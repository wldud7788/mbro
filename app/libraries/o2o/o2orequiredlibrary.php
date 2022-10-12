<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once(APPPATH ."libraries/o2o/o2oconfiglibrary".EXT);

Class o2orequiredlibrary extends o2oconfiglibrary
{
	public $checkO2ORequired = false;		// 필수 강제요소 사용여부
	
	public function __construct() {
		parent::__construct();
		
		// 필수 제약 조건이 동작되야 하는 경우 
		$this->checkO2ORequired = false;
		
		// 현재 등록된 o2o 매장 정보가 있을 경우
		$this->CI->load->library("o2o/o2oservicelibrary");
		$o2o_config = $this->CI->o2oservicelibrary->get_o2o_config(array('use_yn'=>'y'), 'unlimit');
		$use_pos_cnt = 0;
		foreach($o2o_config as $row){
			$use_pos_cnt += count($row['o2o_config_pos']);
		}
		if($use_pos_cnt>0){
			$this->checkO2ORequired = true;
		}
	}
	
	// o2o 가입 안내 추가
	public function required_member_join_gate(){
		if(!$this->checkO2ORequired){return $this->checkO2ORequired;}
				
		$this->CI->template->assign('checkO2ORequired', $this->checkO2ORequired);
		
		$this->CI->template->define('o2o_member_join_gate', $this->CI->skin.'/o2o/_modules/member_join_gate.html');
	}
	
	
	// o2o 설정 관리자 회원 추가 입력 값 추가
	public function required_admin_member_joinform(){
		if(!$this->checkO2ORequired){return $this->checkO2ORequired;}
		
		$this->CI->template->assign('checkO2ORequired', $this->checkO2ORequired);
		
		$this->CI->template->define('o2o_member_joinform', $this->CI->skin.'/o2o/_modules/member_joinform.html');
	}
	
	// 회원가입 입력 항목 중 휴대폰번호 비활성화 방지 처리
	public function required_block_disable_cellphone($params){
		if(!$this->checkO2ORequired){return $this->checkO2ORequired;}
		/* 별도의 회원가입 폼을 통해 강제로 입력받도록 프로세스 변경, 따라서 온라인의 핸드폰 입력 여부와 관계 없어짐
		if($this->checkO2ORequired
			&& ( $params['cellphone_use'] != 'Y' || $params['cellphone_required'] != 'Y'
				|| $params['bcellphone_use'] != 'Y' || $params['bcellphone_required'] != 'Y')
			){
			openDialogAlert('O2O 서비스 중 [핸드폰 항목]은 필수입니다.',400,140,'parent','');
			exit;
		}
		 */
	}
	
	// 동일 휴대폰번호 변경 방지
	public function required_block_duplicate_cellphone_member_o2o($params){
		if(!$this->checkO2ORequired){return $this->checkO2ORequired;}
		$result = false;
		
		unset($params_member);
		$params_member['cellphone'] = $params['cellphone'];
		
		// 중복회원 가입 확인 cellphone
		$this->CI->load->library("o2o/o2oservicelibrary");
		$result = $this->CI->o2oservicelibrary->check_member_o2o($params_member, 'all');
		if(!empty($result)){
			$result = array("result"=>false, "msg"=>'이미 동일한 휴대폰번호가 사용중입니다.');
			echo json_encode($result);
			exit;
		}
		return $result;
	}
	
	// 회원정보 변경 시 휴대폰인증 기능 비활성화 방지 처리
	public function required_block_disable_confirm_phone($params){
		if(!$this->checkO2ORequired){return $this->checkO2ORequired;}
		
		if($this->checkO2ORequired && $params['confirmPhone'] != 'Y'){
			openDialogAlert('O2O 서비스 중 [휴대폰 정보변경 시 인증번호 사용]은 필수입니다.',400,140,'parent','');
			exit;
		}
	}
	
	// O2O 쇼핑몰 창고 저장 기능
	public function required_admin_scm_save_store($params){
		if(!$this->checkO2ORequired){return $this->checkO2ORequired;}
		// O2O 삭제 시 창고를 먼저 삭제해야하므로 연결 체크는 무의미하므로 아래 내역 모두 주석처리
		//		
		//		// 현재 O2O 에 등록된 모든 매장 정보를 바탕으로 연결된 O2O 창고 키와 일치하는 것이 있는지 확인
		//		$not_used_wh = null;
		//		$this->CI->load->library("o2o/o2oservicelibrary");
		//		$o2o_config_list = $this->CI->o2oservicelibrary->get_o2o_config(null, "unlimit");
		//		foreach($o2o_config_list as $o2o_config){
		//			if(!in_array($o2o_config['scm_store'], $params['chk_wh'])){
		//				$not_used_wh = $o2o_config;
		//			}
		//		}
		//		
		//		if($not_used_wh){
		//			openDialogAlert('O2O 매장['.$not_used_wh['pos_name'].']에서 사용중인 창고는 필수입니다.', 400, 150, 'parent', '');
		//			exit;
		//		}
	}
	
	// 휴대폰번호 인증 여부 확인
	public function required_validate_auth_cellphone($params=array(), $deny_callback=null, $o2o_merge_request=true){
		if(!$this->checkO2ORequired){return $this->checkO2ORequired;}
		$cellphone = $params['cellphone'];
		$authnum =  $params['authnum'];
		
		// 통합 요청일 경우에만 인증번호확인 진행
		if($o2o_merge_request){
			// 기본 callback 함수 설정
			if(!function_exists($deny_callback)){
				$deny_callback = function(){
					$callback = "parent.document.getElementById('btn_register').style.display='block';";
					$callback .= "parent.document.getElementsByClassName('authnum_send')[0].style.display='none';";
					$callback .= "parent.document.getElementsByClassName('confirm_authnum')[0].style.display='inline';";
					openDialogAlert("인증번호 확인에 실패했습니다.인증을 먼저 진행해주세요.",400,140,'parent',$callback);
					exit;
				};
			}

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

			// 인증번호 유효성 체크
			if(empty($auth_phone)) $auth_phone = $this->CI->session->userdata('o2o_auth_phone_confirm');
			if(
				empty($phone) &&	//	본인인증을 통한 인증이 없어야함.
				(empty($cellphone) || empty($authnum) || $cellphone != $auth_phone['phone'] || $authnum != $auth_phone['authnum'])
				){
				if($deny_callback){
					$deny_callback();
				}
			}
			// 인증된 세션 파기
			$this->CI->session->unset_userdata('o2o_auth_phone_confirm');
		}
	}
	
	// O2O 미매칭 관련 설정 추가
	public function required_admin_setting_order(){
		if(!$this->checkO2ORequired){return $this->checkO2ORequired;}
		
		$orders = config_load('order');
		$this->CI->template->assign($orders);
				
		$this->CI->template->assign('checkO2ORequired', $this->checkO2ORequired);
		
		$this->CI->template->define('o2o_order', $this->CI->skin.'/o2o/_modules/order.html');
	}
}
