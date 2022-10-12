<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class page_manager extends admin_base {

	var $member_type_arr	= array('default'=>'개인', 'business'=>'기업');
	var $page_type			= 'category';
	var $page_type_arr 		= array();
	var $page_sub_type_arr 	= array();
	var $page_tab			= '';
	var $tab_no				= '';


	// 바로가기 링크 정의 :: 2019-01-25 lwh
	// 순서 정의를 위해 생성자에서 나머지 지정 :: 2019-02-08 lwh
	var $page_menu			= array(
		'category'			=> array('name'=> '카테고리',			'link'=>'./page_layout?cmd=category'),
		'location'			=> array('name'=> '지역',				'link'=>'./page_layout?cmd=location'),
		'brand'				=> array('name'=> '브랜드',				'link'=>'./page_layout?cmd=brand')
	);

	public function __construct() {
		parent::__construct();

		$this->admin_menu();
		$this->tempate_modules();
		$file_path		= $this->template_path();
		$this->operation_type = !empty($this->config_system['operation_type']) ? $this->config_system['operation_type'] : 'heavy';

		$this->load->model('authmodel');
		$this->load->model('pagemanagermodel');

		if($this->config_system['operation_type'] == 'light'){
			$this->page_menu['brand_main']		= array('name'=> '브랜드 메인',	'link'=>'./page_manager/page_layout?cmd=brand');
			$this->page_menu['src_result']		= array('name'=> '검색결과',	'link'=>'./subpage_layout?cmd=search_result');
			$this->page_menu['newarrival']		= array('name'=> '신상품',		'link'=>'./subpage_layout?cmd=newproduct');
			$this->page_menu['best']			= array('name'=> '베스트',		'link'=>'./subpage_layout?cmd=bestproduct');
		}

		$this->page_menu['bigdata_recommend']	= array('name'=> '빅데이터 상품추천',	'link'=>'./subpage_layout?cmd=bigdata_criteria');
		$this->page_menu['all_event']			= array('name'=> '이벤트 메인',		'link'=>'./subpage_layout?cmd=event');
		$this->page_menu['sale_event']			= array('name'=> '할인 이벤트',		'link'=>'/admin/event/catalog', 'target'=>'1');
		$this->page_menu['gift_event']			= array('name'=> '사은품 이벤트',		'link'=>'/admin/event/gift_catalog', 'target'=>'1');

		if(serviceLimit('H_AD')){
			$this->page_menu['minishop']	= array('name'=> '판매자 미니샵','link'=>'/admin/provider/catalog', 'target'=>'1');
		}
	
		
		$this->page_type			= ($this->input->get('cmd'))? $this->input->get('cmd'):'category';
		$this->page_tab				= ($this->input->get('tab'))	? $this->input->get('tab')		: 'access_limit';	// 탭 타입
		$this->tab_no				= ($this->input->get('tabno'))	? $this->input->get('tabno')	: '1';				// 탭 번호

		if($this->page_type == 'brand' && $this->operation_type == 'light') $this->page_tab	= ($this->input->get('tab'))	? $this->input->get('tab')		: 'main';

		$this->page_type_arr 						= array();
		$this->page_type_arr['category']			= '카테고리';
		$this->page_type_arr['brand']				= '브랜드';
		$this->page_type_arr['location']			= '지역';
		if($this->operation_type == 'light'){
			$this->page_type_arr['newproduct']		= '신상품';
			$this->page_type_arr['bestproduct']		= '베스트';
			$this->page_type_arr['search_result']	= '검색';
		}

		$this->page_type_arr['event']				= '이벤트';		
		$this->page_type_arr['bigdata_criteria']	= '빅데이터 상품 추천';

		$this->page_sub_type_arr = array();
		if(in_array($this->page_type,array('category','brand','location'))){
			if($this->page_type == 'brand' && $this->operation_type == 'light'){
				$this->page_sub_type_arr[] = array('code' => 'main', 'title' => '메인');
				$this->page_sub_type_arr[] = array('code' => 'image', 'title' => '브랜드 설정');
			}

			$this->page_sub_type_arr[] = array('code' => 'access_limit', 'title' => '접속제한');
			$this->page_sub_type_arr[] = array('code' => 'banner', 'title' => '배너');
			$this->page_sub_type_arr[] = array('code' => 'recommend', 'title' => '추천상품');
			$this->page_sub_type_arr[] = array('code' => 'page_goods', 'title' => '검색 필터');

			if($this->operation_type == 'light'){
				$this->page_sub_type_arr[] = array('code' => 'goods_info', 'title' => '검색 상품 정보');
			}
			$this->page_sub_type_arr[] = array('code' => 'navigation', 'title' => '카테고리 네비게이션');
			$this->page_sub_type_arr[] = array('code' => 'all_navigation', 'title' => '전체 네비게이션');
		}

		$this->template->assign('page_type_arr', $this->page_type_arr);
		$this->template->assign('page_sub_type_arr', $this->page_sub_type_arr);
		$this->template->assign('page_type', $this->page_type);
		$this->template->assign('page_tab', $this->page_tab);
		$this->template->assign('tab_no', $this->tab_no);
		$this->template->assign('operation_type', $this->operation_type);
		$this->template->define(array('tpl'=>$file_path));
	}

	public function index(){
		redirect("/admin/page_manager/page_layout?cmd=category");
	}

	// 페이지 관리 리스트
	public function catalog(){

		redirect("/admin/page_manager/page_layout?cmd=category");
		exit;

		$auth = $this->authmodel->manager_limit_act('pagemanager_view');
		if(!$auth){
			pageBack("권한이 없습니다.");
			exit;
		}

		// 페이지 리스트 배열 구성
		$page_list[]	= array('page_code'=>'category', 'page_name'=>$this->page_menu['category']['name'], 'manager_type'=>'1', 'manager_txt'=>$this->page_menu['category']['link'],
			'perform'=>array('접속 제한','배너','추천상품','검색 필터','네비게이션 노출/배너')
		);

		if(!serviceLimit('H_FR')){
			$page_list[]	= array('page_code'=>'location', 'page_name'=>$this->page_menu['location']['name'], 'manager_type'=>'1', 'manager_txt'=>$this->page_menu['location']['link'],
				'perform'=>array('접속 제한','배너','추천상품','검색 필터','네비게이션 노출/배너')
			);
		}

		$page_list[]	= array('page_code'=>'brand', 'page_name'=>$this->page_menu['brand']['name'], 'manager_type'=>'1', 'manager_txt'=>$this->page_menu['brand']['link'],
			'perform'=>array('접속 제한','배너','추천상품','검색 필터','네비게이션, 메인 노출/배너')
		);

		if($this->config_system['operation_type'] == 'light'){ // light 버전 전용
			$page_list[]	= array('page_code'=>'brand_main', 'page_name'=>$this->page_menu['brand_main']['name'], 'manager_type'=>'1', 'manager_txt'=>$this->page_menu['brand_main']['link'],
				'perform'=>array('배너','검색 필터','베스트 브랜드 및 아이콘','브랜드 이미지')
			);
			$page_list[]	= array('page_code'=>'src_result', 'page_name'=>$this->page_menu['src_result']['name'], 'manager_type'=>'1', 'manager_txt'=>$this->page_menu['src_result']['link'],
				'perform'=>array('검색 필터')
			);
			$page_list[]	= array('page_code'=>'newarrival', 'page_name'=>$this->page_menu['newarrival']['name'], 'manager_type'=>'1', 'manager_txt'=>$this->page_menu['newarrival']['link'],
				'perform'=>array('배너','검색 필터')
			);
			$page_list[]	= array('page_code'=>'best', 'page_name'=>$this->page_menu['best']['name'], 'manager_type'=>'1', 'manager_txt'=>$this->page_menu['best']['link'],
				'perform'=>array('배너','검색 필터')
			);
		}

		$page_list[]	= array('page_code'=>'bigdata_recommend', 'page_name'=>$this->page_menu['bigdata_recommend']['name'], 'manager_type'=>'1', 'manager_txt'=>$this->page_menu['bigdata_recommend']['link'],
			'perform'=>array('배너','추천상품')
		);
		$page_list[]	= array('page_code'=>'all_event', 'page_name'=>$this->page_menu['all_event']['name'], 'manager_type'=>'1', 'manager_txt'=>$this->page_menu['all_event']['link'],
			'perform'=>array('배너','검색 필터')
		);
		$page_list[]	= array('page_code'=>'sale_event', 'page_name'=>$this->page_menu['sale_event']['name'], 'manager_type'=>'2', 'manager_txt'=>'<a class="highlight-link" href="'.$this->page_menu['sale_event']['link'].'" target="_blank">할인이벤트</a>',
			'perform'=>array('접속 제한','배너','검색 필터')
		);
		$page_list[]	= array('page_code'=>'gift_event', 'page_name'=>$this->page_menu['gift_event']['name'], 'manager_type'=>'2', 'manager_txt'=>'<a class="highlight-link" href="'.$this->page_menu['gift_event']['link'].'" target="_blank">사은품이벤트</a>',
			'perform'=>array('접속 제한','배너','검색 필터')
		);
		if(serviceLimit('H_AD')){
			$page_list[]	= array('page_code'=>'minishop', 'page_name'=>$this->page_menu['minishop']['name'], 'manager_type'=>'2', 'manager_txt'=>'<a class="highlight-link" href="'.$this->page_menu['minishop']['link'].'" target="_blank">입점사리스트</a>',
				'perform'=>array('소개글','추천상품','검색 필터')
			);
		}

		$this->template->assign(array('page_list' => $page_list));
		$this->template->print_("tpl");
	}

	// 카테고리 & 브랜드 & 지역 통합 페이지 설정
	public function page_layout(){
		// 기본 정의 목록
		$page_type				= $this->page_type;		// 페이지 타입
		$page_tab				= $this->page_tab;		// 탭 타입
		$tab_no					= $this->tab_no;				// 탭 번호
		$operation_type			= $this->operation_type;
		$is_extra_col			= false; // 추가열 사용 여부
		$page_info['page_name']	= $this->page_type_arr[$page_type];

		// 무료몰인데 지역 메뉴 접근 시.
		if(!$page_info['page_name'] || ($page_type == "location" && serviceLimit('H_FR'))){
			pageback('잘못된 접근입니다.');
			exit;
		}

		/* 관리자 권한 체크 : 시작 */
		if($page_tab == 'recommend'){
			$auth = $this->authmodel->manager_limit_act('design_act');
			if(!$auth){
				$callback = "history.go(-1);";
				$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
				$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
				$this->template->print_("denined");
				exit;
			}
		}
		/* 관리자 권한 체크 : 끝 */

		// 버튼 명 정의
		if		($page_tab == 'access_limit'){
			$btn_controll		= array('grp_ctrl_yn'=>true, 'grp_ctrl_txt'=>'접속 제한');
			$page_desc			= '· ' . $page_info['page_name'] . ' 페이지 접속 제한 설정 : ' . $btn_controll['grp_ctrl_txt'] . ' 버튼 클릭';
			// 회원등급 추출
			$query		= $this->db->get('fm_member_group');
			$result		= $query->result_array();
			$this->template->assign('member_group', $result);

			// 회원유형
			$this->template->assign('member_type', $this->member_type_arr);

		}else if($page_tab == 'banner'){
			$btn_controll		= array('grp_ctrl_yn'=>true, 'grp_ctrl_txt'=>'배너 관리');
			$page_desc			= '· ' . $page_info['page_name'] . ' 페이지 배너 설정 : ' . $btn_controll['grp_ctrl_txt'] . ' 버튼 클릭';
		}else if($page_tab == 'recommend'){
			$btn_controll		= array('grp_ctrl_yn'=>true, 'grp_ctrl_txt'=>'추천 상품 관리');
			$page_desc			= '· ' . $page_info['page_name'] . ' 페이지 추천상품 설정 : ' . $btn_controll['grp_ctrl_txt'] . ' 버튼 클릭';
		}else if($page_tab == 'page_goods'){
			$is_extra_top = $this->operation_type == 'light' ? false : true;
			//$btn_controll = array('grp_ctrl_yn'=>false, 'grp_ctrl_txt'=>'상품정렬');
			
			$btn_controll = array(
				'grp_ctrl_yn'=>false, 'grp_ctrl_txt'=>'검색 필터',
				'is_extra_top'=>$is_extra_top, 'extra_top_txt'=>'꾸미기', 'is_extra_col'=>false, 'grp_extra_col'=>'검색 필터', 'grp_extra_txt'=>'검색 필터'
			);
			
			if($this->operation_type == 'light'){
				$page_desc		= '· ' . $page_info['page_name'] . ' 페이지 ' . $btn_controll['grp_ctrl_txt'] . ' 설정 : ' . $btn_controll['grp_ctrl_txt'] . ' 버튼 클릭<br/>';
				$page_desc		.= '· ' . $page_info['page_name'] . ' 페이지 ' . $btn_controll['grp_extra_txt'] . ' 설정 : ' . $btn_controll['grp_extra_txt'] . ' 버튼 클릭';
			}else{
				$page_desc		= '· ' . $page_info['page_name'] . ' 페이지 ' . $btn_controll['grp_ctrl_txt'] . ' 설정 : ' . $btn_controll['grp_ctrl_txt'] . ' 버튼 클릭<br/>';
				$page_desc		.= '· ' . $page_info['page_name'] . ' 페이지 상품 ' . $btn_controll['extra_top_txt'] . ' 설정 : ' . $btn_controll['extra_top_txt'] . ' 버튼 클릭<br/>';
				$page_desc		.= '· ' . $page_info['page_name'] . ' 페이지 ' . $btn_controll['grp_extra_txt'] . ' 설정 : ' . $btn_controll['grp_extra_txt'] . ' 버튼 클릭';
			}

		}else if($page_tab == 'navigation' || $page_tab == 'all_navigation'){

			$grp_ctrl_yn  = $this->operation_type == 'light' ? false : true;
			//$is_extra_top = $this->operation_type == 'light' ? true : false;
			$is_extra_top  = true;
			$btn_controll = array(
				'grp_ctrl_yn' => $grp_ctrl_yn, 'grp_ctrl_txt'=>'스타일 관리'
			);
			if($page_tab == 'all_navigation'){
				$tab_name	='전체 네비게이션';
				$sub_txt1	='전체 ';
				if($page_type == 'brand')	$sub_txt2	='및 브랜드 메인 페이지 ';
				if($this->operation_type == 'light') {
					$btn_controll = array(
						'grp_ctrl_yn' => $grp_ctrl_yn, 'grp_ctrl_txt'=>'스타일 관리',
						'is_extra_col'=>false, 'grp_extra_col'=>'', 'grp_extra_txt'=>'배너 관리', 'grp_extra_class' => '',
						'is_extra_top'=>$is_extra_top, 'extra_top_txt'=>'치환 코드 복사', 'extra_top_class' => 'v3',
					'tab_name'=>$tab_name
					);
				}
			}else{
				$tab_name ='네비게이션';
				$btn_controll = array(
					'grp_ctrl_yn' => $grp_ctrl_yn, 'grp_ctrl_txt'=>'스타일 관리',
					'is_extra_col'=>false, 'grp_extra_col'=>'', 'grp_extra_txt'=>'배너 관리', 'grp_extra_class' => '',
					'is_extra_top'=>$is_extra_top, 'extra_top_txt'=>'치환 코드 복사', 'extra_top_class' => 'v3',
					'tab_name'=>$tab_name
				);
			}
			$top_btn_name = $tab_name.' 소스';

			if($this->operation_type == 'light'){
				$page_desc			= '· ' . $sub_txt1 . $page_info['page_name'] . ' 네비게이션 ' . $sub_txt2 . '노출 설정 : ' . $page_info['page_name'] . '명 클릭</br>';
				$page_desc			.= '· ' . $sub_txt1 . $page_info['page_name'] . ' 네비게이션 노출 배너 설정 : ' . $btn_controll['grp_extra_txt'] . ' 버튼 클릭';
			}else{
				$page_desc			= '· ' . $sub_txt1 . $page_info['page_name'] . ' 네비게이션 노출 설정 : ' . $page_info['page_name'] . '명 클릭</br>';
				$page_desc			.= '· ' . $sub_txt1 . $page_info['page_name'] . ' 네비게이션 노출 스타일(이미지 또는 텍스트) 설정 : ' . $page_info['grp_ctrl_txt'] . ' 버튼 클릭</br>';
				$page_desc			.= '· ' . $sub_txt1 . $page_info['page_name'] . ' 네비게이션 노출 배너 설정 : ' . $btn_controll['grp_extra_txt'] . ' 버튼 클릭';
			}

			$file_path	= $this->template_path();
			$file_path	= str_replace('page_layout.html', '_navigation_popup.html', $file_path);
			$this->template->define(array('_navigation_popup'=>$file_path));
		
		
		}else if($page_tab == 'main'){
			
			

		}else if($page_tab == 'image'){

			// 브랜드 메인 페이지 예외처리 :: 2018-12-19 lwh
			if($page_type == 'brand_main' || $page_type == 'brand'){
				//$page_info['page_name'] = '브랜드 메인';
				$page_sub_type			= $page_type;
				//$page_type				= 'brand';
				//$tab_no					= '2';
				$brand_main				= config_load('brand_main','best_icon');
				$this->template->assign('best_icon', $brand_main['best_icon']);
			}

			$btn_controll = array(
				'grp_ctrl_yn' => false, 'grp_ctrl_txt'=>'이미지 관리',
				'is_extra_col'=>false, 'grp_extra_col'=>'브랜드 이미지',
				'grp_extra_txt'=>'이미지관리', 'grp_extra_class' => 'active',
				'is_extra_top'=>true, 'extra_top_txt'=>'베스트 아이콘 관리','extra_top_class' => 'active',
			);
			$page_desc			= '· 베스트 브랜드 설정 : ' . $page_info['page_name'] . '명 클릭</br>';
			$page_desc			.= '· 베스트 브랜드 아이콘 : ' . $btn_controll['extra_top_txt'] . ' 버튼 클릭</br>';
			$page_desc			.= '· 베스트 메인 페이지의 브랜드 이미지 설정 : ' . $btn_controll['grp_extra_txt'] . ' 버튼 클릭</br>';

		}else if($page_tab == 'brand'){
			// 브랜드 메인 페이지 예외처리 :: 2018-12-19 lwh
			$page_info['page_name'] = '브랜드 메인';
			$page_sub_type			= $page_type;
			$page_type				= 'brand';
			$tab_no					= '2';
			$brand_main				= config_load('brand_main','best_icon');
			$this->template->assign('best_icon', $brand_main['best_icon']);
		}

		// subpage_layout.html 불러오는 페이지 정의
		if(($this->page_type == 'brand' && $this->page_tab == 'main') 
				|| in_array($this->page_type,array("newproduct","bestproduct","search_result","event","bigdata_criteria"))){
			$file_path	= $this->template_path();
			$file_path	= str_replace('page_layout.html', 'subpage_layout.html', $file_path);
			$this->template->define(array('tpl'=> $file_path));
			$this->subpage_layout_new();
		}

		if($btn_controll['grp_extra_txt'] && !$btn_controll['grp_extra_class']) $btn_controll['grp_extra_class'] = 'active';
		if($btn_controll['is_extra_top'] == true && !$btn_controll['extra_top_class']) $btn_controll['extra_top_class'] = 'active';

		$this->template->assign('page_menu', $this->page_menu);
		$this->template->assign('page_tab', $page_tab);
		$this->template->assign('page_desc', $page_desc);
		$this->template->assign($page_info);
		$this->template->assign($btn_controll);
		$this->template->define('tab_menu',$this->skin.'/page_manager/tab_menu.html');
		if(count($this->page_sub_type_arr) > 0){
			$this->template->assign('tab_menu_sub_use','y');
			$this->template->define('tab_menu_sub',$this->skin.'/page_manager/tab_menu_sub.html');
		}
		$this->template->print_("tpl");
	}

	// 카테고리 & 브랜드 & 지역 통합 페이지 리스트
	public function page_layout_list(){
		//$page_type				= ($this->input->get('cmd'))	? $this->input->get('cmd')		: 'category';		// 페이지 타입
		//$page_tab				= ($this->input->get('tab'))	? $this->input->get('tab')		: 'access_limit';	// 탭 타입
		$page_type 				= $this->page_type;
		$page_tab 				= $this->page_tab;
		$modelName				= $page_type.'model';
		$this->load->model($modelName);

		$page_name				= array('category'=>'카테고리', 'location'=>'지역', 'brand'=>'브랜드');
		$page_info['page_name'] = $page_name[$page_type];
		if($page_type != 'location')	$column_nm = 'category';
		else							$column_nm = $page_type;

		// 해당 목록 호출
		$all_target_info	= $this->$modelName->{'get_'.$page_type.'_view'}('',4,'admin');
		$all_target_list    = $this->$modelName->get_all();
		$all_category		= $this->pagemanagermodel->depth_count($all_target_info, $all_target_info);
		$all_target_cnt		= $this->pagemanagermodel->endRowspan();

		// 변수 초기화
		$grp_ctrl_txt		= null;		// Code view 버튼 표시여부
		$grp_ctrl_use		= true;		// Code view 버튼 사용여부
		$grp_ctrl_arr		= array();
		$is_extra_col		= false;	// 추가열 사용 여부
		$extra_col_txt		= array();
		$name_arr			= array();
		$btnViewTitle 		= '보기';
		$btnViewClass 		= '';

		if			($page_tab == 'access_limit'){ // 페이지 접속 제한 목록
			$grp_ctrl_txt		= '접속 제한';
			$all_access_limit	= $this->$modelName->{'get_'.$page_type.'_group_for_member'}();

			foreach($all_access_limit as $k => $l_info){
				if($l_info['group_seq']){
					$grp_ctrl_arr[$l_info[$column_nm.'_code']]['member_group'][$l_info['group_seq']] = $l_info['group_name'];
				}else{
					$grp_ctrl_arr[$l_info[$column_nm.'_code']]['user_type'][$l_info['user_type']] = $this->member_type_arr[$l_info['user_type']];
				}
			}
		}else if	($page_tab == 'banner'){ // 페이지 배너 목록
			$grp_ctrl_txt		= '배너';
			$grp_ctrl_arr		= $this->pagemanagermodel->child_get_data($page_type, $all_target_info, 'top_html');
		}else if	($page_tab == 'recommend'){ // 페이지 추천상품 목록
			if($this->operation_type == 'light')	$chk_val = 'recommend_display_light_seq';
			else									$chk_val = 'recommend_display_seq';
			$grp_ctrl_txt		= '추천상품';
			$grp_ctrl_arr		= $this->pagemanagermodel->child_get_data($page_type, $all_target_info, $chk_val);
		}else if	($page_tab == 'page_goods'){ // 페이지 상품 리스트 목록
			$btnViewTitle 		= '상품 정렬';
			$btnViewClass 		= 'v2';
			$is_extra_col		= false;
			if($this->operation_type == 'light'){
				
				$grp_ctrl_arr		= $this->pagemanagermodel->child_get_data($page_type, $all_target_info, true);

				$page_config = $this->pagemanagermodel->get_page_config($page_type);

				if($page_config['filter_cnt'] == 0)
					$extra_col_txt		= '미사용';
				else
					$extra_col_txt		= '사용';

			}else{
				$grp_ctrl_arr		= $this->pagemanagermodel->child_get_data($page_type, $all_target_info, true);

				// 텍스트 표현 정의
				$this->load->helper('design');
				$skinConfiguration = skin_configuration($this->designWorkingSkin);
				if($skinConfiguration[$page_type.'_navigation_use'] == 'Y'){
					if($skinConfiguration[$page_type.'_navigation_type'] == 'single')	$extra_col_txt		= '현재 차수에서 다음 차수 노출';
					else																$extra_col_txt		= '현재 차수에서 다음/다다음 차수 노출';
				}else{																	$extra_col_txt		= '미사용';
				}
			}
		}else if	($page_tab == 'navigation' || $page_tab == 'all_navigation'){ // 기본, 전체 네비게이션 리스트 목록
			$navi_type			= $page_tab == 'all_navigation' ? '_gnb' : '';
			$hide_type			= $page_tab == 'all_navigation' ? '_in_gnb' : '';
			$grp_ctrl_txt		= array('image' => '이미지', 'text' => '텍스트');
			$is_extra_col		= false;

			foreach($all_target_list as $k => $l_info){
				if($this->operation_type != 'light'){
					/*$grp_ctrl_arr[$l_info[$column_nm.'_code']] = array(
						$column_nm.'_code'					=>	$l_info[$column_nm.'_code'],
						'grp_ctrl_type'						=>	$l_info['node'.$navi_type.'_type'],
						'node'.$navi_type.'_type'			=>	$l_info['node'.$navi_type.'_type'],
						'node'.$navi_type.'_text_normal'	=>	$l_info['node'.$navi_type.'_text_normal'],
						'node'.$navi_type.'_text_over'		=>	$l_info['node'.$navi_type.'_text_over'],
						'node'.$navi_type.'_image_normal'	=>	$l_info['node'.$navi_type.'_image_normal'],
						'node'.$navi_type.'_image_over'		=>	$l_info['node'.$navi_type.'_image_over'],
					);
					*/
				}

				$name_arr[$l_info[$column_nm.'_code']] = $l_info['hide'.$hide_type] == '0' ? $l_info['title'] : '<span class="gray">'.$l_info['title'].'미노출</span>';
				$view_arr[$l_info[$column_nm.'_code']] = $l_info['hide'.$hide_type] == '0' ? '노출' : '미노출';
			}

			/*
			foreach($all_target_info as $k => $l_info){
				if($page_tab == 'all_navigation'){
					$extra_col_txt		= !empty($l_info['node'.$navi_type.'_banner']) ? '<div class="pdr10 highlight-link hand" onclick="extraSubCtrlBtn()">배너</div>' : '';
					break;
				}else{
					$extra_col_txt[$k]	= !empty($l_info['node'.$navi_type.'_banner']) ? '<div class="pdr10 highlight-link hand" onclick="extraSubCtrlBtn(\''.$k.'\')">배너</div>' : '';
				}
			}
			*/
		}else if	($page_tab == 'image'){
			$btnViewTitle 		= '베스트';
			$btnViewClass 		= 'v2';
			$grp_ctrl_txt		= '베스트';
			$is_extra_col		= false;
			$grp_ctrl_use		= false;
			//$grp_ctrl_arr		= $this->pagemanagermodel->child_get_data($page_type, $all_target_info, 'best');
			//if($grp_ctrl_arr) foreach($grp_ctrl_arr as $k => $val){
			//	if($val != 'Y')		$grp_ctrl_arr[$k] = null;
			//}

			foreach($all_target_info as $k => $l_info){
				$extra_col_txt[$k]	= !empty($l_info['brand_image']) ? '<div class="pdr10 highlight-link hand" onclick="extraSubCtrlBtn(\''.$k.'\')">이미지</div>' : '';
			}
			foreach($all_target_list as $k => $l_info){
				$name_arr[$l_info[$column_nm.'_code']] = $l_info['title'].'<span class="best_yn hide">'.$l_info['best'].'</span>';
				$view_arr[$l_info[$column_nm.'_code']] = $l_info['best'] == 'Y' ? '베스트' : '일반';
			}
		}
		
		$all_rowspan = 0;
		if($all_category) foreach($all_category as $code => $info){
			$all_rowspan += ($all_target_cnt[$code] > 0) ? $all_target_cnt[$code] : 1;
		}
		$this->template->assign($page_info);
		$this->template->assign('is_extra_col', $is_extra_col);
		$this->template->assign('extra_col_txt', $extra_col_txt);
		$this->template->assign('all_rowspan', $all_rowspan);
		$this->template->assign(array('btnViewTitle'=> $btnViewTitle,'btnViewClass'=>$btnViewClass));
		$this->template->assign('grp_ctrl_use', $grp_ctrl_use);
		$this->template->assign('grp_ctrl_txt', $grp_ctrl_txt);
		$this->template->assign('grp_ctrl_arr', $grp_ctrl_arr);
		$this->template->assign('all_target', $all_target_info);
		$this->template->assign('all_target_cnt', $all_target_cnt);
		$this->template->assign('banner_info', $banner_info);
		$this->template->assign(array('name_arr' => $name_arr, 'view_arr'=>$view_arr));
		$this->template->print_("tpl");
	}

	######################### 해당 탭 페이지 Get / SET :: START ############################

	### 1. 접속제한 :: START
	// 접속제한 설정 view
	public function ajax_set_access_limit(){
		$page_type		= $this->input->post('page_type');
		$target_depth	= $this->input->post('depth');

		$this->template->assign('params', $_POST);
		$this->template->print_("tpl");
	}

	// 접속제한 설정 list
	public function ajax_set_access_limit_list(){
		$page_type		= $this->input->post('page_type');
		$target_depth	= $this->input->post('depth');
		$target_code	= $this->input->post('target_code');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);

		if($target_code){
			$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}($target_depth,$target_code);
		}else{
			$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}($target_depth,null);
		}

		// 접속제한 접속자 부분
		$grp_name			= array();
		$user_type			= array();
		if(count($target_list)>0) {
		    $category_code = array_keys($target_list);
		} else {
		    $category_code = $target_code;
		}

		$cate_grp		= $this->$modelName->{'get_'.$page_type.'_group_for_member'}($category_code);
		// brand와 category는 category_code라는 필드인데 location만 location_code라는 필드명
		if($page_type === 'location') {
		    $prefix = 'location';
		} else {
		    $prefix = 'category';
		}
		foreach($cate_grp as $k => $info){
		    if($target_list[$info[$prefix.'_code']]){
		        if($info['group_name'])		$target_list[$info[$prefix.'_code']]['grp_name'][]	= $info['group_name'];
		        if($info['user_type'])		$target_list[$info[$prefix.'_code']]['user_type'][]	= $this->member_type_arr[$info['user_type']];
			}
		}

		$this->template->assign('target_code', $target_code);
		$this->template->assign('target_list', $target_list);
		$this->template->print_("tpl");
	}

	// 접속제한 상세 view ajax call
	public function ajax_get_access_limit(){
		$page_type		= $this->input->post('page_type');
		$target_code	= $this->input->post('code');
		$modelName		= $page_type.'model';
		$this->load->model($modelName);

		$cate_info	= $this->$modelName->{'get_'.$page_type.'_data'}($target_code);
		$cate_grp	= $this->$modelName->{'get_'.$page_type.'_group_for_member'}($target_code);

		// 접속제한 접속자 부분
		$grp_name			= array();
		$user_type			= array();
		$access_limit_arr	= array();
		foreach($cate_grp as $k => $info){
			if($info['group_name'])		$grp_name[]		= $info['group_name'];
			if($info['user_type'])		$user_type[]	= $this->member_type_arr[$info['user_type']];
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
		$cate_info['access_limit_txt'] = $access_limit_txt;

		// 접속제한 접속기간 부분
		if		($cate_info['catalog_allow'] == 'period'){ // 기간제한 시
			$access_limit_period = $cate_info['catalog_allow_sdate'] . ' ~ ' . $cate_info['catalog_allow_edate'];
		}else if($cate_info['catalog_allow'] == 'none'){
			$access_limit_period = '금지';
		}else if($cate_info['catalog_allow'] == 'show'){
			$access_limit_period = '허용';
		}
		$cate_info['access_limit_period']	= $access_limit_period;

		$this->template->assign('cate_info', $cate_info);
		$this->template->print_("tpl");
	}
	### 1. 접속제한 :: END

	### 2. 페이지배너 :: START
	// 배너 설정 view
	public function ajax_set_banner(){
		$page_type		= $this->input->post('page_type');
		$target_depth	= $this->input->post('depth');

		$this->template->assign('params', $_POST);
		$this->template->print_("tpl");
	}

	// 배너 설정 list
	public function ajax_set_banner_list(){
		$page_type		= $this->input->post('page_type');
		$target_depth	= $this->input->post('depth');
		$target_code	= $this->input->post('target_code');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);

		if($target_code){
			$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}($target_depth,$target_code);
		}else{
			$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}($target_depth,null);
		}

		$this->template->assign('target_code', $target_code);
		$this->template->assign('target_list', $target_list);
		$this->template->print_("tpl");
	}

	// 배너 상세 view ajax call
	public function ajax_get_banner(){
		$page_type		= $this->input->post('page_type');
		$target_code	= $this->input->post('code');
		$modelName		= $page_type.'model';
		$this->load->model($modelName);

		// 배너 내용
		$target_info	= $this->$modelName->{'get_'.$page_type.'_data'}($target_code);

		$this->template->assign('top_html', $target_info['top_html']);
		$this->template->print_("tpl");
	}
	### 2. 페이지배너 :: END

	### 3. 페이지 추천상품 :: START
	// 페이지 추천상품 설정 view
	public function ajax_set_recommend(){
		$page_type		= $this->input->post('page_type');
		$target_depth	= $this->input->post('depth');

		$this->template->assign('params', $_POST);
		if($this->operation_type == 'light'){
			$file_path	= $this->template_path();
			$file_path	= str_replace('ajax_set_recommend.html', 'ajax_set_recommend_light.html', $file_path);
			$this->template->define(array('tpl'=>$file_path));
		}
		$this->template->print_("tpl");
	}

	// 페이지 추천상품 설정 list
	public function ajax_set_recommend_list(){
		$page_type		= $this->input->post('page_type');
		$target_depth	= $this->input->post('depth');
		$target_code	= $this->input->post('target_code');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);
		$this->load->model('goodsdisplay');
		$this->load->helper('design');

		if($target_code){
			$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}($target_depth,$target_code);
		}else{
			$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}($target_depth,null);
		}

		if(count($target_list) > 0) foreach($target_list as $target_code => $info){

			$display_tabs = $this->pagemanagermodel->get_recommend_list($this->operation_type, $page_type, $target_code, true);


			$target_list[$target_code]['platform'] = $display_tabs['platform'];
			$target_list[$target_code]['tabs_row'] = $display_tabs['tabs_row'];

			unset($display_tabs['platform']);
			unset($display_tabs['tabs_row']);

			$target_list[$target_code]['display_tabs'] = $display_tabs;
		}

		if($this->operation_type == 'light'){
			$file_path	= $this->template_path();
			$file_path	= str_replace('ajax_set_recommend_list.html', 'ajax_set_recommend_list_'.$this->operation_type.'.html', $file_path);
			$this->template->define(array('tpl'=>$file_path));
		}

		$this->template->assign('target_code', $target_code);
		$this->template->assign('target_list', $target_list);
		$this->template->print_("tpl");
	}

	// 접속제한 상세 view ajax call
	public function ajax_get_recommend(){
		$page_type			= $this->input->post('page_type');
		$target_code		= $this->input->post('code');
		$kind				= $page_type.'_recommend';

		/* 상품디스플레이 정보 가져오기 */
		$display_tabs		= $this->pagemanagermodel->get_recommend_list($this->operation_type, $page_type, $target_code);

		$this->template->assign('display_tabs', $display_tabs);
		$this->template->print_("tpl");
	}
	### 3. 페이지 추천상품 :: END

	### 4. 페이지 상품리스트 :: START
	// 페이지 상품 설정 view
	public function ajax_set_page_goods(){
		$page_type		= $this->input->post('page_type');
		$target_depth	= $this->input->post('depth');

		$this->template->assign('params', $this->input->post());
		if($this->operation_type == 'light'){
			$file_path	= $this->template_path();
			$file_path	= str_replace('ajax_set_page_goods.html', 'ajax_set_page_goods_'.$this->operation_type.'.html', $file_path);
			$this->template->define(array('tpl'=>$file_path));
		}
		$this->template->print_("tpl");
	}

	// 페이지 상품 설정 list
	public function ajax_set_page_goods_list(){
		$page_type		= $this->input->post('page_type');
		$target_depth	= $this->input->post('depth');
		$target_code	= $this->input->post('target_code');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);
		$this->load->model('goodsdisplay');

		if($target_code){
			$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}($target_depth,$target_code);
		}else{
			$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}($target_depth,null);
		}

		if(count($target_list) > 0) foreach($target_list as $target_code => $info){
			if($info['page_goods_display_seq'] > 0){
				$this->$modelName->{'get_'.$page_type.'_page_goods_display_seq'}($target_code);
				$display_data = $this->goodsdisplay->get_display($info['page_goods_display_seq'],true);
				$display_tabs = $this->goodsdisplay->get_display_tab($info['page_goods_display_seq']);

				$target_list[$target_code]['platform'] = $display_data['platform'] ? $display_data['platform'] : 'pc';

				/* 디스플레이 상품 목록 */
				foreach($display_tabs as $k=>$v){
					$target_list[$target_code]['display_tabs'][$k]['info']	= $v;
					$target_list[$target_code]['display_tabs'][$k]['items'] = $this->goodsdisplay->get_display_item($info['page_goods_display_seq'],$k);
				}
			}
		}

		if($this->operation_type == 'light'){
			$file_path	= $this->template_path();
			$file_path	= str_replace('ajax_set_page_goods_list.html', 'ajax_set_page_goods_list_'.$this->operation_type.'.html', $file_path);
			$this->template->define(array('tpl'=>$file_path));
		}

		$this->template->assign('target_code', $target_code);
		$this->template->assign('target_list', $target_list);
		$this->template->print_("tpl");
	}

	// 페이지 상품 view ajax call
	public function ajax_get_page_goods(){
		$page_type			= $this->input->post('page_type');
		$target_code		= $this->input->post('code');
		$modelName			= $page_type.'model';
		$this->load->model($modelName);
		$this->load->model('goodsdisplay');

		$category_data	= $this->$modelName->{'get_'.$page_type.'_data'}($target_code);

		$list_type	= '';
		if($category_data['list_style'] != 'lattice_a'){
			$list_type = '_'.$category_data['list_style'];
		}

		// 전달 param 정의
		$_GET['count_w']			= $category_data['list_count_w' . $list_type];
		$_GET['count_h']			= $category_data['list_count_h' . $list_type];
		$_GET['kind']				= $page_type;
		$_GET['code']				= $target_code;
		$_GET['popup']				= 1;

		// 이미지 사이즈
		$goodsImageSize				= config_load('goodsImageSize');

		$this->template->assign('goodsImageSize',$goodsImageSize);
		$this->template->assign($this->input->get());

		$this->template->define(array('tpl'=>$this->skin.'/common/_goods_sort_popup.html'));
		$this->template->print_("tpl");
	}

	// 서브 예외 설정 버튼
	public function ajax_set_extra_page_goods(){

		$params				= $this->input->post();
		$page_type			= $params['page_type'];
		$page_tab			= $params['page_tab'];

		if($this->operation_type == 'light'){
			// 검색 필터 가져오기
			$search_filter = array('page_type'=> $page_type, 'data' => $this->pagemanagermodel->get_page_config($page_type));
			$file_path	= $this->template_path();
			$file_path	= str_replace('ajax_set_extra_page_goods.html', 'ajax_set_extra_page_goods_'.$this->operation_type.'.html', $file_path);
			$this->template->define(array('tpl'=>$file_path));
			$this->template->assign($search_filter);
		}else{
			$this->load->helper('design');
			$skinConfiguration = skin_configuration($this->designWorkingSkin);

			if($page_type == 'category')	$colname = 'brand';
			else							$colname = 'category';

			if(!$skinConfiguration[$page_type.'_navigation_count_single']) $skinConfiguration[$page_type.'_navigation_count_single'] = "4|4|4|4";
			if(!$skinConfiguration[$page_type.'_navigation_count_double']) $skinConfiguration[$page_type.'_navigation_count_double'] = "4|4|4|4";

			$params['page_name']				= $this->page_type_arr[$page_type];
			$params['navigation_use']			= $skinConfiguration[$page_type.'_navigation_use'];
			$params['navigation_type']			= $skinConfiguration[$page_type.'_navigation_type'];
			$params['naviation_sub_w']			= $skinConfiguration[$page_type.'_navigation_'.$colname.'_count_w'];
			$params['navigation_count_single']	= explode('|', $skinConfiguration[$page_type.'_navigation_count_single']);
			$params['navigation_count_double']	= explode('|', $skinConfiguration[$page_type.'_navigation_count_double']);

			if(is_array($params['navigation_count_single'])){
				foreach($params['navigation_count_single'] as $k => $_navi_cnt) if(!$_navi_cnt) $params['navigation_count_single'][$k] = 4;
			}
			if(is_array($params['navigation_count_double'])){
				foreach($params['navigation_count_double'] as $k => $_navi_cnt) if(!$_navi_cnt) $params['navigation_count_double'][$k] = 4;
			}
			$this->template->assign($params);
		}

		$this->template->print_("tpl");
	}
	### 4. 페이지 상품리스트 :: END

	### 5. 네비게이션 :: START
	// 네비게이션 설정 view
	public function ajax_set_navigation(){
		$page_type		= $this->input->post('page_type');
		$target_depth	= $this->input->post('depth');

		$this->template->assign('params', $_POST);
		if($this->operation_type == 'light'){
			$file_path	= $this->template_path();
			$file_path	= str_replace('ajax_set_navigation.html', 'ajax_set_navigation_'.$this->operation_type.'.html', $file_path);
			$this->template->define(array('tpl'=>$file_path));
		}
		$this->template->print_("tpl");
	}

	// 네비게이션 설정 list
	public function ajax_set_navigation_list(){
		$page_type		= $this->input->post('page_type');
		$target_depth	= $this->input->post('depth');
		$target_code	= $this->input->post('target_code');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);

		if($target_code){
			$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}($target_depth,$target_code);
		}else{
			$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}($target_depth,null);
		}

		foreach($target_list as $key=>$val){

			// 스타일관리 공통 항목
			$style_keys = array(
				'color'		=> array('key'=>'color',			'unit'=>''),
				'font'		=> array('key'=>'font-family',		'unit'=>''),
				'size'		=> array('key'=>'font-size',		'unit'=>'pt'),
				'bold'		=> array('key'=>'font-weight',		'unit'=>''),
				'underline' => array('key'=>'text-decoration',	'unit'=>''),
			);

			// 스타일관리 > 텍스트 보통일때
			$normal_style							= json_decode($val['node_text_normal']);
			$normal_style_txt						= 'style="';
			foreach($normal_style as $skey=>$svalue)	$normal_style_txt .= $style_keys[$skey]['key'].':'.$svalue.$style_keys[$skey]['unit'].';';
			$normal_style_txt						.= '"';

			// 스타일관리 > 텍스트 마우스오버시
			$over_style								= json_decode($val['node_text_over']);
			$over_style_txt							= 'style="';
			foreach($over_style as $skey=>$svalue)	$over_style_txt .= $style_keys[$skey]['key'].':'.$svalue.$style_keys[$skey]['unit'].';';
			$over_style_txt							.= '"';

			$val['node_text_normal']	= '<span '.$normal_style_txt.'>'.$val['title'].'</span>';
			$val['node_text_over']		= '<span '.$over_style_txt.'>'.$val['title'].'</span>';

			$target_list[$key] = $val;
		}

		if($this->operation_type == 'light'){
			$file_path	= $this->template_path();
			$file_path	= str_replace('ajax_set_navigation_list.html', 'ajax_set_navigation_list_'.$this->operation_type.'.html', $file_path);
			$this->template->define(array('tpl'=>$file_path));
		}

		$this->template->assign('target_code', $target_code);
		$this->template->assign('target_list', $target_list);
		$this->template->print_("tpl");
	}

	// 네비게이션 설정 view ajax call
	public function ajax_get_navigation(){
		$page_type			= $this->input->post('page_type');
		$target_code		= $this->input->post('code');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);

		// 스타일관리 공통 항목
		$style_keys = array(
			'color'		=> array('key'=>'color',			'unit'=>''),
			'font'		=> array('key'=>'font-family',		'unit'=>''),
			'size'		=> array('key'=>'font-size',		'unit'=>'pt'),
			'bold'		=> array('key'=>'font-weight',		'unit'=>''),
			'underline' => array('key'=>'text-decoration',	'unit'=>''),
		);

		$target_info	= $this->$modelName->{'get_'.$page_type.'_data'}($target_code);

		// 스타일관리 > 텍스트 보통일때
		$normal_style							= json_decode($target_info['node_text_normal']);
		$normal_style_txt						= 'style="';
		foreach($normal_style as $skey=>$svalue)	$normal_style_txt .= $style_keys[$skey]['key'].':'.$svalue.$style_keys[$skey]['unit'].';';
		$normal_style_txt						.= '"';

		// 스타일관리 > 텍스트 마우스오버시
		$over_style								= json_decode($target_info['node_text_over']);
		$over_style_txt							= 'style="';
		foreach($over_style as $skey=>$svalue)	$over_style_txt .= $style_keys[$skey]['key'].':'.$svalue.$style_keys[$skey]['unit'].';';
		$over_style_txt							.= '"';

		$target_info['node_text_normal']	= '<span '.$normal_style_txt.'>'.$target_info['title'].'</span>';
		$target_info['node_text_over']		= '<span '.$over_style_txt.'>'.$target_info['title'].'</span>';

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign('target_info', $target_info);
		$this->template->print_("tpl");
	}

	// 네비게이션 배너 관리
	public function ajax_set_extra_navigation(){
		$params				= $this->input->post();
		$page_type			= $this->input->post('page_type');
		$page_tab			= $this->input->post('page_tab');

		$this->template->assign($params);
		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	// 네비게이션 배너 관리 리스트
	public function ajax_set_extra_navigation_list(){
		$page_type			= $this->input->post('page_type');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);
		$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}('1',null);

		$this->template->assign(array('page_type'=>$page_type));
		$this->template->assign(array('target_list' => $target_list));
		$this->template->print_("tpl");
	}

	// 네비게이션 설정 view
	public function ajax_get_extra_navigation(){
		$page_type			= $this->input->post('page_type');
		$target_code		= $this->input->post('target_code');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);

		$banner_html	= $this->$modelName->{'get_'.$page_type.'_depth_list'}('1',$target_code);
		$banner_html	= $banner_html[$target_code];

		$this->template->assign(array('banner_html' => $banner_html['node_banner']));
		$this->template->print_("tpl");
	}

	// 네비게이션 노출설정
	public function ajax_get_extra_view_navigation(){
		$page_type			= $this->input->post('page_type');
		$target_code		= $this->input->post('target_code');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);
		$split_code		= $this->$modelName->{'split_'.$page_type}($target_code);
		$able_hide		= true;
		$curr_hide		= '';
		$next_hide		= '';
		$hide_txt_arr   = array('노출', '미노출');

		foreach($split_code as $code){
			$code_sum = $code;
			$target_info	= $this->$modelName->{'get_'.$page_type.'_data'}($code_sum);

			if($target_info['hide'] == '1' && $target_code != $code_sum ){
				$able_hide = false;
			}else{
				$curr_hide = $target_info['hide'];
				$next_hide = $curr_hide == '0' ? '1' : '0';
			}
		}

		if($able_hide){
			$msg	= '네비게이션에서 '.$target_info['title'].'(하위포함) 을(를) '.$hide_txt_arr[$next_hide].' 하시겠습니까?';
		}else{
			$msg	= '상위 '.$this->page_type_arr[$page_type].'(이)가 미노출 상태로 현재 '.$this->page_type_arr[$page_type].' 노출이 불가합니다.';
		}

		$result = array(
			'state' => $able_hide,
			'msg'	=> $msg,
			'curr'	=> $curr_hide,
			'next'	=> $next_hide
		);

		echo json_encode($result);
	}
	### 5. 네비게이션 :: END

	### 6. 전체 네비게이션 :: START
	// 전체 네비게이션 설정 view
	public function ajax_set_all_navigation(){
		$page_type		= $this->input->post('page_type');
		$target_depth	= $this->input->post('depth');

		$this->template->assign('params', $_POST);
		if($this->operation_type == 'light'){
			$file_path	= $this->template_path();
			$file_path	= str_replace('ajax_set_all_navigation.html', 'ajax_set_all_navigation_'.$this->operation_type.'.html', $file_path);
			$this->template->define(array('tpl'=>$file_path));
		}
		$this->template->print_("tpl");
	}

	// 전체 네비게이션 설정 list
	public function ajax_set_all_navigation_list(){
		$page_type		= $this->input->post('page_type');
		$target_depth	= $this->input->post('depth');
		$target_code	= $this->input->post('target_code');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);

		if($target_code){
			$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}($target_depth,$target_code);
		}else{
			$target_list	= $this->$modelName->{'get_'.$page_type.'_depth_list'}($target_depth,null);
		}

		foreach($target_list as $key=>$val){

			// 스타일관리 공통 항목
			$style_keys = array(
				'color'		=> array('key'=>'color',			'unit'=>''),
				'font'		=> array('key'=>'font-family',		'unit'=>''),
				'size'		=> array('key'=>'font-size',		'unit'=>'pt'),
				'bold'		=> array('key'=>'font-weight',		'unit'=>''),
				'underline' => array('key'=>'text-decoration',	'unit'=>''),
			);

			// 스타일관리 > 텍스트 보통일때
			$normal_style							= json_decode($val['node_gnb_text_normal']);
			$normal_style_txt						= 'style="';
			foreach($normal_style as $skey=>$svalue)	$normal_style_txt .= $style_keys[$skey]['key'].':'.$svalue.$style_keys[$skey]['unit'].';';
			$normal_style_txt						.= '"';

			// 스타일관리 > 텍스트 마우스오버시
			$over_style								= json_decode($val['node_gnb_text_over']);
			$over_style_txt							= 'style="';
			foreach($over_style as $skey=>$svalue)	$over_style_txt .= $style_keys[$skey]['key'].':'.$svalue.$style_keys[$skey]['unit'].';';
			$over_style_txt							.= '"';

			$val['node_gnb_text_normal']	= '<span '.$normal_style_txt.'>'.$val['title'].'</span>';
			$val['node_gnb_text_over']		= '<span '.$over_style_txt.'>'.$val['title'].'</span>';

			$target_list[$key] = $val;
		}

		if($this->operation_type == 'light'){
			$file_path	= $this->template_path();
			$file_path	= str_replace('ajax_set_all_navigation_list.html', 'ajax_set_all_navigation_list_'.$this->operation_type.'.html', $file_path);
			$this->template->define(array('tpl'=>$file_path));
		}

		$this->template->assign('target_code', $target_code);
		$this->template->assign('target_list', $target_list);
		$this->template->print_("tpl");
	}

	// 전체네비게이션 설정 view ajax call
	public function ajax_get_all_navigation(){
		$page_type			= $this->input->post('page_type');
		$target_code		= $this->input->post('code');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);

		// 스타일관리 공통 항목
		$style_keys = array(
			'color'		=> array('key'=>'color',			'unit'=>''),
			'font'		=> array('key'=>'font-family',		'unit'=>''),
			'size'		=> array('key'=>'font-size',		'unit'=>'pt'),
			'bold'		=> array('key'=>'font-weight',		'unit'=>''),
			'underline' => array('key'=>'text-decoration',	'unit'=>''),
		);

		$target_info	= $this->$modelName->{'get_'.$page_type.'_data'}($target_code);

		// 스타일관리 > 텍스트 보통일때
		$normal_style							= json_decode($target_info['node_gnb_text_normal']);
		$normal_style_txt						= 'style="';
		foreach($normal_style as $skey=>$svalue)	$normal_style_txt .= $style_keys[$skey]['key'].':'.$svalue.$style_keys[$skey]['unit'].';';
		$normal_style_txt						.= '"';

		// 스타일관리 > 텍스트 마우스오버시
		$over_style								= json_decode($target_info['node_gnb_text_over']);
		$over_style_txt							= 'style="';
		foreach($over_style as $skey=>$svalue)	$over_style_txt .= $style_keys[$skey]['key'].':'.$svalue.$style_keys[$skey]['unit'].';';
		$over_style_txt							.= '"';

		$target_info['node_gnb_text_normal']	= '<span '.$normal_style_txt.'>'.$target_info['title'].'</span>';
		$target_info['node_gnb_text_over']		= '<span '.$over_style_txt.'>'.$target_info['title'].'</span>';

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign('target_info', $target_info);
		$this->template->print_("tpl");
	}

	// 전체 네비게이션 배너 관리
	public function ajax_set_extra_all_navigation(){
		$params				= $this->input->post();
		$page_type			= $this->input->post('page_type');
		$page_tab			= $this->input->post('page_tab');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);

		$targetinfo = $this->$modelName->get_all();
		$targetinfo = $targetinfo[0];

		$this->template->assign($params);
		$this->template->assign($targetinfo);
		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	// 전체 네비게이션 배너 관리 리스트
	public function ajax_set_extra_all_navigation_list(){
		$page_type			= $this->input->post('page_type');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);

		$targetinfo = $this->$modelName->get_all(array('level = 2'));
		$targetinfo = $targetinfo[0];

		$this->template->assign($targetinfo);
		$this->template->print_("tpl");
	}

	// 전체 네비게이션 설정 view
	public function ajax_get_extra_all_navigation(){
		$page_type			= $this->input->post('page_type');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);

		$banner_html = $this->$modelName->get_all(array('level = 2'));
		$banner_html = $banner_html[0];

		$this->template->assign(array('banner_html' => $banner_html['node_gnb_banner']));
		$this->template->print_("tpl");
	}

	// 전체 네비게이션 노출설정
	public function ajax_get_extra_view_all_navigation(){
		$page_type			= $this->input->post('page_type');
		$target_code		= $this->input->post('target_code');

		$modelName		= $page_type.'model';
		$this->load->model($modelName);
		$split_code		= $this->$modelName->{'split_'.$page_type}($target_code);
		$able_hide		= true;
		$curr_hide		= '';
		$next_hide		= '';
		$hide_txt_arr   = array('노출', '미노출');

		foreach($split_code as $code){
			$code_sum = $code;
			$target_info	= $this->$modelName->{'get_'.$page_type.'_data'}($code_sum);

			if($target_info['hide_in_gnb'] == '1' && $target_code != $code_sum){
				$able_hide = false;
			}else{
				$curr_hide = $target_info['hide_in_gnb'];
				$next_hide = $curr_hide == '0' ? '1' : '0';
			}
		}

		if($able_hide){
			if($page_type == 'brand')	$sub_txt = ' 및 브랜드 메인페이지';
			$msg	= '네비게이션'.$sub_txt.'에서 '.$target_info['title'].'(하위포함) 을(를) <font color="red">'.$hide_txt_arr[$next_hide].'</font> 하시겠습니까?';
		}else{
			$msg	= '상위 '.$this->page_type_arr[$page_type].'(이)가 미노출 상태로 현재 '.$this->page_type_arr[$page_type].' 노출이 불가합니다.';
		}

		$result = array(
			'state' => $able_hide,
			'msg'	=> $msg,
			'curr'	=> $curr_hide,
			'next'	=> $next_hide
		);

		echo json_encode($result);
	}
	### 6. 전체 네비게이션 :: END


	### etc. 베스트 브랜드, 베스트 아이콘, 브랜드 이미지 :: START
	// 서브 예외 설정 버튼
	public function ajax_set_extra_brand_image(){
		$params				= $this->input->post();
		$page_type			= $this->input->post('page_type');
		$page_tab			= $this->input->post('page_tab');

		$this->load->model('brandmodel');
		$brand_list	= $this->brandmodel->get_brand_view('',1,'admin');

		$this->template->assign('brand_list', $brand_list);
		$this->template->print_("tpl");
	}

	// 브랜드 이미지 View :: 2018-12-24 lwh
	public function ajax_get_extra_image(){
		$params				= $this->input->post();
		$this->load->model('brandmodel');
		$brand_info	= $this->brandmodel->get_brand_data($params['target_code']);
		$html = '<div class="center">';
		$html .= '<img src="'.$brand_info['brand_image'].'?v='.date('YmdHis').'" style="max-width:500px;" />';
		$html .= '</div>';

		echo $html;
	}
	### etc. 베스트 브랜드, 베스트 아이콘, 브랜드 이미지 :: END

	######################### 해당 탭 페이지 Get / SET :: END ############################

	## [서브페이지] 이벤트 메인, 신상품, 베스트, 빅데이터상품추천 통합 페이지 설정
	public function subpage_layout_new(){

		if($this->page_tab == 'main'){
			$page_type = $this->page_type."_".$this->page_tab;
		}else{
			$page_type = $this->page_type;
		}

		// 페이지에 표시할 데이터 목록 정의
		if($this->operation_type == 'light' || $page_type == 'bigdata_criteria'){
			// 페이지에 표시할 항목 정의
			$data = array('data' => $this->pagemanagermodel->get_page_config($page_type, 'responsive'));
		}else{
			// 운영방식 : heavy, 페이지설정 : event 인 경우에만 이전과 동일한 페이지 노출
			if($page_type == 'event'){
				$data										= config_load('event');
				$data['display']['end_icon']				= ($data['display']['end_icon']) ? $data['display']['end_icon'] : '/data/icon/event/event_icon02.png';
				$data['display']['close_icon']				= ($data['display']['close_icon']) ? $data['display']['close_icon'] : '/data/icon/event/event_icon01.png';
				$data['display']['m_end_icon']				= ($data['display']['m_end_icon']) ? $data['display']['m_end_icon'] : '/data/icon/event/m_event_icon02.png';
				$data['display']['m_close_icon']			= ($data['display']['m_close_icon']) ? $data['display']['m_close_icon'] : '/data/icon/event/m_event_icon01.png';

				$heavy_event_tpl	= str_replace("page_layout.html","_heavy_event.html",$this->template_path());
				$this->template->define('heavy_event_tpl',$heavy_event_tpl);

			}else{
				pageBack("반응형 스킨 사용 시 제공되는 페이지입니다. ");
				exit;
			}
		}

		// 브랜드 메인 페이지 전용 :: 2018-12-19 lwh
		// 상품정보 페이지 전용 추가 :: 2019-05-13 pjw
		if($this->input->get('tab') == 'goods_info'){

			// 페이지 설명텍스트 설정
			$page_info['page_name']	= $this->page_menu[$page_type]['name'];
			$page_desc				= $this->page_menu[$page_type]['name'].' 페이지 검색 상품 정보 설정 :  노출을 원하는 스타일 클릭';

			// 서브 노출 항목 정리 (상품정보만 노출)
			$data['data']['allow'] = array('goods_info_style','goods_info_image');

			// assign 데이터
			$this->template->assign('page_desc', $page_desc);
			$this->template->assign('tab5', '-on');
		}
		
		// 상품정보 스타일 가져오기 호출 :: 2019-05-09 pjw
		$this->load->model('designmodel');
		$goods_info_style = $this->designmodel->get_goods_info_style('search_list', $data['data']['goods_info_style']);

		$assign_data = array( 'operation_type' => $this->operation_type,	'page_info'	=> $page_info, );
		$assign_data = array_merge($assign_data, $data);

		$this->template->assign('goods_info_style', $goods_info_style);
		$this->template->assign($assign_data);
	}

	public function subpage_layout(){

		$auth = $this->authmodel->manager_limit_act('pagemanager_view');
		if(!$auth){
			pageBack("권한이 없습니다.");
			exit;
		}

		if	(!$this->config_system)		$this->config_system	= config_load('system');

		$template_path			= $this->template_path();
		$page_type				= ($this->input->get('cmd'))	? $this->input->get('cmd')		: 'event';		// 페이지 타입
		$page_name				= array('search_result' => '검색결과', 'event'=>'이벤트 메인', 'newproduct'=>'신상품', 'bestproduct'=>'베스트', 'bigdata_criteria'=>'빅데이터 상품추천', 'brand_main'=>'브랜드 메인');
		//$page_info['page_name'] = $page_name[$page_type];
		$page_info['page_name']	= $this->page_type_arr[$page_type];

		// 페이지에 표시할 데이터 목록 정의
		if($this->operation_type == 'light' || $page_type == 'bigdata_criteria'){
			// 페이지에 표시할 항목 정의
			$data = array('data' => $this->pagemanagermodel->get_page_config($page_type, 'responsive'));
		}else{
			// 운영방식 : heavy, 페이지설정 : event 인 경우에만 이전과 동일한 페이지 노출
			if($page_type == 'event'){
				$data										= config_load('event');
				$data['display']['end_icon']				= ($data['display']['end_icon']) ? $data['display']['end_icon'] : '/data/icon/event/event_icon02.png';
				$data['display']['close_icon']				= ($data['display']['close_icon']) ? $data['display']['close_icon'] : '/data/icon/event/event_icon01.png';
				$data['display']['m_end_icon']				= ($data['display']['m_end_icon']) ? $data['display']['m_end_icon'] : '/data/icon/event/m_event_icon02.png';
				$data['display']['m_close_icon']			= ($data['display']['m_close_icon']) ? $data['display']['m_close_icon'] : '/data/icon/event/m_event_icon01.png';

				$template_path								= explode('/', $template_path);
				$template_path[count($template_path) - 1]	= '_heavy_'.$page_type.'.html';
				$template_path								= implode('/', $template_path);
			}else{
				pageBack("현재 운영방식에선 제공하지 않습니다.");
				exit;
			}
		}

		// 브랜드 메인 페이지 전용 :: 2018-12-19 lwh
		// 상품정보 페이지 전용 추가 :: 2019-05-13 pjw
		if($page_type == 'brand_main'){
			$this->template->assign('tab1', '-on');
		}else if($this->input->get('tab') == 'goods_info'){

			// 페이지 설명텍스트 설정
			$page_info['page_name']	= $this->page_menu[$page_type]['name'];
			$page_desc				= $this->page_menu[$page_type]['name'].' 페이지 검색 상품 정보 설정 :  노출을 원하는 스타일 클릭';

			// 서브 노출 항목 정리 (상품정보만 노출)
			$data['data']['allow'] = array('goods_info_style','goods_info_image');

			// assign 데이터
			$this->template->assign('page_desc', $page_desc);
			$this->template->assign('tab5', '-on');

			$this->template->assign('tab_menu_sub_use','y');
			$this->template->define('tab_menu_sub',$this->skin.'/page_manager/tab_menu_sub.html');
		}
		
		// 상품정보 스타일 가져오기 호출 :: 2019-05-09 pjw
		$this->load->model('designmodel');
		$goods_info_style = $this->designmodel->get_goods_info_style('search_list', $data['data']['goods_info_style']);

		$assign_data = array( 'operation_type' => $this->operation_type );
		$assign_data = array_merge($assign_data, $data);

		$this->template->assign($page_info);
		$this->template->assign('page_menu', $this->page_menu);
		$this->template->assign('goods_info_style', $goods_info_style);
		$this->template->assign($assign_data);
		$this->template->define(array('tpl'=> $template_path));
		$this->template->define('tab_menu',$this->skin.'/page_manager/tab_menu.html');
		$this->template->define('tab_menu_sub',$this->skin.'/page_manager/tab_menu_sub.html');
		$this->template->print_("tpl");
	}
}

/* End of file page_maneger.php */
/* Location: ./app/controllers/admin/page_maneger.php */