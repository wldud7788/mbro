<?php
class o2oblockmodel extends CI_Model {
	// DB 테이블 정보
	protected $tb_name_o2o_block			= "fm_o2o_block";
	
	// 각 테이블 별 필드 정보
	public $tb_column_o2o_block			=	array(
		'o2o_store_seq', 'o2o_pos_seq', 'member_seq', 'regist_date',
	);

	public function __construct() {
		parent::__construct();
	}
	// 블럭 정보 조회
	public function select_o2o_block($params=array(), $limit=1, $mode) {
		
		$this->db->select($this->tb_column_o2o_block);
		$this->db->from($this->tb_name_o2o_block);
		
		// 가변 조건 추가
		foreach($this->tb_column_o2o_block as $column){
			if(!empty($params[$column])){
				if( is_array($params[$column]) ){
					$this->db->where_in($column, $params[$column]);
				}else{
					$this->db->where($column, $params[$column]);
				}
			}
		}
		// 메뉴얼 조건 추가
		$arr_where = array('where_custom');
		foreach($arr_where as $sel_where){
			if(!empty($params[$sel_where])){
				foreach($params[$sel_where] as $column=>$data){
					$this->db->where($data);
				}
			}
		}
		if(!empty($limit) && $limit!="unlimit"){
			$this->db->limit($limit);
		}
		if($mode=="query"){
			return $this->db->get_compiled_select('',false);
		}
		$query = $this->db->get();

		if($limit==1){
			$result = $query->row_array();
		}else{
			$result = $query->result_array();
		}
		return $result;
	}
	// 블럭 정보 입력
	public function insert_o2o_block($params=array()) {
		
		$tb_column = $this->tb_column_o2o_block;
		$tb_name = $this->tb_name_o2o_block;
		
		$insertParams = array();
		foreach($tb_column as $column){
			if(!empty($params[$column])){
				if( is_array($params[$column]) ){
					$insertParams[$column] = implode(",", $params[$column]);
				}else{
					$insertParams[$column] = $params[$column];
				}
			}
		}
		$insertParams['regist_date'] = date("Y-m-d H:i:s");
		$result = $this->db->insert($tb_name, $insertParams);
		return $result;
	}
}

/* End of file o2oblockmodel.php */
/* Location: ./app/models/o2oblockmodel */
