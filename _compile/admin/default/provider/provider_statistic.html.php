<?php /* Template_ 2.2.6 2022/05/17 12:36:51 /www/music_brother_firstmall_kr/admin/skin/default/provider/provider_statistic.html 000003493 */ ?>
<div class="sub-wrap" style="position:relative;">
	<div class="sub-select-bar">
		<select name="year" class="sub-selectbox">
<?php if(is_array($TPL_R1=range( 2010,date('Y')))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<option value="<?php echo $TPL_V1?>" <?php if($_GET["year"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
		</select>
	</div>

	<div class="stistic-data-div">
		<div id="chart1" class="sub-chart"></div>
	</div>
</div>

<script class="code" type="text/javascript">
$(document).ready(function(){

	$("select[name='year']").live("change", function(){
		var addParams	= '&year=' + $(this).val();
		getProviderStatistic(addParams);
	});

	var data	= [];
	var label	= [];
<?php if(count($TPL_VAR["dataForChart"])> 0){?>
	var line1	= <?php echo json_encode($TPL_VAR["dataForChart"])?>;
	data		= [line1];
	label		= [];
	createChart('line', 'chart1', '<?php echo $TPL_VAR["maxValue"]?>', data, label, false);
<?php }?>
});

// Chart 생성 함수
function createChart(chart_type, chart_id, maxValue, data, labelData, show_status)
{
	$("#"+chart_id).html('');

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
			var legend		= {show: show_status,location: 'e',placement: 'outside'};
			var axes		= {xaxis: {renderer: $.jqplot.CategoryAxisRenderer},      
								yaxis: {adMin: 0}};
			var series		= labelData;
			var grid		= {drawGridLines: true,gridLineColor: '#dddddd',background: '#fffdf6',
								borderWidth: 0,shadow: false};
		}else{
			var animate		= {};
			var stackSeries	= false;
			var defaults	= { showMarker:true, pointLabels: { show:true }};
			var legend		= {show:show_status, location: 'e',xoffset: 15,yoffset: 15,placement: 'outside'};
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