<?php
Class MarketGoods_shoplinker  Implements MarketGoodsInterface 
{
	protected $_connectorBasic;

	public $_CI				= false;
	public $baseMarketInfo	= array();


	public function __construct($getBaseMarketInfo)
	{
		$this->baseMarketInfo	= $getBaseMarketInfo;
		$this->_CI				=& get_instance();

		$params['market']		= $getBaseMarketInfo['market'];
		$params['sellerId']		= $getBaseMarketInfo['seller_id'];
		$this->_connectorBasic	= $this->_CI->connector::getInstance('basic', $params);
	}
	
		
	/* 상품정보와 추가정보 로 마켓 파라미터 생성 */
	public function marketGoodsParams($productInfo, $addInfo)
	{
		if(isset($addInfo)){
			$result = array_merge($productInfo, $addInfo);
		}else{
			$result = $productInfo;
		}

		// 전송하는 모든 내용을 htmlspecialchars 처리함
		array_walk_recursive($result, function(&$item, $key) {
			$except = array('detail_desc','new_desc_top');
			if( !in_array($key, $except) ) {
			  $item = htmlspecialchars($item);
			}
		});

		return $result;
	}


	/* 상품정보와 추가정보 분리 생성*/
	public function buildMarketParams($allGoodsInfo, $mode)
	{
		/*****************************************************/
		$this->_CI->load->model('connectormodel');
		$this->_CI->load->model('shippingmodel');
		$this->_CI->load->helper('shipping');
		
		$baseMarketInfo		= $this->baseMarketInfo;
		$goodsData			= $allGoodsInfo['goodsData'];
		$domain				= $allGoodsInfo['domain'];
		$provider_seq		= $allGoodsInfo['provider_seq'];
		$addInfoKey			= $allGoodsInfo['addInfoKey'];
		$addInfoValue		= $allGoodsInfo['addInfoValue'];
		$notificationInfo	= $allGoodsInfo['notificationInfo'];
		$optionsList		= $allGoodsInfo['optionsList'];
		//$subOptionsList		= $allGoodsInfo['subOptionList'];	// 지원안함
		$addinfoParams		= $baseMarketInfo['add_info_detail'];
		$marketCategory		= $baseMarketInfo['category_code'];
		
		
		$shoplinkerAddInfo  = $this->_CI->connectormodel->getMarketAddInfo($baseMarketInfo['add_info_seq']);
		$shopLinkerAuthInfo = $this->_connectorBasic->getShoplinkerMarketAuthInfo();
		
		$goodsParams		= array();
		/*****************************************************/
		
		/*샵링커 기본 정보*/
		$goodsParams['customer_id']						= $shopLinkerAuthInfo['customerId'];
		$goodsParams['distCategoryType']				= $baseMarketInfo['dist_category_type'];
		/*샵링커 기본 정보*/
		
		
		if(strpos($goodsData['goodsImage']['1']['large']['image'],'http') !== false){
			$proto = "";
			$domain = "";
		}else{
			$proto = "http://";
			if($_SERVER["HTTPS"] == 'on') $proto = "https://";
		}
		

		/*이미지 셋팅*/
		/*foreach($goodsData['goodsImage'] as $data){			
		}*/
		
		if(isset($goodsData['goodsImage']['1']['large'])){
			$goodsParams['image_url1'] = $proto.$domain.$goodsData['goodsImage']['1']['large']['image'];
		}
		
		/*과세, 비과세*/
		if($goodsData['goodsInfo']['tax'] == "tax"){
			$goodsParams['tax_yn'] = "001";
		}else if($goodsData['goodsInfo']['tax'] == "exempt"){
			$goodsParams['tax_yn'] = "002";
		}
		
		/*상품 상태*/
		switch($goodsData['goodsInfo']['goods_status']){
			case "normal" : 
				$shoplinkerStatus = "001"; //판매중
				break;
			case "unsold" :
				$shoplinkerStatus = "003"; //판매중지
				break;
			case "runout" : 
				$shoplinkerStatus = "004"; //품절
				break;
			case "purchasing" : 
				$shoplinkerStatus = "003"; //판매중지 - 판매종료는 다시 해당 상품 판매불가함으로 판매중지로 변경 2019-01-23
				break;
		}
		
		// 배송 방법 설정
		if($goodsData['goodsInfo']['shipping_policy'] == 'shop'){

			/*
				$shipping_policy	= use_shipping_method($provider_seq);
				if	(!$shipping_policy) $shipping_policy	= use_shipping_method();
			*/
			$shipping_group_seq = $goodsData['goodsInfo']['shipping_group_seq'];
			$shipping_policy = $this->_CI->shippingmodel->get_shipping_group_summary($shipping_group_seq);


			/*
				샵링커 배송정책 ...... 2018-08-07 pjm
				- 무료 : 001
				- 착불 : 002
				- 착불선결제 : 003
				- 3만원이상무료 : 004
				- 5만원이상 무료 : 005
				- 7만원이상 무료 : 006
				- 10만원 무료 : 007
				- 4만원이상 무료	: 008
				- 9800원이상무료	: 009
				- 2만원이상무료	: 010
				- 6만원이상무료	: 011
				- 수도권 무료배송	: 012
			*/

			$delivery_charge = 0;

			//무료배송
			if($shipping_policy['default_type'] == "free"){

				if($shipping_policy['prepay_info'] == "delivery" || $shipping_policy['prepay_info'] == "all"){
					$delivery_charge_type		= '003';
					$delivery_charge			= (int)$shipping_policy['max_cost'];	//배송비
				}elseif($shipping_policy['prepay_info'] == "postpaid"){		//착불
					$delivery_charge_type		= '002';
					$delivery_charge			= (int)$shipping_policy['max_cost'];	//배송비
				}else{
					$delivery_charge_type		= '001';
				}

			}else{

				//유료배송
				if($shipping_policy['default_type'] == "fixed"){
					$delivery_charge_type		= '003';
				}

				//조건부 무료배송
				if($shipping_policy['default_type'] == "iffree" && $shipping_policy['std_opt_type'] == "amount"){
					
					$params = array();
					$params['default_yn'] = 'Y';
					$ship = $this->_CI->shippingmodel->load_shipping_set_list($shipping_group_seq,$params);

					$_shipping_policy = "";
					foreach($ship as $_ship) if(!$_shipping_policy) $_shipping_policy = $_ship;

					$_section_price = $_shipping_policy['section_ed']['std'];
					if($_section_price[0] > 0 && $_shipping_policy['shipping_cost']['std'][count($_section_price)-1] == 0){
							
						if((int)$_section_price[0] >= 100000){//10만이상무료
							$delivery_charge_type = '007';
						}elseif((int)$_section_price[0] >= 70000){//7만이상무료
							$delivery_charge_type = '006';
						}elseif((int)$_section_price[0] >= 50000){//5만이상무료
							$delivery_charge_type = '005';
						}elseif((int)$_section_price[0] >= 40000){//4만이상무료
							$delivery_charge_type = '008';
						}elseif((int)$_section_price[0] >= 30000){//3만이상무료
							$delivery_charge_type = '004';
						}elseif((int)$_section_price[0] >= 20000){//2만이상무료
							$delivery_charge_type = '010';
						}elseif((int)$_section_price[0] >= 9800){//9천800원이상무료
							$delivery_charge_type = '009';
						}
					}

				}

				//(샵링커 관리자는 착불/착불선결제 일때에만 배송비 노출되고 있음.
				//착불선결제(선불인듯?)
				if($shipping_policy['prepay_info'] == "delivery" || $shipping_policy['prepay_info'] == "all"){
					$delivery_charge_type		= '003';
					$delivery_charge = $shipping_policy['max_cost'];	//배송비
				//착불
				}elseif($shipping_policy['prepay_info'] == "postpaid"){
					$delivery_charge_type		= '002';
					$delivery_charge = $shipping_policy['max_cost'];	//배송비
				}

			}

			/*
				if($shipping_policy[0][0]['deliveryCostPolicy']=='free' || (!$shipping_policy[0][0]['payDeliveryCost'] && !$shipping_policy[0][0]['ifpayDeliveryCost']))
					$delivery_charge_type		= '001';
					
				if($shipping_policy[0][0]['deliveryCostPolicy']=='pay'){
					$delivery_charge_type		= '003';
				}
				
				// 조건부 무료배송 금액차감
				if($shipping_policy[0][0]['deliveryCostPolicy']=='ifpay'){
					
					$delivery_charge_type = '003';//착불선결제
					if($shipping_policy[0][0]['ifpayFreePrice']>=100000){//10만이상무료
						$delivery_charge_type = '007';
					}elseif($shipping_policy[0][0]['ifpayFreePrice']>=70000){//7만이상무료
						$delivery_charge_type = '006';
					}elseif($shipping_policy[0][0]['ifpayFreePrice']>=50000){//5만이상무료
						$delivery_charge_type = '005';
					}elseif($shipping_policy[0][0]['ifpayFreePrice']>=40000){//4만이상무료
						$delivery_charge_type = '008';
					}elseif($shipping_policy[0][0]['ifpayFreePrice']>=30000){//3만이상무료
						$delivery_charge_type = '004';
					}elseif($shipping_policy[0][0]['ifpayFreePrice']>=20000){//2만이상무료
						$delivery_charge_type = '010';
					}elseif($shipping_policy[0][0]['ifpayFreePrice']>=9800){//9천800원이상무료
						$delivery_charge_type = '009';
					}
				}
			*/

		}else{
			$delivery_charge_type			= '003';
		}
		
		$goodsParams['partner_product_id']				= $baseMarketInfo['goods_seq'];
		$goodsParams['sale_status']						= $shoplinkerStatus;
		$goodsParams['group_id']						= $shoplinkerAddInfo['category_code'];
		$goodsParams['product_name']					= $goodsData['goodsInfo']['goods_name'];
		
		if($baseMarketInfo['dist_category_type'] == "M"){		
			$goodsParams['ccategory_l']						= $baseMarketInfo['dep1_category_code'];
			$goodsParams['ccategory_m']						= $baseMarketInfo['dep2_category_code'];
			$goodsParams['ccategory_s']						= $baseMarketInfo['dep3_category_code'];
			$goodsParams['ccategory_d']						= $baseMarketInfo['dep4_category_code'];
		}else if($baseMarketInfo['dist_category_type'] == "G"){
			$goodsParams['ccategory_l']						= $baseMarketInfo['category_code'];
		}
		
		$goodsParams['image_type']						= "URL"; //현재 URL 고정임, 다른방식은 개발이 필요함
		$goodsParams['market_price']					= $goodsData['defaultOption']['consumer_price'];
		$goodsParams['sale_price']						= $goodsData['defaultOption']['price'];
		$goodsParams['supply_price']					= $goodsData['defaultOption']['supply_price'];
		$goodsParams['market_price_p']					= $goodsData['defaultOption']['consumer_price'];
		$goodsParams['sale_price_p']					= $goodsData['defaultOption']['price'];
		$goodsParams['supply_price_p']					= $goodsData['defaultOption']['supply_price'];
		$goodsParams['delivery_charge_type']			= $delivery_charge_type;
		$goodsParams['delivery_charge']					= $delivery_charge;
		$goodsParams['detail_desc']						= preg_replace('/src=([",\'])(\/data\/editor)/smi', "src=$1".get_connet_protocol()."$domain$2", $goodsData['goodsInfo']['contents']);
		$goodsParams['detail_desc']						= str_replace('src="//','src="'.get_connet_protocol(),$goodsParams['detail_desc']);

		$goodsParams['new_desc_top']					= str_replace('src="//','src="'.get_connet_protocol(),$goodsData['goodsInfo']['contents']);
		$goodsParams['quantity']						= $goodsData['defaultOption']['stock'];
		$goodsParams['keyword']							= $goodsData['goodsInfo']['keyword'];

		
		/*옵션 부분*/
		/*2017-11-21 option_seq 추가 샵링커 매칭때문에*/
		if($goodsData['goodsInfo']['option_use'] == 1){
			$goodsParams['option_kind']						= "002";			
			$optCnt = count($goodsData['defaultOption']['option_divide_title']);
			
			//단일 옵션
			if($optCnt == 1){//단일 옵션
				$optTitle = $goodsData['defaultOption']['option_divide_title'][0];
				
				foreach ($optionsList as $opt){
					//$optAttdue = $opt['option_seq']."-".$opt['opts'][0];
					$optAttdue = $opt['opts'][0];
					$optStork = $opt['stock'];
					$optPrice = (int)$opt['price']-(int)$goodsParams['sale_price'];		// sale_price 차이를 넘겨야함 2018-02-22
					$optInfo .= $optAttdue."^^".$optStork."<**>".$optPrice.",";
				}
			}else{//복수 옵션
				$optTitle = join("/",$goodsData['defaultOption']['option_divide_title']);
				
				foreach ($optionsList as $opt){
					/*foreach($opt['opts'] as $optKey => $optVal){
						$opt['opts'][$optKey] = $opt['option_seq']."-".$optVal;
					}*/
					$optAttdue = join("/",$opt['opts']);
					$optStork = $opt['stock'];
					$optPrice = (int)$opt['price']-(int)$goodsParams['sale_price'];		// sale_price 차이를 넘겨야함 2018-02-22
					$optInfo .= $optAttdue."^^".$optStork."<**>".$optPrice.",";
				}
			}			
			
			$optVal = $optTitle."||".$optInfo;
			$goodsParams['opt_info'] = substr($optVal, 0, (strlen($optVal) - 1));
		}else{
			$goodsParams['option_kind']						= "000";
		}
		
		
		/* 추가정보 입력 */
		$brandKey		= array_search('브랜드', $addInfoKey);
		if ($brandKey !== false)
			$goodsParams['brand']		= trim($addInfoValue[$brandKey]['contents']);
			
		$manufactureKey		= array_search('제조사', $addInfoKey);
		if ($manufactureKey !== false){
			$goodsParams['maker']		= trim($addInfoValue[$manufactureKey]['contents']);
		}else{
			$return['success']	= 'N';
			$return['message']	= '제조사를 상품의 추가정보에 입력해주세요.';
			return $return;
		}
		
		$originKey			= array_search('원산지', $addInfoKey);
		if ($originKey !== false){
			$goodsParams['origin']		= trim($addInfoValue[$originKey]['contents']);
		}else{
			$return['success']	= 'N';
			$return['message']	= '원산지를 상품의 추가정보에 입력해주세요.';
			return $return;
		}
				
		$modelKey			= array_search('모델명', $addInfoKey);
		if ($modelKey !== false)
			$goodsParams['model']		= trim($addInfoValue[$modelKey]['contents']);
						
		$manufactureDateKey	= array_search('생산일자', $addInfoKey);
		if ($manufactureDateKey !== false)
			$goodsParams['maker_dt']	= trim($addInfoValue[$manufactureDateKey]['contents']);
						
		$validDateKey		= array_search('유효일자', $addInfoKey);
		if ($validDateKey !== false)
			$goodsParams['expirydate']	= trim($addInfoValue[$validDateKey]['contents']);
		
		$authNoKey			= array_search('인증번호', $addInfoKey);
		if ($authNoKey !== false)
			$goodsParams['auth_no']		= trim($addInfoValue[$authNoKey]['contents']);
		
		// 상품 고시정보
		$notificationDesc	= array();
		foreach ((array)$notificationInfo['notifictionList'] as $key => $val)
			$notificationDesc[$key]		= $val;
			
		$codeNum = str_replace("i", "", $notificationInfo['notificationCode']);
		$goodsParams['goodsinfo']['lclass_id']		= $notificationInfo['notificationCode'];
		
		$itemArry = array();
		$i = 0;
		
		foreach($notificationInfo['notifictionList'] as $key => $val){
			$seq = $i + 1;
			if($seq < 10){
				$code = $codeNum."0".$seq;
			}else{
				$code = $codeNum.$seq;
			}
			
			$itemArry[$i]["item"]["item_seq"] = $code;
			$itemArry[$i]["item"]["item_info"] = $val;
			$i++;
		}
		
		array_push($goodsParams['goodsinfo'],$itemArry); 
		
		// 결과값 리턴
		/*****************************************/
		$return['productInfo']	= $goodsParams;
		$return['addInfo']		= $addinfoParams;

		return $return;
		/*****************************************/
	}
}
