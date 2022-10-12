<?php
/*
* allat 유플러스 크로스 브라우징 결제 모듈
* 2017-05-30 jhs create
* 수정될때 아래에 이력을 남겨주세요 (no. 날짜 이니셜 (내용))
* 1. 2017-06-05 jhs (결제 모듈 변경에 따른 클래스 변경)
* 2. 2017-06-26 jhs (결제 취소 액션 추가)
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class allat extends front_base {

	protected $json_pg_param;

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
		$this->load->library('added_payment');

		$this->cfgPg = config_load('allat');
	}

	 /*
	 * [결제 인증요청 페이지(STEP1)]
	 *
	 */
	public function request()
	{
		//공통적으로 세션을 호출을 안하기에 각 클래스 함수별로 호출
		//공통적으로 세션을 호출할시에는 이부분 제거
		session_start();

		//app/order.php function pay에서 전달 해준 데이터
		$this->json_pg_param = json_decode(base64_decode($_POST["jsonParam"]), true);

		// #28841 settle_price 위 변조 체크 19.02.12 kmj
		$orders = $this->ordermodel->get_order($this->json_pg_param['order_seq']);
		$settle_price = $orders['settleprice'];

		if (intval(floor($settle_price)) !== intval($this->json_pg_param['settle_price'])) {
			alert('결제 금액이 일치하지 않습니다. 다시 한 번 시도해 주세요.');
		}

		$pg_param = array();
		$pg = $this->cfgPg;
		if( isset($pg['pcCardCompanyCode']) ){
			foreach($pg['pcCardCompanyCode'] as $key => $code){
				$arr = explode(',',$pg['pcCardCompanyTerms'][$key]);
				$terms = array();
				foreach($arr as $term){
					$terms[] = sprintf('%02d',$term);
				}
				$codes[] = $code . '-' . implode(':',$terms);
			}
			$this->json_pg_param['allat_noint_quota'] = implode(',',$codes);
		}
		$this->json_pg_param['quotaopt']  = $pg['interestTerms'];
		$pg_param = array_merge($pg_param,$this->json_pg_param);
		$payment = str_replace('escrow_','',$pg_param['payment']);
		if($payment != $pg_param['payment']){
			$pg_param['escorw'] = 1;
			$pg_param['payment'] = $payment;
		}

		$orders = $this->ordermodel -> get_order($pg_param['order_seq']);
		if($pg['mallCode'] == "FM_allat_test01") $pg['mallCode'] = "allat_test01";
		$param['allat_shop_id'] = $pg['mallCode'];
		$param['allat_order_no'] = $pg_param['order_seq'];
		$param['allat_amt'] = $pg_param['settle_price'];
		$param['allat_pmember_id'] = "GUEST";
		if( $this->userInfo['userid'] && strlen($this->userInfo['userid']) < 20 ) $param['allat_pmember_id'] = $this->userInfo['userid'];

		$param['allat_product_cd']	= $pg_param['goods_seq'];
		$param['allat_product_nm']	= $pg_param['goods_name'];
		$param['allat_buyer_nm'] = $pg_param['order_user_name'];
		$param['allat_recp_nm'] = $orders['recipient_user_name'];
		if(function_exists('mb_strcut') === true) {
		    $param['allat_buyer_nm']	= mb_strcut($param['allat_buyer_nm'],0,20);
		    $param['allat_recp_nm']		= mb_strcut($param['allat_recp_nm'],0,20);
		}

		//non active x 방식 추가 파라미터
		$param['shop_receive_url'] = get_connet_protocol().$_SERVER['HTTP_HOST']."/allat/auth";
		$param['allat_enc_data'] = "";
		$param['allat_bonus_yn'] = 'N';
		$param['allat_sell_yn'] = 'Y';
		$param['allat_cardes_yn'] = 'N';
		$param['allat_hpes_yn'] = 'N';
		$param['allat_ticketes_yn'] = 'N';
		$param['allat_registry_no'] = '';
		$param['allat_kbcon_point_yn'] = '';
		$param['allat_gender'] = '';
		$param['allat_birth_ymd'] = '';
		$param['allat_encode_type'] = 'U';
		//non active x 방식 추가 파라미터

		$param['allat_recp_addr'] = $orders['recipient_address']." ".$orders['recipient_address_detail'];

		if(trim($param['allat_recp_addr'])=="") {
			$param['allat_recp_addr']	= $orders['order_user_name'];
		}

		$param['allat_card_yn'] = 'N';
		$param['allat_bank_yn'] = 'N';
		$param['allat_vbank_yn'] = 'N';
		$param['allat_hp_yn'] = 'N';
		$param['allat_ticket_yn']  = 'N';
		if($pg_param['payment'] == 'card') $param['allat_card_yn'] = 'Y';
		if($pg_param['payment'] == 'account') $param['allat_bank_yn'] = 'Y';
		if($pg_param['payment'] == 'virtual') $param['allat_vbank_yn'] = 'Y';
		if($pg_param['payment'] == 'cellphone') $param['allat_hp_yn'] = 'Y';

		$param['allat_zerofee_yn'] = 'Y';
		$param['allat_cash_yn'] = 'N';

		$param['allat_email_addr'] = $orders['order_email'];
		$param['allat_product_img'] = $pg_param['goods_image'];
		$param['allat_real_yn'] = 'Y';
		$param['allat_bankes_yn'] = 'N';
		$param['allat_vbankes_yn'] = 'N';
		if($pg_param['payment'] == 'account' && $pg_param['escorw']) $param['allat_bankes_yn'] = 'Y';
		if($pg_param['payment'] == 'virtual' && $pg_param['escorw']) $param['allat_vbankes_yn'] = 'Y';
		$param['allat_test_yn']  = 'N';
		if( $pg['mallCode'] == 'FM_pgfreete2' ) $param['allat_test_yn']  = 'Y';

		###
		$param['comm_free_mny']		= $pg_param['freeprice'];
		$param['comm_tax_mny']		= $pg_param['comm_tax_mny'] ? $pg_param['comm_tax_mny'] : '0';
		$param['comm_vat_mny']		= $pg_param['comm_vat_mny'] ? $pg_param['comm_vat_mny'] : '0';
		$param['allat_tax_yn']		= $pg_param['comm_tax_mny'] ? 'Y':'N';

		// 복합과세 처리
		if($param['comm_free_mny']){
			$param['allat_multi_amt'] = $param['comm_tax_mny']."|".$param['comm_vat_mny']."|".(($pg_param['freeprice'])?$pg_param['freeprice']:"0");
		}

		// 모바일 일경우 모바일 결제창
		if( $this->_is_mobile_agent)
		{
			if($this->pg_param['mobilenew'] == 'y') $this->pg_open_script();
			echo("<form name='all_settle_form' method='post' target='tar_opener' action='../allat_mobile/allat'>");
			echo("<input type='hidden' name='order_seq' value='".$pg_param['order_seq']."' />");
			echo("<input type='hidden' name='goods_name' value='".$pg_param['goods_name']."' />");
			echo("<input type='hidden' name='goods_seq' value='".$pg_param['goods_seq']."' />");
			echo("<input type='hidden' name='mobilenew' value='".$pg_param['mobilenew']."' />");
			if($param['comm_free_mny']){
				echo("<input type='hidden' name='allat_multi_amt' value='".$param['allat_multi_amt']."' />");
			}
			echo("<input type='hidden' name='comm_free_mny' value='".$pg_param['freeprice']."' />");
			echo("<input type='hidden' name='comm_tax_mny' value='".$pg_param['comm_tax_mny']."' />");
			echo("<input type='hidden' name='comm_vat_mny' value='".$pg_param['comm_vat_mny']."' />");
			echo("</form>");
			echo("<script>document.all_settle_form.submit();</script>");
			exit;
		}

		$this->template->assign("param",$param);
		$this->template->assign($pg_param);
		$this->template->template_dir = BASEPATH."../order";
		$this->template->compile_dir = BASEPATH."../_compile/";
		$this->template->define(array('tpl'=>'_allat_nax.html'));
		$this->template->print_('tpl');
	}


	/*
	*[인증(STEP2)]
	*/
	public function auth(){
		//공통적으로 세션을 호출을 안하기에 각 클래스 함수별로 호출
		//공통적으로 세션을 호출할시에는 이부분 제거
		session_start();
		// 결과값
		$param['result_cd']  = $_POST["allat_result_cd"];
		$param['result_msg'] = $_POST["allat_result_msg"];
		$param['enc_data'] = $_POST["allat_enc_data"];

		$this->template->assign("param",$param);
		$this->template->assign($this->pg_param);
		$this->template->template_dir = BASEPATH."../order";
		$this->template->compile_dir = BASEPATH."../_compile/";
		$this->template->define(array('tpl'=>'_allat_nax_auth.html'));
		$this->template->print_('tpl');
	}

	 /*
	 * [최종결제요청 페이지STEP3]
	 *
	 */
	public function receive()
	{
		$this->load->model('reDepositmodel');
		require ROOTPATH . 'pg/allat/allatutil.php'; // library [수정불가]

		$pg = $this->cfgPg;
		$aParams = $this->input->post();
		$r_reservation_goods_seq = array();
		$r_use_pay_method = array(
			'CARD'=>'card',
			'ABANK'=>'account',
			'VBANK'=>'virtual',
			'HP'=>'cellphone'
		);
		$aResultField = array(
			'reply_cd',
			'reply_msg',
			'order_no',
			'amt',
			'pay_type',
			'approval_ymdhms',
			'seq_no',
			'approval_no',
			'card_id',
			'card_nm',
			'sell_mm',
			'zerofee_yn',
			'cert_yn',
			'contract_yn',
			'save_amt',
			'bank_id',
			'bank_nm',
			'cash_bill_no',
			'escrow_yn',
			'account_no',
			'account_nm',
			'income_account_nm',
			'income_limit_ymd',
			'income_expect_ymd',
			'cash_yn',
			'hp_id',
			'ticket_id',
			'ticket_pay_type',
			'ticket_nm'
		);

		if ($pg['mallCode'] == 'FM_pgfreete2') {
			$sucess_code = "0001";
		} else {
			$sucess_code = "0000";
		}

		try {
			// 요청 파일 로그
			$this->added_payment->write_log($aParams['allat_order_no'], 'P', 'allat', 'receive', 'process0100', $aParams);

			// 필수 값 체크
			if ( ! $aParams['allat_order_no']) {
				throw new Exception('Require allat_order_no : [allat_order_no]' . $aParams['allat_order_no']);
			}

			// 결제 시작 마킹
			if ($aParams['allat_order_no']) {
				$reDepositSeq = $this->reDepositmodel->insert(
					array(
						'order_seq' =>  $aParams['allat_order_no'],
						'pg' => $this->config_system['pgCompany'],
						'params' => json_encode($aParams),
						'regist_date' => date('Y-m-d H:i:s')
					)
				);
			}

			$orders = $this->ordermodel->get_order($aParams['allat_order_no']);
			$result_shipping = $this->ordermodel->get_order_shipping($orders['order_seq']);
			$result_option = $this->ordermodel->get_item_option($orders['order_seq']);
			$result_suboption = $this->ordermodel->get_item_suboption($orders['order_seq']);

			if ( ! $orders['order_seq']) {
				throw new Exception('Require order : [order_seq]' . $orders['order_seq']);
			}

			if ($orders['pg_currency'] == 'KRW') {
				$orders['settleprice']	= floor($orders['settleprice']);
			}

			## 가격 검증
			if ($orders['settleprice'] != $aParams['allat_amt']) {
				$this->ordermodel->set_log($orders['order_seq'], 'pay', '시스템', '결제실패', "ALLAT 결제 실패". chr(10) . "[금액불일치]");
				throw new Exception('Payment Fail : [settleprice]' . $orders['settleprice'] . '[allat_amt]' . $aParams['allat_amt']);
			}

			## 주문 상태 검증
			if (preg_match('/virtual/', $orders['payment'])){
				if ($orders['step'] >= '15' && $orders['step'] <= '75') {
					throw new Exception('Wrong order status : [step]' . $orders['step'] . '[payment]' . $orders['payment']);
				}
			} else {
				if ($orders['step'] >= '25' && $orders['step'] <= '75') {
					throw new Exception('Wrong order status : [step]' . $orders['step'] . '[payment]' . $orders['payment']);
				}
			}

			if ($orders['orign_order_seq']) {
				$add_log = "[재주문]";
			}
			if ($orders['admin_order']) {
				$add_log = "[관리자주문]";
			}
			if ($orders['person_seq']) {
				$add_log = "[개인결제]";
			}

			$at_shop_id = $pg['mallCode'];
			if ($at_shop_id == "FM_allat_test01") {
				$at_shop_id = "allat_test01";
			}
			$at_txt = convert_to_utf8(
				ApprovalReq(
					"allat_shop_id=" . $at_shop_id .
					"&allat_amt=" . $orders['settleprice'] .
					"&allat_enc_data=" . $aParams["allat_enc_data"] .
					"&allat_cross_key=".$pg['merchantKey'], "SSL"
				), "UTF-8", "EUC-KR"
			);

			// 파일 로그
			$this->added_payment->write_log($aParams['allat_order_no'], 'P', 'allat', 'receive', 'process0200', $at_txt);

			// 결제 결과 값 확인
			foreach ($aResultField as $sfield) {
				$aResult[$sfield] = trim(getValue($sfield, $at_txt));
			}

			# 주문번호 중복 오류이면
			if (strcmp($aResult['reply_cd'], $sucess_code) ) {
				if ( ! in_array($aResult['reply_cd'], array("0431", "0606", "0865", "1256", "1310", "1355"))) {
					$this->ordermodel->set_step($orders['order_seq'], '99');
					$this->ordermodel->set_log($orders['order_seq'], 'pay', $orders['order_user_name'], '결제실패[' . $aResult['reply_cd'] . ']', "올엣 결제 실패" . chr(10)."[" . $aResult['reply_cd'] . $aResult['reply_msg'] . "]");
				}
				throw new Exception('Payment Fail : [reply_cd]' . $aResult['reply_cd']);
			} else {
				// 주문 결제수단 업데이트
				if ($aResult['pay_type']) {
					$order_payment = $r_use_pay_method[$aResult['pay_type']];
				}
				if ($aResult['escrow_yn'] == 'Y' && $order_payment) {
					$order_payment = 'escrow_'.$order_payment;
				}
				if ($order_payment) {
					$aOrderStep['payment'] = $order_payment;
				}

				// 회원 마일리지 차감
				if ($orders['emoney'] > 0 && $orders['member_seq'] && $orders['emoney_use'] == 'none') {
					$params = array(
						'gb' => 'minus',
						'type' => 'order',
						'emoney' => $orders['emoney'],
						'ordno' => $orders['order_seq'],
						'memo'		=> "[차감]주문 ({$orders['order_seq']})에 의한 마일리지 차감",
						'memo_lang'	=> $this->membermodel->make_json_for_getAlert("mp260", $orders['order_seq']), // [차감]주문 (%s)에 의한 마일리지 차감
					);
					$this->membermodel->emoney_insert($params, $orders['member_seq']);
					$this->ordermodel->set_emoney_use($orders['order_seq'],'use');
				}
				// 회원 예치금 차감
				if ($orders['cash'] > 0 && $orders['member_seq'] && $orders['cash_use'] == 'none') {
					$params = array(
							'gb' => 'minus',
							'type' => 'order',
							'cash' => $orders['cash'],
							'ordno' => $orders['order_seq'],
							'memo' => "[차감]주문 ({$orders['order_seq']})에 의한 예치금 차감",
							'memo_lang' => $this->membermodel->make_json_for_getAlert("mp261", $orders['order_seq']),   // [차감]주문 (%s)에 의한 예치금 차감
					);
					$this->membermodel->cash_insert($params, $orders['member_seq']);
					$this->ordermodel->set_cash_use($orders['order_seq'],'use');
				}

				//상품쿠폰사용
				if ($result_option) {
					foreach ($result_option as $item_option) {
						if ($item_option['download_seq']) {
							$this->couponmodel->set_download_use_status($item_option['download_seq'], 'used');
						}
					}
				}
				//배송비쿠폰사용
				if ($result_shipping) {
					foreach ($result_shipping as $shipping) {
						if ($shipping['shipping_coupon_down_seq']) {
							$this->couponmodel->set_download_use_status($shipping['shipping_coupon_down_seq'], 'used');
						}
					}
				}

				// 배송비 쿠폰사용 (사용안함)
				if ($orders['download_seq']) {
					$this->couponmodel->set_download_use_status($orders['download_seq'], 'used');
				}

				//주문서쿠폰 사용 처리 by hed
				if ($orders['ordersheet_seq']) {
					$this->couponmodel->set_download_use_status($orders['ordersheet_seq'], 'used');
				}

				//프로모션코드 상품/배송비 할인 사용처리
				$this->promotionmodel->setPromotionpayment($orders);

				// 장바구니 비우기
				if ($orders['mode']) {
					$this->cartmodel->delete_mode($orders['mode']);
				}

				$aOrderStep['pg_transaction_number'] = $aResult['seq_no'];
				$aOrderStep['pg_approval_number'] = $aResult['approval_no'];

				if (preg_match('/virtual/', $orders['payment'])){
					$aOrderStep['virtual_account'] = $aResult['bank_nm'] . " " . $aResult['account_no'] . " ". $aResult['account_nm'];
					$aOrderStep['virtual_date'] = $aResult['income_limit_ymd'];
					$this->ordermodel->set_step($orders['order_seq'], '15', $aOrderStep);
					$this->ordermodel->set_log($orders['order_seq'], 'pay', $orders['order_user_name'], $add_log . "주문접수(" . $orders['mpayment'] . ")", "주문접수" . chr(10) . "[" . $aResult['replycd'] . $aResult['replymsg'] . "]");
				} else {
					$this->coupon_reciver_sms = array();
					$this->coupon_order_sms = array();
					$this->ordermodel->set_step($orders['order_seq'], '25', $aOrderStep);
					$this->ordermodel->set_log($orders['order_seq'], 'pay', $orders['order_user_name'], $add_log . "결제확인(" . $orders['mpayment'] . ")", "결제확인" . chr(10) . "[" . $aResult['replycd'] . $aResult['replymsg'] . "]");

					// 계좌이체 결제의 경우 현금영수증
					if (preg_match('/account/', $orders['payment'])) {
						$result = typereceipt_setting($orders['order_seq']);
					}

					//티켓상품 자동 출고처리구문 순차진행을 위해 분리함 @2017-08-16
					ticket_payexport_ck($orders['order_seq']);

					//받는 사람 티켓상품 SMS 데이터
					if (count($this->coupon_reciver_sms['order_cellphone']) > 0) {
						$order_count = 0;
						foreach ($this->coupon_reciver_sms['order_cellphone'] as $key=>$value) {
							$coupon_arr_params[$order_count] = $this->coupon_reciver_sms['params'][$key];
							$coupon_order_no[$order_count] = $this->coupon_reciver_sms['order_no'][$key];
							$coupon_order_cellphones[$order_count] = $this->coupon_reciver_sms['order_cellphone'][$key];
							$order_count++;
						}
						$commonSmsData['coupon_released']['phone'] = $coupon_order_cellphones;;
						$commonSmsData['coupon_released']['params'] = $coupon_arr_params;
						$commonSmsData['coupon_released']['order_no'] = $coupon_order_no;
					}

					//주문자 티켓상품 SMS 데이터
					if (count($this->coupon_order_sms['order_cellphone']) > 0) {
						$order_count = 0;
						foreach ($this->coupon_order_sms['order_cellphone'] as $key=>$value) {
							$reciver_arr_params[$order_count] = $this->coupon_order_sms['params'][$key];
							$reciver_order_no[$order_count] = $this->coupon_order_sms['order_no'][$key];
							$reciver_order_cellphones[$order_count] = $this->coupon_order_sms['order_cellphone'][$key];
							$order_count++;
						}
						$commonSmsData['coupon_released2']['phone'] = $reciver_order_cellphones;;
						$commonSmsData['coupon_released2']['params'] = $reciver_arr_params;
						$commonSmsData['coupon_released2']['order_no'] = $reciver_order_no;
					}
					if (count($commonSmsData) > 0) {
						commonSendSMS($commonSmsData);
					}
				}

				// 해당 주문 상품의 출고예약량 업데이트
				if ($result_option) {
					foreach ($result_option as $data_option) {
						// 출고량 업데이트를 위한 변수정의
						if ( ! in_array($data_option['goods_seq'], $r_reservation_goods_seq)) {
							$r_reservation_goods_seq[] = $data_option['goods_seq'];
						}
					}
				}
				if ($result_suboption) {
					foreach ($result_suboption as $data_suboption) {
						// 출고량 업데이트를 위한 변수정의
						if ( ! in_array($data_suboption['goods_seq'],$r_reservation_goods_seq)) {
							$r_reservation_goods_seq[] = $data_suboption['goods_seq'];
						}
					}
				}
				// 출고예약량 업데이트
				foreach ($r_reservation_goods_seq as $goods_seq) {
					$this->goodsmodel->modify_reservation_real($goods_seq);
				}
			}
		} catch (Exception $e) {
			$this->added_payment->write_log($orders['order_seq'], 'P', 'allat', 'receive', 'process0300', array('errorMsg' => $e->getMessage())); // 파일 로그 저장
		}

		// 결제 종료 마킹
		if ($reDepositSeq) {
			$this->reDepositmodel->del(array('re_deposit_seq' => $reDepositSeq));
		}

		## 로그 저장
		$this->added_payment->set_pg_log(
			array(
				'pg' => 'allat',
				'order_seq' => $orders['order_seq'],
				'tno' => $aResult['seq_no'],
				'amount' => $aResult['amt'],
				'app_time' => $aResult['approval_ymdhms'],
				'app_no' => $aResult['approval_no'],
				'card_cd' => $aResult['card_id'],
				'card_name' => $aResult['card_nm'],
				'noinf' => $aResult['zerofee_yn'],
				'quota' => $aResult['sell_mm'],
				'bank_name' => $aResult['bank_nm'],
				'bank_code' => $aResult['bank_id'],
				'depositor' => $aResult['account_nm'],
				'biller' => $aResult['income_account_nm'],
				'account' => $aResult['account_no'],
				'commid' => $aResult['hp_id'],
				'va_date' => $aResult['income_limit_ymd'],
				'escw_yn' => $aResult['escrow_yn'],
				'res_cd' => $aResult['replycd'],
				'res_msg' => $aResult['replymsg']
			)
		);

		pageRedirect('../order/complete?no=' . $orders['order_seq'], '', 'parent');
		pageClose();
	}

	//조회
	public function status()
	{
		$this->send_for_provider = array();
		$providerList			= array();
		$pg						= $this->cfgPg;
		$at_cross_key 			= $pg['merchantKey'];

		$shopid					= $_POST['shop_id']; // 상점ID
		$order_seq				= $_POST['order_no']; // 주문번호
		$tx_seq_no				= $_POST['tx_seq_no']; // 거래일련번호
		$account_no				= $_POST['account_no']; // 가상계좌 계좌번호
		$bank_cd				= $_POST['bank_cd']; // 가상계좌 은행코드
		$common_bank_cd			= $_POST['common_bank_cd']; // 가상계좌 공동은행코드
		$apply_ymdhms			= $_POST['apply_ymdhms']; // 승인요청일
		$approval_ymdhms		= $_POST['approval_ymdhms']; // 가상계좌 채번일
		$income_ymdhms			= $_POST['income_ymdhms']; // 가상계좌 입금일
		$apply_amt				= $_POST['apply_amt']; // 채번금액
		$income_amt				= $_POST['income_amt']; // 입금금액
		$income_account_nm		= mb_convert_encoding($_POST['income_account_nm'],'UTF-8','EUC-KR'); // 입금자명
		$receipt_seq_no			= $_POST['receipt_seq_no']; // 현금영수증 일련번호
		$cash_approval_no		= $_POST['cash_approval_no']; // 현금영수증 승인번호
		$noti_currenttimemillis = $_POST['noti_currenttimemillis']; // 입금통보일
		$hash_value				= $_POST['hash_value']; // 해쉬 Data

		## 로그 저장
		$this->added_payment->set_pg_log(
			array(
				'pg' => 'allat',
				'order_seq' => $order_seq,
				'tno' => $tx_seq_no,
				'amount' => $income_amt,
				'bank_code' => $bank_cd,
				'depositor' =>  mb_convert_encoding($income_account_nm, "UTF-8", "EUC-KR"),
				'account' => $account_no
			)
		);

		## 주문 정보
		$orders = $this->ordermodel->get_order($order_seq);

		## 가격 검증
		if ($orders['pg_currency'] == 'KRW') {
			$orders['settleprice']	= floor($orders['settleprice']);
		}

		if ($orders['settleprice'] != $income_amt) {
			$this->ordermodel->set_log($orders['order_seq'], 'pay', '시스템', '결제실패', "ALLAT 결제 실패". chr(10)."[입금통보, 금액불일치]");
			echo "9999";
			exit;
		}

		// 해쉬데이터 검증
		$hash = md5($shopid . $at_cross_key . $order_seq . $noti_currenttimemillis);
		if ($hash != $hash_value) {
			echo "9999";
			exit;
		}

		// 쇼핑몰 디비 처리
		if ($cash_approval_no) { // 현금영수증 승인번호
			$data = array(
				'typereceipt' => 2,
				'cash_receipts_no' => $cash_approval_no
			);
		}

		if ($orders['step'] < '25' || $orders['step'] > '85') { // 결제이후 프로세스 진행 이후에는 결제확인 처리 하지 않음
			// sms 발송을 위한 변수 저장
			$this->coupon_reciver_sms = array();
			$this->coupon_order_sms = array();
			$this->send_for_provider = array();
			$this->ordermodel->set_step($order_seq,25,$data);
		}

		$add_log = "";
		if ($orders['orign_order_seq']) {
			$add_log = "[재주문]";
		}
		if ($orders['admin_order']) {
			$add_log = "[관리자주문]";
		}
		if ($orders['person_seq']) {
			$add_log = "[개인결제]";
		}
		$this->ordermodel->set_log($order_seq, 'pay', '시스템', $add_log . "결제확인(" . $orders['payment'] . ")", '');

		// 가상계좌 결제의 경우 현금영수증
		if ($orders['step'] < '25' || $orders['step'] > '85') {
			$result = typereceipt_setting($orders['order_seq']);
		}

		$result_option = $this->ordermodel->get_item_option($order_seq);
		$result_suboption = $this->ordermodel->get_item_suboption($order_seq);

		// 출고량 업데이트를 위한 변수선언
		$r_reservation_goods_seq = array();
		$providerList = array();

		// 해당 주문 상품의 출고예약량 업데이트
		if ($result_option) {
			foreach ($result_option as $data_option) {
				if ($data_option['provider_seq']) {
					$providerList[$data_option['provider_seq']]	= 1;
				}
				// 출고량 업데이트를 위한 변수정의
				if ( ! in_array($data_option['goods_seq'],$r_reservation_goods_seq)) {
					$r_reservation_goods_seq[] = $data_option['goods_seq'];
				}
			}
		}
		if ($result_suboption) {
			foreach ($result_suboption as $data_suboption) {
				// 출고량 업데이트를 위한 변수정의
				if ( ! in_array($data_suboption['goods_seq'],$r_reservation_goods_seq)) {
					$r_reservation_goods_seq[] = $data_suboption['goods_seq'];
				}
			}
		}

		// 출고예약량 업데이트
		foreach ($r_reservation_goods_seq as $goods_seq) {
			$this->goodsmodel->modify_reservation_real($goods_seq);
		}

		// 결제확인 sms발송
		send_mail_step25($orders['order_seq']);
		if ($orders['sms_25_YN'] != 'Y') {
			$params['shopName'] = $this->config_basic['shopName'];
			$params['ordno'] = $orders['order_seq'];
			$params['user_name'] = $orders['order_user_name'];
			if ($orders['order_cellphone']) {
				$commonSmsData['settle']['phone'][] = $orders['order_cellphone'];
				$commonSmsData['settle']['params'][] = $params;
				$commonSmsData['settle']['order_seq'][] = $orders['order_seq'];
			}
			sendSMS_for_provider('settle', $providerList, $params);
			//입점관리자 SMS 데이터
			if (count($this->send_for_provider['order_cellphone']) > 0) {
				$provider_count = 0;
				foreach ($this->send_for_provider['order_cellphone'] as $key => $value) {
					$provider_msg[$provider_count]				= $this->send_for_provider['msg'][$key];
					$provider_order_cellphones[$provider_count] = $this->send_for_provider['order_cellphone'][$key];
					$provider_count								= $provider_count+1;
				}
				$commonSmsData['provider']['phone']				= $provider_order_cellphones;
				$commonSmsData['provider']['msg']				= $provider_msg;
			}
			$this->db->where('order_seq', $orders['order_seq']);
			$this->db->update('fm_order', array('sms_25_YN'=>'Y'));
		}

		if ($orders['step'] < '25' || $orders['step'] > '85') {
			//티켓상품 자동 출고처리구문 순차진행을 위해 분리함 @2017-08-16
			ticket_payexport_ck($orders['order_seq']);
			//받는 사람 티켓상품 SMS 데이터
			if (count($this->coupon_reciver_sms['order_cellphone']) > 0) {
				$order_count = 0;
				foreach ($this->coupon_reciver_sms['order_cellphone'] as $key => $value) {
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
			if (count($this->coupon_order_sms['order_cellphone']) > 0) {
				$order_count = 0;
				foreach ($this->coupon_order_sms['order_cellphone'] as $key => $value) {
					$reciver_arr_params[$order_count] = $this->coupon_order_sms['params'][$key];
					$reciver_order_no[$order_count] = $this->coupon_order_sms['order_no'][$key];
					$reciver_order_cellphones[$order_count] = $this->coupon_order_sms['order_cellphone'][$key];
					$order_count++;
				}
				$commonSmsData['coupon_released2']['phone'] = $reciver_order_cellphones;;
				$commonSmsData['coupon_released2']['params'] = $reciver_arr_params;
				$commonSmsData['coupon_released2']['order_no'] = $reciver_order_no;
			}
		}
		if (count($commonSmsData) > 0) {
			commonSendSMS($commonSmsData);
		}

		echo "0000";
	}
}