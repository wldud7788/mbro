<?php /* Template_ 2.2.6 2020/10/15 17:39:14 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/goods/zoom.html 000002475 */ 
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
			<a href="#" hrefOri='Iw==' ><img src="<?php echo $TPL_V1["large"]["image"]?>" width="<?php echo $TPL_VAR["goodsImageSize"]["large"]["width"]?>" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage_wide.gif'" designImgSrcOri='ey5sYXJnZS5pbWFnZX0=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9nb29kcy96b29tLmh0bWw=' designImgSrc='ey5sYXJnZS5pbWFnZX0=' designElement='image' /></a>
<?php }}?>
		</div>
		<div class="pagination_wrap">
			<div class="count">
				<a href="javascript:void(0)" class="prev" title="이전" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
				<div class="pagination_area">
					<ul class="pagination">
<?php if($TPL_images_1){foreach($TPL_VAR["images"] as $TPL_V1){?>
						<li><a href="#" hrefOri='Iw==' ><img src="<?php echo $TPL_V1["thumbView"]["image"]?>" width="<?php echo $TPL_VAR["goodsImageSize"]["thumbView"]["width"]?>" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage_list.gif'" designImgSrcOri='ey50aHVtYlZpZXcuaW1hZ2V9' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9nb29kcy96b29tLmh0bWw=' designImgSrc='ey50aHVtYlZpZXcuaW1hZ2V9' designElement='image' /></a></li>
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
			preloadImage: "/data/skin/responsive_diary_petit_gl/images/design/loading.gif",
			effect: "fade",
			crossfade: true,
			autoHeight: true,
			generatePagination: false
		});
	},100);
});
</script>