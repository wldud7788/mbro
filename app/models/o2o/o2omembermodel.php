<?php
class o2omembermodel extends CI_Model {
	protected $tb_name_member_o2o			= "fm_member_o2o";
	protected $tb_name_member_o2o_dr		= "fm_member_o2o_dr";
	
	public $tb_column_member_o2o			=	array(
		'member_o2o_seq', 'member_seq', 'o2o_store_seq', 'auth_yn', 'auth_date'
	);
	public $tb_column_member_o2o_dr		=	array(
		'dormancy_seq', 'member_o2o_seq', 'member_seq', 'o2o_store_seq', 'auth_yn', 'auth_date'
	);
	
	public function __construct() {
		parent::__construct();
	}
	/**
	 * o2o 회원 가입 정보 저장
	 * fm_member 테이블과 1:1 관계
	 */
	public function insert_member_o2o($sqlData){
		$checkData = array(
			'store_seq'		=> $sqlData['store_seq'],
			'pos_seq'		=> $sqlData['pos_seq'],
			'pos_key'		=> $sqlData['pos_key'],
		);
		$this->load->library("o2o/o2oservicelibrary");
		$o2oConfig = $this->o2oservicelibrary->check_o2o_service($checkData);
		
		unset($insertParams);
		$insertParams['member_seq'] = $sqlData['member_seq'];
		$insertParams['o2o_store_seq'] = $o2oConfig['o2o_store_seq'];
		$insertParams['auth_yn'] = $sqlData['auth_yn'];
		$insertParams['auth_date'] = $sqlData['auth_date'];
		$result = $this->db->insert($this->tb_name_member_o2o, $insertParams);
		return $result;
	}
	// o2o 휴면 회원 가입 정보 저장
	public function insert_member_o2o_dr($sqlData){
		unset($insertParams);
		$insertParams['member_o2o_seq']		= $sqlData['member_o2o_seq'];
		$insertParams['member_seq']			= $sqlData['member_seq'];
		$insertParams['o2o_store_seq']		= $sqlData['o2o_store_seq'];
		$insertParams['auth_yn']			= $sqlData['auth_yn'];
		$insertParams['auth_date']			= $sqlData['auth_date'];
		$result = $this->db->insert($this->tb_name_member_o2o_dr, $insertParams);
		return $result;
	}
	
	// o2o 회원 가입 정보 수정
	public function update_member_o2o($params){
		
		if($params['member_o2o_seq']){
			foreach($this->tb_column_member_o2o as $column){
				// 휴면회원 처리를 위해 empty 체크 제외
				//if(!empty($params[$column])){
					if( is_array($params[$column]) ){
						$params[$column] = implode(",", $params[$column]);
						$this->db->set($column, $params[$column]);
					}else{
						$this->db->set($column, $params[$column]);
					}
				//}
			}
			$this->db->where('member_o2o_seq', $params['member_o2o_seq']);
			$result = $this->db->update($this->tb_name_member_o2o);
		}
		return $result;
	}
	
	// o2o 회원 가입 정보 삭제
	public function delete_member_o2o($sqlData){
		
		$result = $this->db->delete($this->tb_name_member_o2o, $sqlData); //
		
		return $result;
	}
	
	// o2o 휴면 회원 가입 정보 삭제
	public function delete_member_o2o_dr($sqlData){
		
		$result = $this->db->delete($this->tb_name_member_o2o_dr, $sqlData); //
		return $result;
	}
	
	// o2o 회원 가입 정보 조회
	public function select_member_o2o($params, $limit=1) {
		
		$this->db->select($this->tb_column_member_o2o);
		$this->db->from($this->tb_name_member_o2o);
		
		// 가변 조건 추가
		foreach($this->tb_column_member_o2o as $column){
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
	
	// o2o 휴면 회원 가입 정보 조회
	public function select_member_o2o_dr($params, $limit=1) {
		
		$this->db->select($this->tb_column_member_o2o_dr);
		$this->db->from($this->tb_name_member_o2o_dr);
		
		// 가변 조건 추가
		foreach($this->tb_column_member_o2o_dr as $column){
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
}

/* End of file o2oservicemodel.php */
/* Location: ./app/models/o2o/o2oservicemodel */
