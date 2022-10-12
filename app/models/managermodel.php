<?php

class managermodel extends CI_Model {
	public function __construct()
	{
		$this->cach_file_path	= ROOTPATH . 'data/cach/action_alert.html';
		$this->table			= 'fm_manager';
	}

	public function get_query_builder() {
		return (clone $this->db)
			->reset_query()
			->from($this->table)
			->where('manager_id !=', 'gabia');
	}

	public function find(string $id) {
		return $this->get_query_builder()
			->where('manager_id', $id)
			->limit(1)
			->get()
			->row_object();
	}

	public function update($data, $id = null) {
		if($id === null) return;
		$db = $this->get_query_builder();
		if(!$db->where('manager_id', $id)->update($this->table, $data)) throw new DatabaseException($db->error());
		return true;
	}

	public function get_manager($manager_seq){
		$bind[] = $manager_seq;
		$query = "select * from fm_manager where manager_seq=?";
		$query = $this->db->query($query,$bind);
		$row = $query->row_array();
		return $row;
	}

	public function get_manager_by_id($id)
	{
	    $query = $this->managermodel->get(array('manager_id' => $id));
	    return $query->row_array();
	}

	public function get($params='', $limit='', $offset=''){
		return $this->db->get_where($this->table, $params, $limit, $offset);
	}

	public function get_lastlogin_date(){
		$query = $this->db->query("select date_format(lastlogin_date,'%Y-%m-%d') as lastlogin_date from fm_manager order by lastlogin_date desc limit 1");
		return $query;
	}

	public function update_passwd($manager_seq,$passwd){

		$log = "<div>".date("Y-m-d H:i:s")." 비밀번호가 변경되었습니다. (".$_SERVER['REMOTE_ADDR'].")</div>";

		$str_md5 = md5($passwd);
		$str_sha256_md5 = hash('sha256',$str_md5);

		$bind[] = $str_sha256_md5;
		$bind[] = $log;
		$bind[] = $manager_seq;
		$query = "update fm_manager set mpasswd=?,manager_log=concat(?,manager_log),passwordUpdateTime=now() where manager_seq=?";
		$query = $this->db->query($query,$bind);
	}

	public function update_date($manager_seq)
	{
		$log = "<div>".date("Y-m-d H:i:s")." 90일 이후 비밀번호 변경으로 설정하였습니다. (".$_SERVER['REMOTE_ADDR'].")</div>";
		$bind[] = $log;
		$bind[] = $manager_seq;
		$query = "update fm_manager set passwordUpdateTime=now(),manager_log=concat(?,manager_log) where manager_seq=?";
		$query = $this->db->query($query,$bind);
	}

	// 마지막 비밀번호변경 경과일수 반환
	public function chk_change_pass_day($manager_seq){
		$data_manager = $this->get_manager($manager_seq);

		if( $data_manager['passwordUpdateTime'] == '0000-00-00 00:00:00' ) $data_manager['passwordUpdateTime'] = $data_manager['mregdate'];

		$change_pass_day = (time()-strtotime($data_manager['passwordUpdateTime'])) / (24*3600);

		return (int)$change_pass_day;
	}

	public function insert_action_history($manager_seq,$action_type,$add_message=''){
		/*
		pg_setting	전자결제설정저장
		bank_setting	무통장입금계좌저장
		member_excel_download	회원엑셀다운로드실행
		secret_key_setting	보안키저장
		member_excel_download_auth	회원엑셀다운로드권한부여
		member_excel_download_pwchg	회원엑셀다운로드비번변경
		sns_nid_api_setting	네아로 API 신청/업데이트
		*/

		$codes = code_load('manager_action');

		foreach($codes as $code){
			if($code['codecd']==$action_type){
				$action_message = $code['value'];
			}
		}

		if($add_message && $action_type != 'marketing_agree_send_log'){
		    $action_message .= ' - '.$add_message;
		}

		if	(!$action_message)	$action_message	= '';

		if ($action_type == 'marketing_agree_send_log') {
		    $bind = array(
		        $manager_seq,
		        '0.0.0.0',
		        $action_type,
		        $add_message
		    );
		} else {
		    $bind = array(
		        $manager_seq,
		        $_SERVER['REMOTE_ADDR'],
		        $action_type,
		        $action_message
		    );
		}

		$sql = "insert into fm_manager_action_history set
		manager_seq = ?,
		ip = ?,
		action_type = ?,
		action_message = ?,
		regist_date = now()
		";
		$this->db->query($sql,$bind);

		$this->make_action_alert_cache();
	}

	public function make_action_alert_cache(){
		$sql = "select *,(select value from fm_code where groupcd='manager_action' and codecd=a.action_type) as action_message from (select * from fm_manager_action_history where regist_date>=DATE_ADD(CURDATE(), INTERVAL -7 DAY) order by regist_date desc) a group by a.action_type order by regist_date desc";
		$query = $this->db->query($sql);
		$html = '';
		$action_history_data = $query->result_array();
		if($action_history_data){
			$html = json_encode($action_history_data);
		}
		@file_put_contents($this->cach_file_path,$html);
		@chmod($this->cach_file_path,0777);
	}

	// 관리자 세션 삭제
	public function logout(){
		$this->session->unset_userdata('manager');
		$_COOKIE['shopReferer'] = '';
		$this->load->helper("cookie");
		delete_cookie('shopReferer');
	}

	## 권한저장용 변수 합치기
	public function manager_auth_list($tmp_auth=''){
		if(!$tmp_auth){
			$this->load->model('authmodel');
			$tmp_auth	= $this->authmodel->make_auth_list();
		}
		foreach($tmp_auth as $k=>$v){
			$tmp[] = $k.'='.$v;
		}
		$auth		= implode('||', $tmp);
		return $auth;
	}

	//
	public function getAccountSettingManagerList(){
		$query = "select manager_seq, manager_id, mname, mregdate from fm_manager";
		$query = $this->db->query($query);
		$row = $query->result_array();
		$data = array();
		foreach($row as $datarow){
			$data[$datarow['manager_seq']] = $datarow;
		}
		return $data;
	}

	public function check_manager_pwd_history($manager_seq,$passwd) {
		$str_md5 = md5($passwd);
		$str_sha256_md5 = hash('sha256',$str_md5);

		$bind[] = $manager_seq;
		$bind[] = $str_md5;
		$bind[] = $str_sha256_md5;
		$sql = "select count(*) as cnt from (select * from fm_manager_pwd_history where manager_seq=? order by regist_date desc limit 2) a where a.pwd=? or a.pwd=?;";
		$query = $this->db->query($sql,$bind);
		$row = $query->row_array();
		return $row;
	}

	public function insert_manager_pwd_history($manager_seq,$passwd) {
		$str_md5 = md5($passwd);
		$str_sha256_md5 = hash('sha256',$str_md5);

		$bind[] = $manager_seq;
		$bind[] = $str_sha256_md5;
		$sql = "insert into fm_manager_pwd_history set manager_seq=?, pwd=?, regist_date=now()";
		$this->db->query($sql,$bind);
	}

	public function get_history($iManagerSeq){
		$sql = "select a.*, b.mname, b.manager_id from fm_manager_action_history a
			left join fm_manager b on a.manager_seq=b.manager_seq where a.manager_seq=? order by history_seq desc";
		return $this->db->query($sql, $iManagerSeq);
	}
}
