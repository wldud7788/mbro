<?php
/*
CREATE TABLE `fm_count` (
	`kind` varchar(10) NOT NULL DEFAULT 'category' COMMENT '분류',
	`code` VARCHAR(16) NOT NULL,
	`totalcount` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '갯수',
	PRIMARY KEY (`kind`, `code`)
)
COLLATE='utf8_general_ci'
ENGINE=innoDB
;
*/
class countmodel extends CI_Model {
	var $kind = 'category';
	var $tablename = array(
		'category'	=>'fm_category_link',
		'brand'		=>'fm_brand_link'
	);

	public function __contruct()
	{
		$this->load->model('goodsmodel');
	}

	public function get($code)
	{
		$params['kind']	= $this->kind;
		$params['code']	= $code;
		$this->db->where($params);
		return $this->db->get('fm_count');
	}

	public function category_brand($goods_seq){
		$query = "select ca.category_code,br.category_code brand_code from fm_category_link ca
			inner join fm_brand_link br on ca.goods_seq=br.goods_seq
		where ca.goods_seq=?";
		$query = $this->db->query($query,array($goods_seq));
		foreach($query->result_array() as $data){
			if( $data['category_code'] ){
				$query = "replace into fm_category_brand (category_code, brand_code) values (?,?)";
				$this->db->query($query, array($data['category_code'], $data['brand_code']));
			}
		}
	}

	public function member_group($group_seq){
		$query		= "select count(member_seq) cnt from fm_member where group_seq=? and status != 'withdrawal'";
		$query		= $this->db->query($query, array($group_seq));
		$row		= $query->row_array();
		$totalcount	= $row['cnt'];
		$query		= "replace into fm_count (kind, code, totalcount) values (?,?,?)";
		$this->db->query($query, array('member', $group_seq, $totalcount));
	}

	public function category($category_code){
		$now_date	= date("Y-m-d");
		$query = "SELECT
		count(g.goods_seq) cnt
			 FROM
				fm_goods g use index (primary)
				INNER JOIN fm_provider AS p ON g.provider_seq=p.provider_seq AND p.provider_status='Y'
				INNER JOIN fm_goods_option o ON (g.goods_seq = o.goods_seq AND o.default_option ='y')
				LEFT JOIN fm_goods_list_summary AS gls ON ( g.goods_seq = gls.goods_seq AND gls.platform = 'P' )
				INNER JOIN fm_category_link cl ON (g.goods_seq=cl.goods_seq AND cl.category_code = ?)
			WHERE
				g.goods_type = 'goods' AND
				g.provider_status ='1' AND
				(g.goods_view = 'look' OR (g.display_terms = 'AUTO' AND g.display_terms_begin <= CURDATE() AND g.display_terms_end >= CURDATE())) AND
				g.goods_status in ('normal','runout','purchasing','unsold')";
		$query		= $this->db->query($query, array($category_code));
		$row		= $query->row_array();
		$totalcount	= $row['cnt'];
		$query		= "replace into fm_count (kind, code, totalcount) values (?,?,?)";
		$this->db->query($query, array('category', $category_code, $totalcount));
		if($totalcount < 1) {
			$query		= "DELETE FROM fm_count WHERE kind=? AND code=?";
			$this->db->query($query, array('category', $category_code));
		}
	}

	public function brand($category_code){
		$now_date	= date("Y-m-d");
		$query = "SELECT
		count(g.goods_seq) cnt
			 FROM
				fm_goods g use index (primary)
				INNER JOIN fm_provider AS p ON g.provider_seq=p.provider_seq AND p.provider_status='Y'
				INNER JOIN fm_goods_option o ON (g.goods_seq = o.goods_seq AND o.default_option ='y')
				LEFT JOIN fm_goods_list_summary AS gls ON ( g.goods_seq = gls.goods_seq AND gls.platform = 'P' )
				INNER JOIN fm_brand_link cl ON (g.goods_seq=cl.goods_seq AND cl.category_code = ?)
			WHERE
				g.goods_type = 'goods' AND
				g.provider_status ='1' AND
				(g.goods_view = 'look' OR (g.display_terms = 'AUTO' AND g.display_terms_begin <= CURDATE() AND g.display_terms_end >= CURDATE())) AND
				g.goods_status in ('normal','runout','purchasing','unsold')";
		$query		= $this->db->query($query, array($category_code));
		$row		= $query->row_array();
		$totalcount	= $row['cnt'];
		$query		= "replace into fm_count (kind, code, totalcount) values (?,?,?)";
		$this->db->query($query, array('brand', $category_code, $totalcount));
	}

	public function arithmetic($method, $kind, $code, $val=1){
		$val	= (int) $val;
		if( !in_array($method,array('+','-','*','/')) ) return false;

		// 카테고리 없으면 insert 해줌 2018-05-29
		$query	= "INSERT IGNORE INTO fm_count (kind, code) VALUES(?,?)";
		$this->db->query($query, array($kind,$code));

		$query	= "update fm_count set totalcount = totalcount ".$method." ? where kind = ? and code = ?";
		$this->db->query($query, array($val,$kind,$code));
	}
}
