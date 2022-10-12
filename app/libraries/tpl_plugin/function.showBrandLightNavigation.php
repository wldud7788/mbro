<?php

/*
* Light 전용 브랜드 네비게이션
* @params
*   - file_name : 파일명 (default : brand_gnb)
*   - code		: 브랜드코드 (default : null)
*   - max_depth : 최대 깊이 (default : 2)
* @author pjw
* @since  2018-11-28
* @description
*   고정 경로 : _modules/brand/
*   신규 커스텀 네비게이션 생성 시 위 고정 경로 안에 파일을 생성 후 파일이름으로 인자값을 넘긴다.
*/
function showBrandLightNavigation($file_name=null, $code=null, $max_depth=2)
{

	$CI =& get_instance();

	//
	$template_path = $CI->__tmp_template_path ? $CI->__tmp_template_path : $CI->template_path;
	$skin_file_name		 = !empty($file_name) ? $file_name : 'brand_gnb';

	//
	$cache_item_id = sprintf('brand_navigation_%s_%s_%s_html', $skin_file_name, $code, $max_depth);
	$html = cache_load($cache_item_id);
	if ($html === false) {
		$skin_configuration  = skin_configuration($CI->skin);
		$brand_template_path = $CI->skin.'/'.'_modules/brand/'.$skin_file_name.'.html';
		$brand_skin_filepath = ROOTPATH.'data/skin/'.$brand_template_path;
		$brand_skin_filename = basename($brand_template_path);
		$brandNavigationKey  = "brandNavigation".uniqid();

		if(file_exists($brand_skin_filepath)){
			$CI->load->model('brandmodel');

			$brand = $CI->brandmodel->get_brand_view('',$max_depth, '',$code);

			$CI->template->assign(array('brand'=>$brand,'brandNavigationKey'=>$brandNavigationKey));
			$CI->template->define(array('brand'=>$brand_template_path));
			$html = $CI->template->fetch("brand");
		}else{
			$html = "<font color='red'>{$brand_skin_filename} 파일을 찾을 수 없습니다.</font>";
		}

		//
		cache_save($cache_item_id, $html);
	}

	echo $html;
	return;
}

?>
