<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

abstract class api_base extends CI_Controller {
	protected $response_data = array('result'=>'400','msg'=>'API 요청 실패','data'=>null);
	protected $encKey = null;
	protected $toeknExprie = null;
	protected $allowMethod = array('getToken'=>array(self::GET_METHOD));
	protected $api_validation = array();
	protected $authorization;
	protected $auth_text;

	// 메소드 상수
	const GET_METHOD = "GET";
	const POST_METHOD = "POST";
	const PUT_METHOD = "PUT";
	const HEAD_METHOD = "HEAD";
	const DELETE_METHOD = "DELETE";
	const PATCH_METHOD = "PATCH";
	const OPTIONS_METHOD = "OPTIONS";

	public function  __construct() {
		// error_reporting(E_ALL);//0 E_ALL E_ERROR|E_PARSE
		parent::__construct();

		// 캐시 드라이버를 로드하고, 사용하는 드라이버로 APC를 지정하고, APC를 사용할 수 없는 경우 파일 기반 캐싱으로 대체
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

		$this->load->helper('basic');
		$this->load->helper('common');
		$this->load->model('o2o/apilogmodel');

		get_base_config_system();
	}

	// API 초기화
	protected function init(){
		// 통신 로그 생성
		$this->makeApiLog('req', array('result'=>'200','msg'=>'API 요청','data'=>null));

		// 허가 메소드 확인 및 필수 파라미터 체크
		$this->checkMethodValidation();

		// 토큰 체크
		$this->checkToken();
	}

	// 토큰 발행 추상 클래스 정의.
	abstract public function getToken();

	// 토큰 만료 및 정상 여부 확인
	abstract public function checkToken();

	// 허가 메소드 확인 및 필수값 체크 및 파라미터 수신
	protected function checkMethodValidation(){
		// 허가 메소드 확인
		if(empty($this->allowMethod)
			|| empty($this->allowMethod[$this->router->method])
			|| !in_array($this->input->method(TRUE), $this->allowMethod[$this->router->method])){
			$this->throwTokenAuthError(1,'허가 메소드 없음'.$this->input->method(TRUE));
		}
		// 필수값 체크
		if(!empty($this->api_validation) && !empty($this->api_validation[$this->router->method])){
			foreach($this->api_validation[$this->router->method] as $key => $validParam){
				$this->checkArrayValidation($key, $validParam);
			}
		}
	}

	protected function checkArrayValidation($key, $validParam){
		if(is_array($validParam)){
			$get_val = $this->input->get($key);
			$post_val = $this->input->post($key);
			$this->checkStringValidation($key, $get_val, $post_val);

			$arr_check_val = ($post_val)?$post_val:$get_val;
			if(is_array($arr_check_val)){
				foreach($arr_check_val as $val_key => $check_val){
					foreach($validParam as $subValidParam){
						$this->checkStringValidation($key."[".$val_key."]"."[".$subValidParam."]", $check_val[$subValidParam]);
					}
				}
			}else{
				$this->throwVaildationError($key);
			}
		}else{
			$get_val = $this->input->get($validParam);
			$post_val = $this->input->post($validParam);
			$this->checkStringValidation($validParam, $get_val, $post_val);
		}
	}

	protected function checkStringValidation($key, $param1, $param2=null){
		// 0 값을 입력받을 수 있도록 변경
		if(
			(empty($param1) && empty($param2))
			&& ($param1!='0' && $param2!='0')
			){
			$this->throwVaildationError($key);
		}
	}

	// 인증 만료 처리
	protected function throwTokenExpireError($idx=null){
		$this->output->set_status_header('401');
		$this->response('99',(($idx)?'['.$idx.']':'').'인증 만료');
	}

	// 인증 실패 처리
	protected function throwTokenAuthError($idx=null,$msg='인증 실패'){
		$this->output->set_status_header('401');
		$this->response('401',(($idx)?'['.$idx.']':'').$msg);
	}

	// 필수값 누락
	protected function throwVaildationError($valid=null){
		$this->output->set_status_header('409');
		$this->response('409','필수값이 누락되었습니다.'.((!empty($valid))?"[".$valid."]":""));
	}
	// 예외처리
	protected function throwException($idx=null,$msg='관리자에게 문의해주세요.'){
		$this->output->set_status_header('500');
		$this->response('500',(($idx)?'['.$idx.']':'').$msg);
	}

	// 결과 생성 & 출력
	protected function response($result='0',$msg='',$data=null){
		$this->responseMake($result, $msg, $data);
		$this->responseWrite();
	}

	// 결과 생성
	protected function responseMake($result='0',$msg='',$data=null){
		$this->response_data['result'] = "".$result;
		$this->response_data['msg'] = $msg;
		$this->response_data['data'] = $data;
	}

	// 로그 생성
	protected function makeApiLog($mode='req', $response_data=null){
		if(empty($response_data)){
			$response_data = $this->response_data;
		}
		$this->apilogmodel->insert_api_log($this->auth_text, $mode, $response_data);
	}

	// 결과 출력
	protected function responseWrite(){
		// 통신 로그 생성
		$this->makeApiLog('res');
		echo json_encode($this->response_data, JSON_UNESCAPED_UNICODE); // 유니코드 인코딩 제거
		exit;
	}
}
?>