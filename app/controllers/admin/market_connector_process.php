<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class market_connector_process extends admin_base {

	public $supportMarkets		= array();
	protected $_connectorBase;

	public function __construct()
	{	
		parent::__construct();
		$this->load->model('connectormodel');

		$this->_connectorBase	= $this->connector::getInstance();
		$this->supportMarkets	= $this->_connectorBase->getSupportMarkets();

	}


	public function doClauseAgree() {
		$MarketConnectorClause	= config_load('MarketConnectorClause');
		config_save('MarketConnectorClause', array("agreeDate" => date('Y-m-d')));
		//최초 설정 firstmall 로 설정
		config_save('MarketLinkage', array("shopCode" => 'firstmall'));
		
		$cluseAgreeDate			= date('Y-m-d');
		$return['success']		= 'Y';
		$return['agreeDate']	= date('Y년 m월 d일');

		echo json_encode($return);
	}
	
	/***
	 * 마켓 연동 정보 입력 2017-08-24 샵링커
	 */
	public function doSetLinkageTarget() {
		
		$params		= $this->input->post();
		
		$MarketConnectorClause		= config_load('MarketConnectorClause');
		$MarketLinkage				= config_load('MarketLinkage');
		
		/*if($params['targetLinkage'] != ""){
			config_save('MarketLinkage', array("shopCode" => $params['targetLinkage']));
			
			if($params['targetLinkage'] == "shoplinker"){
				if($params['shoplinker_id'] != "" && $params['shoplinker_code'] != ""){
					config_save('MarketLinkage', array("shoplinkerId" => $params['shoplinker_id']));
					config_save('MarketLinkage', array("shoplinkerCode" => $params['shoplinker_code']));
					
					$return['success']		= 'Y';
					$return['message']	= "설정이 변경 되었습니다.";
				}else{
					$return['success']		= 'N';
					$return['message']	= "샵링커 아이디나 샵링커 고객사코드중 하나가 잘못 입력 되었습니다.";
				}
			}else{
				$return['success']		= 'Y';
				$return['message']	= "설정이 변경 되었습니다.";
			}
			
		}else{
			$return['success']		= 'N';
			$return['message']	= "연동 방법이 선택되지 않았습니다.";
		}*/
		
		if(isset($MarketConnectorClause['agreeDate'])){
			config_save('MarketLinkage', array("shopCode" => $params['targetLinkage']));
			config_save('MarketLinkage', array("shopChangeDate" => date('Y-m-d', strtotime("+30 days"))));
			
			//shopCode가 틀릴경우 주문/반품/교환/취소를 삭제한다.
			if($MarketLinkage['shopCode'] != $params['targetLinkage']){
				$this->connectormodel->preShopInfoDelete($params['targetLinkage']);
				
				$changeAgreeDate			= date('Y년 m월 d일', strtotime("+30 days"));
				$return['success']		= 'CY';
				$return['changeAgreeDate']	= $changeAgreeDate;
			}else{
				$return['success']		= 'CN';
			}
			

		}else{
			if($params['clauseAgree'] == 'Y'){				
				
				config_save('MarketConnectorClause', array("agreeDate" => date('Y-m-d')));
				config_save('MarketLinkage', array("shopCode" => $params['targetLinkage']));
				
				$cluseAgreeDate			= date('Y-m-d');
				$return['success']		= 'FY';
				$return['agreeDate']	= date('Y년 m월 d일');
			}else{
				$return['success']		= 'N';
				$return['message']		= '이용 약관에 동의 하여 주시기 바랍니다.';
			}
		}
		
		echo json_encode($return);
	}

	/* 샵링커 계정 정보 저장 */
	public function doSetLinkageInfo() {
		$this->load->library('validation');
		$params		= $this->input->post();

		### Validation
		$this->validation->set_rules('shoplinker_id', '샵링커 아이디','trim|required|max_length[20]|xss_clean');
		$this->validation->set_rules('shoplinker_code', '샵링커 고객사코드','trim|required|max_length[20]|xss_clean');

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		config_save('MarketLinkage', array("shoplinkerId" 	=> $params['shoplinker_id']));
		config_save('MarketLinkage', array("shoplinkerCode" => $params['shoplinker_code']));
		$callback = "parent.closeDialog('targetLinkageSetting');";
		openDialogAlert("저장 되었습니다.",400,140,'parent',$callback);
	}

	public function marketAccountSet() {
		$params		= $this->input->post();
		$return		= array();
		$market		= trim($params['market']);

		$return['success']		= 'Y';

		if (isset($this->supportMarkets[$market]) === false) {
			$return['success']	= 'N';
			$return['message']	= '오픈마켓을 선택해주세요.';
		} else if (strlen(trim($params['sellerId'])) < 3) {
			$return['success'] 	= 'N';
			$return['message'] 	= '판매자  아이디를 입력해 주세요';
		} else {
			$accountService		= $this->connector::getInstance('account');
			$market				= $params['market'];
			$sellerId			= $params['sellerId'];
			$mode				= $params['mode'];

			unset($params['market']);
			unset($params['sellerId']);
			$return		= $accountService->setAccountInfo($market, $sellerId, $params, $mode);
		}

		echo json_encode($return);
	}
	
	public function marketAccountSetShopLinker() {
		$params		= $this->input->post();
		$return		= array();
		
		$otherInfo = array();
		
		//$params['market'] = "shoplinker";
		$marketInfoArry = explode("|",$params['linkageMall']);
		$params['market'] = $marketInfoArry[1];
		
		$otherInfo["marketSeq"] = $marketInfoArry[0];
		$otherInfo["marketCode"] = $marketInfoArry[1];
		$MarketLinkage = config_load('MarketLinkage');
		
		$params['marketAuthInfo']['customerId'] = $MarketLinkage['shoplinkerCode'];
		$params['marketAuthInfo']['mallId'] = $marketInfoArry[1];
		$params['marketAuthInfo']['userId'] = $params['sellerId'];
		if($params['masterId'] != ''){
			$params['marketAuthInfo']['masterId'] = $params['masterId'];
		}else{
			$params['marketAuthInfo']['masterId'] = $params['sellerId'];
		}
		
		$params['marketOtherInfo'] = $otherInfo;
		
		$market		= trim($params['market']);
		
		$return['success']		= 'Y';
		
		if ($market === "") {
			$return['success']	= 'N';
			$return['message']	= '오픈마켓을 선택해주세요.';
		} else if (strlen(trim($params['sellerId'])) < 3) {
			$return['success'] 	= 'N';
			$return['message'] 	= '판매자  아이디를 입력해 주세요';
		} else {
			$accountService		= $this->connector::getInstance('account');
			$market				= $params['market'];
			$sellerId			= $params['sellerId'];
			$mode				= $params['mode'];
			
			unset($params['market']);
			unset($params['sellerId']);
			
			$return		= $accountService->setAccountInfo($market, $sellerId, $params, $mode);
		}
		
		echo json_encode($return);
	}

	public function marketAccountDelete() {
		$params		= $this->input->post();
		$return		= array();

		$return['success']		= 'Y';
		if (strlen(trim($params['market'])) < 3) {
			$return['success']	= 'N';
			$return['message']	= '선택된 마켓이 없습니다.';
		} else if (strlen(trim($params['sellerId'])) < 3) {
			$return['success'] 	= 'N';
			$return['message'] 	= '판매자 아이디를 입력해 주세요';
		} else {
			$accountService = $this->connector::getInstance('account');
			$market		= $params['market'];
			$sellerId	= $params['sellerId'];
			$mode		= $params['mode'];

			unset($params['market']);
			unset($params['sellerId']);
			$return		= $accountService->deleteAccountInfo($market, $sellerId);
		}

		echo json_encode($return);

	}
	
	/***
	 * 선택마켓 account 삭제
	 */
	public function selectMarketAccountDelete(){
		$params		= $this->input->post();
		$return		= array();
		
		$arrayParams = explode("+",$params['chkSeq']);
		$accountService = $this->connector::getInstance('account');
		
		foreach($arrayParams as $data){
			if($data){
				$dataArray = explode('`',$data);
				
				$market 	= $dataArray[0];
				$sellerId 	= $dataArray[1];
				$return		= $accountService->deleteAccountInfo($market, $sellerId);
			}
		}
		
		$return['success']		= 'Y';
		$return['message']		= '선택한 계정이 삭제 되었습니다.';
		
		echo json_encode($return);
	}
	
	public function saveAddInfo() {

		$this->load->library('validation');
		$params			= $this->input->post();

		if (in_array($params['deliveryChargeType'], ['FREE_DELIVERY_OVER_9800', 'FREE_DELIVERY_OVER_19800', 'FREE_DELIVERY_OVER_30000', 'CONDITIONAL_FREE'])) {
				
			if(((int)$params['freeShipOverAmount'] % 100) !== 0){	
				$return['success']		= 'N';
				$return['message']		= '무료배송 조건금액은 100 단위로 입력하셔야 합니다.';
				echo json_encode($return);
				exit;
			}
			$this->validation->set_rules('freeShipOverAmount', '무료배송 조건금액', 'required|numeric|trim|xss_clean|greater_than[99]');
			if($this->validation->exec()===false){
				$err = $this->validation->error_array;
				$return['success']		= 'N';
				$return['message']		= $err['value'];
				echo json_encode($return);
				exit;
			}
		}

		$goodsService	= $this->connector::getInstance('goods');
		if(	!$this->supportMarkets[$params['market']] || 
			!$params['seller_id'] ||
			!$params['add_info_title'] ||
			!$params['category_code']
		) {

			$return['success']		= 'N';
			$return['message']		= '잘못된 호출 입니다.';

		} else if($params['mode'] == 'marketRenew'){
			unset($params['mode']);
			$goodsService->updateAddInfoByDist($params);
			$return							= $goodsService->doMarketGoodsUpdate($params['fmMarketProduceSeq'], 'marketGoodsSync', false);
			$return['fmMarketProduceSeq']	= $params['fmMarketProduceSeq'];
		} else {
			$return['success']				= 'Y';
			$return['add_info_seq']			= $goodsService->setMarketAddInfo($params);
		}

		echo json_encode($return);
	}

	public function getMarketInfo() {
		
		$mode		= $this->input->get('mode');
		$market		= $this->input->get('market');
		$sellerId	= $this->input->get('sellerId');

		$actionMode[]	= 'other';
		$requireAuth	= false;
		$postVal		= array();
		$getParams		= array();
		$chkShoplinker  = $this->checkShoplinkMarket($market);
		
		switch ($mode) {
			case	'category' :
				if($chkShoplinker === true){
					$depth = $this->input->get('depth');
					//$getParams['depth']	= $depth;
					$actionCode			= $this->input->get('cagrgoryCode');
					$actionMode[]		= 'getCategory';
					if($this->input->get('cagrgoryCode'))
						$actionMode[]	= $this->input->get('cagrgoryCode');
					if($this->input->get('depth') != "1" && $this->input->get('depth') != "")
						$actionMode[]	= $this->input->get('depth');
					
				}else{
					$depth = $this->input->get('depth');
					$getParams['depth']	= $depth;
					$actionCode			= $this->input->get('cagrgoryCode');
					$actionMode[]		= 'getCategory';
					if($this->input->get('cagrgoryCode'))
						$actionMode[]	= $this->input->get('cagrgoryCode');
				}
				break;
			
			case	'shippingAddress' :
				$actionMode[]		= 'getShippingAddress';
				break;

			case	'returnAddress' :
				$actionMode[]		= 'getReturnAddress';
				break;

			case	'bundleGroupList' :
				$actionMode[]		= 'getBundleGroupList';
				break;

			case	'returnsCompanyList' :
				$actionMode[]		= 'getReturnsCompanyList';
				break;

			case	'categoryMoreInfo' :
				$actionMode[]		= 'getCategoryDesc';
				$actionMode[]		=  $this->input->get('cagrgoryCode');
				break;

			case	'sendCloseList' :
				// 발송예정일 템플릿 리스트
				$actionMode[]		= 'getSendCloseList';
				break;

			default;
				exit;
		}

		$getParamsStr		= '';
		if (count($getParams) > 0)
			$getParamsStr	= '?'.http_build_query($getParams);

		$actionUrl	= implode('/', $actionMode);
		$url		= "{$actionUrl}{$getParamsStr}";

		$this->_connectorBase->setMarketInfo($market, $sellerId);
		$MarketLinkage	= config_load('MarketLinkage');

		if($MarketLinkage['shopCode'] == "shoplinker"){
			$postVal['shoplinker'] = true;
			
			$return		= $this->_connectorBase->callConnector($url, $postVal, 'Json');
		}else{
			$return		= $this->_connectorBase->callGetConnector($url, 'Json');
		}
		
		
		
		echo $return;
		
	}
	
	public function getDistributeList() {
		$params					= $this->input->get();
		$params['limit']		= ((int)$params['limit'] < 1) ? 50 : $params['limit'];
		$params['page']			= ((int)$params['page'] < 1) ? 1 : $params['page'];
		$params['claimType']	= $params['now_claim_type'];
		$withTotalCount			= ((int)$params['totalCount'] < 1 || $params['page'] == 1) ? true : false;

		$distList				= $this->connectormodel->getDistributeList($params, $withTotalCount);
		$rowCnt					= 1;
		$return					= array();
		$return['totalCount']	= $distList['totalCount'];

		$totalPage			= ceil($return['totalCount']/$params['limit']);
		$pageLimit			= 10;
		$nowEndPage			= ($params['page'] <= $pageLimit) ? $pageLimit : (ceil($params['page'] / $pageLimit)) * $pageLimit;
		$nowStartPage		= ($params['page'] < $pageLimit) ? 1 : $nowEndPage - $pageLimit + 1;
		$nowEndPage			= ($nowEndPage > $totalPage) ?  $totalPage :  $nowEndPage;
		$pages				= array();

		for($i = $nowStartPage; $i <= $nowEndPage; $i ++)
			$pages[]		= $i;

		$return['paging']	= pagingtagjs($params['page'], $pages, $totalPage, 'movePage([:PAGE:]);', $pageLimit);
		$return['distList']	= array();
		$marketList			= $this->supportMarkets;
		$beforeCnt			= ($params['limit'] * ($params['page'] - 1));
		$startCnt			= $return['totalCount'] - $beforeCnt;

		foreach ((array) $distList['resultList'] AS $val) {
			$val['no']					= $startCnt;
			$val['image_src']			= "<img src='{$val['image']}' width='40'/>";
			$val['fail_text']			= ($val['dist_fail_yn'] == 'Y') ? '<span class="bold" style="color:red">실패</span>' : '';
			$val['result_message']		= $val['dist_fail_message'];
			$val['category_name']		= implode(' > ', $this->_connectorBase->makeMarketCategoryName($val));
			$val['goods_seq_text']		= "<a href='/admin/goods/regist?no={$val['goods_seq']}' target='_product'>{$val['goods_seq']}</a>";
			
			$chkShoplinker  = $this->checkShoplinkMarket($val['market_code']);
			
			if($chkShoplinker){
				
				/*샵링커 마켓 정보 조회*/
				$params["addInfoSeq"] = $val['add_info_seq'];
				$addInfo = $this->connectormodel->getShoplinkerAddInfo($params);
				$openmarketInfo						= $this->getShoplinkerMarketInfo($addInfo['seller_id'],$addInfo['market']);
				/*샵링커 마켓 정보 조회*/
				
				$getParam = $addInfo['seller_id']."|".$openmarketInfo['mall_code']."|".$openmarketInfo['mall_seq'];
				$val['add_info_text']		= "<a href='#none' onclick='goAddinfo(\"".$getParam."\",\"".$addInfo['category_code']."\")'>{$val['add_info_title']}</a>";
				$val['category_type_text']	= ($val['dist_category_type'] == "M") ? '매칭' : '그룹정보';
				$val['market_name']			= $openmarketInfo['mall_name'];
				
			}else{
				$val['add_info_text']		= "<a href='/admin/market_connector/{$val['market_code']}_add_info?add_info_seq={$val['add_info_seq']}' target='_addInfo'>{$val['add_info_title']}</a>";
				$val['category_type_text']	= ($val['dist_category_type'] == "M") ? '매칭' : '필수정보';
				$val['market_name']			= $marketList[$val['market_code']]['name'];
			}
			
			$return['distList'][]		= $val;

			$startCnt--;
		}

		echo json_encode($return);
	}


	public function marketGoodsRegister() {
		$goodsService	= $this->connector::getInstance('goods');
		$return			= $goodsService->doMarketGoodsRegister($this->input->post('dist_seq'));

		echo json_encode($return);
	}

	protected function _marketProductUpdate($fmMarketProductSeq, $newMarketInfo) {

		$params			= array('fmMarketProduceSeq' => $fmMarketProductSeq);
		$fmMarketList	= $this->connectormodel->getMarketProductList($params);

		if (count($fmMarketList) < 1)
			return '정보가 없습니다.';

		$fmMarketInfo	= $fmMarketList[0];

		//동기화 정보
		$checkArrayKey								= array();
		$checkArrayKey['market_close_date']			= 'saleCloseDate';
		$checkArrayKey['market_sale_status']		= 'statusCode';
		$checkArrayKey['market_product_name']		= 'marketProductName';
		$checkArrayKey['confirmed_product_code']	= 'confirmedProductCode';

		$updateInfo		= array();
		foreach((array)$checkArrayKey as $fmField => $infoKey) {
			if (!trim($newMarketInfo[$infoKey]) || $newMarketInfo[$infoKey] == $fmMarketInfo[$fmField])
				continue;

			$updateInfo[$fmField]	= $newMarketInfo[$infoKey];;
		}

		if (count($updateInfo) > 0 ) {
			$this->connectormodel->updateMarketProductInfo($fmMarketProductSeq, $updateInfo);
			return true;
		} else {
			return '수정된 정보가없니다.';
		}
	}

	public function marketProductStatusSync() {
		$fmMarketProductSeq		= $this->input->post('fm_market_product_seq');
		$marketProductCode		= $this->input->post('market_product_code');
		$goodsSeq	= $this->input->post('goods_seq');
		
		$market				= $this->input->post('market');
		$sellerId			= $this->input->post('seller_id');

		$this->_connectorBase->setMarketInfo($market, $sellerId);
		
		// 샵링커 조회 시는 goods_seq 연동 2018-06-12
		if(strpos($market,"API") !== false ){
			$marketProductCode = $goodsSeq;
		}
		
		$response	= $this->_connectorBase->callGetConnector("Product/getProductInfo/{$marketProductCode}/status");

		if ($response['success'] == 'Y') {
			$this->_marketProductUpdate($fmMarketProductSeq, $response['resultData']);
		}

	}

	public function marketProductConfirm() {
		$fmMarketProductSeq	= $this->input->post('fm_market_product_seq');
		$marketProductCode	= $this->input->post('market_product_code');
		$market				= $this->input->post('market');
		$sellerId			= $this->input->post('seller_id');

		$this->_connectorBase->setMarketInfo($market, $sellerId);
		$response	= $this->_connectorBase->callGetConnector("Product/doProductConfirm/{$marketProductCode}");

		if ($response['success'] == 'Y') {
			$this->_marketProductUpdate($fmMarketProductSeq, $response['resultData']);
		}

		
	}

	public function marketProductDelete() {
		$fmMarketProductSeq		= $this->input->post('fm_market_product_seq');
		$marketProductCode		= $this->input->post('market_product_code');
		$goodsSeq	= $this->input->post('goods_seq');
		
		$market				= $this->input->post('market');
		$sellerId			= $this->input->post('seller_id');
		
		$updateInfo['market_product_status']		= 'D';
		$this->connectormodel->updateMarketProductInfo($fmMarketProductSeq, $updateInfo);

		echo json_encode(array("result_type"=>'productDelete', "result_message"=>'정상 삭제 되었습니다.'));
		return true;
	}

	public function getClaimCollect() {
		$beginDate	= date('Y-m-d', strtotime("-20 Day"));
		$endDate	= date('Y-m-d');
		$market		= $this->input->get('market');
		$sellerId	= $this->input->get('sellerId');
		$return		= $this->getOrderClaimAction($market, $sellerId, $beginDate, $endDate);
		echo json_encode($return);
	}

	public function getOrderCollect() {
		$beginDate	= $this->input->get('startDate');
		$endDate	= $this->input->get('endDate');
		$market		= $this->input->get('market');
		$sellerId	= $this->input->get('sellerId');
		$return		= $this->getOrderCollectAction($market, $sellerId, $beginDate, $endDate);

		$this->getOrderClaimAction($market, $sellerId, $beginDate, $endDate);
		echo json_encode($return);
	}

	public function getOrderCollectAction($market, $sellerId, $beginDate = '', $endDate = '') {
		$beginDate	= ($beginDate == '') ? date('Y-m-d') : $beginDate;
		$endDate	= ($endDate == '') ? date('Y-m-d') : $endDate;
	
		$this->_connectorBase->setMarketInfo($market, $sellerId);
		
		$chkShoplinker  = $this->checkShoplinkMarket($market);
		if($chkShoplinker){
			$MarketLinkage	= config_load('MarketLinkage');
			$postVal['request']['shoplinkerId'] = $MarketLinkage['shoplinkerId'];
			$response	= $this->_connectorBase->callConnector("Order/getOrderList/{$beginDate}/{$endDate}/all",$postVal);
		}else{
			$response	= $this->_connectorBase->callGetConnector("Order/getOrderList/{$beginDate}/{$endDate}/all");
		}

		if ($response['success'] != 'Y')
			return $response;
		
		$orderService	= $this->connector::getInstance('order');
		return $orderService->marketOrderInseart($market, $sellerId, $response['resultData']);
	}

	public function getOrderClaimAction($market, $sellerId, $beginDate = '', $endDate = '') {
		$beginDate		= ($beginDate == '') ? date('Y-m-d') : $beginDate;
		$endDate		= ($endDate == '') ? date('Y-m-d') : $endDate;

		$claimService	= $this->connector::getInstance('claim');
		$claimService->setMarketInfo($market, $sellerId);
		
		$chkShoplinker  = $this->checkShoplinkMarket($market);
		if($chkShoplinker){
			$MarketLinkage	= config_load('MarketLinkage');
			$postVal['request']['shoplinkerId'] = $MarketLinkage['shoplinkerId'];
			$response	= $claimService->callConnector("Claim/getClaimList/{$beginDate}/{$endDate}",$postVal);
		}else{
			$response	= $claimService->callGetConnector("Claim/getClaimList/{$beginDate}/{$endDate}");
		}
		
		//$response		= $claimService->callGetConnector("Claim/getClaimList/{$beginDate}/{$endDate}");

		if ($response['success'] != 'Y')
			return $response;

		$claimService	= $this->connector::getInstance('claim');
		return $claimService->marketClaimInseart($market, $sellerId, $response['resultData']);
	}

	
	public function orderMoveToFmOrder() {
	    $this->load->model("connectormodel");
	    // 사용 여부 체크
	    $row = $this->connectormodel->getInUse();
	    if($row === false || empty($row) || is_array($row) !== true) {
	        $this->setInUse('Y');
	        $params			= $this->input->post();
	        $orderService	= $this->connector::getInstance('order');
	        $return			= $orderService->orderMoveToFmOrder($params);
	        $return['inUse'] = 'N';
	        $this->setInUse('N');
	    } else {
	        $return = array(
	            'inUse'    =>  'Y',
	            'user'     =>  $row['inUse']['user'],
	            'date'     =>  $row['inUse_date'],
	        );
	    }
		echo json_encode($return);
	}



	public function getMarketOrderList() {
		
		$params				= $this->input->get();
		$params['limit']	= ((int)$params['limit'] < 1) ? 5 : $params['limit'];
		$params['page']		= ((int)$params['page'] < 1) ? 1 : $params['page'];

		if (trim($params['keyword'])) {
			switch($params['searchType']) {
				case	'fmOrderSeq' :
					$params['fmOrderSeq']		= trim($params['keyword']);
					break;

				case	'marketOrderNo';
					$params['marketOrderNo']	= trim($params['keyword']);
					break;
			}
		}
		
		$orderStatus	= $this->_connectorBase->getStatusCode('order');
		$marketList		= $this->supportMarkets;

		$params['withTotalCount']	= ((int)$params['totalCount'] < 1 || $params['page'] == 1) ? true : false;

		$response		= $this->connectormodel->getMarketOrderList($params, 'forViewList');
		$orderList		= array();

		foreach((array)$response['resultList'] as $key => $row) {
			$orderProductName	= ($row['add_product_yn'] == 'Y') ? '[추가옵션]' : '';
			$orderProductName	.= "{$row['order_product_name']}";
			
			if ($row['fm_goods_name']) {
				$fmGoodsName			= ($row['manual_matched'] != 'Y') ? $row['fm_goods_name'] : "<span style='color:blue'>[수동매칭]</span> {$row['fm_goods_name']}";
				$fmProductCode			= '';
			} else {
				$row['fm_goods_seq']	= '';
				$fmGoodsName			= "<span style='color:red'>매칭된 상품이 없습니다.</span>";
				$fmProductCode			= '';
			}

			if($row['add_product_yn'] == 'Y' && $row['fm_goods_name'])
				$fmGoodsName	= "<span style='color:blue'>추가구성옵션 입니다.</span>";

			
			if (trim($row['matched_option_name']) == '') {
				$row['matched_option_name']		= '';
				$matchedOptionName				= trim($row['order_option_name']);
			} else {
				$matchedOptionName				= "<span style='color:blue'>[수동매칭]</span><br/>{$row['matched_option_name']}";
			}
			
			//20170922 jhs shoplinker 추가
			$chkShoplinker  = $this->checkShoplinkMarket($row['market']);
			if($chkShoplinker){
				$paramsLC 							= array("mallCode"=>$row['market']);
				$openmarketInfo						= $this->connectormodel->getLinkageCompany($paramsLC)[0];
				$row['market_name']					= $openmarketInfo['mall_name'];
			}else{
				$row['market_name']					= $marketList[$row['market']]['name'];
			}

			//개인정보 마스킹 표시
			$this->load->library('privatemasking');
			$row = $this->privatemasking->masking($row, 'order');

			$row['fm_order_seq']				= ($row['fm_order_seq'] < 1) ? '' : $row['fm_order_seq'];
			$row['seq_list']					= $row['seq'];
			$row['market_order_status_text']	= $orderStatus[$row['market_order_status']];
			$row['order_product_text']			= $orderProductName;
			$row['order_option_text']			= $row['order_option_name'];
			$row['matched_option_text']			= $matchedOptionName;
			$row['orderer']						= "{$row['orderer_name']}<br/>{$row['orderer_cellphone']}";
			$row['recipient']					= "{$row['recipient_name']}<br/>{$row['recipient_cellphone']}";
			$row['recipient_address_all']		= "{$row['recipient_address']}<br/>{$row['recipient_address_detail']}";
			$row['order_time_text']				= "{$row['order_time']}";
			$row['pay_time_text']				= "{$row['settle_time']}";
			$row['order_amount']				= number_format($row['order_amount']);
			$row['paid_amount']					= number_format($row['paid_amount']);
			$row['shipping_cost']				= number_format($row['shipping_cost']);
			$row['fm_goods_name']				= $fmGoodsName;

			if ($row['fm_order_seq'] > 0)
				$row['fm_order_seq_text']		= "<a href='/admin/order/view?no={$row['fm_order_seq']}' target='_order'>{$row['fm_order_seq']}</a>";

			unset($row['seq']);

			$orderList[$key]		= $row;
		}

		$return['totalCount']		= $response['totalCount'];
		$return['marketOrderList']	= $orderList;

		$totalPage		= ceil($return['totalCount']/$params['limit']);

		$pageLimit		= 10;
		$nowEndPage		= ($params['page'] <= $pageLimit) ? $pageLimit : (ceil($params['page'] / $pageLimit)) * $pageLimit;

		$nowStartPage	= ($params['page'] < $pageLimit) ? 1 : $nowEndPage - $pageLimit + 1;
		$nowEndPage		= ($nowEndPage > $totalPage) ?  $totalPage :  $nowEndPage;
		$pages			= array();

		for($i = $nowStartPage; $i <= $nowEndPage; $i ++)
			$pages[]	= $i;

		$return['paging']	= pagingtagjs($params['page'], $pages, $totalPage, 'movePage([:PAGE:]);', $pageLimit);
		


		echo json_encode($return);
	}


	public function getMarketClaimList() {
		
		$params				= $this->input->get();
		$params['limit']	= ((int)$params['limit'] < 1) ? 5 : $params['limit'];
		$params['page']		= ((int)$params['page'] < 1) ? 1 : $params['page'];

		if (trim($params['keyword'])) {
			switch($this->input->get('searchType')) {
				case	'fmClaimCode' :
					$params['fmClaimCode']		= trim($this->input->get('keyword'));
					break;

				case	'marketOrderNo';
					$params['marketOrderNo']	= trim($this->input->get('keyword'));
					break;
			}
		}

		switch ($params['now_claim_type']) {
			case	'RTN' :
			case	'EXC' :
				break;
			default	:
				$params['now_claim_type']	= 'CAN';
		}

	
		$params['claimType']		= $params['now_claim_type'];
		$params['withTotalCount']	= ((int)$params['totalCount'] < 1 || $params['page'] == 1) ? true : false;

		$orderStatus	= $this->_connectorBase->getStatusCode('order');
		$marketList		= $this->supportMarkets;
		$response		= $this->connectormodel->getMarketClaimList($params, 'forViewList');
		$claimList		= array();

		foreach((array)$response['resultList'] as $key => $row) {
			
			$orderProductName	= ($row['add_product_yn'] == 'Y') ? '[추가옵션]' : '';
			$orderProductName	.= "{$row['order_product_name']}";
			($row['order_option_name'] != '') ?  $orderProductName	.= "<br/>{$row['order_option_name']}" : '';

			//20170922 jhs shoplinker 추가
			$chkShoplinker  = $this->checkShoplinkMarket($row['market']);
			if($chkShoplinker){
				$paramsLC 							= array("mallCode"=>$row['market']);
				$openmarketInfo						= $this->connectormodel->getLinkageCompany($paramsLC)[0];
				$row['market_name']					= $openmarketInfo['mall_name'];
			}else{
				$row['market_name']					= $marketList[$row['market']]['name'];
			}
			
			//$row['market_name']			= $marketList[$row['market']]['name'];
			$row['claim_status_text']	= $orderStatus[$row['claim_status']];
			$row['seq_list']			= $row['seq'];
			$row['claim_time_text']		= "{$row['registered_time']}";
			$row['claim_close_time']	= "{$row['claim_close_time']}";
			$row['claim_reason']		= " {$row['claim_reason_desc']}";

			if ($row['is_fm_order'] != 'Y')
				$row['order_product_name']	= "<span style='color:red'>저장된 주문이 없습니다.</span>";
			else
				$row['order_product_name']	= $orderProductName;



			if ($row['fm_order_seq'] > 0)
				$row['fm_order_seq_text']	= "<a href='/admin/order/view?no={$row['fm_order_seq']}' target='_order'>{$row['fm_order_seq']}</a>";

			if ($row['fm_goods_seq'] > 0)
				$row['fm_goods_seq_text']	= "<a href='/admin/goods/regist?no={$row['fm_goods_seq']}' target='_product'>{$row['fm_goods_seq']}</a>";
			
			

			$row['able_to_select']			= false;
			$row['fm_claim_code_text']		= '';

			switch($params['claimType']) {
				case	'CAN' :
					if($row['is_fm_order'] == 'Y' && $row['fm_claim_code'] == '' && $row['claim_status'] == 'CAN00')
						$row['able_to_select']		= true;

					if ($row['fm_claim_code'])
						$row['fm_claim_code_text']	= "<a href='/admin/refund/view?no={$row['fm_claim_code']}' target='_refund'>{$row['fm_claim_code']}</a>";
					
					$row['claim_type_text']		= '주문취소';
					break;

				case	'RTN' :
					if($row['is_fm_order'] == 'Y' && $row['fm_claim_code'] == '' && $row['claim_status'] == 'RTN00')
						$row['able_to_select']		= true;

					if ($row['fm_claim_code'])
						$row['fm_claim_code_text']	= "<a href='/admin/returns/view?no={$row['fm_claim_code']}' target='_refund'>{$row['fm_claim_code']}</a>";
					
					$row['claim_type_text']		= '반품';
					break;


				case	'EXC' :
					if($row['is_fm_order'] == 'Y' && $row['fm_claim_code'] == '' && $row['claim_status'] == 'EXC00')
						$row['able_to_select']		= true;
					
					if ($row['fm_claim_code'])
						$row['fm_claim_code_text']	= "<a href='/admin/returns/view?no={$row['fm_claim_code']}' target='_refund'>{$row['fm_claim_code']}</a>";

					$row['claim_type_text']		= '교환';
					break;
			}


			unset($row['seq']);
			$claimList[$key]		= $row;
		}

		$return['totalCount']		= $response['totalCount'];
		$return['marketClaimList']	= $claimList;

		$totalPage			= ceil($return['totalCount']/$params['limit']);


		$pageLimit			= 10;
		$nowEndPage			= ($params['page'] <= $pageLimit) ? $pageLimit : (ceil($params['page'] / $pageLimit)) * $pageLimit;

		$nowStartPage		= ($params['page'] < $pageLimit) ? 1 : $nowEndPage - $pageLimit + 1;
		$nowEndPage			= ($nowEndPage > $totalPage) ?  $totalPage :  $nowEndPage;
		$pages				= array();

		for($i = $nowStartPage; $i <= $nowEndPage; $i ++)
			$pages[]		= $i;

		$return['paging']	= pagingtagjs($params['page'], $pages, $totalPage, 'movePage([:PAGE:]);', $pageLimit);

		echo json_encode($return);
	}


	public function doCancelComplete() {
		$params['listSeq']	= $this->input->post('listSeq');

		if (count($params['listSeq']) < 1) {
			$return['message']	= '선택된 취소 주문이 없습니다.';
			echo json_encode($return);
			exit;
		}
		$claimService		= $this->connector::getInstance('claim');
		$claimList			= $this->connectormodel->getMarketClaimList($params, 'withMarketOrder', true);
		$completeList		= array();
		$rejectList			= array();
		$failMessage		= array();
		$requestCount		= 0;


		foreach((array)$claimList as $claimInfo) {

			$dateTme				= explode(' ', $claimInfo['registered_time']);
			$claimRegisteredDate	= $dateTme[0];

			$cancelParams['request']						= array();
			$cancelParams['request']['marketClaimCode']		= $claimInfo['market_claim_code'];
			$cancelParams['request']['marketOrderNo']		= $claimInfo['market_order_no'];
			$cancelParams['request']['marketDeliveryNo']	= $claimInfo['market_delivery_no'];
			$cancelParams['request']['marketOrderSeq']		= $claimInfo['market_order_seq'];
			$cancelParams['request']['requestQty']			= $claimInfo['request_qty'];
			$cancelParams['request']['claimRegisteredDate']	= $claimRegisteredDate;
			$cancelParams['request']['marketClaimRawData']	= json_decode($claimInfo['claim_raw_info'],1);
			
			$claimService->setMarketInfo($claimInfo['market'], $claimInfo['seller_id']);
			$chkShoplinker  = $this->checkShoplinkMarket($claimInfo['market']);
			if($chkShoplinker){
				$MarketLinkage	= config_load('MarketLinkage');
				$cancelParams['request']['shoplinkerId'] = $MarketLinkage['shoplinkerId'];
			}

			$result			= $claimService->callConnector("Claim/doCancelComplete", $cancelParams);

			if ($result['success'] == 'Y' && $result['resultData']['claimStatus'] == 'CAN10')
				$completeList[]	= $claimInfo['seq'];
			if ($result['success'] == 'Y' && $result['resultData']['claimStatus'] == 'CAN99')
				$rejectList[]	= $claimInfo['seq'];
			else
				$failList[]		= $claimInfo['market_order_no'];

			$requestCount++;
		}
		
		$claimService->registerFmOrderCancel($completeList, $rejectList);

		$successCount		= count($completeList);
		$rejectCount		= count($rejectList);
		$failCount			= $requestCount - $successCount - $rejectCount;
		$return['message']	= "{$result['resultData']['claimStatus']}{$requestCount}건 중 - 성공 {$successCount}건 / 실패 {$failCount}건 / 거부 {$rejectCount}건";

		if(count($failList) > 0) {
			$marketOrderList	= implode('<br/>', $failList);
			$return['message']	.= "<br/>아래 주문을 확인해주세요 <br/>".$marketOrderList;
		}

		echo json_encode($return);
	}

	public function doClaimRegister() {
		
		switch ($this->input->post('claimType')) {
			case	'return' :
				$claimType	= 'RTN';
				break;

			case	'exchange' :
				$claimType	= 'EXC';
				break;

			default :
				exit;
		}

		$params['listSeq']	= $this->input->post('listSeq');
		$claimService	= $this->connector::getInstance('claim');
		$result				= $claimService->registerFmOrderReturn($params['listSeq'], $claimType);
		$totalCount			= count($params['listSeq']);
		$failCount			= count($result['error']);
		$successCount		= $totalCount - $failCount;
		$return['message']	= "반품접수 : {$totalCount}건 중 - 성공 {$successCount}건 / 실패 {$failCount}건";
		if(count($return['error']) > 0) {
			$marketOrderList	= implode('<br/>', $return['error']);
			$return['message']	.= "<br/>실패 리스트<br/>".$marketOrderList;
		}
		
		echo json_encode($return);

	}

	
	public function getMarketProductList() {
		$status		= $this->_connectorBase->getStatusCode('product');
		$params		= $this->input->get();

		if (trim($this->input->get('keyword'))) {
			switch($this->input->get('searchType')) {
				case	'fmGoodsSeq' :
					$params['fmGoodsSeq']			= trim($this->input->get('keyword'));
					break;

				case	'marketProductCode';
					$params['marketProductCode']	= trim($this->input->get('keyword'));
					break;
				
				case	'marketProductName';
					$params['marketProductName']	= trim($this->input->get('keyword'));
					break;
			}
		}
		
		$params['limit']	= ((int)$params['limit'] < 1) ? 20 : $params['limit'];
		$params['page']		= ((int)$params['page'] < 1) ? 1 : $params['page'];
		
		if (is_array($params['status']) == true && count($params['status']) > 0) {
			
			$saleOutIdx		= array_search('saleOut', $params['status']);
			$params['marketSaleStatus']	= array();
			if ($saleOutIdx === false) {
				$params['marketSaleStatus']	= $params['status'];
			} else {
				unset($params['status'][$saleOutIdx]);

				if (count($params['status']) > 0)
					$params['marketSaleStatus']	= array_merge($params['status'], ['211', '212', '300', '900', '999']);
				else
					$params['marketSaleStatus']	= array('211', '212', '300', '900', '999');
			}
		}

		// ajax 호출 시 json 으로 market 리스트 넘겨받음 2019-05-31 by hyem
		if($params['jsonMarket'] && empty($params['market'])) {
			$params['market'] = json_decode($params['jsonMarket']);
		}
		
		$response			= $this->connectormodel->getMarketProductList($params, 'forViewList');
		$countSet			= $response['totalCount'] - ($params['page'] - 1) * $params['limit'];
		$marketProductList	= array();

		$resultMessage		= '';
		$accountInfoList	= array();

		//getAccountInfo
		
		foreach((array)$response['marketProductList'] as $row) {

			$marketSaleStatusText	= $status[$row['market_sale_status']];
			switch ($row['market_sale_status']) {
				case	'211' :
				case	'212' :
				case	'300' :
				case	'900' :
				case	'999' :
					$marketSaleStatusText		= "<span style='color:red'>{$marketSaleStatusText}</span>";
					break;

				default :
					$marketSaleStatusText		= "<span style='color:blue'>{$marketSaleStatusText}</span>";
			}

			switch($row['last_result']) {
				case	'Y' :
					$resultMessage	= "<span style='color:blue'>성공</span>";
					break;
				
				case	'N' :
					$resultMessage	= "<span style='color:red'>실패</span>";
					break;
				
				case	'P' :
					$resultMessage	= "<span style='color:blue'>대기</span>";
					break;
			}

			
			$marketProductLink	= str_replace('%marketProductCode%', $row['market_product_code'], $this->supportMarkets[$row['market']]['productLink']);
			$marketProductLink	= str_replace('%confirmedProductCode%', $row['confirmed_product_code'], $marketProductLink);
			$chkShoplinker  = $this->checkShoplinkMarket($row['market']);
			if ($row['market'] == 'storefarm') {
				if (isset($accountInfoList[$row['market']][$row['seller_id']]) !== true) {
					$accountInfo	= $this->connectormodel->getAccountInfo(['market' => $row['market'], 'sellerId' => $row['seller_id']]);
					$accountInfoList[$row['market']][$row['seller_id']]		= $accountInfo['marketOtherInfo'];
				}
				
				$marketProductLink	= str_replace('%storefarmUrl%', $accountInfoList[$row['market']][$row['seller_id']]['storefarmUrl'], $marketProductLink);
				$row['market_name']					= $this->supportMarkets[$row['market']]['name'];
			}else if($chkShoplinker === true){
				$param['market'] = $row['market'];
				$param['sellerId'] = $row['seller_id'];
				$param['marketCode'] = $row['market_product_code'];
				//$response = $this->connectormodel->getShoplinkerProductLink($param);
				$marketProductLink	= $response['resultData'];
				
				$openmarketInfo						= $this->getShoplinkerMarketInfo($row['seller_id'],$row['market']);
				$row['market_name']					= $openmarketInfo['mall_name'];
			}else{
				$row['market_name']					= $this->supportMarkets[$row['market']]['name'];
			}

			//$marketProductLink	= str_replace('%sellerId%', $row['seller_id'], $marketProductLink);
			$market_product_link = $row['market_product_code'];
			if($this->supportMarkets[$row['market']]['productLink']){
				$rep_productLink = $this->supportMarkets[$row['market']]['productLink'];
				
				$accountInfo	= $this->connectormodel->getAccountInfo(['market' => $row['market'], 'sellerId' => $row['seller_id']]);
				
				$rep_productLink = str_replace('%storefarmUrl%', $accountInfo['marketOtherInfo']['storefarmUrl'], $rep_productLink);
				$rep_productLink = str_replace('%marketProductCode%', $row['market_product_code'], $rep_productLink);
				$rep_productLink = str_replace('%confirmedProductCode%', $row['confirmed_product_code'], $rep_productLink);
				$market_product_link = '<a href="'.$rep_productLink.'" target="_blank" >'.$row['market_product_code'].'</a>';
			}

			$row['no']							= $countSet--;
			$row['market_product_link']			= $market_product_link;
			$row['fm_product_link']				= "<a href='/admin/goods/regist?no={$row['goods_seq']}' target='_fmproduct'>{$row['goods_seq']}</a>";
			$row['list_result_text']			= $resultMessage;
			$row['distribute_time']				= "{$row['last_distributed_time']}<br/>{$row['registered_time']}";
			$row['market_sale_status_text']		= $marketSaleStatusText;
			
			$marketProductEditBtn    = '';

			if($chkShoplinker === true){
				
				/*샵링커 마켓 정보 조회*/
				$params["addInfoSeq"] = $row['add_info_seq'];
				$addInfo = $this->connectormodel->getShoplinkerAddInfo($params);
				$params2['sellerId'] = $addInfo['seller_id'];
				$params2['searchMarket2'] = $addInfo['market'];
				$shoplinkerAccountInfo = $this->connectormodel->getLinkageMarketAccountInfo($params2);
				$shoplinkerMarketOtherInfo = json_decode($shoplinkerAccountInfo['market_other_info'],true);
				/*샵링커 마켓 정보 조회*/
				
				$getParam = $addInfo['seller_id']."|".$shoplinkerMarketOtherInfo['marketCode']."|".$shoplinkerMarketOtherInfo['marketSeq'];
				
				if ($row['manual_matched'] == 'Y'){
					$row['market_product_name_link']	= "<span style='color:blue'>[수동매칭]</span> {$row['market_product_name']}";
				}else{
					$btnAction			= "goAddinfo('".$getParam."','".$addInfo['category_code']."');";
					$row['market_product_name_link']	= "<a href='#none' onclick=\"".$btnAction."\">{$row['market_product_name']}</a>";
					$marketProductEditBtn	= "<button type='button' onclick=\"".$btnAction."\" class='resp_btn v2'>수정</button>";
				}
				
			}else{
				
				if ($row['manual_matched'] == 'Y'){
					$row['market_product_name_link']	= "<span style='color:blue'>[수동매칭]</span> {$row['market_product_name']}";
				}else{
					$row['market_product_name_link']	= "<a href='/admin/market_connector/{$row['market']}_add_info?fmMarketProduceSeq={$row['fm_market_product_seq']}' target='_fmAddInfoLink'>{$row['market_product_name']}</a>";
					$url				= "/admin/market_connector/".$row['market']."_add_info?fmMarketProduceSeq=".$row['fm_market_product_seq'];
					$btnAction			= "window.open('".$url."','marketAddInfoPop','toolbar=no, scrollbars=yes, resizable=yes, width=1100, height=800');";
					
					$marketProductEditBtn	= "<button type='button' onclick=\"".$btnAction."\" class='resp_btn v2'>수정</button>";
				}
				
				$row['market_product_edit'] = $marketProductEditBtn;
			}
			



			$marketProductList[]		= $row;
		}

		$return['totlCount']			= $response['totalCount'];
		$return['marketProductList']	= $marketProductList;


		$totalPage		= ceil($return['totlCount']/$params['limit']);
		$pageLimit		= 10;
		$nowEndPage		= ($params['page'] <= $pageLimit) ? $pageLimit : (ceil($params['page'] / $pageLimit)) * $pageLimit;
		$nowStartPage	= ($params['page'] < $pageLimit) ? 1 : $nowEndPage - $pageLimit + 1;
		$nowEndPage		= ($nowEndPage > $totalPage) ?  $totalPage :  $nowEndPage;
		$pages			= array();
		for($i = $nowStartPage; $i <= $nowEndPage; $i ++)
			$pages[]	= $i;

		$return['paging']	= pagingtagjs($params['page'],$pages,$totalPage,'searchFormSubmit([:PAGE:]);', $pageLimit);

		echo json_encode($return);

	}


	public function getMarketProductLog() {
		$fmMarketProduceSeq	= $this->input->get('fmMarketProduceSeq');
		$response			= $this->connectormodel->getMarketProductLog($fmMarketProduceSeq);
		echo json_encode($response);
	}

	
	public function getAddInfoList() {
		
		$params['market']	= $this->input->get('market');
		$params['sellerId']	= $this->input->get('sellerId');
		$addInfoList		= $this->connectormodel->getAddinfoList($params);

		echo json_encode($addInfoList);
	}
	
	public function doCheckAlreadyDistributed() {
		$goodsList			= $this->input->post('goodsList');
		$market				= $this->input->post('market');
		$sellerId			= $this->input->post('sellerId');
		$distributedList	= $this->connectormodel->getAlreadyDistributedGoods($market, $sellerId, $goodsList);
		
		echo json_encode($distributedList);
	}

	public function doAddDistributor() {

		$goodsList			= (array)$this->input->post('goodsList');
		$market				= $this->input->post('market');
		$sellerId			= $this->input->post('sellerId');
		$addInfoSeq			= $this->input->post('addInfoSeq');
		$categoryType		= ($this->input->post('categoryType') == 'G') ? 'G' : 'M';
		$duplicateType		= ($this->input->post('alreadyRegisted') == 'Y') ? 'Y' : 'N';

		if (count($goodsList) < 1) {
			$return['success']		= 'N';
			$return['message']		= '등록가능한 상품이 없습니다.';

			echo json_encode($return);
			exit;
		}
		
		$chkShoplinker  = $this->checkShoplinkMarket($market);
		
		if($chkShoplinker){
			
			$goodsService			= $this->connector::getInstance('goods');
			
			/*샵링커 addinfo 저장*/
			$addInfo = explode("|", $addInfoSeq);
			$params['seller_id'] = $sellerId;
			$params['market'] = $market;
			$params['add_info_title'] = $addInfo[1];
			
			//카테고리 정보
			$params['category_code'] = $addInfo[0];
			
			$params['dep1_category_code'] = "";
			$params['dep2_category_code'] = "";
			$params['dep3_category_code'] = "";
			$params['dep4_category_code'] = "";
			$params['dep5_category_code'] = "";
			$params['dep6_category_code'] = "";
			
			$params['dep1_category_name'] = "";
			$params['dep2_category_name'] = "";
			$params['dep3_category_name'] = "";
			$params['dep4_category_name'] = "";
			$params['dep5_category_name'] = "";
			$params['dep6_category_name'] = "";
			
			$getAddInfo = $this->connectormodel->getShoplinkerAddInfo($params);
			
			if($getAddInfo['seq'] <= 0){
				$addInfoSeq = $goodsService->setMarketAddInfo($params);
			}else{
				$addInfoSeq = $getAddInfo['seq'];
			}
			
			/*샵링커 addinfo 저장*/
			
			$addInfo			= $this->connectormodel->getMarketAddInfo($addInfoSeq);

			if ($market != $addInfo['market'] || $sellerId != $addInfo['seller_id']) {
				$return['success']		= 'N';
				$return['message']		= '사용할 수 없는 추가정보입니다.';
			} else {
				$result					= $goodsService->addDistributor($addInfoSeq, $categoryType, $duplicateType, $goodsList);
				$return['success']		= 'Y';
				$return['message']		= "총 {$result['successCnt']}건의 상품이 등록되었습니다.";
				$return['resultDetail']	= $result;
			}
			
		}else{
			
			$addInfo			= $this->connectormodel->getMarketAddInfo($addInfoSeq);
			if ($market != $addInfo['market'] || $sellerId != $addInfo['seller_id']) {
				$return['success']		= 'N';
				$return['message']		= '사용할 수 없는 추가정보입니다.';
			} else {
				$goodsService			= $this->connector::getInstance('goods');
				$result					= $goodsService->addDistributor($addInfoSeq, $categoryType, $duplicateType, $goodsList);
				$return['success']		= 'Y';
				$return['message']		= "총 {$result['successCnt']}건의 상품이 등록되었습니다.";
				$return['resultDetail']	= $result;
			}
			
		}

		echo json_encode($return);		
	}

	public function add_distributor() {
		$params			= $this->input->post();
		$registed		= false;
		if	(!$params['distributor_goods'] || !$params['addInfo'])
			echo 'fail';

		if	($params['registed'] == 1)
			$registed	= true;

		foreach($params['distributor_goods'] as $goods){
			if	($registed){
				$sql = "select * from fm_market_product_info where goods_seq = ?";
				$result = $this->db->query($sql,$goods);
				$result = $result->row_array();
				if	(count($result) > 0) continue;
			}
			$insert['goods_seq']			= $goods;
			$insert['add_info_seq']			= $params['addInfo'];
			$insert['dist_category_type']	= $params['categoryType'];
			$insert['registered_time']		= date("Y-m-d H:i:s");
			$this->db->insert('fm_market_dist_standby', $insert);
		}
	}

	public function del_distributor(){
		$seq = $this->input->post('seq');
		if	($seq)
			$this->db->query('delete from fm_market_dist_standby where seq in ('.$seq.')');
	}

	public function getMatchedCategory() {
		$MarketLinkage	= config_load('MarketLinkage');
		
		$fmCategoryCode	= $this->input->get('fm_categor_code');
		
		if (strlen($fmCategoryCode) > 3) {
			if($MarketLinkage['shopCode'] == "shoplinker"){
				$market		= array('market'=>'shoplinker'); 
				$return		= $this->connectormodel->getMatchCategoryInfoByFm($fmCategoryCode,$market);
			}else{
				$return		= $this->connectormodel->getMatchCategoryInfoByFm($fmCategoryCode);
			}
			
		} else {
			$return		= array('errorMessage' => "카테고리 코드가 없습니다.");
		}

		echo json_encode($return);
	}

	public function saveCategoryMatch(){
		$params		= $this->input->post();
		$marketList	= $this->_connectorBase->getAllMarkets(true);
		$return		= array();

		if (isset($marketList[$params['market']]) !== true) {
			$return['success']		= 'N';
			$return['errorMessage']	= '알 수 없는 마켓입니다.';
		} else if (array_search($params['seller_id'], $marketList[$params['market']]['sellerList']) === false) {
			$return['success']		= 'N';
			$return['errorMessage']	= '알 수 없는 판매자 아이디입니다.';
		}
		

		if ($return['success'] !== 'N') {
			$matchSeq				= $this->connectormodel->cagegoryMatchingRegist($params);
			$return['success']		= 'Y';
			$return['message']		= '매칭성공';
		}

		echo json_encode($return);
	}

	public function deleteCategoryMatch() {
		$deleteParams		= file_get_contents('php://input');
		parse_str($deleteParams, $params);
	
		if (isset($params['matchedSeq']) === true) {
			$result				= $this->connectormodel->cagegoryMatchingDetete($params['matchedSeq']);
			$return['success']	= ($result === true) ? 'Y' : 'N';
		} else {
			$return['success']	= 'N';
		}
		
		
		echo json_encode($return);
	}

	public function checkMatchedCategory() {
		$fmCategoryCode		= $this->input->get('fm_category_code');
		$market['market']	= $this->input->get('market');
		//$market['sellerId']	= $this->input->get('seller_id'); javascript 에서는 sellerId 로 넘겨주고 있음
		$market['sellerId']	= $this->input->get('sellerId');
		$return				= $this->connectormodel->getMatchCategoryInfoByFm($fmCategoryCode, $market);

		echo json_encode($return);
	}
	

	public function add_info_delete(){
		$seq = $this->input->post('seq');
		if	($seq){
			$sql = "delete from fm_market_add_info where seq in (".$seq.")";
			$this->db->query($sql);
		}
	}

	public function getFmGoodsInfo() {
		$this->load->model('goodsmodel');
		$goodsInfo	= $this->goodsmodel->get_goods((int)$this->input->get('fmGoodsSeq'));
		echo json_encode($goodsInfo);
	}

	public function doManualMatch() {
		$marketOrderInfo					= $this->input->post('marketOrderInfo');
		$marketInfo['marketProductName']	= $marketOrderInfo['order_product_name'];
		$marketInfo['market']				= $marketOrderInfo['market'];
		$marketInfo['sellerId']				= $marketOrderInfo['seller_id'];
		$marketInfo['marketProductCode']	= $marketOrderInfo['market_product_code'];
		//수동 매칭 동시에 옵션 매칭
		$marketInfo['order_option_text']	= $marketOrderInfo['order_option_text'];
		$marketInfo['matched_option_text']	= $marketOrderInfo['matched_option_text'];
		//수동 매칭 동시에 옵션 매칭
		$marketInfo['fmGoodsSeq']			= $this->input->post('fmGoodsSeq');

		$goodsService	= $this->connector::getInstance('goods');
		$return			= $goodsService->goodsRegisterdManualMatch($marketInfo);

		echo json_encode($return);
	}

	public function doOptionNameMatch() {
		$listSeq			= (int)$this->input->post('fmMarketOrderSeq');
		$matchedOptionName	= $this->input->post('matchedOptionName');
		$orderService		= $this->connector::getInstance('order');
		$return				= $orderService->doOrderOptionNameMatch($listSeq, $matchedOptionName);
		echo json_encode($return);
	}


	public function getAuthInfo() {
		$market		= $this->input->get('market');
		$authInfo	= file_get_contents(get_connet_protocol()."interface.firstmall.kr/firstmall_plus/market_auth.php?market={$market}");
		echo json_encode(unserialize($authInfo));
	}	
	
	
	
	public function getShoplinkerGroupList(){
		$response = array();
		
		$params = $this->input->get();
		$MarketLinkage	= config_load('MarketLinkage');
		$shoplinkerAccountInfo = $this->connectormodel->getLinkageMarketAccountInfo($params);		
		$shoplinkerMarketOtherInfo = json_decode($shoplinkerAccountInfo['market_other_info'],true);
		
		$postVal['customer_id'] = $MarketLinkage['shoplinkerCode'];
		$postVal['user_id'] = $shoplinkerAccountInfo['seller_id'];
		$postVal['mall_id'] = $shoplinkerMarketOtherInfo['marketCode'];
		$postVal['market'] = $params['market'];
		$postVal['sellerId'] = $shoplinkerMarketOtherInfo['marketCode'];
		
		$rtn = $this->connectormodel->getShoplinkerGroupInfo($postVal);
		
		if($rtn['success'] == "Y"){
			$i = 0;
			foreach ($rtn['resultData'] as $data){
				$response[$i]['seq'] = $data['group_id'];
				$response[$i]['add_info_title'] = $data['group_name'];
				$i++;
			}
		}
		
		echo json_encode($response);;
	}
	
	
	public function getShoplinkerMarketInfo($sellerId, $market){
		$params 							= array('sellerId'=>$sellerId, 'searchMarket2'=>$market);
		$shoplinkerAccountInfo 				= $this->connectormodel->getLinkageMarketAccountInfo($params);
		$shoplinkerMarketOtherInfo 			= json_decode($shoplinkerAccountInfo['market_other_info'],true);
		
		unset($params);
		
		$params								= array('mallCode'=>$shoplinkerMarketOtherInfo['marketCode']);
		$openmarketInfo						= $this->connectormodel->getLinkageCompany($params)[0];
		return $openmarketInfo;
	}
	
	/**
	 * 샵링커 체크 함수
	 * @param unknown $market
	 * @return boolean
	 */
	public function checkShoplinkMarket($market){
		$reaponse = false;
		if(strpos($market,"API") !== false){
			$reaponse = true;
		}
		return $reaponse;
	}

	public function getMarketQnaList() {
		
		$params				= $this->input->get();
		$params['limit']	= ((int)$params['limit'] < 1) ? 5 : $params['limit'];
		$params['page']		= ((int)$params['page'] < 1) ? 1 : $params['page'];
		
		$marketList		= $this->supportMarkets;

		$params['withTotalCount']	= ((int)$params['totalCount'] < 1 || $params['page'] == 1) ? true : false;

		$getInfoMode = $params['mode'] == 'detail' ? 'forRegisterQna' : 'forViewList';

		$response		= $this->connectormodel->getMarketQnaList($params,$getInfoMode);
		$countSet			= $response['totalCount'] - ($params['page'] - 1) * $params['limit'];
		$qnaList		= array();

		foreach((array)$response['resultList'] as $key => $row) {
			$row['no']							= $countSet--;
			$row['qna_time']					= $row['market_qna_date'];

			$chkShoplinker  = $this->checkShoplinkMarket($row['market']);
			if($chkShoplinker === true){
				$openmarketInfo					= $this->getShoplinkerMarketInfo($row['seller_id'],$row['market']);
				$row['market_name']				= $openmarketInfo['mall_name'];
			} else {
				$row['market_name']				= $this->supportMarkets[$row['market']]['name'];
			}
			
			$row['title']						= $row['market_qna_title'];
			$row['contents']					= $row['market_conent'];

			$row['qna_status_text']				= $row['fm_answer_yn'] == 'Y' ? '답변완료' : '답변대기';
			$row['answer_time']					= $row['answered_date'];
			$row['last_status_text']			= $row['last_result'] == 'Y' ? '성공' : '실패';

			$qnaList[$key]		= $row;
		}

		$return['totalCount']		= $response['totalCount'];
		$return['marketQnaList']	= $qnaList;

		$totalPage		= ceil($return['totalCount']/$params['limit']);

		$pageLimit		= 10;
		$nowEndPage		= ($params['page'] <= $pageLimit) ? $pageLimit : (ceil($params['page'] / $pageLimit)) * $pageLimit;

		$nowStartPage	= ($params['page'] < $pageLimit) ? 1 : $nowEndPage - $pageLimit + 1;
		$nowEndPage		= ($nowEndPage > $totalPage) ?  $totalPage :  $nowEndPage;
		$pages			= array();

		for($i = $nowStartPage; $i <= $nowEndPage; $i ++)
			$pages[]	= $i;

		$return['paging']	= pagingtagjs($params['page'], $pages, $totalPage, 'movePage([:PAGE:]);', $pageLimit);
		
		if( $params['mode'] == 'detail') {

			if( $row['fm_goods_seq'] ) {
				$this->load->model('goodsmodel');

				$provider	= $this->goodsmodel->get_provider_names(array($row['fm_goods_seq']));
				$provider_name = array_pop($provider);
				$return['marketQnaList']['0']['provider_name'] = $provider_name['provider_name'];

				$image = $this->goodsmodel->get_goods_image($row['fm_goods_seq'], array('image_type'=>'thumbView'));
				$image = $image['1']['thumbView']['image'];
				$return['marketQnaList']['0']['image'] = $image;
			}
			
			$this->template->assign(array(
				'marketQna'		=> $return['marketQnaList']['0'],
				'imageSize'		=> config_load('goodsImageSize','thumbView')
			));

			$tpl = "default/market_connector/market_qna_answer.html";
			$this->template->define(array('tpl'=>$tpl));
			$this->template->print_("tpl");
			exit;
		}

		echo json_encode($return);
	}

	public function getQnaCollect() {
		$beginDate	= $this->input->get('startDate');
		$endDate	= $this->input->get('endDate');
		$market		= $this->input->get('market');
		$sellerId	= $this->input->get('sellerId');
		$return		= $this->getQnaCollectAction($market, $sellerId, $beginDate, $endDate);

		echo json_encode($return);
	}

	public function getQnaCollectAction($market, $sellerId, $beginDate = '', $endDate = '') {
		$beginDate	= ($beginDate == '') ? date('Y-m-d') : $beginDate;
		$endDate	= ($endDate == '') ? date('Y-m-d') : $endDate;
	
		$this->_connectorBase->setMarketInfo($market, $sellerId);
		
		$chkShoplinker  = $this->checkShoplinkMarket($market);
		if($chkShoplinker){
			$MarketLinkage	= config_load('MarketLinkage');
			$postVal['request']['shoplinkerId'] = $MarketLinkage['shoplinkerId'];
			$response	= $this->_connectorBase->callConnector("Qna/getQnaList/{$beginDate}/{$endDate}/all",$postVal);
		}else{
			$response	= $this->_connectorBase->callGetConnector("Qna/getQnaList/{$beginDate}/{$endDate}/all");
		}

		if(!trim($response['resultData'][0]['marketQnaSeq']) && count($response['resultData']) == 1) $response['resultData'] = array();
		if ($response['success'] != 'Y')
			return $response;
		
		$qnaService		= $this->connector::getInstance('qna');
		return $qnaService->marketQnaInsert($market, $sellerId, $response['resultData']);
	}

	public function doQnaAnswer() {
		$params['seqList']	= $this->input->post('seq');

		if (count($params['seqList']) < 1) {
			exit;
		}
		$qnaService			= $this->connector::getInstance('qna');
		$qnaList			= $this->connectormodel->getMarketQnaList($params);

		$qnaInfo = array_pop($qnaList['resultList']);

		$qnaParams['request']							= array();
		$qnaParams['request']['marketQnaSeq']			= $qnaInfo['market_qna_seq'];
		$qnaParams['request']['marketAnswer']			=  $this->input->post('market_answer');
		$qnaParams['request']['marketAnswerSeq']		= $qnaInfo['market_answer_seq'];
		$qnaParams['request']['marketQnaDate']			= $qnaInfo['market_qna_date'];
		$qnaParams['request']['seq']					= $params['seqList'];
		
		$qnaService->setMarketInfo($qnaInfo['market'], $qnaInfo['seller_id']);
		$chkShoplinker  = $this->checkShoplinkMarket($qnaInfo['market']);
		if($chkShoplinker){
			$MarketLinkage	= config_load('MarketLinkage');
			$qnaParams['request']['shoplinkerId'] = $MarketLinkage['shoplinkerId'];
		} else {
			if( $qnaInfo['market'] == 'storefarm') {
				$qnaParams['request']['type'] = ($qnaInfo['market_order_no']) ? 'seller' : 'goods';
			}else if( $qnaInfo['market'] == 'open11st') {
				$qnaParams['request']['qnaProductCode']					= $qnaInfo['market_product_code'];
			}
		}

		$result			= $qnaService->callConnector("Qna/doQnaAnswer", $qnaParams);

		if ($result['success'] == 'Y') {
			//답변 전송 성공 결과 qna 테이블에 업데이트
			$qnaService->qnaAnswerComplete($qnaParams['request'], $result['resultData']);

			//로그저장
			$logMessage		= "답변 전송 성공";
			$qnaService->makeMarketQnaLog($params['seqList'], $logMessage);

			$callback = "parent.location.reload();";
			openDialogAlert("답변이 전송되었습니다.", 400, 140, 'parent', $callback);
			exit;

		} else {
			//답변 전송 실패 결과 qna 테이블에 업데이트
			$qnaService->qnaAnswerComplete($qnaParams['request'], $result['resultData'], 'no');

			//로그저장
			$logMessage		= "답변 전송 실패";
			if ( $result['resultData']['message'] ) $logMessage .= " - ".$result['resultData']['message'];
			$qnaService->makeMarketQnaLog($params['seqList'], $logMessage);

			openDialogAlert("답변 전송이 실패되었습니다.", 400, 140, 'parent');
			exit;
		}
	}
	
	public function openmarket_auto_regist_order()
	{
		$sOpenmarketAutoRegistOrder	= $this->input->post('openmarketAutoRegistOrder');
		$callback	= "parent.location.reload();";
		config_save('MarketLinkage', array('openmarket_auto_regist_order' => $sOpenmarketAutoRegistOrder));
		openDialogAlert("저장 되었습니다.", 400, 140, 'parent', $callback);
	}

	public function marketQnaDelete() {
		$seq		= $this->input->post('seq');
		
		$updateInfo['fm_delete_yn']		= 'Y';
		$this->connectormodel->updateMarketQnaInfo($seq, $updateInfo);

		echo json_encode(array("result_type"=>'productDelete', "result_message"=>'정상 삭제 되었습니다.'));
		return true;
	}
	
	// 사용 중인지 여부를 체크한다.
	public function getInUse()
	{
	    $this->load->model("connectormodel");
	    $row = $this->connectormodel->getInUse();
	    if($row === false || empty($row) || is_array($row) !== true) {
	        $this->output->set_status_header('200')->set_content_type('application/json')->set_output(json_encode(array('inUse'=>"N")));
	    } else {
	        $this->output->set_status_header('200')->set_content_type('application/json')->set_output(json_encode(array(
	            'inUse'    =>  'Y',
	            'user'     =>  $row['inUse']['user'],
	            'date'     =>  $row['inUse_date'],
	        )));
	    }
	}
	
	// 사용 중인지 여부를 표시한다.
	public function setInUse($value = null)
	{
	    $userData = $this->session->get_userdata();
	    if(empty($userData['manager']) || empty($userData['manager']['manager_id']) || empty($userData['manager']['manager_seq'])) {
	        $this->output->set_status_header('404');
	        exit;
	    }
	    $data = array();
	    // 인자를 받고 함수가 실행된 경우에는 인자의 값으로, 그것이 아닐 경우에는 $_GET['value'] 로 대입한다.
	    $data['value'] = (!empty($value) && in_array($value,array("Y","N"))===true ? $value : $this->input->get('value'));
	    if(empty($data['value']) || in_array($data['value'], array('Y', 'N')) !== true) {
	        $data['value'] = 'N';
	    }
	    $data['user'] = array();
	    $data['user']['manager_id'] = $userData['manager']['manager_id'];
	    $data['user']['manager_seq'] = $userData['manager']['manager_seq'];
	    if(!empty($userData['manager']['mname'])) {
	        $data['user']['mname'] = $userData['manager']['mname'];
	    }
	    $this->load->model("connectormodel");
	    $this->connectormodel->setInUse($data);
	}
}
