<?php /* Template_ 2.2.6 2022/06/30 13:34:41 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/promotion/event_view.html 000005899 */  $this->include_("showGoodsSearchFormLight","setTemplatePath","showDesignDisplay");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "할인 이벤트" 리스트 페이지 @@
- 파일위치 : [스킨폴더]/promotion/event_view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="event_view_page">
	<div class="search_nav">
		<a class="home" href="/main/index" hrefOri='L21haW4vaW5kZXg=' >홈</a>
		<a class="navi_linemap" href="/promotion/event" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3Byb21vdGlvbi9ldmVudF92aWV3Lmh0bWw=" hrefOri='L3Byb21vdGlvbi9ldmVudA==' >이벤트</a>
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

<div class="special_promotion" style="display:none;">
	<style type="text/css">
		.show_display_col4 .display_slide_class .swiper-slide{width: 20%;}
		.show_display_col4 .display_responsible_class .goods_list li.gl_item{width: 20%;}
		.p_t_70{padding-top: 70px !important;}
	</style>
	<div class="search_nav">
			<a class="home" href="/main/index" hrefori="L21haW4vaW5kZXg=" hrefOri='L21haW4vaW5kZXg=' >홈</a>
			<a class="navi_linemap designElement" href="/promotion/event" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3Byb21vdGlvbi9ldmVudF92aWV3Lmh0bWw="  textindex="1" texttemplatepath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3Byb21vdGlvbi9ldmVudF92aWV3Lmh0bWw=" hrefori="L3Byb21vdGlvbi9ldmVudA==" hrefOri='L3Byb21vdGlvbi9ldmVudA==' >이벤트</a>
			<span class="navi_linemap on">LUXURY WEEK</span>
		</div>
	<div style="margin-top: 20px;">
		<img src="https://www.musicbroshop.com//data/skin/responsive_sports_sporti_gl/images/special_promotion.png" alt="" designImgSrcOri='aHR0cHM6Ly93d3cubXVzaWNicm9zaG9wLmNvbS8vZGF0YS9za2luL3Jlc3BvbnNpdmVfc3BvcnRzX3Nwb3J0aV9nbC9pbWFnZXMvc3BlY2lhbF9wcm9tb3Rpb24ucG5n' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3Byb21vdGlvbi9ldmVudF92aWV3Lmh0bWw=' designImgSrc='aHR0cHM6Ly93d3cubXVzaWNicm9zaG9wLmNvbS8vZGF0YS9za2luL3Jlc3BvbnNpdmVfc3BvcnRzX3Nwb3J0aV9nbC9pbWFnZXMvc3BlY2lhbF9wcm9tb3Rpb24ucG5n' designElement='image' >
	</div>
	<div class="resp_wrap">
	  <div class="title_group1 p_t_70" style="text-align:left;">
	    <h3 class="title1"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3Byb21vdGlvbi9ldmVudF92aWV3Lmh0bWw=" >CLOTHES</span></h3>
	  </div>
	  <div class="show_display_col4" data-effect="scale">
	    <?php echo setTemplatePath('promotion/event_view.html')?><?php echo showDesignDisplay( 10375)?>

	  </div>
	</div>
	<div class="resp_wrap">
	  <div class="title_group1 p_t_70" style="text-align:left;">
	    <h3 class="title1"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3Byb21vdGlvbi9ldmVudF92aWV3Lmh0bWw=" >SHOES</span></h3>
	  </div>
	  <div class="show_display_col4" data-effect="scale">
	    <?php echo setTemplatePath('promotion/event_view.html')?><?php echo showDesignDisplay( 10376)?>

	  </div>
	</div>
	<div class="resp_wrap">
	  <div class="title_group1 p_t_70" style="text-align:left;">
	    <h3 class="title1"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3Byb21vdGlvbi9ldmVudF92aWV3Lmh0bWw=" >BAG</span></h3>
	  </div>
	  <div class="show_display_col4" data-effect="scale">
	    <?php echo setTemplatePath('promotion/event_view.html')?><?php echo showDesignDisplay( 10377)?>

	  </div>
	</div>
	<div class="resp_wrap">
	  <div class="title_group1 p_t_70" style="text-align:left;">
	    <h3 class="title1"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3Byb21vdGlvbi9ldmVudF92aWV3Lmh0bWw=" >SLG</span></h3>
	  </div>
	  <div class="show_display_col4" data-effect="scale">
	    <?php echo setTemplatePath('promotion/event_view.html')?><?php echo showDesignDisplay( 10378)?>

	  </div>
	</div>
	<div class="resp_wrap">
	  <div class="title_group1 p_t_70" style="text-align:left;">
	    <h3 class="title1"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3Byb21vdGlvbi9ldmVudF92aWV3Lmh0bWw=" >ACC</span></h3>
	  </div>
	  <div class="show_display_col4" data-effect="scale">
	    <?php echo setTemplatePath('promotion/event_view.html')?><?php echo showDesignDisplay( 10379)?>

	  </div>
	</div>
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

	if(window.location.href === "https://www.musicbroshop.com/promotion/event_view?event=40&page=1&searchMode=event_view&per=40&sorting=ranking&filter_display=lattice"){
		$("#event_view_page").hide();
		$(".special_promotion").show();
	}
});
</script>