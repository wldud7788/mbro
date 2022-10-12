<?php
/**
 * 게시판/게시물 관련 관리자
 * @author gabia
 * @since version 2.0 - 2012.06.29
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/crm_base".EXT);

class Board extends crm_base {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('text','board','file','download','cookie'));
		$this->load->model('Boardmanager');
		$this->load->library('validation');

		$emoneyform = dirname($this->template_path())."/_emoney.html";
		$this->template->define(array('emoneyform'=>$emoneyform));
	}

	public function review_catalog(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		// Relected XSS 검증
		xss_clean_filter();

		define('BOARDID',"goods_review");
		$managersql['whereis']	= ' and id= "'.BOARDID.'" ';
		$managersql['select']		= ' * ';
		$this->manager = $this->Boardmanager->managerdataidck($managersql);//게시판정보

		$getParams = $this->input->get();
		$sc["perpage"] = $getParams['perpage'] ? $getParams['perpage'] : 15;
		$sc["page"] = $getParams['page'] ? $getParams['page'] : 1;

		$bindData = [];

		$whereSql = "where mseq = ?";
		$bindData[] = $this->mdata['member_seq'];

		if ($getParams['sdate']) {
			$whereSql .= " and r_date >= ?";
			$bindData[] = $getParams['sdate']." 00:00:00";
		}

		if ($getParams['edate']) {
			$whereSql .= " and r_date <= ?";
			$bindData[] = $getParams['edate']." 23:59:59";
		}

		if ($getParams['search_text']) {
			$whereSql .= " and (
				REPLACE(B.goods_name,' ','') like ?
				or A.subject like ?
				or A.contents like ?
			)";
			$bindData[] = "%".$getParams['search_text']."%";
			$bindData[] = "%".$getParams['search_text']."%";
			$bindData[] = "%".$getParams['search_text']."%";
		}

		if (in_array("buyed", $getParams['gb']) && in_array("unbuyed", $getParams['gb'])) {
		} else if(in_array("buyed", $getParams['gb'])) {
			$whereSql .= " and (A.order_seq is not null and A.order_seq != '')";
			$whereSql .= " or A.npay_product_order_id != 0 or A.talkbuy_product_order_id != 0"; // 네이버페이로 구매한 경우 or 톡구매한 경우
		} else if (in_array("unbuyed", $getParams['gb'])) {
			$whereSql .= " and (A.order_seq is null or A.order_seq = '')";
		}

		if (in_array("best", $getParams['gb'])) {
			$whereSql .= " and A.best = 'checked'";
		}

		$sql = "select * from fm_goods_review A left join fm_goods B on A.goods_seq = B.goods_seq {$whereSql} order by gid asc";
		$result = select_page($sc['perpage'], $sc['page'], 10, $sql, $bindData);

		foreach($result['record'] as $k=>$datarow){
		    $result['record'][$k]['seq']      = $datarow['seq'];
			$result['record'][$k]['scorelay'] = getGoodsScore($datarow['score'], $this->manager);
			$result['record'][$k]['autoemoneylay'] =  getBoardEmoneyAutotxt($datarow, $reviewless);//상품후기 삭제시 회수정보
			$result['record'][$k]['buyertitle']	= ($datarow['order_seq'])?'구매':'미구매';
			$result['record'][$k]['scorelay'] = getGoodsScore($datarow['score'], $this->manager);
			$result['record'][$k]['emoneylay']	 =  getBoardEmoneybtn($datarow, $this->manager);//마일리지

			$result['record'][$k]['modifybtn'] = '<input type="button"  name="boad_modify_btn" board_seq="'.$result['record'][$k]['seq'].'"  board_id="'.BOARDID.'" value="수정" class="resp_btn v2"/>';
			if($this->manager['auth_reply_use'] == 'Y') $result['record'][$k]['replaybtn'] = '<input type="button" name="boad_reply_btn" board_seq="'.$result['record'][$k]['seq'].'"  board_id="'.BOARDID.'" value="답변" class="resp_btn v2"/>';
			$result['record'][$k]['deletebtn'] = '<input type="button" name="boad_delete_btn" board_seq="'.$result['record'][$k]['seq'].'"  board_id="'.BOARDID.'" value="삭제" class="resp_btn v3"/>';

		}

		$this->template->assign($result);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function qna_catalog(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		// Relected XSS 검증
		xss_clean_filter();

		define('BOARDID',"goods_qna");
		$managersql['whereis']	= ' and id= "'.BOARDID.'" ';
		$managersql['select']		= ' * ';
		$this->manager = $this->Boardmanager->managerdataidck($managersql);//게시판정보

		$getParams = $this->input->get();

		$sc["perpage"] = $getParams['perpage'] ? $getParams['perpage'] : 15;
		$sc["page"] = $getParams['page'] ? $getParams['page'] : 1;


		$bindData = [];

		$whereSql = "where mseq = ?";
		$bindData[] = $this->mdata['member_seq'];

		if ($getParams['sdate']) {
			$whereSql .= " and r_date >= ?";
			$bindData[] = $getParams['sdate']." 00:00:00";
		}

		if($getParams['edate']){
			$whereSql .= " and r_date <= ?";
			$bindData[] = $getParams['edate']." 23:59:59";
		}

		if($getParams['search_text']){
			$whereSql .= " and (
				REPLACE(B.goods_name,' ','') like ?
				or A.subject like ?
				or A.contents like ?
			)";
			$bindData[] = "%".$getParams['search_text']."%";
			$bindData[] = "%".$getParams['search_text']."%";
			$bindData[] = "%".$getParams['search_text']."%";
		}

		$sql = "select * from fm_goods_qna A left join fm_goods B on A.goods_seq = B.goods_seq {$whereSql} order by gid asc";

		$result = select_page($sc['perpage'],$sc['page'],10,$sql, $bindData);

		foreach($result['record'] as $k=>$datarow){
		    $result['record'][$k]['seq']      = $datarow['seq'];
			$result['record'][$k]['scorelay'] = getGoodsScore($datarow['score'], $this->manager);
			$result['record'][$k]['autoemoneylay'] =  getBoardEmoneyAutotxt($datarow, $reviewless);//상품후기 삭제시 회수정보
			$result['record'][$k]['buyertitle']	= ($datarow['order_seq'])?'구매':'미구매';
			$result['record'][$k]['scorelay'] = getGoodsScore($datarow['score'], $this->manager);
			$result['record'][$k]['emoneylay'] =  getBoardEmoneybtn($datarow, $this->manager);//마일리지

			$result['record'][$k]['modifybtn'] = '<input type="button"  name="boad_modify_btn" board_seq="'.$result['record'][$k]['seq'].'"  board_id="'.BOARDID.'" value="수정" class="resp_btn v2"/>';
			if($this->manager['auth_reply_use'] == 'Y') $result['record'][$k]['replaybtn'] = '<input type="button" name="boad_reply_btn" board_seq="'.$result['record'][$k]['seq'].'"  board_id="'.BOARDID.'" value="답변" class="resp_btn v2" />';
			$result['record'][$k]['deletebtn'] = '<input type="button" name="boad_delete_btn" board_seq="'.$result['record'][$k]['seq'].'"  board_id="'.BOARDID.'" value="삭제" class="resp_btn v3"/>';

		}

		$this->template->assign($result);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function mbqna_catalog(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		// Relected XSS 검증
		xss_clean_filter();

		define('BOARDID',"mbqna");
		$managersql['whereis']	= ' and id= "'.BOARDID.'" ';
		$managersql['select']		= ' * ';
		$this->manager = $this->Boardmanager->managerdataidck($managersql);//게시판정보

		$getParams = $this->input->get();

		$sc["perpage"] = $getParams['perpage'] ? $getParams['perpage'] : 15;
		$sc["page"] = $getParams['page'] ? $getParams['page'] : 1;

		$bindData = [];
		$whereSql = "where boardid = 'mbqna' and mseq = ?";
		$bindData[] = $this->mdata['member_seq'];

		if ($getParams['sdate']) {
			$whereSql .= " and r_date >= ? ";
			$bindData[] = $getParams['sdate']." 00:00:00";
		}

		if ($getParams['edate']) {
			$whereSql .= " and r_date <= ? ";
			$bindData[] = $getParams['edate']." 23:59:59";
		}

		if ($getParams['search_text']) {
			$whereSql .= " and (
				subject like '%{$getParams['search_text']}%'
				or contents like '%{$getParams['search_text']}%'
			)";
		}

		$sql = "select * from fm_boarddata {$whereSql} order by gid asc";

		$result = select_page($sc['perpage'], $sc['page'], 10, $sql, $bindData);

		foreach($result['record'] as $k=>$datarow){
		    $result['record'][$k]['seq']      = $datarow['seq'];
			$result['record'][$k]['scorelay'] = getGoodsScore($datarow['score'], $this->manager);
			$result['record'][$k]['autoemoneylay'] =  getBoardEmoneyAutotxt($datarow, $reviewless);//상품후기 삭제시 회수정보
			$result['record'][$k]['buyertitle']	= ($datarow['order_seq'])?'구매':'미구매';
			$result['record'][$k]['scorelay'] = getGoodsScore($datarow['score'], $this->manager);
			$result['record'][$k]['emoneylay']	 =  getBoardEmoneybtn($datarow, $this->manager);//마일리지

			$result['record'][$k]['modifybtn'] = '<input type="button"  name="boad_modify_btn" board_seq="'.$result['record'][$k]['seq'].'"  board_id="'.BOARDID.'" value="수정" class="resp_btn v2"/>';
			$result['record'][$k]['replaybtn'] = ($result['record'][$k]['re_contents'])?'<input type="button" name="boad_reply_btn" board_seq="'.$result['record'][$k]['seq'].'"  board_id="'.BOARDID.'" value="답변수정" class="resp_btn v2"/>':'<input type="button" name="boad_reply_btn" board_seq="'.$datarow['seq'].'"  board_id="'.BOARDID.'" value="답변등록" class="resp_btn v2"/>';//관리자만가능
			$result['record'][$k]['deletebtn'] = '<input type="button" name="boad_delete_btn" board_seq="'.$result['record'][$k]['seq'].'"  board_id="'.BOARDID.'" value="삭제" class="resp_btn"/>';

		}

		$this->template->assign($result);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function counsel_catalog(){
		$aGetParams = $this->input->get();

		// validation
		if ($aGetParams) {
			$this->validation->set_data($aGetParams);
			$this->validation->set_rules('dateType', '검색일', 'trim|string|xss_clean');
			$this->validation->set_rules('sdate', '시작일', 'trim|string|xss_clean');
			$this->validation->set_rules('edate', '종료일', 'trim|string|xss_clean');
			$this->validation->set_rules('managerType', '상담자구분', 'trim|string|xss_clean');
			$this->validation->set_rules('manager_name', '상담자', 'trim|string|xss_clean');
			$this->validation->set_rules('counsel_status[]', '처리여부', 'trim|string|xss_clean');
			$this->validation->set_rules('relationType', '관련번호종류', 'trim|string|xss_clean');
			$this->validation->set_rules('relationCode', '관련번호', 'trim|string|xss_clean');
			$this->validation->set_rules('search_text', '상담내용', 'trim|string|xss_clean');
			if ($this->validation->exec() === false) {
				show_error($this->validation->error_array['value']);
			}
		}

		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		// Relected XSS 검증
		xss_clean_filter();

		$counsel_act_auth = $this->authmodel->manager_limit_act('counsel_act');
		$this->template->assign("counsel_act_auth", $counsel_act_auth);

		$getData = $this->input->get();

		$data['category'] = array("주문","배송","반품","환불");
		$sc["perpage"] = $getData['perpage'] ? $getData['perpage'] : 15;
		$sc["page"] = $getData['page'] ? $getData['page'] : 1;

		/* SQL INJECTION 방지를 위한 데이터 바인딩 처리 */
		$bindData = [];

		if(!$getData['dateType']) {
			$getData['dateType'] = "counsel_regdate";
		}

		if ($_SESSION['order_seq']) {
			$whereSql = "where order_seq = ? ";
			$bindData[] = $_SESSION['order_seq'];
		}else{
			$whereSql = "where member_seq = ? ";
			$bindData[] = $this->mdata['member_seq'];
		}

		if (in_array($getData['dateType'], ["counsel_regdate", "counsel_complete_date"])) {
			if ($getData['sdate']) {
				$whereSql .= " and ".$getData['dateType']." >= ? ";
				$bindData[] = $getData['sdate']." 00:00:00";
			}

			if ($getData['edate']) {
				$whereSql .= " and ".$getData['dateType']." <= ?";
				$bindData[] = $getData['edate']." 23:59:59";
			}
		}

		if ($getData['search_text']) {
			$whereSql .= " and (counsel_contents like ?) ";
			$bindData[] = "%".$getData['search_text']."%";
		}

		if ($getData['manager_name']) {
			$whereSql .= " and manager_name = ? ";
			$bindData[] = $getData['manager_name'];
		}

		if ($getData['relationCode']) {
			$whereSql .= " and ".$this->db->escape_str($getData['relationType'])." = ? ";
			$bindData[] = $getData['relationCode'];
		}


		if ($getData['counsel_status'] && is_array($getData['counsel_status'])) {
			$tempBind = [];
			foreach($getData['counsel_status'] as $value) {
				$tempBind[] = "?";
				$bindData[] = $value;
			}
			$counselStatus = join(",", $tempBind);
			$whereSql .= " and counsel_status in (".$counselStatus.")";
		}

		$sql = "select * from fm_counsel {$whereSql} order by counsel_seq desc";
		$result = select_page($sc['perpage'], $sc['page'], 10, $sql, $bindData);
		foreach($result['record'] as $key=>$data){
		    $result['record'][$key]['seq'] = $data['counsel_seq'];
			if($data['counsel_relation_no']){
				if($data['counsel_relation'] == "주문"){
					$result['record'][$key]['counsel_relation_no'] = "<a href='/admin/order/view?no=".$data['counsel_relation_no']."' target='_blank' style='color:#0796ec; font-weight:bold;'>".$data['counsel_relation_no']."</a>";
				}else if($data['counsel_relation'] == "출고"){
					$result['record'][$key]['counsel_relation_no'] = "<a href='/admin/export/view?no=".$data['counsel_relation_no']."' target='_blank' style='color:#0796ec; font-weight:bold;'>".$data['counsel_relation_no']."</a>";

				}else if($data['counsel_relation'] == "반품"){
					$result['record'][$key]['counsel_relation_no'] = "<a href='/admin/returns/view?no=".$data['counsel_relation_no']."' target='_blank' style='color:#0796ec; font-weight:bold;'>".$data['counsel_relation_no']."</a>";

				}else if($data['counsel_relation'] == "환불"){
					$result['record'][$key]['counsel_relation_no'] = "<a href='/admin/refund/view?no=".$data['counsel_relation_no']."' target='_blank' style='color:#0796ec; font-weight:bold;'>".$data['counsel_relation_no']."</a>";

				}
			}
		}

		/*
		 * 코드별 출력 내용(KR ORI)
		 * mp292: 배송 주문 불만족
		 * mp293: 사이트 이용 불편
		 * mp294: 상품품질 불만족
		 * mp295: 서비스 불만족
		 * mp291: 기타 / 기타 항목 마지막에 표시
		 */
		$withdrawal = array(getAlert('mp292'),getAlert('mp293'),getAlert('mp294'),getAlert('mp295'),getAlert('mp291'));
		$this->template->assign('withdrawal_arr',$withdrawal);
		$this->template->assign($result);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function get_blacklist(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$params = $this->input->post();
		if(!$params['page']) $params['page'] = 1;

		/* SQL INJECTION 이 발생할 여지가 있을 수 있으므로 member_seq 를 escape 처리하도록 함 */
		$memberSeq = $this->db->escape_str($_SESSION['member_seq']);

		if($_SESSION['member_seq']){
			$blackSql = "select * from fm_member_blacklist where member_seq = '".$memberSeq."' order by blacklist_seq desc";
		}else if($_SESSION['order_seq']){
			$blackSql = "select * from fm_member_blacklist where order_seq = '".$memberSeq."' order by blacklist_seq desc";
		}
		$blackList = select_page(5,$params['page'],5,$blackSql,array());
		$this->template->assign('blackList',$blackList['record']);
		$this->template->assign('blackListpage',$blackList['page']);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	public function set_blacklist_init(){
	    $params = array(
	        'blacklist_level'              => 0,
	        'blacklist_contents'           => '악성도 초기화',
	        'blacklist_regist_date'        => date('Y-m-d H:i:s'),
	        'blacklist_regist_manager_seq' => $this->managerInfo['manager_seq'],
	        'blacklist_regist_manager'     =>$this->managerInfo['mname'],
	    );

	    if($_SESSION['member_seq']){
	        $params['member_seq'] = $_SESSION['member_seq'];
	        $this->db->where('member_seq', $_SESSION['member_seq']);
	        $this->db->update('fm_member', array('blacklist' => 0));
	    }else if($_SESSION['order_seq']){
	        $params['order_seq'] = $_SESSION['order_seq'];
	        $this->db->where('order_seq', $_SESSION['order_seq']);
	        $this->db->update('fm_order', array('blacklist' => 0));
	    }

	    $result = $this->db->insert('fm_member_blacklist', $params);

	    echo $result;
	}
}