<?php /* Template_ 2.2.6 2021/01/08 12:02:07 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/_modules/display/goods_display_sizeswipe.html 000004911 */ 
$TPL_displayTabsList_1=empty($TPL_VAR["displayTabsList"])||!is_array($TPL_VAR["displayTabsList"])?0:count($TPL_VAR["displayTabsList"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ [반응형] 디스플레이 템플릿 - 스와이프형 @@
- 파일위치 : [스킨폴더]/_modules/display/goods_display_sizeswipe.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<style>
	.<?php echo $TPL_VAR["display_key"]?> .goods_list ol.gli_contents { text-align:<?php echo $TPL_VAR["text_align"]?>;}
	.<?php echo $TPL_VAR["display_key"]?> .swiper-slide>li.gl_item { width:<?php echo $TPL_VAR["goodsImageSize"]["width"]?>px;  }
</style>

<?php if($TPL_VAR["isRecommend"]){?><h3 class="title_sub1 x2"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL19tb2R1bGVzL2Rpc3BsYXkvZ29vZHNfZGlzcGxheV9zaXplc3dpcGUuaHRtbA==" >추천상품</span></h3><?php }?>
<div id='<?php echo $TPL_VAR["display_key"]?>' class='<?php echo $TPL_VAR["displayClass"]?>' designElement='<?php echo $TPL_VAR["displayElement"]?>' templatePath='<?php echo $TPL_VAR["template_path"]?>' displaySeq='<?php echo $TPL_VAR["display_seq"]?>' perpage='<?php echo $TPL_VAR["perpage"]?>' category='<?php echo $TPL_VAR["category_code"]?>' displayStyle='<?php echo $TPL_VAR["style"]?>'>
<?php if($TPL_VAR["title"]){?><div class="res_db_title1"><?php echo $TPL_VAR["title"]?></div><?php }?>
<?php if($TPL_VAR["displayTitle"]){?><div class="res_db_title2"><?php echo $TPL_VAR["displayTitle"]?></div><?php }?>
<?php if($TPL_displayTabsList_1){foreach($TPL_VAR["displayTabsList"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_V1["contents_type"]=='text'){?>
          <table class="displaySwipeTabContentsContainer" tabIdx="<?php echo $TPL_K1?>" cellpadding="0" cellspacing="0">
			  <tr>
				   <td>
<?php if($TPL_VAR["mobileMode"]||$TPL_VAR["storemobileMode"]){?><?php echo $TPL_V1["tab_contents_mobile"]?><?php }else{?><?php echo $TPL_V1["tab_contents"]?><?php }?>
				   </td>
			  </tr>
          </table>
<?php }elseif($TPL_VAR["goodsList"]){?>
          <div class="<?php echo $TPL_VAR["display_key"]?> display_slide_class displaySwipeTabContentsContainer" tabIdx="<?php echo $TPL_K1?>">
			  <div class="goods_display_slide_wrap">
				  <div class="swiper-wrapper">
					<!-- ------- 상품정보. 파일위치 : /data/design/ ------- -->
<?php $this->print_("goods_list",$TPL_SCP,1);?>

					<!-- ------- //상품정보. ------- -->
				  </div>
				  <!-- scrollbar -->
				  <div class="display-scrollbar swiper-scrollbar<?php echo $TPL_VAR["display_key"]?>"></div>
			  </div>
			   <!-- left, right button -->
			  <div class="swiper-button-next"></div>
			  <div class="swiper-button-prev"></div>
          </div>
<?php }else{?>
     <div class="displaySwipeTabContentsContainer" tabIdx="<?php echo $TPL_K1?>">
          <div style="width:90%; margin:auto;"></div>
     </div>
<?php }?>
<?php }}?>

<script>
	var t = new Date();
	var uniquekey_dsp = '<?php echo $TPL_VAR["display_key"]?>'+t.getTime();
	var display_swiper = [];

	$(function(){
		/* 상품디스플레이 스와이프형 탭 스크립트 */
		$("#<?php echo $TPL_VAR["display_key"]?> .displaySwipeTabContainer").each(function(){
			var tabContainerObj = $(this);
			tabContainerObj.children('li').css('width',(100/tabContainerObj.children('li').length)+'%');
			tabContainerObj.children('li').bind('mouseover click',function(){
				tabContainerObj.children('li.current').removeClass('current');
				$(this).addClass('current');
				var tabIdx = tabContainerObj.children('li').index(this);
				tabContainerObj.closest('.designDisplay, .designCategoryRecommendDisplay').find('.displayTabContentsContainer').hide().eq(tabIdx).show();
			}).eq(0).trigger('mouseover');
		});


		$('.display_slide_class').each(function(){
			if(!$(this).hasClass('set_slide_clear')){
				display_swiper[uniquekey_dsp] = new Swiper($(this).find('.goods_display_slide_wrap'), {
					//scrollbar: $(this).find('.display-scrollbar'),
					slidesPerView: 'auto',
					grabCursor: true,
					nextButton: $(this).find('.swiper-button-next'),
					prevButton: $(this).find('.swiper-button-prev')
				});
				$(this).addClass('set_slide_clear').bind('mousedown touchstart touchmove',function(){
					$('.active_swipe_slide').removeClass('active_swipe_slide');
					$(this).addClass('active_swipe_slide');
				});
			}
		});
		/*
		 $(window).resize(function(){
			setTimeout(function(){
				if($('.swiper-scrollbar-drag').width() == 0) display_swiper[uniquekey_dsp].update(true);
			},1000);
		 });
		 set_goods_display_decoration(".goodsDisplayImageWrap");
		*/
	});
</script>
</div>