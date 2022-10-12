<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class barcode_process extends admin_base {
	
	public function __construct() {
		parent::__construct();		

		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
	}

	public function index(){
		redirect("/admin/barcode/catalog");		
	}

	// 바코드 일괄등록
	public function set_barcode_data(){
		$this->load->model('barcodemodel');

		$goods_seq					= $_POST['goods_seq'];
		$option_seq					= $_POST['option_seq'];
		$goods_code					= $_POST['goods_code'];
		$is_goods_seq_duplicate		= $_POST['is_goods_seq_duplicate'];
		$option_code				= $_POST['option_code'];
		$callback					= "";
		$popOptions['btn_title']	= '확인';
		$popOptions['btn_class']	= 'btn large';
		$popOptions['btn_action']	= "parent.document.getElementById('barcodeFrm').submit();";

		for($idx=0; $idx<count($goods_seq); $idx++){
			unset($param);
			
			$param = array();
			$param['goods_seq']		= $goods_seq[$idx];
			$param['option_seq']	= $option_seq[$idx];
			$param['goods_code']	= $is_goods_seq_duplicate[$idx] ? null : $goods_code[$idx];
			$param['option_code']	= explode(',', $option_code[$idx]);
			$result	= $this->barcodemodel->set_barcode_data($param);

			if($result['code'] != 200){
				openDialogAlert("바코드 등록이 실패 하였습니다.",400,175,'parent',$callback,$popOptions);
				exit;
			}
		}

		openDialogAlert("바코드 등록을 완료 하였습니다.",400,175,'parent',$callback,$popOptions);
		exit;
	}

	// 바코드 일괄등록 (엑셀)
	public function set_barcode_data_excel(){
		
		if(!preg_match("/^F_SH_/",$this->config_system['service']['hosting_code'])){
			$this->load->model('usedmodel');
			$use_per	= $this->usedmodel->get_used_space_percent();
			if($use_per > 100){
				$callback				= "";
				$popOptions['btn_title']	= '용량추가';
				$popOptions['btn_class']	= 'btn large cyanblue';
				$popOptions['btn_action']	= "window.open('http://firstmall.kr/myshop','_blank')";
				openDialogAlert("용량이 초과되어 상품을 등록 또는 수정할 수 없습니다.<br/>용량 추가를 하시길 바랍니다.",400,175,'parent',$callback,$popOptions);
				exit;
			}
		}

		$this->load->model('barcodeexcel');
		$result = $this->barcodeexcel->upload_excel($_FILES);

		$callback	= "parent.location.reload();";
		openDialogAlert($result['msg'], 400, 180, 'parent', $callback);
		exit;
	}
	
	//바코드 엑셀 다운로드
	public function exceldownload(){
		$this->load->model('barcodeexcel');		
		$this->barcodeexcel->download_excel($this->input->post());
		exit;
	}

	//바코드 엑셀 처리 로그 다운로드
	public function excel_log_download(){
		$this->load->model('barcodeexcel');

		$filename	= $_GET['f'];
		$result		= $this->barcodeexcel->download_log_file($filename);
		if	(!$result['status']){
			openDialogAlert($result['err_msg'], 400, 180, 'parent', '');
			exit;
		}
	}

	//바코드 출력 양식 수정
	public function set_barcode_form(){
		$this->load->model('barcodemodel');
		
		//사용자가 설정한 양식 값을 받아옴
		$form_id         = $_POST['form_id'];
		$margin_top      = $_POST['margin_top'];
		$margin_left     = $_POST['margin_left'];
		$margin_bottom   = $_POST['margin_bottom'];
		$margin_right    = $_POST['margin_right'];
		$code_id         = $_POST['code_id'];
		$use_border      = $_POST['use_border'];
		$use_text        = $_POST['use_text'];
		$use_goods_name  = $_POST['use_goods_name'];
		$use_option_name = $_POST['use_option_name'];
		$use_goods_seq   = $_POST['use_goods_seq'];

		//키 값에 맞는 양식의 기본값을 가져옴
		$print_config	= config_load('barcode', $form_id);
		$barcode_config = config_load('barcode', $code_id);

		//기본값에 받아온 설정값으로 바꿈
		$print_config[$form_id]							= $this->barcodemodel->print_info[$form_id];
		$print_config[$form_id]['margin_top']			= $margin_top;
		$print_config[$form_id]['margin_left']			= $margin_left;
		$print_config[$form_id]['margin_bottom']		= $margin_bottom;
		$print_config[$form_id]['margin_right']			= $margin_right;
		$barcode_config[$code_id]						= $this->barcodemodel->barcode_info[$code_id];
		$barcode_config[$code_id]['use_border']			= $use_border;
		$barcode_config[$code_id]['use_text']			= $use_text;
		$barcode_config[$code_id]['use_goods_name']		= $use_goods_name;
		$barcode_config[$code_id]['use_option_name']	= $use_option_name;
		$barcode_config[$code_id]['use_goods_seq']		= $use_goods_seq;

		//양식을 저장
		config_save('barcode', array( $form_id	=> $print_config[$form_id] ));
		config_save('barcode', array( $code_id	=> $barcode_config[$code_id] ));
		config_save('barcode', array( 'use_form'=>$form_id));
		config_save('barcode', array( 'use_code'=>$code_id));

		echo "<script type='text/javascript'>parent.document.getElementById('barcode_form').submit();</script>";
		exit;
	}

	//바코드 출력 양식 변경
	public function set_printid(){
		$this->load->model('barcodemodel');

		$form_id		= $_GET['form_id'];
		config_save('barcode', array( 'use_form'=>$form_id));
		echo "success";
		exit;
	}

	//바코드 타입 변경
	public function set_barcodeid(){
		$this->load->model('barcodemodel');

		$use_code		= $_POST['use_code'];
		$use_code_order	= $_POST['use_code_order'];
		config_save('barcode', array( 'use_code'		=>	$use_code ));
		config_save('barcode', array( 'use_code_order'	=>	$use_code_order ));
		$callback	= "parent.location.reload();";
		openDialogAlert('바코드 형식이 변경되었습니다.', 400, 180, 'parent', $callback);
		exit;
	}

	//바코드 출력 양식 로딩
	public function load_printinfo(){
		$this->load->model('barcodemodel');

		$form_id		= $_GET['form_id'];
		$print_config	= config_load('barcode', $form_id);
		$form			= $print_config[$form_id];

		echo '{';
		echo '"margin_top" : "'.$form['margin_top'].'" ,';
		echo '"margin_left" : "'.$form['margin_left'].'" ,';
		echo '"margin_bottom" : "'.$form['margin_bottom'].'" ,';
		echo '"margin_right" : "'.$form['margin_right'].'"';
		echo '}';
		exit;
	}

	//바코드 타입 양식 로딩
	public function load_barcodeinfo(){
		$this->load->model('barcodemodel');

		$code_id		= $_GET['code_id'];
		$barcode_config	= config_load('barcode', $code_id);
		$barcode		= $barcode_config[$code_id];

		echo '{';
		echo '"use_border" : "'.$barcode['use_border'].'" ,';
		echo '"use_text" : "'.$barcode['use_text'].'" ,';
		echo '"use_goods_name" : "'.$barcode['use_goods_name'].'" ,';
		echo '"use_option_name" : "'.$barcode['use_option_name'].'",';
		echo '"use_goods_seq" : "'.$barcode['use_goods_seq'].'"';
		echo '}';
		exit;
	}
	
	//바코드 이미지 생성
	public function barcode_image(){
		$this->load->model('barcodemodel');

		$code_type	= $_GET['code_type'] ? $_GET['code_type'] : 'code128';
		$code_value = $_GET['code_value'] ? $_GET['code_value'] : '123456789';
		$code_size	= $_GET['code_size'] ? $_GET['code_size'] : '40';

		$chk_subtype = explode('_', $code_type);
		if(count($chk_subtype) > 1){
			$code_type		= $chk_subtype[0];
			$code_subtype	= 'Start '. strtoupper($chk_subtype[1]);
		}else{
			$code_subtype = null;
		}

		$this->barcodemodel->create_barcode($code_type, $code_subtype, $code_value, $code_size);
	}
}

/* End of file barcode.php */
/* Location: ./app/controllers/admin/barcode.php */