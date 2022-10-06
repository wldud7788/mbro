<?php /* Template_ 2.2.6 2022/05/17 12:29:32 /www/music_brother_firstmall_kr/selleradmin/skin/default/statistic_goods/sales_daily.html 000019411 */ 
$TPL_sitetypeloop_1=empty($TPL_VAR["sitetypeloop"])||!is_array($TPL_VAR["sitetypeloop"])?0:count($TPL_VAR["sitetypeloop"]);
$TPL_dataForTable_1=empty($TPL_VAR["dataForTable"])||!is_array($TPL_VAR["dataForTable"])?0:count($TPL_VAR["dataForTable"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

  
<!--[if IE]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />
<script type="text/javascript">
	$(document).ready(function() {
		$(".all-check").toggle(function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',true);
		},function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',false);
		});

		$(".jqplot-point-label").live("mouseenter",function(){
			$(this).addClass("jqplot-point-label-border");
		}).live("mouseleave",function(){
			$(this).removeClass("jqplot-point-label-border");
		});

		$("input[name='date_type']").each(function(){
			$(this).live('click', function(){
				if	($(this).val() == 'month'){
					$(".scMonth").addClass('hide');
				}else{
					$(".scMonth").removeClass('hide');
				}
			});
		});

		/* 일별/월별 시 데이터 갱신 버튼 추가 :: 2014-08-05 lwh */
		$("input[name='date_type']").bind("click", function (){
			if($(this).val() == 'hour'){
				$(".renewal").hide();
			}else{
				$(".renewal").show();
			}
		});
	});
</script>
<style>
	.jqplot-point-label-border {z-index:500; border:1px solid #000; background-color:#fff; padding:3px; margin-left:-3px; margin-top:-3px;}
	.sub-top { text-align:center; border-top:1px solid #C8C8C8 !important; border-bottom:1px solid #C8C8C8 !important; }
	.subtit { background-color:#FFFFE8; font-weight:bold; }
	.total_line { border-top:1px solid #A6A6A6 !important; }
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">
	
		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			
		</ul>
		
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>매출 통계</h2>
		</div>
		
		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="sub-layout-container body-height-resizing">
	
<?php $this->print_("goods_menu",$TPL_SCP,1);?>

	
	<!-- 서브메뉴 바디 : 시작-->
	<div class='slc-body-wrap'>
		<div class="slc-body">		
			<div class="item-title">매출 통계 - 일별</div>
			<br style="line-height:10px" />
			
			<!-- 검색 시작 :: START -->							
			<form>
				<div class="statistic_goods pd20">
					<input type="hidden" name="search" value="on" />
					<div align="center">
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
				
						<span class="btn medium cyanblue"><input type="submit" value="검색" /></span>
						<span class="helpicon" title="입금완료일 기준입니다"></span>
					</div>
					<!-- 판매환경 기능 제거 by hed 2019-06-19 #34379 -->
					<div class="center pdt10 hide">
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
				</div>
			</form>	
			<br style="line-height:10px" />
				
			<div id="chart1" style="margin:auto; height:250px; width:1000px;"></div>				
			<br style="line-height:20px" />

			<!-- 테이블 시작 :: START -->
			<div style="width:100%; margin:auto;">		
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="right" valign="bottom" class="pdb10"><span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('일별_매출_달력','#sales_daily_calendar')" /></span></td>
					</tr>
				</table>

				<!-- 일별 매출 시작 :: START -->
				<div id="sales_daily_calendar">
<?php $this->print_("sales_daily_calendar",$TPL_SCP,1);?>

				</div>				
				<br style="line-height:20px" />
				
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="right" valign="bottom" class="pdb10"><span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('일별_매출','#sales_daily_table')" /></span></td>
					</tr>
				</table>
				
				<div id="sales_daily_table">
					<table width="100%" class="simpledata-table-style2" style="margin:auto;">
						<tr>
							<th width="60px">구분</th>
							<th width="15%" style="padding:5px 0; line-height:1.0">결제금액<div class="desc">(결제횟수)</div></th>
							<th width="10%">실결제금액</th>
							<!-- th width="9%">마일리지사용</th -->
							<th width="10%">예치금사용</th>								
							<th width="15%" style="line-height:1.0">환불<div class="desc">[환불횟수] [되돌리기]</div></th>
							<th width="9%">현금성</th>
							<!-- th width="9%">마일리지</th -->
							<th width="9%">예치금</th>
							<th width="9%">되돌리기</th>							
							<th width="11%" style="line-height:1.0">
								매출이익 <span class="helpicon" title="원가 미포함 : 매출이익 = 매출 – 환불<br/>(%) : 매출이익 / 매출 X 100"></span>
								<div class="desc">[%]</div>
							</th>
						</tr>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_K1=>$TPL_V1){?>
						<tr>
							<td align="center"><?php echo $TPL_K1+ 1?>일</td>
							<!--매출-->
							<td align="right" class="pdr5" style="background-color:#FFFFE8; font-weight:bold;">
								<?php echo get_currency_price($TPL_V1["order_price"])?>

								<div class="desc">[<?php echo number_format($TPL_V1["day_count_sum"])?>]</div>
							</td>
							<td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["day_settleprice_sum"])?></td>
							<!-- td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["day_emoney_use_sum"])?></td -->
							<td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["day_cash_use_sum"])?></td>
							
							<!--환불-->
							<td align="right" class="pdr5" style="background-color:#FFFFE8; font-weight:bold;">
								<?php echo get_currency_price($TPL_V1["day_refund_price_sum_total"])?>

								<div class="desc">[<?php echo get_currency_price($TPL_V1["day_refund_count_sum_A"])?>] [<?php echo get_currency_price($TPL_V1["day_refund_count_sum_R"])?>]</div>
							</td>
							<td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["refund_price_sum"])?></td>
							<!-- td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["refund_emoney_sum"])?></td -->
							<td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["refund_cash_sum"])?></td>
							<td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["day_rollback_price_sum"])?></td>

							<!--매출이익-->						
							<td align="right" class="pdr5" style="background-color:#FFFFE8; font-weight:bold;">
								<?php echo get_currency_price($TPL_V1["day_sales_benefit"])?>

								<div class="desc">[<?php if($TPL_V1["day_sales_benefit_percent"]){?><?php echo $TPL_V1["day_sales_benefit_percent"]?><?php }else{?>0<?php }?>%]</div>
								</font>
							</td>
						</tr>
<?php }}?>
						<tr>
							<td align="center" style="border-top:2px solid #A6A6A6;">누적</td>
							<td align="right" class="pdr5" style="background-color:#FFFFE8; font-weight:bold; border-top:2px solid #A6A6A6;">
								<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["order_price"])?>

								<div class="desc">[<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["day_count_sum"])?>]</div>
							</td>
							<td align="right" class="pdr5" style="border-top:2px solid #A6A6A6;"><?php echo get_currency_price($TPL_VAR["dataForTableSum"]["day_settleprice_sum"])?></td>
							<!-- td align="right" class="pdr5" style="border-top:2px solid #A6A6A6;"><?php echo get_currency_price($TPL_VAR["dataForTableSum"]["day_emoney_use_sum"])?></td -->
							<td align="right" class="pdr5" style="border-top:2px solid #A6A6A6;"><?php echo get_currency_price($TPL_VAR["dataForTableSum"]["day_cash_use_sum"])?></td>							
							<td align="right" class="pdr5" style="background-color:#FFFFE8; font-weight:bold; border-top:2px solid #A6A6A6;">
								<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["day_refund_price_sum_total"])?>

								<div class="desc">[<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["day_refund_count_sum_A"])?>] [<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["day_refund_count_sum_R"])?>]</div>
							</td>
							<td align="right" class="pdr5" style="border-top:2px solid #A6A6A6;">
								<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["refund_price_sum"])?>

							</td>
							<!-- td align="right" class="pdr5" style="border-top:2px solid #A6A6A6;">
								<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["refund_emoney_sum"])?>

							</td -->
							<td align="right" class="pdr5" style="border-top:2px solid #A6A6A6;">
								<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["refund_cash_sum"])?>

							</td>
							<td align="right" class="pdr5" style="border-top:2px solid #A6A6A6;">
								<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["day_rollback_price_sum"])?>

							</td>							
							<td align="right" class="pdr5" style="background-color:#FFFFE8; font-weight:bold; border-top:2px solid #A6A6A6;">
								<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["day_sales_benefit"])?>

								<div class="desc">[<?php if($TPL_VAR["dataForTableSum"]["day_sales_benefit_percent"]){?><?php echo $TPL_VAR["dataForTableSum"]["day_sales_benefit_percent"]?><?php }else{?>0<?php }?>%]</div>
							</td>
						</tr>
					</table>
				</div>

				<br style="line-height:10px" />
				<!-- 할인내역 시작 :: START -->
				<div class="sales_discount_table">
					<table width="100%" class="simpledata-table-style2" style="margin:auto;">
						<tr>
							<th width="60px">구분</th>
							<th class="subtit" align="center">할인</th>
							<th width="8%" align="center">마일리지</th>
							<th width="8%" align="center">에누리</th>
							<th width="8%" align="center">등급</th>
							<th width="8%" align="center">모바일</th>
							<th width="8%" align="center">이벤트</th>
							<th width="8%" align="center">유입</th>
							<th width="8%" align="center">쿠폰</th>
							<th width="8%" align="center">코드</th>
							<th width="8%" align="center">복수구매</th>
							<th width="8%" align="center">제휴사</th>
						</tr>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_K1=>$TPL_V1){?>
						<tr>
							<td align="center"><?php echo $TPL_K1+ 1?>일</td>
							<td align="right" class="pdr5 subtit">
								<?php echo get_currency_price($TPL_V1["discount_price"])?>

							</td>
							<td align="right" class="pdr5">
								<?php echo get_currency_price(($TPL_V1["day_emoney_use_sum"]-$TPL_V1["day_refund_emoney_use_sum"]))?>

							</td>
							<td align="right" class="pdr5">
								<?php echo get_currency_price(($TPL_V1["day_enuri_sum"]-$TPL_V1["day_refund_enuri_sum"]))?>

							</td>
							<td align="right" class="pdr5">
								<?php echo get_currency_price(($TPL_V1["day_member_sale_sum"]-$TPL_V1["day_refund_member_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5">
								<?php echo get_currency_price(($TPL_V1["day_mobile_sale_sum"]-$TPL_V1["day_refund_mobile_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5">
								<?php echo get_currency_price(($TPL_V1["day_event_sale_sum"]-$TPL_V1["day_refund_event_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5">
								<?php echo get_currency_price(($TPL_V1["day_referer_sale_sum"]-$TPL_V1["day_refund_referer_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5">
								<?php echo get_currency_price(($TPL_V1["day_coupon_sale_sum"]-$TPL_V1["day_refund_coupon_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5">
								<?php echo get_currency_price(($TPL_V1["day_promotion_code_sale_sum"]-$TPL_V1["day_refund_promotion_code_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5">
								<?php echo get_currency_price(($TPL_V1["day_multi_sale_sum"]-$TPL_V1["day_refund_multi_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5">
								<?php echo get_currency_price(($TPL_V1["day_api_pg_sale_sum"]-$TPL_V1["day_refund_api_pg_sale_sum"]))?>

							</td>
						</tr>
<?php }}?>
						<tr>
							<td align="center" class="total_line">누적</td>
							<td align="right" class="pdr5 subtit total_line">
								<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["discount_price"])?>

							</td>
							<td align="right" class="pdr5 total_line">
								<?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["day_emoney_use_sum"]-$TPL_VAR["dataForTableSum"]["day_refund_emoney_use_sum"]))?>

							</td>
							<td align="right" class="pdr5 total_line">
								<?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["day_enuri_sum"]-$TPL_VAR["dataForTableSum"]["day_refund_enuri_sum"]))?>

							</td>
							<td align="right" class="pdr5 total_line">
								<?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["day_member_sale_sum"]-$TPL_VAR["dataForTableSum"]["day_refund_member_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5 total_line">
								<?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["day_mobile_sale_sum"]-$TPL_VAR["dataForTableSum"]["day_refund_mobile_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5 total_line">
								<?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["day_event_sale_sum"]-$TPL_VAR["dataForTableSum"]["day_refund_event_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5 total_line">
								<?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["day_referer_sale_sum"]-$TPL_VAR["dataForTableSum"]["day_refund_referer_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5 total_line">
								<?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["day_coupon_sale_sum"]-$TPL_VAR["dataForTableSum"]["day_refund_coupon_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5 total_line">
								<?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["day_promotion_code_sale_sum"]-$TPL_VAR["dataForTableSum"]["day_refund_promotion_code_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5 total_line">
								<?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["day_multi_sale_sum"]-$TPL_VAR["dataForTableSum"]["day_refund_multi_sale_sum"]))?>

							</td>
							<td align="right" class="pdr5 total_line">
								<?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["day_api_pg_sale_sum"]-$TPL_VAR["dataForTableSum"]["day_refund_api_pg_sale_sum"]))?>

							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script class="code" type="text/javascript">
$(document).ready(function(){
	var maxValue = <?php echo $TPL_VAR["maxValue"]?>;
	
	var gap = parseInt(maxValue.toString().substring(0,1)) < 2 ? Math.pow(10,maxValue.toString().length-2) : Math.pow(10,maxValue.toString().length-1);
	var yaxisMax = parseInt(maxValue.toString().substring(0,1)) < 2 ? gap * (parseInt(maxValue.toString().substring(0,2))+2) : gap * (parseInt(maxValue.toString().substring(0,1))+2);
	yaxisMax = yaxisMax > 100 ? yaxisMax : 100;

	var line1 = <?php echo json_encode($TPL_VAR["dataForChart"]['결제금액'])?>;
	var line2 = <?php echo json_encode($TPL_VAR["dataForChart"]['매출액'])?>;
	var plot1 = $.jqplot('chart1', [line1,line2], {
		animate: !$.jqplot.use_excanvas,
		stackSeries: false,
		seriesDefaults: { 
			renderer:$.jqplot.BarRenderer,
			rendererOptions: {
				// Put a 30 pixel margin between bars.
				barMargin: 14,
				// Highlight bars when mouse button pressed.
				// Disables default highlighting on mouse over.
				highlightMouseDown: true   
			},
			pointLabels: {show: true},
			showMarker:true
		},
		axes: {      
			xaxis: {          
				renderer: $.jqplot.CategoryAxisRenderer      
			},      
			yaxis: {        
				adMin: 0      
			}    
		},   
		legend: {      
			show: true,      
			location: 'e',      
			placement: 'outside'    
		},
		seriesColors:<?php echo json_encode($TPL_VAR["seriesColors"])?>,
		series: [
			{'label':'결제금액'},
			{'label':'매출액'}
		],
		
		grid: {
	        drawGridLines: true,
	        gridLineColor: '#dddddd',
	        background: '#fffdf6',
	        borderWidth: 0,
	        shadow: false
	    }
	});

	$(".jqplot-point-label").each(function(){
		$(this).html(setComma($(this).html()));
	});
});
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>