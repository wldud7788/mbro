<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

Class o2oconfiglibrary
{
	public $auth_text = "O2O";
	public $o2o_sitetype = "POS";
	
	// data code 
	public $code = array(
		'use_yn' => array(
			'y' => '사용',
			'n' => '미사용'
		),
		'contracts_status' => array(
			'00' => '신청전',
			'10' => '신청완료',
			'20' => '심사중',
			'30' => '설치대기중',
			'40' => '설치완료',
			'80' => '운영중',
			'90' => '서비스중지',
			'91' => '심사거절',
		),
	);
	
	public $checkO2OService = false;
	
	public $barcode_type = "code128";
	public $barcode_size = "80";
	// int(11)로 구성된 seq를 8진수로 변환한 후 salt에서 빼고 barcode 체계로 만든다
	// 이때 salt는 int(11)의 최대값의 8진수보다 커야함.
	public $barcode_salt			= 2937123068748;	// 쿠폰 바코드용
	public $barcode_salt_member		= 3937123068748;	// 회원 바코드용
	
	public $o2o_system_info = null;	
	public $isCheckedActvieO2OEnv = false;
		
	protected $CI = null;		// CI 인스턴스

	public function __construct() {
		if(empty($this->CI)){
			$this->CI = & get_instance();
		}
		// 서비스 활성화 여부 
		$this->checkO2OServiceActive();
		
		// 인터페이스 서버에서 O2O 관련 설정 로드
		$this->init_general_o2o_config();
		
		// 서비스 가능 체크 및 셋업
		if($this->checkActvieO2OEnv()){
			$this->setupO2OEnv();
		}
		
		if	(!$this->CI->scm_cfg)	$this->CI->scm_cfg	= config_load('scm');
	}

	
	// O2O 서비스 활성화 여부
	public function checkO2OServiceActive(){
		// TODO :: o2o system_config 설정
		// 인증후에서 o2o 업체 정보를 가져온다
		// 서비스 활성화 전에 인증후에서 정보를 가져와야 함
		
		// if($this->CI->config_system['o2o_use']=="Y"){
		//  	$this->checkO2OService = true;
		// }else{
		// 	$this->checkO2OService = false;
		// }
		
		// O2O 의 사용여부에 따른 설정값이 없어짐. 따라서 system_config에서 값을 가져오는 것이 아닌 강제 활성화 처리
		$this->checkO2OService = true;
		
		return $this->checkO2OService;
	}
	
	// O2O 서비스 환경 가능 여부
	public function checkActvieO2OEnv(){
		if(!$this->checkO2OService){
		    return $this->checkO2OService;
		}
		
		$this->CI->load->model('layout');
		$skin = $this->CI->layout->get_view_skin();

		$fileExistCnt = 0;

		$fileList = array(
			// 공통 영역
			ROOTPATH.'app/config/o2o/_pc_menu.ini',										// 관리자 o2o 전용 메뉴
			ROOTPATH.'app/helpers/o2o/readurl_helper.php',
			
			ROOTPATH.'app/models/o2o/apilogmodel.php',
			ROOTPATH.'app/models/o2o/o2oblockmodel.php',								// o2o 설정 관련 모델
			ROOTPATH.'app/models/o2o/o2oconfigmodel.php',								// o2o 설정 관련 모델
			ROOTPATH.'app/models/o2o/o2omembermodel.php',								// o2o 회원 관련 모델
			
			ROOTPATH.'app/libraries/o2o/o2obarcodelibrary.php',							// 바코드 관련 라이브러리
			ROOTPATH.'app/libraries/o2o/o2oconfiglibrary.php',							// 설정 관련 라이브러리
			ROOTPATH.'app/libraries/o2o/o2oinitlibrary.php',							// 초기화 & 기능 추가 관련 라이브러리
			ROOTPATH.'app/libraries/o2o/o2oorderlibrary.php',							// 주문 관련 라이브러리
			ROOTPATH.'app/libraries/o2o/o2orequiredlibrary.php',						// 필수변경 관련 라이브러리
			ROOTPATH.'app/libraries/o2o/o2oservicelibrary.php',							// 설정 관련 라이브러리

			// 관리자 - 스킨
			ROOTPATH.'admin/skin/default/o2o/_modules/barcode_download.html',			// 바코드 다운로드 
			ROOTPATH.'admin/skin/default/o2o/_modules/manager_auth.html',				// 
			ROOTPATH.'admin/skin/default/o2o/_modules/member_joinform.html',			// 회원 가입 설정 모듈
			ROOTPATH.'admin/skin/default/o2o/_modules/member_list_rute.html',			// 관리자 회원 목록 페이지 모듈
			ROOTPATH.'admin/skin/default/o2o/_modules/member_sale.html',				// 회원 등급 안내
			ROOTPATH.'admin/skin/default/o2o/_modules/member_search.html',				// 관리자 회원 목록 검색 페이지 모듈
			ROOTPATH.'admin/skin/default/o2o/_modules/shipping_address_pop.html',		// 매장 수령 주소 html 
			ROOTPATH.'admin/skin/default/o2o/_modules/statistic_sales_menu.html',		// 통계 메뉴
			ROOTPATH.'admin/skin/default/o2o/o2osetting/o2o_list.html',					// 관리자 설정 페이지 목록 스킨
			ROOTPATH.'admin/skin/default/o2o/o2osetting/o2o_regist.html',				// 관리자 설정 페이지 등록 스킨
			ROOTPATH.'admin/skin/default/o2o/statistic_sales/sales_o2o.html',			// 통계

			// 관리자 - 스킨 - tpl
			ROOTPATH.'app/libraries/tpl_plugin/function.o2oAdminMemberListRute.php',	// 관리자 회원 목록 모듈 호출 함수
			
			// 관리자 - 컨트롤러
			ROOTPATH.'app/controllers/admin/o2o/o2osetting.php',							// 관리자 o2o setting 컨트롤러
			ROOTPATH.'app/controllers/admin/o2o/o2osetting_process.php',					// 관리자 o2o setting 처리 컨트롤러
			
			// 스크립트
			ROOTPATH.'app/javascript/js/o2o/admin-o2o.js',									// 관리자 설정 js
			ROOTPATH.'app/javascript/js/o2o/admin-o2oCoupon.js',							// 관리자 쿠폰 js
			ROOTPATH.'app/javascript/js/o2o/o2o-authCellphone.js',
			ROOTPATH.'app/javascript/js/o2o/o2o-barcode.js',
			ROOTPATH.'app/javascript/js/o2o/o2o-register.js',

			// api
			ROOTPATH.'app/controllers/o2o/api.php',
			ROOTPATH.'app/controllers/o2o/base/api_base.php',

			// 사용자
			ROOTPATH.'app/controllers/o2o/o2o_auth_process.php',
			ROOTPATH.'app/controllers/o2o/o2o_barcode.php',
			ROOTPATH.'app/controllers/o2o/o2o_coupon.php',
			ROOTPATH.'app/controllers/o2o/o2o_register.php',
			ROOTPATH.'app/controllers/o2o/o2o_register_process.php',
			
			// 사용자 - 스킨 - tpl
			ROOTPATH.'app/libraries/tpl_plugin/function.o2oFrontMypageCouponBarcode.php',	// 사용자 스킨 바코드 레이어

			// 참조 영역 - 패키지 제거시 제외
			ROOTPATH.'app/libraries/calculatelibrary.php',						// 주문 계산식 라이브러리
			ROOTPATH.'app/libraries/exportlibrary.php',							// 출고 라이브러리
			ROOTPATH.'app/libraries/orderlibrary.php',							// 주문 라이브러리
			ROOTPATH.'app/libraries/refundlibrary.php',							// 환불 라이브러리
			ROOTPATH.'app/libraries/returnlibrary.php',							// 반품 라이브러리
			ROOTPATH.'app/libraries/memberlibrary.php',							// 회원 라이브러리
			ROOTPATH.'app/libraries/scmlibrary.php',							// 재고관리 라이브러리
			ROOTPATH.'app/models/membermodel.php',
		);
				
		// 모바일 스킨이 아닐때만 체크
		// 사용자 스킨
		if(!$this->CI->mobileMode && !$this->CI->fammerceMode && !empty($skin)){
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/order/_coupon_ordersheet.html';
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/o2o/_modules/auth_cellphone.html';
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/o2o/_modules/member_join_gate.html';
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/o2o/_modules/mypage_coupon_init.html';
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/o2o/_modules/mypage_coupon_list.html';
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/o2o/o2o_barcode/index.html';
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/o2o/o2o_coupon/index.html';
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/o2o/o2o_register/index.html';
		}elseif($this->CI->mobileMode && !empty($skin)){	// 모바일 스킨일 경우
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/order/_coupon_ordersheet.html';
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/o2o/_modules/layout_side.html';
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/o2o/_modules/mypage_coupon_init.html';
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/o2o/_modules/mypage_coupon_list.html';
		    $fileList[] = ROOTPATH.'data/skin/'.$skin.'/o2o/o2o_barcode/index.html';
		}
		
		foreach($fileList as $filename){
			if(file_exists(trim($filename))){
				$fileExistCnt++;
			}else{
				// debug("매장 리스트 누락 파일".$filename);
			}
		}
		if($this->o2o_system_info['o2o_relay_host'] 
			&& $this->o2o_system_info['o2o_relay_api_key']
			&& $this->o2o_system_info['o2o_pos_info']
			&& count($fileList) == $fileExistCnt){
			$this->isCheckedActvieO2OEnv = true;
		}else{
			// $this->checkO2OService = false;
		    $this->isCheckedActvieO2OEnv = false;
		}
		
		return $this->isCheckedActvieO2OEnv;
	}
	// O2O 환경 구성
	public function setupO2OEnv(){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		// 해당 메뉴가 없을 경우 추가로 작성해준다.
		// 메뉴 설정 파일에 O2O메뉴 추가
		$file_path_pc_menu = APPPATH."config/_pc_menu.ini";
		$file_path_o2o_pc_menu = APPPATH."config/o2o/_pc_menu.ini";
		
		$arr_menu = parse_ini_file($file_path_pc_menu, true, INI_SCANNER_RAW);
		$arr_menu_o2o = parse_ini_file($file_path_o2o_pc_menu, true, INI_SCANNER_RAW);
		
		// o2o 서비스가 입력되어있는지 확인
		$menu_string = "\r\n\r\n[O2O-autoSetup-".date("Y-m-d H:i:s")."]\r\n";
		$autoSetup = false;
	
		foreach($arr_menu_o2o as $key => $arr_sub_menu_o2o){
			foreach($arr_sub_menu_o2o as $subkey => $sub_menu_o2o){				
				if(empty($arr_menu[$key][$subkey])){
					$menu_string .= $key."[".$subkey."]\t\t= ".$sub_menu_o2o."\r\n";
					$autoSetup = true;
				}
			}
		}		
			
		if(file_exists($file_path_pc_menu) && $autoSetup){
			$fp = fopen($file_path_pc_menu,"a+");
			fwrite($fp,$menu_string);
			fclose($fp);
		}
		
		// SMS가 발송 가능상태일 때만 강제 활성화 처리
		/*$auth = config_load('master','sms_auth'); // 보안키
		$sms_api_key = $auth['sms_auth'];
		$send_phone = getSmsSendInfo(); // 발신번호인증
		// 보안키 및 발신번호 미인증시 처리
		if($sms_api_key && $send_phone){
			$sms_st = 'Y';
		}else{
			if(!$send_phone)	$sms_st = '2';
			if(!$sms_api_key)	$sms_st = '1';
		}
		
		if($sms_st == 'Y'){
			// 휴대폰번호 변경 시 인증 사용 기능 강제 활성화
			$initConfirmsendmsg = '{shopname} 인증번호는 {phonecertify} 입니다.';
			$initConfirmPhone = 'Y';
			$config_member = config_load('member');
			if(empty($config_member['confirmPhone']) || $config_member['confirmPhone'] != $initConfirmPhone) {
				config_save('member',array('confirmPhone'=>$initConfirmPhone));
			}
			if(empty($config_member['confirmsendmsg']) || !preg_match('/\{phonecertify\}/', $config_member['confirmsendmsg'])) {
				config_save('member',array('confirmsendmsg'=>$initConfirmsendmsg));	
			}
		}
		
		// 별도의 회원가입 폼을 통해 강제로 입력받도록 프로세스 변경, 따라서 온라인의 핸드폰 입력 여부와 관계 없어짐
		// 회원 가입 휴대폰번호 항목 강제 활성화
		$initConfigJoinform = array(
			'cellphone_use' => 'Y',
			'cellphone_required' => 'Y',
			'bcellphone_use' => 'Y',
			'bcellphone_required' => 'Y',
		);
		$config_joinform = config_load('joinform');
		foreach($initConfigJoinform as $key => $initValue){
			if(empty($config_joinform[$key]) || $config_joinform[$key] != $initValue){
				config_save('joinform',array($key=>$initValue));
			}
		}*/

		return $this->checkO2OService;
	}
	
	/**
	 * 인터페이스 서버에서 O2O 정보 수신
	 * @return type
	 */
	function init_general_o2o_config(){
		if($this->o2o_system_info) return $this->o2o_system_info;

		// 현재 config 선언 
		$this->o2o_system_info = config_load('o2o');
		
		// config에 저장된 데이터 확인
		$o2o_config_reload = false;
		$o2o_config = config_load('o2o', 'o2o_relay_host', true);
		$o2o_relay_host_date = $o2o_config['o2o_relay_host_date'];
		$o2o_relay_host_date = substr($o2o_relay_host_date, 0, 10);
		if($o2o_relay_host_date < date("Y-m-d")){
			$o2o_config_reload = true;
		}
		// o2o_relay_host_date 를 통해 하루에 한번 갱신
		
		if($o2o_config_reload) {
			// call read url
			$api_url	= 'https://interface.firstmall.kr/firstmall_plus/o2o/config.php';
			$o2o_relay_params = array();
			$binary			= true;
			$timeout		= 7;
			$headers		= array();
			$http_build		= true;
			$debug			= false;
			$method			= "POST";
			try {
				$res_array = null;

				$this->CI->load->helper('o2o/readurl');
				$res = o2o_readurl($api_url, $o2o_relay_params, $binary, $timeout, $headers, $http_build, $debug, $method);

				if($res){
					$res_array = json_decode($res, true);
				}
				if($res_array){
					config_save('o2o', $res_array);
					$this->o2o_system_info = $res_array;
				}
			} catch (Exception $exc) {
				debug($exc);
			}
		}
		return $this->o2o_system_info;
	}
	
	// O2O 사용여부는 사용으로 고정, 나머지 데이터는 인터페이스 서버에서 가져오므로
	// 해당 변수 불필요
	function set_o2o_config_system($params){
		/*
		if(!empty($params['o2o_use'])){
			config_save('system', array('o2o_use'=>$params['o2o_use']));
		}
		if(!empty($params['o2o_relay_host'])){
			config_save('system', array('o2o_relay_host'=>$params['o2o_relay_host']));
		}
		if(!empty($params['o2o_relay_api_key'])){
			config_save('system', array('o2o_relay_api_key'=>$params['o2o_relay_api_key']));
		}
		if(!empty($params['o2o_pos_info'])){
			config_save('system', array('o2o_pos_info'=>$params['o2o_pos_info']));
		}
		*/
		return true;
	}
}