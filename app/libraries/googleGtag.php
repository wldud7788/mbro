<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class googleGtag extends CI_Model
{
	protected $aGtag = array(
		'global'	=> "<script async src='https://www.googletagmanager.com/gtag/js?id={googleAWCode}'></script><script>window.dataLayer=window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '{googleAWCode}');</script>",
		'common'	=> "<script>gtag('event', 'conversion', { 'send_to':'{googleAWCode}/{EventCode}', 'value': {price}, 'currency':'{currency}' });</script>",
		'purchase'	=> "<script>gtag('event', 'conversion', { 'send_to':'{googleAWCode}/{EventCode}', 'value': {price}, 'currency':'{currency}', 'transaction_id': '{orderSeq}' });</script>",
		'signup'	=> "<script>gtag('event', 'conversion', {'send_to':'{googleAWCode}/{EventCode}'});</script>",
		'cart'		=> "<script>function gtag_report_cart(url) { var callback = function () { if (typeof(url) != 'undefined') { window.location = url; } }; gtag('event', 'conversion', { 'send_to': '{googleAWCode}/{EventCode}', 'value': {price}, 'currency': 'KRW', 'event_callback': callback }); return false; }</script>",
		'wish'		=> "<script>function gtag_report_wish(url) { var callback = function () { if (typeof(url) != 'undefined') { window.location = url; } }; gtag('event', 'conversion', { 'send_to': '{googleAWCode}/{EventCode}', 'value': {price}, 'currency': 'KRW', 'event_callback': callback }); return false; }</script>"
	);
	public function __construct()
	{
		if ( ! $this->aGtagCfg) {
			$gtag_config	= config_load('partner');
			if ( ! $gtag_config['google_verification_token']) $gtag_config['gtag']	= false;
			if ($gtag_config['gtag']) $this->aGtagCfg		= json_decode(base64_decode($gtag_config['gtag']), true);
			if ($this->aGtagCfg && ! $this->aGtagCfg[0]['eventCode']) {
				foreach ($this->aGtagCfg as $k => $aGtag) {
					$sEventTag = str_replace(chr(10),'', stripslashes($aGtag['eventTag']));
					preg_match_all("/{[^>]*'send_to'[^}]*'/i", $sEventTag, $matches);
					$aTmp = explode("',", $matches[0][0]);
					if ($aTmp[0]) {
						$sTmp = trim(str_replace(array('{','\'',':','=>','send_to'), array('','','','',''), $aTmp[0]));
						$aTmp = explode('/', $sTmp);
						if ($aTmp[0] == $aGtag['googleAWCode']) $this->aGtagCfg[$k]['eventCode'] = $aTmp[1];
					}
				}
			}
		}
	}
	
	public function globalTag()
	{
		if( ! $this->aGtagCfg[0]['googleAWCode']) return false;
		if( ! $this->aGtagCfg[0]['conversionID']) return false;
		return str_replace(array('{conversionID}', '{googleAWCode}'), array($this->aGtagCfg[0]['conversionID'], $this->aGtagCfg[0]['googleAWCode']), $this->aGtag['global']);
	}
	
	public function eventTagView($sPrice, $sCurrency)
	{
		if( ! $this->aGtagCfg[0]['googleAWCode'])	return false;
		if( ! $this->aGtagCfg[0]['eventCode'])		return false;
		if( ! $sPrice)		return false;
		if( ! $sCurrency)	return false;
		return str_replace(array('{googleAWCode}', '{EventCode}', '{price}', '{currency}'), array($this->aGtagCfg[0]['googleAWCode'], $this->aGtagCfg[0]['eventCode'], $sPrice, $sCurrency), $this->aGtag['common']);
	}
	
	public function eventTagCart($sPrice, $sCurrency)
	{
		if( ! $this->aGtagCfg[0]['googleAWCode'])	return false;
		if( ! $this->aGtagCfg[0]['eventCode'])		return false;
		if( ! $sPrice)		return false;
		if( ! $sCurrency)	return false;
		return str_replace(array('{googleAWCode}', '{EventCode}', '{price}', '{currency}'), array($this->aGtagCfg[1]['googleAWCode'], $this->aGtagCfg[1]['eventCode'], $sPrice, $sCurrency), $this->aGtag['cart']);
	}
	
	public function eventTagWish($sPrice, $sCurrency)
	{
		if( ! $this->aGtagCfg[0]['googleAWCode'])	return false;
		if( ! $this->aGtagCfg[0]['eventCode'])		return false;
		if( ! $sPrice)		return false;
		if( ! $sCurrency)	return false;
		return str_replace(array('{googleAWCode}', '{EventCode}', '{price}', '{currency}'), array($this->aGtagCfg[2]['googleAWCode'], $this->aGtagCfg[2]['eventCode'], $sPrice, $sCurrency), $this->aGtag['wish']);
	}
	
	public function eventTagCheckout($sPrice, $sCurrency)
	{
		if( ! $this->aGtagCfg[0]['googleAWCode'])	return false;
		if( ! $this->aGtagCfg[0]['eventCode'])		return false;
		if( ! $sPrice)		return false;
		if( ! $sCurrency)	return false;
		return str_replace(array('{googleAWCode}', '{EventCode}', '{price}', '{currency}'), array($this->aGtagCfg[3]['googleAWCode'], $this->aGtagCfg[3]['eventCode'], $sPrice, $sCurrency), $this->aGtag['common']);
	}
	
	public function eventTagPurchase($sPrice, $sCurrency, $iOrderSeq)
	{
		if( ! $this->aGtagCfg[0]['googleAWCode'])	return false;
		if( ! $this->aGtagCfg[0]['eventCode'])		return false;
		if( ! $sPrice)		return false;
		if( ! $sCurrency)	return false;
		if( ! $iOrderSeq)	return false;
		return str_replace(array('{googleAWCode}', '{EventCode}', '{price}', '{currency}', '{orderSeq}'), array($this->aGtagCfg[4]['googleAWCode'], $this->aGtagCfg[4]['eventCode'], $sPrice, $sCurrency, $iOrderSeq), $this->aGtag['purchase']);
	}
	
	public function eventTagSignUp()
	{
		if( ! $this->aGtagCfg[0]['googleAWCode'])	return false;
		if( ! $this->aGtagCfg[0]['eventCode'])		return false;
		return str_replace(array('{googleAWCode}', '{EventCode}'), array($this->aGtagCfg[5]['googleAWCode'], $this->aGtagCfg[5]['eventCode']), $this->aGtag['signup']);
	}
}