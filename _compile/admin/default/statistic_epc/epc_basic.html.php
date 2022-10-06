<?php /* Template_ 2.2.6 2022/05/17 12:37:07 /www/music_brother_firstmall_kr/admin/skin/default/statistic_epc/epc_basic.html 000008094 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

  
<!--[if IE]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />

<div id="statsSettingLayer"></div>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>적립 통계</h2>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="sub-layout-container body-height-resizing">
	<div class="slc-head pdt5">
		<ul>
			<li <?php if($_GET['stats_type']=='emoney'||!$_GET['stats_type']){?>class="selected"<?php }?>><span class="mitem"><a href="?stats_type=emoney">마일리지</a></span></li>
<?php if(serviceLimit('H_FR')){?>
			<li><span class="mitem"><a href="#" onclick="<?php echo serviceLimit('A1')?>">포인트</a></span></li>
			<li><span class="mitem"><a href="#" onclick="<?php echo serviceLimit('A1')?>">예치금</a></span></li>
<?php }else{?>
			<li <?php if($_GET['stats_type']=='point'){?>class="selected"<?php }?>><span class="mitem"><a href="?stats_type=point">포인트</a></span></li>
			<li <?php if($_GET['stats_type']=='cash'){?>class="selected"<?php }?>><span class="mitem"><a href="?stats_type=cash">예치금</a></span></li>
<?php }?>
		</ul>
	</div>
	<!-- 서브메뉴 바디 : 시작-->
	<div class='slc-body-wrap'>
		<div class="slc-body">
			<div style="margin:auto;">
				<div class="item-title">적립 통계</div>
<?php if($TPL_VAR["dataForChart"]['before_total']){?>
				<br style="line-height:10px" />

				<div class="statistic_goods pd20 center">
					<label><input type="checkbox" name="cntCode[]" titleName="전월이월" value="before_total" <?php if(preg_match('/before_total/',$_GET['cntCode'])||!$_GET['cntCode']){?>checked<?php }?> /> 전월이월</label>
					<label><input type="checkbox" name="cntCode[]" titleName="지급" value="plus" <?php if(preg_match('/plus/',$_GET['cntCode'])){?>checked<?php }?>/> 지급</label>
					<label><input type="checkbox" name="cntCode[]" titleName="사용" value="minus" <?php if(preg_match('/minus/',$_GET['cntCode'])){?>checked<?php }?>/> 사용</label>
					<label><input type="checkbox" name="cntCode[]" titleName="소멸" value="limits" <?php if(preg_match('/limits/',$_GET['cntCode'])){?>checked<?php }?>/> 소멸</label>
					<label><input type="checkbox" name="cntCode[]" titleName="계" value="after_total" <?php if(preg_match('/after_total/',$_GET['cntCode'])){?>checked<?php }?>/> 계</label>
				</div>
				<br style="line-height:10px" />

				<div id="chart1" style="height:400px; width:1000px; margin:0 auto"></div>
<?php }else{?>
				<div style="height:400px; width:1000px; margin:0 auto"><span style="position:relative; top:45%; left:45%">수집된 통계자료가 없습니다.</span></div>
<?php }?>
				<br style="line-height:20px" />

				<div class="mb10">- <strong>누적 적립액</strong> <?php echo get_currency_price($TPL_VAR["accumulate"], 3)?> (<?php echo date('Y년 m월 d일')?> 자정기준)</div>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mb5">
					<tr>						
						<td>
							<select name="year">
								<option value="">= 연도 선택 =</option>
<?php if(is_array($TPL_R1=range(date('Y'), 2014))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
								<option value="<?php echo $TPL_V1?>" <?php if($_GET["year"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 년</option>
<?php }}?>
							</select>
						</td>
						<td align="right" valign="bottom"><span class="btn small"><input type="button" value="엑셀출력" onclick="<?php if($TPL_VAR["dataForChart"]['before_total']){?>divExcelDownload('월별_적립통계','#epc_monthly_table')<?php }else{?>alert('수집된 통계자료가 없습니다.')<?php }?>" /></span></td>
					</tr>
				</table>

<?php if($TPL_VAR["dataForChart"]['before_total']){?>
				<div id="epc_monthly_table">
<?php $this->print_("_year_table",$TPL_SCP,1);?>

				</div>
<?php }?>
				<br style="line-height:10px" />

				<div class="right red">
					※ 해당월의 적립 통계는 익월 초에 수집됩니다.
				</div>

			</div>

		</div>
	</div>
</div>

<script class="code" type="text/javascript">
	var maxValue = '<?php echo $TPL_VAR["maxValue"]?>';

	var gap = parseInt(maxValue.toString().substring(0,1)) < 2 ? Math.pow(10,maxValue.toString().length-2) : Math.pow(10,maxValue.toString().length-1);
	var yaxisMax = parseInt(maxValue.toString().substring(0,1)) < 2 ? gap * (parseInt(maxValue.toString().substring(0,2))+2) : gap * (parseInt(maxValue.toString().substring(0,1))+2);
	yaxisMax = yaxisMax > 100 ? yaxisMax : 100;

	var listData	= new Object();
	var colorData	= new Array();

	listData['before_total']	= <?php echo json_encode($TPL_VAR["dataForChart"]['before_total'])?>;
	listData['plus']		= <?php echo json_encode($TPL_VAR["dataForChart"]['plus'])?>;
	listData['minus']		= <?php echo json_encode($TPL_VAR["dataForChart"]['minus'])?>;
	listData['limits']		= <?php echo json_encode($TPL_VAR["dataForChart"]['limits'])?>;
	listData['after_total']			= <?php echo json_encode($TPL_VAR["dataForChart"]['after_total'])?>;

	colorData['before_total']	= ['#445ebc'];
	colorData['plus']		= ['#cc0000'];
	colorData['minus']		= ['#339900'];
	colorData['limits']		= ['#cc66ff'];
	colorData['after_total']			= ['#33ccff'];

	$(document).ready(function(){
		$("select[name='year']").change(function(){
			code = [];
			$("input[name=cntCode[]]:checkbox:checked").each(function(){
				code.push($(this).val());
			});
			location.href = "?stats_type=<?php echo $_GET['stats_type']?>&year="+$(this).val()+"&cntCode="+code;
		}).val('<?php echo $TPL_VAR["year"]?>');
		set_jqplot();
		$("input[name='cntCode[]']").click(function(){
			if($("input[name=cntCode[]]:checkbox:checked").length == 0){
				$(this).prop('checked',true);
				alert("한개 이상은 체크해주셔야 합니다");
				return;
			}
			set_jqplot();
		});
	});

	var set_jqplot = function(){
		cnt			= 0;
		titles		= [];
		dataList	= [];
		colors		= [];

		$("input[name='cntCode[]']").each(function(){
			if($(this).attr('checked')){
				cnt++;
				dataList.push(listData[$(this).val()]);
				titles.push({'label':$(this).attr('titleName')});
				colors.push(colorData[$(this).val()]);
			}
		});

		if(cnt > 0){
			$("#chart1").html('');
			var plot1 = $.jqplot('chart1', dataList, {
				seriesDefaults: { 
					showMarker:true,
					pointLabels: { show:true }
				},
				seriesColors:colors,
				series: titles,
				axes: {
					xaxis: {
						renderer: $.jqplot.CategoryAxisRenderer,
					},
					yaxis: {
						min: 0,
						max: yaxisMax,
						numberTicks: 15
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
		}
	};
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>