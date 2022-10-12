<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/batch/dailyAcc".EXT);
class dailyEp extends dailyAcc {
    public function __construct() {
        parent::__construct();
    }    
    public function createDaumFile(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('partnermodel');		
			$this->partnermodel->cron_daumFile('all');
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}    
    public function createNaverFile(){        
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('partnermodel');		
			$this->partnermodel->cron_naverFile('all');
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}    
    public function createNaverThirdFile(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('partnermodel');		
			$this->partnermodel->cron_naverThirdFile('all');
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
    public function createReviewFile(){		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('partnermodel');		
			$this->partnermodel->cron_reviewFile('all');
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	public function createNaverSalesEpFile(){		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('partnermodel');		
			$this->partnermodel->cron_naverSalesEP('file');
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	public function createFacebookFile(){
	    list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
	    try{
	        $this->load->model('partnermodel');
	        $this->partnermodel->cron_feedFiles('file', 'facebook');
	    } catch (Exception $e) {
	        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
	    }
	    if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
	    if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	public function createGoogleFile(){
	    list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
	    try{
	        $this->load->model('partnermodel');
	        $this->partnermodel->cron_feedFiles('file', 'google');
	    } catch (Exception $e) {
	        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
	    }
	    if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
	    if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
}