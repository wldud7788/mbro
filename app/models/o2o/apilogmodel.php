<?php
class apilogmodel extends CI_Model {

	public $tb_column	= array('seq', 'api_type', 'controller', 'action', 'post_info', 'get_info', 'curl_info', 'server_info', 'ip', 'regist_date');
	protected $tb_name			= "fm_api_log";

	public function insert_api_log($api_type='', $process_type='res',$params=array()) {
		$data['api_type']		= $api_type;
		$data['process_type']	= $process_type;
		$data['controller']		= $this->router->fetch_class();
		$data['action']			= $this->router->method;
		$data['post_info']		= serialize($_POST);
		$data['get_info']		= serialize($_GET);
		$data['curl_info']		= serialize($params);
		$data['server_info']	= serialize($_SERVER);
		$data['ip']				= $_SERVER['REMOTE_ADDR'];
		$data['regist_date']	= date('Y-m-d H:i:s');
		
		$this->db->insert($this->tb_name, $data);
	}
	
	public function delete_api_log($deleteTerm=0){
		
		if($deleteTerm && $deleteTerm>0){
			$now = date("Y-m-d");
			$deleteDate = date('Y-m-d', strtotime($Date. '- '.$deleteTerm.' days'));
			$this->db->where('regist_date <', $deleteDate." 00:00:00");
			$this->db->delete($this->tb_name);
		}
	}
}

/* End of file apilogmodel.php */
/* Location: ./app/models/apilogmodel */
