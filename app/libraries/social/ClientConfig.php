<?php
/**
 * Client 객체 생성을 위한 ClientConfig 추상클래스 정의
 * 공통으로 처리되는 메소드는 이 클래스에서 정의되어야한다
 *
 * @package    Firstmall
 * @author     JaeUk Park <pjw@gabiacns.com>
 * @copyright  2021 Gabia C&S
 */

namespace App\Libraries\Social;

abstract class ClientConfig {

    const MEMBER = 'member';

    const BUSINESS = 'business';

    const AGREED = 'Y';

    const STATUS_DONE = 'done';

    const STATUS_HOLD = 'hold';

    // 클라이언트별 회원테이블 컬럼 키 목록
    protected $memberColumnKeys;

    // DB 설정값 :: fm_config `snssocial`
    protected $config;

    // DB 설정값 :: fm_config `member`
    protected $memberConfig;

    // 요청 파라미터
    protected $requestParameter;

    // 요청 세션
    protected $requestSession;

    // 회원 테이블 정보
    protected $memberData;

    // SocialManager에서 요청관련데이터를 받아서 가공처리
    public function __construct(ClientRequestData $clientRequestData) {
        $this->memberConfig = $clientRequestData->getMemberConfig();
        $this->requestParameter = $clientRequestData->getRequest();
        $this->requestSession = $clientRequestData->getSession();

        $this->initConfig($clientRequestData->getSocialConfig(), $clientRequestData->getRequest());
        $this->initMemberColumnKeys();
        $this->initMemberDatas($clientRequestData->getSession());
    }

    // Redirect Url 추상 메소드
    public abstract function getRedirectUrl();

    // DB 관련 설정값 초기화 추상 메소드
    public abstract function initConfig($config, $requestParameter);

    // 클라이언트별 fm_member 테이블 대응 컬럼 목록 초기화 추상 메소드
    public abstract function initMemberColumnKeys();

    // 회원 테이블 정보 초기화 메소드
    public function initMemberDatas($requestSession) {
        $this->memberData = [
            'rute' => $this->getRute(),
            'userid' => '',
            'password' => '',
            'user_name' => '',
            'nickname' => '',
            'email' => '',
            'sms' => 'n',
            'birthday' => '',
            'birth_type' => 'none',
            'status' => $this->getInitMemberStatus($requestSession['mtype']),
            'emoney' => 0,
            'login_cnt'	=> 0,
            'order_cn' => 0,
            'order_sum' => 0,
			'sex' => 'none',
			'cellphone' => '',
            'mtype' => $this->getInitMemberType($requestSession['mtype']),
            'regist_date' => date('Y-m-d H:i:s'),
        ];
    }

    // 설정값 전체 조회
    public function getAllConfig() {
        return $this->config;
    }

    // 설정값 조회
    public function getConfig($key) {
        return $this->config[$key];
    }

    // 설정값 수정
    public function setConfig($key, $value = '') {
        $this->config[$key] = $value;
        return $this->config[$key];
    }

    // 회원 정보 전체 조회
    public function getAllMemberDatas() {
        return $this->memberData;
    }

    // 회원 정보 조회
    public function getMemberData($key) {
        return $this->memberData[$key];
    }

    // 회원 정보 수정
    public function setMemberData($key, $value) {
        $this->memberData[$key] = $value;
        return $this->memberData[$key];
    }

    // 회원 정보 추가 배열 형태로 추가한다
    // 기존에 존재하는 키값의 경우 덮어쓰기 한다
    public function addMemberData($datas) {
        if (empty($datas)) return $this->memberData;
        foreach ($datas as $key => $value) {
            $this->setMemberData($key, $value);
        }

        return $this->memberData;
    }

    // 회원가입 시 회원유형
    public function getInitMemberType($mtype) {
        if($mtype === self::MEMBER) {
            return self::MEMBER;
        }

        if($mtype === self::BUSINESS) {
            return self::BUSINESS;
        }

        return self::MEMBER;
    }

     // 회원가입 시 승인 여부
	public function getInitMemberStatus($mtype){
        // 개인회원 자동 승인 여부
        $isMember = $mtype === self::MEMBER;
        $memberApproved = $this->memberConfig['autoApproval'] === self::AGREED;

        // 기업회원 자동 승인 여부
        $isBusiness = $mtype === self::BUSINESS;
        $businessApproved = $this->memberConfig['autoApproval_biz'] === self::AGREED;

        // 자동 승인의 경우
		if (($isMember && $memberApproved) || ($isBusiness && $businessApproved)) {
			return self::STATUS_DONE;
        }

		return self::STATUS_HOLD;
	}

    // 사용 여부
    public function isUse() {
        return $this->config[$this->memberColumnKeys['use_key']];
    }

    // SNS 타입 조회
    public function getRute() {
        return $this->memberColumnKeys['rute'];
    }

    // SNS 프리픽스 조회
    public function getPrefix() {
        return $this->memberColumnKeys['prefix'];
    }

    // SNS 키 변수명 조회
    public function getKey() {
        return $this->memberColumnKeys['key'];
    }

    // SNS 앱 키 변수명 조회
    public function getAppKey() {
        return $this->memberColumnKeys['app_key'];
    }

    // SNS 사용여부 변수명 조회
    public function getUseKey() {
        return $this->memberColumnKeys['use_key'];
    }
}