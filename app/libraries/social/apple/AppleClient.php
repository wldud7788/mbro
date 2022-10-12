<?php
/**
 * 애플 연동 클라이언트
 * 해당 클라이언트 클래스를 통해 애플 연동 관련 기능을 제공
 * Client 추상메소드를 재정의 하여 사용
 *
 * @author pjw <pjw@gabiacns.com>
 */

namespace App\Libraries\Social\Apple;

use App\Libraries\Social\Client;
use App\Libraries\Social\ClientRequestData;
use App\Libraries\Social\Apple\Sdk\AppleService;

class AppleClient extends Client
{
    public function __construct(ClientRequestData $clientRequestData)
    {
        $config = new AppleConfig($clientRequestData);
        $instance = new AppleService($config->getAllConfig());
        parent::__construct($config, $instance);
    }

    // 인증 URL 생성
    public function getAuthorizeUrl() {
        return $this->instance->getAuthorizeUrl();
    }

    // 인증 처리
    public function authenticate() {
        // 액세스 토큰 발급
        $accessToken = $this->getAccessToken();

        // Code 값이 없는 경우
        if (!$accessToken['result']) {
            return $accessToken;
        }

        // 토큰 정보 파싱
        $decodeResult = json_decode($accessToken, true);

        // 인증 실패
        if ($decodeResult['error'] || !$decodeResult['access_token']) {
            return [
                'result' => false,
                'msg' => '인증에 실패하였습니다. 설정값을 확인해 주세요. '.$decodeResult['error'],
            ];
        }

        // 토큰 데이터
        $appleAccessToken = $decodeResult['access_token'];
        $appleRefreshToken = $decodeResult['refresh_token'];
        $appleIdToken = explode('.', $decodeResult['id_token']);
        // $applePublicKey = json_decode(base64_decode($appleIdToken[0]), true);
        $appleAuthinfo = json_decode(base64_decode($appleIdToken[1]), true);
        $appleUser = json_decode($this->config->getConfig('user'), true);

        // 로그인, 회원가입에 사용할 파라미터 생성
        $appleMemberData = [
            'accessToken' => $appleAccessToken,
            'refreshToken' => $appleRefreshToken,
            'name' => $appleUser['name']['firstName'].$appleUser['name']['middleName'].$appleUser['name']['lastName'],
            'nickname' => $appleUser['name']['firstName'].$appleUser['name']['middleName'].$appleUser['name']['lastName'],
            'email' => $appleAuthinfo['email'],
            'userid' => $appleAuthinfo['sub'],
            'sns_a' => $appleAuthinfo['sub'],
        ];

        // 신규 값을 추가하고 전체 회원 정보를 반환받는다
        $data = $this->config->addMemberData($appleMemberData);

        // 세션에 저장할 데이터 생성
        $sessions = [
            'snslogn' => 'apple',
            'apple_access_token' => $appleAccessToken,
            'apple_refresh_token' => $appleRefreshToken,
            'apple_name' => $appleUser['name']['firstName'].$appleUser['name']['middleName'].$appleUser['name']['lastName'],
            'apple_email' => $appleAuthinfo['email'],
            'apple_userid' => $appleAuthinfo['sub']
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
        if (!$this->config->getConfig('code')) {
            return [
                'result' => false,
                'msg' => 'code 값이 없습니다.',
                'redirectUrl' => '/',
            ];
        }

        $tokenResult = $this->instance->getAccessToken($this->config->getConfig('code'), $this->config->getConfig('state'));
        return $tokenResult;
    }

    // 애플에서 사용하는 세션 키 목록
    public function getSessionKeys() {
        return [
            'snslogn',
            'apple_state',
            'apple_access_token',
            'apple_refresh_token',
            'apple_name',
            'apple_email',
            'apple_userid',
        ];
    }
}