<?php
class Alertmodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function alert_list($sc,$isPage = false){
		$getData = $this->input->get();
		$sc['page'] = (isset($getData['page'])) ? intval($getData['page']) : '1';
		$sc['perpage'] = (isset($getData['perpage'])) ? intval($getData['perpage']) : '20';
		$sc['gb'] = (isset($getData['gb'])) ? $sc['gb'] : 'gv';

		// GET으로 덮어지는 검색 재정의 :: 2017-02-20 lwh
		$sc['gb'] = ($sc['code']) ? $sc['code'] : $sc['gb'];

		$bindData = [];
		if	($sc['gb'])
			$where_arr[] = "code like ?";
			$bindData[] = $sc['gb']."%";

		if	(count($where_arr) > 0)
			$where = ' where '.implode(' and ',$where_arr);

		$sql	=	" select * from fm_alert ".$where;
		$sql	.=	" order by seq ";		

		if( $isPage ){
			$data = select_page($sc['perpage'], $sc['page'], 10, $sql, $bindData);
			$data['page']['querystring'] = get_args_list();
		}else{
			$query = $this->db->query($sql, $bindData);
			$data = $query->result_array();
		}

		return $data;
	}
}
?>
