<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
require_once(APPPATH ."controllers/base/common_base".EXT);

class crm_base_original extends common_base {
	var $AdminMenu			= array();
	var $skin;
	var $managerInfo;
	var $auth_msg			= "권한이 없습니다.";
	var $mdata = array();

	public function __construct() {
		parent::__construct();
		checkEnvironmentValidation();
		session_start();

		/* 만기도래 체크(로그인화면 제외) */
		$file_path = $this->config_system['adminSkin']."/common/blank.html";
		$this->template->define(array('warningScript'=>$file_path));
		if(!preg_match("/^admincrm\/login(^_)*/",uri_string()) && !preg_match("/^admincrm\/main_index/",uri_string()) && uri_string()!='admincrm'){
			warningExpireDate();
		}

		define('__ADMIN__',true);//관리자페이지
		$this->template->assign(array('ADMIN'=>__ADMIN__));
		$this->skin = $this->config_system['crmSkin'];

		### MANAGER SESSION
		$this->managerInfo = $this->session->userdata('manager');
		$this->template->assign(array('managerInfo' => $this->managerInfo));

		### 관리자 접속IP 체크
		$this->load->model('protectip');
		$this->protectip->protect_ip_admincrm($this->managerInfo['manager_seq']);

		$this->load->model('authmodel');

		if (! isset($this->managerInfo['manager_seq']) ) {
			if( !strpos($this->template_path(),'login') && !strpos($this->template_path(),'logout')){
				if((stristr($this->template_path(),'get_blacklist'))){
					//블랙리스트
				}else{
					if($_SERVER['REQUEST_METHOD']=='GET'){
						redirect("/admincrm/login/index?return_url=".urlencode($_SERVER['REQUEST_URI']));
						exit;
					}else{
						redirect("/admincrm/login/index");
						exit;
					}
				}
			}
		} else {
			if( !strpos($this->template_path(),'get_blacklist') ){
				$result = $this->authmodel->manager_limit_view($this->template_path());
				//echo $result." : ".$this->template_path();
				if(!$result){
					pageBack("권한이 없습니다.");
				}
			}
		}
		
		/*
		$this->db->where('manager_seq', $this->managerInfo['manager_seq']);
		$query = $this->db->get('fm_manager');
		$data = $query->result_array();

		$auth_arr = explode("||",$data[0]['manager_auth']);
		foreach($auth_arr as $k){
			$tmp_arr = explode("=",$k);
			$auth[$tmp_arr[0]] = $tmp_arr[1];
		}구버전의 로직이 그대로 있어서 주석 처리
		*/
		
		//18-04-25 gcns jhs add
		$auth['order_view'] = $this->authmodel->manager_limit_act('order_view');
		$auth['member_view'] = $this->authmodel->manager_limit_act('member_view');

		if($auth['order_view'] == "Y") $orderSearchYn = "Y";
		if($this->managerInfo['manager_yn']=='Y') $orderSearchYn = "Y";
		$this->template->assign('orderSearchYn',$orderSearchYn);

		if($auth['member_view'] == "Y") $memberSearchYn = "Y";
		if($this->managerInfo['manager_yn']=='Y') $memberSearchYn = "Y";
		$this->template->assign('memberSearchYn',$memberSearchYn);



		/* 사용 도메인 정의 */
		$host = $_SERVER['HTTP_HOST'];
		$host = preg_replace('/^m\./','', $host);
		$this->pcDomain = $host;
		$this->template->assign('pcDomain',$this->pcDomain);
		if($this->config_system['operation_type'] == 'light')	$this->mobileDomain = $host;
		else													$this->mobileDomain = "m.".preg_replace("/^www\./","",$host);
		$this->template->assign('mobileDomain',$this->mobileDomain);

		if( serviceLimit('H_FRST') ){
			if(in_array($_SERVER['REQUEST_URI'],$arr_nostorfreeService_url)){
				$nostorfreeService = true;
			}
		}


		if($_GET['member_seq']){
			$_SESSION['member_seq'] = $_GET['member_seq'];
			unset($_SESSION['order_seq']);
		}else if($_GET['order_seq']){
			$_SESSION['order_seq'] = $_GET['order_seq'];
			unset($_SESSION['member_seq']);
		}else if($_SESSION['member_seq']){
			$_GET['member_seq'] = $_SESSION['member_seq'];
		}else if($_SESSION['order_seq']){
			$_GET['order_seq'] = $_SESSION['order_seq'];
		}

		if($this->mdata['blacklist'] == "blacklist"){
			if($_GET['order_seq']){
				$blSqlWhere = "where order_seq = '".$_GET['order_seq']."'";
			}else{
				$blSqlWhere = "where member_seq = '".$_GET['member_seq']."'";
			}
			$blSql = "select * from fm_member_blacklist ".$blSqlWhere."";
			$blQuery = $this->db->query($blSql);
			$blResult = $blQuery->result_array();
			$blResult['blacklist'] = "blacklist";
			$this->template->assign('blacklistInfo',$blResult);
		}

		if($_SESSION['member_seq']){
			###
			$this->load->model('membermodel');
			$this->mdata = $this->membermodel->get_member_data($_GET['member_seq']);

			if(!$this->mdata) redirect("/admincrm/main/index");
			if($this->mdata['auth_type']=='auth'){
				$this->mdata['auth_type'] = "실명인증";
				$this->mdata['auth_date'] = $this->mdata['regist_date'];
			}else if($this->mdata['auth_type']=='ipin'){
				$this->mdata['auth_type'] = "아이핀";
				$this->mdata['auth_date'] = $this->mdata['regist_date'];
			}else if($this->mdata['auth_type']=='phone') {
			    $this->mdata['auth_type'] = "휴대폰인증";
			    $this->mdata['auth_date'] = $this->mdata['regist_date'];
			} else{
				$this->mdata['auth_type'] = "없음";
				$this->mdata['auth_date'] = "";
			}


			if($this->mdata['user_name']){
				$this->template->assign('leftUserName',$this->mdata['user_name']);
			}else{
				// 네이버일 경우 고유키를 아이디로 사용중이라면 치환
				if(isset($this->mdata['sns_n']) && $this->mdata['sns_n'] == $this->mdata['userid']){
					$this->template->assign('leftUserName',$this->mdata['conv_sns_n']);
				}else{
					$this->template->assign('leftUserName',$this->mdata['userid']);
				}
			}

			$this->template->assign('leftSnsN',$this->mdata['sns_n']);
			$this->template->assign('leftConvSnsN',$this->mdata['conv_sns_n']);
			$this->template->assign('leftUserId',$this->mdata['userid']);
			$this->template->assign('leftUserIcon',$this->mdata['icon']);
			$this->template->assign('leftStatus_nm',$this->mdata['status_nm']);
			$this->template->assign('leftUser_type',$this->mdata['mtype']);
			$this->template->assign('leftStatus',$this->mdata['status']);
			$this->template->assign('leftBusinessSeq',$this->mdata['business_seq']);

			$this->template->assign('userEmoney',$this->mdata['emoney']);
			$this->template->assign('userPoint',$this->mdata['point']);
			$this->template->assign('userCash',$this->mdata['cash']);
			$this->template->assign('mall_t_check',$this->mdata['mall_t_check']); //추가 20170602 테스트아이디 표시 LDB


			//상담분류
			$category = config_load('counsel','category');
			$this->template->assign("consel_category", $category);

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
					and member_seq = '".$this->mdata['member_seq']."'
					".$date_range."
					GROUP BY step
					";
			$query	= $this->db->query($sql);
			$orderResult = $query->result_array();
			$result = array();
			foreach ($orderResult as $row){
				$result[$row['step']]	= $row['cnt'];
			}
			foreach ($step_arr as $key => $val){

				$orderSummary[$key] = array(
				'count'			=> ($result[$key]) ? $result[$key] : 0,
				'name'			=> $val,
				'link'			=> "../order/catalog?chk_step[".$key."]=1&keyword=".$this->mdata['userid']
				);

				if($key == '45' || $key == '55' || $key == '65'){
					$orderSummary[$key]['link_export'] = "../export/catalog?export_status[".$key."]=1&keyword=".$this->mdata['userid'];
				}
			}

			$sql	= "
					SELECT count(*) as cnt
					FROM fm_order a
					WHERE a.hidden = 'N'
					and a.member_seq = '".$this->mdata['member_seq']."'
					and a.step in ('25','35','45','50','60','70')
					";
			$query	= $this->db->query($sql);
			$settleResult = $query->row_array();
			$this->template->assign('leftExportReady',$settleResult['cnt']);

			/* 반품 접수 */
			$query = $this->db->query("select count(*) as cnt from fm_order_return as b left join fm_order as o on b.order_seq = o.order_seq where b.return_type = 'return' and b.status = 'request' and o.member_seq = '".$this->mdata['member_seq']."' ".$date_range);
			$result = $query->row_array();
			$orderSummary['101'] = array(
				'count'		=> ($result['cnt']) ? $result['cnt'] : 0,
				'name'		=> '반품접수',
				'link'		=> '../returns/catalog?return_status[]=request&keyword='.$this->mdata['userid']
			);

			/* 반품 접수 */
			$query = $this->db->query("select count(*) as cnt from fm_order_return as b left join fm_order as o on b.order_seq = o.order_seq where b.return_type = 'exchange' and b.status = 'request' and o.member_seq = '".$this->mdata['member_seq']."' ".$date_range);
			$result = $query->row_array();
			$orderSummary['111'] = array(
				'count'		=> ($result['cnt']) ? $result['cnt'] : 0,
				'name'		=> '맞교환접수',
				'link'		=> '../returns/catalog?return_status[]=request&keyword='.$this->mdata['userid']
			);


			/* 환불 접수 */
			$query = $this->db->query("select count(*) as cnt from fm_order_refund as b left join fm_order as o on b.order_seq = o.order_seq where b.status = 'request' and o.member_seq = '".$this->mdata['member_seq']."' ".$date_range);
			$result = $query->row_array();
			$orderSummary['102'] = array(
				'count'		=> ($result['cnt']) ? $result['cnt'] : 0,
				'name'		=> '환불접수',
				'link'		=> '../refund/catalog?refund_status[]=request&keyword='.$this->mdata['userid']
			);

			$this->template->assign(array('orderSummary'=>$orderSummary));

			if($orderSummary[25]['count'] > 0){
				$expectationQna[] = 15;
			}

			if($orderSummary[25]['count'] > 0 || $orderSummary[25]['count'] > 0 || $orderSummary[25]['count'] > 0){
				$expectationQna[] = 25;
			}

			//1:1문의건
			$this->load->model('Boardmodel','baseBoardmodel');
			$sc['whereis'] = " and boardid = 'mbqna'   and mseq='".$this->mdata['member_seq']."'";
			$sc['select'] = " count(gid) as cnt ";
			$mbqnaquery = $this->baseBoardmodel->get_data($sc);
			$mbqna_sum = $mbqnaquery['cnt'];

			$sc['whereis'] = " and re_contents!='' and boardid = 'mbqna'  and mseq='".$this->mdata['member_seq']."'";
			$sc['select'] = " count(gid) as cnt ";
			$mbqnareplyquery = $this->baseBoardmodel->get_data($sc);
			$mbqna_reply = $mbqnareplyquery['cnt'];//답변완료수 / 전체질문수
			$this->template->assign('mbqnaCount',$mbqna_sum-$mbqna_reply);
			if($mbqna_sum-$mbqna_reply > 0) $expectationQna[] = 103;

			//리뷰건
			$this->load->model('goodsreview');
			$sc['whereis'] = " and mseq='".$this->mdata['member_seq']."'";
			$sc['select'] = " count(gid) as cnt ";
			$gdreviewquery = $this->goodsreview->get_data($sc);
			$this->template->assign('goodsreviewCount',$gdreviewquery['cnt']);

			//상품문의건
			$this->load->model('goodsqna');
			$sc['whereis'] = "and mseq= ? and (re_contents is null or re_contents = '')";
			$sc['select'] = " count(gid) as cnt ";
			$bindData = [$this->mdata['member_seq']];
			$gdqnaquery = $this->goodsqna->get_data($sc, $bindData);
			$this->template->assign('goodsqnaCount',$gdqnaquery['cnt']);
			if($gdqnaquery['cnt'] > 0) $expectationQna[] = 104;

			//쿠폰보유건 test
			$this->load->model('couponmodel');
			$this->load->helper('coupon');
			down_coupon_list('admin', $sc , $dataloop);

			$svcount = $this->couponmodel->get_download_have_total_count($sc,$this->mdata);
			$this->template->assign($svcount);

			$this->db->select('COUNT(*) AS cnt');
			$this->db->where("use_status = 'unused' and issue_enddate >= '".date("Y-m-d")."' and member_seq = '".$_SESSION['member_seq']."'");
			$result = $this->db->get("fm_download_promotion")->row_array();
			$this->template->assign('promotionCount',$result['cnt']);

			$this->template->assign('expectationQna',$expectationQna);


			$counselSql = "select count(*) as cnt from fm_counsel where member_seq = '".$this->mdata['member_seq']."' and counsel_status = 'request'";
			$counselQuery = $this->db->query($counselSql);

			$counselResult = $counselQuery->row_array();

			$this->template->assign('counselCount',$counselResult['cnt']);



		}else if($_SESSION['order_seq']){
			// 비회원 처리주문 요약 :: 2015-03-24 lwh
			$orderSummary	= array();
			$step_arr		= array('15'=>'주문접수', '25'=>'결제확인', '35'=>'상품준비', '40'=>'부분출고준비', '45'=>'출고준비', '50'=>'부분출고완료', '55'=>'출고완료', '60'=>'부분배송중', '65'=>'배송중', '70'=>'부분배송완료');

			/*$date_range	= " and b.regist_date between '"
						. date('Y-m-d', strtotime('-100 day'))." 00:00:00' "
						. " and '".date('Y-m-d')." 23:59:59' ";*/
			$sql	= "
					SELECT count(*) as cnt , step
					FROM fm_order as b
					WHERE hidden = 'N'
					and order_seq = '".$_SESSION['order_seq']."'
					".$date_range."
					GROUP BY step
					";
			$query	= $this->db->query($sql);
			$orderResult = $query->result_array();
			$result = array();
			foreach ($orderResult as $row){
				$result[$row['step']]	= $row['cnt'];
			}

			foreach ($step_arr as $key => $val){

				$orderSummary[$key] = array(
				'count'			=> ($result[$key]) ? $result[$key] : 0,
				'name'			=> $val,
				'link'			=> "../order/catalog?chk_step[".$key."]=1&keyword=".$this->mdata['userid']
				);

				if($key == '45' || $key == '55' || $key == '65'){
					$orderSummary[$key]['link_export'] = "../export/catalog?export_status[".$key."]=1&keyword=".$this->mdata['userid'];
				}
			}

			/* 반품 접수 */
			$query = $this->db->query("select count(*) as cnt from fm_order_return as b left join fm_order as o on b.order_seq = o.order_seq where b.return_type = 'return' and b.status = 'request' and o.order_seq = '".$_SESSION['order_seq']."' ".$date_range);
			$result = $query->row_array();
			$orderSummary['101'] = array(
				'count'		=> ($result['cnt']) ? $result['cnt'] : 0,
				'name'		=> '반품접수',
				'link'		=> '../returns/catalog?return_status[]=request&keyword='.$this->mdata['userid']
			);

			/* 반품 접수 */
			$query = $this->db->query("select count(*) as cnt from fm_order_return as b left join fm_order as o on b.order_seq = o.order_seq where b.return_type = 'exchange' and b.status = 'request' and o.order_seq = '".$_SESSION['order_seq']."' ".$date_range);
			$result = $query->row_array();
			$orderSummary['111'] = array(
				'count'		=> ($result['cnt']) ? $result['cnt'] : 0,
				'name'		=> '맞교환접수',
				'link'		=> '../returns/catalog?return_status[]=request&keyword='.$this->mdata['userid']
			);


			/* 환불 접수 */
			$query = $this->db->query("select count(*) as cnt from fm_order_refund as b left join fm_order as o on b.order_seq = o.order_seq where b.status = 'request' and o.order_seq = '".$_SESSION['order_seq']."' ".$date_range);
			$result = $query->row_array();
			$orderSummary['102'] = array(
				'count'		=> ($result['cnt']) ? $result['cnt'] : 0,
				'name'		=> '환불접수',
				'link'		=> '../refund/catalog?refund_status[]=request&keyword='.$this->mdata['userid']
			);

			$sql	= "
					SELECT order_user_name
					FROM fm_order as b
					WHERE hidden = 'N'
					and order_seq = '".$_SESSION['order_seq']."'
					";
			$query	= $this->db->query($sql);
			$orderInfo = $query->row_array();

			$this->template->assign('leftUserName',$orderInfo['order_user_name']);
			$this->template->assign(array('orderSummary'=>$orderSummary));


		}

		// 회원 처리주문 요약 :: END
		/* 비밀번호 체크 */
		$this->template->assign('is_change_pass_required',$this->session->userdata('is_change_pass_required'));
		$this->template->assign('is_change_pass',$this->session->userdata('is_change_pass'));

		$this->template->assign('nostorfreeService',$nostorfreeService);
		$this->template->assign(array('designWorkingSkin'=>$this->designWorkingSkin));


	}

	// 관리자 메뉴 로딩
	public function admin_menu(){
		$this->load->model("admin_menu");

		$adminMenuCurrent = $this->uri->rsegments[1];

		/* 매뉴얼 바로보기 숨김처리메뉴 추가 leewh 2014-09-17 */
		$menual_hidden = false;
		if ($adminMenuCurrent == "marketing"
			|| in_array(uri_string(),array('admin/board/board'))) {
			$menual_hidden = true;
		} else {
			if (uri_string() == "admin/setting/manager_reg") {
				$menual_url = urlencode("setting/manager");
			} else if (uri_string() == "admin/brand/batch_design_setting") {
				$menual_url = urlencode("brand/catalog");
			} else if (uri_string() == "admin/location/batch_design_setting") {
				$menual_url = urlencode("location/catalog");
			}
		}

		$this->template->assign(array(
			'adminMenu' => $this->admin_menu->arr_menu,
			'adminMenu2' => $this->admin_menu->arr_menu2,
			'adminMenuLimit' => 5,
			'adminMenuCurrent' => $adminMenuCurrent,
			'admin_menual_url' => $menual_url,
			'admin_menual_hidden' => $menual_hidden
		));
	}

	// 디자인 모듈 로딩
	public function tempate_modules(){

		$filePath = APPPATH."../admincrm/skin/".$this->skin."/_modules/";
		$map = directory_map($filePath);
		foreach($map as $dir => $dirRow) {
			if(is_array($dirRow)) {
				foreach($dirRow as $modulePath) {
					$dir = str_replace('/','',$dir);
					$modulesList[$dir."_".substr($modulePath,0,-5)] = $this->skin."/_modules/".$dir."/".$modulePath;
				}
			}
		}
		$this->template->define($modulesList);
	}

	public function template_path(){
		return $this->skin."/".implode('/',$this->uri->rsegments).".html";
	}
}

// 커스텀 파일이 있는 경우 커스텀파일에서 현파일을 로딩하여 상속 받아 사용한다.
if(!customBaseCall(__FILE__)) { class crm_base extends crm_base_original {} }

// END
/* End of file crm_base.php */
/* Location: ./app/base/crm_base.php */