<?php /* Template_ 2.2.6 2022/05/17 12:37:19 /www/music_brother_firstmall_kr/admin/skin/default/statistic_visitor/_visitor_referer_table.html 000001481 */ 
$TPL_refererData_1=empty($TPL_VAR["refererData"])||!is_array($TPL_VAR["refererData"])?0:count($TPL_VAR["refererData"]);?>
<script type="text/javascript">
	$(function(){
		$(".referer_link").click(function(){
			var refer		= $(this).attr("href");
			var refer_tmp	= refer.split("?");
			$(this).attr("href",refer_tmp[0].replaceAll("adcr.naver","search.naver")+"?"+refer_tmp[1]);
		});
	});
</script>

<table width="100%" class="simpledata-table-style" style="margin:auto;">
	<col /><col width="100" />
	<tr>
		<th>유입경로</th>
		<th>방문자수</th>
	</tr>
<?php if($TPL_refererData_1){foreach($TPL_VAR["refererData"] as $TPL_V1){?>
	<?php  $TPL_VAR["refererCountSum"] +=  $TPL_V1["count"]?>
	<tr>
		<td style="word-break:break-all;" class="pdl10"><?php if($TPL_V1["referer"]){?><a href="<?php echo $TPL_V1["referer"]?>" target="_blank" class="referer_link"><?php echo $TPL_V1["referer"]?></a><?php }else{?>직접입력<?php }?></td>
		<td class="center"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_V1["count"])?></font></td>
	</tr>
<?php }}?>
	<tr>
		<td class="pdl10"><b>합계</b></td>
		<td class="center"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_VAR["refererCountSum"])?></font></td>
	</tr>
</table>