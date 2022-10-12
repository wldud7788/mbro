<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * partner order(npay, kakaotalkbuy) 모델
 */
class partnerordermodel extends CI_Model
{ 
	public function __construct(){

	}

	/**
	 * 주문 가져오기
	 */
	public function getPartnerOrder($params= array()) {
		$query = $this->db->select("SQL_CALC_FOUND_ROWS * ", FALSE)->from("fm_partner_order_detail p");

		if(!empty($params['partner_id'])) {
			if(is_array($params['partner_id'])) {
				$query->where_in('p.partner_id', $params['partner_id']);
			} else {
				$query->where('p.partner_id', $params['partner_id']);
			}
		}

		if(!empty($params['session_tmp'])) {
			if(is_array($params['session_tmp'])) {
				$query->where_in('p.session_tmp', $params['session_tmp']);
			} else {
				$query->where('p.session_tmp', $params['session_tmp']);
			}
		}

		if(!empty($params['partner_order_pk'])) {
			if(is_array($params['partner_order_pk'])) {
				$query->where_in('p.partner_order_pk', $params['partner_order_pk']);
			} else {
				$query->where('p.partner_order_pk', $params['partner_order_pk']);
			}
		}

		if(!empty($params['goods_seq'])) {
			if(is_array($params['goods_seq'])) {
				$query->where_in('p.goods_seq', $params['goods_seq']);
			} else {
				$query->where('p.goods_seq', $params['goods_seq']);
			}
		}

		if(!empty($params['option_type'])) {
			if(is_array($params['option_type'])) {
				$query->where_in('p.option_type', $params['option_type']);
			} else {
				$query->where('p.option_type', $params['option_type']);
			}
		}		

		$query = $query->get();
		return $query->result_array();
	}

	/**
	 * 파트너 주문 업데이트 (partner_order_pk)
	 */
	function setPartnerOrderSeq($partner_order_seq, $partner_order_pk) {
		$result = $this->db->where('partner_order_seq', $partner_order_seq)->update('fm_partner_order_detail',array('partner_order_pk'=>$partner_order_pk));
		return $result;
	}
}