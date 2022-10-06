<?php /* Template_ 2.2.6 2020/12/23 15:33:55 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/mypage/mypage_lnb.html 000005559 */ ?>
<div id="mypageLnbBasic">
		<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
		@@ 마이페이지 LNB 공통 @@
		- 파일위치 : [스킨폴더]/mypage/mypage_lnb.html
		++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
			<h2 class="title1"><a href="/mypage" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >MY SHOPPING</a></h2>
			<h3 class="title2"><a href="/mypage/order_catalog" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >나의 쇼핑</a></h3>
			<ul class="lnb_sub">
				<li><a href="/mypage/order_catalog" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >주문/배송</a></li>
				<li><a href="/mypage/return_catalog" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >반품/교환</a></li>
				<li><a href="/mypage/refund_catalog" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >취소/환불</a></li>
				<li><a href="/mypage/wish" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >위시리스트</a></li>
				<li><a href="/goods/recently" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >최근 본 상품</a></li>
				<li><a href="/mypage/delivery_address?tab=1" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >배송주소록</a></li>
				<li><a href="/mypage/taxinvoice" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >세금계산서</a></li>
				<li><a href="/mypage/personal" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >개인결제</a></li>
			</ul>
			<h3 class="title2"><a href="/mypage/emoney" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >나의 혜택</a></h3>
			<ul class="lnb_sub">
				<li><a href="/mypage/emoney" designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >마일리지</a></li>
				<li><a href="/mypage/coupon" designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >쿠폰</a></li>
<?php if($TPL_VAR["cash_use"]=='Y'){?><li><a href="/mypage/cash" designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >예치금</a></li><?php }?>
<?php if($TPL_VAR["point_use"]=='Y'){?><li><a href="/mypage/point" designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >포인트</a></li><?php }?>
<?php if(serviceLimit('H_NFR')){?>
<?php if($TPL_VAR["emoney_exchange_use"]=='y'){?>
					<li><a href="/mypage/point_exchange" designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >혜택 교환</a></li>
<?php }else{?>
					<li><a href="/mypage/promotion" designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >혜택 교환</a></li>
<?php }?>
<?php }?>
			</ul>
			<h3 class="title2"><a href="/mypage/myqna_catalog" designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >나의 활동</a></h3>
			<ul class="lnb_sub">
				<li><a href="/mypage/myqna_catalog" designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >나의 1:1문의</a></li>
				<li><a href="/mypage/mygdqna_catalog" designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >나의 상품문의</a></li>
				<li><a href="/mypage/mygdreview_catalog" designElement="text" textIndex="21"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >나의 상품후기</a></li>
<?php if(serviceLimit('H_AD')){?>
				<li><a href="/mypage/my_minishop" designElement="text" textIndex="22"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >나의 단골 미니샵</a></li>
<?php }?>
			</ul>
			<h3 class="title2"><a href="/mypage/myinfo" designElement="text" textIndex="23"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >나의 정보</a></h3>
			<ul class="lnb_sub">
				<li><a href="/mypage/myinfo" designElement="text" textIndex="24"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >회원정보 수정</a></li>
				<li><a href="/mypage/withdrawal" designElement="text" textIndex="25"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9teXBhZ2VfbG5iLmh0bWw=" >회원 탈퇴</a></li>
			</ul>
		</div>