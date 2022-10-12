<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class kicclib
{
	public $javascript_url = '';
	public $action_url = '';
	public $receipt_url = '';
	public $params_prefix;
	public $module_prefix;
	public $domain_prefix;
	public $pg;

	public $g_home_dir;
	public $g_log_dir;
	public $g_home_receipt_dir;
	public $g_log_receipt_dir;
	public $g_log_level = '1';
	public $g_gw_url;
	public $g_gw_port = '80';

	protected $arr_payment_code = array(	// 솔루션에서 사용하는 결제타입을 kicc에 맞춰 변경
		'card'				=> '11',	// 신용카드
		'account'			=> '21',	// 계좌이체
		'virtual'			=> '22',	// 무통장입금
		'cellphone'			=> '31',	// 휴대폰
		// ''				=> '50',	// 선불결제				// kicc의 선불결제는 현재 지원하지 않음
		// ''				=> '60',	// 간편결제				// kicc의 간편결제는 현재 지원하지 않음
		'escrow_account'	=> '21',	// 에스크로 계좌이체		// 에스크로의 경우 별도의 EP_escr_type 값을 추가하여 컨트롤
		'escrow_virtual'	=> '22',	// 에스크로 무통장입금	// 에스크로의 경우 별도의 EP_escr_type 값을 추가하여 컨트롤
	);
	public $arr_mgr_txtype = array(	// 솔루션에서 사용하는 결제타입을 kicc에 맞춰 변경
		'card'				=> '32',	// 신용카드
		'account'			=> '33',	// 계좌이체
		'virtual'			=> '62',	// 무통장입금
		'cellphone'			=> '60',	// 휴대폰 휴대폰의 경우 부분취소가 불가능, 60으로 계좌정보 입력하여 처리, 단 현재는 모두 수동 무통장입금으로 처리
		'escrow_account'	=> '61',	// 에스크로 계좌이체		// 에스크로의 경우 별도의 EP_escr_type 값을 추가하여 컨트롤
		'escrow_virtual'	=> '61',	// 에스크로 무통장입금	// 에스크로의 경우 별도의 EP_escr_type 값을 추가하여 컨트롤
	);
	public $arr_mgr_subype = array(	// 솔루션에서 사용하는 결제타입을 kicc에 맞춰 변경
		'ES02',// : 승인취소
		'ES05',// : 환불요청
		'ES07',// : 배송중
		'ES08',// : 배송중 취소요청
		'ES10',// : 배송중 환불요청
	);
	public $arr_kicc_dev_code = array(	// kicc 에서 사용되는 테스트 코드
		'T5102001',		//kicc에서 사용하는 공통 개발 계정
		'T0010876',		//면세상점 테스트 용으로 발급됨
		'GA000001',
	);	
	protected $arr_receipt_code = array(	// 솔루션에서 사용하는 현금영수증 요청 타입을 kicc에 맞춰 변경
		'pay'			=> 'issue',	// 발행
		'mod'			=> 'cancel',	 // 취소
	);
	protected $arr_issue_type = array(	// 솔루션에서 사용하는 현금영수증 발행용도 타입을 kicc에 맞춰 변경
		'0'			=> '01',	// 개인 소득공제용
		'1'			=> '02',	// 사업자지출 증빙용
	);

	public function __construct() {
		if(empty($this->CI)){
			$this->CI = & get_instance();
		}
		$this->pg = config_load($this->CI->config_system['pgCompany']);
		$this->pg['arrKiccCardCompany'] = code_load('kiccCardCompanyCode');

		$env_for_server = 'prod';
		if (in_array($this->pg['mallCode'], $this->arr_kicc_dev_code)) {	// 테스트코드는 개발계정으로 결제진행
			$env_for_server = 'devel';
		}
		// PC와 Mobile에 따라 호출 하는 모듈 양식이 다름
		if(!$this->CI->_is_mobile_agent) {
			$this->params_prefix = 'EP_';
			$this->module_prefix = 'webpay';
			$this->domain_prefix = 'pg';
		}else{
			$this->params_prefix = 'sp_';
			$this->module_prefix = 'ep8';
			$this->domain_prefix = 'sp';
		}


		$arr_javascript_url['devel']		= 'https://test'.$this->domain_prefix.'.easypay.co.kr/webpay/EasypayCard_Web.js';
		$arr_javascript_url['prod']			= 'https://'.$this->domain_prefix.'.easypay.co.kr/webpay/EasypayCard_Web.js';
		$arr_action_url['devel']			= 'https://test'.$this->domain_prefix.'.easypay.co.kr/'.$this->module_prefix.'/MainAction.do';
		$arr_action_url['prod']				= 'https://'.$this->domain_prefix.'.easypay.co.kr/'.$this->module_prefix.'/MainAction.do';
		$arr_receipt_url['devel']			= 'https://testoffice.easypay.co.kr/receipt/ReceiptBranch.jsp';
		$arr_receipt_url['prod']			= 'https://office.easypay.co.kr/receipt/ReceiptBranch.jsp';
		$arr_g_gw_url['devel']				= 'testgw.easypay.co.kr';
		$arr_g_gw_url['prod']				= 'gw.easypay.co.kr';

		$this->javascript_url				= $arr_javascript_url[$env_for_server];
		$this->action_url					= $arr_action_url[$env_for_server];
		$this->receipt_url					= $arr_receipt_url[$env_for_server];

		$this->g_home_dir					= $_SERVER["DOCUMENT_ROOT"]."/pg/kicc";
		$this->g_log_dir					= $_SERVER["DOCUMENT_ROOT"]."/pg/kicc/log";
		// $this->g_log_level					= '1'; // kicc 로그레벨
		$this->g_home_receipt_dir			= $_SERVER["DOCUMENT_ROOT"]."/pg/kicc/receipt";
		$this->g_log_receipt_dir			= $_SERVER["DOCUMENT_ROOT"]."/pg/kicc/receipt/log";

		$this->g_gw_url						= $arr_g_gw_url[$env_for_server];
		// $this->g_gw_port					= '80';
	}
	public function initKiccParams($params, $nextStepUrl){
		$payment_code = $this->arr_payment_code[$params['payment']];

		// 에스크로 체크
		$escrow_yn = 'N';
		if( preg_match('/escrow/', $params['payment']) ) $escrow_yn = 'Y';

		$http_host 	= $_SERVER['HTTP_HOST'];
		$http_protocol = $_SERVER['HTTPS'] ? 'https' : 'http';

		/* 피드백 URL */
		$siteDomain = $http_protocol."://".$http_host.""; //가맹점 도메인 입력
		$return_url = $siteDomain.'/kicc/receive';

		// 할부개월
		$arr_quota = array();
		$quota = '';
		if($this->pg['interestTerms']){
			$arr_quota[] = '00';
			for($i=2;$i<$this->pg['interestTerms'];$i++){
				$arr_quota[] = substr('00'.$i,-2);
			}
		}
		if(count($arr_quota)>0){
			$quota = implode(":", $arr_quota);
		}

		// 무이자
		$arr_noinst = array();
		$noinst_flag = null;
		$noinst_term = '';
		if($this->pg['nonInterestTerms']=='manual'){
			$noinst_flag = 'Y';
			foreach($this->pg['pcCardCompanyCode'] as $k=>$cardCompanyCode){
				$arrCardCompanyTerms = explode(",", $this->pg['pcCardCompanyTerms'][$k]);
				$tmpCardCompanyTerms = array();
				foreach($arrCardCompanyTerms as $cardCompanyTerms){
					$tmpCardCompanyTerms[] = substr('00'.$cardCompanyTerms, -2);
				}

				if(count($tmpCardCompanyTerms)>0){
					$arr_noinst[] = $cardCompanyCode.'-'.implode(":", $tmpCardCompanyTerms);
				}
			}
		}
		if(count($arr_noinst)>0){
			$noinst_term = implode(",", $arr_noinst);
		}

		// 가상계좌 입금마감 일자
		$order_config = config_load('order');
		$vacct_end_date = '';
		if(in_array($params['payment'], array('virtual', 'escrow_virtual')) && $order_config['autocancel'] == 'y'){
			$vacct_end_date = date('Ymd',strtotime("+".$order_config['cancelDuration']." day", time()));
		}

		// 복합과세
		$tax_flg = '';
		$com_tax_amt = '';
		$com_free_amt = '';
		$com_vat_amt = '';
		/**
		 * 휴대폰 결제는 1. tax_flg, 2. com_tax_amt, 3. com_free_amt, 4. com_vat_amt 전달하지 않음 - 상점 설정에 따라 과세,비과세 여부 결정됨
		 * 휴대폰 소액결제의 경우 복합과세를 지원하지 않음
		 */
		if ($params['freeprice'] && $payment_code !== '31') {
			$tax_flg = 'TG01';
			// 전체 면세제품만 샀을 경우 과세값이 ''이라 정상적으로 결제가 되지 않아 수정함 by hed
			$com_tax_amt = ($params['comm_tax_mny']) ? $params['comm_tax_mny'] : '0';
			$com_free_amt = $params['freeprice'];
			$com_vat_amt = $params['comm_vat_mny'];
		}

		unset($result);
		$result = array();
														// 변수명	내용	속성	길이	요청	비고
		// 공통정보
		$result[$this->params_prefix.'mall_id'				] = $this->pg['mallCode'];		// EP_mall_id	가맹점 ID	N	8	○	KICC에서 부여한 가맹점 ID
		$result[$this->params_prefix.'pay_type'				] = $payment_code;				// EP_pay_type	결제수단	AN	32	●	결제수단표 참조
		$result[$this->params_prefix.'currency'				] = '00';							// EP_currency	통화코드	N	2	○	00 : 원화, 고정
		$result[$this->params_prefix.'order_no'				] = $params['order_seq'];			// EP_order_no	가맹점 주문번호	AN	40	○	가맹점에서 생성하는 유일한 번호
		$result[$this->params_prefix.'product_nm'			] = $params['goods_name'];		// EP_product_nm	상품명	AN	50	○	특수문자 제외
		$result[$this->params_prefix.'product_amt'			] = $params['settle_price'];		// EP_product_amt	상품금액	N	14	○	결제금액(반드시 숫자만 가능)
		$result[$this->params_prefix.'return_url'			] = $return_url;					// EP_return_url	가맹점 callback url	AN	400	○	인증응답 받을 가맹점 URL
		$result[$this->params_prefix.'quota'				] = $quota;		// EP_quota	할부개월	AN	가변	△	할부개월
		$result[$this->params_prefix.'mall_nm'				] = $this->CI->config_basic['shopName'];		// EP_mall_nm	가맹점명	AN	20	△	결제창에 표시될 가맹점명
		$result[$this->params_prefix.'ci_url'				] = '';		// EP_ci_url	가맹점 CI URL	AN	256	△	CI 이미지 파일의 URL
		$result[$this->params_prefix.'lang_flag'			] = ($this->CI->config_system['language']=='KR')?'KOR':'ENG';		// EP_lang_flag	영문버젼여부	A	3	△	KOR : 국문, ENG : 영문
		$result[$this->params_prefix.'user_id'				] = '';		// EP_user_id	고객ID	AN	20	△	가맹점에서 관리하는 고객 ID
		$result[$this->params_prefix.'memb_user_no'			] = '';		// EP_memb_user_no	고객 관리번호	AN	20	△	고객 관리번호
		$result[$this->params_prefix.'user_nm'				] = $params['order_user_name'];		// EP_user_nm	고객명	AN	20	△	구매자명
		$result[$this->params_prefix.'user_mail'			] = $params['order_email'];		// EP_user_mail	고객 e-mail	AN	30	△	구매자 e-mail
		$result[$this->params_prefix.'user_phone1'			] = str_replace("-", "", $params['order_phone']);		// EP_user_phone1	고객 전화번호	N	20	△	구매자 연락처(‘-‘없이 입력)
		$result[$this->params_prefix.'user_phone2'			] = str_replace("-", "", $params['order_cellphone']);		// EP_user_phone2	고객 휴대폰번호	N	20	△	구매자 휴대폰번호(‘-‘없이 입력)
		$result[$this->params_prefix.'user_addr'			] = '';		// EP_user_addr	고객 주소	AN	200	△	구매자 주소
		$result[$this->params_prefix.'user_define1'			] = '';		// EP_user_define1	예비필드1	ANS	64	△
		$result[$this->params_prefix.'user_define2'			] = '';		// EP_user_define2	예비필드2	ANS	64	△
		$result[$this->params_prefix.'user_define3'			] = '';		// EP_user_define3	예비필드3	ANS	64	△
		$result[$this->params_prefix.'user_define4'			] = '';		// EP_user_define4	예비필드4	ANS	64	△
		$result[$this->params_prefix.'user_define5'			] = '';		// EP_user_define5	예비필드5	ANS	64	△
		$result[$this->params_prefix.'user_define6'			] = '';		// EP_user_define6	예비필드6	ANS	64	△
		$result[$this->params_prefix.'product_type'			] = '';		// EP_product_type	상품구분	N	1	△	0 : 실물, 1 : 컨텐츠
		$result[$this->params_prefix.'product_expr'			] = '';		// EP_product_expr	서비스기간	N	8	△	YYYYMMDD
		$result[$this->params_prefix.'bkpay_yn'				] = '';		// EP_bkpay_yn	장바구니 결제 여부	A	1 	△
		$result[$this->params_prefix.'window_type'			] = 'iframe';		// EP_window_type	윈도우 타입	A	10	△	iframe(layer popup) / popup
		$result[$this->params_prefix.'disp_cash_yn'			] = 'N';		// EP_disp_cash_yn	현금영수증 화면표시여부	A	1	△	“N” : 미표시 그 외 : DB조회


		// 신용카드 설정정보(신용카드 사용가맹점)
		$result[$this->params_prefix.'usedcard_code'		] = '';		// EP_usedcard_code	사용가능 카드	AN	가변	△	가맹점에서 사용할 카드 리스트
		$result[$this->params_prefix.'os_cert_flag'			] = '2';		// EP_os_cert_flag	해외카드 인증구분	N	1	●	해외카드인증구분 = ‘2’
		$result[$this->params_prefix.'noinst_flag'			] = $noinst_flag;		// EP_noinst_flag	무이자 설정	A	1	△	무이자 : Y, 일반 : N, DB : NULL
		$result[$this->params_prefix.'noinst_term'			] = $noinst_term;		// EP_noinst_term	무이자 기간	ANS	가변	△
		$result[$this->params_prefix.'set_point_card_yn'	] = '';		// EP_set_point_card_yn	포인트 사용유무	A	1	△	사용 : Y, 미사용 : N
		$result[$this->params_prefix.'point_card'			] = '';		// EP_point_card	카드사 포인트	AN	가변	△	카드사 포인트
		$result[$this->params_prefix.'join_cd'				] = '';		// EP_join_cd	조인코드	ANS	4 	△	JC02(현대카드 M포인트 청구할인)
																		//									JC03(국민카드 아이사랑 카드할인)
																		//									JC04(ARS 신용카드 결제 거래 ONLINE 거래)
																		//									JC05(ARS 신용카드 결제 거래 OFFLINE 거래)
																		//									JC06(세이브 결제 거래)
																		//									JC07(비씨 물품바우처 승인 거래)
																		//									JC08(롯데 청구할인)
																		//									JC09(이브릿지 발렛 서비스)
																		//									JC11(롯데카드 아이행복 제휴할인)
																		//									JC12(시티카드 VISA 포인트)
		$result[$this->params_prefix.'kmotion_useyn'		] = '';		// EP_kmotion_useyn	국민앱카드사용유무	A	1	△	 사용 : Y 미사용 : N 자동구분 : 빈값
		$result[$this->params_prefix.'cert_type'			] = '';		// EP_cert_type	인증타입	N	1 	△	빈값 :일반, 0 :인증, 1 :비인증


		// 가상계좌 설정정보(가상계좌 사용가맹점)
		$result[$this->params_prefix.'vacct_bank'			] = '';		// EP_vacct_bank	은행 리스트	AN	가변	△	가맹점에서 사용할 은행 리스트
		$result[$this->params_prefix.'vacct_end_date'		] = $vacct_end_date;		// EP_vacct_end_date	입금마감 일자	N	8	△	YYYYMMDD
		$result[$this->params_prefix.'vacct_end_time'		] = '';		// EP_vacct_end_time	입금마감 시간	N	6	△	hh24miss


		// 선불결제
		$result[$this->params_prefix.'prepaid_cp'			] = '';		// EP_prepaid_cp	선불결제 CP 코드	N	가변	△	CCB:캐시비, ECB:이지캐시


		// 간편결제
		$result[$this->params_prefix.'spay_cp'				] = '';		// EP_spay_cp	간편결제 CP 코드	N	가변


		// 복합과세
		$result[$this->params_prefix.'tax_flg'				] = $tax_flg;		// EP_tax_flg	과세서비스 구분 플래그	ANS	4	△	복합과세를 사용할시 필수값 : TG01 (추가)
		$result[$this->params_prefix.'com_tax_amt'			] = $com_tax_amt;		// EP_com_tax_amt	과세 승인 금액	ANS	14	△
		$result[$this->params_prefix.'com_free_amt'			] = $com_free_amt;		// EP_com_free_amt	비과세 승인 금액	ANS	14	△
		$result[$this->params_prefix.'com_vat_amt'			] = $com_vat_amt;		// EP_com_vat_amt	부가세 금액	ANS	14	△

		// 에스크로
		if($escrow_yn == 'Y' && in_array($payment_code, array('21','22'))){
			$arr_good_info = array();
			## 장바구니 상품정보
			// kicc 에스크로의 경우 장바구니의 개별 금액의 합이 총 결제금액과 무조건 일치해야한다.
			$goods_info = unserialize($params["goods_info"]);
			if($goods_info){
				// 총 결제금액의 비율을 기준으로 개별 금액을 재계산하여 처리
				$escrow_cart_tot_price = '0';
				foreach($goods_info as $k=>$item){
					$escrow_cart_tot_price += $item['good_amtx'] * $item['good_cntx'];
				}
				$tmp = $goods_info;
				$good_cart_price_rest = $params['settle_price'];
				foreach($tmp as $k=>$item){
					$escrow_cart_each_price = $item['good_amtx'] * $item['good_cntx'];
					$goods_info[$k]['good_cart_price'] = (int) ($params['settle_price'] * ($escrow_cart_each_price/$escrow_cart_tot_price));
					$goods_info[$k]['good_cart_price_rest'] = '0';
					$good_cart_price_rest = $good_cart_price_rest - $goods_info[$k]['good_cart_price'];
				}
				$goods_info[0]['good_cart_price_rest'] = $good_cart_price_rest;
				foreach($goods_info as $k=>$item){
					$tmp_good_info = '';
					if(!$item['good_cntx']) $item['good_cntx'] = 1;
					if(!$item['good_amtx']) $item['good_amtx'] = 0;
					$good_cart_price = $item['good_cart_price'];
					if($k==0){
						$good_cart_price += $item['good_cart_price_rest'];
					}
					$tmp_good_info .= "prd_no=".$item['seq'].chr(31);
					$tmp_good_info .= "prd_amt=".$good_cart_price.chr(31);
					$tmp_good_info .= "prd_nm=".rawurlencode($item['good_name']);
					$arr_good_info[] = $tmp_good_info;
				}
			}
			$good_info = implode(chr(31).chr(30), $arr_good_info);

			$result[$this->params_prefix.'escr_type'		] = 'K';												// 에스크로 타입				A	1 	△	K:KICC에스크로-계좌이체, 가상계좌에 사용가능
			$result[$this->params_prefix.'bk_cnt'			] = count($goods_info);									// 에스크로 장바구니 개수		N	2 	△	EP_escr_type 값이 K인 경우 필수 최대30개
			$result[$this->params_prefix.'bk_totamt'		] = $params['settle_price'];							// 에스크로 장바구니 금액		N	14 	△	EP_escr_type 값이 K인 경우 필수
			$result[$this->params_prefix.'bk_goodinfo'		] = $good_info;											// 에스크로 장바구니 정보		ANS	가변	△	EP_escr_type 값이 K인 경우 필수 FORMAT-> 정보명=값US정보명=값US정보명=값 예시-> prd_no=P001prd_amt=25000prd_nm=상품[0]prd_no=P002prd_amt=25000prd_nm=상품[1] [정보] prd_no : 가맹점 상품번호 prd_amt : 상품 금액 prd_nm : 상품명
			$result[$this->params_prefix.'recv_id'			] = '';													// 구매자 ID					ANS	50 	△
			$result[$this->params_prefix.'recv_nm'			] = $params['order_user_name'];							// 구매자 명					ANS	50 	△	EP_escr_type 값이 K인 경우 필수
			$result[$this->params_prefix.'recv_tel'			] = str_replace("-", "", $params['order_phone']);		// 구매자 전화번호			N	20 	△
			$result[$this->params_prefix.'recv_mob'			] = str_replace("-", "", $params['order_cellphone']);	// 구매자 휴대폰번호			N	20 	△	EP_escr_type 값이 K인 경우 필수
			$result[$this->params_prefix.'recv_mail'		] = $params['order_email'];								// 구매자 이메일				ANS	100 △	EP_escr_type 값이 K인 경우 필수
			$result[$this->params_prefix.'recv_zip'			] = '';													// 구매자 우편번호			N	6 	△
			$result[$this->params_prefix.'recv_addr1'		] = '';													// 구매자 주소1				ANS	200 △
			$result[$this->params_prefix.'recv_addr2'		] = '';													// 구매자 주소2				ANS	200 △
			$result[$this->params_prefix.'deli_type'		] = '0';												// 배송구분					N	1 	△	0:택배, 1:자가

		}

		// validation 확인
		$validation = false;

		// kicc의 경우 에스크로일 때 복합과세 처리가 불가능함. 단, 전체 비과세일 경우 처리 가능해야함
		if(!($result[$this->params_prefix.'tax_flg'] == 'TG01' && $result[$this->params_prefix.'escr_type']=='K' && $com_tax_amt > '0')){
			$validation = true;
		}


		// 스크립트를 미리 구성하여 view로 전달
		$result['javascript_callPgDelay'] = $this->initKiccCallPgDelay($nextStepUrl, $validation);

		// 테이터가 없을 시 전부 언셋하여 정리 및 특수문자 워싱
		$tmpresult = $result;
		unset($result);
		$arr_replace_ignore = array($this->params_prefix.'quota', $this->params_prefix.'noinst_term', 'javascript_callPgDelay');
		$result = $this->removeCharacterKiccParam($tmpresult, $arr_replace_ignore);

		return $result;
	}

	// kicc 모듈 호출
	public function callKiccModuleReceipt($params){
		$pg_call_result = array(
			'res_cd' => $params[$this->params_prefix.'res_cd'],
			'res_msg' => $params[$this->params_prefix.'res_msg'],
		);
		include_once($this->g_home_receipt_dir."/easypay_client.php");

		/* ============================================================================== */
		/* =   PAGE : 결제 정보 환경 설정 PAGE                                          = */
		/* = -------------------------------------------------------------------------- = */
		/* =   Copyright (c)  2010   KICC Inc.   All Rights Reserved.                   = */
		/* ============================================================================== */


		/* ============================================================================== */
		/* =   01. 공통 데이터 셋업 (업체에 맞게 수정)                                  = */
		/* = -------------------------------------------------------------------------- = */
		/* = ※ 주의 ※                                                                 = */
		/* = * cert_file 변수 설정                                                      = */
		/* = pg_cert.pem 파일의 절대 경로 설정(파일명을 포함한 경로로 설정)             = */
		/* =                                                                            = */
		/* = * log_dir 변수 설정                                                        = */
		/* = log 디렉토리 설정                                                          = */
		/* = * log_level 변수 설정                                                      = */
		/* = log 레벨 설정                                                              = */
		/* = -------------------------------------------------------------------------- = */

		$g_home_dir   = $this->g_home_receipt_dir;
		$g_cert_file  = $this->g_home_receipt_dir."/cert/pg_cert.pem";
		$g_log_dir    = $this->g_log_receipt_dir;
		$g_log_level  = "1";

		/* ============================================================================== */
		/* =   02. 쇼핑몰 정보 설정                                                     = */
		/* = -------------------------------------------------------------------------- = */
		$g_gw_url    = $this->g_gw_url;  /* 테스트 Gateway URL  */
		//$g_gw_url    = "gw.easypay.co.kr";  /* 리얼 Gateway URL  */
		$g_gw_port   =  $this->g_gw_port;                    /* 포트번호(변경불가) */

		$g_mall_id   = $this->pg['mallCode'];              /* 리얼 반영시 KICC에 발급된 mall_id 사용 */
		$g_mall_name = rawurlencode($this->CI->config_basic['shopName']);
		/* ============================================================================== */

		/* -------------------------------------------------------------------------- */
		/* ::: 처리구분 설정                                                          */
		/* -------------------------------------------------------------------------- */
		$ISSUE    = "issue";   // 발행
		$CANCL    = "cancel";  // 취소

		$tr_cd            = '00201050';         // [필수]요청구분
		$pay_type         = 'cash';         // [필수]결제수단
		$req_type         = $this->arr_receipt_code[$params["taxParamMode"]];         // [필수]요청타입

		$auth_type = '';
		if($this->arr_issue_type[$params["cuse"   ]]=='01'){
			if(!preg_match('/^(010|011|016|017|019)/', $params["creceipt_number"   ])){
				$auth_type = '02';	// 주민등록번호
			}else{
				$auth_type = '03';	// 휴대폰번호
			}
		}elseif($this->arr_issue_type[$params["cuse"   ]]=='02'){
			$auth_type = '04';	// 사업자번호
		}

		// 특수문자 정리
		$params = $this->removeCharacterKiccParam($params);

		/* -------------------------------------------------------------------------- */
		/* ::: 현금영수증 발행정보 설정                                               */
		/* -------------------------------------------------------------------------- */
		$order_no         = $params["order_seq"     ];    // [필수]주문번호
		$user_id          = $params["member_seq"     ];    // [선택]고객 ID
		$user_nm          = $params["person"     ];    // [선택]고객명
		$user_mail        = $params["email"    ];    // [선택]고객 메일
		$issue_type       = $this->arr_issue_type[$params["cuse"   ]];    // [필수]현금영수증발행용도
		$auth_type        = $auth_type;    // [필수]인증구분
		$auth_value       = $params["creceipt_number"   ];    // [필수]인증번호
		$sub_mall_yn      = '0';    // [필수]하위가맹점사용여부
		$sub_mall_buss    = '';    // [선택]하위가맹점사업자번호
		$tot_amt          = $params["price"      ];    // [필수]총거래금액
		$service_amt      = '0';    // [필수]봉사료
		$vat              = $params["surtax"          ];    // [필수]부가세
		$product_nm       = $params["goodsname"   ];    // [필수]상품명

		/* -------------------------------------------------------------------------- */
		/* ::: 현금영수증 취소정보 설정                                               */
		/* -------------------------------------------------------------------------- */
		$mgr_txtype       = '51';          // [필수]거래구분
		$org_cno          = $params["org_cno"   ];          // [필수]원거래고유번호
		$req_id           = $this->pg['mallCode'];          // [필수]가맹점 관리자 로그인 아이디
		$mgr_msg          = '';          // [선택]변경 사유
		$mgr_amt          = '0';          // [선택]부분취소 금액

		/* -------------------------------------------------------------------------- */
		/* ::: IP 정보 설정                                                           */
		/* -------------------------------------------------------------------------- */
		$client_ip         = getenv( "REMOTE_ADDR"	) ? getenv( "REMOTE_ADDR"	) : gethostbyname(gethostname());      // [필수]결제고객 IP

		/* -------------------------------------------------------------------------- */
		/* ::: 결제 결과                                                              */
		/* -------------------------------------------------------------------------- */
		$res_cd     = "";
		$res_msg    = "";

		/* -------------------------------------------------------------------------- */
		/* ::: EasyPayClient 인스턴스 생성 [변경불가 !!].                             */
		/* -------------------------------------------------------------------------- */
		$easyPay = new EasyPay_Client_Receipt;         // 전문처리용 Class (library에서 정의됨)
		$easyPay->clearup_msg();

		$easyPay->set_home_dir($g_home_dir);
		$easyPay->set_gw_url($g_gw_url);
		$easyPay->set_gw_port($g_gw_port);
		$easyPay->set_log_dir($g_log_dir);
		$easyPay->set_log_level($g_log_level);
		$easyPay->set_cert_file($g_cert_file);

		if( $ISSUE == $req_type )
		{
			/* ---------------------------------------------------------------------- */
			/* ::: 인증요청 전문 설정                                                 */
			/* ---------------------------------------------------------------------- */
			// 결제 주문 전문
			$cash_data = $easyPay->set_easypay_item("cash_data");
			$easyPay->set_easypay_deli_us( $cash_data, "order_no"      , $order_no     );
			$easyPay->set_easypay_deli_us( $cash_data, "user_id"       , $user_id      );
			$easyPay->set_easypay_deli_us( $cash_data, "user_nm"       , $user_nm      );
			$easyPay->set_easypay_deli_us( $cash_data, "user_mail"     , $user_mail    );
			$easyPay->set_easypay_deli_us( $cash_data, "issue_type"    , $issue_type   );
			$easyPay->set_easypay_deli_us( $cash_data, "auth_type"     , $auth_type    );
			$easyPay->set_easypay_deli_us( $cash_data, "auth_value"    , $auth_value   );
			$easyPay->set_easypay_deli_us( $cash_data, "sub_mall_yn"   , $sub_mall_yn  );
			$easyPay->set_easypay_deli_us( $cash_data, "product_nm"    , $product_nm   );
			if( $sub_mall_yn =="1" ) {
				$easyPay->set_easypay_deli_us( $cash_data, "sub_mall_buss"   , $sub_mall_buss   );
			}
			$easyPay->set_easypay_deli_us( $cash_data, "tot_amt"      , $tot_amt      );
			$easyPay->set_easypay_deli_us( $cash_data, "service_amt"  , $service_amt  );
			$easyPay->set_easypay_deli_us( $cash_data, "vat"          , $vat          );
		}
		else if( $CANCL == $req_type )
		{
			$mgr_data = $easyPay->set_easypay_item("mgr_data");
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_txtype"    , $mgr_txtype   );
			$easyPay->set_easypay_deli_us( $mgr_data, "org_cno"       , $org_cno      );
			$easyPay->set_easypay_deli_us( $mgr_data, "req_ip"        , $client_ip    );
			$easyPay->set_easypay_deli_us( $mgr_data, "req_id"        , $req_id       );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_msg"       , $mgr_msg      );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_amt"       , $mgr_amt      );
		}

		/* -------------------------------------------------------------------------- */
		/* ::: 실행                                                                   */
		/* -------------------------------------------------------------------------- */
		$opt = "option value";
		$easyPay->easypay_exec($g_mall_id, $tr_cd, $order_no, $client_ip, $opt);
		$res_cd  = $easyPay->_easypay_resdata["res_cd" ];   // 응답코드
		$res_msg = $easyPay->_easypay_resdata["res_msg"];   // 응답메시지
		$res_msg = iconv("euc-kr","utf-8",$res_msg);

		/* -------------------------------------------------------------------------- */
		/* ::: 결과 처리                                                              */
		/* -------------------------------------------------------------------------- */
		$r_cno             = $easyPay->_easypay_resdata[ "cno"             ];    // PG거래번호
		$r_amount          = $easyPay->_easypay_resdata[ "amount"          ];    //총 결제금액
		$r_auth_no         = $easyPay->_easypay_resdata[ "auth_no"         ];    //승인번호
		$r_tran_date       = $easyPay->_easypay_resdata[ "tran_date"       ];    //승인일시
		$r_pnt_auth_no     = $easyPay->_easypay_resdata[ "pnt_auth_no"     ];    //포인트승인번호
		$r_pnt_tran_date   = $easyPay->_easypay_resdata[ "pnt_tran_date"   ];    //포인트승인일시
		$r_cpon_auth_no    = $easyPay->_easypay_resdata[ "cpon_auth_no"    ];    //쿠폰승인번호
		$r_cpon_tran_date  = $easyPay->_easypay_resdata[ "cpon_tran_date"  ];    //쿠폰승인일시
		$r_card_no         = $easyPay->_easypay_resdata[ "card_no"         ];    //카드번호
		$r_issuer_cd       = $easyPay->_easypay_resdata[ "issuer_cd"       ];    //발급사코드
		$r_issuer_nm       = $easyPay->_easypay_resdata[ "issuer_nm"       ];    //발급사명
		$r_acquirer_cd     = $easyPay->_easypay_resdata[ "acquirer_cd"     ];    //매입사코드
		$r_acquirer_nm     = $easyPay->_easypay_resdata[ "acquirer_nm"     ];    //매입사명
		$r_install_period  = $easyPay->_easypay_resdata[ "install_period"  ];    //할부개월
		$r_noint           = $easyPay->_easypay_resdata[ "noint"           ];    //무이자여부
		$r_bank_cd         = $easyPay->_easypay_resdata[ "bank_cd"         ];    //은행코드
		$r_bank_nm         = $easyPay->_easypay_resdata[ "bank_nm"         ];    //은행명
		$r_account_no      = $easyPay->_easypay_resdata[ "account_no"      ];    //계좌번호
		$r_deposit_nm      = $easyPay->_easypay_resdata[ "deposit_nm"      ];    //입금자명
		$r_expire_date     = $easyPay->_easypay_resdata[ "expire_date"     ];    //계좌사용만료일
		$r_cash_res_cd     = $easyPay->_easypay_resdata[ "cash_res_cd"     ];    //현금영수증 결과코드
		$r_cash_res_msg    = $easyPay->_easypay_resdata[ "cash_res_msg"    ];    //현금영수증 결과메세지
		$r_cash_auth_no    = $easyPay->_easypay_resdata[ "cash_auth_no"    ];    //현금영수증 승인번호
		$r_cash_tran_date  = $easyPay->_easypay_resdata[ "cash_tran_date"  ];    //현금영수증 승인일시
		$r_auth_id         = $easyPay->_easypay_resdata[ "auth_id"         ];    //PhoneID
		$r_billid          = $easyPay->_easypay_resdata[ "billid"          ];    //인증번호
		$r_mobile_no       = $easyPay->_easypay_resdata[ "mobile_no"       ];    //휴대폰번호
		$r_ars_no          = $easyPay->_easypay_resdata[ "ars_no"          ];    //전화번호
		$r_cp_cd           = $easyPay->_easypay_resdata[ "cp_cd"           ];    //포인트사/쿠폰사
		$r_used_pnt        = $easyPay->_easypay_resdata[ "used_pnt"        ];    //사용포인트
		$r_remain_pnt      = $easyPay->_easypay_resdata[ "remain_pnt"      ];    //잔여한도
		$r_pay_pnt         = $easyPay->_easypay_resdata[ "pay_pnt"         ];    //할인/발생포인트
		$r_accrue_pnt      = $easyPay->_easypay_resdata[ "accrue_pnt"      ];    //누적포인트
		$r_remain_cpon     = $easyPay->_easypay_resdata[ "remain_cpon"     ];    //쿠폰잔액
		$r_used_cpon       = $easyPay->_easypay_resdata[ "used_cpon"       ];    //쿠폰 사용금액
		$r_mall_nm         = $easyPay->_easypay_resdata[ "mall_nm"         ];    //제휴사명칭
		$r_escrow_yn       = $easyPay->_easypay_resdata[ "escrow_yn"       ];    //에스크로 사용유무
		$r_complex_yn      = $easyPay->_easypay_resdata[ "complex_yn"      ];    //복합결제 유무
		$r_canc_acq_date   = $easyPay->_easypay_resdata[ "canc_acq_date"   ];    //매입취소일시
		$r_canc_date       = $easyPay->_easypay_resdata[ "canc_date"       ];    //취소일시
		$r_refund_date     = $easyPay->_easypay_resdata[ "refund_date"     ];    //환불예정일시
		$r_cash_res_msg = iconv("euc-kr","utf-8",$r_cash_res_msg);

		// $return 이 array가 아닌 경우 false로 간주
		if($res_cd=='0000'){
			$pg_call_result['res_cd'] = $res_cd;
			$pg_call_result['res_msg'] = $res_msg;
			$pg_call_result['cash_no'] = $r_cno;
			$pg_call_result['receipt_no'] = $r_auth_no;
			$pg_call_result['app_time'] = $r_tran_date;
			$pg_call_result['reg_stat'] = $res_cd;
			$pg_call_result['reg_desc'] = $res_msg;
		}else{
			$pg_call_result = false;
		}
		return $pg_call_result;
	}

	// kicc 모듈 호출
	public function callKiccModule($params){
		$pg_call_result = array(
			'res_cd' => $params[$this->params_prefix.'res_cd'],
			'res_msg' => $params[$this->params_prefix.'res_msg'],
		);

		include_once($this->g_home_dir."/easypay_client.php");

		/* -------------------------------------------------------------------------- */

		/* ::: 처리구분 설정                                                          */

		/* -------------------------------------------------------------------------- */

		$TRAN_CD_NOR_PAYMENT    = "00101000";   // 승인(일반, 에스크로)
		$TRAN_CD_NOR_MGR        = "00201000";   // 변경(일반, 에스크로)

		/* -------------------------------------------------------------------------- */
		/* ::: 쇼핑몰 지불 정보 설정                                                  */
		/* -------------------------------------------------------------------------- */
		$g_gw_url    = $this->g_gw_url;               // Gateway URL ( test )
		//$g_gw_url               = "gw.easypay.co.kr";      // Gateway URL ( real )
		$g_gw_port   = $this->g_gw_port;                                           // 포트번호(변경불가)

		/* -------------------------------------------------------------------------- */
		/* ::: 지불 데이터 셋업 (업체에 맞게 수정)                                    */
		/* -------------------------------------------------------------------------- */
		/* ※ 주의 ※                                                                 */
		/* cert_file 변수 설정                                                        */
		/* - pg_cert.pem 파일이 있는 디렉토리의  절대 경로 설정                       */
		/* log_dir 변수 설정                                                          */
		/* - log 디렉토리 설정                                                        */
		/* log_level 변수 설정                                                        */
		/* - log 레벨 설정(1 to 99(높을수록 상세))                                    */
		/* -------------------------------------------------------------------------- */
		$g_home_dir   = $this->g_home_dir;
		$g_cert_file  = $this->g_home_dir.'/cert/pg_cert.pem';
		$g_log_dir    = $this->g_log_dir;
		$g_log_level  = "1";

		$g_mall_id   = $params[$this->params_prefix."mall_id"];              // [필수]몰아이디

		// 전달받은 몰 아이디와 세팅되어있는 몰 아이디 비교
		if($this->pg['mallCode'] != $g_mall_id){
			$pg_call_result['res_cd'] = 'GABIA-9999';
			$pg_call_result['res_msg'] = 'KICC 모듈 호출 실패['.$this->pg['mallCode'].']['.$g_mall_id.']';
			return $pg_call_result;
		}

		/* -------------------------------------------------------------------------- */
		/* ::: 플러그인 응답정보 설정                                                 */
		/* -------------------------------------------------------------------------- */
		$tr_cd            = $params[$this->params_prefix."tr_cd"];           // [필수]요청구분
		$trace_no         = $params[$this->params_prefix."trace_no"];        // [필수]추적고유번호
		$sessionkey       = $params[$this->params_prefix."sessionkey"];      // [필수]암호화키
		$encrypt_data     = $params[$this->params_prefix."encrypt_data"];    // [필수]암호화 데이타
		$pay_type         = $params[$this->params_prefix."ret_pay_type"];    // [선택]결제수단
		$complex_yn       = $params[$this->params_prefix."ret_complex_yn"];  // [선택]복합결제유무
		$card_code        = $params[$this->params_prefix."card_code"];       // [선택]신용카드 카드코드
		/* -------------------------------------------------------------------------- */
		/* ::: 결제 주문 정보 설정                                                    */
		/* -------------------------------------------------------------------------- */
		$order_no         = $params[$this->params_prefix."order_no"];        // [필수]주문번호
		$memb_user_no     = $params[$this->params_prefix."memb_user_no"];    // [선택]가맹점 고객일련번호
		$user_id          = $params[$this->params_prefix."user_id"];         // [선택]고객 ID
		$user_nm          = $params[$this->params_prefix."user_name"];       // [필수]고객명
		$user_mail        = $params[$this->params_prefix."user_mail"];       // [필수]고객 E-mail
		$user_phone1      = $params[$this->params_prefix."user_phone1"];     // [필수]가맹점 고객 연락처1
		$user_phone2      = $params[$this->params_prefix."user_phone2"];     // [선택]가맹점 고객 연락처2
		$user_addr        = $params[$this->params_prefix."user_addr"];       // [선택]가맹점 고객 주소
		$product_type     = $params[$this->params_prefix."product_type"];    // [필수]상품정보구분[0:실물,1:컨텐츠]
		$product_nm       = $params[$this->params_prefix."product_nm"];      // [필수]상품명
		$product_amt      = $params[$this->params_prefix."product_amt"];     // [필수]상품금액
		$tax_flg          = $params[$this->params_prefix."tax_flg"];         // [선택]과세서비스 구분 플래그
		$com_tax_amt      = $params[$this->params_prefix."com_tax_amt"];     // [선택]과세 승인 금액
		$com_free_amt     = $params[$this->params_prefix."com_free_amt"];    // [선택]비과세 승인 금액
		$com_vat_amt      = $params[$this->params_prefix."com_vat_amt"];     // [선택]부가세 금액
		/* -------------------------------------------------------------------------- */
		/* ::: 변경관리 정보 설정                                                     */
		/* -------------------------------------------------------------------------- */
		$mgr_txtype       = $params["mgr_txtype"];         // [필수]거래구분
		$mgr_subtype      = $params["mgr_subtype"];        // [선택]변경세부구분
		$org_cno          = $params["org_cno"];            // [필수]원거래고유번호
		$mgr_amt          = (string)$params["mgr_amt"];            // [선택]부분취소/환불요청 금액
		$mgr_rem_amt      = (string)$params["mgr_rem_amt"];        // [선택]부분취소 잔액
		$mgr_bank_cd      = $params["mgr_bank_cd"];        // [선택]환불계좌 은행코드
		$mgr_account      = $params["mgr_account"];        // [선택]환불계좌 번호
		$mgr_depositor    = $params["mgr_depositor"];      // [선택]환불계좌 예금주명
		$mgr_socno        = $params["mgr_socno"];          // [선택]환불계좌 주민번호
		$mgr_telno        = $params["mgr_telno"];          // [선택]환불고객 연락처
		$deli_cd          = $params["deli_cd"];            // [선택]배송구분[자가:DE01,택배:DE02]
		$deli_corp_cd     = $params["deli_corp_cd"];       // [선택]택배사코드
		$deli_invoice     = $params["deli_invoice"];       // [선택]운송장 번호
		$deli_rcv_nm      = $params["deli_rcv_nm"];        // [선택]수령인 이름
		$deli_rcv_tel     = $params["deli_rcv_tel"];       // [선택]수령인 연락처
		$client_ip        = $params["req_ip"];             // [필수]요청자 IP
		$req_id           = $params["req_id"];             // [선택]요청자 ID
		$mgr_msg          = $params["mgr_msg"];            // [선택]변경 사유
		$mgr_paytype      = $params["mgr_paytype"];        // [선택]결제수단
		$mgr_tax_flg      = $params["mgr_tax_flg"];        // [필수]과세구분 플래그
		$mgr_tax_amt      = (string)$params["mgr_tax_amt"];        // [필수]과세부분 취소 금액
		$mgr_free_amt     = (string)$params["mgr_free_amt"];       // [필수]비과세 부분취소 금액
		$mgr_vat_amt      = (string)$params["mgr_vat_amt"];        // [필수]부가세 부분취소 금액

		/* -------------------------------------------------------------------------- */
		/* ::: 전문                                                                   */
		/* -------------------------------------------------------------------------- */
		$mgr_data    = "";     // 변경정보
		$mall_data   = "";     // 요청전문

		/* -------------------------------------------------------------------------- */
		/* ::: 결제 결과                                                              */
		/* -------------------------------------------------------------------------- */
		$bDBProc              = "";
		$res_cd               = "";
		$res_msg              = "";
		$r_cno                = "";     //PG거래번호
		$r_amount             = "";     //총 결제금액
		$r_order_no           = "";     //주문번호
		$r_auth_no            = "";     //승인번호
		$r_tran_date          = "";     //승인일시
		$r_escrow_yn          = "";     //에스크로 사용유무
		$r_complex_yn         = "";     //복합결제 유무
		$r_stat_cd            = "";     //상태코드
		$r_stat_msg           = "";     //상태메시지
		$r_pay_type           = "";     //결제수단
		$r_mall_id            = "";     //가맹점 Mall ID
		$r_card_no            = "";     //카드번호
		$r_issuer_cd          = "";     //발급사코드
		$r_issuer_nm          = "";     //발급사명
		$r_acquirer_cd        = "";     //매입사코드
		$r_acquirer_nm        = "";     //매입사명
		$r_install_period     = "";     //할부개월
		$r_noint              = "";     //무이자여부
		$r_part_cancel_yn     = "";     //부분취소 가능여부
		$r_card_gubun         = "";     //신용카드 종류
		$r_card_biz_gubun     = "";     //신용카드 구분
		$r_cpon_flag          = "";     //쿠폰사용유무
		$r_cc_expr_date       = "";     //신용카드 유효기간
		$r_bank_cd            = "";     //은행코드
		$r_bank_nm            = "";     //은행명
		$r_account_no         = "";     //계좌번호
		$r_deposit_nm         = "";     //입금자명
		$r_expire_date        = "";     //계좌사용만료일
		$r_cash_res_cd        = "";     //현금영수증 결과코드
		$r_cash_res_msg       = "";     //현금영수증 결과메세지
		$r_cash_auth_no       = "";     //현금영수증 승인번호
		$r_cash_tran_date     = "";     //현금영수증 승인일시
		$r_cash_issue_type    = "";     //현금영수증발행용도
		$r_cash_auth_type     = "";     //인증구분
		$r_cash_auth_value    = "";     //인증번호
		$r_auth_id            = "";     //PhoneID
		$r_billid             = "";     //인증번호
		$r_mobile_no          = "";     //휴대폰번호
		$r_mob_ansim_yn       = "";     //안심결제 사용유무
		$r_ars_no             = "";     //전화번호
		$r_cp_cd              = "";     //포인트사/쿠폰사
		$r_pnt_auth_no        = "";     //포인트승인번호
		$r_pnt_tran_date      = "";     //포인트승인일시
		$r_used_pnt           = "";     //사용포인트
		$r_remain_pnt         = "";     //잔여한도
		$r_pay_pnt            = "";     //할인/발생포인트
		$r_accrue_pnt         = "";     //누적포인트
		$r_deduct_pnt         = "";     //총차감 포인트
		$r_payback_pnt        = "";     //payback 포인트
		$r_cpon_auth_no       = "";     //쿠폰승인번호
		$r_cpon_tran_date     = "";     //쿠폰승인일시
		$r_cpon_no            = "";     //쿠폰번호
		$r_remain_cpon        = "";     //쿠폰잔액
		$r_used_cpon          = "";     //쿠폰 사용금액
		$r_rem_amt            = "";     //잔액
		$r_bk_pay_yn          = "";     //장바구니 결제여부
		$r_canc_acq_date      = "";     //매입취소일시
		$r_canc_date          = "";     //취소일시
		$r_refund_date        = "";     //환불예정일시


		/* -------------------------------------------------------------------------- */
		/* ::: EasyPayClient 인스턴스 생성 [변경불가 !!].                             */
		/* -------------------------------------------------------------------------- */
		$easyPay = new EasyPay_Client;         // 전문처리용 Class (library에서 정의됨)
		$easyPay->clearup_msg();

		$easyPay->set_home_dir($g_home_dir);
		$easyPay->set_gw_url($g_gw_url);
		$easyPay->set_gw_port($g_gw_port);
		$easyPay->set_log_dir($g_log_dir);
		$easyPay->set_log_level($g_log_level);
		$easyPay->set_cert_file($g_cert_file);
		/* -------------------------------------------------------------------------- */
		/* ::: IP 정보 설정                                                           */
		/* -------------------------------------------------------------------------- */
		$client_ip        = getenv( "REMOTE_ADDR"	) ? getenv( "REMOTE_ADDR"	) : gethostbyname(gethostname());         // [필수]결제고객 IP

		/* -------------------------------------------------------------------------- */
		/* ::: 승인요청(플러그인 암호화 전문 설정)                                    */
		/* -------------------------------------------------------------------------- */
		if( $TRAN_CD_NOR_PAYMENT == $tr_cd ) {
			//승인요청 전문 설정
			$easyPay->set_trace_no($trace_no);
			$easyPay->set_snd_key($sessionkey);
			$easyPay->set_enc_data($encrypt_data);
		/* -------------------------------------------------------------------------- */
		/* ::: 변경관리 요청                                                          */
		/* -------------------------------------------------------------------------- */
		}else if( $TRAN_CD_NOR_MGR == $tr_cd ) {
			$mgr_data = $easyPay->set_easypay_item("mgr_data");
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_txtype"    , $mgr_txtype    );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_subtype"   , $mgr_subtype   );
			$easyPay->set_easypay_deli_us( $mgr_data, "org_cno"       , $org_cno       );
			$easyPay->set_easypay_deli_us( $mgr_data, "order_no"      , $order_no      );
			$easyPay->set_easypay_deli_us( $mgr_data, "pay_type"      , $pay_type      );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_amt"       , $mgr_amt       );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_tax_flg"   , $mgr_tax_flg   );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_tax_amt"   , $mgr_tax_amt   );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_free_amt"  , $mgr_free_amt  );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_vat_amt"   , $mgr_vat_amt   );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_bank_cd"   , $mgr_bank_cd   );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_account"   , $mgr_account   );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_depositor" , $mgr_depositor );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_socno"     , $mgr_socno     );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_telno"     , $mgr_telno     );
			$easyPay->set_easypay_deli_us( $mgr_data, "deli_cd"       , $deli_cd       );
			$easyPay->set_easypay_deli_us( $mgr_data, "deli_corp_cd"  , $deli_corp_cd  );
			$easyPay->set_easypay_deli_us( $mgr_data, "deli_invoice"  , $deli_invoice  );
			$easyPay->set_easypay_deli_us( $mgr_data, "deli_rcv_nm"   , $deli_rcv_nm   );
			$easyPay->set_easypay_deli_us( $mgr_data, "deli_rcv_tel"  , $deli_rcv_tel  );
			$easyPay->set_easypay_deli_us( $mgr_data, "req_ip"        , $client_ip     );
			$easyPay->set_easypay_deli_us( $mgr_data, "req_id"        , $req_id        );
			$easyPay->set_easypay_deli_us( $mgr_data, "mgr_msg"       , $mgr_msg       );
		}


		/* -------------------------------------------------------------------------- */
		/* ::: 실행                                                                   */
		/* -------------------------------------------------------------------------- */
		$opt = "option value";    // utf-8
		$easyPay->easypay_exec($g_mall_id, $tr_cd, $order_no, $client_ip, $opt);
		$exec['res_cd'             ] = $easyPay->_easypay_resdata["res_cd"];    // 응답코드
		$exec['res_msg'            ] = $easyPay->_easypay_resdata["res_msg"];   // 응답메시지

		/* -------------------------------------------------------------------------- */
		/* ::: 결과 처리                                                              */
		/* -------------------------------------------------------------------------- */
		$exec['r_cno'              ] = $easyPay->_easypay_resdata[ "cno"             ];     //PG거래번호
		$exec['r_amount'           ] = $easyPay->_easypay_resdata[ "amount"          ];     //총 결제금액
		$exec['r_order_no'         ] = $easyPay->_easypay_resdata[ "order_no"        ];     //주문번호
		$exec['r_auth_no'          ] = $easyPay->_easypay_resdata[ "auth_no"         ];     //승인번호
		$exec['r_tran_date'        ] = $easyPay->_easypay_resdata[ "tran_date"       ];     //승인일시
		$exec['r_escrow_yn'        ] = $easyPay->_easypay_resdata[ "escrow_yn"       ];     //에스크로 사용유무
		$exec['r_complex_yn'       ] = $easyPay->_easypay_resdata[ "complex_yn"      ];     //복합결제 유무
		$exec['r_stat_cd'          ] = $easyPay->_easypay_resdata[ "stat_cd"         ];     //상태코드
		$exec['r_stat_msg'         ] = $easyPay->_easypay_resdata[ "stat_msg"        ];     //상태메시지
		$exec['r_pay_type'         ] = $easyPay->_easypay_resdata[ "pay_type"        ];     //결제수단
		$exec['r_mall_id'          ] = $easyPay->_easypay_resdata[ "mall_id"         ];     //가맹점 Mall ID
		$exec['r_card_no'          ] = $easyPay->_easypay_resdata[ "card_no"         ];     //카드번호
		$exec['r_issuer_cd'        ] = $easyPay->_easypay_resdata[ "issuer_cd"       ];     //발급사코드
		$exec['r_issuer_nm'        ] = $easyPay->_easypay_resdata[ "issuer_nm"       ];     //발급사명
		$exec['r_acquirer_cd'      ] = $easyPay->_easypay_resdata[ "acquirer_cd"     ];     //매입사코드
		$exec['r_acquirer_nm'      ] = $easyPay->_easypay_resdata[ "acquirer_nm"     ];     //매입사명
		$exec['r_install_period'   ] = $easyPay->_easypay_resdata[ "install_period"  ];     //할부개월
		$exec['r_noint'            ] = $easyPay->_easypay_resdata[ "noint"           ];     //무이자여부
		$exec['r_part_cancel_yn'   ] = $easyPay->_easypay_resdata[ "part_cancel_yn"  ];     //부분취소 가능여부
		$exec['r_card_gubun'       ] = $easyPay->_easypay_resdata[ "card_gubun"      ];     //신용카드 종류
		$exec['r_card_biz_gubun'   ] = $easyPay->_easypay_resdata[ "card_biz_gubun"  ];     //신용카드 구분
		$exec['r_cpon_flag'        ] = $easyPay->_easypay_resdata[ "cpon_flag"       ];     //쿠폰사용유무
		$exec['r_cc_expr_date'     ] = $easyPay->_easypay_resdata[ "cc_expr_date"    ];     //신용카드 유효기간
		$exec['r_bank_cd'          ] = $easyPay->_easypay_resdata[ "bank_cd"         ];     //은행코드
		$exec['r_bank_nm'          ] = $easyPay->_easypay_resdata[ "bank_nm"         ];     //은행명
		$exec['r_account_no'       ] = $easyPay->_easypay_resdata[ "account_no"      ];     //계좌번호
		$exec['r_deposit_nm'       ] = $easyPay->_easypay_resdata[ "deposit_nm"      ];     //입금자명
		$exec['r_expire_date'      ] = $easyPay->_easypay_resdata[ "expire_date"     ];     //계좌사용만료일
		$exec['r_cash_res_cd'      ] = $easyPay->_easypay_resdata[ "cash_res_cd"     ];     //현금영수증 결과코드
		$exec['r_cash_res_msg'     ] = $easyPay->_easypay_resdata[ "cash_res_msg"    ];     //현금영수증 결과메세지
		$exec['r_cash_auth_no'     ] = $easyPay->_easypay_resdata[ "cash_auth_no"    ];     //현금영수증 승인번호
		$exec['r_cash_tran_date'   ] = $easyPay->_easypay_resdata[ "cash_tran_date"  ];     //현금영수증 승인일시
		$exec['r_cash_issue_type'  ] = $easyPay->_easypay_resdata[ "cash_issue_type" ];     //현금영수증발행용도
		$exec['r_cash_auth_type'   ] = $easyPay->_easypay_resdata[ "cash_auth_type"  ];     //인증구분
		$exec['r_cash_auth_value'  ] = $easyPay->_easypay_resdata[ "cash_auth_value" ];     //인증번호
		$exec['r_auth_id'          ] = $easyPay->_easypay_resdata[ "auth_id"         ];     //PhoneID
		$exec['r_billid'           ] = $easyPay->_easypay_resdata[ "billid"          ];     //인증번호
		$exec['r_mobile_no'        ] = $easyPay->_easypay_resdata[ "mobile_no"       ];     //휴대폰번호
		$exec['r_mob_ansim_yn'     ] = $easyPay->_easypay_resdata[ "mob_ansim_yn"    ];     //안심결제 사용유무
		$exec['r_ars_no'           ] = $easyPay->_easypay_resdata[ "ars_no"          ];     //전화번호
		$exec['r_cp_cd'            ] = $easyPay->_easypay_resdata[ "cp_cd"           ];     //포인트사/쿠폰사
		$exec['r_pnt_auth_no'      ] = $easyPay->_easypay_resdata[ "pnt_auth_no"     ];     //포인트승인번호
		$exec['r_pnt_tran_date'    ] = $easyPay->_easypay_resdata[ "pnt_tran_date"   ];     //포인트승인일시
		$exec['r_used_pnt'         ] = $easyPay->_easypay_resdata[ "used_pnt"        ];     //사용포인트
		$exec['r_remain_pnt'       ] = $easyPay->_easypay_resdata[ "remain_pnt"      ];     //잔여한도
		$exec['r_pay_pnt'          ] = $easyPay->_easypay_resdata[ "pay_pnt"         ];     //할인/발생포인트
		$exec['r_accrue_pnt'       ] = $easyPay->_easypay_resdata[ "accrue_pnt"      ];     //누적포인트
		$exec['r_deduct_pnt'       ] = $easyPay->_easypay_resdata[ "deduct_pnt"      ];     //총차감 포인트
		$exec['r_payback_pnt'      ] = $easyPay->_easypay_resdata[ "payback_pnt"     ];     //payback 포인트
		$exec['r_cpon_auth_no'     ] = $easyPay->_easypay_resdata[ "cpon_auth_no"    ];     //쿠폰승인번호
		$exec['r_cpon_tran_date'   ] = $easyPay->_easypay_resdata[ "cpon_tran_date"  ];     //쿠폰승인일시
		$exec['r_cpon_no'          ] = $easyPay->_easypay_resdata[ "cpon_no"         ];     //쿠폰번호
		$exec['r_remain_cpon'      ] = $easyPay->_easypay_resdata[ "remain_cpon"     ];     //쿠폰잔액
		$exec['r_used_cpon'        ] = $easyPay->_easypay_resdata[ "used_cpon"       ];     //쿠폰 사용금액
		$exec['r_rem_amt'          ] = $easyPay->_easypay_resdata[ "rem_amt"         ];     //잔액
		$exec['r_bk_pay_yn'        ] = $easyPay->_easypay_resdata[ "bk_pay_yn"       ];     //장바구니 결제여부
		$exec['r_canc_acq_date'    ] = $easyPay->_easypay_resdata[ "canc_acq_date"   ];     //매입취소일시
		$exec['r_canc_date'        ] = $easyPay->_easypay_resdata[ "canc_date"       ];     //취소일시
		$exec['r_refund_date'      ] = $easyPay->_easypay_resdata[ "refund_date"     ];     //환불예정일시

		// 기존 소스 호환을 위한 변수화처리
		extract($exec);

		/* -------------------------------------------------------------------------- */
		/* ::: 가맹점 DB 처리                                                         */
		/* -------------------------------------------------------------------------- */
		/* 응답코드(res_cd)가 "0000" 이면 정상승인 입니다.                            */
		/* r_amount가 주문DB의 금액과 다를 시 반드시 취소 요청을 하시기 바랍니다.     */
		/* DB 처리 실패 시 취소 처리를 해주시기 바랍니다.                             */
		/* -------------------------------------------------------------------------- */
		if ( $res_cd == "0000" ) {
			$bDBProc = "false";     // DB처리 성공 시 "true", 실패 시 "false"

			// =====================================================
			// DB 처리 시작
			// =====================================================
			try{
				/* -------------------------------------------------------------------------- */
				/* ::: 승인요청(플러그인 암호화 전문 설정)                                    */
				/* -------------------------------------------------------------------------- */
				if( $TRAN_CD_NOR_PAYMENT == $tr_cd ) {
					// 결제 승인 처리
					$bDBProc = $this->_procPayKicc($exec);
				/* -------------------------------------------------------------------------- */
				/* ::: 변경관리 요청                                                          */
				/* -------------------------------------------------------------------------- */
				}else if( $TRAN_CD_NOR_MGR == $tr_cd ) {
					// 결제 변경(취소) 처리
					$bDBProc = $this->_procCancelKicc($exec);
				}

				// 주문번호 설정
				$pg_call_result['order_seq'] = $exec['r_order_no'];

			}catch(Exception $e){
				$this->createKiccLog($e);
				$bDBProc = "false";
			}
			// =====================================================
			// DB 처리 종료
			// =====================================================

			if ( $bDBProc != "true" ) {
				// 승인요청이 실패 시 아래 실행
				if( $TRAN_CD_NOR_PAYMENT == $tr_cd ) {
					$easyPay->clearup_msg();

					$tr_cd = $TRAN_CD_NOR_MGR;
					$mgr_data = $easyPay->set_easypay_item("mgr_data");
					if ( $r_escrow_yn != "Y" )
					{
						$easyPay->set_easypay_deli_us( $mgr_data, "mgr_txtype"      , "40"   );
					}
					else
					{
						$easyPay->set_easypay_deli_us( $mgr_data, "mgr_txtype"      , "61"   );
						$easyPay->set_easypay_deli_us( $mgr_data, "mgr_subtype"     , "ES02" );
					}
					$easyPay->set_easypay_deli_us( $mgr_data, "org_cno"         , $r_cno     );
					$easyPay->set_easypay_deli_us( $mgr_data, "order_no"          , $order_no );
					$easyPay->set_easypay_deli_us( $mgr_data, "req_ip"          , $client_ip );
					$easyPay->set_easypay_deli_us( $mgr_data, "req_id"          , "MALL_R_TRANS" );
					$easyPay->set_easypay_deli_us( $mgr_data, "mgr_msg"         , "DB 처리 실패로 망취소"  );

					$easyPay->easypay_exec($g_mall_id, $tr_cd, $order_no, $client_ip, $opt);
					$res_cd      = $easyPay->_easypay_resdata["res_cd"     ];    // 응답코드
					$res_msg     = $easyPay->_easypay_resdata["res_msg"    ];    // 응답메시지
					$r_cno       = $easyPay->_easypay_resdata["cno"        ];    // PG거래번호
					$r_canc_date = $easyPay->_easypay_resdata["canc_date"  ];    // 취소일시
				}
			}
		}
		// 결과메세지 반환
		$pg_call_result['res_cd'] = $res_cd;
		$pg_call_result['res_msg'] = $res_msg;
		return $pg_call_result;
	}

	// kicc 노티 호출
	public function receiveKiccNoti($params){
		// 로깅
		$this->createKiccLog($params, 'noti');

		$pg_receive_result = array(
			'res_cd' => $params['res_cd'],
			'res_msg' => $params['res_msg'],
		);

		/* -------------------------------------------------------------------------- */
		/* ::: 노티수신                                                               */
		/* -------------------------------------------------------------------------- */
		$result_msg = "";

		$exec['r_res_cd'         ] = $params[ "res_cd"         ];  // 응답코드
		$exec['r_res_msg'        ] = $params[ "res_msg"        ];  // 응답 메시지
		$exec['r_cno'            ] = $params[ "cno"            ];  // PG거래번호
		$exec['r_memb_id'        ] = $params[ "memb_id"        ];  // 가맹점 ID
		$exec['r_amount'         ] = $params[ "amount"         ];  // 총 결제금액
		$exec['r_order_no'       ] = $params[ "order_no"       ];  // 주문번호
		$exec['r_noti_type'      ] = $params[ "noti_type"      ];  // 노티구분 변경(20), 입금(30), 에스크로 변경(40)
		$exec['r_auth_no'        ] = $params[ "auth_no"        ];  // 승인번호
		$exec['r_tran_date'      ] = $params[ "tran_date"      ];  // 승인일시
		$exec['r_card_no'        ] = $params[ "card_no"        ];  // 카드번호
		$exec['r_issuer_cd'      ] = $params[ "issuer_cd"      ];  // 발급사코드
		$exec['r_issuer_nm'      ] = $params[ "issuer_nm"      ];  // 발급사명
		$exec['r_acquirer_cd'    ] = $params[ "acquirer_cd"    ];  // 매입사코드
		$exec['r_acquirer_nm'    ] = $params[ "acquirer_nm"    ];  // 매입사명
		$exec['r_install_period' ] = $params[ "install_period" ];  // 할부개월
		$exec['r_noint'          ] = $params[ "noint"          ];  // 무이자여부
		$exec['r_bank_cd'        ] = $params[ "bank_cd"        ];  // 은행코드
		$exec['r_bank_nm'        ] = $params[ "bank_nm"        ];  // 은행명
		$exec['r_account_no'     ] = $params[ "account_no"     ];  // 계좌번호
		$exec['r_deposit_nm'     ] = $params[ "deposit_nm"     ];  // 입금자명
		$exec['r_expire_date'    ] = $params[ "expire_date"    ];  // 계좌사용만료일
		$exec['r_cash_res_cd'    ] = $params[ "cash_res_cd"    ];  // 현금영수증 결과코드
		$exec['r_cash_res_msg'   ] = $params[ "cash_res_msg"   ];  // 현금영수증 결과메시지
		$exec['r_cash_auth_no'   ] = $params[ "cash_auth_no"   ];  // 현금영수증 승인번호
		$exec['r_cash_tran_date' ] = $params[ "cash_tran_date" ];  // 현금영수증 승인일시
		$exec['r_cp_cd'          ] = $params[ "cp_cd"          ];  // 포인트사
		$exec['r_used_pnt'       ] = $params[ "used_pnt"       ];  // 사용포인트
		$exec['r_remain_pnt'     ] = $params[ "remain_pnt"     ];  // 잔여한도
		$exec['r_pay_pnt'        ] = $params[ "pay_pnt"        ];  // 할인/발생포인트
		$exec['r_accrue_pnt'     ] = $params[ "accrue_pnt"     ];  // 누적포인트
		$exec['r_escrow_yn'      ] = $params[ "escrow_yn"      ];  // 에스크로 사용유무
		$exec['r_canc_date'      ] = $params[ "canc_date"      ];  // 취소일시
		$exec['r_canc_acq_date'  ] = $params[ "canc_acq_date"  ];  // 매입취소일시
		$exec['r_refund_date'    ] = $params[ "refund_date"    ];  // 환불예정일시
		$exec['r_pay_type'       ] = $params[ "pay_type"       ];  // 결제수단
		$exec['r_auth_cno'       ] = $params[ "auth_cno"       ];  // 인증거래번호
		$exec['r_tlf_sno'        ] = $params[ "tlf_sno"        ];  // 채번거래번호
		$exec['r_account_type'   ] = $params[ "account_type"   ];  // 채번계좌 타입 US AN 1 (V-일반형, F-고정형)

		/* --------------------------------------------------------------------------- */
		/* ::: 노티수신 - 에스크로 상태변경                                           */
		/* -------------------------------------------------------------------------- */
		$exec['r_escrow_yn'      ] = $params[ "escrow_yn"      ];  // 에스크로유무
		$exec['r_stat_cd'        ] = $params[ "stat_cd "       ];  // 변경에스크로상태코드
		$exec['r_stat_msg'       ] = $params[ "stat_msg"       ];  // 변경에스크로상태메세지

		// 기존 소스 호환을 위한 변수화처리
		extract($exec);

		if ( $r_res_cd == "0000" )
		{
			/* ---------------------------------------------------------------------- */
			/* ::: 가맹점 DB 처리                                                     */
			/* ---------------------------------------------------------------------- */
			/* DB처리 성공 시 : res_cd=0000, 실패 시 : res_cd=5001                    */
			/* ---------------------------------------------------------------------- */
			$bDBProc = 'false';
			// =====================================================
			// DB 처리 시작
			// =====================================================
			try{
				$bDBProc = $this->_procReceiveNotiKicc($exec);

			}catch(Exception $e){
				$this->createKiccLog($e);
				$bDBProc = 'false';
			}
			// =====================================================
			// DB 처리 종료
			// =====================================================
			if($bDBProc == 'true'){
				$pg_receive_result['res_cd'] = '0000';
			}else{
				$pg_receive_result['res_cd'] = '5001';
			}
		}

		/* -------------------------------------------------------------------------- */
		/* ::: 노티 처리결과 처리                                                     */
		/* -------------------------------------------------------------------------- */
		if($pg_receive_result['res_cd'] == '0000'){
			$result_msg = "res_cd=0000" . chr(31) . "res_msg=SUCCESS";
		}else{
			$result_msg = "res_cd=5001" . chr(31) . "res_msg=FAIL";
		}
		return $result_msg;
	}
	protected function _procPayKicc($exec){
		$this->CI->load->helper('order');
		$this->CI->load->helper('shipping');

		$this->CI->load->model('cartmodel');
		$this->CI->load->model('ordermodel');
		$this->CI->load->model('membermodel');
		$this->CI->load->model('couponmodel');
		$this->CI->load->model('goodsmodel');
		$this->CI->load->model('promotionmodel');
		$this->CI->load->model('paymentlog');
		$this->CI->load->library('added_payment');
		$this->CI->load->model('reDepositmodel');

		$platForm = 'P';
		$pageUrl = $this->CI->uri->segment(2);
		if ($this->CI->_is_mobile_agent) {
			$platForm = 'M';
		}

		$this->CI->added_payment->write_log($exec['r_order_no'], $platForm, 'kicc', $pageUrl, 'process0100', $exec);

		// 리턴값 설정
		$bDBProc = "false";
		try{
			$ordr_idxx = $exec['r_order_no']; //주문번호
			$tno = $exec['r_cno']; //PG거래번호
			$settleprice = $exec['r_amount']; //총 결제금액
			$app_time = $exec['r_tran_date']; //승인일시
			$app_no = $exec['r_auth_no']; //승인번호
			$card_cd = $exec['r_issuer_cd']; //발급사코드
			$CARD_NM = $exec['r_issuer_nm']; //발급사명
			$noinf = $exec['r_noint']; //무이자여부
			$quota = $exec['r_install_period']; //할부개월
			$bank_name = $exec['r_bank_nm']; //은행명
			$bank_code = $exec['r_bank_cd']; //은행코드
			$depositor = $exec['r_deposit_nm']; //입금자명
			$account = $exec['r_account_no']; //계좌번호
			$mobile_no = $exec['r_mobile_no']; //발급사코드
			$va_date = $exec['r_expire_date']; //계좌사용만료일
			$res_cd = $exec['res_cd']; // 응답코드
			$res_msg = $exec['res_msg']; // 응답메시지
			$CARD_NM = iconv("euc-kr", "utf-8", $CARD_NM);
			$bank_name = iconv("euc-kr", "utf-8", $bank_name);
			$depositor = iconv("euc-kr", "utf-8", $depositor);
			$res_msg = iconv("euc-kr", "utf-8", $res_msg);
			$biller = $depositor; //입금자명  결제 성공 처리용

			## 주문서 정보
			$orders	= $this->CI->ordermodel->get_order($ordr_idxx);
			$result_option = $this->CI->ordermodel->get_item_option($ordr_idxx);
			$result_suboption = $this->CI->ordermodel->get_item_suboption($ordr_idxx);
			$data_shipping	= $this->CI->ordermodel->get_order_shipping($ordr_idxx);

			if ($orders['orign_order_seq']) {
				$add_log = "[재주문]";
			}
			if ($orders['admin_order']) {
				$add_log = "[관리자주문]";
			}
			if ($orders['person_seq']) {
				$add_log = "[개인결제]";
			}

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

			## 가격 검증
			if ($orders['settleprice'] != $settleprice) {
				throw new Exception('가격이 일치하지 않음.', 402);
			}

			// 결제 시작 마킹
			if ($orders['order_seq']) {
				$reDepositSeq = $this->CI->reDepositmodel->insert(
					array(
						'order_seq' => $orders['order_seq'],
						'pg' => 'kicc',
						'params' => json_encode($exec),
						'regist_date' => date('Y-m-d H:i:s')
					)
				);
			}

			// 결제방법
			$order_payment = '';
			foreach ($this->arr_payment_code as $payment => $payment_code) {
				if ($exec['r_pay_type'] == $payment_code && !preg_match('/escrow/', $payment)) { // 에스크로 체크는 하단 프로세스로 처리
					$order_payment = $payment;
				}
			}
			$escw_yn = ($exec['r_escrow_yn']=='Y') ? 'Y' : 'N';
			if ($escw_yn == 'Y' && $order_payment) {
				$order_payment = 'escrow_' . $order_payment;
			}
			if ($order_payment) {
				$aOrderStep['payment'] = $order_payment;
			}

			$aOrderStep['pg_transaction_number'] = $tno;

			if ($res_cd == '0000') {

				// ================================================================
				// 결제 후 DB 처리 시작
				// ================================================================

				// 회원 마일리지 차감
				if ($orders['emoney'] > 0 && $orders['member_seq'] && $orders['emoney_use'] == 'none') {
					$params = array(
						'gb' => 'minus',
						'type' => 'order',
						'emoney' => $orders['emoney'],
						'ordno' => $ordr_idxx,
						'memo' => "[차감]주문 ({$ordr_idxx})에 의한 마일리지 차감",
						'memo_lang' => $this->CI->membermodel->make_json_for_getAlert("mp260", $ordr_idxx), // [차감]주문 (%s)에 의한 마일리지 차감
					);
					$this->CI->membermodel->emoney_insert($params, $orders['member_seq']);
					$this->CI->ordermodel->set_emoney_use($ordr_idxx, 'use');
				}

				// 회원 예치금 차감
				if ($orders['cash'] > 0 && $orders['member_seq'] && $orders['cash_use'] == 'none') {
					$params = array(
						'gb' => 'minus',
						'type' => 'order',
						'cash' => $orders['cash'],
						'ordno' => $ordr_idxx,
						'memo' => "[차감]주문 ({$ordr_idxx})에 의한 예치금 차감",
						'memo_lang'	=> $this->CI->membermodel->make_json_for_getAlert("mp261", $ordr_idxx), // [차감]주문 (%s)에 의한 예치금 차감
					);
					$this->CI->membermodel->cash_insert($params, $orders['member_seq']);
					$this->CI->ordermodel->set_cash_use($ordr_idxx, 'use');
				}

				// 상품쿠폰사용
				if ($result_option) {
					foreach ($result_option as $item_option) {
						if ($item_option['download_seq']) {
							$this->CI->couponmodel->set_download_use_status($item_option['download_seq'], 'used');
						}
					}
				}
				// 배송비쿠폰사용 @2015-06-22 pjm
				if ($data_shipping) {
					foreach ($data_shipping as $shipping) {
						if ($shipping['shipping_coupon_down_seq']) {
							$this->CI->couponmodel->set_download_use_status($shipping['shipping_coupon_down_seq'], 'used');
						}
					}
				}
				// 배송비쿠폰사용(사용안함)
				if ($orders['download_seq']) {
					$this->CI->couponmodel->set_download_use_status($orders['download_seq'], 'used');
				}

				// 주문서 쿠폰 사용처리
				if ($orders['ordersheet_seq']) {
					$this->CI->couponmodel->set_download_use_status($orders['ordersheet_seq'], 'used');
				}

				// 프로모션코드 상품/배송비 할인 사용처리
				$this->CI->promotionmodel->setPromotionpayment($orders);

				// 장바구니 비우기
				if ($orders['mode']) {
					$this->CI->cartmodel->delete_mode($orders['mode']);
				}

				// 결제 방식에 따른 분기 처리
				if (preg_match('/virtual/', $order_payment) ) { // 가상계좌나 에스크로인 경우
					$aOrderStep['virtual_account'] = trim($bank_name . ' ' . $account . ' ' . $biller);
					$aOrderStep['virtual_date'] = $va_date;
					$this->CI->ordermodel->set_step($ordr_idxx, '15', $aOrderStep);
					$this->CI->ordermodel->set_log($ordr_idxx, 'pay', $orders['order_user_name'], $add_log . "주문접수(" . $orders['mpayment'] . ")", "KICC 가상계좌 주문접수". chr(10)."[" .$res_cd . $res_msg . "]");
					$mail_step = 15;
				} else {
					$aOrderStep['pg_approval_number'] = $app_no;
					$this->CI->coupon_reciver_sms = array();
					$this->CI->coupon_order_sms = array();
					$order_count = 0;
					$this->CI->ordermodel->set_step($ordr_idxx, '25', $aOrderStep);
					$this->CI->ordermodel->set_log($ordr_idxx, 'pay', $orders['order_user_name'], $add_log . "결제확인(".$orders['mpayment'].")", "KICC 결제 확인" . chr(10) . "[" .$res_cd . $res_msg . "]");
					if( preg_match('/account/',$orders['payment']) ){ // 계좌이체 결제의 경우 현금영수증
						$result = typereceipt_setting($orders['order_seq']);
					}
					$mail_step = 25;
				}

				// 출고량 업데이트를 위한 변수선언
				$r_reservation_goods_seq = array();

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
					$this->CI->goodsmodel->modify_reservation_real($goods_seq);
				}

				if ($mail_step  == '25') {
					// 티켓상품 자동 출고처리구문 순차진행을 위해 분리함 @2017-08-16
					ticket_payexport_ck($orders['order_seq']);
					// 받는 사람 티켓상품 SMS 데이터
					if (count($this->CI->coupon_reciver_sms['order_cellphone']) > 0) {
						$order_count = 0;
						foreach ($this->CI->coupon_reciver_sms['order_cellphone'] as $key => $value) {
							$coupon_arr_params[$order_count] = $this->CI->coupon_reciver_sms['params'][$key];
							$coupon_order_no[$order_count] = $this->CI->coupon_reciver_sms['order_no'][$key];
							$coupon_order_cellphones[$order_count] = $this->CI->coupon_reciver_sms['order_cellphone'][$key];
							$order_count = $order_count + 1;
						}
						$commonSmsData['coupon_released']['phone'] = $coupon_order_cellphones;;
						$commonSmsData['coupon_released']['params'] = $coupon_arr_params;
						$commonSmsData['coupon_released']['order_no'] = $coupon_order_no;
					}
					// 주문자 티켓상품 SMS 데이터
					if (count($this->CI->coupon_order_sms['order_cellphone']) > 0) {
						$order_count = 0;
						foreach ($this->CI->coupon_order_sms['order_cellphone'] as $key=>$value) {
							$reciver_arr_params[$order_count] = $this->CI->coupon_order_sms['params'][$key];
							$reciver_order_no[$order_count] = $this->CI->coupon_order_sms['order_no'][$key];
							$reciver_order_cellphones[$order_count] = $this->CI->coupon_order_sms['order_cellphone'][$key];
							$order_count = $order_count + 1;
						}
						$commonSmsData['coupon_released2']['phone'] = $reciver_order_cellphones;;
						$commonSmsData['coupon_released2']['params'] = $reciver_arr_params;
						$commonSmsData['coupon_released2']['order_no'] = $reciver_order_no;
					}
				}

				if (count($commonSmsData) > 0) {
					commonSendSMS($commonSmsData);
				}

				// ================================================================
				// 결제 후 DB 처리 종료
				// ================================================================

				$this->CI->added_payment->write_log($orders['order_seq'], $platForm, 'kicc', $pageUrl, 'process0200', $exec); // 파일 로그 저장
				$bDBProc = "true"; // 결제 처리 성공 : 아무런 문제가 발생하지 않았을 경우 성공으로 처리
			} else {
				throw new Exception('응답코드 에러', 403);
			}
		} catch (Exception $e) {
			$errMsg = $e->getMessage();
			$errCode = $e->getCode();
			if ($errCode != '401') {
				$this->createKiccLog($e);
				switch ($errCode) {
					case '402' :
						$errMsg = 'Payment Fail : [settleprice]' . $orders['settleprice'] . '[amt]' . $settleprice;
					break;
					case '403' :
						$errMsg = 'Payment Fail : [res_cd]' . $res_cd;
					break;
				}
			}
			$this->CI->added_payment->write_log($orders['order_seq'], $platForm, 'kicc', $pageUrl, 'process0300', array('errorMsg' => $errMsg)); // 파일 로그 저장
			$bDBProc = "false";
		}

		// 결제 종료 마킹
		if ($reDepositSeq) {
			$this->CI->reDepositmodel->del(array('re_deposit_seq' => $reDepositSeq));
		}

		## 로그 저장
		$this->CI->added_payment->set_pg_log(
			array(
				'pg' => 'kicc',
				'order_seq' => $orders['order_seq'],
				'tno' => $tno,
				'amount' => $settleprice,
				'app_time' => $app_time,
				'app_no' => $app_no,
				'card_cd' => $card_cd,
				'card_name' => $CARD_NM,
				'noinf' => $noinf,
				'quota' => $quota,
				'bank_name' => $bank_name,
				'bank_code' => $bank_code,
				'depositor' => $depositor,
				'account' => $account,
				'commid' => $mobile_no,
				'va_date' => $va_date,
				'res_cd' => $res_cd,
				'res_msg' => $res_msg
			)
		);

		return $bDBProc;
	}
	// 현금영수증 발행 요청
	public function publishKiccReceipt($data){
		// $return 이 array가 아닌 경우 false로 간주
		$return = false;
		try{
			$data['taxParamMode'] = 'pay';
			$return = $this->callKiccModuleReceipt($data);
		}catch(Exception $e){
			$this->createKiccLog($e);
			$return = false;
		}
		return $return;
	}
	// 현금영수증 수정 요청
	public function modifyKiccReceipt($data){
		// $return 이 array가 아닌 경우 false로 간주
		$return = false;
		try{
			$data['taxParamMode'] = 'mod';
			$return = $this->callKiccModuleReceipt($data);
		}catch(Exception $e){
			$this->createKiccLog($e);
			$return = false;
		}
		return $return;
	}

	// kicc 취소의 경우 취소에 따른 DB 처리는 별도로 동작
	protected function _procCancelKicc($exec){
		// 리턴값 설정
		$bDBProc = "false";
		try{
			// 리턴값 설정
			$bDBProc = "true";
		}catch(Exception $e){
			$this->createKiccLog($e);
			$bDBProc = "false";
		}
		return $bDBProc;
	}

	// kicc noti
	protected function _procReceiveNotiKicc($exec){
		// 리턴값 설정
		$bDBProc = "false";
		try{
			$res_cd				= $exec['r_res_cd'         ];	// 응답코드		AN		4 		O		응답코드표 참조
			$res_msg			= $exec['r_res_msg'        ];	// 응답메시지		ANS		100 		O
			$cno				= $exec['r_cno'            ];	// PG거래번호		N		20 		O		KICC에서 부여된 거래번호(ARS신용카드 포함)
			$memb_id			= $exec['r_memb_id'        ];	// 가맹점 ID		AN		8 		O
			$amount				= $exec['r_amount'         ];	// 총 결제금액		N		14 		O
			$order_no			= $exec['r_order_no'       ];	// 주문번호		AN		40 		　		가맹점 주문번호
			$noti_type			= $exec['r_noti_type'      ];	// 노티구분		AN		2 		O		노티필수 승인:10 변경:20 입금:30
			$auth_no			= $exec['r_auth_no'        ];	// 승인번호		AN		20 		　
			$tran_date			= $exec['r_tran_date'      ];	// 승인/변경 일시		N		14 		O
			$card_no			= $exec['r_card_no'        ];	// 카드번호		AN		40 		　
			$issuer_cd			= $exec['r_issuer_cd'      ];	// 발급사코드		AN		3 		　
			$issuer_nm			= $exec['r_issuer_nm'      ];	// 발급사명		AN		20 		　
			$acquirer_cd		= $exec['r_acquirer_cd'    ];	// 매입사코드		N		3 		　
			$acquirer_nm		= $exec['r_acquirer_nm'    ];	// 매입사명		AN		20 		　
			$install_period		= $exec['r_install_period' ];	// 할부개월		N		2 		　
			$noint				= $exec['r_noint'          ];	// 무이자여부		N		2 		　
			$bank_cd			= $exec['r_bank_cd'        ];	// 은행코드		N		3 		O
			$bank_nm			= $exec['r_bank_nm'        ];	// 은행명		N		20 		　
			$account_no			= $exec['r_account_no'     ];	// 계좌번호		N		20 		O
			$deposit_nm			= $exec['r_deposit_nm'     ];	// 입금자명		AN		10 		O
			$expire_date		= $exec['r_expire_date'    ];	// 계좌사용만료일		N		14 		　
			$cp_cd				= $exec['r_cp_cd'          ];	// 포인트사		AN		3 		　
			$used_pnt			= $exec['r_used_pnt'       ];	// 사용포인트		N		9 		　
			$remain_pnt			= $exec['r_remain_pnt'     ];	// 잔여한도		N		9 		　
			$pay_pnt			= $exec['r_pay_pnt'        ];	// 할인/발생포인트		N		9 		　
			$accrue_pnt			= $exec['r_accrue_pnt'     ];	// 누적포인트		N		9 		　
			$pay_type			= $exec['r_pay_type'       ];	// 결제수단		N		4 		O		11:카드, 21:계좌이체, 22:가상계좌
			$auth_cno			= $exec['r_auth_cno'       ];	// 인증거래번호		AN		20 		O
			$tlf_cno			= $exec['r_tlf_cno'        ];	// 채번거래번호		AN		20		　
			$account_type		= $exec['r_account_type'   ];	// 채번계좌 타입		A		1		O		V-일반형, F-고정형
			$cash_issue_yn		= $exec['r_cash_issue_yn'  ];	// 현금영수증 발급유무		N		1 		O
			$cash_res_cd		= $exec['r_cash_res_cd'    ];	// 현금영수증 결과코드		AN		4 		　
			$cash_tran_date		= $exec['r_cash_tran_date' ];	// 현금영수증 발행일시		AN		14 		O
			$cash_auth_no		= $exec['r_cash_auth_no'   ];	// 현금영수증 승인번호		AN		20 		O

			/* --------------------------------------------------------------------------- */
			/* ::: 노티수신 - 에스크로 상태변경                                           */
			/* -------------------------------------------------------------------------- */
			$escrow_yn			= $exec["r_escrow_yn"      ];  // 에스크로유무
			$stat_cd			= $exec["r_stat_cd "       ];  // 변경에스크로상태코드
			$stat_msg			= $exec["r_stat_msg"       ];  // 변경에스크로상태메세지

			$this->CI->load->model('ordermodel');
			$this->CI->load->model('goodsmodel');

			$this->send_for_provider = array();

			## 주문서 정보 가져오기
			$orders	= $this->CI->ordermodel->get_order($order_no);
			## 가격 검증
			if	($orders['pg_currency'] == 'KRW')
				$orders['settleprice']	= floor($orders['settleprice']);
			if($orders['settleprice'] != $amount){
				$log_title	= '결제실패';
				$log			= "KICC 결제 실패". chr(10)."[입금통보, 금액불일치]";
				$this->CI->ordermodel->set_log($orders['order_seq'], 'pay', '시스템', $log_title, $log);
				throw new Exception('가격이 일치하지 않음.');
			}

			if ( $noti_type == "10" ){ // 승인. 노티필수 승인:10 변경:20 입금:30 에스크로입금:40
			}elseif ( $noti_type == "20" ){ // 변경. 노티필수 승인:10 변경:20 입금:30 에스크로입금:40
			}elseif ( $noti_type == "30" || $noti_type == "40"){ // 입금. 노티필수 승인:10 변경:20 입금:30 에스크로입금:40

				## 로그 변수 세팅
			   $pg_log['pg']			= $this->CI->config_system['pgCompany'];
			   $pg_log['tno']			= $cno;
			   $pg_log['order_seq'] 	= $order_no;
			   $pg_log['depositor']	= $deposit_nm;
			   $pg_log['amount']		= $amount;
			   $pg_log['bank_code']	= $bank_cd;
			   $pg_log['account']		= $account_no;
			   $pg_log['res_cd']		= $res_cd;
			   $pg_log['res_msg']		= $res_msg;

			   ## 로그저장
			   $pg_log['regist_date'] = date('Y-m-d H:i:s');
			   $this->CI->db->insert('fm_order_pg_log', $pg_log);

				if( $cash_auth_no ){// 현금영수증 승인번호
					$data = array(
						'typereceipt'=>2,
						'cash_receipts_no' => $cash_auth_no
					);
				}

				$orders = $this->CI->ordermodel->get_order($order_no);

				if($orders['step'] < '25' || $orders['step'] > '85'){ // 결제이후 프로세스 진행 이후에는 결제확인 처리 하지 않음
					$this->CI->ordermodel->set_step($order_no,25,$data);
				}

				$add_log = "";
				if($orders['orign_order_seq']) $add_log = "[재주문]";
				if($orders['admin_order']) $add_log = "[관리자주문]";
				if($orders['person_seq']) $add_log = "[개인결제]";
				$log_title =  $add_log."결제확인"."(".$orders['mpayment'].")";
				$this->CI->ordermodel->set_log($order_no,'pay',$orders['order_user_name'],$log_title,$log);

				// 가상계좌 결제의 경우 현금영수증
				if( $orders['step'] < '25' || $orders['step'] > '85' ){
					typereceipt_setting($orders['order_seq']);
				}

				// 출고량 업데이트를 위한 변수선언
				$r_reservation_goods_seq = array();
				$providerList = array();

				$result_option = $this->CI->ordermodel->get_item_option($order_no);
				$result_suboption = $this->CI->ordermodel->get_item_suboption($order_no);

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
					$this->CI->goodsmodel->modify_reservation_real($goods_seq);
				}

				// 결제확인 mail 및 sms 발송
				if ($orders['step'] < '25' || $orders['step'] > '85') {
					$this->CI->load->library('orderlibrary');
					$this->CI->orderlibrary->send_step25_mail_sms($orders);
				}

				// [판매지수 EP] 쿠키로 ep 등록 처리된 주문건인지 확인 후 EP 수집 :: 2018-09-18 pjw
				if(!$this->CI->statsmodel) $this->CI->load->model('statsmodel');
				$this->CI->statsmodel->set_order_sale_ep($orders['order_seq']);
			}

			$bDBProc = "true";
		}catch(Exception $e){
			$this->createKiccLog($e);
			$bDBProc = "false";
		}
		return $bDBProc;
	}
	protected function createKiccLog($e, $type='error'){
		//======================================================
		//  LOG 생성 시작
		//======================================================
        $logDir = $this->g_log_dir."/custom_log";
        $logFile = "kicc_".$type.date("Ymd").".log";
        if(!file_exists($logDir)){ mkdir($logDir); }
        $logLocation = $logDir."/".$logFile;
        $fp = fopen($logLocation,"a+");
		fwrite($fp,"[".date('Y-m-d H:i:s')."] - ");
		ob_start();
		print_r($e);
		$ob_msg = ob_get_contents();
		// ob_clean();	// 출력버퍼 내용 지움
		ob_end_clean();	// 출력버퍼 지우고 종료
		if(fwrite($fp, " ".$ob_msg."\n") === FALSE)
		{
		fclose($fp);
		return 0;
		}
		fclose($fp);
		//======================================================
		//  LOG 생성 종료
		//======================================================
	}

	// kicc 메뉴얼 특수문자사용제한
	protected function removeCharacterKiccParam($tmpresult, $arr_replace_ignore=array()) {
		$result = array();
		foreach($tmpresult as $k=>$v){
			if(!in_array($k, $arr_replace_ignore)){
				// 앰퍼샌트	콤마	세미콜론	뉴라인	역슬래시	파이프라인	작은따옴표	큰따옴표
				$patterns = "/[&,;\n\\\\|'\"]/";
				$replacements = '';
				$v = preg_replace($patterns, $replacements, $v);
			}

			if(!empty($v) || $v=='0'){	// 배송구분의 경우 값이 0이므로 패스
				$result[$k] = $v;
			}
		}

		return $result;
	}

	public function validationKiccReceipt($param){
		$result = "false";
		$order_no	= $param['order_seq'];

		try{
			## 주문서 정보 가져오기
			$orders	= $this->CI->ordermodel->get_order($order_no);

			$payment_code = $this->arr_payment_code[$orders['payment']];
			if(!empty($payment_code)){
				$result = $this->receipt_url.'?controlNo='.$orders['pg_transaction_number'].'&payment='.$payment_code;
			}else{
				$this->CI->load->model('salesmodel');
				$sc = array('select'=>'cash_no','whereis'=>'AND order_seq ='.$order_no);
				$sales	= $this->CI->salesmodel->get_data($sc);
				$result = $this->receipt_url.'?controlNo='.$sales['cash_no'];
			}
		}catch(Exception $e){
			$this->createKiccLog($e);
			$result = "false";
		}
		return $result;
	}


	// kicc 모듈 호출용 javascript 함수 본문
	public function initKiccCallPgDelay($url, $validation){
		// 스크립트 호출 가능 체크 false : 불가능, true : 가능
		$pre_call_checked = 'false;';
		$inputTag = 'inputTag';
		$submitScript = 'console.log(\'submit\')';
		// PC와 Mobile에 따라 호출 하는 모듈 양식이 다름
		if(!$this->CI->_is_mobile_agent) {
			$pre_call_checked = '!(typeof(parent.easypay_webpay) === \'undefined\');';
			$submitScript = '
				var frm_pay = parent.document.kicc_frm_pay;
				parent.easypay_webpay(frm_pay,actionUrl,"hiddenifr","0","0","iframe",30);
			';
		}else{
			$inputTag = '$(inputTag).attr("action", actionUrl).attr("target", "tar_opener")';
			$pre_call_checked = '!(parent.$("iframe[name=\'tar_opener\']").length == 0);';
			$submitScript = '
				parent.$(\'body\').find("form[name=\'kicc_frm_pay\']").submit();
			';
		}

		// 스크립트 전문
		$callPgDelay = '';
		$callPgDelay .= '
		var kiccReloadDelayTime = 500;
		var called = false;
		var pre_call_checked = false;
		var actionUrl = "'.$url.'";

		function callPgDelay(inputTag){
			if(!called){
				pre_call_checked = '.$pre_call_checked.'
				if(!pre_call_checked){
					parent.$.getScript("'.$this->javascript_url.'");
					var delayTime = kiccReloadDelayTime;
					console.log("필수 스크립트가 로드되지 않았습니다. "+(delayTime/1000)+"초 후 다시 시도합니다.");
					setTimeout(function(){
						console.log("리로드"+delayTime);
						callPgDelay(inputTag);
					}, delayTime);
					kiccReloadDelayTime += 500;	// 0.5초씩 증가
				}else{

					parent.$(\'body\').find("form[name=\'kicc_frm_pay\']").remove();
					parent.$(\'body\').append('.$inputTag.');
					parent.$(\'body\').append("<script>function kicc_cust_popup_close(){reverse_pay_layer();}<\/script>");

					called = true;
					'.$submitScript.'
				}
			}
		}
		';

		// 유효성 검사 실패 시
		if(!$validation){
			$callPgDelay = '
				function callPgDelay(inputTag){
					alert("[9999] 에크스로 결제 시 복합결제를 진행할 수 없습니다.");
				}
			';
		}

		return $callPgDelay;
	}
}