<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/crm_base".EXT);

class member extends crm_base {

	public function __construct() {
		parent::__construct();
		$this->load->helper('member');
		$this->load->library('validation');
		$this->template->assign('mname',$this->managerInfo['mname']);

		// 보안키 입력창
		$member_download_info = $this->skin.'/member/member_download_info.html';
		$this->template->define(array("member_download_info"=>$member_download_info));

	}

	public function main_index()
	{
		redirect("/admincrm/member/activity");
	}

	// 메인화면
	public function activity()
	{
		$this->admin_menu();
		$this->tempate_modules();

		$file_path	= $this->template_path();


		$data = $this->mdata;
		/* SQL INJECTION 이 발생할 여지가 있을 수 있으므로 member_seq 를 escape 처리하도록 함 */
		$data["member_seq"] = $this->db->escape_str($data["member_seq"]);

		if($data['sns_f']) {//facebook 전용인경우
			foreach($snslist['result'] as $snslist){
				if( $snslist['sns_f'] == $data['sns_f'] ) {
					$snsmb['sns'] = $snslist;
					break;
				}
			}
			if($snsmb) $this->template->assign($snsmb);

			$data['totalinviteck'] = $data['member_invite_cnt'];// 추천회원수

			$fquery = $this->db->query("select count(member_seq) as total from fm_member WHERE fb_invite = '".$data['member_seq']."' and status != 'withdrawal' ");
			$snsftotal = $fquery->row_array();
			$data['totalinvitejoin'] = $snsftotal['total'];//초대후 회원가입된 회원수
		}

		//추천회원정보
		if($data['fb_invite']){
			$fb_invitequery = $this->db->query("select userid from fm_member WHERE member_seq = '".$data['fb_invite']."' and status != 'withdrawal' ");
			$fb_invite = $fb_invitequery->row_array();
			$data['fb_invite_id'] = $fb_invite['userid'];
		}
		$this->load->model("goodsmodel");
		$today_views = json_decode($this->mdata['today_view']);
		if($today_views){
			$todayResult = $this->goodsmodel->get_goods_list($today_views,'thumbScroll', 50);
		}
		$this->template->assign("todayResult", $todayResult);

		$data['totalrecommend'] = $data['member_recommend_cnt'];// 추천회원수

		// 성인인증정보 :: 2015-03-18 lwh
		$adult_query		= $this->db->query("select * from fm_adult_log WHERE member_seq = '".$data['member_seq']."' order by regist_date limit 10");
		$adult_info['res']	= $adult_query->result_array();
		$adult_info['cnt']	= count($adult_info['res']);
		$adult_info['lst']	= $adult_info['res'][$adult_info['cnt']-1]['regist_date'];
		$data['adult_info']	= $adult_info;

		$this->template->assign($data);

		$sql = "select count(*) as cnt from fm_cart where distribution = 'cart' and member_seq = '".$data['member_seq']."'";
		$query = $this->db->query($sql);
		$result = $query->row_array();
		$this->template->assign("cartCount", $result['cnt']);

		$sql = "select count(*) as cnt from fm_goods_wish where member_seq = '".$data['member_seq']."'";
		$query = $this->db->query($sql);
		$result = $query->row_array();
		$this->template->assign("wishCount", $result['cnt']);

		$sql = "select count(*) as cnt from fm_goods_restock_notify where member_seq = '".$data['member_seq']."' ";
		$query = $this->db->query($sql);
		$result = $query->row_array();
		$this->template->assign("restockCount", $result['cnt']);

		$sql = "select count(*) as cnt from fm_goods_fblike where member_seq = '".$data['member_seq']."'";
		$query = $this->db->query($sql);
		$result = $query->row_array();
		$this->template->assign("likeCount", $result['cnt']);

		$sql = "select count(*) as cnt from fm_search_stats where userid = '".$data['userid']."'";
		$query = $this->db->query($sql);
		$result = $query->row_array();
		$this->template->assign("searchCount", $result['cnt']);

		$sql = "select count(*) as cnt from fm_download_promotion where use_status = 'unused' and issue_enddate >= '".date("Y-m-d")."' and member_seq = '".$_SESSION['member_seq']."'";
		$query = $this->db->query($sql);
		$result = $query->row_array();
		$this->template->assign('activityPromotionCount',$result['cnt']);


		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function emoney_list()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		// Relected XSS 검증
		xss_clean_filter();

		/* SQL INJECTION 이 발생할 여지가 있을 수 있으므로 member_seq 를 escape 처리하도록 함 */
		$member_seq = $this->db->escape_str($_SESSION['member_seq']);

		###
		$sc = $this->input->get();
		$sc['page'] = (isset($sc['page'])) ? intval($sc['page']):'0';
		$sc['member_seq'] = $member_seq;
		$sc['perpage'] = '15';

		$this->load->model('membermodel');

		$data = $this->membermodel->emoney_list($sc);
		$aMemberData = $this->membermodel->get_member_data($member_seq);

		$sc['searchcount'] = $data['count'];
		$sc['total_page'] = ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount'] = get_rows('fm_emoney',array('member_seq'=>$member_seq));
		$idx = 0;
		foreach($data['result'] as $datarow){
			$idx++;
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;
			$datarow['mname'] = get_manager_name($datarow['manager_seq']);
			$dataloop[] = $datarow;
		}

		###
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtag($sc['searchcount'],$sc['perpage'],$this->membermodel->admin_member_url($file_path).'?', getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
		$this->template->assign('pagin',$paginlay);
		$this->template->assign('status', $aMemberData['status']);
		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function point_list()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		// Relected XSS 검증
		xss_clean_filter();

		/* SQL INJECTION 이 발생할 여지가 있을 수 있으므로 member_seq 를 escape 처리하도록 함 */
		$member_seq = $this->db->escape_str($_SESSION['member_seq']);

		###
		$sc = $this->input->get();
		$sc['page'] = (isset($sc['page'])) ? intval($sc['page']):'0';
		$sc['member_seq'] = $member_seq;
		$sc['perpage'] = '15';

		$this->load->model('membermodel');

		$data = $this->membermodel->point_list($sc);
		$dormancy = $this->membermodel->get_member_data($member_seq);

		$sc['searchcount'] = $data['count'];
		$sc['total_page'] = ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount'] = get_rows('fm_point',array('member_seq'=>$member_seq));
		$idx = 0;
		foreach($data['result'] as $datarow){
			$idx++;
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;
			$datarow['mname'] = get_manager_name($datarow['manager_seq']);
			$dataloop[] = $datarow;
		}

		###
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtag($sc['searchcount'],$sc['perpage'],$this->membermodel->admin_member_url($file_path).'?', getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
		$this->template->assign('pagin',$paginlay);
		$this->template->assign('status', $dormancy['status']);
		$reserve = config_load('reserve');
		$this->template->assign('reserveinfo',$reserve);
		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function cash_list()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		// Relected XSS 검증
		xss_clean_filter();

		/* SQL INJECTION 이 발생할 여지가 있을 수 있으므로 member_seq 를 escape 처리하도록 함 */
		$member_seq = $this->db->escape_str($_SESSION['member_seq']);

		###
		$sc = $this->input->get();
		$sc['page'] = (isset($sc['page'])) ? intval($sc['page']):'0';
		$sc['member_seq'] = $member_seq;
		$sc['perpage'] = '15';

		$this->load->model('membermodel');

		$data = $this->membermodel->cash_list($sc);

		$sc['searchcount'] = $data['count'];
		$sc['total_page'] = ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount'] = get_rows('fm_point',array('member_seq'=>$member_seq));

		$idx = 0;

		foreach($data['result'] as $datarow){
			$idx++;
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;
			$datarow['mname'] = get_manager_name($datarow['manager_seq']);
			$dataloop[] = $datarow;
		}

		###
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtag($sc['searchcount'],$sc['perpage'],$this->membermodel->admin_member_url($file_path).'?', getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
		$this->template->assign('pagin',$paginlay);

		// 예치금 사용여부 가져오기 추가 :: 2019-08-23 pjw
		$reserve = config_load('reserve');
		$this->template->assign('reserveinfo',$reserve);

		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	// 예치금 인출 추가 :: 2019-08-23 pjw
	public function cash_withdraw()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		$member_seq = $_GET['member_seq'];

		### 회원 정보 조회
		$this->load->model('membermodel');
		$data = $this->membermodel->get_member_data($member_seq);
		$this->template->assign($data);

		$send_phone = getSmsSendInfo();
		if(isset($send_phone)) $this->template->assign('send_phone',$send_phone);

		### SMS 정보 가져옴
		include_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/sms.class.php";
		$auth			= config_load('master');
		$sms_id			= $this->config_system['service']['sms_id'];
		$sms_api_key	= $auth['sms_auth'];
		$gabiaSmsApi	= new gabiaSmsApi($sms_id,$sms_api_key);
		$params			= "sms_id=" . $sms_id . '&sms_pw=' . md5($sms_id);
		$params			= makeEncriptParam($params);
		$limit			= $gabiaSmsApi->getSmsCount();
		$this->template->assign('count',$limit);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}


	//관리자 > 회원 쿠폰 보유/다운가능내역
	public function member_coupon_list(){

		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$this->load->model('ordermodel');
		$this->load->model('goodsmodel');
		$this->load->model('categorymodel');
		$this->load->model('promotionmodel');
		$this->load->model('membermodel');

		/* SQL INJECTION 이 발생할 여지가 있을 수 있으므로 member_seq 를 escape 처리하도록 함 */
		$member_seq = $this->db->escape_str($_SESSION['member_seq']);

		$this->mdata = $this->membermodel->get_member_data($member_seq);//회원정보

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
			$fm_member_group_logsql = "select * from fm_member_group_log where member_seq = '".$this->db->escape_str($this->mdata['member_seq'])."' order by regist_date desc limit 0,1";
			$fm_member_group_logquery = $this->db->query($fm_member_group_logsql);
			$fm_member_group_log =  $fm_member_group_logquery->row_array();
			if( ($mb_group_sort[$fm_member_group_log['prev_group_seq']] >= $mb_group_sort[$fm_member_group_log['chg_group_seq']]) || ($this->mdata['group_seq'] == 1) ) {
				$this->mdata['grade_update_date'] = '';
			}
		}else{
			$this->mdata['grade_update_date'] = substr($this->mdata['regist_date'],0,10);
		}

		$_GET['perpage'] = 15;

		if($_GET['tab'] != 3){
			## 쿠폰 다운내역/다운가능내역
			$this->load->helper('coupon');

			// 마이페이지 - 쿠폰 목록 처리
			$this->load->library('o2o/o2oinitlibrary');
			$this->o2oinitlibrary->checkO2OCouponFilter = false;

			down_coupon_list('admin', $sc , $dataloop);

			$paginlay = pagingtagfront($sc['searchcount'],$sc['perpage'],'?tab='.$_GET['tab'], getLinkFilter('',array_keys($sc)) );
			if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
			$this->template->assign('pagin',$paginlay);
		}else{
			unset($sc);
			$sparams = ($_POST) ? $_POST : $_GET;
			## SEARCH
			$sc['search_text']	= ($sc['search_text'] == '아이디, 이름') ? '':$sc['search_text'];
			$sc['orderby']		= (!empty($sparams['orderby'])) ? $sparams['orderby']:'download_seq';
			$sc['sort']			= (!empty($sparams['sort'])) ? $sparams['sort']:'desc';
			$sc['perpage']		= (!empty($sparams['perpage'])) ? intval($sparams['perpage']):10;
			$sc['page']			= (!empty($sparams['page'])) ? $sparams['page'] : 0;
			$sc['member_seq'] 	= $member_seq;
			$sc['tab'] 			= 3;
			$sc['today']		= date('Y-m-d H:i:s');
			$sc['year']			= date('Y',time());
			$sc['month']		= date('Y-m',time());
			$sc['use_status']	= 'unused';
			$sc['issue_enddate'] = date("Y-m-d");

			$data = $this->promotionmodel->download_list($sc);
			foreach($data['record'] as $datarow){
				$datarow['number']	= $datarow['_no'];
				## 기존 모바일쿠폰제외
				if( $datarow['type'] == 'mobile' && $datarow['sale_agent'] != 'm' ){
					$datarow['sale_agent']	= 'm'; // 사용환경 모바일로 대체
				}
				$datarow = downloadlist_tab1($today, $datarow, $coupons);
				$dataloop[] = $datarow;
			}
			$sc['searchcount'] = $data['searchcount'];
			$file_path = "default/member/member_promotion_list.html";
			$this->template->assign('page',$data['page']);
		}

		$svcount = $this->couponmodel->get_download_have_total_count($sc,$this->mdata);
		$this->template->assign($svcount);

		if(isset($dataloop)) $this->template->assign('loop',$dataloop);
		$this->template->assign('perpage',$sc['perpage']);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function log_memo(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$this->template->assign($this->mdata);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	### 회원리스트
	public function catalog()
	{
		$aGetParams = $this->input->get();

		// validation
		if ($aGetParams) {
			$this->validation->set_data($aGetParams);
			$this->validation->set_rules('keyword', '검색어', 'trim|string|xss_clean');
			$this->validation->set_rules('header_search_keyword', '검색어', 'trim|string|xss_clean');
			$this->validation->set_rules('body_crm_search_keyword', '검색어', 'trim|string|xss_clean');
			$this->validation->set_rules('perpage', '페이지갯수', 'trim|numeric|xss_clean');
			$this->validation->set_rules('page', '페이지', 'trim|numeric|xss_clean');
			$this->validation->set_rules('sort', '정렬', 'trim|string|xss_clean');
			$this->validation->set_rules('sitetype', '유입', 'trim|string|xss_clean');
			$this->validation->set_rules('snsrute[]', 'sns', 'trim|string|xss_clean');
			if ($this->validation->exec() === false) {
				show_error($this->validation->error_array['value']);
			}
		}

		$this->load->model('snsmember');
		$this->load->model('membermodel');
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		// 개인 정보 조회 로그
		// $type,$manager_seq,$type_seq
		$this->load->model('logPersonalInformation');
		$this->logPersonalInformation->insert('memberlist',$this->managerInfo['manager_seq'],'');

		for ($m=1;$m<=12;$m++){	$m_arr[] = str_pad($m, 2, '0', STR_PAD_LEFT); }
		for ($d=1;$d<=31;$d++){	$d_arr[] = str_pad($d, 2, '0', STR_PAD_LEFT); }
		$this->template->assign('m_arr',$m_arr);
		$this->template->assign('d_arr',$d_arr);

		#### AUTH
		$auth_act		= $this->authmodel->manager_limit_act('member_act');
		if(isset($auth_act)) $this->template->assign('auth_act',$auth_act);
		$auth_promotion = $this->authmodel->manager_limit_act('member_promotion');
		if(isset($auth_promotion)) $this->template->assign('auth_promotion',$auth_promotion);
		$auth_send	= $this->authmodel->manager_limit_act('member_send');
		if(isset($auth_send)) $this->template->assign('auth_send',$auth_send);

		// 회원정보다운로드 체크
		$auth_member_down	= $this->authmodel->manager_limit_act('member_download');
		if( !$this->isplusfreenot ){ //무료몰인경우 다운권한 없음
			$auth_member_down = false;
		}
		if(isset($auth_member_down)) $this->template->assign('auth_member_down',$auth_member_down);

		###
		if($_GET['header_search_keyword']) $_GET['keyword'] = $_GET['header_search_keyword'];
		if($_GET['body_crm_search_keyword']) $_GET['keyword'] = $_GET['body_crm_search_keyword'];

		### GROUP
		$group_arr = $this->membermodel->find_group_list();

		### SEARCH
		//print_r($_POST);
		$sc = $_GET;
		$sc['orderby']			= (isset($_GET['orderby'])) ?	$_GET['orderby']:'A.member_seq';
		$sc['sort']				= (isset($_GET['sort'])) ?		$_GET['sort']:'desc';
		$sc['page']				= (isset($_GET['page'])) ?		intval($_GET['page']):0;
		$sc['perpage']			= (isset($_GET['perpage'])) ?	intval($_GET['perpage']):10;


		// 판매환경
		if( $_GET['sitetype'] ){
			$sc['sitetype'] = implode('\',\'',$_GET['sitetype']);
		}

		// 가입양식	if( $_GET['rute'] )$sc['rute'] = implode('\',\'',$_GET['rute']);
 		if( $_GET['snsrute'] ) {
			foreach($_GET['snsrute'] as $key=>$val){$sc[$val] = 1;}
		}


		### MEMBER
		unset($sc['member_seq']);
		$data = $this->membermodel->admin_member_list($sc);

		### PAGE & DATA
		$sc['searchcount']	 = $data['count'];
		$sc['total_page']	 = ceil($sc['searchcount']	 / $sc['perpage']);
		$cntquery = $this->db->query("select count(*) as cnt from fm_member where status in ('done','hold','dormancy')");
		$cntrow = $cntquery->result_array();
		$sc['totalcount'] = $cntrow[0]['cnt'];

		$idx = 0;
		$this->load->model('Goodsreview','Boardmodel');//리뷰건
		foreach($data['result'] as $datarow){
			$idx++;
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;

			$adddata = $this->membermodel->get_member_seq_only($datarow['member_seq']);
			$datarow['email'] = $adddata['email'];
			$datarow['phone'] = $adddata['phone'];
			$datarow['cellphone'] = $adddata['cellphone'];
			$datarow['group_name'] = $adddata['group_name'];

			$datarow['type']	= $datarow['business_seq'] ? '기업' : '개인';

			if($datarow['business_seq']){
				$datarow['user_name'] = $datarow['bname'];
				$datarow['cellphone'] = $datarow['bcellphone'];
				$datarow['phone'] = $datarow['bphone'];
			}
			###
			//$temp_arr	= $this->membermodel->get_order_count($datarow['member_seq']);
			//$datarow['member_order_cnt']	= $temp_arr['cnt'];

			//리뷰건
			$sc['whereis'] = ' and mseq='.$datarow['member_seq'];
			$sc['select'] = ' count(gid) as cnt ';
			$gdreviewquery = $this->Boardmodel->get_data($sc);
			$datarow['gdreview_sum'] = $gdreviewquery['cnt'];

			if($datarow['rute'] != "none" ) {
				$snsmbsc['select'] = ' * ';
				$snsmbsc['whereis'] = ' and member_seq = \''.$datarow['member_seq'].'\' ';
				$snslist = $this->snsmember->snsmb_list($snsmbsc);
				if($snslist['result'][0]) $datarow['snslist'] = $snslist['result'];
			}

			/****/

			$dataloop[] = $datarow;
		}

		## 유입경로 그룹
		$this->load->model('statsmodel');
		$referer_list	= $this->statsmodel->get_referer_grouplist();
		$this->template->assign('referer_list',$referer_list);


		###
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtag($sc['searchcount'],$sc['perpage'],'javascript:searchPaging(\'',getLinkFilter('',array_keys(array())).'\');' );

		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';

		//가입환경
		$sitetypeloop = sitetype($_GET['sitetype'], 'image', 'array');
		$this->template->assign('sitetypeloop',$sitetypeloop);

		//가입양식
		$ruteloop = memberrute($_GET['rute'], 'image', 'array');
        $this->template->assign('ruteloop',$ruteloop);

        //manager log
        $this->searchcount = $sc['searchcount'];

		$this->template->assign('pagin',$paginlay);
		$this->template->assign('group_arr',$group_arr);
		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);

		$this->template->assign('query_string', get_query_string());

		$this->template->define('member_list',$this->skin.'/member/member_list.html');
		$this->template->define('member_search',$this->skin.'/member/member_search.html');
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}



	### 회원상세
	public function detail()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		#### AUTH
		$auth_act		= $this->authmodel->manager_limit_act('member_act');
		if(isset($auth_act)) $this->template->assign('auth_act',$auth_act);
		$auth_promotion = $this->authmodel->manager_limit_act('member_promotion');
		if(isset($auth_promotion)) $this->template->assign('auth_promotion',$auth_promotion);
		$auth_send	= $this->authmodel->manager_limit_act('member_send');
		if(isset($auth_send)) $this->template->assign('auth_send',$auth_send);
		$_GET['member_seq'] = $this->mdata['member_seq'];

		// 개인정보 조회 로그
		//'member', 'memberlist', 'order', 'export', 'return', 'refund', 'orderexcel', 'exportexcel'
		$this->load->model('logPersonalInformation');
		$this->logPersonalInformation->insert('member',$this->managerInfo['manager_seq'],$_GET['member_seq']);

		###
		$this->load->model('membermodel');
		$data = $this->membermodel->get_member_data($_GET['member_seq']);

		// 회원 이름명 OR 업체명 20자 제한
		$data['user_name'] = check_member_name($data['user_name']);
		$data['bname'] = check_member_name($data['bname']);

		// 만 14세 승인 여부 데이터
		$data['kid_auth'] = $data['kid_auth'];

		if($data['auth_type']=='auth'){
			$data['auth_type'] = "실명인증";
		}else if($data['auth_type']=='ipin'){
			$data['auth_type'] = "아이핀";
		}else{
			$data['auth_type'] = "없음";
		}

		$data['zip_arr'] = explode("-",$data['zipcode']);
		$data['bzip_arr'] = explode("-",$data['bzipcode']);

		/*
		 * 코드별 출력 내용(KR ORI)
		 * mp292: 배송 주문 불만족
		 * mp293: 사이트 이용 불편
		 * mp294: 상품품질 불만족
		 * mp295: 서비스 불만족
		 * mp291: 기타 / 기타 항목 마지막에 표시
		 */
		$withdrawal = array(getAlert('mp292'),getAlert('mp293'),getAlert('mp294'),getAlert('mp295'),getAlert('mp291'));
		$this->template->assign('withdrawal_arr',$withdrawal);

		$joinform = ($this->joinform)?$this->joinform:config_load('joinform');
		if($joinform) $this->template->assign('joinform',$joinform);
		$this->template->assign('memberIcondata',memberIconConf());

		//가입 추가 정보 리스트
		//$mdata = $this->mdata;
		$qry = "select * from fm_joinform where used='Y' order by sort_seq";
		$query = $this->db->query($qry);
		$form_arr = $query -> result_array();
		foreach ($form_arr as $k => $subdata){
		$msubdata=$this->membermodel->get_subinfo($data['member_seq'],$subdata['joinform_seq']);
		$subdata['label_view'] = $this -> membermodel-> get_labelitem_type($subdata,$msubdata);
		$sub_form[] = $subdata;
		}
		$this->template->assign('form_sub',$sub_form);

		###
		$grade_list = $this->membermodel->find_group_list();
		$grade_list = array_reverse($grade_list);
		$this->template->assign('grade_list',$grade_list);
		//print_r($grade_list);

		//1:1문의건
		$this->load->model('Boardmodel');
		$sc['whereis'] = " and boardid = 'mbqna'   and mseq='".$data['member_seq']."'";
		$sc['select'] = " count(gid) as cnt ";
		$mbqnaquery = $this->Boardmodel->get_data($sc);
		$data['mbqna_sum'] = $mbqnaquery['cnt'];

		$sc['whereis'] = " and re_contents!='' and boardid = 'mbqna'  and mseq='".$data['member_seq']."'";
		$sc['select'] = " count(gid) as cnt ";
		$mbqnareplyquery = $this->Boardmodel->get_data($sc);
		$data['mbqna_reply'] = $mbqnareplyquery['cnt'];//답변완료수 / 전체질문수

		//리뷰건
		$this->load->model('goodsreview');
		$sc['whereis'] = " and mseq='".$data['member_seq']."'";
		$sc['select'] = " count(gid) as cnt ";
		$gdreviewquery = $this->goodsreview->get_data($sc);
		$data['gdreview_sum'] = $gdreviewquery['cnt'];

		//상품문의건
		$this->load->model('goodsqna');
		$sc['whereis'] = "and mseq= ?";
		$bindData[] = $data['member_seq'];
		$sc['select'] = " count(gid) as cnt ";
		$gdqnaquery = $this->goodsqna->get_data($sc, $bindData);
		$data['gdqna_sum'] = $gdqnaquery['cnt'];

		//쿠폰보유건 test
		$this->load->model('couponmodel');
		$this->load->helper('coupon');
		down_coupon_list('admin', $sc , $dataloop);

		$svcount = $this->couponmodel->get_download_have_total_count($sc,$data);
		$this->template->assign($svcount);

		$this->load->model('snsmember');


		$snsmbsc['select'] = " * ";
		$snsmbsc['whereis'] = " and member_seq ='".$data['member_seq']."' ";
		$snslist = $this->snsmember->snsmb_list($snsmbsc);
		if($snslist['result'][0]) $data['snslist'] = $snslist['result'];

		if($data['sns_f']) {//facebook 전용인경우
			foreach($snslist['result'] as $snslist){
				if( $snslist['sns_f'] == $data['sns_f'] ) {
					$snsmb['sns'] = $snslist;
					break;
				}
			}
			if($snsmb) $this->template->assign($snsmb);

			$data['totalinviteck'] = $data['member_invite_cnt'];// 추천회원수

			//$fquery = $this->db->query("select count(A.member_seq) as total from fm_memberinvite A LEFT JOIN fm_member B ON A.member_seq = B.member_seq WHERE B.fb_invite = '".$data['member_seq']."' and B.status = 'done' ");
			$fquery = $this->db->query("select count(member_seq) as total from fm_member WHERE fb_invite = '".$data['member_seq']."' and status != 'withdrawal' ");
			$snsftotal = $fquery->row_array();
			$data['totalinvitejoin'] = $snsftotal['total'];//초대후 회원가입된 회원수
		}

		//추천회원정보
		if($data['fb_invite']){
			$fb_invitequery = $this->db->query("select userid from fm_member WHERE member_seq = '".$data['fb_invite']."' and status != 'withdrawal' ");
			$fb_invite = $fb_invitequery->row_array();
			$data['fb_invite_id'] = $fb_invite['userid'];
		}


		$data['totalrecommend'] = $data['member_recommend_cnt'];// 추천회원수

		// 성인인증정보 :: 2015-03-18 lwh
		$adult_query		= $this->db->query("select * from fm_adult_log WHERE member_seq = '".$data['member_seq']."' order by regist_date limit 10");
		$adult_info['res']	= $adult_query->result_array();
		$adult_info['cnt']	= count($adult_info['res']);
		$adult_info['lst']	= $adult_info['res'][$adult_info['cnt']-1]['regist_date'];
		$data['adult_info']	= $adult_info;


		// 회원 처리주문 요약 :: 2015-03-24 lwh
		$orderSummary	= array();
		$step_arr		= array('15'=>'주문접수', '25'=>'결제확인', '35'=>'상품준비', '40'=>'부분출고준비', '45'=>'출고준비', '50'=>'부분출고완료', '55'=>'출고완료', '60'=>'부분배송중', '65'=>'배송중', '70'=>'부분배송완료');

		/*$date_range	= " and b.regist_date between '"
					. date('Y-m-d', strtotime('-100 day'))." 00:00:00' "
					. " and '".date('Y-m-d')." 23:59:59' ";*/
		$sql	= "
				SELECT count(*) as cnt , step
				FROM fm_order as b
				WHERE hidden = 'N'
				and member_seq = '".$data['member_seq']."'
				".$date_range."
				GROUP BY step
				";
		$query	= $this->db->query($sql);
		foreach ($query->result_array() as $row){
			$result[$row['step']]	= $row['cnt'];
		}

		foreach ($step_arr as $key => $val){
			$orderSummary[$key] = array(
			'count'			=> ($result[$key]) ? $result[$key] : 0,
			'name'			=> $val,
			'link'			=> "../order/catalog?chk_step[".$key."]=1&keyword=".$data['userid']
			);

			if($key == '45' || $key == '55' || $key == '65'){
				$orderSummary[$key]['link_export'] = "../export/catalog?export_status[".$key."]=1&keyword=".$data['userid'];
			}
		}

		/* 반품 접수 */
		$query = $this->db->query("select count(*) as cnt from fm_order_return as b left join fm_order as o on b.order_seq = o.order_seq where b.status = 'request' and o.member_seq = '".$data['member_seq']."' ".$date_range);
		$result = $query->row_array();
		$orderSummary['101'] = array(
			'count'		=> ($result['cnt']) ? $result['cnt'] : 0,
			'name'		=> '반품접수',
			'link'		=> '../returns/catalog?return_status[]=request&keyword='.$data['userid']
		);

		/* 환불 접수 */
		$query = $this->db->query("select count(*) as cnt from fm_order_refund as b left join fm_order as o on b.order_seq = o.order_seq where b.status = 'request' and o.member_seq = '".$data['member_seq']."' ".$date_range);
		$result = $query->row_array();
		$orderSummary['102'] = array(
			'count'		=> ($result['cnt']) ? $result['cnt'] : 0,
			'name'		=> '환불접수',
			'link'		=> '../refund/catalog?refund_status[]=request&keyword='.$data['userid']
		);

		// 회원 처리주문 요약 :: END

		for ($m=1;$m<=12;$m++){	$m_arr[] = str_pad($m, 2, '0', STR_PAD_LEFT); }
		for ($d=1;$d<=31;$d++){	$d_arr[] = str_pad($d, 2, '0', STR_PAD_LEFT); }
		$this->template->assign('m_arr',$m_arr);
		$this->template->assign('d_arr',$d_arr);
		$this->template->assign('query_string',$_GET['query_string']);
		$data['marketing_agree_send_date'] = substr($data['marketing_agree_send_date'],0, 10);
		$data['update_date'] = substr($data['update_date'],0, 10);

		$this->template->assign($data);
		$this->template->assign(array('orderSummary'=>$orderSummary));
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function today_goods_view(){

		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$this->load->model("goodsmodel");
		$today_views = json_decode($this->mdata['today_view']);
		if($today_views){
			$todayResult = $this->goodsmodel->get_goods_list($today_views,'thumbScroll', 50);
		}
		$this->template->assign("todayResult", $todayResult);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function wish_goods_view(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$this->load->model("wishmodel");
		$wishImageSize	= 'thumbScroll';
		$result = $this->wishmodel->get_list( $this->mdata['member_seq'],$wishImageSize, 50 );


		$this->template->assign("wishResult", $result['record']);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function cart_goods_view(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$query = "
		SELECT cart.cart_seq,cart.fblike,
		goods.goods_seq,goods.goods_name,goods.goods_code,goods.cancel_type,goods.goods_kind,goods.sale_seq,
		goods.shipping_weight_policy,goods.goods_weight,
		goods.shipping_policy,goods.goods_shipping_policy,
		goods.unlimit_shipping_price,goods.limit_shipping_price,
		goods.limit_shipping_ea,goods.limit_shipping_subprice,
		(select image from fm_goods_image where cut_number = 1 AND image_type = 'thumbCart' AND cart.goods_seq = goods_seq limit 1) as image,
		(
			SELECT sum(ea)
			FROM fm_cart_suboption
			WHERE cart_seq=cart.cart_seq
		) sub_ea,
		sum(cart_opt.ea) ea,
		(
			SELECT COUNT(cart_suboption_seq)
			FROM fm_cart_suboption
			WHERE cart_seq=cart.cart_seq
		) sub_cnt,
		(
			SELECT SUM(g.price*s.ea)
			FROM fm_goods_suboption g,fm_cart_suboption s
			WHERE g.goods_seq=cart.goods_seq
			AND g.suboption=s.suboption
			AND g.suboption_title=s.suboption_title
			AND s.cart_seq=cart.cart_seq
		) sub_price,
		(
			SELECT SUM(g.reserve*s.ea)
			FROM fm_goods_suboption g,fm_cart_suboption s
			WHERE g.goods_seq=cart.goods_seq
			AND g.suboption=s.suboption
			AND g.suboption_title=s.suboption_title
			AND s.cart_seq=cart.cart_seq
		) sub_reserve,
		goods_opt.price,
		goods_opt.consumer_price,
		goods_opt.reserve_unit as reserve_unit,
		SUM(IF(cart_opt.option1!='',1,0)) opt_cnt,
		SUM(goods_opt.reserve*cart_opt.ea) reserve,
		goods.reserve_policy,
		goods.multi_discount_use,
		goods.multi_discount_ea,
		goods.multi_discount,
		goods.multi_discount_unit,
		goods.tax,
		goods.social_goods_group,
		goods.socialcp_input_type,goods.socialcp_cancel_type,
		goods.socialcp_cancel_use_refund,goods.socialcp_cancel_payoption,goods.socialcp_cancel_payoption_percent,
		goods.socialcp_use_return,goods.socialcp_use_emoney_day,goods.socialcp_use_emoney_percent,
		goods.individual_refund,
		goods.individual_refund_inherit,
		goods.individual_export,
		goods.individual_return
		FROM fm_cart cart
		,fm_goods goods
		,fm_cart_option cart_opt
		,fm_goods_option goods_opt
		WHERE cart.distribution='cart'
		AND cart.goods_seq = goods.goods_seq
		AND goods.goods_status = 'normal'
		AND cart.cart_seq = cart_opt.cart_seq
		AND cart.goods_seq = goods_opt.goods_seq
		AND ifnull(cart_opt.option1,'') = ifnull(goods_opt.option1,'')
		AND ifnull(cart_opt.option2,'') = ifnull(goods_opt.option2,'')
		AND ifnull(cart_opt.option3,'') = ifnull(goods_opt.option3,'')
		AND ifnull(cart_opt.option4,'') = ifnull(goods_opt.option4,'')
		AND ifnull(cart_opt.option5,'') = ifnull(goods_opt.option5,'')
		and cart.member_seq ='".$this->mdata['member_seq']."'
		";

		$query .= " GROUP BY cart.cart_seq ORDER BY cart.cart_seq DESC LIMIT 50";
		$query = $this->db->query($query);
		$shipping_price['goods'] = 0;
		$shipping_exempt = 0;
		$promocodeSale = 0;
		$cart_items = $query->result_array();

		$this->template->assign("cartResult", $cart_items);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function restock_goods_view(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$this->load->model("goodsmodel");
		### SEARCH
		$_GET['orderby'] = ($_GET['orderby']) ? $_GET['orderby']:'restock_notify_seq';
		$_GET['sort']	 = ($_GET['sort']) ? $_GET['sort']:'desc';
		$_GET['page']	 = ($_GET['page']) ? intval($_GET['page']):'1';
		$_GET['perpage'] = ($_GET['perpage']) ? intval($_GET['perpage']):'50';
		$sc = $_GET;
		$sc['member_seq'] = $this->mdata['member_seq'];
		### LIST
		$loop = $this->goodsmodel->restock_notify_list($sc);

		$this->template->assign("restockResult", $loop['record']);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function fblike_goods_view(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$this->load->model("goodsmodel");
		### SEARCH
		$_GET['orderby'] = ($_GET['orderby']) ? $_GET['orderby']:'goods_seq';
		$_GET['sort']	 = ($_GET['sort']) ? $_GET['sort']:'desc';
		$_GET['page']	 = ($_GET['page']) ? intval($_GET['page']):'1';
		$_GET['perpage'] = ($_GET['perpage']) ? intval($_GET['perpage']):'3';
		$sc = $_GET;
		$sc['member_seq'] = $this->mdata['member_seq'];

		$sql = "select goods_seq from fm_goods_fblike where member_seq = '".$_SESSION['member_seq']."'";
		$query = $this->db->query($sql);
		$result = $query->result_array();

		foreach($result as $likeData){
			$likeGoods[] = $likeData['goods_seq'];
		}

		$sc['fblike_goods_seq'] = join("','", $likeGoods);

		### LIST
		$loop = $this->goodsmodel->admin_goods_list($sc);

		$this->template->assign("restockResult", $loop['record']);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}
	public function search_word_view(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$sql = "select * from fm_search_stats where userid = '".$this->mdata['userid']."'";
		$query = $this->db->query($sql);
		$result = $query->result_array();


		$this->template->assign("result", $result);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function sns_detail(){

		$this->admin_menu();
		$this->tempate_modules();
		$this->load->model('snsmember');
		$file_path	= $this->template_path();
		$this->template->assign('member_seq',$_GET['member_seq']);
		$this->template->assign('snscd',$_GET['snscd']);
		$this->template->assign('no',$_GET['no']);

		$sql = "select rute,user_name,email
						,(case when sex='famale' then '여자' when sex='male' then '남자' else '' end) sex
						,(case when ifnull(birthday,'0000-00-00')!='0000-00-00' then birthday else '' end ) birthdayV
					from
						fm_membersns
					where
						member_seq ='".$_GET['member_seq']."' and rute='".$_GET['snscd'] ."'";
		$query	= $this->db->query($sql);
		$result = $query -> result_array();

		if(!$result[0]) $result[0]['message'] = "연동 해제된 계정입니다.";

		if($result[0]['rute'] == "facebook"){
			$sql	= "select sns_f from fm_member where member_seq='".$_GET['member_seq']."'";
			$query2	= $this->db->query($sql);
			$result2 = $query2->result_array();
			$result[0]['sns_f'] = $result2[0]['sns_f'];
		}

		$result[0]['rute_nm'] = $this->snsmember->snstype_name($_GET['snscd']);

		$this->template->assign('data',$result[0]);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}
}

/* End of file main.php */
/* Location: ./app/controllers/admin/main.php */