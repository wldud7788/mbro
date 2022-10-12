<?php
/*
	[개발용]
	- 설치본 만들때는 제외(삭제)됩니다.
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/common_base".EXT);

class eximbay extends common_base {
	public function __construct() {
		parent::__construct();
		$this->load->helper('order');
		$this->load->helper('shipping');

		$this->load->model('cartmodel');
		$this->load->model('ordermodel');
		$this->load->model('membermodel');
		$this->load->model('couponmodel');
		$this->load->model('goodsmodel');
		$this->load->model('promotionmodel');
		$this->load->model('paymentlog');
	}

	public function request()
	{
		/**
			*Test Card Type : VISA<br/>
			*Test Card No : 4111 1111 1111 1111<br/>
			*Test Expiry Date : 12/20   << 해당년도로 변경해도 결제 가능함
			*Test CVV : 123<br/>
		 */

		$order_seq			= $this->input->post('param1');
		$payment_config	= config_load("eximbay");
		$orders			= $this->ordermodel->get_order($order_seq);

		// 주문서와 가격 검증
		if(
			$orders['payment_price'] != $this->input->post('amt') || 
			!$orders['order_seq'] || 
			$orders['step'] != 0
		){
			pageClose('접근이 올바르지 않습니다.');
			exit;
		}
		
		$secretKey	= $payment_config['eximbay_secretkey'];//가맹점 secretkey
		$mid		= $payment_config['eximbay_mid'];//가맹점 아이디

		//가맹점에서 설정 가능한 고유 거래 아이디. 거래별 고유 값으로 설정하는 것을 권장합니다.
		$ref	= $this->config_system['shopSno'].$order_seq;
		
		if( in_array($mid,array('1849705C64','3138433A69')) ){
			$reqURL = "https://secureapi.test.eximbay.com/Gateway/BasicProcessor.krp";//EXIMBAY TEST 서버 요청 URL입니다.
		}else{
			$reqURL = "https://secureapi.eximbay.com/Gateway/BasicProcessor.krp";
		}

		$cur	= $this->input->post('cur');
		$amt	= $this->input->post('amt');
		$arr 	= $this->input->post();

		$arr['ostype'] = "P";
		if($this->_is_mobile_agent) {
			$arr['ostype'] = "M";
		}

		//fgkey 검증키 생성
		$arr['ver'] = '230';
		$arr['mid'] = $mid;
		$arr['ref'] = $ref;
		$arr['cur'] = $cur;
		$arr['amt'] = $amt;
		$size = count($arr);
		ksort($arr);
		$counter = 0;
		foreach ($arr as $key => $val) {
			if ($counter == $size-1){
				$sortingParams .= $key."=" .$val;
			}else{
				$sortingParams .= $key."=" .$val."&";
			}
			++$counter;
		}
		$linkBuf = $secretKey. "?".$sortingParams;
		$fgkey = strtoupper(hash("sha256", $linkBuf));

		echo("<form name=\"regForm\" method=\"post\" action=\"".$reqURL."\">");
		echo("<input type=\"hidden\" name=\"mid\" value=\"".$mid."\" /><!--필수 값-->");
		echo("<input type=\"hidden\" name=\"ref\" value=\"".$ref."\" /><!--필수 값-->");
		echo("<input type=\"hidden\" name=\"fgkey\" value=\"".$fgkey."\" /><!--필수 값-->");
		foreach($arr as $Key=>$value) {
			echo("<input type=\"hidden\" name=\"".$Key."\" value=\"".$value."\">");
		}
		echo("</form>");
		echo("<script>document.regForm.submit();</script>");
	}
	public function status()
	{
		$pParams = $this->input->post();
		$order_seq			= $pParams['param1'];
		$payment_config	= config_load("eximbay");
		$orders			= $this->ordermodel->get_order($order_seq);

		if ($orders['step'] >= '25' && $orders['step'] <= '75') {
			throw new Exception('Wrong order status : [step]' . $orders['step']);
		}
		
		// 주문서와 가격 검증
		if(
			$orders['payment_price'] != $pParams['amt'] || !$orders['order_seq'] 
		){			
			$log_title	= '결제실패';
			$log			= "EXIMBAY 결제 실패". chr(10)."[금액불일치]";
			$this->ordermodel->set_log($orders['order_seq'], 'pay', '시스템', $log_title, $log);
			pageClose('접근이 올바르지 않습니다.');
			exit;
		}

		/**
		아래 설정 된 값은 테스트용 secretKey입니다.
		테스트로만 진행하시고 발급 받으신 값으로 변경하셔야 됩니다.
		*/
		$secretKey = $payment_config['eximbay_secretkey'];//가맹점 secretkey

		//기본 응답 파라미터
		$ver			= $pParams['ver'];//연동 버전
		$mid			= $pParams['mid'];//가맹점 아이디
		$txntype	= $pParams['txntype'];//거래 타입
		$ref			= $pParams['ref'];//가맹점 지정에서 지정한 거래 아이디
		$cur			= $pParams['cur'];//통화
		$amt			= $pParams['amt'];//결제 금액
		$shop		= $pParams['shop'];//가맹점명
		$buyer		= $pParams['buyer'];//결제자명
		$tel			= $pParams['tel'];//결제자 전화번호
		$email		= $pParams['email'];//결제자 이메일
		$lang		= $pParams['lang'];//결제정보 언어 타입

		$transid		= $pParams['transid'];//Eximbay 내부 거래 아이디
		$rescode		= $pParams['rescode'];//0000 : 정상
		$resmsg		= $pParams['resmsg'];//결제 결과 메세지
		$authcode	= $pParams['authcode'];//승인번호, PayPal, Alipay, Tenpay등 일부 결제수단은 승인번호가 없습니다.
		$cardco		= $pParams['cardco'];//카드 타입
		$resdt			= $pParams['resdt'];//결제 시간 정보 YYYYMMDDHHSS
		$paymethod	= $pParams['paymethod'];//결제수단 코드 (연동문서 참고)

		$accesscountry	= $pParams['accesscountry'];//결제자 접속 국가
		$allowedpvoid		= $pParams['allowedpvoid'];//Y: 부분취소 가능. N: 부분취소 불가
		$fgkey					= $pParams['fgkey'];//검증키, rescode=0000인 경우에만 값 세팅 됨
		$payto					= $pParams['payto'];//청구 가맹점명

		//주문 상품 파라미터
		$item_0_product	= $pParams['item_0_product'];
		$item_0_quantity	= $pParams['item_0_quantity'];
		$item_0_unitPrice	= $pParams['item_0_unitPrice'];

		//추가 항목 파라미터
		$surcharge_0_name		= $pParams['surcharge_0_name'];
		$surcharge_0_quantity		= $pParams['surcharge_0_quantity'];
		$surcharge_0_unitPrice	= $pParams['surcharge_0_unitPrice'];

		//가맹점 지정 파라미터
		$param1 = $pParams['param1'];
		$param2 = $pParams['param2'];
		$param3 = $pParams['param3'];

		//카드 결제 정보 파라미터
		$cardholder	= $pParams['cardholder'];//결제자가 입력한 카드 명의자 영문명
		$cardno1		= $pParams['cardno1'];
		$cardno4		= $pParams['cardno4'];

		//DCC 파라미터
		$foreigncur	= $pParams['foreigncur'];//고객 선택 통화
		$foreignamt	= $pParams['foreignamt'];//고객 선택 통화 금액
		$convrate		= $pParams['convrate'];//적용 환율
		$rateid			= $pParams['rateid'];//적용 환율 아이디

		//배송지 파라미터
		$shipTo_city						= $pParams['shipTo_city'];
		$shipTo_country				= $pParams['shipTo_country'];
		$shipTo_firstName			= $pParams['shipTo_firstName'];
		$shipTo_lastName			= $pParams['shipTo_lastName'];
		$shipTo_phoneNumber	= $pParams['shipTo_phoneNumber'];
		$shipTo_postalCode		= $pParams['shipTo_postalCode'];
		$shipTo_state					= $pParams['shipTo_state'];
		$shipTo_street1				= $pParams['shipTo_street1'];

		//CyberSource의 DM을 사용 하는 경우 받는 파라미터
		$dm_decision	= $pParams['dm_decision'];
		$dm_reject		= $pParams['dm_reject'];
		$dm_review		= $pParams['dm_review'];

		//PayPal 거래 아이디
		$pp_transid	= $pParams['pp_transid'];

		//일본 결제 파라미터 (일본결제)Registered or Sale :: Sale은 입금완료 시, statusurl로만 전송됨 일본 편의점/온라인뱅킹 후불결제 이용 시, 결제정보 등록에 대한 통지가 설정된 경우 발송됩니다.
		$status				= $pParams['status'];
		$paymentURL	= $pParams['paymentURL'];//일본결제의 편의점/온라인뱅킹 후불 결제 이용시 고객에게 결제 방법을 안내하는 URL

		// 로그저장
		$log_params	= array(
			'order_seq'	=>$order_seq,
			'payment'		=> 'eximbay',
			'log_data'		=> serialize($this->input->post()),
			'regist_date'	=> date('Y-m-d H:i:s')
		);
		$this->paymentlog->set($log_params);

		//rescode=0000 일때 fgkey 확인
		if($rescode == "0000"){
			foreach($this->input->post() as $Key=>$value) {

				if($Key == "fgkey"){
					continue;
				}
				$hashMap[$Key]  = $value;
			}
			$size = count($hashMap);
			ksort($hashMap);
			$counter = 0;
			foreach ($hashMap as $key => $val) {
				if ($counter == $size-1){
					$sortingParams .= $key."=" .$val;
				}else{
					$sortingParams .= $key."=" .$val."&";
				}
				++$counter;
			}
			//fgkey 검증키 생성
			$linkBuf = $secretKey. "?".$sortingParams;
			$newFgkey = hash("sha256", $linkBuf);

			//fgkey 검증 실패 시 에러 처리
			if(strtolower($fgkey) != $newFgkey){
				$rescode	= "ERROR";
				$resmsg	= "Invalid transaction";
			}
		}

		if($rescode == "0000"){
			//가맹점 측 DB 처리하는 부분
			//해당 페이지는 Back-End로 처리되기 때문에 스크립트, 세션, 쿠키 사용이 불가능 합니다.
			$this->_settle($order_seq, 'eximbay', $transid, $rescode, $resmsg);
		}
	}

	public function _settle($ordr_idxx, $payment_company, $transactionid, $res_cd, $res_msg){
		$payment_config		= config_load("eximbay");
		$cfg['order']			= config_load('order');
		$orders					= $this->ordermodel->get_order($ordr_idxx);
		$data_shipping			= $this->ordermodel->get_order_shipping($ordr_idxx);
		$data_item_option		= $this->ordermodel->get_item_option($ordr_idxx);
		$result_option			= $data_item_option;
		$result_suboption		= $this->ordermodel->get_item_suboption($ordr_idxx);

		// 회원 마일리지 차감
		if( $orders['emoney'] && $orders['member_seq'] && $orders['emoney_use']=='none')
		{
			$params = array(
				'gb'		=> 'minus',
				'type'		=> 'order',
				'emoney'	=> $orders['emoney'],
				'ordno'		=> $ordr_idxx,
				'memo'		=> "[차감]주문 (".$ordr_idxx.")에 의한 마일리지 차감",
				'memo_lang'	=> $this->membermodel->make_json_for_getAlert("mp260",$ordr_idxx), // [차감]주문 (%s)에 의한 마일리지 차감
			);
			$this->membermodel->emoney_insert($params, $orders['member_seq']);
			$this->ordermodel->set_emoney_use($ordr_idxx,'use');
		}

		// 회원 예치금 차감
		if( $orders['cash'] && $orders['member_seq'] && $orders['cash_use']=='none')
		{
			$params = array(
				'gb'		=> 'minus',
				'type'		=> 'order',
				'cash'		=> $orders['cash'],
				'ordno'		=> $ordr_idxx,
				'memo'		=> "[차감]주문 (".$ordr_idxx.")에 의한 예치금 차감",
				'memo_lang'	=> $this->membermodel->make_json_for_getAlert("mp261",$ordr_idxx), // [차감]주문 (%s)에 의한 예치금 차감
			);
			$this->membermodel->cash_insert($params, $orders['member_seq']);
			$this->ordermodel->set_cash_use($ordr_idxx,'use');
		}

		//상품쿠폰사용
		if($data_item_option) foreach($data_item_option as $item_option){
			if($item_option['download_seq']) $this->couponmodel->set_download_use_status($item_option['download_seq'],'used');
		}
		//배송비쿠폰사용
		if($data_shipping) foreach($data_shipping as $shipping){
			if($shipping['shipping_coupon_down_seq']) $this->couponmodel->set_download_use_status($shipping['shipping_coupon_down_seq'],'used');
		}
		//배송비쿠폰사용(사용안함)
		if($orders['download_seq']) $this->couponmodel->set_download_use_status($orders['download_seq'],'used');

		//주문서쿠폰 사용 처리 by hed
		if($orders['ordersheet_seq']) $this->couponmodel->set_download_use_status($orders['ordersheet_seq'],'used');

		//프로모션코드 상품/배송비 할인 사용처리
		$this->promotionmodel->setPromotionpayment($orders);

		$data = array(
			'pg_transaction_number'	=> $transactionid,
			'pg_currency'					=> $pg_currency,
			'payment'							=> 'card',
			'pg'									=> $payment_company
		);

		$this->coupon_reciver_sms = array();
		$this->coupon_order_sms = array();
		$order_count = 0;
		$this->ordermodel->set_step($ordr_idxx, 25, $data);
		$log = $payment_company.' 결제 확인'. chr(10).'[' .$res_cd . $res_msg . ']' . chr(10). implode(chr(10),$data);
		$this->ordermodel->set_log($ordr_idxx, 'pay', '주문자', '결제확인', $log);

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
		ticket_payexport_ck($ordr_idxx);

		//받는 사람 티켓상품 SMS 데이터
		if(count($this->coupon_reciver_sms['order_cellphone']) > 0){
			$order_count = 0;
			foreach($this->coupon_reciver_sms['order_cellphone'] as $key=>$value){
				$coupon_arr_params[$order_count]		= $this->coupon_reciver_sms['params'][$key];
				$coupon_order_no[$order_count]			= $this->coupon_reciver_sms['order_no'][$key];
				$coupon_order_cellphones[$order_count] = $this->coupon_reciver_sms['order_cellphone'][$key];
				$order_count					=$order_count+1;
			}

			$commonSmsData['coupon_released']['phone'] = $coupon_order_cellphones;;
			$commonSmsData['coupon_released']['params'] = $coupon_arr_params;
			$commonSmsData['coupon_released']['order_no'] = $coupon_order_no;

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

			$commonSmsData['coupon_released2']['phone'] = $reciver_order_cellphones;;
			$commonSmsData['coupon_released2']['params'] = $reciver_arr_params;
			$commonSmsData['coupon_released2']['order_no'] = $reciver_order_no;

		}
		if(count($commonSmsData) > 0){
			commonSendSMS($commonSmsData);
		}
	}

	public function receive()
	{
		### MEMBER SESSION
		$this->userInfo = $this->session->userdata('user');

		$order_seq			= $_POST['param1'];
		$payment_config	= config_load("eximbay");
		$orders			= $this->ordermodel->get_order($order_seq);

		// 주문서와 가격 검증
		if(
			$orders['payment_price'] != $_POST['amt'] || 
			!$orders['order_seq'] || 
			$orders['order_seq'] != $order_seq
		){
			$log_title	= '결제실패';
			$log			= "EXIMBAY 결제 실패". chr(10)."[금액불일치]";
			$this->ordermodel->set_log($orders['order_seq'], 'pay', '시스템', $log_title, $log);
			pageClose('접근이 올바르지 않습니다.');
			exit;
		}

		/**
		아래 설정 된 값은 테스트용 secretKey입니다.
		테스트로만 진행하시고 발급 받으신 값으로 변경하셔야 됩니다.
		*/
		$secretKey	= $payment_config['eximbay_secretkey'];//가맹점 secretkey

		//기본 응답 파라미터
		$ver			= $_POST['ver'];//연동 버전
		$mid			= $_POST['mid'];//가맹점 아이디
		$txntype	= $_POST['txntype'];//거래 타입
		$ref			= $_POST['ref'];//가맹점 지정에서 지정한 거래 아이디
		$cur			= $_POST['cur'];//통화
		$amt			= $_POST['amt'];//결제 금액
		$shop		= $_POST['shop'];//가맹점명
		$buyer		= $_POST['buyer'];//결제자명
		$tel			= $_POST['tel'];//결제자 전화번호
		$email		= $_POST['email'];//결제자 이메일
		$lang		= $_POST['lang'];//결제정보 언어 타입

		$transid		= $_POST['transid'];//Eximbay 내부 거래 아이디
		$rescode		= $_POST['rescode'];//0000 : 정상
		$resmsg		= $_POST['resmsg'];//결제 결과 메세지
		$authcode	= $_POST['authcode'];//승인번호, PayPal, Alipay, Tenpay등 일부 결제수단은 승인번호가 없습니다.
		$cardco		= $_POST['cardco'];//카드 타입
		$resdt			= $_POST['resdt'];//결제 시간 정보 YYYYMMDDHHSS
		$paymethod	= $_POST['paymethod'];//결제수단 코드 (연동문서 참고)

		$accesscountry	= $_POST['accesscountry'];//결제자 접속 국가
		$allowedpvoid		= $_POST['allowedpvoid'];//Y: 부분취소 가능. N: 부분취소 불가
		$fgkey					= $_POST['fgkey'];//검증키, rescode=0000인 경우에만 값 세팅 됨
		$payto					= $_POST['payto'];//청구 가맹점명

		//주문 상품 파라미터
		$item_0_product	= $_POST['item_0_product'];
		$item_0_quantity	= $_POST['item_0_quantity'];
		$item_0_unitPrice	= $_POST['item_0_unitPrice'];

		//추가 항목 파라미터
		$surcharge_0_name		= $_POST['surcharge_0_name'];
		$surcharge_0_quantity		= $_POST['surcharge_0_quantity'];
		$surcharge_0_unitPrice	= $_POST['surcharge_0_unitPrice'];

		//가맹점 지정 파라미터
		$param1 = $_POST['param1'];
		$param2 = $_POST['param2'];
		$param3 = $_POST['param3'];

		//카드 결제 정보 파라미터
		$cardholder	= $_POST['cardholder'];//결제자가 입력한 카드 명의자 영문명
		$cardno1		= $_POST['cardno1'];
		$cardno4		= $_POST['cardno4'];

		//DCC 파라미터
		$foreigncur	= $_POST['foreigncur'];//고객 선택 통화
		$foreignamt	= $_POST['foreignamt'];//고객 선택 통화 금액
		$convrate		= $_POST['convrate'];//적용 환율
		$rateid			= $_POST['rateid'];//적용 환율 아이디

		//배송지 파라미터
		$shipTo_city						= $_POST['shipTo_city'];
		$shipTo_country				= $_POST['shipTo_country'];
		$shipTo_firstName			= $_POST['shipTo_firstName'];
		$shipTo_lastName			= $_POST['shipTo_lastName'];
		$shipTo_phoneNumber	= $_POST['shipTo_phoneNumber'];
		$shipTo_postalCode		= $_POST['shipTo_postalCode'];
		$shipTo_state					= $_POST['shipTo_state'];
		$shipTo_street1				= $_POST['shipTo_street1'];

		//CyberSource의 DM을 사용 하는 경우 받는 파라미터
		$dm_decision	= $_POST['dm_decision'];
		$dm_reject		= $_POST['dm_reject'];
		$dm_review		= $_POST['dm_review'];

		//PayPal 거래 아이디
		$pp_transid	= $_POST['pp_transid'];

		//일본 결제 파라미터 (일본결제)Registered or Sale, Sale은 입금완료 시, statusurl로만 전송됨 일본 편의점/온라인뱅킹 후불결제 이용 시, 결제정보 등록에 대한 통지가 설정된 경우 발송됩니다.
		$status				= $_POST['status'];
		$paymentURL	= $_POST['paymentURL'];//일본결제의 편의점/온라인뱅킹 후불 결제 이용시 고객에게 결제 방법을 안내하는 URL

		//rescode=0000 일때 fgkey 확인
		if($rescode == "0000"){
			//fgkey 검증키 생성
			$linkBuf			= $secretKey. "?mid=" . $mid ."&ref=" . $ref ."&cur=" .$cur ."&amt=" .$amt ."&rescode=" .$rescode ."&transid=" .$transid;
			$newFgkey	= hash("sha256", $linkBuf);

			//fgkey 검증 실패 시 에러 처리
			if(strtolower($fgkey) != $newFgkey){
				$rescode	= "ERROR";
				$resmsg	= "Invalid transaction";
			}

			// 장바구니 비우기
			if( $orders['mode'] ){
				$this->cartmodel->delete_mode($orders['mode']);
			}			
		}

		if( $this->_is_mobile_agent)
		{
			$content = "location.href='../order/complete?no=".$order_seq."';";
		}else{
			$content = "
			if(opener) opener.location.href='../order/complete?no=".$order_seq."';
			self.close();";
		}
		echo js($content);
	}	
}