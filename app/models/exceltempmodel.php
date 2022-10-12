<?
/*
 create table `fm_excel_export_temp` (
 		`export_temp_seq` int(10) unsigned NOT NULL auto_increment,
 		`excel_str` text null,
 		PRIMARY KEY  (`export_temp_seq`)
 );
*/
class exceltempmodel extends CI_Model {
	public function get_excel_temp($excel_temp_seq)
	{
		$query = "select excel_str from `fm_excel_export_temp` where export_temp_seq=?";
		$query = $this->db->query($query,array($excel_temp_seq));
		$data = $query->row_array();
		return $data;

	}

	function truncate_excel_temp()
	{		
		truncate_to_drop('fm_excel_export_temp', $this->db->conn_id);
	}

	// 출고 결과 임시 테이블 저장
	function excel_temp_insert($excel_data){
		$excel_str = serialize($excel_data);
		$query = "insert into fm_excel_export_temp (`excel_str`) values(?)";
		$this->db->query($query,array($excel_str));
		return $this->db->insert_id();
	}
}
?>