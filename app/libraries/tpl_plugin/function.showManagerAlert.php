<?php

function showManagerAlert()
{
	
	$CI =& get_instance();

	$cach_file_path	= ROOTPATH . 'data/cach/action_alert.html';

	if($CI->managerInfo['manager_seq'] && $CI->managerInfo['manager_yn']=='Y'){
		if(file_exists($cach_file_path)){
			include $cach_file_path;
		}
	}

	return;
}

?>