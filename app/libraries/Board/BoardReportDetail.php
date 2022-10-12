<?php
namespace App\Libraries\Board;

/**
 * 관리자에서 신고 상세내용보기
 */
class BoardReportDetail
{
	var $reportDetail = [];
	
	public function __construct($report, $board)
	{
		$this->reportDetail['report'] = $report;
		$this->reportDetail['board'] = $board;
	}

	public function getReportDetail()
	{
		$this->reportDetail();
		$this->reportManager();
		$this->reportDetailAfter();

		$arr = $this->reportDetail;

		return $arr;
	}

	/**
	 * report , board , manager 합쳐진 데이터 가공
	 * 신고내용 getcontents 치환
	 * 신고자 회원정보 가공
	 */
	protected function reportDetailAfter()
	{
		// 신고당시의 신고내용  getcontents 치환
		$board = $this->reportDetail['board'];
		$report = $this->reportDetail['report'];
		$manager = $this->reportDetail['manager'];

		$board['contents'] = $report['boardcontents'];
		$report['boardcontents'] = getcontents($board);

		$board['name'] = $report['boardname'];
		getminfo($manager, $board, $minfo, $mbname, '', 'board_view'); //회원정보
		$board['name'] = $mbname;

		$this->reportDetail['board'] = $board;
		$this->reportDetail['report'] = $report;
	}

	/**
	 * 신고내용 가공
	 */
	protected function reportDetail()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('membermodel');
		$this->CI->load->model('managermodel');

		$report = $this->reportDetail['report'];
		$report['user_info'] = $this->CI->membermodel->get_member_data_only_seq($report['member_seq']);
		$report['contents'] = nl2br(strip_tags($report['contents']));
		// 게시글 링크
		$report['realboardseq'] = isBoardTypeBoard($report['boardtype']) ? $report['boardseq'] : $report['boardparent'];
		$report['viewlink'] = "/admin/board/board?id={$report['boardid']}&seq={$report['realboardseq']}";
		$report['boardtype_txt'] = "게시글";
		if (isBoardTypeBoard($report['boardtype']) === false) {
			$report['viewlink'] .= '&cmtseq=' . $report['boardseq'];
			$report['boardtype_txt'] = "댓글";
		}

		//관리자 정보
		$manager_seq = $report['manager_seq'];
		$managerInfo = $this->CI->managermodel->get_manager($manager_seq);

		$report['manager_id'] = $managerInfo['manager_id'];
		$report['mname'] = $managerInfo['mname'];

		$this->reportDetail['report'] = $report;
	}

	/**
	 * 게시판 정보
	 */
	protected function reportManager()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('Boardmanager');

		$report = $this->reportDetail['report'];

		// 게시판정보
		$sc['whereis'] = ' and id= "' . $report['boardid'] . '" ';
		$sc['select'] = ' * ';
		$manager = $this->CI->Boardmanager->managerdataidck($sc);
		// 게시글 작성자 (비회원작성자는 작성당시의 정보로 get)
		$manager = get_admin_name([
			'mtype' => $board['mtype'],
			'mseq' => $board['mseq'],
			'manager' => $manager,
			'write_admin_format' => $manager['write_admin_format']
		]);
		$this->reportDetail['manager'] = $manager;
	}

}
