<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class excel_spout extends admin_base {


	public function __construct() {
		parent::__construct();

		$this->load->model('excelspoutmodel');
		$this->load->library('validation');

		$this->manager_id		= $this->excelspoutmodel->manager_id;
		$this->is_manager		= $this->excelspoutmodel->is_manager;

		$this->aCategory		= $this->excelspoutmodel->aCategory;
		$this->aCategoryKR		= $this->excelspoutmodel->aCategoryKR;
		$this->aState			= $this->excelspoutmodel->aState;
		$this->excel_type_list	= $this->excelspoutmodel->excel_type_list;

	}


	public function excel_download(){
		$aGetParams = $this->input->get();

		// validation
		if ($aGetParams) {
			$this->validation->set_data($aGetParams);
			$this->validation->set_rules('category', '카테고리', 'trim|numeric|xss_clean');
			$this->validation->set_rules('provider_seq', '입점사번호', 'trim|numeric|xss_clean');
			$this->validation->set_rules('perpage', '페이지갯수', 'trim|numeric|xss_clean');
			$this->validation->set_rules('provider_name', '입점사명', 'trim|string|xss_clean');
			if ($this->validation->exec() === false) {
				show_error($this->validation->error_array['value']);
			}
		}

		$this->admin_menu();
		$this->tempate_modules();

		$this->load->library('searchsetting');

		### SEARCH
		$_default 		= array('page'=>0,'perpage'=>10);
		$sc 			= $this->searchsetting->pagesearchforminfo("excel_download",$_default);

		//4. 카테고리 별 쿼리
		$res = $this->excelspoutmodel->get_exceldownload_info();
		foreach($res as $k => $v){ //--> 키 인덱스로 재배열
			$this->excel_type_list[$v['seq']] = $v['name'];
		}

		$result = $this->excelspoutmodel->get_excel_download_list($sc);

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
			$excel_list[$excelK]['excel_type']	= $this->excel_type_list[$excelV['excel_type']];
		}

		$this->template->assign('loop', $excel_list);
		$this->template->assign('category_info', $this->aCategory);
		$this->template->assign('category_info_kr', $this->aCategoryKR);
		$paginlay =  pagingtag( $excel_total, $perpage, "/admin/excel_spout/excel_download?category=".$category, "&".http_build_query($sc) );
		if( empty($paginlay) )
		{
			$paginlay = '<p><a class="on red">1</a><p>';
		}
		$this->template->assign('pagin',$paginlay);
		$this->template->define(array('tpl'=>'default/excel/excel_download.html'));
		$this->template->print_("tpl");
	}

	/* 2020 관리자UI개선 패치 후 삭제 가능 */
	public function excel_download_old(){
		$this->admin_menu();
		$this->tempate_modules();

		$whereStr = "WHERE category IN ('".join("','",array_keys($this->aCategory))."') AND ((expired_date >= NOW() AND state = 2) OR state IN (0, 1))";

		if($this->is_manager != "Y"){
			$whereStr .= " AND manager_id = '{$this->manager_id}'";
		}

		//1. 페이징
		if(empty($_GET['perpage'])){
			$perpage = 10;
		} else {
			$perpage = $_GET['perpage'];
		}
		$this->template->assign('perpage', $perpage);

		if(empty($_GET['page'])){
			$page = 0;
		} else {
			$page = $_GET['page'];
		}

		//2. 입점사
		//--> provider 정보 추출
		$provider_name  = trim($_GET['provider_name']);

		$providerDB		= $this->db->query('SELECT * FROM  fm_provider');
		$provider_list  = $providerDB->result_array();

		//--> 키 인덱스로 재배열
		$providerData = array();
		foreach($provider_list as $provider)
		{
			$providerData[$provider['provider_seq']]['provider_seq'] = $provider['provider_seq'];
			$providerData[$provider['provider_seq']]['provider_id'] = $provider['provider_id'];
			$providerData[$provider['provider_seq']]['provider_name'] = $provider['provider_name'];

			if( !empty($provider_name) && $provider['provider_name'] == $provider_name )
			{ //--> 입점사 검색일 경우의 입점사 정보 저장
				$provider_seq_search = $provider['provider_seq'];
			}
		}
		$this->template->assign('provider', $providerData);

		if( empty($_GET['provider_seq']) ){
			$provider_seq = 0;
			//--> 입점사 검색일 경우 이름 검색 된 키값으로 셋팅
			if( !empty($provider_name) )
			{
				if( !empty($provider_seq_search) ){
					$provider_seq = $provider_seq_search;
					$whereStr .= " AND provider_seq = {$provider_seq}";
				} else { //--> 검색 했는대 입점사가 없어 검색 결과 0 처리
					$whereStr .= " AND provider_seq = NULL";
				}
			}
		} else {
			$provider_seq = $_GET['provider_seq'];
			$whereStr .= " AND provider_seq = {$provider_seq}";
		}
		$this->template->assign('provider_seq', $provider_seq);

		//3. 구분
		if( empty($_GET['category']) )
		{
			$category = 0;
		} else {
			$category = $_GET['category'];
		}

		if($category > 0)
		{
			$whereStr .= " AND category = {$category}";
		}
		$this->template->assign('category', $category);

		//4. 카테고리 별 쿼리
		$excelFormDB = $this->db->query("SELECT * FROM fm_exceldownload WHERE gb = 'ORDER' AND provider_seq = 1");
		$res = $excelFormDB->result_array();

		foreach($res as $k => $v){ //--> 키 인덱스로 재배열
			$this->excel_type_list[$v['seq']] = $v['name'];
		}

		//6. 엑셀 다운로드 목록
		$excelDB = $this->db->query("SELECT
					*
				FROM
					fm_queue
				{$whereStr}
				ORDER BY id desc
				LIMIT {$page}, {$perpage}");

		$excel_list	= $excelDB->result_array();

		//7. 정보 매칭
		$no = $excel_total - ( ($page/$perpage) * $perpage );
		foreach($excel_list as $excelK => $excelV)
		{
			$excel_list[$excelK]['no']			= $no;
			$excel_list[$excelK]['category']	= $this->aCategory[$excelV['category']];
			$excel_list[$excelK]['categoryKR']	= $this->aCategoryKR[$excelV['category']];
			$excel_list[$excelK]['state']		= $this->aState[$excelV['state']];
			$excel_list[$excelK]['provider_name'] = $providerData[$excelV['provider_seq']]['provider_name'];
			$excel_list[$excelK]['excel_type']	= $this->excel_type_list[$excelV['excel_type']];

			$no--;
		}

		$sc = array();
		$sc['perpage']		= $perpage;
		$sc['provider_seq']	= $provider_seq;

		$this->template->assign('loop', $excel_list);
		$this->template->assign('category_info', $this->aCategory);
		$this->template->assign('category_info_kr', $this->aCategoryKR);
		$paginlay =  pagingtag( $excel_total, $perpage, "/admin/excel_spout/excel_download?category=".$category, "&".http_build_query($sc) );
		if( empty($paginlay) )
		{
			$paginlay = '<p><a class="on red">1</a><p>';
		}
		$this->template->assign('pagin',$paginlay);
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
			ob_clean();
			flush();

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
					WHERE id = ?", $id)->result_array();
			if($this->is_manager != "Y" && $excel_check[0]['manager_id'] != $this->manager_id){
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
						'params' => array('type' => $category, 'menu' => 'excel_download', 'excelcount' => $excel_check[0]['count'], 'reg_date' => $excel_check[0]['reg_date']),
					);
					$this->managerlog->insertData($logInfo);
					echo $category."/".$excel_check[0]['file_name'];
				} else {
					echo "[Error] No File.";
					exit;
				}
			} else {
				echo "[Error] Expired File!!.".$excel_check[0]['manager_id'];
				exit;
			}
        }

		exit;
	}

	/* 엑셀 다운로드 항목 설정 */
	public function excel_download_setting(){

		$params = $this->input->get();

		if($params['downloadType'] == "old"){
			$params['getUrl'] 	= '/admin/goods/download_write';
		}else{
			switch($params['mode']){
				case "GOODS":
					$params['getUrl'] = '/admin/goods/excel_form';
				break;
				case "COUPONS":
					$params['getUrl'] = '/admin/goods/social_excel_form';
				break;
			}
		}
		$this->load->model('scmmodel');
		$this->template->assign('chkScm', $this->scmmodel->chkScmConfig(true));
		$this->template->assign('mode',$params['mode']);

		if($params) $params = json_encode($params);
		$this->template->assign('params',$params);

		$file_path = str_replace('excel_spout/excel_download_setting','excel/_gl_excelform_setting',$this->template_path());
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

}