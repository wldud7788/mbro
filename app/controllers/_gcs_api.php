<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*######################## 
18.02.07 gcs userapp : api 
########################*/
require_once(APPPATH ."controllers/base/common_base".EXT);
class _gcs_api extends common_base {

	public function __construct(){
		parent::__construct();

//		$this->load->model("membermodel");
		$this->domain_path = "http://".$this->config_basic['domain'];
		$this->cookie_exp_time = time()+(86400*365);

		
		/*######################## 17.06.27 gcs userapp : 모바일 기기 분기처리 s */
		$this->load->library('user_agent');
		if ($this->agent->is_mobile('iphone') || $this->agent->is_mobile('ipad')) {
			$this->m_device = "iphone";
		}else{
			$this->m_device = "others";
		}
		$this->template->assign("m_device",$this->m_device);

		$this->userInfo = $this->session->userdata('user');
		/*######################## 17.06.27 gcs userapp : 모바일 기기 분기처리 e */
		
		$this->load->model('appmembermodel');
	}

	## 자동로그인 s #############################################################################
	//로컬에 값있으면 값 저장
	function memberInfoSave()
	{
		if (!$this->userInfo['member_seq']) {
			$data = $this->appmembermodel->get_app_member_info($_POST['member_seq']);
			if (!$_POST['member_seq'] || !$data['member_seq']) { //로컬에도 값이 없거나 디비상에 없는 경우
				$this->autoLogOut();
			} else {
				if ($_POST['key'] != $data['api_key'] || $data['status'] != 'done') {
					$this->autoLogOut();
				} else {
					$params = $data;
					//## SESSION
					$this->load->helper('member');
					create_member_session($params);

					//## 성인인증세션 처리
					if ($params['adult_auth'] == 'Y') {
						$auth_intro_data = ['auth_intro_type' => 'auth', 'auth_intro_yn' => 'Y'];
						$this->session->sess_expiration = (60 * 5);
						$this->session->set_userdata(['auth_intro' => $auth_intro_data]);
					} else {
						$this->session->unset_userdata('auth_intro');
						$_SESSION['auth_intro'] = '';
					}

					$auto_login = $this->session->userdata('auto_login');

					$this->script_memberInfo($data[0], $auto_login, 'json');
				}
			}
		}
	}

	/*## 자동로그인 보안처리 추가 :: 2020-01-07 pjw ##*/
	function auto_login_security() {
		header("Content-Type:text/html;charset=utf-8");
		
		if(!$_POST){
			$_POST = $_GET;
		}		
		
		// 로그인에 필요한 정보
		// 암호화 되어 넘어온 정보를 복호화 후 기존 프로세스에 필요한 변수로 설정
		$AES_KEY		= '9fe57e5f992a3691';
		$member_seq		= str_replace(' ', '+', $_POST['mq']);
		$channel		= str_replace(' ', '+', $_POST['cl']);
		$key			= str_replace(' ', '+', $_POST['ky']);
		$auto_login		= str_replace(' ', '+', $_POST['al']);
		
		// 암호화 풀기
		$member_seq		= AESDecode($AES_KEY, $member_seq);
		$channel		= AESDecode($AES_KEY, $channel);		
		$auto_login		= AESDecode($AES_KEY, $auto_login);
		$key			= base64_decode($key);	// key 값은 기존 aes 암호화 블럭 수보다 커서 base64로 따로 처리

		// 변수 세팅
		$_POST['member_seq']	= $member_seq;
		$_POST['channel']		= $channel;
		$_POST['key']			= $key;
		$_POST['auto_login']	= $auto_login;

		$this->auto_login();
	}

	/*##자동로그인##*/
	function auto_login() {
		if(!$_POST){
			$_POST = $_GET;
		}

		// 로그아웃으로 초기화 :: 2020-01-06 pjw
		$this->logout();

		// 앱에서만 접근 가능하게 블락처리 :: 2020-01-06 pjw
		if(!$this->_is_mobile_agent){
			$msg = "앱에서만 지원하는 기능입니다.";
			echo "<script>alert('".$msg."');location.href='/main/index'; </script>";
			exit;
		}

		$_POST['member_seq'] = (int) $_POST['member_seq'];
		setcookie('auto_login',$_POST['auto_login'],$this->cookie_exp_time,'/',".".$this->config_basic['domain']);
		$this->session->set_userdata('auto_login',$_POST['auto_login']);

		if($_POST['status']=='request') { //로컬에 값있는지 체크
			$this->memberInfoSave();
		}else{
			if(($_POST['member_seq'] ==0 || empty($_POST['member_seq']) ) && $_POST['auto_login'] !='y') {//처음 가입시, 로그아웃했을 때
				$this->logout();
				setcookie('auto_login','n',$this->cookie_exp_time,'/',".".$this->config_basic['domain']);
				$this->session->set_userdata('auto_login','n');
				echo "<script>location.href='/main/index'; </script>";
				exit;
						
				//자동로그아웃 처리
	//			$this->autoLogOut();		
				
			}else{
				if(!$_POST['member_seq']){
					$return['result'] = "0";
					$return['msg'] = "회원정보 없습니다";
					
					//echo json_encode($return);
					echo "<script>location.href='/main/index'; </script>";
					exit;
				}
				
				if($_POST['channel']=='none'){
					$_POST['snslogn'] = "";
					$this->api_normal_login();
				}else {

                    $channel = $_POST['channel'];
                    if($channel == 'nv') {
                        $_POST['snslogn'] = "naver";
                    }else if($channel == 'fb') {
                        $_POST['snslogn'] = "facebook";

                    }else if($channel == 'tw') {
                        $_POST['snslogn'] = "twitter";

                    }else if($channel == 'kk') {
                        $_POST['snslogn'] = "kakaotalk";

                    }else if($channel == 'is') {
                        $_POST['snslogn'] = "instagram";                        
                    }
                    
                    $this->api_login($channel);
                    
                }
			
			}			
		}
		

    }
    protected function getChannel($channel) {
        $sns_name = "sns_n";
        $use_name = "use_n";

        switch($channel) {
            case "fb":
            $sns_name = "sns_f";
            $use_name = "use_f";
            break;

            case "nv":
            $sns_name = "sns_n";
            $use_name = "use_n";
            break;

            case "kk":
            $sns_name = "sns_k";
            $use_name = "use_k";
            break;

            case "is":
            $sns_name = "sns_i";
            $use_name = "use_i";
            break;

            case "tw":
            $sns_name = "sns_t";
            $use_name = "use_t";
            break;

        }
        return array("use_name" => $use_name,
                    "sns_name" => $sns_name);
    }

    public function shopsno() {        
        
        $result = 1;
        $msg = "";
        $shopsno = $this->config_system['shopSno'];
        
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
		// ios는 CFNetwork 값을 포함하여 분기처리 :: 2019-11-06 pjw
        if( $user_agent != "" && !(strpos($user_agent, "CFNetwork") > -1)) {
            $result = 0;
            $msg = "지원되지 않는 디바이스 입니다.";
            $shopsno = "";
		}
        
        $result = array('result' => $result,
            'msg' => $msg,
            'shopsno' => $shopsno
        );
        $result_json = json_encode($result);
        echo $result_json;
    }
    
    // sns 로그인 통합..
    public function api_login($channel) {
        
        $name_array = $this->getChannel($channel);
        $sns_name = $name_array['sns_name'];
        $use_name = $name_array['use_name'];
        
        $this->load->library('snssocial');
		//naver 쇼핑몰로그인하기 (새창)		
		$this->arrSns = ($this->arrSns)?$this->arrSns:config_load('snssocial');

		if($this->arrSns[$use_name]) {//naver 사용여부
			### QUERY
			$where_arr	= array('member_seq'=>$_POST['member_seq']);//
            $data		= get_data('fm_member', $where_arr);
            
            //debug_var($data);
			//정보가 없을 경우 회원가입 안내.
			if(!$data[0][$sns_name]) {
				$result = '0';
				$msg	= "일치하는 회원정보가 없습니다.";
			//가입된경우 로그인하기
			}else{

                if($data[0]['status'] == 'hold'){
                    $result = 0;
                    //님은 아직 가입승인되지 않았습니다.
                    $msg	= $data[0]['user_name']."님은 아직 가입승인되지 않았습니다.";
                }else{
                    //$snslogin = $this->sns_login($params,'sns_k');
                    //$this->session->unset_userdata('mtype');
                    $params[$sns_name] = $data[0][$sns_name];
                    $snslogin = $this->api_sns_login($_POST['member_seq'], $_POST['key']);
                    if($snslogin) {
                        $result		= 1;
                        $msg		= "succ";
                        
                        if($_COOKIE['auto_login']=='y' || $this->session->userdata('auto_login') =='y') { //동일페이지에서 쿠키가 바로 구워지지 않은 경우 고려해서 세션값도 조건으로 처리
							$auto_login = 'y';
						}else{
							$auto_login = 'n';
						}
						
						$this->script_memberInfo($snslogin, $auto_login);
						

                        echo "<script>top.location.href='/main/index'; </script>";                        
						
						exit;

                    }else{//로그인실패시
                        $result = '0';
						$msg	= "탈퇴회원입니다. 관리자에게 문의해 주세요.";
                    }
                }				
			}
				
			
		}else{
			$result = '0';
			$msg	= "[관리자 문의] 네이버 아이디로 로그인 사용여부를 확인해 주세요.";
		}


		if($msg) {
//			echo "<script>alert('".$msg."');</script>";
		}
		echo "<script>top.location.href='/main/index'; </script>";


		//$return = array('result'=>$result,'msg'=>$msg );
		//echo json_encode($return);
		exit;
    }




	/**
	* @sns 으로 로그인시
	* @
	*/
	function api_sns_login($memberseq, $api_key){

		$data = $this->appmembermodel->get_app_member_info($memberseq,['status'=>['done','dormancy']]);
		$mbparams	= $data;

		$db_api_key = $data['api_key'];
		$app_api_key = isset($api_key) ? $api_key : "";
		if( is_null($db_api_key) || $db_api_key == "" ) {
		    # api_key 생성 및 db update
		    $db_api_key = $this->appmembermodel->create_api_key($data['userid'], $data['member_seq'], true);
		}else {
		    if( $app_api_key != $data['api_key'] && $app_api_key != "") {
		        //일치하는 회원정보가 없습니다.
		        $return['result'] = '0';
		        $return['msg'] = getAlert('mb203');
		        
		        $wronglogin_cnt = ($_COOKIE['wronglogin']) ? $_COOKIE['wronglogin'] : 0;
		        setcookie('wronglogin',$wronglogin_cnt+1,time()+(60*5));	//5분동안 저장
		        
		        //			echo json_encode($return);
		        echo "<script>location.href='/main/index'; </script>";
		        exit;
		    }
		}
		
		if($mbparams) {
			### 휴면계정 체크
			if($mbparams['dormancy_seq']){
			
				$return['result'] = '0';
				$return['msg'] = '휴면계정입니다. 휴면상태를 해제시키시려면 웹페이지 '.$this->domain_path.' 에 접속하셔서 로그인해주시기 바랍니다.';

				//자동로그아웃 처리
				$this->autoLogOut($return['msg']);
				echo "<script>location.href='/main/index'; </script>";
				//echo json_encode($return);
				exit;			
			}


			$qry = "update fm_member set login_cnt = login_cnt+1, lastlogin_date = now(), login_addr = '".$_SERVER['REMOTE_ADDR']."' where member_seq = '{$mbparams['member_seq']}' ";
			$result = $this->db->query($qry);

			## sns 로그인/연동 계정 세션 저장
			$this->api_sns_login_auth($snstype);
		
			### SESSION
			$this->load->helper("member");
			create_member_session($mbparams);

			### 성인인증세션 처리
			if($mbparams['adult_auth'] == 'Y'){
				$auth_intro_data = array('auth_intro_type'=>'auth', 'auth_intro_yn'=>'Y');
				$this->session->sess_expiration = (60 * 5);
				$this->session->set_userdata(array('auth_intro'=>$auth_intro_data));
			}else{
				$this->session->unset_userdata('auth_intro');
				$_SESSION['auth_intro']		= '';
			}
			
			### 장바구니 MERGE
			$this->load->model('cartmodel');
			$this->cartmodel->merge_for_member($mbparams['member_seq']);

			### 로그인 이벤트
			$this->load->model('joincheckmodel');
			$jcresult = $this->joincheckmodel->login_joincheck($mbparams['member_seq']);
			
			/* 고객리마인드서비스 상세유입로그 */
			$this->load->helper('reservation');
			$curation = array("action_kind"=>"login");
			curation_log($curation);

		}

		return $mbparams;
	}


	## 로그인/가입연동한 sns계정 세션 저장
	function api_sns_login_auth($snstype){

		$this->load->model('membermodel');
		$this->mdata = $this->membermodel->get_member_data($this->userInfo['member_seq']);//회원정보
		if($this->mdata['rute'] != 'none' && !$this->session->userdata("snslogn")){
			switch($snstype){
				case "sns_f": $snstype = "facebook"; break;
				case "sns_t": $snstype = "twitter"; break;
				case "sns_c": $snstype = "cyworld"; break;
				case "sns_n": $snstype = "naver"; break;
				case "sns_m": $snstype = "me2day"; break;
				case "sns_k": $snstype = "kakao"; break;
				case "sns_d": $snstype = "daum"; break;
				case "sns_i": $snstype = "instagram"; break;
			}
			$this->session->set_userdata("snslogn",$snstype);
		}
	}




// 일반 s
	function api_normal_login() {
		$this->load->model('ssl');
		$this->ssl->decode();
		/*TEST
		_POST
		member_seq 
		channel
		key
		*/
				
		$return = [];
		$data = $this->appmembermodel->get_app_member_info($_POST['member_seq'], ['status' => ['done', 'dormancy', 'hold']]);

		$db_api_key = $data['api_key'];
		$app_api_key = $_POST['key'];

		if (is_null($db_api_key) || $db_api_key == '') {
			// api_key 생성 및 db update
			$db_api_key = $this->appmembermodel->create_api_key($data['userid'], $data['member_seq'], true);
		} elseif ($app_api_key != $db_api_key && $app_api_key != '') {
			//일치하는 회원정보가 없습니다.
			$return['result'] = '0';
			$return['msg'] = getAlert('mb203');

			$wronglogin_cnt = ($_COOKIE['wronglogin']) ? $_COOKIE['wronglogin'] : 0;
			setcookie('wronglogin', $wronglogin_cnt + 1, time() + (60 * 5));	//5분동안 저장

			//			echo json_encode($return);
			echo "<script>location.href='/main/index'; </script>";
			exit;
		}

		setcookie('wronglogin', '', -1);		// 값을 비우고 휘발성으로 전환

		if ($data['status'] == 'hold') {
			$return['result'] = '0';
			$return['msg'] = '아직 가입승인이 되지 않았습니다.';

			//echo json_encode($return);
			echo "<script>location.href='/main/index'; </script>";
			exit;
		}

		$params = $data;
		### 휴면계정 체크
		if($params['dormancy_seq']){

			$return['result'] = '0';
			$return['msg'] = '휴면계정입니다. 휴면상태를 해제시키시려면 웹페이지 '.$this->domain_path.' 에 접속하셔서 로그인해주시기 바랍니다.';

			//자동로그아웃 처리
			$this->autoLogOut($return['msg']);
			
			echo "<script>location.href='/main/index'; </script>";
			//echo json_encode($return);
			exit;			
		}

		### LOG
		$qry = "update fm_member set login_cnt = login_cnt+1, lastlogin_date = now(), login_addr = '".$_SERVER['REMOTE_ADDR']."' where member_seq = '{$params['member_seq']}'";
		$result = $this->db->query($qry);

		### SESSION
		$this->load->helper("member");
		create_member_session($params);

		### 성인인증세션 처리
		if($params['adult_auth'] == 'Y'){
			$auth_intro_data = array('auth_intro_type'=>'auth', 'auth_intro_yn'=>'Y');
			$this->session->sess_expiration = (60 * 5);
			$this->session->set_userdata(array('auth_intro'=>$auth_intro_data));
		}else{
			$this->session->unset_userdata('auth_intro');
			$_SESSION['auth_intro']		= '';
		}

		### 장바구니 MERGE
		$this->load->model('cartmodel');
		$this->cartmodel->merge_for_member($params['member_seq']);

		//fblike 할인 MERGE
		$this->db->where('session_id',session_id());
		$this->db->update('fm_goods_fblike', array('member_seq' => $params['member_seq']));

		/* 고객리마인드서비스 상세유입로그 */
		$this->load->helper('reservation');
		$curation = array("action_kind"=>"login");
		curation_log($curation);
		
		if($_COOKIE['auto_login']=='y' || $this->session->userdata('auto_login') =='y') { //동일페이지에서 쿠키가 바로 구워지지 않은 경우 고려해서 세션값도 조건으로 처리
			$auto_login = 'y';
		}else{
			$auto_login = 'n';
		}

		$this->userInfo['member_seq'] = $params['member_seq'];
		$this->userInfo['user_id'] = $params['user_id'];
		$this->userInfo['user_name'] = $params['user_name'];

		$this->script_memberInfo($params, $auto_login);
		
		if($_POST['status']=='request') {
			
		}else{

			echo "<script>location.href='/main/index'; </script>";
			exit;
		
		}

	}



/*#############자동 로그아웃 s #############*/ 
	function autoLogout($msg=null) {
		
		$this->logout();
		setcookie('auto_login','n',$this->cookie_exp_time,'/',".".$this->config_basic['domain']);
		$this->session->set_userdata('auto_login','n');

		//네이버로그아웃 처리
		echo "<a src='http://nid.naver.com/nidlogin.logout' class='nvLogout'>  </a>";
		echo "<script type='text/javascript' src='/app/javascript/jquery/jquery.min.js'></script>";
		

		echo "<script>$('.nvLogout').click();</script>";

		echo "<script>";
		echo "";
		if ($this->m_device=='iphone') {
			echo "window.webkit.messageHandlers.CSharp.postMessage('Logout?');";
		}else{
			echo "CSharp.postMessage('Logout?');";
		}
		if($msg) {
			echo "alert('".$msg."');";
		}
		echo "</script>";
	}


	function logout(){ //app/controllers/login_process.php 참조
		$unsetuserdata = array('user'=>'','fbuser'=>'','accesstoken'=>'','signedrequest'=>'','nvuser'=>'','mtype'=>'','naver_state'=>'','naver_access_token'=>'','kkouser'=>'','dmuser'=>'','daum_access_token'=>'','http_host'=>'','snslogn'=>'','auth_intro'=>'','auth'=>'','cart_promotioncode_'.session_id()=>'');
		$this->session->unset_userdata($unsetuserdata);

		$_SESSION['user']			= ''; $_SESSION['fbuser']				= '';
		$_SESSION['accesstoken']	= ''; $_SESSION['signedrequest']		= '';
		$_SESSION['nvuser']			= ''; $_SESSION['naver_access_token']	= '';
		$_SESSION['naver_state']	= ''; $_SESSION['mtype']				= '';
		$_SESSION['kkouser']		= '';
		$_SESSION['dmuser']			= ''; $_SESSION['daum_access_token']	= '';
		$_SESSION['http_host']		= ''; $_SESSION['snslogn']				= '';
		$_SESSION['auth_intro']		= ''; $_SESSION['auth']			= '';
		$_SESSION['cart_promotioncode_'.session_id()]	= '';

		unset($this->userInfo, $_SESSION['user'], $_SESSION['fbuser'], $_SESSION['naver_state'], $_SESSION['naver_access_token'], $_SESSION['nvuser'], $_SESSION['accesstoken'], $_SESSION['signedrequest'],$_SESSION['kkouser'],$_SESSION['dmuser'],$_SESSION['daum_access_token'],$_SESSION['auth'],$_SESSION['cart_promotioncode_'.session_id()]);

	}

/*#############자동 로그아웃 e #############*/ 

	function script_memberInfo($snslogin, $auto_login = 'y', $type='script') {
		
	    $send_params = $this->appmembermodel->config_send_params($snslogin);
               
		
		if($type=='script') {
			echo "<script>
				var param = {
									   member_seq : ".$send_params['member_seq'].", 
									   user_id : '".$send_params['user_id']."', 
									   user_name : '".$send_params['user_name']."', 
									   session_id : '".session_id()."', 
									   channel : '".$send_params['channel']."', 
									   reserve : '".$send_params['reserve']."', 
									   balance : '".$send_params['balance']."', 
									   coupon : '".$send_params['coupon']."',
									   auto_login : '".$auto_login."',
									   api_key : '".$send_params['api_key']."'
								  };
				var strParam = JSON.stringify(param);

				var dataStr = 'MemberInfo?' + strParam; ";
				
			if($this->m_device=='iphone') {
				echo "window.webkit.messageHandlers.CSharp.postMessage(dataStr);";
			}else{
				echo "CSharp.postMessage(dataStr);";
			}	
			echo "</script>";	
		}else { //json
			echo json_encode(array('member_seq' => $send_params['member_seq'],
				   'user_id' => $send_params['user_id'], 
				   'user_name' => $send_params['user_name'], 
				   'session_id' => session_id(), 
				   'channel' => $channel, 
				   'reserve' => $send_params['reserve'], 
				   'balance' => $send_params['balance'], 
				   'coupon' => $send_params['coupon'],
				   'auto_login' => $auto_login,
				   'key' => $send_params['key']));
		}
		


	}
## 자동로그인 e #############################################################################




	##############################################################
	# 앱 설치후 > 첫 로그인시 혜택지급 및 중복지급되지 않도록 처리 
	# 앱에서 첫 로그인시 app_firstinstall 함수가 호출됨. 처리후 return 해야함 
	# A0001:설치이력있음({$implodepost})
	# A0002:혜택이력있음({$implodepost})
	# A0003:쿠폰지급실패({$implodepost})
	##############################################################
	function app_firstinstall() {
		$this->load->model('couponmodel');
		$this->load->model('membermodel');

		$member_seq	= $_POST['member_seq'];
		$os_type			= $_POST['os_type'];
		$first_install		= $_POST['first_install'];
		$implodepost		= implode("/", $_POST);

		$returnmsg = "A000:start({$implodepost})";
		$succYN= ''; //성공했는가 여부
		$failment = "";
		//첫 설치 & 회원이 혜택을 받으적이 없다면 1회 혜택 지급
		if($first_install == 'Y'){
			$sql = "select member_seq from fm_member where member_seq='{$member_seq}' and app_benefitYN !='Y' ";
			$row = $this->db->query($sql)->row_array();

			//혜택을 지급받아야하는 회원이라면 
			if($row['member_seq'] !=''){
				$sql_benefit = "select * from fm_app_benefit ";
				$row_benefit = $this->db->query($sql_benefit)->row_array();

				//혜택이 쿠폰일경우
				if($row_benefit['appbenefit'] == 'coupon'){
					//admin/coupon_process/download_write
					$couponSeq = (int) $row_benefit['sel_coupon'];
					unset($memberArr);
					$memberArr[]['member_seq'] = $member_seq;
					$coupons = $this->couponmodel->get_coupon($couponSeq);

					$downloadcnt = 0;
					// 발급쿠폰 정보 확인
					$downcoupons = $this->couponmodel->get_admin_download($member_seq, $couponSeq);
					if(!$downcoupons){
						if( $this->couponmodel->_admin_downlod( $couponSeq, $member_seq) ) {
							$downloadcnt++;
						}
					}else{
						$failment = "이미 지급받은 쿠폰 입니다";
					}
					if($downloadcnt > 0) {
						$app_benefitDetail = "쿠폰혜택 : [{$coupons['coupon_name']} ({$couponSeq})] 지급";
						$succYN= 'Y'; //성공했는가 여부
					}else{
						$app_benefitDetail = "쿠폰혜택 : [{$coupons['coupon_name']} ({$couponSeq})] 지급실패 / {$failment} ";
						$returnmsg = "A0003:쿠폰지급실패({$implodepost})";
					}
				//혜택이 적립금 지급일경우
				}else if($row_benefit['appbenefit'] == 'emoney'){
					$params_reserve['gb']			= "plus";
					$params_reserve['emoney']	= $row_benefit['app_emoney'];
					$params_reserve['memo']		= "[앱설치] 이벤트 적립금 지급";
					$params_reserve['type']			= "direct";
					$this->membermodel->emoney_insert($params_reserve, $member_seq);
					$app_benefitDetail = "적립금혜택 : {$row_benefit['app_emoney']} 지급";
					$succYN= 'Y'; //성공했는가 여부
				}else{ 
					$app_benefitDetail = "혜택없음";
					$succYN= 'Y'; //성공했는가 여부
				}

				//혜택 1회 받았음 인증
				$sql_up = "update fm_member set app_benefitYN='Y', app_benefitDetail='{$app_benefitDetail}' where member_seq='{$member_seq}' ";
				$this->db->query($sql_up);

				//성공시 앱으로 리턴해줘야하는값
				if($succYN == 'Y') $returnmsg = "succ"; 

			}else{
				$returnmsg = "A0002:혜택이력있음({$implodepost})";
			}
		}else{
			$returnmsg = "A0001:설치이력있음({$implodepost})";
		}


		//test-------나중에 지울꺼임!!
		$sql_up1 = "update fm_member set admin_memo='{$returnmsg}' where member_seq='{$member_seq}' ";
		$this->db->query($sql_up1);


		//앱으로 결과값 리턴해줌
		$result = array("result"=>"1", "msg" => $returnmsg);
		echo json_encode($result);
	} 
}	
