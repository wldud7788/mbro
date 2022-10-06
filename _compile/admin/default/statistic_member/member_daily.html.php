<?php /* Template_ 2.2.6 2022/05/30 15:58:33 /www/music_brother_firstmall_kr/admin/skin/default/statistic_member/member_daily.html 000012597 */ 
$TPL_statlist_1=empty($TPL_VAR["statlist"])||!is_array($TPL_VAR["statlist"])?0:count($TPL_VAR["statlist"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

  
<!--[if IE]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />
<style>
	table.calendar-table-style {border-collapse:collapse;}
	table.calendar-table-style th {padding:4px; font-size:11px; background-color:#f5f5f5;}
	table.calendar-table-style th,
	table.calendar-table-style td {border:1px solid #999;}
	table.calendar-table-inner {border-collapse:collapse;}
	table.calendar-table-inner td {border:0px; font-size:11px; padding:3px;}
	table.calendar-table-inner td b {color:#333;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">
	
		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
		</ul>
		
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>가입 통계</h2>
		</div>
		
		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="sub-layout-container body-height-resizing">	
<?php $this->print_("member_menu",$TPL_SCP,1);?>

	
	<!-- 서브메뉴 바디 : 시작-->
	<div class='slc-body-wrap'>
		<div class="slc-body">
					
			<div style="width:100%; margin:auto;">				
				<div class="item-title">가입 통계 - 기본</div>				
				<br style="line-height:10px" />
				
				<div class="statistic_goods pd20 center">
					<form>					
						<label><input type="radio" name="date_type" value="month" /> 월별</label>
						<label><input type="radio" name="date_type" value="daily" checked /> 일별</label>
						<label><input type="radio" name="date_type" value="hour" /> 시간별</label>

						<select name="year">
						<option value="">= 연도 선택 =</option>
<?php if(is_array($TPL_R1=range(date('Y'), 2010))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["year"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 년</option>
<?php }}?>
						</select>
						
						<span class="scMonth">
						<select name="month">
						<option value="">= 월 선택 =</option>
<?php if(is_array($TPL_R1=range( 1, 12))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["month"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 월</option>
<?php }}?>
						</select>
						</span>

						<span class="scDay hide">
						<select name="day">
						<option value="">= 일 선택 =</option>
<?php if(is_array($TPL_R1=range( 1, 31))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["day"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 일</option>
<?php }}?>
						</select>
						</span>
				
						<span class="btn medium cyanblue"><input type="submit" value="검색" /></span>
						<span class="btn_scMonth">
						<span class="btn medium"><input type="button" value="이번달" class="normal" onclick="this.form.year.value='';this.form.month.value='';this.form.submit()" /></span>
						</span>
						<span class="btn_scDay hide">
						<span class="btn medium"><input type="button" value="오늘" class="normal" onclick="this.form.year.value='';this.form.month.value='';this.form.day.value='';this.form.submit()" /></span>
						</span>					
					</form>
				</div>
				<br style="line-height:10px" />

				<div id="chart1" style="margin:auto; height:250px; width:1000px;"></div>
				<br style="line-height:20px" />

				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 1200px; margin:auto;">
					<tr>
						<td align="right" valign="bottom" class="pdb10"><span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('일별_가입자_달력','#visitor_daily_calendar')" /></span></td>
					</tr>
				</table>
				<br style="line-height:10px" />

				<div id="visitor_daily_calendar" style="max-width: 1200px; margin:auto;">
					<table class="simpledata-table-style" width="100%">
						<colgroup>
							<col width="12.5%" />
							<col width="12.5%" />
							<col width="12.5%" />
							<col width="12.5%" />
							<col width="12.5%" />
							<col width="12.5%" />
							<col width="12.5%" />
							<col width="12.5%" />
						</colgroup>
						<thead>
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
						</thead>
						<tbody>
							<tr>
<?php if($TPL_statlist_1){$TPL_I1=-1;foreach($TPL_VAR["statlist"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1< 1&&$TPL_VAR["start_week"]> 0){?>
<?php if(is_array($TPL_R2=range( 0,$TPL_VAR["start_week"]- 1))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<td></td>
<?php }}?>
<?php }?>
								<td>
									<table class="calendar-table-inner" width="100%">
									<tr><td align="right" style="border-bottom:1px solid #ccc"><b><?php echo $TPL_K1?></b></td></tr>
									<tr><td align="right" style="border-bottom:1px dashed #ccc"><font color="<?php echo $TPL_VAR["seriesColors"][ 0]?>"><?php echo number_format($TPL_V1["cnt"])?></font></td></tr>
									<tr><td align="right"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_V1["vcnt"])?></font></td></tr>
									</table>
								</td>

<?php if($TPL_V1["week"]){?>
								<td>
									<table class="calendar-table-inner" width="100%">
									<tr><td align="right" style="border-bottom:1px solid #ccc;"><b>&nbsp;</b></td></tr>
									<tr><td align="right" style="border-bottom:1px dashed #ccc;"><font color="<?php echo $TPL_VAR["seriesColors"][ 0]?>"><?php echo number_format($TPL_V1["week_cnt"])?></font></td></tr>
									<tr><td align="right"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_V1["week_vcnt"])?></font></td></tr>
									</table>
								</td>
								</tr><tr>
<?php }?>

<?php if($TPL_V1["end_day"]> 0&&$TPL_VAR["end_week"]< 6){?>
<?php if(is_array($TPL_R2=range($TPL_VAR["end_week"]+ 1, 6))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<td></td>
<?php }}?>
								<td>
									<table class="calendar-table-inner" width="100%">
									<tr><td align="right" style="border-bottom:1px solid #ccc;"><b>&nbsp;</b></td></tr>
									<tr><td align="right" style="border-bottom:1px dashed #ccc;"><font color="<?php echo $TPL_VAR["seriesColors"][ 0]?>"><?php echo number_format($TPL_V1["week_cnt"])?></font></td></tr>
									<tr><td align="right"><font color="<?php echo $TPL_VAR["seriesColors"][ 1]?>"><?php echo number_format($TPL_V1["week_vcnt"])?></font></td></tr>
									</table>
								</td>
<?php }?>
<?php }}?>
							</tr>
						</tbody>
					</table>
				</div>				
				<br style="line-height:20px" />
				
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 1200px; margin:auto;">
					<tr>
						<td align="right" valign="bottom" class="pdb10"><span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('일별_가입자수','#visitor_daily_table')" /></span></td>
					</tr>
				</table>
				<div id="visitor_daily_table" style="max-width: 1200px; margin:auto;">
					<table width="100%" class="simpledata-table-style" style="margin:auto;">
						<colgroup>
							<col width="13%" />
							<col width="13%" />
							<col width="" />
							<col width="13%" />
							<col width="" />
							<col width="13%" />
						</colgroup>
						<thead>
							<tr>
								<th>일</th>
								<th>가입자수</th>
								<th>전일대비 증감율(가입자수)</th>
								<th>방문자수</th>
								<th>전일대비 증감율(방문자수)</th>
								<th>가입율</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td align="center">합계</td>
								<td align="center"><font color="#445ebc"><?php echo number_format($TPL_VAR["total"]["cnt"])?></font></td>
								<td align="center"></td>
								<td align="center"><font color="#d33c34"><?php echo number_format($TPL_VAR["total"]["vcnt"])?></font></td>
								<td align="center"></td>
								<td align="center"><?php echo $TPL_VAR["total"]["jper"]?>%</td>
							</tr>
<?php if($TPL_statlist_1){foreach($TPL_VAR["statlist"] as $TPL_K1=>$TPL_V1){?>
							<tr>
								<td align="center"><?php echo $TPL_K1?>일</td>
								<td align="center"><font color="#445ebc"><?php echo number_format($TPL_V1["cnt"])?></font></td>
								<td align="center">
<?php if($TPL_V1["per"]== 0){?>0%<?php }elseif($TPL_V1["per"]> 0){?><?php echo $TPL_V1["per"]?>%<font color="blue">▲</font>
<?php }else{?><?php echo ($TPL_V1["per"]* - 1)?>%<font color="red">▼</font><?php }?>
								</td>
								<td align="center"><font color="#d33c34"><?php echo number_format($TPL_V1["vcnt"])?></font></td>
								<td align="center">
<?php if($TPL_V1["vper"]== 0){?>0%<?php }elseif($TPL_V1["vper"]> 0){?><?php echo $TPL_V1["vper"]?>%<font color="blue">▲</font>
<?php }else{?><?php echo ($TPL_V1["vper"]* - 1)?>%<font color="red">▼</font><?php }?>
								</td>
								<td align="center"><?php echo $TPL_V1["jper"]?>%</td>
							</tr>
<?php }}?>
						</tbody>
					</table>
				</div>
				<br style="line-height:20px" />
				
				<div class="line desc pd10 center">
				방문자 수는 1일 1PC 기준입니다.(회원기준이 아님, 동일한 PC에서 하루동안 여러 번 방문해도 1회 체크되며 동일한 회원이 여러 PC에서 방문하면 PC 수만큼 체크됩니다.)
				</div>
			</div>
		</div>
	</div>
</div>

<script class="code" type="text/javascript">
	$(document).ready(function(){
		$("input[name='date_type']").each(function(){
			$(this).live('click', function(){
				if	($(this).val() == 'hour'){
					$(".scMonth").removeClass('hide');
					$(".scDay").removeClass('hide');
					$(".btn_scMonth").addClass('hide');
					$(".btn_scDay").removeClass('hide');
				}else if	($(this).val() == 'daily'){
					$(".scMonth").removeClass('hide');
					$(".scDay").addClass('hide');
					$(".btn_scMonth").removeClass('hide');
					$(".btn_scDay").addClass('hide');
				}else{
					$(".scMonth").addClass('hide');
					$(".scDay").addClass('hide');
					$(".btn_scMonth").addClass('hide');
					$(".btn_scDay").addClass('hide');
				}
			});
		});

		var maxValue = <?php echo $TPL_VAR["maxValue"]?>;	
		var gap = parseInt(maxValue.toString().substring(0,1)) < 2 ? Math.pow(10,maxValue.toString().length-2) : Math.pow(10,maxValue.toString().length-1);
		var yaxisMax = parseInt(maxValue.toString().substring(0,1)) < 2 ? gap * (parseInt(maxValue.toString().substring(0,2))+2) : gap * (parseInt(maxValue.toString().substring(0,1))+2);
		yaxisMax = yaxisMax > 100 ? yaxisMax : 100;

		var line1 = <?php echo json_encode($TPL_VAR["dataForChart"]['가입자수'])?>;
		var line2 = <?php echo json_encode($TPL_VAR["dataForChart"]['방문자수'])?>;
		var plot1 = $.jqplot('chart1', [line1,line2], {
			seriesDefaults: { 
				showMarker:true,
				pointLabels: { show:true }
			},
			seriesColors:<?php echo json_encode($TPL_VAR["seriesColors"])?>,
			series: [
				{'label':'가입자수'},
				{'label':'방문자수'}
			],
			axes: {
				xaxis: {
					renderer: $.jqplot.CategoryAxisRenderer,
				},
				yaxis: {
					min: 0,
					max: yaxisMax,
					numberTicks: 11
				}
			},
			legend: { 
				show:true, 
				location: 'e',
				xoffset: 15,
				yoffset: 15,
				placement: 'outside'
			},
			grid: {
				drawGridLines: true,
				gridLineColor: '#dddddd',
				background: '#fffdf6',
				borderWidth: 0,
				shadow: false
			}
		});
	});
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>