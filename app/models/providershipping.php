<?php
class Providershipping extends CI_Model {

	function get_provider_shipping($provider_seq=1)
	{
		if(!$this->categorymodel) $this->load->model('categorymodel');
		if(!$this->brandmodel) $this->load->model('brandmodel');
		if(!$this->goodsmodel) $this->load->model('goodsmodel');
		$this->load->helper('shipping');

		# 본사배송, 입점사 배송 확인.
		$sql	= "select deli_group from fm_provider where provider_seq=?";
		$query	= $this->db->query($sql,$provider_seq);
		$temp	= $query->result_array();
		$deli_group	= $temp[0]['deli_group'];

		$sql = "select *,summary delivery_summary_msg,quick_summary quick_summary_msg,direct_summary direct_summary_msg  from fm_provider_shipping where provider_seq = ?";

		if($deli_group == "company") $provider_seq = 1;

		$query = $this->db->query($sql,$provider_seq);
		$temp = $query->result_array();
		$data = $temp[0];
		$arr = explode("|",$temp[0]['company_code']);
		$cnt = 0;
		$delivery_cnt = 0;

		unset( $data['summary'],$data['quick_summary'],$data['direct_summary'] );

		if( $data['postpaid_delivery_cost_yn'] == 'y' ){
			$data['postpaid_use_yn'] = 'y';
			$delivery_cnt += 1;
		}

		if($provider_seq){
			foreach(get_invoice_company($provider_seq) as $k=>$tmp){
				$data['deliveryCompany'][$k]		= $tmp['company'];
				$data['deliveryCompanyCode'][$cnt]	= $k;
				$cnt++;
			}
		}

		foreach($arr as $k){
			if($k)
			{
				$tmp = config_load('delivery_url',$k);
				$data['deliveryCompany'][$k]		= $tmp[$k]['company'];
				$data['deliveryCompanyCode'][$cnt]	= $k;
				$cnt++;
			}
		}

		###
		$arr2 = explode("|",$temp[0]['add_delivery_cost']);
		$cnt = 0;
		foreach($arr2 as $k){
			$tmps = explode(":", $k);
			$tmpCount = count($tmps);
			if($tmpCount == 3){
				$data['sigungu'][$cnt]			= $tmps[0];
				$data['sigungu_street'][$cnt]	= $tmps[1];
				$data['addDeliveryCost'][$cnt]	= $tmps[2];
			}else{
				$data['sigungu'][$cnt]			= $tmps[0];
				$data['addDeliveryCost'][$cnt]	= $tmps[1];
			}
			$cnt++;
		}

		if( $data['issue_brand_code'] ){
			$arr_issuebrandCode = explode("|",$data['issue_brand_code']);
			foreach($arr_issuebrandCode as $code){
				$data['data_issue_brand'][$code]['name'] = $this->brandmodel -> get_brand_name($code);
			}
		}
		if( $data['issue_category_code'] ){
			$arr_issue_category = explode("|",$data['issue_category_code']);
			foreach($arr_issue_category as $code){
				$data['data_issue_category'][$code]['name'] = $this->categorymodel -> get_category_name($code);
			}
		}

		if( $data['issue_goods'] ){
			$arr_goods = explode("|",$data['issue_goods']);
			$data['data_issue_goods'] = $this->goodsmodel->get_goods_list($arr_goods,'thumbView');

		}

		if( $data['except_issue_goods'] ){
			$arr_goods = explode("|",$data['except_issue_goods']);
			$data['data_except_goods'] = $this->goodsmodel->get_goods_list($arr_goods,'thumbView');
		}


		if($data['use_yn']=='y') {
			$delivery_cnt += 1;
			$data['shipping_method']['delivery'] = "택배(선불)";
			if( $data['delivery_cost_policy'] == 'pay' && $data['pay_delivery_cost'] > 0 ){
				$data['summary']['delivery'] = number_format($data['pay_delivery_cost'])."원";
			}else{
				$delivery_tmp = "";

				if($data['ifpay_delivery_cost'] > 0 ){
					if($data['ifpay_free_price'] > 0) $delivery_tmp .= number_format($data['ifpay_free_price'])."원 이상 무료 미만";
					$delivery_tmp .= number_format($data['ifpay_delivery_cost'])."원";
				}else{
					$delivery_tmp .= "무료배송";
				}

				$data['summary']['delivery'] = $delivery_tmp;
			}
		}

		if($data['postpaid_use_yn']=='y') {
			$data['shipping_method']['postpaid'] = '택배(착불)';

			if( $data['postpaid_delivery_cost'] )
				$postpaid_tmp = number_format($data['postpaid_delivery_cost'])."원";
			if( $data['postpaid_delivery_summary'] )
				$postpaid_tmp .= " " . $data['postpaid_delivery_summary'];

			$data['summary']['postpaid'] = $postpaid_tmp;
		}

		if($data['quick_use_yn']=='y') {
			$delivery_cnt += 1;
			$data['shipping_method']['quick'] = '퀵서비스';
			$data['summary']['quick'] = $data['quick_summary_msg'];

		}

		if($data['direct_use_yn']=='y') {
			$delivery_cnt += 1;
			$data['shipping_method']['direct'] = '직접수령';
			$data['summary']['direct'] = $data['direct_summary_msg'];
		}

		$data['delivery_cnt'] = $delivery_cnt;

		// NEW 택배사 정보 :: 2017-02-01 lwh
		if	($provider_seq > 1){
			$deliveryCompanyCode	= config_load('providerDeliveryCompanyCode', $provider_seq);
			$deliveryCompanyCode	= $deliveryCompanyCode[$provider_seq];
		}else{
			$provider_seq			= 1;
			$deliveryCompanyCode	= config_load('shippingdelivery', 'deliveryCompanyCode');
			$deliveryCompanyCode	= $deliveryCompanyCode['deliveryCompanyCode'];
		}
		if($deliveryCompanyCode){
			foreach($deliveryCompanyCode as $k => $code){
				$code_num = str_replace('code','',$code);
				if($code_num >= 90){
					$invoice_info	= get_invoice_company($provider_seq, $code);
					if(!$invoice_info) continue;
					$invoice_key	= array_keys($invoice_info);
					$deliCode[]		= $code;
					$deliName[]		= $invoice_info[$invoice_key[0]]['company'];
					$deliNameCodeMapping[$code]		= $invoice_info[$invoice_key[0]]['company'];
				}else{
					$deli_info		= config_load('delivery_url',$code);
					$deliCode[]		= $code;
					$deliName[]		= $deli_info[$code]['company'];
					$deliNameCodeMapping[$code]		= $deli_info[$code]['company'];
				}
			}
			$data['deliveryCompanyCode']	= $deliCode;
			$data['deliveryCompany']		= $deliName;
			$data['deliveryCompanyCodeMapping']		= $deliNameCodeMapping;
		}
		$data['provider_seq'] = $provider_seq;

		return $data;
	}

	function set_provider_shipping($update_params,$where_params)
	{
		$query = $this->db->get_where('fm_provider_shipping', $where_params, 1, 0);
		$row = $query->row_array();

		if(!$row['provider_seq']){
			$this->db->insert('fm_provider_shipping',$where_params);
		}
		$this->db->update('fm_provider_shipping',$update_params, $where_params);
	}

	function delete_provider_shipping($provider_seq)
	{
		$this->db->delete('fm_provider_shipping', array('provider_seq' => $provider_seq));
	}

	// 택배사 정보 가져오기
	function get_provider_courier($provider_seq=1)
	{
		/* 기존 택배사 정보 :: 2016-12-26 lwh - 삭제예정
		$query = "select company_code from fm_provider_shipping where provider_seq = ?";
		$query = $this->db->query($query,$provider_seq);
		$result_courier = $query->result_array();
		$data_courier = $result_courier[0];

		if( $provider_seq ){
			$this->load->helper('shipping');
			foreach(get_invoice_company($provider_seq) as $k=>$tmp){
				//$result['auto_'] = $tmp;
				$result[$k] = $tmp;
			}
		}

		$arr_company_code = explode('|',$data_courier['company_code']);
		foreach($arr_company_code as $data_code){
			$data = config_load('delivery_url',$data_code);
			foreach($data as $code => $val){
				$result[$code] = $val;
			}
		}
		*/

		if	($provider_seq > 1){
			$deliveryCompanyCode	= config_load('providerDeliveryCompanyCode', $provider_seq);
			$deliveryCompanyCode	= $deliveryCompanyCode[$provider_seq];
		}else{
			$deliveryCompanyCode	= config_load('shippingdelivery', 'deliveryCompanyCode');
			$deliveryCompanyCode	= $deliveryCompanyCode['deliveryCompanyCode'];
		}

		foreach($deliveryCompanyCode as $code){
			$code_num = substr($code, 4, 2);
			if($code_num > 90){
				$this->load->helper('shipping');
				foreach(get_invoice_company($provider_seq,$code) as $k=>$tmp){
					$result[$k] = $tmp;
				}
			}else{
				$data = config_load('delivery_url',$code);
				foreach($data as $code => $val){
					$result[$code] = $val;
				}
			}
		}

		return $result;
	}

	// 택배사 정보 가져오기
	function get_provider_courier_all()
	{
		$this->load->helper('shipping');
		$query = "select company_code,provider_seq from fm_provider_shipping";
		$query = $this->db->query($query);
		foreach( $query->result_array() as $data_courier){
			if( $data_courier['provider_seq'] == '1' ){
				foreach(get_invoice_company() as $k=>$tmp){
					$result[$k] = $tmp;
					$result_for_provider[$data_courier['provider_seq']][$k] = $val;
				}
			}

			$arr_company_code = explode('|',$data_courier['company_code']);
			foreach($arr_company_code as $data_code){
				$data = config_load('delivery_url',$data_code);
				foreach($data as $code => $val){
					$result[$code] = $val;
					$result_for_provider[$data_courier['provider_seq']][$code] = $val;
				}
			}
		}

		return array($result,$result_for_provider);
	}
}

