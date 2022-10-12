<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class service extends front_base {

	function __construct() {
		parent::__construct();

		$this->load->helper('member');
	}

	public function main_index()
	{
		redirect("/service/index");
	}

	public function index()
	{

	}

	/* 고객센터 */
	public function cs()
	{
		$arr = config_load('bank');
		if($arr) foreach(config_load('bank') as $k => $v){
			list($tmp) = code_load('bankCode',$v['bank']);
			$v['bank'] = $tmp['value'];
			$bank[] = $v;
		}
		
		// 반응형에선 left 메뉴 따로 정의 :: 2019-02-13 pjw
		if($this->config_system['operation_type'] == 'light'){
			$this->template->define('board_lnb', $this->skin."/_modules/common/board_lnb.html");
		}

		$this->template->assign(array('bank'=>$bank));
		$this->print_layout($this->template_path());
	}

	/* 회사소개 */
	public function company(){
		$this->print_layout($this->template_path());
	}

	/* 이용약관 */
	public function agreement(){
		$arrBasic = ($this->config_basic)?$this->config_basic:config_load('basic');

		//20170920 shopName -> companyName 으로 변경(db쪽에 shopName 치환코드가 있는 관계로 소스에서만 설정) ldb
		$this->template->assign('shopName',$arrBasic['companyName']);

		$data = chkPolicyInfo();	// 통합약관 적용. 기본 치환코드 처리 포함

		$this->template->assign($data);
		$this->print_layout($this->template_path());
	}

	/* 개인정보처리방침 */
	public function privacy(){
		$arrBasic = ($this->config_basic)?$this->config_basic:config_load('basic');

		//20170920 shopName -> companyName 으로 변경(db쪽에 shopName 치환코드가 있는 관계로 소스에서만 설정) ldb
		$this->template->assign('shopName',$arrBasic['companyName']);

		$data = chkPolicyInfo();	// 통합약관 적용. 기본 치환코드 처리 포함

		$this->template->assign($data);
		$this->print_layout($this->template_path());
	}

	/* 이용안내 */
	public function guide(){
		$this->load->model("providershipping");
		$data = $this->providershipping->get_provider_shipping('1');
		$this->template->assign('deliveryCompanyName',$data['deliveryCompanyCodeMapping']?$data['deliveryCompanyCodeMapping'][$data['deliveryCompanyCode'][0]]:'');

		// 반송주소 가져오기
		$this->load->model("shippingmodel");
		$shippingBase = $this->shippingmodel->get_shipping_base();
		$shippingAddress = $this->shippingmodel->get_shipping_address($shippingBase['refund_address_seq'], $shippingBase['refund_scm_type']);
		$shippingAddressText = $shippingAddress['address_zipcode'] . ' ' . 
											($shippingAddress['address_type']=='street' ? $shippingAddress['address_street'] : $shippingAddress['address']) . 
											($shippingAddress['address_detail'] ? ' ' . $shippingAddress['address_detail'] : '');
		$this->template->assign("config_shipping",$shippingAddressText);

		$this->print_layout($this->template_path());
	}

	/* 제휴안내 */
	public function partnership(){
		$this->print_layout($this->template_path());
	}


	public function partnership_send(){

		$file_path	= "../../data/email/".get_lang(true)."/partnership.html";
		$_POST["zipcode"] = $_POST["recipient_zipcode"][0]."-".$_POST["recipient_zipcode"][1];
		$this->template->assign(array('order'=>$_POST));
		$this->template->compile_dir = ROOTPATH."data/email/".get_lang(true)."/";
		$this->template->define(array('tpl'=>$file_path));
		$bodyTpl = $this->template->fetch('tpl');
		$body	= trim($bodyTpl);
		$body	= preg_replace("/\/data\/mail/", $domain."/data/mail", $body);
		$body	= str_replace("http://http://", "http://", $body);

		$email = config_load('email');

		$email['partnership_skin'] = $out;

		$adminEmail = $basic['partnershipEmail']?$basic['partnershipEmail']:$basic['companyEmail'];

		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/Email_send.class.php";
		$mail		= new Mail(isset($params));
		$basic = ($this->config_basic)?$this->config_basic:config_load('basic');
		$headers['From']		= $_POST["email"];
		$headers['Name']	= $_POST["writer"];
		$headers['Subject'] = "[".$_POST["company"]."]".$_POST["qtype"]." 문의입니다.";
		$headers['To']			= $basic['partnershipEmail'];//"kbm@gabia.com; ".
		$resSend = $mail->send($headers, $body);

		if($resSend){
			$callback = "parent.document.location.reload();";
			//문의가 접수되었습니다.
			openDialogAlert(getAlert('et023'),400,140,'parent',$callback);
		}else{
			//문의가 접수중 에러가 발생되었습니다<br>잠시 후 다시 시도하여 주십시오.
			openDialogAlert(getAlert('et024'),400,140,'parent',$callback);
		}


	}

	public function policy(){

		//비회원 개인정보 수집-이용 약관동의 추가
		$data = chkPolicyInfo();	// 통합약관 적용. 기본 치환코드 처리 포함

		$this->template->assign($data);
		$this->print_layout($this->template_path());
	}

	public function cancellation(){

		$data = chkPolicyInfo();	// 통합약관 적용. 기본 치환코드 처리 포함
		$this->template->assign($data);
		$this->print_layout($this->template_path());
	}

	public function store(){
		$this->load->model('shippingmodel');
		$shipping_address_seq = $this->input->get('seq');
		
		$provider_seq = '1';	// 본사 데이터만 조회
		
		// 입력 장소 불러오기
		$sc									= array();
		$sc['address_provider_seq']			= $provider_seq;
		$sc['store_info_display_yn']		= 'Y';
		$sc['address_icon']					= array('shipping_address');
		$sc['orderby']						= " ORDER BY s_addr.address_name ASC ";
		$list = $this->shippingmodel->shipping_address_list($sc);
		
		if(empty($shipping_address_seq)){
			// 대표매장이 기본 선택 되도록 수정
			foreach($list['record'] as $row){
				if($row['default_yn'] == 'Y'){
					$shipping_address_seq = $row['shipping_address_seq'];
				}
			}
			if(empty($shipping_address_seq)){
				$shipping_address_seq = $list['record'][0]['shipping_address_seq'];
			}
		}
		
		$this->template->assign("loop", $list['record']);
		$this->template->assign("shipping_address_seq", $shipping_address_seq);
		
		$this->print_layout($this->template_path());
	}

	public function store_ajax(){
		$this->load->model('shippingmodel');
		
		$_GET['popup'] = true;
		
		$shipping_address_seq = $this->input->get('shipping_address_seq');
		
		$provider_seq = '1';	// 본사 데이터만 조회
		
		if($shipping_address_seq){
			// 입력 장소 불러오기
			$sc									= array();
			$sc['shipping_address_seq']			= $shipping_address_seq;
			$sc['address_provider_seq']			= $provider_seq;
			$sc['store_info_display_yn']		= 'Y';
			$sc['address_icon']					= array('shipping_address');
			$sc['orderby']						= " ORDER BY s_addr.address_name ASC ";
			$list = $this->shippingmodel->shipping_address_list($sc);
		}
		
		$this->template->assign("shipping_address", $list['record'][0]);
		
		$this->template->define(array('tpl'=>$this->template_path()));
		$this->template->print_("tpl");
	}

	/* 마케팅 및 광고 활용 동의 */
	public function marketing(){
		$data = chkPolicyInfo();	// 통합약관 적용. 기본 치환코드 처리 포함

		$this->template->assign($data);
		$this->print_layout($this->template_path());
	}	
}

