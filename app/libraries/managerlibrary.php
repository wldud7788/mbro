<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
/**
 * 관리자/부관리자/입점사 정보 수정
 */
class ManagerLibrary
{
	public function __construct()
	{
		$this->CI = &get_instance();
	}

	/**
	 * exec_valid_limit_ip : (부)관리자 정보 등록/수정, 입점사 정보 등록/수정 시 사용
	 *
	 * @param  array $params : post data
	 * @param  string $limit_ip_key : 사용여부 체크할 key name
	 * @return array $params reference parameter
	 */
	public function exec_valid_limit_ip(&$params, $limit_ip_key = 'limit_ip')
	{
		$ip_chk_key = $limit_ip_key === 'limit_ip' ? 'ip_chk' : 'admin_ip_chk';

		// 대표 관리자(입점사) 가 아니면 배열 unset
		if ($this->auth_check_limit_ip() === false) {
			unset($params[$ip_chk_key], $params[$limit_ip_key]);
			return;
		}

		// params 에 ip_chk 값이 없으면 저장하지 않도록 배열 unset
		if (in_array($params[$ip_chk_key], ['Y', 'N']) == false) {
			unset($params[$ip_chk_key], $params[$limit_ip_key]);
			return;
		}

		// ip_chk == 'Y' 면 limit_ip 만들어서 저장
		if ($params[$ip_chk_key] == 'Y') {
			// ip 체킹
			$ip_cheking = $this->validate_arr_limit_ip($params, $limit_ip_key);
			if ($ip_cheking['success'] === true) {
				// params 데이터에 만들기
				$this->set_limit_ip($params, $limit_ip_key);
			} else {
				openDialogAlert($ip_cheking['msg'], 400, 180, 'parent', $callback);
				exit;
			}
		} else {
			// ip_chk == 'N' 이면 limit_ip 없음
			$params[$limit_ip_key] = '';
		}
	}

	/**
	 * validate_arr_limit_ip : array ip 검증
	 *
	 * @param  array $params : post data
	 * @param  string $limit_ip_key : 사용여부 체크할 key name
	 * @return array $result : 'success' boolean, 'msg' string 메시지
	 */
	protected function validate_arr_limit_ip($params, $limit_ip_key = 'limit_ip')
	{
		$result = ['success' => true, 'msg' => ''];
		$limit_ip_count = count($params[$limit_ip_key . '1']);	// ip 개수

		for ($i = 0; $i < $limit_ip_count; $i++) {
			unset($limit_ip_data);
			$limit_ip_data[] = $params[$limit_ip_key . '1'][$i];
			$limit_ip_data[] = $params[$limit_ip_key . '2'][$i];
			$limit_ip_data[] = $params[$limit_ip_key . '3'][$i];
			if ($params[$limit_ip_key . '4'][$i] !== '') {
				$limit_ip_data[] = $params[$limit_ip_key . '4'][$i];
			}

			if ($this->validate_limit_ip($limit_ip_data) === false) {
				$result = ['success' => false, 'msg' => '아이피 대역은 0~255 사이의 숫자만 입력해주세요.<br/>아이피는 3번째 자리까지 필수 입력하셔야 합니다.'];
				continue;
			}
		}

		return $result;
	}

	/**
	 * validate_limit_ip : 실제 올바른 아이피인지 체크
	 *
	 * @param  array $arr_ip[0] ~ $arr_ip[3]
	 * @return void
	 */
	protected function validate_limit_ip($arr_ip)
	{
		if ($arr_ip[0] == '') {
			return false;
		}
		if ($arr_ip[0] < 1) {
			return false;
		}
		if ($arr_ip[0] > 255) {
			return false;
		}
		if (!is_numeric($arr_ip[0])) {
			return false;
		}
		for ($i = 1; $i < 3; $i++) {
			if ($arr_ip[$i] == '') {
				return false;
			}
			if ($arr_ip[$i] < 0) {
				return false;
			}
			if ($arr_ip[$i] > 255) {
				return false;
			}
			if (!is_numeric($arr_ip[$i])) {
				return false;
			}
		}
		if ($arr_ip[3] != '') {
			if ($arr_ip[3] < 1) {
				return false;
			}
			if ($arr_ip[3] > 255) {
				return false;
			}
			if (!is_numeric($arr_ip[3])) {
				return false;
			}
		}

		return true;
	}

	/**
	 * set_limit_ip : db 에 저장 가능한 형태로 만듦
	 *
	 * @param  array $params : post data
	 * @param  string $limit_ip_key : 사용여부 체크할 key name
	 */
	protected function set_limit_ip(&$params, $limit_ip_key = 'limit_ip')
	{
		$limit_ip = [];
		$limit_ip_count = count($params[$limit_ip_key . '1']);	// ip 개수

		for ($i = 0; $i < $limit_ip_count; $i++) {
			unset($limit_ip_data);
			$limit_ip_data[] = $params[$limit_ip_key . '1'][$i];
			$limit_ip_data[] = $params[$limit_ip_key . '2'][$i];
			$limit_ip_data[] = $params[$limit_ip_key . '3'][$i];
			if ($params[$limit_ip_key . '4'][$i] !== '') {
				$limit_ip_data[] = $params[$limit_ip_key . '4'][$i];
			}

			$ip = implode('.', $limit_ip_data);
			$limit_ip[] = $ip;
		}

		$params[$limit_ip_key] = implode('|', $limit_ip) . '|';
	}

	/**
	 * auth_check_limit_ip : ip 수정은 본사, 입점사의 대표관리자만 가능함
	 *
	 * @return boolean
	 */
	protected function auth_check_limit_ip()
	{
		$auth_check = false;	// 대표 관리자(입점사) 체크

		// 본사 관리자 - 부관리자는 ip_chk, limit_ip 수정하지 않음
		if (defined('__ADMIN__') === true && $this->CI->managerInfo['manager_yn'] == 'Y') {
			$auth_check = true;
		}
		// 입점사 관리자 - 부관리자는 ip_chk, limit_ip 수정하지 않음
		if (defined('__SELLERADMIN__') === true && $this->CI->providerInfo['manager_yn'] == 'Y') {
			$auth_check = true;
		}

		return $auth_check;
	}
}
