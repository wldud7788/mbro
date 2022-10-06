<?php /* Template_ 2.2.6 2022/05/17 12:37:14 /www/music_brother_firstmall_kr/admin/skin/default/statistic_sales/goods_daily.html 000014435 */ 
$TPL_statsData_1=empty($TPL_VAR["statsData"])||!is_array($TPL_VAR["statsData"])?0:count($TPL_VAR["statsData"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<style>
	/* 간단 데이터 테이블 스타일 */
	table.salesgoods-table-style {border-collapse:collapse;}
	table.salesgoods-table-style th {background-color:#f3f3f3; min-height:24px; line-height:24px; border:1px solid #c8c8c8; color:#666; font-weight:normal;}
	table.salesgoods-table-style td {padding:5px 5px; border:1px solid #d7d7d7; color:#666}
	table.salesgoods-table-style th.tdLineRight,
	table.salesgoods-table-style td.tdLineRight {border-right:1px solid #a6a6a6;}
	table.salesgoods-table-style tr.trLineBottom th,
	table.salesgoods-table-style tr.trLineBottom td {border-bottom:1px solid #a6a6a6;}
	table.salesgoods-table-style tr.trLineTop th,
	table.salesgoods-table-style tr.trLineTop td {border-top:1px solid #a6a6a6;}
	table.salesgoods-table-style tr.trBottomInfo td {font-weight:bold;font-size:13px;}
	.linecolor { background-color:#FFFFE8 !important; }
</style>
<script>
	
	/* 더보기 페이징 :: 2014-08-05 lwh */
	/* variable for ajax list */
	var npage		= 1;
	var nnum		= 300;
	var stepArr		= new Array();
	var allOpenStep	= new Array();
	var totalCnt	= '<?php echo $TPL_VAR["listCnt"]?>';
	var loading_status	= 'n';

	function get_daily_stat_ajax(){
		if	(loading_status == 'n'){
			loading_status	= 'y';
			npage++;

			var queryString			= '<?php echo $_SERVER["QUERY_STRING"]?>';

			$("#ajaxLoadingLayer").ajaxStart(function() { loadingStop(this); });
			$.ajax({
				'url'		: './goods_daily_pagin',
				'data'		: {'npage':npage,'nnum':nnum,'queryString':queryString},
				'type'		: 'post',
				'dataType'	: 'html',
				'success'	: function(result) {
					if(result){
						$(".stats-ajax-list").append(result);
						loading_status = 'n';
						var nowRows	= npage * nnum;
						var txtmore = '300개 더보기';
						if(nowRows > totalCnt){
							nowRows = totalCnt;
							$(".renewal").hide();
						}else if((nowRows + 300) > totalCnt){
							txtmore = (totalCnt - nowRows) + '개 더보기';
						}

						if(nowRows == totalCnt)	loading_status = 'e';

						$("#more_view").val(txtmore+' (' + nowRows + ' / ' + totalCnt + ')');
					}else{
						loading_status = 'e';
					}
				}
			});


			$("#ajaxLoadingLayer").ajaxStart(function() { loadingStart(this); });
		}
	}
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
			<div class="item-title">판매 통계 - 상품</div>
			<br style="line-height:10px" />
			
			<form>

<?php $this->print_("goods_search",$TPL_SCP,1);?>


				<br style="line-height:10px" />

				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="right" valign="bottom" class="pdt5 pdb10">
							<select name="sort" onchange="$(this.form).submit();">
							<option value="deposit_date desc">최근매출일↑</option>
							<option value="ea desc">판매수량↑</option>
							<option value="ea asc">판매수량↓</option>						
							<option value="goods_price desc">매출합계↑</option>
							<option value="goods_price asc">매출합계↓</option>
							</select>
							<span class="btn small"><input type="button" value="엑셀다운로드" onclick="DirectExcelDownload('판매통계상품일별','sales_goods_day_table', '<?php echo $_SERVER["QUERY_STRING"]?>');" /></span>
							<script>
<?php if($_GET["sort"]){?>
							$("select[name='sort']").val('<?php echo $_GET["sort"]?>');
<?php }?>
							</script>
						</td>
					</tr>
				</table>
			</form>

			<div id="sales_goods_table">
				<table width="100%" class="salesgoods-table-style" style="margin:auto;" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th rowspan="2" width="30">번호</th>
						<th rowspan="2" width="90">매출일</th>
						<th rowspan="2" colspan="2">판매상품</th>
						<th rowspan="2" width="80">매입가</th>
						<th rowspan="2" width="80">정가</th>
						<th rowspan="2">판매가</th>
						<th rowspan="2">수량</th>
						<th rowspan="2" class="tdLineRight"><b>판매금액</b></th>
						<th colspan="8">할인</th>
					</tr>
					<tr>
						<th>이벤트</th>
						<th>복수구매</th>
						<th>쿠폰</th>
						<th>등급</th>
						<th>모바일</th>
						<th>코드</th>
						<th>유입</th>
					</tr>
<?php if($TPL_VAR["statsData"]){?>
					<tbody class="ltb stats-ajax-list">
<?php if($TPL_statsData_1){$TPL_I1=-1;foreach($TPL_VAR["statsData"] as $TPL_V1){$TPL_I1++;?>
					<tr>
						<td align="center" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo number_format($TPL_I1+ 1)?></td>
						<td align="center" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo date('Y-m-d',strtotime($TPL_V1["deposit_date"]))?></td>
						<td width="180" align="left" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>>
<?php if($TPL_V1["order_type"]=='shipping'){?>
								배송비
<?php }else{?>
<?php if(serviceLimit('H_AD')){?> 
								<div class="desc">[<?php echo $TPL_V1["provider_name"]?>]</div>
<?php }?>
								<?php echo $TPL_V1["order_goods_name"]?>

<?php }?>
						</td>
						<td width="60" class="desc <?php if($TPL_I1% 2== 1){?>linecolor<?php }?>" align="left">
<?php if($TPL_V1["title1"]){?><?php echo $TPL_V1["title1"]?> : <?php echo $TPL_V1["option1"]?><br /><?php }?>
<?php if($TPL_V1["title2"]){?><?php echo $TPL_V1["title2"]?> : <?php echo $TPL_V1["option2"]?><br /><?php }?>
<?php if($TPL_V1["title3"]){?><?php echo $TPL_V1["title3"]?> : <?php echo $TPL_V1["option3"]?><br /><?php }?>
<?php if($TPL_V1["title4"]){?><?php echo $TPL_V1["title4"]?> : <?php echo $TPL_V1["option4"]?><br /><?php }?>
<?php if($TPL_V1["title5"]){?><?php echo $TPL_V1["title5"]?> : <?php echo $TPL_V1["option5"]?><br /><?php }?>
						</td>
						<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo number_format($TPL_V1["supply_price"])?></td>
						<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo number_format($TPL_V1["consumer_price"])?></td>
						<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo number_format($TPL_V1["price"])?></td>
						<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo number_format($TPL_V1["ea"])?></td>
						<td align="right" class="tdLineRight <?php if($TPL_I1% 2== 1){?>linecolor<?php }?>"><b><?php echo number_format($TPL_V1["goods_price"])?></b></td>
						<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo number_format($TPL_V1["event_sale_unit"]*$TPL_V1["ea"])?></td>
						<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo number_format($TPL_V1["multi_sale_unit"]*$TPL_V1["ea"])?></td>
						<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo number_format($TPL_V1["coupon_sale_unit"])?></td>
						<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo number_format($TPL_V1["member_sale_unit"])?></td>
						<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo number_format($TPL_V1["mobile_sale_unit"])?></td>
						<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo number_format($TPL_V1["code_sale_unit"])?></td>
						<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>><?php echo number_format($TPL_V1["referer_sale_unit"])?></td>
					</tr>
<?php }}?>
					</tbody>
<?php }else{?>
					<tr>
						<td colspan="9" align="center" class="tdLineRight">데이터가 없습니다.</td>
						<td align="right"></td>
						<td align="right"></td>
						<td align="right"></td>
						<td align="right"></td>
						<td align="right"></td>
						<td align="right"></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["listCnt"]> 300){?>
				</table>
				<div style="text-align:center; height:50px; margin:5px;">
					<span class="btn large hide renewal"><input type="button" value="<?php if($TPL_VAR["listCnt"]< 600){?><?php echo ($TPL_VAR["listCnt"]- 300)?><?php }else{?>300<?php }?>개 더보기 (총 <?php echo $TPL_VAR["listCnt"]?>개)" id="more_view" onclick="get_daily_stat_ajax();" /></span>
				</div>
				<!-- 정산 및 소계 -->
				<table width="100%" class="salesgoods-table-style" style="margin:auto;" border="0" cellpadding="0" cellspacing="0">
<?php }?>
					<tr class="trLineBottom">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td align="right">소계①</td>
						<td align="right" class="tdLineRight"><b><?php echo number_format($TPL_VAR["statsDataSum"]["goods_price"])?></b></td>
						<td width="50px" align="right"><b><?php echo number_format($TPL_VAR["statsDataSum"]["event_sale"])?></b></td>
						<td width="50px" align="right"><b><?php echo number_format($TPL_VAR["statsDataSum"]["multi_sale"])?></b></td>
						<td width="50px" align="right"><b><?php echo number_format($TPL_VAR["statsDataSum"]["coupon_sale"])?></b></td>
						<td width="50px"  align="right"><b><?php echo number_format($TPL_VAR["statsDataSum"]["member_sale"])?></b></td>
						<td  width="50px" align="right"><b><?php echo number_format($TPL_VAR["statsDataSum"]["mobile_sale"])?></b></td>
						<td  width="50px" align="right"><b><?php echo number_format($TPL_VAR["statsDataSum"]["promotion_code_sale"])?></b></td>
						<td  width="50px" align="right"><b><?php echo number_format($TPL_VAR["statsDataSum"]["referer_sale"])?></b></td>
					</tr>
<?php if($TPL_VAR["search_mode"]=='order'){?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td colspan="2" align="right">(+)기본배송비</td>
						<td align="right" class="tdLineRight"><b><?php echo number_format($TPL_VAR["orderData"]["shipping_cost_sum"])?></b></td>
						<td colspan="8" rowspan="11"></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td colspan="2" align="right">(+)반품배송비</td>
						<td align="right" class="tdLineRight"><b><?php echo number_format($TPL_VAR["orderData"]["return_shipping_cost_sum"])?></b></td>
					</tr>

					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td colspan="2" align="right">(-)배송비쿠폰</td>
						<td align="right" class="tdLineRight"><b><?php echo number_format($TPL_VAR["orderData"]["shipping_coupon_sale_sum"])?></b></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td colspan="2" align="right">(-)배송비코드</td>
						<td align="right" class="tdLineRight"><b><?php echo number_format($TPL_VAR["orderData"]["shipping_promotion_code_sale_sum"])?></b></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td colspan="2" align="right">(-)마일리지사용</td>
						<td align="right" class="tdLineRight"><b><?php echo number_format($TPL_VAR["orderData"]["emoney_use_sum"])?></b></td>
					</tr>					
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td colspan="2" align="right">(-)에누리</td>
						<td align="right" class="tdLineRight"><b><?php echo number_format($TPL_VAR["orderData"]["enuri_sum"])?></b></td>
					</tr>
					<tr class="trLineTop">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td colspan="2" align="right">(-)환불 금액</td>
						<td align="right" class="tdLineRight"><b><?php echo number_format($TPL_VAR["refundData"]["refund_price_sum"])?></b></td>
					</tr>
					<tr class="trLineTop">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td colspan="2" align="right">(+)환불 할인액</td>
						<td align="right" class="tdLineRight"><b><?php echo number_format($TPL_VAR["refundData"]["refund_sale_price_sum"])?></b></td>
					</tr>
					<tr class="trLineTop">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td colspan="2" align="right">소계②</td>
						<td align="right" class="tdLineRight"><b><?php echo $TPL_VAR["orderData"]["sub_price_sum_txt"]?></b></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td colspan="2" align="right">(외)예치금사용</td>
						<td align="right" class="tdLineRight"><b><?php echo number_format($TPL_VAR["orderData"]["cash_use_sum"])?></b></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td colspan="2" align="right">(외)환불 : 예치금</td>
						<td align="right" class="tdLineRight"><b><?php echo number_format($TPL_VAR["refundData"]["refund_cash_sum"])?></b></td>
					</tr>
					
					<tr class="trBottomInfo">
						<td colspan="17" align="center"> <?php echo $TPL_VAR["orderData"]["sales_sum_txt"]?> = <?php echo number_format($TPL_VAR["orderData"]["sales_sum"])?> (매출액)</td>
					</tr>
<?php }?>
			</table>
		</div>
	</div>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>