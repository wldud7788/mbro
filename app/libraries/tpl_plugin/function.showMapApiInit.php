<?php
/* 네이버 맵 스크립트 선 로딩 출력 */
function showMapApiInit()
{
	$CI			=& get_instance();
	$appKey		= $CI->arrSns['key_k']; //카카오 자바스크립트 앱키
	//
	// 사용안 할때는 영역 자체를 안 그리도록 수정
	if($CI->arrSns['use_k']){
		echo "<script type='text/javascript' src='//dapi.kakao.com/v2/maps/sdk.js?appkey=".$appKey."&libraries=services,drawing'></script>";
	}
}
?>