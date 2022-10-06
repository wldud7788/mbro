<?php /* Template_ 2.2.6 2022/05/17 12:36:23 /www/music_brother_firstmall_kr/admin/skin/default/marketing/npay_btn_style_iframe.html 000001384 */  $this->include_("defaultScriptFunc");?>
<html>
<head>
<?php if($TPL_VAR["mode"]=="mobile_goods"){?>
<?php if($TPL_VAR["navercheckout"]["use"]=='test'){?>
<script type="text/javascript" src="//test-pay.naver.com/customer/js/mobile/naverPayButton.js" charset="UTF-8"></script>
<?php }else{?>
<script type="text/javascript" src="//pay.naver.com/customer/js/mobile/naverPayButton.js" charset="UTF-8"></script>
<?php }?>
<?php }else{?>
<script type="text/javascript" src="//pay.naver.com/customer/js/naverPayButton.js" charset="UTF-8"></script>
<?php }?>

<style>
body {margin:0px;padding:0px;}
.npay_storebtn_bx { margin-left:0px !important; }
#nhn_btn{text-align:center;}
</style>
<?php echo defaultScriptFunc()?></head>

<body>
<?php if($TPL_VAR["sel_npay_btn"]["type"]&&$TPL_VAR["sel_npay_btn"]["color"]&&$TPL_VAR["sel_npay_btn"]["count"]){?>
<div id="nhn_btn">
	<img src="/admin/skin/default/images/common/npay/<?php echo $TPL_VAR["sel_npay_btn"]["type"]?>-<?php echo $TPL_VAR["sel_npay_btn"]["color"]?>-<?php echo $TPL_VAR["sel_npay_btn"]["count"]?>_on.gif">
</div>
<?php }else{?>
<div style="margin:3px;font-size:12px; color:#000;">버튼 스타일을 선택해 주세요.</div>
<?php }?>

</body>
</html>