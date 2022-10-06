<?php /* Template_ 2.2.6 2022/05/17 12:31:53 /www/music_brother_firstmall_kr/admin/skin/default/goods/set_goods_options.html 000007067 */  $this->include_("defaultScriptFunc");?>
<?php if($TPL_VAR["mode"]!='view'){?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
	<title><?php echo $TPL_VAR["config_basic"]["shopName"]?><?php if(!preg_match('/order_print/',$_SERVER["REDIRECT_QUERY_STRING"])){?> 관리자환경 :: 퍼스트몰, 오직 운영자만을 생각한 가장 앞선 쇼핑몰입니다.<?php }?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex,nofollow">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<script nonce="<?php echo script_nonce()?>"><?php echo front_config_js()?></script>
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common.css" />
	<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layout.css" />
	<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/buttons.css" />
	<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/boardnew.css" />
	<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/page.css" />
	<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/jqueryui/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/jqueryui/black-tie/jquery-ui-1.8.16.custom.css" />
	<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/poshytip/style.css" />
	<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/goods_admin.css" />
	<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/editor/css/editor.css" />

	<style>body {overflow-x:hidden;}</style>
<?php if($TPL_VAR["config_system"]["favicon"]){?>
	<!-- 파비콘 -->
	<link rel="shortcut icon" href="<?php echo $TPL_VAR["config_system"]["favicon"]?>" />
<?php }?>
	<!-- 자바스크립트 [순서변경하지마세요] -->
<?php if(preg_match('/goods\/regist/',$_SERVER["REQUEST_URI"])||preg_match('/category\/catalog/',$_SERVER["REQUEST_URI"])){?>
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
	<script type="text/javascript" src="/app/javascript/js/admin-layout.js?dummy=130813&krdomain=http://<?php echo $TPL_VAR["config_system"]["subDomain"]?>"></script>
	<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?v=20140317"></script>
	<script type="text/javascript" src="/app/javascript/js/admin-goodsaddlayer.js"></script>
	<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
	<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
	<script type="text/javascript" src="/app/javascript/js/admin-layout.js?dummy=<?php echo date('YmdHis')?>&krdomain=http://<?php echo $TPL_VAR["config_system"]["subDomain"]?>"></script>
	<script type="text/javascript" src="/data/js/language/L10n_<?php echo $TPL_VAR["config_system"]["language"]?>.js?dummy=<?php echo date('YmdHis')?>"></script>
	<script type="text/javascript" src="/app/javascript/js/common-function.js"></script>
	<script  type="text/javascript">
		var gl_goods_seq = '<?php echo $TPL_VAR["goods_seq"]?>';
		var gl_package_yn = '<?php echo $_GET["package_yn"]?>';
		$(document).ready(function(){
<?php if($TPL_VAR["reload"]=='y'){?>
			location.replace('?tmp_seq=<?php echo $TPL_VAR["tmp_seq"]?>&tmp_policy=<?php echo $TPL_VAR["tmp_policy"]?>&socialcp_input_type=<?php echo $_GET["socialcp_input_type"]?><?php if($TPL_VAR["mode"]=='view'){?>&mode=view&goods_seq=<?php echo $TPL_VAR["goods_seq"]?><?php }?>&provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&package_yn=<?php echo $_GET["package_yn"]?>');
<?php if($TPL_VAR["mode"]=='view'){?>socialcpinputtype();<?php }?>
<?php }elseif($TPL_VAR["mode"]=='view'){?>
<?php if($TPL_VAR["options"]){?>
				$("#optionLayer", parent.document).html($("#optionLayer").html());
				$("#preview_option_divide", parent.document).html($("#preview_option_divide").html());
				$("#preview_option_sum", parent.document).html($("#preview_option_sum").html());
				parent.chgSuboptionReservePolicy('<?php echo $TPL_VAR["options"][ 0]["tmp_policy"]?>');
<?php }?>
<?php }?>

				help_tooltip();
				socialcpinputtype();
			});

//
			function socialcpinputtype() {
<?php if($_GET["socialcp_input_type"]){?>
				var socialcp_input_type = '<?php echo $_GET["socialcp_input_type"]?>';
<?php }else{?>
				var socialcp_input_type = $("input[name='socialcp_input_type']:checked", window.opener.document).val();
<?php }?>

				if(socialcp_input_type) {
					var couponinputsubtitle = '';
					$(".couponinputtitle").show();
					if( socialcp_input_type == 'price' ) {
						couponinputsubtitle = '금액';
					}else{
						couponinputsubtitle = '횟수';
					}
<?php if($TPL_VAR["mode"]!='view'){?>$(".socialcpuseopen").val(socialcp_input_type);	<?php }?>
						$(".couponinputsubtitle").text(couponinputsubtitle);
					}

<?php if($TPL_VAR["mode"]!='view'){?>
					//과세/부가세 체크
<?php if($_GET["goodsTax"]){?>
					var goodsTax = '<?php echo $_GET["goodsTax"]?>';
<?php }else{?>
					var goodsTax = $("input[name='tax']:checked", window.opener.document).val();
<?php }?>
					$(".goodsTax").val(goodsTax);
<?php }?>
				}

				$(window).on("beforeunload", function() {
					parent.opener.freqOptionsReload('opt');
				})

	</script>
<?php echo defaultScriptFunc()?></head>
<body>
<div id="wrap">
<?php }?>

<?php if($TPL_VAR["mode"]=='view'){?>
<?php $this->print_("ONLY_VIEW",$TPL_SCP,1);?>

<?php }else{?>
<?php $this->print_("EDIT_VIEW",$TPL_SCP,1);?>

<?php }?>

	<div id="packageErrorDialog" class="hide"></div>
<?php if($TPL_VAR["mode"]!='view'){?>
<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>

<?php }?>

	<div id="helperMessageShow" class="hide"><span id="helperMessage"></div></div>
</body>