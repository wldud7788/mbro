<?php /* Template_ 2.2.6 2022/05/17 12:36:28 /www/music_brother_firstmall_kr/admin/skin/default/member/kakaotalk_payment.html 000000646 */ ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#gabiaFrm').attr('action', '//firstmall.kr/payment_firstmall/');
	$('#gabiaFrm').attr('target', 'gabiaPayment');
	setTimeout(function(){
		$('#gabiaFrm').submit();
	},100);
});
</script>


<form name="gabiaFrm" id="gabiaFrm" method="post">
<input type="hidden" name="mm_param" value="<?php echo $TPL_VAR["param"]?>">
</form>
<iframe name="gabiaPayment" id="gabiaPayment" width="100%" height="700" frameborder="0"></iframe>