<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class kakaopaylib extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->helper('readurl');

		// 실주소
		$this->kakao_hub = "https://kakaopay.firstmall.kr";
		$this->kakao_pg = "https://pg-web.kakao.com";
		$this->timeout = '30';
		$this->detail_url = array(
			'ready'	=> '/v1/payment/ready',	// 결제준비
			'approve' => '/v1/payment/approve',	// 결제승인
			'cancel' => '/v1/payment/cancel', // 결제취소
			'order' => '/v1/payment/order',	// 주문상세조회
			'orders' => '/v1/payment/orders', // 주문내역조회
			'report' => '/v1/payment/manage/report', // 결제내역조회
			'confirm' => '/v1/confirmation/[:agent:]/[:tid:]/[:hash:]' // 매출전표
		);

		$this->cfgPg = config_load('daumkakaopay');
	}

	public function read_api($api_type, $params)
	{
		if ( ! $this->config_system['shopSno']) {
			return false;
		}
		if ( ! $_SERVER['HTTP_HOST']) {
			return false;
		}
		$params['cid'] = $this->cfgPg['cid'];

		$body_param['s_info'] = array(
			'shopSno' => $this->config_system['shopSno'],
			'domain' => get_connet_protocol() . $_SERVER['HTTP_HOST']
		);
		$body_param['api_type'] = trim($api_type);
		$body_param['params'] = $params;

		return json_decode(readurl($this->kakao_hub . '/kakaopay_hub.php', $body_param, false, $this->timeout), true);
	}
}