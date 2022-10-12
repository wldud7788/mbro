<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class Market_connector extends admin_base {
	
	public $supportMarkets		= array();
	protected $_connectorBase;
		
	public function __construct() {
		parent::__construct();
		$this->connectorUrl	= '';
		$this->load->model('connectormodel');
		$this->_connectorBase	= $this->connector::getInstance();
		$this->supportMarkets	= $this->_connectorBase->getAllMarkets();

		$MarketConnectorClause	= config_load('MarketConnectorClause');
		$MarketLinkage	= config_load('MarketLinkage');
		
		if(preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", $MarketConnectorClause['agreeDate']) > 0 && $MarketLinkage['shopCode'] == ''){
			//최초 설정 firstmall 로 설정
			config_save('MarketLinkage', array("shopCode" => 'firstmall'));
		}
		
		if($MarketLinkage["shopCode"] == "shoplinker"){
			foreach ($this->supportMarkets as $key => $val){
				$chkShoplinker  = $this->checkShoplinkMarket($key);
				if($chkShoplinker === false){
					unset($this->supportMarkets[$key]);
				}
			}
		}else{
			
			foreach ($this->supportMarkets as $key => $val){
				$chkShoplinker  = $this->checkShoplinkMarket($key);
				if($chkShoplinker === true){
					unset($this->supportMarkets[$key]);
				}
			}
			
		}
		
		if ((preg_match('/market_connector\/market_setting/',$_SERVER['REQUEST_URI']) == 0 || preg_match('/market_connector\/market_setting/',$_SERVER['REQUEST_URI']) == 0) && preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", $MarketConnectorClause['agreeDate']) == 0)
			$this->supportMarkets['ClauseAgree']	= false;
		
		$this->template->assign('marketsObj', json_encode($this->supportMarkets));
		$this->template->define(array('scm_login'=>$this->skin."/market_connector/_scm_login.html"));
		$this->template->define(array('group_add'=>$this->skin."/market_connector/_group_add.html"));
		
	}

	public function index()
	{
		redirect("/admin/market_connector/market_linkage");
	}
	
	/***
	 * 2017-08-24 샵링커 추가로 인한 구조 변경
	 */
	public function market_setting() {
		$this->admin_menu();
		$this->tempate_modules();
		$filePath	= $this->template_path();

		$params 		= $this->input->get();

		$MarketConnectorClause	= config_load('MarketConnectorClause');
		$MarketLinkage	= config_load('MarketLinkage');
		
		if($MarketLinkage['shopCode'] == ""){
			$redirctUri = "/admin/market_connector/market_linkage";
			pageLocation($redirctUri, "연동 설정을 안하셨습니다. 연동 설정부터 하여 주십시요");
			exit;
		}
		
		if($MarketLinkage['shopCode'] == "firstmall"){
			$this->template->define('CONTENT', $this->skin.$this->firstmall_market_setting());
		}else{
			
			if($params['pageMode'] == "") $params['pageMode'] = "AccountSet";
			$this->template->define('CONTENT', $this->skin.$this->shoplinker_market_setting($params['pageMode']));
		}
		
		$search			= json_encode($params);

		requirejs([
			["/admin/skin/default/css/market_connector.css",10],
			["/app/javascript/js/admin-connectorCommon.js",10],
			["/app/javascript/js/admin/gSearchForm.js",20]]);

		$this->template->assign(array(
			'MarketConnectorClause' => $MarketConnectorClause,
			'search'				=> $search
		));

		$this->template->define(array(
			'tpl' => $this->template_path()
		));

		$this->template->print_("tpl");
	}
	
	/***
	 * 오픈마켓 연동 설정
	 */
	public function market_linkage() {
		$this->admin_menu();
		$this->tempate_modules();
		
		$MarketLinkage	= config_load('MarketLinkage');
		
		$MarketConnectorClause	= config_load('MarketConnectorClause');
		$param = array();
		$scmLoginList	= $this->connectormodel->getLinkageMarket($param);
		
		if (preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", $MarketConnectorClause['agreeDate']) == 0) {
			$MarketConnectorClause	= 'NOT_YET';
		}
		
		$this->template->define('CLAUSE', $this->skin.'/market_connector/_market_connector_clause.html');

		// js, css
		requirejs([
			["/app/javascript/js/admin-connectorCommon.js", 0],
			["/admin/skin/default/css/market_connector.css",10],
		  ]);

		$this->template->assign(array(
			'pageMode'		=> $pageMode,
			'market'		=> $market,
			'sellerId'		=> $sellerId,
			'accountSeq'	=> $accountSeq,
			'useMarketList'	=> $useMarketList,
			'accountList'	=> $accountList,
			'MarketConnectorClause' => $MarketConnectorClause,
			'MarketLinkage' => $MarketLinkage,
			'scmLoginList' => $scmLoginList
		));
		
		$this->template->define(array(
			'tpl' => $this->template_path()
		));
		
		$this->template->print_("tpl");
	}

	public function market_account_setting($market) {
		$accountSeq		= (int)$this->input->get('accountSeq');

		if ($accountSeq > 0) {
			$mode			= 'renew';
			$accountInfo	= $this->connectormodel->getAccountInfo(['accountSeq' => $accountSeq], true);
			$market			= $accountInfo['market'];
			$goodsPriceSet	= json_encode($accountInfo['goodsPriceSet']);
			$goodsStockSet	= json_encode($accountInfo['goodsStockSet']);

			if (isset($accountInfo['accountSeq']) !== true)
				return "/market_connector/_blank.html";

		} else {
			$mode			= 'regist';
			$accountInfo	= array();

			$goodsPriceSet	= json_encode(['adjustment' =>['use'=>'N']]);
			$goodsStockSet	= json_encode(['adjustment' =>['use'=>'N']]);
		}

		// 사용 중지 마켓은 정보 수정 가능.
		$supportMarkets		= $this->_connectorBase->getAllMarkets(false,false);
		if ($mode != 'regist' && isset($supportMarkets[$market]) !== true)
			return "/market_connector/_blank.html";

		$this->template->assign(array(
			'mode'				=> $mode,
			'market'			=> $market,
			'accountInfo'		=> $accountInfo,
			'goodsPriceSet'		=> $goodsPriceSet,
			'goodsStockSet'		=> $goodsStockSet,
		));

		return "/market_connector/_account_form.html";
	}
	
	/***
	 * 솔루션 어카운트 설정
	 * @return string
	 */
	public function firstmall_market_setting(){
		$this->admin_menu();
		$this->tempate_modules();
		
		// 사용 중지 계정도 노출되도록 수정
		$supportMarkets 	= $this->_connectorBase->getAllMarkets(false,false);
		$useMarketList		= $this->connectormodel->getUseMarketList();

		foreach ($useMarketList as $key => $val){
			$chkShoplinker  = $this->checkShoplinkMarket($key);
			if($chkShoplinker === true){
				unset($useMarketList[$key]);
			}
		}

		unset($useMarketList["shoplinker"]);
		
		if (count($useMarketList) > 0) {
			$market		= $this->input->get('market');
			$pageMode	= trim($this->input->get('pageMode'));
			$sellerId	= trim($this->input->get('sellerId'));
			
			if (isset($supportMarkets[$market]) !== true)
				$market	= key($useMarketList);
				
				$params['market']		= $market;
				$accountList			= $this->connectormodel->getAccountList($params);
		} else {
			$market		= false;
			$pageMode	= 'FirstSet';
		}
		
		$MarketLinkage	= config_load('MarketLinkage');

		switch($pageMode) {
			case	'AccountSet' :
				$rightContent	= $this->market_account_setting($market);
				break;
				
			case	'AddInfoListSet' :
				$rightContent	= $this->add_info_list($market, $sellerId);
				break;
				
			case 	'AddInfoRegistSet' :
				$this->_addInfoSet($market, 'layer');
				$rightContent	= "/market_connector/{$market}_add_info.html";
				break;
				
			case 	'CategoryMatchingListSet' :
				$rightContent	= $this->category_matching($market, $sellerId);
				break;
				
			default :
				$rightContent	= "/market_connector/_blank.html";
		}
		
		$this->template->assign(array(
						'pageMode'		=> $pageMode,
						'market'		=> $market,
						'sellerId'		=> $sellerId,
						'accountSeq'	=> $accountSeq,
						'useMarketList'	=> $useMarketList,
						'MarketLinkage' => $MarketLinkage,
						'accountList'	=> $accountList,
		));
		
		
		$this->template->define(array(
						'tpl'			=> $this->template_path(),
						'RIGHT_CONTENT'	=> $this->skin.$rightContent
		));
		
		return "/market_connector/firstmall_market_setting.html";
	}
	
	/**
	 * 샵링커 영역
	 */
	
	/***
	 * 샵링커 마켓 설정
	 * @return string
	 */
	public function shoplinker_market_setting($pageMode = 'AccountSet'){

		$this->admin_menu();
		$this->tempate_modules();

		$market 			= "shoplinker";		
		$useMarketList		= $this->connectormodel->getUseShoplinkerMarketList();

		$param 				= array();
		$scmLoginList		= $this->connectormodel->getLinkageMarket($param);
		
		$pageMode			= (!$pageMode) ? trim($this->input->get('pageMode')):$pageMode;
		$searchMarket		= trim($this->input->get('searchMarket'));
		$detailMarket		= trim($this->input->get('detailMarket'));
		
		$MarketLinkage		= config_load('MarketLinkage');
		
		switch($pageMode) {
			case	'AccountSet' : //ACCOUNT LIST
				$rightContent	= $this->shoplinker_account_list();
				break;
			case    'AccountSetDetail' : //ACCOUNT DETAIL
				$rightContent = $this->shoplinker_market_account_setting($detailMarket);
				break;
				
			case	'AddInfoListSet' : // GROUP LIST
				$rightContent	= $this->shoplinker_add_info_list($MarketLinkage['shoplinkerCode']);
				break;
				
			case 	'AddInfoDetail' :
				$rightContent	= $this->shoplinker_add_info_detail();
				break;
				
			case 	'CategoryMatchingListSet' :
				$rightContent	= $this->shoplinker_category_matching($market, $MarketLinkage['shoplinkerCode']);
				break;
				
			default :
				$rightContent	= $this->shoplinker_account_setting();
		}

		//판매마켓리스트(검색용)
		if(in_array($pageMode,array('AccountSet','AddInfoListSet','CategoryMatchingListSet'))){
			$marketAccountGroup = $this->connectormodel->getLinkageMarketGroup();
		}

		$this->template->assign(array(
			'pageMode'			=> $pageMode,
			'market'			=> "shoplinker",
			'searchMarket'		=> $searchMarket,
			'searchSellerId'	=> $searchSellerId,
			'sellerId'			=> $sellerId,
			'accountSeq'		=> $accountSeq,
			'useMarketList'		=> $useMarketList,
			'marketAccountGroup'=> $marketAccountGroup,
			'accountList'		=> $accountList,
			'MarketLinkage' 	=> $MarketLinkage,
			'scmLoginList' 		=> $scmLoginList
		));
		
		
		$this->template->define(array(
			'tpl'			=> $this->template_path(),
			'RIGHT_CONTENT'	=> $this->skin.$rightContent
		));
		
		return "/market_connector/shoplinker_market_setting.html";
	}
	
	/***
	 * 샵링커 마켓 ACCOUNT 추가 레이어 팝업
	 */
	public function shoplinker_linkage_market_register() {
		
		$this->template->template_dir = BASEPATH."../admin/skin/default/market_connector/";
		$this->template->compile_dir = BASEPATH."../_compile/";
		$this->template->define(array('tpl'=>'_shoplinker_linkage_market_register.html'));
		$this->template->print_('tpl');
	}
	
	/***
	 * 샵링커 연동 마켓 리스트 정보 출력
	 */
	public function getLinkageMarketList(){
		$mallSort = $this->input->get('mallSort');
		$mallSeq = $this->input->get('mallSeq');
		$mallCode = $this->input->get('mallCode');
		
		if($mallSort != ""){
			$sc['mallSort'] = $mallSort;
		}
		
		if($mallSeq != ""){
			$sc['mallSeq'] = $mallSeq;
		}
		
		if($mallCode != ""){
			$sc['mallCode'] = $mallCode;
		}
		
		$linkageCompany = $this->connectormodel->getLinkageCompany($sc);
		$rtnJson = json_encode($linkageCompany);
		echo $rtnJson;
	}
	
	/***
	 * 샵링커 ACCOUNT 리스트(계정 리스트)
	 * @return string
	 */
	public function shoplinker_account_list() {

		$params = $this->input->get();
		
		$params['page']		= ((int)$params['page'] > 0) ? (int)$params['page'] : 1;
		$params['limit']	= ((int)$params['perpage'] > 0) ? (int)$params['perpage'] : 10;
		$totalCount			= ((int)$params['totalCount'] < 1 || $params['page'] == 1) ? true : false;

		$marketAccountList 	= $this->connectormodel->getLinkageMarket($params,'count');

		$params['searchCount']	= $marketAccountList['searchCount'];
		$params['totalCount']	= $marketAccountList['totalCount'];
		$search					= json_encode($params);
		
		$totalPage		= ceil($params['searchCount'] / $params['limit']);
		$pageLimit		= 10;
		$nowEndPage		= ($params['page'] <= $pageLimit) ? $pageLimit : (ceil($params['page'] / $pageLimit)) * $pageLimit;
		$nowStartPage	= ($params['page'] < $pageLimit) ? 1 : $nowEndPage - $pageLimit + 1;
		$nowEndPage		= ($nowEndPage > $totalPage) ?  $totalPage :  $nowEndPage;
		$pages			= array();
		for($i = $nowStartPage; $i <= $nowEndPage; $i ++)
			$pages[]	= $i;
			
			$paging			= pagingtagjs($params['page'],$pages,$totalPage,'movePage([:PAGE:]);', $pageLimit);
			
		$this->template->assign(array(
			'paging'				=> $paging,
			'sc'					=> $params,
			'marketAccountList'		=> $marketAccountList['resultList']
		));
				
		return "/market_connector/_shoplinker_account_form.html";
	}
	
	/***
	 * 샵링커 ACCOUNT 설정
	 * @param string $market
	 * @return string
	 */
	public function shoplinker_market_account_setting($market) {
		
		$params = $this->input->get();
		
		$marketAccountList = $this->connectormodel->getLinkageMarket($params);
		
		$accountSeq		= (int)$this->input->get('accountSeq');
		
		if ($accountSeq > 0) {
			$mode			= 'renew';
			$accountInfo	= $this->connectormodel->getAccountInfo(['accountSeq' => $accountSeq, 'market' => $market], true);
			$market			= $accountInfo['market'];
			$marketOtherInfo	= $accountInfo['marketOtherInfo'];
			$goodsPriceSet	= json_encode($accountInfo['goodsPriceSet']);
			$goodsStockSet	= json_encode($accountInfo['goodsStockSet']);
			
			if (isset($accountInfo['accountSeq']) !== true)
				return "/market_connector/_blank.html";
				
		} else {
			$mode			= 'regist';
			$accountInfo	= array();
			
			$goodsPriceSet	= json_encode(['adjustment' =>['use'=>'N']]);
			$goodsStockSet	= json_encode(['adjustment' =>['use'=>'N']]);
		}
		
		// 사용 중지 마켓은 정보 수정 가능.
		$this->template->assign(array(
						'mode'				=> $mode,
						'market'			=> $market,
						'marketCode'		=> $marketOtherInfo['marketCode'],
						'linkageMall'		=> $marketOtherInfo['marketSeq']."|".$marketOtherInfo['marketCode'],
						'sellerId'			=> $sellerId,
						'accountInfo'		=> $accountInfo,
						'goodsPriceSet'		=> $goodsPriceSet,
						'goodsStockSet'		=> $goodsStockSet,
		));
		
		return "/market_connector/_shoplinker_account_detail.html";
	}
	
	/***
	 * 샵링커 그룹정보 리스트
	 * @return string
	 */
	public function shoplinker_add_info_list($shoplinkerCode){
		
		$params = $this->input->get();
		$params["shoplinkerCode"] = $shoplinkerCode;
		
		$marketAccountList = $this->connectormodel->getLinkageMarketGroupList($params);

		/* 페이징 시작 */
		$params['limit'] = $params['perpage'];
		if(!$params['limit']) 	$params['limit'] = 10;
		if(!$params['page']) 	$params['page'] = 1;
		
		$params['totalCount']	= count($marketAccountList);
		//$search					= json_encode($params);
		
		$totalPage		= ceil($params['totalCount'] / $params['limit']);
		$pageLimit		= 10;
		$nowEndPage		= ($params['page'] <= $pageLimit) ? $pageLimit : (ceil($params['page'] / $pageLimit)) * $pageLimit;
		$nowStartPage	= ($params['page'] < $pageLimit) ? 1 : $nowEndPage - $pageLimit + 1;
		$nowEndPage		= ($nowEndPage > $totalPage) ?  $totalPage :  $nowEndPage;
		$pages			= array();
		for($i = $nowStartPage; $i <= $nowEndPage; $i ++) $pages[]	= $i;
			
		$paging			= pagingtagjs($params['page'],$pages,$totalPage,'movePage([:PAGE:]);', $pageLimit);

		$list 	= array();
		$viewS 	= ($params['page'] - 1) * $params['limit'];
		$viewE 	= $params['page'] * $params['limit'];
		foreach($marketAccountList as $key=>$data){
			if($key >= $viewS && $key < $viewE) $list[] = $data;
		}
		/* 페이징 종료 */

		$this->template->assign(array(
			'sc'					=> $params,
			'paging'				=> $paging,
			'marketAccountList'		=> $list,
		));
		return "/market_connector/shoplinker_add_info_list.html";
	
	}
	
	/***
	 * 샵링커 필수정보 조회 리스트
	 * @return string
	 */
	public function shoplinker_add_info_detail(){
		$params = $this->input->get();
		
		$postVal = array();
		$pageMode = $params['pageMode'];
		$market = $params['detailMarket'];
		$linkMode = $params['linkMode'];
		$groupId = $params['groupId'];
		$marketInfoArray = explode("|",$market);
		
		$sellerId = $marketInfoArray[0];
		$mallId = $marketInfoArray[1];
		$marketSeq= $marketInfoArray[2];
		
		$MarketLinkage	= config_load('MarketLinkage');
		
		$postVal['customer_id'] = $MarketLinkage['shoplinkerCode'];
		$postVal['user_id'] = $sellerId;
		$postVal['market'] = $marketInfoArray[1];
		$postVal['mall_id'] = $mallId;
		$postVal['marketName'] = $this->connectormodel->getMarketName($marketSeq);
		
		if($linkMode == "regist"){
			$groupType = "000";
		}else{
			$groupType = "001";
		}
		
		$this->template->assign(array(
			'pageMode'		=> $pageMode,
			'groupType'		=> $groupType,
			'groupId'		=> $groupId,
			'postVal'		=> $postVal,
			'linkMode'		=> $linkMode
		));
		
		$this->template->template_dir = BASEPATH."../admin/skin/default/market_connector/";
		$this->template->compile_dir = BASEPATH."../_compile/";
		$this->template->define(array('tpl'=>'shoplinker_add_info_detail.html'));
		$this->template->print_('tpl');
	}
		
	
	/***
	 * 샵링커 그룹정보 url 추출
	 * @return string
	 */
	public function getMarketAddinfo(){
		$rtn = "";
		
		$params = $this->input->post();

		$rtn = $this->connectormodel->getShoplinkerAddInfoUrl($params);

		echo json_encode($rtn);
		
	}
	
	/***
	 * 샵링커 그룹정보 url 추출
	 * @return string
	 */
	public function getMarketScmLogin(){
		$rtn = "";
		
		$params = $this->input->post();

		$rtn = $this->connectormodel->getShoplinkerSCMUrl($params);
		
		echo json_encode($rtn);
		
	}
	
	public function shoplinker_category_matching($market, $sellerId){
		$this->admin_menu();
		$this->tempate_modules();
		$this->load->model('categorymodel');
		
		$params				= $this->input->get();
		$params['market']	= $market;
		//$params['sellerId']	= $sellerId;
		$params['page']		= ((int)$params['page'] > 0) ? (int)$params['page'] : 1;
		$params['limit']	= ((int)$params['perpage'] > 0) ? (int)$params['perpage'] : 10;
		$totalCount			= ((int)$params['totalCount'] < 1 || $params['page'] == 1) ? true : false;
		
		$depCnt				= 1;
		$fmCategoryCode		= null;
		
		while (isset($params["searchCategory{$depCnt}"]) === true) {
			$nowCategoryCode	= trim($params["searchCategory{$depCnt}"]);
			if (strlen($nowCategoryCode) == $depCnt * 4) {
				$params['fmCategoryCode']	= $nowCategoryCode;
			}
			
			$depCnt++;
			
		}
		
		
		$categoryList			= $this->connectormodel->getMatchCategoryList($params, 'forViewList', $totalCount);
		
		$fmCategoryNameArr		= array();
		
		foreach ((array)$categoryList['resultList'] as $key => $val) {
			
			if (isset($fmCategoryNameArr[$val['fm_category_code']]) !== true)
				$fmCategoryNameArr[$val['fm_category_code']]	= $this->categorymodel->get_category_name($val['fm_category_code']);
				
				$categoryList['resultList'][$key]['fmCategoryName']			= $fmCategoryNameArr[$val['fm_category_code']];
				$categoryList['resultList'][$key]['requiredAddInfoSummery']	= $fmCategoryNameArr[$val['fm_category_code']];
				
		}

		$params['totalCount']	= $categoryList['totalCount'];
		$params['searchCount']	= $categoryList['searchCount'];
		$search					= json_encode($params);
		
		$totalPage		= ceil($params['searchCount'] / $params['limit']);
		$pageLimit		= 10;
		$nowEndPage		= ($params['page'] <= $pageLimit) ? $pageLimit : (ceil($params['page'] / $pageLimit)) * $pageLimit;
		$nowStartPage	= ($params['page'] < $pageLimit) ? 1 : $nowEndPage - $pageLimit + 1;
		$nowEndPage		= ($nowEndPage > $totalPage) ?  $totalPage :  $nowEndPage;
		$pages			= array();
		for($i = $nowStartPage; $i <= $nowEndPage; $i ++)
			$pages[]	= $i;
			
			$paging			= pagingtagjs($params['page'],$pages,$totalPage,'movePage([:PAGE:]);', $pageLimit);
			
			$this->template->assign(array(
							'list'			=> $categoryList['resultList'],
							'paging'		=> $paging,
							'search'		=> $search,
							'sc'			=> $params,
			));
			
			return "/market_connector/shoplinker_category_matching.html";
	}
	
	/**
	 * 샵링커 영역
	 */	

	public function account_add_popup() {
		$this->admin_menu();
		$this->tempate_modules();
		$supportMarketList	= $this->_connectorBase->getSupportMarkets($market);
		unset($supportMarketList['shoplinker']);

		$market				= $this->input->get('market');
		$market				= (trim($market)) ? trim($market) : key($supportMarketList);
		$accountForm		= $this->market_account_setting($market);


		$file_path			= $this->template_path();
		$this->template->assign('supportMarketList', $supportMarketList);
		$this->template->define(array('ACCOUNT_FORM' => $this->skin.$accountForm));
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function category_matching($market, $sellerId){
		$this->admin_menu();
		$this->tempate_modules();
		$this->load->model('categorymodel');

		$params				= $this->input->get();
		$params['market']	= $market;
		$params['sellerId']	= $sellerId;
		$params['page']		= ((int)$params['page'] > 0) ? (int)$params['page'] : 1;
		$params['limit']	= ((int)$params['perpage'] > 0) ? (int)$params['perpage'] : 10;
		$totalCount			= ((int)$params['totalCount'] < 1 || $params['page'] == 1) ? true : false;

		$depCnt				= 1;
		$fmCategoryCode		= null;

		while (isset($params["searchCategory{$depCnt}"]) === true) {
			$nowCategoryCode	= trim($params["searchCategory{$depCnt}"]);
			if (strlen($nowCategoryCode) == $depCnt * 4) {
				$params['fmCategoryCode']	= $nowCategoryCode;
		}
			
			$depCnt++;

		}

		$categoryList			= $this->connectormodel->getMatchCategoryList($params, 'forViewList', $totalCount);
		$fmCategoryNameArr		= array();

		foreach ((array)$categoryList['resultList'] as $key => $val) {

			if (isset($fmCategoryNameArr[$val['fm_category_code']]) !== true)
				$fmCategoryNameArr[$val['fm_category_code']]	= $this->categorymodel->get_category_name($val['fm_category_code']);
			
			$categoryList['resultList'][$key]['fmCategoryName']			= $fmCategoryNameArr[$val['fm_category_code']];
			$categoryList['resultList'][$key]['requiredAddInfoSummery']	= $fmCategoryNameArr[$val['fm_category_code']];

		}
		
		$params['totalCount']	= $categoryList['totalCount'];
		$params['searchCount']	= $categoryList['searchCount'];
		
		$search					= json_encode($params);
		
		$totalPage		= $params['totalCount'];
		$pageLimit		= ceil($params['totalCount']/$params['limit']);
		$endPage		= ceil($params['page']/$params['limit']) * $params['limit'];
		$nowEndPage		= ($pageLimit <= $endPage) ? $pageLimit : $endPage;
		$nowStartPage	= ($params['page'] <= $params['limit']) ? 1 : ($endPage - $params['limit']) + 1;
		$pages			= array();
		for($i = $nowStartPage; $i <= $nowEndPage; $i ++)
			$pages[]	= $i;

		$paging			= pagingtagjs($params['page'], $pages, $pageLimit, 'movePage([:PAGE:]);', $pageLimit);

		$this->template->assign(array(
			'list'			=> $categoryList['resultList'],
			'paging'		=> $paging,
			'search'		=> $search,
			'sc'			=> $params,
		));

		return "/market_connector/category_matching.html";
	}

	public function add_info_list($market, $sellerId){

		$params					= $this->input->get();
		$params['market']		= $market;
		$params['sellerId']		= $sellerId;
		$params['page']			= ((int)$params['page'] > 0) ? (int)$params['page'] : 1;
		$params['limit']		= ((int)$params['limit'] > 0) ? (int)$params['limit'] : 10;
		$totalCount				= ((int)$params['totalCount'] < 1 || $params['page'] == 1) ? true : false;

		$addInfo				= $this->connectormodel->getAddInfoList($params, 'forViewList', $totalCount);

		$params['totalCount']	= $addInfo['totalCount'];
		$search					= json_encode($params);
		

		$totalPage		= ceil($params['totalCount'] / $params['limit']);
		$pageLimit		= 10;
		$nowEndPage		= ($params['page'] <= $pageLimit) ? $pageLimit : (ceil($params['page'] / $pageLimit)) * $pageLimit;
		$nowStartPage	= ($params['page'] < $pageLimit) ? 1 : $nowEndPage - $pageLimit + 1;
		$nowEndPage		= ($nowEndPage > $totalPage) ?  $totalPage :  $nowEndPage;
		$pages			= array();
		for($i = $nowStartPage; $i <= $nowEndPage; $i ++)
			$pages[]	= $i;

		$paging		= pagingtagjs($params['page'],$pages,$totalPage,'movePage([:PAGE:]);', $pageLimit);

		$this->template->assign(array(
			'list'		=> $addInfo['resultList'],
			'paging'	=> $paging,
			'search'	=> $search
		));

		return "/market_connector/add_info_list.html";
	}


	public function distributor(){
		$this->admin_menu();
		$this->tempate_modules();
		
		$MarketLinkage	= config_load('MarketLinkage');
		
		if($MarketLinkage['shopCode'] == 'shoplinker'){
			$useMarketList	= $this->connectormodel->getUseShoplinkerMarketList();
			if(!$useMarketList){
				$redirctUri = "/admin/market_connector/market_setting?pageMode=AccountSet";
				pageLocation($redirctUri, "설정된 마켓이 없습니다. 마켓 추가 후 이용 가능합니다.");
				exit;
			}
		}
		
		$param = array();
		$scmLoginList	= $this->connectormodel->getLinkageMarket($param);
		
		$params				= $this->input->get();
		$params['page']		= ((int)$params['page'] > 0) ? (int)$params['page'] : 1;
		$params['limit']	= ((int)$params['limit'] > 0) ? (int)$params['limit'] : 10;
		$totalCount			= ((int)$params['totalCount'] < 1 || $params['page'] == 1) ? true : false;

		if($MarketLinkage['shopCode'] == "shoplinker"){
			$distributor = $this->skin."/market_connector/shoplinker_distributor.html";
		}else{
			$distributor = $this->skin."/market_connector/firstmall_distributor.html";
		}
		
		$this->market_common_js_css('distributor');

		$file_path	= $this->template_path();
		$this->template->assign(array(
			'params' => $params,
			'MarketLinkage' => $MarketLinkage,
			'scmLoginList' => $scmLoginList
					
		));

		
		$this->template->define(array(
			'tpl' => $file_path,
			'distributor' => $distributor
						
		));
		$this->template->print_("tpl");
	}

	
	public function market_product_list(){
		$this->admin_menu();
		$this->tempate_modules();
		
		$params	= $this->input->get();

		$onlyMarket		= false;
		if (count($params['market']) == 1)
			$onlyMarket	= $params['market'][0];

		$MarketLinkage	= config_load('MarketLinkage');
		
		if($MarketLinkage['shopCode'] == 'shoplinker'){
			$useMarketList	= $this->connectormodel->getUseShoplinkerMarketList();
			if(!$useMarketList){
				$redirctUri = "/admin/market_connector/market_setting?pageMode=AccountSet";
				pageLocation($redirctUri, "설정된 마켓이 없습니다. 마켓 추가 후 이용 가능합니다.");
				exit;
			}
		}

		$param = array();
		$scmLoginList	= $this->connectormodel->getLinkageMarket($param);
		$confMarket = $MarketLinkage['shopCode'];
	
		if (count($params) > 0)
			$search		= json_encode($params);
		else
			$search		= '{}';

		$this->market_common_js_css('product_list');

		$file_path	= $this->template_path();
		$this->template->assign(array('search' => $search, 'onlyMarket' => $onlyMarket, 'confMarket'=>$confMarket, 'MarketLinkage' => $MarketLinkage, 'scmLoginList' => $scmLoginList));
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}


	public function coupang_add_info()		{$this->_addInfoSet('coupang');}	//쿠팡 추가정보
	public function open11st_add_info()		{$this->_addInfoSet('open11st');}	//11번가 추가정보
	public function storefarm_add_info()	{$this->_addInfoSet('storefarm');}	//스마트스토어 추가정보
		

	protected function _addInfoSet($market, $displayMmode = 'popup') {
		$this->load->helper('shipping');

		if ($displayMmode == 'popup') {
			$this->admin_menu();
			$this->tempate_modules();
			$this->template->assign('market', $market);
		}

		$fmMarketProduceSeq		= (int)$this->input->get('fmMarketProduceSeq');

		if ((int)$this->input->get('add_info_seq') > 0) {
			$addInfoData	= $this->connectormodel->getMarketAddInfo($this->input->get('add_info_seq'));
			$this->template->assign([
				'mode'					=> 'renew',
				'add_info_seq'			=> $this->input->get('add_info_seq'),
				'seller_id'				=> $addInfoData['seller_id'],
				'addInfo'				=> json_encode($addInfoData),
			]);
		} else if($fmMarketProduceSeq > 0) {
			$marketProductInfo			= $this->connectormodel->getMarketProductList(array('fmMarketProduceSeq' => $fmMarketProduceSeq), 'fullInfo');

			$addInfoData				= array();
			$addInfoData				= $this->connectormodel->getMarketAddInfo($marketProductInfo[0]['add_info_seq']);

			$addInfoData['market']		= $marketProductInfo[0]['market'];
			$addInfoData['seller_id']	= $marketProductInfo[0]['seller_id'];
			$addInfoData				= array_merge($addInfoData, $marketProductInfo[0]['market_add_info']);
			$addInfoData				= array_merge($addInfoData, $marketProductInfo[0]['category_info']);

			unset($addInfoData['fmMarketProduceSeq']);

			$this->template->assign([
				'mode'					=> 'marketRenew',
                'add_info_seq'			=> $addInfoData['seq'],
                'seller_id'				=> $addInfoData['seller_id'],
				'addInfo'				=> json_encode($addInfoData),
                'marketProductCode'		=> $marketProductInfo[0]['market_product_code'],
                'marketProductName'		=> $marketProductInfo[0]['market_product_name'],
				'fmMarketProduceSeq'	=> $fmMarketProduceSeq
            ]);

		} else {
			$this->template->assign([
				'mode'					=> 'register',
				'seller_id'				=> $this->input->get('sellerId'),
				'addInfo'				=> '{}',
			]);
		}

		$this->template->assign('displayMmode', $displayMmode);

		$deliveryCompanyList = get_shipping_company_provider();
		$this->template->assign('deliveryCompanyList', $deliveryCompanyList);

		if ($displayMmode == 'popup') {
			$file_path	= $this->template_path();
			$this->template->define(array('tpl'=>$file_path));
			$this->template->print_("tpl");
		}
	}
	
	public function market_order_list() {
		
		$this->admin_menu();
		$this->tempate_modules();
		$file_path		= $this->template_path();
		
		$params			= $this->input->get();
		$search			= json_encode($params);

		$MarketLinkage	= config_load('MarketLinkage');
		
		if($MarketLinkage['shopCode'] == 'shoplinker'){
			$useMarketList	= $this->connectormodel->getUseShoplinkerMarketList();
			if(!$useMarketList){
				$redirctUri = "/admin/market_connector/market_setting?pageMode=AccountSet";
				pageLocation($redirctUri, "설정된 마켓이 없습니다. 마켓 추가 후 이용 가능합니다.");
				exit;
			}
		}
		
		$param 			= array();
		$scmLoginList	= $this->connectormodel->getLinkageMarket($param);
		
		$this->template->assign(array('search'=> $search, 'MarketLinkage' => $MarketLinkage, 'scmLoginList' => $scmLoginList));

		$this->market_common_js_css('ORD');	// js, css

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}
	
	
	public function market_exchange_list()	{$this->market_claim_list('EXC');}
	public function market_return_list()	{$this->market_claim_list('RTN');}
	public function market_cancel_list()	{$this->market_claim_list('CAN');}


	public function market_claim_list($claimType) {
		
		switch ($claimType) {
			case	'RTN' :
				$claimTitle	= "반품";
				break;
			case	'EXC' :
				$claimTitle	= "교환";
				break;
			default	:
				$claimTitle	= "취소";
		}

		$this->admin_menu();
		$this->tempate_modules();
		
		$MarketLinkage	= config_load('MarketLinkage');
		
		if($MarketLinkage['shopCode'] == 'shoplinker'){
			$useMarketList	= $this->connectormodel->getUseShoplinkerMarketList();
			if(!$useMarketList){
				$redirctUri = "/admin/market_connector/market_setting?pageMode=AccountSet";
				pageLocation($redirctUri, "설정된 마켓이 없습니다. 마켓 추가 후 이용 가능합니다.");
				exit;
			}
		}
		
		$param 							= array();
		$scmLoginList					= $this->connectormodel->getLinkageMarket($param);
		
		$params							= $this->input->get();
		$search							= json_encode($params);
		
		$claimInfo['claim_title']		= $claimTitle;
		$claimInfo['claim_type']		= $claimType;
		$claimInfo['search']			= $search;
		$claimInfo['MarketLinkage']		= $MarketLinkage;
		$claimInfo['scmLoginList']		= $scmLoginList;

		$this->market_common_js_css($claimType);

		$file_path	= "default/market_connector/market_claim_list.html";
		$this->template->assign($claimInfo);
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function market_common_js_css($mode='ORD'){
		
		// js, css
		requirejs([
			["/app/javascript/plugin/jsGrid/src/jsgrid.core.js", 0],
			["/app/javascript/plugin/jsGrid/src/jsgrid.load-indicator.js", 10],
			["/app/javascript/plugin/jsGrid/src/jsgrid.load-strategies.js", 20],
			["/app/javascript/plugin/jsGrid/src/jsgrid.sort-strategies.js", 30],
			["/app/javascript/plugin/jsGrid/src/jsgrid.field.js", 40],
			["/app/javascript/plugin/jsGrid/src/i18n/kr.js", 50],
			["/app/javascript/plugin/jsGrid/jsGridCommon.js", 60],

			["/app/javascript/plugin/jsGrid/css/jsgrid.css",10],
			["/app/javascript/plugin/jsGrid/css/theme.css",20],
			["/admin/skin/default/css/market_connector.css",40],
		  ]);

		  if($mode != 'distributor'){
			requirejs([
				["/app/javascript/plugin/multiple-select.js", 70],
				["/app/javascript/js/admin-connectorCommon.js", 80],
				["/app/javascript/js/admin/gSearchForm.js", 90],
				["/admin/skin/default/css/multiple-select.css",30]
			]);
		  }

		  switch ($mode) {
			case	'RTN' :
			case	'EXC' :
			case	'CAN' :
				requirejs("/app/javascript/js/admin-marketClaimList.js", 100);
				requirejs("/app/javascript/js/admin-marketClaimList.js", 100);
			break;
			case	'QNA' :
				requirejs("/app/javascript/js/admin-marketQnaList.js", 100);
			break;
			case 'distributor':
				requirejs([
					["/app/javascript/js/admin-marketDistributor.js", 80],
					["/app/javascript/js/admin/gGoodsSelectList.js", 90],
					["/app/javascript/js/admin/marketConnectorRegist.js", 100],
				]);
			break;
			case 'product_list':
				requirejs("/app/javascript/js/admin-marketProductList.js", 100);
			break;
			default:
				requirejs("/app/javascript/js/admin-marketOrderList.js", 100);
			break;
		  }
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

	/***
	 * 상품문의 리스트
	 */
	public function market_qna_list() {
		$this->admin_menu();
		$this->tempate_modules();
		
		$MarketLinkage	= config_load('MarketLinkage');
		
		if($MarketLinkage['shopCode'] == 'shoplinker'){
			$useMarketList	= $this->connectormodel->getUseShoplinkerMarketList();
			if(!$useMarketList){
				$redirctUri = "/admin/market_connector/market_setting?pageMode=AccountSet";
				pageLocation($redirctUri, "설정된 마켓이 없습니다. 마켓 추가 후 이용 가능합니다.");
				exit;
			}
		}

		$params		= $this->input->get();
		$search		= json_encode($params);

		$qnaInfo['search']			= $search;
		$qnaInfo['MarketLinkage']	= $MarketLinkage;

		$this->template->assign($qnaInfo);

		$this->market_common_js_css('QNA');	// js, css

		$this->template->define(array(
			'tpl' => $this->template_path()
		));
		
		$this->template->print_("tpl");
	}

	/***
	 * 상품문의 처리 리스트
	 */
	public function getMarketQnaLog() {

		$fmMarketQnaSeq	= $this->input->get('seqList');
		$response			= $this->connectormodel->getMarketQnaLog($fmMarketQnaSeq);

		$this->template->assign(array('message'=>$response));

		$tpl = "default/market_connector/market_qna_log.html";
		$this->template->define(array('tpl'=>$tpl));
		$this->template->print_("tpl");

	}

	/**
	 * 주문/환불/반품/교환 수집창 불러오기
	 */
	public function getOrderCollection($mode){

		$mode = $this->input->get('mode');

		$title = "";
		switch($mode){
			case "CAN":
				$title 		= "취소 요청일";
				$guidemsg 	= "오픈 마켓 취소 요청은 30분 마다 자동으로 수집합니다.";
			break;
			case "RTN":
				$title 		= "반품 요청일"; 
				$guidemsg 	= "오픈 마켓 반품 요청은 30분 마다 자동으로 수집합니다.";	
			break;
			case "EXC":
				$title 		= "교환 요청일"; 	
				$guidemsg 	= "오픈 마켓 교환 요청은 30분 마다 자동으로 수집합니다.";	
			break;
			case "QNA":
				$title 		= "문의 수집일";	
				$guidemsg 	= "오픈 마켓 문의는 30분 마다 자동으로 수집합니다.";	
			break;
			default :
				$title 		= "날짜";
				$guidemsg 	= "오픈 마켓 주문은 30분 마다 자동으로 수집합니다.";
			break;
		}

		$this->template->assign(array('title'=>$title,'guidemsg'=>$guidemsg));
		$this->template->assign('mode',$mode);

		$tpl = "default/market_connector/_order_collect.html";
		$this->template->define(array('tpl'=>$tpl));
		$this->template->print_("tpl");

	}
}