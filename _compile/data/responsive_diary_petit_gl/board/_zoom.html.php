<?php /* Template_ 2.2.6 2020/10/15 17:39:14 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/board/_zoom.html 000001985 */  $this->include_("defaultScriptFunc");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>클릭이나 스페이스바를 누르면 닫힙니다.</title>
<meta http-equiv="imagetoolbar" content="no" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php echo defaultScriptFunc()?></head>
<script language="javascript">
var windowX, windowY;
var bLargeImage = 0;
var x,y;

function isMSIE()
{
	return navigator.appName.indexOf('Explorer') != -1 ? true : false;
}
function processKey(e)
{
	var ekey = isMSIE() ? event.keyCode : e.which;
	if (ekey=='32')
	{
		window.close();
	}
}

function fitWindowSize()
{
	window.resizeTo(500, 500);
	var width = 500 - (document.body.clientWidth - document.images[0].width);
	var height = 500 - (document.body.clientHeight - document.images[0].height )+200;
	var windowX = (window.screen.width-width)/2;
	var windowY = (window.screen.height-height)/2;

	if(width>screen.width)
	{
		width = screen.width;
		windowX = 0;
		bLargeImage = 1;
	}
	if(height>screen.height-50)
	{
		height = screen.height-50;
		windowY = 0;
		bLargeImage = 1;
	}

	x = width/2;
	y = height/2;
	window.resizeTo(width, height);
	window.moveTo(windowX,windowY);
}

function move()
{
	if(bLargeImage)
	{
		window.scroll(window.event.clientX - 50,window.event.clientY -50);
	}
}
document.onkeydown = processKey;
</script>
<body onLoad="fitWindowSize()" onmousemove="move();" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" oncontextmenu="return false">
<a href="#" onclick="window.close();"><img id="image" <?php if($TPL_VAR["url"]){?> width="<?php if($TPL_VAR["width"]>= 1000){?>1000<?php }else{?><?php echo $TPL_VAR["width"]?><?php }?>" <?php }?> src=<?php echo $TPL_VAR["url"]?>  border="0" /></a>