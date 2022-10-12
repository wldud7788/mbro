<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once(APPPATH ."libraries/o2o/o2oconfiglibrary".EXT);

Class o2oinitlibrary extends o2oconfiglibrary
{
	public $checkO2OCouponFilter = true;		// 쿠폰 필터 여부
	public $checkFrontO2OService = false;		// O2O 기능 사용자 노출 여부
	
	public function __construct() {
		parent::__construct();
		
		// 현재 등록된 o2o 매장 정보가 있을 경우
		$this->CI->load->library("o2o/o2oservicelibrary");
		$o2o_config = $this->CI->o2oservicelibrary->get_o2o_config(null, 'unlimit');
		if(count($o2o_config)>0){
			$this->checkFrontO2OService = true;
		}
	}
	// 메뉴 비활성화 적용
	// 메뉴의 경우 기존 메뉴에서 제외 해야하므로 o2oconfigmodel에서 처리
	public function init_exceptO2OForAdminMenu(&$adminMenuCurrent=null){
		// O2O 서비스가 부가서비스가 아닌 설정 기능으로 변경 됬기에 메뉴는 무조건 활성화
		return true;
		// 이하의 소스는 return 으로 무시 
		if(!$this->checkO2OService){	// 다른 기능과 반대로 권한이 없을 때 처리
			if	($this->CI->admin_menu->arr_menu) foreach($this->CI->admin_menu->arr_menu as $name => $data){
				if	(!in_array($name, array('o2oservice'))){
					$re_arr_menu[$name]	= $data;
				}
			}
			$this->CI->admin_menu->arr_menu		= $re_arr_menu;
		}else{
			if($adminMenuCurrent=="o2osetting"){
				$adminMenuCurrent = "o2o";		// 디렉토리 명 강제 입력
			}
		}
	}
	
	// o2o 설정 관리자 회원 검색 조건 - 기획 변경으로 미사용 
	public function init_admin_member_search_catalog(){
		if(!$this->checkO2OService){return $this->checkO2OService;}
				
		$this->CI->load->library("o2o/o2oservicelibrary");
		$o2o_config_list = $this->CI->o2oservicelibrary->get_o2o_config(null, "unlimit");
				
		$this->CI->template->assign('o2o_config_list', $o2o_config_list);
		$this->CI->template->assign('checkO2OService', $this->checkO2OService);
		
		$this->CI->template->define('o2o_member_search', $this->CI->skin.'/o2o/_modules/member_search.html');
	}
	
	// o2o 설정 관리자 회원 검색 기능 
	public function init_admin_member_list($sc = array(), &$sqlSelectClause = ""
		, &$sqlFromClause = "", &$sqlWhereClause = "", &$sqlOrderClause = ""){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$sqlSelectClause .= " , A.status ";
		$sqlFromClause .= " LEFT OUTER JOIN fm_member_o2o o2o ON A.member_seq = o2o.member_seq ";
		
		// 검색 조건
		if( !empty($sc['o2o_store_seq'])){
			$sqlWhereClause .= " AND o2o.o2o_store_seq in ('".implode("', '", $sc['o2o_store_seq'])."') ";
		}
		
	}
	
	// o2o 설정 관리자 회원 가입방법 검색 기능 
	public function init_admin_member_rute_list($sc = array(), &$snssqlWhereClause=array()){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		// 검색 조건
		if( !empty($sc['snsrute']) && in_array('pos', $sc['snsrute'])){
			$snssqlWhereClause[] = " (A.rute = 'pos') ";
		}
		
	}
	
	// o2o 가입 핸드폰 인증
	public function init_member_auth_cellphone($call_form='o2o_join_form'){
		if(!$this->checkFrontO2OService){return $this->checkFrontO2OService;}
		// O2O 핸드폰 인증 사용여부
		$joinform = config_load('joinform');
		$o2oauthnum_use = $joinform['o2oauthnum_use'];
		
		// 본인인증을 통한 인증이 이미 이루어졌을 경우 추가 핸드폰 인증 프로세스 제외
		$phone = null;
		$auth = $this->CI->session->userdata('auth');
		if	( $auth['phone_number'] ) {
			$phone_len = strlen($auth['phone_number']);
			switch($phone_len){
			  case 11 :
				  $phone = preg_replace("/([0-9]{3})([0-9]{4})([0-9]{4})/", "$1-$2-$3", $auth['phone_number']);
				  break;
			  case 10:
				  $phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $auth['phone_number']);
				  break;
			}
		}
		if(!empty($phone)){
			$o2oauthnum_use = "N";
			$call_form = "none";
		}
		
		$this->CI->template->assign('checkO2OService', $this->checkFrontO2OService);
		$this->CI->template->assign('call_form', $call_form);
		
		$this->CI->template->assign('o2oauthnum_use', $o2oauthnum_use);
		
		$this->CI->template->define('o2o_auth_cellphone', $this->CI->skin.'/o2o/_modules/auth_cellphone.html');
	}
	
	// o2o 설정 매장 수령 탭 추가
	public function init_admin_shipping_address_pop(){
		if(!$this->checkO2OService){return $this->checkO2OService;}
				
		$this->CI->template->assign('checkO2OService', $this->checkO2OService);
		
		$this->CI->template->define('o2o_shipping_address_pop', $this->CI->skin.'/o2o/_modules/shipping_address_pop.html');
	}
	
	// o2o 설정 매장 수령 목록 추가
	public function init_admin_shipping_address_list(&$list, $sc, $params){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$this->CI->template->assign("checkO2OService",$this->checkO2OService);
		
		if($params['tabType'] == 'o2o'){
			$page = ($sc['page']) ? $sc['page'] : 1;
			
			// POS 연동 업체 정보
			$o2o_pos_info = json_decode($this->o2o_system_info['o2o_pos_info'], true);
			$sc['pos_code'] = null;
			foreach($o2o_pos_info as $pos_code => $pos_info){
				if($pos_info['name']==$sc['address_category']){
					$sc['pos_code'] = $pos_code;
				}
			}
			$sqlData = array(
				'pos_code'					=> $sc['pos_code'],
				'pos_address_nation'		=> $sc['address_nation'],
				'pos_name'					=> $sc['address_name'],
			);
			$this->CI->load->library("o2o/o2oservicelibrary");
			$query = $this->CI->o2oservicelibrary->get_o2o_config($sqlData,'unlimit','query');
			
			$list	= select_script_page(10,$page,10,$query,'','searchPaging');
			// 리스트 재구성
			foreach($list['record'] as &$row){
				$row = $this->transfer_addr($row);
			}
		}
	}
	public function transfer_addr($row){
		// POS 연동 업체 정보
		$o2o_pos_info = json_decode($this->o2o_system_info['o2o_pos_info'], true);

		$row['shipping_address_seq']			= $row['o2o_store_seq'];
		$row['address_category']				= $o2o_pos_info[$row['pos_code']]['name'];
		$row['address_nation']					= $row['pos_address_nation'];
		$row['address_name']					= $row['pos_name'];
		$row['address_type']					= $row['pos_address_type'];
		$row['address_zipcode']					= $row['pos_address_zipcode'];
		$row['address']							= $row['pos_address'];
		$row['address_street']					= $row['pos_address_street'];
		$row['address_detail']					= $row['pos_address_detail'];
		$row['international_postcode']			= $row['pos_international_postcode'];
		$row['international_country']			= $row['pos_international_country'];
		$row['international_town_city']			= $row['pos_international_town_city'];
		$row['international_county']			= $row['pos_international_county'];
		$row['international_address']			= $row['pos_international_address'];
		$row['shipping_phone']					= $row['pos_phone'];
		$row['add_type']						= "o2o";
		$row['store_scm_seq']					= $row['scm_store'];

		if	($this->CI->scm_cfg['use'] == 'Y'){
			$use_wh_seqs = array_keys($this->CI->scm_cfg['use_warehouse']);

			// 미사용 창고 추출
			$row['wh_use']		= 'Y';
			if(array_search($row['scm_store'], $use_wh_seqs) === false){
				$row['wh_use']	= 'N';
			}
		}
		return $row;
	}
	
	// o2o 수령매장 추가
	public function init_get_shipping_join_store(&$store, &$params){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		if($store['store_type'] == 'o2o'){
			$sqlData = array(
				'o2o_store_seq'					=> $store['shipping_address_seq'],
			);
			$this->CI->load->library("o2o/o2oservicelibrary");
			$o2o_config_store = $this->CI->o2oservicelibrary->get_o2o_config($sqlData);
			$o2o_config_store = $this->transfer_addr($o2o_config_store);
			if($o2o_config_store){
				$store	= array_merge($store, $o2o_config_store);
			}
		}
	}
	
	// o2o 설정 매장 수령 목록 추가
	public function init_admin_get_shipping_category(&$result, $type){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		if($type == 'o2o'){
			// POS 연동 업체 정보
			$o2o_pos_info = json_decode($this->o2o_system_info['o2o_pos_info'], true);
			
			$result = null;	// 초기화
			foreach($o2o_pos_info as $pos_info){
				$result[] = array('address_category'=>$pos_info['name']);
			}
		}
	}
	
	// 관리자 o2o 쿠폰 페이지 초기화
	public function init_admin_coupon_page($sc=null,&$checked=null){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$this->CI->template->assign('checkO2OService', $this->checkO2OService);
		
		$this->CI->load->library("o2o/o2oservicelibrary");
		$loop = $this->CI->o2oservicelibrary->get_o2o_config(null, "unlimit");
		$this->CI->template->assign('salestoreitemloop', $loop);

		if(($sc['sale_store'])){
			if(gettype($sc['sale_store']) == 'string' ) $sc['sale_store'] = unserialize(urldecode($sc['sale_store']));
			foreach ($sc['sale_store'] as $v) {
				$checked['sale_store'][$v] = "checked";
			}
		}
		
		if(($sc['sale_store_item'])){
			if(gettype($sc['sale_store_item']) == 'string' ) $sc['sale_store_item'] = unserialize(urldecode($sc['sale_store_item']));
			foreach ($sc['sale_store_item'] as $v) {
				$checked['sale_store_item'][$v] = "checked";
			}
		}
	}
	
	// 사용자 - o2o 쿠폰 페이지 초기화
	public function init_front_coupon_page(){
		if(!$this->checkFrontO2OService){return $this->checkFrontO2OService;}
		
		// 검색조건만 없고 동일한 프로세스이므로 관리자용 호출
		$this->init_admin_coupon_page();
	}
	
	// 관리자 - o2o 쿠폰 매장 추가 
	public function init_admin_coupon(&$coupons){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		if($coupons['sale_store'] == "off" && !empty($coupons['sale_store_item'])){
			$coupons['sale_store_item_arr'] = json_decode($coupons['sale_store_item']);
		}
	}
	
	// 사용자 - o2o 쿠폰 매장 추가 
	public function init_front_coupon(&$coupons){
		if(!$this->checkFrontO2OService){return $this->checkFrontO2OService;}
		
		// 동일한 프로세스이므로 관리자용 호출
		$this->init_admin_coupon($coupons);
	}
	
	// o2o 쿠폰 체크 초기화
	public function init_admin_check_param_online_download(&$paramCoupon, $params){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		// validation 
		if($params['sale_store']=="off" && count($params['sale_store_item'])<1){
			$callback = "parent.document.onlineRegist.sale_store_item[0].focus();";
			openDialogAlert("오프라인 전용 쿠폰일 경우 사용 매장이 최소 1개 이상이어야 합니다.<br/>사용 매장을 선택해 주세요.",450,140,'parent',$callback);
			exit;
		}
		
		$paramCoupon['sale_store'] 				= if_empty($params, 'sale_store', 'all');
		$paramCoupon['sale_store_item']			= "";
		if(is_array($params['sale_store_item'])){
			$paramCoupon['sale_store_item'] = json_encode($params['sale_store_item']);
		}
	}
	
	// 마이페이지 - 쿠폰 목록 처리
	public function init_front_mypage_coupon(){
		if(!$this->checkFrontO2OService){return $this->checkFrontO2OService;}
		
		$this->CI->template->assign('checkO2OService', $this->checkFrontO2OService);
		
		$this->CI->template->define('o2o_mypage_coupon_init', $this->CI->skin.'/o2o/_modules/mypage_coupon_init.html');
	}
	
	// 쿠폰 검색 기능 초기화
	public function init_admin_coupon_catalog(&$where, $sc){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$subSqlArray = array();
		## 온오프 검색
		if	(!empty($sc['sale_store'])){
			$saleStorein = implode("','",$sc['sale_store']);
			$subSqlArray[] = " sale_store in ('".$saleStorein."') ";
		}
		## 매장 검색
		if	(!empty($sc['sale_store_item'])){
			foreach($sc['sale_store_item'] as $sc_sale_store_item){
				$subSqlArray[] = " sale_store_item like '%\"".$sc_sale_store_item."\"%' ";
			}
		}
		
		if(count($subSqlArray)>0){
			$where[] = " ( ".implode(" OR ",$subSqlArray)." ) ";
		}
	}
	// 공통 - o2o 쿠폰 매장 검색 조건 추가 -  사용자의 상품쿠폰 >다운시 개별체크용 
	public function init_public_able_o2o_sale_store(&$coupontype = "", $tableName=""){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		// 온/오프 구분 사용 여부
		// 특정 페이지에서 전체 쿠폰 노출을 위해서 처리
		if(!empty($coupontype) && $this->checkO2OCouponFilter){
			$o2o_store_query = "";
			$o2o_store_item_query = "";
			// O2O 환경 체크 false : 일반 접속, true : 오프라인 요청
			if($this->CI->o2o_pos_env) {
				$sale_store = "off";
				// 매장 검색 조건
				if($this->CI->o2oConfig){
					$o2o_store_item_query = " AND ".(($tableName)?$tableName.".":"")."sale_store_item like '%\"".$this->CI->o2oConfig['o2o_store_seq']."\"%' ";
				}
			}else{
				$sale_store = "on";
			}
			$o2o_store_query = " AND ".(($tableName)?$tableName.".":"")."sale_store = '".$sale_store."' ";
			$coupontype .= $o2o_store_query.$o2o_store_item_query;
		}
	}
	
	// o2o 설정 관리자 회원 노출 
	public function init_print_admin_member_list($data){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$this->CI->template->assign('data', $data);
		$this->CI->template->assign('checkO2OService', $this->checkO2OService);
		
		$this->CI->template->define('o2o_member_list_rute', $this->CI->skin.'/o2o/_modules/member_list_rute.html');
		$this->CI->template->print_('o2o_member_list_rute');
	}
	
	// 사용자 - 마이페이지 쿠폰
	public function init_print_front_mypage_coupon_list($data){
		if(!$this->checkFrontO2OService){return $this->checkFrontO2OService;}
		
		$this->CI->template->assign('data', $data);
		$this->CI->template->assign('checkO2OService', $this->checkFrontO2OService);
		
		$this->CI->template->define('o2o_mypage_coupon_list', $this->CI->skin.'/o2o/_modules/mypage_coupon_list.html');
		$this->CI->template->print_('o2o_mypage_coupon_list');
	}
	
	// 관리자 - 관리자 권한 추가
	public function init_admin_manager_auth(){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$this->CI->template->assign('checkO2OService', $this->checkO2OService);
		$this->CI->template->define('o2o_manager_auth', $this->CI->skin.'/o2o/_modules/manager_auth.html');
	}
	
	// 매장수령으로 별도 등록된 매장 정보 삭제
	public function init_delete_shipping_store($params){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		if($params['o2o_store_seq']){
			$this->CI->load->model('shippingmodel');
			
			// 해당 정보를 갖는 매장수령지가 있는지 확인
			$ship_store = $this->CI->shippingmodel->get_shipping_store($params['o2o_store_seq'], 'shipping_address_seq');
			
			// 단독으로 남은 매장이었는지 확인
			foreach($ship_store as $store_info){
				$last_ship_store = $this->CI->shippingmodel->get_shipping_store($store_info['shipping_set_seq'], 'shipping_set_seq');
				
				// 마지막 남은 매장수령지
				if(count($last_ship_store)==1){
					$this->CI->shippingmodel->del_shipping_set($last_ship_store[0]['shipping_set_seq']);
				}
				
				// 매장수령지 삭제
				$this->CI->shippingmodel->del_shipping_store($store_info['shipping_store_seq'],'shipping_store_seq');
			}
		}
	}
	// 배송지 그룹 강제 추가
	public function init_shipping_store(){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		$shipping_store_seq = array();
		
		// O2O 상품은 모두 본사상품, 향후 입점사 상품이 추가될 경우 배송그룹 수정 필요
		// O2O 전용 배송그룹 호출
		$this->CI->load->model('shippingmodel');
		$ship_list = $this->CI->shippingmodel->get_shipping_group_simple('1', 'O');
		$shipping_group = null;
		if($ship_list[0]){
			$shipping_group = $ship_list[0];
		}
		// O2o 전용 배송그룹 set 
		$this->CI->load->model('shippingmodel');
		$ship_set_list = $this->CI->shippingmodel->get_shipping_set($shipping_group['shipping_group_seq']);
		$shipping_set = null;
		if($ship_set_list[0]){
			$shipping_set = $ship_set_list[0];
		}
		
		// 배송설정 번호
		$ship_store['shipping_set_seq']			= $shipping_set['shipping_set_seq'];
		// 배송그룹 번호 삭제용
		$ship_store['shipping_group_seq_tmp']	= $shipping_group['shipping_group_seq'];
		
		// 수령매장 타입
		$ship_store['store_type']				= ($ship_store['store_type'])?$ship_store['store_type']:'o2o';
		// 매장안내
		$ship_store['store_information']		= ($ship_store['store_information'])?$ship_store['store_information']:'';
		
		// 배송설정번호와 삭제용 번호는 필수로 수신받아야함.
		if(!empty($ship_store['shipping_set_seq']) && !empty($ship_store['shipping_group_seq_tmp'])){
			
			$this->CI->load->library("o2o/o2oservicelibrary");
			$o2o_config_list = $this->CI->o2oservicelibrary->get_o2o_config(null, "unlimit");

			$this->CI->load->model("shippingmodel");
			// 기존 입력된 정보 모두 삭제
			$this->CI->shippingmodel->del_shipping_store($ship_store['shipping_group_seq_tmp'],'shipping_group_seq_tmp');
			foreach($o2o_config_list as $o2o_config){
				// 배송지 고유번호
				$ship_store['shipping_address_seq']	= $o2o_config['o2o_store_seq'];
				// 수령매장명
				$ship_store['shipping_store_name']	= $o2o_config['pos_name'];
				// 매장 전화번호
				$ship_store['store_phone']			= $o2o_config['pos_phone'];
				
				// 수령매장 창고기능 
				$defulat_store_value = "N";
				$store_scm_seq = '';

				// 재고관리버전 활성화 시 
				if	($this->CI->scm_cfg['use'] == 'Y' && !empty($o2o_config['scm_store'])){
					$defulat_store_value = "Y";
					$store_scm_seq = $o2o_config['scm_store'];
				}

				// 창고연결여부
				$ship_store['store_scm_type']			= $defulat_store_value;
				// 수령매장 재고설정
				$ship_store['store_supply_set']			= $defulat_store_value;
				// 수령매장 재고보기설정
				$ship_store['store_supply_set_view']	= $defulat_store_value;
				// 수령매장 재고수량설정
				$ship_store['store_supply_set_order']	= $defulat_store_value;
				// 수령매장 창고 고유키
				$ship_store['store_scm_seq']			= $store_scm_seq;
				
				$shipping_store_seq[] = $this->CI->shippingmodel->set_shipping_store($ship_store);
			}
		}
		return $shipping_store_seq;
	}
	// 관리자 - 상품 목록 바코드 다운로드 
	public function init_admin_goods_catalog_barcode_download(){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$this->CI->template->assign('checkO2OService', $this->checkO2OService);
		$this->CI->template->define('o2o_barcode_download', $this->CI->skin.'/o2o/_modules/barcode_download.html');
	}
	
	// 관리자 - 설정 - 회원 등급별 구매 혜택 안내
	public function init_admin_member_sale(){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$this->CI->template->assign('checkO2OService', $this->checkO2OService);
		$this->CI->template->define('o2o_member_sale', $this->CI->skin.'/o2o/_modules/member_sale.html');
	}
	
	// o2o 가입환경 추가
	public function init_sitetype(&$sitetypeary){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		$sitetypeary[$this->o2o_sitetype] = array("name"=>"오프라인매장 ", "image"=>"icon_pos.gif");
	}
	
	// o2o 바코드 실물 다운로드 규격 추가
	public function init_admin_goods_barcode_download_form(&$columnNames, &$cellNames, $params){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$arr_excel_type = explode("_", $params['excel_type']);
		if($arr_excel_type[1] == 'barcode'){
			$columnNames = array(
				'상품명', '바코드', '판매가'
			);
			$cellNames = array(
				'C.goods_name', 'C.goods_seq'
			);
		}
	}
	
	// o2o 바코드 실물 다운로드 쿼리 추가
	// goods의 데이터를 모두 추출한 후 필수옵션과 추가옵션을 별도로 추출하여 합한다
	public function init_admin_goods_barcode_download_sql(&$queryDB, $conn_id, $params){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$this->sql_barcode_key = array('full_option_name','full_option_barcode','each_opt_price');
		
		$arr_excel_type = explode("_", $params['excel_type']);
		if($arr_excel_type[1] == 'barcode'){
			$goods = array();	// 정보 조합용 데이터 
			$arr_good_seq = array();	// 쿼리 추출용 데이터
			while($tmpGood = mysqli_fetch_array($queryDB)){
				$goods[$tmpGood['goods_seq']] = $tmpGood;
				$arr_good_seq[] = $tmpGood['goods_seq'];
			}

			$option_sql = "
					SELECT 
						TRIM(concat(
							g.goods_name
							, ' '
							, ifnull(opt.option1,'')
							, if(ifnull(opt.option2,'') = '', '', concat('_',opt.option2))
							, if(ifnull(opt.option3,'') = '', '', concat('_',opt.option3))
							, if(ifnull(opt.option4,'') = '', '', concat('_',opt.option4))
							, if(ifnull(opt.option5,'') = '', '', concat('_',opt.option5))
						)) as ".$this->sql_barcode_key[0]."
						, opt.full_barcode as ".$this->sql_barcode_key[1]."
						, opt.goods_seq as goods_seq
						, opt.price as ".$this->sql_barcode_key[2]."
					FROM fm_goods_option opt
						inner join fm_goods g on g.goods_seq = opt.goods_seq AND g.provider_seq = '1'
					WHERE
						opt.goods_seq in (". implode(",", $arr_good_seq).")
			";
			$suboption_sql = "
					SELECT 
						TRIM(concat(
							g.goods_name
							, ' '
							, ifnull(opt.suboption_title,'')
							, if(ifnull(opt.suboption,'') = '', '', concat('_',opt.suboption))
						)) as ".$this->sql_barcode_key[0]."
						, opt.sub_full_barcode as ".$this->sql_barcode_key[1]."
						, opt.goods_seq as goods_seq
						, opt.price as ".$this->sql_barcode_key[2]."
					FROM fm_goods_suboption opt
						inner join fm_goods g on g.goods_seq = opt.goods_seq AND g.provider_seq = '1'
					WHERE
						opt.goods_seq in (". implode(",", $arr_good_seq).")
			";
			// 기획팀 요청에 의해 O2O 실물 바코드 시 추가구성 옵션 다운로드 목록에서 제거
			if($arr_excel_type[1] == 'barcode'){
				$sql = $option_sql;
			}else{
				$sql = "
					(
					".$option_sql."
					) union (
					".$suboption_sql."
					)
					"
				;
			}
			// 리턴용 객체 재생성
			$queryDB = mysqli_query($conn_id, $sql);
		}
	}
	
	// o2o 바코드 실물 다운로드 행 추가
	public function init_admin_goods_barcode_download_row(&$goodsRow, $goods, $params){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		// init_admin_goods_barcode_download_sql 조합시 미리 생성
		// $this->sql_barcode_key = array('full_option_name','full_barcode','each_opt_price');
		
		$arr_excel_type = explode("_", $params['excel_type']);
		if($arr_excel_type[1] == 'barcode'){
			
			$tmpGoodsRow = array();
			foreach($this->sql_barcode_key as $key){
				$row_text = $goods[$key];			
				$tmpGoodsRow[] = html_entity_decode($row_text, ENT_QUOTES, 'utf-8');
			}
			$goodsRow = $tmpGoodsRow;
		}
	}
	
	// 공통 - 모바일 사이드 회원 바코드
	public function init_front_mobile_side_barcode(){
		if(!$this->checkFrontO2OService){return $this->checkFrontO2OService;}
		
		$this->CI->template->assign('checkO2OService', $this->checkFrontO2OService);
		
		$this->CI->template->assign('o2o_barcode_key', $this->CI->userInfo['member_seq']);
		
		$this->CI->template->define('o2o_layout_side', $this->CI->skin.'/o2o/_modules/layout_side.html');
		
	}
	
	// 매출 통계에서 본사매출 중 POS에서 발생한 내역은 제외한다.
	public function init_admin_statistic_sales_monthly_for_params(&$params){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		// POS 매출은 본사매출에서 제외한다
		$params['not_sitetype'] = array();
		$o2o_pos_sitetype = $this->o2o_sitetype;
		if(in_array($o2o_pos_sitetype,$params['sitetype'])){
			if (($key = array_search($o2o_pos_sitetype, $params['sitetype'])) !== false) {
				unset($params['sitetype'][$key]);
			}
			$params['add_o2o_stats'] = '1';	// 매장 매출 추출 추가
			// $params['not_sitetype'][] = $this->o2o_sitetype;
		}
		
		// 사이트맵 제외 검색 조건 추가
		foreach($this->CI->sitetypeloop as $sitetype=>$data){
			if (($key = array_search($sitetype, $params['sitetype'])) === false) {
				$params['not_sitetype'][] = $sitetype;
			}
		}
		$this->CI->template->assign('checkO2OService', $this->checkO2OService);
	}
	
	// O2O 매장 매출 정보 추가
	public function init_admin_statistic_sales_monthly_for_stats($params, $migration_info, &$orgStatsData, &$commission_data){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$flag_migration		= $migration_info['flag_migration'];
		$migrationYear		= $migration_info['migrationYear'];
		$migrationMonth		= $migration_info['migrationMonth'];
		
		if($params['add_o2o_stats'] == '1'){
			$this->CI->load->model('statsmodel');
			$this->CI->load->model('accountallmodel');
			unset($params['add_o2o_stats']);
			unset($params['sitetype']);
			unset($params['not_sitetype']);
			$params['sitetype'] = array($this->o2o_sitetype);
			$params['without_null_sitetype'] = '1';
			$params['only_o2o_stats'] = '1';
			
			$params['q_type']	= 'order';
			$query	= $this->CI->statsmodel->get_sales_sales_monthly_stats($params);
			foreach($query->result_array() as $row)
				$o2oStatsData[$row['stats_month']-1]	= is_array($o2oStatsData[$row['stats_month']-1]) ? array_merge($o2oStatsData[$row['stats_month']-1],$row) : $row;

			$params['q_type']	= 'refund';
			$query	= $this->CI->statsmodel->get_sales_sales_monthly_stats($params);
			foreach($query->result_array() as $row)
				$o2oStatsData[$row['stats_month']-1]	= is_array($o2oStatsData[$row['stats_month']-1]) ? array_merge($o2oStatsData[$row['stats_month']-1],$row) : $row;


			if($flag_migration){

				//정산금액 : 신정산의 이월/당월 정산금액
				$params['q_type']	= 'commission';
				$commission_result	= $this->CI->accountallmodel->get_sales_sales_monthly_stats($params);
				foreach($commission_result as $_data){
					$ym = $_data['stats_year'].str_pad($_data['stats_month'],2,"0",STR_PAD_LEFT);
					if($commission_data[$ym]){
						$commission_data[$ym]['month_commission_price_sum']					+= $_data['month_commission_price_sum'];
						$commission_data[$ym]['month_refund_commission_price_sum']			+= $_data['month_refund_commission_price_sum'];
						$commission_data[$ym]['refund_rollback_commission_price_sum']		+= $_data['refund_rollback_commission_price_sum'];
					}else{
						$commission_data[$ym] = $_data;
					}
				}

				$params['q_type']	= 'order';
				$result	= $this->CI->accountallmodel->get_sales_sales_monthly_stats($params);
				foreach($result as $row){
					if($migrationYear < $params['year'] || ($migrationYear == $params['year'] && $migrationMonth <= $row['stats_month'])){
						$o2oStatsData[$row['stats_month']-1]	= is_array($o2oStatsData[$row['stats_month']-1]) ? array_merge($o2oStatsData[$row['stats_month']-1],$row) : $row;
					}
				}

				$params['q_type']	= 'refund';
				$result	= $this->CI->accountallmodel->get_sales_sales_monthly_stats($params);
				foreach($result as $row){
					if($migrationYear < $params['year'] || ($migrationYear == $params['year'] && $migrationMonth <= $row['stats_month'])){
						$o2oStatsData[$row['stats_month']-1]	= is_array($o2oStatsData[$row['stats_month']-1]) ? array_merge($o2oStatsData[$row['stats_month']-1],$row) : $row;
					}
				}

			}
			
			// 기존 추출 정보와 매장 추출정보를 합산한다.
			foreach($o2oStatsData as $iO2O => &$rowO2O){
				// 배열의 키 명칭 수정
				foreach($rowO2O as $key=>$value){
					if(preg_match("/^(m_|month_m_)/", $key, $matches)){
						$rep_key = $key;
						$rep_key = str_replace("month_m_", "month_o_", $rep_key);
						$rep_key = str_replace("m_", "o_", $rep_key);
						
						$rowO2O[$rep_key] = $rowO2O[$key];
						unset($rowO2O[$key]);
					}
				}
			}
			
			$maxValue = 0;
			$maxMonth = 12;
			for($i=0;$i<$maxMonth;$i++){
				if(!empty($o2oStatsData[$i])){
					foreach($o2oStatsData[$i] as $key=>$value){
						$exBaseKey = array('stats_year', 'stats_month');
						$exKey = array('month_supply_price_sum', 'month_refund_supply_price_sum', 'refund_rollback_supply_price_sum');
						if(in_array($key, $exBaseKey)){
							continue;
						}elseif(preg_match("/^(o_|month_o_)/", $key, $matches)){
							 // 매장 정보 추가
							$orgStatsData[$i][$key] = $o2oStatsData[$i][$key];
						}elseif(in_array($key, $exKey)){
							$prepKey = $key;
							$prepKey = 'o_'.$prepKey;
							 // 매장 정보 추가
							$orgStatsData[$i][$prepKey] = $o2oStatsData[$i][$key];
						}else{
							// 총계 합산 추가
							$orgStatsData[$i][$key] += $o2oStatsData[$i][$key];
						}
					}
					
				}
			}
		}
	}
	
	// O2O 매장 매출 계산 추가
	public function init_admin_statistic_sales_monthly_for_calculate(&$statsData){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		// 에누리 가격 가감
		//$statsData['o_settleprice_sum'] -= ($statsData['o_enuri_sum']+$statsData['o_emoney_sum']);

		// 매장 결제금액 계산 :: 2015-10-06 lwh
		$statsData['month_o_order_price'] = $statsData['o_settleprice_sum'] + $statsData['o_shipping_cost_sum'] + $statsData['o_goods_shipping_cost_sum'];
		

		// 환불 마이너스 처리
		$statsData['month_o_refund_price_total_sum'] = $statsData['month_o_refund_price_total_sum'] * -1;

		// 취소/반품 마이너스 처리
		$statsData['month_o_refund_price_sum'] = $statsData['month_o_refund_price_sum'] * -1;

		// 되돌리기 마이너스 처리
		$statsData['month_o_rollback_price_sum'] = $statsData['month_o_rollback_price_sum'] * -1;

		// 매입가 마이너스 처리
		$statsData['o_month_supply_price_sum']		= $statsData['o_month_supply_price_sum'] * -1;

		// 매출액
		$statsData['month_o_sales_price'] = $statsData['month_o_order_price'] + $statsData['month_o_refund_price_total_sum'];

		//-----------원가계산------------//
		// 매입/정산 합계
		$statsData['month_supply_price'] = $statsData['month_supply_price'] + $statsData['o_month_supply_price_sum'];

		// 취소/반품 합계
		$statsData['month_refund_supply'] = $statsData['month_refund_supply'] + $statsData['o_month_refund_supply_price_sum'];
		// 되돌리기 합계
		$statsData['month_rollback_supply'] = $statsData['month_rollback_supply'] + $statsData['o_refund_rollback_supply_price_sum'];
		// 매장합계
		$statsData['o_month_supply_total'] = $statsData['o_month_supply_price_sum'] + $statsData['o_month_refund_supply_price_sum'] + $statsData['o_refund_rollback_supply_price_sum'];
		
		// 원가 전체합계
		$statsData['month_supply_commission_sum'] = $statsData['month_supply_total'] + $statsData['month_commission_total'] + $statsData['o_month_supply_total'];

		//-----------매출이익 계산------------//
		// 본사 매출이익
		$statsData['month_o_sales_benefit'] = $statsData['month_o_sales_price'] + $statsData['o_month_supply_total'];
		// 전체 매출이익
		$statsData['month_sales_benefit'] = $statsData['month_sales_price'] + $statsData['month_supply_commission_sum'];

		$statsData['month_o_sales_benefit_percent'] = 0;
		$statsData['month_sales_benefit_percent'] = 0;
		// 본사 매출이익 %
		if($statsData['month_o_sales_benefit'] > 0 && $statsData['month_o_sales_price'] > 0){
			$statsData['month_o_sales_benefit_percent'] = round(($statsData['month_o_sales_benefit'] / $statsData['month_o_sales_price']) * 100,2);
		}
		// 전체 매출이익 %
		if($statsData['month_sales_benefit'] > 0 && $statsData['month_sales_price'] > 0){
			$statsData['month_sales_benefit_percent'] = round(($statsData['month_sales_benefit'] / $statsData['month_sales_price']) * 100,2);
		}

	}
	
	// O2O 매장 매출 계산 추가
	public function init_admin_statistic_sales_monthly_for_calculate2(&$dataForTableSum){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		// 매출이익 퍼센트 재계산 :: 2015-09-12 lwh
		if(!$dataForTableSum['month_o_sales_benefit'] || !$dataForTableSum['month_o_sales_price']){
			$dataForTableSum['month_o_sales_benefit_percent'] = "0";
		}else{
			$dataForTableSum['month_o_sales_benefit_percent'] = round(($dataForTableSum['month_o_sales_benefit'] / $dataForTableSum['month_o_sales_price'])*100,2);
		}
		if(!$dataForTableSum['month_sales_benefit'] || !$dataForTableSum['month_sales_price']){
			$dataForTableSum['month_sales_benefit_percent'] = "0";
		}else{
			$dataForTableSum['month_sales_benefit_percent'] = round(($dataForTableSum['month_sales_benefit'] / $dataForTableSum['month_sales_price'])*100,2);
		}
	}
	
	// O2O 매장별 매출 통계 메뉴 추가
	public function init_admin_statistic_sales_menu(){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$this->CI->template->assign('checkO2OService', $this->checkO2OService);
		
		$this->CI->template->define('o2o_statistic_sales_menu', $this->CI->skin.'/o2o/_modules/statistic_sales_menu.html');
	}
	
	// O2O 매장별 매출 통계
	public function init_admin_statistic_sales_page($params = array()){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$this->CI->template->assign('checkO2OService', $this->checkO2OService);
		
		// 매장 정보 추출
		$this->CI->load->library("o2o/o2oservicelibrary");
		$o2oStoreList = $this->CI->o2oservicelibrary->get_o2o_config(array(),999);

		if($params['o2o_store_seq']){
			// 매장 상품별 리스트 데이터 추출
			$tmpList	= array();
			$this->CI->load->library("o2o/o2oservicelibrary");
			$this->CI->o2oservicelibrary->get_o2o_goods_stat($params,$tmpList);
			
			foreach($tmpList as $data){
				$data['sell_price']	= $data['price_sum'] - $data['sale_sum'];
				$statList[] = $data;

				// 총합 계산
				$totalSell['ea']		+= $data['ea_sum'];
				$totalSell['price']		+= $data['price_sum'];
				$totalSell['sale']		+= $data['sale_sum'];
				$totalSell['sell']		+= $data['sell_price'];

				//상품별 배송그룹 배송비계산 @2018-11-01 hed
				$params['goods_seq']		= $data['goods_seq'];
				$goods_shipping_code	= array();
				$this->CI->load->library("o2o/o2oservicelibrary");
				$this->CI->o2oservicelibrary->get_o2o_goods_shipping_code($params, $goods_shipping_code);
				$totalSell['shipping']	+= (int)($goods_shipping_code['shipping_sum']);//$data['shipping_sum'];
			}

			/*
			 * 정산 개선 관련 소스 원복 
			$params_stats_v2 = array();
			$params_stats_v2['sdate']				= $params['sdate'];
			$params_stats_v2['edate']				= $params['edate'];
			$params_stats_v2['sitetype']			= array('POS');
			$params_stats_v2['provider_seq']		= '1';	// 본사 상품 
			$params_stats_v2['base_key']			= 'order_referer';	// 병합을 처리할 기준 필드
			$params_stats_v2['goods_seq']			= $params['goods_seq'];
			$params_stats_v2['order_referer']		= $params['o2o_store_seq'];

			$this->CI->load->model('accountallmodel');
			$totalSell['shipping'] = $this->CI->accountallmodel->get_goods_shipping_code_v2($params_stats_v2);
			 */
			
			$toRefund	= array();
			$this->CI->load->library("o2o/o2oservicelibrary");
			$this->CI->o2oservicelibrary->get_o2o_refund_stat($params, $toRefund);
			
			$totalSell['refund_price']			= $toRefund['refund'][0]['refund_price'];
			$totalSell['return_shipping_price']	= $toRefund['return'][0]['return_shipping_price'];
			$totalSell['total_price']			= $totalSell['sell'] + $totalSell['shipping'] - $totalSell['refund_price'];

		}else{
			// 매장별 리스트 데이터 추출
			$tmpList	= array();
			$this->CI->load->library("o2o/o2oservicelibrary");
			$this->CI->o2oservicelibrary->get_o2o_sales_stat($params,$tmpList);
			
			foreach($tmpList as $data){
				$data['sell_price']	= $data['price_sum'] - $data['sale_sum'] - $data['refund_price'] + $data['shipping_sum'];
				$data['goods_ea'] = count($data['goods_ea']);
				$statList[] = $data;

				// 총합 계산
				$totalSell['price_sum']				+= $data['price_sum'];
				$totalSell['sale_sum']				+= $data['sale_sum'];
				$totalSell['shipping_sum']			+= $data['shipping_sum'];
				$totalSell['refund_price']			+= $data['refund_price'];
				$totalSell['sell_price']			+= $data['sell_price'];
				$totalSell['return_shipping_price']	+= $data['return_shipping_price'];
				$totalSell['total_ea']				+= $data['total_ea'];
				$totalSell['goods_ea']				+= $data['goods_ea'];
			}
		}
		
		
		$this->CI->template->assign(array(
			'totalSell'		=> $totalSell,
			'o2o_store'		=> $o2oStoreList,
			'param'			=> $params,
			'statList'		=> $statList
		));

		$file_path	= $this->CI->template_path('o2o');
		$this->CI->template->define(array('tpl'=>$file_path));
		$this->CI->template->print_("tpl");
	}
	
	// O2O 어드민CRM 고객 정보 바코드 추가
	public function init_admincrm_main_user_detail($member_seq){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$this->CI->template->assign('checkO2OService', $this->checkO2OService);
		
		// POS 용 바코드 번호 추출
		$this->CI->load->library('o2o/o2obarcodelibrary');
		$barcode_key = $this->CI->o2obarcodelibrary->encode_barcode_member($member_seq);
		$this->CI->template->assign("barcode_key", $barcode_key);
	}
	
	// O2O 상품 선택 가능 기능
	public function init_admin_goods_match($order, $goods, &$match_selectable){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		if($order['sitetype'] == $this->o2o_sitetype && $goods['provider_seq'] != '1'){
			$match_selectable = 'NOT_POS_ORDER';
		}
	}
	
	// O2O 상품 선택 가능 기능
	public function init_admin_order_view(&$order){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		if($order['sitetype'] == $this->o2o_sitetype){
			$order['disable_order_back_action'] = 'POS';
		}
	}
	
	
	// O2O 상품 선택 가능 기능
	public function init_admin_order_process_batch_goods_ready(&$origin_order_seq, &$msg){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		$wheres = array();
		$wheres['order_seq'] = $origin_order_seq;
		$wheres['sitetype'] = $this->o2o_sitetype;
		$pos_orders = $this->CI->ordermodel->get_order(null, $wheres, true, true);
		
		$arr_pos_order_seq = array();
		foreach($pos_orders as $pos_order){
			$pos_order_seq = $pos_order['order_seq'];
			foreach($origin_order_seq as $k=>$order_seq){
				if($pos_order_seq == $order_seq){
					unset($origin_order_seq[$k]);
				}
			}
			$arr_pos_order_seq[] = $pos_order_seq;
		}
		if($arr_pos_order_seq){
			$msg .= "<br/><br/>오프라인 주문은 상품 준비 상태로 변경이 불가합니다.<br/>";
			$msg .= implode($arr_pos_order_seq, '<br/>');
		}
	}
	
	
	// O2O 출고 안내 문구 추가
	public function init_admin_order_order_export_popup(){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$this->CI->template->assign('checkO2OService', $this->checkO2OService);
		$this->CI->template->define('o2o_order_export_popup', $this->CI->skin.'/o2o/_modules/order_export_popup.html');
	}
	
	// O2O 주문 자동 배송완료 처리
	public function init_admin_order_process_order_export_exec($origin_order_seq, $scm_wh){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		$wheres = array();
		$wheres['order_seq'] = $origin_order_seq;
		$wheres['sitetype'] = $this->o2o_sitetype;
		$pos_orders = $this->CI->ordermodel->get_order(null, $wheres, true, true);
		
		$this->CI->load->library("o2o/o2oorderlibrary");
		
		foreach($pos_orders as $pos_order){
			$pos_order_seq = $pos_order['order_seq'];
			$this->CI->o2oorderlibrary->proc_o2o_order_batch_status($pos_order_seq, $scm_wh);
		}
	}
}
