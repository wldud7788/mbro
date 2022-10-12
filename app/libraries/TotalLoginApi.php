<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TotalLoginApi {
	function total_login_gettoken($client_id, $client_secret, $code) { 
		// GET
		// 2. 토큰 얻는 curl 실행 (GET)
		$server = 'https://mubro.friendsapp.chat/';
		$subUrl = 'oauth2/token';
		$content = '?client_id='.$client_id.'&client_secret='.$client_secret.'&code='.$code;
	
		$url = $server.$subUrl.$content;
		
		$headers = array("content-type: application/json", "accept-encoding: gzip", "charset=UTF-8");

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_URL,$url); // url 셋팅 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // 헤더 셋팅 
		$response = curl_exec($ch);
		$response = json_decode($response, TRUE);

		return $response;
	} 

	function total_login_userdata($token) { 
		// GET
		$server = 'https://mubro.friendsapp.chat/';
		$subUrl = 'oauth2/me'; 
		$content = '?token='.$token;

		$url = $server.$subUrl.$content;

		$headers = array("content-type: application/json", 
						 "accept-encoding: gzip",
						 "charset=UTF-8"
						 );

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_ENCODING, '');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);
		$response = json_decode($response, TRUE);

		curl_close($ch);

		return $response;
	} 
}

?>