<?php /* Template_ 2.2.6 2021/12/15 17:08:34 /www/music_brother_firstmall_kr/data/skin/responsive_accessories_classy_gl/main/index.html 000006458 */  $this->include_("showDesignLightPopup","setTemplatePath","showDesignBanner","showDesignDisplay");?>
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
	body { background:#f2ede9; }
    #layout_body { max-width:100%; padding-left:0; padding-right:0; background:inherit; }
	#layout_header { background:inherit; }
	#layout_footer { margin-top:120px; background:#fff; }
	@media only screen and (max-width:767px) {
		#layout_footer { margin-top:70px;}
	}
</style>

<div class="resp_wrap">
	<ul class="full_bnr clearbox">
		<li class="l_cont">
            <!-- 슬라이드 배너 영역 (light_style_1_3) :: START -->
            <div class="sliderA main_slider slider_before_loading">
                <?php echo setTemplatePath('main/index.html')?><?php echo showDesignBanner( 3)?>

            </div>
            <script type="text/javascript">
                $(function() {
                    $('.light_style_1_3').not('.slick-initialized').slick({ // $('.light_style_타입num_배너num')에서 '배너num'는 showDesignBanner(배너num)과 반드시 일치해야 합니다
                        dots: true, // 도트 페이징 사용( true 혹은 false )
                        autoplay: true, // 슬라이드 자동( true 혹은 false )
                        speed: 1000, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 600 == 0.6초 )
                        fade: true, // 슬라이딩 fade 모션 사용( true 혹은 fasle )
                        autoplaySpeed: 6000 // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 3000 == 3초 )
                        // 이 외 slick 슬라이더의 자세한 옵션사항은 http://kenwheeler.github.io/slick/ 참고
                    });
                });
            </script>
            <!-- 슬라이드 배너 영역 (light_style_1_3) :: END -->
            <!-- //메인 슬라이드 배너 -->
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbWFpbi9pbmRleC5odG1s" >
				Our design is different.<br />
				Meet high-quality item<br />
				daily mood</span>
			</h2>
			<p>I'd love to hear your story and work with you.</p>
		</li>
		<li class="r_cont">
            <h2><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbWFpbi9pbmRleC5odG1s" >
				I’ll be that for you.<br />
				I want the connection,<br />
				the vulnerability.</span>
			</h2>
			<p>They came to us with an existing brand, but a need to elevate
			the design and add personality. Luckily for us, each fragrance
			already came with a playful anecdote or sentimental story.</p>
            <img src="/data/skin/responsive_accessories_classy_gl/images/design_resp/bnr_01.jpg" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl8wMS5qcGc=' designTplPath='cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2FjY2Vzc29yaWVzX2NsYXNzeV9nbC9pbWFnZXMvZGVzaWduX3Jlc3AvYm5yXzAxLmpwZw==' designElement='image' >
        </li>
	</ul>
</div>

<div class="full_bnr2">
	<div class="resp_wrap">
		<div class="title_group1">
			<h3 class="title1"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbWFpbi9pbmRleC5odG1s" >Our Best Sellers</span></h3>
		</div>
		<div class="resp_special">
			<div class="show_display_col4" data-effect="opacity translate_y">
			   <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10381)?>

			</div>
		</div>
	</div>
</div>
<!-- //메인 상품 디스플레이 -->

<div class="resp_wrap">
	<ul class="full_bnr3 clearbox">
		<li class="l_cont">
			<h2>
				<span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbWFpbi9pbmRleC5odG1s" >
					We offer timeless<br />
					jewelry to accentuate<br />
					<strong>their natural beauty</strong>
				</span>
            </h2>
			<p class="sbtn"><a href="#none" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbWFpbi9pbmRleC5odG1s" hrefOri='I25vbmU=' >ABOUT US</a></p>
		</li>
		<li class="r_cont"><a href="#none" class="btn_mov" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_accessories_classy_gl/images/design_resp/bnr_02.jpg" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl8wMi5qcGc=' designTplPath='cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2FjY2Vzc29yaWVzX2NsYXNzeV9nbC9pbWFnZXMvZGVzaWduX3Jlc3AvYm5yXzAyLmpwZw==' designElement='image' ></a></li>
	</ul>
</div>
<!-- //full_bnr -->

<div class="resp_wrap">
    <div class="title_group1">
        <h3 class="title1"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbWFpbi9pbmRleC5odG1s" >Season Collection</span></h3>
    </div>
	<div class="resp_special">
		<div class="show_display_col3" data-effect="opacity">
			<?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10382)?>

		</div>
	</div>
</div>
<!-- //메인 상품 디스플레이 -->

<div class="resp_wrap">
<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'&&$TPL_VAR["sns"]["ntalk_use"]=='Y'&&$TPL_VAR["sns"]["ntalk_use_mobile_main"]=='Y'){?>
	<div class="btn_talk_area">
		<button type="button" class="btn_talk v2" onclick="location.href='https://talk.naver.com/<?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?>#nafullscreen';">쇼핑할땐 &nbsp;<img src="/data/skin/responsive_accessories_classy_gl/images/icon/icon_talk.png" class="talk_img" alt="네이버톡톡" designImgSrcOri='Li4vaW1hZ2VzL2ljb24vaWNvbl90YWxrLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2FjY2Vzc29yaWVzX2NsYXNzeV9nbC9pbWFnZXMvaWNvbi9pY29uX3RhbGsucG5n' designElement='image' /> 톡톡하세요</button>
	</div>
<?php }?>
</div>
<!-- //네이버 톡톡 -->