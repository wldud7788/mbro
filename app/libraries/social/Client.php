<?php
/**
 * SNS 연동 서비스에 사용되는 Client 추상클래스 정의
 * 추후 공통 기능이 추가되는 경우 이 클래스에 정의
 *
 * @package    Firstmall
 * @author     JaeUk Park <pjw@gabiacns.com>
 * @copyright  2021 Gabia C&S
 */

namespace App\Libraries\Social;

abstract class Client {

    // ClientConfig 객체
    protected $config;

    // SDK 객체
    protected $instance;

    // 자식 클래스에서 각 인스턴스를 받아 전역변수에 설정
    public function __construct(ClientConfig $configInstance, $sdkInstance)
    {
        $this->config = $configInstance;
        $this->instance = $sdkInstance;
    }

    // 인증 요청 URL 생성 추상메소드
    abstract function getAuthorizeUrl();

    // 인증 처리 추상메소드
    abstract function authenticate();

    // 액세스 토큰 생성 추상메소드
    abstract function getAccessToken();

    // 사용여부 확인
    public function isUse() {
        return $this->config->isUse();
    }

    // 설정값 조회
    public function getConfig($key) {
        return $this->config->getConfig($key);
    }

    // 현재 SNS 타입값 조회
    public function getKey() {
        return $this->config->getKey();
    }

    // 현재 SNS 앱 키 조회
    public function getAppKey() {
        return $this->config->getAppKey();
    }

    // 현재 SNS Prefix 값 조회
    public function getPrefix() {
        return $this->config->getPrefix();
    }

    // Redirect Url 조회
    public function getRedirectUrl() {
        return $this->config->getRedirectUrl();
    }

    // 성공 리턴
    public function successResult($data = [], $sessions = []) {
        return [
            'result' => true,
            'data' => $data,
            'sessions' => $sessions,
        ];
    }

    // 실패 리턴
    public function errorResult($msg, $redirectUrl = '/') {
        return [
            'result' => false,
            'msg' => $msg,
            'redirectUrl' => $redirectUrl,
        ];
    }
}