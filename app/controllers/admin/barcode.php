<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class barcode extends admin_base {
	

	public function __construct() {
		parent::__construct();

		$this->load->helper('goods');
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$this->template->define(array('barcode_info_popup' => $this->skin.'/barcode/_barcode_info_popup.html'));
		$this->template->define(array('tpl'=>$file_path));
	}

	public function index(){
		redirect("/admin/barcode/catalog");		
	}

	// 바코드 출력 리스트
	public function catalog(){		
		$this->load->model('barcodemodel');

		//상품 데이터를 가져옴
		$sc = $this->input->get();
		$listdata  = $this->barcodemodel->get_goods_list($sc);
		//창고 데이터를 가져옴
		$storedata = $this->barcodemodel->getstorelist($listdata['goods_seq_list'], $listdata['option_seq_list']);

		foreach($listdata['record'] as $key=>$val){
			$row = $listdata['record'][$key];
			$row['storage'] = array();
			
			foreach($storedata as $skey=>$sval){
				$tmp_row = $storedata[$row['goods_seq']][$row['option_seq']];
				$row['storage'][$skey]['ea']		= $tmp_row['ea'] ? $tmp_row['ea'] : 0;				//상품의 재고
				$row['storage'][$skey]['bad_ea']	= $tmp_row['bad_ea'] ? $tmp_row['bad_ea'] : 0;		//상품의 불량재고
				$row['total_ea']				   = $tmp_row['ea'] ? $tmp_row['ea'] : 0;									//상품의 총 재고 수					
				$row['total_bad_ea']			   = $tmp_row['bad_ea'] ? $tmp_row['bad_ea'] : 0;								//상품의 총 불량재고 수					
			}
			
			$row['prefix'] = $storedata[$row['goods_seq']][$row['option_seq']]['prefix'];
			$row['suffix'] = $storedata[$row['goods_seq']][$row['option_seq']]['suffix'];

			$listdata['record'][$key] = $row;
		}
		
		//바코드 출력 양식, 타입 가져옴
		$barcode_config	= $this->barcodemodel->get_barcode_info();
		$use_code		= $barcode_config[$barcode_config['use_code']];
		$use_code_order	= $barcode_config[$barcode_config['use_code_order']];

		$checked['search_field'][$sc['search_field']] = "selected";
		$checked['gtype'][$sc['gtype']] = "selected";
		$checked['btype'][$sc['btype']] = "checked";
		$checked['bsubtype1'][$sc['bsubtype1']] = "selected";
		$checked['bsubtype2'][$sc['bsubtype2']] = "selected";

		if(!$sc['sort']) {
			$sc['sort'] = 'desc_goods_seq';
		}

		$this->template->assign(array('use_code'		=>$use_code));
		$this->template->assign(array('use_code_order'	=>$use_code_order));
		$this->template->assign(array('listdata'		=>$listdata['record']));
		$this->template->assign(array('sc'=>$sc,'scObj'=>json_encode($sc)));
		$this->template->assign('page',$listdata['page']);	
		$this->template->assign(array('checked'			=>$checked));

		// 상품검색폼
		$this->template->define(array('barcode_search_form' => $this->skin.'/barcode/barcode_search_form.html'));		
		$this->template->print_("tpl");
	}
	
	// 바코드 일괄등록
	public function barcode_write(){
		$this->load->model('barcodemodel');
		
		//상품 데이터를 가져옴
		$sc = count($this->input->post()) > 0 ? $this->input->post() : $this->input->get();
		$listdata  = $this->barcodemodel->get_goods_list($sc);
		
		//상품코드 중복 등록 방지
		$tmp_dupl = array();
		foreach($listdata['record'] as $key=>$val){
			if(in_array($val['goods_seq'], $tmp_dupl)){
				$listdata['record'][$key]['is_goods_seq_duplicate'] = true;
			}else{
				$tmp_dupl[] = $val['goods_seq'];
			}
		}
		
		
		$checked['search_field'][$sc['search_field']] = "selected";
		$checked['gtype'][$sc['gtype']] = "selected";
		$checked['btype'][$sc['btype']] = "checked";
		$checked['bsubtype1'][$sc['bsubtype1']] = "selected";
		$checked['bsubtype2'][$sc['bsubtype2']] = "selected";

		$this->template->assign(array('listdata'		=>$listdata['record']));
		$this->template->assign(array('sc'=>$sc,'scObj'=>json_encode($sc)));
		$this->template->assign('page',$listdata['page']);	
		$this->template->assign(array('checked'			=>$checked));

		// 상품검색폼
		$this->template->define(array('barcode_search_form' => $this->skin.'/barcode/barcode_search_form.html'));		
		$this->template->print_("tpl");
	}

	// 바코드 일괄등록 (엑셀)
	public function barcode_write_excel(){
		$this->load->model('barcodeexcel');

		// 업로드 로그 추출 ( 최근 5건 )
		$sc['elimit']	= 10;
		$logs			= $this->barcodeexcel->get_excel_upload_log($sc);	
		
		$this->template->assign(array("logs" => $logs));
		$this->template->print_("tpl");
	}

	//바코드 출력팝업
	public function barcode_print(){
		if(!$this->authmodel) $this->load->model('authmodel');
		$auth = $this->authmodel->manager_limit_act('goods_act');
		if(!$auth){
			pageClose($this->auth_msg);
			exit;
		}

		$this->load->model('barcodemodel');

		$requestPost = $this->input->post();

		$goodsSeqList = null;
		$optionSeqList = null;
		//선택 출력일 경우 선택한 상품번호를 받아옴
		if ( 
			$requestPost['mode'] =='select' &&
			is_array($requestPost['goods_seq']) === true
		) {	
			foreach($requestPost['goods_seq'] as $row){
				$tmp_token			= explode('|', $row);
				$tmp_goods_seqs[]	= $tmp_token[0];
				$tmp_option_seqs[]	= $tmp_token[1];
			}
			
			$goodsSeqList = $tmp_goods_seqs;
			$optionSeqList = $tmp_option_seqs;
		}

		//출력 양식 설정
		$barcode_config	= $this->barcodemodel->get_barcode_info();
		$use_form		= $barcode_config['use_form'];
		$use_code		= $barcode_config['use_code'];
		$print_info		= $barcode_config[$use_form];
		$barcode_info	= $barcode_config[$use_code];

		$print_cells	= $print_info['cellcount'] * $print_info['rowcount'];

		//상품 데이터를 가져옴
		$goodsParams = [
			//출력 구분 파라미터
			'is_print' => true,
			'print_config' => $print_info,
			'goods_seq_list' => $goodsSeqList,
			'option_seq_list' => $optionSeqList,
			'mode' => $requestPost['mode'],
			'goods_seq' => $requestPost['goods_seq'],
			'goods_stock' => $requestPost['goods_stock'],
			'print_start_num' => $requestPost['print_start_num'],
			'print_page_cnt' => $requestPost['print_page_cnt'],
			'perpage' => $requestPost['perpage'],
			'gtype' => $requestPost['gtype'],
			'btype' => $requestPost['btype'],
			'bsubtype1' => $requestPost['bsubtype1'],
			'bsubtype2' => $requestPost['bsubtype2'],
			'search_type' => $requestPost['search_type'],
			'keyword' => $requestPost['keyword'],
			'sort' => $requestPost['sort'],
		];
		$listdata  = $this->barcodemodel->get_goods_list($goodsParams);
		
		//현재 설정 된 바코드 타입
		$origin_code_type = $barcode_info['id'];			
		$chk_subtype = explode('_', $origin_code_type);
		if(count($chk_subtype) > 1){
			$code_type		= $chk_subtype[0];
			$code_subtype	= 'Start '. strtoupper($chk_subtype[1]);
		}else{
			$code_type		= $origin_code_type;
			$code_subtype	= null;
		}
		
		//바코드 타입 별 유효성 검사
		$size = 40;
		foreach($listdata['record'] as $key=>$val){
			$listdata['record'][$key]['goods_name'] = strip_tags($val['goods_name']);
			$code_val = $val['goods_code'].$val['option_code'];		
			
			if($val['goods_code'] != '' || $val['option_code'] != ''){
				if($this->barcodemodel->validate_barcode('isbn', $code_subtype, $code_val)){
					$barcode_img = '<img src="/admin/barcode_process/barcode_image?code_type=isbn&code_value='.$code_val.'&code_size='.$size.'" />';
				}else if($this->barcodemodel->validate_barcode($code_type, $code_subtype, $code_val)){
					$barcode_img = '<img src="/admin/barcode_process/barcode_image?code_type='.$origin_code_type.'&code_value='.$code_val.'&code_size='.$size.'" />';
				}else{
					$barcode_img = '<p style="margin: 5px; color: red">바코드 형식이 맞지 않습니다.</p>';
					$listdata['barcode_fail_count']++;
				}
			}else{
				$barcode_img = '<p style="margin: 5px; color: red">코드 정보가 없습니다.</p>';
			}

			$listdata['record'][$key]['barcode_img'] = $barcode_img;
		}		

		//선택 출력 시 출력 시작위치 select 박스
		$print_start_num = $requestPost['print_start_num'] ? $requestPost['print_start_num'] : 1;
		$print_start_sel = '<select id="print_start_num" name="print_start_num">';
		for($i = 1; $i <= $print_cells; $i++ ){
			$con = $print_start_num == $i ? 'selected="selected"' : '';
			$print_start_sel .= '<option value="'.$i.'" '.$con.'>'.$i.'</option>';
		}		
		$print_start_sel .= '</select>';

		//바코드 개당 출력 할 개수
		$print_page_cnt = $requestPost['print_page_cnt'] ? $requestPost['print_page_cnt'] : 1; 
		
		//총 출력 될 페이지 수
		$total_page = ceil(count($listdata['record']) / $print_cells);

		$this->template->assign(array('barcodeprint'		=> count($listdata['record'])));
		$this->template->assign(array('print_start_num' => $print_start_sel));
		$this->template->assign(array('mode'			=> $requestPost['mode']));
		$this->template->assign(array('listdata'		=> $listdata['record']));
		$this->template->assign(array('print_info'		=> $print_info));
		$this->template->assign(array('barcode_info'	=> $barcode_info));
		$this->template->assign(array('print_page_cnt'	=> $print_page_cnt));
		$this->template->assign(array('total_print_cell'=> $print_cells));
		$this->template->assign(array('total_page'		=> $total_page));
		$this->template->assign(array('perpage'			=> $listdata['perpage']));
		$this->template->assign(array('goods_seq_list'	=> implode(',', $listdata['goods_seq_list'])));
		$this->template->assign(array('option_seq_list'	=> implode(',', $listdata['option_seq_list'])));
		$this->template->assign(array('goods_stock'		=> implode(',', $listdata['goods_stock'])));
		$this->template->assign(array('gtype'			=> $listdata['gtype']));		
		$this->template->assign(array('btype'			=> $listdata['btype']));		
		$this->template->assign(array('bsubtype1'		=> $listdata['bsubtype1']));	
		$this->template->assign(array('bsubtype2'		=> $listdata['bsubtype2']));	
		$this->template->assign(array('keyword'			=> $listdata['keyword']));	
		$this->template->assign(array('search_type'		=> $listdata['search_type']));	
		$this->template->assign(array('barcode_fail_count'=> $listdata['barcode_fail_count']));
		$this->template->print_("tpl");
	}

}

/* End of file barcode.php */
/* Location: ./app/controllers/admin/barcode.php */