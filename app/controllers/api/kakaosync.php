<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "controllers/base/api_base" . EXT);

use App\Libraries\AdditionService\kakaosync\KakaosyncSetting;

/**
 * 카카오싱크 관련 API
 * @api
 */
class KakaoSync extends api_base
{

	function __construct()
	{
		parent::__construct();

		// 토큰 체크
		$this->grant = $this->check();
	}

	/**
	 * 쇼핑몰 정보 조회 API
	 */
	public function info_get()
	{
		try {
			// 비지니스 로직 구현
			$this->load->library('AdditionService/kakaosync/Client');
			$result = $this->client->getKakaosyncShopInfo();

			$this->response($result);
		} catch (Exception $e) {
			$this->response(['result' => false, 'error' => $e->getMessage()]);
		}
	}

	/**
	 * 카카오싱크 설정 결과 콜백 API
	 */
	public function state_post()
	{
		try {
			// Request 파라미터
			$postParams = $this->input->post();

			// 비지니스 로직 구현
			$KakaosyncSetting = new KakaosyncSetting();
			$result = $KakaosyncSetting->setting($postParams);

			if($result['success']) {
				$this->response($result);
			} else {
				$this->response500($result);
			}
		} catch (Exception $e) {
			$this->response(['result' => false, 'error' => $e->getMessage()]);
		}
	}
}
