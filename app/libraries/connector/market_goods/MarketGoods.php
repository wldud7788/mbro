<?php

class MarketGoods {
	protected $_accountInfo;

	public $market			= false;
	public $productInfo		= array();
	public $addInfo			= array();


	public function __construct(MarketGoodsInterface $market)
	{	
		$this->market		= $market;
	}

	public function setMarketGoodsParams($mode = 'register')
	{
		$allGoodsInfo		= $this->getGoodsData();

		if (is_array($allGoodsInfo['goodsData']['goodsImage']) == false || count($allGoodsInfo['goodsData']['goodsImage']) < 1) {
			$return['success']	= 'N';
			$return['message']	= "상품 이미지가 없습니다.";
			return $return;
		}


		$return				= $this->market->buildMarketParams($allGoodsInfo, $mode);

		$this->productInfo	= $return['productInfo'];
		$this->addInfo		= $return['addInfo'];
		

		return $return;
	
	}

	// 개별 수정은 원 상품의 정보 및 추가정보의 변경분은 반영하지 않는다.
	public function getMarketGoodsParamsForUpdate($productInfo, $addInfo)
	{
		$return['productInfo']	= $productInfo;
		$return['addInfo']		= $addInfo;

		$this->productInfo		= $return['productInfo'];
		$this->addInfo			= $return['addInfo'];

		return $return;
	}

	public function getMarketGoodsParams()
	{
		$result = $this->market->marketGoodsParams($this->productInfo, $this->addInfo);
		return $result;
	}

	public function getGoodsData()
	{
		$_CI	=& $this->market->_CI;
		$_CI->load->model('goodsmodel');
		$_CI->load->model('providershipping');
		$_CI->load->model('connectormodel');

		$connectorBasic		= $_CI->connector::getInstance();
		$baseMarketInfo		= $this->market->baseMarketInfo;
		$goodsData			= $_CI->connectormodel->getGoodsInfoByGoodsSeq($baseMarketInfo['goods_seq']);

		$accountParams['market']	= $baseMarketInfo['market'];
		$accountParams['sellerId']	= $baseMarketInfo['seller_id'];
		$this->_accountInfo			= $_CI->connectormodel->getAccountInfo($accountParams);
		$orderOpt					= config_load('order');	//재고변화에 따른 상품판매 여부(통합설정)

		//재고변화에 따른 상품판매 여부(개별정책이 있을 때)
		if($goodsData['goodsInfo']['runout_policy'] !== ""){
			$orderOpt['runout']			= $goodsData['goodsInfo']['runout_policy'];
			$orderOpt['ableStockLimit'] = $goodsData['goodsInfo']['able_stock_limit'];
		}

		// 가격및 재고 수량 조정
		$goodsData['defaultOption']['price']			= $this->_priceAdjustment((int)$goodsData['defaultOption']['price']);
		$goodsData['defaultOption']['consumer_price']	= $this->_priceAdjustment((int)$goodsData['defaultOption']['consumer_price']);
		$goodsData['defaultOption']['stock']			= $this->_stockAdjustment((int)$goodsData['defaultOption']['stock'], $orderOpt);

		if($_CI->config_system['operation_type'] == 'light'){
			$goodsData['goodsInfo']['contents'] = $goodsData['goodsInfo']['mobile_contents'];
		}

		$return						= array();
		$return['goodsData']		= $goodsData;
		$optionsList				= array();
		$subOptionsList				= array();

		if ($goodsData['goodsInfo']['option_use'] == '1') {
			$optionsList	= $_CI->goodsmodel->get_goods_option($baseMarketInfo['goods_seq']);
			foreach ($optionsList as $key => $option) {
				$optionsList[$key]['price']			 = $this->_priceAdjustment((int)$option['price']);
				$optionsList[$key]['consumer_price'] = $this->_priceAdjustment((int)$option['consumer_price']);
				$optionsList[$key]['stock']			 = $this->_stockAdjustment((int)$option['stock'], $orderOpt);
			}
		}
		$return['optionsList']	= $optionsList;

		if ($goodsData['goodsInfo']['option_suboption_use'] == '1') {
			$subOptionsList		= $_CI->goodsmodel->get_goods_suboption($baseMarketInfo['goods_seq']);
			foreach ($subOptionsList as $key => $subOptionArray) {
				foreach ($subOptionArray as $subKey => $subOption) {
					$subOptionsList[$key][$subKey]['price']			 = $this->_priceAdjustment((int)$subOption['price']);
					$subOptionsList[$key][$subKey]['consumer_price'] = $this->_priceAdjustment((int)$subOption['consumer_price']);
					$subOptionsList[$key][$subKey]['stock']			 = $this->_stockAdjustment((int)$subOption['stock'], $orderOpt);
				}
			}
		}

		$return['subOptionsList']	= $subOptionsList;
		$return['inputOptionsList']	= $_CI->goodsmodel->get_goods_input($baseMarketInfo['goods_seq']);

		if ($_CI->config_system['domain'])
			$return['domain']		= $_CI->config_system['domain'];
		else
			$return['domain']		= $_CI->config_system['subDomain'];

		$return['provider_seq']		= ($return['goodsData']['goodsInfo']['provider_seq'] > 1) ? $return['goodsData']['goodsInfo']['provider_seq'] : 1;

		// 오픈마켓 검색어 가져오기 2018-07-24
		$market = $baseMarketInfo['market'];
		if(stripos($baseMarketInfo['market'],"API") !== false){
			$market = 'shoplinker';
		}
		$keyword = ($return['goodsData']['goodsInfo']['keyword_linkage']) ? $return['goodsData']['goodsInfo']['keyword_linkage'] : $return['goodsData']['goodsInfo']['keyword'];
		$return['goodsData']['goodsInfo']['keyword'] = array_pop($_CI->goodsmodel->get_openmarket_keyword($keyword, array($market)));

		// 오픈마켓 상품명이 있을 때만 goods_name 업데이트
		if( $return['goodsData']['goodsInfo']['goods_name_linkage'] ) {
			$return['goodsData']['goodsInfo']['goods_name'] = $return['goodsData']['goodsInfo']['goods_name_linkage'];
		}
		// 오픈마켓 검색어 가져오기 2018-07-24

		foreach ((array)$return['goodsData']['goodsAddition'] as $val) {
			$addInfoKey[$val['addition_seq']]	= $val['name'];
			$addInfoValue[$val['addition_seq']]	= $val;
		}

		$return['addInfoKey']		= $addInfoKey;
		$return['addInfoValue']		= $addInfoValue;

		$goodsSubInfo				= $return['goodsData']['goodsInfo']['goods_sub_info'];
		$subInfoDesc				= $return['goodsData']['goodsInfo']['sub_info_desc'];
		$return['notificationInfo']	= $connectorBasic->getNotificationInfo($goodsSubInfo, $subInfoDesc, $baseMarketInfo['market']);

		// 상품사진(상품상세확대) 체크
		foreach ($return['goodsData']['goodsImage'] as $key => $val) {
			if( $val['large']['image'] == "") {
				unset($return['goodsData']['goodsImage'][$key]);
			}
		}

		return $return;
	}

	protected function _priceAdjustment(int $orgPrice)
	{
		$priceSet		= $this->_accountInfo['goodsPriceSet']['adjustment'];
		if ($priceSet['use'] != 'Y' || $orgPrice < 1)
			return $orgPrice;

		switch ($priceSet['unit']) {
			case	'PER' :
				$ajdPer		= $priceSet['value'] / 100;
				$adjPrice	= $orgPrice  *  $ajdPer;
				break;

			default :
				$adjPrice	= $priceSet['value'];
		}

		switch ($priceSet['type']) {
			case	'MINUS' :
				$tmpPrice	= $orgPrice - $adjPrice;
				break;

			default :
				$tmpPrice	= $orgPrice + $adjPrice;
		}

		return $this->_cutting(floor($tmpPrice));

	}

	protected function _cutting($value)
	{

		$cuttingUnit	= (int)$this->_accountInfo['goodsPriceSet']['cutting']['unit'];
		
		if ($cuttingUnit == 0)
			return $value;

		$cuttingValue	=  $value % $cuttingUnit;
		$tmpValue		= $value - $cuttingValue;

		//$this->_accountInfo['goodsPriceSet']['cutting']['type']	= 'UP'; 왜 강제로 처리했는지는 모르겠음 테스트 코드인듯하여 주석처리
		switch ($this->_accountInfo['goodsPriceSet']['cutting']['type']) {
			case	'ROUND' :
				$roundCheck	= $cuttingUnit / 2;
				if ($roundCheck <= $cuttingValue)
					$resultValue	= $tmpValue + $cuttingUnit;
				else
					$resultValue	= $tmpValue;
				break;

			case 	'UP' :
				if ($cuttingValue > 0)
					$resultValue	= $tmpValue + $cuttingUnit;
				else
					$resultValue	= $tmpValue;
				break;

			default :
				$resultValue	= $tmpValue;
		}

		return $resultValue;
	}

	protected function _stockAdjustment(int $orgStock, $orderOpt)
	{

		$goodsStockSet		= $this->_accountInfo['goodsStockSet']['adjustment'];
		if ($goodsStockSet['use'] == 'Y')
			return $goodsStockSet['value'];
		else
			return ($orderOpt['runout'] != 'unlimited') ? $orgStock : 9999;
	}
}
