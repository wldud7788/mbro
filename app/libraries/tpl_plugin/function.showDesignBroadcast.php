<?php
/* 상품디스플레이 출력*/
function showDesignBroadcast($display_seq){

	$CI =& get_instance();
	$CI->load->model('broadcastmodel');
	$CI->load->model('broadcastdisplay');
	$CI->load->helper('broadcast');
	
	$broadcast_display					= $CI->broadcastdisplay->getDisplayData($display_seq);
	$broadcast_display_key						= $CI->broadcastdisplay->makeDisplayKey();				// 디스플레이 임시 코드명
	if(!$broadcast_display) return;

	// 디스플레이에 맞는 방송 추출
	$sc = array();
	if($broadcast_display['status'] == 'vod') {
		$sc['display'] = 'on';
		$sc['status'] = array('end');	//방송종료 
		$sc['is_save'] = true;//방송일시기준
		$sc['is_vod_key'] = true;//방송일시기준
	} else if($broadcast_display['status'] == 'live') {
		$sc['display'] = 'on';
		$sc['status'] = array('create','live');	//방송중,방송예정 
		$sc['is_live'] = true;
	}

	// limit 
	$perpage = 5;
	switch($broadcast_display['style']) {
		// pc & 모바일(반응형) 단일형
		case 'full' :  
			$perpage = $broadcast_display['count_f'];
			break;
		// pc 수평롤링형
		case 'rolling' :
			$perpage = $broadcast_display['count_s'] * $broadcast_display['count_r'];
			break;
		// pc 격자형
		case 'lattice_a' :
			$perpage = $broadcast_display['count_w'] * $broadcast_display['count_h'];
			break;
		// 모바일(반응형) 슬라이드형
		case 'slide' :
			$perpage = $broadcast_display['count_s'];
			break;
		// 모바일(반응형) 격자형
		case 'lattice_r' :
			$broadcast_display['count_h'] = 1;
			$perpage = $broadcast_display['count_r'] * $broadcast_display['count_h'];
			break;
	}
	$sc['perpage'] = $perpage;

	// sort
	if( $broadcast_display['sort'] == 'direct') {
		$bc_items = $CI->broadcastdisplay->getBroadcastItem($display_seq);
		$bs_seqs = array();
		foreach($bc_items as $item) {
			$bs_seqs[] = $item['bs_seq'];
		}
		$sc['bs_seq'] = $bs_seqs;
	} else if($broadcast_display['sort'] == 'new' ) {
		$sc['orderby'] = "b.start_date";
		$sc['sort'] = "asc";
	} else {
		$sc['orderby'] = $broadcast_display['sort'];
	}


	$list = $CI->broadcastmodel->getSch($sc);
	broadcastlist($list);
	// 방송예약 방송 시작 시간
	foreach($list as &$row) {
		$row['start_date_day'] = date("m월 d일",strtotime($row['start_date']));
		$row['start_date_hour'] = date("H:i",strtotime($row['start_date']));
	}

	if($broadcast_display['status'] == 'vod') {
		$broadcast_link = "/broadcast/vod?no=";
	} else {
		$broadcast_link = "/broadcast/player?no=";
	}

	$CI->template->assign('broadcast_display_key', $broadcast_display_key);
	$CI->template->assign('broadcastList', $list);
	$CI->template->assign('count_s', $broadcast_display['count_s']);
	$CI->template->assign('count_w', $broadcast_display['count_w']);
	$CI->template->assign('count_h', $broadcast_display['count_h']);
	$CI->template->assign('broadcast_display_seq', $display_seq);
	$CI->template->assign('broadcast_link', $broadcast_link);
	$CI->template->assign('displayElement', 'designBroadcast');

	$CI->template->define('tpl',		$CI->skin."/_modules/broadcast/broadcast_display_{$broadcast_display['style']}.html");
	$CI->template->print_("tpl", '', true);
	// 디스플레이 print_
}


?>