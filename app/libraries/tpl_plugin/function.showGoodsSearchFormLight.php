<?php
/* 상품검색폼 출력*/
function showGoodsSearchFormLight()
{
	$CI =& get_instance();
	$CI->template->define(array("goods_search_form"=>$CI->skin."/goods/_search_form_light.html"));
	$CI->template->print_("goods_search_form");
}