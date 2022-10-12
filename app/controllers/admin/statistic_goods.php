<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class statistic_goods extends admin_base {

	public function __construct() {
		parent::__construct();

		$this->admin_menu();
		$this->tempate_modules();
		$this->load->model('statsmodel');
		$this->load->library('validation');

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

		### SERVICE CHECK
		$this->load->model('usedmodel');
		$result = $this->usedmodel->used_service_check('statistic_goods_detail');
		if(!$result['type']){
			$this->template->assign('statistic_goods_detail_limit','Y');
		}

		$this->seriesColors = array("#445ebc", "#d33c34","#4bb2c5", "#c5b47f", "#EAA228", "#579575", "#839557", "#958c12",
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc", "#c3b8f3", "#EA28A2", "#8566cc");
		$this->template->assign(array('seriesColors'=>$this->seriesColors));

		/* 쇼핑몰분석통계 메뉴 */
		$goods_menu = $this->uri->rsegments[count($this->uri->rsegments)];
		$goods_menu = str_replace(array("_monthly","_daily"),"",$goods_menu);
		$this->template->assign(array('selected_goods_menu'=>$goods_menu));
		$this->template->assign(array('service_code' => $this->config_system['service']['code']));
	}

	public function index()
	{
		redirect("/admin/statistic_goods/goods_cart");
	}

	public function goods_cart(){
		serviceLimit('H_FR','process');

		$cfg_order = config_load('order');
		$statlist	= array();

		$getParams = $this->input->get();

		if ($_SERVER["QUERY_STRING"] == null) {
			$getParams['sdate'] = date('Y-m-01');
			$getParams['edate'] = date('Y-m-d');
		}
		$params['sdate'] = $getParams['sdate'];
		$params['edate'] = $getParams['edate'];
		$params['provider_seq']	= trim($getParams['provider_seq']);
		$params['keyword'] = trim($getParams['keyword']);
		$params['category1'] = trim($getParams['category1']);
		$params['category2'] = trim($getParams['category2']);
		$params['category3'] = trim($getParams['category3']);
		$params['category4'] = trim($getParams['category4']);
		$params['brands1'] = trim($getParams['brands1']);
		$params['brands2'] = trim($getParams['brands2']);
		$params['brands3'] = trim($getParams['brands3']);
		$params['brands4'] = trim($getParams['brands4']);
		$params['order_by'] = trim($getParams['order_by']);

		// 오늘일자 포함 시 오늘일자 데이터 갱신
		if($params['sdate'] <= date('Y-m-d') && date('Y-m-d') <= $params['edate']){
			$this->renewal_goods(date('Y-m-d'));
		}

		$statQuery = $this->statsmodel->get_goods_cart_stats($params);
		if ($statQuery){
			foreach($statQuery->result_array() as $k => $data){
				$data['stock'] = 0;
				$data['badstock'] = 0;
				$data['reservation15'] = 0;
				$data['reservation25'] = 0;

				unset($optParams);
				$optParams['goods_seq']	= $data['goods_seq'];
				$optParams['sdate']	= $getParams['sdate'];
				$optParams['edate']	= $getParams['edate'];
				$optQuery = $this->statsmodel->get_option_cart_stats($optParams);
				foreach($optQuery->result_array() as $o => $optData){
					$data['tstock'] += $optData['stock'];
					$data['tbadstock'] += $optData['badstock'];
					$data['treservation15']	+= $optData['reservation15'];
					$data['treservation25']	+= $optData['reservation25'];

					$data['options'][] = $optData;
				}
				$statlist[] = $data;
			}
		}

		$this->load->model('providermodel');
		$provider = $this->providermodel->provider_goods_list();

		$this->template->assign(array('sc'=>$getParams));
		$this->template->assign(array('provider'=>$provider));
		$this->template->assign(array('cfg_order'=>$cfg_order));
		$this->template->assign(array('statlist'=>$statlist));

		//검색
		$sc = $this->input->get();		
		$this->template->assign(array('sc'=>$sc,'scObj'=>json_encode($sc)));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function goods_wish(){
		serviceLimit('H_FR','process');

		$cfg_order = config_load('order');
		$statlist	= array();

		$getParams = $this->input->get();

		if ($_SERVER["QUERY_STRING"] == null) {
			$getParams['sdate'] = date('Y-m-01');
			$getParams['edate'] = date('Y-m-d');
		}
		$params['sdate'] = ($getParams['sdate']);
		$params['edate'] = ($getParams['edate']);
		$params['provider_seq'] = trim($getParams['provider_seq']);
		$params['keyword'] = trim($getParams['keyword']);
		$params['category1'] = trim($getParams['category1']);
		$params['category2'] = trim($getParams['category2']);
		$params['category3'] = trim($getParams['category3']);
		$params['category4'] = trim($getParams['category4']);
		$params['brands1'] = trim($getParams['brands1']);
		$params['brands2'] = trim($getParams['brands2']);
		$params['brands3'] = trim($getParams['brands3']);
		$params['brands4'] = trim($getParams['brands4']);
		$params['order_by'] = trim($getParams['order_by']);

		$statSql	= $this->statsmodel->get_goods_wish_stats($params);
		$statlist	= $statSql->result_array();

		$this->load->model('providermodel');
		$provider			= $this->providermodel->provider_goods_list();

		$this->template->assign(array('sc'=>$getParams));
		$this->template->assign(array('provider'=>$provider));
		$this->template->assign(array('cfg_order'=>$cfg_order));
		$this->template->assign(array('statlist'=>$statlist));

		//검색
		$sc = $this->input->get();		
		$this->template->assign(array('sc'=>$sc,'scObj'=>json_encode($sc)));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}



	public function goods_search(){
		$aGetParams = $this->input->get();

		// validation
		if ($aGetParams) {
			$this->validation->set_data($aGetParams);
			$this->validation->set_rules('orderby', '정렬', 'trim|string|xss_clean');
			$this->validation->set_rules('sdate', '시작일', 'trim|string|xss_clean');
			$this->validation->set_rules('edate', '종료일', 'trim|string|xss_clean');
			$this->validation->set_rules('keyword', '검색어', 'trim|string|xss_clean');
			if ($this->validation->exec() === false) {
				show_error($this->validation->error_array['value']);
			}
		}

		serviceLimit('H_FR','process');

		$cfg_order = config_load('order');
		$statlist	= array();

		if ($_SERVER["QUERY_STRING"] == null) {
			$_GET['sdate'] = date('Y-m-01');
			$_GET['edate'] = date('Y-m-d');
		}
		$params['sdate']		= ($_GET['sdate']);
		$params['edate']		= ($_GET['edate']);
		$params['keyword']		= trim($_GET['keyword']);

		$statSql	= $this->statsmodel->get_goods_search_stats($params);
		$statlist	= $statSql->result_array();
		foreach($statlist as $k=>$data){
			$statlist[$k]['keyword'] = str_replace(array('<','>'),array('[',']'),$data['keyword']);
		}

		$this->template->assign(array('sc'=>$_GET));
		$this->template->assign(array('cfg_order'=>$cfg_order));
		$this->template->assign(array('statlist'=>$statlist));

		//검색
		$sc = $this->input->get();		
		$this->template->assign(array('sc'=>$sc,'scObj'=>json_encode($sc)));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function goods_search_view(){

		if(!$_GET['search_priod']) $_GET['search_priod'] = 30;
		$statSql	= $this->statsmodel->get_goods_search_by_age($_GET['keyword'],$_GET['search_priod']);
		$statlist	= $statSql->result_array();
		foreach($statlist as $k=>$data){
			if($data['age'] > 10){
				$dataForChartAge[substr($data['age'],0,1).'0'][0] = substr($data['age'],0,1).'0대';
				$dataForChartAge[substr($data['age'],0,1).'0'][1] += $data['cnt'];
			}else if($data['age'] > 0){
				$dataForChartAge[10][0] = '10대';
				$dataForChartAge[10][1] += $data['cnt'];
			}else if($data['member_check']=='MEMBER'){
				$dataForChartAge[1][0] = '회원(정보없음)';
				$dataForChartAge[1][1] += $data['cnt'];
			}else{
				$dataForChartAge[0][0] = '비회원';
				$dataForChartAge[0][1] += $data['cnt'];
			}
		}
		$dataForChartAge = array_values($dataForChartAge);

		$statSql	= $this->statsmodel->get_goods_search_by_sex($_GET['keyword'],$_GET['search_priod']);
		$statlist	= $statSql->result_array();
		foreach($statlist as $k=>$data){
			switch($data['sex']){
				case	'female' :
					$dataForChartSex[$k][] = '여성';
					break;
				case	'male' :
					$dataForChartSex[$k][] = '남성';
					break;
				default :
					$dataForChartSex[$k][] = ($data['member_check'] == 'MEMBER') ? '회원(정보없음)' : '비회원';
					break;
			}
			$dataForChartSex[$k][] = $data['cnt'];
		}

		$statSql	= $this->statsmodel->get_goods_search_by_date($_GET['keyword'],$_GET['search_priod']);
		$statlist	= $statSql->result_array();
		foreach($statlist as $k=>$data){
			$dataForChartDate[$k]['regist_date'] = $data['regist_date'];
			$dataForChartDate[$k]['cnt'] = $data['cnt'];
		}

		$file_path	= $this->template_path();
		$this->template->assign(array('dataForChartAge'=>$dataForChartAge));
		$this->template->assign(array('dataForChartSex'=>$dataForChartSex));
		$this->template->assign(array('dataForChartDate'=>$dataForChartDate));
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function goods_search_detail(){
		$aGetParams = $this->input->get();
		if(!$aGetParams['page']) $aGetParams['page'] = 1;
		$file_path	= $this->template_path();
		$result = $this->statsmodel->get_goods_search_paging_by_date($aGetParams['keyword'],$aGetParams['sdate'],$aGetParams['edate'],$aGetParams['page']);
		$this->template->assign($result);
		$this->template->assign('sc', $aGetParams);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}


	public function goods_review(){
		serviceLimit('H_FR','process');

		$cfg_order = config_load('order');
		$statlist	= array();

		$getParams = $this->input->get();

		if ($_SERVER["QUERY_STRING"] == null) {
			$getParams['sdate'] = date('Y-m-01');
			$getParams['edate'] = date('Y-m-d');
		}

		$params['sdate'] = ($getParams['sdate']);
		$params['edate'] = ($getParams['edate']);
		$params['provider_seq']	= trim($getParams['provider_seq']);
		$params['keyword'] = trim($getParams['keyword']);
		$params['category1'] = trim($getParams['category1']);
		$params['category2'] = trim($getParams['category2']);
		$params['category3'] = trim($getParams['category3']);
		$params['category4'] = trim($getParams['category4']);
		$params['brands1'] = trim($getParams['brands1']);
		$params['brands2'] = trim($getParams['brands2']);
		$params['brands3'] = trim($getParams['brands3']);
		$params['brands4'] = trim($getParams['brands4']);
		$params['order_by'] = trim($getParams['order_by']);

		$statSql	= $this->statsmodel->get_goods_review_stats($params);
		$statlist	= $statSql->result_array();

		$this->load->model('providermodel');
		$provider			= $this->providermodel->provider_goods_list();

		$this->template->assign(array('sc'=>$getParams));
		$this->template->assign(array('provider'=>$provider));
		$this->template->assign(array('cfg_order'=>$cfg_order));
		$this->template->assign(array('statlist'=>$statlist));

		//검색
		$sc = $this->input->get();		
		$this->template->assign(array('sc'=>$sc,'scObj'=>json_encode($sc)));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function goods_restock(){
		serviceLimit('H_FR','process');

		$cfg_order = config_load('order');
		$statlist	= array();

		$getParams = $this->input->get();
		/*
		if ($_SERVER["QUERY_STRING"] == null) {
			$getParams['sdate'] = date('Y-m-01');
			$getParams['edate'] = date('Y-m-d');
		}*/
		$params['sdate'] = ($getParams['sdate']);
		$params['edate'] = ($getParams['edate']);
		$params['provider_seq']	= trim($getParams['provider_seq']);
		$params['keyword'] = trim($getParams['keyword']);
		$params['category1'] = trim($getParams['category1']);
		$params['category2'] = trim($getParams['category2']);
		$params['category3'] = trim($getParams['category3']);
		$params['category4'] = trim($getParams['category4']);
		$params['brands1'] = trim($getParams['brands1']);
		$params['brands2'] = trim($getParams['brands2']);
		$params['brands3'] = trim($getParams['brands3']);
		$params['brands4'] = trim($getParams['brands4']);
		$params['order_by'] = trim($getParams['order_by']);

		$statSql	= $this->statsmodel->get_goods_restock_stats($params);
		$statlist	= $statSql->result_array();

		$this->load->model('providermodel');
		$provider = $this->providermodel->provider_goods_list();

		$this->template->assign(array('sc'=>$getParams));
		$this->template->assign(array('provider'=>$provider));
		$this->template->assign(array('cfg_order'=>$cfg_order));
		$this->template->assign(array('statlist'=>$statlist));

		//검색
		$sc = $this->input->get();		
		$this->template->assign(array('sc'=>$sc,'scObj'=>json_encode($sc)));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	// 상품 집계 오늘날짜 갱신
	public function renewal_goods($stats_date){
		// 장바구니 집계 갱신
		$this->statsmodel->delete_accumul_cart_stats($stats_date);
		$this->statsmodel->set_accumul_cart_stats($stats_date);
	}
}

/* End of file statistic_promotion.php */
/* Location: ./app/controllers/admin/statistic_promotion.php */