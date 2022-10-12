<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class account extends selleradmin_base {

	public function __construct() {
		parent::__construct();
		$this->arr_step = config_load('step');
		$this->arr_payment = config_load('payment');
		$this->load->model('accountmodel');
		$this->load->model('providermodel');

		$auth = $this->authmodel->manager_limit_act('account_view');

		if(!$auth){
			pageBack("권한이 없습니다.");
			exit;
		}
	}

	public function index()
	{
		redirect("/selleradmin/account/catalog");
	}

	public function get_provider_for_period()
	{
		$period = $_GET['period'];
		$result = $this->providermodel->provider_list_for_account_period($period);
		foreach($result as $data){
			if($data['provider_name']) echo("<option value='".$data['provider_seq']."'>".$data['provider_name']."</option>");
		}
	}

	public function _period2date($period_type,$round,$date){
		$r_date = explode('-',$date);
		$st = mktime(0, 0, 0, $r_date[1], 1, $r_date[0]);
		$endday = date('t',$st);
		if($period_type == '2'){
			if($round == 1){
				$ret[] = $date."-01";
				$ret[] = $date."-15";
			}else{
				$ret[] = $date."-16";
				$ret[] = $date."-".$endday;
			}
		}else if($period_type == '4'){
			if($round == 1){
				$ret[] = $date."-01";
				$ret[] = $date."-07";
			}else if($round == 2){
				$ret[] = $date."-08";
				$ret[] = $date."-14";
			}else if($round == 3){
				$ret[] = $date."-15";
				$ret[] = $date."-21";
			}else{
				$ret[] = $date."-22";
				$ret[] = $date."-".$endday;
			}
		}else{
			$ret[] = $date."-01";
			$ret[] = $date."-".$endday;
		}

		return $ret;
	}

	public function catalog()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$calcu_count_limit = $this->usedmodel->get_provider_account_calcu_count();
		$this->template->assign('calcu_count_limit',$calcu_count_limit);

		$data_provider = $this->providermodel->get_provider($this->providerInfo['provider_seq']);

		if(!$_GET['s_year'] && !$_GET['e_year']){
			$date_arr = explode("-",date("Y-m"));
			$_GET['s_year']		= $date_arr[0];
			$_GET['s_month']	= $date_arr[1];
			$_GET['e_year']		= $date_arr[0];
			$_GET['e_month']	= $date_arr[1];
		}
		$_GET['s_export'] = $_GET['s_year']."-".$_GET['s_month'];
		$_GET['e_export'] = $_GET['e_year']."-".$_GET['e_month'];

		if(!$_GET['pay_period'] && $data_provider['calcu_count'] ){
			$_GET['pay_period'] = $data_provider['calcu_count'];
		}

		if(isset($_GET['s_export']) && $_GET['s_export']!="" && isset($_GET['e_export']) && $_GET['e_export']!=""){
			$where_shipping_date_str = "substring( exp.shipping_date, 1, 7 ) between '{$_GET['s_export']}' and '{$_GET['e_export']}' ";
		}
		$where[] = " oitem.provider_seq = '{$this->providerInfo['provider_seq']}' ";

		if($_GET['pay_period']==2){
			$field_period = ",exp.account_2round as account_round";
			$groupby_period = ",account_round";
			$where[] = "pvd.calcu_count=2";
			$account_round = "account_2round";
		}else if($_GET['pay_period']==4){
			$field_period = ",exp.account_4round as account_round";
			$groupby_period = ",account_round";
			$where[] = "pvd.calcu_count=4";
			$account_round = "account_4round";
		}else{
			$where[] = "(pvd.calcu_count=1 OR pvd.calcu_count is null)";
		}

		if($where) $str_where = ' and '. $where_shipping_date_str . ' and ' . implode(' and ',$where);

		$sql = "
			SELECT
				substring( shipping_date, 1, 7 ) export,
				sum(item.ea) export_ea,
				sum(opt.ori_price*item.ea) opt_price,
				sum(sub.price*item.ea) sub_price,
				(
					sum(ifnull(cast(opt.commission_price as signed)*cast(item.ea as signed),0))
					+ sum(ifnull(cast(sub.commission_price as signed)*cast(item.ea as signed),0))
				) as commission_price,

				sum(opt.member_sale*ifnull(item.ea,0))			as member_sale,
				sum(opt.coupon_sale)			as coupon_sale,
				sum(opt.promotion_code_sale)	as promotion_code_sale,
				sum(opt.fblike_sale)			as fblike_sale,
				sum(opt.mobile_sale)			as mobile_sale,
				sum(opt.referer_sale)			as referer_sale,

				sum(IFNULL(opt.salescost_provider_coupon,0) * IFNULL(item.ea,0))	as salescost_provider_coupon,
				sum(IFNULL(opt.salescost_provider_promotion,0) * IFNULL(item.ea,0))	as salescost_provider_promotion,
				sum(IFNULL(opt.salescost_provider_referer,0) * IFNULL(item.ea,0))	as salescost_provider_referer,

				sum(opt.promotion_code_sale) as wcode,
				sum(ifnull(item.ea,0)) as ea,
				oitem.provider_seq,
				sum(IFNULL(opt.unit_emoney,0)*IFNULL(item.ea,0) + IFNULL(sub.unit_emoney,0)*IFNULL(item.ea,0)) as emoney,
				sum(IFNULL(opt.unit_cash,0)*IFNULL(item.ea,0) + IFNULL(sub.unit_cash,0)*IFNULL(item.ea,0)) as cash,
				sum(IFNULL(opt.unit_enuri,0)*IFNULL(item.ea,0) + IFNULL(sub.unit_enuri,0)*IFNULL(item.ea,0)) as enuri,
				oitem.provider_seq
				".$field_period."
			FROM
				fm_goods_export_item item
					LEFT JOIN fm_order_item_option opt ON opt.item_option_seq = item.option_seq and item.option_seq
					LEFT JOIN fm_order_item_suboption sub ON sub.item_suboption_seq = item.suboption_seq and item.suboption_seq
					LEFT JOIN fm_goods_export exp ON exp.export_code=item.export_code
					LEFT JOIN fm_order ord ON ord.order_seq=exp.order_seq
					LEFT JOIN fm_order_item oitem ON oitem.item_seq=item.item_seq
					LEFT JOIN fm_provider pvd ON pvd.provider_seq = oitem.provider_seq
			WHERE
				exp.status = '75'
				and (ord.linkage_id is null or ord.linkage_id != 'connector')
				and ord.orign_order_seq is null
				and exp.account_seq is null
				and (ord.linkage_id is null or ord.linkage_id != 'connector')
				{$str_where}
			GROUP BY
				oitem.provider_seq,export".$groupby_period."
			ORDER BY
				oitem.provider_seq desc";

		$query = $this->db->query($sql);
		foreach($query->result_array() as $data_acc){

			$data_acc['period'] = implode('~<br/>',$this->_period2date($_GET['pay_period'],$data_acc['account_round'],$data_acc['export']));

			// 배송비
			//$data_acc['coupon_sale']							= 0;
			//$data_acc['salescost_provider_coupon']		= 0;
			//$data_acc['promotion_code_sale']				= 0;
			//$data_acc['salescost_provider_promotion']	= 0;
			$data_acc['shipping_cost_by_shop']			= 0;
			$data_acc['return_shipping_price_by_shop']	= 0;
			$data_acc['shipping_cost']							= 0;
			$data_acc['shipping_provider_coupon']			= 0;
			$data_acc['shipping_provider_promotion']		= 0;
			$query_shipping = $this->accountmodel->account_order_shipping_query($_GET['pay_period'],$data_acc['account_round'],$data_acc['export'],$data_acc['provider_seq']);
			foreach($query_shipping -> result_array() as $data_shipping){
				if($data_shipping['shipping_method']=='delivery'){
					$data_acc['shipping_cost']						+= $data_shipping['shipping_cost'];
					$data_acc['coupon_sale']							+= $data_shipping['shipping_coupon_sale'];
					$data_acc['shipping_provider_coupon']		+= $data_shipping['salescost_provider_coupon'];
					$data_acc['salescost_provider_coupon']		+= $data_acc['shipping_provider_coupon'];
					$data_acc['promotion_code_sale']				+= $data_shipping['shipping_promotion_code_sale'];
					$data_acc['shipping_provider_promotion']	+= $data_shipping['salescost_provider_promotion'];
					$data_acc['salescost_provider_promotion']	+= $data_acc['shipping_provider_promotion'];

					if( $data_shipping['provider_seq'] != $data_acc['provider_seq'] ){
						$data_acc['shipping_cost_by_shop'] += get_cutting_price($data_shipping['shipping_cost']);
					}
				}
				if($data_shipping['shipping_method']=='each_delivery'){
					$data_acc['goods_shipping_cost'] 	+= get_cutting_price($data_shipping['delivery_cost']);
					if( $data_shipping['provider_seq'] != $data_acc['provider_seq'] ){
						$data_acc['shipping_cost_by_shop'] += get_cutting_price($data_shipping['delivery_cost']);
					}
				}
			}
			$data_acc['total_shipping_cost_by_shop'] += $data_acc['shipping_cost_by_shop'];


			$field_query = "sum(B.ea) refund_ea,
			sum(ifnull(opt.ori_price*B.ea,0)+ifnull(sub.price*B.ea,0)) +
			sum(if(A.refund_type = 'shipping_price', A.refund_delivery, 0))  as refund_price,
			sum(ifnull(cast(opt.commission_price as signed)*cast(B.ea as signed),0) +
			ifnull(cast(sub.commission_price as signed)*cast(B.ea as signed),0)) +
			sum(if(A.refund_type = 'shipping_price', A.refund_delivery, 0)) as refund_commission_price,
			sum( (ifnull(opt.ori_price,0)-ifnull(opt.commission_price,0)) * B.ea + (ifnull(sub.price,0)-ifnull(sub.commission_price,0)) * B.ea ) as refund_fee
			";

			$query_refund = $this->accountmodel->account_refund_query($_GET['pay_period'],$data_acc['account_round'],$data_acc['export'],$data_acc['provider_seq'],'',$field_query);
			$data_acc_refund = $query_refund->row_array();
			$data_acc['refund_ea'] = $data_acc_refund['refund_ea'];
			$data_acc['refund_price'] = $data_acc_refund['refund_price'];
			$data_acc['refund_commission_price'] = $data_acc_refund['refund_commission_price'];
			if($data_acc_refund['refund_commission_price']) $data_acc['refund_fee'] = $data_acc_refund['refund_price']-$data_acc_refund['refund_commission_price'];
			$data_acc['refund_fee'] = $data_acc_refund['refund_fee'];

			// 반품배송비
			$data_acc['return_shipping_price'] = 0;
			$data_acc['return_shipping_price_by_shop'] = 0;
			$query_shipping = $this->accountmodel->account_return_query($_GET['pay_period'],$data_acc['account_round'],$data_acc['export'],$data_acc['provider_seq']);
			foreach($query_shipping -> result_array() as $data_shipping){
				$data_acc['return_shipping_price']	+= $data_shipping['return_shipping_price'];
				if( $data_shipping['shipping_provider_seq'] != $data_acc['provider_seq'] ){
					$data_acc['return_shipping_price_by_shop'] += $data_shipping['return_shipping_price'];
				}
			}
			$data_acc['total_shipping_cost_by_shop'] += $data_acc['return_shipping_price_by_shop'];

			## 할인부담금 관련 추가
			$data_acc['tot_salescost']			= $data_acc['coupon_sale'] + $data_acc['member_sale']
												+ $data_acc['fblike_sale'] + $data_acc['mobile_sale']
												+ $data_acc['promotion_code_sale']
												+ $data_acc['referer_sale']
												+ $data_acc['enuri'];
												// + $data_acc['cash'] + $data_acc['emoney']; //할인공제는 마일리지/예치금 미포함 @2016-06-29 ysm
			$data_acc['tot_salescost_provider']	= $data_acc['salescost_provider_coupon']
												+ $data_acc['salescost_provider_promotion']
												+ $data_acc['salescost_provider_referer'];
			$data_acc['tot_salescost_admin']	= $data_acc['tot_salescost']
												- $data_acc['tot_salescost_provider'];

			$data_acc['admin_coupon_sale']		= $data_acc['coupon_sale'] - $data_acc['salescost_provider_coupon'];
			$data_acc['admin_promotion_sale']	= $data_acc['promotion_code_sale'] - $data_acc['salescost_provider_promotion'];
			$data_acc['admin_referer_sale']		= $data_acc['referer_sale'] - $data_acc['salescost_provider_referer'];


			$data_acc['wmoney']	= $data_acc['emoney'] + $data_acc['cash'];
			$data_acc['price']		= $data_acc['opt_price'] + $data_acc['sub_price'];
			$data_acc['shipping']	= $data_acc['shipping_cost'] + $data_acc['goods_shipping_cost'];
			$data_acc['fee'] 		= $data_acc['price'] - ($data_acc['commission_price'] + $data_acc['tot_salescost_provider']);
			$data_acc['tot_fee'] 	= $data_acc['fee'] - $data_acc['refund_fee'];
			$data_acc['sales']		= $data_acc['price'] - $data_acc['refund_price'];
			$data_acc['account_price']	= $data_acc['price']
			+ $data_acc['shipping']
			+ $data_acc['return_shipping_price']
			- $data_acc['fee']
			- $data_acc['refund_commission_price']
			- $data_acc['tot_salescost_provider']
			- $data_acc['total_shipping_cost_by_shop'];

			$data_acc['margin']	= $data_acc['tot_fee'] - $data_acc['tot_salescost_admin'];
			$data_acc['margin_percent'] = round( $data_acc['margin'] / ($data_acc['price']-$data_acc['refund_price']) * 10000 ) / 100;
			$loop[] = $data_acc;
		}

		$this->template->assign('loop',$loop);

		### 정산 시작 년/월
		$this_year = date("Y");
		$sql = "select regist_date from fm_order order by regist_date limit 1";
		$query = $this->db->query($sql);
		$order = $query->result_array();
		if($order[0]['regist_date']){
			$start = substr($order[0]['regist_date'],0,4);
		}else{
			$start = $this_year;
		}

		$cnt = $this_year - $start;
		if($cnt<1){
			$year[] = $start;
		}else{
			for($i=date("Y");$i>=$start;$i--){
				$year[] = $i;
			}
		}
		for($i=12;$i>0;$i--){
			$temp = strlen($i)>1 ? $i : "0".$i;
			$month[] = $temp;
		}
		$this->template->assign(array('year'=>$year,'month'=>$month));

		###
		$provider = $this->providermodel->provider_goods_list();
		$this->template->assign('provider',$provider);

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}


	public function complete()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();

		$r_period_type[2] = "";
		$r_period_type[4] = "";

		if	(!$_GET['sc_status'])	$_GET['sc_status']	= 'complete';

		if(!$_GET['s_year'] && !$_GET['e_year']){
			$date_arr = explode("-",date("Y-m"));
			$_GET['s_year']		= $date_arr[0];
			$_GET['s_month']	= $date_arr[1];
			$_GET['e_year']		= $date_arr[0];
			$_GET['e_month']	= $date_arr[1];
		}

		$_GET['sdate'] = $_GET['s_year']."-".$_GET['s_month'];
		$_GET['edate'] = $_GET['e_year']."-".$_GET['e_month'];

		if	($_GET['provider_seq']){
			$addWhere	= " and provider_seq = '".$_GET['provider_seq']."' ";
		}

		$sql = "SELECT * FROM fm_account WHERE acc_status = '".$_GET['sc_status']."'
		AND provider_seq = '".$this->providerInfo['provider_seq']."'
		and acc_date >= '".$_GET['sdate']."' and acc_date <= '".$_GET['edate']."' ".$addWhere." ORDER BY acc_status DESC";
		$query = $this->db->query($sql);
		foreach($query->result_array() as $v){

			$v['period'] = implode('~<br/>',$this->_period2date($v['period_type'],$v['account_round'],$v['acc_date']));
			$v['tot_salescost']			= $v['salescost_admin'] + $v['salescost_provider'];
			$v['admin_salescost']		= explode('|', $v['adminsale_list']);
			$v['provider_salescost']	= explode('|', $v['providersale_list']);
			$loop[] = $v;
		}

		###
		$sql = "select regist_date from fm_order order by regist_date limit 1";
		$query = $this->db->query($sql);
		$order = $query->result_array();
		$start = substr($order[0]['regist_date'],0,4);
		$cnt = date("Y") - $start;
		if($cnt<1){
			$year[] = date("Y")-1;
			$year[] = date("Y");
		}else{
			for($i=date("Y");$i>=$start;$i--){
				$year[] = $i;
			}
		}
		for($i=12;$i>0;$i--){
			$temp = strlen($i)>1 ? $i : "0".$i;
			$month[] = $temp;
		}

		$this->template->assign('loop',$loop);
		$this->template->assign(array('year'=>$year,'month'=>$month));
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}


	public function detail()
	{
		$this->admin_menu();
		$this->tempate_modules();
		$this->load->model('providermodel');

		$file_path		= $this->template_path();
		$provider		= (int) $_GET['provider'];
		$data_provider	= $this->providermodel->get_provider($provider);
		$data_provider['period'] = $this->_period2date($_GET['pay_period'],$_GET['account_round'],$_GET['export']);

		// 상세 정산 정보 가져오기
		$result = $this->accountmodel->detail($_GET);

		$account_gb = "대기";
		switch($_GET['account_gb']){
			case "none":		$account_gb = "대기"; break;
			case "hold":		$account_gb = "보류"; break;
			case "carried":		$account_gb = "이월"; break;
			case "complete":	$account_gb = "완료"; break;
		}

		$this->template->assign('account_gb',$account_gb);
		$this->template->assign('data_provider',$data_provider);
		$this->template->assign('loop',$result['loop']);
		$this->template->assign('loop2',$result['loop2']);
		$this->template->assign('loop3',$result['loop3']);
		$this->template->assign('tot_return',$result['tot_return']);
		$this->template->assign('tot_refund',$result['tot_refund']);
		$this->template->assign('tot_export',$result['tot_export']);
		$this->template->assign('tot',$result['tot']);


		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function complete_process(){
		if($_GET['type']=='pay'){
			$updata['acc_pay_type']	= $_GET['value'];
			$updata['acc_pay_date'] = date("Y-m-d H:i:s");
		}else{
			$updata['acc_tax_type']	= $_GET['value'];
			$updata['acc_tax_date'] = date("Y-m-d H:i:s");
		}
		$this->db->where('seq', $_GET['seq']);
		$result = $this->db->update('fm_account', $updata);

		###
		$callback = "parent.location.reload();";
		openDialogAlert("처리 되었습니다.",400,140,'parent',$callback);
	}

	public function excel_download_detail(){

		$file_path	= $this->template_path();
		$this->load->model('providermodel');
		$provider = (int) $_GET['provider'];
		$data_provider = $this->providermodel->get_provider($provider);
		list($data_provider_account_person) = $this->providermodel->get_person($provider,'calcu');

		$file_type = "account_detail_";
		if($provider){
			$file_type .=$provider."_";
		}
		$file_type .= date("YmdHi");

		// 상세 정산 정보 가져오기
		$result = $this->accountmodel->detail($_GET);

		if(!$_GET['debug']){

			header("Content-Type: application/vnd.ms-excel; charset=utf-8");
			header("Content-Disposition: attachment; filename=".$file_type.".xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
			header("Pragma: public");

		}

		$this->template->assign('data_provider',$data_provider);
		$this->template->assign('data_provider_account_person',$data_provider_account_person);

		$this->template->assign('loop',$result['loop']);
		$this->template->assign('loop2',$result['loop2']);
		$this->template->assign('loop3',$result['loop3']);
		$this->template->assign('tot_return',$result['tot_return']);
		$this->template->assign('tot_refund',$result['tot_refund']);
		$this->template->assign('tot_export',$result['tot_export']);
		$this->template->assign('tot',$result['tot']);
		$this->template->assign('file_type',$file_type);


		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

}

/* End of file account.php */
/* Location: ./app/controllers/admin/account.php */