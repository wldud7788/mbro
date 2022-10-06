<?php /* Template_ 2.2.6 2022/05/17 12:36:47 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/_navigation_popup.html 000004916 */ ?>
<form name="targerForm" id="targerForm" method="post" action="../page_manager_process/modify_<?php echo $TPL_VAR["page_tab"]?>" target="actionFrame">
	<div class="hide" id="sel_chk"></div>
	<input type="hidden" name="page_type" value="<?php echo $TPL_VAR["page_type"]?>" />
	<input type="hidden" name="mode" value="" />
	<input type="hidden" name="style_type" value="image" />
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td class="ctab ctab-on" style="border-left: 1px solid #dadada"><span class="subtab hand" value="image">이미지</span></td>
			<td class="ctab"><span class="subtab hand" value="text">텍스트</span></td>
		</tr>
	</table>

	<div class="navitab navitab_image pd20">
		선택 : <span class="chk_cnt">0</span>개
		<label class="ml15"><input type="radio" name="image_type" value="normal" checked/> 기본</label>
		<label class="ml15"><input type="radio" name="image_type" value="over"/> 마우스오버</label>

		<div class="ajaxImageForm mt20">
			<input type="file" name="tmp_image" value="" class="ajaxImageFormInput" />
			<div id="image-preview-wrap" class="hide">
				<a href="#" class="preview-del"></a>
				<input class="preview-data" type="hidden" name="image_path" value=""/>
				<div class="preview-path"><span></span></div>
				<div class="preview-img"><img src=""/></div>
			</div>
		</div>
		<div id="preview_image"></div>
	</div>

	<div class="navitab navitab_text hide pd20">
		선택 : <span class="chk_cnt">0</span>개

		<div class="mr15"><span style="display: inline-block" class="wx70">기본</span><input type="text" name="text_normal" value="" class="customFontDecoration" /></div>
		<div class="mr15"><span style="display: inline-block" class="wx70">마우스오버</span><input type="text" name="text_over" value="" class="customFontDecoration" /></div>
	</div>

	<div style="padding:10px;" class="center">
		<span class="btn large black"><button type="button" class="saveAccessLimit" onclick="submit_target_update($(this).closest('#targerForm'),'modify');">저장</button></span>
	</div>
</form>

<!-- 이미지 팝업 -->
<div id="imgPopupWrap" class="hide"></div>


<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-font-decoration.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		// 상단 탭 영역 이벤트 정의
		$('.subtab').click(function(){
			$('.subtab').parent().removeClass('ctab-on');
			if($(this).parent().hasClass('ctab-on')){
				$(this).parent().removeClass('ctab-on');
			}else{
				$(this).parent().addClass('ctab-on');
			}

			$('.navitab').addClass('hide');
			$('.navitab_'+$(this).attr('value')).removeClass('hide');
			$('input[name="style_type"]').val($(this).attr('value'));
		});
		
		// 파일 ajax 업로드
		var opt			= {};
		var callback	= function(res){
			var that = this;
			var result	= eval(res);
			if(result.status){
				var $img_wrap = $('#image-preview-wrap').clone();
				$img_wrap.removeClass('hide');
				$img_wrap.addClass('image-preview-wrap');
				$img_wrap.find('.preview-img img').attr('src', result.filePath + result.fileInfo.file_name);
				$img_wrap.find('.preview-path span').text(result.filePath + result.fileInfo.file_name);
				$img_wrap.find('.preview-data').val(result.filePath + result.fileInfo.file_name);
				$img_wrap.find('.preview-del').click(function(){ $(this).closest('.image-preview-wrap').remove(); $(that).val(''); });

				$('#preview_image').html($img_wrap);
			}else{ // 업로드 실패
				alert('[' + result.desc + '] ' + result.msg);
				return false;
			}
		};

			
		$('.ajaxImageFormInput').createAjaxFileUpload(opt, callback);
		$(".customFontDecoration").customFontDecoration();

		// 기본값을 지정해줘야 함 2019-05-23
		var font_decoration_default	= "{'color':'#000000','font':'','size':'','bold':'normal','underline':'none'}";
		$(".customFontDecoration").val(font_decoration_default).change();

	});

	function formInit(){
		$('#preview_image').empty();	
		$('.subtab').parent().removeClass('ctab-on');
		$('.subtab').eq(0).parent().addClass('ctab-on');
		$('.navitab').addClass('hide');
		$('.navitab_image').removeClass('hide');
		$('input[name="style_type"]').val('image');
		$('input[name="tmp_image"]').val('');
		$(".customFontDecoration").customFontDecoration().change();
	}
</script>