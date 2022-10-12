<?php

/* 동영상 출력*/
function showBatchGoodsData($goodsData)
{

	$CI =& get_instance();

	$html = array();

	$goods_seq = $goodsData['goods_seq'];
	$title = "상품코드";
	$href = "regist";

	if($goodsData['goods_kind'] == 'coupon') {
		$title = "티켓".$title;
		$href = "social_regist";
	} else if ($goodsData['goods_type'] == 'gift') {
		$title = "사은품코드";
		$href = "gift_regist";
	}
	if($goodsData['goods_code']) {
		$html[] = '<div><a href="../goods/'.$href.'?no='.$goods_seq.'" target="_blank"><span class="fx11 gray">['.$title.': '.$goodsData['goods_code'].']</span></a></div>';
	}
	
	$html[] = '<div>';
	$html[] = '<a href="../goods/'.$href.'?no='.$goods_seq.'" target="_blank" style="text-decoration:underline !important" >'.getstrcut($goodsData['goods_name'],80).'</a>';
	$html[] = '  <div>';
	if($goodsData['adult_goods'] == 'Y') {
		$html[] = '<img src="../skin/default/images/common/auth_img.png" alt="성인"/>';
	}
	if($goodsData['option_international_shipping_status'] == 'Y') {
		$html[] = '<img src="../skin/default/images/common/icon/icon_inter_ship.png" alt="해외배송상품"/>';
	}
	if($goodsData['cancel_type'] == '1') {
		$html[] = '<img src="../skin/default/images/common/icon/nocancellation.gif" alt="청약철회"/>';
	}
	if($goodsData['tax'] == 'exempt') {
		$html[] = '<img src="../skin/default/images/common/icon/taxfree.gif" alt="비과세"/>';
	}
	$html[] = '  </div>';
	$html[] = '</div>';
	

	echo implode($html);

}
?>