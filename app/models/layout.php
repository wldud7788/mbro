<?php
class Layout extends CI_Model {

	public function __construct() {
		parent::__construct();

		$this->managerInfo = $this->session->userdata('manager');
	}

	/* 현재 프론트화면에 스킨 */
	public function get_view_skin(){
        $sCreateCached      = $this->input->get('createCached');
		// 미리보기를 통해 스킨을 변경하기 위해 파라미터로 전달될 시 쿠키에 재 삽입 by hed
        $getPreviewSkin     = $this->input->get('previewSkin');
		if($getPreviewSkin){
			$_COOKIE['previewSkin'] = $getPreviewSkin;
		}
        $sPreviewSkin       = $_COOKIE['previewSkin'];

        if( $sCreateCached ){
            $sPreviewSkin   = '';
            $_COOKIE['previewSkin'] = '';
            delete_cookie('previewSkin');
            setcookie('fammercemode', '', 0, '/');
            $sSetMode           = $this->input->get('setMode');
            $this->mobileMode   = false;
            $this->fammerceMode = false;
            if( $sSetMode == 'mobile' )         $this->mobileMode   = true;
            else if( $sSetMode == 'fammerce' )  $this->fammerceMode = true;
        }

		if($this->managerInfo['manager_seq'] && $this->is_design_mode()){
			$viewSkin = $this->designWorkingSkin;
			return $viewSkin;
		}

		if($sPreviewSkin){
			$viewSkin = $sPreviewSkin;
			return $viewSkin;
		}

		if			($this->fammerceMode)	$viewSkin = $this->realFammerceSkin;
		else if		($this->mobileMode)		$viewSkin = $this->realMobileSkin;
		else								$viewSkin = $this->realSkin;
		return $viewSkin;
	}

	/* 현재 프론트화면을 디자인모드로 출력할지 여부를 반환 */
	public function is_design_mode(){

		if($this->managerInfo['manager_seq']){
			$return = true;
		}else{
			$return = false;
		}

		if($_COOKIE['previewSkin'] && $_COOKIE['previewSkin']!=$this->workingSkin){
			$return = false;
		}

		if($_COOKIE['previewMobileSkin'] && $_COOKIE['previewMobileSkin']!=$this->workingMobileSkin){
			$return = false;
		}

		// 모바일기기에서는 디자인모드 사용불가
		if($this->_is_mobile_agent){
			$return = false;
		}

		// facebook ,iframe에서는 디자인모드 사용불가
		if($_COOKIE['fammercemode']){
			$return = false;
		}

		if($this->managerInfo['manager_seq']){

			$this->load->helper('cookie');

			if($_GET['setDesignMode']){
				set_cookie(array(
					'name'   => 'setDesignMode',
					'expire' => '86500',
					'value'  => $_GET['setDesignMode'],
					'path'   => '/'
				));

				if($_GET['setDesignMode']=='on'){
					$return = true;
				}else{
					$return = false;
				}
			}else{
				if(get_cookie('setDesignMode')=='on'){
					$return = true;
				}else{
					$return = false;
				}
			}

			//관리자주문 주소검색 디자인모드 숨긴 @2017-07-11
			$uri_str = uri_string();
			if($_GET['adminzipcode'] && strpos($uri_str, "popup/zipcode") !== false) $return = false;
		}

		return $return;
	}

	/* 측면디자인 없이 풀사이즈로 보여줄 화면 tpl_path 정의 */
	public function is_fullsize_absolutly($tpl_path) {
		return in_array($tpl_path,array(
			'member/join_gate.html',
			'member/agreement.html',
			'member/register.html',
			'member/register_ok.html',
			'member/find.html',
			'member/login.html',
			'order/settle.html',
			'order/complete.html',
			'promotion/event.html',
		));
	}

	/* 스킨 내 TPL 폴더 정의 */
	// 해당 스킨 폴더 내에 존재하는 파일만 가져오게 수정 및 불필요한 로직 정리 :: 2019-04-08 pjw
	public function get_folders_in_skin(){
		
		// 기본값 설정
		$folder_names						= array();
		$folder_names['main']				= '메인';
		$folder_names['layout_header']		= '상단 영역';
		$folder_names['layout_footer']		= '하단 영역';
		$folder_names['layout_MainTopBar']	= '메인 상단바';
		$folder_names['layout_TopBar']		= '상단바 영역';
		$folder_names['layout_side']		= '측면 영역';
		$folder_names['layout_scroll']		= '스크롤 영역';
		$folder_names['goods']				= '상품';
		$folder_names['order']				= '주문';
		$folder_names['member']				= '회원';
		$folder_names['mypage']				= '마이페이지';
		$folder_names['service']			= '고객센터';
		$folder_names['intro']				= '인트로';
		$folder_names['popup']				= '팝업페이지';
		$folder_names['joincheck']			= '출석체크';
		$folder_names['bigdata']			= '빅데이터';
		$folder_names['errdoc']				= '에러페이지';
		$folder_names['promotion']			= '프로모션';
		$folder_names['mshop'] 				= '미니샵';
		$folder_names['etc']				= '기타';
		$folder_names['broadcast']			= '라이브쇼핑';

		// 숨길 폴더
		$hide_directories = array('configuration','board','_modules','css','images','common','coupon','sns');
		
		// 입점사가 아닌 경우 미니샵 미노출 :: 2019-09-16 pjw
		if(!serviceLimit('H_AD'))	$hide_directories[] = 'mshop';

		// 추가 폴더
		$working_skin_path	= ROOTPATH."data/skin/".$this->designWorkingSkin;
		$map				= directory_map($working_skin_path,true,false);

		// 폴더별로 조건에 따라 명칭 넣어줌
		foreach($map as $directory){

			// 실제 폴더가 존재하고 숨길 폴더가 아닌 경우
			if(is_dir($working_skin_path.'/'.$directory) && !in_array($directory,$hide_directories)){
				
				// 폴더명이 정의 된 경우만 해당 폴더명을 넣고 아닌경우 그대로 노출
				$folder_name			= empty($folder_names[$directory]) ? $directory : $folder_names[$directory];
				$folders[$directory]	= $folder_name;
			}
		}

		return $folders;
	}

	/* 자주 쓰는 URL */
	public function get_frequent_url(){

		$frequents = array();
		$frequents[] = array('name'=>'메인화면'		,'value'=>'/main/index');
		$frequents[] = array('name'=>'마이페이지'		,'value'=>'/mypage/index');
		$frequents[] = array('name'=>'고객센터'		,'value'=>'/service/cs');

		return $frequents;
	}

	/* 사용자 추가 페이지 url 반환 */
	public function get_tpl_page_url($tpl_path){
		return "/page/index?tpl=".urlencode($tpl_path);
	}

	/* tpl_path의 URL 반환 */
	public function get_tpl_path_url($skin,$tpl_path,$tpl_page=null){
		if($tpl_page==null){
			$query = $this->db->query("select tpl_page from fm_config_layout where skin=? and tpl_path=?",array($skin,$tpl_path));
			$res = $query->row_array();
			$tpl_page = $res['tpl_page'];
		}

		return $tpl_page==1 ? $this->get_tpl_page_url($tpl_path) : "/".preg_replace("/\.html$/","",$tpl_path);
	}

	/* 쇼핑몰 타이틀 반환 */
	public function get_title(){
		$arrBasic = config_load('basic');
	}
}
?>