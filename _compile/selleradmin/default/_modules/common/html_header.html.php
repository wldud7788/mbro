<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/_modules/common/html_header.html 000006007 */  $this->include_("defaultScriptFunc");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<?php if($TPL_VAR["meta_title"]){?>
<title><?php echo $TPL_VAR["meta_title"]?></title>
<?php }else{?>
<title><?php echo $TPL_VAR["config_basic"]["shopName"]?><?php if(!preg_match('/order_print/',$_SERVER["REDIRECT_QUERY_STRING"])){?> 관리자환경 :: 퍼스트몰, 오직 운영자만을 생각한 가장 앞선 쇼핑몰입니다.<?php }?></title>
<?php }?>
<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />  -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<!-- CSS -->

<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/poshytip/style.css" />
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/editor/css/editor.css?v=<?php echo date('Ym')?>" />
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/common.css?v=<?php echo date('Ymd')?>" />
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/buttons.css?v=<?php echo date('Ymd')?>" />
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/boardnew.css?v=<?php echo date('Ymd')?>" />
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/page.css?v=<?php echo date('Ymd')?>" />
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/jqueryui/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/jqueryui/black-tie/jquery-ui-1.8.16.custom.css" />

<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/layout.css?mm=<?php echo date('Ymd')?>" />
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/common-ui.css?mm=<?php echo date('Ymd')?>" >

<?php if($TPL_VAR["config_system"]["favicon"]){?>
<!-- 파비콘 -->
<link rel="shortcut icon" href="<?php echo $TPL_VAR["config_system"]["favicon"]?>" />
<?php }?>

<!-- 자바스크립트 [순서변경하지마세요] -->
<script nonce="<?php echo script_nonce()?>"><?php echo front_config_js()?></script>
<?php if(preg_match('/category\/catalog/',$_SERVER["REQUEST_URI"])){?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.min.1.6.4.js"></script>
<?php }else{?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>
<?php }?>
<script type="text/javascript" src="/app/javascript/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.hotkeys.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.poshytip.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.activity-indicator-1.0.0.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.cookie.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-select-box.js"></script>
<script type="text/javascript" src="/app/javascript/js/dev-tools.js"></script>
<script type="text/javascript" src="/app/javascript/js/selleradmin-layout.js?dummy=<?php echo date('Ymd')?>&krdomain=http://<?php echo $TPL_VAR["config_system"]["subDomain"]?>"></script>
<script type="text/javascript" src="/data/js/language/L10n_<?php echo $TPL_VAR["config_system"]["language"]?>.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/common.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-common-ui.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-bookmark.js?mm=<?php echo date('Ymd')?>"></script>

<!--[if lt IE 9]>
<script type="text/javascript" src="/app/javascript/jquery/html5shiv.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/respond.min.js"></script>
<![endif]-->
<?php if($TPL_VAR["video_use"]){?>
<script type="text/javascript">
var video_use = 'Y';//동영상설정여부
</script>
<?php }?>
<?php if($_GET["id"]){?>
<script type="text/javascript">
//<![CDATA[
var board_id = '<?php echo $_GET["id"]?>';
//]]>
</script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('YmdH')?>"></script>
<?php }?>

<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"></script>

<script type="text/javascript">
//<![CDATA[
//한글도메인체크@2013-03-12
var fdomain = document.domain;
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
var gl_amout_list						= new Array();
<?php if(is_array($TPL_R1=$TPL_VAR["config_system"]["basic_amout"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
gl_amout_list['<?php echo $TPL_K1?>'] = '<?php echo $TPL_V1?>';
<?php }}?>
var gl_currency_exchange = "<?php echo $TPL_VAR["config_currency"][$TPL_VAR["basic_currency"]]['currency_exchange']?>";

//]]>
</script>
<?php echo defaultScriptFunc()?></head>