<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/setting/_setting_menu.html 000002183 */ ?>
<div class="slc-head hide">
	<ul>
		<li><span class="mitem multi"><a href="multi">상점 관리</a></span></li>
		<li><span class="mitem pg"><a href="pg">전자결제</a></span></li>
		<li><span class="mitem bank"><a href="bank">무통장</a></span></li>
		<li><span class="mitem shipping"><a href="shipping_group">배송비</a></span></li>
		<li><span class="mitem delivery"><a href="delivery_company">택배사</a></span></li>
		<li><span class="mitem"><a href="member">회원</a></span></li>
		<li><span class="mitem"><a href="snsconf">SNS 연동</a></span></li>
		<li><span class="mitem"><a href="order">주문</a></span></li>
		<li><span class="mitem"><a href="reserve">마일리지/포인트/예치금</a></span></li>
		<li><span class="mitem"><a href="sale">매출증빙</a></span></li>
<?php if(serviceLimit('H_FR')){?>
		<li><span class="mitem"><a href="#" onclick="<?php echo serviceLimit('A1')?>">상품코드/정보</a></span></li>	
<?php }else{?>
		<li><span class="mitem"><a href="goods">상품코드/정보</a></span></li>	
<?php }?>
		<li><span class="mitem seo"><a href="seo">검색엔진최적화(SEO)</a></span></li>
		<li><span class="mitem"><a href="operating">운영 방식</a></span></li>
		<li><span class="mitem"><a href="manager">관리자</a></span></li>
		<li><span class="mitem"><a href="protect">보안</a></span></li>
<?php if(serviceLimit('H_FR')){?>		
		<li><span class="mitem"><a href="#" onclick="<?php echo serviceLimit('A1')?>">검색</a></span></li>
<?php }else{?>		
		<li><span class="mitem"><a href="search">검색</a></span></li>
<?php }?>
		<li><span class="mitem"><a href="alert_setting">안내메시지</a></span></li>
		<li><span class="mitem"><a href="video">동영상</a></span></li>
		<li><span class="mitem"><a href="cache">캐시</a></span></li>	
	</ul>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("div.slc-head a[href='<?php echo $TPL_VAR["selected_setting_menu"]?>']").parent().parent().addClass("selected");	
	});
</script>