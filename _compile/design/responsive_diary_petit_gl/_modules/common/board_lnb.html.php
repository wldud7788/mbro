<?php /* Template_ 2.2.6 2021/06/25 16:59:30 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/_modules/common/board_lnb.html 000003867 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 고객센터( CS CENTER ) LNB @@
- 파일위치 : [스킨폴더]/_modules/common/board_lnb.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<style type="text/css">
	#boardLnbCommon .lnb_sub>li{padding:10px; border: 1px solid #ddd; border-bottom: 0;}
	#boardLnbCommon .lnb_sub>li:last-child{border-bottom: 1px solid #ddd;}
</style>


<div id="boardLnbCommon">
	<h2 class="title1"><a href="/service/cs" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9fbW9kdWxlcy9jb21tb24vYm9hcmRfbG5iLmh0bWw=" hrefOri='L3NlcnZpY2UvY3M=' >COMMUNITY</a></h3>
	<ul class="lnb_sub">
		<li <?php if(preg_match("/id=notice/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=notice" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9fbW9kdWxlcy9jb21tb24vYm9hcmRfbG5iLmh0bWw=" hrefOri='L2JvYXJkLz9pZD1ub3RpY2U=' >공지사항</a></li>
		<li <?php if(preg_match("/id=freeboard/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=freeboard" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9fbW9kdWxlcy9jb21tb24vYm9hcmRfbG5iLmh0bWw=" hrefOri='L2JvYXJkLz9pZD1mcmVlYm9hcmQ=' >자유게시판</a></li>
		
        
        <li <?php if(preg_match("/id=event/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=event" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9fbW9kdWxlcy9jb21tb24vYm9hcmRfbG5iLmh0bWw=" hrefOri='L2JvYXJkLz9pZD1ldmVudA==' >이벤트</a></li>
		<li <?php if(preg_match("/id=faq/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=faq" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9fbW9kdWxlcy9jb21tb24vYm9hcmRfbG5iLmh0bWw=" hrefOri='L2JvYXJkLz9pZD1mYXE=' >자주 묻는 질문</a></li>
		<!--<li <?php if(preg_match("/id=goods_qna/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=goods_qna" designElement="text" hrefOri='L2JvYXJkLz9pZD1nb29kc19xbmE=' >상품문의</a></li>
		<li <?php if(preg_match("/id=goods_review/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=goods_review" designElement="text" hrefOri='L2JvYXJkLz9pZD1nb29kc19yZXZpZXc=' >상품후기</a></li>-->

<!-- 		<?php if($TPL_VAR["isplusfreenot"]){?>
		<li <?php if(preg_match("/id=bulkorder/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=bulkorder" designElement="text" hrefOri='L2JvYXJkLz9pZD1idWxrb3JkZXI=' >대량구매</a></li>
<?php }?> -->
		<li <?php if(preg_match("/id=partner_board/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=partner_board" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9fbW9kdWxlcy9jb21tb24vYm9hcmRfbG5iLmh0bWw=" hrefOri='L2JvYXJkLz9pZD1wYXJ0bmVyX2JvYXJk' >입점문의</a></li>
        <li <?php if(preg_match("/mypage/myqna_catalog",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/mypage/myqna_catalog" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9fbW9kdWxlcy9jb21tb24vYm9hcmRfbG5iLmh0bWw="  target="_self" hrefOri='L215cGFnZS9teXFuYV9jYXRhbG9n' >1:1문의</a></li>
		<!-- <li><a href="/coin/coin_notice" designElement="text" target="_blank" hrefOri='L2NvaW4vY29pbl9ub3RpY2U=' >BMP코인 → 캐시</a></li> -->
	</ul>
</div>
<script>
$(function() {
	// 고객센터 LNB 텍스트 수정기능으로 삭제시, 클라이언트단에서 삭제 처리
	$('#boardLnbCommon a').each(function(e) {
		if ( $(this).text() == '' ) {
			$(this).parent('li, h2').remove();
		}
	});
});
</script>