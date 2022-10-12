<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class o2osetting extends admin_base {

	protected $mode = '';
	public function __construct() {
		parent::__construct();

		$this->load->model('authmodel');
		$auth = $this->authmodel->manager_limit_act('o2osetting_act');
		if(!$auth){
			pageBack("권한이 없습니다.");
			exit;
		}

		$this->load->library('o2o/o2oservicelibrary');
		$this->load->model('shippingmodel');
		$this->load->library('validation');

		$this->mode = $this->input->get("mode");
		if(empty($this->mode)){
			$this->mode = 'o2o_list';
		}
	}

	public function index()
	{
		$this->{$this->mode}();
	}

	public function o2o_list()
	{
		$aGetParams = $this->input->get();

		// validation
		if ($aGetParams) {
			$this->validation->set_data($aGetParams);
			$this->validation->set_rules('perpage', '페이지갯수', 'trim|numeric|xss_clean');
			$this->validation->set_rules('page', '페이지', 'trim|numeric|xss_clean');
			$this->validation->set_rules('tab_type', '탭타입', 'trim|string|xss_clean');
			$this->validation->set_rules('src_address_name', '주소', 'trim|string|xss_clean');
			$this->validation->set_rules('arr_src_address_category[]', '주소카테고리', 'trim|string|xss_clean');
			$this->validation->set_rules('arr_src_address_icon[]', '주소아이콘', 'trim|string|xss_clean');
			if ($this->validation->exec() === false) {
				show_error($this->validation->error_array['value']);
			}
		}

		$this->admin_menu();
		$this->tempate_modules();

		// O2O 사용여부
		$this->template->assign('checkO2OService',	$this->o2oservicelibrary->checkO2OService);

		// O2O 계약 정보 갱신
		$this->o2oservicelibrary->refresh_o2o_config();

		// 입력장소를 위한 세팅
		if(defined('__ADMIN__') === true){
			$provider_seq = 1;
		}else{
			$provider_seq = $this->providerInfo['provider_seq'];
		}

		$tabType = 'input';

		// 분류 그룹추출
		$category = $this->shippingmodel->get_shipping_category($tabType,$provider_seq);

		// 아이콘 설정
		$address_icon = $this->shippingmodel->address_icon;

		// 현재 입력되어 있는 입력장소 갯수 확인
		$sc									= array();
		$sc['address_provider_seq']			= $provider_seq;
		$list = $this->shippingmodel->shipping_address_list($sc);
		$shipping_address_regist_able_yn = (($list['page']['totalcount'] >= $this->shippingmodel->shipping_address_max)?'N':'Y');
		$this->template->assign("shipping_address_regist_able_yn", $shipping_address_regist_able_yn);
		$this->template->assign("shipping_address_max", $this->shippingmodel->shipping_address_max);

		// 입력 장소 불러오기
		$sc									= array();
		$sc['page']							= $this->input->get('page');
		$sc['address_name']					= $this->input->get('src_address_name');
		$sc['address_provider_seq']			= $provider_seq;
		$sc['address_category']				= $this->input->get('arr_src_address_category');
		$sc['address_icon']					= $this->input->get('arr_src_address_icon');
		$list = $this->shippingmodel->shipping_address_list($sc);

		// 반송지 아이콘 추출
		foreach($list['record'] as &$row){
			if($row['refund_address_seq']){
				$row['icon'][] = $address_icon['refund_address'];
			}
			if($row['store_info_display_yn'] == 'Y'){
				$row['icon'][] = $address_icon['shipping_address'];
			}
			if($row['shipping_store_seq']){
				$row['icon'][] = $address_icon['direct_store'];
			}
			if($row['store_o2o_use_yn'] == 'Y'){
				$row['icon'][] = $address_icon['o2o_store'];
			}
			if($row['default_yn'] == 'Y'){
				$row['icon'][] = $address_icon['default_store'];
			}
		}

		// 검색용 초기값 설정
		$arr_init_sc = array(
			'address_category'	=> array('key'=>'address_category', 'value'=>&$category)
			, 'address_icon'	=> array('key'=>'key', 'value'=>&$address_icon)
		);
		foreach($arr_init_sc as $k=>&$init_data){
			foreach($sc[$k] as $value){
				foreach($init_data['value'] as &$init_data_value){
					if($init_data_value[$init_data['key']] == $value && empty($init_data_value['selected'])){
						$init_data_value['selected'] = 'selected';
						continue;
					}
				}
			}
		}

		$this->template->assign("category", $category);
		$this->template->assign("address_icon", $address_icon);
		$this->template->assign("loop",$list['record']);
		$this->template->assign("page",$list['page']);
		$this->template->assign("sc",$sc);

		// 디스플레이
		$template_path = $this->template_path("o2o");
		$template_path = str_replace("index.html", $this->mode.'.html', $template_path);
		$this->template->define(array('tpl'=>$template_path));
		$this->template->print_("tpl");
	}

	public function o2o_regist()
	{
		$this->admin_menu();
		$this->tempate_modules();

		$shipping_address_seq = $this->input->get('seq');

		// POS 연동 업체 정보
		$o2o_pos_info = json_decode($this->o2oservicelibrary->o2o_system_info['o2o_pos_info'], true);
		$this->template->assign('o2o_pos_info',	$o2o_pos_info);

		// O2O 코드 정보
		$this->template->assign('o2o_code',$this->o2oservicelibrary->code);

		// 창고목록
		$warehouses = array();
		if($this->scm_cfg['use']=="Y"){
			unset($sc);
			$this->load->model('scmmodel');
			$sc['orderby']	= 'wh_name asc';
			$all_warehouses		= $this->scmmodel->get_warehouse($sc);
			// 현재 쇼핑몰창고로 설정된 창고만 선택 가능
			foreach($all_warehouses as $warehouse){
				foreach($this->scm_cfg['use_warehouse'] as $wh_seq => $use_warehouse){
					if($warehouse['wh_seq'] == $wh_seq){
						$warehouses[] = $warehouse;
					}
				}
			}
		}
		$this->template->assign('warehouses',$warehouses);

		// 올인원 설정 정보
		$this->template->assign('scm_cfg',$this->scm_cfg);

		// SMS 사용여부 확인
		require_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/SMS_send.class.php";
		include_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/sms.class.php";
		$send_phone = getSmsSendInfo();
		$auth		= config_load('master');
		$sms		= new SMS_SEND();
		$sms_chk	= $sms->sms_account;

		$sms_id = $this->config_system['service']['sms_id'];
		$sms_api_key = $auth['sms_auth'];

		//$sms_send	= new SMS_SEND();
		$gabiaSmsApi = new gabiaSmsApi($sms_id,$sms_api_key);

		$limit	= $gabiaSmsApi->getSmsCount();

		$this->template->assign('chk', $sms_chk);
		$this->template->assign('sms_count', $limit);
		$this->template->assign('send_phone',$send_phone);
		$this->template->assign('sms_auth', $auth['sms_auth']);

		// SSL 사용여부
		$this->load->model('ssl');
		$this->template->assign('ssl_pay_is_alive', $this->ssl->ssl_pay_is_alive());
		$this->template->assign('get_ssl_domain', $this->ssl->get_ssl_domain());


		// 영업시간 설정
		$store_term_week = $this->shippingmodel->store_term_week;
		$store_term_time = $this->shippingmodel->store_term_time;
		$this->template->assign("store_term_week", $store_term_week);
		$this->template->assign("store_term_time", $store_term_time);


		$tabType = 'input';
		if(defined('__ADMIN__') === true){
			$provider_seq = 1;
		}else{
			$provider_seq = $this->providerInfo['provider_seq'];
		}

		// 입력장소 정보
		$shipping_address = $this->shippingmodel->get_shipping_address($shipping_address_seq);
		if($shipping_address_seq && empty($shipping_address)){
			pageBack("게시글이 존재하지 않습니다.");
			exit;
		}

		// O2O 설정 정보
		$o2o_store = array();
		if($shipping_address['store_seq']){
			$params_o2o = array(
				'o2o_store_seq'=>$shipping_address['store_seq']
			);
			$o2o_store = $this->o2oservicelibrary->get_o2o_config($params_o2o);
		}
		$shipping_address['store_o2o_info'] = $o2o_store;

		$this->template->assign("shipping_address", $shipping_address);


		// 분류 그룹추출
		$category = $this->shippingmodel->get_shipping_category($tabType,$provider_seq);
		foreach($category as &$row){
			if($row['address_category'] == $shipping_address['address_category']){
				$row['selected'] = 'selected';
			}
		}
		$this->template->assign("category",$category);

		// 현재 입력되어 있는 입력장소 갯수 확인
		$sc									= array();
		$sc['address_provider_seq']			= $provider_seq;
		$list = $this->shippingmodel->shipping_address_list($sc);
		$shipping_address_regist_able_yn = (($list['page']['totalcount'] >= $this->shippingmodel->shipping_address_max)?'N':'Y');
		$this->template->assign("shipping_address_regist_able_yn", $shipping_address_regist_able_yn);
		$this->template->assign("shipping_address_max", $this->shippingmodel->shipping_address_max);


		// 디스플레이
		$template_path = $this->template_path("o2o");
		$template_path = str_replace("index.html", $this->mode.'.html', $template_path);
		$this->template->define(array('tpl'=>$template_path));
		$this->template->print_("tpl");
	}
}
/* End of file setting.php */
/* Location: ./app/controllers/admin/setting.php */
