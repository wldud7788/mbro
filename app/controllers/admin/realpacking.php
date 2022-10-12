<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

/* 리얼 패킹 관리자 페이지
 * 2016.09.08 pjw
 */
class realpacking extends admin_base {
	public function __construct() {
		parent::__construct();		
	}

	public function index(){
		redirect("/admin/realpacking/main");
	}
	
	// 메인페이지
	public function main(){
		$this->admin_menu();
		$this->tempate_modules();

		$real_config = config_load('realpacking');
		$real_config['service_info'] = get_object_vars(json_decode($real_config['service_info']));	

		$this->template->assign(array("real_config"=>$real_config));
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}
	
	// 서비스 등록 페이지
	public function service_regist(){
		$this->template->assign(array("shopNo"=>$this->config_system['shopSno']));

		$this->admin_menu();
		$this->tempate_modules();
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}
}