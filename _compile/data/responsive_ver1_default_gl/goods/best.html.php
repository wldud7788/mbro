<?php /* Template_ 2.2.6 2021/12/15 17:48:34 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/goods/best.html 000002429 */  $this->include_("showDesignBanner","showGoodsSearchFormLight");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "베스트" 리스트 페이지 @@
- 파일위치 : [스킨폴더]/goods/best.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="best_page">
	<div class="search_nav">
		<a class="home" href="../main/index">홈</a>
		<span class="navi_linemap on" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvZ29vZHMvYmVzdC5odG1s" >TOP <?php echo $TPL_VAR["page_config"]["rank"]?></span>
	</div>

	<!-- "베스트" 상단 배너 -->
<?php if($TPL_VAR["page_config"]["banner"]["banner_seq"]){?>
	<div id="slideBanner_Best" class="page_banner_area1 slider_before_loading">
	<?php echo showDesignBanner($TPL_VAR["page_config"]["banner"]["banner_seq"],true)?>

	</div>
<?php }?>

	<!-- ------- 검색필터, 상품정렬( 파일위치 : [스킨폴더]/goods/_search_form_light.html ) ------- -->
	<?php echo showGoodsSearchFormLight()?>

	<!-- ------- //검색필터, 상품정렬 ------- -->

	<!-- ------- 상품 영역( data-displaytype : "lattice", "list" ), 파일위치 : [스킨폴더]/goods/search_list_template.html ------- -->
	<div id="searchedItemDisplay" class="searched_item_display best_page_ranking" data-displaytype="lattice"></div>
	<!-- ------- //상품 영역 ------- -->
</div>

<div id="wish_alert">
	<div class="wa_on"></div>
	<div class="wa_off"></div>
	<div class="wa_msg"></div>
</div>

<script type="text/javascript">
$(function() {

	// 컬러 필터 - 255, 255, 255 --> border
	colorFilter_white( '#searchFilterSelected .color_type' );

	// "베스트 페이지" 상단 슬라이드배너 옵션 설정
	$('#slideBanner_Best .custom_slider>div').slick('unslick');
	$('#slideBanner_Best .custom_slider>div').slick({
		dots: true, // 도트 페이징 사용( true 혹은 false )
		autoplay: true, // 슬라이드 자동( true 혹은 false )
		speed: 1000, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 600 == 0.6초 )
		fade: true, // 페이드 모션 사용( 이 부분은 수정하지 마세요 )
		autoplaySpeed: 5000 // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 5000 == 5초 )
	});

});
</script>