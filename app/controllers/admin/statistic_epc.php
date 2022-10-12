<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class statistic_epc extends admin_base {
	
	public function __construct() {
		parent::__construct();

		$this->admin_menu();
		$this->tempate_modules();
		
		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('statistic_epc');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}
		/* 관리자 권한 체크 : 끝 */

		### SERVICE CHECK
		$this->load->model('usedmodel');
		$result = $this->usedmodel->used_service_check('statistic_visitor_detail');
		if(!$result['type']){
			$this->template->assign('statistic_visitor_detail_limit','Y');
		}
//

		$this->template->assign(array(
			'service_code' => $this->config_system['service']['code'], 
			'sitetype'=>$_GET['sitetype'],
			'sitetypeloop'=>$this->sitetypeloop
		));
	}

	public function index()
	{
		redirect("/admin/statistic_epc/epc_basic");
	}

	public function epc_basic(){

		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('statistic_epc');
		$this->load->model('statsmodel');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}

		$year			= !empty($_GET['year']) ? $_GET['year'] : date('Y');
		$stats_type		= !empty($_GET['stats_type']) ? $_GET['stats_type'] : 'emoney';
		$accumulate		= 0; //누적 마일리지액
		$type_arr		= array('before_total','plus','minus','limits','after_total');
		$dataForChart	= array();
		$maxval_arr		= array();
		$now_date		= date('Y-m-01');
		$end_date		= date('Y-m-d');

		if($stats_type == 'point' || $stats_type == 'cash'){
			serviceLimit('H_FR','process');
		}

		$sql = "select * from fm_stats_epc where stats_type = '{$stats_type}' and stats_year = '{$year}' order by stats_month";

		$query			= $this->db->query($sql);
		$query			= $query->result_array();

		foreach($query as $k => $v){
			foreach($type_arr as $type){
				$dataForChart[$type][] = array($v['stats_month'].'월',$v[$type]);
				$maxval_arr[] = (int)$v[$type];
			}
		}

		$accumulate = $this->statsmodel->get_stats_epc_accumulate($stats_type);

		$this->template->assign(array(
			'dataForChart'	=> $dataForChart,
			'maxValue'		=> max($maxval_arr),
			'year'			=> $year,
			'accumulate'	=> $accumulate
		));

		$this->template->define(array('_year_table'=>$this->skin."/statistic_epc/_year_table.html"));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	
	}

}