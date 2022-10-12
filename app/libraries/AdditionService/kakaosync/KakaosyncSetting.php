<?php

namespace App\Libraries\AdditionService\kakaosync;
/**
 * 솔루션에서 카카오싱크 연동 설정
 * 카카오싱크 연동 과정에 따라 솔루션에서 세팅을 변경
 * 
 * @package    Firstmall
 * @author     WooSuk Choi <cws@gabiacns.com>
 * @copyright  2022 Gabia C&S
 */

 class KakaosyncSetting
{
	public function __construct()
	{
		$this->ci = &get_instance();
	}
 
	public function setting($param)
	{
		$kakao = $param['kakao'];
		$action = $kakao['data']['action'];

		writeCsLog($kakao, "api" , "sync", "hour");

		if(empty($kakao['data'])) {
			$msg = '정상적인 데이터를 응답받지 못함.';
			return $this->errorResult($msg);
		}

		if($action == "connect" || $action == "edit") {
			$result = $this->kakaosyncConnect($kakao);
		} else if($action == 'disconnect') {
			$result = $this->kakaosyncDisconnect();
		}

		return $result;
	}

	// 카카오싱크 설정 값 세팅
	protected function kakaosyncConnect($param)
	{
		if(empty($param['jsAppKey']) || empty($param['restApiKey'])){
			$msg = '정상적인 데이터를 응답받지 못함.';
			return $this->errorResult($msg);
		}

		$snssocialar['key_k'] = $param['jsAppKey'];
		$snssocialar['kakaotalk_app_javascript_key'] = $param['jsAppKey'];
		$snssocialar['rest_key_k'] = $param['restApiKey'];
		$snssocialar['status_ks'] = '1';
		$snssocialar['type_k'] = 'rest';
		$snssocialar['mode_ks'] = 'SYNC';

		config_save_array('snssocial',$snssocialar);

		return $this->successResult();
	}

	// 카카오싱크 설정 값 해제
	protected function kakaosyncDisconnect()
	{
		$snssocialar['key_k'] = '';
		$snssocialar['rest_key_k'] = '';
		$snssocialar['kakaotalk_app_javascript_key'] = '';
		$snssocialar['use_k'] = '0';
		$snssocialar['status_ks'] = '0';

		config_save_array('snssocial',$snssocialar);

		return $this->successResult();
	}

	// 성공 리턴
	public function successResult($data = []) {
		return [
			'success' => true,
		];
	}

	// 실패 리턴
	public function errorResult($msg) {
		return [
			'success' => false,
			'msg' => $msg
		];
	}
}