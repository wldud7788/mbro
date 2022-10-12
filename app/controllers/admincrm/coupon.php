<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/crm_base".EXT);

class coupon extends crm_base {

	public function __construct() {
		parent::__construct();
		$this->load->model('ordermodel');
		$this->load->model('providermodel');
		$this->load->helper('order');
		$this->arr_step = config_load('step');
		$this->arr_payment = config_load('payment');
		$this->cfg_order = config_load('order');

		$auth = $this->authmodel->manager_limit_act('order_view');
		if(!$auth){
			pageBack("관리자 권한이 없습니다.");
			exit;
		}
	}

	public function promotion_view(){

		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$sc['download_seq'] = $_GET['no'];

		### SEARCH
		$sc['search_text']		= ($sc['search_text'] == '아이디, 이름') ? '':$sc['search_text'];
		$sc['orderby']		= (!empty($_POST['orderby'])) ?	$_POST['orderby']:'download_seq';
		$sc['sort']				= (!empty($_POST['sort'])) ?			$_POST['sort']:'desc';
		$sc['perpage']		= (!empty($_POST['perpage'])) ?	intval($_POST['perpage']):10;
		$sc['page']			= (!empty($_POST['page'])) ?		intval(($_POST['page'] - 1) * $sc['perpage']):0;

		$this->load->model("promotionmodel");
		$data = $this->promotionmodel->download_list($sc);

		$this->template->assign($data[result][0]);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}
}