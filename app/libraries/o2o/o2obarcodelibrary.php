<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once(APPPATH ."libraries/o2o/o2oconfiglibrary".EXT);

Class o2obarcodelibrary extends o2oconfiglibrary
{
	public function __construct() {
		parent::__construct();
	}
	
	public function send_barcode($member_seq){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$key = $this->encode_barcode_member($member_seq);
		
		// 문구 초기화
		$sendMsgLink = $this->CI->config_system['domain']."/o2o/o2o_barcode/draw?key=".$key;
		$sendMsg = "{shopname} \n바코드는 마이페이지에서도 확인 가능합니다.\n[바코드 확인]\n".$sendMsgLink;
		$sendMsg	= str_replace("{shopname}", $this->CI->config_basic['shopName'], $sendMsg);

		$params['msg'] = trim($sendMsg);
		$commonSmsData['member']['phone'] = $phone;
		$commonSmsData['member']['params'] = $params;

		$result = commonSendSMS($commonSmsData);
	}
	
	// 바코드 출력
	public function draw_barcode($data){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		$this->CI->load->model('barcodemodel');

		$code_value = $data['key'];
		$code_type	= ($data['type'])?$data['type']:$this->barcode_type;
		$code_size	= ($data['size'])?$data['size']:$this->barcode_size;
		
		if(empty($code_value)) exit;
		$code_value = $code_value;
		
		$chk_subtype = explode('_', $code_type);
		if(count($chk_subtype) > 1){
			$code_type		= $chk_subtype[0];
			$code_subtype	= 'Start '. strtoupper($chk_subtype[1]);
		}else{
			$code_subtype = null;
		}

		$this->CI->barcodemodel->create_barcode($code_type, $code_subtype, $code_value, $code_size);
		
	}
	
	// 바코드를 고유키로 변경
	function decode_barcode($barcode){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		$key = 0;
		
		$salt = $this->barcode_salt;
		
		$oct = $salt - $barcode;
		$key = octdec($oct);
		return $key;
	}
	
	// 바코드를 고유키로 변경
	function decode_barcode_member($barcode){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		$key = 0;
		
		$salt = $this->barcode_salt_member;
		
		$oct = $salt - $barcode;
		$key = octdec($oct);
		return $key;
	}
	
	// 고유키 바코드를  변경
	function encode_barcode_member($member_seq){
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$salt = $this->barcode_salt_member;
		$oct = decoct($member_seq);
		$key = $salt - $oct;
		
		return $key;
	}
	
}