<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class referer_process extends admin_base {

	public function __construct() {
		parent::__construct();

		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('referer_act');
		if(!$auth){
			$callback = "";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}
		/* 관리자 권한 체크 : 끝 */

		$this->load->library(array('validation','pxl'));
		$this->load->model('referermodel');
	}


	// 유입경로 할인 PARAMETER 체크
	public function _check_param($mode = 'regist'){

		$aPostParams = $this->input->post();
		
		if	($mode == 'regist'){
			$aPostParams['refererUrl']		= trim($aPostParams['refererUrl']);

			// http나 https 제거
			if	(preg_match('/^http/', $aPostParams['refererUrl']))
				$aPostParams['refererUrl']	= preg_replace('/^https*\:\/\//', '', trim($aPostParams['refererUrl']));

			$this->validation->set_rules('refererName', '유입경로명','trim|required|xss_clean');
			$this->validation->set_rules('refererDesc', '유입경로설명','trim|xss_clean');
			$this->validation->set_rules('refererUrl', '유입경로 URL','trim|required|xss_clean');
		}

		if($aPostParams['sales_tag'] == "provider"){
			if(count($aPostParams['salescost_provider_list']) < 1){
				openDialogAlert("입점사 지정은 필수 항목입니다.",450,140,'parent',$callback);
				exit;
			}
			$this->validation->set_rules('salescostper', '입점사 부담률','trim|required|xss_clean');
		}else{
			$aPostParams['salescost_provider_list'] 	= null;
			$aPostParams['salescostper']				= 0;
		}

		$this->validation->set_rules('saleType', '혜택','trim|required|max_length[7]|xss_clean');
		$aPostParams['percentGoodsSale']		= ($aPostParams['percentGoodsSale'] > 0) ? $aPostParams['percentGoodsSale'] : '';
		$aPostParams['maxPercentGoodsSale']		= ($aPostParams['maxPercentGoodsSale'] > 0) ? $aPostParams['maxPercentGoodsSale'] : '';
		$aPostParams['wonGoodsSale']			= ($aPostParams['wonGoodsSale'] > 0) ? $aPostParams['wonGoodsSale'] : '';
		if($aPostParams['saleType'] == 'percent'){
			$this->validation->set_rules('percentGoodsSale', '혜택','trim|required|numeric|max_length[3]|xss_clean');
			$this->validation->set_rules('maxPercentGoodsSale', '최대 할인 금액','trim|required|numeric|xss_clean');
		}elseif($aPostParams['saleType']=='won'){
			$this->validation->set_rules('wonGoodsSale', '할인 금액','trim|required|numeric|xss_clean');
		}
		$this->validation->set_rules('issueDate[]', '유효 기간','trim|required|max_length[10]|xss_clean');
		if	(strtotime($aPostParams['issueDate'][0]) > strtotime($aPostParams['issueDate'][1])){
			$callback = "parent.document.getElementsByName('issueDate')[0].focus();";
			openDialogAlert("유효기간 시작일이 종료일보다 크게 입력되었습니다.",400,140,'parent',$callback);
			exit;
		}
		$this->validation->set_rules('limitGoodsPrice', '사용제한 금액','trim|numeric|xss_clean');

		if($this->validation->exec()===false){
			$err 		= $this->validation->error_array;
			$callback 	= "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		if(in_array($aPostParams['issue_type'],array('issue','except'))){
			if($aPostParams['issue_type'] == 'except') $tit = " 예외";
			$this->validation->set_rules('issueGoods[]', '적용'.$tit.' 상품','trim|numeric|xss_clean');
			$this->validation->set_rules('issueCategoryCode[]', '적용'.$tit.' 카테고리','trim|xss_clean');
			
			if(count($aPostParams['issueGoods']) == 0 && count($aPostParams['issueCategoryCode']) == 0){
				$callback = "";
				openDialogAlert("유입 경로 할인 제한 할 상품 또는 카테고리를 선택해 주세요.",400,160,'parent',$callback);
				exit;
			}
		}
		
		// 중복확인
		$chkReferer	= $this->referermodel->chk_referersale_duple($aPostParams['refererUrl'], $aPostParams['refererUrlType'], $aPostParams['issueDate'][0], $aPostParams['issueDate'][1], $aPostParams['provider_seq_list'], $aPostParams['referersaleSeq']);
		if	($chkReferer['referersale_seq']){
			$callback = "parent.document.getElementsByName('refererUrl')[0].focus();";
			openDialogAlert("유입경로 URL의 유효기간이 중복됩니다. 유효기간을 조정해 주세요.",400,140,'parent',$callback);
			exit;
		}

		$aPostParams['issue_type'] 					= if_empty($aPostParams, 'issue_type', 'all');
		$aPostParams['duplicationUse']				= if_empty($aPostParams, 'duplicationUse', '0');
		$aPostParams['limitGoodsPrice']				= if_empty($aPostParams, 'limitGoodsPrice', '0');
		if($aPostParams['saleType']=='percent'){
			$aPostParams['percentGoodsSale']			= $aPostParams['percentGoodsSale'];
			$aPostParams['maxPercentGoodsSale']		= $aPostParams['maxPercentGoodsSale'];
			$aPostParams['wonGoodsSale']				= '0';
		}elseif($aPostParams['saleType']=='won'){
			$aPostParams['percentGoodsSale']			= '0';
			$aPostParams['maxPercentGoodsSale']		= '0';
			$aPostParams['wonGoodsSale']				= $aPostParams['wonGoodsSale'];
		}
		if(!$aPostParams['issueDate'][0])	$aPostParams['issueDate'][0]	= date('Y-m-d');
		if(!$aPostParams['issueDate'][1])	$aPostParams['issueDate'][1]	= date('Y-m-d');


		if	($mode == 'regist'){
			$retParam['referersale_name']		= $aPostParams['refererName'];
			$retParam['referersale_desc']		= $aPostParams['refererDesc'];
			$retParam['referersale_url']		= $aPostParams['refererUrl'];
			$retParam['url_type']				= ($aPostParams['refererUrlType']) ? $aPostParams['refererUrlType'] : 'equal';
		}

		if(is_array($aPostParams['salescost_provider_list'])){
			$aPostParams['provider_seq_list'] = "|".implode("|",$aPostParams['salescost_provider_list'])."|";
		}else{
			$aPostParams['provider_seq_list'] = "";
		}

		$retParam['sale_type']				= $aPostParams['saleType'];
		$retParam['percent_goods_sale']		= $aPostParams['percentGoodsSale'];
		$retParam['max_percent_goods_sale']	= get_cutting_price($aPostParams['maxPercentGoodsSale']);
		$retParam['won_goods_sale']			= get_cutting_price($aPostParams['wonGoodsSale']);
		$retParam['issue_type']				= $aPostParams['issue_type'];
		$retParam['duplication_use']		= $aPostParams['duplicationUse'];
		$retParam['issue_goods_type']		= $aPostParams['issue_type'];
		$retParam['issue_category_type']	= $aPostParams['issue_type'];
		$retParam['issue_startdate']		= $aPostParams['issueDate'][0];
		$retParam['issue_enddate']			= $aPostParams['issueDate'][1];
		$retParam['limit_goods_price']		= get_cutting_price($aPostParams['limitGoodsPrice']);
		$retParam['salescost_admin']		= $aPostParams['salescost_admin'];
		$retParam['salescost_provider']		= $aPostParams['salescost_provider'];
		$retParam['provider_list']			= $aPostParams['provider_seq_list'];
		$retParam['update_date']			= date('Y-m-d H:i:s');

		return $retParam;
	}

	// 유입경로 할인 등록
	public function regist(){

		$params					= $this->_check_param();
		$params['regist_date']	= date('Y-m-d H:i:s');
		$this->db->insert('fm_referersale', $params);
		$refererSaleSeq 	= $this->db->insert_id();

		$sales_tag			= $this->input->post('sales_tag');
		$provider_list		= $this->input->post('salescost_provider_list');
		$issueGoods 		= $this->input->post('issueGoods');
		$issueCategoryCode 	= $this->input->post('issueCategoryCode');
		
		if(isset($issueGoods)){
			foreach($issueGoods as $goodsSeq){
				// 본사 또는 선택한 입점사의 상품만 저장.
				$query		= $this->db->select('provider_seq')->get_where('fm_goods',array('goods_seq'=>$goodsSeq));
				$goodsData	= $query->row_array();
				if(!serviceLimit('H_AD') || $sales_tag == "all" || ($sales_tag == 'admin' && $goodsData['provider_seq'] == 1) || 
						($sales_tag == 'provider' && in_array($goodsData['provider_seq'],$provider_list)))
				{
					$paramIssuegoods['referersale_seq']		= $refererSaleSeq;
					$paramIssuegoods['goods_seq']			= $goodsSeq;
					$paramIssuegoods['type']				= $params['issue_type'];
					$this->db->insert('fm_referersale_issuegoods', $paramIssuegoods);
				}
			}
		}
		if(isset($issueCategoryCode)){
			foreach($issueCategoryCode as $categoryCode){
				$paramIssuecategory['referersale_seq']	= $refererSaleSeq;
				$paramIssuecategory['category_code']	= $categoryCode;
				$paramIssuecategory['type']				= $params['issue_type'];
				$this->db->insert('fm_referersale_issuecategory', $paramIssuecategory);
			}
		}

		$callback = "parent.document.location.href='/admin/referer/referersale?no=".$refererSaleSeq."&mode=new';";
		openDialogAlert("저장 되었습니다.",400,140,'parent',$callback);
	}

	// 유입경로 할인 수정
	public function modify(){

		$params				= $this->_check_param('modify');
		$refererSaleSeq		= $this->input->post('referersaleSeq');
		$sales_tag			= $this->input->post('sales_tag');
		$provider_list		= $this->input->post('salescost_provider_list');
		$issueGoods 		= $this->input->post('issueGoods');
		$issueCategoryCode 	= $this->input->post('issueCategoryCode');

		$this->db->where('referersale_seq', $refererSaleSeq);
		$this->db->update('fm_referersale', $params);

		$this->db->delete('fm_referersale_issuecategory', array('referersale_seq' => $refererSaleSeq));
		$this->db->delete('fm_referersale_issuegoods', array('referersale_seq' => $refererSaleSeq));

		if(isset($issueGoods)){
			foreach($issueGoods as $goodsSeq){
				// 본사 또는 선택한 입점사의 상품만 저장.
				$query		= $this->db->select('provider_seq')->get_where('fm_goods',array('goods_seq'=>$goodsSeq));
				$goodsData	= $query->row_array();
				if(!serviceLimit('H_AD') || $sales_tag == "all" || ($sales_tag == 'admin' && $goodsData['provider_seq'] == 1) || 
						($sales_tag == 'provider' && in_array($goodsData['provider_seq'],$provider_list)))
				{
					$paramIssuegoods['referersale_seq']		= $refererSaleSeq;
					$paramIssuegoods['goods_seq']			= $goodsSeq;
					$paramIssuegoods['type']				= $params['issue_type'];
					$this->db->insert('fm_referersale_issuegoods', $paramIssuegoods);
				}
			}
		}
		if(isset($issueCategoryCode)){
			foreach($issueCategoryCode as $categoryCode){
				$paramIssuecategory['referersale_seq']	= $refererSaleSeq;
				$paramIssuecategory['category_code']	= $categoryCode;
				$paramIssuecategory['type']				= $params['issue_type'];
				$this->db->insert('fm_referersale_issuecategory', $paramIssuecategory);
			}
		}

		$callback = "parent.document.location.reload();";
		openDialogAlert("저장 되었습니다.",400,140,'parent',$callback);
	}

	public function delete_referer(){
		$no = $this->input->get('no');
		if	($no){
			$this->db->delete('fm_referersale', array('referersale_seq' => $no));
			$this->db->delete('fm_referersale_issuecategory', array('referersale_seq' => $no));
			$this->db->delete('fm_referersale_issuegoods', array('referersale_seq' => $no));

			$callback = "parent.document.location.reload();";
			openDialogAlert("삭제 되었습니다.",400,140,'parent',$callback);
		}
	}

	// 유입경로할인 관리자 테스트 @nsg 2015-10-16
	public function test_referer(){
		$add = $this->input->get('add');
		if($add){
			$this->load->model('visitorlog');
			$this->visitorlog->save_referer_log("http://".$add);
		}
	}
}

/* End of file coupon_process.php */
/* Location: ./app/controllers/admin/category.php */
