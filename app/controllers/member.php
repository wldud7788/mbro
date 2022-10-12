<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class member extends front_base {

	function __construct() {
		parent::__construct();
		$this->load->library('snssocial');
		$this->load->helper('member');
		$this->joinform = config_load('joinform');
		unset($joinform['use_y']);//폐지@2013-04-29
		unset($joinform['use_m']);//폐지@2014-07-01
	}

	public function main_index()
	{
		redirect("/member/index");
	}

	public function index()
	{

	}

	public function agreement()
	{
		$join_type		= $this->input->get('join_type');
		$type		= "member";
		if(strpos($join_type, $type)){
			$mtype = $type;
		}else{
			$mtype = $join_type;
		}

		$this->template->assign('mtype',$mtype);

		//18.02.27 kmj 기본앱 일 경우 공지
		if($this->arrSns['key_f'] == "455616624457601" && $join_type == 'fbmember'){
			print "<script type='text/javascript'>alert('페이스북의 앱 정책 변경으로 3월 중으로 페이스북을 통한 회원 가입 및 로그인 서비스를 제공하지 못하게 되었습니다.\\n페이스북으로 가입하신 회원은 다른 SNS 또는 신규 ID로 재가입해 주시기 바랍니다.\\n');</script>";
			pageRedirect($url='/member/agreement?join_type=member', $msg = '', $target = 'self');
			exit;
		}
		// 트위터 기본앱일 경우 공지 #19795 2018-06-27 hed
		if($this->arrSns['key_t'] == "ifHWJYpPA2ZGYDrdc5wQ" && $this->arrSns['use_t'] == "1" && ($join_type == 'twmember'||$join_type == 'twbusiness')){
			print "<script type='text/javascript'>alert('트위터의 앱 정책 변경으로 트위터를 통한 회원 가입 및 로그인 서비스를 제공하지 못하게 되었습니다.\\n트위터로 가입하신 회원은 다른 SNS 또는 신규 ID로 재가입해 주시기 바랍니다.\\n');</script>";
			pageRedirect($url='/member/agreement?join_type=member', $msg = '', $target = 'self');
			exit;
		}

		if($this->userInfo){
			 pageRedirect($url='/main/index', $msg = '', $target = 'self');
			 exit;
		}
		//sns subdomain
		if ( $this->config_system['domain'] && $this->config_system['domain'] == $_SERVER['HTTP_HOST'] )
			$this->template->assign("isdomain",true);//정식도메인
		$this->template->assign('firstmallcartid',session_id());

		// 사용 중인 sns 가져오기 라이브러리에서 공용처리 :: 2020-03-11 pjw
		$this->load->library('snssocial');
		$joinform = $this->snssocial->joinform_usesns();
		if(!trim($this->arrSns['key_k'])){ $joinform['use_k'] = ""; }
		if($joinform) $this->template->assign('joinform',$joinform);

		// SNS 카카오 연동 시 SDK호출
		if($joinform['use_k']) {
			requirejs([
				["/app/javascript/plugin/kakao/kakao.min.js",10],
			]);
		}
		requirejs([
			["/app/javascript/js/skin-snslogin.js",20],
		]);

		$this->template->assign('register',true);
		$join_type = isset($join_type) ? $join_type : false;

		$emoneyapp = config_load('member');
		$this->template->assign('emoneyapp',$emoneyapp);


		$this->load->model('membermodel');
		if($this->session->userdata('fb_invite')){
			$fbinvitemdata = $this->membermodel->get_member_data($this->session->userdata('fb_invite'));//회원정보
			if($fbinvitemdata['member_seq']) {
				$newdata = array(
									'fbinvitestr'  => $this->session->userdata('fb_invite'),
									'fb_invite'     => $fbinvitemdata['member_seq']
								);
				 $this->session->set_userdata($newdata);

				$this->template->assign('fb_invite',$fbinvitemdata);
				$this->template->assign('recommend',$fbinvitemdata);
			}else{
				$unsetuserdata = array('fbinvitestr' => '', 'fb_invite' => '');
				$this->session->unset_userdata($unsetuserdata);
			}
		}

		//신규회원가입쿠폰발급
		$this->load->model('couponmodel');
		$sc['whereis'] = ' and (type="member" or type="member_shipping") and issue_stop = 0 ';//발급중지가 아닌경우
		$coupon_multi_list = $this->couponmodel->get_coupon_multi_list($sc);
		foreach($coupon_multi_list as $coupon_multi){
			$couponmember 	= $this->couponmodel->get_coupon($coupon_multi['coupon_seq']);
			/* 사용제한 - 금액이 있을 경우 표시 leewh 2014-10-28 */
			if ($couponmember['limit_goods_price'] > 0) {
				$couponmember['limit_goods_price_title'] = sprintf("%s원 이상 구매시",number_format($couponmember['limit_goods_price']));
			}
			$couponmemberar[] = $couponmember;
			if( $num == 0 ) {//예전스킨용
				$num++;
				$this->template->assign('couponmember',$couponmember);
			}
		}
		$this->template->assign('couponmemberarray',$couponmemberar);

		//회원실명확인 : 본인확인 인증절차 @2016-07-18 ysm
		$this->realname_adult();

		$arrBasic = ($this->config_basic)?$this->config_basic:config_load('basic');

		if(strpos($join_type, 'member') !== false){ 
			if($joinform['kid_join_use'] == 'Y' || $joinform['kid_join_use'] == 'N'){
				$mtype = 'member';
				$this->template->assign('mtype',$mtype);
			}
		}

		// 만14세미만 스킨패치 여부 session 초기화.
		$_SESSION['skin_patch_14years_old'] = false;

		//20170920 shopName -> companyName 으로 변경(db쪽에 shopName 치환코드가 있는 관계로 소스에서만 설정) ldb
		$this->template->assign('shopName',$arrBasic['companyName']);
		// 현재 사용하지 않는 use_c use_m use_y use_g use_p use_i 삭제함
		if( ($joinform['join_type']=='member_business' 
				|| $joinform['use_f'] || $joinform['use_t']  || $joinform['use_n']  || $joinform['use_k'] || $joinform['use_a']) 
			&& !$join_type) {
			if($joinform) $this->template->assign('joinform',$joinform);
			$this->print_layout($this->skin.'/member/join_gate.html');
	
		/**
		 * else 로직 진입하는 설정 조건
		 * 1. 설정 > 회원 > 회원유형 : 개인회원 or 사업자 회원
		 * 2. 설정 > 회원 > sns 연동 : 연동된 sns '모두' 해지된 경우
		 */
		}else{

			$member = chkPolicyInfo();	// 통합약관 적용 - 치환처리 포함

			if($joinform['use_k'] && $joinform['use_sns']) $this->template->assign('use_sns', $joinform['use_sns']);
			$this->template->assign($member);
			$this->template->assign($joinform);
			$join_type = ($join_type !== false) ? $join_type : str_replace("_only","",$joinform['join_type']);
			$this->template->assign('join_type',$join_type);

			// 개인회원 가입인 경우 mtype 값에 'member' 전달해서 만 14세 체크박스를 노출시킨다.
			if ($join_type === 'member') {
				$this->template->assign('mtype', $join_type);
			}
			$this->print_layout($this->template_path());
		}
	}

	public function register()
	{	
		$params = $this->input->get();

		if($this->userInfo){
			 pageRedirect($url='/main/index', $msg = '', $target = 'self');
			 exit;
		}
		$email = code_load('email');
		$joinform = ($this->joinform)?$this->joinform:config_load('joinform');

		$emoneyapp = config_load('member');
		$this->template->assign('emoneyapp',$emoneyapp);

		$this->load->model('membermodel');
		if($this->session->userdata('fb_invite')){
			$fbinvitemdata = $this->membermodel->get_member_data($this->session->userdata('fb_invite'));//회원정보
			if($fbinvitemdata['member_seq']) {
				$newdata = array(
									'fbinvitestr'	=> $this->session->userdata('fb_invite'),
									'fb_invite'		=> $fbinvitemdata['member_seq']
								);
				 $this->session->set_userdata($newdata);

				$this->template->assign('fb_invite',$fbinvitemdata);
				$this->template->assign('recommend',$fbinvitemdata);
			}else{
				$unsetuserdata = array('fbinvitestr' => '', 'fb_invite' => '');
				$this->session->unset_userdata($unsetuserdata);
			}
		}

		if( $joinform['join_type']=='member_business' && !$params['join_type'] ) {
			print "<script type='text/javascript'>alert('회원 유형을 선택해주세요.');</script>";
			pageRedirect($url='/member/agreement', $msg = '', $target = 'self');
			exit;
		}

		$mtype = 'member';
		if($joinform['join_type']=='business_only' || ($joinform['join_type']=='member_business' && $params['join_type']=='business')) {
			$mtype = 'business';
		}

		//회원실명확인 : 본인확인 인증절차 @2016-07-18 ysm
		$this->realname_adult();

		//가입 추가 정보 리스트
		$msubdata = '';
		$qry = "select * from fm_joinform where used='Y' order by sort_seq";
		$query = $this->db->query($qry);
		$form_arr = $query -> result_array();
		foreach ($form_arr as $k => $data){
		$data['label_view'] = $this -> membermodel-> get_labelitem_type($data,$msubdata); 
		$sub_form[] = $data;

		}
		for ($m=1;$m<=12;$m++){	$m_arr[] = str_pad($m, 2, '0', STR_PAD_LEFT); }
		for ($d=1;$d<=31;$d++){	$d_arr[] = str_pad($d, 2, '0', STR_PAD_LEFT); }
		$this->template->assign('m_arr',$m_arr);
		$this->template->assign('d_arr',$d_arr);
		$this->template->assign('recommend',$this->session->userdata('recommend'));//추천회원자동등록됨
		$this->template->assign('form_sub',$sub_form);
		$auth = $this->session->userdata('auth');

		if($auth["namecheck_name"]) $this->template->assign('user_name',$auth["namecheck_name"]);
		if($auth["namecheck_key"]) $this->template->assign('safe_key',$auth["namecheck_key"]);
		if($auth["namecheck_birth"]) $this->template->assign('birthday', substr($auth["namecheck_birth"],0 ,4)."-".substr($auth["namecheck_birth"],4,2)."-".substr($auth["namecheck_birth"],-2));
		if($auth["namecheck_sex"]){
			if($auth["namecheck_sex"] == "M" || $auth["namecheck_sex"] == "A" || $auth["namecheck_sex"] == "1"){
				$sex = "male";
			}else{
				$sex = "female";
			}
			$this->template->assign('sex',$sex);
		}
		$this->template->assign('memberIcondata',memberIconConf());
		// 2018-05-23 jhr 본인인증된 사람은 핸드폰번호 고정
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

			$this->template->assign('cellphone',$phone);
			$this->template->assign('regitst_auth',1);
		}

		//  o2o 가입 핸드폰 인증
		$this->load->library('o2o/o2oinitlibrary');
		$this->o2oinitlibrary->init_member_auth_cellphone('join_form');

		// o2o 가입 안내 추가
		$this->load->library('o2o/o2orequiredlibrary');
		$this->o2orequiredlibrary->required_member_join_gate();

		if($email) $this->template->assign('email_arr',$email);
		if($joinform) $this->template->assign('joinform',$joinform);
		if($mtype) $this->template->assign('mtype',$mtype);
		$marketing['mailing'] = $this->input->get('mailing');
		$marketing['sms'] = $this->input->get('sms');

		$this->template->assign($marketing);
		$this->template->assign(array('kid_agree'=>$params['kid_agree'], 'is_skin_patch'=>$params['is_skin_patch']));
		$this->template->define(array('form_member'=>$this->skin.'/member/register_form.html'));
		$this->template->assign('register',true);
		$this->print_layout($this->template_path());
	}

	//회원실명확인 : 본인확인 인증절차 @2016-07-18 ysm
	public function realname_adult(){

		$realname = config_load('realname');
		$auth = $this->session->userdata('auth');

		if( ($realname['useRealnamephone']=='Y' || $realname['useIpin']=='Y') && $auth['auth_yn']!='Y' ) {//
			$arrBasic = ($this->config_basic)?$this->config_basic:config_load('basic');
			// 성인인증 관련 페이지 처리 :: 2015-06-04 lwh
			if($arrBasic['operating'] == "adult"){
				$this->template->assign('adult','1');
			}
			$this->template->assign('realnameinfo',$realname);
			$this->print_layout($this->skin.'/member/auth_chk.html');
			exit;
		}
	}


	//추천인 확인
	public function recommend_confirm()
	{
		$this->load->model('membermodel');
		$member	= $this->membermodel->get_member_data_id($_GET['recomid'],'done');
		$type = ($_GET['type']=='b') ? $_GET['type'] : '';
		$callback_txt = "<script type='text/javascript'>";
		if($member['member_seq']){
			// 추천인 ok
			$callback_txt .= "parent.document.getElementById('".$type."recommend_return_txt').innerHTML='가입되어 있는 회원입니다.';";
		}else{
			$callback_txt .= "parent.document.getElementById('".$type."recommend_return_txt').innerHTML='가입되어 있지 않은 회원입니다';";
			$callback_txt .= "parent.document.getElementById('".$type."recommend').value='';";
		}
		$callback_txt .= "</script>";

		echo $callback_txt;
	}

	//예전초대하기링크주소
	public function recommend()
	{
		$this->fbinvite();
	}

	//최종초대하기페이지
	public function fbinvite()
	{
		$this->load->model('membermodel');

		$this->snssocial->facebooklogin();
		if($_GET['fbinvitestr']){
			$unsetuserdata = array('fbinvitestr' => '', 'fb_invite' => '');
			$this->session->unset_userdata($unsetuserdata);
			$fbinvitemdata = $this->membermodel->get_member_data($_GET['fbinvitestr']);//회원정보
			if($fbinvitemdata['member_seq']) {
				$newdata = array(
									'fbinvitestr'  => $_GET['fbinvitestr'],
									'fb_invite'     => $fbinvitemdata['member_seq']
								);
				 $this->session->set_userdata($newdata);

				$this->template->assign('fb_invite',$fbinvitemdata);
				$this->template->assign('recommend',$fbinvitemdata);
			}
		}else{
			if($this->session->userdata('fb_invite')){
				$fbinvitemdata = $this->membermodel->get_member_data($this->session->userdata('fb_invite'));//회원정보
				if($fbinvitemdata['member_seq']) {
				$newdata = array(
									'fbinvitestr'  => $this->session->userdata('fb_invite'),
									'fb_invite'     => $fbinvitemdata['member_seq']
								);
				 $this->session->set_userdata($newdata);

					$this->template->assign('fb_invite',$fbinvitemdata);
					$this->template->assign('recommend',$fbinvitemdata);
				}else{
					$unsetuserdata = array('fbinvitestr' => '', 'fb_invite' => '');
					$this->session->unset_userdata($unsetuserdata);
				}
			}
		}
		$this->agreement();
	}

	public function register_ok()
	{
		/**
		 * 회원가입 후 한번만 접속 가능하도록 session 으로 체킹
		 * 추적 스크립트 재수집 방지
		 */
		$tmp_userid = $this->session->userdata('tmp_userid');
		if (isset($tmp_userid) === false) {
			//잘못된 접근입니다.
			$msg = getAlert('mb066');
			$return_url = '/';
			pageRedirect($return_url, $msg);
			exit;
		}

		/*
		법정 대리인 동의서 다운로드 링크
		*/
		$kid_auth = $this->input->get('kid_auth');
		if ($this->session->userdata('kid_auth') == 'N' || $kid_auth == 'N') {
			$joinform = config_load('joinform');
			if (!empty($joinform['agree_inlaw_filename']) && file_exists(ROOTPATH . '/data/agreement/' . $joinform['agree_inlaw_filename'])) {
				$url = '../data/agreement/' . $joinform['agree_inlaw_filename'];
			} else {
				$url = "javascript:alert('" . getAlert('et002') . "')";
			}
			$this->template->assign('file_url', $url);
		}
		$this->template->assign('kid_auth', $kid_auth);

		// ifdo 연동
		$this->load->library('ifdolibrary');
		$ifdo_tags = $this->ifdolibrary->join($tmp_userid);

		// 채널톡 연동
		$this->load->library('channeltalklibrary');
		$channeltalk = $this->channeltalklibrary->join();

		if ( $this->input->get('layermode') == 'layer') {
			$this->template->define(['tpl' => $this->skin . '/member/_layer_register_ok.html']);
			$this->template->print_('tpl');
		} else {
			$this->print_layout($this->template_path());
		}

		if ($this->config_system['facebook_pixel_use'] == 'Y') {
			$fbq = '';
			$fbq .= '<script>';
			$fbq .= "fbq('track', 'CompleteRegistration');";
			$fbq .= '</script>';

			echo $fbq;
		}

		// gtag 연동
		$this->load->library('googleGtag');
		$sEventTags = $this->googlegtag->eventTagSignUp();
		if ($sEventTags) {
			echo $sEventTags;
		}

		// 세션 초기화
		$unsetuserdata = ['tmp_userid', 'kid_auth', 'auth'];
		$this->session->unset_userdata($unsetuserdata);
	}

	public function login()
	{
		$layermode = !empty($_GET['layermode']) ? $_GET['layermode'] : 'normal';

		if ( $this->config_system['domain'] && $this->config_system['domain'] == $_SERVER['HTTP_HOST'] )
			$this->template->assign("isdomain",true);//정식도메인
		$this->template->assign('firstmallcartid',session_id());

		secure_vulnerability('member', 'order_auth', $_GET['order_auth']);
		$_GET['order_auth']		= (int) $_GET['order_auth'];
		$return_url = isset($_GET['return_url']) ? $_GET['return_url'] : "";
		$return_url = preg_replace("/mobileAjaxCall=[a-z0-9_-]*/","",$return_url);
		if(! (strstr(urldecode($return_url),"/board/write") || strstr(urldecode($return_url),"goods/review_write") || strstr(urldecode($return_url),"/mypage/mygdreview_write")) ) {
			if($_GET['order_auth'] ){
				$return_url = "/mypage/order_catalog";
			}
		}

		if( preg_match('/settle/',$return_url) ){
			$mode = "settle";
		}else if( preg_match('/cart/',$return_url) ){
			$mode = "cart";
		}

		if(!$return_url){
			$referer = parse_url($_SERVER['HTTP_REFERER']);
			//if($referer['path']=='/order/settle'){
				$return_url = $referer['path'] . ($referer['query'] ? '?'.$referer['query'] : '');
			//}
		}

		if($mode) $this->template->assign('mode',$mode);
		if($return_url) $this->template->assign('return_url',$return_url);
		$this->template->assign('login',true);

		$joinform = $this->snssocial->joinform_usesns();
		if($joinform) $this->template->assign('joinform',$joinform);

		$member = config_load('member');
		//20170920 shopName -> companyName 으로 변경(db쪽에 shopName 치환코드가 있는 관계로 소스에서만 설정) ldb
		$member['agreement'] = str_replace("{shopName}",$arrBasic['companyName'],$member['agreement']);
		$member['privacy'] = str_replace("{shopName}",$arrBasic['companyName'],$member['privacy']);
		$member['privacy'] = str_replace("{domain}",$arrBasic['domain'],$member['privacy']);

		//개인정보 관련 문구개선 @2016-09-06 ysm
		$member['privacy'] = str_replace("{책임자명}",$arrBasic['member_info_manager'],$member['privacy']);
		$member['privacy'] = str_replace("{책임자담당부서}",$arrBasic['member_info_part'],$member['privacy']);
		$member['privacy'] = str_replace("{책임자직급}",$arrBasic['member_info_rank'],$member['privacy']);
		$member['privacy'] = str_replace("{책임자연락처}",$arrBasic['member_info_tel'],$member['privacy']);
		$member['privacy'] = str_replace("{책임자이메일}",$arrBasic['member_info_email'],$member['privacy']);

		//개인정보 수집-이용
		$member['policy'] = str_replace("{domain}",$arrBasic['domain'],str_replace("{shopName}",$arrBasic['companyName'],$member['policy']));
		$this->template->assign($member);

		$this->load->helper('cookie');
		$this->template->assign('idsavechecked',get_cookie('userlogin'));

		if($layermode=='layer'){
			$this->template->define(array('tpl'=>$this->skin.'/member/_layer_login.html'));
			$this->template->print_('tpl');
		}else{
			$this->print_layout($this->template_path());
		}
	}


	public function find()
	{
		$sms_auth = config_load('master');
		$sms_conf = config_load('sms');

		// 카카오 알림톡 관련 추가 :: 2018-03-26 lwh
		$this->load->model('kakaotalkmodel');
		$kakaotalk_config	= $this->kakaotalkmodel->get_service();
		if($kakaotalk_config['status'] == 'A' && $kakaotalk_config['use_service'] == 'Y'){
			$sms_auth['sms_auth'] = (!$sms_auth['sms_auth']) ? true : $sms_auth['sms_auth'];
			$scParams['msg_code'] = array('findid_user','findpwd_user');
			$msg_list = $this->kakaotalkmodel->get_msg_code($scParams);
			if($sms_conf['findid_user_yn'] != 'Y')
				$sms_conf['findid_user_yn'] = $msg_list['findid_user']['msg_yn'];
			if($sms_conf['findpwd_user_yn'] != 'Y')
				$sms_conf['findpwd_user_yn'] = $msg_list['findpwd_user']['msg_yn'];
		}


		$this->template->assign('sms_auth',$sms_auth['sms_auth']);
		$this->template->assign('findid_user_yn',$sms_conf['findid_user_yn']);
		$this->template->assign('findpwd_user_yn',$sms_conf['findpwd_user_yn']);

		$joinform = ($this->joinform)?$this->joinform:config_load('joinform');
		if($joinform) $this->template->assign('joinform',$joinform);

		# 아이디/비번찾기 시 Chptcha 입력 추가  @2016-09-08 pjm
		$find_idpass	= config_load('find_idpass');
		$captcha_html	= array();
		if($find_idpass['find_id_use_captcha'] == "y" || $find_idpass['find_pass_use_captcha'] == "y"){
			include_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/Securimage.php";
			$Securimage							= new Securimage();
		}

		// 추후 일본어 패치 되었을 경우 _jp 넣어줄 것 2017-02-06
		$lang = '';
		switch($this->config_system['language']){
			case "US";$lang = '_en';break;
			case "CN";$lang = '_cn';break;
			case "JP";$lang = '';
		}

		$icon_path									= "/admin/skin/default/images/captcha/admin_refresh{$lang}.gif";
		$secure_txt									= getAlert('et400');

		if($find_idpass['find_id_use_captcha'] == "y"){
			$options_id_search						= array();
			$options_id_search['image_id']			= 'captcha_id_image';
			$options_id_search['input_id']			= 'captcha_id_search';
			$options_id_search['input_name']		= 'captcha_id_txt';
			$options_id_search['input_text']		= $secure_txt;
			$options_id_search['namespace']			= 'id_search';
			$options_id_search['show_path']			= '/captcha/securimage_show';
			$options_id_search['icon_path']			= $icon_path;
			$captcha_html['id_search_captcha_html'] = $Securimage->getCaptchaHtml($options_id_search);
		}else{
			$captcha_html['id_search_captcha_html'] = "";
		}
		if($find_idpass['find_pass_use_captcha'] == "y"){
			$options_pass_search					= array();
			$options_pass_search['image_id']		= 'captcha_pass_image';
			$options_pass_search['input_id']		= 'captcha_pass_search';
			$options_pass_search['input_name']		= 'captcha_pass_txt';
			$options_pass_search['input_text']		= $secure_txt;
			$options_pass_search['namespace']		= 'pass_search';
			$options_pass_search['show_path']		= '/captcha/securimage_show';
			$options_pass_search['icon_path']		= $icon_path;
			$captcha_html['pass_search_captcha_html'] = $Securimage->getCaptchaHtml($options_pass_search);
		}else{
			$captcha_html['pass_search_captcha_html'] = "";
		}
		$this->template->assign($captcha_html);

		$realname = config_load('realname');
		$this->template->assign('realnameinfo',$realname);
		$this->print_layout($this->template_path());
	}


	public function register_sns_form()
	{
		//18.02.27 kmj 기본앱 일 경우 공지
		if($this->arrSns['key_f'] == "455616624457601" && $_GET['snstype'] == 'facebook'){
			print "<script type='text/javascript'>alert('페이스북의 앱 정책 변경으로 3월 중으로 페이스북을 통한 회원 가입 및 로그인 서비스를 제공하지 못하게 되었습니다.\\n페이스북으로 가입하신 회원은 다른 SNS 또는 신규 ID로 재가입해 주시기 바랍니다.\\n');</script>";
			exit;
		}
		// 트위터 기본앱일 경우 공지 #19795 2018-06-27 hed
		if($this->arrSns['key_t'] == "ifHWJYpPA2ZGYDrdc5wQ" && $this->arrSns['use_t'] == "1" && $_GET['snstype'] == 'twitter'){
			print "<script type='text/javascript'>alert('트위터의 앱 정책 변경으로 트위터를 통한 회원 가입 및 로그인 서비스를 제공하지 못하게 되었습니다.\\n트위터로 가입하신 회원은 다른 SNS 또는 신규 ID로 재가입해 주시기 바랍니다.\\n');</script>";
			exit;
		}

		$referer = parse_url($_SERVER['HTTP_REFERER']);
		$referer['host'] = preg_replace("/^m\./","",$referer['host']);
		$referer['host'] = preg_replace("/^www\./","",$referer['host']);
		$this->config_system['domain'] = preg_replace("/^www\./","",$this->config_system['domain']);

		$display = ( $this->_is_mobile_agent === true)?"touch":"popup";
		if(!$this->session->userdata('fbuser')) {
			$login_info = array(
			'scope'			=> $this->snssocial->userauth,
			'display'		=> $display);
			$loginUrl = $this->snssocial->facebook->getLoginUrl($login_info);

			$this->template->assign('loginUrl',$loginUrl);
		}else{
			$fbpermissions = $this->snssocial->facebookpermissions($this->snssocial->facebook);

			if($_GET['formtype'] == 'wishadd' && $_GET['stream'] && !(array_key_exists($_GET['stream'], $fbpermissions['data'][0]) || in_array($_GET['stream'], $fbpermissions) ) ) {
					$login_info = array(
					'scope'			=> $_GET['stream'],
					'display'		=> $display);
					$permissionloginUrl = $this->snssocial->facebook->getLoginUrl($login_info);
					$this->template->assign('permissionloginUrl',$permissionloginUrl);
			}

			if(!$fbpermissions){
					$login_info = array(
					'scope'			=> $this->snssocial->userauth,
					'display'		=> $display);
					$permissionloginUrl = $this->snssocial->facebook->getLoginUrl($login_info);
					$this->template->assign('permissionloginUrl',$permissionloginUrl);
			}
			$this->template->assign('fbuser',$this->session->userdata('fbuser'));
		}

		if($_GET['snsreferer']) setcookie('snsreferer', $_GET['snsreferer'], 0, '/');
		if($_GET['return_url']) setcookie('return_url', $_GET['return_url'], 0, '/');

		$this->template->assign('designMode',false);
		$this->template->assign('snsrefererurl',$_COOKIE['snsreferer']);
		$this->template->assign('snsrefererdetailurl',$_COOKIE['return_url']);
		$this->print_layout($this->template_path());
	}

	public function popup_change_pass(){
		// 로그인체크
		login_check();
		
		$modifyPWMin = config_load('member','modifyPWMin');
		$passwordRate = round($modifyPWMin['modifyPWMin']/30);

		$this->template->assign(array('passwordRate'=>$passwordRate));
		$this->print_layout($this->template_path());
	}

	// 성인인증 페이지
	public function adult_auth(){

		$realname = config_load('realname');
		$auth = $this->session->userdata('auth');

		if(empty($_GET['return_url'])){
			$return_url = '/main';
		}else{
			$return_url = $_GET['return_url'];
		}

		$adult_auth	= $this->session->userdata('auth_intro');
		if($adult_auth['auth_intro_yn'] == 'Y'){
			redirect($return_url);
		}

		$this->template->assign('realnameinfo',$realname);
		$this->template->assign('return_url',$return_url);
		$this->template->assign('domain',$this->config_basic['domain']);

		$this->print_layout($this->template_path());
	}

	public function unsubscribe(){

		$ussKey = $this->input->get('ussKey');
		$verify = $this->input->get('verify');
		$testMode = $this->input->get('testMode');

		if(empty($ussKey)!==false){
			echo "<script>alert('잘못된 접근입니다.'); self.close();</script>";
			exit;
		}

		if(empty($verify)!==false && $verify != md5($this->config_system['shopSno'])){
			echo "<script>alert('잘못된 접근입니다.'); self.close();</script>";
			exit;
		}

		$this->load->model("membermodel");
		$massage = $this->membermodel->email_unsubscribe($ussKey, $testMode);

		// 수신 거부 테스트가 아닌 경우
		if((boolean)$testMode!==true){
			echo "<script>alert('".$massage."'); self.close();</script>";
		}else{
		// 수신 거부 테스트인 경우
			echo json_encode($massage);
		}
		exit;

	}

	public function dormancy(){
		$userid = $this->uri->rsegments[3];
		if($userid){
			$userid		= strForASCII(explode('l',$userid),'dec');
			$userid		= implode($userid);
			$this->db->where(array('userid'=>$userid));
			$rs			= $this->db->get('fm_member');
			$member		= $rs->row_array();
			if($member['member_seq'] && $member['dormancy_seq']){
				$this->load->model('membermodel');
				$this->membermodel->dormancy_off($member['member_seq']);
				//휴면처리가 성공적으로 해제되었습니다.\\n로그인후 정상적으로 쇼핑몰 이용이 가능합니다.
				echo "<script>alert('".getAlert('mb232')."'); location.href='/member/login';</script>";
			}else{
				redirect("/");
			}
		}else{
			redirect("/");
		}
	}

	// 휴면해지 본인인증 페이지
	public function dormancy_auth(){

		$realname = config_load('realname');
		$dormancy_auth	= $this->session->userdata('auth_dormancy');
		if($dormancy_auth['auth_dormancy_yn'] == 'Y'){
			redirect('/member/login');
		}

		$this->template->assign('realnameinfo',$realname);
		$this->template->assign('member_seq',$_GET['dormancy_seq']);
		$this->print_layout($this->template_path());
	}

	/*아이디자인 test로그인 시 레이어창*/
	public function t_id_list(){
		$this->tempate_modules();

		/* 관리자 권한 확인 start*/
		if(!$this->managerInfo) {
			echo "<script>alert('관리자 체크 확인요망');</script>";
			$callback = "";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}
		/* end */
		else {
			$this->load->model('designmodel');
			$mall_t_list = $this->designmodel->mall_t_id_list();
			if($mall_t_list != '') {
				$p_test = array();
				foreach($mall_t_list as $row) {
					$row['status'] = ($row['status'] == 'hold') ? '미승인' : '승인';
					$row['type'] = ($row['business_seq']) ? '기업' : '개인';
					$p_test[] = $row;
				}
				$this->template->assign(array('mall_i_test' => $p_test));
			} else {
				$not_t_list = "설정된 테스트 계정이 없습니다.";
				$this->template->assign('not_t_list', $not_t_list);
			}

			$file_path	= $this->skin.'/member/_t_id_list.html';

			$this->template->define(array('tpl'=>$file_path));
			$this->template->print_("tpl");
		}
	}
	/*아이디자인 test 레이어창 end*/

	public function kid_check(){
		$joinform	= config_load('joinform');
		$url		= '../data/agreement/'.$joinform['agree_inlaw_filename'];
		$this->template->assign('file_url',$url);
		$this->template->assign('file_name',$joinform['agree_inlaw_filename']);

		if( is_file($_SERVER['DOCUMENT_ROOT'].'/data/skin/'.$this->template_path()) ){
			$this->print_layout($this->template_path());
		} else {
			redirect("/main/index");
		}
		
	}

}
