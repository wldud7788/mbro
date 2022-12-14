<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/design/file_view_popup.html 000003726 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<link rel="stylesheet" href="/app/javascript/plugin/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/lib/util/dialog.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/neat.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/elegant.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/night.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/monokai.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/cobalt.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/eclipse.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/rubyblue.css">

<script src="/app/javascript/plugin/codemirror/lib/codemirror.js"></script>
<script src="/app/javascript/plugin/codemirror/mode/xml/xml.js"></script>
<script src="/app/javascript/plugin/codemirror/mode/javascript/javascript.js"></script>
<script src="/app/javascript/plugin/codemirror/lib/util/dialog.js"></script>
<script src="/app/javascript/plugin/codemirror/lib/util/search.js"></script>
<script src="/app/javascript/plugin/codemirror/lib/util/searchcursor.js"></script>
<script src="/app/javascript/plugin/codemirror/mode/css/css.js"></script>
<script src="/app/javascript/plugin/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="/app/javascript/plugin/codemirror/mode/htmlembedded/htmlembedded.js"></script>

<script>
var originalSourceTextareaObj;
$(function(){

	// Textarea Obj 
	var originalSourceTextareaObj = document.getElementById("originalSourceTextarea");

	originalSourceEditorObj = CodeMirror.fromTextArea(originalSourceTextareaObj, {
		mode: "<?php echo $TPL_VAR["code_mode"]?>",
		lineNumbers: true,
		lineWrapping :true,
		theme: 'cobalt',
		onCursorActivity: function() {
			originalSourceEditorObj.setLineClass(originalSourceEditorActiveLine, null);
			originalSourceEditorActiveLine = originalSourceEditorObj.setLineClass(originalSourceEditorObj.getCursor().line, "originalSourceEditorActiveLine");
		},
		onKeyEvent: function(editor, e){
			if(!e.ctrlKey && e.keyCode!=122) e.target.blur();
			
		}
	});
	
	// ???????????? ??????
	var originalSourceEditorActiveLine = originalSourceEditorObj.setLineClass(0, "originalSourceEditorActiveLine");
	

});

</script>

<style type="text/css">
	
	html,body {height:100% !important}
	
	.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black;}
	.CodeMirror-scroll {
		display: block;
		position: absolute;
		top: 0px;
		left: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999 !important;
		border: 0px;
		background-color:#112435;
	}

	.originalSourceEditorActiveLine {background: #003355 !important;}
	
	#originalSourceViewTitle 		{width:100%;}
	#originalSourceTextareaContainer {position:relative; width:100%; height:500px;}

</style>

<body>
	<table id="originalSourceViewTitle" class="info-table-style" width="100%" align="center">
	<col width="140" />
	<tr>
		<td class="its-th">????????????</th>
		<td class="its-td"><span class="source_edited_mark" style="display:none">*</span><?php echo $TPL_VAR["skin"]?>/<?php echo $TPL_VAR["tpl_path"]?></td>
	</tr>
	</table>

	<div id="originalSourceTextareaContainer"><textarea id="originalSourceTextarea"><?php echo htmlspecialchars($TPL_VAR["tpl_source"])?></textarea></div>	
	
</body>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>