<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 라이브 커머스 스트림 서버 통신
 * @author Hyemi Ryu
 * 2020-10-27
 */
class stream
{
	protected $ci;
	protected $apiUrl;
	protected $detailUrl;
	protected $timeout;
	protected $authToken;


	public function __construct()
	{
		$this->ci		=& get_instance();
		$this->ci->load->helper('readurl');
		$this->timeout	= '10';

		if(!$this->api_url){
			$this->setApi();
		}
	}

	/*
	* vod 서버 통신 시 sendMethod 호출
	*/
	public function sendMethod($method,$body=array(),$path=array()){
		// 우선 authLogin 먼저 실행
		if($this->authToken == '') {
			$token = $this->authLogin();
			if($token === false) {
				// vod 로그인이 되지 않음 / broadcast_cfg(username,password 확인 필요)
				return array('msg'=>'현재 스트리밍 서버를 이용할 수 없습니다.\r\n퍼스트몰 고객센터로 문의해주세요.[stream401]');
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

		return (array)$response;
	}

	/**
	 * 실제 vod 서버 curl 통신
	 */
	public function send($call_info, $data) {
		$call_url = $call_info['uri'];
		$call_method = $call_info['method'];
		$body_data = $data;

		$auth_required = true;
		if(isset($call_info['auth'])) $auth_required = $call_info['auth'];

		$headers	= $this->getHeader($auth_required);			// Header
		if(!in_array($call_method, array('post','get'))) {
			$method = $call_method;
		}

		// get 방식일경우 url에 추가
		if ($call_method == 'get' && !empty($body_data)) {
			$call_url = $call_url.'?'.http_build_query($body_data);
			unset($body_data);
		}

		$read_data	= readurl($this->apiUrl.$call_url,$body_data,false,$this->timeout,$headers,true,true,$method);

		// 200/201 외
		if(is_array($read_data)) {
			$response['httpCode'] = $read_data['httpCode'];
			$response['msg'] = json_decode($read_data['result'])->message;
		} else {
			$response	= json_decode($read_data);
		}

		$debug['url'] = $this->apiUrl.$call_url;
		$debug['body'] = $body_data;
		$debug['method'] = $method;
		$debug['call_method'] = $call_method;
		$debug['headers'] = $headers;
		$debug['response'] = $response;

		writeCsLog($debug, "api" , "vod", "hour");

		return $response;
	}

	/**
	 * header 생성 (auth 외에는 헤더에 Authorization 포함)
	 */
	protected function getHeader($auth_required){
		if($auth_required) {
			$header['Authorization']			= "Bearer " .$this->authToken;
		}

		return $header;
	}

	/**
	 * url path GET
	 */
	protected function getUrl($apiType){
		if	(!$apiType) return false;

		if	($this->detailUrl[$apiType]){
			return $this->detailUrl[$apiType];
		}else{
			$this->setApi();
			$this->getUrl($apiType);
		}
	}

	/**
	 * url path SET
	 */
	protected function setApi() {
		// config 값에서 서버정보 가져옴
		$this->ci->load->config('broadcast');
		$broadcastConfig = $this->ci->config->item('broadcast');

		$this->apiUrl	= $broadcastConfig['vodApiUrl'];
		$this->detailUrl = array(
			'authLogin'	=> array( 'method'=>'post', 'uri' =>'auth/login'), //토큰 발급
			'addBroadcast' => array( 'method'=>'post', 'uri' =>'broadcast'), // 방송 등록
			'modifyChannelStatus' => array( 'method'=>'put', 'uri' =>'broadcast/channel/{channel}/{status}'), // 방송 채널 상태 변경
			'getBroadcast' => array( 'method'=>'get', 'uri' =>'broadcast/channel/{channel}'), // 방송 채널 정보
			'channelLikes' => array( 'method'=>'post', 'uri' =>'broadcast/channel/{channel}/like'), // 좋아요 터치!
			'sendChat' => array( 'method'=>'post', 'uri' =>'broadcast/channel/{channel}/chat'), // 채팅 공지 전송
			'getVodChat' => array( 'method'=>'get', 'uri' =>'broadcast/channel/{channel}/chat'), // vod 채팅 가져오기
			'deleteVod' => array( 'method'=>'delete', 'uri' =>'broadcast/channel/{channel}'), // vod 삭제
			'getUserInfo' => array( 'method'=>'get', 'uri' =>'auth/me'), // 남은 건수 리턴
		);
	}

	/**
	 * sendMethod 호출 시 기본으로 authLogin 실행하여 토큰 리턴
	 */
	protected function authLogin() {


		// 파일 읽어서 50분 넘으면 token 다시 요청하기
		$token = $this->select_token();
		// token 요청 후 파일 굽기
		if($token == "") {
			$call_info = $this->getUrl('authLogin');
			$call_info['auth'] = false;
			$cfg_broadcast = config_load('broadcast');

			$data = array();
			$data['username'] = $cfg_broadcast['username'];
			$data['password'] = $cfg_broadcast['password'];

			$result = $this->send($call_info, $data);

			$this->update_token($result->token);
			$token = $result->token;
		}

		if(empty($token)) {
			return false;
		}

		$this->authToken = $token;
		return true;
	}

	/* 출고 중복실행방지 상태 업데이트 */
	function update_token($str)
	{
		$filePath = ROOTPATH.'data/broadcast_token.txt';
		$fp = fopen($filePath, 'w');
		fwrite($fp, $str);
		fclose($fp);
	}

	function select_token(){
		$filePath = ROOTPATH.'data/broadcast_token.txt';
		$fileContents = '';
		if(file_exists($filePath)) {

			$handle	= fopen($filePath, "r");
			$fileContents = fread($handle, filesize($filePath));
			fclose($handle);

			if( $fileContents != '' ){
				$ftime = (time() - filemtime($filePath)) / 60;
				if( $ftime >= 50 ){
					$fileContents = '';
				}
			}
		}
		return $fileContents;
	}
}