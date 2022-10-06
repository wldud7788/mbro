<?php /* Template_ 2.2.6 2021/03/15 17:22:51 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/promotion/event_view.html 000003586 */  $this->include_("showGoodsSearchFormLight");?>
<img src="/data/skin/responsive_diary_petit_gl/images/event_page_top_img.png" alt="" title="" id="event_top_img_pc" class="pc_event_top_banner">
<img src="/data/skin/responsive_diary_petit_gl/images/m_event_page_top_img.png" alt="" title="" id="event_top_img_mobile" class="mobile_event_top_banner">

<script type="text/javascript">
	$(function() {
		setTimeout(function(){
			if (window.location=="http://music-brother.firstmall.kr/promotion/event_view?event=16&page=1&searchMode=event_view&per=40&sorting=ranking&filter_display=lattice" || window.location=="https://musicbroshop.com/promotion/event_view?event=16&page=1&searchMode=event_view&per=40&sorting=ranking&filter_display=lattice") {
				$("#event_top_img_pc").attr("src", '/data/skin/responsive_diary_petit_gl/images/pc_pinkage.jpg');
				$("#event_top_img_mobile").attr("src", '/data/skin/responsive_diary_petit_gl/images/m_pinkage.jpg');
			}
			if (window.location=="http://music-brother.firstmall.kr/promotion/event_view?event=17&page=1&searchMode=event_view&per=40&sorting=ranking&filter_display=lattice" || window.location=="https://musicbroshop.com/promotion/event_view?event=17&page=1&searchMode=event_view&per=40&sorting=ranking&filter_display=lattice") {
				$("#event_top_img_pc").attr("src", '/data/skin/responsive_diary_petit_gl/images/pc_drbrm.jpg');
				$("#event_top_img_mobile").attr("src", '/data/skin/responsive_diary_petit_gl/images/m_drbrm.jpg');
			}
		},100);
		
	});

</script>

<style type="text/css">
	.mobile_event_top_banner{display: none; width: 100%;}
	@media only screen and (max-width:967px) {
	      .mobile_event_top_banner{display: block;}
	      .pc_event_top_banner{display: none;}
	    }
</style>


<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "할인 이벤트" 리스트 페이지 @@
- 파일위치 : [스킨폴더]/promotion/event_view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="event_view_page">
	<div class="search_nav">
		<a class="home" href="/main/index">홈</a>
		<a class="navi_linemap" href="/promotion/event" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9wcm9tb3Rpb24vZXZlbnRfdmlldy5odG1s" >이벤트</a>
		<span class="navi_linemap on"><?php echo $TPL_VAR["eventData"]["title"]?></span>
	</div>

	<!--[ 상단 배너 영역 ]-->
<?php if($TPL_VAR["eventData"]["event_page_banner"]){?>
	<div class="category_edit_area mobile_img_adjust">
	<?php echo $TPL_VAR["eventData"]["event_page_banner"]?>

	</div>
<?php }?>

	<!-- ------- 검색필터, 상품정렬( 파일위치 : [스킨폴더]/goods/_search_form_light.html ) ------- -->
	<?php echo showGoodsSearchFormLight()?>

	<!-- ------- //검색필터, 상품정렬 ------- -->

	<!-- ------- 상품 영역( data-displaytype : "lattice", "list" ), 파일위치 : [스킨폴더]/goods/search_list_template.html ------- -->
	<div id="searchedItemDisplay" class="searched_item_display" data-displaytype="lattice"></div>
	<!-- ------- //상품 영역 ------- -->
</div>

<div id="wish_alert">
	<div class="wa_on"></div>
	<div class="wa_off"></div>
	<div class="wa_msg"></div>
</div>

<script type="text/javascript">
$(function() {
	// 검색 페이지 -> 디폴트 검색박스 open
	$('#searchModule #searchVer2').show();

	// 컬러 필터 - 255, 255, 255 --> border
	colorFilter_white( '#searchFilterSelected .color_type' );
});
</script>