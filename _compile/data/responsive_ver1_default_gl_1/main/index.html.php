<?php /* Template_ 2.2.6 2022/03/07 13:16:42 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl_1/main/index.html 000011512 */  $this->include_("showDesignLightPopup","showDesignBanner","showDesignDisplay");?>
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

  @media (max-width:500px) {
    .pc_bmp_banner{display: none;}
    .mobile_bmp_banner{display: block;}

    .community{display: none;}
    .mobile_community_box{display: block;}
  }
</style>

<!-- 슬라이드 배너 영역 (light_style_2_1) :: START -->
<div class="sliderB wide_visual_slider">
  <?php echo showDesignBanner( 1)?>

</div>
<script type="text/javascript">
$(function() {
  $('.light_style_2_1').slick({
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
<!-- 슬라이드 배너 영역 (light_style_2_1) :: END -->

<div class="pc_bmp_banner">
    <img src="/data/skin/responsive_ver1_default_gl_1/images/main_bmp_banner.jpg" alt="" title="">
    <div class="main_bmp_btnbox">
    <a href="https://musicbroshop.com/coin/coin_notice"></a>
    <a href="https://bmpbrave.com/"></a>
    </div>
</div>

<div class="mobile_bmp_banner">
    <img src="/data/skin/responsive_ver1_default_gl_1/images/mobile_main_bmp_banner2.jpg" alt="" title="">
    <div class="mobile_main_bmp_btnbox">
    <a href="https://musicbroshop.com/coin/coin_notice"></a>
    </div>
</div>



<div class="resp_wrap">
  <!-- BEST PRODUCTS -->
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2xfMS9tYWluL2luZGV4Lmh0bWw=" >BEST</span></h3>
    <p class="text2" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2xfMS9tYWluL2luZGV4Lmh0bWw=" >BEST 1위~10위</p>
  </div>
  <div data-effect="scale opacity" data-iconposition="left" data-icontype="best">
    <?php echo showDesignDisplay( 10001)?>

  </div>

  <!-- RECOMMEND ITEMS -->
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2xfMS9tYWluL2luZGV4Lmh0bWw=" >Recommend Items</span></h3>
    <p class="text2" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2xfMS9tYWluL2luZGV4Lmh0bWw=" >뮤직브로에서 엄선한 추천 상품~!</p>
  </div>
  <ul class="main_bnr_c1">
    <li class="left_area">
      <a href="#https://www.musicbroshop.com/goods/view?no=2120" target='_self'><img src="/data/skin/responsive_ver1_default_gl_1/images/design/resp_bnr_main_101.jpg" title="" alt="" /></a>
      <ul class="main_bnr_c1_2 Pt6">
        <li class="left_area"><a href="#https://www.musicbroshop.com/goods/view?no=2120" target='_self'><img src="/data/skin/responsive_ver1_default_gl_1/images/design/resp_bnr_main_102.jpg" title="" alt="" /></a></li>
        <li class="center_area"><a href="#https://www.musicbroshop.com/goods/view?no=1944" target='_self'><img src="/data/skin/responsive_ver1_default_gl_1/images/design/resp_bnr_main_103.jpg" title="" alt="" /></a></li>
        <li class="right_area"><a href="#https://www.musicbroshop.com/goods/view?no=1541" target='_self'><img src="/data/skin/responsive_ver1_default_gl_1/images/design/resp_bnr_main_104.jpg" title="" alt="" /></a></li>
      </ul>
    </li>
    <li class="right_area">
      <!-- 슬라이드 배너 영역 (light_style_1_3) :: START -->
      <div class="sliderA slider_before_loading">
        <?php echo showDesignBanner( 3)?>

      </div>
      <script type="text/javascript">
      $(function() {
        $('.light_style_1_3').slick({
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
  </ul>


  <!-- FEATURED PRODUCTS -->
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2xfMS9tYWluL2luZGV4Lmh0bWw=" >RENEWAL</span></h3>
    <p class="text2" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2xfMS9tYWluL2luZGV4Lmh0bWw=" >보다 나은 서비스를 위해 홈페이지를 새롭게 개편합니다.</p>
  </div>
  <?php echo showDesignDisplay( 10002)?>



  <!-- NEW PRODUCTS -->
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2xfMS9tYWluL2luZGV4Lmh0bWw=" >RENEWAL</span></h3>
    <p class="text2" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2xfMS9tYWluL2luZGV4Lmh0bWw=" >보다 나은 서비스를 위해 홈페이지를 새롭게 개편합니다.</p>
  </div>
  <!-- 슬라이드 배너 영역 (light_style_2_4) :: START -->
  <div class="main_slider_b2 sliderB slider_before_loading">
    <?php echo showDesignBanner( 4)?>

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
  <?php echo showDesignDisplay( 10003)?>  -->
  

  <!-- 상품디스플레이 -->
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2xfMS9tYWluL2luZGV4Lmh0bWw=" ><strong>RENEWAL</strong>Pick</span></h3>
      <p class="text2" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2xfMS9tYWluL2luZGV4Lmh0bWw=" >보다 나은 서비스를 위해 홈페이지를 새롭게 개편합니다.</p>
  </div>
  <div class="show_display_col4">
    <?php echo showDesignDisplay( 10313)?>

  </div>
  <!-- //상품디스플레이 -->


<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'&&$TPL_VAR["sns"]["ntalk_use"]=='Y'&&$TPL_VAR["sns"]["ntalk_use_mobile_main"]=='Y'){?>
  <!-- 네이버 톡톡 -->
  <div class="btn_talk_area">
    <button type="button" class="btn_talk v2" onclick="location.href='https://talk.naver.com/<?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?>#nafullscreen';"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2xfMS9tYWluL2luZGV4Lmh0bWw=" >쇼핑할땐</span> &nbsp;<img src="/data/skin/responsive_ver1_default_gl_1/images/icon/icon_talk.png" class="talk_img" alt="네이버톡톡" />&nbsp; <span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2xfMS9tYWluL2luZGV4Lmh0bWw=" >톡톡하세요</span></button>
  </div>
<?php }?>

</div>