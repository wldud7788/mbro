<?php /* Template_ 2.2.6 2021/12/15 16:50:22 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/goods/search.html 000001857 */  $this->include_("showGoodsSearchFormLight");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "검색결과" 리스트 페이지 @@
- 파일위치 : [스킨폴더]/goods/search.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="search_result_page">
	<div class="title_container">
<?php if($TPL_VAR["goodsSearchText"]){?>
		<h2 class="searched">'<span class="searched_text"><?php echo $TPL_VAR["goodsSearchText"]?></span>' <span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2dvb2RzL3NlYXJjaC5odG1s" >검색결과</span></h2>
<?php }else{?>
		<h2 class="searched"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2dvb2RzL3NlYXJjaC5odG1s" >검색</span></h2>
<?php }?>
	</div>

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
	$('.search_ver2').addClass('on');

	// 컬러 필터 - 255, 255, 255 --> border
	colorFilter_white( '#searchFilterSelected .color_type' );
});
</script>