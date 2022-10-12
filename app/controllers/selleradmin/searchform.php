<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class searchform extends selleradmin_base {

	public function __construct() {
		parent::__construct();

	}

	// 메뉴별 기본 검색 폼
	public function get_default_form()
	{
		$this->admin_menu();
		$this->tempate_modules();
		
		$this->load->model('searchdefaultconfigmodel');
		$this->config->load("searchFormSet");		// app/config/searchform.php

		$pageid				= $this->input->get('pageid');
		$mode				= $this->input->get('mode');

		$get_search_form	= $this->config->item($pageid);

		$data_search_default = array();
		$data_search_default['searchEditUse']	= $get_search_form['searchEditUse'];
		$data_search_default['required']		= $get_search_form['searchRequired'];

		$data_search_default_str 				= $this->searchdefaultconfigmodel->get_search_default_config($pageid);
		//debug($data_search_default_str);
		$jsonChk								= json_decode($data_search_default_str['search_info']);
		
		// json 타입 데이터가 아닐 경우
		if($data_search_default_str['search_info'] && json_last_error() != 0){
			parse_str($data_search_default_str['search_info'],$search_info);
			$data_search_default_str['search_info'] = json_encode($search_info);
		 }

		if($mode != "default" && $data_search_default_str['search_info']){
			$data_search_default['default_field'] = $data_search_default_str['field_default'];
			$data_search_default['default_value'] = $data_search_default_str['search_info'];
		}else{
			// 기본 설정
			$data_search_default['default_field'] = ($get_search_form['searchDefault'])? json_encode($get_search_form['searchDefault']):'';
			$data_search_default['default_value'] = ($get_search_form['searchValue'])? json_encode($get_search_form['searchValue']):'';
			
		}

		// 개선된 설정값이 있을 때
		if(gettype($data_search_default['default_field']) == 'string' && $data_search_default['default_field'] != 'null'){
			$data_search_default['default_field'] = json_decode($data_search_default['default_field']);
		}elseif($data_search_default_str['search_info'] && gettype($data_search_default['default_field']) == null || $data_search_default['default_field'] == 'null'){
		// 개선전 설정값이 있을 때
			list($default_field,$default_value) = $this->searchdefaultconfigmodel->set_default_field_migration($data_search_default_str['search_info']);
			$data_search_default['default_value'] = $default_value;
			$data_search_default['default_field'] = $default_field;
		}else{$data_search_default['default_value'] = $default_value;
		// 설정값이 없을 때
		}

		// 필수 검색 필드가 누락되어 있다면 추가.
		foreach($data_search_default['required'] as $_field){
			if(!in_array($_field,$data_search_default['default_field'])){
				$data_search_default['default_field'][] = $_field;
			}
		}

		echo json_encode($data_search_default);

	}

	public function save_search_form(){

		# reset
		$callbackAppend = '';
		
		$this->load->model('searchdefaultconfigmodel');
		
		$params = $this->input->post();
		$pageid = $params['pageid'];
		if(!$pageid){
			echo json_encode(array("result"=>"fail","message"=>"저장 실패! 검색설정 주요 정보['pageid']가 누락되었습니다."));
			exit;
		}
		if(count($params['search_form_editor']) < 1){
			echo json_encode(array("result"=>"fail","message"=>"필수 검색 항목을 1개 이상 체크해 주세요."));
			exit;
		}
		/*
		if(in_array($pageid,array("order","returns","refund","export","member"))){
			$pageid = 'admin/'.$pageid.'/catalog';
			
			# [주문-통합주문리스트]인 경우만 추가
			# 2016-10-25 14:44  나중에 추가하기로 하여 주석처리함(채우형)
			#$_POST['pageid'] == 'order' && $callbackAppend = "parent.location.replace('/{$pageid}');";
		}elseif(in_array($pageid,array("order_company"))){
			$pageid = 'admin/order/company_catalog';
		}elseif(in_array($pageid,array("gift_catalog","restock_notify_catalog"))){
			$pageid = 'admin/goods/'.$pageid;
		}elseif(in_array($pageid,array("revision", "stockmove", "inven", "ledger", "scmgoods"))){
			$pageid = $pageid == 'scmgoods' ? 'goods' : $pageid;
			$pageid = 'admin/scm_manage/'.$pageid;
		}elseif(in_array($pageid,array("sorder", "warehousing", "carryingout", "autoorder", "traderaccount"))){
			$pageid = 'admin/scm_warehousing/'.$pageid;
		}elseif(in_array($pageid,array("dormancy_catalog","withdrawal"))){
			$pageid = 'admin/member/'.$pageid;
		}else{
			$pageid = 'admin/order/'.$pageid;
		}
		*/

		//debug($_POST);
		unset($params['pageid'],$params['query_string']);
		unset($params['orderby'],$params['sort']);
		unset($params['page'],$params['perpage']);
		unset($params['total_page'],$params['totalcount']);
		unset($params['searchcount'],$params['no']);
		$params['search_page']	= $pageid;
		
		$result = $this->searchdefaultconfigmodel->set_search_default_new($params);
		$result['default_field'] = $params['search_form_editor'];
		
		//debug($result);
		echo json_encode($result);

	}

}