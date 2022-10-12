<?php
class smsmodel extends CI_Model {

	/*
	* RETURN : LIMIT_TYPE, USED BY PERCENT, LIMIT CAN USE, MESSAGE
	*
	*/
	function sms_auth_check(){

		$CI =& get_instance();
		$auth = config_load('master');

		$sms_id = $this->config_system['service']['sms_id'];
		$sms_api_key = $auth['sms_auth'];

		if(!$CI->session->userdata['smsHpAuth']){
			redirect("/admin/batch/sms_hp_auth");
			exit;
		}

		$smsAuthTime = strtotime(date("Y-m-d H:i:s"))-$CI->session->userdata['smsHpAuthTime'];

		if($smsAuthTime > 3600){
			$return['code'] = "203";
			return $return;
		}

		$CI->session->set_userdata['token']['requestToken'] = '';
		$CI->session->set_userdata['token']['accessToken'] = '';

		$requestToken = md5($sms_id.date("YmdHis"));

		$orderUrl = get_connet_protocol().'sms2.firstmall.kr/smsouth/getAccessToken';
		$queryString = 'sms_id='.$sms_id;
		$queryString .= '&api_key='.$sms_api_key;
		$queryString .= '&requestToken='.$requestToken;
		$queryString .= '&real_server_ip='.$_SERVER['REMOTE_ADDR'];

		$cu = curl_init();
		curl_setopt($cu, CURLOPT_URL,$orderUrl); // 데이터를 보낼 URL 설정
		curl_setopt($cu, CURLOPT_HEADER, FALSE);
		curl_setopt($cu, CURLOPT_FAILONERROR, TRUE);
		curl_setopt($cu, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded;charset=UTF-8'));
		curl_setopt($cu, CURLOPT_POST, 1); // 데이터를 get/post 로 보낼지 설정.
		curl_setopt($cu, CURLOPT_POSTFIELDS, $queryString); // 보낼 데이터를 설정. 형식은 GET 방식으로설정
		curl_setopt($cu, CURLOPT_RETURNTRANSFER, 1); // REQUEST 에 대한 결과값을 받을 것인지 체크.#Resource ID 형태로 넘어옴 :: 내장 함수 curl_errno 로 체크
		curl_setopt($cu, CURLOPT_TIMEOUT,60); // REQUEST 에 대한 결과값을 받는 시간 설정.
		curl_setopt($cu, CURLOPT_SSL_VERIFYPEER, 0); //
		curl_setopt($cu, CURLOPT_SSL_VERIFYHOST, 1); //

		$result = curl_exec($cu); // 실행

		curl_close($cu);

		$authData = json_decode($result, true);

		$CI->session->set_userdata(array('token'=>array('requestToken'=>$requestToken, 'accessToken'=>$authData['msg']) ));

		return $authData;

	}

	// 인증 체크 함수 :: 2018-07-18 lwh
	function smsAuth_chk(){
		$smsAuth['auth'] = false;
		if($this->session->userdata['smsHpAuth']){
			$smsAuthTime = strtotime(date("Y-m-d H:i:s")) - $this->session->userdata['smsHpAuthTime'];
			if($smsAuthTime <= 10800){
				$smsAuth['auth'] = true;
			}else{
				$smsAuth['msg'] = "인증 시간이 만료되었습니다. 다시 인증해 주십시오.";
			}
		}

		if(!$smsAuth['auth']){
			unset($_SESSION['smsHpAuth']);
		}

		return $smsAuth;
	}

	// SMS 발송 파일 로깅
	function sms_log_write($msg){
		$logDir = ROOTPATH."/data/logs/";
		if(!is_dir($logDir)){
		mkdir($logDir);
		@chmod($logDir,0777);
		}
		$fp = fopen($logDir.'smssend_'.date('Ymd').'.log',"a+");
		fwrite($fp,"[".date('Y-m-d H:i:s')."] - sms_send \r\n");
		ob_start();
		echo 'admin_seq : '.$this->session->userdata['manager']['manager_seq'] . "\r\n";
		echo 'ip_addr : '.$_SERVER['REMOTE_ADDR'] . "\r\n";
		echo 'agent : '  . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
		echo 'geoip : ' . $_SERVER['GEOIP_ADDR'] . "\r\n";
		echo 'geo_country : ' . $_SERVER['REDIRECT_GEOIP_COUNTRY_NAME'] . "\r\n";
		echo 'msg : ';
		print_r($msg);
		$contents = ob_get_contents();
		$contents = str_replace("\n","\r\n",$contents);
		ob_clean();
		fwrite($fp,$contents . "\r\n");
		fclose($fp);
	}

	function smsHpAauth(){

		$CI =& get_instance();

		$realnametype	= ($_POST['realnametype'])	? $_POST['realnametype']	: $_GET['realnametype'];
		$pageType		= ($_POST['p_type'])		? $_POST['p_type']			: $_GET['p_type'];

		if( $realnametype ) {

			if ($_SERVER['HTTPS'] == "on") {
				$HTTP_HOST = "https://".$_SERVER['HTTP_HOST'];
			}else{
				$HTTP_HOST = "http://".$_SERVER['HTTP_HOST'];
			}

			if ( $pageType ) $returnurl_intro = '?p_type=' . $pageType; // 기존 변수 재활용

			if( $realnametype == 'phone' ) {//본인인증
				//**************************************** 본인인증 : 휴대폰 필수 수정값***************************************************************************
				if(!extension_loaded('CPClient')) {
					dl('CPClient.' . PHP_SHLIB_SUFFIX);
				}
				$module = 'CPClient';

				$sSite = checksmskey($realnametype);
				$sSiteCode 			= $sSite['Code'];			// 본인인증 사이트 코드
				$sSitePassword		= $sSite['Password'];			// 본인인증 사이트 패스워드
				$authtype			= "M";    // 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드
				$popgubun 			= "Y";		//Y : 취소버튼 있음 / N : 취소버튼 없음


//				$cb_encode_path	= $_SERVER["DOCUMENT_ROOT"]."/namecheck/CPClient";	// 암호화 프로그램의 위치 (절대경로+모듈명)_Linux ..
//				$sType			= "REQ";
//				$reqseq = `$cb_encode_path SEQ $sSiteCode`;


				$reqseq = "REQ_0123456789";     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로

				// 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.
				$function = 'get_cprequest_no';
				if (extension_loaded($module)) {
					$reqseq = $function($sitecode);
				} else {
					$reqseq = "Module get_request_no is not compiled into PHP";
				}

				$returnurl		= $HTTP_HOST."/admin/auth_process/auth_phone_return".$returnurl_intro;	// 성공시 이동될 URL
				$errorurl		= $HTTP_HOST."/admin/auth_process/auth_phone_return".$returnurl_intro;	// 실패시 이동될 URL

				// reqseq값은 성공페이지로 갈 경우 검증을 위하여 세션에 담아둔다.

				$CI->session->set_userdata(array('REQ_SEQ_P'=>$reqseq));//$_SESSION["REQ_SEQ"] = $reqseq;
				$_SESSION["REQ_SEQ_P"] = $reqseq;


				// 입력될 plain 데이타를 만든다.1
				$plaindata =  "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
										  "8:SITECODE" . strlen($sSiteCode) . ":" . $sSiteCode .
										  "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
										  "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
										  "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
										  "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
										  "9:CUSTOMIZE" . strlen($customize) . ":" . $customize.
										  "9:RESERVED1" . strlen($sReserved1) . ":" . $sReserved1.
										  "9:RESERVED2" . strlen($sReserved2) . ":" . $sReserved2.
										  "9:RESERVED3" . strlen($sReserved3) . ":" . $sReserved3;

				//$enc_data = `$cb_encode_path ENC $sSiteCode $sSitePassword $plaindata`;

				$function = 'get_encode_data';
				if (extension_loaded($module)) {
					$enc_data = $function($sSiteCode, $sSitePassword, $plaindata);
				} else {
					$enc_data = "Module get_request_data is not compiled into PHP";
				}

				if( $enc_data == -1 )
				{
					$returnMsg = "암/복호화 시스템 오류입니다.";
					//$enc_data = "";
				}
				else if( $enc_data== -2 )
				{
					$returnMsg = "암호화 처리 오류입니다.";
					//$enc_data = "";
				}
				else if( $enc_data== -3 )
				{
					$returnMsg = "암호화 데이터 오류 입니다.";
					//$enc_data = "";
				}
				else if( $enc_data== -9 )
				{
					$returnMsg = "입력값 오류 입니다.";
					//$enc_data = "";
				}
				$sEncData = $enc_data;
			}
			elseif( $realnametype == 'ipin' ) {//아이핀체크

					if(!extension_loaded('IPINClient')) {
						dl('IPINClient.' . PHP_SHLIB_SUFFIX);
					}
					$module = 'IPINClient';

					###
					$sSite = checksmskey($realnametype);
					$sSiteCode		= $sSite['Code'];
					$sSitePw			= $sSite['Password'];

					$sModulePath	= $_SERVER["DOCUMENT_ROOT"]."/namecheck/IPINClient";
					$sReturnURL		= get_connet_protocol().$_SERVER['HTTP_HOST']."/admin/auth_process/ipin_chk".$returnurl_intro;

					##
					$sType			= "SEQ";
					//$sCPRequest = `$sModulePath $sType $sSiteCode`;

					$function = 'get_request_no';
					if (extension_loaded($module)) {
						$sCPRequest = $function($sSiteCode);
					} else {
						$sCPRequest = "Module get_request_no is not compiled into PHP";
					}


					$CI->session->set_userdata(array('CPREQUEST'=>$sCPRequest));
					$_SESSION['CPREQUEST'] = $sCPRequest;

					##
					$sType			= "REQ";
					$sEncData		= "";
					$sRtnMsg		= "";

					//$sEncData	= `$sModulePath $sType $sSiteCode $sSitePw $sCPRequest $sReturnURL`;//$sCPRequest $sReturnURL

					$function = 'get_request_data';
					if (extension_loaded($module)) {
						$sEncData = $function($sSiteCode, $sSitePw, $sCPRequest, $sReturnURL);
					} else {
						$sEncData = "Module get_request_data is not compiled into PHP";
					}


					if ($sEncData == -9){
						$sRtnMsg = "입력값 오류 : 암호화 처리시, 필요한 파라미터값의 정보를 정확하게 입력해 주시기 바랍니다.";
					}
			}

			if(empty($sEncData)) {//실패시
				$returnMsg = '잘못된 접근입니다.';
				pageClose($returnMsg);
				exit;
			}

			if($returnMsg) {//실패시
				pageClose($returnMsg);
				exit;
			}

			$scripts[] = "<script type='text/javascript' src='/app/javascript/jquery/jquery.min.js'></script>";
			$scripts[] = "<script type='text/javascript'>";
			$scripts[] = "$(function() {";
			if( $realnametype == 'phone' ) {//본인인증
				$encodedataform = '<input type="hidden" name="m" value="checkplusSerivce" >';
				$encodedataform .= '<input type="hidden" name="EncodeData" value="'.$sEncData.'" >';
				$action= 'https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb';
				$scripts[] = 'document.form_chk.submit();';
			}else{
				if( $realnametype == 'ipin' ) {//ipin
					$encodedataform = '<input type="hidden" name="m" value="pubmain" >';
					$action= 'https://cert.vno.co.kr/ipin.cb';
				}else{
					$encodedataform = '<input type="hidden" name="m" value="" >';
					$action = 'https://cert.namecheck.co.kr/NiceID2/certpass_input.asp';
				}
				$encodedataform .= '<input type="hidden" name="enc_data" value="'.$sEncData.'" >';
				$scripts[] = 'document.form_chk.submit();';
			}


			$scripts[] = "});";
			$scripts[] = "</script>";

echo '<html><head>';
foreach($scripts as $script){
	echo $script."\n";
}
echo '</head><body>
<form method="post" name="form_chk" action="'.$action.'">
'.$encodedataform.'
<input type="hidden" name="param_r1" value="'.trim($sReserved1).'">
<input type="hidden" name="param_r2" value="'.trim($sReserved2).'">
<input type="hidden" name="param_r3" value="'.trim($sReserved3).'">
</form>
</body>
</html>
';
			exit;
		}else{
			$returnMsg ="잘못된 접근입니다.";
			exit;
		}
	}

	function smsHpAauthCheck($params){
		$CI =& get_instance();
		$CI->session->set_userdata(array('smsHpAuth'=>1, 'smsHpAuthTime'=>strtotime(date("Y-m-d H:i:s"))));
	}



	function checkSafeKey($sms_auth = null){
		$CI =& get_instance();
		$auth = config_load('master');
		$sms_id = $this->config_system['service']['sms_id'];
		$sms_api_key = $sms_auth ? $sms_auth : $_POST['safe_key'];

		$requestToken = md5($sms_id.date("YmdHis"));

		$orderUrl = get_connet_protocol().'sms.firstmall.kr/smsouth/checkSafeKey';
		$queryString = 'sms_id='.$sms_id;
		$queryString .= '&api_key='.$sms_api_key;
		$queryString .= '&manager_id='.$this->managerInfo['manager_id'];
		$queryString .= '&real_server_ip='.$_SERVER['REMOTE_ADDR'];

		$cu = curl_init();
		curl_setopt($cu, CURLOPT_URL,$orderUrl); // 데이터를 보낼 URL 설정
		curl_setopt($cu, CURLOPT_HEADER, FALSE);
		curl_setopt($cu, CURLOPT_FAILONERROR, TRUE);
		curl_setopt($cu, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded;charset=UTF-8'));
		curl_setopt($cu, CURLOPT_POST, 1); // 데이터를 get/post 로 보낼지 설정.
		curl_setopt($cu, CURLOPT_POSTFIELDS, $queryString); // 보낼 데이터를 설정. 형식은 GET 방식으로설정
		curl_setopt($cu, CURLOPT_RETURNTRANSFER, 1); // REQUEST 에 대한 결과값을 받을 것인지 체크.#Resource ID 형태로 넘어옴 :: 내장 함수 curl_errno 로 체크
		curl_setopt($cu, CURLOPT_TIMEOUT,60); // REQUEST 에 대한 결과값을 받는 시간 설정.
		curl_setopt($cu, CURLOPT_SSL_VERIFYPEER, 0); //
		curl_setopt($cu, CURLOPT_SSL_VERIFYHOST, 1); //

		$result = curl_exec($cu); // 실행

		curl_close($cu);

		$authData = json_decode($result, true);

		if	( !$sms_auth ) {
			if($authData['code'] == "200"){
				$CI->session->set_userdata(array('member_excel_download'=>'y'));
			}else{
				$CI->session->set_userdata(array('member_excel_download'=>'n'));
			}
		}

		return $authData;

	}

}
