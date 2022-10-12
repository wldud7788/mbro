<?php 
function assignBrandBestIcon(){
	$CI =& get_instance();
	$config_icon			= config_load('brand_main','best_icon');
	$brand_best_icon		= $config_icon['best_icon'];
	if($brand_best_icon)	$CI->template->assign(array('brand_best_icon'=>$brand_best_icon));
}