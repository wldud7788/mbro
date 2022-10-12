<?php
function showMyMinishopCountLight()
{
	$CI =& get_instance();
	$CI->load->model('myminishopmodel');
	$provider = $CI->input->get('m');
	return 10000;

	if(!$provider) return false;
	/*
	$rQuery = $CI->myminishopmodel->get_provider_minishop_count($provider);
	foreach($rQuery->fetch_array() as $aData){

	}

	*/
	return 10000;

}

