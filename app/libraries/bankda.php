<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class bankda extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	/* 뱅크다 인증 */
	public function get_auth() {
		$this->load->helper('readurl');
		$sUrl = "https://www.bankda.com/seedex/bankda_encode.php?sData=".preg_replace("/-/","", $this->config_system['service']['cid'])."&sMethod=Enc";
		$cid = readurl($sUrl);
		return $cid;

	}
}