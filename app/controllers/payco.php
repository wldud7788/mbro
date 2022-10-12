<?php
/* ============================================================================== */
/* =   PAGE : 페이코 결제 연동 PAGE												= */
/* = -------------------------------------------------------------------------- = */
/* = Copyright (c)  2018.08   GABIA C&S lwh.   All Rights Reserved.				= */
/* ============================================================================== */

/* ============================================================================== */
/* = * 수정 이력																= */
/* = -------------------------------------------------------------------------- = */
/* = 최초작성 2018-08-23 lwh													= */
/* ============================================================================== */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class payco extends front_base {

	protected $pg_param;		// 넘겨받은 pg 변수 array
	protected $payco_pg;		// 매출증빙 api url
	protected $detail_url;	// 통신 상세 url
	protected $timeout;		// readurl 타임아웃
	protected $authorization; // 인증 변수

	public function __construct() {
		parent::__construct();
		$this->load->helper('order');
		$this->load->helper('shipping');
		$this->load->helper('readurl');

		$this->load->model('cartmodel');
		$this->load->model('ordermodel');
		$this->load->model('membermodel');
		$this->load->model('usedmodel');
		$this->load->model('couponmodel');
		$this->load->model('goodsmodel');
		$this->load->model('promotionmodel');
		$this->load->model('paymentlog');

		$this->load->library('added_payment');
		$this->load->model('reDepositmodel');


		if(!$this->payco_pg || !$this->payco_hub)	$this->set_api();

		$this->cfgPg = config_load('payco');
		$this->cfgOrder = config_load('order');
	}

	protected function set_api(){
		// 실주소
		$this->payco_hub	= "https://payco.firstmall.kr";
		$this->payco_pg		= "https://bill.payco.com";
		// 테스트
		$this->payco_pg_test= "https://alpha-bill.payco.com";
		$this->timeout		= '30';
	}

	// 결제 주문예약 페이지 - STEP1
	public function request(){
		session_start();

		global $pg;

		//app/order.php function pay에서 전달 해준 데이터
		$this->pg_param = json_decode(base64_decode($_POST["jsonParam"]),true);

		$body_data					= array();
		$products_arr				= array();
		$pg_param					= $this->pg_param;
		$pg							= $this->cfgPg;
		$orders						= $this->ordermodel->get_order($pg_param['order_seq']);
		$items						= $this->ordermodel->get_item($pg_param['order_seq']);

		$body_data['sellerKey']						= $pg['sellerKey'];						// 가맹점 코드
		$body_data['sellerOrderReferenceKey']		= $pg_param['order_seq'];				// 주문번호
		$body_data['sellerOrderReferenceKeyType']	= 'UNIQUE_KEY';							// 주문번호타입
		$body_data['currency']						= $pg['currency'];						// 통화단위

		$body_data['totalPaymentAmt']				= $orders['settleprice'];				// 총 결제 할 금액 (총 배송비 포함)
		$body_data['totalTaxfreeAmt']				= $orders['freeprice'];					// 면세금액(면세상품의 공급가액 합)
		$body_data['totalTaxableAmt']				= $pg_param['comm_tax_mny'];			// 과세금액(과세상품의 공급가액 합)
		if(isset($pg_param['comm_vat_mny'])){
			$body_data['totalVatAmt']				= $pg_param['comm_vat_mny'];			// 부가세(과세상품의 부가세 합)
		}
		$body_data['orderTitle']					= urlencode($pg_param['goods_name']);	// 주문 타이틀

		// returnUrl, returnUrlParam, nonBankbookDepositInformUrl, orderMethod 중계서버에서 재정의 됨

		// 주문채널 PC/MOBILE
		if ($this->mobileMode && $this->_is_mobile_agent)					$_AGENT			= "MOBILE";
		else																$_AGENT			= "PC";
		$body_data['orderChannel']					= $_AGENT;

		// 인앱결제 여부(Y/N), default=N (in-app 결제인경우 Y)
		if (checkUserApp(getallheaders()))
			$body_data['inAppYn']					= 'Y';

		// 개인통관고유번호 입력 여부 (Y/N) default=N
		if ($orders['clearance_unique_personal_code'])
			$body_data['individualCustomNoInputYn']	= 'Y';

		// 주문상품 List (Json Data)
		$products									= array();
		foreach($items as $k => $item){
			if($k < 1){ // 1개의 상품만 보내달라는 페이코 측 요청
				$item_option = $this->ordermodel->get_option_for_item($item['item_seq']);
				$products['cpId']						= $pg['cpId'];		// 상점 ID
				$products['productId']					= $pg['productId']; // 상품 ID
				$products['productAmt']					= $item_option[0]['ori_price'] * $item_option[0]['ea']; // 상품금액 (상품단가 * 수량)
				$products['productPaymentAmt']			= $body_data['totalPaymentAmt']; // 상품 결제금액 (상품결제단가 * 수량) => 총결제금액으로 보내달라고요청
				$products['orderQuantity']				= $orders['total_ea']; // 주문 수량
				$products['sortOrdering']				= $k + 1; // 노출순서
				// 상품명 - 1개상품을 대표로 보내달라는 요청
				if(count($items) > 1)					$goods_cnt = ' 외 ' . (count($items)-1) . '건';
				$products['productName']				= urlencode($item['goods_name'] . $goods_cnt);
				$products['option']						= urlencode($item_option[0]['title1'].':'.$item_option[0]['option1']);
				// 외부가맹점에서 관리하는 주문상품 연동 키 - 그냥 랜덤하게 넣어달라는 요청에 주문번호를 넣었음.
				$products['sellerOrderProductReferenceKey'] = $orders['order_seq'];
				// 과세타입 - DUTYFREE:면세, TAXATION:과세, COMBINE:결합상품
				if		($orders['freeprice'] && $pg_param['comm_vat_mny'])			$taxationType	= 'COMBINE';
				else if ($orders['freeprice'] && !$pg_param['comm_vat_mny'])		$taxationType	= 'DUTYFREE';
				else																$taxationType	= 'TAXATION';
				$products['taxationType']				= $taxationType;	// 과세 타입

				$products_arr[]							= $products;
			}
		}
		$body_data['orderProducts']					= $products_arr;
		if($products['productName'])				$body_data['orderTitle'] = $products['productName'];


		// #26000 불필요 파라미터 제거 by hed
		// 1-1. Payment 변수 설정
		// $body_data['cid']				= $pg['cid'];				// 가맹점 코드
		// $body_data['partner_user_id']	= ($orders['member_seq']) ? $orders['member_seq'] : 'nomember';			// 가맹점 회원 id
		// $body_data['partner_order_id']	= $orders['order_seq'];		// 가맹점 주문번호
		// $body_data['item_name']			= $pg_param['goods_name'];	// 상품명
		// $body_data['quantity']			= $orders['total_ea'];		// 상품 수량
		// $body_data['total_amount']		= floor($orders['settleprice']);// 상품 총액
		// $body_data['tax_free_amount']	= floor($orders['freeprice']);	// 상품 비과세 금액
		// if(isset($pg_param['comm_vat_mny'])){
		// 	$body_data['vat_amount']		= floor($pg_param['comm_vat_mny']);									// 상품 부과세 금액
		// }
		// if(count($pg['payment_opt']) == 1){
		// 	$body_data['payment_method_type']= $pg['payment_opt'][0];// 결제 수단 제한
		// }
		// if($pg['interestTerms'] != 'auto'){
		// 	$body_data['install_month']	= (int) $pg['interestTerms']; // 카드할부개월수 0~12
		// }


		// 1-2. 샵정보 추가
		$shop_info['shopSno']	= $this->config_system['shopSno'];
		$shop_info['domain']	= get_connet_protocol().$_SERVER['HTTP_HOST']; //가맹점 도메인 입력
		$body_param['s_info']	= $shop_info;

		// 1-3. 부가정보 추가
		// 부가 정보 & 판매자 부가 정보는 중계서버에서 입력 및 가공됨.
		$pg_info['pg_method_code']			= $pg['method_code'];
		$pg_info['pg_agent']				= $body_data['orderChannel'];
		if ($body_data['orderChannel'] == 'MOBILE'){
			$pg_info['cancelMobileUrl']		= 'payco/cancel';
		}
		if($body_data['inAppYn'] == 'Y'){
			// IOS인앱 결제시 ISP 모바일 등의 앱에서 결제를 처리한 뒤  복귀할 앱 url
			$pg_info['appUrl']				= "firstmall_app://";
		}
		// 자동 주문 무효 사용시 - 가상계좌 만료일 사용
		if($this->cfgOrder['autocancel'] == 'y')
			$pg_info['expiry_date']			= date('YmdHis',strtotime("+".$this->cfgOrder['cancelDuration']." day", time()));

		$body_param['pg_info']				= $pg_info;

		// 1-3. API 통신
		$body_param['api_type']	= 'reserve';
		$body_param['params']	= $body_data;
		$call_url	= $this->payco_hub.'/payco_hub.php';
		$json_data	= readurl($call_url,$body_param,false,$this->timeout);
		$read_data	= json_decode($json_data,true);
		$respons	= $read_data['result'];

		// 2. 리턴값 수신 -> 결과 추출
		if($respons['code'] == '0'){

			// 2-1. 세션 생성
			$pg_map['order_seq']			= $orders['order_seq'];
			$pg_map['reserveOrderNo']		= $respons['result']['reserveOrderNo'];
			$pg_map['pg_param']				= $pg_param;
			$_SESSION['PAYCO_PG']			= $pg_map;
		}else{
			// 결제요청 실패
			$alertMsg = getAlert('os217');
			if($respons['code'])		$alertMsg .= ':' . $respons['code'];
			if($respons['message'])		$alertMsg .= '\n['.$respons['message'].']';
			echo '<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>';
			echo '<script type="text/javascript">alert("'.$alertMsg.'");'.$this->pg_cancel_script().'</script>';
			exit;
		}

		$this->template->assign('agent',$_AGENT);
		$this->template->assign('param',$respons['result']);
		$this->template->template_dir = BASEPATH."../order";
		$this->template->compile_dir = BASEPATH."../_compile/";
		$this->template->define(array('tpl'=>'_payco.html'));

		$this->template->print_('tpl');
	}

	// 결제 인증 - STEP2
	public function auth(){
		session_start();

		$pg = $this->cfgPg;
		$pg_param = $this->pg_param;
		$aGetParams = $this->input->get();

		try {
			/*
			request 에서 세션에 저장했던 파라미터 값이 유효한지 체크
			세션 유지 시간(로그인 유지시간)을 적당히 유지 하거나 세션을 사용하지 않는 경우 DB처리 하시기 바랍니다.
			*/
			if ( ! isset($_SESSION['PAYCO_PG'])) {
				throw new Exception('Require PAYCO_PG : [PAYCO_PG]' . $_SESSION['PAYCO_PG'], 402);
			}

			// 전달값 체크
			$param = $_SESSION['PAYCO_PG'];
			$platForm = 'P';
			$pageUrl = $this->uri->segment(2);
			if ($this->_is_mobile_agent) {
				$platForm = 'M';
			}
			$this->added_payment->write_log($param['order_seq'], $platForm, 'payco', $pageUrl, 'process0100', $param);

			// 주문 조회
			$orders = $this->ordermodel->get_order($param['order_seq']);

			// 필수 값 체크
			if ( ! $orders['order_seq']) {
				throw new Exception('Require order : [order_seq]' . $orders['order_seq'], 401);
			}
			if (preg_match('/virtual/', $orders['payment'])) {
				if ($orders['step'] >= '15' && $orders['step'] <= '75') {
					throw new Exception('Wrong order status : [step]' . $orders['step'] . '[payment]' . $orders['payment'], 401);
				}
			} else {
				if ($orders['step'] >= '25' && $orders['step'] <= '75') {
					throw new Exception('Wrong order status : [step]' . $orders['step'] . '[payment]' . $orders['payment'], 401);
				}
			}

			// 가격 검증
			if ($orders['pg_currency'] == 'KRW' && $param['pg_param']['settle_price'] != floor($orders['settleprice'])) {
				throw new Exception('Wrong order [settleprice]' . $orders['settleprice'], 401);
			}

			// 결제 시작 마킹
			if ($orders['order_seq']) {
				$reDepositSeq = $this->reDepositmodel->insert(
					array(
						'order_seq' => $orders['order_seq'],
						'pg' => 'payco',
						'params' => json_encode($param),
						'regist_date' => date('Y-m-d H:i:s')
					)
				);
			}

			// 1-2. 전달 정보 설정
			$body_data['sellerKey'] = $pg['sellerKey']; // 가맹점 코드
			$body_data['reserveOrderNo'] = $param['reserveOrderNo']; // 주문예약번호
			$body_data['sellerOrderReferenceKey'] = $orders['order_seq']; // 외부가맹점에서 관리하는 주문연동 Key
			$body_data['paymentCertifyToken'] = $aGetParams['paymentCertifyToken']; // 결제인증토큰 - 결제인증완료 후 returnUrl로전달 받은 정보
			$body_data['totalPaymentAmt'] = $orders['settleprice']; // 총 결제 할 금액 (총 배송비 포함)
			$body_data['totalTaxfreeAmt'] = $orders['freeprice']; // 면세금액(면세상품의 공급가액 합)
			$body_data['totalTaxableAmt'] = $param['pg_param']['comm_tax_mny']; // 과세금액(과세상품의 공급가액 합)
			if (isset($param['pg_param']['comm_vat_mny'])) {
				$body_data['totalVatAmt'] = $param['pg_param']['comm_vat_mny']; // 부가세(과세상품의 부가세 합)
			}

			// 1-3. 샵정보 추가
			$shop_info['shopSno'] = $this->config_system['shopSno'];
			$shop_info['domain'] = get_connet_protocol() . $_SERVER['HTTP_HOST']; //가맹점 도메인 입력
			$body_param['s_info'] = $shop_info;

			// 1-4. API 통신
			$body_param['api_type']	= 'approval';
			$body_param['params'] = $body_data;
			$call_url = $this->payco_hub . '/payco_hub.php';
			$json_data = readurl($call_url, $body_param, false, $this->timeout);
			$read_data = json_decode($json_data, true);
			$respons = $read_data['result'];

			$this->added_payment->write_log($orders['order_seq'], $platForm, 'payco', $pageUrl, 'process0200', $respons);

			// 2-1. 리턴값 수신
			if ($read_data['httpCode'] == '200' && $respons['code'] == '0') {

				$resultCode	= $respons['code']; // 결과 코드
				$resMsg = $respons['message']; // 결과 메세지
				$orderNo = $respons['result']['orderNo']; // 페이코 거래고유번호
				$CertifyKey = $respons['result']['orderCertifyKey']; // 페이코 주문인증키
				$amt = $respons['result']['totalPaymentAmt']; // 결제 승인 요청 금액

				foreach ($respons['result']['paymentDetails'] as $k => $payment) {
					switch ($payment['paymentMethodCode']) {
						case '01' : // 신용카드(일반) - 쓰지 않음..
						case '31' : // 신용카드
							$respons['payment_method_type'] = 'card';

							$cardCode = $payment['cardSettleInfo']['cardCompanyCode'];
							$cardName = $payment['cardSettleInfo']['cardCompanyName'];
							$enc = mb_detect_encoding($cardName);
							if($enc != 'UTF-8'){
								$cardName = iconv($enc, "UTF-8", $cardName);
							}
							$cardQuota = $payment['cardSettleInfo']['cardInstallmentMonthNumber']; // 할부개월수
						break;
						case '04' : // 계좌이체(일반) - 쓰지 않음..
						case '35' : // 간편계좌
							$respons['payment_method_type'] = 'account';

							$bank_name	= $payment['realtimeAccountTransferSettleInfo']['bankName'];
							$bankCode = $payment['realtimeAccountTransferSettleInfo']['bankCode'];
							$accountNo = $payment['realtimeAccountTransferSettleInfo']['accountNo'];

							// recive 에서 처리할 변수 설정
							$respons['account'] = '[' . $bank_name . '] ' . $accountNo;
						break;
						case '02' : // 무통장입금
							$respons['payment_method_type'] = 'virtual';

							$bank_name = $payment['nonBankbookSettleInfo']['bankName'];
							$bankCode = $payment['nonBankbookSettleInfo']['bankCode'];
							$accountNo = $payment['nonBankbookSettleInfo']['accountNo'];
							$paymentExpirationYmd = $payment['nonBankbookSettleInfo']['paymentExpirationYmd'];

							// recive 에서 처리할 변수 설정
							$respons['virtual_account'] = '[' . $bank_name . '] ' . $accountNo;
							$respons['virtual_date'] = $paymentExpirationYmd;
						break;

						case '05' : // 휴대폰(일반) - 쓰지 않음..
						case '60' : // 휴대폰
							$respons['payment_method_type'] = 'phone';
							// 변수 전체를 그냥 저장..
							//$payment;
						break;
						case '75' : // 페이코 쿠폰(자유이용쿠폰) - 쓰지 않음..
						case '76' : // 카드 쿠폰 - 쓰지 않음..
						case '77' : // 가맹점 쿠폰 - 쓰지 않음..
						case '96' : // 충전금 환불 - 쓰지 않음..
						case '98' : // 페이코 포인트
							$respons['payment_method_type'] = 'payco_coupon';
							// 변수 전체를 그냥 저장..
							//$payment;
						break;
					}

					$payment_method_type[] = $respons['payment_method_type']; // 결제정보
					$approved_at = $payment['tradeYmdt']; // 결제승인시각
				}
			}else{
				/* = ----------------------------------------------------------------- = */
				/* =   결제 실패 DB 업데이트 로직											   = */
				/* = ----------------------------------------------------------------- = */

				// 결제요청 실패
				$resultCode	= $respons['code'];
				if($respons['message']){
					$resMsg = $respons['message'];
				}

				$this->ordermodel->set_step($orders['order_seq'], '99');
				$this->ordermodel->set_log($orders['order_seq'], 'pay', $orders['order_user_name'], '결제실패[' . $respons['code'] . ']', "페이코 결제 실패" . chr(10) . "[" . $respons['code'] ." : " . $resMsg ."]");

				if ($resMsg) {
					throw new Exception($resMsg, 401);
				} else {
					throw new Exception('Payment Fail : [res_cd]' . $resultCode, 401);
				}
			}

		} catch (Exception $e) {
			$errMsg = $e->getMessage();
			$errCode = $e->getCode();
			$this->added_payment->write_log($orders['order_seq'], $platForm, 'payco', $pageUrl, 'process0300', array('errorMsg' => $errMsg)); // 파일 로그 저장
		}

		// 결제 종료 마킹
		if ($reDepositSeq) {
			$this->reDepositmodel->del(array('re_deposit_seq' => $reDepositSeq));
		}

		// 2-2. PG 로그 저장
		$this->added_payment->set_pg_log(
			array(
				'pg' => 'payco',
				'order_seq' => $orders['order_seq'],
				'tno' => $orderNo,
				'amount' => $amt,
				'app_time' => ($approved_at) ? date('YmdHis', strtotime($approved_at)) : null,
				'app_no' => $CertifyKey,
				'card_cd' => $cardCode,
				'card_name' => $cardName,
				'noinf' => '',
				'quota' => $cardQuota,
				'bank_name' => $bank_name,
				'bank_code' => $bankCode,
				'depositor' => '',
				'account' => $accountNo,
				'commid' => '',
				'mobile_no' => '',
				'escw_yn' => 'N',
				'biller' => 'payco',
				'payment_cd' => implode(',', $payment_method_type),
				'va_date' => $paymentExpirationYmd,
				'res_cd' => $resultCode,
				'res_msg' => $resMsg
			)
		);

		if ($errCode == '401') {
			$this->payfail('FM402 - ' . $errMsg);
		} else if ($errCode == '402') {
			$this->payfail('FM401 - SESSION ERR');
		} else {
			// 3. 결제 승인처리
			$this->receive($respons, $orders);

			// 4. 완료페이지 이동
			$this->paySucc($orders['order_seq']);
		}
	}

	// 최종 결제승인처리 (퍼스트몰 로직) - STEP3
	public function receive($respons, $orders)
	{
		if(!$orders['order_seq']){
			// 주문서 주문번호 오류시 처리...
		}

		if($respons['payment_method_type']){
			$payment_method = $respons['payment_method_type'];
			$set_params		= array('payment');
			$where_params	= array($payment_method);

			// 무통장 입금 처리 시
			if($payment_method == 'virtual'){
				array_push($set_params, 'virtual_account');
				array_push($set_params, 'virtual_date');
				array_push($where_params, $respons['virtual_account']);
				array_push($where_params, $respons['virtual_date']);
			}
			array_push($where_params, $orders['order_seq']);

			if(count($set_params) > 0){
				$add_set = implode('=?, ',$set_params) . "=? ,";
			}
			$query = "update fm_order set " . $add_set . "pg='payco' where order_seq=?";
			$this->db->query($query,$where_params);
		}

		// $tid == $orderNo 와 $authCode == $CertifyKey  선언
		$orderNo		= $respons['result']['orderNo'];			// 페이코 거래고유번호
		$CertifyKey		= $respons['result']['orderCertifyKey'];	// 페이코 주문인증키

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

		//프로모션코드 상품/배송비 할인 사용처리
		$this->promotionmodel->setPromotionpayment($orders);

		// 장바구니 비우기
		if( $orders['mode'] ){
			$this->cartmodel->delete_mode($orders['mode']);
		}

		// 주문 상태 업데이트
		$data = array(
			'pg_transaction_number' => $orderNo,	// 페이코 거래고유번호
			'pg_approval_number'	=> $CertifyKey	// 페이코 주문인증키
		);
		$this->coupon_reciver_sms = array();
		$this->coupon_order_sms = array();
		$order_count = 0;

		// 가상계좌 구분 처리
		if($payment_method == 'virtual')	$step	= 15;
		else								$step	= 25;
		$this->ordermodel->set_step($orders['order_seq'], $step, $data);

		// DB 로그 기록
		$add_log = "";
		if($orders['orign_order_seq'])	$add_log = "[재주문]";
		if($orders['admin_order'])		$add_log = "[관리자주문]";
		if($orders['person_seq'])		$add_log = "[개인결제]";

		if($payment_method == 'virtual')	$msg_payment = '가상계좌발급완료';
		else								$msg_payment = '결제확인';

		$log_title =  $add_log . $msg_payment . "(페이코)";
		$log = "페이코 " . $msg_payment . chr(10) . "[" . $resultCode . ":" . $_payco_result_code[$resultCode] ."]" . chr(10). implode(chr(10),$data);
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

		if($step == '25'){
			$commonSmsData = $this->send_sms($orders['order_seq']);
		}

		if(count($commonSmsData) > 0){
			commonSendSMS($commonSmsData);
		}
	}

	// 무통장 입금 확인 처리
	public function account()
	{
		// $_POST['reserveOrderNo']; // 예약 주문번호 - 저장안함
		$order_seq	= $_POST['sellerOrderReferenceKey'];								// 주문번호
		$tno		= $_POST['orderNo'];												// tno - 거래번호
		$amount		= $_POST['totalOrderAmt'];											// 결제금액
		$bank_code	= $_POST['paymentDetails'][0]['nonBankbookSettleInfo']['bankCode'];	// 은행코드
		$account	= $_POST['paymentDetails'][0]['nonBankbookSettleInfo']['accountNo'];// 계좌번호

		// PG LOG CHK
		$where_param['tno']			= $tno;
		$where_param['amount']		= $amount;
		$where_param['bank_code']	= $bank_code;
		$where_param['account']		= $account;
		$pg_log_arr					= $this->ordermodel->get_pg_log($order_seq, $where_param);

		if($pg_log_arr[0]['order_seq']){
			$data_order = $this->ordermodel->get_order($order_seq);
			if($data_order['step'] == '15'){

				// 결제 확인 처리
				$this->ordermodel->set_step($order_seq,25);

				// 티켓관련 처리
				$commonSmsData = $this->send_sms($order_seq);
				if(count($commonSmsData) > 0){
					commonSendSMS($commonSmsData);
				}

				// 로그 처리
				$log_title =  "무통장 입금 결제확인 (페이코)";
				$log = "페이코 결제확인 " . chr(10) . "[" . $_POST['code'] . ":" . $_POST['message'] ."]";
				$this->ordermodel->set_log($order_seq, 'pay', '시스템', $log_title, $log);

				$result = array('result'=>'200','respons'=>'OK');
			}else if($data_order['step'] == '15'){
				// 기처리 및 수동처리 된 내역으로 처리X
				$result = array('result'=>'200','respons'=>'OK');
			}else{
				$result = array('result'=>'500','respons'=>'ERROR','step'=>$data_order['step']);
			}
		}else{
			$result = array('result'=>'400','respons'=>'ERROR','params'=>$_POST);
		}

		echo json_encode($result);
	}

	// step 에 따른 발송 처리 구분
	public function send_sms($order_seq)
	{
		// 주문메일 sms발송
		send_mail_step25($order_seq);

		/* 자체 현금영수증 처리(?)
		$this->load->helper('common');
		// 계좌이체 결제의 경우 현금영수증
		$orders	= $this->ordermodel->get_order($order_seq);
		if( preg_match('/account/',$orders['payment']) ){
			$result = typereceipt_setting($order_seq);
		}
		*/

		//티켓상품 자동 출고처리구문 순차진행을 위해 분리함 @2017-08-16
		ticket_payexport_ck($order_seq);

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

			$commonSmsData['coupon_released2']['phone']		= $reciver_order_cellphones;
			$commonSmsData['coupon_released2']['params']	= $reciver_arr_params;
			$commonSmsData['coupon_released2']['order_no']	= $reciver_order_no;
		}

		return $commonSmsData;
	}

	// 결제 처리 완료 시 페이지 이동
	public function paySucc($order_seq){
		// $("#actionFrame", parent.document)[0].contentWindow;
		// opener
	    echo '<script type="text/javascript">var actionFrame=parent.document.getElementById("actionFrame");if(null===actionFrame||"object"!=typeof actionFrame){var frames=parent.document.getElementsByName("actionFrame");for(i in frames)if("object"==typeof frames[i]){actionFrame=frames[i];break}}actionFrame.contentWindow.succ_pg("' . $order_seq . '");</script>';
	}

	// 결제 취소 시 리턴
	public function cancel(){
		// 결제를 취소하셨습니다.
		echo '<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>';
		echo '<script type="text/javascript">alert("'.getAlert('os178').'");'.$this->pg_cancel_script().'</script>';
	}

	// 결제 실패 시 리턴
	public function payfail($code){
		if($this->input->get('code') && empty($code)){
			$code = $this->input->get('code').' - '.$this->input->get('message');
		}
		// $("#actionFrame", parent.document)[0].contentWindow;
		// opener
		// 결제실패
		echo '<script type="text/javascript">parent.document.getElementById("actionFrame").contentWindow.fail_pg("'.$code.'");</script>';
	}

	public function pg_cancel_script(){
		$js_echo = '$("#wrap",parent.document).show();$("div.pay_layer",parent.document).eq(0).show();$("div.pay_layer",parent.document).eq(1).hide();$("#layer_pay",parent.document).hide();$("#lay_mask",parent.document).remove();';

		return $js_echo;
	}

	// 매출전표 추출
	public function pg_confirm(){

		/* 영수증 - 매출전표
		테스트 -> https://alpha-bill.payco.com
		서비스 -> https://bill.payco.com
		• 가맹점용 URL : /seller/receipt/{가맹점키}/{외부가맹점주문번호}/{PAYCO주문번호}
		/seller/receipt/{sellerKey}/{sellerOrderReferenceKey}/{orderNo}

		• 고객용 URL :  /outseller/receipt/{PAYCO주문번호}
		/outseller/receipt/{orderNo}
		*/
		// 초기화 변수 선언
		$cid = $tid = $order_seq = $p_userid = null;
		$order_seq	= ($_GET['no']) ? $_GET['no'] : $_POST['order_seq'];

		// 구버전 구분값 및 TID 추출
		$this->db->where('order_seq',$order_seq);
		$query		= $this->db->get('fm_order_pg_log');
		$result		= $query->result_array();
		$tid		= $result[0]['tno'];

		$pg	= $this->cfgPg;
		if($this->managerInfo && $_GET['admin']){
			$call_url	= '/seller/receipt/[:sellerKey:]/[:sellerOrderReferenceKey:]/[:orderNo:]';
		}else{
			$call_url	= '/outseller/receipt/[:orderNo:]';
		}

		$call_url	= str_replace('[:sellerKey:]', $pg['sellerKey'], $call_url);
		$call_url	= str_replace('[:sellerOrderReferenceKey:]', $order_seq, $call_url);
		$call_url	= str_replace('[:orderNo:]', $tid, $call_url);

		// 매출정보 주소 정보
		if($pg['sellerKey'] == 'S0FSJE')	$confirm_url = $this->payco_pg_test.$call_url;
		else								$confirm_url = $this->payco_pg.$call_url;

		if($_GET['return_type'] == 'json'){
			echo json_encode($confirm_url);
		}else{
			echo $confirm_url;
		}
	}

	// 결제 팝업 리다이렉트 창
	public function pg_popup(){
		redirect($_GET['orderSheetUrl']);
	}

	// 상점 키 정보 저장
	public function set_keys(){

		if($this->config_system['shopSno'] == $_POST['shopSno']){
			$payco_config = $this->cfgPg;
			$payco_config['cpId']		= $_POST['cpId'];
			$payco_config['sellerKey']	= $_POST['sellerKey'];
			$payco_config['productId']	= $_POST['productId'];
			$payco_config['partnerId']	= $_POST['partnerId'];

			config_save('payco',$payco_config);

			$result = array('result'=>'200','respons'=>'SUCC');
			echo json_encode($result);
		}else{
			$result = array('result'=>'400','respons'=>'FAIL');
			echo json_encode($result);
		}
	}
}