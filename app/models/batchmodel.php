<?php
class batchmodel extends CI_Model {
	var $action_code = array(
		'export_complete' => 'cron_export_complete', // 출고완료 후 처리
		'export_ready' => 'cron_export_complete', // 출고준비 후 처리
		'complete_ticket' => 'cron_complete_ticket', // 쿠폰상품 출고완료 후 처리
	
	);

	/*
	create table fm_batch(
		`batch_seq` INT(11) NOT NULL AUTO_INCREMENT COMMENT '고유번호',
		`action_code` VARCHAR(20) NOT NULL COMMENT '코드',
		`params` TEXT NULL COMMENT '파라미터',
		`status` ENUM('none','ing') NOT NULL DEFAULT 'none' COMMENT '상태',
		`regist_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '등록일시',
		PRIMARY KEY (`batch_seq`)
	);

	ALTER TABLE `fm_batch` ADD INDEX `action_code` (`action_code`, `batch_seq`);
	*/

	public function insert($action_code,$params,$status){
		$query = "INSERT INTO `fm_batch` (`action_code`,`params`,`status`,`regist_date`) values(?,?,?,now())";
		$this->db->query($query,array($action_code,$params,$status));
	}

	public function del($seq){
		$query = "delete from `fm_batch` where batch_seq=?";
		$this->db->query($query,array($seq));
	}

	public function get($action_code,$status){
		$query = "select * from `fm_batch` where `action_code`='".$action_code."' and `status`='".$status."'";
		return mysqli_query($this->db->conn_id,$query);
	}

	public function update_status_ing($action_code)
	{
		$query = "update `fm_batch` set `status`='ing' where `action_code`=? and `status`='none'";
		$this->db->query($query,array($action_code));
	}
	
	public function get_data_sql_params($aParams)
	{
		$aParams['limit'] = (int) $aParams['limit'];
		return "select * from `fm_batch` b where b.`action_code`=".$this->db->escape($aParams['action_code'])." and b.`status`=".$this->db->escape($aParams['status'])." and b.`regist_date`>= ".$this->db->escape($aParams['start_date'])." and b.`regist_date`<".$this->db->escape($aParams['end_date'])." order by b.batch_seq limit ".$aParams['limit'];
	}
	
	public function update_status_ing_sql($sSql)
	{
		$sSql	= str_replace('select *', 'select b.batch_seq', $sSql);
		$query	= "update `fm_batch` c, (".$sSql.") t set c.`status` = 'ing' where c.batch_seq = t.batch_seq";
		$this->db->query($query);
	}
}
?>