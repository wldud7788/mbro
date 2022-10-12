<?php
class Connectormodel extends CI_Model {

	protected $_connectorBasic;
	public $statusCodeList	= array();

	public function __construct() {
		parent::__construct();
		$this->load->library('Connector');
		$this->_connectorBasic		= $this->connector::getInstance();
		$this->load->model('usedmodel');
	}

	public function getAccountList($params, $withDeleted = false) {
		$whereArr		= array();

		if (isset($params['market']) == true && trim($params['market']))
			$whereArr['market']			= $params['market'];

		if (isset($params['sellerId']) == true && trim($params['sellerId']))
			$whereArr['seller_id']		= $params['sellerId'];

		if (isset($params['accountUse']) == true && trim($params['accountUse']))
			$whereArr['account_use']	= ($params['accountUse'] == 'N') ? 'N' : 'Y';

		if ($withDeleted !== true)
			$whereArr['delete_yn']		= 'N';

		$query			= $this->db->get_where('fm_market_account', $whereArr);
		$accountList	= array();

		foreach($query->result() as $accountObj) {
			$accountInfo					= array();
			$accountInfo['accountSeq']		= $accountObj->seq;
			$accountInfo['market']			= $accountObj->market;
			$accountInfo['sellerId']		= $accountObj->seller_id;
			$accountInfo['marketOtherInfo']	= json_decode($accountObj->market_other_info, 1);
			$accountInfo['goodsPriceSet']	= json_decode($accountObj->goods_price_set, 1);
			$accountInfo['goodsStockSet']	= json_decode($accountObj->goods_stock_set, 1);
			$accountInfo['accountUse']		= $accountObj->account_use;
			$accountList[]					= $accountInfo;
		}

		return $accountList;
	}

	public function getUseAllMarkets() {
		$marketList	= $this->_connectorBasic->getAllMarkets();
		$MarketLinkage	= config_load('MarketLinkage');

		if($MarketLinkage["shopCode"] == "shoplinker"){
			foreach ($marketList as $key => $val){
				$chkShoplinker  = $this->checkShoplinkMarket($key);
				if($chkShoplinker === false){
					unset($marketList[$key]);
				}
			}
		}else{
			
			foreach ($marketList as $key => $val){
				$chkShoplinker  = $this->checkShoplinkMarket($key);
				if($chkShoplinker === true){
					unset($marketList[$key]);
				}
			}
			
		}
		if($marketList==null || !isset($marketList)){
			$marketList = array();
		}

		return $marketList;
	}

	public function getUseMarketList($params=array()) {
		$supportMarkets			= $this->_connectorBasic->getSupportMarkets(true);
		$where['delete_yn']		= 'N';
		if($params['account_use']) {
			$where['account_use'] = $params['account_use'];
		}

		$this->db->select("market");
		$this->db->order_by("seq", "asc");
		$this->db->group_by("market");
		$query		= $this->db->get_where('fm_market_account', $where);

		$marketList	= array();
		foreach($query->result() as $market) {
			if (isset($supportMarkets[$market->market]) == true)
				$marketList[$market->market]	= $supportMarkets[$market->market]['name'];
		}

		return $marketList;
	}
	
	public function getUseShoplinkerMarketList($params=array()) {
		
		$where['delete_yn']		= 'N';
		if($params['account_use']) {
			$where['account_use'] = $params['account_use'];
		}

		$this->db->select("seq, market, seller_id, goods_price_set, goods_stock_set, account_use, delete_yn, market_other_info");
		$this->db->order_by("seq", "asc");
		$this->db->group_by("market");
		$this->db->like("market", "API","after");
		$query		= $this->db->get_where('fm_market_account', $where);

		$marketList	= array();
		$marketList = $query->result();

		return $marketList;
	}

	public function getAccountInfo($params, $withLogs = false) {

		$defaultPriceSet['adjustment']['use']	= 'N';	// 판매가 기본 설정
		$defaultStockSet['adjustment']['use']	= 'N';	// 재고수량 설정

		$this->db->from('fm_market_account');
		$whereArr	= array();
		if (isset($params['market']) === true){
			if($params['market'] == 'shoplinker'){
				$this->db->like('market', 'APISHOP', 'after');
			}else{
				$whereArr['market']		= $params['market'];
			}
		}

		if (isset($params['sellerId']) === true)
			$whereArr['seller_id']	= $params['sellerId'];

		if (isset($params['accountSeq']) === true) {
			unset($whereArr);
			$whereArr['seq']		= $params['accountSeq'];
		}

		$query			= $this->db->where($whereArr)->get();
		$accountInfo	= array();
		if (count($query->result()) > 0) {
			$accountObj		= $query->result()[0];
			$marketOtherInfo = json_decode($accountObj->market_other_info,true);
			
			$accountInfo['accountSeq']			= $accountObj->seq;
			$accountInfo['market']				= $accountObj->market;
			$accountInfo['marketName'] 			= $this->getMarketName($marketOtherInfo['marketSeq']);
			$accountInfo['sellerId']			= $accountObj->seller_id;
			$accountInfo['marketAuthInfo']		= json_decode($accountObj->market_auth_info, 1);
			$accountInfo['marketOtherInfo']		= json_decode($accountObj->market_other_info, 1);
			$accountInfo['goodsPriceSet']		= json_decode($accountObj->goods_price_set, 1);
			$accountInfo['goodsStockSet']		= json_decode($accountObj->goods_stock_set, 1);
			$accountInfo['accountUse']			= $accountObj->account_use;

			if (isset($accountInfo['goodsPriceSet']['adjustment']) !== true)
				$accountInfo['goodsPriceSet']	= $defaultPriceSet;

			if (isset($accountInfo['goodsStockSet']['adjustment']) !== true)
				$accountInfo['goodsStockSet']	= $defaultStockSet;

			if ($withLogs === true) {
				$this->db->order_by("seq", "desc");

				$accountInfo['accountLog']		= array();
				$logQuery		= $this->db->get_where('fm_market_account_log', ['account_seq' => $accountObj->seq], 100);

				foreach ($logQuery->result() as $logRow) {
					$nowLog['managerId']			= $logRow->manager_id;
					$nowLog['log']					= $logRow->log;
					$nowLog['logTime']				= $logRow->log_time;
					$accountInfo['accountLog'][]	= $nowLog;
				}

			}
		}

		return $accountInfo;
	}


	// Queue 요청 정보
	public function getMarketQueueList($requestId) {
		$select		= " SELECT * FROM fm_market_queue_list WHERE request_id = ?";
		$result		= $this->db->query($select, array($requestId));
		$resultData	= $result->row_array();

		$return		= array();
		if ($resultData['request_id'] == $requestId) {
			$return	= $resultData;
			if (strlen($return['other_info']) > 8) {
				$return['other_info_raw']	= $return['other_info'];
				$return['other_info']		= json_decode($return['other_info'], 1);
			}
		}

		return $return;
	}
	


	/*↓↓↓↓↓↓↓ 상품 추가정보 & 카테고리 매칭 ↓↓↓↓↓↓↓*/

	//새로 생성
	public function getAddinfoList($params, $returnMode = 'basic', $widthTotalCount = false) {
		$whereArr		= array();
		$whereValueArr	= array();
		
		if (isset($params['market']) == true && trim($params['market'])) {
			$whereArr[]			= 'market = ?';
			$whereValueArr[]	= $params['market'];
		}

		if (isset($params['market']) == true && trim($params['sellerId'])) {
			$whereArr[]			= 'seller_id = ?';
			$whereValueArr[]	= $params['sellerId'];
		}

		if (isset($params['keyword']) == true && trim($params['keyword'])) {
			$whereArr[]			= 'add_info_title like ?';
			$whereValueArr[]	= "%{$params['keyword']}%";
		}

		$basicWhere		= ' ';
		if (count($whereArr) > 0)
			$basicWhere	= ' WHERE '.implode(" AND ", $whereArr);
		
		$sortArr		= array();
		$sortArr[]		= 'ORDER BY';
		if (isset($params['sort']) && strlen($params['sort']) > 2) {
			$sortExp	= explode('^', $params['sort']);
			$fildField	= array_search($sortExp[0], $this->db->list_fields('fm_market_category_link'));
			$sortArr[]	= ($fildField !== false) ? $sortExp[0] : 'registered_time';
			$sortArr[]	= (isset($sortExp[1]) == true && strtolower($sortExp[1]) == 'asc') ? 'ASC' : 'DESC';
		} else {
			$sortArr[]	= "registered_time";
			$sortArr[]	= "DESC";
		}

		$sort			= implode(' ', $sortArr);
		
		$limit			= '';
		if (isset($params['limit'])) {
			$limitStart	= ($params['page'] - 1) * $params['limit'];
			$limit		= "LIMIT {$limitStart}, {$params['limit']}";
		}

		$sql			= "SELECT * FROM fm_market_add_info {$basicWhere} {$sort} {$limit}";


		$query			= $this->db->query($sql, $whereValueArr);
		$marketInfo		= $this->_connectorBasic->getAllMarkets(true);
		$addInfoList	= [];


		foreach ($query->result() as $row) {
			$addInfo						= array();
			$addInfo['seq']					= $row->seq;
			$addInfo['market']				= $row->market;
			$addInfo['seller_id']			= $row->seller_id;
			$addInfo['add_info_title']		= $row->add_info_title;
			$addInfo['dep1_category_code']	= $row->dep1_category_code;
			$addInfo['dep1_category_name']	= $row->dep1_category_name;
			$addInfo['dep2_category_code']	= $row->dep2_category_code;
			$addInfo['dep2_category_name']	= $row->dep2_category_name;
			$addInfo['dep3_category_code']	= $row->dep3_category_code;
			$addInfo['dep3_category_name']	= $row->dep3_category_name;
			$addInfo['dep4_category_code']	= $row->dep4_category_code;
			$addInfo['dep4_category_name']	= $row->dep4_category_name;
			$addInfo['dep5_category_code']	= $row->dep5_category_code;
			$addInfo['dep5_category_name']	= $row->dep5_category_name;
			$addInfo['dep6_category_code']	= $row->dep6_category_code;
			$addInfo['dep6_category_name']	= $row->dep6_category_name;
			$addInfo['registered_time']		= $row->registered_time;
			$addInfo['renewed_time']		= $row->renewed_time;
			$addInfo['fullCategoryName']	= implode(' > ', $this->_connectorBasic->makeMarketCategoryName($addInfo));
			$addInfo['marketName']			= $marketInfo[$row->market]['name'];
			$addInfoList[]					= $addInfo;

		}

		

		switch ($returnMode) {
			case	'forViewList' :
				if ($widthTotalCount == true) {
					$countSql		= "SELECT COUNT(*) as total_count FROM fm_market_add_info {$basicWhere}";
					$countQuery		= $this->db->query($countSql, $whereValueArr);
					$countResult	= $countQuery->result();
					$return['totalCount']	= $countResult[0]->total_count;
				} else {
					$return['totalCount']	= $params['totalCount'];
				}
			
				$return['resultList']		= $addInfoList;
				break;

			default :
				$return		= $addInfoList;
		}


		return $return;
	}


	
	/* 마켓 추가정보 */
	public function getMarketAddInfo($addInfoSeq) {
		$sql			= "SELECT * FROM fm_market_add_info WHERE seq = ?";
		$query			= $this->db->query($sql,array($addInfoSeq));
			
		$addInfoBase	= $query->row_array();
		$addInfoDetail	= json_decode($addInfoBase['add_info_detail'],1);

		unset($addInfoBase['add_info_detail']);

		$addInfo		= array_merge($addInfoBase, $addInfoDetail);
		$category		= $this->_connectorBasic->makeMarketCategoryName($addInfo);	
		$category_name	= implode(' > ', $category);
		$addInfo['category_name']	= $category_name;

		return $addInfo;
	}

	/* 카테고리 매칭 리스트 */
	public function getMatchCategoryList($params, $returnMode = 'basic', $widthTotalCount = false) {
		
		$whereArr		= $countWhereArr =  array();
		$whereValueArr	= $countWhereValueArr =  array();


		if (isset($params['fmCategoryCode']) && strlen($params['fmCategoryCode']) > 3) {
			$whereArr[]			= "fm_category_code LIKE ?";
			$whereValueArr[]	= "{$params['fmCategoryCode']}%";
		}

		if (isset($params['market']) == true && trim($params['market'])) {
			if($params['market'] == 'shoplinker' ){
				$whereArr[]	= $countWhereArr[]	= "substr(market,1,3) = 'API'";
			}else{
				$whereArr[]	= $countWhereArr[]	= 'market = ?';
				$whereValueArr[] = $countWhereValueArr = $params['market'];
			}

		}

		if (isset($params['searchMarket']) == true && trim($params['searchMarket'])) {
			$whereArr[]			= 'market = ?';
			$whereValueArr[]	= $params['searchMarket'];
		}


		if (isset($params['market']) == true && trim($params['sellerId'])) {
			$whereArr[]			= 'seller_id = ?';
			$whereValueArr[]	= $params['sellerId'];
		}


		$basicWhere		= $countWhere =  '';
		if (count($whereArr) > 0)
			$basicWhere	= ' WHERE '.implode(" AND ", $whereArr);
		if (count($countWhereArr) > 0)
			$countWhere	= ' WHERE '.implode(" AND ", $countWhereArr);

		
		
		$limit			= '';
		if (isset($params['limit'])) {
			$limitStart	= ($params['page'] - 1) * $params['limit'];
			$limit		= "LIMIT {$limitStart}, {$params['limit']}";
		}
		
		$sortArr		= array();
		$sortArr[]		= 'ORDER BY';
		if (isset($params['sort']) && strlen($params['sort']) > 2) {
			$sortExp	= explode('^', $params['sort']);
			$fildField	= array_search($sortExp[0], $this->db->list_fields('fm_market_category_link'));
			$sortArr[]	= ($fildField !== false) ? $sortExp[0] : 'registered_time';
			$sortArr[]	= (isset($sortExp[1]) == true && strtolower($sortExp[1]) == 'asc') ? 'ASC' : 'DESC';
		} else {
			$sortArr[]	= "registered_time";
			$sortArr[]	= "DESC";
			$sortArr[]	= ", seq";
			$sortArr[]	= "DESC";
		}

		$sort			= implode(' ', $sortArr);
		
		$sql			= "SELECT * FROM fm_market_category_link {$basicWhere} {$sort} {$limit}";
		$query			= $this->db->query($sql, $whereValueArr);
		$marketInfo		= $this->_connectorBasic->getAllMarkets(true);
		$categoryList	= [];
		
		foreach ($query->result() as $row) {

			$category['seq']					= $row->seq;
			$category['market']				= $row->market;
			$category['seller_id']			= $row->seller_id;
			$category['add_info_title']		= $row->add_info_title;
			$category['fm_category_code']	= $row->fm_category_code;
			$category['dep1_category_code']	= $row->dep1_category_code;
			$category['dep1_category_name']	= $row->dep1_category_name;
			$category['dep2_category_code']	= $row->dep2_category_code;
			$category['dep2_category_name']	= $row->dep2_category_name;
			$category['dep3_category_code']	= $row->dep3_category_code;
			$category['dep3_category_name']	= $row->dep3_category_name;
			$category['dep4_category_code']	= $row->dep4_category_code;
			$category['dep4_category_name']	= $row->dep4_category_name;
			$category['dep5_category_code']	= $row->dep5_category_code;
			$category['dep5_category_name']	= $row->dep5_category_name;
			$category['dep6_category_code']	= $row->dep6_category_code;
			$category['dep6_category_name']	= $row->dep6_category_name;
			$category['registered_time']	= $row->registered_time;
			$category['required_add_info']	= json_decode($row->required_add_info, 1);

			$category['required_addInfo_summery']	= $this->makeRequiredAddInfoSummery($category['required_add_info']);

			$fullCategoryName = $this->_connectorBasic->makeMarketCategoryName($category);
			$category['marketCategoryCode'] = $category['dep'.count($fullCategoryName).'_category_code'];	//매칭카테고리코드
			$category['fullCategoryName']	= implode(' > ', $fullCategoryName);
			$chkShoplinker  = $this->checkShoplinkMarket($row->market);
			if($chkShoplinker){
				$param['sellerId'] = $row->seller_id;
				$param['searchMarket2'] = $row->market;
				$marketOtherInfo = $this->getLinkageMarketAccountInfo($param);
				$marketSeqArray	= json_decode($marketOtherInfo['market_other_info'],true);
				$shoplinkerMarketName	= $this->getMarketName($marketSeqArray['marketSeq']);
				$category['marketName']			= $shoplinkerMarketName.'(샵링커)/'.$row->seller_id;
			}else{
				$category['marketName']			= $marketInfo[$row->market]['name'];
			}

			$categoryList[]					= $category;
		}
		
		switch ($returnMode) {
			case	'forViewList' :
				if ($widthTotalCount == true) {
					$countSql		= "SELECT COUNT(*) as total_count FROM fm_market_category_link {$basicWhere}";
					$countQuery		= $this->db->query($countSql, $whereValueArr);
					$countResult	= $countQuery->result();
					$return['searchCount']	= $countResult[0]->total_count;
					
					$countSql		= "SELECT COUNT(*) as total_count FROM fm_market_category_link {$countWhere}";
					$countQuery		= $this->db->query($countSql, $countWhereValueArr);
					$countResult	= $countQuery->result();
					$return['totalCount']	= $countResult[0]->total_count;

				} else {
					$return['totalCount']	= $params['totalCount'];
				}
			
				$return['resultList']		= $categoryList;
				break;

			default :
				$return		= $categoryList;
		}

		return $return;
	}

	public function makeRequiredAddInfoSummery($input) {
		$infoArray		= array();
		foreach ((array)$input as $row)
			$infoArray[]	= "{$row['title']} - {$row['valueText']}";
		return implode("\n",$infoArray);
	}
	
	/* 카테고리 매칭 등록 */
	public function cagegoryMatchingRegist($params) {
		
		$setMatching['market']					= $params['market'];
		$setMatching['seller_id']				= $params['sellerId'];
		$setMatching['fm_category_code']		= $params['fm_category_code'];
		$setMatching['category_code']			= $params['category_code'];
		$setMatching['dep1_category_code']		= $params['dep1_category_code'];
		$setMatching['dep2_category_code']		= $params['dep2_category_code'];
		$setMatching['dep3_category_code']		= $params['dep3_category_code'];
		$setMatching['dep4_category_code']		= $params['dep4_category_code'];
		$setMatching['dep5_category_code']		= $params['dep5_category_code'];
		$setMatching['dep6_category_code']		= $params['dep6_category_code'];
		$setMatching['dep1_category_name']		= $params['dep1_category_name'];
		$setMatching['dep2_category_name']		= $params['dep2_category_name'];
		$setMatching['dep3_category_name']		= $params['dep3_category_name'];
		$setMatching['dep4_category_name']		= $params['dep4_category_name'];
		$setMatching['dep5_category_name']		= $params['dep5_category_name'];
		$setMatching['dep6_category_name']		= $params['dep6_category_name'];
		
		$setMatching['required_add_info']		= json_encode($params['requiredAddInfo']);
		$setMatching['registered_time']			= date("Y-m-d H:i:s");
		
		$this->_connectorBasic->setMarketInfo($params['market'], $params['sellerId']);
		
		$chkShoplinker  = $this->checkShoplinkMarket($params['market']);
		
		if($chkShoplinker === true){
			$postVal['shoplinker'] = true;
			$result		= $this->_connectorBasic->callConnector("Other/getCategoryDesc/{$setMatching['category_code']}",$postVal);
		}else{
			$result		= $this->_connectorBasic->callGetConnector("Other/getCategoryDesc/{$setMatching['category_code']}");
		}
		
		
		
		if ($result['success'] == 'Y')
			$setMatching['category_add_info']	= json_encode($result['resultData']);

		$sql		= "SELECT seq FROM fm_market_category_link WHERE market = ? AND seller_id = ? AND fm_category_code = ?";
		$whereArr	= array($setMatching['market'], $setMatching['seller_id'], $setMatching['fm_category_code']);
		$reuslt		= $this->db->query($sql, $whereArr);
		$seqInfo	= $reuslt->row_array();

		if (isset($seqInfo['seq'])) {
			$this->db->update('fm_market_category_link', $setMatching, array('seq'=>$seqInfo['seq']));;
			return $seqInfo['seq'];
		} else {
			$this->db->insert('fm_market_category_link', $setMatching);
			return $this->db->insert_id();
		}
	
	}

	/* 카테고리 매칭 삭제 */
	public function cagegoryMatchingDetete($params) {
		
		$paramsArr			= array();

		if (is_array($params) === true)
			$paramsArr		= $params;
		else
			$paramsArr[]	= $params;

		$paramsArr			= array_unique($paramsArr);

		// 삭제할 seq 정의
		$deleteSeqList		= array();
		foreach($paramsArr as $delSeq) {
			if (preg_match('/[^0-9|^\.|^\-]/', $delSeq) == 0 || $delSeq === '')
				$deleteSeqList[]	= (int)$delSeq;

		}

		if (count($deleteSeqList) < 1)
			return false;

		$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($deleteSeqList))));
		$delQuery		= "DELETE FROM fm_market_category_link WHERE seq IN ({$inString})";
		$this->db->query($delQuery, $deleteSeqList);

		return true;

	}
	
	/* 기존 주문/클레임 삭제 */
	public function preShopInfoDelete($targetShop) {
		if($targetShop == 'shoplinker'){
			$ordersDelQuery		= "DELETE FROM fm_market_orders WHERE market != 'shoplinker'";
			$this->db->query($ordersDelQuery);
			
			$claimsDelQuery		= "DELETE FROM fm_market_claims WHERE market != 'shoplinker'";
			$this->db->query($claimsDelQuery);

			$qnaDelQuery		= "DELETE FROM fm_market_qna WHERE market != 'shoplinker'";
			$this->db->query($qnaDelQuery);
		}else{
			$orderDelQuery		= "DELETE FROM fm_market_orders WHERE market = 'shoplinker'";
			$this->db->query($orderDelQuery);
			
			$claimsDelQuery		= "DELETE FROM fm_market_claims WHERE market = 'shoplinker'";
			$this->db->query($claimsDelQuery);

			$qnaDelQuery		= "DELETE FROM fm_market_qna WHERE market = 'shoplinker'";
			$this->db->query($qnaDelQuery);
		}
	}


	/* 
		카테고리 매칭 정보 확인
		fmCategoryCode : 몰카테고리
		marketInfo : 마켓정보 array('market' => '', 'sellerId' => '')
	*/
	public function getMatchCategoryInfoByFm($fmCategoryCode, $marketInfo = false) {
		
		preg_match_all("/([0-9]{4})/", $fmCategoryCode, $splitCategoryCode);
		$categoryCodeArr	= array();
		$fmCategoryArr		= array();
		$categoryCodeAccrue	= '';

		foreach ($splitCategoryCode[1] as $nowCategoryCode) {
			$categoryCodeAccrue	.= $nowCategoryCode;
			$categoryCodeArr[]	= $categoryCodeAccrue;
			$fmCategoryArr[$categoryCodeAccrue]	= '';
		}
		
		if (count($categoryCodeArr) < 1)
			return false;

		$categoryIn		= implode("','", $categoryCodeArr);
		$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($categoryCodeArr))));
		
		$sql		= "SELECT category_code, title FROM fm_category WHERE {$addWhere} category_code IN ({$inString})";
		$result		= $this->db->query($sql, $categoryCodeArr);
		$category	= $result->result_array();
		
		$fmCategoryInfo	= array();
		foreach ($category as $nowFmCategory)
			$fmCategoryArr[$nowFmCategory['category_code']]	= $nowFmCategory['title'];
		
		$fmCategoryInfo['fmCategoryList']	= $fmCategoryArr;
		$fmCategoryInfo['fmCategoryCode']	= $fmCategoryCode;
		$fmCategoryInfo['fmCategoryName']	= implode(' > ', $fmCategoryArr);
		//$fmCategoryInfo['fmCategoryName']
	
		$marketWhere			= array();
		$marketWhereValue		= array();

		if(is_array($marketInfo) === true) {

			// 마켓 검색
			if (isset($marketInfo['market']) === true) {
				if($marketInfo['market'] === 'shoplinker'){
					$marketWhere[]		= "substr(market,1,3) = 'API'";
				}else{
					$marketWhere[]		= 'market = ?';
					$marketWhereValue[]	= $marketInfo['market'];
				}
			}
			
			// 셀러 검색
			if (isset($marketInfo['sellerId']) === true) {
				$marketWhere[]		= 'seller_id = ?';
				$marketWhereValue[]	= $marketInfo['sellerId'];
			}
		}

		$marketWhere[]			= 'fm_category_code = ?';
		$marketWhereValue[]		= $fmCategoryCode;
		$marketWhereText		= implode(' AND ', $marketWhere);
		
		$marketSql				= "SELECT * FROM fm_market_category_link WHERE {$marketWhereText}";
		
		$result					= $this->db->query($marketSql, $marketWhereValue);

		$marketCategory			= array();
		foreach($result->result_array() as $categoryInfo) {
			$nowCategory		= $categoryInfo;
			$categoryArr[]		= $nowCategory['dep1_category_name'];

			$categoryNameArr	= $this->_connectorBasic->makeMarketCategoryName($nowCategory);
			$nowCategory['full_category_name']	= implode(' > ', $categoryNameArr);

			$nowCategory['required_add_info']			= json_decode($nowCategory['required_add_info'], 1);
			$nowCategory['category_add_info']			= json_decode($nowCategory['category_add_info'], 1);
			$nowCategory['required_addInfo_summery']	= $this->makeRequiredAddInfoSummery($nowCategory['required_add_info']);

			$marketCategory[]	= $nowCategory;
		}


		$fmCategoryInfo['marketCategoryList']	= $marketCategory;

		return $fmCategoryInfo;
	}

	//이미 배포된 상품 리스트
	public function getAlreadyDistributedGoods($market, $sellerId, $goodsSeqList) {
		$updateCnt		= 50;
		$goodsSeqList	= array_values(array_unique($goodsSeqList));
		$arrayCount		= count($goodsSeqList);
		$maxPage		= ceil($arrayCount / $updateCnt);
		$endPoint		= 0;
		$alreadyList	= array();

		for ($i = 1; $i <= $maxPage; $i++) {
			$startPoint	= $endPoint;
			$endPoint	= $i * $updateCnt;
			$endPoint	= ($endPoint > $arrayCount) ? $arrayCount : $endPoint;
			$targetList	= array($market, $sellerId);

			for ($j = $startPoint; $j < $endPoint; $j++) {
				$nowGoodsSeq	= (int)$goodsSeqList[$j];
				if ($goodsSeqList[$j] < 1)
					continue;

				if ((int)$goodsSeqList[$j] > 0)
					$targetList[]	= (int)$goodsSeqList[$j];
			}
			$targetCnt		= count($targetList) - 2;
			if ($targetCnt < 1)
				continue;

			$inString		= str_replace(' ', ',', trim(str_repeat("? ", $targetCnt)));  
			$nowSelect		= "SELECT goods_seq FROM fm_market_product_info WHERE market=? AND seller_id=? AND goods_seq IN({$inString})";

			$query			= $this->db->query($nowSelect, $targetList);
			foreach ((array) $query->result_array() as $row) {
				$goodsSeq	= $row['goods_seq'];
				
				if (array_search($goodsSeq, $alreadyList) !== false)
					continue;
				
				$alreadyList[]	= $goodsSeq;
			}
		}

		return $alreadyList;
	}

	/*↑↑↑↑↑↑↑ 상품 추가정보 & 카테고리 매칭 ↑↑↑↑↑↑↑*/

	
	
	/*↓↓↓↓↓↓↓ 마켓 상품 관련 처리↓↓↓↓↓↓↓*/
	
	/* 마켓 상품 리스트 */
	public function getMarketProductList($params, $getInfoMode = 'basicList') {

		$whereArr		= array();
		$whereValueArr	= array();
		

		if (isset($params['fmGoodsSeq']) && trim($params['fmGoodsSeq']) != '') {
			$whereArr[]			= 'mp.goods_seq = ?';
			$whereValueArr[]	= $params['fmGoodsSeq'];
		}
		
		if(is_array($params['fmGoodsSeqArr']) && count($params['fmGoodsSeqArr']) > 0){
			$whereArr[]			= 'mp.goods_seq in ?';
			$whereValueArr[]	= $params['fmGoodsSeqArr'];
		}

		if (isset($params['marketProductCode']) && trim($params['marketProductCode']) != '') {
			$whereArr[]			= 'mp.market_product_code = ?';
			$whereValueArr[]	= $params['marketProductCode'];
		}
		
		if (isset($params['marketProductName']) && trim($params['marketProductName']) != '') {
			$whereArr[]			= 'mp.market_product_name like ?';
			$whereValueArr[]	= "%" .$params['marketProductName'] . "%";
		}

		if (isset($params['fmMarketProduceSeq']) && trim($params['fmMarketProduceSeq']) != '') {
			$whereArr[]			= 'mp.seq = ?';
			$whereValueArr[]	= $params['fmMarketProduceSeq'];
		}
		//연동 마켓
		if (isset($params['market']) && !empty($params['market'])) {
			if (is_array($params['market'])) {
				$marketList		= array_unique($params['market']);
				$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($marketList))));  
				$whereArr[]		= "mp.market IN ({$inString})";
				$whereValueArr	= array_merge($whereValueArr,$marketList);
			} else if (trim($params['market']) != '') {
				$whereArr[]			= "mp.market	= ?";
				$whereValueArr[]	= $params['market'];
			}
		}

		if (isset($params['sellerId']) && trim($params['sellerId']) != '') {
			$whereArr[]			= 'mp.seller_id = ?';
			$whereValueArr[]	= $params['sellerId'];
		}

		if (isset($params['manualMatched']) && trim($params['manualMatched']) != '') {
			$whereArr[]			= 'mp.manual_matched = ?';
			$whereValueArr[]	= $params['manualMatched'];
		}

		$dateFidle		= false;

		$beginDate		= false;
		$beginTime		= false;
		if (isset($params['searchBeginDate']) && trim($params['searchBeginDate']) != '') {
			$beginDate	= (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $params['searchBeginDate'])) ? "{$params['searchBeginDate']}" : false;
			$beginTime	= (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $params['searchBeginDate'])) ? "{$params['searchBeginDate']} 00:00:00" : false;
		}
		
		$endDate		= false;
		$endTime		= false;
		if (isset($params['searchEndDate']) && trim($params['searchEndDate']) != '') {
			$endDate	= (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $params['searchEndDate'])) ? "{$params['searchEndDate']}" : false;
			$endTime	= (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $params['searchEndDate'])) ? "{$params['searchEndDate']} 23:59:59" : false;
		}

		$orderByInfo	= "mp.seq DESC";
		if (isset($params['dateType']) && trim($params['dateType']) != '') {
			switch($params['dateType']) {
				
				case	'lastDistributedDate' :
					$dateFidle		= "mp.last_distributed_time";
					$orderByInfo	= "mp.last_distributed_time DESC, mp.seq DESC";
					$dateType		= "time";
					break;

				case	'registeredDate' :
					$dateFidle		= "mp.registered_time";
					$orderByInfo	= "mp.registered_time DESC, mp.seq DESC";
					$dateType		= "time";
					break;

				case	'marketCloseDate' :
					$dateFidle		= "mp.market_close_date";
					$orderByInfo	= "mp.market_close_date DESC, mp.seq DESC";
					$dateType		= "date";
					break;
			}
		}
		

		if ($dateFidle !== false) {
			if($beginDate !== false) {
				$whereArr[]			= "{$dateFidle}  >= ?";
				$whereValueArr[]	= ($dateType == 'date') ? $beginDate : $beginTime;
			}

			if($endDate !== false) {
				$whereArr[]			= "{$dateFidle}  <= ?";
				$whereValueArr[]	= ($dateType == 'date') ? $endDate : $endTime;
			}
		}


		// 판매상태
		if(isset($params['marketSaleStatus'])) {
			if (is_array($params['marketSaleStatus'])) {
				$uniqueList		= array_unique($params['marketSaleStatus']);
				$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($uniqueList))));
				$whereArr[]		= "mp.market_sale_status IN ({$inString})";
				$whereValueArr	= array_merge($whereValueArr,$uniqueList);
			} else if(trim($params['marketSaleStatus']) != '') {
				$whereArr[]			= "mp.market_sale_status  = ?";
				$whereValueArr[]	= $params['marketSaleStatus'];
			}
		}

		
		// 최종 수정 성공여부
		if(isset($params['lastResult']) && ($params['lastResult'] == 'Y' || $params['lastResult'] == 'N')) {
			$whereArr[]			= 'mp.last_result = ?';
			$whereValueArr[]	= $params['lastResult'];
		}

		// 솔루션 상품 삭제 여부
		if(isset($params['market_product_status'])) {
			if($params['market_product_status']=="D"){
				$whereArr[]			= 'NOT EXISTS (SELECT 1 FROM fm_goods g WHERE g.goods_seq = mp.goods_seq)';
			}else{
				$whereArr[]			= 'EXISTS (SELECT 1 FROM fm_goods g WHERE g.goods_seq = mp.goods_seq)';
			}
			
		}
		
		// 삭제 정보 포함 검색
		if($params['search_market_product_status']=='ALL'){
		}elseif($params['search_market_product_status']){	// 특정 상태 검색
			$whereArr[]			= "market_product_status == '".$params['search_market_product_status']."'";
		}else{ // 연동 삭제 정보는 노출 안 함
			$whereArr[]			= "market_product_status != 'D'";
		}

		$addSqlFunc		= '';
		$joinInfoArr	= array();
		$addFieldsArr	= array();

		switch ($getInfoMode) {
			case	'forViewList' :
				$addSqlFunc		= 'SQL_CALC_FOUND_ROWS';
				$addFieldsArr[]	= "IFNULL((SELECT '1' FROM fm_goods g WHERE g.goods_seq = mp.goods_seq),'D') AS delete_goods_seq";
				break;

			case	'fullInfo' :
				$joinInfoArr[]	= "INNER JOIN fm_market_product_detail AS md";
				$joinInfoArr[]	= "ON mp.seq = md.fm_market_product_seq";
				$addFieldsArr[]	= "md.category_info			AS category_info";
				$addFieldsArr[]	= "md.market_product_info	AS market_product_info";
				$addFieldsArr[]	= "md.market_add_info		AS market_add_info";
				break;
		}

		$limit		= '';
		if (isset($params['limit'])) {
			$limitStart	= ($params['page'] - 1) * $params['limit'];
			$limit		= "LIMIT {$limitStart}, {$params['limit']}";
		}
		
		$joinInfo		= '';
		if (count($joinInfoArr) > 0)
			$joinInfo	= implode("\n", $joinInfoArr);

		$addFields		= '';
		if (count($addFieldsArr) > 0)
			$addFields	= ', '.implode(",\n", $addFieldsArr);
		

		$where				= '';
		if (count($whereArr) > 0)
			$where		= 'WHERE '.implode(' AND ', $whereArr);

	

		$listSql	= "
			SELECT	  {$addSqlFunc}
					  mp.seq					AS fm_market_product_seq
					, mp.goods_seq				AS goods_seq
					, mp.add_info_seq			AS add_info_seq
					, mp.market					AS market
					, mp.seller_id				AS seller_id
					, mp.market_product_code	AS market_product_code
					, mp.confirmed_product_code	AS confirmed_product_code
					, mp.market_product_name	AS market_product_name
					, mp.market_sale_status		AS market_sale_status
					, mp.market_begin_date		AS market_begin_date
					, mp.market_close_date		AS market_close_date
					, mp.last_result			AS last_result
					, mp.manual_matched			AS manual_matched
					, mp.registered_time		AS registered_time
					, mp.last_distributed_time	AS last_distributed_time
					, mp.dist_category_type		AS dist_category_type
					, mp.market_product_status	AS market_product_status
					{$addFields}
			FROM	fm_market_product_info		AS mp
				{$joinInfo}
			{$where}
			ORDER BY
				{$orderByInfo}
			{$limit}
			";
		
		$query				= $this->db->query($listSql, $whereValueArr);
		$marketProductList	= $query->result_array();
		

		switch ($getInfoMode) {
			case	'forViewList' :
				
				$query			= $this->db->query("SELECT FOUND_ROWS() AS count");
				$countInfo		= $query->row_array();

				$return['totalCount']			= $countInfo['count'];
				$return['marketProductList']	= $marketProductList;
				break;
			
			case	'fullInfo' :
				$fullInfoList	= array();
				foreach((array) $marketProductList as $row) {
					$categoryInfo		= json_decode($row['category_info'], 1);
					$marketProductInfo	= json_decode($row['market_product_info'], 1);
					$marketAddInfo		= json_decode($row['market_add_info'], 1);
					
					unset($row['category_info']);
					unset($row['market_product_info']);
					unset($row['market_add_info']);

					$row['category_info']		= $categoryInfo;
					$row['market_product_info']	= $marketProductInfo;
					$row['market_add_info']		= $marketAddInfo;

					$fullInfoList[]				= $row;
				}

				$return		= $fullInfoList;
				break;

			default :
				$return		= $marketProductList;

		}

		return $return;
	}

	/* 상품배포 리스트 */
	public function getDistributeList($params, $widthTotalCount) {

		$whereArr				= array();
		$whereValueArr			= array();

		if (isset($params['market']) && trim($params['market']) != '') {
			$whereArr[]			= 'addinfo.market = ?';
			$whereValueArr[]	= $params['market'];
		}

		if (isset($params['sellerId']) && trim($params['sellerId']) != '') {
			$whereArr[]			= 'addinfo.seller_id = ?';
			$whereValueArr[]	= $params['sellerId'];
		}


		$where				= '';
		if (count($whereArr) > 0)
			$where		= 'WHERE '.implode(' AND ', $whereArr);

		$limit		= '';
		if (isset($params['limit'])) {
			$limitStart	= ($params['page'] - 1) * $params['limit'];
			$limit		= "LIMIT {$limitStart}, {$params['limit']}";
		}

		$listSql	= "
			SELECT	dist.seq					AS dist_seq
				,	addinfo.seq					AS add_info_seq
				,	goods.goods_seq				AS goods_seq
				,	addinfo.market				AS market_code
				,	addinfo.seller_id			AS seller_id
				,	goods.goods_name			AS goods_name
				,	image.image					AS image
				,	addinfo.add_info_title		AS add_info_title
				,	addinfo.dep1_category_name	AS dep1_category_name
				,	addinfo.dep2_category_name	AS dep2_category_name
				,	addinfo.dep3_category_name	AS dep3_category_name
				,	addinfo.dep4_category_name	AS dep4_category_name
				,	addinfo.dep5_category_name	AS dep5_category_name
				,	addinfo.dep6_category_name	AS dep6_category_name
				,	dist.dist_category_type		AS dist_category_type
				,	dist.fail_yn				AS dist_fail_yn
				,	dist.fail_message			AS dist_fail_message

			FROM		fm_market_dist_standby	AS dist 
			INNER JOIN	fm_goods				AS goods 
				ON dist.goods_seq = goods.goods_seq

			LEFT JOIN	fm_goods_image			AS image
				ON	dist.goods_seq = image.goods_seq
					AND image.cut_number = '1'
					AND image.image_type = 'thumbCart'

			INNER JOIN	fm_market_add_info		AS addinfo 
				ON	dist.add_info_seq = addinfo.seq
			{$where}
			ORDER BY
				dist.seq	DESC
			{$limit}";

		$query		= $this->db->query($listSql, $whereValueArr);

		if ($widthTotalCount == true) {
			$countSql		= "
				SELECT COUNT(*) AS total_count
				FROM		fm_market_dist_standby	AS dist 
				INNER JOIN	fm_goods				AS goods 
					ON dist.goods_seq = goods.goods_seq
				INNER JOIN	fm_market_add_info		AS addinfo 
					ON	dist.add_info_seq = addinfo.seq
				{$where}";

			$countQuery		= $this->db->query($countSql, $whereValueArr);
			$countResult	= $countQuery->result();
			$return['totalCount']	= $countResult[0]->total_count;
		} else {
			$return['totalCount']	= $params['totalCount'];
		}

		$return[resultList]			= $query->result_array();

		return $return;
	}
	
	/* 배포상품 상세정보 */
	public function getDistributeDetail($idx) {

		$listSql	= "
			SELECT	dist.seq					AS dist_seq
				,	dist.goods_seq				AS goods_seq
				,	dist.dist_category_type		AS dist_category_type
				,	addinfo.seq					AS add_info_seq
				,	addinfo.market				AS market
				,	addinfo.seller_id			AS seller_id
				,	addinfo.add_info_title		AS add_info_title
				,	addinfo.category_code		AS category_code
				,	addinfo.dep1_category_name	AS dep1_category_name
				,	addinfo.dep2_category_name	AS dep2_category_name
				,	addinfo.dep3_category_name	AS dep3_category_name
				,	addinfo.dep4_category_name	AS dep4_category_name
				,	addinfo.dep5_category_name	AS dep5_category_name
				,	addinfo.dep6_category_name	AS dep6_category_name
				,	addinfo.dep1_category_code	AS dep1_category_code
				,	addinfo.dep2_category_code	AS dep2_category_code
				,	addinfo.dep3_category_code	AS dep3_category_code
				,	addinfo.dep4_category_code	AS dep4_category_code
				,	addinfo.dep5_category_code	AS dep5_category_code
				,	addinfo.dep6_category_code	AS dep6_category_code
				,	addinfo.add_info_detail		AS add_info_detail
			FROM		fm_market_dist_standby	AS dist 
			inner join	fm_market_add_info		AS addinfo 
				on	dist.add_info_seq = addinfo.seq
			WHERE
				dist.seq	= ?";

		$query		= $this->db->query($listSql,array($idx));
		$distInfo	= $query->row_array();
		$distInfo['add_info_detail']	= json_decode($distInfo['add_info_detail'], 1);
		return $distInfo;
	}


	/* 마켓 상품 기본정보 업데이트 */
	public function updateMarketProductInfo($fmMarketProductSeq, $params) {
		$setData	= filter_keys($params, $this->db->list_fields('fm_market_product_info'));
		$result		= $this->db->update('fm_market_product_info', $setData, array('seq'=>$fmMarketProductSeq));
	}
	
	/* 마켓 상품전송 로그 리스트 */
	public function getMarketProductLog($fmMarketProduceSeq) {
		$query		= $this->db->query("SELECT * FROM fm_market_product_log WHERE fm_market_product_seq = ? ORDER BY seq DESC", array($fmMarketProduceSeq));
		$productLog	= $query->result_array();
		return $productLog;
	}

	/* 퍼스트몰 상품정보 */
	public function getGoodsInfoByGoodsSeq($goodsSeq) {
		$this->load->model('goodsmodel');
		$this->load->model('providermodel');

		$defaultOption					= $this->goodsmodel->get_goods_default_option($goodsSeq);
		$returnInfo['goodsInfo']		= $this->goodsmodel->get_goods($goodsSeq);
		$returnInfo['goodsAddition']	= $this->goodsmodel->get_goods_addition($goodsSeq);
		$returnInfo['goodsImage']		= $this->goodsmodel->get_goods_image($goodsSeq);
		$returnInfo['defaultOption']	= $defaultOption[0];

		return $returnInfo;	
	}

	/*↑↑↑↑↑↑↑ 마켓 상품 관련 처리 ↑↑↑↑↑↑↑*/


	/*↓↓↓↓↓↓↓ 마켓 주문 관련 처리 ↓↓↓↓↓↓↓*/
	
	/* 마켓 주문 리스트 */
	public function getMarketOrderList($params, $getInfoMode = 'withGoodsBasic', $withOtherInfo = false) {

		$whereArr		= array();
		$whereValueArr	= array();

		if (isset($params['seqList'])) {
			if (is_array($params['seqList'])) {
				$uniqueList		= array_unique($params['seqList']);
				$seqList		= implode("','", $uniqueList);
				$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($uniqueList))));  
				$whereArr[]		= "mo.seq IN ({$inString})";
				$whereValueArr	= $uniqueList;
			} else {
				$whereArr[]			= "mo.seq  = ?";
				$whereValueArr[]	= $params['seqList'];
			}
		}

		//퍼스트몰 주문번호
		if (isset($params['fmOrderSeq']) && trim($params['fmOrderSeq']) != '') {
			$whereArr[]			= "mo.fm_order_seq	= ?";
			$whereValueArr[]	= $params['fmOrderSeq'];
		}

		//마켓 주문번호
		if (isset($params['marketOrderNo']) && trim($params['marketOrderNo']) != '') {
			$whereArr[]			= "mo.market_order_no	= ?";
			$whereValueArr[]	= $params['marketOrderNo'];
		}

		//마켓 주문순번
		if (isset($params['marketOrderSeq']) && trim($params['marketOrderSeq']) != '') {
			$whereArr[]			= "mo.market_order_seq	= ?";
			$whereValueArr[]	= $params['marketOrderSeq'];
		}

		//연동 마켓
		if (isset($params['market'])) {
			if (is_array($params['market'])) {
				$marketList		= array_unique($params['market']);
				if ( count($marketList) > 0 ) {
					$listSeq		= implode("','", $marketList);
					$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($marketList))));  
					$whereArr[]		= "mo.market IN ({$inString})";
					$whereValueArr	= array_merge($whereValueArr,$marketList);
				} else {
					$whereArr[]		= "mo.market = ''";
				}
			} else if (trim($params['market']) != '') {
				$whereArr[]			= "mo.market	= ?";
				$whereValueArr[]	= $params['market'];
			}
		}


		//연동 아이디
		if (isset($params['sellerId']) && trim($params['sellerId']) != '') {
			$whereArr[]			= "mo.seller_id	= ?";
			$whereValueArr[]	= $params['sellerId'];
		}


		if($params['hasFmOrderSeq'] == 'Y') {
			$whereArr[]			= "mo.fm_order_seq  > ?";
			$whereValueArr[]	= 0;
		} else if($params['hasFmOrderSeq'] == 'N') {
			$whereArr[]			= "mo.fm_order_seq  = ?";
			$whereValueArr[]	= 0;
			// 주문수량 - 결제취소수량이 1개 이상일때만 주문등록가능 카운트 되도록 수정 2019-06-04 by hyem
			if($params['hasCanceled'] == "N") {
				$whereArr[]		= "mo.order_qty - mo.order_cancel_qty > 0";
			}
		}

		//상태
		if (isset($params['status'])){
			if (is_array($params['status'])) {
				$uniqueList		= array_unique($params['status']);
				$listSeq		= implode("','", $uniqueList);
				$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($uniqueList))));  
				$whereArr[]		= "mo.market_order_status IN ({$inString})";
				$whereValueArr	= array_merge($whereValueArr,$uniqueList);
			} else if(trim($params['status']) != ''){
				$whereArr[]		= "mo.market_order_status  = ?";
				$whereValueArr[]= $params['status'];
			}
		}

		$dateFidle		= false;
		$orderByInfo	= "mo.market_order_no DESC, mo.market_order_seq";
		
		if (isset($params['dateType']) === true) {

			switch($params['dateType']) {
				
				case	'registeredTime' :
					$dateFidle		= "mo.registered_time";
					$orderByInfo	= "mo.seq DESC";
					break;

				case	'fmOrderSaveTime' :
					$dateFidle		= "mo.fm_order_save_time";
					$orderByInfo	= "mo.fm_order_save_time DESC";
					break;

				case	'settleTime' :
					$dateFidle		= "mo.settle_time";
					$orderByInfo	= "mo.settle_time DESC";
					break;
				
				default :
					$orderByInfo	= "mo.seq DESC";
			}

		}

		$beginDate	= (isset($params['searchBeginDate']) && $params['searchBeginDate']) ? "{$params['searchBeginDate']} 00:00:00" : false;
		$endDate	= (isset($params['searchEndDate']) && $params['searchEndDate']) ? "{$params['searchEndDate']} 23:59:59" : false;

		if ($dateFidle !== false) {
			if($beginDate !== false) {
				$whereArr[]			= "{$dateFidle}  >= ?";
				$whereValueArr[]	= $beginDate;
			}

			if($endDate !== false) {
				$whereArr[]			= "{$dateFidle}  <= ?";
				$whereValueArr[]	= $endDate;
			}
		}
		
		//샵링커 주문번호
		if (isset($params['openmarketOrderId']) && trim($params['openmarketOrderId']) != '') {
		    $whereArr[]			= "IF(mo.openmarket_order_id IS NULL OR mo.openmarket_order_id = '', '{$params['openmarketOrderId']}', mo.openmarket_order_id) = '{$params['openmarketOrderId']}'";
		}
	
		$joinInfoArr		= array();
		$joinFieldsArr		= array();
		$groupInfoArr		= array();
		$joinInfo			= '';
		$addFields			= '';
		$groupInfo			= '';

		$goodsJoinInfo		= array();
		$goodsJoinInfo[]	= "LEFT JOIN fm_market_product_info AS mp";
		$goodsJoinInfo[]	= "ON mo.market = mp.market AND mo.seller_id = mp.seller_id AND mo.market_product_code = mp.market_product_code";
		$goodsJoinInfo[]	= "LEFT JOIN fm_goods AS fp";
		$goodsJoinInfo[]	= "ON mp.goods_seq = fp.goods_seq";
		
		$goodsAddFields		= array();
		$goodsAddFields[]	= 'mp.goods_seq			AS fm_goods_seq';
		$goodsAddFields[]	= 'mp.manual_matched	AS manual_matched';
		$goodsAddFields[]	= 'fp.goods_seq			AS goods_seq';
		$goodsAddFields[]	= 'fp.goods_name		AS fm_goods_name';
		$goodsAddFields[]	= 'fp.adult_goods		AS adult_goods';
		$goodsAddFields[]	= 'fp.goods_type		AS goods_type';
		$goodsAddFields[]	= 'fp.tax				AS tax';
		$goodsAddFields[]	= 'fp.provider_seq		AS provider_seq';
		
		if($params['market'][0] == 'shoplinker'){
			$goodsAddFields[]	= 'mo.other_info				AS other_info';
		}
		
		

		switch($getInfoMode) {
			case	'forViewList' :
			case	'withGoodsBasic' :
				$joinInfoArr	= $goodsJoinInfo;
				$addFieldsArr	= $goodsAddFields;
				break;

			case	'withGoodsFull' :
				$joinInfoArr	= $goodsJoinInfo;
				$addFieldsArr	= $goodsAddFields;

				$joinInfoArr[]	= "LEFT JOIN fm_goods_image	AS image";
				$joinInfoArr[]	= "ON	mp.goods_seq = image.goods_seq AND image.cut_number = '1' AND image.image_type = 'thumbCart'";
				$addFieldsArr[]	= 'image.image	AS fm_goods_image';
				
				$addFieldsArr[]	= 'fp.goods_code				AS fm_goods_code';
				$addFieldsArr[]	= 'fp.package_yn				AS package_yn';
				$addFieldsArr[]	= 'fp.purchase_goods_name		AS purchase_goods_name';
				$addFieldsArr[]	= 'fp.individual_refund			AS individual_refund';
				$addFieldsArr[]	= 'fp.individual_refund_inherit	AS individual_refund_inherit';
				$addFieldsArr[]	= 'fp.individual_export			AS individual_export';
				$addFieldsArr[]	= 'fp.individual_return			AS individual_return';
				$addFieldsArr[]	= 'fp.shipping_policy			AS shipping_policy';
				$addFieldsArr[]	= 'fp.shipping_group_seq		AS shipping_group_seq';
				$addFieldsArr[]	= 'fp.goods_shipping_policy		AS goods_shipping_policy';
				$addFieldsArr[]	= 'fp.limit_shipping_ea			AS limit_shipping_ea';
				$addFieldsArr[]	= 'fp.limit_shipping_price		AS limit_shipping_price';
				$addFieldsArr[]	= 'fp.limit_shipping_subprice	AS limit_shipping_subprice';
				
				if($params['market'][0] != 'shoplinker'){
					$addFieldsArr[]	= 'mo.other_info				AS other_info';
				}
				
				$orderByInfo	= "mo.market_order_no DESC, mo.add_product_yn DESC, mo.shipping_cost ASC";
				break;
	
			case	'delivery' :
				$joinInfoArr	= $goodsJoinInfo;
				$groupInfoArr[]	= 'mo.market_order_no';
				$groupInfoArr[]	= 'mo.market_delivery_no';
				
				$addFieldsArr[]	= 'count(*)								AS has_item_count';
				$addFieldsArr[]	= 'sum(mo.order_amount)					AS sum_order_amount';
				$addFieldsArr[]	= 'sum(mo.paid_amount)					AS sum_paid_amount';
				$addFieldsArr[]	= 'sum(mo.shipping_cost)				AS sum_shipping_cost';
				$addFieldsArr[]	= 'max(mo.shipping_cost)				AS max_shipping_cost';
				$addFieldsArr[]	= 'GROUP_CONCAT(fp.shipping_group_seq)	AS shipping_group_seq_list';
				$addFieldsArr[]	= 'GROUP_CONCAT(fp.provider_seq)		AS provider_seq_list';
				$addFieldsArr[]	= 'GROUP_CONCAT(fp.trust_shipping)		AS trust_shipping_list';
				$addFieldsArr[]	= 'GROUP_CONCAT(mo.market_product_code)	AS market_product_list';
				$addFieldsArr[]	= 'GROUP_CONCAT(mo.seq)					AS seq_list';
				$addFieldsArr[]	= 'GROUP_CONCAT(mo.shipping_cost)		AS shipping_cost_list';
				$addFieldsArr[]	= 'GROUP_CONCAT(mo.extra_shipping_cost)	AS extra_shipping_cost_list';
				$addFieldsArr[]	= 'GROUP_CONCAT(mo.shipping_type)		AS shipping_type_list';
				
				if($params['market'][0] != 'shoplinker'){
					$addFieldsArr[]	= 'mo.other_info				AS other_info';
				}
				break;

			case	'fmItemList' :
				$addFieldsArr[]	= 'mo.fm_item_seq				AS fm_item_seq';
				$addFieldsArr[]	= 'mo.fm_item_option_seq		AS fm_item_option_seq';
				$addFieldsArr[]	= 'mo.fm_item_suboption_seq		AS fm_item_suboption_seq';
				$addFieldsArr[]	= 'mo.add_product_yn			AS add_product_yn';
				if($params['market'][0] != 'shoplinker'){
					$addFieldsArr[]	= 'mo.other_info				AS other_info';
				}
				break;

			case	'onlyOrder' :
				$addFieldsArr[]	= 'mo.fm_item_seq				AS fm_item_seq';
				$addFieldsArr[]	= 'mo.fm_item_option_seq		AS fm_item_option_seq';
				$addFieldsArr[]	= 'mo.fm_item_suboption_seq		AS fm_item_suboption_seq';
				$addFieldsArr[]	= 'mo.add_product_yn			AS add_product_yn';
				$addFieldsArr[]	= 'oi.provider_seq				AS provider_seq';

				$joinInfoArr[]	= 'INNER JOIN fm_order_item oi';
				$joinInfoArr[]	= 'ON mo.fm_item_seq = oi.item_seq';
				break;

			case	'onlyMarketOrder' :
				break;

		}

		if ($withOtherInfo == true)
			$addFieldsArr[]	= 'mo.other_info	AS other_info';

		if (count($joinInfoArr) > 0)
			$joinInfo	= implode("\n", $joinInfoArr);

		if (count($addFieldsArr) > 0)
			$addFields	= ', '.implode(",\n", $addFieldsArr);

		if (count($groupInfoArr) > 0)
			$groupInfo	= 'GROUP BY '.implode(", ", $groupInfoArr);
		

		$where				= '';
		if (count($whereArr) > 0)
			$where		= 'WHERE '.implode(' AND ', $whereArr);

		
		$limit		= '';
		if (isset($params['limit'])) {
			$limitStart	= ($params['page'] - 1) * $params['limit'];
			$limit		= "LIMIT {$limitStart}, {$params['limit']}";
		}

		$listSql	= "
			SELECT	  mo.seq						AS seq
					, mo.fm_order_seq				AS fm_order_seq
					, mo.market						AS market
					, mo.seller_id					AS seller_id
					, mo.market_order_no			AS market_order_no
					, mo.market_order_seq			AS market_order_seq
					, mo.market_delivery_no			AS market_delivery_no
					, mo.invoice_num				AS invoice_num
					, mo.bundle_shipping_yn			AS bundle_shipping_yn
					, mo.bundle_shipping_no			AS bundle_shipping_no
					, mo.seller_product_code		AS seller_product_code
					, mo.market_product_code		AS market_product_code
					, mo.order_product_name			AS order_product_name
					, mo.market_option_code			AS market_option_code
					, mo.order_option_name			AS order_option_name
					, mo.matched_option_name		AS matched_option_name
					, mo.add_product_yn				AS add_product_yn
					, mo.add_product_code			AS add_product_code
					, mo.market_order_status		AS market_order_status
					, mo.order_qty					AS order_qty
					, mo.order_cancel_qty			AS order_cancel_qty
					, mo.order_product_price		AS order_product_price
					, mo.order_amount				AS order_amount
					, mo.paid_amount				AS paid_amount
					, mo.global_shipping_yn			AS global_shipping_yn
					, mo.shipping_method			AS shipping_method
					, mo.shipping_type				AS shipping_type
					, mo.shipping_cost				AS shipping_cost
					, mo.extra_shipping_cost		AS extra_shipping_cost
					, mo.delivery_message			AS delivery_message
					, mo.orderer_name				AS orderer_name
					, mo.orderer_zipcode			AS orderer_zipcode
					, mo.orderer_address			AS orderer_address
					, mo.orderer_address_detail		AS orderer_address_detail
					, mo.orderer_cellphone			AS orderer_cellphone
					, mo.orderer_tel				AS orderer_tel
					, mo.recipient_name				AS recipient_name
					, mo.recipient_zipcode			AS recipient_zipcode
					, mo.recipient_address			AS recipient_address
					, mo.recipient_address_detail	AS recipient_address_detail
					, mo.recipient_cellphone		AS recipient_cellphone
					, mo.recipient_tel				AS recipient_tel
					, mo.order_time					AS order_time
					, mo.settle_time				AS settle_time
					, mo.last_message				AS last_message
					{$addFields}
			FROM	fm_market_orders				AS mo
				{$joinInfo}
			{$where}
			{$groupInfo}
			ORDER BY
				{$orderByInfo}
			{$limit}";
				

		$query			= $this->db->query($listSql, $whereValueArr);
		$orderList		= $query->result_array();
		switch ($getInfoMode) {
			case	'forViewList' :				
				
				if ($params['withTotalCount'] == true) {
					$countSql		= "SELECT COUNT(*) AS total_count FROM	fm_market_orders AS mo {$joinInfo} {$where} {$groupInfo}";
					$countQuery		= $this->db->query($countSql, $whereValueArr);
					$countResult	= $countQuery->result();
					$return['totalCount']	= $countResult[0]->total_count;
				} else {
					$return['totalCount']	= $params['totalCount'];
				}
				
				
				$return['resultList']		= $orderList;

				return $return;
				break;
			case	'fmItemList' :
				$itemList		= array();
				$orderInfo		= array();
				foreach((array) $orderList as $row) {
					if (isset($orderInfo['market']) !== true) {
						$orderInfo['market']			= $row['market'];
						$orderInfo['seller_id']			= $row['seller_id'];
						$orderInfo['market_order_no']	= $row['market_order_no'];
						$orderInfo['market_delivery_no']	= $row['market_delivery_no'];
					}
					$itemList[$row['fm_item_seq']][$row['fm_item_option_seq']][$row['fm_item_suboption_seq']]		= $row;
				}
				
				$return['orderInfo']	= $orderInfo;
				
				$return['itemList']		= $itemList;

				return $return;
				break;
				
			default :
				return $orderList;

		}
	}
	
	/* 마켓 주문인지 확인 */
	public function checkIsMarketOrder($fmOrderSeq) {

		$orderSql	= "SELECT linkage_id, linkage_mall_code FROM fm_order WHERE order_seq = '{$fmOrderSeq}'";
		$result		= $this->db->query($orderSql);
		$orderInfo	= $result->row_array();

		if ($orderInfo['linkage_id'] == 'connector')
			return $orderInfo;
		else
			return false;
	}
	
	/*↑↑↑↑↑↑↑ 마켓 주문 관련 처리 ↑↑↑↑↑↑↑*/


	/*↓↓↓↓↓↓↓ 마켓 클레임 관련 처리 ↓↓↓↓↓↓↓*/
	
	/* 마켓 클레임 리스트 */
	public function getMarketClaimList($params, $getInfoMode = 'withMarketOrder', $rawInfo = false) {

		$whereArr		= array();
		$whereValueArr	= array();

		if (isset($params['listSeq'])) {
			if (is_array($params['listSeq'])) {
				$uniqueList		= array_unique($params['listSeq']);
				$listSeq		= implode("','", $uniqueList);
				$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($uniqueList))));  
				$whereArr[]		= "mc.seq IN ({$inString})";
				$whereValueArr	= $uniqueList;
			} else {
				$whereArr[]			= "mc.seq  = ?";
				$whereValueArr[]	= $params['listSeq'];
			}
		}
			
		//클레임 타입
		if (isset($params['claimType']) && trim($params['claimType']) != '') {
			$whereArr[]			= "mc.claim_type  = ?";
			$whereValueArr[]	= $params['claimType'];
		}

		//마켓 주문번호
		if (isset($params['marketOrderNo']) && trim($params['marketOrderNo']) != '') {
			$whereArr[]			= "mc.market_order_no  = ?";
			$whereValueArr[]	= $params['marketOrderNo'];
		}
		
		//마켓 주문순번
		if (isset($params['marketOrderSeq']) && trim($params['marketOrderSeq']) != '') {
			$whereArr[]			= "mc.market_order_seq  = ?";
			$whereValueArr[]	= $params['marketOrderSeq'];
		}
		
		//퍼스트몰 클레임코드
		if (isset($params['fmClaimCode']) && trim($params['fmClaimCode']) != '') {
			$whereArr[]			= "mc.fm_claim_code  = ?";
			$whereValueArr[]	= $params['fmClaimCode'];
		}

		//마켓 클레임코드
		if (isset($params['marketClaimCode']) && trim($params['marketClaimCode']) != '') {
			$whereArr[]			= "mc.market_claim_code  = ?";
			$whereValueArr[]	= $params['marketClaimCode'];
		}
		
		
		//연동 마켓
		if (isset($params['market'])) {
			if (is_array($params['market'])) {
				$marketList		= array_unique($params['market']);
				if ( count($marketList) > 0 ) {
					$listSeq		= implode("','", $marketList);
					$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($marketList))));  
					$whereArr[]		= "mc.market IN ({$inString})";
					$whereValueArr	= array_merge($whereValueArr,$marketList);
				} else {
					$whereArr[]		= "mc.market = ''";
				}
			} else if (trim($params['market']) != '') {
				$whereArr[]			= "mc.market	= ?";
				$whereValueArr[]	= $params['market'];
			}
		}

		//연동 아이디
		if (isset($params['sellerId']) && trim($params['sellerId']) != '') {
			$whereArr[]			= "mc.seller_id	= ?";
			$whereValueArr[]	= $params['sellerId'];
		}


		//상태
		if (isset($params['status'])){
			if (is_array($params['status'])) {
				$uniqueList		= array_unique($params['status']);
				$listSeq		= implode("','", $uniqueList);
				$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($uniqueList))));  
				$whereArr[]		= "mc.claim_status IN ({$inString})";
				$whereValueArr	= array_merge($whereValueArr,$uniqueList);
			} else if (trim($params['status']) != '') {
				$whereArr[]			= "mc.claim_status  = ?";
				$whereValueArr[]	= $params['status'];
			}
		}


		// 클레임 등록 여부
		if($params['hasFmClaimCode'] == 'Y') {
			$whereArr[]			= "mc.fm_claim_code  != ''";
		} else if($params['hasFmClaimCode'] == 'N') {
			$whereArr[]			= "mc.fm_claim_code = ''";
		}
		// 퍼스트몰 주문으로 등록 여부
		if (isset($params['is_fm_order'])){
			$whereArr[]			= "mc.is_fm_order  = ?";
			$whereValueArr[]	= $params['is_fm_order'];
		}

		//날짜검색
		$dateFidle			= false;
		$orderByInfo		= "mc.seq DESC";
		if (isset($params['dateType']) == true) {
			switch($params['dateType']) {
				case	'registeredTime' :
					$dateFidle		= "mc.registered_time";
					$orderByInfo		= "mc.seq DESC";
					break;
			}
		}
		
		$beginDate	= (isset($params['searchBeginDate']) && $params['searchBeginDate']) ? "{$params['searchBeginDate']} 00:00:00" : false;
		$endDate	= (isset($params['searchEndDate']) && $params['searchEndDate']) ? "{$params['searchEndDate']} 23:59:59" : false;

		if ($dateFidle !== false) {
			if($beginDate !== false) {
				$whereArr[]			= "{$dateFidle}  >= ?";
				$whereValueArr[]	= $beginDate;
			}

			if($endDate !== false) {
				$whereArr[]			= "{$dateFidle}  <= ?";
				$whereValueArr[]	= $endDate;
			}
		}

	
		if ($withOtherInfo == true)
			$addFieldsArr[]	= 'mo.other_info	AS other_info';
		
		
		$orderJoinInfo		= array();
		$orderJoinInfo[]	= "LEFT JOIN fm_market_orders AS mo";
		$orderJoinInfo[]	= "ON mc.fm_market_order_seq = mo.seq";


		$goodsJoinInfo		= array();
		$goodsJoinInfo[]	= "LEFT JOIN fm_market_product_info AS mp";
		$goodsJoinInfo[]	= "ON mc.market = mp.market AND mc.seller_id = mp.seller_id AND mo.market_product_code = mp.market_product_code";

		$fmGoodsJoinInfo[]	= "LEFT JOIN fm_goods AS fp";
		$fmGoodsJoinInfo[]	= "ON mp.goods_seq = fp.goods_seq";
		
		

		switch($getInfoMode) {
			case	'forViewList' :
			case	'withMarketOrder' :
				$joinInfoArr	= array_merge($orderJoinInfo, $goodsJoinInfo);
				$addFieldsArr	= $goodsAddFields;
				$addFieldsArr[]	= "mp.goods_seq				AS fm_goods_seq";
				$addFieldsArr[]	= "mo.fm_order_seq			AS fm_order_seq";
				$addFieldsArr[]	= "mo.order_product_name	AS order_product_name";
				$addFieldsArr[]	= "mo.order_option_name		AS order_option_name";
				$addFieldsArr[]	= "mo.add_product_yn		AS add_product_yn";
				$addFieldsArr[]	= 'mo.market_product_code	AS market_product_code';
				$addFieldsArr[]	= 'UNIX_TIMESTAMP(mc.registered_time)	AS registered_timestamp';
				$addFieldsArr[]	= 'UNIX_TIMESTAMP(mc.claim_close_time)	AS claim_close_timestamp';
				
				break;

			case	'forRegisterClaim' :
				$joinInfoArr	= array_merge($orderJoinInfo, $goodsJoinInfo);
				$addFieldsArr[]	= 'mc.seq					AS fm_market_claim_seq';
				$addFieldsArr[]	= 'UNIX_TIMESTAMP(mc.registered_time)	AS registered_timestamp';
				$addFieldsArr[]	= 'UNIX_TIMESTAMP(mc.claim_close_time)	AS claim_close_timestamp';

				$addFieldsArr[]	= 'mo.fm_order_seq			AS fm_order_seq';
				$addFieldsArr[]	= 'mo.market_order_no		AS market_order_no';
				$addFieldsArr[]	= 'mo.fm_item_seq			AS fm_item_seq';
				$addFieldsArr[]	= 'mo.fm_item_option_seq	AS fm_item_option_seq';
				$addFieldsArr[]	= 'mo.fm_item_suboption_seq	AS fm_item_suboption_seq';
				$addFieldsArr[]	= 'mo.market_order_status	AS market_order_status';
				$addFieldsArr[]	= 'mo.market_product_code	AS market_product_code';
				$addFieldsArr[]	= 'mo.order_amount			AS order_amount';
				$addFieldsArr[]	= 'mo.order_qty				AS order_qty';
				$addFieldsArr[]	= 'mo.invoice_num			AS invoice_num';
				$addFieldsArr[]	= 'mo.order_cancel_qty		AS order_cancel_qty';

				$addFieldsArr[]	= 'mp.goods_seq				AS fm_goods_seq';

				$whereArr[]		= "fm_claim_code = ''";
				break;

			default	:
				break;
		}
		
		//샵링커 주문번호
		if (isset($params['openmarketOrderId']) && trim($params['openmarketOrderId']) != '') {
		    $whereArr[]			= "IF(mo.openmarket_order_id IS NULL OR mo.openmarket_order_id = '', '{$params['openmarketOrderId']}', mo.openmarket_order_id) = '{$params['openmarketOrderId']}'";
		}

		if ($rawInfo === true)
			$addFieldsArr[]	= 'mc.claim_raw_info	AS claim_raw_info';


		if (count($joinInfoArr) > 0)
			$joinInfo	= implode("\n", $joinInfoArr);

		if (count($addFieldsArr) > 0)
			$addFields	= ', '.implode(",\n", $addFieldsArr);

		if (count($groupInfoArr) > 0)
			$groupInfo	= 'GROUP BY '.implode(", ", $groupInfoArr);
		

		$where				= '';
		if (count($whereArr) > 0)
			$where		= 'WHERE '.implode(' AND ', $whereArr);
		
		$limit		= '';
		if (isset($params['limit'])) {
			$limitStart	= ($params['page'] - 1) * $params['limit'];
			$limit		= "LIMIT {$limitStart}, {$params['limit']}";
		}

		$listSql	= "
			SELECT	mc.seq						AS seq
				,	mc.market					AS market
				,	mc.seller_id				AS seller_id
				,	mc.fm_market_order_seq		AS fm_market_order_seq
				,	mc.fm_claim_code			AS fm_claim_code
				,	mc.is_fm_order				AS is_fm_order
				,	mc.market_claim_code		AS market_claim_code
				,	mc.market_order_no			AS market_order_no
				,	mc.market_delivery_no		AS market_delivery_no
				,	mc.market_order_seq			AS market_order_seq
				,	mc.claim_type				AS claim_type
				,	mc.claim_status				AS claim_status
				,	mc.request_qty				AS request_qty
				,	mc.claim_registrant			AS claim_registrant
				,	mc.claim_reason				AS claim_reason
				,	mc.claim_reason_desc		AS claim_reason_desc
				,	mc.last_message				AS last_message
				,	mc.registered_time			AS registered_time
				,	mc.claim_close_time			AS claim_close_time
				,	mc.renewed_time				AS renewed_time
				,	mc.exchange_name			AS exchange_name
				,	mc.exchange_zipcode			AS exchange_zipcode
				,	mc.exchange_address			AS exchange_address
				,	mc.exchange_address_detail	AS exchange_address_detail
				,	mc.exchange_cellphone		AS exchange_cellphone
				,	mc.exchange_tel				AS exchange_tel
				{$addFields}
			FROM	fm_market_claims			AS mc
				{$joinInfo}
			{$where}
			{$groupInfo}
			ORDER BY
				{$orderByInfo}
			{$limit}";

		$query			= $this->db->query($listSql, $whereValueArr);
		$claimList		= $query->result_array();
		switch ($getInfoMode) {
			case	'forViewList' :
				
				
				if ($params['withTotalCount'] == true) {
					$countSql		= "SELECT COUNT(*) AS total_count FROM	fm_market_claims AS mc {$joinInfo} {$where} {$groupInfo}";
					$countQuery		= $this->db->query($countSql, $whereValueArr);
					$countResult	= $countQuery->result();
					$return['totalCount']	= $countResult[0]->total_count;
				} else {
					$return['totalCount']	= $params['totalCount'];
				}
					
				$return['resultList']		= $claimList;

				return $return;
				break;
				
			default :
				return $claimList;

		}
	}

	/*↑↑↑↑↑↑↑ 마켓 클레임 관련 처리 ↑↑↑↑↑↑↑*/

	/*↓↓↓↓↓↓↓ 마켓 문의 관련 처리 ↓↓↓↓↓↓↓*/
	
	public function getMarketQnaList($params, $getInfoMode = 'forViewList') {

		$whereArr		= array();
		$whereValueArr	= array();

		if (isset($params['seqList'])) {
			if (is_array($params['seqList'])) {
				$uniqueList		= array_unique($params['seqList']);
				$seqList		= implode("','", $uniqueList);
				$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($uniqueList))));  
				$whereArr[]		= "mq.seq IN ({$inString})";
				$whereValueArr	= $uniqueList;
			} else {
				$whereArr[]			= "mq.seq  = ?";
				$whereValueArr[]	= $params['seqList'];
			}
		}

		//연동 마켓
		if (isset($params['market'])) {
			if (is_array($params['market'])) {
				$marketList		= array_unique($params['market']);
				if ( count($marketList) > 0 ) {
					$listSeq		= implode("','", $marketList);
					$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($marketList))));  
					$whereArr[]		= "mq.market IN ({$inString})";
					$whereValueArr	= array_merge($whereValueArr,$marketList);
				} else {
					$whereArr[]		= "mq.market = ''";
				}
			} else if (trim($params['market']) != '') {
				$whereArr[]			= "mq.market	= ?";
				$whereValueArr[]	= $params['market'];
			}
		}

		//마켓 주문번호
		if (isset($params['marketQnaSeq']) && trim($params['marketQnaSeq']) != '') {
			$whereArr[]			= "mq.market_qna_seq  = ?";
			$whereValueArr[]	= $params['marketQnaSeq'];
		}

		//연동 아이디
		if (isset($params['sellerId']) && trim($params['sellerId']) != '') {
			$whereArr[]			= "mq.seller_id	= ?";
			$whereValueArr[]	= $params['sellerId'];
		}

		// 답변 가능 유무
		if (isset($params['market_cs_yn']) && trim($params['market_cs_yn']) != '') {
			$whereArr[]			= "mq.market_cs_yn	= ?";
			$whereValueArr[]	= $params['market_cs_yn'];
		}

		// 답변 완료 유무
		if(isset($params['fm_answer_yn'])) {
			if (is_array($params['fm_answer_yn'])) {
				$uniqueList		= array_unique($params['fm_answer_yn']);
				$inString		= str_replace(' ', ',', trim(str_repeat("? ", count($uniqueList))));
				$whereArr[]		= "mq.fm_answer_yn IN ({$inString})";
				$whereValueArr	= array_merge($whereValueArr,$uniqueList);
			} else if(trim($params['fm_answer_yn']) != '') {
				$whereArr[]			= "mq.fm_answer_yn	= ?";
				$whereValueArr[]	= $params['fm_answer_yn'];
			}
		}

		// 최종 수정 성공여부
		if(isset($params['lastResult']) && ($params['lastResult'] == 'Y' || $params['lastResult'] == 'N')) {
			$whereArr[]			= 'mq.last_result = ?';
			$whereValueArr[]	= $params['lastResult'];
		}

		$dateFidle		= "mq.market_qna_date";
		$orderByInfo	= "mq.seq DESC";
		

		
		$beginDate	= (isset($params['searchBeginDate']) && $params['searchBeginDate']) ? "{$params['searchBeginDate']} 00:00:00" : false;
		$endDate	= (isset($params['searchEndDate']) && $params['searchEndDate']) ? "{$params['searchEndDate']} 23:59:59" : false;

		if ($dateFidle !== false) {
			if($beginDate !== false) {
				$whereArr[]			= "{$dateFidle}  >= ?";
				$whereValueArr[]	= $beginDate;
			}

			if($endDate !== false) {
				$whereArr[]			= "{$dateFidle}  <= ?";
				$whereValueArr[]	= $endDate;
			}
		}

		if( $getInfoMode != 'forInsertMode') {
			$whereArr[]			= "mq.fm_delete_yn	= ?";
			$whereValueArr[]	= 'N';
		}


		$goodsJoinInfo		= array();
		$addFieldsArr		= array();

		switch($getInfoMode) {
			case	'forRegisterQna' :
				$goodsJoinInfo[]	= "LEFT JOIN fm_market_product_info AS mp";
				$goodsJoinInfo[]	= "ON mq.market = mp.market AND mq.seller_id = mp.seller_id AND mq.market_product_code = mp.market_product_code";
				$goodsJoinInfo[]	= "LEFT JOIN fm_goods AS fp";
				$goodsJoinInfo[]	= "ON mp.goods_seq = fp.goods_seq";
				$goodsJoinInfo[]	= "LEFT JOIN fm_market_orders AS mo";
				$goodsJoinInfo[]	= "ON mq.market_order_no = mo.market_order_no";

				$addFieldsArr[]		= "mp.goods_seq			AS fm_goods_seq";
				$addFieldsArr[]		= "fp.goods_name		AS fm_goods_name";
				$addFieldsArr[]		= "fp.provider_seq		AS provider_seq";
				$addFieldsArr[]		= "mo.fm_order_seq		AS fm_order_seq";

				break;
			case	'forViewList' :
			default : 
				break;
		}

		if (count($goodsJoinInfo) > 0)
			$joinInfo	= implode("\n", $goodsJoinInfo);

		$where				= '';
		if (count($whereArr) > 0)
			$where		= 'WHERE '.implode(' AND ', $whereArr);

		if (count($addFieldsArr) > 0)
			$addFields	= ', '.implode(",\n", $addFieldsArr);

		
		$limit		= '';
		if (isset($params['limit'])) {
			$limitStart	= ($params['page'] - 1) * $params['limit'];
			$limit		= "LIMIT {$limitStart}, {$params['limit']}";
		}

		$listSql	= "
			SELECT	mq.*
					{$addFields}
			FROM	fm_market_qna 			AS mq
				{$joinInfo}
			{$where}
			ORDER BY
				{$orderByInfo}
			{$limit}";
				

		$query			= $this->db->query($listSql, $whereValueArr);
		$qnaList		= $query->result_array();

		if ($params['withTotalCount'] == true) {
			$countSql		= "SELECT COUNT(*) AS total_count FROM	fm_market_qna AS mq {$joinInfo} {$where}";
			$countQuery		= $this->db->query($countSql, $whereValueArr);
			$countResult	= $countQuery->result();
			$return['totalCount']	= $countResult[0]->total_count;
		} else {
			$return['totalCount']	= $params['totalCount'];
		}
		
		
		$return['resultList']		= $qnaList;

		return $return;
	}

	/* 마켓 문의전송 로그 리스트 */
	public function getMarketQnaLog($fmMarketQnaSeq) {
		$query		= $this->db->query("SELECT * FROM fm_market_qna_log WHERE fm_market_qna_seq = ? ORDER BY seq DESC", array($fmMarketQnaSeq));
		$qnaLog	= $query->result_array();
		return $qnaLog;
	}

	/* 마켓 문의 기본정보 업데이트 */
	public function updateMarketQnaInfo($seq, $params) {
		$setData	= filter_keys($params, $this->db->list_fields('fm_market_qna'));
		$result		= $this->db->update('fm_market_qna', $setData, array('seq'=>$seq));
	}

	/*↑↑↑↑↑↑↑ 마켓 문의 관련 처리 ↑↑↑↑↑↑↑*/
	/*↓↓↓↓↓↓↓ 샵링커 영역 ↓↓↓↓↓↓↓*/
	
	/***
	 * 연동 마켓 조회
	 * @return boolean|unknown
	 */
	public function getLinkageCompany($sc){
		
		return $this->usedmodel->get_linkage_support_mall_mall_type('shoplinker',$sc);
	}
	
	/***
	 * 마켓 이름 호출
	 * @param string $marketCode
	 * @return string
	 */
	public function getMarketName($marketSeq){
		$marketName = "";

		// 샵링커인 경우에만 검색 2020-03-10
		if(trim($marketSeq) == "") return $marketName;

		$sc['mallSeq'] = $marketSeq;
		$marketNameArry = $this->getLinkageCompany($sc);
		$marketName = $marketNameArry[0]['mall_name'];
		
		return $marketName;
	}
	
	/***
	 * 판매가격, 재고수량 출력 
	 * @param json $json
	 * @param string $type
	 * @return string|mixed
	 */
	public function getShoplinkerAccountInfo($getJson, $getType){
		$accountStr = "";
		
		$params = json_decode($getJson, true);
		
		if($getType == "price"){
			
			$accountStr = "판매가격을 ";
			
			if($params['adjustment']['use'] == 'N'){
				
				$accountStr .= "원 판매가격과 동일하게 전송";
				
			}else{
				
				if($params['adjustment']['type'] == "PLUS"){
					$accountStr .= " +";
				}else{
					$accountStr .= " -";
				}
				
				$accountStr .= $params['adjustment']['value'];
				
				if($params['adjustment']['unit'] == "PER"){
					$accountStr .= "% 조정으로 일괄 전송,";
				}else{
					$accountStr .= "원 조정으로 일괄 전송,";
				}
				

				
				
				if($params['cutting']['use'] == 'Y'){
					$accountStr .= " 조정된 가격을";
					
					if($params['cutting']['unit'] == "10"){
						$accountStr .= " 일원 단위에서";
					}else if($params['cutting']['unit'] == "100"){
						$accountStr .= " 십원 단위에서";
					}else if($params['cutting']['unit'] == "1000"){
						$accountStr .= " 백원 단위에서";
					}
					
					if($params['cutting']['type'] == "DOWN"){
						$accountStr .= " 버림 하여 절사 처리";
					}else if($params['cutting']['type'] == "UP"){
						$accountStr .= " 올림 하여 절사 처리";
					}else if($params['cutting']['type'] == "ROUND"){
						$accountStr .= " 반올림 하여 절사 처리";
					}
				}
			}
			
		}else if($getType == "stock"){
			if($params['adjustment']['use'] == 'N'){
				$accountStr = "원상품 재고수량과 동일하게 전송";
			}else{
				$accountStr = "재고수량을 ".$params['adjustment']['value']."개로 일괄전송";
				
			}
		}
		
		return $accountStr;
	}
	
	/***
	 * 등록된 마켓 정보 추출
	 * @return array $marketList
	 */
	public function getLinkageMarket($params,$mode=''){
		
		$accountList = array();
		
		//$where = " WHERE market = 'shoplinker' and delete_yn != 'Y'";
		$where = $allwhere 	= "substr(market,1,3) = 'API' and delete_yn != 'Y'";

		if($params['searchMarket'] != ""){
			$where .= " and market_other_info -> \"$.marketCode\" = \"".$params['searchMarket']."\" and delete_yn != 'Y'";
		}
				
		if($params['searchSellerId'] != ""){
			$where .= " and seller_id = \"".$params['searchSellerId']."\"";
		}

		$limit			= '';
		if (isset($params['limit'])) {
			$limitStart	= ($params['page'] - 1) * $params['limit'];
			$limit		= "LIMIT {$limitStart}, {$params['limit']}";
		}

		$listSql	= "
			SELECT	seq, market, seller_id, goods_price_set, goods_stock_set, account_use, delete_yn, market_other_info
			FROM	fm_market_account
			WHERE {$where}
			ORDER BY seq DESC
		".$limit;

		if($mode == 'count') {
			$query			= $this->db->query("SELECT COUNT(*) AS CNT FROM fm_market_account	WHERE {$where}")->row_array();
			$return['searchCount'] = $query['CNT'];
			$this->db->where($allwhere);
			$this->db->from('fm_market_account');
			$return['totalCount'] = $this->db->count_all_results();
		}

		$query			= $this->db->query($listSql, $whereValueArr);
		$marketList		= $query->result_array();

		$i = 0;
		foreach($marketList as $data){
			$accountList[$i]['seq'] = $data['seq'];
			
			if($data['account_use'] == "Y"){
				$accountUse = "ON";
			}else{
				$accountUse = "OFF";
			}
			
			if($data['delete_yn'] == "Y"){
				$accountUse = "OFF";
			}
			
			
			$otherInfo = json_decode($data['market_other_info'],true);
			
			$accountList[$i]['market'] = $data['market'];
			
			$accountList[$i]['marketName'] = $this->getMarketName($otherInfo['marketSeq']);
			$accountList[$i]['marketCode'] = $otherInfo['marketCode'];
			$accountList[$i]['marketSeq'] = $otherInfo['marketSeq'];
			$accountList[$i]['sellerId'] = $data['seller_id'];
			
			$accountList[$i]['goodsPriceSet'] = $this->getShoplinkerAccountInfo($data['goods_price_set'],'price');
			$accountList[$i]['goodsStockSet'] = $this->getShoplinkerAccountInfo($data['goods_stock_set'],'stock');
			
			$accountList[$i]['accountUse'] = $accountUse;
			
			$i++;
		}

		if($mode == 'count') {
			$return['resultList'] 	= $accountList;
		}else{
			$return 				= $accountList;
		}
			
		return $return;
	}
	
	/***
	 * 등록된 마켓 정보 추출
	 * @return array $marketList
	 */
	public function getLinkageMarketGroupList($params){
		
		$accountList = array();
		
		//$where = " WHERE market = 'shoplinker' and delete_yn != 'Y'";
		$where = $countWhere = "WHERE market LIKE 'API%' and delete_yn != 'Y'";

		if($params['searchSellerId'] != ""){
			$where .= " and seller_id = \"".$params['searchSellerId']."\"";
		}

		if($params['searchMarket'] != ""){
			$where .= " and market_other_info -> \"$.marketCode\" = \"".$params['searchMarket']."\" ";
		}
		
		$listSql	= "
			SELECT	seq, market, seller_id, goods_price_set, goods_stock_set, account_use, delete_yn, market_other_info
			FROM	fm_market_account
			{$where}
			ORDER BY seq DESC
		";
			
			$query			= $this->db->query($listSql, $whereValueArr);
			$marketList		= $query->result_array();
			$i 				= 0;
			foreach($marketList as $data){

				$accountList[$i]['seq'] = $data['seq'];
				
				if($data['account_use'] == "Y"){
					$accountUse = "ON";
				}else{
					$accountUse = "OFF";
				}
				
				if($data['delete_yn'] == "Y"){
					$accountUse = "OFF";
				}
				
				
				$otherInfo 				= json_decode($data['market_other_info'],true);
				
				$postVal 				= array();				
				$postVal['customer_id'] = $params['shoplinkerCode'];
				$postVal['user_id'] 	= $data['seller_id'];
				$postVal['mall_id'] 	= $otherInfo['marketCode'];
				$postVal['market'] 		= $data['market'];
				//$postVal['market'] 	= 'shoplinker';
				$postVal['sellerId'] 	= $data['seller_id'];
				
				$rtn 					= $this->getShoplinkerGroupInfo($postVal);

				if($rtn['success'] == "Y"){
					
					if($rtn['resultData'] != null){
						foreach($rtn['resultData'] as $data){

							// 그룹명 검색
							if($params['searchGroupName'] != "" && !strstr($data['group_name'],$params['searchGroupName'])){
								unset($accountList[$i]);
								continue;
							}

							// 샵링커 카테고리 특수문자 제거 2019-10-01 sms
							$cateinfo 	= $data['cateinfo'];
							$leng 		= strlen($cateinfo);
							
							for($count=0; $count<=$leng; $count++){
								if($cateinfo[strlen($cateinfo)-1]==='>'){
									$cateinfo = substr($cateinfo, 0, -1);
								}else{
									break;
								}
							}
							$data['cateinfo'] 				= $cateinfo;

							$accountList[$i]['groupName'] 	= $data['group_name'];
							$accountList[$i]['groupId'] 	= $data['group_id'];
							$accountList[$i]['sellerId'] 	= $data['user_id'];
							$accountList[$i]['cateinfo'] 	= $data['cateinfo'];
							$accountList[$i]['useYn'] 		= $data['useYn'];
							$accountList[$i]['market'] 		= $data['market'];
							$accountList[$i]['marketName'] 	= $this->getMarketName($otherInfo['marketSeq']);
							$accountList[$i]['marketCode'] 	= $otherInfo['marketCode'];
							$accountList[$i]['marketSeq'] 	= $otherInfo['marketSeq'];

							$i++;
						}
					}
				}else{
					unset($accountList[$i]);
				}

			}

			return $accountList;
	}
	
	
	public function getLinkageMarketAccountInfo($params){
		
		$accountList = array();
		
		//$where = " WHERE market = 'shoplinker' and delete_yn != 'Y'";
		$where = "WHERE market LIKE 'API%' and delete_yn != 'Y'";
		
		if($params['sellerId'] != ""){
			$where .= " and seller_id = '".$params['sellerId']."'";
		}
		
		if($params['searchMarket'] != ""){
			$where .= " and market_other_info -> \"$.marketCode\" = \"".$params['searchMarket']."\"";
			
		}
		
		if($params['searchMarket2'] != ""){
			$where .= " and market = '".$params['searchMarket2']."'";
			
		}
		
		$listSql	= "
			SELECT	seq, market, seller_id, goods_price_set, goods_stock_set, account_use, delete_yn, market_other_info
			FROM	fm_market_account
			{$where}
			ORDER BY seq DESC
		";
			
		$query			= $this->db->query($listSql, $whereValueArr);
		$marketList		= $query->result_array();
		
		foreach ($marketList as $data){
			$response['seq'] =  $data['seq'];
			$response['market'] =  $data['market'];
			$response['seller_id'] =  $data['seller_id'];
			$response['market_other_info'] =  $data['market_other_info'];
		}
		
		
		return $response;
	}
	
	/***
	 * 등록 되어진 마켓 리스트
	 * @return array
	 */
	public function getLinkageMarketGroup($param=null){
		
		$accountList = array();
		
		//$where = "WHERE market LIKE 'shoplinker%' and delete_yn != 'Y'";
		$where = "WHERE market LIKE 'API%' and delete_yn != 'Y'";
		
		if($param['accountUse'] == "Y"){
			$where .= " AND account_use = 'Y'";
		}
		
		$listSql	= "
			SELECT	seq, market, market_other_info
			FROM	fm_market_account
			{$where}
		    GROUP BY market_other_info
			";
			
			$query			= $this->db->query($listSql, $whereValueArr);
			$marketList		= $query->result_array();
			
			$i = 0;
			foreach($marketList as $data){
				$accountList[$i]['seq'] = $data['seq'];
				
				$marketOrg = $data['market'];
				$marketOtherInfo = json_decode($data['market_other_info'],true);
				$accountList[$i]['marketCode'] = $marketOtherInfo['marketCode'];
				$accountList[$i]['marketName'] = $this->getMarketName($marketOtherInfo['marketSeq'])."(샵링커)";

				$i++;
			}
			
			return $accountList;
	}
	
	/***
	 * 등록 되어진 마켓 리스트
	 * @return array
	 */
	public function getShoplinkerAddInfo($param=null){
		if($param['addInfoSeq'] != ""){
			$where = "WHERE seq = '".$param['addInfoSeq']."'";
		}else{
			$where = "WHERE market = '".$param['market']."' and seller_id = '".$param['seller_id']."' and category_code = '".$param['category_code']."'";
		}
		
		
		$listSql	= "
			SELECT	seq, market, seller_id, category_code
			FROM	fm_market_add_info
			{$where}
			";
			
			$query			= $this->db->query($listSql, $whereValueArr);
			$marketList		= $query->result_array();
			
			$rtn['seq'] = $marketList[0]['seq'];
			$rtn['market'] = $marketList[0]['market'];
			$rtn['seller_id'] = $marketList[0]['seller_id'];
			$rtn['category_code'] = $marketList[0]['category_code'];
			
			return $rtn;
	}
	
	
	/***
	 * 샵링커 계정 그룹정보 호출
	 * @param array $param
	 */
	public function getShoplinkerGroupInfo($param){
		$rtn = array();
		$this->_connectorBasic->setMarketInfo($param['market'], $param['user_id']);
		
		$postVal['request'] = $param;
		$postVal['shoplinker'] = true;
		
		$rtnArray = $this->_connectorBasic->callConnector('product/getShoplinkerGroup',$postVal);
		$rtn["success"] = $rtnArray["success"];
		
		if(isset($rtnArray['resultData']['group_name'])){
			$rtn['resultData'][0] = $rtnArray['resultData'];
		}else{
			$rtn['resultData'] = $rtnArray['resultData'];
		}
		
		return $rtn;
		
	}
	
	/***
	 * 샵링커 그룹정보 관리 URL 호출
	 * @param array $param
	 * @return string
	 */
	public function getShoplinkerAddInfoUrl($param){	

		$this->_connectorBasic->setMarketInfo($param['market'], $param['user_id']);
		$postVal['request'] = $param;
		$postVal['shoplinker'] = true;

		return $this->_connectorBasic->callConnector('product/getMoveGroupManagerUrl',$postVal);
	}
	
	/***
	 * 샵링커 SCM 로그인 URL 호출
	 * @param array $param
	 * @return string
	 */
	public function getShoplinkerSCMUrl($param){
		$this->_connectorBasic->setMarketInfo($param['market'], $param['user_id']);
		$postVal['request'] = $param;
		$postVal['shoplinker'] = true;
		
		return $this->_connectorBasic->callConnector('product/getMoveSCMUrl',$postVal);
	}
	
	/***
	 * 샵링커 오픈 마켓 링크 호출
	 * @param array $param
	 * @return string
	 */
	public function getShoplinkerProductLink($param){
		$this->_connectorBasic->setMarketInfo($param['market'], $param['sellerId']);
		$postVal['request']['marketCode'] = $param['marketCode'];
		return $this->_connectorBasic->callConnector('Product/getOpenMarketProductLink',$postVal);
	}
	
	/***
	 * 샵링커 카테고리 조회
	 * @param array $sc
	 * @return string
	 */
	public function getLinkCategoryInfo($sc=null){
		$response = array();
		$rtn = $this->usedmodel->get_linkage_category('shoplinker',$sc);
		$rtnCnt = count($rtn);
		$depth = $sc["depth"];
		
		if($rtnCnt > 0){
			$resultData = array();
			
			$response['success'] = "Y";
			$i = 0;
			foreach($rtn as $data){
				$categoryCode = $data['category_code'.$depth];
				$categoryName = $data['category_name'.$depth];
				if($categoryName != ""){
					$resultData[$i]['categoryCode'] = $categoryCode;
					$resultData[$i]['categoryName'] = $categoryName;
					$i++;
				}else{
					$resultData = array();
					break;
				}
			}
			
			$response['resultData'] = $resultData;
		}else{
			$response['success'] = "N";
			$response['code'] = "605";
			$response['message'] = "해당하는 카테고리가 없습니다.";
		}
		
		return json_encode($response);
	}

	/*추가옵션 주문 등록시 주문 등록 된 필수옵션 정보 불러오기 20180314 ldb*/
	public function sameOrderlistOne($market_product_code) {
		$listSql	= "SELECT * FROM fm_market_orders where market_product_code = $market_product_code and add_product_yn = 'N' and fm_order_seq != ''";
		$query			= $this->db->query($listSql);
		$marketList		= $query->result_array();

		if($marketList[0]['seq'] == '') {
			$rtOption['message'] = '필수옵션부터 주문 등록을 하셔야 합니다.';
		} else {
			$rtOption['seq'] = $marketList[0]['seq'];
			$rtOption['fm_order_seq'] = $marketList[0]['fm_order_seq'];
			$rtOption['fm_item_seq'] = $marketList[0]['fm_item_seq'];
			$rtOption['fm_item_option_seq'] = $marketList[0]['fm_item_option_seq'];
		}

		return $rtOption;
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
	/*↑↑↑↑↑↑↑ 샵링커 영역 ↑↑↑↑↑↑↑*/

	/*↓↓↓↓↓↓↓ 공통 영역 ↓↓↓↓↓↓↓*/
	/***
	 * 할인금액 조회
	 * @param order_seq|mall_order_id|mall_code
	 * @return price
	 */
	public function getOpenmarketDiscountAmount($order_seq,$mall_order_id,$mall_code){
		$response = 0;
		if(!$order_seq || !$mall_order_id || !$mall_code) {
			return $response;
		}

		$whereArr		= array();
		$whereValueArr	= array();
		if (trim($order_seq)) {
			$whereArr[]			= 'fm_order_seq = ?';
			$whereValueArr[]	= $order_seq;
		}

		if (trim($mall_order_id)) {
			$whereArr[]			= 'market_order_no = ?';
			$whereValueArr[]	= $mall_order_id;
		}

		$basicWhere		= ' ';
		if (count($whereArr) > 0)
			$basicWhere	= ' WHERE '.implode(" AND ", $whereArr);

		$sql	= "select
					sum(order_product_price) as order_product_price,
					sum(order_amount) as order_amount,
					sum(paid_amount) as paid_amount,
					sum(seller_discount_amount) as seller_discount_amount,	
					sum(market_discount_amount) as market_discount_amount,
					sum(shipping_cost) as shipping_cost
				from fm_market_orders {$basicWhere} group by fm_order_seq ";

		$query	= $this->db->query($sql, $whereValueArr);
		$result	= $query->result_array();
		$result_data = $result[0];

		if($result_data['seller_discount_amount'] > 0 || $result_data['market_discount_amount'] > 0) {
			if($mall_code=='storefarm'){
				$response = (($result_data['market_discount_amount'] - $result_data['seller_discount_amount']) + $result_data['seller_discount_amount']);
			}elseif($mall_code=='open11st'){
				$response = ($result_data['market_discount_amount'] + $result_data['seller_discount_amount']);
			}elseif($mall_code=='coupang'){
				$response = ($result_data['market_discount_amount'] + $result_data['seller_discount_amount']);
			}else{
				$response = 0;
			}
		}

		return $response;
	}
	
	/**
	 * 사용중인지 여부를 반환한다.
	 */
	public function getInUse()
	{
	    if(function_exists('config_load') !== true) {
	        $this->load->helper('basic');
	    }
	    $row = config_load("market_connector", "inUse", true);
	    if ( empty($row) ||  empty($row['inUse']) || $row['inUse']['value'] !== 'Y' || empty($row['inUse_date']) ) {
	        return false;
	    }
	    
	    // 마지막으로 사용한 시간보다 5분 후라면 미사용중으로 체크한다. 2020-03-12 modified
	    $now		= date_create(date("Y-m-d H:i:s"));
	    $date		= date_create($row['inUse_date']);
	    $diffObj	= date_diff($now, $date);

		$minutes	 = $diffObj->days * 24 * 60;
		$minutes	+= $diffObj->h * 60;
		$minutes	+= $diffObj->i;

	    if( empty($diffObj) ||  $minutes > 5) {
			return false;
	    }
	    return $row;
	}
	
	/**
	 * 사용/미사용 여부를 갱신한다.
	 */
	public function setInUse($data)
	{
	    if(function_exists('config_save') !== true) {
	        $this->load->helper('basic');
	    }
	    config_save("market_connector", array('inUse'  =>  $data));
	}
	
	/*↑↑↑↑↑↑↑ 공통 영역 ↑↑↑↑↑↑↑*/
}