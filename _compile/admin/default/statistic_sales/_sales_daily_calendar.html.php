<?php /* Template_ 2.2.6 2022/05/17 12:37:16 /www/music_brother_firstmall_kr/admin/skin/default/statistic_sales/_sales_daily_calendar.html 000002849 */ ?>
<style>
table.calendar-table-style {border-collapse:collapse;}
table.calendar-table-style th {padding:4px; font-size:11px; background-color:#f5f5f5;}
table.calendar-table-style th,
table.calendar-table-style td {border:1px solid #999;}
table.calendar-table-inner {border-collapse:collapse;}
table.calendar-table-inner td {border:0px; font-size:11px; padding:3px;}
table.calendar-table-inner td b {color:#333;}
</style>

<table class="simpledata-table-style" width="100%">
<col width="12.5%" />
<col width="12.5%" />
<col width="12.5%" />
<col width="12.5%" />
<col width="12.5%" />
<col width="12.5%" />
<col width="12.5%" />
<col width="12.5%" />
<tr>
	<th>일</th>
	<th>월</th>
	<th>화</th>
	<th>수</th>
	<th>목</th>
	<th>금</th>
	<th>토</th>
	<th>합계</th>
</tr>
<?php if(is_array($TPL_R1=range( 0,$TPL_VAR["c_row"]- 1))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<tr>
	<?php  $TPL_VAR["c_sales_price_row_sum"] = 0 ?>
	<?php  $TPL_VAR["c_interests_row_sum"] = 0 ?>

<?php if(is_array($TPL_R2=range( 0, 7- 1))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<?php  $TPL_VAR["c_day"] = ( $TPL_V1*7)+ $TPL_V2- $TPL_VAR["c_start_idx"]+1 ?>
	<?php  $TPL_VAR["c_sales_price_row_sum"] +=  $TPL_VAR["dataForChart"]['매출'][$TPL_VAR["c_day"]- 1] ?>	
	<?php  $TPL_VAR["c_interests_row_sum"] +=  $TPL_VAR["dataForChart"]['매출이익'][$TPL_VAR["c_day"]- 1] ?>	
	
	<td class="day-cell">
<?php if($TPL_VAR["c_day"]> 0&&$TPL_VAR["c_day"]<=$TPL_VAR["c_end_idx"]){?>
		<table class="calendar-table-inner" width="100%">
		<tr><td align="right" style="border-bottom:1px solid #ccc"><b><?php echo $TPL_VAR["c_day"]?></b></td></tr>
		<tr><td align="right" style="border-bottom:1px dashed #ccc"><font color="<?php echo $TPL_VAR["seriesColors"][ 0]?>"><?php echo number_format($TPL_VAR["dataForChart"]['매출'][$TPL_VAR["c_day"]- 1])?></font></td></tr>
		<tr><td align="right"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_VAR["dataForChart"]['매출이익'][$TPL_VAR["c_day"]- 1])?></font></td></tr>
		</table>
<?php }?>
	</td>
<?php }}?>
	
	<td class="day-cell">
		<table class="calendar-table-inner" width="100%">
		<tr><td align="right" style="border-bottom:1px solid #ccc">&nbsp;</td></tr>
		<tr><td align="right" style="border-bottom:1px dashed #ccc"><font color="<?php echo $TPL_VAR["seriesColors"][ 0]?>"><?php echo number_format($TPL_VAR["c_sales_price_row_sum"])?></font></td></tr>
		<tr><td align="right"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_VAR["c_interests_row_sum"])?></font></td></tr>
		</table>
	</td>
</tr>
<?php }}?>
</table>