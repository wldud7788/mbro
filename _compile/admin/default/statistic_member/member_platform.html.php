<?php /* Template_ 2.2.6 2022/05/30 16:03:30 /www/music_brother_firstmall_kr/admin/skin/default/statistic_member/member_platform.html 000005305 */ 
$TPL_statlist_1=empty($TPL_VAR["statlist"])||!is_array($TPL_VAR["statlist"])?0:count($TPL_VAR["statlist"]);?>
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
			<h2>가입 통계</h2>
		</div>
		
		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="sub-layout-container body-height-resizing">
<?php $this->print_("member_menu",$TPL_SCP,1);?>

	
	<!-- 서브메뉴 바디 : 시작-->
	<div class='slc-body-wrap'>
		<div class="slc-body">		
			<div class="item-title">가입 통계 - 환경</div>
			<br style="line-height:10px" />

			<div style="width:100%; margin:auto;">
				<div class="statistic_goods pd20 center">
					<form>
					<input type="hidden" name="search" value="on" />
						<select name="year">
						<option value="">= 연도 선택 =</option>
<?php if(is_array($TPL_R1=range(date('Y'), 2010))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["year"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 년</option>
<?php }}?>
						</select>
						
						<select name="month">
						<option value="">= 전체 =</option>
<?php if(is_array($TPL_R1=range( 1, 12))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["month"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 월</option>
<?php }}?>
						</select>
				
						<span class="btn medium cyanblue"><input type="submit" value="검색" /></span>					
					</form>
				</div>
				<br style="line-height:10px" />
			
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 1200px; margin:auto;">
					<tr>
						<td align="right" valign="bottom" class="pdb10"><span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('환경별_가입통계','#platform_monthly_table')" /></span></td>
					</tr>
				</table>				
				<div id="platform_monthly_table" style="max-width: 1200px; margin:auto;">
					<table width="100%" class="simpledata-table-style" style="margin:auto;">
						<col width="40%" /><col width="30%" />
						<tr>
							<th>판매환경</th>
							<th>건수</th>
						</tr>
<?php if($TPL_statlist_1){foreach($TPL_VAR["statlist"] as $TPL_K1=>$TPL_V1){?>
						<tr>
							<td align="center"><?php echo $TPL_K1?></td>
							<td align="right" class="pdr5"><font><?php echo number_format($TPL_V1["cnt"])?>(<?php echo $TPL_V1["percent"]?>%)</font></td>
						</tr>
<?php }}?>
					</table>
				</div>				
			</div>
			<br style="line-height:40px" />
			
			<div style="width:600px; margin:auto;">	
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<col width="50%" /><col width="50%" />
				<tr>
					<td align="center" valign="top">
						<span class="bold fx16">환경별 건수</span>
						<div id="chart1" style="margin:auto; height:250px; width:100%;"></div>
					</td>
				</tr>
				</table>
			</div>		
		</div>
	</div>
</div>

<script class="code" type="text/javascript">
	$(document).ready(function(){

<?php if(count($TPL_VAR["dataForChart"])> 0){?>
		var data = <?php echo preg_replace("/\"([0-9]+)\"/","$1",json_encode($TPL_VAR["dataForChart"]))?>;
		var plot1 = jQuery.jqplot ('chart1', [data], 
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
<?php }?>
	});
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>