<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class ProviderLibrary
{
	public function __construct()
	{
		$this->CI = &get_instance();
	}

	/**
	 * 입점사 미출고 리스트 검색 기본값
	 * @param array $sc 검색조건
	 * @return array $param 검색 기본값 세팅된 값
	 */
	public function default_search_remind_export($param)
	{
		// 기본값 세팅
		$param['display_sort'] = (!$param['display_sort'] && $param['sort']) ? $param['sort'] : $param['display_sort']; //정렬
		$param['display_sort'] = ($param['display_sort']) ? $param['display_sort'] : 'provider_name ASC';
		$param['page'] = ($param['page']) ? $param['page'] : 0; // 첫 페이지로 초기화
		$param['perpage'] = ($param['perpage']) ? $param['perpage'] : 10; // 10개씩 노출
		$param['regdate'][0] = ($param['regdate'][0]) ? $param['regdate'][0] : date('Y-m-d', strtotime('-9 day')); // 기간 (-3일부터 7일 동안)
		$param['regdate'][1] = ($param['regdate'][1]) ? $param['regdate'][1] : date('Y-m-d', strtotime('-3 day'));
		$param['select_date_regist'] = ($param['regdate'][0] == date('Y-m-d', strtotime('-9 day')) && $param['regdate'][1] == date('Y-m-d', strtotime('-3 day'))) ? '7days_untill_end_date' : $param['select_date_regist']; // 7일 동안인 경우
		$param['found_info_mobile'] = (count($param['found_info_mobile']) == 1) ? $param['found_info_mobile'] : ['Y', 'N']; // 물류 담당자 연락처 유무 모두

		return $param;
	}
}
