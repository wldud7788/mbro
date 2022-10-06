<?php /* Template_ 2.2.6 2021/12/15 17:48:34 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/goods/location.html 000001604 */  $this->include_("showGoodsSearchFormLight");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "지역" 리스트 페이지 @@
- 파일위치 : [스킨폴더]/goods/location.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="location_page">
	<div class="search_nav"></div>

	<!--[ 상단 꾸미기 HTML ]-->
<?php if($TPL_VAR["locationData"]["top_html"]){?>
	<div class="category_edit_area mobile_img_adjust">
	<?php echo $TPL_VAR["locationData"]["top_html"]?>

	</div>
<?php }?>

	<!-- ------- 검색필터, 추천상품, 상품정렬( 파일위치 : [스킨폴더]/goods/_search_form_light.html ) ------- -->
	<?php echo showGoodsSearchFormLight()?>

	<!-- ------- //검색필터, 추천상품, 상품정렬 ------- -->

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