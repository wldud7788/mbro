<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class inicis_mobile extends front_base {
	public function __construct(){
		parent::__construct();
		$this->load->helper('order');
		$this->load->helper('shipping');
		$this->load->helper('readurl');

		$this->load->model('ordermodel');
		$this->load->model('refundmodel');
		$this->load->model('cartmodel');
		$this->load->model('membermodel');
		$this->load->model('couponmodel');
		$this->load->model('promotionmodel');
		$this->load->model('goodsmodel');
		$this->load->library('added_payment');

		$this->cfgPg = config_load($this->config_system['pgCompany']);
	}

	public function inicis()
	{
		Header('Content-Type: text/html; charset=EUC-KR');

		$pg = $this->cfgPg;

		if($pg['mobileNonInterestTerms'] == 'manual'){// 무이자 수동시 @2017-08-01
			if( isset($pg['mobileCardCompanyCode']) ){
				foreach($pg['mobileCardCompanyCode'] as $key => $code){
					$arr = explode(',',$pg['mobileCardCompanyTerms'][$key]);
					$terms = array();
					foreach($arr as $term){
						$terms[] = $term;
					}
					$codes[] = $code . '-' . implode(':',$terms);
					if($code == 'ALL'){
						$all_noint = implode(':',$terms);
					}
				}
				$param['inicis_noint_quota'] = implode('^',$codes);
			}
		}

		if( $all_noint ){
			$codes = array();
			$arr_tmp =  code_load('inicisCardCompanyCode');
			foreach($arr_tmp as $tmp_code) $arr[] = $tmp_code['codecd'];
			foreach($arr as $code){
				$codes[$code] = $code.'-'.$all_noint;
			}
			$param['inicis_noint_quota'] = implode('^',$codes);
		}

		if($pg['mobileInterestTerms']){
			for($i=1;$i<=$pg['mobileInterestTerms'];$i++){
				$arr_max_quota[] = sprintf('%02d',$i);
			}
			$param['inicis_max_quota'] = implode(':',$arr_max_quota);
		}

		$data_order = $this->ordermodel -> get_order($_POST['order_seq']);
		if	($data_order['pg_currency'] == 'KRW'){
			$data_order['settleprice']	= floor($data_order['settleprice']);
		}

		$param['goods_name'] = $_POST['goods_name'];
		$pg_param['quotaopt']  = $pg['mobileInterestTerms'];

		$param['mallCode'] = $pg['mallCode'];

		$payment = str_replace('escrow_','',$data_order['payment']);
		if($payment != $data_order['payment']){
			$pg_param['escorw'] = 1;
			$pg_param['payment'] = $payment;
			$param['useescrow'] = "Y";
			$param['mallCode'] = $pg['escrowMallCode'];
		}

		if( $param['mallCode']== 'GBF_INIpayTest' )	$param['mallCode']= "INIpayTest";				//gabia test
		if( $param['mallCode']== 'GBFINIpayTest' )	$param['mallCode']= "INIpayTest";				//gabia test

		foreach($param as $k => $data){
			if(!is_array($data)) $param[$k] = mb_convert_encoding($data, "EUC-KR", "UTF-8");
		}

		foreach($data_order as $k => $data){
			if(!is_array($data)) $data_order[$k] = mb_convert_encoding($data, "EUC-KR", "UTF-8");
		}
		$shopName = mb_convert_encoding($this->config_basic['shopName'], "EUC-KR", "UTF-8");

		$vat_price				= $data_order['settleprice'] - $data_order['freeprice'];
		$data_order['surtax']	= ($vat_price > 0) ? $vat_price - round($vat_price / 1.1) : 0;

		/* ################ 16.12.29 gcs 장다혜 : 가상계좌 사용시 입금기한 고정 s */
		$order_config = config_load('order');
		if($order_config['autocancel'] == 'y')
			$param['Vcard_date'] = date('Ymd',strtotime("+".$order_config['cancelDuration']." day", time()));
		/* ################ 16.12.29 gcs 장다혜 : 가상계좌 사용시 입금기한 고정 e */

		$this->template->template_dir = BASEPATH."../order";
		$this->template->compile_dir = BASEPATH."../_compile/";
		$this->template->assign("shopName",$shopName);
		$this->template->assign($param);
		$this->template->assign($data_order);
		$this->template->define(array('tpl'=>'_inicis_mobile.html'));
		$this->template->print_('tpl');
	}

	## ISP, 계좌이체, 가상계좌를 제외한 모든 지불 수단 사용
	## 가상계좌 채번(계좌발급)일때는 이곳에서 주문 처리
	## ISP일 경우 새창방지 설정으로 inicis_next 호출됨.
	## 단, GET으로  P_TID,P_REQ_URL,P_SATAUS 넘어옴.
	public function inicis_next()
	{
		header('Content-Type: text/html; charset=EUC-KR'); // PG 처리를 위해 문서 타입 설정

		$this->load->model('reDepositmodel');

		$pg = $this->cfgPg;
		$aPost = $this->input->post();
		$aGet = $this->input->get();
		$aPost['P_RMESG1'] = iconv('UTF-8', 'CP949//TRANSLIT', $aPost['P_RMESG1']);

		$aParams['P_OID'] = $aGet['P_NOTI'];
		if ($aPost['P_NOTI']) {
			$aParams['P_OID'] = $aPost['P_NOTI'];
		}
		$this->added_payment->write_log($aParams['P_OID'], 'M', 'inicis', 'inicis_next', 'process0100', $aPost);
		$this->added_payment->write_log($aParams['P_OID'], 'M', 'inicis', 'inicis_next', 'process0200', $aGet);

		$aResult = array();
		$r_reservation_goods_seq = array();
		$bDuplicateTransaction = false;
		$resultmsg = "결제 실패하였습니다.";

		// INICIS ISP 결제의 경우 GET 인지라 넘어오는 경우 대응
		$aParams['P_STATUS_R'] = $aGet['P_STATUS'];
		$aParams['P_RMESG1'] = $aGet['P_RMESG1'];
		$aParams['P_TID'] = $aGet['P_TID'];
		$aParams['P_REQ_URL'] = $aGet['P_REQ_URL'];
		$aParams['P_AMT'] = $aGet['P_AMT'];
		if ($aPost['P_STATUS']) {
			$aParams['P_STATUS_R'] = $aPost['P_STATUS'];
		}
		if ($aPost['P_RMESG1']) {
			$aParams['P_RMESG1'] = $aPost['P_RMESG1'];
		}
		if ($aPost['P_TID']) {
			$aParams['P_TID'] = $aPost['P_TID'];
		}
		if ($aPost['P_REQ_URL']) {
			$aParams['P_REQ_URL'] = $aPost['P_REQ_URL'];
		}
		if ($aPost['P_AMT']) {
			$aParams['P_AMT'] = $aPost['P_AMT'];
		}

		$data['P_MID'] = $pg['mallCode'];
		$data['P_TID'] = $aParams['P_TID'];
		if (strstr($data['P_TID'], $pg['escrowMallCode'])) {
			$data['P_MID'] = $pg['escrowMallCode'];
		}

		try {
			// 필수값 체크
			if ( ! $aParams['P_OID']) {
				throw new Exception('Require P_OID : [P_OID]' . $aParams['P_OID']);
			}
			if ( ! $data['P_MID']) {
				throw new Exception('Require P_MID : [P_MID]' . $aParams['P_MID']);
			}
			if ( ! $aParams['P_REQ_URL']) {
				throw new Exception('Require P_REQ_URL : [P_REQ_URL]' . $aParams['P_REQ_URL']);
			}

			$orders = $this->ordermodel->get_order($aParams['P_OID']); // 주문서 정보 가져오기
			$result_option = $this->ordermodel->get_item_option($orders['order_seq']);
			$result_suboption = $this->ordermodel->get_item_suboption($orders['order_seq']);
			$result_shipping = $this->ordermodel->get_order_shipping($orders['order_seq']);

			if ( ! $orders['order_seq']) {
				throw new Exception('Require order : [order_seq]' . $orders['order_seq']);
			}

			if ( ! $result_option) {
				throw new Exception('Require order option : [item_option_seq]' . $result_option[0]['item_option_seq']);
			}
			if ( ! $result_shipping) {
				throw new Exception('Require order shipping : [order shipping count]' . count($result_shipping));
			}

			// 주문서 결제처리 가능 여부
			if (preg_match('/virtual/', $orders['payment'])) {
				if ($orders['step'] >= '15' && $orders['step'] <= '75') {
					throw new Exception('Wrong order status : [step]' . $orders['step'] . '[payment]' . $orders['payment']);
				}
			} else {
				if ($orders['step'] >= '25' && $orders['step'] <= '75') {
					throw new Exception('Wrong order status : [step]' . $orders['step'] . '[payment]' . $orders['payment']);
				}
			}

			// 결제 시작 마킹
			$reDepositSeq = $this->reDepositmodel->insert(
				array(
					'order_seq' => $orders['order_seq'],
					'pg' => $this->config_system['pgCompany'],
					'params' => json_encode($aPost),
					'regist_date' => date('Y-m-d H:i:s')
				)
			);

			// 중복 결제 체크
			$this->added_payment->cfg['inicis'] = $pg;
			$aCheck = $this->added_payment->view('M', 'inicis', $orders['payment'], $orders['order_seq'], $orders['pg_transaction_number']);
			$this->added_payment->write_log($orders['order_seq'], 'M', 'inicis', 'inicis_next', 'process0300', $aCheck);

			if ($aCheck['success'] == 'Y'){
				if ($aCheck['paymethod']) $aCheck['payMethod'] = $aCheck['paymethod'];
				if (($aCheck['paymethod'] == 'VBank' && ($aCheck['status'] == 'Y' || $aCheck['status'] == 'N')) || ($aCheck['paymethod'] != 'VBank' && $aCheck['status'] == '0')) {
					$aResult['P_STATUS'] = '00';
					$aResult['P_TYPE'] = $aCheck['paymethod'];
					$aResult['P_AMT'] = $aCheck['price'];
					$aResult['P_TID'] = $aCheck['tid'];
					$aResult['P_AUTH_NO'] = $aCheck['applNum'];
					$aResult['P_AUTH_DT'] = $aCheck['applDate'];
					if ($aCheck['applTime']) {
						$aResult['P_AUTH_DT'] .= ' ' . $aCheck['applTime'];
					}
					$bDuplicateTransaction = true;
				}
			}

			// 결제요청 URL 에서 실결제 정보 읽어오기
			if (! $bDuplicateTransaction){
				$out = readurl($aParams['P_REQ_URL'], $data, false, 600);
				$this->added_payment->write_log($orders['order_seq'], 'M', 'inicis', 'inicis_next', 'process0400', $out);
				$aOut = explode('&', trim($out));
				foreach($aOut as $tmp){
					$aTmp = explode('=', $tmp);
					$aResult[$aTmp[0]] = $aTmp[1];
				}
			}
			$aResult['PageCall_time'] = date("H:i:s");
			$this->added_payment->write_log($orders['order_seq'], 'M', 'inicis', 'inicis_next', 'process0500', $aResult);

			$this->db->reconnect();

			if ($orders['pg_currency'] == 'KRW') {
				$orders['settleprice'] = floor($orders['settleprice']);
			}

			if ($aResult['P_TYPE'] == "VBANK" && $aResult['P_VACT_BANK_CODE']) {
				$aBank = code_load('inicisBankCode', $aResult['P_VACT_BANK_CODE']);
				$bank_name = $aBank[0]['value'];
			}

			$resultLog = array(
				'pg' => 'inicis',
				'order_seq' => $aParams['P_OID'],
				'tno' => $aResult['P_TID'],
				'amount' => $aResult['P_AMT'],
				'app_time' => $aResult['P_AUTH_DT'],
				'app_no' => $aResult['P_AUTH_NO'],
				'card_cd' => $aResult['P_FN_CD1'],
				'card_name' => convert_to_utf8($aResult['P_FN_NM']),
				'biller' => convert_to_utf8($aResult['P_UNAME']),
				'res_cd' => $aResult['P_STATUS'],
				'res_msg' => convert_to_utf8($aResult['P_RMESG1']) . " :: " . $aResult['P_RMESG2']
			);

			if ($aResult['P_TYPE'] == "BANK") {
				$resultLog['bank_name'] = convert_to_utf8($aResult['P_FN_NM']);
				$resultLog['bank_code'] = $aResult['P_FN_CD1'];
			} else if ($aResult['P_TYPE'] == "VBANK") {
				$resultLog['bank_name'] = $bank_name;
				$resultLog['bank_code'] = $aResult['P_VACT_BANK_CODE']; //가상계좌번호
				$resultLog['account'] = $aResult['P_VACT_NUM']; //가상계좌번호
				$resultLog['depositor'] = convert_to_utf8($aResult['P_VACT_NAME']); //계좌주명
			} else if ($aResult['P_TYPE'] == "CARD") {
				$resultLog['card_cd'] = $aResult['P_FN_CD1'];
				if ( ! $aResult['P_CARD_PURCHASE_NAME']) {
					$arr_card = code_load('inicisCardCompanyCode', $aResult['P_FN_CD1']);
					$aResult['P_CARD_PURCHASE_NAME'] = $arr_card[0]['value'];
				}
				$resultLog['card_name'] = $aResult['P_CARD_PURCHASE_NAME'];
				if ($aResult['P_CARD_ISSUER_NAME']) $resultLog['card_name'] .= "(".convert_to_utf8($aResult['P_CARD_ISSUER_NAME']).")";
				$resultLog['quota'] = (int) $aResult['P_RMESG2'];
			}

			if (! $bDuplicateTransaction && $orders['settleprice'] != $aResult['P_AMT'] && $aResult['P_TYPE'] != "VBANK" && $aParams['P_STATUS_R'] === "00" && $aResult['P_STATUS'] === "00"){
				$this->refundmodel->inicis_cancel($orders, array());
				$this->ordermodel->set_log($orders['order_seq'], 'pay', '시스템', '결제취소', 'INICIS 모바일 결제 취소'. chr(10).'[금액불일치]');
				$this->added_payment->set_pg_log($resultLog);
				throw new Exception('Cancel Wrong AMT : [settleprice]' . $orders['settleprice'] . '[P_AMT]' . $aResult['P_AMT'] . '[P_TYPE]' . $aResult['P_TYPE'] . '[P_STATUS_R]' . $aParams['P_STATUS_R'] . '[P_STATUS]' . $aResult['P_STATUS']);
			}

			if (! $orders['order_user_name']) {
				$orders['order_user_name'] = "주문자";
			}

			// 주문 처리
			if ( $aParams['P_STATUS_R'] === "00" && $aResult['P_STATUS'] === "00") {

				// 거래번호 업데이트
				$aModify = '';
				if ($aResult['P_TID']) {
					$aModify['pg_transaction_number'] = $aResult['P_TID'];
				}
				if ($aModify) {
					$this->db->update('fm_order', $aModify, array(
						'order_seq' => $orders['order_seq']
					));
				}

				// 주문 상태 처리
				if ($aResult['P_TYPE'] == "VBANK"){ // 가상계좌일때(주문접수)

					$virtual_account = $bank_name;
					if ($aResult['P_VACT_NUM']) {
						$virtual_account .= ' ' . $aResult['P_VACT_NUM'];
					}
					$data = array(
						'virtual_account' => $virtual_account,
						'virtual_date' => $aResult['P_VACT_DATE']
					);
					$this->ordermodel->set_step($orders['order_seq'], '15', $data);
					$log = "이니시스 가상계좌 주문접수" . chr(10) . implode(chr(10), $data);
					$this->ordermodel->set_log($orders['order_seq'], 'pay', $orders['order_user_name'], '주문접수', $log);
					$mail_step = '15';
				} else {
					$data = array(
						'pg_approval_number' => $aResult['P_AUTH_NO']
					);
					$this->ordermodel->set_step($orders['order_seq'], '25', $data);
					$log = "이니시스 결제 확인" . chr(10) . implode(chr(10), $data);
					$this->ordermodel->set_log($orders['order_seq'], 'pay', $orders['order_user_name'], '결제확인', $log);
					if (preg_match('/account/', $orders['payment'])) {
						typereceipt_setting($orders['order_seq']);
					}
					ticket_payexport_ck($orders['order_seq']);
					$mail_step = '25';
				}

				// 적립금 예치금 쿠폰 프로모션코드 처리
				if ($orders['emoney'] > 0 && $orders['member_seq'] && $orders['emoney_use'] == 'none') {
					$params = array(
						'gb' => 'minus',
						'type' => 'order',
						'emoney' => $orders['emoney'],
						'ordno' => $orders['order_seq'],
						'memo' => "[차감]주문 (" . $orders['order_seq'] . ")에 의한 마일리지 차감",
						'memo_lang' => $this->membermodel->make_json_for_getAlert("mp260", $orders['order_seq'])
					);
					$this->membermodel->emoney_insert($params, $orders['member_seq']);
					$this->ordermodel->set_emoney_use($orders['order_seq'], 'use');
				}
				if ($orders['cash'] > 0 && $orders['member_seq'] && $orders['cash_use'] == 'none') {
					$params = array(
						'gb' => 'minus',
						'type' => 'order',
						'cash' => $orders['cash'],
						'ordno' => $orders['order_seq'],
						'memo' => "[차감]주문 (" . $orders['order_seq'] . ")에 의한 예치금 차감",
						'memo_lang' => $this->membermodel->make_json_for_getAlert("mp261", $orders['order_seq'])
					);
					$this->membermodel->cash_insert($params, $orders['member_seq']);
					$this->ordermodel->set_cash_use($orders['order_seq'], 'use');
				}
				if ($result_option) foreach ($result_option as $item_option) {
					if ($item_option['download_seq']) $this->couponmodel->set_download_use_status($item_option['download_seq'], 'used');
				}
				if ($result_shipping) foreach ($result_shipping as $shipping) {
					if ($shipping['shipping_coupon_down_seq']) $this->couponmodel->set_download_use_status($shipping['shipping_coupon_down_seq'], 'used');
				}
				if ($orders['download_seq']) {
					$this->couponmodel->set_download_use_status($orders['download_seq'], 'used');
				}
				if ($orders['ordersheet_seq']) {
					$this->couponmodel->set_download_use_status($orders['ordersheet_seq'], 'used');
				}
				$this->promotionmodel->setPromotionpayment($orders);
				if ($orders['mode']) {
					$this->cartmodel->delete_mode($orders['mode']);
				}

				// 재고처리
				if ($result_option) {
					foreach ($result_option as $data_option) {
						if (! in_array($data_option['goods_seq'], $r_reservation_goods_seq)) {
							$r_reservation_goods_seq[] = $data_option['goods_seq'];
						}
					}
				}
				if ($result_suboption) {
					foreach ($result_suboption as $data_suboption) {
						if (! in_array($data_suboption['goods_seq'], $r_reservation_goods_seq)) {
							$r_reservation_goods_seq[] = $data_suboption['goods_seq'];
						}
					}
				}
				foreach ($r_reservation_goods_seq as $goods_seq) {
					$this->goodsmodel->modify_reservation_real($goods_seq);
				}

				// 메시지
				$commonSmsData = array();
				if ($mail_step == '25') {
					$this->coupon_reciver_sms = array();
					$this->coupon_order_sms = array();
					if (count($this->coupon_reciver_sms['order_cellphone']) > 0) {
						$order_count = 0;
						foreach(array_keys($this->coupon_reciver_sms['order_cellphone']) as $key){
							$coupon_arr_params[$order_count] = $this->coupon_reciver_sms['params'][$key];
							$coupon_order_no[$order_count] = $this->coupon_reciver_sms['order_no'][$key];
							$coupon_order_cellphones[$order_count] = $this->coupon_reciver_sms['order_cellphone'][$key];
							$order_count = $order_count + 1;
						}
						$commonSmsData['coupon_released']['phone'] = $coupon_order_cellphones;
						$commonSmsData['coupon_released']['params'] = $coupon_arr_params;
						$commonSmsData['coupon_released']['order_no'] = $coupon_order_no;
					}
					if (count($this->coupon_order_sms['order_cellphone']) > 0) {
						$order_count = 0;
						foreach(array_keys($this->coupon_order_sms['order_cellphone']) as $key){
							$reciver_arr_params[$order_count] = $this->coupon_order_sms['params'][$key];
							$reciver_order_no[$order_count] = $this->coupon_order_sms['order_no'][$key];
							$reciver_order_cellphones[$order_count] = $this->coupon_order_sms['order_cellphone'][$key];
							$order_count = $order_count + 1;
						}
						$commonSmsData['coupon_released2']['phone'] = $reciver_order_cellphones;
						$commonSmsData['coupon_released2']['params'] = $reciver_arr_params;
						$commonSmsData['coupon_released2']['order_no'] = $reciver_order_no;
					}
					if (count($commonSmsData) > 0) {
						commonSendSMS($commonSmsData);
					}
				}
				$resultmsg = "결제 성공하였습니다.";
			}

			// 결제 종료 마킹
			if ($reDepositSeq) {
				$this->reDepositmodel->del(array('re_deposit_seq' => $reDepositSeq));
			}

			// 상세 로그 저장
			$this->added_payment->set_pg_log($resultLog);

		} catch (Exception $e) {
			$resultmsg .= $e->getMessage();
			$this->added_payment->write_log($orders['order_seq'], 'M', 'inicis', 'inicis_next', 'process0600', array('errorMsg' => $resultmsg));
		}

		pageRedirect('../order/complete?no=' . $orders['order_seq'], $resultmsg, 'self');
	}

	# ISP, 계좌이체, 가상계좌(입금통보)만 사용

	public function inicis_rnoti()
	{
		//*******************************************************************************
		// FILE DESCRIPTION :
		// 이니시스 smart phone 결제 결과 수신 페이지 샘플
		// 기술문의 : ts@inicis.com
		// HISTORY
		// 2010. 02. 25 최초작성
		// 2010  06. 23 WEB 방식의 가상계좌 사용시 가상계좌 채번 결과 무시 처리 추가(APP 방식은 해당 없음!!)
		// WEB 방식일 경우 이미 P_NEXT_URL 에서 채번 결과를 전달 하였으므로,
		// 이니시스에서 전달하는 가상계좌 채번 결과 내용을 무시 하시기 바랍니다.
		//*******************************************************************************

		header('Content-Type: text/html; charset=EUC-KR'); // PG 처리를 위해 문서 타입 설정

		$this->db->reconnect();

		$PGIP = $_SERVER['REMOTE_ADDR'];
		$aPost = $this->input->post();
		$aPost['PGIP'] = $PGIP;

		## file log start
		$this->added_payment->write_log($aPost['P_OID'], 'M', 'inicis', 'inicis_rnoti', 'process0100', $aPost);
		## file log end

		try {
			// lks 20190212 허용 아이피 183.109.71.153, 203.238.37.15, 39.115.212.9, 211.219.96.165, 118.129.210.25 PG에서 보냈는지 IP로 체크
			if ( ! in_array($PGIP, array('211.219.96.165','118.129.210.25','183.109.71.153','203.238.37.15', '39.115.212.9'))) {
				throw new Exception('Wrong Request IP : [PGIP]' . $PGIP);
			}

			// 이니시스 NOTI 서버에서 받은 Value
			$P_TID = $aPost['P_TID']; // 거래번호
			$P_MID = $aPost['P_MID']; // 상점아이디
			$P_AUTH_DT = $aPost['P_AUTH_DT']; // 승인일자
			$P_STATUS = $aPost['P_STATUS']; // 거래상태 (00:성공, 01:실패)
			$P_TYPE = $aPost['P_TYPE']; // 지불수단
			$P_OID = $aPost['P_OID']; // 상점주문번호
			$P_FN_CD1 = $aPost['P_FN_CD1']; // 금융사코드1
			$P_FN_CD2 = $aPost['P_FN_CD2']; // 금융사코드2
			$P_FN_NM = $aPost['P_FN_NM']; // 금융사명 (은행명, 카드사명, 이통사명)
			$P_AMT = $aPost['P_AMT']; // 거래금액
			$P_UNAME = $aPost['P_UNAME']; // 결제고객성명
			$P_RMESG1 = $aPost['P_RMESG1']; // 결과코드
			$P_RMESG2 = $aPost['P_RMESG2']; // 결과메시지
			$P_NOTI = $aPost['P_NOTI']; // 노티메시지(상점에서 올린 메시지)
			$P_AUTH_NO = $aPost['P_AUTH_NO']; // 승인번호
			$P_SRC_CODE = $aPost['P_SRC_CODE']; // KPAY 결제

			// 필수값 체크
			if ( ! $P_OID) {
				throw new Exception('Wrong P_OID : [P_OID]' . $P_OID);
			}

			$orders	= $this->ordermodel->get_order($P_OID);
			$result_option = $this->ordermodel->get_item_option($P_OID);
			$result_suboption = $this->ordermodel->get_item_suboption($P_OID);
			$data_shipping = $this->ordermodel->get_order_shipping($P_OID);

			if ( ! $orders['order_seq']) {
				throw new Exception('Require order : [order_seq]' . $orders['order_seq']);
			}

			if ($orders['pg_currency'] == 'KRW') {
				$orders['settleprice'] = floor($orders['settleprice']);
			}

			## 가격 검증
			if($orders['settleprice'] != $P_AMT){
				$this->ordermodel->set_log($orders['order_seq'], 'pay', '시스템', '결제실패', 'INICIS 모바일 결제 실패' . chr(10) . '[금액불일치]');
				throw new Exception('Payment Fail : [P_AMT]' . $P_AMT . '[settleprice]' . $orders['settleprice']);
			}

			if ( ! $orders['order_user_name']) {
				$orders['order_user_name'] = '주문자';
			}

			if ($P_STATUS == '01' && $orders['step'] > '0') {
				echo 'OK';
				## file log start
				$this->added_payment->write_log($aPost['P_OID'], 'M', 'inicis', 'inicis_rnoti', 'process0200', array('P_STATUS' => $P_STATUS, 'step' => $orders['step']));
				## file log end
				exit;
			}

			if ($P_STATUS != '01' && (($orders['step'] >= '25' && $orders['step'] <= '85') || $orders['step'] == '99')){
				$P_RMESG1 = '실패';
				if ($P_STATUS == '00' || $P_STATUS == '02') {
					$P_RMESG1 = '성공';
				}
				echo 'OK';
				## file log start
				$this->added_payment->write_log($aPost['P_OID'], 'M', 'inicis', 'inicis_rnoti', 'process0300', array('P_STATUS' => $P_STATUS, 'step' => $orders['step']));
				## file log end
				exit;
			}

			// 상세 로그용 파라미터 세팅
			if ($P_TYPE == 'VBANK' || $P_TYPE == 'BANK') {
				$arr_bank = code_load('inicisBankCode', $P_FN_CD1);
				$bank_name = $arr_bank[0]['value'];
				$bank_code = $P_FN_CD1;
			}
			if ($P_TYPE == 'ISP') {
				$arr_card = code_load('inicisCardCompanyCode', $P_FN_CD1);
				$card_name = $arr_card[0]['value'];
				$card_cd = $P_FN_CD1;
				$quota = (int) $P_RMESG2;
			}
			$resultLog = array(
				'pg' => 'inicis',
				'order_seq' => $P_OID,
				'tno' => $P_TID,
				'amount' => $P_AMT,
				'app_time' => $P_AUTH_DT,
				'app_no' => $P_AUTH_NO,
				'card_name' => trim($card_name),
				'card_cd' => $card_cd,
				'quota' => $quota,
				'bank_name' => trim($bank_name),
				'bank_code' => $bank_code,
				'biller' => trim($P_UNAME),
				'res_cd' => $P_STATUS,
				'res_msg' => trim($P_RMESG1)
			);

			## ISP는 새창열림 방지 추가로 next 로 리턴 받음 2014-12-31 pjm
			## ISP 결재가 아니거나, ISP 결제이며 결제시도상태일떄 정상주문건으로 돌림.
			## P_SRC_CODE : A 경우에는 next 로 리턴받지 않아 noti 에서 처리 2019-04-19 2019-05-13 hyem
			if (($P_TYPE == 'ISP' && ($orders['step'] == '0' || $orders['step'] == '99')) || $P_SRC_CODE == 'A' || $P_TYPE != 'ISP') {
				if (($P_TYPE == 'VBANK' && $P_STATUS == '02') || ($P_TYPE != 'VBANK')) {
					$this->added_payment->set_pg_log($resultLog);
				}

				// 주문 처리(가상계좌는 접수시 처리)
				// P_SRC_CODE : A 경우에는 next 로 리턴받지 않아 noti 에서 처리 2019-04-19 2019-05-13 hyem
				if ($P_STATUS == '00' && ($P_SRC_CODE == 'A' || ($P_TYPE != 'ISP' && $P_TYPE != 'VBANK'))) {
					// 회원 마일리지 차감
					if ($orders['emoney'] > 0 && $orders['member_seq'] && $orders['emoney_use'] == 'none') {
						$params = array(
							'gb' => 'minus',
							'type' => 'order',
							'emoney' => $orders['emoney'],
							'ordno' => $P_OID,
							'memo' => '[차감]주문 (' . $P_OID . ')에 의한 마일리지 차감',
							'memo_lang'	=> $this->membermodel->make_json_for_getAlert('mp260', $P_OID) // [차감]주문 (%s)에 의한 마일리지 차감
						);
						$this->membermodel->emoney_insert($params, $orders['member_seq']);
						$this->ordermodel->set_emoney_use($P_OID, 'use');
					}
					// 회원 예치금 차감
					if ($orders['cash'] > 0 && $orders['member_seq'] && $orders['cash_use'] == 'none') {
						$params = array(
							'gb' => 'minus',
							'type' => 'order',
							'cash' => $orders['cash'],
							'ordno' => $P_OID,
							'memo' => '[차감]주문 (' . $P_OID . ')에 의한 예치금 차감',
							'memo_lang'	=> $this->membermodel->make_json_for_getAlert('mp261', $P_OID) // [차감]주문 (%s)에 의한 예치금 차감
						);
						$this->membermodel->cash_insert($params, $orders['member_seq']);
						$this->ordermodel->set_cash_use($P_OID, 'use');
					}

					// 상품쿠폰사용
					if ($result_option) {
						foreach($result_option as $item_option){
							if ($item_option['download_seq']) {
								$this->couponmodel->set_download_use_status($item_option['download_seq'], 'used');
							}
						}
					}

					// 배송비쿠폰사용 @2015-06-22 pjm
					if ($data_shipping) {
						foreach($data_shipping as $shipping){
							if ($shipping['shipping_coupon_down_seq']) {
								$this->couponmodel->set_download_use_status($shipping['shipping_coupon_down_seq'], 'used');
							}
						}
					}

					// 배송비쿠폰사용(사용안함)
					if ($orders['download_seq']) {
						$this->couponmodel->set_download_use_status($orders['download_seq'], 'used');
					}

					// 주문서쿠폰 사용 처리 by hed
					if ($orders['ordersheet_seq']) {
						$this->couponmodel->set_download_use_status($orders['ordersheet_seq'], 'used');
					}

					// 장바구니 비우기
					if ($orders['mode']) {
						$this->cartmodel->delete_mode($orders['mode']);
					}
				}

				// 결제 step 변경(성공코드 : 가상계좌 02, 그외는 00)
				// ISP 이중으로 결제확인 처리되어 예외처리함(next에서 처리되도록) 2018-09-10
				// P_SRC_CODE : A 경우에는 next 로 리턴받지 않아 noti 에서 처리 2019-04-19 2019-05-13 hyem
				if (
					($P_SRC_CODE == 'A' && $P_STATUS == '00') ||
					($P_TYPE == 'VBANK' && $P_STATUS == '02') ||
					($P_TYPE != 'VBANK' && $P_TYPE != 'ISP' && $P_STATUS == '00')
				) {
					$data = array(
						'pg_transaction_number' => $P_TID,
						'pg_approval_number' => $P_AUTH_NO
					);

					if ($P_TYPE == 'VBANK') {
						$orders['order_user_name'] .= '(자동)';
					}

					// sms 발송을 위한 변수 저장
					$this->coupon_reciver_sms = array();
					$this->coupon_order_sms = array();
					$this->send_for_provider = array();

					// 출고량 업데이트를 위한 변수선언
					$r_reservation_goods_seq = array();
					$providerList = array();

					$this->ordermodel->set_step($P_OID, '25', $data);
					$log = '이니시스 결제 확인' . chr(10) . implode(chr(10), $data);
					$this->ordermodel->set_log($P_OID, 'pay', $orders['order_user_name'], '결제확인', $log);
					$mail_step = '25';

					// 가상계좌 결제의 경우 현금영수증
					if ($orders['step'] < '25' || $orders['step'] > '85'){
						typereceipt_setting($orders['order_seq']);
					}

					if ($result_option) {
						foreach($result_option as $data_option) {
							if ($data_option['provider_seq']) {
								$providerList[$data_option['provider_seq']] = 1;
							}
							// 출고량 업데이트를 위한 변수정의
							if ( ! in_array($data_option['goods_seq'],$r_reservation_goods_seq)) {
								$r_reservation_goods_seq[] = $data_option['goods_seq'];
							}
						}
					}
					if ($result_suboption) {
						foreach($result_suboption as $data_suboption) {
							// 출고량 업데이트를 위한 변수정의
							if ( ! in_array($data_suboption['goods_seq'],$r_reservation_goods_seq)) {
								$r_reservation_goods_seq[] = $data_suboption['goods_seq'];
							}
						}
					}

					// 출고예약량 업데이트
					if ($r_reservation_goods_seq) {
						foreach($r_reservation_goods_seq as $goods_seq) {
							$this->goodsmodel->modify_reservation_real($goods_seq);
						}
					}

					/***********************************************************************************
					' 위에서 상점 데이터베이스에 등록 성공유무에 따라서 성공시에는 "OK"를 이니시스로 실패시는 "FAIL" 을
					' 리턴하셔야합니다. 아래 조건에 데이터베이스 성공시 받는 FLAG 변수를 넣으세요
					' (주의) OK를 리턴하지 않으시면 이니시스 지불 서버는 "OK"를 수신할때까지 계속 재전송을 시도합니다
					' 기타 다른 형태의 echo "" 는 하지 않으시기 바랍니다
					'***********************************************************************************/

					if ($mail_step == '25') {
						// 결제확인메일/sms 발송
						send_mail_step25($orders['order_seq']);
						if ($orders['sms_25_YN'] != 'Y'){
							$params['shopName'] = $this->config_basic['shopName'];
							$params['ordno'] = $orders['order_seq'];
							if($orders['order_cellphone']){
								$commonSmsData['settle']['phone'][] = $orders['order_cellphone'];
								$commonSmsData['settle']['params'][] = $params;
								$commonSmsData['settle']['order_seq'][] = $orders['order_seq'];
							}
							$this->db->where('order_seq', $orders['order_seq']);
							$this->db->update('fm_order', array('sms_25_YN'=>'Y'));
						}

						sendSMS_for_provider('settle', $providerList, $params);
						// 입점관리자 SMS 데이터
						if (count($this->send_for_provider['order_cellphone']) > 0) {
							$provider_count = 0;
							foreach($this->send_for_provider['order_cellphone'] as $key=>$value) {
								$provider_msg[$provider_count] = $this->send_for_provider['msg'][$key];
								$provider_order_cellphones[$provider_count] = $this->send_for_provider['order_cellphone'][$key];
								$provider_count = $provider_count+1;
							}
							$commonSmsData['provider']['phone'] = $provider_order_cellphones;
							$commonSmsData['provider']['msg'] = $provider_msg;
						}

						// 티켓상품 자동 출고처리구문 순차진행을 위해 분리함 @2017-08-16
						ticket_payexport_ck($orders['order_seq']);

						// 받는 사람 티켓상품 SMS 데이터
						if (count($this->coupon_reciver_sms['order_cellphone']) > 0) {
							$order_count = 0;
							foreach($this->coupon_reciver_sms['order_cellphone'] as $key=>$value) {
								$coupon_arr_params[$order_count] = $this->coupon_reciver_sms['params'][$key];
								$coupon_order_no[$order_count] = $this->coupon_reciver_sms['order_no'][$key];
								$coupon_order_cellphones[$order_count] = $this->coupon_reciver_sms['order_cellphone'][$key];
								$order_count = $order_count+1;
							}
							$commonSmsData['coupon_released']['phone'] = $coupon_order_cellphones;;
							$commonSmsData['coupon_released']['params'] = $coupon_arr_params;
							$commonSmsData['coupon_released']['order_no'] = $coupon_order_no;
						}

						// 주문자 티켓상품 SMS 데이터
						if (count($this->coupon_order_sms['order_cellphone']) > 0) {
							$order_count = 0;
							foreach($this->coupon_order_sms['order_cellphone'] as $key=>$value) {
								$reciver_arr_params[$order_count] = $this->coupon_order_sms['params'][$key];
								$reciver_order_no[$order_count] = $this->coupon_order_sms['order_no'][$key];
								$reciver_order_cellphones[$order_count] = $this->coupon_order_sms['order_cellphone'][$key];
								$order_count = $order_count+1;
							}
							$commonSmsData['coupon_released2']['phone'] = $reciver_order_cellphones;;
							$commonSmsData['coupon_released2']['params'] = $reciver_arr_params;
							$commonSmsData['coupon_released2']['order_no'] = $reciver_order_no;
						}
					}
					if (count($commonSmsData) > 0) {
						commonSendSMS($commonSmsData);
					}

					echo 'OK'; //절대로 지우지 마세요
					## file log start
					$this->added_payment->write_log($aPost['P_OID'], 'M', 'inicis', 'inicis_rnoti', 'process0400', array('P_STATUS' => $P_STATUS, 'step' => $orders['step'], 'P_SRC_CODE' => $P_SRC_CODE, 'P_SRC_CODE' => $P_TYPE));
					## file log end
				} else {
					// 가상계좌 주문접수일때
					// ISP 정상 결제일때 next 로 처리되고 이니시스측에 OK 떨어지도록 수정 :: 18-12-07 lkh
					if (($P_TYPE == 'VBANK' || $P_TYPE == 'ISP') && $P_STATUS == '00') {
						echo 'OK';
					} else {
						$aLog = array(
							'P_TID' => $P_TID,
							'P_MID' => $P_MID,
							'P_TYPE' => $P_TYPE,
							'P_FN_CD1' => $P_FN_CD1,
							'P_FN_CD2' => $P_FN_CD2,
							'P_OID' => $P_OID,
							'P_STATUS' => $P_STATUS,
							'P_RMESG1' => $P_RMESG1,
							'P_RMESG2' => $P_RMESG2,
							'PGIP' => $PGIP,
							'PageCall_time' => date('H:i:s'),
							'res' => '이니시스 결제 실패1',
							'ordr_idxx' => $P_OID
						);
						$this->added_payment->write_log($P_OID, 'M', 'inicis', 'inicis_rnoti', 'process0500', $aLog);

						if ($P_OID) {
							// ISP 결제에서 rnoti를 탄 경우에는 OK를 찍고 종료한다 :: 2019-05-13 rsh
							// ISP(KBANK가 아닌) 결제에서는 inicis_next() 를 호출해야함.
							if ($P_TYPE === 'ISP' && empty($P_SRC_CODE)) {
								echo 'OK';
								exit;
							}
							$data = array('log' => implode(chr(10), $aLog));
							$this->ordermodel->set_step($P_OID, '99', $data);
							$this->ordermodel->set_log($P_OID, 'pay', $orders['order_user_name'], '결제실패', $data['log']);
						}

						echo 'FAIL'; // P_TYPE : ".$P_TYPE." / P_STATUS : ".$P_STATUS;
					}
				}
			}
		} catch (Exception $e) {
			$errorMsg = $e->getMessage();
			echo 'FAIL';
			## file log start
			$this->added_payment->write_log($aPost['P_OID'], 'M', 'inicis', 'inicis_rnoti', 'process0600', array('errorMsg' => $errorMsg));
			## file log end
		}
	}

	## ISP , 계좌이체 등 돌아오는 페이지
	public function popup_return()
	{
		$aGetParams = $this->input->get();
		## file log start
		$aGetParams['PageCall_time'] = date("H:i:s");
		$aGetParams['PGIP'] = $_SERVER['REMOTE_ADDR'];
		## file log end

		$this->added_payment->write_log($aGetParams['order_seq'], 'M', 'inicis', 'popup_return', 'process0100', $aGetParams);
		pageRedirect('../order/complete?no=' . $aGetParams['order_seq'], '', 'self');
	}
}

// end file