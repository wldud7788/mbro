<?php /* Template_ 2.2.6 2022/05/17 12:29:33 /www/music_brother_firstmall_kr/selleradmin/skin/default/statistic_goods/_sales_daily_calendar.html 000002335 */ ?>
<table class="table_basic">
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
	<?php  $TPL_VAR["c_sales_price_row_sum"] +=  $TPL_VAR["dataForChart"]['결제금액'][$TPL_VAR["c_day"]- 1] ?>	
	<?php  $TPL_VAR["c_interests_row_sum"] +=  $TPL_VAR["dataForChart"]['매출액'][$TPL_VAR["c_day"]- 1] ?>	
	
	<td class="day-cell">
<?php if($TPL_VAR["c_day"]> 0&&$TPL_VAR["c_day"]<=$TPL_VAR["c_end_idx"]){?>
		<table class="calendar-table-inner" width="100%">
		<tr><td align="right" style="border-bottom:1px solid #ccc"><b><?php echo $TPL_VAR["c_day"]?></b></td></tr>
		<tr><td align="right" style="border-bottom:1px dashed #ccc"><font color="<?php echo $TPL_VAR["seriesColors"][ 0]?>"><?php echo number_format($TPL_VAR["dataForChart"]['결제금액'][$TPL_VAR["c_day"]- 1])?></font></td></tr>
		<tr><td align="right"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_VAR["dataForChart"]['매출액'][$TPL_VAR["c_day"]- 1])?></font></td></tr>
		</table>
<?php }?>
	</td>
<?php }}?>
	
	<td class="day-cell">
		<table class="calendar-table-inner" width="100%">
			<tr><td align="left" >&nbsp;</td></tr>
			<tr><td align="right"><font color="<?php echo $TPL_VAR["seriesColors"][ 0]?>"><?php echo number_format($TPL_VAR["c_sales_price_row_sum"])?></font></td></tr>
			<tr><td align="right"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_VAR["c_interests_row_sum"])?></font></td></tr>
		</table>
	</td>
</tr>
<?php }}?>
</table>