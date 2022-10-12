<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 비디오커머스 알림 전송
 * 2019-12-13
 */
class noti
{
    private $logFile;
    public $ci;
    
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        $this->ci = &get_instance();
        
        $this->ci->load->library('batchLib');
        $this->ci->load->helper('basic');
        $this->ci->load->helper('common');
        $this->ci->load->model('broadcastmodel');
        $this->ci->load->model('membermodel');
    }
    
    /**
     * 해당 방송의 알림을 발송한다.
     * @param int $bsSeq : 편성표 번호
     * @return array : ('total' => 총 건수, 'succ' => 발송 건수, 'fail' => 실패 건수, 'reason' => 실패사유)
     */
    public function noti($bsSeq)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        
        // 발송 결과
        $res = array(
            'reason' => array(),
            'succ' => 0,
            'fail' => 0,
            'total' => 0,
        );
            
        // succ : 발송 대상 / fail : 발송 대상이 아닌 건
        $notiSeqs = array('succ'=>array(), 'fail'=>array());
        
        $this->logFile = "broadcastBatch_noti_".date("Ym") . ".log";
        $this->ci->batchlib->_cronFileLog($this->logFile, 'Start');
        
        try {
            // $this->db->trans_begin();
            $key = get_shop_key();
            
            $notiData = $this->ci->broadcastmodel->getBroadcastNoti(
                array('bs_seq'=>$bsSeq, 'send_type' => null, 'send_time'=>null),
                "bn.seq, bn.member_seq, bn.contact_num, AES_DECRYPT(UNHEX(m.cellphone), '{$key}') as cellphone"
                );
            
            $res['total'] = count($notiData);
            if($res['total']>0) {
                // 발송 데이터
                $commonSmsData  = array('live_noti'=>array('phone'=>array(), 'params'=>array()));
                
                // 방송정보 데이터
                $params = $this->getNotiParams($bsSeq);
                
                // 발송중으로 상태 변경
                $this->ci->broadcastmodel->updateBroadcastNoti(array('send_type'=>'ing'), array('bs_seq'=>$bsSeq));
                
                foreach($notiData as $notiRow) {
                    $phone = null;
                    // 회원 주문건
                    if(!empty($notiRow['cellphone'])) {
                        $phone = $notiRow['cellphone'];
                    } else { // 비회원 주문건
                        $phone = $notiRow['contact_num'];
                    }
                    $phone = preg_replace("/[^0-9]/", "", $phone);
                    
                    if(!empty($phone)) {
                        $commonSmsData['live_noti']['phone'][] = $phone;
                        $commonSmsData['live_noti']['params'][] = $params;
                        $notiSeqs['succ'][] = $notiRow['seq'];
                    } else {
                        $notiSeqs['fail'][] = $notiRow['seq'];
                    }
                }
                
                if(count($commonSmsData['live_noti']['phone']) > 0){
                    /**
                     * 발송
                     */
                    $result = commonSendSMS($commonSmsData);
                    $updateData = array();
                    
                    // 발송 성공
                    if($result['code'] == "0000") {
                        if($result['kakao'] === 'OK') { // 카카오톡 발송
                            $updateData['send_type'] = 'kakao';
                        } else { // SMS 발송
                            $updateData['send_type'] = 'sms';
                        }
                        $res['succ'] += count($notiSeqs['succ']);
                    } else { // 발송 실패
                        $updateData['send_type'] = 'fail';
                        $updateData['reason'] = "발송 오류로 발송 실패"; 
                        
                        $res['fail'] += count($notiSeqs['succ']);
                        $res['reason'][] = $updateData['reason'];
                    }
                    $updateData['send_time'] = date("Y-m-d H:i:s");
                    $updateRes = $this->ci->broadcastmodel->updateBroadcastNoti($updateData, array('seq'=>$notiSeqs['succ']));
                    $this->ci->batchlib->_cronFileLog($this->logFile, 'Result - ' . print_r($updateRes, true));
                    // 발송 성공건 update
                    $notiSeqs['succ'] = array();
                } else {
                    throw new Exception("방송 알림 대상 회원이 존재하지 않습니다.");
                }
                
            } else {
                throw new Exception("방송 알림 신청 건이 없습니다.");
            }
        } catch (Exception $e) {
            // $this->db->trans_rollback();
            $this->ci->batchlib->_cronFileLog($this->logFile, 'Error - ' . $e->getMessage());
            
            // 총 건수
            $res['total'] = 0; 
            // 성공 건수
            $res['succ'] = 0;
            // 실패 건수
            $res['fail'] = count($notiSeqs['succ']) + count($notiSeqs['fail']);
            // 실패 사유
            $res['reason'] = $e->getMessage();
            return $res;
        }
        
        /*if ($this->db->trans_status() === false) {
         $this->db->trans_rollback();
         }
         else {
         $this->db->trans_commit();
         }*/
        
        
        // 미 업데이트건이 남아있다면 모두 fail로 처리
        $errUpdateData['send_time'] = date("Y-m-d H:i:s");
        $errUpdateData['send_type'] = 'fail';
        if(count($notiSeqs['succ'])>0) {
            $res['fail'] += count($notiSeqs['succ']);
            $errUpdateData['reason'] = "서버 오류로 발송 실패";
            $res['reason'][] = $errUpdateData['reason'];
            $this->ci->broadcastmodel->updateBroadcastNoti($errUpdateData, array('seq'=>$notiSeqs['succ']));
        }
        if(count($notiSeqs['fail'])>0) {
            $errUpdateData['reason'] = "연락처 오류로 발송 실패";
            $res['fail'] += count($notiSeqs['fail']);
            $res['reason'][] = $errUpdateData['reason'];
            $this->ci->broadcastmodel->updateBroadcastNoti($errUpdateData, array('seq'=>$notiSeqs['fail']));
        }
        
        $this->ci->batchlib->_cronFileLog($this->logFile, 'End');
        
        // 실패 사유
        $res['reason'] = implode($res['reason'], ", ");
        return $res;
    }
    
    /**
     * 방송 알림용 파라미터를 반환한다.
     * @param int $bsSeq
     * @throws Exception
     */
    private function getNotiParams($bsSeq)
    {
        $params = array();
        
        // 쇼핑몰 이름 (설정 > 일반정보)
        if(empty($this->ci->config_basic)) {
            $this->ci->config_basic = config_load('basic');
        }
        $params['shopName']				= $this->ci->config_basic['shopName'];
        
        // 라이브 방송일자
        $this->ci->load->model("broadcastmodel");
        $sch = $this->ci->broadcastmodel->getSch(array('bs_seq'=>$bsSeq));
        if(empty($sch)) {
            throw new Exception("방송이 존재하지 않습니다.");
        }
        $sch = reset($sch);
        $startDateObj = new DateTime($sch['start_time'], new DateTimeZone('Asia/Seoul'));
        // 월일년
        $params['liveDate'] = $startDateObj->format("Y.m.d");
        // 요일
        $week = $startDateObj->format("D");
        $week = substr($week, 0, 2);
        $week = strtolower($week);
        $this->ci->lang->load("calendar_lang", "korean");
        $week = $this->ci->lang->line("cal_" . strtolower($week));
        if(!empty($week)) {
            $params['liveDate'] .= " ({$week})";
        }
        
        // 라이브 방송시간
        $endDateObj = new DateTime($sch['end_time'], new DateTimeZone('Asia/Seoul'));
        $params['liveTime'] = $startDateObj->format("H:i")."~".$endDateObj->format("H:i");
        return $params;
    }
}