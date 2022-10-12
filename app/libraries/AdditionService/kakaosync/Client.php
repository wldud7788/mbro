<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use App\Libraries\AdditionService\send;
use App\Libraries\AdditionService\kakaosync\ClientKakaosyncShopInfo;

/**
 * 카카오싱크 연동을 위한 중계서버 통신용 Client 클래스
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

		if (!$this->serviceType) {
			$this->setOption();
		}
	}

	/**
	 * option SET
	 */
	protected function setOption()
	{
		$this->serviceType = 'kakaosync';
		$this->storage = 'session'; // 토큰은 세션방식으로 저장함
		$this->expireTime = 50; // 토큰 유효시간 50초
	}

	/**
	 * url path SET
	 */
	protected function setApi()
	{
		$this->ci->load->config('additionServer');
		$kakaosyncConfig = $this->ci->config->item('kakaosync');

		$this->apiUrl	= $kakaosyncConfig['mallApiHost'];
		$this->detailUrl = [
			'accessToken' => ['method' => 'get',  'uri' => '/token/issue'], //토큰 발급
			'join'        => ['method' => 'post', 'uri' => '/shopInsert/{shopsno}'], // 카카오싱크 신청
			'state'       => ['method' => 'put',  'uri' => '/shopModify/{shopsno}'], // 카카오싱크 변경 및 해지
		];
	}

	// 쇼핑몰 정보 전달
	public function getKakaosyncShopInfo()
	{
		$client = new ClientKakaosyncShopInfo();
		return $client->getShopInfo();
	}

	// 사업자 정보 유효성 검사
	public function validBusinessData()
	{
		$this->ci->load->library('validation');
		$this->ci->load->model('adminenvmodel');

		$callbackUrl = "/admin/setting/multi_basic?no=1";

		$client = new ClientKakaosyncShopInfo();
		$getShopInfo = $client->getShopInfo();
		$vaildParams = $getShopInfo['business'];

		foreach ($vaildParams as $data) {
			if (is_array($data)) {
				foreach ($data as $key => $val) {
					$vaildParams[$key] = $val;
				}
			}
		}

		$this->ci->validation->set_data($vaildParams);
		$this->ci->validation->set_rules('identificationNumber', '사업자번호', 'trim|required|string|xss_clean');
		$this->ci->validation->set_rules('name', '상호', 'trim|required|string|xss_clean');
		$this->ci->validation->set_rules('representativeName', '대표자명', 'trim|required|string|xss_clean');
		$this->ci->validation->set_rules('category', '업태', 'trim|required|string|xss_clean');
		$this->ci->validation->set_rules('categoryItem', '종목', 'trim|required|string|xss_clean');
		$this->ci->validation->set_rules('zipcode', '지번', 'trim|required|string|xss_clean');
		$this->ci->validation->set_rules('baseAddress', '기본주소', 'trim|required|string|xss_clean');
		$this->ci->validation->set_rules('detailAddress', '상세주소', 'trim|required|string|xss_clean');

		if ($this->ci->validation->exec() === false) {
			$msg = "카카오싱크 연동 신청을 위한 쇼핑몰 필수 정보 입력 후 다시 신청해주세요.(설정>상점관리>사업자정보 입력)\n\n※ 필수 항목 : 사업자번호, 대표자명, 업태, 종목, 사업장주소";
			
			return $this->errorResult($msg, $callbackUrl);
		}

		$env_data = $this->ci->adminenvmodel->get(['use_yn' => 'y', 'admin_env_seq' => '1'])->row_array();
		if(empty($env_data['domain'])) {
			$msg = "카카오싱크 연동 신청을 위한 대표 도메인 설정 후 다시 신청해주세요.(설정>상점관리>대표 도메인)";
			return $this->errorResult($msg, $callbackUrl);
		}
		
		return $this->successResult();
	}

	// 카카오싱크 간편 설정 팝업 호출
	public function kakaosyncJoin()
	{
		$this->ci->load->model('adminenvmodel');
		$cfg = config_load('system');

		$get_params = ['shopSno' => $cfg['shopSno']];
		$env_data = $this->ci->adminenvmodel->get($get_params)->row_array();

		$params['domain'] = 'http://' . $env_data['temp_domain'];
		if($this->mode == 'test') $params['mode'] = 'test';

		$shopsno = $cfg['shopSno'];

		$result = $this->sendMethod('join',$params, ['shopsno' => 'f'.$shopsno]);
		$body = json_decode($result['body']);

		if($result['httpCode'] != 302 || $body->message) {
			$msg = $result['msg'] ?: $body->message;
			$msg = $msg ?: '카카오싱크 연동 신청이 실패되었습니다.';
			return $this->errorResult($msg);
		}

		preg_match_all("/\'.*?\'/",$result['body'], $url_match);
		$url = str_replace("'", "", $url_match[0]);
		$url = htmlspecialchars_decode($url[0]);

		return $this->successResult($url);
	}

	// 카카오싱크 설정 변경
	public function kakaosyncModify()
	{
		$social_cfg = config_load('snssocial');
		$params['appKey'] = $social_cfg['rest_key_k'];
		$params['action'] = 'edit';

		$cfg = config_load('system');
		$shopsno = $cfg['shopSno'];

		$result = $this->sendMethod('state', $params, ['shopsno' => 'f'.$shopsno]);

		return $result;
	}

	// 카카오싱크 연동 해제
	public function kakaosyncTerminate()
	{
		$social_cfg = config_load('snssocial');
		$params['appKey'] = $social_cfg['rest_key_k'];
		$params['action'] = 'disconnect';

		$cfg = config_load('system');
		$shopsno = $cfg['shopSno'];

		$result = $this->sendMethod('state', $params, ['shopsno' => 'f'.$shopsno]);
		$body = json_decode($result['body']);

		if($result['httpCode'] != 200 || $body->message) {
			$msg = $result['msg'] ?: $body->message;
			$msg = $msg ?: '카카오싱크 연동 해제가 실패되었습니다.';
			return $this->errorResult($msg);
		}

		return $this->successResult($result['body']);
	}

	// 성공 리턴
	public function successResult($data = []) {
		return [
			'success' => true,
			'data' => $data
		];
	}

	// 실패 리턴
	public function errorResult($msg, $redirectUrl = '') {
		return [
			'success' => false,
			'msg' => $msg,
			'url' => $redirectUrl,
		];
	}
}
