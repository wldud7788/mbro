<?php /* Template_ 2.2.6 2022/05/17 12:37:08 /www/music_brother_firstmall_kr/admin/skin/default/statistic_goods/_goods_menu.html 000001544 */ ?>
<div class="slc-head pdt5">
<ul>
<?php if(!$TPL_VAR["statistic_goods_detail_limit"]){?>
	<li><span class="mitem"><a href="goods_cart">장바구니</a></span></li>
	<li><span class="mitem"><a href="goods_wish">위시리스트</a></span></li>
	<li><span class="mitem"><a href="goods_search">검색어</a></span></li>
	<li><span class="mitem"><a href="goods_review">상품후기</a></span></li>
	<li><span class="mitem"><a href="goods_restock">재입고알림</a></span></li>
<?php }else{?>
	<li><span class="nofreelinknone mitem"><a href="#">장바구니</a></span></li>
	<li><span class="nofreelinknone mitem"><a href="#">위시리스트</a></span></li>
	<li><span class="nofreelinknone mitem"><a href="#">검색어</a></span></li>
	<li><span class="nofreelinknone mitem"><a href="#">상품후기</a></span></li>
	<li><span class="nofreelinknone mitem"><a href="#">재입고알림</a></span></li>
<?php }?>
	<!--
	<li><span class="mitem"><a href="shop_emoney">마일리지현황</a></span></li>
	<li><span class="mitem"><a href="shop_goods">상품현황</a></span></li>
	<li><span class="mitem"><a href="shop_supply">공급처(사입처)현황</a></span></li>
	-->

</ul>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("div.slc-head a[href='<?php echo $TPL_VAR["selected_goods_menu"]?>']").parent().parent().addClass("selected");
});

</script>