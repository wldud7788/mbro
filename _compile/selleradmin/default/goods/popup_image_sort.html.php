<?php /* Template_ 2.2.6 2022/05/17 12:29:11 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/popup_image_sort.html 000010256 */  $this->include_("defaultScriptFunc");
$TPL_goodsImageSize_1=empty($TPL_VAR["goodsImageSize"])||!is_array($TPL_VAR["goodsImageSize"])?0:count($TPL_VAR["goodsImageSize"]);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $TPL_VAR["config_basic"]["shopName"]?> - 순서변경 및 삭제</title>
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
<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.poshytip.min.js"></script>
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
<script type="text/javascript">
var arrGoodsImage = new Array();
<?php if($TPL_goodsImageSize_1){$TPL_I1=-1;foreach($TPL_VAR["goodsImageSize"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
arrGoodsImage[<?php echo $TPL_I1?>] = '<?php echo $TPL_K1?>';
<?php }}?>

var _mockdata;

$(function(){
	var goodsImageTableObj = $('#goodsImageTable',window.opener.document);

	// 기본 이미지정보 추출 :: 2016-05-03 lwh
	var img_flag = false;
	$("input[name='viewGoodsImage[]']",goodsImageTableObj).each(function(idx,obj){
		var img_view	= $(obj).val();
		var cut_number	= idx + 1;
		var img_list = '<tr><td class="its-td-align center"><input type="hidden" name="cut_number[]" value="'+cut_number+'" /><span class="btn-minus"><button type="button" class="goodsImageDel"></button></span></td>';
		img_list += '<td class="its-td-align center" nowrap><img src="/admin/skin/default/images/common/icon_move.gif"></td>';
		img_list += '<td class="its-td-align center"><img src="'+img_view+'" height="30px" ></td></tr>';
		img_flag = true;
		$("#img_body").append(img_list);
	});
	if(img_flag) $("#noimg").remove();
	// 상품컷 순서변경 :: 2016-05-03 lwh
	$("#img_body").sortable({
		items:'tr',
		out: function( event, ui ) {

		}
	});

	// 상품컷 삭제 :: 2016-05-03 lwh
	$(".goodsImageDel").live("click",function(){
		var del_cut = $(this).closest('tr').find("input[name='cut_number[]']").val();
		$(this).closest('tr').remove();
		$("#sort_img_frm").append('<input type="hidden" name="del_cut[]" value="'+del_cut+'" />');
	});

	/* 이미지 및 설정 최종저장 :: 2016-04-29 lwh */
	$("#saveGoodsImg").bind('click',function(){
		var goodsSeq	= "<?php echo $_GET["no"]?>";

		// seq가 넘어왔을땐 실시간 저장
		if(goodsSeq){
			var serialize	= $("form#sort_img_frm").serialize();
			$.ajax({
				type: "post",
				url: "/selleradmin/goods_process/goods_img_sort",
				dataType : 'json',
				data: serialize,
				success: function(result){
					if(result.result){
						sortable_parent(result.cut_number,goodsImageTableObj);
						window.opener.default_img();
						alert('상품컷 정보가 재설정되었습니다.');
						window.self.close();
					}else{
						alert('상품컷 정보 재설정이 실패하였습니다.');
						window.self.close();
					}
				}
			});
		}else{
			var cut_arr = new Array();
			$("input[name='cut_number[]']").each(function(i){cut_arr[i] = $(this).val();});
			sortable_parent(cut_arr,goodsImageTableObj);
			window.opener.default_img();
			alert('상품컷 정보가 재설정되었습니다.');
			window.self.close();
		}
	});
});

// 상품페이지 정렬 재지정 :: 2016-05-03 lwh
function sortable_parent(obj,goodsImageTableObj){

	var first_clone = $(".cut-tr",goodsImageTableObj).eq(0).find('td.firstCol').clone();
	// 원본 버튼 삭제
	$(".cut-tr",goodsImageTableObj).eq(0).find('td.firstCol').remove();

	var cutnum_clone = null;
	var now_obj = null;
	var newcutnum = null;

	if(obj && obj != ''){
		$.each(obj,function(idx,old_cut){
			newcutnum = idx + 1;
			now_obj = $(".cutnum"+old_cut,goodsImageTableObj);
			cutnum_clone = now_obj.clone();
			now_obj.remove();
			cutnum_clone.removeClass('cutnum'+old_cut).addClass('newcutnum'+newcutnum);
			$("tbody",goodsImageTableObj).append(cutnum_clone);
		});
	}else{
		var headBtn = '<div class="hide" id="multiadd" style="display: block;">';
		headBtn += '<span class="btn large cyanblue"><button class="batchImageMultiRegist" style="width: 120px;" type="button">멀티일괄등록</button></span>';
		headBtn += '<span title="<b>멀티일괄등록이란?</b><br>쇼핑몰에서 상품 사진은 여러 페이지에서 보여지게 되며,<br>각각의 페이지에 알맞은 사이즈로 나타나야 합니다.<br>멀티일괄등록이란 입력된 일괄등록 사이즈 설정값을 기준으로 <br>필요한 사이즈의 상품 여러개의 사진을 한꺼번에 등록합니다.<br><br><b>일괄등록이란?</b><br>일괄등록이란 입력된 일괄등록 사이즈 설정값을 기준으로 <br>필요한 사이즈의 상품 사진을 한 번에 등록합니다.<br><br><b>개별등록이란?</b><br>일괄등록으로 등록된 상품사진을 개별적으로 변경하여 등록합니다." class="helpicon"></span>';
		headBtn += '</div>';
		headBtn += '<span class="btn-plus first_plus hide"><button id="goodsImageAdd" type="button"></button></span>';
		headBtn += '<div id="multitxt" style="display: none;">멀티등록<br>순서변경</div>';
		$('thead',goodsImageTableObj).find('th').eq(0).html(headBtn);
		var noimgtd	= '<tr class="no_goods_image"><td class="its-td-align center" colspan="10">등록된 사진이 없습니다. 멀티일괄등록 버튼을 클릭하여 사진을 편리하게 등록하세요</td></tr>';
		$('#goodsImageTable tbody',goodsImageTableObj).html(noimgtd);
		$('table#watermark_tb',goodsImageTableObj).hide();
		$('#goodsImagePriview',window.opener.document).hide();
	}

	// 순번 재지정
	var newcutnum = 0;
	$(".cut-tr",goodsImageTableObj).each(function(){
		newcutnum++;
		$('.cutnum'+newcutnum,goodsImageTableObj).remove();
		$('.newcutnum'+newcutnum,goodsImageTableObj).removeClass('newcutnum'+newcutnum).addClass('cutnum'+newcutnum);
	});

	// 원본 버튼 추가
	$(".cut-tr",goodsImageTableObj).eq(0).prepend(first_clone);
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
<body onkeypress="userKeyPress();" >
<div class="wrapper">
	<div class="header">
		<h1>순서변경 및 삭제</h1>
		<p><a href="javascript:void(0);" onclick="window.self.close();" title="닫기" class="close"> </a></p>
	</div>
	<div class="body">
		<ul class="alert">
			<li  style="list-style-type:disc;margin-left:20px;" >상품컷의 노출 순서는 아이콘을 마우스로 드래그하여 변경할 수 있습니다.</li>
			<li  style="list-style-type:disc;margin-left:20px;" >상품컷 삭제나 순서변경은 저장을 눌러야 최종 적용됩니다.</li>
		</ul>
		<form name="sort_img_frm" id="sort_img_frm">
		<input type="hidden" name="goodsSeq" value="<?php echo $_GET["no"]?>" />
		<div class="pd10">
			<table class="info-table-style" style="width:100%">
			<colgroup>
			<col width="20%" />
			<col width="20%" />
			<col width="" />
			</colgroup>
			<thead>
			<tr>
				<th class="its-th-align center">삭제</th>
				<th class="its-th-align center">순서변경</th>
				<th class="its-th-align center">미리보기</th>
			</tr>
			</thead>
			<tbody id="img_body">
			<tr id="noimg">
				<td class="its-td-align center" colspan="3">변경할 이미지가 없습니다.</td>
			</tr>
			</tbody>
			</table>
		</div>
		<div class="center" style="left:50%;bottom:10px;margin-left:-50px;position:fixed;">
			<span class="btn large cyanblue"><button type="button" id="saveGoodsImg" style="width:100px;">저장</button></span>
		</div>
		</form>
	</div>
</div>
<div id="openDialogLayer" class="hide">
	<div align="center" id="openDialogLayerMsg"></div>
</div>
</body>
</html>