<?php

namespace App\Libraries\Social\Apple\Sdk;

class AppleService {

    const API = "https://appleid.apple.com";

    const AUTHORIZE = "/auth/authorize";

    const ACCESS_TOKEN = "/auth/token";

    const STATE_KEY = "apple_state";

    private $kid;

    private $iss;

    private $sub;

    private $privateKey;

    private $responseType = 'code id_token';

    private $responseMode = 'form_post';

    private $redirectUri;

    private $state;

    private $scope = 'name email';

    private $data = 'applelogin';

    private $code;

    private $idToken;

    private $error;

    private $user;

    private $accessToken;

    public function __construct($config) {
        $this->kid = $config['kid'];
        $this->iss = $config['iss'];
        $this->sub = $config['sub'];
        $this->privateKey = $config['privateKey'];
        $this->redirectUri = $config['redirect_uri'];

        // get state from session
        $this->getState();
    }

    // 인증 요청 URL 생성
    public function getAuthorizeUrl() {
        $param = [
            'response_type'	=> $this->responseType,
            'response_mode'	=> $this->responseMode,
            'client_id'		=> $this->sub,
            'redirect_uri'	=> $this->redirectUri,
            'state'			=> $this->generateState(),
            'scope'			=> $this->scope,
            'data'			=> $this->data,
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
            'client_id'		=> $this->sub,
            'client_secret' => $this->generateSecretkey($this->kid, $this->iss, $this->sub, $this->privateKey),
            'code'			=> $code,
            'grant_type'	=> 'authorization_code',
            'redirect_url'	=> $this->redirectUri,
        ];

        $result = $this->request(self::API.self::ACCESS_TOKEN, $param, $header);
        return $result;
    }

    // state 랜덤 변수 생성 (CSRF 공격 대비)
    private function generateState() {
        if (!$this->state) {
            $this->state = bin2hex($this->getRandom(5));
            $_SESSION[self::STATE_KEY] = $this->state;
        }

        return $this->state;
    }

    // state 세션 처리
    private function verifyState($state = '') {
        if ($state === '') return false;
        if ($state == $_SESSION[self::STATE_KEY]) return true;

        return false;
    }

    // state 세션 가져오기
    private function getState() {
        if (!$this->state) {
            $this->state = $_SESSION[self::STATE_KEY];
        }

        return $this->state;
    }

    // 애플 시크릿 키 생성
    private function generateSecretkey($kid, $iss, $sub, $key) {

        // 사인키 생성
        $header = [
            'alg' => "ES256",
            'kid' => $kid
        ];

        $body = [
            'iss' => $iss,
            'iat' => time(),
            'exp' => time() + 3600,
            'aud' => self::API,
            'sub' => $sub
        ];

        $privKey = openssl_pkey_get_private($key);
        if (!$privKey) {
            echo 'pkey error';
            exit;
        }

        $payload	= $this->encodeJWT(json_encode($header)).'.'.$this->encodeJWT(json_encode($body));
        $signature	= '';
        $success	= openssl_sign($payload, $signature, $privKey, OPENSSL_ALGO_SHA256);

        if (!$success){
            echo 'sign error';
            exit;
        }

        $raw_signature = $this->encodeDER($signature, 64);
        $client_secret = $payload.'.'.$this->encodeJWT($raw_signature);

        return $client_secret;
    }

    // JWT 인코딩 함수
    private function encodeJWT($data) {
        $encoded = strtr(base64_encode($data), '+/', '-_');
        return rtrim($encoded, '=');
    }

    // DER 인코딩 함수
    private function encodeDER($der, $partLength) {
        $hex = unpack('H*', $der);
        $hex = $hex[1];
        if ('30' !== mb_substr($hex, 0, 2, '8bit')) return '';

        if ('81' === mb_substr($hex, 2, 2, '8bit')) $hex = mb_substr($hex, 6, null, '8bit');
        else										$hex = mb_substr($hex, 4, null, '8bit');

        if ('02' !== mb_substr($hex, 0, 2, '8bit'))	return '';

        $Rl		= hexdec(mb_substr($hex, 2, 2, '8bit'));
        $R		= $this->retrievePositiveInteger(mb_substr($hex, 4, $Rl * 2, '8bit'));
        $R		= str_pad($R, $partLength, '0', STR_PAD_LEFT);
        $hex	= mb_substr($hex, 4 + $Rl * 2, null, '8bit');

        if ('02' !== mb_substr($hex, 0, 2, '8bit')) return '';

        $Sl		= hexdec(mb_substr($hex, 2, 2, '8bit'));
        $S		= $this->retrievePositiveInteger(mb_substr($hex, 4, $Sl * 2, '8bit'));
        $S		= str_pad($S, $partLength, '0', STR_PAD_LEFT);

        return pack('H*', $R.$S);
    }

    // int 코드 인코딩
    private function retrievePositiveInteger($data) {
        while ('00' === mb_substr($data, 0, 2, '8bit') && mb_substr($data, 2, 2, '8bit') > '7f') {
            $data = mb_substr($data, 2, null, '8bit');
        }
        return $data;
    }

    // 랜덤 문자열 생성
    private function getRandom($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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