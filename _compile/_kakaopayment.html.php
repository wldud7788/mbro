<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/order/_kakaopayment.html 000003425 */  $this->include_("defaultScriptFunc");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="utf-8" lang="utf-8">
<head>
    <title>카카오페이 결제 페이지</title>
	<meta http-equiv="cache-control" content="no-cache"/>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="/app/javascript/jquery/jquery.min.1.6.4.js" charset="urf-8"></script>

	<!-- 카카오페이------------------------------------------------- -->
	<script type="text/javascript">
	function openpop_kakaopay(){
		var next_redirect_url		= $("input[name='next_redirect_url']").val();
		if(next_redirect_url){

			$("body",parent.document).prepend('<div id="lay_mask" style="position:fixed; background:gray; z-index:100001; opacity:0.4; filter:alpha(opacity=40); background:rgba(0,0,0,.4); filter: progid: DXImageTransform.Microsoft.gradient(startColorstr=#4C000000, endColorstr=#4C000000);display: none;">');
			var mask = $("#lay_mask",parent.document);
	
			//화면의 높이와 너비를 구한다. 
			var maskHeight = $(parent.document).height();
			var maskWidth = $(parent.window).width();

			//마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다. 
			mask.css({'width':maskWidth,'height':maskHeight});
			mask.show();

<?php if($TPL_VAR["agent"]=='pc'){?>
			$("#kakaopay_layer",parent.document).css('width','450px');
			$("#kakaopay_layer",parent.document).css('height','550px');
			$("#kakaopay_layer",parent.document).css('position','fixed');
			var left	= ( $(parent.window).scrollLeft() + ($(parent.window).width() - $("#kakaopay_layer",parent.document).width()) / 2 );
			var top		= '10px';//( $(parent.window).scrollTop() + ($(parent.window).height() - $("#kakaopay_layer",parent.document).height()) / 2 );
<?php }else{?>
			$("#kakaopay_layer",parent.document).css('width','100%');
			$("#kakaopay_layer",parent.document).css('height','100%');
			$("#kakaopay_layer",parent.document).css('position','fixed');
			var left	= 0;
			var top		= 0;
<?php }?>

			$("#kakaopay_layer",parent.document).html('<iframe name="paycall_frame" id="paycall_frame" src="'+next_redirect_url+'" width="100%" height="100%" style="border:0;"></iframe>');
			$("#kakaopay_layer",parent.document).append($("#payForm").html());
			$("#kakaopay_layer",parent.document).css('z-index','100002');
			$("#kakaopay_layer",parent.document).css('top',top);
			$("#kakaopay_layer",parent.document).css('left',left);
			$("#kakaopay_layer",parent.document).show();
		}		
	}
	</script>
<?php echo defaultScriptFunc()?></head>
<body>

<form name="payForm" id="payForm" action="../payment/kakaopay"  method="post" accept-charset="utf-8">
<input type="hidden" name="tid" value="<?php echo $TPL_VAR["param"]["tid"]?>" />
<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["param"]["order_seq"]?>" />
<input type="hidden" name="next_redirect_url" value="<?php echo $TPL_VAR["param"]["next_redirect_url"]?>" />
<input type="hidden" name="created_at" value="<?php echo $TPL_VAR["param"]["created_at"]?>" />
</form>
</body>
<script>openpop_kakaopay();</script>
</html>