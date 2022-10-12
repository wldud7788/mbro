<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class accountall_process extends admin_base {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('validation');
	}

	public function accountall_setting()
	{
		$this->load->model('providermodel');
		$this->load->model('accountallmodel');

		$accountallNextConfirm	= $this->accountallmodel->get_account_setting('last');
		$sellerAccCycleListTmp	= $this->accountallmodel->get_provider_calcu_list('last');

		$this->validation->set_rules('accountall_confirm', '정산마감일','trim|required|xss_clean');
		$this->validation->set_rules('accountall_period_same', '정산 주기','trim|required|xss_clean');

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		$managerSeq							= $this->managerInfo['manager_seq'];
		$accountallPeriodSame				= $this->input->post('accountall_period_same');
		$accountallConfirm					= $this->input->post('accountall_confirm');
		$accountallProviderSeqArr			= $this->input->post('accountall_provider_seq');	
		$accountallProviderCalcuCountArr	= $this->input->post('accountall_provider_calcu_count');
		$sellerAccCycle 	= array();
		$sellerAccCycle[1]	= 0;
		$sellerAccCycle[2]	= 0;
		$sellerAccCycle[4]	= 0;
		$cnt = 0;
		foreach($sellerAccCycleListTmp as $sellerAccCycleList){
			if($accountallProviderCalcuCountArr[$sellerAccCycleList['provider_seq']]){
				$sellerAccCycle[$accountallProviderCalcuCountArr[$sellerAccCycleList['provider_seq']]]++;
				$cnt++;
			}else{
				$sellerAccCycle[$sellerAccCycleList['calcu_count']]++;
			}
		}

		$confirmArr = array(1,8,11);
		if( !in_array($accountallConfirm,$confirmArr) ){
			openDialogAlert("잘못된 접근입니다.",400,140,'parent',$callback);
			exit;
		}

		$periodArr = array('Y','N');
		if( !in_array($accountallPeriodSame,$periodArr) ){
			openDialogAlert("잘못된 접근입니다.",400,140,'parent',$callback);
			exit;
		}

		if( empty($accountallProviderSeqArr) ){
			openDialogAlert("선택된 입점사가 없습니다.",400,140,'parent',$callback);
			exit;
		}

		if( $accountallPeriodSame == 'N' && $accountallConfirm != 1 ){
			openDialogAlert("정산 주기가 모든 입점사 월 1회가 아님일 경우 정산 주기는 당월 말일만 가능합니다.",400,160,'parent',$callback);
			exit;
		}

		if( $accountallPeriodSame == 'N' && $sellerAccCycle[2] == 0 && $sellerAccCycle[4] == 0 ){
			openDialogAlert("정산 주기가 월 1회가 아닌 입점사를 선택해 주세요.",400,160,'parent',$callback);
			exit;
		}

		if( $accountallPeriodSame == 'Y' && ($sellerAccCycle[2] > 0 || $sellerAccCycle[4] > 0) ){
			openDialogAlert("모든 입점사의 정산주기가 동일하지 않습니다.",400,160,'parent',$callback);
			exit;
		}

		if( $accountallPeriodSame == $accountallNextConfirm['accountall_period_same'] && $accountallConfirm == $accountallNextConfirm['accountall_confirm'] && $cnt == 0 ){
			openDialogAlert("변경된 정보가 없어 저장할 수 없습니다.",400,140,'parent',$callback);
			exit;
		}

		foreach($accountallProviderSeqArr as $providerSeq ){
			$accountallProviderCalcuCount = $accountallProviderCalcuCountArr[$providerSeq];
			$result = $this->accountallmodel->insert_account_provider_period($providerSeq,$accountallProviderCalcuCount);
		}
		$result = $this->accountallmodel->insert_account_setting($managerSeq,$accountallPeriodSame,$accountallConfirm);
		$callback = "parent.document.location.reload();";
		if($result == false){
			openDialogAlert("설정시 오류가 있습니다.",400,140,'parent',$callback);
			exit;
		}
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}

	public function accountall_period_setting()
	{
		$this->load->model('accountallmodel');

		if( !$_POST['set_provider_seq'] ){
			echo "ERR1";
			exit;
		}
		$cnt = 0;
		$setProviderSeqArr			= $this->input->post('set_provider_seq');	
		$setProviderCalcuCountArr	= $this->input->post('set_provider_calcu_count');

		foreach($setProviderSeqArr as $providerSeq ){
			$setProviderCalcuCount = $setProviderCalcuCountArr[$providerSeq];
			$result = $this->accountallmodel->insert_account_provider_period($providerSeq,$setProviderCalcuCount);
			$cnt += $result;
		}

		echo $cnt;
	}
}

/* End of file returns_process.php */
/* Location: ./app/controllers/admin/returns_process.php */