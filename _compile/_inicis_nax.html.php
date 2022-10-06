<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/order/_inicis_nax.html 000001327 */  $this->include_("defaultScriptFunc");
$TPL_param_1=empty($TPL_VAR["param"])||!is_array($TPL_VAR["param"])?0:count($TPL_VAR["param"]);?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>LG 유플러스 input -> settle 로 form 전송</title>
<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>
<script type="text/javascript">
	function setPayInfo(){
		var inputTag = '<form method="post" name="SendPayForm_id" id="SendPayForm_id">';

		$('#PAYINFO > input').each(function(index){
			inputTag += '<input type="' + $(this).attr('type') + '" name="' + $(this).attr('name')  + '" id="' + $(this).attr('id')  + '" value="' + $(this).val()  + '" />';
		});
		
		inputTag += '</form>';
		
		parent.$('body').append(inputTag);

		parent.pay();
	}
</script>
<?php echo defaultScriptFunc()?></head>
<body>
<form method="post" name="PAYINFO" id="PAYINFO">
<?php if($TPL_param_1){foreach($TPL_VAR["param"] as $TPL_K1=>$TPL_V1){?>
	<input type='hidden' name='<?php echo $TPL_K1?>' id='<?php echo $TPL_K1?>' value='<?php echo $TPL_V1?>'>
<?php }}?>
</form>
</body>
<script type="text/javascript">setPayInfo()</script>
</html>