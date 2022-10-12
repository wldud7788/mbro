<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
/**
 * 댓글 lib
 */
class BoardCommentLibrary
{
	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('Boardcomment');
	}

	/**
	 * 게시글 조회
	 */
	public function get_data($sc)
	{
		if (!$sc['where']) {
			return;
		}
		$whereis = [];
		foreach ($sc['where'] as $key => $value) {
			$whereis[] = $key . '="' . $value . '"';
		}
		$params['whereis'] = ' and ' . implode('and', $whereis);
		$params['select'] = ' * ';

		$board_data = $this->CI->Boardcomment->get_data($params);

		return $board_data;
	}
}
