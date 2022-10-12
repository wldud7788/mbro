<?php
class paymentlog extends CI_Model {
	public function __construct(){
		$this->table = 'fm_payment_log';
	}

	public function get($params,$orderbys=''){
		$this->db->where($params);
		if( $orderbys ) foreach($orderbys as $orderby1=>$orderby2){
			$this->db->order_by($orderby1, $orderby2);
		}
		return $this->db->get($this->table);
	}

	public function set($params){
		$this->db->insert($this->table, $params); 
	}

	public function get_log($order_seq){
		$logs = array();
		$result	= $this->get(array('order_seq'=>$order_seq));
		foreach($result->result_array() as $data){
			$arr = unserialize($data['log_data']);
			$arr['log_seq'] = $data['log_seq'];
			$logs[] = $arr;
		}
		return $logs;
	}
}
?>
