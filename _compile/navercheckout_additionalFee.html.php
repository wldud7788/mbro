<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/partner/navercheckout_additionalFee.html 000000483 */ 
$TPL_result_1=empty($TPL_VAR["result"])||!is_array($TPL_VAR["result"])?0:count($TPL_VAR["result"]);?>
<additionalFees>
<?php if($TPL_result_1){foreach($TPL_VAR["result"] as $TPL_V1){?>
	<additionalFee>
		<id><?php echo $TPL_V1["id"]?></id>
		<surprice><?php echo $TPL_V1["surprice"]?></surprice>
	</additionalFee>
<?php }}?>
</additionalFees>