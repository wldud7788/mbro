<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/mypage/_wish2cart.html 000002703 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 위시리트스트 페이지에서 장바구니로 담을때 옵션 선택 @@
- 파일위치 : [스킨폴더]/mypage/_wish2cart.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript" src="/app/javascript/plugin/jquery_selectbox/js/jquery.selectbox-0.2.js"></script>

<form name="goodsForm" method="post" action="/order/add" enctype="multipart/form-data" target="actionFrame">
<input type="hidden" name="goodsSeq" value="<?php echo $TPL_VAR["goods"]["goods_seq"]?>" />

<div class="cart_dialog_img">
	<a href="/goods/view?no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>" target="_blank"><img src="<?php echo $TPL_VAR["goods"]["image"]?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl/images/common/noimage.gif'" alt="" /></a>
	<span class="name"><?php echo $TPL_VAR["goods"]["goods_name"]?></span>
</div>
<div class="cart_dialog_option">
<?php $this->print_("OPTION_SELECT",$TPL_SCP,1);?>

</div>


<ul class="cart_dialog_foot">
	<li class="price_area">
		<strong>총 금액:</strong>
<?php if(($TPL_VAR["goods"]["price"]>$TPL_VAR["goods"]["sale_price"])||($TPL_VAR["goods"]["consumer_price"]>$TPL_VAR["goods"]["sale_price"]&&$TPL_VAR["goods"]["event"]["target_sale"]== 1)){?>
			<?php echo get_currency_price($TPL_VAR["goods"]["sale_price"], 2,'','<span id="total_goods_price"  class="red">_str_price_</span>','red fx13')?>

<?php }else{?>
			<?php echo get_currency_price($TPL_VAR["goods"]["price"], 2,'','<span id="total_goods_price"  class="red">_str_price_</span>','red fx13')?>

<?php }?>
	</li>
	<li class="btn_area">
		<button type="button" id="addCart" class="btn_resp color2"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL215cGFnZS9fd2lzaDJjYXJ0Lmh0bWw=" >장바구니담기</span></button>
	</li>
</ul>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$('button#addCart').bind('click', function(){
		$("form[name='goodsForm']").submit();
		hideCenterLayer();
	});

	// PC 사이즈에서 옵션값 추가로 레이어 높이값이 달라질 경우 
	if ( window.innerWidth > 767 ) {
		var gon = $('#cart_dialog .y_scroll_auto').height();
		$( document ).ajaxComplete(function() {
			if ( $('#cart_dialog').is(':visible') ) {
				var gon2 = $('#cart_dialog .y_scroll_auto').height();
				if ( gon2 > gon ) {
					showCenterLayer('#cart_dialog');
					gon = gon2;
				}
			}
		});
	}
});
</script>