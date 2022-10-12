<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * V-commerce 편성표와 매칭된 상품 정보를 합쳐서 반환하기 위해 만든 라이브러리
 * @author Sunha Ryu
 * 2019-11-22
 */
class goods
{
    private $ci;
    private $date;
    private $status;
    private $bsSeq;
    private $sch;
    private $bsSeqList;
    private $goods;
    private $goodsSeqList;
    private $shippingGroupSeqList;
    private $shippingGroup;
    private $link;
    
    private $schFields = array('bs_seq', 'img', 'title', 'contents', 'status', 'start_time', 'end_time', 'nation_key', 'regist_date');
    private $goodsFields = array('goods_seq', 'bs_seq', 'goods_name', 'g_default_price', 'shipping_group_seq', 'discount_rate');
    
    /**
     * Class Constructor.
     * 
     * @param object $object
     * @return void
     */
    public function __construct()
    {
        $this->ci = &get_instance();
        
        $this->ci->load->helper("basic");
        $this->ci->load->helper("common");
        $this->ci->load->model("adminenvmodel");
        $this->ci->load->model("goodsmodel");
        $this->ci->load->model('broadcastmodel');
        $this->ci->load->model('shippingmodel');
        
        $this->date = null;
        $this->status = null;
        $this->sch = array();
        $this->bsSeqList = array();
        $this->goods = array();
        $this->goodsSeqList = array();
        $this->shippingGroupSeqList = array();
        $this->shippingGroup = array();
        $this->link = array();
    }
    
    /**
     * 검색할 날짜
     * @param string $date : yyyymmdd
     */
    public function setDate($date) 
    {
        $this->date = $date;
    }
    
    /**
     * 가져올 방송 상태
     * @param array $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * 가져올 방송 편성표
     * @param int $bsSeq
     */
    public function setBsSeq($bsSeq)
    {
        $this->bsSeq = $bsSeq;
    }
    
    /**
     * 편성표와 매칭된 상품정보/옵션정보/상품이미지/상품무료배송여부/브랜드명 데이터를 반환한다.
     * @return array
     */
    public function getData()
    {
        $this->initSch();
        $this->initGoods();
        $this->initGoodsOption();
        $this->initGoodsCurrency();
        $this->initGoodsBrand();
        $this->initGoodsImage();
        $this->initGoodsShipping();
        $tmp = $this->sch;
        $data = array();
        
        // 방송 데이터와 상품 데이터를 연결한다.
        if(count($this->link)>0) {
            foreach($this->link as $bs_seq => $goods_seqs) {
                if(count($goods_seqs)>0) {
                    foreach($goods_seqs as $goods_seq) {
                        if(!is_array($tmp[$bs_seq]['goods_data'])) {
                            $tmp[$bs_seq]['goods_data'] = array();
                        }
                        unset($this->goods[$goods_seq]['bs_seq']);
                        $tmp[$bs_seq]['goods_data'][] = $this->goods[$goods_seq];
                    }
                }
                
            }
        }
        
        // 방송 이미지, 방송 제목이 없을 경우 상품 이름으로 대체한다.
        foreach($tmp as $tmpRow) {
            if(!empty($tmpRow['goods_data'])) {
                $firstGoodsElem = reset($tmpRow['goods_data']);
                if(empty($tmpRow['title']) && !empty($firstGoodsElem['goods_name'])) {
                    $tmpRow['title'] = $firstGoodsElem['goods_name'];
                }
                
                if(empty($tmpRow['img']) && !empty($firstGoodsElem['goods_image'])) {
                    $tmpRow['img'] = $firstGoodsElem['goods_image'];
                }
            }
            $data[] = $tmpRow;
        }
        return $data;
    }
    
    /**
     * 방송 편성표 데이터
     */
    private function initSch()
    {
        $cond = array();
        
        if(!empty($this->date)) {
            $cond['date'] = $this->date;
        }
        
        if(!empty($this->status)) {
            $cond['status'] = $this->status;
        }
        
        // 방송번호가 있으면 다른 조건 모두 무시
        if(!empty($this->bsSeq)) {
            $cond = array(
                'bs_seq' => $this->bsSeq
            );
        }
        
        $sch = $this->ci->broadcastmodel->getSch($cond);
        
        if(count($sch)>0) {
            foreach($sch as $row) {
                $row = filter_keys($row, $this->schFields);
                $this->bsSeqList[] = $row['bs_seq'];
                $this->sch[$row['bs_seq']] = $row;
                // 방송-상품간 seq 연결고리
                $this->link[$row['bs_seq']] = array();
            }
        }
    }
    
    /**
     * 상품 데이터
     */
    private function initGoods()
    {
        $tmp = $this->ci->broadcastmodel->getBroadcastGoods($this->bsSeqList, null, "bg.discount_rate");
        $goodsSeqList = array();
        $goods = array();
        if(count($tmp)>0) {
            foreach($tmp as $row) {
                $row = filter_keys($row, $this->goodsFields);
                // 방송 번호를 키값으로 하여 상품번호를 대입한다.
                $this->link[$row['bs_seq']][$row['goods_seq']] = $row['goods_seq'];
                
                // fm_goods의 default_price를 기준으로 한다.
                $row['default_price'] = $row['g_default_price'];
                unset($row['g_default_price']);
                if($row['discount_rate'] > 0) {
                    $row['discount_price'] = $row['default_price'] * ((100 - $row['discount_rate'])/100);
                } else {
                    $row['discount_price'] = $row['default_price'];
                }
                $row['discount_price'] = (string) $row['discount_price'];
                
                $this->shippingGroupSeqList[$row['shipping_group_seq']] = $row['shipping_group_seq'];
                
                $goodsSeqList[] = $row['goods_seq'];
                $goods[$row['goods_seq']] = $row;
            }
        }
        $this->goods = $goods;
        $this->goodsSeqList = $goodsSeqList;
    }
    
    /**
     * 상품 옵션 데이터
     */
    private function initGoodsOption()
    {
        if(empty($this->goodsSeqList) || count($this->goodsSeqList) < 1) {
            return false;
        }
        
        // 상품의 옵션 데이터를 가져온다.
        $optionData =  $this->ci->goodsmodel->get_goods_option_by_goods_seqs($this->goodsSeqList);
        $tmp = array();
        $data = array();
        
        if(count($optionData)>0) {
            // 상품번호, 옵션타이틀 기준으로 데이터를 가공한다.
            foreach($optionData as $row) {
                if(empty($tmp[$row['goods_seq']])) {
                    $tmp[$row['goods_seq']] = array();
                }
                for($i=1; $i<=5; $i++) {
                    if(!empty($row['option'.$i])) {
                        if(empty($tmp[$row['goods_seq']][$i])) {
                            $tmp[$row['goods_seq']][$i] = array();
                        }
                        $tmp[$row['goods_seq']][$i][$row['option'.$i]] = $row['option'.$i];
                    }
                }
            }
            
            if(count($tmp)) {
                foreach($tmp as $goods_seq => $elem) {
                    if(count($elem)>0) {
                        if(empty($data[$goods_seq])) {
                            $data[$goods_seq] = array();
                        }
                        foreach($elem as $option) {
                            $data[$goods_seq][] = implode($option, ',');
                        }
                    }
                    $data[$goods_seq] = implode($data[$goods_seq], "|");
                }
                
                // 멤버 변수에 대입
                if(count($data) >0) {
                    foreach($data as $goods_seq => $elem) {
                        $this->goods[$goods_seq]['option_data'] = $elem;
                    }
                }
            }
        }
        
    }
    
    /**
     * 상품 브랜드 명
     * 1차브랜드-2차브랜드-3차브랜드 와 같은 식으로 데이터를 가공한다.
     */
    private function initGoodsBrand()
    {
        if(empty($this->goodsSeqList)) {
            return false;
        }
        
        $this->ci->load->model("brandmodel");
        // 브랜드 링크 데이터
        $result = $this->ci->brandmodel->getCategoryCode($this->goodsSeqList);
        
        $tmp = array();
        if(count($result)>0) {
            $codeList = array();
            foreach($result as $row) {
                $codeLength = strlen($row['category_code']);
                if($codeLength>4) {
                    $tmp[$row['goods_seq']] = array();
                    for($i = 4; $i <= $codeLength; $i += 4) {
                        $code = substr($row['category_code'], 0, $i);
                        $codeList[] = $code;
                        $tmp[$row['goods_seq']][] = $code;
                    }
                } else {
                    $tmp[$row['goods_seq']] = $row['category_code'];
                    $codeList[] = $row['category_code'];
                }
            }
            
            // 브랜드 데이터
            $codeInfoTmp = $this->ci->brandmodel->getCodeInfo($codeList, 'category_code, title');
            $codeInfo = array();
            if(count($codeInfoTmp) > 0) {
                foreach($codeInfoTmp as $codeInfoRow) {
                    $codeInfo[$codeInfoRow['category_code']] = $codeInfoRow['title'];
                }
            }
            
            if(count($tmp)>0) {
                foreach($tmp as $goods_seq => $tmpRow) {
                    
                    if(is_array($tmpRow) === true) {
                        $tmpTitle = array();
                        foreach($tmpRow as $tmpCode) {
                            $tmpTitle[] = $codeInfo[$tmpCode];
                        }
                        $title = implode($tmpTitle, "-");
                    } else {
                        $title = $codeInfo[$tmpRow];
                    }
                    $this->goods[$goods_seq]['brand_title'] = $title;
                }
            }
        }
        
    }
    
    /**
     * 상품 이미지 데이터
     */
    private function initGoodsImage()
    {
        if(empty($this->goodsSeqList)) {
            return false;
        }
        
        $goodsImages = $this->ci->goodsmodel->get_goods_images($this->goodsSeqList);
        if(count($goodsImages)>0) {
            foreach($goodsImages as $goods_seq => $goodsImages) {
                $imageRow = reset($goodsImages);
                // 상품상세(기본) 이미지
                $image = $imageRow['view']['image'];
                // url 형식의 이미지는 그대로 유지
                if(!preg_match('/http/', $image)){
                    $image = get_connet_protocol().$_SERVER['HTTP_HOST'].$image;
                }
                $this->goods[$goods_seq]['goods_image'] = $image;
            }
        }
        
        if(preg_match('/http/', $data_goods['image'])){
            $data_goods['image_url'] = $data_goods['image'];
        }else{
            $data_goods['image_url'] = get_connet_protocol().$_SERVER['HTTP_HOST'].$data_goods['image'];
        }
    }
    
    /**
     * 상품 무료배송 여부 데이터
     */
    private function initGoodsShipping()
    {
        if(empty($this->shippingGroupSeqList)) {
            return false;
        }
        
        // 상품의 배송그룹 데이터를 가져와서 멤버변수에 대입한다.
        $shippingData = $this->ci->shippingmodel->get_shipping_group_summary_list($this->shippingGroupSeqList);
        if(count($shippingData)>0) {
            foreach($shippingData as $shippingRow) {
                $this->shippingGroup[$shippingRow['shipping_group_seq']] = $shippingRow;
            }
        }
        
        // 상품 멤버변수에 무료배송 여부를 대입한다.
        if(count($this->goods)>0) {
            foreach($this->goods as $goods_seq => $goodsRow) {
                $this->goods[$goods_seq]['free_shipping_use'] = $this->shippingGroup[$goodsRow['shipping_group_seq']]['free_shipping_use'];
                unset($this->goods[$goods_seq]['shipping_group_seq']);
            }
        }
    }
    
    /**
     * 상품 통화 데이터 -> 다국어 통합시 변경될 예정.
     */
    private function initGoodsCurrency()
    {
        $envRow = $this->ci->broadcastmodel->getEnvData();
        $currency = $envRow['currency'] ? $envRow['currency'] : 'KRW';
        
        if(count($this->goods)>0) {
            foreach($this->goods as $goods_seq => $row) {
                $this->goods[$goods_seq]['currency'] = $currency;
            }
        }
    }
    
}
