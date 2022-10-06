<?php /* Template_ 2.2.6 2022/03/18 15:13:17 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/goods/view_common_contents.html 000003702 */  $this->include_("defaultScriptFunc");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 상품 상세 설명 - 공용정보 원본 보기 @@
- 파일위치 : [스킨폴더]/goods/view_common_contents.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if(!$TPL_VAR["commonpreload"]){?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"  xmlns:fb="http://ogp.me/ns/fb#"  xmlns:og="http://ogp.me/ns#" >
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# <?php if($TPL_VAR["APP_NAMES"]&&$TPL_VAR["APP_TYPE"]){?><?php echo $TPL_VAR["APP_NAMES"]?><?php }else{?>website<?php }?>: <?php if($TPL_VAR["APP_NAMES"]&&$TPL_VAR["APP_TYPE"]){?>http://ogp.me/ns/fb/<?php echo $TPL_VAR["APP_NAMES"]?><?php }else{?>http://ogp.me/ns/fb/website<?php }?>#">
<meta charset="utf-8">
<meta name="viewport" content="width=400px">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<title><?php if($TPL_VAR["shopTitle"]){?><?php echo strip_tags($TPL_VAR["shopTitle"])?><?php }elseif($TPL_VAR["subject"]){?><?php echo strip_tags($TPL_VAR["subject"])?><?php }elseif($TPL_VAR["goods"]["goods_name"]){?><?php echo strip_tags($TPL_VAR["goods"]["goods_name"])?><?php }elseif($TPL_VAR["config_basic"]["shopName"]){?><?php echo strip_tags($TPL_VAR["config_basic"]["shopName"])?><?php }?></title>
<link rel="stylesheet" type="text/css" href="/data/skin/responsive_sports_sporti_gl_1/css/common.css" />
<link rel="stylesheet" type="text/css" href="/data/skin/responsive_sports_sporti_gl_1/css/buttons.css" />
<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery-ui.min.js"></script>
<style type="text/css">
#goods_view_contents_title { padding:0 10px; height:40px; background-color:#616775; }
#goods_view_contents_title h2 { font-size:14px; font-weight:500; line-height:40px; padding-left:36px; color:#fff; background:url(/data/skin/responsive_sports_sporti_gl_1/images/design/hand_zoom.png) 0 50% no-repeat; background-size:24px; }
#goods_view_contents_title .close { position: absolute; right: 0px; top: 0px; background: url(/data/skin/responsive_sports_sporti_gl_1/images/design/btn_close.png) no-repeat center center; background-size: 39px 39px; width: 39px; height: 39px; box-sizing: border-box; overflow:hidden; text-indent:-999px; }
#goods_view_contents {z-index:5; }
#goods_view_contents_top {z-index:10; position:fixed; right:10px; bottom:10px; width:37px;}
#goods_view_contents_top img {max-width:100%;}
.goods_desc_contents img {max-width:100%;}
.goods_description ul {list-style-type:disc; padding-left: 20px;}
</style>
<?php echo defaultScriptFunc()?></head>
<body>

<!-- title, close -->
<div id="goods_view_contents_title">
	<h2>이미지 확대/축소가 가능합니다.</h2>
	<a href="javascript:void(0)" class="close" onclick="history.back();">닫기</a>
</div>

<!-- to top -->
<div id="goods_view_contents_top">
	<a href="#"><img src="/data/skin/responsive_sports_sporti_gl_1/images/design/btn_floating_top.png" /></a>
</div>


<div class="goods_desc_contents goods_description">
	<?php echo $TPL_VAR["goods"]["common_contents"]?>

</div>

</body>
</html>
<?php }else{?>

<div class="goods_desc_contents goods_description">
	<?php echo $TPL_VAR["goods"]["common_contents"]?>

</div>
<?php }?>