<?php

/* 모바일 메인상단바 출력*/
function showMainTopBar($template_path='')
{
	$CI =& get_instance();
	$CI->load->model('designmodel');

	//
	$cache_item_id = 'skin_main_top_bar_html';
	$html = cache_load($cache_item_id);

	if ($html === false) {
		$skin_configuration = skin_configuration($CI->skin);
		$topbar_template_path = $CI->skin.'/'.'_modules/common/topbar.html';
		$topbar_skin_filepath = ROOTPATH.'data/skin/'.$topbar_template_path;

		$html = '';
		if(file_exists($topbar_skin_filepath)){
			$topbar	= explode('|', $skin_configuration['topbar']);
			$query = $CI->designmodel->get_topbar($CI->skin);
			if ($query) {
				$data = $query->result_array();
			}
			if (sizeOf($data) == 0) {
				$query = $CI->designmodel->get_topbar();
				if ($query) {
					$data = $query->result_array();
				}
			}

			$opt["tab_type"] = $data[0]["tab_type"];
			$opt["tab_style"] = $data[0]["tab_style"];
			$opt["tab_cursor"] = $data[0]["tab_cursor"];
			$opt["tab_img_prev"] = $data[0]["tab_img_prev"];
			$opt["tab_img_next"] = $data[0]["tab_img_next"];

			$CI->template->assign(array('lists'=>$data,'opt'=>$opt));
			$CI->template->define(array('topbar'=>$topbar_template_path));
			$html = $CI->template->fetch("topbar");
		}

		//
		cache_save($cache_item_id, $html);
	}

	//
	echo $html;

	return;
}

?>
