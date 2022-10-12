<?php 

/* 하위브랜드 목록 반환 */
function getFavoriteBrand()
{
	$CI =& get_instance();
	$CI->load->model('brandmodel');

	if(!$CI->userInfo['member_seq']) return array();

	$category = $CI->brandmodel->get_all(array("hide != '1'","b.member_category_seq is not null"));

	return $category;
}

?>