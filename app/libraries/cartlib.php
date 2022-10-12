<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 장바구니 관련 lib
 * 2021-10-28
 * by hyem
 */
class cartlib
{
	function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('cartmodel');
	}

	public function empty_cart_duraion($arr) {
		if(empty($arr)) {
			/**
			 * 어떤 조건도 없으면 삭제안함!
			 */
			return;
		}

		$this->CI->db->trans_begin();

		$params = [
			'update_date <' => $arr['duration_date'],
			'partner_id' => $arr['partner_id'],
		];
		
		$strSubQuery = $this->CI->db->select("cart_seq")
		->from("fm_cart")
		->where($params)
		->get_compiled_select();

		$this->CI->db->where_in('cart_seq',$strSubQuery, false)->delete('fm_cart_option');
		$this->CI->db->where_in('cart_seq',$strSubQuery, false)->delete('fm_cart_suboption');
		$this->CI->db->where_in('cart_seq',$strSubQuery, false)->delete('fm_cart_input');
		$this->CI->db->where($params)->delete('fm_cart');

		// dummy 데이터 삭제, option(suboption) 없는데 cart만 있는 경우 cart 삭제하는 쿼리
		$query = "delete a from fm_cart a
		left join fm_cart_option b on a.cart_seq=b.cart_seq
		left join fm_cart_suboption c on a.cart_seq=c.cart_seq
		where b.cart_option_seq is null and c.cart_suboption_seq is null";
		$this->CI->db->query($query);
		$this->CI->db->trans_commit();
	}

	/**
	 * 장바구니에 파트너 정보 넣기
	 * 장바구니 비우기에 예외처리
	 */
	function setCartMarking($cart_seq, $partner_id) {
		if(empty($cart_seq) || empty($partner_id)) {
			return;
		}
		$this->CI->load->model('cartmodel');
		$set_params = ['partner_id' => $partner_id];
		$where_params = ['cart_seq' => $cart_seq];
		return $this->CI->cartmodel->modify('cart', $set_params, $where_params);
	}
}
