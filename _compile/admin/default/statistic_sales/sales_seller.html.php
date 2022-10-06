<?php /* Template_ 2.2.6 2022/05/17 12:37:15 /www/music_brother_firstmall_kr/admin/skin/default/statistic_sales/sales_seller.html 000013496 */ 
$TPL_year_1=empty($TPL_VAR["year"])||!is_array($TPL_VAR["year"])?0:count($TPL_VAR["year"]);
$TPL_month_1=empty($TPL_VAR["month"])||!is_array($TPL_VAR["month"])?0:count($TPL_VAR["month"]);
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);
$TPL_sitetypeloop_1=empty($TPL_VAR["sitetypeloop"])||!is_array($TPL_VAR["sitetypeloop"])?0:count($TPL_VAR["sitetypeloop"]);
$TPL_statList_1=empty($TPL_VAR["statList"])||!is_array($TPL_VAR["statList"])?0:count($TPL_VAR["statList"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<style>
	/* 간단 데이터 테이블 스타일 */
	table.salesgoods-table-style {border-collapse:collapse;}
	table.salesgoods-table-style th {background-color:#f3f3f3; min-height:24px; line-height:24px; border:1px solid #c8c8c8; color:#666; font-weight:normal;}
	table.salesgoods-table-style td {padding:5px 5px; border:1px solid #d7d7d7; color:#666}
	table.salesgoods-table-style th.tdLineRight,
	table.salesgoods-table-style td.tdLineRight {border-right:2px solid #000;}
	table.salesgoods-table-style tr.trLineBottom th,
	table.salesgoods-table-style tr.trLineBottom td {border-bottom:0px solid #000;}
	table.salesgoods-table-style tr.trLineTop th,
	table.salesgoods-table-style tr.trLineTop td {border-top:0px solid #000;}
	.linecolor { background-color:#fff ; }
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$(".all-check").toggle(function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',true);
		},function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',false);
		});
	});

	function reset_search(){
		$("input[name='provider_seq']").val('');
		$("input[name='provider_name']").val('');
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
			<div class="item-title">판매 통계 - 입점사</div>
			<br style="line-height:10px" />

			<!--/* 검색 : START */-->
			<div class="statistic_goods">
				<div class="search-form-container">
				<form>
					<table border="0" class="search-form-table">
						<tr>
							<td class="its-td pdb10" colspan="2" align="center">
								<style>
									.ui-combobox {
										position: relative;
										display: inline-block;
									}
									.ui-combobox-toggle {
										position: absolute;
										top: 0;
										bottom: 0;
										margin-left: -1px;
										padding: 0;
										/* adjust styles for IE 6/7 */
										*height: 1.7em;
										*top: 0.1em;
									}
									.ui-combobox-input {
										margin: 0;
										padding: 0.3em;
									}
									.ui-autocomplete {
										max-height: 200px;
										overflow-y: auto;
										/* prevent horizontal scrollbar */
										overflow-x: hidden;
									}
								</style>
								<select name="s_year" class="ui-widget"   style="width:100px; height:24px !important;">
<?php if($TPL_year_1){foreach($TPL_VAR["year"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1?>" <?php if($_GET["s_year"]==$TPL_V1){?> selected="selected" <?php }?> ><?php echo $TPL_V1?></option>
<?php }}?>
								</select>
								<select name="s_month" class="ui-widget"   style="width:100px; height:24px !important;">
<?php if($TPL_month_1){foreach($TPL_VAR["month"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1?>" <?php if($_GET["s_month"]==$TPL_V1){?> selected="selected" <?php }?> ><?php echo $TPL_V1?></option>
<?php }}?>
								</select>
								<!--
								<input type="text" name="sdate" value="<?php echo $TPL_VAR["param"]["sdate"]?>" size="10" class="line datepicker" /> ~
								<input type="text" name="edate" value="<?php echo $TPL_VAR["param"]["edate"]?>" size="10" class="line datepicker" />&nbsp;
								-->
								<span class="btn medium cyanblue"><input type="submit" value="검색" /></span>
								<span class="helpicon" title="입금완료일 기준입니다"></span>
							</td>
						</tr>
						<tr>
							<th class="its-th left pdr10" height="30px">입점사</th>
							<td class="its-td">
								<div class="ui-widget">
									<select name="provider_seq_select" class="provider_seq_select" style="vertical-align:bottom;">
									<option value="" selected="selected" ></option>
									<option value="1" >본사</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1["provider_seq"]?>"><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }}?>
									</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $_GET["provider_seq"]?>" />
									<input type="text" name="provider_name" value="<?php echo $_GET["provider_name"]?>" readonly style="vertical-align:bottom;" />
									<span class="btn small"><input type="button" value="초기화" onclick="reset_search();" /></span>
								</div>
								<span class="ptc-charges hide"></span>
								<script>
									$( ".provider_seq_select" )
									.combobox()
									.change(function(){
										$("input[name='provider_base']").removeAttr('checked').change();
										$("input[name='provider_seq']").val($(this).val());
										$("input[name='provider_name']").val($("option:selected",this).text());
									});
								</script>
							</td>
						</tr>
						<!-- 판매환경 기능 제거 by hed 2019-06-19 #34379 -->
						<tr class="hide">
							<th class="its-th left pdr10">판매환경</th>
							<td class="its-td">
<?php if($TPL_sitetypeloop_1){foreach($TPL_VAR["sitetypeloop"] as $TPL_K1=>$TPL_V1){?>
<?php if(in_array($TPL_K1,$TPL_VAR["sitetype"])){?>
								<label class="search_label"><input type="checkbox" name="sitetype[]" value="<?php echo $TPL_K1?>" checked="checked" /> <?php echo $TPL_V1["name"]?></label>
<?php }else{?>
								<label class="search_label"><input type="checkbox" name="sitetype[]" value="<?php echo $TPL_K1?>" /> <?php echo $TPL_V1["name"]?></label>
<?php }?>
<?php }}?>
								<span class="icon-check hand all-check"><b class="">전체</b></span>
							</td>
						</tr>
					</table>
				</form>
				</div>
			</div>
			<!--/* 검색 : END */-->

			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="right" valign="bottom" class="pdt5 pdb10">
						<span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('입점사판매통계','#seller_goods_table')" /></span>
					</td>
				</tr>
			</table>			

			<!--/* 리스트 : START */-->
			<div id="seller_goods_table">
<?php if($_GET["provider_seq"]){?>
				<!--/* 입점사 상품 리스트 */-->
				<table width="100%" class="simpledata-table-style" style="margin:auto;" border="0" cellpadding="0" cellspacing="0">
				<colgroup>
					<col width="19%" />
					<col width="19%" />
					<col width="19%" />
					<col width="19%" />
					<col width="12%" />
					<col width="12%" />
				</colgroup>
				<tr>
					<th>상품명</th>
					<th>판매수량</th>
					<th>판매금액</th>
					<th>할인</th>
					<th colspan="2">결제금액</th>
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
					<td colspan="5" align="center" height="50px">데이터가 없습니다.</td>
				</tr>
<?php }?>
				</table>
<?php }else{?>
				<!--/* 입점사별 매출 리스트 */-->
				<table width="100%" class="simpledata-table-style" style="margin:auto;" border="0" cellpadding="0" cellspacing="0">
				<colgroup>
					<col width="4%" />
					<col width="17%" />
					<col width="13%" />
					<col width="13%" />
					<col width="13%" />
					<col width="13%" />
					<col width="13%" />
					<col width="13%" />
				</colgroup>
				<tr>
					<th>번호</th>
					<th>입점사명</th>
					<th>판매수량(종)</th>
					<th>판매금액</th>
					<th>할인</th>
				</tr>
<?php if($TPL_VAR["statList"]){?>
				<tbody class="ltb">
<?php if($TPL_statList_1){$TPL_I1=-1;foreach($TPL_VAR["statList"] as $TPL_V1){$TPL_I1++;?>
				<tr>
					<td align="center" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>>
						<?php echo $TPL_I1+ 1?>

					</td>
					<td align="center" <?php if($TPL_I1% 2== 1){?>class="linecolor"<?php }?>>
						<?php echo $TPL_V1["provider_name"]?>

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
					<td colspan="7" align="center" height="50px">데이터가 없습니다.</td>
				</tr>
<?php }?>
				</table>
<?php }?>
			</div>
			<!--/* 리스트 : END */-->
		</div>
	</div>
</div>
<div id="loadexcel_Popup" style="text-align:center;" class="hide">
	<div style="margin-top:10px; margin-bottom:15px;">
		현재 화면에 노출되는 데이터만 엑셀 문서로 제공됩니다.<br/>
		화면 아래 '더보기' 버튼을 통해 데이터를 모두 확인하신 후<br/>
		엑셀 파일 다운로드를 권장합니다.
	</div>
	<span class="btn large gray"><input type="button" value="엑셀파일 다운로드" onclick="divExcelDownload('판매수단별_매출','#seller_goods_table');" /></span>
	&nbsp;
	<span class="btn large gray"><input type="button" value="닫기" onclick="closeDialog('loadexcel_Popup');" /></span>
</div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>