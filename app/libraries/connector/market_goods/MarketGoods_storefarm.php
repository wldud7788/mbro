<?php
Class MarketGoods_storefarm Implements MarketGoodsInterface
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

	/* 11번가 주소 등록용 코드검색 */
	protected function getMailNoSeqByZipcode($zipcode)
	{
		$zipcode	= str_replace('-','', $zipcode);
		$response	= $this->_connectorBasic->callGetConnector("other/getMailNoSeqByZipcode/{$zipcode}");
		$mailNoSeq	= ($response['success'] == 'Y') ? $response['resultData'] : Null;
		return $mailNoSeq;
	}


	/* 상품정보 싱크용 */
	public function syncParamaters($marketProductInfo)
	{
	}

	/* 상품정보와 추가정보 로 마켓 파라미터 생성 */
	public function marketGoodsParams($productInfo, $addInfo)
	{
		return array_merge($productInfo, $addInfo);
	}


	/* 상품정보와 추가정보 분리 생성*/
	public function buildMarketParams($allGoodsInfo, $mode)
	{
		$connectorBasic		= $this->_CI->connector::getInstance();

		/*****************************************************/
		$baseMarketInfo		= $this->baseMarketInfo;

		$goodsData			= $allGoodsInfo['goodsData'];
		$domain				= $allGoodsInfo['domain'];
		$provider_seq		= $allGoodsInfo['provider_seq'];
		$addInfoKey			= $allGoodsInfo['addInfoKey'];
		$addInfoValue		= $allGoodsInfo['addInfoValue'];
		$notificationInfo	= $allGoodsInfo['notificationInfo'];
		$optionsList		= $allGoodsInfo['optionsList'];
		$inputOptionsList	= $allGoodsInfo['inputOptionsList'];
		$subOptionsList		= $allGoodsInfo['subOptionsList'];

		$addinfoParams		= $baseMarketInfo['add_info_detail'];
		$marketCategory		= $baseMarketInfo['category_code'];
		$requiredAddInfo	= $baseMarketInfo['required_add_info'];
		$goodsParams		= array();
		/*****************************************************/

		$addinfoParams['CategoryId']	= $marketCategory;

		$searchAddressKey			= '';
		// 출고지 매칭
		if ($addinfoParams['Delivery']['ShippingAddressId'] == 'AUTO') {
			$providerInfo			= $this->_CI->providermodel->get_provider($provider_seq);
			$searchAddressKey		= $this->_connectorBasic->forMatchingText($providerInfo['provider_id']);

			if ($addinfoParams['Delivery']['ReturnAddressId'] == 'AUTO')
				$addressResult		= $this->_connectorBasic->callConnector('Other/getAllAddress');
			else
				$addressResult		= $this->_connectorBasic->callConnector('Other/getShippingAddress');

			$shippingAddressList	= array();
			$returnAddressList		= array();

			foreach ((array)$addressResult['resultData'] as $addressInfo) {

				switch ($addressInfo['AddressType']) {
					case	'00300' :
						$shippingAddressList[]		= $addressInfo;
						$returnAddressList[]		= $addressInfo;
						break;

					case	'00400' :
						$shippingAddressList[]		= $addressInfo;
						break;

					case	'00500' :
						$returnAddressList[]		= $addressInfo;
						break;
				}

			}

			if(count($shippingAddressList) < 1) {
				$return['success']	= 'N';
				$return['message']	= '스마트스토어에 등록된 출고지가 없습니다.';
				return $return;
			}

			$ShippingAddressId		= '';
			foreach($shippingAddressList as $shippingInfo) {
				$marketKey			= $this->_connectorBasic->forMatchingText($shippingInfo['Name']);

				if ($searchAddressKey == $marketKey) {
					$ShippingAddressId	= $shippingInfo['AddressId'];
					break;
				}
			}

			if ($ShippingAddressId === '') {
				$return['success']	= 'N';
				$return['message']	= "[출고지명 : {$searchAddressKey}] 해당 출고지가 없습니다.";
				return $return;
			}

			$addinfoParams['Delivery']['ShippingAddressId']		= $ShippingAddressId;
		}


		// 반품/교환 주소 매칭
		if ($addinfoParams['Delivery']['ReturnAddressId'] == 'AUTO') {
			if (is_array($returnAddressList) !== true) {
				$addressList			= $this->_connectorBasic->callConnector('Other/getReturnAddress');
				$returnAddressList		= $addressList['resultData'];

				$providerInfo			= $this->_CI->providermodel->get_provider($provider_seq);
				$searchAddressKey		= $this->_connectorBasic->forMatchingText($providerInfo['provider_id']);
			}

			if(count($returnAddressList) < 1) {
				$return['success']	= 'N';
				$return['message']	= '스마트스토어에 등록된 반품/교환지가 없습니다.';
				return $return;
			}

			$ReturnAddressId		= '';
			foreach($returnAddressList as $returnInfo) {
				$marketKey			= $this->_connectorBasic->forMatchingText($returnInfo['Name']);

				if ($searchAddressKey == $marketKey) {
					$ReturnAddressId	= $returnInfo['AddressId'];
					break;
				}
			}


			if ($ReturnAddressId === '') {
				$return['success']	= 'N';
				$return['message']	= "[반품/교환지명 : {$searchAddressKey}] 해당 반품/교환지가 없습니다.";
				return $return;
			}

			$addinfoParams['Delivery']['ReturnAddressId']		= $ReturnAddressId;
		}


		// 묶음 배송 그룹 매칭
		if ($addinfoParams['BundleGroupIdSet'] == 'AUTO') {
			if ($searchAddressKey == '') {
				$providerInfo		= $this->_CI->providermodel->get_provider($provider_seq);
				$searchAddressKey	= $this->_connectorBasic->forMatchingText($providerInfo['provider_id']);
			}

			$bundleGroupResult		= $this->_connectorBasic->callConnector("Other/getBundleGroupList");
			$bundleGroupList		= $bundleGroupResult['resultData'];

			if(count($bundleGroupList) < 1) {
				$return['success']	= 'N';
				$return['message']	= '스마트스토어에 등록된 묶음 배송 그룹이 없습니다.';
				return $return;
			}


			$BundleGroupId			= '';
			foreach($bundleGroupList as $groupInfo) {
				$marketKey			= $this->_connectorBasic->forMatchingText($groupInfo['Name']);

				if ($searchAddressKey == $marketKey) {
					$BundleGroupId	= $groupInfo['Code'];
					break;
				}
			}

			if ($BundleGroupId === '') {
				$return['success']	= 'N';
				$return['message']	= "[배송그룹명 : {$searchAddressKey}] 해당 배송그룹이 없습니다.";
				return $return;
			}

			$addinfoParams['BundleGroupIdSet']		= $BundleGroupId;
		}

		if ($addinfoParams['BundleGroupIdSet'] != 'NOT_FOR_BUNDLE') {
			$addinfoParams['Delivery']['BundleGroupAvailable']	= 'Y';
			$addinfoParams['Delivery']['BundleGroupId']			= $addinfoParams['BundleGroupIdSet'];
		} else {
			$addinfoParams['Delivery']['BundleGroupAvailable']	= 'N';
		}

		if ($addinfoParams['Delivery']['Type'] == '1') {
			$deliveryCompany = $connectorBasic->getDeliveryCompanyCode($addinfoParams['Delivery']['CompanyCode']);
			$addinfoParams['Delivery']['DeliveryCompany'] = $deliveryCompany;
		} else {
			unset($addinfoParams['Delivery']['CompanyCode']);
		}

		// 원산지 매칭
		$originKey		= array_search('원산지', $addInfoKey);
		$originText		= $addInfoValue[$originKey]['contents'];

		$originSearch	= urlencode($originText);
		$originResult	= $this->_connectorBasic->callConnector("Other/getOriginAreaList/{$originSearch}");
		$originList		= (is_array($originResult['resultData']) == true) ? $originResult['resultData'] : array();

		if(count($originList) == 1) {
			$orginArea['Code']		= $originList[0]['Code'];
		} else {
			if (strlen($originText) > 0) {
				$orginArea['Code'] = '04';
				$orginArea['Content'] = $originText;
			}
		}

		// 수입사
		$importerKey		= array_search('수입사', $addInfoKey);

		if (isset($orginArea['Code']))
			$orginArea['Importer']		= $addInfoValue[$importerKey]['contents'];


		if (isset($orginArea['Code']))
			$goodsParams['OriginArea']	= $orginArea;


		// 어린이 상품 인증 대상 설정값이 없을 경우 리셋
		if ($addinfoParams['ChildCertifiedProductExclusion'] == '')	unset($addinfoParams['ChildCertifiedProductExclusion']);


		// 친환경 인증 대상 설정값이 없을 경우 
		if ($addinfoParams['GreenCertifiedProductExclusion'] == '') unset($addinfoParams['GreenCertifiedProductExclusion']);


		// 인증정보 매칭
		$useAddInfoValue	= false;
		$certificationId	= '';
		$certificationName	= '';

		//dist_category_type : M 매칭, G:그룹정보
		if ($baseMarketInfo['dist_category_type'] == 'M') {
			if (isset($requiredAddInfo['StorefarmCertification']) === true) {
				if ($requiredAddInfo['StorefarmCertification']['value'] != 'USE_ADDINFO') {
					$certificationId	= $requiredAddInfo['StorefarmCertification']['value'];
					$certificationName	= $requiredAddInfo['StorefarmCertification']['valueText'];
				} else {
					$useAddInfoValue	= true;
				}

			}
		} else {
			$useAddInfoValue			= true;
		}

		// 친환경 인증 제외이고 아동용상품 인증 제외 인 경우 인증정보 설정안함.
		// 인증대상 : N, 인증제외 : Y
		if($addinfoParams['ChildCertifiedProductExclusion'] != "N"
				&& $addinfoParams['GreenCertifiedProductExclusion'] != "N") {
					$useAddInfoValue = false;
		}

		if ($useAddInfoValue === true) {
			$certificationId		= $addinfoParams['StorefarmCertification'];
			$certificationName		= $addinfoParams['StorefarmCertificationText'];
		}

		// 인증정보 설정(어린이제품 인증 대상 카테고리의 경우 필수)
		if (strlen($certificationId) > 1) {
			$certifiKey						= array_search('인증번호', $addInfoKey);
			$certificationInfo				= array();
			$certificationNameTmp			= explode(':', $certificationName);
			$certificationInfo['Id']		= $certificationId;
			$certificationInfo['Name']		= trim($certificationNameTmp[0]);
			$certificationInfo['Number']	= $addInfoValue[$certifiKey]['contents'];
			$certificationInfo['KindType']  = $this->getKindType($certificationInfo['Id'], $addinfoParams['KCCertifiedProductExclusion']);
			
			$companyNameKey					= array_search('인증상호', $addInfoKey);
			if ($companyNameKey !== false)
				$certificationInfo['CompanyName']	= $addInfoValue[$companyNameKey]['contents'];

			$goodsParams['CertificationList']['Certification'][]	= $certificationInfo;
		}


		// 시작일 설정
		switch ($addinfoParams['saleStartSet']) {
			case	'TODAY' :
				$addinfoParams['saleStartSet']		= 'SETDATE';
				$addinfoParams['SaleStartDate']		= date('Y-m-d');
				break;
		}


		// 종료일 설정
		switch ($addinfoParams['saleEndSet']) {
			case	'INFINITE' :
				$addinfoParams['SaleEndDate']		= '2099-12-31';
				break;
		}

		// AreaType 설정 안하면 리셋
		if ($addinfoParams['Delivery']['AreaType'] == '')
			unset($addinfoParams['Delivery']['AreaType']);


		//STATUS
		/*
		 *	SALE	- 판매중
		 *  SUSP	- 판매 중지
		 * 	OSTK	- 품절
		 */
		if($goodsData['goodsInfo']['goods_status'] == "normal" && $goodsData['goodsInfo']['goods_view'] == "look")
			$goodsParams['StatusType']		= "SALE";
		else
			$goodsParams['StatusType']		= "SUSP";

		// 1회 최대 구매수량
		if($goodsData['goodsInfo']['max_purchase_limit'] == "limit")
			$goodsParams['MaxPurchaseQuantityPerOrder']	= 	$goodsData['goodsInfo']['max_purchase_ea'];

		// 최소 구매수량
		if($goodsData['goodsInfo']['min_purchase_limit'] == "limit")
			$goodsParams['MinPurchaseQuantity']			= 	$goodsData['goodsInfo']['min_purchase_ea'];


		$goodsParams['SaleType']					= "NEW";	//상품 판매 유형 : NEW-새상품, OLD-중고상품, REFUR-리퍼, DSP-진열
		$goodsParams['Name']						= $goodsData['goodsInfo']['goods_name'];
		$goodsParams['PublicityPhraseContent']		= "";		//홍보문구
		$goodsParams['PublicityPhraseStartDate']	= "";		//홍보 문구 전시 시작일
		$goodsParams['PublicityPhraseEndDate']		= "";		//홍보 문구 전시 종료일
		$goodsParams['SellerManagementCode']		= $baseMarketInfo['goods_seq'];
		$goodsParams['SellerBarCode']				= $goodsData['goodsInfo']['goods_code'];
		$goodsParams['MinorPurchasable']			= ($goodsData['goodsInfo']['adult_goods'] == 'Y') ? 'N' : 'Y';
		$goodsParams['TaxType']						= ($goodsData['goodsInfo']['tax']  == 'exempt') ? 'DUTYFREE' : 'TAX';
		$goodsParams['DetailContent']				= preg_replace('/src=([",\'])(\/data\/editor)/smi', "src=$1".get_connet_protocol()."$domain$2", $goodsData['goodsInfo']['contents']);
		$goodsParams['DetailContent']				= str_replace('src="//','src="'.get_connet_protocol(),$goodsParams['DetailContent']);
		$goodsParams['SalePrice']					= $goodsData['defaultOption']['price'];


		// 필수 옵션
		if ($goodsData['goodsInfo']['option_use'] == '1') {

			$nowOption	= array();
			$optionCnt	= 0;
			$totalStock	= 0;
			foreach ($optionsList[0]['option_divide_title'] as $titleIdx => $titleInfo) {
				$optionCnt++;

				if ($optionCnt > 3) {
					$return['success']	= 'N';
					$return['message']	= '스마트스토어 옵션은 최대 3가지까지만 등록이 가능합니다.';
					return $return;
				}

				$nowOption['Names']["Name{$optionCnt}"]		= $titleInfo;
			}

			foreach ($optionsList as $optionInfo) {
				$nowItem		= array();
				$totalStock		+= $optionInfo["stock"];

				for ($i = 1; $i <= $optionCnt; $i++)
					$nowItem["Value{$i}"]			= $optionInfo["option{$i}"];

				$nowItem['Price']					= $optionInfo['price'] - $goodsParams['SalePrice'];
				$nowItem["Quantity"]				= $optionInfo["stock"];
				$nowItem["SellerManagerCode"]		= $optionInfo["option_seq"];
				$nowItem["Usable"]					= ($optionInfo["stock"] < 1 || $optionInfo["option_view"] == 'N') ? 'N' : 'Y';

				$nowOption['ItemList']['Item'][]	= $nowItem;
			}

			$goodsParams['Option']['SortType']		= $addinfoParams['SortType'];
			$goodsParams['Option']['Combination']	= $nowOption;
			$goodsParams['StockQuantity']			= $totalStock;

			// 입력옵션
			if ($goodsData['goodsInfo']['member_input_use'] == '1') {
				$CustomList						= array();
				foreach ((array)$inputOptionsList as $inputOptionInfo) {
					$nowCustOption				= array();
					$nowCustOption['Name']		= $inputOptionInfo['input_name'];
					$nowCustOption['Usable']	= 'Y';
					$CustomList['Custom'][]		= $nowCustOption;
				}

				$goodsParams['Option']['CustomList']	= $CustomList;
			}

		} else {
			$goodsParams['StockQuantity']			= $goodsData['defaultOption']['stock'];
		}

		// 추가구성 옵션
		if ($goodsData['goodsInfo']['option_suboption_use'] == '1') {

			$supplementProduct			= array();
			foreach ($subOptionsList as $subOptionDesc) {
				foreach ($subOptionDesc as $subOptionInfo) {
					$nowSupplement		= array();
					$nowSupplement['Name']					= $subOptionInfo['suboption_title'];
					$nowSupplement['Value']					= $subOptionInfo['suboption'];
					$nowSupplement['Price']					= $subOptionInfo['price'];
					$nowSupplement['Quantity']				= $subOptionInfo['stock'];
					$nowSupplement['SellerManagementCode']	= $subOptionInfo['suboption_seq'];
					$nowSupplement['Usable']				= ($subOptionInfo["stock"] < 1 || $subOptionInfo["option_view"] == 'N') ? 'N' : 'Y';

					$supplementProduct['Item'][]			= $nowSupplement;
				}
			}

			$goodsParams['SupplementProduct']['SortType']	= $addinfoParams['SortType'];
			$goodsParams['SupplementProduct']['ItemList']	= $supplementProduct;
		}


		// 이미지 리스트
		$idx	= 0;
		foreach ((array)$goodsData['goodsImage'] as $image) {
			if($idx > 6) continue;		// 이미지 7개까지 전송되도록 수정 2019-01-31

			// 이미지 url 체크
			if( preg_match('/http(s?)\:\/\//i', $image['large']['image']) ) // url인 경우
				$goodsParams['goodsImageList'][$idx]['ImageUrl']	= $image['large']['image'];
			else 															// url아닌 경우 도메인과 함께
				$goodsParams['goodsImageList'][$idx]['ImageUrl']	= "http://{$domain}{$image['large']['image']}";

			$idx++;
		}


		/* 추가정보 입력 */
		$brandKey		= array_search('브랜드', $addInfoKey);
		if ($brandKey !== false)
			$goodsParams['Model']['BrandName']			= trim($addInfoValue[$brandKey]['contents']);

		$manufactureKey	= array_search('제조사', $addInfoKey);
		if ($brandKey !== false)
			$goodsParams['Model']['ManufacturerName']	= trim($addInfoValue[$manufactureKey]['contents']);

		$modelKey			= array_search('모델명', $addInfoKey);
		if ($modelKey !== false)
			$goodsParams['Model']['ModelName']			= trim($addInfoValue[$modelKey]['contents']);


		$manufactureDateKey	= array_search('생산일자', $addInfoKey);
		if ($manufactureDateKey !== false)
			$goodsParams['ManufactureDate']				= trim($addInfoValue[$manufactureDateKey]['contents']);

		$manufactureDateKey	= array_search('제조일자', $addInfoKey);
		if ($manufactureDateKey !== false && empty($goodsParams['ManufactureDate']) )
			$goodsParams['ManufactureDate']				= trim($addInfoValue[$manufactureDateKey]['contents']);

		$validDateKey	= array_search('유효일자', $addInfoKey);
		if ($validDateKey !== false)
			$goodsParams['ValidDate']					= trim($addInfoValue[$validDateKey]['contents']);
		
		$powerConsumptionKey	= array_search('소비전력', $addInfoKey);
		if ($powerConsumptionKey !== false)
			$goodsParams['PowerConsumption']					= trim($addInfoValue[$powerConsumptionKey]['contents']);


		// 상품 고시정보
		$notificationDesc	= array();
		foreach ((array)$notificationInfo['notifictionList'] as $key => $val)
			$notificationDesc[$key]		= $val;

		foreach ((array)$addinfoParams['AddSummary'] as $key => $val)
			$notificationDesc[$key]		= (strlen(trim($val)) > 5) ? $val : '상세설명 참조';

		// 건강기능식품인 경우 소재지, 용량 추가로 요청하여 제조업소의 명칭과, 수량 동일하게 전송함. 2018-11-29 by hyem
		if($goodsData['goodsInfo']['goods_sub_info'] == '21') {
			if(isset($notificationDesc['Producer']))	$notificationDesc['Location']	= $notificationDesc['Producer'];
			if(isset($notificationDesc['Amount']))		$notificationDesc['Weight']		= $notificationDesc['Amount'];
		}
		$goodsParams['ProductSummary'][$notificationInfo['notificationCode']]	= $notificationDesc;

		/*****************************************/
		$return['productInfo']	= $goodsParams;
		$return['addInfo']		= $addinfoParams;

		return $return;
		/*****************************************/
	}
	
	/**
	 * 인증 정보 종류 코드를 반환한다
	 * 2019-09-03
	 * @author Sunha Ryu
	 *
	 * @param string $id 인증번호
	 * @param string $KCCertifiedProductExclusion KC인증 여부 (Y:인증예외/N:인증대상)
	 * @return string KC(KC인증)|CHI(어린이제품 인증)|GRN(친환경 인증)|ETC(기타)
	 */
	protected function getKindType($id, $KCCertifiedProductExclusion = 'Y')
	{
	    
	    // 어린이 제품 인증
	    if(in_array($id, array('1042', '1040', '1041'))) {
	        
	        // KC 인증대상일 경우 KC인증으로 반환한다.
	        if($KCCertifiedProductExclusion === 'N') {
	            return "KC";
	        }
	        return "CHI";
	    }
	    
	    // KC 인증
	    if($KCCertifiedProductExclusion === 'N') {
	        if(in_array($id, array('1023', '1022', '1024', '1020', '51', '58', '65', '1021', '121', '72'))) {
                return "KC";
	        }
	    }
	    
	    // 친환경 인증
	    if(in_array($id, array('98', '268', '265', '99'))) {
	        return "GRN";
	    }
	    
	}
}
