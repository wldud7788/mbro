<?php /* Template_ 2.2.6 2021/12/15 17:48:38 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/errdoc/404.html 000002489 */  $this->include_("defaultScriptFunc");?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<title>Error 404 - Page Not Found</title>
<link rel="stylesheet" type="text/css" href="/data/skin/responsive_ver1_default_gl/css/common.css" />
<style type="text/css">
.intro_content {text-align:center; }
.intro_title {font-size:32px; line-height:1.3; font-weight:400;color:#000;padding-top:40px;}
.intro_title2 {font-size:21px; line-height:1.3; font-weight:100;color:#999;padding-top:20px;}
.intro_title_small {font-size:17px; font-weight:300; padding:10px 0px 0;}
.intro_btns { padding-top:30px; }
</style>
<?php echo defaultScriptFunc()?></head>
<body>

<div class="full_layout">
	<ul class="single_contents">
		<li>
			<div class="intro_content">
				<p><img src="/data/skin/responsive_ver1_default_gl/images/common/pc_img_404.gif" alt="Error 404" /></p>
				<p class="intro_title">Error 404 - Page Not Found</p>
				<p class="intro_title2 Fw100">
					요청하신 페이지를 찾을 수 없습니다.<br />
					URL을 다시 확인하시기 바랍니다.<br />
				</p>
				<p class="intro_btns">
					<a class="btn_resp size_c color2 Fw100" href="/">쇼핑몰 바로가기</a>
				</p>
				<p class="intro_title_small" style="padding-top:30px;">
					<?php echo $TPL_VAR["companyName"]?> &nbsp;|&nbsp; <a href="tel:<?php echo $TPL_VAR["companyPhone"]?>"><?php echo $TPL_VAR["companyPhone"]?></a>
				</p>
			</div>
		</li>
	</ul>
</div>

<script type="text/javascript">
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};
</script>

</body>
</html>