<?php

Class GoodsService  extends ServiceBase
{

	protected $_ServiceName		= 'goods';
	public $productStatus;
	
	public function __construct($params = array())
	{
		parent::__construct($params);
		$this->_CI->load->model('connectormodel');
		$this->productStatus	= $this->getStatusCode('product');
		
		/*2017-12-06 샵링커 마켓 설정 추가*/
		$find			= $this->_CI->db->query("SELECT * FROM fm_market_account WHERE market LIKE 'API%' and delete_yn = 'N' and account_use = 'Y' group by market");
		$findRow		= $find->result();
		
		$this->_CI->load->model('connectormodel');
		$connectorModel		=& $this->_CI->connectormodel;
		foreach ($findRow as $val){
			$getParam['searchMarket'] = $val->market;
			$rtn = $connectorModel->getLinkageMarket($getParam);
			$this->_supportMarkets[$val->market]['name'] = $rtn[0]['marketName'];
			$this->_supportMarkets[$val->market]['productLink'] = '';
		}
		
		/*2017-12-06 샵링커 마켓 설정 추가*/
	}

	public function getServiceName(){ return $this->_ServiceName; }
	
	public function addDistributor($addInfoSeq, $categoryType, $duplicateType, $goodsSeqList, $addInfoOther=null)
	{
		$connectorModel	=& $this->_CI->connectormodel;
		
		if($addInfoSeq > 0){
			$addInfo		= $connectorModel->getMarketAddInfo($addInfoSeq);
		}else{
			$addInfo		= $addInfoOther;
		}
		
		$goodsSeqList	= array_unique($goodsSeqList);
		$allGoodsCnt	= count($goodsSeqList);

		if ($duplicateType !== 'Y') {
			$distributedList	= $connectorModel->getAlreadyDistributedGoods($addInfo['market'], $addInfo['seller_id'], $goodsSeqList);
			
			foreach((array) $distributedList as $goodsSeq) {

				$arrayIdx		= array_search($goodsSeq, $goodsSeqList);
				if ($arrayIdx !== false)
					unset($goodsSeqList[$arrayIdx]);
			}
		}
		
		$alreadyDist	= $allGoodsCnt - count($goodsSeqList);
		$alreadyStandby	= 0;

		$goodsSeqList	= array_values($goodsSeqList);
		
		$updateCnt		= 20;
		$arrayCount		= count($goodsSeqList);
		$maxPage		= ceil($arrayCount / $updateCnt);
		$endPoint		= 0;
		$insertBase		= array();
		$insertBase['add_info_seq']			= $addInfoSeq;
		$insertBase['dist_category_type']	= $categoryType;
		$insertBase['registered_time']		= date("Y-m-d H:i:s");;

		for ($i = 1; $i <= $maxPage; $i++) {
			$startPoint	= $endPoint;
			$endPoint	= $i * $updateCnt;
			$endPoint	= ($endPoint > $arrayCount) ? $arrayCount : $endPoint;
			$insertList	= array();

			for ($j = $startPoint; $j < $endPoint; $j++) {
				if ($goodsSeqList[$j] < 1)
					continue;

				if ((int)$goodsSeqList[$j] > 0) {
					$where					= array();
					$where['add_info_seq']	= $addInfoSeq;
					$where['goods_seq']		= (int)$goodsSeqList[$j];
					$this->_CI->db->where($where);
					$result		= $this->_CI->db->get('fm_market_dist_standby');

					if (count($result->result()) > 0) {
						$alreadyStandby++;
						continue;
					}

					$nowInsert				= $insertBase;
					$nowInsert['goods_seq']	= (int)$goodsSeqList[$j];
					$insertList[]			= $nowInsert;
				}
			}
			
			if (count($insertList) < 1)
				continue;

			$this->_CI->db->insert_batch('fm_market_dist_standby', $insertList);
		}

		
		$return['successCnt']		=$arrayCount - $alreadyStandby;
		$return['requestCnt']		= $allGoodsCnt;
		$return['alreadyDist']		= $alreadyDist;
		$return['alreadyStandby']	= $alreadyStandby;

		return $return;
	}


	/* 마켓 상품등록 */
	public function doMarketGoodsRegister($idx)
	{
		$connectorModel		=& $this->_CI->connectormodel;

		$baseMarketInfo		= $connectorModel->getDistributeDetail($idx);

		if ($baseMarketInfo['dist_category_type'] == 'M') {
			//매칭 카테고리 처리
			$this->_CI->load->model('goodsmodel');

			$defaultCategory	= $this->_CI->goodsmodel->get_goods_category_default($baseMarketInfo['goods_seq']);

			$params['market']	= $baseMarketInfo['market'];
			$params['sellerId']	= $baseMarketInfo['seller_id'];

			if (strlen($defaultCategory['category_code']) > 3)
				$categoryInfo	= $connectorModel->getMatchCategoryInfoByFm($defaultCategory['category_code'], $params)['marketCategoryList'];
			else
				$categoryInfo	= [];
			if (count($categoryInfo) < 1) {
				//매칭괸 카테고리가 없을경우
				$return['market_name']			= $this->_supportMarkets[$baseMarketInfo['market']]['name'];
				$return['market_goods_name']	= '';
				$return['market_category_name']	= '';
				$return['seller_id']			= $baseMarketInfo['seller_id'];
				$return['result_type']			= 'N';
				$return['result_text']			= '<span class="bold" style="color:red">실패</span>';
				$return['result_message']		= '매칭된 카테고리가 없습니다.';

				$this->goodsRegisterFailUpeate($idx, $return);
			} else {

				//1개의 카테고리만 연동
				foreach ($categoryInfo[0] as $key => $val)
					$baseMarketInfo[$key]		= $val;

				$return		= $this->_marketGoodsRegister($idx, $baseMarketInfo);
			}
		} else {
			//추가정보 기본 카테고리 처리
			$return			= $this->_marketGoodsRegister($idx, $baseMarketInfo);
		}

		return $return;
	}


	/* 마켓 매칭카테고리 정보 */
	public function getMarketCategoryByFmCategoryCode($fmCategoryCode, $market, $seller_id)
	{
		if (!$fmCategoryCode)
			return [];

		$params['market']		= $market;
		$params['sellerId']		= $seller_id;

		$matchedCategoryInfo	= $this->_CI->connectormodel->getMatchCategoryInfoByFm($fmCategoryCode, $params);

		return $matchedCategoryInfo['marketCategoryList'];
	}


	/* 마켓 상품등록 실행*/
	protected function _marketGoodsRegister($idx, $baseMarketInfo)
	{
		if(strpos($baseMarketInfo['market'],"API") !== false){
			$class			= "MarketGoods_shoplinker";
			$marketParameters['shoplinker'] = true;
		}else{
			$class			= "MarketGoods_{$baseMarketInfo['market']}";
		}
		
		if (class_exists($class) === true) {
			$setMarket	= new $class($baseMarketInfo);
			$doMarket	= new MarketGoods($setMarket);
			$paramsInfo	= $doMarket->setMarketGoodsParams();
		} else {
			$paramsInfo['success']	= 'N';
			$paramsInfo['message']	= "[{$baseMarketInfo['market']}] 알 수 없는 마켓입니다.";
		}

		if ($paramsInfo['success'] == 'N') {
			//실패시 처리
			$return['market_name']			= $this->_supportMarkets[$baseMarketInfo['market']]['name'];
			$return['market_goods_name']	= $paramsInfo['productInfo']['marketGoodsName'];
			$return['market_category_name']	= $category_name;
			$return['seller_id']			= $baseMarketInfo['seller_id'];
			$return['result_text']			= '<span class="bold" style="color:red">실패</span>';
			$return['result_message']		= $paramsInfo['message'];

			$this->goodsRegisterFailUpeate($idx, $return);

			return $return;
		}

		$marketParameters['request']		= $doMarket->getMarketGoodsParams();
		$this->setMarketInfo($baseMarketInfo['market'], $baseMarketInfo['seller_id']);
		$response		= $this->callConnector('product/doProductRegister', $marketParameters);

		unset($category);
		$category		= $this->makeMarketCategoryName($baseMarketInfo);	
		$category_name	= implode(' > ', $category);

		$return['market_name']				= $this->_supportMarkets[$baseMarketInfo['market']]['name'];
		$return['market_goods_name']		= $paramsInfo['productInfo']['marketGoodsName'];
		$return['market_category_name']		= $category_name;
		$return['seller_id']				= $baseMarketInfo['seller_id'];
		$return['result_type']				= $response['success'];
		
		$baseMarketInfo['market_category_name']	= $category_name;

		if ($response['success'] == 'Y') {
			//성공시 처리
			$marketProductCode				= $response['resultData']['marketProductCode'];
			$marketProductLink				= str_replace('%marketProductCode%', $marketProductCode, $this->_supportMarkets[$baseMarketInfo['market']]['productLink']);

			if ($baseMarketInfo['market'] == 'storefarm') {
				$accountInfo				= $this->_CI->connectormodel->getAccountInfo(['market' => $baseMarketInfo['market'], 'sellerId' => $baseMarketInfo['seller_id']]);	
				$marketProductLink			= str_replace('%storefarmUrl%', $accountInfo['marketOtherInfo']['storefarmUrl'], $marketProductLink);
			}else if(stripos($baseMarketInfo['market'],"API") !== false){
				$param['market'] = $baseMarketInfo['market'];
				$param['sellerId'] = $baseMarketInfo['seller_id'];
				$param['marketCode'] = $marketProductCode;
				$res = $this->_CI->connectormodel->getShoplinkerProductLink($param);
				$marketProductLink	= $res['resultData'];
			}

			$return['result_text']			= '<span class="bold" style="color:blue">성공</span>';
			$return['result_message']		= $response['resultData']['message'];
			$return['market_product_link']	= "<a href='{$marketProductLink}' target='_blank'>{$marketProductCode}</a>";
			$return['market_product_code']	= $marketProductCode;
			$return['market_goods_name']	= $response['resultData']['marketProductName'];
			$this->goodsRegisterSuccessInsert($idx, $baseMarketInfo, $paramsInfo, $response['resultData']);
		} else {
			//실패시 처리
			$return['result_text']			= '<span class="bold" style="color:red">실패</span>';
			$return['result_message']		= $response['message'];
			$this->goodsRegisterFailUpeate($idx, $return);
		}


		return $return;

	}

	/* 마켓 추가정보 등록 */
	public function setMarketAddInfo($params) {
		$addInfoSeq		= (int)$params['add_info_seq'];
		$sellerId		= $params['seller_id'];
		$market			= $params['market'];
		$addInfoTitle	= $params['add_info_title'];
		
		//카테고리 정보
		$categoryCode	= $params['category_code'];

		$dep1_category_code	= $params['dep1_category_code'];
		$dep2_category_code	= $params['dep2_category_code'];
		$dep3_category_code	= $params['dep3_category_code'];
		$dep4_category_code	= $params['dep4_category_code'];
		$dep5_category_code	= $params['dep5_category_code'];
		$dep6_category_code	= $params['dep6_category_code'];

		$dep1_category_name	= $params['dep1_category_name'];
		$dep2_category_name	= $params['dep2_category_name'];
		$dep3_category_name	= $params['dep3_category_name'];
		$dep4_category_name	= $params['dep4_category_name'];
		$dep5_category_name	= $params['dep5_category_name'];
		$dep6_category_name	= $params['dep6_category_name'];

		//마켓 정보가 아닌경우 삭제
		unset($params['add_info_seq']);
		unset($params['seller_id']);
		unset($params['market']);
		unset($params['addInfo_title']);
		unset($params['category_code']);
		unset($params['dep1_category_code']);
		unset($params['dep2_category_code']);
		unset($params['dep3_category_code']);
		unset($params['dep4_category_code']);
		unset($params['dep5_category_code']);
		unset($params['dep6_category_code']);
		unset($params['dep1_category_name']);
		unset($params['dep2_category_name']);
		unset($params['dep3_category_name']);
		unset($params['dep4_category_name']);
		unset($params['dep5_category_name']);
		unset($params['dep6_category_name']);

		$setParams['market']				= $market;
		$setParams['seller_id']				= $sellerId;
		$setParams['add_info_title']		= $addInfoTitle;
		$setParams['category_code']			= $categoryCode;
		$setParams['dep1_category_code']	= $dep1_category_code;
		$setParams['dep2_category_code']	= $dep2_category_code;
		$setParams['dep3_category_code']	= $dep3_category_code;
		$setParams['dep4_category_code']	= $dep4_category_code;
		$setParams['dep5_category_code']	= $dep5_category_code;
		$setParams['dep6_category_code']	= $dep6_category_code;
		$setParams['dep1_category_name']	= $dep1_category_name;
		$setParams['dep2_category_name']	= $dep2_category_name;
		$setParams['dep3_category_name']	= $dep3_category_name;
		$setParams['dep4_category_name']	= $dep4_category_name;
		$setParams['dep5_category_name']	= $dep5_category_name;
		$setParams['dep6_category_name']	= $dep6_category_name;
		$setParams['add_info_detail']		= json_encode($params);
		$setParams['registered_time']		= date('Y-m-d H:i:s');
		$setParams['renewed_time']			= $setParams['registered_time'];

		$setData	= filter_keys($setParams, $this->_CI->db->list_fields('fm_market_add_info'));

		if ($addInfoSeq	 > 0) {
			//수정
			unset($setData['registered_time']);
			$this->_CI->db->update('fm_market_add_info', $setData, array('seq'=>$addInfoSeq));
			return $addInfoSeq;
		} else {
			//등록
			$this->_CI->db->insert('fm_market_add_info', $setData);
			return $this->_CI->db->insert_id();
		}
	}

	
	/* 마켓 상품상태 업데이트 */
	public function updateMarketSaleStatus($fmMarketProductSeq, $status, $queue = false, $callback = true)
	{
		$connectorModel		=& $this->_CI->connectormodel;
		$marketProductList	= $connectorModel->getMarketProductList(['fmMarketProduceSeq' => $fmMarketProductSeq])[0];

		if (isset($marketProductList['market_product_code']) !== true)
			return false;

		$marketProductCode	= $marketProductList['market_product_code'];
		$market				= $marketProductList['market'];
		$sellerId			= $marketProductList['seller_id'];
		$this->setMarketInfo($market, $sellerId);

		$statusText			= $this->productStatus[$status];
		$url				= "Product/doSaleStatusChange/{$marketProductCode}/{$status}";
		$resultText			= '';
		
		if ($queue == true) {
			$callbackUrl	= ($callback === true) ? "/admin/market_connect_callback/market_product_status_change" : false;
			$response		= $this->queueConnector($url, false, $callbackUrl);

			$distInfo['last_result']		= $response['success'];

			if ($response['success'] != 'Y') {

				$distInfo['last_result']	= 'N';
				$resultText					= "실패 - {$response['message']}";

			} else if ($callback == true){
				$responseData	= $response['resultData'];

				$distInfo['last_result']	= 'P';	//Queue 는 Pending 처리
				$resultText					= "요청({$responseData['requestId']})";

				$otherInfo['fmMarketProductSeq']	= $fmMarketProductSeq;
				$otherInfo['marketProductCode']		= $marketProductCode;
				$otherInfo['fmGoodsSeq']			= $status;

				$queueInfo['request_id']		= $responseData['requestId'];
				$queueInfo['market']			= $market;
				$queueInfo['seller_id']			= $sellerId;
				$queueInfo['method']			= 'Product';
				$queueInfo['action']			= 'doSaleStatusChange';
				$queueInfo['job']				= '상품수정';
				$queueInfo['other_info']		= json_encode($otherInfo);
				$queueInfo['registered_time']	= $responseData['registeredTime'];

				$this->_CI->db->insert('fm_market_queue_list', $queueInfo);
			}

		} else {

			$response		= $this->callConnector($url);
			$distInfo		= array();
			if ($response['success'] == 'Y'){
				$distInfo['market_sale_status']	= $status;
				$distInfo['last_result']	= 'Y';
				$resultText	= '성공';
				
			} else {
				$distInfo['last_result']	= 'N';
				$resultText	= '실패';
			}

		}

		$distInfo['last_distributed_time']	= date('Y-m-d H:i:s');
		$this->updateMarketProductInfo($fmMarketProductSeq, $distInfo);

		if ($resultText != '') {
			$distLog	= "{$this->_supportMarkets[$market]['name']} \"{$statusText}\" 처리 {$resultText}";
			$this->makeMarketProductLog($fmMarketProductSeq, $marketProductCode, $distLog);
		}

		return $distInfo['last_result'];
	}



	/* 마켓 상품수정 */
	public function doMarketGoodsUpdate($targetSeq, $mode = 'fmGoodsSync', $queue = true)
	{
		$this->_CI->load->model('goodsmodel');
		
		$connectorModel		=& $this->_CI->connectormodel;

		$marketParams						= array();
		$marketParams['manualMatched']		= 'N';
		switch ($mode) {
			case	'fmGoodsSync' :
				$marketParams['fmGoodsSeq']			= $targetSeq;
				break;
			
			case	'marketGoodsSync' :
				$marketParams['fmMarketProduceSeq']	= $targetSeq;
				break;
		}

		$marketProductList	= $connectorModel->getMarketProductList($marketParams);
		$fmGoodsInfo		= $this->_CI->goodsmodel->get_goods($marketProductList[0]['goods_seq']);
		$fmSaleStatus		= ($fmGoodsInfo['goods_status'] == 'normal' && $fmGoodsInfo['goods_view'] == 'look') ? '210' : '211';
		$_connectorBase		= $this->_CI->connector::getInstance();
		$marketUse			= array();

		if (count($marketProductList) > 0) {
			foreach ($marketProductList as $row) {

				// 실제로 market, sellerId 사용유무 체크하여 상품 전송
				if(empty($marketUse[$row['market']][$row['seller_id']])) {
					$marketUseTmp = $_connectorBase->getMarketSellers($row['market'],true,$row['seller_id']);
					$marketUse[$row['market']][$row['seller_id']] = empty($marketUseTmp) ? "N" : "Y";
				}
				if($marketUse[$row['market']][$row['seller_id']] == "N") continue;

				$this->setMarketInfo($row['market'], $row['seller_id']);
				//상태변경
				if(strpos($row['market'],"API") !== false){
					$response		= $this->callConnector("Product/getProductInfo/{$targetSeq}/status");
				}else{
					$response		= $this->callConnector("Product/getProductInfo/{$row['market_product_code']}/status");
				}
				
				//상품상태 조회 실패시 처리
				if ($response['success'] == 'N') {
					$distLog	= "{$this->_supportMarkets[$row['market']]['name']} 상품코드 : {$row['market_product_code']} - 상품조회 실패";
					if(trim($response['message'])) $distLog .= "(".$response['message'].")";
					$this->makeMarketProductLog($row['fm_market_product_seq'], $row['market_product_code'], $distLog);

					$distInfo['last_result']			= 'N';
					$distInfo['last_distributed_time']	= date('Y-m-d H:i:s');
					$this->updateMarketProductInfo($row['fm_market_product_seq'], $distInfo);
					continue;
				}

				$soldOutCheck	= false;
				switch($response['resultData']['statusCode']) {
					case	'100' : //승인전
					case	'105' : //승인요청
					case	'190' : //승인반려
					case	'110' : //승인완료
					case	'200' : //판매대기
					case	'205' : //부분판매중
					case	'210' : //판매중
						$marketStatus	= '210';	// 판매중
						break;
					case	'212' : //품절(품절도 판매중으로 처리)
						$marketStatus	= '210';	// 판매중
						$soldOutCheck	= true;
						break;

					case	'300' :	//판매종료
					case	'900' :	//판매중지
					case	'999' :	//상품삭제
						$marketStatus	= '300';
						continue;
						break;

					default :	//전시중지
						$marketStatus	= '211';
				}


				
				// 상품이 판매종료, 판매중지, 상품상제의 경우 상품 정보 업데이트 안함
				if($marketStatus == '300') {
					$distLog	= "{$this->_supportMarkets[$row['market']]['name']} 상품코드 : {$row['market_product_code']} - {$this->productStatus[$response['resultData']['statusCode']]}";
					$this->makeMarketProductLog($row['fm_market_product_seq'], $row['market_product_code'], $distLog);

					$distInfo['last_result']			= 'N';
					$distInfo['market_sale_status']		= $response['resultData']['statusCode'];
					$distInfo['last_distributed_time']	= date('Y-m-d H:i:s');
					$connectorModel->updateMarketProductInfo($row['fm_market_product_seq'], $distInfo);
					continue;
				}


				$statusResult	= 'Y';

				//마켓상품이 품절이 아닌경우 상품 업데이트 전 상태 변경
				if ($soldOutCheck === false && $marketStatus != $fmSaleStatus)
					$statusResult	= $this->updateMarketSaleStatus($row['fm_market_product_seq'], $fmSaleStatus, $queue, false);

				//상태 변경이 없거나 성공일경우 상품정보 업데이트
				if ($statusResult == 'Y') {
					$return	= $this->_marketGoodsUpdate($row['fm_market_product_seq'], $mode, $queue);
					//$return	= $this->_marketGoodsUpdate($row['fm_market_product_seq'], $mode, false);

					//마켓상품이 품절인경우 상품 업데이트 후 상태 변경
					if ($soldOutCheck === true && $marketStatus != $fmSaleStatus)
						$this->updateMarketSaleStatus($row['fm_market_product_seq'], $fmSaleStatus, $queue, true);

					if ($mode == 'marketGoodsSync')
						return $return;
				}

			}
		}

		return;
	}


	/* 마켓 상품수정 처리*/
	protected function _marketGoodsUpdate($fmMarketProductSeq, $mode, $queue)
	{
		$connectorModel		=& $this->_CI->connectormodel;

		$marketParams['fmMarketProduceSeq']	= $fmMarketProductSeq;
		$marketProductList	= $connectorModel->getMarketProductList($marketParams, 'fullInfo');

		if (count($marketProductList) < 1)
			return;

		$marketProductInfo					= $marketProductList[0];
		
		$baseMarketInfo['market']			= $marketProductInfo['market'];
		$baseMarketInfo['seller_id']		= $marketProductInfo['seller_id'];
		$baseMarketInfo['goods_seq']		= $marketProductInfo['goods_seq'];
		$baseMarketInfo['add_info_detail']	= $marketProductInfo['market_add_info'];

		$categoryInfo		= $marketProductInfo['category_info'];
		//$marketProductInfo['dist_category_type']	= 'M';			테스트용인것 같아서 주석처리함 2018-02-20
		$baseMarketInfo['dist_category_type']	= $marketProductInfo['dist_category_type'];
		
		if($marketProductInfo['dist_category_type'] == 'M') {
			$this->_CI->load->model('goodsmodel');
			$fmGoodsSeq			= $marketProductInfo['goods_seq'];

			$defaultCategory	= $this->_CI->goodsmodel->get_goods_category_default($fmGoodsSeq);
			$matchedCategory	= $this->getMarketCategoryByFmCategoryCode($defaultCategory['category_code'], $baseMarketInfo['market'], $baseMarketInfo['seller_id']);

			if (isset($matchedCategory[0]['category_code']))
				$categoryInfo	= $matchedCategory[0];
		}
		

		foreach ($categoryInfo as $key => $val)
			$baseMarketInfo[$key]		= $val;
		
		if(strpos($baseMarketInfo['market'],"API") !== false){
			$class			= "MarketGoods_shoplinker";
		}else{
			$class			= "MarketGoods_{$baseMarketInfo['market']}";
		}
		
		//$class			= "MarketGoods_{$baseMarketInfo['market']}";
		if (class_exists($class) === true) {
			$setMarket	= new $class($baseMarketInfo);
			$doMarket	= new MarketGoods($setMarket);

			if ($mode == 'fmGoodsSync' || $mode == 'marketGoodsSync') {
				// 상품동기화(원 상품 정보 변경을 반영한다.)
				$paramsInfo		= $doMarket->setMarketGoodsParams('update');

				// 동기화 진행 시 실패되면 더이상 수정 로직은 실행하지 않음 2019-05-10
				if($paramsInfo['success'] == 'N') {
					$return['success']	= 'N';
					$return['message']	= $paramsInfo['message'];
					return $return;
				}
			} else {
				// 상품개별수정(원 상품 및 원 추가정보의 변경은 반영하지 않는다.)
				$paramsInfo		= $doMarket->getMarketGoodsParamsForUpdate($marketProductInfo['market_product_info'], $marketProductInfo['market_add_info']);
			}

			// 쿠팡 상품 수정 시 buildMarketParams 실패 처리 되면, 실패로그에 쌓기 Queue 요청도 안함 2019-01-25
			if( $baseMarketInfo['market'] == 'coupang' && $paramsInfo['success'] == 'N' ) {
				$jobText	= "상품수정";
				$successText = $paramsInfo['message'];

				$distLog	= "{$this->_supportMarkets[$baseMarketInfo['market']]['name']} \{$jobText}\  - {$successText}";
				$distInfo['last_result']	= 'N';
				$distInfo['last_distributed_time']	= date('Y-m-d H:i:s');
				$this->updateMarketProductInfo($fmMarketProductSeq, $distInfo);

				$this->makeMarketProductLog($fmMarketProductSeq, $marketProductInfo['market_product_code'], $distLog);
				return;
			}

			$marketParameters['request']	= $doMarket->getMarketGoodsParams();
			$url	= "product/doProductUpdate/{$marketProductInfo['market_product_code']}";

			if ($queue === true) {
				$callbackUrl	= "/admin/market_connect_callback/market_product_update";
				$response	= $this->queueConnector($url, $marketParameters, $callbackUrl);
			} else {
				$response	= $this->callConnector($url, $marketParameters);
			}
			
		} else {
			$response['message']	= "[{$baseMarketInfo['market']}] 알 수 없는 마켓입니다.";
		}

		if ($queue === true) {
			$jobText	= "상품수정 Queue등록";

			if ($response['success'] != 'Y') {
				$distInfo['last_result']	= 'N';
				$successText				= $response['message'];
			} else {

				$responseData	= $response['resultData'];

				$distInfo['last_result']	= 'P';	//Queue 는 Pending 처리
				$successText				= "요청({$responseData['requestId']})";
				
				$otherInfo['fmMarketProductSeq']	= $fmMarketProductSeq;
				$otherInfo['marketProductCode']		= $marketProductInfo['market_product_code'];
				$otherInfo['fmGoodsSeq']			= $baseMarketInfo['goods_seq'];

				$queueInfo['request_id']		= $responseData['requestId'];
				$queueInfo['market']			= $baseMarketInfo['market'];
				$queueInfo['seller_id']			= $baseMarketInfo['seller_id'];
				$queueInfo['method']			= 'Product';
				$queueInfo['action']			= 'doProductUpdate';
				$queueInfo['job']				= '상품수정';
				$queueInfo['other_info']		= json_encode($otherInfo);
				$queueInfo['registered_time']	= $responseData['registeredTime'];
				
				$this->_CI->db->insert('fm_market_queue_list', $queueInfo);
			}
			

		} else {
			// Queue가 아닌경우 결과 즉시 업데이트
			$jobText	= "상품수정";

			if ($response['resultData']['marketProductCode'] == $marketProductInfo['market_product_code']) {
				$distInfo['market_product_name']	= $response['resultData']['marketProductName'];
				$distInfo['market_sale_status']		= $response['resultData']['saleStatus']['statusCode'];
				$distInfo['market_begin_date']		= $response['resultData']['saleStatus']['saleBeginDate'];
				$distInfo['market_close_date']		= $response['resultData']['saleStatus']['saleCloseDate'];
				$distInfo['last_result']			= 'Y';
				$successText	= '성공';
				$distLog		= '';
			} else {
				$distInfo['last_result']	= 'N';
				$successText				= $response['message'];
			}

		}

		$distInfo['last_distributed_time']	= date('Y-m-d H:i:s');
		$this->updateMarketProductInfo($fmMarketProductSeq, $distInfo);
		
		$distLog	= "{$this->_supportMarkets[$baseMarketInfo['market']]['name']} \"{$jobText}\" 처리  - {$successText}";
		$this->makeMarketProductLog($fmMarketProductSeq, $marketProductInfo['market_product_code'], $distLog);
		$this->updateMarketProductDesc($fmMarketProductSeq, $categoryInfo, $paramsInfo['productInfo'], $paramsInfo['addInfo']);
		
		$return['success']	= $distInfo['last_result'];
		$return['message']	= $successText;
		
		return $return;
	}

	/* 마켓 상품 상태 정보 갱신 */
	public function syncProductStatusFromMarket($marketProductCode, $market, $sellerId)
	{

		$searchParams['market']				= $market;
		$searchParams['sellerId']			= $sellerId;
		$searchParams['marketProductCode']	= $marketProductCode;
		$fmMarketProduct					= $this->_CI->connectormodel->getMarketProductList($searchParams);
		
		$this->setMarketInfo($market, $sellerId);
		
		if(stripos($market,"API") !== false){
			$marketProductCode = $fmMarketProduct[0]['goods_seq'];
		}
		
		$response		= $this->callConnector("Product/getProductInfo/{$marketProductCode}/status");

		if ($response['success'] == 'Y' && count($fmMarketProduct) > 0) {
			$distInfo['market_sale_status']		= $response['resultData']['statusCode'];
			$distInfo['market_product_name']	= $response['resultData']['marketProductName'];
			$distInfo['market_begin_date']		= $response['resultData']['saleBeginDate'];
			$distInfo['market_close_date']		= $response['resultData']['saleCloseDate'];
			$distInfo['last_distributed_time']	= date('Y-m-d H:i:s');

			$this->_CI->connectormodel->updateMarketProductInfo($fmMarketProduct[0]['fm_market_product_seq'], $distInfo);
		} else if ($response['success'] == 'Y') {
			$response['success']				= 'N';
			$response['message']				= '배포된 상품이 없습니다.';
		}

		return $response;
	}

	/* 마켓 상품 수동매칭 */
	public function goodsRegisterdManualMatch($params)
	{
		
		if(isset($params['marketProductCode']) !== true) {
			$return['success']	= 'N';
			$return['message']	= '마켓 상품코드가 없습니다.';

			return $return;
		}

		# 20190107 옥션, 지마켓의 경우 마스터상품ID^^상품ID로 넘어 오기도 함.
		if(strstr($params['marketProductCode'],"^^")){
			$_marketProductCode = explode("^^",$params['marketProductCode']);
			$params['marketProductCode'] = $_marketProductCode[1];
		}
		
		$this->setMarketInfo($params['market'], $params['sellerId']);
		$marketProductStatus					= $this->callConnector("Product/getProductInfo/{$params['marketProductCode']}/status");
		$statusInfo								= $marketProductStatus['resultData'];

		$matchParams['market_product_code']		= $params['marketProductCode'];
		$matchParams['goods_seq']				= $params['fmGoodsSeq'];
		$matchParams['market']					= $params['market'];
		$matchParams['seller_id']				= $params['sellerId'];
		$matchParams['market_product_name']		= $params['marketProductName'];
		$matchParams['market_sale_status']		= (isset($statusInfo['statusCode'])) ?  $statusInfo['statusCode'] : '211';
		$matchParams['market_begin_date']		= (isset($statusInfo['saleBeginDate'])) ?  $statusInfo['saleBeginDate'] : '0000-00-00';
		$matchParams['market_close_date']		= (isset($statusInfo['saleCloseDate'])) ?  $statusInfo['saleCloseDate'] : '0000-00-00';
		$matchParams['registered_time']			= date('Y-m-d H:i:s');
		$matchParams['last_distributed_time']	= $matchParams['registered_time'];
		$matchParams['last_result']				= 'Y';
		$matchParams['manual_matched']			= 'Y';
		$matchParams['market_product_status']	= '1';

		//옵션 매칭 kmj 18.02.08
		$order_option_text = trim($params['order_option_text']);
		if(strlen($order_option_text) > 0){
			$optionDB = $this->_CI->db->query('SELECT option_title, option1, option2, option3, option4, option5 FROM fm_goods_option WHERE goods_seq = ?', $params['fmGoodsSeq']);
		
			$optionText = '';
			foreach($optionDB->result_array() as $optionsList){
				$options = array_filter(array_slice($optionsList, 1, 5)); 
				$regex = '/(?=.*?'.implode(')(?=.*?', $options).')/s';
				if( preg_match($regex, $order_option_text) ){
					$optionsTextTemp = '';
					$optionTitle = explode(',', $optionsList['option_title']);
					for($i=1; $i<=count($options); $i++){
						$optionsTextTemp .= $optionTitle[$i-1].": ".$options['option'.$i].", ";
					}

					if(strlen($optionsTextTemp) > strlen($optionText)){
						$optionText = $optionsTextTemp;
					}
				}
			}
			$optionText = substr($optionText, 0, -2);

			if(!empty($optionText)){
				$this->_CI->db->update('fm_market_orders', array('matched_option_name' => $optionText), array('market_product_code'=>$params['marketProductCode']));
			}
		}

		$searchParams['market']					= $params['market'];
		$searchParams['sellerId']				= $params['sellerId'];
		$searchParams['marketProductCode']		= $params['marketProductCode'];
		// 연동해제(삭제)한 상품도 조회하여 기존 데이터를 덮어쓰도록 변경 by hed
		$searchParams['search_market_product_status']	= 'ALL';
		$fmMarketProduct						= $this->_CI->connectormodel->getMarketProductList($searchParams);
		
		$setData	= filter_keys($matchParams, $this->_CI->db->list_fields('fm_market_product_info'));

		if (isset($fmMarketProduct[0]['fm_market_product_seq']))
			$this->_CI->db->update('fm_market_product_info', $setData, array('seq'=>$fmMarketProduct[0]['fm_market_product_seq']));
		else
			$this->_CI->db->insert('fm_market_product_info', $setData);
		
		$return['success']	= 'Y';
		$return['message']	= '수동매칭 성공.';

		return $return;
	}

	/* 마켓 상품등록 성공시 처리 */
	public function goodsRegisterSuccessInsert($standBySeq, $baseMarketInfo, $paramsInfo, $response)
	{
		$this->_CI->db->reconnect();

		# 20190107 옥션, 지마켓의 경우 마스터상품ID^^상품ID로 넘어 오기도 함.
		if(strstr($response['marketProductCode'],"^^")){
			$_marketProductCode = explode("^^",$response['marketProductCode']);
			$response['marketProductCode'] = $_marketProductCode[1];
		}

		//기본정보
		$setParams['market']				= $baseMarketInfo['market'];
		$setParams['goods_seq']				= $baseMarketInfo['goods_seq'];
		$setParams['add_info_seq']			= $baseMarketInfo['add_info_seq'];
		$setParams['seller_id']				= $baseMarketInfo['seller_id'];
		$setParams['dist_category_type']	= $baseMarketInfo['dist_category_type'];
		$setParams['market_category_name']	= $baseMarketInfo['market_category_name'];
		$setParams['market_product_code']	= $response['marketProductCode'];
		
		if($baseMarketInfo['market'] == "shoplinker"){
			$setParams['confirmed_product_code']	= $response['openmarketProductCode'];
		}
		
		$setParams['market_product_name']	= $response['marketProductName'];
		$setParams['market_sale_status']	= $response['saleStatus']['statusCode'];
		$setParams['market_begin_date']		= $response['saleStatus']['saleBeginDate'];
		$setParams['market_close_date']		= $response['saleStatus']['saleCloseDate'];
		$setParams['market_update_list']	= 'NONE';
		$setParams['last_result']			= 'Y';
		$setParams['manual_matched']		= 'N';
		$setParams['registered_time']		= date('Y-m-d H:i:s');
		$setParams['last_distributed_time']	= $setParams['registered_time'];

		$setData				= filter_keys($setParams, $this->_CI->db->list_fields('fm_market_product_info'));
		
		$this->_CI->db->insert('fm_market_product_info', $setData);
		$fm_market_product_seq	= $this->_CI->db->insert_id();

		if(!$fm_market_product_seq) {
			$this->connectorFileLog("goodsRegisterSuccessInsert".date("ymd").".txt","[".$standBySeq."]".$this->_CI->db->last_query());
		}
		
		// 카테고리 정보
		$categoryParams['category_code']		= $baseMarketInfo['category_code'];
		$categoryParams['dep1_category_code']	= $baseMarketInfo['dep1_category_code'];
		$categoryParams['dep2_category_code']	= $baseMarketInfo['dep2_category_code'];
		$categoryParams['dep3_category_code']	= $baseMarketInfo['dep3_category_code'];
		$categoryParams['dep4_category_code']	= $baseMarketInfo['dep4_category_code'];
		$categoryParams['dep5_category_code']	= $baseMarketInfo['dep5_category_code'];
		$categoryParams['dep6_category_code']	= $baseMarketInfo['dep6_category_code'];
		$categoryParams['dep1_category_name']	= $baseMarketInfo['dep1_category_name'];
		$categoryParams['dep2_category_name']	= $baseMarketInfo['dep2_category_name'];
		$categoryParams['dep3_category_name']	= $baseMarketInfo['dep3_category_name'];
		$categoryParams['dep4_category_name']	= $baseMarketInfo['dep4_category_name'];
		$categoryParams['dep5_category_name']	= $baseMarketInfo['dep5_category_name'];
		$categoryParams['dep6_category_name']	= $baseMarketInfo['dep6_category_name'];

		// 상세정보
		$detailParams['fm_market_product_seq']	= $fm_market_product_seq;
		$detailParams['category_info']			= json_encode($categoryParams);
		$detailParams['market_product_info']	= json_encode($paramsInfo['productInfo']);
		$detailParams['market_add_info']		= json_encode($paramsInfo['addInfo']);
		
		$detailSet	= filter_keys($detailParams, $this->_CI->db->list_fields('fm_market_product_detail'));
		$this->_CI->db->insert('fm_market_product_detail', $detailSet);
		$this->_CI->db->delete('fm_market_dist_standby', array('seq' => $standBySeq));

		//로그저장
		$logMessage		= "{$this->_supportMarkets[$baseMarketInfo['market']]['name']} 상품등록 성공";
		$this->makeMarketProductLog($fm_market_product_seq, $response['marketProductCode'], $logMessage);
	}

	/* 마켓 상품등록 실패시 처리 */
	public function goodsRegisterFailUpeate($idx, $failInfo)
	{
		$setData['fail_yn']			= 'Y';
		$setData['fail_message']	= $failInfo['result_message'];
		$this->_CI->db->update('fm_market_dist_standby', $setData, array('seq'=>$idx));
	}

	/* 배포상품 추가정보 업데이트*/
	public function updateAddInfoByDist($params)
	{
		$fmMarketProductSeq		= $params['fmMarketProduceSeq'];
		$nowMarketProductInfo	= $this->_CI->connectormodel->getMarketProductList(array('fmMarketProduceSeq' => $fmMarketProductSeq), 'fullInfo');
		$categoryInfo			= array();

		foreach((array)$nowMarketProductInfo[0]['category_info'] as $key => $val) {
			$categoryInfo[$key]	= $nowMarketProductInfo[0]['category_info'][$key];
			unset($params[$key]);
		}

		$marketAddInfo			= $params;
		$marketProductInfo		= $nowMarketProductInfo[0]['market_product_info'];
		$this->updateMarketProductDesc($fmMarketProductSeq, $categoryInfo, $marketProductInfo, $marketAddInfo);

		$result							= $nowMarketProductInfo[0];
		$result['category_info']		= $categoryInfo;
		$result['market_add_info']		= $marketAddInfo;
		$result['market_product_info']	= $marketProductInfo;

		return $result;
	}

	/* 마켓 상품 추가(상세)정보 업데이트 */
	public function updateMarketProductDesc($fmMarketProductSeq, $categoryInfo, $marketProductInfo, $marketAddInfo)
	{

		//불필요 정보 리셋
		unset($marketAddInfo['fmMarketProduceSeq']);
		unset($marketAddInfo['market']);
		unset($marketAddInfo['seller_id']);
		unset($marketAddInfo['add_info_seq']);

		$params['category_info']		= json_encode($categoryInfo);
		$params['market_product_info']	= json_encode($marketProductInfo);
		$params['market_add_info']		= json_encode($marketAddInfo);

		$setData	= filter_keys($params, $this->_CI->db->list_fields('fm_market_product_detail'));
		$this->_CI->db->update('fm_market_product_detail', $setData, array('fm_market_product_seq'=>$fmMarketProductSeq));
	}

	/* 마켓 상품 기본정보 업데이트 */
	public function updateMarketProductInfo($fmMarketProductSeq, $params)
	{
		$setData	= filter_keys($params, $this->_CI->db->list_fields('fm_market_product_info'));
		$this->_CI->db->update('fm_market_product_info', $setData, array('seq'=>$fmMarketProductSeq));
	}

	/* 마켓 상품전송 로그 기록 */
	public function makeMarketProductLog($fmMarketProductSeq, $marketProductSeq, $log)
	{
		//로그저장
		$logParams['fm_market_product_seq']		= $fmMarketProductSeq;
		$logParams['market_product_code']		= $marketProductSeq;
		$logParams['log_text']					= $log;
		$logParams['registered_time']			= date('Y-m-d H:i:s');
		$this->_CI->db->insert('fm_market_product_log', $logParams);
	}
}