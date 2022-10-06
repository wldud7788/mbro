<?php /* Template_ 2.2.6 2022/05/17 12:29:14 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_batch_modify_commoninfo.html 000008813 */ 
$TPL_info_loop_1=empty($TPL_VAR["info_loop"])||!is_array($TPL_VAR["info_loop"])?0:count($TPL_VAR["info_loop"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">
$(document).ready(function() {

	// COMMON INFO
	$("select[name='info_select']").on("change", function(){
		var text = $("select[name='info_select'] option:selected").text();
		if(!$(this).val()){
			$("input[name='info_name']").attr("readonly",false).val('');
			return;
		}
		$("input[name='info_name']").attr("readonly",true).val(text);
		$.get('../goods_process/get_info?seq='+$(this).val(), function(response) {
			var data = eval(response)[0];

			// 팝업에 공용정보 내용 집어넣기 :: 2016-05-09 lwh
			$("#view_textarea").text(data.contents);
			Editor.switchEditor($("#view_textarea").data("initializedId"));
			Editor.modify({"content" : data.contents});
		});
	});
});

// 에디터 팝업 :: 2016-05-04 lwh => 2016-11-23 admin-goodsRegist.js로부터 복사
function view_editor_pop(contants,viewType){
	var descTxt		= "";
	//if(goodsSeq) descTxt = "<span class='desc'>- 저장을 누르면 실시간으로 저장됩니다.</span>";

	$("input[name='contents_type']").val(contants);

	var newContant = '<textarea name="view_textarea" id="view_textarea" class="daumeditor" style="width:100%;height:500px;" contentHeight="500px"></textarea>';
	$(".view_contents_area").html(newContant);
	DaumEditorLoader.init("#view_textarea");

	var title = '공용 정보';
	$("#view_common_info").show();

	if(viewType == 'save')	$(".contents_saveBtn").show();
	else					$(".contents_saveBtn").hide();

	$("body").css("overflow","hidden");
	openDialog(title+" "+descTxt, "view_editor_div", {"width":"98.5%","draggable":false,position: {my:'center',at:'top',of:window},"close":function(){$("body").css("overflow","");  }});
}

// 에디터 내용 저장 :: 2016-05-04 lwh => 2016-11-23 admin-goodsRegist.js로부터 복사
function view_editor_save(){

	var editTxt		= Editor.getContent();
	var cont_type	= $("input[name='contents_type']").val();

	var info_name	= $('input[name="info_name"]').val();
	var info_select = $("form[name='tmpContentsFrm'] select[name='info_select'] option:selected").val();

	// 공용정보 검사 :: 2016-05-09 lwh
	if (editTxt == "<p><br></p>") editTxt = "";

	if (editTxt == "" && !info_name) {
		openDialogAlert('공용정보명을 입력해 주세요.',400,150,function(){},'');
		return false;
	}

	submitEditorForm(document.tmpContentsFrm);
	$("#tmpContentsFrm").submit();

	/*
	// 현재 내용 COPY
	$("#"+cont_type+"_view").html(editTxt);
	$("#"+cont_type).val(editTxt);

	openDialogAlert('임시 저장되었습니다.',400,150,function(){},'');
	*/

	closeDialog('view_editor_div');
}

function goods_info_del(){

	var seq = $("select[name='info_select']").val();

	if(seq == ""){
		alert("삭제할 공용정보를 선택하세요");
	}else{
		if(confirm("선택한 공용정보를 삭제하시겠습니까?\n삭제후에는 복구 할 수 없습니다.")){

			$.ajax({
				type: "get",
				url: "../goods_process/goods_info_del",
				data: "seq="+seq,
				success: function(result){
					var select_index = $("select[name='info_select'] option:selected").index();
					$('select[name="info_select"] option:eq('+select_index+')').remove();
					$('input[name="info_name"]').val("");

					openDialogAlert("삭제되었습니다.",400,150,function(){},'');
				}
			});

		}
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
		<select name="modify_list"  class="modify_list line">
			<option value="choice">선택 </option>
			<option value="all">전체 </option>
		</select>
		</td>
		<td class="list-row">
			<span>공용정보</span>
			<select name="batch_info_select" style="width:400px" class="line">
			<option value="">공용정보선택</option>
<?php if($TPL_info_loop_1){foreach($TPL_VAR["info_loop"] as $TPL_V1){?>
<?php if($TPL_V1["info_name"]!='== 선택하세요 =='&&$TPL_V1["info_name"]!='== ←좌측에 공용정보명을 입력하여 새로운 공용정보를 만드시거나 또는 ↓아래에서 이미 만들어진 공용정보를 불러오세요 =='){?>
			<option value="<?php echo $TPL_V1["info_seq"]?>"><?php echo $TPL_V1["info_name"]?>(<?php echo $TPL_V1["info_seq"]?>)</option>
<?php }?>
<?php }}?>
			</select>

			<span class="btn medium cyanblue"><button type="button" onclick="view_editor_pop('commonContents','save');">확인</button></span>
			<span>으로 변경합니다.</span>
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
		<col width="60" /><!--상품이미지-->
		<col width="" /><!--상품명-->
		<col width="500" /><!--공용정보-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
		<th colspan="2">상품명</th>
		<th>공용정보</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;">
			<td class="center"><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /></td>
			<td class="center"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a></td>
			<td class="left" style="padding-left:10px;"><a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut($TPL_V1["goods_name"], 80)?></a> <div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
<?php if($TPL_V1["tax"]=='exempt'){?><div style="color:red;">[비과세]</div><?php }?></td>
			<td class="left"><span class="pd10"><?php echo $TPL_V1["info_name"]?><?php if($TPL_V1["info_seq"]){?>(<?php echo $TPL_V1["info_seq"]?>)<?php }?></span>
			</td>
		</tr>
		<tr class="order-list-summary-row hide">
			<td colspan="7" class="order-list-summary-row-td"><div class="option_info"></div></td>
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