<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
/**
 * 신고하기 lib
 */

require_once APPPATH . 'libraries/Board/BoardBaseLibrary' . EXT;

use App\Libraries\Board\BoardReportDetail;

class BoardReportLibrary extends BoardBaseLibrary
{
	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('boardreportmodel');
	}

	/**
	 * 신고 가능한지 체크
	 * 회원글 , 기존 중복 차단 체크
	 */
	public function canReportBoard($param = [])
	{
		if (empty($param)) {
			return false;
		}
		// 현존하는 글인지
		if ($this->getBoarddata($param) === false) {
			return false;
		}

		// 관리자 차단 못함
		if (getBoardWriter($this->boarddata) === 'admin') {
			return false;
		}

		// 본인글은 아닌지
		if (isMyBoardData($this->boarddata)) {
			return false;
		}

		// 중복신고 체크
		if ($this->isDuplicate($param) === true) {
			return false;
		}

		return true;
	}

	/**
	 * 관리자 신고글리스트
	 */
	public function getReportList($param = [])
	{
		$this->CI->load->model('membermodel');
		$report = $this->CI->boardreportmodel->getReport($param);
		$loop = [];

		$page['searchcount'] = $this->CI->boardreportmodel->getReportCount();
		$page['totalcount'] = $this->CI->boardreportmodel->getReportTotal();
		$page['html'] = pagingtag($page['searchcount'], $param['perpage'], getPageUrl($this->CI->file_path) . '?', getLinkFilter('', array_keys($param)));
		$page['html'] = (!empty($page['html'])) ? $page['html'] : '<p><a class="on red">1</a><p>';

		$no = $page['searchcount'] - ($param['page'] / $param['perpage'] * $param['perpage']);
		foreach ($report->result_array() as $data) {
			$data['rno'] = $no;
			$no--;

			$data['contents'] = getstrcut(strip_tags($data['contents']), 10);

			// 회원정보 중복 쿼리 방지
			if (!isset($userInfo[$data['member_seq']])) {
				$userInfo[$data['member_seq']] = $this->CI->membermodel->get_member_userid($data['member_seq']);
			}
			$data['userid'] = $userInfo[$data['member_seq']];

			// 처리정보 겟은 나중에
			$loop[] = $data;
		}

		return [$loop, $page];
	}

	/**
	 * 관리자에서 신고글 상세보기
	 */
	public function viewReport($seq)
	{
		if (gettype($seq) != 'string') {
			return;
		}

		// 신고내용
		$report = $this->getReport(['seq' => $seq])->row_array();
		if (!$report) {
			return;
		}
		// 게시글
		$arr = [
			'board_id' => $report['boardid'],
			'board_seq' => $report['boardseq'],
			'board_type' => $report['boardtype'],
		];
		$this->getBoarddata($arr);

		$reportDetail = new BoardReportDetail($report, $this->boarddata);

		return $reportDetail->getReportDetail();
	}

	/**
	 * 신고등록
	 *  현재 게시글 조회해서 신고 당시의 기록 저장
	 */
	public function setReport($param = [])
	{
		if ($this->getBoarddata($param) === false) {
			return false;
		}

		$arr = [
			'boardid' => $param['board_id'],
			'boardseq' => $param['board_seq'],
			'boardtype' => $param['board_type'],
			'boardsubject' => $this->boarddata['subject'],
			'boardcontents' => $this->boarddata['contents'],
			'boardmember_seq' => $this->boarddata['mseq'],
			'boardname' => $this->boarddata['name'],
			'boardregist_date' => $this->boarddata['r_date'],
			'boardupdate_date' => $this->boarddata['m_date'],
			'member_seq' => $param['member_seq'],
			'contents' => $param['contents'],
			'regist_date' => date('Y-m-d H:i:s'),
			'ip' => $this->CI->input->server('REMOTE_ADDR'),
		];
		if (isBoardTypeBoard($param['board_type']) === false) {
			$arr['boardparent'] = $this->boarddata['parent'];
		}
		$result = $this->CI->boardreportmodel->insert($arr);

		return $result;
	}

	/**
	 * 신고무시
	 */
	public function deleteReport($seq)
	{
		if (gettype($seq) != 'string') {
			return;
		}

		$report = $this->CI->boardreportmodel->deleteReport($seq);

		return $report;
	}

	/**
	 * 신고처리
	 */
	public function processReport($param)
	{
		if (empty($param)) {
			return [];
		}

		$arr = [
			'boardid' => $param['boardid'],
			'boardseq' => $param['boardseq'],
			'boardtype' => $param['boardtype'],
			'manager_seq' => $this->CI->managerInfo['manager_seq'],
			'report_date' => date('Y-m-d H:i:s'),
			'report_ip' => $this->CI->input->server('REMOTE_ADDR'),
		];
		$result = $this->CI->boardreportmodel->insertProcess($arr);

		return $result;
	}

	// 신고데이터 조회
	protected function getReport($param = [])
	{
		if (empty($param)) {
			return [];
		}
		$report = $this->CI->boardreportmodel->getReport($param);

		return $report;
	}

	/**
	 * 중복체크
	 * 중복이면 TRUE
	 */
	protected function isDuplicate($param = [])
	{
		$result = false;
		if (empty($param)) {
			return [];
		}

		$report = $this->getReport($param);
		if ($report->num_rows() > 0) {
			$result = true;
		}

		return $result;
	}
}
