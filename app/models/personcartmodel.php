<?php
class personcartmodel extends CI_Model {

	public function get_cart($cart_seq) {
		$query = "
			SELECT *
			FROM fm_person_cart
			WHERE cart_seq=?";
		$query = $this->db->query($query,array($cart_seq));
		list($returnArr) = $query->result_array();
		$query->free_result();
		return $returnArr;
	}

	public function get_cart_list() {
		$session_id = session_id();
		if($this->userInfo['member_seq']){
			$where_query[] = "member_seq = ?";
			$where_arr[] = $this->userInfo['member_seq'];
		}else{
			$where_query[] = "session_id = ?";
			$where_arr[] = $session_id;
		}
		$query = "SELECT * FROM fm_person_cart WHERE ".implode(' AND ',$where_query) ." order by cart_seq desc";
		$query = $this->db->query($query,$where_arr);
		foreach($query->result_array() as $row) $returnArr[] = $row;
		$query->free_result();
		return $returnArr;
	}

	public function get_cart_count() {
		$session_id = session_id();
		if($this->userInfo['member_seq']){
			$where_query[] = "member_seq = ?";
			$where_arr[] = $this->userInfo['member_seq'];
		}else{
			$where_query[] = "session_id = ?";
			$where_arr[] = $session_id;
		}
		$query = "SELECT count(*) cnt FROM fm_person_cart WHERE distribution = 'cart' and ".implode(' AND ',$where_query) ." order by cart_seq desc";
		$query = $this->db->query($query,$where_arr);
		$row = $query->result_array();

		return $row[0]['cnt'];
	}

	public function get_cart_option($cart_seq) {
		$this->load->model('goodsmodel');
		$returnArr = "";
		$query = "
			SELECT cart.*,goods.price,goods.consumer_price,goods.goods_seq,
			goods.reserve_rate,goods.reserve_unit,goods.reserve,goods.commission_rate,goods.commission_type,
			(select supply_price from fm_goods_supply where option_seq=goods.option_seq and goods_seq=goods.goods_seq) supply_price
			FROM fm_person_cart_option cart,fm_goods_option goods
			WHERE cart.option1=goods.option1
				AND cart.option2=goods.option2
				AND cart.option3=goods.option3
				AND cart.option4=goods.option4
				AND cart.option5=goods.option5
				AND goods.goods_seq =
				(
					select goods_seq from fm_person_cart where cart_seq=?
				)
				AND cart.cart_seq=?
			ORDER BY cart.cart_option_seq DESC";
		$query = $this->db->query($query,array($cart_seq,$cart_seq));
		foreach ($query->result_array() as $row){
			$returnArr[] = $row;
		}
		$query->free_result();
		return $returnArr;
	}

	public function get_cart_suboption($cart_seq) {
		$returnArr = "";
		$query = "
			SELECT cart.*,goods.price,goods.consumer_price,goods.goods_seq,
			goods.reserve_rate,goods.reserve_unit,goods.reserve,goods.commission_rate,
			(select supply_price from fm_goods_supply where suboption_seq=goods.suboption_seq and goods_seq=goods.goods_seq) supply_price
			FROM fm_person_cart_suboption cart,fm_goods_suboption goods
			WHERE cart.suboption=goods.suboption AND cart.suboption_title=goods.suboption_title
				AND goods.goods_seq =
				(
					select goods_seq from fm_person_cart where cart_seq=?
				)
				AND cart.cart_seq=?
			ORDER BY cart.cart_suboption_seq DESC";
		$query = $this->db->query($query,array($cart_seq,$cart_seq));
		foreach ($query->result_array() as $row){
			$returnArr[] = $row;
		}
		$query->free_result();
		return $returnArr;
	}

	public function get_cart_input($cart_seq, $cart_option_seq = '') {
		$bind[]	= $cart_seq;
		if	($cart_option_seq > 0){
			$addWhere	= " and cart_option_seq = ? ";
			$bind[]		= $cart_option_seq;
		}

		$returnArr = "";
		$query = "
			SELECT *
			FROM fm_person_cart_input
			WHERE cart_seq=?
			".$addWhere."
			ORDER BY cart_input_seq DESC";
		$query = $this->db->query($query, $bind);
		foreach ($query->result_array() as $row){
			$returnArr[] = $row;
		}
		$query->free_result();
		return $returnArr;
	}

	public function get_cart_suboption_by_cart_option($cart_option_seq)
	{
		$returnArr = "";
		$query = "
			SELECT cart.*,goods.price,goods.consumer_price,goods.goods_seq,goods.sub_sale,
			goods.package_count as package_count_sub,
			goods.package_option_seq1,
			goods.package_option1,
			goods.reserve_rate,goods.reserve_unit,goods.reserve,goods.commission_rate,goods.commission_type,
			(select supply_price from fm_goods_supply where suboption_seq=goods.suboption_seq and goods_seq=goods.goods_seq) supply_price
			FROM fm_person_cart_suboption cart,fm_goods_suboption goods
			WHERE cart.suboption=goods.suboption AND cart.suboption_title=goods.suboption_title
				AND goods.goods_seq =
				(
					select goods_seq from fm_person_cart where cart_seq=cart.cart_seq
				)
				AND cart.cart_option_seq=?
			ORDER BY cart.cart_suboption_seq DESC";

		$query = $this->db->query($query,array($cart_option_seq));
		foreach ($query->result_array() as $row){
			$returnArr[] = $row;
		}
		$query->free_result();
		return $returnArr;
	}

	public function get_cart_input_by_cart_option($cart_option_seq)
	{
		$returnArr = "";
		$query = "
			SELECT *
			FROM fm_person_cart_input
			WHERE cart_option_seq=?
			ORDER BY cart_input_seq DESC";
		$query = $this->db->query($query,array($cart_option_seq));
		foreach ($query->result_array() as $row){
			$returnArr[] = $row;
		}
		$query->free_result();
		return $returnArr;
	}

	public function delete($cart_seqs){

		$this->db->select('cart_seq');
		if($this->userInfo['member_seq']) $this->db->where('member_seq', $this->userInfo['member_seq']);
		else $this->db->where('session_id', session_id());
		$this->db->where_in('cart_seq',$cart_seqs);
		$query = $this->db->get('fm_person_cart');

		foreach ($query->result_array() as $row)
		{
			$tables = array('fm_person_cart_option', 'fm_person_cart_input', 'fm_person_cart_suboption', 'fm_person_cart');
			$this->db->delete($tables,array('cart_seq' => $row['cart_seq']));
		}
	}

	public function delete_option($cart_option_seq=null, $cart_suboption_seq=null){
		$cart_seq = null;

		if($cart_option_seq){
			$query = $this->db->query("select cart_seq from fm_cart_option where cart_option_seq=?",$cart_option_seq);
		} else if($cart_suboption_seq) {
			$query = $this->db->query("select cart_seq from fm_cart_suboption where cart_suboption_seq=?",$cart_suboption_seq);
		}

		$result = $query->row_array();
		$cart_seq = $result['cart_seq'];

		if(!$cart_seq) return;

		$tables = array('fm_cart_option', 'fm_cart_input', 'fm_cart_suboption', 'fm_cart');
		$this->db->delete($tables, array('cart_seq' => $cart_seq));
	}

	public function delete_mode($mode,$admin=''){

		$this->db->select('cart_seq');

		if($this->userInfo['member_seq'] && !$admin) $this->db->where('member_seq', $this->userInfo['member_seq']);
		else $this->db->where('session_id', session_id());

		$this->db->where('distribution',$mode);
		$query = $this->db->get('fm_person_cart');
		foreach ($query->result_array() as $row)
		{
			$tables = array('fm_person_cart_option', 'fm_person_cart_input', 'fm_person_cart_suboption', 'fm_person_cart');
			$this->db->delete($tables,array('cart_seq' => $row['cart_seq']));
		}
	}

	// 회원이면 이전에 담았던 장바구니 데이터를 합칩니다.
	public function merge_for_member($member_seq){

		$session_id = session_id();

		$this->db->where('session_id',$session_id);
		$this->db->update('fm_person_cart', array('member_seq' => $member_seq));

		$carts = $this->get_cart_list();
		$arr_done = array();
		foreach($carts as $cart){
			if(!in_array($cart['goods_seq'],$arr_done)){
				$this->merge_for_goods($cart['goods_seq'],$cart['cart_seq'],$member_seq);
			}
			$arr_done[] = $cart['goods_seq'];
		}

	}

	public function merge_for_choice(){
		if($this->userInfo['member_seq']){
			$this->db->where('member_seq',$this->userInfo['member_seq']);
			$this->db->where('distribution','choice');
		}else{
			$session_id = session_id();
			$this->db->where('session_id',$session_id);
			$this->db->where('distribution','choice');
		}
		$this->db->update('fm_person_cart', array('distribution' => 'cart'));

		$carts = $this->get_cart_list();
		$arr_done = array();
		foreach($carts as $cart){
			if(!in_array($cart['goods_seq'],$arr_done)){
				$this->merge_for_goods($cart['goods_seq'],$cart['cart_seq'],$member_seq);
			}
			$arr_done[] = $cart['goods_seq'];
		}
	}

	public function catalog($member_seq="", $person_seq="0",$tmp_arr=null)
	{
		$this->load->model('goodsmodel');
		$this->load->model('categorymodel');
		$this->load->model('promotionmodel');
		$this->load->model('cartmodel');
		$this->load->library('sale');
		$this->load->helper('shipping_helper');

		$mode						= 'cart';
		$applypage					= 'saleprice';
		$result						= '';
		$where_query				= '';
		$shop_shipping_policy		= '';
		$total						= 0;
		$total_point				= 0;
		$shop_total_price			= 0;
		$shop_total_price_exempt	= 0;
		$exempt_chk					= 0;
		$default_box_ea				= false;
		$arr_shipping_method		= get_shipping_method('all');
		$session_id					= session_id();
		$cfg_reserve				= config_load('reserve');
		$shipping_price['goods']	= 0;
		$shipping_exempt			= 0;
		$promocodeSale				= 0;
		$provider_shipping_policy	= array();
		$provider_sum_goods_price	= array();
		$provider_shipping_price	= array();
		$provider_box_ea			= array();
		$member_seq					= ($member_seq) ? $member_seq : $this->userInfo['member_seq'];

		if	($member_seq > 0){
			$members				= $this->membermodel->get_member_data($member_seq);
		}

		if	($person_seq){
			$sql	= "select * from fm_person where person_seq = ? ";
			$query	= $this->db->query($sql, array($person_seq));
			$person	= $query->row_array();
		}

		//--> sale library 적용
		$param['cal_type']				= 'list';
		$param['member_seq']			= $members['member_seq'];
		$param['group_seq']				= $members['group_seq'];
		$this->sale->set_init($param);
		$this->sale->preload_set_config($applypage);
		//<-- sale library 적용

		if(in_array($tmp_arr['cart_table'],array("admin","person")) && $tmp_arr['mode'] == "tmp"){

			$goods_seq = $tmp_arr['option_select_goods_seq'];

			foreach($tmp_arr['option'] as $k=>$option){

				$option_data = $this->goodsmodel->get_cart_tmp_option($tmp_arr,$goods_seq,$k);
				$cart_list[] = $option_data;

			}
			$num_rows	= count($cart_list);

		}else{
			$query = "
			SELECT
			cart.fblike,
			goods.goods_seq,goods.goods_name,goods.goods_code,goods.goods_type,goods.cancel_type,
			goods.goods_kind,goods.socialcp_event,goods.sale_seq,
			goods.package_yn,goods.package_yn_suboption,
			goods.shipping_weight_policy,goods.goods_weight,
			goods.shipping_policy,goods.goods_shipping_policy,
			goods.unlimit_shipping_price,goods.limit_shipping_price,
			goods.limit_shipping_ea,goods.limit_shipping_subprice,
			goods_img.image,
			goods.min_purchase_ea,
			goods.max_purchase_ea,
			goods_opt.price,
			goods_opt.commission_rate,
			goods_opt.commission_type,
			goods_opt.reserve_rate,
			goods_opt.reserve_unit as reserve_unit,
			goods_opt.reserve reserve,
			goods_opt.consumer_price,
			goods_opt.package_option_seq1,
			goods_opt.package_option_seq2,
			goods_opt.package_option_seq3,
			goods_opt.package_option_seq4,
			goods_opt.package_option_seq5,
			goods_opt.package_option1,
			goods_opt.package_option2,
			goods_opt.package_option3,
			goods_opt.package_option4,
			goods_opt.package_option5,
			(select supply_price from fm_goods_supply where goods_seq=goods_opt.goods_seq and option_seq=goods_opt.option_seq) supply_price,
			goods.reserve_policy,
			goods.multi_discount_use,
			goods.multi_discount_ea,
			goods.multi_discount,
			goods.multi_discount_unit,
			goods.hscode,
			goods.option_international_shipping_status,
			goods.tax,
			goods.provider_seq,
			goods.socialcp_input_type,goods.socialcp_cancel_type,
			goods.socialcp_cancel_use_refund,goods.socialcp_cancel_payoption,goods.socialcp_cancel_payoption_percent,
			goods.socialcp_use_return,goods.socialcp_use_emoney_day,goods.socialcp_use_emoney_percent,
			goods.individual_refund,
			goods.individual_refund_inherit,
			goods.individual_export,
			goods.individual_return,
			goods.possible_pay,
			goods.possible_mobile_pay,
			goods.adult_goods,
			goods.purchase_goods_name,
			goods.option_international_shipping_status,
			goods.shipping_group_seq as goods_shipping_group_seq,
			cart.shipping_group_seq,
			cart.shipping_set_seq,
			cart.shipping_set_code,
			cart.shipping_hop_date,
			cart.shipping_store_seq,
			cart.shipping_prepay_info,
			(select provider_name from fm_provider where provider_seq=goods.provider_seq) provider_name,
			cart_opt.*,
			(select shipping_calcul_type from fm_shipping_grouping where shipping_group_seq = goods.shipping_group_seq) as shipping_calcul_type,
			goods.display_terms,
			goods.display_terms_text,
			goods.display_terms_color,
			goods.display_terms_begin,
			goods.display_terms_end,
			goods.multi_discount_policy
			FROM
			fm_person_cart_option cart_opt
			left join fm_person_cart cart on cart.cart_seq = cart_opt.cart_seq
			left join fm_goods_image goods_img on goods_img.cut_number = 1 AND goods_img.image_type = 'thumbCart' AND cart.goods_seq = goods_img.goods_seq
			,fm_goods goods
			,fm_goods_option goods_opt
			,fm_provider pv
			WHERE cart.distribution=?
			AND cart.goods_seq = goods.goods_seq
			AND goods.provider_seq = pv.provider_seq
			AND goods.goods_status = 'normal'
			AND cart.goods_seq = goods_opt.goods_seq
			AND ifnull(cart_opt.option1,'') = ifnull(goods_opt.option1,'')
			AND ifnull(cart_opt.option2,'') = ifnull(goods_opt.option2,'')
			AND ifnull(cart_opt.option3,'') = ifnull(goods_opt.option3,'')
			AND ifnull(cart_opt.option4,'') = ifnull(goods_opt.option4,'')
			AND ifnull(cart_opt.option5,'') = ifnull(goods_opt.option5,'')
			AND cart.member_seq = ? ";
			if($person_seq)	$query	.= " AND cart.person_seq = ? ";
			else			$query	.= " AND (cart.person_seq = ? or cart.person_seq is null) ";
			$query		.= "ORDER BY pv.deli_group, cart_opt.shipping_method, goods.provider_seq, cart.goods_seq,cart_opt.cart_option_seq ASC";
			$query		= $this->db->query($query, array($mode, $member_seq, $person_seq));
			$cart_list	= $query->result_array();
			$num_rows	= $query->num_rows();
		}

		foreach ($cart_list as $row){
			$goods_ea[$row['goods_seq']]	+= $row['ea'];
			$r_cart_option[]				= $row;
		}

		foreach ($cart_list as $row){

			$opt_no = $row['opt_no'];

			// 해외배송상품
			$r_goods[$row['goods_seq']]['option_international_shipping_status']	= $row['option_international_shipping_status'];

			if (trim($row['multi_discount_policy'])){
				$row['multi_discount_policy']	= json_decode($row['multi_discount_policy'], 1);
			}else{
				$row['multi_discount_policy']	= '';
			}

			if(in_array($tmp_arr['cart_table'],array("admin","person")) && $tmp_arr['mode'] == "tmp"){
				// 추가옵션
				$etc_ptions			= $this->goodsmodel->get_cart_tmp_etc_option($opt_no,$_GET);
				$cart_suboptions	= $etc_ptions['suboption'];
				$cart_inputs		= $etc_ptions['inputoption'];
				// 추가입력사항
				//$cart_inputs		= $this->get_cart_input_by_cart_option($_GET);
			}else{
				// 추가옵션
				$cart_suboptions	= $this->get_cart_suboption_by_cart_option($row['cart_option_seq']);

				// 추가입력사항
				$cart_inputs		= $this->get_cart_input_by_cart_option($row['cart_option_seq']);
			}

			// 연결 상품 검증
			$row['package_error']	= false;
			if($row['package_yn'] == 'y'){
				for($cpi=0;$cpi<=5;$cpi++){
					if( $row['package_option_seq'.$cpi] ){
						$params_check = array(
								'mode'					=> 'option',
								'goods_seq'				=> $row['goods_seq'],
								'option_seq'			=> $row['option_seq'],
								'package_option_seq'	=> $row['package_option_seq'.$cpi],
								'package_option'		=> $row['package_option'.$cpi],
								'no'					=> $cpi
						);
						if( !check_package_option($params_check) ){
							$row['package_error_type']	=  'option';
							$row['package_error']	=  true;
						}
					}
				}
			}

			if($row['package_yn_suboption'] == 'y'){
				foreach($cart_suboptions as $key_suboption => $data_suboption)
				{
					if($data_suboption['package_option_seq1']){
						$params_check = array(
								'mode'					=> 'suboption',
								'goods_seq'				=> $row['goods_seq'],
								'option_seq'			=> $data_suboption['suboption_seq'],
								'package_option_seq'	=> $data_suboption['package_option_seq1'],
								'package_option'		=> $data_suboption['package_option1'],
								'no'					=> 1
						);
						if( !check_package_option($params_check) ){
							$data_suboption['package_error_type']	=  'suboption';
							$data_suboption['package_error']	=  true;
							$row['package_error_type']	=  'suboption';
							$row['package_error']	=  true;
						}
					}
					$cart_suboptions[$key_suboption] = $data_suboption;
				}
			}

			// 할인 미적용가
			$row['org_price']		= $row['price'];

			//예약 상품의 경우 문구를 넣어준다 2016-11-07
			$row['goods_name']		= get_goods_pre_name($row,true,true);

			// 상품명 특수문자 처리
			$row['goods_name']		= strip_tags(str_replace(array("\"","'"),'',$row['goods_name']));

			// 카테고리정보
			$tmparr2 = array();
			if($r_goods[$row['goods_seq']]['r_category']){
				$row['r_category'] = $r_goods[$row['goods_seq']]['r_category'];
			}else{
				$categorys = $this->goodsmodel->get_goods_category($row['goods_seq']);
				foreach($categorys as $key => $data){
					$tmparr = $this->categorymodel->split_category($data['category_code']);
					foreach($tmparr as $cate) $tmparr2[] = $cate;
				}
				if($tmparr2){
					$tmparr2 = array_values(array_unique($tmparr2));
					$row['r_category'] = $tmparr2;
					$r_goods[$row['goods_seq']]['r_category'] = $tmparr2;
				}
			}

			// 옵션 별 최대 구매,최소 구매수량
			$option_name = $row['option1'].' ^^ '.$row['option2'].' ^^ '.$row['option3'].' ^^ '.$row['option4'].' ^^ '.$row['option5'];
			$r_goods[$row['goods_seq']]['ea_for_option'][$option_name]	+= $row['ea'];
			$r_goods[$row['goods_seq']]['min_purchase_ea']				= $row['min_purchase_ea'];
			$r_goods[$row['goods_seq']]['max_purchase_ea']				= $row['max_purchase_ea'];

			// 해외배송상품
			$r_goods[$row['goods_seq']]['option_international_shipping_status']	= $row['option_international_shipping_status'];

			//----> sale library 적용
			unset($param,$row['reserve'],$row['point']);
			$param['consumer_price']		= $row['consumer_price'];
			$param['price']					= $row['price'];
			$param['ea']					= $row['ea'];
			$param['goods_ea']				= $goods_ea[$row['goods_seq']];
			$param['category_code']			= $row['r_category'];
			$param['goods_seq']				= $row['goods_seq'];
			$param['goods']					= $row;
			$this->sale->set_init($param);
			$sales	= $this->sale->calculate_sale_price($applypage);

			$row['sales']					= $sales;

			$row['basic_sale']				= $sales['one_sale_list']['basic'];
			$row['event_sale_target']		= ($sales['target_list']['event'] == 1) ? 'consumer_price' : 'price';
			$row['event_sale']				= $sales['one_sale_list']['event'];
			$row['multi_sale']				= $sales['one_sale_list']['multi'];
			$row['event']					= $this->sale->cfgs['event'];
			$row['price']					= $sales['one_result_price'];
			$row['reserve']					= $sales['one_tot_reserve'];
			$row['point']					= $sales['one_tot_point'];
			$row['eventEnd']				= $sales['eventEnd'];
			$this->sale->reset_init();
			unset($sales);
			//<---- sale library 적용

			$row['ori_price']	= $row['price'];
			$row['tot_price']	+= $row['price'] * $row['ea'];

			// 마일리지계산
			if($row['reserve_policy'] == 'shop') {
				$row['reserve'] += $this->goodsmodel->get_reserve_with_policy($row['reserve_policy'],$row['price'],$cfg_reserve['default_reserve_percent'],$row['reserve_rate'],$row['reserve_unit'],$row['reserve']);
				$row['reserve'] = $row['reserve'] * $row['ea'];
			}

			// 포인트계산
			$row['point'] += (int) $this->goodsmodel->get_point_with_policy($row['price']);
			$row['point'] = $row['point'] * $row['ea'];

			// 로우 길이
			$r_goods[$row['goods_seq']]['cnt']++;
			if($r_goods[$row['goods_seq']]['cnt'] == 1){
				$row['first'] = 1;
			}else{
				$row['first'] = 0;
			}

			// 상품별로 가격 마일리지 포인트 업데이트
			$r_goods[$row['goods_seq']]['price'] = $row['price'] * $row['ea'];
			$r_goods[$row['goods_seq']]['ea'] = $row['ea'];
			$r_goods[$row['goods_seq']]['reserve'] = (int) $row['reserve'];
			$r_goods[$row['goods_seq']]['point'] = (int) $row['point'];

			//suboption point
			$sub_total_sale_price = 0;
			foreach($cart_suboptions as $key_suboption => $data_suboption)
			{
				if($this->userInfo['member_seq']){
					// 포인트
					$data_suboption['point'] = (int) $this->goodsmodel->get_point_with_policy($data_suboption['price']);
					$data_suboption['point'] = $data_suboption['point'] * $data_suboption['ea'];
					// 마일리지
					$data_suboption['reserve'] = $this->goodsmodel->get_reserve_with_policy($row['reserve_policy'],$data_suboption['price'],$cfg_reserve['default_reserve_percent'],$data_suboption['reserve_rate'],$data_suboption['reserve_unit'],$data_suboption['reserve']);
					$data_suboption['reserve'] = $data_suboption['reserve'] * $data_suboption['ea'];
				}else{
					$data_suboption['reserve'] = 0;
					$data_suboption['point'] = 0;
				}
				$cart_suboptions[$key_suboption] = $data_suboption;

				// 상품별
				$r_goods[$row['goods_seq']]['reserve'] += (int) $data_suboption['reserve'];
				$r_goods[$row['goods_seq']]['point'] += (int) $data_suboption['point'];
				$r_goods[$row['goods_seq']]['ea'] += (int) $data_suboption['ea'];
				$r_goods[$row['goods_seq']]['price'] += $data_suboption['price'] * $data_suboption['ea'];
				$row['all_ea'] += (int) $data_suboption['ea'];

				// 추가 마일리지
				$row['suboption_point'] += $data_suboption['point'];
				$row['suboption_reserve'] += $data_suboption['reserve'];

				$row['tot_price'] += $data_suboption['price'] * $data_suboption['ea'];

				// 옵션별 구매수량
				$option_name = $data_suboption['suboption_title'].' ^^ '.$data_suboption['suboption'];
				$r_goods[$row['goods_seq']]['ea_for_suboption'][$option_name] += $data_suboption['ea'];

				// 장바구니 카운트
				$r_goods[$row['goods_seq']]['cnt']++;
				$sub_total_sale_price	+= $data_suboption['price'] * $data_suboption['ea'];
			}

			$row['cart_suboptions'] = $cart_suboptions ? $cart_suboptions : array();
			$row['cart_inputs'] = $cart_inputs;

			$shipping = $this->goodsmodel->get_goods_delivery($row,$row['ea']);
			$row['shipping_provider_seq'] = $shipping['provider_seq'];
			$row['shipping']			  = $shipping;
			$row['goods_name'] = strip_tags(str_replace(array("\"","'"),'',$row['goods_name']));
			$row['goods_shipping'] = 0;
			if($row['shipping_policy'] == 'goods'){
				$row['goods_shipping'] = $shipping['price'];
			}

			// 상품별 주문배송방법 선택 - 배송그룹 정의(입점사별 기본,개별정책)
			if($row['shipping_policy'] == 'goods'){
				$row['shipping_group'] = $row['shipping_method'].$row['goods_seq'];
			}else{
				$row['shipping_group'] = $row['shipping_method'].$row['shipping_provider_seq'];
			}

			// 새로운 shipping_grp 지정 :: 2016-08-08 lwh
			// 개별배송일때 버전상관없이 배송그룹코드에 cart_option_seq 포함하고 있어서 버전별 분기처리 삭제. @2019-03-13 pjm
			$each = '';
			if($row['shipping_calcul_type'] == 'each')	$each = '_'.$row['cart_option_seq'];
			$row['shipping_group'] = $row['goods_shipping_group_seq'].'_'.$row['shipping_set_seq'].'_'.$row['shipping_set_code'].$each;

			// 새로운 shipping_set_name 을 지정 :: 2016-10-26 lwh
			$row['shipping_method_name'] = $this->shippingmodel->ship_set_code[$row['shipping_set_code']];

			$shop_total_price += $row['tot_price'];
			if($row['tax']!="tax"){
				$shop_total_price_exempt += $row['tot_price'];
			}

			$provider_sum_goods_price[$shipping['provider_seq']] += $row['tot_price'];
			$shipping_group_sum_goods_price[$row['shipping_group']] += $row['tot_price'];

			// 상품별 저장
			$r_goods[$row['goods_seq']]['goods_name'] = $row['goods_name'];
			$r_goods[$row['goods_seq']]['provider_seq'] = $row['provider_seq'];
			$r_goods[$row['goods_seq']]['shipping_group'] = $row['shipping_group'];
			$r_goods[$row['goods_seq']]['price'] += $row['price'] * $row['ea'];
			$r_goods[$row['goods_seq']]['ea'] += $row['ea'];
			$r_goods[$row['goods_seq']]['option_ea'] += $row['ea'];
			$r_goods[$row['goods_seq']]['shipping_weight_policy'] = $row['shipping_weight_policy'];
			$r_goods[$row['goods_seq']]['goods_weight'] = $row['goods_weight'];
			$r_goods[$row['goods_seq']]['shipping_policy'] = $row['shipping_policy'];
			$r_goods[$row['goods_seq']]['goods_shipping_policy'] = $row['goods_shipping_policy'];
			$r_goods[$row['goods_seq']]['unlimit_shipping_price'] = $row['unlimit_shipping_price'];
			$r_goods[$row['goods_seq']]['limit_shipping_price'] = $row['limit_shipping_price'];
			$r_goods[$row['goods_seq']]['limit_shipping_ea'] = $row['limit_shipping_ea'];
			$r_goods[$row['goods_seq']]['limit_shipping_subprice'] = $row['limit_shipping_subprice'];
			$r_goods[$row['goods_seq']]['shipping_weight_policy'] = $row['shipping_weight_policy'];
			$r_goods[$row['goods_seq']]['reserve'] += (int) $row['reserve'];
			$r_goods[$row['goods_seq']]['point'] += (int) $row['point'];
			$r_goods[$row['goods_seq']]['tax'] = $row['tax'];
			$r_goods[$row['goods_seq']]['shipping_provider_seq'] = $shipping['provider_seq'];
			$r_goods[$row['goods_seq']]['event'] = $row['event'];

			// 배송 그룹별 저장
			$r_shipping_group[$row['shipping_group']]['goods_seq'] = $row['goods_seq'];
			$r_shipping_group[$row['shipping_group']]['provider_seq'] = $row['provider_seq'];
			$r_shipping_group[$row['shipping_group']]['shipping_policy'] = $row['shipping_policy'];
			$r_shipping_group[$row['shipping_group']]['goods_shipping_policy'] = $row['goods_shipping_policy'];
			$r_shipping_group[$row['shipping_group']]['unlimit_shipping_price'] = $row['unlimit_shipping_price'];
			$r_shipping_group[$row['shipping_group']]['limit_shipping_price'] = $row['limit_shipping_price'];
			$r_shipping_group[$row['shipping_group']]['limit_shipping_ea'] = $row['limit_shipping_ea'];
			$r_shipping_group[$row['shipping_group']]['limit_shipping_subprice'] = $row['limit_shipping_subprice'];
			$r_shipping_group[$row['shipping_group']]['shipping_weight_policy'] = $row['shipping_weight_policy'];
			$r_shipping_group[$row['shipping_group']]['price'] += $row['tot_price'];
			$r_shipping_group[$row['shipping_group']]['unit_price'] += $row['price'];
			$r_shipping_group[$row['shipping_group']]['ea'] += $row['all_ea'];
			$r_shipping_group[$row['shipping_group']]['tax'] = $row['tax'];
			$r_shipping_group[$row['shipping_group']]['shipping_provider_seq'] = $shipping['provider_seq'];
			$r_shipping_group[$row['shipping_group']]['shipping_method'] = $row['shipping_method'];


			//티켓상품저장@2013-10-22
			$r_goods[$row['goods_seq']]['socialcp_input_type'] = $row['socialcp_input_type'];
			$r_goods[$row['goods_seq']]['socialcp_cancel_type'] = $row['socialcp_cancel_type'];
			$r_goods[$row['goods_seq']]['socialcp_use_return'] = $row['socialcp_use_return'];
			$r_goods[$row['goods_seq']]['socialcp_use_emoney_day'] = $row['socialcp_use_emoney_day'];
			$r_goods[$row['goods_seq']]['socialcp_use_emoney_percent'] = $row['socialcp_use_emoney_percent'];

			$r_goods[$row['goods_seq']]['socialcp_cancel_use_refund'] = $row['socialcp_cancel_use_refund'];
			$r_goods[$row['goods_seq']]['socialcp_cancel_payoption'] = $row['socialcp_cancel_payoption'];
			$r_goods[$row['goods_seq']]['socialcp_cancel_payoption_percent'] = $row['socialcp_cancel_payoption_percent'];

			// 과세 비과세
			if($row['tax']=="exempt"){
				$exempt_chk++;
			}


			// 총상품금액
			$total += $row['price'];

			// 총수량
			$total_ea += $row['ea'];

			// 총 상품금액
			$total_sale_price	+= $row['price'] * $row['ea'] + $sub_total_sale_price;

			$result[] = $row;
		}

		### 과세 비과세
		if($num_rows==$exempt_chk){
			$tax_type = "exempt";
		}else if($exempt_chk == 0){
			$tax_type = "tax";
		}else{
			$tax_type = "mix";
		}

		// 배송비계산
		$row = array();
		foreach($r_shipping_group as $shipping_group => $row){
			$goods_seq = $row['goods_seq'];
			$param = $row;
			$param['price'] = $row['unit_price'];

			$shipping = $this->goodsmodel->get_goods_delivery($param,$row['ea']);
			$provider_shipping_policy[$shipping['provider_seq']] = $shipping;

			// 상품별 주문배송방법 선택 배송정책
			$shipping_group_policy[$shipping_group] = $shipping;

			$row['goods_shipping'] = 0;
			if($row['shipping_policy'] == 'shop' && preg_match('/delivery/',$shipping_group) ){
				$shop_shipping_policy = $shipping;
				$default_box_ea = true;
			}else if($row['shipping_policy'] == 'goods' && preg_match('/delivery/',$shipping_group) ) {
				$r_goods[$row['goods_seq']]['goods_shipping'] = $shipping['price'];
				$box_ea += $shipping['box_ea'];
				$provider_box_ea[$row['provider_seq']] += $shipping['box_ea'];
				$shipping_price['goods'] += $shipping['price'];
				$provider_shipping_price[$row['shipping_provider_seq']]['goods'] += $shipping['price'];

				// 상품별 주문배송방법 선택 개별 배송비
				$shipping_group_price[$shipping_group]['goods'] += $shipping['price'];
			}

			if($row['tax']=="exempt"){
				$shipping_exempt += $shipping['price'];
			}
		}

		if($shop_total_price && $shop_shipping_policy['free']){
			if($shop_shipping_policy['free'] <= $shop_total_price){
				$shipping_price['shop'] = 0;
			}
		}

		foreach($provider_shipping_policy as $provider_seq=>$row){
			if($provider_sum_goods_price[$provider_seq] && $row['free'] && $row['free'] <= $provider_sum_goods_price[$provider_seq]){
				$provider_shipping_price[$row['provider_seq']]['shop'] += 0;
			}else{
				$provider_shipping_price[$row['provider_seq']]['shop'] += $row['policy']=='shop' ? $row['price'] : 0;
			}
		}


		// 상품별 주문배송방법 선택
		foreach($shipping_group_policy as $shipping_group=>$row){

			if(preg_match('/delivery/',$shipping_group)){

				if( $row['policy'] == 'shop' ){
					if($shipping_group_sum_goods_price[$shipping_group] && $row['free'] && $row['free'] <= $shipping_group_sum_goods_price[$shipping_group]){
						$shipping_price['shop'] += 0;
						$shipping_groupg_price[$shipping_group]['shop'] += 0;
					}else{
						$shipping_price['shop'] += $row['policy']=='shop' ? $row['price'] : 0;
						$shipping_group_price[$shipping_group]['shop'] += $row['policy']=='shop' ? $row['price'] : 0;
					}
				}
			}else{
				$shipping_group_price[$shipping_group]['postpaid'] = $row['postpaid'];
				$shipping_group_price[$shipping_group]['summary'] = $row['summary'];
			}
		}

		foreach($result as $k=>$row){
			if(!$k || $prev_shipping_provider_seq!=$row['shipping_provider_seq'] || $prev_shipping_group!=$row['shipping_group'] ){
				$result[$k]['shipping_provider_division'] = true;
			}
			$prev_shipping_provider_seq = $row['shipping_provider_seq'];
			$prev_shipping_group		= $row['shipping_group'];

			// 중복 으로 인한 제거 - 이견 없을시 추후 삭제 :: 2015-10-08 lwh
			//$shipping_company_cnt[$row['shipping_provider_seq']]++;
			$shipping_company_cnt[$row['shipping_group']]++;

			if(is_array($row['cart_suboptions']) && count($row['cart_suboptions']) > 0){
				// 중복 으로 인한 제거 - 이견 없을시 추후 삭제 :: 2015-10-08 lwh
				//$shipping_company_cnt[$row['shipping_provider_seq']] += count($row['cart_suboptions']);
				$shipping_company_cnt[$row['shipping_group']] += count($row['cart_suboptions']);
			}
		}

		if( $shop_total_price && $default_box_ea)$box_ea += 1;
		$total_price = $total + array_sum($shipping_price);

		$exempt_price = $shop_total_price_exempt;
		$arr = array(
			'person'=>$person,
			'data_goods'=>$r_goods,
			'total_reserve'=>$total_reserve,
			'total_point'=>$total_point,
			'taxtype'=>$tax_type,
			'exempt_shipping'=>$shipping_exempt,
			'exempt_price'=>$exempt_price,
			'list'=>$result,
			'total'=>$total,
			'total_sale_price'=>$total_sale_price,
			'total_ea'=>$total_ea,
			'shipping_price'=>$shipping_price,
			'shipping_company_cnt'=>$shipping_company_cnt,
			'provider_shipping_price'=>$provider_shipping_price,
			'provider_shipping_policy'=>$provider_shipping_policy,
			'provider_box_ea'=>$provider_box_ea,
			'shop_shipping_policy'=>$shop_shipping_policy,
			'total_price'=>$total_price,
			'promocodeSale'=>$promocodeSale,
			'box_ea'=>$box_ea
		);

		// 상품별 주문배송방법 선택
		$arr['shipping_group_price'] = $shipping_group_price;
		$arr['shipping_group_policy'] = $shipping_group_policy;

		return $arr;
	}

	public function cart_list($member_seq="", $person_seq="0"){

		$this->load->model('goodsmodel');
		$this->load->model('categorymodel');
		$this->load->model('promotionmodel');
		$this->load->model('membermodel');
		$this->load->helper('order');
		$this->load->library('sale');

		$total						= 0;
		$result						= "";
		$where_query				= "";
		$shop_total_price			= 0;
		$shop_total_price_exempt	= 0;
		$exempt_chk					= 0;
		$shop_shipping_policy		= "";
		$session_id					= session_id();

		$cfg_reserve				= config_load('reserve');
		$mode						= 'cart';

		$where_arr[]				= $mode;
		$where_query[]				= "cart.member_seq = ?";
		$where_arr[]				= $member_seq;

		if($person_seq){
			$where_query[]			= "cart.person_seq = ?";
			$where_arr[]			= $person_seq;
		}else{
			$where_query[]			= "(cart.person_seq = ? or cart.person_seq is null)";
			$where_arr[]			= $person_seq;
		}

		$query = "
		SELECT
			cart.cart_seq,cart.fblike,
			goods.goods_seq,goods.goods_name,goods.goods_code,
			goods.shipping_weight_policy,goods.goods_weight,
			goods.shipping_policy,goods.goods_shipping_policy,
			goods.unlimit_shipping_price,goods.limit_shipping_price,
			goods.limit_shipping_ea,goods.limit_shipping_subprice,
			goods_img.image,
			(
				SELECT sum(ea)
				FROM fm_person_cart_suboption
				WHERE cart_seq=cart.cart_seq
			) sub_ea,
			sum(cart_opt.ea) ea,
			(
				SELECT COUNT(cart_suboption_seq)
				FROM fm_person_cart_suboption
				WHERE cart_seq=cart.cart_seq
			) sub_cnt,
			(
				SELECT SUM(g.price*s.ea)
				FROM fm_goods_suboption g,fm_person_cart_suboption s
				WHERE g.goods_seq=cart.goods_seq
				AND g.suboption=s.suboption
				AND g.suboption_title=s.suboption_title
				AND s.cart_seq=cart.cart_seq
			) sub_price,
			(
				SELECT SUM(g.reserve*s.ea)
				FROM fm_goods_suboption g,fm_person_cart_suboption s
				WHERE g.goods_seq=cart.goods_seq
				AND g.suboption=s.suboption
				AND g.suboption_title=s.suboption_title
				AND s.cart_seq=cart.cart_seq
			) sub_reserve,
			goods_opt.price,
			goods_opt.consumer_price,
			goods_opt.reserve as reserve_unit,
			SUM(IF(cart_opt.option1!='',1,0)) opt_cnt,
			SUM(goods_opt.reserve*cart_opt.ea) reserve,
			goods.reserve_policy,
			goods.multi_discount_use,
			goods.multi_discount_ea,
			goods.multi_discount,
			goods.multi_discount_unit,
			goods.tax,
			goods.provider_seq,
			goods.adult_goods,
			goods.option_international_shipping_status,
			goods.cancel_type,
			goods.shipping_group_seq as goods_shipping_group_seq,
			goods.sale_seq,
			cart.shipping_group_seq,
			cart.shipping_set_seq,
			cart.shipping_set_code,
			cart.shipping_hop_date,
			cart.shipping_store_seq,
			cart.shipping_prepay_info,
			cart_opt.*,
			goods.display_terms,
			goods.display_terms_text,
			goods.display_terms_color,
			goods.display_terms_begin,
			goods.display_terms_end,
			goods.multi_discount_policy
		FROM
			fm_person_cart cart
			left join fm_goods_image goods_img on goods_img.cut_number = 1 AND goods_img.image_type = 'thumbCart' AND cart.goods_seq = goods_img.goods_seq
			,fm_goods goods
			,fm_person_cart_option cart_opt
			,fm_goods_option goods_opt
		WHERE
			cart.distribution=?
			AND cart.goods_seq = goods.goods_seq
			AND cart.cart_seq = cart_opt.cart_seq
			AND cart.goods_seq = goods_opt.goods_seq
			AND cart_opt.option1 = goods_opt.option1
			AND cart_opt.option2 = goods_opt.option2
			AND cart_opt.option3 = goods_opt.option3
			AND cart_opt.option4 = goods_opt.option4
			AND cart_opt.option5 = goods_opt.option5";
		if($where_query){
			$query .= ' AND '.implode(' AND ', $where_query);
		}
		//$query .= " GROUP BY cart.cart_seq ORDER BY cart.cart_seq DESC";
		## 배송업체별, 배송정책(기본,개별) 정렬 추가
		$query .= " GROUP BY cart.cart_seq ORDER BY goods.provider_seq asc,goods.shipping_policy asc,cart.cart_seq DESC";

		$query						= $this->db->query($query,$where_arr);

		$shipping_price['goods']	= 0;
		$shipping_exempt			= 0;
		$promocodeSale				= 0;
		$total_reserve				= 0;
		$total_point				= 0;
		$cart_items					= $query->result_array();

		$provider_shipping_policy	= array();
		$provider_sum_goods_price	= array();
		$provider_shipping_price	= array();
		$provider_box_ea			= array();

		if	($member_seq > 0){
			$members				= $this->membermodel->get_member_data($member_seq);
		}
		//--> sale library 적용
		$applypage						= 'order';
		$param['cal_type']				= 'list';
		$param['member_seq']			= $members['member_seq'];
		$param['group_seq']				= $members['group_seq'];
		$this->sale->set_init($param);
		$this->sale->preload_set_config($applypage);
		//<-- sale library 적용

		foreach ($cart_items as $row){

			$categorys = $this->goodsmodel->get_goods_category($row['goods_seq']);
			foreach($categorys as $key => $data) $row['r_category'] = $this->categorymodel->split_category($data['category_code']);

			if (trim($row['multi_discount_policy'])){
				$row['multi_discount_policy']	= json_decode($row['multi_discount_policy'], 1);
			}else{
				$row['multi_discount_policy']	= '';
			}

			$cart_options		= $this->personcartmodel->get_cart_option($row['cart_seq']);
			$cart_suboptions	= $this->personcartmodel->get_cart_suboption($row['cart_seq']);
			$cart_inputs		= $this->personcartmodel->get_cart_input($row['cart_seq']);
			$shipping			= $this->goodsmodel->get_goods_delivery($row,$row['ea']);
			$suboptions			= $this->goodsmodel->get_goods_suboption($row['goods_seq']);

			$cnt_sub_required = 0;
			$suboption_title_required = '';
			if (is_array($suboptions)) {
				foreach ($suboptions as $key_option => $data_option) {
					foreach($data_option as $k => $sub_opt){
						if ($sub_opt['sub_required'] == 'y') {
							$suboption_title_required = $sub_opt['suboption_title'];
							$cnt_sub_required++;
						}
					}
				}
			}
			$row['cnt_sub_required']				= $cnt_sub_required;
			$row['suboption_title_required']		= $suboption_title_required;

			if(!in_array($shipping['provider_seq'],array_keys($provider_shipping_policy))){
				$provider_shipping_policy[$shipping['provider_seq']] = $shipping;
			}

			$row['shipping_provider_seq'] = $shipping['provider_seq'];
			$row['shipping']			  = $shipping;

			//예약 상품의 경우 문구를 넣어준다 2016-11-07
			$row['goods_name'] = get_goods_pre_name($row,true,true);
			$row['goods_name'] = strip_tags(str_replace(array("\"","'"),'',$row['goods_name']));

			// 복수구매 할인 적용
			$arr_multi = array(
				'multi_discount_use' => $row['multi_discount_use'],
				'multi_discount_ea' => $row['multi_discount_ea'],
				'multi_discount' => $row['multi_discount'],
				'multi_discount_unit' => $row['multi_discount_unit']
			);

			//----> sale library 적용
			unset($param,$sales,$row['reserve'],$row['point']);
			$param['option_type']				= 'option';
			$param['consumer_price']		= $row['consumer_price'];
			$param['price']						= $row['org_price'];
			$param['sale_price']				= $row['price'];
			$param['ea']					= $row['ea'];
			$param['goods_ea']				= $goods_ea[$row['goods_seq']];
			$param['category_code']			= $row['r_category'];
			$param['goods_seq']				= $row['goods_seq'];
			$param['goods']					= $row;
			$this->sale->set_init($param);
			$sales	= $this->sale->calculate_sale_price($applypage);

			$row['sales']					= $sales;
			$row['basic_sale']				= $sales['one_sale_list']['basic'];
			$row['event_sale_target']		= ($sales['target_list']['event'] == 1) ? 'consumer_price' : 'price';
			$row['event_sale']				= $sales['one_sale_list']['event'];
			$row['multi_sale']				= $sales['one_sale_list']['multi'];
			$row['event']					= $this->sale->cfgs['event'];
			$row['price']					= $sales['one_result_price'];
			$row['reserve']					= $sales['one_tot_reserve'];
			$row['point']					= $sales['one_tot_point'];
			$row['eventEnd']				= $sales['eventEnd'];
			$this->sale->reset_init();
			unset($sales);
			//<---- sale library 적용

			if($row['reserve_policy'] != 'goods') $row['reserve'] = 0;
			foreach($cart_options as $key_option => $data_option){
				$data_option['ori_price'] = $data_option['price'];

				// 이벤트 할인 /적립
				$data_option['event'] = get_event_price($data_option['ori_price'], $row['goods_seq'], $arr_category, $data_option['consumer_price'], $row);
				if($data_option['event']['event_seq']) {
					if($data_option['event']['target_sale'] == 1 && $data_option['consumer_price'] > 0 ){//정가기준 할인시
						$data_option['price'] = ($data_option['consumer_price'] > $data_option['event']['event_sale_unit'])?$data_option['consumer_price'] - (int) $data_option['event']['event_sale_unit']:0;
					}else{
						$data_option['price'] = ($data_option['price'] > $data_option['event']['event_sale_unit'])?$data_option['price'] - (int) $data_option['event']['event_sale_unit']:0;
					}
				}

				// 복수구매 할인
				$data_option['price'] = (int) $this->goodsmodel->get_multi_sale_price($row['ea'],$data_option['price'],$arr_multi);
				$row['tot_price'] += $data_option['price'] * $data_option['ea'];

				// 마일리지 계산
				$data_option['reserve'] = $this->goodsmodel->get_reserve_with_policy($row['reserve_policy'],$data_option['price'],$cfg_reserve['default_reserve_percent'],$data_option['reserve_rate'],$data_option['reserve_unit'],$data_option['reserve']);
				$data_option['reserve'] += (int) $data_option['event']['event_reserve_unit'];
				$row['reserve'] += $data_option['reserve'] * $data_option['ea'];

				$cart_options[$key_option] = $data_option;
			}

			// 추가옵션 마일리지
			$row['reserve']			+= $row['sub_reserve'];

			$row['cart_options']	= $cart_options;
			//$row['cart_suboptions'] = $cart_suboptions;
			$row['cart_suboptions'] = $cart_suboptions ? $cart_suboptions : array();
			$row['cart_inputs']		= $cart_inputs;

			// 포인트계산
			$row['point']			+= $this->goodsmodel->get_point_with_policy($row['price']);
			$row['point']			= $row['point'] * $row['ea'];

			$row['tot_price']		+= $row['sub_price'];
			$row['tot_ea']			+= $row['ea'];
			$row['tot_ea']			+= $row['sub_ea'];
			$total_point			+= $row['point'];
			$total_reserve			+= $row['reserve'];

			$row['goods_shipping'] = 0;

			//기본배송
			if($row['shipping_policy'] == 'shop'){
				if($row['tax']!="tax"){
					$shop_total_price_exempt += $row['tot_price'];
				}
				//$shop_shipping_policy = $shipping;
			}
			//개별배송
			else{
				$row['goods_shipping'] = $shipping['price'];
				$shipping_price['goods'] += $row['goods_shipping'];
				$provider_shipping_price[$row['shipping_provider_seq']]['goods'] += $row['goods_shipping'];
				$provider_box_ea[$row['provider_seq']] += $shipping['box_ea'];
				$box_ea += $shipping['box_ea'];
				if($row['tax']!="tax"){
					$shop_total_price_exempt += $row['tot_price'];
					$shipping_exempt += $shipping['price'];
				}
			}

			$shop_total_price += $row['tot_price'];
			$provider_sum_goods_price[$shipping['provider_seq']] += $row['tot_price'];

			###
			if($row['tax']!="tax"){
				$exempt_chk++;
			}

			$total += $row['tot_price'];
			$result[] = $row;
		}

		###
		if($query->num_rows()==$exempt_chk){
			$tax_type = "exempt";
		}else if($exempt_chk == 0){
			$tax_type = "tax";
		}else{
			$tax_type = "mix";
		}


		if($member_seq && $result) foreach($result as $k => $row){
			$categorys = $this->goodsmodel->get_goods_category($row['goods_seq']);
			foreach($categorys as $key => $data) $arr_category = $this->categorymodel->split_category($data['category_code']);
			foreach($row['cart_options'] as $key_option => $data_option){
				$add_reserve = (int) $this->membermodel->get_group_addreseve($member_seq,$data_option['price'],$total,$row['goods_seq'],$arr_category);
				$data_option['reserve'] += $add_reserve;

				$row['reserve'] += $add_reserve*$data_option['ea'];
				$row['cart_options'][$key_option] = $data_option;
			}
			$result[$k] = $row;
		}


		foreach($result as $k => $row){$result[$k]['promocodeSale']=0;
			foreach($row['cart_options'] as $key_option => $data_option){
				if($data_option['promotion_code_seq'] && $data_option['promotion_code_serialnumber']) {
					//프로모션코드할인
					$promotions = $this->promotionmodel->get_able_download_saleprice($data_option['promotion_code_seq'],$data_option['promotion_code_serialnumber'], $total, $data_option['price'],$data_option['ea']);
					$result[$k]['cart_options'][$key_option]['promotioncode_sale'] = (int) $promotions['promotioncode_sale'];
					$result[$k]['promocodeSale'] += (int) $promotions['promotioncode_sale'];
					$promocodeSale += (int) $promotions['promotioncode_sale'];
				}
			}
		}

		foreach($provider_shipping_policy as $provider_seq=>$row){
			if($provider_sum_goods_price[$provider_seq] && $row['free'] && $row['free'] <= $provider_sum_goods_price[$provider_seq]){
				$shipping_price['shop'] += 0;
				$provider_shipping_price[$row['provider_seq']]['shop'] += 0;
			}else{
				$shipping_price['shop'] += $row['policy']=='shop' ? $row['price'] : 0;
				$provider_shipping_price[$row['provider_seq']]['shop'] += $row['policy']=='shop' ? $row['price'] : 0;
			}
		}

		if( $shop_total_price )$box_ea += 1;
		foreach($provider_sum_goods_price as $provider_seq => $value){
			if($value) $provider_box_ea[$provider_seq] += 1;
		}

		$total_price	= $total + array_sum($shipping_price);
		$exempt_price	= $shop_total_price_exempt;

		/* 배송그룹에 의한 배송업체별 입점사코드 순서대로 정렬 */
		/*
		function cmp($a, $b)
		{
		    if ($a['shipping_provider_seq'] == $b['shipping_provider_seq']) return 0;
		    return ($a['shipping_provider_seq'] < $b['shipping_provider_seq']) ? -1 : 1;
		}
		usort ($result, "cmp");
		*/
		foreach($result as $k=>$row){
			## 배송방법 : 입점사별 > 배송방법별(기본,개별)
			if(!$k || $prev_shipping_provider_seq!=$row['shipping_provider_seq'] ||  $row['shipping_policy'] != $prev_shipping_policy){
				$result[$k]['shipping_provider_division'] = true;
			}
			$prev_shipping_provider_seq = $row['shipping_provider_seq'];
			$prev_shipping_policy		= $row['shipping_policy'];	//기본배송, 개별배송

			/* 배송업체정보 */
			$shipping_company_cnt[$row['shipping_provider_seq']][$row['shipping_policy']]++;
		}

		$arr = array(
			'taxtype'=>$tax_type,
			'exempt_shipping'=>$shipping_exempt,
			'exempt_price'=>$exempt_price,
			'list'=>$result,
			'total'=>$total,
			'total_reserve'=>$total_reserve,
			'total_point'=>$total_point,
			'shipping_price'=>$shipping_price,
			'shipping_company_cnt'=>$shipping_company_cnt,
			'provider_shipping_price'=>$provider_shipping_price,
			'provider_shipping_policy'=>$provider_shipping_policy,
			'provider_box_ea'=>$provider_box_ea,
			//'shop_shipping_policy'=>$shop_shipping_policy,
			'total_price'=>$total_price,
			'promocodeSale'=>$promocodeSale,
			'box_ea'=>$box_ea
		);

		return $arr;
	}

	function merge_for_goods($goods_seq,$cart_seq,$member_seq=''){

		$session_id = session_id();
		//if(!$member_seq ) $member_seq = $this->userInfo['member_seq'];

		$options = $this->get_cart_option($cart_seq);
		$suboptions = $this->get_cart_suboption($cart_seq);

		if($member_seq) $this->db->where('member_seq',$member_seq);
		else $this->db->where('session_id',$session_id);

		$this->db->where('goods_seq',$goods_seq);
		$this->db->where('cart_seq !=',$cart_seq);
		$this->db->where('distribution','cart');
		$this->db->select('cart_seq');
		$query = $this->db->get('fm_person_cart');


		foreach($query->result_array() as $row){
			$pre_cart_seq = $row['cart_seq'];
			$pre_options = $this->get_cart_option($pre_cart_seq);
			if($pre_options && $options){
				foreach($pre_options as $pre_option){
					foreach($options as $k => $option){
						if(
						$pre_option['option1'] == $option['option1'] &&
						$pre_option['option2'] == $option['option2'] &&
						$pre_option['option3'] == $option['option3'] &&
						$pre_option['option4'] == $option['option4'] &&
						$pre_option['option5'] == $option['option5']
						){
							$this->db->where('cart_option_seq', $pre_option['cart_option_seq']);
							$this->db->where('cart_seq', $pre_cart_seq);
							$this->db->delete('fm_person_cart_option');
						}
					}
				}
			}
			$this->db->where('cart_seq', $pre_cart_seq);
			$this->db->update('fm_person_cart_option', array('cart_seq'=>$cart_seq));

			$pre_suboptions = $this->get_cart_suboption($pre_cart_seq);
			if( $pre_suboptions && $suboptions ){
				foreach($pre_suboptions as $pre_suboption){
					foreach($suboptions as $k => $suboption){
						if(
						$pre_suboption['suboption_title'] == $suboption['suboption_title'] &&
						$pre_suboption['suboption'] == $suboption['suboption']
						){
							$this->db->where('cart_suboption_seq', $pre_suboption['cart_suboption_seq']);
							$this->db->where('cart_seq', $pre_cart_seq);
							$this->db->delete('fm_person_cart_suboption');
						}
					}
				}
			}

			$this->db->where('cart_seq', $pre_cart_seq);
			$this->db->update('fm_person_cart_suboption', array('cart_seq'=>$cart_seq));
			$this->db->where('cart_seq', $pre_cart_seq);
			$this->db->update('fm_person_cart_input', array('cart_seq'=>$cart_seq));
			$this->db->delete('fm_person_cart',array('cart_seq' => $pre_cart_seq));
		}
	}

	public function delete_cart_option($cart_option_seq,$mode='del')
	{
		$data = $this->get_cart_option_by_cart_option($cart_option_seq);
		$cart_seq = $data['cart_seq'];

		$bind[0]=$cart_option_seq;
		$query="delete from fm_person_cart_option where cart_option_seq=?";
		$this->db->query($query,$bind);
		$query="delete from fm_person_cart_suboption where cart_option_seq=?";
		$this->db->query($query,$bind);
		$query="delete from fm_person_cart_input where cart_option_seq=?";
		$this->db->query($query,$bind);

		if($mode == 'del'){
			$query = "select count(*) cnt from fm_person_cart_option where cart_seq=?";
			$query = $this->db->query($query,array($cart_seq));
			$data = $query->row_array();
			$cnt = $data['cnt'];
			if($cnt==0){
				$query="delete from fm_person_cart where cart_seq=?";
				$this->db->query($query,array($cart_seq));
			}
		}
	}

	public function get_cart_by_cart_option($cart_option_seq)
	{
		$bind[0] = $cart_option_seq;
		$query = "select * from fm_person_cart where cart_seq = (select cart_seq from fm_person_cart_option where cart_option_seq=?)";
		$query = $this->db->query($query,$bind);
		$data = $query->row_array();
		return $data;
	}

	public function get_cart_option_by_cart_option($cart_option_seq)
	{
		$bind[0] = $cart_option_seq;
		$query = "
			SELECT cart.*,goods.price,goods.consumer_price,goods.goods_seq,
			goods.reserve_rate,goods.reserve_unit,goods.reserve,goods.commission_rate,goods.commission_type,
			(select supply_price from fm_goods_supply where option_seq=goods.option_seq and goods_seq=goods.goods_seq) supply_price
			FROM fm_person_cart_option cart,fm_goods_option goods
			WHERE cart.cart_option_seq=?
			";

		if($goods_seq){
			$query .= "and goods.goods_seq='".$goods_seq."'";
		}else{
			$query .= "
			AND goods.goods_seq =
			(
				select goods_seq from fm_person_cart where cart_seq=cart.cart_seq
			)
			";
		}

		$query .="
			AND cart.option1=goods.option1
			AND cart.option2=goods.option2
			AND cart.option3=goods.option3
			AND cart.option4=goods.option4
			AND cart.option5=goods.option5";
		$query = $this->db->query($query,$bind);
		$data = $query->row_array();
		return $data;
	}

	// 주문되지 않은 장바구니가 있는 경우 삭제
	public function delete_dummy_cart(){

		$sql	= "select cart_seq from fm_person_cart where person_seq = '0' ";
		$query	= $this->db->query($sql);
		$result	= $query->result_array();
		if	($result)foreach($result as $k => $data){
			//주문 안된 장바구니 삭제
			$this->db->query("delete from fm_person_cart_option where cart_seq = ? ", array($data['cart_seq']));
			$this->db->query("delete from fm_person_cart_input where cart_seq = ? ", array($data['cart_seq']));
			$this->db->query("delete from fm_person_cart_suboption where cart_seq = ? ", array($data['cart_seq']));
			$this->db->query("delete from fm_person_cart where cart_seq = ? ", array($data['cart_seq']));
		}
	}

	function insert_cart_alloption($cart_seq,$inputs,$shipping_method='')
	{
		$this->load->helper('copy');
		$this->load->library('upload');
		$this->load->model('goodsmodel');

		$catetmp = $this->goodsmodel->get_goods_category($_POST['goodsSeq']);
		unset($category);
		foreach($catetmp as $caterow) {
			if( strlen($caterow['category_code']) > 4) {
				if(strlen($caterow['category_code']) == 16) {
					$category[] = substr($caterow['category_code'], 0, 16);
					$category[] = substr($caterow['category_code'], 0, 12);
					$category[] = substr($caterow['category_code'], 0, 8);
					$category[] = substr($caterow['category_code'], 0, 4);
				}elseif(strlen($caterow['category_code']) == 12) {
					$category[] = substr($caterow['category_code'], 0, 12);
					$category[] = substr($caterow['category_code'], 0, 8);
					$category[] = substr($caterow['category_code'], 0, 4);
				}elseif(strlen($caterow['category_code']) == 8) {
					$category[] = substr($caterow['category_code'], 0, 8);
					$category[] = substr($caterow['category_code'], 0, 4);
				}else{
					$category[] = substr($caterow['category_code'], 0, 4);
				}
			}else{
				$category[] = $caterow['category_code'];
			}
		}

		$brands = $this->goodsmodel->get_goods_brand($_POST['goodsSeq']);
		unset($brand_code);
		if($brands) foreach($brands as $bkey => $branddata){
			if( $branddata['link'] == 1 ){
				$brand_codear= $this->brandmodel->split_brand($branddata['category_code']);
				$brand_code[] = $brand_codear[0];
			}
		}

		$cart = $this->catalog($this->is_adminOrder);
		unset($insert_data,$max);
		foreach($_POST['optionEa'] as $k1 => $ea){
			unset($insert_data,$max);
			for($i=0;$i<5;$i++){
				if( !isset($_POST['option'][$i][$k1]) || !$_POST['option'][$i][$k1] ) $_POST['option'][$i][$k1] = "";
				if( !isset($_POST['optionTitle'][$i][$k1]) || !$_POST['optionTitle'][$i][$k1] ) $_POST['optionTitle'][$i][$k1] = null;
			}
			$insert_data['option1']		= $_POST['option'][0][$k1];
			$insert_data['title1']		= $_POST['optionTitle'][0][$k1];
			$insert_data['option2']		= $_POST['option'][1][$k1];
			$insert_data['title2']		= $_POST['optionTitle'][1][$k1];
			$insert_data['option3']		= $_POST['option'][2][$k1];
			$insert_data['title3']		= $_POST['optionTitle'][2][$k1];
			$insert_data['option4']		= $_POST['option'][3][$k1];
			$insert_data['title4']		= $_POST['optionTitle'][3][$k1];
			$insert_data['option5']		= $_POST['option'][4][$k1];
			$insert_data['title5']		= $_POST['optionTitle'][4][$k1];
			$insert_data['ea'] 			= $ea;
			$insert_data['cart_seq']	= $cart_seq;

			// 배송방법 저장
			if(!$shipping_method){
				$insert_data['shipping_method'] = $_POST['shipping_method'];
			}else{
				$insert_data['shipping_method'] = $shipping_method;
			}

			if(!$insert_data['shipping_method']) $insert_data['shipping_method'] = "delivery";

			/**
			**/
			if( $this->session->userdata('cart_promotioncode_'.session_id()) ){

				$sc['whereis'] = " and promotion_input_serialnumber ='".$this->session->userdata('cart_promotioncode_'.session_id())."'";
				$promotioncode = $this->promotionmodel->get_data($sc);
				$promotioncode = $promotioncode[0];

				list($price,$reserve) = $this->goodsmodel->get_goods_option_price(
					$_POST['goodsSeq'],
					$insert_data['option1'],
					$insert_data['option2'],
					$insert_data['option3'],
					$insert_data['option4'],
					$insert_data['option5']
				);

				if( strstr($promotioncode['type'],'promotion') ){//일반코드
					$promotions = $this->promotionmodel->get_able_promotion_list($_POST['goodsSeq'], $category, $brand_code, $cart['total'], $this->session->userdata('cart_promotioncode_'.session_id()), $price, $ea );
				}else{//개별코드
					$promotions = $this->promotionmodel->get_able_download_list($_POST['goodsSeq'], $category, $brand_code, $cart['total'], $this->session->userdata('cart_promotioncode_'.session_id()), $price, $ea );
				}

				if( $promotions) {
					if($promotions['duplication_use'] == 1) {//중복할인은 무조건추가
							$insert_data['promotion_code_seq']	= $this->session->userdata('cart_promotioncodeseq_'.session_id());
							$insert_data['promotion_code_serialnumber']	= $this->session->userdata('cart_promotioncode_'.session_id());
					}else{//중복할인이 아닌경우 상품 할인가(판매가)가 최대값인 상품으로 처리함
						foreach($cart['list'] as $cartkey => $cartdata){

							if($_POST['goodsSeq'] == $cartdata['goods_seq']) {

								if( ($max[$_POST['goods_seq']] && $max[$_POST['goods_seq']] < $price) || !$max[$_POST['goods_seq']]){
									$insert_data['promotion_code_seq']	= $this->session->userdata('cart_promotioncodeseq_'.session_id());
									$insert_data['promotion_code_serialnumber']	= $this->session->userdata('cart_promotioncode_'.session_id());

									$max[$_POST['goods_seq']] = $price;
									$upsql = "update fm_person_cart_option set promotion_code_seq=null,promotion_code_serialnumber=null where cart_seq = {$cartdata['cart_seq']} ";
									$this->db->query($upsql);
								}
							}
						}

						if($cart['list'] && !$max[$_POST['goods_seq']]){//최초상품인경우

							$insert_data['promotion_code_seq']	= $this->session->userdata('cart_promotioncodeseq_'.session_id());
							$insert_data['promotion_code_serialnumber']	= $this->session->userdata('cart_promotioncode_'.session_id());
						}
					}
				}
			}

			$this->db->insert('fm_person_cart_option', $insert_data);

			// 첫번째상품 일련번호구하기
			$cart_option_seq = $this->db->insert_id();
			if($k1 == 0) $first_cart_option_seq = $this->db->insert_id();

			// 장바구니 추가입력항목
			if( isset($_POST['inputsValue']) && is_array($_POST['inputsValue'][0])){
				// 2014-12-18 옵션 개편 후 (ocw)
				unset($insert_data);
				$path = "./data/order/";
				if( isset($_POST['inputsValue']) ){
					$k = 0;
					foreach($inputs as $key_input => $data_input){
						if( $data_input ){
							if($data_input['input_form']=='file'){

								$file_path = $_POST['inputsValue'][$key_input][$k1];

								/* 이미지파일 확장자 */
								$this->arrImageExtensions = array('jpg','jpeg','png','gif','bmp','tif','pic');
								$this->arrImageExtensions = array_merge($this->arrImageExtensions, array_map('strtoupper', $this->arrImageExtensions));
								$file_ext = end(explode('.', $file_path));

								if (preg_match("/^\/data\/tmp\//i", str_replace(realpath(ROOTPATH), "", realpath($file_path))) && file_exists($file_path)) {
									if (in_array($file_ext, $this->arrImageExtensions)) {
										$fname = $cart_seq . '_' . $cart_option_seq . '_' . $k . "." . $file_ext;
										$copyResult = copyFile($file_path, $path . $fname);
										if ($copyResult['result']) {
											$insert_data['type'] = 'file';
											$insert_data['input_title'] = $data_input['input_name'];
											$insert_data['input_value'] = $fname;
											$insert_data['cart_seq'] = $cart_seq;
											$insert_data['cart_option_seq']	= $cart_option_seq;
											$this->db->insert('fm_person_cart_input', $insert_data);
										}
										$k++;
									}
								} else {
									$insert_data['type'] = 'file';
									$insert_data['input_title'] = $_POST['inputsTitle'][$key_input][$k1];
									$insert_data['input_value'] = $file_path ? $file_path : '';
									$insert_data['cart_seq'] = $cart_seq;
									$insert_data['cart_option_seq']	= $cart_option_seq;
									$this->db->insert('fm_person_cart_input', $insert_data);
								}
							}else{
								$insert_data['type'] = 'text';
								$insert_data['input_title'] = $_POST['inputsTitle'][$key_input][$k1];
								$insert_data['input_value'] = $_POST['inputsValue'][$key_input][$k1];
								$insert_data['cart_seq'] = $cart_seq;
								$insert_data['cart_option_seq']	= $cart_option_seq;
								$this->db->insert('fm_person_cart_input', $insert_data);
							}
						}
					}
				}
			}

			//장바구니 추가입력옵션
			if( isset($_POST['suboption']) && isset($_POST['suboption_addposition']) ){
				foreach($_POST['suboption_addposition'] as $k2 => $addposition){
					if	($k1 == $addposition){
						unset($insert_data);
						$insert_data['ea']				= $_POST['suboptionEa'][$k2];
						$insert_data['suboption_title']	= $_POST['suboptionTitle'][$k2];
						$insert_data['suboption']		= $_POST['suboption'][$k2];
						$insert_data['cart_seq'] 		= $cart_seq;
						$insert_data['cart_option_seq']	= $cart_option_seq;
						$this->db->insert($this->tb_cart_suboption, $insert_data);
					}
				}
			}
		}

		// 장바구니 추가입력항목
		if( isset($_POST['inputsValue']) && !is_array($_POST['inputsValue'][0])){
			// 2014-12-18 옵션 개편 전 (ocw)
			unset($insert_data);
			$path = "./data/order/";
			$config['upload_path'] = $path;
			$config['allowed_types'] = implode('|', array('jpg','jpeg','png','gif','bmp','tif','pic'));
			$config['max_size']	= $this->config_system['uploadLimit'];
			if( isset($_POST['inputsValue']) ){
				$i = 0;
				$k =0;
				foreach($inputs as $key_input => $data_input){
					if( $data_input ){
						if($data_input['input_form']=='file'){
							if($_FILES['inputsValue']['tmp_name']){
								if($_FILES['inputsValue']['tmp_name'][$k]){
									$config['file_name'] = $cart_seq . '_' . $first_cart_option_seq . '_' . $k;
									$this->upload->initialize($config, true);
									if ($this->upload->do_upload('inputsValue', $k)) {
										$insert_data['type'] = 'file';
										$insert_data['input_title'] = $data_input['input_name'];
										$insert_data['input_value'] = $this->upload->file_name;
										$insert_data['cart_seq'] = $cart_seq;
										$insert_data['cart_option_seq']	= $first_cart_option_seq;
										$this->db->insert('fm_person_cart_input', $insert_data);
									}
								}
								$k++;
							}else if ($_POST['inputsValue'][$i]){
								$insert_data['type'] = 'file';
								$insert_data['input_title'] = $data_input['input_name'];
								$insert_data['input_value'] = $_POST['inputsValue'][$i];
								$insert_data['cart_seq'] = $cart_seq;
								$insert_data['cart_option_seq']	= $first_cart_option_seq;
								$this->db->insert('fm_person_cart_input', $insert_data);
								$i++;
							}
						}else{
							$insert_data['type'] = 'text';
							$insert_data['input_title'] = $data_input['input_name'];
							$insert_data['input_value'] = $_POST['inputsValue'][$i];
							$insert_data['cart_seq'] = $cart_seq;
							$insert_data['cart_option_seq']	= $first_cart_option_seq;
							$this->db->insert('fm_person_cart_input', $insert_data);
							$i++;
						}
					}
				}
			}
		}

		//장바구니 추가입력옵션
		unset($insert_data);
		if( isset($_POST['suboption']) && !isset($_POST['suboption_addposition']) ){
			foreach($_POST['suboption'] as $k1 => $suboption){
				$insert_data['ea']				= $_POST['suboptionEa'][$k1];
				$insert_data['suboption_title']	= $_POST['suboptionTitle'][$k1];
				$insert_data['suboption']		= $suboption;
				$insert_data['cart_seq'] 		= $cart_seq;
				$insert_data['cart_option_seq']	= $first_cart_option_seq;
				$this->db->insert('fm_person_cart_suboption', $insert_data);
			}
		}
	}

	// 옵션 선택 모듈 ver0.1용 추가 함수
	public function add_cart_ver_0_1($add_data=''){

		$this->load->model('statsmodel');
		$this->load->model('goodsmodel');
		$this->load->model('goodsfblike');
		$this->load->model('brandmodel');
		$this->load->model('promotionmodel');
		$this->load->model('shippingmodel');
		$this->load->helper('goods');

		if(!$add_data) $add_data= $_POST;

		$seloptprefix			= trim($add_data['select_option_prefix']);
		$seloptsuffix			= trim($add_data['select_option_suffix']);
		$cart_option_seq		= $add_data['cart_option_seq'];
		$use_add_action_button	= $add_data[$seloptprefix.'use_add_action_button'.$seloptsuffix];
		$exist_option_seq		= $add_data[$seloptprefix.'exist_option_seq'.$seloptsuffix];
		$goods_seq				= $add_data[$seloptprefix.'option_select_goods_seq'.$seloptsuffix];
		$option					= $add_data[$seloptprefix.'option'.$seloptsuffix];
		$optionTitle			= $add_data[$seloptprefix.'optionTitle'.$seloptsuffix];
		$inputsValue			= $add_data[$seloptprefix.'inputsValue'.$seloptsuffix];
		$inputsTitle			= $add_data[$seloptprefix.'inputsTitle'.$seloptsuffix];
		$viewInputs				= $add_data[$seloptprefix.'viewInputs'.$seloptsuffix];
		$viewInputsTitle		= $add_data[$seloptprefix.'viewInputsTitle'.$seloptsuffix];
		$optionEa				= $add_data[$seloptprefix.'optionEa'.$seloptsuffix];
		$suboption				= $add_data[$seloptprefix.'suboption'.$seloptsuffix];
		$suboptionTitle			= $add_data[$seloptprefix.'suboptionTitle'.$seloptsuffix];
		$suboptionEa			= $add_data[$seloptprefix.'suboptionEa'.$seloptsuffix];
		$mode					= (trim($_GET['mode']))	? 'direct'	: 'cart';
		$session_id				= session_id();
		$member_seq				= (int) $this->userInfo['member_seq'];
		$arrImageExtensions		= array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tif', 'pic');
		$sale_code_seq			= $this->session->userdata('cart_promotioncodeseq_' . $session_id);
		$sale_code				= $this->session->userdata('cart_promotioncode_' . $session_id);
		$shipping_method		= trim($add_data['shipping_method']);
		if	(!$shipping_method)	$shipping_method	= 'delivery';

		// 상품 추가입력사항 파일 업로드 시 저장 폴더 생성
		$path		= ROOTPATH."data/order/";
		if	(!is_dir($path)){
			@mkdir($path);
			@chmod($path, 0777);
		}

		// 버튼식 추가가 아닌 경우 입력옵션 추가
		if	($use_add_action_button == 'n' && is_array($viewInputs) && count($viewInputs) > 0){
			$inputsValue[0]		= $viewInputs;
			$inputsTitle[0]		= $viewInputsTitle;
		}

		// 상품 정보 추출
		$goodsinfo		= $this->goodsmodel->get_goods($goods_seq);
		// 상품 입력옵션 정보 추출
		$inputs			= $this->goodsmodel->get_goods_input($goods_seq);

		// 장바구니 통계 데이터 추가
		if	($this->is_adminOrder != 'admin'){
			$stats_param['goods_seq']	= $goods_seq;
			$stats_param['goods_name']	= $goodsinfo['goods_name'];
			foreach($optionEa as $k1 => $ea){
				for($i = 0; $i < 5; $i++){
					$opt_idx						= $i + 1;
					if	($option[$k1][$i])	$stats_param['option' . $opt_idx]	= $option[$k1][$i];
					else					$stats_param['option' . $opt_idx]	= '';
				}
				$stats_param['ea']	= $ea;

				$this->statsmodel->insert_cart_stats($stats_param);
			}
		}

		// 바로구매, 선택구매 장바구니 정리
		if	($mode != 'cart')	$this->delete_mode($mode);

		// 좋아요 여부
		$ckfblike	= $this->goodsfblike->getgoodsfblike($goods_seq, '', $session_id);

		// 카테고리 추출
		$category	= array();
		$catetmp	= $this->goodsmodel->get_goods_category($goods_seq);
		if	($catetmp)foreach($catetmp as $caterow){
			if	( strlen($caterow['category_code']) > 4) {
				if	(strlen($caterow['category_code']) >= 16)
					$category[]	= substr($caterow['category_code'], 0, 16);
				if	(strlen($caterow['category_code']) >= 12)
					$category[]	= substr($caterow['category_code'], 0, 12);
				if	(strlen($caterow['category_code']) >= 8)
					$category[]	= substr($caterow['category_code'], 0, 8);
			}
			$category[]		= substr($caterow['category_code'], 0, 4);
		}

		// 대표 브랜드 추출
		$brands		= $this->goodsmodel->get_goods_brand($goods_seq);
		unset($brand_code);
		if	($brands)foreach($brands as $bkey => $branddata){
			if	($branddata['link'] == 1){
				$brand_codear	= $this->brandmodel->split_brand($branddata['category_code']);
				$brand_code[]	= $brand_codear[0];
			}
		}

		// 기존 장바구니 정보 추출
		$cart		= $this->catalog($this->is_adminOrder);
		$cart_goods	= $cart['data_goods'][$goods_seq];

		if(!$goodsinfo['shipping_group_seq'])	$goodsinfo['shipping_group_seq']	= $cart_goods['shipping_group_seq'];
		if(!$add_data['shipping_method'])		$add_data['shipping_method']		= $cart_goods['shipping_set_seq'];

		//상품을 장바구니에 담을때 배송설정이 불가한 경우 해당 배송그룹의 배송방법 중 1개를 가져온다. @2016-09-05 pjm
		//관리자 주문, 개인결제 생성시 사용됨.
		if(!$add_data['shipping_method']){
			$default_shipping = $this->shippingmodel->load_shipping_set_list($goodsinfo['shipping_group_seq']);
			foreach($default_shipping as $shipping_data){
				if(!$add_data['shipping_method']) $add_data['shipping_method'] = $shipping_data['shipping_set_seq'];
			}
		}
		// 배송설정 추출 :: 2016-07-25 lwh
		if($goodsinfo['shipping_group_seq'] && $add_data['shipping_method']){
			$set_info = $this->shippingmodel->get_shipping_set($add_data['shipping_method'], 'shipping_set_seq');
		}

		if	($this->is_adminOrder == 'admin'){
			//$data_cart	= $this->get_cart_by_cart_option($cart_option_seq);
			//$cart_seq	= $data_cart['cart_seq'];

			$member_seq = $add_data["member_seq"];

			if($cart_option_seq){

				$data_cart	= $this->get_cart_by_cart_option($cart_option_seq);
				$cart_seq	= $data_cart['cart_seq'];

			}else{

				$insert_data['goods_seq']		= $goods_seq;
				$insert_data['session_id'] 		= $session_id;
				$insert_data['member_seq'] 		= $member_seq;
				$insert_data['distribution']	= $mode;
				$insert_data['regist_date ']	= date('Y-m-d H:i:s',time());
				$insert_data['update_date']		= date('Y-m-d H:i:s',time());
				$insert_data['fblike']			= 'N';
				$insert_data['shipping_group_seq']	= $goodsinfo['shipping_group_seq'];
				$insert_data['shipping_set_seq']	= $set_info['shipping_set_seq'];
				$insert_data['shipping_set_code']	= $set_info['shipping_set_code'];
				$insert_data['shipping_hop_date']	= $add_data['hop_select_date'];
				$insert_data['shipping_store_seq']	= $add_data['shipping_store_seq'];
				$insert_data['shipping_prepay_info']= $add_data['shipping_prepay_info'];
				if($ckfblike)	$insert_data['fblike']	= 'Y';
				$this->db->insert('fm_person_cart', $insert_data);
				$cart_seq						= $this->db->insert_id();
			}

		}else{
			// 장바구니 추가
			$insert_data['goods_seq']		= $goods_seq;
			$insert_data['session_id'] 		= $session_id;
			$insert_data['member_seq'] 		= $member_seq;
			$insert_data['distribution']	= $mode;
			$insert_data['regist_date ']	= date('Y-m-d H:i:s',time());
			$insert_data['update_date']		= date('Y-m-d H:i:s',time());
			$insert_data['fblike']			= 'N';
			$insert_data['shipping_group_seq']	= $goodsinfo['shipping_group_seq'];
			$insert_data['shipping_set_seq']	= $set_info['shipping_set_seq'];
			$insert_data['shipping_set_code']	= $set_info['shipping_set_code'];
			$insert_data['shipping_hop_date']	= $add_data['hop_select_date'];
			$insert_data['shipping_store_seq']	= $add_data['shipping_store_seq'];
			$insert_data['shipping_prepay_info']= $add_data['shipping_prepay_info'];
			if($ckfblike)	$insert_data['fblike']	= 'Y';
			$this->db->insert('fm_person_cart', $insert_data);
			$cart_seq						= $this->db->insert_id();
		}

		// 기존에 선택된 옵션이 있는 경우 제거
		if	($exist_option_seq && is_array($exist_option_seq) && count($exist_option_seq) > 0){
			foreach($exist_option_seq as $k => $seq){
				$this->db->delete('fm_person_cart_option',		array('cart_option_seq' => $seq));
				$this->db->delete('fm_person_cart_input',		array('cart_option_seq' => $seq));
				$this->db->delete('fm_person_cart_suboption',	array('cart_option_seq' => $seq));
			}
		}

		// 필수옵션 기준으로 옵션 정보 insert
		foreach($optionEa as $grp_idx => $ea){

			// 필수옵션 추가
			unset($insert_data,$max);
			for($i = 0; $i < 5; $i++){
				$opt_idx			= $i + 1;
				${'opt'.$opt_idx}	= $option[$grp_idx][$i];
				if	( !isset($option[$grp_idx][$i]) || !$option[$grp_idx][$i] )
					$option[$grp_idx][$i]		= '';
				if	( !isset($optionTitle[$grp_idx][$i]) || !$optionTitle[$grp_idx][$i] )
					$optionTitle[$grp_idx][$i]	= null;

				$insert_data['option' . $opt_idx]	= $option[$grp_idx][$i];
				$insert_data['title' . $opt_idx]	= $optionTitle[$grp_idx][$i];
			}
			$insert_data['ea'] 			= $ea;
			$insert_data['cart_seq']	= $cart_seq;
			$insert_data['shipping_method']	= $shipping_method;

			// 코드할인 session 추가
			if	($sale_code){
				$sc['whereis']	= " and promotion_input_serialnumber ='" . $sale_code . "'";
				$promotioncode	= $this->promotionmodel->get_data($sc);
				$promotioncode	= $promotioncode[0];

				list($price, $reserve)	= $this->goodsmodel->get_goods_option_price(
					$goods_seq, $opt1, $opt2, $opt3, $opt4, $opt5
				);

				// 할인 코드 정보 추출
				$codeFuncName		= 'get_able_download_list';		// 개별코드
				if	( strstr($promotioncode['type'], 'promotion') )
					$codeFuncName	= 'get_able_promotion_list';	// 일반코드
				$promotions	= $this->promotionmodel->$codeFuncName($goods_seq, $category, $brand_code, $cart['total'], $sale_code, $price, $ea);

				if	($promotions){
					// 중복할인은 무조건추가
					if	($promotions['duplication_use'] == 1){
							$insert_data['promotion_code_seq']			= $sale_code_seq;
							$insert_data['promotion_code_serialnumber']	= $sale_code;
					// 중복할인이 아닌경우 상품 할인가(판매가)가 최대값인 상품으로 처리함
					}else{
						foreach($cart['list'] as $cartkey => $cartdata){
							if	($goods_seq == $cartdata['goods_seq']){
								if	( ($max[$goods_seq] && $max[$goods_seq] < $price) || !$max[$goods_seq]){
									$insert_data['promotion_code_seq']			= $sale_code_seq;
									$insert_data['promotion_code_serialnumber']	= $sale_code;
									$max[$goods_seq]							= $price;
									$upsql	= "update fm_person_cart_option
												set promotion_code_seq = null,
												promotion_code_serialnumber = null
												where cart_seq = '" . $cartdata['cart_seq'] . "'";
									$this->db->query($upsql);
								}
							}
						}

						// 최초상품인경우
						if($cart['list'] && !$max[$goods_seq]){
							$insert_data['promotion_code_seq']			= $sale_code_seq;
							$insert_data['promotion_code_serialnumber']	= $sale_code;
						}
					}
				}
			}
			$this->db->insert('fm_person_cart_option', $insert_data);
			$cart_option_seq	= $this->db->insert_id();
			if	($grp_idx == 0)	$first_cart_option_seq	= $cart_option_seq;

			// 입력옵션 추가
			if( $inputsValue[$grp_idx] && is_array($inputsValue[$grp_idx])){
				foreach($inputs as $k => $data_input){
					unset($insert_data);
					$input_name	= $data_input['input_name'];
					$idx		= array_search($input_name, $inputsTitle[$grp_idx]);
					if	($idx || $input_name == $inputsTitle[$grp_idx][0]){
						$inputType						= $data_input['input_form'];
						$inputVal						= $inputsValue[$grp_idx][$idx];
						$inputsTitle[$grp_idx][$idx]	= '';

						// 파일업로드 입력옵션일 경우
						if	($data_input['input_form'] == 'file'){
							$inputType	= 'file';
							$file_path	= str_replace(realpath(ROOTPATH), '', realpath($inputVal));
							$fname		= $file_path;
							// 파일 업로드 여부체크
							if	(preg_match("/\/tmp\//i", $file_path) && file_exists(realpath(ROOTPATH) . $file_path)){
								$file_ext	= end(explode('.', $file_path));
								$file_path	= realpath(ROOTPATH) . $file_path;
								$fname		= '';
								if	( in_array(strtolower($file_ext), $arrImageExtensions) ){
									$fname	= $cart_seq . '_' . $cart_option_seq . '_'
											. $k . "." . $file_ext;
									copy($file_path, $path.$fname);
								}
								$k++;
							}

							$inputVal	= $fname;
						}

						$insert_data['type']			= $inputType;
						$insert_data['input_title']		= $input_name;
						$insert_data['input_value']		= $inputVal;
						$insert_data['cart_seq']		= $cart_seq;
						$insert_data['cart_option_seq']	= $cart_option_seq;
						$this->db->insert('fm_person_cart_input', $insert_data);
					}
				}
			}

			// 추가옵션 추가
			if( $suboption[$grp_idx] && is_array($suboption[$grp_idx])){
				foreach($suboption[$grp_idx] as $idx => $sub){
					unset($insert_data);
					$insert_data['ea']				= $suboptionEa[$grp_idx][$idx];
					$insert_data['suboption_title']	= $suboptionTitle[$grp_idx][$idx];
					$insert_data['suboption']		= $sub;
					$insert_data['cart_seq'] 		= $cart_seq;
					$insert_data['cart_option_seq']	= $cart_option_seq;
					$this->db->insert('fm_person_cart_suboption', $insert_data);
				}
			}
		}
		$result['mode']			= $mode;
		$result['member_seq']	= $member_seq;
		$result['goods_seq']	= $goods_seq;
		$result['cart_seq']		= $cart_seq;

		return $result;
	}
}

/* End of file category.php */
/* Location: ./app/models/category */
