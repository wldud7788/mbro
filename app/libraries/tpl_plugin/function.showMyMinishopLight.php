<?php
/* 모바일 상단탭바 출력*/
function showMyMinishopLight()
{
	$CI =& get_instance();
	$CI->load->model('providermodel');
	$result = false;
	$result = $CI->myminishopmodel->get_myminishop($CI->userInfo['member_seq']);
	return $result;
}

