<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class batch extends admin_base {

    public $aCategory = array(
        11 => "mileage",
        12 => "point"
    );
    
    public $aCategoryKR = array(
        11 => "마일리지",
        12 => "포인트"
    );
    
    public $aState = array(
        0 => "대기중",
        1 => "지급중",
        2 => "완료"
    );
    
	public function __construct() {
		parent::__construct();
		$this->load->helper('member');
		$this->template->assign('mname',$this->managerInfo['mname']);
		$this->template->define('member_search',$this->skin.'/member/member_search.html');

		// 보안키 입력창
		$member_download_info = $this->skin.'/member/member_download_info.html';
		$this->template->define(array("member_download_info"=>$member_download_info));

	}

	public function index()
	{
		redirect("/admin/member/catalog");
	}

	### 회원리스트
	public function member_catalog()
	{
		$auth = $this->authmodel->manager_limit_act('member_view');
		if(!$auth){
			pageBack("관리자 권한이 없습니다.");
			exit;
		}
		$this->load->model('snsmember');
		$this->load->model('membermodel');
		$this->load->model('providermodel');
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		
		$provider	= $this->providermodel->provider_goods_list();
		$this->template->assign('provider',$provider);
		
		// 개인 정보 조회 로그
		// $type,$manager_seq,$type_seq
		$this->load->model('logPersonalInformation');
		$this->logPersonalInformation->insert('memberlist',$this->managerInfo['manager_seq'],'');

		for ($m=1;$m<=12;$m++){	$m_arr[] = str_pad($m, 2, '0', STR_PAD_LEFT); }
		for ($d=1;$d<=31;$d++){	$d_arr[] = str_pad($d, 2, '0', STR_PAD_LEFT); }
		$this->template->assign('m_arr',$m_arr);
		$this->template->assign('d_arr',$d_arr);

		#### AUTH
		$auth_arr		= array();
		$auth_act		= $this->authmodel->manager_limit_act('member_act');
		if(isset($auth_act)) $auth_arr['auth_act'] = $auth_act;
		$auth_promotion = $this->authmodel->manager_limit_act('member_promotion');
		if(isset($auth_promotion)) $auth_arr['auth_promotion'] = $auth_promotion;
		$auth_send	= $this->authmodel->manager_limit_act('member_send');
		if(isset($auth_send)) $auth_arr['auth_send'] = $auth_send;

		// 회원정보다운로드 체크
		$auth_member_down	= $this->authmodel->manager_limit_act('member_download');
		if( !$this->isplusfreenot ){ //무료몰인경우 다운권한 없음
			$auth_member_down = false;
		}
		if(isset($auth_member_down)) $auth_arr['auth_member_down'] = $auth_member_down;
		$this->template->assign('auth_arr',json_encode($auth_arr));

		###
		if($_GET['header_search_keyword']) $_GET['keyword'] = $_GET['header_search_keyword'];

		### GROUP
		$group_arr = $this->membermodel->find_group_list();
		$search_type_arr = array(
			'user_name' => '이름',
			'userid' => '아이디',
			'email' => '이메일',
			'phone' => '전화번호(네자리)',
			'cellphone' => '핸드폰(네자리)',
			'address' => '주소',
			'nickname' => '닉네임'
		);

		$this->load->library('searchsetting');
		$_default 						= array('orderby'=>'member_seq','sort'=>'desc','page'=>0,'perpage'=>10);
		$callPage = $this->input->get('callPage');

		$scRes 							= $this->searchsetting->pagesearchforminfo("member_catalog",$_default);
		$sc_form 						= $scRes['form'];
		$sc_datePreset					= $scRes['date_preset'];
		
		unset($scRes['form']);
		$sc					= $scRes;
		if($callPage == "status") {
			$sc['status'] = 'hold';
		} else if($callPage == "sms" || $callPage == "batch_sms") {
			$sc['sms'] = 'y';
		} else if($callPage == "email" || $callPage == "batch_email") {
			$sc['mailing'] = 'y';
		}

		if($this->input->get('dormancy') == 1) {
			$sc['sc_day_type'] = $this->input->get('sc_day_type');
			$sc['lastlogin_search_type'] = $this->input->get('lastlogin_search_type');
			$sc['regist_sdate'] = $this->input->get('regist_sdate');
			$sc['regist_edate'] = $this->input->get('regist_edate');
			$sc['searchflag'] = "1";
			$sc['select_date_regist'] = "";
		}

		$sc['selected']['search_type'][$sc['search_type']]	= "selected";
		$sc['selected']['sc_day_type'][$sc['sc_day_type']]	= "selected";
		$sc['selected']['lastlogin_search_type'][$sc['lastlogin_search_type']]	= "selected";
		$sc['selected']['grade'][$sc['grade']]	= "selected";

		$sc['checkbox']['business_seq'][$sc['business_seq']]	= "checked";
		$sc['checkbox']['status'][$sc['status']]	= "checked";
		$sc['checkbox']['sitetype'][$sc['sitetype']]	= "checked";
		$sc['checkbox']['snsrute'][$sc['snsrute']]	= "checked";

		if($sc_datePreset[$scRes['select_date_regist']] && empty($sc['regist_sdate']) && empty($sc['regist_edate'])) {
			$sc['regist_sdate'] = $sc_datePreset[$scRes['select_date_regist']][0];
			$sc['regist_edate'] = $sc_datePreset[$scRes['select_date_regist']][1];
		}
		if($sc_datePreset[$scRes['select_date_birthday']] && empty($sc['birthday_sdate']) && empty($sc['birthday_edate'])) {
			$sc['birthday_sdate'] = $sc_datePreset[$scRes['select_date_birthday']][0];
			$sc['birthday_edate'] = $sc_datePreset[$scRes['select_date_birthday']][1];
		}
		if($sc_datePreset[$scRes['select_date_anniversary']] && empty($sc['anniversary_sdate'][0]) && empty($sc['anniversary_edate'][0])) {
			$sc['anniversary_sdate'][0] = substr($sc_datePreset[$scRes['select_date_anniversary']][0],5,2);
			$sc['anniversary_sdate'][1] = substr($sc_datePreset[$scRes['select_date_anniversary']][0],8,2);
			$sc['anniversary_edate'][0] = substr($sc_datePreset[$scRes['select_date_anniversary']][1],5,2);
			$sc['anniversary_edate'][1] = substr($sc_datePreset[$scRes['select_date_anniversary']][1],8,2);			
		}

		$this->template->assign('sc_form',$sc_form);
		
		//debug($sc);
		### MEMBER
		$sc['pageType'] = "search";
		$data = $this->membermodel->admin_member_list_spout($sc); //프로세스 변경 kmj

		if(count($data['grade_cnt']) > 1){
			$member_grade_seq	= "";
			$member_grade_name	= "";
		}else{
			$member_grade_seq	= $data['grade_cnt'][0]['group_seq'];
			$member_grade_name	= $data['grade_cnt'][0]['group_name'];
		}

		$this->template->assign(array('member_grade_seq'=>$member_grade_seq,'member_grade_name'=>$member_grade_name));

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

			//기업회원 정보 매칭 kmj
			if($datarow['mtype'] == 'business'){
			    $datarow['type']	= '기업';
			    
			    $bus_info = $this->db->query("seLECT
						business_seq, bname, bcellphone, bphone
					fROM
						fm_member_business
					wHERE
						member_seq = ? limit 0, 1", $datarow['member_seq'])->result_array();
			    
			    if($bus_info[0]){
			        $datarow['business_seq']	= $bus_info[0]['business_seq'];
			        $datarow['user_name']		= $bus_info[0]['bname'];
			        $datarow['cellphone']		= $bus_info[0]['bcellphone'];
			        $datarow['phone']			= $bus_info[0]['bphone'];
			    } else {
			        $datarow['business_seq']	= '';
			        $datarow['user_name']		= '';
			        $datarow['cellphone']		= '';
			        $datarow['phone']			= '';
			    }
			} else {
			    $datarow['type']	= '개인';
			}
			
			//그룹 정보 매칭 kmj
			$group_info = $this->db->query("seLECT
						group_name
					fROM
						fm_member_group
					wHERE
						group_seq = ? limit 0, 1", $datarow['group_seq'])->result_array();
			if($group_info[0]){
			    $datarow['group_name'] = $group_info[0]['group_name'];
			} else {
			    $datarow['group_name'] = '';
			}
			
			//유입 정보 매칭 kmj
			if(!$datarow['referer_domain']){
			    $datarow['referer_name'] = '직접입력';
			} else {
			    $referer_info = $this->db->query("seLECT
							referer_group_name
						fROM
							fm_referer_group
						wHERE
							referer_group_url = ? limit 0, 1", $datarow['referer_domain'])->result_array();
			    if($referer_info[0]){
			        $datarow['referer_name'] = $referer_info[0]['referer_group_name'];
			    } else {
			        $datarow['referer_name'] = '기타';
			    }
			}

			//리뷰건
			$sc['whereis'] = ' and mseq <> \'\' and mseq='.$datarow['member_seq'];
			$sc['select'] = ' count(gid) as cnt ';
			$gdreviewquery = $this->Boardmodel->get_data($sc);
			$datarow['gdreview_sum'] = $gdreviewquery['cnt'];

			if($datarow['rute'] != "none" ) {
				$snsmbsc['select'] = ' * ';
				$snsmbsc['whereis'] = ' and member_seq = \''.$datarow['member_seq'].'\' ';
				$snslist = $this->snsmember->snsmb_list($snsmbsc);
				if($snslist['result'][0]) $datarow['snslist'] = $snslist['result'];
			}

			$datarow['regist_date'] 	= date("Y-m-d H:i", strtotime($datarow['regist_date']));
			$datarow['lastlogin_date'] 	= date("Y-m-d H:i", strtotime($datarow['lastlogin_date']));

			/****/

			$dataloop[] = $datarow;
		}

		## 유입경로 그룹
		$this->load->model('statsmodel');
		$referer_list	= $this->statsmodel->get_referer_grouplist();
		$this->template->assign('referer_list',$referer_list);

		
		###
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtag($sc['searchcount'], $sc['perpage'], 'javascript:searchPaging(\'', getLinkFilter('',array_keys($sc)).'\');' );
		
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';

		//가입환경
		$sitetypeloop = sitetype($_GET['sitetype'], 'image', 'array');
		$this->template->assign('sitetypeloop',$sitetypeloop);

		//가입양식
		$ruteloop = memberrute($_GET['rute'], 'image', 'array' , 'search');
		$this->template->assign('ruteloop',$ruteloop);

		$this->template->assign('pagin',$paginlay);
		$this->template->assign('group_arr',$group_arr);
		$this->template->assign('search_type_arr',$search_type_arr);
		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('dormancy_count',$data['dormancy_count']);

		$this->template->assign(array('sc'=>$sc,'scObj'=>json_encode($sc)));

		$this->template->assign('callPage',$callPage);
		$this->template->assign('pageType',"search");
		$this->template->assign('loadType',"layer");
		$this->template->assign('query_string',get_query_string());

		$reserve = config_load('reserve');
		$this->template->assign('reserveinfo',$reserve);

		$point_use_button = "pointNotForm";
		if($reserve['point_use']=="Y") $point_use_button = "batchForm";
		$this->template->assign('point_use_button',$point_use_button);

		$this->template->define('member_list',$this->skin.'/member/member_list.html');
		$this->template->define('member_search',$this->skin.'/member/member_search.html');
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/* 이메일 수동 발송 */
	public function email_form()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		$auth_send	= $this->authmodel->manager_limit_act('member_send');
		$basic = ($this->config_basic)?$this->config_basic:config_load('basic');

		if(!$auth_send){
			echo "<script>alert('권한이 없습니다.'); self.close();</script>";
			exit;
		}

		// 회원 정보 다운로드 체크
		if ($this->managerInfo['manager_yn']=='Y') {
			$auth_member_down = true;
		} else {
			$auth_member_down = $this->authmodel->manager_limit_act('member_download');
		}

		if(isset($auth_member_down)){
			$this->template->assign('auth_member_down',$auth_member_down);
		}

		// 이메일 발송 로그 데이터 로드
		$query = $this->db->query("select * from fm_log_email order by seq desc limit 10");
		$emailData = $query->result_array();

		$this->load->model('usedmodel');
		$email_chk = $this->usedmodel->hosting_check();

		$this->template->assign('email_chk', $email_chk);
		$this->template->assign('verify', $this->config_system['shopSno']);

		/**
		 * SSL Redirect를 사용 중이라면 프로토콜을 무조건 https로 한다.
		 * 2019-06-17
		 * @copyright gabiacns
		 * @author Sunha Ryu
		 */
		$protocol = function_exists('get_connet_protocol') ? get_connet_protocol() : 'http://';
		$domain = $this->input->server('HTTP_HOST');
		$this->load->library('ssllib');
		$sslEnv = $this->ssllib->getSslEnvironment(array(), 1);
		if(!empty($sslEnv['data']) && count($sslEnv['data'])>0 && !empty($sslEnv['data'][0])) {
		    // 접속한 도메인이 ssl 대상 도메인에 포함되어 있고, 리다이렉트 설정이 Y 면 무조건 https로 한다.
		    if(in_array($domain, $sslEnv['data'][0]['domains'])) {
		        $certRedirect = $sslEnv['data'][0][$this->ssllib->sslConfigColumn['certRedirect']];
		        if($certRedirect === 'Y') {
		            $protocol = 'https://';
		        }
		    }
		}

		$this->template->assign('protocol', $protocol);
		$this->template->assign('domain', $domain);
		$this->template->assign('agreeManager', $this->managerInfo['mname'].'('.$this->managerInfo['manager_id'].')');
		$this->template->assign(array('mail_count'=>master_mail_count(),'email'=>$basic['companyEmail']));
		$this->template->assign('loop',$emailData);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	//SMS 대량 발송
	public function sms(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		// smsid, key 가 없을때 블락처리 :: 2018-09-12 pjw
		$auth			= config_load('master');
		$sms_id			= $this->config_system['service']['sms_id'];
		$sms_api_key	= $auth['sms_auth'];
		if($sms_id == ''){
			echo "<script>alert('SMS 아이디가 없습니다.'); document.location.replace('/admin/member/sms');</script>";
			exit;
		}else if($sms_api_key == ''){
			echo "<script>alert('등록 된 SMS 인증키가 없습니다.'); document.location.replace('/admin/member/sms');</script>";
			exit;
		}

		$auth_send	= $this->authmodel->manager_limit_act('member_send');
		if(!$auth_send){
			echo "<script>alert('권한이 없습니다.'); history.back();</script>";
			exit;
		}

		$send_phone = getSmsSendInfo();
		if(isset($send_phone)) $this->template->assign('send_phone',$send_phone);
		
		// 회원정보다운로드 체크
		if ($this->managerInfo['manager_yn']=='Y') {
			$auth_member_down = true;
		} else {
			$auth_member_down	= $this->authmodel->manager_limit_act('member_download');
		}
		if(isset($auth_member_down)) $this->template->assign('auth_member_down',$auth_member_down);


		if(isset($auth_send)) $this->template->assign('auth_send',$auth_send);
		$auth_promotion = $this->authmodel->manager_limit_act('member_promotion');
		if(isset($auth_promotion)) $this->template->assign('auth_promotion',$auth_promotion);

		$this->load->model("smsmodel");
		$return = $this->smsmodel->sms_auth_check();

		if($return['code'] != "200"){
			if($return['code'] == "203"){
				echo "<script>alert('인증 시간이 만료되었습니다. 다시 인증해 주십시오.'); document.location.replace('/admin/batch/sms_hp_auth');</script>";
				exit;
			}else{
				echo "<script>alert('".$return['msg']."'); </script>";
				exit;
			}
		}	
		
		$this->load->model("membermodel");

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

		$data = $this->membermodel->admin_member_list($sc);

		
		$this->template->assign('send_count',$data['count']);

		$specialArr	= array('＃', '＆', '＊', '＠', '§', '※', '☆', '★', '○', '●', '◎', '◇', '◆', '□', '■', '△', '▲', '▽', '▼', '→', '←', '↑', '↓', '↔', '〓', '◁', '◀', '▷', '▶', '♤', '♠', '♡', '♥', '♧', '♣', '⊙', '◈', '▣', '◐', '◑', '▒', '▤', '▥', '▨', '▧', '▦', '▩', '♨', '☏', '☎', '☜', '☞', '¶', '†', '‡', '↕', '↗', '↙', '↖', '↘', '♭', '♩', '♪', '♬', '㉿', '㈜', '№', '㏇', '™', '㏂', '㏘', '℡', '?', 'ª', 'º');
		$sms_id = $this->config_system['service']['sms_id'];
		$limit	= commonCountSMS();
		$sms_chk = $sms_id;

		$this->template->assign('count',$limit);
		$this->template->assign($this->session->userdata('token'));
		$this->template->assign(array('mInfo'=>$mInfo,'number'=>($send_num)? $send_num : $basic['companyPhone']));
		$this->template->assign(array('sms_loop'=>$sms_data,'sms_total'=>$sms_total,'sms_cont'=>$specialArr,'chk'=>$sms_chk));

		$this->template->assign('query_string',get_query_string());
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function emoney_form()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		
		$auth_promotion = $this->authmodel->manager_limit_act('member_promotion');
		
		if(!$auth_promotion){
			echo "<script>alert('권한이 없습니다.'); self.close();</script>";
			exit;
		}

		// 회원정보다운로드 체크
		if ($this->managerInfo['manager_yn']=='Y') {
			$auth_member_down = true;
		} else {
			$auth_member_down	= $this->authmodel->manager_limit_act('member_download');
		}
		if(isset($auth_member_down)) $this->template->assign('auth_member_down',$auth_member_down);
		
		###
		//$mInfo['total'] = get_rows('fm_member',array('status !='=>'withdrawal'));
		//$this->template->assign('mInfo',$mInfo);

		$this->template->define(array('tpl'=>$file_path));
		//$this->template->print_("tpl");
		
		//지급 내역 보기 kmj
		$this->history(11);
		$this->template->print_("tpl");
	}

	public function point_form()
	{
		serviceLimit('H_FR','process');

		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		
		$auth_promotion = $this->authmodel->manager_limit_act('member_promotion');
		
		if(!$auth_promotion){
			echo "<script>alert('권한이 없습니다.'); self.close();</script>";
			exit;
		}

		// 회원정보다운로드 체크
		if ($this->managerInfo['manager_yn']=='Y') {
			$auth_member_down = true;
		} else {
			$auth_member_down	= $this->authmodel->manager_limit_act('member_download');
		}
		if(isset($auth_member_down)) $this->template->assign('auth_member_down',$auth_member_down);

		
		###
		//$mInfo['total'] = get_rows('fm_member',array('status !='=>'withdrawal'));
		//$this->template->assign('mInfo',$mInfo);

		$this->template->define(array('tpl'=>$file_path));

		//지급 내역 보기 kmj
		$this->history(12);
		$this->template->print_("tpl");
		
	}

	public function sms_form()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$auth_send	= $this->authmodel->manager_limit_act('member_send');
		if(!$auth_send){
			echo "<script>alert('권한이 없습니다.'); self.close();</script>";
			exit;
		}

		$this->load->model("smsmodel");
		$sms_result	= $this->smsmodel->smsAuth_chk();
		$smsAuth	= $sms_result['auth'];
		if($sms_result['msg']){
			echo "<script>alert('" . $sms_result['msg'] . "');</script>";
		}

		if($smsAuth){
			$send_phone = getSmsSendInfo();
			if(isset($send_phone)) $this->template->assign('send_phone',$send_phone);

			$table = !empty($_GET['table']) ? $_GET['table'] : 'fm_member';
			$this->template->assign('table',$table);

			// 회원정보다운로드 체크
			if ($this->managerInfo['manager_yn']=='Y') {
				$auth_member_down = true;
			} else {
				$auth_member_down	= $this->authmodel->manager_limit_act('member_download');
			}
			if(isset($auth_member_down)) $this->template->assign('auth_member_down',$auth_member_down);

			###
			if($table=='fm_goods_restock_notify'){
				$mInfo['total'] = get_rows('fm_goods_restock_notify',array('notify_status'=>'none'));
				$action = "../goods_process/restock_notify_send_sms";
				$this->template->assign('action',$action);

				$this->template->assign('send_message',"[{$this->config_basic['shopName']}] 고객님께서 알림요청하신 상품({상품고유값},{상품명})이 재입고되었습니다.");
			}else{
				//$mInfo['total'] = get_rows('fm_member',array('status !='=>'withdrawal'));
				$action = "../member_process/send_sms";
				$this->template->assign('action',$action);
			}
			$specialArr	= array('＃', '＆', '＊', '＠', '§', '※', '☆', '★', '○', '●', '◎', '◇', '◆', '□', '■', '△', '▲', '▽', '▼', '→', '←', '↑', '↓', '↔', '〓', '◁', '◀', '▷', '▶', '♤', '♠', '♡', '♥', '♧', '♣', '⊙', '◈', '▣', '◐', '◑', '▒', '▤', '▥', '▨', '▧', '▦', '▩', '♨', '☏', '☎', '☜', '☞', '¶', '†', '‡', '↕', '↗', '↙', '↖', '↘', '♭', '♩', '♪', '♬', '㉿', '㈜', '№', '㏇', '™', '㏂', '㏘', '℡', '?', 'ª', 'º');
			$basic = ($this->config_basic)?$this->config_basic:config_load('basic');

			$sms_info = config_load('sms_info','send_num');
			if($sms_info['send_num']) $send_num = $sms_info['send_num'];

			###
			$sql = "select count(seq) as total, category from fm_sms_album group by category";
			$query = $this->db->query($sql);
			$sms_data = $query->result_array();
			$sms_total = get_rows('fm_sms_album');
			array_push($sms_data,array('total'=>$sms_total,'category'=>'전체보기'));
			rsort($sms_data);

			$sms_id = $this->config_system['service']['sms_id'];
			$limit	= commonCountSMS();
			$sms_chk = $sms_id;
		}

		$this->template->assign('sms_auth',$smsAuth);
		$this->template->assign('count',$limit);
		$this->template->assign(array('mInfo'=>$mInfo,'number'=>($send_num)? $send_num : $basic['companyPhone']));
		$this->template->assign(array('sms_loop'=>$sms_data,'sms_total'=>$sms_total,'sms_cont'=>$specialArr,'chk'=>$sms_chk));
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function sms_hp_auth(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		###
		//$mInfo['total'] = get_rows('fm_member',array('status !='=>'withdrawal'));
		//$this->template->assign('mInfo',$mInfo);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function getSmsCategory(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		
		###
		$sql = "select count(seq) as total, category from fm_sms_album group by category";
		$query = $this->db->query($sql);
		$sms_data = $query->result_array();
		$sms_total = get_rows('fm_sms_album');
		array_push($sms_data,array('total'=>$sms_total,'category'=>'전체보기'));
		rsort($sms_data);
		$this->template->assign(array('sms_loop'=>$sms_data));

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function getSmsSelectCategory(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		
		###
		$sql = "select count(seq) as total, category from fm_sms_album group by category";
		$query = $this->db->query($sql);
		$sms_data = $query->result_array();
		$sms_total = get_rows('fm_sms_album');
		array_push($sms_data,array('total'=>$sms_total,'category'=>'전체보기'));
		rsort($sms_data);
		$this->template->assign(array('sms_loop'=>$sms_data));

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function restock_notify_sms(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$auth_send	= $this->authmodel->manager_limit_act('member_send');
		if(!$auth_send){
			echo "<script>alert('권한이 없습니다.'); self.close();</script>";
			exit;
		}

		$send_phone = getSmsSendInfo();
		if(isset($send_phone)) $this->template->assign('send_phone',$send_phone);

		// 회원정보다운로드 체크
		if ($this->managerInfo['manager_yn']=='Y') {
			$auth_member_down = true;
		} else {
			$auth_member_down	= $this->authmodel->manager_limit_act('member_download');
		}
		if(isset($auth_member_down)) $this->template->assign('auth_member_down',$auth_member_down);

		###
		$mInfo['total'] = get_rows('fm_goods_restock_notify',array('notify_status'=>'none'));
		$action = "../goods_process/restock_notify_send_sms";
		$this->template->assign('action',$action);

		$this->template->assign('send_message',"[{$this->config_basic['shopName']}] 고객님께서 알림요청하신 상품({상품고유값},{상품명},{옵션})이 재입고되었습니다.");

		$specialArr	= array('＃', '＆', '＊', '＠', '§', '※', '☆', '★', '○', '●', '◎', '◇', '◆', '□', '■', '△', '▲', '▽', '▼', '→', '←', '↑', '↓', '↔', '〓', '◁', '◀', '▷', '▶', '♤', '♠', '♡', '♥', '♧', '♣', '⊙', '◈', '▣', '◐', '◑', '▒', '▤', '▥', '▨', '▧', '▦', '▩', '♨', '☏', '☎', '☜', '☞', '¶', '†', '‡', '↕', '↗', '↙', '↖', '↘', '♭', '♩', '♪', '♬', '㉿', '㈜', '№', '㏇', '™', '㏂', '㏘', '℡', '?', 'ª', 'º');
		$basic = ($this->config_basic)?$this->config_basic:config_load('basic');

		$sms_info = config_load('sms_info','send_num');
		if($sms_info['send_num']) $send_num = $sms_info['send_num'];

		###
		$sql = "select count(seq) as total, category from fm_sms_album group by category";
		$query = $this->db->query($sql);
		$sms_data = $query->result_array();
		$sms_total = get_rows('fm_sms_album');
		array_push($sms_data,array('total'=>$sms_total,'category'=>'전체보기'));
		rsort($sms_data);

		$sms_id = $this->config_system['service']['sms_id'];
		$limit	= commonCountSMS();
		$sms_chk = $sms_id;

		//메타테그 치환용 정보
		$meta_title	= "재입고 알림 문자 발송";
		$this->template->assign('meta_title',$meta_title);

		$this->template->assign('count',$limit);
		$this->template->assign(array('mInfo'=>$mInfo,'number'=>($send_num)? $send_num : $basic['companyPhone']));
		$this->template->assign(array('sms_loop'=>$sms_data,'sms_total'=>$sms_total,'sms_cont'=>$specialArr,'chk'=>$sms_chk));
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	function process_test(){
		echo "<table id='processTable' width='".$percent."%'>
			<tr>
				<td height='30' bgcolor='#ff0000'></td>
			</tr>
		</table>
		";

		$totalCount = 100000;

		$sendCount=0;
		ob_start();
		for($i=0; $i<$totalCount; $i++){
			$sendCount++;
			$percent = $sendCount / $totalCount * 100;
			echo "<script>document.all.processTable.style.width='".$percent."%';</script>";
			ob_flush(); 
			ob_clean();
		}
		ob_end_clean(); 
		exit;
	}


	function history($category)
	{
	    if ($category <= 0) {
	        openDialogAlert("카테고리 번호를 확인 할 수 없습니다.", 400, 180, 'parent', "");
	        exit;
	    }
	    
	    //변수정리
	    if (empty($_GET['perpage'])) {
	        $perpage = 10;
	    } else {
	        $perpage = $_GET['perpage'];
	    }
	    
	    if (empty($_GET['page'])) {
	        $page = 0;
	    } else {
	        $page = $_GET['page'];
	    }
	    
	    //갯수
	    $dataDB		= $this->db->query("SELECT COUNT(id) as cnt FROM fm_queue WHERE category = ?", $category);
	    $dataTotal	= $dataDB->result_array();
	    $data_total = $dataTotal[0]['cnt'];
	    $this->template->assign('data_total', $data_total);
	    
	    //목록
	    $dataDB = $this->db->query("SELECT * FROM fm_queue WHERE category = ?
                                        ORDER BY id desc LIMIT {$page}, {$perpage}", $category);
	    $data_list	= $dataDB->result_array();
	    
	    $no = $data_total - (($page/$perpage) * $perpage);
	    foreach ($data_list as $k => $v) {
	        $data_list[$k]['no']           = $no;
	        $data_list[$k]['category']     = $this->aCategory[$v['category']];
	        $data_list[$k]['state']        = $this->aState[$v['state']];
	        $data_list[$k]['count']        = $v['count'];
	        $tmpArr                        = explode("|", $v['file_name']);
	        $data_list[$k]['memo']         = $tmpArr[0];
	        $data_list[$k]['amount']       = $tmpArr[1];
	        if($tmpArr[2] == 'plus'){
	            $data_list[$k]['gb']       = '지급';
	        } else {
	            $data_list[$k]['gb']       = '차감';
	        }
	        $data_list[$k]['limit_date']   = substr($v['expired_date'], 0, 10);
	        
	        $no--;
	    }
	    
	    //페이징
	    $sc                   = array();
	    $sc['perpage']        = $perpage;
	    
	    $paginlay =  pagingtag($data_total, $perpage,'?', getLinkFilter('',array_keys($sc)) );
	    if (empty($paginlay)) {
	        $paginlay = '<p><a class="on red">1</a><p>';
	    }
	    
	    $this->template->assign('loop', $data_list);
	    $this->template->assign('perpage', $perpage);
	    $this->template->assign('pagin',$paginlay);
	    $this->template->assign('categoryKR', $this->aCategoryKR[$category]);
	}
}