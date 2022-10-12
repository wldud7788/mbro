<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/o2o/base/api_base".EXT);

class api extends api_base {
	protected $o2o_pos_info = array();
	public $o2oConfig = array();
	
	public function __construct() {
		// api_base 호출
		parent::__construct();
		$this->load->library('o2o/o2oservicelibrary');
		$this->load->library('o2o/o2oorderlibrary');
		
		// O2O 환경 체크 false : 일반 접속, true : 오프라인 요청
		// 해당 변수를 o2o 서비스가 시작되면 갱신함
		// common_base에서 선언함
		$this->o2o_pos_env = true;
		
		// 인증 시작문자
		$this->auth_text = $this->o2oservicelibrary->auth_text;
		
		// 허가 메소드 추가
		$this->allowMethod['connectCheck']		= array(self::POST_METHOD);
		$this->allowMethod['members']			= array(self::POST_METHOD);
		$this->allowMethod['benefit']			= array(self::POST_METHOD);
		$this->allowMethod['orders']			= array(self::POST_METHOD);
		$this->allowMethod['ordersCancel']		= array(self::POST_METHOD);
		$this->allowMethod['getStock']			= array(self::POST_METHOD);
		$this->allowMethod['setContracts']		= array(self::POST_METHOD);
		
		// 필수 파라미터 추가
		$this->api_validation['getToken']			= array();
		$this->api_validation['connectCheck']		= array();
		$this->api_validation['members']			= array();
		$this->api_validation['benefit']			= array('cart' => array('barcode', 'price', 'org_price', 'ea'));
		$this->api_validation['orders']				= array(
													'pos_order_seq',		// POS 주문 PK - 중복처리방지용
													'settle_price',			// 실제 결제 금액
													'org_settle_price',		// 할인 전 총 주문 금액
													'regist_date',			// 주문일시
													'order_item' => array(	// 아이템 정보
														'barcode',				// 상품 고유 바코드
														'goods_name',			// 상품명
														'ea',					// 수량
														'price',				// 상품단가
														'org_price',			// 상품의 판매가(할인 미적용 단가)
														'cost',					// 상품의 원가
													)
												);
		$this->api_validation['ordersCancel']		= array(
													'order_seq',			// O2O 주문 PK
													'pos_order_seq',		// POS 주문 PK - 중복처리방지용
												);
		$this->api_validation['getStock']			= array('barcode');
		$this->api_validation['setContracts']		= array('pos_code', 'store_seq', 'pos_seq', 'contracts_status');
		
		// 해당 정보는 Config 에서 가져와서 처리 될 수 있도록 변경 예정
		$this->o2o_pos_info = json_decode($this->o2oservicelibrary->o2o_system_info['o2o_pos_info'], true);
				
		// 할인 목록 : unit_ordersheet 의 경우 총액일 때만 쿠폰에 가산, 개별일 경우엔 이미 계산되어 있음.
		$this->arr_sale_list = array('event', 'multi', 'member', 'mobile', 'fblike', 'promotion_code', 'coupon', 'referer'); // , 'unit_ordersheet'
		
		// API base 호출
		$this->init();
	}
	
	// 토큰 발행
	public function getToken(){
		// 토큰 발행 방식이 아닌 연동키를 이용한 방식
		$this->throwTokenAuthError(2);
	}
	
	// 토큰 만료 및 정상 여부 확인
	public function checkToken(){
		$check_token = true;
		// 계약 결과 저장 시에는 토큰 체크 제외
		if($this->router->method=="setContracts"){
			$check_token = false;
		}
		
		try {
			if($check_token){
				$headers = $this->input->request_headers();
				$authorization = $headers['authorization'];
				if(empty($authorization)){
					$authorization = $headers['Authorization'];
				}
				if (!empty($authorization)){
					$filter_authorization = $authorization;
					if($this->auth_text){
						if(strpos($authorization, $this->auth_text)===false){
							$this->throwTokenAuthError(4);
						}else{
							$filter_authorization = str_replace($this->auth_text." ", "", $authorization);
						}
					}
					
					$tmp_o2o_auth_info = explode("_", $filter_authorization);
					$o2o_auth_info = array();
					if(count($tmp_o2o_auth_info)==3){
						$o2o_auth_info = array(
							'store_seq'		=> $tmp_o2o_auth_info[0],
							'pos_seq'		=> $tmp_o2o_auth_info[1],
							'pos_key'		=> $tmp_o2o_auth_info[2],
						);
					}
					
					// o2o 설정 확인
					$this->o2oConfig = $this->check_o2o_config($o2o_auth_info);
				}else{
					$this->throwTokenAuthError(3);
				}
			}
		} catch (Exception $ex) {
			$this->throwTokenAuthError(5);
		}
	}
	
	// o2o 설정 확인
	protected function check_o2o_config($o2o_auth_info){
		$o2oConfig = $this->o2oservicelibrary->check_o2o_service($o2o_auth_info);
		if(empty($o2oConfig) ){
			$this->throwTokenAuthError(6);
		}
		return $o2oConfig;
	}

	// API 연동 확인
	public function connectCheck(){
		$this->response('1','성공',$this->o2oConfig);
	}
	
	// 회원정보 조회
	public function members(){
		$result['code']		= "0";
		$result['msg']		= "";
		
		$phone = $this->input->post('phone');
		$member_barcode = $this->input->post('member_barcode');
		
		if(empty($phone) && empty($member_barcode)
			|| (!empty($phone) && strlen($phone)!='13' && strlen($phone)!='14' && strlen($phone)!='4')){
			$result['msg'] = '요청 데이터가 없습니다.';
		}else{
			// 핸드폰번호 기준으로 회원 정보 얻기
			$arr_member_info = $this->o2oservicelibrary->get_member_info(array('cellphone'=>$phone), 'all');
			// 바코드 기준으로 회원 정보 얻기
			if($member_barcode){
				$arr_member_info = $this->o2oservicelibrary->get_member_info_by_barcode(array('member_barcode'=>$member_barcode), 'all');
				
				// 조회의 경우 중복데이터가 같이 반환되기에 방문일 갱신 프로세스 제거
				// 단 바코드의 경우 고유한 회원만 반환 되기에 방문일 프로세스 추가
				if($arr_member_info['result'][0]['member_seq']){
					// 최종 방문일 갱신 및 매장명 업데이트
					$this->load->library('memberlibrary');
					$this->memberlibrary->make_login_history($arr_member_info['result'][0]['member_seq'], $this->o2oConfig['pos_name']);
				}
			}
			
			// 쿠폰정보 조회 - 쿠폰 고유키 계산
			$this->load->library('o2o/o2obarcodelibrary');
			$res_member = array();
			if($arr_member_info['result']){
				foreach($arr_member_info['result'] as $member_info){

					// 불필요 데이터 제거
					$res_member_info['group_name']		= $member_info['group_name'];
					$res_member_info['member_seq']		= $member_info['member_seq'];
					// 고유키를 바코드로 회원 역산
					$res_member_info['member_barcode']	= "".$this->o2obarcodelibrary->encode_barcode_member($member_info['member_seq']);
					$res_member_info['user_name']		= $member_info['user_name'];
					$res_member_info['email']			= $member_info['email'];
					$res_member_info['phone']			= $member_info['cellphone'];
					$res_member_info['zipcode']			= $member_info['zipcode'];
					$res_member_info['address_street']	= $member_info['address_street'];
					$res_member_info['address_detail']	= $member_info['address_detail'];
					$res_member_info['emoney']			= $member_info['emoney'];
					$res_member_info['cash']			= $member_info['cash'];

					// kicc 디코딩 시 null 반환 처리를 못 하여 기본 값을 ''로 지정
					$default_res_member_info_key = array('emoney'=>'0.00', 'cash'=>'0.00');
					foreach($res_member_info as $res_member_info_key => &$res_member_info_val){
						if(is_null($res_member_info_val)){
							if($default_res_member_info_key[$res_member_info_key]){
								$res_member_info_val = $default_res_member_info_key[$res_member_info_key];
							}else{
								$res_member_info_val = '';
							}
						}
					}

					$res_member['member'][] = $res_member_info;
				}
				if(count($res_member['member'])>0){
					$result['code'] = '1';
				}
			}else{
				$result['msg'] = '일치하는 데이터가 없습니다.';
			}
		}

		$this->response($result['code'], $result['msg'], $res_member);
	}
	// 할인 혜택 적용 조회
	public function benefit(){
		
		$this->load->library('sale');
		$this->load->model('couponmodel');
		$this->load->model('membermodel');
		$this->load->model('goodsmodel');
		
		$result['code']		= "0";
		$result['msg']		= "";
		$result['data']		= null;
		$result_data		= array(
								'member_seq'				=> '0'
								, 'user_name'				=> ''
								, 'emoney'					=> '0'
								, 'emoney_use_limit'		=> '0'
								, 'emoney_price_limit'		=> '0'
								, 'min_emoney'				=> '0'
								, 'max_emoney'				=> '0'
								, 'emoney_using_unit'		=> '0'
								, 'cash'					=> '0'
								, 'cart_coupon_seq'			=> '0'
								, 'cart_coupon_title'		=> ''
							);		// 결과 구성용 임시 변수, 모든 처리가 완료된 후 결과 변수($result['data'])에 담는다.
		$result_member		= false;		// 회원정보 조회 여부
		$member_cach		= 0;			// 회원 소유 예치금
		$result_condition	= false;	// 마일리지 & 예치금 조건 조회 여부
		$result_coupon		= false;		// 쿠폰정보 조회 여부
		
		// 파라미터 수신
		$member_barcode			= $this->input->post('member_barcode');
		$member_barcode			= trim(str_replace(' ', '', $member_barcode));
		
		$coupon_barcode			= $this->input->post('coupon_barcode');
		$coupon_barcode			= trim(str_replace(' ', '', $coupon_barcode));
		
		$cart					= $this->input->post('cart');
		
		// 카트 데이터 초기화
		foreach($cart as &$goods){

			$goods['shop_price']			= '0';
			// $goods['shop_price_rest']		= '0';
			$goods['shop_org_price']		= '0';

			foreach($this->arr_sale_list as $sale_name){
				// case1을 사용하건 case2를 사용하건 실제 처리에는 관계 없으나 
				// POS에서 개별처리의 난점이 예상되어 합산값인 case2을 전달
				
				// case1. 할인 내역은 각 상품별 총 할인액을 전달
				// if($sale_name == 'unit_ordersheet'){	// 주문서쿠폰은 별도 가산
				// }else{
				// 	$goods[$sale_name.'_sale']		= '0';
				// }
				
				// case2. 할인 내역은 각 상품별 할인 및 나머지를 전달
				$goods[$sale_name.'_sale_unit']		= '0';
				$goods[$sale_name.'_sale_rest']		= '0';
			}
		}
		unset($goods);
		$result_data['cart']	= $cart;
		// 장바구니를 상품 금액이 큰 순서로 재정렬
		// 중복할인 예외일때 상품금액이 클 경우 할인 금액이 제일 크므로 첫 상품에 쿠폰을 적용하게된다.
		// 이 때 상품금액은 pos에서 전달하는 금액으로 실제 상품금액과 차이가 있을 수 있으니 향후 문제 될 경우 검토
		$cart = array_sort($cart, 'price', SORT_DESC);
		
		// 주문 총액 
		$pos_total_price = 0;
		foreach($cart as $goods){
			$pos_total_price += $goods['price'] * $goods['ea'];
		}
		
		// 회원정보와 바코드 정보가 모두 없다면 validation 에러 처리
		if(empty($member_barcode) && empty($coupon_barcode)){
			$this->throwVaildationError("phone or coupon_barcode");
		}
		
		// 마일리지 & 예치금 설정 정보 
		$reserves = ($this->reserves)?$this->reserves:config_load('reserve');
		
		// 혜택 정보 구성 - 마일리지 & 예치금
		$member_cach_condition = 'N';
		if($reserves){
			// 마일리지 정보 추가
			$mergeArray = array('emoney_use_limit', 'emoney_price_limit', 'min_emoney', 'max_emoney', 'emoney_using_unit');
			foreach($mergeArray as $key){
				$result_data[$key] = $reserves[$key];
			}
			// 예치금 정보 추가
			$member_cach_condition = $reserves['cash_use'];
			
			$result_condition = true;
		}
		
		if(!empty($coupon_barcode)){
			// 쿠폰정보 조회 - 쿠폰 고유키 계산
			$this->load->library('o2o/o2obarcodelibrary');
			$coupon_download_seq = $this->o2obarcodelibrary->decode_barcode($coupon_barcode);

			// 쿠폰 정보 구성 
			$downloads = null;
			if($coupon_download_seq){
				// 실제 사용 가능한지 여부 체크
				$sc['only_cart_goods']	= 'y';
				$sc['download_seq']		= $coupon_download_seq;
				$sc['use_status']		= 'unused';
				$sc['couponDate']		= array('available');
				$mycoupons				= $this->couponmodel->my_download_list($sc, true);
				$downloads = $mycoupons['result'][0];
				if($downloads){
					// 쿠폰 혜택 간이 계산이 아닌 calculate를 통해서 계산
					$result_data['cart_coupon_seq']		= $downloads['download_seq'];
					$result_data['cart_coupon_title']	= $downloads['coupon_name'];

					// 쿠폰을 소유하고 있을 경우 회원이므로 회원 혜택을 강제 적용
					if($downloads['member_seq']){
						$this->userInfo['member_seq'] = $downloads['member_seq'];
					}
				}
			}
		}
		
		// 회원정보 조회
		if($this->userInfo['member_seq']){
			// 쿠폰정보로 회원정보가 확인 되었을 경우 
			$tmp_memberInfo = $this->membermodel->get_member_data($this->userInfo['member_seq']);
			// 조회 정보 가공
			$memberInfo	= array(
				'code' => '1',
				'result' => array(
					'group_name'		=> $tmp_memberInfo['group_name'],
					'member_seq'		=> $tmp_memberInfo['member_seq'],
					'user_name'			=> $tmp_memberInfo['user_name'],
					'email'				=> $tmp_memberInfo['email'],
					'phone'				=> $tmp_memberInfo['cellphone'],
					'zipcode'			=> $tmp_memberInfo['zipcode'],
					'address_street'	=> $tmp_memberInfo['address_street'],
					'address_detail'	=> $tmp_memberInfo['address_detail'],
					'emoney'			=> $tmp_memberInfo['emoney'],
					'cash'				=> $tmp_memberInfo['cash'],
					'userid'			=> $tmp_memberInfo['userid'],
					'rute'				=> $tmp_memberInfo['rute'],
				),
				'msg' => "성공",
			);	
		}
		if(!empty($member_barcode)){	// 바코드 입력 시 바코드회원이 더욱 우선 처리
			$params['member_barcode'] = $member_barcode;
			$tmp_memberInfo = $this->o2oservicelibrary->get_member_info_by_barcode($params);
			if($tmp_memberInfo['result']){
				$memberInfo = $tmp_memberInfo;
			}
		}
		
		// 혜택 정보 구성 - 회원
		if($memberInfo['result']){
			// 회원 정보 추가 - 예치금 제외 : 예치금은 설정 기능에 따라 별도로 추가
			$mergeArray = array('member_seq', 'user_name', 'emoney');
			foreach($mergeArray as $key){
				$result_data[$key] = ($memberInfo['result'][$key])?$memberInfo['result'][$key]:'';
			}
			// 예치금 정보 저장
			if($member_cach_condition=="Y"){
				$result_data['cash'] = $memberInfo['result']['cash'];
			}
			
			// cart 모델에서 사용할 값 지정
			$this->userInfo['member_seq'] = $memberInfo['result']['member_seq'];
			$result_member = true;
		}
		
		// 최종 방문일 갱신 및 매장명 업데이트
		$this->load->library('memberlibrary');
		$this->memberlibrary->make_login_history($this->userInfo['member_seq'], $this->o2oConfig['pos_name']);

		// 마일리지 설정 정보는 필수이며 회원 혜택과 쿠폰 혜택이 있을 경우 cart 재구성
		if($result_condition && ($result_member || $result_coupon)){
			// 혜택 정보 생성 시 블럭 처리
			$this->o2oservicelibrary->set_block_benefit($this->userInfo['member_seq'], $this->o2oConfig);
			
			// 각 상품의 바코드를 기준으로 상품 고유키와 옵션 고유키 등을 추출하여 장바구니를 구성한다.
			foreach($cart as $key=>$goods){
				// 바코드 기준으로 상품 단일 옵션을 반환.
				$tmpGoodsInfo = $this->o2oservicelibrary->get_goods_onlyone_by_barcode($result['msg'], $goods['barcode']);
				
				if($tmpGoodsInfo['data']['full_barcode']==$goods['barcode']){
					$cart[$key]['goods_info'] = $tmpGoodsInfo['data'];
					$cart[$key]['goods_master_info'] = $tmpGoodsInfo['goodsMasterInfo'];
					$cart[$key]['goods_option_type'] = $tmpGoodsInfo['type'];
				}else{
					$cart[$key]['goods_info'] = null;
					$cart[$key]['goods_master_info'] = null;
				}
			}
			
			// 장바구니 담기
			// O2O 전용 배송그룹 호출
			$o2o_shipping_group = $this->o2oservicelibrary->get_o2o_shipping_group($this->o2oConfig['o2o_store_seq']);
			$shipping_method		= $o2o_shipping_group['shipping_method'];
			$shipping_store_seq		= $o2o_shipping_group['shipping_store_seq'];
			
			$check_add_cart = false;
			$keep_cart = null;
			$arr_result_cart = array();
			$this->load->model('cartmodel');
			foreach($cart as $key=>$goods){
				if($goods['goods_info'] && $goods['goods_master_info']) {
					unset($add_data);
					// $this->is_adminOrder = 'admin';	// 관리자 주문과 동일하게 처리
					$_GET['mode'] = 'o2o';	// 별도의 장바구니 타입 추가
					$add_data["cart_overwrite_distribution"]		= $_GET['mode'];
					// 장바구니 초기화 : 값이 있으면 초기화 하지 않음
					// 제일 첫 상품을 담을 때만 초기화 하고 나머지는 초기화 하지 않음
					$add_data["keep_cart"]							= $keep_cart;	// null : 삭제 :"1" :  유지;	
					$keep_cart = "1";
					$add_data["member_seq"]							= ($this->userInfo['member_seq'])?$this->userInfo['member_seq']:'';
					$add_data['use_add_action_button']				= 'y';
					$add_data['option_select_goods_seq']			= $goods['goods_info']['goods_seq'];
					$add_data['option_select_provider_seq']			= $goods['goods_master_info']['provider_seq'];

					// 옵션 배열 시작
					unset($add_data_option);
					unset($add_data_option_title);
					foreach($goods['goods_info']['option_divide_title'] as $key_option_divide => $option_divide_title){
						$add_data_option[]							= $goods['goods_info']['opts'][$key_option_divide];
						$add_data_option_title[]					= $option_divide_title;
					}
					// 옵션 배열 종료

					if($goods['goods_option_type'] == 'opt'){
						$add_data['option'][$key]						= $add_data_option;
						$add_data['optionTitle'][$key]					= $add_data_option_title;
						$add_data['optionEa'][$key]						= $goods['ea'];
						// 추가 옵션 배열 시작
						$add_data['suboption']							= '';
						$add_data['suboptionTitle']						= '';
						$add_data['suboptionEa']						= '';
						// 추가 옵션 배열 종료
					}elseif($goods['goods_option_type'] == 'opt'){
						$add_data['option']								= '';
						$add_data['optionTitle']						= '';
						$add_data['optionEa']							= '';
						// 추가 옵션 배열 시작
						$add_data['suboption'][$key]					= $add_data_option;
						$add_data['suboptionTitle'][$key]				= $add_data_option_title;
						$add_data['suboptionEa'][$key]					= $goods['ea'];
						// 추가 옵션 배열 종료
					}
					
					// O2O 배송그룹 강제 지정
					$add_data['shipping_method']					= $shipping_method;
					$add_data['shipping_store_seq']					= $shipping_store_seq;
										
					// 불필요 값 시작
					//	$add_data['select_option_prefix']				= null;
					//	$add_data['select_option_suffix']				= null;
					//	$add_data['cart_option_seq']					= null;
					//	$add_data['exist_option_seq']					= null;
					//	$add_data['inputsValue']						= null;
					//	$add_data['inputsTitle']						= null;
					// 불필요 값 종료

					// 장바구니 추가
					$resultCart			= $this->cartmodel->add_cart_ver_0_1($add_data);
					if($resultCart['cart_seq']){
						$arr_result_cart[] = $resultCart;
						$check_add_cart = true;
					}
				}
			}
			
			// 장바구니 추가에 성공 했을 경우만 계산
			if($check_add_cart){
				// 할인혜택 계산 - calculate 호출
				$this->displaymode = 'cart';
				// 쿠폰 적용
				if(!empty($downloads)){
					// 주문서쿠폰
					if($downloads['type']=="ordersheet"){
						$_POST['ordersheet_coupon_download_seq'] = $downloads['download_seq'];
					}else{
						// 일반쿠폰 처리 및 중복 & 단독 사용 불가처리
						$coupon_same_time_can = true;
						foreach($arr_result_cart as $result_cart){
							foreach($result_cart['cart_option_seq'] as $result_cart_option_seq){
								if($coupon_same_time_can){
									// 오프라인에서는 쿠폰을 1개만 사용 가능하여
									// 단독 사용 조건은 체크하지 않으며
									// 중복 사용 조건에 모두 만족할 시 동일 쿠폰 적용
									if($downloads['duplication_use'] == "0") {
										$coupon_same_time_can = false;
									}
									$_POST['coupon_download'][$result_cart['cart_seq']][$result_cart_option_seq] = $downloads['download_seq'];
								}

							}
						}
					}
				}

				$this->load->library('calculatelibrary');
				$this->calculatelibrary->allow_exit = false;
				// api에서는 echo 및 스크립트 불필요
				ob_start();
				$cal_cart = $this->calculatelibrary->exec_calculate('','','o2o');
				$ob_msg = ob_get_contents();
				ob_end_clean();	// 출력버퍼 지우고 종료
				unset($ob_msg);

				// 칼큘레이터 적용 할인가 입력
				foreach($result_data['cart'] as $key=>$data){
					foreach($cal_cart['list'] as $cal_cart_data){
						if($data['barcode']==$cal_cart_data['full_barcode']){
							
							$result_data['cart'][$key]['shop_price']			= ''.floor($cal_cart_data['sale_price']);
							$result_data['cart'][$key]['shop_org_price']		= ''.$cal_cart_data['price'];
							
							// POS에서는 불필요한 내용
							// $result_data['cart'][$key]['shop_price_rest']		= ''.($cal_cart_data['tot_result_price'] - ($result_data['cart'][$key]['shop_price'] * $result_data['cart'][$key]['ea']));
							// $result_data['cart'][$key]['sum_shop_price']		= $cal_cart_data['tot_result_price'];
							// $result_data['cart'][$key]['sum_shop_org_price']	= ''.(($cal_cart_data['tot_ori_price'])?$cal_cart_data['tot_ori_price']:'0');
							
							// 할인 목록 : unit_ordersheet 의 경우 총액일 때만 쿠폰에 가산, 개별일 경우엔 이미 계산되어 있음.
							foreach($this->arr_sale_list as $sale_name){
								
								// case1을 사용하건 case2를 사용하건 실제 처리에는 관계 없으나 
								// POS에서 개별처리의 난점이 예상되어 합산값인 case1을 전달
								
								// case1. 할인 내역은 각 상품별 총 할인액을 전달
								// if($sale_name == 'unit_ordersheet'){	// 주문서쿠폰은 별도 가산
								// 	$result_data['cart'][$key]['coupon_sale']			+= $cal_cart_data[$sale_name];
								// 	$result_data['cart'][$key]['coupon_sale']			= ''.$result_data['cart'][$key]['coupon_sale'];
								// }else{
								// 	$result_data['cart'][$key][$sale_name.'_sale']		= ''.(($cal_cart_data[$sale_name.'_sale'])?$cal_cart_data[$sale_name.'_sale']:'0');
								// }
								
								// case2. 할인 내역은 각 상품별 할인 및 나머지를 전달
								$result_data['cart'][$key][$sale_name.'_sale_unit']		= ''.(($cal_cart_data[$sale_name.'_sale_unit'])?$cal_cart_data[$sale_name.'_sale_unit']:'0');
								$result_data['cart'][$key][$sale_name.'_sale_rest']		= ''.(($cal_cart_data[$sale_name.'_sale_rest'])?$cal_cart_data[$sale_name.'_sale_rest']:'0');
							}
							
							// 금액은 음수 금지
							if($result_data['cart'][$key]['price']<0) $result_data['cart'][$key]['price'] = 0;
						}
					}
				}
			}
			$result['data'] = $result_data;
			$result['code'] = '1';
			$result['msg'] = (empty($result['msg']))?"성공":"에러".$result['msg'];
		}else{
			$result['data'] = $result_data;
			$result['code'] = '1';
			$result['msg'] = (empty($result['msg']))?"성공":"에러".$result['msg'];
		}
		
		$this->response($result['code'], $result['msg'], $result['data']);
	}
	// 주문 정보 수집
	public function orders(){
		ini_set('memory_limit','-1');
		$result['code']		= "0";
		$result['msg']		= "실패";
		$result['data']		= array('order_seq' => '');
		$order_seq			= '';
		
		$post_params['pos_order_seq']			= $this->input->post('pos_order_seq');
		$post_params['emoney']					= $this->input->post('emoney');
		$post_params['cash']					= $this->input->post('cash');
		$post_params['enuri']					= $this->input->post('enuri');
		$post_params['member_seq']				= $this->input->post('member_seq');
		$post_params['cart_coupon_seq']			= $this->input->post('cart_coupon_seq');
		$post_params['settle_price']			= $this->input->post('settle_price');
		$post_params['org_settle_price']		= $this->input->post('org_settle_price');
		$post_params['regist_date']				= $this->input->post('regist_date');
		$post_params['order_item']				= $this->input->post('order_item');

		// 최종 방문일 갱신 및 매장명 업데이트
		$this->load->library('memberlibrary');
		$this->memberlibrary->make_login_history($post_params['member_seq'], $this->o2oConfig['pos_name']);
		
		// 주문 수집 처리 전 각각의 금액 계산이 올바른지 체크
		$checksum = $this->o2oorderlibrary->checksum_before_make_order($result['msg'], $post_params);
		
		if($checksum){
			// 주문 생성 처리 
			$order_seq = $this->o2oorderlibrary->make_o2o_order($result, $post_params);

			if($order_seq){
				$result['code']		= "1";
				$result['msg']		= "성공";
				$result['data']		= array('order_seq' => $order_seq);
			}
		}
		
		$this->response($result['code'], $result['msg'], $result['data']);
	}
	// 주문취소 정보 수집
	public function ordersCancel(){
		$result['code']		= "0";
		$result['msg']		= "실패";
		$result['data']		= array('order_seq' => '');
		$order_seq			= '';
		
		$post_params['order_seq']				= $this->input->post('order_seq');
		$post_params['pos_order_seq']			= $this->input->post('pos_order_seq');
		
		// 최종방문일 갱신을 위한 회원 정보 얻기
		$this->load->library('orderlibrary');
		$order = $this->orderlibrary->get_order(array('order_seq'=>$post_params['order_seq']));
		
		// 최종 방문일 갱신 및 매장명 업데이트
		$this->load->library('memberlibrary');
		$this->memberlibrary->make_login_history($order['member_seq'], $this->o2oConfig['pos_name']);
		
		// 주문 취소 처리 
		$order_seq = $this->o2oorderlibrary->refund_o2o_order($result['msg'], $post_params);
		
		if($order_seq){
			$result['code']		= "1";
			$result['msg']		= "성공";
			$result['data']		= array('order_seq' => $order_seq);
		}
		
		$this->response($result['code'], $result['msg'], $result['data']);
	}
	// 상품 재고 확인 추가
	public function getStock(){
		
		$chk = array('sale_able_stock'=>0);
		
		$result['code']		= "0";
		$result['msg']		= "실패";
		$result['data']		= array('stock' => 0);
		
		$this->load->helper('order');
		
		$barcode = $this->input->post('barcode');
		
	
		// 바코드 기준으로 상품 단일 옵션을 반환.
		$tmpGoodsInfo = $this->o2oservicelibrary->get_goods_onlyone_by_barcode($result['msg'], $barcode);
		if($tmpGoodsInfo){
			if($this->scm_cfg['use']=="Y"){
				// scm 이 활성화 되어 있을 경우 shop의 기본 재고가 아닌 POS의 연결 매장의 데이터만 추출한다.
				unset($sc);
				$sc['wh_seq']			= $this->o2oConfig['scm_store'];		// 연결매장 고유키
				$sc['concat_goods']		= $tmpGoodsInfo['data']['goods_seq'].'option'.$tmpGoodsInfo['data']['option_seq'];		// 상품 및 옵션 정보 {$goods_seq.'option'.$option_seq};
				$location_stock			= $this->scmmodel->get_location_stock($sc);
				
				if	(count($location_stock) == 1){
					$chk['sale_able_stock']	= $location_stock[0]['ea'];
				}else{
					$msg .= "[".$barcode.":잘못된 창고 정보가 조회되었습니다.]";
				}
			}
			
			// SCM이 비활성화 되었거나 등록되지 않은 재고가 있을 경우 쇼핑몰재고를 바라보도록 수정
			if(empty($chk['sale_able_stock'])){
				// 필수 옵션 기준 재고 체크
				if(!empty($tmpGoodsInfo['data']) && $tmpGoodsInfo['type']=='opt'){
					$goods_seq		= $tmpGoodsInfo['data']['goods_seq'];
					$option_r[0]	= $tmpGoodsInfo['data']['option1'];
					$option_r[1]	= $tmpGoodsInfo['data']['option2'];
					$option_r[2]	= $tmpGoodsInfo['data']['option3'];
					$option_r[3]	= $tmpGoodsInfo['data']['option4'];
					$option_r[4]	= $tmpGoodsInfo['data']['option5'];
					$option_ea		= 1;

					// 재고 체크
					$chk = check_stock_option(
						$goods_seq,
						$option_r[0],
						$option_r[1],
						$option_r[2],
						$option_r[3],
						$option_r[4],
						$option_ea,
						null,
						'view_stock'
					);
				}elseif(!empty($tmpGoodsInfo['data']) && $tmpGoodsInfo['type']=='sub'){
					// 추가 옵션 기준 재고 체크 - 필수 옵션으로 확인된 데이터가 있을 시 무시
					$goods_seq		= $tmpGoodsInfo['data']['goods_seq'];
					$option_r[0]	= $tmpGoodsInfo['data']['suboption_title'];
					$option_r[1]	= $tmpGoodsInfo['data']['suboption'];
					$option_ea		= 1;

					// 재고 체크
					$chk = check_stock_suboption(
						$goods_seq,
						$option_r[0],
						$option_r[1],
						$option_ea,
						null,
						'view_stock'
					);
				}
			}
		}
		
		
		if(!empty($chk['sale_able_stock'])){
			$result['code']		= "1";
			$result['msg']		= "성공";
			$result['data']		= array('stock' => $chk['sale_able_stock']);
		}
		
		$this->response($result['code'], $result['msg'], $result['data']);
	}
	
	// 계약 결과 저장 및 연동키 발행 - 미사용
	public function setContracts(){
		/*
		$pos_code = $this->input->post('pos_code');
		$store_seq = $this->input->post('store_seq');
		$pos_seq = $this->input->post('pos_seq');
		$pos_name = $this->input->post('pos_name');
		$pos_phone = $this->input->post('pos_phone');
		$contracts_status = $this->input->post('contracts_status');
		$publish_pos_key = $this->input->post('publish_pos_key');
		$publish_pos_key = ($publish_pos_key)?$publish_pos_key:"n";
		
		// 각 업체별 요청지를 IP로 제한
		if(empty($this->o2o_pos_info[$pos_code])){
			$this->throwTokenAuthError('7', "허가받지 않은 업체입니다.");
		}else{
			$o2o_pos_ip = $this->o2o_pos_info[$pos_code]['ip'];
			if($_SERVER['REMOTE_ADDR']!=$o2o_pos_ip){
				$this->throwTokenAuthError('8', "허가받지 않은 IP입니다.");
			}
		}
		
		// 헤더 체크
		$headers = $this->input->request_headers();
		$authorization = $headers['authorization'];
		if (!empty($authorization)){
			$filter_authorization = $authorization;
			if($this->auth_text){
				if(strpos($authorization, $this->auth_text)===false){
					$this->throwTokenAuthError(9);
				}else{
					$filter_authorization = str_replace($this->auth_text." ", "", $authorization);
				}
			}
			if($filter_authorization!=$this->o2o_pos_info[$pos_code]['key']){
				$this->throwTokenAuthError(10);
			}
		}
		
		// 연동키 발행
		$pos_key = "";
		if($publish_pos_key=="y"){
			unset($posKeyData);
			$posKeyData = array(
				'time'				=> time(),
				'auth_text'			=> $this->auth_text,
				'pos_code'			=> $pos_code,
				'store_seq'			=> $store_seq,
			);
			$pos_key = $this->o2oservicelibrary->generatePosKey($posKeyData);
		}
		
		// 계약 결과 저장
		unset($insertData);
		$insertData = array(
			'pos_code'			=> $pos_code,
			'store_seq'			=> $store_seq,
			'pos_seq'			=> $pos_seq,
			'contracts_status'	=> $contracts_status,
			'pos_key'			=> $pos_key,
			'pos_name'			=> $pos_name,
			'pos_phone'			=> $pos_phone,
			'scm_store'			=> '',
			'use_yn'			=> '',
		);
		$o2oConfig = $this->o2oservicelibrary->merge_o2o_config($insertData);
		
		// 중계DB에 계약 생성 요청
		if($o2oConfig){
			
			// 중계 DB 호출
			unset($o2o_relay_params);
			$o2o_relay_params['pos_code']		= $o2oConfig['pos_code'];
			$o2o_relay_params['store_seq']		= $o2oConfig['store_seq'];
			$o2o_relay_params['pos_seq']		= $o2oConfig['pos_seq'];
			$o2o_relay_params['use_yn']			= ($o2oConfig['delete_yn']=='y')?'n':$o2o_config_pos['use_yn'];
			$o2o_relay_params['pos_key']		= $o2oConfig['pos_key'];

			unset($o2o_relay_info);
			$o2o_relay_info = $this->o2oservicelibrary->sharePosInfo($o2o_relay_params);
			
			if($o2o_relay_info['result']!="1"){
				$this->throwException('1','중계 서버 처리에 실패했습니다.');
			}
			$this->response('1','성공',array('pos_key'=>$o2oConfig['pos_key']));
		}
		$this->response('0','O2O 서비스를 사용할 수 업습니다.',array('pos_key'=>$o2oConfig['pos_key']));
		*/
		$this->response('0','미지원 API 입니다.',null);
	}
}

/* End of file o2o.php */
/* Location: ./app/controllers/o2o.php */