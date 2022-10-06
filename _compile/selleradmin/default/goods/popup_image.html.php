<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/popup_image.html 000016756 */  $this->include_("defaultScriptFunc");
$TPL_goodsImageSize_1=empty($TPL_VAR["goodsImageSize"])||!is_array($TPL_VAR["goodsImageSize"])?0:count($TPL_VAR["goodsImageSize"]);
$TPL_options_1=empty($TPL_VAR["options"])||!is_array($TPL_VAR["options"])?0:count($TPL_VAR["options"]);?>
<!--  html5 upload -->
<script type="text/javascript" src="/app/javascript/plugin/jquery_fileupload/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery_fileupload/jquery.fileupload.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/browsercheck.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/image.uploader.js?dummy=<?php echo date('TmdHis')?>"></script>


<script type="text/javascript">
var arrGoodsImage = new Array();
<?php if($TPL_goodsImageSize_1){$TPL_I1=-1;foreach($TPL_VAR["goodsImageSize"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
arrGoodsImage[<?php echo $TPL_I1?>] = '<?php echo $TPL_K1?>';
<?php }}?>

var _mockdata;
var imageMultiLayId 	= "set_popup_image_lay";
var goodsImageTableObj 	= $('#goodsImageTable .goodsImageDetail');
$(function(){

	var uploadCallback = function(res){
		if(res.status == false){
			if(res.msg) alert(res.msg);
			else alert("상품 사진 업로드 실패!");
		}else{
			var result = imgUploadEvent(this, res, '','', {});
			if(result.status == true){
				$("input[name='filedata']").attr("name","uploadImg");
			}
		}
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////
	// image uploader
	$('#'+imageMultiLayId+' #progress').hide();
	var uploader = fileuploader.select();
	if( uploader.isSwf ) {
		$('#'+imageMultiLayId+' #file_image').hide();
		uploader.script 		= krdomain+'/selleradmin/goods_process/upload_file';	
		uploader.scriptData		= {'division':'<?php echo $TPL_VAR["sc"]["division"]?>','idx':<?php echo $TPL_VAR["sc"]["idx"]?>};
		uploader.multi 			= false;
		uploader.shopname 		= "single";
		$("#"+imageMultiLayId+" #uploader").uploadify(uploader);
	}else {
<?php if($TPL_VAR["sc"]["division"]=="all"){?>
		uploadConfig.addData 	= "filemode=goods"; // 사진 사이즈별 추가 생성
<?php }?>
		uploadConfig.file_param = "filedata";
		$('#goodsImage').createAjaxFileUpload(uploadConfig, uploadCallback);
	}

		
	///////////////////////////////////////////////////////////////////////////////////////////////////
	$("#"+imageMultiLayId+" .setImageSize").on("click",function(){
		//$("#"+imageMultiLayId+" .save_image_input").removeAttr("disabled").removeAttr("readonly");
		openDialog("사이즈 확인", "goods_resize_formlay", {'width':550,'height':500,'show':'fade','hide' : 'fade'});
	});
	//사이즈변경 기본값 세팅
	$("#goods_resize_formlay .setDefaultValue").on("click",function(){
		var defaultSize = {'largeImage':'600',
							'viewImage':'800',
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

		var goodsSeq	= "<?php echo $TPL_VAR["sc"]["no"]?>";
		var division	= "<?php echo $TPL_VAR["sc"]["division"]?>";
		var idx			= "<?php echo $TPL_VAR["sc"]["idx"]?>";
		var uploadImg	= $("input[name='uploadImg']").val();
		var fileColor	= $("input:radio[name='fileColorradio']:checked").val();
		var ImgLabel	= $("#goodsImgLabel").val();
		var regist_date	= "<?php echo $TPL_VAR["data_goods"]["regist_date"]?>";
		var provider_seq= "<?php echo $TPL_VAR["data_goods"]["provider_seq"]?>";

		// 매칭컬러 여부 재확인
		if(!$("#"+imageMultiLayId+" #fileOptionAble").is(":checked")) fileColor = '';

		// seq가 넘어왔을땐 실시간 저장
		if(goodsSeq){
			if(!uploadImg && division == 'all'){
				alert('변경된 이미지 정보가 없습니다.');
				//window.self.close();
				return;
			}
			loadingStart();
			$.ajax({
				type: "post",
				url: "../goods_process/goods_img_upload",
				dataType : 'json',
				data: {
					'goodsSeq':goodsSeq,
					'idx':idx,
					'uploadImg':uploadImg,
					'fileColorradio':fileColor,
					'ImageGoodsLabel':ImgLabel,
					'division':division,
					'regist_date':regist_date,
					'provider_seq':provider_seq
				},
				success: function(result){
					if(division == 'all'){
						$.each(result,function(num,val){
							if(val){
								$("input[name='"+arrGoodsImage[num]+"GoodsImage[]']",goodsImageTableObj).eq(idx).closest('td').find('.desc').removeClass("desc").addClass("goods"+arrGoodsImage[num]).addClass("view hand blue");
								$("input[name='"+arrGoodsImage[num]+"GoodsImage[]']",goodsImageTableObj).eq(idx).val( val );
							}
						});
						index_img(idx, 'view', "<?php echo $TPL_VAR["goodsImageSize"]['view']['name']?>");
					}else{
						$("input[name='"+division+"GoodsImage[]']",goodsImageTableObj).eq(idx).closest('td').find('.desc').removeClass("desc").addClass("goods"+division).addClass("view hand blue");
						if(result[0]){ // 이미지 있을때만 진행
							var each_img = result[0];
							$("input[name='"+division+"GoodsImage[]']",goodsImageTableObj).eq(idx).val(each_img);
						}
						$("input[name='"+division+"GoodsLabel[]']",goodsImageTableObj).eq(idx).val(ImgLabel);
						if(!ImgLabel) ImgLabel = '-';
						$("#goodsImgLabel_view").html(ImgLabel);
						chgFileColor(fileColor);
						index_img(idx, division, "<?php echo $TPL_VAR["goodsImageSize"][$TPL_VAR["sc"]["division"]]['name']?>");
					}

					alert('이미지 정보가 변경되었습니다.');
					closeDialog(imageMultiLayId);
					//window.self.close();
				}
			});
		}else{
			if(division == 'all'){
				if(uploadImg){
					for(var i=0;i<arrGoodsImage.length;i++){
						$("input[name='"+arrGoodsImage[i]+"GoodsImage[]']",goodsImageTableObj).eq(idx).closest('td').find('.desc').removeClass("desc").addClass("goods"+arrGoodsImage[i]).addClass("view hand blue");
						$("input[name='"+arrGoodsImage[i]+"GoodsImage[]']",goodsImageTableObj).eq(idx).val( uploadImg.replace('view',arrGoodsImage[i]) );
					}
					index_img(idx, 'view', "<?php echo $TPL_VAR["goodsImageSize"]['view']['name']?>");
				}
			}else{
				if(uploadImg){
					$("input[name='"+division+"GoodsImage[]']",goodsImageTableObj).eq(idx).closest('td').find('.desc').removeClass("desc").addClass("goods"+division).addClass("view hand blue");
					$("input[name='"+division+"GoodsImage[]']",goodsImageTableObj).eq(idx).val( uploadImg.replace('view',division) );
				}
				$("input[name='"+division+"GoodsLabel[]']",goodsImageTableObj).eq(idx).val(ImgLabel);
				if(!ImgLabel) ImgLabel = '-';
				$("#goodsImgLabel_view").html(ImgLabel);
				index_img(idx, division, "<?php echo $TPL_VAR["goodsImageSize"][$TPL_VAR["sc"]["division"]]['name']?>");
			}

			alert('이미지 정보가 변경되었습니다.');
			closeDialog(imageMultiLayId);
			//window.self.close();
		}
	});

<?php if($TPL_VAR["sc"]["division"]=='view'){?>
	addFileColorOption("<?php echo $TPL_VAR["sc"]["idx"]?>");
<?php }?>

	// 미리보기 셋팅 :: 2016-04-29 lwh
	var division 	= "<?php echo $TPL_VAR["sc"]["division"]?>";
	var old_label = '';
	if(division == 'all')	division = 'large';
	else	old_label = $("#goodsImgLabel_view").html();

	var old_img = $("input[name='"+division + "GoodsImage[]']").eq(<?php echo $TPL_VAR["sc"]["idx"]?>).val();
	if(old_img){
		var options = {'inpValue':false,'previewDel':true};
		imgUploadEvent("#goodsImage", "", "", old_img,options);	//등록된 이미지 미리보기
		//$(".preview-del").remove();	// 등록된 이미지 삭제 아이콘(x) 제거
	}
	if(old_label!='-'){
		$("#"+imageMultiLayId+" #goodsImgLabel").val(old_label);
	}
});

// 옵션 색상컷 사용여부 :: 2016-04-29 lwh
function fileColorOptionUse(){
	if($("input:checkbox[id='fileOptionAble']").is(":checked")) {
		$("input[name='fileColorradio']").removeAttr("disabled");
		$("#fileOptionTxt").removeClass("gray");
		$("#fileOptionValue").removeClass("gray");
	} else {
		$("input[name='fileColorradio']").attr("disabled","disabled");
		$("#fileOptionTxt").addClass("gray");
		$("#fileOptionValue").addClass("gray");
	}
}

// 옵션 색상컷 변경 :: 2016-04-29 lwh
function chgFileColor(ccolor){
	var idx = "<?php echo $TPL_VAR["sc"]["idx"]?>";
	goodsImageTableObj.find("tbody tr").eq(idx).find("input[name='goodsImageColor[]']").val(ccolor);
	if(ccolor){
		goodsImageTableObj.find("tbody tr").eq(idx).find(".fileColorTitle").html("<span style='display:inline-block;width:18px; height:18px; margin-top:0px; margin-left:2px; border:1px solid #e8e8e8; background-color:"+ccolor+";size:25px;'></span>");
		goodsImageTableObj.find("tbody tr").eq(idx).find(".fileColorTitle").css("color", ccolor);
	}else{
		goodsImageTableObj.find("tbody tr").eq(idx).find(".fileColorTitle").html("");
	}
	$("#filecolor").html(goodsImageTableObj.find("tbody tr").eq(idx).find(".fileColorTitle").clone());
}

// 옵션 색상컷 호출 :: 2016-04-29 lwh
function getColor() {
	var strColor = "";
	var chkColorArr= new Array();

<?php if($TPL_options_1){foreach($TPL_VAR["options"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["opts"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<?php if($TPL_V1["divide_newtype"][$TPL_K2]&&$TPL_V1["divide_newtype"][$TPL_K2]=='color'){?>
				if (jQuery.inArray( "<?php echo $TPL_V1["color"]?>" , chkColorArr ) == -1) {
					var whitecolorborder = " style='display:inline-block;width:18px; height:18px; border:1px solid #ccc; background-color:<?php echo $TPL_V1["color"]?>; cursor:pointer;' ";
					strColor += "<label class='resp_radio'><input type=\"radio\" disabled=\"disabled\" name=\"fileColorradio\" value=\"<?php echo $TPL_V1["color"]?>\" /> "+"<?php echo $TPL_V2?>";
					strColor += " <span style='width:18px; height:18px; margin-top:-2px; margin-left:2px; border:1px solid #e8e8e8; background-color:<?php echo $TPL_V1["color"]?>;display:inline-block'></span></label>&nbsp;&nbsp;&nbsp;";
					chkColorArr.push("<?php echo $TPL_V1["color"]?>");
				}
<?php }?>
<?php }}?>
<?php }}?>
	return strColor;
}

// 색상 상품컷 매칭 :: 2016-04-29 lwh
function addFileColorOption(idx){
	var imgKind 			= "<?php echo $TPL_VAR["sc"]["division"]?>";
	var isColor = false;
	var fileOptionValueHtm = "";
	var colorStr = getColor();
	var idx 				= "<?php echo $TPL_VAR["sc"]["idx"]?>";

	if (colorStr) {
		isColor = true;
		fileOptionValueHtm += colorStr;
	}

	if (isColor) {
		$("#fileOptionAble").show();
		$("#fileOptionTxtAdd").show();
		$("#fileOptionTxt").show();
		$("#fileOptionValue").show();
		$("#fileNoOptionTxt").hide();
		$("#fileOptionValue").html(fileOptionValueHtm);
		$(".color-option-checkbox").show();
	} else {
		$("#fileOptionAble").hide();
		$("#fileNoOptionTxt").show();
		$("#fileOptionTxt").hide();
		$("#fileOptionValue").hide();
		$("#fileOptionValue").html("");
		$(".color-option-checkbox").hide();
	}

	var ccolor = $("#goodsImageTable tbody tr").eq(idx).find("input[name='goodsImageColor[]']").val();
	try {
		if(ccolor) {
			if (imgKind == "view") {
				$("#fileOptionAble").attr("disabled", false);
				$("#fileOptionAble").attr("checked", "checked");
				$("#fileOptionTxt").removeClass("gray");
				$("#fileOptionValue").removeClass("gray");
				$("input[name='fileColorradio']").removeAttr("disabled");

				// 컬러가 소문자일 경우
				if ($("input[name='fileColorradio'][value='"+ccolor.toLowerCase()+"']").length) {
					$("input[name='fileColorradio'][value='"+ccolor.toLowerCase()+"']").attr("checked", "checked");
				}

				// 컬러가 대문자일 경우
				if ($("input[name='fileColorradio'][value='"+ccolor.toUpperCase()+"']").length) {
					$("input[name='fileColorradio'][value='"+ccolor.toUpperCase()+"']").attr("checked", "checked");
				}
			} else {
				$("#fileOptionAble").removeAttr("checked");
				$("#fileOptionAble").attr("disabled", true);
			}
		} else {
			if (imgKind == "view") {
				if($("input:checkbox[id='fileOptionAble']").is(":checked")) {
					$("input[name='fileColorradio']").removeAttr("disabled");
				} else {
					$("#fileOptionAble").removeAttr("disabled");
					$("input[name='fileColorradio']").attr("disabled","disabled");
				}
			} else {
				$("#fileOptionAble").removeAttr("checked");
				$("#fileOptionAble").attr("disabled", true);
			}
		}
	} catch (e) {
		alert(e);
		if (imgKind == "view") {
			$("#fileOptionAble").removeAttr("disabled");
			$("input[name='fileColorradio']").removeAttr("disabled");
		} else {
			$("#fileOptionAble").removeAttr("checked");
			$("#fileOptionAble").attr("disabled", true);
		}
	}
}

function userKeyPress() {
	//입력받은 key가 엔터시 (key 값이 13)
	if ( window.event.keyCode == 13 ) {
		//아무런 작동값이 없는 0으로 강제 변환
		window.event.keyCode = 0;
	}else{
		return;
	}
}
</script>
<?php echo defaultScriptFunc()?></head>

<div class="content webftpFormItem">
<?php if($TPL_VAR["sc"]["division"]=='all'){?>
	<form name="upload_img_frm" id="upload_img_frm">
	<div class="right">
		<button type="button" class="resp_btn setImageSize">사이즈 확인</button>
	</div>
<?php }?>
	<table class="table_basic mt5">
	<colgroup>
		<col width="25%">
		<col width="75%">
	</colgroup>
		<tr>
		<th>사진 첨부</th>
		<td>
<?php if($TPL_VAR["sc"]["division"]!='all'){?>
			<div class="preview_image"><span class="nothing">등록된 이미지가 없습니다.</span></div>
<?php }?>
			<label class="resp_btn v2 mt0"><input type="file" id="goodsImage" name="Filedata_tmp" accept="image/x-png,image/gif,image/jpeg">파일선택</label>
			<input type="text" class="webftpFormItemInput" name="filedata" value="" size="30" maxlength="255" />									
			</td>
		</tr>
<?php if($TPL_VAR["sc"]["division"]=='all'){?>
		<tr>
		<th>미리보기</th>
		<td>
			<div class="preview_image"><span class="nothing">등록된 이미지가 없습니다.</span></div>
			</td>
		</tr>
<?php }?>
<?php if($TPL_VAR["sc"]["division"]!='all'){?>
		<tr>
		<th>레이블</th>
		<td>
				<input type="text" name="goodsImgLabel" id="goodsImgLabel" value="" />
			</td>
		</tr>
<?php }?>
<?php if($TPL_VAR["sc"]["division"]=='view'){?>
		<tr>
		<th>색상</th>
		<td valign="top">
				<p class="color-option-checkbox" style="padding-bottom:5px">
				<label class="resp_checkbox"><input type="checkbox" value="1" id="fileOptionAble" onclick="fileColorOptionUse()" class="hide" />
				 상품상세페이지에서 색상 선택(또는 마우스 오버) 시 → 매칭된 상품 이미지 노출</label>
				</p>
			<p id="fileNoOptionTxt" style="line-height:25px;">본 이미지에 매칭된 색상 없음</p>
				<p id="fileOptionTxt" class="gray hide">본 이미지에 해당되는 색상을 아래에서 선택하세요.</p>
				<p id="fileOptionValue" class="gray hide pdt5"></p>
				<p id="fileOptionTxtAdd" class="gray hide" style="padding:10px 0px 0px 0px">※ 현재 저장된 색상(특수옵션) 기준입니다.<br />※ 색상(특수옵션)을 수정한 경우 상품저장 후 다시 상품컷에 색상을 매칭하세요.</p>
			</td>
		</tr>
<?php }?>
		</table>
<?php if($TPL_VAR["sc"]["division"]!='all'){?>
	<ul class='bullet_hyphen resp_message'>
		<li>개별 등록 시 설정된 사이즈로 자동 리사이징 되지 않습니다.</li>
		<li>움직이는 GIF 파일은 반드시 개별 등록해야 정상 작동합니다.</li>
		<li>색상 매칭을 원하는 경우, 특수 옵션의 색상을 생성 해주세요. 색상 매칭 후 상품 상세 페이지에서 색상 선택(또는 마우스오버)시 매칭된 상품 이미지를 노출할 수 있습니다</li>
	</ul>
<?php }?>
</div>
<div class="footer">
	<button type="button" id="saveGoodsImg" class="resp_btn active size_XL">저장</button>
	<button type="button" class="resp_btn v3 size_XL" onClick="closeDialog('set_popup_image_lay')">취소</button>
</div>

<div id="goods_resize_formlay" class="hide"><?php $this->print_("goods_resize_form",$TPL_SCP,1);?></div>