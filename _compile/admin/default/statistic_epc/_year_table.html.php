<?php /* Template_ 2.2.6 2022/05/17 12:37:07 /www/music_brother_firstmall_kr/admin/skin/default/statistic_epc/_year_table.html 000001676 */ ?>
<table width="100%" class="simpledata-table-style" style="margin:auto;">
<tr>
	<th>항목</th>
<?php if(is_array($TPL_R1=$TPL_VAR["dataForChart"]['before_total'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	<th align="center"><?php echo $TPL_V1[ 0]?></th>
<?php }}?>
</tr>
<tr>
	<td align="center">전월(년) 이월</td>
<?php if(is_array($TPL_R1=$TPL_VAR["dataForChart"]['before_total'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	<td align="center"><?php echo get_currency_price($TPL_V1[ 1])?></td>
<?php }}?>
</tr>
<tr>
	<td align="center">지급</td>
<?php if(is_array($TPL_R1=$TPL_VAR["dataForChart"]['plus'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	<td align="center"><?php echo get_currency_price($TPL_V1[ 1])?></td>
<?php }}?>
</tr>
<tr>
	<td align="center">사용</td>
<?php if(is_array($TPL_R1=$TPL_VAR["dataForChart"]['minus'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	<td align="center"><?php echo get_currency_price($TPL_V1[ 1])?></td>
<?php }}?>
</tr>
<tr>
	<td align="center">소멸</td>
<?php if(is_array($TPL_R1=$TPL_VAR["dataForChart"]['limits'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	<td align="center"><?php echo get_currency_price($TPL_V1[ 1])?></td>
<?php }}?>
</tr>
<tr>
	<td align="center">당월 누적합계</td>
<?php if(is_array($TPL_R1=$TPL_VAR["dataForChart"]['after_total'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	<td align="center"><?php echo get_currency_price($TPL_V1[ 1])?></td>
<?php }}?>
</tr>
</table>