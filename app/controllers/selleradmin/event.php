<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class event extends selleradmin_base {

	public function __construct() {
		parent::__construct();
		$auth = $this->authmodel->manager_limit_act('coupon_view');

		if(!$auth){
			pageBack("권한이 없습니다.");
			exit;
		}
	}

	public function index()
	{
		redirect("/selleradmin/event/catalog");
	}

	public function catalog()
	{
		redirect("/selleradmin/event/gift_catalog");
	}

	public function gift_catalog()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$this->load->model('eventmodel');
		$this->load->model("providermodel");
		$this->load->model('shippingmodel');

		$sc							= $_GET;
		$sc['sort']					= $_GET['sort'] ? $_GET['sort'] : 'evt.gift_seq desc';
		$sc['page']					= (isset($_GET['page']) && $_GET['page'] > 1) ? intval($_GET['page']):'0';
		$sc['keyword']				= $_GET['keyword'];
		$sc['perpage']				= $_GET['perpage'] ? $_GET['perpage'] : 10;
		$sc['provider_seq']			= $this->providerInfo['provider_seq'];
		$sc['salescost_provider']	= 1;

		$result		= $this->eventmodel->get_gift_event_list($sc);
		foreach($result['record'] as $k=>$v){

			// 배송그룹 미지정인 경우 (교환조건) / 데이터 오류인경우 -> 자동 본사 연결
			if	( !$v['shipping_group_seq'] ){
				if(!$v['provider_seq']) $v['provider_seq'] = '1';
				$ship_info = $this->shippingmodel->get_shipping_base($v['provider_seq']);
				$v['shipping_group_seq']	= $ship_info['shipping_group_seq'];
				$v['shipping_group_name']	= $ship_info['shipping_group_name'];

				$setParam['provider_seq']			= $v['provider_seq'];
				$setParam['shipping_group_seq']		= $v['shipping_group_seq'];

				$this->db->where("gift_seq",$v['gift_seq']);
				$this->db->update("fm_gift",$setParam);
			}

			// 입점사 명 추출
			if	( !$v['provider_name'] ){
				if	($v['provider_seq'] == 1)	$v['provider_name']	= '본사';
				else{
					$provider = $this->providermodel->get_provider($v['provider_seq']);
					$v['provider_name']		= $provider['provider_name'];
				}
			}

			// 배송 그룹명 추출
			if	( !$v['shipping_group_name'] ){
				$ship_info = $this->shippingmodel->get_shipping_group($v['shipping_group_seq']);
				$v['shipping_group_name']	= $ship_info['shipping_group_name'];
			}

			$result['record'][$k] = $v;
		}

		if(!$sc['event_status'])		$sc['event_status'] = "all";
		if(!$sc['gift_gb'])				$sc['gift_gb'] = "all";
		if(!$sc['display'])				$sc['display'] = "all";
		if(!$sc['event_view'])			$sc['event_view'] = "all";
		$sc['checkbox']['event_status'][$sc['event_status']]	= "checked";
		$sc['checkbox']['gift_gb'][$sc['gift_gb']]				= "checked";
		$sc['checkbox']['display'][$sc['display']]				= "checked";
		$sc['checkbox']['event_view'][$sc['event_view']]		= "checked";

		$this->template->assign($result);
		$this->template->assign(array('count'=>$count,'sc'=>$sc));

		$provider			= $this->providerInfo;
		$this->template->assign('provider',$provider);

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function gift_regist(){

		$this->load->model('categorymodel');
		$this->admin_menu();
		$this->tempate_modules();
		$this->load->model('goodsdisplay');
		$this->load->model('goodsmodel');
		$this->load->model('providermodel');
		$this->load->model('pagemanagermodel');
		$this->load->model('eventmodel');

		$provider_info['provider_seq']	= $this->providerInfo['provider_seq'];
		$provider_info['provider_name']	= $this->providerInfo['provider_name'];

		$event_seq 	= $_GET['event_seq'];

		if($event_seq){
			$data 				= $this->eventmodel->get_gift($event_seq);
			if($data['gift_gb'] == 'buy' && !$data['goods_rule']) $data['goods_rule'] = 'reserve';
			$data['tpl_path']	= str_replace('etc/','',$data['tpl_path']);
			if($data['provider_seq'] != $provider_info['provider_seq']){
				pageLocation('../event/gift_catalog','다른 입점사의 이벤트 페이지 입니다.');
				exit;
			}

		}
		
		// [반응형스킨] 검색필터 추가 :: 2018-11-01 pjw
		// 검색필터만 값이 없을 경우 기본값을 노출해야 하기때문에 pagemanagermodel 에서 통합 관리함
		$aPageManager			= $this->pagemanagermodel->get_page_config('gift_event');

		$filter_col_tmp 			= $aPageManager['filter_col'];
		$aPageManager['filter_col'] 	= '';
		if($filter_col_tmp){
			$i = 0;
			foreach($filter_col_tmp as $k => $filter_col){
				foreach($filter_col['item'] as $k2 => $v2){
					$aPageManager['filter_col'][$i][$k2] = $v2;
				}
				$i++;
			}
		}

		if( !$data['search_filter'] ){
			$sDefaultSearchFilter	= implode(',', $this->pagemanagermodel->default_filters['gift_event']);
			$data['search_filter'] = $sDefaultSearchFilter;
		}
		if( !$data['search_orderby'] ){
			$data['search_orderby'] = 'rank';
		}

		$gift_gb = $_GET['gb'];
		if($data['gift_gb']){
			$gift_gb = $data['gift_gb'];
		}
		$this->template->assign("gift_gb", $gift_gb);


		if($data['goods_rule']=='goods'){
			$_rows = $this->eventmodel->get_gift_choice($data['gift_seq']);
			foreach ($_rows as $row){
				if(serviceLimit('H_AD')){
					$row['provider_name'] = $provider_lists[$row['provider_seq']]['provider_name'];
				}
				$limit_goods[] = $row;
			}
			if($limit_goods) $this->template->assign('issuegoods',$limit_goods);
		}else if($data['goods_rule']=='category'){
			###
			$this->load->model('categorymodel');
			$this->db->where('gift_seq', $data['gift_seq']);
			$query = $this->db->get('fm_gift_choice');
			foreach ($query->result_array() as $row){
				$row['title'] =  $this->categorymodel->get_category_name($row['category_code']);
				$limit_cate[] = $row;
			}
			if($limit_cate) $this->template->assign('issuecategorys',$limit_cate);
		}

		### 사은품 혜택
		$_benefit_rows = $this->eventmodel->get_gift_benefit($data['gift_seq']);
		switch($data['gift_rule']){
			case 'default':
				$temp = $_benefit_rows;
			$this->template->assign('default',$temp[0]);
			$search = str_replace("|", ",", $temp[0]['gift_goods_seq']);
				if($search == "") $search = "''";
				$lists = $this->eventmodel->get_gift_goods($search);
				if($lists) $this->template->assign('defaultGifts',$lists);
			break;

			case 'price':
			$cnt = 1;
				foreach ($_benefit_rows as $v){
				$search = str_replace("|", ",", $v['gift_goods_seq']);
					if($search == "") $search = "''";
					$lists = $this->eventmodel->get_gift_goods($search);
					$v['gifts']		= $lists;
				$v['num']		= $cnt;
				$priceLoop[]	= $v;
				$cnt++;
			}
			$this->template->assign('priceLoop',$priceLoop);
			break;

			case 'quantity':
				foreach ($_benefit_rows as $v){
				$gift_goods_seq = $v['gift_goods_seq'];
				$qtyLoop[] = $v;
			}
			$this->template->assign('qtyLoop',$qtyLoop);

			$search = str_replace("|", ",", $gift_goods_seq);
				if($search == "") $search = "''";
				$lists = $this->eventmodel->get_gift_goods($search);
				if($lists) $this->template->assign('qtyGifts',$lists);
			break;
			case 'lot':
				foreach ($_benefit_rows as $v){
				$gift_goods_seq = $v['gift_goods_seq'];
				$lotLoop[] = $v;
			}
			$this->template->assign('lotLoop',$lotLoop);

			$search = str_replace("|", ",", $gift_goods_seq);
				if($search == "") $search = "''";
				$lists = $this->eventmodel->get_gift_goods($search);
				if($lists) $this->template->assign('lotGifts',$lists);
			break;
		}


		/* 샘플 상품 정보 */
		$sampleGoodsInfo = array(
			'goods_name' => '샘플 상품',
			'price' => '19800',
			'consumer_price' => '24800',
		);

		$styles = array();
		foreach($this->goodsdisplay->styles as $k=>$v)
		{
			if(in_array($k,array('lattice_a','lattice_b','list'))){
				$styles[$k]=$v;
			}
		}

		/* 리스트 이미지 꾸미기 값 파싱 */
		$list_image_decorations = $this->goodsdisplay->decode_image_decorations($data['list_image_decorations']);

		// 수정인 경우 배송그룹 조회 :: 2016-11-08 lwh
		if($data['shipping_group_seq']){
			$this->load->model('shippingmodel');
			$ship_grp_list = $this->shippingmodel->get_shipping_group_simple($data['provider_seq']);
			$this->template->assign("ship_grp_list",$ship_grp_list);
		}else if($provider_info['provider_seq']){
			$this->load->model('shippingmodel');
			$ship_grp_list = $this->shippingmodel->get_shipping_group_simple($provider_info['provider_seq']);
			$this->template->assign("ship_grp_list",$ship_grp_list);
		}

		$this->template->assign(array(
			'styles'						=> $styles,
			'orders'						=> $this->goodsdisplay->orders,
			'goodsImageSizes'				=> config_load('goodsImageSize'),
			'list_image_decorations'		=> $list_image_decorations,
			'sampleGoodsInfo'				=> $sampleGoodsInfo,
			'mode'							=> $_GET['mode'],
		));
		if($provider_info){
			$this->template->assign("provider_info",$provider_info);
		}else{
			$this->template->assign("provider",$provider);
		}

		$this->template->assign("event",$data);
		$this->template->assign(array('snsevent' => 'event'));

		### [반응형스킨] 운영방식 추가 :: 2018-11-01 pjw
		$operation_type = !empty($this->config_system['operation_type']) ? $this->config_system['operation_type'] : 'heavy';
		$this->template->assign('operation_type', $operation_type);

		// 상품정보 선택기능 추가 :: 2019-05-17 pjw
		$this->load->model('designmodel');
		$goods_info_style = $this->designmodel->get_goods_info_style('search_list', $data['goods_info_style']);
		
		$this->template->assign('goods_info_style', $goods_info_style);
		$this->template->define('goods_info_style', $this->skin.'/page_manager/_goods_info_style.html');
		

		// 이벤트 페이지 레이아웃 rowspan 계산 추가 :: 2018-11-01 pjw
		$rowspan = 3;
		if($data['event_seq'] > 0)		$rowspan++;
		if($operation_type == 'light')	$rowspan = $rowspan + 6;
		$this->template->assign('rowspan', $rowspan);

		$file_path	= $this->template_path();
		$this->template->assign("aPageManager", $aPageManager);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function gift_view(){
		$this->load->model('categorymodel');
		$this->admin_menu();
		$this->tempate_modules();
		$this->load->model('goodsdisplay');
		$this->load->model('providermodel');

		$event_seq = $_GET['event_seq'];
		$query = $this->db->query("select * ,
		if(current_date() between start_date and end_date,'진행 중',if(end_date < current_date(),'종료','시작 전')) as status
		from fm_gift where gift_seq=?",$event_seq);
		$data = $query->row_array();


		if	($data['provider_list']){
			$provider_list	= substr(substr($data['provider_list'], 1), 0, -1);
			$provider_arr	= explode('|', $provider_list);
			if	(count($provider_arr) > 0){
				$provider_select_list	= $this->providermodel->get_provider_range($provider_arr);
				if	($provider_select_list){
					foreach($provider_select_list as $k => $provider_data){
						if	($k > 0)	$provider_name_list	.= '<br />';
						$provider_name_list	.= $provider_data['provider_name'];
					}
				}
			}

			$data['provider_name_list']	= $provider_name_list;
		}

		$gift_gb = $_GET['gb'];
		if($data['gift_gb']){
			$gift_gb = $data['gift_gb'];
		}
		$this->template->assign("gift_gb", $gift_gb);


		if($data['goods_rule']=='goods'){
			$sql = "SELECT
						distinct A.*, B.*
					FROM
						fm_gift_choice A
						LEFT JOIN
						(SELECT
							g.goods_seq, g.goods_name, o.price
						FROM
							fm_goods g LEFT JOIN fm_goods_option o ON g.goods_seq = o.goods_seq AND o.default_option = 'y') B ON A.goods_seq = B.goods_seq
					WHERE
						A.gift_seq = '{$data['gift_seq']}'";
			$query = $this->db->query($sql);
			foreach ($query->result_array() as $row){
				$limit_goods[] = $row;
			}
			if($limit_goods) $this->template->assign('issuegoods',$limit_goods);
		}else if($data['goods_rule']=='category'){
			###
			$this->load->model('categorymodel');
			$this->db->where('gift_seq', $data['gift_seq']);
			$query = $this->db->get('fm_gift_choice');
			foreach ($query->result_array() as $row){
				$row['title'] =  $this->categorymodel->get_category_name($row['category_code']);
				$limit_cate[] = $row;
			}
			if($limit_cate) $this->template->assign('issuecategorys',$limit_cate);
		}


		###
		$sql = "select * from fm_gift_benefit where gift_seq = '{$data['gift_seq']}'";
		$query = $this->db->query($sql);
		if($data['gift_rule']=='default'){
			$temp = $query->result_array();
			$this->template->assign('default',$temp[0]);
			$search = str_replace("|", ",", $temp[0]['gift_goods_seq']);
			if($search == ""){
				$search = "''";
			}
			$sql = "SELECT
						g.goods_seq, g.goods_name, o.price
					FROM
						fm_goods g LEFT JOIN fm_goods_option o ON g.goods_seq = o.goods_seq AND o.default_option = 'y'
					WHERE
						g.goods_seq in ($search)";
			$query = $this->db->query($sql);
			foreach ($query->result_array() as $row){
				$defaultGifts[] = $row;
			}
			if($defaultGifts) $this->template->assign('defaultGifts',$defaultGifts);
		}else if($data['gift_rule']=='price'){
			$cnt = 1;
			foreach ($query->result_array() as $v){
				$search = str_replace("|", ",", $v['gift_goods_seq']);
				if($search == ""){
					$search = "''";
				}
				$sql = "SELECT
							g.goods_seq, g.goods_name, o.price
						FROM
							fm_goods g LEFT JOIN fm_goods_option o ON g.goods_seq = o.goods_seq AND o.default_option = 'y'
						WHERE
							g.goods_seq in ($search)";
				$query = $this->db->query($sql);
				unset($temps);
				foreach ($query->result_array() as $row){
					$temps[] = $row;
				}
				$v['gifts']		= $temps;
				$v['num']		= $cnt;
				$priceLoop[]	= $v;
				$cnt++;
			}
			$this->template->assign('priceLoop',$priceLoop);
		}else if($data['gift_rule']=='quantity'){
			foreach ($query->result_array() as $v){
				$gift_goods_seq = $v['gift_goods_seq'];
				$qtyLoop[] = $v;
			}
			$this->template->assign('qtyLoop',$qtyLoop);

			$search = str_replace("|", ",", $gift_goods_seq);
			if($search == ""){
				$search = "''";
			}

			$sql = "SELECT
						g.goods_seq, g.goods_name, o.price
					FROM
						fm_goods g LEFT JOIN fm_goods_option o ON g.goods_seq = o.goods_seq AND o.default_option = 'y'
					WHERE
						g.goods_seq in ($search)";
			$query = $this->db->query($sql);
			foreach ($query->result_array() as $row){
				$qtyGifts[] = $row;
			}
			if($qtyGifts) $this->template->assign('qtyGifts',$qtyGifts);
		}else if($data['gift_rule']=='lot'){
			foreach ($query->result_array() as $v){
				$gift_goods_seq = $v['gift_goods_seq'];
				$lotLoop[] = $v;
			}
			$this->template->assign('lotLoop',$lotLoop);

			$search = str_replace("|", ",", $gift_goods_seq);
			if($search == ""){
				$search = "''";
			}

			$sql = "SELECT
						g.goods_seq, g.goods_name, o.price
					FROM
						fm_goods g LEFT JOIN fm_goods_option o ON g.goods_seq = o.goods_seq AND o.default_option = 'y'
					WHERE
						g.goods_seq in ($search)";
			$query = $this->db->query($sql);
			foreach ($query->result_array() as $row){
				$lotGifts[] = $row;
			}
			if($lotGifts) $this->template->assign('lotGifts',$lotGifts);
		}


		/* 샘플 상품 정보 */
		$sampleGoodsInfo = array(
			'goods_name' => '샘플 상품',
			'price' => '19800',
			'consumer_price' => '24800',
		);

		$styles = array();
		foreach($this->goodsdisplay->styles as $k=>$v)
		{
			if(in_array($k,array('lattice_a','lattice_b','list'))){
				$styles[$k]=$v;
			}
		}

		/* 리스트 이미지 꾸미기 값 파싱 */
		$list_image_decorations = $this->goodsdisplay->decode_image_decorations($data['list_image_decorations']);


		$this->template->assign(array(
			'styles'						=> $styles,
			'orders'						=> $this->goodsdisplay->orders,
			'goodsImageSizes'				=> config_load('goodsImageSize'),
			'list_image_decorations'		=> $list_image_decorations,
			'sampleGoodsInfo'				=> $sampleGoodsInfo
		));

		$this->template->assign("event",$data);
		$this->template->assign(array('snsevent' => 'event'));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	## 사은품 지급 상세 로그  2015-05-14 pjm
	public function gift_use_log(){

		$this->load->model('giftmodel');

		$giftlog = $this->giftmodel->get_gift_order_log($_POST['order_seq'],$_POST['item_seq']);

		$this->template->assign(array('giftlog'	=> $giftlog[0]));

		$file_path = dirname($this->template_path()).'/../event/gift_use_log.html';
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}
}

/* End of file event.php */
/* Location: ./app/controllers/admin/event.php */