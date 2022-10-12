<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class innopay extends front_base {
    protected $pg_param;

	public function construct() { 
		parent::__construct();
		$this->load->helper('order');
		$this->load->helper('shipping');

		$this->load->model('cartmodel');
		$this->load->model('ordermodel');
		$this->load->model('membermodel');
		$this->load->model('couponmodel');
		$this->load->model('goodsmodel');
		$this->load->model('promotionmodel');
		$this->load->model('paymentlog');
		$this->load->helper('readurl');

	}

	public function index() {
	    //echo "<script>console.log(".print_r($_GET).")</script>";
        $this->load->view('innopay', ['data' => $_GET]);
    }

	// 1. 결제 인증 요청 페이지 띄우기
	public function request() {
		session_start();

        $this->pg_param = json_decode(base64_decode($_POST["jsonParam"]),true);

        // #28841 settle_price 위변조 체크 19.02.12 kmj
        $settleSQL = "seLECT settleprice FROM fm_order WHERE order_seq = ?";
        $settle_price = $this->db->query($settleSQL, array($this->pg_param['order_seq']))->result_array();

        if( intval(floor($settle_price[0]['settleprice'])) !== intval($this->pg_param['settle_price']) ){
            echo("<script>alert('결제 금액이 일치하지 않습니다. 다시 한 번 시도해 주세요.');</script>");
            exit;
        }

        $script_url_1 = 'https://pg.innopay.co.kr/ipay/js/jquery-2.1.4.min.js';
        $script_url_2 = 'https://pg.innopay.co.kr/ipay/js/innopay-2.0.js';

        $param = array();

        $this->template->template_dir = BASEPATH."../order";
        $this->template->compile_dir = BASEPATH."../_compile/";
        $this->template->define(array('tpl'=>'_innopay.html'));
        $this->template->print_('tpl');


	} 
	/* 2. 결제 플러그인 호출 */
	/* 3. 결제창 닫기  */
	/* 4. 결제 완료 값 불러오기 */
	/* 5. 결제 로그 쌓기 */
}

?>