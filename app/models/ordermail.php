<?php
class ordermail extends CI_Model {
	var $export_code		= array();
	var $order_seq 			= '';
	var $shipping_seq		= '';
	var $step 				= '';
	var $goods_kind			= 'goods';
	var $file_path 			= array();
	var $debug 				= false;

	public function __construct()
	{
		$this->load->library('email');
		$this->load->model('returnmodel');
		$this->load->model('membermodel');
		$this->load->model('goodsmodel');
		$this->load->model('exportmodel');
		$this->load->model('ordermodel');
		$this->load->helper('order');
		$this->load->helper('shipping');

		$this->arr_shipping_method = array(
				'delivery'=>'택배(선불)',
				'postpaid'=>'택배(착불)',
				'quick'=>'퀵서비스',
				'direct'=>'직접수령'
		);

		$this->arr_payment = config_load('payment');
		$this->set_contents_file();
	}

	public function set_contents_file()
	{
		$this->file_path['15']	 = "../../data/email/".get_lang(true)."/order.html";
		$this->file_path['25']	 = "../../data/email/".get_lang(true)."/settle.html";
		$this->file_path['55']	 = "../../data/email/".get_lang(true)."/released.html";
		$this->file_path['75']	 = "../../data/email/".get_lang(true)."/delivery.html";
		if( $this->goods_kind == 'ticket' ){
			$this->file_path['55']	 = "../../data/email/".get_lang(true)."/coupon_released.html";
			$this->file_path['75']	 = "../../data/email/".get_lang(true)."/coupon_delivery.html";
		}
	}

	// 이전 메일발송용
	function get_export_old($item,$config_cancel){

		// 옵션 문자열화
		$options_arr	= get_options_print_array($item, ':');

		// 티켓번호
		$export['coupon_serial']	= $item['coupon_serial'];
		// 회차
		$export['couponNum']		= $item['coupon_st'].'/'.$item['opt_ea'];
		// 값어치
		if	($item['coupon_input'] > 0){
			$export['exists_option']++;
			if	($item['socialcp_input_type'] == 'pass'){
				$export['coupon_input_count']	= $item['coupon_input'];
			}else{
				$export['coupon_input_price']	= $item['coupon_input'];
			}
		}
		// 옵션 목록화
		$export['optionlist']	= $options_arr;
		$export['cancel_rule']	= 'option';
		$export['cancel_day']	= $config_cancel['socialcp_cancel_day'];
		$export['refund_rule']	= $config_cancel['socialcp_use_return'];
		if	($config_cancel['socialcp_cancel_type'] == 'pay')	$export['cancel_rule']	= 'pay';

		return $export;
	}

	public function get_mail_info()
	{
		$tot = array();
		$arr = config_load('bank');
		if($arr) foreach(config_load('bank') as $k => $v){
			list($tmp) = code_load('bankCode',$v['bank']);
			$v['bank'] = $tmp['value'];
			$bank[] = $v;
		}

		if( count($this->export_code) > 0 ){
			$last_export_code = end( $this->export_code );
			$data_export 								= $this->exportmodel->get_export($last_export_code);
			$data_export['out_shipping_method']   		= $this->arr_shipping_method[$data_export['domestic_shipping_method']];
			$data_export_item 							= $this->exportmodel->get_export_item($last_export_code);
			$export_shipping_seq 						= $data_export_item[0]['shipping_seq'];
			$this->order_seq 							= $data_export['order_seq'];
			$this->shipping_seq 						= $export_shipping_seq;
			$tmp_export_shipping 						= $this->ordermodel->get_order_shipping($this->order_seq,null,$export_shipping_seq);
			list($data_export_shipping) 				= array_values($tmp_export_shipping);
		}

		$pay_log 		= $this->ordermodel->get_log($this->order_seq,'pay');
		$process_log 	= $this->ordermodel->get_log($this->order_seq,'process');
		$cancel_log 	= $this->ordermodel->get_log($this->order_seq,'cancel');
		$arr_orders 	= $this->ordermodel->get_order($this->order_seq);
		$arr_items 		= $this->ordermodel->get_item($this->order_seq);

		if( count($this->export_code) > 0 ){
			$export = $this->get_export_old($data_export_item[0],$arr_orders);
			$data_export['coupon_serial'] 			= $export['coupon_serial'];
			$data_export['couponNum'] 				= $export['couponNum'];
			$data_export['coupon_input'] 			= $export['coupon_input'];
			$data_export['exists_option'] 				= $export['exists_option'];
			$data_export['coupon_input_count'] 	= $export['coupon_input_count'];
			$data_export['optionlist'] 					= $export['optionlist'];
			$data_export['cancel_rule'] 				= $export['cancel_rule'];
			$data_export['cancel_day'] 				= $export['cancel_day'];
			$data_export['refund_rule'] 				= $export['refund_rule'];
		}

		$arr_orders['mpayment'] = $this->arr_payment[$arr_orders['payment']];
		$arr_orders['mstep'] 	= $this->arr_step[$arr_orders['step']];
		if(!$this->to_email) $this->to_email = $arr_orders['order_email'];

		//티켓상품이 아닐경우 email에 주문자 메일 셋팅
        if(!$data_export['coupon_serial']){
			if($this->set_user_yn == "Y"){
				$this->to_email = $arr_orders['order_email'];
			}else{
				$this->to_email = "";
			}
        }
		if($this->set_admin_email != "" && $this->set_admin_yn == "Y"){
			if($this->to_email) $this->to_email .= ";";
			 $this->to_email .= $this->set_admin_email;
		}

		$total_sale = (int) $arr_orders['enuri'];

		foreach($arr_items as $key=>$item)
		{
			$arr_options 	= $this->ordermodel->get_option_for_item($item['item_seq']);
			$arr_suboptions = $this->ordermodel->get_suboption_for_item($item['item_seq']);

			if($arr_options) foreach($arr_options as $k => $data)
			{
				//티켓상품의 출고완료/배송완료시 체크한 티켓번호 정보만 발송되도록 제한 @2016-02-15
				if( ($this->step>'45' && $this->step<'85' ) && $this->goods_kind == 'ticket' && $data['item_option_seq'] != $data_export_item[0]['option_seq'] ) {
					unset($arr_options[$k]);
					continue;
				}

				if( $this->export_code ){
					$data['export_ea'] = 0;
					foreach( $data_export_item as $row_export_item){
						if($row_export_item['opt_type'] == 'opt' && $row_export_item['option_seq'] == $data['item_option_seq']){
							$data['export_ea'] = $row_export_item['ea'];
						}
					}
				}


				$real_stock = $this->goodsmodel -> get_goods_option_stock(
						$item['goods_seq'],
						$data['option1'],
						$data['option2'],
						$data['option3'],
						$data['option4'],
						$data['option5']
				);

				$rstock = $this->ordermodel -> get_option_reservation(
						$this->cfg_order['ableStockStep'],
						$item['goods_seq'],
						$data['option1'],
						$data['option2'],
						$data['option3'],
						$data['option4'],
						$data['option5']
				);

				$stock = (int) $real_stock - (int) $rstock;
				$data['mstep']		= $this->arr_step[$data['step']];
				$data['real_stock'] = $real_stock;
				$data['stock'] = $stock;

				$data['out_org_price'] = $data['org_price']*$data['ea'];
				$data['out_supply_price'] = $data['supply_price']*$data['ea'];
				$data['out_commission_price'] = $data['commission_price']*$data['ea'];
				$data['out_consumer_price'] = $data['consumer_price']*$data['ea'];
				$data['out_price'] = $data['price']*$data['ea'];
				$data['out_refund_price'] = $data['price']*$data['refund_ea'];

				//promotion sale
				// 이벤트할인, 복수구매 할인 추가 :: 2018-07-25 pjw
				$data['out_event_sale']  = $data['event_sale'];
				$data['out_multi_sale']  = $data['multi_sale'];
				$data['out_member_sale'] = $data['member_sale']*$data['ea'];
				$data['out_coupon_sale'] = ($data['download_seq'])?$data['coupon_sale']:0;
				$data['out_coupon_sale'] += $data['unit_ordersheet'];
				$data['out_fblike_sale'] = $data['fblike_sale'];
				$data['out_mobile_sale'] = $data['mobile_sale'];
				$data['out_referer_sale'] = $data['referer_sale'];
				$data['out_promotion_code_sale'] = $data['promotion_code_sale'];

				// total sale
				// 이벤트할인, 복수구매 할인 추가 :: 2018-07-25 pjw
				$data['out_tot_sale'] = $data['out_event_sale'] + $data['out_multi_sale'] + $data['out_member_sale'] + $data['out_coupon_sale'] + $data['out_promotion_code_sale'] + $data['out_fblike_sale'] + $data['out_mobile_sale'] + $data['out_referer_sale'];
				$total_sale += $data['out_tot_sale'];

				//use
				$data['out_reserve'] = $data['reserve']*$data['ea'];
				$data['out_point'] 	= $data['point']*$data['ea'];

				$data['step_complete'] = $data['step45']+$data['step55']+$data['step65']+$data['step75'];

				$tot['ea'] += $data['ea'];
				$tot['refund_ea'] += $data['refund_ea'];
				$tot['supply_price'] += $data['out_supply_price'];
				$tot['commission_price'] += $data['out_commission_price'];
				$tot['consumer_price'] += $data['out_consumer_price'];
				$tot['price'] += $data['out_price'];
				$tot['oprice'] += $data['price'];

				//promotion sale
				// 이벤트할인, 복수구매 할인 추가 :: 2018-07-25 pjw
				$tot['event_sale']  += $data['out_event_sale'];
				$tot['multi_sale']  += $data['out_multi_sale'];
				$tot['member_sale'] += $data['out_member_sale'];
				$tot['coupon_sale'] += $data['out_coupon_sale'];
				$tot['fblike_sale'] += $data['out_fblike_sale'];
				$tot['mobile_sale'] += $data['out_mobile_sale'];
				$tot['referer_sale'] += $data['out_referer_sale'];
				$tot['promotion_code_sale'] += $data['out_promotion_code_sale'];

				//use sale
				$tot['reserve'] += $data['out_reserve'];
				$tot['point'] += $data['out_point'];

				$tot['real_stock'] += $real_stock;
				$tot['stock'] += $stock;

				$return_item = $this->returnmodel->get_return_item_ea($data['item_seq'],$data['item_option_seq']);
				$able_return_ea += (int) $data['step75'] - (int) $return_item['ea'];

				###
				$input = array();
				$sql = "SELECT * FROM fm_order_item_input WHERE order_seq = '{$this->order_seq}' and item_seq = '{$data[item_seq]}' and item_option_seq='{$data[item_option_seq]}'";
				$query = $this->db->query($sql);
				foreach($query->result_array() as $rows){
					$input[] = $rows;
				}
				$data['inputs'] = $input;

				if($arr_suboptions) foreach($arr_suboptions as $k_sub => $data_sub){

					if( $this->export_code ){
						$data_sub['export_ea'] = 0;
						foreach( $data_export_item as $row_export_item){
							if($row_export_item['opt_type'] == 'sub' && $row_export_item['option_seq'] == $data_sub['item_suboption_seq']){
								$data_sub['export_ea'] = $row_export_item['ea'];
							}
						}
					}

					if($data_sub['item_option_seq'] != $data['item_option_seq']) continue;

					$real_stock = $this->goodsmodel -> get_goods_suboption_stock(
							$item['goods_seq'],
							$data_sub['title'],
							$data_sub['suboption']
					);
					$rstock = $this->ordermodel -> get_suboption_reservation(
							$this->cfg_order['ableStockStep'],
							$item['goods_seq'],
							$data_sub['title'],
							$data_sub['suboption']
					);

					$stock = (int) $real_stock - (int) $rstock;
					$data_sub['real_stock'] = (int) $real_stock;
					$data_sub['stock'] = (int) $stock;

					###
					$data_sub['out_supply_price'] = $data_sub['supply_price']*$data_sub['ea'];
					$data_sub['out_commission_price'] = $data_sub['commission_price']*$data_sub['ea'];
					$data_sub['out_consumer_price'] = $data_sub['consumer_price']*$data_sub['ea'];
					$data_sub['out_org_price'] = $data_sub['org_price']*$data_sub['ea'];
					$data_sub['out_price'] = $data_sub['price']*$data_sub['ea'];
					$data_sub['out_refund_price'] = $data_sub['price']*$data_sub['refund_ea'];

					//promotion sale
					// 이벤트할인, 복수구매 할인 추가 :: 2018-07-25 pjw
					$data_sub['out_event_sale']  = $data_sub['event_sale'];
					$data_sub['out_multi_sale']  = $data_sub['multi_sale'];
					$data_sub['out_member_sale'] = $data_sub['member_sale']*$data_sub['ea'];
					$data_sub['out_coupon_sale'] = ($data_sub['download_seq'])?$data_sub['coupon_sale']:0;
					$data_sub['out_fblike_sale'] = $data_sub['fblike_sale'];
					$data_sub['out_mobile_sale'] = $data_sub['mobile_sale'];
					$data_sub['out_referer_sale'] = $data_sub['referer_sale'];
					$data_sub['out_promotion_code_sale'] = $data_sub['promotion_code_sale'];

					// total sale
					$data_sub['out_tot_sale'] = $data_sub['out_event_sale'] + $data_sub['out_multi_sale'] + $data_sub['out_member_sale'] + $data_sub['out_coupon_sale'] + $data_sub['out_promotion_code_sale'] + $data_sub['out_fblike_sale'] + $data_sub['out_mobile_sale'] + $data_sub['out_referer_sale'];
					$total_sale += $data_sub['out_tot_sale'];

					//member use
					$data_sub['out_reserve'] = $data_sub['reserve']*$data_sub['ea'];
					$data_sub['out_point'] = $data_sub['point']*$data_sub['ea'];

					$data_sub['mstep']	= $this->arr_step[$data_sub['step']];
					$data_sub['step_complete'] = $data_sub['step45']+$data_sub['step55']+$data_sub['step65']+$data_sub['step75'];

					$arr_suboptions[$k_sub] = $data_sub;
					$data['suboptions'][]	= $data_sub;

					if( $this->export_code && $data_sub['export_ea']){
						$data['arr_suboptions'][] = $data_sub;
						$data['sub'][] = $data_sub;
					}

					$tot['ea'] += $data_sub['ea'];
					$tot['refund_ea'] += $data_sub['refund_ea'];
					$tot['supply_price'] 	+= $data_sub['out_supply_price'];
					$tot['commission_price'] 	+= $data_sub['out_commission_price'];
					$tot['consumer_price'] 	+= $data_sub['out_consumer_price'];

					//promotion sale
					// 이벤트할인, 복수구매 할인 추가 :: 2018-07-25 pjw
					$tot['event_sale']  += $data_sub['out_event_sale'];
					$tot['multi_sale']  += $data_sub['out_multi_sale'];
					$tot['member_sale'] += $data_sub['out_member_sale'];
					$tot['coupon_sale'] += $data_sub['out_coupon_sale'];
					$tot['fblike_sale'] += $data_sub['out_fblike_sale'];
					$tot['mobile_sale'] += $data_sub['out_mobile_sale'];
					$tot['referer_sale'] += $data_sub['out_referer_sale'];
					$tot['promotion_code_sale'] += $data_sub['out_promotion_code_sale'];

					//member use
					$tot['reserve'] += $data_sub['out_reserve'];
					$tot['point'] += $data_sub['out_point'];

					$tot['oprice'] 			+= $data_sub['price'];
					$tot['price'] 			+= $data_sub['out_price'];
					$tot['real_stock'] 		+= $real_stock;
					$tot['stock'] 			+= $stock;

					$return_item = $this->returnmodel->get_return_item_ea($data_sub['item_seq'],$data_sub['item_suboption_seq']);
					$able_return_ea += (int) $data_sub['step75'] - (int) $return_item['ea'];
				}

				// 구치환코드 선언
				unset($arr_str_options);
				$data['options'] = '';
				$arr_str_options[] = ( $data['title1'] ) ? $data['title1'] . ":" . $data['option1'] :$data['option1'];
				$arr_str_options[] = ( $data['title2'] ) ? $data['title2'] . ":" . $data['option2'] :$data['option2'];
				$arr_str_options[] = ( $data['title3'] ) ? $data['title3'] . ":" . $data['option3'] :$data['option3'];
				$arr_str_options[] = ( $data['title4'] ) ? $data['title4'] . ":" . $data['option4'] :$data['option4'];
				$arr_str_options[] = ( $data['title5'] ) ? $data['title5'] . ":" . $data['option5'] :$data['option5'];
				if( $arr_str_options ) $data['options'] = implode(' ',$arr_str_options);
				$data['goods_name'] = $item['goods_name'];
				/**if( $this->export_code && $data['export_ea']){
					$arr_options[$k] 	= $data;
				}else if( !$this->export_code ){
					$arr_options[$k] 	= $data;
				}**/
				$arr_options[$k] 	= $data;
				$data_goods[] 	= $data;
			}

			$item['rowspan']			= count($arr_options) + count($arr_suboptions);
			$item['arr_suboptions']		= $arr_suboptions;
			$item['arr_options']			= $arr_options;
			$arr_items[$key] 				= $item;

			$tot['goods_shipping_cost']	+= $item['goods_shipping_cost'];

		}

		/* 주문상품을 배송그룹별로 분할 */
		$shipping_provider_seq = null;
		$shipping = $this->ordermodel->get_order_shipping($this->order_seq);
		$shipping_group_items=array();
		foreach($arr_items as $item){
			$shipping_group_items[$item['shipping_seq']]['goods_shipping_cost_sum']+= $item['goods_shipping_cost'];
			$shipping_group_items[$item['shipping_seq']]['goods_shipping_cost']+= $item['goods_shipping_cost'];
			$shipping_group_items[$item['shipping_seq']]['rowspan'] += $item['rowspan'];
			$shipping_group_items[$item['shipping_seq']]['items'][] = $item;
			$shipping_group_items[$item['shipping_seq']]['items'][0]['options'][0]['shipping_division']	= 1;
			$shipping_group_items[$item['shipping_seq']]['totalitems'] += count($item['options'])+count($item['suboptions']);
		}

		$this->load->helper('shipping');
		$arr_shipping_method = get_shipping_method('all','');
		foreach($shipping_group_items as $shipping_seq=>$row){

			$shipping_res	= $this->ordermodel->get_order_shipping($this->order_seq,$shipping_provider_seq,$shipping_seq,'limit');
			$tmp_key		= array_keys($shipping_res);
			$shipping		= $shipping_res[$tmp_key[0]];

			$shipping['shipping_method_name'] = $arr_shipping_method[$shipping['shipping_method']];

			$shipping_tot['shipping_promotion_code_sale']	+= $shipping['shipping_promotion_code_sale'];
			$shipping_tot['shipping_coupon_sale']			+= $shipping['shipping_coupon_sale'];

			$total_sale += $shipping_tot['shipping_promotion_code_sale'];
			$total_sale += $shipping_tot['shipping_coupon_sale'];

			// 배송비 종류별 계산 :: 2016-08-18 lwh
			if($shipping['shipping_type'] == 'prepay'){
				$shipping_tot['shipping_cost']			+= $shipping['shipping_cost'];//총배송비
				$shipping_tot['std_shipping_cost']		+= $shipping['delivery_cost'];//선불배송비
				$shipping_tot['add_shipping_cost']	+= $shipping['add_delivery_cost'];//추가배송비
				$shipping_tot['hop_shipping_cost']	+= $shipping['hop_delivery_cost'];//희망배송
				$shipping['shipping_pay_type']		= getAlert("sy002"); // "주문시 결제";

			// 착불배송비 계산 (@2016-09-28 pjm)
			}elseif($shipping['shipping_type'] == 'postpaid'){
				$shipping['postpaid']				= $shipping['delivery_cost'] + $shipping['add_delivery_cost'] + $shipping['hop_delivery_cost'];
				$shipping_tot['postpaid_cost']		+= $shipping['postpaid'];//총착불배송비
				$shipping_tot['std_postpaid_cost']		+= $shipping['delivery_cost'];//착불배송비
				$shipping_tot['add_postpaid_cost']	+= $shipping['add_delivery_cost'];//착불 추가배송비
				$shipping_tot['hop_postpaid_cost']	+= $shipping['hop_delivery_cost'];//착불 희망배송
				$shipping['shipping_pay_type']		= getAlert("sy003"); // "착불";
			}else{
				$shipping['shipping_pay_type'] = getAlert("sy010"); // "무료";
			}

			if(preg_match( '/each_delivery/',$shipping['shipping_method'])){
				$shipping_tot['goods_shipping_cost']		+= $row['goods_shipping_cost'];
				$shipping_tot['add_goods_shipping_cost']	+= $shipping['add_delivery_cost'];
			}

			$shipping_tot['international_cost']				+= $shipping['international_cost'];

			if	($shipping['provider_seq'] > 1){
				$salescost[$shipping['provider_seq']]['salescost']['shippingcost']	+= $shipping['salescost_provider_coupon'];
				$salescost[$shipping['provider_seq']]['salescost']['shippingcost']	+= $shipping['salescost_provider_promotion'];
				$salescost[$shipping['provider_seq']]['salescost']['shippingcoupon']	+= $shipping['salescost_provider_coupon'];
				$salescost[$shipping['provider_seq']]['salescost']['shippingpromotion']	+= $shipping['salescost_provider_promotion'];
				$salescost[$shipping['provider_seq']]['original']['shippingcoupon']	+= $shipping['shipping_coupon_sale'];
				$salescost[$shipping['provider_seq']]['original']['shippingpromotion']	+= $shipping['shipping_promotion_code_sale'];
			}

			$shipping_group_items[$shipping_seq]['shipping'] = $shipping;
		}


		// 총 할인
		$arr_orders['total_sale'] = $total_sale;

		// 회원 정보 가져오기
		if($arr_orders['member_seq']){
			$members = $this->membermodel->get_member_data($arr_orders['member_seq']);
			$this->template->assign(array('members'=>$members));
		}

		// 배송방법
		$arr_orders['mshipping'] = $this->ordermodel->get_delivery_method($arr_orders);

		$this->load->helper('shipping');
		$shipping = use_shipping_method();
		if( $shipping ) foreach($shipping as $key => $data){
			if($data) $shipping_cnt[$key] = count($data);
		}
		$shipping_policy['policy'] 	= $shipping;

		//반품정보 가져오기
		$this->load->model('returnmodel');
		$data_return = $this->returnmodel->get_return_for_order($this->order_seq,"return");
		if( $data_return )foreach($data_return as $k=>$data){
			$data['mstatus'] = $this->returnmodel->arr_return_status[$data['status']];
			$data_return[$k] = $data;
		}

		//교환정보 가져오기
		$data['exchange_list_ea'] = 0;
		$data_exchange = $this->returnmodel->get_return_for_order($this->order_seq,"exchange");
		if($data_exchange) foreach($data_exchange as $data){
			$data['mstatus'] = $this->returnmodel->arr_return_status[$data['status']];
			$data_exchange[$k] = $data;
		}

		//환불정보 가져오기
		$this->load->model('refundmodel');
		$data_refund = $this->refundmodel->get_refund_for_order($this->order_seq);
		if( $data_refund )foreach($data_refund as $k=>$data){
		$data['mstatus'] = $this->refundmodel->arr_refund_status[$data['status']];
				$data_refund[$k] = $data;
		}

		$this->load->model('salesmodel');
		//세금계산서 or 현금영수증
		$sc['whereis']	= ' and typereceipt = "'.$arr_orders['typereceipt'].'" and order_seq="'.$this->order_seq.'" ';
		$sc['select']		= '  cash_no, tstep, seq  ';
		$sales 		= $this->salesmodel->get_data($sc);
		if( $sales ) {
			if($sales['tstep']=='1')
			{
				$cash_msg = "발급신청";
			}
			else if($sales['tstep']=='2')
			{
				$cash_msg = "발급완료";
			} else if($sales['tstep']=='3')
			{
				$cash_msg = "발급취소";
			} else if($sales['tstep']=='4')
			{
				$cash_msg = "발급실패";
			}

			if(!($arr_orders['payment'] =='card' && $arr_orders['payment'] =='cellphone') ) {
				if( $arr_orders['typereceipt'] == 2 ) {
					$cash_receipts_no = ($sales['cash_no'])?$sales['cash_no']:$arr_orders['cash_receipts_no'];
					if(!$cash_receipts_no) {
						$cash_msg = "발급실패";
					}
				}
			}
		}


		// 구치환코드 선언
		$arr_orders['price'] 									= $tot['price']; // 상품가
		$arr_orders['goods_shipping_cost'] 				= $shipping_tot['goods_shipping_cost']; // 개별배송비
		$arr_orders['shipping_cost'] 						= $shipping_tot['shipping_cost']; // 배송비
		$arr_orders['coupon_sale'] 						= $shipping_tot['shipping_coupon_sale'];	// 배송비쿠폰
		$arr_orders['shipping_promotion_code_sale'] 	= $shipping_tot['shipping_promotion_code_sale']; //배송비코드
		$data_arr['shipping_tot']							= $shipping_tot;

		$arr_orders['goods_promotion_code_sale'] 	= $tot['promotion_code_sale']; // 코드
		$arr_orders['member_sale'] 						= $tot['member_sale']; // 등급
		$arr_orders['fblike_sale'] 							= $tot['fblike_sale']; // 좋아요
		$arr_orders['goods_mobile_sale'] 				= $tot['mobile_sale']; // 모바일
		$arr_orders['referer_sale'] 							= $tot['referer_sale']; // 유입경로
		$arr_orders['goods_coupon_sale'] 				= $tot['coupon_sale']; // 할인쿠폰
		$data_arr['items_tot']								= $tot;

		$data_arr['goods'] 									= $data_goods;
		$data_arr['sales_cash_msg']  						= $cash_msg;
		$data_arr['order']										= $arr_orders;
		$data_arr['items']										= $arr_items;

		$data_arr['bank']										= $bank;
		$data_arr['pay_log']									= $pay_log;
		$data_arr['process_log']							= $process_log;
		$data_arr['cancel_log']								= $cancel_log;
		$data_arr['data_return']							= $data_return;
		$data_arr['data_exchange']						= $data_exchange;
		$data_arr['data_refund']							= $data_refund;
		$data_arr['shipping_policy']						= $shipping_policy;
		$data_arr['goods_kind_arr']						= $goods_kind_arr;
		$data_arr['shipping_group_items']				= $shipping_group_items;
		$data_arr['data_export_item'] 					= $data_export_item;
		$data_arr['data_export'] 							= $data_export;
		$data_arr['export'] 									= $data_export;
		$data_arr['data_export_shipping'] 				= $data_export_shipping;
		$data_arr['able_step_action']						= $this->ordermodel->able_step_action;
		$data_arr['config_basic'] 							= $this->config_basic;
		$data_arr['basic']['domain'] 						= "http://".$this->config_system['domain'];

		return $data_arr;
	}

	public function set_subject($data_arr){
		$member_seq = $data_arr['order']['member_seq'];

		$arr['domain'] = $this->config_system['domain'];
		if(!$arr['domain']) $arr['domain'] = 'http://'.$_SERVER['HTTP_HOST'];
		$arr['shopName'] = $this->config_basic['shopName'];

		$arr['userid'] = "비회원";
		$arr['userlevel'] = "비회원";
		$arr['username'] = "비회원";
		$arr['usernickname'] = "비회원";
		$arr['userday'] = "";
		$arr['userbirthday'] = "";
		$arr['usermileage'] = "";
		$arr['userpoint'] = "";
		$arr['useremoney'] = "";

		if( $member_seq ){
			$data_member = $this->membermodel->get_member_data($member_seq);
			$arr['userid'] = $data_member['userid'];
			$arr['userlevel'] = $data_member['group_name'];
			$arr['userday'] = $data_member['regist_date'];
			$arr['username'] = $data_member['user_name'];
			$arr['usernickname'] = $data_member['nickname']?$data_member['nickname']:$data_member['user_name'];
			$arr['userbirthday'] = $data_member['birthday'];
			$arr['usermileage'] = $data_member['emoney'];
			$arr['userpoint'] = $data_member['point'];
			$arr['useremoney'] = $data_member['cash'];
		}

		if( $this->subject  ){

			/*	{shopName}{userid}{username}	{usernickname}{userlevel}	{userday}{userbirthday}{usermileage}	{userpoint}	{useremoney}	*/
			foreach($arr as $key=>$data){
				$this->subject = str_replace("{".$key."}",$data,$this->subject);
			}
		}

		$this->member_seq =  $member_seq;
	}

	public function set_body($data_arr){
		$this->set_contents_file();
		$this->template->assign($data_arr);
		$file_path	= $this->file_path[$this->step];
		$this->template->compile_dir = ROOTPATH."data/email/".get_lang(true)."/";
		$this->template->define(array('tpl'=>$file_path));
		$this->body = $this->template->fetch("tpl");
	}

	public function send()
	{
		if( !$this->from_name ) $this->from_name = $this->config_basic['shopName'];

		if($this->debug){
			echo $this->subject."<br/>";
			echo $this->body;
		}else{
			$this->email->mailtype='html';
			$this->email->from($this->from_email, $this->from_name);
			$this->email->to($this->to_email);
			$this->email->subject($this->subject);
			$body = str_replace('\\','',http_src($this->body));
			$this->email->message($body);
			$this->email->send();
			$this->email->clear();
		}
	}

	public function send_log()
	{
		$params['regdate']	= date('Y-m-d H:i:s');
		$params['gb']			= "AUTO";
		$params['total']		= '1';
		$params['to_email']	= $this->to_email;
		$params['member_seq']	= $this->member_seq;
		$params['subject']		= $this->subject;
		$params['contents']		= $this->body;
		$params['order_seq']	= $this->order_seq;
		$params['memo']			= $this->memo;
		$params_data = filter_keys($params, $this->db->list_fields('fm_log_email'));
		$result =  $this->db->insert('fm_log_email', $params_data);
	}
}