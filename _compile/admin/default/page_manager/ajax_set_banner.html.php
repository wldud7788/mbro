<?php /* Template_ 2.2.6 2022/05/17 12:36:44 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_set_banner.html 000006018 */ ?>
<script type="text/javascript">
var page_type	= '<?php echo $TPL_VAR["params"]["page_type"]?>';
var depth		= '<?php echo $TPL_VAR["params"]["depth"]?>';
var target_code = '';
$(document).ready(function() {
	// depth 선택 시 동작
	depth_select_load('','depth1','',page_type);
	$("select[name='depth1']").bind("change",function(){
		depth_select_load('depth1','depth2',$(this).val(),page_type);
		depth_select_load('depth2','depth3','',page_type);
		depth_select_load('depth3','depth4','',page_type);
	});
	$("select[name='depth2']").bind("change",function(){
		depth_select_load('depth2','depth3',$(this).val(),page_type);
		depth_select_load('depth3','depth4','',page_type);
	});
	$("select[name='depth3']").bind("change",function(){
		depth_select_load('depth3','depth4',$(this).val(),page_type);
	});
	$(".sel_target_code").bind("change",function(){
		depth		= '<?php echo $TPL_VAR["params"]["depth"]?>';
		target_code	= $(this).val();
		ajax_sub_body_layer();
	});

	// 체크박스 색상
	bindChkAll();
	$("input[type='checkbox'][name='code[]']").live('change',function(){
		if($(this).is(':checked')){
			$(this).closest('tr').addClass('checked-tr-background');
		}else{
			$(this).closest('tr').removeClass('checked-tr-background');
		}
	}).change();

	ajax_sub_body_layer();
});

// 리스트 동적 Call
function ajax_sub_body_layer(){
	$.ajax({
		type	: 'POST',
		url		: './ajax_set_banner_list',
		data	: {'page_type':page_type, 'depth':depth, 'target_code':target_code},
		dataType: 'html',
		success	: function(res){
			$("#ajax_sub_body").html(res);
		}
	});
}
// 에디터 View 버튼
function pop_target_view(code){
	var banner_content = $("#banner_view_"+code).html();
	var newContant = '<textarea name="top_html" id="top_html" class="daumeditor" style="width:100%;height:500px;" contentHeight="500px" fullMode="1">'+banner_content+'</textarea>';
	$("#top_html_layer").html(newContant);
	DaumEditorLoader.init("#top_html");

	var chk_code	= '<input type="checkbox" class="chk hide" name="chk_code[]" value="'+code+'" checked />';
	$("#popModifyLayer_banner").find("#sel_chk").html(chk_code);

	var width = 1200;
	var height = 780;
	setSubCtrlPop(width, height, null);
}
// 등록 및 삭제 버튼
function pop_target_update(mod){
	var mod_txt	= '등록';
	if(mod == 'delete')	mod_txt = '삭제';
	var cnt = $("input:checkbox[name='code[]']:checked").length;
	if(cnt<1){
		alert(mod_txt+"할 목록을 선택해 주세요.");
		return;
	}else{
		var chk_cnt	= 0;
		$("#sel_chk").empty();
		$("input:checkbox[name='code[]']:checked").each(function(){
			chk_cnt++;
			var clone_code = $(this).clone();
			var copy_name = $(this).attr("name").replace("code[]", "chk_code\[\]");
			clone_code.attr("name", copy_name);
			$("#sel_chk").append(clone_code);
		});

		if(mod == 'modify'){
			var newContant = '<textarea name="top_html" id="top_html" class="daumeditor" style="width:100%;height:500px;" contentHeight="500px" fullMode="1"></textarea>';
			$("#top_html_layer").html(newContant);
			DaumEditorLoader.init("#top_html");

			// 등록 팝업창 호출
			var width = $(document).width() * 0.9;
			var height = $(document).height() * 0.9;
			setSubCtrlPop(width, height, chk_cnt);
		}else{
			submit_target_update($('#popModifyLayer_banner').find('#targerbannerForm'),mod);
		}
	}
}
// 등록 및 삭제 최종 적용
function submit_target_update(obj, mod){
	var mod_txt	= '등록';
	if(mod == 'delete')	mod_txt = '삭제';

	$(obj).find("input[name='mode']").val(mod);

	if(!$("#targerbannerForm").find("input[name='page_type']").val()){			
		alert("입력값 오류 새로고침 후 시도하세요.");
		window.reload();
		return;
	}
	
	if(mod == 'modify'){
		var editTxt		= Editor.getContent();
		if (editTxt=="<p><br></p>") editTxt = '';
		if (editTxt == ''){
			alert("내용을 입력해 주세요.");
			return;
		}
		readyEditorForm(document.targerbannerForm);
	}

	if(!confirm("선택한 목록을 " + mod_txt + "하겠습니까? ")) return;

	var queryString = $(obj).serialize();
	$.ajax({
		type: "post",
		url: "../page_manager_process/modify_banner",
		data: queryString,
		success: function(result){
			ajax_sub_body_layer();
			ajax_main_body_layer();
			closeDialog('popModifyLayer_banner');
			alermSuccess();
		}
	});
}
</script>

<div class="pd5 target_depth_layer">
	대상&nbsp;
<?php if($TPL_VAR["params"]["depth"]> 1){?>
<?php if(is_array($TPL_R1=range( 0,($TPL_VAR["params"]["depth"]- 2)))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
	<select class="line sel_target_code" name="depth<?php echo ($TPL_K1+ 1)?>">
		<option value="">-<?php echo ($TPL_K1+ 1)?>차-</option>
	</select>
	>
<?php }}?>
<?php }?>
	<select class="line" name="" disabled>
		<option value="">-<?php echo $TPL_VAR["params"]["depth"]?>차-</option>
	</select>
</div>
<div class="pdt5 pdb5">
	<span>선택한 항목</span>
	<span class="btn medium"><button type="button" onclick="pop_target_update('modify');" >등록</button></span>
	<span class="btn medium"><button type="button" onclick="pop_target_update('delete');" >삭제</button></span>
</div>
<?php if($TPL_VAR["params"]){?>
<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0" id="inner_html">
<colgroup>
	<col width="5%" />
	<col width="35%" />
	<col width="" />
</colgroup>
<thead class="lth">
<tr>
	<th class="its-th-align"><input type="checkbox" class="chk_all"/></th>
	<th class="its-th-align">대상</th>
	<th class="its-th-align">배너</th>
</tr>
</thead>
<tbody class="ltb" id="ajax_sub_body">
<tr>
	<td class="its-td-align center" colspan="3">대상을 먼저 선택하여 주세요.</td>
</tr>
</tbody>
</table>
<?php }else{?>
잘못된 접근입니다.
<?php }?>