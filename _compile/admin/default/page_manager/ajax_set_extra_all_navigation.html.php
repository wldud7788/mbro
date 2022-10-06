<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_set_extra_all_navigation.html 000003592 */ ?>
<script type="text/javascript">
var page_type	= '<?php echo $TPL_VAR["page_type"]?>';
var target_code = '';
$(document).ready(function() {
	ajax_sub_body_layer();
});

// 리스트 동적 Call
function ajax_sub_body_layer(){
	$.ajax({
		type	: 'POST',
		url		: './ajax_set_extra_all_navigation_list',
		data	: {'page_type':page_type},
		dataType: 'html',
		success	: function(res){
			console.log(res);
			$("#ajax_sub_body").html(res);
		}
	});
}
// 에디터 View 버튼
function pop_target_view(code){
	var banner_content = $("#banner_view_"+code).html();
	var newContant = '<textarea name="node_gnb_banner" id="node_gnb_banner" class="daumeditor" style="width:100%;height:500px;" contentHeight="500px" fullMode="1">'+banner_content+'</textarea>';
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

	if(mod == 'modify'){
		var newContant = '<textarea name="node_gnb_banner" id="node_gnb_banner" class="daumeditor" style="width:100%;height:500px;" contentHeight="500px" fullMode="1"></textarea>';
		$("#top_html_layer").html(newContant);
		DaumEditorLoader.init("#top_html");

		// 등록 팝업창 호출
		var width = $(document).width() * 0.9;
		var height = $(document).height() * 0.9;
		setSubCtrlPop(width, height, 0, 'extra');
	}else{
		submit_target_update($('#popModifyLayer_extra_all_navigation').find('#targerExtraForm'),mod);
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
		url: "../page_manager_process/extra_all_navigation",
		data: queryString,
		success: function(result){
			ajax_sub_body_layer();
			ajax_main_body_layer();
			closeDialog('popModifyLayer_extra_all_navigation');
			alermSuccess();
		}
	});
}
</script>

<div class="pdt5 pdb5">
	<span class="btn medium"><button type="button" onclick="pop_target_update('modify');" >등록</button></span>
	<span class="btn medium"><button type="button" onclick="pop_target_update('delete');" >삭제</button></span>
</div>
<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0" id="inner_html">
<colgroup>
	<col width="35%" />
	<col width="" />
</colgroup>
<thead class="lth">
<tr>
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