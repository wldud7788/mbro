<?php /* Template_ 2.2.6 2022/03/07 14:25:42 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/main/index.html 000017297 */  $this->include_("showDesignLightPopup","setTemplatePath","showDesignBanner","showDesignDisplay");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ index @@
- 파일위치 : [스킨폴더]/main/index.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php echo showDesignLightPopup( 4)?>

<?php echo showDesignLightPopup( 3)?>

<?php echo showDesignLightPopup( 2)?>

<?php echo showDesignLightPopup( 1)?>

<?php echo showDesignLightPopup( 24)?>

<?php echo showDesignLightPopup( 25)?>



<style type="text/css">
  #layout_body { max-width:100%; padding-left:0; padding-right:0; }

  .main_bmp_btnbox{position: absolute;width: 45%;height: 100%;right: 0; top: 0; box-sizing: border-box;}
  .main_bmp_btnbox>a{ width: 43%;float: left;height: 67%; margin:3.5% 2.7%; transition: all 0.2s;}
  .main_bmp_btnbox>a:hover{background-color: rgba(255,255,255,0.3);}
  .pc_bmp_banner{text-align:center; position:relative; max-width: 1920px; margin: 20px auto 0 auto;}

  .mobile_bmp_banner{display: none;text-align:center; position:relative; max-width: 1920px; margin: 20px auto 0 auto;}
  .mobile_main_bmp_btnbox{position: absolute;width: 70%;height: 100%;right: 0; top: 0; box-sizing: border-box;}
  .mobile_main_bmp_btnbox>a{     width: 85%;height: 70%;margin: 10% 6% 0;transition: all 0.2s;display: block;}
  .mobile_main_bmp_btnbox>a:hover{background-color: rgba(255,255,255,0.3);}
  .sliderB .text_wrap {display: none;}

  .bg_event_zone{margin: 50px auto; max-width: 950px;}
  
  .bg_event_pc{ position: relative;width: 950px;height: 600px;}

  .title_group1{padding: 100px 0 50px 0;}


  @media (max-width: 1280px) {
    .bg_event_pc{display: none;}
  }

  @media (max-width:500px) {
    .pc_bmp_banner{display: none;}
    .mobile_bmp_banner{display: block;}

    .community{display: none;}
    .mobile_community_box{display: block;}
  }

  #layout_body { max-width:100%; padding-left:0; padding-right:0; }
    #layout_footer { margin-top:100px; }
    .main_bnr3 .respBnrGon_num3_typeB{padding-top: 10px;}
    .respBnrGon{overflow: hidden;zoom: 1;text-align: center;}
    .main_bnr3 .respBnrGon_num3_typeB>ul{magin: -20px 0 0 -20px;}
    .main_bnr3 .respBnrGon_num3_typeB>ul>li{width: 50%; padding: 20px 0 0 20px;}
    .respBnrGon_num3_typeB>ul>li:nth-child(3n+1){clear: both; float: right;}
    .respBnrGon>ul>li{box-sizing: border-box;display: inline-block;vertical-align: top;font-size: 15px;line-height: 1.4;}
    .full_bnr .respBnrGon_num2_typeA>ul>li:nth-child(1){padding-left: 70px; padding-bottom: 100px;}
    .respBnrGon_num2_typeA>ul>li:nth-child(odd){float: left; padding: .47% .47% .47% 0}
    .respBnrGon_num2_typeA>ul{max-width: 1260px; margin:0 auto;}
    .respBnrGon_num2_typeA>ul>li{width: 50%;}
    .respBnrGon_num2_typeA>ul>li>a{width: 80%; display: inline-block;}
    .full_bnr a.roll img{-webkit-filter: grayscale(100%);}
    .full_bnr a.roll img:hover{-webkit-filter: grayscale(0%);}

    @media only screen and (max-width: 767px){
      .main_bnr3 .respBnrGon_num3_typeB>ul>li{width: 100%;}
      .full_bnr .respBnrGon_num2_typeA>ul>li{padding: 0; width: 50%;}
      .full_bnr .respBnrGon_num2_typeA>ul>li:nth-child(1){padding: 0;}
      .respBnrGon_num2_typeA>ul>li>a{width: 95%;}
      .respBnrGon_num2_typeA>ul>li>a>h2{font-size: 18px !important;}
      .respBnrGon_num2_typeA>ul>li>a>p{font-size: 12px;}
    }
</style>

<div class="main_slider_a2 sliderA slider_before_loading">
  <?php echo setTemplatePath('main/index.html')?><?php echo showDesignBanner( 10)?>

</div>
<!-- //3단 슬라이드 배너 -->
<script type="text/javascript">
    $(function() {
        $('.light_style_1_10').slick({
            dots: true, // 도트 페이징 사용( true 혹은 false )
            autoplay: true, // 슬라이드 자동( true 혹은 false )
            autoplaySpeed: 8000, // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 8000 == 8초 )
            speed: 800, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 800 == 0.8초 )
            centerMode: true, // 센터모드 사용( true 혹은 false )
            variableWidth: true, // 가변 넓이 사용( true 혹은 false )
            slidesToShow: 1,
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

<div class="pc_bmp_banner">
    <img src="/data/skin/responsive_ver1_default_gl/images/main_bmp_banner.jpg" alt="" title="" designImgSrcOri='Li4vaW1hZ2VzL21haW5fYm1wX2Jhbm5lci5qcGc=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvbWFpbl9ibXBfYmFubmVyLmpwZw==' designElement='image' >
    <div class="main_bmp_btnbox">
    <a href="https://musicbroshop.com/coin/coin_notice" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2NvaW4vY29pbl9ub3RpY2U=' ></a>
    <a href="https://bmpbrave.com/" hrefOri='aHR0cHM6Ly9ibXBicmF2ZS5jb20v' ></a>
    </div>
</div>

<div class="mobile_bmp_banner">
    <img src="/data/skin/responsive_ver1_default_gl/images/mobile_main_bmp_banner2.jpg" alt="" title="" designImgSrcOri='Li4vaW1hZ2VzL21vYmlsZV9tYWluX2JtcF9iYW5uZXIyLmpwZw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvbW9iaWxlX21haW5fYm1wX2Jhbm5lcjIuanBn' designElement='image' >
    <div class="mobile_main_bmp_btnbox">
    <a href="https://musicbroshop.com/coin/coin_notice" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2NvaW4vY29pbl9ub3RpY2U=' ></a>
    </div>
</div>

<!-- <div class="bg_event_zone">
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textindex="3" texttemplatepath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" class="designElement">Brave Girls New Item</span></h3>
    <p class="text2 designElement" designElement="text" textindex="4" texttemplatepath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s">브레이브걸스 신규 앨범</p>
  </div>
  <div class="bg_event_pc">
    <div class="bg_event_box01">

    </div>
    <div class="bg_event_box02">

    </div>
  </div>
</div> -->

<div class="resp_wrap" style="display:none;">
  <!-- RECOMMEND ITEMS -->
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" >브레이브걸스 EVENT</span></h3>
    <p class="text2" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" >브레이브걸스 미니 6집 [THANK YOU] 발매 기념 쇼케이스 초대 이벤트</p>
  </div>
  <ul class="main_bnr_c1">
    <li class="left_area" style="width: 76.8%;">
      <!-- 슬라이드 배너 영역 (light_style_1_3) :: START -->
      <div class="sliderA slider_before_loading">
        <?php echo setTemplatePath('main/index.html')?><?php echo showDesignBanner( 11)?>

      </div>
      <script type="text/javascript">
      $(function() {
        $('.light_style_1_11').slick({
          dots: true, // 도트 페이징 사용( true 혹은 false )
          autoplay: true, // 슬라이드 자동( true 혹은 false )
          speed: 800, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 800 == 0.8초 )
          autoplaySpeed: 4000 // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 4000 == 4초 )
        });
        // 이 외 slick 슬라이더의 자세한 옵션사항은 http://kenwheeler.github.io/slick/ 참고
      });
      </script>
      <!-- 슬라이드 배너 영역 (light_style_1_3) :: END -->
    </li>
    <li class="right_area">
<!--       <a href="#" target='_self' hrefOri='Iw==' ><img src="/data/skin/responsive_ver1_default_gl/images/design/resp_bnr_main_101.jpg" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9yZXNwX2Jucl9tYWluXzEwMS5qcGc=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvZGVzaWduL3Jlc3BfYm5yX21haW5fMTAxLmpwZw==' designElement='image' /></a> -->
      <ul class="main_bnr_c1_2">
        <li class="left_area"><a href="#" target='_self' hrefOri='Iw==' ><img src="/data/skin/responsive_ver1_default_gl/images/design/bg_subimg02.jpg" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9iZ19zdWJpbWcwMi5qcGc=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvZGVzaWduL2JnX3N1YmltZzAyLmpwZw==' designElement='image' /></a></li>
        <!-- <li class="center_area"><a href="#" target='_self' hrefOri='Iw==' ><img src="/data/skin/responsive_ver1_default_gl/images/design/resp_bnr_main_103.jpg" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9yZXNwX2Jucl9tYWluXzEwMy5qcGc=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvZGVzaWduL3Jlc3BfYm5yX21haW5fMTAzLmpwZw==' designElement='image' /></a></li> -->
        <li class="right_area"><a href="#ew?no=1541" target='_self' hrefOri='I2V3P25vPTE1NDE=' ><img src="/data/skin/responsive_ver1_default_gl/images/design/bg_subimg01.jpg" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9iZ19zdWJpbWcwMS5qcGc=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvZGVzaWduL2JnX3N1YmltZzAxLmpwZw==' designElement='image' /></a></li>
      </ul>
    </li>
    
  </ul>
</div>




<div class="resp_wrap">


  <!-- BEST PRODUCTS -->
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" >BEST</span></h3>
    <p class="text2" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" >BEST 1위~10위</p>
  </div>
  <div data-effect="scale opacity" data-iconposition="left" data-icontype="best">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10001)?>

  </div>




  <!-- FEATURED PRODUCTS -->
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" >RENEWAL</span></h3>
    <p class="text2" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" >보다 나은 서비스를 위해 홈페이지를 새롭게 개편합니다.</p>
  </div>
  <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10002)?>



  <!-- NEW PRODUCTS -->
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" >RENEWAL</span></h3>
    <p class="text2" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" >보다 나은 서비스를 위해 홈페이지를 새롭게 개편합니다.</p>
  </div>
  <!-- 슬라이드 배너 영역 (light_style_2_4) :: START -->
  <div class="main_slider_b2 sliderB slider_before_loading">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignBanner( 4)?>

  </div>
  <script type="text/javascript">
  $(function() {
    $('.light_style_2_4').slick({
      dots: true, // 도트 페이징 사용( true 혹은 false )
      autoplay: true, // 슬라이드 자동( true 혹은 false )
      speed: 1000, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 600 == 0.6초 )
      fade: true, // 페이드 모션 사용
      autoplaySpeed: 5000 // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 5000 == 5초 )
    });
    // 이 외 slick 슬라이더의 자세한 옵션사항은 http://kenwheeler.github.io/slick/ 참고
  });
  </script>
  <!-- 슬라이드 배너 영역 (light_style_2_4) :: END -->


  <!-- firstmall STORY
  <div class="title_group1">
    <p class="text1" designElement="text">"가치와 세련됨을 잃지 않는"</p>
    <h3 class="title1"><span designElement="text">여기는 STORY 입니다.</span></h3>
    <p class="text2" designElement="text">이미지를 클릭하면 STORY 게시판으로 이동합니다.</p>
  </div> -->
  <!-- 슬라이드 배너 영역 (light_style_1_5) :: START 
  <div class="main_slider_a1 sliderA slider_before_loading" data-effect="opacity">
    
  </div>
  <script type="text/javascript">
  $(function() {
    $('.light_style_1_5').slick({
      slidesToShow: 3, // 한 화면에 몇개의 슬라이드를 보여줄 것인가? - 3개
      slidesToScroll: 2, // 슬라이드 할때, 몇개씩 슬라이드할 것인가? - 2개
      speed: 800, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 800 == 0.8초 )
      responsive: [
      {
        breakpoint: 768, // 스크린 가로 사이즈가 768px 이하일 때,
        settings: {
          arrows: false, // 좌우 버튼 페이징 사용 안함( 사용함: true, 사용안함: false )
          centerMode: true, // 센터모드 사용( true 혹은 false )
          centerPadding: '40px', // 센터모드 사용시 좌우 여백
          slidesToShow: 2 // 한 화면에 몇개의 슬라이드를 보여줄 것인가? - 2개
        }
      },
      {
        breakpoint: 480, // 스크린 가로 사이즈가 400px 이하일 때,
        settings: {
          arrows: false, // 좌우 버튼 페이징 사용 안함( 사용함: true, 사용안함: false )
          centerMode: true, // 센터모드 사용( true 혹은 false )
          centerPadding: '60px', // 센터모드 사용시 좌우 여백
          slidesToShow: 1 // 한 화면에 몇개의 슬라이드를 보여줄 것인가? - 1개
        }
      }]
    });
    // 이 외 slick 슬라이더의 자세한 옵션사항은 http://kenwheeler.github.io/slick/ 참고
  });
  </script>-->
  <!-- 슬라이드 배너 영역 (light_style_1_5) :: END -->

  <!-- <div class="title_group1"> 
    <h3 class="title1"><span designElement="text">REVIEW</span></h3>
    <p class="text2" designElement="text">퍼스트몰 반응형 스킨은 세련된 리뷰형 상품정보도 제공합니다.</p>
  </div>
  <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10003)?>  -->
  

  <!-- 상품디스플레이 -->
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" ><strong>RENEWAL</strong> Pick</span></h3>
      <p class="text2" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" >보다 나은 서비스를 위해 홈페이지를 새롭게 개편합니다.</p>
  </div>
  <div class="show_display_col4">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10313)?>

  </div>
  <!-- //상품디스플레이 -->


<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'&&$TPL_VAR["sns"]["ntalk_use"]=='Y'&&$TPL_VAR["sns"]["ntalk_use_mobile_main"]=='Y'){?>
  <!-- 네이버 톡톡 -->
  <div class="btn_talk_area">
    <button type="button" class="btn_talk v2" onclick="location.href='https://talk.naver.com/<?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?>#nafullscreen';"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" >쇼핑할땐</span> &nbsp;<img src="/data/skin/responsive_ver1_default_gl/images/icon/icon_talk.png" class="talk_img" alt="네이버톡톡" designImgSrcOri='Li4vaW1hZ2VzL2ljb24vaWNvbl90YWxrLnBuZw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvaWNvbi9pY29uX3RhbGsucG5n' designElement='image' />&nbsp; <span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWFpbi9pbmRleC5odG1s" >톡톡하세요</span></button>
  </div>
<?php }?>

</div>