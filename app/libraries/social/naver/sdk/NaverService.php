<?php

namespace App\Libraries\Social\Naver\Sdk;

class NaverService {

    const API = "https://nid.naver.com/oauth2.0";

    const OPENAPI = "https://openapi.naver.com/v1";

    const AUTHORIZE = "/authorize";

    const ACCESS_TOKEN = "/token";

    const USER_PROFILE = "/nid/me";

    const STATE_KEY = "naver_state";

    private $clientId;

    private $clientSecret;

    private $responseType = 'code';

    private $redirectUri;

    private $state;

    private $code;

    private $error;

    private $accessToken;

    public function __construct($config) {
        $this->clientId = $config['client_id'];
        $this->clientSecret = $config['client_secret'];
        $this->redirectUri = $config['redirect_uri'];

        // get state from session
        $this->getState();
    }

    // 인증 요청 URL 생성
    public function getAuthorizeUrl() {
        $param = [
            'response_type'	=> $this->responseType,
            'client_id'		=> $this->clientId,
            'redirect_uri'	=> $this->redirectUri,
            'state'			=> $this->generateState(),
        ];

        return self::API.self::AUTHORIZE.'?'.http_build_query($param);
    }

    // 액세스 토큰 생성
    public function getAccessToken($code, $state = '') {
        if (!$code) return false;
        if (!$this->verifyState($state)) return false;

        $header	= [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
            'User-Agent: curl'
        ];

        $param = [
            'client_id'		=> $this->clientId,
            'client_secret' => $this->clientSecret,
            'code'			=> $code,
            'grant_type'	=> 'authorization_code',
            'state'         => $state,
            'redirect_url'	=> $this->redirectUri,
        ];

        $result = $this->request(self::API.self::ACCESS_TOKEN, $param, $header);
        return $result;
    }

    // 회원 정보 조회
    public function getUser($access_token) {
        $param = [];
        $header = ['Authorization' => 'Bearer '.$access_token];

        $result = $this->request(self::OPENAPI.self::USER_PROFILE, $param, $header);
        $result = json_decode($result);
        return $result;
    }

    // state 랜덤 변수 생성 (CSRF 공격 대비)
    private function generateState() {
        if (!$this->state) {
            $mt			= microtime();
			$rand		= mt_rand();
			$this->state		= md5( $mt . $rand );
            $_SESSION[self::STATE_KEY] = $this->state;
        }

        return $this->state;
    }

    // state 세션 처리
    private function verifyState($state = '') {
        if ($state === '') return false;
        if ($state === $_SESSION[self::STATE_KEY]) return true;

        return false;
    }

    // state 세션 가져오기
    private function getState() {
        if (!$this->state) {
            $this->state = $_SESSION[self::STATE_KEY];
        }

        return $this->state;
    }

    // API 요청 CURL 함수
    private function request($requestUrl, $data=[], $headers=[]){
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt ($ch, CURLOPT_SSLVERSION,1);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($headers) {
            foreach ($headers as $key => $val) {
                $send_header[] = $key . ':' . $val;
            }
            curl_setopt ($ch, CURLOPT_HTTPHEADER, $send_header);
        }

        if ($data) {
            curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        curl_setopt ($ch, CURLOPT_URL,$requestUrl);
        $result		= curl_exec($ch);
        $httpCode	= curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if(in_array($httpCode, array(200,201))){
            return $result;
        }else{
            $errCode['httpCode']	= $httpCode;
            $errCode['result']		= $result;
            $errCode['info']		= curl_getinfo($ch);

            return $errCode;
        }

        return false;
    }
}