<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function xss_clean_basic($value,$key=null,$type=null){
	$msg	= '유효하지 않은 문자가 체크되었습니다.';

	if( is_array($value) ) {
		foreach($value as $value2){
			xss_clean_basic($value2,$key);
		}
	}else{
		// JS Hex encode 데이터로 넘어올 경우 decode 하여 XSS 필터링 체크
		if (preg_match('@\\\(x)?([0-9a-f]{2,3})@', $value)) {
			$value = decodeJsHexString($value);
		}
		// 방식에 따라 필터 적용
		if($type==null){
			$value_filter = xss_clean($value);
		}elseif($type=="filter_html_tags"){
			$value_filter = strip_tags($value);
			//xss 원복 kmj
			$value_filter = preg_replace("/(onmouseover|onclick|onsubmit)/","",$value_filter);
		}
		if($value_filter != $value){
			//xsswriteLog($key." ==> ".$value_filter. " != ".$value,uri_string());

			/**
			* 보안체크 추가
			* login, member, mypage, board, sales
			* @2017-04-18
			**/
			if(strstr(uri_string(), "_process")){
				if(strstr(uri_string(), "board_"))$callback = "parent.submitck();";
				openDialogAlert($msg,400,140,'parent',$callback);
			}else{
				pageBack($msg);
			}
			exit;
		}
	}
}

function xss_clean_filter(){
	$CI =& get_instance();
	$CI->load->helper('Security');
	$CI->load->helper('javascript');

	//예외처리
	$pass_post = array('sslEncodedString', 'return_url', 'referer_page_ga'); //무료보안, 이전페이지(가입/로그인/본인인증/그외페이지)
	if (preg_match("/^(board_process|board_goods_process|board_comment_process)/i", uri_string())) { //게시판
		array_push($pass_post,'returnurl', 'contents', 'file_key_w', 'file_key_i');
	} else if (preg_match("/board\/video_update/i", uri_string())) { // 게시판-동영상 등록
	    array_push($pass_post, 'file_key_W', 'file_key_I', 'file_key', 'r_img', 'file_key_A');
	} else if (preg_match("/^(sns_process\/(daumuserinfo|snsredirecturl))/i", uri_string())) { //SNS 다음
		array_push($pass_post, 'str', 'snsurl');
	} else if (preg_match("/^(naverpay\/(set_npay_order))/i", uri_string())) {
		array_push($pass_post, 'npay_cont');
	} else if (
		preg_match("/^(board\/(popup_video))/i", uri_string())
		||
		preg_match("/^(goods\/(popup_video))/i", uri_string())
		||
		preg_match("/^(mypage\/(popup_video))/i", uri_string())
	) {//동영상등록시
		array_push($pass_post, 'hidFileID', 'file_key', 'file_key_W', 'file_key_I', 'r_img', 'file_key_A');
	} else if (preg_match("/^(common\/(category_all_navigation|brand_all_navigation|location_all_navigation))/i", uri_string())) { //전체 카테고리/브랜드/지역
		array_push($pass_post, 'requesturi');
	} else if (
		preg_match("/^(payment\/(kcp|kcp_return|lg|lg_return|allat|allat_return|inicis|inicis_return|kspay|kspay_return|kakaopay|kicc|kicc_return))/i", uri_string())
		||
		preg_match("/^(kcp_mobile|inicis_mobile|kspay_mobile|allat_mobile|lg_mobile|kicc_mobile)/i", uri_string())
		||
		preg_match("/^(kicc\/(receive|request|iframe))/i", uri_string())
	) {
		return;
	} else if (preg_match("/^(order\/(epost_delivery_set|epost_export_get))/i", uri_string())) { // 우체국 택배 연동
		return;
	}

	foreach ($_POST as $key => $value) {
		if (@in_array($key, $pass_post)) continue;
		xss_clean_basic($value, $key);
	}

	foreach ($_GET as $key => $value) {
		// GET 메소드의 경우 예외처리 시에도 html 태그 제거
		xss_clean_basic($value, $key, "filter_html_tags");

		if (@in_array($key, $pass_post)) continue;
		xss_clean_basic($value, $key);
	}
}

function xsswriteLog($xssckvalue,$xssurl)
{
	$valuear['xsscheckval'][] = $xssckvalue;
	$valuear['xssurl'][] = $xssurl;
	if($_POST){
		$PageCall_time = date("H:i:s");
		$valuear['PageCall time'][] = $PageCall_time;
	}

	foreach ($_POST as $key => $value)
	{
		// If magic quotes is enabled strip slashes
		if (get_magic_quotes_gpc())
		{
			$_POST[$key] = stripslashes($value);
			$value = stripslashes($value);
		}
		$value = urlencode($value);
		$req .= "&$key=$value";
		$valuear[$key][] = $value;
	}

	foreach ($_GET as $key => $value)
	{
		// If magic quotes is enabled strip slashes
		if (get_magic_quotes_gpc())
		{
			$_GET[$key] = stripslashes($value);
			$value = stripslashes($value);
		}
		$value = urlencode($value);
		$req .= "&$key=$value";
		$valuear[$key][] = $value;
	}

	$msg  = $valuear;

	$file = "xss_input_".date("Ymd").".log";
	$path = "data/tmp/";
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

// javascript Hex String decode
function decodeJsHexString($code)
{
	$callbackFunction = function ($str) {
		$unhexStr = "";
		if ($str[1]) {
			$hex = substr($str[2], 0, 2);
			$unhex = chr(hexdec($hex));
			if (strlen($str[2]) > 2) {
				$unhex .= substr($str[2], 2);
			}
			$unhexStr = $unhex;
		} else {
			$unhexStr = chr(octdec($str[2]));
		}
		return $unhexStr;
	};

	$decodeHexStr = preg_replace_callback('@\\\(x)?([0-9a-f]{2,3})@', $callbackFunction, $code);

	return $decodeHexStr;
}
?>
