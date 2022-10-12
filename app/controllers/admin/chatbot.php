<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class chatbot extends admin_base
{
	public function __construct()
	{
		parent::__construct();
	}	
	
	public function chat()
	{
		$this->load->helper('readurl');
		$config_chatbot	= config_load('chatbot');
		$aParams	= array(
			'shopSno'		=> $this->config_system['shopSno'],
			'serviceCode'	=> $this->config_system['service']['code'],
			'hostCode'		=> $this->config_system['service']['hosting_code'],
			'domain'		=> $this->config_system['domain'],
			'subDomain'		=> $this->config_system['subDomain'],
			'expireDate'	=> $this->config_system['service']['expire_date']
		);
		$sCheckDateTime	= date("Y-m-d H:i:s");
		$sEnCode		= base64_encode(serialize($aParams));
		$sUrl			= "https://interface.firstmall.kr/firstmall_plus/request.php?cmd=chatbotCode&code=" . $sEnCode;
		
		if(!$config_chatbot || $config_chatbot['date'] < date('Y-m-d H:i:s', strtotime('-10 minutes'))) {
			$sChat	= readurl($sUrl);
			config_save('chatbot', array('enCode' => $sChat, 'date' => $sCheckDateTime));
		}else{
			$sChat = $config_chatbot['enCode'];
		}
		
		$sChat	= readurl($sUrl);
		$aChat	= unserialize(base64_decode($sChat));
		$aResult['appCode']	= $aChat['appCode'];
		if ($aChat['appCode']) {
			$aResult['id']		= $this->config_system['subDomain'] . "_" . $this->managerInfo['manager_seq'];
			$aResult['name']	= $this->managerInfo['manager_id'];
			$aResult['domain']	= $this->config_system['domain'];
			$aResult['email']	= $this->config_basic['companyEmail'];
			$aResult['phone']	= $this->config_system['companyPhone'];
			$aResult['meta']	= array('company' => $this->config_basic['shopName']);
		}
		
		if($config_chatbot['chatbot_use'] != 'Y'){
			return false;
		}
		echo json_encode($aResult);
	}
}

/* End of file coupon.php */
/* Location: ./app/controllers/admin/coupon.php */