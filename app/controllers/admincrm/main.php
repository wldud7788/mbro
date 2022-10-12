<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/crm_base".EXT);

class main extends crm_base {

	public function __construct() {
		parent::__construct();
		$this->load->helper('member');
		$this->load->model('membermodel');
		$this->template->assign('mname',$this->managerInfo['mname']);

		// 보안키 입력창
		$member_download_info = $this->skin.'/member/member_download_info.html';
		$this->template->define(array("member_download_info"=>$member_download_info));

	}

	public function main_index()
	{
		redirect("/admincrm/main/index");
	}

	// 메인화면
	public function index()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	// 메인화면
	public function user_detail($type = '')
	{
		$this->admin_menu();
		$this->tempate_modules();

		$file_path	= $this->template_path();

		// 개인정보 조회 로그
		//'member', 'memberlist', 'order', 'export', 'return', 'refund', 'orderexcel', 'exportexcel'
		$this->load->model('logPersonalInformation');
		$this->logPersonalInformation->insert('member', $this->managerInfo['manager_seq'], $this->input->get("member_seq"));
		
		/* SQL INJECTION 이 발생할 여지가 있을 수 있으므로 member_seq 를 escape 처리하도록 함 */
		$this->mdata["member_seq"] = $this->db->escape_str($this->mdata["member_seq"]);

		$data = $this->mdata;


		$data['zip_arr'] = explode("-",$data['zipcode']);
		$data['bzip_arr'] = explode("-",$data['bzipcode']);

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

		$joinform = ($this->joinform)?$this->joinform:config_load('joinform');
		if($joinform) $this->template->assign('joinform',$joinform);
		$this->template->assign('memberIcondata',memberIconConf());

		//가입 추가 정보 리스트
		//$mdata = $this->mdata;
		$qry = "select * from fm_joinform where used='Y' order by sort_seq";
		$query = $this->db->query($qry);
		$form_arr = $query -> result_array();
		foreach ($form_arr as $k => $subdata){
		$msubdata=$this->membermodel->get_subinfo($data['member_seq'],$subdata['joinform_seq']);
		$subdata['label_view'] = $this -> membermodel-> get_labelitem_type($subdata,$msubdata);
		$sub_form[] = $subdata;
		}
		$this->template->assign('form_sub',$sub_form);

		###
		$grade_list = $this->membermodel->find_group_list();

		$grade_list = array_reverse($grade_list);
		$this->template->assign('grade_list',$grade_list);
		//print_r($grade_list);
		$this->load->model('snsmember');

		$snsmbsc['select'] = " * ";
		$snsmbsc['whereis'] = " and member_seq ='".$data['member_seq']."' ";
		$snslist = $this->snsmember->snsmb_list($snsmbsc);
		if($snslist['result'][0]) $data['snslist'] = $snslist['result'];

		if($data['sns_f']) {//facebook 전용인경우
			foreach($snslist['result'] as $snslist){
				if( $snslist['sns_f'] == $data['sns_f'] ) {
					$snsmb['sns'] = $snslist;
					break;
				}
			}
			if($snsmb) $this->template->assign($snsmb);

			$data['totalinviteck'] = $data['member_invite_cnt'];// 추천회원수

			//$fquery = $this->db->query("select count(A.member_seq) as total from fm_memberinvite A LEFT JOIN fm_member B ON A.member_seq = B.member_seq WHERE B.fb_invite = '".$data['member_seq']."' and B.status = 'done' ");
			$fquery = $this->db->query("select count(member_seq) as total from fm_member WHERE fb_invite = '".$data['member_seq']."' and status != 'withdrawal' ");
			$snsftotal = $fquery->row_array();
			$data['totalinvitejoin'] = $snsftotal['total'];//초대후 회원가입된 회원수
		}

		$oftenDeliveryResult = $this->membermodel->get_delivery_address($data['member_seq'],'often');
		if(!$oftenDeliveryResult){
			$oftenDeliveryResult = $this->membermodel->get_delivery_address($data['member_seq'],'lately');
		}
		$oftenDelivery = $oftenDeliveryResult[0];
		$this->template->assign("oftenDelivery",$oftenDelivery);

		$this->template->assign($data);
		
		// 가입환경 텍스트 추가
		$this->template->assign("platformText",sitetype($data['platform'],'image',''));
		
		// POS 용 바코드 번호 추출
		$this->load->library('o2o/o2oinitlibrary');
		$this->o2oinitlibrary->init_admincrm_main_user_detail($data['member_seq']);

		// 회원 처리주문 요약 :: 2015-03-24 lwh
		$orderSummary	= array();
		$step_arr		= array('15'=>'주문접수', '25'=>'결제확인', '35'=>'상품준비', '40'=>'부분출고준비', '45'=>'출고준비', '50'=>'부분출고완료', '55'=>'출고완료', '60'=>'부분배송중', '65'=>'배송중', '70'=>'부분배송완료');
		$date_range	= " and b.regist_date between '"
					. date('Y-m-d', strtotime('-30 day'))." 00:00:00' "
					. " and '".date('Y-m-d')." 23:59:59' ";

		$sql	= "
				SELECT order_seq
				FROM fm_order as b
				WHERE hidden = 'N'
				and member_seq = '".$this->mdata['member_seq']."'
				and step in (15)
				".$date_range."
				order by order_seq asc
				";
		$query	= $this->db->query($sql);
		$orderReady = $query->result_array();
		$this->template->assign('orderReady',$orderReady);

		$sql	= "
				SELECT order_seq
				FROM fm_order as b
				WHERE hidden = 'N'
				and member_seq = '".$this->mdata['member_seq']."'
				and step in (25,35,40,50,60,70)
				".$date_range."
				order by order_seq asc
				";
		$query	= $this->db->query($sql);
		$exportReady = $query->result_array();
		$this->template->assign('exportReady',$exportReady);

		/* 반품 접수 */
		$query = $this->db->query("select return_code from fm_order_return as b left join fm_order as o on b.order_seq = o.order_seq where b.status = 'request' and o.member_seq = '".$this->mdata['member_seq']."' ".$date_range);
		$returnReady = $query->result_array();
		$this->template->assign('returnReady',$returnReady);


		/* 환불 접수 */
		$query = $this->db->query("select refund_code from fm_order_refund as b left join fm_order as o on b.order_seq = o.order_seq where b.status = 'request' and o.member_seq = '".$this->mdata['member_seq']."' ".$date_range);
		$refundReady = $query->result_array();
		$this->template->assign('refundReady',$refundReady);

		//1:1문의건
		$query = $this->db->query("select seq from fm_boarddata where boardid = 'mbqna' and (re_contents = '' or re_contents is null)  and mseq='".$this->mdata['member_seq']."'");
		$mbqnaReady = $query->result_array();
		$this->template->assign('mbqnaReady',$mbqnaReady);

		//상품문의건
		$query = $this->db->query("select seq from fm_goods_qna where (re_contents = '' or re_contents is null) and mseq='".$this->mdata['member_seq']."'");
		$gdqnaReady = $query->result_array();
		$this->template->assign('gdqnaReady',$gdqnaReady);

		$counselSql = "select counsel_seq from fm_counsel where member_seq = '".$this->mdata['member_seq']."' and counsel_status = 'request'";
		$counselQuery = $this->db->query($counselSql);
		$counselReady = $counselQuery->result_array();
		$this->template->assign('counselReady',$counselReady);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}
}

/* End of file main.php */
/* Location: ./app/controllers/admin/main.php */