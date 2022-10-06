<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/design/eye_editor_tabcontents.html 000003390 */ 
$TPL_backup_files_1=empty($TPL_VAR["backup_files"])||!is_array($TPL_VAR["backup_files"])?0:count($TPL_VAR["backup_files"]);?>
<script>
$("#sourceTextarea<?php echo $TPL_VAR["tabIdx"]?>").each(function(){
	var tabIdx = <?php echo $TPL_VAR["tabIdx"]?>;
	var objId = $(this).attr('id');

	// Textarea Obj 
	var sourceTextareaObj = this;
	
	// 검색어
	var searchKeyword = "<?php echo $TPL_VAR["searchKeyword"]?>";


	// 에디터 생성
	sourceEditorObjs[tabIdx] = CodeMirror.fromTextArea(sourceTextareaObj, {
		mode: "<?php echo $TPL_VAR["code_mode"]?>",
		lineNumbers: true,
		lineWrapping :true,
		keyMap:'default',
		theme: 'default',
		indentUnit: 4,
		tabSize: 4,
		onChange: function(){
			sourceeditor_edited_mark_on(tabIdx);
		},
		onCursorActivity: function() {
			sourceEditorObjs[tabIdx].setLineClass(sourceEditorActiveLine, null);
			sourceEditorActiveLine = sourceEditorObjs[tabIdx].setLineClass(sourceEditorObjs[tabIdx].getCursor().line, "sourceEditorActiveLine");
		}
	});

	// 커서라인 강조
	var sourceEditorActiveLine = sourceEditorObjs[tabIdx].setLineClass(0, "sourceEditorActiveLine");

	// 검색어 찾아가기
	if(searchKeyword.length>1){
		var searchKeywordRow = null;
		for (var cursor = sourceEditorObjs[tabIdx].getSearchCursor(searchKeyword); cursor.findNext();){
			var_dump(cursor);
			sourceEditorObjs[tabIdx].markText(cursor.from(), cursor.to(), "CodeMirror-searching")
			if(searchKeywordRow==null){
				searchKeywordRow = cursor.from().line;
				sourceEditorObjs[tabIdx].setCursor(sourceEditorObjs[tabIdx].lineInfo(searchKeywordRow));
			}else{
				searchKeywordRow = cursor.from().line;
			}
		}		
	}

	$("#btnViewOriginalSource<?php echo $TPL_VAR["tabIdx"]?>").live("click",function(){
		source_view_popup('original','<?php echo $TPL_VAR["skin"]?>','<?php echo $TPL_VAR["skinTplPath"]?>');
	});
	
	

});

reMakeHelpIcon();
</script>

<input type="hidden" class="filemtime" value="<?php echo $TPL_VAR["filemtime"]?>" />
<input type="hidden" class="skin" value="<?php echo $TPL_VAR["skin"]?>" />
<input type="hidden" class="tpl_name" value="<?php echo $TPL_VAR["tpl_name"]?>" />
<input type="hidden" class="tpl_url" value="<?php echo $TPL_VAR["tpl_url"]?>" />

<table class="info-table-style" width="100%" align="center">
<col width="10%" />
<col />
<col width="105" />
<tr>
	<td class="its-th-align center">백업파일 <span class="helpicon addHelpIcon" title="최근 저장된 5개의 파일을 백업합니다."></span></th>
	<td class="its-td">
<?php if($TPL_backup_files_1){foreach($TPL_VAR["backup_files"] as $TPL_V1){?>
			 <span class="btn small"><input type="button" value="<?php echo date('Y-m-d H:i:s',$TPL_V1["time"])?>" onclick="file_view_popup('backup','<?php echo $TPL_V1["path"]?>')"/></span>
<?php }}?>
	</th>
	<td class="its-td">
<?php if($TPL_VAR["skin"]){?>
			<span class="btn small"><input type="button" value="원본소스보기" id="btnViewOriginalSource<?php echo $TPL_VAR["tabIdx"]?>" /></span>
<?php }?>
	</td>
</tr>
</table>

<textarea id="sourceTextarea<?php echo $TPL_VAR["tabIdx"]?>" class="sourceTextarea" name="tpl_source"><?php echo htmlspecialchars($TPL_VAR["tpl_source"])?></textarea>