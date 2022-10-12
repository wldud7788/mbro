<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/base/admin_base'.EXT);

class marketing_agree extends admin_base {

	function __construct()
	{
        parent::__construct();

        if (date('H') < '08' || date('H') >= '18') {
            exit;
        }
        
        //error_reporting(E_ALL);
        ini_set("memory_limit",-1);
        set_time_limit(0);
        
        $email = config_load('email');

        if($email["marketing_agree_user_yn"] != 'Y'){
            echo "NO AUTH";
            exit;
        }
        
        $basic              = ($this->config_basic) ? $this->config_basic : config_load('basic');
        $this->mailAddr     = $basic['companyEmail'];
        $this->mailName		= !$basic['shopName'] ? 'http://'.$_SERVER['HTTP_HOST'] : $basic['shopName'];
        $this->mailSubject  = "[".$this->mailName."] 광고성 정보 수신 동의 확인 안내";  
        
    }
    
    public function send()
    {   
        $this->load->model('managermodel');
        $this->load->model('membermodel');
        $sendList = $this->membermodel->get_member_marketing_send();
        
        $updateDatas    = array();
        //$sendList[0]['member_seq'] = 285; //for test
        
        foreach($sendList as $k => $v){
            $res = $this->send_mail($v);
            
            if ($res['result'] == true) {
                $updateDatas[$k]['res'] = "s";
            } else {
                $updateDatas[$k]['res'] = "f";
            }
            
            $sendDate = date('Y-m-d H:i:s');
            $updateDatas[$k]['seq']         = $v['seq'];
            $updateDatas[$k]['send_addr']   = $this->mailAddr;
            $updateDatas[$k]['send_date']   = $sendDate;
            
            usleep(250000); //부하를 줄이기 위해 1초에 4개씩 발송
        }
        
        $updateCount = $this->db->update_batch("fm_marketing_send_log", $updateDatas, 'seq', true); //마지막 param은 escape 여부
        
        if ($updateCount > 0) {
            $log_params                 = array();
            $log_params['gb']           = 'AUTO'; 
            $log_params['total']        = $updateCount; 
            $log_params['from_email']   = $this->mailAddr; 
            $log_params['subject']      = $this->mailSubject; 
            $log_params['contents']     = $res['contents']; 
            $log_params['regdate']      = date('Y-m-d H:i:s'); 
            $this->db->insert('fm_log_email', $log_params);
            
            $this->managermodel->insert_action_history('1', "marketing_agree_send_log", "광고성정보수신안내 메일발송실행 ");
        } else {
            $this->managermodel->insert_action_history('1', "marketing_agree_send_log", "광고성정보수신안내 메일발송실행 - 발송 실패(관리자에게 문의 하세요.)"); 
        }
        
        unset($updateDatas);
    }
    
    function send_mail($params)
    { 
        $memberInfo = $this->membermodel->get_member_data_all($params['member_seq']);

        $marketing_data = array();
        $marketing_data['userid'] = $memberInfo['userid'];
        
        if ($memberInfo['sms'] == 'y') {
            $marketing_data['sms_agree_status'] = '동의';
            $marketing_data['sms_agree_date'] = $memberInfo['update_date'];
        } else {
            $marketing_data['sms_agree_status'] = '거부';
            $marketing_data['sms_agree_date'] = '-';
        }
        
        if ($memberInfo['mailing'] == 'y') {
            $marketing_data['email_agree_status'] = '동의';
            $marketing_data['email_agree_date'] = $memberInfo['update_date'];
        } else {
            $marketing_data['email_agree_status'] = '거부';
            $marketing_data['email_agree_date'] = '-';
        }
        
        $contents = sendMail('', 'marketing_agree', '', $marketing_data);
        $contents = str_replace('\\','',http_src($contents));
         
        $mail = new Mail();
        
        $return = array();
        $return['userid']   = $memberInfo['userid'];
        $return['contents'] = $contents;
        $return['result']   = false;
        
        if (filter_var($params['receive_addr'], FILTER_VALIDATE_EMAIL) != false) {
            $this->email->from($this->mailAddr, $this->mailName);
            $this->email->to($params['receive_addr']);
            $this->email->subject($this->mailSubject);
            $this->email->message($contents);
            $resSend = $this->email->send();
            $this->email->clear();
            
            $return['result']   = $resSend;
        }
        
        return $return;
    }
}
