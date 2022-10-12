<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coin 
{
	function __construct() {
		
	}
	
	// 코인 현재 가격 가져오는 api 
	function value() {
		/*

		// 수정필요 
		// api 호출 
		$url = 'http://13.124.142.177:8083/v1/trade/getTokenPrice';
		$headers = array( "content-type: application/json", "accept-encoding: gzip","charset=UTF-8" );

		$check['systemId'] = 'web2';
		$check['requestTime'] = '20200112105117123';
		$check['trxId'] = '2f44f241-9d64-4d16-bf56-70b9d4e0e79a';
		$check['coinId'] = 'BMP';
		$check['currency'] = 'KRW';

		// json 으로 보낼 형식 
		$postData = json_encode($check);

		// curl 실행 
		$ch=curl_init(); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_URL, $url); //header값 셋팅(없을시 삭제해도 무방함)
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //POST방식 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
		curl_setopt($ch, CURLOPT_POST, true); //POST방식으로 넘길 데이터(JSON데이터) 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 3); // 전송에 3초가 지나면 타임아웃
		$response = curl_exec($ch);
		$response = json_decode($response, TRUE);
		*/
	
	}
	
	// 코인 지갑 수수료 확인하는 api 
	function deposit() {
	
	}

}
?>