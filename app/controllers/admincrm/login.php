<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/crm_base".EXT);

class login extends crm_base {

	public function __construct() {
		parent::__construct();
	}

	public function index(){

		// 로그인 페이지 아이피 접근제한
		$this->load->model('protectip');
		
		// Relected XSS 검증
		xss_clean_filter();
		
		$this->protectip->protect_ip_admin_login();

		$this->tempate_modules();
		$file_path	= $this->template_path();
		
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function init(){

		$sql = "select count(*) as cnt from fm_manager";
		$query = $this->db->query($sql);
		$result = $query->row_array();
		if($result['cnt']){
			redirect("/admincrm/login/index");
		}

		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

}

/* End of file login.php */
/* Location: ./app/controllers/admin/login.php */