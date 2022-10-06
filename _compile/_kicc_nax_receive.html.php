<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/order/_kicc_nax_receive.html 000001502 */  $this->include_("defaultScriptFunc");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<title>kicc webpay 가맹점 page</title>
<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>
<?php echo defaultScriptFunc()?></head>
<body>
    <form name="frm" method="post">
<?php if($TPL_VAR["jsonParamRecevie"]){?>
	<input type='hidden' name='jsonParamRecevie' id='jsonParamRecevie' value='<?php echo $TPL_VAR["jsonParamRecevie"]?>'>
<?php }?>
    </form>
</body>

<script>
$(document).ready(function(){
	var jsonParamRecevie = $("#jsonParamRecevie");
	parent.$('body').find("form[name='kicc_frm_pay']").find("#jsonParamRecevie").remove();
	parent.$('body').find("form[name='kicc_frm_pay']").append(jsonParamRecevie);
	parent.$('body').find("form[name='kicc_frm_pay']").attr("action", "/kicc/apply");
	parent.$('body').find("form[name='kicc_frm_pay']").attr("target", "actionFrame");
	parent.$('body').find("form[name='kicc_frm_pay']").submit();
	window.parent.kicc_popup_close();
});
</script>
</html>