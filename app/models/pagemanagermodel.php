<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pagemanagermodel extends CI_Model {

	var $rowspan_arr = [];

	public function __construct() {
		parent::__construct();

		$this->default_filters = array();
		/*
		$this->default_filters = array(
			'category'			=> array('category','brand','freeship','price','rekeyword'),
			'brand'				=> array('category','brand','freeship','price','rekeyword'),
			'location'			=> array('category','brand','freeship','price','rekeyword'),
			'sales_event'		=> array('category','brand','freeship','price','rekeyword'),
			'gift_event'		=> array('category','brand','freeship','price','rekeyword'),
			'minishop'			=> array('category','brand','freeship','price','rekeyword'),
			'search_result'		=> array('category','brand','freeship','price','rekeyword'),
			'event'				=> array('sales','gift','attendance','event'),
			'newproduct'		=> array('category','brand','freeship','price','rekeyword'),
			'bestproduct'		=> array('category','brand','freeship','price','rekeyword')
		);
		*/
	}

	// Depth 카운터 계산
	public function depth_count(&$all_category_info){
		foreach($all_category_info as $k => &$info){
			$childs_cnt							= count($info['childs']);
			$this->rowspan_arr[$k][0] = $childs_cnt;
			if ($childs_cnt > 0){
				$this->depth_parent_sum($k, $childs_cnt);
			}

			if($childs_cnt){
				$this->depth_count($info['childs']);
			}
		}

		return $all_category_info;
	}

	// Depth 카운터 상위계층 합
	public function depth_parent_sum($code, $childs_cnt){
		$codeLen = 4;
		$now_depth = strlen($code) / $codeLen;
		if($now_depth > 1) {
			for($i = 1; $i < $now_depth; $i++){
				$parent_code = substr($code, 0, ($i * $codeLen));
				$this->rowspan_arr[$parent_code][] = $childs_cnt;
			}
		}
	}

	// Depth Array 계산 반환
	public function endRowspan(){
		foreach($this->rowspan_arr as $code => $cnts){
			$minus = count($cnts) - 1;
			$this->rowspan_arr[$code] = array_sum($cnts) - $minus;
		}
		return $this->rowspan_arr;
	}

	// page_type별 데이터 저장 시 가공처리
	public function page_data_check($page_type, $codecd='', $data){
		$newdata = $data;

		if($page_type == 'bigdata_criteria' && $codecd == 'condition'){
			$this->load->model('goodsdisplay');
			$newdata = $this->goodsdisplay->check_criteria($newdata,'bigdata_catalog');
		}else{
			if(is_array($newdata)){
				$newdata = implode(',', $newdata);
			}
		}

		return $newdata;
	}

	// 내부 값으로 하위 코드 재귀호출
	public function child_get_data($page_type, $all_target_info, $chk_val){

		if($page_type != 'location')	$column_nm = 'category';
		else							$column_nm = $page_type;

		$grp_ctrl_arr = array();
		foreach($all_target_info as $k => $l_info){
			$grp_ctrl_arr[$l_info[$column_nm.'_code']] = ($chk_val === true) ? true : $l_info[$chk_val];
			if($l_info['childs']) foreach($l_info['childs'] as $k2 => $l_info_2){
				$grp_ctrl_arr[$l_info_2[$column_nm.'_code']] = ($chk_val === true) ? true : $l_info_2[$chk_val];
				if($l_info_2['childs']) foreach($l_info_2['childs'] as $k3 => $l_info_3){
					$grp_ctrl_arr[$l_info_3[$column_nm.'_code']] = ($chk_val === true) ? true : $l_info_3[$chk_val];
					if($l_info_3['childs']) foreach($l_info_3['childs'] as $k4 => $l_info_4){
						$grp_ctrl_arr[$l_info_4[$column_nm.'_code']] = ($chk_val === true) ? true : $l_info_4[$chk_val];
					}
				}
			}
		}

		return $grp_ctrl_arr;
	}

	// 페이지 정보 로드
	public function get_page_config($page_type='', $platform=''){
		// 페이지 타입이 없는 경우 블락처리
		if($page_type == '') return array();

		$data	= config_load($page_type);				// 페이지타입별 설정된 정보를 config에서 로드
		$allow	= $this->get_allow_list($page_type);	// 페이지 별 사용 필요한 정보

		//debug($data);
		//debug($allow);
		// 기본 정보 세팅 (allow 목록에 있는 경우만 세팅, 없는 경우는 넘어감)
		if(in_array('link_url', $allow))		 $link_url			= $this->get_link_url($page_type);
		if(in_array('banner', $allow))			 $banner			= $this->get_banner_list($page_type, $platform);
		if(in_array('rank', $allow))			 $rank				= $data['rank'];
		if(in_array('condition', $allow))		 $condition			= $data['condition'];
		if(in_array('orderby', $allow))			 $orderby			= explode(',', $data['orderby']);
		if(in_array('order_col', $allow))		 $order_col			= $this->get_order_col($page_type);
		if(in_array('status', $allow))			 $status			= $this->get_status_list($page_type, $data['status']);
		if(in_array('search_filter', $allow))	 $search_filter		= $this->get_search_filter($page_type, $data['search_filter']);
		if(in_array('search_filter', $allow))	 $filter_cnt		= count($data['search_filter']);
		if(in_array('filter_col', $allow))		 $filter_col		= $this->get_search_filter_columns($page_type);
		if(in_array('goods_info_style', $allow)) $goods_info_style	= $data['goods_info_style'];
		if(in_array('goods_info_image', $allow)) $goods_info_image	= $data['goods_info_image'];


		// 페이지 타입별 따로 처리해야 할 데이터 가공
		if($page_type == 'bigdata_criteria'){

			// 빅데이터 설정 정보
			$banner = $data['banner'];
			$this->load->model('bigdatamodel');
			$this->load->model('goodsmodel');
			$this->load->model('usedmodel');

			$chks = $this->usedmodel->used_service_check('bigdata');
			$this->template->assign(array('chkBigdata'=>$chks['type']));
			$this->template->assign(array('kinds' => $this->bigdatamodel->get_kind_array()));
			$this->template->define(array('SEARCH_FORM' => $this->skin."/bigdata/search_form.html"));
			$this->template->define('condition', $this->skin.'/page_manager/_recommend.html');

		}

		// 공통 상품정보 노출 추가
		$this->template->define('goods_info_style', $this->skin.'/page_manager/_goods_info_style.html');

		// allow 배열 키 값에 맞는 데이터만 배열로 만들어서 반환
		$result_data = array('allow' => $allow, 'filter_cnt'=>$filter_cnt);
		foreach($allow as $key){
			$result_data[$key] = $$key;
		}

		return $result_data;
	}

	// 각 페이지 별 사용 필요한 정보 정의
	public function get_allow_list($page_type){

		$allow	= array(
			'category'			=> array('search_filter','filter_col', 'orderby', 'order_col', 'status','goods_info_style','goods_info_image'),
		    'brand'				=> array('search_filter','filter_col', 'orderby', 'order_col', 'status','goods_info_style','goods_info_image'),
			'brand_main'		=> array('link_url','banner','search_filter','filter_col','status'),
			'location'			=> array('search_filter','filter_col', 'orderby', 'order_col', 'status','goods_info_style','goods_info_image'),
		    'sales_event'		=> array('search_filter','filter_col', 'orderby', 'order_col', 'status','goods_info_style','goods_info_image'),
		    'gift_event'		=> array('search_filter','filter_col', 'orderby', 'order_col', 'status','goods_info_style','goods_info_image'),
		    'minishop'			=> array('search_filter','filter_col', 'orderby', 'order_col', 'status','goods_info_style','goods_info_image'),
		    'search_result'		=> array('link_url', 'search_filter', 'filter_col', 'orderby', 'order_col', 'status','goods_info_style','goods_info_image'),
			'event'				=> array('link_url', 'banner', 'search_filter', 'filter_col', 'orderby', 'order_col', 'status'),
			'newproduct'		=> array('link_url', 'banner', 'search_filter', 'filter_col', 'orderby', 'order_col', 'status','goods_info_style','goods_info_image'),
		    'bestproduct'		=> array('link_url', 'banner', 'search_filter', 'filter_col', 'orderby', 'order_col', 'rank', 'status','goods_info_style','goods_info_image'),
		    'bigdata_criteria'	=> array('link_url', 'banner', 'condition','goods_info_style','goods_info_image'),
		);

		return $allow[$page_type];
	}

	// 페이지별 링크 반환
	public function get_link_url($page_type){
//		$domain			= !empty($this->config_system['domain']) ? $this->config_system['domain'] : $this->config_system['subDomain'];
		$domain			= get_connet_protocol().$_SERVER['SERVER_NAME'];

		$link_urls = array(
			'search_result'		=> $domain.'/goods/search',
			'event'				=> $domain.'/promotion/event',
			'newproduct'		=> $domain.'/goods/new_arrivals',
			'bestproduct'		=> $domain.'/goods/best',
			'bigdata_criteria'	=> $domain.'/bigdata/catalog',
			'brand_main'		=> $domain.'/goods/brand_main',
		);

		return $link_urls[$page_type];
	}

	// 배너 목록 가져옴 (서브 페이지용)
	public function get_banner_list($page_type, $platform='mobile'){
		$this->load->model('designmodel');
		$styles = $this->designmodel->get_banner_styles();

		$sql = 'select SQL_CALC_FOUND_ROWS * from fm_design_banner where platform=? and skin=? and page_type=? order by banner_seq desc limit 1';
		$query = $this->db->query($sql,array($platform, $this->realSkin, $page_type));
		$banner				= $query->result_array();
		$banner				= $banner[0];
		$banner['styles']	= $styles;

		// 배너를 보여줄 템플릿 정의
		if($page_type == 'bigdata_criteria'){
			$this->template->define('bannerlist', $this->skin.'/page_manager/_banner.html');
		}else{
			$this->template->define('bannerlist', $this->skin.'/page_manager/_bannerlist.html');
		}

		return $banner;
	}

	// 페이지별 노출용 정렬 항목 반환
	public function get_order_col($page_type){

		$default_order_cols = array(
			'category'		=> array( 'rank' => '랭킹순', 'new' => '신규등록순', 'low' => '낮은가격순', 'high' => '높은가격순', 'review' => '상품평많은순', 'sales' => '판매량순', ),
			'brand'			=> array( 'rank' => '랭킹순', 'new' => '신규등록순', 'low' => '낮은가격순', 'high' => '높은가격순', 'review' => '상품평많은순', 'sales' => '판매량순', ),
			'location'		=> array( 'rank' => '랭킹순', 'new' => '신규등록순', 'low' => '낮은가격순', 'high' => '높은가격순', 'review' => '상품평많은순', 'sales' => '판매량순', ),
			'sales_event'	=> array( 'rank' => '랭킹순', 'new' => '신규등록순', 'low' => '낮은가격순', 'high' => '높은가격순', 'review' => '상품평많은순', 'sales' => '판매량순', ),
			'gift_event'		=> array( 'rank' => '랭킹순', 'new' => '신규등록순', 'low' => '낮은가격순', 'high' => '높은가격순', 'review' => '상품평많은순', 'sales' => '판매량순', ),
			'search_result' => array( 'rank' => '랭킹순', 'new' => '신규등록순', 'low' => '낮은가격순', 'high' => '높은가격순', 'review' => '상품평많은순', 'sales' => '판매량순', ),
			'event'			=> '이벤트 최근 시작일',
			'newproduct'	=> '신규등록순',
			'bestproduct'	=> array('daily' => '누적 판매량순', 'monthly' => '월별 판매량 순 (최근 3개월, 당월 포함) <span class="tooltip_btn" onClick="showTooltip(this, \'/admin/tooltip/page_manager\', \'#stateMonths\')"></span>'),
		);

		return $default_order_cols[$page_type];
	}

	// 페이지별 상태값 배열 반환
	public function get_status_list($page_type, $data){
		// 노출용 목록
		$status_cols = array(
			'category'		=> array('normal'	=> '정상', 'runout' => '품절', 'purchasing' => '재고 확보중', 'unsold' => '판매중지'),
			'brand'			=> array('normal'	=> '정상', 'runout' => '품절', 'purchasing' => '재고 확보중', 'unsold' => '판매중지'),
			'location'		=> array('normal'	=> '정상', 'runout' => '품절', 'purchasing' => '재고 확보중', 'unsold' => '판매중지'),
			'sales_event'	=> array('normal'	=> '정상', 'runout' => '품절', 'purchasing' => '재고 확보중', 'unsold' => '판매중지'),
			'gift_event'		=> array('normal'	=> '정상', 'runout' => '품절', 'purchasing' => '재고 확보중', 'unsold' => '판매중지'),
			'search_result'		=> array('normal'	=> '정상', 'runout' => '품절', 'purchasing' => '재고 확보중', 'unsold' => '판매중지'),
			'event'				=> array('expired' => '종료된 이벤트'),
			'newproduct'		=> array('normal'	=> '정상', 'runout' => '품절', 'purchasing' => '재고 확보중', 'unsold' => '판매중지'),
			'bestproduct'		=> array('normal'	=> '정상', 'runout' => '품절', 'purchasing' => '재고 확보중', 'unsold' => '판매중지'),
		);

		// 입점형일 경우 문구 추가
		$use_provider = array('search_result', 'newproduct', 'bestproduct');
		if(serviceLimit('H_AD') && in_array($page_type, $use_provider)) $status_prefix = '승인 | ';
		if		($page_type == 'event')			{ $status_prefix = '노출 | '; $desc = '정상'; }
		else if	($page_type == 'brand_main')	{ $status_prefix = '노출'; }
		else									{ $desc = '정상'; }

		// 정보 조합 후 반환
		return array(
			'desc'	=>	$status_prefix.$desc,
			'chk'	=>	($data) ? explode(',', $data) : null,
			'col'	=>  $status_cols[$page_type],
		);
	}

	// 검색 필터 값이 없는 경우 기본값 지정
	public function get_search_filter($page_type, $data){
		$result = array();
		if(empty($data) || count($data) == 0){
			$result = array();
		}else{
			$result = explode(',', $data);
		}

		return $result;
	}

	// 페이지별 검색 필터 노출용 배열 반환
	public function get_search_filter_columns($page_type){

		$item 					= array();
		$item['categorybrand'] 	= array('category'=>'카테고리','brand'=>'브랜드');
		$item['shipping'] 		= array('freeship'=>'무료배송', 'abroadship'=>'해외배송');
		//$item['status'] 		= array('normal'=>'정상', 'runout'=>'품절', 'purchasing'=>'재고 확보중', 'unsold'=>'판매 중지');
		$item['etc']			= array('price'=>'가격', 'rekeyword'=>'재검색어', 'color'=>'색상');
		$item['promotion']		= array('sales'=>'할인/기획전', 'gift'=>'사은품', 'attendance'=>'출석체크');
		$common_columns 		= array(
										'categorybrand'=> array('title' => '카테고리/브랜드'	,'field' => 'search_filter' , 'item' =>  $item['categorybrand']),
										'shipping'=> array('title' => '배송 정보' 		,'field' => 'search_filter' , 'item' => $item['shipping']),
										'etc'=> array('title' => '기타 정보' 		,'field' => 'search_filter' , 'item' => $item['etc']),
								);
								//'status'=> array('title' => '판매 상태' 		,'field' => 'search_filter' 		, 'item' => $item['status']),
		$default_columns['category'] 		= $common_columns;
		$default_columns['brand'] 			= $common_columns;
		$default_columns['location'] 		= $common_columns;
		$default_columns['sales_event'] 	= $common_columns;
		$default_columns['gift_event'] 		= $common_columns;
		$default_columns['minishop'] 		= $common_columns;
		$default_columns['search_result'] 	= $common_columns;
		$default_columns['event']			= array(
													'promotion'=> array('title' => '할인기획전'	,'field' => 'search_filter' , 'item' =>  $item['promotion']),
													'event'=> array('title' => '이벤트명', 'field' => 'search_filter', 'item' => array('event' => '이벤트명')) 
												);
		$default_columns['newproduct'] 		= $common_columns;
		$default_columns['bestproduct'] 	= $common_columns;
		$default_columns['brand_main']		= array(
													'leng'  => array('title' => '언어', 'field' => 'search_filter', 'item' => array('kor'=>'한글','eng'=>'영문')),
													'brand' => array('title' => '브랜드', 'field' => 'search_filter', 'item' => array('brand'=>'브랜드명')),
												);

		// 입점몰일때만 판매자 조건 노출
		if(serviceLimit('H_AD')){
			$seller_add_columns = array('category','brand','location','search_result','newproduct','bestproduct');
			if(in_array($page_type, $seller_add_columns)){
				$default_columns[$page_type]['etc']['item'] = array_merge($default_columns[$page_type]['etc']['item'],array('seller'=>'판매자'));
			}
		}

		return $default_columns[$page_type];
	}

	// 카테고리, 브랜드, 지역 추천상품 가져오기
	public function get_recommend_list($operation_type='heavy', $page_type, $target_code, $is_extra = false){

		$modelName			= $page_type.'model';
		$this->load->model($modelName);
		$this->load->model('goodsdisplay');
		$this->load->model('designmodel');
		$this->load->helper('design');
		$display_seq_arr	= $this->$modelName->{'get_'.$page_type.'_recommend_display_seq'}($target_code, false);

		// light 일 경우
		if($operation_type == 'light'){
			$r_display_seq		= $display_seq_arr['recommend_display_light_seq'];

			if($r_display_seq){
				$r_display_data		= $this->goodsdisplay->get_display($r_display_seq,true);
				$r_display_tabs		= $this->goodsdisplay->get_display_tab($r_display_seq);

				$platform = $r_display_data['platform'] ? $r_display_data['platform'] : 'responsive';
				$this->template->assign(array('platform'=>$platform));

				/* 디스플레이 상품 목록 */
				$tabs_row = 0;

				foreach($r_display_tabs as $k=>$v){
					$r_display_tabs[$k]['items'] = $this->goodsdisplay->get_display_item($r_display_seq,$k);

					// 탭 옵션조건 추출 - design_helper 함수
					if($v['contents_type'] == 'auto' || $v['contents_type'] == 'auto_sub'){
						$r_display_tabs[$k]['auto_criteria_desc'] = setAutoCondition($v['auto_criteria'], $page_type);
					}

					$tabs_row++;
				}

				// 추가 정보 임시로 탭에 넘겨 보냄
				if($is_extra){
					$r_display_tabs['tabs_row'] = $tabs_row;
					$r_display_tabs['platform'] = $platform;
				}
			}

			$display_tabs		= $r_display_tabs;

		}else{	// heavy 일 경우
			$display_seq		= $display_seq_arr['recommend_display_seq'];
			$m_display_seq		= $display_seq_arr['m_recommend_display_seq'];


			// PC
			if($display_seq){
				$display_data		= $this->goodsdisplay->get_display($display_seq,true);
				$display_tabs		= $this->goodsdisplay->get_display_tab($display_seq);

				$platform = $display_data['platform'] ? $display_data['platform'] : 'pc';
				$this->template->assign(array('platform'=>$platform));

				// 디스플레이 상품 목록
				$tabs_row = 0;
				foreach($display_tabs as $k=>$v){
					$display_tabs[$k]['items'] = $this->goodsdisplay->get_display_item($display_seq,$k);

					// 탭 옵션조건 추출 - design_helper 함수
					if($v['contents_type'] == 'auto' || $v['contents_type'] == 'auto_sub'){
						$display_tabs[$k]['auto_criteria_desc'] = setAutoCondition($v['auto_criteria'], $page_type);
					}

					$tabs_row++;
				}

				// 추가 정보 임시로 탭에 넘겨 보냄
				if($is_extra){
					$display_tabs['tabs_row'] = $tabs_row;
					$display_tabs['platform'] = $platform;
				}
			}

			// 모바일
			if($m_display_seq && $mobile_display_flag){
				$m_display_data		= $this->goodsdisplay->get_display($m_display_seq,true);
				$m_display_tabs		= $this->goodsdisplay->get_display_tab($m_display_seq);

				foreach($m_display_tabs as $k=>$v){
					$m_display_tabs[$k]['items'] = $this->goodsdisplay->get_display_item($m_display_seq,$k);
				}
			}

		}

		return $display_tabs;
	}
}
?>
