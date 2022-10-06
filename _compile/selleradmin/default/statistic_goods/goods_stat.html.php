<?php /* Template_ 2.2.6 2022/05/17 12:29:32 /www/music_brother_firstmall_kr/selleradmin/skin/default/statistic_goods/goods_stat.html 000007204 */ 
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
table.salesgoods-table-style tr.trLineBottom td {border-bottom:2px solid #000;}
table.salesgoods-table-style tr.trLineTop th,
table.salesgoods-table-style tr.trLineTop td {border-top:2px solid #000;}
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
			<h2>상품판매통계</h2>
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
			<div class="item-title" style="margin-left:25px;">상품판매통계</div>

			<!--/* 검색 : START */-->
			<div class="search-form-container" style="padding:0px; background-color:#fff">
			<form>
				<table border="0" class="search-form-table">
				<tr>
					<td class="its-td" colspan="2" align="center">
						<input type="text" name="sdate" value="<?php echo $TPL_VAR["param"]["sdate"]?>" size="10" class="line datepicker" /> ~
						<input type="text" name="edate" value="<?php echo $TPL_VAR["param"]["edate"]?>" size="10" class="line datepicker" />

						<span class="btn small"><input type="submit" value="검색" /></span>
						<span class="helpicon" title="입금완료일 기준입니다"></span>
					</td>
				</tr>
				<tr>
					<th class="its-th" height="30px">판매환경 :</th>
					<td class="its-td">
<?php if($TPL_sitetypeloop_1){foreach($TPL_VAR["sitetypeloop"] as $TPL_K1=>$TPL_V1){?>
<?php if(in_array($TPL_K1,$TPL_VAR["sitetype"])){?>
						<label class="search_label pdr5"><input type="checkbox" name="sitetype[]" value="<?php echo $TPL_K1?>" checked="checked" /> <?php echo $TPL_V1["name"]?></label>
<?php }else{?>
						<label class="search_label pdr5"><input type="checkbox" name="sitetype[]" value="<?php echo $TPL_K1?>" /> <?php echo $TPL_V1["name"]?></label>
<?php }?>
<?php }}?>
						<span class="icon-check hand all-check"><b class="">전체</b></span>
					</td>
				</tr>
				</table>
			</form>
			<br/>
			</div>
			<!--/* 검색 : END */-->

			<!--/* 리스트 : START */-->
			<div id="seller_goods_table">
				<table width="100%" class="salesgoods-table-style" style="margin:auto;" border="0" cellpadding="0" cellspacing="0">
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
					<th>판매가합계</th>
					<th>할인합계</th>
					<th colspan="2">판매가합계-할인합계</th>
				</tr>
<?php if($TPL_VAR["statList"]){?>
				<tbody class="ltb">
<?php if($TPL_statList_1){foreach($TPL_VAR["statList"] as $TPL_V1){?>
				<tr>
					<td align="center"><?php echo $TPL_V1["goods_name"]?></td>
					<td align="right"><?php echo number_format($TPL_V1["ea_sum"])?></td>
					<td align="right"><?php echo get_currency_price($TPL_V1["price_sum"])?></td>
					<td align="right"><?php echo get_currency_price($TPL_V1["sale_sum"])?></td>
					<td align="right" colspan="2"><?php echo get_currency_price($TPL_V1["sell_price"])?></td>
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
<?php }else{?>
				<tr>
					<td colspan="6" align="center" height="50px">데이터가 없습니다.</td>
				</tr>
<?php }?>
				</tbody>
				</table>
			</div>
			<!--/* 리스트 : START */-->
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