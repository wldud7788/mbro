<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class statistic_ga extends admin_base {
	
	public function __construct() {
		parent::__construct();

		$this->admin_menu();
		$this->tempate_modules();
		$this->load->model('statsmodel');

		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('statistic_goods');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}
		/* 관리자 권한 체크 : 끝 */

		/* 쇼핑몰분석통계 메뉴 */
		$goods_menu = $this->uri->rsegments[count($this->uri->rsegments)];
		$goods_menu = str_replace(array("_monthly","_daily"),"",$goods_menu);
		$this->template->assign(array('selected_goods_menu'=>$goods_menu));
		$this->template->assign(array('service_code' => $this->config_system['service']['code']));
	}

	public function index()
	{
		redirect("/admin/statistic_ga/regist");
	}

	public function regist(){
		//ga_auth -> common_base
		### SERVICE CHECK
		$this->load->model('usedmodel');
		$result = $this->usedmodel->used_service_check('grade');
		if(!$result['type']){
			$this->template->assign('service_limit','Y');
		}

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}
}

/* End of file statistic_promotion.php */
/* Location: ./app/controllers/admin/statistic_promotion.php */