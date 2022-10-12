<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

/* 리얼 패킹 프로세스
 * 2016.09.08 pjw
 */
class realpacking_process extends admin_base {
	public function __construct() {
		parent::__construct();		
	}

	// refresh_token 갱신
	public function refresh(){
		try{
			// 리얼패킹 토큰 정보 및 API 파라미터 세팅
			$real_config					= config_load('realpacking');
			$real_config['service_info']	= get_object_vars(json_decode($real_config['service_info']));	
			$data	= array(
				"grant_type"	=> "refresh_token",
				"refresh_token" => $real_config['service_info']['refresh_token']
			);

			// 리얼패킹 refresh_token 갱신 API 호출
			$ch				= curl_init();
			curl_setopt ($ch, CURLOPT_USERPWD, $real_config['service_info']['client_id'].":".$real_config['service_info']['client_secret']);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_HEADER, 0);
			curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt ($ch, CURLOPT_URL, get_connet_protocol().'www.realpacking.com/dev_lab/oauth2/token.php');
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
			$result			= curl_exec($ch);
			
			// 결과값 파싱 후 저장
			$service_info	= get_object_vars(json_decode($result));
			$real_config['service_info']['access_token']  = $service_info['access_token'];
			$real_config['service_info']['refresh_token'] = $service_info['refresh_token'];
			config_save('realpacking', array("service_info" => json_encode($real_config['service_info'])));
			
			echo $result;
		}catch(Exception $e){
			echo '';
		}
		exit;
	}
}