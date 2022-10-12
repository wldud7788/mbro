<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/crm_base".EXT);

class member_process extends crm_base {

	public function __construct() {
		parent::__construct();
		$this->load->library('validation');


	}

	public function save_memo(){
		$postParams = $this->input->post();

		$memberData['admin_memo'] = $postParams['admin_memo'];

		$this->db->where('member_seq', $this->mdata['member_seq']);
		$result = $this->db->update('fm_member', $memberData);

		$msg = "메모가 수정되었습니다.";
		$callback = "parent.location.reload()";
		openDialogAlert($msg,400,140,'parent',$callback);
		

	}

	public function member_withdrawal(){
		$this->load->model('authmodel');
		$auth = $this->authmodel->manager_limit_act('withdrawal_act');
		if(!$auth){
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}
				
		### Validation
		$this->validation->set_rules('reason', '탈퇴사유','trim|required|xss_clean');
		$this->validation->set_rules('memo', '내용','trim|required|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		###
		$params	= $_POST;
		$params['regist_date']	= date('Y-m-d H:i:s');
		$params['regist_ip']	= $_SERVER['REMOTE_ADDR'];
		if( $this->isdemo['isdemo'] && $member['userid'] == $this->isdemo['isdemoid'] ){
			openDialogAlert($this->isdemo['msg'],500,140,'parent',$callback);
			exit;
		}
		$this->load->library('memberlibrary');
		//회원탈퇴
		$withdrawalMsg = $this->memberlibrary->set_withdrawal($params);
		###
		$callback = "parent.location.reload();";
		openDialogAlert($withdrawalMsg['msg'],400,140,'parent',$callback);
	}

	/**
	 * 예치금 인출 추가
	 * @author pjw 2019-08-23
	 */
	public function cash_withdraw(){

		// 예치금 인출 팝업에서 전달하는 변수
		$params	= $this->input->post();
		// 알림창에 실행할 자바스크립트 콜백 함수
		$callback = '';
		// 필수 값 유효성 체크
		$this->validation->set_rules('member_seq', '고유번호','trim|required|xss_clean');
		$this->validation->set_rules('cash', '인출금액','trim|required|numeric|xss_clean');
		$this->validation->set_rules('reason', '인출사유','trim|required|xss_clean');
		if($params['send_sms'] == 'Y'){
			$this->validation->set_rules('cellphone', '핸드폰번호','trim|required|xss_clean');
			$this->validation->set_rules('msg', '메세지','trim|required|xss_clean');
		}

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		// 예치금 출금 가능한 상태인지 확인 
		$this->load->model('membermodel');
		$aMemberData = $this->membermodel->get_member_data($params['member_seq']);
		if($aMemberData['status'] == 'dormancy' || $aMemberData['status'] == 'withdrawal'){
			openDialogAlert('휴면/탈퇴 회원에게 마일리지 지급/차감 하실 수 없습니다.', 400, 140,'parent');
			exit;
		}
		// 회원 예치금 조회
		$remain_cash = $this->membermodel->get_cash($params['member_seq']);
		// 예치금을 조회하여 인출 가능 금액 확인
		if( $params['cash'] > $remain_cash){
			openDialogAlert('보유 예치금을 초과하였습니다.',400,140,'parent',$callback);
			exit;
		}

		// 계좌 정보 설정
		$account_info = array(
			'bank' => $params['bank'],
			'depositor' => $params['depositor'],
			'account' => $params['account'],
		);
		
		// 예치금 정보 설정
		$cash_info = array(
			'gb' => 'minus',
			'type' => 'withdraw',
			'cash' => $params['cash'],
			'ordno' => '',
			'memo' => "[인출]".$params['reason'],
			'memo_lang' => '',
			'manager_seq' => $this->managerInfo['manager_seq'],
			'account_info' => json_encode($account_info),
		);

		// 예치금 차감 처리
		$this->membermodel->cash_insert($cash_info, $params['member_seq']);

		// 문자 문자 전송
		$sms_result = '';
		if( $params['send_sms'] == 'Y' ){
			// 문자 메세지 인코딩 형식 변환
			$str = trim($params["msg"]);
			$euckr_str = mb_convert_encoding($str,'EUC-KR', 'UTF-8');
			// 문자 길이 체크 단문(SMS)/장문(LMS) 구분
			$len = strlen($euckr_str);
			$sms_type = '';
			$len > 90 ? $sms_type = "LMS":$sms_type = "SMS ";
			
			// 문자 세팅
			$params['msg'] = $str;
			$commonSmsData['member']['phone'] = $params['cellphone'];
			$commonSmsData['member']['params'] = $params;
			// 문자 전송
			$result = commonSendSMS($commonSmsData);

			// 문자 전송 결과 값 설정
			if($result['msg'] == "fail"){
				$result_msg = "%이후에는 문자가 올수 없습니다.<br>예) 30%DC -> 30% DC";
			}else{
				$result_code = $result['code'];
				if($result_code != "0000"){
					if($result_code == "E001"){
						$result_msg = "SMS 인증 정보가 잘못되었습니다.";
					}else{
						$result_msg = $sms_type."발송에 실패했습니다.";
					}
				}else{
					$result_msg = $sms_type."발송에 성공하였습니다.";
				}
			}
			$sms_result = "<br> SMS : ".$result_msg;
		}

		// 결과창 노출
		$callback = "parent.location.reload();";
		openDialogAlert('예치금 인출이 완료되었습니다.'.$sms_result, 400, 140, 'parent', $callback);
	}

}