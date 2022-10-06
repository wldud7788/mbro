<?php /* Template_ 2.2.6 2022/05/17 12:37:10 /www/music_brother_firstmall_kr/admin/skin/default/statistic_member/member_etc.html 000012768 */ 
$TPL_arr_age_1=empty($TPL_VAR["arr_age"])||!is_array($TPL_VAR["arr_age"])?0:count($TPL_VAR["arr_age"]);
$TPL_ageStatTotal_1=empty($TPL_VAR["ageStatTotal"])||!is_array($TPL_VAR["ageStatTotal"])?0:count($TPL_VAR["ageStatTotal"]);
$TPL_ageStatList_1=empty($TPL_VAR["ageStatList"])||!is_array($TPL_VAR["ageStatList"])?0:count($TPL_VAR["ageStatList"]);
$TPL_arr_location_1=empty($TPL_VAR["arr_location"])||!is_array($TPL_VAR["arr_location"])?0:count($TPL_VAR["arr_location"]);
$TPL_locationList_1=empty($TPL_VAR["locationList"])||!is_array($TPL_VAR["locationList"])?0:count($TPL_VAR["locationList"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

  
<!--[if IE]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.donutRenderer.min.js"></script>   
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />
<style type="text/css">
	table.simpledata-table-style td.ctd { text-align:center; }
	table.simpledata-table-style td.rtd { text-align:right;padding-right:5px; }
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
						<select name="year">
						<option value="">= 연도 선택 =</option>
<?php if(is_array($TPL_R1=range(date('Y'), 2010))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["year"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 년</option>
<?php }}?>
						</select>

						<span class="btn medium cyanblue"><input type="submit" value="검색" /></span>					
					</form>
				</div>

				<div style="text-align:center;margin:40px 0 10px;">
					<span class="bold fx16">성별</span>
				</div>
				<div id="chart1" style="margin:auto; height:250px; width:1000px;"></div>				
				<br style="line-height:20px" />

				<div style="text-align:center;margin:40px 0;">
					<span class="bold fx16">연령별</span>
				</div>
				<table width="1000px" style="margin:0 auto;" border="0" cellpadding="0" cellspacing="0">
					<col width="33%" /><col width="33%" /><col width="33%" />
					<tr>
						<td align="center" valign="top">
							<span class="bold fx14">총합</span>
							<div id="chart2" style="margin:auto; height:250px; width:100%;"></div>
						</td>
						<td align="center" valign="top">
							<span class="bold fx14">남자</span>
							<div id="chart3" style="margin:auto; height:250px; width:100%;"></div>
						</td>
						<td align="center" valign="top">
							<span class="bold fx14">여자</span>
							<div id="chart4" style="margin:auto; height:250px; width:100%;"></div>
						</td>
					</tr>
				</table>
				<br style="line-height:20px" />

				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="right" valign="bottom" class="pdb10"><span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('월별_연령별_성별_가입통계','#age_monthly_table')" /></span></td>
					</tr>
				</table>
				<div id="age_monthly_table">
					<table width="100%" class="simpledata-table-style" style="margin:auto;">
						<colgroup>
							<col width="10%" />
<?php if(is_array($TPL_R1=range( 1,count($TPL_VAR["arr_age"])))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=range( 0,count($TPL_VAR["arr_sex"])))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<col />
<?php }}?>
<?php }}?>
						</colgroup>
						<thead>
							<tr>
								<th rowspan="2" style="background:#eeeeee;"></th>
<?php if($TPL_arr_age_1){foreach($TPL_VAR["arr_age"] as $TPL_V1){?>
								<th colspan="3"><?php echo $TPL_V1?></th>
<?php }}?>
							</tr>
							<tr>
<?php if(is_array($TPL_R1=range( 1,count($TPL_VAR["arr_age"])))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=range( 1,count($TPL_VAR["arr_sex"])))&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
								<th><?php echo $TPL_VAR["arr_sex"][$TPL_I2]?></th>
<?php }}?>
								<th>합</th>
<?php }}?>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="ctd">합계</td>
<?php if($TPL_ageStatTotal_1){foreach($TPL_VAR["ageStatTotal"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["sex"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<td class="rtd"><?php echo number_format($TPL_V2)?></td>
<?php }}?>
<?php }}?>
							</tr>
<?php if($TPL_ageStatList_1){foreach($TPL_VAR["ageStatList"] as $TPL_K1=>$TPL_V1){?>
							<tr>
								<td class="ctd"><?php echo $TPL_K1?>월</td>
<?php if(is_array($TPL_R2=$TPL_V1["age"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if(is_array($TPL_R3=$TPL_V2["sex"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
								<td class="rtd"><?php echo number_format($TPL_V3)?></td>
<?php }}?>
<?php }}?>
							</tr>
<?php }}?>
						</tbody>
					</table>
				</div>

				<div style="text-align:center;margin:40px 0 10px;">
					<span class="bold fx16">지역별</span>
				</div>
				<div id="chart5" style="margin:auto; height:250px; width:1000px;"></div>
				<br style="line-height:20px" />

				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="right" valign="bottom" class="pdb10"><span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('지역별_성별_가입통계','#location_table')" /></span></td>
					</tr>
				</table>
				<div id="location_table">
					<table width="100%" class="simpledata-table-style" style="margin:auto;">
						<colgroup>
							<col width="10%" />
<?php if(is_array($TPL_R1=range( 1,count($TPL_VAR["arr_location"])))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=range( 0,count($TPL_VAR["arr_sex"])))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<col />
<?php }}?>
<?php }}?>
						</colgroup>
						<thead>
							<tr>
								<th rowspan="2" style="background:#eeeeee;"></th>
<?php if($TPL_arr_location_1){foreach($TPL_VAR["arr_location"] as $TPL_V1){?>
								<th colspan="3"><?php echo $TPL_V1?></th>
<?php }}?>
							</tr>
							<tr>
<?php if(is_array($TPL_R1=range( 1,count($TPL_VAR["arr_location"])))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=range( 1,count($TPL_VAR["arr_sex"])))&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
								<th><?php echo $TPL_VAR["arr_sex"][$TPL_I2]?></th>
<?php }}?>
								<th>합</th>
<?php }}?>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="ctd">합계</td>
<?php if($TPL_locationList_1){foreach($TPL_VAR["locationList"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["sex"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<td class="rtd"><?php echo number_format($TPL_V2)?></td>
<?php }}?>
<?php }}?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script class="code" type="text/javascript">
	$(document).ready(function(){

		var data	= [];
		var label	= [];

		var line1	= <?php echo json_encode($TPL_VAR["dataForChart"]['성별']['남성'])?>;
		var line2	= <?php echo json_encode($TPL_VAR["dataForChart"]['성별']['여성'])?>;
		var line3	= <?php echo json_encode($TPL_VAR["dataForChart"]['성별']['합계'])?>;
		data		= [line1, line2, line3];
		label		= [{'label':'남성'},{'label':'여성'},{'label':'합계'}];
		createChart('line', 'chart1', '<?php echo $TPL_VAR["sexMaxValue"]?>', data, label, true);


		data		= [<?php echo preg_replace("/\"([0-9]+)\"/","$1",json_encode($TPL_VAR["dataForChart"]['연령']['총합']))?>];
		createChart('round', 'chart2', '', data, '', false);
		data		= [<?php echo preg_replace("/\"([0-9]+)\"/","$1",json_encode($TPL_VAR["dataForChart"]['연령']['남자']))?>];
		createChart('round', 'chart3', '', data, '', false);
		data		= [<?php echo preg_replace("/\"([0-9]+)\"/","$1",json_encode($TPL_VAR["dataForChart"]['연령']['여자']))?>];
		createChart('round', 'chart4', '', data, '', true);

		var line1	= <?php echo json_encode($TPL_VAR["dataForChart"]['지역']['남'])?>;
		var line2	= <?php echo json_encode($TPL_VAR["dataForChart"]['지역']['여'])?>;
		var line3	= <?php echo json_encode($TPL_VAR["dataForChart"]['지역']['합계'])?>;
		data		= [line1, line2, line3];
		label		= [{'label':'남'},{'label':'여'},{'label':'합계'}];
		createChart('stick', 'chart5', '<?php echo $TPL_VAR["locationMaxValue"]?>', data, label, true);
	});

	// Chart 생성 함수
	function createChart(chart_type, chart_id, maxValue, data, labelData, show_status)
	{
		if	(chart_type == 'round'){
			var animate		= {};
			var stackSeries	= false;
			var defaults	= {renderer: jQuery.jqplot.PieRenderer, 
								rendererOptions: {showDataLabels: true,dataLabels: 'percent'}};
			var legend		= {show: show_status,location: 'e',placement: 'outside'};
			var grid		= {background: 'transparent',borderWidth: 0,shadow: false}
			var series		= {};
			var axes		= {};
		}else{
			var maxValue = maxValue;
			var gap = parseInt(maxValue.toString().substring(0,1)) < 2 ? Math.pow(10,maxValue.toString().length-2) : Math.pow(10,maxValue.toString().length-1);
			var yaxisMax = parseInt(maxValue.toString().substring(0,1)) < 2 ? gap * (parseInt(maxValue.toString().substring(0,2))+2) : gap * (parseInt(maxValue.toString().substring(0,1))+2);
			yaxisMax = yaxisMax > 100 ? yaxisMax : 100;

			if	(chart_type == 'stick'){
				var animate		= !$.jqplot.use_excanvas;
				var stackSeries	= false;
				var defaults	= { renderer:$.jqplot.BarRenderer,
									rendererOptions: {barMargin: 15,highlightMouseDown: true},
									pointLabels: {show: true},showMarker:true};
				var legend		= {show: true,location: 'e',placement: 'outside'};
				var axes		= {xaxis: {renderer: $.jqplot.CategoryAxisRenderer},      
									yaxis: {adMin: 0}};
				var series		= labelData;
				var grid		= {drawGridLines: true,gridLineColor: '#dddddd',background: '#fffdf6',
									borderWidth: 0,shadow: false};
			}else{
				var animate		= {};
				var stackSeries	= false;
				var defaults	= { showMarker:true, pointLabels: { show:true }};
				var legend		= {show:true, location: 'e',xoffset: 15,yoffset: 15,placement: 'outside'};
				var axes		= {xaxis: {renderer: $.jqplot.CategoryAxisRenderer,},
									yaxis: {min: 0,max: yaxisMax,numberTicks: 11}};
				var series		= labelData;
				var grid		= {drawGridLines: true,gridLineColor: '#dddddd',background: '#fffdf6',
									borderWidth: 0,shadow: false};
			}
		}

		var plot = $.jqplot(chart_id, data, {
			animate: animate,
			stackSeries: stackSeries,
			seriesDefaults: defaults,
			seriesColors:<?php echo json_encode($TPL_VAR["seriesColors"])?>,
			series: series,
			legend: legend,
			axes: axes,
			grid:grid
		});
	}
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>