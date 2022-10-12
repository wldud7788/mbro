<?php
class ServiceBase
{
	protected $_Response;
	protected $_RequestBody;
	protected $_RequestUri;
	protected $_StatusCodeList;
	protected $_CipherMethod	= 'aes-128-cbc';
	
	protected $_MarketConnectorClause;
	protected $_FmAccessKey;
	protected $_FmSecureKey;
	protected $_CI;
	protected $_Market;
	protected $_SellerId;
	protected $_MarketAuth;
	protected $_MarketAuthList;
	protected $_DevMode	= false;

	protected $_devServerList		= array();	// array('121.78.114.51', '121.78.197.232'); QA 서버에서도 정상 동작이 필요하여 예외처리 제거
	protected $_supportMarkets;

	public function __construct($params = array())
	{
		$this->_CI		=& get_instance(); 

		$FmAuthInfo		= config_load('ConnectorAuth');

		if (strlen($FmAuthInfo['access_key']) == 36) {
			$this->_FmAccessKey		= $FmAuthInfo['access_key'];
			$this->_FmSecureKey		= $FmAuthInfo['secret_key'];
		}

		if (isset($params['market']) == true && isset($params['sellerId']) == true)
			$this->setMarketInfo($params['market'], $params['sellerId']);

		// dev 모드 시 주석 해제
		//$this->_DevMode		= true;

		$this->_supportMarkets	= $this->getSupportMarkets();

	}

	/* 주문 지원 마켓 및 상품 링크 */
	public function getSupportMarkets() {
		$markets['open11st']['name']			= '11번가';
		$markets['open11st']['productLink']		= 'http://www.11st.co.kr/product/SellerProductDetail.tmall?method=getSellerProductDetail&prdNo=%marketProductCode%';

		$markets['coupang']['name']				= '쿠팡';
		$markets['coupang']['productLink']		= 'http://www.coupang.com/vp/products/%confirmedProductCode%';

		$markets['storefarm']['name']			= '스마트스토어';
		$markets['storefarm']['productLink']	= 'http://storefarm.naver.com/%storefarmUrl%/products/%marketProductCode%';
		
		//$markets['auction']['name']				= '옥션';
		//$markets['auction']['productLink']		= 'http://itempage3.auction.co.kr/DetailView.aspx?itemno=%marketProductCode%';
		
		//$markets['gmarket']['name']				= 'G마켓';
		//$markets['gmarket']['productLink']		= 'http://item.gmarket.co.kr/detailview/Item.asp?goodscode=%marketProductCode%';
		
		return $markets;
	}

	public function getMarketAccount($mode = 'all')
	{
		$find			= $this->_CI->db->query("SELECT * FROM fm_market_account WHERE market = ? AND seller_id = ?", [$this->_Market, $this->_SellerId]);
		$findRow		= $find->result();

		if (count($findRow) > 0) {
			switch($mode) {
				case	'marketAuthInfo' :
					return json_decode($findRow[0]->market_auth_info, 1);
					break;
				
				case	'marketOtherInfo' :
					return json_decode($findRow[0]->market_other_info, 1);
					break;
				
				default :
					$accountInfo	= array();
					$accountInfo['marketAuthInfo']	= json_decode($findRow[0]->market_auth_info, 1);
					$accountInfo['marketOtherInfo']	= json_decode($findRow[0]->market_other_info, 1);
					return $accountInfo;


			}
			
		} else {
			return false;
		}
	}

	// 마켓 연동을 위한 API Key 가져오기
	public function getFmAccessInfo()
	{
		$return['AccessKey']	= $this->_FmAccessKey;
		$return['SecretKey']	= $this->_FmSecureKey;

		return $return;
	}


	// 마켓 정보 설정
	public function setMarketInfo($market, $sellerId = Null)
	{

		$this->_Market			= strtolower($market);
		$this->_SellerId		= $sellerId;
		$this->_MarketAuth		= Null;
		
		if (isset($this->_MarketAuthList[$this->_Market][$this->_SellerId]) === true) {
			$this->_MarketAuth	= $this->_MarketAuthList[$this->_Market][$this->_SellerId];
		} else {
			$this->_MarketAuth	= $this->getMarketAccount('marketAuthInfo');
			$this->_MarketAuthList[$this->_Market][$this->_SellerId]	= $this->_MarketAuth;
		}

	}

	// 마켓 정보 가져오기
	public function getMarketInfo()
	{
		$return['market']	= $this->_Market;
		$return['sellerId']	= $this->_SellerId;

		return $return;
	}
	
	// 샵링커 인증 정보 가져오기
	public function getShoplinkerMarketAuthInfo()
	{
		$return['mallId']	= $this->_MarketAuth['mallId'];
		$return['userId']	= $this->_MarketAuth['userId'];
		$return['customerId']	= $this->_MarketAuth['customerId'];
		
		return $return;
	}

	// ASE 암호화
	public function AesEncrypt($plainText)
	{
		$ivLen			= openssl_cipher_iv_length($this->_CipherMethod);
		$iv				= openssl_random_pseudo_bytes($ivLen);
		$password		= hash('sha256', $this->_FmSecureKey, true);
		$cipherText		= openssl_encrypt($plainText, $this->_CipherMethod, $password, true, $iv);
		$hmac			= hash_hmac('sha256', $cipherText, $password, true);

		return base64_encode("{$cipherText}{$iv}{$hmac}");
	}

	// ASE 복호화
	public function AesDecrypt($fullCipherText) {
		$fullCipherText		= @base64_decode($fullCipherText, true);

		if ($fullCipherText === false)
			return false;

		$fullChipherLen	= strlen($fullCipherText);
		$ivLen			= openssl_cipher_iv_length($this->_CipherMethod);
		$checkSumLen	= 32 + $ivLen;

		if ($fullChipherLen < $checkSumLen)
			return false;

		$iv			= substr($fullCipherText, $fullChipherLen - $checkSumLen, $ivLen);
		$hmac		= substr($fullCipherText, $fullChipherLen - 32, 32);
		$cipherText	= substr($fullCipherText, 0, $fullChipherLen - $checkSumLen);

		$password	= hash('sha256', $this->_FmSecureKey, true);
		$hmacCheck	= hash_hmac('sha256', $cipherText, $password, true);

		if ($hmac !== $hmacCheck)
			return false;

		return openssl_decrypt($cipherText, $this->_CipherMethod, $password, true, $iv);
	}

	public function isDevMode() {return $this->_DevMode;}

	/* 마켓연동 호출 URL */
	public function getConnectorUrl() {

		//개발 서버 접속
		if ($this->_DevMode == true)
			return 'http://openmarketdev.firstmall.kr';
		else
			return 'http://openmarket.firstmall.kr';
	}

	// 연동서버 사용 인증
	protected function _HmacGenerate($method, $uri, $body = '') {
		$dateTimeObj	= new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('ASIA/SEOUL'));
		$dateTime		= $dateTimeObj->format("Y-m-d H:i:s T");

		$target			= strtolower("{$method} {$uri}");
		$message[]		= "(request-target): {$target}";
		$message[]		= "datetime: {$dateTime}";

		if (strlen($body) > 0) {
			$message[]	= "content-length: ".strlen($body);
			$headers	= "(request-target) datetime content-length";
		} else {
			$headers	= "(request-target) datetime";
		}

		$signedMessage	= base64_encode(hash_hmac('SHA256', implode("\n", $message), $this->_FmSecureKey, true));
		
		$signature		= array();
		$signature[]	= 'keyId="'.$this->_FmAccessKey.'"';
		$signature[]	= 'algorithm="hmac-sha256"';
		$signature[]	= 'headers="'.$headers.'"';
		$signature[]	= 'signature="'.$signedMessage.'"';
		
		$return['DateTime']		= $dateTime;
		$return['Signature']	= implode(',', $signature);

		return $return;
	}

	/* 마켓연동 호출 */

	protected function _call($requestUri, $requestBody) {

		$header				= array();
		$this->_Response	= Null;
		$this->_RequestBody	= $requestBody;
		$this->_RequestUri	= $requestUri;


		if (is_array($requestBody) === true) {
			$method		= 'post';
			$body		= json_encode($requestBody);
			$header[]	= 'Content-Type: Application/json';
		} else {
			$method		= 'get';
			$body		= '';
		}

		$hmacInfo		= $this->_HmacGenerate($method, $requestUri, $body);

		$header[]		= "AccessKey: {$this->_FmAccessKey}";
		$header[]		= "DateTime: {$hmacInfo['DateTime']}";
		$header[]		= "Signature: {$hmacInfo['Signature']}";

		$connectorUrl	= $this->getConnectorUrl();
		$actionUrl		= "{$connectorUrl}{$requestUri}";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_URL, $actionUrl);

		if ($method != 'get') {
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		} else {
			curl_setopt($ch, CURLOPT_POST, false);
		}

		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$this->_Response	= curl_exec($ch);
	}
	
	/* GET Method Call */
	public function callGetConnector($url, $mode = 'Array'){ return $this->callConnector($url, false, $mode);}

	/* Support Call */
	public function callOtherConnector($url, $target = 'support', $postValue = false, $mode = 'Array')
	{
		$target				= ucfirst(strtolower($target));

		if ($this->_MarketAuth != false) {
			if (is_array($postValue) !== true)
				$postValue		= array();

			$postValue['auth']	= $this->_MarketAuth;
		}
		
		$callUri			= "/connector/{$target}/{$url}";
		$this->_call($callUri, $postValue);

		return $this->getLastResult($mode);
	}

	/* POST Method Call */
	public function callConnector($url, $postValue = false, $mode = 'Array')
	{
		$market				= ucfirst(strtolower($this->_Market));

		$this->_Response	= Null;

		if ($this->_MarketAuth != false) {
			if (is_array($postValue) !== true)
				$postValue		= array();

			$postValue['auth']	= $this->_MarketAuth;
		}
		
		if(stripos($market,"API") !== false){
			$callUri			= "/connector/shoplinker/{$url}";
		}else{
			$callUri			= "/connector/{$market}/{$url}";
		}

		$this->_call($callUri, $postValue);

		return $this->getLastResult($mode);
	}


	public function queueConnector($url, $postValue = false, $callbackUrl = false, $mode = 'Array') {
		$market				= ucfirst(strtolower($this->_Market));

		$this->_Response	= Null;

		if ($this->_MarketAuth != false) {
			if (is_array($postValue) !== true)
				$postValue		= array();

			$postValue['auth']	= $this->_MarketAuth;
		}
		
		if ($callbackUrl !== false) {
			
			// 접속한 도메인으로 응답받도록 수정 2019-04-29
			$domain									= $_SERVER['HTTP_HOST'];

			$postValue['callback']['use']			= true;
			$postValue['callback']['uri']			= get_connet_protocol()."{$domain}{$callbackUrl}";
			$postValue['callback']['callbackAuth']	= $this->AesEncrypt($callbackUrl);

		}

		if(stripos($market,"API") !== false){
			$callUri			= "/queue/shoplinker/{$url}";
		}else{
			$callUri			= "/queue/{$market}/{$url}";
		}

		//$callUri			= "/queue/{$market}/{$url}";
		$this->_call($callUri, $postValue);

		return $this->getLastResult($mode);
	}


	/* Response Value Return */
	public function getLastResult($returnType = 'Array')
	{
		$returnType			= ucfirst(strtolower($returnType));	
		switch ($returnType) {
			case	'Json' :
				$return		= $this->_Response;
				break;
			
			case	'Object' :
				$return		= json_decode($this->_Response);
				break;
			
			case	'Array' :
			default :
				$return		= json_decode($this->_Response, true);

		}

		return $return;
	}

	/* Request Value Return*/
	public function getLastRequest($target = 'all')
	{
		$target			= strtolower($target);	
		switch($target) {
			case	'uri' :
				return $this->_RequestUri;
				break;
			
			case	'body' :
				return $this->_RequestBody;
				break;
			
			default :
				$return['uri']	= $this->_RequestUri;
				$return['body']	= $this->_RequestBody;
				return $return;
				break;
		}
	}


	/* 상태 코드 리스트 'order' 'product' */
	public function getStatusCode($target = 'order') {
		if (count($this->_StatusCodeList) < 1) {
			$allStatusCodeList		= $this->callOtherConnector("CodeList/getAllStatusCode");
			$this->_StatusCodeList	= $allStatusCodeList['resultData'];
		}

		return $this->_StatusCodeList[$target];
	}


	/* 매칭 카테고리명 배열 리턴*/
	public function makeMarketCategoryName($inCategoryArr) {
		$category	= array();

		if ($inCategoryArr['dep1_category_name'])
			$category[]	= $inCategoryArr['dep1_category_name'];

		if ($inCategoryArr['dep2_category_name'])
			$category[]	= $inCategoryArr['dep2_category_name'];

		if ($inCategoryArr['dep3_category_name'])
			$category[]	= $inCategoryArr['dep3_category_name'];
		
		if ($inCategoryArr['dep4_category_name'])
			$category[]	= $inCategoryArr['dep4_category_name'];

		if ($inCategoryArr['dep5_category_name'])
			$category[]	= $inCategoryArr['dep5_category_name'];

		if ($inCategoryArr['dep6_category_name'])
			$category[]	= $inCategoryArr['dep6_category_name'];

		return $category;
	}

	// 옵션 매칭용 Text 반환
	public function forMatchingOptionText($inOptionText) { return trim(preg_replace('/[\s+|:+|,+|\/+|\?+]/', '', $inOptionText)); }
	public function forMatchingText($inText) { return trim(preg_replace('/[\s+]/', '', $inText)); }

	function checkNumberValue($input) {
		$checkNumber	= preg_replace('/([^0-9|^.])/', '', $input);

		if ($checkNumber != $input)
			return false;
		else
			return true;
	}

	## 오픈마켓 관련 파일로그
	public function connectorFileLog($filename, $content){
		$logDir = ROOTPATH."/data/logs/connector/";
		if(!is_dir($logDir)){
			mkdir($logDir);
			@chmod($logDir,0777);
		}
		$fp = fopen($logDir.$filename,"a+");
		fwrite($fp,"[".date('Y-m-d H:i:s')."] - ");
		fwrite($fp,$content . "\r\n");
		fclose($fp);
	}
}