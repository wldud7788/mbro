<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/batch/batchUser".EXT);
class _batch extends batchUser {
	function __construct() {		
		parent::__construct();
	}
	/* daily */
	public function daily(){		
		$this->_dailyEtc();
		$this->_dailyMember();
		$this->_dailyGoods();
		$this->_dailyOrder();		
		$this->_dailyAcc();
		$this->_dailyRemind();
		$this->_dailyStats();
	}
	protected function _dailyEtc(){	   
		$this->config->load('batch'.ucfirst(str_replace('_', '', __FUNCTION__)));		
		$this->batchlib->aExecFunc = $this->config->item('aExecFunc');
		$this->shop_branch();		
	}
	protected function _dailyMember(){
		$this->config->load('batch'.ucfirst(str_replace('_', '', __FUNCTION__)));
		$this->batchlib->aExecFunc = $this->config->item('aExecFunc');		
		$this->member_emoney_deduction();
	}
	protected function _dailyGoods(){
		$this->config->load('batch'.ucfirst(str_replace('_', '', __FUNCTION__)));		
		$this->batchlib->aExecFunc = $this->config->item('aExecFunc');		
		$this->social_goods_validate();
	}
	protected function _dailyOrder(){
		$this->config->load('batch'.ucfirst(str_replace('_', '', __FUNCTION__)));		
		$this->batchlib->aExecFunc = $this->config->item('aExecFunc');
		$this->order_cancel();
	}	
	protected function _dailyAcc(){
		$this->config->load('batch'.ucfirst(str_replace('_', '', __FUNCTION__))); 
		$this->batchlib->aExecFunc = $this->config->item('aExecFunc');
		$this->accumul_stats_sales();
	}
	protected function _dailyRemind(){
		$this->config->load('batch'.ucfirst(str_replace('_', '', __FUNCTION__)));   
		$this->batchlib->aExecFunc = $this->config->item('aExecFunc');
		$this->remind_coupon();
	}
	protected function _dailyStats(){
		$this->config->load('batch'.ucfirst(str_replace('_', '', __FUNCTION__)));		
		$this->batchlib->aExecFunc = $this->config->item('aExecFunc');
		$this->stats_delete();
	}
	/* daily EP */
	public function daily_ep(){
		$this->_dailyEp();
	}
	protected function _dailyEp(){
		$this->config->load('batch'.ucfirst(str_replace('_', '', __FUNCTION__)));		
		$this->batchlib->aExecFunc = $this->config->item('aExecFunc');
		$this->createDaumFile();
	}
	/* 20 min */   
	public function cron_send_email(){	
		$this->_exportMsg();
	}	
	protected function _exportMsg(){		
		$this->config->load('batch'.ucfirst(str_replace('_', '', __FUNCTION__)));   
		$this->batchlib->aExecFunc = $this->config->item('aExecFunc');
		$this->cron_deposit_mail_sms();
	}
	
	//적립금 통계 마이그레이션
	public function set_emoney_mi(){
		$this->load->model('statsmodel');
		
		echo '----------------------------------------------------------';
		if($_SERVER) echo "<br />";
        echo ' :: 적립금 통계 재수집 - set_emoney_mi Start';
		if($_SERVER) echo "<br />";

		$start_year 	= "2019";	// 시작년도
		$end_year 		= "2020";	// 종료년도
		$start_month 	= "01";		// 시작월
		$end_month 		= "12";		// 종료월
		
		$start_ym 		= $start_year."-".$start_month;
		$end_ym 		= $end_year."-".$end_month;
		
		$year_diff 		= $end_year - $start_year;
		//$this->db->query("delete from fm_stats_epc where stats_type = 'emoney' ");
		
		for($i=0; $i <= $year_diff; $i++){
			$startYear = $start_year + $i;
			
			$loopStartYear = $startYear;
			
			if($startYear == $start_year){
				$loopStartMonth = $start_month;
				$loopEndMonth = "12";
			}else if($startYear != $start_year && $startYear < $end_year){
				$loopStartMonth = "01";
				$loopEndMonth = "12";
			}else{
				$loopStartMonth = "01";
				$loopEndMonth = $end_month;
			}
			
			for($month = (int)$loopStartMonth; $month <= $loopEndMonth; $month++){
				if($month < 10){
					$getMonth = "0".$month;
				}else{
					$getMonth = $month;
				}
				
				$prams['startDate'] = $loopStartYear."-".$getMonth."-01";
				$prams['startYear'] = $loopStartYear;
				$prams['startMonth'] = $getMonth;
				
				$this->statistic_epc_mi($prams,'emoney');
			}
		}
		echo ' :: 적립금 통계 재수집 - set_emoney_mi  End';
		if($_SERVER) echo "<br />";
		echo '----------------------------------------------------------';
		if($_SERVER) echo "<br />";
	}
	
	//포인트 통계 마이그레이션
	public function set_point_mi(){

		$this->load->model('statsmodel');
		
		echo '----------------------------------------------------------';
		if($_SERVER) echo "<br />";
        echo ' :: 포인트 통계 재수집- set_point_mi Start';
		if($_SERVER) echo "<br />";
		
		$start_year 	= "2019";	// 시작년도
		$end_year 		= "2020";	// 종료년도
		$start_month 	= "01";		// 시작월
		$end_month 		= "12";		// 종료월
		
		$start_ym 		= $start_year."-".$start_month;
		$end_ym 		= $end_year."-".$end_month;
		
		$year_diff 		= $end_year - $start_year;
		$this->db->query("delete from fm_stats_epc where stats_type = 'point'");
		
		for($i=0; $i <= $year_diff; $i++){
			$startYear = $start_year + $i;
			
			$loopStartYear = $startYear;
			
			if($startYear == $start_year){
				$loopStartMonth = $start_month;
				$loopEndMonth = "12";
			}else if($startYear != $start_year && $startYear < $end_year){
				$loopStartMonth = "01";
				$loopEndMonth = "12";
			}else{
				$loopStartMonth = "01";
				$loopEndMonth = $end_month;
			}
			
			for($month = (int)$loopStartMonth; $month <= $loopEndMonth; $month++){
				if($month < 10){
					$getMonth = "0".$month;
				}else{
					$getMonth = $month;
				}
				
				$prams['startDate'] = $loopStartYear."-".$getMonth."-01";
				$prams['startYear'] = $loopStartYear;
				$prams['startMonth'] = $getMonth;
				
				$this->statistic_epc_mi($prams,'point');
			}
		}
		echo ' :: 포인트 통계 재수집- set_point_mi End';
		if($_SERVER) echo "<br />";
		echo '----------------------------------------------------------';
		if($_SERVER) echo "<br />";
	}
	
	function statistic_epc_mi($params, $epc){
		$this->load->model('statsmodel');
		$stats_type = $epc;
		$now_date			= $params['startDate'];
		$now_year			= $params['startYear'];
		$now_month			= $params['startMonth'];
		$que				= "select count(*) as cnt from fm_stats_epc where stats_type = '{$stats_type}'";
		$query				= $this->db->query($que);
		$res				= $query->row_array();
		$cnt				= $res['cnt'];
		$stats['now_date']	= $now_date;

		//최초 여부 검사
		if($cnt > 0){
			//부득이 하게 지난달에 정산을 하지 못하였을 경우를 대비
			$sql = "select * from fm_stats_epc where stats_type = '{$stats_type}' order by stats_date desc limit 1";
			$result		= $this->db->query($sql);
			$pprs		= $result->row_array();
			
			if(!$pprs['stats_date']) return;
			//마지막날짜와 현재날짜의 차이를 계산하여 루프를 돈다
			$diff		= dateDiffMonth($pprs['stats_date'],$now_date);
			
			$stats['before_total']	= $pprs['after_total'] ? $pprs['after_total'] : 0;
			
			for($i=1;$i<=$diff+1;$i++){
				$stats['e_date']		= monthAddMinus($pprs['stats_date'],$i);
				$stats['s_date']		= monthAddMinus($stats['e_date'],-1);
				$stats['s_date_year']	= substr($stats['s_date'],0,4);
				$stats['s_date_month']	= substr($stats['s_date'],5,2);
				
				//중복검사
				if($this->statsmodel->isOverlap_epc($stats['s_date_year'],$stats['s_date_month'],$stats_type)) continue;
				
				$month_stats			= $this->statsmodel->get_stats_epc($stats['s_date'],$stats['e_date'],$stats_type);
				$stats['before_total']	= $this->statsmodel->stats_epc_insert($stats_type,$stats,$month_stats);
			}
		}else{
			//마이그레이션이 안되었을 경우를 대비하여
			$que = "select min(ifnull(regist_date,'0000-00-00')) min from fm_stats_epc where stats_type = '{$stats_type}' and regist_date !=  '0000-00-00 00:00:00'";
			$query				= $this->db->query($que);
			$res				= $query->row_array();
			$min				= $res['min'];
			if(!$min) {
				$min = date("Y-m-d", strtotime('-1 month',strtotime($now_date)));
			}
			$min_start_year		= substr($min,0,4);
			$min_start_month	= substr($min,5,2);
			
			//처음시작된 마일리지 날짜와 당월이 같다면 다음달에 진행 한다
			if(!($min_start_year == $now_year && $min_start_month == $now_month)){
				$stats['before_total']	= 0; //이월금액
				$start_date = $min;
				
				//최초날짜와 현재날짜의 차이를 계산하여 루프를 돈다
				$diff = dateDiffMonth($start_date,$now_date);
				
				for($i=1;$i<=$diff+1;$i++){
					$stats['e_date']		= monthAddMinus($start_date,$i);
					$stats['s_date']		= monthAddMinus($stats['e_date'],-1);
					$stats['s_date_year']	= substr($stats['s_date'],0,4);
					$stats['s_date_month']	= substr($stats['s_date'],5,2);
					
					//중복검사
					if($this->statsmodel->isOverlap_epc($stats['s_date_year'],$stats['s_date_month'],$stats_type)) continue;
					
					$month_stats			= $this->statsmodel->get_stats_epc($stats['s_date'],$stats['e_date'],$stats_type);
					$stats['before_total']	= $this->statsmodel->stats_epc_insert($stats_type,$stats,$month_stats);
				}
			}
		}

		
        echo $now_date.' :: statistic_epc OK';
        if($_SERVER) echo "<br />";
	}
}

// END
/* End of file _batch.php */
/* Location: ./app/controllers/_batch.php */