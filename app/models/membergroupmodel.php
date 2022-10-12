<?php
class Membergroupmodel extends CI_Model {
	public function __construct(){
		$cfg_order = config_load('order');
		$this->load->helper('goods');
	}

	public function get_group_sale($sale_seq='all', $goods_seq=0, $category_code=array()){
		# reset
		$category_code && !is_array($category_code) && ($category_code = array($category_code));

		# default sale_seq 가져오기
		if(!$sale_seq) {
			$sql = "select sale_seq from fm_member_group_sale where defualt_yn='y'";
			$query = $this->db->query($sql);
			$default_sale = $query -> result_array();
			is_array($default_sale) && $default_sale = array_shift($default_sale);
			
			if(sizeof($default_sale)) {
				if(array_key_exists('sale_seq', $default_sale)) {
					$sale_seq = $default_sale['sale_seq'];
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		#
		$this->load->model('membermodel');
		$sale_group_list = $this->membermodel->member_sale_group_list();

		#
		$sql = "select * from fm_member_group_sale where 1 ";
		$sale_seq!='all' && $sql .= "and sale_seq='".$sale_seq."'";
		$query = $this->db->query($sql);
		$sale_list = $query -> result_array();

		foreach ($sale_list as $datarow) {
			#
			$_no = $datarow["_no"];
			$l_sale_seq = $datarow["sale_seq"];
			$l_sale_title = $datarow["sale_title"];

			foreach($sale_group_list as $sale_group) {
				#
				$group_seq = $sale_group['group_seq'];

				#
				$sql = "select * from fm_member_group_sale_detail where sale_seq = '".$l_sale_seq."' and group_seq = '".$group_seq."'";
				$query = $this->db->query($sql);
				$detail_list = $query -> result_array();

				foreach($detail_list as $subdatarow) {
					if($subdatarow["sale_use"] == "Y") {
						$subdata[$group_seq]["sale_use"] = get_currency_price($subdatarow["sale_limit_price"],3)." 이상 구매";
					}else{
						$subdata[$group_seq]["sale_use"] = "조건없음";
					}

					$subdata[$group_seq]["sale_price"] = get_currency_price($subdatarow["sale_price"]);

					if($subdatarow["sale_price_type"] == "PER") {
						$subdata[$group_seq]["sale_price_type"] = "% 추가 할인";
					}else{
						$subdata[$group_seq]["sale_price_type"] = $this->config_system['basic_currency']." 할인";
					}

					$subdata[$group_seq]["sale_option_price"] = get_currency_price($subdatarow["sale_option_price"]);

					if($subdatarow["sale_option_price_type"] == "PER") {
						$subdata[$group_seq]["sale_option_price_type"] = "% 추가 할인";
					}else{
						$subdata[$group_seq]["sale_option_price_type"]	= $this->config_system['basic_currency']." 할인";
					}

					$subdata[$group_seq]["point_use"] = $subdatarow["point_use"];

					if($subdatarow["point_use"] == "Y") {
						$subdata[$group_seq]["point_use"] = get_currency_price($subdatarow["point_limit_price"],3)." 이상 구매";
					}else{
						$subdata[$group_seq]["point_use"] = "조건없음";
					}

					$subdata[$group_seq]["point_price"] = $subdatarow["point_price"];

					if($subdatarow["point_price_type"] == "PER") {
						$subdata[$group_seq]["point_price_type"] = "% 추가 적립";
					}else{
						$subdata[$group_seq]["point_price_type"] = $this->config_system['basic_currency']." 추가 적립";
					}


					$subdata[$group_seq]["reserve_price"] = $subdatarow["reserve_price"];

					if($subdatarow["reserve_price_type"] == "PER") {
						$subdata[$group_seq]["reserve_price_type"] = "% 추가 적립";
					}else{
						$subdata[$group_seq]["reserve_price_type"] = $this->config_system['basic_currency']." 추가 적립";
					}

					$subdata[$group_seq]["reserve_select"]	= $subdatarow["reserve_select"];
					$subdata[$group_seq]["reserve_year"]	= $subdatarow["reserve_year"];
					$subdata[$group_seq]["reserve_direct"]	= $subdatarow["reserve_direct"];
					$subdata[$group_seq]["point_select"]		= $subdatarow["point_select"];
					$subdata[$group_seq]["point_year"]		= $subdatarow["point_year"];
					$subdata[$group_seq]["point_direct"]		= $subdatarow["point_direct"];
				}
			}

			$data[$l_sale_seq]['records'] = $subdata;
			$data[$l_sale_seq]["sale_seq"] = (int)$l_sale_seq;
			$data[$l_sale_seq]["sale_title"] = $l_sale_title;
			$data[$l_sale_seq]["loop"] = $sale_group_list;
			$data[$l_sale_seq]["gcount"] = count($sale_group_list);
			
			
			# 제품 필터링
			$sql = "SELECT * FROM fm_member_group_issuegoods WHERE sale_seq='".$l_sale_seq."'";
			$query = $this->db->query($sql);
			foreach ($query->result_array() as $row){		
				# 할인 예외 등록 상품
				if($row['goods_seq'] == $goods_seq && $row['type'] == 'sale') {
					foreach($data[$l_sale_seq]['records'] as $k=>$v) {
						$data[$l_sale_seq]['records'][$k]['sale_option_price'] = 0;
						$data[$l_sale_seq]['records'][$k]['sale_price'] = 0;
						$data[$l_sale_seq]['records'][$k]['sale_use'] = '조건없음';
					}					
					continue;
				}	

				# 적립 예외 등록 상품
				if($row['goods_seq'] == $goods_seq && $row['type'] == 'emoney') {
					foreach($data[$l_sale_seq]['records'] as $k=>$v) {
						$data[$l_sale_seq]['records'][$k]['point_price'] = 0;
						$data[$l_sale_seq]['records'][$k]['reserve_price'] = 0;
						$data[$l_sale_seq]['records'][$k]['point_use'] = '조건없음';
					}					
					continue;
				}
			}


			# 카테고리 필터링
			$sql = "SELECT * FROM fm_member_group_issuecategory WHERE sale_seq='".$l_sale_seq."'";
			$query = $this->db->query($sql);
			foreach ($query->result_array() as $row){		
				# 할인 예외 등록 상품
				if(in_array($row['category_code'], $category_code) && $row['type'] == 'sale') {
					foreach($data[$l_sale_seq]['records'] as $k=>$v) {
						$data[$l_sale_seq]['records'][$k]['sale_option_price'] = 0;
						$data[$l_sale_seq]['records'][$k]['sale_price'] = 0;
						$data[$l_sale_seq]['records'][$k]['sale_use'] = '조건없음';
					}					
					continue;
				}	

				# 적립 예외 등록 상품
				if(in_array($row['category_code'], $category_code) && $row['type'] == 'emoney') {
					foreach($data[$l_sale_seq]['records'] as $k=>$v) {
						$data[$l_sale_seq]['records'][$k]['point_price'] = 0;
						$data[$l_sale_seq]['records'][$k]['reserve_price'] = 0;
						$data[$l_sale_seq]['records'][$k]['point_use'] = '조건없음';
					}					
					continue;
				}
			}

			# records 키정렬
			#ksort($data[$l_sale_seq]['records']);

		}

		return $data;
	}
}

/* End of file membergroupmodel.php */
/* Location: ./app/models/membergroupmodel.php */