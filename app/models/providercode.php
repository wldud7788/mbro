<?php
class Providercode extends CI_Model {
	public function __construct()
	{
		$this->table = 'fm_provider_code';
	}

	public function select($field='',$where='',$orderby=''){
		if(!$field) $field = "*";
		$this->db->select($field);
		$this->db->from($this->table);
		
		if($where){
			$this->db->where($where);
		}
		if($orderby){
			foreach($orderby as $key=>$value){
				$this->db->order_by($key, $value);
			}
		}
		return $this->db->get();
	}

	public function del($params,$where_ins='',$where_not_ins=''){
		if($where_ins){
			foreach($where_ins as $field => $values){
				$this->db->where_in($field, $values);
			}
		}
		if($where_not_ins){
			foreach($where_not_ins as $field => $values){
				$this->db->where_not_in($field, $values);
			}
		}
		$this->db->where($params);
		$this->db->delete($this->table);
	}	

	public function insert($params){
		$this->db->set($params);
		$this->db->insert($this->table);
	}
}

// end class