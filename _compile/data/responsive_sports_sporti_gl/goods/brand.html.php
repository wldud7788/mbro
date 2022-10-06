<?php /* Template_ 2.2.6 2022/09/20 16:40:56 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/goods/brand.html 000002890 */  $this->include_("showGoodsSearchFormLight");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "브랜드" 리스트 페이지 @@
- 파일위치 : [스킨폴더]/goods/brand.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<style type="text/css">

	.subpage_sidemenu{display: inline-block; width: 15%; vertical-align: top; padding: 30px 30px 30px 0; box-sizing: border-box;}
	/*#layout_body{max-width: 1260px; padding-left: 20px;}*/
	.layout_body2{max-width: 100% !important;}
	/*.layout_body{max-width: 1260px !important; padding-left: 20px;}*/
	#brand_page{    display: block; margin: 0 auto; max-width: 1260px;}
	.subpage_sidemenu ul li{line-height: 35px; border-bottom: 1px solid #ddd;}
	.subpage_sidemenu ul li a{/*display: block; width: 100%;*/font-weight: 600;}
	.subpage_sidemenu ul li a:hover{opacity: 0.5;}
	/* .searched_item_display>ul>li{width: 16.6%;} */
	.more_btn1, .more_btn2, .more_btn3, .more_btn4 {position: absolute; right: 0; font-weight: bold; font-size: 18px; cursor: pointer; display: none; width: 50px; text-align: center;}
	.show_active{display: inline-block;}
	.more_btn1:hover, .more_btn2:hover, .more_btn3:hover, .more_btn4:hover {opacity: 0.6;}
	.subpage_subbox {display: none;}
	.subpage_subbox a{font-weight: 500 !important;}
	.fontweight_active{font-weight: bold !important;}

	@media screen and (max-width: 960px) {
		.searched_item_display>ul>li{width: 33%;}
	}

	@media screen and (max-width: 768px) { 
		.subpage_sidemenu{display: none;}
		#catalog_page{width: 100%;}
		.searched_item_display>ul>li{width: 50%;}
	}
</style>

<div id="brand_page">
	<div class="search_nav"></div>

	<!--[ 상단 꾸미기 HTML ]-->
<?php if($TPL_VAR["brandData"]["top_html"]){?>
	<div class="category_edit_area mobile_img_adjust">
	<?php echo $TPL_VAR["brandData"]["top_html"]?>

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