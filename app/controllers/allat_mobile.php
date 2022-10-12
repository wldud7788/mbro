<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class allat_mobile extends front_base {
	public function __construct(){
		parent::__construct();
		$this->load->helper('order');
		$this->load->helper('shipping');
		$this->load->model('cartmodel');
		$this->load->model('ordermodel');
		$this->load->model('membermodel');
		$this->load->model('couponmodel');
		$this->load->model('promotionmodel');
		$this->load->model('goodsmodel');
		$this->load->library('added_payment');

		$this->cfgPg = config_load('allat');
	}

	public function allat()
	{
		header("Content-Type: text/html; charset=EUC-KR");

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
			$pg_param['allat_noint_quota'] = implode(',',$codes);
		}
		$pg_param['quotaopt']  = $pg['interestTerms'];

		$aPostParams = $this->input->post();

		$data_order = $this->ordermodel -> get_order($aPostParams['order_seq']);
		$goods_name = $aPostParams['goods_name'];
		$goods_seq = $aPostParams['goods_seq'];

		$payment = str_replace('escrow_','',$data_order['payment']);
		if(strstr($data_order['payment'],"escrow")){
			$pg_param['escorw']  = 1;
			$pg_param['payment'] = $payment;
		}else{
			$pg_param['escorw']  = 0;
			$pg_param['payment'] = $data_order['payment'];
		}

		if($pg['mallCode'] == "FM_allat_test01") $pg['mallCode'] = "allat_test01";
		$param['allat_shop_id']		= $pg['mallCode'];
		$param['allat_order_no']	= $data_order['order_seq'];
		if	($data_order['pg_currency'] == 'KRW')
			$data_order['settleprice']	= floor($data_order['settleprice']);
		$param['allat_amt']			= $data_order['settleprice'];
		$param['allat_pmember_id']	= "GUEST";
		if( $this->userInfo['userid'] && strlen($this->userInfo['userid']) < 20 ) $param['allat_pmember_id'] = $this->userInfo['userid'];
		$param['allat_product_cd']	= $goods_seq;
		$param['allat_product_nm']	= $goods_name;
		$param['allat_buyer_nm'] = $data_order['order_user_name'];
		$param['allat_recp_nm'] = $data_order['recipient_user_name'];
		if(function_exists('mb_strcut') === true) {
		    $param['allat_buyer_nm']	= mb_strcut($param['allat_buyer_nm'],0,20);
		    $param['allat_recp_nm']		= mb_strcut($param['allat_recp_nm'],0,20);
		}
		$param['allat_recp_addr']	= $data_order['recipient_address']." ".$data_order['recipient_address_detail'];

		if(trim($param['allat_recp_addr'])=="") {
			$param['allat_recp_addr']	= $data_order['order_user_name'];
		}

		$param['allat_card_yn'] 	= 'N';		//신용카드결제
		$param['allat_bank_yn'] 	= 'N';		//계좌이체결제
		$param['allat_abank_yn'] 	= 'N';		//계좌이체결제(모듈확인 필요할듯)
		$param['allat_vbank_yn'] 	= 'N';		//무통장(가상계좌)결제
		$param['allat_hp_yn'] 		= 'N';		//휴대폰결제
		$param['allat_ticket_yn']  	= 'N';	//상품권결제
		if($data_order['payment'] == 'card') $param['allat_card_yn'] = 'Y';
		if($data_order['payment'] == 'account' || $data_order['payment'] == 'escrow_account'){ $param['allat_bank_yn'] = 'Y'; $param['allat_abank_yn'] = 'Y'; }
		if($data_order['payment'] == 'virtual' || $data_order['payment'] == 'escrow_virtual') $param['allat_vbank_yn'] = 'Y';
		if($data_order['payment'] == 'cellphone') $param['allat_hp_yn'] = 'Y';

		$param['allat_zerofee_yn'] = 'Y';
		$param['allat_cash_yn'] = 'N';
		$param['allat_email_addr'] = $data_order['order_email'];
		$param['allat_product_img'] = $pg_param['goods_image'];
		$param['allat_real_yn'] = 'Y';
		$param['allat_abankes_yn'] = 'N';
		$param['allat_vbankes_yn'] = 'N';
		if($pg_param['payment'] == 'account' && $pg_param['escorw']) $param['allat_abankes_yn'] = 'Y';
		if($pg_param['payment'] == 'virtual' && $pg_param['escorw']) $param['allat_vbankes_yn'] = 'Y';
		$param['allat_test_yn']  = 'N';
		if( $pg['mallCode'] == 'FM_pgfreete2' ) $param['allat_test_yn']  = 'Y';

		$param['mobilenew'] = $aPostParams['mobilenew'];

		$param['comm_free_mny'] = $aPostParams['comm_free_mny'];
		$param['comm_tax_mny'] = $aPostParams['comm_tax_mny'] ? $aPostParams['comm_tax_mny'] : '0';
		$param['comm_vat_mny'] = $aPostParams['comm_vat_mny'] ? $aPostParams['comm_vat_mny'] : '0';
		$param['allat_tax_yn'] = $aPostParams['comm_tax_mny'] ? 'Y':'N';

		// 복합과세 처리
		if($param['comm_free_mny']){
			$param['allat_multi_amt'] = $param['comm_tax_mny']."|".$param['comm_vat_mny']."|".$param['comm_free_mny'];
		}

		foreach($param as $k => $data) $param[$k] = mb_convert_encoding($data,'EUC-KR','UTF-8');
		foreach($pg_param as $k => $data) $pg_param[$k] = mb_convert_encoding($data,'EUC-KR','UTF-8');

		$this->template->assign($param);
		$this->template->assign($pg_param);
		$this->template->template_dir = BASEPATH."../order";
		$this->template->compile_dir = BASEPATH."../_compile/";
		$this->template->define(array('tpl'=>'_allat_mobile.html'));
		$this->template->print_('tpl');
	}

	public function receive()
	{
		// 결과값
		$result_cd  = $_POST["allat_result_cd"];
		$result_msg = $_POST["allat_result_msg"];
		$enc_data   = $_POST["allat_enc_data"];

		if(trim($result_cd) == "9999"){
			$result_msg = "사용자 결제 취소";
		}

		// 결과값 Return
		echo "<script>parent.approval_submit('".$result_cd."','".$result_msg."','".$enc_data."');</script>";
	}

	public function approval()
	{
		$this->load->model('reDepositmodel');
		require ROOTPATH . 'pg/allat/allatutil.php';

		$pg	= $this->cfgPg;
		$aParams = $this->input->post();

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
		$r_use_pay_method = array(
			'CARD'=>'card',
			'ABANK'=>'account',
			'VBANK'=>'virtual',
			'HP'=>'cellphone'
		);

		if ($pg['mallCode'] == 'FM_pgfreete2') {
			$sucess_code = "0001";
		} else {
			$sucess_code = "0000";
		}

		$aParamsLog = $aParams;
		unset($aParamsLog['allat_product_nm'], $aParamsLog['allat_buyer_nm'], $aParamsLog['allat_recp_nm'], $aParamsLog['allat_recp_addr']);

		// 요청 파일 로그
		$this->added_payment->write_log($aParams['allat_order_no'], 'M', 'allat', 'approval', 'process0100', $aParamsLog);

		try {
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
			$result_option = $this->ordermodel->get_item_option($orders['order_seq']);
			$result_suboption = $this->ordermodel->get_item_suboption($orders['order_seq']);
			$result_shipping = $this->ordermodel->get_order_shipping($orders['order_seq']);

			if ( ! $orders['order_seq']) {
				throw new Exception('Require order : [order_seq]' . $orders['order_seq']);
			}

			## 가격 검증
			if ($orders['pg_currency'] == 'KRW') {
				$orders['settleprice']	= floor($orders['settleprice']);
			}
			if ($orders['settleprice'] != $aParams['allat_amt']) {
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

			if ( ! $orders['order_user_name']) {
				$orders['order_user_name'] = "주문자";
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
			$this->added_payment->write_log($orders['order_seq'], 'M', 'allat', 'approval', 'process0200', $at_txt);

			// 결제 결과 값 확인
			foreach ($aResultField as $sfield) {
				$aResult[$sfield] = trim(getValue($sfield, $at_txt));
			}

			if (strcmp($aResult['reply_cd'], $sucess_code)) {
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
					$order_payment = 'escrow_' . $order_payment;
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
						'memo' => "[차감]주문 (".$orders['order_seq'].")에 의한 마일리지 차감",
						'memo_lang'	=> $this->membermodel->make_json_for_getAlert("mp260", $orders['order_seq']), // [차감]주문 (%s)에 의한 마일리지 차감
					);
					$this->membermodel->emoney_insert($params, $orders['member_seq']);
					$this->ordermodel->set_emoney_use($orders['order_seq'], 'use');
				}
				// 회원 예치금 차감
				if ($orders['cash']>0 && $orders['member_seq'] && $orders['cash_use'] == 'none') {
					$params = array(
						'gb' => 'minus',
						'type' => 'order',
						'cash' => $orders['cash'],
						'ordno' => $orders['order_seq'],
						'memo' => "[차감]주문 (".$orders['order_seq'].")에 의한 예치금 차감",
						'memo_lang' => $this->membermodel->make_json_for_getAlert("mp261", $orders['order_seq']), // [차감]주문 (%s)에 의한 예치금 차감
					);
					$this->membermodel->cash_insert($params, $orders['member_seq']);
					$this->ordermodel->set_cash_use($orders['order_seq'], 'use');
				}
				//상품쿠폰사용
				if ($result_option) {
					foreach ($result_option as $item_option) {
						if ($item_option['download_seq']) {
							$this->couponmodel->set_download_use_status($item_option['download_seq'], 'used');
						}
					}
				}
				//배송비쿠폰사용 @2015-06-22 pjm
				if ($result_shipping) {
					foreach ($result_shipping as $shipping) {
						if ($shipping['shipping_coupon_down_seq']) {
							$this->couponmodel->set_download_use_status($shipping['shipping_coupon_down_seq'], 'used');
						}
					}
				}
				//배송비쿠폰사용(사용안함)
				if ($orders['download_seq']) {
					$this->couponmodel->set_download_use_status($orders['download_seq'], 'used');
				}
				//주문서쿠폰 사용 처리 by hed
				if ($orders['ordersheet_seq']) {
					$this->couponmodel->set_download_use_status($orders['ordersheet_seq'], 'used');
				}
				//프로모션코드 상품/배송비 할인 사용처리 @2017-01-23
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
					// sms 발송을 위한 변수 저장
					$this->coupon_reciver_sms = array();
					$this->coupon_order_sms = array();
					$this->send_for_provider = array();
					$this->ordermodel->set_step($orders['order_seq'], '25', $aOrderStep);
					$this->ordermodel->set_log($orders['order_seq'], 'pay', $orders['order_user_name'], $add_log . "결제확인(" . $orders['mpayment'] . ")", "결제확인" . chr(10) . "[" . $aResult['replycd'] . $aResult['replymsg'] . "]");

					// 계좌이체 결제의 경우 현금영수증
					if (preg_match('/account/', $orders['payment'])) {
						typereceipt_setting($orders['order_seq']);
					}

					//티켓상품 자동 출고처리구문 순차진행을 위해 분리함 @2017-08-16
					ticket_payexport_ck($orders['order_seq']);

					//받는 사람 티켓상품 SMS 데이터
					if (count($this->coupon_reciver_sms['order_cellphone']) > 0) {
						$order_count = 0;
						foreach($this->coupon_reciver_sms['order_cellphone'] as $key=>$value){
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
						foreach($this->coupon_order_sms['order_cellphone'] as $key=>$value){
							$reciver_arr_params[$order_count] = $this->coupon_order_sms['params'][$key];
							$reciver_order_no[$order_count] = $this->coupon_order_sms['order_no'][$key];
							$reciver_order_cellphones[$order_count] = $this->coupon_order_sms['order_cellphone'][$key];
							$order_count = $order_count+1;
						}
						$commonSmsData['coupon_released2']['phone'] = $reciver_order_cellphones;;
						$commonSmsData['coupon_released2']['params'] = $reciver_arr_params;
						$commonSmsData['coupon_released2']['order_no'] = $reciver_order_no;
					}
					if(count($commonSmsData) > 0){
						commonSendSMS($commonSmsData);
					}
				}

				// 출고량 업데이트를 위한 변수선언
				$r_reservation_goods_seq = array();

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
						if ( ! in_array($data_option['goods_seq'], $r_reservation_goods_seq)) {
							$r_reservation_goods_seq[] = $data_option['goods_seq'];
						}
					}
				}
				// 출고예약량 업데이트
				foreach ($r_reservation_goods_seq as $goods_seq) {
					$this->goodsmodel->modify_reservation_real($goods_seq);
				}
			}
		} catch (Exception $e) {
			$this->added_payment->write_log($orders['order_seq'], 'M', 'allat', 'approval', 'process0300', array('errorMsg' => $e->getMessage())); // 파일 로그 저장
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

		if ($aParams['mobilenew'] == "y") {
			pageRedirect('../order/complete?no=' . $orders['order_seq'], '', 'parent');
		} else {
			pageRedirect('../order/complete?no=' . $orders['order_seq'], '', 'opener');
			echo js("self.close();");
		}
	}
}