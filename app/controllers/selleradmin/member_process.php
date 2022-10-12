<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class member_process extends selleradmin_base {

	public function __construct() {
		parent::__construct();
		$this->load->library('validation');
		$this->load->model('admin/setting');
	}

	### 실명확인
	public function realname(){
		#### AUTH
		$auth = $this->authmodel->manager_limit_act('setting_member_act');
		if(!$auth){
			$callback = "parent.set_member_html();";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		if(isset($_POST['realnameId'])) config_save('realname',array('realnameId'=>$_POST['realnameId']));
		if(isset($_POST['realnamePwd'])) config_save('realname',array('realnamePwd'=>$_POST['realnamePwd']));
		if(isset($_POST['useRealname'])) config_save('realname',array('useRealname'=>$_POST['useRealname']));
		if(isset($_POST['ipinSikey'])) config_save('realname',array('ipinSikey'=>$_POST['ipinSikey']));
		if(isset($_POST['ipinKeyString'])) config_save('realname',array('ipinKeyString'=>$_POST['ipinKeyString']));
		if(isset($_POST['useIpin'])) config_save('realname',array('useIpin'=>$_POST['useIpin']));
		###
		$callback = "parent.set_member_html();";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}

	### 가입
	public function agreement(){
		#### AUTH
		$auth = $this->authmodel->manager_limit_act('setting_member_act');
		if(!$auth){
			$callback = "parent.set_member_html();";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		### 설정저장
		config_save('member',array('agreement'=>$_POST['agreement']));
		###
		$callback = "parent.set_member_html();";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}
	public function privacy(){
		#### AUTH
		$auth = $this->authmodel->manager_limit_act('setting_member_act');
		if(!$auth){
			$callback = "parent.set_member_html();";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		###
		$config['upload_path']		= $path = ROOTPATH."/data/config/";
		$config['overwrite']			= TRUE;
		$this->load->library('Upload');
		/*
		if (is_uploaded_file($_FILES['p3p_xml']['tmp_name'])) {
			$file_ext = end(explode('.', $_FILES['p3p_xml']['name']));//확장자추출
			$config['allowed_types']	= 'xml';
			$config['file_name']			= 'P3p.'.$file_ext;
			$this->upload->initialize($config);
			if ($this->upload->do_upload('p3p_xml')) {
				config_save('member',array('p3p_xml'=>$config['file_name']));
			}else{
				$callback = "";
				openDialogAlert("xml 만 가능합니다.",400,140,'parent',$callback);
				exit;
			}
		}
		if (is_uploaded_file($_FILES['p3policy_xml']['tmp_name'])) {
			$file_ext = end(explode('.', $_FILES['p3policy_xml']['name']));//확장자추출
			$config['allowed_types']	= 'xml';
			$config['file_name']			= 'P3policy.'.$file_ext;
			$this->upload->initialize($config);
			if ($this->upload->do_upload('p3policy_xml')) {
				config_save('member',array('p3policy_xml'=>$config['file_name']));
			}else{
				$callback = "";
				openDialogAlert("xml 만 가능합니다.",400,140,'parent',$callback);
				exit;
			}
		}
		*/
		if (is_uploaded_file($_FILES['privacy_html']['tmp_name'])) {
			$file_ext = end(explode('.', $_FILES['privacy_html']['name']));//확장자추출
			$config['allowed_types']	= 'html';
			$config['file_name']			= 'privacy_html.'.$file_ext;
			$this->upload->initialize($config);
			if ($this->upload->do_upload('privacy_html')) {
				config_save('member',array('privacy_html'=>$config['file_name']));
			}else{
				$callback = "";
				openDialogAlert("html 만 가능합니다.",400,140,'parent',$callback);
				exit;
			}
		}

		### 설정저장
		config_save('member',array('privacy'=>$_POST['privacy']));
		config_save('member',array('policy'=>$_POST['policy']));
		###
		$callback = "parent.set_member_html();";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}

	public function joinform(){
		#### AUTH
		$auth = $this->authmodel->manager_limit_act('setting_member_act');
		if(!$auth){
			$callback = "parent.set_member_html();";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		if( $_POST['Label_cnt'] > 0 ){
			 $this->db->empty_table('fm_joinform');
		}
		$user_sub_arr = $_POST['labelItem']['user'];
		$sort_user=0;
		foreach($user_sub_arr as $k => $sub_arr){
			if($sub_arr['use'] =='')$sub_arr['use'] ='N';
			if($sub_arr['required'] =='')$sub_arr['required'] ='N';
			$sort_user++;
			$data = array(
							'joinform_seq'=> $sub_arr['joinform_seq'],
							'join_type' => 'user',
							'label_title' => $sub_arr['name'],
							'label_desc' => $sub_arr['exp'],
							'label_type' => $sub_arr['type'],
							'label_value' => $sub_arr['value'],
							'required' => $sub_arr['required'],
							'used' => $sub_arr['use'],
							'sort_seq' => $sort_user,
							'regist_date' => date('Y-m-d H:i:s'),
						);
			$this->db->insert('fm_joinform', $data);

		}
		$sort_order=0;
		$order_sub_arr = $_POST['labelItem']['order'];
		foreach($order_sub_arr as $k => $sub_arr){
			if($sub_arr['use'] =='')$sub_arr['use'] ='N';
			if($sub_arr['required'] =='')$sub_arr['required'] ='N';
			$sort_order++;
			$data = array(
							'joinform_seq'=> $sub_arr['joinform_seq'],
							'join_type' => 'order',
							'label_title' => $sub_arr['name'],
							'label_desc' => $sub_arr['exp'],
							'label_type' => $sub_arr['type'],
							'label_value' => $sub_arr['value'],
							'required' => $sub_arr['required'],
							'used' => $sub_arr['use'],
							'sort_seq' => $sort_order,
							'regist_date' => date('Y-m-d H:i:s'),
					);
			$this->db->insert('fm_joinform', $data);

		}
		### 설정저장
		config_save('joinform',array('email_userid'=>$_POST['email_userid']));
		config_save('joinform',array('join_type'=>$_POST['join_type']));

		//snsmb
		if($_POST['join_type'] == 'member_only' ){
			unset($_POST['join_sns_bizonly'], $_POST['join_sns_mbbiz']);
		}

		if($_POST['join_type'] == 'member_business' ){
			unset($_POST['join_sns_mbonly'], $_POST['join_sns_bizonly']);
		}

		if($_POST['join_type'] == 'business_only' ){
			unset($_POST['join_sns_mbonly'], $_POST['join_sns_mbbiz']);
		}

		config_save('joinform',array('join_sns_mbonly'=>$_POST['join_sns_mbonly']));
		config_save('joinform',array('join_sns_bizonly'=>$_POST['join_sns_bizonly']));
		config_save('joinform',array('join_sns_mbbiz'=>$_POST['join_sns_mbbiz']));

		config_save('joinform',array('use_f'=>$_POST['use_f']));
		config_save('joinform',array('use_home'=>$_POST['use_home']));

		//sns use
		if($_POST['key_f']){
		  config_save('snssocial',array('use_f'=>1));
		  config_save('snssocial',array('key_f'=>$_POST['key_f']));
		  config_save('snssocial',array('secret_f'=>$_POST['secret_f']));
		  config_save('snssocial',array('name_f'=>$_POST['name_f']));
		}else{
		  config_save('snssocial',array('use_f'=>1));
		  config_save('snssocial',array('key_f'=>'455616624457601'));
		  config_save('snssocial',array('secret_f'=>'a6c595c16e08c17802ab4e4d8ac0e70b'));
		  config_save('snssocial',array('name_f'=>'fammerce_plus'));
		}

		if($_POST['use_t']){
		  config_save('snssocial',array('use_t'=>$_POST['use_t']));
		  config_save('snssocial',array('key_t'=>$_POST['key_t']));
		  config_save('snssocial',array('secret_t'=>$_POST['secret_t']));

		  config_save('joinform',array('use_t'=>$_POST['use_t']));
		}else{
		  config_save('snssocial',array('use_t'=>0));
		  config_save('snssocial',array('key_t'=>'ifHWJYpPA2ZGYDrdc5wQ'));
		  config_save('snssocial',array('secret_t'=>'cH5gWafZTZjY553zTqZ2YEd4pRPCsKjeHkB8TLficwI'));

		  config_save('joinform',array('use_t'=>$_POST['use_t']));
		}

		if( $_POST['use_m'] && (!$_POST['key_m'] ) ){
			openDialogAlert("미투데이의 [API Key] 값을 정확히 입력해 주세요.",400,140,'parent',$callback);
			exit;
		}
		  config_save('snssocial',array('use_m'=>$_POST['use_m']));
		  config_save('snssocial',array('key_m'=>$_POST['key_m']));
		  config_save('joinform',array('use_m'=>$_POST['use_m']));

		if( $_POST['use_y'] && (!$_POST['key_y'] || !$_POST['secret_y'] ) ){
			openDialogAlert("요즘의 설정값을 정확히 입력해 주세요.",400,140,'parent',$callback);
			exit;
		}

		  config_save('snssocial',array('use_y'=>$_POST['use_y']));
		  config_save('snssocial',array('key_y'=>$_POST['key_y']));
		  config_save('snssocial',array('secret_y'=>$_POST['secret_y']));
		  config_save('joinform',array('use_y'=>$_POST['use_y']));

		if($_POST['use_c']){
		  config_save('snssocial',array('use_c'=>$_POST['use_c']));
		  config_save('snssocial',array('key_c'=>$_POST['key_c']));
		  config_save('snssocial',array('secret_c'=>$_POST['secret_c']));

		  config_save('joinform',array('use_c'=>$_POST['use_c']));
		}else{
		  config_save('snssocial',array('use_c'=>0));
		  config_save('snssocial',array('key_c'=>'394d5f52e7654e216714d5ea074f242705063b910'));
		  config_save('snssocial',array('secret_c'=>'35939c0a7c818488a5d4b268399c88db'));

		  config_save('joinform',array('use_c'=>$_POST['use_c']));
		}



		###
		if(isset($_POST['disabled_userid'])){
			$_POST['disabled_userid'] = str_replace(" ","",$_POST['disabled_userid']);
			config_save('joinform',array('disabled_userid'=>$_POST['disabled_userid']));
		}
		###
		$user_arr = array('userid', 'password', 'user_name', 'email', 'phone', 'cellphone', 'address', 'recommend', 'birthday', 'sex');
		$buss_arr = array('bname', 'bceo', 'bno', 'bitem', 'badress', 'bperson', 'bpart', 'bphone','bemail', 'bcellphone');
		for($i=0;$i<count($user_arr);$i++){
			$use_name = $user_arr[$i]."_use";
			$required_name = $user_arr[$i]."_required";
			$this->joinform_config_save($_POST, $use_name);
			$this->joinform_config_save($_POST, $required_name);
		}
		###
		for($i=0;$i<count($buss_arr);$i++){
			$use_name = $buss_arr[$i]."_use";
			$required_name = $buss_arr[$i]."_required";
			$this->joinform_config_save($_POST, $use_name);
			$this->joinform_config_save($_POST, $required_name);
		}

		###
		$callback = "parent.set_member_html();";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}


	public function joinform_snsconfig_save($params, $name){
		$value = if_empty($params, $name, 'N');
		//echo $name." : ".$value."<br>";
		config_save('joinform',array($name=>$value));
	}

	public function joinform_config_save($params, $name){
		$value = if_empty($params, $name, 'N');
		//echo $name." : ".$value."<br>";
		config_save('joinform',array($name=>$value));
	}


	### 승인/혜택
	public function approval(){
	}

	### 등급
	public function grade(){
		#### AUTH
		$auth = $this->authmodel->manager_limit_act('setting_member_act');
		if(!$auth){
			$callback = "parent.set_member_html();";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		if($_POST['grade_mode']=='deleteGrade'){
			for ($i = 0 ; $i < count($_POST['group_seq']) ; $i++) {
				$group_seq = $_POST['group_seq'][$i];
				$result = $this->db->delete('fm_member_group', array('group_seq' => $group_seq));
				$result = $this->db->delete('fm_member_group_issuegoods', array('group_seq' => $group_seq));
				$result = $this->db->delete('fm_member_group_issuecategory', array('group_seq' => $group_seq));
			}
			if($result){
				$callback = "parent.set_member_html();";
				openDialogAlert("삭제되었습니다.",400,140,'parent',$callback);
			}
		}else{
			config_save('grade_clone',array('start_month'=>$_POST['start_month']));
			config_save('grade_clone',array('chg_term'	=>$_POST['chg_term']));
			config_save('grade_clone',array('chg_day'	=>$_POST['chg_day']));
			config_save('grade_clone',array('chk_term'	=>$_POST['chk_term']));
			config_save('grade_clone',array('keep_term'	=>$_POST['keep_term']));
			$callback = "parent.set_member_html();";
			openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
		}
	}
	public function grade_write(){
		#### AUTH
		$auth = $this->authmodel->manager_limit_act('setting_member_act');
		if(!$auth){
			$callback = "parent.set_member_html();";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		### Validation
		$this->validation->set_rules('group_name', '명칭','trim|required|max_length[15]|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		###
		$params = $_POST;
		$params['regist_date'] = date('Y-m-d H:i:s');
		if(isset($_POST['order_sum_use'])) if(is_array($_POST['order_sum_use'])) $params['order_sum_use'] = serialize($_POST['order_sum_use']);
		$data = filter_keys($params, $this->db->list_fields('fm_member_group'));
		$result = $this->db->insert('fm_member_group', $data);
		$group_seq = $this->db->insert_id();

		### SALE
		for($i=0;$i<count($_POST['issueGoods']);$i++){
			if($_POST['issueGoods'][$i])
			$result = $this->db->insert('fm_member_group_issuegoods', array('group_seq'=>$group_seq,'goods_seq'=>$_POST['issueGoods'][$i],'type'=>'sale'));
		}
		for($i=0;$i<count($_POST['issueCategoryCode']);$i++){
			$result = $this->db->insert('fm_member_group_issuecategory', array('group_seq'=>$group_seq,'category_code'=>$_POST['issueCategoryCode'][$i],'type'=>'sale'));
		}

		### EMONEY
		for($i=0;$i<count($_POST['exceptIssueGoods']);$i++){
			if($_POST['exceptIssueGoods'][$i])
			$result = $this->db->insert('fm_member_group_issuegoods', array('group_seq'=>$group_seq,'goods_seq'=>$_POST['exceptIssueGoods'][$i],'type'=>'emoney'));
		}
		for($i=0;$i<count($_POST['issueCategoryCode']);$i++){
			$result = $this->db->insert('fm_member_group_issuecategory', array('group_seq'=>$group_seq,'category_code'=>$_POST['exceptIssueCategoryCode'][$i],'type'=>'emoney'));
		}

		###
		if($result){
			//$callback = "parent.set_member_html();parent.closeDialog('gradePopup');";
			$callback = "parent.formMove('grade',4);";
			openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
		}
	}
	public function grade_modify(){
		#### AUTH
		$auth = $this->authmodel->manager_limit_act('setting_member_act');
		if(!$auth){
			$callback = "parent.set_member_html();";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		### Validation
		$this->validation->set_rules('group_name', '명칭','trim|required|max_length[15]|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		###
		$params = $_POST;
		//$params['sale_use'] = if_empty($params, 'sale_use', 'N');
		//$params['point_use'] = if_empty($params, 'point_use', 'N');
		$params['update_date'] = date('Y-m-d H:i:s');
		###
		$result = $this->db->delete('fm_member_group_issuegoods', array('group_seq' => $params['seq']));
		$result = $this->db->delete('fm_member_group_issuecategory', array('group_seq' => $params['seq']));


		### SALE
		$issueGoods = array_unique($_POST['issueGoods']);
		for($i=0;$i<count($issueGoods);$i++){
			if($issueGoods[$i])
			$result = $this->db->insert('fm_member_group_issuegoods', array('group_seq'=>$params['seq'],'goods_seq'=>$issueGoods[$i],'type'=>'sale'));
		}
		for($i=0;$i<count($_POST['issueCategoryCode']);$i++){
			$result = $this->db->insert('fm_member_group_issuecategory', array('group_seq'=>$params['seq'],'category_code'=>$_POST['issueCategoryCode'][$i],'type'=>'sale'));
		}

		### EMONEY
		$exceptIssueGoods = array_unique($_POST['exceptIssueGoods']);
		for($i=0;$i<count($exceptIssueGoods);$i++){
			if($exceptIssueGoods[$i])
			$result = $this->db->insert('fm_member_group_issuegoods', array('group_seq'=>$params['seq'],'goods_seq'=>$exceptIssueGoods[$i],'type'=>'emoney'));
		}
		for($i=0;$i<count($_POST['exceptIssueCategoryCode']);$i++){
			$result = $this->db->insert('fm_member_group_issuecategory', array('group_seq'=>$params['seq'],'category_code'=>$_POST['exceptIssueCategoryCode'][$i],'type'=>'emoney'));
		}


		if( is_array($_POST['order_sum_use']) ) $params['order_sum_use'] = serialize($_POST['order_sum_use']);
		$data = filter_keys($params, $this->db->list_fields('fm_member_group'));
		$this->db->where('group_seq', $params['seq']);
		$result = $this->db->update('fm_member_group', $data);

		###
		if($result){
			//$callback = "parent.set_member_html();parent.closeDialog('gradePopup');";
			$callback = "parent.formMove('grade',4);";
			openDialogAlert("설정이 수정 되었습니다.",400,140,'parent',$callback);
		}
	}


	### 로그아웃/탈퇴/재가입
	public function withdraw(){
		#### AUTH
		$auth = $this->authmodel->manager_limit_act('setting_member_act');
		if(!$auth){
			$callback = "parent.set_member_html();";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		### 설정저장
		config_save('member',array('sessLimit'=>$_POST['sessLimit']));
		config_save('member',array('sessLimitMin'=>$_POST['sessLimitMin']));
		###
		$callback = "parent.set_member_html();";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}


	public function withdrawal_set(){
		$this->load->model('membermodel');
		$member_arr = $_GET['member_chk'];
		###
		$params['regist_date']	= date('Y-m-d H:i:s');
		$params['reason']		= "관리자 리스트 탈퇴처리";
		$params['regist_ip']	= $_SERVER['REMOTE_ADDR'];
		$this->load->library('memberlibrary');
		//회원탈퇴
		$withdrawalMsg = $this->memberlibrary->set_withdrawal($params, $member_arr);
		###
		$callback = "parent.location.reload();";
		openDialogAlert($withdrawalMsg['msg'],400,140,'parent',$callback);
	}


	public function member_modify(){}

	public function member_withdrawal(){
		### Validation
		$this->validation->set_rules('reason', '탈퇴사유','trim|required|xss_clean');
		$this->validation->set_rules('memo', '내용','trim|required|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		###
		$params	= $_POST;
		$params['regist_date']	= date('Y-m-d H:i:s');
		$params['regist_ip']	= $_SERVER['REMOTE_ADDR'];
		$this->load->library('memberlibrary');
		//회원탈퇴
		$withdrawalMsg = $this->memberlibrary->set_withdrawal($params);
		###
		$callback = "parent.location.href = '/selleradmin/member/withdrawal';";
		openDialogAlert($withdrawalMsg['msg'],400,140,'parent',$callback);
	}


	public function sms(){
		#### AUTH
		$auth = $this->authmodel->manager_limit_act('member_act');
		if(!$auth){
			$callback = "";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		###
		$sms_arr = array("join","withdrawal","","order","settle","released","delivery","cancel","refund","findid","findpwd");//,"cs"

		###
		if(isset($_POST['send_num'])) config_save('sms_info',array('send_num'=>implode("-",$_POST['send_num'])));

		$qry = "DELETE FROM fm_config WHERE groupcd = 'sms_info' AND codecd like 'admins_num_%'";
		$result = $this->db->query($qry);
		$cnt = 0;
		for($i=0;$i<count($_POST['admins_num1']);$i++){
			$id		= "admins_num_".$i;
			if(isset($_POST['admins_num1'][$i]) && isset($_POST['admins_num2'][$i]) && isset($_POST['admins_num3'][$i])){
				$number = $_POST['admins_num1'][$i]."-".$_POST['admins_num2'][$i]."-".$_POST['admins_num3'][$i];
				if($number!='--'){
					config_save('sms_info',array($id=>$number));
					$cnt = $i;
				}
			}
		}
		if($cnt>0) config_save('sms_info',array('admis_cnt'=>$cnt+1));

		###
		for($i=0;$i<count($sms_arr);$i++){
			$user_id = $sms_arr[$i]."_user";

			if($i!=2){
				$this->validation->set_rules($user_id, '내용','trim|required|xss_clean');
				if($this->validation->exec()===false){
					$err = $this->validation->error_array;
					$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
					openDialogAlert('SMS 메시지를 입력해 주세요.',400,140,'parent',$callback);
					exit;
				}
			}

			config_save('sms',array($user_id=>$_POST[$user_id]));
			$admin_id = $sms_arr[$i]."_admin";
			config_save('sms',array($admin_id=>$_POST[$admin_id]));
			$user_chk = $sms_arr[$i]."_user_yn";
			config_save('sms',array($user_chk=>if_empty($_POST, $user_chk, 'N')));
			/*
			$admin_chk = $sms_arr[$i]."_admin_yn";
			config_save('sms',array($admin_chk=>if_empty($_POST, $admin_chk, 'N')));
			*/
			for($j=0;$j<$cnt+1;$j++){
				$admins_chk = $sms_arr[$i]."_admins_yn_".$j;
				config_save('sms',array($admins_chk=>if_empty($_POST, $admins_chk, 'N')));
			}
		}

		###
		$callback = "parent.location.reload();";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}

	public function email(){
		#### AUTH
		$auth = $this->authmodel->manager_limit_act('member_act');
		if(!$auth){
			$callback = "";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		###
		$email_arr = array("join","order","settle","delivery","cancel","findid","confirm","cs");

		###
		/*
		for($i=0;$i<count($email_arr);$i++){
			$user_chk = $email_arr[$i]."_user_yn";
			config_save('email',array($user_chk=>if_empty($_POST, $user_chk, 'N')));
			$admin_chk = $email_arr[$i]."_admin_yn";
			config_save('email',array($admin_chk=>if_empty($_POST, $admin_chk, 'N')));
		}
		*/

		$basic = config_load('basic');

		if(isset($_POST['mail_form'])){
			$id = $_POST['mail_form'];
			config_save('email',array($id."_title"=>$_POST['title']));
			//config_save('email',array($id."_skin"=>$_POST['contents']));
			config_save('email',array($id."_skin"=>adjustEditorImages($_POST['contents'])));

			$user_chk = $id."_user_yn";
			config_save('email',array($user_chk=>if_empty($_POST, $user_chk, 'N')));
			$admin_chk = $id."_admin_yn";
			config_save('email',array($admin_chk=>if_empty($_POST, $admin_chk, 'N')));
			$admin_email = $id."_admin_email";
			config_save('email',array($admin_email=>if_empty($_POST, $admin_email, $basic['companyEmail'])));
		}

		$path = ROOTPATH."/data/email/".get_lang(true)."/".$id.".html";
		setHtmlFile($path, adjustEditorImages($_POST['contents']), 1);

		###
		//$callback = "parent.location.reload();";
		$callback = "";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}

	public function getmail(){
		$id		= $_GET['id'];

		$email = config_load('email');
		$title = isset($email[$id.'_title']) ? $email[$id.'_title'] : "";
		$contents = isset($email[$id.'_skin']) ? $email[$id.'_skin'] : " ";

		$user_chk	= $email[$id."_user_yn"]=='Y' ? "checked" : "";
		$admin_chk	= $email[$id."_admin_yn"]=='Y' ? "checked" : "";
		$admin_email = $email[$id."_admin_email"];

		$basic = config_load('basic');
		if(!$admin_email) $admin_email = $basic['companyEmail'];

		$html = "<label><input type='checkbox' name='".$id."_user_yn' value='Y' ".$user_chk."/> 고객</label> ";
		$html .= "<label><input type='checkbox' name='".$id."_admin_yn' value='Y' ".$admin_chk."/> 관리자</label> ";
		$html .= "<input type='text' name='".$id."_admin_email' value='{$admin_email}' />";

		###
		$path = ROOTPATH."/data/email/".get_lang(true)."/".$id.".html";
		$data = getHtmlFile($path);

		$result = array("title"=>$title,"contents"=>$data,"html"=>$html);
		echo "[".json_encode($result)."]";
	}

	public function logmail(){
		$seq	= $_GET['seq'];
		$query = $this->db->query("select * from fm_log_email where seq = '{$seq}'");
		$emailData = $query->result_array();
		$title = isset($emailData[0]['subject']) ? $emailData[0]['subject'] : "";
		$contents = isset($emailData[0]['contents']) ? $emailData[0]['contents'] : " ";
		$result = array("title"=>$title,"contents"=>$contents);
		echo "[".json_encode($result)."]";
	}

	public function getlogmail(){
		$seq	= $_GET['seq'];
		$query = $this->db->query("select * from fm_log_email where seq = '{$seq}'");
		$emailData = $query->result_array();
		$contents = isset($emailData[0]['contents']) ? $emailData[0]['contents'] : " ";
		$subject = isset($emailData[0]['subject']) ? $emailData[0]['subject'] : " ";
		$total = isset($emailData[0]['total']) ? $emailData[0]['total'] : " ";
		$regdate = isset($emailData[0]['regdate']) ? $emailData[0]['regdate'] : " ";
		$result = array("subject"=>$subject,"total"=>$total,"regdate"=>$regdate,"contents"=>$contents);
		//echo $result;
		echo "[".json_encode($result)."]";
	}




	public function getSmsForm(){
		###
		$sc['page']				= (isset($_POST['page'])) ?		intval($_POST['page']):'0';
		$sc['perpage']			= (isset($_POST['perpage'])) ?	intval($_POST['perpage']):'4';
		$sc['category']			= (isset($_POST['category'])) ?	$_POST['category'] : null;

		$this->load->model('membermodel');
		$data = $this->membermodel->sms_form_list($sc);

		###
		$sc['searchcount']	 = $data['count'];
		$sc['total_page']	 = ceil($sc['searchcount']	 / $sc['perpage']);
		$sc['totalcount']	 = get_rows('fm_sms_album');

		$paginlay = pagingtag($sc['searchcount'],$sc['perpage'],'sms_form?', getLinkFilter('',array_keys($sc)) );
		if(empty($paginlay)) $paginlay = '<p><a class="on red">1</a><p>';

		//print_r($data);
		$result = "<table width=\"100%\" cellspacing=\"0\">";
		$result .= "<tr>";
		foreach($data['result'] as $datarow){
			$result .= "<td>";
			$result .= "	<div style='padding:2px;'>";
			$result .= "		<div class='sms-define-form'>";
			$result .= "			<div class='sdf-head clearbox'>";
			$result .= "				<div class='fl'><img src='/selleradmin/skin/default/images/common/sms_i_antena.gif'></div>";
			$result .= "				<div class='fr'><img src='/selleradmin/skin/default/images/common/sms_i_battery.gif'></div>";
			$result .= "			</div>";
			$result .= "			<div class='sdf-body-wrap'>";
			$result .= "				<div class='sdf-body'>";
			$result .= "					<textarea name='_user' readonly class='sms_contents' codecd='{$datarow['category']}' groupcd='sms_form' onclick=\"$('#send_message').val(this.value);send_byte_chk($('#send_message'));\">".htmlspecialchars($datarow['msg'])."</textarea>";
			$result .= "					<div class='sdf-body-foot clearbox'>";
			$result .= "						<div class='fl'><b class='send_byte'>0</b>byte</div>";
			$result .= "						<div class='fr'><img src='/selleradmin/skin/default/images/common/sms_btn_send.gif' align='absmiddle' class='del_message' /></div>";
			$result .= "					</div>";
			$result .= "				</div>";
			$result .= "			</div>";
			$result .= "		</div>";
			$result .= "	</div>";
//			$result .= "<textarea name=\"_user\" class=\"sms_contents\" readonly codecd=\"".$datarow['category']."\" groupcd=\"sms_form\"  onmouseover=\"this.className='sms_contents_border';\" onmouseout=\"this.className='sms_contents';\" onclick=\"$('#send_message').val(this.value);send_byte_chk();\">".$datarow['msg']."</textarea>";
			$result .= "<div><span class=\"btn small gray\"><button type=\"button\" class='mod_form' id=\"mod_form\" seq=\"".$datarow['seq']."\">수정</button></span> <span class=\"btn small gray\"><button type=\"button\" id=\"del_form\" class='del_form' seq=\"".$datarow['seq']."\">삭제</button></span></div>";
			$result .= "</td>";
		}
		$result .= "</tr>";
		//$result .= "</table>";
		$result .= "<tr height='15'><td colspan='4'></td></tr>";
		$result .= "<tr><td colspan='4' align='center'>";
		$result .= "<span class=\"paging_navigation\" style=\"width:100%;text-align:center;\">".$paginlay."</span>";
		$result .= "</td></tr>";
		$result .= "</table>";

		echo json_encode($result);
	}

	public function delete_smsform(){
		if(isset($_GET['seq'])){
			$result = $this->db->delete('fm_sms_album', array('seq' => $_GET['seq']));
			$callback = "parent.document.getElementById('container').src='../member/sms_form';";
			openDialogAlert("삭제 되었습니다.",400,140,'parent',$callback);
		}
	}


	public function sms_process(){
		### Validation
		if(isset($_POST['sms_form_group'])){
			$this->validation->set_rules('sms_form_group', '그룹선택','trim|required|xss_clean');
		}else{
			$this->validation->set_rules('sms_form_name', '그룹명','trim|required|xss_clean');
		}
		$this->validation->set_rules('sms_form_text', '보관메세지','trim|required|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		###
		$params['category'] = isset($_POST['sms_form_group']) ? $_POST['sms_form_group'] : $_POST['sms_form_name'];
		$params['msg'] = $_POST['sms_form_text'];

		if($_POST['album_seq']){
			$this->db->where('seq', $_POST['album_seq']);
			$result = $this->db->update('fm_sms_album', $params);
		}else{
			$result = $this->db->insert('fm_sms_album', $params);
		}

		###
		$callback = "parent.document.getElementById('container').src='../member/sms_form';";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}



	public function send_email(){
		### Validation
		if($_POST['send_num'] < 1){
			$callback = "";
			openDialogAlert('받는사람이 없습니다.',400,140,'parent',$callback);
			exit;
		}
		$this->validation->set_rules('title', '제목','trim|required|max_length[100]|xss_clean');
		//$this->validation->set_rules('contents', '내용','trim|required|xss_clean');
		$this->validation->set_rules('send_email', '보내는사람','trim|required|max_length[50]|valid_email|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		###
		unset($mailArr);
		$mailArr = explode(",", $_POST["send_to"]);
		unset($mailArr[0]);
		if(isset($_POST['add_num_chk'])!='Y'){
			$key = get_shop_key();
			switch($_POST['member']){
				case "all":
					$query = $this->db->query("select AES_DECRYPT(UNHEX(email), '{$key}') as email from fm_member where status != 'withdrawal' and email<>'' and mailing = 'y'");
					$data = $query->result_array();
					if(count($data)>0){
						foreach($data as $k){
							array_push($mailArr,$k['email']);
						}
					}
					break;
				case "search":
					//echo urldecode($_POST["serialize"]);
					$tempArr = explode("&",urldecode($_POST["serialize"]));
					foreach($tempArr as $k){
						$tmp = explode("=",$k);
						if($tmp[1]){
							$sc[$tmp[0]] = $tmp[1];
						}
					}
					//$sc['mailing'] = 'y';
					$this->load->model('membermodel');
					$data = $this->membermodel->admin_search_list($sc);
					if(count($data['result'])>0){
						foreach($data['result'] as $k){
							array_push($mailArr,$k['email']);
						}
					}
					break;
				case "select":
					$tempArr = explode(",", $_POST["serialize"]);
					unset($tempArr[0]);
					foreach($tempArr as $k){
						$query = $this->db->query("select AES_DECRYPT(UNHEX(email), '{$key}') as email from fm_member where member_seq = '{$k}' and email<>'' ");
						$data = $query->result_array();
						if($data[0]['email']) array_push($mailArr,$data[0]['email']);
					}
					break;
				case "excel":
					break;
			}

		}
		//print_r($mailArr);
		//exit;
		###
		$this->load->model('usedmodel');
		$email_chk = $this->usedmodel->hosting_check();

		###
		$total = count($mailArr);
		$toMonth = date("Y-m");
		$sql = "select sum(total) as count from fm_log_email where regdate like '{$toMonth}%'";
		$query = $this->db->query($sql);
		$emailData = $query->result_array();
		$usedMail	= $emailData[0]['count'] + $total;
		if(3000 < $usedMail  && !$email_chk){
			$callback = "";
			openDialogAlert('본 이메일 발송 기능은 월 3,000통 발송이 가능합니다.<br>더 많은 이메일 발송은 대량발송 서비스를 이용해 주십시오.',400,140,'parent',$callback);
			exit;
		}
		###
		$basic = config_load('basic');
		//sendDirectMail($mailArr, $_POST['send_email'], $_POST['title'], $_POST['contents']);
		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/Email_send.class.php";
		$mail = new Mail(isset($params));
		$body = adjustEditorImages($_POST['contents']);
		foreach($mailArr as $k){
			if(filter_var($k,FILTER_VALIDATE_EMAIL)!=false){
				$headers['From']    = $_POST['send_email'];
				$headers['Name']	= !$basic['companyName'] ? get_connet_protocol().$_SERVER['HTTP_HOST'] : $basic['companyName'];
				$headers['Subject'] = $_POST['title'];
				$headers['To'] = $k;
				$resSend = $mail->send($headers, $body);
			}
		}

		### LOG
		$params['regdate']		= date('Y-m-d H:i:s');
		$params['gb']			= 'MANUAL';
		$params['total']		= $total;
		$params['from_email']	= $_POST['send_email'];
		$params['subject']		= $_POST['title'];
		$params['contents']		= $body;
		$data = filter_keys($params, $this->db->list_fields('fm_log_email'));
		$result = $this->db->insert('fm_log_email', $data);

		### MASTER
		config_save('master',array('mail_count'=>(3000 - $usedMail)));

		$callback = "parent.document.getElementById('container').src='../member/email_form';";
		//$callback = "parent.location.reload();";
		$msg = "메일이 발송 되었습니다.";
		openDialogAlert($msg,400,140,'parent',$callback);
		exit;
	}


	public function send_sms(){
		### Validation
		if($_POST['send_num'] < 1){
			$callback = "";
			openDialogAlert('받는사람이 없습니다.',400,140,'parent',$callback);
			exit;
		}
		$this->validation->set_rules('send_message', '내용','trim|required|xss_clean');
		$this->validation->set_rules('send_sms', '보내는사람','trim|required|max_length[50]|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		###
		$phoneNo = explode(",", $_POST["send_to"]);
		unset($phoneNo[0]);
		$key = get_shop_key();

		if(isset($_POST['add_num_chk'])!='Y'){
			switch($_POST['member']){
				case "all":
					$sql = "SELECT
									AES_DECRYPT(UNHEX(A.cellphone), '{$key}') as cellphone ,
									B.bcellphone, B.business_seq
									 FROM fm_member A
									LEFT JOIN fm_member_business B ON A.member_seq = B.member_seq
									WHERE status != 'withdrawal' and sms = 'y' ";
					$query = $this->db->query($sql);
					$data = $query->result_array();
					if(count($data)>0){
						foreach($data as $k){
							if($k['business_seq'] ) { //기업회원
								if($k['bcellphone']) array_push($phoneNo, $k['bcellphone']);
							}else{
								if($k['cellphone']) array_push($phoneNo, $k['cellphone']);
							}
						}
					}
					break;
				case "search":
					//echo urldecode($_POST["serialize"]);
					$tempArr = explode("&",urldecode($_POST["serialize"]));
					foreach($tempArr as $k){
						$tmp = explode("=",$k);
						if($tmp[1]){
							$sc[$tmp[0]] = $tmp[1];
						}
					}
					//$sc['sms'] = 'y';
					$this->load->model('membermodel');
					$data = $this->membermodel->admin_search_list($sc);
					if(count($data['result'])>0){
						foreach($data['result'] as $k){
							//array_push($phoneNo,$k['cellphone']);
							if($k['business_seq'] ) { //기업회원
								if($k['bcellphone']) array_push($phoneNo, $k['bcellphone']);
							}else{
								if($k['cellphone']) array_push($phoneNo, $k['cellphone']);
							}

						}
					}
					break;
				case "select":
					$tempArr = explode(",", $_POST["serialize"]);
					unset($tempArr[0]);
					foreach($tempArr as $k){
					$sql = "SELECT
									AES_DECRYPT(UNHEX(A.cellphone), '{$key}') as cellphone ,
									B.bcellphone, B.business_seq
									 FROM fm_member A
									LEFT JOIN fm_member_business B ON A.member_seq = B.member_seq
									WHERE A.member_seq = '{$k}'  ";

						$query = $this->db->query($sql);
						$data = $query->result_array();

						if($data[0]['business_seq'] ) { //기업회원
							if($data[0]['bcellphone']) array_push($phoneNo, $data[0]['bcellphone']);
						}else{
							if($data[0]['cellphone']) array_push($phoneNo, $data[0]['cellphone']);
						}
					}
					break;
				case "excel":
					break;
			}
		}

		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
		$sms_send	= new SMS_SEND();
		$from_sms	= preg_replace("/[^0-9]/", "", $_POST['send_sms']);
		$cnt = 0;
		foreach($phoneNo as $v){
			$dataTo[$cnt]["phone"] = $v;
			$cnt++;
		}
		$sms_send->to		= $dataTo;
		$sms_send->from		= $from_sms;

		###
		$str = trim($_POST["send_message"]);
		$euckr_str = mb_convert_encoding($str,'EUC-KR','UTF-8');
		$len = strlen($euckr_str);
		$size = ceil($len/80);
		$start_num	= 0;
		$cut_num	= 80;
		$send_cnt	= 0;
		/*
		for($i=0;$i<$size;$i++){
			$temp_str	= substr($euckr_str, $start_num, $cut_num);
			$iconv_str	= iconv('EUC-KR','UTF-8',$temp_str);
			if(!trim($iconv_str)){
				$cut_num--;
				$temp_str	= substr($euckr_str, $start_num, $cut_num);
				$iconv_str	= iconv('EUC-KR','UTF-8',$temp_str);
			}
			$start_num	+= $cut_num;
			$cut_num	= 80;
			//echo $iconv_str."<br>";
			$result		= $sms_send->send($iconv_str);
			$send_cnt++;
		}

		if(!$result){
			$result_msg	= $sms_send->msg;
		}else{
			$result_msg = $send_cnt."개의 SMS가 발송되었습니다.";
		}
		*/
		###
		$result		= $sms_send->send($str);
		$msg	= $sms_send->msg;

		$callback = "";
		openDialogAlert($msg,400,140,'parent',$callback);
		exit;
	}

	public function set_emoney(){
		### Validation
		if($_POST['send_member'] < 1){
			$callback = "";
			openDialogAlert('선택된 회원이 없습니다.',400,140,'parent',$callback);
			exit;
		}
		### Validation
		$this->validation->set_rules('emoney', '마일리지','trim|required|xss_clean');
		$this->validation->set_rules('memo', '사유','trim|required|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		unset($memberArr);
		$this->load->model('membermodel');
		switch($_POST['member']){
			case "all":
				$key = get_shop_key();
				$query = $this->db->query("select member_seq from fm_member where status != 'withdrawal'");
				foreach($query->result_array() as $v){
					$memberArr[] = $v['member_seq'];
				}
				break;
			case "search":
				//echo urldecode($_POST["serialize"]);
				$tempArr = explode("&",urldecode($_POST["serialize"]));
				foreach($tempArr as $k){
					$tmp = explode("=",$k);
					if($tmp[1]){
						$sc[$tmp[0]] = $tmp[1];
					}
				}
				$data = $this->membermodel->admin_search_list($sc);
				$memberArr = $data['result'];
				break;
			case "select":
				$memberArr = explode(",", $_POST["serialize"]);
				unset($memberArr[0]);
				break;
			case "excel":
				break;
		}

		$_POST['type'] = 'direct';
		$_POST['manager_seq'] = $this->managerInfo['manager_seq'];//마일리지 수동지급시 관리자정보추가
		if($_POST['reserve_select']){
			if($_POST['reserve_select']=='year'){
				$_POST['limit_date'] = $_POST['reserve_year']."-12-31";
			}else{
				$_POST['limit_date'] = date("Y-m-d", mktime(0,0,0,date("m")+$_POST['reserve_direct'][$i], date("d"), date("Y")));
			}
		}
		foreach($memberArr as $k){
			$this->membermodel->emoney_insert($_POST, $k);
		}

		$callback = "parent.location.reload(); parent.document.getElementById('container').src='../member/emoney_form';";
		openDialogAlert("마일리지가 적용 되었습니다.",400,140,'parent',$callback);
		exit;
	}

	public function set_point(){
		### Validation
		if($_POST['send_member'] < 1){
			$callback = "";
			openDialogAlert('선택된 회원이 없습니다.',400,140,'parent',$callback);
			exit;
		}
		### Validation
		$this->validation->set_rules('point', '포인트','trim|required|xss_clean');
		$this->validation->set_rules('memo', '사유','trim|required|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		unset($memberArr);
		$this->load->model('membermodel');
		switch($_POST['member']){
			case "all":
				$key = get_shop_key();
				$query = $this->db->query("select member_seq from fm_member where status != 'withdrawal'");
				foreach($query->result_array() as $v){
					$memberArr[] = $v['member_seq'];
				}
				break;
			case "search":
				//echo urldecode($_POST["serialize"]);
				$tempArr = explode("&",urldecode($_POST["serialize"]));
				foreach($tempArr as $k){
					$tmp = explode("=",$k);
					if($tmp[1]){
						$sc[$tmp[0]] = $tmp[1];
					}
				}
				$data = $this->membermodel->admin_search_list($sc);
				$memberArr = $data['result'];
				break;
			case "select":
				$memberArr = explode(",", $_POST["serialize"]);
				unset($memberArr[0]);
				break;
			case "excel":
				break;
		}

		$_POST['type'] = 'direct';
		$_POST['manager_seq'] = $this->managerInfo['manager_seq'];//마일리지 수동지급시 관리자정보추가
		if($_POST['reserve_select']){
			if($_POST['reserve_select']=='year'){
				$_POST['limit_date'] = $_POST['reserve_year']."-12-31";
			}else{
				$_POST['limit_date'] = date("Y-m-d", mktime(0,0,0,date("m")+$_POST['reserve_direct'][$i], date("d"), date("Y")));
			}
		}
		foreach($memberArr as $k){
			$this->membermodel->point_insert($_POST, $k);
		}

		$callback = "parent.location.reload(); parent.document.getElementById('container').src='../member/point_form';";
		openDialogAlert("포인트가 적용 되었습니다.",400,140,'parent',$callback);
		exit;
	}

	public function emoney_detail(){
		### Validation
		$this->validation->set_rules('emoney', '마일리지','trim|required|xss_clean');
		$_POST['memo'] = $_POST['memo_type']=='direct' ? $_POST['memo_direct'] : $_POST['memo_type'];
		$this->validation->set_rules('memo', '사유','trim|required|xss_clean');
		if($_POST['send_sms']=='Y'){
			$this->validation->set_rules('cellphone', '핸드폰번호','trim|required|xss_clean');
			$this->validation->set_rules('msg', '메세지','trim|required|xss_clean');
		}
		###
		if($_POST['reserve_select']=='year'){
			$this->validation->set_rules('reserve_year', '지급연도','trim|required|max_length[4]|min_length[4]|numeric|xss_clean');

		}else if($_POST['reserve_select']=='direct'){
			$this->validation->set_rules('reserve_direct', '제한개월','trim|required|max_length[4]|min_length[1]|numeric|xss_clean');
		}
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		$_POST['type'] = 'direct';
		$this->load->model('membermodel');

		$_POST['manager_seq'] = $this->managerInfo['manager_seq'];
		if($_POST['reserve_select']){
			if($_POST['reserve_select']=='year'){
				$_POST['limit_date'] = $_POST['reserve_year']."-12-31";
			}else{
				$_POST['limit_date'] = date("Y-m-d", mktime(0,0,0,date("m")+$_POST['reserve_direct'][$i], date("d"), date("Y")));
			}
		}
		$this->membermodel->emoney_insert($_POST, $_POST['member_seq']);

		$sms_result = "";
		if($_POST['send_sms']=='Y'){
			$basic = config_load('basic');
			require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
			$sms_send	= new SMS_SEND();
			$from_sms	= preg_replace("/[^0-9]/", "", $basic['companyPhone']);
			$dataTo[0]["phone"] = $_POST['cellphone'];
			$sms_send->to		= $dataTo;
			$sms_send->from		= $from_sms;
			$result = $sms_send->send($_POST["msg"]);
			$msg	= $sms_send->msg;
			if(!$result) $sms_result = "<br> SMS : ".$msg;
		}

		$callback = "parent.emoney_pop();parent.location.reload();";
		openDialogAlert("마일리지가 적용 되었습니다.".$sms_result,400,140,'parent',$callback);
		exit;
	}


	public function point_detail(){
		### Validation
		$this->validation->set_rules('point', '포인트','trim|required|xss_clean');
		$_POST['memo'] = $_POST['memo_type']=='direct' ? $_POST['memo_direct'] : $_POST['memo_type'];
		$this->validation->set_rules('memo', '사유','trim|required|xss_clean');
		if($_POST['send_sms']=='Y'){
			$this->validation->set_rules('cellphone', '핸드폰번호','trim|required|xss_clean');
			$this->validation->set_rules('msg', '메세지','trim|required|xss_clean');
		}

		###
		if($_POST['reserve_select']=='year'){
			$this->validation->set_rules('reserve_year', '지급연도','trim|required|max_length[4]|min_length[4]|numeric|xss_clean');

		}else if($_POST['reserve_select']=='direct'){
			$this->validation->set_rules('reserve_direct', '제한개월','trim|required|max_length[4]|min_length[1]|numeric|xss_clean');
		}

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		$_POST['type'] = 'direct';
		$this->load->model('membermodel');

		$_POST['manager_seq'] = $this->managerInfo['manager_seq'];
		if($_POST['reserve_select']){
			if($_POST['reserve_select']=='year'){
				$_POST['limit_date'] = $_POST['reserve_year']."-12-31";
			}else{
				$_POST['limit_date'] = date("Y-m-d", mktime(0,0,0,date("m")+$_POST['reserve_direct'][$i], date("d"), date("Y")));
			}
		}
		$this->membermodel->point_insert($_POST, $_POST['member_seq']);

		$sms_result = "";
		if($_POST['send_sms']=='Y'){
			$basic = config_load('basic');
			require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
			$sms_send	= new SMS_SEND();
			$from_sms	= preg_replace("/[^0-9]/", "", $basic['companyPhone']);
			$dataTo[0]["phone"] = $_POST['cellphone'];
			$sms_send->to		= $dataTo;
			$sms_send->from		= $from_sms;
			$result = $sms_send->send($_POST["msg"]);
			$msg	= $sms_send->msg;
			if(!$result) $sms_result = "<br> SMS : ".$msg;
		}

		$callback = "parent.emoney_pop();parent.location.reload();";
		openDialogAlert("포인트가 적용 되었습니다.".$sms_result,400,140,'parent',$callback);
		exit;
	}

	public function sms_pop(){
		### Validation
		$this->validation->set_rules('cellphone', '핸드폰번호','trim|required|xss_clean');
		$this->validation->set_rules('msg', '메세지','trim|required|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		if($_POST['send_sms']=='Y'){
			$basic = config_load('basic');
			require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
			$sms_send	= new SMS_SEND();
			$from_sms	= preg_replace("/[^0-9]/", "", $basic['companyPhone']);
			$dataTo[0]["phone"] = $_POST['cellphone'];
			$sms_send->to		= $dataTo;
			$sms_send->from		= $from_sms;

			###
			$str = trim($_POST["msg"]);
			$euckr_str = mb_convert_encoding($str,'EUC-KR','UTF-8');
			$len = strlen($euckr_str);
			$size = ceil($len/80);
			$start_num	= 0;
			$cut_num	= 80;
			$send_cnt	= 0;
			/*
			for($i=0;$i<$size;$i++){
				$temp_str	= substr($euckr_str, $start_num, $cut_num);
				$iconv_str	= iconv('EUC-KR','UTF-8',$temp_str);
				if(!trim($iconv_str)){
					$cut_num--;
					$temp_str	= substr($euckr_str, $start_num, $cut_num);
					$iconv_str	= iconv('EUC-KR','UTF-8',$temp_str);
				}
				$start_num	+= $cut_num;
				$cut_num	= 80;

				$result		= $sms_send->send($iconv_str);
				$send_cnt++;
			}
			*/
			$result		= $sms_send->send($str);
			$result_msg	= $sms_send->msg;
		}
		$callback = "parent.closeDialog('sendPopup');";
		openDialogAlert($result_msg,400,140,'parent',$callback);
		exit;
	}

	public function email_pop(){
		$this->validation->set_rules('title', '제목','trim|required|max_length[100]|xss_clean');
		$this->validation->set_rules('contents', '내용','trim|required|xss_clean');
		$this->validation->set_rules('email', '받는사람','trim|required|max_length[50]|valid_email|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		###
		$this->load->model('usedmodel');
		$email_chk = $this->usedmodel->hosting_check();

		###
		$total = 1;
		$toMonth = date("Y-m");
		$sql = "select sum(total) as count from fm_log_email where regdate like '{$toMonth}%'";
		$query = $this->db->query($sql);
		$emailData = $query->result_array();
		$usedMail	= $emailData[0]['count'] + $total;
		if(3000 < $usedMail  && !$email_chk){
			$callback = "";
			openDialogAlert('본 이메일 발송 기능은 월 3,000통 발송이 가능합니다.<br>더 많은 이메일 발송은 대량발송 서비스를 이용해 주십시오.',400,140,'parent',$callback);
			exit;
		}
		###
		$basic = config_load('basic');
		//sendDirectMail($mailArr, $_POST['send_email'], $_POST['title'], $_POST['contents']);
		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/Email_send.class.php";
		$mail = new Mail(isset($params));
		$body = adjustEditorImages($_POST['contents']);
		if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)!=false){
			$headers['From']		= !$basic['companyEmail'] ? 'gabia@gabia.com' : $basic['companyEmail'];
			$headers['Name']		= !$basic['companyName'] ? get_connet_protocol().$_SERVER['HTTP_HOST'] : $basic['companyName'];
			$headers['Subject']		= $_POST['title'];
			$headers['To']			= $_POST['email'];
			$resSend				= $mail->send($headers, $body);
		}

		### LOG
		$params['regdate']		= date('Y-m-d H:i:s');
		$params['gb']			= 'MANUAL';
		$params['total']		= $total;
		$params['from_email']	= $basic['companyEmail'];
		$params['subject']		= $_POST['title'];
		$params['contents']		= $body;
		$data = filter_keys($params, $this->db->list_fields('fm_log_email'));
		$result = $this->db->insert('fm_log_email', $data);

		### MASTER
		config_save('master',array('mail_count'=>(3000 - $usedMail)));

		$callback = "parent.closeDialog('sendPopup');";
		$msg = "메일이 발송 되었습니다.";
		openDialogAlert($msg,400,140,'parent',$callback);
		exit;
	}


	public function sms_excel(){
		echo "EXCEL";
	}

	public function sms_auth(){
		#### AUTH
		$auth = $this->authmodel->manager_limit_act('member_act');
		if(!$auth){
			$callback = "";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		### Validation
		$this->validation->set_rules('sms_auth', 'SMS 인증번호','trim|required|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		config_save('master',array('sms_auth'=>$_POST['sms_auth']));

		###
		$callback = "parent.location.reload();";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}


	public function getAuthPopup(){
		$result = "";
		if($_GET['type']=='A'){
			$result = "<table width='100%' cellspacing='0'>";
			$result .= "<tr><td>";
			$result .= "<div style='color:red;'>SMS 충전하기 위해서는 SMS 계정이 필요합니다. SMS 계정을 만들어 주세요!</div>";
			$result .= "</td></tr>";
			$result .= "<tr><td>";
			$result .= "<div class='description'>SMS 계정은 가비아 홈페이지 > 마이가비아 > 쇼핑몰관리에서 만들 수 있습니다. <span class='btn small gray center'><button type='button' onclick=\"window.open('https://firstmall.kr/myshop/index.php','','');\">SMS 계정만들기</button></span></div>";
			$result .= "</td></tr>";
			$result .= "</table>";
		}else if($_GET['type']=='B'){
			$result = "<table width='100%' cellspacing='0'>";
			$result .= "<tr><td>";
			$result .= "<div style='color:red;'>SMS 서비스를 안전하게 이용하기 위하여 SMS 인증번호를 입력해 주세요! (최초 1회 또는 변경 가능)</div>";
			$result .= "</td></tr>";
			$result .= "<tr><td>";
			$result .= "<div class='description'>SMS 인증번호를 받기 위해서는 SMS 계정이 필요합니다. 아직 SMS계정이 없다면 계정부터 만들어 주세요! <span class='btn small gray center'><button type='button' onclick=\"window.open('http://link.firstmall.kr?link=myshop/','','');\">SMS 계정만들기</button></span></div>";
			$result .= "</td></tr>";
			$result .= "<tr><td>";
			$result .= "<div class='description'>SMS 인증번호는 가비아 홈페이지 >  마이가비아 > 쇼핑몰관리에서 받을 수 있습니다.  <span class='btn small gray center'><button type='button' onclick=\"window.open('http://link.firstmall.kr?link=myshop/','','');\">SMS 인증번호 받기</button></span></div>";
			$result .= "</td></tr>";
			$result .= "<tr><td>";
			$result .= "<div class='description'>SMS 인증번호을 받으셨다면 SMS 인증번호를 입력해 주세요. <span class='btn small gray center'><button type='button' onclick=\"parent.location.href='sms_auth'\">SMS 인증번호 입력하기</button></span></div>";
			$result .= "</td></tr>";
			$result .= "<tr><td height='10'></td></tr>";
			$result .= "<tr><td>";
			$result .= "<div class='description'>바로가기 클릭시 가비아로그인이 필요하며, 쇼핑몰관리페이지에서 SMS인증번호를 발급받아야하는 쇼핑몰도메인 '서비스관리>SMS서비스-관리'를 클릭하시면 됩니다.</div>";
			$result .= "</td></tr>";
			$result .= "</table>";
		}else if($_GET['type']=='C'){
			$result = "<table width='100%' cellspacing='0'>";
			$result .= "<tr><td>";
			$result .= "<div class='description'>SMS 인증번호는 가비아 홈페이지 >  마이가비아 > 쇼핑몰관리에서 받을 수 있습니다.  <span class='btn small gray center'><button type='button' onclick=\"window.open('http://link.firstmall.kr?link=myshop/','','');\">SMS 인증번호 받기</button></span></div>";
			$result .= "</td></tr>";
			$result .= "<tr><td>";
			$result .= "<div class='description'>SMS 인증번호을 받으셨다면 SMS 인증번호를 입력해 주세요. <span class='btn small gray center'><button type='button' onclick=\"parent.location.href='sms_auth'\">SMS 인증번호 입력하기</button></span></div>";
			$result .= "</td></tr>";
			$result .= "<tr><td height='10'></td></tr>";
			$result .= "<tr><td>";
			$result .= "<div class='description'>바로가기 클릭시 가비아로그인이 필요하며, 쇼핑몰관리페이지에서 SMS인증번호를 발급받아야하는 쇼핑몰도메인 '서비스관리>SMS서비스-관리'를 클릭하시면 됩니다.</div>";
			$result .= "</td></tr>";
			$result .= "</table>";
		}
		echo $result;
	}

	public function getExcelPopup(){
		$result = "";
		$result .= "<form name='popForm' method='post' action='../member_process/sms_excel' target='actionFrame'>";
		$result .= "<table width='100%' cellspacing='0'>";
		$result .= "<tr><td>";
		$result .= "▶ 엑셀 데이터 발송 안내<br/>";
		$result .= "SMS 발송 대상을 엑셀 데이터로 등록할 수 있습니다.<br/>";
		$result .= "엑셀 양식을 다운로드 받아 형식에 맞게 데이터를 입력해 주세요. ";
		$result .= "</td></tr>";
		$result .= "<tr><td>";
		$result .= "▶ 엑셀 데이터 입력 방법<br/>";
		$result .= "1. 기본적으로 다운로드 받은 엑셀 약식을 유지한 후 데이터만 입력<br/>";
		$result .= "2. 반드시 A열에는 이름, B열에는 핸드폰번호를 입력<br/>";
		$result .= "3. 반드시 핸드폰번호는 '-'를 포함하여 입력<br/>";
		$result .= "예시) 010-123-4567<br/>";
		$result .= "4. 입력완료 후 엑셀파일 저장 형식을 *.xls로 저장 ";
		$result .= "</td></tr>";
		$result .= "<tr><td>";
		$result .= "▶ 엑셀 파일 업로드<br/>";
		$result .= "<input type='file' name=''>";
		$result .= "</td></tr>";
		$result .= "</table>";
		$result .= "<span class='btn small gray center'><button type='button' onclick='document.popForm.submit();'>확인</button></span>";
		$result .= "</form>";
		echo $result;
	}

	public function amail(){
		#### AUTH
		$auth = $this->authmodel->manager_limit_act('member_act');
		if(!$auth){
			$callback = "";
			openDialogAlert($this->auth_msg,400,140,'parent',$callback);
			exit;
		}

		### Validation
		$this->validation->set_rules('name', '이름','trim|required|max_length[100]|xss_clean');
		$this->validation->set_rules('email', '이메일','trim|required|max_length[64]|valid_email|xss_clean');
		$this->validation->set_rules('phoneArr[0]', '전화번호','trim|required|max_length[4]|numeric|xss_clean');
		$this->validation->set_rules('phoneArr[1]', '전화번호','trim|required|max_length[4]|numeric|xss_clean');
		$this->validation->set_rules('phoneArr[2]', '전화번호','trim|required|max_length[4]|numeric|xss_clean');
		$this->validation->set_rules('mobileArr[0]', '휴대폰','trim|required|max_length[4]|numeric|xss_clean');
		$this->validation->set_rules('mobileArr[1]', '휴대폰','trim|required|max_length[4]|numeric|xss_clean');
		$this->validation->set_rules('mobileArr[2]', '휴대폰','trim|required|max_length[4]|numeric|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		### SAVE
		$phone		= implode("-",$_POST['phoneArr']);
		$cellphone	= implode("-",$_POST['mobileArr']);
		config_save('email_mass',array('name'=>$_POST['name']));
		config_save('email_mass',array('email'=>$_POST['email']));
		config_save('email_mass',array('phone'=>$phone));
		config_save('email_mass',array('cellphone'=>$cellphone));

		$callback = "";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
		exit;
	}


	public function amail_send_set(){
		ini_set("memory_limit",-1);
		set_time_limit(0);

		###
		$cid = preg_replace("/-/","", $this->config_system['service']['cid']);

		###
		$params = "";
		$anp = "";
		$first_yn = "Y";
		$cnt = 0;
		$subCnt = 0;
		$groupName = "SIMPLE MAIL";

		unset($mailArr);
		$mailArr = explode(",", $_GET["no"]);
		unset($mailArr[0]);

		###
		if(isset($_GET['add_num_chk'])!='Y'){
			$key = get_shop_key();
			switch($_GET['member']){
				case "all":
					$query = $this->db->query("select AES_DECRYPT(UNHEX(email), '{$key}') as email from fm_member where status != 'withdrawal' and email<>'' ");// and mailing = 'y'
					$data = $query->result_array();
					if(count($data)>0){
						foreach($data as $k){
							array_push($mailArr,$k['email']);
						}
					}
					break;
				case "search":
					foreach($_GET as $keyval => $value){
							$sc[$keyval] = $value;
						}
					//$sc['mailing'] = 'y';
					$this->load->model('membermodel');
					$data = $this->membermodel->admin_search_list($sc);
					if(count($data['result'])>0){
						foreach($data['result'] as $k){
							array_push($mailArr,$k['email']);
						}
					}
					break;
				case "select":
					foreach($_GET as $keyval => $value){
						if($keyval == 'member_chk'){
							foreach($value as $keyval2 => $member_seq){
								$sql = "select AES_DECRYPT(UNHEX(email), '{$key}') as email from fm_member where member_seq = '".$member_seq."' and email<>'' ";
								$query = $this->db->query($sql);
						$data = $query->result_array();
						if($data[0]['email']) array_push($mailArr,$data[0]['email']);
							}
						}
					}
					break;
				case "excel":
					break;
			}

		}

		###
		if($mailArr){
			foreach($mailArr as $v){
				$params .= $anp."mid[".$cnt."]=".addslashes($v)."&email[".$cnt."]=".addslashes($v)."&name[".$cnt."]=".addslashes($v);

				if($subCnt % 1000 != 0 || $subCnt == 0){
					$cnt++;
				} else {
					$params .= "&first_yn=".$first_yn."&domain=".addslashes($_SERVER["SERVER_NAME"])."&userid=".$cid."&groupName=".$groupName."\n";

					$this->setEmails($params);

					$params = "";
					$first_yn = "N";
					$anp = "";
					$cnt = 0;

				}
				$anp = "&";
				$subCnt++;
			}

			$params .= "&first_yn=".$first_yn."&domain=".addslashes($_SERVER["SERVER_NAME"])."&userid=".$cid."&groupName=".$groupName."\n";
			$this->setEmails($params);

			$mailEndCnt = $this->getEmailCnt($cid);

			if($cnt > 0) $result = array("result"=>TRUE, "msg"=>$mailEndCnt."개의 이메일이 세팅되어졌습니다.");
			else $result = array("result"=>FALSE, "msg"=>"이메일 셋팅에 실패하였습니다.");
		}else{
			$result = array("result"=>FALSE, "msg"=>"전송할 회원이 없습니다.");
		}
		echo "[".json_encode($result)."]";
	}

	public function setEmails($params) {

		$fp = fsockopen ("amail.firstmall.kr", 80);
		$strLen =  strlen($params);

		fputs($fp,"POST http://amail.firstmall.kr/new_amail.input.php HTTP/1.0\n");
		fputs($fp,"User-Agent: navyism\n");
		fputs($fp,"Content-type: application/x-www-form-urlencoded\n");
		fputs($fp,"Content-length: ".$strLen."\n");
		fputs($fp,"\n");
		fputs($fp,$params);
		fputs($fp,"\n");

		while(! feof ($fp))
		{
			$file = fgets ($fp, 1024);
		}
		fclose ($fp);

		return $file;
	}


	public function iconUpload(){
		$this->load->library('Upload');
		if (is_uploaded_file($_FILES['grade_icon']['tmp_name'])) {
			$config['upload_path']		= $path = ROOTPATH."/data/icon/common/";
			$file_ext = end(explode('.', $_FILES['grade_icon']['name']));//확장자추출
			$config['allowed_types']	= 'jpg|gif|jpeg|png';
			$config['overwrite']			= TRUE;
			$config['file_name']			= substr(microtime(), 2, 6).'.'.$file_ext;
			$this->upload->initialize($config);

			if ($this->upload->do_upload('grade_icon')) {
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



	public function getEmailCnt($cid) {
		$params = "userid=".$cid."";

		$fp = fsockopen ("amail.firstmall.kr", 80);
		$strLen =  strlen($params);

		fputs($fp,"POST http://amail.firstmall.kr/getEmailCnt.php HTTP/1.0\n");
		fputs($fp,"User-Agent: navyism\n");
		fputs($fp,"Content-type: application/x-www-form-urlencoded\n");
		fputs($fp,"Content-length: ".$strLen."\n");
		fputs($fp,"\n");
		fputs($fp,$params);
		fputs($fp,"\n");

		while(! feof ($fp))
		{
			$file = fgets ($fp, 1024);
		}
		fclose ($fp);

		return $file;
	}
}

/* End of file setting_process.php */
/* Location: ./app/controllers/selleradmin/setting_process.php */