<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class mshop_process extends front_base {

	public function __construct() {
		parent::__construct();
		$this->load->library('validation');
		$this->load->model("myminishopmodel");
	}

	public function add_myshop(){
		$provider_seq				= trim($_POST['shop_no']);
		if( $_POST['ajax'] ) {  
			$member_seq				= trim($this->userInfo['member_seq']);
			if	(!trim($provider_seq) || !trim($member_seq)){
				$result['result']	= false;
				$result['msg']		= getAlert('et054'); //단골 미니샵 등록에 실패하였습니다.
				echo json_encode($result);
				exit;
			}

			$chk_this_shop	= $this->myminishopmodel->chk_myminishop($member_seq, $provider_seq);
			$result['reg']	= 'on';
			if( $chk_this_shop == 'y' ) {//있으면
				$this->myminishopmodel->delete_myshop($member_seq, $provider_seq);
				$result['reg']	= 'off';
			}else{//없으면
				$_POST['seq'] = $this->userInfo['member_seq'];
				$this->myminishopmodel->add_myminishop(); 
			}
			
			$result['result']	= true; 
			echo json_encode($result); 
		}else{
			$member_seq				= trim($_POST['seq']);
			//메모
			$this->validation->set_rules('memo', getAlert('et055'),'trim|max_length[50]|xss_clean');
			if($this->validation->exec()===false){
				$callback = "if(parent.document.getElementsByName('memo')[0]) parent.document.getElementsByName('memo')[0].focus();";
				//메모는 50자이내로 입력해 주세요.
				$text = getAlert('et056');
				openDialogAlert($text,300,140,'parent',$callback);
				exit;
			}

			if	(!trim($provider_seq) || !trim($member_seq)){
				$callback	= "parent.window.close();";
				$text		= getAlert('et054'); //단골 미니샵 등록에 실패하였습니다.
				openDialogAlert($text,300,140,'parent',$callback);
				exit;
			}
			$this->myminishopmodel->add_myminishop();  
			$callback	= "parent.addok();";
			$text		= getAlert('et057'); //등록되었습니다.
			openDialogAlert($text,300,140,'parent',$callback);
			exit;
		}
	}


	public function delete_myshop(){
		$getData = $this->input->get();
		
		$mseq = $getData['mseq'];
		$pseq = $getData['shopno'];

		$result['result'] = 'fail';
		
		$processFlag = true;

		if ($mseq !== $this->userInfo['member_seq']) {
			$processFlag = false;
		}

		if ($this->myminishopmodel->chk_myminishop($mseq, $pseq) === 'n') {
			$processFlag = false;
		}

		if ($processFlag === true && $mseq && $pseq) {
			$this->myminishopmodel->delete_myshop($mseq, $pseq);
			$result['result']	= 'ok';
		}

		echo json_encode($result);
	}

	public function save_memolist(){ 
		$member_seq				= trim($_POST['mseq']);
		$memo					= $_POST['memo'];
		$params['member_seq']	= $member_seq;
		if	($member_seq && count($memo) > 0){
			foreach($memo as $provider_seq => $memo_str){
				if	($provider_seq){
					$params['provider_seq']	= $provider_seq;
					$params['memo']			= $memo_str;
					$this->myminishopmodel->update_myshop_memo($params);
				}
			}
		} 
		$callback	= "parent.location.reload();";
		$text		= getAlert('et058'); //수정되었습니다.
		openDialogAlert($text,300,140,'parent',$callback);
		exit;
	}
}