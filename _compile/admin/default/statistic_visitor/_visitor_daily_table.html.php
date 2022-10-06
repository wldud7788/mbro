<?php /* Template_ 2.2.6 2022/05/17 12:37:19 /www/music_brother_firstmall_kr/admin/skin/default/statistic_visitor/_visitor_daily_table.html 000002114 */ 
$TPL_dataForTable_1=empty($TPL_VAR["dataForTable"])||!is_array($TPL_VAR["dataForTable"])?0:count($TPL_VAR["dataForTable"]);?>
<table width="100%" class="simpledata-table-style" style="margin:auto;">
	<col width="13%" /><col width="13%" /><col width="" /><col width="13%" /><col width="" /><col width="13%" />
	<tr>
		<th>일</th>
		<th>페이지뷰</th>
		<th>전일대비 증감율(페이지뷰)</th>
		<th>방문자수</th>
		<th>전일대비 증감율(방문자수)</th>
		<th>인당페이지뷰</th>
	</tr>
	<tr>
		<td align="center">합계</td>
		<td align="center"><font color="<?php echo $TPL_VAR["seriesColors"][ 0]?>"><?php echo number_format($TPL_VAR["dataForTableSum"]["pv"])?></font></td>
		<td align="center"></td>
		<td align="center"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_VAR["dataForTableSum"]["visit"])?></font></td>
		<td align="center"></td>
		<td align="center"><?php echo $TPL_VAR["dataForTableSum"]["pvPerVisit"]?></td>
	</tr>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_K1=>$TPL_V1){?>
	<tr>
		<td align="center"><?php echo $TPL_K1+ 1?>일</td>
		<td align="center"><font color="<?php echo $TPL_VAR["seriesColors"][ 0]?>"><?php echo number_format($TPL_V1["pv"])?></font></td>
		<td align="center"><?php echo round(abs($TPL_V1["pvGrowth"]), 1)?>% <?php if($TPL_V1["pvGrowth"]> 0){?><font color=blue>▲</font><?php }elseif($TPL_V1["pvGrowth"]< 0){?><font color=red>▼</font><?php }?></td>
		<td align="center"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_V1["visit"])?></font></td>
		<td align="center"><?php echo round(abs($TPL_V1["visitGrowth"]), 1)?>% <?php if($TPL_V1["visitGrowth"]> 0){?><font color=blue>▲</font><?php }elseif($TPL_V1["visitGrowth"]< 0){?><font color=red>▼</font><?php }?></td>
		<td align="center"><?php echo $TPL_V1["pvPerVisit"]?></td>
	</tr>
<?php }}?>
</table>