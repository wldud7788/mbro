<?php /* Template_ 2.2.6 2021/01/08 12:01:42 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/goods/catalog.html 000007724 */  $this->include_("showGoodsSearchFormLight","setTemplatePath","showDesignDisplay");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "카테고리" 리스트 페이지 @@
- 파일위치 : [스킨폴더]/goods/catalog.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="itemstmplayer" class="hide"></div>

<div id="catalog_page">
	<div class="search_nav"></div>

	<!--[ 상단 꾸미기 HTML ]-->
<?php if($TPL_VAR["categoryData"]["top_html"]){?>
	<div class="category_edit_area mobile_img_adjust">
	<?php echo $TPL_VAR["categoryData"]["top_html"]?>

	</div>
<?php }?>

	<!-- ------- 검색필터, 추천상품, 상품정렬( 파일위치 : [스킨폴더]/goods/_search_form_light.html ) ------- -->
	<?php echo showGoodsSearchFormLight()?>

	<!-- ------- //검색필터, 추천상품, 상품정렬 ------- -->

	<!-- ------- 상품 영역( data-displaytype : "lattice", "list" ), 파일위치 : [스킨폴더]/goods/search_list_template.html ------- -->
    
    <style type="text/css">
    	.music_mdpick, .goods_mdpick, .fashion_mdpick, .beauty_mdpick, .food_mdpick, .sports_mdpick, .style_mdpick{display: none; }
        .mdpick_box{display:none;}
    </style>

    <script type="text/javascript">
    	$(function() {
              $(".mdpick_box").hide();
            
    		if (window.location=="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c0008&per=40&sorting=ranking&filter_display=lattice" || window.location=="http://music-brother.firstmall.kr/goods/catalog?page=1&searchMode=catalog&category=c0008&per=40&sorting=ranking&filter_display=lattice") {
				$(".goods_mdpick").hide();
				$(".fashion_mdpick").hide();
				$(".beauty_mdpick").hide();
				$(".food_mdpick").hide();
				$(".sports_mdpick").hide();
				$(".style_mdpick").hide();
                $(".mdpick_box").show();
				$(".music_mdpick").show();
			}

			if (window.location=="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c0013&per=40&sorting=ranking&filter_display=lattice" || window.location=="http://music-brother.firstmall.kr/goods/catalog?page=1&searchMode=catalog&category=c0013&per=40&sorting=ranking&filter_display=lattice") {
				$(".music_mdpick").hide();
				$(".fashion_mdpick").hide();
				$(".beauty_mdpick").hide();
				$(".food_mdpick").hide();
				$(".sports_mdpick").hide();
				$(".style_mdpick").hide();
                $(".mdpick_box").show();
				$(".goods_mdpick").show();
			}

			if (window.location=="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c0010&per=40&sorting=ranking&filter_display=lattice" || window.location=="http://music-brother.firstmall.kr/goods/catalog?page=1&searchMode=catalog&category=c0010&per=40&sorting=ranking&filter_display=lattice") {
				$(".music_mdpick").hide();
				$(".goods_mdpick").hide();
				$(".beauty_mdpick").hide();
				$(".food_mdpick").hide();
				$(".sports_mdpick").hide();
				$(".style_mdpick").hide();
                $(".mdpick_box").show();
				$(".fashion_mdpick").show();
			}

			if (window.location=="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c0009&per=40&sorting=ranking&filter_display=lattice" || window.location=="http://music-brother.firstmall.kr/goods/catalog?page=1&searchMode=catalog&category=c0009&per=40&sorting=ranking&filter_display=lattice") {
				$(".music_mdpick").hide();
				$(".goods_mdpick").hide();
				$(".fashion_mdpick").hide();
				$(".food_mdpick").hide();
				$(".sports_mdpick").hide();
				$(".style_mdpick").hide();
                $(".mdpick_box").show();
				$(".beauty_mdpick").show();
			}
			if (window.location=="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c0012&per=40&sorting=ranking&filter_display=lattice" || window.location=="http://music-brother.firstmall.kr/goods/catalog?page=1&searchMode=catalog&category=c0012&per=40&sorting=ranking&filter_display=lattice") {
				$(".music_mdpick").hide();
				$(".goods_mdpick").hide();
				$(".fashion_mdpick").hide();
				$(".beauty_mdpick").hide();
				$(".sports_mdpick").hide();
				$(".style_mdpick").hide();
                $(".mdpick_box").show();
				$(".food_mdpick").show();
			}
			if (window.location=="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c0019&per=40&sorting=ranking&filter_display=lattice" || window.location=="http://music-brother.firstmall.kr/goods/catalog?page=1&searchMode=catalog&category=c0019&per=40&sorting=ranking&filter_display=lattice") {
				$(".music_mdpick").hide();
				$(".goods_mdpick").hide();
				$(".fashion_mdpick").hide();
				$(".beauty_mdpick").hide();
				$(".food_mdpick").hide();
				$(".style_mdpick").hide();
                $(".mdpick_box").show();
				$(".sports_mdpick").show();
			}
			if (window.location=="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c0017&per=40&sorting=ranking&filter_display=lattice" || window.location=="http://music-brother.firstmall.kr/goods/catalog?page=1&searchMode=catalog&category=c0017&per=40&sorting=ranking&filter_display=lattice") {
				$(".music_mdpick").hide();
				$(".goods_mdpick").hide();
				$(".fashion_mdpick").hide();
				$(".beauty_mdpick").hide();
				$(".food_mdpick").hide();
				$(".sports_mdpick").hide();
                $(".mdpick_box").show();
				$(".style_mdpick").show();
			}

    	});

    </script>

    	<!-- 상품디스플레이 -->
    <div class="mdpick_box">
        <div class="title_group1">
            <h3 class="title1"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL2NhdGFsb2cuaHRtbA==" ><strong>MD’</strong>s Pick</span></h3>
        </div>
        <div class="music_mdpick">
            <?php echo setTemplatePath('goods/catalog.html')?><?php echo showDesignDisplay( 10319)?>

        </div>
        <div class="goods_mdpick">
            <?php echo setTemplatePath('goods/catalog.html')?><?php echo showDesignDisplay( 10320)?>

        </div>
        <div class="fashion_mdpick">
            <?php echo setTemplatePath('goods/catalog.html')?><?php echo showDesignDisplay( 10321)?>

        </div>
        <div class="beauty_mdpick">
            <?php echo setTemplatePath('goods/catalog.html')?><?php echo showDesignDisplay( 10322)?>

        </div>
        <div class="food_mdpick">
            <?php echo setTemplatePath('goods/catalog.html')?><?php echo showDesignDisplay( 10323)?>

        </div>
        <div class="sports_mdpick">
            <?php echo setTemplatePath('goods/catalog.html')?><?php echo showDesignDisplay( 10324)?>

        </div>
        <div class="style_mdpick">
            <?php echo setTemplatePath('goods/catalog.html')?><?php echo showDesignDisplay( 10325)?>

        </div>
        <div class="title_group1">
		<h3 class="title1"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL2NhdGFsb2cuaHRtbA==" ><strong>ALL</strong></span></h3>
	</div>
    </div>

	<!-- //상품디스플레이 -->
    
    
	<div id="searchedItemDisplay" class="searched_item_display" data-displaytype="lattice">
		
	</div>
    

    
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