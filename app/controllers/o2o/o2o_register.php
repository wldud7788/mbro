<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class o2o_register extends front_base {

	function __construct() {
		parent::__construct();
		
		$this->load->library('o2o/o2oservicelibrary');
		
		// 인증키 체크
		$this->o2o_auth_info = array(
			'pos_key'	=> $this->input->get('pos_key'),
			'store_seq' => $this->input->get('store_seq'),
			'pos_seq'	=> $this->input->get('pos_seq'),
		);
		$this->o2oConfig = $this->o2oservicelibrary->check_o2o_service($this->o2o_auth_info);
		if(empty($this->o2oConfig)){
			// 에러 페이지로 이동
			redirect('/errdoc/error_404');
		}else{
			// O2O 환경 체크 false : 일반 접속, true : 오프라인 요청
			// 해당 변수를 o2o 서비스가 시작되면 갱신함
			// common_base에서 선언함
			$this->o2o_pos_env = true;
		}
	}
	
	public function index(){
		$_GET['popup'] = true;
		
		//  o2o 가입 핸드폰 인증
		$this->load->library('o2o/o2oinitlibrary');
		$this->o2oinitlibrary->init_member_auth_cellphone();
		
		// 인증키 전달
		$this->template->assign('o2o_auth_info',$this->o2o_auth_info);
		
		// 설정 정보 추가
		$joinform				= config_load('joinform');
		$this->template->assign('joinform', $joinform);
		
		$this->print_layout($this->template_path("o2o"));
	}
}