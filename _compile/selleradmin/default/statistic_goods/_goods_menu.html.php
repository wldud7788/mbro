<?php /* Template_ 2.2.6 2022/05/17 12:29:33 /www/music_brother_firstmall_kr/selleradmin/skin/default/statistic_goods/_goods_menu.html 000001335 */ ?>
<!-- 2022.01.03 11월 3차 패치 by 김혜진 -->
<ul class="tab_01 v2 pageSetTab">

<?php if(!$TPL_VAR["statistic_goods_detail_limit"]){?>
	<li><a href="goods_sales" value="goods_sales">매출통계</a></li>
	<li><a href="goods_stat" value="goods_stat">상품통계</a></li>
	<li><a href="goods_cart" value="goods_cart">장바구니</a></li>
	<li><a href="goods_wish" value="goods_wish">위시리스트</a></li>
	<li><a href="goods_review" value="goods_review">상품후기</a></li>
	<li><a href="goods_restock" value="goods_restock">재입고알림</a></li>
<?php }else{?>
	<li><a href="#" class="nofreelinknone">매출통계</a></li>
	<li><a href="#" class="nofreelinknone">상품통계</a></li>
	<li><a href="#" class="nofreelinknone">장바구니</a></li>
	<li><a href="#" class="nofreelinknone">위시리스트</a></li>
	<li><a href="#" class="nofreelinknone">상품후기</a></li>
	<li><a href="#" class="nofreelinknone">재입고알림</a></li>
<?php }?>
	<!--
    <li><a href="shop_emoney">마일리지현황</a></li>
    <li><a href="shop_goods">상품현황</a></li>
    <li><a href="shop_supply">공급처(사입처)현황</a></li>
    -->

</ul>