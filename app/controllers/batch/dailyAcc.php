<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/batch/dailyRemind".EXT);
class dailyAcc extends dailyRemind {
    public function __construct() {
        parent::__construct();
    }    
    ### 구매통계 - 상품 - 일별 데이터
	public function accumul_stats_sales(){
		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('statsmodel');
            $yester_day = date('Y-m-d', strtotime('-1day'));
            //$yester_day = '2014-07-27';
            $daily_data	= $this->statsmodel->get_daily_sales_stats($yester_day,$yester_day);

            // 넣을 데이터 삭제
            $this->statsmodel->delete_accumul_stats_sales($yester_day,$yester_day);

            if($daily_data){
                foreach($daily_data as $k => $sel_data){
                    $this->statsmodel->set_accumul_stats_sales($sel_data);
                }                
            }else{                
                throw new Exception('stats_sales is No data');
            }
		} catch (Exception $e) {			
			if( $aFunc ){
                $this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
            }            
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}    
    ## 구매통계 - 매출 - 일별 월별 데이터
	public function accumul_sales_mdstats(){
		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('statsmodel');
            $yester_day = date('Y-m-d', strtotime('-1day'));
            //$yester_day = '2014-07-25';

            $daily_data	= $this->statsmodel->get_sales_mdstats($yester_day,$yester_day);

            // 넣을 데이터 삭제
            $this->statsmodel->delete_accumul_sales_mdstats($yester_day,$yester_day);

            if($daily_data){
                foreach($daily_data as $k => $sel_data){
                    $arr_seq[] = $sel_data['order_seq'];
                    $this->statsmodel->set_accumul_sales_mdstats($sel_data);
                }
                // 통계수집체크처리 :: 2015-09-30 lwh
                $this->statsmodel->set_accumul_mark($arr_seq,'Y');                
            }else{
                throw new Exception('sales_mdstats is No data');                
            }
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}    
    ## 구매통계 - 매출 - 일별 월별 환불 데이터
	public function accumul_sales_refund(){
		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('statsmodel');
            $yester_day = date('Y-m-d', strtotime('-1day'));
            //$yester_day = '2014-07-25';

            $daily_data	= $this->statsmodel->get_sales_refund($yester_day,$yester_day);

            // 넣을 데이터 삭제
            $this->statsmodel->delete_accumul_sales_refund($yester_day,$yester_day);

            if($daily_data){
                foreach($daily_data as $k => $sel_data){
                    $this->statsmodel->set_accumul_sales_refund($sel_data);
                }                
            }else{
                throw new Exception('sales_refund is No data');
            }
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}    
    ## 구매통계 - 카테고리/브랜드별 데이터
	public function accumul_sales_category(){
		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('statsmodel');
            $yester_day = date('Y-m-d', strtotime('-1day'));
            //$yester_day = '2014-07-05';

            $daily_data_C	= $this->statsmodel->get_sales_category('C',$yester_day,$yester_day);

            $daily_data_B	= $this->statsmodel->get_sales_category('B',$yester_day,$yester_day);

            // 넣을 데이터 삭제
            $this->statsmodel->delete_accumul_sales_category($yester_day,$yester_day);

            foreach($daily_data_C as $k => $sel_data){
                $sel_data['t_type'] = 'C';
                $this->statsmodel->set_accumul_sales_category($sel_data);
            }

            foreach($daily_data_B as $k => $sel_data){
                $sel_data['t_type'] = 'B';
                $this->statsmodel->set_accumul_sales_category($sel_data);
            }

            if(!$daily_data_C && !$daily_data_B){
                throw new Exception('sales_category is No data');
            }
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
    ### 구매통계 - 상품 - 장바구니 일별 데이터
	public function accumul_cart_stats(){
		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('statsmodel');
            $stats_date		= date('Y-m-d', strtotime('-1 day'));

            // 넣을 데이터 삭제
            $this->statsmodel->delete_accumul_cart_stats($stats_date);

            $result		= $this->statsmodel->set_accumul_cart_stats($stats_date);
            if(!$result) {
                throw new Exception('cart_stats is No data');
            }			
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
}