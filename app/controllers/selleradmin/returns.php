<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class returns extends selleradmin_base {

	public function __construct() {
		parent::__construct();
		$this->cfg_order = config_load('order');
		$auth = $this->authmodel->manager_limit_act('refund_view');
		if(!$auth){
			pageBack("관리자 권한이 없습니다.");
			exit;
		}
	}

	public function index()
	{
		redirect("/selleradmin/order/catalog");
	}

	public function important()
	{
		$val = $_GET['val'];
		$no = str_replace('important_','',$_GET['no']);
		$query = "update fm_order_return set important=? where return_seq=?";
		$this->db->query($query,array($val,$no));
	}

	public function set_search_return(){

		$this->load->model('searchdefaultconfigmodel');

		$param_order = $_POST;
		$param_order['search_page'] = 'admin/returns/catalog';
		$this->searchdefaultconfigmodel->set_search_default($param_order);

		$callback = "parent.closeDialog('search_detail_dialog');";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}

	public function get_search_return(){

		$this->load->model('searchdefaultconfigmodel');
		$data_search_default_str = $this->searchdefaultconfigmodel->get_search_default_config('admin/returns/catalog');
		parse_str($data_search_default_str['search_info'], $data_search_default);
		echo json_encode($data_search_default);
	}

	public function catalog()
	{
		$this->admin_menu();
		$this->tempate_modules();

		$this->load->model('returnmodel');
		$this->load->model('refundmodel');
		$this->load->model('ordermodel');
		$this->load->helper('order');
		$this->load->library('privatemasking');

		$this->load->library('Connector');
		$connector	= $this->connector::getInstance();

		//마켓연동 연동 서비스 사용유무
		if ($connector->isConnectorUse()) {
			$connectorUse	= true;
			$this->load->model('connectormodel');
			$marketList		= $this->connectormodel->getUseAllMarkets();
		}  else {
			$connectorUse	= false;
			$marketList		= array();
		}

		$this->template->assign(array('connectorUse' => $connectorUse, 'marketList' => $marketList));


		$npay_use = npay_useck();

		// 검색조건이 없을 경우 기본 세팅 검색조건을 가져옵니다.
		if( count($_GET) == 0 ){

			$this->load->model('searchdefaultconfigmodel');
			$data_search_default_str = $this->searchdefaultconfigmodel->get_search_default_config('selleradmin/returns/catalog');
			if($data_search_default_str['search_info']){
				parse_str($data_search_default_str['search_info'], $data_search_default);
				$search_date = $this->searchdefaultconfigmodel->get_search_format_date($data_search_default['default_period']);
				$_GET['sdate']			= $search_date['start_date'];
				$_GET['edate']			= $search_date['end_date'];
				$_GET['default_period']	= $data_search_default['default_period'];
				$_GET['return_status']	= $data_search_default['default_return_status'];
				$this->template->assign("search_default",$data_search_default);
			}
		}

		// 검색어
		if( $_GET['keyword'] ){

			$keyword = str_replace("'","\'",trim($_GET['keyword']));

			// 검색어가 주문번호 일 경우
			if( preg_match('/^([0-9]{19})$/',$keyword) ){
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

		if($_GET['date_field']){
			$date_field = $_GET['date_field'];
		}else{
			$date_field = "ref.regist_date";
		}
		// 주문일
		if($_GET['sdate']){
			$where[] = $date_field." >= '".$_GET['sdate']." 00:00:00'";
		}
		if($_GET['edate']){
			$where[] = $date_field." <= '".$_GET['edate']." 24:00:00'";
		}

		# npay 반품요청건 조회
		if($_GET['search_npay_order_return']){
			$where[] = "ref.npay_order_id != '' and ref.status = 'request'";
		}


		# 오픈마켓 주문
		if (isset($_GET['selectMarkets']) === true && $_GET['allselectMarkets'] != 'y') {
			$connectorMarket	= array_unique($_GET['selectMarkets']);
			$newMarketArray		= array();
			foreach ((array)$connectorMarket as $marketCode) {
				$marketCode		= trim($marketCode);
				if (strlen($marketCode) > 1)
					$newMarketArray[]	= $marketCode;
			}
			

			$marketCnt	= count($newMarketArray);

			if ($marketCnt > 0) {
				$this->load->library('Connector');
				$connector		= $this->connector::getInstance();
				$marketList		= $connector->getAllMarkets(true);

				$justConnector	= true;
				if (in_array('NOT', $newMarketArray) === true) {
					$justConnector	= false;
					$notConnector	= "(ord.linkage_id = '' OR  ord.linkage_id is null)";
					unset($newMarketArray[array_search('NOT', $newMarketArray)]);
					$newMarketArray	= array_values($newMarketArray);
					$marketCnt--;
				} else {
					$where[]	="ord.linkage_id = 'connector'";
				}
				

				if ($marketCnt < count($marketList)) {
					if ($marketCnt == 1) {
						if ($justConnector === true)
							$where[]	= "ord.linkage_mall_code = '{$newMarketArray[0]}'";
						else
							$where[]	= "({$notConnector} OR (ord.linkage_id = 'connector' AND ord.linkage_mall_code = '{$newMarketArray[0]}'))";
					} else {
						$marketIn		= implode("','", $newMarketArray);
						if ($justConnector === true) {
							$where[]	= "ord.linkage_mall_code IN ('{$marketIn}')";
						} else if(count($newMarketArray) > 0){
							$where[]	= "({$notConnector} OR (ord.linkage_id = 'connector' AND ord.linkage_mall_code IN ('{$marketIn}')))";
						} else {
							$where[]	= "{$notConnector}";
						}
					}
				}
			}
		}

		// 회수방법 조건 추가 :: 2019-08-26 pjw
		if( !empty($_GET['return_method']) ){
			$where[]	= "ref.return_method = '".$_GET['return_method']."'";
		}


		// 주문상태
		if( $_GET['return_status'] ){
			$arr = array();
			foreach($_GET['return_status'] as $key => $data){
				$arr[] = "ref.status = '".$data."'";
			}
			$where[] = "(".implode(' OR ',$arr).")";
		}

		$sqlWhereClause = $where ? " AND ".implode(' AND ',$where) : "";

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
		(SELECT status FROM fm_order_refund WHERE refund_code=ref.refund_code) refund_status,
		(SELECT mname FROM fm_manager WHERE manager_seq = ref.manager_seq) mname,
		mem.rute as mbinfo_rute,
		mem.user_name as mbinfo_user_name,
		bus.business_seq as mbinfo_business_seq,
		bus.bname as mbinfo_bname
		FROM
			fm_order_return as ref
			inner join fm_order_return_item as item on ref.return_code=item.return_code
			inner join fm_order as ord on ref.order_seq = ord.order_seq
			LEFT JOIN fm_order_item orditem ON (orditem.order_seq = ord.order_seq and item.item_seq=orditem.item_seq)
			LEFT JOIN fm_member mem ON mem.member_seq=ord.member_seq
			LEFT JOIN fm_member_business bus ON bus.member_seq=mem.member_seq
		where orditem.provider_seq = '{$this->providerInfo['provider_seq']}' {$sqlWhereClause}
		GROUP BY ref.return_code
		ORDER BY ref.status asc, ref.return_seq DESC";
		$query = $this->db->query($query);
		foreach($query->result_array() as $k => $data)
		{
			unset($data['return_ea']);
			## item별 반품사유 count 문제로 쿼리 추가

			$tot_query = "SELECT ea, reason_code,stock_return_ea,package_stock_return_ea FROM fm_order_return_item WHERE return_code='{$data['return_code']}'";
			$tot_res = $this->db->query($tot_query);
			foreach($tot_res->result_array() as $kk => $tot_data)
			{
				if( $tot_data['reason_code'] > 100 && $tot_data['reason_code'] < 200 ) $data['user_reason_cnt'] += $tot_data['ea'];
				if( $tot_data['reason_code'] > 200 && $tot_data['reason_code'] < 300 ) $data['goods_reason_cnt'] += $tot_data['ea'];
				if( $tot_data['reason_code'] > 300 ) $data['shop_reason_cnt'] += $tot_data['ea'];
				
				/**
				* 반품 실제 회수수량
				* fm_order_return_item return_ea 미사용-> stock_return_ea 
				**/
				if($data['package_yn'] && $tot_data['package_stock_return_ea']){//패키지상품의 환불수량
					/**$package_stock_return_ea = unserialize($item['package_stock_return_ea']);
					foreach($package_stock_return_ea as $package_stock_return_ea_v){
						$item['return_ea']			+= $package_stock_return_ea_v;
					}**/
					$data['return_ea']		+= $tot_data['ea'];//실제 패키지상품 환불수량과 다를수 있어서 접수된 수량처리
				}else{
					$data['return_ea']		+= $tot_data['stock_return_ea'];
				}
			}

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
			$data['tot'][$data['important']] = $tot[$data['status']][$data['important']];

			if($data['member_seq']){
				$data['member_type']	= $data['mbinfo_business_seq'] ? '기업' : '개인';
			}

			if ($data['linkage_id'] == 'connector')
				$data['linkage_mallname_text']	= $marketList[$data['linkage_mall_code']]['name'];

			//개인정보 마스킹 표시
			$data = $this->privatemasking->masking($data, 'order');

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

		$this->template->define(array('tpl' => $this->template_path()));
		$this->template->assign(array('record' => $record));
		$this->template->assign(array('tot' => $tot));
		$this->template->assign(array('npay_use' => $npay_use));
		$this->template->assign(array('arr_return_status' => $this->returnmodel->arr_return_status));
		$this->template->print_("tpl");
	}

	// 기존 반품 처리 view 분기 처리 :: 2018-06-11 lwh
	public function view(){
		$this->load->model('returnmodel');
		$this->load->model('ordermodel');
		$this->load->model('accountallmodel');

		$return_code		= $_GET['no'];
		$data_return 		= $this->returnmodel->get_return($return_code);

		//반품코드로 등록된 데이터가 없을 경우 이전페이지로 이동 pjw
		if( is_null($data_return) ) {
			pageBack("존재하지 않는 데이터 입니다.");
			exit;
		}

		$data_order			= $this->ordermodel->get_order($data_return['order_seq']);
		// 오픈마켓 이슈로 인해 일단 무조건 new_view로 보낸 후 빈 라디오박스로 노출되게 임시처리 :: 2018-07-19 pjw
		$this->returns_new_view($return_code, $data_return, $data_order);

//		if($data_return['refund_ship_duty']){
//			$this->returns_new_view($return_code, $data_return, $data_order);
//		}else{
//			$this->returns_old_view($return_code, $data_return, $data_order);
//		}
	}


	// 새로운 반품 방식 추가 :: 2018-06-11 lwh
	public function returns_new_view($return_code, $data_return, $data_order)
	{
		$this->admin_menu();
		$this->tempate_modules();

		// 사유코드
		$reasons			= code_load('return_reason');
		$qry				= "select * from fm_return_reason where return_type='coupon' order by idx asc";
		$query				= $this->db->query($qry);
		$reasoncouponLoop	= $query -> result_array();
		$qry				= "select * from fm_return_reason where return_type!='coupon' order by idx asc";
		$query				= $this->db->query($qry);
		$reasonLoop			= $query -> result_array();

		$this->load->model('refundmodel');
		$this->load->model('goodsmodel');
		$this->load->helper('order');
		$this->load->model('giftmodel');
		$this->load->helper('order');
		$this->load->model('orderpackagemodel');

		$data_return_item 	= $this->returnmodel->get_return_item($return_code);
		$process_log 		= $this->ordermodel->get_log($data_return['order_seq'],'process',array('return_code'=>$return_code));

		//npay 사용여부 확인, 취소사유 코드 불러오기
		$npay_use = npay_useck();
		if($npay_use && $data_return['npay_order_id']){
			$this->load->library('naverpaylib');
			$reasonLoop = $this->naverpaylib->get_npay_return_reason();
			$npay_return_hold	= $this->naverpaylib->get_npay_code("return_hold");
			//debug($npay_return_hold);

			if($npay_return_hold[strtoupper($data_return['npay_flag'])]){
				$data_return['npay_flag_msg'] = $npay_return_hold[strtoupper($data_return['npay_flag'])];
			}else{
				$data_return['npay_flag_msg'] = '';
			}
		}

		$tmp = $this->refundmodel->get_refund($data_return['refund_code']);
		$data_return['mrefund_status']	= $this->refundmodel->arr_refund_status[$tmp['status']];
		$data_return['mstatus'] 		= $this->returnmodel->arr_return_status[$tmp['status']];

		if(!$npay_use || !$data_return['npay_order_id']){
			if( $data_return['phone'] )$data_return['phone'] = explode('-',$data_return['phone']);
			if( $data_return['cellphone'] )$data_return['cellphone'] = explode('-',$data_return['cellphone']);
		}

		if( $data_return['sender_zipcode'] )$data_return['sender_zipcode'] = explode('-',$data_return['sender_zipcode']);

		foreach($data_return_item as $key => $item){

			$goods_cnt[$item['goods_seq']]++;
			$tot['ea']  		+= $item['ea'];
			$tot['return_ea']	+= $item['return_ea'];

			//반품완료 처리시 재고 증가여부 선택용 2015-03-30 pjm
			for($k=0; $k <= $item['ea']; $k++){
				$item['eaLoop'][] = $k;
			}
			$data_return_item[$key]['eaLoop'] = $item['eaLoop'];

			if( $item['reason_code'] > 100 && $item['reason_code'] < 200 ) $tot['user_reason_cnt'] += $item['ea'];
			if( $item['reason_code'] > 200 && $item['reason_code'] < 300 ) $tot['shop_reason_cnt'] += $item['ea'];
			if( $item['reason_code'] > 300 ) $tot['goods_reason_cnt'] += $item['ea'];

			if	($item['goods_kind'] == 'coupon'){
				$data_return_item[$key]['couponinfo'] = get_goods_coupon_view($item['export_code']);
			}

			## 사은품
			$item['gift_title'] = "";
			if($item['goods_type'] == "gift"){
				$giftlog = $this->giftmodel->get_gift_title($data_return['order_seq'],$item['item_seq']);
				$data_return_item[$key]['gift_title'] = $giftlog['gift_title'];
			}

			//청약철회상품체크
			$ctgoods = $this->goodsmodel->get_goods($item['goods_seq']);
			$data_return_item[$key]['cancel_type'] = $ctgoods['cancel_type'];

			$data_return_item[$key]['reasons'] = $reasons;
			$data_return_item[$key]['reasonLoop'] = ($item['goods_kind'] == 'coupon' )?$reasoncouponLoop:$reasonLoop;

			$data_return_item[$key]['refunditem'] = $this->refundmodel->get_refund_item_data($data_return['refund_code'],$item['item_seq'], $item['option_seq']);
			$data_return_item[$key]['inputs'] = $this->ordermodel->get_input_for_option($item['item_seq'], $item['option_seq']);

			if($item['package_yn'] == 'y' && $item['opt_type'] == 'opt'){
				$item['packages'] = $this->orderpackagemodel->get_option($item['option_seq']);
				foreach($item['packages'] as $key_package=>$data_package){
					$stock = (int) $data_package['stock'];
					$badstock = (int) $data_package['badstock'];
					$reservation = (int) $data_package['reservation'.$this->cfg_order['ableStockStep']];
					$ablestock = $stock - $badstock - $reservation;
					$item['packages'][$key_package]['ablestock'] = $ablestock;
					$optionStr = $data_package['goods_seq']."option".$data_package['option_seq'];
					$item['packages'][$key_package]['optioninfo'] = $optionStr;
					$package_option_code = 'option'.$data_package['package_option_seq'];
					$item['packages'][$key_package]['package_option_code'] = $package_option_code;
					$arr_package_return_badea = unserialize($item['package_return_badea']);
					$item['packages'][$key_package]['return_badea'] = $arr_package_return_badea[$package_option_code];
				}
				$data_return_item[$key]['packages'] = $item['packages'];
			}

			if($item['package_yn'] == 'y' && $item['opt_type'] == 'sub'){
				$item['packages'] = $this->orderpackagemodel->get_suboption($item['option_seq']);
				foreach($item['packages'] as $key_package=>$data_package){
					$stock = (int) $data_package['stock'];
					$badstock = (int) $data_package['badstock'];
					$reservation = (int) $data_package['reservation'.$this->cfg_order['ableStockStep']];
					$ablestock = $stock - $badstock - $reservation;
					$item['packages'][$key_package]['ablestock'] = $ablestock;
					$optionStr = $data_package['goods_seq']."option".$data_package['option_seq'];
					$item['packages'][$key_package]['optioninfo'] = $optionStr;
					$package_option_code = 'suboption'.$data_package['package_suboption_seq'];
					$item['packages'][$key_package]['package_option_code'] = $package_option_code;
					$arr_package_return_badea = unserialize($item['package_return_badea']);
					$item['packages'][$key_package]['return_badea'] = $arr_package_return_badea[$package_option_code];
				}
				$data_return_item[$key]['packages'] = $item['packages'];
			}

			// Npay 반품건일시 반품사유 코드
			if($npay_use && $item['npay_product_order_id']){
				$reason_desc = explode("@",$data_return_item[$key]['reason_desc']);
				if(count($reason_desc)>1){
					$data_return_item[$key]['reason_code'] = $reason_desc[0];
					$data_return_item[$key]['reason_desc'] = $reason_desc[1];
				}else{
					$data_return_item[$key]['reason_code'] = $item['reason_desc'];
				}
				
				// Npay 반품건일시 반품 부담
				if(empty($data_return['refund_ship_duty'])) {
				    $npay_ship_duty = $this->returnmodel->get_npay_ship_duty($data_return_item[$key]['reason_code']);
				    if(!empty($npay_ship_duty)) {
				        $data_return['refund_ship_duty'] = $npay_ship_duty;
				    }
				}
			}


		}
		if($goods_ea) $tot['goods_cnt'] = array_sum($goods_cnt);
		$data_return['mstatus'] = $this->returnmodel->arr_return_status[$data_return['status']];
		$data_return['mreturn_type'] = $this->returnmodel->arr_return_type[$data_return['return_type']];

		// 반품배송비 책임 예외처리 :: 2018-05-23 lwh
		// 오픈마켓 이슈로 reason_code 가 없으면 빈값으로 들어가게 처리 :: 2018-07-19 pjw
		if (!$data_return['refund_ship_duty']){
			if ($data_return['reason_code'] == '120'){
				$data_return['refund_ship_duty'] = 'buyer';
			}else if($data_return['reason_code'] == '310'){
				$data_return['refund_ship_duty'] = 'seller';
			}
		}
		// 반품 배송비 주체 결정 :: 2018-05-23 lwh
		if ($data_return['status'] == 'request'){
			if			($return_provider == '1' || $data_return['refund_ship_type'] == 'A'){
				$data_return['return_shipping_gubun'] = 'company';
			}else if	($data_return['refund_ship_type'] == 'D'){
				$data_return['return_shipping_gubun'] = 'provider';
			}
		}

		//개인정보 마스킹 표시
		$this->load->library('privatemasking');
		$data_order = $this->privatemasking->masking($data_order, 'order');
		$data_return = $this->privatemasking->masking($data_return, 'order');
		$process_log = $this->privatemasking->masking($process_log, 'order_log');

		$this->template->assign(
			array(
				'process_log'		=>$process_log,
				'data_return'		=>$data_return,
				'data_return_item'	=>$data_return_item,
				'tot'				=>$tot,
				'data_order'		=>$data_order,
				'providerInfo'		=>$this->providerInfo,
				'npay_use'			=> $npay_use
			)
		);
		$this->template->assign('query_string',$_GET['query_string']);//######################## 16.12.15 gcs yjy : 검색조건 유지되도록

		$file_path = str_replace('view.html','new_view.html',$this->template_path());
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function returns_old_view($return_code, $data_return, $data_order)
	{

		$this->admin_menu();
		$this->tempate_modules();

		// 사유코드
		$reasons			= code_load('return_reason');
		$qry				= "select * from fm_return_reason where return_type='coupon' order by idx asc";
		$query				= $this->db->query($qry);
		$reasoncouponLoop	= $query -> result_array();
		$qry				= "select * from fm_return_reason where return_type!='coupon' order by idx asc";
		$query				= $this->db->query($qry);
		$reasonLoop			= $query -> result_array();

		$this->load->model('refundmodel');
		$this->load->model('goodsmodel');
		$this->load->helper('order');
		$this->load->model('giftmodel');
		$this->load->helper('order');
		$this->load->model('orderpackagemodel');

		$data_return_item 	= $this->returnmodel->get_return_item($return_code);
		$process_log 		= $this->ordermodel->get_log($data_return['order_seq'],'process',array('return_code'=>$return_code));

		//npay 사용여부 확인, 취소사유 코드 불러오기
		$npay_use = npay_useck();
		if($npay_use && $data_return['npay_order_id']){
			$this->load->library('naverpaylib');
			$reasonLoop = $this->naverpaylib->get_npay_return_reason();
			$npay_return_hold	= $this->naverpaylib->get_npay_code("return_hold");
			//debug($npay_return_hold);

			if($npay_return_hold[strtoupper($data_return['npay_flag'])]){
				$data_return['npay_flag_msg'] = $npay_return_hold[strtoupper($data_return['npay_flag'])];
			}else{
				$data_return['npay_flag_msg'] = '';
			}
		}

		$tmp = $this->refundmodel->get_refund($data_return['refund_code']);
		$data_return['mrefund_status']	= $this->refundmodel->arr_refund_status[$tmp['status']];
		$data_return['mstatus'] 		= $this->returnmodel->arr_return_status[$tmp['status']];

		if(!$npay_use || !$data_return['npay_order_id']){
			if( $data_return['phone'] )$data_return['phone'] = explode('-',$data_return['phone']);
			if( $data_return['cellphone'] )$data_return['cellphone'] = explode('-',$data_return['cellphone']);
		}

		if( $data_return['sender_zipcode'] )$data_return['sender_zipcode'] = explode('-',$data_return['sender_zipcode']);

		foreach($data_return_item as $key => $item){

			$goods_cnt[$item['goods_seq']]++;
			$tot['ea']  		+= $item['ea'];
			$tot['return_ea']	+= $item['return_ea'];

			//반품완료 처리시 재고 증가여부 선택용 2015-03-30 pjm
			for($k=0; $k <= $item['ea']; $k++){
				$item['eaLoop'][] = $k;
			}
			$data_return_item[$key]['eaLoop'] = $item['eaLoop'];

			if( $item['reason_code'] > 100 && $item['reason_code'] < 200 ) $tot['user_reason_cnt'] += $item['ea'];
			if( $item['reason_code'] > 200 && $item['reason_code'] < 300 ) $tot['shop_reason_cnt'] += $item['ea'];
			if( $item['reason_code'] > 300 ) $tot['goods_reason_cnt'] += $item['ea'];

			if	($item['goods_kind'] == 'coupon'){
				$data_return_item[$key]['couponinfo'] = get_goods_coupon_view($item['export_code']);
			}

			## 사은품
			$item['gift_title'] = "";
			if($item['goods_type'] == "gift"){
				$giftlog = $this->giftmodel->get_gift_title($data_return['order_seq'],$item['item_seq']);
				$data_return_item[$key]['gift_title'] = $giftlog['gift_title'];
			}

			//청약철회상품체크
			$ctgoods = $this->goodsmodel->get_goods($item['goods_seq']);
			$data_return_item[$key]['cancel_type'] = $ctgoods['cancel_type'];

			$data_return_item[$key]['reasons'] = $reasons;
			$data_return_item[$key]['reasonLoop'] = ($item['goods_kind'] == 'coupon' )?$reasoncouponLoop:$reasonLoop;

			$data_return_item[$key]['refunditem'] = $this->refundmodel->get_refund_item_data($data_return['refund_code'],$item['item_seq'], $item['option_seq']);
			$data_return_item[$key]['inputs'] = $this->ordermodel->get_input_for_option($item['item_seq'], $item['option_seq']);

			if($item['package_yn'] == 'y' && $item['opt_type'] == 'opt'){
				$item['packages'] = $this->orderpackagemodel->get_option($item['option_seq']);
				foreach($item['packages'] as $key_package=>$data_package){
					$stock = (int) $data_package['stock'];
					$badstock = (int) $data_package['badstock'];
					$reservation = (int) $data_package['reservation'.$this->cfg_order['ableStockStep']];
					$ablestock = $stock - $badstock - $reservation;
					$item['packages'][$key_package]['ablestock'] = $ablestock;
					$optionStr = $data_package['goods_seq']."option".$data_package['option_seq'];
					$item['packages'][$key_package]['optioninfo'] = $optionStr;
					$package_option_code = 'option'.$data_package['package_option_seq'];
					$item['packages'][$key_package]['package_option_code'] = $package_option_code;
					$arr_package_return_badea = unserialize($item['package_return_badea']);
					$item['packages'][$key_package]['return_badea'] = $arr_package_return_badea[$package_option_code];
				}
				$data_return_item[$key]['packages'] = $item['packages'];
			}

			if($item['package_yn'] == 'y' && $item['opt_type'] == 'sub'){
				$item['packages'] = $this->orderpackagemodel->get_suboption($item['option_seq']);
				foreach($item['packages'] as $key_package=>$data_package){
					$stock = (int) $data_package['stock'];
					$badstock = (int) $data_package['badstock'];
					$reservation = (int) $data_package['reservation'.$this->cfg_order['ableStockStep']];
					$ablestock = $stock - $badstock - $reservation;
					$item['packages'][$key_package]['ablestock'] = $ablestock;
					$optionStr = $data_package['goods_seq']."option".$data_package['option_seq'];
					$item['packages'][$key_package]['optioninfo'] = $optionStr;
					$package_option_code = 'suboption'.$data_package['package_suboption_seq'];
					$item['packages'][$key_package]['package_option_code'] = $package_option_code;
					$arr_package_return_badea = unserialize($item['package_return_badea']);
					$item['packages'][$key_package]['return_badea'] = $arr_package_return_badea[$package_option_code];
				}
				$data_return_item[$key]['packages'] = $item['packages'];
			}

			// Npay 반품건일시 반품사유 코드
			if($npay_use && $item['npay_product_order_id']){
				$reason_desc = explode("@",$data_return_item[$key]['reason_desc']);
				if(count($reason_desc)>1){
					$data_return_item[$key]['reason_code'] = $reason_desc[0];
					$data_return_item[$key]['reason_desc'] = $reason_desc[1];
				}else{
					$data_return_item[$key]['reason_code'] = $item['reason_desc'];
				}
			}


		}
		if($goods_ea) $tot['goods_cnt'] = array_sum($goods_cnt);
		$data_return['mstatus'] = $this->returnmodel->arr_return_status[$data_return['status']];
		$data_return['mreturn_type'] = $this->returnmodel->arr_return_type[$data_return['return_type']];

		//개인정보 마스킹 표시
		$this->load->library('privatemasking');
		$data_order = $this->privatemasking->masking($data_order, 'order');
		$data_return = $this->privatemasking->masking($data_return, 'order');
		$process_log = $this->privatemasking->masking($process_log, 'order_log');

		$this->template->assign(
			array(
				'process_log'		=>$process_log,
				'data_return'		=>$data_return,
				'data_return_item'	=>$data_return_item,
				'tot'				=>$tot,
				'data_order'		=>$data_order,
				'providerInfo'		=>$this->providerInfo,
				'npay_use'			=> $npay_use
			)
		);
		$this->template->assign('query_string',$_GET['query_string']);//######################## 16.12.15 gcs yjy : 검색조건 유지되도록

		$this->template->define(array('tpl' => $this->template_path()));
		$this->template->print_("tpl");
	}

}

/* End of file return.php */
/* Location: ./app/controllers/selleradmin/return.php */