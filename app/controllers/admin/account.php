<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class account extends admin_base {

	public function __construct() {
		parent::__construct();
		$this->arr_step = config_load('step');
		$this->arr_payment = config_load('payment');
		$this->load->model('accountmodel');
		$this->load->model('providermodel');

	}

	public function index()
	{
		redirect("/admin/account/catalog");
	}

	public function get_provider_for_period()
	{
		$period = $_GET['period'];

		/* 입점사명 정렬 추가(가나다abc) leewh 2014-11-10 */
		//$result = $this->providermodel->provider_list_for_account_period($period);
		$result = $this->providermodel->provider_list_for_account_period_sort($period);
		foreach($result as $data){
			if($data['provider_name']) echo("<option value='".$data['provider_seq']."'>".$data['provider_name']."</option>");
		}
	}

	public function set_missing_account_round()
	{
		$this->load->model('accountmodel');
		$this->load->model('exportmodel');
		$query = "select * from fm_goods_export where `status`='75' and (account_2round='' OR account_2round is null)";
		$query = $this->db->query($query);
		foreach($query->result_array() as $data_export){
			$data_export_item = $this->exportmodel->get_export_item($data_export['export_code']);
			if($data_export['shipping_date']&&$data_export['shipping_date']!='0000-00-00'){
				$shipping_date = $data_export['shipping_date'];
			}
			$this->accountmodel->set_account_round($data_export,$data_export_item,$shipping_date);

		}
	}

	public function _period2date($period_type,$round,$date){
		return $this->accountmodel->period2date($period_type,$round,$date);
	}

	public function catalog()
	{
		$this_year = date("Y");
		$this_mon = date("m");

		$this->set_missing_account_round();
		$this->admin_menu();
		$this->tempate_modules();
		$file_path	= $this->template_path();
		$calcu_count_limit = $this->usedmodel->get_provider_account_calcu_count();
		$this->template->assign('calcu_count_limit',$calcu_count_limit);
		
		if(!$_GET){
			$_GET['s_year']					= $this_year;
			$_GET['s_month']				= $this_mon;
			$_GET['e_year']					= $this_year;
			$_GET['e_month']				= $this_mon;
			$_GET['pay_period']				= 1;
			$_GET['provider_seq_selector']	= '';
			$_GET['provider_seq']			= '';
			$_GET['provider_name']			= '';
		}else if(!$_GET['s_year'] || !$_GET['e_year']){
			$_GET['s_year']					= $this_year;
			$_GET['s_month']				= $this_mon;
			$_GET['e_year']					= $this_year;
			$_GET['e_month']				= $this_mon;
		}
		$loop = $this->accountmodel -> get_account_request($_GET,'catalog');
		$this->template->assign('loop',$loop);

		### 정산 시작 년/월
		
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
		/* 입점사명 정렬 추가(가나다abc) leewh 2014-11-10 */
		//$provider = $this->providermodel->provider_goods_list();
		$provider			= $this->providermodel->provider_goods_list_sort();

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
			$addWhere	= " and ac.provider_seq = '".$_GET['provider_seq']."' ";
		}

		$sql = "SELECT ac.seq as account_seq,pvd.provider_seq, pvd.provider_id, pvd.provider_name, ac.* FROM fm_account ac, fm_provider pvd WHERE ac.provider_seq = pvd.provider_seq and ac.acc_status = '".$_GET['sc_status']."' and ac.acc_date >= '".$_GET['sdate']."' and ac.acc_date <= '".$_GET['edate']."' ".$addWhere." ORDER BY ac.acc_status DESC";
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
		$start = date('Y');
		if	($order[0]['regist_date'])	$start = substr($order[0]['regist_date'],0,4);
		$cnt = date("Y") - $start;
		if($cnt < 1){
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

		###
		/* 입점사명 정렬 추가(가나다abc) leewh 2014-11-10 */
		//$provider = $this->providermodel->provider_goods_list();
		$provider			= $this->providermodel->provider_goods_list_sort();

		$this->template->assign('provider',$provider);

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

	public function process(){
		$data = $this->accountmodel -> get_account_request($_GET,'process');

		###
		$insert['acc_date']			= $_GET['export'];
		$insert['acc_status']		= $_GET['value'];
		$insert['provider_id']		= get_provider_id($_GET['provider']);
		$insert['provider_seq']		= $_GET['provider'];
		$insert['sell_ea']			= $data[0]['export_ea'];
		$insert['sell_price']		= $data[0]['price'];
		$insert['sell_shipping']	= $data[0]['shipping'];
		$insert['ref_ea']			= $data[0]['refund_ea'];
		$insert['ref_price']		= $data[0]['refund_price'];
		$insert['ref_fee']			= $data[0]['refund_fee'];
		$insert['sales_ea']			= $data[0]['export_ea']-$data[0]['refund_ea'];
		$insert['sales_price']		= $data[0]['sales'];
		$insert['sales_shipping']	= $data[0]['shipping'];
		$insert['sales_sum']		= $data[0]['sales'] + $data[0]['shipping'];
		$insert['sales_charge']		= $data[0]['tot_fee'];
		$insert['prom_code']		= $data[0]['wcode'];
		$insert['prom_emoney']		= $data[0]['emoney'];
		$insert['prom_cash']		= $data[0]['cash'];
		$insert['prom_sum']			= $data[0]['wcode'] + $data[0]['emoney']  + $data[0]['cash'];
		$insert['ret_shipping']		= $data[0]['return_shipping_price'];
		$insert['acc_price']		= $data[0]['account_price'];
		$insert['profit_price']		= $data[0]['margin'];
		$insert['profit_per']		= $data[0]['margin_percent'];
		$insert['period_type']		= $_GET['pay_period'];
		$insert['account_round']	= $data[0]['account_round'];
		$insert['regist_date']		= date("Y-m-d H:i:s");

		## 할인부담금 관련 추가
		$insert['salescost_admin']		= $data[0]['tot_salescost_admin'];
		$insert['salescost_provider']	= $data[0]['tot_salescost_provider'];
		$insert['adminsale_list']		= $data[0]['admin_coupon_sale'].'|'
										. $data[0]['member_sale'].'|'
										. $data[0]['fblike_sale'].'|'
										. $data[0]['mobile_sale'].'|'
										. $data[0]['admin_promotion_sale'].'|'
										. $data[0]['admin_referer_sale'].'|'
										. $data[0]['enuri'].'|'
										. $data[0]['cash'].'|'
										. $data[0]['emoney'];
		$insert['providersale_list']	= $data[0]['salescost_provider_coupon'].'|'
										. $data[0]['salescost_provider_promotion'].'|'
										. $data[0]['salescost_provider_referer'];

		// 위탁배송비
		$insert['total_shipping_cost_by_shop']	= $data[0]['total_shipping_cost_by_shop'];
		$insert['shipping_cost_by_shop']	= $data[0]['shipping_cost_by_shop'];
		$insert['return_shipping_price_by_shop']	= $data[0]['return_shipping_price_by_shop'];

		//트랜잭션 시작
		$this->db->trans_begin();
		$this->db->insert('fm_account', $insert);
		$account_seq = $this->db->insert_id();

		if( $account_seq > 0 ){
			$this->db->trans_commit();
		} else {
			$this->db->trans_rollback();
			openDialogAlert("처리 중 오류가 발생 했습니다. 다시 시도 해 주십시오.",400,140,'parent', "parent.location.reload();");
			exit;
		}

		$this->load->model("accountmodel");

		if($_GET['pay_period']==2){
			$account_round = "account_2round";
		}else if($_GET['pay_period']==4){
			$account_round = "account_4round";
		}

		$param['account_status']	= $_GET['value'];
		$param['account_round']		= $data[0]['account_round'];
		$param['round_field']			= $account_round;
		$param['account_date']		= $_GET['export'];
		$param['provider_seq']		= $_GET['provider'];
		$param['account_seq']		= $account_seq;

		$this->accountmodel->account_complete_item($param);
		$this->accountmodel->set_export_accountstatus($param);
		$this->accountmodel->account_return($_GET['pay_period'],$data[0]['account_round'],$_GET['export'],$_GET['provider'],$account_seq);
		$this->accountmodel->account_refund($_GET['pay_period'],$data[0]['account_round'],$_GET['export'],$_GET['provider'],$account_seq);
		$this->accountmodel->account_order_shipping($_GET['pay_period'],$data[0]['account_round'],$_GET['export'],$_GET['provider'],$account_seq);

		###
		$callback = "parent.location.reload();";
		openDialogAlert("처리 되었습니다.",400,140,'parent',$callback);
	}

	public function complete_process(){
		if($_GET['type']=='pay'){
			$updata['acc_pay_type']	= $_GET['value'];
			$updata['acc_pay_date'] = date("Y-m-d H:i:s");
		}elseif($_GET['type']=='status'){
			$updata['acc_status']	= $_GET['value'];
			$this->accountmodel->update_export_account_status($_GET['seq'],$updata['acc_status']);
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

	public function migration()
	{
		exit;
		$this->accountmodel->migration();
		debug_var($this->db->queries);
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

/* End of file brand.php */
/* Location: ./app/controllers/admin/brand.php */
