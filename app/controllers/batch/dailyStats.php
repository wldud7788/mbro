<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/common_base".EXT);
class dailyStats extends common_base {

	var $iOnTimeStamp = '';

	public function __construct() {
		parent::__construct();
		error_reporting(E_ERROR);
		set_time_limit(0);
		ini_set('memory_limit', '-1');
		$this->db->db_debug = false;		
		$this->load->library('batchLib');		
		$this->load->model('accountallmodel');   

		$this->iOnTimeStamp		= time();
		//$this->iOnTimeStamp		= mktime(1,1,1,4,1,2019);		// 정산마감일 수동 지정 처리

		if($this->accountallmodel->_debug){
			echo "dailyStats iOnTimeStamp Y-m-d : ".date('Y-m-d', $this->iOnTimeStamp)."\r\n";
			echo "dailyStats iOnTimeStamp -1 month Y-m : ".date('Y-m', strtotime('-1 month',$this->iOnTimeStamp))."\r\n";
			echo "dailyStats iOnTimeStamp Day : ".date("d",$this->iOnTimeStamp)."\r\n"; 
		}
	}
	
	public function stats_delete()
	{		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('statsmodel');
			$this->statsmodel->last_year_delete();

			$this->load->model('visitorlog');
			$this->visitorlog->ip_delete();		
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	
	public function statistic_epc(){		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$today = date("d",$this->iOnTimeStamp);
			if($today=='01'){
				$this->load->model('statsmodel');
				$epc = array('emoney','point','cash');
				foreach($epc as $stats_type){
					$now_date			= date('Y-m-d');
					$now_year			= date('Y');
					$now_month			= date('m');
					$que				= "select count(*) as cnt from fm_stats_epc where stats_type = '{$stats_type}'";
					$query				= mysqli_query($this->db->conn_id,$que);
					$res				= mysqli_fetch_assoc($query);
					$cnt				= $res['cnt'];
					$stats['now_date']	= $now_date;

					//최초 여부 검사
					if($cnt > 0){
						//부득이 하게 지난달에 정산을 하지 못하였을 경우를 대비
						$sql = "select * from fm_stats_epc where stats_type = '{$stats_type}' order by stats_date desc limit 1";
						$result		= mysqli_query($this->db->conn_id,$sql);
						$pprs		= mysqli_fetch_assoc($result);
						if(!$pprs['stats_date']) continue;
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
						$que = "select min(ifnull(regist_date,'0000-00-00')) min from fm_".$stats_type." where regist_date !=  '0000-00-00 00:00:00'";
						$query				= mysqli_query($this->db->conn_id,$que);
						$res				= mysqli_fetch_assoc($query);
						$min				= $res['min'];
						if(!$min) continue;
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
				}
			}
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}	
	public function daily_stats(){		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{		   
			$this->load->model('dailystatsmodel');
			$this->load->model('goodsmodel');
			$custom_date = isset($_GET['date']) && $_GET['date'] ? $_GET['date'] : null;
			$this->dailystatsmodel->exec_func($custom_date);
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	##
	public function set_referer_domain(){		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$sql	= "select * from fm_cart_stats where referer like 'http%' and (referer_domain is null or referer_domain = '' or referer_domain like 'm.%' or referer_domain like 'www.%' or referer_domain = '0') ";
			$rs		= mysqli_query($this->db->conn_id,$sql);
			while ($data = mysqli_fetch_assoc($rs)){
				$seq	= $data['cart_stats_seq'];
				$tmp	= parse_url($data['referer']);
				$domain	= $tmp['host'];
				$domain	= preg_replace('/^(www\.|m\.)/', '', $domain);
				$sql	= "update fm_cart_stats set referer_domain = '".$domain."' where cart_stats_seq = '".$seq."' ";
				mysqli_query($this->db->conn_id,$sql);
			}

			$sql	= "select * from fm_member where referer like 'http%' and (referer_domain is null or referer_domain = '' or referer_domain like 'm.%' or referer_domain like 'www.%' or referer_domain = '0') ";
			$rs		= mysqli_query($this->db->conn_id,$sql);
			while ($data = mysqli_fetch_assoc($rs)){
				$seq	= $data['member_seq'];
				$tmp	= parse_url($data['referer']);
				$domain	= $tmp['host'];
				$domain	= preg_replace('/^(www\.|m\.)/', '', $domain);
				$sql	= "update fm_member set referer_domain = '".$domain."' where member_seq = '".$seq."' ";
				mysqli_query($this->db->conn_id,$sql);
			}

			$sql	= "select * from fm_member_stats where referer like 'http%' and (referer_domain is null or referer_domain = '' or referer_domain like 'm.%' or referer_domain like 'www.%' or referer_domain = '0') ";
			$rs		= mysqli_query($this->db->conn_id,$sql);
			while ($data = mysqli_fetch_assoc($rs)){
				$seq	= $data['member_stats_seq'];
				$tmp	= parse_url($data['referer']);
				$domain	= $tmp['host'];
				$domain	= preg_replace('/^(www\.|m\.)/', '', $domain);
				$sql	= "update fm_member_stats set referer_domain = '".$domain."' where member_stats_seq = '".$seq."' ";
				mysqli_query($this->db->conn_id,$sql);
			}

			$sql	= "select * from fm_order where referer like 'http%' and (referer_domain is null or referer_domain = '' or referer_domain like 'm.%' or referer_domain like 'www.%' or referer_domain = '0') ";
			$rs		= mysqli_query($this->db->conn_id,$sql);
			while ($data = mysqli_fetch_assoc($rs)){
				$seq	= $data['order_seq'];
				$tmp	= parse_url($data['referer']);
				$domain	= $tmp['host'];
				$domain	= preg_replace('/^(www\.|m\.)/', '', $domain);
				$sql	= "update fm_order set referer_domain = '".$domain."' where order_seq = '".$seq."' ";
				mysqli_query($this->db->conn_id,$sql);
			}

			$sql	= "select * from fm_order_stats where referer like 'http%' and (referer_domain is null or referer_domain = '' or referer_domain like 'm.%' or referer_domain like 'www.%' or referer_domain = '0') ";
			$rs		= mysqli_query($this->db->conn_id,$sql);
			while ($data = mysqli_fetch_assoc($rs)){
				$seq	= $data['order_stats_seq'];
				$tmp	= parse_url($data['referer']);
				$domain	= $tmp['host'];
				$domain	= preg_replace('/^(www\.|m\.)/', '', $domain);
				$sql	= "update fm_order_stats set referer_domain = '".$domain."' where order_stats_seq = '".$seq."' ";
				mysqli_query($this->db->conn_id,$sql);
			}

			$sql	= "select * from fm_stats_visitor_referer where referer like 'http%' and (referer_domain is null or referer_domain = '' or referer_domain like 'm.%' or referer_domain like 'www.%' or referer_domain = '0') ";
			$rs		= mysqli_query($this->db->conn_id,$sql);
			while ($data = mysqli_fetch_assoc($rs)){
				$seq	= $data['seq'];
				$tmp	= parse_url($data['referer']);
				$domain	= $tmp['host'];
				$domain	= preg_replace('/^(www\.|m\.)/', '', $domain);
				$sql	= "update fm_stats_visitor_referer set referer_domain = '".$domain."' where seq = '".$seq."' ";
				mysqli_query($this->db->conn_id,$sql);
			}			
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
		
	}
	public function account_seller_del_sales(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$accountAllMiDate = config_load("accountall_setting","accountall_migration_date");
			if($accountAllMiDate){
				$accountAllMigrationDate = $accountAllMiDate['accountall_migration_date'];
				$migrationYear = substr($accountAllMigrationDate,0,4);
				$migrationMonth = (substr($accountAllMigrationDate,5,2)+1);
				$migrationcheck = date("Y-m-d", mktime(0, 0, 0, intval($migrationMonth), 1, intval($migrationYear)));
				$migration = date("Y-m-d H:i:s", mktime(0, 0, 0, intval($migrationMonth), 1, intval($migrationYear)));
				$checkdate = date("Y-m-d");
				if($accountAllMigrationDate != "0000-00-00" && $checkdate == $migrationcheck){
					$this->accountallmodel->account_migration_sales_del($migration);
				}
			}
			// 이월 데이터 삭제 없음 by hed
			// $this->accountallmodel->account_carryover_del_sales();						//정산 대상이 아닌 이전달(이월) 데이터 삭제
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}

	public function account_seller_stats2(){

		if(!$this->providermodel) $this->load->model('providermodel');
		$this->iOnTimeStamp = mktime(0,0,0,5,1,2019);
		$this->accountallmodel->_debug = true;
		$this->accountallmodel->iOnTimeStamp = $this->iOnTimeStamp;	

		$this->accountallmodel->account_seller_stats_insert_cronjob();				//입점사별 정산통계

	}

	public function account_seller_stats(){		
		
		$this->accountallmodel->_debug = true;
		$this->accountallmodel->iOnTimeStamp = $this->iOnTimeStamp;

		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			//정산 대상이 아닌 이전달(이월) 데이터 삭제
			// $this->accountallmodel->account_carryover_del_sales();
			// 정산마감일
			$accountall_cnt_confirm	= $this->accountallmodel->get_account_setting('cron');
			$account_confirm = $accountall_cnt_confirm['accountall_confirm'];
			// 정산마감일 없을 경우 실행되지 않음
			if($account_confirm){

				$today = date("d",$this->iOnTimeStamp);
				
				echo "\r\ntoday : ". $today ." == ".date("Y-m-d",$this->iOnTimeStamp) ."\r\n";

				if($today == $account_confirm){//1일자 전월데이타 집계처리
					$confirm["confirm_year_month"]		= date('Y-m', strtotime('-1 month',$this->iOnTimeStamp));
					$confirm["confirm_day"] = $account_confirm;
					$confirm["confirm_start_date"]		= date("Y-m-d H:i:s",$this->iOnTimeStamp);
					$this->load->helper('accountall');
					if(!$this->providermodel) $this->load->model('providermodel');
					if(!$this->accountallmodel->account_fee_ar['pg']){//pg 수수료통제외(엑셀업로드시적용)
						$this->accountallmodel->account_seller_stats_insert_cronjob();				//입점사별 정산통계
						$this->accountallmodel->account_carryover_overdraw_insert_cronjob();		//미정산->당월데이타를 미정산-전월 정산데이타 생성
					}
					$confirm["confirm_end_date"] = date('Y-m-d H:i:s', $this->iOnTimeStamp);
					$this->accountallmodel->insert_account_confirm($confirm);
				}
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	
	public function account_seller_period_update(){		
 
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
 
		try{
			if(date("d",$this->iOnTimeStamp) < 5){
				$this->load->model('providermodel');
				$providerList = $this->accountallmodel->get_provider_calcu_list('pre');
				foreach($providerList as $provider){
					$this->accountallmodel->update_provider_acccount_period($provider['provider_seq'],$provider['calcu_count']);
				}
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	
	public function goods_purchase_ea(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$sUpdateQuery  = "update fm_goods set purchase_ea_3mon = 0";
			mysqli_query($this->db->conn_id, $sUpdateQuery);
			$sQuery	= "SELECT daily_goods_seq, SUM(daily_ea) tot_ea FROM `fm_daily_stats_order_m_3` WHERE daily_ea IS NOT NULL GROUP BY daily_goods_seq";
			$rQuery	= mysqli_query($this->db->conn_id, $sQuery);
			while($aData   = mysqli_fetch_array($rQuery)){
				$sUpdateQuery  = "update fm_goods set purchase_ea_3mon = '".$aData['tot_ea']."' where goods_seq = '".$aData['daily_goods_seq']."'";
				mysqli_query($this->db->conn_id, $sUpdateQuery);			
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
}
