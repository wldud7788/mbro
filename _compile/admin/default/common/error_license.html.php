<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/common/error_license.html 000003307 */  $this->include_("defaultScriptFunc");?>
<html>
<head>
<title><?php echo $TPL_VAR["config_basic"]["companyName"]?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layout.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/buttons.css" />

<?php if($TPL_VAR["config_system"]["favicon"]){?>
<link rel="shortcut icon" href="<?php echo $TPL_VAR["config_system"]["favicon"]?>" />
<?php }?>

<?php echo defaultScriptFunc()?></head>
<body>

	<table style="position:fixed; z-index:10000; left:0px; top:0px; width:100%; height:100%; background-color:#fff;">
	<tr>
		<td align="center">
			<table>
			<tr><td align="center"><img src="/admin/skin/default/images/common/img_no.gif" /></td></tr>
			<tr><td height="25"></td></tr>
			<tr><td><img src="/admin/skin/default/images/common/img_txt_no_license.gif" /></td></tr>
			<tr><td height="5"></td></tr>
<?php if($TPL_VAR["code"]){?>
			<tr><td align="center" style="color:#000; font-weight:bold; font-family:tahoma; font-size:16px;">(CODE : <?php echo $TPL_VAR["code"]?>)</td></tr>
			<tr><td height="15"></td></tr>
<?php }?>
			<tr><td align="center" style="color:#626262; font-family:dotum; font-size:12px;">가비아 퍼스트몰 고객센터(1544-3270)로 문의 바랍니다.</td></tr>	
			</table>
		</td>
	</tr>
	<tr>
		<td height="130" class="center" style="line-height:20px;">
			<!-- 이미지로 카피라이트를 이용하실 분들은 주석을 해제하여 사용하여 주십시요  -->
			<!-- <img src="/admin/skin/default/images/design/footer_txt.gif" /><br />-->		
			회사명 : <?php echo $TPL_VAR["config_basic"]["companyName"]?>

			<font color="cccccc"><b> | </b></font>사업자등록번호 : <?php echo $TPL_VAR["config_basic"]["businessLicense"]?>

			<font color="cccccc"><b> | </b></font>주소 : <?php echo $TPL_VAR["config_basic"]["companyAddress"]?> <?php echo $TPL_VAR["config_basic"]["companyAddressDetail"]?><br />
			통신판매업 신고 : <?php echo $TPL_VAR["config_basic"]["mailsellingLicense"]?>

			<font color="cccccc"><b> | </b></font>연락처 : <?php echo $TPL_VAR["config_basic"]["companyPhone"]?>

<?php if($TPL_VAR["config_basic"]["companyFax"]){?>
			<font color="cccccc"><b> | </b></font>FAX : <?php echo $TPL_VAR["config_basic"]["companyFax"]?>

<?php }?>
			<font color="cccccc"><b> | </b></font>개인정보 보호책임자 : <?php echo $TPL_VAR["config_basic"]["member_info_manager"]?>

			<font color="cccccc"><b> | </b></font>대표자 : <?php echo $TPL_VAR["config_basic"]["ceo"]?><br />
			contact : <font color="990000"><b><?php echo $TPL_VAR["config_basic"]["companyEmail"]?></b></font> for more information
		</td>
	</tr>	
	</table>
	
	
</body>
</html>