<?php /* Template_ 2.2.6 2022/05/17 12:31:39 /www/music_brother_firstmall_kr/admin/skin/default/design/text_edit.html 000004195 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<style type="text/css">
	.tmp-wrap, .txt-editor { border: 1px solid #aaa; height: 400px; padding: 5px; overflow:auto; }
	.tmp-wrap textarea { width: 99%; height: 100%; resize: none; display: block; border: none;}
	.txt-result { display: none; margin: 10px auto; width: 950px; height: 400px; }
	.link-wrap { margin: 12px 0; }
	.link-wrap input { width: 60%; }
</style>
<script src="/app/javascript/js/base64.js"></script>
<script type="text/javascript">
$(function(){	
	parent.DM_window_title_set("left","<a href=\"javascript:;\" onmouseup=\"DM_window_sourceeditor('<?php echo $TPL_VAR["template_path"]?>','<?php echo $TPL_VAR["txt_search"]?>', true)\">◀ 텍스트 영역의 HTML소스보기</a>");
	parent.DM_window_title_set("center","<?php echo $TPL_VAR["layout_config"]["tpl_desc"]?>(<?php echo $TPL_VAR["layout_config"]["tpl_path"]?>)에 선택한 ");
	
	
	// html 소스보기 버튼 클릭
	$('.btn-edit-html').click(function(){
		if($('.btn-edit-html:checked').length > 0){
			// script 태그만 막음
			str = $('.txt-editor').html();
			str = removeDivLine(str);
			$('.txt-tmp').val(str);

			$('.txt-editor').hide();
			$('.tmp-wrap').show();
		}else{
			// script 태그만 막음
			str = $('.txt-tmp').val();
			str = removeDivLine(str);

			$('.txt-editor').html(str);
	
			$('.txt-editor').show();
			$('.tmp-wrap').hide();
		}
	});

	// 저장 시 실제 저장할 곳에 저장
	$('#textManagerForm').submit(function(){

		//html 보기가 체크 되어있는 경우엔 에디터에 적용 한다
		if($('.btn-edit-html:checked').length > 0){
			// script 태그만 막음
			str = $('.txt-tmp').val();
			str = removeDivLine(str);
			$('.txt-editor').html(str);
		}

		$('.txt-result').val(removeDivLine($('.txt-editor').html()));
		return true;
	});


	initTextEditor();
});

// 에디터 html 태그 치환 작업
function removeDivLine(str){
	str = str.replace(/<(\/?)script/gi, "&lt;$1script");
	str = str.replace(/<div>/gi, "<br>");
	str = str.replace(/<\/div>/gi, "");

	return str;
}

// 텍스트 수정 폼 초기화
function initTextEditor(){
	$('.btn-edit-html').attr('checked', false);
	$('.tmp-wrap').hide();

	$('.txt-editor').html($('.txt-result').val());
}

// 폼 전송 전처리
function textEditFormValidate(){
	
	if($('#tmp_link').val() != ''){
		$('#link').val(Base64.encode($('#tmp_link').val()));
	}

	return true;
}

</script>
<form id="textManagerForm" name="textManagerForm" action="../design_process/text_edit" method="post" target="actionFrame" onsubmit="return textEditFormValidate(); return false;">
	<input type="hidden" name="template_path" value="<?php echo $TPL_VAR["template_path"]?>" />
	<input type="hidden" name="txt_index" value="<?php echo $TPL_VAR["txt_index"]?>" />
	<input type="hidden" name="tag_name" value="<?php echo $TPL_VAR["tag_name"]?>" />
	<input type="hidden" id="link" name="link" value="" />

	<div style="height:15px"></div>
	<div style="padding:10px;">
<!-- 		<label><input type="checkbox" class="btn-edit-html" value="1" /> HTML</label> -->
		<pre class="txt-editor" contenteditable="true"></pre>
		<div class="tmp-wrap"><textarea class="txt-tmp" ></textarea></div>
		<textarea class="txt-result" name="txt"><?php echo htmlspecialchars($TPL_VAR["txt"])?></textarea>
<?php if($TPL_VAR["tag_name"]=='a'){?>
		<div class="link-wrap">
			링크 : <input type="text" id="tmp_link" value="<?php echo $TPL_VAR["link"]?>" placeholder="링크를 입력해주세요."/>
			<select name="target">
				<option value="_blank" <?php if($TPL_VAR["target"]=='_blank'){?>selected<?php }?>>새창</option>
				<option value="_self" <?php if($TPL_VAR["target"]=='_self'){?>selected<?php }?>>현재창</option>
			</select>
		</div>
<?php }?>
	</div>

	<div class="center">
		<span class="btn medium cyanblue"><input type="submit" value="적용" /></span>
	</div>
</form>
<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>