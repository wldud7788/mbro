<?php /* Template_ 2.2.6 2022/05/17 12:31:51 /www/music_brother_firstmall_kr/admin/skin/default/goods/popup_image.html 000019742 */  $this->include_("defaultScriptFunc");
$TPL_goodsImageSize_1=empty($TPL_VAR["goodsImageSize"])||!is_array($TPL_VAR["goodsImageSize"])?0:count($TPL_VAR["goodsImageSize"]);
$TPL_options_1=empty($TPL_VAR["options"])||!is_array($TPL_VAR["options"])?0:count($TPL_VAR["options"]);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $TPL_VAR["config_basic"]["shopName"]?> -  <?php if($_GET["division"]=='all'){?>일괄등록<?php }else{?>개별등록<?php }?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layout.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/buttons.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/boardnew.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/page.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/jqueryui/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/jqueryui/black-tie/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/poshytip/style.css" />
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/editor/css/goods_image_popup.css" />
<?php if($TPL_VAR["browser_info"]['nickname']=="Safari"){?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php }else{?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquploadify/swfobject.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquploadify/jquery.uploadify.v2.1.4.js"></script>
<?php }?>
<script type="text/javascript" src="/app/javascript/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.poshytip.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.activity-indicator-1.0.0.min.js"></script>
<script type="text/javascript" src="/app/javascript/js/dev-tools.js"></script>
<script type="text/javascript" src="/app/javascript/js/common.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('YmdHis')?>"></script>

<script type="text/javascript">
//<![CDATA[
//한글도메인체크@2013-03-12
var fdomain = document.domain;
var gl_protocol = '<?php echo get_connet_protocol()?>';
var krdomain = gl_protocol+'<?php echo $TPL_VAR["config_system"]["subDomain"]?>';
var kordomainck = false;
var get_division = '<?php echo $_GET["division"]?>';
var get_idx 	= <?php echo $_GET["idx"]?>;
for(i=0; i<fdomain.length; i++){
 if (((fdomain.charCodeAt(i) > 0x3130 && fdomain.charCodeAt(i) < 0x318F) || (fdomain.charCodeAt(i) >= 0xAC00 && fdomain.charCodeAt(i) <= 0xD7A3)))
{
	kordomainck = true;
	break;
}
}
if( !kordomainck ){
krdomain = '';
}
//]]>
</script>

<!--  html5 upload -->
<script type="text/javascript" src="/app/javascript/plugin/jquery_fileupload/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery_fileupload/jquery.fileupload.js"></script>
<script type="text/javascript" src="/app/javascript/js/browsercheck.js"></script>
<script type="text/javascript" src="/app/javascript/js/image.uploader.js?dummy=<?php echo date('TmdHis')?>"></script>


<script type="text/javascript">
var arrGoodsImage = new Array();
<?php if($TPL_goodsImageSize_1){$TPL_I1=-1;foreach($TPL_VAR["goodsImageSize"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
arrGoodsImage[<?php echo $TPL_I1?>] = '<?php echo $TPL_K1?>';
<?php }}?>

var _mockdata;

$(function(){
	var goodsImageTableObj = $('#goodsImageTable',window.opener.document);

	///////////////////////////////////////////////////////////////////////////////////////////////////
	// image uploader
	$('#progress').hide();
	var uploader = fileuploader.select();
	uploader.shopname = "single";
	if( uploader.isSwf ) {
		$('#file_image').hide();
		uploader.script 		= krdomain+'/admin/goods_process/upload_file';	
		uploader.scriptData		= {'division':'<?php echo $_GET["division"]?>','idx':<?php echo $_GET["idx"]?>};
		uploader.multi 			= false;
		$("#uploader").uploadify(uploader);
	}else {
		uploader.url	 		= krdomain+'/admin/goods_process/upload_file';
		uploader.formData		= {'division':'<?php echo $_GET["division"]?>','idx':<?php echo $_GET["idx"]?>};
		
		$("#uploader").fileupload(uploader);
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////


	/* 상품이미지 설정 저장 */
	$("#save_image_config_ck").click(function(){
		if($(this).attr("checked") == "checked" ) {
			$(".save_image_input").removeAttr("disabled").removeAttr("readonly");
			$("button.save_image_config").parent().removeClass("gray").addClass("cyanblue");
		}else{
			$(".save_image_input").attr("disabled","disabled").attr("readonly","readonly");
			$("button.save_image_config").parent().addClass("gray").removeClass("cyanblue");
		}
	});
	$(".save_image_config").click(function(){
		if($("#save_image_config_ck").attr("checked") == "checked" ) save_image_config();
	});

	/* 이미지 및 설정 최종저장 :: 2016-04-29 lwh */
	$("#saveGoodsImg").bind('click',function(){

		var goodsSeq	= "<?php echo $_GET["no"]?>";
		var division	= "<?php echo $_GET["division"]?>";
		var idx			= "<?php echo $_GET["idx"]?>";
		var uploadImg	= $("input[name='uploadImg']").val();
		var fileColor	= $("input:radio[name='fileColorradio']:checked").val();
		var ImgLabel	= $("#goodsImgLabel").val();
		var regist_date	= "<?php echo $TPL_VAR["data_goods"]["regist_date"]?>";
		var provider_seq= "<?php echo $TPL_VAR["data_goods"]["provider_seq"]?>";

		// 매칭컬러 여부 재확인
		if(!$("#fileOptionAble").is(":checked")) fileColor = '';

		// seq가 넘어왔을땐 실시간 저장
		if(goodsSeq){
			if(!uploadImg && division == 'all'){
				alert('변경된 이미지 정보가 없습니다.');
				window.self.close();
				return;
			}
			loadingStart();
			$.ajax({
				type: "post",
				url: "/admin/goods_process/goods_img_upload",
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
						window.opener.index_img(idx, 'view', "<?php echo $TPL_VAR["goodsImageSize"]['view']['name']?>");
					}else{
						$("input[name='"+division+"GoodsImage[]']",goodsImageTableObj).eq(idx).closest('td').find('.desc').removeClass("desc").addClass("goods"+division).addClass("view hand blue");
						if(result[0]){ // 이미지 있을때만 진행
							var each_img = result[0];
							$("input[name='"+division+"GoodsImage[]']",goodsImageTableObj).eq(idx).val(each_img);
						}
						$("input[name='"+division+"GoodsLabel[]']",goodsImageTableObj).eq(idx).val(ImgLabel);
						if(!ImgLabel) ImgLabel = '-';
						$("#goodsImgLabel_view",window.opener.document).html(ImgLabel);
						chgFileColor(fileColor);
						window.opener.index_img(idx, division, "<?php echo $TPL_VAR["goodsImageSize"][$_GET["division"]]['name']?>");
					}

					alert('이미지 정보가 변경되었습니다.');
					window.self.close();
				}
			});
		}else{
			if(division == 'all'){
				if(uploadImg){
					for(var i=0;i<arrGoodsImage.length;i++){
						$("input[name='"+arrGoodsImage[i]+"GoodsImage[]']",goodsImageTableObj).eq(idx).closest('td').find('.desc').removeClass("desc").addClass("goods"+arrGoodsImage[i]).addClass("view hand blue");
						$("input[name='"+arrGoodsImage[i]+"GoodsImage[]']",goodsImageTableObj).eq(idx).val( uploadImg.replace('view',arrGoodsImage[i]) );
					}
					window.opener.index_img(idx, 'view', "<?php echo $TPL_VAR["goodsImageSize"]['view']['name']?>");
				}
			}else{
				if(uploadImg){
					$("input[name='"+division+"GoodsImage[]']",goodsImageTableObj).eq(idx).closest('td').find('.desc').removeClass("desc").addClass("goods"+division).addClass("view hand blue");
					$("input[name='"+division+"GoodsImage[]']",goodsImageTableObj).eq(idx).val( uploadImg.replace('view',division) );
				}
				$("input[name='"+division+"GoodsLabel[]']",goodsImageTableObj).eq(idx).val(ImgLabel);
				if(!ImgLabel) ImgLabel = '-';
				$("#goodsImgLabel_view",window.opener.document).html(ImgLabel);
				window.opener.index_img(idx, division, "<?php echo $TPL_VAR["goodsImageSize"][$_GET["division"]]['name']?>");
			}

			alert('이미지 정보가 변경되었습니다.');
			window.self.close();
		}
	});

<?php if($_GET["division"]=='view'){?>
	addFileColorOption("<?php echo $_GET["idx"]?>");
<?php }?>

	// 미리보기 셋팅 :: 2016-04-29 lwh
	var division = "<?php echo $_GET["division"]?>";
	var old_label = '';
	if(division == 'all')	division = 'view';
	else	old_label = $("#goodsImgLabel_view",window.opener.document).html();
	var old_img = opener.document.getElementsByName( division + 'GoodsImage[]')[<?php echo $_GET["idx"]?>].value;
	if(old_img){
		$("#imgView").html('<img src="'+old_img+'?'+Math.floor(Math.random()*(10000*10000))+'" height="50" class="pd5" />');
	}
	if(old_label!='-'){
		$("#goodsImgLabel").val(old_label);
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
	var idx = "<?php echo $_GET["idx"]?>";
	$("#goodsImageTable tbody tr",opener.document).eq(idx).find("input[name='goodsImageColor[]']").val(ccolor);
	if(ccolor){
		$("#goodsImageTable tbody tr",opener.document).eq(idx).find(".fileColorTitle").html("<span style='width:30px; height:30px; margin-top:2px; margin-left:2px; border:0px solid #e8e8e8; color:"+ccolor+";size:25px;'><font style='display:inline-block;width:18px; height:18px; border:1px solid #ccc; background-color:"+ccolor+"; cursor:pointer;' >■</font></span>");
		$("#goodsImageTable tbody tr",opener.document).eq(idx).find(".fileColorTitle").css("color", ccolor);
	}else{
		$("#goodsImageTable tbody tr",opener.document).eq(idx).find(".fileColorTitle").html("");
	}
	$("#filecolor",window.opener.document).html($("#goodsImageTable tbody tr",opener.document).eq(idx).find(".fileColorTitle").clone());
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
					strColor += "<label><input type=\"radio\" disabled=\"disabled\" name=\"fileColorradio\" value=\"<?php echo $TPL_V1["color"]?>\" /> "+"<?php echo $TPL_V2?>"+" <span style='width:30px; height:30px; margin-top:2px; margin-left:2px; border:0px solid #e8e8e8; color:<?php echo $TPL_V1["color"]?>;size:25px;'><font "+whitecolorborder+" >■</font></span></label>&nbsp;&nbsp;&nbsp;";
					chkColorArr.push("<?php echo $TPL_V1["color"]?>");
				}
<?php }?>
<?php }}?>
<?php }}?>
	return strColor;
}

// 색상 상품컷 매칭 :: 2016-04-29 lwh
function addFileColorOption(idx){
	var imgKind = "<?php echo $_GET["division"]?>";
	var isColor = false;
	var fileOptionValueHtm = "";
	var colorStr = getColor();
	var idx = "<?php echo $_GET["idx"]?>";

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

	var ccolor = $("#goodsImageTable tbody tr",opener.document).eq(idx).find("input[name='goodsImageColor[]']").val();
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
<style type="text/css">
.uploadifyQueue { left: 0px; width: 100%; bottom: 50px; position: fixed; }
</style>
<?php echo defaultScriptFunc()?></head>
<body onkeypress="userKeyPress();" >
<div class="wrapper">
	<div class="header">
		<h1><?php if($_GET["division"]=='all'){?>일괄등록<?php }else{?>개별등록<?php }?></h1>
		<p><a href="javascript:void(0);" onclick="window.self.close();" title="닫기" class="close"> </a></p>
	</div>
	<div class="body pdt10">
<?php if($_GET["division"]=='all'){?><div id="goods_resize_formlay" ><?php $this->print_("goods_resize_form",$TPL_SCP,1);?></div><?php }?>

		<table class="pdl10" border="0">
		<tr>
			<td style="width:60px">
				<div style="display: inline-block; vertical-align: top; padding-top: 5px">&bull; 이미지</div>
			</td>
			<td style="width:15px;"> : </td>
			<td colspan="2">
				<!-- input type="file" id="uploader" /-->
				<label for="uploader" id="file_image">
					<img src="/app/javascript/plugin/jquploadify/uploadify-search.gif"/>
				</label>
				<input type="file" id="uploader" name="Filedata" style="display:none" accept="image/x-png,image/gif,image/jpeg" />
				
				<input type="hidden" name="uploadImg" value="" />
				<span id="imgView"></span>
				
			    <!--  html5 uploader progress -->
				<div id="progress" class="progress">
					<div class="progress-bar progress-bar-success"></div>
		         </div> 
				
			</td>
		</tr>
		<tr>
			<td></td>
			<td colspan="3" height="50px">
<?php if($_GET["division"]!='all'){?>
				<p class="gray">※ 개별 등록 시 설정된 사이즈로 자동 리사이징 되지 않습니다.</p>
				<p class="gray">※ 움직이는 GIF’파일은 반드시 개별등록 해야 정상적으로 움직입니다.</p>
<?php }?>
			</td>
		</tr>
<?php if($_GET["division"]!='all'){?>
		<tr>
			<td>&bull; 레이블</td>
			<td> : </td>
			<td colspan="2">
				<input type="text" name="goodsImgLabel" id="goodsImgLabel" value="" />
			</td>
		</tr>
<?php }?>
<?php if($_GET["division"]=='view'){?>
		<tr>
			<td class="pdt10" valign="top">&bull; 색상</td>
			<td class="pdt10" valign="top"> : </td>
			<td class="pdt5" colspan="2" valign="top">
				<p class="color-option-checkbox" style="padding-bottom:5px">
					<label><input type="checkbox" value="1" id="fileOptionAble" onclick="fileColorOptionUse()" class="hide" /> 상품상세페이지에서 색상 선택(또는 마우스 오버) 시 → 매칭된 상품 이미지 노출</label>
				</p>
				<p id="fileNoOptionTxt" style="line-height:25px;">현재 이 상품은 색상(특수옵션)이 없습니다.<br/>우선 색상(특수옵션)을 생성하고 상품저장 후 다시 상품컷에 색상을 매칭하세요.<br/>매칭이 되면 상품상세페이지에서 색상 선택(또는 마우스오버) 시 → 매칭된 상품 이미지 노출</p>
				<p id="fileOptionTxt" class="gray hide">본 이미지에 해당되는 색상을 아래에서 선택하세요.</p>
				<p id="fileOptionValue" class="gray hide pdt5"></p>
				<p id="fileOptionTxtAdd" class="gray hide" style="padding:10px 0px 0px 0px">※ 현재 저장된 색상(특수옵션) 기준입니다.<br />※ 색상(특수옵션)을 수정한 경우 상품저장 후 다시 상품컷에 색상을 매칭하세요.</p>
			</td>
		</tr>
<?php }?>
		</table>
		<div class="center" style="left:50%;margin-left:-50px;position:fixed;margin-top:20px;">
			<span class="btn large cyanblue"><button type="button" id="saveGoodsImg" style="width:100px;">저장</button></span>
		</div>
	</div>
</div>
<div id="openDialogLayer" class="hide">
	<div align="center" id="openDialogLayerMsg"></div>
</div>
<div id="ajaxLoadingLayer" class="hide"></div>
</body>
</html>