<?php
class o2oconfigmodel extends CI_Model {
	// DB 테이블 정보
	protected $tb_name_o2o_store			= "fm_o2o_config_store";
	protected $tb_name_o2o_pos				= "fm_o2o_config_pos";
	
	// 각 테이블 별 필드 정보
	public $tb_column_o2o_store			=	array(
		'o2o_store_seq', 'pos_code', 'store_seq', 'pos_key', 'pos_name', 'pos_phone',
		'pos_address_nation', 'pos_address_type', 'pos_address_zipcode', 'pos_address', 'pos_address_street',
		'pos_address_detail', 'pos_international_postcode', 'pos_international_country', 'pos_international_town_city', 'pos_international_county',
		'pos_international_address',
		'scm_store',
		'delete_yn', 'regist_date',
	);
	public $tb_column_o2o_pos			=	array(
		'o2o_pos_seq', 'o2o_store_seq', 'pos_seq', 'contracts_status', 
		'use_yn', 
		'delete_yn', 'regist_date',
	);

	public function __construct() {
		parent::__construct();
	}
	// 매장 정보 조회
	public function select_o2o_config($params=array(), $limit=1, $mode=null) {
		
		$this->db->select($this->tb_column_o2o_store);
		$this->db->from($this->tb_name_o2o_store);
		if($mode!="admin"){
			$this->db->where('delete_yn', 'n');		// 삭제여부 기본 조건
		}
		
		// 가변 조건 추가
		foreach($this->tb_column_o2o_store as $column){
			if(
				!empty($params[$column])
				|| (isset($params[$column]) && $column == 'o2o_store_seq')	// o2o_store_seq로 조회할 경우 값이 없더라도 강제 조회
			){	
				if( is_array($params[$column]) ){
					$this->db->where_in($column, $params[$column]);
				}else{
					$this->db->where($column, $params[$column]);
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
	// 포스정보 조회
	public function select_o2o_config_pos($params=array(), $limit=1, $mode=null) {		
		$this->db->select($this->tb_column_o2o_pos);
		$this->db->from($this->tb_name_o2o_pos);
		if(empty($mode)){
			$this->db->where('delete_yn', 'n');		// 삭제여부 기본 조건
		}
		
		// 가변 조건 추가
		foreach($this->tb_column_o2o_pos as $column){
			if(!empty($params[$column])){
				if( is_array($params[$column]) ){
					$this->db->where_in($column, $params[$column]);
				}else{
					$this->db->where($column, $params[$column]);
				}
			}
		}
		if(!empty($limit) && $limit!="unlimit"){
			$this->db->limit($limit);
		}
		// debug($this->db->get_compiled_select('',false));
		$query = $this->db->get();

		if($limit==1){
			$result = $query->row_array();
		}else{
			$result = $query->result_array();
		}
		return $result;
	}
	// 매장/포스 정보 입력
	public function insert_o2o_config($params=array(), $mode="store") {
		
		$tb_column = ($mode=="store")?$this->tb_column_o2o_store:$this->tb_column_o2o_pos;
		$tb_name = ($mode=="store")?$this->tb_name_o2o_store:$this->tb_name_o2o_pos;
		
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
		$insertParams['delete_yn'] = 'n';
		$this->db->insert($tb_name, $insertParams);
		
		// 고유키 반환
		$result = $this->db->insert_id();
		return $result;
	}
	// 매장/포스 정보 수정
	public function update_o2o_config($params=array(), $mode="store") {
			
		$tb_column		= ($mode=="store")?$this->tb_column_o2o_store:$this->tb_column_o2o_pos;
		$tb_name		= ($mode=="store")?$this->tb_name_o2o_store:$this->tb_name_o2o_pos;
		$key			= ($mode=="store")?'o2o_store_seq':'o2o_pos_seq';
		
		if($params[$key]){
			foreach($tb_column as $column){
				if(!empty($params[$column]) || $column == 'scm_store'){	// 창고 연결 여부는 공백으로 입력 가능해야함
					if( is_array($params[$column]) ){
						$params[$column] = implode(",", $params[$column]);
						$this->db->set($column, $params[$column]);
					}else{
						$this->db->set($column, $params[$column]);
					}
				}
			}
			$this->db->where($key, $params[$key]);
			$result = $this->db->update($tb_name);
		}
		return $result;
	}
	// 매장/포스 정보 삭제
	public function delete_o2o_config($params=array(), $mode="store") {
		
		$tb_column		= ($mode=="store")?$this->tb_column_o2o_store:$this->tb_column_o2o_pos;
		$tb_name		= ($mode=="store")?$this->tb_name_o2o_store:$this->tb_name_o2o_pos;
		$key			= ($mode=="store" || $mode=="posAll")?'o2o_store_seq':'o2o_pos_seq';
		
		if($params[$key]){
			$o2oConfig['delete_yn'] = 'y';
			
			$this->db->set('delete_yn', 'y');
			$this->db->where_in($key, $params[$key]);
			$this->db->update($tb_name);
			
			$this->load->library("o2o/o2oservicelibrary");
			$o2oConfig = $this->o2oservicelibrary->get_o2o_config($params,1,'admin');
			$result = $o2oConfig;
			
			if($mode=="store"){
				unset($sqlData);
				$sqlData = array(
					'o2o_store_seq'				=> $o2oConfig['o2o_store_seq'],
				);
				$this->delete_o2o_config($sqlData, "posAll");
			}
		}
		return $result;
	}
}

/* End of file o2oconfigmodel.php */
/* Location: ./app/models/o2oconfigmodel */
