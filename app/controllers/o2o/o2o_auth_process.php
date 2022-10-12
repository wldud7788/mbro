<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class o2o_auth_process extends front_base {

	function __construct() {
		parent::__construct();
		
		// 암호화 데이터 디코딩
		$this->load->model('ssl');
		$this->ssl->decode();
		
		$this->load->library('o2o/o2oservicelibrary');
		$this->load->library('validation');
		
		// 서비스 활성화 여부 체크
		if(!$this->o2oservicelibrary->checkO2OService){
			// 에러 페이지로 이동
			redirect('/errdoc/error_404');
		}
	}
	### 휴대폰 인증 
	public function authphone(){
		// 인증된 세션 파기
		$this->session->unset_userdata('o2o_auth_phone_confirm');
		
		$sendresult	= false;
		
		$call_form = $this->input->post('call_form');
		
		$array_cellphone = $this->input->post('cellphone');
		foreach($array_cellphone as $k=>&$v){
			$v = base64_decode($v);
		}
		$cellphone = implode("",$array_cellphone);
		$cellphone_with = implode("-",$array_cellphone);
		$_POST['cellphone'] = $array_cellphone;
		
		$this->validation->set_rules('cellphone[]',			'휴대폰번호',			'trim|required|max_length[4]|numeric|xss_clean');
		
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$result = array("result"=>false, "msg"=>$err['value']);
			echo json_encode($result);
			exit;
		}

		unset($params_member);
		$params_member['cellphone'] = $cellphone_with;
		
		// 중복회원 가입 확인 cellphone
		$member_info = $this->o2oservicelibrary->get_member_info($params_member);
		
		$checked_member_o2o_merge = $this->o2oservicelibrary->check_member_o2o($params_member);
		
		// 온/오프 통합 여부
		$member_merge = ($call_form=="join_form" && $checked_member_o2o_merge)?true:false;
		
		if($member_info['code'] == "0" || $member_merge ){
			
			$phone		= $cellphone;
			$config		= config_load('member','confirmsendmsg');
			$sendMsg	= $config['confirmsendmsg'];
			$authnum	= rand(10000,99999);

			// 문구 초기화
			if(empty($sendMsg)) $sendMsg = "{shopname} 인증번호는 {phonecertify} 입니다.";

			// 약관 링크 추가
			$sendMsg .= "\n\n[이용약관]\n".$this->config_system['domain']."/service/agreement";

			$sendMsg	= str_replace("{shopname}", $this->config_basic['shopName'], $sendMsg);
			$sendMsg	= str_replace("{phonecertify}", $authnum, $sendMsg);

			$params['msg'] = trim($sendMsg);
			$commonSmsData['member']['phone'] = $phone;
			$commonSmsData['member']['params'] = $params;

			$result = commonSendSMS($commonSmsData);
			if($result['code'] == 0000){
				// 인증번호 세션
				$auth_phone = array('authnum'=>$authnum,'phone'=>$cellphone_with);
				$this->session->sess_expiration = (60 * 3);
				$this->session->set_userdata('o2o_auth_phone',$auth_phone);

				if($member_merge){
					$sendresult = "99";
					$msg = "동일한 휴대폰번호의 오프라인 계정이 확인되었습니다. "
						. "\n\n휴대폰 인증 및 회원가입 완료 시 "
						. "\n온/오프라인 회원 통합이 자동으로 이루어집니다.";
				}else{
					// 회원가입 폼에서는 매장 통합 대상 데이터가 없기 때문에 일반 가입으로 전환
					if($call_form=="join_form"){
						$sendresult = "online_join";
						// js 영역에서 처리
					}else{
						//발송되었습니다. 3분이내 입력하시기바랍니다.
						$msg = getAlert('mb068');
						$sendresult = true;
					}
				}
				
			}else{
				//발송에 실패하였습니다. 새로고침 후 시도해주세요.
				$msg = getAlert('mb069');
			}
		}elseif($member_info['code'] == "1"){
			$msg = '동일한 휴대폰번호로 이미 가입되어 있습니다.';
		}else{
			$msg = $member_info['msg'];
		}
		
		$result = array("result"=>$sendresult, "msg"=>$msg);
		echo json_encode($result);
	}
	
	// 휴대폰번호 인증번호 확인
	public function authphone_confirm(){
		// 인증된 세션 파기
		$this->session->unset_userdata('o2o_auth_phone_confirm');
		
		$auth_phone = $this->session->userdata('o2o_auth_phone');
		
		//=================================================
		// parameter init
		//=================================================
		$arr_param_list = array(
			'cellphone'			=> null,
			'authnum'			=> null,
		);
		foreach($arr_param_list as $reciveParamName => $value){
			// 가변 변수에 데이터 할당
			${$reciveParamName} = $this->input->post($reciveParamName);
			// 데이터 없을 시 기본 값 설정
			if(empty(${$reciveParamName}) && !empty($value)) ${$reciveParamName} = $value;
		}
		foreach($cellphone as $k=>&$v){
			$v = base64_decode($v);
		}
		$_POST['cellphone'] = $cellphone;
		if(!empty($cellphone))  $cellphone = implode("-",$cellphone);
		
		//=================================================
		// Form validation start
		//=================================================
		// form 체크 조건 추가
		$this->validation->set_rules('cellphone[]',			'휴대폰번호',			'trim|required|max_length[4]|numeric|xss_clean');
		$this->validation->set_rules('authnum',				'인증번호',				'required|trim|xss_clean|max_length[5]');
		
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		// 인증번호 유효성 체크
		if($cellphone != $auth_phone['phone'] || $authnum != $auth_phone['authnum']){
			openDialogAlert("인증번호 확인에 실패했습니다.",400,140,'parent',$callback);
			exit;
		}
		//=================================================
		// Form validation end
		//=================================================
		
		$callback = "
			$('.confirm_authnum').hide();
			$('.auth_timer').hide();
			if(typeof(parnet)!==\"undefined\"){
				parnet.clearInterval(timer);
			}
		";
		// 세션 파기
		$this->session->unset_userdata('o2o_auth_phone');
		
		// 회원 가입페이지에서 체크
		$this->session->sess_expiration = (60 * 15);
		$this->session->set_userdata('o2o_auth_phone_confirm',$auth_phone);
		
		openDialogAlert("인증 되었습니다.",400,140,'parent',$callback);
		exit;
	}
	
	### 휴대폰 인증 세션 삭제 :: 2016-04-25 lwh
	public function authphone_del(){
		// 인증된 세션 파기
		$this->session->unset_userdata('o2o_auth_phone_confirm');
		$this->session->unset_userdata('o2o_auth_phone');
		echo 'ok';
	}
	### 휴대폰 인증 세션 삭제 :: 2016-04-25 lwh
	public function check_authphone(){
		$auth_phone = $this->session->userdata('o2o_auth_phone');
		debug($auth_phone);
		$auth_phone = $this->session->userdata('o2o_auth_phone_confirm');
		debug($auth_phone);
		echo 'ok';
		$auth_phone = $this->session->userdata('auth_phone');
		debug($auth_phone);
		echo 'ok';
	}
}