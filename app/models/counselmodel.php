<?php
class Counselmodel extends CI_Model
{
	protected $table = 'fm_counsel';

	public function __construct()
	{
		$this->managerurl				= '/admin/board/counsel_catalog';							//게시판관리
	}

	public function get($params='', $fields='', $orderbys=''){
		$this->db->where($params);
		if( $orderbys )
		{
			foreach($orderbys as $orderby1=>$orderby2)
			{
				$this->db->order_by($orderby1, $orderby2);
			}
		}
		if( $fields ) $this->db->select($fields);

		return $this->db->get('fm_counsel');
	}

	public function get_query_builder() {
		return (clone $this->db)
			->reset_query()
			->from($this->table);
	}

	public function find(int $id) {
		return $this->get_query_builder()
			->where('counsel_seq', $id)
			->limit(1)
			->get()
			->row_object();
	}
}

/* End of file Counselmodel.php */
/* Location: ./app/models/Counselmodel.php */