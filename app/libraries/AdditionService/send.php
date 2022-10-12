<?php

namespace App\Libraries\AdditionService;

use GuzzleHttp\Ring\Client\CurlHandler;
use App\Libraries\AdditionService\StringSecurity;

/**
 * 중계서버 통신 클래스
 * GuzzleHttp CURL 통신방식
 * 
 * @package    Firstmall
 * @author     WooSuk Choi <cws@gabiacns.com>
 * @copyright  2022 Gabia C&S
 */

class Send
{
	protected $apiUrl;				// 중계서버 주소
	protected $apiKey;				// 중계서버 통신 시 사용되는 약속된 키
	protected $Type;				// 중계서버 통신 시 사용되는 약속된 값
	protected $authToken;			// 인증토큰
	protected $detailUrl;			// api 상세주소
	protected $guzzleClient;		// GuzzleHttp 객체
	protected $timestamp;			// 현재시각 타임스탬프
	protected $timeout;				// 통신 응답 유효시간 

	protected $serviceType;			// 서비스 타입
	protected $storage;				// 토큰 저장 타입 기본값: session | local: 로컬에 파일로 저장 session: 세션 방식으로 저장
	protected $expireTime;			// 토큰 유효시간(초단위)


	public function __construct(CurlHandler $guzzleClient = null)
	{
		$this->ci = & get_instance();

		$this->guzzleClient = $guzzleClient ?: new CurlHandler();

		$this->timeout	= '10';

		$this->apiKey = '2022.02.01';
		$this->Type = 'api_sns';

		if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
	}

	/**
	 * 중계서버 통신 시 sendMethod 호출
	 */
	public function sendMethod($method, $body=[], $path=[])
	{
		// 우선 accessToken 먼저 실행
		if($this->accessToken == '') {
			$token = $this->accessToken();
			if($token === false) {
				return [
					'success'  => false,
					'httpCode' => 401,
					'msg'      => "유효한 인증 정보가 부족하여 요청이 거부되었습니다. \n퍼스트몰 고객센터로 문의해주세요"
				];
			}
		}

		// 받은 토큰을 header 로 합쳐서 전송
		// API 연동 주소 호출
		$call_info = $this->getUrl($method);

		// uri에 path 치환
		if(!empty($path)) {
			preg_match_all("/\{.*?\}/", $call_info["uri"],$uri_match);
			foreach($uri_match[0] as $match) {
				$key_match = str_replace(array("{","}"), "", $match);
				$call_info["uri"] = str_replace($match,$path[$key_match],$call_info["uri"]);
			}
		}
		$response = $this->send($call_info, $body);

		return $response;
	}

	/**
	 * 실제 중계서버 GuzzleHttp CURL 통신
	 */
	public function send($call_info, $data)
	{
		$handler = $this->guzzleClient;

		$call_url = $call_info['uri'];
		$call_method = $call_info['method'];
		$body_data = $data;

		$auth_required = true;
		if(isset($call_info['auth'])) $auth_required = $call_info['auth'];

		$headers = $this->getHeader($auth_required);
		if(!in_array($call_method, array('post'))) {
			$method = strtoupper($call_method);
		}

		// get 방식일경우 url에 추가
		if ($call_method == 'get'){
			if(!empty($body_data))$call_url = $call_url.'?'.http_build_query($body_data);
			unset($body_data);
		}

		if (isset($body_data)) {
			$body_data = json_encode($body_data);
		}

		$response = $handler([
			'uri' => $call_url,
			'http_method' => $method,
			'scheme' => 'https',
			'body' => $body_data,
			'headers' => $headers,
			'client' => [
				'timeout' => $this->timeout
			],
		]);

		$read_data = $response->then(function (array $response) {
			$result['httpCode'] = $response['status'];
			$result['body'] = stream_get_contents($response['body']);

			return $result;
		});
		
		$result = array_values((array)$read_data);
		writeCsLog($result, "api" , "service");

		return $result[0];
	}

	/**
	 * header 생성
	 */
	protected function getHeader($auth_required){
		$header['host'] = [$this->apiUrl];
		$header['Content-Type'] = ['appilcation/json'];	
		$header['x-access-shop-Session'] = [session_id()];

		if($auth_required) {
			$header['x-access-apisns-token'] = [$this->authToken];
		} else {
			$scretkey = StringSecurity::SecurityEncode($this->apiKey . $this->Type . $this->timestamp, $this->apiKey);
			$header['x-access-shop-Secret'] = [$scretkey];
			$header['x-access-shop-Timestamp'] = [$this->timestamp];
		}

		$debug['apikey'] = $this->apiKey;
		$debug['type'] = $this->Type;
		$debug['time'] = $this->timestamp;
		$debug['header'] = $header;
		writeCsLog($debug, "api" , "service");
		
		return $header;
	}

	/**
	 * url path GET
	 */
	protected function getUrl($apiType){
		if (!$apiType) return false;

		if ($this->detailUrl[$apiType]){
			return $this->detailUrl[$apiType];
		}else{
			$this->getUrl($apiType);
		}
	}

	/**
	 * sendMethod 호출 시 기본으로 accessToken 실행하여 토큰 리턴
	 */
	protected function accessToken()
	{
		$token = $this->selectToken();

		// token 요청 후 파일 굽기
		if($token == "") {
			$call_info = $this->getUrl('accessToken');
			$call_info['auth'] = false;
			$this->timestamp = time();

	
			$data = array();
			$result = $this->send($call_info, $data);
			$body = json_decode($result['body']);

			if($result['httpCode'] != 200 && $body->success != true ) {
				return false;
			} else {
				$token = $body->token;
			}

			$this->updateToken($token);
		}

		if(empty($token)) {
			return false;
		}

		$this->authToken = $token;
		return true;
	}

	/**
	 * 토큰 저장
	 * 로컬 스토리지와 세션 스토리지 방식
	 */
	protected function updateToken($token)
	{
		// 로컬 스토리지
		if ($this->storage === 'local') {
			$filePath = ROOTPATH.'data/'.$this->serviceType.'_token.txt';
			$fp = fopen($filePath, 'w');
			fwrite($fp, $token);
			fclose($fp);
		} else {
		// 세션 스토리지
			$this->ci->session->sess_expiration = $this->expireTime;
			$this->ci->session->set_userdata($this->serviceType . '_token', $token);
		}
		
	}

	/**
	 * 토큰 가져오기
	 */
	protected function selectToken()
	{
		// 로컬 스토리지
		if ($this->storage === 'local') {
			$filePath = ROOTPATH.'data/'.$this->serviceType.'_token.txt';
			$fileContents = '';
			if(file_exists($filePath)) {

				$handle	= fopen($filePath, "r");
				$fileContents = fread($handle, filesize($filePath));
				fclose($handle);

				if( $fileContents != '' ){
					$ftime = (time() - filemtime($filePath));
					if( $ftime >= $this->expireTime ){
						$fileContents = '';
					}
				}
			}
			$token = $fileContents;
		} else {
		// 세션 스토리지
			$token = $this->ci->session->userdata($this->serviceType . '_token');
		}

		return $token;
	}
}
