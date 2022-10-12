<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class coupon extends admin_base {

	public function __construct() {

		parent::__construct();
		$this->admin_menu();
		$this->tempate_modules();
		$this->file_path	= $this->template_path();
		$this->load->model('couponmodel');
		$this->load->model('membermodel');
		$this->load->helper('coupon');
		$this->load->library('validation');

		$reserves = ($this->reserves)?$this->reserves:config_load('reserve');
		$ispoint		= $reserves['point_use'];//포인트 사용여부 설정
		$ispointurl	= '/admin/setting/reserve';//포인트설정페이지
		$this->template->assign('ispoint',$ispoint);
		$this->template->assign('ispointurl',$ispointurl);

		/* 회원 그룹 개발시 변경*/
		/*
		$groups = "";
		$grquery = $this->db->query("select group_seq,group_name from fm_member_group order by order_sum_price desc, order_sum_ea desc, order_sum_cnt desc, use_type asc");//where group_seq != 1
		if($grquery->result_array()) {
			foreach($grquery->result_array() as $row){
				$groups[] = $row;
			}
		}
		*/
		/**$grquery = $this->db->query("select group_seq,group_name from fm_member_group where group_seq != 1 ");
		foreach($grquery->result_array() as $row){
			$groups[] = $row;
		}**/
		/******************/
		$this->groups = $groups;
		$this->template->assign(array('groups'=>$groups));
		$this->template->define(array('tpl'=>$this->file_path));

		//쿠폰 사용 가능한 상품 확인하기 레이어
		$this->template->define(array('coupongoodslayer'=>$this->skin.'/coupon/coupongoodslayer.html'));

	}

	public function index()
	{
		redirect("/admin/coupon/catalog");
	}

	//쿠폰목록
	public function catalog()
	{
		$aGetParams = $this->input->get();

		// validation
		if ($aGetParams) {
			$this->validation->set_data($aGetParams);
			$this->validation->set_rules('id', '게시판ID', 'trim|string|xss_clean');
			$this->validation->set_rules('no', '일련번호', 'trim|numeric|xss_clean');
			$this->validation->set_rules('perpage', '페이지갯수', 'trim|numeric|xss_clean');
			$this->validation->set_rules('page', '페이지', 'trim|numeric|xss_clean');
			$this->validation->set_rules('orderby', '정렬', 'trim|string|xss_clean');
			$this->validation->set_rules('search_text', '검색어', 'trim|string|xss_clean');
			$this->validation->set_rules('sdate', '시작일', 'trim|string|xss_clean');
			$this->validation->set_rules('edate', '종료일', 'trim|string|xss_clean');
			$this->validation->set_rules('issue_stop0', '발급여부', 'trim|numeric|xss_clean');
			$this->validation->set_rules('issue_stop1', '발급여부', 'trim|numeric|xss_clean');
			$this->validation->set_rules('couponType[]', '쿠폰종류', 'trim|string|xss_clean');
			$this->validation->set_rules('coupon_same_time', '사용제한', 'trim|string|xss_clean');
			$this->validation->set_rules('limit_goods_price', '금액제한', 'trim|numeric|xss_clean');
			$this->validation->set_rules('cost_type', '사용처', 'trim|string|xss_clean');
			$this->validation->set_rules('search_cost_start', '부담율', 'trim|numeric|xss_clean');
			$this->validation->set_rules('search_cost_end', '부담율', 'trim|numeric|xss_clean');
			$this->validation->set_rules('provider_seq', '입점사', 'trim|string|xss_clean');
			$this->validation->set_rules('provider_name', '입점사명', 'trim|string|xss_clean');
			if ($this->validation->exec() === false) {
				show_error($this->validation->error_array['value']);
			}
		}

		$coupon_category_sub 		= $this->couponmodel->coupon_category_all;
		$set_coupon_form			= $this->couponmodel->set_coupon_form;			//쿠폰종류/발급방식에 따른 등록폼설정값

		$this->load->library('searchsetting');
		$_default 						= array('orderby'=>'coupon_seq','sort'=>'desc','page'=>0,'perpage'=>10);
		$scRes 							= $this->searchsetting->pagesearchforminfo("coupon_catalog",$_default);
		$sc_form 						= $scRes['form'];
		$sc_form['coupon_category']		= $this->couponmodel->coupon_category;			//쿠폰종류(상품/배송비/주문서/마일리지)
		$sc_form['coupon_category_sub'] = $coupon_category_sub;							//쿠폰타입,발급방식
		$this->template->assign('sc_form',$sc_form);

		unset($scRes['form']);

		### SEARCH
		$sc					= $scRes;
		if(!$sc['sc_coupon_category'])	$sc['sc_coupon_category'] = "all";
		if(!$sc['issue_stop'])			$sc['issue_stop'] = "all";
		if(!$sc['use_type'])			$sc['use_type'] = "all";
		if(!$sc['sale_agent'])			$sc['sale_agent'] = "all";
		if(!$sc['sale_payment'])		$sc['sale_payment'] = "all";
		$sc['checkbox']['sc_coupon_category'][$sc['sc_coupon_category']]	= "checked";
		$sc['checkbox']['issue_stop'][$sc['issue_stop']]					= "checked";
		$sc['checkbox']['use_type'][$sc['use_type']]						= "checked";
		$sc['checkbox']['sale_agent'][$sc['sale_agent']]					= "checked";
		$sc['checkbox']['sale_payment'][$sc['sale_payment']]				= "checked";

		if($sc['sale_store_item']) $sc['selected']['sale_store_item'][$sc['sale_store_item']] = "selected";

		// o2o 쿠폰 매장 추가
		$this->load->library('o2o/o2oinitlibrary');
		$this->o2oinitlibrary->init_admin_coupon_page($sc);


		$this->template->assign('checked',$checked);
		$result = $this->couponmodel->coupon_list($sc);

		### PAGE & DATA
		$sc['searchcount']		= $result['page']['searchcount'];
		$sc['total_page']		= @ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount']		= $result['page']['totalcount'];

		$this->template->assign('sc',$sc);
		$this->template->define(array('searchForm' => $this->skin.'/coupon/_search_form.html'));

		foreach($result['record'] as $key=>$datarow){

			$date_tmp				= explode(" ",$datarow['regist_date']);
			$datarow['date']		= $date_tmp[0]."<br />".$date_tmp[1];
			$datarow['limit_goods_price_title'] = ( $datarow['type'] == 'offline_emoney' || $datarow['type'] == 'point')?"-":get_currency_price($datarow['limit_goods_price']);
			$datarow['issue_stop_title']	= ($datarow['issue_stop']=='1') ? "<span class='red bold'>발급 중지</span>" : "발급 중";

			//유효기간항목
			if($datarow['type'] == 'offline_emoney' ) {
				$datarow['issuedate']	= ' - ';
			}else{
				if( $datarow['issue_priod_type'] == 'months' ) {
					$datarow['issuedate']	= '해당월 말일';
				}elseif( $datarow['issue_priod_type'] == 'date' ) {
					$datarow['issuedate']	= $datarow['issue_startdate'].' <br/> '.$datarow['issue_enddate'];
				}else{
					$datarow['issuedate']	= '발급일~'.number_format($datarow['after_issue_day']).'일';
				}
			}

			$dsc['whereis']				= ' and coupon_seq='.$datarow['coupon_seq'];
			$downloadtotal				= $this->couponmodel->get_download_total_count($dsc);
			$datarow['downloadtotal']	= number_format($downloadtotal);//발급수

			$usc['whereis']				= ' and coupon_seq='.$datarow['coupon_seq'].' and use_status = \'used\' ';
			$usetotal					= $this->couponmodel->get_download_total_count($usc);

			$datarow['usetotal']		= number_format($usetotal);//사용건수
			$datarow['issueimg']		= 'online';
			if(strstr($datarow['type'],'offline')){
				//$datarow['use_type'] = '온라인에서<br/>인증 후 사용';
				$datarow['issueimg'] = 'print';
			}

			$issued_method = $datarow['type'];
			$issued_method .= ($datarow['sale_store'] == 'off')?'_off':'';
			//$datarow_ctype = $this->couponmodel->get_coupon_category($datarow['type'],array('coupon_category_name','coupon_type_name'));
			$datarow['coupon_category_name']	= $sc_form['coupon_category'][$datarow['coupon_category']];		// 쿠폰유형
			$datarow['coupon_type']				= $coupon_category_sub[$datarow['coupon_category']][$issued_method];				// 쿠폰종류

			//혜택
			if( $datarow['coupon_category'] == "shipping" ){//배송비
				$datarow['salepricetitle']	= ($datarow['shipping_type'] == 'free' ) ? '무료, 최대 '.get_currency_price($datarow['max_percent_shipping_sale'],2,'basic'): '배송비 '.get_currency_price($datarow['won_shipping_sale'],2,'basic');//
			}elseif($datarow['type'] == 'offline_emoney' ){//오프라인 마일리지쿠폰
				$datarow['salepricetitle']	='마일리지 '.get_currency_price($datarow['offline_emoney'],2,'basic').' 지급';
			}else{
				$datarow['salepricetitle']	= ($datarow['sale_type'] == 'percent' ) ? $datarow['percent_goods_sale'].'% 할인 (최대 '.get_currency_price($datarow['max_percent_goods_sale'],2,'basic').")": get_currency_price($datarow['won_goods_sale'],2,'basic')." 할인";
			}

			if($set_coupon_form[$datarow['type']]['issuedTo'] == "direct"){		//직접발급시
				$datarow['directbtn']	= (( $datarow['issue_priod_type'] == 'date' && str_replace("-","", substr($datarow['issue_enddate'],0,10)) < date("Ymd"))) ? "":"<button type='button' class='resp_btn active' onClick=\"gCouponIssued.open({'issued_seq':'".$datarow['coupon_seq']."','issued_title_name':'".addslashes($datarow['coupon_name'])."','download_limit':'".$datarow['download_limit']."','issued_type':'coupon'})\">발급</button>";
			}else{
				$datarow['directbtn']	= "";
				//if( $datarow['use_type']=='offline' ) $datarow['issuebtn'].=" (매장)";
			}
			$result['record'][$key] = $datarow;
		}

		###
		if(isset($result)) $this->template->assign($result);

		if($_GET['mode'] == 'old'){
			$file_path = str_replace("catalog.html","catalog_old.html",$this->template_path());
		}else{
			$file_path = $this->template_path();
		}
		$this->template->assign(array('sc'=>$sc,'scObj'=>json_encode($sc)));

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	//쿠폰적용 상품조회
	public function coupongoodsreviewer()
	{
		if( $this->input->get('download_seq') ){
			$this->coupondown = true;
		}

		$no = (int) $this->input->get('no') ;
		if($this->coupondown) {
			$this->couponinfo 	= $this->couponmodel->get_download_coupon($no);
		}else{
			$this->couponinfo 	= $this->couponmodel->get_coupon($no);
		}

		if( $this->couponinfo['coupon_type'] == 'offline' ) {
			$this->offline();
		}else{
			$this->online();
		}
	}


	public function regist()
	{
		// o2o 쿠폰 매장 추가
		$this->load->library('o2o/o2oinitlibrary');
		$this->o2oinitlibrary->init_admin_coupon_page();

		$checked_ = $selected_ = $_hide = array();

		// Admin UX/UI 개편. @2020.02.10 pjm 정의 시작
		$set_coupon_category		= $this->couponmodel->coupon_category;
		$set_coupon_category_sub	= $this->couponmodel->coupon_category_sub;			//쿠폰종류/발급방식에 따른 등록폼설정값
		$set_coupon_form			= $this->couponmodel->set_coupon_form;

		$no = $this->input->get('no');

		if(isset($no)) {

			$this->load->model('goodsmodel');
			$this->load->model('categorymodel');
			$this->load->model('providermodel');

			if($this->coupondown) {
				$coupons 		= ($this->couponinfo)?$this->couponinfo:$this->couponmodel->get_download_coupon($no);
				$coupons['coupondown'] = $this->coupondown;
			}else{
				$coupons 			= ($this->couponinfo)?$this->couponinfo:$this->couponmodel->get_coupon($no);
			}

			// 2020.02.12 추가
			$coupons['issued_method'] = $coupons['type'];
			$coupons['issued_method'] .= ($coupons['sale_store'] == 'off')?'_off':'';
			if($coupons['coupon_category']){
				foreach($set_coupon_category_sub[$coupons['coupon_category']] as $k=>$v){
					foreach($v['list'] as $k2=>$v2){
						if($coupons['type'] == $k2){ $coupons['coupon_type'] = $k; }
					}
				}
			}

			// o2o 쿠폰 매장 추가
			$this->load->library('o2o/o2oinitlibrary');
			$this->o2oinitlibrary->init_admin_coupon($coupons);


			if( $coupons['type'] == 'mobile' ) {//기존 모바일쿠폰제외
				$coupons['type']				= 'download';//상품쿠폰으로 대체
				//$coupons['sale_agent']	= ($coupons['sale_agent']!= 'm')?'m':'';//사용환경 모바일로 대체
			}
			if (!isset($coupons['coupon_seq'])) pageBack('잘못된 접근입니다.');

			//선택된 회원등급리스트
			$couponGroups 	= $this->couponmodel->get_coupon_group($no);
			if($couponGroups){
				$this->template->assign(array('couponGroups'=>$couponGroups));
			}

			//선택된 입점사 리스트
			if	($coupons['provider_list']){
				$coupons['provider_name_list']		= $this->providermodel->get_provider_select_list($coupons['provider_list']);
				$coupons['discount_seller_type']	= "seller";
			}

			if($this->coupondown) {
				$issuegoods 	= $this->couponmodel->get_coupon_download_issuegoods($no,$coupons['issue_type']);
				$issuecategorys	= $this->couponmodel->get_coupon_download_issuecategory($no,$coupons['issue_type']);
			}else{
				$issuegoods 	= $this->couponmodel->get_coupon_issuegoods($no,$coupons['issue_type']);
				$issuecategorys	= $this->couponmodel->get_coupon_issuecategory($no,$coupons['issue_type']);
			}
			// 선택된 상품, 카테고리
			if(($issuegoods)){
				$issuegoods = $this->goodsmodel->get_select_goods_list($issuegoods);
				$this->template->assign(array('issuegoods'=>$issuegoods));
			}
			if($issuecategorys){
				foreach($issuecategorys as $key =>$data) $issuecategorys[$key]['category'] = $this->categorymodel -> get_category_name($data['category_code']);
				$this->template->assign(array('issuecategorys'=>$issuecategorys));
			}

			$dsc['whereis']					= ' and coupon_seq='.$coupons['coupon_seq'];
			$downloadtotal					= $this->couponmodel->get_download_total_count($dsc);
			$coupons['downloadtotalbtn']	= number_format($downloadtotal);

			$usc['whereis']					= ' and coupon_seq='.$coupons['coupon_seq'].' and use_status = \'used\' ';
			$usetotal						= $this->couponmodel->get_download_total_count($usc);
			$coupons['usetotalbtn']			= number_format($usetotal);//사용건수

			if(strstr($coupons['type'],"offline")){
				if($coupons['offline_type'] == 'file'){//엑셀등록인 경우
					$coupons['offlinecoupontotal'] = $this->couponmodel->get_offlinecoupon_input_item_total_count($coupons['coupon_seq']);
				}else{
					$coupons['offlinecoupontotal'] = $this->couponmodel->get_offlinecoupon_item_total_count($coupons['coupon_seq']);
				}
			}
			// 기간이 있을경우 -> 시간 가공 후 처리
			if($coupons['download_startdate'])	$coupons['download_starthour']	= date('H', strtotime($coupons['download_startdate']));
			if($coupons['download_startdate'])	$coupons['download_startmin']	= date('i', strtotime($coupons['download_startdate']));
			if($coupons['download_startdate'])	$coupons['download_startdate']	= date('Y-m-d', strtotime($coupons['download_startdate']));
			if($coupons['download_enddate'])	$coupons['download_endhour']	= date('H', strtotime($coupons['download_enddate']));
			if($coupons['download_enddate'])	$coupons['download_endmin']		= date('i', strtotime($coupons['download_enddate']));
			if($coupons['download_enddate'])	$coupons['download_enddate']	= date('Y-m-d', strtotime($coupons['download_enddate']));

			if($coupons['download_starttime'])	$coupons['download_starttime_h']= date('H', strtotime($coupons['download_starttime']));
			if($coupons['download_starttime'])	$coupons['download_starttime_m']= date('i', strtotime($coupons['download_starttime']));
			if($coupons['download_endtime'])	$coupons['download_endtime_h']	= date('H', strtotime($coupons['download_endtime']));
			if($coupons['download_endtime'])	$coupons['download_endtime_m']	= date('i', strtotime($coupons['download_endtime']));

			if( $this->coupondown ) {
				$todayck = date("Y-m-d",time());
				if( $coupons['issue_enddate'] >= date("Y-m-d") ) {
					$issuedaylimit = intval((strtotime($coupons['issue_enddate'])-strtotime($todayck)) / 86400);
					$coupons['issuedaylimit'] = $issuedaylimit;
					$coupons['issuedaylimituse'] = true;
				}else{
					$issuedaylimit = intval((strtotime($todayck)-strtotime($coupons['issue_enddate'])) / 86400);
					$coupons['issuedaylimit'] = $issuedaylimit;
				}
			}else{
				if( $coupons['issue_priod_type'] == 'date') {
					$todayck = date("Y-m-d",time());
					$coupons['issuedaylimit'] = 0;
					if( $coupons['issue_enddate'] >= date("Y-m-d") ) {
						$issuedaylimit = intval((strtotime($coupons['issue_enddate'])-strtotime($todayck)) / 86400);
						$coupons['issuedaylimit'] = $issuedaylimit;
						$coupons['issuedaylimituse'] = true;
					}else{
						$issuedaylimit = intval((strtotime($todayck)-strtotime($coupons['issue_enddate'])) / 86400);
						$coupons['issuedaylimit'] = $issuedaylimit;
					}
				}
			}

			// 선택된 유입경로할인 리스트
			$this->load->model('referermodel');
			$referersaleloop			= $this->referermodel->get_referersale_all('');
			$this->template->assign(array('referersaleloop'=>$referersaleloop));
			$salerefereritem = explode(",",$coupons['sale_referer_item']);
			unset($salserefereritemloop);
			foreach($salerefereritem as $key=>$sale_referer_item_val ) {
				if(!$sale_referer_item_val)continue;
				foreach($referersaleloop as $referersale ) {
					if( !in_array($salserefereritemloopa,$sale_referer_item_val) && $referersale['referersale_seq'] == $sale_referer_item_val ) {
						$salserefereritemloopa[] = $sale_referer_item_val;
						$salserefereritemloop[$key]['referersale_seq']		= $sale_referer_item_val;
						$salserefereritemloop[$key]['referersale_name']	= $referersale['referersale_name'];
					}
				}
			}
			if($salserefereritemloop) $this->template->assign(array('salserefereritemloop'=>$salserefereritemloop));

			$coupons['type_title'] = $this->couponmodel->couponTypeTitle[$coupons['type']];
			//할인 금액 부담율 기본값 지정
			if(empty($coupons['provider_list'])){ $coupons['provider_list'] = 1; }

			if(in_array($coupons['type'],array("birthday","anniversary"))){
				$coupons['beforeDay'] = $coupons['before_'.$coupons['type']];
				$coupons['afterDay'] = $coupons['after_'.$coupons['type']];
			}

			//
			if($coupons['sale_type'] == "won"){
				$coupons['goods_sale_price'] = $coupons['won_goods_sale'];
			}else{
				$coupons['goods_sale_price'] = $coupons['percent_goods_sale'];
			}
			if($coupons['offline_type'] == "random" || $coupons['offline_type'] == "one"){
				$coupons['certificate_issued_type'] = "auto";
			}else{
				$coupons['certificate_issued_type'] = "manual";
			}
			if($coupons['offline_reserve_select'] == "year" || $coupons['offline_reserve_select'] == "direct"){
				$coupons['period_limit'] = "limit";
			}else{
				$coupons['period_limit'] = "unlimit";
			}
			if(!$coupons['sale_referer_type']) $coupons['sale_referer_type'] = "a";

			if(!$coupons['download_period_use']){
				if($coupons['download_startdate'] || $coupons['download_enddate']){
					$coupons['download_period_use'] = "limit";
				}else{
					$coupons['download_period_use'] = "unlimit";
				}
			}
			if($coupons['shipping_type'] == "free"){
				$coupons['wonShippingSale'] = $coupons['max_percent_shipping_sale'];
			}else{
				$coupons['wonShippingSale'] = $coupons['won_shipping_sale'];
			}
			//---------------------------------------------------------------------------------------------
			// check, select 선택된 값 정의
			$checked_['coupon_category'][$coupons['coupon_category']]					= "checked";
			$checked_['discount_seller_type'][$coupons['discount_seller_type']]			= "checked";
			$checked_['download_period_use'][$coupons['download_period_use']]					= "checked";
			$checked_['period_limit'][$coupons['period_limit']]							= "checked";
			$checked_['offline_reserve_select'][$coupons['offline_reserve_select']]		= "checked";
			$checked_['issue_priod_type'][$coupons['issue_priod_type']]					= "checked";
			$checked_['duplication_use'][$coupons['duplication_use']]					= "checked";
			$checked_['download_limit'][$coupons['download_limit']]						= "checked";
			$checked_['certificate_issued_type'][$coupons['certificate_issued_type']]	= "checked";
			$checked_['offline_type'][$coupons['offline_type']]							= "checked";
			$checked_['coupon_same_time'][$coupons['coupon_same_time']]					= "checked";
			$checked_['issue_type'][$coupons['issue_type']]								= "checked";
			$checked_['sale_agent'][$coupons['sale_agent']]								= "checked";
			$checked_['sale_payment'][$coupons['sale_payment']]							= "checked";
			$checked_['sale_referer'][$coupons['sale_referer']]							= "checked";
			$checked_['sale_referer_type'][$coupons['sale_referer_type']]				= "checked";
			$checked_['sale_store'][$coupons['sale_store']]								= "checked";

			$checked_['coupon_img'][$coupons['coupon_img']]								= "checked";
			$checked_['coupon_mobile_img'][$coupons['coupon_mobile_img']]				= "checked";
			if($coupons['coupon_img'] == 4 || $coupons['coupon_mobile_img'] == 4){
				$checked_['coupon_image_set']['upload']									= "checked";
			}else{
				$checked_['coupon_image_set']['basic']									= "checked";
			}
			if($coupons['download_week']){
				for($i = 0; $i < strlen($coupons['download_week']); $i++){
					$checked_['download_week'][substr($coupons['download_week'],$i,1)]	= "checked";
				}
			}

			$selected_['sale_type'][$coupons['sale_type']]								= "selected";
			$selected_['offlineLimit_input'][$coupons['offline_limit']]					= "selected";
			$selected_['offlineLimit_one'][$coupons['offlineLimit_one']]				= "selected";
			$selected_['shipping_type'][$coupons['shipping_type']]						= "selected";


			$selected_['download_endhour'][$coupons['download_endhour']]				= "selected";
			$selected_['download_endmin'][$coupons['download_endmin']]					= "selected";
			$selected_['download_endtime_h'][$coupons['download_endtime_h']]			= "selected";
			$selected_['download_endtime_m'][$coupons['download_endtime_m']]			= "selected";

			// 관리자 직접 발급 버튼 노출
			if($set_coupon_form[$coupons['type']]['issuedTo'] == "direct"){
				$adminissuebtn	= (( $coupons['issue_priod_type'] == 'date' && str_replace("-","", substr($coupons['issue_enddate'],0,10)) < date("Ymd"))) ? false:true;
				$this->template->assign(array('adminissuebtn'=>$adminissuebtn));
			}

		} else{

			//---------------------------------------------------------------------------------------------
			// 신규등록 초기 값
			$checked_['discount_seller_type']['admin']							= "checked";
			$checked_['download_period_use']['unlimit']							= "checked";
			$checked_['issue_priod_type']['date']								= "checked";
			$checked_['duplication_use']['0']									= "checked";
			$checked_['coupon_same_time']['Y']									= "checked";
			$checked_['issue_type']['all']										= "checked";
			$checked_['sale_agent']['a']										= "checked";
			$checked_['sale_payment']['a']										= "checked";
			$checked_['sale_referer']['a']										= "checked";
			$checked_['coupon_category']['goods']								= "checked";
			$checked_['coupon_img']['1']										= "checked";
			$checked_['coupon_mobile_img']['1']									= "checked";
			$checked_['coupon_image_set']['basic']								= "checked";
			$checked_['download_limit']['unlimit']								= "checked";
			$checked_['sale_referer_type']['a']									= "checked";
			$checked_['certificate_issued_type']['auto']						= "checked";
			$checked_['offline_type']['input']									= "checked";
			$checked_['period_limit']['unlimit']								= "checked";
			$checked_['offline_reserve_select']['year']							= "checked";

			$selected_['download_endhour']['23']								= "selected";
			$selected_['download_endmin']['59']									= "selected";
			$selected_['download_endtime_h']['23']								= "selected";
			$selected_['download_endtime_m']['59']								= "selected";

			$coupons = array();
			$coupons['use_type']				= "online";
			$coupons['offline_random_num']		= 1;
			$coupons['offlineLimitEa_one']		= 1;
			$coupons['after_issue_day']			= 0;
			$coupons['after_upgrade']			= 0;
			$coupons['offline_reserve_year']	= 0;
			$coupons['offline_reserve_direct']	= 0;
			$coupons['beforeDay']				= 7;
			$coupons['afterDay']				= 7;

		}

		// serviceLimit('H_NFR') 무료몰제외 1
		$this->template->assign(array('coupons'=>$coupons));
		$this->template->assign(array('selected_'=>$selected_,'checked_'=>$checked_));

		//$couponfilename = getcouponpagepopup($coupons);		//어디서쓰는지 알수없음
		//$this->template->assign('couponfilename',$couponfilename);
		$this->template->assign('coupon_category',$set_coupon_category);
		$this->template->assign('coupon_category_sub',$set_coupon_category_sub);
		$this->template->assign('set_coupon_form',$set_coupon_form);

		$this->template->assign('mode',$this->input->get('mode'));
		$this->template->assign('query_string',$this->input->get('query_string'));
		if( !$this->coupongoodsreviewer ) {  
			$this->template->assign("offline_coupon_form",get_interface_sample_path("20210510/offline_coupon_form.xls"));
			//$this->template->define(array('onlinecoupontypelayer' => $this->skin.'/coupon/onlinecoupontype.html'));
			//$this->template->assign(array('membertypedisabled'=>$membertypedisabled));
			$this->template->print_("tpl");
		}
	}

	public function get_category_sub(){

		// Admin UX/UI 개편. @2020.02.10 pjm 정의 시작
		$set_coupon_category_sub	= $this->couponmodel->coupon_category_sub;			//쿠폰종류/발급방식에 따른 등록폼설정값
		$set_coupon_service			= $this->couponmodel->coupon_service_limit;

		$category 					= $_POST['coupon_category'];
		$res 						= $set_coupon_category_sub[$category];

		// 무료몰일 때 쿠폰 제한 체크
		$coupon_service_limit = $set_coupon_service['H_NFR'];
		foreach($res as $k => $v){
			foreach($v['list'] as $k2=>$v2){
				//무료몰 제한 쿠폰 삭제
				if(in_array($k2,$coupon_service_limit) && !serviceLimit('H_NFR')){
					unset($res[$k]['list'][$k2]);
				}
			}
		}

		echo json_encode($res);

	}


	// 등록폼 설정값
	public function get_coupon_regist_form(){

		$this->config->load("couponSet");

		$issued_method		= $_POST['issued_method'];
		$set_coupon_form	= $this->config->item("set_coupon_form");			//쿠폰종류/발급방식에 따른 등록폼설정값
		$res				= $set_coupon_form[$issued_method];

		//무료몰일 때 :: 쿠폰사용제한에서 유입경로 할인 사용 안하도록 기능 제한.
		if(!serviceLimit('H_NFR')) $res['refererLimit'] = 'n';

		echo json_encode($res);

	}


	public function online()
	{
		// o2o 쿠폰 매장 추가
		$this->load->library('o2o/o2oinitlibrary');
		$this->o2oinitlibrary->init_admin_coupon_page();

		if(isset($_GET['no'])) {
			$no = (int) $_GET['no'];


			$this->load->model('goodsmodel');
			$this->load->model('categorymodel');
			$this->load->model('providermodel');

			if($this->coupondown) {
				$coupons 		= ($this->couponinfo)?$this->couponinfo:$this->couponmodel->get_download_coupon($no);
				$coupons['coupondown'] = $this->coupondown;
			}else{
				$coupons 			= ($this->couponinfo)?$this->couponinfo:$this->couponmodel->get_coupon($no);
			}

			// o2o 쿠폰 매장 추가
			$this->load->library('o2o/o2oinitlibrary');
			$this->o2oinitlibrary->init_admin_coupon($coupons);


			if( $coupons['type'] == 'mobile' ) {//기존 모바일쿠폰제외
				$coupons['type']				= 'download';//상품쿠폰으로 대체
				//$coupons['sale_agent']	= ($coupons['sale_agent']!= 'm')?'m':'';//사용환경 모바일로 대체
			}
			if (!isset($coupons['coupon_seq'])) pageBack('잘못된 접근입니다.');
			$couponGroups 	= $this->couponmodel->get_coupon_group($no);
			if($this->coupondown) {
				$issuegoods 	= $this->couponmodel->get_coupon_download_issuegoods($no);
				$issuecategorys	= $this->couponmodel->get_coupon_download_issuecategory($no);
			}else{
				$issuegoods 	= $this->couponmodel->get_coupon_issuegoods($no);
				$issuecategorys	= $this->couponmodel->get_coupon_issuecategory($no);
			}
			if	($coupons['provider_list']){

				$sc['orderby']	= 'provider_name';
				$sc['sort']		= 'asc';
				$sc['page']		= 0;
				$sc['perpage']	= 9999;
				$provider		= $this->providermodel->provider_list($sc);
				$provider_seq	= array();

				if	($provider){
					foreach($provider['result'] as $k => $data){
						$provider_seq[$data['provider_seq']]	= $data;
					}
				}


				$provider_list	= substr(substr($coupons['provider_list'], 1), 0, -1);
				$provider_arr	= explode('|', $provider_list);
				if	(count($provider_arr) > 0){
					$provider_select_list	= $this->providermodel->get_provider_range($provider_arr);
					if	($provider_select_list){
						foreach($provider_select_list as $k => $data){
							if	($k > 0)	$provider_name_list	.= '<br />';
							// 입점사의 수수료 정책 잘 가져오도록 수정 2019-08-09 by hyem
							$commission = $add_commission_text = "";
							$commission				= $provider_seq[$data['provider_seq']]['commission_type'];
							$add_commission_text	= ($commission == 'SACO' || $commission == '') ? '("수수료"정산)' : '("공급가"정산)';
							$provider_name_list	.= $data['provider_name'].$add_commission_text;
						}
					}
				}

				$coupons['provider_name_list']	= $provider_name_list;
			}
			if($couponGroups){
				foreach($this->groups as $tmp){
					foreach($couponGroups as $key => $group){
						if($tmp['group_seq'] == $group['group_seq']){
							$couponGroups[$key]['group_name'] = $tmp['group_name'];
							$couponGroupsNew[] = $couponGroups[$key];
						}
					}
				}
				$this->template->assign(array('couponGroups'=>$couponGroupsNew));
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

			$dsc['whereis'] = ' and coupon_seq='.$coupons['coupon_seq'];
			$downloadtotal = $this->couponmodel->get_download_total_count($dsc);
			$coupons['downloadtotal']	= 0;//발급수-> 수정가능하도록 수정@2012-06-08
			$coupons['downloadtotalbtn']	= number_format($downloadtotal);

			$usc['whereis'] = ' and coupon_seq='.$coupons['coupon_seq'].' and use_status = \'used\' ';
			$usetotal = $this->couponmodel->get_download_total_count($usc);
			$coupons['usetotalbtn']	= number_format($usetotal);//사용건수

			// 기간이 있을경우 -> 시간 가공 후 처리
			if($coupons['download_startdate'])	$coupons['download_starthour']	= date('H', strtotime($coupons['download_startdate']));
			if($coupons['download_startdate'])	$coupons['download_startmin']	= date('i', strtotime($coupons['download_startdate']));
			if($coupons['download_startdate'])	$coupons['download_startdate']	= date('Y-m-d', strtotime($coupons['download_startdate']));
			if($coupons['download_enddate'])	$coupons['download_endhour']	= date('H', strtotime($coupons['download_enddate']));
			if($coupons['download_enddate'])	$coupons['download_endmin']		= date('i', strtotime($coupons['download_enddate']));
			if($coupons['download_enddate'])	$coupons['download_enddate']	= date('Y-m-d', strtotime($coupons['download_enddate']));

			if($coupons['download_starttime'])	$coupons['download_starttime_h']= date('H', strtotime($coupons['download_starttime']));
			if($coupons['download_starttime'])	$coupons['download_starttime_m']= date('i', strtotime($coupons['download_starttime']));
			if($coupons['download_endtime'])	$coupons['download_endtime_h']	= date('H', strtotime($coupons['download_endtime']));
			if($coupons['download_endtime'])	$coupons['download_endtime_m']	= date('i', strtotime($coupons['download_endtime']));

			if( $this->coupondown ) {
				$todayck = date("Y-m-d",time());
				if( $coupons['issue_enddate'] >= date("Y-m-d") ) {
					$issuedaylimit = intval((strtotime($coupons['issue_enddate'])-strtotime($todayck)) / 86400);
					$coupons['issuedaylimit'] = $issuedaylimit;
					$coupons['issuedaylimituse'] = true;
				}else{
					$issuedaylimit = intval((strtotime($todayck)-strtotime($coupons['issue_enddate'])) / 86400);
					$coupons['issuedaylimit'] = $issuedaylimit;
				}
			}else{
				if( $coupons['issue_priod_type'] == 'date') {
					$todayck = date("Y-m-d",time());
					$coupons['issuedaylimit'] = 0;
					if( $coupons['issue_enddate'] >= date("Y-m-d") ) {
						$issuedaylimit = intval((strtotime($coupons['issue_enddate'])-strtotime($todayck)) / 86400);
						$coupons['issuedaylimit'] = $issuedaylimit;
						$coupons['issuedaylimituse'] = true;
					}else{
						$issuedaylimit = intval((strtotime($todayck)-strtotime($coupons['issue_enddate'])) / 86400);
						$coupons['issuedaylimit'] = $issuedaylimit;
					}
				}
			}

			if($coupons['download_week']){
				$downweek = "";

				if(strpos($coupons['download_week'],'1') > 0)	$downweek .= ",월";
				if(strpos($coupons['download_week'],'2') > 0)	$downweek .= ",화";
				if(strpos($coupons['download_week'],'3') > 0)	$downweek .= ",수";
				if(strpos($coupons['download_week'],'4') > 0)	$downweek .= ",목";
				if(strpos($coupons['download_week'],'5') > 0)	$downweek .= ",금";
				if(strpos($coupons['download_week'],'6') > 0)	$downweek .= ",토";
				if(strpos($coupons['download_week'],'7') > 0)	$downweek .= ",일";

				$downweek = substr($downweek,1,strlen($downweek));
				$coupons['download_enddatetitle_week'] = $downweek . " 요일 다운가능";
			}
			$coupons['type_title'] = $this->couponmodel->couponTypeTitle[$coupons['type']];

			$this->template->assign(array('coupons'=>$coupons));
		}

		if( $coupons['type'] == 'admin' || $coupons['type'] == 'admin_shipping' ){//직접발급시
			$adminissuebtn	= (( $coupons['issue_priod_type'] == 'date' && str_replace("-","", substr($coupons['issue_enddate'],0,10)) < date("Ymd"))) ? false:true;
			$this->template->assign(array('adminissuebtn'=>$adminissuebtn));
		}

		$this->load->model('referermodel');
		$referersaleloop			= $this->referermodel->get_referersale_all('');
		$this->template->assign(array('referersaleloop'=>$referersaleloop));
		$salerefereritem = explode(",",$coupons['sale_referer_item']);
		unset($salserefereritemloop);
		foreach($salerefereritem as $key=>$sale_referer_item_val ) {
			if(!$sale_referer_item_val)continue;
			foreach($referersaleloop as $referersale ) {
				if( !in_array($salserefereritemloopa,$sale_referer_item_val) && $referersale['referersale_seq'] == $sale_referer_item_val ) {
					$salserefereritemloopa[] = $sale_referer_item_val;
					$salserefereritemloop[$key]['referersale_seq']		= $sale_referer_item_val;
					$salserefereritemloop[$key]['referersale_name']	= $referersale['referersale_name'];
				}
			}
		}
		if($salserefereritemloop) $this->template->assign(array('salserefereritemloop'=>$salserefereritemloop));

		$couponfilename = getcouponpagepopup($coupons);
		$this->template->assign('couponfilename',$couponfilename);


		$this->template->assign('query_string',$_GET['query_string']);
		if( !$this->coupongoodsreviewer ) {
			$this->template->define(array('onlinecoupontypelayer' => $this->skin.'/coupon/onlinecoupontype.html'));
			$this->template->assign(array('membertypedisabled'=>$membertypedisabled));
			$this->template->print_("tpl");
		}
	}

	// 쿠폰별 팝업
	public function coupon_popup_setting(){

		$coupon_service_limit 	= $this->couponmodel->coupon_service_limit;
		$coupon_all_list		= $this->couponmodel->coupon_all_list;
		$coupon_type 			= (!$_GET['type'])? 'birthday':$_GET['type'];

		//무료몰 제한 쿠폰 예외 처리
		if(!serviceLimit('H_NFR') && (in_array($coupon_type,$coupon_service_limit['H_NFR']))) {
			serviceLimit('H_FR','process');	// 잘못된 접근 입니다.
		}

		$coupons				= array("type"=>$coupon_type);
		$coupons['type_title']	= $this->couponmodel->couponTypeTitle[$coupon_type];
		$couponpopupuse			= config_load('couponpopupuse',$coupon_type.'_popup_use');
		$coupons['popup_use']	= $couponpopupuse[$coupon_type.'_popup_use'];
		$this->template->assign(array('coupons'=>$coupons));

		$couponfilename			= getcouponpagepopup($coupons);
		$this->template->assign('couponfilename',$couponfilename);

		// 팝업제공하는 쿠폰 리스트
		$coupon_popup_list 		= array();
		foreach($this->couponmodel->coupon_popup as $_key=>$_type){
			if($coupon_service_limit['H_NFR'] && in_array($_type,$coupon_service_limit['H_NFR']) && !serviceLimit('H_NFR')){
				//무료몰 제한 쿠폰 예외 처리
			}else{
				$coupon_popup_list[$_type] = $coupon_all_list[$_type];
			}
		}
		$this->template->assign('coupon_popup_list',$coupon_popup_list);

		$this->load->helper('file');
		$origin_file			= explode("/",$this->file_path);
		$codeall				= str_replace($origin_file[count($origin_file)-1],"/codeall.html",$this->file_path);
		$tpl_source_all			= read_file(ROOTPATH."admin/skin/".$codeall);
		$codeall_mobile			= str_replace($origin_file[count($origin_file)-1],"/codeall_mobile.html",$this->file_path);
		$tpl_source_all_mobile	= read_file(ROOTPATH."admin/skin/".$codeall_mobile);

		$coupondowntarget 		= coupondowntargethtml($_GET['type']);
		$tpl_source_all 		= str_replace("{다운대상기간치환}",$coupondowntarget,str_replace("{쿠폰유형}",$_GET['type'],str_replace("{쿠폰고유번호}",$_GET['coupon_seq'],$tpl_source_all)));
		$tpl_source_all_mobile 	= str_replace("{다운대상기간치환}",$coupondowntarget,str_replace("{쿠폰유형}",$_GET['type'],str_replace("{쿠폰고유번호}",$_GET['coupon_seq'],$tpl_source_all_mobile)));

		$tpl_source_all 		= str_replace("<","&lt;",str_replace(">","&gt;",$tpl_source_all));
		$this->template->assign(array('couponcodeallhtml'=>$tpl_source_all,'couponcodehtml'=>$tpl_source,'couponcodeallhtml_mobile'=>$tpl_source_all_mobile,'couponcodehtml_mobile'=>$tpl_source_mobile));


		$this->template->print_("tpl");

	}


	//코드보기
	public function online_code()
	{
		if(serviceLimit('H_FR') && ($_GET['type'] == 'memberlogin' || $_GET['type'] == 'membermonths' || $_GET['type'] == 'order')){
			serviceLimit('H_FR','process');
		}
		$coupons				= array("type"=>$_GET['type']);
		$coupons['type_title']	= $this->couponmodel->couponTypeTitle[$coupons['type']];
		$couponpopupuse			= config_load('couponpopupuse',$_GET['type'].'_popup_use');
		$coupons['popup_use']	= $couponpopupuse[$_GET['type'].'_popup_use'];
		$this->template->assign(array('coupons'=>$coupons));

		$couponfilename			= getcouponpagepopup($coupons);
		$this->template->assign('couponfilename',$couponfilename);

		$sc_form = array();
		$sc_form['coupon_category']	= $this->config->item("coupon_category");
		$sc_form['coupon_category_sub']	= $this->config->item("coupon_category_sub");			//쿠폰종류/발급방식에 따른 등록폼설정값
		$this->template->assign('sc_form',$sc_form);

		$this->load->helper('file');
		$codeall				= str_replace("/online_code.html","/codeall.html",$this->file_path);
		$tpl_source_all			= read_file(ROOTPATH."admin/skin/".$codeall);
		$codeall_mobile			= str_replace("/online_code.html","/codeall_mobile.html",$this->file_path);
		$tpl_source_all_mobile	= read_file(ROOTPATH."admin/skin/".$codeall_mobile);

		//$codeone= str_replace("/online_code.html","/code.html",$this->file_path);
		//$tpl_source = read_file(ROOTPATH."admin/skin/".$codeone);
		//$codeone_mobile= str_replace("/online_code.html","/code_mobile.html",$this->file_path);
		//$tpl_source_mobile = read_file(ROOTPATH."admin/skin/".$codeone_mobile);

		$coupondowntarget = coupondowntargethtml($_GET['type']);
		//$tpl_source = str_replace("{다운대상기간치환}",$coupondowntarget,str_replace("{쿠폰유형}",$_GET['type'],str_replace("{쿠폰고유번호}",$_GET['no'],$tpl_source)));
		//$tpl_source_mobile = str_replace("{다운대상기간치환}",$coupondowntarget,str_replace("{쿠폰유형}",$_GET['type'],str_replace("{쿠폰고유번호}",$_GET['no'],$tpl_source_mobile)));
		$tpl_source_all = str_replace("{다운대상기간치환}",$coupondowntarget,str_replace("{쿠폰유형}",$_GET['type'],str_replace("{쿠폰고유번호}",$_GET['no'],$tpl_source_all)));
		$tpl_source_all_mobile = str_replace("{다운대상기간치환}",$coupondowntarget,str_replace("{쿠폰유형}",$_GET['type'],str_replace("{쿠폰고유번호}",$_GET['no'],$tpl_source_all_mobile)));

		$this->template->assign(array('couponcodeallhtml'=>$tpl_source_all,'couponcodehtml'=>$tpl_source,'couponcodeallhtml_mobile'=>$tpl_source_all_mobile,'couponcodehtml_mobile'=>$tpl_source_mobile));
		$this->template->print_("tpl");
	}

	public function codeviewer()
	{
		$this->load->helper('file');
		$codeall= str_replace("/codeviewer.html","/codeall.html",$this->file_path);
		$codeone= str_replace("/codeviewer.html","/code.html",$this->file_path);
		if( $_GET['type'] == 'all' ) {
			$tpl_source = read_file(ROOTPATH."admin/skin/".$codeall);
		}else{
			$tpl_source = read_file(ROOTPATH."admin/skin/".$codeone);
		}
		if(isset($_GET['no'])) $tpl_source = str_replace("{프로모션고유번호}",$_GET['no'],$tpl_source);
		$this->template->assign(array('couponcodehtml'=>$tpl_source));
		//$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function offline()
	{
		if(isset($_GET['no'])) {
			$no = (int) $_GET['no'];
			$this->load->model('goodsmodel');
			$this->load->model('categorymodel');
			$this->load->model('providermodel');

			if($this->coupondown) {
				$coupons 		= ($this->couponinfo)?$this->couponinfo:$this->couponmodel->get_download_coupon($no);
				$coupons['coupondown'] = $this->coupondown;
			}else{
				$coupons 			= ($this->couponinfo)?$this->couponinfo:$this->couponmodel->get_coupon($no);
			}
			if (!isset($coupons['coupon_seq'])) pageBack('잘못된 접근입니다.');
			$couponGroups 	= $this->couponmodel->get_coupon_group($no);
			if($this->coupondown) {
				$issuegoods 	= $this->couponmodel->get_coupon_download_issuegoods($no);
				$issuecategorys	= $this->couponmodel->get_coupon_download_issuecategory($no);
			}else{
				$issuegoods 	= $this->couponmodel->get_coupon_issuegoods($no);
				$issuecategorys	= $this->couponmodel->get_coupon_issuecategory($no);
			}
			if	($coupons['provider_list']){
				$provider_list	= substr(substr($coupons['provider_list'], 1), 0, -1);
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

				$coupons['provider_name_list']	= $provider_name_list;
			}
			if($couponGroups){
				foreach($couponGroups as $key => $group){
					foreach($this->groups as $tmp){
						if($tmp['group_seq'] == $group['group_seq']){
							$couponGroups[$key]['group_name'] = $tmp['group_name'];
						}
					}
				}
				$this->template->assign(array('couponGroups'=>$couponGroups));
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

			$coupons['download_startdate']	= substr($coupons['download_startdate'], 0, 10);
			$coupons['download_enddate']	= substr($coupons['download_enddate'], 0, 10);

			$dsc['whereis'] = ' and coupon_seq='.$coupons['coupon_seq'];
			$downloadtotal = $this->couponmodel->get_download_total_count($dsc);
			$coupons['downloadtotal']	= 0;//발급수-> 수정가능하도록 수정@2012-06-08
			$coupons['downloadtotalbtn']	= number_format($downloadtotal);

			$usc['whereis'] = ' and coupon_seq='.$coupons['coupon_seq'].' and use_status = \'used\' ';
			$usetotal = $this->couponmodel->get_download_total_count($usc);
			$coupons['usetotalbtn']	= number_format($usetotal);//사용건수

			if($coupons['offline_type'] == 'file'){//엑셀등록인 경우
				$coupons['offlinecoupontotal'] = $this->couponmodel->get_offlinecoupon_input_item_total_count($coupons['coupon_seq']);
			}else{
				$coupons['offlinecoupontotal'] = $this->couponmodel->get_offlinecoupon_item_total_count($coupons['coupon_seq']);
			}

			if( $this->coupondown ) {
				$todayck = date("Y-m-d",time());
				if( $coupons['issue_enddate'] >= date("Y-m-d") ) {
					$issuedaylimit = intval((strtotime($coupons['issue_enddate'])-strtotime($todayck)) / 86400);
					$coupons['issuedaylimit'] = $issuedaylimit;
					$coupons['issuedaylimituse'] = true;
				}else{
					$issuedaylimit = intval((strtotime($todayck)-strtotime($coupons['issue_enddate'])) / 86400);
					$coupons['issuedaylimit'] = $issuedaylimit;
				}
			}else{
				if( $coupons['issue_priod_type'] == 'date') {
					$todayck = date("Y-m-d",time());
					$coupons['issuedaylimit'] = 0;
					if( $coupons['issue_enddate'] >= date("Y-m-d") ) {
						$issuedaylimit = intval((strtotime($coupons['issue_enddate'])-strtotime($todayck)) / 86400);
						$coupons['issuedaylimit'] = $issuedaylimit;
						$coupons['issuedaylimituse'] = true;
					}else{
						$issuedaylimit = intval((strtotime($todayck)-strtotime($coupons['issue_enddate'])) / 86400);
						$coupons['issuedaylimit'] = $issuedaylimit;
					}
				}
			}
			$this->template->assign(array('coupons'=>$coupons));
		}

		$this->load->model('referermodel');
		$referersaleloop			= $this->referermodel->get_referersale_all();
		$this->template->assign(array('referersaleloop'=>$referersaleloop));
		$salerefereritem = explode(",",$coupons['sale_referer_item']);
		unset($salserefereritemloop);
		foreach($salerefereritem as $key=>$sale_referer_item_val ) {
			if(!$sale_referer_item_val)continue;
			foreach($referersaleloop as $referersale ) {
				if( !in_array($salserefereritemloopa,$sale_referer_item_val) && $referersale['referersale_seq'] == $sale_referer_item_val ) {
					$salserefereritemloopa[] = $sale_referer_item_val;
					$salserefereritemloop[$key]['referersale_seq']		= $sale_referer_item_val;
					$salserefereritemloop[$key]['referersale_name']	= $referersale['referersale_name'];
				}
		}
		}
		if($salserefereritemloop) $this->template->assign(array('salserefereritemloop'=>$salserefereritemloop));

		$this->template->define(array('offlinecoupontypelayer' => $this->skin.'/coupon/offlinecoupontype.html'));

		$this->template->assign('query_string',$_GET['query_string']);
		if( !$this->coupongoodsreviewer ) {
			$this->template->assign(array('membertypedisabled'=>$membertypedisabled));
			$this->template->assign("offline_coupon_form",get_interface_sample_path("20210510/offline_coupon_form.xls"));
			$this->template->print_("tpl");
		}
	}

	//인쇄용쿠폰 > 엑셀등록하기
	public function offline_excel()
	{
		$coupon_seq = (int) $_GET['no'];
		$coupons 		= $this->couponmodel->get_coupon($coupon_seq);
		$this->template->assign(array('coupons'=>$coupons));
		$this->template->assign('saveinterval',3);//3초 대기
		$this->template->print_("tpl");
	}

	//인쇄용쿠폰 > 인증번호 보기
	public function offline_coupon()
	{
		$coupon_seq = (int) $_GET['no'];
		$coupons 		= $this->couponmodel->get_coupon($coupon_seq);
		$this->template->assign(array('coupons'=>$coupons));
		$this->template->print_("tpl");
	}

	//발급내역
	public function download()
	{
		$no 			= $this->input->get('no');
		$coupons 		= $this->couponmodel->get_coupon($no);
		$coupons['downloaddatetitle'] = (strstr($coupons['type'],'offline'))?'인증일/인증번호':'발급일';
		$this->template->assign(array('coupons'=>$coupons));
		$this->template->print_("tpl");
	}

	//쿠폰발급 > 회원검색페이지
	public function download_member()
	{
		$this->load->model('membermodel');

		$no				= (int) $this->input->get('no');
		$coupons 		= $this->couponmodel->get_coupon($no);
		$this->template->assign(array('coupons'=>$coupons));

		### GROUP
		$group_all		= $this->membermodel->find_group_list();
		$coupongroups 	= $this->couponmodel->get_coupon_group($no);
		if($coupongroups){
			$i =0;
			foreach($coupongroups as $key => $group){
				foreach($group_all as $tmp){
					if($tmp['group_seq'] == $group['group_seq']){
						$group_arr[$i]['group_seq'] = $tmp['group_seq'];
						$group_arr[$i]['group_name'] = $tmp['group_name'];
					}
				}$i++;
			}
		}else{
			$group_arr = $group_all;
		}
		$this->template->assign('group_arr',$group_arr);
		$this->template->print_("tpl");
	}


	//쿠폰발급 > 회원검색리스트
	public function download_member_list()
	{
		$no 			= (int) $this->input->post('no');
		$coupons 		= $this->couponmodel->get_coupon($no);
		$this->template->assign(array('coupons'=>$coupons));

		$coupongroups 	= $this->couponmodel->get_coupon_group($no);
		$coupongroupsar = '';
		if($coupongroups){
			foreach($coupongroups as $key => $group){
				$coupongroupsar[] = $group['group_seq'];
			}
		}

		$this->load->model('membermodel');

		### SEARCH
		$sc = $this->input->post();
		$sc['search_text']		= ($sc['search_text'] == '이름, 아이디, 이메일, 전화번호, 핸드폰(뒷자리4), 주소') ? '':$sc['search_text'];
		$sc['keyword']			= $sc['search_text'];
		$sc['orderby']			= 'A.member_seq';
		$sc['sort']				= (isset($sc['sort'])) ?		$sc['sort']:'desc';
		$sc['perpage']			= (!empty($sc['perpage'])) ?	intval($sc['perpage']):10;
		$sc['page']				= (!empty($sc['page'])) ?	intval(($sc['page'] - 1) * $sc['perpage']):0;
		$sc['groupsar']			= $coupongroupsar;

		### MEMBER
		$data = $this->membermodel->coupon_member_list($sc);

		// 페이징 처리 위한 변수 셋팅
		$nowpage				=  get_current_page($sc);	//현재 페이지
		$pagecount				=  get_page_count($sc, $data['count']);

		$page['html']			= pagingtag($data['count'], $sc['perpage'], "?" );
		$page['querystring']	= get_args_list($sc);
		$page['nowpage']		= $nowpage;

		### PAGE & DATA
		$sc['searchcount']		= $data['count'];
		$sc['total_page']		= @ceil($sc['searchcount']/ $sc['perpage']);
		$sc['totalcount']		= $this->membermodel->get_member_total_count();

		$idx 	= 0;
		$html 	= $this->getdownload_member_html($data, $sc,  $page, $coupons);
		if(!empty($html)) {
			$result = array( 'content'=>$html, 'searchcount'=>$sc['searchcount'], 'totalcount'=>$sc['totalcount'], 'nowpage'=>$page['nowpage'], 'total_page'=>$sc['total_page'], 'page'=>$sc['page'], 'pagecount'=>(int)$pagecount);
		}else{
			$result = array( 'content'=>"", 'searchcount'=>$sc['searchcount'], 'totalcount'=>$sc['totalcount'], 'nowpage'=>$page['nowpage'], 'total_page'=>$sc['total_page'], 'page'=>$sc['page'], 'pagecount'=>(int)$pagecount);
		}
		echo json_encode($result);
		exit;
	}

	//회원검색 > 발급내역
	function getdownload_member_html($data, $sc, $page, $coupons)
	{
		$no		= $sc['searchcount'] - ( ($sc['page']/$sc['perpage']) * $sc['perpage'] );
		foreach($data['result'] as $datarow){
			// 쿠폰 정보 확인
			$download_coupons = $this->couponmodel->get_admin_download($datarow['member_seq'], $coupons['coupon_seq']);
			$class = ($download_coupons)?" class='bg-gray' ":"";

			$datarow['_no'] = $no;
			$datarow['type']	= $datarow['business_seq'] ? '기업' : '개인';
            if($datarow['user_name'] == ""){
                $datarow['user_name'] = $datarow['bname'];
                $datarow['address'] = $datarow['baddress'];
                $datarow['address_detail'] = $datarow['baddress_detail'];
                $datarow['phone'] = $datarow['bphone'];
                $datarow['cellphone'] = $datarow['bcellphone'];
                $datarow['zipcode'] = $datarow['bzipcode'];
            }
			$html .= '<tr  '.$class.' >';
			if($download_coupons) {
				$html .= '	<td  class="its-td-align center"> </td>';
			}else{
				$html .= '	<td  class="its-td-align center"><label class="resp_checkbox"><input type="checkbox" onclick="chkmember(this);" name="member_chk[]" value="'.$datarow['member_seq'].'" cellphone="'.htmlentities($datarow['cellphone']).'" email="'.htmlentities($datarow['email']).'"  userid="'.htmlentities($datarow['userid']).'"  user_name="'.htmlentities($datarow['user_name']).'"  class="member_chk" '.$disabled.'></label></td>';
			}
			$html .= '	<td class="its-td-align center">'.$datarow['_no'].'</td>';
			$html .= '	<td class="its-td-align center">'.htmlentities($datarow['type']).'</td>';
			$html .= '	<td><span class="hand blue" onClick="open_crm_summary(this,\''.$datarow['member_seq'].'\',\'\',\'right\');" >'.htmlentities($datarow['userid']).'</span></td>';
			$html .= '	<td><span class="hand blue"  onClick="open_crm_summary(this,\''.$datarow['member_seq'].'\',\'\',\'right\');" >'.htmlentities($datarow['user_name']).'</span></td>';
			$html .= '	<td class="its-td-align center">'.htmlentities($datarow['email']).'</td>';
			$html .= '	<td class="its-td-align center">'.htmlentities($datarow['cellphone']).'</td>';
			$html .= '	<td class="its-td-align center">'.htmlentities($datarow['phone']).'</td>';
			$html .= '</tr>';
			$no--;
		}//foreach end

		if($sc['searchcount'] == 0){
			if($sc['search_text']){
				$html .= '<tr ><td class="its-td-align center" colspan="8" >"'.$sc['search_text'].'"로(으로) 검색된 회원이 없습니다.</td></tr>';
			}else{
				$html .= '<tr ><td class="its-td-align center" colspan="8" >회원이 없습니다.</td></tr>';
			}
		}
		return $html;
	}

	//쿠폰관리 > 발급내역 -> 검색 : 사용여부 , 사용일, 주문상품(주문번호) 또는 마일리지 지급
	public function downloadlist()
	{
		$no 		= $this->input->post('no');
		$coupons 	= $this->couponmodel->get_coupon($no);
		$this->template->assign(array('coupons'=>$coupons));

		### SEARCH
		$sc					= $this->input->post();
		$sc['search_text']	= ($sc['search_text'] == '아이디, 이름') ? '':$sc['search_text'];
		$sc['orderby']		= (!empty($sc['orderby'])) ?	$sc['orderby']:'download_seq';
		$sc['sort']			= (!empty($sc['sort'])) ?		$sc['sort']:'desc';
		$sc['perpage']		= (!empty($sc['perpage'])) ?	intval($sc['perpage']):10;
		$sc['page']			= (!empty($sc['page'])) ?		intval(($sc['page'] - 1) * $sc['perpage']):0;

		## 발급내역
		$data 			= $this->couponmodel->download_list($sc);
		## 발급내역 > 총 할인금액추출
		$coupon_sale 	= $this->couponmodel->get_coupontotal($sc, $coupons);

		// 페이징 처리 위한 변수 셋팅
		$page		= get_current_page($sc);
		$pagecount	= get_page_count($sc, $data['count']);

		### PAGE & DATA
		$sc['searchcount']		= $data['count'];
		$sc['total_page']		= @ceil($sc['searchcount']/ $sc['perpage']);
		$sc['totalcount']		= $this->couponmodel->get_download_item_total_count($no);

		$idx = 0;
		$html = $this->getdownloadhtml($data, $sc,  $page);

		if(!empty($html)) {
			$result = array( 'content'=>$html,'totalsaleprcie'=>get_currency_price($coupon_sale['coupon_sale'],1), 'searchcount'=>$sc['searchcount'], 'totalcount'=>$sc['totalcount'], 'nowpage'=>(($sc['page']/$sc['perpage'])+1), 'total_page'=>$sc['total_page'], 'page'=>$page, 'pagecount'=>(int)$pagecount);
		}else{
			$result = array( 'content'=>"",'totalsaleprcie'=>get_currency_price($coupon_sale['coupon_sale'],1),  'searchcount'=>$sc['searchcount'], 'totalcount'=>$sc['totalcount'], 'nowpage'=>(($sc['page']/$sc['perpage'])+1), 'total_page'=>$sc['total_page'], 'page'=>$page, 'pagecount'=>(int)$pagecount);
        }

        //관리자 로그 남기기
		$this->load->library('managerlog');
		$this->managerlog->insertData(array('params' => array('coupon_name' => $coupons['coupon_name'], 'searchcount' => $sc['searchcount'])));

		echo json_encode($result);
		exit;
	}

	//쿠폰관리 > 발급내역 NEW
	function getdownloadhtml($data, $sc, $page)
	{
		$this->load->model('ordermodel');
		$html	= '';
		$no		= $sc['searchcount'] - ( ($sc['page']/$sc['perpage']) * $sc['perpage'] );

		foreach($data['result'] as $datarow){

			$datarow['_no']		= $no;
			$date_tmp			= explode(" ",$datarow['regist_date']);
			$datarow['date']	= $date_tmp[0]."<br />".$date_tmp[1];
			$datarow['use_status_title'] = ($datarow['use_status'] == 'used') ? $datarow['use_date']:'미사용';
			if(str_replace("-","",$datarow['issue_enddate']) < date("Ymd") && $datarow['use_status'] != 'used'){
				$datarow['use_status_title'] = '<span class="gray" >유효기간 만료</span>';//미사용중 기간지남
			}

			$deletebtn = ($datarow['use_status'] == 'used')?' disabled="disabled" ':'';//

			//$datarow['use_date']			  = ($datarow['use_status'] == 'used') ? substr($datarow['use_date'],2,14):'';

			$datarow['order_seq'] = '';
			if($datarow['use_status'] == 'used') {
				if ( ( $datarow['type'] == 'shipping' || strstr($datarow['type'],'_shipping') ) ) {
					unset($order_coupon,$items);
					$order_coupon = $this->ordermodel->get_order_shipping_coupon($datarow['member_seq'], $datarow['download_seq']);
					$datarow['order_seq'] = '<span class="goods_name1 hand orderview blue" onclick="orderinfo(\''.$order_coupon[0]['order_seq'].'\');" order_seq="'.$order_coupon[0]['order_seq'].'" >'.$order_coupon[0]['order_seq'].'</span>';

					if($order_coupon[0]['order_seq']) $items 				 = $this->ordermodel->get_item($order_coupon[0]['order_seq']);
					$goods_cnt = count($items)-1;
					if($items){
						$goodsinfo = ($goods_cnt > 0) ? '<span class="goods_name1">'.$items[0]['goods_name'].'</span> 외'.$goods_cnt.'건':'<span class="goods_name1 orderview blue" onclick="orderinfo(\''.$order_coupon[0]['order_seq'].'\');"  goods_seq="'.$items[0]['goods_seq'].'" >'.$items[0]['goods_name'].'</span>';

						$datarow['goodsview'] = $goodsinfo;
					}else{
						$datarow['goodsview'] = "";
					}
					$datarow['coupon_order_saleprice'] = get_currency_price($order_coupon[0]['coupon_order_saleprice'],2,'basic').'&nbsp;';
				} else {
					if ($datarow['type'] == 'offline_emoney') {
						$datarow['goodsview'] = '마일리지 '.get_currency_price($datarow['offline_emoney'],2,'basic').' 지급';
					}else{
						unset($order_coupon);
						if($datarow['type'] == 'ordersheet'){
							// 주문서쿠폰 정보 추가
							$order_coupon_tmp		= $this->ordermodel->get_order_ordersheet_coupon($datarow['member_seq'],'',$datarow['download_seq'],'downloadlist');
						}else{
							$order_coupon_tmp 	= $this->ordermodel->get_option_coupon_item($datarow['member_seq'], $datarow['download_seq']);
						}
						$order_coupon		= $order_coupon_tmp[0];
						$datarow['order_seq'] = '<span class="goods_name1 hand orderview blue" onclick="orderinfo(\''.$order_coupon['order_seq'].'\');" order_seq="'.$order_coupon['order_seq'].'" >'.$order_coupon['order_seq'].'</span>';
						if($order_coupon['goods_seq']){
							$datarow['goodsview'] = ($order_coupon['order_seq'])?'<span class="goods_name1 hand goodsview blue" onclick="goodsinfo(\''.$order_coupon['goods_seq'].'\');"  goods_seq="'.$order_coupon['goods_seq'].'" >'.$order_coupon['goods_name'].'</span>':'';
						}else{
							$datarow['goodsview'] = '-';
						}
						$datarow['coupon_order_saleprice'] = get_currency_price($order_coupon['coupon_order_saleprice'],2,'basic').'&nbsp;';
					}
				}
			}
			if($datarow['use_type'] == 'offline')	$datarow['goodsview'] = '-';

			if((strstr($datarow['type'],'offline'))){
				$datarow['datetitle'] = $datarow['date'].' <br /> '.$datarow['offline_input_serialnumber'];
			}else{
				$datarow['datetitle'] = $datarow['date'];
			}

			if ($datarow['type'] != 'offline_emoney') {
				$datarow['limit_goods_price_title'] = get_currency_price($datarow['limit_goods_price'],2,'basic');//제한금액 이상&nbsp;
			}

			if(strstr($datarow['type'],'offline')){
				$datarow['coupon_same_time_title']		= " - ";
				$datarow['issue_type_title']			= " - ";
				$datarow['sale_payment_title']			= " - ";
				$datarow['sale_referer_title']			= " - ";
				$datarow['sale_agent_title']			= " - ";
				$datarow['limit_title']					= ' - ';
			}else{
				$datarow['coupon_same_time_title']		= ($datarow['coupon_same_time']=='N') ? "단독" : "동시";
				$datarow['issue_type_title']			= ($datarow['issue_type']=='issue' || $datarow['issue_type']=='except') ? "제한" : "전체";
				$datarow['sale_payment_title']			= ($datarow['sale_payment']=='b') ? "무통장" : "X";
				$datarow['sale_referer_title']			= ($datarow['sale_referer']=='n' || $datarow['sale_referer']=='y') ? "제한" : "무관";
				$datarow['sale_agent_title']			= ($datarow['sale_agent']=="m") ? 'Mobile' : "X";//<img src="/images/common/icon_mobile.gif" >
				$datarow['limit_title']					= $datarow['coupon_same_time_title'].'/'.$datarow['limit_goods_price_title'].'/'.$datarow['issue_type_title'].'/'.$datarow['sale_agent_title'].'/'.$datarow['sale_payment_title'].'/'.$datarow['sale_referer_title'];
			}

			//혜택
			if( ( $datarow['type'] == 'shipping' || strstr($datarow['type'],'_shipping') ) ){//배송비
				$datarow['salepricetitle']	= ($datarow['shipping_type'] == 'free' ) ? '무료, 최대 '.get_currency_price($datarow['max_percent_shipping_sale'],2,'basic'): '배송비 '.get_currency_price($datarow['won_shipping_sale'],2,'basic');//
			}elseif($datarow['type'] == 'offline_emoney' ){//오프라인 마일리지쿠폰
				$datarow['salepricetitle']	='마일리지 '.get_currency_price($datarow['offline_emoney'],2,'basic').' 지급';
			}else{
				$datarow['salepricetitle']	= ($datarow['sale_type'] == 'percent' ) ? $datarow['percent_goods_sale'].'% 할인, <br/>최대 '.get_currency_price($datarow['max_percent_goods_sale'],2,'basic'): get_currency_price($datarow['won_goods_sale'],2,'basic').' 할인';
			}
            if($datarow['user_name'] == ""){
                $datarow['user_name'] = $datarow['bname'];
            }

			if( $datarow['type'] == 'offline_emoney' ) {
				$datarow['issuedate'] 				= '-';		//마일리지 지급으로 끝
				$datarow['couponinfobtn'] 			= "-";
				$datarow['coupon_order_saleprice'] 	= '-';
			}else{
				$datarow['issuedate']	= substr($datarow['issue_startdate'],0,10).' <br/> '.substr($datarow['issue_enddate'],0,10);	//유효기간
				if( $datarow['type'] == 'offline_coupon' ) {
					$coupon_type 						= "offline";
					$datarow['coupon_order_saleprice'] 	= '-';
				}else{
					$coupon_type 						= "online";
					$class_saleprice					= ' class="right"';
				}
				$datarow['couponinfobtn'] = '<input type="button" class="resp_btn v2" onClick="coupongoodsreview(this)" coupon_type="'.$coupon_type.'" coupon_seq="'.$datarow['coupon_seq'].'" download_seq="'.$datarow['download_seq'].'"  use_type="'.$datarow['use_type'].'"  issue_type="'.$datarow['issue_type'].'"   coupon_name="'.$datarow['coupon_name'].'" value="조회" />';
			}
			if(!$datarow['order_seq']) $datarow['order_seq'] = '-';
			if(!$datarow['goodsview']) $datarow['goodsview'] = '-';
			$html .= '<tr>';
			$html .= '	<td><label class="resp_checkbox"><input type="checkbox" name="del[]" value="'.$datarow['download_seq'].'"  class="checkeds"  '.$deletebtn.'/></label></td>';
			$html .= '	<td>'.$datarow['_no'].'</td>';
			$html .= '	<td><span class="hand blue" onClick="open_crm_summary(this,\''.$datarow['member_seq'].'\',\'\',\'right\');" >'.htmlentities($datarow['userid']).'</span></td>';
			$html .= '	<td><span class="hand blue"  onClick="open_crm_summary(this,\''.$datarow['member_seq'].'\',\'\',\'right\');" >'.htmlentities($datarow['user_name']).'</span></td>';
			$html .= '	<td>'.$datarow['couponinfobtn'].'</td>';
			$html .= '	<td>'.$datarow['issuedate'].'</td>';
			$html .= '	<td>'.$datarow['use_status_title'].'</td>';
			$html .= '	<td'.$class_saleprice.'>'.$datarow['coupon_order_saleprice'].'</td>';
			$html .= '	<td>'.$datarow['datetitle'].'</td>';
			$html .= '	<td>'.$datarow['order_seq'].'</td>';
			$html .= '	<td>'.$datarow['goodsview'].'</td>';

			$html .= '</tr>';
			$no--;
		}//foreach end



		if(count($data['result']) == 0){
			if($sc['search_text']){
				$html .= '<tr ><td colspan="10" >"'.$sc['search_text'].'"로(으로) 검색된 쿠폰내역이 없습니다.</td></tr>';
			}else{
				$html .= '<tr ><td colspan="11" >쿠폰 발급/사용 내역이 없습니다.</td></tr>';
			}
		}
		return $html;
	}

	//쿠폰관리 > 발급내역 - 삭제예정 (2020/04/01)
	function getdownloadhtml_old($data, $sc, $page)
	{
		$this->load->model('ordermodel');
		$html = '';
		$i = 0;

		foreach($data['result'] as $datarow){
			$datarow['number'] = $data['count'] - ( ( $page -1 ) * $sc['perpage'] + $i + 1 ) + 1;
			$datarow['date']			= substr($datarow['regist_date'],2,14);//등록일
			$datarow['use_status_title'] = ($datarow['use_status'] == 'used') ? '사용함':'미사용';
			if(str_replace("-","",$datarow['issue_enddate']) < date("Ymd") && $datarow['use_status'] != 'used') $datarow['use_status_title'] = '<span class="gray" >소멸함</span>';//미사용중 기간지남
			$deletebtn = ($datarow['use_status'] == 'used')?' disabled="disabled" ':'';//

			$datarow['use_date']			  = ($datarow['use_status'] == 'used') ? substr($datarow['use_date'],2,14):'';

			if($datarow['use_status'] == 'used') {
				if ( ( $datarow['type'] == 'shipping' || strstr($datarow['type'],'_shipping') ) ) {
					unset($order_coupon,$items);
					$order_coupon = $this->ordermodel->get_order_shipping_coupon($datarow['member_seq'], $datarow['download_seq']);
					if($order_coupon[0]['order_seq']) $items 				 = $this->ordermodel->get_item($order_coupon[0]['order_seq']);
					$goods_cnt = count($items)-1;
					if($items){
						$goodsinfo = ($goods_cnt > 0) ? '<img src="'.$items[0]['image'].'" /> <br /><span class="goods_name1">'.$items[0]['goods_name'].'</span> 외'.$goods_cnt.'건':'<img src="'.$items[0]['image'].'" /> <br /><span class="goods_name1 orderview"  onclick="orderinfo(\''.$order_coupon[0]['order_seq'].'\');"  goods_seq="'.$items[0]['goods_seq'].'" >'.$items[0]['goods_name'].'</span>';

						$datarow['goodsview'] = '<span class="goods_name1 hand orderview" onclick="orderinfo(\''.$order_coupon[0]['order_seq'].'\');"order_seq="'.$order_coupon[0]['order_seq'].'" >['.$order_coupon[0]['order_seq'].']</span><br/>'.$goodsinfo;
					}else{
						$datarow['goodsview'] = "";
					}
					$datarow['coupon_order_saleprice'] = get_currency_price($order_coupon[0]['coupon_order_saleprice'],2,'basic').'&nbsp;';
				} else {
					if ($datarow['type'] == 'offline_emoney') {
						$datarow['goodsview'] = '마일리지 '.get_currency_price($datarow['offline_emoney'],2,'basic').' 지급';
					}else{
						unset($order_coupon);
						$order_coupon = $this->ordermodel->get_option_coupon_item($datarow['member_seq'], $datarow['download_seq']);
						$datarow['goodsview'] = ($order_coupon[0]['order_seq'])?'<span class="goods_name1 hand orderview" onclick="orderinfo(\''.$order_coupon[0]['order_seq'].'\');" order_seq="'.$order_coupon[0]['order_seq'].'" >['.$order_coupon[0]['order_seq'].']</span><br/><img src="'.$order_coupon[0]['image'].'" /> <br /><span class="goods_name1 hand goodsview" onclick="goodsinfo(\''.$order_coupon[0]['goods_seq'].'\');"  goods_seq="'.$order_coupon[0]['goods_seq'].'" >'.$order_coupon[0]['goods_name'].'</span>':'';
						$datarow['coupon_order_saleprice'] = get_currency_price($order_coupon[0]['coupon_order_saleprice'],2,'basic').'&nbsp;';
					}
				}
			}

			if($datarow['use_type'] == 'offline')	$datarow['goodsview'] = '-';

			if((strstr($datarow['type'],'offline'))){
				$datarow['datetitle'] = $datarow['date'].'<br>'.$datarow['offline_input_serialnumber'];
			}else{
				$datarow['datetitle'] = $datarow['date'];
			}

			if ($datarow['type'] != 'offline_emoney') {
				$datarow['limit_goods_price_title'] = get_currency_price($datarow['limit_goods_price'],2,'basic');//제한금액 이상&nbsp;
			}

			if( $datarow['type'] == 'offline_emoney' ||  $datarow['use_type'] == 'offline'  ){
				$datarow['coupon_same_time_title']	= " - ";
				$datarow['issue_type_title']					= " - ";
				$datarow['sale_payment_title']			= " - ";
				$datarow['sale_referer_title']				= " - ";
				$datarow['sale_agent_title']					= " - ";
				$datarow['limit_title']							= ' - ';
			}else{
				$datarow['coupon_same_time_title']	= ($datarow['coupon_same_time']=='N') ? "단독" : "동시";
				$datarow['issue_type_title']					= ($datarow['issue_type']=='issue' || $datarow['issue_type']=='except') ? "제한" : "전체";
				$datarow['sale_payment_title']			= ($datarow['sale_payment']=='b') ? "무통장" : "X";
				$datarow['sale_referer_title']				= ($datarow['sale_referer']=='n' || $datarow['sale_referer']=='y') ? "제한" : "무관";
				$datarow['sale_agent_title']					= ($datarow['sale_agent']=="m") ? 'Mobile' : "X";//<img src="/images/common/icon_mobile.gif" >
				$datarow['limit_title']							= $datarow['coupon_same_time_title'].'/'.$datarow['limit_goods_price_title'].'/'.$datarow['issue_type_title'].'/'.$datarow['sale_agent_title'].'/'.$datarow['sale_payment_title'].'/'.$datarow['sale_referer_title'];
			}

			$datarow['issuedate']	= substr($datarow['issue_startdate'],2,10).' <br/> '.substr($datarow['issue_enddate'],2,10);//유효기간

			//혜택
			if( ( $datarow['type'] == 'shipping' || strstr($datarow['type'],'_shipping') ) ){//배송비
				$datarow['salepricetitle']	= ($datarow['shipping_type'] == 'free' ) ? '무료, 최대 '.get_currency_price($datarow['max_percent_shipping_sale'],2,'basic'): '배송비 '.get_currency_price($datarow['won_shipping_sale'],2,'basic');//
			}elseif($datarow['type'] == 'offline_emoney' ){//오프라인 마일리지쿠폰
				$datarow['salepricetitle']	='마일리지 '.get_currency_price($datarow['offline_emoney'],2,'basic').' 지급';
			}else{
				$datarow['salepricetitle']	= ($datarow['sale_type'] == 'percent' ) ? $datarow['percent_goods_sale'].'% 할인, <br/>최대 '.get_currency_price($datarow['max_percent_goods_sale'],2,'basic'): get_currency_price($datarow['won_goods_sale'],2,'basic').' 할인';
			}
            if($datarow['user_name'] == ""){
                $datarow['user_name'] = $datarow['bname'];
            }

			if( $datarow['type'] == 'offline_emoney' ) {
				 $datarow['couponinfobtn'] = "-";
			}else{
				if( $datarow['type'] == 'offline_coupon' ) {
					$coupon_type = "offline";
				}else{
					$coupon_type = "online";
				}
				$datarow['couponinfobtn'] = '<span class="btn small gray "><input type="button" class="coupongoodsreviewbtnpopup" coupon_type="'.$coupon_type.'" coupon_seq="'.$datarow['coupon_seq'].'" download_seq="'.$datarow['download_seq'].'"  use_type="'.$datarow['use_type'].'"  issue_type="'.$datarow['issue_type'].'"   coupon_name="'.$datarow['coupon_name'].'" value="조회" /></span>';
			}
			$html .= '<tr>';
			$html .= '	<td class="its-td-align center"><input type="checkbox" name="del[]" value="'.$datarow['download_seq'].'"  class="checkeds"  '.$deletebtn.'/></td>';
			$html .= '	<td class="its-td-align center">'.$datarow['number'].'</td>';
			$html .= '	<td class="its-td-align center"><span class=" userinfo hand bold blue"  onclick="userinfo(\''.$datarow['member_seq'].'\');"  mid="'.$datarow['userid'].'" mseq="'.$datarow['member_seq'].'" >'.$datarow['userid'].'</span></td>';
			$html .= '	<td class="its-td-align center bold"><span class=" userinfo hand bold blue"  onclick="userinfo(\''.$datarow['member_seq'].'\');"   mid="'.$datarow['userid'].'" mseq="'.$datarow['member_seq'].'" >'.$datarow['user_name'].'</span></td>';
			$html .= '	<td class="its-td-align center">'.$datarow['datetitle'].'</td>';
			if($datarow['use_type'] == 'online')
				$html .= '	<td class="its-td-align center">'.$datarow['limit_title'].'</td>';
			$html .= '	<td class="its-td-align center">'.$datarow['issuedate'].'</td>';
			if($datarow['use_type'] == 'online'){
				$html .= '	<td class="its-td-align center">'.$datarow['salepricetitle'].'</td>';
				$html .= '	<td class="its-td-align right">'.$datarow['coupon_order_saleprice'].'</td>';
			}
			$html .= '	<td class="its-td-align center">'.$datarow['couponinfobtn'].'</td>';
			$html .= '	<td class="its-td-align center">'.$datarow['use_status_title'].'</td>';
			$html .= '	<td class="its-td-align center">'.$datarow['goodsview'].'</td>';
			$html .= '	<td class="its-td-align center">'.$datarow['use_date'].'</td>';
			$html .= '</tr>';
			$i++;
		}//foreach end

		if($i==0){
			if($sc['search_text']){
				$html .= '<tr ><td class="its-td-align center" colspan="13" >"'.$sc['search_text'].'"로(으로) 검색된 쿠폰내역이 없습니다.</td></tr>';
			}else{
				$html .= '<tr ><td class="its-td-align center" colspan="13" >발급내역이 없습니다.</td></tr>';
			}
		}
		return $html;
	}

	//관리자 > 회원 쿠폰 보유/다운가능내역
	public function member_coupon_list(){

		$this->load->helper('member');
		$this->load->model('ordermodel');
		$this->load->model('goodsmodel');
		$this->load->model('categorymodel');
		$this->mdata = $this->membermodel->get_member_data($_GET['member_seq']);//회원정보

		if( !empty($this->mdata['birthday']) && $this->mdata['birthday'] != '0000-00-00' ) {
			$this->mdata['thisyear_birthday'] = date("Y").substr($this->mdata['birthday'],4,6);
			if(checkdate(substr($this->mdata['thisyear_birthday'],5,2),substr($this->mdata['thisyear_birthday'],8,2),substr($this->mdata['thisyear_birthday'],0,4)) != true) {
				$this->mdata['thisyear_birthday'] = date("Y-m-d",strtotime('-1 day', strtotime($this->mdata['thisyear_birthday'])));
			}
		}

		if ( !empty($this->mdata['anniversary']) ) {
			$this->mdata['thisyear_anniversary'] = date("Y").'-'.$this->mdata['anniversary'];//기념일(mm-dd) 추가
			if(checkdate(substr($this->mdata['thisyear_anniversary'],5,2),substr($this->mdata['thisyear_anniversary'],8,2),substr($this->mdata['thisyear_anniversary'],0,4)) != true) {
				$this->mdata['thisyear_anniversary'] = date("Y-m-d",strtotime('-1 day', strtotime($this->mdata['thisyear_anniversary'])));
			}
		}

		$mb_group_sort = mb_group_sort();//회원등급순서 재정렬
		//등급조정쿠폰의 등업된 경우에만 다운가능
		if ($this->mdata['grade_update_date'] != '0000-00-00 00:00:00') {
			$fm_member_group_logsql = "select * from fm_member_group_log where member_seq = '".$this->mdata['member_seq']."' order by regist_date desc limit 0,1";
			$fm_member_group_logquery = $this->db->query($fm_member_group_logsql);
			$fm_member_group_log =  $fm_member_group_logquery->row_array();
			if( ($mb_group_sort[$fm_member_group_log['prev_group_seq']] >= $mb_group_sort[$fm_member_group_log['chg_group_seq']]) || ($this->mdata['group_seq'] == 1) ) {
				$this->mdata['grade_update_date'] = '';
			}
		}else{
			$this->mdata['grade_update_date'] = substr($this->mdata['regist_date'],0,10);
		}

		###
		//쿠폰 다운내역/다운가능내역
		$this->load->helper('coupon');
		down_coupon_list('admin', $sc , $dataloop);
 		###

		$svcount = $this->couponmodel->get_download_have_total_count($sc,$this->mdata);
		$this->template->assign($svcount);
		###

		if(isset($dataloop)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtagfront($sc['searchcount'],$sc['perpage'],'?tab='.$_GET['tab'].'&member_seq='.$_GET['member_seq'], getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
		$this->template->assign('pagin',$paginlay);
		$this->template->assign('perpage',$sc['perpage']);

		$this->template->print_("tpl");
	}

	//상품쿠폰찾기
	public function coupongoodssearch()
	{
		$goodsSeq = (int) $_POST['goods'];
		$couponSeq = (int) $_POST['coupon'];

		$today = date('Y-m-d',time());
		$this->load->model('goodsmodel');

		$tmp = $this->goodsmodel -> get_goods_category($goodsSeq);
		if($tmp) foreach($tmp as $data) $category[] = $data['category_code'];
		$goods = $this->goodsmodel -> get_default_option($goodsSeq);
		if( !$goods ) {
			echo json_encode(array('result'=>false));
			exit;
		}

		$resultgoods = '';
		$goodsinfo	= $this->goodsmodel->get_goods($goodsSeq);
		$images		= $this->goodsmodel->get_goods_image($goodsSeq);
		$resultgoods['name']	= $goodsinfo['goods_name'];
		$resultgoods['price']	= get_currency_price($goods['price'],2,'basic');
		if($images){
			foreach($images as $image){
				if($image['thumbCart']){
					$resultgoods['src'] = $image['thumbCart']['image'];break;
				}elseif($image['thumbScroll']){
					$resultgoods['src'] = $image['thumbScroll']['image']; break;
				}elseif($image['list1']){
					$resultgoods['src'] = $image['list1']['image']; break;
				}elseif($image['list2']){
					$resultgoods['src'] = $image['list2']['image']; break;
				}elseif($image['thumbView']){
					$resultgoods['src'] = $image['thumbView']['image']; break;
				}
			}
		}

		$issuegoods 	= $this->couponmodel->get_coupon_issuegoods($couponSeq);
		$issuecategory 	= $this->couponmodel->get_coupon_issuecategory($couponSeq);
		$this->couponinfo 	= $this->couponmodel->get_coupon($couponSeq);
		if($this->couponinfo['issue_type'] == 'issue') {
			$resultck = 'goodsno';
			if($issuegoods) {
				foreach($issuegoods as $key => $tmp) {
					if( $tmp['goods_seq'] == $goodsSeq ) {
						$resultck = 'goodsyes';
						break;
					}
				}
				if(!$resultck) $resultck = 'goodsno';
			}

			if($issuecategory) {
				foreach($issuecategory as $key => $tmp) {
					if( in_array($tmp['category_code'],$category) ) {
						$resultck = 'goodsyes';
						break;
					}
				}
				if(!$resultck) $resultck = 'goodsno';
			}
		}else{
			$resultck = 'goodsyes';
			if($issuegoods) {
				foreach($issuegoods as $key => $tmp) {
					if( $tmp['goods_seq'] == $goodsSeq ) {
						$resultck = 'goodsno';
						break;
					}
				}
				if(!$resultck) $resultck = 'goodsyes';
			}

			if($issuecategory) {
				foreach($issuecategory as $key => $tmp) {
					if( in_array($tmp['category_code'],$category) ) {
						$resultck = 'goodsno';
						break;
					}
				}
				if(!$resultck) $resultck = 'goodsyes';
			}
		}

		/**
		## 할인부담금 관련 부담자의 상품에만 적용.
		- 쿠폰 사용처가 본사상품일때 본사 상품이 아니면 패스
		- 쿠폰 사용처가 입점사일때 본사 상품이면 패스
		- 할인부담금 관련 부담자의 상품에만 적용.
		@2017-04-18
		- 단, 생일쿠폰 외 특정 쿠폰 제외
		**/
		if(!in_array($this->couponinfo['type'], $this->couponmodel->except_providerchk_coupon) &&  $resultck == 'goodsyes' ) {
			if	($goodsinfo['provider_seq'] == 1 && $this->couponinfo['provider_list'])	$resultck = 'goodsno';
			if	($goodsinfo['provider_seq'] != 1 && !$this->couponinfo['provider_list'])	$resultck = 'goodsno';
			if	($this->couponinfo['provider_list'] && !strstr($this->couponinfo['provider_list'], '|'.$goodsinfo['provider_seq'].'|'))	$resultck = 'goodsno';
		}

		$result = array('result'=>$resultck,"goods"=>$resultgoods);
		echo json_encode($result);
	}

	//쿠폰 발급하기
	public function gl_coupon_issued(){

		$params = array(
						'layId'				=> $this->input->post('divSelectLay'),
						'issued_type'		=> $this->input->post('issued_type'),
						'issued_seq'		=> $this->input->post('issued_seq'),
						'download_limit'	=> $this->input->post('download_limit')
					);


		if($this->input->post('issued_type') == "promotion"){
			$params['issued_name']		= "할인코드";
		}else{
			$params['issued_name']		= "쿠폰";
		}

		$this->template->assign($params);
		$this->template->print_("tpl");

	}

	public function couponpage_codeview(){

		$this->load->helper('file');
		$origin_file			= explode("/",$this->file_path);

		if($this->input->get('mode') == "pc"){
			$codeall				= str_replace($origin_file[count($origin_file)-1],"/codeall.html",$this->file_path);
		}else{
			$codeall			= str_replace($origin_file[count($origin_file)-1],"/codeall_mobile.html",$this->file_path);
		}

		$coupondowntarget	= coupondowntargethtml($_GET['type']);

		$tpl_source_all		= read_file(ROOTPATH."admin/skin/".$codeall);
		$tpl_source_all		= str_replace("{다운대상기간치환}",$coupondowntarget,str_replace("{쿠폰유형}",$_GET['type'],str_replace("{쿠폰고유번호}",$_GET['coupon_seq'],$tpl_source_all)));
		$tpl_source_all		= str_replace("<","&lt;",str_replace(">","&gt;",$tpl_source_all));
		$this->template->assign(array('couponcodeallhtml'=>$tpl_source_all));

		$params = array('type'=>$_GET['type'],
						'mode'=>$_GET['mode'],
				);

		$this->template->assign($params);
		$this->template->print_("tpl");

	}

}

/* End of file coupon.php */
/* Location: ./app/controllers/admin/coupon.php */