<?php /* Template_ 2.2.6 2021/12/15 17:04:32 /www/music_brother_firstmall_kr/data/skin/responsive_wristwatch_classic_gl/main/index.html 000009248 */  $this->include_("showDesignLightPopup","setTemplatePath","showDesignBanner","showDesignDisplay");?>
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
    #layout_footer { margin-top:0; }
</style>

<!-- 슬라이드 배너 영역 (light_style_1_3) :: START -->
<div class="sliderA wide_visual_slider">
	<?php echo setTemplatePath('main/index.html')?><?php echo showDesignBanner( 3)?>

</div>
<script type="text/javascript">
    $(function() {
        $('.light_style_1_3').slick({ // $('.light_style_타입num_배너num')에서 '배너num'는 showDesignBanner(배너num)과 반드시 일치해야 합니다
            //arrows: false,     // 좌우 화살표 ( true 혹은 false )
            dots: true,          // 도트 페이징 사용( true 혹은 false )
            autoplay: true,    // 슬라이드 자동( true 혹은 false )
            speed: 1000,      // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 600 == 0.6초 )
            fade: true,          // 슬라이딩 fade 모션 사용( true 혹은 fasle )
            autoplaySpeed: 8000, // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 3000 == 3초 )
            // 이 외 slick 슬라이더의 자세한 옵션사항은 http://kenwheeler.github.io/slick/ 참고
        });
    });
</script>
<!-- 슬라이드 배너 영역 (light_style_1_3) :: END -->
<!-- //메인 슬라이드 배너 -->

<div class="full_bnr">
	<div class="respBnrGon respBnrGon_num2_typeA">
		<ul class="resp_wrap">
			<li><a href="#none" class="roll" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/bnr_01_over.png" alt="배너 01" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl8wMV9vdmVyLnBuZw==' designTplPath='cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3dyaXN0d2F0Y2hfY2xhc3NpY19nbC9pbWFnZXMvZGVzaWduX3Jlc3AvYm5yXzAxX292ZXIucG5n' designElement='image' /></a></li>
			<li><a href="#none" class="roll" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/bnr_02_over.png" alt="배너 02" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2Jucl8wMl9vdmVyLnBuZw==' designTplPath='cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3dyaXN0d2F0Y2hfY2xhc3NpY19nbC9pbWFnZXMvZGVzaWduX3Jlc3AvYm5yXzAyX292ZXIucG5n' designElement='image' /></a></li>
		</ul>
	</div>
</div>
<!-- //full_bnr (이미지 배너) -->

<div class="full_bnr2">
   <a href="#none" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/bnr2_01.jpg" alt="배너 01" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2JucjJfMDEuanBn' designTplPath='cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3dyaXN0d2F0Y2hfY2xhc3NpY19nbC9pbWFnZXMvZGVzaWduX3Jlc3AvYm5yMl8wMS5qcGc=' designElement='image' /></a>
</div>
<!-- //full_bnr2 (이미지 배너) -->

<div class="resp_wrap display_wrap">
    <div class="title_group1">
		<h3 class="title1"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvbWFpbi9pbmRleC5odG1s" >Best Collection</span></h3>
	</div>
    <div class="show_display_col4">
        <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10341)?>

    </div>
</div>
<!-- //상품디스플레이 (Best Collection) -->

<div class="full_bnr3">
	<div class="respBnrGon respBnrGon_num3_typeE">
		<div class="title_group1">
			<h3 class="title1"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvbWFpbi9pbmRleC5odG1s" >Weekly Post</span></h3>
		</div>
		<ul class="resp_wrap" data-effect="opacity">
			<li><a href="#none" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/bnr3_01.jpg" alt="배너 01" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2JucjNfMDEuanBn' designTplPath='cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3dyaXN0d2F0Y2hfY2xhc3NpY19nbC9pbWFnZXMvZGVzaWduX3Jlc3AvYm5yM18wMS5qcGc=' designElement='image' /></a></li>
			<li><a href="#none" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/bnr3_02.jpg" alt="배너 02" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2JucjNfMDIuanBn' designTplPath='cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3dyaXN0d2F0Y2hfY2xhc3NpY19nbC9pbWFnZXMvZGVzaWduX3Jlc3AvYm5yM18wMi5qcGc=' designElement='image' /></a></li>
			<li><a href="#none" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/bnr3_03.jpg" alt="배너 03" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2JucjNfMDMuanBn' designTplPath='cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3dyaXN0d2F0Y2hfY2xhc3NpY19nbC9pbWFnZXMvZGVzaWduX3Jlc3AvYm5yM18wMy5qcGc=' designElement='image' /></a></li>
		</ul>
	</div>
</div>
<!-- //full_bnr3 (이미지 배너) -->

<div class="resp_wrap display_wrap">
    <div class="title_group1">
		<h3 class="title1"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvbWFpbi9pbmRleC5odG1s" >New Collection</span></h3>
	</div>
    <div class="show_display_col4">
        <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10342)?>

    </div>
</div>
<!-- //상품디스플레이 (New Collection) -->

<div class="full_bnr4">
	<div class="respBnrGon respBnrGon_num2_typeA">
		<ul class="resp_wrap">
			<li><a href="#none" class="btn_mov" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/bnr4_01.jpg" alt="영상" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2JucjRfMDEuanBn' designTplPath='cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3dyaXN0d2F0Y2hfY2xhc3NpY19nbC9pbWFnZXMvZGVzaWduX3Jlc3AvYm5yNF8wMS5qcGc=' designElement='image' ></a></li>
			<li><a href="/service/company" target='_self' hrefOri='L3NlcnZpY2UvY29tcGFueQ==' ><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/bnr4_02.png" title="텍스트" alt="텍스트" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2JucjRfMDIucG5n' designTplPath='cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3dyaXN0d2F0Y2hfY2xhc3NpY19nbC9pbWFnZXMvZGVzaWduX3Jlc3AvYm5yNF8wMi5wbmc=' designElement='image' ></a></li>
		</ul>
	</div>
	<div id="full_mov" class="full_mov">
		<div class="wrap">
			<div class="mov">
				<iframe id="player" width="560" height="315" src="https://www.youtube.com/embed/PD_AM4WOFa4?enablejsapi=1&amp;version=3&amp;playerapiid=ytplayer" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
				<!-- 유투브 iframe에 id값을 지정 해주고, src쪽에는 ?enablejsapi=1&version=3&playerapiid=ytplayer 를 추가 -->
			</div>
		</div>
		<a href="#none" class="close" hrefOri='I25vbmU=' >X</a>
	</div>
	<script type="text/javascript">
		$(function(){
			$(".full_bnr4 .btn_mov").on("click", function(){
				$("#full_mov").show();
			});
			$(".full_mov .close").on("click", function(){
				$("#full_mov").hide();
				$('#player')[0].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
				/* 팝업창 닫을 떄 유투브 동영상 제어하기 => 재생 = playVideo, 일시정지 = pauseVideo, 중지 = stopVideo
				자세한건 참조문서를 보면된다. ( https://developers.google.com/youtube/iframe_api_reference?hl=ko ) */
			});
		});
	</script>
</div>
<!-- //full_bnr4 (동영상) -->

<div class="resp_wrap">
<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'&&$TPL_VAR["sns"]["ntalk_use"]=='Y'&&$TPL_VAR["sns"]["ntalk_use_mobile_main"]=='Y'){?>
	<div class="btn_talk_area">
		<button type="button" class="btn_talk v2" onclick="location.href='https://talk.naver.com/<?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?>#nafullscreen';">쇼핑할땐 &nbsp;<img src="/data/skin/responsive_wristwatch_classic_gl/images/icon/icon_talk.png" class="talk_img" alt="네이버톡톡" designImgSrcOri='Li4vaW1hZ2VzL2ljb24vaWNvbl90YWxrLnBuZw==' designTplPath='cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3dyaXN0d2F0Y2hfY2xhc3NpY19nbC9pbWFnZXMvaWNvbi9pY29uX3RhbGsucG5n' designElement='image' /> 톡톡하세요</button>
	</div>
<?php }?>
</div>
<!-- //네이버 톡톡 -->