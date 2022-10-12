<?php
Class MarketGoods_open11st Implements MarketGoodsInterface 
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
		$result = array_merge($productInfo, $addInfo);

		// 전송하는 모든 내용을 htmlspecialchars 처리함
		array_walk_recursive($result, function(&$item, $key) {
			$except = array('htmlDetail');
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
		$baseMarketInfo		= $this->baseMarketInfo;

		$goodsData			= $allGoodsInfo['goodsData'];
		$domain				= $allGoodsInfo['domain'];
		$provider_seq		= $allGoodsInfo['provider_seq'];
		$addInfoKey			= $allGoodsInfo['addInfoKey'];
		$addInfoValue		= $allGoodsInfo['addInfoValue'];
		$notificationInfo	= $allGoodsInfo['notificationInfo'];
		$optionsList		= $allGoodsInfo['optionsList'];
		$subOptionsList		= $allGoodsInfo['subOptionsList'];
		$inputOptionsList	= $allGoodsInfo['inputOptionsList'];
		$addinfoParams		= $baseMarketInfo['add_info_detail'];
		$goodsParams		= array();
		/*****************************************************/

		if(in_array('인증유형', $addInfoKey) || in_array('인증번호', $addInfoKey)) {
			$certTypeArrKey = array_search('인증유형', $addInfoKey);

			if(!in_array($certTypeArrKey, array(131,132))) {
				$certCodeArrKey = array_search('인증번호', $addInfoKey);

				$certTypeArr = $addInfoValue[$certTypeArrKey];
				$certCodeArr = $addInfoValue[$certCodeArrKey];

				$addinfoParams['ProductCert']['certTypeCd'] = $certTypeArr['contents'];
				$addinfoParams['ProductCert']['certKey'] = $certCodeArr['contents'];
			}
		}

		//반품/교환지 주소
		if($addinfoParams['addrSeqIn'] == 'AUTO') {

			$providerInfo	= $this->_CI->providermodel->get_provider($provider_seq);
			$marketAddress	= $this->_connectorBasic->callGetConnector('other/getReturnAddress');
			$searchKey		= $this->_connectorBasic->forMatchingText($providerInfo['provider_id']);
			$foundAddrSeq	= false;
			
			foreach((array)$marketAddress['resultData'] as $addr) {
					
				$targetText	= $this->_connectorBasic->forMatchingText($addr['addrNm']);
				if ($targetText == $searchKey) {
					$foundAddrSeq	= $addr['addrSeq'];
					break;
				}
			}

			//매칭된 출고지가 없으면 실패
			if ($foundAddrSeq === false) {
				$return['success']	= 'N';
				$return['message']	= '11번가에 등록된 반품/교환지가 없습니다.';
				return $return;
			}

			$addinfoParams['addrSeqIn']		= $foundAddrSeq;
		}


		//출고지지 주소
		if($addinfoParams['addrSeqOut'] == 'AUTO') {
				
			$providerInfo	= $this->_CI->providermodel->get_provider($provider_seq);
			$marketAddress	= $this->_connectorBasic->callGetConnector('other/getShippingAddress');

			$searchKey		= $this->_connectorBasic->forMatchingText($providerInfo['provider_id']);

			$foundAddrSeq	= false;

			foreach((array)$marketAddress['resultData'] as $addr) {
				
				$targetText	= $this->_connectorBasic->forMatchingText($addr['addrNm']);

				if ($targetText == $searchKey) {
					$foundAddrSeq	= $addr['addrSeq'];
					break;
				}
			}

			//매칭된 출고지가 없으면 실패
			if ($foundAddrSeq === false) {
				$return['success']	= 'N';
				$return['message']	= '11번가에 등록된 출고지가 없습니다.';
				return $return;
			}
			
			$addinfoParams['addrSeqOut']	= $foundAddrSeq;
		}
		$goodsParams['dispCtgrNo']			= $baseMarketInfo['category_code'];
		$goodsParams['sellerPrdCd']			= $baseMarketInfo['goods_seq'];
		$goodsParams['prdNm']				= $goodsData['goodsInfo']['goods_name'];
		$goodsParams['advrtStmt']			= $this->marketTextSubstr($goodsData['goodsInfo']['summary'], 28);
		$goodsParams['htmlDetail']			= $goodsData['goodsInfo']['contents'];
		$goodsParams['htmlDetail']			= str_replace('src="//','src="'.get_connet_protocol(),$goodsParams['htmlDetail']);
		$goodsParams['suplDtyfrPrdClfCd']	= ($goodsData['goodsInfo']['tax']  == 'exempt') ? '02' : '01';
		$goodsParams['minorSelCnYn']		= ($goodsData['goodsInfo']['adult_goods'] == 'Y') ? 'N' : 'Y';
		$goodsParams['selPrc']				= $goodsData['defaultOption']['price'];
		$goodsParams['maktPrc']				= $goodsData['defaultOption']['consumer_price'];
		$goodsParams['prdSelQty']			= $goodsData['defaultOption']['stock'];
		$goodsParams['brand']				= '알수없음';
			

		$goodsParams['htmlDetail']			= preg_replace('/src=([",\'])(\/data\/editor)/smi', "src=$1".get_connet_protocol()."$domain$2", $goodsParams['htmlDetail']);

		//최대 구마수량 제한
		if ($goodsData['goodsInfo']['max_purchase_limit'] == 'limit') {
			$goodsParams['selLimitTypCd']	= '01';
			$goodsParams['selLimitQty']		= $goodsData['goodsInfo']['max_purchase_ea'];
		}

		//최소 구마수량 제한
		if ($goodsData['goodsInfo']['min_purchase_limit'] == 'limit') {
			$goodsParams['selMinLimitTypCd']= '01';
			$goodsParams['selMinLimitQty']	= $goodsData['goodsInfo']['min_purchase_ea'];
		}


		$goodsParams['optSelectYn']			= ($goodsData['goodsInfo']['option_use'] == '1') ? 'Y' : 'N';


		if ($goodsData['goodsInfo']['option_use'] == '1') {
			
			$goodsParams['txtColCnt']		= '1';
			$goodsParams['prdExposeClfCd']	= '01';
			$goodsParams['colTitle']		= implode('/', (array)$goodsData['defaultOption']['option_divide_title']);

			/***************** 11번가 멀티옵션 수정 *************************/
			if(count($goodsData['defaultOption']['option_divide_title']) == 1 ) {
				//옵션있음
				foreach ((array)$optionsList as $optionInfo) {
					$nowOption	= array();
					$nowOption['colValue0']				= implode('/', (array)$optionInfo['opts']);
					$nowOption['colOptPrice']			= $optionInfo['price'] - $goodsData['defaultOption']['price'];
					$nowOption['colCount']				= $optionInfo['stock'];
					$nowOption['useYn']					= ($nowOption['colCount'] < 1 || $optionInfo["option_view"] == 'N') ? 'N' : 'Y';

					//$nowOption['colSellerStockCd']		= $optionInfo['option_seq'];
					//$nowOption['optionMappingKey']		= implode('<+>', (array)$optionInfo['opts']);

					$goodsParams['ProductOption'][]		= $nowOption;
				}
			} else if (count($goodsData['defaultOption']['option_divide_title']) > 1) {
				unset($goodsParams['colTitle']);
				
				foreach ((array)$optionsList as $optionInfo) {
					$nowOption = array();

					$title = $optionInfo['option_divide_title'];
					$opts = $optionInfo['opts'];
					$optionMapping = "";

					foreach($title as $key => $val) {
						if($optionMapping) $optionMapping .= "†";
						$optionMapping .= $title[$key].":".$opts[$key];
						
					}

					$nowOption = array(
									'useYn'				=> 'Y',
									'colOptPrice'		=> $optionInfo['price'] - $goodsData['defaultOption']['price'],
									'colCount'			=> $optionInfo['stock'],
									'optionMappingKey'	=> $optionMapping
								);

					$goodsParams['ProductOptionExt']['ProductOption'][] = $nowOption;

					foreach($optionInfo['option_divide_title'] as $key => $val) {
						if(!in_array($optionInfo['opts'][$key], $optionData[$val] )) $optionData[$val][] = $optionInfo['opts'][$key];
					}
				}


				foreach($optionData as $key => $data) {
					$nowData = array();
					$nowData['colTitle'] = $key;
					foreach( $data as $row) {
						$rowData = array();
						$rowData['colOptPrice'] = 0;
						$rowData['colValue0'] = $row;
						$nowData['ProductOption'][] = $rowData;
					}
					$goodsParams['ProductRootOption'][] = $nowData;
				}

			}
			/***************** 11번가 멀티옵션 수정 *************************/

				
		}

		if ($goodsData['goodsInfo']['option_suboption_use'] == '1') {
			foreach ($subOptionsList as $subOptionArr) {
				foreach ($subOptionArr as $subOptionInfo) {
					$nowSubOption		= array();
					$nowSubOption['addPrdGrpNm']		= $subOptionInfo['suboption_title'];
					$nowSubOption['compPrdNm']			= $subOptionInfo['suboption'];
					$nowSubOption['sellerAddPrdCd']		= $subOptionInfo['suboption_seq'];
					$nowSubOption['addCompPrc']			= $subOptionInfo['price'];
					$nowSubOption['compPrdQty']			= $subOptionInfo['stock'];
					$nowSubOption['compPrdVatCd']		= $goodsParams['suplDtyfrPrdClfCd'];
					$nowSubOption['addUseYn']			= ($nowSubOption['compPrdQty'] > 0) ? 'Y' : 'N';

					$goodsParams['ProductComponent'][]	= $nowSubOption;
				}
			}
		}

		/* 11번가 입력옵션 지원안함 ..... 2019-01-30 
		if ($goodsData['goodsInfo']['member_input_use'] == '1') {
			foreach ((array)$inputOptionsList as $inputOptionInfo) {

				if($inputOptionInfo['input_name'] == '')
					continue;

				$nowInputOption		= array();
				$nowInputOption['colOptName']		= $inputOptionInfo['input_name'];
				$nowInputOption['colOptUseYn']		= 'Y';

				$goodsParams['ProductCustOption'][]	= $nowInputOption;
			}
		}*/
		

		//이미지
		$imageNumber	= 0;
		foreach ((array)$goodsData['goodsImage'] as $image) {
			$imageNumber++;
			
			if($imageNumber > 4) break;

			$imageCode						= sprintf("prdImage%02s", $imageNumber);
			
			// url 체크 2018-11-30 by hyem
			if( preg_match('/http(s?)\:\/\//i', $image['large']['image']) ) // url인 경우
				$goodsParams[$imageCode]	= $image['large']['image'];
			else															// url아닌 경우 도메인과 함께
				$goodsParams[$imageCode]	= "http://{$domain}{$image['large']['image']}";
		}


		//추가정보 입력
		$brandKey		= array_search('브랜드', $addInfoKey);
		if($brandKey != false)
			$goodsParams['brand']	= $addInfoValue[$brandKey]['contents'];
		
		$orginKey		= array_search('구입처', $addInfoKey);
		if($orginKey != false)
			$goodsParams['abrdBuyPlace']	= $addInfoValue[$orginKey]['contents'];
	
		$orginKey		= array_search('원산지', $addInfoKey);
		if($orginKey != false)
			$goodsParams['orgnNmVal']	= $addInfoValue[$orginKey]['contents'];


		$madeDateKey	= array_search('제조일자', $addInfoKey);
		if($madeDateKey != false)
			$goodsParams['mnfcDy']		= $addInfoValue[$madeDateKey]['contents'];

		$effecDateKey	= array_search('유효일자', $addInfoKey);
		if($effecDateKey != false)
		$goodsParams['eftvDy']	= $addInfoValue[$effecDateKey]['contents'];

		//상품고시정보 입력
		$notifacationList		= array();

		foreach ((array)$notificationInfo['notifictionList'] as $key => $val) {
			$nowNoti['code']	= $key;
			$nowNoti['name']	= $val;
			$notifacationList[]	= $nowNoti;
		}
			
		$notification['type']	= $notificationInfo['notificationCode'];
		$notification['item']	= $notifacationList;
			
		$goodsParams['ProductNotification']	= $notification;
		$goodsParams['marketGoodsName']		= $goodsParams['prdNm'];

		
		if ($mode == 'update') {
			$goodsParams['optUpdateYn']		= 'Y';
		}

		/*****************************************/
		$return['productInfo']	= $goodsParams;
		$return['addInfo']		= $addinfoParams;

		return $return;
		/*****************************************/
	}

	/*
	* 11번가 전용 substr
	* 한글은 2 count , 그외는 1 count
	*/
	public function marketTextSubstr($text, $length=28) {
		
		$count = 0;
		$text = preg_split('//u', $text, null, PREG_SPLIT_NO_EMPTY);
		foreach($text as $t) {
			if(preg_match("/[\xE0-\xFF][\x80-\xFF][\x80-\xFF]/", $t)) $count += 2;
			else $count+= 1;

			if( $count < $length) {
				$result .= $t;
			} else {
				if($count == $length) {
					$result .= $t;
				}
				continue;
			}
		}
		return $result;
	}
}
