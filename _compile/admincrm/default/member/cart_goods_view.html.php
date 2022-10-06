<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admincrm/skin/default/member/cart_goods_view.html 000000976 */ 
$TPL_cartResult_1=empty($TPL_VAR["cartResult"])||!is_array($TPL_VAR["cartResult"])?0:count($TPL_VAR["cartResult"]);?>
<table width="100%" cellspacing="0" cellpadding="0">
<?php if($TPL_cartResult_1){foreach($TPL_VAR["cartResult"] as $TPL_V1){?>
		<tr>
			<td width="70" rowspan="2"><a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo $TPL_V1["image"]?>" width="70" height="50" onerror="/data/skin/default/images/common/noimage.gif"></a></td>
			<td align="left" style="padding-left:5px;"><a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo $TPL_V1["goods_name"]?></a></td>
		</tr>
		<tr>
			<td style="padding-left:5px;"><?php echo $TPL_V1["price"]?></td>
		</tr>
		<tr><td colspan="2" height="10"></td></tr>
<?php }}?>
</table>