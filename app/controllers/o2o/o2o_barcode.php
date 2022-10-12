<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class o2o_barcode extends front_base {

	function __construct() {
		parent::__construct();
		$this->load->library('o2o/o2obarcodelibrary');
	}
	
	//바코드 이미지 생성
	public function index(){
		// 바코드 형식에 따라 필요한 값이 달라짐
		$mode = $this->input->get('mode');
		
		if($mode == 'side_menu'){
			$barcode_key = $this->input->get('barcode_key');
			$key = $this->o2obarcodelibrary->encode_barcode_member($barcode_key);
		}elseif($mode == 'coupon_list'){
			// 쿠폰 목록에서 호출 했을 경우
			$download_seq = $this->input->get('d_seq');
			$member_seq = $this->input->get('m_seq');
			$coupon_seq = $this->input->get('c_seq');
			$salt_seq = $this->input->get('s_seq');

			$salt = $this->o2obarcodelibrary->barcode_salt;
			$oct = decoct($download_seq);
			$key = $salt - $oct;
		}
		
		if($key){
			// 인증키 전달
			$this->template->assign('barcode_key',$key);
		}
		
		$file_path = $this->template_path("o2o");
		
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}
	
	public function draw(){
		$key = $this->input->get('key');
		$type = $this->input->get('type');
		$size = $this->input->get('size');
		
		$data['key']	= $key;
		$data['type']	= $type;
		$data['size']	= $size;
		
		$this->o2obarcodelibrary->draw_barcode($data);
	}
	
	public function decode(){
		$key = $this->input->get('key');
		
		echo $this->o2obarcodelibrary->decode_barcode($key);
		exit;
	}
	
	public function decode_member(){
		$key = $this->input->get('key');
		
		echo $this->o2obarcodelibrary->decode_barcode_member($key);
		exit;
	}
	
}