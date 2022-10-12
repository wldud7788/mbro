<?php
function facebook_ver($source, $tpl){
	
	$fbversion = (__FB_APP_VER__)?'v'.__FB_APP_VER__:"v2.0";

	if( !( preg_match("/(FB\.init\(\{)/",$source) && (preg_match("/(.*version)(.*:)(.*\'$fbversion\')/",$source) || preg_match("/(.*version)(.*:)(.*\'v{APP_VER}\')/",$source)) ) && ( !preg_match("/(FB\.init\(\{)(.*version)(.*:)(.*$fbversion)/",$source) || !preg_match("/(FB\.init\(\{)(.*version)(.*:)(.*v{APP_VER})/",$source)) ) {//한줄처리와 여려줄의 경우 검색
		$source = str_replace("FB.init({","FB.init({version:'$fbversion',",$source);
	}
	if( preg_match("/connect.facebook.net\/ko_KR\/all.js/",$source) ) {
		$source=str_replace("connect.facebook.net/ko_KR/all.js","connect.facebook.net/ko_KR/sdk.js",$source);
	}
	return $source;
}

?>