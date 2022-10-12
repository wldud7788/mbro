<?php
function showSearchRecentUse(){
	$sUse = "on";
	if(get_cookie('searchRecent') == 'off') $sUse = "off";
	return $sUse;
}
?>