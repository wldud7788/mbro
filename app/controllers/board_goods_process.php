<?php
/**
 * 게시글 관련 관리자 process
 * @author gabia
 * @since version 1.0 - 2012.06.29
 */
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class Board_goods_process extends front_base {

	public function __construct() {
		parent::__construct();

		$boardid = (!empty($_POST['board_id'])) ? $_POST['board_id']:$_GET['board_id'];
		secure_vulnerability('board', 'boardid', $boardid,array('parent','parent.submitck();'));
		define('BOARDID',$boardid);

		$this->load->library('validation');
		$this->load->library('Upload');
		$this->load->helper('download');
		$this->load->helper('board');//

		$this->load->model('Boardmanager');
		$this->load->model('membermodel');
		$this->load->model('boardadmin');

		if( BOARDID == 'goods_qna' ) {
			$this->load->model('Goodsqna','Boardmodel');
		}elseif( BOARDID == 'goods_review' ) {
			$this->load->model('Goodsreview','Boardmodel');
		}elseif( BOARDID == 'bulkorder' ) {//대량구매게시판
			$this->load->model('Boardbulkorder','Boardmodel');
		}else{
			$this->load->model('Boardmodel');
		}
		$this->load->model('Boardindex');
		$this->load->model('Boardcomment');
	}

	/* 기본 */
	public function index()
	{
		$mode = (!empty($_POST['mode']))?$_POST['mode']:$_GET['mode'];

		$sc['whereis']	= ' and id= "'.BOARDID.'" ';
		$sc['select']		= ' * ';
		$manager = $this->Boardmanager->managerdataidck($sc);//게시판정보
		if (!isset($manager['id'])) {
			//$callback = "parent.document.location.href='".$this->Boardmanager->managerurl."';";
			//존재하지 않는 게시판입니다.
			openDialogAlert(getAlert('et102'),400,140,'parent','');
			exit;
		}
 		/* 게시글 파일다운 */
		if($mode == 'goods_review_emoney') {
			//회원정보체크
			$this->load->model('membermodel');
			$minfo = $this->membermodel->get_member_data($_POST['mseq']);
			if(!empty($minfo)) { //회원정보체크
				//emoney
				//emoney history
			}
		}

		/* 상품후기 삭제시 마일리지/포인트 회수창 */
		elseif($mode == 'goods_review_less_view') {
			$_POST['delseq']				= (int) $_POST['delseq'];

			get_auth($manager, '', 'write' , $isperm);
			if ( $isperm['isperm_write'] === false ) {
				//잘못된 접근입니다.
				$return = array('result'=>false, 'name'=>$manager['name'], 'msg'=>getAlert('et103'));
				echo json_encode($return);
				exit;
			}

			$parentsql['whereis']	= ' and seq= "'.$_POST['delseq'].'" ';
			//본래게시글 추출@2017-05-12
			if( !(BOARDID == 'goods_review' || BOARDID == 'goods_qna' || BOARDID == 'bulkorder') ) {
				$parentsql['whereis']	.= ' and boardid= "'.BOARDID.'" ';
			}
			$parentsql['select']		= ' * ';
			$datarow = $this->Boardmodel->get_data($parentsql);//게시판목록
			if(empty($datarow)) {
				//존재하지 않는 게시물입니다.
				$return = array('result'=>false, 'name'=>$manager['name'], 'msg'=>getAlert('et104'));
				echo json_encode($return);
				exit;
			}
			if( $datarow['mseq'] > 0 ) {//회원글일때
				$session_arr = ( $this->session->userdata('user') )?$this->session->userdata('user'):$_SESSION['user'];
				if(!$session_arr['member_seq']){
					//잘못된 접근입니다.
					$return = array('result'=>false, 'name'=>$manager['name'], 'msg'=>getAlert('et103'));
					echo json_encode($return);
					exit;
				}

				if( $session_arr['member_seq'] != $datarow['mseq']){
					//잘못된 접근입니다.
					$return = array('result'=>false, 'name'=>$manager['name'], 'msg'=>getAlert('et103'));
					echo json_encode($return);
					exit;
				}
			}else{//비회원
				$ss_pwwrite_name = 'board_pwwrite_'.BOARDID;
				$boardpwwritess = $this->session->userdata($ss_pwwrite_name);
				if ( (isset($datarow['seq']) && !strstr($boardpwwritess,'['.$datarow['seq'].']') && !empty($boardpwwritess)) || empty($boardpwwritess)) {
					//잘못된 접근입니다.
					$return = array('result'=>false, 'name'=>$manager['name'], 'msg'=>getAlert('et103'));
					echo json_encode($return);
					exit;
				}
			}

			//삭제 시 지급된 적립 금액을
			$msg = '<div style="text-align:left">'.$manager['name'].' '.getAlert('et105').' ';

			$autoemoneylay		=  getBoardEmoneyAutotxt($datarow, $reviewless);//상품후기 삭제시 회수정보
			$auto_emoney			= ($reviewless['emoney'])?$reviewless['emoney']:0;//자동지급 총마일리지
			$auto_point				= ($reviewless['point'])?$reviewless['point']:0;//자동지급 총포인트
			//$input_emoney		= ($datarow['emoney'])?$datarow['emoney']:0;//수동지급
			$emoneyview = getBoardEmoneybtn($datarow, $manager, 'viewdelete');
			$input_emoney		= ($emoneyview)?$emoneyview:0;//수동지급

			getminfo($this->manager, $datarow, $minfo, $boardname);//회원정보
			$datarow['name'] = $boardname;
			if($minfo){
				$mb_emoney	= ($minfo['emoney'])?$minfo['emoney']:0;
				$mb_point		= ($minfo['point'])?$minfo['point']:0;
			}

			$ispointuse			= $this->isplusfreenot['ispoint'];
			$less_emoney = 0;$less_point = 0;
			$less_emoney =($auto_emoney)+($input_emoney);
			$less_point = $auto_point;

			//회수합니다.
			$msg.= ' <span style="color:red;" class="red">'.getAlert('et106').'</span>';
			$msg.= '<br/>';

			if( $auto_emoney>0 || $auto_point>0 ) {
				//자동 지급
				$msg1= '<div style="padding:3px; 0px" > - '.getAlert('et107').' : ';
				//마일리지
				$msg1.= ' '.getAlert('et108').' '.get_currency_price($auto_emoney,3);
				//포인트
				if( $ispointuse || $auto_point>0 ) $msg1.= ' / '.getAlert('et109').' '.get_currency_price($auto_point).'P';
				$msg1.= '</div>';
				$msg.=$msg1;
			}

			if( $input_emoney > 0 ) {
				//수동 지급
				$msg2= '<div style="padding:3px; 0px" > - '.getAlert('et110').' : ';
				$msg2.= ' '.getAlert('et108').' '.get_currency_price($input_emoney,3);
				$msg2.= '</div>';
				$msg.=$msg2;
			}

			//현재 보유
			$msg3= '<div style="padding:3px; 0px" > - '.getAlert('et111').' : ';
			$msg3.= ' '.getAlert('et108').' '.get_currency_price($mb_emoney,3);
			//포인트
			if( $ispointuse || $mb_point>0 ) $msg3.= ' / '.getAlert('et109').' '.get_currency_price($mb_point).'P';
			$msg3.= '</div>';
			$msg.=$msg3;

			$msg.= '<br/>';

			$msg4= '<div style="padding:3px; 0px" >';
			//회수 마일리지
			$msg4.= ' '.getAlert('et112').' '.get_currency_price($less_emoney,3);
			//보유 마일리지 부족
			if($less_emoney>$mb_emoney) $msg4.= ' (<span style="color:red;" class="red">'.getAlert('et113').'</span>)';
			$msg4.= '</div>';
			$msg.=$msg4;

			if( $ispointuse || $less_point>0 ) {
				$msg5= '<div style="padding:3px;" >';
				//회수 포인트
				$msg5.= ' '.getAlert('et114').' '.$less_point.'P';
				//보유 포인트 부족
				if($less_point>$mb_point) $msg5.= ' &nbsp;(<span style="color:red;" class="red">'.getAlert('et115').'</span>)';
				$msg5.= '</div>';
				$msg.=$msg5;
			}

			$msg.= '<br/>';//$msg.= '<br/>';

			if( $less_emoney>$mb_emoney || $less_point>$mb_point ){
				//회수할 적립 금액이 부족합니다.<br/> 고객센터로 문의해 주십시오.
				$msg.= '<div style="padding:3px 0px;" > '.getAlert('et116').' </div>';
				$return = array('result'=>'lees_none', 'name'=>$manager['name'], 'msg'=>$msg);
			}else{
				//삭제된 게시글은 복구할 수 없습니다.<br/> 정말로 삭제하시겠습니까?
				$msg.= '<div style="padding:3px 0px;" > '.getAlert('et117').' </div>';

				if( $less_emoney || $less_point ){
					$return = array('result'=>'lees', 'name'=>$manager['name'], 'msg'=>$msg);
				}else{
					$return = array('result'=>'delete', 'name'=>$manager['name'], 'msg'=>$msg);
				}
			}

			echo json_encode($return);
			exit;
		}



		/* 상품후기외 게시글 삭제시 마일리지/포인트 회수창 */
		elseif($mode == 'board_less_view') {
			$_POST['delseq']				= (int) $_POST['delseq'];


			get_auth($manager, '', 'write' , $isperm);
			if ( $isperm['isperm_write'] === false ) {
				//잘못된 접근입니다.
				$return = array('result'=>false, 'name'=>$manager['name'], 'msg'=>getAlert('et103'));
				echo json_encode($return);
				exit;
			}

			$parentsql['whereis']	= ' and seq= "'.$_POST['delseq'].'" ';
			$parentsql['select']		= ' * ';
			$datarow = $this->Boardmodel->get_data($parentsql);//게시판목록
			if(empty($datarow)) {
				//존재하지 않는 게시물입니다.
				$return = array('result'=>false, 'name'=>$manager['name'], 'msg'=>getAlert('et104'));
				echo json_encode($return);
				exit;
			}

			if( $datarow['mseq'] > 0 ) {//회원글일때
				$session_arr = ( $this->session->userdata('user') )?$this->session->userdata('user'):$_SESSION['user'];
				if(!$session_arr['member_seq']){
					//잘못된 접근입니다.
					$return = array('result'=>false, 'name'=>$manager['name'], 'msg'=>getAlert('et103'));
					echo json_encode($return);
					exit;
				}

				if( $session_arr['member_seq'] != $datarow['mseq']){
					//잘못된 접근입니다.
					$return = array('result'=>false, 'name'=>$manager['name'], 'msg'=>getAlert('et103'));
					echo json_encode($return);
					exit;
				}
			}else{//비회원
				$ss_pwwrite_name = 'board_pwwrite_'.BOARDID;
				$boardpwwritess = $this->session->userdata($ss_pwwrite_name);
				if ( (isset($datarow['seq']) && !strstr($boardpwwritess,'['.$datarow['seq'].']') && !empty($boardpwwritess)) || empty($boardpwwritess)) {
					//잘못된 접근입니다.
					$return = array('result'=>false, 'name'=>$manager['name'], 'msg'=>getAlert('et103'));
					echo json_encode($return);
					exit;
				}
			}

			//삭제 시 지급된 적립 금액을
			$msg = '<div style="text-align:left">'.$manager['name'].' '.getAlert('et105').' ';
			$emoneyview = getBoardEmoneybtn($datarow, $manager, 'viewdelete');
			$input_emoney		= ($emoneyview)?$emoneyview:0;//수동지급
			getminfo($this->manager, $datarow, $minfo, $boardname);//회원정보
			$datarow['name'] = $boardname;
			if($minfo){
				$mb_emoney	= ($minfo['emoney'])?$minfo['emoney']:0;
				$mb_point		= ($minfo['point'])?$minfo['point']:0;
			}
			$less_emoney = 0;$less_point = 0;
			$less_emoney = $input_emoney;

			//회수합니다
			$msg.= ' <span style="color:red;" class="red">'.getAlert('et106').'</span>';
			$msg.= '<br/>';

			if( $input_emoney > 0 ) {
				//수동 지급
				$msg2= '<div style="padding:3px; 0px" > - '.getAlert('et110').' : ';
				//마일리지
				$msg2.= ' '.getAlert('et108').' '.get_currency_price($input_emoney,3);
				$msg2.= '</div>';
				$msg.=$msg2;
			}

			//현재 보유
			$msg3= '<div style="padding:3px; 0px" > - '.getAlert('et111').' : ';
			//마일리지
			$msg3.= ' '.getAlert('et108').' '.get_currency_price($mb_emoney,3);
			$msg3.= '</div>';
			$msg.=$msg3;

			$msg.= '<br/>';

			$msg4= '<div style="padding:3px; 0px" >';
			//회수 마일리지
			$msg4.= ' '.getAlert('et112').' '.get_currency_price($less_emoney,3);
			//보유 마일리지 부족
			if($less_emoney>$mb_emoney) $msg4.= ' (<span style="color:red;" class="red">'.getAlert('et113').'</span>)';
			$msg4.= '</div>';
			$msg.=$msg4;

			$msg.= '<br/>';//$msg.= '<br/>';

			if( $less_emoney>$mb_emoney){
				//회수할 적립 금액이 부족합니다.<br/> 고객센터로 문의해 주십시오.
				$msg.= '<div style="padding:3px 0px;" >'.getAlert('et116').'</div>';
				$return = array('result'=>'lees_none', 'name'=>$manager['name'], 'msg'=>$msg);
			}else{
				//삭제된 게시글은 복구할 수 없습니다.<br/> 정말로 삭제하시겠습니까?
				$msg.= '<div style="padding:3px 0px;" >'.getAlert('et117').'</div>';

				if( $less_emoney){
					$return = array('result'=>'lees', 'name'=>$manager['name'], 'msg'=>$msg);
				}else{
					$return = array('result'=>'delete', 'name'=>$manager['name'], 'msg'=>$msg);
				}
			}

			echo json_encode($return);
			exit;
		}

	}
}

/* End of file board_process.php */
/* Location: ./app/controllers/admin/board_goods_process.php */