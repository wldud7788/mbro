<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
/**
 * 관리자/입점사 메뉴 즐겨찾기 모델
 */
class bookmarkmodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'fm_bookmark';
	}

	/**
	 * 즐겨찾기 메뉴 리스트를 가져온다.
	 * @param int $limit
	 * @param string $user_name
	 * @return array
	 */
	public function getBookmarkList($params = [])
	{
		$query = $this->db->from($this->table)
		->where($params);
		$query = $query->get();

		return $query->result_array();
	}

	/**
	 * 즐겨찾기 메뉴 하나를 가져온다.
	 * @param string $user_name
	 * @return array
	 */
	public function getBookmarkOne($params = [])
	{
		$query = $this->db->from($this->table)
		->where($params);
		$query = $query->get();

		return $query->row_array();
	}

	/**
	 * 즐겨찾기를 저장한다.
	 * @param array $params
	 * @return int
	 */
	public function insertBookmark($params = [])
	{
		$filter_params = filter_keys($params, $this->db->list_fields($this->table));
		$filter_params['regist_date'] = date('Y-m-d H:i:s');

		$result = $this->db->insert($this->table, $filter_params);

		if ($result !== true) {
			return false;
		}

		return $this->db->insert_id();
	}

	/**
	 * 즐겨찾기를 삭제한다.
	 * @param int $seq
	 * @return boolean
	 */
	public function deleteBookmark($seq)
	{
		return $this->db->delete($this->table, ['seq' => $seq]);
	}
}
