<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class member extends selleradmin_base {

	public function __construct() {
		parent::__construct();
		$this->template->assign('mname',$actor = $this->providerInfo['provider_name']);//$this->managerInfo['mname']
	}

	public function index()
	{
		redirect("/selleradmin/member/catalog");
	}

	### 회원리스트test
	public function catalog()
	{

		$this->load->model('snsmember');
		$this->load->model('membermodel');
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		// 개인 정보 조회 로그
		// $type,$manager_seq,$type_seq
		$this->load->model('logPersonalInformation');
		$this->logPersonalInformation->insert('memberlist',$this->managerInfo['manager_seq'],'');

		for ($m=1;$m<=12;$m++){	$m_arr[] = str_pad($m, 2, '0', STR_PAD_LEFT); }
		for ($d=1;$d<=31;$d++){	$d_arr[] = str_pad($d, 2, '0', STR_PAD_LEFT); }
		$this->template->assign('m_arr',$m_arr);
		$this->template->assign('d_arr',$d_arr);

		#### AUTH
		$auth_act		= $this->authmodel->manager_limit_act('member_act');
		if(isset($auth_act)) $this->template->assign('auth_act',$auth_act);
		$auth_promotion = $this->authmodel->manager_limit_act('member_promotion');
		if(isset($auth_promotion)) $this->template->assign('auth_promotion',$auth_promotion);
		$auth_send	= $this->authmodel->manager_limit_act('member_send');
		if(isset($auth_send)) $this->template->assign('auth_send',$auth_send);

		###
		if($_GET['header_search_keyword']) $_GET['keyword'] = $_GET['header_search_keyword'];

		### GROUP
		$group_arr = $this->membermodel->find_group_list();

		### SEARCH
		//print_r($_POST);
		$sc = $_GET;
		$sc['orderby']			= (isset($_GET['orderby'])) ?	$_GET['orderby']:'A.member_seq';
		$sc['sort']				= (isset($_GET['sort'])) ?		$_GET['sort']:'desc';
		$sc['page']				= (isset($_GET['page'])) ?		intval($_GET['page']):0;
		$sc['perpage']			= (isset($_GET['perpage'])) ?	intval($_GET['perpage']):10;


		// 판매환경
		if( $_GET['sitetype'] ){
			$sc['sitetype'] = implode('\',\'',$_GET['sitetype']);
		}

		// 가입양식	if( $_GET['rute'] )$sc['rute'] = implode('\',\'',$_GET['rute']);
 		if( $_GET['snsrute'] ) {
			foreach($_GET['snsrute'] as $key=>$val){$sc[$val] = 1;}
		}


		### MEMBER
		$data = $this->membermodel->admin_member_list($sc);

		### PAGE & DATA
		$sc['searchcount']	 = $data['count'];
		$sc['total_page']	 = ceil($sc['searchcount']	 / $sc['perpage']);
		$cntquery = $this->db->query("select count(*) as cnt from fm_member where status in ('done','hold') ");
		$cntrow = $cntquery->result_array();
		$sc['totalcount'] = $cntrow[0]['cnt'];

		$idx = 0;
		$this->load->model('Goodsreview','Boardmodel');//리뷰건
		foreach($data['result'] as $datarow){
			$idx++;
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;

			$adddata = $this->membermodel->get_member_seq_only($datarow['member_seq']);
			$datarow['email'] = $adddata['email'];
			$datarow['phone'] = $adddata['phone'];
			$datarow['cellphone'] = $adddata['cellphone'];
			$datarow['group_name'] = $adddata['group_name'];

			$datarow['type']	= $datarow['business_seq'] ? '기업' : '개인';

			if($datarow['business_seq']){
				$datarow['user_name'] = $datarow['bname'];
				$datarow['cellphone'] = $datarow['bcellphone'];
				$datarow['phone'] = $datarow['bphone'];
			}

			//리뷰건
			$sc['whereis'] = ' and mseq='.$datarow['member_seq'];
			$sc['select'] = ' count(gid) as cnt ';
			$gdreviewquery = $this->Boardmodel->get_data($sc);
			$datarow['gdreview_sum'] = $gdreviewquery['cnt'];

			if($datarow['rute'] != "none" ) {
				$snsmbsc['select'] = ' * ';
				$snsmbsc['whereis'] = ' and member_seq = \''.$datarow['member_seq'].'\' ';
				$snslist = $this->snsmember->snsmb_list($snsmbsc);
				if($snslist['result'][0]) $datarow['snslist'] = $snslist['result'];
			}

			/****/

			$dataloop[] = $datarow;
		}

		###
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtag($sc['searchcount'],$sc['perpage'],$this->membermodel->admin_member_url($file_path).'?', getLinkFilter('',array_keys($sc)) );

		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';

		//가입환경
		$sitetypeloop = sitetype($_GET['sitetype'], 'image', 'array');
		$this->template->assign('sitetypeloop',$sitetypeloop);

		//가입양식
		$ruteloop = memberrute($_GET['rute'], 'image', 'array');
		$this->template->assign('ruteloop',$ruteloop);

		$this->template->assign('pagin',$paginlay);
		$this->template->assign('group_arr',$group_arr);
		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);



		$this->template->assign('query_string',get_query_string());

		$this->template->define('member_list',$this->skin.'/member/member_list.html');
		$this->template->define('member_search',$this->skin.'/member/member_search.html');
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}


	public function set_search_default(){
		foreach($_POST as $key => $data){
			if( is_array($data) ){
				foreach($data as $key2 => $data2){
					if($data2) $cookie_arr[] = $key."[".$key2."]"."=".$data2;
				}
			}else if($data){
				$cookie_arr[] = $key."=".$data;
			}
		}
		if($cookie_arr){
			$cookie_str = implode('&',$cookie_arr);
			if($_POST['gb']=='withdrawal'){
				$_COOKIE['withdrawal_search'] = $cookie_str;
				setcookie('withdrawal_search',$cookie_str,time()+86400*30);
			}else{
				$_COOKIE['member_list_search'] = $cookie_str;
				setcookie('member_list_search',$cookie_str,time()+86400*30);
			}
		}
		$callback = "parent.closeDialog('search_detail_dialog');";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}

	public function get_search_default(){
		$arr = explode('&',$_COOKIE['member_list_search']);
		foreach($arr as $data){
			$arr2 = explode("=",$data);
			$result[] = $arr2;

		}
		echo json_encode($result);
	}

	public function get_search_withdrawal(){
		$arr = explode('&',$_COOKIE['withdrawal_search']);
		foreach($arr as $data){
			$arr2 = explode("=",$data);
			$result[] = $arr2;

		}
		echo json_encode($result);
	}



	### 회원상세
	public function detail()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		#### AUTH
		$auth_act		= $this->authmodel->manager_limit_act('member_act');
		if(isset($auth_act)) $this->template->assign('auth_act',$auth_act);
		$auth_promotion = $this->authmodel->manager_limit_act('member_promotion');
		if(isset($auth_promotion)) $this->template->assign('auth_promotion',$auth_promotion);
		$auth_send	= $this->authmodel->manager_limit_act('member_send');
		if(isset($auth_send)) $this->template->assign('auth_send',$auth_send);

		if(!isset($_GET['member_seq'])){
			$callback = "parent.history.back();";
			openDialogAlert("잘못된 접근입니다.",400,140,'parent',$callback);
			die();
		}

		// 개인정보 조회 로그
		//'member', 'memberlist', 'order', 'export', 'return', 'refund', 'orderexcel', 'exportexcel'
		$this->load->model('logPersonalInformation');
		$this->logPersonalInformation->insert('member',$this->managerInfo['manager_seq'],$_GET['member_seq']);

		###
		$this->load->model('membermodel');
		$data = $this->membermodel->get_member_data($_GET['member_seq']);
		if($data['auth_type']=='auth'){
			$data['auth_type'] = "실명인증";
		}else if($data['auth_type']=='ipin'){
			$data['auth_type'] = "아이핀";
		}else{
			$data['auth_type'] = "없음";
		}

		$data['zip_arr'] = explode("-",$data['zipcode']);
		$data['bzip_arr'] = explode("-",$data['bzipcode']);

		$withdrawal = code_load('withdrawal');
		if($withdrawal) $this->template->assign('withdrawal_arr',$withdrawal);

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

		//1:1문의건
		$this->load->model('Boardmodel');
		$sc['whereis'] = " and boardid = 'mbqna'   and mseq='".$data['member_seq']."'";
		$sc['select'] = " count(gid) as cnt ";
		$mbqnaquery = $this->Boardmodel->get_data($sc);
		$data['mbqna_sum'] = $mbqnaquery['cnt'];

		$sc['whereis'] = " and re_contents!='' and boardid = 'mbqna'  and mseq='".$data['member_seq']."'";
		$sc['select'] = " count(gid) as cnt ";
		$mbqnareplyquery = $this->Boardmodel->get_data($sc);
		$data['mbqna_reply'] = $mbqnareplyquery['cnt'];//답변완료수 / 전체질문수

		//리뷰건
		$this->load->model('goodsreview');
		$sc['whereis'] = " and mseq='".$data['member_seq']."'";
		$sc['select'] = " count(gid) as cnt ";
		$gdreviewquery = $this->goodsreview->get_data($sc);
		$data['gdreview_sum'] = $gdreviewquery['cnt'];

		//상품문의건
		$this->load->model('goodsqna');
		$sc['whereis'] = "and mseq= ?";
		$bindData = [$data['member_seq']];
		$sc['select'] = " count(gid) as cnt ";
		$gdqnaquery = $this->goodsqna->get_data($sc, $bindData);
		$data['gdqna_sum'] = $gdqnaquery['cnt'];

		//쿠폰보유건 test
		$this->load->model('couponmodel');
		$dsc['whereis'] = " and use_status='unused' and member_seq='".$data['member_seq']."'";
		$data['coupondownloadtotal'] = $this->couponmodel->get_download_total_count($dsc);

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

		$data['totalrecommend'] = $data['member_recommend_cnt'];// 추천회원수

		//$arr_step 	= config_load('step');
		$order_summary = array();
		/*
		입금을 확인하세요! : 주문접수
		상품을 출고하세요! : 결제확인, 상품준비, 부분출고준비, 부분출고완료, 부분배송중, 부분배송완료
		출고를 완료하세요! : 출고준비
		배송을 완료하세요! : 출고완료, 배송중
		반품을 회수하세요! : 반품접수, 반품 처리 중
		환불을 처리하세요! : 환불접수, 환불 처리 중
		*/

		/* 입금을 확인하세요 */
		$query = "
		select sum(settleprice) as settleprice, count(*) as cnt,
		( select sum(ea) from fm_order_item_option where item_seq in (select item_seq from fm_order_item where order_seq = fm_order.order_seq) ) as option_ea,
		( select sum(ea) from fm_order_item_suboption where item_seq in (select item_seq from fm_order_item where order_seq = fm_order.order_seq) ) as suboption_ea
		from fm_order where step = '15' and member_seq=?";
		$query = $this->db->query($query,$data['member_seq']);
		$result = $query->row_array();
		$order_summary[] = array(
			'title'			=> '입금을 확인하세요',
			'settleprice'	=> $result['settleprice'],
			'count'			=> $result['cnt'],
			'ea'			=> $result['option_ea']+$result['suboption_ea'],
			'link'			=> '../order/catalog?chk_step[15]=1&keyword='.$data['userid']
		);

		/* 상품을 출고하세요 */
		$query = "
		select sum(settleprice) as settleprice, count(*) as cnt,
		( select sum(ea) from fm_order_item_option where item_seq in (select item_seq from fm_order_item where order_seq = fm_order.order_seq) ) as option_ea,
		( select sum(ea) from fm_order_item_suboption where item_seq in (select item_seq from fm_order_item where order_seq = fm_order.order_seq) ) as suboption_ea
		from fm_order where step in ('25','35','40','50','60','70') and member_seq=?";
		$query = $this->db->query($query,$data['member_seq']);
		$result = $query->row_array();
		$order_summary[] = array(
			'title'		=> '상품을 출고하세요',
			'settleprice'	=> $result['settleprice'],
			'count'			=> $result['cnt'],
			'ea'			=> $result['option_ea']+$result['suboption_ea'],
			'link'		=> '../order/catalog?chk_step[25]=1&chk_step[35]=1&chk_step[40]=1&chk_step[50]=1&chk_step[60]=1&chk_step[70]=1&keyword='.$data['userid']
		);

		/* 출고를 완료하세요 */
		$query = "
		SELECT count(exp.export_seq) cnt ,
		sum(opt.price*item.ea) opt_price,
		sum(sub.price*item.ea) sub_price,
		sum(item.ea) ea
		FROM
		fm_goods_export exp
			LEFT JOIN fm_order ord ON ord.order_seq=exp.order_seq
		,fm_goods_export_item item
			LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = item.option_seq and item.option_seq
			LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = item.suboption_seq and item.suboption_seq
		WHERE exp.export_code=item.export_code AND exp.status='45' and ord.member_seq=?
		group by exp.export_seq";

		$query = $this->db->query($query,$data['member_seq']);
		$result = array();
		foreach($query->result_array() as $tmp){
			$result['cnt'] += $tmp['cnt'];
			$result['settleprice'] += $tmp['opt_price']+$tmp['sub_price'];
			$result['ea'] += $tmp['ea'];
		}
		$order_summary[] = array(
			'title'		=> '출고를 완료하세요',
			'settleprice'	=> $result['settleprice'],
			'count'			=> $result['cnt'],
			'ea'			=> $result['ea'],
			'link'		=> '../export/catalog?export_status[45]=1&keyword='.$data['userid']
		);

		/* 배송을 완료하세요 */
		$query = "
		SELECT count(exp.export_seq) cnt ,
		sum(opt.price*item.ea) opt_price,
		sum(sub.price*item.ea) sub_price,
		sum(item.ea) ea
		FROM
		fm_goods_export exp
			LEFT JOIN fm_order ord ON ord.order_seq=exp.order_seq
		,fm_goods_export_item item
			LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = item.option_seq and item.option_seq
			LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = item.suboption_seq and item.suboption_seq
		WHERE exp.export_code=item.export_code AND exp.status in ('55','65') and ord.member_seq=?
		group by exp.export_seq";

		$query = $this->db->query($query,$data['member_seq']);
		$result = array();
		foreach($query->result_array() as $tmp){
			$result['cnt'] += $tmp['cnt'];
			$result['settleprice'] += $tmp['opt_price']+$tmp['sub_price'];
			$result['ea'] += $tmp['ea'];
		}
		$order_summary[] = array(
			'title'		=> '배송을 완료하세요',
			'settleprice'	=> $result['settleprice'],
			'count'			=> $result['cnt'],
			'ea'			=> $result['ea'],
			'link'		=> '../export/catalog?export_status[55]=1&export_status[65]=1&keyword='.$data['userid']
		);

		/* 반품을 회수하세요 */
		$query = "
		SELECT count(ret.return_seq) cnt ,
		sum(opt.price*item.ea) opt_price,
		sum(sub.price*item.ea) sub_price,
		sum(item.ea) ea
		FROM
		fm_order_return ret
			LEFT JOIN fm_order ord ON ord.order_seq=ret.order_seq
		,fm_order_return_item item
			LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = item.option_seq and item.option_seq
			LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = item.suboption_seq and item.suboption_seq
		WHERE ret.return_code=item.return_code AND ret.status in ('request','ing') and ord.member_seq=?
		group by ret.return_seq";
		$query = $this->db->query($query,$data['member_seq']);
		$result = array();
		foreach($query->result_array() as $tmp){
			$result['cnt'] += $tmp['cnt'];
			$result['settleprice'] += $tmp['opt_price']+$tmp['sub_price'];
			$result['ea'] += $tmp['ea'];
		}
		$order_summary[] = array(
			'title'		=> '반품을 회수하세요',
			'settleprice'	=> $result['settleprice'],
			'count'			=> $result['cnt'],
			'ea'			=> $result['ea'],
			'link'		=> '../returns/catalog?return_status[]=request&return_status[]=ing&keyword='.$data['userid']
		);

		/* 환불을 처리하세요 */
		$query = "
		SELECT count(ret.refund_seq) cnt ,
		sum(opt.price*item.ea) opt_price,
		sum(sub.price*item.ea) sub_price,
		sum(item.ea) ea
		FROM
		fm_order_refund ret
			LEFT JOIN fm_order ord ON ord.order_seq=ret.order_seq
		,fm_order_refund_item item
			LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = item.option_seq and item.option_seq
			LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = item.suboption_seq and item.suboption_seq
		WHERE ret.refund_code=item.refund_code AND ret.status in ('request','ing') and ord.member_seq=?
		group by ret.refund_seq";
		$query = $this->db->query($query,$data['member_seq']);
		$result = array();
		foreach($query->result_array() as $tmp){
			$result['cnt'] += $tmp['cnt'];
			$result['settleprice'] += $tmp['opt_price']+$tmp['sub_price'];
			$result['ea'] += $tmp['ea'];
		}
		$order_summary[] = array(
			'title'		=> '환불을 처리하세요',
			'settleprice'	=> $result['settleprice'],
			'count'			=> $result['cnt'],
			'ea'			=> $result['ea'],
			'link'		=> '../refund/catalog?refund_status[]=request&refund_status[]=ing&keyword='.$data['userid']
		);

		foreach($order_summary as $tmp){
			$tot_order_summary['settleprice'] += $tmp['settleprice'];
			$tot_order_summary['count'] 	+= $tmp['count'];
			$tot_order_summary['ea'] 		+= $tmp['ea'];
		}


		###
		$temp_arr	= $this->membermodel->get_order_count($data['member_seq']);
		$data['order_cnt'] = $temp_arr['cnt'];
		$data['order_sum'] = $temp_arr['sum'];

		if(!$tot_order_summary['settleprice']) $tot_order_summary['settleprice'] = $temp_arr['sum'];

		for ($m=1;$m<=12;$m++){	$m_arr[] = str_pad($m, 2, '0', STR_PAD_LEFT); }
		for ($d=1;$d<=31;$d++){	$d_arr[] = str_pad($d, 2, '0', STR_PAD_LEFT); }
		$this->template->assign('m_arr',$m_arr);
		$this->template->assign('d_arr',$d_arr);
		$this->template->assign('query_string',$_GET['query_string']);

		$this->template->assign($data);
		$this->template->assign(array(
			'order_summary'		=> $order_summary,
			'tot_order_summary'	=> $tot_order_summary
		));
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function emoney_detail()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$member_seq = $_GET['member_seq'];
		###
		$this->load->model('membermodel');
		$data = $this->membermodel->get_member_data($member_seq);
		$this->template->assign($data);

		###
		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
		$sms	= new SMS_SEND();
		$params	= "sms_id=" . $sms->sms_account . '&sms_pw=' . $sms->sms_password;
		$params = makeEncriptParam($params);
		$limit	= ($sms->limit != -1) ? number_format($sms->limit) : 0;
		$this->template->assign('count',$limit);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function point_detail()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$member_seq = $_GET['member_seq'];
		###
		$this->load->model('membermodel');
		$data = $this->membermodel->get_member_data($member_seq);
		$this->template->assign($data);

		###
		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
		$sms	= new SMS_SEND();
		$params	= "sms_id=" . $sms->sms_account . '&sms_pw=' . $sms->sms_password;
		$params = makeEncriptParam($params);
		$limit	= ($sms->limit != -1) ? number_format($sms->limit) : 0;
		$this->template->assign('count',$limit);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function cash_detail()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$member_seq = $_GET['member_seq'];
		###
		$this->load->model('membermodel');
		$data = $this->membermodel->get_member_data($member_seq);
		$this->template->assign($data);

		###
		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
		$sms	= new SMS_SEND();
		$params	= "sms_id=" . $sms->sms_account . '&sms_pw=' . $sms->sms_password;
		$params = makeEncriptParam($params);
		$limit	= ($sms->limit != -1) ? number_format($sms->limit) : 0;
		$this->template->assign('count',$limit);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function sms_pop()
	{
		$aParams	= $this->input->get();

		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		if($aParams['member_seq']){
			$member_seq = $aParams['member_seq'];
			###
			$this->load->model('membermodel');
			$data = $this->membermodel->get_member_data($member_seq);
			$this->template->assign($data);
		}
		if($aParams['cellphone']){
			$this->template->assign('cellphone',$aParams['cellphone']);
		}
		if($aParams['page']){
			$this->template->assign('page',$aParams['page']);
		}

		//티켓상품의 확인코드 SMS보내기
		if($aParams['certify_code']){
			$certify_code_msg = $this->config_basic['shopName']."쇼핑몰에서 판매된 티켓 상품에 대하여 구매자가 귀사 매장 방문 시 티켓 사용 확인코드는 ".$aParams['certify_code']."입니다.";
			$this->template->assign('certify_code_msg',$certify_code_msg);
		}


		###
		include_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/sms.class.php";
		$auth			= config_load('master');
		$sms_id			= $this->config_system['service']['sms_id'];
		$sms_api_key	= $auth['sms_auth'];
		$gabiaSmsApi	= new gabiaSmsApi($sms_id,$sms_api_key);		
		$params			= "sms_id=" . $sms_id . '&sms_pw=' . md5($sms_id);
		$params			= makeEncriptParam($params);
		$limit			= $gabiaSmsApi->getSmsCount();
		$this->template->assign('count',$limit);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}


	public function email_pop()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$member_seq = $_GET['member_seq'];
		if($member_seq){
			$this->load->model('membermodel');
			$data = $this->membermodel->get_member_data($member_seq);
			$this->template->assign($data);
		}else if($_GET['email']){
			$data['email'] = $_GET['email'];
			$this->template->assign($data);
		}

		$basic = config_load('basic');
		$master = config_load('master');

		###
		$query = $this->db->query("select * from fm_log_email order by seq desc limit 10");
		$emailData = $query->result_array();

		###
		$this->load->model('usedmodel');
		$email_chk = $this->usedmodel->hosting_check();
		$this->template->assign('email_chk',$email_chk);

		###
		$this->template->assign(array('mail_count'=>$master['mail_count'],'email'=>$data['email']));
		$this->template->assign('loop',$emailData);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function cash_pop()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$member_seq = $_GET['member_seq'];
		if($member_seq){
			$this->load->model('membermodel');
			$data = $this->membermodel->get_member_data($member_seq);
			$this->template->assign($data);
		}else if($_GET['email']){
			$data['email'] = $_GET['email'];
			$this->template->assign($data);
		}

		$basic = config_load('basic');
		$master = config_load('master');

		###
		$query = $this->db->query("select * from fm_log_email order by seq desc limit 10");
		$emailData = $query->result_array();

		###
		$this->load->model('usedmodel');
		$email_chk = $this->usedmodel->hosting_check();
		$this->template->assign('email_chk',$email_chk);

		###
		$this->template->assign(array('mail_count'=>$master['mail_count'],'email'=>$data['email']));
		$this->template->assign('loop',$emailData);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function emoney_list()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$member_seq = $_GET['member_seq'];

		###
		$sc = $_GET;
		$sc['page']				= (isset($_GET['page'])) ?		intval($_GET['page']):'0';
		$sc['member_seq']		= $member_seq;
		$sc['perpage']			= '5';

		$this->load->model('membermodel');

		$data = $this->membermodel->emoney_list($sc);

		$sc['searchcount']	 = $data['count'];
		$sc['total_page']	 = ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount']	 = get_rows('fm_emoney',array('member_seq'=>$member_seq));
		$idx = 0;
		foreach($data['result'] as $datarow){
			$idx++;
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;
			/**
			$datarow['contents'] = "";
			if($datarow['type']=='order'){
				$datarow['contents'] = "주문번호 ".$datarow['ordno'];
			}else if($datarow['type']=='join'){
				$datarow['contents'] = "회원가입";
			}else if($datarow['type']=='bookmark'){
				$datarow['contents'] = "즐겨찾기";
			}else if($datarow['type']=='refund'){
				$datarow['contents'] = "환불 ".$datarow['ordno'];
			}
			**/
			$datarow['mname'] = get_manager_name($datarow['manager_seq']);
			$dataloop[] = $datarow;
		}

		###
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtag($sc['searchcount'],$sc['perpage'],$this->membermodel->admin_member_url($file_path).'?', getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
		$this->template->assign('pagin',$paginlay);

		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function used_history(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$type	= $_GET['type'];
		$seq	= $_GET['seq'];
		$table	= "fm_".$type;
		$seq_nm	= $type."_seq";

		$sql = "select A.*, B.memo as pmemo from fm_used_log A left join {$table} B ON A.used_seq = B.{$seq_nm} where A.parent_seq = '{$seq}' order by A.seq asc";
		//echo $sql;
		$query = $this->db->query($sql);
		foreach($query->result_array() as $v){
			/**
			if($v['type']=='order'){
				$v['contents'] = "주문번호 ".$v['ordno'];
			}else if($v['type']=='join'){
				$v['contents'] = "회원가입";
			}else if($v['type']=='bookmark'){
				$v['contents'] = "즐겨찾기";
			}else if($v['type']=='refund'){
				$v['contents'] = "환불 ".$v['ordno'];
			}
			**/
			$loop[] = $v;
		}
		$this->template->assign('loop',$loop);

		//print_r($loop);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}


	public function point_list()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$member_seq = $_GET['member_seq'];

		###
		$sc = $_GET;
		$sc['page']				= (isset($_GET['page'])) ?		intval($_GET['page']):'0';
		$sc['member_seq']		= $member_seq;
		$sc['perpage']			= '5';

		$this->load->model('membermodel');

		$data = $this->membermodel->point_list($sc);

		$sc['searchcount']	 = $data['count'];
		$sc['total_page']	 = ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount']	 = get_rows('fm_point',array('member_seq'=>$member_seq));
		$idx = 0;
		foreach($data['result'] as $datarow){
			$idx++;
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;
			/**
			$datarow['contents'] = "";
			if($datarow['type']=='order'){
				$datarow['contents'] = "주문번호 ".$datarow['ordno'];
			}else if($datarow['type']=='join'){
				$datarow['contents'] = "회원가입";
			}else if($datarow['type']=='bookmark'){
				$datarow['contents'] = "즐겨찾기";
			}else if($datarow['type']=='refund'){
				$datarow['contents'] = "환불 ".$datarow['ordno'];
			}
			**/
			$datarow['mname'] = get_manager_name($datarow['manager_seq']);
			$dataloop[] = $datarow;
		}

		###
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtag($sc['searchcount'],$sc['perpage'],$this->membermodel->admin_member_url($file_path).'?', getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
		$this->template->assign('pagin',$paginlay);

		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function cash_list()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$member_seq = $_GET['member_seq'];

		###
		$sc = $_GET;
		$sc['page']				= (isset($_GET['page'])) ?		intval($_GET['page']):'0';
		$sc['member_seq']		= $member_seq;
		$sc['perpage']			= '5';

		$this->load->model('membermodel');

		$data = $this->membermodel->cash_list($sc);

		$sc['searchcount']	 = $data['count'];
		$sc['total_page']	 = ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount']	 = get_rows('fm_point',array('member_seq'=>$member_seq));
		$idx = 0;
		foreach($data['result'] as $datarow){
			$idx++;
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;
			/**
			$datarow['contents'] = "";
			if($datarow['type']=='order'){
				$datarow['contents'] = "주문번호 ".$datarow['ordno'];
			}else if($datarow['type']=='join'){
				$datarow['contents'] = "회원가입";
			}else if($datarow['type']=='bookmark'){
				$datarow['contents'] = "즐겨찾기";
			}else if($datarow['type']=='refund'){
				$datarow['contents'] = "환불 ".$datarow['ordno'];
			}
			**/
			$datarow['mname'] = get_manager_name($datarow['manager_seq']);
			$dataloop[] = $datarow;
		}

		###
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtag($sc['searchcount'],$sc['perpage'],$this->membermodel->admin_member_url($file_path).'?', getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
		$this->template->assign('pagin',$paginlay);

		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	//초대하기 내역입니다.
	public function invite_list()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		###

		$this->load->model('membermodel');
		$this->load->model('snsfbinvite');
		unset($sc);
		### SEARCH
		$sc = $_GET;
		$sc['orderby']		= (!empty($_GET['orderby'])) ?	$_GET['orderby']:'seq';
		$sc['sort']				= (!empty($_GET['sort'])) ?			$_GET['sort']:'desc';
		$sc['page']			= (!empty($_GET['page'])) ?		intval($_GET['page']):0;
		$sc['perpage']		= (!empty($_GET['perpage'])) ?	intval($_GET['perpage']):10;
		$sc['member_seq']			= $_GET['member_seq'];
		$data = $this->snsfbinvite->snsinvite_list_search($sc);

		/**
		 * count setting
		**/
		$sc['searchcount']	 = $data['count'];
		$sc['total_page']	 = @ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount']	 = $this->snsfbinvite->get_item_total_count($sc);

		$idx = 0;
		foreach($data['result'] as $datarow){
			$idx++;
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;
			$datarow['date']			= substr($datarow['r_date'],2,14);//초대일

			$datarow['joinck'] = ($datarow['joinck'] == 1)? "Y":"N";
			$dataloop[] = $datarow;
		}

		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtagfront($sc['searchcount'],$sc['perpage'],'?member_seq='.$_GET['member_seq'], getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
		$this->template->assign('pagin',$paginlay);
		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}


	//추천하기 내역입니다.
	public function recommend_list()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		###

		$this->load->model('membermodel');
		$data = $this->membermodel->get_member_data($_GET['member_seq']);
		unset($sc);
		### SEARCH
		$sc = $_GET;
		$sc['orderby']		= (!empty($_GET['orderby'])) ?	$_GET['orderby']:'seq';
		$sc['sort']				= (!empty($_GET['sort'])) ?			$_GET['sort']:'desc';
		$sc['page']			= (!empty($_GET['page'])) ?		intval($_GET['page']):0;
		$sc['perpage']		= (!empty($_GET['perpage'])) ?	intval($_GET['perpage']):10;
		$sc['recommend']			= $data['userid'];
		$data = $this->membermodel->recommend_list($sc);

		/**
		 * count setting
		**/
		$sc['searchcount']	 = $data['count'];
		$sc['total_page']	 = @ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount']	 = $this->membermodel->recommend_total_count($sc);

		$idx = 0;
		foreach($data['result'] as $datarow){
			$idx++;
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;
			$datarow['date']			= substr($datarow['regist_date'],2,14);//추천(가입)일
			$dataloop[] = $datarow;
		}
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtagfront($sc['searchcount'],$sc['perpage'],'?member_seq='.$_GET['member_seq'], getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
		$this->template->assign('pagin',$paginlay);
		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	###
	public function withdrawal()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		###
		$sc = $_GET;
		$sc['orderby']			= (isset($_GET['orderby'])) ?	$_GET['orderby']:'withdrawal_seq';
		$sc['sort']				= (isset($_GET['sort'])) ?		$_GET['sort']:'desc';
		$sc['page']				= (isset($_GET['page'])) ?		intval($_GET['page']):'0';
		$sc['perpage']			= (isset($_GET['perpage'])) ?	intval($_GET['perpage']):'10';

		###
		$this->load->model('membermodel');
		$data = $this->membermodel->admin_withdrawal_list($sc);

		$sc['searchcount']	 = $data['count'];
		$sc['total_page']	 = ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount']	 = get_rows('fm_member',array('status'=>'withdrawal'));
		$idx = 0;
		foreach($data['result'] as $datarow){
			$idx++;
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;
			$dataloop[] = $datarow;
		}

		###
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtag($sc['searchcount'],$sc['perpage'],$this->membermodel->admin_member_url($file_path).'?', getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
		$this->template->assign('pagin',$paginlay);

		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	### SMS발송관리
	public function sms()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		##
		$sms_info = config_load('sms_info');
		if($sms_info['send_num']) $send_num = explode("-",$sms_info['send_num']);
		if($sms_info['admis_cnt']>0){
			for($i=0;$i<$sms_info['admis_cnt'];$i++){
				$id = "admins_num_".$i;
				$v['number'] = explode("-",$sms_info[$id]);
				$admins_arr[] = $v;
			}
		}

		###
		$sms_arr = array("join","withdrawal","","order","settle","released","delivery","cancel","refund","findid","findpwd");//,"cs"
		$sms_dis = array("","disabled","","","","","","","","disabled","disabled");//,"disabled"
		$sms_text = array("회원가입 시","회원탈퇴 시","","주문접수 시","결제확인 시","출고완료 시","배송완료 시","결제취소→환불완료 시","반품→환불완료 시","아이디 찾기","비밀번호 찾기");//,"1:1문의 답변 시"
		$sms = config_load('sms');

		for($i=0;$i<count($sms_arr);$i++){
			###
			$v['name']	= $sms_arr[$i];
			$v['text']	= $sms_text[$i];

			###
			unset($v['user']);
			unset($v['admin']);
			if(isset($sms[$sms_arr[$i]."_user"])) $v['user'] = $sms[$sms_arr[$i]."_user"];
			if(isset($sms[$sms_arr[$i]."_admin"])) $v['admin'] = $sms[$sms_arr[$i]."_admin"];

			###
			unset($v['user_chk']);
			//unset($v['admin_chk']);
			unset($v['admins_chk']);
			if(isset($sms[$sms_arr[$i]."_user_yn"])) $v['user_chk'] = $sms[$sms_arr[$i]."_user_yn"];
			//if(isset($sms[$sms_arr[$i]."_admin_yn"])) $v['admin_chk'] = $sms[$sms_arr[$i]."_admin_yn"];
			for($j=0;$j<$sms_info['admis_cnt'];$j++){
				if(isset($sms[$sms_arr[$i]."_admins_yn_".$j])) $v['admins_chk'][] = $sms[$sms_arr[$i]."_admins_yn_".$j];
			}
			$v['disabled'] = $sms_dis[$i];
			$v['arr'] = $admins_arr;
			$loop[]		= $v;
		}
		$this->template->assign('loop',$loop);


		###
		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
		$sms	= new SMS_SEND();
		$sms_chk = $sms->sms_account;
		$auth = config_load('master');

		$this->template->assign('tab1','-on');
		$this->template->assign(array('send_num'=>$send_num,'admins_arr'=>$admins_arr,'chk'=>$sms_chk,'sms_auth'=>$auth['sms_auth']));
		//$this->template->assign(array('sms_arr'=>$sms_arr,'sms_text'=>$sms_text));
		$this->template->define('top_menu',$this->skin.'/member/top_menu.html');
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function sms_charge()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
		$sms	= new SMS_SEND();
		$params	= "sms_id=" . $sms->sms_account . '&sms_pw=' . $sms->sms_password;
		$params = makeEncriptParam($params);
		$limit	= ($sms->limit != -1) ? number_format($sms->limit) : 0;
		$sms_chk = $sms->sms_account;

		$this->template->assign('tab2','-on');
		$this->template->assign(array('count'=>$limit,'param'=>$params,'chk'=>$sms_chk));
		$this->template->define('top_menu',$this->skin.'/member/top_menu.html');
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function sms_payment(){
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		$mall_id	= isset($mall_id) ? $mall_id : $this->config_system['service']['cid'];
		$domain		= isset($this->config_system['subDomain']) ? $this->config_system['subDomain'] : $_SERVER['SERVER_NAME'];
		$arr_domain	= explode(".", $domain);
		if ($arr_domain[0]=="www") {
			$domain = substr($domain, 4);
		}
		$sms_call = "req_domain=".$domain."&req_mallid=".$mall_id."&req_type=SMS&req_url=/myhg/mylist/spec/firstmall/sms/index.php";
		$sms_call = makeEncriptParam($sms_call);

		$this->template->assign('param',$sms_call);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function sms_history()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		###
		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
		$sms	= new SMS_SEND();
		//$params	= "sms_id=" . $sms->sms_account . '&sms_pw=' . $sms->sms_password;
		$params	= "sms_id=" . $sms->sms_account;
		$params = makeEncriptParam($params);
		$sms_chk = $sms->sms_account;
		$maxDay	= date("'Y', 'm', 'd'", strtotime("-3 months"));
		$today = date("Y-m-d");
		$auth = config_load('master');

		###
		if($_GET['tran_phone']) $today = "";
		$this->template->assign('tran_phone',$_GET['tran_phone']);
		$this->template->assign('tab3','-on');
		$this->template->assign(array('maxDay'=>$maxDay,'today'=>$today,'param'=>$params,'chk'=>$sms_chk,'sms_auth'=>$auth['sms_auth']));
		$this->template->define('top_menu',$this->skin.'/member/top_menu.html');
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function sms_auth()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
		$sms	= new SMS_SEND();
		$params	= "sms_id=" . $sms->sms_account . '&sms_pw=' . $sms->sms_password;
		$params = makeEncriptParam($params);
		$limit	= ($sms->limit != -1) ? number_format($sms->limit) : 0;
		$sms_id = "";
		if($sms->sms_account){
			$sms_id = substr($sms->sms_account,0,2);
			for($i=0;$i<strlen($sms->sms_account)-2;$i++){
				$sms_id .= "*";
			}
		}
		$auth = config_load('master');

		$this->template->assign('tab4','-on');
		$this->template->assign(array('sms_id'=>$sms_id,'sms_auth'=>$auth['sms_auth'],'auth_date'=>$auth['auth_date']));
		$this->template->define('top_menu',$this->skin.'/member/top_menu.html');
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}




	### 이메일발송관리
	public function email()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		###
		$email_arr = array("join","withdrawal","order","settle","released","delivery","cancel","refund","findid","findpwd","cs","promotion");
		$email_text = array("회원가입","회원탈퇴","주문접수","결제확인","출고완료","배송완료","결제취소","환불완료","아이디찾기","비밀번호찾기","1:1문의","프로모션발급");
		$email = config_load('email');

		for($i=0;$i<count($email_arr);$i++){
			###
			$v['name']	= $email_arr[$i];
			$v['text']	= $email_text[$i];
			###
			unset($v['user_chk']);
			unset($v['admin_chk']);
			if(isset($email[$email_arr[$i]."_user_yn"])) $v['user_chk'] = $email[$email_arr[$i]."_user_yn"];
			if(isset($email[$email_arr[$i]."_admin_yn"])) $v['admin_chk'] = $email[$email_arr[$i]."_admin_yn"];
			$loop[]		= $v;
		}

		$basic = config_load('basic');

		$this->template->assign('email',$basic['companyEmail']);
		$this->template->assign('loop',$loop);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function email_history()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		###
		$sc = $_GET;
		$sc['orderby']			= (isset($_GET['orderby'])) ?	$_GET['orderby']:'seq';
		$sc['sort']				= (isset($_GET['sort'])) ?		$_GET['sort']:'desc';
		$sc['page']				= (isset($_GET['page'])) ?		intval($_GET['page']):'0';
		$sc['perpage']			= (isset($_GET['perpage'])) ?	intval($_GET['perpage']):'10';

		###
		$this->load->model('membermodel');
		$data = $this->membermodel->email_history_list($sc);

		$sc['searchcount']	 = $data['count'];
		$sc['total_page']	 = ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount']	 = get_rows('fm_log_email');
		$idx = 0;
		foreach($data['result'] as $datarow){
			$idx++;
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;
			$dataloop[] = $datarow;
		}

		###
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtag($sc['searchcount'],$sc['perpage'],$this->membermodel->admin_member_url($file_path).'?', getLinkFilter('',array_keys($sc)) );
		$this->template->assign('pagin',$paginlay);

		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	### 이메일대량발송
	public function amail()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		###
		$email_mass = config_load('email_mass');
		$email_mass['phoneArr']		= explode("-",$email_mass['phone']);
		$email_mass['mobileArr']	= explode("-",$email_mass['cellphone']);

		$this->template->assign($email_mass);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function amail_send()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		#### AUTH
		$auth_act		= $this->authmodel->manager_limit_act('member_act');
		if(isset($auth_act)) $this->template->assign('auth_act',$auth_act);
		$auth_promotion = $this->authmodel->manager_limit_act('member_promotion');
		if(isset($auth_promotion)) $this->template->assign('auth_promotion',$auth_promotion);
		$auth_send	= $this->authmodel->manager_limit_act('member_send');
		if(isset($auth_send)) $this->template->assign('auth_send',$auth_send);

		###
		$cid = preg_replace("/gabia-/","", $this->config_system['service']["cid"]);
		$email_mass = config_load('email_mass');
		$email_mass['cid']			= $cid;
		$email_mass['phoneArr']		= explode("-",$email_mass['phone']);
		$email_mass['mobileArr']	= explode("-",$email_mass['cellphone']);
		$email_mass['server_name']	= $_SERVER["SERVER_NAME"];
		$this->template->assign('mass',$email_mass);

		###
		$mInfo['total'] = get_rows('fm_member',array('status !='=>'withdrawal'));
		$basic = config_load('basic');
		$this->template->assign('mInfo',$mInfo);

		### GROUP
		$this->load->model('membermodel');
		$group_arr = $this->membermodel->find_group_list();

		### SEARCH
		//print_r($_POST);
		$sc = $_GET;
		$sc['orderby']			= (isset($_GET['orderby'])) ?	$_GET['orderby']:'member_seq';
		$sc['sort']				= (isset($_GET['sort'])) ?		$_GET['sort']:'desc';
		$sc['page']				= (isset($_GET['page'])) ?		intval($_GET['page']):'0';
		$sc['perpage']			= (isset($_GET['perpage'])) ?	intval($_GET['perpage']):'10';

		### MEMBER
		$data = $this->membermodel->admin_member_list($sc);

		### PAGE & DATA
		$sc['searchcount']	 = $data['count'];
		$sc['total_page']	 = ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount']	 = get_rows('fm_member',array('status !='=>'withdrawal'));
		$idx = 0;
		foreach($data['result'] as $datarow){
			$idx++;

			$adddata = $this->membermodel->get_member_seq_only($datarow['member_seq']);
			$datarow['email'] = $adddata['email'];
			$datarow['phone'] = $adddata['phone'];
			$datarow['cellphone'] = $adddata['cellphone'];
			$datarow['group_name'] = $adddata['group_name'];

			$datarow['type']	= $datarow['business_seq'] ? '기업' : '개인';
			$datarow['number']	= $sc['searchcount']	 - ( ($sc['page'] -1 ) * 1 + $idx + 1) + 1;

			if($datarow['business_seq']){
				$datarow['user_name'] = $datarow['bname'];
				$datarow['cellphone'] = $datarow['bcellphone'];
				$datarow['phone'] = $datarow['bphone'];
			}


			$dataloop[] = $datarow;
		}

		###
		if(isset($data)) $this->template->assign('loop',$dataloop);
		$paginlay = pagingtag($sc['searchcount'],$sc['perpage'],$this->membermodel->admin_member_url($file_path).'?', getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay))$paginlay = '<p><a class="on red">1</a><p>';
		$this->template->assign('pagin',$paginlay);



		$this->template->assign('group_arr',$group_arr);
		$this->template->assign('perpage',$sc['perpage']);
		$this->template->assign('sc',$sc);
		$this->template->assign('amail','Y');

		$this->template->define('member_list',$this->skin.'/member/member_list.html');
		$this->template->define('member_search',$this->skin.'/member/member_search.html');
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

		###
		if(!$email_mass['name'] && !$email_mass['email']){
			$callback = "<script>openDialog('이메일 대량 발송 설정','amail_chk',{'width':'300','height':'120'});</script>";
			echo $callback;
			exit;
		}
	}


	public function sms_form()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$table = !empty($_GET['table']) ? $_GET['table'] : 'fm_member';
		$this->template->assign('table',$table);

		###
		if($table=='fm_goods_restock_notify'){
			$mInfo['total'] = get_rows('fm_goods_restock_notify',array('notify_status'=>'none'));
			$action = "../goods_process/restock_notify_send_sms";
			$this->template->assign('action',$action);

			$this->template->assign('send_message',"[{$this->config_basic['shopName']}] 고객님께서 알림요청하신 상품({상품고유값},{상품명})이 재입고되었습니다.");
		}else{
			$mInfo['total'] = get_rows('fm_member',array('status !='=>'withdrawal'));
			$action = "../member_process/send_sms";
			$this->template->assign('action',$action);
		}
		$specialArr	= array('＃', '＆', '＊', '＠', '§', '※', '☆', '★', '○', '●', '◎', '◇', '◆', '□', '■', '△', '▲', '▽', '▼', '→', '←', '↑', '↓', '↔', '〓', '◁', '◀', '▷', '▶', '♤', '♠', '♡', '♥', '♧', '♣', '⊙', '◈', '▣', '◐', '◑', '▒', '▤', '▥', '▨', '▧', '▦', '▩', '♨', '☏', '☎', '☜', '☞', '¶', '†', '‡', '↕', '↗', '↙', '↖', '↘', '♭', '♩', '♪', '♬', '㉿', '㈜', '№', '㏇', '™', '㏂', '㏘', '℡', '?', 'ª', 'º');
		$basic = config_load('basic');

		###
		$sql = "select count(seq) as total, category from fm_sms_album group by category";
		$query = $this->db->query($sql);
		$sms_data = $query->result_array();
		$sms_total = get_rows('fm_sms_album');
		array_push($sms_data,array('total'=>$sms_total,'category'=>'전체보기'));
		rsort($sms_data);
		###
		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
		$sms	= new SMS_SEND();
		$params	= "sms_id=" . $sms->sms_account . '&sms_pw=' . $sms->sms_password;
		$params = makeEncriptParam($params);
		$limit	= ($sms->limit != -1) ? number_format($sms->limit) : 0;
		$sms_chk = $sms->sms_account;

		$this->template->assign('count',$limit);
		$this->template->assign(array('mInfo'=>$mInfo,'number'=>$basic['companyPhone']));
		$this->template->assign(array('sms_loop'=>$sms_data,'sms_total'=>$sms_total,'sms_cont'=>$specialArr,'chk'=>$sms_chk));
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function emoney_form()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		###
		$mInfo['total'] = get_rows('fm_member',array('status !='=>'withdrawal'));
		$this->template->assign('mInfo',$mInfo);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function point_form()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		###
		$mInfo['total'] = get_rows('fm_member',array('status !='=>'withdrawal'));
		$this->template->assign('mInfo',$mInfo);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function email_form()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$basic = config_load('basic');
		$master = config_load('master');

		###
		$query = $this->db->query("select * from fm_log_email order by seq desc limit 10");
		$emailData = $query->result_array();

		###
		$this->load->model('usedmodel');
		$email_chk = $this->usedmodel->hosting_check();
		$this->template->assign('email_chk',$email_chk);

		###
		$mInfo['total'] = get_rows('fm_member',array('status !='=>'withdrawal'));

		$this->template->assign(array('mail_count'=>$master['mail_count'],'email'=>$basic['companyEmail']));
		$this->template->assign('mInfo',$mInfo);
		$this->template->assign('loop',$emailData);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}
	public function delivery(){
		$file_path	= $this->template_path();
		$this->template->assign('member_seq',$_GET['member_seq']);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function delivery_address(){
		//login_check();
		$this->admin_menu();
		$this->tempate_modules();
		$this->load->helper('shipping');
		$file_path	= $this->template_path();

		$sc=array();
		$sc['page']				= (!empty($_GET['page'])) ?		intval($_GET['page']):'1';
		$sc['perpage']			= $perpage ? $perpage : 10;
		$list_order=$_GET['order'];

		switch($list_order){
			case 'desc_up' :
				$orderby='address_description asc';
				break;
			case 'desc_dn' :
				$orderby='address_description desc';
				break;
			case 'name_up' :
				$orderby='recipient_user_name asc';
				break;
			case 'name_dn' :
				$orderby='recipient_user_name desc';
				break;
			case 'name_dn' :
				$orderby='address_seq desc';
				break;
			default :
				$orderby='address_seq desc';
				break;
		}

		$shipping = use_shipping_method();
		if( $shipping ){
			foreach($shipping as $key => $data){
				if($data) $shipping_cnt[$key] = count($data);
			}
		}
		$shipping_policy['policy'] 	= $shipping;
		$shipping_policy['count'] 	= $shipping_cnt;

		$deli_cnt = count($shipping_policy['policy']);

		$member_seq = $_GET['member_seq'];

		$tab=$_GET['tab'];
		$key = get_shop_key();

		$popup=$_GET['popup'];

		$sql="select *,
				AES_DECRYPT(UNHEX(recipient_phone), '{$key}') as recipient_phone,
				AES_DECRYPT(UNHEX(recipient_cellphone), '{$key}') as recipient_cellphone
			from fm_delivery_address ";

		if($popup == '1'){
			if($tab=='2'){
				if($deli_cnt < 2){
					$sql .= " where member_seq=".$member_seq." and lately='Y' and international ='domestic' order by ".$orderby." limit 30";
				}else{
					$sql .= " where member_seq=".$member_seq." and lately='Y' order by ".$orderby." limit 30";
				}
			}else{
				if($deli_cnt < 2){
					$sql .= " where member_seq=".$member_seq." and often='Y' and international ='domestic' order by ".$orderby." limit 30";
				}else{
					$sql .= "  where member_seq=".$member_seq." and often='Y'  order by ".$orderby." limit 30";
				}
			}
			$query = $this->db->query($sql);
			$result['record'] = $query -> result_array();
		}else{
			if($tab=='2'){
				if($deli_cnt < 2){
					$sql .= " where member_seq=".$member_seq." and lately='Y' and international ='domestic' order by ".$orderby;
				}else{
					$sql .= " where member_seq=".$member_seq." and lately='Y' order by ".$orderby;
				}
			}else{
				if($deli_cnt < 2){
					$sql .= " where member_seq=".$member_seq." and often='Y' and international ='domestic' order by ".$orderby;
				}else{

					$sql .= " where member_seq=".$member_seq." and often='Y'  order by ".$orderby;
				}
			}
			$result = select_page($sc['perpage'],$sc['page'],10,$sql,array());

		}

		foreach($result['record'] as $data){
			if($data['international'] == 'domestic'){
				$international_show = '국내';
			}elseif($data['international'] == 'international'){
				$international_show = '해외';
			}
			$data['international_show'] = $international_show;
			$loop[] = $data;
		}


		$this->template->assign('shop_shipping_policy',$cart['shop_shipping_policy']);
		$this->template->assign('shipping_policy',$shipping_policy);
		$this->template->assign('loop',$loop);
		$this->template->assign('member_seq',$member_seq);
		$this->template->assign($result);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function replace_pop()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$this->load->model('membermodel');
		$this->template->assign('replaceText', $this->membermodel->get_replacetext());
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}
}

/* End of file member.php */
/* Location: ./app/controllers/selleradmin/member.php */