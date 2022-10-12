<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class _gabiaFront extends front_base {

	public function set_google_verification()
	{
		$this->load->library('googleAdsApi');
		$aPostParams = $this->input->post();
		$this->googleadsapi->fileLog('set_google_verification', $aPostParams);
		if ($aPostParams['shopNo'] != $this->config_system['shopSno']) {
			echo json_encode(array(
				"result" => "error authentication"
			));
			exit();
		}
		if (! $aPostParams['googleVerificationToken']) {
			echo json_encode(array(
				"result" => "error verification"
			));
			exit();
		}
		config_save('partner', array(
			'google_verification_token' => $aPostParams['googleVerificationToken'],
			'google_merchant_use' => 'Y'
		));
		echo json_encode(array(
			"result" => "set verification"
		));
	}
}