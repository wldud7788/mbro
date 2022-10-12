<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class ifdo_marketing_process extends admin_base {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('ifdolibrary');
		$this->load->library('validation');
	}

	### 저장
	public function config()
	{
		$aPostParams	= $this->input->post();

		/* 관리자 권한 체크 : 시작 */
		$this->load->model('authmodel');
		$auth = $this->authmodel->manager_limit_act('ifdo_marketing');
		if(!$auth){
			$callback = "";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}
		/* 관리자 권한 체크 : 끝 */
		
		if($aPostParams['ifdo_marketing_use'] == 'Y'){
			$this->validation->set_rules('ifdo_marketing_code', '사이트 구분 코드','trim|required|xss_clean');

			if($this->validation->exec()===false){
				$err = $this->validation->error_array;
				$callback = "if(top.window.parent.document.getElementsByName('{$err['key']}')[0]) top.window.parent.document.getElementsByName('{$err['key']}')[0].focus();";
				openDialogAlert($err['value'],400,140,'parent',$callback);
				exit;
			}
			
		}

		### IFDO연동 설정 저장
		$this->ifdolibrary->set_ifdo_marketing($aPostParams);
		
		###
		$callback = "parent.document.location.reload();";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}
}