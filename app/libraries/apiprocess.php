<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class apiprocess {
		function join($name, $email, $password) { 
		// POST 방식 
			$server = 'https://apiv2.music-brother.com';
			$subUrl = '/user/users';
			$headers = array( "content-type: application/json", "accept-encoding: gzip","charset=UTF-8" );
			
			$appMember['name'] = $name;
			$appMember['email'] = $email;
			$appMember['password'] = $password;
			
			// json 으로 보낼 형식 
			$postData = json_encode($appMember);
			
			// curl 실행 
			$ch=curl_init(); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_URL, $server.$subUrl);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //POST방식 
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
			curl_setopt($ch, CURLOPT_POST, true); //POST방식으로 넘길 데이터(JSON데이터) 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 3); // 전송에 3초가 지나면 타임아웃
			$response = curl_exec($ch);
			$response = json_decode($response, TRUE);
	
			return $response;
		} 

		function auth($userid,$pwd) {
			// POST방식
            $url = "https://apiv2.music-brother.com/";
            $headers = array( "content-type: application/json", "accept-encoding: gzip","charset=UTF-8" );

            $data2['email'] = $userid;
            $data2['password'] = $pwd;

            $tokenGetData = json_encode($data2);

            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch1, CURLOPT_URL, $url.'user/login');
            curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch1, CURLOPT_POST, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $tokenGetData);

            $token = curl_exec($ch1);
            $token = json_decode($token, TRUE);

            return $token;
		}

		function login($token) {
			// GET 방식 
			$server = 'https://apiv2.music-brother.com/';
			$subUrl = 'user/me';
			$headers = array( "Authorization: ".$token );

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_URL,$server.$subUrl);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //POST방식 
			$response = curl_exec($ch);
			$response = json_decode($response, TRUE);

			return $response;
		}
		
		function ticket($userid) { 
			// PUT 방식 
			$server = 'https://mubro.friendsapp.chat';
			$subUrl = '/admin/users/';
			$headers = array( "content-type: application/json", 
								 "accept-encoding: gzip",
								 "charset=UTF-8",
								 "Authorization:Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhZG1pbiI6dHJ1ZSwiaWF0IjoxNjA3Njk0MTQ2fQ.dVNeFfzYn84wGgtQFhnwnZxJQ0mepV-1vGrujl8Aq5Y"
								);
			$url = $server.$subUrl.$userid;

			$timestamp = strtotime("+1 months");
			$isoDate = date("Y-m-d H:i:s", $timestamp).'Z';

			// 배열에 변수 저장
			$appMember['ticketExpiredAt'] = $isoDate;
			
			// json 으로 보낼 형식 
			$data = json_encode($appMember);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // 헤더추가
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // 보내는 방식은 PUT
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
			$response = curl_exec($ch);
			$response = json_decode($response, TRUE);
			
			 
			//var_dump($response);
			return $response;
		}
		
		function password($userid,$email,$new) {
			// PUT 방식 
			$server = 'https://mubro.friendsapp.chat';
			$subUrl = '/admin/users/';
			$headers = array( "content-type: application/json", 
								 "accept-encoding: gzip",
								 "charset=UTF-8",
								 "Authorization:Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhZG1pbiI6dHJ1ZSwiaWF0IjoxNjA3Njk0MTQ2fQ.dVNeFfzYn84wGgtQFhnwnZxJQ0mepV-1vGrujl8Aq5Y"
								);
			$url = $server.$subUrl.$userid;
			$appMember['email'] = $email;
			$appMember['password'] = $new;
			
			// json 으로 보낼 형식 
			$data = json_encode($appMember);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // 헤더추가
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // 보내는 방식은 PUT
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
			$response = curl_exec($ch);
			$response = json_decode($response, TRUE);

			//var_dump($response);
			return $response;

		}

		function coin_rate() {
			// 코인 실시간 금액 조회 
			$server = 'http://13.124.142.177:8083/v1/';
			$subUrl = 'trade/getTokenPrice';
			$headers = array( "content_type: application/json", 
								 "accept-encoding: gzip",
								 "charset=UTF-8"
								);

			$url = $server.$subUrl;
			
			$search['systemId'] = 'MUBROSHOP';
			$search['requestTime'] = '20200112105117123';
			$search['trxId'] = '2f44f241-9d64-4d16-bf56-70b9d4e0e79a';
			$search['coinId'] = 'BMP';
			$search['currency'] = 'KRW';

			$data = json_encode($search);

			$ch=curl_init(); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // 헤더추가
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POST, true); //POST방식으로 넘길 데이터(JSON데이터) 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 3); // 전송에 1초가 지나면 타임아웃
			
			$response = curl_exec($ch);
			$response = json_decode($response, TRUE);
		
			return $response;
		}

		function coin_wallet() {
			// 지갑 수수료 현황 조회
			$server = 'http://13.124.142.177:8083/v1/';
			$subUrl = 'trade/getFeeWalletBalance';
			$headers = array(
				"content-type: application/json", 
				 "charset=UTF-8"
			);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_URL,$server.$subUrl);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // 헤더 설정
			curl_setopt($ch, CURLOPT_TIMEOUT, 2); // 전송에 2초가 지나면 타임아웃
			$response = curl_exec($ch);
			$response = json_decode($response, TRUE);

			return $response;
		}

		function coin_list($userid,$hash,$amount) {
			// 코인 내역 N건 조회  
			$server = 'https://api.shopcoin.musicbrotherss.com/payments?user='.$userid.'&secret='.$hash.'&skip=0&limit='.$amount;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_URL, $server);
			$result = curl_exec($ch);
			curl_close($ch);
			$result = json_decode($result, TRUE);

			return $result;
		}

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