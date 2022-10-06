<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/popup_image_multi.html 000008606 */ 
$TPL_goodsImageSize_1=empty($TPL_VAR["goodsImageSize"])||!is_array($TPL_VAR["goodsImageSize"])?0:count($TPL_VAR["goodsImageSize"]);?>
<!--  html5 image multi upload -->
<script type="text/javascript" src="/app/javascript/plugin/jquery_fileupload/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery_fileupload/jquery.fileupload.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/browsercheck.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/image.uploader.js?dummy=<?php echo date('Ymdhi')?>"></script>
<script type="text/javascript">
var arrGoodsImage = new Array();
<?php if($TPL_goodsImageSize_1){$TPL_I1=-1;foreach($TPL_VAR["goodsImageSize"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
arrGoodsImage[<?php echo $TPL_I1?>] = '<?php echo $TPL_K1?>';
<?php }}?>

var imageMultiLayId 	= "set_popup_image_multi_lay";
var goodsImageTableObj 	= $('#goodsImageTable .goodsImageDetail');

function preview(response) {
	url = response.filePath + '/' + response.fileInfo.orig_name;

	var code = '<div class="image-preview-wrap mr5"><div class="bg"><a href="#" class="preview-del"></a><input class="preview-data" type="hidden" name="image_path" value=""/>';
	code += '<div class="preview-img"><a href="' + url + '" target="_blank">';
	code += '<img src="' + url + "?" + Math.random() + '"/></a></div>';
	code += '<input type="hidden" name="uploadImg[]" value="' + url + '">';
	code += '</div><div>';

	$('.webftpFormItem .preview_image').append(code);
}

$(function(){
	// 단건파일 업로드'전' 실행되는 이벤트
	singleFileUpload.event.singleAdd(function (file) {
        var acceptFileTypes = /^image\/(gif|jpe?g|png)$/i;
		if(
			typeof file.originalFiles !== 'undefined'
			&& !acceptFileTypes.test(file.originalFiles[0]['type'])
		) {
            alert('이미지 파일(gif, png, jpeg, jpg)만 선택해 주세요');

			// bool 결과에따라 파일업로드 진행여부 결정된다.
			return false;
        }
	});

	// 단건파일 업로드'후' 실행되는 이벤트
	singleFileUpload.event.singleDone(function (response) {
		// 업로드 이미지 미리보기 생성
		if (response.result[0].status === 1) {
			$('.webftpFormItem .preview_image span.nothing').hide();
			preview(response . result[0]);
		} else {
			var fileName = response.files[0].name;
			var errorMessage = response.result[0].msg;
			
			alert('파일명 : ' + fileName + " \n" + errorMessage);
		}
	});

	// 모든파일 업로드'후' 실행되는 이벤트
	singleFileUpload.event.multiDone(function(file){
		// 미리보기 삭제 이벤트		
		$(document).on('click', '#set_popup_image_multi_lay .preview-del', function(e) {
			e.preventDefault();
			$(this).closest('.image-preview-wrap').remove();
		});
	});

	// 파일업로드 설정값
	singleFileUpload.eventRegist({
		url : '/common/goods_image_temporary_fileupload',
		fileIdSelector : '#html5_upload',
	});

	///////////////////////////////////////////////////////////////////////////////////////////////////
	$("#"+imageMultiLayId+" .setImageSize").on("click",function(){
		openDialog("사이즈 확인", "goods_resize_formlay", {'width':550,'height':570,'show':'fade','hide' : 'fade'});
	});
	//사이즈변경 기본값 세팅
	$("#goods_resize_formlay .setDefaultValue").on("click",function(){
		var defaultSize = {'largeImage':'800',
							'viewImage':'600',
							'list1Image':'300',
							'list2Image':'190',
							'thumbView':'80',
							'thumbCart':'100',
							'thumbScroll':'74'
							};
		$.each(defaultSize,function(key,val){
			$("#goods_resize_formlay #"+key+"Width").val(val);
		});
	});
	/* 상품이미지 설정 저장 */
	$("#goods_resize_formlay .save_image_config").click(function(){
		save_image_config();
	});

	/* 이미지 및 설정 최종저장 :: 2016-04-29 lwh */
	$("#"+imageMultiLayId+" #saveGoodsImg").on('click',function(){
		// 업로드 이미지 검사
		var img_len = $("#"+imageMultiLayId+" input[name='uploadImg[]']").length;
		if(img_len < 1){
			alert("'파일 선택'을 통해 상품 사진을 먼저 추가 해주세요.");
			return;
		}

		$('#goodsImageTable .goodsImageDetail tbody tr.no_goods_image').remove();
		var goodsSeq	= gl_goods_seq;
		var provider_seq= gl_provider_seq;
		var regist_date	= "<?php echo $TPL_VAR["goods"]["regist_date"]?>";
		var serialize	= $("form#upload_img_frm").serialize();
		var cutnum		= $('tbody tr',goodsImageTableObj).not(".no_goods_image").length;
		var params		= 'type=multi&division=all&goodsSeq='+goodsSeq+'&regist_date='+regist_date+'&provider_seq='+provider_seq+'&idx='+cutnum+'&'+serialize;

		// seq가 넘어왔을땐 실시간 저장
		if(goodsSeq){
			loadingStart();
			$.ajax({
				type: "post",
				url: "../goods_process/goods_img_upload",
				data: params,
				dataType : 'json',
				success: function(result){
					var flag = false;					
					if(result[0]){
						$.each(result[0],function(num,val){
							goodsImageAdd();	//사진 상세 추가
							var idx	= $('.goodsImageDetail tbody tr').not("tr.no_goods_image").length;
							idx = parseInt(idx-1);
							if(val){
								for(var i=0;i<arrGoodsImage.length;i++){
									$('.goods'+arrGoodsImage[i],goodsImageTableObj).eq(idx).removeClass("desc").addClass("hand");
									$("input[name='"+arrGoodsImage[i]+"GoodsImage[]']",goodsImageTableObj).eq(idx).val( val.replace('large',arrGoodsImage[i]) );
									flag = true;
								}
							}
						});
					}

					if(flag){
						default_img();
						alert('이미지가 저장되었습니다');
						closeImageMultiDialog();
					}else{
						alert('이미지가 업로드가 실패되었습니다.');
					}
				}
			});
		}else{
			$("#"+imageMultiLayId+" input[name='uploadImg[]']").each(function(idx,obj){
				done($(obj).val());
			});
			default_img();
			alert('이미지가 임시저장 되었습니다.');
			closeImageMultiDialog();
			//window.self.close();
		}
	});

});

function done(val) {
	$('tbody tr.no_goods_image',goodsImageTableObj).remove();
	$("form #goodsImageAdd").click();
	var idx = $('tbody tr',goodsImageTableObj).not(".no_goods_image").length;
	idx = parseInt(idx-1);
	for(var i=0;i<arrGoodsImage.length;i++){
		$('.goods'+arrGoodsImage[i], goodsImageTableObj).eq(idx).removeClass("v3");
		$("input[name='"+arrGoodsImage[i]+"GoodsImage[]']",goodsImageTableObj).eq(idx).val( val.replace('view',arrGoodsImage[i]) );
	}
}

function closeImageMultiDialog() {
	closeDialog(imageMultiLayId);
}
</script>

<div class="content webftpFormItem">
	<form name="upload_img_frm" id="upload_img_frm">
	<div class="right">
		<button type="button" class="resp_btn setImageSize">사이즈 확인</button>
	</div>

	<table class="table_basic mt5">
		<colgroup>
			<col width="25%">
			<col width="75%">
		</colgroup>
	<tr>
		<th>사진 첨부</th>
		<td>
			<!--  html5 uploader progress -->
			<div class="uploaderHtml5">
				<label class="resp_btn v2 mt0"><input type="file"  id="html5_upload" name="Filedata" multiple accept="image/*">파일선택</label>
				<input type="hidden" class="webftpFormItemInput" name="Filedata" value="<?php echo $TPL_VAR["event"]["event_banner"]?>" size="30" maxlength="255" />									
			</div>
		</td>
	</tr>
	<tr>
		<th>미리 보기</th>
		<td>
			<div id="img_viewer" class="uploaderFlash hide"><span class="nothing">선택한 파일이 없습니다.</span></div>
			<div class="uploaderHtml5 preview_image"><span class="nothing">선택한 파일이 없습니다.</span></div>
		</td>
	</tr>
	</table>
	</form>
	<ul class='bullet_hyphen resp_message'>
		<li>여러 개의 이미지를 한번에 등록 가능합니다.</li>
		<li>첨부 가능한 용량 및 개수는 아래와 같습니다.
			<dl>
				<dt>한 개 파일 : 최대 6MB</dt>
			</dl>
			<dl>
				<dt>여러 개 파일 : 최대 20MB, 최대 20개</dt>
			</dl>
		</li>
	</ul>

</div>

<div class="footer">
	<button type="button" id="saveGoodsImg" class="resp_btn active size_XL">저장</button>
	<button type="button" class="resp_btn v3 size_XL" onClick="closeImageMultiDialog()">취소</button>
</div>


<div id="goods_resize_formlay" class="hide"><?php $this->print_("goods_resize_form",$TPL_SCP,1);?></div>