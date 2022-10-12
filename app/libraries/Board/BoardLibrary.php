<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
/**
 * 게시글 등록/수정 관련된 소스들이 컨트롤러와 모델에 산재되어 있어 향후 병합을 위한 라이브러리 구조
 * 2021-05-03
 * by hyem
 */
class BoardLibrary
{
	public $allow_exit = true;

	public $boardManager = [];
	public $boardid = '';

	public function BoardLibrary($parameters = [])
	{
		$this->CI = &get_instance();

		define('BOARDID', $parameters['boardid']);
		$this->boardid = $parameters['boardid'];
		if (BOARDID == 'goods_qna') {
			$this->CI->load->model('Goodsqna', 'Boardmodel');
		} elseif (BOARDID == 'goods_review') {
			$this->CI->load->model('Goodsreview', 'Boardmodel');
		} elseif (BOARDID == 'bulkorder') {//대량구매게시판
			$this->CI->load->model('Boardbulkorder', 'Boardmodel');
		} else {
			$this->CI->load->model('Boardmodel');
		}

		$this->CI->load->helper('board');
		$this->CI->load->model('Boardmanager');
		$this->CI->load->model('Boardindex');

		// review 게시판 설정 조회
		$sc['whereis'] = ' and id= "' . BOARDID . '" ';
		$sc['select'] = ' * ';
		$this->boardManager = $this->CI->Boardmanager->managerdataidck($sc);
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

		$board_data = $this->CI->Boardmodel->get_data($params);

		return $board_data;
	}

	/**
	 * 게시글 등록
	 */
	public function data_write($params, $config = [])
	{
		// 게시글 아이디
		$params['boardid'] = $this->boardid;
		// 공지글
		$params['notice'] = $params['onlynotice'] = 0;
		// 비밀글(무조건)
		$params['hidden'] = ($this->boardManager['secret_use'] == 'A') ? '1' : '0';

		// 부가정보
		$params['r_date'] = $params['r_date'] ? $params['r_date'] : date('Y-m-d H:i:s');
		$params['m_date'] = $params['r_date'];
		$params['ip'] = $this->CI->input->ip_address();
		$params['agent'] = $this->CI->input->server('HTTP_USER_AGENT');

		// 답글 알림 여부
		$params['rsms'] = $params['rsms'] ? $params['rsms'] : 'N';
		$params['remail'] = $params['remail'] ? $params['remail'] : 'N';

		// 글쓴이 정보
		$params['mseq'] = $params['mseq'] ? $params['mseq'] : '';
		$params['mid'] = $params['mid'] ? $params['mid'] : '';
		$params['name'] = $params['name'] ? $params['name'] : '';

		// 상품정보
		if ($params['goods_seq']) {
			$goodsInfo = $this->get_goods_info($params['goods_seq']);
			$params['provider_seq'] = $goodsInfo['provider_seq'];
		}

		// depth
		$params['parent'] = $params['parent'] ? $params['parent'] : 0;
		$params['gid'] = $this->get_gid();
		$params['depth'] = $params['depth'] ? $params['depth'] : 0;

		if ($params['addFiles'] && $config['insert_image']) {
			$params['contents'] = $this->content_insert_file($params['addFiles'], $params['contents'], $config['insert_image']);
		}

		$result = $this->CI->Boardmodel->data_write($params);
		// 게시글 등록 후 처리
		if ($result) {
			if (BOARDID == 'goods_review') {
				goods_review_count(['goods_seq' => $orderProduct['ProductID']], $result);
			}
			$this->board_insert_after_proc($params['gid']);
		}

		return $result;
	}

	/**
	 * 게시글 수정
	 */
	public function data_modify($params, $config = [])
	{
		$params['m_date'] = date('Y-m-d H:i:s');

		if ($params['addFiles'] && $config['insert_image']) {
			$params['contents'] = $this->content_insert_file($params['addFiles'], $params['contents'], $config['insert_image']);
		}

		$result = $this->CI->Boardmodel->data_modify($params);

		if (BOARDID == 'goods_review') {
			goods_review_count(['goods_seq' => $orderProduct['ProductID']], $result);
		}

		return $result;
	}

	/**
	 * 게시글 등록 후 처리
	 */
	public function board_insert_after_proc($gid)
	{
		$idxparams = [];
		$idxparams['onlynotice'] = 0; //공지영역만 노출여부
		$idxparams['onlynotice_sdate'] = ''; //공지노출 시작일
		$idxparams['onlynotice_edate'] = ''; //공지노출 완료일

		$idxparams['gid'] = $gid; //고유번호
		$idxparams['boardid'] = BOARDID; //id
		$this->CI->Boardindex->idx_write($idxparams);

		$this->boardManager['totalnum'] += 1;
		$upmanagerparams = ['totalnum' => $this->boardManager['totalnum']];
		$this->CI->Boardmanager->manager_item_save($upmanagerparams, BOARDID);
	}

	/**
	 * 상품 정보 추출
	 */
	public function get_goods_info($goods_seq)
	{
		if (!$goods_seq) {
			return;
		}
		if (!$this->CI->goodsmodel) {
			$this->CI->load->model('goodsmodel');
		}

		// 상품 정보 조회
		return $this->CI->goodsmodel->get_goods($goods_seq);
	}

	/**
	 * gid return
	 */
	public function get_gid()
	{
		// 게시글 gid 추출
		$minsql['whereis'] = ' ';
		$minsql['select'] = ' min(gid) as mingid ';
		$mindata = $this->CI->Boardmodel->get_data($minsql);
		$gid = $mindata['mingid'] ? $mindata['mingid'] - 1 : 100000000.00;

		return $gid;
	}

	/**
	 * 첨부파일 본문에 삽입
	 */
	public function content_insert_file($files, $contents, $mode)
	{
		// 첨부파일 contents 하단에 삽입
		if ($files) {
			foreach ($files as $image) {
				$incimage[] = '<img src="' . $image['url'] . '" alt="' . $image['name'] . '"  class="txc-image" /><br /><br />';
			}
			if ($mode == 'bottom') {
				$contents = $contents . '<br /><br />' . @implode(' ', $incimage);
			}
		}

		return $contents;
	}
}
