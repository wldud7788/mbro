<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class refund_process extends selleradmin_base {

	public function __construct() {
		parent::__construct();
		$this->load->library('validation');

	}

	public function save(){
		$this->load->model('ordermodel');
		$this->load->model('refundmodel');
		$this->load->model('emoneymodel');
		$this->load->model('membermodel');
		$this->load->model('eventmodel');
		$this->load->helper('text');

		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('refund_act');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}
		/* 관리자 권한 체크 : 끝 */

		$cfg_order = config_load('order');

		/* 환불 정보 저장 */
		$saveData = array(
			'adjust_use_coupon'		=> $_POST['adjust_use_coupon'],
			'adjust_use_promotion'	=> $_POST['adjust_use_promotion'],
			'adjust_use_emoney'		=> $_POST['adjust_use_emoney'],
			'adjust_use_cash'		=> $_POST['adjust_use_cash'],
			'adjust_use_enuri'		=> $_POST['adjust_use_enuri'],
			'adjust_refund_price'	=> $_POST['adjust_refund_price'],
			'refund_method'			=> $_POST['refund_method'],
			'refund_price'			=> $_POST['refund_price'],
			'refund_emoney'			=> $_POST['refund_emoney'],
			'refund_cash'			=> $_POST['refund_cash'],
			'refund_ordersheet'		=> $_POST['refund_ordersheet'],
		);

		$this->db->where('refund_code', $_POST['refund_code']);
		$this->db->update("fm_order_refund",$saveData);

		/* 저장된 정보 로드 */
		$data_refund		= $this->refundmodel->get_refund($_POST['refund_code']);
		$data_refund_item 	= $this->refundmodel->get_refund_item($_POST['refund_code']);
		$data_order			= $this->ordermodel->get_order($data_refund['order_seq']);
		$data_member		= $this->membermodel->get_member_data($data_order['member_seq']);

		$order_total_ea = $this->ordermodel->get_order_total_ea($data_refund['order_seq']);
		if($data_refund_item) foreach($data_refund_item as $item) $refund_ea += $item['ea'];

		if(!$this->arr_payment)	$this->arr_payment = config_load('payment');

		$saveData = array();
		$saveData['status'] = $_POST['status'];

		/* 환불신청 또는 환불처리중에서 환불완료로 변경될때 */
		if($data_refund['status']!='complete' && $_POST['status']=='complete')
		{
			$saveData['refund_date'] = date('Y-m-d H:i:s');
			$saveData['manager_seq'] = $this->managerInfo['manager_seq'];

			/* 무통장 환불 처리 */
			if($_POST['refund_method']=='bank' || $_POST['refund_method']=='manual' || $_POST['refund_method']=='cash')
			{
				// 별다른 처리 없음
			}
			/* PG 결제취소 처리 */
			else
			{
				if($data_order['settleprice']<$data_refund['refund_price']){
					openDialogAlert("환불금액이 실결제금액보다 클 수 없습니다.",400,140,'parent');
					exit;
				}

				$pgCompany = $this->config_system['pgCompany'];

				$pgCancelType = $data_refund['cancel_type'];

				/* 카드일땐 금액에 따라 전체취소할지 부분취소할지 결정함 */
				//if($_POST['refund_method']=='card'){
					if($data_order['settleprice']==$data_refund['refund_price'] && $order_total_ea==$refund_ea){
						// 전체금액일땐 전체취소
						$data_refund['cancel_type'] = 'full';
					}else{
						// 부분금액일땐 부분취소
						$data_refund['cancel_type'] = 'partial';
					}
				//}

				/* PG 부분취소 */
				if($data_refund['cancel_type']=='partial')
				{

					$cancelFunction = "{$pgCompany}_cancel";
					// 부분반품 시 기 동일 결제 방식 반품 금액을 계산하기위해 환불처리 방식을 전달이 필요 by hed 20180601
					$refund_method_set = false;
					if(empty($data_refund['refund_method'])){
						$data_refund['refund_method'] = $_POST['refund_method'];
						$refund_method_set = true;
					}
					$cancelResult = $this->refundmodel->$cancelFunction($data_order,$data_refund);
					// 이후 처리에 영향을 주지 않기 위해 다시 unset
					if($refund_method_set){
						unset($data_refund['refund_method']);
					}

					if(!$cancelResult['success']){
						openDialogAlert("{$pgCompany} 부분매입취소 실패<br /><font color=red>{$cancelResult['result_code']} : {$cancelResult['result_msg']}</font>",400,160,'parent','');
						exit;
					}

					$data_refund['cancel_type'] = 'partial';

				}
				/* PG 전체취소 */
				else
				{
					if($data_order['settleprice']!=$data_refund['refund_price']){
						openDialogAlert("PG 전체취소시에는 결제금액과 환불금액이 동일해야합니다.",400,140,'parent');
						exit;
					}

					$cancelFunction = "{$pgCompany}_cancel";
					// 부분반품 시 기 동일 결제 방식 반품 금액을 계산하기위해 환불처리 방식을 전달이 필요 by hed 20180601
					$refund_method_set = false;
					if(empty($data_refund['refund_method'])){
						$data_refund['refund_method'] = $_POST['refund_method'];
						$refund_method_set = true;
					}
					$cancelResult = $this->refundmodel->$cancelFunction($data_order,$data_refund);
					// 이후 처리에 영향을 주지 않기 위해 다시 unset
					if($refund_method_set){
						unset($data_refund['refund_method']);
					}

					if(!$cancelResult['success']){
						openDialogAlert("{$pgCompany} 결제 취소 실패<br /><font color=red>{$cancelResult['result_code']} : {$cancelResult['result_msg']}</font>",400,160,'parent','');
						exit;
					}
				}

			}

			// 추가옵션 관련 아이템 재배열
			$items_array	= array();
			if($data_refund_item)foreach($data_refund_item as $item){

				if( $item['goods_kind'] == 'coupon' ) {//티켓상품 마일리지/포인트, 재고, 할인쿠폰 반환없음
					$refund_goods_coupon_ea++;
				}

				if($item['title1'])		$item['options_str']  = $item['title1'] .":".$item['option1'];
				if($item['title2'])		$item['options_str'] .= " / ".$item['title2'] .":".$item['option2'];
				if($item['title3'])		$item['options_str'] .= " / ".$item['title3'] .":".$item['option3'];
				if($item['title4'])		$item['options_str'] .= " / ".$item['title4'] .":".$item['option4'];

				if	($item['opt_type'] == 'sub'){
					$item['price']								= $item['price'] * $item['ea'];
					$item['sub_options']							= $item['options_str'];
					if	($first_option_seq)
						$items_array[$first_option_seq]['sub'][]		= $item;
					else
						$items_array[$item['option_seq']]['sub'][]		= $item;
				}else{
					$items_array[$item['option_seq']]['price']			+= $item['price'] * $row['ea'];
					$items_array[$item['option_seq']]['ea']			+= $item['ea'];
					$items_array[$item['option_seq']]['option_ea']	+= $item['option_ea'];
					$items_array[$item['option_seq']]['goods_name']	= $item['goods_name'];
					$items_array[$item['option_seq']]['options']		= $item['options_str'];
					$items_array[$item['option_seq']]['inputs']		= $this->ordermodel->get_input_for_option($item['item_seq'], $item['option_seq']);
				}
				if	(!$first_option_seq)	$first_option_seq	= $item['option_seq'];
			}

			if( !$refund_goods_coupon_ea ) {
				/* 마일리지 지급 */
				if($data_refund['refund_emoney'])
				{
					$params = array(
						'gb'			=> 'plus',
						'type'			=> 'refund',
						'limit_date'	=> $_POST['refund_emoney_limit_date'],
						'emoney'		=> $data_refund['refund_emoney'],
						'ordno'         => $data_order['order_seq'],
						'memo'			=> "[복원] 주문환불({$data_refund['refund_code']})에 의한 마일리지 환원",
						'memo_lang'     => $this->membermodel->make_json_for_getAlert("mp246",$data_refund['refund_code']), // [복원] 주문환불(%s)에 의한 마일리지 환원
					);
					$this->membermodel->emoney_insert($params, $data_order['member_seq']);
				}

				/* 예치금 지급 */
				if($data_refund['refund_cash'])
				{
					$params = array(
						'gb'		=> 'plus',
						'type'		=> 'refund',
						'cash'		=> $data_refund['refund_cash'],
						'ordno'		=> $data_order['order_seq'],
						'memo'		=> "[복원] 주문환불({$data_refund['refund_code']})에 의한 예치금 환원",
						'memo_lang'	=> $this->membermodel->make_json_for_getAlert("mp247",$data_refund['refund_code']), // [복원] 주문환불(%s)에 의한 예치금 환원
					);
					$this->membermodel->cash_insert($params, $data_order['member_seq']);
				}

				// 구매확정 사용하지 않는 경우에만 회수
				if(!$cfg_order['buy_confirm_use']){
					/* 마일리지 회수 */
					if($_POST['return_reserve'] && $data_refund['refund_type']=='return'){
						$params = array(
							'gb'		=> 'minus',
							'type'		=> 'refund',
							'emoney'	=> $_POST['return_reserve'],
							'ordno'		=> $data_order['order_seq'],
							'memo'		=> "[차감] 주문환불({$data_order['order_seq']})에 의하여 배송완료시 지급된 마일리지 차감",
							'memo_lang'	=> $this->membermodel->make_json_for_getAlert("mp258",$data_order['order_seq']), // [차감] 주문환불(%s)에 의하여 배송완료시 지급된 마일리지 차감
						);
						$this->membermodel->emoney_insert($params, $data_order['member_seq']);
					}

					/* 포인트 회수 */
					if($_POST['return_point'] && $data_refund['refund_type']=='return'){
						$params = array(
							'gb'		=> 'minus',
							'type'		=> 'refund',
							'point'		=> $_POST['return_point'],
							'ordno'		=> $data_order['order_seq'],
							'memo'		=> "[차감] 주문환불({$data_order['order_seq']})에 의하여 배송완료시 지급된 포인트 차감",
							'memo_lang'	=> $this->membermodel->make_json_for_getAlert("mp259",$data_order['order_seq']), // [차감] 주문환불(%s)에 의하여 배송완료시 지급된 포인트 차감
						);
						$this->membermodel->point_insert($params, $data_order['member_seq']);
					}
				}
			}

			/* 환불처리완료 안내메일 발송 */
			$params = array_merge($saveData,$data_refund);
			$params['refund_reason']		= htmlspecialchars($data_refund['refund_reason']);
			$params['refund_date']			= $saveData['refund_date'];
			$params['mstatus'] 				= $this->refundmodel->arr_refund_status[$_POST['status']];
			$params['refund_price']			= number_format($data_refund['refund_price']);
			$params['refund_emoney']		= number_format($data_refund['refund_emoney']);
			$params['mrefund_method']		= $this->arr_payment[$data_refund['refund_method']];
			if($data_refund['refund_method']=='bank'){
				$params['mrefund_method']		.= " 환불";
			}elseif($data_refund['cancel_type']=='full'){
				$params['mrefund_method'] 		.= " 결제취소";
			}elseif($data_refund['cancel_type']=='partial'){
				$params['mrefund_method'] 		.= " 부분취소";
			}
			$params['items'] 			= $items_array;

			$email_type = $data_refund['refund_type']=='return' ? 'refund' : 'cancel';
			$result = sendMail($data_order['order_email'], $email_type, $data_member['userid'], $params);

			// 주문이 환불완료 일경우 주문한 회원의 구매횟수 및 구매금액 업데이트
			if($data_refund['refund_type'] == 'return' && $data_order['member_seq']){
				$refund_price = $data_refund['refund_price'] + $data_refund['refund_emoney'];
				if($data_order['member_seq']){

					$this->membermodel->member_order($data_order['member_seq']);

					//주문건/주문금액 필드추가 및 실시간업데이트 @2013-06-19
					$this->membermodel->member_order_batch($data_order['member_seq']);

				}
			}

			//이벤트 판매건/주문건/주문금액 @2013-11-15
			if($data_refund['refund_type'] == 'return' && $data_refund_item){
				foreach($data_refund_item as $item) {
					if( $item['event_seq'] ) {
						$this->eventmodel->event_order($item['event_seq']);
						$this->eventmodel->event_order_batch($item['event_seq']);
					}
				}
			}
		}

		$this->db->where('refund_code', $_POST['refund_code']);
		$this->db->update("fm_order_refund",$saveData);

		/* 환불신청 또는 환불처리중에서 환불완료로 변경될때 */
		if($data_refund['status']!='complete' && $_POST['status']=='complete')
		{
			/* 반품->환불완료시 SMS 발송 */
			//if($data_refund['refund_type']=='return'){

				$this->load->model('accountmodel');
				$this->accountmodel->set_refund($_POST['refund_code'],$saveData['refund_date']);

				$params = array();
				$params['shopName'] = $this->config_basic['shopName'];
				$params['ordno']	= $data_order['order_seq'];
				$params['user_name'] = $data_order['order_user_name'];
				if($data_refund['refund_type'] == 'return'){
				sendSMS($data_order['order_cellphone'], 'refund', '', $params);
				}else{
					sendSMS($data_order['order_cellphone'], 'cancel', '', $params);
				}
			//}

			/* 로그저장 */
			$logTitle = "환불완료";
			$logDetail = "관리자가 환불완료처리를 하였습니다.";
			$logParams	= array('refund_code' => $_POST['refund_code']);
			$this->ordermodel->set_log($data_order['order_seq'],'process',$this->providerInfo['provider_log_name'],$logTitle,$logDetail,$logParams);

			$callback = "parent.document.location.reload();";
			openDialogAlert("환불처리가 완료되었습니다.",400,140,'parent',$callback);
		}else{
			$callback = "parent.document.location.reload();";
			openDialogAlert("환불정보가 저장되었습니다.",400,140,'parent',$callback);
		}
	}

	// 관리자메모 변경
	public function admin_memo()
	{
		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('refund_act');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}
		/* 관리자 권한 체크 : 끝 */

		$refund_seq = $_GET['seq'];
		$this->validation->set_rules('admin_memo','관리자메모','trim|xss_clean');
		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		$data['admin_memo'] = $_POST['admin_memo'];
		$this->db->where('refund_seq', $refund_seq);
		$this->db->update('fm_order_refund', $data);
		openDialogAlert("관리자 메모가 변경 되었습니다.",400,140,'parent','');
	}

}

/* End of file refund_process.php */
/* Location: ./app/controllers/selleradmin/refund_process.php */