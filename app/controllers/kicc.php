<?php
/*
* kicc 크로스 브라우징 결제 모듈
* 2018-11-26 hed create
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class kicc extends front_base {

	protected $pg_param;
	
	public function __construct() {
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
		
		$this->load->library('kicclib');
	}

	 /*
	 * [결제 인증요청 페이지(STEP2-1)]
	 *
	 */
	public function request()
	{
		session_start();
		//app/order.php function pay에서 전달 해준 데이터
		$this->pg_param = json_decode(base64_decode($_POST["jsonParam"]),true);
		
		// #28841 settle_price 위변조 체크 19.02.12 kmj
		$settleSQL = "seLECT settleprice FROM fm_order WHERE order_seq = ?";
		$settle_price = $this->db->query($settleSQL, array($this->pg_param['order_seq']))->result_array();

		if( intval(floor($settle_price[0]['settleprice'])) !== intval($this->pg_param['settle_price']) ){
			echo("<script>alert('결제 금액이 일치하지 않습니다. 다시 한 번 시도해 주세요.');</script>");
			exit;
		}

		$javascript_url		= $this->kicclib->javascript_url;
		$action_url			= $this->kicclib->action_url;
		
		// PC와 모바일에 따라 변경
		// 인증요청 페이지 전달 
		$param = array();
		$paramKicc			= $this->kicclib->initKiccParams($this->pg_param, '../kicc/iframe');
		
		// 아이프레임 or popup 형식으로 재submit이 발생하므로 암호화 처리
		// 아이프레임 크기 조절을 위해 EP_pay_type|sp_pay_type은 별도 처리
		$pay_type		= $paramKicc[$this->kicclib->params_prefix.'pay_type'];
		unset($paramKicc[$this->kicclib->params_prefix.'pay_type']);
		$jsonParam			= base64_encode(json_encode($paramKicc));
		$param[$this->kicclib->params_prefix.'pay_type'] = $pay_type;
		
		// 스크립트를 미리 구성하여 view로 전달
		$javascript_callPgDelay = $paramKicc['javascript_callPgDelay'];
		
		$this->template->assign('javascript_callPgDelay',		$javascript_callPgDelay);
		$this->template->assign('javascript_url',				$javascript_url);
		$this->template->assign('action_url',					$action_url);
		$this->template->assign('param',						$param);
		$this->template->assign('jsonParam',					$jsonParam);
		
		$this->template->template_dir = BASEPATH."../order";
		$this->template->compile_dir = BASEPATH."../_compile/";
		$this->template->define(array('tpl'=>'_kicc_nax.html'));
		$this->template->print_('tpl');

	}

	 /*
	 * [결제 정보 수신 페이지(STEP2-2)]
	 *
	 */
	public function receive(){
		// iframe 방식으로 처리되기에 응답코드가 0000이 아닌 경우 iframe 종료 처리
		$res_cd = $this->input->post($this->kicclib->params_prefix.'res_cd');
		$param = $this->input->post();
		$jsonParamRecevie = base64_encode(json_encode($param));
		
		if($res_cd=="0000"){
			// 부모창에 있는 결제 데이터와 합산하여 처리 페이지로 재전송
			$this->template->assign('jsonParamRecevie',	$jsonParamRecevie);
			
			$this->template->template_dir = BASEPATH."../order";
			$this->template->compile_dir = BASEPATH."../_compile/";
			$this->template->define(array('tpl'=>'_kicc_nax_receive.html'));
			$this->template->print_('tpl');
		}else{	
			// 예외 처리 
			$this->iframe_exit($param);
		}
	}
	
	 /*
	 * iframe 종료
	 *
	 */
	public function iframe_exit($result){
		$res_cd = $this->input->post($this->kicclib->params_prefix.'res_cd');
		$res_msg = $this->input->post($this->kicclib->params_prefix.'res_msg');
		
		if(empty($res_cd) || !empty($result['res_cd'])){
			$res_cd = $result['res_cd'];
		}
		if(empty($res_msg) || !empty($result['res_msg'])){
			$res_msg = $result['res_msg'];
		}
		
		$callback = 'window.parent.reverse_pay_layer();';
		
		echo '<script>'.$callback.'alert( "'.$res_cd.' : '.$res_msg.'");window.parent.kicc_popup_close();</script>';
	}
	
	 /*
	 * [결제 인증요청 페이지 - iframe]
	 *
	 */
	public function iframe()
	{
		session_start();
		$post_param = $this->input->post();
		
		//app/order.php function pay에서 전달 해준 데이터
		$this->pg_param = json_decode(base64_decode($post_param["jsonParam"]),true);
		$this->pg_param[$this->kicclib->params_prefix.'pay_type'] = $post_param[$this->kicclib->params_prefix.'pay_type'];
			
		$javascript_url		= $this->kicclib->javascript_url;
		$action_url			= $this->kicclib->action_url;
		$param				= $this->pg_param;
		
		// iframe에서 실제 kicc로 보낼때 input안에 데이터가 담길 수 있도록 인코딩처리
		$param['javascript_callPgDelay'] = urlencode($param['javascript_callPgDelay']);
		
		$this->template->assign('javascript_url',		$javascript_url);
		$this->template->assign('action_url',			$action_url);
		$this->template->assign('param',				$param);
		
		$this->template->template_dir = BASEPATH."../order";
		$this->template->compile_dir = BASEPATH."../_compile/";
		$this->template->define(array('tpl'=>'_kicc_nax_iframe.html'));
		$this->template->print_('tpl');

	}
	 /*
	 * [최종결제요청 페이지(STEP2-3)]
	 *
	 */
	public function apply(){
		// iframe 방식으로 처리되기에 응답코드가 0000이 아닌 경우 iframe 종료 처리
		$post_param = $this->input->post();
		$strJsonParam = $this->input->post("jsonParam");
		$strJsonParamRecevie = $this->input->post("jsonParamRecevie");
		$jsonParam = json_decode(base64_decode($strJsonParam),true);
		$jsonParamRecevie = json_decode(base64_decode($strJsonParamRecevie),true);
		
		$param = array_merge($jsonParam, $jsonParamRecevie);
		$param[$this->kicclib->params_prefix.'pay_type'] = $post_param[$this->kicclib->params_prefix.'pay_type'];
		
		$param = $this->kicclib->callKiccModule($param);
		$res_msg			= iconv("euc-kr","utf-8",$param['res_msg']);
		
		if($param['res_cd']=="0000" && $param['order_seq']){
			pageRedirect('../order/complete?no='.$param['order_seq'],'','parent');
		}else{	
			//'결제 실패하였습니다.'
			alert('['.$param['res_cd'].']'.getAlert('os217').'['.$res_msg.']');
		}
	}
	 /*
	 * 매출증빙
	 *
	 */
	public function receipt(){
		$param['order_seq']	= $this->input->get('no');
		
		// order_seq와 tno와 payment를 기준으로 등록된 데이터가 맞는지 확인.
		$url = $this->kicclib->validationKiccReceipt($param);
		echo $url;		
	}
}