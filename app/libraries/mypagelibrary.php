<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 마이페이지 내에 처리하는 function 들이 컨트롤러에 산재되어 있어 
 * 향후 병합을 위한 라이브러리 구조
 * 2021-11-22
 */
class MypageLibrary
{
	function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('membermodel');
		$this->CI->load->model('couponmodel');
	}

	/**
	 * 현재 교환할 수 있는 사은품 이벤트인지 검증
	 */
	public function buy_gift_validation() {
		$aParams = $this->CI->input->post();

		// seq(goods_seq) 가 사은품이 아니면 return false;
		$seq = $aParams['goods_seq'];
		$this->CI->load->model('goodsmodel');
		$goods = $this->CI->goodsmodel->get_goods($seq);
		// 사은품, 정상, 노출 이 아니면 false
		if(($goods['goods_type'] == 'gift'
			&& $goods['goods_status'] == 'normal'
			&& $goods['goods_view'] == 'look') == false) {
			return false;
		}

		// price 가 사은품이벤트에 있는지 체크
		$gift_goods_validation = false;
		$gift_seq_possiblie = array();
		$point = $aParams['point'];
		$query = $this->CI->db->select("*")->from("fm_gift_benefit")->where("benefit_rule","price")->where("sprice",$point)->where("eprice","0.00")->get();
		$gift_event = $query->result_array();
		$min_emoney = 0;
		foreach($gift_event as $row) {
			$goods_seq_arr = explode('|',$row['gift_goods_seq']);
			if(in_array($seq, $goods_seq_arr)) {
				$gift_seq_possiblie[] = $row['gift_seq'];
				$gift_goods_validation = true;
				if($min_emoney == 0) {
					$min_emoney = $row['sprice'];
				} else {
					$min_emoney = $min_emoney > $row['sprice'] ? $row['sprice'] : $min_emoney;
				}
			}
		}
		if($gift_goods_validation == false) {
			return false;
		}
		$my_emoney = $this->CI->membermodel->get_emoney($this->CI->userInfo['member_seq']);
		if((int)$my_emoney < (int)$min_emoney) {
			return false;
		}

		// gift_seq_possiblie 현재 노출되는 사은품 이벤트가 맞는지 체크
		unset($gift_event);
		$gift_validation = false;
		$today = date("Y-m-d");
		$query = $this->CI->db->select("*")->from("fm_gift")
			->where_in("gift_seq",$gift_seq_possiblie)->where("display","y")
			->where("start_date <=",$today)->where("end_date >=",$today)->get();
		$gift_event = $query->result_array();
		foreach($gift_event as $row) {
			$gift_validation = true;
		}

		return $gift_validation;
	}

}