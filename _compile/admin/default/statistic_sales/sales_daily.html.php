<?php /* Template_ 2.2.6 2022/05/17 12:37:14 /www/music_brother_firstmall_kr/admin/skin/default/statistic_sales/sales_daily.html 000019117 */ 
$TPL_year_1=empty($TPL_VAR["year"])||!is_array($TPL_VAR["year"])?0:count($TPL_VAR["year"]);
$TPL_month_1=empty($TPL_VAR["month"])||!is_array($TPL_VAR["month"])?0:count($TPL_VAR["month"]);
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

		/* ??????/?????? ??? ????????? ?????? ?????? ?????? :: 2014-08-05 lwh */
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

<!-- ????????? ????????? ??? : ?????? -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">
	
		<!-- ?????? ?????? -->
		<ul class="page-buttons-left">
			
		</ul>
		
		<!-- ????????? -->
		<div class="page-title">
			<h2>?????? ??????</h2>
		</div>
		
		<!-- ?????? ?????? -->
		<ul class="page-buttons-right">
			
		</ul>

	</div>
</div>
<!-- ????????? ????????? ??? : ??? -->

<!-- ?????? ???????????? ?????? : ?????? -->
<div class="sub-layout-container body-height-resizing">
	
<?php $this->print_("sales_menu",$TPL_SCP,1);?>

	
	<!-- ???????????? ?????? : ??????-->
	<div class='slc-body-wrap'>
		<div class="slc-body">		
			<div class="item-title">?????? ?????? - ?????????</div>
			<br style="line-height:10px" />
			
			<!-- ?????? ?????? :: START -->							
			<form>
				<div class="statistic_goods pd20">
					<input type="hidden" name="search" value="on" />
					<div align="center">
						<label><input type="radio" name="date_type" value="month" /> ??????</label>
						<label><input type="radio" name="date_type" value="daily" checked /> ??????</label>
						<label><input type="radio" name="date_type" value="hour" /> ?????????</label>
						<select name="year">
						<option value="">= ?????? ?????? =</option>
<?php if($TPL_year_1){foreach($TPL_VAR["year"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["year"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> ???</option>
<?php }}?>
						</select>

						<span class="scMonth">
						<select name="month">
						<option value="">= ??? ?????? =</option>
<?php if($TPL_month_1){foreach($TPL_VAR["month"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["month"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> ???</option>
<?php }}?>
						</select>
						</span>
				
						<span class="btn medium cyanblue"><input type="submit" value="??????" /></span>
						<span class="helpicon" title="??????????????? ???????????????"></span>
					</div>
					<!-- ???????????? ?????? ?????? by hed 2019-06-19 #34379 -->
					<div class="center pdt10 hide">
						<strong>???????????? &nbsp;</strong>
<?php if($TPL_sitetypeloop_1){foreach($TPL_VAR["sitetypeloop"] as $TPL_K1=>$TPL_V1){?>
<?php if(in_array($TPL_K1,$TPL_VAR["sitetype"])){?>
							<label class="search_label"><input type="checkbox" name="sitetype[]" value="<?php echo $TPL_K1?>" checked="checked" /> <?php echo $TPL_V1["name"]?></label>
<?php }else{?>
							<label class="search_label"><input type="checkbox" name="sitetype[]" value="<?php echo $TPL_K1?>" /> <?php echo $TPL_V1["name"]?></label>
<?php }?>
<?php }}?>
						<span class="icon-check hand all-check"><b class="">??????</b></span>
					</div>
				</div>
			</form>	
			<br style="line-height:10px" />
				
			<div id="chart1" style="margin:auto; height:250px; width:1000px;"></div>				
			<br style="line-height:20px" />

			<!-- ????????? ?????? :: START -->
			<div style="width:100%; margin:auto;">		
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="right" valign="bottom" class="pdb10"><span class="btn small"><input type="button" value="????????????" onclick="divExcelDownload('??????_??????_??????','#sales_daily_calendar')" /></span></td>
					</tr>
				</table>

				<!-- ?????? ?????? ?????? :: START -->
				<div id="sales_daily_calendar">
<?php $this->print_("sales_daily_calendar",$TPL_SCP,1);?>

				</div>				
				<br style="line-height:20px" />
				
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="right" valign="bottom" class="pdb10"><span class="btn small"><input type="button" value="????????????" onclick="divExcelDownload('??????_??????','#sales_daily_table')" /></span></td>
					</tr>
				</table>
				
				<div id="sales_daily_table">
					<table width="100%" class="simpledata-table-style2" style="margin:auto;">
						<tr>
							<th width="60px">??????</th>
							<th width="15%" style="padding:5px 0; line-height:1.0">????????????<div class="desc">(????????????)</div></th>
							<th width="10%">???????????????</th>
							<!-- th width="9%">??????????????????</th -->
							<th width="10%">???????????????</th>								
							<th width="15%" style="line-height:1.0">??????<div class="desc">[????????????] [????????????]</div></th>
							<th width="10%">?????????</th>
							<!-- th width="9%">????????????</th -->
							<th width="10%">?????????</th>
							<th width="10%">????????????</th>							
							<th width="15%" style="line-height:1.0">
								?????????
								<!--span class="helpicon" title="?????? ????????? : ???????????? = ?????? ??? ??????<br/>(%) : ???????????? / ?????? X 100"></span-->
								<div class="desc">[%]</div>
							</th>
						</tr>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_K1=>$TPL_V1){?>
						<tr>
							<td align="center"><?php echo $TPL_K1+ 1?>???</td>
							<!--??????-->
							<td align="right" class="pdr5" style="background-color:#FFFFE8; font-weight:bold;">
								<?php echo get_currency_price($TPL_V1["order_price"])?>

								<div class="desc">[<?php echo number_format($TPL_V1["day_count_sum"])?>]</div>
							</td>
							<td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["day_settleprice_sum"])?></td>
							<!-- td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["day_emoney_use_sum"])?></td -->
							<td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["day_cash_use_sum"])?></td>
							
							<!--??????-->
							<td align="right" class="pdr5" style="background-color:#FFFFE8; font-weight:bold;">
								<?php echo get_currency_price($TPL_V1["day_refund_price_sum_total"])?>

								<div class="desc">[<?php echo get_currency_price($TPL_V1["day_refund_count_sum_A"])?>] [<?php echo get_currency_price($TPL_V1["day_refund_count_sum_R"])?>]</div>
							</td>
							<td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["refund_price_sum"])?></td>
							<!-- td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["refund_emoney_sum"])?></td -->
							<td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["refund_cash_sum"])?></td>
							<td align="right" class="pdr5"><?php echo get_currency_price($TPL_V1["day_rollback_price_sum"])?></td>

							<!--????????????-->						
							<td align="right" class="pdr5" style="background-color:#FFFFE8; font-weight:bold;">
								<?php echo get_currency_price($TPL_V1["day_sales_benefit"])?>

								<div class="desc">[<?php if($TPL_V1["day_sales_benefit_percent"]){?><?php echo $TPL_V1["day_sales_benefit_percent"]?><?php }else{?>0<?php }?>%]</div>
								</font>
							</td>
						</tr>
<?php }}?>
						<tr>
							<td align="center" style="border-top:2px solid #A6A6A6;">??????</td>
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
				<!-- ???????????? ?????? :: START -->
				<div class="sales_discount_table">
					<table width="100%" class="simpledata-table-style2" style="margin:auto;">
						<tr>
							<th width="60px">??????</th>
							<th class="subtit" align="center">??????</th>
							<th width="8%" align="center">????????????</th>
							<th width="8%" align="center">?????????</th>
							<th width="8%" align="center">??????</th>
							<th width="8%" align="center">?????????</th>
							<th width="8%" align="center">?????????</th>
							<th width="8%" align="center">??????</th>
							<th width="8%" align="center">??????</th>
							<th width="8%" align="center">??????</th>
							<th width="8%" align="center">????????????</th>
							<th width="8%" align="center">?????????</th>
						</tr>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_K1=>$TPL_V1){?>
						<tr>
							<td align="center"><?php echo $TPL_K1+ 1?>???</td>
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
							<td align="center" class="total_line">??????</td>
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

	var line1 = <?php echo json_encode($TPL_VAR["dataForChart"]['??????'])?>;
	var line2 = <?php echo json_encode($TPL_VAR["dataForChart"]['????????????'])?>;
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
			{'label':'????????????'},
			{'label':'?????????'}
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