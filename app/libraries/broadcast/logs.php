<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 비디오 커머스 로그 데이터를 데이터베이스에 삽입하기 위해 만든 라이브러리
 * @author Sunha Ryu
 * 2019-11-25
 */
class logs
{    
    private $ci;
    private $fields = array('provider_seq', 'manager_seq', 'log_type', 'action', 'device' ,'memo', 'detail','info');
    private $params = array();
    
    /**
     * Class Constructor.
     * 
     * @param object $object
     * @return void
     */
    public function __construct($params)
    {
        $this->ci = &get_instance();
        foreach( $this->fields as $field ) {
            if(!empty($params[$field])) {
                $this->params[$field] = $params[$field];
            }
        }
        $this->init();
    }
    
    /**
     * ip, request_uri 글로벌 변수를 대입한다.
     * @return void
     */
    private function init()
    {
        if(empty($this->params['detail'])) {
            $this->params['detail'] = serialize($this->ci->input->server());
        }
        if(empty($this->params['ip'])) {
            $this->params['ip'] = $this->ci->input->server('REMOTE_ADDR');
        }
    }
    
    /**
     * Logging
     * @param string $action : ['apply','regist','hold','reject','create','delete','live','end','on','off','modify']
     * @return boolean
     */
    public function logging($action, $bs_seq)
    {
        if(!in_array($action, array('apply','regist','hold','reject','create','delete','live','end','on','off','modify','cancel','callback','disconnect'))) {
            return false;
        }
        
        if(empty($bs_seq)) {
            return false;
		}

		// $action : 'approval' - 승인, 'status' - 상태,'modify' - 상태/노출외데이터수정,'display' - 노출
		
		// 로그 타입
		if(in_array($action, array('apply','regist','hold','reject'))) {
			$log_type = 'approval';		// 승인
		} else if(in_array('on','off')) {
			$log_type = 'display';		// 노출
		} else if($action =='modify'){
			$log_type = 'modify';		// 수정
		} else {
			$log_type = 'status';		//상태
		}
        
		$params = $this->params;
        $params['action'] = $action;
		$params['bs_seq'] = $bs_seq;
		$params['log_type'] = $log_type;
		$params['regist_date'] = date("Y-m-d H:i:s");
		
        return $this->ci->db->insert("fm_broadcast_log", $params);
    }
    
    
}
