<?php /* Template_ 2.2.6 2022/05/17 12:36:45 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_set_recommend_light.html 000005830 */ ?>
<script type="text/javascript">
var cmd			= '<?php echo $TPL_VAR["params"]["cmd"]?>';
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
		var idx_num = $(this).closest('tr').attr('idx_num');
		if($(this).is(':checked')){
			$(".group_item"+idx_num).addClass('checked-tr-background');
			//$(this).closest('tr').find('td').addClass('checked-tr-background');
		}else{
			$(".group_item"+idx_num).removeClass('checked-tr-background');
			//$(this).closest('tr').find('td').removeClass('checked-tr-background');
		}
	}).change();

	ajax_sub_body_layer();
});

// 리스트 동적 Call
function ajax_sub_body_layer(){
	$.ajax({
		type	: 'POST',
		url		: './ajax_set_recommend_list',
		data	: {'page_type':page_type, 'depth':depth, 'target_code':target_code},
		dataType: 'html',
		success	: function(res){
			$("#ajax_sub_body").html(res);
		}
	});
}
// 설정보기 버튼
function pop_target_view(code){
	$.ajax({
		type	: 'POST',
		url		: './ajax_set_recommend_list',
		data	: {'page_type':page_type, 'depth':depth, 'target_code':target_code},
		dataType: 'html',
		success	: function(res){
			$("#top_html_layer").html(res);
		}
	});

	var width		= $(document).width() * 0.8;
	var height		= $(document).height() * 0.8;
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
		var chk_cnt			= 0;
		var target_code	= new Array();
		$("#sel_chk").empty();
		$("input:checkbox[name='code[]']:checked").each(function(){
			target_code.push($(this).val());
			chk_cnt++;
			var clone_code = $(this).clone();
			var copy_name = $(this).attr("name").replace("code[]", "chk_code\[\]");
			clone_code.attr("name", copy_name);
			$("#sel_chk").append(clone_code);
		});

		if(mod == 'modify'){
			var target_codes	= '&target_codes[]=' + target_code.join('&target_codes[]=');
			var pop_url			= "../design/display_edit?displaykind="+cmd+"&kind="+page_type+"_recommend&popup=1"+target_codes;
			window.open(pop_url,'',"width=1200,height=700,scrollbars=1");
		}else{
			submit_target_update($('#popModifyLayer_recommend').find('#targerrecommendForm'),mod);
		}
	}
}
// 등록 및 삭제 최종 적용
function submit_target_update(obj, mod){
	if(mod == 'delete'){
		$(obj).find("input[name='mode']").val(mod);
		if(!confirm("선택한 목록을 삭제하겠습니까? ")) return;

		var queryString = $(obj).serialize();
		$.ajax({
			type: "post",
			url: "../page_manager_process/modify_recommend",
			data: queryString,
			success: function(result){
				ajax_sub_body_layer();
				ajax_main_body_layer();
				closeDialog('popModifyLayer_recommend');
				alermSuccess();
			}
		});
	}else{
		ajax_sub_body_layer();
		ajax_main_body_layer();
	}
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
	<span class="btn medium"><button type="button" onclick="pop_target_update('modify');" >등록/수정</button></span>
	<span class="btn medium"><button type="button" onclick="pop_target_update('delete');" >삭제</button></span>
</div>
<?php if($TPL_VAR["params"]){?>
<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0" id="inner_html">
<colgroup>
	<col width="5%" />
	<col width="20%" />
	<col width="15%" />
	<col width="" />
</colgroup>
<thead class="lth">
<tr>
	<th class="its-th-align" rowspan="2"><input type="checkbox" class="chk_all"/></th>
	<th class="its-th-align" rowspan="2">대상</th>
	<th class="its-th-align" colspan="2">반응형 : 데스크탑, 모바일</th>
</tr>
<tr>
	<th class="its-th-align">구분</th>
	<th class="its-th-align">추천상품</th>
</tr>
</thead>
<tbody class="ltb" id="ajax_sub_body">
<tr>
	<td class="its-td-align center" colspan="4">대상을 먼저 선택하여 주세요.</td>
</tr>
</tbody>
</table>
<?php }else{?>
잘못된 접근입니다.
<?php }?>