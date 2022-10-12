<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once(APPPATH ."libraries/o2o/o2oservicelibrary".EXT);

Class o2oorderlibrary extends o2oservicelibrary
{
	public function __construct() {
		parent::__construct();
		
	}
	
	/**
	 * O2O 금액 합산 계산
	 * @param type $post_params
	 * @return type
	 */
	public function checksum_before_make_order(&$msg, $post_params) {
		if(!$this->checkO2OService){return $this->checkO2OService;}
		$result = 0;
		$org_result = $result;
		
		// ===========================================================
		// 검산을 위한 변수 정리 시작
		// ===========================================================
		$cal_data['settle_price']		= ($post_params['settle_price'])?$post_params['settle_price']:'0';
		$cal_data['org_settle_price']	= ($post_params['org_settle_price'])?$post_params['org_settle_price']:'0';
		$cal_data['emoney']				= ($post_params['emoney'])?$post_params['emoney']:'0';
		$cal_data['cash']				= ($post_params['cash'])?$post_params['cash']:'0';
		$cal_data['enuri']				= ($post_params['enuri'])?$post_params['enuri']:'0';
		$cal_data['discount_price']		= $cal_data['emoney'] + $cal_data['cash'] + $cal_data['enuri'];	//  + $cal_data['coupon']; 쿠폰은 각 상품내에 적용
		
		$cal_data['sum_org_price']		= '0';
		// 각 상품 총액 계산
		foreach($post_params['order_item'] as $order_item){
			$cal_data['sum_org_price']	+= ($order_item['org_price'] * $order_item['ea']);
			foreach($this->CI->arr_sale_list as $sale_name){
				$cal_data[$sale_name.'_sale']	+= ($order_item[$sale_name.'_sale_unit'] * $order_item['ea']) + $order_item[$sale_name.'_sale_rest'];							
			}
			// $cal_data['pos_sale']	+= ($order_item['pos_sale_unit'] * $order_item['ea']) + $order_item['pos_sale_rest'];							
		}
		// 모든 할인 총액 가산
		foreach($this->CI->arr_sale_list as $sale_name){
			$cal_data['discount_price']	+= $cal_data[$sale_name.'_sale'];							
		}
		// $cal_data['discount_price']	+= $cal_data['pos_sale'];
		// ===========================================================
		// 검산을 위한 변수 정리 종료
		// ===========================================================
		
		
		// ===========================================================
		// 검산 시작
		// ===========================================================
		
		if($cal_data['sum_org_price'] != $cal_data['org_settle_price']){
			$msg .= ':할인 전 결제 총액이 올바르지 않습니다.';
			$result++;
		}
		$cal_data['check_price']		= $cal_data['sum_org_price'] - $cal_data['discount_price'];
		if($cal_data['check_price'] != $cal_data['settle_price']){
			$msg .= ':할인 후 결제 총액이 올바르지 않습니다.';
			$result++;
		}
		// 각 상품별 금액
		foreach($post_params['order_item'] as $order_item){
			unset($check_price);
			$check_price	=	$order_item['org_price'] * $order_item['ea'];
				
			foreach($this->CI->arr_sale_list as $sale_name){
				$check_price	-= ($order_item[$sale_name.'_sale_unit'] * $order_item['ea']) + $order_item[$sale_name.'_sale_rest'];
			}
			$check_price = floor($check_price / $order_item['ea']);
			if($check_price != $order_item['price']){
				$msg .= ':할인 후 개별 판매가가 올바르지 않습니다.';
				$result++;
			}
		}
		// ===========================================================
		// 검산 종료
		// ===========================================================
		
		// 초기값과 변함이 없을 때
		if($result == $org_result){
			$result = true;
		}else{
			$msg .= ':금액 계산이 올바르지 않습니다.';
			$result = false;
		}
		
		return $result;
	}
	
	/**
	 * O2O 전용 주문 생성
	 *	[프로세스]
	 *		O2O 전용 배송그룹 호출
	 *		주문 마스터 생성
	 *		배송그룹 추출
	 *		주문 배송그룹 저장
	 *		주문 아이템 저장
	 *		정산
	 *		출고
	 *		배송
	 * @param type $post_params
	 * @return type
	 */
	public function make_o2o_order(&$result, $post_params) {
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		// 중복 수집 체크
		$this->CI->load->library('orderlibrary');
		unset($orderCheckParams);
		$orderCheckParams['order_seq']				= null;
		$orderCheckParams['linkage_id']				= 'pos';
		$orderCheckParams['linkage_order_id']		= $post_params['pos_order_seq'];	// 추후 샵링커등 연동시 주문번호로 사용
		$orderCheckParams['linkage_mall_code']		= $this->CI->o2oConfig['o2o_store_seq'];
		$dup_order = $this->CI->orderlibrary->get_order($orderCheckParams);
		if($dup_order['order_seq']){
			$result['msg']		= '중복된 POS 주문번호입니다.';
			$result['data']		= array('order_seq' => $dup_order['order_seq']);
			return '';
		}

		// sale library 에서 받을 수 없기에 상품 금액에 대한 총 금액을 재계산함.
		$cal_total_real_sale_price = 0;
		// 제한조건C 의경우 총 적립금 데이터가 필요하므로 미리 계산
		$cfg_reserve		= ($this->CI->reserves)?$this->CI->reserves:config_load('reserve');
		$appointed_reserve = 0;
		// 재계산 시작
		foreach($post_params['order_item'] as $tmp_post_order_item_key=>$tmp_post_order_item){
			$cal_total_real_sale_price += $tmp_post_order_item['price'] * $tmp_post_order_item['ea'];

			// 제한조건C 의경우 총 적립금 데이터가 필요하므로 미리 계산
			if ($cfg_reserve['default_reserve_limit']==2 && $post_params['emoney'] > 0) {
				$tmpGoodsInfo = $this->get_goods_onlyone_by_barcode($result['msg'], $tmp_post_order_item['barcode']);
				$goodsMasterInfo = $tmpGoodsInfo['goodsMasterInfo'];
				
				$opt_price			= $tmp_post_order_item['price'];
				
				$reserve_policy		= ($goodsMasterInfo['reserve_policy'])?$goodsMasterInfo['reserve_policy']:'shop';
				$reserve_rate		= ($goodsMasterInfo['reserve_rate'])?$goodsMasterInfo['reserve_rate']:$cfg_reserve['default_reserve_percent'];
				$reserve_unit		= ($goodsMasterInfo['reserve_unit'])?$goodsMasterInfo['reserve_unit']:'percent';
				$reserve			= ($goodsMasterInfo['reserve'])?$goodsMasterInfo['reserve']:'0';
				$new_opt_price = $opt_price;
				
				$tmp_reserve	= $this->CI->goodsmodel->get_reserve_with_policy($reserve_policy, $new_opt_price, $cfg_reserve['default_reserve_percent'], $reserve_rate, $reserve_unit, $reserve);
				$appointed_reserve += $tmp_reserve;
			}
		}
		
		// $post_params 가공
		$externalOrderSeqList = array();		// O2O 대량 주문입력은 고려되지 않았으므로 단일 주문 수집을 기준처리
		$externalOrderSeqList[] = $post_params['pos_order_seq'];
		
		// $post_params['order_item'] 가공
		$marketProductArr = array();
		$nowOrderList = array();
		foreach($post_params['order_item'] as $tmp_post_order_item_key=>$tmp_post_order_item){
			// 외부판매 상품 고유키 저장
			$marketProductArr[]						= $tmp_post_order_item['barcode'];
			
			$tmpGoodsInfo = $this->get_goods_onlyone_by_barcode($result['msg'], $tmp_post_order_item['barcode']);
			$goodsMasterInfo = $tmpGoodsInfo['goodsMasterInfo'];
			$goodsOptionInfo = $tmpGoodsInfo['data'];
			$goodsOptionType = $tmpGoodsInfo['type'];
			
				
			$orderRow = array();
			$orderRow['provider_seq']				= ($goodsMasterInfo['provider_seq'])?$goodsMasterInfo['provider_seq']:'1'; // 상품의 입점사
			$orderRow['fm_goods_seq']				= $goodsMasterInfo['goods_seq']; // 연결 상품 고유키
			$orderRow['fm_goods_code']				= $goodsMasterInfo['goods_code']; // 연결 상품 코드
			$orderRow['fm_goods_image']				= $goodsMasterInfo['image']; // 연결 상품 이미지
			$orderRow['fm_goods_name']				= $goodsMasterInfo['goods_name']; // 연결 상품명
			$orderRow['tax']						= $goodsMasterInfo['tax']; // 연결 상품 부가세
			$orderRow['adult_goods']				= $goodsMasterInfo['adult_goods']; // 연결 상품 성인 여부 | N : 일방상품, Y : 성인상품
			$orderRow['goods_type']					= $goodsMasterInfo['goods_type']; // 연결 상품 타입 | goods : 일반상품, gift : 사은품
			$orderRow['individual_refund']			= $goodsMasterInfo['individual_refund']; // 개별취소 가능 여부
			$orderRow['individual_refund_inherit']	= $goodsMasterInfo['individual_refund_inherit']; // 본상품 취소시 함께 취소 여부
			$orderRow['individual_export']			= $goodsMasterInfo['individual_export']; // 개별출고 가능 여부
			$orderRow['individual_return']			= $goodsMasterInfo['individual_return']; // 개별반품 교환 가능 여부
			$orderRow['global_shipping_yn']			= 'Y'; // 개별 출고 설정 사용 여부
			$orderRow['shipping_group_seq']			= $goodsMasterInfo['shipping_group_seq']; // 배송그룹 고유키
			
			$orderRow['goods_seq']					= $goodsMasterInfo['goods_seq']; // 연결 상품 고유키
			$orderRow['goods_name']					= $goodsMasterInfo['goods_name']; // 연결 상품명
			$orderRow['goods_kind']					= $goodsMasterInfo['goods_kind']; // 연결 종류
					
			// $post_params 정보 할당
			$orderRow['seq']						= $post_params['pos_order_seq']; // 외부 판매 주문 고유키
			
			// $tmp_post_order_item 정보 할당
			$orderRow['market_product_code']		= $tmp_post_order_item['barcode']; // 외부 판매처 상품 고유키
			$orderRow['purchase_goods_name']		= $tmp_post_order_item['goods_name']; // 외부 상품 판매 금액
			$orderRow['product_price']				= $tmp_post_order_item['org_price']; // 외부 상품 판매 금액
			$orderRow['order_product_price']		= $tmp_post_order_item['org_price']; // 외부 상품 판매 금액 - 할인전
			$orderRow['order_qty']					= $tmp_post_order_item['ea']; // 외부 상품 판매 수량
			
			// 옵션 정보 저장
			$orderRow['optionInfo']					= array();
			$orderRow['subOptionInfo']				= array();
			if($goodsOptionType == 'opt'){								// 필수옵션 매칭 시
				$orderRow['optionInfo'][] = $goodsOptionInfo;
			}elseif($goodsOptionType == 'sub'){							// 추가 매칭 시
				$orderRow['subOptionInfo'.'_'.$goodsMasterInfo['goods_seq']][] = $goodsOptionInfo;
			}else{														// 미 매칭 시
				$orderRow['optionInfo'][] = array();
			}
			
			// 마일리지와 예치금과 포인트 처리
			$cfg_reserve		= ($this->CI->reserves)?$this->CI->reserves:config_load('reserve');
			$reserve_policy		= ($goodsMasterInfo['reserve_policy'])?$goodsMasterInfo['reserve_policy']:'shop';
			$reserve_rate		= ($goodsMasterInfo['reserve_rate'])?$goodsMasterInfo['reserve_rate']:$cfg_reserve['default_reserve_percent'];
			$reserve_unit		= ($goodsMasterInfo['reserve_unit'])?$goodsMasterInfo['reserve_unit']:'percent';
			$reserve			= ($goodsMasterInfo['reserve'])?$goodsMasterInfo['reserve']:'0';
			$opt_price			= $tmp_post_order_item['price'];
			
			
			// 구매적립(마일리지 제한 조건 설정에 따른 분기)
			$reserve_policy_log = '';
			$new_opt_price = 0; // 마일리지 계산용 변수
			if ($cfg_reserve['default_reserve_limit']==3 && $post_params['emoney'] > 0) {

				// 적립 제한 조건 B설정 추가 leewh 2014-07-04
				$each_using_reserve = 0;

				// 필수 옵션 1개 사용마일리지 계산
				$each_using_reserve = $this->CI->goodsmodel->get_reserve_standard_pay($opt_price, $tmp_post_order_item['ea'], $cal_total_real_sale_price, $post_params['emoney']);

				$new_opt_price = $opt_price - $each_using_reserve;
				$reserve_policy_log	.= sprintf('[제한조건B (실결제금액-사용마일리지 : %s)]', get_currency_price($new_opt_price));
			} else {
				// 마일리지 계산용 가격 분리 leewh 2014-07-09
				$new_opt_price = $opt_price;
			}
			
			// sale 라이브러리에서 회원 혜택 및 이벤트 혜택 조회
			if(($post_params['member_seq'] > 0)){
				$this->CI->load->model('membermodel');
				$members	= $this->CI->membermodel->get_member_data($post_params['member_seq']);
				
				$member_seq		= $members['member_seq'];
				$member_group	= $members['group_seq'];
				$total_emoney	= $members['emoney'];
				$total_cash		= $members['cash'];
				$applypage		= 'order';
				
				//----> sale library 적용
				$param['cal_type']				= 'list';
				$param['total_price']			= $post_params['settle_price'];
				$param['reserve_cfg']			= $cfg_reserve;
				$param['tot_use_emoney']		= $post_params['emoney'];
				$param['member_seq']			= $member_seq;
				$param['group_seq']				= $member_group;
				$param['sale_price']			= $tmp_post_order_item['price'];
				$param['ea']					= $tmp_post_order_item['ea'];
				$this->CI->load->library('sale');
				$this->CI->sale->set_init($param);
				$this->CI->sale->preload_set_config($applypage);
								
				// 이벤트 할인 계산
				$this->CI->sale->set_event_sale();
				$this->CI->sale->list_event_sale();
				
				// 이벤트 마일리지
				$orderRow['event_reserve']		= $this->CI->sale->event_sale_reserve($new_opt_price);
				// 이벤트 포인트
				$orderRow['event_point']		= $this->CI->sale->event_sale_point($new_opt_price);
				
				
				// 회원 할인 계산
				$this->CI->sale->goods['sale_seq'] = $goodsMasterInfo['sale_seq'];
				$this->CI->sale->set_member_sale();
				$this->CI->sale->list_member_sale();
				// 회원 마일리지
				$orderRow['member_reserve']		= $this->CI->sale->member_sale_reserve($new_opt_price, $post_params['settle_price']);
				// 회원 포인트
				$orderRow['member_point']		= $this->CI->sale->member_sale_point($new_opt_price, $post_params['settle_price']);
				
				//<---- sale library 적용
			}

			// 포인트
			$this->CI->load->model('goodsmodel');
			$orderRow['point']		= $this->CI->goodsmodel->get_point_with_policy($opt_price);
			$orderRow['reserve']	= $this->CI->goodsmodel->get_reserve_with_policy($reserve_policy, $new_opt_price, $cfg_reserve['default_reserve_percent'], $reserve_rate, $reserve_unit, $reserve);

			// 마일리지 설정 B일때 마일리지을 사용한 경우 상품마일리지 won(원) 단위 환산하여 지급 2015-04-02
			if ($cfg_reserve['default_reserve_limit'] == 3 && $post_params['emoney'] > 0) {
				if ($new_opt_price < 1) { // 결제금액 0원 일경우 마일리지 0원 처리
					$orderRow['reserve'] = 0;
				} else if($reserve_unit != 'percent') {
					$orderRow['reserve'] = get_currency_price(($orderRow['reserve']/$goodsMasterInfo['price'])*$new_opt_price);
				}
			}

			// 비회원 마일리지/포인트 제거
			if	(!($post_params['member_seq'] > 0)){
				$orderRow['fb_reserve']			= 0;
				$orderRow['fb_point']			= 0;
				$orderRow['mobile_reserve']		= 0;
				$orderRow['mobile_point']		= 0;
				$orderRow['member_point']		= 0;
				$orderRow['member_reserve']		= 0;
				$orderRow['point_one']			= 0;
				$orderRow['reserve_one']		= 0;
				$orderRow['point']				= 0;
				$orderRow['reserve']			= 0;
			}

			// 마일리지,포인트 로그
			$log = '';
			if	( $reserve_policy_log )	$log	.= $reserve_policy_log;
			if( $orderRow['reserve'] > 0 ) $log .= ($log?' / ':'').'구매  : '.(is_numeric($orderRow['reserve'])?get_currency_price($orderRow['reserve']):$orderRow['reserve']);
			if( $orderRow['event_reserve'] > 0 ) $log .= ($log?' / ':'').'이벤트  : '.(is_numeric($orderRow['event_reserve'])?get_currency_price($orderRow['event_reserve']):$orderRow['event_reserve']);
			if( $orderRow['member_reserve'] > 0 ) $log .= ($log?' / ':'').'회원  : '.(is_numeric($orderRow['member_reserve'])?get_currency_price($orderRow['member_reserve']):$orderRow['member_reserve']);
			if( $orderRow['fb_reserve'] > 0 ) $log .= ($log?' / ':'').'좋아요  : '.(is_numeric($orderRow['fb_reserve'])?get_currency_price($orderRow['fb_reserve']):$orderRow['fb_reserve']);
			if( $orderRow['mobile_reserve'] > 0 ) $log .= ($log?' / ':'').'모바일  : '.(is_numeric($orderRow['mobile_reserve'])?get_currency_price($orderRow['mobile_reserve']):$orderRow['mobile_reserve']);
			$orderRow['reserve_log'] = $log;
			$log = '';
			if( $orderRow['point'] > 0 ) $log .= ($log?' / ':'').'구매  : '.(is_numeric($orderRow['point'])?get_currency_price($orderRow['point']):$orderRow['point']);
			if( $orderRow['event_point'] > 0 ) $log .= ($log?' / ':'').'이벤트  : '.(is_numeric($orderRow['event_point'])?get_currency_price($orderRow['event_point']):$orderRow['event_point']);
			if( $orderRow['member_point'] > 0 ) $log .= ($log?' / ':'').'회원  : '.(is_numeric($orderRow['member_point'])?get_currency_price($orderRow['member_point']):$orderRow['member_point']);
			if( $orderRow['fb_point'] > 0 ) $log .= ($log?' / ':'').'좋아요  : '.(is_numeric($orderRow['fb_point'])?get_currency_price($orderRow['fb_point']):$orderRow['fb_point']);
			if( $orderRow['mobile_point'] > 0 ) $log .= ($log?' / ':'').'모바일  : '.(is_numeric($orderRow['mobile_point'])?get_currency_price($orderRow['mobile_point']):$orderRow['mobile_point']);
			$orderRow['point_log'] = $log;

			// 옵션의 마일리지 포인트
			$orderRow['reserve_one']	= get_cutting_price($orderRow['reserve'])
									+ get_cutting_price($orderRow['event_reserve'])
									+ get_cutting_price($orderRow['member_reserve'])
									+ get_cutting_price($orderRow['fb_reserve'])
									+ get_cutting_price($orderRow['mobile_reserve']);
			$orderRow['point_one']		= get_cutting_price($orderRow['point'])
									+ get_cutting_price($orderRow['event_point'])
									+ get_cutting_price($orderRow['member_point'])
									+ get_cutting_price($orderRow['fb_point'])
									+ get_cutting_price($orderRow['mobile_point']);

			/* 구매 시 마일리지액 제한 조건 추가 leewh 2014-06-25 */
			$reserve_policy_log = '';
			if ($cfg_reserve['default_reserve_limit']==1 && $post_params['emoney'] > 0) {
				$orderRow['reserve_one'] = 0;
				$reserve_policy_log	.= '[제한조건D 지급 마일리지 : 0]';
			} else if ($cfg_reserve['default_reserve_limit']==2 && $post_params['emoney'] > 0) {
				$minus_reserve = 0;
				$reserve_subtract = $appointed_reserve - $post_params['emoney'];

				if ($reserve_subtract > 0) {
					/* 필수 옵션 차감할 1개 사용 마일리지 계산 */
					$minus_reserve = $this->CI->goodsmodel->get_reserve_limit($orderRow['reserve_one']*$tmp_post_order_item['ea'], $tmp_post_order_item['ea'], $appointed_reserve, $post_params['emoney']);
					$orderRow['reserve_one'] = $orderRow['reserve_one'] - $minus_reserve;
				} else {
					$minus_reserve = $post_params['emoney'];
					$orderRow['reserve_one'] = 0;  //전액 사용으로 지급안함.
				}
				$reserve_policy_log .= sprintf("[제한조건C 지급 마일리지 : %s]", get_currency_price($orderRow['reserve_one']));
			}

			// 마일리지 정책 A 가 아닐경우 정책명을 제일 앞에 표시
			if ($orderRow['reserve_log'] && $reserve_policy_log) $orderRow['reserve_log'] = $reserve_policy_log." / ".$orderRow['reserve_log'];

			
			// 입력받은 할인 내역 저장
			foreach($this->CI->arr_sale_list as $sale_name){
				// 할인 내역 저장
				$orderRow[$sale_name.'_sale']			= ($tmp_post_order_item[$sale_name.'_sale_unit'] * $tmp_post_order_item['ea']) + $tmp_post_order_item[$sale_name.'_sale_rest'];	
				// 할인 내역 저장 - 상품별
				$orderRow[$sale_name.'_sale_unit']		= $tmp_post_order_item[$sale_name.'_sale_unit'];
				// 할인 내역 저장 - 나머지
				$orderRow[$sale_name.'_sale_rest']		= $tmp_post_order_item[$sale_name.'_sale_rest'];
			}
			
			// 매입가
			$orderRow['supply_price'] = 0;
			if(!empty($tmp_post_order_item['cost'])){
				$orderRow['supply_price'] = $tmp_post_order_item['cost'];
			}
			
			// 사용 쿠폰 번호
			$orderRow['download_seq'] = $post_params['cart_coupon_seq'];

			// 할인적용금액
			$orderRow['sale_price'] = $tmp_post_order_item['price'];
			
			if($goodsOptionType == 'sub'){							// 추가 매칭 시
				if(empty($nowOrderList[$orderRow['fm_goods_seq'].'_'.$tmp_post_order_item_key])){
					$nowOrderList[$orderRow['fm_goods_seq']] = $orderRow;
				}else{
					$tmp = $nowOrderList[$orderRow['fm_goods_seq'].'_'.$tmp_post_order_item_key];
					$tmp['subOptionInfo'.'_'.$goodsMasterInfo['goods_seq']][] = $goodsOptionInfo;
					$nowOrderList[$orderRow['fm_goods_seq'].'_'.$tmp_post_order_item_key] = $tmp;
				}
			}else{
				// 외부판매 상품 데이터 목록 저장
				$nowOrderList[$orderRow['fm_goods_seq'].'_'.$tmp_post_order_item_key] = $orderRow;
			}
		}
		
		// 트렌잭션 시작
		$this->CI->db->trans_begin();
				
		// 주문 생성 후 최종 order_seq 반환
		$order_seq = $this->make_o2o_insert_order($post_params);
		
		/**
		* 정산개선 배열초기화
		* @ accountallmodel
		**/
		$account_ins_shipping	= array();		// shipping->save_shipping 에서 생성
		$account_ins_opt		= array();
		$account_ins_subopt		= array();
		
		// O2O 전용 배송그룹 호출
		$o2o_shipping_group = $this->get_o2o_shipping_group($this->CI->o2oConfig['o2o_store_seq']);
		$shippingGroupSeq	= $o2o_shipping_group['shipping_method'];
		$shippingProviderArr = array();
		// 단일 배송그룹으로 처리되므로 $shippingGroupSeqArr 와 쌍이 맞아야하며 get_o2o_shipping_group 를 통해 1개의 배송그룹정보를 반환함
		$shippingProviderArr[] = $o2o_shipping_group['shippingGroup']['shipping_provider_seq'];

		// 매장 정보 저장
		if($o2o_shipping_group['shippingStore']){
			foreach($o2o_shipping_group['shippingStore'] as $tmpShippingStore){
				$shippingStoreScmTypeArr[]	= ($this->CI->o2oConfig['scm_store'])?'Y':'N';
				$shippingAddressSeqArr[]	= $tmpShippingStore['shipping_address_seq'];
			}
		}
		
		// ===========================================================================
		// 배송 그룹 정보 추출 시작
		// ===========================================================================
		// 배송 그룹에 따른 주문 배송 정보 목록 생성
		$shippingGroupSeqArr = array($shippingGroupSeq);		// O2O 배송 그룹
		$shippingParsms = array();
		$shippingParsms['default_first'] = true;
		unset($in);
		$in['orderSeq']						= $order_seq;					// o2oorderlibrary->make_o2o_insert_order 에서 반환
		$in['externalOrderSeqList']			= $externalOrderSeqList;		// $post_params 에서 가공
		$in['shippingGroupSeqArr']			= $shippingGroupSeqArr;			// o2oorderlibrary->get_o2o_shipping_group 에서 반환
		$in['marketProductArr']				= $marketProductArr;			// $post_params['order_item'] 에서 가공
		$in['shippingProviderArr']			= $shippingProviderArr;			// o2oorderlibrary->get_o2o_shipping_group 에서 반환된 값을 가공
		$in['shippingParsms']				= $shippingParsms;				// 상단 선언
		$in['shippingStoreScmTypeArr']		= $shippingStoreScmTypeArr;		// o2oorderlibrary->get_o2o_shipping_group 에서 반환
		$in['shippingAddressSeqArr']		= $shippingAddressSeqArr;		// o2oorderlibrary->get_o2o_shipping_group 에서 반환
		
		unset($out);
		$out = array();		
		$this->CI->load->library('shipping');
		$this->CI->shipping->make_shipping_group_list($in, $out);		
		// 결과 할당
		$shippingInfoList					= $out['shippingInfoList'];
		$shippingGroupList					= $out['shippingGroupList'];
		$productShippingCodeList			= $out['productShippingCodeList'];
		// ===========================================================================
		// 배송 그룹 정보 추출 종료
		// ===========================================================================
		
		// ===========================================================================
		// 배송 그룹 정보 저장 시작
		// ===========================================================================
		unset($in);
		$in['orderSeq']						= $order_seq;				// o2oorderlibrary->make_o2o_insert_order 에서 반환
		$in['shippingInfoList']				= $shippingInfoList;		// shipping->make_shipping_group_list 에서 반환
		$in['shippingGroupList']			= $shippingGroupList;		// shipping->make_shipping_group_list 에서 반환
		unset($out);
		$out = array();		
		$this->CI->load->library('shipping');
		$this->CI->shipping->save_shipping($in, $out);		
		// 결과 할당
		$shippingSeqList					= $out['shippingSeqList'];
		$account_ins_shipping				= $out['account_ins_shipping'];
		// ===========================================================================
		// 배송 그룹 정보 저장 종료
		// ===========================================================================
		
		// ===========================================================================
		// 주문 아이템 저장 시작
		// ===========================================================================
		$this->CI->load->library('orderlibrary');
		unset($in);
		$in['orderSeq']						= $order_seq;				// o2oorderlibrary->make_o2o_insert_order 에서 반환
		$in['shippingSeqList']				= $shippingSeqList;			// shipping->save_shipping 에서 반환
		$in['shippingInfoList']				= $shippingInfoList;		// shipping->make_shipping_group_list 에서 반환
		$in['productShippingCodeList']		= $productShippingCodeList;	// shipping->make_shipping_group_list 에서 반환
		$in['nowOrderList']					= $nowOrderList;			// $post_params['order_item'] 에서 가공
		unset($out);
		$out = array();		
		$this->CI->orderlibrary->save_order_item($in, $out);	
		// 결과 할당
		$orderItemList						= $out['orderItemList'];
		$account_ins_opt					= $out['account_ins_opt'];
		$account_ins_subopt					= $out['account_ins_subopt'];
		// ===========================================================================
		// 주문 아이템 저장 종료
		// ===========================================================================
		
		
		$orderRegister  = false;
		if(count($orderItemList)>0){
			$orderRegister  = true;
		}
		
		// ===========================================================================
		// 주문 완료 처리 시작
		// ===========================================================================
		if ($orderRegister == false) {
			$this->CI->db->trans_rollback();

			return $order_seq;
		}

		$this->CI->db->trans_commit();

		// 결제 성공 후 처리 | O2O 주문거래의 경우 선결제 후 주문수집이므로 결제 성공 처리를 바로 진행한다.

		// ===========================================================================
		// 주문 수정 정보 구성 시작
		// ===========================================================================
		$orderAddParams['mode']						= 'direct';
		$orderAddParams['deposit_yn'] 				= "y";
		$orderAddParams['emoney_use'] 				= 'none';
		$orderAddParams['cash_use'] 				= 'none';
		$orderAddParams['freeprice'] 				= 0;
		$orderAddParams['settleprice'] 				= $post_params['settle_price'];
		$orderAddParams['original_settleprice'] 	= $post_params['settle_price'];
		$orderAddParams['shipping_cost']			= 0;
		$orderAddParams['international']			= 'domestic';	// 배송지 강제 설정
		$orderAddParams['regist_date']				= ($post_params['regist_date'])?$post_params['regist_date']:date('Y-m-d H:i:s');
		$orderAddParams['deposit_date']				= ($post_params['regist_date'])?$post_params['regist_date']:date('Y-m-d H:i:s');
		$orderAddParams['linkage_id']				= 'pos';
		$orderAddParams['linkage_order_id']			= $post_params['pos_order_seq'];	// 추후 샵링커등 연동시 주문번호로 사용
		$orderAddParams['linkage_mall_order_id']	= null;
		$orderAddParams['linkage_mall_code']		= $this->CI->o2oConfig['o2o_store_seq'];
		$orderAddParams['linkage_order_reg_date']	= date('Y-m-d H:i:s');
		// ===========================================================================
		// 주문 수정 정보 구성 종료
		// ===========================================================================

		// ===========================================================================
		// 주문 후 결제 성공 처리 시작
		// ===========================================================================
		$this->CI->load->library('orderlibrary');
		unset($in);
		$in['orderSeq']						= $order_seq;				// o2oorderlibrary->make_o2o_insert_order 에서 반환
		$in['account_ins_opt']				= $account_ins_opt;			// orderlibrary->save_order_item 에서 반환
		$in['account_ins_subopt']			= $account_ins_subopt;		// orderlibrary->save_order_item 에서 반환
		$in['account_ins_shipping']			= $account_ins_shipping;	// shipping->save_shipping 에서 반환
		$in['orderAddParams']				= $orderAddParams;			// $post_params 에서 가공
		unset($out);
		$out = array();
		$this->CI->orderlibrary->proc_order_after_init($in, $out);		// 주문생성 처리
		$this->CI->orderlibrary->proc_order_after_success($in, $out);	// 주문접수 처리
		// O2O 주문의 경우 선결제 후 수집이므로 바로 결제 성공 처리
		$this->CI->orderlibrary->proc_order_after_payment($in, $out);	// 결제확인 처리
		// ===========================================================================
		// 주문 후 결제 성공 처리 종료
		// ===========================================================================

		// 출고 창고 정보
		$target_wh = '1';
		if ($this->CI->scm_cfg['use'] == 'Y' && $this->CI->o2oConfig['scm_store']) {
			$target_wh = $this->CI->o2oConfig['scm_store']; //2
		}

		// 출고 트랜잭션 시작 : 출고가 정상적으로 완료되지 않을 때엔 관리자에서 실행하기 위하여 트랜잭션 추가함
		$this->CI->db->trans_begin();

		// 개별 주문을 체크하여 매칭상품은 출고 완료, 미매칭상품은 결제완료로 유지 | 미매칭일 경우 상품 준비중 상태로 변경 불가함
		// 재고 설정에 따라 재고가 부족할 경우 결제완료, 재고와 상관 없이 출고할 경우 출고완료로 변경
		$this->proc_o2o_order_export($order_seq, $target_wh);

		// 출고 완료 상품을 배송완료로 (배송중 상태로 변경 불가함)
		$this->proc_o2o_order_batch_status($order_seq, $target_wh);

		if ($this->CI->db->trans_status() === false) {
			$this->CI->db->trans_rollback();

			return $order_seq;
		}

		// 출고 트랜잭션 종료
		$this->CI->db->trans_commit();

		// ===========================================================================
		// 주문 완료 처리 종료
		// ===========================================================================

		return $order_seq;

	}
	
	// O2O 전용 주문 마스터 생성
	public function make_o2o_insert_order($post_params) {
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		$this->CI->load->model('membermodel');
				
		// 회원 정보 
		$member_seq						= $post_params['member_seq'];
		if($member_seq){
			$member_data = $this->CI->membermodel->get_member_data($member_seq);
			// 주문자&수신자 정보 | 주문자와 수신자 정보는 member_seq에 대한 정보가 있으면 입력
			if($member_data){
				$order_user_name			= $member_data['user_name']; // 주문자명
				$order_phone				= explode("-", $member_data['phone']); // 주문자 연락처 | array
				$order_cellphone			= explode("-", $member_data['cellphone']); // 주문자 핸드폰 | array
				$order_email				= $member_data['email']; // 주문자 이메일
				$recipient_user_name		= $member_data['user_name']; // 수신자명
				$recipient_phone			= explode("-", $member_data['phone']); // 수신자 연락처 | array
				$recipient_cellphone		= explode("-", $member_data['cellphone']); // 수신자 핸드폰 | array
				$recipient_email			= $member_data['email']; // 수신자 이메일 | 티켓 상품 일 때만 입력됨
			}
		}
		
		// 배송지 정보
		$international					= ($this->CI->o2oConfig['pos_address_nation']=='korea')?'0':'1'; // 국제발송 여부 | 1 : 국제 발송, 0 : 국내 발송
		$address_nation_key				= ($this->CI->o2oConfig['pos_address_nation']=='korea')?'KOR':''; // 배송 국가 코드 | 기본 KOR

		$region							= $this->CI->o2oConfig['pos_address_nation']; // 국제 배송 국가
		$international_address			= $this->CI->o2oConfig['pos_international_address']; // 국제 배송 주소
		$international_town_city		= $this->CI->o2oConfig['pos_international_town_city']; // 국제 배송 도시
		$international_county			= $this->CI->o2oConfig['pos_international_county']; // 국제 배송 지역
		$international_postcode			= $this->CI->o2oConfig['pos_international_postcode']; // 국제 배송 우편번호
		$international_country			= $this->CI->o2oConfig['pos_international_country']; // 국제 배송 국가
		
		$recipient_new_zipcode			= $this->CI->o2oConfig['pos_address_zipcode']; // 국내 배송 신 우편번호 5자리
		$recipient_address_type			= $this->CI->o2oConfig['pos_address_type']; // 국내 도로명주소 구분 | street : 도로명, zibun : 지번
		$recipient_address				= $this->CI->o2oConfig['pos_address']; // 국내 배송지 지번 주소
		$recipient_address_street		= $this->CI->o2oConfig['pos_address_street']; // 국내 배송지 도로명 주소
		$recipient_address_detail		= $this->CI->o2oConfig['pos_address_detail']; // 국내 배송지 상세
		

		// 결제 정보 | O2O의 결제 방식은 오프라인 POS에서 VAN 결제가 이루어지나 실제 금액 합산이 이루어지지 않으므로 bank로 처리
		$payment						= 'pos_pay'; // 결제 방식 | card : 신용카드, bank : 무통장입금, account : 계좌이체, cellphone | 핸드폰결제, virtual : 가상계좌, escrow_virtual : 에스크로 가상계좌, escrow_account : 에스크로 계좌이체, point : 포인트, paypal : 페이팔, pos_pay : 매장결제
		$typereceipt					= '0'; // 매출증빙 | 0 : 매출전표, 1: 세금계산서, 2: 현금영수증
		$emoney							= $post_params['emoney']; // 할인 총 마일리지
		$cash							= $post_params['cash']; // 할인 총 예치금
		$enuri							= $post_params['enuri']; //할인 총 에누리 : 매장할인 
		
		// 결제 부가 정보
		$krw_exchange_rate				= get_exchange_rate("KRW"); // 통화별 환율정보
		$settle_price					= $post_params['settle_price']; // 실 결제 금액
		$shipping_cost					= 0; // 총 배송비
		
		// 쿠폰 정보 확인 | 사용된 쿠폰 고유키로 해당 쿠폰이 장바구니 쿠폰인지 일반 쿠폰인지 구분
		if($post_params['cart_coupon_seq']){
			$coupon_download_seq = $post_params['cart_coupon_seq'];
			// 실제 사용 가능한지 여부 체크
			$sc['only_cart_goods']	= 'y';
			$sc['download_seq']		= $coupon_download_seq;
			$sc['use_status']		= 'unused';
			$sc['couponDate']		= array('available');
			
			$this->CI->load->model('couponmodel');
			$mycoupons				= $this->CI->couponmodel->my_download_list($sc, true);
			$downloads = $mycoupons['result'][0];
			if($downloads){
				if($downloads['type']=='ordersheet'){	// 쿠폰 종류가 장바구니 쿠폰일 경우
					$ordersheet_seq			= $post_params['cart_coupon_seq'];
					$ordersheet_sale		= 0;
					foreach($post_params['order_item'] as $post_params_item){
						$ordersheet_sale += ($post_params_item['coupon_sale_unit'] * $post_params_item['ea']) + $post_params_item['coupon_sale_rest'];
					}
					if($ordersheet_sale > 0){
						$ordersheet_sale_krw = get_currency_exchange($ordersheet_sale,"KRW",$this->CI->config_system['basic_currency']);
					}else{
						$ordersheet_sale_krw = '0';
					}
				}
			}
		}
		
		// 주문 생성 후 최종 order_seq 반환
		$order_seq = null;
		
		// ordermodel->insert_order 에서 이용하는 데이터들을 강제 재할당처리
		unset($_GET);
		unset($_POST);
		unset($_COOKIE);
		
		// =====================================================================
		// 주문 환경 정보
		// =====================================================================
		$_GET['mode']										= 'direct'; // 주문 방식 | 기본 cart | choice : 선택구매, cart : 장바구니구매, admin : 관리자구매, direct : 바로구매
		// $_POST['adminOrder']								= ''; // 관리자 주문 여부 | admin : 관리자 주문 | adminOrder 가 admin이고 admin_memo일 때 메모 저장 | 관리자 주문일 경우 $this->session->userdata["manager"]["manager_id"] 세션에서 관리자 고유키 입력
		// $this->session->userdata["manager"]["manager_id"]	= '';
		// $_POST['person_seq']								= ''; // 개인 결제 주문 | person_seq 와 admin_memo 동시 입력 시 메모 저장
		// $_POST['admin_memo']								= ''; // 관리자 메모
		// $_POST['member_seq']								= ''; // 회원 번호 | 일반적으론 $this->userInfo['member_seq']세션에서 추출함, adminOrder 가 admin일때 값 할당
		$this->CI->userInfo['member_seq']						= $member_seq;
		// $_POST['clearance_unique_personal_code']			= ''; // 해외배송상품 개인통관번호
		$_POST['overwrite_sitetype']						= $this->o2o_sitetype; // sitetype 덮어쓰기, ci환경에서 만들어내는 변수를 덮어씀 | APP_ANDROID : 안드로이드, APP_IOS : 아이폰, M : 모바일, F : 페이스북, P : PC, POS : 오프라인 주문
		// $_POST['overwrite_skintype']						= ''; // skintype 덮어쓰기, ci환경에서 만들어내는 변수를 덮어씀, 사용되는곳 없어서 안씀 | M : 모바일, F : 페이스북, OFF_M : 오프라인 모바일, OFF_F : 오프라인 페이스북, OFF_P : 오프라인 PC, P : PC


		// =====================================================================
		// 배송 메세지
		// =====================================================================
		// $_POST['each_msg']									= ''; // 개별 배송 메세지 여부 | Y : 개별 메세지, N : 일반
		// $_POST['each_memo']									= ''; // 개별 배송 메세지 array 타입
		// $_POST['memo']										= ''; // 배송 메세지


		// =====================================================================
		// 배송지 정보
		// =====================================================================
		$_POST['international']								= '0'; // 배송지정보 삭제 요청 $international; // 국제발송 여부 | 1 : 국제 발송, 0 : 국내 발송
		$_POST['address_nation_key']						= 'KOR'; // 배송지정보 삭제 요청 $address_nation_key; // 배송 국가 코드 | 기본 KOR

		$_POST['shipping_method_international']				= ''; // 국제 배송 방법
		$_POST['region']									= $region; // 국제 배송 국가
		$_POST['international_address']						= ''; // 배송지정보 삭제 요청 $international_address; // 국제 배송 주소
		$_POST['international_town_city']					= ''; // 배송지정보 삭제 요청 $international_town_city; // 국제 배송 도시
		$_POST['international_county']						= ''; // 배송지정보 삭제 요청 $international_county; // 국제 배송 지역
		$_POST['international_postcode']					= ''; // 배송지정보 삭제 요청 $international_postcode; // 국제 배송 우편번호
		$_POST['international_country']						= ''; // 배송지정보 삭제 요청 $international_country; // 국제 배송 국가

		// $_POST['shipping_method']							= ''; // 국내 배송 방법 | 미사용
		// $_POST['recipient_zipcode']							= ''; // 국내 배송 구 우편번호 6자리 | array | 미사용
		$_POST['recipient_new_zipcode']						= ''; // 배송지정보 삭제 요청 $recipient_new_zipcode; // 국내 배송 신 우편번호 5자리
		$_POST['recipient_address_type']					= ''; // 배송지정보 삭제 요청 $recipient_address_type; // 국내 도로명주소 구분 | street : 도로명, zibun : 지번
		$_POST['recipient_address']							= ''; // 배송지정보 삭제 요청 $recipient_address; // 국내 배송지 지번 주소
		$_POST['recipient_address_street']					= ''; // 배송지정보 삭제 요청 $recipient_address_street; // 국내 배송지 도로명 주소
		$_POST['recipient_address_detail']					= ''; // 배송지정보 삭제 요청 $recipient_address_detail; // 국내 배송지 상세


		// =====================================================================
		// 결제 정보
		// =====================================================================
		$_POST['payment']									= $payment; // 결제 방식 | card : 신용카드, bank : 무통장입금, account : 계좌이체, cellphone | 핸드폰결제, virtual : 가상계좌, escrow_virtual : 에스크로 가상계좌, escrow_account : 에스크로 계좌이체, point : 포인트, paypal : 페이팔
		$_POST['typereceipt']								= $typereceipt; // 매출증빙 | 0 : 매출전표, 1: 세금계산서, 2: 현금영수증
		// $_POST['depositor']									= ''; // 입금자명
		// $_POST['bank']										= ''; // 입금 계좌 정보
		$_POST['emoney']									= $emoney; // 할인 총 마일리지
		$_POST['cash']										= $cash; // 할인 총 예치금
		$_POST['enuri']										= $enuri; // 할인 총 에누리


		// =====================================================================
		// 주문자&수신자 정보
		// =====================================================================
		$_POST['order_user_name']							= ($order_user_name)?$order_user_name:'비회원'; // 주문자명
		$_POST['order_phone']								= $order_phone; // 주문자 연락처 | array
		$_POST['order_cellphone']							= ($order_cellphone)?$order_cellphone:array(); // 주문자 핸드폰 | array
		$_POST['order_email']								= ($order_email)?$order_email:''; // 주문자 이메일
		$_POST['recipient_user_name']						= $recipient_user_name; // 수신자명
		$_POST['recipient_phone']							= $recipient_phone; // 수신자 연락처 | array
		$_POST['recipient_cellphone']						= $recipient_cellphone; // 수신자 핸드폰 | array
		$_POST['recipient_email']							= $recipient_email; // 수신자 이메일 | 티켓 상품 일 때만 입력됨

		// =====================================================================
		// 결제 부가 정보
		// =====================================================================
		// $_POST['download_seq']								= ''; // 쿠폰 고유키 : 현재 미사용 추측
		// $_POST['coupon_sale']								= ''; // 쿠폰 할인 금액 : 현재 미사용 추측
		$params['krw_exchange_rate']						= $krw_exchange_rate; // 통화별 환율정보
		$params["ordersheet_seq"]							= $ordersheet_seq; // 장바구니 쿠폰 고유키
		$params["ordersheet_sale"]							= $ordersheet_sale; // 장바구니 쿠폰 할인 금액
		$params["ordersheet_sale_krw"]						= $ordersheet_sale_krw; // 장바구니 쿠폰 할인 금액(원화기준)
		$params['settle_price']								= $settle_price; // 실 결제 금액
		$params['shipping_cost']							= $shipping_cost; // 총 배송비
		// $params['shipping']									= ''; // 배송방법 | 미사용
		// $params['pgCompany']								= ''; // 결제 모듈


		// =====================================================================
		// 유입경로 정보
		// =====================================================================
		// $_COOKIE['marketplace']								= ''; // 유입매체
		// $_COOKIE['refererDomain']							= ''; // 유입경로 도메인
		// $_COOKIE['shopReferer']								= ''; // 유입경로 풀 URL
		// $_COOKIE["curation"]								= ''; // 고객 리마인드 유입 경로
		
		$this->CI->load->library('orderlibrary');
		$order_seq = $this->CI->orderlibrary->save_order($params);
		
		return $order_seq;
	}
	
	// O2O 전용 출고 처리
	public function proc_o2o_order_export($order_seq, $target_wh = 1) {
		if(!$this->checkO2OService){return $this->checkO2OService;}
		
		// ===========================================================================
		// 출고 데이터 추출용 쿼리 생성 시작
		// ===========================================================================
		$this->CI->load->library('exportlibrary');
		$export_data = $this->CI->exportlibrary->get_order_export_data($order_seq, $this->CI->o2oConfig['scm_store']);
		// ===========================================================================
		// 출고 데이터 추출용 쿼리 생성 종료
		// ===========================================================================
		
		// 출고 제한 정보 세팅
		$provider_seq = '1';	// O2O 주문은 입점사만 가능
		$data_provider = $this->CI->providermodel->get_provider($provider_seq);
		$stockable = $data_provider['default_export_stock_check'];
		$ticket_stockable = $data_provider['default_export_ticket_stock_check'];
		
		// 미매칭 상품의 주문 수집
		$config_order = config_load('order');
		$not_match_goods_order = $config_order['not_match_goods_order'];
		if(empty($not_match_goods_order)) $not_match_goods_order = 'y';

		// 미연결창고 상태 체크
		$not_connect_scm = $this->get_store_connect_scm();
		// 올인원버전을 사용하나 o2o 창고가 미연결창고인 경우 출고 시 재고 체크 및 재고를 차감하지 않음.
		if($not_connect_scm == 'Y'){
			$stockable = 'unlimit';
			$ticket_stockable = 'unlimit';
		}
		
		// 출고용 데이터 가공
		$p_pm = array();
		if($export_data['ordershipping']){
			foreach($export_data['ordershipping'] as $ordershipping){
				foreach($ordershipping as $oShipDe){
					$shipSeq = $oShipDe['shipping_seq'];	// 변수명 간소화
					
					$p_pm['check_mode']							= '';
					$p_pm['export_mode']						= 'goods';
					$p_pm['each_shipping_seq']					= ''; // 해당 주문건의 전체 출고
					$p_pm['each_item_option_seq']				= '';
					$p_pm['each_shipping_method']				= '';
					$p_pm['export_date']						= date("Y-m-d");
					$p_pm['stockable']							= $stockable;		// 출고되는 모든 실물의 재고가 있으면
					$p_pm['export_step']						= '55';			// 출고완료
					$p_pm['ticket_stockable']					= $ticket_stockable;		// 출고되는 모든 실물의 재고가 있으면
					$p_pm['ticket_step']						= '55';			// 출고완료
					$p_pm['scm_wh']								= $this->CI->o2oConfig['scm_store'];			// 연결된 창고
					
					// 미연결창고의 재고처리를 위한 변수
					$p_pm['not_connect_scm']					= $not_connect_scm;
					
					$p_pm['order_seq'][$shipSeq]				= $oShipDe['order_seq'];
					$p_pm['check_shipping_seq'][$shipSeq]		= $shipSeq;
					
					$p_pm['export_shipping_group'][$shipSeq]	= $oShipDe['shipping_group'];
					$p_pm['export_shipping_method'][$shipSeq]	= $oShipDe['shipping_method'];
					$p_pm['export_shipping_set_name'][$shipSeq]	= $oShipDe['shipping_set_name'];
					$p_pm['delivery_company'][$shipSeq]			= 'code0';	// O2O는 택배 배송 없음
					$p_pm['delivery_number'][$shipSeq]			= '';	// O2O는 택배 배송 없음
					$p_pm['export_store_scm_type'][$shipSeq]	= $oShipDe['store_scm_type'];
					$p_pm['export_address_seq'][$shipSeq]		= $oShipDe['shipping_address_seq'];
					
					// 필수옵션 출고 처리
					foreach($oShipDe['options'] as $item_option_seq=>$oShipDeOpt ){
						$iOptSeq = $oShipDeOpt['item_option_seq'];	// 변수명 간소화
						
						$p_pm['package_grouping_key'][]				= 'package-'.$iOptSeq;			// 출고완료
						
						if($oShipDeOpt['stock']!='미매칭'){
							$p_pm['optioninfo'][$shipSeq]['option'][$iOptSeq]			= $oShipDe['items'][$oShipDeOpt['item_seq']]['goods_data']['goods_seq'].'option'.$oShipDeOpt['option_seq'];
							$p_pm['whSupplyPrice'][$shipSeq]['option'][$iOptSeq]		= $oShipDeOpt['supply_price'];
							$p_pm['goodscode'][$shipSeq]['option'][$iOptSeq]			= $oShipDeOpt['goodscode'];
						}
						$p_pm['stock'][$shipSeq]['option'][$iOptSeq]				= $oShipDeOpt['stock'];
						$p_pm['autoWh'][$shipSeq]['option'][$iOptSeq]				= '0';
						$p_pm['request_ea'][$shipSeq]['option'][$iOptSeq]			= ($oShipDeOpt['stock']==='미매칭' && $not_match_goods_order == 'y')?'0':$oShipDeOpt['request_ea'];	// 실 출고 처리 수량
						$p_pm['shipping_goods_kind'][$shipSeq]['option'][$iOptSeq]	= 'OPT';

						// 미매칭 상품이고 미매칭의 상품의 강제 매칭 설정에 따라 수정
						$p_pm['not_match_goods_order'][$shipSeq]['option'][$iOptSeq] = ($oShipDeOpt['stock']==='미매칭')?$not_match_goods_order:'y';
												
						// 추가옵션 출고 처리 
						foreach($oShipDeOpt['suboptions'] as $item_suboption_seq=>$oShipDeSubOpt ){
							$iSubOptSeq = $oShipDeSubOpt['item_suboption_seq'];	// 변수명 간소화
						
							$p_pm['package_grouping_key'][]				= 'package-'.$iSubOptSeq;			// 출고완료
						
							if($oShipDeSubOpt['stock']!='미매칭'){
								$p_pm['optioninfo'][$shipSeq]['suboption'][$iSubOptSeq]				= $oShipDe['items'][$oShipDeOpt['item_seq']]['goods_data']['goods_seq'].'suboption'.$iSubOptSeq;
								$p_pm['whSupplyPrice'][$shipSeq]['suboption'][$iSubOptSeq]			= $oShipDeSubOpt['supply_price'];
								$p_pm['goodscode'][$shipSeq]['suboption'][$iSubOptSeq]				= $oShipDeSubOpt['goodscode'];
							}
							$p_pm['stock'][$shipSeq]['suboption'][$iSubOptSeq]					= $oShipDeSubOpt['stock'];
							$p_pm['autoWh'][$shipSeq]['suboption'][$iSubOptSeq]					= '0';
							$p_pm['request_ea'][$shipSeq]['suboption'][$iSubOptSeq]				= ($oShipDeSubOpt['stock']==='미매칭' && $not_match_goods_order == 'y')?0:$oShipDeSubOpt['request_ea'];	// 실 출고 처리 수량
							$p_pm['shipping_goods_kind'][$shipSeq]['suboption'][$iSubOptSeq]	= 'SUB';

							// 미매칭 상품이고 미매칭의 상품의 강제 매칭 설정에 따라 수정
							$p_pm['not_match_goods_order'][$shipSeq]['suboption'][$iSubOptSeq] = ($oShipDeSubOpt['stock']==='미매칭')?$not_match_goods_order:'y';
						}
					}
					
				}
			}
		}
		$post_params = $p_pm;
		
		// ===========================================================================
		// 출고 데이터 생성 시작
		// ===========================================================================
		$this->CI->load->library('exportlibrary');
		$post_params = $this->CI->exportlibrary->make_order_export($post_params);
		// ===========================================================================
		// 출고 데이터 생성 종료
		// ===========================================================================
		
		
		// ===========================================================================
		// 출고 처리 시작
		// ===========================================================================
		$this->CI->load->library('exportlibrary');
		unset($out);
		$out = array();		
		$this->CI->managerInfo['mname'] = 'O2O시스템';
		$post_params['library_call_type'] = 'o2o';
		$this->CI->exportlibrary->proc_order_export_exec($post_params, '', '', $out);

		// 로그 생성
		if($out['result_check'] || $out['cnt_export_error_45']>0 || $out['cnt_export_error_45']>0){
			writeCsLog($out, "o2o", "pos_".$this->CI->o2oConfig['o2o_store_seq']);
		}

		// ===========================================================================
		// 출고 처리 종료
		// ===========================================================================
	}
	
	// O2O 전용 배송완료 처리
	public function proc_o2o_order_batch_status($order_seq, $target_wh = 1) {
		if(!$this->checkO2OService){return $this->checkO2OService;}
		$this->CI->managerInfo['mname'] = 'O2O시스템';
		
		// ===========================================================================
		// 배송 데이터 추출용 쿼리 생성 시작
		// ===========================================================================
		$this->CI->load->library('exportlibrary');
		unset($params);
		$params['search_type']				= 'order_seq';
		$params['keyword']					= $order_seq;
		$export_data = $this->CI->exportlibrary->get_order_batch_status_data($params);
		// ===========================================================================
		// 배송 데이터 추출용 쿼리 생성 종료
		// ===========================================================================
		
		// 출고 제한 정보 세팅
		$provider_seq = '1';	// O2O 주문은 입점사만 가능
		$data_provider = $this->CI->providermodel->get_provider($provider_seq);
		$stockable = $data_provider['default_export_stock_check'];
		$ticket_stockable = $data_provider['default_export_ticket_stock_check'];

		// 배송용 데이터 가공
		$p_pm = array();
		if($export_data){
			foreach($export_data as $export_code=>$data_export){
				$p_pm['status']										= '65';
				$p_pm['export_date']								= date("Y-m-d");
				$p_pm['stockable']									= $stockable;
				$p_pm['scm_wh']										= $target_wh;
				$p_pm['export_code'][]								= $export_code;
				$p_pm['shipping_provider_seq'][$export_code]		= $data_export['shipping_provider_seq']; // 출고입점사 고유키
				$p_pm['export_shipping_group'][$export_code]		= $data_export['shipping_group']; // 출고 배송 그룹 고유키
				$p_pm['export_shipping_method'][$export_code]		= $data_export['shipping_method']; // 출고 배송 방법 | direct_store : 매장수령
				$p_pm['export_shipping_set_name'][$export_code]		= $data_export['shipping_set_name']; // 출고 배송명
				$p_pm['delivery_company'][$export_code]				= 'code0'; // 택배사코드
				$p_pm['delivery_number'][$export_code]				= ''; // 운송번호
				$p_pm['export_store_scm_type'][$export_code]		= $data_export['store_scm_type']; // 출고 SCM 연결 여부
				$p_pm['export_address_seq'][$export_code]			= $data_export['shipping_address_seq']; // 출고 매장 수령 고유키
			}
		}
		$post_params = $p_pm;
		
		
		// ===========================================================================
		// 배송완료 처리 시작
		// ===========================================================================
		$this->CI->load->library('exportlibrary');
		unset($out);
		$out = array();		
		$this->CI->managerInfo['mname'] = 'O2O시스템';
		$this->CI->exportlibrary->proc_order_batch_status($post_params, $out);

		// 로그 생성
		if($out['err_cnt'] > 0){
			writeCsLog($out, "o2o", "pos_".$this->CI->o2oConfig['o2o_store_seq']);
		}

		// ===========================================================================
		// 배송완료 종료
		// ===========================================================================
	}
	/**
	 * O2O 전용 주문 취소 & 환불 & 반품 포함
	 * 부분취소, 부분반품 기능 없음
	 *	[프로세스]
	 *		O2O 전용 배송그룹 호출
	 *		주문 마스터 생성
	 *		배송그룹 추출
	 *		주문 배송그룹 저장
	 *		주문 아이템 저장
	 * @param type $post_params
	 * @return type
	 */
	public function refund_o2o_order(&$msg, $post_params) {
		if(!$this->checkO2OService){return $this->checkO2OService;}
		$this->CI->managerInfo['mname'] = 'O2O시스템';
		$arr_refund_code = array();
		$order_seq = $post_params['order_seq'];
		
		// 기 취소 체크
		$this->CI->load->library('orderlibrary');
		unset($orderCheckParams);
		$orderCheckParams['order_seq']				= $order_seq;
		$orderCheckParams['linkage_id']				= 'pos';
		$orderCheckParams['linkage_order_id']		= $post_params['pos_order_seq'];	// 추후 샵링커등 연동시 주문번호로 사용
		$orderCheckParams['linkage_mall_code']		= $this->CI->o2oConfig['o2o_store_seq'];
		$dup_order = $this->CI->orderlibrary->get_order($orderCheckParams);
		if(empty($dup_order['order_seq'])){
			$msg = '취소 대상이 없는 POS 주문번호입니다.';
			return '';
		}elseif(in_array($dup_order['step'],array('00','85','95','99'))){
			// 결제취소 상태인 경우
			$msg = '기취소된 POS 주문번호입니다.';
			return '';
		}
		
		//  반품 가능한 아이템을 모두 반품 -> 취소 가능 아이템을 모두 취소 -> 환불 처리
		
		// ===========================================================================
		// 반품 신청 가공 시작
		// ===========================================================================
		// 반품 가능 아이템 조회
		$this->CI->load->library('returnlibrary');
		$this->CI->returnlibrary->allow_exit = false;
		$this->CI->session->set_userdata('manager',array('manager_seq'=>0));
		// api에서는 echo 및 스크립트 불필요
		ob_start();
		$return_able_order_list = $this->CI->returnlibrary->get_order_for_return($order_seq);
		$ob_msg = ob_get_contents();
		ob_end_clean();	// 출력버퍼 지우고 종료
		if(empty($return_able_order_list['loop'])){
				writeCsLog($ob_msg, "o2o", "pos_".$this->CI->o2oConfig['o2o_store_seq']);
		}
		unset($ob_msg);
		
		
		// 반품용 데이터 가공
		$mode = '';	// exchange : 맞교환
		$p_pm = array();
		if($return_able_order_list['loop']){
			$p_pm['order_seq']									= $order_seq;
			$p_pm['chk_shipping_seq']							= '1';
			$p_pm['reason']										= $return_able_order_list['reasonLoop'][0]['codecd']; // 120
			$p_pm['reason_desc']								= $return_able_order_list['reasonLoop'][0]['reason']; // 사이즈가 맞지 않아요1
			$p_pm['reason_detail']								= ''; // 
			$p_pm['cellphone'][]								= $return_able_order_list['orders']['order_cellphone'][0]; // 010
			$p_pm['cellphone'][]								= $return_able_order_list['orders']['order_cellphone'][1]; // 9488
			$p_pm['cellphone'][]								= $return_able_order_list['orders']['order_cellphone'][2]; // 6536
			$p_pm['phone'][]									= $return_able_order_list['orders']['order_phone'][0]; // 02
			$p_pm['phone'][]									= $return_able_order_list['orders']['order_phone'][1]; // 
			$p_pm['phone'][]									= $return_able_order_list['orders']['order_phone'][2]; // 
			$p_pm['return_method']								= 'user'; // user
			$p_pm['return_recipient_zipcode'][]					= $return_able_order_list['orders']['recipient_new_zipcode']; // 05118
			$p_pm['return_recipient_address_type']				= ''; // 
			$p_pm['return_recipient_address_street']			= $return_able_order_list['orders']['recipient_address_street']; // 서울특별시 광진구 광나루로56길 32 (구의현대2단지아파트)
			$p_pm['return_recipient_address']					= $return_able_order_list['orders']['recipient_address']; // 서울특별시 광진구 구의동 611 구의현대2단지아파트
			$p_pm['return_recipient_address_detail']			= $return_able_order_list['orders']['recipient_address_detail']; // 상세주소
			$bankCode = code_load('bankCode');
			$p_pm['bank']										= $bankCode[0]['codecd']; // 10
			$p_pm['depositor']									= ''; // 
			$p_pm['account'][]									= ''; // 
			$p_pm['account'][]									= ''; // 
			$p_pm['account'][]									= ''; // 
			$p_pm['refund_ship_type']							= 'D'; // 
			$p_pm['shipping_price_bank_account']				= ''; // 
			$p_pm['shipping_price_depositor']					= ''; // 
			
			foreach($return_able_order_list['loop'] as $loop){
				$p_pm['chk_shipping_group_address'][]			= ': (반송주소) '.$loop['shipping_provider']['deli_zipcode'].' '.htmlspecialchars($loop['shipping_provider']['deli_address1']).' '.htmlspecialchars($loop['shipping_provider']['deli_address2']);
				
				foreach($loop['export_item'] as $export_item){
					if($export_item['rt_ea']){
						$p_pm['chk_seq'][]								= '1';
						$p_pm['chk_item_seq'][]							= $export_item['item_seq'];
						$p_pm['chk_option_seq'][]						= $export_item['item_option_seq'];
						if($export_item['opt_type'] == 'sub'){
							$chk_suboption_seq = $export_item['option_seq'];
						}else{
							$chk_suboption_seq = '';
						}
						$p_pm['chk_suboption_seq'][]					= $chk_suboption_seq;
						$p_pm['chk_export_code'][]						= $export_item['export_code'];
						$p_pm['chk_individual_return'][]				= $export_item['individual_return'];
						if($mode == 'exchange' || $export_item['shiping_free_yn'] == 'Y'){
							$pay_shiping_cost = $export_item['swap_shiping_cost'];
						}else{
							$pay_shiping_cost = $export_item['refund_shiping_cost'];
						}
						$p_pm['pay_shiping_cost'][]						= $pay_shiping_cost; // 0.00
						$p_pm['mode']									= ''; // 

						$p_pm['input_chk_ea'][]							= $export_item['rt_ea']; // 3
						$p_pm['chk_ea'][]								= $export_item['rt_ea']; // 3
					}
				}
			}
		}
		// 반품 가능 수량 체크
		$albe_return = false;
		if(array_sum($p_pm['input_chk_ea']) > 0){
			$albe_return = true;
		}
		$post_params = $p_pm;
		// ===========================================================================
		// 반품 신청 가공 종료
		// ===========================================================================
		
		if($albe_return){
			// ===========================================================================
			// 반품 신청 시작
			// ===========================================================================
			$this->CI->load->library('returnlibrary');
			$this->CI->returnlibrary->allow_exit = false;
			$this->CI->session->set_userdata('manager',array('manager_seq'=>0));
			// api에서는 echo 및 스크립트 불필요
			ob_start();
			$return_code_info = $this->CI->returnlibrary->proc_order_return($post_params,false);
			$ob_msg = ob_get_contents();
			ob_end_clean();	// 출력버퍼 지우고 종료

			// 로그 생성
			if(empty($return_code_info['return_code']) || empty($return_code_info['refund_code'])){
				writeCsLog($ob_msg, "o2o", "pos_".$this->CI->o2oConfig['o2o_store_seq']);
			}
			unset($ob_msg);	
			
			// ===========================================================================
			// 반품 신청 종료
			// ===========================================================================
			$return_code = $return_code_info['return_code'];
			$refund_code = $return_code_info['refund_code'];
			$arr_refund_code[] = $refund_code;
			
			// ===========================================================================
			// 반품 처리 가공 시작
			// ===========================================================================
			// 반품 요청된 내역 처리
			$this->CI->load->library('returnlibrary');
			$this->CI->returnlibrary->allow_exit = false;
			$this->CI->session->set_userdata('manager',array('manager_seq'=>0));
			// api에서는 echo 및 스크립트 불필요
			ob_start();
			$return_view = $this->CI->returnlibrary->get_return($return_code);
			$ob_msg = ob_get_contents();
			ob_end_clean();	// 출력버퍼 지우고 종료
			// 로그 생성
			if(empty($return_view['data_return_item'])){
				writeCsLog($ob_msg, "o2o", "pos_".$this->CI->o2oConfig['o2o_store_seq']);
			}
			unset($ob_msg);	
			
			// 미연결창고 상태 체크
			$not_connect_scm = $this->get_store_connect_scm();
			
			// 반품처리용 데이터 가공
			$p_pm = array();
			if($return_view['data_return_item']){
				$p_pm['return_code']				= $return_view['data_return']['return_code']; //R1810221545
				$p_pm['return_type']				= $return_view['data_return']['return_type']; //return
				$p_pm['order_seq']					= $return_view['data_return']['order_seq']; //2018102215333117538
				$p_pm['not_connect_scm']			= $not_connect_scm; // o2o 창고의 미연결 상태 Y:미연결
				
				$p_pm['cellphone'][]				= $return_view['data_return']['cellphone'][0]; //010
				$p_pm['cellphone'][]				= $return_view['data_return']['cellphone'][1]; //9488
				$p_pm['cellphone'][]				= $return_view['data_return']['cellphone'][2]; //6536
				$p_pm['phone'][]					= $return_view['data_return']['phone'][0]; //
				$p_pm['phone'][]					= $return_view['data_return']['phone'][1]; //
				$p_pm['phone'][]					= $return_view['data_return']['phone'][2]; //
				
				$p_pm['return_method']				= 'user'; //user
				$senderZipcode = $return_view['data_return']['sender_zipcode'][0]; //05118
				if($return_view['data_return']['sender_zipcode'][1]){
					$senderZipcode .= '-'.$return_view['data_return']['sender_zipcode'][1];
				}
				$p_pm['senderZipcode'][]			= $senderZipcode;
				$p_pm['senderAddress_type']			= $return_view['data_return']['sender_address_type']; //
				$p_pm['senderAddress_street']		= $return_view['data_return']['sender_address_street']; //서울특별시 광진구 광나루로56길 32 (구의현대2단지아파트)
				$p_pm['senderAddress']				= $return_view['data_return']['sender_address']; //서울특별시 광진구 구의동 611 구의현대2단지아파트
				$p_pm['senderAddressDetail']		= $return_view['data_return']['sender_address_detail']; //상세주소
				$p_pm['return_reason']				= ($return_view['data_return']['return_reason'])?$return_view['data_return']['return_reason']:''; //
				$p_pm['admin_memo']					= $return_view['data_return']['admin_memo']; //
				$p_pm['refund_ship_type']			= 'D'; //M
				$p_pm['return_shipping_gubun']		= 'company'; //company
				$p_pm['return_shipping_price']		= '0'; //
				$p_pm['status']						= 'complete'; //complete

				foreach($return_view['data_return_item'] as $r_R_I){
					// 창고 정보 입력
					if($return_view['scm_cfg']['use'] == 'Y' && $this->CI->o2oConfig['scm_store']){
						$p_pm['scm_wh']		= $this->CI->o2oConfig['scm_store']; //2
					}
					
					// 창고정보가 있을 때만 옵션정보 입력
					if($p_pm['scm_wh']
						&& $return_view['scm_cfg']['use'] == 'Y'
						&& $r_R_I['provider_seq'] == '1' 
						&& $r_R_I['package_yn'] != 'y' && $r_R_I['optioninfo']
						){
						
						$p_pm['optioninfo'][$r_R_I['return_item_seq']]			= $r_R_I['optioninfo']; //441option509
					}
					
					// 창고정보에 따른 반품 수량이나 불량 수량 입력
					if($p_pm['scm_wh']
						&& $return_view['scm_cfg']['use'] == 'Y'
						&& $r_R_I['provider_seq'] == '1'
						){
						$p_pm['stock_return_ea'][$r_R_I['return_item_seq']]		= $r_R_I['ea']; //3
						$p_pm['return_badea'][$r_R_I['return_item_seq']]		= '0'; //0
					}else{
						$p_pm['stock_return_ea'][$r_R_I['return_item_seq']]		= $r_R_I['stock_return_ea']; //3
					}
					
					// 창고정보에 따른 반품 로케이션
					if($p_pm['scm_wh']
						&& $return_view['scm_cfg']['use'] == 'Y'
						){
						if($r_R_I['provider_seq'] == '1'){
							$p_pm['location_position'][$r_R_I['return_item_seq']]	= $r_R_I['location_position']; //1-1-1
							$p_pm['location_code'][$r_R_I['return_item_seq']]		= $r_R_I['location_code']; //1-1-1
						}else{
							// 입점사
						}
					}
					
					$p_pm['reason'][$r_R_I['return_item_seq']]					= $r_R_I['reasonLoop'][0]['codecd']; // 120
					$p_pm['reason_desc'][$r_R_I['return_item_seq']]				= $r_R_I['reasonLoop'][0]['reason']; // 사이즈가 맞지 않아요1
				}
				
				
			}
			$post_params = $p_pm;
			// ===========================================================================
			// 반품 처리 가공 종료
			// ===========================================================================
			
			
			// ===========================================================================
			// 반품 처리 시작
			// ===========================================================================
			// 반품 요청된 내역 처리
			$this->CI->load->library('returnlibrary');
			$this->CI->returnlibrary->allow_exit = false;
			$this->CI->session->set_userdata('manager',array('manager_seq'=>0));
			$this->CI->managerInfo['manager_seq'] = 0;
			// api에서는 echo 및 스크립트 불필요
			ob_start();
			$return_view = $this->CI->returnlibrary->proc_return_save($post_params, false);
			$ob_msg = ob_get_contents();
			ob_end_clean();	// 출력버퍼 지우고 종료

			// 로그 생성
			writeCsLog($ob_msg, "o2o", "pos_".$this->CI->o2oConfig['o2o_store_seq']);
			unset($ob_msg);	
			// ===========================================================================
			// 반품 처리 종료
			// ===========================================================================
		}
		
		
		
		// ===========================================================================
		// 주문 취소 처리 시작
		// ===========================================================================
		// 취소 가능 아이템 조회
		$this->CI->load->library('refundlibrary');
		$refund_able_order_list = $this->CI->refundlibrary->get_order_for_cancel($order_seq);
		
		// 취소용 데이터 가공
		$p_pm = array();
		if($refund_able_order_list){
			$p_pm['order_seq']									= $order_seq;
			$p_pm['cancel_type']								= 'partial';	// 부분취소로 처리
			$p_pm['refund_reason']								= '취소요청';	// 취소사유
			$p_pm['bank_name']									= '';	
			$p_pm['bank_depositor']								= '';	
			$p_pm['bank_account']								= '';	
			$p_pm['manual_refund_yn']							= 'y';	// 메뉴얼 취소 여부
			
			foreach($refund_able_order_list as $refund_able_order){
				foreach($refund_able_order['options'] as $refund_able_order_options){
					if(!empty($refund_able_order_options['able_refund_ea'])){
						$p_pm['chk_seq'][]									= 'on';
						$p_pm['chk_item_seq'][]								= $refund_able_order_options['item_seq'];
						$p_pm['chk_option_seq'][]							= $refund_able_order_options['item_option_seq'];
						$p_pm['chk_suboption_seq'][]						= 0;
						$p_pm['chk_individual_refund'][]					= $refund_able_order['individual_refund'];
						$p_pm['chk_individual_refund_inherit'][]			= $refund_able_order['individual_refund_inherit'];
						$p_pm['chk_individual_export'][]					= $refund_able_order['individual_export'];
						$p_pm['chk_individual_return'][]					= $refund_able_order['individual_return'];
						$p_pm['input_chk_ea'][]								= $refund_able_order_options['able_refund_ea'];
						$p_pm['chk_ea'][]									= $refund_able_order_options['able_refund_ea'];
					}
				}
				foreach($refund_able_order['suboptions'] as $refund_able_order_suboptions){
					if(!empty($refund_able_order_suboptions['able_refund_ea'])){
						$p_pm['chk_seq'][]									= 'on';
						$p_pm['chk_item_seq'][]								= $refund_able_order_options['item_seq'];
						$p_pm['chk_option_seq'][]							= 0;
						$p_pm['chk_suboption_seq'][]						= $refund_able_order_options['item_suboption_seq'];
						$p_pm['chk_individual_refund'][]					= $refund_able_order['individual_refund'];
						$p_pm['chk_individual_refund_inherit'][]			= $refund_able_order['individual_refund_inherit'];
						$p_pm['chk_individual_export'][]					= $refund_able_order['individual_export'];
						$p_pm['chk_individual_return'][]					= $refund_able_order['individual_return'];
						$p_pm['input_chk_ea'][]								= $refund_able_order_options['able_refund_ea'];
						$p_pm['chk_ea'][]									= $refund_able_order_options['able_refund_ea'];
					}
				}
			}
		}
		$post_params = $p_pm;
		
		
		// 취소 가능 수량 체크
		$albe_refund = false;
		if(array_sum($p_pm['input_chk_ea']) > 0){
			$albe_refund = true;
		}
		
		if($albe_refund){
			$this->CI->load->library('refundlibrary');
			$this->CI->refundlibrary->allow_exit = false;
			$this->CI->session->set_userdata('manager',array('manager_seq'=>0));
			// api에서는 echo 및 스크립트 불필요
			ob_start();
			$refund_code = $this->CI->refundlibrary->proc_order_refund($post_params,false);
			$ob_msg = ob_get_contents();
			ob_end_clean();	// 출력버퍼 지우고 종료

			// 로그 생성
			if(empty($refund_code)){
				writeCsLog($ob_msg, "o2o", "pos_".$this->CI->o2oConfig['o2o_store_seq']);
			}
			$arr_refund_code[] = $refund_code;
			unset($ob_msg);	
		}
		// ===========================================================================
		// 주문 취소 처리 종료
		// ===========================================================================
		
		

		// ===========================================================================
		// 환불 처리 시작
		// ===========================================================================
		
		// 취소 신청과 반품 신청으로 인해 발생한 환불 내역을 처리
		foreach($arr_refund_code as $refund_code){
			if(trim($refund_code)){
				// 결제취소(환불) 요청된 내역 처리
				$this->CI->load->library('refundlibrary');
				$this->CI->refundlibrary->allow_exit = false;
				$this->CI->session->set_userdata('manager',array('manager_seq'=>0));
				// api에서는 echo 및 스크립트 불필요
				ob_start();
				$refund_view = $this->CI->refundlibrary->get_refund($refund_code);
				$ob_msg = ob_get_contents();
				ob_end_clean();	// 출력버퍼 지우고 종료
				// 로그 생성
				if(empty($refund_view['refund_total_rows'])){
					writeCsLog($ob_msg, "o2o", "pos_".$this->CI->o2oConfig['o2o_store_seq']);
				}
				unset($ob_msg);	


				// 환불용 데이터 가공
				$p_pm = array();
				if($refund_view){
					$p_pm['order_seq']									= $refund_view['data_order']['order_seq']; //2018101915063917566
					$p_pm['top_orign_order_seq']						= $refund_view['data_order']['top_orign_order_seq']; //
					$p_pm['refund_code']								= $refund_code; //C18101915225
					$p_pm['tot_price']									= $refund_view['tot']['price']; //22000
					$p_pm['tot_refund_goods_shipping_cost']				= $refund_view['tot']['refund_goods_shipping_cost']; //
					$p_pm['tot_member_sale']							= $refund_view['tot']['member_sale']; //0
					$p_pm['tot_coupon_sale']							= $refund_view['tot']['coupon_sale']; //0
					$p_pm['tot_fblike_sale']							= $refund_view['tot']['fblike_sale']; //0
					$p_pm['tot_mobile_sale']							= $refund_view['tot']['mobile_sale']; //0
					$p_pm['tot_referer_sale']							= $refund_view['tot']['referer_sale']; //0
					$p_pm['tot_promotion_code_sale']					= $refund_view['tot']['promotion_code_sale']; //0
					$p_pm['order_shipping_cost']						= $refund_view['data_order']['real_shipping_cost']; //0.00
					$p_pm['refund_shipping_cost']						= $refund_view['tot']['refund_shipping_cost']; //0
					$p_pm['order_coupon_sale']							= $refund_view['data_order']['coupon_sale']; //
					$p_pm['order_emoney']								= $refund_view['data_order']['emoney']; //0.00
					$p_pm['order_enuri']								= $refund_view['data_order']['enuri']; //0.00
					$p_pm['cancel_type']								= $refund_view['data_refund']['cancel_type']; //full
					$p_pm['refund_type']								= $refund_view['data_refund']['refund_type']; //cancel_payment
					$p_pm['return_reserve']								= ($refund_view['data_refund']['refund_type']=='return')?$refund_view['tot']['return_reserve']:"0"; //
					$p_pm['return_point']								= ($refund_view['data_refund']['refund_type']=='return')?$refund_view['tot']['return_point']:"0"; //
					$p_pm['refund_version']								= '1'; //
					$p_pm['refund_reason']								= $refund_view['data_refund']['refund_reason']; //취소요청
					$p_pm['refund_method']								= 'bank'; //bank
					$p_pm['refund_emoney_limit_type']					= 'n'; //2018-10-19 15:07:01
					$p_pm['refund_emoney_limit_date']					= ''; //2018-10-19 15:07:01

					foreach($refund_view['refund_shipping_items'] as $r_S_I){
						$p_pm['refund_delivery_price_tmp'][$r_S_I['return_shipping']['shipping_seq']]				= $r_S_I['return_shipping_cost']; //0
						if($r_S_I['shipping']['refund_delivery_cash'] > 0){
							$p_pm['refund_delivery_cash_tmp'][$r_S_I['return_shipping']['shipping_seq']]				= $r_S_I['shipping']['refund_delivery_cash']; //0
						}else{
							$p_pm['refund_delivery_cash_tmp'][$r_S_I['return_shipping']['shipping_seq']]				= $r_S_I['shipping']['cash_sale_unit'] + $r_S_I['shipping']['cash_sale_rest']; //0
						}
						foreach($r_S_I['items'] as $items){
							$p_pm['refund_provider_seq'][$items['refund_item_seq']]				= $items['provider_seq']; //1
							$p_pm['refund_ea'][$items['refund_item_seq']]						= $items['ea']; //3
							$p_pm['refund_item_for_ship'][$r_S_I['shipping']['shipping_seq']]	= $r_S_I['return_shipping'][$items['shipping_seq']]; //399
							$p_pm['refund_item_seq'][]											= $items['refund_item_seq']; //398
							$p_pm['refund_npay_product_order_id'][$items['refund_item_seq']]	= $items['npay_product_order_id']; //
							
							if(($items['refund_emoney_sale_unit'] * $items['ea']) > 0){
								$p_pm['refund_emoney_tmp'][$items['refund_item_seq']]				= $items['refund_emoney_sale_unit'] * $items['ea']; //0
							}else{
								$p_pm['refund_emoney_tmp'][$items['refund_item_seq']]				= ($items['emoney_sale_unit'] * $items['ea']) + $items['emoney_sale_rest']; //0
							}
							
							if(($items['refund_cash_sale_unit'] * $items['ea']) > 0){
								$p_pm['refund_cash_tmp'][$items['refund_item_seq']]				= $items['refund_cash_sale_unit'] * $items['ea']; //0
							}else{
								$p_pm['refund_cash_tmp'][$items['refund_item_seq']]				= ($items['cash_sale_unit'] * $items['ea']) + $items['cash_sale_rest']; //0
							}
							
							// 사용된 쿠폰 정보 모두 반환
							$p_pm['refund_goods_coupon'][$items['refund_item_seq']]				= $items['refund_goods_coupon']; //0
							$p_pm['refund_delivery_coupon'][$items['refund_item_seq']]			= $items['refund_delivery_coupon']; //0
							$p_pm['refund_goods_promotion'][$items['refund_item_seq']]			= $items['refund_goods_promotion']; //0
							$p_pm['refund_delivery_promotion'][$items['refund_item_seq']]		= $items['refund_delivery_promotion']; //0
							
							// 최종 반환 금액
							$p_pm['refund_goods_price'][$items['refund_item_seq']]				= ($items['price']*$items['option_ea']) - $items['total_sale'] - $p_pm['refund_emoney_tmp'][$items['refund_item_seq']] - $p_pm['refund_cash_tmp'][$items['refund_item_seq']]; //6,000
						}
					}
					// 주문서쿠폰 반환
					$p_pm['refund_ordersheet']							= $refund_view['data_order']['use_ordersheetcoupon']['download_seq']; //0
					
					$p_pm['complete_price']								= $refund_view['tot']['refund_complete_total']; //0
					$p_pm['refund_emoney']								= array_sum($p_pm['refund_emoney_tmp']); //0
					$p_pm['refund_cash']								= array_sum($p_pm['refund_cash_tmp']); //0
					$p_pm['refund_shipping_price']						= $refund_view['data_refund']['return_shipping_price']; //0
					$p_pm['refund_price']								= $refund_view['data_refund']['refund_total_price'] + array_sum($p_pm['refund_emoney_tmp']) + array_sum($p_pm['refund_cash_tmp']);//22000
					$p_pm['status']										= 'complete'; //complete
				}
				$post_params = $p_pm;

				// 결제취소(환불) 요청된 내역 처리
				$this->CI->load->library('refundlibrary');
				$this->CI->refundlibrary->allow_exit = false;
				$this->CI->session->set_userdata('manager',array('manager_seq'=>0));
				// api에서는 echo 및 스크립트 불필요
				ob_start();
				$refund_view = $this->CI->refundlibrary->proc_refund_save($post_params, false);
				$ob_msg = ob_get_contents();
				ob_end_clean();	// 출력버퍼 지우고 종료

				// 로그 생성
				writeCsLog($ob_msg, "o2o", "pos_".$this->CI->o2oConfig['o2o_store_seq']);
				unset($ob_msg);	
			}
		}
		// ===========================================================================
		// 환불 처리 종료
		// ===========================================================================
		
		
		return $order_seq;
	}
	
	/*
	 * o2o 창고의 올인원 사용 시 연결되어있는 창고 확인
	 */
	function get_store_connect_scm(){
		// 미연결창고 상태 체크
		$not_connect_scm = '';
		// 올인원버전을 사용하나 o2o 창고가 미연결창고인 경우 출고 시 재고 체크 및 재고를 차감하지 않음.
		if	(!$this->CI->scm_cfg)	$this->CI->scm_cfg	= config_load('scm');
		if($this->CI->scm_cfg['use'] == 'Y' && empty($this->CI->o2oConfig['scm_store'])){
			$not_connect_scm = 'Y';
		}
		return $not_connect_scm;
	}
	
}