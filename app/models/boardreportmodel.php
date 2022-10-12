<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/**
 * 게시글 신고하기
 */
class boardreportmodel extends CI_Model
{
	public function __construct()
	{
	}

	/**
	 * 로그 기록
	 * @param array $params
	 * @return boolean
	 */
	public function insert($params = [])
	{
		$filter_params = filter_keys($params, $this->db->list_fields('fm_board_report'));
		$result = $this->db->insert('fm_board_report', $filter_params);
		if ($result !== true) {
			return false;
		}

		return $this->db->insert_id();
	}

	/**
	 * 신고 리스트
	 */
	public function getReport($params = [])
	{
		// subquery
		if ($params['search_text']) {
			$searchquery = $this->db->select('member_seq')->from('fm_member m')
				->like('m.userid', $params['search_text'])
				->get_compiled_select();
		}

		$query = $this->db->select('SQL_CALC_FOUND_ROWS d.*, r.*', false)->from('fm_board_report r FORCE INDEX(board_idx)');

		// 처리결과
		$query->join('fm_board_report_data d FORCE INDEX(board_idx)', 'r.boardid = d.boardid AND r.boardseq = d.boardseq AND r.boardtype = d.boardtype', 'left');

		// 날짜
		$date_gb = $params['date_type'] ? $params['date_type'] : 'regist_date';
		if ($date_gb == 'report_date') {
			$date_gb = 'd.report_date';
		} elseif ($data_gb == 'regist_date') {
			$date_gb = 'r.regist_date';
		}
		if ($params['sdate'] && $params['edate']) {
			$query->where("$date_gb >= '{$params['sdate']} 00:00:00'", null, false);
			$query->where("$date_gb <= '{$params['edate']} 23:59:59'", null, false);
		} elseif ($params['sdate']) {
			$query->where("$date_gb >= '{$params['sdate']} 00:00:00'", null, false);
		} elseif ($params['edate']) {
			$query->where("$date_gb <= '{$params['edate']} 23:59:59'", null, false);
		}

		// 게시판 아이디
		if ($params['board_id']) {
			$query->where('r.boardid', $params['board_id']);
		}
		// 게시글 번호
		if ($params['board_seq']) {
			$query->where('r.boardseq', $params['board_seq']);
		}
		// 게시글 조회
		if ($params['board_type']) {
			$query->where('r.boardtype', $params['board_type']);
		}
		// 신고 회원 seq
		if ($params['member_seq']) {
			$query->where('r.member_seq', $params['member_seq']);
		}

		// 신고seq
		if ($params['seq']) {
			$query->where('r.seq', $params['seq']);
		}

		// 검색
		if ($params['search_text']) {
			if ($params['search_type'] == 'all') {
				$query->group_start();
				$query->where_in('r.member_seq', $searchquery, false);
				$query->or_like('r.contents', $params['search_text']);
				$query->group_end();
			} elseif ($params['search_type'] == 'contents') {
				$query->like('r.contents', $params['search_text']);
			} elseif ($params['search_type'] == 'userid') {
				$query->where('r.member_seq', '(' . $searchquery . ')', false);
			}
		}

		// 처리여부
		if ($params['report'] == 'R') {	// 처리
			$query->where('d.report_date IS NOT NULL', null, false);
		} elseif ($params['report'] == 'NR') {	// 미처리
			$query->where('d.report_date IS NULL', null, false);
		}

		// limit
		if ($params['perpage']) {
			$query->limit($params['perpage'], $params['page']);
		}
		$query->order_by('r.seq desc');

		$query = $query->get();

		return $query;
	}

	/**
	* 검색된 result 의 count
	* @return int
	*/
	public function getReportCount()
	{
		$query = $this->db->select('FOUND_ROWS() as COUNT', false)->get()->row_array();

		return $query['COUNT'];
	}

	/**
	* admin 에서 총 신고 개수 노출 시 사용
	* @return int
	*/
	public function getReportTotal($is_save)
	{
		$query = $this->db->select('count(*) as CNT')
		->from('fm_board_report');

		$query = $query->get();
		$query = $query->row_array();

		return $query['CNT'];
	}

	public function deleteReport($seq)
	{
		if (!$seq) {
			return;
		}

		return $this->db->delete('fm_board_report', ['seq' => $seq]);
	}

	/**
	 * 로그 기록
	 * @param array $params
	 * @return boolean
	 */
	public function insertProcess($params = [])
	{
		$filter_params = filter_keys($params, $this->db->list_fields('fm_board_report_data'));
		$result = $this->db->insert('fm_board_report_data', $filter_params);
		if ($result !== true) {
			return false;
		}

		return $this->db->insert_id();
	}
}
