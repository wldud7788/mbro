<?php
/**
 * 페이스북 연동 클라이언트
 * 해당 클라이언트 클래스를 통해 페이스북 연동 관련 기능을 제공
 * Client 추상메소드를 재정의 하여 사용
 *
 * @author pjw <pjw@gabiacns.com>
 */

namespace App\Libraries\Social\Facebook;

use App\Libraries\Social\Client;
use App\Libraries\Social\ClientRequestData;
use App\Libraries\Social\Facebook\Sdk\FacebookService;

class FacebookClient extends Client
{
    public function __construct(ClientRequestData $clientRequestData)
    {
        $config = new FacebookConfig($clientRequestData);
        $instance = new FacebookService($config->getAllConfig());
        parent::__construct($config, $instance);
    }

    // 인증 URL 생성
    public function getAuthorizeUrl() {
        $param = ['redirect_uri' => $this->config->getConfig('redirect_uri'),];
        return $this->instance->getLoginUrl($param);
    }

    // 인증 처리
    public function authenticate() {

        // 액세스 토큰 발급
        $accessToken = $this->getAccessToken();

        // 인증 실패
        if (!$accessToken) {
            return $this->errorResult(getAlert('mb091').' :: No AccessToken');
        }

        // 토큰 값이 있으면 회원 정보 가져오기
        $facebookUser = $this->getProfile();

        // 정보를 못가져오는 경우 인증 실패 처리
        if (!$facebookUser) {
            // SDK 에서 관리하는 세션을 초기화 해준다 (accessToken이 이상한 경우에 발생하기 때문)
            $this->clearAllPersistentData();
            return $this->errorResult('인증이 만료되었습니다. 다시 시도해 주시기 바랍니다.');
        }

        // 로그인, 회원가입에 사용할 파라미터 생성
        $facebookMemberData = [
            'userid' => $facebookUser['id'],
            'user_name' => $facebookUser['name'],
            'nickname' => $facebookUser['name'],
            'sns_f' => $facebookUser['id'],
        ];

        // 신규 값을 추가하고 전체 회원 정보를 반환받는다
        $data = $this->config->addMemberData($facebookMemberData);

        // 닉네임 10자 자르기
        if($data['nickname'] && mb_strlen($data['nickname'],'utf-8') > 10) {
            $data['nickname'] = substr($data['nickname'], 0, 10);
        }

        // 세션에 저장할 데이터 생성
        $sessions = [
            'snslogn' => 'facebook',
            'fbuser' => $facebookUser,
            'user_accesstoken' => $accessToken,
        ];

        // 연동 정보를 리턴
        return $this->successResult($data, $sessions);
    }

    // 액세스 토큰 발급
    public function getAccessToken() {
        $tokenResult = $this->instance->getAccessToken();
        return $tokenResult;
    }

    // SDK 에서 관리하는 세션 전체 삭제 처리
    private function clearAllPersistentData() {
        $this->instance->clearAllPersistentData();
    }

    // 유저 번호 가져오기
    public function getUserId() {
        return $this->instance->getUser();
    }

    // 내 프로필 조회
    public function getProfile() {
        return $this->instance->getProfile();
    }

    // SignRequest 생성
    // 레거시용 현재는 사용안하게 처리함
    public function generateSignRequest() {
        $signRequest = $this->instance->getSignedRequest();
		return $signRequest;
    }

    // 계정 정보 조회
    // 레거시용 현재는 사용안하게 처리함
    public function getAccount($uid, $token) {
        $account = $this->instance->api($uid.'/accounts','GET', ['access_token' => $token]);
        return $account;
    }

    // 페이스북에서 사용하는 세션 키 목록
    public function getSessionKeys() {
        return [
            'snslogn',
            'fbuser',
            'user_accesstoken',
        ];
    }
}