<?php
class boardformmodel extends CI_Model
{
	public function __construct() {
		parent::__construct();
		$this->table = 'fm_boardform';
	}

	public function get_first_goods_review()
	{
		$query = $this->db->select('*')
		->from($this->table)
		->where(
			array(
				'used' => 'Y',
				'label_type' => 'radio',
				'boardid' => 'goods_review'
			)
		)
		->order_by('sort_seq', 'asc')
		->limit(1)
		->get();
		return $query;
	}
}
