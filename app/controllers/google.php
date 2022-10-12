<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class google extends front_base {
	public function __construct(){
		parent::__construct();
	}
	// 사업자 정보 조회
	public function googleBusiness()
	{
		$this->load->model('adminenvmodel');
		$this->load->library('googleAdsApi');
		$this->load->helper('readurl');
		$aConfigPartner	= config_load('partner');
		$aGetParams		= $this->input->get();
		
		if ((empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off') && $_SERVER['SERVER_PORT'] != 443) {
			if($_SERVER['HTTP_HOST'] != 'pandadev3.firstmall.kr'){
				echo json_encode(array('result'=>'failed', 'msg'=>'not use ssl'));
				return false;
			}
		}

		if (!$aGetParams['shopHash']) {
			echo json_encode(array('result'=>'failed', 'msg'=>'not use google'));
			return false;
		}

		$sShopHash1	= hash("sha256", str_replace(array('/'), array(''), $this->config_system['subDomain']) . $this->config_system['shopSno']);
		$sShopHash2	= hash("sha256", str_replace(array('/'), array(''), $this->config_system['domain']) . $this->config_system['shopSno']);
		$sShopHash3	= hash("sha256", str_replace(array('/'), array(''), $_SERVER['HTTP_HOST']) . $this->config_system['shopSno']);
		if ($aGetParams['shopHash'] != $sShopHash1 && $aGetParams['shopHash'] != $sShopHash2 && $aGetParams['shopHash'] != $sShopHash3) {
			echo json_encode(array('result'=>'failed', 'msg'=>'no match hash'));
			return false;
		}
		
		if($this->config_system['admin_env_seq'] > 1){
			$admin_env_seq = $this->config_system['admin_env_seq'];
		} else {
			$admin_env_seq = 1;
		}
		
		$params = array('use_yn' => 'y', 'admin_env_seq' => $admin_env_seq);
		$query = $this->adminenvmodel->get($params);
		list($data)					= $query->result_array();
		$result['shopName']			= $data['admin_env_name'];
		$result['companyName']		= $this->config_basic['companyName'];
		$result['businessLicense']	= $this->config_basic['businessLicense'];
		$result['companyZipcode']	= $this->config_basic['companyZipcode'];
		$result['companyAddress']	= implode(' ', array($this->config_basic['companyAddress_street'], $this->config_basic['companyAddressDetail']));
		$result['ceo']				= $this->config_basic['ceo'];
		$result['companyEmail']		= $this->config_basic['companyEmail'];
		$result['companyPhone']		= $this->config_basic['companyPhone'];
		echo json_encode(array('result'=>'success', 'data'=>$result));
	}
	// 배송 변경 정보 갱신 요청
	public function putShippingSetup()
	{
		// 레퍼러 체크
		if (!preg_match('/setting\/shipping_group_regist\?shipping_group_seq=/', $_SERVER['HTTP_REFERER'])) {
			return false;
		}
		$this->load->library('googleAdsApi');
		$aVerification	= $this->googleadsapi->getSiteVerification($this->config_system['shopSno']);
		if (!$aVerification['merchantID'] || !$aVerification['seqno']) {
			return false;
		}
		$sResponce	= $this->googleadsapi->putShippingSetup($this->config_system['shopSno'], $aVerification['merchantID'], $aVerification['seqno']);
		echo "OK";
	}

	// gtag 정보 수신
	public function gtagSetup()
	{
		$this->load->library('googleAdsApi');
		$aPostParams	= $this->input->post();
		$this->googleadsapi->fileLog('gtagSetup', $aPostParams);
		$sShopHash1	= hash("sha256", str_replace(array('/'), array(''), $this->config_system['subDomain']) . $this->config_system['shopSno']);
		$sShopHash2	= hash("sha256", str_replace(array('/'), array(''), $this->config_system['domain']) . $this->config_system['shopSno']);
		$sShopHash3	= hash("sha256", str_replace(array('/'), array(''), $_SERVER['HTTP_HOST']) . $this->config_system['shopSno']);

		if ($aPostParams['shopSeq'] != $this->config_system['shopSno']) {
			echo json_encode(array('result'=>'failed', 'msg'=>'no match shop'));
			return false;
		}
		if ($aPostParams['shopHash'] != $sShopHash1 && $aPostParams['shopHash'] != $sShopHash2 && $aPostParams['shopHash'] != $sShopHash3) {
			echo json_encode(array('result'=>'failed', 'msg'=>'no match hash'));
			return false;
		}
		if ( ! $aPostParams['APIData']) {
			echo json_encode(array('result'=>'failed', 'msg'=>'no Data'));
			return false;
		}

		config_save('partner',array('gtag' => $aPostParams['APIData']));
		echo json_encode(array('result'=>'success'));
	}

	public function goodsName()
	{
		$this->load->model('partnermodel');
		$aPostParams	= $this->input->post();
		$sShopHash1	= hash("sha256", str_replace(array('/'), array(''), $this->config_system['subDomain']) . $this->config_system['shopSno']);
		$sShopHash2	= hash("sha256", str_replace(array('/'), array(''), $this->config_system['domain']) . $this->config_system['shopSno']);
		$sShopHash3	= hash("sha256", str_replace(array('/'), array(''), $_SERVER['HTTP_HOST']) . $this->config_system['shopSno']);

		if ($aPostParams['shopSeq'] != $this->config_system['shopSno']) {
			echo json_encode(array('result'=>'failed', 'msg'=>'no match shop'));
			return false;
		}
		if ($aPostParams['shopHash'] != $sShopHash1 && $aPostParams['shopHash'] != $sShopHash2 && $aPostParams['shopHash'] != $sShopHash3) {
			echo json_encode(array('result'=>'failed', 'msg'=>'no match hash'));
			return false;
		}
		if(!$aPostParams['goodsIds']) {
			echo json_encode(array('result'=>'failed', 'msg'=>'error goodsIds'));
			return false;
		}
		$aGoodsSeqs = json_decode($aPostParams['goodsIds'], true);

		if( !is_array($aGoodsSeqs) || !$aGoodsSeqs[0] ){
			echo json_encode(array('result'=>'failed', 'msg'=>'error goodsIds'));
			return false;
		}

		foreach($this->partnermodel->get_goods_name($aGoodsSeqs)->result_array() as $data){
			$result[$data['goods_seq']] = $data['goods_name'];
		}
		echo json_encode($result);
	}
}