<?php

/* 인스타그램피드 출력 */
function showInstagramFeed()
{
	$CI = &get_instance();

	$CI->load->library('instagramlibrary');
	$instagram = $CI->instagramlibrary->getConfig();

	if ($instagram['use'] != 'Y') {
		return false;
	} else {
		// 피드 업데이트 시간이 한시간 이상 지나면 피드 자동 업데이트
		$CI->instagramlibrary->setFeedAuto();
	}

	$CI->load->model('instagramfeedmodel');

	// light 버전 추가
	$operation_type = $CI->config_system['operation_type'];

	$instagramFeed = config_load('instagramFeed');

	// 반응형
	if (!isset($instagramFeed['feed_cell_resp'])) {
		$instagramFeed['feed_cell_resp'] = 5;
	}
	if (!isset($instagramFeed['feed_count_resp'])) {
		$instagramFeed['feed_count_resp'] = 10;
	}

	// 전용스킨
	if (!isset($instagramFeed['feed_pdl'])) {
		$instagramFeed['feed_pdl'] = 15;
	}
	if (!isset($instagramFeed['feed_pdt'])) {
		$instagramFeed['feed_pdt'] = 15;
	}
	if (!isset($instagramFeed['feed_cell'])) {
		$instagramFeed['feed_cell'] = 5;
	}
	if (!isset($instagramFeed['feed_row'])) {
		$instagramFeed['feed_row'] = 2;
	}

	if ($operation_type == 'light') {
		$limit = $instagramFeed['feed_count_resp'];
	} else {
		$limit = $instagramFeed['feed_cell'] * $instagramFeed['feed_row'];
	}

	$feedList = $CI->instagramfeedmodel->getFeedList($limit, $instagram['username']);

	foreach ($feedList as $key => $data) {
		if ($operation_type == 'light') {
			$num = $key / $instagramFeed['feed_cell_resp'];
		} else {
			$num = $key / $instagramFeed['feed_cell'];
		}

		$datarow[$num][] = $data;
	}

	$CI->template->assign(['instagramFeed' => $instagramFeed]);
	$CI->template->assign(['feedloop' => $datarow]);

	$CI->template->define(['tpl' => $CI->skin . '/_modules/display/instagram_feed.html']);
	$CI->template->print_('tpl');
}
