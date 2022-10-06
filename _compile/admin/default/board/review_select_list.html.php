<?php /* Template_ 2.2.6 2022/05/17 12:30:56 /www/music_brother_firstmall_kr/admin/skin/default/board/review_select_list.html 000007527 */  $this->include_("defaultScriptFunc");
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title><?php echo $TPL_VAR["title"]?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common.css?v=<?php echo date('Ymd')?>">
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layout.css?v=<?php echo date('Ymd')?>">
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/buttons.css?v=<?php echo date('Ymd')?>">
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/board.css?v=<?php echo date('Ymd')?>">
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/page.css?v=<?php echo date('Ymd')?>">
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/jqueryui/black-tie/jquery-ui-1.8.16.custom.css?v=<?php echo date('Ymd')?>">
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/poshytip/style.css?v=<?php echo date('Ymd')?>">
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/editor/css/editor.css?v=<?php echo date('Ymd')?>">

<?php if($TPL_VAR["config_system"]["favicon"]){?>
<!-- 파비콘 -->
<link rel="shortcut icon" href="<?php echo $TPL_VAR["config_system"]["favicon"]?>">
<?php }?>

<!-- 자바스크립트 [순서변경하지마세요] -->
<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.hotkeys.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.poshytip.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.activity-indicator-1.0.0.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.cookie.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-select-box.js"></script>
<script type="text/javascript" src="/app/javascript/js/dev-tools.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-layout.js?dummy=<?php echo date('YmdHis')?>&krdomain=http://<?php echo $TPL_VAR["config_system"]["subDomain"]?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=20160125"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=20160125"></script>
<script type="text/javascript" src="/app/javascript/js/common.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-layout.js"></script>
<?php echo defaultScriptFunc()?></head>

<script type="text/javascript">
function apply_layer(){
	var iObj = $("div#<?php echo $_GET["inputBoard"]?>",parent.document);
	var tag = "";iObj.html( tag );
	$("div#<?php echo $_GET["displayId"]?> div.targetBoard",parent.document).each(function(){
		tag += "<div class='goods move' >";
		tag += $(this).html();
		tag += "</div>";
		this.onclick=function(){parent.targetBoard_click($(this));};
	});
	iObj.html( tag );
}
$(function() {
	$("div#sourceList div.sourceBoards").click(function(){
		var cObj = $(this).clone();
		var tObj = $("div#<?php echo $_GET["displayId"]?> div#targetList",parent.document);
		cObj.removeClass("sourceBoards").addClass("targetBoard");
		if( ! tObj.find("div#"+cObj.attr('id')).length ) tObj.append(cObj);
		apply_layer();
	});
	if(!parent) return;

	// 등록된 상품 선택된 상태로
	if($("div#<?php echo $_GET["displayId"]?> div#targetList div.targetBoard",parent.document).length==0){
		$("div#<?php echo $_GET["inputBoard"]?> div.goods",parent.document).each(function(){
			var tObj = $("div#<?php echo $_GET["displayId"]?> div#targetList",parent.document);
			var seq = $(this).find("input[name='<?php echo $_GET["inputBoard"]?>[]']").val();
			var tag = "";
			tag += "<div class=\"clearbox targetBoard\" id=\""+seq+"\" style=\"border-right:1px solid #aaa;border-left:1px solid #aaa;border-bottom:1px solid #aaa;\">";
			tag += $(this).html();
			tag += "</div>";
			tObj.append(tag);
		});
		apply_layer();
	}//endif;
});
</script>
<script type="text/javascript">
/* input form style 적용*/
function apply_input_style(){
$('img.small_goods_image').each(function() {
	if (!this.complete ) {// image was broken, replace with your new image
		this.src = '/data/icon/error/noimage_list.gif';
	}
});
}
$(document).ready(function() {
	/* 스타일적용 */
	apply_input_style();
});
</script>

<style>
.goodsviewbox1 {float:left;width:40%;padding-bottom: 5px; padding-left: 0px; padding-right: 0px; border-top: #efefef 0px solid; padding-top: 5px;}
.goodsviewbox1 .pic {width: 50px; float: left; vertical-align: top;}
.goodsviewbox1 .gdinfo {width:120px;line-height: 140%; float: left; margin-left: 10px;}
.goodsviewbox1 .gdinfo .goods_name {padding-bottom: 5px; padding-left: 0px; padding-right: 0px; padding-top: 0px;}
.goodsviewbox1 .gdinfo .price {font-family: dotum; color: #333333;}

.goodsviewbox2 {float:left;width:60%;padding-bottom: 5px; padding-left: 0px; padding-right: 0px; border-top: #efefef 0px solid; padding-top: 5px;}
.goodsviewbox2 .info { line-height: 140%;margin-left: 10px;}
.goodsviewbox2 .info .subject {width:250px;padding-bottom: 5px; padding-left: 0px; padding-right: 0px; color: #3c5899; font-weight: bold; padding-top: 0px;}
</style>
<div id="sourceList">
<!-- <?php if($TPL_VAR["loop"]){?> -->
<!-- <?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?> -->
<div class="clearbox sourceBoards " id="<?php echo $TPL_V1["seq"]?>" style="border-right:1px solid #aaa;border-left:1px solid #aaa;border-bottom:1px solid #aaa">
	<div class="goodsviewbox1">
		<div class="pic hand image"><img src="<?php echo $TPL_V1["goodsInfo"]["image"]?>" class="goodsThumbView small_goods_image pic" width="50" height="50" alt="<?php echo $TPL_V1["label"]?>" onerror="this.src='/data/icon/error/noimage_list.gif'"></div>
		<div class="gdinfo">
			<div class="goods_name hand"><?php echo $TPL_V1["goodsInfo"]["goods_name"]?></a></div>
			<div class="price hand"><?php echo $TPL_V1["goodsInfo"]["price"]?></div>
		</div>
	</div>
	<div class="goodsviewbox2">
		<div class="info">
			<div class="subject hand"><?php echo $TPL_V1["subject_real"]?></div>
			<div class="hand"><?php echo $TPL_V1["name"]?></div>
			<div class="hand"><?php echo $TPL_V1["score"]?> [<?php echo $TPL_V1["buyertitle"]?>][<?php echo $TPL_V1["isphoto"]?>]</div>
		</div>
	</div>
	<input type='hidden' name='<?php echo $_GET["inputBoard"]?>[]' value='<?php echo $TPL_V1["seq"]?>'>
</div>
<!-- <?php }}?> -->
<!-- <?php }?> -->
</div>
<div style="height:5px"></div>
<!-- 페이징 test -->
<div align="center">
<div class="paging_navigation mb10" style="margin:auto"><?php echo $TPL_VAR["pagin"]?></div>
</div>
</html>