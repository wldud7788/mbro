<?php /* Template_ 2.2.6 2021/12/30 16:59:57 /www/music_brother_firstmall_kr/admin/skin/default/o2o/statistic_sales/sales_o2o.html 000008903 */ 
$TPL_o2o_store_1=empty($TPL_VAR["o2o_store"])||!is_array($TPL_VAR["o2o_store"])?0:count($TPL_VAR["o2o_store"]);
$TPL_statList_1=empty($TPL_VAR["statList"])||!is_array($TPL_VAR["statList"])?0:count($TPL_VAR["statList"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		gSearchForm.init({'pageid':'sales_o2o', 'sc':<?php echo $TPL_VAR["scObj"]?>});
	})
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
<div class="contents_container">

<?php $this->print_("sales_menu",$TPL_SCP,1);?>


	<div id="search_container" class="search_container">
		<form class='search_form' >
			<table class="table_search">
				<tr>
					<th>결제 확인일</th>
					<td>
						<select name="year" class="wx80" defaultValue="<?php echo date('Y')?>">
<?php if(is_array($TPL_R1=range(date('Y'), 2010))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option>
<?php }}?>
						</select>

						<select name="month" class="wx80" defaultValue="<?php echo date('m')?>">
<?php if(is_array($TPL_R1=range( 1, 12))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php if($TPL_V1< 10){?>0<?php echo $TPL_V1?><?php }else{?><?php echo $TPL_V1?><?php }?>" <?php if($TPL_VAR["sc"]["month"]==$TPL_V1){?>selected<?php }?>><?php if($TPL_V1< 10){?>0<?php echo $TPL_V1?><?php }else{?><?php echo $TPL_V1?><?php }?></option>
<?php }}?>
						</select>
					</td>
				</tr>
				<tr>
					<th>매장</th>
					<td>
						<div class="ui-widget">
							<select name="o2o_store_seq_select" class="o2o_store_seq_select">
								<option value="" selected="selected" ></option>
<?php if($TPL_o2o_store_1){foreach($TPL_VAR["o2o_store"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["o2o_store_seq"]?>" <?php if($TPL_VAR["sc"]["o2o_store_seq"]==$TPL_V1["o2o_store_seq"]){?>selected<?php }?>><?php echo $TPL_V1["pos_name"]?>(<?php echo $TPL_V1["store_seq"]?>)</option>
<?php }}?>
							</select>
							<input type="hidden" class="o2o_store_seq" name="o2o_store_seq" value="<?php echo $TPL_VAR["sc"]["o2o_store_seq"]?>" />
						</div>
						<span class="ptc-charges hide"></span>
						<script>
							$( ".o2o_store_seq_select" )
									.combobox()
									.change(function(){
										$("input[name='o2o_store_base']").removeAttr('checked').change();
										$("input[name='o2o_store_seq']").val($(this).val());
										$("input[name='o2o_store_name']").val($("option:selected",this).text());
									});
						</script>
					</td>
				</tr>
			</table>
			<div class="search_btn_lay"></div>
		</form>
	</div>

	<!-- 서브메뉴 바디 : 시작-->
	<div class='contents_dvs'>
		<div class="title_dvs">
			<div class="item-title">매장</div>
			<button type="button" class="resp_btn" onclick="divExcelDownload('매장구매통계','#seller_goods_table')" ><img src="/admin/skin/default/images/common/btn_img_ex.gif"/><span>다운로드</span></button>
		</div>

		<!--/* 리스트 : START */-->
		<div id="seller_goods_table">
<?php if($_GET["o2o_store_seq"]){?>
			<!--/* 매장 상품 리스트 */-->
			<table class="table_basic">
				<colgroup>
					<col />
					<col width="13%" />
					<col width="13%" />
					<col width="13%" />
					<col width="10%" />
					<col width="10%" />
				</colgroup>
				<tr>
					<th>상품명</th>
					<th>판매수량</th>
					<th>판매가합계</th>
					<th>할인합계</th>
					<th colspan="2">판매가합계-할인합계</th>
				</tr>
<?php if($TPL_VAR["statList"]){?>
				<tbody class="ltb">
<?php if($TPL_statList_1){$TPL_I1=-1;foreach($TPL_VAR["statList"] as $TPL_V1){$TPL_I1++;?>
				<tr>
					<td align="center" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>>
						<?php echo $TPL_V1["goods_name"]?>

					</td>
					<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>>
						<?php echo number_format($TPL_V1["ea_sum"])?>

					</td>
					<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>>
						<?php echo get_currency_price($TPL_V1["price_sum"])?>

					</td>
					<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>>
						<?php echo get_currency_price($TPL_V1["sale_sum"])?>

					</td>
					<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?> colspan="2">
						<?php echo get_currency_price($TPL_V1["sell_price"])?>

					</td>
				</tr>
<?php }}?>
				<!--/* 총계 */-->
				<tr class="trLineTop">
					<td align="center" height="25"><b>총합</b></td>
					<td align="right"><b><?php echo number_format($TPL_VAR["totalSell"]["ea"])?></b></td>
					<td align="right"><b><?php echo get_currency_price($TPL_VAR["totalSell"]["price"])?></b></td>
					<td align="right"><b><?php echo get_currency_price($TPL_VAR["totalSell"]["sale"])?></b></td>
					<td align="right" colspan="2"><b><?php echo get_currency_price($TPL_VAR["totalSell"]["sell"])?></b></td>
				</tr>
				<tr>
					<td colspan="4" rowspan="4">&nbsp;</td>
					<td align="right">(+)배송비</td>
					<td align="right"><b><?php echo get_currency_price($TPL_VAR["totalSell"]["shipping"])?></b></td>
				</tr>
				<tr>
					<td align="right">(-)환불액</td>
					<td align="right"><b><?php echo get_currency_price($TPL_VAR["totalSell"]["refund_price"])?></b></td>
				</tr>
				<tr>
					<td align="right">
						합계
						<span class="helpicon" title="매출액합계-환불액+배송비"></span>
					</td>
					<td align="right"><b><?php echo get_currency_price($TPL_VAR["totalSell"]["total_price"])?></b></td>
				</tr>
				<tr>
					<td align="right">반품배송비</td>
					<td align="right"><b><?php echo get_currency_price($TPL_VAR["totalSell"]["return_shipping_price"])?></b></td>
				</tr>
				</tbody>
<?php }else{?>
				<tr>
					<td colspan="6" align="center" height="50px">데이터가 없습니다.</td>
				</tr>
<?php }?>
			</table>
<?php }else{?>
			<!--/* 매장별 매출 리스트 */-->
			<table class="table_basic">
				<colgroup>
					<col width="4%" />
					<col />
					<col width="13%" />
					<col width="13%" />
					<col width="13%" />

				</colgroup>
				<tr>
					<th>번호</th>
					<th>매장명</th>
					<th>상품판매수(종)</th>
					<th>상품금액합계</th>
					<th>할인합계</th>
				</tr>
<?php if($TPL_VAR["statList"]){?>
				<tbody class="ltb">
<?php if($TPL_statList_1){$TPL_I1=-1;foreach($TPL_VAR["statList"] as $TPL_V1){$TPL_I1++;?>
				<tr>
					<td align="center" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>>
						<?php echo $TPL_I1+ 1?>

					</td>
					<td align="center" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>>
						<?php echo $TPL_V1["pos_name"]?>

					</td>
					<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>>
						<?php echo number_format($TPL_V1["total_ea"])?> (<?php echo number_format($TPL_V1["goods_ea"])?>)
					</td>
					<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>>
						<?php echo get_currency_price($TPL_V1["price_sum"])?>

					</td>
					<td align="right" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>>
						<?php echo get_currency_price($TPL_V1["sale_sum"])?>

					</td>
				</tr>
<?php }}?>
				<!--/* 총계 */-->
				<tr class="trLineTop">
					<td align="center"></td>
					<td align="center"><b>총합</b></td>
					<td align="right">
						<b><?php echo number_format($TPL_VAR["totalSell"]["total_ea"])?> (<?php echo number_format($TPL_VAR["totalSell"]["goods_ea"])?>)</b>
					</td>
					<td align="right"><b><?php echo get_currency_price($TPL_VAR["totalSell"]["price_sum"])?></b></td>
					<td align="right"><b><?php echo get_currency_price($TPL_VAR["totalSell"]["sale_sum"])?></b></td>
				</tr>
				</tbody>
<?php }else{?>
				<tr>
					<td colspan="5" align="center" height="50px">데이터가 없습니다.</td>
				</tr>
<?php }?>
			</table>
<?php }?>
		</div>
		<!--/* 리스트 : END */-->
	</div>

</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>