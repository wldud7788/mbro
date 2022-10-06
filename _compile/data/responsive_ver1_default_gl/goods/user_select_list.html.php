<?php /* Template_ 2.2.6 2021/12/15 17:48:34 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/goods/user_select_list.html 000010357 */  $this->include_("defaultScriptFunc");
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 상품 검색 - 검색된 상품 리스트 @@
- 파일위치 : [스킨폴더]/goods/user_select_list.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title><?php echo $TPL_VAR["title"]?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">

<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layout.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/buttons.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/board.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/page.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/jqueryui/black-tie/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/poshytip/style.css" />
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/editor/css/editor.css" />
<link rel="stylesheet" type="text/css" href="/data/skin/responsive_ver1_default_gl/css/common.css" />
<style>
body { min-width:auto; }
</style>
<?php if($TPL_VAR["config_system"]["favicon"]){?>
<!-- 파비콘 -->
<link rel="shortcut icon" href="<?php echo $TPL_VAR["config_system"]["favicon"]?>" />
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
<script type="text/javascript" src="/app/javascript/js/selleradmin-layout.js?dummy=<?php echo date('YmdHis')?>&krdomain=//<?php echo $TPL_VAR["config_system"]["subDomain"]?>"></script>
<script type="text/javascript" src="/data/js/language/L10n_<?php echo $TPL_VAR["config_system"]["language"]?>.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/common.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-layout.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//$('#select_<?php echo $_GET["displayId"]?>',parent.document).height($('#sourceList').height()+80);
	//$("div#<?php echo $_GET["displayId"]?>", parent.document).height($(parent.document).height());
});
</script>
<?php echo defaultScriptFunc()?></head>


<body>
<script type="text/javascript">
function apply_layer(){
	var iObj = $("div#<?php echo $_GET["inputGoods"]?>",parent.document);
	var tag = "";iObj.html( tag );
	$("div#<?php echo $_GET["displayId"]?> div.targetGoods",parent.document).each(function(){
		var goodsSeq = $(this).attr('id');
		var img = $(this).find(".img_area").html();
		var goodsName = $(this).find("div.name").html();
		var goodsPrice = $(this).find("div.price").html();

		tag += "<div class='goods_loop_area v2'>";
		tag += "	<ul class='goods_area'>";
		tag += "		<li class='img_area'>"+img+"</li>";
		tag += "		<li class='info_area'>";
<?php if($_GET["bulkorder"]){?>
		tag += "			<div class='name'>"+goodsName+"</div>";
<?php }else{?>
		tag += "			<div class='name'>"+goodsName+"</div>";
<?php }?>
		tag += "			<div class='price'>"+goodsPrice+"</div>";
		tag += "		</li>";
		tag += "	</ul>";
		tag += "	<input type='hidden' name='<?php echo $_GET["inputGoods"]?>[]' value='"+goodsSeq+"' />";
<?php if($_GET["bulkorder"]){?>
		var goodscont = $(this).attr('cont');
		tag += "	<textarea name='<?php echo $_GET["inputGoods"]?>_cont[]' id='<?php echo $_GET["inputGoods"]?>_cont_"+goodsSeq+"' title='옵션과 수량정보 입력' cont='" + goodscont + "' /></textarea>";
<?php }?>
		tag += "</div>";

		this.onclick=function(){parent.targetGoods_click($(this));};
<?php if($_GET["goods_review"]){?>parent.goodslistclose('<?php echo $_GET["displayId"]?>',goodsSeq);<?php }?>
	});
	iObj.html( tag );

<?php if($_GET["bulkorder"]){?>
	$("textarea[name='<?php echo $_GET["inputGoods"]?>_cont[]']",parent.document).each(function(){
		var goodscont = $(this).attr('cont');
		if(eval('goodscont') != 'undefined' ) {
			$(this).val(goodscont);
		}
	});
<?php }?>
}
$(function() {
	$("#sourceList .sourceGoods").live("click",function(){
		var cObj = $(this).clone();
		var tObj = $("div#<?php echo $_GET["displayId"]?> div#targetList",parent.document);
		cObj.removeClass("sourceGoods").addClass("targetGoods");
<?php if($_GET["goods_review"]){?>tObj.empty();<?php }?>
		if( ! tObj.find("div#"+cObj.attr('id')).length ) tObj.append(cObj);
		apply_layer();
		
<?php if($_GET["goods_review"]){?>
		$('.resp_layer_pop', parent.document).hide();
		$('.resp_layer_bg', parent.document).remove();
		$('body', parent.document).css('overflow', 'auto');
<?php }?>
	});
	// 등록된 상품 선택된 상태로
	$("div#<?php echo $_GET["inputGoods"]?> div.goods",parent.document).each(function(){
		var clone = $("div#sourceList div.sourceGoods").eq(0).clone();
		var img = $(this).find(".img_area").html();
		var name = $(this).find("div.name").html();
		var price = $(this).find("div.price").html();
		var seq = $(this).find("input[name='<?php echo $_GET["inputGoods"]?>[]']").val();
		var goodsSeqsel = false;
		$("div#<?php echo $_GET["displayId"]?> div.targetGoods",parent.document).each(function(){
			var goodsSeq = $(this).attr('id');
			if( goodsSeq == seq ) {
				goodsSeqsel = true;
				return false;//break;
			}
		});

		if( goodsSeqsel == false ) {//선택되지 않은상품만추가
			var tObj = $("div#<?php echo $_GET["displayId"]?> div#targetList",parent.document);
			clone.attr('id',seq);
<?php if($_GET["bulkorder"]){?>
			var goodscont = $(this).find("textarea[name='<?php echo $_GET["inputGoods"]?>_cont[]']").val();
			clone.attr('cont',goodscont);
<?php }?>
			clone.find(".img_area").html(img);
			clone.find("div.name").html(name);
			clone.find("div.price").html(price);
			clone.removeClass("sourceGoods").addClass("targetGoods");
			clone[0].onclick=function(){parent.targetGoods_click(clone);};
			tObj.append(clone);
		}
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	//$(document).resize(function(){iframeset();}).resize();
	setInterval(function(){
		iframeset();
	},1000);
});
function iframeset(){
	$('#orderlist',parent.document).height($('#sourceList').height());
	$('#select_<?php echo $_GET["displayId"]?>',parent.document).height($('#sourceList').height());
}
</script>
<div id="sourceList">
	<div class="board_goods_select_display v2">
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
		<div id="<?php echo $TPL_V1["goods_seq"]?>" class="sourceGoods goods_loop_area">
			<ul class="goods_area">
				<li class="img_area"><img src="<?php echo $TPL_V1["image"]?>" class="goodsThumbView goods_img" alt="<?php echo $TPL_V1["label"]?>" /></li>
				<li class="info_area">
					<div class="name"><?php echo $TPL_V1["goods_name"]?></div>
					<div class="price">
<?php if($TPL_V1["string_price_use"]){?>
						<?php echo $TPL_V1["string_price"]?>

<?php }else{?>
<?php if($TPL_V1["consumer_price"]> 0&&$TPL_V1["consumer_price"]<$TPL_V1["price"]){?><?php echo number_format($TPL_V1["consumer_price"])?> →<?php }?> <?php echo number_format($TPL_V1["price"])?>

<?php }?>
					</div>
				</li>
			</ul>
			<input type='hidden' name='displayGoods[]' value='<?php echo $TPL_V1["goods_seq"]?>' />
		</div>
<?php }}else{?>
		<div>
			<p class="center" style="padding:30px;">검색된 상품 리스트가 없습니다.</p>
		</div>
<?php }?>
	</div>

	<!-- 페이징 -->
	<div class="paging_navigation">
<?php if($TPL_VAR["page"]["first"]){?>
		<a href="user_select_list?page=<?php echo $TPL_VAR["page"]["first"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="first">처음</a>
<?php }?>
<?php if($TPL_VAR["page"]["prev"]){?>
		<a href="user_select_list?page=<?php echo $TPL_VAR["page"]["prev"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="prev">이전</a>
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
		<a href="javascript:void(0)" class="on"><?php echo $TPL_V1?></a>
<?php }else{?>
		<a href="user_select_list?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>"><?php echo $TPL_V1?></a>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?>
		<a href="user_select_list?page=<?php echo $TPL_VAR["page"]["next"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="next">다음</a>
<?php }?>
<?php if($TPL_VAR["page"]["last"]){?>
		<a href="user_select_list?page=<?php echo $TPL_VAR["page"]["last"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="last">끝</a>
<?php }?>
<?php if(!$TPL_VAR["record"]){?>
		<a href="javascript:void(0)" class="on">1</a>
<?php }?>
	</div>
</div>

</body>
</html>