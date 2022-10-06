<?php /* Template_ 2.2.6 2022/05/17 12:37:16 /www/music_brother_firstmall_kr/admin/skin/default/statistic_sales/_referer_price_table.html 000001349 */ 
$TPL_table_title_1=empty($TPL_VAR["table_title"])||!is_array($TPL_VAR["table_title"])?0:count($TPL_VAR["table_title"]);
$TPL_statlist_1=empty($TPL_VAR["statlist"])||!is_array($TPL_VAR["statlist"])?0:count($TPL_VAR["statlist"]);?>
<table width="100%" class="simpledata-table-style" style="margin:auto;">
<thead>
<tr>
	<th style="width:30px"></th>
	<th widht="10%">유입경로별 판매금액</th>
<?php if($TPL_table_title_1){foreach($TPL_VAR["table_title"] as $TPL_V1){?>
	<th width="*"><?php echo $TPL_V1?></th>
<?php }}?>
	<th width="7%">합계</th>
</tr>
</thead>
<tbody>
<?php if($TPL_statlist_1){$TPL_I1=-1;foreach($TPL_VAR["statlist"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
<tr>
	<td class="ctd"><input type="checkbox" name="priceCode[]" value="<?php echo $TPL_K1?>" titleName="<?php echo $TPL_K1?>" <?php if($TPL_I1== 0){?>checked<?php }?> /></td>
	<td class="ctd"><?php echo $TPL_K1?></td>
<?php if(is_array($TPL_R2=$TPL_V1["list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td class="rtd"><?php echo number_format($TPL_V2["price"])?></td>
<?php }}?>
	<td class="rtd"><?php echo number_format($TPL_V1["total_price"])?></td>
</tr>
<?php }}?>
</tbody>
</table>