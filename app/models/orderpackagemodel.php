<?
class orderpackagemodel extends CI_Model {
	public function __construct()
	{
		$this->load->model('goodsmodel');
	}
	public function insert_order_package_option($insert_param){
		foreach($insert_param as $field => $val){
			$fields[] = $field;
			$values[] = "?";
			$bind[] = $val;
		}
		$query = "insert into `fm_order_package_option` (`".implode('`,`',$fields)."`) values(".implode(',',$values).")";
		$this->db->query($query,$bind);
	}

	public function insert_order_package_suboption($insert_param){
		foreach($insert_param as $field => $val){
			$fields[] = $field;
			$values[] = "?";
			$bind[] = $val;
		}
		$query = "insert into `fm_order_package_suboption` (`".implode('`,`',$fields)."`) values(".implode(',',$values).")";
		$this->db->query($query,$bind);
	}

	// 패키지 상품 주문
	public function package_order($order_seq){
		if	(!$this->scm_cfg)	$this->scm_cfg	= config_load('scm');
		if	($this->scm_cfg['use'] == 'Y'){
			$this->load->model('scmmodel');
		}

		# 패키지 주문 초기화
		$query = "delete from fm_order_package_option where order_seq=?";
		$this->db->query($query,array($order_seq));
		$query = "delete from fm_order_package_suboption where order_seq=?";
		$this->db->query($query,array($order_seq));

		$query = "select o.*,i.goods_seq from fm_order_item_option o,fm_order_item i where o.item_seq=i.item_seq and o.package_yn='y' and o.order_seq=?";
		$query = $this->db->query($query,array($order_seq));
		foreach($query->result_array() as $data){
			$param['goods_seq'] = $data['goods_seq'];
			$param['option1'] = $data['option1'];
			$param['option2'] = $data['option2'];
			$param['option3'] = $data['option3'];
			$param['option4'] = $data['option4'];
			$param['option5'] = $data['option5'];
			$data_info = $this->goodsmodel->get_option_info_by_optionval($param);

			$insert_param['order_seq'] = $data['order_seq'];
			$insert_param['item_seq'] = $data['item_seq'];
			$insert_param['item_option_seq'] = $data['item_option_seq'];
			$cal_supply_price = 0;
			for($i=1;$i<6;$i++){
				$package_option_seq = $data_info['package_option_seq'.$i];
				$package_unit_ea = $data_info['package_unit_ea'.$i];
				if($package_option_seq){
					$data_goods = $this->goodsmodel->get_option_package_info( $package_option_seq );
					$insert_param['goods_seq'] = $data_goods['goods_seq'];
					$insert_param['goods_code'] = $data_goods['goods_code'];
					$insert_param['image'] = $data_goods['image'];
					$insert_param['goods_name'] = $data_goods['goods_name'];

					// 재고관리 사용시 매입처 정보 가져오기
					if	($this->scm_cfg['use'] == 'Y'){
						$sc['option_seq'] = $package_option_seq;
						$sc['goods_seq'] = $data_goods['goods_seq'];
						list($data_defaultinfo) = $this->scmmodel->get_order_defaultinfo($sc);
						$data_goods['purchase_goods_name'] = $data_defaultinfo['supply_goods_name'];
					}
					$insert_param['purchase_goods_name'] = $data_goods['purchase_goods_name'];
					$insert_param['hscode'] = $data_goods['hscode'];
					$insert_param['title1'] = $data_goods['title1'];
					$insert_param['option1'] = $data_goods['option1'];
					$insert_param['title2'] = $data_goods['title2'];
					$insert_param['option2'] = $data_goods['option2'];
					$insert_param['title2'] = $data_goods['title2'];
					$insert_param['option2'] = $data_goods['option2'];
					$insert_param['title3'] = $data_goods['title3'];
					$insert_param['option3'] = $data_goods['option3'];
					$insert_param['title4'] = $data_goods['title4'];
					$insert_param['option4'] = $data_goods['option4'];
					$insert_param['title5'] = $data_goods['title5'];
					$insert_param['option5'] = $data_goods['option5'];
					$insert_param['unit_ea'] = $package_unit_ea;
					if($data_goods['optioncode1']) $insert_param['goods_code'] .= $data_goods['optioncode1'];
					if($data_goods['optioncode2']) $insert_param['goods_code'] .= $data_goods['optioncode2'];
					if($data_goods['optioncode3']) $insert_param['goods_code'] .= $data_goods['optioncode3'];
					if($data_goods['optioncode4']) $insert_param['goods_code'] .= $data_goods['optioncode4'];
					if($data_goods['optioncode5']) $insert_param['goods_code'] .= $data_goods['optioncode5'];

					// 물류관리 버전이고 과세상품이면 평균매입가에 부가세를 포함시킨다.
					if	($this->scm_cfg['use'] == 'Y' && $data['tax']){
						$data['supply_price']	= $data_goods['supply_price'] + round($data_goods['supply_price'] * 0.1);
					}
					$insert_param['supply_price'] = $data_goods['supply_price'];

					$this->insert_order_package_option($insert_param);
					$cal_supply_price += $insert_param['supply_price'] * $insert_param['unit_ea'];
				}
			}

			// 원주문의 옵션 매입단가 업데이트
			$query_update = "update fm_order_item_option set supply_price=? where item_option_seq=?";
			$this->db->query($query_update,array($cal_supply_price,$data['item_option_seq']));
		}

		$insert_param = array();
		$query = "select o.*,i.goods_seq from fm_order_item_suboption o,fm_order_item i where o.item_seq=i.item_seq and o.package_yn='y' and o.order_seq=?";
		$query = $this->db->query($query,array($order_seq));
		foreach($query->result_array() as $data){
			$param['goods_seq'] = $data['goods_seq'];
			$param['suboption_title'] = $data['title'];
			$param['suboption'] = $data['suboption'];
			$data_info = $this->goodsmodel->get_suboption_info_by_suboptionval($param);

			$insert_param['order_seq'] = $data['order_seq'];
			$insert_param['item_seq'] = $data['item_seq'];
			$insert_param['item_suboption_seq'] = $data['item_suboption_seq'];

			$cal_supply_price = 0;
			for($i=1;$i<6;$i++){
				$package_option_seq = $data_info['package_option_seq'.$i];
				$package_unit_ea = $data_info['package_unit_ea'.$i];
				if($package_option_seq){
					$data_goods = $this->goodsmodel->get_option_package_info( $package_option_seq );
					$insert_param['goods_seq'] = $data_goods['goods_seq'];
					$insert_param['goods_code'] = $data_goods['goods_code'];
					$insert_param['image'] = $data_goods['image'];
					$insert_param['goods_name'] = $data_goods['goods_name'];

					// 재고관리 사용시 매입처 정보 가져오기
					if	($this->scm_cfg['use'] == 'Y'){
						$sc['option_seq'] = $package_option_seq;
						$sc['goods_seq'] = $data_goods['goods_seq'];
						list($data_defaultinfo) = $this->scmmodel->get_order_defaultinfo($sc);
						$data_goods['purchase_goods_name'] = $data_defaultinfo['supply_goods_name'];
					}
					$insert_param['purchase_goods_name'] = $data_goods['purchase_goods_name'];
					$insert_param['title1'] = $data_goods['title1'];
					$insert_param['option1'] = $data_goods['option1'];
					$insert_param['title2'] = $data_goods['title2'];
					$insert_param['option2'] = $data_goods['option2'];
					$insert_param['title2'] = $data_goods['title2'];
					$insert_param['option2'] = $data_goods['option2'];
					$insert_param['title3'] = $data_goods['title3'];
					$insert_param['option3'] = $data_goods['option3'];
					$insert_param['title4'] = $data_goods['title4'];
					$insert_param['option4'] = $data_goods['option4'];
					$insert_param['title5'] = $data_goods['title5'];
					$insert_param['option5'] = $data_goods['option5'];
					$insert_param['unit_ea'] = $package_unit_ea;
					if($data_goods['optioncode1']) $insert_param['goods_code'] .= $data_goods['optioncode1'];
					if($data_goods['optioncode2']) $insert_param['goods_code'] .= $data_goods['optioncode2'];
					if($data_goods['optioncode3']) $insert_param['goods_code'] .= $data_goods['optioncode3'];
					if($data_goods['optioncode4']) $insert_param['goods_code'] .= $data_goods['optioncode4'];
					if($data_goods['optioncode5']) $insert_param['goods_code'] .= $data_goods['optioncode5'];

					// 물류관리 버전이고 과세상품이면 평균매입가에 부가세를 포함시킨다.
					if	($this->scm_cfg['use'] == 'Y' && $data['tax']){
						$data['supply_price']	= $data_goods['supply_price'] + round($data_goods['supply_price'] * 0.1);
					}
					$insert_param['supply_price'] = (int) $data_goods['supply_price'];
					$this->insert_order_package_suboption($insert_param);
					$cal_supply_price += $insert_param['supply_price'] * $insert_param['unit_ea'];
				}
			}

			// 원주문의 추가옵션 매입단가 업데이트
			$query_update = "update fm_order_item_suboption set supply_price=? where item_suboption_seq=?";
			$this->db->query($query_update,array($cal_supply_price,$data['item_suboption_seq']));
		}
	}

	function get_option($item_option_seq,$mode=false){
		if(!$mode) $where_str = "where item_option_seq=?";
		else $where_str = "where package_option_seq=?";
		$query = "select * from fm_order_package_option ".$where_str;

		$query = $this->db->query($query,array($item_option_seq));
		foreach($query->result_array() as $data){
			for($i=1;$i<6;$i++){
				$arr_option['option'.$i] = $data['option'.$i];
			}
			$data['return_badea'] = (int) $data['return_badea'];
			$data_stock = $this->goodsmodel->get_option_stock($data['goods_seq'],$arr_option);
			$data['stock'] = (int) $data_stock['stock'];
			$data['badstock'] = (int) $data_stock['badstock'];
			$data['reservation15'] = (int) $data_stock['reservation15'];
			$data['reservation25'] = (int) $data_stock['reservation25'];
			$data['option_seq'] = (int) $data_stock['option_seq'];
			$data['scm_auto_warehousing'] = (int) $data_stock['scm_auto_warehousing'];

			$data['bar_goods_code'] = $data['goods_code'];
			if ( ! preg_match("/^[a-z0-9:_\/-]+$/i", $data['goods_code']))
			{
				$data['bar_goods_code'] = "";
			}
			$result[] = $data;
		}
		return $result;
	}
	function get_suboption($item_suboption_seq,$mode=false){
		if (!$this->scm_cfg) {
			$this->scm_cfg	= config_load('scm');
		}
		
		if (!$mode) {
			$where_str = "where p.item_suboption_seq=?";
		} else {
			$where_str = "where p.package_suboption_seq=?";
		}
		$query = "seLECT p.*, s.consumer_price, s.price, (s.price * s.ea) as ea_price
					FROM fm_order_package_suboption p
						INNER JOIN fm_order_item_suboption s ON s.item_suboption_seq = p.item_suboption_seq ".$where_str;
		$query = $this->db->query($query,array($item_suboption_seq));
		foreach($query->result_array() as $data){
			for ($i=1;$i<6;$i++) {
				$arr_option['option'.$i] = $data['option'.$i];
			}
			$data['return_badea']	= (int) $data['return_badea'];
			$data_stock			  = $this->goodsmodel->get_option_stock($data['goods_seq'],$arr_option);
			
			$data['stock']		   = (int) $data_stock['stock'];
			$data['badstock']		= (int) $data_stock['badstock'];
			$data['reservation15']   = (int) $data_stock['reservation15'];
			$data['reservation25']   = (int) $data_stock['reservation25'];
			$data['option_seq']	  = (int) $data_stock['option_seq'];
			$data['scm_auto_warehousing'] = (int) $data_stock['scm_auto_warehousing'];
			
			if ($this->scm_cfg['use'] == 'Y') {
				$location			= $this->get_package_location($data['goods_seq'], $data['option_seq']);
				$data['location']	= $location[0]['location'];
			}
			
			$data['bar_goods_code'] = $data['goods_code'];
			if ( ! preg_match("/^[a-z0-9:_\/-]+$/i", $data['goods_code']))
			{
				$data['bar_goods_code'] = "";
			}

			$result[] = $data;
		}
		
		return $result;
	}
	
	function get_package_location($goods_seq, $option_seq){
		$query = "seLECT location_code as location FROM fm_scm_location_link WHERE goods_seq =? AND option_seq = ?";
		$query = $this->db->query($query,array($goods_seq, $option_seq));
		$res = $query->result_array();
		
		
		return $res;
	}
}