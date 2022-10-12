<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class excel_spout extends selleradmin_base {

	public $aCategory = array(
			1 => "goods",
			2 => "order",
			4 => "export"
		);

	public $aCategoryKR = array(
			1 => "상품",
			2 => "주문",
			4 => "출고"
		);

	public $aState = array(
			0 => "대기중",
			1 => "진행중",
			2 => "완료"
		);

	public $excel_type_list = array(
				'search'		=> '검색',
				'select'		=> '선택',
				'search_order'	=> '주문별 검색',
				'search_item'	=> '상품별 검색',
				'search_export'	=> '출고번호별 검색',
				'select_order'	=> '주문별 선택',
				'select_item'	=> '상품별 선택',
				'select_export'	=> '출고번호별 선택',
			);

	public function __construct() {
		parent::__construct();

		$this->load->model('excelspoutmodel');	

		$this->provider_seq = $this->providerInfo['provider_seq'];
		$this->provider_id	= $this->providerInfo['provider_id'];
		$this->is_manager	= $this->managerInfo['manager_yn'];

		$this->manager_id		= $this->excelspoutmodel->manager_id;
		$this->is_manager		= $this->excelspoutmodel->is_manager;

		$this->aCategory		= $this->excelspoutmodel->aCategory;
		$this->aCategoryKR		= $this->excelspoutmodel->aCategoryKR;
		$this->aState			= $this->excelspoutmodel->aState;
		$this->excel_type_list	= $this->excelspoutmodel->excel_type_list;

		if($this->provider_seq <= 0){
			echo "입점사 코드 누락. 관리자에게 문의 바랍니다.";
			exit;
		}
	}

	public function excel_download(){
		$this->admin_menu();
		$this->tempate_modules();

		$this->load->library('searchsetting');

		### SEARCH
		$_default 		= array('page'=>0,'perpage'=>10,'provider_seq'=>$this->providerInfo['provider_seq']);
		$sc 			= $this->searchsetting->pagesearchforminfo("seller_excel_download",$_default);
		$sc['provider_seq'] = $this->providerInfo['provider_seq'];

		//4. 카테고리 별 쿼리
		$res = $this->excelspoutmodel->get_exceldownload_info();
		foreach($res as $k => $v){ //--> 키 인덱스로 재배열
			$this->excel_type_list[$v['seq']] = $v['name'];
		}

		$result = $this->excelspoutmodel->get_excel_download_list_seller($sc);
		$this->template->assign(array('sc'=>$sc,'scObj'=>json_encode($sc)));
		$this->template->assign('page',$result['page']);

		### PAGE & DATA
		$sc['searchcount']		= $result['page']['searchcount'];
		$sc['total_page']		= @ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount']		= $result['page']['totalcount'];
		$excel_list 			= $result['record'];

		//7. 정보 매칭
		foreach($excel_list as $excelK => $excelV)
		{
			$excel_list[$excelK]['category']	= $this->aCategory[$excelV['category']];
			$excel_list[$excelK]['categoryKR']	= $this->aCategoryKR[$excelV['category']];
			$excel_list[$excelK]['state']		= $this->aState[$excelV['state']];
			$excel_list[$excelK]['provider_name'] = $this->providerInfo['provider_name'];
			$excel_list[$excelK]['excel_type']	= $this->excel_type_list[$excelV['excel_type']];
		}
		
		$this->template->assign('loop', $excel_list);
		$this->template->assign('category', $sc['category']);
		$this->template->assign('category_info', $this->aCategory);
		$this->template->assign('category_info_kr', $this->aCategoryKR);
		$paginlay =  pagingtag( $excel_total, $perpage, "/selleradmin/excel_spout/excel_download?category=".$category, "&".http_build_query($sc) );
		if( empty($paginlay) )
		{
			$paginlay = '<p><a class="on red">1</a><p>';
		}
		$this->template->assign('pagin', $paginlay);
		$this->template->define(array('tpl'=>'default/excel/excel_download.html'));
		$this->template->print_("tpl");
	}

	public function file_download(){
		/**
		 * type: 'list' 관리자 각 메뉴 엑셀 다운로드(fm_queue) 이용하여 다운로드 시
		 */
		$type		= $this->input->get('type');
		$id			= $this->input->get('id');
		/**
		 * type 이 없는 경우 url or down_url 가 real file path
		 */
		$url		= $this->input->get('url');
		$down_url	= $this->input->get('down_url');

		$category	= $this->input->get('category');		// type 유무와 상관없이 category가 존재하기도함

		$file_path	= ROOTPATH . "excel_download/" . $category;

		if( (empty($type) && !empty($url)) || $down_url ){
			$url = $file_path.$url;
			if ($down_url) $url = $down_url;
			$real_filename = end(explode("/", $url));

			if(!download_allowed_check($url)) {
				echo "ERROR : NOT ALLOWED DOWNLOAD";
				exit;
			}
			
			header('Content-Type: application/x-octetstream');
			header('Content-Length: '.filesize($url));
			header('Content-Disposition: attachment; filename='.$real_filename);
			header('Content-Transfer-Encoding: binary');
			
			$fp = fopen($url, "r");
			fpassthru($fp);
            fclose($fp);
			
		} else if($type == 'list') {
			//다운로드 가능 기간 체크
			$excel_check = $this->db->query("SELECT 
						file_name,
						context,
						expired_date,
						manager_id,
						count,
						reg_date
					FROM  
						fm_queue 
					WHERE id = ? AND provider_seq = ?", array($id, $this->provider_seq))->result_array();

			if($this->is_manager != "Y" && $excel_check[0]['manager_id'] != $this->provider_id){
				echo "[Error] No permission.";
				exit;
			}

			$this->load->model('authmodel');
			$private_masking = $this->authmodel->manager_limit_act('private_masking');
			if ($private_masking) {
				$context = unserialize($excel_check[0]['context']);
				if(in_array($category, ['order', 'export']) && (!$context['is_private'] || $context['is_private'] == 'Y')){
					$msg = "마스킹(*) 처리된 개인정보 항목이 포함되어 있어 엑셀 다운로드를 할 수 없습니다.";
					$msg .= "<br/ >대표운영자에게 관리자 권한 수정을 요청하거나 해당 항목을 제외하면 다운로드 가능합니다.";
					openDialogAlert($msg, 600, 180, 'parent', '');
					exit;
				}
			}

			if($excel_check[0]['expired_date'] >= date('Y-m-d H:i:s')){
				if( file_exists($file_path."/".$excel_check[0]['file_name']) ){
					//관리자 로그 남기기
					$this->load->library('managerlog');
					$logInfo = array(
						'params' => array('type' => $category, 'menu' => 'excel_download', 'reg_date' => $excel_check[0]['reg_date']),	
					);
					$this->managerlog->insertData($logInfo);
					echo $category."/".$excel_check[0]['file_name'];
				} else {
					echo "[Error] No File.";
					exit;
				}
			} else {
				echo "[Error] Expired File.";
				exit;
			}
        }
        
        exit;
	}

	/* 엑셀 다운로드 항목 설정 */
	public function excel_download_setting(){

		$params = $this->input->get();

		if($params['downloadType'] == "old"){
			$params['getUrl'] 	= '/selleradmin/goods/download_write';
		}else{
			switch($params['mode']){
				case "GOODS":
					$params['getUrl'] = '/selleradmin/goods/excel_form';
				break;
				case "COUPONS":
					$params['getUrl'] = '/selleradmin/goods/social_excel_form';
				break;
			}
		}

		$this->template->assign('mode',$params['mode']);
		
		if($params) $params = json_encode($params);
		$this->template->assign('params',$params);

		$file_path = str_replace('excel_spout/excel_download_setting','excel/_gl_excelform_setting',$this->template_path());
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}
}