<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
require_once(APPPATH ."controllers/sns_process_legacy".EXT);

use App\Libraries\SocialManager;
use App\Libraries\Social\Apple\AppleClient;
use App\Libraries\Social\Naver\NaverClient;
use App\Libraries\Social\Facebook\FacebookClient;
use App\Libraries\Social\Twitter\TwitterClient;
use App\Libraries\Social\Kakao\KakaoClient;


class sns_process extends front_base {

	use sns_process_legacy;

	public function __construct() {
		parent::__construct();
		$this->load->library('validation');
		$this->load->library('snssocial');
		$this->load->library('memberlibrary');

		$this->load->model('membermodel');
		$this->config_email = config_load('email');
		$this->app_member	= config_load('member');
		$this->joinform		= config_load('joinform');

		$this->load->model('appmembermodel');
	}

	// 네이버 인증 콜백 (레거시)
	public function naveruserck() {
		if ($this->isSupportSocialScript()) {
			$this->naver_callback();
		} else {
			$this->naveruserck_legacy();
		}
	}

	// * 추후 네이버 인증 콜백 주소 변경이 가능한 시점에 아래 함수를 메인으로 사용 *
	public function naver_callback() {
		try {
			$socialManager = new SocialManager(NaverClient::class, $this->input->get());
			$authResult = $socialManager->authenticate();

			pageRedirect($authResult['redirectUrl'], $authResult['msg']);
		} catch (Exception $e) {
			pageRedirect('/', $e->getMessage());
		}
	}

	// 카카오 인증 콜백
	public function kakao_callback() {
		try {
			$this->socialManager = new SocialManager(KakaoClient::class, $this->input->get());
			$authResult = $this->socialManager->authenticate();

			pageRedirect($authResult['redirectUrl'], $authResult['msg']);
		} catch (Exception $e) {
			pageRedirect('/', $e->getMessage());
		}
	}

	// 페이스북 인증 콜백
	public function facebook_callback() {
		try {
			$socialManager = new SocialManager(FacebookClient::class, $this->input->get());
			$authResult = $socialManager->authenticate();

			pageRedirect($authResult['redirectUrl'], $authResult['msg']);
		} catch (Exception $e) {
			pageRedirect('/', $e->getMessage());
		}
	}

	// 트위터 회원가입 처리 (레거시)
	public function twitterjoin() {
		if ($this->isSupportSocialScript()) {
			$this->twitter_callback();
		} else {
			$this->twitterjoin_legacy();
		}
	}

	// 트위터 로그인 처리 (레거시)
	public function twitterlogin() {
		if ($this->isSupportSocialScript()) {
			$this->twitter_callback();
		} else {
			$this->twitterlogin_legacy();
		}
	}

	// 트위터 인증 콜백
	// * 추후 트위터 인증 콜백 주소 변경이 가능한 시점에 아래 함수를 메인으로 사용 *
	public function twitter_callback() {
		try {
			$socialManager = new SocialManager(TwitterClient::class, $this->input->get());
			$authResult = $socialManager->authenticate();

			pageRedirect($authResult['redirectUrl'], $authResult['msg']);
		} catch (Exception $e) {
			pageRedirect('/', $e->getMessage());
		}
	}

	// 애플 인증 콜백 (레거시)
	public function applecertificate(){
		if ($this->isSupportSocialScript()) {
			$this->apple_callback();
		} else {
			$this->applecertificate_legacy();
		}

	}

	// * 추후 애플 인증 콜백 주소 변경이 가능한 시점에 아래 함수를 메인으로 사용 *
	public function apple_callback(){
		try {
			$socialManager = new SocialManager(AppleClient::class, $this->input->post());
			$authResult = $socialManager->authenticate();

			pageRedirect($authResult['redirectUrl'], $authResult['msg']);
		} catch (Exception $e) {
			pageRedirect('/', $e->getMessage());
		}
	}

	// skin-snslogin.js 를 사용 중인지 여부 검사
	private function isSupportSocialScript() {
		// 아래 세션값이 없는 경우 SNS 연동을 기존 레거시 함수로 수행한다
		$isLegacy = $this->session->userdata('isLegacy');

		return $isLegacy === 'N';
	}
}

/* End of file sns_process.php */
/* Location: ./app/controllers/sns_process.php */