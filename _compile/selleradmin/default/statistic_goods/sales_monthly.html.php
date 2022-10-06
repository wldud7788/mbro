<?php /* Template_ 2.2.6 2022/05/17 12:29:33 /www/music_brother_firstmall_kr/selleradmin/skin/default/statistic_goods/sales_monthly.html 000035063 */ 
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
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />

<!-- nprogress -->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/nprogress/nprogress.js"></script>
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/nprogress/nprogress.css" />

<script type="text/javascript">
	var tapType = 'amount';
	var heightArr = new Array();
	heightArr['amount']	= 700;
	heightArr['refund']	= 700;
	heightArr['cost']	= 700;
	heightArr['sales']	= 280;
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

		// 안내 팝업 탭 별 클릭 :: 2015-10-08 lwh
		$(".tap").bind("click", function(){
			tapType = $(this).attr("tap");

			$(".tap").removeClass("seltd");
			$(this).addClass("seltd");
			$(".tap_content").hide();
			$("#"+tapType+"_area").show();

			$("#info_sale_stat").height(heightArr[tapType]+"px");
		});
	});

	// 매출통계 안내페이지 팝업
	function open_info_stat(){
		openDialog('매출 통계 안내', 'info_sale_stat', {'width':'984','height':heightArr[tapType]+93});
	}
	// 통계 수집 요청 
	var jsonRequestScrapSalesMonthly = JSON.parse("<?php echo $TPL_VAR["jsonRequestScrapSalesMonthly"]?>");
	var iScrap = 0;
	var sScrapDialogId = 'info_scrap_sales_monthly';
	var sScrapDialogStyle = {'width':'240','height':'180', 'zIndex':'60000'};
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
				
				openDialog('통계 수집', sScrapDialogId, sScrapDialogStyle);
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
					'url' : '../statistic_goods/ajax_scrap_sales_monthly',
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
							openDialogConfirm("[판매 통계 - 매출액 - 월별] 데이터 수집이 완료 되었습니다.<br/>페이지를 새로고침 하시겠습니까?", 400, 180
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
	table.stat-table-style { border-collapse:collapse; border:1px solid #CBCBCB; }
	table.stat-table-style th {background:#f1f1f1 /*url('/admin/skin/default/images/common/th_bg_popup.gif') repeat-x*/; height:24px; line-height:24px; border:1px solid #CBCBCB; color:#666; font-weight:normal;}
	table.stat-table-style td {padding:5px 2px; border:1px solid #CBCBCB; color:#666}
	table.stat-table-style td.t-hide { border-top:0px !important; }
	table.stat-table-style td.r-hide { border-right:0px !important; }
	table.stat-table-style td.l-hide { border-left:0px !important; }
	table.stat-table-style td.b-hide { border-bottom:0px !important; }
	table.stat-table-style td.r-light { border-right:1px solid #d7d7d7 !important; }
	table.stat-table-style td.t-light { border-top:1px solid #d7d7d7 !important; }
	table.stat-table-style .r-bold { border-right:1px solid #CBCBCB !important; }
	table.stat-table-style .l-bold { border-left:1px solid #CBCBCB !important; }
	table.stat-table-style .s-title { background-color:#FFFFE8; font-weight:bold; line-height:20px; }
	table.stat-table-style .m-title { font-weight:bold; line-height:20px; }
	table.stat-table-style .tit-color { background-color:#FFFFE8; }
	table.stat-table-style span.minus { color:#D33C34; }
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
			<div class="item-title">매출 통계 - 월별</div>
			<br style="line-height:10px" />
			
			<form name="search_frm">
				<div class="statistic_goods pd20">	
					<input type="hidden" name="search" value="on" />
					<div align="center">
						<label><input type="radio" name="date_type" value="month" checked /> 월별</label>
						<label><input type="radio" name="date_type" value="daily" /> 일별</label>
						<label><input type="radio" name="date_type" value="hour" /> 시간별</label>

						<select name="year">
						<option value="">= 연도 선택 =</option>
<?php if(is_array($TPL_R1=range(date('Y'), 2010))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["year"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 년</option>
<?php }}?>
						</select>

						<span class="scMonth hide">
						<select name="month">
						<option value="">= 월 선택 =</option>
<?php if(is_array($TPL_R1=range( 1, 12))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["month"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 월</option>
<?php }}?>
						</select>
						</span>
						<span class="btn medium cyanblue"><input type="submit" value="검색" /></span>
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
						<span class="icon-check hand all-check">전체</span>
					</div>
				</div>
			</form>
			<br style="line-height:10px" />

			<div id="chart1" style="margin:auto; height:250px; width:1000px;"></div>
			<br style="line-height:20px" />

			<div style="width:100%; margin:auto;">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td class="pdt5 pdb10">
							<span class="btn small orange"><button type="button" onclick="open_info_stat();">안내) 매출 통계</button></span>
						</td>
						<td align="right" valign="bottom" class="pdt5 pdb10"><span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('월별_매출','#sales_monthly_table')" /></span></td>
					</tr>
				</table>

				<!-- 매출 테이블 :: START -->
				<div id="sales_monthly_table" style="width:100%; overflow-x:scroll;">
					<table class="stat-table-style" style="margin:auto;">
					<thead>
					<tr>
						<th class="center r-bold" style="min-width:120px;" colspan="2">
							구분
						</th>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_K1=>$TPL_V1){?>
						<th class="center r-bold l-bold" style="min-width:100px;">
							<?php echo $TPL_K1+ 1?>월
						</th>
<?php }}?>
						<th class="center" <?php if(serviceLimit('H_AD')){?>style="min-width:300px;"<?php }else{?>style="min-width:150px;"<?php }?>>
							합계
						</th>
					</tr>
					<!-- 결제금액 :: START -->
					<tr>
						<td class="b-hide r-hide s-title" width="15px">&nbsp;</td>
						<td class="l-hide s-title r-bold center" width="105px">
							결제금액
							<span class="helpicon2 detailDescriptionLayerBtn" title="결제금액"></span>
							<div class="detailDescriptionLayer hide" style="display: none;">
								<div>상품 및 배송비 판매금액에서 모든 할인(이벤트, 쿠폰 등)을 공제한 금액입니다.</div>
							</div>
						</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td class="s-title r-light right">
							<?php echo get_currency_price($TPL_V1["month_p_order_price"])?>

						</td>
<?php }}?>
						<td class="s-title r-light right">
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_order_price"])?>

						</td>
					</tr>
					<tr>
						<td class="t-hide b-hide tit-color">&nbsp;</td>
						<td class="pdl10 fx11 r-bold b-hide">상품</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td class="r-light b-hide right">
							<?php echo get_currency_price($TPL_V1["p_settleprice_sum"])?>

						</td>
<?php }}?>
						<td class="r-light b-hide right">
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["p_settleprice_sum"])?>

						</td>
					</tr>
					<tr>
						<td class="t-hide tit-color">&nbsp;</td>
						<td class="pdl10 fx11 r-bold t-light">배송비</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td class="r-light t-light right">
							<span class="underhelpicon" title="
								<table>
									<tr>
										<td>배송비결제금액</td>
										<td>: </td>
										<td><?php echo get_currency_price($TPL_V1["p_shipping_cost_sum"])?></td>
									</tr>
									<tr>
										<td>상품배송비금액</td>
										<td>: </td>
										<td><?php echo get_currency_price($TPL_V1["p_goods_shipping_cost_sum"])?></td>
									</tr>
								</table>"><?php echo get_currency_price((($TPL_V1["p_shipping_cost_sum"])+($TPL_V1["p_goods_shipping_cost_sum"])))?></span>
						</td>
<?php }}?>
						<td class="r-light t-light right">
							<?php echo get_currency_price((($TPL_VAR["dataForTableSum"]["p_shipping_cost_sum"])+($TPL_VAR["dataForTableSum"]["p_goods_shipping_cost_sum"])))?>

						</td>
					</tr>
					<!-- 결제금액 :: END -->
					<!-- 환불 :: START -->
					<tr>
						<td class="b-hide r-hide" width="20px">&nbsp;</td>
						<td class="l-hide r-bold center m-title">환불</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td class="r-light right m-title">
<?php if($TPL_V1["month_p_refund_price_total_sum"]< 0){?>
							<span class="minus">
							<?php echo get_currency_price($TPL_V1["month_p_refund_price_total_sum"])?>

								</span>
<?php }else{?>
							<?php echo get_currency_price($TPL_V1["month_p_refund_price_total_sum"])?>

<?php }?>
						</td>
<?php }}?>
						<td class="r-light right m-title">
<?php if($TPL_VAR["dataForTableSum"]["month_p_refund_price_total_sum"]< 0){?>
							<span class="minus">
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_refund_price_total_sum"])?>

							</span>
<?php }else{?>
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_refund_price_total_sum"])?>

<?php }?>
						</td>
					</tr>
					<tr>
						<td class="t-hide b-hide">&nbsp;</td>
						<td class="pdl10 fx11 r-bold b-hide">취소/반품</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td class="r-light b-hide right">
<?php if($TPL_V1["month_p_refund_price_sum"]< 0){?>
							<span class="minus">
							<?php echo get_currency_price($TPL_V1["month_p_refund_price_sum"])?>

							</span>
<?php }else{?>
							<?php echo get_currency_price($TPL_V1["month_p_refund_price_sum"])?>

<?php }?>
						</td>
<?php }}?>
						<td class="r-light b-hide right">
<?php if($TPL_VAR["dataForTableSum"]["month_p_refund_price_sum"]< 0){?>
							<span class="minus">
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_refund_price_sum"])?>

							</span>
<?php }else{?>
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_refund_price_sum"])?>

<?php }?>
						</td>
					</tr>
					<tr>
						<td class="t-hide">&nbsp;</td>
						<td class="pdl10 fx11 r-bold t-light">되돌리기</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td class="r-light t-light right">
<?php if($TPL_V1["month_p_rollback_price_sum"]< 0){?>
							<span class="minus">
							<?php echo get_currency_price($TPL_V1["month_p_rollback_price_sum"])?>

							</span>
<?php }else{?>
							<?php echo get_currency_price($TPL_V1["month_p_rollback_price_sum"])?>

<?php }?>
						</td>
<?php }}?>
						<td class="r-light t-light right">
<?php if($TPL_VAR["dataForTableSum"]["month_p_rollback_price_sum"]< 0){?>
							<span class="minus">
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_rollback_price_sum"])?>

							</span>
<?php }else{?>
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_rollback_price_sum"])?>

<?php }?>
						</td>
					</tr>
					<!-- 환불 :: END -->
					<!-- 매출 :: START -->
					<tr>
						<td class="l-hide s-title r-bold center" colspan="2">매출</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td class="s-title r-light right">
							<?php echo get_currency_price($TPL_V1["month_p_sales_price"])?>

						</td>
<?php }}?>
						<td class="s-title r-light right">
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_p_sales_price"])?>

						</td>
					</tr>
					<!-- 매출 :: START -->
					<!-- 원가 :: START -->
					<tr>
						<td class="b-hide r-hide" width="20px">&nbsp;</td>
						<td class="l-hide r-bold center m-title">원가</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td class="r-light right m-title">
<?php if($TPL_V1["month_commission_total"]< 0){?>
							<span class="minus">
							<?php echo get_currency_price($TPL_V1["month_commission_total"])?>

							</span>
<?php }else{?>
							<?php echo get_currency_price($TPL_V1["month_commission_total"])?>

<?php }?>
						</td>
<?php }}?>
						<td class="r-light right m-title">
<?php if($TPL_VAR["dataForTableSum"]["month_commission_total"]< 0){?>
							<span class="minus">
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_commission_total"])?>

							</span>
<?php }else{?>
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_commission_total"])?>

<?php }?>
						</td>
					</tr>
					<tr>
						<td class="t-hide b-hide">&nbsp;</td>
						<td class="pdl10 fx11 r-bold b-hide">매입/정산</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td class="r-light b-hide right">
<?php if($TPL_V1["month_commission_price_sum"]< 0){?>
							<span class="minus">
							<?php echo get_currency_price($TPL_V1["month_commission_price_sum"])?>

							</span>
<?php }else{?>
							<?php echo get_currency_price($TPL_V1["month_commission_price_sum"])?>

<?php }?>
						</td>
<?php }}?>
						<td class="r-light b-hide right">
<?php if($TPL_VAR["dataForTableSum"]["month_commission_price_sum"]< 0){?>
							<span class="minus">
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_commission_price_sum"])?>

							</span>
<?php }else{?>
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_commission_price_sum"])?>

<?php }?>
						</td>
					</tr>
					<tr>
						<td class="t-hide b-hide">&nbsp;</td>
						<td class="pdl10 fx11 r-bold t-light b-hide">취소/반품</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td class="r-light t-light b-hide right">
							<?php echo get_currency_price($TPL_V1["month_refund_commission_price_sum"])?>

						</td>
<?php }}?>
						<td class="r-light t-light b-hide right">
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["month_refund_commission_price_sum"])?>

						</td>
					</tr>
					<tr>
						<td class="t-hide">&nbsp;</td>
						<td class="pdl10 fx11 r-bold t-light">되돌리기</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td class="r-light t-light right">
							<?php echo get_currency_price($TPL_V1["refund_rollback_commission_price_sum"])?>

						</td>
<?php }}?>
						<td class="r-light t-light right">
							<?php echo get_currency_price($TPL_VAR["dataForTableSum"]["refund_rollback_commission_price_sum"])?>

						</td>
					</tr>
					<!-- 원가 :: END -->
					<!-- 매출이익 :: START -->
					<tr>
						<td class="l-hide s-title r-bold center" colspan="2">
							매출이익<br/>[%]
						</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
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
<?php }}?>
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
					</tr>
					<!-- 매출이익 :: END -->
					</thead>
					</table>
				</div>
				<!-- 매출 테이블 :: END -->

				<!-- 할인데이터 :: START -->
				<br style="line-height:10px" />
				<div id="sales_discount_table">
				<div>
					<table width="100%" class="simpledata-table-style" style="margin:auto;">
					<tr>
						<th>구분</th>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_K1=>$TPL_V1){?>
						<th width="7%"><?php echo $TPL_K1+ 1?>월</th>
<?php }}?>
						<th width="7%">누적</th>
					</tr>
					<tr>
						<td class="pdl5 subtit center">할인</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5 subtit"><?php echo get_currency_price($TPL_V1["discount_price"])?></td>
<?php }}?>
						<td align="right" class="pdr5 subtit"><?php echo get_currency_price($TPL_VAR["dataForTableSum"]["discount_price"])?></td>
					</tr>
					<tr>
						<td align="right" class="pdr5 fx11">마일리지</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_V1["month_emoney_use_sum"]-$TPL_V1["month_refund_emoney_use_sum"]))?></td>
<?php }}?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_emoney_use_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_emoney_use_sum"]))?></td>
					</tr>
					<tr>
						<td align="right" class="pdr5 fx11">에누리</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_V1["month_enuri_sum"]-$TPL_V1["month_refund_enuri_sum"]))?></td>
<?php }}?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_enuri_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_enuri_sum"]))?></td>
					</tr>
					<tr>
						<td align="right" class="pdr5 fx11">회원등급</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_V1["month_member_sale_sum"]-$TPL_V1["month_refund_member_sale_sum"]))?></td>
<?php }}?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_member_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_member_sale_sum"]))?></td>
					</tr>
					<tr>
						<td align="right" class="pdr5 fx11">모바일</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_V1["month_mobile_sale_sum"]-$TPL_V1["month_refund_mobile_sale_sum"]))?></td>
<?php }}?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_mobile_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_mobile_sale_sum"]))?></td>
					</tr>
					<tr>
						<td align="right" class="pdr5 fx11">이벤트</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_V1["month_event_sale_sum"]-$TPL_V1["month_refund_event_sale_sum"]))?></td>
<?php }}?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_event_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_event_sale_sum"]))?></td>
					</tr>
					<tr>
						<td align="right" class="pdr5 fx11">유입경로</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_V1["month_referer_sale_sum"]-$TPL_V1["month_refund_referer_sale_sum"]))?></td>
<?php }}?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_referer_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_referer_sale_sum"]))?></td>
					</tr>
					<tr>
						<td align="right" class="pdr5 fx11">쿠폰</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_V1["month_coupon_sale_sum"]-$TPL_V1["month_refund_coupon_sale_sum"]))?></td>
<?php }}?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_coupon_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_coupon_sale_sum"]))?></td>
					</tr>
					<tr>
						<td align="right" class="pdr5 fx11">프로모션코드</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_V1["month_promotion_code_sale_sum"]-$TPL_V1["month_refund_promotion_code_sale_sum"]))?></td>
<?php }}?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_promotion_code_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_promotion_code_sale_sum"]))?></td>
					</tr>
					<tr>
						<td align="right" class="pdr5 fx11">복수구매</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_V1["month_multi_sale_sum"]-$TPL_V1["month_refund_multi_sale_sum"]))?></td>
<?php }}?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_multi_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_multi_sale_sum"]))?></td>
					</tr>
					<tr>
						<td align="right" class="pdr5 fx11">제휴사</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_V1["month_api_pg_sale_sum"]-$TPL_V1["month_refund_api_pg_sale_sum"]))?></td>
<?php }}?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_api_pg_sale_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_api_pg_sale_sum"]))?></td>
					</tr>
<?php if($TPL_VAR["npay_use"]){?>
					<tr>
						<td align="right" class="pdr5 fx11">Npay쿠폰(판매자부담)</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_V1["month_npay_sale_seller_sum"]-$TPL_V1["month_refund_npay_sale_seller_sum"]))?></td>
<?php }}?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_npay_sale_seller_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_npay_sale_seller_sum"]))?></td>
					</tr>
					<tr>
						<td align="right" class="pdr5 fx11">Npay쿠폰(네이버페이부담)</td>
<?php if($TPL_dataForTable_1){foreach($TPL_VAR["dataForTable"] as $TPL_V1){?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_V1["month_npay_sale_npay_sum"]-$TPL_V1["month_refund_npay_sale_npay_sum"]))?></td>
<?php }}?>
						<td align="right" class="pdr5"><?php echo get_currency_price(($TPL_VAR["dataForTableSum"]["month_npay_sale_npay_sum"]-$TPL_VAR["dataForTableSum"]["month_refund_npay_sale_npay_sum"]))?></td>
					</tr>
<?php }?>
					</table>
				</div>
				<!-- 할인데이터 :: END -->
			</div>
		</div>
	</div>
</div>

<div id="info_sale_stat" class="hide">
	<style type="text/css">
		.tap_area table.tb_tap td { width:236px; height:36px; border-top:1px solid #d5d5d5; border-left:1px solid #d5d5d5; border-bottom:1px solid #d5d5d5; background-color:#fff; font-size:12px; color:#828282; text-align:center; cursor:pointer; }
		.tap_area table.tb_tap td.ed { border-right:1px solid #d5d5d5; }
		.tap_area table.tb_tap td.seltd { background-color:#4665ba; font-size:12px; color:#fff; }

		.content_area { padding-top:30px; }
		.content_area .subTitle { font-size:13px; color:#4665ba; }
		.content_area .subContent { padding-top:8px; font-size:12px; color:#222222; }
		.skyblue { color:#0b94ed; }
	</style>
	<div class="tap_area">
		<table cellspacing="0" cellpadding="0" width="944px" class="tb_tap">
		<colgroup>
			<col width="236px"/>
			<col width="236px"/>
			<col width="236px"/>
			<col width="236px"/>
		</colgroup>
		<tr>
			<td class="tap seltd" tap="amount">결제금액</td>
			<td class="tap" tap="refund">환불</td>
			<td class="tap" tap="cost">원가</td>
			<td class="tap ed" tap="sales">매출액/매출이익</td>
		</tr>
		</table>
	</div>
	<div class="content_area">
		<!-- 결제금액 :: START -->
		<table id="amount_area" class="tap_content" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td>
				결제금액은 상품 및 배송비 판매금액에서 모든 할인(이벤트, 쿠폰 등)을 공제한 (+) 금액으로 실결제액과 예치금을 합한 금액입니다.<br/>
				<br/>
				예를 들어,<br/>
				<br/>
				상품판매가 10,000원<br/>
				상품쿠폰할인 2,000원<br/>
				배송비 2,500원<br/>
				예치금사용 1,000원<br/>
				<br/>
				고객의 실결제액은 <br/>
				10,000-2,000+2,500-1,000 = 9,500원<br/>
				<br/>
				결제금액 실결제액과 예치금의 합이므로<br/>
				10,500원 입니다.
			</td>
		</tr>
		</table>
		<!-- 결제금액 :: END -->

		<!-- 환불 :: START -->
		<table id="refund_area" class="tap_content hide" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td>
				환불은 상품 및 배송비 취소환불, 반품환불, 되돌리기 결제금액을 모두 합한 (-) 금액 입니다.<br/>
				<br/>
				되돌리기란 ‘결제확인’  상태의 주문서를 ‘주문접수’ 상태로 되돌릴 때 발생합니다.<br/>
			</td>
		</tr>
		</table>
		<!-- 환불 :: END -->

		<!-- 원가 :: START -->
		<table id="cost_area" class="tap_content hide" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td>
				원가는 매출로 인해 지불한 비용입니다. 본사 상품의 경우 매입가가 원가이며 입점사 상품은 입점사에 지불한 정산 금액이 원가입니다.<br/>
				또한 취소/반품 환불과 되돌리기 환불로 인해 지불해야 하는 금액이 취소된 경우 원가가 줄어드는 비용도 반영합니다.<br/>
				즉 <span class="bold">‘거래로 인한 원가’ - ‘환불(취소/반품)로 인한 원가 ‘-  ‘되돌리기(취소/반품)’로 인한 원가</span> 로 계산됩니다.
			</td>
		</tr>
		</table>
		<!-- 원가 :: END -->

		<!-- 매출/매출이익 :: START -->
		<table id="sales_area" class="tap_content hide" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td>
				매출이란, 결제금액에서 환불 을 공제한 금액입니다.<br/>
				<br/>
				매출이익이란, 매출에서 원가를 뺀 금액 입니다. 매출이익율(%)은 매출이익이 매출액에서 차지하는 비중을 백분율로 표시(소수점 둘째짜리 반올림)한 것입니다.<br/>
			</td>
		</tr>
		</table>
		<!-- 매출/매출이익 :: END -->

		<br height="40px;"/>
		<div width="100%" style="text-align:center;">
			<span class="btn gray large"><input type="button" onclick="closeDialog('info_sale_stat');" value="&nbsp;&nbsp;확인&nbsp;&nbsp;" /></span>
		</div>
	</div>
</div>

<script class="code" type="text/javascript">
	$(document).ready(function(){
		var maxValue = <?php echo $TPL_VAR["maxValue"]?>;

		var gap = parseInt(maxValue.toString().substring(0,1)) < 2 ? Math.pow(10,maxValue.toString().length-2) : Math.pow(10,maxValue.toString().length-1);
		var yaxisMax = parseInt(maxValue.toString().substring(0,1)) < 2 ? gap * (parseInt(maxValue.toString().substring(0,2))+2) : gap * (parseInt(maxValue.toString().substring(0,1))+2);
		yaxisMax = yaxisMax > 100 ? yaxisMax : 100;

		var line1 = <?php echo json_encode($TPL_VAR["dataForChart"]['매출액'])?>;
		var line2 = <?php echo json_encode($TPL_VAR["dataForChart"]['매출이익'])?>;
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
				{'label':'매출액'},
				{'label':'매출이익'}
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