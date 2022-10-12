<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class joincheck extends admin_base {
	
	public function __construct() {
		parent::__construct();
		$this->load->model("joincheckmodel");
	}

	public function index()
	{
		redirect("/admin/joincheck/catalog");		
	}
	
	public function catalog()
	{
		/* 관리자 권한 체크 : 시작 */
		$this->load->model('authmodel');
		$auth = $this->authmodel->manager_limit_act('joincheck_view');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}
		/* 관리자 권한 체크 : 끝 */

		$this->admin_menu();
		$this->tempate_modules();
		$file_path		= $this->template_path();
		$today['today']	= date('Ymd');
		$this->template->assign('date',$today);

		### SEARCH
		$sc						= $this->input->get();
		$sc['page']				= (isset($sc['page']) && $sc['page'] > 1) ? intval($sc['page']):'0';
		$sc['perpage']			= (isset($sc['perpage'])) ?	intval($sc['perpage']):'10';
		if(isset($sc['search_text'])) $sc['search_mode']	= "search";
		
		$result							= $this->joincheckmodel->get_joincheck_list($sc);

		$sc['searchcount']	 			= $result['page']['searchcount'];
		$sc['totalcount']	 			= $result['page']['totalcount'];

		if(!$sc['event_status'])		$sc['event_status'] 			= "all";
		if(!$sc['event_type'])			$sc['event_type'] 				= "all";
		if(!$sc['event_clear_type'])	$sc['event_clear_type'] 		= "all";
		$sc['checkbox']['event_status'][$sc['event_status']]			= "checked";
		$sc['checkbox']['event_type'][$sc['event_type']]				= "checked";
		$sc['checkbox']['event_clear_type'][$sc['event_clear_type']]	= "checked";

		if(isset($redata)) $this->template->assign('loop',$dataloop);		
		$this->template->assign($result);
			$this->template->assign(array(
			'count'=>$count,
			'sc'=>$sc
		));		
		$this->template->define(array('tpl'=>$file_path));
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
		
	}
	
	
	public function regist()
	{
		$this->admin_menu();
		$this->tempate_modules();
		
		$this->file_path	= $this->template_path();		
		$joincheck_seq		= $this->input->get('joincheck_seq');
		
		$sc						= $this->input->get();		
		$sc['page']				= (isset($sc['page'])) ?	intval($sc['page']):'1';
		$sc['perpage']			= (isset($sc['perpage'])) ?	intval($sc['perpage']):'10';

		//이벤트 회원 진행 상황 조회
		$aJoincheckResult = $this->joincheckmodel->get_joincheck_result($joincheck_seq)->row_array();
		$aJoincheckResultAssign['page']['totalcount'] = (int) $aJoincheckResult['totalcount'];
		$aJoincheckResultAssign['rc']['sum_clear'] = (int) $aJoincheckResult['sum_clear'];
		$aJoincheckResultAssign['rc']['sum_emoney'] = (int) $aJoincheckResult['sum_emoney'];
		$this->template->assign($aJoincheckResultAssign);

		// 이벤트 정보 조회
		$result = $this->joincheckmodel->get_joincheck($joincheck_seq)->row_array();
		$config_basic = ($this->config_basic)?$this->config_basic:config_load('basic');
		$result['shopName'] = $config_basic['shopName'];
		
		//스킨별 팝업사이즈 지정
		if($result['check_type'] == 'comment'){
			$result['sz1']='680'; $result['sz2']='700';			
		}else{
			$result['sz1']='545'; $result['sz2']='670';
		}
		
		// 쇼핑몰 통화 기준 단위에 맞게 수정
		$result['emoney'] = get_cutting_price($result['emoney']);

		$reserves = ($this->reserves)?$this->reserves:config_load('reserve');

		$operation_type = !empty($this->config_system['operation_type']) ? $this->config_system['operation_type'] : 'heavy';
		$this->template->assign('operation_type', $operation_type);

		$this->template->assign(array('joincheck'=>$result,'reserves'=>$reserves,'mode'=>$this->input->get('mode')));
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}
	
	
	
	public function memberlist()
	{
		/* 관리자 권한 체크 : 시작 */
		$this->load->model('authmodel');
		$auth = $this->authmodel->manager_limit_act('joincheck_view');
		if(!$auth){
			$callback = "window.close();";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}
		/* 관리자 권한 체크 : 끝 */

		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		
		if( count($_GET) == 0 ){
			$_GET['emoney_pay '] = array('N','Y');
			$_GET['clear_success'] = array('N','Y');						
		}	
		
		
		### SEARCH
		$sc						= $this->input->get();
		$sc['page']				= (isset($sc['page']) && $sc['page'] > 1) ? intval($sc['page']):'0';
		$sc['perpage']			= (isset($sc['perpage'])) ?	intval($sc['perpage']):'10';
		if(isset($_GET['search_text'])) $sc['search_mode']	= "search";

		$sc['joincheck_seq'] = (!empty($this->input->post('joincheck_seq')))?$this->input->post('joincheck_seq'):$sc['joincheck_seq'];

		list($result,$rc) = $this->joincheckmodel->get_joincheck_memberlist($sc);
		$sc['searchcount']	 = $result['page']['searchcount'];
		$sc['totalcount']	 = $result['page']['totalcount'];

		foreach($result['record'] as $key => $datarow){

			$datarow['mclear_success'] = $this->joincheckmodel->clear_successNames[$datarow['clear_success']];
			
			//마일리지 지급여부에 따라 금액/미지급 표시
			if($datarow['emoney_pay'] == 'Y' ){								
				$datarow['memoney'] = $datarow['emoney'];
			}else{
				$datarow['memoney'] = '미지급';				
			}		
			$mbtel = (isset($minfo['cellphone']))?$minfo['cellphone']:$minfo['phone'];
			
			$datarow['allcount']	=  $rc['check_clear_count'];
			$datarow['usercount'] 	= (!$datarow['usercount'])? '0':$datarow['usercount'];

			// 연속일때, 횟수 일때
			if($rc['check_clear_type']== 'count'){
				$datarow['usercount'] =	"총 ".$datarow['count_cnt'];			
			}elseif($rc['check_clear_type']=='straight'){
				$datarow['usercount'] = "연속 ".$datarow['straight_cnt'];
			}		
			
			$result['record'][$key] = $datarow;
		}
		
		###
		include_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/sms.class.php";

		$auth			= config_load('master');
		$sms_id			= $this->config_system['service']['sms_id'];
		$sms_api_key	= $auth['sms_auth'];
		$gabiaSmsApi	= new gabiaSmsApi($sms_id,$sms_api_key);		
		$params			= "sms_id=" . $sms_id . '&sms_pw=' . md5($sms_id);
		$params			= makeEncriptParam($params);
		$limit			= $gabiaSmsApi->getSmsCount();
		$this->template->assign('count',$limit);
		

		if(isset($redata)) $this->template->assign('loop',$dataloop);
		$this->template->assign($result);
		$this->template->assign(array('rc'=>$rc, 'sc'=>$sc));		
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}
}

/* End of file event.php */
/* Location: ./app/controllers/admin/event.php */