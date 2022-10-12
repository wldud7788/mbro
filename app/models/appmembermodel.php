<?php
class AppMemberModel extends CI_Model {

    /*######################## 17.12.05 gcs yjy : 이메일 중복되지 않도록 처리 (중복이메일 확인) s */
	public function email_dupli_chk($email, $member_seq=null) {
		$key = get_shop_key();
		$where = "";

		if($member_seq) { //본인 이메일인지 체크. 본인 이메일은 검색조건에서 빼야함
			$where = " and member_seq !='".$member_seq."' ";
		}
		//$sql = "SELECT * FROM fm_member  WHERE AES_DECRYPT(UNHEX(email), '{$key}') = '".$email."' {$where} "; //쿼리속도 2.7초
		$sql = "SELECT * FROM fm_member  WHERE email = HEX(AES_ENCRYPT('{$email}', '{$key}')) {$where} "; //쿼리속도 0.02초
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) { return true; }

		//$sql2 = "SELECT * FROM fm_member_dr WHERE AES_DECRYPT(UNHEX(email), '{$key}') = '".$email."' {$where} ";
		$sql2 = "SELECT * FROM fm_member_dr WHERE email = HEX(AES_ENCRYPT('{$email}', '{$key}')){$where} ";
		$query2 = $this->db->query($sql2);
		if($query2->num_rows() > 0) { return true; }

		return false;
	}
/*######################## 17.12.05 gcs yjy : 이메일 중복되지 않도록 처리 (중복이메일 확인) e */
/*######################## 17.12.21 gcs yjy : 앱 처리 s */
    function memberInfo() {
    	$query = "select A.*,B.business_seq,B.bname,C.group_name from fm_member A LEFT JOIN fm_member_business B ON A.member_seq = B.member_seq left join fm_member_group C on C.group_seq=A.group_seq where A.member_seq ='".$this->userInfo['member_seq']."' ";
    	$qry = $this->db->query($query);
    	$mem_data = $qry->row_array();

    	//쿠폰보유건
    	/*$this->load->model('couponmodel');
    	$sc['today']			= date('Y-m-d',time());
    	$dsc['whereis'] = " and member_seq=".$mem_data['member_seq']." and use_status='unused' AND ( (issue_startdate is null  AND issue_enddate is null ) OR (issue_startdate <='".$sc['today']."' AND issue_enddate >='".$sc['today']."') )";//사용가능한
    	//$coupondownloadtotal = $this->couponmodel->get_download_total_count($dsc);*/

    	$send_params = $this->config_send_params($mem_data);

    	return $send_params;
    }

    function config_send_params($mem_data) {
        $send_params = array();

        $send_params['member_seq'] = $mem_data['member_seq'];
        $send_params['user_id'] = $mem_data['userid'];
        $send_params['user_name'] = $mem_data['user_name'];
        $send_params['session_id'] = session_id();


        if($mem_data['rute']=='naver' ) {
            $send_params['channel'] = 'nv';
        }else if($mem_data['rute']=='kakao' ) {
            $send_params['channel'] = 'kk';
        }else if($mem_data['rute']=='twitter' ) {
            $send_params['channel'] = 'tw';
        }else if($mem_data['rute']=='instagram' ) {
            $send_params['channel'] = 'it';
        }else if($mem_data['rute']=='facebook' ) {
            $send_params['channel'] = 'fb';
        }else {
            $send_params['channel'] = 'none';
        }

        if($mem_data['sns_cnage']=='1') {
            $send_params['channel'] = 'none';
        }

        $send_params['reserve'] = $mem_data['emoney'];
        $send_params['balance'] = $mem_data['cash'];
        //$send_params['coupon'] = $coupondownloadtotal;
        $send_params['api_key'] = $mem_data['api_key'];
        $send_params['auto_login'] = 'y';

        return $send_params;
    }
    function create_api_key($userid, $memberseq = 0, $is_update = false) {
        srand(floor(time() / (60*60*24)));
        $rand_id = rand(1000,9999);
        $userid = isset($userid) ? $userid : $rand_id;

        $api_key = hash('sha256',md5($userid));
        if( $is_update) {
            $this->db->query("UPDATE fm_member SET api_key = '".$api_key."' WHERE member_seq = '".$memberseq."' ");
        }

        return $api_key;
    }

/*######################## 17.12.21 gcs yjy : 앱 처리 e */

	public function get_app_member_info($member_seq,$condition=[]) {
		$key = get_shop_key();
		$query = $this->db->select("A.*, B.business_seq,B.bname,C.group_name, AES_DECRYPT(UNHEX(A.cellphone), '{$key}') as cellphone, AES_DECRYPT(UNHEX(A.email), '{$key}') as email")
		->from('fm_member A')
		->join('fm_member_business B', 'A.member_seq = B.member_seq', 'left')
		->join('fm_member_group C', 'C.group_seq = A.group_seq', 'left')
		->where('A.member_seq', $member_seq);

		if(array_key_exists('status',$condition)) {
			$query->where_in('status',$condition['status']);
		}
		
		$query = $query->get();
		$data = $query->row_array();
		return $data;
	}
}

/* End of file membermodel.php */
/* Location: ./app/models/membermodel */