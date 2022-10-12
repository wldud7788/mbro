<?php
/**
 * 게시판 관련 관리자 process
 * @author gabia
 * @since version 2.0 - 2012.06.29
 */
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class Boardmanager_process extends selleradmin_base {

	public function __construct() {
		parent::__construct();

		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('board_act');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}
		/* 관리자 권한 체크 : 끝 */

		$this->load->helper('board');//
		$this->load->library('validation');
		$this->load->model('Boardmanager');//v
	}

	/* 기본 */
	public function index()
	{
		$mode = (isset($_POST['mode']))?$_POST['mode']:$_GET['mode'];
		/* 게시판생성 */
		if($mode == 'boardmanager_write') {
		}

		/* 게시판수정 */
		elseif($mode == 'boardmanager_modify') {
		}

		/* 게시판삭제 */
		elseif($mode == 'boardmanager_delete') {
		}

		/* 게시판다중삭제 */
		elseif($mode == 'boardmanager_multi_delete') {

		}

		/* 게시판복사 */
		elseif($mode == 'boardmanager_copy') {

			$this->load->model('usedmodel');
			$result = $this->usedmodel->used_service_check('board');
			if(!$result['type']){
				$html = '<table width="100%"><tr><td align="left">무료몰+ : 기본 5개 (게시판 추가 시 1개당 2,200원, 최초 1회 결제로 기간 관계 없이 계속 이용)<br />프리미엄몰+ 또는 독립몰+로 업그레이드 하시면 게시판을 무제한 이용 가능합니다.</td></tr><tr><td align="center"><br /><br /><span class="btn large gray"><input type="button" onclick="serviceBoardAdd();" value="추가 신청 >"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn large gray"><input type="button" onclick="serviceUpgrade();" value="업그레이드 >"></span></td></tr></table>';
				openDialogAlert($html,600,210,'parent','');
				exit;
			}

			### Validation
			if( $_POST['id'] == '영문, 숫자, 언더스코어(_), 하이픈(-) 가능' ) {
				$_POST['id'] = '';
			}

			if( $_POST['name'] == '영문,한글, 숫자, 언더스코어(_), 하이픈(-) 가능' ) {
				$_POST['name'] = '';
			}

			$this->validation->set_rules('id', '게시판 아이디','trim|required|max_length[32]|xss_clean');
			$this->validation->set_rules('name', '게시판명','trim|required|max_length[32]|xss_clean');


			if($this->validation->exec()===false){
			   $err = $this->validation->error_array;
			   $callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			   openDialogAlert($err['value'],400,140,'parent',$callback);
			   exit;
			}

			###
			$sc['whereis']	= ' and id= "'.$_POST['id'].'" ';//등록시
			$sc['select']		= ' seq, id, name ';
			$rdata = $this->Boardmanager->managerdataidck($sc);//게시판정보
			if($rdata) {//등록된 게시판 아이디인경우
				$callback = "if(parent.document.getElementsByName('userid')[0]) parent.document.getElementsByName('userid')[0].focus();";
				openDialogAlert("이미사용중인 아이디입니다.",400,140,'parent',$callback);
				exit;
			}

			$sc['whereis']	= ' and id= "'.$_POST['copyid'].'" ';
			$sc['select']		= ' * ';
			$boardmanager = $this->Boardmanager->get_managerdata($sc);//게시판정보
			if($boardmanager){
				$nokey = array('seq','type','id','name','totalnum','r_date','m_date');
				foreach($boardmanager as $key=>$val) {
					if(in_array($key,$nokey)) continue;
					$params[$key] = $val;
				}
				$params['r_date'] = date("Y-m-d H:i:s");
				$params['m_date'] = date("Y-m-d H:i:s");
				$params['id'] = $_POST['id'];
				$params['name'] = $_POST['name'];
				$params['type'] = 'A';
				$result = $this->Boardmanager->manager_copy($params,$boardmanager, $_POST['copyid'], $_POST['id']);
			}

			if($result) {
				$sc['whereis']	= ' and id= "'.$_POST['copyid'].'" ';
				$sc['select']		= ' * ';
				$cpmanager = $this->Boardmanager->get_managerdata($sc);//게시판정보
				boarduploaddir($cpmanager);//폴더생성 및 스킨 복사

				$callback = "parent.document.location.reload();";
				openDialogAlert("게시판을 복사하였습니다.",400,140,'parent',$callback);
			}else{
				openDialogAlert("게시판복사가 실패 되었습니다.",400,140,'parent',$callback);
			}
			exit;
		}

		/* 게시판 아이콘
		 * @ new/hot/review 저장
		 * @ 게시판수정시에는 자동저장됨
		*/
		elseif($mode == 'boardmanager_icon') {

			$this->load->library('Upload');
			if (is_uploaded_file($_FILES['board_icon']['tmp_name'])) {
				$config['upload_path']		= (isset($_POST['boardid'])) ? $this->Boardmanager->board_data_dir.$_POST['boardid'].'/':$this->Boardmanager->board_tmp_dir;

				$file_ext = end(explode('.', $_FILES['board_icon']['name']));//확장자추출
				$config['allowed_types']	= 'jpg|gif|jpeg|png';

				$tmp = @getimagesize($_FILES['board_icon']['tmp_name']);
				$_FILES['Filedata']['type'] = $tmp['mime'];
				$config['overwrite']			= TRUE;
				$config['file_name']			= (isset($_POST['boardid'])) ? $_POST['boardid'].'_'.$_POST['icontype'].'.'.$file_ext:substr(microtime(), 2, 6).'_'.$_POST['icontype'].'.'.$file_ext;
				$this->upload->initialize($config);

				if ($this->upload->do_upload('board_icon')) {

					@chmod($config['upload_path'].$config['file_name'], 0777);

					if(isset($_POST['boardid'])) {
						$callback = 'parent.iconFileUploadComplete("true","'.$_POST['icontype'].'","'.$config['file_name'].'","'.$this->Boardmanager->board_data_src.$_POST['boardid'].'/","'.$file_ext.'");';

						$params['icon_'.$_POST['icontype'].'_img'] = $config['file_name'];
						$this->Boardmanager->manager_modify($params);

						$sc['whereis']	= ' and seq= "'.$_POST['seq'].'" ';
						$sc['select']		= ' * ';
						$manager = $this->Boardmanager->get_managerdata($sc);//게시판정보
						boarduploaddir($manager);//폴더생성 및 스킨 복사
					}else{
						$callback = 'parent.iconFileUploadComplete("true","'.$_POST['icontype'].'","'.$config['file_name'].'","'.$this->Boardmanager->board_tmp_src.'","'.$file_ext.'");';
						//(icontype,filename, filedir)
					}

					openDialogAlert("등록하였습니다.",400,140,'parent',$callback);

				}else{

					$callback = 'parent.iconFileUploadComplete("false","'.$_POST['icontype'].'","","","");';
					openDialogAlert("gif, jpg,jpeg, png 만 가능합니다.",400,140,'parent',$callback);

				}

			}else{
				$callback = 'parent.iconFileUploadComplete("false","'.$_POST['icontype'].'","","","");';
				openDialogAlert("등록 파일이 없습니다.",400,140,'parent',$callback);
			}
			exit;

		}

		/* 게시판아이디 중복체크 */
		elseif($mode == 'boardmanager_idck') {
			if(empty($_POST['board_id'])) echo '';

			$sc['whereis']	= ' and id= "'.$_POST['board_id'].'" ';
			$sc['select']		= ' seq, id, name ';
			$result = $this->Boardmanager->managerdataidck($sc);//게시판정보
			echo !$result ? 'true' : 'false';
			exit;
		}

		/* 게시판 스킨설정 */
		elseif($mode == 'boardmanager_skin_help') {
			$this->load->helper('file');
			if ( $_POST['boardid'] ){//게시판이 생성된경우
				$skin_type_img	= $this->Boardmanager->board_skin_src.$_POST['boardid'].'/'.$_POST['skinname'].'/skin_type.gif';
				$skin_help_file		= $this->Boardmanager->board_skin_dir.'/'.$_POST['boardid'].'/'.$_POST['skinname'].'/help.txt';
				$skin_help = read_file($skin_help_file);
				if(!$skin_help) {
					$_POST['skinname'] = ($_POST['skinname'])?$_POST['skinname']:'default01';
					$skin_type_img	= $this->Boardmanager->board_originalskin_src.$_POST['skinname'].'/skin_type.gif';
					$skin_help_file		= $this->Boardmanager->board_originalskin_dir.'/'.$_POST['skinname'].'/help.txt';
					$skin_help = read_file($skin_help_file);
				}
			}else{
				$_POST['skinname'] = ($_POST['skinname'])?$_POST['skinname']:'default01';
				$skin_type_img	= $this->Boardmanager->board_originalskin_src.$_POST['skinname'].'/skin_type.gif';
				$skin_help_file		= $this->Boardmanager->board_originalskin_dir.'/'.$_POST['skinname'].'/help.txt';
			}

			$skin_help = read_file($skin_help_file);
			if(!$skin_help && $_POST['boardid']) {
				if(in_array($_POST['boardid'], $this->Boardmanager->renewlist) ) {//기본만
					if( $_POST['boardid']=='goods_qna' ||  $_POST['boardid']=='goods_review' ) {
						$skin_type_img	= '/data/skin/'.$this->skin.'/images/board/skin_type_goods.gif';
						$skin_help_file		= ROOTPATH.'/data/skin/'.$this->skin.'/images/board/help_goods.txt';
					}else{
						$skin_type_img	= '/data/skin/'.$this->skin.'/images/board/skin_type_'.$_POST['boardid'].'.gif';
						$skin_help_file		= ROOTPATH.'/data/skin/'.$this->skin.'/images/board/help_'.$_POST['boardid'].'.txt';
					}
				}else{
					$skin_type_img	= '/data/skin/'.$this->skin.'/images/board/skin_type_'.$_POST['skinname'].'.gif';
					$skin_help_file		= ROOTPATH.'/data/skin/'.$this->skin.'/images/board/help_'.$_POST['skinname'].'.txt';
				}
				$skin_help = read_file($skin_help_file);
			}

			$result = array('skin_type_img'=>'<img src="'.$skin_type_img.'" >', 'skin_help'=>nl2br($skin_help));
			echo json_encode($result);
			exit;
		}
	}

}

/* End of file boardmanager_process.php */
/* Location: ./app/controllers/selleradmin/boardmanager_process.php */