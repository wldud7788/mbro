<?php

/*
* Light 전용 카테고리 네비게이션
* @params
*   - file_name : 파일명 (default : category_gnb)
*   - code		: 카테고리코드 (default : null)
*   - max_depth : 최대 깊이 (default : 3)
* @author pjw
* @since  2018-11-28
* @description
*   고정 경로 : _modules/category/
*   신규 커스텀 네비게이션 생성 시 위 고정 경로 안에 파일을 생성 후 파일이름으로 인자값을 넘긴다.
*/
function showCategoryLightNavigation($file_name=null, $code=null, $max_depth=3)
{

	$CI =& get_instance();

	$cache_item_id = sprintf('category_light_navigation%s_%s_html',  ($code ? '_' . $code : ''), $max_depth);

	$html = cache_load($cache_item_id);
	if ($html === false) {
		$template_path = $CI->__tmp_template_path ? $CI->__tmp_template_path : $CI->template_path;

		$skin_file_name			= !empty($file_name) ? $file_name : 'category_gnb';
		$skin_configuration		= skin_configuration($CI->skin);
		$category_template_path = $CI->skin.'/'.'_modules/category/'.$skin_file_name.'.html';
		$category_skin_filepath = ROOTPATH.'data/skin/'.$category_template_path;
		$category_skin_filename = basename($category_template_path);
		$categoryNavigationKey	= "categoryNavigation".uniqid();

		if(file_exists($category_skin_filepath)){
			$CI->load->model('categorymodel');

			$category = $CI->categorymodel->get_category_view('',$max_depth, '',$code);

			$CI->template->assign(array('category'=>$category,'categoryNavigationKey'=>$categoryNavigationKey));
			$CI->template->define(array('category'=>$category_template_path));
			$html = $CI->template->fetch("category");
		}else{
			$html = "<font color='red'>{$category_skin_filename} 파일을 찾을 수 없습니다.</font>";
		}

		//
		cache_save($cache_item_id, $html);
	}

	echo $html;
	return;
}

?>
