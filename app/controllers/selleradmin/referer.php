<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class referer extends selleradmin_base {

	public function __construct(){
		parent::__construct();

		$this->load->model('providermodel');
		$this->load->model('referermodel');
		$this->load->model('categorymodel');
		$this->load->model('goodsmodel');

		$this->admin_menu();
		$this->tempate_modules();
		$this->file_path	= $this->template_path();

		$auth = $this->authmodel->manager_limit_act('coupon_view');

		if(!$auth){
			pageBack("권한이 없습니다.");
			exit;
		}

		$this->template->define(array('tpl'=>$this->file_path));
	}

	public function index(){
		redirect("/selleradmin/referer/catalog");
	}

	// 유입경로할인 목록
	public function catalog(){

		$sc							= $_GET;
		$sc['page']				= (isset($_GET['page']) && $_GET['page'] > 1) ? intval($_GET['page']):'0';
		$sc['perpage']			= (isset($_GET['perpage'])) ?	intval($_GET['perpage']):'10';
		if(isset($_GET['search_text'])) $sc['search_mode']	= "search";
		$sc['provider_seq']			= $this->providerInfo['provider_seq'];
		$sc['salescost_provider']	= 1;

		$referer	= $this->referermodel->get_referersale_list($sc);

		if	($referer['record']){
			foreach($referer['record'] as $k => $data){
	
				$data['date']		= date('Y-m-d H:i', strtotime($data['regist_date']));
				$data['validdate']	= $data['issue_startdate'] . ' ~ ' . $data['issue_enddate'];

				//기획정의.
				if(in_array($this->config_system['basic_currency'],array("KRW","JPY"))){
					$data['max_percent_goods_sale'] = (int)$data['max_percent_goods_sale'];
					$data['won_goods_sale']			= (int)$data['won_goods_sale'];
				}
				$data['salepricetitle']	= ($data['sale_type'] == 'percent' ) ? $data['percent_goods_sale'].'% 할인, 최대 '.get_currency_price($data['max_percent_goods_sale'],2,'basic'): get_currency_price($data['won_goods_sale'],2,'basic')." 할인";

				$list[]	= $data;
			}
		}

		if(!$sc['search_field']) $sc['search_field'] = "all";
		$sc['selectbox']['search_field'][$sc['search_field']] = "selected";

		$this->template->assign('sc',$sc);
		$this->template->assign(array('list'=>$list));
		$this->template->assign(array('page'=>$referer['page']));
		$this->template->print_("tpl");
	}

	// 유입경로할인 상세
	public function referersale(){

		$provider			= $this->providermodel->provider_goods_list();
		if	($_GET['no']){
			$referer			= $this->referermodel->get_referersale_info($_GET['no']);
			$issuegoods 		= $this->referermodel->get_referersale_issuegoods($_GET['no']);
			$issuecategorys		= $this->referermodel->get_referersale_issuecategory($_GET['no']);
			if	($referer['provider_list']){
				$provider_list	= substr(substr($referer['provider_list'], 1), 0, -1);
				$provider_arr	= explode('|', $provider_list);
				if	(count($provider_arr) > 0){
					$provider_select_list	= $this->providermodel->get_provider_range($provider_arr);
					if	($provider_select_list){
						foreach($provider_select_list as $k => $data){
							if	($k > 0)	$provider_name_list	.= '<br />';
							$provider_name_list	.= $data['provider_name'];
						}
					}
				}

				$referer['provider_name_list']	= $provider_name_list;
			}

			if(($issuegoods)){
				foreach($issuegoods as $key => $tmp) $arrGoodsSeq[] =  $tmp['goods_seq'];
				$goods = $this->goodsmodel->get_goods_list($arrGoodsSeq,'thumbView');
				foreach($issuegoods as $key => $data) $issuegoods[$key] = @array_merge($issuegoods[$key],$goods[$data['goods_seq']]);
				$this->template->assign(array('issuegoods'=>$issuegoods));
			}

			if($issuecategorys){
				foreach($issuecategorys as $key =>$data) $issuecategorys[$key]['category'] = $this->categorymodel -> get_category_name($data['category_code']);
				$this->template->assign(array('issuecategorys'=>$issuecategorys));
			}

			$this->template->assign(array('referer'=>$referer));
		}

		$this->template->assign(array('provider'=>$provider));

		$this->template->print_("tpl");
	}
}

/* End of file referer.php */
/* Location: ./app/controllers/admin/referer.php */