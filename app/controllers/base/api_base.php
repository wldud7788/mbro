<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Composer load
require_once(ROOTPATH.'vendor/autoload.php');

// RESTful API
use chriskacerguis\RestServer\RestController;

/**
 * Restful API 에서 사용하는 컨트롤러
 * 인증 토큰을 체크하고, 해당 사용자가 권한이 있는지 확인하여 결과를 응답한다.
 * 
 * 2019-11-22
 * @author Sunha Ryu
 */
class api_base extends RestController {
	var $apiTokenInfo;
	
    /**
	 * Class constructor
	 *
	 * @return void
	 */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("jwtmodel");
    }
    
    /**
     * api 에서 사용하는 template path 를 반환한다.
     * @param string $addPath
     * @return string
     */
    public function template_path($addPath=null){
        return (($addPath)?$addPath."/":"").implode('/',$this->uri->rsegments).".html";
    }
    
    /**
     * AccessToken과 권한을 체크한다.
     * @return void
     */
    protected function check($grantTypes = null)
    {
        $check = $this->checkGrant($grantTypes);
        
        if($check['status'] !== parent::HTTP_OK) {
            $status = parent::HTTP_INTERNAL_ERROR;
            
            $response = array();
            $response['success'] = false;
            if(!empty($check['code'])) {
                $response['code'] = $check['code'];
            }

            if(!empty($check['message'])) {
                $response['message'] = $check['message'];
            }
            
            if(!empty($check['status'])) {
                $status = $check['status'];
            }
            
            $this->response($response, $status);
		}
		$this->apiTokenInfo = $check;
		
        return $check['grant'];
    }
    
    
    /**
     * AccessToken을 체크한다.
     * @param string $token : http header Authorization 값
     * @return array
     */
    private function checkToken($token)
    {
        try{
            $payload = $this->jwtmodel->decodeToken($token);
            $payload = (array) $payload;
        } catch(\Exception $e) {
            $err = array();
            $error = $e->getMessage();
            if(!empty($error)) {
                $error = explode("|", $e->getMessage());
                if(count($error)>1) {
                    $err['code'] = $error[0];
                    $err['message'] = $error[1];
                } else {
                    $err['message'] = $error;
                } 
            }
            $err['status'] = $e->getCode();
            if(empty($err['status'])) {
                $err['status'] = parent::HTTP_INTERNAL_ERROR; 
            }
            return array('result'=>false, 'data'=>$err);
        }
        return array('result'=>true, 'data'=>$payload);
        
    }
    
    /**
     * 404 오류 출력
     */
    public function response404($arr = null)
    {
        $res = array(
            'success' => false,
            'code' => "not_found",
            'message' => "요청과 관련된 리소스가 존재하지 않습니다.",
        );
        if(!empty($arr) && !empty($arr['code']) && !empty($arr['message'])) {
            $res = $arr;
        }
        
        $this->response($res, parent::HTTP_NOT_FOUND);
    }
    
    /**
     * 500 오류 출력
     */
    public function response500($arr = null)
    {
        $res = array(
            'success' => false,
            'code' => "internal_server_error",
            'message' => "서버 오류입니다.",
        );
        if(!empty($arr) && !empty($arr['code']) && !empty($arr['message'])) {
            $res = $arr;
        }
        
        $this->response($res, parent::HTTP_INTERNAL_ERROR);
    }
    
    /**
     * 403 권한 오류 출력
     */
    public function response403()
    {
        $this->response(array(
            'success'   =>  false,
            'code'      =>  'not_allowed',
            'message'   =>  '권한이 없습니다.',
        ), parent::HTTP_FORBIDDEN);
    }
    
    
    /**
     * 권한을 체크한다.
     * @param array|string $grantTypes : ["admin":"(PC)관리자", "app":"관리자 송출앱"]
     */
    private function checkGrant($grantTypes)
    {
        // grantTypes이 null인 경우 빈배열로 저장
        if(is_null($grantTypes)) {
			$grantTypes = [];
		}

        if(!is_array($grantTypes)) {
            $grantTypes = array($grantTypes);
        }

        $token = null;
        $result = array();
        
        if(count($grantTypes) > 0) {
            // admin 일시 session을 확인
            if(in_array('admin', $grantTypes)===true) {
                $admin = $this->session->userdata('manager');
                if(!empty($admin) && !empty($admin['manager_seq'])) {
                    $result['status'] = parent::HTTP_OK;
                    $result['grant'] = 'admin';
                    return $result;
                }
            }
            
            /* 일반 쇼핑몰 사용자 확인일 경우 해당 부분에 추가 */
            
            // 그 외에는 Authorization 헤더 확인, ClientId, SecretKey인증 방식
            if(in_array('app', $grantTypes)===true ) {

				$debug['uri_string'] = $this->uri->uri_string;
				$debug['header'] = $this->_head_args['Authorization'];
				$debug['get'] = $this->input->get();
				$debug['post'] = $this->input->post();
				$debug['put'] = $this->put();
				$debug['request'] = $this->request;
				
				writeCsLog($debug, "broadcast" , "api", "hour");
                
                // 헤더에 Authorization 값이 있으면 무조건 체크하여 성공/실패 여부를 반환한다. 
                if(isset($this->_head_args['Authorization'])) {
                    $token = $this->head("Authorization");
					$tokenData = $this->checkToken($token);
					
                    if($tokenData['result']===true) {
                        if(!empty($tokenData['data']['grant_type']) && in_array($tokenData['data']['grant_type'], $grantTypes )=== true) {
                            $result['status'] = parent::HTTP_OK;
							$result['grant'] = $tokenData['data']['grant_type'];
							$result['provider_seq'] = $tokenData['data']['provider_seq'];
							$result['manager_seq'] = $tokenData['data']['manager_seq'];
                            return $result;
                        } else {
                            // Authrization 헤더가 정상적이나 메소드에서 접근이 허용되지 않은 경우
                            unset($tokenData);
                            // 403 not_allowed
                            $tokenData['data']['status'] = parent::HTTP_FORBIDDEN;
                            $tokenData['data']['code'] = 'not_allowed';
                            $tokenData['data']['message'] = '권한이 없습니다.';
                        }
                    }
                    
                    if(!empty($tokenData['data']['code'])) {
                        $result['code'] = $tokenData['data']['code'];
                    }
                    
                    if(!empty($tokenData['data']['message'])) {
                        $result['message'] = $tokenData['data']['message'];
                    }
                    
                    if(!empty($tokenData['data']['status'])) {
                        $result['status'] = $tokenData['data']['status'];
                    }
                    
                    return $result;
                }
            }
            
            // 게스트 권한 추가
            if(in_array('guest', $grantTypes) === true) {
                $result['status'] = parent::HTTP_OK;
                $result['grant'] = 'guest';
                return $result;
            }
        } else {
            $debug['uri_string'] = $this->uri->uri_string;
            $debug['header'] = $this->_head_args['Authorization'];
            $debug['get'] = $this->input->get();
            $debug['post'] = $this->input->post();
            $debug['put'] = $this->put();
            $debug['request'] = $this->request;

            writeCsLog($debug, "common" , "api", "hour");

            // 헤더에 Authorization 값이 있으면 무조건 체크하여 성공/실패 여부를 반환한다. 
            if(isset($this->_head_args['Authorization'])) {
                $token = $this->head("Authorization");
                $token = str_replace('Bearer ', '', $token);

                $tokenData = $this->checkToken($token);

                if($tokenData['result']===true) {
                    $result['status'] = parent::HTTP_OK;
                    return $result;
                }

                if(!empty($tokenData['data']['code'])) {
                    $result['code'] = $tokenData['data']['code'];
                }

                if(!empty($tokenData['data']['message'])) {
                    $result['message'] = $tokenData['data']['message'];
                }

                if(!empty($tokenData['data']['status'])) {
                    $result['status'] = $tokenData['data']['status'];
                }

                return $result;
            }
        }

        // 기본 값은 403 not_allowed
        if(empty($result['status'])) {
            $result['status'] = parent::HTTP_FORBIDDEN;
        }
        if(empty($result['code'])) {
            $result['code'] = 'not_allowed';
        }
        if(empty($result['message'])) {
            $result['message'] = '권한이 없습니다.';
        }
                    
        return $result;
    }
    
}