<?php
class exportlogmodel extends CI_Model {

	function export_log($stockable,$step,$export_type,$goods_kind,$error)
	{
		$params['manager_seq'] = $this->managerInfo['manager_seq'];
		$params['provider_seq'] = $this->providerInfo['provider_seq'];
		$params['export_type'] = $export_type;
		$params['goods_kind'] = $goods_kind;
		$params['order_seq'] = $error['order_seq'];
		$params['shipping_seq'] = $error['shipping_seq'];
		$params['export_option_code'] = $error['export_item_seq'];
		$params['export_code'] = $error['export_code'];
		$params['stockable'] = $stockable;
		$params['step'] = $step;
		$params['msg'] = $error['msg'];
		$params['regist_date'] = date('Y-m-d H:i:s');

		$this->db->insert('fm_goods_export_log',$params);
	}

	function get_log_for_order($order_seq){
		$result = array();
		$arr_step[45] = '출고준비';
		$arr_step[55] = '출고완료';
		$arr_export_type['web_order'] = 'web주문별';
		$arr_export_type['web_goods'] = 'web상품별';
		$arr_export_type['excel_order'] = 'excel주문별';
		$arr_export_type['excel_goods'] = 'excel상품별';
		$query = "select l.*,
				p.provider_name,
				p.provider_id,
				m.manager_id,
				m.mname as manager_name
				from fm_goods_export_log l
					left join fm_provider p on l.provider_seq=p.provider_seq
					left join fm_manager m on l.manager_seq=m.manager_seq
				where order_seq=? order by log_seq  desc";
		$query = $this->db->query($query,array($order_seq));
		foreach($query->result_array() as $data){
			$data['process_title'] = $arr_step[$data['step']];
			$data['export_type_title'] = $arr_export_type[$data['export_type']];
			$result[] = $data;
		}

		return $result;
	}
}