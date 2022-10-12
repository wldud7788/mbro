<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class calculatelibrary
{
	protected $ci = null;
	protected $gl_get_params = null;
	protected $gl_post_params = null;
	public $allow_exit = true;
    public function __construct() {
		$this->ci = & get_instance();
		$this->ci->load->helper('basic');
		$this->ci->load->helper('javascript');
		$this->gl_get_params = $this->ci->input->get();
		$this->gl_post_params = $this->ci->input->post();
		
		if($this->gl_post_params) $this->gl_get_params = $this->gl_post_params;
    }
	
	public function exec_calculate($adminOrder="", $person_seq='', $mode=''){
		

		// 기본값 정의
		$applypage						= 'order';
		$members						= "";
		$err_reserve					= "";
		$total_price					= 0;
		$total_reserve					= 0;
		$total_point					= 0;
		$goods_weight					= 0;
		$sum_goods_price				= 0;
		$total_coupon_sale				= 0;
		$total_fblike_sale				= 0;
		$total_mobile_sale				= 0;
		$total_goods_price				= 0;
		$total_member_sale				= 0;
		$total_real_sale_price			= 0;
		$international_shipping_price	= 0;
		$scripts						= array();
		if	(!$person_seq && $this->gl_post_params['person_seq'])	$person_seq	= $this->gl_post_params['person_seq'];
		// 모바일결제 : 체크값 오류시 callback으로 결제창 layer 숨김 처리
		$pg_cancel_script				= ($this->gl_post_params['mobilenew'] == "y") ? $this->ci->pg_cancel_script() : '';

		// 관리자 주문 예외처리 값
		if(!$adminOrder)	$adminOrder	= ($this->gl_get_params["adminOrder"]) ? $this->gl_get_params["adminOrder"] : '';
		if(!$person_seq)	$person_seq	= ($this->gl_get_params["person_seq"]) ? $this->gl_get_params["person_seq"] : '';
		$adminOrderType					= ($this->gl_get_params['adminOrderType'] == 'person') ? 'person' : '';

		$cfg['order'] = ($this->ci->cfg_order) ? $this->ci->cfg_order : config_load('order');
		$cfg_reserve					= ($this->ci->reserves)?$this->ci->reserves:config_load('reserve');
		$pg								= config_load($this->ci->config_system['pgCompany']);
		$shipping						= use_shipping_method();
		$this->ci->shipping_order							= $shipping;

		// 입점사별 상품구매금액 합계
		$this->ci->provider_sum_goods_price					= array();
		// 입점사별 상품 무게 합계
		$this->ci->provider_goods_weight					= array();
		// 입점사별 해외배송비 합계
		$this->ci->provider_international_shipping_price	= array();
		// 입점사별 기본배송비
		$this->ci->provider_shipping_cost					= array();

		if	(is_array($shipping) )
			$international_shipping	= $shipping[1][$this->gl_post_params['shipping_method_international']];

		// 회원정보 추출
		if		($adminOrder == "admin" && $this->gl_get_params['member_seq'] && $this->ci->displaymode == 'coupon'){
			$this->gl_get_params['member_seq']		= (int) $this->gl_get_params['member_seq'];
			$members	= $this->ci->membermodel->get_member_data($this->gl_get_params['member_seq']);
		}elseif	($adminOrder == "admin" && $this->gl_post_params['member_seq']){
			$this->gl_post_params['member_seq']		= (int) $this->gl_post_params['member_seq'];
			$members	= $this->ci->membermodel->get_member_data($this->gl_post_params['member_seq']);
		}elseif	($adminOrder != "admin" && $this->ci->userInfo['member_seq']){
			$members	= $this->ci->membermodel->get_member_data($this->ci->userInfo['member_seq']);
		}
		$member_seq		= $members['member_seq'];
		$member_group	= $members['group_seq'];
		$total_emoney	= $members['emoney'];
		$total_cash		= $members['cash'];
		if( $member_seq != '' ){
			$members['emoney']	= $this->ci->membermodel->get_emoney($member_seq);
			
			if($mode != 'o2o'){
				// O2O 조회로 인해 블럭되어 있는지 확인
				$this->ci->load->library("o2o/o2oservicelibrary");
				$this->ci->o2oservicelibrary->check_o2o_benefit($this->allow_exit, $member_seq);
			}
		}

		// 마일리지 전체 사용일때 회원 총 마일리지 불러오기
		if($this->gl_post_params['emoney_all'] == "y"){
			$this->gl_post_params['emoney']	= $members['emoney'];
		}

		// 장바구니 정보 추출
		if		($adminOrder == 'admin' && $adminOrderType == 'person'){
			$this->ci->load->model('personcartmodel');
			$cart	= $this->ci->personcartmodel->catalog($member_seq, $person_seq);
		}elseif	($person_seq > 0){
			$this->ci->load->model('personcartmodel');
			$cart	= $this->ci->personcartmodel->catalog($this->ci->userInfo['member_seq'], $person_seq);
			if	($cart['person']['use_reserve']){
				$this->ci->person_use_reserve				= 1;
				$cfg_reserve['default_reserve_limit']	= $cart['person']['reserve_limit'];
			}
		}else{
			$this->ci->load->model('cartmodel');
			$cart	= $this->ci->cartmodel->catalog($adminOrder);
		}
		$this->ci->cart	= $cart;
		
		if	( $adminOrder != 'admin' && !$cart['list'] && $this->ci->displaymode != 'cart' ){
			pageLocation('../main/index',getAlert('os111'));
			$this->call_exit();
		}

		/* 구매 시 마일리지액 제한 조건 추가 leewh 2014-06-25 */
		if ($cfg_reserve['default_reserve_limit']>=2){
			if (isset($this->gl_post_params['appointed_reserve'])) {
				$appointed_reserve = $this->gl_post_params['appointed_reserve'];
			}

			if ($cfg_reserve['default_reserve_limit']==3) {
				unset($cal_total_real_sale_price);
				if (isset($this->gl_post_params['total_real_sale_price'])) {
					$cal_total_real_sale_price = $this->gl_post_params['total_real_sale_price'];
				}

				$tot_using_reserve = 0; // 상품 사용마일리지

				if ($this->gl_post_params['emoney'] > 0) {
					// 총 사용 마일리지 재정의 총 상품실결제금액보다 총 결제금액이 클 경우
					if ($cal_total_real_sale_price < $this->gl_post_params['emoney']) {
						$tot_using_reserve = $cal_total_real_sale_price;
					} else {
						$tot_using_reserve = $this->gl_post_params['emoney'];
					}
				}
			}
		}

		$is_international_shipping = false; // 해외배송상품
		/**** 재고 체크 및 최대/최소 구매수량 체크 ****/
		foreach($cart['data_goods'] as $goods_seq => $data){
			if($data['option_international_shipping_status'] == 'y'){
				$is_international_shipping = true; // 해외배송상품
			}

			if($data['option_ea']){
				$optEa = $data['option_ea'];
			}else{
				$optEa = $data['ea'];
			}

			// 구매수량 체크
			if($data['min_purchase_ea'] && $data['min_purchase_ea'] >  $optEa){
				//addslashes($data['goods_name']).'은 '.$data['min_purchase_ea'].'개 이상 구매하셔야 합니다.'
				$err_msg = getAlert('os006',array(addslashes($data['goods_name']),$data['min_purchase_ea']));
				if( $this->ci->displaymode == 'cart' ) {
					alert($err_msg);
				}else{
					openDialogAlert($err_msg,400,140,'parent',$pg_cancel_script);
					$this->call_exit();
				}
			}
			if($data['max_purchase_ea'] && $data['max_purchase_ea'] < $optEa){
				//addslashes($data['goods_name']).'은 '.$data['max_purchase_ea'].'개 이상 구매하실 수 없습니다.'
				$err_msg = getAlert('os007',array(addslashes($data['goods_name']),$data['max_purchase_ea']+1));
				if( $this->ci->displaymode == 'cart' ) {
					alert($err_msg);
				}else{
					openDialogAlert($err_msg,400,140,'parent',$pg_cancel_script);
					$this->call_exit();
				}
			}

			// 단독이벤트만 판매시 이벤트기간이 아니면 판매중지 @2013-11-29
			if( $data['event']['event_goodsStatus'] === true ){
				//↓아래 상품은 단독이벤트 기간에만 구매가 가능합니다.
				$err_msg = getAlert('os008');
				$err_msg .= "\\n".addslashes($data['goods_name']);
				if( $this->ci->displaymode == 'cart' ) {
					alert($err_msg);
				}else{
					openDialogAlert($err_msg,400,140,'parent',$pg_cancel_script);
					$this->call_exit();
				}
			}

			//배송비쿠폰 개별배송상품 체크
			if($data['shipping_policy'] == 'shop'){
				$this->ci->arr_shop_shipping_cnt++;
			}else{
				$this->ci->arr_goods_shipping_price++;
			}

			if($data['ea_for_option'])foreach($data['ea_for_option'] as $option_key => $option_ea){

				$option_r = explode(' ^^ ',$option_key);
				$option_t = explode(' ^^ ',$data['option_title']);

				// 재고 체크
				$chk = check_stock_option(
					$goods_seq,
					$option_r[0],
					$option_r[1],
					$option_r[2],
					$option_r[3],
					$option_r[4],
					$option_ea,
					$cfg['order'],
					'view_stock'
				);

				if( $chk['stock'] < 0 ){
					$opttitle = '';
					if($option_r[0]) $opttitle .= $option_r[0];
					if($option_r[1]) $opttitle .= ' '.$option_r[1];
					if($option_r[2]) $opttitle .= ' '.$option_r[2];
					if($option_r[3]) $opttitle .= ' '.$option_r[3];
					if($option_r[4]) $opttitle .= ' '.$option_r[4];

					$opttitle = '';
					foreach($option_r as $optKey => $optVal){
						if($optVal && $option_t[$optKey]) $opttmp = $option_t[$optKey] . ':';
						if($optVal)	$tmpopttitle[] = $opttmp . $optVal;
					}
					if(count($tmpopttitle) > 0)
						$opttitle			= implode(', ', $tmpopttitle);
					$goodsName	= addslashes($data['goods_name']);
					if	($opttitle)	$goodsName	.= ' (' . $opttitle . ')';

					//구매가능재고를 초과한 상품을 알려 드립니다.<br/> $goodsName | $ea개 → 구매가능재고는 $chk['sale_able_stock']개입니다.
					$err_msg = getAlert('os009', array($goodsName, $option_ea, $chk['sale_able_stock']));
					if( $this->ci->displaymode == 'cart' ) {
						alert($err_msg);
					}else{
						openDialogAlert($err_msg,400,140,'parent',$pg_cancel_script);
						$this->call_exit();
					}
				}
			}

			if($data['ea_for_suboption']) foreach($data['ea_for_suboption'] as $option_key => $option_ea){
				$option_r = explode(' ^^ ',$option_key);
				// 재고 체크
				$chk = check_stock_suboption(
					$goods_seq,
					$option_r[0],
					$option_r[1],
					$option_ea,
					$cfg['order'],
					'view_stock'
				);

				if( $chk['stock'] < 0 ){
					$opttitle = '';
					if($option_r[1]) $opttitle = $option_r[0] . ':' . $option_r[1];
					$goodsName = addslashes($data['goods_name']);
					if	($opttitle)	$goodsName	.= ' (' . $opttitle . ')';

					//구매가능재고를 초과한 상품을 알려 드립니다.<br/> $goodsName | $ea개 → 구매가능재고는 $chk['sale_able_stock']개입니다.
					$err_msg = getAlert('os009', array($goodsName, $option_ea, $chk['sale_able_stock']));
					if( $this->ci->displaymode == 'cart' ) {
						alert($err_msg);
					}else{
						openDialogAlert($err_msg,400,140,'parent',$pg_cancel_script);
						$this->call_exit();
					}
				}
			}
		}
		/* **************************************************** */

		// 주문서 쿠폰 할인 초기화
		// 장바구니에 담긴 각 상품별 쿠폰 할인을 계산하기 전 미리 설정
		$ordersheet_coupon_download_seq = $this->gl_post_params['ordersheet_coupon_download_seq'];
		$cart['ordersheet_coupon_download_seq'] = $ordersheet_coupon_download_seq;
		
		// 주문서 쿠폰에서 총액 계산 용, 쿠폰은 필수옵션금액에서만 할인된다.
		foreach($cart['list'] as $key => $data) {
			$sum_option_total_price				+= $data['price'];
		}

		//----> sale library 적용
		$cart['total']					= $cart['total_sale_price'];
		$param['cal_type']				= 'list';
		$param['total_price']			= $cart['total_sale_price'];
		$param['reserve_cfg']			= $cfg_reserve;
		$param['tot_use_emoney']		= $tot_using_reserve;
		$param['member_seq']			= $member_seq;
		$param['group_seq']				= $member_group;
		// 주문서 쿠폰 할인 계산을 위한 파라미터 추가
		if($ordersheet_coupon_download_seq){
			$param['ordersheet_coupon_seq'] = $ordersheet_coupon_download_seq;
			$param['sum_option_total_price']		= $sum_option_total_price;
		}
		$this->ci->sale->set_init($param);
		$this->ci->sale->preload_set_config($applypage);
		//<---- sale library 적용
		
		if(!$this->ci->displaymode)
			echo "<script type='text/javascript' src='/app/javascript/jquery/jquery.min.js'></script>";
		$scripts[]	= "<script type='text/javascript'>";
		$scripts[]	= "$(function() {";
		
		foreach($cart['list'] as $key => $data) {

			// 초기값
			$category				= ($data['r_category']) ? $data['r_category'] : array();
			$data['ori_price']		= $data['price'];
			$cart_suboptions		= $data['cart_suboptions'];
			$cart_inputs			= $data['cart_inputs'];
			$coupon_download_seq	= $this->gl_post_params['coupon_download'][$data['cart_seq']][$data['cart_option_seq']];

			//----> sale library 적용
			unset($param, $sales, $optsalelist);
			$param['option_type']					= 'option';
			$param['consumer_price']				= $data['consumer_price'];
			$param['price']							= $data['org_price'];
			$param['sale_price']					= $data['price'];
			$param['ea']							= $data['ea'];
			$param['goods_ea']						= $cart['data_goods'][$data['goods_seq']]['ea'];
			$param['option_ea']						= $cart['data_goods'][$data['goods_seq']]['option_ea'];
			$param['category_code']					= $category;
			$param['goods_seq']						= $data['goods_seq'];
			$param['goods']							= $data;
			$param['sum_option_total_price']		= $sum_option_total_price;
			
			if	($coupon_download_seq)
				$param['coupon_download_seq']		= $coupon_download_seq;
			$this->ci->sale->set_init($param);
			$sales	= $this->ci->sale->calculate_sale_price($applypage);

			//이벤트 쿠폰/코드 사용제한2 @2015-08-13
			if	( $this->ci->sale->goods['event'] ) {
				if( $this->ci->sale->goods['event']['use_coupon'] == 'n' && !in_array($data['goods_seq'],$this->ci->ordernosales_cp) ) {
					$this->ci->ordernosales_cp[$data['goods_seq']] = $this->ci->sale->goods['event']['event_seq'];
				}
				if( $this->ci->sale->goods['event']['use_coupon_shipping'] == 'n' && !in_array($data['shipping']['provider_seq'],$this->ci->ordernosales_cp_sh)  ) {
					$this->ci->ordernosales_cp_sh[$data['shipping']['provider_seq']] = $this->ci->sale->goods['event']['event_seq'];
				}
				if( $this->ci->sale->goods['event']['use_coupon_ordersheet'] == 'n' && !in_array($data['goods_seq'],$this->ci->ordernosales_cp_os)  ) {
					$this->ci->ordernosales_cp_os[$data['goods_seq']] = $this->ci->sale->goods['event']['event_seq'];
				}
				if( $this->ci->sale->goods['event']['use_code'] == 'n' && !in_array($data['goods_seq'],$this->ci->ordernosales_cd)  ) {
					$this->ci->ordernosales_cd[$data['goods_seq']] = $this->ci->sale->goods['event']['event_seq'];
				}
				if( $this->ci->sale->goods['event']['use_code_shipping'] == 'n' && !in_array($data['shipping']['provider_seq'],$this->ci->ordernosales_cd_sh)  ) {
					$this->ci->ordernosales_cd_sh[$data['shipping']['provider_seq']] = $this->ci->sale->goods['event']['event_seq'];
				}
			}
			// 기본 정보
			$data['org_price']							= ($data['consumer_price']) ? $data['consumer_price'] : $data['price'];
			$opt_price									= $sales['one_result_price'];
			$data['sale_price']							= $sales['one_result_price'];
			if	(!$param['sale_price']){
				$data['original_price']					= $sales['one_sale_list']['original'];//정가
				$data['basic_sale']						= $sales['one_sale_list']['basic'];
			}

			// 이벤트, 복수구매 할인 정보 :: 2018-07-10 lkh
			$data['event_sale_target']					= ($sales['target_list']['event'] == 1) ? 'consumer_price' : 'price';
			$data['event_sale']							= $sales['sale_list']['event'];
			$data['event_reserve']						= $sales['one_reserve_list']['event'];
			$data['event_point']						= $sales['one_point_list']['event'];
			$data['multi_sale']							= $sales['sale_list']['multi'];

			$data['event_sale_unit']					= $sales['one_sale_list']['event'];//이벤트할인(개당)
			$data['multi_sale_unit']					= $sales['one_sale_list']['multi'];//복수구매할인(개당)

			// 쿠폰할인 정보
			$data['coupon_sale']						= $sales['sale_list']['coupon'];
			$data['coupon_sale_unit']					= $sales['one_sale_list']['coupon'];//쿠폰할인(개당)
			$data['coupon_sale_rest']					= $data['coupon_sale']-($data['coupon_sale_unit']*$data['ea']);//쿠폰할인-짜투리
			$data['coupon']['salescost_admin']			= $this->ci->sale->coupon_salescost['admin'];
			$data['coupon']['salescost_provider']		= $this->ci->sale->coupon_salescost['provider'];
			$data['coupon']['provider_list']			= $this->ci->sale->coupon_salescost['list'];
			$data['download_seq']						= $coupon_download_seq;
			$data['coupon_select_duplication_use']		= false;
			if	($coupon_download_seq){
				$coupon_same_time_n						= $this->ci->sale->coupon_same_time_n;
				$coupon_same_time_n_duplication_n		= $this->ci->sale->coupon_duplication_n;
				$coupon_same_time_y						= $this->ci->sale->coupon_same_time_y;
				$coupon_sale_payment_b					= $this->ci->sale->coupon_sale_payment_b;
				$coupon_sale_agent_m					= $this->ci->sale->coupon_sale_agent_m;
			}
			
			// 주문서쿠폰 할인정보
			$data['unit_ordersheet']					= $sales['sale_list']['ordersheet'];
			// 정산용 쿠폰 세일 금액에 주문서 쿠폰 할인 내역을 추가
			$data['coupon_sale_unit']					+= (int)($sales['sale_list']['ordersheet']/$data['ea']);	
			$data['coupon_sale_rest']					+= $sales['sale_list']['ordersheet'] - (((int)($sales['sale_list']['ordersheet']/$data['ea']))*$data['ea']);	

			// 쿠폰 사용 팝업에서 전체 쿠폰 추출
			if	( $members && $person_seq == "" && $this->ci->displaymode == 'coupon'){
				if( !$this->ci->ordernosales_cp[$data['goods_seq']] ) {//이벤트 쿠폰 사용제한 @2015-08-13
					$coupons			= $this->ci->couponmodel->get_able_use_list($members['member_seq'],$data['goods_seq'],$category, $cart['total'], $data['price'], $data['ea']);
					$data['coupons']	= $coupons;
					# 선택한 쿠폰의 중복할인 적용 여부
					if($coupon_download_seq){
						foreach($coupons as $coupon_data){
							if($coupon_data['coupon_seq'] == $sales['seq_list']['coupon'] && $coupon_download_seq == $coupon_data['download_seq']){
								$data['coupon_select_duplication_use']	= $coupon_data['duplication_use'];
							}
						}
					}
				}
			}else{
				$data['coupons']						= $this->ci->sale->couponSales;
			}

			// 회원할인 정보
			$member_sale								+= $data['member_sale'];
			$data['member_sale']						= $sales['sale_list']['member'];
			$data['member_sale_unit']					= $sales['one_sale_list']['member'];//등급할인(개당)
			$data['member_sale_rest']					= $data['member_sale']-($data['member_sale_unit']*$data['ea']);//등급할인-짜투리
			// 코드할인 정보
			$data['promotion_code_seq']					= $this->ci->sale->code_seq;
			$data['promotion_code_sale']				= $sales['sale_list']['code'];
			$data['code_sale_unit']						= $sales['one_sale_list']['code'];//코드할인(개당)
			$data['code_sale_rest']						= $data['promotion_code_sale']-($data['code_sale_unit']*$data['ea']);//코드할인-짜투리
			$data['promotion']['salescost_admin']		= $this->ci->sale->code_salescost['admin'];
			$data['promotion']['salescost_provider']	= $this->ci->sale->code_salescost['provider'];
			$data['promotion']['provider_list']			= $this->ci->sale->code_salescost['list'];

			// 좋아요 할인 정보
			$data['fblike_sale']						= $sales['sale_list']['like'];
			$data['fblike_sale_unit']					= $sales['one_sale_list']['like'];//좋아요할인(개당)
			$data['fblike_sale_rest']					= $data['fblike_sale']-($data['fblike_sale_unit']*$data['ea']);//좋아요-짜투리

			// 모바일할인 정보
			$data['mobile_sale']						= $sales['sale_list']['mobile'];
			$data['mobile_sale_unit']					= $sales['one_sale_list']['mobile'];//모바일할인(개당)
			$data['mobile_sale_rest']					= $data['mobile_sale']-($data['mobile_sale_unit']*$data['ea']);//모바일할인-짜투리

			// 유입경로 할인 정보
			$data['referersale_seq']					= $this->ci->sale->referer_seq;
			$data['referer_sale']						= $sales['sale_list']['referer'];
			$data['referer_sale_unit']					= $sales['one_sale_list']['referer'];
			$data['referer_sale_rest']					= $data['referer_sale']-($data['referer_sale_unit']*$data['ea']);//유입경로할인-짜투리
			$data['referersale']['salescost_provider']	= $this->ci->sale->referer_salecode['provider'];
			$data['referersale']['provider_list']		= $this->ci->sale->referer_salecode['list'];


			// sale_price가 없을 시 여기서 event까지 계산함
			if	(!$data['event'] && $this->ci->sale->cfgs['event']){
				$data['event']					= $this->ci->sale->cfgs['event'];
				$data['eventEnd']				= $sales['eventEnd'];
			}

			// 마일리지 / 포인트 ( 실결제 금액 기준이기에 여기서 계산 )
			// 이벤트 마일리지 / 포인트 계산 ( 장바구니에서 혜택적용할인가를 받아서 쓸 경우만 )
			if	($param['sale_price']){
				$this->ci->sale->cfgs['event']		= $data['event'];
				$data['event_reserve']			= $this->ci->sale->event_sale_reserve($sales['one_result_price']);
				$data['event_point']			= $this->ci->sale->event_sale_point($sales['one_result_price']);
			}
			$data['member_reserve']						= $sales['one_reserve_list']['member'];
			$data['member_point']						= $sales['one_point_list']['member'];
			$data['fb_reserve']							= $sales['one_reserve_list']['like'];
			$data['fb_point']							= $sales['one_point_list']['like'];
			$data['mobile_reserve']						= $sales['one_reserve_list']['mobile'];
			$data['mobile_point']						= $sales['one_point_list']['mobile'];

			$total_real_sale_price						+= $sales['result_price'];
			$data['tot_org_price']						= $data['org_price'] * $data['ea'];
			$data['tot_sale_price']						= $sales['total_sale_price'];
			$data['tot_result_price']					= $sales['result_price'];
			if	($sales['title_list'])foreach($sales['title_list'] as $sale_type => $tmptitle){
				$optsalelist[$sale_type]						= $sales['sale_list'][$sale_type];
				$moptsalelist[$sale_type]						= $sales['sale_list'][$sale_type];
				$cart['total_sale_list'][$sale_type]['title']	= $sale_title;
				$cart['total_sale_list'][$sale_type]['price']	+= $sales['sale_list'][$sale_type];
				if($sale_type=="ordersheet"){	// 주문서쿠폰의 경우 쿠폰에 강제 합산
					$cart['total_sale_list']['coupon']['price']	+= $sales['sale_list'][$sale_type];
				}
			}

			$this->ci->sale->reset_init();
			//<---- sale library 적용

			// 구매적립(마일리지 제한 조건 설정에 따른 분기)
			$reserve_policy_log = '';
			$new_opt_price = 0; // 마일리지 계산용 변수
			if ($cfg_reserve['default_reserve_limit']==3 && $this->gl_post_params['emoney'] > 0) {

				/* 적립 제한 조건 B설정 추가 leewh 2014-07-04 */
				$each_using_reserve = 0;

				// 필수 옵션 1개 사용마일리지 계산
				$each_using_reserve = $this->ci->goodsmodel->get_reserve_standard_pay($opt_price, $data['ea'], $cal_total_real_sale_price, $tot_using_reserve);

				$new_opt_price = $opt_price - $each_using_reserve;
				$reserve_policy_log	.= sprintf('[제한조건B (실결제금액-사용마일리지 : %s)]', get_currency_price($new_opt_price));
			} else {
				// 마일리지 계산용 가격 분리 leewh 2014-07-09
				$new_opt_price = $opt_price;
			}

			// 포인트
			$data['point']		= $this->ci->goodsmodel->get_point_with_policy($opt_price);
			$data['reserve']	= $this->ci->goodsmodel->get_reserve_with_policy($data['reserve_policy'], $new_opt_price, $cfg_reserve['default_reserve_percent'], $data['reserve_rate'], $data['reserve_unit'], $data['reserve']);

			// 마일리지 설정 B일때 마일리지을 사용한 경우 상품마일리지 won(원) 단위 환산하여 지급 2015-04-02
			if ($cfg_reserve['default_reserve_limit'] == 3 && $this->gl_post_params['emoney'] > 0) {
				if ($new_opt_price < 1) { // 결제금액 0원 일경우 마일리지 0원 처리
					$data['reserve'] = 0;
				} else if($data['reserve_unit'] != 'percent') {
					$data['reserve'] = get_currency_price(($data['reserve']/$data['price'])*$new_opt_price);
				}
			}

			// 비회원 마일리지/포인트 제거
			if	(!($member_seq > 0)){
				$data['fb_reserve']			= 0;
				$data['fb_point']			= 0;
				$data['mobile_reserve']		= 0;
				$data['mobile_point']		= 0;
				$data['member_point']		= 0;
				$data['member_reserve']		= 0;
				$data['point_one']			= 0;
				$data['reserve_one']		= 0;
				$data['point']				= 0;
				$data['reserve']			= 0;
			}

			// 마일리지,포인트 로그
			$log = '';
			if	( $reserve_policy_log )	$log	.= $reserve_policy_log;
			if( $data['reserve'] > 0 ) $log .= ($log?' / ':'').'구매  : '.(is_numeric($data['reserve'])?get_currency_price($data['reserve']):$data['reserve']);
			if( $data['event_reserve'] > 0 ) $log .= ($log?' / ':'').'이벤트  : '.(is_numeric($data['event_reserve'])?get_currency_price($data['event_reserve']):$data['event_reserve']);
			if( $data['member_reserve'] > 0 ) $log .= ($log?' / ':'').'회원  : '.(is_numeric($data['member_reserve'])?get_currency_price($data['member_reserve']):$data['member_reserve']);
			if( $data['fb_reserve'] > 0 ) $log .= ($log?' / ':'').'좋아요  : '.(is_numeric($data['fb_reserve'])?get_currency_price($data['fb_reserve']):$data['fb_reserve']);
			if( $data['mobile_reserve'] > 0 ) $log .= ($log?' / ':'').'모바일  : '.(is_numeric($data['mobile_reserve'])?get_currency_price($data['mobile_reserve']):$data['mobile_reserve']);
			$data['reserve_log'] = $log;
			$log = '';
			if( $data['point'] > 0 ) $log .= ($log?' / ':'').'구매  : '.(is_numeric($data['point'])?get_currency_price($data['point']):$data['point']);
			if( $data['event_point'] > 0 ) $log .= ($log?' / ':'').'이벤트  : '.(is_numeric($data['event_point'])?get_currency_price($data['event_point']):$data['event_point']);
			if( $data['member_point'] > 0 ) $log .= ($log?' / ':'').'회원  : '.(is_numeric($data['member_point'])?get_currency_price($data['member_point']):$data['member_point']);
			if( $data['fb_point'] > 0 ) $log .= ($log?' / ':'').'좋아요  : '.(is_numeric($data['fb_point'])?get_currency_price($data['fb_point']):$data['fb_point']);
			if( $data['mobile_point'] > 0 ) $log .= ($log?' / ':'').'모바일  : '.(is_numeric($data['mobile_point'])?get_currency_price($data['mobile_point']):$data['mobile_point']);
			$data['point_log'] = $log;

			// 옵션의 마일리지 포인트
			$data['reserve_one']	= get_cutting_price($data['reserve'])
									+ get_cutting_price($data['event_reserve'])
									+ get_cutting_price($data['member_reserve'])
									+ get_cutting_price($data['fb_reserve'])
									+ get_cutting_price($data['mobile_reserve']);
			$data['point_one']		= get_cutting_price($data['point'])
									+ get_cutting_price($data['event_point'])
									+ get_cutting_price($data['member_point'])
									+ get_cutting_price($data['fb_point'])
									+ get_cutting_price($data['mobile_point']);

			/* 구매 시 마일리지액 제한 조건 추가 leewh 2014-06-25 */
			$reserve_policy_log = '';
			if ($cfg_reserve['default_reserve_limit']==1 && $this->gl_post_params['emoney'] > 0) {
				$data['reserve_one'] = 0;
				$reserve_policy_log	.= '[제한조건D 지급 마일리지 : 0]';
			} else if ($cfg_reserve['default_reserve_limit']==2 && $this->gl_post_params['emoney'] > 0) {
				$minus_reserve = 0;
				$reserve_subtract = $appointed_reserve - $this->gl_post_params['emoney'];

				if ($reserve_subtract > 0) {
					/* 필수 옵션 차감할 1개 사용 마일리지 계산 */
					$minus_reserve = $this->ci->goodsmodel->get_reserve_limit($data['reserve_one']*$data['ea'], $data['ea'], $appointed_reserve, $this->gl_post_params['emoney']);
					$data['reserve_one'] = $data['reserve_one'] - $minus_reserve;
				} else {
					$minus_reserve = $this->gl_post_params['emoney'];
					$data['reserve_one'] = 0;  //전액 사용으로 지급안함.
				}
				$reserve_policy_log .= sprintf("[제한조건C 지급 마일리지 : %s]", get_currency_price($data['reserve_one']));
			}

			// 마일리지 정책 A 가 아닐경우 정책명을 제일 앞에 표시
			if ($data['reserve_log'] && $reserve_policy_log) $data['reserve_log'] = $reserve_policy_log." / ".$data['reserve_log'];

			$data['tot_reserve']						= $data['reserve_one'] * $data['ea'];
			$data['tot_point']							= $data['point_one'] * $data['ea'];
			$data['option_suboption_price_sum']			= $data['sale_price'] * $data['ea'];
			$data['option_suboption_price_sum_origin']	= $data['price'] * $data['ea'];

			// 추가구성옵션 계산
			if($data['cart_suboptions']){
				foreach($data['cart_suboptions'] as $k => $cart_suboption){

					//----> sale library 적용
					unset($param, $sales, $subsalelist);
					$param['option_type']			= 'suboption';
					$param['sub_sale']				= $cart_suboption['sub_sale'];
					$param['consumer_price']		= $cart_suboption['consumer_price'];
					$param['price']					= $cart_suboption['price'];
					$param['sale_price']			= $cart_suboption['price'];
					$param['ea']					= $cart_suboption['ea'];
					$param['category_code']			= $category;
					$param['goods_seq']				= $data['goods_seq'];
					$param['goods']					= $data;
					$this->ci->sale->set_init($param);
					$sales	= $this->ci->sale->calculate_sale_price($applypage);

					$cart_suboption['org_price']				= ($cart_suboption['consumer_price']) ? $cart_suboption['consumer_price'] : $cart_suboption['price'];
					if	(!$param['sale_price']){
						$cart_suboption['original_price']		= $sales['one_sale_list']['original'];
						$cart_suboption['basic_sale']			= $sales['one_sale_list']['basic'];
					}
					$cart_suboption['event_sale_target']	= ($sales['target_list']['event'] == 1) ? 'consumer_price' : 'price';
					$cart_suboption['event_sale']			= $sales['sale_list']['event'];
					$cart_suboption['multi_sale']			= $sales['sale_list']['multi'];

					$cart_suboption['event_sale_unit']		= $sales['one_sale_list']['event'];//이벤트할인(개당)
					$cart_suboption['multi_sale_unit']		= $sales['one_sale_list']['multi'];//복수구매할인(개당)

					$cart_suboption['member_sale']		= $sales['sale_list']['member'];
					$cart_suboption['member_sale_unit']	= $sales['one_sale_list']['member'];
					$cart_suboption['member_sale_rest']	= $cart_suboption['member_sale']-($cart_suboption['member_sale_unit']*$cart_suboption['ea']);//등급할인-짜투리
					$member_sale						+= $cart_suboption['member_sale'];
					$cart_suboption['member_reserve']	= $sales['one_reserve_list']['member'];
					$cart_suboption['member_point']		= $sales['one_point_list']['member'];
					$sale_suboption_price				= $sales['one_result_price'];
					$cart_suboption['sale_price']		= $sales['one_result_price'];
					$total_sale_suboption				+= $cart_suboption['member_sale'];
					$subsaletotalprice					= $sales['total_sale_price'];
					$data['tot_org_price']				+= $cart_suboption['org_price'] * $cart_suboption['ea'];
					$data['tot_sale_price']				+= $sales['total_sale_price'];
					$data['tot_result_price']			+= $sales['result_price'];

					if	($sales['title_list'])foreach($sales['title_list'] as $sale_type => $tmptitle){
						$subsalelist[$sale_type]						= $sales['sale_list'][$sale_type];
						$moptsalelist[$sale_type]						+= $sales['sale_list'][$sale_type];
						$cart['total_sale_list'][$sale_type]['title']	= $sale_title;
						$cart['total_sale_list'][$sale_type]['price']	+= $sales['sale_list'][$sale_type];
						if($sale_type=="ordersheet"){	// 주문서쿠폰의 경우 쿠폰에 강제 합산
							$cart['total_sale_list']['coupon']['price']	+= $sales['sale_list'][$sale_type];
						}
					}
					$this->ci->sale->reset_init();
					//<---- sale library 적용

					/* $cart_suboption['reserve'] 초기 값이 구매수량이 곱해진 총마일리지가 전달됨.
					추가옵션 상품 1개 기준으로 상품 마일리지 재계산 2015-03-27 leewh */
					$cart_suboption['reserve']	= $this->ci->goodsmodel->get_reserve_with_policy($data['sub_reserve_policy'],$sale_suboption_price,$cfg_reserve['default_reserve_percent'],$cart_suboption['reserve_rate'],$cart_suboption['reserve_unit'],$cart_suboption['reserve']);

					$cart_suboption['reserve'] = get_currency_price($cart_suboption['reserve']);
					// 구매마일리지(마일리지 제한 조건 설정에 따른 분기)
					$reserve_policy_log = '';
					$new_sale_suboption_price = 0; //추가옵션 마일리지 계산용 변수
					if ($cfg_reserve['default_reserve_limit']==3 && $this->gl_post_params['emoney'] > 0) {

						/* 적립 제한 조건 B설정 추가 leewh 2014-07-04 */
						$each_sub_using_reserve = 0;

						// 서브옵션 1개 사용마일리지 계산
						$each_sub_using_reserve = $this->ci->goodsmodel->get_reserve_standard_pay($sale_suboption_price, $cart_suboption['ea'], $cal_total_real_sale_price, $tot_using_reserve);

						$new_sale_suboption_price = $sale_suboption_price - $each_sub_using_reserve;
						$reserve_policy_log .= sprintf('[제한조건B (실결제금액-사용마일리지 : %s)]', get_currency_price($new_sale_suboption_price));
					} else {
						// 마일리지 계산용 가격 분리 leewh 2014-07-09
						$new_sale_suboption_price = $sale_suboption_price;
					}

					// 서브옵션 마일리지 및 포인트
					$cart_suboption['point']	= $this->ci->goodsmodel->get_point_with_policy($sale_suboption_price);
					$cart_suboption['reserve']	= $this->ci->goodsmodel->get_reserve_with_policy($data['sub_reserve_policy'], $new_sale_suboption_price, $cfg_reserve['default_reserve_percent'], $cart_suboption['reserve_rate'], $cart_suboption['reserve_unit'], $cart_suboption['reserve']);

					// 마일리지 설정 B일때 마일리지을 사용한 경우 상품마일리지 won(원) 단위 환산하여 지급 2015-04-02
					if ($cfg_reserve['default_reserve_limit'] == 3 && $this->gl_post_params['emoney'] > 0) {
						if	($new_sale_suboption_price < 1) { // 결제금액 0원 일경우 마일리지 0원 처리
							$cart_suboption['reserve']	= 0;
						} else if($cart_suboption['reserve_unit'] != "percent") {
							$cart_suboption['reserve'] = get_cutting_price(($cart_suboption['reserve'] / $cart_suboption['price']) * $new_sale_suboption_price);
						}
					}

					// 비회원 마일리지/포인트 제거
					if	(!($member_seq > 0)){
						$cart_suboption['member_point']		= 0;
						$cart_suboption['member_reserve']	= 0;
						$cart_suboption['point_one']		= 0;
						$cart_suboption['reserve_one']		= 0;
						$cart_suboption['point']			= 0;
						$cart_suboption['reserve']			= 0;
					}

					// 추가옵션 마일리지, 포인트 로그
					$log = '';
					if ($reserve_policy_log)	$log .= $reserve_policy_log;
					if ($cart_suboption['reserve'] > 0)	$log .= sprintf("%s구매 : %s", ($log?' / ':''), get_currency_price($cart_suboption['reserve']));
					if ($cart_suboption['member_reserve'] > 0) $log .= sprintf("%s회원 : %s", ($log?' / ':''), get_currency_price($cart_suboption['member_reserve']));
					$cart_suboption['reserve_log'] = $log;

					$log = '';
					if ($cart_suboption['point'] > 0)	$log .= sprintf("%s구매 : %s", ($log?' / ':''), get_currency_price($cart_suboption['point']));
					if ($cart_suboption['member_point'] > 0) $log .= sprintf("%s회원 : %s", ($log?' / ':''), get_currency_price($cart_suboption['member_point']));
					$cart_suboption['point_log'] = $log;

					// 서브 옵션용 마일리지, 포인트 개별 합계 2015-03-27
					$cart_suboption['reserve_one']	= get_cutting_price($cart_suboption['reserve']) +  get_cutting_price($cart_suboption['member_reserve']);
					$cart_suboption['point_one']	=  get_cutting_price($cart_suboption['point']) +  get_cutting_price($cart_suboption['member_point']);

					/* 구매 시 마일리지액 제한 조건 추가 leewh 2014-06-25 */
					$reserve_policy_log = '';
					if ($cfg_reserve['default_reserve_limit']==1 && $this->gl_post_params['emoney'] > 0) {
						$cart_suboption['reserve_one'] = 0;
						$reserve_policy_log	.= '[제한조건D 지급 마일리지 : 0]';
					} else if ($cfg_reserve['default_reserve_limit']==2 && $this->gl_post_params['emoney'] > 0) {
						$minus_sub_reserve = 0;
						$reserve_sub_subtract = $appointed_reserve - $this->gl_post_params['emoney'];

						if ($reserve_sub_subtract > 0) {
							/* 서브옵션 차감할 1개 사용 마일리지 계산 */
							$tmp_tot_reserve = $cart_suboption['reserve_one'] * $cart_suboption['ea'];
							$minus_sub_reserve = $this->ci->goodsmodel->get_reserve_limit($tmp_tot_reserve, $cart_suboption['ea'], $appointed_reserve, $this->gl_post_params['emoney']);
							$cart_suboption['reserve_one'] = $cart_suboption['reserve_one'] - $minus_sub_reserve;
						} else {
							$minus_sub_reserve = $this->gl_post_params['emoney'];
							$cart_suboption['reserve_one'] = 0; //전액 사용으로 지급안함.
						}
						$reserve_policy_log .= sprintf("[제한조건C 지급 마일리지 : %s]", get_currency_price($cart_suboption['reserve_one']));
					}

					// 마일리지 정책 A 가 아닐경우 정책명을 제일 앞에 표시
					if ($cart_suboption['reserve_log'] && $reserve_policy_log) $cart_suboption['reserve_log'] = $reserve_policy_log." / ".$cart_suboption['reserve_log'];

					$cart_suboption['reserve']	= $cart_suboption['reserve_one']*$cart_suboption['ea'];
					$total_reserve				+= $cart_suboption['reserve'];
					$cart_suboption['point']	= $cart_suboption['point_one'] * $cart_suboption['ea'];
					$total_point				+= $cart_suboption['point'];
					$total_real_sale_price		+= $cart_suboption['sale_price'] * $cart_suboption['ea'];

					$scripts[] = '$("span#suboption_reserve_'.$cart_suboption['cart_suboption_seq'].'",parent.document).html("'.get_currency_price($cart_suboption['reserve']).'");';
					$scripts[] = '$("span#suboption_point_'.$cart_suboption['cart_suboption_seq'].'",parent.document).html("'.get_currency_price($cart_suboption['point']).'");';
					$scripts[] = '$("span#member_sale_suboption_'.$cart_suboption['cart_suboption_seq'].'",parent.document).html("'.get_currency_price($cart_suboption['member_sale']).'");';
					$scripts[] = '$("span#cart_suboption_price_'.$cart_suboption['cart_suboption_seq'].'",parent.document).html("'.get_currency_price($sale_suboption_price*$cart_suboption['ea']).'");';

					if($cart_suboption['member_sale']){
						$scripts[] = '$("#suboption_member_sale_tr_'.$cart_suboption['cart_suboption_seq'].'",parent.document).show();';
						$scripts[] = '$("#sale_suboption_'.$cart_suboption['cart_suboption_seq'].'",parent.document).hide();';
					}else{
						$scripts[] = '$("#suboption_member_sale_tr_'.$cart_suboption['cart_suboption_seq'].'",parent.document).hide();';
						$scripts[] = '$("#sale_suboption_'.$cart_suboption['cart_suboption_seq'].'",parent.document).show();';
					}

					################# 2014-10-31 변경된 장바구니 모양으로 인해 추가
					// 추가구성옵션 전체 할인금액
					if	($subsaletotalprice > 0){
						$scripts[] = '$("#cart_suboption_sale_total_'.$cart_suboption['cart_suboption_seq'].'",parent.document).html("<span class=\"desc\">(-)</span> '.get_currency_price($subsaletotalprice,2).'");';
						$scripts[] = '$("#cart_suboption_sale_detail_'.$cart_suboption['cart_suboption_seq'].'",parent.document).show();';
					}else{
						$scripts[] = '$("#cart_suboption_sale_total_'.$cart_suboption['cart_suboption_seq'].'",parent.document).html("-");';
						$scripts[] = '$("#cart_suboption_sale_detail_'.$cart_suboption['cart_suboption_seq'].'",parent.document).hide();';
					}
					// 추가구성옵션 할인내역
					if	($subsalelist)foreach($subsalelist as $tmp_type => $tmp_price){
						if	($tmp_price > 0){
							$scripts[] = '$("#cart_suboption_'.$tmp_type.'_saletr_'.$cart_suboption['cart_suboption_seq'].'",parent.document).show();';
							$scripts[] = '$("span#cart_suboption_'.$tmp_type.'_saleprice_'.$cart_suboption['cart_suboption_seq'].'",parent.document).html("'.get_currency_price($tmp_price).'");';
						}else{
							$scripts[] = '$("#cart_suboption_'.$tmp_type.'_saletr_'.$cart_suboption['cart_suboption_seq'].'",parent.document).hide();';
							$scripts[] = '$("span#cart_suboption_'.$tmp_type.'_saleprice_'.$cart_suboption['cart_suboption_seq'].'",parent.document).html(0);';
						}
					}
					################# 2014-10-31 변경된 장바구니 모양으로 인해 추가

					$data['cart_suboptions'][$k] = $cart_suboption;
					$data['option_suboption_price_sum'] += $cart_suboption['sale_price']*$cart_suboption['ea'];
					$data['option_suboption_price_sum_origin'] += $cart_suboption['price']*$cart_suboption['ea'];

					# 과세/비과세별 상품 판매액
					$tax_price[$data['tax']]['price'] += $cart_suboption['sale_price'];
				}
			}

			$data['cart_sale'] = $data['event_sale'] + $data['multi_sale'] + $data['member_sale'] + $data['mobile_sale'] + $data['fblike_sale'] + $data['promotion_code_sale'] + $data['coupon_sale'] + $data['referer_sale'] + $data['unit_ordersheet'];

			################# 2014-10-31 변경된 장바구니 모양으로 인해 추가

			// 필수옵션 할인내역
			if	($optsalelist){
				$tmp_price_sum	= 0;
				foreach($optsalelist as $tmp_type => $tmp_price){
					if	($tmp_price > 0){
						$tmp_price_sum	+= $tmp_price;
						$scripts[]		= '$("#cart_option_'.$tmp_type.'_saletr_'.$data['cart_option_seq'].'",parent.document).show();';
						$scripts[]		= '$("span#cart_option_'.$tmp_type.'_saleprice_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($tmp_price).'");';
					}else{
						$scripts[]		= '$("#cart_option_'.$tmp_type.'_saletr_'.$data['cart_option_seq'].'",parent.document).hide();';
						$scripts[]		= '$("span#cart_option_'.$tmp_type.'_saleprice_'.$data['cart_option_seq'].'",parent.document).html(0);';
					}
				}
				if	($tmp_price_sum > 0){
					$scripts[]		= '$("#cart_option_sale_detail_'.$data['cart_option_seq'].'", parent.document).show();';
					$scripts[]		= '$("#cart_option_sale_total_'.$data['cart_option_seq'].'_2", parent.document).html(" '.get_currency_price($tmp_price_sum,2).'");';
				}else{
					$scripts[]		= '$("#cart_option_sale_detail_'.$data['cart_option_seq'].'", parent.document).hide();';
					$scripts[]		= '$("#cart_option_sale_total_'.$data['cart_option_seq'].'", parent.document).html("-");';
					$scripts[]		= '$("#cart_option_sale_total_'.$data['cart_option_seq'].'_2", parent.document).html("-");';
				}
			}
			// 필수옵션+추가구성옵션 할인내역
			if	($moptsalelist){
			    $mtmp_price_sum	= 0;
				foreach($moptsalelist as $tmp_type => $tmp_price){
					if	($tmp_price > 0){
					    $mtmp_price_sum	+= $tmp_price;
						$scripts[]		= '$("#cart_sum_'.$tmp_type.'_saletr_'.$data['cart_option_seq'].'",parent.document).show();';
						$scripts[]		= '$("span#cart_sum_'.$tmp_type.'_saleprice_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($tmp_price).'");';
					}else{
						$scripts[]		 = '$("#cart_sum_'.$tmp_type.'_saletr_'.$data['cart_option_seq'].'",parent.document).hide();';
						$scripts[]		= '$("span#cart_sum_'.$tmp_type.'_saleprice_'.$data['cart_option_seq'].'",parent.document).html(0);';
					}
				}
				if	($mtmp_price_sum > 0){
					$scripts[]		= '$("#cart_sum_sale_tr_'.$data['cart_option_seq'].'", parent.document).show();';
					$scripts[]		= '$("span#cart_sum_sale_'.$data['cart_option_seq'].'", parent.document).html("'.get_currency_price($mtmp_price_sum).'");';
				}else{
					$scripts[]		= '$("#cart_sum_sale_tr_'.$data['cart_option_seq'].'", parent.document).hide();';
					$scripts[]		= '$("span#cart_sum_sale_'.$data['cart_option_seq'].'", parent.document).html("0");';
				}
			}
			
			// 반응형 스킨일 경우 필수옵션+추가구성옵션 할인금액으로 적용
			if($this->operation_type === 'light') {
			    if	($mtmp_price_sum > 0){
			        $scripts[]		= '$("#cart_option_sale_total_'.$data['cart_option_seq'].'", parent.document).html("<span class=\"desc\">(-)</span> '.get_currency_price($mtmp_price_sum,2).'");';
			    }
			} else { // 전용 스킨일 경우 필수옵션 할인금액으로 적용
			    if	($tmp_price_sum > 0){
			        $scripts[]		= '$("#cart_option_sale_total_'.$data['cart_option_seq'].'", parent.document).html("<span class=\"desc\">(-)</span> '.get_currency_price($tmp_price_sum,2).'");';
			    }
			}

			$scripts[] = '$("span.cart_option_price_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['sale_price']*$data['ea']).'");';

			################# 2014-10-31 변경된 장바구니 모양으로 인해 추가



			if( $this->ci->_is_mobile_agent) {//mobile 인 경우에만적용 $this->ci->mobileMode ||
				$scripts[] = '$("#mobile_sale_tr_'.$data['cart_option_seq'].'",parent.document).show();';
				$scripts[] = '$("span#mobile_sale_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['mobile_sale']).'");';
			}
			$scripts[] = '$("span#cart_option_price_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['sale_price']*$data['ea']).'");';

			$scripts[] = '$("span#cart_origin_price_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['price']).'");';

			if($data['fblike_sale']){
				$scripts[] = '$("#fblike_sale_tr_'.$data['cart_option_seq'].'",parent.document).show();';
				$scripts[] = '$("span#fblike_sale_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['fblike_sale']).'");';
			}else{
				$scripts[] = '$("#fblike_sale_tr_'.$data['cart_option_seq'].'",parent.document).hide();';
			}

			if($data['promotion_code_sale']){
				$scripts[] = '$("#promotioncode_sale_tr_'.$data['cart_option_seq'].'",parent.document).show();';
				$scripts[] = '$("span#promotioncode_sale_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['promotion_code_sale']).'");';
			}else{
				$scripts[] = '$("#promotioncode_sale_tr_'.$data['cart_option_seq'].'",parent.document).hide();';
			}
			if($data['coupon_sale']){
				$scripts[] = '$("#coupon_sale_tr_'.$data['cart_option_seq'].'",parent.document).show();';
				$scripts[] = '$("span#coupon_sale_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['coupon_sale']).'");';
			}else{
				$scripts[] = '$("#coupon_sale_tr_'.$data['cart_option_seq'].'",parent.document).hide();';
			}
			if($data['member_sale']){
				$scripts[] = '$("#option_member_sale_tr_'.$data['cart_option_seq'].'",parent.document).show();';
				$scripts[] = '$("span#member_sale_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['member_sale']).'");';
			}else{
				$scripts[] = '$("#option_member_sale_tr_'.$data['cart_option_seq'].'",parent.document).hide();';
			}
			if($data['referer_sale']){
				$scripts[] = '$("#referer_sale_tr_'.$data['cart_option_seq'].'",parent.document).show();';
				$scripts[] = '$("span#referer_sale_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['referer_sale']).'");';
			}else{
				$scripts[] = '$("#referer_sale_tr_'.$data['cart_option_seq'].'",parent.document).hide();';
			}

			if($data['cart_sale']) $scripts[] = '$("#cart_sale_tr_'.$data['cart_option_seq'].'",parent.document).show();';
			$scripts[] = '$("span#cart_sale_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['cart_sale']).'");';

			$scripts[] = '$("span#option_reserve_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['tot_reserve']).'");';
			$scripts[] = '$("span#option_point_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['tot_point']).'");';

			if($data['cart_sale']){
				$scripts[] = '$("#sale_option_'.$data['cart_option_seq'].'",parent.document).hide();';
			}else{
				$scripts[] = '$("#sale_option_'.$data['cart_option_seq'].'",parent.document).show();';
			}

			$scripts[] = '$("span#option_suboption_price_sum_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['option_suboption_price_sum']).'");';

			$scripts[] = '$("span#option_suboption_price_sum_origin_'.$data['cart_option_seq'].'",parent.document).html("'.get_currency_price($data['option_suboption_price_sum_origin']).'");';

			// 상품 무게 계산
			if( $data['shipping_weight_policy'] == "shop" ){
				$goods_weight = $data['goods_weight'] + $international_shipping['defaultGoodsWeight'];
			}else{
				$goods_weight = $data['goods_weight'];
			}

			//$data['goods_weight']	= $goods_weight * $data['ea'];
			$data['goods_weight']	= $goods_weight;
			$cart['list'][$key]		= $data;
			// 입점사별 상품 무게 합산
			$this->ci->provider_goods_weight[$data['provider_seq']] += $data['goods_weight'];

			$total_sales_price			+= get_cutting_price($data['tot_sale_price']);
			$total_mobile_sale			+= get_cutting_price($data['mobile_sale']);
			$total_fblike_sale			+= get_cutting_price($data['fblike_sale']);
			$total_promotion_code_sale	+= get_cutting_price($data['promotion_code_sale']);
			$total_coupon_sale			+= get_cutting_price($data['coupon_sale']);
			$total_member_sale			+= get_cutting_price($data['member_sale']);
			$total_referer_sale			+= get_cutting_price($data['referer_sale']);
			$total_reserve				+= $data['tot_reserve'];
			$total_point				+= $data['tot_point'];
			$total_sale_price			+= $data['cart_sale'];
			$total_goods_weight			+= $data['goods_weight'];

			# 과세/비과세별 상품 판매액/배송비
			$tax_price[$data['tax']]['price']	+= $data['sale_price'];

			$provider_cart[$data['shipping_group']]['provider_price']	+= $data['tot_price'];
			$provider_cart[$data['shipping_group']]['cart_list'][]	= $data;

			// 배송그룹별 상품할인가 합
			$shipping_group_sum_goods_price[$data['shipping_group']] += $data['tot_price'] - $data['cart_sale'];
		}

		// 관리자 주문일 경우 해외배송여부처리
		if( $adminOrder == 'admin' && $is_international_shipping ){
			$scripts[] = '$(".clearance_unique_personal_code",parent.document).show();';
		}elseif( $adminOrder == 'admin' && !$is_international_shipping ){
			$scripts[] = '$(".clearance_unique_personal_code",parent.document).hide();';
		}
		if( $adminOrderType == 'person' && !$is_international_shipping ){
			$scripts[] = '$(".clearance_unique_personal_code",parent.document).hide();';
		}

		if( is_array($coupon_same_time_n) && count($coupon_same_time_n) > 0 ){//단독쿠폰체크
			if( count($coupon_same_time_n) != 1 || ( count($coupon_same_time_n) > 0 && count($coupon_same_time_y) > 0) ) {
				//단독쿠폰은 다른쿠폰과 동시에 사용하실 수 없습니다. <br/>쿠폰을 다시한번 선택해 주세요.
				$err_coupon = getAlert('os011');
				$err_coupon_callback = 'parent.sametime_coupon_dialog();'.$pg_cancel_script;
				openDialogAlert($err_coupon,400,140,'parent',$err_coupon_callback);
				$this->call_exit();
			}elseif( count($coupon_same_time_n) == 1 && $coupon_same_time_n_duplication_n && $coupon_same_time_n_duplication_n[$coupon_same_time_n[0]] > 1 ) {//단독이면서 중복쿠폰이 아닌경우
				//해당 단독쿠폰은 중복으로 사용하실 수 없습니다. <br/>다시한번 선택해 주세요.
				$err_coupon = getAlert('os012');
				$err_coupon_callback = 'parent.sametime_coupon_dialog();'.$pg_cancel_script;
				openDialogAlert($err_coupon,400,140,'parent',$err_coupon_callback);
				$this->call_exit();
			}
		}

		$total_sale_price					+= $total_sale_suboption;
		$cart['total_mobile_sale']			= $total_mobile_sale;
		$cart['total_fblike_sale']			= $total_fblike_sale;
		$cart['total_promotion_code_sale']	= $total_promotion_code_sale;
		$cart['total_coupon_sale']			= $total_coupon_sale;
		$cart['total_member_sale']			= $total_member_sale;
		$cart['total_referer_sale']			= $total_referer_sale;
		$cart['total_reserve']				= $total_reserve;
		$cart['total_real_sale_price']		= $total_real_sale_price; //총실결제금액합계@2014-07-04
		$cart['total_point']				= $total_point;
		$cart['total_sale_price']			= $total_sale_price;
		$cart['total_goods_weight']			= $total_goods_weight;

		// 할인적용가 기준 배송비 계산
		$total_goods_price = $cart['total'] - $cart['total_sale_price'];
		if($cart['shop_shipping_policy']['free']){
			$cart['shipping_price']['shop'] = get_cutting_price($cart['shop_shipping_policy']['price']);
			if($cart['shop_shipping_policy']['free'] <= $total_goods_price){
				$cart['shipping_price']['shop'] = 0;
			}
		}

		### WONY ------- 배송비 계산 및 this 저장--------- ### shipping library 계산 - calculator

		// ### Mobile 예외처리 :: 2017-08-10 lwh
		if($this->ci->mobileMode){
			$this->gl_post_params['recipient_address_street']	= ($this->gl_post_params['recipient_input_address_street']) ? $this->gl_post_params['recipient_input_address_street'] : $this->gl_post_params['recipient_address_street'];
			$this->gl_post_params['recipient_address']			= ($this->gl_post_params['recipient_input_address']) ? $this->gl_post_params['recipient_input_address'] : $this->gl_post_params['recipient_address'];
			$this->gl_post_params['recipient_address_detail']	= ($this->gl_post_params['recipient_input_address_detail']) ? $this->gl_post_params['recipient_input_address_detail'] : $this->gl_post_params['recipient_address_detail'];
		}

		// ### NEW 배송 그룹 정보 추출 ### :: START ### ----------- 여기서부터
		$this->ci->load->library('shipping');
		if		($this->gl_post_params['address_nation'])	$ship_ini['nation']	= $this->gl_post_params['address_nation'];
		if		($this->gl_post_params['recipient_address_street']) // 주소값 지정
			$ship_ini['street_address']	= $this->gl_post_params['recipient_address_street'];
		if		($this->gl_post_params['recipient_address'])
			$ship_ini['zibun_address']	= $this->gl_post_params['recipient_address'];
		$ini_info				= $this->ci->shipping->set_ini($ship_ini);
		$shipping_group_list	= $this->ci->shipping->get_shipping_groupping($cart['list'], $mode);

		// 상세 배송비 금액 추출
		$shipping_cost_detail	= $shipping_group_list['shipping_cost_detail'];
		unset($shipping_group_list['shipping_cost_detail']);

		// 전체 배송비 금액 추출
		$total_shipping_price	= $shipping_group_list['total_shipping_price'];
		unset($shipping_group_list['total_shipping_price']);

		// 최종 결제 금액 재계산
		$cart['total_price'] = $cart['total_price'] + $total_shipping_price;

		// 배송가능 해외국가 추출
		$ship_gl_arr	= $this->ci->shippingmodel->get_gl_shipping();
		$ship_gl_list	= $this->ci->shippingmodel->split_nation_str($ship_gl_arr);

		// 배송결과 Parent 에 Return :: START
		$ship_possible			= true;
		$ship_region_possible	= true;

		foreach($shipping_group_list as $shipKey => $shipinfo){
			$scripts[] = '$(".grp_shipping_'.$shipKey.'",parent.document).find(".shipper_name").html("'.$shipinfo['shipper_name'].'");';
			$scripts[] = '$(".grp_shipping_'.$shipKey.'",parent.document).find(".shipping_set_name").html("'.$shipinfo['cfg']['baserule']['shipping_set_name'].'");';
			if	($shipinfo['grp_shipping_price'] > 0 && $shipinfo['ship_possible'] == 'Y'){
				$scripts[] = '$(".grp_shipping_price_'.$shipKey.'",parent.document).removeClass("red");';
				$scripts[] = '$(".grp_shipping_price_'.$shipKey.'",parent.document).html("'.get_currency_price($shipinfo['grp_shipping_price'],2).'");';
				$altInfo = ''.getAlert("os239").': ' . get_currency_price($shipinfo['shipping_std_cost'],2);    // 기본배송비
				$altInfo .= '<br/>'.getAlert("os240").': ' . get_currency_price($shipinfo['shipping_add_cost'],2);  // 추가배송비
				$altInfo .= '<br/>'.getAlert("os247").': ' . get_currency_price($shipinfo['shipping_hop_cost'],2);  // 희망배송비

				$scripts[] = '$(".prepay_info",parent.document).show();';

				// 총 배송비 계산 :: 2017-09-28 lwh
				$ship_price[$shipinfo['shipping_prepay_info']]['total'] += $shipinfo['grp_shipping_price'];
				$ship_price[$shipinfo['shipping_prepay_info']]['std'] += $shipinfo['shipping_std_cost'];
				$ship_price[$shipinfo['shipping_prepay_info']]['add'] += $shipinfo['shipping_add_cost'];
				$ship_price[$shipinfo['shipping_prepay_info']]['hop'] += $shipinfo['shipping_hop_cost'];
			}else{
				if			($shipinfo['ship_possible'] == 'Y') {
					$scripts[] = '$(".grp_shipping_price_'.$shipKey.'",parent.document).removeClass("red");';
					if($shipinfo['cfg']['baserule']['shipping_set_code'] == 'coupon'){
						$scripts[] = '$(".grp_shipping_price_'.$shipKey.'",parent.document).html("'.getAlert("os241").'");';    // 티켓발송
						$altInfo = ''.getAlert("os241").'';    // 티켓발송
					}else{
						$scripts[] = '$(".grp_shipping_price_'.$shipKey.'",parent.document).html("'.getAlert("os242").'");';    // 무료
						$altInfo = ''.getAlert("os243").'';    // 무료배송
					}
					$scripts[] = '$(".prepay_info",parent.document).hide();';
				}else if	($shipinfo['ship_possible'] == 'H') {
					$scripts[] = '$(".grp_shipping_price_'.$shipKey.'",parent.document).addClass("red");';
					$scripts[] = '$(".grp_shipping_price_'.$shipKey.'",parent.document).html("'.getAlert("os242").'");';    // 배송불가
					$altInfo = ''.getAlert("os243").''; // 배송 불가지역
					$ship_possible = false;
					$this->ci->ship_possible = "N";	//비회원 결제시 배송 제한 주소 확인 20170605 ldb
					$scripts[] = '$(".prepay_info",parent.document).hide();';
				}else{
					$scripts[] = '$(".grp_shipping_price_'.$shipKey.'",parent.document).addClass("red");';
					$scripts[] = '$(".grp_shipping_price_'.$shipKey.'",parent.document).html("'.getAlert("os242").'");';    // 배송불가
					$altInfo = ''.getAlert("os244").'';  // 희망배송일 배송 불가지역
					$ship_possible = false;
					$ship_region_possible	= false;
					$this->ci->ship_possible = "N";	//비회원 결제시 배송 제한 주소 확인 20170605 ldb
					$scripts[] = '$(".prepay_info",parent.document).hide();';
				}
			}

			// class의 손실로 인한 중복 변경 :: 2017-01-02 lwh
			$scripts[] = '$(".priceInfo_'.$shipKey.'",parent.document).html("'.$altInfo.'");';
			$scripts[] = '$(".grp_shipping_'.$shipKey.'",parent.document).find("div.layer_inner").html("'.$altInfo.'");';

			// 배송비 관련 Global 변수 재 가공 :: 2016-08-08 lwh
			$shipping_provider_seq = $shipinfo['cfg']['baserule']['shipping_provider_seq'];
			$this->ci->shipping_group_cost[$shipKey]['shop'] = $shipinfo['grp_shipping_price'];
			$this->ci->shipping_group_policy[$shipKey]['policy'] = 'shop';
			$this->ci->shipping_group_policy[$shipKey]['provider_seq'] = $shipping_provider_seq;
			$this->ci->shipping_group_policy[$shipKey]['shipping_cfg'] = $shipinfo;
			$this->ci->shipping_group_policy[$shipKey]['shipping_ini'] = $ship_ini;
			$this->ci->shipping_group_policy[$shipKey]['prepay_info'] = $shipinfo['shipping_prepay_info'];
			$this->ci->shipping_group_policy[$shipKey]['price'] = $shipinfo['grp_shipping_price'];

			$this->ci->provider_shipping_cost[$shipping_provider_seq] += (int) $shipinfo['grp_shipping_price'];

			// 쿠폰 관련 배송비 계산 추가 :: 2017-05-17 lwh
			$provider_cart[$shipKey]['grp_shipping_price'] = ($shipinfo['shipping_prepay_info'] == 'delivery') ? $shipinfo['grp_shipping_price'] : '0';
			$provider_cart[$shipKey]['shipping_provider_seq'] = $shipping_provider_seq;

			// 구) 배송비 수정관련 추가사항 :: START 2016-10-31 lwh
			$scripts[] = '$("#price_'.$shipKey.'",parent.document).html("' . get_currency_price($shipinfo['grp_shipping_price'],2) . '");';

			if($shipinfo['cfg']['baserule']['shipping_calcul_type'] == 'each'){
				$goods_delivery += $shipinfo['grp_shipping_price']; // 개별배송비
			}else{
				$basic_delivery += $shipinfo['grp_shipping_price']; // 기본배송비
			}
			// 구) 배송비 수정관련 추가사항 :: END
		}

		// 구) 배송비 수정관련 추가사항 :: START 2016-10-31 lwh
		$scripts[] = '$(".total_org_shipping_price",parent.document).html("' . get_currency_price($total_shipping_price) . '");';
		$scripts[]		= '$("span.goods_delivery", parent.document).html("'.get_currency_price($goods_delivery).'");';
		$scripts[]		= '$("span.basic_delivery", parent.document).html("'.get_currency_price($basic_delivery).'");';
		if($total_shipping_price < 1){
			$scripts[] = '$(".total_org_shipping_price_btn",parent.document).hide();';
		}
		// 구) 배송비 수정관련 추가사항 :: END

		// 배송 불가 항목 체크.
		if($ship_possible){
			$scripts[] = '$("#ship_possible",parent.document).val("Y");';
			$scripts[] = '$(".ship_possible",parent.document).addClass("hide");';
		}else{
			$scripts[] = '$("#ship_possible",parent.document).val("N");';
			$scripts[] = '$(".ship_possible",parent.document).removeClass("hide");';
			$total_shipping_price = 0;
			if(!$ship_region_possible){
				$scripts[] = '$(".kr_nation_region",parent.document).html(" - ' . getAlert('dv006') . '");';
			}
		}

		// 쿠폰 사용 후 배송비 변경 확인 :: 2017-07-11 lwh
		$scripts[] = 'var download_chk = 0;';
		$scripts[] = '$(".shippingcoupon_download_input",parent.document).each(function(){ download_chk += $(this).val();});';
		$scripts[] = 'download_chk += $("input[name=\'emoney_view\']",parent.document).val();';
		$scripts[] = 'download_chk += $("input[name=\'cash_view\']",parent.document).val();';
		$scripts[] = 'if(download_chk > 0 ){';
		$scripts[] = "var new_ship_price = '".number_format($total_shipping_price)."';";
		$scripts[] = 'var old_ship_price = $(".total_delivery_shipping_price",parent.document).html()||0;';
		$scripts[] = 'if(new_ship_price != old_ship_price) parent.reset_coupon();';
		$scripts[] = '}';

		// 상세 배송비 재정의 :: 2017-09-28 lwh
		foreach($ship_price as $prepay_info => $ship_detail){
			$scripts[] = '$(".'.$prepay_info.'_tot_price",parent.document).html("'.get_currency_price($ship_detail['total']).'");';
			$scripts[] = '$(".std_'.$prepay_info.'_price",parent.document).html("'.get_currency_price($ship_detail['std']).'");';
			$scripts[] = '$(".add_'.$prepay_info.'_price",parent.document).html("'.get_currency_price($ship_detail['add']).'");';
			$scripts[] = '$(".hop_'.$prepay_info.'_price",parent.document).html("'.get_currency_price($ship_detail['hop']).'");';
		}

		// 총 배송비
		$scripts[] = '$(".total_delivery_shipping_price",parent.document).html("'.get_currency_price($total_shipping_price).'");';
		$this->ci->shipping_cost = $total_shipping_price;

		// 배송국가 선택된 국기 img 변경
		$nation_img = "/admin/skin/default/images/common/icon/nation/".$ini_info['nation'].".png";
		$scripts[] = '$("#nation_img",parent.document).attr("src","'.$nation_img.'");';
		if($ini_info['nation'] == 'KOREA'){
			$scripts[] = '$("#nation_gl_type",parent.document).addClass("hide");';
		}else{
			$scripts[] = '$("#nation_gl_type",parent.document).removeClass("hide");';
		}
		// 배송결과 Parent 에 Return :: END
		// ### NEW 배송 그룹 정보 추출 및 계산 :: END ### ----------- 여기까지

		//프로모션코드 배송비할인2
		if($this->ci->session->userdata('cart_promotioncode_'.session_id())) {
			$shipping_promotions = $this->ci->promotionmodel->get_able_download_saleprice($this->ci->session->userdata('cart_promotioncodeseq_'.session_id()),$this->ci->session->userdata('cart_promotioncode_'.session_id()), $cart['total'], '','');
		}

		//프로모션코드 본사배송상품 배송비할인
		$this->ci->shipping_promotion_code_sale	= array();
		if($total_shipping_price > 0 && $shipping_promotions) {//본사배송상품
			foreach($this->ci->provider_shipping_cost as $provider_seq => $shipping_cost){

				//이벤트 배송비코드 사용제한 @2015-08-13
				if( $this->ci->ordernosales_cd_sh[$provider_seq] ) continue;

				$codesales_use		= 'N';
				$shippingcode_sale	= 0;
				if		(!$shipping_promotions['provider_list'] > 0 && $provider_seq == 1)
					$codesales_use	= 'A';
				elseif	($shipping_promotions['provider_list'] && strstr($shipping_promotions['provider_list'], '|'.$provider_seq.'|'))
					$codesales_use	= 'P';

				if		($codesales_use == 'A' || $codesales_use == 'P'){
					if($shipping_promotions['sale_type'] == 'shipping_free' &&  $shipping_cost > 0)		{
						$shippingcode_sale	= ($shipping_cost < $shipping_promotions['promotioncode_shipping_sale_max'])	? $shipping_cost : $shipping_promotions['promotioncode_shipping_sale_max'];
					}elseif($shipping_promotions['sale_type'] == 'shipping_won' && $shipping_cost > 0 && $shipping_cost >= $shipping_promotions['promotioncode_shipping_sale'])	{
						$shippingcode_sale	= $shipping_promotions['promotioncode_shipping_sale'];
					}

					if	($shippingcode_sale > 0){
						$this->ci->shipping_promotion_code_sale[$provider_seq]	= $shippingcode_sale;
						$this->ci->shipping_promotion_code_sale_provider[$provider_seq]	= $shipping_promotions['salescost_provider'];
						$this->ci->shipping_promotion_code_seq[$provider_seq]	= $shipping_promotions['promotion_seq'];
						$this->ci->shipping_cost								-= $shippingcode_sale;
						$total_shipping_price								-= $shippingcode_sale;

						$this->ci->shipping_promotion_code_salecost[$provider_seq]	= ($codesales_use == 'A')	? 0 : get_cutting_price($shippingcode_sale * ($shipping_promotions['salescost_provider']/100));
					}
				}
			}
		}

		//배송비쿠폰 할인
		if( $this->gl_post_params['shippingcoupon_download'] && $total_shipping_price > 0 ) {
			$this->ci->shipping_coupon_payment_b = false;
			$this->ci->shippingcoupon_download_ck = false;
			foreach($this->gl_post_params['shippingcoupon_download'] as $shipKey => $download_seq) {

				$provider_seq = $this->ci->shipping_group_policy[$shipKey]['provider_seq'];

				//이벤트 배송비쿠폰 사용제한 @2015-08-13
				if( $this->ci->ordernosales_cp_sh[$provider_seq] ) continue;

				$shippingcoupons = $this->ci->couponmodel->get_download_coupon($download_seq);
				if	($shippingcoupons){
					if	($shippingcoupons['shipping_type'] == 'free'){
						if	($shippingcoupons['max_percent_shipping_sale'] <= $this->ci->shipping_group_cost[$shipKey]['shop']){
							$shippingcoupon_sale	= $shippingcoupons['max_percent_shipping_sale'];
						}else{
							$shippingcoupon_sale	= $this->ci->shipping_group_cost[$shipKey]['shop'];
						}
					}else{
						if	($shippingcoupons['won_shipping_sale'] <= $this->ci->shipping_group_cost[$shipKey]['shop']){
							$shippingcoupon_sale	= $shippingcoupons['won_shipping_sale'];
						}
					}

					if($this->ci->shippingcoupon_download_ck === false && $this->ci->arr_goods_shipping_price >0 ) $this->ci->shippingcoupon_download_ck = true;

					if	($shippingcoupon_sale > 0) {

						//무통장만 사용가능
						if($shippingcoupons['sale_payment'] == 'b' && $this->ci->shipping_coupon_payment_b != true )
							$this->ci->shipping_coupon_payment_b = true;

						if( ( $shippingcoupons['type'] == 'memberGroup_shipping' || $shippingcoupons['type'] == 'member_shipping' || $shippingcoupons['type'] == 'memberlogin_shipping' || $shippingcoupons['type'] == 'membermonths_shipping' ) && $provider_seq == 1 ) {//배송그룹이 본사인경우 0
							$shippingcoupons['salescost_provider'] = 0;
						}
						$salescost										= get_cutting_price($shippingcoupon_sale * ($shippingcoupons['salescost_provider']/100));
						$total_shipping_price							-= $shippingcoupon_sale;
						$this->ci->shipping_cost							-= $shippingcoupon_sale;
						$this->ci->shipping_coupon_salecost[$shipKey]	= $salescost;
						$this->ci->shipping_coupon_sale[$shipKey]		= $shippingcoupon_sale;
						$this->ci->shipping_coupon_sale_provider[$shipKey]	= $shippingcoupons['salescost_provider'];
						$this->ci->shipping_coupon_down_seq[$shipKey]	= $download_seq;
					}
				}
			}
		}

		//배송비쿠폰은 개별배송비 상품이 있을 경우 제외안내
		if( !$this->ci->displaymode &&  $this->ci->shippingcoupon_download_ck === true && $this->gl_post_params['shippingcoupon_download'] ) {
			//배송비 쿠폰은 개별배송 상품에는 반영되지 않습니다.
			openDialogAlert(getAlert('os013'),400,140,'parent',$pg_cancel_script);
		}


		//쿠폰>사용제한>무통장만가능
		if( is_array($coupon_sale_payment_b) || $this->ci->shipping_coupon_payment_b ){
			$cart['coupon_sale_payment_b'] = count($coupon_sale_payment_b);
			if( $this->ci->shipping_coupon_payment_b === true ) $cart['coupon_sale_payment_b'] = (int) ($cart['coupon_sale_payment_b'] + 1);
		}

		if($cart['coupon_sale_payment_b']  && $this->gl_post_params['payment'] != 'bank' && !$this->ci->displaymode ) {
			//현재 무통장 전용 쿠폰을 사용하셨습니다.<br />결제수단을 무통장으로 변경해 주세요!
			openDialogAlert(getAlert('os014'),400,140,'parent',$pg_cancel_script);
			$this->call_exit();
		}

		//쿠폰>사용제한>모바일/테블릿기기만가능
		if( is_array($coupon_sale_agent_m)){
			$cart['coupon_sale_agent_m'] = count($coupon_sale_agent_m);
		}

		// 에누리
		if($person_seq != ""){
			$query	= $this->ci->db->query("select * from fm_person where person_seq='".$person_seq."'");
			$res	= $query->row_array();
			$enuri	= $res['enuri'];
		}elseif($adminOrder == "admin" && isset($this->gl_post_params['enuri']) && $this->gl_post_params['enuri'] > 0) {
			//#20282 2018-07-27 ycg 개인 결제 생성시 에누리 소수점 적용 안되는 문제 수정
			$enuri = get_cutting_price($this->gl_post_params['enuri']);
		}else{
			$enuri	= 0;
		}

		// enuri가 더 큰 경우 최대값으로 변경
		if	(($cart['total'] - $cart['total_sale_price'] + $total_shipping_price) < $enuri){
			$enuri	= $cart['total'] - $cart['total_sale_price'] + $total_shipping_price;
			echo '<script>
					$("input[name=\'enuri\']",parent.document).val("'.$enuri.'");
				</script>';
		}

		/* 총 결제금액 */
		$settle_price = $cart['total'] - $cart['total_sale_price'] + $total_shipping_price - $enuri;

		if($settle_price<0)$settle_price=0;


		/* 주문금액 */
		$this->ci->order_price = $cart['total'] + $total_shipping_price;

		/* 캐쉬 사용할 수 있는 금액 계산*/
		if( $members && ($this->gl_post_params['cash'] > 0 || $this->gl_post_params['cash_all']) ){
			$reserve_use = true;

			// 마일리지 전액사용
			if($this->gl_post_params['cash_all']){
				$this->gl_post_params['cash'] = $this->ci->ordermodel->get_usable_cash($cart['total'],$settle_price-$this->gl_post_params['emoney'],$members['cash']);
				if($this->gl_post_params['cash']){
					echo '<script>
					$("input[name=\'cash\']",parent.document).val("'.$this->gl_post_params['cash'].'");
					$("input[name=\'cash_view\']",parent.document).val("'.$this->gl_post_params['cash'].'");
					</script>';
				}else{
					$reserve_use = false;
					//예치금를 사용하실 수 없습니다.
					$err_reserve = getAlert('os015');
				}
			}

			if( $this->gl_post_params['cash'] > $settle_price ){
				$reserve_use = false;
				//"최대 ".number_format($settle_price)."원까지 사용가능 합니다."
				$err_reserve = getAlert('os016',get_currency_price($settle_price,2));
			}

			if( $this->gl_post_params['cash'] > $members['cash'] ){
				$reserve_use = false;
				//number_format( $members['cash'] )."원 이상 사용하실 수 없습니다."
				$err_reserve = getAlert('os017',get_currency_price( $members['cash'] ,2));
			}

			if(!$this->ci->displaymode){
				if($err_reserve){
					echo '<script>
					$("input[name=\'cash\']",parent.document).val(0);
					$("input[name=\'cash_view\']",parent.document).val(0);
					$("input[name=\'cash_all\']",parent.document).val("");
					$(".cash_cancel_button",parent.document).hide();
					$(".cash_input_button",parent.document).show();
					$(".cash_all_input_button",parent.document).show();
					</script>';
					openDialogAlert($err_reserve,400,140,'parent',$pg_cancel_script);
					$this->call_exit();
				}else{
					echo '<script>
					$("input[name=\'cash_all\']",parent.document).val("");
					</script>';
				}
				if($this->gl_post_params['cash'] > 0){
					echo '<script>
					$("#priceCashTd").show();
					$("#total_cash").html("'.get_currency_price($this->gl_post_params['cash']).'");
					</script>';
				}
			}
			$cart['cash'] = get_cutting_price($this->gl_post_params['cash']);
			$settle_price -= get_cutting_price($cart['cash']);
		}

		$err_reserve = '';
		if( $members && ($this->gl_post_params['emoney'] > 0 || $this->gl_post_params['emoney_all']) ){

			$reserve_use = true;
			$reserves = ($this->ci->reserves)?$this->ci->reserves:config_load('reserve');
			/**if(!$reserves) {//마일리지 미설정시 @2017-02-09
				$reserve_use = false;
				//마일리지을 사용하실 수 없습니다.
				$err_reserve = getAlert('os018');
			}**/

			// 마일리지 전액사용
			if($this->gl_post_params['emoney_all'] && $reserve_use===true){

				/* 마일리지 전액사용 클릭시 사용금액을 0원 처리할 경우 에러메세지를 받기 위해 리턴값을 배열로 받음 leewh 2014-11-12 */
				// 총금액이 아닌 할인적용 금액으로 제한 체크 함 2019-02-14 hyem
				$returnInfo = $this->ci->ordermodel->get_usable_emoney($cart['total']-$cart['total_sale_price'],$settle_price,$members['emoney']);
				$this->gl_post_params['emoney'] = $returnInfo['emoney'];

				if($this->gl_post_params['emoney']){
					echo '<script>
					$("input[name=\'emoney\']",parent.document).val("'.$this->gl_post_params['emoney'].'");
					$("input[name=\'emoney_view\']",parent.document).val("'.get_currency_price($this->gl_post_params['emoney']).'");
					</script>';
				}else{
					$reserve_use = false;
					if ($returnInfo['err_reserve']) {
						$err_reserve = $returnInfo['err_reserve'];
					} else {
						//마일리지을 사용하실 수 없습니다.
						$err_reserve = getAlert('os018');
					}
				}
			}

			/* 마일리지 사용 단위 ordermodel로 옮김 @2016-06-08 pjm */
			list($reserve_use,$err_reserve,$cutting_using_unit) = $this->ci->ordermodel->get_cutting_emoney($this->gl_post_params['emoney'],$members['emoney'],$settle_price,$cart['total']-$cart['total_sale_price'],$reserve_use,$err_reserve);

			if($err_reserve && $cutting_using_unit == 0){
				echo '<script>
						$("input[name=\'emoney\']",parent.document).val(0);
						$("input[name=\'emoney_view\']",parent.document).val(0);
						$("input[name=\'emoney_all\']",parent.document).val("");
						$(".emoney_cancel_button",parent.document).hide();
						$(".emoney_input_button",parent.document).show();
						$(".emoney_all_input_button",parent.document).show();
						$("#priceEmoneyTd",parent.document).hide();
					</script>';
				openDialogAlert($err_reserve,400,140,'parent',$pg_cancel_script);
				$this->call_exit();
			}else{
				if	($err_reserve) {
					echo '<script>
							$("input[name=\'emoney\']",parent.document).val("'.$cutting_using_unit.'");
							$("input[name=\'emoney_view\']",parent.document).val("'.get_currency_price($cutting_using_unit).'");
						</script>';
					openDialogAlert($err_reserve,400,140,'parent',$pg_cancel_script);
					$this->gl_post_params['emoney'] = $cutting_using_unit;
				}

				if	(!$this->ci->displaymode) {
					echo '<script>
					$("input[name=\'emoney_all\']",parent.document).val("");
					</script>';
				}
			}

			$cart['emoney']		= $this->gl_post_params['emoney'];
			$settle_price		-= $cart['emoney'];
		}

		$this->ci->amount = $settle_price;
		/*
		// 네이버 마일리지
		$this->ci->load->model('navermileagemodel');
		$settle_price = $this->ci->navermileagemodel->check_mileage($settle_price);
		*/

		# 사용한 마일리지/예치금
		$use_emonay = $cart['emoney'];
		$use_cash	= $cart['cash'];

		/* 상품결제가합 */
		$this->ci->sum_goods_price	= get_cutting_price($cart['total'],'basic');
		$this->ci->settle_price		= get_cutting_price($settle_price,'basic');
		$this->ci->shipping_price			= $shipping_price;//@2016-08-16 ysm
		$cart['total_price']	= $settle_price;

		$this->ci->cart = $cart;

		// 마일리지 합계 출력
		if($tot_reserve){
			$scripts[] = '$("#tot_reserve",parent.document).html("'.get_currency_price($tot_reserve).'");';
		}

		/* 구매 시 마일리지액 제한 조건 추가 leewh 2014-06-25 */
		if ($cfg_reserve['default_reserve_limit']>0) {
			$scripts[] = 'if (!$("#default_reserve_limit", parent.document).length) $("form#orderFrm", parent.document).append("<input type=\'hidden\' name=\'default_reserve_limit\' id=\'default_reserve_limit\' value=\''.$cfg_reserve['default_reserve_limit'].'\' />");';

			/* 마일리지액 제한 조건 C설정 */
			if ($cfg_reserve['default_reserve_limit']==2) {
				$scripts[] = 'if (!$("#appointed_reserve", parent.document).length) $("form#orderFrm", parent.document).append("<input type=\'hidden\' name=\'appointed_reserve\' id=\'appointed_reserve\' value=\''.$cart['total_reserve'].'\' />");';
			} else if ($cfg_reserve['default_reserve_limit']==3) {
				/* 마일리지액 제한 조건 B설정 */
				$scripts[] = 'if (!$("#total_real_sale_price", parent.document).length) {$("form#orderFrm", parent.document).append("<input type=\'hidden\' name=\'total_real_sale_price\' id=\'total_real_sale_price\' value=\''.$cart['total_real_sale_price'].'\' />");} else {$("form#orderFrm #total_real_sale_price", parent.document).val('.$cart['total_real_sale_price'].');}';
			}
		}

		/* 쿠폰이 무통장만 사용가능함 @2014-07-09 */
		if( $cart['coupon_sale_payment_b'] ) {
			$scripts[] = 'if (!$("#coupon_sale_payment_b", parent.document).length) {$("form#orderFrm", parent.document).append("<input type=\'hidden\' name=\'coupon_sale_payment_b\' id=\'coupon_sale_payment_b\' value=\''.$cart['coupon_sale_payment_b'].'\' />");} else {$("form#orderFrm #coupon_sale_payment_b", parent.document).val('.$cart['coupon_sale_payment_b'].');}';
		}

		$scripts[] = '$("#total_sale, .total_sale",parent.document).html("'.get_currency_price($cart['total_sale_price']).'");';
		$scripts[] = '$(".settle_price",parent.document).html("'.get_currency_price($cart['total_price']).'");';
		// 총 결제액의 비교통화 변경 @2016-07-14 pjm
		$this->ci->template->include_('showCompareCurrency');
		if($this->ci->mobileMode){
			$total_price_compare = addcslashes(str_replace("\r\n","",showCompareCurrency('',$cart['total_price'],'return')));
			$scripts[] = "$('.settle_price_compare .currency_compare_lay .currency_open',parent.document).html('".$total_price_compare."');";
		}else{
			$total_price_compare = (str_replace("\r\n","",showCompareCurrency('',$cart['total_price'],'return_array')));
			$compare_cnt	= count($total_price_compare);
			$compare_list	= array();
			foreach($total_price_compare as $k=>$compare_data){
				if($k == 0){
					if($compare_cnt > 1)	$open_yn = ' .currency_open';
					$scripts[] = "$('.settle_price_compare .currency_compare_lay".$open_yn."',parent.document).html('".$compare_data."');";
				}else{
					$compare_list[] = "<li>".$compare_data."</li>";
				}
			}
			$scripts[] = "$('.settle_price_compare .currency_compare_lay .currency_list',parent.document).html('".implode("",$compare_list)."');";
		}

		$scripts[] = '$(".totalprice",parent.document).html("'.get_currency_price($cart['total_price']).'");';
		if( $adminOrder == 'admin' ) {//관리자주문
			$scripts[] = '$(".total_price_temp",parent.document).val("'.get_currency_price($cart['total_price']).'");';
		}
		$scripts[] = '$("#total_reserve,.total_reserve",parent.document).html("'.get_currency_price($cart['total_reserve']).'");';
		$scripts[] = '$("#total_point,.total_point",parent.document).html("'.get_currency_price($cart['total_point']).'");';
		$scripts[] = '$("#total_goods_price, span.total_goods_price",parent.document).html("'.get_currency_price($cart['total']).'");';
		$scripts[] = '$("#total_coupon_sale_tr",parent.document).'.($cart['total_coupon_sale']?'show()':'hide()').';';
		$scripts[] = '$("#total_coupon_sale, .total_coupon_sale",parent.document).html("'.get_currency_price($cart['total_coupon_sale']).'");';

		// 마이너스 처리 추가 :: 2017-06-01 lwh
		if($cart['total_coupon_sale'] > 0){
			$scripts[] = '$("#total_coupon_sale",parent.document).closest("div").find(".minus").show();';
		}else{
			$scripts[] = '$("#total_coupon_sale",parent.document).closest("div").find(".minus").hide();';
		}
		if($cart['total_code_sale'] > 0){
			$scripts[] = '$("#total_code_sale",parent.document).closest("div").find(".minus").show();';
		}else{
			$scripts[] = '$("#total_code_sale",parent.document).closest("div").find(".minus").hide();';
		}

		$session_arr = ( $this->ci->session->userdata('user') )?$this->ci->session->userdata('user'):$_SESSION['user'];
		if( count($this->ci->systemfblike['result'])) {//할인혜택이 있으면 '좋아요 혜택' 문구노출
			if( ($cfg['order']['fblike_ordertype'] == 1 && $session_arr['member_seq'] ) || ($cfg['order']['fblike_ordertype'] != 1) ) {//비회원혜택여부
				$scripts[] = '$(".fblikelay",parent.document).show();';
			}
		}
		$scripts[] = '$("#total_fblike_sale_tr",parent.document).'.($cart['total_fblike_sale']?'show()':'hide()').';';

		$scripts[] = '$("#total_fblike_sale",parent.document).html("'.get_currency_price($cart['total_fblike_sale']).'");';
		$scripts[] = '$("#total_mobile_sale_tr",parent.document).'.($cart['total_mobile_sale']?'show()':'hide()').';';
		$scripts[] = '$("#total_mobile_sale",parent.document).html("'.get_currency_price($cart['total_mobile_sale']).'");';
		$scripts[] = '$("#total_member_sale_tr",parent.document).'.($cart['total_member_sale']?'show()':'hide()').';';
		$scripts[] = '$("#total_member_sale",parent.document).html("'.get_currency_price($cart['total_member_sale']).'");';
		$scripts[] = '$("#total_referer_sale_tr",parent.document).'.($cart['total_referer_sale']?'show()':'hide()').';';
		$scripts[] = '$("#total_referer_sale",parent.document).html("'.get_currency_price($cart['total_referer_sale']).'");';
		$scripts[] = '$("#total_shipping_price, .total_shipping_price",parent.document).html("'.get_currency_price($total_shipping_price).'");';

		$scripts[] = '$("#use_emoney, .use_emoney",parent.document).html("'.get_currency_price($cart['emoney']).'");';
		if($cart['emoney']>0){
			$scripts[] = '$("#use_emoney, .use_emoney",parent.document).closest("div").find(".minus").show();';
		}else{
			$scripts[] = '$("#use_emoney, .use_emoney",parent.document).closest("div").find(".minus").hide();';
		}
		$scripts[] = '$("#use_cash, .use_cash",parent.document).html("'.get_currency_price($cart['cash']).'");';
		if($cart['emoney']>0){
			$scripts[] = '$("#use_cash, .use_cash",parent.document).closest("div").find(".minus").show();';
		}else{
			$scripts[] = '$("#use_cash, .use_cash",parent.document).closest("div").find(".minus").hide();';
		}

		$scripts[] = '$("#tmp_emoney_set",parent.document).html("'.get_currency_price($total_emoney - $this->gl_post_params['emoney']).'");';
		$scripts[] = '$("#tmp_cash_set",parent.document).html("'.get_currency_price($total_cash - $this->gl_post_params['cash']).'");';


		################# 2014-10-31 변경된 장바구니 모양으로 인해 추가
		$cart['total_sale_list']['shippingcoupon']['title']	= '배송비쿠폰';
		$cart['total_sale_list']['shippingcoupon']['price']	= 0;
		$cart['total_sale_list']['shippingcode']['title']	= '배송비코드';
		$cart['total_sale_list']['shippingcode']['price']	= 0;

		$shipping_coupon_sale_price			= array_sum($this->ci->shipping_coupon_sale);
		if	($shipping_coupon_sale_price){
			$total_sales_price	+= $shipping_coupon_sale_price;
			$cart['total_sale_list']['shippingcoupon']['title']	= '배송비쿠폰';
			$cart['total_sale_list']['shippingcoupon']['price']	= $shipping_coupon_sale_price;
			$cart['total_sale_list']['coupon']['price']			+= $shipping_coupon_sale_price;
		}
		$shipping_promotion_code_sale_price	= array_sum($this->ci->shipping_promotion_code_sale);
		if	($shipping_promotion_code_sale_price > 0){
			$total_sales_price	+= $shipping_promotion_code_sale_price;
			$cart['total_sale_list']['shippingcode']['title']	= '배송비코드';
			$cart['total_sale_list']['shippingcode']['price']	= $shipping_promotion_code_sale_price;
		}
		// 에누리
		if	($enuri > 0)	$total_sales_price	+= get_cutting_price($enuri);

		// 총할인 정보
		if	($total_sales_price > 0){
			$scripts[] = '$(".total_sale_price_btn",parent.document).show();';
			$scripts[] = '$(".total_sales_price",parent.document).html("'.get_currency_price($total_sales_price).'");';
			$scripts[] = '$(".total_sales_price",parent.document).closest("div").find(".minus").show();';

			if	($cart['total_sale_list'])foreach($cart['total_sale_list'] as $sale_type => $saleArr){
				if	($saleArr['price'] > 0){
					$scripts[] = '$("#total_'.$sale_type.'_sale",parent.document).html("'.get_currency_price($saleArr['price']).'");';
					$scripts[] = '$("#total_'.$sale_type.'_sale_tr, " ,parent.document).show();';
				}else{
					$scripts[] = '$("#total_'.$sale_type.'_sale",parent.document).html("0");';
					$scripts[] = '$("#total_'.$sale_type.'_sale_tr, " ,parent.document).hide();';
				}
			}

			// 배송비 쿠폰
			if(isset($shipping_coupon_sale_price)){//배송비쿠폰선택시
				$scripts[]	= '$("span#shipping_coupon_sale",parent.document).html("<span style=\"padding-left:20px;\">배송비쿠폰할인 : (-)'.get_currency_price($shipping_coupon_sale_price,3).'</span>");';
				$scripts[]	= '$("#shipping_coupon_sale_tr",parent.document).show();';
			}else{
				$scripts[]	= '$("span#shipping_coupon_sale",parent.document).html("");';
				$scripts[]	= '$("#shipping_coupon_sale_tr",parent.document).hide();';
			}

			// 배송비 코드
			if($shipping_promotion_code_sale_price > 0){
				$scripts[]	= '$("span#shipping_code_sale",parent.document).html("<span style=\"padding-left:20px;\">배송비코드할인 : (-)'.get_currency_price($shipping_promotion_code_sale_price).'</span>");';
				$scripts[]	= '$("#shipping_code_sale_tr",parent.document).show();';
			}else{
				$scripts[]	= '$("span#shipping_code_sale",parent.document).html("");';
				$scripts[]	= '$("#shipping_code_sale_tr",parent.document).hide();';
			}

			// 에누리 할인 추가
			if	($enuri > 0){
				$scripts[] = '$("#enuri_tr",parent.document).show();';
				$scripts[] = '$("#enuri",parent.document).html("'.get_currency_price($enuri).'");';
				$scripts[] = '$("input[name=\'enuri\']",parent.document).val("'.$enuri.'");';
			}else{
				$scripts[] = '$("#enuri_tr",parent.document).hide();';
				$scripts[] = '$("#enuri",parent.document).html("0");';
				$scripts[] = '$("input[name=\'enuri\']",parent.document).val("");';
			}
		}else{
			$scripts[] = '$(".total_sale_price_btn",parent.document).hide();';
			$scripts[] = '$(".total_sales_price",parent.document).html("0");';
			$scripts[] = '$(".total_sales_price",parent.document).closest("div").find(".minus").hide();';
		}

		################# 2014-10-31 변경된 장바구니 모양으로 인해 추가

		// 추가배송비 처리
		$tot_add_delivery = 0;
		$tot_basic_delivery = 0;
		foreach($shipping_group_policy as $shipping_group=>$row){
			if	($row['add_delivery_cost'] > 0){
				$scripts[] = '$("#add_delivery_'.$shipping_group.'",parent.document).html("+ '.get_currency_price($row['add_delivery_cost'],2).'");';
			}else{
				$scripts[] = '$("#add_delivery_'.$shipping_group.'",parent.document).html("");';
			}

			$tot_add_delivery += get_cutting_price($row['add_delivery_cost']);
		}

		// 모바일 스킨 기본배송비 추가배송비 영역 출력
		if( $total_shipping_price ){
			$tot_basic_delivery = get_cutting_price($total_shipping_price) - get_cutting_price($tot_add_delivery);
		}
		$scripts[] = '$("#basic_delivery",parent.document).html("'.get_currency_price($tot_basic_delivery).'");';
		$scripts[] = '$("#add_basic_delivery",parent.document).html("'.get_currency_price($tot_add_delivery).'");';

		//@프로모션코드
		$scripts[] = '$("#cartpromotioncode",parent.document).val("'.$this->ci->session->userdata('cart_promotioncode_'.session_id()).'");';
		if($this->ci->session->userdata('cart_promotioncode_'.session_id())){
			$scripts[] = '$(".cartpromotioncodeinputlay",parent.document).hide();';
			$scripts[] = '$(".cartpromotioncodedellay",parent.document).show();';
		}else{
			$scripts[] = '$(".cartpromotioncodeinputlay",parent.document).show();';
			$scripts[] = '$(".cartpromotioncodedellay",parent.document).hide();';
		}
		$scripts[] = '$("#total_promotion_goods_sale_tr",parent.document).'.($cart['total_promotion_code_sale']?'show()':'hide()').';';
		$scripts[] = '$("#total_promotion_goods_sale, .total_promotion_goods_sale",parent.document).html("'.get_currency_price($cart['total_promotion_code_sale']).'");';

		if(is_array($this->ci->shipping_promotion_code_sale) && count($this->ci->shipping_promotion_code_sale) > 0) {//배송비프로모션선택시
			foreach($this->ci->shipping_promotion_code_sale as $provider_seq => $shipping_sale){
				$scripts[]	= '$("div#shippingcode_sale_'.$provider_seq.'", parent.document).html("<img src=\"/admin/skin/default/images/common/icon/icon_ord_code.gif\" /> '.get_currency_price($shipping_sale,2).'");';
			}
		}else{
			$scripts[] = '$(".shippingcode_sale",parent.document).html("");';
		}

		if(isset($this->ci->shipping_coupon_sale)){//배송비쿠폰선택시
			foreach($this->ci->shipping_coupon_sale as $provider_seq => $shipping_sale){
				$scripts[] = '$("div#shippingcoupon_sale_'.$provider_seq.'",parent.document).html("<span class=\"desc\">- '.get_currency_price($shipping_sale,2).' 쿠폰</span>");';
			}
		}else{
			$scripts[] = '$("div.shippingcoupon_sale",parent.document).html("");';
		}

		/* 결제금액이 0원일 경우 결제수단을 무통장만 활성화 */
		if($settle_price==0){
			$scripts[] = '$("input[name=\'payment\'][value=\'bank\']",parent.document).attr("checked","checked").click();';
			$scripts[] = '$("input[name=\'payment\'][value!=\'bank\']",parent.document).attr("disabled","disabled");';

			$scripts[] = '$("#payment_type",parent.document).hide();';
			$scripts[] = '$("#payment_type_zero",parent.document).show();';
			$scripts[] = '$(".bank",parent.document).hide();';
			$scripts[] = 'if($("input[name=\'depositor\']",parent.document).val() == ""){';
			$scripts[] = '$("input[name=\'depositor\']",parent.document).val("전액할인");}';
			$scripts[] = 'if(!$("select[name=\'bank\']",parent.document).find("option:selected").val()){';
			$scripts[] = '$("select[name=\'bank\']",parent.document).find("option").eq(1).attr("selected",true);}';

			$scripts[] = '$(".cach_voucherchk", parent.document).hide();';
			$scripts[] = '$("select[name=\'typereceipt\']",parent.document).find("[value=0]").attr("selected",true);';
			$scripts[] = '$("#cash_container", parent.document).hide();';
			$scripts[] = '$("select[name=\'typereceipt\']",parent.document).find("[value=2]").attr("disabled","disabled");';

			# @2015-12-07 pjm 결제금액은 0원이나 마일리지 또는 예치금 사용이면 계산서 발급선택 노출
			if($cart['emoney'] > 0 || $cart['cash']){
				$scripts[] = '$("#typereceiptlay", parent.document).show();';
				//$scripts[] = '$(".typereceiptlay", parent.document).hide();';
				if($cart['emoney'] > 0 && $cfg['order']['sale_reserve_yn'] == 'Y') {
					$scripts[] = '$(".tax_voucherchk", parent.document).show();';
					$scripts[] = '$("select[name=\'typereceipt\']",parent.document).find("[value=1]").removeAttr("disabled");';
				} else if($cart['cash'] > 0 && $cfg['order']['sale_emoney_yn'] == 'Y')  {
					$scripts[] = '$(".tax_voucherchk", parent.document).show();';
					$scripts[] = '$("select[name=\'typereceipt\']",parent.document).find("[value=1]").removeAttr("disabled");';
				} else {
					$scripts[] = '$(".tax_voucherchk", parent.document).hide();';
					$scripts[] = '$("select[name=\'typereceipt\']",parent.document).find("[value=1]").attr("disabled","disabled");';
					$scripts[] = '$("#tax_container", parent.document).hide();';
					$scripts[] = '$(".typereceiptlay", parent.document).hide();';
					$scripts[] = '$("#typereceiptlay", parent.document).hide();';
				}
			}else{
				$scripts[] = '$(".tax_voucherchk", parent.document).hide();';
				$scripts[] = '$(".typereceiptlay", parent.document).hide();';
				$scripts[] = '$("#typereceiptlay", parent.document).hide();';
			}

			$scripts[] = '$("#escrow",parent.document).hide();';
		}else{
			$scripts[] = '$("select[name=\'typereceipt\']",parent.document).find("[value=2]").removeAttr("disabled");';
			$scripts[] = '$("select[name=\'typereceipt\']",parent.document).find("[value=1]").removeAttr("disabled");';
			$scripts[] = '$("input[name=\'payment\'][value!=\'bank\']",parent.document).removeAttr("disabled");';
			$scripts[] = '$("#payment_type",parent.document).show();';
			$scripts[] = '$("#payment_type_zero",parent.document).hide();';
			$scripts[] = 'if($("input[name=\'payment\']:checked",parent.document).val()=="bank"){';
			$scripts[] = '$(".bank",parent.document).show();}';
			$scripts[] = 'if($("input[name=\'depositor\']",parent.document).val() == "전액할인"){';
			$scripts[] = '$("input[name=\'depositor\']",parent.document).val("");}';
			if		($this->ci->_is_mobile_agent){//$this->ci->mobileMode  ||
				if	(is_array($pg['mobileEscrow']) && count($pg['mobileEscrow']) > 0){
					if		(in_array('account', $pg['mobileEscrow']) && $pg['mobileEscrowAccountLimit'] <= $settle_price) {
						$scripts[] = '$("#escrow",parent.document).show();';
					}elseif	(in_array('virtual', $pg['mobileEscrow']) && $pg['mobileEscrowVirtualLimit'] <= $settle_price) {
						$scripts[] = '$("#escrow",parent.document).show();';
					}else{
						$scripts[] = '$("#escrow",parent.document).hide();';
					}
				}else{
					$scripts[] = '$("#escrow",parent.document).hide();';
				}
			}else{
				if	(is_array($pg['escrow']) && count($pg['escrow']) > 0){
					if		(in_array('account', $pg['escrow']) && $pg['escrowAccountLimit'] <= $settle_price) {
						$scripts[] = '$("#escrow",parent.document).show();';
					}elseif	(in_array('virtual', $pg['escrow']) && $pg['escrowVirtualLimit'] <= $settle_price) {
						$scripts[] = '$("#escrow",parent.document).show();';
					}else{
						$scripts[] = '$("#escrow",parent.document).hide();';
					}
				}else{
					$scripts[] = '$("#escrow",parent.document).hide();';
				}
			}
			$scripts[] = 'if($("input[name=\'payment\']:checked",parent.document).val()=="bank"){';
			$scripts[] = '$("#typereceiptlay", parent.document).show();}';
			$scripts[] = '$(".tax_voucherchk", parent.document).show();';
			$scripts[] = '$(".cash_voucherchk", parent.document).show();';
		}

		// 배송방법 선택 없앰
		$scripts[] = '$(".shipping_tr", parent.document).hide();';
		// 다른국가선택 레이어 숨기기
		if($this->gl_post_params['address_nation']){
			$scripts[] = '$(".detailDescriptionLayer", parent.document).hide();';
		}

		$scripts[] = "});";
		$scripts[] = "</script>";

		if($this->ci->displaymode == 'coupon'){
			$checkcoupons			= 0;
			$checkshippingcoupons	= 0;
			$html					= '';
			$shippinghtml			= '';
			$r_template_file_path		= explode('/',$this->ci->template_path());
			$r_template_file_path[2]	= "_coupon.html";
			$template_file_path			= implode('/',$r_template_file_path);

			$this->ci->template->assign(array(
				'shipping_group_policy'	=> $cart['shipping_group_policy'],
				'shipping_group_price'	=> $cart['shipping_group_price']
			));
			// 상품 관련 쿠폰 :: 2017-05-17 lwh
			if	( $members && $person_seq == "") {
				foreach($provider_cart as $provider_seq => $data){
					$_cart_list = array();
					foreach($data['cart_list'] as $cart_key => $cart_data) {
						//이벤트적용 상품일 때 쿠폰사용제한 체크
						if(!$cart_data['event'] || $cart_data['event']['use_coupon'] == "y"){
							$_cart_list[] = $cart_data;
							if	($cart_data['coupons'])	$checkcoupons	+= count($cart_data['coupons']);
						}
					}
					$data['cart_list'] = $_cart_list;
					$tmp_provider_cart[]	= $data;
				}
			}
			$this->ci->template->assign(array(
				'provider_cart'			=> $tmp_provider_cart,
				'checkcoupons'			=> $checkcoupons
			));
			$this->ci->template->define('*', $template_file_path."?cartlist");
			$html	= $this->ci->template->fetch('*');

			// 배송쿠폰 :: 2017-05-17 lwh
			unset($tmp_provider_cart_shipping);
			if	( $members && $person_seq == "") {
				foreach($provider_cart as $shipKey => $data){
					$provider_seq = $data['shipping_provider_seq'];

					unset($cart_list);
					foreach($data['cart_list'] as $cart_key => $cart_data) {
						if	($cart_data['goods_kind'] == 'goods') $cart_list[] = $cart_data;
					}
					$data['cart_list']		= $cart_list;
					$total_shipping_price	+= $data['grp_shipping_price'];
					if	($data['grp_shipping_price'] > 0) {
						$shipping_group = $data['cart_list'][0]['shipping_group'];
						$shippingcoupons	= $this->ci->couponmodel->get_shippingcoupon_provider($provider_seq, $this->ci->userInfo['member_seq'], $data['provider_price'], $data['grp_shipping_price']);

						$data['cart_list'][0]['shipping_coupon']	= $shippingcoupons;
						$data['cart_list'][0]['shipping_cost']		= $data['grp_shipping_price'];
						if	($shippingcoupons)	$checkshippingcoupons	+= count($shippingcoupons);

						if	($this->ci->shipping_coupon_down_seq[$shipping_group])
							$data['cart_list'][0]['shipping_coupon_down_seq']	= $this->ci->shipping_coupon_down_seq[$shipping_group];
						if	($this->ci->shipping_coupon_sale[$shipping_group])
							$data['cart_list'][0]['shipping_coupon_sale']		= $this->ci->shipping_coupon_sale[$shipping_group];
						$tmp_provider_cart_shipping[]	= $data;
					}
				}
			}

			$this->ci->template->assign(array(
				'provider_cart'				=> $tmp_provider_cart_shipping,
				'checkshippingcoupons'		=> $checkshippingcoupons,
				'total_shipping_price'		=> $total_shipping_price
			));

			$this->ci->template->define('*', $template_file_path."?shippincoupon");
			$shippinghtml = $this->ci->template->fetch('*');

			// 주문서쿠폰 :: 2018-09-10 hed
			unset($checkordersheetcoupons);
			if	( $members && $person_seq == "") {
				$ordersheetcoupons = $this->ci->couponmodel->get_able_use_ordersheet_coupon_list($this->ci->userInfo['member_seq'], $this->ci->sum_goods_price);
				$checkordersheetcoupons	= count($ordersheetcoupons);
			}

			$this->ci->template->assign(array(
				'ordersheetcoupons'				=> $ordersheetcoupons,
				'checkordersheetcoupons'		=> $checkordersheetcoupons,
				'ordersheet_coupon_download_seq'	=> $ordersheet_coupon_download_seq
			));

			// 스킨 패치에 따라 영향을 받을 수 있어 별도 파일로 처리
			$r_template_file_path[2]		= "_coupon_ordersheet.html";
			$ordersheet_template_file_path	= implode('/',$r_template_file_path);
			$this->ci->template->define('coupon_ordersheet', $ordersheet_template_file_path);
			$coupon_ordersheet_html = $this->ci->template->fetch('coupon_ordersheet');
			
			if	( $checkcoupons < 1 && $checkshippingcoupons < 1 && $checkordersheetcoupons < 1) {
				$return		= array('coupon_error'				=> true,
									'checkcoupons'				=> $checkcoupons,
									'checkshippingcoupons'		=> $checkshippingcoupons,
									'checkordersheetcoupons'	=> $checkordersheetcoupons,
									'coupongoods'				=> '',
									'couponshipping'			=> '',
									'couponordersheet'			=> '');
			}else{
				$return		= array('coupon_error'				=> false,
									'checkcoupons'				=> $checkcoupons,
									'checkshippingcoupons'		=> $checkshippingcoupons,
									'checkordersheetcoupons'	=> $checkordersheetcoupons,
									'coupongoods'				=> $html,
									'couponshipping'			=> $shippinghtml,
									'couponordersheet'			=> $coupon_ordersheet_html);
			}
			echo json_encode($return);
		}else if($this->ci->displaymode == 'cart') {
			return $cart;
		}else if(!$this->ci->displaymode){
			foreach($scripts as $script){
				echo $script."\n";
			}
		}
	}
	
	
	public function call_exit(){
		if($this->allow_exit){
			exit;
		}
	}
}