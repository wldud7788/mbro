<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/statistic_summary/summary.html 000005693 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

  
<!--[if IE]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.donutRenderer.min.js"></script>    
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left"></ul>
		<!-- 타이틀 -->
		<div class="page-title"><h2>요약 통계</h2></div>
		<!-- 우측 버튼 -->
		<ul class="page-buttons-right"></ul>
	</div>
</div>

<!-- 페이지 타이틀 바 : 끝 -->
<div class="contents_dvs v2">
	<div class="item-title">방문자 수</div>	
	<div class="chart_frame"><div id="chart1"></div></div>	
</div>

<div class="contents_dvs v2">
	<div class="item-title">가입자 수</div>	
	<div class="chart_frame"><div id="chart2"></div></div>
</div>

<div class="contents_dvs v2">
	<div class="item-title">매출 금액</div>	
	<div class="chart_frame"><div id="chart3"></div></div>
</div>

<div class="contents_dvs v2">
<?php $this->print_("_summary_table",$TPL_SCP,1);?>

</div>

<script class="code" type="text/javascript">
$(document).ready(function(){
	var data	= [];
	var label	= [];

	data		= [<?php echo json_encode($TPL_VAR["dataForChart"]['방문'])?>];
	label		= [{'label':'방문수'}];
	createChart('line', 'chart1', '<?php echo $TPL_VAR["maxVisitor"]?>', data, label, true);

	data		= [<?php echo json_encode($TPL_VAR["dataForChart"]['가입'])?>];
	label		= [{'label':'가입수'}];
	createChart('line', 'chart2', '<?php echo $TPL_VAR["maxMember"]?>', data, label, true);

	data		= [<?php echo json_encode($TPL_VAR["dataForChart"]['매출'])?>];
	label		= [{'label':'매출금액'}];
	createChart('line', 'chart3', '<?php echo $TPL_VAR["maxOrder"]?>', data, label, true);
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
		var maxValue = parseInt(maxValue);
		var gap = parseInt(maxValue.toString().substring(0,1)) < 2 ? Math.pow(10,maxValue.toString().length-2) : Math.pow(10,maxValue.toString().length-1);
		var yaxisMax = parseInt(maxValue.toString().substring(0,1)) < 2 ? gap * (parseInt(maxValue.toString().substring(0,2))+2) : gap * (parseInt(maxValue.toString().substring(0,1))+2);
		yaxisMax = yaxisMax > 100 ? yaxisMax : 100;

		if	(chart_type == 'stick'){
			var animate		= !$.jqplot.use_excanvas;
			var stackSeries	= false;
			var defaults	= { renderer:$.jqplot.BarRenderer,
								rendererOptions: {barMargin: 15,highlightMouseDown: true},
								pointLabels: {show: true},showMarker:true};
			var legend		= {show: true,location: 'e', placement: 'outside'};
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