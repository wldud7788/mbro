<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class index extends common_base {

	public function main_index()
	{
		/* 미리보기 스킨 세션처리 */
		if(isset($_GET['previewSkin']) && $_GET['previewSkin']){
			setcookie('previewSkin', $_GET['previewSkin'], 0, '/');
			set_cookie(array(
				'name'   => 'setDesignMode',
				'value'  => false,
				'path'   => '/'
			));
		}elseif($_COOKIE['previewSkin']){
			$this->load->helper("cookie");
			delete_cookie('previewSkin');
		}
		if($_SERVER['QUERY_STRING']){
			redirect("main/index?".$_SERVER['QUERY_STRING']);
		}else{
			// 검색엔진 최적화를 위해 (http://webmastertool.naver.com/guide/basic_optimize.naver#chapter4.2)
			redirect("main/index", "auto", 301);
		}
	}

}

/* End of file index.php */
/* Location: ./app/controllers/admin/index.php */