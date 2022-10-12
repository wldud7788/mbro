<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
/**
 * 차단하기 lib
 */
require_once APPPATH . 'libraries/Board/BoardBaseLibrary' . EXT;

class BoardBlockLibrary extends BoardBaseLibrary
{
	const BLOCK_ON = 'on';
	const BLOCK_OFF = 'off';
	var $myBlockList = [];

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('boardblockmodel');
	}

	/**
	 * 차단 가능한지 체크
	 * 회원글 , 기존 중복 차단 체크
	 */
	public function canBlockBoard($param = [])
	{
		if (empty($param)) {
			return false;
		}
		// 현존하는 글인지
		if ($this->getBoarddata($param) === false) {
			return false;
		}
		// 관리자 or 비회원은 차단 못함 (회원이 아니면 false)
		if (getBoardWriter($this->boarddata) != 'member') {
			return false;
		}

		// 본인글이면 FALSE
		if (isMyBoardData($this->boarddata)) {
			return false;
		}

		/**
		 * 중복 차단 체크
		 * 현재 db 랑 param의 onoff 비교하여 return boolean
		 */
		$onoff = [
			self::BLOCK_ON => false,
			self::BLOCK_OFF => true,
		];
		$arr = [
			'member_seq' => $param['member_seq'],
			'block_seq' => $this->boarddata['mseq'],
		];
		if ($this->isDuplicate($arr) === $onoff[$param['block_onoff']]) {
			return false;
		}

		return true;
	}

	/**
	 * 차단 등록/해제 처리
	 */
	public function processBlock($param = [])
	{
		if (empty($this->boarddata)) {
			return false;
		}

		if ($param['block_onoff'] === self::BLOCK_OFF) {
			$result = $this->setBlock($param);
		} else {
			$result = $this->deleteBlock($param);
		}

		return $result;
	}

	/**
	 * 내가 차단한 회원인지
	 * 차단 사용 못하면 FALSE
	 * 차단중이면 off
	 * 차단아니면 on
	 */
	public function isBlockUser($param)
	{
		if (empty($param)) {
			return false;
		}
		// 비회원은 무조건 차단아닌것으로
		if (defined('__ISUSER__') === false) {
			return self::BLOCK_OFF;
		}

		$myBlockList = [];
		$myBlockList = $this->getMyBlockList();
		if (in_array($param['mseq'], $myBlockList)) {
			return self::BLOCK_ON;
		} else {
			return self::BLOCK_OFF;
		}
	}

	/**
	 * front 에서 차단 관련 assign data
	 * param @manager : 게시판정보
	 * param @data : 게시글정보  (reference variable)
	 *  : block_view, block_onoff, contents
	 */
	public function assignBoarddata($manager, &$data)
	{
		// 해당 게시글 차단하기 버튼 노출 여부
		$data['block_view'] = isBoardBlock($manager, $data);
		if ($data['block_view'] === false) {
			return;
		}

		// 차단하기 or 차단해제 체크
		$data['block_onoff'] = $this->isBlockUser($data);
		// 현재 차단 아닌경우
		if ($data['block_onoff'] === self::BLOCK_OFF) {
			return;
		}

		// 해당 회원 차단중이면
		if (isset($data['contents'])) {
			//차단된 작성자의 게시글입니다.
			$data['contents'] = getAlert('et425');
		} else {
			//차단된 작성자의 댓글입니다.
			$data['content'] = getAlert('et426');
		}
	}

	/**
	 * param : boarddata
	 * 중복 차단이면 TRUE
	 */
	protected function isDuplicate($param = [])
	{
		$result = false;
		if (empty($param)) {
			return [];
		}

		$report = $this->getBlock($param);
		if ($report->num_rows() > 0) {
			$result = true;
		}

		return $result;
	}

	/**
	 * 차단 row 가져오기
	 */
	protected function getBlock($param = [])
	{
		if (empty($param)) {
			return [];
		}
		$block = $this->CI->boardblockmodel->getBlock($param);

		return $block;
	}

	/**
	 * 차단등록
	 */
	protected function setBlock($param = [])
	{
		if (empty($this->boarddata)) {
			return false;
		}

		$arr = [
			'member_seq' => $param['member_seq'],
			'block_seq' => $this->boarddata['mseq'],
			'regist_date' => date('Y-m-d H:i:s'),
			'ip' => $this->CI->input->server('REMOTE_ADDR'),
		];
		$result = $this->CI->boardblockmodel->insert($arr);

		return $result;
	}

	/**
	 * 차단해제
	 */
	protected function deleteBlock($param = [])
	{
		if (empty($this->boarddata)) {
			return false;
		}

		$arr = [
			'member_seq' => $param['member_seq'],
			'block_seq' => $this->boarddata['mseq'],
		];
		$result = $this->CI->boardblockmodel->delete($arr);

		return $result;
	}

	/**
	 * 나의 차단 리스트
	 */
	protected function getMyBlockList()
	{
		$myBlockList = [];
		$arr['member_seq'] = $this->CI->userInfo['member_seq'];

		$list = $this->getBlock($arr);
		foreach ($list->result_array() as $data) {
			$myBlockList[] = $data['block_seq'];
		}

		return $myBlockList;
	}
}
