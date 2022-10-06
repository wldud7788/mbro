<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_set_extra_navigation.html 000004688 */ ?>
<script type="text/javascript">
var page_type	= '<?php echo $TPL_VAR["page_type"]?>';
var target_code = '<?php echo $TPL_VAR["target_code"]?>';
$(document).ready(function() {
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
		url		: './ajax_set_extra_navigation_list',
		data	: {'page_type':page_type, 'target_code':target_code},
		dataType: 'html',
		success	: function(res){
			console.log(res);
			$("#ajax_sub_body").html(res);
		}
	});
}
// 에디터 View 버튼
function pop_target_view(code, typecode){
	var banner_content = $("#banner_view_"+code+"_"+typecode).html();
	var newContant = '<textarea name="node_banner" id="node_banner" class="daumeditor" style="width:100%;height:500px;" contentHeight="500px" fullMode="1">'+banner_content+'</textarea>';

	// 코드값 추가
	newContant = newContant + '<input type="hidden" name="code" value="'+ typecode +'" />';

	$("#top_html_layer").html(newContant);
	DaumEditorLoader.init("#top_html");

	var width = $(document).width() * 0.9;
	var height = $(document).height() * 0.9;
	setSubCtrlPop(width, height, null, 'extra');
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
		$("#sel_chk_extra").empty();
		$("input:checkbox[name='code[]']:checked").each(function(){
			chk_cnt++;
			var clone_code = $(this).clone();
			var copy_name = $(this).attr("name").replace("code[]", "chk_code\[\]");
			clone_code.attr("name", copy_name);
			$("#sel_chk_extra").append(clone_code);
		});

		if(mod == 'modify'){
			var newContant = '<textarea name="node_banner" id="node_banner" class="daumeditor" style="width:100%;height:500px;" contentHeight="500px" fullMode="1"></textarea>';
			$("#top_html_layer").html(newContant);
			DaumEditorLoader.init("#top_html");

			// 등록 팝업창 호출
			var width = $(document).width() * 0.9;
			var height = $(document).height() * 0.9;
			setSubCtrlPop(width, height, 0, 'extra');
		}else{
			submit_target_update($('#popModifyLayer_extra_navigation').find('#targerExtraForm'),mod);
		}
	}
}
// 등록 및 삭제 최종 적용
function submit_target_update(obj, mod){
	var mod_txt	= '등록';
	if(mod == 'delete')	mod_txt = '삭제';

	$(obj).find("input[name='mode']").val(mod);

	if(!$("#targerExtraForm").find("input[name='page_type']").val()){			
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
		readyEditorForm(document.targerExtraForm);
	}

	if(!confirm("선택한 목록을 " + mod_txt + "하겠습니까? ")) return;

	var queryString = $(obj).serialize();
	$.ajax({
		type: "post",
		url: "../page_manager_process/extra_navigation",
		data: queryString,
		success: function(result){
			ajax_sub_body_layer();
			ajax_main_body_layer();
			closeDialog('popModifyLayer_extra_navigation');
			alermSuccess();
		}
	});
}
</script>

<div class="pdt5 pdb5">
	<span>선택한 항목</span>
	<span class="btn medium"><button type="button" onclick="pop_target_update('modify');" >등록</button></span>
	<span class="btn medium"><button type="button" onclick="pop_target_update('delete');" >삭제</button></span>
</div>
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
	<th class="its-th-align">배너(데스크탑 전용)</th>
</tr>
</thead>
<tbody class="ltb" id="ajax_sub_body">
<tr>
	<td class="its-td-align center" colspan="2">대상을 먼저 선택하여 주세요.</td>
</tr>
</tbody>
</table>