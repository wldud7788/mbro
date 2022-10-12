<?
class ordershippingmodel extends CI_Model {
	public function __construct(){

	}

	public function get_ordershipping_for_order($params){
		$order_seq		= $params['order_seq'];
		$provider_seq	= $params['provider_seq'];
		$shipping_seq	= $params['shipping_seq'];
		$ship_set_code	= $params['ship_set_code'];

		$this->load->model('shippingmodel');
		if($order_seq){
			$where_arr[] = "s.order_seq=?";
			$bind[] = $order_seq;
		}

		if( defined('__SELLERADMIN__') === true ){
			$where_arr[] = "s.provider_seq=?";
			$bind[] = $this->providerInfo['provider_seq'];
		}

		if($provider_seq){
			$where_arr[] = "s.provider_seq=?";
			$bind[] = $provider_seq;
		}

		foreach($arr_shipping_method as $shipping_method){
			switch($shipping_method){
				case "delivery" :
					$arr_num[]	= "?";
					$arr_num[]	= "?";
					$arr_num[]	= "?";
					$arr_num[]	= "?";
					$bind[]		= $shipping_method;
					$bind[]		= "each_delivery";
					$bind[]		= "postpaid";
					$bind[]		= "each_postpaid";
					break;
				default :
					$arr_num[]	= "?";
					$bind[]		= $shipping_method;
					break;
			}
		}
		if($arr_num){
			$where_arr[]	= "s.shipping_method in(".implode(',',$arr_num).")";
		}

		if($shipping_seq){
			$where_arr[]	= "s.shipping_seq = ?";
			$bind[]			= $shipping_seq;
		}

		if($ship_set_code){
			$where_arr[]	= "s.shipping_method = ?";
			$bind[]			= $ship_set_code;
		}

		if($where_arr){
			$where_str = implode(" AND ",$where_arr);
		}else{
			return false;
		}

		$query = "
		select t.*,concat(t.shipping_seq,t.coupon_option_seq) as shipping_cd from (
			select
				s.*,if(s.shipping_method='coupon',io.item_option_seq,'') as coupon_option_seq
				,o.orign_order_seq,o.npay_order_id,o.recipient_zipcode,o.ordersheet_sale,o.talkbuy_order_id,o.label
			from
				fm_order_shipping s
				left join fm_order_item_option io on s.order_seq=io.order_seq and s.shipping_seq=io.shipping_seq
				left join fm_order as o on o.order_seq=io.order_seq
			where ".$where_str." group by s.shipping_seq,coupon_option_seq order by s.provider_seq,s.shipping_seq
		) t
		";
		$query = $this->db->query($query,$bind);
		foreach($query->result_array() as $data)
		{
			$ship_arr = explode('_',$data['shipping_group']);
			$shipping_group_seq	= $ship_arr[0];
			$shipping_set_seq	= $ship_arr[1];

			// 배송출고지 추출 :: 2016-10-05 lwh
			$sql = "SELECT * FROM fm_shipping_grouping WHERE shipping_group_seq = ?";
			$grp_query	= $this->db->query($sql,$shipping_group_seq);
			$grp_res	= $grp_query->row_array();
			$send_add = $this->shippingmodel->get_shipping_address($grp_res['sendding_address_seq'], $grp_res['sendding_scm_type']);
			if($send_add['address_nation'] == 'korea'){
				$send_add['view_address'] = ($send_add['address_type'] == 'street') ? $send_add['address_street'] : $send_add['address'];
				$send_add['view_address'] = '(' . $send_add['address_zipcode'] . ') ' . $send_add['view_address'] . ' ' . $send_add['address_detail'];
			}else{
				$send_add['view_address'] = '(' . $send_add['international_postcode'] . ') ' . $send_add['international_country'] . ' ' . $send_add['international_town_city'] . ' ' . $send_add['international_county'] . ' ' . $send_add['international_address'];
			}
			$data['sending_address'] = $send_add;
			// $data['refund_address']		= $this->shippingmodel->get_shipping_address($grp_res['refund_address_seq'], $grp_res['refund_scm_type']); // 일단 필요없음

			// 배송방법명 없는경우 예외처리 :: 2016-09-23 lwh
			if(!$data['shipping_set_name']){
				$shipping_set_code = $data['shipping_method'];
				if		($shipping_set_code == 'delivery'){
					$data['shipping_set_name'] = '택배';
				}else if($shipping_set_code == 'postpaid'){
					$data['shipping_set_name'] = '택배(착불)';
				}else if($shipping_set_code == 'direct'){
					$data['shipping_set_name'] = '직접수령';
				}else if($shipping_set_code == 'direct_delivery'){
					$data['shipping_set_name'] = '직접배송';
				}else if($shipping_set_code == 'quick'){
					$data['shipping_set_name'] = '퀵서비스';
				}else if($shipping_set_code == 'freight'){
					$data['shipping_set_name'] = '화물배송';
				}else if($shipping_set_code == 'direct_store'){
					$data['shipping_set_name'] = '매장수령';
				}else if($shipping_set_code == 'custom'){
					$data['shipping_set_name'] = '직접입력';
				}
			}
			$result[] = $data;
		}
		return $result;
	}

	// 특정입점사의 주문의 배송사번호를 가져옴
	public function get_shipping_provider_seq_for_order($order_seq,$provider_seq){
		$query_option = $this->db->query("select s.provider_seq shipping_provider_seq from fm_order_item_option o,fm_order_shipping s where o.order_seq=? and o.provider_seq=? and s.shipping_seq=o.shipping_seq limit 1", array($order_seq,$provider_seq) );
		$row_shipping = $query_option->row_array();
		return $row_shipping['shipping_provider_seq'];
	}

	public function get_order_shipping($shipping_seq){
		$query = "select * from fm_order_shipping where shipping_seq=?";
		return $this->db->query($query,array($shipping_seq));
	}

	public function get_shipping_only($params){
		$this->db->where($params);
		return $this->db->get('fm_order_shipping');
	}

}