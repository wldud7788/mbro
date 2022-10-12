<?php
class Myminishopmodel extends CI_Model {

	public function myminishop_list($sc) {

		$sql = "select m.*,p .* from fm_member_minishop m, fm_provider p "
				. "where m.member_seq = ". $sc['member_seq'] . " and m.provider_seq = p.provider_seq "
				. "group by m.provider_seq order by p.provider_name asc";

		$result = select_page($sc['perpage'],$sc['page'],10,$sql,array());
		$result['page']['querystring'] = get_args_list();
		return $result;
	}

	// 총건수
	public function get_myminishop_total_count($sc = null)
	{
		$sql = 'select  SQL_CALC_FOUND_ROWS * from fm_member_minishop ';
		$sql .= " where member_seq = '".$sc[member_seq]."' ";
 		$this->db->query($sql);
		return mysqli_affected_rows();
	}

	// 총건수
	public function get_provider_minishop_count($sc = null)
	{
		$sql = 'select  count(*) cnt from fm_member_minishop ';
		$sql .= " where provider_seq = ?";
		return $this->db->query($sql, $sc['provider_seq']);
	}


	// TODO(kjw) : change to response type - boolean
	public function chk_myminishop($member_seq, $provider_seq){
		$sql	= "select * from fm_member_minishop where member_seq = ? and provider_seq = ?";
		$query	= $this->db->query($sql,array($member_seq, $provider_seq));
		$row	= $query->row_array();

		$response = "n";
		
		if ($row['provider_seq']) {
			$response = 'y';
		}
		
		return $response;
	}

	public function get_myminishop($member_seq){
		$sField		= '';
		$sTable		= '';
		$sWhere	= '';
		$sOrderby	= '';
		if($member_seq){
			$sTable = " LEFT JOIN fm_member_minishop m ON m.provider_seq = p.provider_seq";
			$sField = ", m.member_seq";
			$sWhere = "m.member_seq = ? AND ";
			$sOrderby = "m.member_seq DESC, ";
			$bind[] = $member_seq;
		}
		$sql	= "select p.provider_seq, p.provider_name".$sField." from fm_provider p".$sTable
				. " where ".$sWhere."p.provider_status = ? AND p.provider_group is Null"
				. " order by ".$sOrderby."p.provider_name asc";
		$bind[] = 'Y';
		$query	= $this->db->query($sql,$bind);
		$myshop	= $query->result_array();

		return $myshop;
	}

	public function add_myminishop(){

		$insert_params['member_seq'] 			= $_POST['seq'];
		$insert_params['provider_seq'] 			= $_POST['shop_no'];
		$insert_params['memo'] 					= $_POST['memo'];
		$insert_params['regist_date'] 			= date("Y-m-d H:i:s");
		$this->db->insert('fm_member_minishop', $insert_params);
		$this->db->insert_id();

	}

	public function delete_myshop($member_seq, $provider_seq){
		if	($member_seq && $provider_seq){
			$whereArr	= array('member_seq'=>$member_seq, 'provider_seq'=>$provider_seq);
			$this->db->delete('fm_member_minishop', $whereArr);
		}
	}

	public function update_myshop_memo($params){
		if	($params['member_seq'] && $params['provider_seq']){
			$whereArr		= array('member_seq'=>$params['member_seq'],
									'provider_seq'=>$params['provider_seq']);
			$upArr['memo']	= addslashes($params['memo']);
			$this->db->update('fm_member_minishop', $upArr, $whereArr);
		}
	}

	public function get_minishop_list($member_seq){
		$sql	= "select * from
						fm_member_minishop m
						INNER JOIN fm_provider p on m.provider_seq = p.provider_seq
					where member_seq = '".$member_seq."' ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getProvider($provider_seq)
	{

		$sQuery = "select p.provider_seq, p.provider_name, p.minishop_introdution, p.info_name, p.minishop_goods_info_image, p.minishop_status, p.minishop_search_filter, p.minishop_orderby, p.goods_info_style , count(m.member_seq) cnt from fm_provider p left join fm_member_minishop m on p.provider_seq = m.provider_seq where p.provider_seq = ? group by provider_seq";
		$rQuery = $this->db->query($sQuery, array($provider_seq));
		list($result) = $rQuery->result_array();
		return $result;
	}
}

/* End of file myminishopmodel.php */
/* Location: ./app/models/myminishopmodel */