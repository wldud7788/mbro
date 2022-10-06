<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/order/_kicc_nax.html 000001707 */  $this->include_("defaultScriptFunc");
$TPL_param_1=empty($TPL_VAR["param"])||!is_array($TPL_VAR["param"])?0:count($TPL_VAR["param"]);?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>KICC input -> settle 로 form 전송</title>
<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>
<script type="text/javascript">
	// PC와 mobile에 따라서 실행되는 스크립트가 달라 컨트롤러 영역에서 구성해서 실행
	<?php echo $TPL_VAR["javascript_callPgDelay"]?>


	function setPayInfo(){
		var inputTag = '<form method="post" name="kicc_frm_pay" id="kicc_frm_pay">';

		$('#PAYINFO > input').each(function(index){
			inputTag += '<input type="' + $(this).attr('type') + '" name="' + $(this).attr('name')  + '" id="' + $(this).attr('id')  + '" value="' + $(this).val()  + '" />';
		});
		
		inputTag += '</form>';

		// getScript 한번만 호출하기 위해서 javascript_callPgDelay(kicclib) 으로 위치 이동 2020-04-01

		callPgDelay(inputTag);
	}
</script>
<?php echo defaultScriptFunc()?></head>
<body>
<form method="post" name="PAYINFO" id="PAYINFO">
<?php if($TPL_VAR["jsonParam"]){?>
	<input type='hidden' name='jsonParam' id='jsonParam' value='<?php echo $TPL_VAR["jsonParam"]?>'>
<?php }?>

<?php if($TPL_param_1){foreach($TPL_VAR["param"] as $TPL_K1=>$TPL_V1){?>
	<input type='hidden' name='<?php echo $TPL_K1?>' id='<?php echo $TPL_K1?>' value='<?php echo $TPL_V1?>'>
<?php }}?>
</form>
</body>
<script type="text/javascript">setPayInfo()</script>
</html>