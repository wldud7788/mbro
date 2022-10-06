<?php /* Template_ 2.2.6 2022/05/17 12:36:55 /www/music_brother_firstmall_kr/admin/skin/default/setting/bank_payment.html 000000642 */ ?>
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
<iframe name="gabiaPayment" id="gabiaPayment" width="100%" height="500" frameborder="0"></iframe>