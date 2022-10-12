<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class coupon extends selleradmin_base {

	public function __construct() {
		parent::__construct();

		$this->admin_menu();
		$this->tempate_modules();
		$this->file_path	= $this->template_path();
		$this->load->model('couponmodel');
		$this->load->model('membermodel');
		$this->load->helper('coupon');
		$this->load->library('validation');

		$auth = $this->authmodel->manager_limit_act('coupon_view');

		if(!$auth){
			pageBack("권한이 없습니다.");
			exit;
		}

		$reserves = ($this->reserves)?$this->reserves:config_load('reserve');
		$ispoint		= $reserves['point_use'];//포인트 사용여부 설정
		$ispointurl	= '/admin/setting/reserve';//포인트설정페이지
		$this->template->assign('ispoint',$ispoint);
		$this->template->assign('ispointurl',$ispointurl);

		/* 회원 그룹 개발시 변경*/
		$groups = "";
		$query = $this->db->query("select group_seq,group_name from fm_member_group");
		foreach($query->result_array() as $row){
			$groups[] = $row;
		}
		/******************/
		$this->groups = $groups;
		$this->template->assign(array('groups'=>$groups));
		$this->template->define(array('tpl'=>$this->file_path));

		//쿠폰 사용 가능한 상품 확인하기 레이어
		$this->template->define(array('coupongoodslayer'=>$this->skin.'/coupon/coupongoodslayer.html'));

	}

	public function index()
	{
		redirect("/selleradmin/coupon/catalog");
	}

	//쿠폰목록
	public function catalog()
	{
		$aGetParams = $this->input->get();

		// validation
		if ($aGetParams) {
			$this->validation->set_data($aGetParams);
			$this->validation->set_rules('id', '일련번호', 'trim|string|xss_clean');
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

			$dsc['whereis'] = ' and coupon_seq='.$datarow['coupon_seq'];
			$downloadtotal = $this->couponmodel->get_download_total_count($dsc);
			$datarow['downloadtotal']	= number_format($downloadtotal);//발급수

			$usc['whereis'] = ' and coupon_seq='.$datarow['coupon_seq'].' and use_status = \'used\' ';
			$usetotal = $this->couponmodel->get_download_total_count($usc);

			$datarow['usetotal']			= number_format($usetotal);//사용건수
			$datarow['issueimg']	= 'online';
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

		$file_path = $this->template_path();

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
				$coupons['provider_name_list'] = $this->providermodel->get_provider_select_list($coupons['provider_list']);
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

			$selected_['download_endhour']['23']								= "selected";
			$selected_['download_endmin']['59']									= "selected";
			$selected_['download_endtime_h']['23']								= "selected";
			$selected_['download_endtime_m']['59']								= "selected";

			$coupons['use_type'] = "online";
		}
		// serviceLimit('H_NFR') 무료몰제외 1
		$this->template->assign(['coupons' => $coupons]);
		$this->template->assign(array('selected_'=>$selected_,'checked_'=>$checked_));

		$this->template->assign('coupon_category',$set_coupon_category);
		$this->template->assign('coupon_category_sub',$set_coupon_category_sub);
		$this->template->assign('set_coupon_form',$set_coupon_form[$coupons['type']]);

		$this->template->assign('query_string',$_GET['query_string']);
		if( !$this->coupongoodsreviewer ) {  
			$this->template->assign("offline_coupon_form",get_interface_sample_path("20210510/offline_coupon_form.xls"));
			$this->template->print_("tpl");
		}
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

			// o2o 쿠폰 매장 기능 추가
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
			$issuegoods 		= $this->couponmodel->get_coupon_issuegoods($no);
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

		$this->template->assign('query_string',$_GET['query_string']);
		if( !$this->coupongoodsreviewer ) {
			$this->template->define(array('onlinecoupontypelayer' => $this->skin.'/coupon/onlinecoupontype.html'));
		$this->template->assign(array('membertypedisabled'=>$membertypedisabled));
		$this->template->print_("tpl");
	}
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
			$issuegoods 		= $this->couponmodel->get_coupon_issuegoods($no);
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
		**/
		if( $resultck == 'goodsyes' ) {
			if	($goodsinfo['provider_seq'] == 1 && $this->couponinfo['provider_list'])	$resultck = 'goodsno';
			if	($goodsinfo['provider_seq'] != 1 && !$this->couponinfo['provider_list'])	$resultck = 'goodsno';
			if	($this->couponinfo['provider_list'] && !strstr($this->couponinfo['provider_list'], '|'.$goodsinfo['provider_seq'].'|'))	$resultck = 'goodsno';
		}

		$result = array('result'=>$resultck,"goods"=>$resultgoods);
		echo json_encode($result);
	}
}

/* End of file coupon.php */
/* Location: ./app/controllers/selleradmin/coupon.php */