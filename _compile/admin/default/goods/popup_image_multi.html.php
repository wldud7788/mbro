<?php /* Template_ 2.2.6 2022/05/17 12:31:51 /www/music_brother_firstmall_kr/admin/skin/default/goods/popup_image_multi.html 000010021 */  $this->include_("defaultScriptFunc");
$TPL_goodsImageSize_1=empty($TPL_VAR["goodsImageSize"])||!is_array($TPL_VAR["goodsImageSize"])?0:count($TPL_VAR["goodsImageSize"]);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $TPL_VAR["config_basic"]["shopName"]?> - 여러 컷 일괄등록</title>
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

<!--  html5 image multi upload -->
<script type="text/javascript" src="/app/javascript/plugin/jquery_fileupload/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery_fileupload/jquery.fileupload.js"></script>
<script type="text/javascript" src="/app/javascript/js/browsercheck.js"></script>
<script type="text/javascript" src="/app/javascript/js/image.uploader.js"></script>



<script type="text/javascript">
var arrGoodsImage = new Array();
<?php if($TPL_goodsImageSize_1){$TPL_I1=-1;foreach($TPL_VAR["goodsImageSize"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
arrGoodsImage[<?php echo $TPL_I1?>] = '<?php echo $TPL_K1?>';
<?php }}?>
	var goodsImageTableObj = $('#goodsImageTable',window.opener.document);
$(function(){
	
	///////////////////////////////////////////////////////////////////////////////////////////////////
	// image uploader
	$('#progress').hide();
	var uploader = fileuploader.select();
	uploader.shopname = "multi";
	if( uploader.isSwf ) {
		$('#file_image').hide();
		$("#uploader").uploadify(uploader);
	}else {
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
		// 업로드 이미지 검사
		var img_len = $("input[name='uploadImg[]']").length;
		if(img_len < 1){
			alert('찾아보기를 통해 이미지를 먼저 첨부해주세요.');
			return;
		}

		$('#goodsImageTable tbody tr.no_goods_image', window.opener.document).remove();
		var goodsSeq	= "<?php echo $_GET["no"]?>";
		var regist_date	= "<?php echo $TPL_VAR["data_goods"]["regist_date"]?>";
		var provider_seq= "<?php echo $TPL_VAR["data_goods"]["provider_seq"]?>";
		var serialize	= $("form#upload_img_frm").serialize();
		var cutnum		= $('#goodsImageTable tbody tr',window.opener.document).length;
		var params		= 'type=multi&division=all&goodsSeq='+goodsSeq+'&regist_date='+regist_date+'&provider_seq='+provider_seq+'&idx='+cutnum+'&'+serialize;

		// seq가 넘어왔을땐 실시간 저장
		if(goodsSeq){
			loadingStart();
			$.ajax({
				type: "post",
				url: "/admin/goods_process/goods_img_upload",
				data: params,
				dataType : 'json',
				success: function(result){
					var flag = false;					
					if(result[0]){
						$.each(result[0],function(num,val){
							$("form #goodsImageAdd",window.opener.document).click();
							var idx	= $('#goodsImageTable tbody tr',window.opener.document).length;
							idx = parseInt(idx-1);
							if(val){
								for(var i=0;i<arrGoodsImage.length;i++){
									$('.goods'+arrGoodsImage[i],goodsImageTableObj).eq(idx).removeClass("desc").addClass("hand blue");
									$("input[name='"+arrGoodsImage[i]+"GoodsImage[]']",goodsImageTableObj).eq(idx).val( val.replace('large',arrGoodsImage[i]) );
									flag = true;
								}
							}
						});
					}
					if(flag){
						window.opener.default_img();
						alert('이미지가 저장되었습니다.');
						window.self.close();
					}else{
						alert('이미지가 업로드가 실패되었습니다.');
						window.self.close();
					}
				}
			});
		}else{
			$("input[name='uploadImg[]']").each(function(idx,obj){
				done($(obj).val());
			});
			window.opener.default_img();
			alert('이미지가 임시저장 되었습니다.');
			window.self.close();
		}
	});
});
function userKeyPress() {
	//입력받은 key가 엔터시 (key 값이 13)
	if ( window.event.keyCode == 13 ) {
		//아무런 작동값이 없는 0으로 강제 변환
		window.event.keyCode = 0;
	}else{
		return;
	}
}

function done(val) {
	$('#goodsImageTable tbody tr.no_goods_image', window.opener.document).remove();
	$("form #goodsImageAdd",window.opener.document).click();
	var idx = $('#goodsImageTable tbody tr',window.opener.document).length;
	idx = parseInt(idx-1);
	for(var i=0;i<arrGoodsImage.length;i++){
		$('.goods'+arrGoodsImage[i],goodsImageTableObj).eq(idx).removeClass("desc").addClass("hand blue");
		$("input[name='"+arrGoodsImage[i]+"GoodsImage[]']",goodsImageTableObj).eq(idx).val( val.replace('view',arrGoodsImage[i]) );
	}
}
</script>

<?php echo defaultScriptFunc()?></head>
<body onkeypress="userKeyPress();" >
<div class="wrapper">
	<div class="header">
		<h1>여러 컷 일괄등록</h1>
		<p><a href="javascript:void(0);" onclick="window.self.close();" title="닫기" class="close"> </a></p>
	</div>
	<div class="body">
		
		<form name="upload_img_frm" id="upload_img_frm">
		<ul class="alert">
			<div id="goods_resize_formlay" ><?php $this->print_("goods_resize_form",$TPL_SCP,1);?></div>
			<li>				
				<div class="image-upload" >
					<label for="uploader" id="file_image">
						<img src="/app/javascript/plugin/jquploadify/uploadify-search.gif"/>
					</label>
					<!--<input type="file" id="uploader" name="Filedata" style="display:none" accept="image/x-png,image/gif,image/jpeg" multiple/>-->
					<input type="file" id="uploader" name="Filedata" style="display:none" multiple/>
				</div>
			</li>
			
			<!-- li id="imgtb" class="hide">
				<B>미리보기 :</B>
				<div id="img_viewer"></div>
			</li-->
			<!--  html5 uploader progress -->
			<div id="progress" class="progress">
		       	<div class="progress-bar progress-bar-success"></div>
		   	</div>
		   	
			<li id="imgtb" class="hide">
				<B>미리보기 :</B>
				<div id="img_viewer"></div>
			</li>
		</ul>		
		</form>

		<div class="center" style="left:50%;bottom:10px;margin-left:-50px;position:fixed;">
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