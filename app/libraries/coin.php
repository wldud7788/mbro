<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coin 
{
	function __construct() {
		
	}
	
	// ���� ���� ���� �������� api 
	function value() {
		/*

		// �����ʿ� 
		// api ȣ�� 
		$url = 'http://13.124.142.177:8083/v1/trade/getTokenPrice';
		$headers = array( "content-type: application/json", "accept-encoding: gzip","charset=UTF-8" );

		$check['systemId'] = 'web2';
		$check['requestTime'] = '20200112105117123';
		$check['trxId'] = '2f44f241-9d64-4d16-bf56-70b9d4e0e79a';
		$check['coinId'] = 'BMP';
		$check['currency'] = 'KRW';

		// json ���� ���� ���� 
		$postData = json_encode($check);

		// curl ���� 
		$ch=curl_init(); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_URL, $url); //header�� ����(������ �����ص� ������)
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //POST��� 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
		curl_setopt($ch, CURLOPT_POST, true); //POST������� �ѱ� ������(JSON������) 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 3); // ���ۿ� 3�ʰ� ������ Ÿ�Ӿƿ�
		$response = curl_exec($ch);
		$response = json_decode($response, TRUE);
		*/
	
	}
	
	// ���� ���� ������ Ȯ���ϴ� api 
	function deposit() {
	
	}

}
?>