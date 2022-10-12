<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class errdoc extends front_base {
	function error_404()
	{
		// 404 not found error 시 header 코드 추가
		$this->output->set_status_header('404'); 
		
		$basic = ($this->config_basic)?$this->config_basic:config_load('basic'); 
		$arr_asign = array(
			'companyName'=>$basic['companyName'],
			'companyPhone'=>$basic['companyPhone']
		);
		$this->template->assign($arr_asign);
		$uri_str = uri_string();
		if(strpos($uri_str, "admin/") !== false){
			$this->skin = $this->config_system['adminSkin']; 
		} 
//		$this->template->define(array('tpl'=>$this->skin.'/errdoc/404.html'));
//		$this->template->print_("tpl");

		$file_path = $this->skin.'/errdoc/404.html';
		$this->print_layout($file_path);
	}
}
?>