<?php
class Currencymodel extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->table = 'fm_currency';
	}
	
	public function get_default_params($admin_env_seq){
		return array(
				array(
						'admin_env_seq'				=>$admin_env_seq,
						'currency'						=>'USD',
						'currency_type'					=>'compare',
						'currency_amout'				=>0.00,
						'currency_exchange'			=>1.20,
						'cutting_price'					=>0.001,
						'cutting_action'				=>'ascending',
						'currency_symbol'				=>'&dollar;',
						'currency_symbol_position'	=>'after'
				),
				array(
						'admin_env_seq'				=>$admin_env_seq,
						'currency'						=>'KRW',
						'currency_type'					=>'basic',
						'currency_amout'				=>0.00,
						'currency_exchange'			=>1137.30,
						'cutting_price'					=>0.100,
						'cutting_action'				=>'ascending',
						'currency_symbol'				=>'&#x20a9;',
						'currency_symbol_position'	=>'after'
				),
				array(
						'admin_env_seq'				=>$admin_env_seq,
						'currency'						=>'CNY',
						'currency_type'					=>'compare',
						'currency_amout'				=>0.00,
						'currency_exchange'			=>6.68,
						'cutting_price'					=>0.100,
						'cutting_action'				=>'ascending',
						'currency_symbol'				=>'元;',
						'currency_symbol_position'	=>'after'
				),
				array(
						'admin_env_seq'				=>$admin_env_seq,
						'currency'						=>'JPY',
						'currency_type'					=>'compare',
						'currency_amout'				=>0.00,
						'currency_exchange'			=>104.28,
						'cutting_price'					=>0.100,
						'cutting_action'				=>'ascending',
						'currency_symbol'				=>'円',
						'currency_symbol_position'	=>'after'
				),
				array(
						'admin_env_seq'				=>$admin_env_seq,
						'currency'						=>'EUR',
						'currency_type'					=>'compare',
						'currency_amout'				=>0.00,
						'currency_exchange'			=> 0.91,
						'cutting_price'					=>0.100,
						'cutting_action'				=>'ascending',
						'currency_symbol'				=>'&euro;',
						'currency_symbol_position'	=>'after'
				)
		);
	}

	public function get($params, $limit, $offset){
		return $this->db->get_where($this->table, $params, $limit, $offset);
	}

	public function update($update_params, $where_params){
		$this->db->update($this->table, $update_params, $where_params);
	}

	public function insert($insert_params){
		$this->db->insert($this->table, $insert_params);
	}
	public function truncate(){
		$this->db->query('truncate table '.$this->table);
	}
}

/* End of file currencymodel.php */
/* Location: ./app/models/currencymodel.php */