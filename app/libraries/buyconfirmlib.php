<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class buyconfirmlib {
	private $CI;
	public function __construct() {
		if(empty($this->CI)){
			$this->CI = & get_instance();
			if(empty($this->CI->cfg_order)){
				$this->CI->cfg_order = config_load('order');
			}
		}
	}
	/**
	 * 구매확정 버튼 노출 가능 여부 확인 by 출고 정보 기준
	 * 구매확정 버튼은 각 출고별로 선언.
	 * 구매확정 버튼 노출 기준
	 * 1. 구매확정 사용
	 * 2. 실물 상품 출고 정보
	 * 3. 구매확정 가능 수량 존재 : $exp_item['reserve_ea']
	 *    = reserve_ea : 지급해야할 마일리지 수량이 있는 경우 (환불, 교환, 취소에 따라 값이 변경된다.)
	 * 
	 * @return array
	 * 구매확정 버튼 노출 관련 데이터
	 * 1. 노출 여부 : btn_buyconfirm
	 * 2. 기 구매확정 갯수 : reserve_buyconfirm_ea
	 */
	public function check_buyconfirm($in_exp, $in_exp_item = array()){
		$buyconfirmInfo = array();
		
		// 반품신청 가능 기간 체크
		if(empty(isset($in_exp['return_able_term']))){
			if($this->CI->cfg_order['buy_confirm_use']){
				// 구매확정 사용시 출고완료일 후 n일 내에만 반품신청 가능
				$order_return_edate = date('Ymd',strtotime('+'.$this->CI->cfg_order['save_term'].' day',strtotime($in_exp['complete_date'])));
				$in_exp['return_able_term'] = (date('Ymd')<=$order_return_edate)?1:0;
			}else{
				// 구매확정 미사용시 배송완료일 후 n일 내에만 반품신청 가능
				$order_return_sdate = date('Ymd',strtotime('+'.$this->CI->cfg_order['save_term'].' day',strtotime($in_exp['shipping_date'])));
				$in_exp['return_able_term'] = (date('Ymd')<=$order_return_sdate)?1:0;
			}
		}
		// 반품신청 가능 기간과 구매확정 가능 기간은 별다른 관계가 없다고 판단하여 해당 프로세스를 제외 by hed
		$in_exp['return_able_term'] = 1;
		
		// 별도로 할당 받은 출고 아이템 정보가 있다면 갱신.
		if($in_exp_item && empty($in_exp['items'])){
			$in_exp['items'] = $in_exp_item;
		}
		
		// 티켓상품의 출고 여부
		if(empty($in_exp['goods_kind'])){
			// 티켓상품의 경우 주문과 동시에 출고되므로 실물상품과 동일한 출고라인에 올 수 없음
			$in_exp['goods_kind'] = $in_exp_item[0]['goods_kind'];
		}
		
		// 구매확정 버튼 제어
		$buyconfirmInfo['btn_buyconfirm']	= false;
		$buyconfirmInfo['reserve_buyconfirm_ea'] = 0;
		if	($in_exp['goods_kind'] == 'goods' && $this->CI->cfg_order['buy_confirm_use']){
			$reserve_ea = 0;
			foreach($in_exp['items'] as $exp_item){
				$reserve_ea = $reserve_ea + $exp_item['reserve_ea'];
				$reserve_buyconfirm_ea	+= $exp_item['reserve_buyconfirm_ea'];
			}
			// 출고준비 상태에서는 구매확정 불가
			if($reserve_ea > 0 && $in_exp['return_able_term'] && $in_exp['status'] > '45'){
				
				// 구매확정 중 반품 신청이 있는지 확인
				$params_check_buyconfirm = array();
				$params_check_buyconfirm['order_seq']		= $in_exp['order_seq'];
				$params_check_buyconfirm['export_code']		= $in_exp['export_code'];

				$this->CI->load->model('buyconfirmmodel');
				$check_buyconfirm = $this->CI->buyconfirmmodel->check_ing_return_for_buyconfirm($params_check_buyconfirm);

				$buyconfirmInfo['btn_buyconfirm']	= $check_buyconfirm;
			}
			$buyconfirmInfo['reserve_buyconfirm_ea'] = $reserve_buyconfirm_ea;
		}
		return $buyconfirmInfo;
	}
	
	/**
	 * 구매확정 처리
	 * @param type $export_code
	 * @param type $msg
	 * @param type $addParams			// added by hyem 2021.04.15
	 * 					["partner"] (npay, talkbuy, openmarket ....) : 외부 주문
	 * 					["actor"] (npay, talkbuy, system, admin) : 행위자
	 */
	public function exec_buyconfirm($export_code, &$msg = '', $addParams = null){
		$this->CI->load->model('exportmodel');
		$this->CI->load->model('ordermodel');

		$data_export_item	= $this->CI->exportmodel->get_export_item($export_code);
		$data_export		= $this->CI->exportmodel->get_export($export_code);

		if ($data_export['status'] == 45) {
			$msg .= '출고준비 상태에서는 구매확정을 하실 수 없습니다.';
			return false;
		}

		if ($data_export_item[0]['goods_kind'] == 'coupon') {
			$msg .= '티켓상품에서는 구매확정을 하실 수 없습니다.';
			return false;
		}

		// 구매확정 중 반품 신청이 있는지 확인
		$params_check_buyconfirm = array();
		$params_check_buyconfirm['order_seq']		= $data_export['order_seq'];
		$params_check_buyconfirm['export_code']		= $data_export['export_code'];

		$this->CI->load->model('buyconfirmmodel');
		$check_buyconfirm = $this->CI->buyconfirmmodel->check_ing_return_for_buyconfirm($params_check_buyconfirm);

		if(!$check_buyconfirm){
			//D출고건은 반품신청 중이므로 구매확정할 수 없습니다.
			$msg .= getAlert('mp301', $params_check_buyconfirm['export_code']);
			return false;
		}

		//구매확정 사용, 마일리지 미지급 상태
		if($this->CI->cfg_order['buy_confirm_use']){

			$tot_confirm_ea		= 0;
			$mode				= "buyconfirm";
			$export_items		= array();
			foreach($data_export_item as $k => $item)
			{
				$tmp = array();
				$tmp['opt_type']				= $item['opt_type'];
				$tmp['reserve_ea']				= $item['reserve_ea'];
				$tmp['reserve_buyconfirm_ea']	= $item['reserve_buyconfirm_ea'];
				$tmp['reserve_destroy_ea']		= $item['reserve_destroy_ea'];
				$tmp['option_seq']				= $item['option_seq'];
				$tmp['export_item_seq']			= $item['export_item_seq'];
				$tot_confirm_ea					+= $item['reserve_ea'];

				$export_items[] = $tmp;
			}

			## 마일리지 지급예정수량이 있을때
			if($tot_confirm_ea > 0){

				$edate		= date('Y-m-d',strtotime("-".$this->CI->cfg_order['save_term']." day"));
				## 배송완료일 > 구매확정시 마일리지 지급 기간 or 기간 만료시 마일리지 무조건 지급
				if( $data_export['complete_date'] >= $edate || $this->CI->cfg_order['save_type'] == 'give'){

					$data_order		= $this->CI->ordermodel->get_order($data_export['order_seq']);
					foreach($export_items as $k => $item)
					{

						// 마일리지 지급예정수량 2015-03-31 pjm
						$confirm_ea		= $item['reserve_ea'];

						$reserve = 0;
						if($item['opt_type'] == 'opt') $reserve = $this->CI->ordermodel->get_option_reserve($item['option_seq']);
						else $reserve = $this->CI->ordermodel->get_suboption_reserve($item['option_seq']);
						$tot_reserve += $reserve * $confirm_ea;

						$point = 0;
						if($item['opt_type'] == 'opt') $point = $this->CI->ordermodel->get_option_reserve($item['option_seq'],'point');
						else $point = $this->CI->ordermodel->get_suboption_reserve($item['option_seq'],'point');
						$tot_point += $point * $confirm_ea;

						#지급예정수량 : 0, 지급완료수량 : 지급예정수량
						$tmp = array();
						$tmp['export_item_seq']			= $item['export_item_seq'];
						$tmp['reserve_ea']				= 0;
						$tmp['reserve_buyconfirm_ea']	= $item['reserve_ea']+$item['reserve_buyconfirm_ea'];
						$chg_reserve[]					= $tmp;

					}

					if( $data_order['member_seq'] ){
						$this->CI->load->model('membermodel');
						if($tot_reserve){
							$params_reserve['gb']			= "plus";
							$params_reserve['emoney']		= $tot_reserve;
							$params_reserve['memo']			= "[".$export_code."] 구매확정";
							$params_reserve['memo_lang'] 	= $this->CI->membermodel->make_json_for_getAlert("mp238",$export_code);   // [%s] 구매확정
							$params_reserve['ordno']		= $data_order['order_seq'];
							$params_reserve['type']			= "order";
							$params_reserve['limit_date'] 	= get_emoney_limitdate('order');
							$this->CI->membermodel->emoney_insert($params_reserve, $data_order['member_seq']);
						}
						if($tot_point){
							$params_point['gb']				= "plus";
							$params_point['point']          = $tot_point;
							$params_point['memo']           = "[".$export_code."] 구매확정";
							$params_point['memo_lang']		= $this->CI->membermodel->make_json_for_getAlert("mp238",$export_code);   // [%s] 구매확정
							$params_point['ordno']          = $data_order['order_seq'];
							$params_point['type']           = "order";
							$params_point['limit_date'] 	= get_point_limitdate('order');
							$this->CI->membermodel->point_insert($params_point, $data_order['member_seq']);
						}

						$query = "update fm_goods_export set reserve_save = 'save' where export_code = ?";
						$this->CI->db->query($query,array($export_code));

					}


				## 지급예정 수량 소멸 처리
				}elseif($data_export['complete_date'] < $edate && $this->CI->cfg_order['save_type'] == 'exist'){

					$mode = "destroy";
					foreach($data_export_item as $k => $item)
					{
						#지급예정수량 : 0, 소멸수량 : 지급예정수량
						$tmp = array();
						$tmp['export_item_seq']			= $item['export_item_seq'];
						$tmp['reserve_ea']				= 0;
						$tmp['reserve_destroy_ea']		= $item['reserve_ea']+$item['reserve_destroy_ea'];
						$chg_reserve[]					= $tmp;
					}
				}
				## 출고아이템에 마일리지 지급예정수량, 지급완료 수량 업데이트 2015-03-31 pjm
				$this->CI->exportmodel->exec_export_reserve_ea($chg_reserve,$mode);
			}
		}

		if($mode == "buyconfirm") $mode = "pay";

		// 구매확정 행위자
		if($addParams["actor"]) {
			$data_buy_confirm['actor_id']		= $addParams["actor"];
			$data_buy_confirm['doer']			= $addParams["doer"] ? $addParams["doer"] : ucfirst($addParams["actor"]);
			$actor = $data_buy_confirm['actor_id'] ? $data_buy_confirm['actor_id'] : "system";
		} else {
			$data_buy_confirm['manager_seq']	= $this->CI->managerInfo['manager_seq'];
			$data_buy_confirm['actor_id']		= $this->CI->managerInfo['manager_id'];
			$data_buy_confirm['doer']			= $this->CI->managerInfo['mname'];
			$actor = "admin";
		}

		$data_buy_confirm['order_seq']		= $data_export['order_seq'];
		$data_buy_confirm['export_seq']		= $data_export['export_seq'];
		$data_buy_confirm['ea']				= $tot_confirm_ea;
		$data_buy_confirm['emoney_status']	= $mode;
		
		$this->CI->load->model('buyconfirmmodel');
		$this->CI->buyconfirmmodel -> buy_confirm($actor,$export_code);
		$this->CI->buyconfirmmodel -> log_buy_confirm($data_buy_confirm);

		// 배송완료 처리
		if( $data_export['status'] < 75 ){
			$this->CI->exportSmsData = array();
			$this->CI->exportmodel->exec_complete_delivery($export_code, $addParams["doer"]);

			// 외부 주문은 sms 미 발송
			if(!isset($addParams["partner"])) {
				if(count($this->CI->exportSmsData) > 0){
					commonSendSMS($this->CI->exportSmsData);
				}
			}
		}

		// 주문로그
		$order_log_title	= '구매확정('.$export_code.':'.$tot_confirm_ea.")";
		$this->CI->ordermodel->set_log($data_export['order_seq'],'buyconfirm',$data_buy_confirm['doer'],$order_log_title,'','','',$addParams["actor"]);

		/**
		* 2-1 임시매출데이타를 이용한 미정산데이타 또는 통합정산테이블 시작
		* 정산개선 - 통합정산데이타 생성
		* @ 
		**/
		if(!$this->CI->accountall)			$this->CI->load->helper('accountall');
		if(!$this->CI->accountallmodel)		$this->CI->load->model('accountallmodel');
		if(!$this->CI->providermodel)		$this->CI->load->model('providermodel');
		//정산대상 수량업데이트
		$this->CI->accountallmodel->update_calculate_sales_ac_ea($data_export['order_seq'],$export_code);
		//정산확정 처리
		$this->CI->accountallmodel->insert_calculate_sales_buyconfirm($data_export['order_seq'], $export_code, $tot_confirm_ea);
		//debug_var($this->db->queries);
		//debug_var($this->db->query_times);
		/**
		* 2-1 임시매출데이타를 이용한 미정산데이타 또는 통합정산테이블 끝
		* 정산개선 - 통합정산데이타 생성
		* @
		**/
		$msg .= '구매확정이 완료 되었습니다.';
		return true;
	}
}