<?php
/**
 * ClientConfig 클래스에서 사용되는 데이터 설정 값 클래스
 * SocialManager에서 DB, Request, 세션 데이터를 이 클래스에 세팅하여 SNS 클라이언트 생성 시에 넘겨준다
 * 생성자에서 멤버변수 값을 세팅하며 get 메소드를 통해서 조회만 가능하게 제작됨
 * 
 * @package    Firstmall
 * @author     JaeUk Park <pjw@gabiacns.com>
 * @copyright  2021 Gabia C&S
 */
namespace App\Libraries\Social;

class ClientRequestData {

    private $socialConfig;

    private $memberConfig;

    private $request;

    private $session;

    public function __construct($socialConfig, $memberConfig, $request, $session) {
        $this->socialConfig = $socialConfig;
        $this->memberConfig = $memberConfig;
        $this->request = $request;
        $this->session = $session;
    }

    public function getSocialConfig() {
        return $this->socialConfig;
    }

    public function getMemberConfig() {
        return $this->memberConfig;
    }

    public function getRequest() {
        return $this->request;
    }

    public function getSession() {
        return $this->session;
    }

}