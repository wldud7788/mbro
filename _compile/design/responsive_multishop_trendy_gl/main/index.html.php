<?php /* Template_ 2.2.6 2021/12/15 16:44:42 /www/music_brother_firstmall_kr/data/skin/responsive_multishop_trendy_gl/main/index.html 000012098 */  $this->include_("showDesignLightPopup","setTemplatePath","showDesignBanner","getBoarddata","showDesignDisplay");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ index @@
- 파일위치 : [스킨폴더]/main/index.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<?php echo showDesignLightPopup( 4)?>

<?php echo showDesignLightPopup( 3)?>

<?php echo showDesignLightPopup( 2)?>

<?php echo showDesignLightPopup( 1)?>

<!-- //띠배너/팝업 -->

<style type="text/css">
#layout_body { max-width:100%; padding-left:0; padding-right:0; }
</style>

<!-- 슬라이드 배너 영역 (light_style_1_10) :: START -->
<div class="sliderB wide_visual_slider">
	<?php echo setTemplatePath('main/index.html')?><?php echo showDesignBanner( 10)?>

</div>
<script type="text/javascript">
$(function() {
	$('.light_style_1_10').slick({
		dots: true, // 도트 페이징 사용( true 혹은 false )
		autoplay: true, // 슬라이드 자동( true 혹은 false )
		pauseOnHover: false, // Hover시 autoplay 정지안함( 정지: true, 정지안함: false )
		speed: 1000, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 600 == 0.6초 )
		fade: true, // 페이드 모션 사용
		autoplaySpeed: 8000 // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 8000 == 8초 )
	});
	// 이 외 slick 슬라이더의 자세한 옵션사항은 http://kenwheeler.github.io/slick/ 참고
});
</script>
<!-- 슬라이드 배너 영역 (light_style_1_10) :: END -->

<div class="resp_wrap">
	<!-- STORY -->
	<div class="title_group1">
		<h3 class="title1"><a href="/board/?id=custom_bbs2" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==" hrefOri='L2JvYXJkLz9pZD1jdXN0b21fYmJzMg==' >STORY</a></h3>
	</div>
	<div id="mainStoryList" class="board_gallery" designElement='displaylastest' templatePath='bWFpbi9pbmRleC5odG1s'>
		<ul>
<?php if(is_array($TPL_R1=getBoardData('custom_bbs2','4',null,null,'17','60','ID','HID','IMG',array('orderby=gid asc','','rdate_s=','rdate_f=','auto_term=','image_w=400','image_h=')))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<li class="board_gallery_li">
				<div class="item_img_area">
					<a href="<?php echo $TPL_V1["wigetboardurl_view"]?>" hrefOri='ey53aWdldGJvYXJkdXJsX3ZpZXd9' ><img src="<?php echo $TPL_V1["filelist"]?>" alt="" designImgSrcOri='ey5maWxlbGlzdH0=' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='ey5maWxlbGlzdH0=' designElement='image' /></a>
				</div>
				<ul class="item_info_area">
					<li class="goods_name_area">
						<a href="<?php echo $TPL_V1["wigetboardurl_view"]?>" hrefOri='ey53aWdldGJvYXJkdXJsX3ZpZXd9' ><span class="name"><?php echo $TPL_V1["subject"]?> <?php echo $TPL_V1["iconnew"]?> <?php echo $TPL_V1["iconhot"]?> <?php echo $TPL_V1["iconfile"]?> <?php echo $TPL_V1["iconhidden"]?></span></a>
					</li>
					<li class="goods_desc_area">
						<a href="<?php echo $TPL_V1["wigetboardurl_view"]?>" hrefOri='ey53aWdldGJvYXJkdXJsX3ZpZXd9' ><?php echo $TPL_V1["contents"]?></a>
					</li>
				</ul>
			</li>
<?php }}?>
		</ul>
	</div>    
</div>

<!-- 2 Banner -->
<ul class="main_bnr_type2">
	<li style="background-color:#62ace5;">
		<a href="#" hrefOri='Iw==' ><img src="/data/skin/responsive_multishop_trendy_gl/images/design_resp/bnr_main_c01.gif" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl9tYWluX2MwMS5naWY=' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX211bHRpc2hvcF90cmVuZHlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl9tYWluX2MwMS5naWY=' designElement='image' /></a>
	</li>
	<li style="background-color:#e0e0e0;">
		<a href="#" hrefOri='Iw==' ><img src="/data/skin/responsive_multishop_trendy_gl/images/design_resp/bnr_main_c02.gif" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl9tYWluX2MwMi5naWY=' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX211bHRpc2hvcF90cmVuZHlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl9tYWluX2MwMi5naWY=' designElement='image' /></a>
	</li>
</ul>

<div class="resp_wrap">
	<!-- NEW ARRIVALS -->
	<div class="title_group1">
		<h3 class="title1"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==" >NEW ARRIVALS</span></h3>
	</div>
	<div class="style7_custom1 show_display show_display_col5">
		<?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10111)?>

	</div>
</div>

<!-- EVENT -->
<div class="resp_wrap">
	<div class="title_group1">
		<h3 class="title1"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==" >EVENT</span></h3>
	</div>
</div>
	
<!-- 슬라이드 배너 영역 (light_style_1_3) :: START -->
<div class="main_slider_a2 sliderA center slider_before_loading">
	<?php echo setTemplatePath('main/index.html')?><?php echo showDesignBanner( 3)?>

</div>
<script type="text/javascript">
$(function() {
	$('.light_style_1_3').slick({
		dots: true, // 도트 페이징 사용( true 혹은 false )
		autoplay: true, // 슬라이드 자동( true 혹은 false )
		autoplaySpeed: 8000, // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 8000 == 8초 )
		speed: 800, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 800 == 0.8초 )
		centerMode: true, // 센터모드 사용( true 혹은 false )
		variableWidth: true, // 가변 넓이 사용( true 혹은 false )
		slidesToShow: 3,
		pauseOnHover: false, // Hover시 autoplay 정지안함( 정지: true, 정지안함: false )
		responsive: [
		{
			breakpoint: 1100, // 스크린 가로 사이즈가 1100px 이하일 때,
			settings: {
				arrows: false, // 좌우 버튼 페이징 사용 안함( 사용함: true, 사용안함: false )
				variableWidth: false,
				centerPadding: '80px', // 센터모드 사용시 좌우 여백
				slidesToShow: 1 // 한 화면에 몇개의 슬라이드를 보여줄 것인가? - 2개
			}
		},
		{
			breakpoint: 640, // 스크린 가로 사이즈가 640px 이하일 때,
			settings: {
				arrows: false, // 좌우 버튼 페이징 사용 안함( 사용함: true, 사용안함: false )
				variableWidth: false,
				centerPadding: '20px', // 센터모드 사용시 좌우 여백
				slidesToShow: 1 // 한 화면에 몇개의 슬라이드를 보여줄 것인가? - 1개
			}
		}]
	});
});
</script>
<!-- 슬라이드 배너 영역 (light_style_1_3) :: END -->

<div class="resp_wrap">
	<!-- BEST OF BEST -->
	<div class="title_group1">
		<h3 class="title1"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==" >BEST OF BEST</span></h3>
	</div>
	<div class="style4_custom1 show_display show_display_col3" data-effect="scale">
		<?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10112)?>

	</div>
</div>

<div class="wide_banner_custom">
	<img src="/data/skin/responsive_multishop_trendy_gl/images/design_resp/bnr_main_201.jpg" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl9tYWluXzIwMS5qcGc=' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX211bHRpc2hvcF90cmVuZHlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl9tYWluXzIwMS5qcGc=' designElement='image' />
</div>

<div class="resp_wrap">
	<!-- MD'S PICK -->
	<div class="title_group1">
		<h3 class="title1"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==" >MD'S PICK</span></h3>
	</div>
	<div class="style7_custom1 display_tab_custom show_display show_display_col4" data-effect="rotate_01">
		<?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10113)?>

	</div>
</div>

<!-- SPACE -->
<div class="main_space">
	<div class="resp_wrap">
		<div class="title_group1">
			<h3 class="title1"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==" >SPACE</span></h3>
		</div>
		<div class="respBnrGon respBnrGon_num5_typeX1">
			<ul>
				<li><a href="#" hrefOri='Iw==' ><img src="/data/skin/responsive_multishop_trendy_gl/images/design_resp/bnr_306_01.jpg" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl8zMDZfMDEuanBn' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX211bHRpc2hvcF90cmVuZHlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl8zMDZfMDEuanBn' designElement='image' /></a></li>
				<li><a href="#" hrefOri='Iw==' ><img src="/data/skin/responsive_multishop_trendy_gl/images/design_resp/bnr_306_02.jpg" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl8zMDZfMDIuanBn' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX211bHRpc2hvcF90cmVuZHlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl8zMDZfMDIuanBn' designElement='image' /></a></li>
				<li>
					<!-- 슬라이드 배너 영역 (light_style_1_5) :: START -->
					<div class="sliderA slider_before_loading">
						<?php echo setTemplatePath('main/index.html')?><?php echo showDesignBanner( 5)?>

					</div>
					<script type="text/javascript">
					$(function() {
						$('.light_style_1_5').slick({
							dots: true, // 도트 페이징 사용( true 혹은 false )
							autoplay: true, // 슬라이드 자동( true 혹은 false )
							speed: 800, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 800 == 0.8초 )
							autoplaySpeed: 4000 // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 4000 == 4초 )
						});
						// 이 외 slick 슬라이더의 자세한 옵션사항은 http://kenwheeler.github.io/slick/ 참고
					});
					</script>
					<!-- 슬라이드 배너 영역 (light_style_1_5) :: END -->
				</li>
				<li><a href="#" hrefOri='Iw==' ><img src="/data/skin/responsive_multishop_trendy_gl/images/design_resp/bnr_306_03.jpg" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl8zMDZfMDMuanBn' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX211bHRpc2hvcF90cmVuZHlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl8zMDZfMDMuanBn' designElement='image' /></a></li>
				<li><a href="#" hrefOri='Iw==' ><img src="/data/skin/responsive_multishop_trendy_gl/images/design_resp/bnr_306_04.jpg" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl8zMDZfMDQuanBn' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX211bHRpc2hvcF90cmVuZHlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl8zMDZfMDQuanBn' designElement='image' /></a></li>
			</ul>
		</div>
	</div>
</div>

<div class="resp_wrap">
<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'&&$TPL_VAR["sns"]["ntalk_use"]=='Y'&&$TPL_VAR["sns"]["ntalk_use_mobile_main"]=='Y'){?>
	<!-- 네이버 톡톡 -->
	<div class="btn_talk_area">
		<button type="button" class="btn_talk v2" onclick="location.href='https://talk.naver.com/<?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?>#nafullscreen';"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==" >쇼핑할땐</span> &nbsp;<img src="/data/skin/responsive_multishop_trendy_gl/images/icon/icon_talk.png" class="talk_img" alt="네이버톡톡" designImgSrcOri='Li4vaW1hZ2VzL2ljb24vaWNvbl90YWxrLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX211bHRpc2hvcF90cmVuZHlfZ2wvaW1hZ2VzL2ljb24vaWNvbl90YWxrLnBuZw==' designElement='image' />&nbsp; <span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL21haW4vaW5kZXguaHRtbA==" >톡톡하세요</span></button>
	</div>
<?php }?>
</div>