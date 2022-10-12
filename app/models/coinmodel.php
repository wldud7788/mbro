<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coinmodel extends CI_Model {

	public function __construct()
	{
		// 비정상적인 접근을 방지 
		//parent::__construct();
	}	

	public function index()
	{
		// 세션에 저장된 회원의 변수 
		$member_seq = $_SESSION['user']['member_seq'];
		
		// fm_coin에서 각 멤버에 맞는 리스트 불러오기 
		$sql = "SELECT * FROM fm_coin WHERE member_seq = {$member_seq}";
		
		// 쿼리로 가져와서, 그걸 배열화 시킨다. 
		$query = $this->db->query($sql);
		$coindata = $query->result_array();

		return $coindata;
	}

    public function insert($data) {
        $result = $this->db->insert('fm_coin_event', $data);
    }

    public function admin_search() {
        $this->db->select('*');
        $this->db->from('fm_coin_event');
        $this->db->order_by('id');

        $q = $this->db->get()->result_array();

        return $q;
    }

    public function admin_update($dbname, $data, $where) {
	    $this->db->update($dbname, $data, $where);

    }

    public function search($select, $dbname, $where) {
	    $this->db->select($select);
	    $this->db->from($dbname);
	    $this->db->where($where);

        $query = $this->db->get()->result_array();

        return $query;
    }

    public function search_where($type, $keyword, $status_where, $wait, $comp) {

        $this->db->select('*');
        $this->db->from('fm_coin_event');
        $this->db->like($type, $keyword);
        $this->db->where($status_where);
        $this->db->where('created_at between'.$wait);
        $this->db->where('updated_at between'.$wait);
        $this->db->order_by('id');

        $q = $this->db->get()->result_array();
        return $q;
    }

	// 현재 시세 조회 coin_notice 에서 사용
    public function value() {
		$sql = "SELECT * FROM `fm_coin_quotes` ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		$row = $query->row_array(); // db쿼리해서 가져온 것 배열화
		
		return $row;
	}

	// 해당 유저 코인 전환 기록 확인
    public function chk_user($member_seq) {
	    $this->db->select("count('*') as cnt");
	    $this->db->from('fm_coin');
	    $this->db->where('member_seq', $member_seq);

        $query = $this->db->get()->result_array();

        return $query;
    }

	// 마이페이지 내 코인 전환조회
    public function member_search($member_seq) {
        $sql = "
			SELECT *
			FROM fm_coin
			WHERE
				member_seq='{$member_seq}'
			ORDER BY od_num DESC
		";

        $query = $this->db->query($sql,$member_seq);
        $row = $query->row_array(); // db쿼리해서 가져온 것 배열화

        return $row;
    }

}
?>