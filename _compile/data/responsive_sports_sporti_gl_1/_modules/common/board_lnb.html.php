<?php /* Template_ 2.2.6 2022/03/18 15:13:29 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/_modules/common/board_lnb.html 000002375 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 고객센터( CS CENTER ) LNB @@
- 파일위치 : [스킨폴더]/_modules/common/board_lnb.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="boardLnbCommon">
	<h2 class="title1"><a href="/service/cs" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2JvYXJkX2xuYi5odG1s" >CS CENTER</a></h3>
	<ul class="lnb_sub">
		<li <?php if(preg_match("/id=notice/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=notice" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2JvYXJkX2xuYi5odG1s" >공지사항</a></li>
		<li <?php if(preg_match("/id=faq/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=faq" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2JvYXJkX2xuYi5odG1s" >자주 묻는 질문</a></li>
		<li <?php if(preg_match("/id=goods_qna/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=goods_qna" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2JvYXJkX2xuYi5odG1s" >상품문의</a></li>
		<li <?php if(preg_match("/id=goods_review/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=goods_review" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2JvYXJkX2xuYi5odG1s" >상품후기</a></li>
<?php if($TPL_VAR["isplusfreenot"]){?>
		<li <?php if(preg_match("/id=bulkorder/",$_SERVER["REQUEST_URI"])){?>class="on"<?php }?>><a href="/board/?id=bulkorder" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2JvYXJkX2xuYi5odG1s" >대량구매</a></li>
<?php }?>
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