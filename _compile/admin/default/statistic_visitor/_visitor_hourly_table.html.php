<?php /* Template_ 2.2.6 2022/05/17 12:37:19 /www/music_brother_firstmall_kr/admin/skin/default/statistic_visitor/_visitor_hourly_table.html 000001492 */ 
$TPL_dataForTable_1=empty($TPL_VAR["dataForTable"])||!is_array($TPL_VAR["dataForTable"])?0:count($TPL_VAR["dataForTable"]);?>
<table width="100%" class="simpledata-table-style" style="margin:auto;">
	<col width="25%" /><col width="25%" /><col width="25%" /><col width="25%" />
	<tr>
		<th>시간</th>
		<th>페이지뷰</th>
		<th>방문자수</th>
		<th>인당페이지뷰</th>
	</tr>
	<tr>
		<td align="center">합계</td>
		<td align="center"><font color="<?php echo $TPL_VAR["seriesColors"][ 0]?>"><?php echo number_format($TPL_VAR["dataForTableSum"]["pv"])?></font></td>
		<td align="center"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_VAR["dataForTableSum"]["visit"])?></font></td>
		<td align="center"><?php echo $TPL_VAR["dataForTableSum"]["pvPerVisit"]?></td>
	</tr>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_K1=>$TPL_V1){?>
	<tr>
		<td align="center"><?php echo $TPL_K1?>시</td>
		<td align="center"><font color="<?php echo $TPL_VAR["seriesColors"][ 0]?>"><?php echo number_format($TPL_V1["pv"])?></font></td>
		<td align="center"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_V1["visit"])?></font></td>
		<td align="center"><?php echo $TPL_V1["pvPerVisit"]?></td>
	</tr>
<?php }}?>
</table>