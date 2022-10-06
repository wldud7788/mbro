<?php /* Template_ 2.2.6 2022/05/17 12:37:15 /www/music_brother_firstmall_kr/admin/skin/default/statistic_sales/sales_platform.html 000007399 */ 
$TPL_sitetypeloop_1=empty($TPL_VAR["sitetypeloop"])||!is_array($TPL_VAR["sitetypeloop"])?0:count($TPL_VAR["sitetypeloop"]);
$TPL_dataForTable_1=empty($TPL_VAR["dataForTable"])||!is_array($TPL_VAR["dataForTable"])?0:count($TPL_VAR["dataForTable"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

  
<!--[if IE]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.donutRenderer.min.js"></script>   
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />
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
			<div class="item-title">판매 통계 - 환경</div>
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
						<option value="all">= 월 선택 =</option>
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
					<td align="right" valign="bottom" class="pdt5 pdb10"><span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('판매수단별_매출','#platform_monthly_table')" /></span></td>
				</tr>
				</table>
				
				<div id="platform_monthly_table">
					<table width="100%" class="simpledata-table-style" style="margin:auto;">
					<col width="40%" /><col width="30%" /><col width="30%" />
					<tr>
						<th>판매환경</th>
						<th>판매(결제) 횟수</th>
						<th>판매금액(결제완료 기준)</th>
					</tr>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_K1=>$TPL_V1){?>
					<tr>
						<td align="center"><?php echo $TPL_VAR["sitetypeloop"][$TPL_K1]["name"]?></td>
						<td align="right" class="pdr5"><font><?php echo number_format($TPL_V1["count_sum"])?>(<?php echo $TPL_V1["count_percent"]?>%)</font></td>
						<td align="right" class="pdr5"><font><?php echo get_currency_price($TPL_V1["settleprice_sum"])?></font></td>			
					</tr>
<?php }}?>
					</table>
				</div>
			</div>
			
			<div style="width:1000px; margin:auto;">				
				<br style="line-height:40px" />
				
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<col width="50%" /><col width="50%" />
				<tr>
					<td align="center" valign="top">
						<span class="bold fx16">판매환경별 건수</span>
						<div id="chart1" style="margin:auto; height:250px; width:100%;"></div>
					</td>
					<td align="center" valign="top">
						<span class="bold fx16">판매환경별 금액</span>	
						<div id="chart2" style="margin:auto; height:250px; width:100%;"></div>
					</td>
				</tr>
				</table>
			</div>		
		</div>
	</div>
</div>

<script class="code" type="text/javascript">
	$(document).ready(function(){
		
		var data = <?php echo preg_replace("/\"([0-9]+)\"/","$1",json_encode($TPL_VAR["dataForChart"]['건수']))?>;
		var plot1 = jQuery.jqplot ('chart1', [data], 
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
				//seriesColors:<?php echo json_encode($TPL_VAR["seriesColors"])?>,
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
		
		var data = <?php echo preg_replace("/\"([0-9]+)\"/","$1",json_encode($TPL_VAR["dataForChart"]['금액']))?>;
		var plot2 = jQuery.jqplot ('chart2', [data], 
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
				//seriesColors:<?php echo json_encode($TPL_VAR["seriesColors"])?>,
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
 	});
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>