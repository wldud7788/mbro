<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class mshop extends front_base {

	function __construct() {
		parent::__construct();

		$this->load->model('usedmodel');
		$this->load->library('validation');

		### SERVICE CHECK
		$result = $this->usedmodel->used_service_check('minishop');
		if(!$result['type']){
			pageRedirect("/main/index","입점몰+ Lite에서는 미니샵을 이용하실 수 없습니다.");
			exit;
		}

	}

	public function index() {
		$aGetParams = $this->input->get();

		// validation
		if ($aGetParams) {
			$this->validation->set_data($aGetParams);
			$this->validation->set_rules('m', '일련번호', 'trim|numeric|xss_clean');
			$this->validation->set_rules('code', '코드', 'trim|numeric|xss_clean');
			$this->validation->set_rules('category_code', '카테고리', 'trim|string|xss_clean');
			$this->validation->set_rules('display_style', '스타일', 'trim|string|xss_clean');
			$this->validation->set_rules('sort', '정렬', 'trim|string|xss_clean');
			if ($this->validation->exec() === false) {
				show_error($this->validation->error_array['value']);
			}
		}

		if($this->config_system['operation_type']=='light'){
			$this->_index_light();
		}else{
			$this->_index_heavy();
		}
	}

	protected function _index_light() {
		$this->load->model('goodslistmodel');
		$this->load->model('categorymodel');
		$this->load->model('brandmodel');
		$this->load->model('locationmodel');
		$this->load->model('myminishopmodel');
		$this->load->model('goodsmodel');
		$this->load->library('validation');
		$aDeliveryCodes	= code_load('searchDelivery');
		$aPerpageCodes	= code_load('searchPerpage');
		foreach($aPerpageCodes as $aData) $aDefaultPerpages[]	= $aData['value'];

		$aParams	= $this->input->get();
		$aParams['sRequestUri']	= $_SERVER['REQUEST_URI'];
		$chk		= 'n';
		$sMemberSeq = '';

		if($aParams['m']){
			$aParams['provider']	= $aParams['m'];
		}

		/* 판매자 정보 */
		if( $aParams['provider'] ){
			$aProvider	= $this->myminishopmodel->getProvider($aParams['provider']);
		}

		/* 필터 사용 */
		$this->goodslistmodel->getFilterConfig('mshop', $aProvider);
		$aFilterConfig	= $this->goodslistmodel->aFilterConfig;

		if(!$aParams['page'])		$aParams['page']	= 1;
		if(!$aParams['sorting'])	$aParams['sorting']	= $aFilterConfig['orderby'];
		if(!in_array($aParams['per'], $aDefaultPerpages))	$aParams['per']	= 40;

		/* 카테고리 정보 */
		if( $aParams['category'] ){
			$aCategoryData	= $this->categorymodel->get_category_data(str_replace('c', '', $aParams['category']));
		}
		/* 브랜드 정보 */
		if( $aParams['brand'][0] ){
			$sBrand		= str_replace('b', '', $aParams['brand'][0]);
			foreach($aParams['brand'] as $sDataBrands){
				$sDataBrands				= str_replace('b', '', $sDataBrands);
				$aBrandInfo[$sDataBrands]	= $this->brandmodel->get_brand_data($sDataBrands);
			}
			if( $sBrand ){
				$aBrandData	= $aBrandInfo[$sBrand];
			}
		}
		/* 지역 정보 */
		if( $aParams['location'] ){
			$locationData	= $this->locationmodel->get_location_data(str_replace('l', '', $aParams['location']));
		}

		if($this->userInfo['member_seq']){
			$sMemberSeq = $this->userInfo['member_seq'];
			$chk		= $this->myminishopmodel->chk_myminishop($sMemberSeq, $aProvider['provider_seq']);
		}
		$aProvider['thisshop'] = $chk;
		$sCategory	= str_replace('c', '', $aParams['category']);
		$aCategorys	= $this->categorymodel->split_category($sCategory);

		foreach($aParams['brand'] as $sDataBrands){
			$aBrands[] = str_replace('b', '', $sDataBrands);
		}

		// url에 따른 code값 정의
		$aSearch['platform'] = 'P';
		$aSearch['provider'] = $aParams['provider'];
		if( $this->mobileMode || $this->_is_mobile_agent ){
			$aSearch['platform']	= 'M';
		}

		// 검색조건의 상품번호 추출
		if( $aSearch['provider'] ){
			$sGoodsQuery	= $this->goodslistmodel->queryBuild($aSearch, 'mshop');
		}
		$iTotcount	= $this->goodslistmodel->goodsListTotal($sGoodsQuery);

		// 상품에 해당 하는 필터 로딩
		$aCategorys	= $this->goodslistmodel->categorysForFilter($sGoodsQuery, '', 'search');

		if($aFilterConfig['brand']){
			$aBrands	= $this->goodslistmodel->brandsForFilter($sGoodsQuery, 'mshop');
		}
		if($aFilterConfig['color']){
			$aColors	= $this->goodslistmodel->colorsForFilter($sGoodsQuery);
		}

		$aDeliverys	= $this->goodslistmodel->deliverysForFilter($sGoodsQuery, $aDeliveryCodes, $aFilterConfig);

		if( $aFilterConfig['price'] ){
			$aMaxPrice	= $this->goodslistmodel->maxGoodsPriceFilter($sGoodsQuery);
		}

		// light 일 경우 추천상품 데이터 추가 :: 2019-01-22 pjw
		$providerRecommendGoodsList = $this->goodsmodel->get_mshop_auto_goodslist($aProvider['provider_seq']);

		$this->template->assign('categoryData',						$aCategoryData);
		$this->template->assign('brandData',						$aBrandData);
		$this->template->assign('aBrandInfo',						$aBrandInfo);
		$this->template->assign('locationData',						$locationData);
		$this->template->assign('aProvider',						$aProvider);
		$this->template->assign('member_seq',						$sMemberSeq);
		$this->template->assign('filterNaviCategoryList',			$aNaviCategorys);
		$this->template->assign('filterCategoryList',				$aCategorys);
		$this->template->assign('filterBrandList',					$aBrands);
		$this->template->assign('filterProviderList',				$aProviders);
		$this->template->assign('filterDelvieryCodes',				$aDeliverys);
		$this->template->assign('filterColors',						$aColors);
		$this->template->assign('filterMaxPrice',					$aMaxPrice);
		$this->template->assign('totcount',							$iTotcount);
		$this->template->assign('params',							$aParams);
		$this->template->assign('skin',								$this->skin);
		$this->template->assign('aFilterConfig',					$aFilterConfig);
		$this->template->assign('providerRecommendGoodsList',		$providerRecommendGoodsList);
		$this->print_layout($this->template_path());
		echo("<script>var gl_searchFilterUse = '".$aFilterConfig['searchFilterUse']."';</script>");
	}

	protected function _index_heavy() {

		$this->load->model('membermodel');
		$this->load->model('goodsmodel');
		$this->load->model('goodsdisplay');
		$this->load->model('providermodel');
		$this->load->model('categorymodel');
		$this->load->model('brandmodel');

		$_GET['display_style']	= chk_parameter_xss_clean($_GET['display_style']);

		// 로그인 정보
		$ss					= $this->userInfo;
		$ss['return_url']	= $_SERVER['REQUEST_URI'];
		$this->template->assign(array('ss'=>$ss));

		if(!$_GET['code']) $_GET['code'] = $_GET['m'];
		if(!$_GET['m']) $_GET['m'] = $_GET['code'];

		// PARAM 및 입점사 정보
		$m				= isset($_GET['m'])		? preg_replace("/[^0-9]/i","",$_GET['m']) : 1;
		$sort			= isset($_GET['sort'])	? $_GET['sort'] : '';

		$provider		= $this->providermodel->get_provider($m);
		if	($provider['main_visual'] && !file_exists(ROOTPATH . $provider['main_visual'])){
			$provider['main_visual']	= '';
			$provider['main_visual_mobile']	= '';
		}else{

			$org_main_visual = end(explode('/', $provider['main_visual']));
			$org_mobile_visual = str_replace('/'.$org_main_visual,'/_mobile_'.$org_main_visual,$provider['main_visual']);
			$provider['main_visual_mobile']	= $org_mobile_visual;
		}
		$this->template->assign(array('pv'=>$provider));

		if($provider['provider_status']!='Y') pageLocation('/main/index','접근권한이 없습니다');

		//
		if	($this->userInfo['member_seq']){

		$this->load->model('myminishopmodel');
			$chk_this_shop	= $this->myminishopmodel->chk_myminishop($this->userInfo['member_seq'], $m);
			$myshop			= $this->myminishopmodel->get_myminishop($this->userInfo['member_seq']);
			$this->template->assign(array('thisshop'=>$chk_this_shop));
			$this->template->assign(array('my'=>$myshop));
		}

		/* 카테고리 브랜드 정보 */
		//$mainCategory	= $this->categorymodel->get_category_data('');

		if( $this->mobileMode || $this->storemobileMode ){
			$display_ins_arr = $this->goodsmodel->get_goods_display_insert('mobile','모바일 미니샵리스트','mshop');
			$display = $display_ins_arr['display'];
		}else{
			$display_ins_arr = $this->goodsmodel->get_goods_display_insert('pc','미니샵리스트','mshop');
			$display = $display_ins_arr['display'];

			// 검색페이지는 기본 리스팅스타일이 list형이므로, lattice_a로 변경했을 때 최소 가로개수를 4개로 지정해줌
			if($display['style']!='lattice_a' && $_GET['display_style']=='lattice_a' && $display['count_w']<3){
				$display['count_w'] = 4;
			}
		}

		$perpage = $_GET['perpage'] ? $_GET['perpage'] : $display['count_w'] * $display['count_h'];
		$perpage = $perpage ? $perpage : 10;
		$list_default_sort = $display['default_sort'] ? $display['default_sort'] : 'popular';

		$perpage_min = $display['count_w']*$display['count_h'];
		if($perpage != $display['count_w']*$display['count_h']){
			$display['count_h'] = ceil($perpage/$display['count_w']);
		}

		/**
		 * list setting
		**/
		$sc=array();
		$sc['sort']				= $sort ? $sort : $list_default_sort;
		$sc['page']				= (!empty($_GET['page'])) ?		intval($_GET['page']):'1';
		$sc['perpage']			= $perpage ? $perpage : 10;
		$sc['image_size']		= $display['image_size'];
		$sc['list_style']		= $_GET['display_style'] ? $_GET['display_style'] : $display['style'];
		if( $this->mobileMode || $this->storemobileMode ){
			if(!preg_match("/^mobile/",$sc['list_style']))
				$sc['list_style']= "mobile_".$sc['list_style'];
		}else{
			$sc['list_style']	= preg_replace("/^mobile_/","",$sc['list_style']);
		}

		$sc['list_goods_status']= $display['goods_status'];

		$sc['provider_seq']		= $m;
		$sc['category_code']	= !empty($_GET['category_code'])		? $_GET['category_code'] : $code;
		$sc['brands']			= !empty($_GET['brands'])		? $_GET['brands'] : array();
		$sc['brand_code']		= !empty($_GET['brand_code'])	? $_GET['brand_code'] : '';
		$sc['search_text']		= !empty($_GET['search_text'])	? $_GET['search_text'] : '';
		$sc['old_search_text']	= !empty($_GET['old_search_text'])	? $_GET['old_search_text'] : '';
		$sc['start_price']		= !empty($_GET['start_price'])	? $_GET['start_price'] : '';
		$sc['end_price']		= !empty($_GET['end_price'])	? $_GET['end_price'] : '';
		$sc['color']			= !empty($_GET['color'])		? $_GET['color'] : '';

		$list	= $this->goodsmodel->goods_list($sc);
		$this->template->assign($list);

		/**
		 * display
		**/
		$this->goodsdisplay->set('platform',$display['platform']);
		$this->goodsdisplay->set('style',$sc['list_style']);
		$this->goodsdisplay->set('count_w',$display['count_w']);
		$this->goodsdisplay->set('count_w_lattice_b',$display['count_w_lattice_b']);
		$this->goodsdisplay->set('kind', $display['kind']);
		//$this->goodsdisplay->set('perpage',$perpage);
		//$this->goodsdisplay->set('navigation_paging_style', $display['navigation_paging_style']);
		if($perpage){
			$this->goodsdisplay->set('count_h',ceil($perpage/$display['count_w']));
		}else{
			$this->goodsdisplay->set('count_h',$display['count_h']);
		}
		$display_key = $this->goodsdisplay->make_display_key();

		$this->goodsdisplay->set('image_decorations',$display['image_decorations']);
		$this->goodsdisplay->set('image_size',$display['image_size']);
		$this->goodsdisplay->set('text_align',$display['text_align']);
		$this->goodsdisplay->set('info_settings',$display['info_settings']);
		$this->goodsdisplay->set('display_key',$display_key);
		$this->goodsdisplay->set('displayTitle',$display['title']);
		$this->goodsdisplay->set('title',$display['title']);
		$this->goodsdisplay->set('APP_USE',$this->__APP_USE__);
		$this->goodsdisplay->set('mobile_h',$display['mobile_h']);
		$this->goodsdisplay->set('m_list_use',$display['m_list_use']);
		$this->goodsdisplay->set('img_optimize',$display['img_opt_lattice_a']);
		$this->goodsdisplay->set('img_opt_lattice_a',$display['img_opt_lattice_a']);
		$this->goodsdisplay->set('img_padding',$display['img_padding_lattice_a']);
		$this->goodsdisplay->set('count_h_lattice_b',$display['list_count_h_lattice_b']);
		$this->goodsdisplay->set('count_h_list',$display['list_count_h_list']);
		$this->goodsdisplay->set('displayTabsList',array($list));
		$this->goodsdisplay->set('displayGoodsList',!empty($list['record'])?$list['record']:array());
		if(!$this->fammerceMode){
			$this->goodsdisplay->set('target','_blank');
		}
		$goodsDisplayHTML = "<div id='{$display_key}' class='designMshopGoodsDisplay' designElement='mshopGoodsDisplay' displaySeq='{$display['display_seq']}'>";
		$goodsDisplayHTML .= $this->goodsdisplay->print_(true);
		$goodsDisplayHTML .= "</div>";

		$tmpGET = $_GET;
		unset($tmpGET['sort']);
		unset($tmpGET['page']);
		$sortUrlQuerystring = getLinkFilter('',array_keys($tmpGET));

		$orders = $this->goodsdisplay->orders;
		unset($orders['popular']);

		/* 카테고리 정보 */
		$code = isset($_GET['category_code']) ? $_GET['category_code'] : '';
		$categoryData = $this->categorymodel->get_category_data($code);
		$code = $categoryData['category_code'];
		if(strlen($code)>4 ){
			$categoryCodeParent = substr($code,0,strlen($code)-4);
		}
		$this->template->assign(array(
			'categoryCodeParent'			=> $categoryCodeParent,
			'categoryCode'			=> $code,
			'categoryTitle'			=> $categoryData['title'],
			'categoryData'			=> $categoryData,
		));

		$this->template->assign(array(
			'goodsDisplayHTML'		=> $goodsDisplayHTML,
			'sortUrlQuerystring'	=> $sortUrlQuerystring,
			'sort'					=> $sc['sort'],
			'sc'					=> $sc,
			'orders'				=> $this->goodsdisplay->orders,
			'perpage_min'			=> $perpage_min,
			'list_style'			=> $sc['list_style'],
			'providerinfo'					=> $provider,
		));

		if($_GET['ajax']){
			echo $goodsDisplayHTML;
		}else{
			$this->print_layout($this->template_path());
		}
	}

}