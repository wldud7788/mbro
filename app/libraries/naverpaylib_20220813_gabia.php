<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class naverpaylib extends CI_Model{
	var $cfg_naverpay		= '';
	var $api_url			= '';
	var $back_url			= '';
	var $return_url			= '';
	var $add_file_path		= '';
	var $access_license		 = '';
	var $secretkey			= '';
	var $servicename		= '';
	var $detaillevel		= '';
	var $version			= '';
	var $operation			= '';
	var $targetUrl			= '';
	var $targetLink			= '';
	var $cus_targetUrl		= '';
	var $shop_targetUrl		= '';
	var $timestamp			= '';
	var $interface_info		= array();
	var $npay_config		= '';
	var $scl				= '';
	var $culture			= '';

	public function __construct($mode='order')
	{
		$this->cfg_naverpay		= config_load('navercheckout');
		$this->add_file_path	= ROOTPATH.'data/order/';
		$this->servicename		= "MallService5";
		$this->detaillevel		= "Full";
		$this->version			= "5.0";	//주문API 4.1, 문의API 1.0
		$this->culture			= "false";

		$this->get_license_info($mode);
	}

	public function  get_license_info($mode='buy'){

		# 중계서버 API URL
		$this->trade_targetUrl = "https://npayapi.firstmall.kr/npay";

		# license key 중계서버에서 받아오기
		$params = array("version"	=> $this->cfg_naverpay['version'],
						"use"		=> $this->cfg_naverpay['use'],
						"mode"		=> "license"
						);
		$result = $this->send($params,"license");

		if($this->cfg_naverpay['version'] == "2.1"){

			$this->access_license	= $result[0];
			$this->secretkey		= $result[1];

			if($this->cfg_naverpay['use'] == "test"){

				if($mode == "buy"){
					$this->targetUrl		= "https://test-api.pay.naver.com/o/customer/api/order/v20/register";

					if($this->_is_mobile_agent){
						$this->targetLink		= "https://test-m.pay.naver.com/o/customer/buy/";
					}else{
						$this->targetLink		= "https://test-order.pay.naver.com/customer/buy";
					}
				}else{
					$this->targetUrl		= "http://sandbox.api.naver.com/Checkout/MallService5";
					//CustomerInquiryService(문의내역조회), CustomerInquiryService(문의답변및수정)
					$this->cus_targetUrl	= "http://sandbox.api.naver.com/Checkout/CustomerInquiryService";
				}
			}elseif($this->cfg_naverpay['use'] == "y"){
				
				if($mode == "buy"){
					$this->targetUrl		= "https://api.pay.naver.com/o/customer/api/order/v20/register";
					if($this->_is_mobile_agent){
						$this->targetLink		= "https://m.pay.naver.com/o/customer/buy/";
					}else{
						$this->targetLink		= "https://order.pay.naver.com/customer/buy";
					}
				}else{
					$this->targetUrl		= "http://ec.api.naver.com/Checkout/MallService5";
					$this->cus_targetUrl	= "http://ec.api.naver.com/Checkout/CustomerInquiryService";
				}
			}

		}else{

			$this->targetUrl = '';

		}
	}

	/* XML출력 */
	function print_xml($xmldata){
		header("Content-Type: application/xml;charset=utf-8");
		echo $xmldata;
	}


	public function make_dir_for_add_file(){
		$path = $this->add_file_path;
		if(!is_dir($path)){
			@mkdir($path);
			@chmod($path,0777);
		}
	}

	# 상품주문 : XML 헤더정의
	public function set_header(){


		$header_xml = array();
		$header_xml[] = '<?xml version="1.0" encoding="utf-8"?>';
		$header_xml[] = '<order>';
		$header_xml[] = $this->auth_xml_data();		// 인증정보

		$return_data = implode("\n",$header_xml);
		unset($header_xml);

		return $return_data;

	}

	# 상품주문 : XML footer
	public function set_footer(){

		$footer_xml		= array('</order>');
		$return_data	= implode("\n",$footer_xml);
		unset($footer_xml);

		return $return_data;

	}

	# 상품주문 : 주문정보 등록 URL
	public function set_api_url($test,$mode){

		$naverpay_api_url['test']['order'] = 'https://test-api.pay.naver.com/o/customer/api/order/v20/register';
		$naverpay_api_url['y']['order'] = 'https://api.pay.naver.com/o/customer/api/order/v20/register';
		$this->api_url  = $naverpay_api_url[$test][$mode];

	}

	# 상품주문 : 
	public function set_back_url($mode=''){
		return  "http://".$this->config_system['domain']."/naverpay/".$mode;
	}

	/***** 해당 상품이 조합형 옵션인지 단독형 옵션인지 판단하는 내용가맹점에서 작성) **/
	function isCombinationYn($productId) {
		// 해당 옵션이 조합형일 경우 true, 단독형인 경우 false를 반환
		// 조합형: 조합된 옵션으로 코드 관리, 조합된 옵션으로 가격을 가지고 있음. 조합된 옵션별 재고관리
		// 단독형: 하나의 옵션으로 코드 관리, 옵션 개별로 가격이 없음. 옵션별 재고관리 없음(상품별 재고 관리)
		return true;
	}

	# 주문수집 : 라이선스 인증
	function order_auth($node){

		//error_reporting(E_ALL);
		include_once dirname(__FILE__)."/nhnapi-simplecryptlib.php";

		if($node == "cus"){
			$this->servicename		= "CustomerInquiryService";
			$this->version			= "1.0";	//주문API 4.1, 문의API 1.0
		}else{
			$this->servicename		= "MallService5";
			$this->version			= "5.0";	//주문API 4.1, 문의API 1.0
		}

		//NHNAPISCL 객체생성
		$this->scl = new NHNAPISCL();
		//타임스탬프를 포맷에 맞게 생성
		$timestamp = $this->scl->getTimestamp();

		$this->timestamp = $timestamp;
		//hmac-sha256서명생성
		$data = $this->timestamp . $this->servicename . $this->operation;

		$signature = $this->scl->generateSign($timestamp . $this->servicename . $this->operation, $this->secretkey);

		$auth_xml = array();
		$auth_xml[] = '			<'.$node.':AccessCredentials>';
		$auth_xml[] = '				<'.$node.':AccessLicense>'.$this->access_license.'</'.$node.':AccessLicense>';		//API 라이선스
		$auth_xml[] = '				<'.$node.':Timestamp>'.$this->timestamp.'</'.$node.':Timestamp>';				//서비스 요청 시각
		$auth_xml[] = '				<'.$node.':Signature>'.$signature.'</'.$node.':Signature>';				//인증된 요청자의 전자서명값
		$auth_xml[] = '			</'.$node.':AccessCredentials>';

		$return_xml	= implode("\n",$auth_xml);
		unset($auth_xml);

		return $return_xml;
	}

	function generateKey($timestamp){

		include_once dirname(__FILE__)."/nhnapi-simplecryptlib.php";

		//NHNAPISCL 객체생성
		$this->scl = new NHNAPISCL();

		//암호키 생성
		$secret = $this->scl->generateKey($timestamp,$this->secretkey);
		if(PEAR::isError($secret)){
		  echo $secret->toString(). "\n";
		  return;
		}

		return $secret;
	}

	# 주문수집 : header,footer xml
	function headerRequest($node='mall'){

		$head_xml	= array();
		if($node == "cus"){
			$head_xml[] = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cus="http://customerinquiry.checkout.platform.nhncorp.com/">';
		}else{
			$head_xml[] = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:mall="http://mall.checkout.platform.nhncorp.com/" xmlns:base="http://base.checkout.platform.nhncorp.com/">';
		}
		$head_xml[] = '	<soapenv:Header/>';
		$head_xml[] = '	<soapenv:Body>';
		$head_xml[]	= '		<'.$node.':'.$this->operation.'Request>';

		$return_xml['header'] = implode("\n",$head_xml);
		unset($head_xml);

		$foot_xml	= array();
		$foot_xml[]	= '		</'.$node.':'.$this->operation.'Request>';
		$foot_xml[]	= '	</soapenv:Body>';
		$foot_xml[]	= '</soapenv:Envelope>';
		$return_xml['footer'] = implode("\n",$foot_xml);
		unset($foot_xml);

		return $return_xml;
	}

	# 주문수집 : 기본 요청 구조 > 상세, 리스트
	function BaseCheckoutRequest($arr){

		$base_xml = array();

		$node = $arr['node'];
		if(!$node) $node = "base";

		$base_xml[] = $this->order_auth($node);
		if($arr['request_id']) $base_xml[] = '			<RequestID>'.$arr['request_id'].'</'.$node.':RequestID>';
		$base_xml[] = '			<'.$node.':DetailLevel>'.$this->detaillevel.'</'.$node.':DetailLevel>';
		$base_xml[] = '			<'.$node.':Version>'.$this->version.'</'.$node.':Version>';

		if($arr['mode'] == "list"){
			//조회시작일시(해당시간 포함)
			$base_xml[] = '			<'.$node.':InquiryTimeFrom>'.$arr['startdt'].'</'.$node.':InquiryTimeFrom>';
			//조회종료일시(해당시각 포함 안함)
			$base_xml[] = '			<'.$node.':InquiryTimeTo>'.$arr['enddt'].'</'.$node.':InquiryTimeTo>';
			//조회에 사용할 추가 데이터(예:주문번호)
			if($arr['extradt']) $base_xml[] = '			<'.$node.':InquiryExtraData>'.$arr['extradt'].'</'.$node.':InquiryExtraData>';	
		}

		$return_xml = implode("\n",$base_xml);
		unset($base_xml);

		return $return_xml;
	}

	public function order_except_msg($_except_msg,$h=""){

		$_except_msg_strlen = mb_strlen(strip_tags($_except_msg));

		if($h=="") {
			if($_except_msg_strlen > 200) $h = 235;
			elseif($_except_msg_strlen > 150) $h = 210;
			elseif($_except_msg_strlen > 110) $h = 190;
			elseif($_except_msg_strlen > 70) $h = 180;
			elseif($_except_msg_strlen > 30) $h = 160;
			else $h = 140;
		}

		openDialogAlert($_except_msg, 450, $h, 'parent', '');
		exit;

	}

	# 상품주문 : make xml data 
	public function product_xml_data($arr,$product='',$total_sale=0){

		$mode					= $arr['mode'];
		$shipping_method		= $arr['shipping_method'];
		$shipping_packageId		= $arr['shipping_packageId'];
		$shipping_group_policy	= $arr['shipping_group_policy'];
		$shipping_paytype		= $arr['shipping_paytype'];			//배송비결제방법(선불/착불)
		$session_tmp			= $arr['session_id']."_".$arr['mktime'];
		$tot_ea					= 0;
		$xml					= array();

		//debug("상품 XML 시작 >>> ");
		//debug("shipping_paytype : ".$shipping_paytype);

		if($product){

			//id : 상품번호. 최대 30자
			//merchantProductId : 판매자 상품번호(입점몰)
			//ecMallProductId : 지식쇼핑 EP mall_pid
			//basePrice : 본상품 1개의 판매가격, 1 이상만 입력
			//taxType : 과세 TAX, 면세 TAX_FREE, 영세 : ZERO_TAX
			//infoUrl : 상품상세 URL
			///imageUrl : 상품원본 이미지 URL
			//giftName : 사은품명. 텍스트 최대 200자
			//option 옵션

			if($product['tax'] == "tax"){
				$taxtype = "TAX";			//과제
			}elseif($product['tax'] == "exempt"){
				$taxtype = "TAX_FREE";		//면세
			}else{
				$taxtype = "ZERO_TAX";		//영세
			}

			$giftname	= '';
			
			$domain = $_SERVER['HTTP_HOST'];
			if(strstr("http",$domain)) $domain = str_replace("http://","",str_replace("https://","",$domain));

			//한글 도메인일경우 Punycode 변환
			if(preg_match('/[^\x00-\x7f]/',$domain)){
				$this->load->library('punycode');
				$domain	= $this->punycode->encodeHostName($domain);
			}

			$infoUrl	= get_connet_protocol().$domain."/goods/view?no=".$product['goods_seq'];

			if($product['options']) list($opt_xml,$opt_managecode,$opt_tot_ea) = $this->option_xml_data($product['options']);
			if($product['suboptions']) list($subopt_xml,$sub_tot_ea) = $this->suboption_xml_data($product['suboptions']);

			$tot_ea					= $opt_tot_ea + $sub_tot_ea;
			$merchant_product_id	= $session_tmp;

			//옵션별 할인가
			$opt_sale = $opt_code = array();
			$opt_single_code = '';
			foreach($opt_managecode as $managecode => $codedata){
				//단일옵션일때 merchantcode에 옵션코드 포함 시키기
				if($product['opttype'] == 'single'){
					$merchant_product_id = $session_tmp."@".$managecode;
				}else{
					 // interface 에 옵션별 할인가 포함(npay 주문 직전 금액 검증)
					$opt_sale[]		= $managecode."@".$codedata;
					$opt_code[]		= $managecode;
				}
			}

			# 배송비 상품 개별 설정 값
			/*
			$shipping_basic = array();
			$shipping_basic['shipping_group']				= $product['shipping_group'];
			$shipping_basic['shipping_method_name']			= $product['shipping_method_name'];
			$shipping_basic['shipping_provider_division']	= $product['shipping_provider_division'];
			$shipping_basic['shipping_policy']				= $product['shipping_policy'];
			$shipping_basic['goods_shipping']				= $product['goods_shipping'];
			$shipping_basic['goods_shipping_policy']		= $product['goods_shipping_policy'];
			$shipping_basic['unlimit_shipping_price']		= $product['unlimit_shipping_price'];
			$shipping_basic['limit_shipping_price']			= $product['limit_shipping_price'];
			$shipping_basic['limit_shipping_ea']			= $product['limit_shipping_ea'];
			$shipping_basic['limit_shipping_subprice']		= $product['limit_shipping_subprice'];

			if($mode == "cart"){
				$shipping_basic['shipping_method']			= $product['shipping_method'];
			}else{
				if(preg_match( '/each/',$product['shipping_method'])){
					$shipping_basic['shipping_method']			= $product['shipping_method'];
				}else{
					$shipping_basic['shipping_method']			= $shipping_method;
				}
			}
			list($shipping_xml,$return_ship_type) = $this->shipping_xml_data($shipping_basic,$shipping_group_policy,$arr['idx'],$tot_ea);//배송정책

			*/

			//선택한 배송방법(배송정책)
			// $tot_ea > $opt_tot_ea 변경 (추가옵션 수량별배송비 계산되지 않도록 변경 2019-12-03 
			list($shipping_xml,$return_ship_type) = $this->shipping_xml_data($shipping_packageId,$product['shipping_set'],$shipping_paytype,$opt_tot_ea);

			$inp_cnt = 0;
			if($product['options']){
				foreach($product['options'] as $opt_k=>$opt){
					foreach($opt['inputs'] as $inp_k=>$inp){
						$inp_cnt++;
					}
				}
			}


			// 싱글옵션 : 옵션이 아무것도 없을때
			if($product['options'][0]['type'] == "single" && $inp_cnt == 0){
				$product['default_price'] = $product['default_price'] - abs($product['options'][0]['opt_add_price']);
			}

			//상품정보확인 URL 생성
			$goods_info_product = array();
			$goods_info_product['id']					= $product['goods_seq'];
			$goods_info_product['merchantProductId']	= base64_encode($merchant_product_id);
			$goods_info_product['optionManageCodes']	= implode(",",$opt_code);
			$goods_info_product['return_ship_type']		= $return_ship_type;

			$product['goods_name'] = getstrcut($product['goods_name'],100);
			if	(!$imageUrl && $product['images']['image']){
				if	(preg_match('/^(http|https)\:\/\//', $product['images']['image'])){
					$imageUrl	= $product['images']['image'];
				}else{
					$imageUrl	= get_connet_protocol().$domain . $product['images']['image'];
				}
			}

			$xml[] = '<product>';
			$xml[] = '	<id>'.$product['goods_seq'].'</id>';
			$xml[] = '	<merchantProductId>'.base64_encode($merchant_product_id).'</merchantProductId>';
			$xml[] = '	<ecMallProductId>'.$product['goods_seq'].'</ecMallProductId>';
			$xml[] = '	<name><![CDATA['.$product['goods_name'].']]></name>';
			$xml[] = '	<basePrice>'.$product['default_price'].'</basePrice>';
			$xml[] = '	<taxType>'.$taxtype.'</taxType>';
			$xml[] = '	<infoUrl><![CDATA['.$infoUrl.']]></infoUrl>';
			$xml[] = '	<imageUrl><![CDATA['.$imageUrl.']]></imageUrl>';
			//if($giftname) $xml[] = '	<giftName><![CDATA[' .$giftname. ']]></giftName>';
			$xml[] = $opt_xml;			//옵션
			$xml[] = $subopt_xml;		//추가옵션
			$xml[] = $shipping_xml;		//배송정보
			$xml[] = '</product>';
		
		}

		$return_data = implode("\n",$xml);
		unset($xml);

		return array($return_data,$goods_info_product);
	}

	# 상품정보확인 URL 생성
	public function callback_goods_info($goods_info_url){

		$goodsinfo_tmp	= array();
		/*
		네이버페이 상품정보 확인 URL은 http로 고정.
		models/ssl.php 에서 해당 페이지는 https자동 리다이렉트 예외처리.
		*/
		$goodsinfo		= "http://".$this->config_system['domain']."/partner/navercheckout_item?";
		foreach($goods_info_url as $field=>$val){
			if(is_array($val)){
				foreach($val as $k=>$val2){
					if(is_array($val2)){
						foreach($val2 as $k2=>$val3){
							$goodsinfo_tmp[] = $field."[".$k."][".$k2."]=".$val3;
						}
					}else{
					}
				}
			}else{
				$goodsinfo_tmp[] = $field."=".$val;
			}
		}
		foreach($goodsinfo_tmp as $v){
			if(!$aa) $aa = $v; else $aa .= "&".$v;
		}
		$goodsinfo .= implode("&",$goodsinfo_tmp);

		return $goodsinfo;
	}

	# 상품주문 :  make xml data 인증
	public function auth_xml_data(){

		if($this->return_url)	$return_url = $this->return_url;
		else					$return_url = $_SERVER['HTTP_REFERER'];
		
		$auth_xml	= array();
		$auth_xml[] = '<merchantId>' . $this->cfg_naverpay['shop_id'] . '</merchantId>';
		$auth_xml[] = '<certiKey>' . $this->cfg_naverpay['certi_key'] . '</certiKey>';
		$auth_xml[] = '<backUrl><![CDATA['.$return_url.']]></backUrl>';
		$auth_xml[] = '<mcstCultureBenefitYn>'.$this->culture.'</mcstCultureBenefitYn>';

		$return_xml = implode("\n",$auth_xml);
		unset($auth_xml);

		return $return_xml;
	}

	# 상품주문 : 상품 상세 페이지의 연동 정보
	public function set_interface(){

		$interface_info = $this->interface_info;

		//salesCode			: 경로별 매출 코드. 매출코드가 필요한 경우 입력
		//cpaInflowCode		: 지식쇼핑 CPA코드. 지식쇼핑 가맹점 중 파라미터 방식 이용한 CPA과금을 원하는 경우 입력
		//naverInflowCode	: 네이버 서비스 유입경로 코드.
		//mileageInflowCode : 네이버페이 포인트 유입경로 코드
		//saClickId			: SA CLICK ID. 네이버 검색광고 이용 가맹점 중 광고주
		$inter_xml	= array();
		$inter_xml[] = '<interface>';

		//사용자 정의 값 (상품정보 검증시 되돌려 받음)
		foreach($interface_info as $key=>$val){
			if($val) $inter_xml[] = '	<'.$key.'>'.$val.'</'.$key.'>';
		}

		$inter_xml[] = '</interface>';

		$return_data = implode("\n",$inter_xml);
		unset($inter_xml);

		return $return_data;
	}

	# 배송유형, 배송방법, 배송비결제방법, 추가배송비 사용 확인.
	public function shipping_method_type($shipping_set,$shipping_paytype){

		//Npay method : 배송방법
		// - 택배소포등기 DELIVERY (무료, 유료, 조건부무료, 수량별 부과)
		// - 퀵서비스 QUICK_SVC				=> npay 강제 적용 : 배송비 묶음 불가, 유료, 착불, 배송비 빈값
		// - 직접배달 DIRECT_DELIVERY		=> 사용안함
		// - 방문수령 VISIT_RECEIPT			=> npay 강제 적용 : 배송비 묶음 불가, 무료
		// - 배송없음 NOTHING				=> 사용안함

		//debug($shipping_set);

		$shipping_std		= $shipping_set['std'];
		$shipping_baserule	= $shipping_set['baserule'];

		if($shipping_baserule['shipping_set_code'] == "direct_store"){
			$shipping_std[0] = $shipping_baserule;
		}

		//debug($shipping_std);

		$shipping_check_msg = array();									//배송비 오류 체크
		$method				= "";
		$fee_paytype		= "";
		$fee_type			= "";
		$fee_price			= $shipping_std[0]['shipping_cost'];			// 기본배송비
		$basic_price		= "0";										// 조건부무료배송내 기준 금액
		$add_shipping		= false;									// 지역별 추가 배송비 사용여부

		#--------------------------------------------------------------------------------------
		# 배송그룹내 배송비 묶음 또는 개별에 따른 무료화 설정
		$shipping_std_group_free		= $shipping_set['shipping_std_group_free'];		//기본배송비 무료화
		$shipping_add_group_free		= $shipping_set['shipping_add_group_free'];		//추가배송비 무료화

		// Shop 기준
		//delivery 택배, direct_delivery 직접배송, quick 퀵, freight 화물배송, direct_store 매장, custom 택배
		$shipping_set_code		= $shipping_std[0]['shipping_set_code'];
		//free 무료, fixed 고정, amount 금액(구간입력), amount_rep 금액(구간반복),
		//cnt(구간입력), cnt_rep(수량)구간반복), weight 무게(구간입력), weight_rep 무게(구간반복)
		$shipping_opt_type		= $shipping_std[0]['shipping_opt_type'];
		$shipping_group_seq		= $shipping_std[0]['shipping_group_seq'];

		# 무료배송그룹과 함께 주문시 배송비 무료화 처리
		if($shipping_std_group_free == "Y"){
			$shipping_opt_type = "free";
		}

		$debug_log = array();
		$debug_log[] = "shipping_paytype : ".$shipping_paytype;
		$debug_log[] = "shipping_set_code : ".$shipping_set_code;
		$debug_log[] = "shipping_opt_type : ".$shipping_opt_type;
		$debug_log[] = "shipping_group_seq : ".$shipping_group_seq;

		#--------------------------------------------------------------------------------------
		# 배송비 결제방법(fee_paytype)
		if($shipping_paytype == "delivery"){
			$fee_paytype			= "PREPAYED"; 
		}elseif($shipping_paytype == "postpaid"){
			$fee_paytype			= "CASH_ON_DELIVERY";
		}else{
			$shipping_check_msg['fee_paytype']	= "배송비 결제 방법 오류";
		}
		#--------------------------------------------------------------------------------------
		# 배송비 유형(fee_type)
		if($shipping_std[0]['shipping_set_code'] != "direct_store"){
			if(in_array($shipping_opt_type,array("free","fixed","amount","cnt_rep"))){

				switch($shipping_opt_type){
					case "free":			//Shop : 무료
						$fee_type = "FREE";						//Npay : 무료
					break;
					case "fixed":			//Shop : 고정
						$fee_type = "CHARGE";					//Npay : 유료
					break;
					case "amount":			//Shop :금액(구간입력)
						$fee_type				= "CONDITIONAL_FREE";			//Npay : 조건부 무료
						//조건부 무료배송 기준금액
						if(count($shipping_std) == 2 && (int)$shipping_std[1]['shipping_cost'] == 0){
							$basic_price		= $shipping_std[1]['section_st'];
							$fee_price			= $shipping_std[0]['shipping_cost'];		// 기본배송비
						}else{
							$shipping_check_msg['amount'] = "조건부 무료배송 오류(조건부 무료 배송 구간이 너무 많거나 무료조건 배송비가 0보다 큼)";
						}
					break;
					case "cnt_rep":			//Shop : 수량(구간반복)
						$fee_type = "CHARGE_BY_QUANTITY";		//Npay : 수량별 부과
						$fee_price = $shipping_std[1]['shipping_cost'];		// 두번째 배송금액이 전달되도록 수정 2018-05-23
					break;
				}
			}else{
				$shipping_check_msg['fee_type']	= "배송비 유형 오류";
			}
		}else{
			$fee_type = "FREE";						//Npay : 무료
		}
		#--------------------------------------------------------------------------------------
		# 배송방법(method)
		if(in_array($shipping_set_code,array("delivery","direct_delivery","quick","freight","direct_store","custom"))){

			switch($shipping_set_code){
				case "custom":					//직접입력
				case "delivery":				//택배소포등기
					$method		= "DELIVERY"; 
				break;
				case "direct_delivery":			//직접배송
					$method		= "DIRECT_DELIVERY";
				break;
				case "quick":					//퀵
					$method		= "QUICK_SVC";
				break;
				case "freight":					//화물배송
					$method		= "DIRECT_DELIVERY"; 
				break;
				case "direct_store":			//매장수령(방문수령)
					$method		= "VISIT_RECEIPT"; 
					$paytype	= "FREE";
				break;
			}
		}else{
			$shipping_check_msg['method']	= "배송방법오류";
		}
		#--------------------------------------------------------------------------------------

		//상품 배송 그룹의 본사or입점사 고유값을 갖고 있는 기본 배송지(default_yn)에 대한 반품 배송지 정보 추출
		$return_address = $this->shippingmodel->get_default_address($shipping_std[0]['shipping_provider_seq']);

		# 기본배송비 무료화
		if($shipping_std_group_free == "Y"){
			$fee_type		= "FREE";
			$fee_paytype	= "FREE";
		}

		//기본배송비- 무료또는 착불일떄만 0 입력 가능 (feePrice)
		if($fee_type == "FREE"){
			$fee_price		= "0";
			$fee_paytype	= "FREE";
		}
		$debug_log[] = "method : ".$method;
		$debug_log[] = "fee_paytype : ".$fee_paytype;
		$debug_log[] = "fee_type : ".$fee_type;
		//debug(implode("\n",$debug_log));
		//exit;
		#--------------------------------------------------------------------------------------
		# 상품이 속한 배송그룹내 기본배송정책의 추가배송비 사용 확인.
		# 추가배송비 무료화가 아닐 때
		if($shipping_add_group_free != "Y"){

			if($shipping_std[0]['default_yn'] != "Y"){
				$shipping_params		= array("delivery_nation"=>"korea","default_yn"=>"Y");
				$shipping_group_list	= $this->shippingmodel->load_shipping_set_list($shipping_group_seq,$shipping_params);
				foreach($shipping_group_list as $key=>$val){
					if($val["default_yn"] == "Y"){
						$default_shipping_set_seq = $val['shipping_set_seq'];
						continue;
					}
				}
				# 상품별 선택한 배송정책
				if($default_shipping_set_seq){
					$default_shipping_set = $this->shippingmodel->load_shipping_set_detail($default_shipping_set_seq);
					if($default_shipping_set['add_use'] == "Y") $add_shipping = true; 
				}

			}else{
				if($shipping_set['add'][0]) $add_shipping = true; 
			}
		}
		#--------------------------------------------------------------------------------------
		$return_shipping_method = array(
									"shipping_check_msg"	=> $shipping_check_msg,
									"method"				=> $method,
									"fee_paytype"			=> $fee_paytype,
									"fee_type"				=> $fee_type,
									"basic_price"			=> floor($basic_price),
									"fee_price"				=> floor($fee_price),
									"add_shipping"			=> $add_shipping,
									"return_address"		=> $return_address,
								);
		return $return_shipping_method;
	}
	
	# 상품주문 : 배송정책 @2016-10-18
	public function shipping_xml_data($shipping_packageId,$shipping_set,$shipping_paytype,$tot_ea=0){

        /* 2022.01.12 12월 4차 패치 by 김혜진 */
        $this->load->library('partnerlib');

		//debug("shipping_set data >> ");
		//debug($shipping_set);

		$debug_log = array();

		//std 기본, add 추가, hop 희망
		# 배송정책 기본 사용여부
		if($shipping_set['std']){ $shipping_set_type = "std"; }
		# 배송정책 희망배송 사용여부
		if($shipping_set['hop']){ $shipping_set_type = "hop"; }

		if($shipping_set['baserule']['shipping_set_code'] == "direct_store"){
			$shipping_set_type = "direct_store";
		}

		# 희망배송이 세팅된 배송방법 선택시 주문 불가.
		if($shipping_set_type == "hop"){
            $this->partnerlib->order_except_msg("<span class=fx12>희망배송 사용오류!</span>");
		}

		if($shipping_set_type != "direct_store" && $shipping_set_type != "std"){
            $this->partnerlib->order_except_msg("<span class=fx12>기본배송정책 사용안함 오류!</span>");
		}

		//groupId : 배송비 묶음 그룹 ID 
		//$groupId			= $shipping_set['shipping_group_seq'];
		//$setId				= $shipping_set['shipping_set_seq'];
		//$shipping_packageId	= str_pad($groupId,4,"0",STR_PAD_LEFT).str_pad($setId,4,"0",STR_PAD_LEFT);

		$debug_log[] = "배송그룹번호 : ".$groupId;
		$debug_log[] = "배송방법번호 : ".$setId;
		$debug_log[] = "배송비 결제방법 : ".$shipping_paytype;
		$debug_log[] = "기본배송정책사용 : ".$shipping_set_type;
		//debug(implode("\n",$debug_log));
		//$shipping	= $shipping_data[$groupId]['shipping_provider'];

		// method : 배송방법
		// - 택배소포등기 DELIVERY (무료, 유료, 조건부무료, 수량별 부과)
		// - 퀵서비스 QUICK_SVC				=> npay 강제 적용 : 배송비 묶음 불가, 유료, 착불, 배송비 빈값
		// - 직접배달 DIRECT_DELIVERY		=> 사용안함
		// - 방문수령 VISIT_RECEIPT			=> npay 강제 적용 : 배송비 묶음 불가, 무료
		// - 배송없음 NOTHING				=> 사용안함
		// paytype : 배송비 지급방법(선불 PREPAYED /착불 CASH_ON_DELIVERY)
		// feeType : 배송비 유형(무료 FREE, 유료:CHARGE, 조건부무료:CONDITIONAL_FREE, 수량별부과 : CHARGE_BY_QUANTITY)
		$ship_return = $this->shipping_method_type($shipping_set,$shipping_paytype);
		$shipping_check_msg		= $ship_return['shipping_check_msg'];			//배송정책 체크 결과 메세지
		$method					= $ship_return['method'];						//배송방법
		$feePayType				= $ship_return['fee_paytype'];					//배송비 지급방법
		$feeType				= $ship_return['fee_type'];						//배송비 유형
		$basePrice				= (!$ship_return['basic_price'])? "0":$ship_return['basic_price'];	//조건부무료 기준배송비
		$feePrice				= (!$ship_return['fee_price'])? "0":$ship_return['fee_price'];	//기본배송비
		$add_shipping			= $ship_return['add_shipping'];					//추가배송비

		if($shipping_check_msg){
            /* 2022.01.12 12월 4차 패치 by 김혜진 */
            $this->partnerlib->order_except_msg("<span class=fx12>배송방법/배송비지급방법/배송비유형 오류!</span>");
		}

		# 수량별반복부과시 추가 세팅
		if($feeType == "CHARGE_BY_QUANTITY"){
			$charge_by_quantity_type	= "REPEAT";
			$repeat_ea					= $shipping_set['std'][1]['section_ed'];	//반복수량
		}

		# 배송조건 부합시 실제 부과될 배송비
		if($feeType == "CHARGE_BY_QUANTITY"){
			$feePrice_tmp	= $feePrice * ceil(($tot_ea+0.01) / $repeat_ea);
		}else{
			$feePrice_tmp	= $feePrice;
		}
		//결제시 상품정보 검증용(배송그룹, 배송비 결제방법, 배송금액)
		$return_shipping_type = $shipping_basic['shipping_group']."@".$feePayType."@".$feePrice_tmp;

		// XML REQUEST -----------------------------------------------------------------
		$ship_data = array();
		$ship_data[] = '	<shippingPolicy>';
		$ship_data[] = '		<groupId>' .$shipping_packageId. '</groupId>';
		$ship_data[] = '		<method>' .$method. '</method>';
		$ship_data[] = '		<feeType>' .$feeType. '</feeType>';
		$ship_data[] = '		<feePayType>' .$feePayType. '</feePayType>';
		$ship_data[] = '		<feePrice>' .$feePrice. '</feePrice>';
		//조건부무료
		if ( $feeType == "CONDITIONAL_FREE") {
			$ship_data[] = '		<conditionalFree>';
			$ship_data[] = '			<basePrice>' .$basePrice. '</basePrice>';
			$ship_data[] = '		</conditionalFree>';
		//수량별 부과
		} else if ($feeType == "CHARGE_BY_QUANTITY") {
			$ship_data[] = '		<chargeByQuantity>';
			//일정 수량별 반복 부과:REPEAT
			$ship_data[] = '			<type>' .$charge_by_quantity_type. '</type>';
			if ($charge_by_quantity_type == "REPEAT") {
				// 포장 단위별 추가 배송비 설정 항목이 없을때만 사용.
				$ship_data[] = '			<repeatQuantity>'.$repeat_ea.'</repeatQuantity>';
			} else if ($charge_by_quantity_type == "RANGE") {
				// 수량 구간별 => 사용 안함.
				/*
				$ship_data[] = '			<range>';
				$ship_data[] = '				<type>2</type>';
				$ship_data[] = '				<range2From>' .($shipping_basic['limit_shipping_ea']). '</range2From>';
				$ship_data[] = '				<range2FeePrice>' .$shipping_basic['limit_shipping_subprice']. '</range2FeePrice>';
				$ship_data[] = '			</range>';
				*/
			}
			$ship_data[] = '		</chargeByQuantity>';
		}
		//surchargeByArea : 지역별 배송비. 지역별 추가 배송비를 사용하고, 가맹점 별도 API를 사용하지 않는 경우에만 입력.
		if ($add_shipping) {
			$ship_data[]= '		<surchargeByArea>';
			$ship_data[]= '			<apiSupport>true</apiSupport>';	//지역별 배송비 조회 API 사용
			$ship_data[]= '		</surchargeByArea>';
		}
		$ship_data[]= '	</shippingPolicy>';
		//------------------------------------------------------------------------------

		$return_data = implode("\n",$ship_data);
		unset($ship_data);

		return array($return_data,$return_shipping_type);
	}

	# 상품주문 : 배송정책
	public function shipping_xml_data_old($shipping_basic,$shipping_data,$idx=0,$tot_ea=0){

		//groupId : 배송비 묶음 그룹 ID 
		$groupId	= $shipping_basic['shipping_group'];
		$shipping	= $shipping_data[$groupId]['shipping_provider'];
		//method : 배송방법
		// - 택배소포등기 DELIVERY (무료, 유료, 조건부무료, 수량별 부과)
		// - 퀵서비스 QUICK_SVC				=> npay 강제 적용 : 배송비 묶음 불가, 유료, 착불, 배송비 빈값
		// - 직접배달 DIRECT_DELIVERY		=> 사용안함
		// - 방문수령 VISIT_RECEIPT			=> npay 강제 적용 : 배송비 묶음 불가, 무료
		// - 배송없음 NOTHING				=> 사용안함

		list($method,$paytype) = $this->shipping_method_type($shipping_basic['shipping_method']);

		//feeType : 배송비 유형(무료 FREE, 유료:CHARGE, 조건부무료:CONDITIONAL_FREE, 수량별부과 : CHARGE_BY_QUANTITY)
			//배송비 유형(무료, 유료, 조건부무료, 수량별 부과)
			$feeType	= "FREE";
		//feePrice : 기본 배송비(무료또는 착불일떄만 0 입력 가능)
				$feePrice	= $shipping['ifpay_delivery_cost'];

			$group_cost_policy			= $shipping_data[$groupId]['group_cost_policy'];	//특정상품 구입시 무료 여부(free)
			$charge_by_quantity_type	= "";												//일정 수량별 반복 부과

			//택배
			if($method == "DELIVERY"){

				//선불/착불 공통 정책
				if($paytype == "PREPAYED" || $paytype == "CASH_ON_DELIVERY"){

					//조건부 무료
					if($shipping['delivery_cost_policy'] == "ifpay" && $group_cost_policy != 'free'){
						$feeType	= "CONDITIONAL_FREE";						
						$basePrice	= $shipping['ifpay_free_price'];	//basePrice : 조건부 무료배송 기준 금액
					//유료
					}else if($shipping['delivery_cost_policy'] == "pay" && $group_cost_policy != 'free'){
						$feeType	= "CHARGE";
						$feePrice	= $shipping['pay_delivery_cost'];
					//무료
					}else if($shipping['delivery_cost_policy'] == "free" || $group_cost_policy == 'free'){
						$feeType	= "FREE";
						$feePrice	= 0;
					}

				}elseif($paytype == "FREE"){
					$feeType	= "FREE";
					$feePrice	= 0;
				}
				if($paytype == "CASH_ON_DELIVERY"){
					$feePrice	= $shipping['postpaid_delivery_cost'];	//착불
				}

			//개별배송(선불만 가능)
			}else if($method == "DELIVERY_EACH"){
				// 무조건 유료 : goods_shipping_policy > unlimit
				// 수량별 부과 : goods_shipping_policy > limit
				if($shipping_basic['goods_shipping_policy'] == "limit"){
					//포장단위가 2개 이상이고 추가 배송비가 기본배송비와 다를때 주문불가
					//총 배송비로 계산
					if((int)$shipping_basic['limit_shipping_subprice'] == 0 && $shipping_basic['limit_shipping_subprice'] != $shipping_basic['limit_shipping_price']){
						# 유료배송
						$feeType	= "CHARGE";
						$feePrice	= ($shipping_basic['goods_shipping'])? $shipping_basic['goods_shipping'] : $shipping_basic['limit_shipping_price'];
					}else{
						//수량별 부과
						$feeType					= "CHARGE_BY_QUANTITY";
						$charge_by_quantity_type	= "REPEAT";	//일정 수량별 반복 부과
						$feePrice					= $shipping_basic['limit_shipping_price'];
					}
				}else{
					$feeType	= "CHARGE";
					$feePrice	= $shipping_basic['unlimit_shipping_price'];
				}
				$method = "DELIVERY";
			}else if($method == "QUICK_SVC"){
				$feeType = "CHARGE";
			}else{
				$feeType = "FREE";
				$feePrice	= 0;
			}

			if(!$feePrice) $feePrice = "0";

			if(($paytype != "CASH_ON_DELIVERY" && (int)$feePrice == 0) && $feeType != "FREE" && $method != "QUICK_SVC") $feeType = "FREE";

		//feePayType : 배송비 결제방법(무료 FREE, 선물:PREPAYED, 착불:CASH_ON_DELIVERY)

		if($feeType == "FREE"){
			$feePayType = "FREE";
		}else{
			$feePayType = $paytype;		//고객선택(선불/착불)
		}

		//surchargeByArea : 지역별 배송비. 지역별 추가 배송비를 사용하고, 가맹점 별도 API를 사용하지 않는 경우에만 입력.
		if ($shippingPolicy != null) {
		}

		# 배송조건 부합시 실제 부과될 배송비
		if($feeType == "CHARGE_BY_QUANTITY"){
			$feePrice_tmp	= $feePrice * $tot_ea;
		}else{
			$feePrice_tmp	= $feePrice;
		}
		//결제시 상품정보 검증용(배송그룹, 배송비 결제방법, 배송금액)
		$return_shipping_type = $shipping_basic['shipping_group']."@".$feePayType."@".$feePrice_tmp;

		// XML REQUEST -----------------------------------------------------------------
		$ship_data = array();
		$ship_data[] = '	<shippingPolicy>';
		$ship_data[] = '		<groupId>' .$groupId. '</groupId>';
		$ship_data[] = '		<method>' .$method. '</method>';
		$ship_data[] = '		<feeType>' .$feeType. '</feeType>';
		$ship_data[] = '		<feePayType>' .$feePayType. '</feePayType>';
		$ship_data[] = '		<feePrice>' .$feePrice. '</feePrice>';
		//조건부무료
		if ( $feeType == "CONDITIONAL_FREE") {
			$ship_data[] = '		<conditionalFree>';
			$ship_data[] = '			<basePrice>' .$basePrice. '</basePrice>';
			$ship_data[] = '		</conditionalFree>';
		//수량별 부과
		} else if ($feeType == "CHARGE_BY_QUANTITY") {
			$ship_data[] = '		<chargeByQuantity>';
			//일정 수량별 반복 부과:REPEAT
			$ship_data[] = '			<type>' .$charge_by_quantity_type. '</type>';
			if ($charge_by_quantity_type == "REPEAT") {
				// 포장 단위별 추가 배송비 설정 항목이 없을때만 사용.
				$ship_data[] = '			<repeatQuantity>'.$shipping_basic['limit_shipping_ea'].'</repeatQuantity>';
			} else if ($charge_by_quantity_type == "RANGE") {
				// 수량 구간별 => 사용 안함.
				$ship_data[] = '			<range>';
				$ship_data[] = '				<type>2</type>';
				$ship_data[] = '				<range2From>' .($shipping_basic['limit_shipping_ea']). '</range2From>';
				$ship_data[] = '				<range2FeePrice>' .$shipping_basic['limit_shipping_subprice']. '</range2FeePrice>';
				$ship_data[] = '			</range>';
			}
			$ship_data[] = '		</chargeByQuantity>';
		}
		//surchargeByArea : 지역별 배송비. 지역별 추가 배송비를 사용하고, 가맹점 별도 API를 사용하지 않는 경우에만 입력.
		if ($shipping_data[$groupId]['addDeliveryCost']) {
			$ship_data[]= '		<surchargeByArea>';
			$ship_data[]= '			<apiSupport>true</apiSupport>';	//지역별 배송비 조회 API 사용
			$ship_data[]= '		</surchargeByArea>';
		}
		$ship_data[]= '	</shippingPolicy>';
		//------------------------------------------------------------------------------

		$return_data = implode("\n",$ship_data);
		unset($ship_data);

		return array($return_data,$return_shipping_type);
	}

	# 상품주문 : 추가옵션
	public function suboption_xml_data($subopt){

		$opt_data	= array();
		$sub_tot_ea = 0;
		foreach($subopt as $opt_k => $val){

			$id			= $val['option_seq']."_".$val['suboption_seq'];
			$opt_data[] = '	<supplement>';
			$opt_data[] = '		<id>' .$id. '</id>';
			$opt_data[] = '		<name><![CDATA[' .$val['suboption']. ']]></name>';
			$opt_data[] = '		<price>' .($val['price']-$val['member_sale']). '</price>';
			$opt_data[] = '		<quantity>' .$val['ea']. '</quantity>';
			$opt_data[] = '	</supplement>';

			$sub_tot_ea += $val['ea'];
		}

		$return_data = implode("\n",$opt_data);
		unset($opt_data);

		return array($return_data,$sub_tot_ea);

	}

	# 상품주문 : 옵션
	public function option_xml_data($opt){

		$opt_data = $return_manageCode = array();
		$opt_tot_ea = 0;

		// 옵션
		foreach($opt as $opt_tmp){

			$opt_seq	= $opt_tmp['option_seq'];

			$input_cnt = 0;
			if($opt_tmp['inputs']){
				foreach($opt_tmp['inputs'] as $inp){
					if(trim($inp['input_value'])) $input_cnt++;
				}
			}

			$opt_tot_ea += $opt_tmp['ea'];

			// 옵션 정보가 없는 본상품 주문일 경우는 <single> 요소가 반드시 들어가야 한다.
			if(!$opt_tmp['option1'] && !$opt_tmp['option2'] && !$opt_tmp['option3'] && !$opt_tmp['option4'] && !$opt_tmp['option5'] && $input_cnt == 0){

				$opt_data[] = '	<single>';
				$opt_data[] = '		<quantity>' .$opt_tmp['ea']. '</quantity>';
				$opt_data[] = '	</single>';

				$manageCode = "opt1".$opt_seq;	//single code

				$return_manageCode[$manageCode] = $opt_tmp['one_total_sale_price'];


			}else{

				//$manageCode = $opt_tmp['option_seq'];
				$manageCode = "opt1".$opt_seq;

				if($opt_tmp['option2']) $manageCode .= "_opt2".$opt_seq;
				if($opt_tmp['option3']) $manageCode .= "_opt3".$opt_seq;
				if($opt_tmp['option4']) $manageCode .= "_opt4".$opt_seq;
				if($opt_tmp['option5']) $manageCode .= "_opt5".$opt_seq;

				//1개당 할인 받은 금액
				$return_manageCode[$manageCode] = $opt_tmp['one_total_sale_price'];

				$opt_data[]	= '	<option>';
				$opt_data[] = '		<quantity>' .$opt_tmp['ea']. '</quantity>';
				$opt_data[] = '		<price>' .$opt_tmp['opt_add_price']. '</price>';
				$opt_data[] = '		<manageCode><![CDATA[' .$manageCode.']]></manageCode>';

				for($i=1; $i<=5; $i++){

					$title		= $opt_tmp['title'.$i];
					$value		= $opt_tmp['option'.$i];
					if($opt_tmp['option'.$i]) $id = "opt".$i.$opt_tmp['option_seq']; else $id = '';

					if($value) $opt_data[] = $this->option_xml_selectItem('SELECT',$id,$title,$value);
				}

				//입력옵션
				if($opt_tmp['inputs']){
					foreach($opt_tmp['inputs'] as $k=>$inp_tmp){

						//if($inp_tmp['type'] != "file"){
							//$title		= $inp_tmp['input_title']."^IN^".strtoupper($inp_tmp['type']);
							$title		= $inp_tmp['input_title'];
							$value		= $inp_tmp['input_value'];
							$id			= "inp".$k.$opt_tmp['option_seq'];

							if($value) $opt_data[] = $this->option_xml_selectItem('INPUT',$id,$title,$value);
						//}

					}
				}

				$opt_data[] = '	</option>';
			}

			$count++;
			
		}

		$return_data = implode("\n",$opt_data);
		unset($opt_data);

		return array($return_data,$return_manageCode,$opt_tot_ea);
	}

	# 상품주문 : 옵션 XML 정리
	public function option_xml_selectItem($type,$id,$title,$value){
		$select_opt_data = array();
		$select_opt_data[] = '		<selectedItem>';
		$select_opt_data[] = '			<type>'.$type.'</type>';
		$select_opt_data[] = '			<name><![CDATA[' .$title. ']]></name>';
		$select_opt_data[] = '			<value>';
		$select_opt_data[] = '				<id>' .$id.'</id>';
		$select_opt_data[] = '				<text><![CDATA[' .$value. ']]></text>';
		$select_opt_data[] = '			</value>';
		$select_opt_data[] = '		</selectedItem>';

		return implode("\n",$select_opt_data);
	}

	# npay 코드 조회
	function get_npay_code($mode,$code=''){
	
		if(!$this->npay_config[$mode]){
			$this->load->helper('readurl');
			$url = 'https://interface.firstmall.kr/firstmall_plus/request.php?cmd=npayCode&mode='.$mode;
			$result = readurl($url);
			if($result){
				$npay_code  = array();
				$arr		= xml2array($result);
				foreach($arr['NaverPayGlobalCode']['item'] as $ncode){
					$npay_code[$ncode['code']]	= $ncode['value'];
				}
			}

			$this->npay_config[$mode] = $npay_code;
		}

		if($code){
			return $this->npay_config[$mode][$code];
		}else{
			return $this->npay_config[$mode];
		}

	}

	# npay 반품 사유
	public function get_npay_return_reason() {
		$reasonLoop = array();

		$npay_reasons	= $this->get_npay_code("claim_return");
		$npay_reasons_duty	= $this->get_npay_code("claim_return_duty");
		foreach($npay_reasons as $k=>$v){
			$tmp = array("codecd"=>$k,"reason"=>$v,"duty"=>$npay_reasons_duty[$k]);
			$reasonLoop[] = $tmp;
		}
		return $reasonLoop;
	}

	# 코드 매핑
	function get_npay_code_mapping($mode,$code){

		switch($mode){
			case "shipping_method":
					//delivery','direct','quick','postpaid'
				switch($code){
					case "DELIVERY":			$return_code = "delivery"; break; //택배,등기,소포
					case "GDFW_ISSUE_SVC":		$return_code = ""; break; //굿스플로 송장 출력";
					case "VISIT_RECEIPT":		$return_code = "direct"; break; //방문수령";
					case "DIRECT_DELIVERY":		$return_code = ""; break; //직접전달";
					case "QUICK_SVC":			$return_code = "quick"; break; //퀵서비스";
					case "NOTHING":				$return_code = ""; break; //배송없음";
					case "RETURN_DESIGNATED":	$return_code = ""; break; //지정반품택배";
					case "RETURN_DELIVERY":		$return_code = ""; break; //일반반품택배";
					case "RETURN_INDIVIDUAL":	$return_code = ""; break; //직접반송";
				}
			break;
		}

		return $return_code;
	}

	# 주문수집 : 변경상품 주문내역 조회
	function get_product_orderlist($sc){

		$this->operation = $sc['operation'];

		$arr = array(
				'node'		=>'base',
				'mode'		=>'list',
				'request_id'=>'',
				'startdt'	=>$sc['startdt'],
				'enddt'		=>$sc['enddt'],
				'extradt'	=>$sc['extradata'],
			);

		$header_xml = $this->headerRequest();

		$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';

		$list_xml[]	= $header_xml['header'];
		$list_xml[] = $this->BaseCheckoutRequest($arr);
		$list_xml[]	= '			<mall:LastChangedStatusCode>'.$sc['status'].'</mall:LastChangedStatusCode>';	//결제완료 주문건만
		$list_xml[]	= '			<mall:MallID>'.$this->cfg_naverpay['shop_id'].'</mall:MallID>';
		$list_xml[]	= $header_xml['footer'];


		$return_xml = implode("\n",$list_xml);
		unset($list_xml);

		return $return_xml;
	}

	# 주문수집 : 특정상품 주문번호 상세 조회
	function get_product_orderinfo($sc){

		$this->operation = $sc['operation'];

		$arr = array(
				'node'		=>'base',
				'mode'		=>'goods',
				'request_id'=>'',
			);

		$header_xml = $this->headerRequest();

		$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';

		$list_xml[]	= $header_xml['header'];
		//$list_xml[]	= '		<mall:GetProductOrderInfoListRequest>';
		$list_xml[] = $this->BaseCheckoutRequest($arr);
		if(is_array($sc['product_order_id'])){
			foreach($sc['product_order_id'] as $product_order_id){
				$list_xml[]	= '			<mall:ProductOrderIDList>'.$product_order_id.'</mall:ProductOrderIDList>';
			}
		}else{
			$list_xml[]	= '			<mall:ProductOrderIDList>'.$sc['product_order_id'].'</mall:ProductOrderIDList>';
		}
		//$list_xml[]	= '		</mall:GetProductOrderInfoListRequest>';
		$list_xml[]	= $header_xml['footer'];


		$return_xml['timestamp'] = $this->timestamp;
		$return_xml['request'] = implode("\n",$list_xml);
		unset($list_xml);

		return $return_xml;


	}

	# 발송처리(사용안함)         
	function ship_product_order($export,$operation="ShipProductOrder"){

		if($export['ProductOrderID']){

			$this->operation = $operation;

			$arr = array(
					'node'		=>'base',
					'request_id'=>'',
				);

			$header_xml = $this->headerRequest();

			$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';

			$list_xml[]	= $header_xml['header'];
			$list_xml[] = $this->BaseCheckoutRequest($arr);
			foreach($export as $field=>$value){
				if($value){
					if($field == "DispatchDate"){
						$list_xml[]	= '			<mall:'.$field.'><![CDATA['.$value.']]></mall:'.$field.'>';
					}else{
						$list_xml[]	= '			<mall:'.$field.'>'.$value.'</mall:'.$field.'>';
					}
				}
			}
			$list_xml[]	= $header_xml['footer'];

			$return_xml = implode("\n",$list_xml);
			unset($list_xml);

			$result = $this->send($return_xml,'order');

		}else{

			$result = array("ResponseType"=>false,"Error"=>array("Message"=>"출고할 주문상품번호가 없습니다."));
		}

		return $result;

	}

	# 주문취소
	function cancel_sale($cancel){

		if($cancel['ProductOrderID']){

			$this->operation = "CancelSale";

			$arr = array(
					'node'		=>'base',
					'request_id'=>'',
				);

			$header_xml = $this->headerRequest();

			$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';

			$list_xml[]	= $header_xml['header'];
			$list_xml[] = $this->BaseCheckoutRequest($arr);
			foreach($cancel as $field=>$value){
				if($value) {

					$list_xml[]	= '			<mall:'.$field.'>'.$value.'</mall:'.$field.'>';
				}
			}
			$list_xml[]	= $header_xml['footer'];

			$return_xml = implode("\n",$list_xml);
			unset($list_xml);

			$result = $this->send($return_xml,'order');

		}else{

			$result = array("ResponseType"=>false,"Error"=>array("Message"=>"취소할 상품주문번호가 없습니다."));
		}


		return $result;
	}
	
	# 취소요청 승인
	function approve_cancel_application($cancel){

		if($cancel['ProductOrderID']){

			$this->operation = "ApproveCancelApplication";

			$arr = array(
					'node'		=>'base',
					'request_id'=>'',
				);

			$header_xml = $this->headerRequest();

			$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';

			$list_xml[]	= $header_xml['header'];
			$list_xml[] = $this->BaseCheckoutRequest($arr);
			foreach($cancel as $field=>$value){
				if($value !== ''){
					if($field == "Memo"){
						$list_xml[]	= '			<mall:'.$field.'><![CDATA['.$value.']]></mall:'.$field.'>';
					}else{
						$list_xml[]	= '			<mall:'.$field.'>'.$value.'</mall:'.$field.'>';
					}
				}
			}
			$list_xml[]	= $header_xml['footer'];

			$return_xml = implode("\n",$list_xml);
			unset($list_xml);

			$result = $this->send($return_xml,'order');

		}else{

			$result = array("ResponseType"=>false,"Error"=>array("Message"=>"취소승인할 상품주문번호가 없습니다."));
		}


		return $result;
	}


	# 반품보류 해제
	function release_return_hold($return_type,$ProductOrderID){

		if($ProductOrderID){

			if($return_type == "exchange"){
				$this->operation	= "ReleaseExchangeHold";
				$title				= "교환";
			}else{
				$this->operation	= "ReleaseReturnHold";
				$title				= "반품";
			}

			$arr = array(
					'node'		=>'base',
					'request_id'=>'',
				);

			$header_xml = $this->headerRequest();

			$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';

			$list_xml[]	= $header_xml['header'];
			$list_xml[] = $this->BaseCheckoutRequest($arr);
			$list_xml[]	= '			<mall:ProductOrderID>'.$ProductOrderID.'</mall:ProductOrderID>';
			$list_xml[]	= $header_xml['footer'];

			$return_xml = implode("\n",$list_xml);
			unset($list_xml);

			$result = $this->send($return_xml,'order');

		}else{

			$result = array("ResponseType"=>false,"Error"=>array("Message"=>$title." 보류 해제 할 상품주문번호가 없습니다."));
		}
		return $result;
	}

	# 반품요청 승인
	function approve_return_application($cancel){

		if($cancel['ProductOrderID']){

			$this->operation = "ApproveReturnApplication";

			$arr = array(
					'node'		=>'base',
					'request_id'=>'',
				);

			$header_xml = $this->headerRequest();

			$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';

			$list_xml[]	= $header_xml['header'];
			$list_xml[] = $this->BaseCheckoutRequest($arr);
			foreach($cancel as $field=>$value){
				if($value !== ''){
					if($field == "Memo"){
						$list_xml[]	= '			<mall:'.$field.'><![CDATA['.$value.']]></mall:'.$field.'>';
					}else{
						$list_xml[]	= '			<mall:'.$field.'>'.$value.'</mall:'.$field.'>';
					}
				}
			}
			$list_xml[]	= $header_xml['footer'];

			$return_xml = implode("\n",$list_xml);
			unset($list_xml);

			$result = $this->send($return_xml,'order');

		}else{

			$result = array("ResponseType"=>false,"Error"=>array("Message"=>"반품요청 승인 할 상품주문번호가 없습니다."));
		}


		return $result;
	}

	# 교환 수거 완료
	function approve_collected_exchange($ProductOrderID){

		if($ProductOrderID){

			$this->operation = "ApproveCollectedExchange";
			$arr = array(
					'node'		=>'base',
					'request_id'=>'',
				);

			$header_xml = $this->headerRequest();
			$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';
			$list_xml[]	= $header_xml['header'];
			$list_xml[] = $this->BaseCheckoutRequest($arr);
			$list_xml[]	= '			<mall:ProductOrderID>'.$ProductOrderID.'</mall:ProductOrderID>';
			$list_xml[]	= $header_xml['footer'];

			$return_xml = implode("\n",$list_xml);
			unset($list_xml);

			$result = $this->send($return_xml,'order');

		}else{

			$result = array("ResponseType"=>false,"Error"=>array("Message"=>"교환 수거 완료 처리 할 상품주문번호가 없습니다."));
		}
		return $result;
	}

	# 발주처리
	function place_product_order($npay_product_order_id){

		if($npay_product_order_id){

			$this->operation	= "PlaceProductOrder";
			$this->detaillevel	= "Compact";

			$arr = array(
					'node'		=>'base',
					'request_id'=>'',
				);

			$header_xml = $this->headerRequest();

			$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';

			$list_xml[]	= $header_xml['header'];
			$list_xml[] = $this->BaseCheckoutRequest($arr);
			$list_xml[]	= '			<mall:ProductOrderID>'.$npay_product_order_id.'</mall:ProductOrderID>';
			$list_xml[]	= $header_xml['footer'];

			$return_xml = implode("\n",$list_xml);
			unset($list_xml);

			$result = $this->send($return_xml,'order');

		}else{

			$result = array("ResponseType"=>false,"Error"=>array("Message"=>"발주처리할 주문상품번호가 없습니다."));
		}


		return $result;
	}

	# 반품처리
	function request_return($return){

		if($return['ProductOrderID']){

			$this->operation = "RequestReturn";

			$arr = array(
					'node'		=>'base',
					'request_id'=>'',
				);

			$header_xml = $this->headerRequest();

			$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';

			$list_xml[]	= $header_xml['header'];
			$list_xml[] = $this->BaseCheckoutRequest($arr);
			foreach($return as $field=>$value){
				if($value){
					if($field == "DispatchDate"){
						$list_xml[]	= '			<mall:'.$field.'><![CDATA['.$value.']]></mall:'.$field.'>';
					}else{
						$list_xml[]	= '			<mall:'.$field.'>'.$value.'</mall:'.$field.'>';
					}
				}
			}
			$list_xml[]	= $header_xml['footer'];

			$return_xml = implode("\n",$list_xml);
			unset($list_xml);

			$result = $this->send($return_xml,'order');

		}else{

			$result = array("ResponseType"=>false,"Error"=>array("Message"=>"출고할 주문상품번호가 없습니다."));
		}


		return $result;
	}

	# 상품리뷰
	function get_purchase_review($sc){
		
		$this->operation	= "GetPurchaseReviewList";
		$this->detaillevel	= "Compact";

		$arr = array(
				'node'		=>'base',
				'mode'		=>'list',
				'request_id'=>'',
				'startdt'	=>$sc['startdt'],
				'enddt'		=>$sc['enddt'],
			);

		$header_xml = $this->headerRequest();

		$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';
		$list_xml[]	= $header_xml['header'];
		$list_xml[] = $this->BaseCheckoutRequest($arr);
		$list_xml[]	= '			<mall:PurchaseReviewClassType>'.$sc['PurchaseReviewClassType'].'</mall:PurchaseReviewClassType>';
		$list_xml[]	= '			<mall:MallID>'.$this->cfg_naverpay['shop_id'].'</mall:MallID>';
		$list_xml[]	= $header_xml['footer'];

		$return_xml = implode("\n",$list_xml);
		unset($list_xml);

		$result = $this->send($return_xml,'order');
		$return_result['result']	= $result;
		$return_result['timestamp'] = $this->timestamp;

		return $return_result;

	}

	# 문의리스트(사용안함)
	function get_customer_inquiry($sc){

		$this->servicename	= "CustomerInquiryService";
		$this->operation	= "GetCustomerInquiryList";
		$this->detaillevel	= "Compact";

		$arr = array(
				'node'		=>'cus',
				'request_id'=>'',
			);


		$header_xml = $this->headerRequest('cus');

		$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';
		$list_xml[]	= $header_xml['header'];
		$list_xml[] = $this->BaseCheckoutRequest($arr);
		$list_xml[]	= '			<ServiceType>CHECKOUT</ServiceType>';
		$list_xml[]	= '			<MallID>'.$this->cfg_naverpay['shop_id'].'</MallID>';
		$list_xml[]	= '			<InquiryTimeFrom>'.$sc['startdt'].'</InquiryTimeFrom>';
		$list_xml[]	= '			<InquiryTimeTo>'.$sc['enddt'].'</InquiryTimeTo>';
		$list_xml[]	= '			<IsAnswered>'.$sc['IsAnswered'].'</IsAnswered>';
		$list_xml[]	= $header_xml['footer'];

		$return_xml = implode("\n",$list_xml);
		unset($list_xml);

		$result = $this->send($return_xml,'cus');
		$return_result = array('result'	=> $result,
								'timestamp' => $this->timestamp);

		return $return_result;

	}

	# 문의답변
	function qnswer_customer_inquiry($sc){
		
		$this->operation	= "AnswerCustomerInquiry";
		$this->detaillevel	= "Compact";

		$arr = array(
				'node'		=>'cus',
				'request_id'=>'',
			);

		$header_xml = $this->headerRequest('cus');

		$list_xml[]	= '<?xml version="1.0" encoding="utf-8"?>';
		$list_xml[]	= $header_xml['header'];
		$list_xml[] = $this->BaseCheckoutRequest($arr);
		$list_xml[]	= '			<ServiceType><![CDATA[CHECKOUT]]></ServiceType>';
		$list_xml[]	= '			<MallID><![CDATA['.$this->cfg_naverpay['shop_id'].']]></MallID>';
		$list_xml[]	= '			<InquiryID><![CDATA['.$sc['InquiryID'].']]></InquiryID>';
		$list_xml[]	= '			<AnswerContent><![CDATA['.$sc['AnswerContent'].']]></AnswerContent>';	//답변내용
		if($sc['AnswerContentID']){
		$list_xml[]	= '			<AnswerContentID>'.$sc['AnswerContentID'].'</AnswerContentID>';	//답변번호
		}
		$list_xml[]	= '			<ActionType><![CDATA['.$sc['ActionType'].']]></ActionType>';	//INSERT, UPDATE
		$list_xml[]	= $header_xml['footer'];

		$return_xml = implode("\n",$list_xml);
		unset($list_xml);

		$result = $this->send($return_xml,'cus');

		return $result;

	}

	function send($data,$mode='goods'){

		$headers	= array();;
		//$headers[]	= 'Content-Type: text/xml;charset=UTF-8';
		
		if(!is_array($data)){
		$data = str_replace("\n","",str_replace("\t","",$data));
		}

		if($mode == "order"){
			$targetUrl = $this->targetUrl;
			$headers[]	= 'Content-Type: text/xml;charset=UTF-8';
			$headers[] = "SOAPAction: ".$this->servicename . "#" . $this->operation;
			$headers[]	= "Content-length: ".strlen($data);
		}elseif($mode == "cus"){
			$targetUrl = $this->cus_targetUrl;
			$headers[]	= 'Content-Type: text/xml;charset=UTF-8';
			$headers[] = "SOAPAction: ".$this->servicename . "#" . $this->operation;
			$headers[]	= "Content-length: ".strlen($data);
		}elseif($mode == "shop"){
			$targetUrl = $this->shop_targetUrl;
		}elseif($mode == "export"){
			$this->operation = "auto_order_export";
			$targetUrl = $this->trade_targetUrl."/".$this->operation.".php";
		}elseif($mode == "license"){
			$this->operation = "npay_get_license";
			$targetUrl = $this->trade_targetUrl."/".$this->operation.".php";
		}elseif($mode == "get_order"){
			$targetUrl = $this->trade_targetUrl."/".$this->operation.".php";
		}else{
			$targetUrl = $this->targetUrl;
			$headers[]	= 'Content-Type: text/xml;charset=UTF-8';
			$headers[]	= "Content-length: ".strlen($data);
		}

		//request log : request timestamp가 reponse 개인정보 복호화시 사용됨.
		$this->result_message_log($this->operation,$data,'Request');

		$ci = curl_init();
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		if($headers) curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ci, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ci, CURLOPT_URL, $targetUrl);
		curl_setopt($ci, CURLOPT_POST, TRUE);
		curl_setopt($ci, CURLOPT_TIMEOUT, 300);
		curl_setopt($ci, CURLOPT_POSTFIELDS, $data);

		// 주문 등록 후 결과값 확인
		$response = curl_exec($ci);

		if($response == false){
			$err = 'Curl error '. curl_error($ci);
			$this->result_message_log("npay_error_curl",curl_error($ci),$this->operation);
			return $err;
			exit;
		}
		curl_close($ci);

		//response log
		if($mode == "license"){
			$response = unserialize($response);
			$license_log = array("license_key" =>strlen($response[0]),
								"secreat_key" =>strlen($response[1])
								);
			$this->result_message_log($this->operation,$license_log);
		}else{
			$this->result_message_log($this->operation,$response,'Response');
		}

		//상품주문 사용
		if($mode == "goods"){

			$param = explode(':', $response);

		}elseif($mode == "export" || $mode == "license" || $mode == "get_order"){

			$param = $response;

		}else{			
			//주문 수집 사용
			require_once("PEAR/XMLParser.php");
			$xml = new PEAR_XMLParser;
			$xml->parse($response);
			$xmldata = $xml->getdata();

			if($mode == "shop"){
				$param = $xmldata['Body']['ProductOrderInfoList'];
			}else{
			
				$param = $xmldata['soapenv:Body']['n:'.$this->operation.'Response'];
				if(!$param){
					$param = $xmldata['soapenv:Body']['soapenv:Fault'];
				}
				$param = $this->npay_parser($param);
			}

			if(!$param['ResponseType']){
				$param['ResponseType']		= "FAIL";
				$param['Error']['Message']	= $param['faultstring'];
			}
		}
		return $param;
	}

	function npay_parser($data,$no=''){

		if(!$no) $returnRes = array();
		foreach($data as $key=>$val){
			$key = str_replace("n1:","",str_replace("n:","",$key));
			if(is_array($val)){
				$returnRes[$key] = $this->npay_parser($val);
			}else{
				$returnRes[$key] = $val;
			}
		}

		return $returnRes;
	}

	/* 로그기록 */
	function result_message_log($method,$ResultMessage,$mode=''){
		$logDir = ROOTPATH.'data/logs';
		if(!is_dir($logDir)){
			mkdir($logDir);@chmod($logDir,0777);
		}
		$logDir .= "/npay";
		if(!is_dir($logDir)){
			mkdir($logDir);@chmod($logDir,0777);
		}
		$logDir .= "/".date('Ymd');
		if(!is_dir($logDir)){
			mkdir($logDir);@chmod($logDir,0777);
		}

		//대량처리 문제로 시간별로 구분 @2017-03-09
		$logFilePath = $logDir."/".$method."_";//.date('Ym').".txt"
		if($method == "npay_send_order_result" || $method == "npay_get_order" || $method == "PlaceProductOrder"){
			$logFilePath .= date('Ymd').".txt";
		}else{
			$logFilePath .= date('Ym').".txt";
		}

		$microtime = substr(microtime(),0,10) * 1000000000;
		$fp = fopen( $logFilePath, "a+" );
		fwrite($fp,"[".date('Y-m-d H:i:s.').$microtime."]\r\n");
		if($mode) fwrite($fp,"MODE : ".$mode."\r\n");
		if($this->timestamp) fwrite($fp,"TIMESTAMP : ".$this->timestamp."\r\n");
		if($_SERVER['REMOTE_ADDR']) fwrite($fp,"REMOTE_IP : ".$_SERVER['REMOTE_ADDR']."\r\n");
		ob_start();
		print_r($ResultMessage);
		$contents = ob_get_contents();
		$contents = str_replace("\n","\r\n",$contents);
		ob_clean();
		fwrite($fp,"{$contents}\r\n");
		/*
		foreach($ResultMessage as $k=>$v){
			fwrite($fp,"{$k} : {$v}\r\n");
		}
		*/
		fwrite($fp,"\r\n");
		fclose($fp);

		@chmod($logFilePath,0777);
	}

}