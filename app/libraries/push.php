<?php
class Push
{
	protected $_system;
	protected $_params;
	protected $_kind;
	protected $_unique;
	protected $_title;
	protected $_msg;
	protected $_provider;
	protected $_admin_done;
	protected $_debug;
	protected $_Response;
	protected $_RequestBody;
	protected $_RequestUri;
	protected $_validPush = false;
	protected $_shopSno;
	protected $_CI;
	protected $_devServerList		= array('121.78.114.51', '121.78.197.230');

	protected $_defTitle = array(
		'order_view'		=> '{shopName} (주문접수)',
		'order_deposit'		=> '{shopName} (결제확인)',
		'mbqna'				=> '{shopName} (1:1문의)',
		'goods_qna'			=> '{shopName} (상품문의)',
		'gs_seller_qna'		=> '{shopName} (입점사문의)',
		'gs_seller_notice'	=> '{shopName} (공지)'
	);

	protected $_defContent = array(
		'order_view'		=> '{ord_item}의 주문이 접수되었습니다.',
		'order_deposit'		=> '{userid}님 주문({ordno})이 결제확인 되었습니다.',
		'mbqna'				=> '{userid}님의 1:1문의가 접수되었습니다.',
		'goods_qna'			=> '{goods_name}의 상품문의가 접수되었습니다.',
		'gs_seller_qna'		=> '{provider_name}입점사의 문의가 접수되었습니다.',
		'gs_seller_notice'	=> '입점사 공지사항이 접수되었습니다.'
	);

	public function __construct($params = array()){
		$this->_system			= config_load('system');
		$this->_CI				=& get_instance();
		$this->_shopSno			= $this->_CI->config_system['shopSno'];
		$this->_domain			= str_replace('.firstmall.kr','',$this->_system['subDomain']);

		if (array_search($_SERVER['SERVER_ADDR'], $this->_devServerList) !== false)
			$this->_DevMode		= true;
	}

	public function set($var, $val) {
		$this->$var = $val;
	}

	public function valid_check() {
		$multi					= array_keys($this->_CI->config_system['dbs']);
		foreach($multi as $key)
			if	(md5($key) == config_load('system')['push_token']) 	$this->_validPush	= true;
		return $this->_validPush;
	}

	/* queue 정의 */
	public function pushInsert($mode = 'Array') {
		if	(!$this->_validPush) return;
		$this->_Response			= Null;

		$params						= $this->_params;
		$params['shopName']			= $this->_CI->config_basic['shopName'];

		$title	= $this->_title ? $this->_title : $this->_convert($this->_defTitle[$this->_kind], $params);
		$msg	= $this->_msg ? $this->_msg : $this->_convert($this->_defContent[$this->_kind], $params);

		$postValue['shopSno']		= $this->_shopSno;
		$postValue['domain']		= $this->_domain;
		$postValue['title']			= $title;
		$postValue['msg']			= $msg;
		$postValue['kind']			= $this->_kind;
		$postValue['unique']		= $this->_unique;
		$postValue['provider']		= $this->_provider;
		$postValue['admin_done']	= $this->_admin_done;
		$postValue['debug']			= $this->_debug;

		$callUri					= "/set";
		$this->_call($callUri, $postValue);

		return $this->_getLastResult($mode);
	}

	protected function _convert($str, $params) {
		foreach( $params as $k => $v ) $str = str_replace('{'.$k.'}', $v, $str);
		return $str;
	}


	/* 푸시 등록 */

	protected function _call($requestUri, $requestBody) {

		$header				= array();
		$this->_Response	= Null;
		$this->_RequestBody	= $requestBody;
		$this->_RequestUri	= $requestUri;

		if (is_array($requestBody) === true) {
			$method		= 'post';
			$body		= json_encode($requestBody);
			$header[]	= 'Content-Type: Application/json';
			$header[]	= 'Requst_url: '.$this->_CI->config_system['domain'];
		} else {
			$method		= 'get';
			$body		= '';
		}

		$connectorUrl	= $this->_getConnectorUrl();
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

	/* Response Value Return */
	public function _getLastResult($returnType = 'Array') {
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

	/* 호출 URL */
	public function _getConnectorUrl() {

		//개발 서버 접속
		if ($this->_DevMode == true)
			return 'https://push.firstmall.kr';
		else
			return 'https://push.firstmall.kr';
	}
}