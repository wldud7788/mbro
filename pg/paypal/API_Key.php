<?
$paypal_config	= config_load("paypal");
$http_protocol	= $_SERVER['HTTPS'] ? 'https' : 'http';
$url			= $http_protocol."://".($_SERVER['HTTP_HOST'])."/payment";
$url_success	= $url.("/paypal_complete");				// return url
$url_cancel		= $url.("/paypal_cancel");					// cacel url


define('API_USERNAME', $paypal_config['paypal_username']);
define('API_PASSWORD', $paypal_config['paypal_userpasswd']);
define('API_SIGNATURE', $paypal_config['paypal_signature']);

if($paymode == "test"){
	define('API_ENDPOINT', 'https://api-3t.sandbox.paypal.com/nvp'); // sandbox API_ENDPOINT
}else{
	define('API_ENDPOINT', 'https://api-3t.paypal.com/nvp');  //live API_ENDPOINT
}
if($paymode == "test"){
	define('PAYPAL_URL', 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=');  // sandbox  PAYPAL_URL
}elseif($paymode == "mobile"){
	define('PAYPAL_URL', 'https://www.paypal.com/webscr&cmd=_express-checkout&useraction=commit&token=');  // sandbox  Mobile 
}else{
	define('PAYPAL_URL', 'https://www.paypal.com/webscr&cmd=_express-checkout&useraction=commit&token=');  // live  PAYPAL_URL
}

define("VERSION", "96.0");

$API_UserName	= API_USERNAME;
$API_Password	= API_PASSWORD;
$API_Signature	= API_SIGNATURE;
$API_Endpoint	= API_ENDPOINT;
$version		= VERSION;
$nvpHeader		= ""; 
$nvpHeader		= "&PWD=".urlencode($API_Password)."&USER=".urlencode($API_UserName)."&SIGNATURE=".urlencode($API_Signature);

?>