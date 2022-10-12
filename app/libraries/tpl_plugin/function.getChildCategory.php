<?php

/* 하위카테고리 목록 반환 */
function getChildCategory($code,$exactly=false,$division='catalog')
{
	$CI =& get_instance();

	// 관리자, 회원 로그인시 캐시 예외 적용
	$cache_flag = true;
	if ($CI->userInfo['member_seq'] || $CI->managerInfo) {
		$cache_flag = false;
	}
	$cache_item_id = sprintf('category_child_%s_%s_%s', $code, $exactly ? '1' : '0', $division);
	$data = cache_load($cache_item_id);
	if ($data === false || ! $cache_flag) {
		$CI->load->model('categorymodel');
		$data = $CI->categorymodel->getChildCategory($code,$exactly,$division);
		if ($cache_flag) {
			cache_save($cache_item_id, $data);
		}
	}

	return $data;
}

?>
