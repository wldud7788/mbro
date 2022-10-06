<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/order/download_write.html 000021731 */ 
$TPL_order_list_arr_1=empty($TPL_VAR["order_list_arr"])||!is_array($TPL_VAR["order_list_arr"])?0:count($TPL_VAR["order_list_arr"]);
$TPL_item_list_arr_1=empty($TPL_VAR["item_list_arr"])||!is_array($TPL_VAR["item_list_arr"])?0:count($TPL_VAR["item_list_arr"]);
$TPL_orderrequireds_1=empty($TPL_VAR["orderrequireds"])||!is_array($TPL_VAR["orderrequireds"])?0:count($TPL_VAR["orderrequireds"]);
$TPL_itemrequireds_1=empty($TPL_VAR["itemrequireds"])||!is_array($TPL_VAR["itemrequireds"])?0:count($TPL_VAR["itemrequireds"]);
$TPL_items_1=empty($TPL_VAR["items"])||!is_array($TPL_VAR["items"])?0:count($TPL_VAR["items"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<style type="text/css">
.excel-form-lay {padding-left:20px;}
.excel-form-lay .excel-form-cell {position:relative;margin-top:20px;margin-left:20px;width:30%;display:inline-block;vertical-align:top;}
.excel-form-table {border-left:1px solid #464646;border-top:1px solid #464646;}
.excel-form-table tr td {text-align:center;border-right:1px solid #464646;border-bottom:1px solid #464646;}
.excel-form-table tr td.checked-cell {background-color:#fffed9 !important;font-weight:bold;}
.excel-form-table tr td:last-child {padding:5px;text-align:left;}
.excel-form-table tr:nth-child(odd) td {background-color:#f5f5f5;}
.excel-form-table tr:nth-child(even) td {background-color:#d8d8d8;}
button.excel-btn {width:70px;}
</style>
<script type="text/javascript">
// 주문 엑셀 항목
var order_list_arr = [
<?php if($TPL_order_list_arr_1){foreach($TPL_VAR["order_list_arr"] as $TPL_K1=>$TPL_V1){?>
{'<?php echo $TPL_K1?>':'<?php echo $TPL_V1?>'},
<?php }}?>
];

// 상품 엑셀 항목
var item_list_arr = [
<?php if($TPL_item_list_arr_1){foreach($TPL_VAR["item_list_arr"] as $TPL_K1=>$TPL_V1){?>
{'<?php echo $TPL_K1?>':'<?php echo $TPL_V1?>'},
<?php }}?>
];

// 주문별 필수
var required_only_order_arr = [
<?php if($TPL_orderrequireds_1){foreach($TPL_VAR["orderrequireds"] as $TPL_V1){?>
'<?php echo $TPL_V1?>',
<?php }}?>
];

// 상품별 필수
var required_items_arr = [
<?php if($TPL_itemrequireds_1){foreach($TPL_VAR["itemrequireds"] as $TPL_V1){?>
'<?php echo $TPL_V1?>',
<?php }}?>
];

 // 메뉴 끝으로 이동
function fnMenuMoveEnd(oMenu) {
	var cnt = oMenu.length-1;
	var i=0;

	for (i=oMenu.length-1; i>=0; i--) {
		if (Menulist_isSelected(oMenu, i)) {
			if (i==oMenu.length-1) return;
			var idx = i;

			for (j=idx;j<cnt;j++) {
				Menulist_downMenu(oMenu, idx);
				idx = idx + 1;
			}
			cnt = cnt - 1;
		}
	}

	red_cell();
}

// 메뉴 맨 위로 이동
function fnMenuMoveStart(oMenu) {
	var i=0;
	var len = oMenu.length;
	var cnt = 0;
	for (i=0; i<oMenu.length; i++) {
	if (Menulist_isSelected(oMenu, i)) {
		if (i==0) return;
		var idx = i;

		for (j=idx;j>cnt;j--) {
			Menulist_upMenu(oMenu, idx);
			idx = idx - 1;
		}
		cnt = cnt + 1;
		}
	}

	red_cell();
}

// 메뉴 위로 이동
function fnMenuMoveUp(oMenu) {
	var i=0;
	for (i=0; i<oMenu.length; i++) {
		if (Menulist_isSelected(oMenu, i)) {
			if (i==0) return;
			Menulist_upMenu(oMenu, i);
		}
	}
	red_cell();
}

// 메뉴 아래로 이동
function fnMenuMoveDown(oMenu) {
	var i=0;
	for (i=oMenu.length-1; i>=0; i--) {
		if (Menulist_isSelected(oMenu, i)) {
			if (i==oMenu.length-1) return;
			Menulist_downMenu(oMenu, i);
		}
	}
	red_cell();
}

function Menulist_downMenu(oMenu, index) {
	if (index < 0) return;
	if (index == oMenu.length-1) {
		return; // 더 이상 아래로 이동할 수 없을때
	}
	Menulist_moveMenu(oMenu, index, 1);

	red_cell();
}

function Menulist_upMenu(oMenu, index) {
	if (index < 0) return;
	if (index == 0) {
		return; // 더 이상 위로 이동할 수 없을때
	}
	Menulist_downMenu(oMenu, index-1);
	red_cell();
}

function Menulist_isSelected(oMenu, idx) {
	return (oMenu.options[idx].selected==true);
}
function Menulist_moveMenu(oMenu, index, distance) {
	var tmpOption = new Option(oMenu.options[index].text, oMenu.options[index].value, false,
	oMenu.options[index].selected);
	for (var i=index; i<index+distance; i++) {
		oMenu.options[i].text = oMenu.options[i+1].text;
		oMenu.options[i].value = oMenu.options[i+1].value;
		oMenu.options[i].selected = oMenu.options[i+1].selected;

	}
	oMenu.options[index+distance] = tmpOption;

	red_cell();
}

function write_submit(){
	var option = document.getElementById("downloads_item_use");
	for(var i=0;i<option.options.length;i++){
		option.options[i].selected = true;
	}
	document.input_form.submit();
}

function required_chk(value){
	var cnt = 0;
	var criteria = $("input[name='criteria']:checked").val();

	if(criteria=='ITEM'){
		for(var i=0;i<required_items_arr.length;i++){
			if(value==required_items_arr[i]) cnt++;
		}
	}
	if(criteria=='ORDER'){
		for(var i=0;i<required_only_order_arr.length;i++){
			if(value==required_only_order_arr[i]) cnt++;
		}
	}

	if(cnt>0) return false;
	else return true;
}

function set_excel_item()
{
	var num			= 0;
	var viewKey		= 0;
	var listKey			= 0;
	var subKey		= 0;
	var itemKey		= false;
	var itemName	= false;
	var chk				= false;
	var chkKey		= false;
	var usedVal		= false;
	var viewObj		= new Array();
	var listObj			= order_list_arr;
	var criteria		= $("input[name='criteria']:checked").val();
	var usedObj		= $("#downloads_item_use");
	var nousedObj	= $("#downloads_item_nouse");

	if(criteria == 'ITEM') listObj = item_list_arr;

	usedObj.find("option").each(function(){
		itemKey	= false;
		usedVal	= $(this).val();
		for(listKey in listObj){
			for(subKey in listObj[listKey]){
				if(subKey == usedVal) itemKey = subKey;
			}
		}
		if(!itemKey){
			chkKey = check_add_cell( usedVal );
			if(chkKey) viewObj[num] = usedVal;
			num++;
		}else if( itemKey ){
			viewObj[num] = itemKey;
			num++;
		}
	});

	usedObj.find('option').remove();
	nousedObj.find('option').remove();

	for(viewKey in viewObj){
		itemName = false;
		for(listKey in listObj){
			for(subKey in listObj[listKey]){
				if(subKey == viewObj[viewKey]){
					itemName = listObj[listKey][subKey];
				}
			}
		}
		if(!itemName) itemName = viewObj[viewKey];
		usedObj.append('<option value="'+viewObj[viewKey]+'">'+itemName+'</option>');
	}

	for(listKey in listObj){
		chk = false;
		for(subKey in listObj[listKey]){
			for(viewKey in viewObj){
				if(subKey == viewObj[viewKey]) chk = true;
			}
		}
		if( !chk ){
			for(subKey in listObj[listKey]){
				nousedObj.append('<option value="'+subKey+'">'+listObj[listKey][subKey]+'</option>');
			}
		}
	}

	set_multiplication_sign();
	red_cell();
}

function check_criteria()
{
	var criteria = $("input[name='criteria']:checked").val();
	if(criteria == 'ORDER'){
		$("#item_require_message").addClass("hide");
		$("#order_require_message").removeClass("hide");
	}else{
		$("#order_require_message").addClass("hide");
		$("#item_require_message").removeClass("hide");
	}
	select_criteria(criteria);
}

// 필수항목 *기호 붙이기
function set_multiplication_sign()
{
	var criteria = $("input[name='criteria']:checked").val();
	$("select.excel_item option").each(function(){
		var str = $(this).text();
		var res = str.replace("*", "");
		$(this).text(res);
		if(criteria == 'ORDER'){
			for(var i=0;i<required_only_order_arr.length;i++){
				if($(this).val()==required_only_order_arr[i]){
						$(this).text('*'+res);
				}
			}
		}
		if(criteria == 'ITEM'){
			for(var i=0;i<required_items_arr.length;i++){
				if($(this).val()==required_items_arr[i]){
					$(this).text('*'+res);
				}
			}
		}
	});
}

function select_criteria(excel_type)
{
	if	(excel_type == 'ITEM'){
		$(".ORDER").hide();
		$(".ITEM").show();
	}else{
		$(".ORDER").show();
		$(".ITEM").hide();
	}

}

function view_excel_code_help(){
	openDialog("택배사  안내", "excel_code_help", {"width":"700","height":"408","show" : "fade","hide" : "fade"});
}

function check_add_cell(str){
	var patt = /(추가)/;
	return patt.test( str );
}

function delete_cell()
{
	var cnt = 0;
	$("#downloads_item_use option:selected").each(function() {
		if( check_add_cell($(this).val()) ) {
			$(this).remove();
			return;
		}
		$(this).appendTo("#downloads_item_nouse");
	});
	red_cell();
}

function plus_cell(){
	var add_cell_name = $("input[name='add_cell']").val();
	var sobj = $("#downloads_item_use");

	sobj.find("option").each(function(){
		if( $(this).val() == '(추가) '+ add_cell_name ) add_cell_name = '';
	});
	if(!add_cell_name) return false;

	var tag = "<option value='(추가) "+add_cell_name+"'>(추가) "+add_cell_name+"</option>";
	sobj.append( tag );
	red_cell();
}

function add_del_cell(){
	$("#downloads_item_use option:selected").each(function() {
		if( check_add_cell($(this).val()) ) {
			$(this).remove();
			red_cell();
			return;
		}else{
			alert("해당 항목은 추가셀이 아닙니다.");
		}
	});
}

function red_cell(){
	$("#downloads_item_use option").each(function() {
		if( check_add_cell($(this).val()) ) {
			$(this).addClass("red");
		}else{
			$(this).removeClass("red");
		}
	});
}

$(document).ready(function() {
	// 항목 추가
	$('#add_element').click(function() {
		$("#downloads_item_nouse option:selected").each(function() {
			$(this).appendTo("#downloads_item_use");
		});
	});
	$("#downloads_item_nouse").dblclick(function(){
		$("#downloads_item_nouse option:selected").each(function() {
			$(this).appendTo("#downloads_item_use");
		});
	});

	// 항목 삭제
	$('#del_element').click(function() {
		delete_cell();
	});
	$("#downloads_item_use").dblclick(function(){
		delete_cell();
	});

	// 항목 처음으로 이동
	$('#firstMove').click(function() {
		fnMenuMoveStart(document.input_form.downloads_item_use);
	});

	// 항목 위로 이동
	$('#upMove').click(function() {
		fnMenuMoveUp(document.input_form.downloads_item_use);
	});

	// 항목 아래로 이동
	$('#downMove').click(function() {
		fnMenuMoveDown(document.input_form.downloads_item_use);
	});

	// 항목 마지막 이동
	$('#lastMove').click(function() {
		fnMenuMoveEnd(document.input_form.downloads_item_use);
	});

	$("input:radio[name='criteria']").click(function() {
		set_excel_item();
	});

<?php if(!$TPL_VAR["seq"]){?>
	$("#file_type_input").removeClass("hide");
<?php }else{?>
	$("#file_type_message").removeClass("hide");
<?php }?>

<?php if($_GET["seq"]){?>
	// 선택된 엑셀 종류 표시
	select_criteria('<?php echo $TPL_VAR["criteria"]?>');
<?php }?>
	set_excel_item();
	check_criteria();
});
</script>
<style>
table.info-table-style tr td table.excel-file-type-table {border-collapse:collapse;border:1px solid #aaaaaa;}
table.info-table-style tr td table.excel-file-type-table tr th {padding:10px;border-left:1px solid #c7c7c7;border-bottom:1px solid #c7c7c7;background-color:#e8e8e8;font-size:11px;color:#000;font-weight:normal;text-align:left;}
table.info-table-style tr td table.excel-file-type-table tr td {padding:10px;border-left:1px solid #dadada;border-bottom:1px solid #dadada;font-size:11px;}
table.info-table-style tr td table.excel-file-type-table tr td span.excel-highlight-link{color:#e06d18;text-decoration: underline;}
div.attention {font-size:16px;font-weight:bold;}
div.excel_item_title {font-weight:bold; font-size:14px; font-family:dotum;}
select.excel_item {width:400px; height:600px; font-size:14px; font-family:dotum;}
</style>
<form id="input_form" name="input_form" method="post" action="../order_process/download_write" target="actionFrame">
<input type="hidden" name="seq" value="<?php echo $TPL_VAR["seq"]?>" />

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2><span class="bold fx16">다운로드 항목설정</span></h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span class="btn large icon"><button type="button" onclick="location.href='/admin/order/download_list';"><span class="arrowleft"></span>양식리스트</button></span></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large black"><button type="button" onclick="write_submit();">저장하기</button></span></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="item-title">이름 및 종류</div>
<table class="info-table-style" style="width:100%">
<colgroup><col width="20%" /><col width="80%" /></colgroup>
<tbody>
<tr>
	<th class="its-th-align center">이름</th>
	<td class="its-td">
		<input type="text" name="name" style="width:90%" class="line" value="<?php echo $TPL_VAR["name"]?>" />
	</td>
</tr>
<tr>
	<th class="its-th-align center">선택</th>
	<td class="its-td">
<?php if($_GET["seq"]> 0&&$TPL_VAR["criteria"]=='ORDER'){?>
		주문기준 엑셀파일
<?php }elseif($_GET["seq"]> 0&&$TPL_VAR["criteria"]=='ITEM'){?>
		상품기준 엑셀파일
<?php }?>
		<div <?php if($_GET["seq"]){?>class="hide"<?php }?>>
		<label><input type="radio" name="criteria" class="null " value="ORDER" checked onclick="check_criteria()" /> 주문기준 엑셀파일</label>
		<label><input type="radio" name="criteria" class="null" value="ITEM" <?php if($TPL_VAR["criteria"]=='ITEM'){?>checked<?php }?> onclick="check_criteria()" /> 상품기준 엑셀파일</label>
		</div>
	</td>
</tr>
<tr>
	<th class="its-th-align center">상품설정</th>
	<td class="its-td">
		<input type="checkbox" id="only_real" name="only_real" <?php if($TPL_VAR["only_real"]==true){?>checked<?php }?>/> <label for="only_real">실제(연결)상품 만 다운로드</label>
	</td>
</tr>
<tr>
	<th class="its-th-align center">
		<div class="ORDER">주문기준 엑셀파일</div>
		<div class="ITEM">상품기준 엑셀파일</div>
	</th>
	<td class="its-td">
		<div>출고처리를 정확하게 하기 위해 동일한 판매자의 동일한 배송방법과 동일한 배송지를 기준으로 주문 정보를 자동 분류하여 엑셀로 다운로드 됩니다.</div>
		<div>
			<table class="excel-file-type-table" width="95%">
			<tr>
				<th width="16%">중요한 셀</th>
				<th width="42%" style="text-align:center;">다운로드 값</th>
				<th width="42%" style="text-align:center;">업로드(엑셀로 출고처리) 안내</th>
			</tr>
			<tr>
				<th>보낼수량</th>
				<td class="ORDER">
					<div class="attention">해당 주문의 보낼 수량 합</div>
					<div>※ 보낼 수량 합 = 주문수량 합 - 취소수량 합 - 보낸수량 합</div>
				</td>
				<td class="ORDER">
					<div class="attention">해당 주문의 보낼 수량 합</div>
					<div class="red">※ 다운로드 된 보낼수량으로 출고처리됨</div>
				</td>
				<td class="ITEM">
					<div class="attention">해당 주문→해당 상품의 보낼 수량</div>
					<div>※ 보낼 수량 = 상품의 주문수량 –상품의 주문수량 – 상품의 보낸수량</div>
				</td>
				<td class="ITEM">
					<div class="attention">해당 주문→해당 상품의 보낼 수량</div>
					<div class="red">※ 다운로드 된 ‘보낼수량’ 이하이고 ‘0’보다 클 때 출고처리됨</div>
					<div class="red">※ 보낼수량을 조정하여 상품별 부분출고 가능함</div>
				</td>
			</tr>
			<tr>
				<th>택배사</th>
				<td>
					<div class="attention">택배사 코드</div>
					<div>※ 배송방법이 택배이고 설정된 택배사가 있을 때 자동 기재됨</div>
				</td>
				<td>
					<div class="attention">택배사 코드</div>
					<div>※ 일괄업로드(송장) 기능의 업로드 전용 필드</div>
					<div>※ 배송방법이 택배일 때 변경 가능 <span class="excel-highlight-link hand" onclick="view_excel_code_help();">안내)택배사</span></div>
				</td>
			</tr>
			<tr>
				<th>운송장번호</th>
				<td></td>
				<td>
					<div class="attention">운송장번호</div>
					<div>※ 일괄업로드(송장) 기능의 업로드 전용 필드</div>
					<div>※ 배송방법이 택배일 때 택배사의 운송장번호</div>
					<div>※ 단, 우체국(AUTO) : 엑셀 입력 불필요 (자동할당됨)</div>
					<div>※ 단, 롯데택배(AUTO) : 엑셀 입력 불필요 (자동할당됨)</div>
					<div>※ 단, 굿스플로(AUTO) : 엑셀 입력 불필요 (아래와 같이 처리)</div>
					<div style="margin-left:15px;">① ‘출고준비’ 처리 후</div>
					<div style="margin-left:15px;">② 굿스플로 [운송장받기/출력] 버튼 클릭하여 운송장 받은 후</div>
					<div style="margin-left:15px;">③ ‘출고완료’ 처리함</div>
				</td>
			</tr>
			<tr>
				<th>
					<div class="ORDER">출고그룹</div>
					<div class="ITEM">주문기준 엑셀파일</div>
				</th>
				<td class="ORDER">
					<div class="attention">출고그룹</div>
					<div>※ 자동으로 기재됨</div>
				</td>
				<td class="ORDER">
					<div class="attention">출고그룹</div>
					<div class="red">※ 필수값으로 출고그룹이 있어야만 출고처리가 가능함</div>
				</td>
				<td class="ITEM">
					<div class="attention">출고상품번호</div>
					<div>※ 자동으로 기재됨</div>
				</td>
				<td class="ITEM">
					<div class="attention">출고상품번호</div>
					<div class="red">※ 필수값으로 출고상품번호가 있어야만 출고처리가 가능함</div>
				</td>
			</tr>
			</table>
		</div>
	</td>
</tr>
<tr>
	<th class="its-th-align center">업로드 시 출고처리를 위한 필수값</th>
	<td class="its-td">
		<div id="order_require_message" class="hide">
<?php if($TPL_orderrequireds_1){foreach($TPL_VAR["orderrequireds"] as $TPL_K1=>$TPL_V1){?>
		*<?php echo $TPL_VAR["order_list_arr"][$TPL_V1]?><?php if($TPL_K1!=$TPL_orderrequireds_1- 1){?>,<?php }?>
<?php }}?>
		</div>
		<div id="item_require_message" class="hide">
<?php if($TPL_itemrequireds_1){foreach($TPL_VAR["itemrequireds"] as $TPL_K1=>$TPL_V1){?>
		*<?php echo $TPL_VAR["item_list_arr"][$TPL_V1]?><?php if($TPL_K1!=$TPL_itemrequireds_1- 1){?>,<?php }?>
<?php }}?>
		</div>
	</td>
</tr>
</tbody>
</table>

<div style="height:30px"></div>

<div class="item-title">항목설정</div>

<div align="center">
<table cellpadding="0" cellspacing="0">
<tr>
	<td align="center" valign="top">
		<div class="excel_item_title">전체 항목</div>
		<select multiple="multiple" name="downloads_item_nouse[]" id="downloads_item_nouse" class="excel_item select_download_item">
<?php if($TPL_VAR["criteria"]=='ORDER'){?>
<?php if($TPL_order_list_arr_1){foreach($TPL_VAR["order_list_arr"] as $TPL_K1=>$TPL_V1){?>
<?php if(!in_array($TPL_K1,$TPL_VAR["items"])){?>
			<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }?>
<?php }}?>
<?php }else{?>
<?php if($TPL_item_list_arr_1){foreach($TPL_VAR["item_list_arr"] as $TPL_K1=>$TPL_V1){?>
<?php if(!in_array($TPL_K1,$TPL_VAR["items"])){?>
			<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }?>
<?php }}?>
<?php }?>
		</select>
		<div class="pdt5" style="height:50px;"></div>
	</td>

	<td width="80" align="center">
		<span class="btn small gray"><button type="button" id="add_element" class="excel-btn">추가 →</button></span>
		<div style="padding-top:6px;"></div>
		<span class="btn small gray"><button type="button" id="del_element" class="excel-btn">← 삭제</button></span>
	</td>
	<td align="center" valign="top">
		<div class="excel_item_title">다운로드 항목</div>
			<select multiple="multiple" name="downloads_item_use[]" id="downloads_item_use"  class="excel_item selected_download_item">
<?php if($TPL_items_1){foreach($TPL_VAR["items"] as $TPL_V1){?>
<?php if($TPL_VAR["itemList"][$TPL_V1]){?>
				<option value="<?php echo $TPL_V1?>"><?php echo $TPL_VAR["itemList"][$TPL_V1]?></option>
<?php }else{?>
				<option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option>
<?php }?>
<?php }}?>
			</select>
		<div class="pdt5" style="height:50px;">
			<input type="text" name="add_cell" style="width:315px;" value="" />
			<span class="btn small red"><button type="button" id="add_cell" class="excel-btn" onclick="plus_cell();">↑셀 추가</button></span>
		</div>
	</td>
	<td align="left" style="padding-left:5px;">
		<span class="btn small gray"><button type="button" id="firstMove" class="excel-btn">처음</button></span>
		<div style="padding-top:6px;"></div>
		<span class="btn small gray"><button type="button" id="upMove" class="excel-btn">위로</button></span>
		<div style="padding-top:6px;"></div>
		<span class="btn small gray"><button type="button" id="downMove" class="excel-btn">아래로</button></span>
		<div style="padding-top:6px;"></div>
		<span class="btn small gray"><button type="button" id="lastMove" class="excel-btn">마지막</button></span>
		<div style="padding-top:6px;"></div>
		<span class="btn small red"><button type="button" id="del_cell" class="excel-btn" onclick="add_del_cell()">추가 셀 삭제</button></span>
	</td>
</tr>
</table>
</div>
</form>

<div id="excel_code_help" style="display:none;">
<?php $this->print_("excel_delivery_code",$TPL_SCP,1);?>

</div>

<script>red_cell();</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>