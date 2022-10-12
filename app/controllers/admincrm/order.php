<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/crm_base".EXT);

class order extends crm_base {

	public function __construct() {
		parent::__construct();
		$this->load->model('ordermodel');
		$this->load->model('providermodel');
		$this->load->helper('order');
		$this->load->library('validation');
		$this->arr_step = config_load('step');
		$this->arr_payment = config_load('payment');
		$this->cfg_order = config_load('order');

		$auth = $this->authmodel->manager_limit_act('order_view');
		if(!$auth){
			pageBack("관리자 권한이 없습니다.");
			exit;
		}
	}

	public function index()
	{
		redirect("/admincrm/order/catalog");
	}

	public function catalog()
	{
		$aGetParams = $this->input->get();

		// validation
		if ($aGetParams) {
			$this->validation->set_data($aGetParams);
			$this->validation->set_rules('ajaxCall', '여부', 'trim|numeric|xss_clean');
			$this->validation->set_rules('body_order_search_type', '검색선택', 'trim|string|xss_clean');
			$this->validation->set_rules('keyword', '검색어', 'trim|string|xss_clean');
			$this->validation->set_rules('date_field', '검색일', 'trim|string|xss_clean');
			$this->validation->set_rules('regist_date[]', '등록일', 'trim|string|xss_clean');
			$this->validation->set_rules('chk_step[]', '주문상태', 'trim|string|xss_clean');
			$this->validation->set_rules('payment[]', '결제수단', 'trim|string|xss_clean');
			if ($this->validation->exec() === false) {
				show_error($this->validation->error_array['value']);
			}
		}

		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		// Relected XSS 검증
		xss_clean_filter();

		$this->load->model('returnmodel');
		$this->load->model('refundmodel');
		$this->load->model('membermodel');
		$this->load->helper('shipping');
		$this->load->model('openmarketmodel');
		$this->load->model('goodsflowmodel');

		## 굿스플로 서비스 체크 @nsg 2015-10-19
		$goodsflow = $this->goodsflowmodel->get_goodsflow_setting();
		$this->template->assign('goodsflow',$goodsflow);

		$getParams = $this->input->get();
		//유입매체
		$sitemarketplaceloop = sitemarketplace($getParams['sitemarketplace'], 'image', 'array');

		//오픈마켓연동정보
		if	($this->openmarketmodel->chk_linkage_service()){
			$linkage = $this->openmarketmodel->get_linkage_config();
			if($linkage){
				// 설정된 판매마켓 정보
				$linkage_mallnames = array();
				$linkage_mallnames_for_search = array();
				$linkage_malldata		= $this->openmarketmodel->get_linkage_mall();
				$linkage_malldata		= $this->openmarketmodel->sort_linkage_mall($linkage_malldata);

				foreach($linkage_malldata as $k => $data){
					if	($data['default_yn'] == 'Y'){
						$linkage_mallnames[$data['mall_code']]	= preg_replace("/\(.*\)/","",$data['mall_name']);
						$linkage_mallnames_for_search[]	= array(
							'mall_code' => $data['mall_code'],
							'mall_name' => preg_replace("/\(.*\)/","",$data['mall_name'])
						);
					}
				}
				$this->template->assign('linkage_mallnames_for_search',$linkage_mallnames_for_search);
				$this->template->assign('linkage_mallnames',$linkage_mallnames);
			}
		}

		// 기본세팅이 없는경우 이번달 주문을 검색조건으로 합니다.
		if( $getParams['ajaxCall'] ){
			$getParams['regist_date'][0] = date('Y-m-01');
			$getParams['regist_date'][1] = date('Y-m-t');
		}

		$record = "";

		//상품리스트에서 [조회] 클릭시 해당 상품 주문 리스트 검색용. @2015-09-21 pjm
		if($getParams['goods_seq']){
			$getParams['keyword'] = $getParams['goods_seq'];
		}

		if($getParams['header_search_keyword']) {
			$getParams['keyword'] = $getParams['header_search_keyword'];
		}

		## 유입경로 그룹
		$this->load->model('statsmodel');
		$referer_list	= $this->statsmodel->get_referer_grouplist();
		$this->template->assign('referer_list',$referer_list);


		// 현재의 처리 프로세스
		$orders = config_load('order');
		$this->template->assign($orders);
		$export_cfg = config_load('export');
		$this->template->assign($export_cfg);
		$this->template->assign('config_system',$this->config_system);
		$this->template->define(array('order_process'=>$this->skin."/setting/_order_process.html"));

		$print_setting_path = dirname($this->template_path()).'/../setting/_print_setting.html';
		$this->template->define(array('print_setting'=>$print_setting_path));

		//판매환경
		$sitetypeloop = sitetype($getParams['sitetype'], 'image', 'array');
		$this->template->assign('sitetypeloop',$sitetypeloop);
		$this->template->assign('order_list_search',$_COOKIE['order_list_search']);
		$this->template->assign('old_list',$getParams['old_list']);

		$this->template->assign('sitemarketplaceloop',$sitemarketplaceloop);
		$this->template->assign(array('able_step_action' => $this->ordermodel->able_step_action));

		// 엑셀 출고
		$excel_export_path = dirname($this->template_path()).'/_excel_export.html';
		$this->template->define(array('excel_export'=>$excel_export_path));

		$excel_export_path = dirname($this->template_path()).'/_excel_delivery_code.html';
		$this->template->define(array('excel_delivery_code'=>$excel_export_path));

		$invoice_guide_path = dirname($this->template_path()).'/_invoice_guide.html';
		$this->template->define(array('invoice_guide'=>$invoice_guide_path));

		// 엑셀 검색 다운로드
		$excel_download_path = dirname($this->template_path()).'/_excel_download.html';
		$this->template->define(array('excel_dwonload'=>$excel_download_path));

		if ($getParams['ajaxCall']) {
			$ajaxCall = $getParams['ajaxCall'];
		} else {
			$ajaxCall = $_POST['ajaxCall'];
		}

		$this->template->assign('ajaxCall',$ajaxCall);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign(array('record' => $record));
		$this->template->print_("tpl");
	}


	public function catalog_ajax(){

		$this->load->model('refundmodel');
		$this->load->model('returnmodel');
		$this->load->model('ordermodel');
		$this->load->model('openmarketmodel');

		//오픈마켓연동정보
		$linkage_malldata = $this->openmarketmodel->get_linkage_support_mall('shoplinker');
		if($linkage_malldata) {
			foreach($linkage_malldata as $key=>$malldata){
				 $linkage_mallnames[$malldata['mall_code']] = $malldata['mall_name'];
			}
		}
		$this->template->assign('linkage_mallnames',$linkage_mallnames);

		$_PARAM	= $this->input->post();//$_GET//$_POST
		unset($_PARAM['stepBox']);


		$page = (trim($_PARAM['page'])) ? trim($_PARAM['page']) : 1;
		$bfStep = trim($_PARAM['bfStep']) != '' ? trim($_PARAM['bfStep']) : -1;

		/* SQL INJECTION 각 메소드에서 처리하기엔 로직이 너무 방대하므로 전역적으로 escape 처리하도록 함 */
		$bfStep = $this->db->escape_str($bfStep);

		$no = trim($_PARAM['nnum']);

		if (!$_PARAM['ajaxCall']) {
			$_PARAM['member_seq'] = $_SESSION['member_seq'];
		}

		if ($_PARAM['member_seq']) {
			$_PARAM['member_seq'] = $this->db->escape_str($_PARAM['member_seq']);
		}


		$query	= $this->ordermodel->get_order_catalog_query($_PARAM);

		if	($query){
			if	($page == 1){
				$_PARAM['query_type']	= 'total_record';
				$totalQuery				= $this->ordermodel->get_order_catalog_query($_PARAM);
				$totalData				= $totalQuery->result_array();
				$no						= $totalData[0]['cnt'];
			}

			foreach($query->result_array() as $k => $data){
				$data['linkage_mallname'] = str_replace("(주)","",$linkage_mallnames[$data['linkage_mall_code']]);
				if(!$data['linkage_mallname'] ) $data['linkage_mallname'] = "내사이트";

				$data['mstep'] = $this->arr_step[$data['step']];

				$data['sitetypetitle']		= sitetype($data['sitetype'], 'image', '');//판매환경
				$data['marketplacetitle']	= sitemarketplace($data['marketplace'], 'image', '');//유입매체

				$tmp = explode(' ',$data['bank_account']);
				$data['bankname'] = $tmp[0];

				###
				//$data['opt_cnt']	= $this->ordermodel->get_option_count('opt', $data['order_seq']);
				//$data['gift_cnt']	= $this->ordermodel->get_option_count('gift', $data['order_seq']);
				$data['gift_nm']	= $this->ordermodel->get_gift_name($data['order_seq']);
				$data['tot_ea']	= $data['opt_ea']+$data['sub_ea'];

				//반품정보 가져오기
				$data['return_list_ea'] = 0;
				$data_return = $this->returnmodel->get_return_for_order($data['order_seq'],"return");
				if($data_return) foreach($data_return as $row_return){
					$data['return_list_ea'] += $row_return['ea'];
				}

				//교환정보 가져오기
				$data['exchange_list_ea'] = 0;
				$data_exchange = $this->returnmodel->get_return_for_order($data['order_seq'],"exchange");
				if($data_exchange) {
					foreach($data_exchange as $row_exchange) {
						$data['exchange_list_ea'] += $row_exchange['ea'];
					}
				}

				//환불정보 가져오기
				$data['refund_list_ea'] = 0;
				$data['cancel_list_ea'] = 0;
				$data_refund = $this->refundmodel->get_refund_for_order($data['order_seq']);
				if ($data_refund) {
					foreach($data_refund as $row_refund){
						if ( $row_refund['refund_type'] == 'cancel_payment' ) {
							$data['cancel_list_ea'] += $row_refund['ea'];
						} else {
							$data['refund_list_ea'] += $row_refund['ea'];
						}
					}
				}

				$data['mpayment'] = $this->arr_payment[$data['payment']];
				$step_cnt[$data['step']]++;
				$tot_settleprice[$data['step']] += $data['settleprice'];
				$tot[$data['step']][$data['important']] += $data['settleprice'];

				$data['step_cnt'] = $step_cnt;
				$data['tot_settleprice'] = $tot_settleprice;
				$data['tot'][$data['important']] = $tot[$data['step']][$data['important']];

				if ($data['member_seq']) {
					$data['member_type'] = $data['mbinfo_business_seq'] ? '기업' : '개인';
				}

				$data['loop']	= $loop;
				$data['no']		= $no;

				if ($data['payment'] == 'bank' && $data['bank_account']) {
					$bank_tmp			= explode(' ', $data['bank_account']);
					$bank_name			= str_replace('은행', '', $bank_tmp[0]);
					$data['bank_name']	= $bank_name;
				}

				if ($data['deposit_date']=="0000-00-00 00:00:00") {
					$data['deposit_date'] = "";
				}

				if ($_PARAM['stepBox'][$data['step']]) {
					if ($_POST['stepBox'][$data['step']] == 'select') {
						$data['thischeck']	= true;
					} elseif ($_POST['stepBox'][$data['step']] == 'important') {
						if ($data['important']) {
							$data['thischeck']	= true;
						}
					} elseif ($_POST['stepBox'][$data['step']] == 'not-important') {
						if (!$data['important']) {
							$data['thischeck']	= true;
						}
					}
				}

				## 시작점과 종료점
				if	($bfStep != $data['step']){
					$data['start_step']	= $data['step'] > 0 ? $data['step'] : 1;
					if	($bfStep > -1){
						$record[$k]['end_step']			= $bfStep;
						$_PARAM['query_type']			= 'summary';
						$_PARAM['end_step']				= $bfStep;
						$summary_query					= $this->ordermodel->get_order_catalog_query($_PARAM);
						$endData						= $summary_query->result_array();
						$data['end_mstep']				= $this->arr_step[$bfStep];
						$data['end_step']				= $bfStep;
						$data['end_step_cnt']			= $endData[0]['cnt'];
						$data['end_step_settleprice']	= $endData[0]['total_settleprice'];
					}
					$bfStep	= $data['step'];
				}

				if	($no == 1){
					$_PARAM['query_type']			= 'summary';
					$_PARAM['end_step']				= $data['step'];
					$summary_query					= $this->ordermodel->get_order_catalog_query($_PARAM);
					$endData						= $summary_query->result_array();
					$data['last_step']				= $data['step'];
					$data['last_step_cnt']			= $endData[0]['cnt'];
					$data['last_step_settleprice']	= $endData[0]['total_settleprice'];
				}

				$record[$k] = $data;
				$final_step	= $data['step'];

				$no--;
			}
		}

		if ($_GET['ajaxCall']) {
			$ajaxCall = $_GET['ajaxCall'];
		} else {
			$ajaxCall = $_POST['ajaxCall'];
		}

		//관리자 로그
		$this->searchcount = $no;

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->assign(array('stepBox' => $_PARAM['stepBox']));
		$this->template->assign(array('page' => $page));
		$this->template->assign(array('final_no' => $no));
		$this->template->assign(array('final_step' => $final_step));
		$this->template->assign(array('record' => $record));
		$this->template->assign(array('able_step_action' => $this->ordermodel->able_step_action));
		$this->template->assign(array('ajaxCall'=>$ajaxCall));
		$this->template->print_("tpl");
	}

	public function return_catalog()
	{
		$aGetParams = $this->input->get();

		// validation
		if ($aGetParams) {
			$this->validation->set_data($aGetParams);
			$this->validation->set_rules('date_field', '검색일', 'trim|string|xss_clean');
			$this->validation->set_rules('sdate', '시작일', 'trim|string|xss_clean');
			$this->validation->set_rules('edate', '종료일', 'trim|string|xss_clean');
			$this->validation->set_rules('return_status[]', '상태', 'trim|string|xss_clean');
			if ($this->validation->exec() === false) {
				show_error($this->validation->error_array['value']);
			}
		}

		$this->admin_menu();
		$this->tempate_modules();

		// Relected XSS 검증
		xss_clean_filter();

		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('refund_view');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}
		/* 관리자 권한 체크 : 끝 */

		$this->load->model('returnmodel');
		$this->load->model('refundmodel');
		$this->load->model('ordermodel');

		$getParams = $this->input->get();

		if( count($getParams) == 0 ){
			$getParams['sdate'] = date('Y-m-d');
			$getParams['edate'] = date('Y-m-d');
			$getParams['return_status'] = array('request','ing');
		}

		$where = array();

		// 검색어
		if( $getParams['keyword'] ){

			$keyword_type = preg_replace("/[^a-z_.]/i","",trim($getParams['keyword_type']));
			$keyword = str_replace("'","\'",trim($getParams['keyword']));
			$keyword = $this->db->escape($keyword);

			if($keyword_type){
				$where[] = "{$keyword_type} = '" . $keyword . "'";
			// 검색어가 주문번호 일 경우
			}else if( preg_match('/^([0-9]{19})$/',$keyword) ){
				$where[] = "ref.order_seq = '" . $keyword . "'";

			// 검색어가 출고번호 일 경우
			}else if(preg_match('/^([D0-9]{9,11})$/',$keyword)){
				$where[] = "ref.order_seq = (SELECT order_seq FROM fm_goods_export WHERE export_code = '" . $keyword . "')";
			// 검색어가 반품번호 일 경우
			}else if(preg_match('/^([R0-9]{9,11})$/',$keyword)){
				$where[] = "ref.return_code = '" . $keyword . "'";
			// 검색어가 환불번호 일 경우
			}else if(preg_match('/^([C0-9]{9,11})$/',$keyword)){
				$where[] = "ref.order_seq = (SELECT order_seq FROM fm_order_refund WHERE refund_code = '" . $keyword . "')";
			}else{

				$where[] = "
				(
					mem.user_name like '%" . $keyword . "%' OR
					bus.bname like '%" . $keyword . "%' OR
					ord.order_user_name  like '%" . $keyword . "%' OR
					ord.depositor like '%" . $keyword . "%' OR
					ord.order_email like '%" . $keyword . "%' OR
					ord.order_phone like '%" . $keyword . "%' OR
					ord.order_cellphone like '%" . $keyword . "%' OR
					mem.userid like '%" . $keyword . "%' OR
					ref.return_code like '%" . $keyword . "%' OR
					EXISTS (
						SELECT shipping_seq FROM fm_order_shipping WHERE order_seq = ord.order_seq and (
							recipient_phone LIKE '%" . $keyword . "%' OR
							recipient_cellphone LIKE '%" . $keyword . "%' OR
							recipient_user_name LIKE '%" . $keyword . "%')
					) OR
					EXISTS (
						SELECT
							item_seq
						FROM fm_order_item WHERE order_seq = ord.order_seq and goods_name LIKE '%" . $keyword . "%'
					)
				)
				";
			}
		}

		$bindData = [];
		$where[] = " ord.member_seq = ? ";
		$bindData[] = $_SESSION['member_seq'];

		// 주문일
		$date_field = $getParams['date_field'] ? $getParams['date_field'] : 'ref.regist_date';

		if (in_array($date_field, ["ref.regist_date", "ref.return_date"])) {
			if ($getParams['sdate']) {
				$where[] = $date_field." >= ? ";
				$bindData[] = $getParams['sdate']." 00:00:00";
			}
			if ($getParams['edate']) {
				$where[] = $date_field." <= ? ";
				$bindData[] = $getParams['edate']." 23:59:59";
			}
		}

		// 주문상태
		if( $getParams['return_status'] ){
			$where[] = "ref.status IN ? ";
			$bindData[] = $getParams['return_status'];
		}

		$sqlWhereClause = $where ? " where ".implode(' AND ',$where) : "";

		$query = "SELECT ord.*,ref.*,
		ord.payment,
		sum(item.return_ea) as return_ea,
		(
			SELECT userid FROM fm_member WHERE member_seq=ord.member_seq
		) userid,
		(
			SELECT group_name FROM fm_member m,fm_member_group g WHERE m.group_seq=g.group_seq and m.member_seq=ord.member_seq
		) group_name,
		(
			SELECT sum(ea) FROM fm_order_item_option WHERE order_seq=ord.order_seq
		) option_ea,
		(
			SELECT sum(ea) FROM fm_order_item_suboption WHERE order_seq=ord.order_seq
		) suboption_ea,
		sum(item.ea) as return_ea_sum,
		IF(ref.reason_code>100 and ref.reason_code<200,sum(item.ea),0) user_reason_cnt,
		IF(ref.reason_code>200 and ref.reason_code<300,sum(item.ea),0) shop_reason_cnt,
		IF(ref.reason_code>300,sum(item.ea),0) goods_reason_cnt,
		(SELECT status FROM fm_order_refund WHERE refund_code=ref.refund_code) refund_status,
		(SELECT mname FROM fm_manager WHERE manager_seq = ref.manager_seq) mname,
		mem.rute as mbinfo_rute,
		mem.user_name as mbinfo_user_name,
		bus.business_seq as mbinfo_business_seq,
		bus.bname as mbinfo_bname
		FROM
			fm_order_return as ref
			LEFT JOIN fm_order as ord on ref.order_seq = ord.order_seq
			LEFT JOIN fm_order_return_item as item on ref.return_code=item.return_code
			LEFT JOIN fm_member mem ON mem.member_seq=ord.member_seq
			LEFT JOIN fm_member_business bus ON bus.member_seq=mem.member_seq
		{$sqlWhereClause}
		GROUP BY ref.return_code
		ORDER BY ref.status asc, ref.return_seq DESC";
		$query = $this->db->query($query, $bindData);
		foreach($query->result_array() as $k => $data)
		{
			$no++;
			$data['price'] = (int) $data['opt_price'] + (int) $data['sub_price'];
			$data['mstatus'] = $this->returnmodel->arr_return_status[$data['status']];
			$data['mrefund_status'] = $this->refundmodel->arr_refund_status[$data['refund_status']];
			$data['mpayment'] = $this->arr_payment[$data['payment']];

			$tot[$data['status']]['order_ea'] += $data['option_ea']+$data['suboption_ea'];
			$tot[$data['status']]['user_reason_cnt'] += $data['user_reason_cnt'];
			$tot[$data['status']]['shop_reason_cnt'] += $data['shop_reason_cnt'];
			$tot[$data['status']]['goods_reason_cnt'] += $data['goods_reason_cnt'];
			$tot[$data['status']][$data['return_type']] += $data['return_ea_sum'];
			$tot[$data['status']]['return_ea'] += $data['return_ea'];

			$status_cnt[$data['status']]++;

			$tot[$data['status']][$data['important']] += $data['price'];
			$data['status_cnt'] = $status_cnt;

			if($data['member_seq']){
				$data['member_type']	= $data['mbinfo_business_seq'] ? '기업' : '개인';
			}

			$record[$k] = $data;
			if($status_cnt[$data['status']] == 1)
			{
				$record[$k]['start'] = true;
				$ek = $k-1;
				if($ek >= 0 ){
					$record[$ek]['end'] = true;
				}
			}
		}

		// 현재의 처리 프로세스
		$orders = config_load('order');
		$this->template->assign($orders);

		$this->template->define(array('tpl' => $this->template_path()));
		$this->template->assign(array('record' => $record));
		$this->template->assign(array('arr_return_status' => $this->returnmodel->arr_return_status));
		$this->template->print_("tpl");
	}

	public function refund_catalog()
	{
		$this->admin_menu();
		$this->tempate_modules();

		// Relected XSS 검증
		xss_clean_filter();

		$getParams = $this->input->get();

		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('refund_view');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}
		/* 관리자 권한 체크 : 끝 */

		$this->load->model('returnmodel');
		$this->load->model('refundmodel');
		$this->load->model('ordermodel');

		if( count($getParams) == 0 ){
			$getParams['sdate'] = date('Y-m-d');
			$getParams['edate'] = date('Y-m-d');
			$getParams['refund_status'] = array('request','ing');
		}

		$where = array();

		// 검색어
		if( $getParams['keyword'] ){

			$keyword_type = preg_replace("/[^a-z_.]/i","",trim($getParams['keyword_type']));
			$keyword = str_replace("'","\'",trim($getParams['keyword']));
			$keyword = $this->db->escape($keyword);

			if($keyword_type){
				$where[] = "{$keyword_type} = '" . $keyword . "'";
			// 검색어가 주문번호 일 경우
			}else if( preg_match('/^([0-9]{19})$/',$keyword) ){
				$where[] = "ref.order_seq = '" . $keyword . "'";

			// 검색어가 출고번호 일 경우
			}else if(preg_match('/^([D0-9]{9,11})$/',$keyword)){
				$where[] = "ref.order_seq = (SELECT order_seq FROM fm_goods_export WHERE export_code = '" . $keyword . "')";
			// 검색어가 반품번호 일 경우
			}else if(preg_match('/^([R0-9]{9,11})$/',$keyword)){
				$where[] = "ref.order_seq = (SELECT order_seq FROM fm_order_return WHERE return_code = '" . $keyword . "')";
			// 검색어가 환불번호 일 경우
			}else if(preg_match('/^([C0-9]{9,11})$/',$keyword)){
				$where[] = "ref.refund_code = '" . $keyword . "'";
			}else{

				$where[] = "
				(
					mem.user_name like '%" . $keyword . "%' OR
					bus.bname like '%" . $keyword . "%' OR
					ord.order_user_name  like '%" . $keyword . "%' OR
					ord.depositor like '%" . $keyword . "%' OR
					ord.order_email like '%" . $keyword . "%' OR
					ord.order_phone like '%" . $keyword . "%' OR
					ord.order_cellphone like '%" . $keyword . "%' OR
					mem.userid like '%" . $keyword . "%' OR
					ref.refund_code  like '%" . $keyword . "%' OR
					EXISTS (
						SELECT shipping_seq FROM fm_order_shipping WHERE order_seq = ord.order_seq and (
							recipient_phone LIKE '%" . $keyword . "%' OR
							recipient_cellphone LIKE '%" . $keyword . "%' OR
							recipient_user_name LIKE '%" . $keyword . "%')
					) OR
					EXISTS (
						SELECT
							item_seq
						FROM fm_order_item WHERE order_seq = ord.order_seq and goods_name LIKE '%" . $keyword . "%'
					)
				)
				";
			}

		}

		$bindData = [];
		$where[] = " ord.member_seq = ? ";
		$bindData[] = $_SESSION['member_seq'];

		// 주문일
		$date_field = $getParams['date_field'] ? $getParams['date_field'] : 'ref.regist_date';

		if (in_array($date_field, ["ref.regist_date", "ref.refund_date"])) {
			if ($getParams['sdate']) {
				$where[] = $date_field." >= ? ";
				$bindData[] = $getParams['sdate']." 00:00:00";
			}
			if ($getParams['edate']) {
				$where[] = $date_field." <= ? ";
				$bindData[] = $getParams['edate']." 23:59:59";
			}
		}

		// 주문상태
		if( $getParams['refund_status'] ){
			$where[] = "ref.status IN ? ";
			$bindData[] = $getParams['refund_status'];
		}

		$sqlWhereClause = $where ? " where ".implode(' AND ',$where) : "";

		$query = "SELECT ord.*,ref.*,
		ord.payment,
		(
			SELECT userid FROM fm_member WHERE member_seq=ord.member_seq
		) userid,
		(
			SELECT group_name FROM fm_member m,fm_member_group g WHERE m.group_seq=g.group_seq and m.member_seq=ord.member_seq
		) group_name,
		(
			SELECT sum(ea) FROM fm_order_item_option WHERE order_seq=ord.order_seq
		) option_ea,
		(
			SELECT sum(ea) FROM fm_order_item_suboption WHERE order_seq=ord.order_seq
		) suboption_ea,
		(SELECT status FROM fm_order_return WHERE refund_code=ref.refund_code) return_status,
		sum(item.ea) as refund_ea_sum,
		mem.rute as mbinfo_rute,
		mem.user_name as mbinfo_user_name,
		bus.business_seq as mbinfo_business_seq,
		bus.bname as mbinfo_bname
		FROM
			fm_order_refund as ref
			left join fm_order as ord on ref.order_seq = ord.order_seq
			left join fm_order_refund_item as item on ref.refund_code=item.refund_code
			left join fm_member mem ON mem.member_seq=ord.member_seq
			left join fm_member_business bus ON bus.member_seq=mem.member_seq
		{$sqlWhereClause}
		GROUP BY ref.refund_code
		ORDER BY ref.status asc, ref.refund_seq DESC";
		$query = $this->db->query($query, $bindData);
		foreach($query->result_array() as $k => $data)
		{
			$no++;

			$data['mstatus'] = $this->refundmodel->arr_refund_status[$data['status']];
			$data['returns_status'] = $this->returnmodel->arr_return_status[$data['return_status']];
			$data['mpayment'] = $this->arr_payment[$data['payment']];

			$status_cnt[$data['status']]++;
			$tot_price[$data['status']]+=$data['refund_price'];

			$tot[$data['status']][$data['important']] += $data['price'];
			$data['status_cnt'] = $status_cnt;
			$data['tot_price'] = $tot_price;
			$data['tot'][$data['important']] = $tot[$data['status']][$data['important']];

			if($data['member_seq']){
				$data['member_type']	= $data['mbinfo_business_seq'] ? '기업' : '개인';
			}

			$record[$k] = $data;
			if($status_cnt[$data['status']] == 1)
			{
				$record[$k]['start'] = true;
				$ek = $k-1;
				if($ek >= 0 ){
					$record[$ek]['end'] = true;
				}
			}
		}

		if($record)
		{
			$record[$k]['end'] = true;
			foreach($record as $k => $data){
				$record[$k]['no'] = $no;
				$no--;
			}
		}

		// 현재의 처리 프로세스
		$orders = config_load('order');
		$this->template->assign($orders);
		$this->template->define(array('order_process'=>$this->skin."/setting/_order_process.html"));

		$this->template->assign('query_string',get_query_string());
		$this->template->define(array('tpl' => $this->template_path()));
		$this->template->assign(array('record' => $record));
		$this->template->assign(array('arr_refund_status' => $this->refundmodel->arr_refund_status));
		$this->template->print_("tpl");
	}
}

/* End of file order.php */
/* Location: ./app/controllers/admin/order.php */
