<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/setting/privacy_third_party.html 000001708 */ ?>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/style.css" />
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/editor/css/editor.css" />
<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	DaumEditorLoader.init("#view_textarea");
});
// 에디터 내용 저장 :: 2017-05-10 lwh
function view_editor_save(){
	var editTxt		= Editor.getContent();
	if (editTxt=="<p><br></p>") editTxt = "";

	// 실시간 저장
	submitEditorForm(document.tmpContentsFrm);
	$("#tmpContentsFrm").submit();

	$(this).parent().closeDialog('view_editor_div');
}
</script>
<form name="tmpContentsFrm" id="tmpContentsFrm" method="post" enctype="multipart/form-data" action="../member_process/privacy_third_parth" target="actionFrame">
<div class="center">
	<div class="view_contents_area">
		<textarea name="view_textarea" id="view_textarea" class="daumeditor" style="width:100%;height:500px;" contentHeight="500px"><?php echo $TPL_VAR["policy_third_party"]?></textarea>
	</div>
	<div class="contents_saveBtn center pdt10"><span class="btn large"><button type="button" onclick="view_editor_save()" style="width:100px;">저장</button></span></div>
</div>
</form>