<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class o2o_coupon extends front_base {

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
		$_GET['perpage'] = 6;		
		
		$this->load->helper('member');
		$this->load->model('membermodel');
		
		$this->load->model('couponmodel');
		$this->load->model('ordermodel');
		$this->load->helper('coupon');
		$this->load->model('goodsmodel');
		$this->load->model('categorymodel');
		
		// 회원 바코드 체크
		$member_barcode = $this->input->get("member_barcode");
		$member_barcode = trim($member_barcode);
		$member_barcode = str_replace(" ","",$member_barcode);
		if(empty($member_barcode)){
			// 에러 페이지로 이동
			redirect('/errdoc/error_404');
		}
		$params['member_barcode'] = $member_barcode;
		$memberInfo = $this->o2oservicelibrary->get_member_info_by_barcode($params);
		$this->userInfo['member_seq'] = $memberInfo['result']['member_seq'];
		$washMemberInfo = $memberInfo['result'];
		// $washMemberInfo = array();
		
		// 별도의 스트링 출력을 위해 회원의 전체 데이터를 가져온다.
		$tmpMemberInfo = $this->membermodel->get_member_data($washMemberInfo['member_seq']);
		$ruteloop = memberrute($tmpMemberInfo['rute'], 'name', '');
		$memberInfoStr = '';
		if($tmpMemberInfo['user_name']){
			$memberInfoStr .= $tmpMemberInfo['user_name'];
		}else{
			$memberInfoStr .= '-';
		}
		if($tmpMemberInfo['userid']){
			$memberInfoStr .= '('.$tmpMemberInfo['userid'].')님 ';
		}else{
			if($tmpMemberInfo['platform']=='POS'){
				$memberInfoStr .= '('.'오프라인회원'.')님 ';
			}elseif($ruteloop){
				$memberInfoStr .= '('.$ruteloop.')님 ';
			}else{
				$memberInfoStr .= '('.'아이디 없음'.')님 ';
			}
		}
		if($tmpMemberInfo['cellphone']){
			$memberInfoStr .= $tmpMemberInfo['cellphone'];
		}else{
			$memberInfoStr .= '핸드폰 번호 없음';
		}
		
		$_GET['tab'] = "1";
		$this->template->assign('memberInfoStr',$memberInfoStr);

		###
		//쿠폰 다운내역/다운가능내역
		$sc['member_seq']	= $memberInfo['result']['member_seq'];
		// 사용 가능 쿠폰만 조회되도록 수정 
		$_GET['use_status']	= 'unused';	// sc로 모델에 전달 하는것이 ㅇ아닌 GET에서 추가함.
		down_coupon_list('mypage', $sc , $dataloop);//helper('coupon');

		###
		
		// 마이페이지 - 쿠폰 목록 처리
		$this->load->library('o2o/o2oinitlibrary');
		$this->o2oinitlibrary->init_front_mypage_coupon();

		if(isset($dataloop)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtagfront($sc['searchcount'],$sc['perpage'],$this->membermodel->admin_member_url($file_path).'?tab='.$_GET['tab'], getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
		$this->template->assign('pagin',$paginlay);
		$this->template->assign('perpage',$sc['perpage']);
		
		// 인증키 전달
		$this->template->assign('o2o_auth_info',$this->o2o_auth_info);
		
		$this->print_layout($this->template_path("o2o"));
	}
}