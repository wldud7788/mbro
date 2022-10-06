<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/partner/navercheckout_item.html 000001712 */ 
$TPL_result_1=empty($TPL_VAR["result"])||!is_array($TPL_VAR["result"])?0:count($TPL_VAR["result"]);?>
<response>
<?php if($TPL_result_1){foreach($TPL_VAR["result"] as $TPL_V1){
$TPL_arr_category_2=empty($TPL_V1["arr_category"])||!is_array($TPL_V1["arr_category"])?0:count($TPL_V1["arr_category"]);?>
<item id="<?php echo $TPL_V1["goods_seq"]?>">
<name><![CDATA[<?php echo $TPL_V1["goods_name"]?>]]></name>
<url>http://<?php echo $_SERVER["HTTP_HOST"]?>/goods/view?no=<?php echo $TPL_V1["goods_seq"]?></url>
<description><![CDATA[<?php echo $TPL_V1["contents"]?>]]></description>
<image><?php echo $TPL_V1["viewimg"]?></image>
<thumb><?php echo $TPL_V1["list1img"]?></thumb>
<price><?php echo $TPL_V1["price"]?></price>
<quantity><?php echo $TPL_V1["tot_stock"]?></quantity>
<options>
<?php if(is_array($TPL_R2=$TPL_V1["options"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<option name="<?php echo $TPL_K2?>">
<?php if(is_array($TPL_R3=$TPL_V2)&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?><select><![CDATA[<?php echo $TPL_V3?>]]></select>
<?php }}?>
</option>
<?php }}?>
</options>
<category>
<?php if($TPL_arr_category_2){$TPL_I2=-1;foreach($TPL_V1["arr_category"] as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_I2== 0){?>
<first><?php echo $TPL_V2?></first>
<?php }?>
<?php if($TPL_I2== 1){?>
<second><?php echo $TPL_V2?></second>
<?php }?>
<?php if($TPL_I2== 2){?>
<third><?php echo $TPL_V2?></first>
<?php }?>
<?php if($TPL_I2== 3){?>
<fourth><?php echo $TPL_V2?></first>
<?php }?>
<?php }}?>
</category>
</item>
<?php }}?>
</response>