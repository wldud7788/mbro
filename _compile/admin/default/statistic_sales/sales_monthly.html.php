<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/statistic_sales/sales_monthly.html 000058786 */ 
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
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" /><!-- nprogress -->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/nprogress/nprogress.js"></script>
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/nprogress/nprogress.css" />
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">
	var tapType = 'amount';
	var heightArr = new Array();
	heightArr['amount']	= 380;
	heightArr['refund']	= 380;
	heightArr['cost']	= 380;
	heightArr['sales']	= 380;
	$(document).ready(function() {
		
		gSearchForm.init({'pageid':'sales_sales', 'sc':<?php echo $TPL_VAR["scObj"]?>});

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

		// ?????? ?????? ??? ??? ?????? :: 2015-10-08 lwh
		$(".tap").bind("click", function(){
			tapType = $(this).attr("tap");

			$(".tap").removeClass("seltd");
			$(this).addClass("seltd");
			$(".tap_content").hide();
			$("#"+tapType+"_area").show();

			$("#info_sale_stat").height(heightArr[tapType]+"px");
		});
	});

	// ???????????? ??????????????? ??????
	function open_info_stat(){
		openDialog('?????? ?????? ??????', 'info_sale_stat', {'width':'984','height':heightArr[tapType]+93});
	}
	
	// ?????? ?????? ?????? 
	var jsonRequestScrapSalesMonthly = JSON.parse("<?php echo $TPL_VAR["jsonRequestScrapSalesMonthly"]?>");
	var iScrap = 0;
	var sScrapDialogId = 'info_scrap_sales_monthly';
	var sScrapDialogStyle = {'width':'240','height':'280', 'zIndex':'60000'};
	function fCallScrap(i){
		if(jsonRequestScrapSalesMonthly.length > 0){
			NProgress.configure({ parent: '#'+sScrapDialogId });
			if($("#" + sScrapDialogId).length == 0){
				var oDiv = '<div id="' + sScrapDialogId + '" class="hide"></div>';
				$("body").append(oDiv);
			}

			if(i < jsonRequestScrapSalesMonthly.length){
				var sScrapInfoText = jsonRequestScrapSalesMonthly[i].sScrapInfoText;
				$("#" + sScrapDialogId).html(sScrapInfoText);
				$(".progress_cnt").html(i+1);
				$(".progress_cnt_total").html(jsonRequestScrapSalesMonthly.length);
				
				openDialog('?????? ??????', sScrapDialogId, sScrapDialogStyle);
				NProgress.set(0.0);
				NProgress.start();

				var aPrams = {
					'q_type' : jsonRequestScrapSalesMonthly[i].q_type
					, 'year' : jsonRequestScrapSalesMonthly[i].year
					, 'month' : jsonRequestScrapSalesMonthly[i].month
					, 'save_provider_seq' : jsonRequestScrapSalesMonthly[i].save_provider_seq
					, 'only_o2o_stats' : jsonRequestScrapSalesMonthly[i].only_o2o_stats
				};
				$.ajax({
					'url' : '../statistic_sales/ajax_scrap_sales_monthly',
					'data' : aPrams,
					'type' : 'get',
					'dataType' : 'json',
					'sync' : false,
					'success' : function(jsonResult){
						if(parseInt(i)+1 < jsonRequestScrapSalesMonthly.length){
							fCallScrap(parseInt(i) + 1);
						}else{
							NProgress.set(1.0);
							NProgress.done(true);
							NProgress.configure({ parent: 'body' });
							closeDialog(sScrapDialogId);
							openDialogConfirm("[?????? ?????? - ????????? - ??????] ????????? ????????? ?????? ???????????????.<br/>???????????? ???????????? ???????????????????", 400, 250
								, function(){
									location.href = location.href;
								}
								, function(){
								}
							);
						}
					}
				});
			}
		}
	};

	$(document).ready(function() {
		fCallScrap(0);
	});

	
</script>
<style type="text/css">
	.jqplot-point-label-border {z-index:500; border:1px solid #000; background-color:#fff; padding:3px; margin-left:-3px; margin-top:-3px;}
	.subtit { background-color:#FFFFE8; font-weight:bold; }
	.botdot { border-bottom:0px !important; }
	.topdot { border-top: 1px dashed #CBCBCB !important; }
	.sales_benefit { background-color:#A8E4FB; font-weight:bold; }

	/* New stat CSS */
	table.stat-table-style { border-collapse:collapse; border:1px solid #CBCBCB; line-height:1.2;}
	table.stat-table-style th {background:#f9fafc ; border:1px solid #CBCBCB; color:#666; font-weight:normal; border-top: 1px solid #0f4897;}
	table.stat-table-style td {padding:5px 2px !important; border:1px solid #CBCBCB; color:#666; }
	table.stat-table-style td.t-hide { border-top:0px !important; }
	table.stat-table-style td.r-hide { border-right:0px !important; }
	table.stat-table-style td.l-hide { border-left:0px !important; }
	table.stat-table-style td.r-light { border-right:1px solid #d7d7d7 !important; }
	table.stat-table-style td.t-light { border-top:1px solid #d7d7d7 !important; }
	table.stat-table-style .r-bold { border-right:1px solid #CBCBCB !important; }
	table.stat-table-style .l-bold { border-left:1px solid #CBCBCB !important; }
	table.stat-table-style .s-title { background-color:#FFFFE8; font-weight:bold;  }
	table.stat-table-style .m-title { font-weight:bold; 
	table.stat-table-style .tit-color { background-color:#FFFFE8; }
	table.stat-table-style span.minus { color:#D33C34; }
</style>

<!-- ????????? ????????? ??? : ?????? -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- ?????? ?????? -->
		<div class="page-buttons-left">
		</div>

		<!-- ????????? -->
		<div class="page-title">
			<h2>?????? ??????</h2>
		</div>

		<!-- ?????? ?????? -->
		<div class="page-buttons-right">
		</div>
	</div>
</div>
<!-- ????????? ????????? ??? : ??? -->

<div id="search_container" class="search_container">
	<form class='search_form' >						
	<table class="table_search">
		<tr>
			<th>?????? ?????????</th>
			<td>
				<div class="resp_radio dateType">
					<label><input type="radio" name="date_type" value="month" <?php if($TPL_VAR["sc"]["date_type"]=="month"){?>checked<?php }?>/> ??????</label>
					<label><input type="radio" name="date_type" value="daily" <?php if($TPL_VAR["sc"]["date_type"]=="daily"){?>checked<?php }?>/> ??????</label>
					<label><input type="radio" name="date_type" value="hour" <?php if($TPL_VAR["sc"]["date_type"]=="hour"){?>checked<?php }?>/> ?????????</label>
				</div>
			</td>
		</tr>
		<tr>
			<th>??????</th>
			<td class="date_type_form" >
				<select name="year" class="wx80" defaultValue="<?php echo date('Y')?>">					
<?php if($TPL_year_1){foreach($TPL_VAR["year"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option>
<?php }}?>
				</select>					
				
				<select name="month" class="wx80 <?php if(!in_array('sc_month',$TPL_VAR["sc_form"]["default_field"])){?>hide<?php }?>" defaultValue="<?php echo date('m')?>" >					
<?php if($TPL_month_1){foreach($TPL_VAR["month"] as $TPL_V1){?>			
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["sc"]["month"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>				
			</td>
		</tr>
		<tr>
			<th class="hide">?????? ??????</th>
			<td class="hide">
				<div class="resp_checkbox">
				<label><input type="checkbox" name="sitetype[]" value="all" class="chkall"/> ??????</label>
<?php if($TPL_sitetypeloop_1){foreach($TPL_VAR["sitetypeloop"] as $TPL_K1=>$TPL_V1){?>
<?php if(in_array($TPL_K1,$TPL_VAR["sitetype"])){?>
				<label><input type="checkbox" name="sitetype[]" value="<?php echo $TPL_K1?>" checked="checked" /> <?php echo $TPL_V1["name"]?></label>
<?php }else{?>
				<label><input type="checkbox" name="sitetype[]" value="<?php echo $TPL_K1?>" /> <?php echo $TPL_V1["name"]?></label>
<?php }?>
<?php }}?>

				</div>
			</td>
		</tr>
	</table>
	<div class="search_btn_lay"></div>
	</form>
</div>

<!-- ???????????? ?????? : ??????-->
<div class="contents_dvs v2">
	<div class="item-title">??????</div>	
	<div class="chart_frame"><div id="chart1"></div></div>
</div>

<div class="contents_dvs v2">
	<div class="title_dvs">
		<div class="item-title">?????? ?????? ??????</div>
		<button type="button" class="resp_btn v3" onclick="divExcelDownload('??????_??????','#sales_monthly_table')" > <img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> <span>????????????</span></button>
	</div>	
	
	<!-- ?????? ????????? :: START -->
	<div id="sales_monthly_table" style="overflow-x:scroll;">
		<table class="stat-table-style table_basic pd5 v10" style="margin:auto;">
		<thead>
		<tr>
			<th class="center r-bold" style="min-width:120px;" colspan="2" 
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
					rowspan="2"
<?php }?>
				>
				??????
			</th>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_K1=>$TPL_V1){?>
			<th class="center r-bold l-bold"
<?php if(serviceLimit('H_AD')){?>
					style="min-width:240px;"
<?php }else{?>
<?php if($TPL_VAR["checkO2OService"]){?>
					style="min-width:150px;"
<?php }else{?>
					style="min-width:100px;"
<?php }?>
<?php }?>

<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_VAR["checkO2OService"]){?>
					colspan="4"
<?php }else{?>
					colspan="3"
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["checkO2OService"]){?>
					colspan="3"
<?php }?>
<?php }?>>
				<?php echo $TPL_K1+ 1?>???
			</th>
<?php }}?>
			<th class="center"
<?php if(serviceLimit('H_AD')){?>
					style="min-width:300px;"
<?php }else{?>
<?php if($TPL_VAR["checkO2OService"]){?>
					style="min-width:200px;"
<?php }else{?>
					style="min-width:150px;"
<?php }?>
<?php }?>

<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_VAR["checkO2OService"]){?>
					colspan="4"
<?php }else{?>
					colspan="3"
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["checkO2OService"]){?>
					colspan="3"
<?php }?>
<?php }?>>
				??????
			</th>
		</tr>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
		<tr>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<th class="center r-light" width="80px">??????</th>
<?php if(serviceLimit('H_AD')){?>
			<th class="center r-light" width="80px">?????????</th>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<th class="center r-light" width="80px">??????</th>
<?php }?>
			<th class="center r-bold" width="80px">???</th>
<?php }}?>
			<th class="center r-light" width="90px">??????</th>
<?php if(serviceLimit('H_AD')){?>
			<th class="center r-light" width="80px">?????????</th>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<th class="center r-light" width="80px">??????</th>
<?php }?>
			<th class="center r-bold" width="80px">???</th>
		</tr>
<?php }?>
		<!-- ???????????? :: START -->
		<tr>
			<td class="b-hide r-hide s-title" width="15px">&nbsp;</td>
			<td class="l-hide s-title r-bold center" width="105px">
				????????????
				<span class="tooltip_btn" onclick="showTooltip(this, '/admin/tooltip/statistic', '#tip6')"></span>
			</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="s-title r-light right">
				<?php echo get_currency_price($TPL_V1["month_m_order_price"])?>

			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="s-title r-light right">
				<?php echo get_currency_price($TPL_V1["month_p_order_price"])?>

			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="s-title r-light right">
				<?php echo get_currency_price($TPL_V1["month_o_order_price"])?>

			</td>
<?php }?>
			<td class="s-title r-bold right">
				<span class="underhelpicon" title="
					<table>
						<tr>
							<td>?????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["month_settleprice_sum"]-$TPL_V1["month_cash_use_sum"])?></td>
						</tr>
						<!--tr>
							<td>????????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["month_emoney_use_sum"])?></td>
						</tr-->
						<tr>
							<td>?????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["month_cash_use_sum"])?></td>
						</tr>
<?php if($TPL_VAR["npay_use"]){?>
						<tr>
							<td>Npay?????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["month_npay_point_use_sum"])?></td>
						</tr>
<?php }?>
						<tr>
							<td>????????????</td>
							<td>: </td>
							<td><?php echo number_format($TPL_V1["month_count_sum"])?></td>
						</tr>
					</table>"><?php echo get_currency_price($TPL_V1["month_order_price"])?>

				</span>
			</td>
<?php }}?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="s-title r-light right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_m_order_price"])?>

			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="s-title r-light right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_order_price"])?>

			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="s-title r-light right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_o_order_price"])?>

			</td>
<?php }?>
			<td class="s-title r-bold right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_order_price"])?>

			</td>
		</tr>
		<tr>
			<td class="t-hide b-hide tit-color">&nbsp;</td>
			<td class="pdl10 fx11 r-bold b-hide">??????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light b-hide right">
				<?php echo get_currency_price($TPL_V1["m_settleprice_sum"])?>

			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light b-hide right">
				<?php echo get_currency_price($TPL_V1["p_settleprice_sum"])?>

			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light b-hide right">
				<?php echo get_currency_price($TPL_V1["o_settleprice_sum"])?>

			</td>
<?php }?>
			<td class="r-bold b-hide right">
				<span class="underhelpicon" title="
					<table>
						<tr>
							<td>?????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["month_settleprice_sum"]-$TPL_V1["month_cash_use_sum"]-($TPL_V1["month_shipping_cost_sum"]-$TPL_V1["shipping_cash_use_sum"]))?></td>
						</tr>
						<!--tr>
							<td>????????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["month_emoney_use_sum"])?></td>
						</tr-->
						<tr>
							<td>?????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["month_cash_use_sum"]-$TPL_V1["shipping_cash_use_sum"])?></td>
						</tr>
						<!--tr>
							<td>?????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["month_shipping_cost_sum"])?></td>
						</tr-->
					</table>"><?php echo get_currency_price($TPL_V1["month_goods_price_sum"])?>

				</span>
			</td>
<?php }}?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light b-hide right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["m_settleprice_sum"])?>

			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light b-hide right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["p_settleprice_sum"])?>

			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light b-hide right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["o_settleprice_sum"])?>

			</td>
<?php }?>
			<td class="r-bold b-hide right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_goods_price_sum"])?>

			</td>
		</tr>
		<tr>
			<td class="t-hide tit-color">&nbsp;</td>
			<td class="pdl10 fx11 r-bold t-light">?????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light right">
				<span class="underhelpicon" title="
					<table>
						<tr>
							<td>?????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["m_shipping_cost_sum"]-$TPL_V1["shipping_m_cash_sum"])?></td>
						</tr>
						<tr>
							<td>?????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["shipping_m_cash_sum"])?></td>
						</tr>
					</table>"><?php echo get_currency_price((($TPL_V1["m_shipping_cost_sum"])+($TPL_V1["m_goods_shipping_cost_sum"])))?></span>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light t-light right">
				<span class="underhelpicon" title="
					<table>
						<tr>
							<td>?????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["p_shipping_cost_sum"]-$TPL_V1["shipping_p_cash_sum"])?></td>
						</tr>
						<tr>
							<td>?????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["shipping_p_cash_sum"])?></td>
						</tr>
					</table>"><?php echo get_currency_price((($TPL_V1["p_shipping_cost_sum"])+($TPL_V1["p_goods_shipping_cost_sum"])))?></span>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light right">
				<span class="underhelpicon" title="
					<table>
						<tr>
							<td>?????????????????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["o_shipping_cost_sum"])?></td>
						</tr>
						<tr>
							<td>?????????????????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["o_goods_shipping_cost_sum"])?></td>
						</tr>
					</table>"><?php echo get_currency_price((($TPL_V1["o_shipping_cost_sum"])+($TPL_V1["o_goods_shipping_cost_sum"])))?></span>
			</td>
<?php }?>
			<td class="r-bold t-light right">
				<span class="underhelpicon" title="
					<table>
						<tr>
							<td>?????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["shipping_cost_sum"]-$TPL_V1["shipping_cash_use_sum"])?></td>
						</tr>
						<tr>
							<td>?????????</td>
							<td>: </td>
							<td><?php echo get_currency_price($TPL_V1["shipping_cash_use_sum"])?></td>
						</tr>
					</table>"><?php echo get_currency_price($TPL_V1["month_shipping_cost_sum"])?></span>
			</td>
<?php }}?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light right">
				<?php echo get_currency_price((($TPL_VAR["dataForTableSum"]["m_shipping_cost_sum"])+($TPL_VAR["dataForTableSum"]["m_goods_shipping_cost_sum"])))?>

			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light t-light right">
				<?php echo get_currency_price((($TPL_VAR["dataForTableSum"]["p_shipping_cost_sum"])+($TPL_VAR["dataForTableSum"]["p_goods_shipping_cost_sum"])))?>

			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light right">
				<?php echo get_currency_price((($TPL_VAR["dataForTableSum"]["o_shipping_cost_sum"])+($TPL_VAR["dataForTableSum"]["o_goods_shipping_cost_sum"])))?>

			</td>
<?php }?>
			<td class="r-bold t-light right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_shipping_cost_sum"])?>

			</td>
		</tr>
		<!-- ???????????? :: END -->
		<!-- ?????? :: START -->
		<tr>
			<td class="b-hide r-hide" width="20px">&nbsp;</td>
			<td class="l-hide r-bold center m-title">??????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light right m-title">
<?php if($TPL_V1["month_m_refund_price_total_sum"]< 0){?>
				<span class="minus"><?php echo get_currency_price($TPL_V1["month_m_refund_price_total_sum"])?></span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_m_refund_price_total_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light right m-title">
<?php if($TPL_V1["month_p_refund_price_total_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_p_refund_price_total_sum"])?>

					</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_p_refund_price_total_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light right m-title">
<?php if($TPL_V1["month_o_refund_price_total_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_o_refund_price_total_sum"])?>

					</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_o_refund_price_total_sum"])?>

<?php }?>
			</td>
<?php }?>
			<td class="r-bold right m-title">
				<span class="underhelpicon <?php if($TPL_V1["month_refund_price_sum"]< 0){?>minus<?php }?>" title="????????? : <?php echo get_currency_price($TPL_V1["month_refund_price_sum_A"]-$TPL_V1["month_refund_cash_sum"])?><br/><!--???????????? : <?php echo get_currency_price($TPL_V1["month_refund_emoney_sum"])?><br/-->????????? : <?php echo get_currency_price($TPL_V1["month_refund_cash_sum"])?>">
<?php if($TPL_V1["month_refund_price_total_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_refund_price_total_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_refund_price_total_sum"])?>

<?php }?>
				</span>
			</td>
<?php }}?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light right m-title">
<?php if($TPL_VAR["dataForTableSum"]["month_m_refund_price_total_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_m_refund_price_total_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_m_refund_price_total_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light right m-title">
<?php if($TPL_VAR["dataForTableSum"]["month_p_refund_price_total_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_refund_price_total_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_refund_price_total_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light right m-title">
<?php if($TPL_VAR["dataForTableSum"]["month_o_refund_price_total_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_o_refund_price_total_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_o_refund_price_total_sum"])?>

<?php }?>
			</td>
<?php }?>
			<td class="r-bold right m-title">
<?php if($TPL_VAR["dataForTableSum"]["month_refund_price_total_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_refund_price_total_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_refund_price_total_sum"])?>

<?php }?>
			</td>
		</tr>
		<tr>
			<td class="t-hide b-hide">&nbsp;</td>
			<td class="pdl10 fx11 r-bold b-hide">??????/??????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light b-hide right">
<?php if($TPL_V1["month_m_refund_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_m_refund_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_m_refund_price_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light b-hide right">
<?php if($TPL_V1["month_p_refund_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_p_refund_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_p_refund_price_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light b-hide right">
<?php if($TPL_V1["month_o_refund_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_o_refund_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_o_refund_price_sum"])?>

<?php }?>
			</td>
<?php }?>
			<td class="r-bold b-hide right">
				<span class="underhelpicon <?php if($TPL_V1["month_refund_price_sum"]< 0){?>minus<?php }?>" title="???????????? : <?php echo get_currency_price($TPL_V1["month_refund_price_sum"])?>"><?php echo get_currency_price($TPL_V1["month_refund_price_sum"])?></span>
			</td>
<?php }}?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light b-hide right">
<?php if($TPL_VAR["dataForTableSum"]["month_m_refund_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_m_refund_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_m_refund_price_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light b-hide right">
<?php if($TPL_VAR["dataForTableSum"]["month_p_refund_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_refund_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_refund_price_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light b-hide right">
<?php if($TPL_VAR["dataForTableSum"]["month_o_refund_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_o_refund_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_o_refund_price_sum"])?>

<?php }?>
			</td>
<?php }?>
			<td class="r-bold b-hide right">
<?php if($TPL_VAR["dataForTableSum"]["month_refund_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_refund_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_refund_price_sum"])?>

<?php }?>
			</td>
		</tr>
		<tr>
			<td class="t-hide">&nbsp;</td>
			<td class="pdl10 fx11 r-bold t-light">????????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light right">
<?php if($TPL_V1["month_m_rollback_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_m_rollback_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_m_rollback_price_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light t-light right">
<?php if($TPL_V1["month_p_rollback_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_p_rollback_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_p_rollback_price_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light right">
<?php if($TPL_V1["month_o_rollback_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_o_rollback_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_o_rollback_price_sum"])?>

<?php }?>
			</td>
<?php }?>
			<td class="r-bold t-light right">
				<span class="underhelpicon <?php if($TPL_V1["month_refund_price_sum"]< 0){?>minus<?php }?>" title="???????????? : <?php echo get_currency_price($TPL_V1["month_rollback_price_sum"])?>">
<?php if($TPL_V1["month_rollback_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_rollback_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_rollback_price_sum"])?>

<?php }?>
				</span>
			</td>
<?php }}?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light right">
<?php if($TPL_VAR["dataForTableSum"]["month_m_rollback_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_m_rollback_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_m_rollback_price_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light t-light right">
<?php if($TPL_VAR["dataForTableSum"]["month_p_rollback_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_rollback_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_rollback_price_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light right">
<?php if($TPL_VAR["dataForTableSum"]["month_o_rollback_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_o_rollback_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_o_rollback_price_sum"])?>

<?php }?>
			</td>
<?php }?>
			<td class="r-bold t-light right">
<?php if($TPL_VAR["dataForTableSum"]["month_rollback_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_rollback_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_rollback_price_sum"])?>

<?php }?>
			</td>
		</tr>
		<!-- ?????? :: END -->
		<!-- ?????? :: START -->
		<tr>
			<td class="l-hide s-title r-bold center" colspan="2">?????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="s-title r-light right">
				<?php echo get_currency_price($TPL_V1["month_m_sales_price"])?>

			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="s-title r-light right">
				<?php echo get_currency_price($TPL_V1["month_p_sales_price"])?>

			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="s-title r-light right">
				<?php echo get_currency_price($TPL_V1["month_o_sales_price"])?>

			</td>
<?php }?>
			<td class="s-title r-bold right">
				<?php echo get_currency_price($TPL_V1["month_sales_price"])?>

			</td>
<?php }}?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="s-title r-light right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_m_sales_price"])?>

			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="s-title r-light right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_sales_price"])?>

			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="s-title r-light right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_o_sales_price"])?>

			</td>
<?php }?>
			<td class="s-title r-bold right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_sales_price"])?>

			</td>
		</tr>
		<!-- ?????? :: START -->
		<!-- ?????? :: START -->
		<tr>
			<td class="b-hide r-hide" width="20px">&nbsp;</td>
			<td class="l-hide r-bold center m-title">??????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light right m-title">
<?php if($TPL_V1["month_supply_total"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_supply_total"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_supply_total"])?>

<?php }?>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light right m-title">
<?php if($TPL_V1["month_commission_total"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_commission_total"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_commission_total"])?>

<?php }?>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-bold right m-title">
<?php if($TPL_V1["o_month_supply_total"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["o_month_supply_total"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["o_month_supply_total"])?>

<?php }?>
			</td>
<?php }?>
			<td class="r-bold right m-title">
<?php if($TPL_V1["month_supply_commission_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_supply_commission_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_supply_commission_sum"])?>

<?php }?>
			</td>
<?php }}?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light right m-title">
<?php if($TPL_VAR["dataForTableSum"]["month_supply_total"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_supply_total"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_supply_total"])?>

<?php }?>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light right m-title">
<?php if($TPL_VAR["dataForTableSum"]["month_commission_total"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_commission_total"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_commission_total"])?>

<?php }?>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light right m-title">
<?php if($TPL_VAR["dataForTableSum"]["o_month_supply_total"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["o_month_supply_total"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["o_month_supply_total"])?>

<?php }?>
			</td>
<?php }?>
			<td class="r-bold right m-title">
<?php if($TPL_VAR["dataForTableSum"]["month_supply_commission_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_supply_commission_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_supply_commission_sum"])?>

<?php }?>
			</td>
		</tr>
		<tr>
			<td class="t-hide b-hide">&nbsp;</td>
			<td class="pdl10 fx11 r-bold b-hide">??????/??????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light b-hide right">
<?php if($TPL_V1["month_supply_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_supply_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_supply_price_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light b-hide right">
<?php if($TPL_V1["month_commission_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_commission_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_commission_price_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light b-hide right">
<?php if($TPL_V1["o_month_supply_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["o_month_supply_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["o_month_supply_price_sum"])?>

<?php }?>
			</td>
<?php }?>
			<td class="r-bold b-hide right">
				<span class="underhelpicon <?php if($TPL_V1["month_supply_price"]< 0){?>minus<?php }?>" title="???????????? : <?php echo $TPL_V1["month_supply_price"]?>">
<?php if($TPL_V1["month_supply_price"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_supply_price"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_supply_price"])?>

<?php }?>
			</td>
<?php }}?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light b-hide right">
<?php if($TPL_VAR["dataForTableSum"]["month_supply_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_supply_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_supply_price_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light b-hide right">
<?php if($TPL_VAR["dataForTableSum"]["month_commission_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_commission_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_commission_price_sum"])?>

<?php }?>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light b-hide right">
<?php if($TPL_VAR["dataForTableSum"]["o_month_supply_price_sum"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["o_month_supply_price_sum"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["o_month_supply_price_sum"])?>

<?php }?>
			</td>
<?php }?>
			<td class="r-bold b-hide right">
<?php if($TPL_VAR["dataForTableSum"]["month_supply_price"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_supply_price"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_supply_price"])?>

<?php }?>
			</td>
		</tr>
		<tr>
			<td class="t-hide b-hide">&nbsp;</td>
			<td class="pdl10 fx11 r-bold t-light b-hide">??????/??????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light b-hide right">
				<?php echo get_currency_price($TPL_V1["month_refund_supply_price_sum"])?>

			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light t-light b-hide right">
				<?php echo get_currency_price($TPL_V1["month_refund_commission_price_sum"])?>

			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light b-hide right">
				<?php echo get_currency_price($TPL_V1["o_month_refund_supply_price_sum"])?>

			</td>
<?php }?>
			<td class="r-bold t-light b-hide right">
				<?php echo get_currency_price($TPL_V1["month_refund_supply"])?>

			</td>
<?php }}?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light b-hide right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_refund_supply_price_sum"])?>

			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light t-light b-hide right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_refund_commission_price_sum"])?>

			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light b-hide right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["o_month_refund_supply_price_sum"])?>

			</td>
<?php }?>
			<td class="r-bold t-light b-hide right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_refund_supply"])?>

			</td>
		</tr>
		<tr>
			<td class="t-hide">&nbsp;</td>
			<td class="pdl10 fx11 r-bold t-light">????????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light right">
				<?php echo get_currency_price($TPL_V1["refund_rollback_supply_price_sum"])?>

			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light t-light right">
				<?php echo get_currency_price($TPL_V1["refund_rollback_commission_price_sum"])?>

			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light right">
				<?php echo get_currency_price($TPL_V1["o_refund_rollback_supply_price_sum"])?>

			</td>
<?php }?>
			<td class="r-bold t-light right">
				<?php echo get_currency_price($TPL_V1["month_rollback_supply"])?>

			</td>
<?php }}?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["refund_rollback_supply_price_sum"])?>

			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="r-light t-light right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["refund_rollback_commission_price_sum"])?>

			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="r-light t-light right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["o_refund_rollback_supply_price_sum"])?>

			</td>
<?php }?>
			<td class="r-bold t-light right">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_rollback_supply"])?>

			</td>
		</tr>
		<!-- ?????? :: END -->
		<!-- ???????????? :: START -->
		<tr>
			<td class="l-hide s-title r-bold center" colspan="2">
				????????????<br/>[%]
			</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="s-title r-light right">
<?php if($TPL_V1["month_m_sales_benefit"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_m_sales_benefit"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_m_sales_benefit"])?>

<?php }?>
				<div style="font-size:11px;letter-spacing:-1px;text-align:right">
<?php if($TPL_V1["month_m_sales_benefit_percent"]< 0){?>
				<span class="minus">(<?php echo $TPL_V1["month_m_sales_benefit_percent"]?>%)</span>
<?php }else{?>
				[<?php echo $TPL_V1["month_m_sales_benefit_percent"]?>%]
<?php }?>
				</div>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="s-title r-light right">
<?php if($TPL_V1["month_p_sales_benefit"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_p_sales_benefit"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_p_sales_benefit"])?>

<?php }?>
				<div style="font-size:11px;letter-spacing:-1px;text-align:right">
<?php if($TPL_V1["month_p_sales_benefit_percent"]< 0){?>
				<span class="minus">(<?php echo $TPL_V1["month_p_sales_benefit_percent"]?>%)</span>
<?php }else{?>
				[<?php echo $TPL_V1["month_p_sales_benefit_percent"]?>%]
<?php }?>
				</div>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="s-title r-light right">
<?php if($TPL_V1["month_o_sales_benefit"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_o_sales_benefit"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_o_sales_benefit"])?>

<?php }?>
				<div style="font-size:11px;letter-spacing:-1px;text-align:right">
<?php if($TPL_V1["month_o_sales_benefit_percent"]< 0){?>
				<span class="minus">(<?php echo $TPL_V1["month_o_sales_benefit_percent"]?>%)</span>
<?php }else{?>
				[<?php echo $TPL_V1["month_o_sales_benefit_percent"]?>%]
<?php }?>
				</div>
			</td>
<?php }?>
			<td class="s-title r-bold right">
<?php if($TPL_V1["month_sales_benefit"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_V1["month_sales_benefit"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["month_sales_benefit"])?>

<?php }?>
				<div style="font-size:11px;letter-spacing:-1px;text-align:right">
<?php if($TPL_V1["month_sales_benefit_percent"]< 0){?>
				<span class="minus">(<?php echo $TPL_V1["month_sales_benefit_percent"]?>%)</span>
<?php }else{?>
				[<?php echo $TPL_V1["month_sales_benefit_percent"]?>%]
<?php }?>
				</div>
			</td>
<?php }}?>
<?php if(serviceLimit('H_AD')||$TPL_VAR["checkO2OService"]){?>
			<td class="s-title r-light right">
<?php if($TPL_VAR["dataForTableSum"]["month_m_sales_benefit"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_m_sales_benefit"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_m_sales_benefit"])?>

<?php }?>
				<div style="font-size:11px;letter-spacing:-1px;text-align:right">
<?php if($TPL_VAR["dataForTableSum"]["month_m_sales_benefit_percent"]< 0){?>
				<span class="minus">(<?php echo $TPL_VAR["dataForTableSum"]["month_m_sales_benefit_percent"]?>%)</span>
<?php }else{?>
				[<?php echo $TPL_VAR["dataForTableSum"]["month_m_sales_benefit_percent"]?>%]
<?php }?>
				</div>
			</td>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
			<td class="s-title r-light right">
<?php if($TPL_VAR["dataForTableSum"]["month_p_sales_benefit"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_sales_benefit"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_sales_benefit"])?>

<?php }?>
				<div style="font-size:11px;letter-spacing:-1px;text-align:right">
<?php if($TPL_VAR["dataForTableSum"]["month_p_sales_benefit_percent"]< 0){?>
				<span class="minus">(<?php echo $TPL_VAR["dataForTableSum"]["month_p_sales_benefit_percent"]?>%)</span>
<?php }else{?>
				[<?php echo $TPL_VAR["dataForTableSum"]["month_p_sales_benefit_percent"]?>%]
<?php }?>
				</div>
			</td>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
			<td class="s-title r-light right">
<?php if($TPL_VAR["dataForTableSum"]["month_o_sales_benefit"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_o_sales_benefit"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_o_sales_benefit"])?>

<?php }?>
				<div style="font-size:11px;letter-spacing:-1px;text-align:right">
<?php if($TPL_VAR["dataForTableSum"]["month_o_sales_benefit_percent"]< 0){?>
				<span class="minus">(<?php echo $TPL_VAR["dataForTableSum"]["month_o_sales_benefit_percent"]?>%)</span>
<?php }else{?>
				[<?php echo $TPL_VAR["dataForTableSum"]["month_o_sales_benefit_percent"]?>%]
<?php }?>
				</div>
			</td>
<?php }?>
			<td class="s-title r-bold right">
<?php if($TPL_VAR["dataForTableSum"]["month_sales_benefit"]< 0){?>
				<span class="minus">
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_sales_benefit"])?>

				</span>
<?php }else{?>
				<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_sales_benefit"])?>

<?php }?>
				<div style="font-size:11px;letter-spacing:-1px;text-align:right">
<?php if($TPL_VAR["dataForTableSum"]["month_sales_benefit_percent"]< 0){?>
				<span class="minus">(<?php echo $TPL_VAR["dataForTableSum"]["month_sales_benefit_percent"]?>%)</span>
<?php }else{?>
				[<?php echo $TPL_VAR["dataForTableSum"]["month_sales_benefit_percent"]?>%]
<?php }?>
				</div>
			</td>
		</tr>
		<!-- ???????????? :: END -->
		</tbody>
		</table>
	</div>	
	<!-- ?????? ????????? :: END -->
</div>

<div class="contents_dvs v2">
	<div class="title_dvs">
		<div class="item-title">?????? ?????? ??????</div>		
	</div>	
	<!-- ??????????????? :: START -->		
	<div id="sales_discount_table">
		<table class="table_basic v7 pd7">
		<tr>
			<th>??????</th>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_K1=>$TPL_V1){?>
			<th width="7%"><?php echo $TPL_K1+ 1?>???</th>
<?php }}?>
			<th width="7%">??????</th>
		</tr>
		<tr>
			<td class="subtit center">??????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right" class="subtit"><?php echo get_currency_price($TPL_V1["discount_price"])?></td>
<?php }}?>
			<td align="right" class="subtit"><?php echo get_currency_price($TPL_VAR["dataForTableSum"]["discount_price"])?></td>
		</tr>
		<tr>
			<td align="right" >????????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right"><?php echo get_currency_price(($TPL_V1["month_emoney_use_sum"]-$TPL_V1["month_refund_emoney_use_sum"]))?></td>
<?php }}?>
			<td align="right"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_emoney_use_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_emoney_use_sum"]))?></td>
		</tr>
		<tr>
			<td align="right" >?????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right"><?php echo get_currency_price(($TPL_V1["month_enuri_sum"]-$TPL_V1["month_refund_enuri_sum"]))?></td>
<?php }}?>
			<td align="right"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_enuri_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_enuri_sum"]))?></td>
		</tr>
		<tr>
			<td align="right" >????????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right"><?php echo get_currency_price(($TPL_V1["month_member_sale_sum"]-$TPL_V1["month_refund_member_sale_sum"]))?></td>
<?php }}?>
			<td align="right"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_member_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_member_sale_sum"]))?></td>
		</tr>
		<tr>
			<td align="right" >?????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right"><?php echo get_currency_price(($TPL_V1["month_mobile_sale_sum"]-$TPL_V1["month_refund_mobile_sale_sum"]))?></td>
<?php }}?>
			<td align="right"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_mobile_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_mobile_sale_sum"]))?></td>
		</tr>
		<tr>
			<td align="right" >?????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right"><?php echo get_currency_price(($TPL_V1["month_event_sale_sum"]-$TPL_V1["month_refund_event_sale_sum"]))?></td>
<?php }}?>
			<td align="right"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_event_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_event_sale_sum"]))?></td>
		</tr>
		<tr>
			<td align="right" >????????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right"><?php echo get_currency_price(($TPL_V1["month_referer_sale_sum"]-$TPL_V1["month_refund_referer_sale_sum"]))?></td>
<?php }}?>
			<td align="right"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_referer_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_referer_sale_sum"]))?></td>
		</tr>
		<tr>
			<td align="right" >??????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right"><?php echo get_currency_price(($TPL_V1["month_coupon_sale_sum"]-$TPL_V1["month_refund_coupon_sale_sum"]))?></td>
<?php }}?>
			<td align="right"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_coupon_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_coupon_sale_sum"]))?></td>
		</tr>
		<tr>
			<td align="right" >??????????????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right"><?php echo get_currency_price(($TPL_V1["month_promotion_code_sale_sum"]-$TPL_V1["month_refund_promotion_code_sale_sum"]))?></td>
<?php }}?>
			<td align="right"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_promotion_code_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_promotion_code_sale_sum"]))?></td>
		</tr>
		<tr>
			<td align="right" >????????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right"><?php echo get_currency_price(($TPL_V1["month_multi_sale_sum"]-$TPL_V1["month_refund_multi_sale_sum"]))?></td>
<?php }}?>
			<td align="right"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_multi_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_multi_sale_sum"]))?></td>
		</tr>
		<tr>
			<td align="right" >?????????</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right"><?php echo get_currency_price(($TPL_V1["month_api_pg_sale_sum"]-$TPL_V1["month_refund_api_pg_sale_sum"]))?></td>
<?php }}?>
			<td align="right"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_api_pg_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_api_pg_sale_sum"]))?></td>
		</tr>
<?php if($TPL_VAR["npay_use"]){?>
		<tr>
			<td align="right">Npay??????(???????????????)</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right"><?php echo get_currency_price(($TPL_V1["month_npay_sale_seller_sum"]-$TPL_V1["month_refund_npay_sale_seller_sum"]))?></td>
<?php }}?>
			<td align="right"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_npay_sale_seller_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_npay_sale_seller_sum"]))?></td>
		</tr>
		<tr>
			<td align="right">Npay??????(?????????????????????)</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
			<td align="right"><?php echo get_currency_price(($TPL_V1["month_npay_sale_npay_sum"]-$TPL_V1["month_refund_npay_sale_npay_sum"]))?></td>
<?php }}?>
			<td align="right"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_npay_sale_npay_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_npay_sale_npay_sum"]))?></td>
		</tr>
<?php }?>
		</table>
	</div>
	<!-- ??????????????? :: END -->
</div>

<div class="box_style_05 mt20">
	<div class="title">??????</div>
	<ul class="bullet_circle">					
		<li>?????? ?????? ?????? <a href="https://www.firstmall.kr/customer/faq/1345" target="_blank" class="resp_btn_txt">????????? ??????</a></li>			
	</ul>
</div>

<script class="code" type="text/javascript">
	$(document).ready(function(){
		var maxValue = <?php echo $TPL_VAR["maxValue"]?>;

		var gap = parseInt(maxValue.toString().substring(0,1)) < 2 ? Math.pow(10,maxValue.toString().length-2) : Math.pow(10,maxValue.toString().length-1);
		var yaxisMax = parseInt(maxValue.toString().substring(0,1)) < 2 ? gap * (parseInt(maxValue.toString().substring(0,2))+2) : gap * (parseInt(maxValue.toString().substring(0,1))+2);
		yaxisMax = yaxisMax > 100 ? yaxisMax : 100;

		var line1 = <?php echo json_encode($TPL_VAR["dataForChart"]['?????????'])?>;
		var line2 = <?php echo json_encode($TPL_VAR["dataForChart"]['????????????'])?>;
		var plot1 = $.jqplot('chart1', [line1,line2], {
			animate: !$.jqplot.use_excanvas,
			stackSeries: false,
			seriesDefaults: {
				renderer:$.jqplot.BarRenderer,
				rendererOptions: {
					// Put a 30 pixel margin between bars.
					barMargin: 15,
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
				{'label':'?????????'},
				{'label':'????????????'}
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