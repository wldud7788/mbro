<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/promotion/gift_view.html 000001939 */  $this->include_("showGoodsSearchFormLight");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "사은품 이벤트" 리스트 페이지 @@
- 파일위치 : [스킨폴더]/promotion/gift_view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="gift_view_page">
	<div class="search_nav">
		<a class="home" href="/main/index">홈</a>
		<a class="navi_linemap" href="/promotion/event" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3Byb21vdGlvbi9naWZ0X3ZpZXcuaHRtbA==" >이벤트</a>
		<span class="navi_linemap searched_text"><?php echo $TPL_VAR["gfitData"]["title"]?></span>
	</div>

	<!--[ 상단 배너 영역 ]-->
<?php if($TPL_VAR["gfitData"]["gift_contents"]){?>
	<div class="category_edit_area mobile_img_adjust">
	<?php echo $TPL_VAR["gfitData"]["gift_contents"]?>

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