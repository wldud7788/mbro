<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/common_base".EXT);

/* 리얼 패킹 연동 API (리얼패킹 => 퍼스트몰)
 * 2016.09.08 pjw
 */
class realpacking extends common_base {
	public function __construct() {
		parent::__construct();		
	}
	
	// 서비스 정보 업데이트
	public function service_info_update(){
		// 필수 파라미터
		$filter_param = array('u','client_id','client_secret','access_token','refresh_token');
		$config_real  = array();
		
		// 파라미터 검사
		foreach($filter_param as $filter){
			if(!$_POST[$filter]){
				$result = array(
					"code"				=> false,
					"result_code"		=> 400,
					"result_msg"		=> "Parameter can't be empty."
				);
				echo json_encode($result);
				exit;
			}else{
				$config_real[$filter] = $_POST[$filter];
			}
		}
		
		// config에 파라미터 저장
		config_save('realpacking', array(
			'service_info' => json_encode($config_real),
			'use_service'  => 'Y'
		));
		$result = array(
			"code"				=> true,
			"result_code"		=> 200,
			"result_msg"		=> "Success"
		);
	
		echo json_encode($result);
		exit;
	}
	
	// 주문 정보 조회
	public function get_order_list(){
		// 필수 파라미터 
		$filter_param = array('start_date','end_date');
		$config_real  = array();
		
		// 파라미터 검사
		foreach($filter_param as $filter){
			if(!$_POST[$filter]){
				$result = array(
					"code"				=> false,
					"result_code"		=> 400,
					"result_msg"		=> "Parameter can't be empty."
				);
				echo json_encode($result);
				exit;
			}
		}
		
		// 검색 값 세팅
		$sc	= array();
		foreach($_POST as $key=>$val){
			$sc[$key] = addslashes(trim($val));
		}		

		// 데이터 조회
		$this->load->model('exportmodel');
		$datalist	= $this->exportmodel->get_export_info($sc);
		
		echo json_encode($datalist);
		exit;
	}
}