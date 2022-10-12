<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class statistic_sales extends selleradmin_base {

	public function __construct() {
		parent::__construct();

		$this->seriesColors = array("#445ebc", "#d33c34","#4bb2c5", "#c5b47f", "#EAA228", "#579575", "#839557", "#958c12",
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc", "#c3b8f3", "#EA28A2", "#8566cc");
		$this->template->assign(array('seriesColors'=>$this->seriesColors));

		/* 매출통계 메뉴 */
		$this->template->define(array('sales_menu'=>$this->skin."/statistic_sales/_sales_menu.html"));
		$sales_menu = $this->uri->rsegments[count($this->uri->rsegments)];
		if($sales_menu=='sales_monthly') $sales_menu = 'sales_monthly';
		$this->template->assign(array('selected_sales_menu'=>$sales_menu));

		//판매환경
		$this->sitetypeloop = sitetype($_GET['sitetype'], 'image', 'array');
		if(!count($_GET)) $_GET['sitetype'] = array_keys($this->sitetypeloop);

		$this->template->assign(array(
			'sitetype'=>$_GET['sitetype'],
			'sitetypeloop'=>$this->sitetypeloop
		));
	}

	public function index()
	{
		redirect("/selleradmin/statistic_sales/sales_monthly");
	}

	/* 월별  매출 통계 */
	public function sales_monthly()
	{
		$this->admin_menu();
		$this->tempate_modules();

		/* 관리자 권한 체크 : 시작 */
		/**
		$auth = $this->authmodel->manager_limit_act('statistic_sales');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}
		**/
		/* 관리자 권한 체크 : 끝 */

		### SERVICE CHECK
		$this->load->model('usedmodel');
		$result = $this->usedmodel->used_service_check('statistic_sales_detail');
		if(!$result['type']){
			$this->template->assign('statistic_sales_detail_limit','Y');
		}

		/* 날짜 파라미터 */
		$_GET['year'] = !empty($_GET['year']) ? $_GET['year'] : date('Y');
		$_GET['sitetype'] = !empty($_GET['sitetype']) ? $_GET['sitetype'] : array();

		$statsData = array();

		/* 데이터 추출 : 주문금액, 결제금액, 마일리지사용, 할인금액, 배송비, 매입금액 */
		$sql = "
			select
				stats_year
				,stats_month
				,sum(settleprice_sum) as month_settleprice_sum
				,sum(enuri_sum) as month_enuri_sum
				,sum(emoney_use_sum) as month_emoney_use_sum
				,sum(cash_use_sum) as month_cash_use_sum
				,sum(count_sum) as month_count_sum
				,sum(shipping_cost_sum+goods_shipping_cost_sum) as month_shipping_cost_sum
				,sum(option_ori_price_sum) as month_ori_price_sum
				,sum(shipping_coupon_sale_sum+option_coupon_sale_sum) as month_coupon_sale_sum
				,sum(shipping_promotion_code_sale_sum+option_promotion_code_sale_sum) as month_promotion_code_sale_sum
				,sum(option_fblike_sale_sum) as month_fblike_sale_sum
				,sum(option_mobile_sale_sum) as month_mobile_sale_sum
				,sum(option_member_sale_sum) as month_member_sale_sum
				,sum(ifnull(option_supply_price_sum,0)+ifnull(suboption_supply_price_sum,0)) as month_supply_price_sum
				from
				(
					select
						a.order_seq as order_seq,
						year(a.deposit_date) as stats_year,
						month(a.deposit_date) as stats_month
						,sum(a.settleprice) as settleprice_sum
						,sum(a.enuri) as enuri_sum
						,sum(a.emoney) as emoney_use_sum
						,sum(a.cash) as cash_use_sum
						,sum(b.shipping_coupon_sale) as shipping_coupon_sale_sum
						,sum(b.shipping_promotion_code_sale) as shipping_promotion_code_sale_sum
						,sum(a.international_cost+a.shipping_cost) as shipping_cost_sum
						,count(*) as count_sum
						,(select sum(ori_price*ea) from fm_order_item_option where order_seq=a.order_seq) as option_ori_price_sum
						,(select sum(ifnull(coupon_sale,0)*ea) from fm_order_item_option where order_seq=a.order_seq) as option_coupon_sale_sum
						,(select sum(ifnull(fblike_sale,0)*ea) from fm_order_item_option where order_seq=a.order_seq) as option_fblike_sale_sum
						,(select sum(ifnull(mobile_sale,0)*ea) from fm_order_item_option where order_seq=a.order_seq) as option_mobile_sale_sum
						,(select sum(ifnull(promotion_code_sale,0)*ea) from fm_order_item_option where order_seq=a.order_seq) as option_promotion_code_sale_sum
						,(select sum(ifnull(member_sale,0)*ea) from fm_order_item_option where order_seq=a.order_seq) as option_member_sale_sum
						,(select sum(goods_shipping_cost) from fm_order_item where order_seq=a.order_seq) as goods_shipping_cost_sum
						,(select sum(supply_price*ea) from fm_order_item_option where order_seq=a.order_seq) as option_supply_price_sum
						,(select sum(supply_price*ea) from fm_order_item_suboption where order_seq=a.order_seq) as suboption_supply_price_sum
					from fm_order as a
					left join fm_order_shipping as b on a.order_seq=b.order_seq
					where a.deposit_yn='y' and year(a.deposit_date)='{$_GET['year']}' and a.sitetype in ('".implode("','",$_GET['sitetype'])."') and b.provider_seq = '{$this->providerInfo['provider_seq']}'
					group by a.order_seq
				) as b
				group by b.stats_month
		";

		$query = $this->db->query($sql);
		foreach($query->result_array() as $row) $statsData[$row['stats_month']-1] = is_array($statsData[$row['stats_month']-1]) ? array_merge($statsData[$row['stats_month']-1],$row) : $row;

		/* 데이터 추출 : 환불금액, 환불건수 */
		$sql = "
			select
				stats_year
				,stats_month
				,sum(refund_price_sum) as month_refund_price_sum
				,sum(refund_count_sum) as month_refund_count_sum
				from
				(
					select
						a.order_seq as order_seq,
						year(a.refund_date) as stats_year,
						month(a.refund_date) as stats_month
						,sum(a.refund_price) as refund_price_sum
						,count(*) as refund_count_sum
						from fm_order_refund as a
						left join fm_order as b on a.order_seq = b.order_seq
						left join fm_order_item as c on b.order_seq = c.order_seq
					where year(a.refund_date)='{$_GET['year']}' and b.sitetype in ('".implode("','",$_GET['sitetype'])."')  and c.provider_seq = '{$this->providerInfo['provider_seq']}'
					group by a.order_seq
				) as b
				group by b.stats_month
		";
		$query = $this->db->query($sql);
		foreach($query->result_array() as $row) $statsData[$row['stats_month']-1] = is_array($statsData[$row['stats_month']-1]) ? array_merge($statsData[$row['stats_month']-1],$row) : $row;

		/* 매출액, 매입금액평균, 순이익 계산 */
		foreach($statsData as $i => $row){
			// 주문금액
			$statsData[$i]['order_price'] = $row['month_settleprice_sum']+$row['month_emoney_use_sum']+$row['month_cash_use_sum'];
			// 할인합계
			$statsData[$i]['discount_price'] = $row['month_enuri_sum']+$row['month_coupon_sale_sum']+$row['month_promotion_code_sale_sum']+$row['month_fblike_sale_sum']+$row['month_mobile_sale_sum']+$row['month_member_sale_sum'];
			// 매출액
			$statsData[$i]['sales_price'] = $row['month_settleprice_sum']+$row['month_emoney_use_sum']+$row['month_cash_use_sum']-$row['month_refund_price_sum'];
			// 순이익
			$statsData[$i]['interests'] = $statsData[$i]['sales_price']-$row['month_supply_price_sum'];
		}


		/* 데이터 가공 */
		$maxValue = 0;
		$maxMonth = 12;

		$dataForChart = array();

		for($i=0;$i<$maxMonth;$i++){
			//$dataForChart['매출액'][$i] = ($i+1).'월';
			$dataForChart['매출액'][$i] = $statsData[$i]['sales_price']?$statsData[$i]['sales_price']:0;
		}

		for($i=0;$i<$maxMonth;$i++){
			//$dataForChart['순이익'][$i] = ($i+1).'월';
			$dataForChart['순이익'][$i] = $statsData[$i]['interests']?$statsData[$i]['interests']:0;
		}

		foreach($dataForChart as $k=>$v){
			foreach($dataForChart[$k] as $row){
				$maxValue = $maxValue < $row ? $row : $maxValue;
			}
		}

		$this->template->assign(array(
			'dataForChart'	=> $dataForChart,
			'maxValue'		=> $maxValue
		));

		/* 월별 데이터 테이블 */
		$dataForTable = array();
		$dataForTableSum = array();
		for($i=0;$i<$maxMonth;$i++){
			$dataForTable[$i] = $statsData[$i];
		}
		foreach($dataForTable as $stats_month=>$row){
			foreach($row as $k=>$v){
				$dataForTableSum[$k] += $v;
			}
		}

		$this->template->assign(array(
			'dataForTable'	=> $dataForTable,
			'dataForTableSum' => $dataForTableSum,
		));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/* 일별  매출 통계 */
	public function sales_daily()
	{
		$this->admin_menu();
		$this->tempate_modules();

		/* 관리자 권한 체크 : 시작 */
		/**
		$auth = $this->authmodel->manager_limit_act('statistic_sales');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}**/
		/* 관리자 권한 체크 : 끝 */

		### SERVICE CHECK
		$this->load->model('usedmodel');
		$result = $this->usedmodel->used_service_check('statistic_sales_detail');
		if(!$result['type']){
			$this->template->assign('statistic_sales_detail_limit','Y');
		}

		/* 날짜 파라미터 */
		$_GET['year'] = !empty($_GET['year']) ? $_GET['year'] : date('Y');
		$_GET['month'] = !empty($_GET['month']) ? $_GET['month'] : date('m');
		$_GET['sitetype'] = !empty($_GET['sitetype']) ? $_GET['sitetype'] : array();

		$statsData = array();

		/* 데이터 추출 : 주문금액, 결제금액, 마일리지사용, 할인금액, 배송비, 매입금액 */
		$sql = "
			select
				stats_year
				,stats_month
				,stats_day
				,sum(settleprice_sum) as day_settleprice_sum
				,sum(enuri_sum) as day_enuri_sum
				,sum(emoney_use_sum) as day_emoney_use_sum
				,sum(cash_use_sum) as day_cash_use_sum
				,sum(count_sum) as day_count_sum
				,sum(shipping_cost_sum+goods_shipping_cost_sum) as day_shipping_cost_sum
				,sum(option_ori_price_sum) as day_ori_price_sum
				,sum(shipping_coupon_sale_sum+option_coupon_sale_sum) as day_coupon_sale_sum
				,sum(shipping_promotion_code_sale_sum+option_promotion_code_sale_sum) as day_promotion_code_sale_sum
				,sum(option_fblike_sale_sum) as day_fblike_sale_sum
				,sum(option_mobile_sale_sum) as day_mobile_sale_sum
				,sum(option_member_sale_sum) as day_member_sale_sum
				,sum(ifnull(option_supply_price_sum,0)+ifnull(suboption_supply_price_sum,0)) as day_supply_price_sum
				from
				(
					select
						a.order_seq as order_seq
						,year(a.deposit_date) as stats_year
						,month(a.deposit_date) as stats_month
						,day(a.deposit_date) as stats_day
						,sum(a.settleprice) as settleprice_sum
						,sum(a.enuri) as enuri_sum
						,sum(a.emoney) as emoney_use_sum
						,sum(a.cash) as cash_use_sum
						,sum(b.shipping_coupon_sale) as shipping_coupon_sale_sum
						,sum(b.shipping_promotion_code_sale) as shipping_promotion_code_sale_sum
						,sum(a.international_cost+a.shipping_cost) as shipping_cost_sum
						,count(*) as count_sum
						,(select sum(ori_price*ea) from fm_order_item_option where order_seq=a.order_seq) as option_ori_price_sum
						,(select sum(ifnull(coupon_sale,0)*ea) from fm_order_item_option where order_seq=a.order_seq) as option_coupon_sale_sum
						,(select sum(ifnull(fblike_sale,0)*ea) from fm_order_item_option where order_seq=a.order_seq) as option_fblike_sale_sum
						,(select sum(ifnull(mobile_sale,0)*ea) from fm_order_item_option where order_seq=a.order_seq) as option_mobile_sale_sum
						,(select sum(ifnull(promotion_code_sale,0)*ea) from fm_order_item_option where order_seq=a.order_seq) as option_promotion_code_sale_sum
						,(select sum(ifnull(member_sale,0)*ea) from fm_order_item_option where order_seq=a.order_seq) as option_member_sale_sum
						,(select sum(goods_shipping_cost) from fm_order_item where order_seq=a.order_seq) as goods_shipping_cost_sum
						,(select sum(supply_price*ea) from fm_order_item_option where order_seq=a.order_seq) as option_supply_price_sum
						,(select sum(supply_price*ea) from fm_order_item_suboption where order_seq=a.order_seq) as suboption_supply_price_sum
					from fm_order as a
					left join fm_order_shipping as b on a.order_seq=b.order_seq
					where a.deposit_yn='y' and year(a.deposit_date)='{$_GET['year']}' and month(a.deposit_date)='{$_GET['month']}' and a.sitetype in ('".implode("','",$_GET['sitetype'])."') and b.provider_seq = '{$this->providerInfo['provider_seq']}'
					group by a.order_seq
				) as b
				group by b.stats_day
		";

		$query = $this->db->query($sql);
		foreach($query->result_array() as $row) $statsData[$row['stats_day']-1] = is_array($statsData[$row['stats_day']-1]) ? array_merge($statsData[$row['stats_day']-1],$row) : $row;

		/* 데이터 추출 : 환불금액, 환불건수 */
		$sql = "
			select
				stats_year
				,stats_month
				,stats_day
				,sum(refund_price_sum) as day_refund_price_sum
				,sum(refund_count_sum) as day_refund_count_sum
				,sum(cancel_price_sum) as day_cancel_price_sum
				,sum(cancel_count_sum) as day_cancel_count_sum
				,sum(return_price_sum) as day_return_price_sum
				,sum(return_count_sum) as day_return_count_sum
				,sum(ifnull(option_supply_price_sum,0)+ifnull(suboption_supply_price_sum,0)) as day_refund_supply_price_sum
				from
				(
					select
						a.order_seq as order_seq
						,year(a.refund_date) as stats_year
						,month(a.refund_date) as stats_month
						,day(a.refund_date) as stats_day
						,sum(a.refund_price) as refund_price_sum
						,count(*) as refund_count_sum
						,sum(if(a.refund_type='cancel_payment',a.refund_price,0)) as cancel_price_sum
						,sum(if(a.refund_type='cancel_payment',1,0)) as cancel_count_sum
						,sum(if(a.refund_type='return',a.refund_price,0)) as return_price_sum
						,sum(if(a.refund_type='return',1,0)) as return_count_sum
						,(select sum(supply_price*ea) from fm_order_item_option where order_seq=a.order_seq) as option_supply_price_sum
						,(select sum(supply_price*ea) from fm_order_item_suboption where order_seq=a.order_seq) as suboption_supply_price_sum
						from fm_order_refund as a
						left join fm_order as b on a.order_seq = b.order_seq
						left join fm_order_item as c on b.order_seq = c.order_seq
					where year(a.refund_date)='{$_GET['year']}' and month(a.refund_date)='{$_GET['month']}' and b.sitetype in ('".implode("','",$_GET['sitetype'])."') and c.provider_seq = '{$this->providerInfo['provider_seq']}'
					group by a.order_seq
				) as b
				group by b.stats_day
		";
		$query = $this->db->query($sql);
		foreach($query->result_array() as $row) $statsData[$row['stats_day']-1] = is_array($statsData[$row['stats_day']-1]) ? array_merge($statsData[$row['stats_day']-1],$row) : $row;

		/* 매출액, 매입금액평균, 순이익 계산 */
		foreach($statsData as $i => $row){

			// 주문금액
			$statsData[$i]['order_price'] = $row['day_settleprice_sum']+$row['day_emoney_use_sum']+$row['day_cash_use_sum'];
			// 할인합계
			$statsData[$i]['discount_price'] = $row['day_enuri_sum']+$row['day_coupon_sale_sum']+$row['day_fblike_sale_sum']+$row['day_mobile_sale_sum']+$row['day_promotion_code_sale_sum']+$row['day_member_sale_sum'];
			// 매출액
			$statsData[$i]['sales_price'] = $row['day_settleprice_sum']+$row['day_emoney_use_sum']+$row['day_cash_use_sum']-$row['day_refund_price_sum'];
			// 순이익
			$statsData[$i]['interests'] = $statsData[$i]['sales_price']-($statsData[$i]['day_supply_price_sum']-$row['day_refund_supply_price_sum']);

		}


		/* 데이터 가공 */
		$maxValue = 0;
		$maxDay = date('t',strtotime($_GET['year'].'-'.$_GET['month'].'-01'));

		$dataForChart = array();

		for($i=0;$i<$maxDay;$i++){
			//$dataForChart['매출액'][$i] = ($i+1).'월';
			$dataForChart['매출액'][$i] = $statsData[$i]['sales_price']?$statsData[$i]['sales_price']:0;
		}

		for($i=0;$i<$maxDay;$i++){
			//$dataForChart['순이익'][$i] = ($i+1).'월';
			$dataForChart['순이익'][$i] = $statsData[$i]['interests']?$statsData[$i]['interests']:0;
		}

		foreach($dataForChart as $k=>$v){
			foreach($dataForChart[$k] as $row){
				$maxValue = $maxValue < $row ? $row : $maxValue;
			}
		}

		$this->template->assign(array(
			'dataForChart'	=> $dataForChart,
			'maxValue'		=> $maxValue,
			'maxDay'		=> $maxDay
		));

		/* 일별 데이터 테이블 */
		$dataForTable = array();
		$dataForTableSum = array();
		for($i=0;$i<$maxDay;$i++){
			$dataForTable[$i] = $statsData[$i];
			foreach($dataForTable[$i] as $k=>$v){
				$dataForTableSum[$k] += $v;
			}
		}

		$this->template->assign(array(
			'dataForTable'	=> $dataForTable,
			'dataForTableSum' => $dataForTableSum,
		));

		/* 일별 데이터 달력용 */
		$c_start_idx = date('w',strtotime("{$_GET['year']}-{$_GET['month']}-01"));
		$c_end_idx = date('t',strtotime("{$_GET['year']}-{$_GET['month']}-01"));
		$c_row = ceil(($c_start_idx+$c_end_idx)/7);

		$this->template->assign(array(
			'c_start_idx'	=> $c_start_idx,
			'c_end_idx'		=> $c_end_idx,
			'c_row'			=> $c_row,
		));
		$this->template->define(array('sales_daily_calendar'=>$this->skin."/statistic_sales/_sales_daily_calendar.html"));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/* 결제수단별  매출 통계 */
	public function sales_payment()
	{
		$this->admin_menu();
		$this->tempate_modules();

		$this->arr_payment = config_load('payment');

		/* 관리자 권한 체크 : 시작 */
		/**
		$auth = $this->authmodel->manager_limit_act('statistic_sales');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}**/
		/* 관리자 권한 체크 : 끝 */

		### SERVICE CHECK
		$this->load->model('usedmodel');
		$result = $this->usedmodel->used_service_check('statistic_sales_detail');
		if(!$result['type']){
			$this->template->assign('statistic_sales_detail_limit','Y');
			exit;
		}

		/* 날짜 파라미터 */
		$_GET['year'] = !empty($_GET['year']) ? $_GET['year'] : date('Y');
		$_GET['month'] = isset($_GET['month']) ? $_GET['month'] : date('m');
		$_GET['sitetype'] = !empty($_GET['sitetype']) ? $_GET['sitetype'] : array();

		$statsData = array();

		/* 데이터 추출 : 주문금액, 결제금액, 마일리지사용, 할인금액, 배송비, 매입금액 */
		$wheres = array();
		$wheres[] = "a.deposit_yn='y'";
		$wheres[] = "year(a.deposit_date)='{$_GET['year']}'";
		$wheres[] = "a.sitetype in ('".implode("','",$_GET['sitetype'])."')";
		if(!empty($_GET['month'])) $wheres[] = "month(a.deposit_date)='{$_GET['month']}'";
		$sql = "
			select
				a.order_seq as order_seq
				,year(a.deposit_date) as stats_year
				,month(a.deposit_date) as stats_month
				,a.payment as payment
				,day(a.deposit_date) as stats_day
				,sum(a.settleprice) as month_settleprice_sum
				,count(*) as month_count_sum
			from fm_order as a
			left join fm_order_item as c on a.order_seq = c.order_seq
			where ".implode(" and ", $wheres)." and c.provider_seq = '{$this->providerInfo['provider_seq']}'
			group by a.payment
		";
		$query = $this->db->query($sql);
		foreach($query->result_array() as $row) $statsData[$row['payment']] = $row;

		/* 데이터 가공 */
		$maxDay = date('t',strtotime($_GET['year'].'-'.$_GET['month'].'-01'));
		$count_total_sum = 0;

		$dataForChart = array();
		$idx = 0;
		foreach($this->arr_payment as $k=>$v){
			$count_total_sum += $statsData[$k]['month_count_sum'];
			$dataForChart['건수'][$idx][0] = $v;
			$dataForChart['건수'][$idx][1] = $statsData[$k]['month_count_sum']?$statsData[$k]['month_count_sum']:0;
			$dataForChart['금액'][$idx][0] = $v;
			$dataForChart['금액'][$idx][1] = $statsData[$k]['month_settleprice_sum']?$statsData[$k]['month_settleprice_sum']:0;
			$idx++;
		}

		$this->template->assign(array(
			'dataForChart'	=> $dataForChart,
			'maxDay'		=> $maxDay
		));

		/* 일별 데이터 테이블 */
		$dataForTable = array();
		foreach($this->arr_payment as $k=>$v){
			$dataForTable[$k] = $statsData[$k];
			$dataForTable[$k]['month_count_percent'] = $dataForTable[$k]['month_count_sum']?round($dataForTable[$k]['month_count_sum']/$count_total_sum*100):0;
		}

		$this->template->assign(array(
			'dataForTable'	=> $dataForTable,
			'arr_payment'	=> $this->arr_payment,
		));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/* 요일별  매출 통계 */
	public function sales_weekday()
	{
		$this->admin_menu();
		$this->tempate_modules();

		$this->arr_weekday = array('월','화','수','목','금','토','일');

		/* 관리자 권한 체크 : 시작 */
		/**
		$auth = $this->authmodel->manager_limit_act('statistic_sales');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}**/
		/* 관리자 권한 체크 : 끝 */

		### SERVICE CHECK
		$this->load->model('usedmodel');
		$result = $this->usedmodel->used_service_check('statistic_sales_detail');
		if(!$result['type']){
			$this->template->assign('statistic_sales_detail_limit','Y');
			exit;
		}

		/* 날짜 파라미터 */
		$_GET['year'] = !empty($_GET['year']) ? $_GET['year'] : date('Y');
		$_GET['month'] = isset($_GET['month']) ? $_GET['month'] : date('m');
		$_GET['sitetype'] = !empty($_GET['sitetype']) ? $_GET['sitetype'] : array();

		$statsData = array();

		/* 데이터 추출 : 결제금액, 건수 */
		$wheres = array();
		$wheres[] = "a.deposit_yn='y'";
		$wheres[] = "year(a.deposit_date)='{$_GET['year']}'";
		if(!empty($_GET['month'])) $wheres[] = "month(a.deposit_date)='{$_GET['month']}'";
		$wheres[] = "a.sitetype in ('".implode("','",$_GET['sitetype'])."')";
		$sql = "
			select
				a.order_seq as order_seq
				,year(a.deposit_date) as stats_year
				,month(a.deposit_date) as stats_month
				,weekday(a.deposit_date) as stats_weekday
				,day(a.deposit_date) as stats_day
				,sum(a.settleprice) as month_settleprice_sum
				,count(*) as month_count_sum
			from fm_order as a
			left join fm_order_item as c on a.order_seq = c.order_seq
			where ".implode(" and ", $wheres)."  and c.provider_seq = '{$this->providerInfo['provider_seq']}'
			group by stats_weekday
		";
		$query = $this->db->query($sql);
		foreach($query->result_array() as $row) $statsData[$row['stats_weekday']] = $row;

		/* 데이터 가공 */
		$maxDay = date('t',strtotime($_GET['year'].'-'.$_GET['month'].'-01'));
		$count_total_sum = 0;

		$dataForChart = array();
		foreach($this->arr_weekday as $k=>$v){
			$count_total_sum += $statsData[$k]['month_count_sum'];
			$dataForChart['건수'][$k][0] = $v;
			$dataForChart['건수'][$k][1] = $statsData[$k]['month_count_sum']?$statsData[$k]['month_count_sum']:0;
			$dataForChart['금액'][$k][0] = $v;
			$dataForChart['금액'][$k][1] = $statsData[$k]['month_settleprice_sum']?round($statsData[$k]['month_settleprice_sum']/1000):0;
		}

		$maxValue['건수'] = 0;
		$maxValue['금액'] = 0;
		foreach($dataForChart as $k=>$v){
			foreach($dataForChart[$k] as $row){
				$maxValue[$k] = $maxValue[$k] < $row[1] ? $row[1] : $maxValue[$k];
			}
		}

		$this->template->assign(array(
			'dataForChart'	=> $dataForChart,
			'maxValue'		=> $maxValue,
			'maxDay'		=> $maxDay
		));

		/* 요일별 데이터 테이블 */
		$dataForTable = array();
		foreach($this->arr_weekday as $k=>$v){
			$dataForTable[$k] = $statsData[$k];
			$dataForTable[$k]['month_count_percent'] = $dataForTable[$k]['month_count_sum']?round($dataForTable[$k]['month_count_sum']/$count_total_sum*100):0;
		}

		$this->template->assign(array(
			'dataForTable'	=> $dataForTable,
			'arr_weekday'	=> $this->arr_weekday,
		));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/* 시간대별  매출 통계 */
	public function sales_hour()
	{
		$this->admin_menu();
		$this->tempate_modules();

		/* 관리자 권한 체크 : 시작 */
		/**
		$auth = $this->authmodel->manager_limit_act('statistic_sales');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}**/
		/* 관리자 권한 체크 : 끝 */

		### SERVICE CHECK
		$this->load->model('usedmodel');
		$result = $this->usedmodel->used_service_check('statistic_sales_detail');
		if(!$result['type']){
			$this->template->assign('statistic_sales_detail_limit','Y');
			exit;
		}

		/* 날짜 파라미터 */
		$_GET['year'] = !empty($_GET['year']) ? $_GET['year'] : date('Y');
		$_GET['month'] = isset($_GET['month']) ? $_GET['month'] : date('m');
		$_GET['sitetype'] = !empty($_GET['sitetype']) ? $_GET['sitetype'] : array();

		$statsData = array();

		/* 데이터 추출 : 결제금액, 건수 */
		$wheres = array();
		$wheres[] = "a.deposit_yn='y'";
		$wheres[] = "year(a.deposit_date)='{$_GET['year']}'";
		if(!empty($_GET['month'])) $wheres[] = "month(a.deposit_date)='{$_GET['month']}'";
		$wheres[] = "a.sitetype in ('".implode("','",$_GET['sitetype'])."')";
		$sql = "
			select
				a.order_seq as order_seq
				,year(a.deposit_date) as stats_year
				,month(a.deposit_date) as stats_month
				,hour(a.deposit_date) as stats_hour
				,day(a.deposit_date) as stats_day
				,sum(a.settleprice) as month_settleprice_sum
				,count(*) as month_count_sum
			from fm_order as a
			left join fm_order_item as c on a.order_seq = c.order_seq
			where ".implode(" and ", $wheres)."  and c.provider_seq = '{$this->providerInfo['provider_seq']}'
			group by stats_hour
		";
			//debug_var($sql);
		$query = $this->db->query($sql);
		foreach($query->result_array() as $row) $statsData[$row['stats_hour']] = $row;

		/* 데이터 가공 */
		$maxDay = date('t',strtotime($_GET['year'].'-'.$_GET['month'].'-01'));
		$count_total_sum = 0;

		$dataForChart = array();
		for($i=0;$i<24;$i++){
			$count_total_sum += $statsData[$i]['month_count_sum'];
			$dataForChart['건수'][$i][0] = $i;
			$dataForChart['건수'][$i][1] = $statsData[$i]['month_count_sum']?$statsData[$i]['month_count_sum']:0;
			$dataForChart['금액'][$i][0] = $i;
			$dataForChart['금액'][$i][1] = $statsData[$i]['month_settleprice_sum']?$statsData[$i]['month_settleprice_sum']:0;
		}

		$maxValue['건수'] = 0;
		$maxValue['금액'] = 0;
		foreach($dataForChart as $k=>$v){
			foreach($dataForChart[$k] as $row){
				$maxValue[$k] = $maxValue[$k] < $row[1] ? $row[1] : $maxValue[$k];
			}
		}

		$this->template->assign(array(
			'dataForChart'	=> $dataForChart,
			'maxValue'		=> $maxValue,
			'maxDay'		=> $maxDay
		));

		/* 테이블 */
		$dataForTable = array();
		for($i=0;$i<24;$i++){
			$dataForTable[$i] = $statsData[$i];
			$dataForTable[$i]['month_count_percent'] = $dataForTable[$i]['month_count_sum']?round($dataForTable[$i]['month_count_sum']/$count_total_sum*100):0;
		}

		$this->template->assign(array(
			'dataForTable'	=> $dataForTable,
			'arr_weekday'	=> $this->arr_weekday,
		));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/* 지역별  매출 통계 */
	public function sales_location()
	{
		$this->admin_menu();
		$this->tempate_modules();

		$this->load->helper('zipcode');
	    $ZIP_DB = get_zipcode_db();

		$this->arr_location = array();
		$query = $ZIP_DB->query("SELECT substring(SIDO,1,2) as SIDO FROM `zipcode` GROUP BY SIDO");
		foreach($query->result_array() as $row){
			$this->arr_location[] = $row['SIDO'];
		}

		/* 관리자 권한 체크 : 시작 */
		/**
		$auth = $this->authmodel->manager_limit_act('statistic_sales');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}**/
		/* 관리자 권한 체크 : 끝 */

		### SERVICE CHECK
		$this->load->model('usedmodel');
		$result = $this->usedmodel->used_service_check('statistic_sales_detail');
		if(!$result['type']){
			$this->template->assign('statistic_sales_detail_limit','Y');
			exit;
		}

		/* 날짜 파라미터 */
		$_GET['year'] = !empty($_GET['year']) ? $_GET['year'] : date('Y');
		$_GET['month'] = isset($_GET['month']) ? $_GET['month'] : date('m');
		$_GET['sitetype'] = !empty($_GET['sitetype']) ? $_GET['sitetype'] : array();

		$statsData = array();

		/* 데이터 추출 : 주문금액, 결제금액, 마일리지사용, 할인금액, 배송비, 매입금액 */
		$wheres = array();
		$wheres[] = "a.deposit_yn='y'";
		$wheres[] = "year(a.deposit_date)='{$_GET['year']}'";
		if(!empty($_GET['month'])) $wheres[] = "month(a.deposit_date)='{$_GET['month']}'";
		$wheres[] = "a.sitetype in ('".implode("','",$_GET['sitetype'])."')";
		$sql = "
			select
				a.order_seq as order_seq
				,year(a.deposit_date) as stats_year
				,month(a.deposit_date) as stats_month
				,day(a.deposit_date) as stats_day
				,substring(recipient_address,1,2) as location
				,sum(a.settleprice) as month_settleprice_sum
				,count(*) as month_count_sum
			from fm_order as a
			left join fm_order_item as c on a.order_seq = c.order_seq
			where ".implode(" and ", $wheres)."  and c.provider_seq = '{$this->providerInfo['provider_seq']}'
			group by location
		";
		$query = $this->db->query($sql);
		foreach($query->result_array() as $row) $statsData[$row['location']] = $row;

		/* 데이터 가공 */
		$maxDay = date('t',strtotime($_GET['year'].'-'.$_GET['month'].'-01'));
		$count_total_sum = 0;

		$dataForChart = array();
		$idx = 0;
		foreach($this->arr_location as $v){
			$count_total_sum += $statsData[$v]['month_count_sum'];
			$dataForChart['건수'][$idx][0] = $v;
			$dataForChart['건수'][$idx][1] = $statsData[$v]['month_count_sum']?$statsData[$v]['month_count_sum']:0;
			$dataForChart['금액'][$idx][0] = $v;
			$dataForChart['금액'][$idx][1] = $statsData[$v]['month_settleprice_sum']?$statsData[$v]['month_settleprice_sum']:0;
			$idx++;
		}

		$maxValue['건수'] = 0;
		$maxValue['금액'] = 0;
		foreach($dataForChart as $k=>$v){
			foreach($dataForChart[$k] as $row){
				$maxValue[$k] = $maxValue[$k] < $row[1] ? $row[1] : $maxValue[$k];
			}
		}

		$this->template->assign(array(
			'dataForChart'	=> $dataForChart,
			'maxDay'		=> $maxDay,
			'maxValue'		=> $maxValue
		));

		/* 일별 데이터 테이블 */
		$dataForTable = array();
		foreach($this->arr_location as $v){
			$dataForTable[$v] = $statsData[$v];
			$dataForTable[$v]['month_count_percent'] = $dataForTable[$v]['month_count_sum']?round($dataForTable[$v]['month_count_sum']/$count_total_sum*100):0;
		}

		$this->template->assign(array(
			'dataForTable'	=> $dataForTable,
			'arr_location'	=> $this->arr_location,
		));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/* 성별/연령별  매출 통계 */
	public function sales_age()
	{
		$this->admin_menu();
		$this->tempate_modules();

		$this->arr_age = array('10대 이하','20대','30대','40대','50대','60대 이상');
		$this->arr_sex = array('남','여');

		/* 관리자 권한 체크 : 시작 */
		/**
		$auth = $this->authmodel->manager_limit_act('statistic_sales');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}**/
		/* 관리자 권한 체크 : 끝 */

		### SERVICE CHECK
		$this->load->model('usedmodel');
		$result = $this->usedmodel->used_service_check('statistic_sales_detail');
		if(!$result['type']){
			$this->template->assign('statistic_sales_detail_limit','Y');
			exit;
		}

		/* 날짜 파라미터 */
		$_GET['year'] = !empty($_GET['year']) ? $_GET['year'] : date('Y');
		$_GET['month'] = isset($_GET['month']) ? $_GET['month'] : date('m');
		$_GET['sitetype'] = !empty($_GET['sitetype']) ? $_GET['sitetype'] : array();

		$statsData = array();

		/* 데이터 추출 : 주문금액, 결제금액, 마일리지사용, 할인금액, 배송비, 매입금액 */
		$wheres = array();
		$wheres[] = "a.deposit_yn='y'";
		$wheres[] = "year(a.deposit_date)='{$_GET['year']}'";
		$wheres[] = "b.buyer_age is not null";
		$wheres[] = "b.buyer_sex is not null";
		if(!empty($_GET['month'])) $wheres[] = "month(a.deposit_date)='{$_GET['month']}'";
		$wheres[] = "a.sitetype in ('".implode("','",$_GET['sitetype'])."')";
		$sql = "
			select
				a.order_seq as order_seq
				,year(a.deposit_date) as stats_year
				,month(a.deposit_date) as stats_month
				,day(a.deposit_date) as stats_day
				,case
					when b.buyer_age < 20 then '10대 이하'
					when b.buyer_age < 30 then '20대'
					when b.buyer_age < 40 then '30대'
					when b.buyer_age < 50 then '40대'
					when b.buyer_age < 60 then '50대'
					when b.buyer_age >= 60 then '60대 이상'
				end as buyer_age
				,case
					when b.buyer_sex = 'male' then '남'
					when b.buyer_sex = 'female' then '여'
				end as buyer_sex
				,sum(a.settleprice) as month_settleprice_sum
				,count(*) as month_count_sum
			from fm_order as a
			left join fm_order_item as c on a.order_seq = c.order_seq
			inner join fm_order_stats as b on a.order_seq=b.order_seq
			where ".implode(" and ", $wheres)."  and c.provider_seq = '{$this->providerInfo['provider_seq']}'
			group by buyer_age,buyer_sex
		";
		$query = $this->db->query($sql);
		foreach($query->result_array() as $row) $statsData[$row['buyer_sex']][$row['buyer_age']] = $row;

		/* 데이터 가공 */
		$maxDay = date('t',strtotime($_GET['year'].'-'.$_GET['month'].'-01'));
		$count_total_sum = 0;

		$idx = 0;
		foreach($this->arr_sex as $sex){
			foreach($this->arr_age as $age){
				$count_total_sum += $statsData[$sex][$age]['month_count_sum'];
				$idx++;
			}
		}

		/* 일별 데이터 테이블 */
		$count_total_sum;
		$dataForTable = array();
		$dataForTableSum = array();
		foreach($this->arr_sex as $sex){
			foreach($this->arr_age as $age){
				$dataForTable[$sex][$age] = $statsData[$sex][$age];
				$dataForTableSum[$age]['month_count_sum'] += $statsData[$sex][$age]['month_count_sum'];
				$dataForTableSum[$age]['month_settleprice_sum'] += $statsData[$sex][$age]['month_settleprice_sum'];
				$dataForTableSum[$age]['month_count_percent'] = $dataForTableSum[$age]['month_count_sum']?round($dataForTableSum[$age]['month_count_sum']/$count_total_sum*100):0;
			}
		}

		$dataForChart = array();

		$idx = 0;
		foreach($this->arr_age as $age){
			$dataForChart['건수'][$idx][0] = $age;
			$dataForChart['건수'][$idx][1] = $dataForTableSum[$age]['month_count_sum']?$dataForTableSum[$age]['month_count_sum']:0;
			$dataForChart['금액'][$idx][0] = $age;
			$dataForChart['금액'][$idx][1] = $dataForTableSum[$age]['month_settleprice_sum']?$dataForTableSum[$age]['month_settleprice_sum']:0;
			$idx++;
		}

		$this->template->assign(array(
			'dataForChart'		=> $dataForChart,
			'maxDay'			=> $maxDay,
			'dataForTable'		=> $dataForTable,
			'dataForTableSum'	=> $dataForTableSum,
			'arr_sex'			=> $this->arr_sex,
			'arr_age'			=> $this->arr_age,
		));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/* 판매환경별  매출 통계 */
	public function sales_platform()
	{
		$this->admin_menu();
		$this->tempate_modules();

		/* 관리자 권한 체크 : 시작 */
		/**
		$auth = $this->authmodel->manager_limit_act('statistic_sales');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}**/
		/* 관리자 권한 체크 : 끝 */

		### SERVICE CHECK
		$this->load->model('usedmodel');
		$result = $this->usedmodel->used_service_check('statistic_sales_detail');
		if(!$result['type']){
			$this->template->assign('statistic_sales_detail_limit','Y');
			exit;
		}

		/* 날짜 파라미터 */
		$_GET['year'] = !empty($_GET['year']) ? $_GET['year'] : date('Y');
		$_GET['month'] = isset($_GET['month']) ? $_GET['month'] : date('m');
		$_GET['sitetype'] = !empty($_GET['sitetype']) ? $_GET['sitetype'] : array();

		$statsData = array();

		/* 판매환경별 매출비율 */
		$wheres = array();
		$wheres[] = "a.deposit_yn='y'";
		$wheres[] = "year(a.deposit_date)='{$_GET['year']}'";
		if(!empty($_GET['month'])) $wheres[] = "month(a.deposit_date)='{$_GET['month']}'";
		$wheres[] = "a.sitetype in ('".implode("','",$_GET['sitetype'])."')";

		$query = $this->db->query("select
		sitetype,
		sum(settleprice) as settleprice_sum,
		count(*) as count_sum
		from fm_order as a
		left join fm_order_item as c on a.order_seq = c.order_seq
		where ".implode(" and ",$wheres)." and c.provider_seq = '{$this->providerInfo['provider_seq']}'
		group by sitetype;");
		$statsData = array();
		foreach($query->result_array() as $row) {
			$statsData[$row['sitetype']] = $row;
			$statsData[$row['sitetype']]['sitetype_name'] = $this->sitetypeloop[$row['sitetype']]['name'];
		}

		/* 데이터 가공 */
		$maxDay = date('t',strtotime($_GET['year'].'-'.$_GET['month'].'-01'));
		$count_total_sum = 0;

		$idx = 0;
		foreach($this->sitetypeloop as $sitetype=>$v){
			$count_total_sum += $statsData[$sitetype]['count_sum'];
			$idx++;
		}

		/* 일별 데이터 테이블 */
		$dataForTable = array();
		foreach($this->sitetypeloop as $sitetype=>$v){
			$dataForTable[$sitetype] = $statsData[$sitetype];
			$dataForTable[$sitetype]['count_percent'] = $dataForTable[$sitetype]['count_sum']?round($dataForTable[$sitetype]['count_sum']/$count_total_sum*100):0;
		}

		$dataForChart = array();
		$idx=0;
		foreach($this->sitetypeloop as $sitetype=>$v){
			$dataForChart['금액'][$idx][0] = $this->sitetypeloop[$sitetype]['name'];
			$dataForChart['금액'][$idx][1] = $statsData[$sitetype]['settleprice_sum'] ? $statsData[$sitetype]['settleprice_sum'] : 0;
			$dataForChart['건수'][$idx][0] = $this->sitetypeloop[$sitetype]['name'];
			$dataForChart['건수'][$idx][1] = $statsData[$sitetype]['count_sum'] ? $statsData[$sitetype]['count_sum'] : 0;
			$idx++;
		}

		$this->template->assign(array(
			'dataForTable'	=> $dataForTable,
			'dataForChart' => $dataForChart,
		));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}



}

/* End of file statistic_sales.php */
/* Location: ./app/controllers/selleradmin/statistic_sales.php */