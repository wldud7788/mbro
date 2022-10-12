<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class brand extends admin_base {

	public function __construct() {
		parent::__construct();
		$auth = $this->authmodel->manager_limit_act('goods_view');
		if(!$auth){
			pageBack("권한이 없습니다.");
			exit;
		}
	}

	public function index()
	{
		redirect("/admin/brand/catalog");
	}

	public function catalog()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		$design_ex 	= "1. EYE-DESIGN 환경으로 이동하세요.<br/>2. EYE-DESIGN을 ON하세요.<br/>3. 브랜드 영역을 클릭하세요.<br/>4. 브랜드 디자인 스타일(가로형, 세로형)을 선택하세요.<br/>※ HTML편집으로 세부 디자인을 수정할 수도 있습니다.";
		$this->template->assign(array('brand_design_ex'=>$design_ex));
		$this->template->define(array('tpl'=>$file_path));

		$this->load->model('brandmodel');

		$firstData = $this->brandmodel->get_brand_depth_list(1,'',1);
		foreach($firstData as $key=>$data){ if($firstCode) continue; $firstCode = $key; }

		$categoryDefault = array(
			'pageId'				=> 'brand',
			'pageTitle'				=> '브랜드',
			'getSettingInfo'    	=> '/admin/brand/ifrm_brand_info',
			'getSettingDesign'  	=> '/admin/brand/ifrm_brand_design',
			'mode'					=> 'info',
			'categoryCode'			=> $firstCode,
			'skinType'				=> $this->config_system['operation_type']
		);
		$this->template->assign('categoryDefault',json_encode($categoryDefault));

		// 웹FTP 템플릿 define
		$this->template->define(array('webftp'=>$this->skin.'/webftp/_webftp.html'));
		$this->template->define(array('mini_webftp'=>$this->skin.'/webftp/_mini_webftp.html'));

		$this->template->print_("tpl");
	}

	public function ifrm_brand_info(){
		$this->tempate_modules();
		$this->load->model('brandmodel');

		$categoryCode = $_GET['categoryCode'];

		$categoryData = $this->brandmodel->get_brand_data($categoryCode);

		$categoryData['parentcodetext'] = $this->brandmodel->get_brand_goods_code($categoryCode,'modify');

		$brandInfo = $this->brandmodel->get_brand_info($categoryCode);

		// 접속자 제한 부분 :: START 2018-12-26 lwh
		$access_limit = $this->brandmodel->get_brand_group_for_member($categoryCode);
		$grp_name			= array();
		$user_type			= array();
		$access_limit_arr	= array();
		foreach($access_limit as $k => $info){
			if($info['group_name'])		$grp_name[]		= $info['group_name'];
			if($info['user_type'])		$user_type[]	= ($info['user_type'] == 'business') ? '기업' : '개인';
		}

		if(count($grp_name) > 0 || count($user_type) > 0){
			if(count($grp_name) > 0){
				$access_limit_arr[]	= implode(',', $grp_name);
			}
			if(count($user_type) > 0){
				$access_limit_arr[]	= implode(',', $user_type);
			}
			$access_limit_txt = implode(' | ', $access_limit_arr);
		}else{
			$access_limit_txt = '모든 사용자';
		}
		$this->template->assign(array('access_limit_txt'=>$access_limit_txt));
		// 접속자 제한 부분 :: END

		/* 회원 그룹 개발시 변경*/
		$groups = "";
		$query = $this->db->query("select group_seq,group_name from fm_member_group");
		foreach($query->result_array() as $row){
			$groups[] = $row;
		}
		/******************/

		/* 브랜드 국가 관련 */
		$this->load->model("brandcountrymodel");
		$brandCountry = $this->brandcountrymodel->_select_list();
		// 브랜드 종류(그룹)
		$categoryData["classification"] = unserialize($categoryData["classification"]);
		// 브랜드 국가
		foreach($brandCountry as $country) {
			if($country["seq"] === $categoryData["country_seq"]) {
				$categoryData["country"] = $country;
				break;
			}
		}

		$this->template->assign(array('operation_type'=>$this->config_system['operation_type']));
		$this->template->assign(array('country'=>$brandCountry));
		$this->template->assign(array('groups'=>$groups));
		$this->template->assign(array('categoryCode'=>$categoryCode));
		$this->template->assign(array('categoryData'=>$categoryData));
		$this->template->assign(array('brandInfo'=>$brandInfo));
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	public function ifrm_brand_design(){
		$this->tempate_modules();
		$this->load->model('goodsdisplay');
		$this->load->model('brandmodel');
		$categoryCode = $_GET['categoryCode'];

		$categoryData = $this->brandmodel->get_brand_data($categoryCode);

		$this->template->assign(array(
			'categoryData'					=> $categoryData,
			'categoryCode'					=> $categoryCode
		));
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	public function tree(){
		set_time_limit(0);
		error_reporting(E_ERROR|E_PARSE);
		header("HTTP/1.0 200 OK");
		header('Content-type: application/json; charset=utf-8');
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Pragma: no-cache");
		$aDisplaySeqs	= array();
		$db_config = array(
			"servername" => $this->db->hostname,
			"username" => $this->db->username,
			"password" => $this->db->password,
			"database" => $this->db->database
		);
		if ($this->db->port) {
			$db_config['serverport'] = $this->db->port;
		}

		require_once(APPPATH."/javascript/plugin/jstree/_tree/_inc/class._database.php");
		require_once(APPPATH."/javascript/plugin/jstree/_tree/_inc/class.tree.php");

		$jstree = new json_tree('fm_brand', array('category_code'=>'category_code'));
		$jstree->jstreedb = new _database($db_config);

		if(isset($_POST['operation'])){
			$operation	= $_POST['operation'];
			$_POST['title'] = trim($_POST['title']);
			$params		= $_POST;
		}else if(isset($_GET['operation'])){
			$operation	= $_GET['operation'];
			$params		= $_GET;
		}

		/* 관리자 권한 체크 : 시작 */
		if($operation != 'get_children'){
			$auth = $this->authmodel->manager_limit_act('goods_act');
			if( !$auth ){
				echo "{ \"status\" : 0, \"msg\" : \"관리자 권한이 없습니다.\" }";
				die();
			}
		}
		/* 관리자 권한 체크 : 끝 */

		$result	= false;
		$jstree->jstreedb->trans_begin();

		if( $operation=='rename' || $operation=='remove_node' || ($operation=='move_node' && $params['copy']==0) ){
			$data_ori				= $jstree->_get_node($params['id']);
			$sOriCategoryCode		= $data_ori['category_code'];
		}
		if( $operation=='move_node' && $params['copy']==0 ){
			$aOriCategoryCodes	= $jstree->_get_child_code($sOriCategoryCode);
			if(!$aOriCategoryCodes){
				$jstree->jstreedb->trans_rollback();
				die();
			}
		}
		if( $operation=='remove_node' ){
			$aDisplaySeqs	= $jstree->get_display_seq($sOriCategoryCode);
		}

		if( isset($operation) && strpos($operation, "_") !== 0 && method_exists($jstree, $operation) ) {
			$result			= $jstree->{$operation}($params);
		}

		$result_etc	= true;
		if( $result && $operation=='move_node' && $params['copy']==0 ){
			$obj	= json_decode($result);
			if( $obj->category_code && $obj->category_code != $sOriCategoryCode  ){
				$link_cnt	= $jstree->_get_link_cnt($sOriCategoryCode);
				if( $link_cnt > 10000 ){
					$jstree->jstreedb->trans_rollback();
					echo "{ \"status\" : 0, \"msg\" : \"연결한 상품수 10,000개 이상 입니다.. \\n이동하시려면 고객센터로 연락하시기 바랍니다.\" }";
					die();
				}
				$aNewCategoryCodes			= $jstree->_get_child_code($obj->category_code);
				$result_etc					= $jstree->etc_move_node($aOriCategoryCodes, $aNewCategoryCodes);
			}
		}
		if( $operation=='remove_node' && !empty($sOriCategoryCode) ){
			$result_etc					= $jstree->etc_remove_node($sOriCategoryCode, $aDisplaySeqs);
		}
		if( $operation=='rename' ){
			// 할인혜택 금액 저장
			$this->load->model('goodssummarymodel');
			$this->goodssummarymodel->set_event_price(array('brand'=>array($sOriCategoryCode)));
		}
		if( $result && $result_etc ){
			$jstree->jstreedb->trans_commit();
			echo $result;
		}else{
			$jstree->jstreedb->trans_rollback();
			echo "{ \"status\" : 0, \"msg\" : \"".$jstree->m_sMsg."\" }";
		}
	}

	public function view(){
		// 카테고리 코드
		$category = $this->input->post('category');

		// 카테고리 그룹
		$query = "select a.group_seq,b.group_name from fm_brand_group a,fm_member_group b where a.group_seq=b.group_seq and  a.category_code='$category'";
		$query = $this->db->query($query);
		foreach($query->result_array() as $row){
			$groups[] = $row;
		}

		// 카테고리 타입
		$types = array();
		$query = "select * from fm_brand_group where group_seq is null and  category_code='$category' and user_type != ''";
		$query = $this->db->query($query);
		foreach($query->result_array() as $row){
			$types[] = $row;
		}

		// 카테고리 하위포함 상품 수
		$query = "select count(distinct a.goods_seq) cnt from fm_brand_link as a inner join fm_goods as b on a.goods_seq = b.goods_seq where a.category_code like '{$category}%'";
		$query = $this->db->query($query);
		$tmp = $query->row_array();
		$cnt = $tmp['cnt'];

		// [반응형스킨] light 버전 추가 및 데이터 가공 추가 :: 2018-12-03 pjw
		$this->load->model('pagemanagermodel');
		$operation_type				 = $this->config_system['operation_type'];
		$recommend_data				 = $this->pagemanagermodel->get_recommend_list($operation_type, 'brand', $category);
		$recommend_data				 = $recommend_data[0];
		$category_config			 = $this->pagemanagermodel->get_page_config('brand');

		// 카테고리 정보
		$query = "select * from fm_brand where category_code ='{$category}'";
		$query = $this->db->query($query);
		foreach($query->result_array() as $row){
			$row['top_html'] = $row['top_html'] == '<p><br></p>' ? '' : $row['top_html'];
			$row['goodsCnt'] = $cnt;
			$row['types'] = $types;
			if($row['category_code'] == $category && isset($groups)){
				$row['groups'] = $groups;
			}

			$row['auto_criteria_desc'] = $recommend_data['auto_criteria_desc'];

			// 사용여부 결정 :: 2018-12-27 lwh
			$row['use_search_filter']  = ($category_config['filter_cnt'] == 0) ? 'N' : 'Y';

			// 검색필터 상세 값 정의 :: 2018-12-27 lwh
			if($row['use_search_filter'] == 'Y') foreach($category_config['filter_col'] as $k => $column){
				foreach($column['item'] as $filter_code => $filter_nm){
					if(array_search($filter_code, $category_config['search_filter']) !== false){
						$category_config['search_filter_arr'][$filter_code] = $filter_nm;
					}
				}
			}
			$row['set_search_filter'] = implode(', ', $category_config['search_filter_arr']);

			$result[] = $row;
		}

		echo json_encode($result);
	}

	/* 카테고리에 속한 상품 목록(순서정렬에 사용) */
	public function get_category_goods_list(){

		$this->load->model('goodsmodel');
		$this->load->model('brandmodel');

		$categoryCode = $_GET['categoryCode'];
		$page = $_GET['page'] ? $_GET['page'] : 1;
		$perpage = $_GET['perpage'] ? (int)$_GET['perpage'] : 10;

		$categoryData = $this->brandmodel->get_brand_data($categoryCode);

		$result = array(
			'totalCnt' => 0,
			'goods' => array()
		);

		$sc=array();
		$sc['sort']				= 'popular';
		$sc['page']				= $page;
		$sc['search_text']		= '';
		$sc['brand']			= $categoryCode;
		$sc['perpage']			= $perpage;
		$sc['image_size']		= $categoryData['list_image_size'];
		$sc['get_goods_stock']	= true;
		$list	= $this->goodsmodel->goods_list($sc);
		$result['goods'] = $list['record'];
		$result['page']			= $page;
		$result['perpage']		= $perpage;
		$result['totalCnt']		= $list['page']['totalcount'];
		$result['paging']		= pagingtagjs($page, $list['page']['page'], $list['page']['totalpage'], 'show_next_sortgoods([:PAGE:])');

		echo json_encode($result);
	}

	/* 브랜드페이지 한꺼번에 꾸미기 */
	public function batch_design_setting(){
		$this->admin_menu();
		$this->tempate_modules();

		$this->load->model('goodsdisplay');
		$this->load->model('brandmodel');
		$this->load->helper('design');

		$skinConfiguration = skin_configuration($this->designWorkingSkin);

		/* 샘플 상품 정보 */
		$sampleGoodsInfo = array(
			'goods_seq' => '',
			'goods_name' => '샘플 상품',
			'price' => '19800',
			'consumer_price' => '24800',
			'image_cnt' => 2,
			'image2' => '/admin/skin/default/images/design/img_effect_sample2.gif',
		);

		$styles				= $this->goodsdisplay->styles;
		$mobilestyles_list	= $this->goodsdisplay->mobilestyles_list;

		//상품디스플레이영역의 노출심벌 통화단위 @2017-02-10
		$this->template->assign('currency_symbol_list',get_currency_symbol_list());

		$this->template->assign(array(
			'styles'						=> $styles,
			'mobilestyles_list'				=> $mobilestyles_list,
			'auto_orders'					=> $this->goodsdisplay->auto_orders,
			'orders'						=> $this->goodsdisplay->orders,
			'goodsImageSizes'				=> config_load('goodsImageSize'),
			'sampleGoodsInfo'				=> $sampleGoodsInfo,
			'skinConfiguration'				=> $skinConfiguration,
			'skinVersion'					=> $this->workingMobileSkinVersion
		));
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	// 입점사 별 브랜드 상품 개수 가져오기 :: 2019-09-19 pjw
	public function get_brand_goods_count(){
		$this->load->model('brandmodel');

		$provider_seq	= $this->input->get('provider_seq');
		$brand_list		= $this->brandmodel->get_brand_goods_count($provider_seq);

		echo json_encode($brand_list);
	}
}

/* End of file brand.php */
/* Location: ./app/controllers/admin/brand.php */
