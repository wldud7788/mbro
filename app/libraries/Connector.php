<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once ROOTPATH . "app/libraries/connector/market_goods/MarketGoods.php";
require_once ROOTPATH . "app/libraries/connector/market_goods/MarketGoodsInterface.php";
require_once ROOTPATH . "app/libraries/connector/ServiceBase.php";

// 마켓연동 서비스
$fulPath	= ROOTPATH."app/libraries/connector";
$handle		= opendir($fulPath);
while ($file = readdir($handle)) {
	$checkText		= strtolower($file);

	if (preg_match("/service.php$/", $checkText) === 1)
		require_once  "$fulPath/{$file}";
}
closedir($handle);

// 마켓연동 상품 매칭
$fulPath	= ROOTPATH."app/libraries/connector/market_goods";
$handle		= opendir($fulPath);
while ($file = readdir($handle)) {
	$checkText		= strtolower($file);

	if (preg_match("/^marketgoods_/", $checkText) === 1)
		require_once "{$fulPath}/{$file}";
}
closedir($handle);


Class Connector
{
	
	public static $market;
	public static $sellerId;
	private static $__instance	= array();
	
	public function __construct($params = array())
	{
		self::$market	= (isset($params['market']) === true) ? $params['market'] : Null;		
		self::$sellerId	= (isset($params['sellerId']) === true) ? $params['sellerId'] : Null;
	}

	public static function getInstance($service = 'basic', $params = array())
	{

		$service		= strtolower($service);

		self::$market	= (isset($params['market']) === true) ? $params['market'] : self::$market;
		self::$sellerId	= (isset($params['sellerId']) === true) ? $params['sellerId'] : self::$sellerId;
	
		if (isset(self::$__instance[$service]) === false) {
			
			$params		= array();

			if (self::$market != null && self::$sellerId != null) {
				$params['market']	= self::$market;
				$params['sellerId']	= self::$sellerId;
			}

			$targetMarket	= ucfirst($service);
			$className		= "{$targetMarket}Service";
			self::$__instance[$service]		= new $className($params);

		} else if (self::$market != null && self::$sellerId != null) {
			$oldMarket		= self::$__instance[$service]->getMarketInfo();
			
			if ($oldMarket['market'] != self::$market || $oldMarket['sellerId'] != self::$sellerId)
				self::$__instance[$service]->setMarketInfo(self::$market, self::$sellerId);
		}

		return self::$__instance[$service];
	}

	public function __clone()
    {
        return false;
    }
    public function __wakeup()
    {
        return false;
    }
	
	public function __destruct(){}


}