<?php /* Template_ 2.2.6 2022/05/17 12:37:15 /www/music_brother_firstmall_kr/admin/skin/default/statistic_sales/sales_etc.html 000014727 */ 
$TPL_sitetypeloop_1=empty($TPL_VAR["sitetypeloop"])||!is_array($TPL_VAR["sitetypeloop"])?0:count($TPL_VAR["sitetypeloop"]);
$TPL_arr_age_1=empty($TPL_VAR["arr_age"])||!is_array($TPL_VAR["arr_age"])?0:count($TPL_VAR["arr_age"]);
$TPL_dataForTable2_1=empty($TPL_VAR["dataForTable2"])||!is_array($TPL_VAR["dataForTable2"])?0:count($TPL_VAR["dataForTable2"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

  
<!--[if IE]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>   
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.donutRenderer.min.js"></script>   
<style type="text/css">
	table.simpledata-table-style td.right	{ padding-right:5px;}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$(".all-check").toggle(function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',true);
		},function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',false);
		});
	});
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">
	
		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			
		</ul>
		
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>판매 통계</h2>
		</div>
		
		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="sub-layout-container body-height-resizing">
	
<?php $this->print_("sales_menu",$TPL_SCP,1);?>

	
	<!-- 서브메뉴 바디 : 시작-->
	<div class='slc-body-wrap'>
		<div class="slc-body">		
			<div class="item-title">판매 통계 - 성별/연령/지역</div>
			<br style="line-height:10px" />

			<div class="statistic_goods pd20">				
				<form>
					<input type="hidden" name="search" value="on" />
					<div align="center">
						<select name="year">
						<option value="">= 연도 선택 =</option>
<?php if(is_array($TPL_R1=range(date('Y'), 2010))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["year"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 년</option>
<?php }}?>
						</select>
						
						<select name="month">
						<option value="">= 월 선택 =</option>
<?php if(is_array($TPL_R1=range( 12, 1))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["month"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 월</option>
<?php }}?>
						</select>				
						<span class="btn medium cyanblue"><input type="submit" value="검색" /></span>
						<span class="helpicon" title="입금완료일 기준입니다"></span>
					</div>
					<div class="center pdt10">
						<strong>판매환경 &nbsp;</strong>
<?php if($TPL_sitetypeloop_1){foreach($TPL_VAR["sitetypeloop"] as $TPL_K1=>$TPL_V1){?>
<?php if(in_array($TPL_K1,$TPL_VAR["sitetype"])){?>
							<label class="search_label"><input type="checkbox" name="sitetype[]" value="<?php echo $TPL_K1?>" checked="checked" /> <?php echo $TPL_V1["name"]?></label>
<?php }else{?>
							<label class="search_label"><input type="checkbox" name="sitetype[]" value="<?php echo $TPL_K1?>" /> <?php echo $TPL_V1["name"]?></label>
<?php }?>
<?php }}?>
						<span class="icon-check hand all-check"><b class="">전체</b></span>
					</div>
				</form>	
			</div>
			
			<div style="width:100%; margin:auto;">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="right" valign="bottom" class="pdt5 pdb10">
							<span class="btn small orange"><button type="button" onclick='openDialog("안내) 성별/연령 통계", "layer_guide_age", {"width":"550","height":"180","show" : "fade","hide" : "fade","modal":false}); '>안내) 성별/연령 통계</button></span>
							<div class="hide" id="layer_guide_age">
								회원정보에 생일 또는 성별 정보가 저장되어 있는 회원의 주문(결제완료) 기준으로 구매건수와 구매금액을 집계합니다. <br/>
								<br/>
								※ 생일 또는 성별 정보가 없는 회원 주문 및 비회원 주문은 집계되지 않습니다.
							</div>
							<span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('성별/연령별_매출','#payment_monthly_table')" /></span>
						</td>
					</tr>
				</table>	
				<div id="payment_monthly_table">
					<table width="100%" class="simpledata-table-style" style="margin:auto;">			
					<tr>
						<td rowspan="2" width="10%" bgcolor="eeeeee"></td>
<?php if($TPL_arr_age_1){foreach($TPL_VAR["arr_age"] as $TPL_V1){?>
						<th colspan="3" width="15%"><?php echo $TPL_V1?></th>
<?php }}?>
					</tr>
					<tr>
<?php if($TPL_arr_age_1){foreach($TPL_VAR["arr_age"] as $TPL_V1){?>
							<th width="5%">남</th>
							<th width="5%">여</th>
							<th width="5%">합</th>				
<?php }}?>
					</tr>
					<tr>
						<td align="center">건수</td>
<?php if($TPL_arr_age_1){foreach($TPL_VAR["arr_age"] as $TPL_V1){?>
							<td class="right fx10 tahoma"><?php echo number_format($TPL_VAR["dataForTable1"]['남'][$TPL_V1]['month_count_sum'])?></td>
							<td class="right fx10 tahoma"><?php echo number_format($TPL_VAR["dataForTable1"]['여'][$TPL_V1]['month_count_sum'])?></td>
							<td class="right fx10 tahoma"><?php echo number_format($TPL_VAR["dataForTableSum"][$TPL_V1]['month_count_sum'])?>(<?php echo $TPL_VAR["dataForTableSum"][$TPL_V1]['month_count_percent']?>%)</td>				
<?php }}?>
					</tr>
					<tr>
						<td align="center">금액</td>
<?php if($TPL_arr_age_1){foreach($TPL_VAR["arr_age"] as $TPL_V1){?>
							<td class="right fx10 tahoma"><?php echo get_currency_price($TPL_VAR["dataForTable1"]['남'][$TPL_V1]['month_settleprice_sum'])?></td>
							<td class="right fx10 tahoma"><?php echo get_currency_price($TPL_VAR["dataForTable1"]['여'][$TPL_V1]['month_settleprice_sum'])?></td>
							<td class="right fx10 tahoma"><?php echo get_currency_price($TPL_VAR["dataForTableSum"][$TPL_V1]['month_settleprice_sum'])?></td>				
<?php }}?>
					</tr>
					</table>
				</div>
			</div>
			<div style="width:1000px; margin:auto;">				
				<br style="line-height:40px" />
				
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<col width="50%" /><col width="50%" />
				<tr>
					<td align="center" valign="top">
						<span class="bold fx16">연령별 건수</span>
						<div id="chart1" style="margin:auto; height:250px; width:100%;"></div>
					</td>
					<td align="center" valign="top">
						<span class="bold fx16">연령별 금액</span>	
						<div id="chart2" style="margin:auto; height:250px; width:100%;"></div>
					</td>
				</tr>
				</table>
			</div>

			<div style="width:100%; margin:auto;">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="right" valign="bottom" class="pdt5 pdb10">
							<span class="btn small orange"><button type="button" onclick='openDialog("안내) 지역 통계", "layer_guide_location", {"width":"550","height":"180","show" : "fade","hide" : "fade","modal":false}); '>안내) 지역 통계</button></span>
							<div class="hide" id="layer_guide_location">
								주문(결제완료)의 배송지 주소에 따라 지역별 구매횟수와 구매금액을 집계합니다.
							</div>
							<span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('지역별_매출','#payment_monthly_area_table')" /></span>
						</td>
					</tr>
				</table>
				
				<div id="payment_monthly_area_table">
					<table width="100%" class="simpledata-table-style" style="margin:auto;">
					<col width="40%" /><col width="30%" /><col width="30%" />
					<tr>
						<th>지역</th>
						<th>판매(결제) 횟수</th>
						<th>판매금액(결제완료 기준)</th>
					</tr>
<?php if($TPL_dataForTable2_1){foreach($TPL_VAR["dataForTable2"] as $TPL_K1=>$TPL_V1){?>
					<tr>
						<td align="center"><?php echo $TPL_K1?></td>
						<td align="right" class="pdr5"><font><?php echo number_format($TPL_V1["month_count_sum"])?>(<?php echo $TPL_V1["month_count_percent"]?>%)</font></td>
						<td align="right" class="pdr5"><font><?php echo get_currency_price($TPL_V1["month_settleprice_sum"])?></font></td>			
					</tr>
<?php }}?>
					</table>
				</div>
			</div>

			<div style="width:1000px; margin:auto;">
				<br style="line-height:40px" />
				
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<col width="49%" /><col /><col width="49%" />
				<tr>
					<td align="center" valign="top">
						<div class="center"><span class="bold fx16">지역별 건수</span></div>
						<div id="chart3" style="margin:auto; height:250px; width:100%;"></div>
					</td>
					<td></td>
					<td align="center" valign="top">
						<div class="center"><span class="bold fx16">지역별 금액</span></div>
						<div id="chart4" style="margin:auto; height:250px; width:100%;"></div>
					</td>
				</tr>
				</table>
			</div>			
		</div>
	</div>
</div>

<script class="code" type="text/javascript">
	$(document).ready(function(){

		var data1 = <?php echo preg_replace("/\"([0-9]+)\"/","$1",json_encode($TPL_VAR["dataForChart1"]['건수']))?>;
		var plot1 = jQuery.jqplot ('chart1', [data1], 
			{ 
				seriesDefaults: {
					// Make this a pie chart.
					renderer: jQuery.jqplot.PieRenderer, 
					rendererOptions: {
						// Put data labels on the pie slices.
						// By default, labels show the percentage of the slice.
						showDataLabels: true
					}
				}, 
				seriesColors:<?php echo json_encode($TPL_VAR["seriesColors"])?>,
				legend: {      
					show: false,      
					location: 'e',      
					placement: 'outside'    
				},
				grid: {
					background: 'transparent',
					borderWidth: 0,
					shadow: false
				}
			}
		);
		
		var data2 = <?php echo preg_replace("/\"([0-9]+)\"/","$1",json_encode($TPL_VAR["dataForChart1"]['금액']))?>;
		var plot2 = jQuery.jqplot ('chart2', [data2], 
			{ 
				seriesDefaults: {
					// Make this a pie chart.
					renderer: jQuery.jqplot.PieRenderer, 
					rendererOptions: {
						// Put data labels on the pie slices.
						// By default, labels show the percentage of the slice.
						showDataLabels: true,
						dataLabels: 'percent'
					}
				}, 
				seriesColors:<?php echo json_encode($TPL_VAR["seriesColors"])?>,
				legend: {      
					show: true,      
					location: 'e',      
					placement: 'outside'    
				},
				grid: {
					background: 'transparent',
					borderWidth: 0,
					shadow: false
				}
			}
		);


		var maxValue = <?php echo $TPL_VAR["maxValue"]['건수']?>;
		var gap = parseInt(maxValue.toString().substring(0,1)) < 2 ? Math.pow(10,maxValue.toString().length-2) : Math.pow(10,maxValue.toString().length-1);
		var yaxisMax = parseInt(maxValue.toString().substring(0,1)) < 2 ? gap * (parseInt(maxValue.toString().substring(0,2))+2) : gap * (parseInt(maxValue.toString().substring(0,1))+2);
		yaxisMax = yaxisMax > 100 ? yaxisMax : 100;
		
		var data3 = <?php echo json_encode($TPL_VAR["dataForChart2"]['건수'])?>;
		var plot3 = $.jqplot('chart3', [data3], {
			stackSeries: false,
			seriesDefaults: { 
				renderer:$.jqplot.BarRenderer,
				rendererOptions: {
					// Put a 30 pixel margin between bars.
					barMargin: 10,
					// Highlight bars when mouse button pressed.
					// Disables default highlighting on mouse over.
					highlightMouseDown: true   
				},
				pointLabels: {show: true},
				showMarker:true
			},
			seriesColors:<?php echo json_encode($TPL_VAR["seriesColors"])?>,
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
				show: false  
			},
			grid: {
				drawGridLines: true,
				gridLineColor: '#dddddd',
				background: '#fffdf6',
				borderWidth: 0,
				shadow: false
			}
		});
		
		var maxValue = <?php echo $TPL_VAR["maxValue"]['금액']?>;
		var gap = parseInt(maxValue.toString().substring(0,1)) < 2 ? Math.pow(10,maxValue.toString().length-2) : Math.pow(10,maxValue.toString().length-1);
		var yaxisMax = parseInt(maxValue.toString().substring(0,1)) < 2 ? gap * (parseInt(maxValue.toString().substring(0,2))+2) : gap * (parseInt(maxValue.toString().substring(0,1))+2);
		yaxisMax = yaxisMax > 100 ? yaxisMax : 100;
		
		var data4 = <?php echo json_encode($TPL_VAR["dataForChart2"]['금액'])?>;
		var plot4 = $.jqplot('chart4', [data4], {
			animate: !$.jqplot.use_excanvas,
			stackSeries: false,
			seriesDefaults: { 
				renderer:$.jqplot.BarRenderer,
				rendererOptions: {
					// Put a 30 pixel margin between bars.
					barMargin: 10,
					// Highlight bars when mouse button pressed.
					// Disables default highlighting on mouse over.
					highlightMouseDown: true   
				},
				pointLabels: {show: true},
				showMarker:true
			},
			seriesColors:<?php echo json_encode($TPL_VAR["seriesColors"])?>,
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
				show: false  
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