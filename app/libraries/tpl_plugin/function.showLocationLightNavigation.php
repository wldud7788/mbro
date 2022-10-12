<?php

/*
* Light 전용 지역 네비게이션
* @params
*   - file_name : 파일명 (default : location_gnb)
*   - code		: 지역코드 (default : null)
*   - max_depth : 최대 깊이 (default : 2)
* @author pjw
* @since  2018-11-28
* @description
*   고정 경로 : _modules/location/
*   신규 커스텀 네비게이션 생성 시 위 고정 경로 안에 파일을 생성 후 파일이름으로 인자값을 넘긴다.
*/
function showLocationLightNavigation($file_name=null, $code=null, $max_depth=2)
{

	$CI =& get_instance();
	$template_path  = $CI->__tmp_template_path ? $CI->__tmp_template_path : $CI->template_path;
	$skin_file_name = !empty($file_name) ? $file_name : 'location_gnb';

	//
	$cache_item_id = sprintf('location_navigation_%s_%s_%s_html', $skin_file_name, $code, $max_depth);
	$html = cache_load($cache_item_id);

	if ($html === false) {
		$skin_configuration		= skin_configuration($CI->skin);
		$location_template_path = $CI->skin.'/'.'_modules/location/'.$skin_file_name.'.html';
		$location_skin_filepath = ROOTPATH.'data/skin/'.$location_template_path;
		$location_skin_filename = basename($location_template_path);
		$locationNavigationKey  = "locationNavigation".uniqid();

		if(file_exists($location_skin_filepath)){
			$CI->load->model('locationmodel');
			$tmp_code = $code != null ? explode(',', $code) : null;

			$location = $CI->locationmodel->get_location_view('',$max_depth, '',$code);

			$CI->template->assign(array('location'=>$location,'locationNavigationKey'=>$locationNavigationKey));
			$CI->template->define(array('location'=>$location_template_path));
			$html = $CI->template->fetch("location");
		}else{
			$html = "<font color='red'>{$location_skin_filename} 파일을 찾을 수 없습니다.</font>";
		}

		//
		cache_save($cache_item_id, $html);
	}

	echo $html;
	return;
}

?>
