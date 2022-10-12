<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

use App\Libraries\AdditionService\send;
use App\Libraries\AdditionService\StringSecurity;

/**
 * 인스타그램 연동을 위한 중계서버 통신용 Client 클래스
 *
 * @package    Firstmall
 * @author     WooSuk Choi <cws@gabiacns.com>
 * @copyright  2022 Gabia C&S
 */

class Client extends Send
{
	public function __construct()
	{
		parent::__construct();

		if (!$this->api_url) {
			$this->setApi();
		}
	}

	/**
	 * url path SET
	 */
	protected function setApi()
	{
		$this->ci->load->config('additionServer');
		$instagramConfig = $this->ci->config->item('instagram');

		$this->apiUrl = $instagramConfig['mallApiHost'];
		$this->detailUrl = [
			'join' => ['method' => 'get', 'uri' => '/instargram/shopInsert/'], // 인스타그램 신청
		];
	}

	// 인스타그램 연동 팝업 호출
	public function instagramJoin()
	{
		$params = $this->setInstagramParameters();

		$data['uri'] = $params['call_url'];
		$data['code'] = StringSecurity::SecurityEncode('f' . $params['shopsno'], $this->apiKey);
		$data['site'] = StringSecurity::SecurityEncode($params['temp_domain'], $this->apiKey);

		return $this->successResult($data);
	}

	// 인스타그램 연동 파라미터 처리
	public function setInstagramParameters()
	{
		$call_url = 'https://' . $this->apiUrl . $this->detailUrl['join']['uri'];

		$cfg = config_load('system');
		$shopsno = $cfg['shopSno'];

		$this->ci->load->model('adminenvmodel');
		$env_data = $this->ci->adminenvmodel->get(['use_yn' => 'y', 'admin_env_seq' => '1'])->row_array();
		$temp_domain = 'http://' . $env_data['temp_domain'];

		return [
			'call_url' => $call_url,
			'shopsno' => $shopsno,
			'temp_domain' => $temp_domain
		];
	}

	// 성공 리턴
	public function successResult($data = [])
	{
		return [
			'success' => true,
			'data' => $data
		];
	}

	// 실패 리턴
	public function errorResult($msg)
	{
		return [
			'success' => false,
			'msg' => $msg
		];
	}
}
