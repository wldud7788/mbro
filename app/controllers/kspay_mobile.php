<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
require_once(ROOTPATH . 'pg/kspay/KSPayWebHost.inc');
class kspay_mobile extends front_base {
	public function __construct(){
		parent::__construct();

		$this->load->helper('order');
		$this->load->helper('shipping');

		$this->load->model('cartmodel');
		$this->load->model('ordermodel');
		$this->load->model('membermodel');
		$this->load->model('couponmodel');
		$this->load->model('promotionmodel');
		$this->load->model('goodsmodel');

		$this->load->library('kspaylib');
	}

	public function kspay_wh_result()
	{
		$this->kspaylib->kspayMobileMode = true;
		$this->kspaylib->wh_result();
	}
}