<?php /* Template_ 2.2.6 2022/05/17 12:29:16 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_batch_modify_multidiscount.html 000017673 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
$(document).ready(function() {

	//대량구매 설정 ↓
	$('#multiDiscountSet').on("click", function() {openDialog("대량구매", "multiDiscountDialog", {"width":"500","show" : "fade","hide" : "fade"});});

	$('select[name="multi_discount_unit"]').on('change', function(){

		var unitText	= $('select[name="multi_discount_unit"] option:selected').text();

		if (unitText == '%')
			$('.discount_unit').text(unitText);
		else
			$('.discount_unit').text(unitText + ' / 1개');
	});

	$('#multiDiscountTable').on("blur", 'input[name="discount_over_qty[]"]:eq(0)', function(){
		var nowOver		= parseInt(this.value, 10);
		var nowUnder	= parseInt($('input[name="discount_under_qty[]"]').eq(0).val(),10);

		if (isNaN(nowOver) || nowOver < 2) {
			alert('시작 수량이 2 보다작습니다.');
			this.value	= 2;
		}

		if (nowOver >= nowUnder) {
			alert('미만 수량이 ' + nowOver + '보다 같거나 작습니다.');
			$('input[name="discount_under_qty[]"]').eq(0).val(nowOver + 1);
			$('input[name="discount_under_qty[]"]').eq(0).trigger('blur');
		}
	});

	$('#multiDiscountTable').on("blur", 'input[name="discount_under_qty[]"]', function(){
		var nowIndex	= $('input[name="discount_under_qty[]"]').index(this);
		var nowOver		= parseInt($('input[name="discount_over_qty[]"]').eq(nowIndex).val(),10);
		var nowUnder	= parseInt(this.value, 10);

		if (nowIndex == 0 && (isNaN(nowOver) || nowOver < 2)) {
			nowOver		= 2;
			$('input[name="discount_over_qty[]"]').eq(0).val(2);
		}

		if (nowOver >= nowUnder) {
			alert('미만 수량이 ' + nowOver + '보다 같거나 작습니다.');
			$('input[name="discount_under_qty[]"]').eq(nowIndex).val(nowOver + 1);
		}

		changeDiscountSet(nowIndex + 1)
	});


	$('.addDiscountSet').on("click", function(){

		var unitText	= $('select[name="multi_discount_unit"] option:selected').text();
		unitText		= (unitText == '%') ? unitText : unitText + ' / 1개';

		var baseTr	 = '<tr>';
		baseTr		+= '<td class="its-td-align pd10 center"><span class="btn-minus"><button type="button" class="delDiscountSet"></button></span></td>';
		baseTr		+= '<td class="its-td-align pd10">';
		baseTr		+= '<input type="text" name="discount_over_qty[]" value="0" class="line onlynumber" size="4" maxlength="5"/> 개 이상';
		baseTr		+= '<span class="discount_under_qty">';
		baseTr		+= ' <input type="text" name="discount_under_qty[]" value="0" class="line onlynumber" size="4" maxlength="5"/> 개 미만';
		baseTr		+= '</span>';
		baseTr		+= '</td>';
		baseTr		+= '<td class="its-td-align pd10">';
		baseTr		+= '<input type="text" name="discount_amount[]" value="0" class="line onlynumber" size="7" maxlength="10"/>';
		baseTr		+= '<span class="discount_unit">' + unitText + '</span>';
		baseTr		+= '</td>';
		baseTr		+= '</tr>';

		var lastOver	= parseInt($('input[name="discount_over_qty[]"]:last').val(),10);
		var lastUnder	= parseInt($('input[name="discount_under_qty[]"]:last').val(),10);
		var totalSetCnt	= $("#multiDiscountTable tbody tr").length;

		lastOver		= (isNaN(lastOver)) ? 0 : lastOver;
		lastUnder		= (isNaN(lastUnder)) ? 0 : lastUnder;

		if (lastOver >= lastUnder && totalSetCnt > 0) {
			alert('수량을 확인해주세요');
			return;
		}
		if (totalSetCnt == 0) {
			var targetElement	= $(baseTr);
			var lastUnder		= 2;
			$('.max_qty_set').show();
		} else {
			var targetElement	= $("#multiDiscountTable tbody tr:last").clone();
		}

		if (totalSetCnt == 1) {
			$("#multiDiscountTable tbody tr:first").find('.btn-minus').hide();
			$(targetElement).find('.btn-minus').show();
			$(targetElement).find('input[name="discount_over_qty[]"]').attr('readonly', true).addClass('readonly-color');
		}

		targetElement.find('input[name="discount_over_qty[]"').val(lastUnder);
		targetElement.find('input[name="discount_under_qty[]"').val(lastUnder + 1);
		targetElement.find('input[name="discount_amount[]"').val(0);

		$("#multiDiscountTable tbody").append(targetElement);
		$('input[name="discount_under_qty[]"]:last').trigger('change');
		checkDiscountSet();
	});

	$('#multiDiscountTable').on("change", "input[name='discount_under_qty[]']:last", function(){$('input[name="discount_max_over_qty"]').val(this.value);});

	$('#multiDiscountTable').on("click", ".delDiscountSet", function(){
		var targetTr	= $(this).parents('tr');
		var trIndex		= $('.delDiscountSet').index(this) + 1;

		targetTr.remove();

		var totalSetCnt	= $("#multiDiscountTable tbody tr").length;
		if (totalSetCnt == 0)
			$('.max_qty_set').hide();
		else if (totalSetCnt == 1)
			$("#multiDiscountTable tbody tr:first").find('.btn-minus').show();


		changeDiscountSet(trIndex - 1);
		checkDiscountSet();
	});

	// "대량구매" 라인추가
	$('#applyMultiDiscountBtn').on('click', function() {
		var trEm = $('.row-multi-discount').first(), rowspan = 1;
		var toHTML1 = '', toHTML2 = '';

		var discountSetCnt	= $('input[name="discount_over_qty[]"]').length;
		var discountBtn		= '<th class="its-th-align center">대량 구매</th><th class="its-th-align left cyanblue" style="border-left:0"><span class="btn small gray"><button id="multiDiscountSet" type="button">설정</button></span></th>';
		var unitText		= $('select[name="multi_discount_unit"] option:selected').text();
		var unitValue		= $('select[name="multi_discount_unit"]').val();

		unitText			= (unitText == '%') ? unitText : unitText + ' / 1개';

		// row-remove
		$('.info-table-style .row-multi-discount').not(':first').remove();

		if (discountSetCnt == 0) {
			$('td:eq(0)', trEm).html('<span class="gray">미설정</span>');
			$('td:eq(1)', trEm).html('');
			// set-rowspan
			rowspan = $('.info-table-style .row-multi-discount').length;
			$('th:eq(0), th:eq(1)', trEm).attr('rowspan', rowspan);

			closeDialog("multiDiscountDialog");
			return true;
		}

		var multiDiscountList	= [];
		var discountSet			= {};

		for (i = 0; i < discountSetCnt; i++) {

			overCnt		= parseInt($('input[name="discount_over_qty[]"]').eq(i).val(),10);
			underCnt	= parseInt($('input[name="discount_under_qty[]"]').eq(i).val(),10);
			amount		= parseInt($('input[name="discount_amount[]"]').eq(i).val(),10);

			overCnt		= (isNaN(overCnt)) ? 0 : overCnt;
			underCnt	= (isNaN(underCnt)) ? 0 : underCnt;
			amount		= (isNaN(amount)) ? 0 : amount;
			rowCnt		= i + 1;


			if (overCnt >= underCnt) {
				alert(rowCnt + '번째 상품수량을 확인해주세요');
				return false;
			}


			discountSet				= {};
			discountSet.overCnt		= overCnt;
			discountSet.underCnt	= underCnt;
			discountSet.amount		= amount;

			multiDiscountList.push(discountSet);
		}

		for (i = 0; i < discountSetCnt; i++) {
			row		= multiDiscountList[i];
			toHTML1 = ''
			+'<div style="margin:5px 0;">'
			+row.overCnt + '개 이상'
			+ '<input type="hidden" name="discountOverQty[]" value="' + row.overCnt + '"/>';
			if(discountSetCnt > 1){
				toHTML1 += ' ~ ' + row.underCnt + '개 미만' + '<input type="hidden" name="discountUnderQty[]" value="' + row.underCnt + '"/>';
			}
			toHTML1 += '</div>';
			toHTML2 = ''
			+row.amount + ' ' + unitText
			+'<input type="hidden" name="discountAmount[]" value="' + row.amount + '"/>';
			if(i==0) {
				$('td:eq(0)', trEm).html(toHTML1);
				$('td:eq(1)', trEm).html(toHTML2);
			} else if( discountSetCnt > 1){
				$('tr.row-multi-discount').last().after('<tr class="row-multi-discount"><td class="its-td">'+toHTML1+'</td><td class="its-td">'+toHTML2+'</td></tr>');
			}
		}

		var maxOverQty	= parseInt($('input[name="discount_max_over_qty"]').val(), 10);
		var maxAmount	= parseInt($('input[name="discount_max_amount"]').val(), 10);

		maxOverQty	= (isNaN(maxOverQty)) ? 0 : maxOverQty;
		maxAmount		= (isNaN(maxAmount)) ? 0 : maxAmount;


		toHTML1 = ''
		+'<div style="margin:5px 0;">'+maxOverQty + '개 이상'+'</div>'
		+'<input type="hidden" name="discountMaxOverQty" value="' + maxOverQty + '"/>';

		toHTML2 = ''
		+maxAmount + ' ' + unitText
		+'<input type="hidden" name="discountMaxAmount" value="' + maxAmount + '"/>'
		+'<input type="hidden" name="discountUnit" value="' + unitValue + '"/>';

		if( discountSetCnt > 1) $('tr.row-multi-discount').last().after('<tr class="row-multi-discount"><td class="its-td discount_qty_td">'+toHTML1+'</td><td class="its-td discount_amount_td">'+toHTML2+'</td></tr>');


		// set-rowspan
		rowspan = $('.info-table-style .row-multi-discount').length;
		$('th:eq(0), th:eq(1)', trEm).attr('rowspan', rowspan);

		closeDialog("multiDiscountDialog");
	});

});

function changeDiscountSet(nowIndex) {

	var totalSetCnt	= $('input[name="discount_under_qty[]"]').length;

	for (i = nowIndex; i < totalSetCnt; i++) {
		lastUnder	= parseInt($('input[name="discount_under_qty[]"]').eq(i - 1).val(),10);
		nowUnder	= parseInt($('input[name="discount_under_qty[]"]').eq(i).val(),10);

		$('input[name="discount_over_qty[]"]').eq(i).val(lastUnder);

		if (nowUnder <= lastUnder) {
			$('input[name="discount_under_qty[]"]').eq(i).val(lastUnder + 1);
		}
	}

	$('input[name="discount_under_qty[]"]:last').trigger('change');
}

function checkDiscountSet()
{
	var totalSetCnt	= $("#multiDiscountTable tbody tr").length;
	if(totalSetCnt<=1){
		$('.max_qty_set').hide();
		$("#multiDiscountTable tbody tr td span.discount_under_qty").hide();
	}else{
		$("#multiDiscountTable tbody tr td span.discount_under_qty").show();
		$('.max_qty_set').show();
	}
}
</script>

<br class="table-gap" />
<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="15%" /><!--대상 상품-->
		<col /><!--아래와 같이 업데이트-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th>대상 상품</th>
		<th>아래와 같이 업데이트</th>
	</tr>
	<tbody class="ltb ">
	<tr  style="height:70px;">
		<td class="list-row" align="center" rowspan="10">
		검색된 상품에서  →
		<select name="modify_list"  class="line">
			<option value="choice">선택 </option>
			<option value="all">전체 </option>
		</select>
		</td>
		<td class="list-row">
			<div class="mt5 ml10">
				<span>대량구매 혜택을 ↓아래의 내용으로 변경 합니다.</span>
				<span class="btn medium"><button type="button" id="multiDiscountSet">설정</button></span>
			</div>

			<div class="hide mt10 ml10" id='multiDiscountView'>[대량구매 혜택]</div>
			<table class="list-table-style" style="width:300px;">
				<colgroup>
					<col width="60%" />
					<col width="40%" />
					<col />
				</colgroup>
				<tbody>
					<tr class="row-multi-discount">
						<td class="its-td"></td>
						<td class="its-td"></td>
					</tr>
				</tbody>
			</table>

		</td>
	</tr>
	</tbody>
</table>

<br class="table-gap" />

<ul class="left-btns clearbox">
	<li><span class="desc">이용방법 : [검색하기]버튼으로 검색 후 상품정보를 업데이트 하세요.</span></li>
</ul>
<div class="fr">
	<div class="clearbox">
		<ul class="right-btns clearbox">
		<li><select class="custom-select-box-multi" name="orderby">
			<option value="goods_seq" <?php if($TPL_VAR["orderby"]=='goods_seq'){?>selected<?php }?>>최근등록순</option>
			<option value="goods_name" <?php if($TPL_VAR["orderby"]=='goods_name'){?>selected<?php }?>>상품명순</option>
			<option value="page_view" <?php if($TPL_VAR["orderby"]=='page_view'){?>selected<?php }?>>페이지뷰순</option>
		</select></li>
		<li><select  class="custom-select-box-multi" name="perpage">
			<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
			<option id="dp_qty50" value="50" <?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?> >50개씩</option>
			<option id="dp_qty100" value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
			<option id="dp_qty200" value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
		</select></li>
	</ul>
	</div>
</div>
<br style="line-height:2px;" />
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="50" /><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="100" /><!--입점--><?php }?>
		<col width="60" /><!--상품이미지-->
		<col width="" /><!--상품명-->
		<col width="500" /><!--공용정보-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
<?php if(serviceLimit('H_AD')){?><th>입점</th><?php }?>
		<th colspan="2">상품명</th>
		<th>대량구매</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;">
			<td class="center"><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_V1["provider_seq"]=='1'){?>
			<td class="bg-blue white bold center">
<?php if($TPL_V1["lastest_supplier_name"]){?>
				매입 - <?php echo $TPL_V1["lastest_supplier_name"]?>

<?php }else{?>
				매입
<?php }?>
			</td>
<?php }else{?>
			<td class="bg-red white bold center"><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
<?php }?>
			<td class="center"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a></td>
			<td class="left" style="padding-left:10px;"><a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut($TPL_V1["goods_name"], 80)?></a> <div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
<?php if($TPL_V1["tax"]=='exempt'){?><div style="color:red;">[비과세]</div><?php }?></td>
			<td class="left">
				<table>
<?php if(is_array($TPL_R2=$TPL_V1["multi_discount_policy"]["policyList"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
				<tr>
					<td style="height:auto;border:0px;width:150px;">
						<?php echo $TPL_V2["discountOverQty"]?>개 이상<?php if($TPL_V2["discountUnderQty"]){?> ~ <?php echo $TPL_V2["discountUnderQty"]?>개 미만<?php }?>
					</td>
					<td style="height:auto;border:0px;">
						<?php echo $TPL_V2["discountAmount"]?> <?php if($TPL_V1["multi_discount_policy"]["discountUnit"]=='PRI'){?><?php echo $TPL_VAR["basic_currency"]?> / 1개<?php }else{?>%<?php }?>
					</td>
				</tr>
<?php if($TPL_I2==count($TPL_V1["multi_discount_policy"]["policyList"])- 1&&$TPL_I2> 0){?>
				<tr>
					<td style="height:auto;border:0px;">
						<?php echo $TPL_V1["multi_discount_policy"]["discountMaxOverQty"]?>개 이상
					</td>
					<td style="height:auto;border:0px;">
						<?php echo $TPL_V1["multi_discount_policy"]["discountMaxAmount"]?> <?php if($TPL_V1["multi_discount_policy"]["discountUnit"]=='PRI'){?><?php echo $TPL_VAR["config_system"]['basic_currency']?> / 1개<?php }else{?>%<?php }?>
					</td>
				</tr>
<?php }?>
<?php }}?>
				</table>
			</td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td class="center" colspan="7">
<?php if($TPL_VAR["search_text"]){?>
				'<?php echo $TPL_VAR["search_text"]?>' 검색된 상품이 없습니다.
<?php }else{?>
				등록된 상품이 없습니다.
<?php }?>
		</td>
	</tr>
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->

</table>
<!-- 주문리스트 테이블 : 끝 -->



<!-- 대량구매 설정 다이얼로그 -->
<div id="multiDiscountDialog" class="hide">
	<table class="info-table-style" id="multiDiscountTable" style="width:100%">
		<colgroup>
			<col width="5%" />
			<col width="55%"/>
			<col width="40%"/>
		</colgroup>
		<thead>
			<tr>
				<th class="its-th-align center bold pd10"><span class="btn-plus"><button type="button" class="addDiscountSet"></button></span></th>
				<th class="its-th-align center bold pd10">필수옵션 상품수량</th>
				<th class="its-th-align center bold pd10">
					필수옵션 할인
					<select name="multi_discount_unit" class="line">
					<option value="PER" <?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]!='PRI'){?>selected<?php }?>>%</option>
					<option value="PRI" <?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]=='PRI'){?>selected<?php }?>><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
				</select>
				</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
		<tfoot class="center max_qty_set hide">
			<tr>
				<td class="its-td-align pd10"></td>
				<td class="its-td-align pd10 left">
					<input type="text" name="discount_max_over_qty" value="" class="line onlynumber readonly-color" size="4" maxlength="5" readonly/> 개 이상
				</td>
				<td class="its-td-align pd10 left">
					<input type="text" name="discount_max_amount" value="" class="line onlynumber" size="7" maxlength="10"/>
					<span class="discount_unit">%</span>
				</td>
			<tr>
		</tfoot>
	</table>
	<div class="center" style="padding:10px;"><span class="btn large black"><button type="button" id="applyMultiDiscountBtn">적용하기</button></span></div>
</div>