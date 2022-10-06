<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/_modules/common/mycart_top.html 000001721 */  $this->include_("showMycartTop");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 장바구니/위시리스트/최근 본 상품 - 탭 @@
- 파일위치 : [스킨폴더]/_modules/common/mycart_top.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="tab_cart_top">
	<ul class="clearbox">
		<li <?php if(uri_string()=='order/cart'){?>class="on"<?php }?>>
			<a href="javascript:void(0)" onclick="var result = confirm('장바구니로 이동합니다'); if(result) { location.replace('/order/cart'); }" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9fbW9kdWxlcy9jb21tb24vbXljYXJ0X3RvcC5odG1s" >장바구니</span> <span class="num"><?php echo showMycartTop('cart')?></span></a>
		</li>
		<li <?php if(uri_string()=='mypage/wish'){?>class="on"<?php }?>>
			<a href="/mypage/wish" hrefOri='L215cGFnZS93aXNo' ><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9fbW9kdWxlcy9jb21tb24vbXljYXJ0X3RvcC5odG1s" >위시리스트</span> <span class="num"><?php echo showMycartTop('wish')?></span></a>
		</li>
		<li <?php if(uri_string()=='goods/recently'){?>class="on"<?php }?>>
			<a href="/goods/recently" hrefOri='L2dvb2RzL3JlY2VudGx5' ><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9fbW9kdWxlcy9jb21tb24vbXljYXJ0X3RvcC5odG1s" >최근 본 상품</span> <span class="num"><?php echo showMycartTop('recently')?></span></a>
		</li>
	</ul>
</div>