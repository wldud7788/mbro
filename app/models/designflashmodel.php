<?php
class designflashmodel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function get_flash($flash_seq)
	{
		$this->db->select("a.*, b.url xmlurl");
		$this->db->from("fm_design_flash a");
		$this->db->join("fm_design_flash_file b", "a.flash_seq = b.flash_seq");
		$this->db->where("a.flash_seq", $flash_seq);
		$this->db->where("b.type", 'xml');
		$this->db->like("b.url", 'data.xml', 'before');
		$this->db->limit(0, 1);
		return $this->db->get();
	}

	public function update_flash($data, $seq)
	{
		$this->db->where('flash_seq', $seq);
		$this->db->update(
			'fm_design_flash',
			array(
				'name' => $data['name'],
				'width' => $data['flashW'],
				'height' => $data['flashH']
			)
		);
	}

	public function delete_flash_file($seq)
	{
		$this->db->delete(
			'fm_design_flash_file',
			array(
				'flash_seq' => $seq,
				'type' => 'img'
			)
		);
	}

	public function insert_flash_file($data)
	{
		$this->db->insert(
			'fm_design_flash_file',
			array(
				'type' => $data['type'],
				'flash_seq' => $data['flash_seq'],
				'url' => $data['url']
			)
		);
	}
}