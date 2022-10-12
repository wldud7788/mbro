<?php
/**
 * 접속아이피 체크
*/
class protectip extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->currentIp = $_SERVER['REMOTE_ADDR']; // 체크대상아이피
	}

	/* 접속 제한 체크 */
	public function check_ip($allow_ip){
		$allow_access = true;
		if($allow_ip){
			$allow_access = false;
			foreach($allow_ip as $setting_ip){
				if($setting_ip && preg_match('/'.$setting_ip.'/',$this->currentIp)){
					$allow_access = true;
				}
			}
		}
		return $allow_access;
	}

	/* front 아이피 차단 */
	public function protect_ip_check(){
		$protectIps = isset($this->config_system['protectIp']) ? explode("\n",$this->config_system['protectIp']) : null;
		if( $protectIps && $this->check_ip($protectIps) ){
			if($this->uri->rsegments[2]!='error_404'){
				redirect("/errdoc/error_404");
				exit;
			}
		}

	}

	/* 관리자 로그인페이지 아이피 차단 */
	public function protect_ip_admin_login(){
		$allowIps = isset($this->config_system['admin_limit_ip']) ? explode("|",$this->config_system['admin_limit_ip']) : null;
		if( $allowIps && !$this->check_ip($allowIps) ){

			// 에러 페이지로 이동
			if(sha1($_SERVER['REMOTE_ADDR']) != '618facb1637a6ba4cb07d03ddd529a8bada5609e') { // 가비아CNS 판교오피스 아이피 예외 (2017-09-25 채우형)
				if($this->uri->rsegments[2]!='error_404'){
					redirect("/errdoc/error_404");
				}
			}
		}
	}

	/* 관리자 페이지 아이피 차단(로그인제외) */
	public function protect_ip_admin($manager_seq){
		$this->load->model('managermodel');
		$manager_info = $this->managermodel->get_manager($manager_seq);
		$allowIps = ($manager_info['limit_ip']) ? explode("|",$manager_info['limit_ip']) : null;
		if( $allowIps && !$this->check_ip($allowIps) ){
			// 관리자 세션 삭제
			$this->load->model('managermodel');
			$this->managermodel->logout();

			// 관리자 로그인 페이지로 이동
			if($this->uri->rsegments[2]!='login'){
				redirect('/admin/login');
				exit;
			}
		}
	}

	/* 관리자 페이지 아이피 차단(로그인제외) */
	public function protect_ip_provider($provider_seq){
		$this->load->model('providermodel');
		$provider_info = $this->providermodel->get_provider_one($provider_seq);
		$allowIps = ($provider_info['limit_ip']) ? explode("|",$provider_info['limit_ip']) : null;
		if( $allowIps && !$this->check_ip($allowIps) ){
			// 입점사 세션 삭제
			$this->providermodel->logout();

			// 관리자 로그인 페이지로 이동
			if($this->uri->rsegments[2]!='login'){
				redirect('/selleradmin/login');
				exit;
			}
		}
	}

	/* 관리자CRM 페이지 아이피 차단(로그인제외) */
	public function protect_ip_admincrm($manager_seq){
		$this->load->model('managermodel');
		$manager_info = $this->managermodel->get_manager($manager_seq);
		$allowIps = ($manager_info['limit_ip']) ? explode("|",$manager_info['limit_ip']) : null;
		if( $allowIps && !$this->check_ip($allowIps) ){
			// 관리자 세션 삭제
			$this->load->model('managermodel');
			$this->managermodel->logout();

			// 관리자 로그인 페이지로 이동
			if($this->uri->rsegments[2]!='login'){
				redirect('/admincrm/login');
				exit;
			}
		}
	}
}