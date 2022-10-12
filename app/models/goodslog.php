<?php
class goodslog extends CI_Model {

	var $current_date;
	var $current_year;
	var $current_month;
	var $current_day;
	var $current_hour;

	function __construct() {
		parent::__construct();

		$this->current_date = date('Y-m-d');
		$this->current_hour = date('H');

		list(
			$this->current_year,
			$this->current_month,
			$this->current_day
		) = explode('-',$this->current_date);
	}

	function add($type,$goods_seq,$addCount=1){
		$addCount = (int)$addCount;
		if($goods_seq){
			$data = array(
				'type'			=> $type,
				'stats_date'	=> $this->current_date,
				'goods_seq'		=> $goods_seq,
			);
			$query = $this->db->get_where('fm_stats_goods',$data);
			$result = $query->row_array();
			$this->db->set($data);
			if($result['goods_stats_seq']){
				$this->db->where($data);
				$this->db->set("cnt","cnt+{$addCount}",false);
				$this->db->update('fm_stats_goods', $data);
			}else{
				$this->db->set("cnt",$addCount);
				$this->db->insert('fm_stats_goods', $data);
			}

			/* 상품 테이블 장바구니/위시리스트 카운트 업데이트 @2016-12-05 pjm */
			if($type == "cart" || $type == "wish"){
				$data = array('goods_seq' => $goods_seq);
				$this->db->where($data);
				if($type == "cart"){
					$this->db->set("cart_count","ifnull(cart_count,0)+{$addCount}",false);
				}else{
					$this->db->set("wish_count","ifnull(wish_count,0)+{$addCount}",false);
				}
				$this->db->update('fm_goods', $data);
			}
		}
	}

	function del($type,$goods_seq,$addCount=1){
		$addCount = (int)$addCount;
		if($goods_seq){
			$data = array(
				'type'			=> $type,
				'stats_date'	=> $this->current_date,
				'goods_seq'		=> $goods_seq,
			);
			$query = $this->db->get_where('fm_stats_goods',$data);
			$result = $query->row_array();

			if($result['goods_stats_seq']){
				$this->db->where($data);
				$this->db->set("cnt","cnt-{$addCount}",false);
				$this->db->update('fm_stats_goods', $data);
			}

			if($type == "cart" || $type == "wish"){
				$data = array('goods_seq' => $goods_seq);
				$this->db->where($data);
				if($type == "cart"){
					$this->db->set("cart_count","ifnull(cart_count,0)-{$addCount}",false);
				}else{
					$this->db->set("wish_count","ifnull(wish_count,0)-{$addCount}",false);
				}
				$this->db->update('fm_goods', $data);
			}
		}
	}
}
?>
