<?php /* Template_ 2.2.6 2022/05/17 12:31:36 /www/music_brother_firstmall_kr/admin/skin/default/design/image_insert.html 000005534 */ 
$TPL_frequentUrls_1=empty($TPL_VAR["frequentUrls"])||!is_array($TPL_VAR["frequentUrls"])?0:count($TPL_VAR["frequentUrls"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript">
	$(function(){		
		parent.DM_window_title_set("left","<a href=\"javascript:;\" onmousedown=\"DM_window_sourceeditor('<?php echo $TPL_VAR["tplPath"]?>','<?php echo $TPL_VAR["designImgSrcOri"]?>')\">◀ HTML소스보기</a>");
		parent.DM_window_title_set("center","<?php echo $TPL_VAR["layout_config"]["tpl_desc"]?>(<?php echo $TPL_VAR["layout_config"]["tpl_path"]?>)에 선택한 ");
		
		/* 파일업로드버튼 ajax upload 적용 */
		var opt			= {};
		var callback	= function(res){
			var that		= this;
			var result		= eval(res);

			if(result.status){
				$(that).closest('.webftpFormItem').find('.webftpFormItemInput').val( 'data/tmp/' +result.fileInfo.file_name);
				$(that).closest('.webftpFormItem').find("input[name='originalFileName']").val(result.fileInfo.orig_name);
				$('#newImagePriview').attr('src', result.filePath + result.fileInfo.file_name);
				$('#newImagePriviewContainer').show();
			}else{
				alert(result.msg);
			}
		};

		// ajax 이미지 업로드 이벤트 바인딩
		$('#imageUploadButton').createAjaxFileUpload(opt, callback);
	});
</script>
<style>
	#newImagePriviewContainer {margin:auto 15px; min-height:20px; padding:10px;  border:1px solid #ddd; text-align:center;}
	.webftpFormItemPreview {max-height:100px; max-width:100px; display:none;}
</style>

<form name="imageManagerForm" action="../design_process/image_insert" method="post" enctype="multipart/form-data" target="actionFrame">
<input type="hidden" name="tplPath" value="<?php echo $TPL_VAR["tplPath"]?>" />
<input type="hidden" name="uploadPath" value="data/skin/<?php echo $TPL_VAR["designWorkingSkin"]?>/images" />

<img class="fileSearchBtnImage hide" src="/admin/skin/default/images/common/btn_filesearch.gif" />
<div style="height:15px"></div>

<div id="newImagePriviewContainer" class="hide">
	<img src="" id="newImagePriview" style="max-height:300px; max-width:100%;" />	
	<div class="center" style="padding-top:10px;">
		 이미지 ALT 레이블&nbsp; <input type="text" name="imageLabel" value="<?php echo $TPL_VAR["designImageLabel"]?>" class="line" style="width:200px;" /> 
	</div>
</div>

<div style="padding:15px;">	
	<table class="design-simple-table-style" width="100%" align="center">
		<col width="140" />
		<tr>
			<th class="dsts-th">
				삽입 이미지
			</th>
			<td class="dsts-td left">
				<div class="webftpFormItem" >
					<input type="radio" name="webftpFormItemSelector" class="hide" />
					<table border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed">
						<tr>
							<td>
								<div class="hide"><img src="<?php echo $TPL_VAR["designImgSrc"]?>" class="webftpFormItemPreview" onload="$('#newImagePriview').attr('src',this.src); $('#newImagePriviewContainer').show()" style="max-height:100px; max-width:100px;" /></div>
								<input type="text" name="newDesignImgPath" value="" size="30" class="webftpFormItemInput line" readonly="readonly" />
								<input type="text" name="originalFileName" class="webftpFormItemInputOriName hide" />
								<input id="imageUploadButton" type="file" value="" class="uploadify" />
			
								<div>
									<input type="text" name="link" value="<?php echo $TPL_VAR["link"]?>" title="링크URL" class="line" size="50" />
									<select name="target" class="custom-select-box">
										<option value="_self">현재창</option>
										<option value="_blank">새창</option>
									</select>									
									<select class="custom-select-box-multi" onchange="$(this.form.link).val(this.value).trigger('focus')">
										<option value="">자주쓰는 페이지 주소</option>
<?php if($TPL_frequentUrls_1){foreach($TPL_VAR["frequentUrls"] as $TPL_V1){?>
										<option value="<?php echo $TPL_V1["value"]?>"><?php echo $TPL_V1["name"]?></option>
<?php }}?>
									</select>									
								</div>

								<div class="hide">
									<span class="btn small"><input type="button" value="이미지 편집" /></span>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<th class="dsts-th">
				삽입 위치
			</th>
			<td class="dsts-td left">
				<div class="imageCheckboxContainer">
					<div class="imageCheckboxItem"><label><input type="radio" name="location" value="top" checked="checked" /><img src="/admin/skin/default/images/design/<?php echo $TPL_VAR["up_image_name"]?>.gif" /></label></div>
					<div class="imageCheckboxItem"><label><input type="radio" name="location" value="bottom" /><img src="/admin/skin/default/images/design/<?php echo $TPL_VAR["down_image_name"]?>.gif" /></label></div>
				</div>
			</td>
		</tr>
	</table>	
	<div style="height:15px"></div>
	
	<div class="center">
		<span class="btn large cyanblue"><input type="submit" value="적용" /></span>
	</div>
	<div style="height:15px"></div>
	</form>
</div>

<?php $this->print_("mini_webftp",$TPL_SCP,1);?>


<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>