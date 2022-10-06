<?php /* Template_ 2.2.6 2022/03/18 15:13:17 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/goods/zoom.html 000002499 */ 
$TPL_images_1=empty($TPL_VAR["images"])||!is_array($TPL_VAR["images"])?0:count($TPL_VAR["images"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 상품 이미지 확대보기 @@
- 파일위치 : [스킨폴더]/goods/zoom.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<style type="text/css">
.zoom_page { width:<?php echo $TPL_VAR["goodsImageSize"]["large"]["width"]?>px; }
</style>

<div id="goods_view" class="zoom_page">
	<div id="goods_thumbs">
		<div class="slides_container">
<?php if($TPL_images_1){foreach($TPL_VAR["images"] as $TPL_V1){?>
			<a href="#" hrefOri='Iw==' ><img src="<?php echo $TPL_V1["large"]["image"]?>" width="<?php echo $TPL_VAR["goodsImageSize"]["large"]["width"]?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl_1/images/common/noimage_wide.gif'" designImgSrcOri='ey5sYXJnZS5pbWFnZX0=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvem9vbS5odG1s' designImgSrc='ey5sYXJnZS5pbWFnZX0=' designElement='image' /></a>
<?php }}?>
		</div>
		<div class="pagination_wrap">
			<div class="count">
				<a href="javascript:void(0)" class="prev" title="이전" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
				<div class="pagination_area">
					<ul class="pagination">
<?php if($TPL_images_1){foreach($TPL_VAR["images"] as $TPL_V1){?>
						<li><a href="#" hrefOri='Iw==' ><img src="<?php echo $TPL_V1["thumbView"]["image"]?>" width="<?php echo $TPL_VAR["goodsImageSize"]["thumbView"]["width"]?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl_1/images/common/noimage_list.gif'" designImgSrcOri='ey50aHVtYlZpZXcuaW1hZ2V9' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvem9vbS5odG1s' designImgSrc='ey50aHVtYlZpZXcuaW1hZ2V9' designElement='image' /></a></li>
<?php }}?>
					</ul>
				</div>
				<a href="javascript:void(0)" class="next" title="다음" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(function(){
	$("#goods_thumbs .slides_container a:gt(0)").hide();
	setTimeout(function(){
		$("#goods_thumbs").slides({
			preload: true,
			preloadImage: "/data/skin/responsive_sports_sporti_gl_1/images/design/loading.gif",
			effect: "fade",
			crossfade: true,
			autoHeight: true,
			generatePagination: false
		});
	},100);
});
</script>