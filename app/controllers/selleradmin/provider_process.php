<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

use App\libraries\Password;

class provider_process extends selleradmin_base {

	public function __construct() {
		parent::__construct();
		$this->load->library('validation');
	}

	public function provider_modify(){

		$params = $this->provider_check('modify');

		// 입점사 권한 체크
		if( $this->providerInfo['provider_seq'] !=  $params['provider_seq']){
			alert('올바른 접속이 아닙니다.');
			exit;
		}

		$params['limit_use']		= 'N';

		$this->load->library('managerlibrary');
		$this->managerlibrary->exec_valid_limit_ip($params);

		if($params['hp_chk']!='Y'){
			$params['auth_hp'] = "";
		}else{
			if(trim($params['auth_hp']) == ''){
				openDialogAlert("인증 휴대폰 번호를 입력하여 주세요.",400,140,'parent','');
				exit;
			}
		}

		$this->load->model('providermodel');
		$provider_info			= $this->providermodel->get_provider($params['provider_seq']);

		if	($params['main_visual']){
			$params['main_visual']	= $this->providermodel->upload_minishop_image($provider_info['provider_id'], $params['main_visual'], $params['org_main_visual']);
		}else{
			if	($params['del_main_visual'] == 'y'){
				$this->providermodel->delete_minishop_image($params['org_main_visual']);
				$params['org_main_visual']	= '';
			}
			$params['main_visual']	= $params['org_main_visual'];
		}

		## add update date
		if	($provider_info['provider_status'] != $params['provider_status']){
			$params['update_date']	= date('Y-m-d H:i:s');
		}

		$data = filter_keys($params, $this->db->list_fields('fm_provider'));
		unset($data['deli_group']); // 입점사는 배송그룹을 수정할수 없음 (2013-09-24)
		
		// [반응형스킨] 미니샵 정보 추가 :: 2018-11-01 pjw
		$data['minishop_introdution']	= $_POST['minishop_introdution'];

		// 미니샵 정보 배열->문자열화 로직 추가 2019-06-27 Sunha Ryu
		if(empty($data['minishop_search_filter'])) {
		    $data['minishop_search_filter'] = array();
		}
		if(is_array($data['minishop_search_filter'])) {
		    $data['minishop_search_filter'] = implode(',', $data['minishop_search_filter']);
		}

		if(!empty($_POST['minishop_orderby']))			$data['minishop_orderby']		= $_POST['minishop_orderby'];
		if(!empty($_POST['minishop_status']))			$data['minishop_status']		= implode(',', $_POST['minishop_status']);

		// 추천상품 조건 추가 :: 2018-12-14 pjw
		$data['auto_criteria']			= $_POST['auto_criteria'];
		$data['auto_criteria_type']		= $_POST['auto_criteria_type'];
		$data['auto_contents']			= $_POST['auto_contents'];
		$data['auto_mobile_contents']	= $_POST['auto_mobile_contents'];
		$data['goods_info_style']		= $_POST['goods_info_style'];
		
		// 추천상품 타입이 직접 선정인경우
		if($data['auto_criteria_type'] == 'MANUAL'){
			// 기존 상품 데이터 삭제
			$this->db->delete('fm_provider_relation', array('provider_seq'=>$params['provider_seq']));

			// 선정한 상품 데이터가 있을 경우
			if( $_POST['displayGoods']!= null && count($_POST['displayGoods']) > 0){
				
				// 직접선정 추천상품 저장
				foreach($_POST['displayGoods'] as $tmp_goods_seq){
					$result	= $this->db->insert('fm_provider_relation', array('provider_seq'=>$params['provider_seq'],'relation_goods_seq'=>$tmp_goods_seq));
				}

			}
		}

		/* 수정내역 추출 */
		$query = $this->db->query("SHOW FULL COLUMNS FROM fm_provider");
		$columns_result = $query->result_array();
		$columns = array();
		foreach($columns_result as $v) $columns[$v['Field']] = $v['Comment'];

		$provider_log = $provider_info['provider_log'];
		foreach($data as $key=>$value){
			if($provider_info[$key]!=$value && $columns[$key] && !in_array($key,array('admin_memo','selleradmin_memo'))){
				$value1 = $provider_info[$key] ? $provider_info[$key] : '없음';
				$value2 = $value ? $value : '없음';
				$provider_log .= "<div>".$this->providerInfo['provider_id']."에 의해 ".$columns[$key]."정보가 ".date("Y년m월d일 H시i분s초")."에 변경됨 [".$value1."]->[".$value2."] (".$_SERVER['REMOTE_ADDR'].")</div>";
			}
		}
		$data['provider_log'] = $provider_log;

		$result = $this->db->update('fm_provider', $data, array('provider_seq'=>$params['provider_seq']));

		// 비밀번호가 실제로 변경된 후에 이력을 생성
		if($params['passwd_chg'] && $params['passwd_chg']=='Y'){
			$sql = "insert into fm_provider_pwd_history set provider_seq=?, pwd=?, regist_date=now()";
			$query = $this->db->query($sql,array($params['provider_seq'],$params['provider_passwd']));
		}

		### PERSON
		$this->db->delete('fm_provider_person', array('provider_seq' => $params['provider_seq']));
		$person = array('ds1', 'ds2', 'cs', 'calcu', 'md', 'wcalcu');
		foreach($person as $k){
			$gb	= $k=="calcu" ? "calcus" : $k;
			//if($params[$gb."_name"]){
				unset($eparams);
				$eparams['provider_seq'] = $params['provider_seq'];
				$eparams['gb']		= $k;
				$eparams['name']	= $params[$gb."_name"];
				$eparams['email']	= $params[$gb."_email"];
				$eparams['phone']	= $params[$gb."_phone"];
				$eparams['mobile']	= $params[$gb."_mobile"];
				$result = $this->db->insert('fm_provider_person', $eparams);
			//}
		}

		// 확인코드 저장
		if	(count($_POST['certify_code']) > 0){
			$this->load->model('providermodel');
			$this->providermodel->delete_certify(array('provider_seq' => $params['provider_seq']));
			foreach($_POST['certify_code'] as $k => $certify_code){
				if(!$_POST['manager_name'][$k] || !$certify_code) continue;
				$cparams['provider_seq']	= $params['provider_seq'];
				$cparams['manager_id']		= $provider_info['provider_id'];
				$cparams['manager_name']	= $_POST['manager_name'][$k];
				$cparams['certify_code']	= trim($certify_code);
				$this->providermodel->insert_certify($cparams);
				unset($cparams);
			}
		}

		## 메뉴 상단 처리 건수 표기
		if($_POST['noti_count_priod_order']){
			$this->load->model('providercode');
			$noti_codes = array('noti_count_priod_order','noti_count_priod_board','noti_count_priod_account');
			$data_auth	= array();
			$wheres['shopSno']			= $this->config_system['shopSno'];
			$wheres['provider_seq']	= $params['provider_seq'];
			$wheres['codecd like'] = '%_priod_%';
			$orderbys['idx'] 					= 'asc';
			$where_ins['codecd'] = $noti_codes;
			$this->providercode->del($wheres,$where_ins);
			$data_auth	= $this->providercode->select('max(idx) as midx',$wheres,$orderbys)->row_array();
			$idx = $data_auth['midx'];
			foreach( $noti_codes as $value){
				if($_POST[$value]){
					$idx++;
					$insert_params['idx']					= $idx;
					$insert_params['shopSno']		= $this->config_system['shopSno'];
					$insert_params['provider_seq']	=$params['provider_seq'];
					$insert_params['codecd']			= $value;
					$insert_params['value']				= $_POST[$value];
					$this->providercode->insert($insert_params);
				}
			}
		}

		if($result){
			$callback = "parent.document.location.reload();";
			openDialogAlert("수정 되었습니다.",400,140,'parent',$callback);
		}
	}



	public function provider_check($type){
		$this->validation->set_rules('provider_gb', '구분','trim|required|xss_clean');
		$this->validation->set_rules('provider_name', '입점사(업체)명','trim|max_length[20]|required|xss_clean');


		if($type=="regist"){
			$this->validation->set_rules('provider_id', '입점사 ID','trim|max_length[32]|required|xss_clean');
			$this->db->where('provider_id', $_POST['provider_id']);
			$query = $this->db->get("fm_provider");
			$mem_chk = $query->result_array();
			if($mem_chk){
				$callback = "if(parent.document.getElementsByName('provider_id')[0]) parent.document.getElementsByName('provider_id')[0].focus();";
				openDialogAlert("이미 등록된 아이디 입니다.",400,140,'parent',$callback);
				exit;
			}
			$this->validation->set_rules('provider_passwd', '입점사 비밀번호','trim|required|xss_clean');
		}else{
			if($_POST['passwd_chg']){
				$this->validation->set_rules('provider_passwd', '입점사 비밀번호','trim|required|xss_clean');
				$this->validation->set_rules('current_password', '현재 비밀번호','trim|required|max_length[32]|xss_clean');
			}
			if($_POST['provider_passwd']){
				$_POST['origin_provider_passwd'] = $_POST['provider_passwd'];
				$_POST['provider_passwd']	= Password::encrypt($_POST['provider_passwd']);
				$_POST['re_provider_passwd'] = Password::encrypt($_POST['re_provider_passwd']);
			}else{
				unset($_POST['provider_passwd']);
			}
		}


		if($_POST['provider_passwd'] != $_POST['re_provider_passwd']){
			$callback = "if(parent.document.getElementsByName('provider_id')[0]) parent.document.getElementsByName('provider_passwd')[0].focus();";
			openDialogAlert("입력한 비밀번호와 확인이 올바르지 않습니다.",400,140,'parent',$callback);
			exit;
		}

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		### 관리자 비밀번호 검증
		if($type=="modify" && $_POST['passwd_chg'] && $_POST['passwd_chg']=='Y'){

			$useChar = 0;
            
			if($_POST['provider_passwd'] != $_POST['re_provider_passwd']){
				$callback = "parent.document.getElementsByName('re_provider_passwd')[0].focus();";
				openDialogAlert("비밀번호 확인이 다릅니다.",400,140,'parent',$callback);
				exit;
			}

			$str_md5 = $_POST['provider_passwd'];   // 이미 상위에서 md5 실행함
			$str_sha256_md5 = hash('sha256',$str_md5);
			$sql = "select count(*) as cnt from (select * from fm_provider_pwd_history where provider_seq=? order by regist_date desc limit 2) a where a.pwd=? or a.pwd=? or a.pwd=?;";
			$queryBinds = [
				$_POST['provider_seq'], 
				$str_md5, 
				$str_sha256_md5, 
				Password::encrypt($_POST['provider_passwd'])
			];
			$query = $this->db->query($sql, $queryBinds);
			$res = $query->row_array();
			if($res['cnt']){
				openDialogAlert("사용할 수 없는 비밀번호입니다.",400,140,'parent',"");
				exit;
			}

			$str_md5 = md5($_POST['current_password']);
			$str_sha256_md5 = hash('sha256',$str_md5);
			$query = "select * from fm_provider where provider_seq=? and (provider_passwd=? OR provider_passwd=? OR provider_passwd=?)";
			$queryBinds = [
				$_POST['provider_seq'],
				$str_md5,
				$str_sha256_md5,
				Password::encrypt($_POST['current_password'])
			];
			$query = $this->db->query($query, $queryBinds);
			$data = $query->row_array();
			if(!$data){
				$callback = "";
				openDialogAlert("현재 비밀번호가 일치하지 않습니다.",400,140,'parent',$callback);
				exit;
			}

			// 비밀번호 유효성 체크
			if($_POST['provider_seq']){
				$query = "select * from fm_provider where provider_seq=?";
				$query = $this->db->query($query,array($_POST['provider_seq']));
				$data = $query->row_array();
				$pre_enc_password = $data['provider_passwd'];
				$enc_password = $_POST['provider_passwd'];    // 이미 상위에서 md5 실행함
			}
			
			$check_password = $this->input->post('origin_provider_passwd'); // 이미 상위에서 md5 실행하였으므로 원본 데이터를 전달함
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

		// 확인코드 유효성 및 중복확인
		if	(count($_POST['certify_code']) > 0){
			$this->load->model('providermodel');
			foreach($_POST['certify_code'] as $k => $certify_code){
				if(!$_POST['manager_name'][$k] || !$certify_code) continue;

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
				if($type=="modify" ) if	($_POST['certify_seq'][$k])	$param['out_seq']	= $_POST['certify_seq'][$k];
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

		if($_POST['deli_zipcode']) $_POST['deli_zipcode']		= implode("-",$_POST['deli_zipcode']);
		if($_POST['deli_zipcode']=='-') unset($_POST['deli_zipcode']);
		if($_POST['info_zipcode']) $_POST['info_zipcode']		= implode("-",$_POST['info_zipcode']);
		if($_POST['info_zipcode']=='-') unset($_POST['info_zipcode']);

		$_POST['info_address1_type']	= $_POST['info_address_type'];
		$_POST['info_address1']	= $_POST['info_address'];
		$_POST['info_address1_street']	= $_POST['info_address_street'];
		

		//계좌 사본	
		if(preg_match("/^\/?data\/tmp/i", $_POST['calcu_file_hidden'])){
			if(!is_dir(ROOTPATH.'data/provider')){
				@mkdir(ROOTPATH.'data/provider');
				@chmod(ROOTPATH.'data/provider',0777);
			}
			$ext = explode("/", $_POST['calcu_file_hidden']);
			$ext = $ext[count($ext)-1];
			$_POST['calcu_file'] = $ext;			
			$new_path = "data/provider/{$ext}";
			copy(ROOTPATH.$_POST['calcu_file_hidden'],ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
		}else{
			$_POST['calcu_file']		= $_POST['calcu_file_hidden'];
		}

		//사업자 등록증 사본	
		if(preg_match("/^\/?data\/tmp/i", $_POST['info_file_hidden'])){
			if(!is_dir(ROOTPATH.'data/provider')){
				@mkdir(ROOTPATH.'data/provider');
				@chmod(ROOTPATH.'data/provider',0777);
			}
			$ext = explode("/", $_POST['info_file_hidden']);
			$ext = $ext[count($ext)-1];
			$_POST['info_file'] = $ext;			
			$new_path = "data/provider/{$ext}";
			copy(ROOTPATH.$_POST['info_file_hidden'],ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
		}else{
			$_POST['info_file']		= $_POST['info_file_hidden'];
		}

		return $_POST;
	}

	public function provider_chk($chk_key = null){
		$manager_id = $_REQUEST['provider_id'];
		if(!$manager_id) die();
		//$manager_id = strtolower($manager_id);

		###
		$count = get_rows('fm_provider',array('provider_id'=>$manager_id));

		$text = "사용할 수 있는 아이디 입니다.";
		$return = true;
		if(strlen($manager_id)<4 || strlen($manager_id)>16){
			$text = "글자 제한 수를 맞춰주세요.";
			$return = false;
		}else if(preg_match("/[^a-z0-9\-_]/i", $manager_id)) {
			$text = "사용할 수 없는 아이디 입니다.";
			$return = false;
		}else if($count > 0){
			$text = "이미 사용중인 아이디 입니다.";
			$return = false;
		}
		$result = array("return_result" => $text, "manager_id" => $manager_id, "return" => $return);

		if($chk_key){
			return $result;
		}else{
			echo json_encode($result);
		}
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

	function default_stock_check()
	{
		$provider_seq = 1;
		if( $this->providerInfo['provider_seq'] ){
			$provider_seq = $this->providerInfo['provider_seq'];
		}
		$this->load->model('providermodel');

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