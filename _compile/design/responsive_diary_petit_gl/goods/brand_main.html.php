<?php /* Template_ 2.2.6 2020/12/14 13:02:49 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/goods/brand_main.html 000006842 */  $this->include_("assignBrandMenuData","setTemplatePath","showDesignBanner");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 브랜드 메인 @@
- 파일위치 : [스킨폴더]/goods/brand_main.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="search_nav">
	<a class="home" href="../main/index" hrefOri='Li4vbWFpbi9pbmRleA==' >홈</a>
	<span class="navi_linemap on" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9nb29kcy9icmFuZF9tYWluLmh0bWw=" >BRANDS</span>
</div>

<!-- 브랜드 데이터 로드 -->
<?php echo assignBrandMenuData()?>


<?php if($TPL_VAR["page_config"]["banner"]["banner_seq"]){?>
<!--메인배너 :: START -->
<div id="slideBanner_BrandMain" class="page_banner_area1 slider_before_loading">
<?php echo setTemplatePath('goods/brand_main.html')?><?php echo showDesignBanner($TPL_VAR["page_config"]["banner"]["banner_seq"],true)?>

</div>
<!--메인배너 :: END -->
<?php }?>
<?php if($TPL_VAR["page_config"]["search_filter"]&&count($TPL_VAR["page_config"]["search_filter"])> 0){?>
<form id="brandFm">
	<fieldset>
		<legend>Search Brand</legend>
<?php if(in_array('brand',$TPL_VAR["page_config"]["search_filter"])){?>
		<div class="resp_brand_search_form">
			<span class="search_title" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9nb29kcy9icmFuZF9tYWluLmh0bWw=" >Search Brand</span>
			<input type="text" name="keyword" class="search_input" value="" />&nbsp;
			<button type="submit" class="btn_resp size_c"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9nb29kcy9icmFuZF9tYWluLmh0bWw=" >검색</span></button>
		</div>
<?php }?>
<?php if(in_array('kor',$TPL_VAR["page_config"]["search_filter"])||in_array('eng',$TPL_VAR["page_config"]["search_filter"])){?>
		<div class="resp_brand_search_btns">
			<ul>
				<li><a href="javascript:void(0)" class="alphabet_btn all on" data-target="all" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9nb29kcy9icmFuZF9tYWluLmh0bWw=" >ALL</span></a></li>
<?php if(is_array($TPL_R1=($TPL_VAR["brandMenuData"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if((preg_match('/[a-z]/',$TPL_K1)&&in_array('eng',$TPL_VAR["page_config"]["search_filter"]))||(preg_match('/[ㄱ-ㅎ]/',$TPL_K1)&&in_array('kor',$TPL_VAR["page_config"]["search_filter"]))){?>
				<li <?php if(!$TPL_V1[ 0]){?>class="hide"<?php }?>><a href="javascript:void(0)" class="alphabet_btn" data-target="wrap<?php echo str_replace("/","",strtr(base64_encode(str_replace("/","",$TPL_K1)),"+=","-_"))?>" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ><?php echo strtoupper($TPL_K1)?></a></li>
<?php }?>
<?php }}?>
			</ul>
		</div>
<?php }?>
	</fieldset>
</form>
<?php }?>
<?php if(($TPL_VAR["brandMenuData"])){?>
<div class="resp_brand_main_list">
<?php if(is_array($TPL_R1=($TPL_VAR["brandMenuData"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
		<ul class="brandwrap brand<?php echo $TPL_V2["category_code"]?> wrap<?php echo str_replace("/","",strtr(base64_encode(str_replace("/","",$TPL_K1)),"+=","-_"))?>">
			<li>
				<a class="brand_list_block" <?php if($TPL_V2["brand_image"]){?><?php }?> href="/goods/brand?code=<?php echo $TPL_V2["category_code"]?>" hrefOri='L2dvb2RzL2JyYW5kP2NvZGU9ey4uY2F0ZWdvcnlfY29kZX0=' >
					<div>
						<img src="<?php echo $TPL_V2["brand_image"]?>" alt="<?php echo $TPL_V2["prn_title"]?>" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage.gif';" designImgSrcOri='ez0uLmJyYW5kX2ltYWdlfQ==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9nb29kcy9icmFuZF9tYWluLmh0bWw=' designImgSrc='ez0uLmJyYW5kX2ltYWdlfQ==' designElement='image' />
					</div>
					<span class="name">
						<?php echo $TPL_V2["prn_title"]?>

<?php if($TPL_V2["best"]=='Y'&&$TPL_VAR["brand_best_icon"]){?>
						<img class="icon" src="<?php echo $TPL_VAR["brand_best_icon"]?>" alt="best" onerror="this.src='/data/icon/goods/error/noimage_list.gif';" designImgSrcOri='e2JyYW5kX2Jlc3RfaWNvbn0=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9nb29kcy9icmFuZF9tYWluLmh0bWw=' designImgSrc='e2JyYW5kX2Jlc3RfaWNvbn0=' designElement='image' />
<?php }?>
					</span>
				</a>
			</li>
		</ul>
<?php }}?>
<?php }}?>
</div>
<?php }else{?>
<div class="no_data_area2">
	브랜드 정보가 없습니다.
</div>
<?php }?>

<div id="filterNoData" class="no_data_area2" style="display:none;">
	브랜드 정보가 없습니다.
</div>

<script type="text/javascript">
$(document).ready(function() {
	$(".alphabet_btn").click(function(){
		$(".alphabet_btn").removeClass("on");
		$(this).addClass("on");

		$target = $(this).attr("data-target");
		$(".brandwrap").removeClass("on").hide();
		$(".brandwrap."+$target).addClass("on").show();
		if($target === "all") {
			$(".brandwrap").removeClass("on").show();
		}

		if ( $('.resp_brand_main_list>ul:visible').length == 0 ) $('#filterNoData').show();
		else $('#filterNoData').hide();
		$('.search_input').val('');
	});
	$("#brandFm").submit(function(){
		$.post("/goods_process/brand_search",$(this).serializeArray(), function(response){
			if (response.result == false) {
				$(".brandwrap").removeClass("on").show();
				//$(".brandtxt").removeClass("disable");
				//$(".brandtxt").removeClass("on");
			} else {
				$(".brandwrap").removeClass("on").hide();
				//$(".brandtxt").addClass("disable");
				//$(".brandtxt").removeClass("on");
				$(response).each(function(idx, data){
					//$(".brandwrap.brand"+data.category_code).show();
					$(".brandwrap.brand"+data.category_code).addClass("on").show();
				});
			}

			if ( $('.resp_brand_main_list>ul:visible').length == 0 ) $('#filterNoData').show();
			else $('#filterNoData').hide();
			$('.alphabet_btn').removeClass('on');
			$('.alphabet_btn.all').addClass('on');
		}, "json");
		return false;
	});

	$(".brand_classification").click(function(){
		$("#brandFm").submit();
	});

	// "브랜드 메인" 상단 슬라이드배너 옵션 설정
	$('#slideBanner_BrandMain .custom_slider>div').slick('unslick');
	$('#slideBanner_BrandMain .custom_slider>div').slick({
		dots: true, // 도트 페이징 사용( true 혹은 false )
		autoplay: true, // 슬라이드 자동( true 혹은 false )
		speed: 1000, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 600 == 0.6초 )
		fade: true, // 페이드 모션 사용( 이 부분은 수정하지 마세요 )
		autoplaySpeed: 5000 // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 5000 == 5초 )
	});
});
</script>