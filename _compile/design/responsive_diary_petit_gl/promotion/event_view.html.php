<?php /* Template_ 2.2.6 2021/03/15 17:22:51 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/promotion/event_view.html 000004207 */  $this->include_("showGoodsSearchFormLight");?>
<img src="/data/skin/responsive_diary_petit_gl/images/event_page_top_img.png" alt="" title="" id="event_top_img_pc" class="pc_event_top_banner" designImgSrcOri='Li4vaW1hZ2VzL2V2ZW50X3BhZ2VfdG9wX2ltZy5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9wcm9tb3Rpb24vZXZlbnRfdmlldy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9ldmVudF9wYWdlX3RvcF9pbWcucG5n' designElement='image' >
<img src="/data/skin/responsive_diary_petit_gl/images/m_event_page_top_img.png" alt="" title="" id="event_top_img_mobile" class="mobile_event_top_banner" designImgSrcOri='Li4vaW1hZ2VzL21fZXZlbnRfcGFnZV90b3BfaW1nLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9wcm9tb3Rpb24vZXZlbnRfdmlldy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9tX2V2ZW50X3BhZ2VfdG9wX2ltZy5wbmc=' designElement='image' >

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
@@ "?????? ?????????" ????????? ????????? @@
- ???????????? : [????????????]/promotion/event_view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="event_view_page">
	<div class="search_nav">
		<a class="home" href="/main/index" hrefOri='L21haW4vaW5kZXg=' >???</a>
		<a class="navi_linemap" href="/promotion/event" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9wcm9tb3Rpb24vZXZlbnRfdmlldy5odG1s" hrefOri='L3Byb21vdGlvbi9ldmVudA==' >?????????</a>
		<span class="navi_linemap on"><?php echo $TPL_VAR["eventData"]["title"]?></span>
	</div>

	<!--[ ?????? ?????? ?????? ]-->
<?php if($TPL_VAR["eventData"]["event_page_banner"]){?>
	<div class="category_edit_area mobile_img_adjust">
	<?php echo $TPL_VAR["eventData"]["event_page_banner"]?>

	</div>
<?php }?>

	<!-- ------- ????????????, ????????????( ???????????? : [????????????]/goods/_search_form_light.html ) ------- -->
	<?php echo showGoodsSearchFormLight()?>

	<!-- ------- //????????????, ???????????? ------- -->

	<!-- ------- ?????? ??????( data-displaytype : "lattice", "list" ), ???????????? : [????????????]/goods/search_list_template.html ------- -->
	<div id="searchedItemDisplay" class="searched_item_display" data-displaytype="lattice"></div>
	<!-- ------- //?????? ?????? ------- -->
</div>

<div id="wish_alert">
	<div class="wa_on"></div>
	<div class="wa_off"></div>
	<div class="wa_msg"></div>
</div>

<script type="text/javascript">
$(function() {
	// ?????? ????????? -> ????????? ???????????? open
	$('#searchModule #searchVer2').show();

	// ?????? ?????? - 255, 255, 255 --> border
	colorFilter_white( '#searchFilterSelected .color_type' );
});
</script>