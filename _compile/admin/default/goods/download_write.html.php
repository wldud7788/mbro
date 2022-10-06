<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/goods/download_write.html 000010196 */ 
$TPL_requireds_1=empty($TPL_VAR["requireds"])||!is_array($TPL_VAR["requireds"])?0:count($TPL_VAR["requireds"]);
$TPL_chk_items_1=empty($TPL_VAR["chk_items"])||!is_array($TPL_VAR["chk_items"])?0:count($TPL_VAR["chk_items"]);
$TPL_chk_orders_1=empty($TPL_VAR["chk_orders"])||!is_array($TPL_VAR["chk_orders"])?0:count($TPL_VAR["chk_orders"]);
$TPL_itemList_1=empty($TPL_VAR["itemList"])||!is_array($TPL_VAR["itemList"])?0:count($TPL_VAR["itemList"]);
$TPL_items_1=empty($TPL_VAR["items"])||!is_array($TPL_VAR["items"])?0:count($TPL_VAR["items"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript">

var auth_arr = [
<?php if($TPL_requireds_1){foreach($TPL_VAR["requireds"] as $TPL_V1){?>
'<?php echo $TPL_V1?>',
<?php }}?>
];

var item_arr = [
<?php if($TPL_chk_items_1){foreach($TPL_VAR["chk_items"] as $TPL_V1){?>
'<?php echo $TPL_V1?>',
<?php }}?>
];

var order_arr = [
<?php if($TPL_chk_orders_1){foreach($TPL_VAR["chk_orders"] as $TPL_V1){?>
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
}

function Menulist_downMenu(oMenu, index) {
	if (index < 0) return;
	if (index == oMenu.length-1) {
		return; // 더 이상 아래로 이동할 수 없을때
	}
	Menulist_moveMenu(oMenu, index, 1);
}

function Menulist_upMenu(oMenu, index) {
	if (index < 0) return;
	if (index == 0) {
		return; // 더 이상 위로 이동할 수 없을때
	}
	Menulist_downMenu(oMenu, index-1);
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
	for(var i=0;i<auth_arr.length;i++){
		if(value==auth_arr[i]) cnt++;
	}
	if(cnt>0) return false;
	else return true;
}

function item_value_out(){
	$("#downloads_item_use option").each(function(){
		var cnt = 0;
		for(var i=0;i<item_arr.length;i++){
			if($(this).val()==item_arr[i]) cnt++;
		}
		if(cnt>0) $(this).appendTo("#temp_item");
	});

	$("#downloads_item_nouse option").each(function(){
		var cnt = 0;
		for(var i=0;i<item_arr.length;i++){
			if($(this).val()==item_arr[i]) cnt++;
		}
		if(cnt>0) $(this).appendTo("#temp_item");
	});
}

function item_value_in(){
	$("#temp_item option").each(function(){
		var cnt = 0;
		for(var i=0;i<item_arr.length;i++){
			if($(this).val()==item_arr[i]) cnt++;
		}
		if(cnt>0) $(this).appendTo("#downloads_item_nouse");
	});
}


function order_value_out(){
	$("#downloads_item_use option").each(function(){
		var cnt = 0;
		for(var i=0;i<order_arr.length;i++){
			if($(this).val()==order_arr[i]) cnt++;
		}
		if(cnt>0) $(this).appendTo("#temp_item");
	});

	$("#downloads_item_nouse option").each(function(){
		var cnt = 0;
		for(var i=0;i<order_arr.length;i++){
			if($(this).val()==order_arr[i]) cnt++;
		}
		if(cnt>0) $(this).appendTo("#temp_item");
	});
}

function order_value_in(){
	$("#temp_item option").each(function(){
		var cnt = 0;
		for(var i=0;i<order_arr.length;i++){
			if($(this).val()==order_arr[i]) cnt++;
		}
		if(cnt>0) $(this).appendTo("#downloads_item_nouse");
	});
}

$(document).ready(function() {

<?php if($TPL_VAR["criteria"]=='ITEM'){?>
		order_value_out();
		item_value_in();
<?php }else{?>
		item_value_out();
		order_value_in();
<?php }?>

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
			var cnt = 0;
			$("#downloads_item_use option:selected").each(function() {
				if(!required_chk($(this).val())){
					cnt++;
					return;
				}
				$(this).appendTo("#downloads_item_nouse");
			});
			if(cnt>0) alert("필수 항목은 삭제하실 수 없습니다.");
		});
		$("#downloads_item_use").dblclick(function(){
			var cnt = 0;
			$("#downloads_item_use option:selected").each(function() {
				if(!required_chk($(this).val())){
					cnt++;
					return;
				}
				$(this).appendTo("#downloads_item_nouse");
			});
			if(cnt>0) alert("필수 항목은 삭제하실 수 없습니다.");
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
			if($(this).val()=='ORDER'){
				item_value_out();
				order_value_in();
			}else{
				order_value_out();
				item_value_in();
			}
		});
});
</script>

<form id="input_form" name="input_form" method="post" action="../goods_process/download_write" target="actionFrame">
<input type="hidden" name="seq" value="<?php echo $TPL_VAR["seq"]?>" />
<input type="hidden" name="name" value="상품" />


<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2><span class="bold fx16">(구) 실물 다운로드/업로드 항목 설정</span></h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span class="btn large icon"><button type="button" onclick="location.href='/admin/goods';"><span class="arrowleft"></span>상품리스트</button></span></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large black"><button type="button" onclick="write_submit();">저장하기</button></span></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->


<div class="item-title">항목설정</div>

<select multiple="multiple" name="temp_item[]" id="temp_item" style="display:none;">
</select>


<div style="width:100%;text-align:center;">
<center>
<table cellpadding="0" cellspacing="0" width="740">
<tr>
	<td align="center">

	<div style="hiehgt:20px;font-weight:bold;">전체 항목</div>
	<select multiple="multiple" name="downloads_item_nouse[]" id="downloads_item_nouse" style="width: 305px; height: 380px;">
<?php if($TPL_itemList_1){foreach($TPL_VAR["itemList"] as $TPL_K1=>$TPL_V1){?>
<?php if(!in_array($TPL_K1,$TPL_VAR["items"])){?>
		<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }?>
<?php }}?>
	</select>

	</td>

	<td width="60" align="center">

	<span class="btn small gray"><button type="button" id="add_element">추가→</button></span>
	<div style="padding-top:6px;"></div>
	<span class="btn small gray"><button type="button" id="del_element">←삭제</button></span>

	</td>
	<td align="center">
	<div style="hiehgt:20px;font-weight:bold;">다운로드 항목</div>
		<select multiple="multiple" name="downloads_item_use[]" id="downloads_item_use" style="width: 305px; height: 380px;">
<?php if($TPL_items_1){foreach($TPL_VAR["items"] as $TPL_V1){?>
<?php if($TPL_VAR["itemList"][$TPL_V1]){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_VAR["itemList"][$TPL_V1]?></option><?php }?>
<?php }}?>
		</select>

	</td>
	<td align="left" style="padding-left:5px;">
		<span class="btn small gray"><button type="button" id="firstMove" style="width:45px;">처음</button></span>
		<div style="padding-top:6px;"></div>
		<span class="btn small gray"><button type="button" id="upMove" style="width:45px;">위로</button></span>
		<div style="padding-top:6px;"></div>
		<span class="btn small gray"><button type="button" id="downMove" style="width:45px;">아래로</button></span>
		<div style="padding-top:6px;"></div>
		<span class="btn small gray"><button type="button" id="lastMove" style="width:45px;">마지막</button></span>
	</td>
</tr>
</table>
</center>
</div>


</form>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>