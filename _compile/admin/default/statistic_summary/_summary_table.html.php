<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/statistic_summary/_summary_table.html 000003600 */ 
$TPL_tableData_1=empty($TPL_VAR["tableData"])||!is_array($TPL_VAR["tableData"])?0:count($TPL_VAR["tableData"]);?>
<div class="title_dvs">
	<div class="item-title">통계 상세</div>
	<button type="button" onclick="divExcelDownload('주요통계요약','#summary_table')" class="resp_btn v3"/> <img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /><span>다운로드</span></button>
</div>

<div id="summary_table">
	<table class="table_basic v7">
		<colgroup>
			<col width="20%"/>
			<col width="20%" />
			<col width="20%" />
			<col width="20%" />
			<col width="20%" />
		</colgroup>
		<thead>
			<tr>
				<th></th>
				<th>전월 평균</th>
				<th>지난주(7일) 평균</th>
				<th>어제</th>
				<th>오늘</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_tableData_1){$TPL_I1=-1;foreach($TPL_VAR["tableData"] as $TPL_V1){$TPL_I1++;?>
			<tr>
				<th class="left"><?php echo $TPL_V1["title"]?></th>
<?php if($TPL_I1> 4&&$TPL_VAR["statistic_summary_detail_limit"]=='Y'){?>
<?php if($TPL_I1== 5){?>
				<td class="center" rowspan="7" colspan="4">
					<img src="/admin/skin/default/images/common/btn_upgrade.gif" style="cursor:pointer;" onclick="window.open('https://firstmall.kr/ec_hosting/addservice/frelocate.php?p=upgrade&s=P_FREE');" />
				</td>
<?php }?>
<?php }else{?>
<?php if(isset($TPL_V1["mStr"])){?>
				<td>
<?php if($TPL_V1["best"]=='mPer'){?><?php echo $TPL_V1["mStr"]?><?php }else{?><?php echo str_replace('class="redFont"','',$TPL_V1["mStr"])?><?php }?>
				</td>
<?php }else{?>
				<td class="right">
<?php if($TPL_V1["best"]=='mPer'){?><font color="red"><?php }?>
						<?php echo number_format($TPL_V1["mPer"])?> (<?php echo number_format($TPL_V1["mTotal"], 1)?>)
<?php if($TPL_V1["best"]=='mPer'){?></font><?php }?>
				</td>
<?php }?>
<?php if(isset($TPL_V1["wStr"])){?>
				<td>
<?php if($TPL_V1["best"]=='wPer'){?><?php echo $TPL_V1["wStr"]?><?php }else{?><?php echo str_replace('class="redFont"','',$TPL_V1["wStr"])?><?php }?>
				</td>
<?php }else{?>
				<td class="right">
<?php if($TPL_V1["best"]=='wPer'){?><font color="red"><?php }?>
						<?php echo number_format($TPL_V1["wPer"])?> (<?php echo number_format($TPL_V1["wTotal"], 1)?>)
<?php if($TPL_V1["best"]=='wPer'){?></font><?php }?>
				</td>
<?php }?>
<?php if(isset($TPL_V1["bStr"])){?>
				<td>
<?php if($TPL_V1["best"]=='bTotal'){?><?php echo $TPL_V1["bStr"]?><?php }else{?><?php echo str_replace('class="redFont"','',$TPL_V1["bStr"])?><?php }?>
				</td>
<?php }else{?>
				<td class="right">
<?php if($TPL_V1["best"]=='bTotal'){?><font color="red"><?php }?>
						<?php echo number_format($TPL_V1["bTotal"])?>

<?php if($TPL_V1["best"]=='bTotal'){?></font><?php }?>
				</td>
<?php }?>
<?php if(isset($TPL_V1["nStr"])){?>
				<td>
<?php if($TPL_V1["best"]=='Total'){?><?php echo $TPL_V1["nStr"]?><?php }else{?><?php echo str_replace('class="redFont"','',$TPL_V1["nStr"])?><?php }?>
				</td>
<?php }else{?>
				<td class="right">
<?php if($TPL_V1["best"]=='Total'){?><font color="red"><?php }?>
						<?php echo number_format($TPL_V1["Total"])?>

<?php if($TPL_V1["best"]=='Total'){?></font><?php }?>
				</td>
<?php }?>
<?php }?>
			</tr>
<?php }}?>
		</tbody>
	</table>
</div>
<div class="resp_message">
	- 빨간색으로 표기된 항목은 전월 평균/지난주(7일 평균)/어제/오늘 중 가장 높은 값입니다.
</div>