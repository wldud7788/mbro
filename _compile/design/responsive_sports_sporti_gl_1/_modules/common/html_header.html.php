<?php /* Template_ 2.2.6 2022/04/12 15:45:39 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/_modules/common/html_header.html 000035235 */  $this->include_("metaHeaderWrite","naverWcsScript","defaultScriptFunc");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ #HTML_HEADER @@
- 파일위치 : [스킨폴더]/_modules/common/html_header.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"  xmlns:fb="http://ogp.me/ns/fb#"  xmlns:og="http://ogp.me/ns#">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# <?php if($TPL_VAR["APP_NAMES"]&&$TPL_VAR["APP_TYPE"]){?><?php echo $TPL_VAR["APP_NAMES"]?><?php }else{?>website<?php }?>: <?php if($TPL_VAR["APP_NAMES"]&&$TPL_VAR["APP_TYPE"]){?>http://ogp.me/ns/fb/<?php echo $TPL_VAR["APP_NAMES"]?><?php }else{?>http://ogp.me/ns/fb/website<?php }?>#">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<?php echo metaHeaderWrite($TPL_VAR["add_meta_info"])?>

<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />  -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<title><?php echo $TPL_VAR["shopTitle"]?></title>

<?php if($TPL_VAR["old_meta"]=='Y'){?>
	<!-- SEO 설정이 없을경우 -->
<?php if(!$TPL_VAR["config_basic"]["metaTagUse"]){?>
	<meta name="robots" content="noindex,nofollow">
<?php }?>
	<meta name="generator" content="<?php if($TPL_VAR["meta"]["generator"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["meta"]["generator"]))?><?php }else{?><?php echo htmlspecialchars(strip_tags($TPL_VAR["config_basic"]["shopName"]))?><?php }?>" />

<?php if($TPL_VAR["APP_USE"]=='f'){?>
	<meta name="title" content="<?php if($TPL_VAR["goods"]["goods_name"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["goods"]["goods_name"]))?><?php }else{?><?php if($TPL_VAR["subject"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["subject"]))?><?php }else{?><?php if($TPL_VAR["shopTitle"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["shopTitle"]))?><?php }?><?php }?><?php }?>" />
<?php if(!$TPL_VAR["goods"]["summary"]&&$TPL_VAR["goods"]["common_contents"]){?>
		<meta name="description" content="<?php echo htmlspecialchars(strip_tags($TPL_VAR["goods"]["common_contents"]))?>" />
<?php }else{?>
		<meta name="description" content="<?php if($TPL_VAR["goods"]["summary"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["goods"]["summary"]))?><?php }else{?><?php if($TPL_VAR["subject"]&&$TPL_VAR["contents"]){?><?php echo getstrcut(htmlspecialchars(strip_tags($TPL_VAR["contents"])), 30)?><?php }else{?><?php if($TPL_VAR["mete"]["description"]){?> - <?php echo htmlspecialchars(strip_tags($TPL_VAR["mete"]["description"]))?><?php }?><?php if($TPL_VAR["config_basic"]["metaTagDescription"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["config_basic"]["metaTagDescription"]))?><?php }else{?><?php }?><?php }?><?php }?>" />
<?php }?>
<?php }else{?>
	<meta name="title" content="[<?php echo htmlspecialchars(strip_tags($TPL_VAR["config_basic"]["shopName"]))?>]<?php if($TPL_VAR["goods"]["goods_name"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["goods"]["goods_name"]))?> <?php }else{?><?php if($TPL_VAR["subject"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["subject"]))?><?php }else{?><?php if($TPL_VAR["mete"]["description"]){?> - <?php echo htmlspecialchars(strip_tags($TPL_VAR["mete"]["description"]))?><?php }?><?php if($TPL_VAR["config_basic"]["metaTagDescription"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["config_basic"]["metaTagDescription"]))?><?php }else{?><?php }?><?php }?><?php }?>" />
	<meta name="description" content="<?php if($TPL_VAR["goods"]["summary"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["goods"]["summary"]))?><?php }else{?><?php if($TPL_VAR["subject"]&&$TPL_VAR["contents"]){?><?php echo getstrcut(htmlspecialchars(strip_tags($TPL_VAR["contents"])), 30)?><?php }else{?><?php if($TPL_VAR["mete"]["description"]){?> - <?php echo htmlspecialchars(strip_tags($TPL_VAR["mete"]["description"]))?><?php }?><?php if($TPL_VAR["config_basic"]["metaTagDescription"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["config_basic"]["metaTagDescription"]))?><?php }else{?><?php }?><?php }?><?php }?>" />
<?php }?>
	<meta name="keywords" content="<?php if($TPL_VAR["goods"]["summary"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["goods"]["summary"]))?><?php }?><?php if($TPL_VAR["config_basic"]["metaTagKeyword"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["config_basic"]["metaTagKeyword"]))?><?php }else{?><?php }?>" />
<?php }else{?>
	<!-- SEO 설정이 있을경우 -->
	<?php echo $TPL_VAR["new_meta"]?>

<?php }?>

<meta property="og:url" content="<?php echo $TPL_VAR["url"]?>" />
<meta property="og:site_name" content="<?php echo htmlspecialchars(strip_tags($TPL_VAR["config_basic"]["shopName"]))?>" />
<meta property="og:title" content="<?php if($TPL_VAR["goods"]["goods_name"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["goods"]["goods_name"]))?><?php }else{?><?php if($TPL_VAR["subject"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["subject"]))?><?php }else{?><?php if($TPL_VAR["shopTitle"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["shopTitle"]))?><?php }?><?php }?><?php }?>" />
<?php if(!$TPL_VAR["goods"]["summary"]&&$TPL_VAR["goods"]["common_contents"]){?>
	<meta property="og:description" content="<?php echo htmlspecialchars(strip_tags($TPL_VAR["goods"]["common_contents"]))?>" />
<?php }else{?>
	<meta property="og:description" content="<?php if($TPL_VAR["goods"]["summary"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["goods"]["summary"]))?><?php }else{?><?php if($TPL_VAR["subject"]&&$TPL_VAR["contents"]){?><?php echo getstrcut(htmlspecialchars(strip_tags($TPL_VAR["contents"])), 30)?><?php }else{?><?php if($TPL_VAR["mete"]["description"]){?> - <?php echo htmlspecialchars(strip_tags($TPL_VAR["mete"]["description"]))?><?php }?><?php if($TPL_VAR["config_basic"]["metaTagDescription"]){?><?php echo htmlspecialchars(strip_tags($TPL_VAR["config_basic"]["metaTagDescription"]))?><?php }else{?><?php }?><?php }?><?php }?>" />
<?php }?>

<?php if($TPL_VAR["APP_USE"]=='f'){?>
	<meta property="fb:app_id" content="<?php echo $TPL_VAR["APP_ID"]?>" />
<?php if($TPL_VAR["APP_NAMES"]=='fammerce_plus'&&$TPL_VAR["APP_TYPE"]=='item'){?>
		<meta property="og:type" content="<?php if($TPL_VAR["APP_TYPE"]){?><?php echo $TPL_VAR["APP_NAMES"]?>:<?php echo $TPL_VAR["APP_TYPE"]?><?php }else{?>website<?php }?>" />
<?php }else{?>
		<meta property="og:type" content="<?php if($TPL_VAR["APP_TYPE"]){?><?php echo $TPL_VAR["APP_TYPE"]?><?php }else{?>website<?php }?>" />
<?php }?>
<?php if($TPL_VAR["APP_NAMES"]&&$TPL_VAR["goods"]["goods_seq"]){?>
<?php if($TPL_VAR["APP_NAMES"]=='fammerce_plus'&&$TPL_VAR["APP_TYPE"]=='item'){?>
<?php if($TPL_VAR["goods"]["string_price_use"]){?>
				<meta property="<?php echo $TPL_VAR["APP_NAMES"]?>:price"    content="<?php echo htmlspecialchars(strip_tags($TPL_VAR["goods"]["string_price"]))?>" />
<?php }else{?>
<?php if($TPL_VAR["goods"]["consumer_price"]> 0){?>
					<meta property="<?php echo $TPL_VAR["APP_NAMES"]?>:price"    content="<?php echo number_format($TPL_VAR["goods"]["consumer_price"])?>원 →<?php echo number_format($TPL_VAR["goods"]["price"])?>원 (<?php echo number_format($TPL_VAR["goods"]["consumer_price"]-$TPL_VAR["goods"]["price"])?>원 할인)" />
<?php }else{?>
				<meta property="<?php echo $TPL_VAR["APP_NAMES"]?>:price"    content="<?php echo number_format($TPL_VAR["goods"]["price"])?>원" />
<?php }?>
<?php }?>
			  <meta property="<?php echo $TPL_VAR["APP_NAMES"]?>:url"      content="<?php echo $TPL_VAR["url"]?>" />
			  <meta property="<?php echo $TPL_VAR["APP_NAMES"]?>:category" content="<?php echo htmlspecialchars(strip_tags($TPL_VAR["fbcategory_title"]))?>" />
<?php }else{?>
<?php if($TPL_VAR["goods"]["string_price_use"]){?>
					<meta property="<?php echo $TPL_VAR["APP_TYPE"]?>:price:amount"    content="<?php echo htmlspecialchars(strip_tags($TPL_VAR["goods"]["string_price"]))?>" />
<?php }else{?>
<?php if($TPL_VAR["goods"]["consumer_price"]> 0){?>
						<meta property="<?php echo $TPL_VAR["APP_TYPE"]?>:price:amount"    content="<?php echo ($TPL_VAR["goods"]["price"])?>" />
<?php }else{?>
					<meta property="<?php echo $TPL_VAR["APP_TYPE"]?>:price:amount"    content="<?php echo $TPL_VAR["goods"]["price"]?>" />
<?php }?>
<?php }?>

<?php if($TPL_VAR["goods"]["brand"]){?>
				 <meta property="<?php echo $TPL_VAR["APP_TYPE"]?>:brand" content="<?php echo strip_tags($TPL_VAR["view_brand"])?>" />
<?php }?>
				  <meta property="<?php echo $TPL_VAR["APP_TYPE"]?>:price:currency"    content="KRW" />
				  <meta property="<?php echo $TPL_VAR["APP_TYPE"]?>:product_link"      content="<?php echo $TPL_VAR["url"]?>" />
				  <meta property="<?php echo $TPL_VAR["APP_TYPE"]?>:category" content="<?php echo htmlspecialchars(strip_tags($TPL_VAR["fbcategory_title"]))?>" />
<?php }?>
<?php }?>
<?php if($TPL_VAR["APP_IMG"]){?>
<?php if(preg_match('/http/',$TPL_VAR["APP_IMG"])){?>
			<meta property="og:image" content="<?php echo $TPL_VAR["APP_IMG"]?>"  />
			<link rel="image_src" href="<?php echo $TPL_VAR["APP_IMG"]?>"/>
<?php }else{?>
<?php if($_SERVER["HTTPS"]=='on'){?>
			<meta property="og:image" content="https://<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["APP_IMG"]?>"  />
			<link rel="image_src" href="https://<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["APP_IMG"]?>"/>
<?php }else{?>
<meta property="og:image" content="//<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["APP_IMG"]?>"  />
<link rel="image_src" href="//<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["APP_IMG"]?>"/>
<?php }?>
<?php }?>
<?php }?>
<?php }else{?>
<meta property="og:type" content="website" />
<?php if($TPL_VAR["APP_IMG"]){?>
<?php if(preg_match('/http/',$TPL_VAR["APP_IMG"])){?>
			<meta property="og:image" content="<?php echo $TPL_VAR["APP_IMG"]?>"  />
			<link rel="image_src" href="<?php echo $TPL_VAR["APP_IMG"]?>"/>
<?php }else{?>
<?php if($_SERVER["HTTPS"]=='on'){?>
			<meta property="og:image" content="https://<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["APP_IMG"]?>"  />
			<link rel="image_src" href="https://<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["APP_IMG"]?>"/>
<?php }else{?>
<meta property="og:image" content="//<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["APP_IMG"]?>"  />
<link rel="image_src" href="//<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["APP_IMG"]?>"/>
<?php }?>
<?php }?>
<?php }?>
<?php }?>

<?php if(!$TPL_VAR["APP_IMG"]&&$TPL_VAR["SNSLOGO"]){?>
<?php if($_SERVER["HTTPS"]=='on'){?>
<meta property="og:image" content="https://<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["SNSLOGO"]?>"  />
<link rel="image_src" href="https://<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["SNSLOGO"]?>"/>
<?php }else{?>
<meta property="og:image" content="//<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["SNSLOGO"]?>"  />
<link rel="image_src" href="//<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["SNSLOGO"]?>"/>
<?php }?>
<?php }?>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/data/font/font.css" />

<!-- 구글 웹폰트 -->
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR:100,300,400,500,700&amp;subset=korean" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="/data/skin/responsive_sports_sporti_gl_1/css/jqueryui/black-tie/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/slick/slick.css"><!-- 반응형 슬라이드 -->
<link rel="stylesheet" type="text/css" href="/data/design/goods_info_style.css"><!-- 상품디스플레이 CSS -->
<link rel="stylesheet" type="text/css" href="/data/design/goods_info_user.css"><!-- ++++++++++++ 상품디스플레이 사용자/제작자 CSS ++++++++++++ -->
<link rel="stylesheet" type="text/css" href="/data/skin/responsive_sports_sporti_gl_1/css/lib.css" />
<link rel="stylesheet" type="text/css" href="/data/skin/<?php echo $TPL_VAR["skin"]?>/css/common.css?v=<?php echo date('Ymd')?>" />
<link rel="stylesheet" type="text/css" href="/data/skin/responsive_sports_sporti_gl_1/css/board.css" />
<link rel="stylesheet" type="text/css" href="/data/skin/responsive_sports_sporti_gl_1/css/buttons.css" />
<link rel="stylesheet" type="text/css" href="/data/skin/responsive_sports_sporti_gl_1/css/mobile_pagination.css" />
<link rel="stylesheet" type="text/css" href="/link/css?k=quickdesign&v=<?php echo date('YmdHis')?>" /><!-- Quick Design CSS -->
<link rel="stylesheet" type="text/css" href="/data/skin/responsive_sports_sporti_gl_1/css/broadcast.css" /> 
<link rel="stylesheet" type="text/css" href="/data/skin/responsive_sports_sporti_gl_1/css/user.css" /><!-- ++++++++++++ 스킨 사용자/제작자 CSS ++++++++++++ -->
<?php if($TPL_VAR["ISADMIN"]||$TPL_VAR["writeditorjs"]){?>
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/editor/css/editor.css" />
<?php }?>
<link rel="stylesheet" href="/app/javascript/plugin/touchSlider/swiper.css" />
<!-- /CSS -->
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/jquery_swipe/jquery_swipe.css" />

<!-- 파비콘 -->
<?php if(!$TPL_VAR["ISMOBILE_AGENT"]){?>
<?php if($TPL_VAR["config_system"]["favicon"]){?>
<?php if($_SERVER["HTTPS"]=='on'){?>
    <link rel="shortcut icon" href="https://<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["config_system"]["favicon"]?>" />
<?php }else{?>
    <link rel="shortcut icon" href="//<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["config_system"]["favicon"]?>" />
<?php }?>
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["config_system"]["androidicon"]||$TPL_VAR["config_system"]["iphoneicon"]){?>
<!-- 바로가기아이콘 -->
<link rel="apple-touch-icon" href="http<?php if($_SERVER["HTTPS"]=='on'){?>s<?php }?>://<?php echo $_SERVER["HTTP_HOST"]?><?php echo $TPL_VAR["config_system"]["iphoneicon"]?>" />
<link rel="shortcut icon" href="http<?php if($_SERVER["HTTPS"]=='on'){?>s<?php }?>://<?php echo $_SERVER["HTTP_HOST"]?><?php echo $TPL_VAR["config_system"]["androidicon"]?>" />
<?php }?>
<?php }?>

<!-- 자바스크립트 -->
<script src="/app/javascript/jquery/jquery.min.js"></script>
<script src="/app/javascript/jquery/jquery-ui.min.js"></script>
<script src="/app/javascript/plugin/jquery.poshytip.min.js"></script>
<script src="/app/javascript/plugin/jquery.activity-indicator-1.0.0.min.js"></script>
<script src="/app/javascript/plugin/jquery.cookie.js"></script>
<script src="/app/javascript/plugin/jquery.slides.min.js"></script>
<script src="/app/javascript/plugin/jquery.placeholder.js"></script>
<script src="/app/javascript/plugin/validate/jquery.validate.js"></script>
<script src="/app/javascript/plugin/ezmark/js/jquery.ezmark.min.js"></script>
<script src="/app/javascript/plugin/custom-select-box.js"></script>
<script src="/app/javascript/plugin/custom-mobile-pagination.js"></script>
<script src="/app/javascript/plugin/slick/slick.min.js"></script>
<script src="/app/javascript/plugin/jquery_swipe/jquery.event.swipe.js"></script>
<script src="/app/javascript/plugin/touchSlider/swiper.js"></script>
<?php echo requirejs(array(array('/app/javascript/js/dev-tools.js', 30),array('/app/javascript/js/design.js', 31),array('/app/javascript/js/common.js', 32),array('/app/javascript/js/common-mobile.js', 33),array('/app/javascript/js/front-layout.js', 34),array('/app/javascript/js/base64.js', 35),array('/app/javascript/js/skin-responsive.js', 36),array(implode('',array('/data/js/language/L10n_',$TPL_VAR["config_system"]["language"],'.js')), 37),array('/data/skin/responsive_sports_sporti_gl_1/common/script.js', 40),array('/data/skin/responsive_sports_sporti_gl_1/common/jquery.touchSlider.js', 40),array('/data/skin/responsive_sports_sporti_gl_1/common/jquery.event.drag-1.5.min.js', 40),array('/data/skin/responsive_sports_sporti_gl_1/common/responsive.js', 40),array('/data/skin/responsive_sports_sporti_gl_1/common/search_ver2.js', 40),array('/data/skin/responsive_sports_sporti_gl_1/common/user.js', 40)))?>

<?php if(($TPL_VAR["ISADMIN"]||$TPL_VAR["writeditorjs"])&&!$_GET["mobileAjaxCall"]){?>
<?php echo requirejs(array(array('/app/javascript/plugin/editor/js/editor_loader.js', 20),array(implode('',array('/app/javascript/plugin/editor/js/daum_editor_loader.js?file_use=',$TPL_VAR["manager"]["file_use"])), 20)))?>

<?php }?>
<?php if($TPL_VAR["mobileMode"]||$TPL_VAR["storemobileMode"]||$TPL_VAR["ISMOBILE_AGENT"]){?>
<?php echo requirejs('/app/javascript/js/goods-display_mobile.js', 30)?>

<?php }else{?>
<?php echo requirejs('/app/javascript/js/goods-display.js', 30)?>

<?php }?>
<script>
var REQURL = '<?php echo $_SERVER["REQUEST_URI"]?>';
var WINDOWWIDTH = window.innerWidth;
// sns 만14세 동의 체크 변수
var kid_agree = "";
</script>

<?php if($TPL_VAR["APP_USE"]=='f'&&$TPL_VAR["is_file_facebook"]){?>
<script>
 var is_user = false;
<?php if(defined('__ISUSER__')){?>
 is_user = <?php echo defined('__ISUSER__')?>;
<?php }?>
 var plus_app_id = '<?php echo $TPL_VAR["APP_ID"]?>';
 var fammercemode = '<?php echo $TPL_VAR["fammercemode"]?>';
 var mbpage = false;
<?php if($TPL_VAR["login"]||$TPL_VAR["register"]){?>
 mbpage = true;
<?php }?>

 var orderpage = false;
<?php if($TPL_VAR["cartpage"]||$TPL_VAR["settlepage"]){?>
	orderpage = true;
<?php }?>

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo $TPL_VAR["APP_ID"]?>', //App ID
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true,  // parse XFBML,
      oauth      : true,
      version    : 'v<?php echo $TPL_VAR["APP_VER"]?>'
    });

<?php if($TPL_VAR["fammercemode"]){?>
		FB.Canvas.setAutoGrow();
<?php }?>

<?php if(!($TPL_VAR["cartpage"]||$TPL_VAR["settlepage"])){?>
		// like 이벤트가 발생할때 호출된다.
		FB.Event.subscribe('edge.create', function(response) {
			$.ajax({'url' : '../sns_process/facebooklikeck', 'type' : 'post', 'data' : {'mode':'like', 'product_url':response}});
		});

		// unlike 이벤트가 발생할때 호출된다.
		FB.Event.subscribe('edge.remove', function(response) {
			$.ajax({'url' : '../sns_process/facebooklikeck', 'type' : 'post', 'data' : {'mode':'unlike', 'product_url':response}});
		});
<?php }?>

	// logout 이벤트가 발생할때 호출된다.
	FB.Event.subscribe('auth.logout', function(response) {

	});
  };
	$(document).ready(function() {
		//기본 login
		$(".fb-login-button").click(function(){
<?php if((strstr($_SERVER["HTTP_HOST"],'.firstmall.kr')||$_SERVER["HTTP_HOST"]==$TPL_VAR["APP_DOMAIN"])){?>
				FB.login(handelStatusChange,{scope:'<?php echo $TPL_VAR["fbuserauth"]?>'});
<?php }else{?>
				document.location.href = gl_protocol+'m.<?php echo $TPL_VAR["config_system"]["subDomain"]?><?php if(strstr($_SERVER["REQUEST_URI"],"?")){?><?php echo $_SERVER["REQUEST_URI"]?>&handelStatusChange_autologin=1<?php }else{?><?php echo $_SERVER["REQUEST_URI"]?>?handelStatusChange_autologin=1<?php }?>';
<?php }?>
		});
<?php if($_GET["handelStatusChange_autologin"]){?>
			FB.login(handelStatusChange,{scope:'<?php echo $TPL_VAR["fbuserauth"]?>'});
<?php }?>

		//기업회원 login
		$(".fb-login-button-business").click(function(){
<?php if((strstr($_SERVER["HTTP_HOST"],'.firstmall.kr')||$_SERVER["HTTP_HOST"]==$TPL_VAR["APP_DOMAIN"])){?>
				FB.login(handelStatusChangebiz,{scope:'<?php echo $TPL_VAR["fbuserauth"]?>'});
<?php }else{?>
				document.location.href = gl_protocol+'m.<?php echo $TPL_VAR["config_system"]["subDomain"]?><?php if(strstr($_SERVER["REQUEST_URI"],"?")){?><?php echo $_SERVER["REQUEST_URI"]?>&handelStatusChangebiz_autologin=1<?php }else{?><?php echo $_SERVER["REQUEST_URI"]?>?handelStatusChangebiz_autologin=1<?php }?>';
<?php }?>
		});
<?php if($_GET["handelStatusChangebiz_autologin"]){?>
			FB.login(handelStatusChangebiz,{scope:'<?php echo $TPL_VAR["fbuserauth"]?>'});
<?php }?>

		//회원통합 로그인(이메일동일)
		$(".fb-login-button-connect").click(function(){
<?php if((strstr($_SERVER["HTTP_HOST"],'.firstmall.kr')||$_SERVER["HTTP_HOST"]==$TPL_VAR["APP_DOMAIN"])){?>
				FB.login(handelStatusChangeconnect,{scope:'<?php echo $TPL_VAR["fbuserauth"]?>'});
<?php }else{?>
				document.location.href = gl_protocol+'m.<?php echo $TPL_VAR["config_system"]["subDomain"]?><?php if(strstr($_SERVER["REQUEST_URI"],"?")){?><?php echo $_SERVER["REQUEST_URI"]?>&handelStatusChangeconnect_autologin=1<?php }else{?><?php echo $_SERVER["REQUEST_URI"]?>?handelStatusChangeconnect_autologin=1<?php }?>';
<?php }?>
		});
<?php if($_GET["handelStatusChangeconnect_autologin"]){?>
			FB.login(handelStatusChangeconnect,{scope:'<?php echo $TPL_VAR["fbuserauth"]?>'});
<?php }?>

		//새로가입(이메일동일함)
		$(".fb-login-button-noconnect").click(function(){
<?php if((strstr($_SERVER["HTTP_HOST"],'.firstmall.kr')||$_SERVER["HTTP_HOST"]==$TPL_VAR["APP_DOMAIN"])){?>
				FB.login(handelStatusChangenoconnect,{scope:'<?php echo $TPL_VAR["fbuserauth"]?>'});
<?php }else{?>
				document.location.href = gl_protocol+'m.<?php echo $TPL_VAR["config_system"]["subDomain"]?><?php if(strstr($_SERVER["REQUEST_URI"],"?")){?><?php echo $_SERVER["REQUEST_URI"]?>&handelStatusChangenoconnect_autologin=1<?php }else{?><?php echo $_SERVER["REQUEST_URI"]?>?handelStatusChangenoconnect_autologin=1<?php }?>';
<?php }?>
		});

<?php if($_GET["handelStatusChangenoconnect_autologin"]){?>
			FB.login(handelStatusChangenoconnect,{scope:'<?php echo $TPL_VAR["fbuserauth"]?>'});
<?php }?>
	});
</script>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/ko_KR/sdk.js";//#xfbml=1&appId=<?php echo $TPL_VAR["APP_ID"]?>

fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
 <script type="text/javascript">
  var fbId = "";
  var fbAccessToken = "";
  var isLogin = false;
  var isFirst = true;
  var fbUid = "";
  var fbName = "";
	function handelStatusChange(response) {
		if (response && response.status == 'connected') {
		// 로그인
		isLogin = true;
		initializeFbTokenValues();
		initializeFbUserValues();
		fbId = response.authResponse.userID;
		fbAccessToken = response.authResponse.accessToken;
		if(kid_agree != ""){
			loginck_data = {'kid_agree':kid_agree};
		}else{
			loginck_data = {};
		}
		FB.api('/me', function(response) {
			 fbUid = response.email;
			 fbName = response.name;
			 if (fbName != "") {
<?php if(!defined('__ISUSER__')){?>
				loadingStart("body",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});
					$.ajax({
					'url' : '../sns_process/facebookloginck',
					'data': loginck_data,
					'type' : 'post',
					'dataType': 'json',
					'success': function(res) {
						if(res.result == 'emailck'){//이메일이 등록된 경우
							//회원 통합하기  <span class='desc'>로그인해 주세요.</span>
							openDialog(getAlert('mb237'), "member_facebook_connect", {"width":"470","height":"250"});
						}else if(res.result == true){
							loadingStop("body",true);
							openDialogAlert(res.msg,'400','180',function(){
<?php if($_GET["return_url"]){?>
								document.location.href='<?php echo $_GET["return_url"]?>';
<?php }elseif($TPL_VAR["res"]["retururl"]){?>
								document.location.href=res.retururl;
<?php }elseif($TPL_VAR["login"]||$TPL_VAR["register"]){?>
								document.location.href=res.retururl;
<?php }else{?>
								document.location.reload();
<?php }?>
							});
						}else{
							loadingStop("body",true);
							openDialogAlert(res.msg,'400','140',function(){});
						}
					}
					});
<?php }?>
			}
		});
	   } else if (response.status == 'not_authorized' || response.status == 'unknown') {
		   //연결을 취소하셨습니다.
			openDialogAlert(getAlert('mb238'),'400','160',function(){});
			// 로그아웃된 경우
			isLogin = false;
<?php if(defined('__ISUSER__')){?>
			loadingStart("body",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});
				$.ajax({
				'url' : '../sns_process/facebooklogout',
				'dataType': 'json',
				'success': function(res) {
					if(res.result == true){
<?php if($_GET["return_url"]){?>
							document.location.href='<?php echo $_GET["return_url"]?>';
<?php }elseif($TPL_VAR["login"]||$TPL_VAR["register"]){?>
							document.location.href='../main/';
<?php }else{?>
							document.location.reload();
<?php }?>
					}else{
						document.location.reload();
					}
				}
				});

<?php }?>
			if (fbId != "")  initializeFbTokenValues();
			if (fbUid != "") initializeFbUserValues();
		}
	}

	function handelStatusChangebiz(response) {
		if (response && response.status == 'connected') {
		// 로그인
		isLogin = true;
		initializeFbTokenValues();
		initializeFbUserValues();
		fbId = response.authResponse.userID;
		fbAccessToken = response.authResponse.accessToken;
		FB.api('/me', function(response) {
			 fbUid = response.email;
			 fbName = response.name;
			 if (fbName != "") {
<?php if(!defined('__ISUSER__')){?>
				loadingStart("body",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});
					$.ajax({
					'url' : '../sns_process/facebookloginck',
					'data' : {'mtype':'biz'},
					'type' : 'post',
					'dataType': 'json',
					'success': function(res) {
						if(res.result == 'emailck'){//이메일이 등된 경우
							//회원 통합하기  <span class='desc'>로그인해 주세요.</span>
							openDialog(getAlert('mb237'), "member_facebook_connect", {"width":"470","height":"250"});
						}else if(res.result == true){
							loadingStop("body",true);
							openDialogAlert(res.msg,'400','180',function(){
<?php if($_GET["return_url"]){?>
								document.location.href='<?php echo $_GET["return_url"]?>';
<?php }elseif($TPL_VAR["login"]||$TPL_VAR["register"]){?>
								document.location.href='/mypage/';
<?php }else{?>
								document.location.reload();
<?php }?>
							});
						}else{
							loadingStop("body",true);
							openDialogAlert(res.msg,'400','140',function(){});
						}
					}
					});
<?php }?>
			}
		});
	   } else if (response.status == 'not_authorized' || response.status == 'unknown') {
		   //연결을 취소하셨습니다.
			openDialogAlert(getAlert('mb238'),'400','160',function(){});
			// 로그아웃된 경우
			isLogin = false;
<?php if(defined('__ISUSER__')){?>
			loadingStart("body",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});
				$.ajax({
				'url' : '../sns_process/facebooklogout',
				'dataType': 'json',
				'success': function(res) {
					if(res.result == true){
<?php if($_GET["return_url"]){?>
							document.location.href='<?php echo $_GET["return_url"]?>';
<?php }elseif($TPL_VAR["login"]||$TPL_VAR["register"]){?>
							document.location.href='../main/';
<?php }else{?>
							document.location.reload();
<?php }?>
					}else{
						document.location.reload();
					}
				}
				});

<?php }?>
			if (fbId != "")  initializeFbTokenValues();
			if (fbUid != "") initializeFbUserValues();
		}
	}

	//회원통합을 위한 로그인
	function handelStatusChangeconnect(response) {
		if (response && response.status == 'connected') {
		// 로그인
		isLogin = true;
		initializeFbTokenValues();
		initializeFbUserValues();
		fbId = response.authResponse.userID;
		fbAccessToken = response.authResponse.accessToken;
		FB.api('/me', function(response) {
			 fbUid = response.email;
			 fbName = response.name;
			 if (fbName != "") {
<?php if(!defined('__ISUSER__')){?>
				loadingStart("body",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});
					var userid = $("#facebook_userid").val();
					var password = $("#facebook_password").val();
					$.ajax({
					'url' : '../sns_process/facebookloginck',
					'data' : {'facebooktype':'mbconnect','userid':userid, 'password':password},
					'type' : 'post',
					'dataType': 'json',
					'success': function(res) {
						if(res.result == true){
							loadingStop("body",true);
							openDialogAlert(res.msg,'400','180',function(){
<?php if($_GET["return_url"]){?>
								document.location.href='<?php echo $_GET["return_url"]?>';
<?php }elseif($TPL_VAR["login"]||$TPL_VAR["register"]){?>
								document.location.href='/mypage/';
<?php }else{?>
								document.location.reload();
<?php }?>
							});
						}else{
							loadingStop("body",true);
							openDialogAlert(res.msg,'400','140',function(){});
						}
					}
					});
<?php }?>
			}
		});
	   } else if (response.status == 'not_authorized' || response.status == 'unknown') {
		   //연결을 취소하셨습니다.
			openDialogAlert(getAlert('mb238'),'400','160',function(){});
			// 로그아웃된 경우
			isLogin = false;
<?php if(defined('__ISUSER__')){?>
			loadingStart("body",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});
				$.ajax({
				'url' : '../sns_process/facebooklogout',
				'dataType': 'json',
				'success': function(res) {
					if(res.result == true){
<?php if($_GET["return_url"]){?>
							document.location.href='<?php echo $_GET["return_url"]?>';
<?php }elseif($TPL_VAR["login"]||$TPL_VAR["register"]){?>
							document.location.href='../main/';
<?php }else{?>
							document.location.reload();
<?php }?>
					}else{
						document.location.reload();
					}
				}
				});

<?php }?>
			if (fbId != "")  initializeFbTokenValues();
			if (fbUid != "") initializeFbUserValues();
		}
	}

	//회원통합하지 않고 가입하기
	function handelStatusChangenoconnect(response) {
		if (response && response.status == 'connected') {
		// 로그인
		isLogin = true;
		initializeFbTokenValues();
		initializeFbUserValues();
		fbId = response.authResponse.userID;
		fbAccessToken = response.authResponse.accessToken;
		FB.api('/me', function(response) {
			 fbUid = response.email;
			 fbName = response.name;
			 if (fbName != "") {
<?php if(!defined('__ISUSER__')){?>
				loadingStart("body",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});
					$.ajax({
					'url' : '../sns_process/facebookloginck',
					'data' : {'facebooktype':'noconnect'},
					'type' : 'post',
					'dataType': 'json',
					'success': function(res) {
						if(res.result == true){
							loadingStop("body",true);
							openDialogAlert(res.msg,'400','180',function(){
<?php if($_GET["return_url"]){?>
								document.location.href='<?php echo $_GET["return_url"]?>';
<?php }elseif($TPL_VAR["login"]||$TPL_VAR["register"]){?>
								document.location.href='/mypage/';
<?php }else{?>
								document.location.reload();
<?php }?>
							});
						}else{
							loadingStop("body",true);
							openDialogAlert(res.msg,'400','140',function(){});
						}
					}
					});
<?php }?>
			}
		});
	   } else if (response.status == 'not_authorized' || response.status == 'unknown') {
		   //연결을 취소하셨습니다.
			openDialogAlert(getAlert('mb238'),'400','160',function(){});
			// 로그아웃된 경우
			isLogin = false;
<?php if(defined('__ISUSER__')){?>
			loadingStart("body",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});
				$.ajax({
				'url' : '../sns_process/facebooklogout',
				'dataType': 'json',
				'success': function(res) {
					if(res.result == true){
<?php if($_GET["return_url"]){?>
							document.location.href='<?php echo $_GET["return_url"]?>';
<?php }elseif($TPL_VAR["login"]||$TPL_VAR["register"]){?>
							document.location.href='../main/';
<?php }else{?>
							document.location.reload();
<?php }?>
					}else{
						document.location.reload();
					}
				}
				});
<?php }?>
			if (fbId != "")  initializeFbTokenValues();
			if (fbUid != "") initializeFbUserValues();
		}
	}

	function initializeFbTokenValues() {
		fbId = "";
		fbAccessToken = "";
	}
	function initializeFbUserValues() {
		fbUid = "";
		fbName = "";
	}
	function logout(){
		// 로그아웃된 경우
		FB.logout();
		isLogin = false;
<?php if(defined('__ISUSER__')){?>
		loadingStart("body",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});
			$.ajax({
			'url' : '../sns_process/facebooklogout',
			'dataType': 'json',
			'success': function(res) {
				if(res.result == true){
<?php if($_GET["return_url"]){?>
						document.location.href='<?php echo $_GET["return_url"]?>';
<?php }elseif($TPL_VAR["login"]||$TPL_VAR["register"]){?>
						document.location.href='../main/';
<?php }else{?>
						document.location.reload();
<?php }?>
				}else{
					document.location.reload();
				}
			}
			});
<?php }?>
		if (fbId != "")  initializeFbTokenValues();
		if (fbUid != "") initializeFbUserValues();
	}
 </script>
<?php }?>

<style type="text/css">
	.subpage_sidemenu, #brandSideMenu {
		font-family: 'Hahmlet', serif;
	}
/* 레이아웃설정 폰트 적용 */
#layout_body body,
#layout_body table,
#layout_body div,
#layout_body input,
#layout_body textarea,
#layout_body select,
#layout_body span
{
<?php if($TPL_VAR["layout_config"]["font"]){?>		font-family:"<?php echo $TPL_VAR["layout_config"]["font"]?>" !important; <?php }?>
}

/* 레이아웃설정 스크롤바색상 적용 */
<?php if($TPL_VAR["layout_config"]["scrollbarColor"]){?>
html, body, div, textarea {
	scrollbar-base-color:#ffffff;
	scrollbar-arrow-color:<?php echo $TPL_VAR["layout_config"]["scrollbarColor"]?>;
	scrollbar-shadow-color:<?php echo $TPL_VAR["layout_config"]["scrollbarColor"]?>;
	scrollbar-3dlight-color:#ffffff;
	scrollbar-highlight-color:<?php echo $TPL_VAR["layout_config"]["scrollbarColor"]?>;
	scrollbar-darkshadow-color:#ffffff;
	scrollbar-face-color:#ffffff;
}
<?php }?>
</style>

<?php if($TPL_VAR["config_basic"]["naver_wcs_use"]=='y'&&!$_GET["popup"]&&!$_GET["iframe"]){?>
<!--[ 네이버 공통유입 스크립트 ]-->
<?php echo naverWcsScript()?>

<?php }?>

<!-- /자바스크립트 -->
<?php echo defaultScriptFunc()?></head>

<body>

<?php if($TPL_VAR["APP_USE"]=='f'&&$TPL_VAR["is_file_facebook"]){?>
<!--facebook area-->
<div id="fb-root"></div>
<!--facebook area end-->
<?php }?>