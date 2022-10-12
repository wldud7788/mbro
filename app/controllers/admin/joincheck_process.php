<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);


class Joincheck_process extends admin_base {
	public function __construct() {
		parent::__construct();

		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('joincheck_act');
		if(!$auth){
			pageBack("권한이 없습니다.");
			exit;
		}
		/* 관리자 권한 체크 : 끝 */
		$this->load->model("joincheckmodel");
	}

	public function index()
	{
		$this->load->library(array('validation','pxl'));

		$today 			= date("Y-m-d");
		$mode			= $this->input->post('mode');
		$joincheck_seq	= $this->input->post('joincheck_seq');
		$mode 			= (!empty($mode))?$mode:$this->input->get('mode');
		$joincheck_seq 	= (!empty($joincheck_seq))?$joincheck_seq:$this->input->get('joincheck_seq');


		$isplusfreenot =  $this->isplusfreenot;
		if( !$isplusfreenot || !$isplusfreenot['ispoint'] ) {//무료몰인경우초기화@2013-01-14
			$_POST['point'] 		= '';
			$_POST['point_select'] 	= '';
			$_POST['point_year'] 	= '';
			$_POST['point_direct'] 	= '';
		}

		$params 							= $this->input->post();
		//$params['ch_title']				=  $params['ch_title'];		//출석체크 명
		//$params['sdate']					=  $params['sdate'];			//출석 시작 기간
		//$params['edate']					=  $params['edate'];			//출석 종료 기간
		$staste_stop						=  $params['mode_stop'];			//출석 종료 기간

		$params['ck_type']					=  $params['ck_type'];		// 출석 타입
		$params['com_list']					=  $params['com_list'];		// 댓글수
		$params['cl_type']					=  $params['cl_type'];		// 달성 타입
		if($params['cl_type']=='count'){
			$params['cl_count']				=  $params['cl_count_c'];		// 달성조건
		}elseif($params['cl_type']=='straight'){
			$params['cl_count']				=  $params['cl_count_s'];		// 달성조건
		}
		$params['emoney']					=  get_cutting_price($params['emoney']);		// 혜택

		$params['check_it']					=  $params['check_it']; 					// 출석 체크 맨트
		$params['check_already']			=  $params['check_already'];				// 이미 출석 했을때
		$params['check_complete']			=  $params['check_complete'];				// 마일리지 지급 시
		$params['check_SMS']				=  $params['check_SMS'];					// 마일리지 지급 SMS 발송
		$params['check_SMS_yn']				=  $params['check_SMS_yn']=='Y'?'Y':'N';	// 마일리지 지급 SMS 발송여부
		$params['joincheck_view']			 = $params['joincheck_view']=='N'?'N':'Y'; //출석체크 배너 노출 여부
		$params['joincheck_introduce']		 = $params['joincheck_introduce']; 		//출석체크 소개
		$params['joincheck_introduce_color'] = $params['joincheck_introduce_color']; //출석체크 소개 색상

		if($params['ck_type']=='comment'){
			$params['check_skin']			=  $params['chc_skin'];	// 스킨
		}else{
			$params['check_skin']			=  $params['ch_skin'];	// 스킨
		}
		$params['stamp_skin']				=  $params['stamp_skin'];	// 도장 스킨

		if($staste_stop == 'stop'){
			$params['check_state'] 			= $staste_stop;
		}else{
			if( $params['sdate'] <= $today &&  $today <= $params['edate']){
				$params['check_state'] = 'ing';
			}elseif( $params['edate'] < $today){
				$params['check_state'] = 'end';
			}else{
				$params['check_state'] = 'before';
			}
		}

		###	//폼 검색
		if(in_array($mode,array('joincheck_write','joincheck_modify'))) {

			/*
			Validation Check :: 필수체크리스트(체크순서)
			1. 목표/연속 출석 횟수 체크
			2. 이벤트명 체크
			3. 이벤트기간 내 목표/연속출석 횟수 가능여부 검증
			4. 이벤트기간 중복 확인
			5. 지급마일리지 확인
			6. 유효기간 확인
			*/
			if($params['cl_type'] == "count"){
				$this->validation->set_rules('cl_count_c', '목표 출석 횟수','trim|numeric|required|xss_clean|greater_than[0]');
			}else{
				$this->validation->set_rules('cl_count_s', '연속 출석 횟수','trim|numeric|required|xss_clean|greater_than[0]');
			}
			$this->validation->set_rules('ch_title', '이벤트명','trim|required|max_length[50]|xss_clean');

			$this->validation->set_rules('sdate', '시작일','trim|required|max_length[10]|xss_clean');
			$this->validation->set_rules('edate', '종료일','trim|required|max_length[10]|xss_clean');

			if(trim($params['edate']) < date('Y-m-d'))
			{	$c_msg		='종료일이 오늘보다 작을수는 없습니다.';
				$callback 	= "parent.document.jcRegist.edate.focus();";
				openDialogAlert($c_msg,400,140,'parent',$callback);
				exit;
			}
			if($params['sdate'] > $params['edate'] )
			{	$c_msg='종료일이 시작일보다 빠릅니다.<br/> 종료일을 변경해주세요';
				$callback = "parent.document.jcRegist.edate.focus();";
				openDialogAlert($c_msg,400,160,'parent',$callback);
				exit;
			}

			# 이벤트기간 내 목표/연속출석 횟수 가능여부 검증
			$ch_settime = intval((strtotime($params['edate']) - strtotime($params['sdate']))/86400);
			if($ch_settime + 1 <  $params['cl_count'] ){
				if($params['cl_type']=='count'){
					$cl_type_field = "cl_count_c";
					$cl_type_title = "목표 출석 횟수";
				}elseif ($params['cl_type']=='straight'){
					$cl_type_field = "cl_count_s";
					$cl_type_title = "연속 출석 횟수";
				}
				$callback 	= "parent.document.jcRegist.".$cl_type_field.".focus();";
				$c_msg		= $cl_type_title."가 이벤트 기간의 출석 가능 횟수를 초과했습니다.<br>".$cl_type_title."를 변경해주세요.";
				openDialogAlert($c_msg,450,180,'parent',$callback);
				exit;
			}

			# 이벤트기간 중복 확인
			if($params['check_state'] == 'before'||$params['check_state'] == 'ing'){
				$joincheckoutOverlap = $this->joincheckmodel->joincheckDateOverlapCheck($joincheck_seq, $params['sdate'], $params['edate']);
				if((int)$joincheckoutOverlap[0] > 0 ){
					$c_msg		= '이벤트 기간은 중복될 수 없습니다.<br/> 시작일과 종료일을 변경해주세요';
					$callback 	= "parent.document.jcRegist.sdate.focus();";
					openDialogAlert($c_msg,400,180,'parent',$callback);
					exit;
				}
			}

			if(!$params['emoney']) 	$params['emoney'] = 0;
			if(!$params['point'])	$params['point'] = 0;
			//마일리지 숫자체크 
			if (!preg_match("/^[0-9]/",$params['emoney'])) {
				$c_msg 		= "마일리지은 숫자만 입력 가능합니다.";
				$callback 	= "parent.document.jcRegist.emoney.focus();";
				openDialogAlert($c_msg,400,140,'parent',$callback);
				exit;
			}

			$this->validation->set_rules('emoney', '지급 마일리지','trim|numeric|required|xss_clean|greater_than[0]');

			if ($params['reserve_limit_type'] == "Y" && $params['reserve_select'] == "direct") {
				$this->validation->set_rules('reserve_direct', '유효 기간','trim|numeric|required|xss_clean|greater_than[0]');
			}
			if ($params['add_benefits']) {
				$this->validation->set_rules('point', '지급 포인트','trim|numeric|required|xss_clean|greater_than[0]');
				if ($params['point_select'] == "direct") {
					$this->validation->set_rules('point_direct', '유효 기간','trim|numeric|required|xss_clean|greater_than[0]');
				}
			}

			$this->validation->set_rules('check_it', '출석 체크 메세지','trim|required|xss_clean');
			$this->validation->set_rules('check_already', '이미 출석체크 한 경우 메세지','trim|required|xss_clean');
			$this->validation->set_rules('check_complete', '출석 체크 달성 시 메세지','trim|required|xss_clean');
			$this->validation->set_rules('check_SMS', '출석 체크 달성 시 문자 발송 메세지','trim|required|xss_clean');

			if($this->validation->exec()===false){
				$err = $this->validation->error_array;
				$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
				openDialogAlert($err['value'],400,140,'parent',$callback);
				exit;
			}

		}
		###

		if($mode == 'joincheck_write') {

			$data = array(
				'title' 				=> $params['ch_title'],
				'start_date'			=> $params['sdate'],
				'end_date'				=> $params['edate'],
				'regist_date'			=> date('Y-m-d H:i:s'),
				'check_state'			=> $params['check_state'],
				'check_type'			=> $params['ck_type'],
				'comment_list'			=> $params['com_list'],
				'check_clear_type'		=> $params['cl_type'],
				'check_clear_count'		=> $params['cl_count'],
				'emoney'				=> get_cutting_price($params['emoney']),
				'reserve_select'		=> $params['reserve_limit_type']=="Y" ? $params['reserve_select'] : "" ,
				'reserve_year'			=> $params['reserve_year'],
				'reserve_direct'		=> $params['reserve_direct'],
				'point'					=> get_cutting_price($params['point']),
				'point_select'			=> $params['point_limit_type']=="Y" ? $params['point_select'] : "",
				'point_year'			=> $params['point_year'],
				'point_direct'			=> $params['point_direct'],
				'skin'					=> $params['check_skin'],
				'stamp_skin'			=> $params['stamp_skin'],
				'check_it'				=> $params['check_it'],
				'check_already'			=> $params['check_already'],
				'check_complete'		=> $params['check_complete'],
				'check_SMS'				=> $params['check_SMS'],
				'check_SMS_yn'			=> $params['check_SMS_yn'],
				'del_state'				=> 'N',
				'joincheck_view'		=> $params['joincheck_view'],
				'joincheck_introduce'	=> $params['joincheck_introduce'],
				'joincheck_introduce_color'	=> $params['joincheck_introduce_color']

            );

			$result = $this->db->insert('fm_joincheck', $data);
			$sId	= $this->db->insert_id();

			
			if(!$result){
				$callback = "parent.document.location.reload()";
				openDialogAlert("저장이 실패하였습니다.",400,140,'parent',$callback);
			}
			if(preg_match("/^(\/data\/tmp)/i",$_POST['joincheck_banner'])){
			if(!is_dir(ROOTPATH.'data/joincheck')){
				@mkdir(ROOTPATH.'data/joincheck');
				@chmod(ROOTPATH.'data/joincheck',0777);
			}
			$ext = explode(".",$_POST['joincheck_banner']);
			$ext = $ext[count($ext)-1];
			$joincheck_banner = "joincheck_view_banner_".$sId.".{$ext}";
			$new_path = "data/joincheck/{$joincheck_banner}";
			@copy(ROOTPATH.$_POST['joincheck_banner'],ROOTPATH.$new_path);
			@chmod(ROOTPATH.$new_path,0777);
			}else{
				$joincheck_banner = $_POST['joincheck_banner'];
			}

			$joincheck_data = array(
				'joincheck_banner'=>$joincheck_banner
			);

			$this->db->where("joincheck_seq",$sId);
			$result = $this->db->update("fm_joincheck", $joincheck_data);

			if($result){
				$callback = "parent.document.location.href='/admin/joincheck/regist?joincheck_seq=".$sId."&mode=new';";
				openDialogAlert("저장 되었습니다.",400,140,'parent',$callback);
			}else{
				$callback = "parent.document.location.reload()";
				openDialogAlert("저장이 실패하였습니다.",400,140,'parent',$callback);
			}

		}elseif ($mode == 'joincheck_modify'){

			if(!$joincheck_seq){
				openDialogAlert("잘못된 접근입니다.",400,140,'parent',$callback);
				exit;
			}

			if ($params['savemode'] == 'status' && ($staste_stop == 'stop' || $staste_stop == 'ing')){
				$data = array(
				'check_state'	=> $params['check_state'],
				);
			}else{

				if(preg_match("/^(\/data\/tmp)/i",$_POST['joincheck_banner'])){
					if(!is_dir(ROOTPATH.'data/joincheck')){
						@mkdir(ROOTPATH.'data/joincheck');
						@chmod(ROOTPATH.'data/joincheck',0777);
					}
					$ext = explode(".",$_POST['joincheck_banner']);
					$ext = $ext[count($ext)-1];
					$joincheck_banner = "joincheck_view_banner_".$joincheck_seq.".{$ext}";
					$new_path = "data/joincheck/{$joincheck_banner}";
					@copy(ROOTPATH.$_POST['joincheck_banner'],ROOTPATH.$new_path);
					@chmod(ROOTPATH.$new_path,0777);
				}else{
					$joincheck_banner = $_POST['joincheck_banner'];
				}

				$data = array(
					'title' 			=> $params['ch_title'],
					'start_date'		=> $params['sdate'],
					'end_date'			=> $params['edate'],
					'update_date'		=> date('Y-m-d H:i:s'),
					'check_state'		=> $params['check_state'],
					'check_type'		=> $params['ck_type'],
					'comment_list'		=> $params['com_list'],
					'check_clear_type'	=> $params['cl_type'],
					'check_clear_count'	=> $params['cl_count'],
					'emoney'			=> get_cutting_price($params['emoney']),
					'reserve_select'	=> $params['reserve_limit_type']=="Y" ? $params['reserve_select'] : "",
					'reserve_year'		=> $params['reserve_year'],
					'reserve_direct'	=> $params['reserve_direct'],
					'skin'				=> $params['check_skin'],
					'stamp_skin'		=> $params['stamp_skin'],
					'check_it'			=> $params['check_it'],
					'check_already'		=> $params['check_already'],
					'check_complete'	=> $params['check_complete'],
					'check_SMS'			=> $params['check_SMS'],
					'check_SMS_yn'		=> $params['check_SMS_yn'],
					'del_state'		    => 'N',
					'joincheck_view'	=> $params['joincheck_view'],
					'joincheck_introduce'		=> $params['joincheck_introduce'],
					'joincheck_introduce_color'	=> $params['joincheck_introduce_color'],
					'joincheck_banner'			=>$joincheck_banner
				);
				
				// 이벤트 진행중인 경우에만 저장
				if($params['check_state'] == 'before'){
					$data['point']			= get_cutting_price($params['point']);
					$data['point_select']	= $params['point_limit_type']=="Y" ? $params['point_select'] : "";
					$data['point_year']		= $params['point_year'];
					$data['point_direct']	= $params['point_direct'];
				}

			}

			$this->db->where('joincheck_seq',$joincheck_seq);
			$result = $this->db->update('fm_joincheck', $data);
			if($result){
				if($params['submode'] == "mode_stop"){
					$msg = "발급 상태 변경 완료되었습니다.";
				}else{
					$msg = "수정을 완료하였습니다.";
				}
				$callback = "parent.document.location.reload()()";
				openDialogAlert($msg,400,140,'parent',$callback);

			}else{
				$callback = "parent.document.location.reload()";
				openDialogAlert("수정이 실패하였습니다.",400,140,'parent',$callback);
			}


		}elseif ($mode == 'joincheck_delete'){

			$data = array(	'del_state'		=> 'Y');
			$this->db->where('joincheck_seq',$joincheck_seq);
			$this->db->delete('fm_joincheck');
			$callback = "parent.document.location.href='/admin/joincheck/catalog';";

			openDialogAlert("삭제 되었습니다.",400,140,'parent',$callback);

		}elseif ($mode == 'joincheck_copy'){

			$sql = "SELECT *,
			if(check_state = 'stop','중지',if(current_date() between start_date and end_date,'진행 중',if(end_date < current_date(),'진행완료','진행 전')))
			 as status
			FROM fm_joincheck where joincheck_seq='".$joincheck_seq."'";
			$query = $this->db->query($sql);
			$result= $query->row_array();

			$copy_title="[복사]".$result['title'];

			$data = array(
				'title' 			=> $copy_title,
				'regist_date'		=> date('Y-m-d H:i:s'),
				'check_state'		=> 'before',
				'check_type'		=> $result['check_type'],
				'comment_list'		=> $result['comment_list'],
				'check_clear_type'	=> $result['check_clear_type'],
				'check_clear_count'	=> $result['check_clear_count'],
				'emoney'			=> get_cutting_price($result['emoney']),
				'skin'				=> $result['skin'],
				'stamp_skin'		=> $result['stamp_skin'],
				'check_it'			=> $result['check_it'],
				'check_already'		=> $result['check_already'],
				'check_complete'	=> $result['check_complete'],
				'check_SMS'			=> $result['check_SMS'],
				'check_SMS_yn'		=> $result['check_SMS_yn'],
				'del_state'			=> 'N',
				'joincheck_view'	=> $result['joincheck_view'],
				'joincheck_introduce'	    => $result['joincheck_introduce'],
				'joincheck_introduce_color'	=> $result['joincheck_introduce_color'],
				'joincheck_banner'		    =>$result['joincheck_banner']
			);

			$result = $this->db->insert('fm_joincheck', $data);
			$callback = "parent.document.location.href='/admin/joincheck/catalog';";
			openDialogAlert("복사 되었습니다.",400,140,'parent',$callback);

		}

	}


	//마일리지 등록
	public function emoney_pay()
	{
		$mode 				= $this->input->get_post('mode');
		$send_sms 			= $this->input->post('send_sms');
		$joincheck_seq 		= $this->input->post('joincheck_seq');
		$jcresult_seq 		= $this->input->post('jcresult_seq');
		$emoney_pay_emoney 	= $this->input->post('emoney_pay_emoney');

 		/* 마일리지 지급 */
		if($mode == 'emoney_pay') {

			$jcresult_seq_tmp = explode(",",$jcresult_seq);
			if(count($jcresult_seq) == 0) {
				$callback = "parent.emoneyclose();";
				openDialogAlert("회원을 선택해 주세요.",400,140,'parent',$callback);
				exit;
			}
			$this->load->model('membermodel');
			$query = $this->db->where_in('jcresult_seq',$jcresult_seq_tmp)->get('fm_joincheck_result');
			foreach($query->result_array() as $mc ){

				//회원정보체크
				$minfo = $this->membermodel->get_member_data($mc['member_seq']);
				if(!empty($minfo)) { //회원정보체크

					### EMONEY
					$query 				= $this->db->get_where('fm_joincheck',array('joincheck_seq'=>$joincheck_seq));
					$joincheck 			= $query -> row_array();
					$limit_date_emoney 	= "";
					if($joincheck['reserve_select']=='year'){
						$limit_date_emoney = date("Y-m-d", mktime(0,0,0,12, 31, date("Y")+$joincheck['reserve_year']));
					}else if($joincheck['reserve_select']=='direct'){
						$limit_date_emoney = date("Y-m-d", mktime(0,0,0,date("m")+$joincheck['reserve_direct'], date("d"), date("Y")));
					}
					if($emoney_pay_emoney > 0 ) {

						$emoney					= array();
						$emoney['type']			= 'joincheck';
						$emoney['emoney']		= $emoney_pay_emoney;
						$emoney['gb']			= 'plus';
						if($this->managerInfo['manager_seq']){
							$emoney['manager_seq']	= $this->managerInfo['manager_seq'];						
						}
						$emoney['memo']			= '출석체크 이벤트-'.addslashes($joincheck['title']);
						$emoney['memo_lang']	= $this->membermodel->make_json_for_getAlert("mp283");   // 출석체크 이벤트
						$emoney['limit_date']	= $limit_date_emoney;
						$this->membermodel->emoney_insert($emoney, $minfo['member_seq']);

						$update_prarams = array(
								'emoney_pay'		=> 'Y',
								'emoney_pay_date'	=> date('Y-m-d H:i:s'),
								'emoney'			=> $mc['emoney']+$emoney_pay_emoney,
						);
						$this->db->where('jcresult_seq',$mc['jcresult_seq']);
						$this->db->update("fm_joincheck_result",$update_prarams);
					}

					$config_basic = ($this->config_basic)?$this->config_basic:config_load('basic');

					$sms_msg = str_replace("{shopName}",$config_basic['shopName'],$_POST['emoney_pay_sms']);

					###SMS 발송
					if (!empty($sms_msg) && !empty($minfo['cellphone']) && $send_sms == 'Y') {

						require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
						$sms_send	= new SMS_SEND();
						$to_sms[0]['phone']	= preg_replace("/[^0-9]/", "", $minfo['cellphone']);
						$from_sms	= preg_replace("/[^0-9]/", "", $config_basic['companyPhone']);

						$sms_send->to		= $to_sms;
						$sms_send->from		= $from_sms;

						$result = $sms_send->send($sms_msg);

					}
				###
				}

			}
			$callback = "parent.emoneyclose();";
			openDialogAlert("마일리지 지급 완료",400,140,'parent',$callback);

			exit;
		}

	}


}
?>