<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class ifdo_marketing extends admin_base {

	public function __construct() {
		parent::__construct();
		$this->load->library('ifdolibrary');
	}

	public function index()
	{
		redirect("/admin/ifdo_marketing/config");
	}

	public function config(){
		/* 관리자 권한 체크 : 시작 */
		$this->load->model('authmodel');
		$auth = $this->authmodel->manager_limit_act('ifdo_marketing');
		if(!$auth){
			pageBack($this->auth_msg);
			exit;
		}
		
		// IFDO연동 설정 정보
		$ifdo_marketing = $this->ifdolibrary->get_ifdo_marketing();

		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		$this->template->assign(array('ifdo_marketing'=>$ifdo_marketing));
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}
}

/* End of file ifdo_marketing.php */
/* Location: ./app/controllers/admin/ifdo_marketing.php */