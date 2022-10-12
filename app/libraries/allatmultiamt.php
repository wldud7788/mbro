<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 올앳 복합과세 계산
 * 2020-07-20
 */
class AllatMultiAmt
{
    public $CI;
    private $data_refund;
    private $all_order_seq;
    private $refund_goods_price;
    private $delivery_price_tmp;
    
    /**
     * 생성자
     */
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('ordermodel');
        $this->CI->load->model('refundmodel');
        $this->CI->load->helper('common');
    }
    
    /**
     * 환불 코드를 인자로 받아 환불 데이터를 멤버변수에 대입한다.
     * @param string $refund_code
     * @throws Exception
     */
    public function setRefundData($refund_code) {
        $this->refund_code = $refund_code;
        $this->data_refund = $this->CI->refundmodel->get_refund($refund_code);
        if(!$this->data_refund) {
            throw new Exception("잘못된 환불코드입니다.");
        }
    }
    
    /**
     * 환불 데이터를 반환한다.
     * @return array
     */
    public function getDataRefund()
    {
        return $this->data_refund;
    }
    
    /**
     * 복합과세/비과세 여부
     * 
     * free_tax가 y면 비과세/복합과세
     */
    public function setFreeTax()
    {
        $data_order_item	= $this->CI->ordermodel->get_item($this->data_refund['order_seq']);
        
        $tmp_tax	= array();
        $free_tax	= "n";
        if($data_order_item){
            foreach($data_order_item as $item){
                $tmp_tax[]		= $item['tax'];
                if($item['tax'] == "exempt") $free_tax = "y";
            }
        }
        
        if( !in_array("tax",$tmp_tax) && $free_tax == "n" ) $free_tax = "y";
        $this->data_refund['free_tax'] = $free_tax;
    }
    
    /**
     * 과세/비과세 금액 나누기
     */
    public function setTaxPrice($refund_delivery_price_tmp, $refund_goods_price)
    {
        $this->data_refund['tax_price']	= 0;
        $this->data_refund['free_price'] = 0;
        $data_refund_item 	= $this->CI->refundmodel->get_refund_item($this->refund_code);
        if($data_refund_item){
            foreach($data_refund_item as $item){
                $refund_seq		= $item['refund_item_seq'];
                $refund_deliv	+= $refund_delivery_price_tmp[$refund_seq];
                if($item['tax'] == "tax"){ // 과세
                    $this->data_refund['tax_price'] += $refund_goods_price[$refund_seq];
                }elseif($item['tax'] == "exempt"){ // 비과세
                    $this->data_refund['free_price'] += $refund_goods_price[$refund_seq];
                }
            }
        }
        
        $this->refund_goods_price		= array_sum($refund_goods_price);
        $this->refund_delivery_price_tmp	= array_sum($refund_delivery_price_tmp);
    }
    
    /**
     * 해당 환불건의 전체 주문 번호를 가져온다.
     * @param int $order_seq
     * @param int $top_orign_order_seq
     */
    public function setAllOrderSeq($top_orign_order_seq)
    {
        $order_seq = $this->data_refund['order_seq'];
        $all_order_seq = array($order_seq);
        
        if($top_orign_order_seq){
            $top_orign_order_seq	= $top_orign_order_seq;
            $all_order_seq[]		= $top_orign_order_seq;
        }else{
            $top_orign_order_seq = $order_seq;
        }
        $aOrderSeqs = $this->CI->ordermodel->get_order_seqs_by_top_orign_order_seq($order_seq);
        if( $aOrderSeqs ){
            foreach($aOrderSeqs as $sTmpOrderSeq){
                if( !in_array($sTmpOrderSeq, $all_order_seq) && $sTmpOrderSeq ){
                    $all_order_seq[] = $sTmpOrderSeq;
                }
            }
        }
        $this->all_order_seq = array_unique($all_order_seq);
    }
    
    /**
     * 과세/부가세 계산
     * @throws Exception
     */
    public function setCommMny()
    {
        // 전체 과세금액 추출
        $refund_type = "complete";
        $order_seq = $this->data_refund['order_seq'];
        # 주문 데이터를 토대로 과세상품액, 비과세액, 과세 배송비금액 구해오기
        $all_order_list		= $this->CI->ordermodel->get_order($order_seq);
        $tax_invoice_type	= ($all_order_list['typereceipt'] == 1) ? true : false;		//세금 계산서 신청여부
        // 환불가능 과세금액 계산
        $order_tax_prices	= $this->CI->ordermodel->get_order_prices_for_tax($order_seq,$all_order_list,$tax_invoice_type,$refund_type);
        
        $this->CI->load->model('salesmodel');
        $data_tax = $this->CI->salesmodel->tax_calulate(
            $order_tax_prices["tax"],
            $order_tax_prices["exempt"],
            $order_tax_prices["shipping_cost"],
            $order_tax_prices["sale"],
            $order_tax_prices["tax_sale"],'SETTLE');
        
        $supply			= get_cutting_price($data_tax['supply']);
        $surtax			= get_cutting_price($data_tax['surtax']);
        $taxprice		= get_cutting_price($data_tax['supply']) + get_cutting_price($data_tax['surtax']);
        
        // 남은 환불가능 과세금액과 환불예정 과세금액이 동일할 경우
        // 전체 과세금액으로부터 과세,부과세를 역산한다.
        if($this->data_refund['tax_price']==$taxprice && $taxprice > 0){
            // 전체 공급가액 계산
            $tot_tax_prices	= $this->CI->ordermodel->get_order_prices_for_tax($order_seq,$all_order_list,$tax_invoice_type,"all_order");
            $tot_data_tax = $this->CI->salesmodel->tax_calulate(
                $tot_tax_prices["tax"],
                $tot_tax_prices["exempt"],
                $tot_tax_prices["shipping_cost"],
                $tot_tax_prices["sale"],
                $tot_tax_prices["tax_sale"],'SETTLE');
            $tot_supply		= get_cutting_price($tot_data_tax['supply']);
            $tot_surtax		= get_cutting_price($tot_data_tax['surtax']);
            
            // 기존환불 과세금액 계산
            $re_tax_refund_data_list = $this->CI->refundmodel->get_refund_for_order($this->data_refund['order_seq']);
            $re_tax_sum_tax_price = 0;
            $re_tax_sum_comm_tax_mny = 0;
            $re_tax_sum_comm_vat_mny = 0;
            $re_tax_sum_free_price = 0;
            foreach($re_tax_refund_data_list as $re_tax_refund_data){
                if($re_tax_refund_data['status']=='complete'){
                    $re_tax_sum_tax_price += $re_tax_refund_data['tax_price'];
                    $re_tax_sum_comm_tax_mny += $re_tax_refund_data['comm_tax_mny'];
                    $re_tax_sum_comm_vat_mny += $re_tax_refund_data['comm_vat_mny'];
                    $re_tax_sum_free_price += $re_tax_refund_data['freeprice'];
                }
            }
            
            $refund_comp = $this->CI->refundmodel->get_refund_complete_price($this->all_order_seq);
            $refund_complete_pg_price = $refund_comp['refund_goods_price'] + $refund_comp['refund_delivery_price'];
            
            // 검산 : 기 환불금액
            if($re_tax_sum_tax_price+$re_tax_sum_free_price != ($refund_complete_pg_price)){
                throw new Exception('기환불금액 오류<br/> 기환불금액('.get_currency_price($refund_complete_pg_price,3).')이 과세금액('.get_currency_price($re_tax_sum_tax_price,3).')와 면세금액('.get_currency_price($re_tax_sum_free_price,3).')의 합과 다릅니다.');
            }
            // 검산 : 기환불 과세금액
            if($re_tax_sum_tax_price != ($re_tax_sum_comm_tax_mny+$re_tax_sum_comm_vat_mny)){
                throw new Exception('기환불금액 오류<br/> 과세금액('.get_currency_price($re_tax_sum_tax_price,3).')이 공급가액('.get_currency_price($re_tax_sum_comm_tax_mny,3).')와 부가세('.get_currency_price($re_tax_sum_comm_vat_mny,3).')의 합과 다릅니다.');
            }
            
            $re_tax_comm_tax_mny = $tot_supply - $re_tax_sum_comm_tax_mny;
            $re_tax_comm_vat_mny = $taxprice - $re_tax_comm_tax_mny;
            
            // 검산 : 환불요청 금액 //  $aPostParams['refund_price'] 기존 데이터에는 마일리지가 포함되어 있으므로 순수 환불 금액으로 재계산 by hed
            $real_refund_price = $this->refund_goods_price + $this->refund_delivery_price_tmp;
            if($real_refund_price != ($re_tax_comm_tax_mny+$re_tax_comm_vat_mny+$this->data_refund['free_price'])){
                throw new Exception('환불요청 금액 오류<br/> 환불요청 금액('.get_currency_price($real_refund_price,3).')이 공급가액('.get_currency_price($re_tax_comm_tax_mny,3).')와 부가세('.get_currency_price($re_tax_comm_vat_mny,3).')와 비과세('.get_currency_price($this->data_refund['free_price'],3).')의 합과 다릅니다.');
            }
            
            $this->data_refund['comm_tax_mny'] = $re_tax_comm_tax_mny;
            $this->data_refund['comm_vat_mny'] = $re_tax_comm_vat_mny;
        }
    }
}