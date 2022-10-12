<?php
class buyconfirmmodel extends CI_Model
{
	public function get_log_buy_confirm($export_seq)
	{
		$bind[] = $export_seq;
		$query = "select l.*,
			(select manager_id from fm_manager where manager_seq=l.manager_seq) manager_id,
			(select userid from fm_member where member_seq=l.member_seq) member_id
			from fm_log_buy_confirm l where export_seq=? order by seq desc limit 1";
		$query = $this->db->query($query,$bind);
		return $query -> row_array();
	}

	public function log_buy_confirm($data)
	{
		$bind[] = $data['order_seq'];
		$bind[] = $data['export_seq'];

		$str_field[] = "order_seq=?";
		$str_field[] = "export_seq=?";
		if($data['manager_seq']){
			$str_field[]	= "manager_seq=?";
			$bind[]			= $data['manager_seq'];
		}
		if($data['member_seq']){
			$str_field[]	= "member_seq=?";
			$bind[]			= $data['member_seq'];
		}
		if($data['doer']){
			$str_field[]	= "doer=?";
			$bind[]			= $data['doer'];
		}
		if($data['ea']){
			$str_field[]	= "ea=?";
			$bind[]			= $data['ea'];
		} 
		if($data['emoney_status']){
			$str_field[]	= "emoney_status=?";
			$bind[]			= $data['emoney_status'];
		}
		if($data['actor_id']){
			$str_field[]	= "actor_id=?";
			$bind[]			= $data['actor_id'];
		}

		$query = "insert fm_log_buy_confirm set ".implode(",",$str_field).",regdate=now()";
		$this->db->query($query,$bind);
	}

	public function buy_confirm($buy_confirm,$export_code)
	{
		$bind[] = $buy_confirm;
		$bind[] = $export_code;
		$query = "update fm_goods_export set confirm_date=now(), buy_confirm=? where export_code=?";
		$this->db->query($query,$bind);
	}
	
	/**
	 * 진행중인 반품 신청이 있는지 확인.
	 * order_seq, export_code
	 * 
	 * @param type $params
	 * @return boolean
	 */
	public function check_ing_return_for_buyconfirm($params){
		$able_buyconfirm = false;	// true : 구매확정 가능, false : 구매확정 불가
		
		if(empty($params['order_seq']) || empty($params['export_code'])){
			return $able_buyconfirm;
		}
		$bind = array();
		$bind[] = $params['order_seq'];
		$bind[] = $params['export_code'];
				
		$sql = "SELECT 
					ret.refund_code
					, ret.status
				FROM
					fm_order_return AS ret 
					LEFT JOIN fm_order_return_item AS ret_item ON ret_item.return_code=ret.return_code
				WHERE 1=1
					AND ret.order_seq = ? 
					AND ret_item.export_code = ? 
				";
		$query = $this->db->query($sql, $bind);
		$return_data = $query->result_array();
		
		// 진행중인 반품건수 체크
		$arr_refund_code = array();
		$count_return = 0;
		foreach($return_data as $row){
			if(!in_array($arr_refund_code, $row['refund_code']) && !empty($row['refund_code'])){
				$arr_refund_code[] = $row['refund_code'];
			}
			if($row['status'] != 'complete'){
				$count_return++;
			}
		}
		
		if($count_return == 0) {
			$able_buyconfirm = true;
		}
		
		return $able_buyconfirm;
	}
}

/* End of file buyconfirmmodel.php */
/* Location: ./app/models/buyconfirmmodel.php */
