<?php
/*
에러코드 설계
첫째자리 : 1 : 필수옵션,2 : 추가옵션
둘째자리 : 연결순번 1~5
10 : DATA없음,20 : DATA다름

CREATE TABLE `fm_package_error` (
	`error_seq` BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '고유번호',
	`goods_seq` INT(10) NOT NULL COMMENT '패키지 상품의 고유번호',
	`type` ENUM('option','suboption') NOT NULL DEFAULT 'option' COMMENT '에러구분',
	`parent_seq` INT(10) NOT NULL COMMENT '에러구문에따른 상품정보의 일련번호',
	`no` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '패키지옵션의순번',
	`error_code` CHAR(4) NOT NULL COMMENT '에러코드',
	`regist_date` DATETIME NOT NULL COMMENT '등록일시',
	PRIMARY KEY (`error_seq`)
)
COMMENT='패키지상품연결에러'
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
ALTER TABLE `fm_goods`
	ADD COLUMN `package_err` ENUM('y','n') NULL DEFAULT NULL COMMENT '필수옵션연결오류여부',
	ADD COLUMN `package_err_suboption` ENUM('y','n') NULL DEFAULT NULL COMMENT '추가옵션연결오류여부';
*/
class errorpackage extends CI_Model {
	public function __construct(){
		$this->table = 'fm_package_error';
	}

	public function del_error($params){
		$this->db->delete($this->table, $params); 
	}
	/*
	params (array) key :package_goods_seq,type,parent_seq
	*/
	public function set_error($params){
		$this->db->set('regist_date', 'NOW()', FALSE);
		$this->db->insert($this->table, $params);
	}

	public function get_error($params){
		$query = $this->db->get_where($this->table,$params);
		return $query;
	}

	public function get_last_error($params){
		
		foreach($params as $field => $val){
			$where_arr[]	= $field." = ?";
			$bind[]			= $val;
		}
		
		$where_str = implode(' and ',$where_arr);
		$query = "select * from ".$this->table." where ".$where_str." order by error_seq desc limit 1";
		
		return $this->db->query($query,$bind);
	}
}