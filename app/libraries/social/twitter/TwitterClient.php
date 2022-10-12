<?php
/**
 * 트위터 연동 클라이언트
 * 해당 클라이언트 클래스를 통해 트위터 연동 관련 기능을 제공
 * Client 추상메소드를 재정의 하여 사용
 *
 * @author pjw <pjw@gabiacns.com>
 */

namespace App\Libraries\Social\Twitter;


use App\Libraries\Social\Client;
use App\Libraries\Social\ClientRequestData;
use App\Libraries\Social\Twitter\Sdk\TwitterService;

class TwitterClient extends Client
{
    public function __construct(ClientRequestData $clientRequestData)
    {
        $config = new TwitterConfig($clientRequestData);
        $instance = $this->initService($config);

        parent::__construct($config, $instance);
    }

    // 트위터 SDK 객체 생성
    private function initService($config) {
        $consumer_key = $config->getConfig('consumer_key');
        $consumer_secret = $config->getConfig('consumer_secret');
        $oauth_token = $config->getConfig('oauth_token');
        $oauth_token_secret = $config->getConfig('oauth_token_secret');
        $instance = new TwitterService($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

        // 객체 생성 후에 세션 파기
        unset($_SESSION['oauth_token']);
        unset($_SESSION['oauth_token_secret']);

        return $instance;
    }

    // 인증 URL 생성
    public function getAuthorizeUrl() {
        $redirectUrl = $this->config->getRedirectUrl();
        $requestToken = $this->instance->getRequestToken($redirectUrl);

        $authorizeUrl = '';
        if ($requestToken['oauth_token']) {
            $authorizeUrl = $this->instance->getAuthorizeURL($requestToken['oauth_token']);

            // request 토큰 세션 저장
            $_SESSION['oauth_token'] = $requestToken['oauth_token'];
            $_SESSION['oauth_token_secret'] = $requestToken['oauth_token_secret'];
        }

        return $authorizeUrl;
    }

    // 인증 처리
    public function authenticate() {
        // 액세스 토큰 발급
        $accessToken = $this->getAccessToken();

        // 토큰이 없는 경우
        if (!$accessToken) {
            return [
                'result' => false,
                'msg' => getAlert('mb091'),
            ];
        }

        // 로그인, 회원가입에 사용할 파라미터 생성
        $twitterMemberData = [
            'user_name' => $accessToken['screen_name'],
            'userid' => $accessToken['screen_name'],
            'sns_t' => $accessToken['user_id'],
        ];

        // 신규 값을 추가하고 전체 회원 정보를 반환받는다
        $data = $this->config->addMemberData($twitterMemberData);

        // 아이디가 이메일로 넘어온 경우 이메일 설정
		if (strstr($accessToken['user_id'], "@")) {
			$data['authemail'] = true;
			$data['email'] = $accessToken['user_id'];
		}

        // 세션에 저장할 데이터 생성
        $sessions = [
            'snslogn' => 'twitter',
        ];

        // 연동 정보를 리턴
        return [
            'result' => true,
            'data' => $data,
            'sessions' => $sessions,
        ];
    }

    // 액세스 토큰 발급
    public function getAccessToken() {
        if (!$this->config->getConfig('oauth_verifier')) {
            return [
                'result' => false,
                'msg' => '인증값이 없습니다.',
            ];
        }

        $tokenResult = $this->instance->getAccessToken($this->config->getConfig('oauth_verifier'));
        return $tokenResult;
    }

    // 트위터에서 사용하는 세션 키 목록
    public function getSessionKeys() {
        return [
            'snslogn',
            'oauth_token',
            'oauth_token_secret',
        ];
    }
}