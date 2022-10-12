<?php
/*
* kcp 크로스 브라우징 결제 모듈
* 2017-05-30 jhs create
* 수정될때 아래에 이력을 남겨주세요 (no. 날짜 이니셜 (내용))
* 1. 2017-06-19 jhs (상세 클래스 구현)
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class kcp extends front_base {

	protected $pg_param;

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

		$this->cfgPg = config_load($this->config_system['pgCompany']);
		$this->cfgOrder = config_load('order');
	}

	 /*
	 * [결제 인증요청 페이지(STEP2-1)]
	 *
	 */
	public function request()
	{
		session_start();
		$pg = $this->cfgPg;

		//app/order.php function pay에서 전달 해준 데이터
		$this->pg_param = json_decode(base64_decode($_POST["jsonParam"]),true);

		// #28841 settle_price 위변조 체크 19.02.12 kmj
		$settleSQL = "seLECT settleprice FROM fm_order WHERE order_seq = ?";
		$settle_price = $this->db->query($settleSQL, array($this->pg_param['order_seq']))->result_array();

		if( intval(floor($settle_price[0]['settleprice'])) !== intval($this->pg_param['settle_price']) ){
			echo("<script>alert('결제 금액이 일치하지 않습니다. 다시 한 번 시도해 주세요.');</script>");
			exit;
		}

		if($pg['nonInterestTerms'] == 'manual' &&  isset($pg['pcCardCompanyCode'])){
			foreach($pg['pcCardCompanyCode'] as $key => $code){
				$arr = explode(',',$pg['pcCardCompanyTerms'][$key]);
				$terms = array();
				foreach($arr as $term){
					$terms[] = sprintf('%02d',$term);
				}
				$codes[] = $code . '-' . implode(':',$terms);
			}
			$pg_param['kcp_noint_quota'] = implode(',',$codes);
		}
		$pg_param['quotaopt']  = $pg['interestTerms'];
		/* bin 디렉토리 전까지의 경로를 입력,절대경로 입력 */
		$pg_param['g_conf_home_dir']  = $_SERVER["DOCUMENT_ROOT"]."/pg/kcp/";
		$pg_param['g_conf_log_dir']   = $_SERVER["DOCUMENT_ROOT"]."/pg/kcp/log";          // log 절대경로 입력
		/* 테스트  : testpaygw.kcp.co.kr
		 * 실결제  : paygw.kcp.co.kr */
		$pg_param['g_conf_gw_url']    = $pg['mallCode']=='T0007' ? "testpaygw.kcp.co.kr" : "paygw.kcp.co.kr";
		/* 테스트  : https://pay.kcp.co.kr/plugin/payplus_test.js
		 * 실결제  : https://pay.kcp.co.kr/plugin/payplus.js */
		$pg_param['g_conf_js_url']	  = $pg['mallCode']=='T0007' ? "https://testpay.kcp.co.kr/plugin/payplus_web.jsp" : "https://pay.kcp.co.kr/plugin/payplus_web.jsp";
		/* 테스트 T0000 */
		$pg_param['g_conf_site_cd']   = $pg['mallCode'];
		/* 테스트 3grptw1.zW0GSo4PQdaGvsF__ */
		$pg_param['g_conf_site_key']  = $pg['merchantKey'];
		$pg_param['g_conf_site_name'] = $this->config_basic['shopName'];
		$pg_param['g_conf_log_level'] = "3";           // 변경불가
		$pg_param['g_conf_gw_port']   = "8090";        // 포트번호(변경불가)
		$pg_param['g_wsdl']			  = $pg['mallCode']=='T0007' ? "real_KCPPaymentService.wsdl" : "KCPPaymentService.wsdl";

		###
		$pg_param['kcp_logo_type']		= $pg['kcp_logo_type'];
		$pg_param['kcp_skin_color']		= $pg['kcp_skin_color'];
		if		($pg_param['kcp_logo_type'] == 'img' && !is_null($pg['kcp_logo_val_img'])){
			$pg_param['kcp_logo_val_img']	= $pg['kcp_logo_val_img'];
			$pg_param['kcp_logo_img']		= get_connet_protocol().$_SERVER['HTTP_HOST'].str_replace(ROOTPATH, '/', $pg['kcp_logo_val_img']);
		}elseif	($pg_param['kcp_logo_type'] == 'text' && !is_null($pg['kcp_logo_val_text'])){
			$pg_param['g_conf_site_name']	= $pg['kcp_logo_val_text'];
		}
		$pg_param = array_merge($pg_param,$this->pg_param);

		###
		$pg_param['comm_free_mny']	= $pg_param['freeprice'];
		$pg_param['comm_tax_mny']	= $pg_param['comm_tax_mny'];
		$pg_param['comm_vat_mny']	= $pg_param['comm_vat_mny'];

		$pg_param['goods_name'] = preg_replace('/[\s\#\&\+\-\%\@\=\/\:\;\,\.\'\"\^\`\~\_\|\!\?\*\$\#\<\>\(\)\[\]\{\}]/i', '', $pg_param['goods_name']);

		$orders = $this->ordermodel->get_order($this->pg_param['order_seq']);

		## 장바구니 상품정보
		$pg_param['good_info'] = "seq=1" . chr(31) . "ordr_numb=0001".chr(31)."good_name=".$pg_param['goods_name'].chr(31)."good_cntx=1".chr(31)."good_amtx=".$orders['settleprice'];

		$payment = str_replace('escrow_','',$pg_param['payment']);
		if($payment != $pg_param['payment']){
			$pg_param['escorw'] = 1;
			$pg_param['payment'] = $payment;
		}

		// 주문 무효일자 추출 :: 2015-08-10 lwh
		$order_cfg = $this->cfgOrder;
		if($order_cfg['autocancel'] == 'y'){
			$cancelDuration = $order_cfg['cancelDuration'];
		}

		// 모바일 일경우 모바일 결제창
		if( $this->_is_mobile_agent)
		{
			if($this->pg_param['mobilenew'] == 'y') $this->pg_open_script();
			echo("<form name='kcp_settle_form' method='post' target='tar_opener' action='../kcp_mobile/auth'>");
			echo("<input type='hidden' name='order_seq' value='".$this->pg_param['order_seq']."' />");
			echo("<input type='hidden' name='goods_name' value='".$this->pg_param['goods_name']."' />");
			echo("<input type='hidden' name='goods_seq' value='".$this->pg_param['goods_seq']."' />");
			echo("<input type='hidden' name='payment' value='".$this->pg_param['payment']."' />");
			echo("<input type='hidden' name='mobilenew' value='".$this->pg_param['mobilenew']."' />");
			echo("<input type='hidden' name='goods_info' value='".$this->pg_param['goods_info']."' />");
			echo("<input type='hidden' name='comm_free_mny' value='" . $this->pg_param['comm_free_mny'] . "' />");
			echo("<input type='hidden' name='comm_tax_mny' value='" . $this->pg_param['comm_tax_mny'] . "' />");
			echo("<input type='hidden' name='comm_vat_mny' value='" . $this->pg_param['comm_vat_mny'] . "' />");
			echo("</form>");
			echo("<script>document.kcp_settle_form.submit();</script>");
			exit;
		}

		$this->template->assign('cancelDuration',$cancelDuration);
		$this->template->assign($pg_param);
		$this->template->assign(array('data_order'=>$orders));
		$this->template->template_dir = BASEPATH."../order";
		$this->template->compile_dir	= BASEPATH."../_compile/";
		$this->template->define(array('tpl'=>'_kcp_nax.html'));
		$this->template->print_('tpl');

	}

	 /*
	 * [최종결제요청 페이지(STEP2-2)]
	 *
	 */
	public function receive()
	{
		header('Content-Type: text/html; charset=EUC-KR'); // PG 처리를 위해 문서 타입 설정

		require ROOTPATH . 'pg/kcp/sample/pp_ax_hub_lib.php'; // library [수정불가]
		$this->load->model('reDepositmodel');

		global $pg, $c_PayPlus;

		$pg = $this->cfgPg;
		$sLogType = '';
		$order_count = 0;
		$aOrderStep = array();
		$aKcpResult = array();
		$commonSmsData = array();
		$r_reservation_goods_seq = array();
		$aUsePayMethod = array(
			'100000000000'=>'card',
			'010000000000'=>'account',
			'001000000000'=>'virtual',
			'000010000000'=>'cellphone'
		);
		$this->coupon_order_sms = array();
		$this->coupon_reciver_sms = array();
		$aParams = $this->input->post();

		// 요청 파일 로그
		$aParamsLog = $aParams;
		foreach (array('good_name', 'buyr_name', 'rcvr_name', 'rcvr_add1', 'rcvr_add2', 'site_name', 'res_msg') as $sKey) {
			if ($aParams[$sKey]) {
				$aParamsLog[$sKey] = iconv('UTF-8', 'EUC-KR//TRANSLIT', $aParams[$sKey]);
			}
		}
		$this->added_payment->write_log($aParams['ordr_idxx'], 'P', 'kcp', 'receive', 'process0100', $aParamsLog);

		try {
			// 필수 값 체크
			if ( ! $aParams['ordr_idxx']) {
				throw new Exception('Require ordr_idxx : [ordr_idxx]' . $aParams['ordr_idxx']);
			}
			if ( ! $aParams['req_tx']) {
				throw new Exception('Require req_tx : [req_tx]' . $aParams['req_tx']);
			}
			if ( ! $aParams['good_mny']) {
				throw new Exception('Require good_mny : [good_mny]' . $aParams['good_mny']);
			}
			if ($aParams['req_tx'] == 'pay' && ! $aParams['enc_data']) {
				throw new Exception('Require enc_data : [enc_data]' . $aParams['enc_data']);
			}
			if ($aParams['req_tx'] == 'pay' && ! $aParams['enc_info']) {
				throw new Exception('Require enc_info : [enc_info]' . $aParams['enc_info']);
			}

			// 결제 시작 마킹
			if ($aParams['ordr_idxx']) {
				$reDepositSeq = $this->reDepositmodel->insert(
					array(
						'order_seq' =>  $aParams['ordr_idxx'],
						'pg' => $this->config_system['pgCompany'],
						'params' => json_encode($aParams),
						'regist_date' => date('Y-m-d H:i:s')
					)
				);
			}

			// 주문서 조회
			$orders	= $this->ordermodel->get_order($aParams['ordr_idxx']);
			$result_shipping = $this->ordermodel->get_order_shipping($orders['order_seq']);
			$result_option = $this->ordermodel->get_item_option($orders['order_seq']);
			$result_suboption = $this->ordermodel->get_item_suboption($orders['order_seq']);

			// 필수 값 체크
			if ( ! $orders['order_seq']) {
				throw new Exception('Require order : [order_seq]' . $orders['order_seq']);
			}
			if ($aParams['use_pay_method'] == '001000000000') {
				if ($orders['step'] >= '15' && $orders['step'] <= '75') {
					throw new Exception('Wrong order status : [step]' . $orders['step'] . '[use_pay_method]' . $aParams['use_pay_method']);
				}
			} else {
				if ($orders['step'] >= '25' && $orders['step'] <= '75') {
					throw new Exception('Wrong order status : [step]' . $orders['step'] . '[use_pay_method]' . $aParams['use_pay_method']);
				}
			}

			$g_conf_gw_url = $pg['mallCode']=='T0007' ? 'testpaygw.kcp.co.kr' : 'paygw.kcp.co.kr';
			$cust_ip = getenv('REMOTE_ADDR');
			$c_PayPlus = new C_PP_CLI;
			$c_PayPlus->mf_clear();

			if ($aParams['req_tx'] == 'pay') {
				/* 결제금액 유효성 검증 */
				$c_PayPlus->mf_set_ordr_data('ordr_mony', $orders['settleprice']);
				$c_PayPlus->mf_set_encx_data($aParams['enc_data'], $aParams['enc_info']);
			} else if ($aParams['req_tx'] == 'mod') { // 03-2. 취소/매입 요청
				$aParams['tran_cd'] = '00200000';
				$c_PayPlus->mf_set_modx_data('tno', $aParams['tno']); // KCP 원거래 거래번호
				$c_PayPlus->mf_set_modx_data('mod_type', $aParams['mod_type']); // 원거래 변경 요청 종류
				$c_PayPlus->mf_set_modx_data('mod_ip', $cust_ip); // 변경 요청자 IP
				$c_PayPlus->mf_set_modx_data('mod_desc', $aParams['mod_desc']); // 변경 사유
			} else if ($aParams['req_tx'] == 'mod_escrow') { // 03-3. 에스크로 상태변경 요청
				$aParams['tran_cd'] = '00200000';
				$c_PayPlus->mf_set_modx_data('tno', $aParams['tno']); // KCP 원거래 거래번호
				$c_PayPlus->mf_set_modx_data('mod_type', $aParams['mod_type']); // 원거래 변경 요청 종류
				$c_PayPlus->mf_set_modx_data('mod_ip', $cust_ip); // 변경 요청자 IP
				$c_PayPlus->mf_set_modx_data('mod_desc', $aParams['mod_desc']); // 변경 사유
				if ($aParams['mod_type'] == 'STE1') { // 상태변경 타입이 [배송요청]인 경우
					$c_PayPlus->mf_set_modx_data('deli_numb', $aParams['deli_numb']);   // 운송장 번호
					$c_PayPlus->mf_set_modx_data('deli_corp', $aParams['deli_corp']);   // 택배 업체명
				} else if ($aParams['mod_type'] == 'STE2' || $aParams['mod_type'] == 'STE4') { // 상태변경 타입이 [즉시취소] 또는 [취소]인 계좌이체, 가상계좌의 경우
					if ($aParams['vcnt_yn'] == 'Y') {
						$c_PayPlus->mf_set_modx_data('refund_account', $aParams['refund_account']); // 환불수취계좌번호
						$c_PayPlus->mf_set_modx_data('refund_nm', $aParams['refund_nm']); // 환불수취계좌주명
						$c_PayPlus->mf_set_modx_data('bank_code', $aParams['bank_code']); // 환불수취은행코드
					}
				}
			}

			if ($aParams['tran_cd'] != '' && $aParams['req_tx'] == 'pay') {
				$this->added_payment->write_log($orders['order_seq'], 'P', 'kcp', 'receive', 'process0200', array(null, ROOTPATH . 'pg/kcp/', $pg['mallCode'], $pg['merchantKey'], '00200000', null, $g_conf_gw_url, '8090', 'payplus_cli_slib', null, $cust_ip, '3', 0, null));
				$aCheckResult = $this->added_payment->view($orders['sitetype'], 'kcp', $orders['payment'], $orders['order_seq'], $orders['pg_transaction_number']);
				$this->added_payment->write_log($orders['order_seq'], 'P', 'kcp', 'receive', 'process0300', $aCheckResult);
				if ($aCheckResult['m_res_data']['res_cd'] == '0000') {
					$c_PayPlus->m_res_cd = $aCheckResult['m_res_data']['res_cd'];
					$c_PayPlus->m_res_msg = $aCheckResult['m_res_data']['res_msg'];
				} else {
					$aKcpRequest = array(null, ROOTPATH . 'pg/kcp/', $pg['mallCode'], $pg['merchantKey'], $aParams['tran_cd'], null, $g_conf_gw_url, '8090', 'payplus_cli_slib', $orders['order_seq'], $cust_ip, '3', 0, 0);
					$this->added_payment->write_log($orders['order_seq'], 'P', 'kcp', 'receive', 'process0400', $aKcpRequest);
					$c_PayPlus->mf_do_tx($aKcpRequest[0], $aKcpRequest[1], $aKcpRequest[2], $aKcpRequest[3], $aKcpRequest[4], $aKcpRequest[5], $aKcpRequest[6], $aKcpRequest[7], $aKcpRequest[8], $aKcpRequest[9], $aKcpRequest[10], $aKcpRequest[11], $aKcpRequest[12], $aKcpRequest[13]);
				}
			} else {
				$c_PayPlus->m_res_cd  = '9562';
				$c_PayPlus->m_res_msg = '연동 오류|Payplus Plugin이 설치되지 않았거나 tran_cd값이 설정되지 않았습니다.';
				throw new Exception('Payment Fail : [tran_cd]' . $aParams['tran_cd'] . '[req_tx]' . $aParams['req_tx']);
			}
			$aKcpResult['res_cd'] = $c_PayPlus->m_res_cd;
			$aKcpResult['res_msg'] = $c_PayPlus->m_res_msg;
			$sResMsgUtf8 = convert_to_utf8($c_PayPlus->m_res_msg);

			if ($aParams['req_tx'] == 'pay') {
				if ($aKcpResult['res_cd'] == '0000') {
					$aKcpResult['tno'] = $c_PayPlus->mf_get_res_data('tno'); // KCP 거래 고유 번호
					$aKcpResult['amount'] = $c_PayPlus->mf_get_res_data('amount'); // KCP 실제 거래 금액
					$aKcpResult['pnt_issue'] = $c_PayPlus->mf_get_res_data('pnt_issue'); // 결제 포인트사 코드
					if ($aParams['use_pay_method'] == '100000000000') { // 05-1. 신용카드 승인 결과 처리
						$aKcpResult['card_cd'] = $c_PayPlus->mf_get_res_data('card_cd'); // 카드사 코드
						$aKcpResult['card_name'] = $c_PayPlus->mf_get_res_data('card_name'); // 카드사 명
						$aKcpResult['app_time'] = $c_PayPlus->mf_get_res_data('app_time'); // 승인시간
						$aKcpResult['app_no'] = $c_PayPlus->mf_get_res_data('app_no'); // 승인번호
						$aKcpResult['noinf'] = $c_PayPlus->mf_get_res_data('noinf'); // 무이자 여부
						$aKcpResult['quota'] = $c_PayPlus->mf_get_res_data('quota'); // 할부 개월 수
						if ($aKcpResult['pnt_issue'] == 'SCSK' || $aKcpResult['pnt_issue'] == 'SCWB') { // 05-1.1. 복합결제(포인트+신용카드) 승인 결과 처리
							$aKcpResult['pt_idno'] = $c_PayPlus->mf_get_res_data('pt_idno'); // 결제 및 인증 아이디
							$aKcpResult['pnt_amount'] = $c_PayPlus->mf_get_res_data('pnt_amount'); // 마일리지액 or 사용금액
							$aKcpResult['pnt_app_time'] = $c_PayPlus->mf_get_res_data('pnt_app_time'); // 승인시간
							$aKcpResult['pnt_app_no'] = $c_PayPlus->mf_get_res_data('pnt_app_no'); // 승인번호
							$aKcpResult['add_pnt'] = $c_PayPlus->mf_get_res_data('add_pnt'); // 발생 포인트
							$aKcpResult['use_pnt'] = $c_PayPlus->mf_get_res_data('use_pnt'); // 사용가능 포인트
							$aKcpResult['rsv_pnt'] = $c_PayPlus->mf_get_res_data('rsv_pnt'); // 총 누적 포인트
							$aKcpResult['total_amount'] = $aKcpResult['amount'] + $aKcpResult['pnt_amount']; // 복합결제시 총 거래금액
						}
					}
					if ($aParams['use_pay_method'] == '010000000000') { // 05-2. 계좌이체 승인 결과 처리
						$aKcpResult['app_time'] = $c_PayPlus->mf_get_res_data('app_time');  // 승인 시간
						$aKcpResult['bank_name'] = $c_PayPlus->mf_get_res_data('bank_name');  // 은행명
						$aKcpResult['bank_code'] = $c_PayPlus->mf_get_res_data('bank_code');  // 은행코드
					}
					if ($aParams['use_pay_method'] == '001000000000') { // 05-3. 가상계좌 승인 결과 처리
						$aKcpResult['bankname'] = $c_PayPlus->mf_get_res_data('bankname'); // 입금할 은행 이름
						$aKcpResult['depositor'] = $c_PayPlus->mf_get_res_data('depositor'); // 입금할 계좌 예금주
						$aKcpResult['account'] = $c_PayPlus->mf_get_res_data('account'); // 입금할 계좌 번호
						$aKcpResult['va_date'] = $c_PayPlus->mf_get_res_data('va_date'); // 가상계좌 입금마감시간
					}
					if ($aParams['use_pay_method'] == '000100000000') { // 05-4. 포인트 승인 결과 처리
						$aKcpResult['pt_idno'] = $c_PayPlus->mf_get_res_data('pt_idno'); // 결제 및 인증 아이디
						$aKcpResult['pnt_amount'] = $c_PayPlus->mf_get_res_data('pnt_amount'); // 마일리지액 or 사용금액
						$aKcpResult['pnt_app_time'] = $c_PayPlus->mf_get_res_data('pnt_app_time'); // 승인시간
						$aKcpResult['pnt_app_no'] = $c_PayPlus->mf_get_res_data('pnt_app_no'); // 승인번호
						$aKcpResult['add_pnt'] = $c_PayPlus->mf_get_res_data('add_pnt'); // 발생 포인트
						$aKcpResult['use_pnt'] = $c_PayPlus->mf_get_res_data('use_pnt'); // 사용가능 포인트
						$aKcpResult['rsv_pnt'] = $c_PayPlus->mf_get_res_data('rsv_pnt'); // 총 누적 포인트
					}
					if ($aParams['use_pay_method'] == '000010000000') { // 05-5. 휴대폰 승인 결과 처리
						$aKcpResult['app_time'] = $c_PayPlus->mf_get_res_data('hp_app_time'); // 승인 시간
						$aKcpResult['commid'] = $c_PayPlus->mf_get_res_data('commid'); // 통신사 코드
						$aKcpResult['mobile_no'] = $c_PayPlus->mf_get_res_data('mobile_no'); // 휴대폰 번호
					}
					if ($aParams['use_pay_method'] == '000000001000') { // 05-6. 상품권 승인 결과 처리
						$aKcpResult['app_time'] = $c_PayPlus->mf_get_res_data('tk_app_time'); // 승인 시간
						$aKcpResult['tk_van_code'] = $c_PayPlus->mf_get_res_data('tk_van_code'); // 발급사 코드
						$aKcpResult['tk_app_no'] = $c_PayPlus->mf_get_res_data('tk_app_no'); // 승인 번호
					}
					$aKcpResult['cash_authno'] = $c_PayPlus->mf_get_res_data('cash_authno'); // 현금 영수증 승인 번호
				}
				$aKcpResult['escw_yn'] = $c_PayPlus->mf_get_res_data('escw_yn'); // 에스크로 여부

				$this->added_payment->write_log($orders['order_seq'], 'P', 'kcp', 'receive', 'process0500', $aKcpResult);
				$this->db->reconnect();

				// 주문 DB 처리
				if ($orders['orign_order_seq']) {
					$sLogType = '[재주문]';
				}
				if ($orders['admin_order']) {
					$sLogType = '[관리자주문]';
				}
				if ($orders['person_seq']) {
					$sLogType = '[개인결제]';
				}
				if ($aParams['use_pay_method']) {
					$order_payment = $aUsePayMethod[$aParams['use_pay_method']];
				}
				if ($aKcpResult['escw_yn'] == 'Y' && $order_payment) {
					$order_payment = 'escrow_' . $order_payment;
				}
				if ($order_payment) {
					$aOrderStep['payment'] = $order_payment;
				}

				if($aKcpResult['res_cd'] != '0000') {
					if ($orders['step'] < '15' || $orders['step'] > '75') {
						$this->ordermodel->set_step($orders['order_seq'], '99', $aOrderStep);
					}
					$this->ordermodel->set_log($orders['order_seq'], 'pay', $orders['order_user_name'], '결제실패[' . $aKcpResult['res_cd'] . ']', 'KCP 결제 실패' . chr(10) . '[' . $aKcpResult['res_cd'] . $sResMsgUtf8 . ']');
					throw new Exception('Payment Fail : [order_seq]' . $orders['order_seq'] . '[res_cd]' . $aKcpResult['res_cd'] . '[step]' . $orders['step']);
				} else {
					if ($orders['emoney'] > 0 && $orders['member_seq'] && $orders['emoney_use'] == 'none') { // 회원 마일리지 차감
						$sMemo = '[차감]주문 (' . $orders['order_seq'] . ')에 의한 마일리지 차감';
						$aEmoney = array(
							'gb' => 'minus',
							'type' => 'order',
							'emoney' => $orders['emoney'],
							'ordno' => $orders['order_seq'],
							'memo' => $sMemo,
							'memo_lang' => $this->membermodel->make_json_for_getAlert('mp260', $orders['order_seq']) // [차감]주문 (%s)에 의한 마일리지 차감
						);
						$this->membermodel->emoney_insert($aEmoney, $orders['member_seq']);
						$this->ordermodel->set_emoney_use($orders['order_seq'], 'use');
					}
					if ($orders['cash'] > 0 && $orders['member_seq'] && $orders['cash_use'] == 'none') { // 회원 예치금 차감
						$sMemo = '[차감]주문 (' . $orders['order_seq'] . ')에 의한 예치금 차감';
						$aCash = array(
							'gb' => 'minus',
							'type' => 'order',
							'cash' => $orders['cash'],
							'ordno' => $orders['order_seq'],
							'memo' => $sMemo,
							'memo_lang' => $this->membermodel->make_json_for_getAlert('mp261', $orders['order_seq']) // [차감]주문 (%s)에 의한 예치금 차감
						);
						$this->membermodel->cash_insert($aCash, $orders['member_seq']);
						$this->ordermodel->set_cash_use($orders['order_seq'], 'use');
					}
					if ($result_option) { // 상품쿠폰사용
						foreach ($result_option as $item_option) {
							if ($item_option['download_seq']) {
								$this->couponmodel->set_download_use_status($item_option['download_seq'], 'used');
							}
						}
					}
					if ($result_shipping) { // 배송비쿠폰사용
						foreach($result_shipping as $shipping) {
							if ($shipping['shipping_coupon_down_seq']) {
								$this->couponmodel->set_download_use_status($shipping['shipping_coupon_down_seq'], 'used');
							}
						}
					}
					if ($orders['download_seq']) { // 배송비쿠폰사용(사용안함)
						$this->couponmodel->set_download_use_status($orders['download_seq'], 'used');
					}
					if ($orders['ordersheet_seq']) { // 주문서쿠폰 사용 처리 by hed
						$this->couponmodel->set_download_use_status($orders['ordersheet_seq'], 'used');
					}
					$this->promotionmodel->setPromotionpayment($orders); // 프로모션코드 상품/배송비 할인 사용처리
					if ($orders['mode']){ // 장바구니 비우기
						$this->cartmodel->delete_mode($orders['mode']);
					}
					$aOrderStep['pg_transaction_number'] = $aKcpResult['tno'];
					$aOrderStep['pg_approval_number'] = $aKcpResult['app_no'];
					if ($aParams['use_pay_method'] == '001000000000') { // 06-1-3. 가상계좌
						$aOrderStep['virtual_account'] = convert_to_utf8($aKcpResult['bankname'] . ' ' . $aKcpResult['account'] . ' ' . $aKcpResult['depositor']);
						$aOrderStep['virtual_date'] = $aKcpResult['va_date'];
						if ($aKcpResult['cash_authno']) { // 현금영수증발급
							$aOrderStep['typereceipt'] = '2';
							$aOrderStep['cash_receipts_no'] = $aKcpResult['cash_authno'];
						}
						$this->ordermodel->set_step($orders['order_seq'], '15', $aOrderStep);
						$this->ordermodel->set_log($orders['order_seq'], 'pay', $orders['order_user_name'], $sLogType . '주문접수(' . $orders['mpayment'] . ')', 'KCP 가상계좌 주문접수' . chr(10) . '[' . $aKcpResult['res_cd'] . $sResMsgUtf8 . ']' . chr(10) . implode(chr(10), $aOrderStep));
					} else {
						if ($aKcpResult['cash_authno']) { // PG모듈에서 현금영수증발급시
							$aOrderStep['typereceipt'] = '2';
							$aOrderStep['cash_receipts_no'] = $aKcpResult['cash_authno'];
						}
						$this->ordermodel->set_step($orders['order_seq'], '25', $aOrderStep);
						$this->ordermodel->set_log($orders['order_seq'], 'pay', $orders['order_user_name'], $sLogType . '결제확인(' . $orders['mpayment'] . ')', 'KCP 결제 확인'. chr(10) . '[' .$aKcpResult['res_cd'] . $sResMsgUtf8 . ']' . chr(10). implode(chr(10), $aOrderStep));

						if (preg_match('/account/', $orders['payment'])) { // 계좌이체 결제의 경우 현금영수증
							$result = typereceipt_setting($orders['order_seq']);
						}
						ticket_payexport_ck($orders['order_seq']); // 티켓상품 자동 출고처리구문 순차진행을 위해 분리함 @2017-08-16
						if (count($this->coupon_reciver_sms['order_cellphone']) > 0) { // 받는 사람 티켓상품 SMS 데이터
							$order_count = 0;
							foreach ($this->coupon_reciver_sms['order_cellphone'] as $key => $value) {
								$coupon_arr_params[$order_count] = $this->coupon_reciver_sms['params'][$key];
								$coupon_order_no[$order_count] = $this->coupon_reciver_sms['order_no'][$key];
								$coupon_order_cellphones[$order_count] = $this->coupon_reciver_sms['order_cellphone'][$key];
								$order_count = $order_count + 1;
							}
							$commonSmsData['coupon_released']['phone'] = $coupon_order_cellphones;;
							$commonSmsData['coupon_released']['params'] = $coupon_arr_params;
							$commonSmsData['coupon_released']['order_no'] = $coupon_order_no;
						}
						if (count($this->coupon_order_sms['order_cellphone']) > 0) { // 주문자 티켓상품 SMS 데이터
							$order_count = 0;
							foreach ($this->coupon_order_sms['order_cellphone'] as $key => $value) {
								$reciver_arr_params[$order_count] = $this->coupon_order_sms['params'][$key];
								$reciver_order_no[$order_count] = $this->coupon_order_sms['order_no'][$key];
								$reciver_order_cellphones[$order_count] = $this->coupon_order_sms['order_cellphone'][$key];
								$order_count = $order_count + 1;
							}
							$commonSmsData['coupon_released2']['phone'] = $reciver_order_cellphones;;
							$commonSmsData['coupon_released2']['params'] = $reciver_arr_params;
							$commonSmsData['coupon_released2']['order_no'] = $reciver_order_no;
						}
						if (count($commonSmsData) > 0) {
							commonSendSMS($commonSmsData);
						}
					}
					if ($result_option) { // 해당 주문 상품의 출고예약량 업데이트
						foreach ($result_option as $data_option) {
							if ( ! in_array($data_option['goods_seq'], $r_reservation_goods_seq)) {
								$r_reservation_goods_seq[] = $data_option['goods_seq'];
							}
						}
					}
					if ($result_suboption) {
						foreach ($result_suboption as $data_suboption) {
							if( ! in_array($data_suboption['goods_seq'], $r_reservation_goods_seq)){
								$r_reservation_goods_seq[] = $data_suboption['goods_seq'];
							}
						}
					}
					foreach ($r_reservation_goods_seq as $goods_seq) { // 출고예약량 업데이트
						$this->goodsmodel->modify_reservation_real($goods_seq);
					}
				}
			}
		} catch (Exception $e) {
			$this->added_payment->write_log($orders['order_seq'], 'P', 'kcp', 'receive', 'process0600', array('errorMsg' => $e->getMessage())); // 파일 로그 저장
		}

		// 결제 종료 마킹
		if ($reDepositSeq) {
			$this->reDepositmodel->del(array('re_deposit_seq' => $reDepositSeq));
		}

		## 로그 저장
		$this->added_payment->set_pg_log(
			array(
				'pg' => 'kcp',
				'order_seq' => $orders['order_seq'],
				'tno' => $aKcpResult['tno'],
				'amount' => $aKcpResult['amount'],
				'card_cd' => $aKcpResult['card_cd'],
				'card_name' => convert_to_utf8($aKcpResult['card_name']),
				'app_no' => $aKcpResult['app_no'],
				'app_time' => $aKcpResult['app_time'],
				'noinf' => $aKcpResult['noinf'],
				'quota' => $aKcpResult['quota'],
				'bank_code' => $aKcpResult['bank_code'],
				'bank_name' => $aParams['use_pay_method'] == '001000000000' ? convert_to_utf8($aKcpResult['bankname']) : convert_to_utf8($aKcpResult['bank_name']),
				'escw_yn' => $aKcpResult['escw_yn'],
				'depositor' => convert_to_utf8($aKcpResult['depositor']),
				'account' => $aKcpResult['account'],
				'va_date' => $aKcpResult['va_date'],
				'commid' => $aKcpResult['commid'],
				'mobile_no' => $aKcpResult['mobile_no'],
				'res_cd' => $aKcpResult['res_cd'],
				'res_msg' => $sResMsgUtf8
			)
		);

		// End of [res_cd = "0000']
		pageRedirect('../order/complete?no=' . $orders['order_seq'], '', 'parent');
	}

	//조회
	public function status()
	{

		$this->send_for_provider = array();

		## 주문서 정보 가져오기
		$orders	= $this->ordermodel->get_order($_POST ['order_no']);
		## 가격 검증
		if	($orders['pg_currency'] == 'KRW')
			$orders['settleprice']	= floor($orders['settleprice']);
			if($orders['settleprice'] != $_POST['ipgm_mnyx']){
				$log_title	= '결제실패';
				$log			= "KCP 결제 실패". chr(10)."[입금통보, 금액불일치]";
				$this->ordermodel->set_log($orders['order_seq'], 'pay', '시스템', $log_title, $log);
				echo "<html><body><form><input type=\"hidden\" name=\"result\" value=\"9999\"></form></body></html>";
				exit;
			}

			/* ============================================================================== */
			/* =   02. 공통 통보 데이터 받기												= */
			/* = -------------------------------------------------------------------------- = */
			$site_cd	  = $_POST [ "site_cd"  ];				 // 사이트 코드
			$tno		  = $_POST [ "tno"	  ];				 // KCP 거래번호
			$order_no	 = $_POST [ "order_no" ];				 // 주문번호
			$tx_cd		= $_POST [ "tx_cd"	];				 // 업무처리 구분 코드
			$tx_tm		= $_POST [ "tx_tm"	];				 // 업무처리 완료 시간
			/* = -------------------------------------------------------------------------- = */
			$ipgm_name	= "";									// 주문자명
			$remitter	 = "";									// 입금자명
			$ipgm_mnyx	= "";									// 입금 금액
			$bank_code	= "";									// 은행코드
			$account	  = "";									// 가상계좌 입금계좌번호
			$op_cd		= "";									// 처리구분 코드
			$noti_id	  = "";									// 통보 아이디
			/* = -------------------------------------------------------------------------- = */
			$refund_nm	= "";									// 환불계좌주명
			$refund_mny   = "";									// 환불금액
			$bank_code	= "";									// 은행코드
			/* = -------------------------------------------------------------------------- = */
			$st_cd		= "";									// 구매확인 코드
			$can_msg	  = "";									// 구매취소 사유
			/* = -------------------------------------------------------------------------- = */
			$waybill_no   = "";									// 운송장 번호
			$waybill_corp = "";									// 택배 업체명
			/* = -------------------------------------------------------------------------- = */
			$cash_a_no	= "";									// 현금영수증 승인번호

			/* = -------------------------------------------------------------------------- = */
			/* =   02-1. 가상계좌 입금 통보 데이터 받기									 = */
			/* = -------------------------------------------------------------------------- = */
			if ( $tx_cd == "TX00" )
			{
				$ipgm_name = $_POST[ "ipgm_name" ];				// 주문자명
				$remitter  = $_POST[ "remitter"  ];				// 입금자명
				$ipgm_mnyx = $_POST[ "ipgm_mnyx" ];				// 입금 금액
				$bank_code = $_POST[ "bank_code" ];				// 은행코드
				$account   = $_POST[ "account"   ];				// 가상계좌 입금계좌번호
				$op_cd	 = $_POST[ "op_cd"	 ];				// 처리구분 코드
				$noti_id   = $_POST[ "noti_id"   ];				// 통보 아이디
				$cash_a_no = $_POST[ "cash_a_no" ];				// 현금영수증 승인번호
			}

			/* = -------------------------------------------------------------------------- = */
			/* =   02-2. 가상계좌 환불 통보 데이터 받기									 = */
			/* = -------------------------------------------------------------------------- = */
			else if ( $tx_cd == "TX01" )
			{
				$refund_nm  = $_POST[ "refund_nm"  ];			   // 환불계좌주명
				$refund_mny = $_POST[ "refund_mny" ];			   // 환불금액
				$bank_code  = $_POST[ "bank_code"  ];			   // 은행코드
			}
			/* = -------------------------------------------------------------------------- = */
			/* =   02-3. 구매확인/구매취소 통보 데이터 받기								  = */
			/* = -------------------------------------------------------------------------- = */
			else if ( $tx_cd == "TX02" )
			{
				$st_cd = $_POST[ "st_cd"]; 							// 구매확인 코드

				if ( $st_cd = "N"  )								// 구매확인 상태가 구매취소인 경우
				{
					$can_msg = $_POST[ "can_msg"   ];			   // 구매취소 사유
				}
			}
			/* = -------------------------------------------------------------------------- = */
			/* =   02-4. 배송시작 통보 데이터 받기										   = */
			/* = -------------------------------------------------------------------------- = */
			else if ( $tx_cd == "TX03" )
			{

				$waybill_no   = $_POST[ "waybill_no"   ];		   // 운송장 번호
				$waybill_corp = $_POST[ "waybill_corp" ];		   // 택배 업체명
			}

			/* = -------------------------------------------------------------------------- = */
			/* =   02-5. 모바일안심결제 통보 데이터 받기									= */
			/* = -------------------------------------------------------------------------- = */
			else if ( $tx_cd == "TX08" )
			{
				$ipgm_mnyx = $_POST[ "ipgm_mnyx" ];				// 입금 금액
				$bank_code = $_POST[ "bank_code" ];				// 은행코드
			}
			/* ============================================================================== */

			## 로그 저장
			$this->added_payment->set_pg_log(
				array(
					'pg' => 'kcp',
					'order_seq' => $order_no,
					'tno' => $tno,
					'depositor' => $remitter,
					'biller' => $ipgm_name,
					'amount' => $ipgm_mnyx,
					'bank_code' => $bank_code,
					'account' => $account,
					'res_cd' => $tx_cd,
					'res_msg' => $can_msg
				)
			);


			/* ============================================================================== */
			/* =   03. 공통 통보 결과를 업체 자체적으로 DB 처리 작업하시는 부분입니다.	  = */
			/* = -------------------------------------------------------------------------- = */
			/* =   통보 결과를 DB 작업 하는 과정에서 정상적으로 통보된 건에 대해 DB 작업에  = */
			/* =   실패하여 DB update 가 완료되지 않은 경우, 결과를 재통보 받을 수 있는	 = */
			/* =   프로세스가 구성되어 있습니다.											= */
			/* =																			= */
			/* =   * DB update가 정상적으로 완료된 경우									 = */
			/* =   하단의 [04. result 값 세팅 하기] 에서 result 값의 value값을 0000으로	 = */
			/* =   설정해 주시기 바랍니다.												  = */
			/* =																			= */
			/* =   * DB update가 실패한 경우												= */
			/* =   하단의 [04. result 값 세팅 하기] 에서 result 값의 value값을 0000이외의   = */
			/* =   값으로 설정해 주시기 바랍니다.										   = */
			/* = -------------------------------------------------------------------------- = */

			/* = -------------------------------------------------------------------------- = */
			/* =   03-1. 가상계좌 입금 통보 데이터 DB 처리 작업 부분						= */
			/* = -------------------------------------------------------------------------- = */
			if ( $tx_cd == "TX00" )
			{
				if( $cash_a_no ){// 현금영수증 승인번호
					$data = array(
							'typereceipt'=>2,
							'cash_receipts_no' => $cash_a_no
					);
				}

				$orders = $this->ordermodel->get_order($order_no);

				if($orders['step'] < '25' || $orders['step'] > '85'){ // 결제이후 프로세스 진행 이후에는 결제확인 처리 하지 않음
					//sms 발송을 위한 변수 저장
					$this->coupon_reciver_sms = array();
					$this->coupon_order_sms = array();
					$this->send_for_provider = array();
					$this->ordermodel->set_step($order_no,25,$data);
				}

				$log[] = date("Y-m-d H:i:s");
				$log[] = "주문자명:".$ipgm_name;
				$log[] = "입금자명:".$remitter;
				$log[] = "입금금액:".$ipgm_mnyx;
				$log[] = "은행코드:".$bank_code;
				$log[] = "가상계좌 입금계좌번호:".$account;
				$log[] = "주문자명:".$op_cd;
				$log[] = "주문자명:".$noti_id;
				$log[] = "현금영수증 승인번호:".$cash_a_no;
				$log_str = "가상계좌 결제확인" . chr(10) . implode(chr(10),$log);
				$this->ordermodel->set_log($order_no,'pay','자동','결제확인',$log_str);

				// 가상계좌 결제의 경우 현금영수증
				if( $orders['step'] < '25' || $orders['step'] > '85' ){
					$result = typereceipt_setting($orders['order_seq']);
				}

				$result_option = $this->ordermodel->get_item_option($order_no);
				$result_suboption = $this->ordermodel->get_item_suboption($order_no);

				// 출고량 업데이트를 위한 변수선언
				$r_reservation_goods_seq = array();
				$providerList				= array();

				// 해당 주문 상품의 출고예약량 업데이트
				if($result_option){
					foreach($result_option as $data_option){
						if($data_option['provider_seq']) $providerList[$data_option['provider_seq']]	= 1;

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

				// 결제확인 sms발송
				send_mail_step25($orders['order_seq']);
				if($orders['sms_25_YN'] != 'Y'){
					$params['shopName']		= $this->config_basic['shopName'];
					$params['ordno']		= $orders['order_seq'];
					$params['user_name']	= $orders['order_user_name'];
					if($orders['order_cellphone']){
						$commonSmsData['settle']['phone'][]		= $orders['order_cellphone'];
						$commonSmsData['settle']['params'][]	= $params;
						$commonSmsData['settle']['order_seq'][] = $orders['order_seq'];
					}
					sendSMS_for_provider('settle', $providerList, $params);
					//입점관리자 SMS 데이터
					if(count($this->send_for_provider['order_cellphone']) > 0){
						$provider_count = 0;
						foreach($this->send_for_provider['order_cellphone'] as $key=>$value){
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

				if($orders['step'] < '25' || $orders['step'] > '85'){
					//티켓상품 자동 출고처리구문 순차진행을 위해 분리함 @2017-08-16
					ticket_payexport_ck($orders['order_seq']);

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
				}

				if(count($commonSmsData) > 0){
					commonSendSMS($commonSmsData);
				}
			}
			/* = -------------------------------------------------------------------------- = */
			/* =   03-2. 가상계좌 환불 통보 데이터 DB 처리 작업 부분						= */
			/* = -------------------------------------------------------------------------- = */
			else if ( $tx_cd == "TX01" )
			{
			}
			/* = -------------------------------------------------------------------------- = */
			/* =   03-3. 구매확인/구매취소 통보 데이터 DB 처리 작업 부분					= */
			/* = -------------------------------------------------------------------------- = */
			else if ( $tx_cd == "TX02" )
			{
			}
			/* = -------------------------------------------------------------------------- = */
			/* =   03-4. 배송시작 통보 데이터 DB 처리 작업 부분							 = */
			/* = -------------------------------------------------------------------------- = */
			else if ( $tx_cd == "TX03" )
			{
			}
			/* = -------------------------------------------------------------------------- = */
			/* =   03-5. 정산보류 통보 데이터 DB 처리 작업 부분							 = */
			/* = -------------------------------------------------------------------------- = */
			else if ( $tx_cd == "TX04" )
			{
			}
			/* = -------------------------------------------------------------------------- = */
			/* =   03-6. 즉시취소 통보 데이터 DB 처리 작업 부분							 = */
			/* = -------------------------------------------------------------------------- = */
			else if ( $tx_cd == "TX05" )
			{
			}
			/* = -------------------------------------------------------------------------- = */
			/* =   03-7. 취소 통보 데이터 DB 처리 작업 부분								 = */
			/* = -------------------------------------------------------------------------- = */
			else if ( $tx_cd == "TX06" )
			{
			}
			/* = -------------------------------------------------------------------------- = */
			/* =   03-8. 발급계좌해지 통보 데이터 DB 처리 작업 부분						 = */
			/* = -------------------------------------------------------------------------- = */
			else if ( $tx_cd == "TX07" )
			{
			}
			/* = -------------------------------------------------------------------------- = */
			/* =   03-9. 모바일안심결제 통보 데이터 DB 처리 작업 부분					   = */
			/* = -------------------------------------------------------------------------- = */
			else if ( $tx_cd == "TX08" )
			{
			}
			/* ============================================================================== */




			/* ============================================================================== */
			/* =   04. result 값 세팅 하기												  = */
			/* ============================================================================== */
			echo "<html><body><form><input type=\"hidden\" name=\"result\" value=\"0000\"></form></body></html>";
	}

	public function pg_open_script(){
		echo '<script type="text/javascript">';
		echo '$("#wrap",parent.document).css("display","none");';
		echo '$("#payprocessing",parent.document).css("display","block");';
		echo '</script>';
	}
}

// end file