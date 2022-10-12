<?php

/**
 * @author ocw
 */

function confirmLicenseLink($string)
{
	$CI =& get_instance();
	$CI->load->helper('readurl');
	
	$businessLicense = preg_replace("/[^0-9]/",'',$CI->config_basic['businessLicense']);

	$protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https://' : 'http://';
	//#21344 2018-08-27 ycg 통신판매사업자 확인 API 주소 변경
	$url = $protocol."www.ftc.go.kr/bizCommPop.do?wrkr_no={$businessLicense}";
	//$res = readurl($url);
	
	//if($res){
		$html = "";
		$html .= "<a href=\"javascript:;\" onclick=\"window.open('{$url}','communicationViewPopup','width=750,height=700,scrollbars=yes')\">";
		$html .= $string;
		$html .= "</a>";
	/*
	}else{
		$html = "";
		$html .= "<a href=\"javascript:;\" onclick=\"openDialogAlert('공정거래위원회 데이터베이스에서<br />사업자번호 {$businessLicense}의 정보를 찾을 수 없습니다.',500,155)\">";
		$html .= $string;
		$html .= "</a>";
	}
	*/
	
	return $html;	
}
?>