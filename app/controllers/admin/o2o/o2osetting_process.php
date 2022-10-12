<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class o2osetting_process extends admin_base {

	public function __construct() {
		parent::__construct();

		$this->load->model('authmodel');
		$auth = $this->authmodel->manager_limit_act('o2osetting_act');
		if(!$auth){
			pageBack("권한이 없습니다.");
			exit;
		}

		$this->load->library('validation');
		$this->load->library('o2o/o2oservicelibrary');
		$this->load->model('shippingmodel');
	}

	public function saveActive(){

		//=================================================
		// parameter init
		//=================================================
		$arr_param_list = array(
			'o2o_use',
		);
		foreach($arr_param_list as $reciveParamName){
			// 가변 변수에 데이터 할당
			${$reciveParamName} = $this->input->post($reciveParamName);
		}

		//=================================================
		// Form validation start
		//=================================================
		// form 체크 조건 추가
		$this->validation->set_rules('o2o_use',			'사용 여부',				'required|trim|xss_clean');

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		//=================================================
		// Form validation end
		//=================================================


		//=================================================
		// data save start
		//=================================================
		// O2O 서비스 사용여부 불필요
		// $o2oConfig = $this->o2oservicelibrary->set_o2o_config_system(array('o2o_use'=>$o2o_use));
		//=================================================
		// data save end
		//=================================================


		if($o2oConfig){
			$callback = "parent.closeDialog('o2oConfigLayer');parent.location.reload();";
			openDialogAlert("처리 되었습니다.",400,140,'parent',$callback);
		}else{
			$callback = "parent.closeDialog('o2oConfigLayer');parent.location.reload();";
			openDialogAlert("처리 중 문제가 발생했습니다.",400,140,'parent',$callback);
		}
	}

	public function save()
	{
		//=================================================
		// parameter init
		//=================================================
		$arr_param_list = array(
			'o2o_store_seq'
			, 'shipping_address_seq'
			, 'address_provider_seq'
			, 'address_category'
			, 'address_category_direct'
			, 'address_name'
			, 'zoneZipcode'
			, 'address_nation'
			, 'zoneAddress_type'
			, 'zoneAddress'
			, 'zoneAddress_street'
			, 'zoneAddressDetail'
			, 'international_country'
			, 'international_town_city'
			, 'international_county'
			, 'international_address'
			, 'shipping_phone'
			, 'store_info_display_yn'
			, 'default_yn'
			, 'origin_default_yn'
			, 'store_term_week'
			, 'store_term_time'
			, 'store_term_hour1'
			, 'store_term_min1'
			, 'store_term_hour2'
			, 'store_term_min2'
			, 'store_description'
			, 'store_o2o_use_yn'
			, 'pos_code'
			, 'store_seq'
			, 'pos_seq'
			, 'del_o2o_pos_seq'
			, 'pos_key'
			, 'scm_store'
		);
		foreach($arr_param_list as $reciveParamName){
			// 가변 변수에 데이터 할당
			${$reciveParamName} = $this->input->post($reciveParamName);
		}
		if(empty($default_yn)){
			$default_yn = 'N';
		}

		//=================================================
		// Form validation start
		//=================================================
		// form 체크 조건 추가
		$this->validation->set_rules('address_category',				'분류 ',				'required|trim|xss_clean');
		if($address_category == 'direct_input'){
			$this->validation->set_rules('address_category_direct',				'분류명',				'required|trim|xss_clean|max_length[255]');
		}
		$this->validation->set_rules('address_name',				'매장명',			'required|trim|xss_clean|max_length[8]');
		$this->validation->set_rules('zoneZipcode[]',			'우편번호',				'required|trim|xss_clean|max_length[255]');
		if($address_nation == 'global'){
			$this->validation->set_rules('international_country', '국가','required|trim|xss_clean');
			$this->validation->set_rules('international_town_city', '도시','required|trim|xss_clean');
			$this->validation->set_rules('international_county', '주/도','required|trim|xss_clean');
			$this->validation->set_rules('international_address', '주소','required|trim|xss_clean');
		}else{
			$this->validation->set_rules('zoneAddress', '주소','required|trim|xss_clean');
			// (구)지번은 신주소없어서 예외처리 2020-06-30
			//$this->validation->set_rules('zoneAddress_street', '주소','required|trim|xss_clean');
			$this->validation->set_rules('zoneAddressDetail', '상세주소','required|trim|xss_clean');
		}
		// 포스 연동 사용 시
		if($store_o2o_use_yn == 'Y'){
			$this->validation->set_rules('store_seq',			'점포코드',				'required|trim|xss_clean|max_length[255]');
			$this->validation->set_rules('pos_seq[]',			'포스키',				'required|trim|xss_clean|max_length[255]');
			$this->validation->set_rules('pos_key',				'연동키',				'trim|xss_clean|max_length[255]');
			$this->validation->set_rules('scm_store',			'퍼스트몰 연결 창고',		'trim|xss_clean|max_length[255]');

			// 등록되어있던 포스키를 모두 삭제했을 경우 강제로 처리
			$cnt_pos_seq = 0;
			$cnt_del_pos_seq = 0;
			foreach($pos_seq as $row){
				if(!empty($row)) $cnt_pos_seq++;
			}
			foreach($del_o2o_pos_seq as $row){
				if(!empty($row)) $cnt_del_pos_seq++;
			}
			if(($cnt_pos_seq == $cnt_del_pos_seq && $cnt_pos_seq > 0) || $cnt_pos_seq == 0){
				$this->validation->set_rules('required_pos_seq',			'포스키',				'required|trim|xss_clean|max_length[255]');
			}
		}

		// 입력장소를 위한 세팅
		if(defined('__ADMIN__') === true){
			$provider_seq = 1;
		}else{
			$provider_seq = $this->providerInfo['provider_seq'];
		}

		// 현재 입력되어 있는 입력장소 갯수 확인
		$sc									= array();
		$sc['address_provider_seq']			= $provider_seq;
		$list = $this->shippingmodel->shipping_address_list($sc);
		$shipping_address_regist_able_yn = (($list['page']['totalcount'] > $this->shippingmodel->shipping_address_max)?'N':'Y');
		if($shipping_address_regist_able_yn == 'N' && empty($shipping_address_seq)){
			$this->validation->set_rules('required_max_cnt',			'입력 가능 최대 매장 수',				'required|trim|xss_clean');
		}

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		/*
		// POS 상태에 따른 사용 가능 여부 처리
		foreach($pos_seq as $key=>$value){
			if($use_yn[$key]=='y' && !in_array($contracts_status[$key], array('40','80'))){
				openDialogAlert(($key+1)."번째 POS의 운영상태가 [설치완료] 이후에만 사용가능합니다.",400,140,'parent',$callback);
				exit;
			}
		}
		 */
		//=================================================
		// Form validation end
		//=================================================


		// 트랜잭션 시작
		$this->db->trans_begin();
		$rollback = false;
		//=================================================
		// data save start
		//=================================================
		if($store_o2o_use_yn == 'Y' || $o2o_store_seq){
			$tmpZoneZipcode =  (is_array($zoneZipcode)) ? implode('',$zoneZipcode) : $zoneZipcode;
			unset($sqlData);
			$sqlData = array(
				'o2o_store_seq'				=> $o2o_store_seq,
				'pos_code'					=> $pos_code,
				'pos_name'					=> $address_name,
				'pos_phone'					=> $shipping_phone,
				'zoneZipcode'				=> $tmpZoneZipcode,
				'address_nation'			=> $address_nation,
				'zoneAddress_type'			=> $zoneAddress_type,
				'zoneAddress'				=> $zoneAddress,
				'zoneAddress_street'		=> $zoneAddress_street,
				'zoneAddressDetail'			=> $zoneAddressDetail,
				'international_country'		=> $international_country,
				'international_town_city'	=> $international_town_city,
				'international_county'		=> $international_county,
				'international_address'		=> $international_address,
				'store_seq'					=> $store_seq,
				'pos_key'					=> $pos_key,
				'scm_store'					=> $scm_store,
				'o2o_pos_seq'				=> $o2o_pos_seq,
				'del_o2o_pos_seq'			=> $del_o2o_pos_seq,
				'pos_seq'					=> $pos_seq,
				'contracts_status'			=> $contracts_status,
				'use_yn'					=> strtolower($store_o2o_use_yn),
			);
			$o2oConfig = $this->o2oservicelibrary->merge_o2o_config($sqlData);
			$o2o_store_seq = $o2oConfig['o2o_store_seq'];

			//=================================================
			// share to o2o server start
			//=================================================
			$o2oConfigAll = $this->o2oservicelibrary->get_o2o_config($sqlData,1,'admin');
			if($o2oConfigAll){
				foreach($o2oConfigAll['o2o_config_pos'] as $o2o_config_pos){
					// 중계 DB 호출
					unset($o2o_relay_params);
					$o2o_relay_params['pos_code']		= $o2oConfigAll['pos_code'];
					$o2o_relay_params['store_seq']		= $o2oConfigAll['store_seq'];
					$o2o_relay_params['pos_seq']		= $o2o_config_pos['pos_seq'];
					$o2o_relay_params['use_yn']			= ($o2o_config_pos['delete_yn']=='y')?'n':$o2o_config_pos['use_yn'];
					$o2o_relay_params['pos_key']		= $o2oConfigAll['pos_key'];

					unset($o2o_relay_info);
					// O2O 매장 연결 기능이 등록되어 있을 때만 중계서버에 전송
					if($o2o_relay_params['store_seq'] && $o2o_relay_params['pos_seq']){
						$o2o_relay_info = $this->o2oservicelibrary->sharePosInfo($o2o_relay_params);
					}

					if($o2o_relay_info['result']!="1"){
						$callback = "parent.closeDialog('o2oConfigLayer');parent.location.reload();";
						openDialogAlert("중계 서버 처리에 실패했습니다.",400,140,'parent',$callback);
					}
				}
			}
			//=================================================
			// share to o2o server end
			//=================================================
		}
		//=================================================
		// data save end
		//=================================================


		//=================================================
		// 입력장소 data save start
		//=================================================
		if (defined('__SELLERADMIN__') === true) {
			$provider_seq	= $this->providerInfo['provider_seq'];
		}else{
			$provider_seq	= $_POST['provider_seq'];
			if(!$provider_seq)	$provider_seq = 1;
		}
		$address_provider_seq = $provider_seq;

		// 영업시간 데이터 구성
		$arr_store_term = array();
		foreach($store_term_week as $k=>$week){
			$row_store_term = array();
			$row_store_term['store_term_week']		= $store_term_week[$k];
			$row_store_term['store_term_time']		= $store_term_time[$k];
			$row_store_term['store_term_hour1']		= $store_term_hour1[$k];
			$row_store_term['store_term_min1']		= $store_term_min1[$k];
			$row_store_term['store_term_hour2']		= $store_term_hour2[$k];
			$row_store_term['store_term_min2']		= $store_term_min2[$k];
			$arr_store_term[] = $row_store_term;
		}

		$store_term = json_encode($arr_store_term);

		unset($data_shipping_address);
		$data_shipping_address = array(
			'shipping_address_seq'			=> $shipping_address_seq
			, 'address_provider_seq'		=> $address_provider_seq
			, 'address_category'			=> $address_category
			, 'address_category_direct'		=> $address_category_direct
			, 'address_name'				=> $address_name
			, 'zoneZipcode'					=> $zoneZipcode
			, 'address_nation'				=> $address_nation
			, 'zoneAddress_type'			=> $zoneAddress_type
			, 'zoneAddress'					=> $zoneAddress
			, 'zoneAddress_street'			=> $zoneAddress_street
			, 'zoneAddressDetail'			=> $zoneAddressDetail
			, 'international_country'		=> $international_country
			, 'international_town_city'		=> $international_town_city
			, 'international_county'		=> $international_county
			, 'international_address'		=> $international_address
			, 'shipping_phone'				=> $shipping_phone
			, 'store_info_display_yn'		=> $store_info_display_yn
			, 'store_term'					=> $store_term
			, 'store_description'			=> $store_description
			, 'store_o2o_use_yn'			=> $store_o2o_use_yn
			, 'store_seq'					=> $o2o_store_seq
		);

		// 등록 / 수정 model 에서 처리
		$shipping_address_seq = $this->shippingmodel->set_shipping_address($data_shipping_address);

		// 대표매장 설정
		if($default_yn != $origin_default_yn){
			unset($data_shipping_address_default_yn);
			$data_shipping_address_default_yn = array(
				'shipping_address_seq'			=> $shipping_address_seq
				, 'address_provider_seq'		=> $address_provider_seq
				, 'default_yn'					=> $default_yn
			);
			$this->shippingmodel->set_shipping_address_default_yn($data_shipping_address_default_yn);
		}
		//=================================================
		// 입력장소 data save end
		//=================================================

		if ($this->db->trans_status() === FALSE || $rollback == true)
		{
		    $this->db->trans_rollback();
			$callback = "parent.closeDialog('o2oConfigLayer');parent.location.reload();";
			openDialogAlert("처리 중 문제가 발생했습니다.",400,160,'parent',$callback);
			exit;
		}
		else
		{
		    $this->db->trans_commit();
		}


		if($shipping_address_seq){
			$callback = "parent.closeDialog('o2oConfigLayer');parent.location.href='/admin/o2o/o2osetting?mode=o2o_regist&seq=".$shipping_address_seq."';";
			openDialogAlert("처리 되었습니다.",400,160,'parent',$callback);
		}else{
			$callback = "parent.closeDialog('o2oConfigLayer');parent.location.reload();";
			openDialogAlert("처리 중 문제가 발생했습니다.",400,160,'parent',$callback);
		}
	}

	public function delete()
	{
		//=================================================
		// Form validation start
		//=================================================
		// form 체크 조건 추가
		$this->validation->set_rules('add_chk[]',			'고유키',				'required|trim|xss_clean|max_length[255]');

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		//=================================================
		// Form validation end
		//=================================================

		//=================================================
		// parameter init
		//=================================================
		$arr_param_list = array(
			'add_chk',
		);
		foreach($arr_param_list as $reciveParamName){
			// 가변 변수에 데이터 할당
			${$reciveParamName} = $this->input->post($reciveParamName);
		}

		// 입력 장소 불러오기
		$sc									= array();
		$sc['shipping_address_seq']			= $add_chk;
		$list = $this->shippingmodel->shipping_address_list($sc);

		if(count($list['record']) != count($add_chk)){
			$callback = "parent.closeDialog('o2oDeleteInfoLayer');";
			openDialogAlert("이미 삭제된 데이터가 있습니다.<br/>새로고침 후 다시 시도해주세요.</a>",400,160,'parent',$callback);
			exit;
		}

		// 입력장소에 연결되어 있는 O2O 매장 정보 삭제
		$arrSeq = array();

		$refund_address_include = false;
		$shipping_store_include = false;

		foreach($list['record'] as $row){
			$arrSeq[] = $row['store_seq'];
			if($row['refund_address_seq'] && !$refund_address_include){
				$address['refund'] = '반송지';
				$refund_address_include = true;
			}
			if($row['shipping_store_seq'] && !$shipping_store_include){
				$address['store'] = '매장수령';
				$shipping_store_include = true;
			}
		}
		$msg = implode(', ', $address);

		// $this->db->trans_start(true);
		if($refund_address_include || $shipping_store_include){
			$callback = "parent.closeDialog('o2oDeleteInfoLayer');";
			openDialogAlert("선택한 매장은 ".$msg."(으)로 사용 중 입니다. ".$msg." 설정 변경 후 다시 삭제해주세요.</a>",400,180,'parent',$callback);
			exit;
		}

		// 트랜잭션 시작
		$this->db->trans_begin();
		$rollback = false;

		// 삭제 처리
		$deleteChkCnt = 0;
		$deleteCnt = 0;
		foreach($arrSeq as $o2o_store_seq){
			if($o2o_store_seq){
				// 삭제 처리 전 scm 연동 버전의 경우 창고를 먼저 삭제한 후 매장 정보를 삭제할 수 있음.
				if($this->scm_cfg['use']=="Y"){
					unset($sqlData);
					$sqlData = array(
						'o2o_store_seq'				=> $o2o_store_seq,
					);
					$o2oConfig = $this->o2oservicelibrary->get_o2o_config($sqlData);
					if(!empty($o2oConfig['scm_store'])){
						unset($sc);
						$sc['wh_seq']	= $o2oConfig['scm_store'];
						$warehouse = $this->scmmodel->get_warehouse($sc);
						if(!empty($warehouse) && !empty($warehouse[0]['wh_seq'])){
							$callback = "parent.closeDialog('o2oDeleteInfoLayer');";
							openDialogAlert("연결되어있는 창고를 먼저 삭제 후 다시 시도해주세요.<br/><a href=\"/admin/scm_basic/warehouse\">바로가기></a>",400,140,'parent',$callback);
							exit;
						}
					}
				}
				//=================================================
				// data save start
				//=================================================
				unset($sqlData);
				$sqlData = array(
					'o2o_store_seq'				=> $o2o_store_seq,
				);
				$o2oConfig = $this->o2oservicelibrary->del_o2o_config($sqlData);
				//=================================================
				// data save end
				//=================================================

				//=================================================
				// share to o2o server start
				//=================================================
				$o2oConfigAll = $this->o2oservicelibrary->get_o2o_config($sqlData,1,'admin');
				if($o2oConfigAll){
					$deleteChkCnt = $deleteChkCnt + count($o2oConfigAll['o2o_config_pos']);
					foreach($o2oConfigAll['o2o_config_pos'] as $o2o_config_pos){
						// 중계 DB 호출
						unset($o2o_relay_params);
						$o2o_relay_params['pos_code']		= $o2oConfigAll['pos_code'];
						$o2o_relay_params['store_seq']		= $o2oConfigAll['store_seq'];
						$o2o_relay_params['pos_seq']		= $o2o_config_pos['pos_seq'];
						$o2o_relay_params['use_yn']			= ($o2o_config_pos['delete_yn']=='y')?'n':$o2o_config_pos['use_yn'];
						$o2o_relay_params['pos_key']		= $o2o_config_pos['pos_key'];

						unset($o2o_relay_info);
						$o2o_relay_info = $this->o2oservicelibrary->sharePosInfo($o2o_relay_params);


						if($o2o_relay_info['result']!="1"){
							$callback = "parent.closeDialog('o2oDeleteInfoLayer');parent.location.reload();";
							openDialogAlert("중계 서버 처리에 실패했습니다.",400,140,'parent',$callback);
						}else{
							$deleteCnt++;
						}
					}
				}
				//=================================================
				// share to o2o server end
				//=================================================
			}
		}

		// 입력장소 정보 삭제
		$sc									= array();
		$sc['shipping_address_seq']			= $add_chk;
		$deleteShippingCnt = $this->shippingmodel->del_shipping_address($sc);

		if ($this->db->trans_status() === FALSE || $rollback == true)
		{
		    $this->db->trans_rollback();
			$callback = "parent.closeDialog('o2oDeleteInfoLayer');parent.location.reload();";
			openDialogAlert("처리 중 문제가 발생했습니다[".$deleteCnt."][".$deleteChkCnt."].",400,140,'parent',$callback);
			exit;
		}
		else
		{
		    $this->db->trans_commit();
		}

		// file cache 삭제
		cache_clean('shipping_refund_address');

		$result = (($deleteCnt==$deleteChkCnt) && (count($add_chk)==$deleteShippingCnt));
		if($result){
			$callback = "parent.closeDialog('o2oDeleteInfoLayer');parent.location.reload();";
			openDialogAlert("처리 되었습니다.",400,140,'parent',$callback);
		}else{
			$callback = "parent.closeDialog('o2oDeleteInfoLayer');parent.location.reload();";
			openDialogAlert("처리 중 문제가 발생했습니다[".$deleteCnt."][".$deleteChkCnt."].",400,140,'parent',$callback);
		}
	}

	public function get(){
		//=================================================
		// Form validation start
		//=================================================
		// form 체크 조건 추가
		$this->validation->set_rules('o2o_store_seq',	'고유키',				'required|trim|xss_clean|max_length[255]');

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$res = array('result'=>'','msg'=>'[0]대상을 선택해주세요.','data'=>null);
			echo json_encode($res);
			exit;
		}
		//=================================================
		// Form validation end
		//=================================================

		//=================================================
		// parameter init
		//=================================================
		$arr_param_list = array(
			'o2o_store_seq',
		);
		foreach($arr_param_list as $reciveParamName){
			// 가변 변수에 데이터 할당
			${$reciveParamName} = $this->input->post($reciveParamName);
		}
		//=================================================
		// data get start
		//=================================================
		unset($sqlData);
		$sqlData = array(
			'o2o_store_seq'				=> $o2o_store_seq,
		);
		$o2oConfig = $this->o2oservicelibrary->get_o2o_config($sqlData);
		$result = $o2oConfig;
		//=================================================
		// data get end
		//=================================================


		if($result){
			$res = array('result'=>'1','msg'=>'','data'=>$result);
		}else{
			$res = array('result'=>'-1','msg'=>'[1]대상이 없습니다.','data'=>null);
		}
		echo json_encode($res);
		exit;
	}

	public function generatePosKey(){
		//=================================================
		// Form validation start
		//=================================================
		// form 체크 조건 추가
		$this->validation->set_rules('o2o_store_seq',	'고유키',				'required|trim|xss_clean|max_length[255]');
		$this->validation->set_rules('agree_yn',        '동의',                 'required|trim|xss_clean');

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$res = array('result'=>'','msg'=>$err['value'],'data'=>null);
			echo json_encode($res);
			exit;
		}
		//=================================================
		// Form validation end
		//=================================================

		//=================================================
		// parameter init
		//=================================================
		$arr_param_list = array(
			'o2o_store_seq',
		);
		foreach($arr_param_list as $reciveParamName){
			// 가변 변수에 데이터 할당
			${$reciveParamName} = $this->input->post($reciveParamName);
		}

		//=================================================
		// generatePosKey start
		//=================================================
		unset($sqlData);
		$sqlData = array(
			'o2o_store_seq'				=> $o2o_store_seq,
		);
		$o2oConfig = $this->o2oservicelibrary->get_o2o_config($sqlData);

		unset($posKeyData);
		$posKeyData = array(
			'time'				=> time(),
			'auth_text'			=> $this->o2oservicelibrary->auth_text,
			'pos_code'			=> $o2oConfig['pos_code'],
			'store_seq'			=> $o2oConfig['store_seq'],
		);
		$pos_key = $this->o2oservicelibrary->generatePosKey($posKeyData);
		$result = $pos_key;
		//=================================================
		// generatePosKey end
		//=================================================


		if($result){
			$res = array('result'=>'1','msg'=>'','data'=>$result);
		}else{
			$res = array('result'=>'-1','msg'=>'[1]연동키 재발행에 실패했습니다.','data'=>null);
		}
		echo json_encode($res);
		exit;

	}
}
/* End of file setting.php */
/* Location: ./app/controllers/admin/setting.php */
