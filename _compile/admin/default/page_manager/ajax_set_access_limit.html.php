<?php /* Template_ 2.2.6 2022/05/17 12:36:44 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_set_access_limit.html 000005597 */ ?>
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

	// 접속기간 제한 날짜 선택시
	$(".datepicker").bind('change', function(){
		$("#catalog_allow_period").attr("checked",true);
	});

	ajax_sub_body_layer();
	setDatepicker();
});

// 리스트 동적 Call
function ajax_sub_body_layer(){
	$.ajax({
		type	: 'POST',
		url		: './ajax_set_access_limit_list',
		data	: {'page_type':page_type, 'depth':depth, 'target_code':target_code},
		dataType: 'html',
		success	: function(res){
			$("#ajax_sub_body").html(res);
		}
	});
}
// 등록 및 삭제 버튼
function pop_target_update(mod){
	var mod_txt	= '등록';
	if(mod == 'delete')	mod_txt = '해제';
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
			// 등록 팝업창 호출
			setSubCtrlPop('800','270', chk_cnt);
		}else{
			submit_target_update($('#popModifyLayer_access_limit').find('#targerSettingForm'),mod);
		}
	}
}
// 등록 및 삭제 최종 적용
function submit_target_update(obj, mod){
	var mod_txt	= '등록';
	if(mod == 'delete')	mod_txt = '해제';

	$(obj).find("input[name='mode']").val(mod);

	if(!$("#targerSettingForm").find("input[name='page_type']").val()){			
		alert("입력값 오류 새로고침 후 시도하세요.");
		window.reload();
		return;
	}
	if($("input[name='catalog_allow']:checked").val() == 'period'){
		if($("input[name='catalog_allow_sdate']").val() > $("input[name='catalog_allow_edate']").val()){
			alert("기간을 정확히 입력하세요.");
			return;
		}
		if(!$("input[name='catalog_allow_sdate']").val() || !$("input[name='catalog_allow_edate']").val()){
			alert("기간을 입력해주세요.");
			return;
		}
	}
	
	if(!confirm("선택한 목록을 " + mod_txt + "하겠습니까? ")) return;

	var queryString = $(obj).serialize();
	$.ajax({
		type: "get",
		url: "../page_manager_process/modify_access_limit",
		data: queryString,
		success: function(result){
			ajax_sub_body_layer();
			ajax_main_body_layer();
			closeDialog('popModifyLayer_access_limit');
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
	<span class="btn medium"><button type="button" onclick="pop_target_update('modify');" >등록/수정</button></span>
	<span class="btn medium"><button type="button" onclick="pop_target_update('delete');" >해제</button></span>
</div>
<?php if($TPL_VAR["params"]){?>
<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0" id="inner_html">
<colgroup>
	<col width="5%" />
	<col width="25%" />
	<col width="35%" />
	<col width="35%" />
</colgroup>
<thead class="lth">
<tr>
	<th class="its-th-align" rowspan="2"><input type="checkbox" class="chk_all"/></th>
	<th class="its-th-align" rowspan="2">대상</th>
	<th class="its-th-align" colspan="2">접속제한</th>
</tr>
<tr>
	<th class="its-th-align">접속자 허용</th>
	<th class="its-th-align">접속기간 제한</th>
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