<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

use App\libraries\Password;

class provider_process extends admin_base {

	public function __construct() {
		parent::__construct();
		$this->load->library('validation');
	}

	public function provider_reg(){

		$aPostParams = $this->input->post();

		/* 관리자 권한 체크 : 시작 */
		$this->load->model('authmodel');
		$auth = $this->authmodel->manager_limit_act('provider_act');
		if(!$auth){
			$callback = "";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}
		/* 관리자 권한 체크 : 끝 */


		$this->load->model('multishopmodel');
		$result = $this->multishopmodel->getAdminEnv('');
		foreach($result as $data_multi){
			$this->multishopmodel->multiShopDBConnection($data_multi['shopSno']);
		}

		// 확인코드 유효성 및 중복확인
		if	(count($aPostParams['certify_code']) > 0){
			$this->load->model('providermodel');
			foreach($aPostParams['certify_code'] as $k => $certify_code){
				if(!$aPostParams['manager_name'][$k] || !$certify_code) continue;

				$certify_code	= trim($certify_code);
				if	(!$this->providermodel->check_certify_code($certify_code)){
					$callback = "";
					openDialogAlert("잘못된 확인코드가 있습니다.",400,140,'parent',$callback);
					exit;
				}

				//입력된 확인코드 체크
				if ( $certify_code_arry && in_array(trim($certify_code) ,$certify_code_arry) ) {
					$callback = "";
					openDialogAlert("중복된 확인코드가 있습니다.",400,140,'parent',$callback);
					exit;
				}
				$certify_code_arry[] = $certify_code;

				// 중복확인
				$param['certify_code']	= $certify_code;
				$certify				= $this->providermodel->get_certify_manager($param);
				if	($certify ) {
					$callback = "";
					openDialogAlert("중복된 확인코드가 있습니다.",400,140,'parent',$callback);
					exit;
				}
				unset($param);
			}//endforeach
		}//endif

		$params = $this->provider_check('regist');
		if($aPostParams['hp_chk']!='Y') $params['auth_hp'] = "";

		if	($params['main_visual']){
			$this->load->model('providermodel');
			$params['main_visual']	= $this->providermodel->upload_minishop_image($params['provider_id'], $params['main_visual']);
		}

		/* 입점사 등급 로그 */
		$grplist		= $this->providermodel->provider_group_name();
		$provider_log	= "<div>[수동] ".date("Y-m-d H:i:s")." 신규 -> ".$grplist[$params['pgroup_seq']]."(".$params['pgroup_seq'].")"." (".$this->managerInfo['manager_id'].", ".$_SERVER['REMOTE_ADDR'].")</div>";
		/* 입점사 등급 로그 */

		$data = filter_keys($params, $this->db->list_fields('fm_provider'));
		$data['pgroup_date']	= date("Y-m-d H:i:s");
		$data['regdate']		= date("Y-m-d H:i:s");
		$data['provider_log']	= $provider_log;
		$data['manager_yn']		= 'Y';
		$data['minishop_search_filter']	= '';

		// [반응형스킨] 미니샵 정보 추가 :: 2018-11-01 pjw
		$data['minishop_introdution']	= '미니샵에 오신 것을 환영합니다. 많이 이용해 주세요~'; // 기본값 지정 :: 2019-02-07 lwh
		if( $aPostParams['minishop_goods_info_image'] ) $data['minishop_goods_info_image']	= $aPostParams['minishop_goods_info_image'];
		if(!empty($aPostParams['minishop_search_filter']))	$data['minishop_search_filter'] = implode(',', $aPostParams['minishop_search_filter']);
		if(!empty($aPostParams['minishop_orderby']))			$data['minishop_orderby']		= $aPostParams['minishop_orderby'];
		if(!empty($aPostParams['minishop_status']))			$data['minishop_status']		= implode(',', $aPostParams['minishop_status']);

		// 추천상품 조건 추가 :: 2018-12-14 pjw
		$data['auto_criteria']			= $aPostParams['auto_criteria'];
		$data['auto_criteria_type']		= $aPostParams['auto_criteria_type'];
		$data['auto_contents']			= $aPostParams['auto_contents'];
		$data['auto_mobile_contents']	= $aPostParams['auto_mobile_contents'];

		$this->multishopmodel->start_auto_sync('provider_auth');

		$result = $this->db->insert('fm_provider', $data);
		$provider_seq = $this->db->insert_id();
		
		//주문 다운로드 기본 항목 제공
		$this->load->model('excelmodel');

		$name = array('주문별한줄', '상품별한줄');
		foreach(array('ORDER' ,'ITEM') as $key => $values){
			unset($itemList);
			$this->excelmodel->setting_type = $values;
			$this->excelmodel->set_cell();
			foreach($this->excelmodel->all_cells as $data){
				$itemList[$data[1]] = $data[0];
			}

			unset($excel);
			$excel['name'] = $name[$key];
			$excel['item'] = implode("|",array_keys($itemList));
			$excel['gb'] = 'ORDER';
			$excel['criteria'] = $values;
			$excel['provider_seq'] = $provider_seq;
			$excel['regdate'] = date("Y-m-d H:i:s");
			$excel['update_date'] = date("Y-m-d H:i:s");

			$result = $this->db->insert('fm_exceldownload', $excel);
		}
		
		// 추천상품 타입이 직접 선정인경우
		if($data['auto_criteria_type'] == 'MANUAL'){
			// 선정한 상품 데이터가 있을 경우
			if( $aPostParams['displayGoods']!= null && count($aPostParams['displayGoods']) > 0){

				// 직접선정 추천상품 저장
				foreach($aPostParams['displayGoods'] as $tmp_goods_seq){
					$result	= $this->db->insert('fm_provider_relation', array('provider_seq'=>$provider_seq,'relation_goods_seq'=>$tmp_goods_seq));
				}

			}
		}

		// 정산주기 자동등록 :: 2018-08-23 lkh
		$this->load->model('accountallmodel');
		$this->accountallmodel->insert_account_provider_period($provider_seq,1,"0000:00:00 00:00:00");

		### BRAND
		$oparams['provider_seq']	= $provider_seq;
		$oparams['link']			= 1;
		$oparams['charge']			= $params['charge'];
		$oparams['commission_type']	= $params['commission_type'];
		$result = $this->db->insert('fm_provider_charge', $oparams);


		### PERSON
		$person = array('ds1', 'ds2', 'cs', 'calcu', 'md', 'wcalcu');
		foreach($person as $k){
			$gb	= $k=="calcu" ? "calcus" : $k;
			if($params[$gb."_name"]){
				unset($eparams);
				$eparams['provider_seq'] = $provider_seq;
				$eparams['gb']		= $k;
				$eparams['name']	= $params[$gb."_name"];
				$eparams['email']	= $params[$gb."_email"];
				$eparams['phone']	= $params[$gb."_phone"];
				$eparams['mobile']	= $params[$gb."_mobile"];
				$result = $this->db->insert('fm_provider_person', $eparams);
			}
		}

		// 확인코드 저장
		if	(count($aPostParams['certify_code']) > 0){
			$this->load->model('providermodel');
			foreach($aPostParams['certify_code'] as $k => $certify_code){
				if(!$aPostParams['manager_name'][$k] || !$certify_code) continue;

				$cparams['provider_seq']	= $provider_seq;
				$cparams['manager_id']		= $aPostParams['provider_id'];
				$cparams['manager_name']	= $aPostParams['manager_name'][$k];
				$cparams['certify_code']	= trim($certify_code);

				$this->providermodel->insert_certify($cparams);
				unset($cparams);
			}
		}

		$this->multishopmodel->run_auto_sync('provider_auth',array('fm_config'));

		## 관리자 메뉴 상단 처리 건수 표기
		if($aPostParams['noti_count_priod_order']){
			$this->load->model('providercode');
			$noti_codes = array('noti_count_priod_order','noti_count_priod_board','noti_count_priod_account');
			$data_auth	= array();
			$wheres['shopSno']			= $this->config_system['shopSno'];
			$wheres['provider_seq']	= $provider_seq;
			$wheres['codecd like'] = '%_priod_%';
			$orderbys['idx'] 					= 'asc';
			$where_ins['codecd'] = $noti_codes;
			$this->providercode->del($wheres,$where_ins);
			$data_auth	= $this->providercode->select('max(idx) as midx',$wheres,$orderbys)->row_array();
			$idx = $data_auth['midx'];
			foreach( $noti_codes as $value){
				if($aPostParams[$value]){
					$idx++;
					$insert_params['idx']					= $idx;
					$insert_params['shopSno']		= $this->config_system['shopSno'];
					$insert_params['provider_seq']	=$provider_seq;
					$insert_params['codecd']			= $value;
					$insert_params['value']				= $aPostParams[$value];
					$this->providercode->insert($insert_params);
				}
			}
		}

		// 배송그룹 기본값 등록
		$this->load->model('shippingmodel');
		$this->shippingmodel->set_base_shipping_group($provider_seq);
		$this->shippingmodel->set_base_shipping_group($provider_seq,'coupon');
		$this->shippingmodel->set_base_shipping_group($provider_seq,'o2o');		// O2O배송그룹 추가

        //관리자 로그 남기기
        $this->load->library('managerlog');
        $inData['params'] = array(
            'provider_name' => $data['provider_name'],
			'provider_id'	=> $data['provider_id'],
        );
        $this->managerlog->insertData($inData);

		if($result){
			$callback = "parent.document.location = '/admin/provider';";
			openDialogAlert("등록 되었습니다.",400,140,'parent',$callback);
		}
	}

	public function provider_modify(){

		$aPostParams = $this->input->post();

		/* 관리자 권한 체크 : 시작 */
		$this->load->model('authmodel');
		$auth = $this->authmodel->manager_limit_act('provider_act');
		if(!$auth){
			$callback = "";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}
		/* 관리자 권한 체크 : 끝 */

		// 관리자 아이디/비밀번호 xss_clean : input->post() 는 이미 변환이 되어 original POST GET 이용해야함
		$this->load->helper('Security');
		$this->load->helper('xssfilter');
		xss_clean_basic($_POST['provider_passwd']); 

		$this->load->model('multishopmodel');
		$result = $this->multishopmodel->getAdminEnv('');
		foreach($result as $data_multi){
			$this->multishopmodel->multiShopDBConnection($data_multi['shopSno']);
		}


		$this->load->model('providermodel');
		$this->load->model('providershipping');
		$params			= $this->provider_check('modify');

		if($aPostParams['hp_chk']!='Y'){
			$params['auth_hp'] = "";
		}else{
			if(trim($params['auth_hp']) == ''){
				openDialogAlert("인증 휴대폰 번호를 입력하여 주세요.",400,140,'parent','');
				exit;
			}
		}
		$provider_seq				= $params['provider_seq'];
		$this->data_provider_info	= $this->providermodel->get_provider($provider_seq);

		// 확인코드 유효성 및 중복확인
		if	(count($aPostParams['certify_code']) > 0){
			//$this->load->model('providermodel');
			foreach($aPostParams['certify_code'] as $k => $certify_code){
				if(!$aPostParams['manager_name'][$k] || !$certify_code) continue;

				$certify_code	= trim($certify_code);
				if	(!$this->providermodel->check_certify_code($certify_code)){
					$callback = "";
					openDialogAlert("잘못된 확인코드가 있습니다.",400,140,'parent',$callback);
					exit;
				}

				//입력된 확인코드 체크
				if ( $certify_code_arry && in_array(trim($certify_code) ,$certify_code_arry) ) {
					$callback = "";
					openDialogAlert("중복된 확인코드가 있습니다.",400,140,'parent',$callback);
					exit;
				}
				$certify_code_arry[] = $certify_code;

				// 중복확인
				$param['certify_code']		= $certify_code;
				$param['not_manager_id']	= $this->data_provider_info['provider_id'];//본인꺼는 제외
				$certify				= $this->providermodel->get_certify_manager($param);
				if	($certify ) {
					$callback = "";
					openDialogAlert("중복된 확인코드가 있습니다.",400,140,'parent',$callback);
					exit;
				}
				unset($param);
			}//endforeach
		}//endif

		## add minishop visual image
		if	($params['main_visual']){
			$params['main_visual']	= $this->providermodel->upload_minishop_image($this->data_provider_info['provider_id'], $params['main_visual'], $params['org_main_visual']);
		}else{
			if	($params['del_main_visual'] == 'y'){
				$this->providermodel->delete_minishop_image($params['org_main_visual']);
				$params['org_main_visual']	= '';
			}
			$params['main_visual']	= $params['org_main_visual'];
		}

		## add update date
		if	($this->data_provider_info['provider_status'] != $params['provider_status']){
			$params['update_date']	= date('Y-m-d H:i:s');

			// 미승인 처리시 판매중인 상품 상태 변경 미승인,판매중지,미노출 처리
			if($params['provider_status'] == 0){
				$this->load->model('goodsmodel');
				$provider_status = 0;
				$goods_status = 'unsold';
				$goods_view = 'notLook';
				$this->goodsmodel->change_all_provider_status($provider_seq,$provider_status,$goods_status,$goods_view);
			}

		}

		$data = filter_keys($params, $this->db->list_fields('fm_provider'));

		/* 수정내역 추출 */
		$grplist = $this->providermodel->provider_group_name();

		$query = $this->db->query("SHOW FULL COLUMNS FROM fm_provider");
		$columns_result = $query->result_array();
		$columns = array();
		foreach($columns_result as $v) $columns[$v['Field']] = $v['Comment'];

		$provider_log = "";
		foreach($data as $key=>$value){
			if($this->data_provider_info[$key]!=$value && $columns[$key] && !in_array($key,array('admin_memo','selleradmin_memo'))){
				if($key == "pgroup_seq"){
					$data['pgroup_date'] = date("Y-m-d H:i:s",mktime());
					$value1 = $this->data_provider_info[$key] ? $grplist[$this->data_provider_info[$key]]."(".$this->data_provider_info[$key].")" : '없음';
					$value2 = $value ? $grplist[$value]."(".$value.")" : '없음';
				}else{
					$value1 = $this->data_provider_info[$key] ? $this->data_provider_info[$key] : '없음';
					$value2 = $value ? $value : '없음';
				}
				$provider_log .= "<div>[수동] ".date("Y-m-d H:i:s")." ".$value1." -> ".$value2." (".$this->managerInfo['manager_id'].", ".$_SERVER['REMOTE_ADDR'].")</div>";
			}
		}
		$provider_log = $this->data_provider_info['provider_log'];
		$data['provider_log'] = $provider_log;

		## providerPassword update date add 2017/10/27
		if ($data['provider_passwd'] != ''){
			$data['passwordUpdateTime'] = date('Y-m-d H:i:s');
		}

		// [반응형스킨] 미니샵 정보 추가 :: 2018-11-01 pjw
		$data['minishop_introdution']		= $aPostParams['minishop_introdution'];
		$data['minishop_search_filter']	= '';
		if( $aPostParams['minishop_goods_info_image'] ) $data['minishop_goods_info_image']	= $aPostParams['minishop_goods_info_image'];
		if(!empty($aPostParams['minishop_search_filter']))	$data['minishop_search_filter'] = implode(',', $aPostParams['minishop_search_filter']);
		if(!empty($aPostParams['minishop_orderby']))		$data['minishop_orderby']		= $aPostParams['minishop_orderby'];
		if(!empty($aPostParams['minishop_status']))			$data['minishop_status']		= implode(',', $aPostParams['minishop_status']);

		// 추천상품 조건 추가 :: 2018-12-14 pjw
		$data['auto_criteria']			= $aPostParams['auto_criteria'];
		$data['auto_criteria_type']		= $aPostParams['auto_criteria_type'];
		$data['auto_contents']			= $aPostParams['auto_contents'];
		$data['auto_mobile_contents']	= $aPostParams['auto_mobile_contents'];

		// 추천상품 타입이 직접 선정인경우
		if($data['auto_criteria_type'] == 'MANUAL'){
			// 기존 상품 데이터 삭제
			$this->db->delete('fm_provider_relation', array('provider_seq'=>$params['provider_seq']));

			// 선정한 상품 데이터가 있을 경우
			if( $aPostParams['displayGoods']!= null && count($aPostParams['displayGoods']) > 0){

				// 직접선정 추천상품 저장
				foreach($aPostParams['displayGoods'] as $tmp_goods_seq){
					$result	= $this->db->insert('fm_provider_relation', array('provider_seq'=>$params['provider_seq'],'relation_goods_seq'=>$tmp_goods_seq));
				}

			}
		}

		/* 수정내용 로그 */
		$this->multishopmodel->start_auto_sync('provider_auth');
		$result = $this->db->update('fm_provider', $data, array('provider_seq'=>$params['provider_seq']));
		// 입점사의 상태값 변경시 입점사 부운영자의 상태값도 동일하게 수정 2021.07.27
		$this->db->update('fm_provider', array('provider_status'=>$data['provider_status']), array('provider_group'=>$params['provider_seq']));
		
		### BRAND
		$this->db->delete('fm_provider_charge', array('provider_seq' => $params['provider_seq']));
		$oparams['provider_seq']	= $params['provider_seq'];
		$oparams['link']			= 1;
		$oparams['charge']			= round(pfloor($params['charge'] * 100) / 100,2);
		$oparams['commission_type']	= $params['commission_type'];
		$result = $this->db->insert('fm_provider_charge', $oparams);
		unset($oparams);
		$oparams['provider_seq']	= $params['provider_seq'];
		$oparams['link']			= 0;
		$cnt = 0;
		foreach($params['brand_ch'] as $k){
			$temp_arr = explode("|",$k);
			$oparams['category_code']	= $temp_arr[0];
			$oparams['title']			= $temp_arr[1];
			$oparams['charge']			= $params['brand_per'][$cnt];
			$result = $this->db->insert('fm_provider_charge', $oparams);
			$cnt++;
		}


		### PERSON
		$this->db->delete('fm_provider_person', array('provider_seq' => $params['provider_seq']));
		$person = array('ds1', 'ds2', 'cs', 'calcu', 'md', 'wcalcu');
		foreach($person as $k){
			$gb	= $k=="calcu" ? "calcus" : $k;
			// name 없어도 저장되도록 개선 2020-05-06
			unset($eparams);
			$eparams['provider_seq'] = $params['provider_seq'];
			$eparams['gb']		= $k;
			$eparams['name']	= $params[$gb."_name"];
			$eparams['email']	= $params[$gb."_email"];
			$eparams['phone']	= $params[$gb."_phone"];
			$eparams['mobile']	= $params[$gb."_mobile"];
			$result = $this->db->insert('fm_provider_person', $eparams);
		}

		// 확인코드 저장
		if	(count($aPostParams['certify_code']) > 0){
			$this->load->model('providermodel');
			$this->providermodel->delete_certify(array('provider_seq' => $params['provider_seq']));
			foreach($aPostParams['certify_code'] as $k => $certify_code){
				if(!$aPostParams['manager_name'][$k] || !$certify_code) continue;
				$cparams['provider_seq']	= $params['provider_seq'];
				$cparams['manager_id']		= $this->data_provider_info['provider_id'];
				$cparams['manager_name']	= $aPostParams['manager_name'][$k];
				$cparams['certify_code']	= trim($certify_code);
				$this->providermodel->insert_certify($cparams);
				unset($cparams);
			}
		}

		$this->multishopmodel->run_auto_sync('provider_auth',array('fm_config'));

		## 메뉴 상단 처리 건수 표기
		if($aPostParams['noti_count_priod_order']){
			$this->load->model('providercode');
			$noti_codes = array('noti_count_priod_order','noti_count_priod_board','noti_count_priod_account');
			$data_auth	= array();
			$wheres['shopSno']			= $this->config_system['shopSno'];
			$wheres['provider_seq']	= $provider_seq;
			$wheres['codecd like'] = '%_priod_%';
			$orderbys['idx'] 					= 'asc';
			$where_ins['codecd'] = $noti_codes;
			$this->providercode->del($wheres,$where_ins);
			$data_auth	= $this->providercode->select('max(idx) as midx',$wheres,$orderbys)->row_array();
			$idx = $data_auth['midx'];
			foreach( $noti_codes as $value){
				if($aPostParams[$value]){
					$idx++;
					$insert_params['idx']					= $idx;
					$insert_params['shopSno']		= $this->config_system['shopSno'];
					$insert_params['provider_seq']	=$provider_seq;
					$insert_params['codecd']			= $value;
					$insert_params['value']				= $aPostParams[$value];
					$this->providercode->insert($insert_params);
				}
			}
        }

        //관리자 로그 남기기
        $this->load->library('managerlog');
        $inData['params'] = array(
            'provider_name' => $data['provider_name']
        );
        $this->managerlog->insertData($inData);

		if($result){
			$callback = "parent.document.location.reload();";
			openDialogAlert("수정 되었습니다.",400,140,'parent',$callback);
		}
	}

	public function provider_check($type){

		$aPostParams = $this->input->post();

		if($this->config_system['service']['code']=='P_ADVL'){
			$aPostParams['calcu_count'] = 1;
			$limit = $this->usedmodel->get_provider_limit();
			$sql = "select count(*) as cnt from fm_provider where provider_id!='base' and provider_status='Y' and provider_seq!=?";
			$query = $this->db->query($sql,$aPostParams['provider_seq']);
			$data = $query->row_array();
			if($type=='regist'){
				if($data['cnt']>=$limit){
					$callback = "";
					openDialogAlert("<font color=red>입점사는 총 {$limit}개까지 등록하실 수 있습니다. (현재{$data['cnt']}개)</font>",400,140,'parent',$callback);
					exit;
				}
			}
			if($type=='modify'){
				$this->data_provider_info	= $this->providermodel->get_provider($aPostParams['provider_seq']);
				if(
					$data['cnt']>=$limit && $aPostParams['provider_status']=='Y'
				){
					$callback = "";
					openDialogAlert("<font color=red>입점사는 총 {$limit}개까지만 활성화 가능합니다. (현재{$data['cnt']}개)</font>",400,140,'parent',$callback);
					exit;
				}
			}
		}

		if($aPostParams['provider_passwd'] != $aPostParams['re_provider_passwd']){
			$callback = "parent.document.getElementsByName('provider_passwd')[0].focus();";
			openDialogAlert("입력한 비밀번호와 확인이 올바르지 않습니다.",400,160,'parent',$callback);
			exit;
		}

		$this->validation->set_rules('provider_gb', '구분','trim|required|xss_clean');
		$this->validation->set_rules('provider_name', '입점사(업체)명','trim|max_length[20]|required|xss_clean');
		if($type=="regist"){
			// 관리자 아이디/비밀번호 xss_clean : input->post() 는 이미 변환이 되어 original POST GET 이용해야함
			$this->load->helper('Security');
			$this->load->helper('xssfilter');
			xss_clean_basic($_POST['provider_id']); 
			xss_clean_basic($_POST['provider_passwd']); 
			$this->validation->set_rules('provider_id', '입점사 ID','trim|max_length[32]|required|xss_clean');
			// 중복확인과 동일하게 체크 2020-05-28
			$provider_id 			= $this->input->post('provider_id');
			$provider_chk_result 	= $this->providermodel->provider_id_check($provider_id);
			if($provider_chk_result['return']==false){
				$callback = "if(parent.document.getElementsByName('provider_id')[0]) parent.document.getElementsByName('provider_id')[0].focus();";
				openDialogAlert($provider_chk_result['return_result'],400,140,'parent',$callback);
				exit;
			}
			$this->validation->set_rules('provider_passwd', '입점사 비밀번호','trim|min_length[8]|required|xss_clean');

		}else{
			if($aPostParams['passwd_chg']){
				// 관리자 비밀번호 xss_clean : input->post() 는 이미 변환이 되어 original POST GET 이용해야함
				$this->load->helper('Security');
				$this->load->helper('xssfilter');
				xss_clean_basic($_POST['provider_passwd']); 

				$this->validation->set_rules('provider_passwd', '입점사 비밀번호','trim|min_length[8]|max_length[20]|required|xss_clean');
				$this->validation->set_rules('manager_password', '현재 관리자 비밀번호','trim|required|max_length[32]|xss_clean');
			}
		}

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}


		if($type=="regist" || $aPostParams['passwd_chg']){
			$useChar = 0;

			// 비밀번호 유효성 체크
			if($aPostParams['provider_seq']){
				$query = "select * from fm_provider where provider_seq=?";
				$query = $this->db->query($query,array($aPostParams['provider_seq']));
				$data = $query->row_array();
				$pre_enc_password = $data['provider_passwd'];
				// 이전 비밀번호가 md5 로 만들어졌을수도 있어서  알고리즘 판별 해서 암호화 한다.
				$enc_password = (Password::isOldAlgorithm($pre_enc_password) === true) ? md5($aPostParams['provider_passwd']) : Password::encrypt($aPostParams['provider_passwd']);
			}

			$check_password = $this->input->post('provider_passwd');
			$password_params = array(
				'birthday'				=> '',
				'phone'					=> '',
				'cellphone'				=> '',
				'pre_enc_password'		=> $pre_enc_password,
				'enc_password'			=> $enc_password,
			);
			$this->load->library('memberlibrary');
			$result = $this->memberlibrary->check_password_validation($check_password, $password_params);
			if($result['code'] != '00' && $result['alert_code']){
				openDialogAlert(getAlert($result['alert_code']),400,160,'parent',$callback);
				exit;
			}
		}

		if($aPostParams['provider_passwd']){
			$aPostParams['provider_passwd']	= Password::encrypt($aPostParams['provider_passwd']);
		}else{
			unset($aPostParams['provider_passwd']);
		}
		$this->validation->set_rules('charge', '정산기준','trim|numeric|xss_clean');
		// $this->validation->set_rules('account_period_type', '정산주기','trim|required|xss_clean');
		// 정산개선 추가 :: 2018-05-03 lkh
		$this->validation->set_rules('shipping_charge', '배송비 수수료','trim|numeric|xss_clean');
		$this->validation->set_rules('return_shipping_charge', '반품배송비 수수료','trim|numeric|xss_clean');
		// 3차 환불 개선으로 추가 :: 2018-11- lkh
		$this->validation->set_rules('coupon_penalty_charge', '티켓상품 환불위약금 수수료','trim|numeric|xss_clean');

		$aPostParams['limit_use']		= if_empty($aPostParams, "limit_use", 'N');

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		if(!$aPostParams['charge']){
			openDialogAlert("정산기준을 설정하세요.",400,150,'parent',$callback);
			exit;
		}
		if($aPostParams['shipping_charge'] == ""){
			$callback = "parent.document.getElementsByName('shipping_charge')[0].focus();";
			openDialogAlert("배송비 수수료를 설정하세요.",400,150,'parent',$callback);
			exit;
		}
		if($aPostParams['return_shipping_charge'] == ""){
			$callback = "parent.document.getElementsByName('return_shipping_charge')[0].focus();";
			openDialogAlert("반품배송비 수수료를 설정하세요.",400,150,'parent',$callback);
			exit;
		}
		if($_POST['coupon_penalty_charge'] == ""){
			$callback = "parent.document.getElementsByName('coupon_penalty_charge')[0].focus();";
			openDialogAlert("티켓상품 환불위약금 수수료를 설정하세요.",400,150,'parent',$callback);
			exit;
		}


		### 관리자 비밀번호 검증
		if($aPostParams['passwd_chg']){
			$str_md5 = md5($aPostParams['manager_password']);
			$str_sha256_md5 = hash('sha256',$str_md5);
			$query = "select * from fm_manager where manager_id=? and (mpasswd=? OR mpasswd=? OR mpasswd=?)";
			$queryBinds = [
				$this->managerInfo['manager_id'], 
				$str_md5, 
				$str_sha256_md5,
				Password::encrypt($aPostParams['manager_password']),
			];
			$query = $this->db->query($query, $queryBinds);
			$data = $query->row_array();
			if(!$data){
				$callback = "";
				openDialogAlert("현재 로그인된 관리자 비밀번호가 일치하지 않습니다.",400,140,'parent',$callback);
				exit;
			}
		}

		if($aPostParams['check_delivery_code']!='Y') $aPostParams['check_delivery_code'] = ''; // 배송상품 - 출고완료 처리 조건
		if($aPostParams['check_delivery_complete']!='Y') $aPostParams['check_delivery_complete'] = ''; // 배송상품 - 배송완료 처리 권한

		// 확인코드 유효성 및 중복확인
		if	(count($aPostParams['certify_code']) > 0){
			$this->load->model('providermodel');
			foreach($aPostParams['certify_code'] as $k => $certify_code){
				if(!$aPostParams['manager_name'][$k] || !$certify_code) continue;

				$certify_code	= trim($certify_code);
				if	(!$this->providermodel->check_certify_code($certify_code)){
					$callback = "";
					openDialogAlert("잘못된 확인코드가 있습니다.",400,140,'parent',$callback);
					exit;
				}

				// 중복확인
				if	($aPostParams['certify_seq'][$k])	$param['out_seq']	= $aPostParams['certify_seq'][$k];
				$param['certify_code']	= $certify_code;
				$certify				= $this->providermodel->get_certify_manager($param);
				if	($certify){
					$callback = "";
					openDialogAlert("중복된 확인코드가 있습니다.",400,140,'parent',$callback);
					exit;
				}
				unset($param);
			}
		}

		if($aPostParams['deli_zipcode']) $aPostParams['deli_zipcode']		= implode("-",$aPostParams['deli_zipcode']);
		if($aPostParams['deli_zipcode']=='-') unset($aPostParams['deli_zipcode']);

		if($aPostParams['info_zipcode']) $aPostParams['info_zipcode']		= implode("-",$_POST['info_zipcode']);
		if($aPostParams['info_zipcode']=='-') unset($aPostParams['info_zipcode']);

		$aPostParams['info_address1_type']	= $aPostParams['info_address_type'];
		$aPostParams['info_address1']	= $aPostParams['info_address'];
		$aPostParams['info_address1_street']	= $aPostParams['info_address_street'];

		//계좌 사본
		if(preg_match("/^\/?data\/tmp/i", $aPostParams['calcu_file_hidden'])){
			if(!is_dir(ROOTPATH.'data/provider')){
				@mkdir(ROOTPATH.'data/provider');
				@chmod(ROOTPATH.'data/provider',0777);
			}
			$ext = explode("/", $aPostParams['calcu_file_hidden']);
			$ext = $ext[count($ext)-1];
			$aPostParams['calcu_file'] = $ext;
			$new_path = "data/provider/{$ext}";
			copy(ROOTPATH.$aPostParams['calcu_file_hidden'],ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
		}else{
			$aPostParams['calcu_file']		= $aPostParams['calcu_file_hidden'];
		}

		//사업자 등록증 사본
		if(preg_match("/^\/?data\/tmp/i", $aPostParams['info_file_hidden'])){
			if(!is_dir(ROOTPATH.'data/provider')){
				@mkdir(ROOTPATH.'data/provider');
				@chmod(ROOTPATH.'data/provider',0777);
			}
			$ext = explode("/", $aPostParams['info_file_hidden']);
			$ext = $ext[count($ext)-1];
			$aPostParams['info_file'] = $ext;
			$new_path = "data/provider/{$ext}";
			copy(ROOTPATH.$aPostParams['info_file_hidden'],ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
		}else{
			$aPostParams['info_file']		= $aPostParams['info_file_hidden'];
		}

		// 입점사 등록시 정산 주기 초기화 :: 2018-08-23 lkh
		if($type=='regist'){
			$aPostParams['calcu_count'] = 1;
		}

		return $aPostParams;
	}

	public function provider_chk(){
		$provider_id = $this->input->post('provider_id');
		if(!$provider_id) die();

		// model 에서 체크하도록 수정
		$this->load->model('providermodel');
		$result = $this->providermodel->provider_id_check($provider_id);echo json_encode($result);
	}

	public function bankUpload(){
		$type = $_GET['type'] ? $_GET['type'] : "bank";
		if($type=="bank"){
			$filenm = "calcu_file";
		}else{
			$filenm = "busi_file";
		}

		$this->load->library('upload');
		if (is_uploaded_file($_FILES[$filenm]['tmp_name'])) {
			$config['upload_path']		= $path = ROOTPATH."/data/provider/";
			$file_ext = end(explode('.', $_FILES[$filenm]['name']));//확장자추출
			$arrImageExtensions = array('jpg','jpeg','png','gif');
			$arrImageExtensions = array_merge($arrImageExtensions,array_map('strtoupper',$arrImageExtensions));
			$config['allowed_types'] = implode('|',$arrImageExtensions);
			$config['overwrite']			= TRUE;
			$config['file_name']			= substr(microtime(), 2, 6).'.'.$file_ext;
			$this->upload->initialize($config);

			if ($this->upload->do_upload($filenm)) {
				@chmod($config['upload_path'].$config['file_name'], 0777);
				if($type=="bank"){
					$callback = "parent.bankHidden('{$config[file_name]}');";
				}else{
					$callback = "parent.busiHidden('{$config[file_name]}');";
				}
				openDialogAlert("등록하였습니다.",400,140,'parent',$callback);
			}else{
				$callback = "";
				openDialogAlert("gif, jpg,jpeg, png 만 가능합니다.",400,140,'parent',$callback);
			}
		}else{
			$callback = "";
			openDialogAlert("등록 파일이 없습니다.",400,140,'parent',$callback);
		}
		exit;
	}

	public function upload_file(){
		$this->load->model('providermodel');
		$error		= array('status' => 0,'msg' => '업로드 실패하였습니다.','desc' => '업로드 실패');
		$folder		= "data/tmp/";
		$pid		= $_POST['provider_id'];
		$filename	= date('dHis').'_'.$pid;
		$result		= $this->providermodel->upload_minishop_tempimage($filename,$folder);
		if(!$result['status']){
			echo "[".json_encode($error)."]";
			exit;
		}
		$source		= $result['fileInfo']['full_path'];
		$target		= $result['fileInfo']['full_path'];
		$result		= array('status' => 1,'newFile' => "/".$folder.$filename,
							'ext' => $result['fileInfo']['file_ext']);
		echo "[".json_encode($result)."]";
	}

	public function iconUpload(){
		$this->load->library('upload');
		if (is_uploaded_file($_FILES['pgrade_icon']['tmp_name'])) {
			$config['upload_path']		= $path = ROOTPATH."/data/icon/provider/";
			$file_ext = end(explode('.', $_FILES['pgrade_icon']['name']));//확장자추출
			$config['allowed_types']	= 'jpg|gif|jpeg|png';
			$config['overwrite']			= TRUE;
			$config['file_name']			= substr(microtime(), 2, 6).'.'.$file_ext;
			$this->upload->initialize($config);

			if ($this->upload->do_upload('pgrade_icon')) {
				@chmod($config['upload_path'].$config['file_name'], 0777);
				$callback = "parent.iconDisplay('{$config[file_name]}');";
				openDialogAlert("등록하였습니다.",400,140,'parent',$callback);
			}else{
				$callback = "";
				openDialogAlert("gif, jpg,jpeg, png 만 가능합니다.",400,140,'parent',$callback);
			}
		}else{
			$callback = "";
			openDialogAlert("등록 파일이 없습니다.",400,140,'parent',$callback);
		}
		exit;
	}

	/* 입점사 등급 추가/수정 */
	public function provider_group_write(){

		#### AUTH
		$auth = $this->authmodel->manager_limit_act('setting_member_act');
		if(!$auth){
			$callback = "";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		### Validation
		$this->validation->set_rules('pgroup_name', '명칭','trim|required|max_length[15]|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		###
		if($_POST['pgroup_seq'] > 1 || !$_POST['pgroup_seq']){
			if($_POST['use_type'] == 1){
				$_POST['order_sum_use']		= $_POST['order_sum_use1'];
				$_POST['order_sum_price']	= str_replace(",","",$_POST['order_sum_price1']);
				$_POST['order_sum_ea']		= str_replace(",","",$_POST['order_sum_ea1']);
				$_POST['order_sum_cnt']		= str_replace(",","",$_POST['order_sum_cnt1']);
				$_POST['use_type']			= "auto1";
			}elseif($_POST['use_type'] == 2){
				$_POST['order_sum_use']		= $_POST['order_sum_use2'];
				$_POST['order_sum_price']	= str_replace(",","",$_POST['order_sum_price2']);
				$_POST['order_sum_ea']		= str_replace(",","",$_POST['order_sum_ea2']);
				$_POST['order_sum_cnt']		= str_replace(",","",$_POST['order_sum_cnt2']);
				$_POST['use_type']			= "auto2";
			}else{
				$_POST['use_type']			= "manual";
			}
		}else{
			## 기준등급 : 자동관리1
			$_POST['use_type']			= "auto1";
			$_POST['order_sum_use']		= array("price1");
			$_POST['order_sum_price']	= 0;
			$_POST['order_sum_ea']		= 0;
			$_POST['order_sum_cnt']		= 0;
		}

		//등급 아이콘
		if(preg_match("/^\/?data\/tmp/i", $_POST['pgroup_icon'])){

			// 폴더가 없을 수도 있어 생성처리
			if(!is_dir(ROOTPATH.'data/icon/provider')){
				@mkdir(ROOTPATH.'data/icon/provider');
				@chmod(ROOTPATH.'data/icon/provider',0777);
			}

			// 파일 이름 재정의
			$ext			= explode(".",$_POST['pgroup_icon']);
			$ext			= $ext[count($ext)-1];
			$pgroup_icon	= "pgroup_icon_".$_POST['pgroup_seq'].".{$ext}";
			$new_path		= "/data/icon/provider/{$pgroup_icon}";

			// 파일 이동 처리
			copy(ROOTPATH.$_POST['pgroup_icon'], ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);

			// 파일 이동 후 db 값에 갱신 하기 위해 재정의 한 파일명 넣음
			$_POST['pgroup_icon'] =$pgroup_icon;
		}

		$params = $_POST;

		if(isset($_POST['order_sum_use'])) if(is_array($_POST['order_sum_use'])) $params['order_sum_use'] = serialize($_POST['order_sum_use']);

		if($_POST['mode'] == "modify"){

			$pgroup_seq				= $_POST['pgroup_seq'];
			$data					= filter_keys($params, $this->db->list_fields('fm_provider_group'));

			$this->db->where('pgroup_seq', $pgroup_seq);
			$result					= $this->db->update('fm_provider_group', $data);

		}else{

			$params['regist_date']	= date('Y-m-d H:i:s');
			$data					= filter_keys($params, $this->db->list_fields('fm_provider_group'));
			$result					= $this->db->insert('fm_provider_group', $data);
			$pgroup_seq				= $this->db->insert_id();

		}

		###
		if($result){
			$callback = "parent.document.location.href='/admin/provider/provider_group_reg?pgroup_seq=".$pgroup_seq."'" ;
			openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
		}
	}

	/* 입점사 등급 삭제/갱신설정 */
	public function provider_group_modify(){

		#### AUTH
		$auth = $this->authmodel->manager_limit_act('joincheck_view');
		if(!$auth){
			$callback = "";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		if($_GET['pgrade_mode'] == "manual_group_update"){ $_POST['pgrade_mode'] = $_GET['pgrade_mode']; }

		$this->load->model('providermodel');
		if($_POST['pgrade_mode']=='deleteGrade'){

			$delCnt = 0;
			foreach($_POST['pgroup_seq'] as $pgroup_seq){
				$provider_cnt	= $this->providermodel->find_group_provider_cnt($pgroup_seq);
				if(!$provider_cnt){
					$result	= $this->db->delete('fm_provider_group', array('pgroup_seq' => $pgroup_seq));
					$delCnt++;
				}
			}

			if($delCnt > 0){
				$callback = "parent.document.location.reload();";
				openDialogAlert("삭제되었습니다.",400,140,'parent',$callback);
			}else{
				$callback = "";
				openDialogAlert("입점사가 지정된 등급이 있어 삭제 실패 하였습니다.",400,140,'parent',$callback);
			}
		}elseif($_POST['pgrade_mode']=='autoGradeUpdate'){

			config_save('provider_grade_clone',array('start_month'=>$_POST['start_month']));
			config_save('provider_grade_clone',array('chg_term'	=>$_POST['chg_term']));
			config_save('provider_grade_clone',array('chg_day'	=>$_POST['chg_day']));
			config_save('provider_grade_clone',array('chk_term'	=>$_POST['chk_term']));
			config_save('provider_grade_clone',array('keep_term'=>$_POST['keep_term']));
			$callback = "parent.document.location.reload();";
			openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);

		}elseif($_POST['pgrade_mode'] == "manual_group_update"){

			## 등급갱신(수동) -> 다음 등급조정일 기준 적용
			$result	= $this->providermodel->provider_group_update("upt");
		}

	}

	function default_stock_check()
	{
		$this->load->model('providermodel');

		$provider_seq = 1;

		$params['default_export_stock_check'] = $_POST['default_export_stock_check'];
		$params['default_export_stock_step'] = $_POST['default_export_stock_step'];
		$params['default_export_ticket_stock_check'] = $_POST['default_export_ticket_stock_check'];
		$params['default_export_ticket_stock_step'] = $_POST['default_export_ticket_stock_step'];
		$params['provider_seq'] = $provider_seq;

		$this->providermodel->set_default_stock_check($params);

		$callback = "parent.document.location.reload();";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}

}
