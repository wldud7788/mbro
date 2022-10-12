<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

/**
 * 라이브 방송 페이지
 */
class broadcast extends admin_base {

	public function __construct() {
		parent::__construct();
		$this->load->model('broadcastmodel');
		$this->load->helper('broadcast');

		$this->template->assign('cfg_broadcast', $this->broadcastmodel->cfg_broadcast);
	}

	/**
	 * 방송 리스트로 이동하는 함수
	 */
	public function index()
	{
		redirect("/admin/broadcast/catalog");		
	}

	/**
	 * 라이브 안내 및 설정 페이지
	 */
	public function info_old() 
	{
		$auth = $this->authmodel->manager_limit_act('broadcast_act');
		if(!$auth){
			pageBack("관리자 권한이 없습니다.");
			exit;
		}
		//View 영역 호출
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$this->template->assign('isUse',isBroadcastUse());

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}
	/**
	 * 생성한 방송 리스트
	 */
	public function catalog()
	{	
		if(defined('VODUSE') !== true){
			$auth = $this->authmodel->manager_limit_act('broadcast_act');
			if(!$auth){
				pageBack("관리자 권한이 없습니다.");
				exit;
			}
		}

		//View 영역 호출
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		// 검색 조건
		$this->load->library('searchsetting');
		$_default = array('orderby'=>'b.bs_seq','page'=>0,'perpage'=>10);
		$scRes = $this->searchsetting->pagesearchforminfo('broadcast_catalog',$_default);
		$this->template->assign('sc_form',$scRes['form']);
		unset($scRes['form']);
		$sc 							= $scRes;
		if(defined('VODUSE') == true){
			$sc['status'] = array('end');
			$sc['is_save'] = true;
		}

		$this->template->define(array('searchForm' => $this->skin.'/broadcast/_search_form.html'));
		$this->template->assign(array('sc'=>$sc,'scObj'=>json_encode($sc)));

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/**
	 * 실제 방송 리스트 template
	 */
	public function catalog_ajax()
	{
		$data = $this->input->post('data');
		$vod = $this->input->post('vod');
		$select = $this->input->post('select');

		$file_path	= $this->template_path();

		// vod 방송이고, 아이디자인에서 검색이 아닌 경우에는 vod_ajax
		if($vod == "true" && $select !="true") {
			$file_path 	= str_replace("catalog_ajax.html","vod_ajax.html",$file_path);
		}
		if($select == "true") {
			// select_broadcasts 와 data.broadcast 비교
			$select_broadcast = explode('|',$this->input->post('select_broadcast'));
			foreach($data as &$broadcast) {
				if(in_array($broadcast['bsSeq'],$select_broadcast)) {
					$broadcast['alreadySelect'] = true;
				}
			}
			$file_path 	= str_replace("broadcast/catalog_ajax.html","design/broadcast_list_ajax.html",$file_path);
		}

		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign(array('record' => $data));
		$this->template->print_("tpl");
	}

	/**
	 * 편성표 등록
	 */
	public function regist()
	{
		$auth = $this->authmodel->manager_limit_act('broadcast_act');
		if(!$auth){
			pageBack("관리자 권한이 없습니다.");
			exit;
		}
		//View 영역 호출
		$this->admin_menu();
		$this->tempate_modules();
		
		$file_path	= $this->template_path();
		$this->load->library('broadcast/writeargs');
		$args = $this->writeargs->getWriteArgs();
		
		// bs_seq 값이 있으면 수정
		$bs_seq = $this->input->get('bs_seq');
		$bs_seq = (int) $bs_seq;
		$this->load->library('broadcast/permit');
		if(!empty($bs_seq)) {
		    $this->template->assign('bs_seq', $bs_seq);
		} else {
			$provider_seq = '1';
			$this->template->assign('provider_seq', $provider_seq);
		}
		
		$this->template->assign($args);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/**
	 * 편성표 정보
	 */
	public function info()
	{
		$auth = $this->authmodel->manager_limit_act('broadcast_act');
		if(!$auth){
			pageBack("관리자 권한이 없습니다.");
			exit;
		}
		//View 영역 호출
		$this->admin_menu();
		$this->tempate_modules();

		$file_path	= $this->template_path();
		// bs_seq 값이 있으면 수정
		$bs_seq = (int)$this->input->get('bs_seq');
		$this->load->library('broadcast/permit');
		if($bs_seq < 1) {
			pageBack("올바른 연결이 아닙니다.");
			exit;
		}
		$this->load->library('broadcast/writeargs');
		$args = $this->writeargs->getWriteArgs();
		$this->template->assign($args);
		
		$this->template->assign('bs_seq', $bs_seq);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/**
	* 편성표 기본 데이터
	*/
   public function defaultRegist()
   {
	   //View 영역 호출
	   $this->admin_menu();
	   $this->tempate_modules();
	   
	   $file_path	= $this->template_path();
	   $this->load->library('broadcast/writeargs');
	   $args = $this->writeargs->getWriteArgs();
	   
		echo json_encode($args);
   }
	/**
	 * vod 리스트 
	 */
	public function vod()
	{
		$auth = $this->authmodel->manager_limit_act('vod_act');
		if(!$auth){
			pageBack("관리자 권한이 없습니다.");
			exit;
		}
		define('VODUSE',true);
		$this->template->assign('voduse',1);
		$this->catalog();
	}


	/**
	 * 아이디자인 방송 넣기 시 방송 검색
	 */
	public function select()
	{
		$this->tempate_modules();
		$auth = $this->authmodel->manager_limit_act('broadcast_act');
		if(!$auth){
			pageBack("관리자 권한이 없습니다.");
			exit;
		}

		// 검색 조건
		$this->load->library('searchsetting');
		$_default = array('orderby'=>'b.bs_seq','page'=>0,'perpage'=>10);
		$scRes = $this->searchsetting->pagesearchforminfo('broadcast_catalog',$_default);
		$this->template->assign('sc_form',$scRes['form']);
		unset($scRes['form']);
		$sc 							= $scRes;

		$sc['select'] = true;
		$sc['select_status'] = $this->input->get('select_status') ? $this->input->get('select_status') : 'vod';

		if($this->input->get('select_broadcast')) {
			$sc['select_broadcast'] = $this->input->get('select_broadcast');
		}
		// 지난방송 검색 시 저장된 방송만 불러오기
		if($sc['select_status'] == 'vod') {
			$sc['is_save'] = true;
		}

		$this->template->define(array('searchForm' => $this->skin.'/broadcast/_search_form.html'));
		$this->template->assign(array('sc'=>$sc,'scObj'=>json_encode($sc)));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

}
?>