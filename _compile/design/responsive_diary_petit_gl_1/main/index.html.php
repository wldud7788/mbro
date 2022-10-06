<?php /* Template_ 2.2.6 2021/12/28 10:31:32 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/main/index.html 000018324 */  $this->include_("showDesignLightPopup","setTemplatePath","showDesignBanner","showDesignDisplay");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ index @@
- 파일위치 : [스킨폴더]/main/index.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->


<?php echo showDesignLightPopup( 5)?>

<?php echo showDesignLightPopup( 4)?>

<?php echo showDesignLightPopup( 3)?>

<?php echo showDesignLightPopup( 2)?>

<?php echo showDesignLightPopup( 9)?>

<?php echo showDesignLightPopup( 8)?>

<?php echo showDesignLightPopup( 12)?>

<?php echo showDesignLightPopup( 6)?>

<?php echo showDesignLightPopup( 14)?>

<?php echo showDesignLightPopup( 11)?>

<?php echo showDesignLightPopup( 13)?>

<?php echo showDesignLightPopup( 19)?>

<?php echo showDesignLightPopup( 20)?>

<?php echo showDesignLightPopup( 21)?>

<?php echo showDesignLightPopup( 22)?>

<?php echo showDesignLightPopup( 23)?>


<!-- //띠배너/팝업 -->

<style type="text/css">
	#layout_header { border-bottom:0; }
	#layout_body { max-width:100%; padding-left:0; padding-right:0; }
    .store_box{background:url(/data/skin/responsive_diary_petit_gl_1/images/design_resp/main_center03.jpg);}
    .main_bmp_btnbox{position: absolute;width: 45%;height: 100%;right: 0; top: 0; box-sizing: border-box;}
    .main_bmp_btnbox>a{ width: 43%;float: left;height: 67%; margin:3.5% 2.7%; transition: all 0.2s;}
    .main_bmp_btnbox>a:hover{background-color: rgba(255,255,255,0.3);}
    .pc_bmp_banner{text-align:center; position:relative; max-width: 1920px; margin: 20px auto 0 auto;}

    .mobile_bmp_banner{display: none;text-align:center; position:relative; max-width: 1920px; margin: 20px auto 0 auto;}
    .mobile_main_bmp_btnbox{position: absolute;width: 70%;height: 100%;right: 0; top: 0; box-sizing: border-box;}
    .mobile_main_bmp_btnbox>a{     width: 85%;height: 70%;margin: 10% 6% 0;transition: all 0.2s;display: block;}
    .mobile_main_bmp_btnbox>a:hover{background-color: rgba(255,255,255,0.3);}

    .community{max-width: 1920px; margin: 0 auto; overflow:hidden;}
    .community>ul{width: 100%;}
    .community>ul>li{width: 25%; height: 250px; border: 2px solid #ddd; float: left; box-sizing: border-box;}
    .community>ul>li:nth-of-type(1), .community>ul>li:nth-of-type(2)/*, .community>ul>li:nth-of-type(3)*/{border-right: none;}

    .community>ul>li>a{display: block;width: 100%; height: 100%; padding:55px; box-sizing: border-box;}
    .community>ul>li:nth-of-type(4){padding:55px 60px 20px;}
    .community>ul>li:nth-of-type(4)>p{font-size: 2.5em; font-weight: bold; color: #444;}
    .community>ul>li:nth-of-type(4)>a{padding:10px; border: 2px solid #ddd; text-align: center; width: 55%; height: auto; transition: all 0.2s; font-weight: bold; font-size: 1.3em;}
    .community>ul>li:nth-of-type(4)>a:nth-of-type(1){margin-top: 15px; border-bottom: none;}
    .community>ul>li:nth-of-type(4)>a:hover{opacity: 0.6;}
    .community>ul>li>a>p{transition: all 0.3s;}
    .community>ul>li>a>p:nth-of-type(1){font-size: 2.5em; font-weight: bold;}
    .community>ul>li>a>p:nth-of-type(2){font-size: 1.5em; margin-top: 15px; }
    .community>ul>li>a>p:nth-of-type(3){font-size: 1.5em; margin-top: 5px; }
    .community>ul>li>a>p:nth-of-type(3)>span{font-size: 0.7em;}

    .community>ul>li>a:hover p{opacity: 0.6;}
    .community>ul>li>a:hover p:nth-of-type(3){text-decoration: underline;}
    .comm_1{background: url(/data/skin/responsive_diary_petit_gl_1/images/design_resp/playground.jpg) no-repeat; background-position: right; }
    .comm_2{background: url(/data/skin/responsive_diary_petit_gl_1/images/design_resp/notice2.jpg) no-repeat; background-position: right; }
    .comm_3{background: url(/data/skin/responsive_diary_petit_gl_1/images/design_resp/event.jpg) no-repeat; background-position: right; }
    .comm_4{background: url(/data/skin/responsive_diary_petit_gl_1/images/design_resp/bmp_main_img.png);}

    .mobile_community_box{display: none;}

    @media (max-width:500px) {
		.pc_bmp_banner{display: none;}
		.mobile_bmp_banner{display: block;}

		.community{display: none;}
		.mobile_community_box{display: block;}
	}

/*	@media (orientation: landscape) {
	 Landscape 모드일 때 적용할 CSS 
		body{max-width: 70%; margin: 0 auto;}
	}*/
</style>

<!-- 메인 슬라이드 배너 -->
<!-- 슬라이드 배너 영역 (light_style_1_21) :: START -->
<div class="diary_custom_slider custom_slider sliderA center">
	<?php echo setTemplatePath('main/index.html')?><?php echo showDesignBanner( 21)?>

</div>

<script type="text/javascript">
	$(function () {
		$(".light_style_1_21").not(".slick-initialized").slick({
			// $('.light_style_타입num_배너num')에서 '배너num'는 showDesignBanner(배너num)과 반드시 일치해야 합니다
			dots: true, // 도트 페이징 사용( true 혹은 false )
			autoplay: true, // 슬라이드 자동( true 혹은 false )
			speed: 1000, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 600 == 0.6초 )
			fade: true, // 슬라이딩 fade 모션 사용( true 혹은 fasle )
			autoplaySpeed: 3000, // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 3000 == 3초 )
			customPaging: function (slide, i) {
			// 슬라이드 번호 부분으로 전문가가 아니면 수정을 추천하지 않습니다.
			i = i + 1 + "/" + slide.slideCount;
			return i;
			},
			// 이 외 slick 슬라이더의 자세한 옵션사항은 http://kenwheeler.github.io/slick/ 참고
		});
	});
</script>

<div class="mobile_community_box">
	<?php echo setTemplatePath('main/index.html')?><?php echo showDesignBanner( 22)?>

</div>
<script type="text/javascript">
    $(function () {
        $(".light_style_1_22").slick({
            dots: true, // 도트 페이징 사용( true 혹은 false )
            autoplay: true, // 슬라이드 자동( true 혹은 false )
            speed: 800, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 800 == 0.8초 )
            autoplaySpeed: 4000, // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 4000 == 4초 )
        });
        // 이 외 slick 슬라이더의 자세한 옵션사항은 http://kenwheeler.github.io/slick/ 참고
    });
</script>
<div class="community">
	<ul>
		<li>
			<a href="/board/?id=freeboard" class="comm_1" hrefOri='L2JvYXJkLz9pZD1mcmVlYm9hcmQ=' >
				<p>자유게시판</p>
				<p>뮤직브로만의 놀이터!</p>
				<p>바로가기 <span>></span></p>
			</a>
		</li>
		<li>
			<a href="/board/?id=notice" class="comm_2" hrefOri='L2JvYXJkLz9pZD1ub3RpY2U=' >
				<p>공지사항</p>
				<p>뮤직브로 소식, 공지, 이슈</p>
				<p>바로가기 <span>></span></p>
			</a>
		</li>
		<li>
			<a href="/board/?id=event" class="comm_3" hrefOri='L2JvYXJkLz9pZD1ldmVudA==' >
				<p>이벤트</p>
				<p>뮤직브로의 이벤트!</p>
				<p>바로가기 <span>></span></p>
			</a>
		</li>
		<li class="comm_4">

			<p>BMP 사용하기</p>
			<a href="/coin/coin_notice" hrefOri='L2NvaW4vY29pbl9ub3RpY2U=' >
				BMP코인 → 캐시
			</a>
			<a href="https://bmpbrave.com/" target="_blank" hrefOri='aHR0cHM6Ly9ibXBicmF2ZS5jb20v' >
				BMP코인이란?
			</a>
	
		</li>
	</ul>
</div>
<div class="pc_bmp_banner">
    <img src="/data/skin/responsive_diary_petit_gl_1/images/main_bmp_banner.jpg" alt="" title="" designImgSrcOri='Li4vaW1hZ2VzL21haW5fYm1wX2Jhbm5lci5qcGc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL21haW5fYm1wX2Jhbm5lci5qcGc=' designElement='image' >
    <div class="main_bmp_btnbox">
 		<a href="https://musicbroshop.com/coin/coin_notice" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2NvaW4vY29pbl9ub3RpY2U=' ></a>
 		<a href="https://bmpbrave.com/" hrefOri='aHR0cHM6Ly9ibXBicmF2ZS5jb20v' ></a>
    </div>
</div>

<div class="mobile_bmp_banner">
    <img src="/data/skin/responsive_diary_petit_gl_1/images/mobile_main_bmp_banner2.jpg" alt="" title="" designImgSrcOri='Li4vaW1hZ2VzL21vYmlsZV9tYWluX2JtcF9iYW5uZXIyLmpwZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL21vYmlsZV9tYWluX2JtcF9iYW5uZXIyLmpwZw==' designElement='image' >
    <div class="mobile_main_bmp_btnbox">
 		<a href="https://musicbroshop.com/coin/coin_notice" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2NvaW4vY29pbl9ub3RpY2U=' ></a>
    </div>
</div>


<!-- 슬라이드 배너 영역 (light_style_1_21) :: END -->
<!-- //메인 슬라이드 배너 -->


<div class="resp_wrap">
	<div class="display_diary_right" style="padding-top:20px;">
		<!-- 상품디스플레이 (NEW ARRIVALS) -->
		<div class="title_group1">
			<h3 class="title1"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==" >여러가지 멜로디 <strong>추천 앨범</strong></span></h3>
			<a href="/goods/brand_main" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==" hrefOri='L2dvb2RzL2JyYW5kX21haW4=' >브랜드 자세히 보기</a>
		</div>
		<div class="show_display_col4">
			<?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10311)?>

		</div>
		<!-- //상품디스플레이 (NEW ARRIVALS) -->
	</div>

	<div class="display_diary_custom">
		<div class="title_group1">
			<h3 class="title1"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==" >S/S 시즌별 아이템 한눈에 모아보기</span></h3>
		</div>
		<div class="main_bnr_d1">
			<li class="left_area">
                <!-- 슬라이드 배너 영역 (light_style_1_20) :: START -->
				<?php echo setTemplatePath('main/index.html')?><?php echo showDesignBanner( 20)?>

				<script type="text/javascript">
                    $(function () {
                        $(".main_bnr_d1 .light_style_1_20").slick({
                            dots: true, // 도트 페이징 사용( true 혹은 false )
                            autoplay: true, // 슬라이드 자동( true 혹은 false )
                            speed: 800, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 800 == 0.8초 )
                            autoplaySpeed: 4000, // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 4000 == 4초 )
                        });
                        // 이 외 slick 슬라이더의 자세한 옵션사항은 http://kenwheeler.github.io/slick/ 참고
                    });
				</script>
				<!-- 슬라이드 배너 영역 (light_style_1_20) :: END -->
                <a href="#" class="text1" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA=="  target="_self" hrefOri='Iw==' >뮤직브로만의 특색있는 트렌드 아이템.</a>
				<a href="#" class="text2" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA=="  target="_self" hrefOri='Iw==' >2021 S/S Fashion Item</a>
			</li>
			<li class="right_area">
				<ul class="main_bnr_d1_2">
					<li>
						<a href="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c00130008&per=40&sorting=ranking&filter_display=lattice" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2dvb2RzL2NhdGFsb2c/cGFnZT0xJnNlYXJjaE1vZGU9Y2F0YWxvZyZjYXRlZ29yeT1jMDAxMzAwMDgmcGVyPTQwJnNvcnRpbmc9cmFua2luZyZmaWx0ZXJfZGlzcGxheT1sYXR0aWNl' >
							<img src="/data/skin/responsive_diary_petit_gl_1/images/design_resp/stand_img.PNG" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL3N0YW5kX2ltZy5QTkc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2Rlc2lnbl9yZXNwL3N0YW5kX2ltZy5QTkc=' designElement='image' /></a>
						<a href="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c00130008&per=40&sorting=ranking&filter_display=lattice" class="text1" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2dvb2RzL2NhdGFsb2c/cGFnZT0xJnNlYXJjaE1vZGU9Y2F0YWxvZyZjYXRlZ29yeT1jMDAxMzAwMDgmcGVyPTQwJnNvcnRpbmc9cmFua2luZyZmaWx0ZXJfZGlzcGxheT1sYXR0aWNl' >브레이브걸스 공식 굿즈! </a>
						<a href="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c00130008&per=40&sorting=ranking&filter_display=lattice" class="text2" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2dvb2RzL2NhdGFsb2c/cGFnZT0xJnNlYXJjaE1vZGU9Y2F0YWxvZyZjYXRlZ29yeT1jMDAxMzAwMDgmcGVyPTQwJnNvcnRpbmc9cmFua2luZyZmaWx0ZXJfZGlzcGxheT1sYXR0aWNl' >다양한 K-굿즈 상품</a>
					</li>
					<li>
						<a href="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c0021&per=40&sorting=ranking&filter_display=lattice" target='_self' hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2dvb2RzL2NhdGFsb2c/cGFnZT0xJnNlYXJjaE1vZGU9Y2F0YWxvZyZjYXRlZ29yeT1jMDAyMSZwZXI9NDAmc29ydGluZz1yYW5raW5nJmZpbHRlcl9kaXNwbGF5PWxhdHRpY2U=' ><img src="/data/skin/responsive_diary_petit_gl_1/images/design_resp/main_life01.jpg" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbGlmZTAxLmpwZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbGlmZTAxLmpwZw==' designElement='image' /></a>
						<a href="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c0019&per=40&sorting=ranking&filter_display=lattice" class="text1" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA=="  target="_blank" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2dvb2RzL2NhdGFsb2c/cGFnZT0xJnNlYXJjaE1vZGU9Y2F0YWxvZyZjYXRlZ29yeT1jMDAxOSZwZXI9NDAmc29ydGluZz1yYW5raW5nJmZpbHRlcl9kaXNwbGF5PWxhdHRpY2U=' >디지털 상품 모아보기 </a>
						<a href="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c0019&per=40&sorting=ranking&filter_display=lattice" class="text2" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA=="  target="_self" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2dvb2RzL2NhdGFsb2c/cGFnZT0xJnNlYXJjaE1vZGU9Y2F0YWxvZyZjYXRlZ29yeT1jMDAxOSZwZXI9NDAmc29ydGluZz1yYW5raW5nJmZpbHRlcl9kaXNwbGF5PWxhdHRpY2U=' >노트북,  태블릿,  생활가전</a>
					</li>
				</ul>
			</li>
		</div>
	</div>

	<div class="display_diary_right">
		<!-- 상품디스플레이 -->
		<div class="title_group1">
			<h3 class="title1"><span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==" >BEST 1~10위 <br><strong>인기상품 !!</strong></span></h3>
			<a href="/goods/brand_main" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==" hrefOri='L2dvb2RzL2JyYW5kX21haW4=' >브랜드 자세히 보기</a>
		</div>
		<div class="show_display_col3">
			<?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10001)?>

		</div>
		<!-- //상품디스플레이 -->
	</div>

	<!-- 이미지 배너 -->
	<ul class="cost_bnr_wrap clearbox">
		<li>
			<a href="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c0008&per=40&sorting=ranking&filter_display=lattice" target='_self' hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2dvb2RzL2NhdGFsb2c/cGFnZT0xJnNlYXJjaE1vZGU9Y2F0YWxvZyZjYXRlZ29yeT1jMDAwOCZwZXI9NDAmc29ydGluZz1yYW5raW5nJmZpbHRlcl9kaXNwbGF5PWxhdHRpY2U=' ><img src="/data/skin/responsive_diary_petit_gl_1/images/design_resp/main_center02.jpg" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fY2VudGVyMDIuanBn' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fY2VudGVyMDIuanBn' designElement='image' /></a>
		</li>
		<li>
			<a href="https://musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c0013&per=40&sorting=ranking&filter_display=lattice" target='_self' hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2dvb2RzL2NhdGFsb2c/cGFnZT0xJnNlYXJjaE1vZGU9Y2F0YWxvZyZjYXRlZ29yeT1jMDAxMyZwZXI9NDAmc29ydGluZz1yYW5raW5nJmZpbHRlcl9kaXNwbGF5PWxhdHRpY2U=' ><img src="/data/skin/responsive_diary_petit_gl_1/images/design_resp/main_center01.jpg" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fY2VudGVyMDEuanBn' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fY2VudGVyMDEuanBn' designElement='image' /></a>
         
		</li>
	</ul>
	<!-- //이미지 배너 -->

	<!-- 상품디스플레이 -->
	<div class="title_group1">
		<h3 class="title1"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==" ><strong>MD’</strong>s Pick</span></h3>
	</div>
	<div class="show_display_col4">
		<?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10313)?>

	</div>
	<!-- //상품디스플레이 -->

<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'&&$TPL_VAR["sns"]["ntalk_use"]=='Y'&&$TPL_VAR["sns"]["ntalk_use_mobile_main"]=='Y'){?>
	<!-- 네이버 톡톡 -->
	<div class="btn_talk_area">
		<button type="button" class="btn_talk v2" onclick="location.href='https://talk.naver.com/<?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?>#nafullscreen';">쇼핑할땐 &nbsp;<img src="/data/skin/responsive_diary_petit_gl_1/images/icon/icon_talk.png" class="talk_img" alt="네이버톡톡" designImgSrcOri='Li4vaW1hZ2VzL2ljb24vaWNvbl90YWxrLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2ljb24vaWNvbl90YWxrLnBuZw==' designElement='image' /> 톡톡하세요</button>
	</div>
<?php }?>
</div>