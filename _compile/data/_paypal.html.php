<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/order/_paypal.html 000002312 */  $this->include_("defaultScriptFunc");?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PayPal Express Checkout 範例程式</title>
<?php echo defaultScriptFunc()?></head>
	<style type="text/css">
	<!--
	.txt12 {
		font-size: 12px;
		line-height: 20px;
		color: #333;
		font-family:Arial, Helvetica, sans-serif;
	}
	-->
	</style>
<body>
<center>

<form action="/order/paypal_order" method="POST" name="paypalFrm">
<input type="text" name="order_seq" value="<?php echo $TPL_VAR["order_seq"]?>">
<input type="text" name="mode" value="<?php echo $TPL_VAR["mode"]?>">
	<div style="width:600px;">
		<table width="100%" cellpadding="2">
		  <tr>
			<td width="22%" align="left"><img border="0" src="https://www.paypal.com/en_US/i/logo/paypal_logo.gif" alt="PayPal"></td>
			<td align="right" style="color:#036">&nbsp;</td>
			</tr>
		  <tr>
			<td colspan="2" align="left"><p style="color:#036"><strong>Express Checkout (Sandbox)</strong></p></td>
			</tr>
		</table>
		
	</div>


	<div style="width:600px">
		<fieldset>
		<legend style="margin-top:10px; color:#036">Order Summary  </legend>
		<table width="80%" class="txt12">
		<tr>
		<td>Item1</td>
		<td><input type="text" name="L_NAME[]" size="20" maxlength="32" value="<?php echo $TPL_VAR["goods_name"]?>" /></td>
		<td>Unit</td>
		<td><input type="text" name="L_AMT[]" size="5" maxlength="7" value="<?php echo $TPL_VAR["settle_price"]?>" /></td>
		<td>Qty</td>
		<td><input type="text" name="L_QTY[]" size="3" maxlength="3" value="1" /> </td>
		</tr>
		<tr>
		<td ><p>Currency</p></td>
		<td colspan="5">
			<select name="currencyCodeType">
            <option value="<?php echo $TPL_VAR["basic_currency"]?>" selected><?php echo $TPL_VAR["basic_currency"]?></option>            
		</select></td>
		</tr>
			</table>
		<p>&nbsp;</p>
	  </fieldset>
		<p align="right">
		  <input type="image" name="submit" src="/order/SunriseBtn_EN.png" />
		</p>
	</div>
</form>
    
<script type="text/javascript">
//document.paypalFrm.target = "_top";
//document.paypalFrm.target = "_blank";
document.paypalFrm.submit();
</script>

</body>
</html>