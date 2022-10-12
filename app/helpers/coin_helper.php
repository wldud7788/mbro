<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// iframe 허용 도메인 목록 (구분자 콤마(,) 사용)
define('__IFRAME_VALID_DOMAIN__', 'youtube.com,naver.com,daum.net,vimeo.com,ustream.tv,smartucc.kr,google.com,google.co.kr,play-tv.kakao.com');

function value {
	$sql = "SELECT * FROM `fm_coin_quotes` ORDER BY id DESC LIMIT 1";
	$query = $this->db->query($sql);
	$row = $coin_query->row_array(); // db쿼리해서 가져온 것 배열화 
}
?>