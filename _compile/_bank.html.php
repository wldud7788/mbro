<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/order/_bank.html 000000424 */ ?>
<form name="bank_form" method="post" action="../payment/bank">
<input type="text" name="order_seq" value="<?php echo $TPL_VAR["order_seq"]?>" />
<input type="text" name="adminOrder" value="<?php echo $TPL_VAR["adminOrder"]?>" />
</form>
<script type="text/javascript">
document.bank_form.submit();
</script>