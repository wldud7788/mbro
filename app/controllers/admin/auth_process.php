<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class auth_process extends admin_base {

	public function __construct() {
		parent::__construct();
		$this->load->library('validation');
		$this->load->library('snssocial');
		$this->load->model('membermodel');
		$this->load->helper('member');
	}



	public function auth_phone_return(){

		$realname = config_load('realname');
		$auth = $this->session->userdata('auth');
		$findtypess = $this->session->userdata('findtypess');
		$findidss = $this->session->userdata('findidss');

		if(!extension_loaded('CPClient')) {
			dl('CPClient.' . PHP_SHLIB_SUFFIX);
		}
		$module = 'CPClient';


		//필수 수정값
		$sSite					= checksmskey('phone');
		$sSiteCode 			= $sSite['Code'];			// 본인인증 사이트 코드
		$sSitePassword		= $sSite['Password'];			// 본인인증 사이트 패스워드
		$authtype = "M";      	// 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드
		$popgubun 	= "Y";		//Y : 취소버튼 있음 / N : 취소버튼 없음
		$customize 	= "";			//없으면 기본 웹페이지 / Mobile : 모바일페이지

		//******************************************************************************************************************

		$enc_data	= $this->input->post_get("EncodeData");		// 암호화된 결과 데이타
		$sReserved1 = $this->input->post_get('param_r1');
		$sReserved2 = $this->input->post_get('param_r2');
		$sReserved3 = $this->input->post_get('param_r3');


		$pageType	= $_GET['p_type'];

		//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
		if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "입력 값 확인이 필요합니다 : ".$match[0]; exit;} // 문자열 점검 추가.
		if(base64_encode(base64_decode($enc_data))!=$enc_data) {echo "입력 값 확인이 필요합니다"; exit;}

		if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved1, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
		if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved2, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
		if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved3, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////


		if ($enc_data != "") {

			//$plaindata = `$cb_encode_path DEC $sSiteCode $sSitePassword $enc_data`;		// 암호화된 결과 데이터의 복호화

			$function = 'get_decode_data';// 암호화된 결과 데이터의 복호화
			if (extension_loaded($module)) {
				$plaindata = $function($sSiteCode, $sSitePassword, $enc_data);

			} else {
				$plaindata = "Module get_response_data is not compiled into PHP";
			}


			if ($plaindata == -1){
				$returnMsg  = "암/복호화 시스템 오류";
			}else if ($plaindata == -4){
				$returnMsg  = "복호화 처리 오류";
			}else if ($plaindata == -5){
				$returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
			}else if ($plaindata == -6){
				$returnMsg  = "복호화 데이터 오류";
			}else if ($plaindata == -9){
				$returnMsg  = "입력값 오류";
			}else if ($plaindata == -12){
				$returnMsg  = "사이트 비밀번호 오류";
			}else{
				$returnMsg  = "본인인증이 확인되었습니다.";

				// 복호화가 정상적일 경우 데이터를 파싱합니다.
 				//$ciphertime = `$cb_encode_path CTS $sSiteCode $sSitePassword $enc_data`;	// 암호화된 결과 데이터 검증 (복호화한 시간획득)
				/**
				//사용하지 않는 변수이고 제공모듈에서도 함수가 없어서 주석@2015-10-29
				$function = 'get_cipher_datetime';// 암호화된 결과 데이터 검증 (복호화한 시간획득)
				if (extension_loaded($module)) {
					$ciphertime = $function($sitecode,$sitepasswd,$enc_data);
				} else {
					$ciphertime = "Module get_cipher_datetime is not compiled into PHP";
				}***/


				$requestnumber = GetValueNameCheck($plaindata , "REQ_SEQ");
				$responsenumber = GetValueNameCheck($plaindata , "RES_SEQ");
				$authtype = GetValueNameCheck($plaindata , "AUTH_TYPE");
				$name = GetValueNameCheck($plaindata , "NAME");
				$birthdate = GetValueNameCheck($plaindata , "BIRTHDATE");
				$gender = GetValueNameCheck($plaindata , "GENDER");
				$nationalinfo = GetValueNameCheck($plaindata , "NATIONALINFO");	//내/외국인정보(사용자 매뉴얼 참조)
				$dupinfo = GetValueNameCheck($plaindata , "DI");
				$conninfo = GetValueNameCheck($plaindata , "CI");
				$errcode = GetValueNameCheck($plaindata , "ERR_CODE");

				if(strcmp($this->session->userdata['REQ_SEQ_P'], $requestnumber) != 0  || !$dupinfo)
				{

					$requestnumber = "";
					$responsenumber = "";
					$authtype = "";
					$name = "";
					$birthdate = "";
					$gender = "";
					$nationalinfo = "";
					$dupinfo = "";
					$conninfo = "";

					$msg = "세션값이 다릅니다. 올바른 경로로 접근하시기 바랍니다. (code : 1)";
					pageClose($msg);
					exit;
				}else{

					$auth_data["auth_yn"] = "Y";
					$auth_data["namecheck_type"] = "phone";
					$auth_data["namecheck_name"] = iconv("euc-kr", "utf-8", $name);
					$auth_data["namecheck_sex"] = iconv("euc-kr", "utf-8", $gender);
					$auth_data["namecheck_birth"] = iconv("euc-kr", "utf-8", $birthdate);

					$auth_data["namecheck_check"] = iconv("euc-kr", "utf-8", $dupinfo);//중복체크용
					$auth_data["namecheck_vno"] = iconv("euc-kr", "utf-8", $conninfo);//주민등록번호와고유키

					if( !$auth_data["namecheck_check"] ){
						$msg = "세션값이 다릅니다. 올바른 경로로 접근하시기 바랍니다. (code : 2)";
						pageClose($msg);
						exit;
					}

					$this->load->model("smsmodel");
					$this->smsmodel->smsHpAauthCheck($auth_data);

					if($pageType == 'sms_manual'){
						pageLocation('/admin/batch/sms_form', $msg, 'opener');
					}else{
						pageLocation('/admin/batch/sms', $msg, 'opener');
					}
					pageClose();
					exit;

				}
			}
			$msg = "잠시 후 다시 시도하여주십시오.<br/>오류가 계속 될 경우 고객센터로 문의하세요.";
			//pageClose($msg);
			exit;

		} else {
			$sRtnMsg = "처리할 암호화 데이타가 없습니다.";
		}

		pageClose($sRtnMsg);
		exit;
	}


	public function ipin_chk(){
		$realname = config_load('realname');
		$auth = $this->session->userdata('auth');
		$findtypess = $this->session->userdata('findtypess');
		$findidss = $this->session->userdata('findidss');

		if(!extension_loaded('IPINClient')) {
			dl('IPINClient.' . PHP_SHLIB_SUFFIX);
		}
		$module = 'IPINClient';

		$sSite = checksmskey('ipin');
		$sSiteCode		= $sSite['Code'];
		$sSitePw			= $sSite['Password'];

		$sEncData					= "";			// 암호화 된 사용자 인증 정보
		$sDecData					= "";			// 복호화 된 사용자 인증 정보

		$sRtnMsg					= "";			// 처리결과 메세지
		$sModulePath	= $_SERVER["DOCUMENT_ROOT"]."/namecheck/IPINClient";
		$sEncData		= $this->input->post_get("enc_data");
		$pageType		= $_GET['p_type'];

		//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
		if(preg_match('~[^0-9a-zA-Z+/=]~', $sEncData, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
		if(base64_encode(base64_decode($sEncData))!=$sEncData) {echo "입력 값 확인이 필요합니다!"; exit;}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////

		$sCPRequest = $this->session->userdata['CPREQUEST'];

		if ($sEncData != "") {

			//$sDecData = `$sModulePath RES $sSiteCode $sSitePw $sEncData`;

			// 사용자 정보를 복호화 합니다.
			$function = 'get_response_data';
				if (extension_loaded($module)) {
					$sDecData = $function($sSiteCode, $sSitePw, $sEncData);
				} else {
					$sDecData = "Module get_response_data is not compiled into PHP";
				}


			if ($sDecData == -9) {
				$sRtnMsg = "입력값 오류 : 복호화 처리시, 필요한 파라미터값의 정보를 정확하게 입력해 주시기 바랍니다.";
			} else if ($sDecData == -12) {
				$sRtnMsg = "NICE신용평가정보에서 발급한 개발정보가 정확한지 확인해 보세요.";
			} else {

				$arrData = preg_split("/\^/", $sDecData);
				$iCount = count($arrData);

				if ($iCount >= 5) {

					$strResultCode	= $arrData[0];			// 결과코드
					if ($strResultCode == 1) {
						$strCPRequest	= $arrData[8];			// CP 요청번호

						if ($sCPRequest == $strCPRequest) {

							$sRtnMsg = "사용자 인증 성공";

							$strVno      		= $arrData[1];	// 가상주민번호 (13자리이며, 숫자 또는 문자 포함)
							$strUserName		= $arrData[2];	// 이름
							$strDupInfo			= $arrData[3];	// 중복가입 확인값 (64Byte 고유값)
							$strAgeInfo			= $arrData[4];	// 연령대 코드 (개발 가이드 참조)
							$strGender			= $arrData[5];	// 성별 코드 (개발 가이드 참조)
							$strBirthDate		= $arrData[6];	// 생년월일 (YYYYMMDD)
							$strNationalInfo	= $arrData[7];	// 내/외국인 정보 (개발 가이드 참조)

							$auth_data["auth_yn"] = "Y";
							$auth_data["namecheck_type"] = "ipin";
							$auth_data["namecheck_name"] = iconv("euc-kr", "utf-8", $strUserName);
							$auth_data["namecheck_sex"] = iconv("euc-kr", "utf-8", $strGender);
							$auth_data["namecheck_birth"] = iconv("euc-kr", "utf-8", $strBirthDate);
							$auth_data["namecheck_check"] = iconv("euc-kr", "utf-8", $strDupInfo);
							$auth_data["namecheck_vno"] = iconv("euc-kr", "utf-8", $strVno);

							$this->load->model("smsmodel");
							$this->smsmodel->smsHpAauthCheck($auth_data);

							if($pageType == 'sms_manual'){
								pageLocation('/admin/batch/sms_form', $msg, 'opener');
							}else{
								pageLocation('/admin/batch/sms', $msg, 'opener');
							}
							pageClose();
							exit;

						} else {
							$sRtnMsg = "CP 요청번호 불일치 : 세션에 넣은 $sCPRequest 데이타를 확인해 주시기 바랍니다.";
						}
					} else {
						$sRtnMsg = "리턴값 확인 후, NICE신용평가정보 개발 담당자에게 문의해 주세요. [$strResultCode]";
					}

				} else {
					$sRtnMsg = "리턴값 확인 후, NICE신용평가정보 개발 담당자에게 문의해 주세요.";
				}

			}
		} else {
			$sRtnMsg = "처리할 암호화 데이타가 없습니다.";
		}

		pageClose($sRtnMsg);
		exit;
	}
}

/* End of file auth_process.php */
/* Location: ./app/controllers/admin/auth_process.php */