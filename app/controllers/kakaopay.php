<?php
/* ============================================================================== */
/* =   PAGE : 카카오 결제 연동 PAGE													= */
/* = -------------------------------------------------------------------------- = */
/* = Copyright (c)  2017.12   GABIA C&S lwh.   All Rights Reserved.				= */
/* ============================================================================== */

/* ============================================================================== */
/* = * 수정 이력																	= */
/* = -------------------------------------------------------------------------- = */
/* = 최초작성 2017-12-06 lwh														= */
/* ============================================================================== */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class kakaopay extends front_base {

	protected $pg_param;		// 넘겨받은 pg 변수 array

	public function __construct() {
		parent::__construct();
		$this->load->helper('order');
		$this->load->helper('shipping');

		$this->load->model('cartmodel');
		$this->load->model('ordermodel');
		$this->load->model('membermodel');
		$this->load->model('usedmodel');
		$this->load->model('couponmodel');
		$this->load->model('goodsmodel');
		$this->load->model('promotionmodel');
		$this->load->model('paymentlog');
		$this->load->library('added_payment');
		$this->load->library('kakaopaylib');
		$this->load->model('reDepositmodel');
	}

	// 결제 인증요청 페이지 - STEP1
	public function request(){
		session_start();

		//app/order.php function pay에서 전달 해준 데이터
		$this->pg_param = json_decode(base64_decode($_POST["jsonParam"]),true);

		$pg_param					= $this->pg_param;
		$orders						= $this->ordermodel->get_order($pg_param['order_seq']);

		// 1-1. Payment 변수 설정
		$body_data['partner_user_id']	= ($orders['member_seq']) ? $orders['member_seq'] : 'nomember';													// 가맹점 회원 id
		$body_data['partner_order_id']	= $orders['order_seq'];		// 가맹점 주문번호
		$body_data['item_name']			= $pg_param['goods_name'];	// 상품명
		$body_data['quantity']			= $orders['total_ea'];		// 상품 수량
		$body_data['total_amount']		= floor($orders['settleprice']);// 상품 총액
		$body_data['tax_free_amount']	= floor($orders['freeprice']);	// 상품 비과세 금액
		if(isset($pg_param['comm_vat_mny'])){
			$body_data['vat_amount']		= floor($pg_param['comm_vat_mny']);									// 상품 부과세 금액
		}
		if(count($this->kakaopaylib->cfgPg['payment_opt']) == 1){
			$body_data['payment_method_type']= $this->kakaopaylib->cfgPg['payment_opt'][0];// 결제 수단 제한
		}
		if($this->kakaopaylib->cfgPg['interestTerms'] != 'auto'){
			$body_data['install_month']	= (int) $this->kakaopaylib->cfgPg['interestTerms']; // 카드할부개월수 0~12
		}
		// 카카오 페이 버전 추가 :: 2018-05-02 lwh
		$body_data['chk_version']		= '1.1';

		// 1-3. API 통신
		$read_data = $this->kakaopaylib->read_api('ready', $body_data);
		$respons	= $read_data['result'];

		// 2. 리턴값 수신 -> 결과 추출
		if($read_data['httpCode'] == '200'){
			if( $this->_is_mobile_agent)	$agent = "mobile";
			else							$agent = "pc";

			// 2-1. 세션 생성
			$pg_map['order_seq']	= $orders['order_seq'];
			$pg_map['tid']			= $respons['tid'];
			$_SESSION['KAKAOPAY_PG']= $pg_map;

			$respons['next_redirect_url']	= $respons['next_redirect_'.$agent.'_url'];
			$respons['next_redirect_pc_url']; // pc 결제페이지 url
			$respons['next_redirect_mobile_url']; // mobile 결제페이지 url
			$respons['created_at']; // 결제 인증요청 시간
		}else{
			// 결제요청 실패
			$alertMsg = getAlert('os121');
			if($respons['code'])	$alertMsg .= ':' . $respons['code'];
			if($respons['msg'])		$alertMsg .= '\n['.$respons['msg'].']';
			echo '<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>';
			echo '<script type="text/javascript">alert("'.$alertMsg.'");'.$this->pg_cancel_script().'</script>';
			exit;
		}

		$this->template->assign('agent',$agent);
		$this->template->assign('param',$respons);
		$this->template->template_dir = BASEPATH."../order";
		$this->template->compile_dir = BASEPATH."../_compile/";
		$this->template->define(array('tpl'=>'_kakaopayment.html'));
		$this->template->print_('tpl');
	}

	// 결제 인증 및 결제 요청 - STEP2
	public function auth(){
		session_start();

		$error = false;
		$aGetParams = $this->input->get();

		$platForm = 'P';
		$pageUrl = $this->uri->segment(2);
		if ($this->_is_mobile_agent) {
			$platForm = 'M';
		}

		try {
			/*
			request 에서 세션에 저장했던 파라미터 값이 유효한지 체크
			세션 유지 시간(로그인 유지시간)을 적당히 유지 하거나 세션을 사용하지 않는 경우 DB처리 하시기 바랍니다.
			*/
			// 1-1. 전달값 체크
			$param = $_SESSION['KAKAOPAY_PG'];
			if ( ! $param['order_seq'] || ! $aGetParams['pg_token']) {
				throw new Exception('Require param : [order_seq]' . $param['order_seq'] . '[pg_token]' . $aGetParams['pg_token']);
			}

			$this->added_payment->write_log($param['order_seq'], $platForm, 'kakaopay', $pageUrl, 'process0100', $aGetParams); // 파일 로그 저장

			// 결제 시작 마킹
			if ($param['order_seq']) {
				$reDepositSeq = $this->reDepositmodel->insert(
					array(
						'order_seq' => $param['order_seq'],
						'pg' => 'daumkakaopay',
						'params' => json_encode($param),
						'regist_date' => date('Y-m-d H:i:s')
					)
				);
			}

			$orders	= $this->ordermodel->get_order($param['order_seq']);

			// 주문 체크
			if ( ! $orders['order_seq']) {
				throw new Exception('Require order : [order_seq]' . $orders['order_seq']);
			}

			// 주문 상태 검증
			if (preg_match('/virtual/', $orders['payment'])){
				if ($orders['step'] >= '15' && $orders['step'] <= '75') {
					throw new Exception('Wrong order status : [step]' . $orders['step'] . '[payment]' . $orders['payment']);
				}
			} else {
				if ($orders['step'] >= '25' && $orders['step'] <= '75') {
					throw new Exception('Wrong order status : [step]' . $orders['step'] . '[payment]' . $orders['payment']);
				}
			}

			// 1-2. 전달 정보 설정
			$body_data['tid']				= $param['tid'];		// 결제고유코드
			$body_data['partner_order_id']	= $orders['order_seq'];	// 가맹점 주문번호
			$body_data['partner_user_id']	= ($orders['member_seq']) ? $orders['member_seq'] : 'nomember'; // 가맹점 회원 id
			$body_data['pg_token']			= $aGetParams['pg_token']; // PG 인증값
			$body_data['total_amount']		= floor($orders['settleprice']); // 결제 금액

			$read_data = $this->kakaopaylib->read_api('approve', $body_data);
			$respons	= $read_data['result'];

			// 2-1. 리턴값 수신
			if ($read_data['httpCode'] == '200') {
				$resultCode		= $respons['aid'] . '||' . $respons['code']; // 결과 코드
				$tid			= $respons['tid'];	// 카카오페이 거래고유번호
				$amt			= $respons['amount']['total']; // 결제 승인 요청 금액
				$cardCode		= $respons['card_info']['purchase_corp_code']; // 카드사 코드
				$cardName		= $respons['card_info']['purchase_corp']; // 결제카드사명
				$enc			= mb_detect_encoding($cardName);
				if($enc != 'UTF-8'){
					$cardName		= iconv($enc, "UTF-8", $cardName);
				}
				$approved_id	= $respons['card_info']['approved_id']; // 카드사 승인번호
				$approved_at	= $respons['approved_at']; // 결제승인시각
				$cardQuota		= $respons['card_info']['install_month']; // 할부개월수
			} else if($respons['code'] != "-702") {
				/* = ----------------------------------------------------------------- = */
				/* =   결제 실패 DB 업데이트 로직											   = */
				/* = ----------------------------------------------------------------- = */
				$resultCode		= $respons['aid'] . '||' . $respons['code']; // 결과 코드

				// 결제요청 실패
				if($respons['msg']){
					$failMsg = $respons['extras']['method_result_message'] . ' (' . $respons['msg'] . ')';
				}

				$this->ordermodel->set_step($orders['order_seq'], '99');
				$log_title =  '결제실패[' . $respons['code'] . ']';
				$log = "카카오페이 결제 실패" . chr(10) . "[" . $respons['code'] ." : " . $failMsg . "]";
				$this->ordermodel->set_log($orders['order_seq'], 'pay', $orders['order_user_name'], $log_title, $log);
				$kakaopay_cancel_flag = 'Y';
			}

			// 3. 결제 승인처리
			// -702 : 이미 결제 완료된 TID로 다시 결제승인 API를 호출한 경우 중복요청이므로receive 는 한번만 실행되도록 처리
			// -785 : 초기 값 없이 요청만 중복으로 왔기 때문에 결제실패처리함 .. 추후 결제성공 유무 판단하여 처리예정
			if ($kakaopay_cancel_flag != 'Y' && $respons['code'] != "-702") {
				$this->receive($respons, $orders);
			}
			$this->added_payment->write_log($orders['order_seq'], $platForm, 'kakaopay', $pageUrl, 'process0200', $respons); // 파일 로그 저장
		} catch (Exception $e) {
			$this->added_payment->write_log($orders['order_seq'], $platForm, 'kakaopay', $pageUrl, 'process0300', array('errorMsg' => $e->getMessage())); // 파일 로그 저장
			$error = true;
		}

		// 결제 종료 마킹
		if ($reDepositSeq) {
			$this->reDepositmodel->del(array('re_deposit_seq' => $reDepositSeq));
		}

		if ($error) {
			pageReload(getAlert('os217'), 'parent');
			exit;
		}

		// 로그 저장
		$this->added_payment->set_pg_log(
			array(
				'pg' => 'kakaopay',
				'order_seq' => $orders['order_seq'],
				'tno' => $tid,
				'amount' => $amt,
				'app_time' => date('YmdHis', strtotime($approved_at)),
				'app_no' => $approved_id,
				'card_cd' => $cardCode,
				'card_name' => $cardName,
				'quota' => $cardQuota,
				'escw_yn' => 'N',
				'biller' => 'kakao',
				'payment_cd' => $respons['payment_method_type'],
				'res_cd' => $resultCode,
				'res_msg' => $failMsg
			)
		);

		if ($kakaopay_cancel_flag == 'Y') { // 카카오페이 결제 실패
			echo '<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>';
			openDialogAlert(getAlert('os121') . "<br /><font color=red>{$resultCode} : {$_kakao_result_code[$resultCode]}({$resultMsg})</font>", 400, 160, 'parent', $this->pg_cancel_script());
		} else {
			pageRedirect('../order/complete?no=' . $orders['order_seq'], '', 'parent');
		}
	}

	// 최종 결제승인처리 (퍼스트몰 로직) - STEP3
	public function receive($respons, $orders){
		if(!$orders['order_seq']){
			// 주문서 주문번호 오류시 처리...
		}

		if($respons['payment_method_type']){
			$payment_method = 'card';
			/* // 추후 구분예정
			if(strtolower($respons['payment_method_type']) != 'card')
				$payment_method = 'kakaomoney';
			*/

			$query = "update fm_order set payment=?, pg='kakaopay' where order_seq=?";
			$this->db->query($query,array($payment_method,$orders['order_seq']));
		}

		// $tid 와 $authCode 선언
		$tid			= $respons['tid'];	// 카카오페이 거래고유번호
		$authCode		= $respons['card_info']['approved_id']; // 카드사 승인번호

		// 주문 상품 재고 체크
		$runout = false;
		$result = $this->ordermodel->get_item_option($orders['order_seq']);
		$data_item_option = $result;
		$result_option = $result;
		$result = $this->ordermodel->get_item_suboption($orders['order_seq']);
		$result_suboption = $result;
		$data_shipping	= $this->ordermodel->get_order_shipping($orders['order_seq']);

		// 회원 마일리지 차감
		if( $orders['emoney']>0 && $orders['member_seq'] && $orders['emoney_use']=='none')
		{
			$params = array(
				'gb'		=> 'minus',
				'type'		=> 'order',
				'emoney'	=> $orders['emoney'],
				'ordno'		=> $orders['order_seq'],
				'memo'		=> "[차감]주문 ({$orders['order_seq']})에 의한 마일리지 차감",
				'memo_lang'	=> $this->membermodel->make_json_for_getAlert("mp260",$orders['order_seq']), // [차감]주문 (%s)에 의한 마일리지 차감
			);
			$this->membermodel->emoney_insert($params, $orders['member_seq']);
			$this->ordermodel->set_emoney_use($orders['order_seq'],'use');
		}

		// 회원 예치금 차감
		if( $orders['cash']>0 && $orders['member_seq'] && $orders['cash_use']=='none')
		{
			$params = array(
				'gb'		=> 'minus',
				'type'		=> 'order',
				'cash'		=> $orders['cash'],
				'ordno'		=> $orders['order_seq'],
				'memo'		=> "[차감]주문 ({$orders['order_seq']})에 의한 예치금 차감",
				'memo_lang'	=> $this->membermodel->make_json_for_getAlert("mp261",$orders['order_seq']), // [차감]주문 (%s)에 의한 예치금 차감
			);
			$this->membermodel->cash_insert($params, $orders['member_seq']);
			$this->ordermodel->set_cash_use($orders['order_seq'],'use');
		}

		//상품쿠폰사용
		if($data_item_option) foreach($data_item_option as $item_option){
			if($item_option['download_seq']){
				$this->couponmodel->set_download_use_status($item_option['download_seq'],'used');
			}
		}
		//배송비쿠폰사용 @2015-06-22 pjm
		if($data_shipping) foreach($data_shipping as $shipping){
			if($shipping['shipping_coupon_down_seq']) $this->couponmodel->set_download_use_status($shipping['shipping_coupon_down_seq'],'used');
		}
		//배송비쿠폰사용(사용안함)
		if($orders['download_seq']){
			$this->couponmodel->set_download_use_status($orders['download_seq'],'used');
		}

		//주문서쿠폰 사용 처리 by hed
		if($orders['ordersheet_seq']) $this->couponmodel->set_download_use_status($orders['ordersheet_seq'],'used');

		//프로모션코드 상품/배송비 할인 사용처리
		$this->promotionmodel->setPromotionpayment($orders);

		// 장바구니 비우기
		if( $orders['mode'] ){
			$this->cartmodel->delete_mode($orders['mode']);
		}

		// 주문 상태 업데이트
		$data = array(
			'pg_transaction_number' => $tid,		// 카카오페이 거래고유번호
			'pg_approval_number'	=> $authCode	// 승인번호
		);
		$this->coupon_reciver_sms = array();
		$this->coupon_order_sms = array();
		$order_count = 0;

		$this->ordermodel->set_step($orders['order_seq'],25,$data);

		// DB 로그 기록
		$add_log = "";
		if($orders['orign_order_seq'])	$add_log = "[재주문]";
		if($orders['admin_order'])		$add_log = "[관리자주문]";
		if($orders['person_seq'])		$add_log = "[개인결제]";

		$log_title =  $add_log."결제확인"."(카카오페이)";

		$log = "카카오페이 결제 확인". chr(10)."[" . $resultCode . ":" . $_kakao_result_code[$resultCode] ."]" . chr(10). implode(chr(10),$data);
		$this->ordermodel->set_log($orders['order_seq'],'pay',$orders['order_user_name'],$log_title,$log);

		// 출고량 업데이트를 위한 변수선언
		$r_reservation_goods_seq = array();

		// 해당 주문 상품의 출고예약량 업데이트
		if($result_option){
			foreach($result_option as $data_option){
				// 출고량 업데이트를 위한 변수정의
				if(!in_array($data_option['goods_seq'],$r_reservation_goods_seq)){
					$r_reservation_goods_seq[] = $data_option['goods_seq'];
				}
			}
		}

		if($result_suboption){
			foreach($result_suboption as $data_suboption){
				// 출고량 업데이트를 위한 변수정의
				if(!in_array($data_suboption['goods_seq'],$r_reservation_goods_seq)){
					$r_reservation_goods_seq[] = $data_suboption['goods_seq'];
				}
			}
		}
		// 출고예약량 업데이트
		foreach($r_reservation_goods_seq as $goods_seq){
			$this->goodsmodel->modify_reservation_real($goods_seq);
		}

		//티켓상품 자동 출고처리구문 순차진행을 위해 분리함 @2017-08-16
		ticket_payexport_ck($orders['order_seq']);

		//받는 사람 티켓상품 SMS 데이터
		if(count($this->coupon_reciver_sms['order_cellphone']) > 0){
			$order_count = 0;
			foreach($this->coupon_reciver_sms['order_cellphone'] as $key=>$value){
				$coupon_arr_params[$order_count]		= $this->coupon_reciver_sms['params'][$key];
				$coupon_order_no[$order_count]			= $this->coupon_reciver_sms['order_no'][$key];
				$coupon_order_cellphones[$order_count]	= $this->coupon_reciver_sms['order_cellphone'][$key];
				$order_count					=$order_count+1;
			}

			$commonSmsData['coupon_released']['phone']		= $coupon_order_cellphones;;
			$commonSmsData['coupon_released']['params']		= $coupon_arr_params;
			$commonSmsData['coupon_released']['order_no']	= $coupon_order_no;

		}

		//주문자 티켓상품 SMS 데이터
		if(count($this->coupon_order_sms['order_cellphone']) > 0){
			$order_count = 0;
			foreach($this->coupon_order_sms['order_cellphone'] as $key=>$value){
				$reciver_arr_params[$order_count]		= $this->coupon_order_sms['params'][$key];
				$reciver_order_no[$order_count]			= $this->coupon_order_sms['order_no'][$key];
				$reciver_order_cellphones[$order_count] = $this->coupon_order_sms['order_cellphone'][$key];
				$order_count					=$order_count+1;
			}

			$commonSmsData['coupon_released2']['phone']		= $reciver_order_cellphones;;
			$commonSmsData['coupon_released2']['params']	= $reciver_arr_params;
			$commonSmsData['coupon_released2']['order_no']	= $reciver_order_no;

		}

		if(count($commonSmsData) > 0){
			commonSendSMS($commonSmsData);
		}
	}

	// 결제 취소 시 리턴
	public function cancel(){
		// 결제를 취소하셨습니다.
		echo '<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>';
		echo '<script type="text/javascript">alert("'.getAlert('os178').'");'.$this->pg_cancel_script().'</script>';
	}

	// 결제 실패 시 리턴
	public function payfail(){
		// 카카오페이 결제 실패
		echo '<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>';
		echo '<script type="text/javascript">alert("'.getAlert('os121').'");'.$this->pg_cancel_script().'</script>';
	}

	public function pg_cancel_script(){
		$js_echo = '$("#wrap",parent.document).show();$("div.pay_layer",parent.document).eq(0).show();$("div.pay_layer",parent.document).eq(1).hide();$("#layer_pay",parent.document).hide();$("#kakaopay_layer",parent.document).css("display","none");$("#lay_mask",parent.document).remove();';

		return $js_echo;
	}

	// 매출전표 추출
	public function pg_confirm(){

		// 초기화 변수 선언
		$cid = $tid = $order_seq = $p_userid = null;
		$order_seq	= ($_GET['no']) ? $_GET['no'] : $_POST['order_seq'];

		// 구버전 구분값 및 TID 추출
		$this->db->where('order_seq',$order_seq);
		$query		= $this->db->get('fm_order_pg_log');
		$result		= $query->result_array();
		$tid		= $result[0]['tno'];
		$biller		= $result[0]['biller'];

		if ($this->config_system['not_use_daumkakaopay'] == 'n' && $biller == 'kakao' && $order_seq) {
			// 주문정보 추출
			$orders		= $this->ordermodel->get_order($order_seq);
			$p_userid	= ($orders['member_seq']) ? $orders['member_seq'] : 'nomember';

			// CID 추출
			$cid		= $this->kakaopaylib->cfgPg['cid'];

			// HASH 값 추출 (고객번호 + 결제고유번호 + 주문번호 + 주문아이디)
			$hash_str	= $cid . $tid . $order_seq . $p_userid;

			$hash		= hash('sha256', $hash_str);
			if( $this->_is_mobile_agent)	$agent = "m";
			else							$agent = "p";

			$call_url	= $this->kakaopaylib->detail_url['confirm'];
			$call_url	= str_replace('[:agent:]', $agent, $call_url);
			$call_url	= str_replace('[:tid:]', $tid, $call_url);
			$call_url	= str_replace('[:hash:]', $hash, $call_url);

			if($cid == 'TC0ONETIME'){ // TEST 용 CID 일때..
				$confirm_url= 'https://mockup-pg-web.kakao.com'.$call_url;
			}else{
				$confirm_url= $this->kakaopaylib->kakao_pg.$call_url;
			}
		}else{
			// 구버전 카카오페이 매출증빙 url
			$confirm_url = "https://mms.cnspay.co.kr/trans/retrieveIssueLoader.do?TID=".$_GET['tno']."&type=0";
		}

		if($_GET['return_type'] == 'json'){
			echo json_encode($confirm_url);
		}else{
			echo $confirm_url;
		}
	}
}