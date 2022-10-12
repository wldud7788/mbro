<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
/**
 * 인스타그램 피드 모델
 */
class Instagramfeedmodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'fm_instagram_feed';
	}

	/**
	 * 인스타그램 피드 리스트를 가져온다.
	 * @param int $limit
	 * @param string $user_name
	 * @return array
	 */
	public function getFeedList($limit = 30, $user_name)
	{
		$query = $this->db->from($this->table)
		->order_by('sort_seq')
		->where('user_name', $user_name)
		->limit($limit);

		$query = $query->get();

		return $query->result_array();
	}

	/**
	 * 인스타그램 피드 하나를 가져온다.
	 * @param string $user_name
	 * @return array
	 */
	public function getFeedOne($user_name)
	{
		$query = $this->db->from($this->table)
		->where('user_name', $user_name);
		$query = $query->get();

		return $query->row_array();
	}

	/**
	 * 인스타그램 피드를 저장한다.
	 * @param array $params
	 * @return boolean
	 */
	public function insertFeed($params = [])
	{
		$filter_params = filter_keys($params, $this->db->list_fields($this->table));
		$filter_params['update_date'] = date('Y-m-d H:i:s');

		$result = $this->db->insert($this->table, $filter_params);

		if ($result !== true) {
			return false;
		}

		return $this->db->affected_rows();
	}

	/**
	 * 인스타그램 피드를 batch로 저장한다.
	 * @param array $params
	 * @return boolean
	 */
	public function insertBatchFeed($params = [])
	{
		$result = $this->db->insert_batch($this->table, $params);

		return $result ? true : false;
	}

	/**
	 * 인스타그램 피드를 삭제한다.
	 * @param string $user_name
	 * @return boolean
	 */
	public function deleteFeed($user_name)
	{
		return $this->db->delete($this->table, ['user_name' => $user_name]);
	}
}
