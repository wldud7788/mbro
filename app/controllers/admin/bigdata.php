<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class bigdata extends admin_base {

	public function __construct() {
		parent::__construct();

		$this->admin_menu();
		$this->tempate_modules();
		$this->load->model('bigdatamodel');
		$this->load->model('goodsmodel');
		$this->load->model('usedmodel');
		if	(!$this->config_system)		$this->config_system	= config_load('system');

		$chks = $this->usedmodel->used_service_check('bigdata');
		$this->template->assign(array('chkBigdata'=>$chks['type']));

		$this->template->assign(array('kinds' => $this->bigdatamodel->get_kind_array()));
		$this->template->define(array('SEARCH_FORM' => $this->skin."/bigdata/search_form.html"));
	}

	public function index(){
		redirect("/admin/bigdata/catalog");
	}

	// 빅데이터 추천 설정 페이지
	public function catalog(){
		serviceLimit('H_FR','process');

		// 현재 저장된 설정 불러오기
		$cfg_bigdata = config_load('bigdata_criteria');
		$this->template->assign(array('cfg_bigdata'	=> $cfg_bigdata['condition']));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	// 상품정보 추출 페이지
	public function get_goods(){

		$goods_seq			= trim($this->input->post('goods_seq'));
		$condition			= trim($this->input->post('condition'));
		$displayCriteria	= trim($this->input->post('displayCriteria'));

		if(strpos($condition,'bigdata') > -1) $sc['bigdata'] = 1;

		$sc['bigdata_test'] 		= 1;
		$sc['goods_seq_exclude'] 	= $goods_seq;

		$this->load->model('goodsdisplay');
		$sc 	= $this->goodsdisplay->auto_select_condition($displayCriteria, $sc);
		$list 	= $this->goodsmodel->auto_condition_goods_list($sc);

		foreach($list['record'] as &$data) {
			$data['jsimage'] 		= viewImg($data['goods_seq'],'thumbView');
			$data['jsgoods_name'] 	= getstrcut(strip_tags($data['goods_name']),30);
			$data['jsprice'] 		= get_currency_price($data['price'],2);
		}
		echo json_encode($list);
	}

	// 상품 상세정보 HTML
	public function get_goods_view($goods_seq){

		$this->tempate_modules();
		$result		= $this->goodsmodel->get_goods_view($goods_seq, true, true);
		if	($result['status'] == 'error'){
			echo $result['msg'];
		}else{
			$goods			= $result['goods'];
			$category		= $result['category'];
			$alerts			= $result['alerts'];
			if	($result['assign'])foreach($result['assign'] as $key => $val){
				$this->template->assign(array($key	=> $val));
			}
			$this->template->assign(array('skin'	=> $this->config_system['skin']));

			$file_path	= $this->template_path();
			$this->template->define(array('tpl'=>$file_path));
			$html		= $this->template->fetch("tpl");

			return $html;
		}
	}

	// 빅데이터 상품 추출
	public function get_bigdata_goods(){

		$goods_seq		= trim($_POST['goods_seq']);
		$skind			= trim($_POST['skind']);
		$base64_params	= trim($_POST['base64_params']);
		if	($base64_params)	$_POST	= unserialize(base64_decode($base64_params));
		$tkind			= trim($_POST['tkind']);
		$smonth			= trim($_POST['smonth']);
		$tmonth			= trim($_POST['tmonth']);
		$list_count_w	= trim($_POST['list_count_w']);
		$except			= trim($_POST['except']);
		$use_except		= trim($_POST['use_except']);
		$same_type		= $_POST['same_type'];
		$same_type		= explode(',', $_POST['same_type']);

		if	($goods_seq > 0){
			$sc['src_month']	= $smonth;
			$sc['goods_seq']	= $goods_seq;
			$sc['src_kind']		= $skind;
			$members			= $this->bigdatamodel->get_member_seq($sc);
			if	(is_array($members) && count($members) > 0){
				unset($sc);
				$sc['src_month']	= $tmonth;
				$sc['src_kind']		= $tkind;
				$sc['members']		= implode(',', $members);
				if	(count($same_type) > 0){
					foreach($same_type as $k => $type){
						if		($type == 'category'){
							$category	= $this->goodsmodel->get_goods_category_default($goods_seq);
						}elseif	($type == 'brand'){
							$brand		= $this->goodsmodel->get_goods_brand_default($goods_seq);
						}elseif	($type == 'location'){
							$location	= $this->goodsmodel->get_goods_location_default($goods_seq);
						}
					}
					$sc['category1']	= $category['category_code'];
					$sc['brands1']		= $brand['category_code'];
					$sc['location1']	= $location['category_code'];
				}

				$goods_arr	= $this->bigdatamodel->get_goods_seq($sc, 0);

				// 현재 검색한 상품 제외
				if (in_array($goods_seq,$goods_arr)) {
					$_tmp_data = array_diff($goods_arr, array($goods_seq));
					$goods_arr = array_values($_tmp_data);
				}
			}
		}

		$result['status']		= false;
		$result['kind']			= $skind;
		if	($use_except == 'y' && $except > 0 && count($goods_arr) < $except){
			$result['status']	= false;
		}elseif	(is_array($goods_arr) && count($goods_arr) > 0){
			$html				= $this->get_goods_list($goods_arr, $skind, $list_count_w);
			if	($html){
				$result['status']		= true;
				$result['html']			= $html;
			}
		}

		echo json_encode($result);
	}

	// 상품 상세정보 HTML
	public function get_goods_list($goods_seq, $kind, $count_w = 5){

		$this->tempate_modules();
		$goods_seq[]	= 13;
		$goods_seq[]	= 14;
		$goods_seq[]	= 16;
		$goods_seq[]	= 17;
		$sc['src_seq']	= $goods_seq;
		$list			= $this->goodsmodel->goods_list($sc);

		$this->template->assign(array('kind'	=> $kind));
		$this->template->assign(array('count_w'	=> $count_w));
		$this->template->assign(array('goods'	=> $list['record']));
		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$html		= $this->template->fetch("tpl");

		return $html;
	}

}

/* End of file bigdata.php */
/* Location: ./app/controllers/admin/bigdata.php */