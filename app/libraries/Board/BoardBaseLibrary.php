<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
/**
 * boardlibrary, boardcommentlibrary
 * by hyem
 */
class BoardBaseLibrary
{
	public $boarddata = [];

	protected function getBoarddata($param)
	{
		$boarddata = [];
		$sc['where'] = [
			'seq' => $param['board_seq'],
		];

		if (isBoardTypeBoard($param['board_type'])) {
			// 게시글 조회
			$this->CI->load->library('Board/BoardLibrary', ['boardid' => $param['board_id']]);
			$boarddata = $this->CI->boardlibrary->get_data($sc);
		} else {
			// 댓글 조회
			$this->CI->load->library('Board/BoardCommentLibrary');
			$boarddata = $this->CI->boardcommentlibrary->get_data($sc);
			$boarddata['contents'] = $boarddata['content'];	// 댓글은 content .... 라서 contents로 덮어쓰기함 ㅠㅠ
		}
		if (!$boarddata['contents']) {
			// 현재 게시글 없으면 false
			return false;
		}
		$boarddata['board_type'] = $param['board_type'];
		$this->boarddata = $boarddata;

		return true;
	}
}
