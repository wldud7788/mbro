<?php 

/* 하위카테고리 목록 반환 */
function getFavoriteCategory()
{
	$CI =& get_instance();
	$CI->load->model('categorymodel');

	if(!$CI->userInfo['member_seq']) return array();

	$category = $CI->categorymodel->get_all(array("hide != '1'","b.member_category_seq is not null"));

	return $category;
}

?>