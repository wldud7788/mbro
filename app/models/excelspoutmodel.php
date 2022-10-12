<?php
class excelspoutmodel extends CI_Model {

	public function __construct() {

		parent::__construct();

		$this->manager_id		= $this->managerInfo['manager_id'];
		$this->is_manager		= $this->managerInfo['manager_yn'];

		$this->aCategory = array(
				1 => "goods",
				2 => "order",
				3 => "member",
				4 => "export",
				5 => "scmgoods"
			);

		$this->aCategoryKR = array(
				1 => "상품",
				2 => "주문",
				3 => "회원",
				4 => "출고",
				5 => "재고상품"
			);

		$this->aState = array(
				0 => "대기중",
				1 => "진행중",
				2 => "완료"
			);

		$this->excel_type_list = array(
					'search'		=> '검색',
					'select'		=> '선택',
					'all'			=> '전체',
					'search_order'	=> '주문별 검색',
					'search_item'	=> '상품별 검색',
					'search_export'	=> '출고번호별 검색',
					'search_scmgoods' => '재고상품 검색',
					'search_barcord' => '바코드 다운로드 검색',
					'search_zoomoney' => '주머니 상품관리용 검색',
					'select_order'	=> '주문별 선택',
					'select_item'	=> '상품별 선택',
					'select_export'	=> '출고번호별 선택',
					'select_scmgoods' => '재고상품 선택',
					'select_barcord' => '바코드 다운로드 선택',
					'select_zoomoney' => '주머니 상품관리용 선택',
				);
	}

	public function get_exceldownload_info(){
	
		//4. 카테고리 별 쿼리
		$excelFormDB = $this->db->query("SELECT * FROM fm_exceldownload WHERE gb = 'ORDER' AND provider_seq = 1");
		$res = $excelFormDB->result_array();
		return $res;
	}

	public function get_excel_download_list($params)
	{

		$whereStr = $countWheres = array();

		$whereStr[] = "((q.expired_date >= NOW() AND state = 2) OR q.state IN (0, 1))";
	
		if($this->is_manager != "Y"){
			$whereStr[] = "q.manager_id = '{$this->manager_id}'";
		}

		if( empty($params['provider_seq']) ){
			$provider_seq = 0;
			//--> 입점사 검색일 경우 이름 검색 된 키값으로 셋팅
			if( !empty($provider_name) )
			{
				if( !empty($provider_seq_search) ){
					$provider_seq = $provider_seq_search;
					$whereStr[] = "q.provider_seq = {$provider_seq}";
				} else { //--> 검색 했는대 입점사가 없어 검색 결과 0 처리
					$whereStr[] = "q.provider_seq = NULL";
				}
			}
		} else {
			$provider_seq = $params['provider_seq'];
			$whereStr[] = "q.provider_seq = {$provider_seq}";

			if( defined('__SELLERADMIN__') == true){
				$countWheres[] = "q.provider_seq = {$provider_seq}";
			}
		}
	
		//3. 구분 
		if( empty($params['category']) )
		{
			$category = 0;
		} else {
			$category = $params['category'];
		}
		
		if($category > 0)
		{
			$whereStr[] = "q.category = {$category}";
			$countWheres[] = "q.category = {$category}";
        }else{
			$whereStr[] = "q.category IN ('".join("','",array_keys($this->aCategory))."')";
		}

		if($params['orderby'] ) {
			$orderby ="ORDER BY {$params['orderby']} {$params['sort']} ";
		} else {
			$orderby ="ORDER BY q.id desc ";
		}

		$sqlWhereClause = $whereStr ? implode(' AND ',$whereStr) : "";

		$limitStr =" LIMIT {$params['page']}, {$params['perpage']} ";

		$sql				= array();
		$sql['field']		= "q.*,p.provider_name";
		$sql['table']		= "fm_queue AS q LEFT JOIN fm_provider as p on q.provider_seq=p.provider_seq";
		$sql['wheres']		= $sqlWhereClause;
		$sql['countWheres']	= $countWheres;
		$sql['orderby']		= $orderby;
		$sql['limit']		= $limitStr;
		$result				= pagingNumbering($sql,$params);

		return $result;

	}

	public function get_excel_download_list_seller($params)
	{

		$whereStr = $countWheres = array();

		$whereStr[] = "((q.expired_date >= NOW() AND state = 2) OR q.state IN (0, 1))";

		if($params['manager_id']){
			$whereStr[] = "q.manager_id = '{$params['manager_id']}'";
		}

		$provider_seq = $params['provider_seq'];
		$whereStr[] = "q.provider_seq = {$provider_seq}";

		if( defined('__SELLERADMIN__') == true){
			$countWheres[] = "q.provider_seq = {$provider_seq}";
		}
	
		//3. 구분 
		if( empty($params['category']) )
		{
			$category = 0;
		} else {
			$category = $params['category'];
		}
		
		if($category > 0)
		{
			$whereStr[] = "q.category = {$category}";
			$countWheres[] = "q.category = {$category}";
        }else{
			$whereStr[] = "q.category IN ('".join("','",array_keys($this->aCategory))."')";
		}

		if($params['orderby'] ) {
			$orderby ="ORDER BY {$params['orderby']} {$params['sort']} ";
		} else {
			$orderby ="ORDER BY q.id desc ";
		}

		$sqlWhereClause = $whereStr ? implode(' AND ',$whereStr) : "";

		$limitStr =" LIMIT {$params['page']}, {$params['perpage']} ";

		$sql				= array();
		$sql['field']		= "q.*,p.provider_name";
		$sql['table']		= "fm_queue AS q LEFT JOIN fm_provider as p on q.provider_seq=p.provider_seq";
		$sql['wheres']		= $sqlWhereClause;
		$sql['countWheres']	= $countWheres;
		$sql['orderby']		= $orderby;
		$sql['limit']		= $limitStr;
		$result				= pagingNumbering($sql,$params);

		return $result;

	}
	
}