<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class popup extends selleradmin_base {

	public function __construct() {
		parent::__construct();
		$this->load->library('validation');
	}

	public function _zipcode_oldzibun()
	{
		// 우편번호 설정
		$cfg_zipcode		= config_load('zipcode');
		
		//사용가능한 우편번호 검색
		$use_zipcode_set	= array();
		if($cfg_zipcode['street_zipcode_5'])		$use_zipcode_set[]	= 'street';
		if($cfg_zipcode['street_zipcode_6'])		$use_zipcode_set[]	= 'zibun';
		if($cfg_zipcode['old_zipcode_lot_number'])	$use_zipcode_set[]	= 'oldzibun';

		if(!$_GET['zipcode_type'])									$_GET['zipcode_type']	= $use_zipcode_set[0];
		else if(!in_array($_GET['zipcode_type'],$use_zipcode_set))	$_GET['zipcode_type']	= $use_zipcode_set[0];

		$select_zipcode_type = $_GET['zipcode_type'];


		// 우편번호 설정
		$cfg_zipcode = config_load('zipcode');
		if($this->mobileMode)	
			$perpage = "5";
		else 
			$perpage = "10";		

	    $this->load->model('zipcodemodel');		
		$data = $this->zipcodemodel->zipcode_oldzibun($perpage);

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign("cfg_zipcode",$cfg_zipcode);
		$this->template->assign("zipcodeFlag",$_GET['zipcodeFlag']);
		$this->template->assign("zipcode_type",$data['zipcode_type']);
		$this->template->assign("query_string",$data['query_string']);
		$this->template->assign("keyword",$data['keyword']);
		$this->template->assign("page",$data['page']);
		$this->template->assign("loop",$data['loop']);
		$this->template->print_("tpl");
	}
	
	public function zipcode()
	{
		$aGetParams = $this->input->get();

		if ($aGetParams['idx'] === 'undefined') {
			$aGetParams['idx'] = '';
		}
		if ($aGetParams['page'] === 'undefined') {
			$aGetParams['page'] = 1;
		}
		if ($aGetParams['ziptype'] === 'undefined') {
			$aGetParams['ziptype'] = '';
		}

		// validation
		if ($aGetParams) {
			$this->validation->set_data($aGetParams);
			$this->validation->set_rules('page', '페이지', 'trim|numeric|xss_clean');
			$this->validation->set_rules('zipcode_type', '우편번호 종류', 'trim|string|xss_clean');
			$this->validation->set_rules('old_zipcode', '구우편번호', 'trim|string|xss_clean');
			$this->validation->set_rules('mtype', '모드', 'trim|string|xss_clean');
			$this->validation->set_rules('iframe', '아이프레임', 'trim|numeric|xss_clean');
			$this->validation->set_rules('keyword', '검색어', 'trim|string|xss_clean');
			if ($this->validation->exec() === false) {
				show_error($this->validation->error_array['value']);
			}
		}

		/**
		 * "반응형 스킨"과 "전용 스킨"의 넘어오는 파라미터 명이 다르기 때문에 통합 했습니다.
		 * $this->zipcodemodel->zipcode() 에서 글로벌 변수 $_GET 사용되어서 $_GET['keyword'] 통합 했습니다.
		 */
		$_GET['keyword'] = (isset($aGetParams['zipcode_keyword'])) ? $aGetParams['zipcode_keyword'] : $aGetParams['keyword'];

		/**
		 * 2글자 이하면 경고창 출력 시킨다
		 * 1글자면 검색시 slow query 발생
		 */
		$wordLength = mb_strlen(trim($_GET['keyword']));
		if ($wordLength === 1) {
			// iframe 호출 되이서 javascript callback 동작되지 않기 때문에 키워드 초기화 시킴
			$_GET['keyword'] = '';

			/**
			 * 팝업창 에서 처리
			 *
			 * 다국어 스킨 이면 주소찾기 스킨도 변경됩니다
			 * - 다국어스킨 + 팝업창 = 에러 (opener, parent 사용못함)
			 * - 위치 : 관리자 > 주문 > 전체 주문 조회 > 관리자가 주문넣기 > 주소검색 팝업창 open
			 *
			 * 경고창 출력 후 exit 하면 안됩니다.
			 * - view 출력이 되지 않습니다
			 */

			// adminzipcode 관리자에서 호출한 페이지인지 확인하는 값
			if (isset($aGetParams['adminzipcode']) && $aGetParams['adminzipcode'] === 'y') {
				alert('검색어는 2자이상 입력하여 주세요');

			// 검색어는 2자이상 입력하여 주세요
			} else {
				openDialogAlert(getAlert('et428'), 400, 160, 'parent');
			}
		}

		// 우편번호 설정
		$cfg_zipcode		= config_load('zipcode');
		
		//사용가능한 우편번호 검색
		$use_zipcode_set	= array();
		if($cfg_zipcode['street_zipcode_5'])		$use_zipcode_set[]	= 'street';
		if($cfg_zipcode['street_zipcode_6'])		$use_zipcode_set[]	= 'zibun';
		if($cfg_zipcode['old_zipcode_lot_number'])	$use_zipcode_set[]	= 'oldzibun';

		if (!$aGetParams['zipcode_type']) {
			$_GET['zipcode_type'] = $use_zipcode_set[0];
		} else if(!in_array($aGetParams['zipcode_type'],$use_zipcode_set)) {
			$_GET['zipcode_type'] = $use_zipcode_set[0];
		}

		$select_zipcode_type = $_GET['zipcode_type'];

		// 구지번 검색
		if($select_zipcode_type == 'oldzibun'){
			$this->_zipcode_oldzibun();
			exit;
		}

		if($this->mobileMode)	
			$perpage = "5";
		else 
			$perpage = "10";		

	    $this->load->model('zipcodemodel');
		$data = $this->zipcodemodel->zipcode($perpage);
		
		
		if($this->mobileMode){
			$this->template->assign("zipcodeFlag",$_GET['zipcodeFlag']);			
		}
		
		$file_path	= $this->template_path();
		$this->template->assign(['sc' => $aGetParams]);
		$this->template->assign("cfg_zipcode",$cfg_zipcode);
		$this->template->assign("zipcode_type",$data['zipcode_type']);
		$this->template->assign("query_string",$data['query_string']);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign("arrSido",$data['arrSido']);
		$this->template->assign("arrSigungu",$data['arrSigungu']);
		$this->template->assign("zipcodeFlag",$aGetParams['zipcodeFlag']);		
		$this->template->assign("keyword",$data['keyword']);
		$this->template->assign("page",$data['page']);
		$this->template->assign("loop",$data['loop']);
		$this->template->print_("tpl");

	}

	public function zipcode_street_sigungu()
	{
		$arrSigungu = array();
	    $this->load->helper('zipcode');
	    $ZIP_DB = get_zipcode_db();

		$zipcode_type = $_GET['zipcode_type'] ? $_GET['zipcode_type'] : "street";

		if(isset($_GET['zipcode_keyword'])){
			$keyword = $_GET['zipcode_keyword'];
		}else{
			$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : false;
		}

		if($keyword){
			$keyword = trim($keyword);
			$keyword = str_replace(array('>','<','"','\'','\\'),'',$keyword);
			$keyword = preg_replace("/\-$/","",$keyword);
			$keyword = preg_replace("/(\s)+/"," ",$keyword);
			$keyword = preg_replace("/(동|면|읍|리)([0-9])([^가])/","$1 $2$3",$keyword);

			if(preg_match("/(.*)로([0-9]+(.*))/i",$keyword,$matches)){
				$keyword = $matches[1].'로'.$matches[2];
			}
			if(preg_match("/(.*)동([0-9]+(.*))/i",$keyword,$matches)){
				$keyword = $matches[1].'동'.$matches[2];
			}

			$wheres = array();
			$keywords = array();		// 입력된 키워드
			$remain_keywords = array();	// 입력된 키워드중 where절에 포함되지 않은 나머지 키워드들
			$tmp_keywords = explode(' ',$keyword);

			// 키워드 정리
			foreach($tmp_keywords as $value){
				$value = trim($value);
				if(preg_match("/(.*)로([0-9]+(.*))/i",$value,$matches)){
					$keyword2 = $matches[1].'로 '.$matches[2];
					$tmp_keywords2 = explode(' ',$keyword2);
					foreach($tmp_keywords2 as $value2){
						$value2 = trim($value2);
						if(!$value) continue;
						$keywords[] = $value2;
					}
				}

				if(!$value) continue;
				$keywords[] = $value;
			}
			$remain_keywords = $keywords;

			// 검색된 절
			$clauses = array();

			// 검색모드(도로명이 포함되었는지, 동검색이 포함되었는지)
			$mode = '';

			foreach($keywords as $value){

				if($value=='서울시' || $value=='서울') $value='서울특별시';
				/*
				if(preg_match("/시$/",$value) || preg_match("/도$/",$value) || preg_match("/군$/",$value) || preg_match("/구$/",$value)) {
					if(preg_match("/시$/",$value)){
						$wheres[] = "(SIDO LIKE '".$value."%' or SIGUNGU LIKE '".$value."%')";
						$clauses['SIDO'] = $clauses['SIGUNGU'] = $clauses['SI'] = $value;
					}elseif(preg_match("/도$/",$value)){
						$wheres[] = "SIDO LIKE '".$value."%'";
						$clauses['SIDO'] = $clauses['DO'] = $value;
					}elseif(preg_match("/구$/",$value)){
						$wheres[] = "(SIGUNGU LIKE '".$value."%' or SIGUNGU LIKE '".trim($clauses['SI'].' '.$value)."%')";
						$clauses['SIGUNGU'] = $clauses['GU'] = $value;
					}else{
						$wheres[] = "SIGUNGU LIKE '".$value."%'";
					}

					continue;
				}
				*/

				if(preg_match("/로$/",$value) || preg_match("/길$/",$value)) {
					$wheres[] = $sidoWheres[] = "STREET LIKE '".$value."%'";
					$clauses['street'] = $value;
					$mode = 'street';
				}
				else if(preg_match("/동$/",$value) || preg_match("/면$/",$value) || preg_match("/읍$/",$value) || preg_match("/동[0-9]+가$/",$value)) {
					$wheres[] = $sidoWheres[] = "(DONG LIKE '".$value."%')";
					$mode = 'dong';
				}
				else if(preg_match("/리$/",$value)) {
					$wheres[] = $sidoWheres[] = "RI LIKE '".$value."%'";
					$mode = 'dong';
				}
				else if(!preg_match("/^[0-9]/",$value)){
					$wheres[] = $sidoWheres[] = "SIGUNGUBUILDING LIKE '".$value."%'";
					$mode = 'dong';
				}

				if(preg_match("/^[0-9]/",$value)){
					$nums = preg_replace("/[^0-9-]/","",$value);
					$nums = explode("-",$nums);

					if($mode=='dong'){
						$numWhere = "JIBUN1 = '".$nums[0]."'";
						if($nums[1])
						$numWhere = "(".$numWhere." and JIBUN2 = '".$nums[1]."')";
						$wheres[] = $sidoWheres[] = $numWhere;
					}

					if($mode=='street'){
						$numWhere = "BUILDINGNUM1 = '".$nums[0]."'";
						if($nums[1])
						$numWhere = "(".$numWhere." and BUILDINGNUM2 = '".$nums[1]."')";
						$numWhere = "((".$numWhere.") or STREET LIKE '".$clauses['street'].$nums[0]."번길%')";
						$wheres[] = $sidoWheres[] = $numWhere;
					}

					if(!$mode){
						$numWhere = "(JIBUN1 = '".$nums[0]."' or BUILDINGNUM1 = '".$nums[0]."')";
						if($nums[1])
						$numWhere = "(".$numWhere." and (JIBUN2 = '".$nums[1]."' or BUILDINGNUM2 = '".$nums[1]."'))";
						$wheres[] = $sidoWheres[] = $numWhere;
					}
				}
			}

			if(!$mode && !$wheres){
				$wheres[] = $sidoWheres[] = "STREET LIKE '".$keyword."%' or BUILDING LIKE '".$keyword."%' or DONG LIKE '".$keyword."%''".$keyword."%' or SIGUNGUBUILDING LIKE '".$keyword."%'";
			}

			if($sidoWheres){
				$arrSigungu = $ZIP_DB->query("select SIGUNGU from zipcode_street WHERE SIDO = '".$_GET['SIDO']."' AND ".implode(" AND ", $sidoWheres)." GROUP BY SIGUNGU");
			}else{
				$arrSigungu = $ZIP_DB->query("select SIGUNGU from zipcode_street WHERE SIDO = '".$_GET['SIDO']."' GROUP BY SIGUNGU");
			}

			$arrSigungu = $arrSigungu->result_array();

		}

		echo json_encode($arrSigungu);
	}

	public function sido()
	{
	    $this->load->helper('zipcode');
	    $ZIP_DB = get_zipcode_db();

		$loop = "";
		if($_GET['sido']){
			$query = "SELECT
			concat(SIDO,' ',SIGUNGU) as sigungu_addr,
			concat(SIDO,' ',SIGUNGU,' ', DONG) as addr,
			concat(SIDO,' ',SIGUNGU,' ',STREET) as addr_street
			FROM zipcode_street WHERE";

			if($_GET['zipcode_type'] == "street"){
				$wheres[] = $sidoWheres[] = "(STREET LIKE '".$_GET['sido']."%' OR SIGUNGU LIKE '".$_GET['sido']."%')";// or BUILDING LIKE '".$_GET['sido']."%'
			}else{
				$wheres[] = $sidoWheres[] = "(DONG LIKE '".$_GET['sido']."%' OR SIGUNGU LIKE '".$_GET['sido']."%')";// or SIGUNGUBUILDING LIKE '".$_GET['sido']."%'
			}

			$query = $ZIP_DB->query($query.implode(" AND ", $sidoWheres)." group by SIDO,SIGUNGU,STREET");
			$i=0;
			foreach ($query->result_array() as $row){

				if($before_sigungu != $row['sigungu_addr']){
					$loop[$i]['addr'] = $row['sigungu_addr'];
					$loop[$i]['addr_street'] = $row['sigungu_addr'];
					$i++;
				}
				$before_sigungu = $row['sigungu_addr'];
				$loop[$i]['addr'] = $row['addr'];
				$loop[$i]['addr_street'] = $row['addr_street'];
				$i++;
			}

		}

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign("sidoFlag",$_GET['sidoFlag']);
		$this->template->assign("sido",$_GET['sido']);
		$this->template->assign("idx",$_GET['idx']);
		$this->template->assign("loop",$loop);
		$this->template->print_("tpl");
	}

	public function information()
	{
		$file_path	= $this->template_path();
		$template_path = $_GET['template_path'].'.html';
		$file_path	= str_replace('information.html',$template_path,$file_path);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function salecost_info(){
		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	// 배송비 관련 주소검색 팝업 :: 2016-05-30 lwh
	public function zipcode_zone(){
		$this->load->model('zipcodemodel');

		$file_path	= $this->template_path();
		if($_GET['nation'] == 'global'){
			$file_path	= str_replace('zipcode_zone.html', 'zipcode_zone_global.html', $file_path);
		}
		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign("nation",$_GET['nation']);
		$this->template->assign("p_type",$_GET['p_type']);
		$this->template->assign("idx",$_GET['idx']);
		$this->template->print_("tpl");
	}

	// 배송비 관련 주소검색 AJAX :: 2016-05-30 lwh
	public function zipcode_zone_ajax(){
		$nation				= $_GET['nation'];
		$address_type		= $_GET['address_type'];
		$limitType			= $_GET['limitType'];
		
		$this->load->model('zipcodemodel');
		if($nation == 'korea'){
			$serch_txt['SIDO']		= $_GET['SIDO'];
			if($_GET['SIGUNGU'])
				$serch_txt['SIGUNGU']	= $_GET['SIGUNGU'];
			if($_GET['DONG'])
				$serch_txt['DONG']		= $_GET['DONG'];

			$data = $this->zipcodemodel->zipcode_selecter_kr($address_type, $serch_txt, $limitType);
		}else{
			if($address_type == 'nation_name'){
			}else{
				$serch_txt['EMS_TYPE']		= $_GET['EMS_TYPE'];
				if($_GET['EMS_AREA'])		$serch_txt['EMS_AREA']		= $_GET['EMS_AREA'];
				if($_GET['EMS_COUNTRY'])	$serch_txt['nation_name']	= $_GET['EMS_COUNTRY'];
			}
			$data = $this->zipcodemodel->zipcode_selecter_gl($address_type, $serch_txt);
		}

		echo json_encode($data);
	}

	// 배송비 관련 장소리스트 팝업 :: 2016-06-07 lwh
	public function shipping_address_pop(){
		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign("use_type",$_GET['use_type']);
		$this->template->assign("shipping_address_seqs", $this->input->get('shipping_address_seqs'));
		$this->template->print_("tpl");
	}

	// 배송비 Tab별 리스트 :: 2016-06-07 lwh
	public function shipping_address_list(){
		$file_path	= $this->template_path();
		$this->load->model('shippingmodel');

		if(defined('__ADMIN__') === true){
			$provider_seq = 1;
		}else{
			$provider_seq = $this->providerInfo['provider_seq'];
		}

		// 분류 그룹추출
		$category = $this->shippingmodel->get_shipping_category($_GET['tabType'],$provider_seq);

		if($_GET['src']) { parse_str($_GET['src']); unset($_GET['src']); }
		
		$sc = $_GET;
		$shipping_address_seqs = $sc['shipping_address_seqs'];
        $shipping_address_seqs = explode("|", $shipping_address_seqs);
        $shipping_address_seqs = array_filter($shipping_address_seqs);
        
        unset($sc['tabType']);
        unset($sc['shipping_address_seqs']);
		$sc['address_category'] = $address_category;
		$sc['address_nation']	= $address_nation;
		$sc['address_name']		= $address_name;
		$sc['page']				= $page;

		if($_GET['tabType'] == 'input'){ // 입력 장소 불러오기
			$sc['address_provider_seq'] = $provider_seq;
			$list = $this->shippingmodel->shipping_address_list($sc);

			foreach($list['record'] as $k => $v){
                if(in_array($v['shipping_address_seq'], $shipping_address_seqs) === true){
                    //매장 선택 시 중복 선택 하지 않도록
                    $list['record'][$k]['is_selected'] = 'Y';
                }
            }
		}

		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign("category",$category);
		$this->template->assign("loop",$list['record']);
		$this->template->assign("page",$list['page']);
		$this->template->assign("tabtype",$_GET['tabType']);
		$this->template->assign("sc",$sc);
		$this->template->print_("tpl");
	}

	// 배송비 상품상세페이지 배송안내 팝업 :: 2017-02-20 lwh
	public function shipping_desc_pop(){
		$file_path	= $this->template_path();

		$this->load->model('shippingmodel');
		$ship_set = $this->shippingmodel->get_shipping_set($_GET['set_seq'], 'shipping_set_seq');
		
		if($this->config_system['language'] == 'KR'){
			$desc['std'] = $ship_set['delivery_std_input'];
			$desc['add'] = $ship_set['delivery_add_input'];
		}else{
			$desc['std'] = $ship_set['delivery_std_input'.$this->config_system['language']];
			$desc['add'] = $ship_set['delivery_add_input'.$this->config_system['language']];
			
		}

		// 자동안내설명 스킨
		$this->template->define(array('delivery_desc' => $this->skin.'/setting/add_national_delivery_desc.html'));

		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign("desc",$desc);
		$this->template->print_("tpl");
	}

	// 출고 정보 변경창 :: 2016-09-29 lwh
	public function shipping_chg_pop(){
		$file_path	= $this->template_path();
		$this->load->model('ordermodel');
		$this->load->model('exportmodel');
		$this->load->model('shippingmodel');

		// identity_seq
		// p_type	-> order : shipping_seq / export : export_code
		// process	-> realtime : 실시간 변경 처리 / after : 변경정보만 리턴

		$identity_seq	= $_GET['identity_seq'];
		$p_type			= $_GET['p_type'];
		$process		= $_GET['process'];

		// 배송정보
		if($p_type == 'order'){ // 배송정보 추출
			$order_shipping		= $this->ordermodel->get_seq_for_order_shipping($identity_seq);
			$shipping_group		= $order_shipping['shipping_group'];
			$provider_seq		= $order_shipping['provider_seq'];
			$shipping_method	= $order_shipping['shipping_method'];
		}else{ // 출고정보
			$order_shipping		= $this->exportmodel->get_export($identity_seq);
			$shipping_group		= $order_shipping['shipping_group'];
			$provider_seq		= $order_shipping['shipping_provider_seq'];
			$shipping_method	= $order_shipping['shipping_method'];
		}

		// 주문당시 배송정보 추출
		$patten			= "/".$shipping_method."/";
		$ship_arr		= explode('_',preg_replace($patten,"",$shipping_group));
		$shipping_group_seq = $ship_arr[0];
		$shipping_set_seq	= $ship_arr[1];

		// 해당 입점사의 배송그룹 추출
		$grp_list	= $this->shippingmodel->get_shipping_group_simple($provider_seq);

		// 현재 선택된 그룹의 배송방법 추출
		$set_list = $this->shipping_set_ajax($shipping_group_seq, 'array');
		if(!$set_list){
			$set_list = $this->shipping_set_ajax($grp_list[0]['shipping_group_seq'], 'array');
		}

		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign("grp_list",$grp_list);
		$this->template->assign("set_list",$set_list);
		$this->template->assign("sel_group_seq",$shipping_group_seq);
		$this->template->assign("sel_set_seq",$shipping_set_seq);

		$this->template->assign("identity_seq",$_GET['identity_seq']);
		$this->template->assign("p_type",$_GET['p_type']);
		$this->template->assign("process",$_GET['process']);
		$this->template->print_("tpl");
	}

	// 배송그룹 추출 :: 2016-11-21 lwh
	public function shipping_grp_ajax($returnType = 'json'){
		$this->load->model('shippingmodel');
		$provider_seq = ($provider_seq) ? $provider_seq : $_GET['provider_seq'];

		// 현재 선택된 그룹의 배송방법 추출
		$grp_list	= $this->shippingmodel->get_shipping_group_simple($provider_seq);

		if($returnType == 'json')	echo json_encode($grp_list);
		else						return $grp_list;
	}

	// 배송방법 추출 :: 2016-09-29 lwh
	public function shipping_set_ajax($sel_grp_seq = '', $returnType = 'json'){
		$this->load->model('shippingmodel');
		$shipping_group_seq = ($sel_grp_seq) ? $sel_grp_seq : $_GET['sel_grp_seq'];

		// 현재 선택된 그룹의 배송방법 추출
		$set_arr	= $this->shippingmodel->get_shipping_set($shipping_group_seq);
		foreach($set_arr as $k => $set_info){
			$set_info['set_code_name'] = $this->shippingmodel->ship_set_code[$set_info['shipping_set_code']];
			$set_info['del_nation_name'] = ($set_info['delivery_nation'] == 'korea') ? '대한민국' : '해외국가';
			$set_info['select_option_html'] = $set_info['shipping_set_name'] . ' (' . $set_info['del_nation_name'] . ' - ' . $set_info['set_code_name'] . ')';

			$set_list[] = $set_info;
		}

		if($returnType == 'json')	echo json_encode($set_list);
		else						return $set_list;
	}

	// 매장수령 리스트 추출 :: 2016-10-05 lwh
	public function shipping_store_ajax($set_seq=''){
		$this->load->model('shippingmodel');

		$set_seq	= ($set_seq) ? $set_seq : $_GET['set_seq'];
		$store_list	= $this->shippingmodel->get_shipping_store($set_seq,'shipping_set_seq');

		echo json_encode($store_list);
	}

	// 회원등급 설정
	public function groupsale_choice(){
		$this->load->model('membergroupmodel');
		$group_sale_lists = $this->membergroupmodel->get_group_sale('all', $_GET['goods_seq'], $_GET['category_code']);

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign(array('group_sale_lists'=>$group_sale_lists));
		$this->template->print_("tpl");
	}
}

/* End of file coupon.php */
/* Location: ./app/controllers/admin/coupon.php */