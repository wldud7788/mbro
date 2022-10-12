<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/**
 * 게시글 차단하기
 */
class boardblockmodel extends CI_Model
{
	public function __construct()
	{
	}

	/**
	 * 차단 리스트
	 */
	public function getBlock($params = [])
	{
		$query = $this->db->from('fm_board_block');

		// 차단 회원 seq
		if ($params['member_seq']) {
			$query->where('member_seq', $params['member_seq']);
		}
		// 차단 당한 회원 seq
		if ($params['block_seq']) {
			$query->where('block_seq', $params['block_seq']);
		}
		$query = $query->get();

		return $query;
	}

	/**
	 * 차단 기록
	 * @param array $params
	 * @return boolean
	 */
	public function insert($params = [])
	{
		$filter_params = filter_keys($params, $this->db->list_fields('fm_board_block'));
		$result = $this->db->insert('fm_board_block', $filter_params);
		if ($result !== true) {
			return false;
		}

		return $this->db->insert_id();
	}

	/**
	 * 차단 해제
	 */
	public function delete($params = [])
	{
		$filter_params = filter_keys($params, $this->db->list_fields('fm_board_block'));
		$result = $this->db->delete('fm_board_block', $filter_params);

		return $result;
	}
}
