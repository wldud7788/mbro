<?php
Class MarketGoods_coupang  Implements MarketGoodsInterface 
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
		return array_merge($productInfo, $addInfo);
	}


	/* 상품정보와 추가정보 분리 생성*/
	public function buildMarketParams($allGoodsInfo, $mode)
	{
		/*****************************************************/
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
		$goodsParams		= array();
		/*****************************************************/
		

		/* 상품 추가정보 다시 정의 */
		$addinfoParams['displayCategoryCode']		= $marketCategory;

		// 시작일 ~ 종료일설정
		switch ($addinfoParams['saleStartSet']) {
			case	'TODAY' :
				$addinfoParams['saleStartSet']		= 'SETDATE';
				$addinfoParams['saleStartedAt']		= date('Y-m-d');
				break;

		}
		

		// 종료일 설정
		switch ($addinfoParams['saleEndSet']) {
			case	'INFINITE' :
				$addinfoParams['saleEndedAt']		= '2099-12-31';
				break;
		}
		

		// 자동 출고지 설정 처리
		$searchAddressKey			= false;
		if ($addinfoParams['outboundShippingPlaceCode'] == 'AUTO') {
			$providerInfo			= $this->_CI->providermodel->get_provider($provider_seq);
			$searchAddressKey		= $this->_connectorBasic->forMatchingText($providerInfo['provider_name']);

			$shippingAddress		= $this->_connectorBasic->callConnector('other/getShippingAddress');
			$shippingAddressList	= (array)$shippingAddress['resultData'];

			if(count($shippingAddressList) < 1) {
				$return['success']	= 'N';
				$return['message']	= '쿠팡에 등록된 출고지가 없습니다.';
				return $return;
			}

			$outboundShippingPlaceCode		= false;
			$deliveryCodeList				= array();
			foreach($shippingAddressList as $shippingInfo) {
				$marketKey			= $this->_connectorBasic->forMatchingText($shippingInfo['shippingPlaceName']);
				if ($searchAddressKey == $marketKey) {
					$outboundShippingPlaceCode	= $shippingInfo['outboundShippingPlaceCode'];
					$deliveryCodeList			= $shippingInfo['remoteInfos'];
					break;
				}
			}


			if ($outboundShippingPlaceCode === false) {
				$return['success']	= 'N';
				$return['message']	= "[출고지명 : {$searchAddressKey}] 쿠팡에 해당 출고지가 없습니다.";
				return $return;
			}

			$addinfoParams['outboundShippingPlaceCode']	= $outboundShippingPlaceCode;

			if ($addinfoParams['deliveryCompanyCode'] == 'AUTO') {
				if (isset($deliveryCodeList[0]) !== true) {
					$return['success']	= 'N';
					$return['message']	= "[출고지명 : {$searchAddressKey}] 등록된 배송사가 없습니다.";
					return $return;
				}

				$addinfoParams['deliveryCompanyCode']	= $deliveryCodeList[0]['deliveryCode'];
			}

		}


		// 자동 반품지 설정 처리
		if ($addinfoParams['returnCenterCode'] == 'AUTO') {
			
			if ($searchAddressKey === false) {
				$providerInfo		= $this->_CI->providermodel->get_provider($provider_seq);
				$searchAddressKey	= $this->_connectorBasic->forMatchingText($providerInfo['provider_name']);
			}

			$returnAddress			= $this->_connectorBasic->callConnector('other/getReturnAddress');
			$returnAddressList		= (array)$returnAddress['resultData'];
			

			if(count($returnAddressList) < 1) {
				$return['success']	= 'N';
				$return['message']	= '쿠팡에 등록된 반품지가 없습니다.';
				return $return;
			}
			
			$returnCenterCode		= false;
			foreach($returnAddressList as $shippingInfo) {
				$marketKey			= $this->_connectorBasic->forMatchingText($shippingInfo['returnChargeName']);
				if ($searchAddressKey == $marketKey) {
					$returnCenterCode	= $shippingInfo['returnCenterCode'];
					break;
				}
			}
		

			if ($returnCenterCode === false) {
				$return['success']	= 'N';
				$return['message']	= "[반품지명 : {$searchAddressKey}] 쿠팡에 해당 반품지가 없습니다.";
				return $return;
			}

			$addinfoParams['returnCenterCode']	= $returnCenterCode;
		}

		/***************************/


		/* 아이템에 포함되는 상품정보 */
		$maximumBuyForPersonPeriod	= 1;
		$overseasPurchased			= 'NOT_OVERSEAS_PURCHASED';
		$parallelImported			= 'NOT_PARALLEL_IMPORTED';
		$freePriceType				= 'NO_FREE_PRICE';
		$adultOnly					= ($goodsData['goodsInfo']['adult_goods'] == 'Y') ? 'ADULT_ONLY' : 'EVERYONE';
		$texType					= ($goodsData['tax'] != 'tax') ? 'FREE' : 'TAX';
		$maximumBuyForPerson		= ($goodsData['goodsInfo']['max_purchase_limit'] == 'limit') ? (int)$goodsData['goodsInfo']['max_purchase_ea'] : 0;
			

		$contents[0]['contentsType']					= 'TEXT';
		$contents[0]['contentDetails'][0]['content']	= preg_replace('/src=([",\'])(\/data\/editor)/smi', "src=$1".get_connet_protocol()."$domain$2", $goodsData['goodsInfo']['contents']);
		$contents[0]['contentDetails'][0]['content']	= str_replace('src="//','src="'.get_connet_protocol(),$contents[0]['contentDetails'][0]['content']);
		$contents[0]['contentDetails'][0]['detailType']	= 'TEXT';


		//대표 이미지
		$images			= array();
		foreach ((array)$goodsData['goodsImage'] as $arrayIdx => $image) {
			$nowImage					= array();
			$nowImage['imageOrder']		= 0;
			$nowImage['imageType']		= 'REPRESENTATION';

			// 이미지 url 체크
			if( preg_match('/http(s?)\:\/\//i', $image['large']['image']) ) // url인 경우
				$nowImage['vendorPath']	= $image['large']['image'];
			else 															// url아닌 경우 도메인과 함께 
				$nowImage['vendorPath']	= "http://{$domain}{$image['large']['image']}";

			$images[]					= $nowImage;
			unset($goodsData['goodsImage'][$arrayIdx]);

			//일단 상품이미지 1개
			break;
		}

		$notices		= array();
		foreach ($notificationInfo['notifictionList'] as $notiName => $notiValue) {
			$nowNotices									= array();
			$nowNotices['noticeCategoryName']			= $notificationInfo['notificationCode'];
			$nowNotices['noticeCategoryDetailName']		= $notiName;
			$nowNotices['content']						= $notiValue;
			$notices[]									= $nowNotices;
		}
			
		$searchTags		= array();
		if (trim($goodsData['goodsInfo']['keyword']) != '')
			$searchTags	= explode(',', $goodsData['goodsInfo']['keyword']);

		foreach($searchTags as $keyIdx => $keyVal)
			$searchTags[$keyIdx]	= trim($keyVal);

		/******************************/


		
		/* 쿠팡 카테고리별 필수정보 확인 */
		$categoryDescUrl	= "other/getCategoryDesc/{$marketCategory}";
		$response			= $this->_connectorBasic->callConnector($categoryDescUrl);

		$attributeList		= false;		// 전체 속성 리스트
		$mandatoryAttr		= array();		// 필수 속성 리스트
		$optionalAttr		= array();		// 추가 속성 리스트

		$goodsParams['sellerProductName']	= (trim($goodsData['goodsInfo']['goods_name_linkage']) != '') ? $goodsData['goodsInfo']['goods_name_linkage'] : $goodsData['goodsInfo']['goods_name'];
		$goodsParams['taxType']				= (trim($goodsData['goodsInfo']['tax']) == 'exempt') ? 'FREE' : 'TAX';
	

		if (isset($response['resultData']['attributes']) === true) {
			foreach($response['resultData']['attributes'] as $attrbuteInfo) {
				$attrKey	= md5($this->_connectorBasic->forMatchingOptionText($attrbuteInfo['attributeTypeName']));
				
				$attributeList[$attrKey]		= $attrbuteInfo;

				if ($attrbuteInfo['required'] == 'MANDATORY')
					$mandatoryAttr[$attrKey]	= $attrbuteInfo['attributeTypeName'];
				else
					$optionalAttr[$attrKey]		= $attrbuteInfo['attributeTypeName'];
			}
		}
		/*********************************/


		/* 쿠팡 아이템 파리미터 */
		if ($goodsData['goodsInfo']['option_use'] == '1') {

			$fmOptList		= array();
			foreach ((array)$optionsList[0]['option_divide_title'] as $fmOptTitle) {
				$titleKey				= md5($this->_connectorBasic->forMatchingOptionText($fmOptTitle));
				$fmOptList[$titleKey]	= $fmOptTitle;
			}
			
			// 카테고리에 옵션정보가 있을경우(없는 경우는 센드박스)
			if (is_array($attributeList) === true) {
				// 필수옵션 확인
				foreach ((array)$mandatoryAttr as $optKey => $optTitle) {
					if (isset($fmOptList[$optKey])) {
						unset($fmOptList[$optKey]);
						unset($mandatoryAttr[$optKey]);
					}
				}

				//필수 옵션 입력 에러
				if (count($mandatoryAttr) > 0) {
					$mandaroryOpt		= implode(', ', $mandatoryAttr);

					$return['success']	= 'N';
					$return['message']	= "필수옵션({$mandaroryOpt})이 누락되었습니다.";
					return $return;
				}

				//사용가능 옵션 확인
				foreach ((array)$fmOptList as $optKey => $optTitle) {
					if (isset($optionalAttr[$optKey])) {
						unset($fmOptList[$optKey]);
						unset($optionalAttr[$optKey]);
					}
				}
				
				//필수 옵션 입력 에러
				if (count($fmOptList) > 0) {
					$fmOption			= implode('", "', $fmOptList);
					$possibleOpt		= implode('", "', $optionalAttr);

					$return['success']	= 'N';
					$return['message']	= "사용이 불가능한 옵션입니다.(\"{$fmOption}\")\n 가능옵션 - \"{$possibleOpt}\"";
					return $return;
				}

			}			

			$items			= array();

			foreach((array) $optionsList as $optInfo) {

				$attributes			= array();
				$itemNameList		= array();
				$optionCode			= array();

				foreach($optInfo['option_divide_title'] as $optIdx => $fmOptTitle) {
					$titleKey			= md5($this->_connectorBasic->forMatchingOptionText($fmOptTitle));
					$nowAttrInfo		= $attributeList[$titleKey];
					$optionValue		= $optInfo['opts'][$optIdx];
					
					//
					if ($nowAttrInfo['dataType'] == 'NUMBER') {
						preg_match("/(^[0-9]+)/", $optionValue, $optValTemp);
						$optNumVal		= $optValTemp[0];
						$optUnit		= str_replace($optNumVal, '', $optionValue);
						$lowOptUnit		= strtolower($optUnit);
						$usableUnits	= (array)$nowAttrInfo['usableUnits'];

						foreach($usableUnits as $unitIdx => $unitValue)
							$usableUnits[$unitIdx]	= strtolower($unitValue);

						if (array_search($lowOptUnit, $usableUnits) === false) {
							$return['success']	= 'N';
							if ($nowAttrInfo['usableUnits'] > 5)
								$possibleOpt	= implode(', ', array_slice($nowAttrInfo['usableUnits'], 0, 5)) . " 등";
							else
								$possibleOpt	= implode(', ', $nowAttrInfo['usableUnits']);

							$return['message']	= "\"{$optUnit}\"는 사용이 불가능한 유닛입니다.(\"{$optionValue}\")\n 가능유닛 - \"{$possibleOpt}\"";
							return $return;
						}
					}

					$nowAttribute['attributeTypeName']	= $nowAttrInfo['attributeTypeName'];
					$nowAttribute['attributeValueName']	= $optionValue;
					$attributes[]						= $nowAttribute;
					$itemNameList[]						= $optionValue;
					$optionCode[]						= trim($optInfo['optcodes'][$optIdx]);
				}

				$nowItem								= array();
				$nowItem['originalPrice']				= $optInfo['consumer_price'];
				$nowItem['salePrice']					= $optInfo['price'];
				$nowItem['itemName']					= $goodsParams['sellerProductName'].' '.implode(' ', $itemNameList);
				$nowItem['externalVendorSku']			= "{$optInfo['goods_seq']}_{$optInfo['option_seq']}";

				$nowItem['unitCount']					= 0;

				$nowItem['attributes']					= $attributes;
				$nowItem['notices']						= $notices;
				$nowItem['maximumBuyCount']				= $optInfo['stock'];
				$nowItem['outboundShippingTimeDay']		= $addinfoParams['outboundShippingTimeDay'];
				$nowItem['contents']					= $contents;
				$nowItem['images']						= $images;
				$nowItem['maximumBuyForPerson']			= $maximumBuyForPerson;
				$nowItem['maximumBuyForPersonPeriod']	= $maximumBuyForPersonPeriod;
				$nowItem['texType']						= $texType;
				$nowItem['adultOnly']					= $adultOnly;
				$nowItem['overseasPurchased']			= $overseasPurchased;
				$nowItem['parallelImported']			= $parallelImported;
				$nowItem['freePriceType']				= $freePriceType;

				if (count($searchTags) > 0)
					$nowItem['searchTags']				= $searchTags;
				
				$items[]	= $nowItem;
			}
			

		} else {

			$fmOptList		= array();
			$attributes		= array();
			$targets		= array();
			$itemNameList	= array();

			foreach ((array)$addInfoKey as $fmOptTitle) {
				$titleKey				= md5($this->_connectorBasic->forMatchingOptionText($fmOptTitle));
				$fmOptList[$titleKey]	= $fmOptTitle;
			}

			// 카테고리에 옵션정보가 있을경우(없는 경우는 센드박스)
			if (is_array($attributeList) === true) {
				// 필수옵션 확인
				foreach ((array)$mandatoryAttr as $optKey => $optTitle) {
					if (isset($fmOptList[$optKey])) {
						$targets[]		= $optKey;
						unset($mandatoryAttr[$optKey]);
					}
				}

				//필수 옵션 입력 에러
				if (count($mandatoryAttr) > 0) {
					$mandaroryOpt		= implode(', ', $mandatoryAttr);

					$return['success']	= 'N';
					$return['message']	= "필수옵션({$mandaroryOpt})이 누락되었습니다.";
					return $return;
				}

				//사용가능 옵션 확인
				foreach ((array)$fmOptList as $optKey => $optTitle) {
					if (isset($optionalAttr[$optKey])) {
						$targets[]		= $optKey;
						unset($optionalAttr[$optKey]);
					}
				}
			}

			foreach ($targets as $optKey) {
				$addInfoName	= $fmOptList[$optKey];

				$attrKey		= array_search($addInfoName, $addInfoKey);
				$optionValue	= $addInfoValue[$attrKey]['contents'];
				$nowAttrInfo	= $attributeList[$optKey];
				$itemNameList[]	= $optionValue;
					
				if ($nowAttrInfo['dataType'] == 'NUMBER') {
					preg_match("/(^[0-9]+)/", $optionValue, $optValTemp);
					$optNumVal		= $optValTemp[0];
					$optUnit		= str_replace($optNumVal, '', $optionValue);
					$lowOptUnit		= strtolower($optUnit);
					$usableUnits	= (array)$nowAttrInfo['usableUnits'];

					foreach($usableUnits as $unitIdx => $unitValue)
						$usableUnits[$unitIdx]	= strtolower($unitValue);

					if (array_search($lowOptUnit, $usableUnits) === false) {
						$return['success']	= 'N';
						if ($nowAttrInfo['usableUnits'] > 5)
							$possibleOpt	= implode(', ', array_slice($nowAttrInfo['usableUnits'], 0, 5)) . " 등";
						else
							$possibleOpt	= implode(', ', $nowAttrInfo['usableUnits']);

						$return['message']	= "\"{$optUnit}\"는 사용이 불가능한 유닛입니다.(\"{$optionValue}\")\n 가능유닛 - \"{$possibleOpt}\"";
						return $return;
					}
				}

				$nowAttribute['attributeTypeName']	= $nowAttrInfo['attributeTypeName'];
				$nowAttribute['attributeValueName']	= $optionValue;
				$attributes[]						= $nowAttribute;
			}

			
			// ITEM은 추가정보 영역을 활용
			$nowItem								= array();
			$nowItem['originalPrice']				= $goodsData['defaultOption']['consumer_price'];
			$nowItem['salePrice']					= $goodsData['defaultOption']['price'];
			$nowItem['itemName']					= $goodsParams['sellerProductName'].' '.implode(' ', $itemNameList);
			$nowItem['externalVendorSku']			= "{$goodsData['goodsInfo']['goods_seq']}";

			$nowItem['unitCount']					= 0;

			$nowItem['attributes']					= $attributes;
			$nowItem['notices']						= $notices;
			$nowItem['maximumBuyCount']				= $goodsData['defaultOption']['stock'];
			$nowItem['outboundShippingTimeDay']		= $addinfoParams['outboundShippingTimeDay'];
			$nowItem['contents']					= $contents;
			$nowItem['images']						= $images;
			$nowItem['maximumBuyForPerson']			= $maximumBuyForPerson;
			$nowItem['maximumBuyForPersonPeriod']	= $maximumBuyForPersonPeriod;
			$nowItem['texType']						= $texType;
			$nowItem['adultOnly']					= $adultOnly;
			$nowItem['overseasPurchased']			= $overseasPurchased;
			$nowItem['parallelImported']			= $parallelImported;
			$nowItem['freePriceType']				= $freePriceType;

			if (count($searchTags) > 0)
				$nowItem['searchTags']				= $searchTags;
				
			$items[]	= $nowItem;

		}
		

		$goodsParams['items']		= $items;
		/************************/


		/* 추가정보 입력 */
		$brandKey					= array_search('브랜드', $addInfoKey);
		$goodsParams['brand']		= $addInfoValue[$brandKey]['contents'];

		$manufactureKey				= array_search('제조사', $addInfoKey);
		$goodsParams['manufacture']	= $addInfoValue[$manufactureKey]['contents'];
		

		//쿠팡 상품명이 있을경우 
		$coupangGoodsNameKey					= array_search('쿠팡상품명', $addInfoKey);
		if ($coupangGoodsNameKey > 0)
			$goodsParams['sellerProductName']	= $addInfoValue[$coupangGoodsNameKey]['contents'];
		/*****************/


		// 결과값 리턴
		/*****************************************/
		$return['productInfo']	= $goodsParams;
		$return['addInfo']		= $addinfoParams;

		return $return;
		/*****************************************/
	}
}
