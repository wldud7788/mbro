<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

use App\Libraries\SocialManager;
use App\Libraries\Social\Apple\AppleClient;
use App\Libraries\Social\Naver\NaverClient;
use App\Libraries\Social\Facebook\FacebookClient;
use App\Libraries\Social\Twitter\TwitterClient;
use App\Libraries\Social\Kakao\KakaoClient;

class sns extends front_base {

	public function __construct() {
		parent::__construct();
		$this->load->library('validation');
		$this->load->library('snssocial');
		$this->template->assign('designMode',false);
		$this->protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https://' : 'http://';
	}


	/* facebook 연동 */
	public function config_facebook()
	{
		$arrSystem = ($this->config_system)?$this->config_system:config_load('system');
		$this->fbuser = $this->snssocial->facebookuserid();
		if ( !$this->fbuser ) {
			$this->facebook = new Facebook(array(
			  'appId'  => $this->__APP_ID__,
			  'secret' => $this->__APP_SECRET__,
			  "cookie" => true
			));
			// Get User ID
			$this->fbuser = $this->facebook->getUser();
			if($this->fbuser){
				if( !$this->session->userdata('fbuser') ) {
					$this->session->set_userdata('fbuser', $this->fbuser);
				}
			}else{
				$this->snssocial->facebooklogin();
			}
		}else{
			if( !$this->session->userdata('fbuser') ) {
				$this->session->set_userdata('fbuser', $this->fbuser);
			}
		}

		//@2015-04-28
		$fbuser = $this->fbuser;//$this->snssocial->fbuser;
		if(!$fbuser) {
			$login_info = array(
			'scope'			=> 'email, manage_pages, publish_actions',
			'display'		=> 'popup',
			'redirect_uri'	=> $this->protocol.$arrSystem['subDomain'].'/sns/config_facebook');
			$loginUrl = $this->snssocial->facebook->getLoginUrl($login_info);
			//$_SERVER['HTTP_HOST']->$arrSystem['subDomain']

			$this->template->assign('loginUrl',$loginUrl);
		}else{
			$fbpermissions = $this->snssocial->facebookpermissions($this->snssocial->facebook);
			if($fbpermissions){
				if( !(array_key_exists('manage_pages', $fbpermissions['data'][0]) || in_array('manage_pages', $fbpermissions) ) ) {
					$login_info = array(
					'scope'			=> 'manage_pages',
					'display'		=> 'popup',
					'redirect_uri'	=> $this->protocol.$arrSystem['subDomain'].'/sns/config_facebook?popup=1');
					$permissionloginUrl = $this->snssocial->facebook->getLoginUrl($login_info);
					$this->template->assign('permissionloginUrl',$permissionloginUrl);
					//$_SERVER['HTTP_HOST']->$arrSystem['subDomain']
				}
			}
		}

		$this->template->assign('fbuser',$fbuser);
		if($this->arrSns['key_f'] && $fbuser){
			$snsparams['page_id'] = $this->arrSns['page_id_f'];
			$tabs_page = $this->snssocial->facebook_page_read($snsparams, $appuseck);
			$this->template->assign('appuseck',$appuseck);
			$this->template->assign('pageloop',$tabs_page);
		}
		$this->template->assign($this->arrSns); //sns used
		$this->template->assign('config',true);
		$this->template->assign($arrSystem);
		$this->print_layout($this->template_path());

	}

	public function subdomainfacebookck()
	{
		$this->tempate_modules();
		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$arrSystem = ($this->config_system)?$this->config_system:config_load('system');
		$this->snssocial->facebooklogin();
	}

	public function facebookuseid(){
		//$this->session->unset_userdata('fbuser');
		$fbuser = ($_POST['fbuserid'])?$_POST['fbuserid']:$_GET['fbuserid'];
		if(!$this->session->userdata('fbuser')) {//페이스북회원인경우
			$this->session->set_userdata('fbuser', $fbuser);
		}

		//$this->session->unset_userdata('fbuserid');
		echo $_GET["jsoncallback"];
		exit;
	}

	function _writeLog($msg)
	{
		/**
			$PageCall_time = date("H:i:s");
			$valuear['PageCall time'][] = $PageCall_time;
			$req = '';
			foreach ($_GET as $key => $value)
			{
				if (get_magic_quotes_gpc())
				{
					$_GET[$key] = stripslashes($value);
					$value = stripslashes($value);
				}
				$value = urlencode($value);
				$req .= "&$key=$value";
				$valuear[$key][] = $value;
			}
			foreach ($_POST as $key => $value)
			{
				if (get_magic_quotes_gpc())
				{
					$_POST[$key] = stripslashes($value);
					$value = stripslashes($value);
				}
				$value = urlencode($value);
				$req .= "&$key=$value";
				$valuear[$key][] = $value;
			}
			foreach ($_SESSION as $key => $value)
			{
				if (get_magic_quotes_gpc())
				{
					$_SESSION[$key] = stripslashes($value);
					$value = stripslashes($value);
				}
				$value = urlencode($value);
				$req .= "&$key=$value";
				$valuear[$key][] = $value;
			}
			$this->_writeLog($valuear);
		***/

	    $file = "input_".date("Ymd").".log";
		$path = "data/tmp/";//\data\tmp
	    if(!($fp = fopen($path.$file, "a+"))) return 0;

	    ob_start();
	    print_r($msg);
	    $ob_msg = ob_get_contents();
	    ob_clean();

	    if(fwrite($fp, " ".$ob_msg."\n") === FALSE)
	    {
	        fclose($fp);
	        return 0;
	    }
	    fclose($fp);
	    return 1;
	}

	// 네이버 톡톡 API 간편 연결
	// 2016.08.18 pjw
	public function ntalk(){
		if(!$this->config_system) $this->config_system = config_load('system');
		if(!$this->config_basic) $this->config_basic = config_load('basic');
		$needlist	= array ('shopName', 'businessLicense', 'companyName', 'ceo', 'businessConditions', 'companyAddress', 'businessLine');
		foreach($needlist as $val){
			if(!$this->config_basic[$val]){
				echo "<script type='text/javascript'>alert('사업자 정보를 입력해 주세요.');opener.location.href='/admin/setting/multi';self.close();</script>";
				exit;
			}
		}

		//$shopdomain	= $this->config_system['subDomain'];
		//현재 접속한 도메인으로 통신하도록 수정 2019-05-08
		$shopdomain	= $_SERVER['HTTP_HOST'];
		$shopno		= $this->config_system['shopSno'];
		$protocol	= check_ssl_protocol() ? 'https' : 'http';
		$chnlId		= $shopdomain.'_'.$shopno.'_'.$protocol;
		$result = $this->ntalk_api('/gabia/talk-channel/getAccessToken', 'GET', '&chnlCd=gabia');

		$jsonObj = json_decode($result);
		if($jsonObj->success){
			//$tmp_domain		= 'https://dev2-partner.talk.naver.com';
			$tmp_domain		= 'https://partner.talk.naver.com';
			$tmp_returnUrl	= '/api/channel/service/connect?token='.$jsonObj->data->accessToken.'&returnUrl=https://naverapi.firstmall.kr/ntalk_callback.php?c='.$chnlId;
			header('Location: '.$tmp_domain.$tmp_returnUrl);
		}
		exit;
	}

	// 네이버 톡톡 API 채널 연결 해제
	// 2016.08.18 pjw
	public function ntalk_disconnect(){
		$result = $this->ntalk_api('/gabia/talk-channel/channel', 'DELETE');
		$this->ntalk_removeChannel();
		exit;
	}

	// 네이버 톡톡 API 채널 비활성화
	// 2016.08.18 pjw
	public function ntalk_disable(){
		$result = $this->ntalk_api('/gabia/talk-channel/channel/off', 'PUT');
		$this->ntalk_toggle_able();
		exit;
	}

	// 네이버 톡톡 API 채널 연결 해제
	// 2016.08.18 pjw
	public function ntalk_enable(){
		$result = $this->ntalk_api('/gabia/talk-channel/channel/on', 'PUT');
		$this->ntalk_toggle_able();
		exit;
	}

	// 네이버 톡톡 API 공용 함수
	// 2016.08.18 pjw
	function ntalk_api($api, $method, $addParam=''){
		$this->load->helper('readurl');
		//$domain		= 'https://dev.apis.naver.com';
		$domain	= 'https://apis.naver.com';

		if(!$this->config_system) $this->config_system = config_load('system');
		//$shopdomain	= $this->config_system['domain'] ? $this->config_system['domain'] : $this->config_system['subDomain'];
		//현재 접속한 도메인으로 통신하도록 수정 2019-05-08
		$shopdomain	= $_SERVER['HTTP_HOST'];
		$shopno		= $this->config_system['shopSno'];
		$protocol	= check_ssl_protocol() ? 'https' : 'http';
		$chnlId		= $shopdomain.'_'.$shopno.'_'.$protocol;
		$chnparam	= '?chnlId='.$chnlId.$addParam;

		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt ($ch, CURLOPT_SSLVERSION,1);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array(
			'X-Naver-Client-Id: aI4RC7Rj1YQ3PmF2ZCkr',
			'X-Naver-Client-Secret: QM3pFRIIDz'
		));
		curl_setopt ($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_URL, $domain.$api.$chnparam);
		$result = curl_exec($ch);

		$decode = json_decode($result);
		if($decode->success == true){
			return $result;
		}else{

			// 존재하지 않는 채널인 경우 연결을 해제
			if($decode->error->code == 402){
				config_save('snssocial', array("ntalk_use" => "N"));
				config_save('snssocial', array("ntalk_connect" => "N"));
			}

			if($decode->error->code == 403){
				config_save('snssocial', array("ntalk_use" => "N"));
			}

			$result = array(
				"success"	=> false,
				"code"		=> $decode->error->code,
				"message"	=> $decode->error->message
			);
			echo json_encode($result);
			exit;
		}
	}

	public function ntalk_callback(){
		echo "<script type='text/javascript'>alert('연동이 완료 되었습니다.');opener.location.reload();self.close();</script>";
	}

	// 네이버 톡톡 연동 API
	// 2016.08.18 서비스 상세정보 조회 pjw
	public function ntalk_getChannelInfo(){
		try{
			if(!$this->config_basic) $this->config_basic = config_load('basic');
			$isRoadName = $this->config_basic['companyAddress_type'] == 'oldzibun' ? 'N' : 'Y';

			// 사업자 번호 형식체크
			$frm_bno = array(3, 2, 5);
			$tmp_bno = explode('-', $this->config_basic['businessLicense']);
			foreach($tmp_bno as $key=>$val){
				if(strlen($val) != $frm_bno[$key]){
					$result = array(
						"code"	  => 501,
						"success" => false,
						"message" => "사업자 번호 양식이 맞지 않습니다. xxx-xx-xxxxx 형식으로 변경하십시오."
					);
					echo json_encode($result);
					exit;
				}
			}

			$result = array(
				"code"	  => 200,
				"success" => true,
				"profile" => array(
								"profileName"			=> $this->config_basic['shopName'],
								"contactInformation"	=> $this->config_basic['basic'],
								"businessYn"			=> true,
								"locationInformation"	=> array(
									"address"				=> $this->config_basic['companyAddress'],
									"addressDetail"			=> $this->config_basic['companyAddressDetail'],
									"isRoadName"			=> $isRoadName
								)
							),
				"businessInfo" => array(
								"businessType"			=> 'BUSINESS',
								"businessCountryCode"	=> 'KOR',
								"businessNo"			=> $this->config_basic['businessLicense'] ,
								"businessSiteName"		=> $this->config_basic['companyName'],
								"representativeName"	=> $this->config_basic['ceo'],
								"businessAddress"		=> $this->config_basic['companyAddress'],
								"businessConditionName"	=> $this->config_basic['businessConditions'],
								"categoryItemName"		=> $this->config_basic['businessLine']
							)
			);
		}catch(Exception $e){
			$result = array(
				"code"	  => 500,
				"success" => false,
				"message" => "채널 조회 실패"
			);
		}

		echo json_encode($result);
		exit;
	}

	// 2016.08.18 채널 등록 완료 pjw
	public function ntalk_addChannel(){
		try{
			if(!$this->config_basic) $this->config_basic = config_load('basic');

			config_save('snssocial', array(
				"ntalk_connect"		=> "Y",
				"ntalk_use"			=> "Y",
				"ntalk_connect_id"	=> $_POST['accountId']
			));

			$result = array(
				"code"	  => 200,
				"success" => true
			);
		}catch(Exception $e){
			$result = array(
				"code"	  => 500,
				"success" => false,
				"message" => "채널 등록 실패"
			);
		}

		echo json_encode($result);
		exit;
	}

	// 2016.08.18 채널 사용/미사용 처리 pjw
	public function ntalk_toggle_able(){
		try{
			if(!$this->config_basic) $this->config_basic = config_load('basic');

			config_save('snssocial', array(
				"ntalk_use"	 => $_POST['use_talk']
			));

			$result = array(
				"code"	  => 200,
				"success" => true
			);
		}catch(Exception $e){
			$result = array(
				"code"	  => 500,
				"success" => false,
				"message" => "채널 상태 변경 실패"
			);
		}

		echo json_encode($result);
		exit;
	}

	// 2016.08.18 채널 삭제 pjw
	public function ntalk_removeChannel(){
		try{
			if(!$this->config_basic) $this->config_basic = config_load('basic');

			config_save('snssocial', array(
				"ntalk_connect"				=> "N",
				"ntalk_use"					=> "",
				"ntalk_connect_id"			=> "",
				"ntalk_use_web_product"		=> "",
				"ntalk_use_web_quick"		=> "",
				"ntalk_use_mobile_product"	=> "",
				"ntalk_use_mobile_main"		=> "",
				"ntalk_use_sniffet"			=> ""
			));

			$result = array(
				"code"	  => 200,
				"success" => true
			);
		}catch(Exception $e){
			$result = array(
				"code"	  => 500,
				"success" => false,
				"message" => "채널 삭제 실패"
			);
		}

		echo json_encode($result);
		exit;
	}

	// 레거시 회원가입 타입 변경
	private function replaceMemberType($mtype) {
		// 카카오싱크 스킨 미패치 시 강제 치환
		$mtype = str_replace('sync', '', $mtype);
		return $mtype === 'biz' ? 'business' : $mtype;
	}

	// 각 SNS 로그인 파라미터 공통 처리
	private function setSocialParameters() {
		// skin-snslogin.js 없는 스킨은 SNS 연동 후 레거시 콜백 함수를 수행해야하므로 이를 위한 분기처리용 세션을 생성
		$isLegacy = 'N';

		// 회원타입 (member, business)
		$mtype = $this->replaceMemberType($this->input->post('mtype'));

		// 회원가입 여부 (login, join)
		$mform = $this->input->post('mform');

		// 회원 통합 여부 (통합인 경우 mbconnect_direct 값으로 넘어온다)
		$facebooktype = $this->input->post('facebooktype');

		// 만 14세 미만 가입 동의 여부
		$kidAgree = $this->input->post('kid_agree');
		$isSkinPached = $this->input->post('skin_patch_14years_old');

		// SNS 로그인 관련 파라미터
		$socialParameters = [
			'isLegacy' => $isLegacy,
			'mtype' => $mtype,
			'mform' => $mform,
			'facebooktype' => $facebooktype,
		];

		// 로그인에 필요한 데이터 먼저 세션 처리 한다
		$this->session->set_userdata($socialParameters);

		// 만 14세 동의 관련 파라미터 추가
		$socialParameters['kid_agree'] = $kidAgree;
		$socialParameters['skin_patch_14years_old'] = $isSkinPached;

		// 만 14세 동의 체크는 따로 라이브러리에서 추가 세션 처리함
		$this->load->library('memberlibrary');
		$this->memberlibrary->kidAgreeCheck($socialParameters);

		return $socialParameters;
	}

	// SNS 로그인 게이트 오류 결과 출력 후 프로세스 종료
	private function errorResult($msg = 'Error') {
		$result = [
			'result' => false,
			'msg' => $msg,
		];

		echo json_encode($result);
		exit;
	}

	// SNS 로그인 게이트 정상 결과 출력 후 프로세스 종료
	private function successResult($data = [], $msg = '') {
		$result = array_merge($data, [
			'result' => true,
			'msg' => $msg,
		]);

		echo json_encode($result);
		exit;
	}

	// 네이버 인증 요청 전처리
	public function naver_gate() {
		try {
			// 공통 파라미터 세션 처리
			$this->setSocialParameters();

			// SNS 객체 생성
			$socialManager = new SocialManager(NaverClient::class);

			// Authorize URL 생성하여 리턴
			$this->successResult(['authorizeUrl' => $socialManager->getAuthorizeUrl()]);
		} catch (Exception $e) {
			$this->errorResult($e->getMessage());
		}
	}

	// 카카오 인증 요청 전처리
	public function kakao_gate() {
		try {
			// 공통 파라미터 세션 처리
			$this->setSocialParameters();

			// SNS 객체 생성
			$socialManager = new SocialManager(KakaoClient::class);

			// 결과 배열
			$result = [];

			// 연동방식
			$loginType = $socialManager->getConfig('type_k');
			if (empty($loginType)) {
				$loginType = 'js';
			}

			// REST API 연동일 때 인증 요청 URL을 생성
			if ($loginType === 'rest') {
				$result['authorizeUrl'] = $socialManager->getAuthorizeUrl();
			}

			// 결과에 연동방식을 추가
			$result['type'] = $loginType;

			// 결과값 만들어서 리턴
			$this->successResult($result);
		} catch (Exception $e) {
			$this->errorResult($e->getMessage());
		}
	}

	// 카카오톡 인앱브라우저 인증 요청 전처리
	public function kakao_browser_gate() {
		try {
			// 공통 파라미터 세션 처리
			$this->setSocialParameters();

			// SNS 객체 생성
			$socialManager = new SocialManager(KakaoClient::class);

			// 결과 배열
			$result = [];

			// 연동방식
			$loginType = $socialManager->getConfig('type_k');

			// REST API 연동일 때 인증 요청 URL을 생성
			if ($loginType === 'rest') {
				$result['authorizeUrl'] = $socialManager->getAutoAuthorizeUrl();
			}

			// 결과에 연동방식을 추가
			$result['type'] = $loginType;

			// 결과값 만들어서 리턴
			$this->successResult($result);
		} catch (Exception $e) {
			$this->errorResult($e->getMessage());
		}
	}

	// 페이스북 인증 요청 전처리
	public function facebook_gate() {
		try {
			// 공통 파라미터 세션 처리
			$this->setSocialParameters();

			// SNS 객체 생성
			$socialManager = new SocialManager(FacebookClient::class);

			// 결과 배열
			$result = [];

			// 연동방식
			$loginType = $socialManager->getConfig('type_f');
			if (empty($loginType)) {
				$loginType = 'js';
			}

			// REST API 연동일 때 인증 요청 URL을 생성
			if ($loginType === 'rest') {
				$result['authorizeUrl'] = $socialManager->getAuthorizeUrl();
			}

			// 결과에 연동방식을 추가
			$result['type'] = $loginType;

			// 결과값 만들어서 리턴
			$this->successResult($result);
		} catch (Exception $e) {
			$this->errorResult($e->getMessage());
		}
	}

	// 트위터 인증 요청 전처리
	public function twitter_gate() {
		try {
			// 공통 파라미터 세션 처리
			$this->setSocialParameters();

			// SNS 객체 생성
			$socialManager = new SocialManager(TwitterClient::class);

			// Authorize URL 생성하여 리턴
			$this->successResult(['authorizeUrl' => $socialManager->getAuthorizeUrl()]);
		} catch (Exception $e) {
			$this->errorResult($e->getMessage());
		}
	}

	// 애플 인증 요청 전처리 컨트롤러
	public function apple_gate(){
		try {
			// 공통 파라미터 세션 처리
			$this->setSocialParameters();

			// SNS 객체 생성
			$socialManager = new SocialManager(AppleClient::class);

			// Authorize URL 생성하여 리턴
			$this->successResult(['authorizeUrl' => $socialManager->getAuthorizeUrl()]);
		} catch (Exception $e) {
			$this->errorResult($e->getMessage());
		}
	}
}

/* End of file sns_process.php */
/* Location: ./app/controllers/sns_process.php */