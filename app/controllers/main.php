<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class main extends front_base {

	public function main_index()
	{
		redirect("main/index");
	}

	protected function _index(){
		$aResult		= $this->_read();
		$category_plan  = $aResult['category_plan'];
		$default_shipping_address  = $aResult['default_shipping_address'];
		$this->template->assign('category_plan', $category_plan);
		$this->template->assign('default_shipping_address', $default_shipping_address);
		$this->template->assign('main', true);
		$this->print_layout($this->template_path());
	}

	## 메인에 노출 필요 데이터 로드
	protected function _read()
	{
		// 대표매장 정보
		// 입력장소를 위한 세팅
		if(defined('__ADMIN__') === true){
			$provider_seq = 1;
		}else{
			$provider_seq = $this->providerInfo['provider_seq'];
		}

		$cache_item_id = sprintf('shipping_address_list_%s', $provider_seq ? $provider_seq : 'main');
		$list = cache_load($cache_item_id);
		if ($list === false) {
			$this->load->model('shippingmodel');

			$sc									= array();
			$sc['address_provider_seq']			= $provider_seq;
			$sc['store_info_display_yn']		= 'Y';
			$sc['default_yn']					= 'Y';

			$list = $this->shippingmodel->shipping_address_list($sc);

			//
			cache_save($cache_item_id, $list);
		}

		$default_shipping_address = array();
		if($list['record'][0]){
			$default_shipping_address = $list['record'][0];
		}

		return array('default_shipping_address' => $default_shipping_address);
	}

	## 메인 분기
	public function index()
	{
		$sCreateCached  = $this->input->get('createCached');
		$sPreviewSkin  = $this->input->get('previewSkin');

		/* 미리보기 스킨 세션처리 */
		if(count($this->uri->segments) == 0){
			/* 미리보기 스킨 세션처리 */
			if($sPreviewSkin){
				setcookie('previewSkin', $_GET['previewSkin'], 0, '/');
				set_cookie(array(
					'name'   => 'setDesignMode',
					'value'  => false,
					'path'   => '/'
				));
			}elseif($_COOKIE['previewSkin']){
				$this->load->helper("cookie");
				delete_cookie('previewSkin');
				setcookie('previewSkin', '', 0, '/');
			}
			if($sPreviewSkin || $_COOKIE['previewSkin']){
				if($_SERVER['QUERY_STRING']){
					redirect("main/index?".$_SERVER['QUERY_STRING']);
				}else{
					// 검색엔진 최적화를 위해 (http://webmastertool.naver.com/guide/basic_optimize.naver#chapter4.2)
					redirect("main/index", "auto", 301);
				}
			}
		}

		$this->_index();
	}

	public function blank()
	{
		/* 빈 페이지를 캐싱 */
		//http_response_code(204);
		header('Cache-Control: public, max-age=31536000');
		header('Expires: '.date('r', strtotime('+1 year')));
		header('Pragma: invalid');
		exit;
	}

	public function googleToken(){
		$aPartner	= config_load('partner');
		if( 'google'.$aPartner['google_verification_token'].".html" != $this->uri->uri_string ){
			show_404();
			exit;
		}
		echo "google-site-verification: " . $this->uri->uri_string;
	}
}
