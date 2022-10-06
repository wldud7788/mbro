<?php /* Template_ 2.2.6 2022/09/26 16:37:35 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/main/index.html 000029534 */  $this->include_("showDesignLightPopup","setTemplatePath","showDesignBanner","showDesignDisplay","getBoarddata");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ index @@
- 파일위치 : [스킨폴더]/main/index.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<?php echo showDesignLightPopup( 4)?>

<?php echo showDesignLightPopup( 3)?>

<?php echo showDesignLightPopup( 2)?>

<?php echo showDesignLightPopup( 1)?>

<?php echo showDesignLightPopup( 27)?>

<?php echo showDesignLightPopup( 26)?>

<!-- //띠배너/팝업 -->

<style type="text/css">
    #layout_body { max-width:100%; padding-left:0; padding-right:0; }
    #layout_footer { margin-top:100px; }
    .main_bnr3 .respBnrGon_num3_typeB{padding-top: 10px;}
    .respBnrGon{overflow: hidden;zoom: 1;text-align: center;}
    .main_bnr3 .respBnrGon_num3_typeB>ul{magin: -20px 0 0 -20px;}
    .main_bnr3 .respBnrGon_num3_typeB>ul>li{width: 50%; padding: 20px 0 0 20px;}
    /*.respBnrGon_num3_typeB>ul>li:nth-child(3n+1){clear: both; float: right;}*/
    .respBnrGon>ul>li{box-sizing: border-box;display: inline-block;vertical-align: top;font-size: 15px;line-height: 1.4;}
    .full_bnr .respBnrGon_num2_typeA>ul>li:nth-child(1){padding-left: 70px; padding-bottom: 100px;}
    .respBnrGon_num2_typeA>ul>li:nth-child(odd){float: left; padding: .47% .47% .47% 0}
    .respBnrGon_num2_typeA>ul{max-width: 1260px; margin:0 auto;}
    .respBnrGon_num2_typeA>ul>li{width: 50%;}
    .respBnrGon_num2_typeA>ul>li>a{width: 80%; display: inline-block;}
    .full_bnr a.roll img{-webkit-filter: grayscale(100%);}
    .full_bnr a.roll img:hover{-webkit-filter: grayscale(0%);}
    .displaY_goods_short_desc span{-webkit-line-clamp: 1;}
    /*.show_display_col4 .display_slide_class .swiper-slide{width: 16.6%;}*/
    .show_display_col4 .display_responsible_class .goods_list li.gl_item{width: 16.6%;}
    .designPopup .designPopupBody{max-width:400px;}

    /*.show_display_col4 .display_responsible_class .goods_list li.gl_item{width: 16.6%;}*/

    @media only screen and (max-width: 767px){
      .main_bnr3 .respBnrGon_num3_typeB>ul>li{width: 100%;}
      .full_bnr .respBnrGon_num2_typeA>ul>li{padding: 0; width: 50%;}
      .full_bnr .respBnrGon_num2_typeA>ul>li:nth-child(1){padding: 0;}
      .respBnrGon_num2_typeA>ul>li>a{width: 95%;}
      .respBnrGon_num2_typeA>ul>li>a>h2{font-size: 18px !important;}
      .respBnrGon_num2_typeA>ul>li>a>p{font-size: 12px;}
      .show_display_col4 .display_slide_class .swiper-slide{width: 50%;}
      .show_display_col4 .display_responsible_class .goods_list li.gl_item{width: 50%;}
    }
</style>

<!-- 슬라이드 배너 영역 (light_style_1_3) :: START -->
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

<div class="resp_wrap">
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >Review Event</span></h3>
    <p class="text2" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >포토후기 1,000캐시, 일반후기 500캐시 지급!</p>
  </div>
  <div class="main_bnr_type2" style="margin-top:0px;">
      <ul data-effect="scale">
          <li style="text-align: center">
              <a href="https://musicbroshop.com/board/?id=goods_review" target="_blank" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2JvYXJkLz9pZD1nb29kc19yZXZpZXc=' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/event_banner_02.png" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2V2ZW50X2Jhbm5lcl8wMi5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL2V2ZW50X2Jhbm5lcl8wMi5wbmc=' designElement='image' /></a>
          </li>

      </ul>
  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >다꾸 스티커 9월 신상</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10384)?>

  </div>
</div>
<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
      <h3 class="title1"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" > 후기 300개 돌파상품 </span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10383)?>

  </div>
</div>
<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >귀여운 건 못 참아!!! </span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10382)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >이 상품 어때요? </span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10388)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >수제 쿠키 전문점 소드락이</span></h3>
    <p class="text2" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >드라마 정주행을 위한 이불 속 간식</p>
  </div>
  <div class="main_bnr_type2" style="margin-top:0px;">
      <ul data-effect="scale">
          <li style="text-align: center">
              <a href="https://musicbroshop.com/board/?id=goods_review" target="_blank" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2JvYXJkLz9pZD1nb29kc19yZXZpZXc=' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/event_banner_03.png" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2V2ZW50X2Jhbm5lcl8wMy5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL2V2ZW50X2Jhbm5lcl8wMy5wbmc=' designElement='image' /></a>
          </li>

      </ul>
  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >놓치면 후회할 가격</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10361)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >MD의 추천! 가을엔 커플템으로 데이트를</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10371)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >뮤직브로에서는 뮤직을 듣자</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10381)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >디저트 배는 따로 있지</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10379)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >캐시 즉시지급</span></h3>
    <!-- <p class="text2" designElement="text">뮤직브로에서 지급하는 캐시 </p> -->
  </div>
  <div class="main_bnr_type2" style="margin-top:0px;">
      <ul data-effect="scale">
          <li style="text-align: center">
              <a href="https://musicbroshop.com/board/?id=goods_review" target="_blank" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2JvYXJkLz9pZD1nb29kc19yZXZpZXc=' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/event_banner_04.png" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2V2ZW50X2Jhbm5lcl8wNC5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL2V2ZW50X2Jhbm5lcl8wNC5wbmc=' designElement='image' /></a>
          </li>
      </ul>
  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >어디서 유럽 냄새 안나요? 유럽식 절임 소스 모음
</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10378)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >미뤄왔던 가을 감성 인테리어 준비
</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10377)?>

  </div>
</div>



<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >패.완.악 포인트가 되는 악세서리 
</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10389)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >모던 아트 포스터로 집안에 생기를
</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10390)?>

  </div>
</div>


<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >인기 간편식
</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10391)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >홈파티 캠핑을 위한 상차림
</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10392)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >혹시 이거 사러 들어오셨는지요…?
</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10393)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="21"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >간단하게 챙기는 점심식사
</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10394)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1" style="text-align:center;">
    <h3 class="title1"><span designElement="text" textIndex="22"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >수고했어, 오늘도
</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10395)?>

  </div>
</div>

<div class="resp_wrap">
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="23"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >깨알같은 고객 후기들</span></h3>
    <p class="text2" designElement="text" textIndex="24"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >고객님들의 정성스러운 포토 후기들</p>
  </div>
  <div class="main_bnr_type2" style="margin-top:0px;">
      <ul data-effect="scale">
          <li style="text-align: center">
              <a href="https://musicbroshop.com/board/?id=goods_review" target="_blank" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2JvYXJkLz9pZD1nb29kc19yZXZpZXc=' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/event_banner_05.png" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2V2ZW50X2Jhbm5lcl8wNS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL2V2ZW50X2Jhbm5lcl8wNS5wbmc=' designElement='image' /></a>
          </li>
      </ul>
  </div>
</div>


<!-- //BEST PRODUCTS

<div class="resp_wrap">
  <div class="title_group1">
    <h3 class="title1"><span designElement="text">BMP코인 캐시 전환 이벤트</span></h3>
    <p class="text2" designElement="text">BMP 코인 쇼핑몰에서 현금처럼 사용 가능</p>
  </div>
  <div class="main_bnr_type2" style="margin-top:0px;">
      <ul data-effect="scale">
          <li style="text-align: center">
              <a href="https://musicbroshop.com/coin/coin_notice" target="_blank" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2NvaW4vY29pbl9ub3RpY2U=' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/coin_sbaner.png" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2NvaW5fc2JhbmVyLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL2NvaW5fc2JhbmVyLnBuZw==' designElement='image' /></a>
          </li>

      </ul>
  </div>
</div>
 -->


<!-- // 기획전 배너

<div class="resp_wrap main_bnr3">
    <div class="title_group1">
    <h3 class="title1"><span designElement="text">기획전</span></h3>
  </div>
  <div class="respBnrGon respBnrGon_num3_typeB">
    <ul data-effect="scale">
      <li><a href="https://www.musicbroshop.com/promotion/event_view?event=35&page=1&searchMode=event_view&per=40&sorting=ranking&filter_display=lattice" target='_self' hrefOri='aHR0cHM6Ly93d3cubXVzaWNicm9zaG9wLmNvbS9wcm9tb3Rpb24vZXZlbnRfdmlldz9ldmVudD0zNSZwYWdlPTEmc2VhcmNoTW9kZT1ldmVudF92aWV3JnBlcj00MCZzb3J0aW5nPXJhbmtpbmcmZmlsdGVyX2Rpc3BsYXk9bGF0dGljZQ==' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/main_middle_img_20220617_01.png" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbWlkZGxlX2ltZ18yMDIyMDYxN18wMS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbWlkZGxlX2ltZ18yMDIyMDYxN18wMS5wbmc=' designElement='image' /></a></li>
      <li><a href="https://www.musicbroshop.com/promotion/event_view?event=36&page=1&searchMode=event_view&per=40&sorting=ranking&filter_display=lattice" target='_self' hrefOri='aHR0cHM6Ly93d3cubXVzaWNicm9zaG9wLmNvbS9wcm9tb3Rpb24vZXZlbnRfdmlldz9ldmVudD0zNiZwYWdlPTEmc2VhcmNoTW9kZT1ldmVudF92aWV3JnBlcj00MCZzb3J0aW5nPXJhbmtpbmcmZmlsdGVyX2Rpc3BsYXk9bGF0dGljZQ==' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/main_middle_img_20220617_02.png" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbWlkZGxlX2ltZ18yMDIyMDYxN18wMi5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbWlkZGxlX2ltZ18yMDIyMDYxN18wMi5wbmc=' designElement='image' /></a></li>
      <li><a href="https://www.musicbroshop.com/promotion/event_view?event=37&page=1&searchMode=event_view&per=40&sorting=ranking&filter_display=lattice" target='_self' hrefOri='aHR0cHM6Ly93d3cubXVzaWNicm9zaG9wLmNvbS9wcm9tb3Rpb24vZXZlbnRfdmlldz9ldmVudD0zNyZwYWdlPTEmc2VhcmNoTW9kZT1ldmVudF92aWV3JnBlcj00MCZzb3J0aW5nPXJhbmtpbmcmZmlsdGVyX2Rpc3BsYXk9bGF0dGljZQ==' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/main_middle_img_20220617_03.png" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbWlkZGxlX2ltZ18yMDIyMDYxN18wMy5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbWlkZGxlX2ltZ18yMDIyMDYxN18wMy5wbmc=' designElement='image' /></a></li>
      <li><a href="https://www.musicbroshop.com/promotion/event_view?event=38&page=1&searchMode=event_view&per=40&sorting=ranking&filter_display=lattice" target='_self' hrefOri='aHR0cHM6Ly93d3cubXVzaWNicm9zaG9wLmNvbS9wcm9tb3Rpb24vZXZlbnRfdmlldz9ldmVudD0zOCZwYWdlPTEmc2VhcmNoTW9kZT1ldmVudF92aWV3JnBlcj00MCZzb3J0aW5nPXJhbmtpbmcmZmlsdGVyX2Rpc3BsYXk9bGF0dGljZQ==' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/main_middle_img_20220617_04.png" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbWlkZGxlX2ltZ18yMDIyMDYxN18wNC5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbWlkZGxlX2ltZ18yMDIyMDYxN18wNC5wbmc=' designElement='image' /></a></li>
    </ul>
  </div>
</div>
 -->

<!-- //이미지 배너 (EVENT) -->






<!-- //NEW ARRIVALS -->


<!-- 슬라이드 배너 영역 (light_style_1_3) :: END -->
<div class="main_bnr_type2">
    <ul data-effect="scale">
        <li>
            <a href="https://www.musicbroshop.com/goods/catalog?page=1&searchMode=catalog&category=c00330001&per=40&sorting=ranking&filter_display=lattice" target='_self' hrefOri='aHR0cHM6Ly93d3cubXVzaWNicm9zaG9wLmNvbS9nb29kcy9jYXRhbG9nP3BhZ2U9MSZzZWFyY2hNb2RlPWNhdGFsb2cmY2F0ZWdvcnk9YzAwMzMwMDAxJnBlcj00MCZzb3J0aW5nPXJhbmtpbmcmZmlsdGVyX2Rpc3BsYXk9bGF0dGljZQ==' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/middle_music_banner01.png" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21pZGRsZV9tdXNpY19iYW5uZXIwMS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL21pZGRsZV9tdXNpY19iYW5uZXIwMS5wbmc=' designElement='image' /></a>
        </li>
        <li>
            <a href="https://www.musicbroshop.com/promotion/event_view?event=21&page=1&searchMode=event_view&per=40&sorting=ranking&filter_display=lattice" target='_self' hrefOri='aHR0cHM6Ly93d3cubXVzaWNicm9zaG9wLmNvbS9wcm9tb3Rpb24vZXZlbnRfdmlldz9ldmVudD0yMSZwYWdlPTEmc2VhcmNoTW9kZT1ldmVudF92aWV3JnBlcj00MCZzb3J0aW5nPXJhbmtpbmcmZmlsdGVyX2Rpc3BsYXk9bGF0dGljZQ==' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/middle_luxury_banner01.png" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21pZGRsZV9sdXh1cnlfYmFubmVyMDEucG5n' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL21pZGRsZV9sdXh1cnlfYmFubmVyMDEucG5n' designElement='image' /></a>
        </li>
    </ul>
</div>
<!-- //2단 이미지 배너 -->



<!-- =====================================================
  백그라운드 이미지로 처리되어 있습니다. 
  배너 이미지를 변경하려면 아래 경로( '[스킨폴더]/images/design_resp/' )의 이미지를 업로드하여 바꾸기 바랍니다.
  이미지 사이즈 : 1920 * 1500 (권장)
  ===================================================== -->
<div class="full_bnr" style="background-image:url('/data/skin/responsive_sports_sporti_gl/images/design_resp/bottom_img01.jpg'); display: none;">
    <ul class="text_wrap">          
        <li class="text1"><span designElement="text" textIndex="25"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >GLOBAL K-POP PLATFORM MUSICBRO</span></li>
        <li class="text2"><span designElement="text" textIndex="26"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >전 세계 K-POP 팬들을 위한 놀이터 뮤직브로 </span></li>
        <li class="sbtn"><a href="#none" designElement="text" textIndex="27"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" hrefOri='I25vbmU=' >read more</a></li>        
    </ul>
</div>
<!-- //패럴렉스 배너 -->

<div class="resp_wrap" style="display:none;"> 
  <div class="title_group1">
    <h3 class="title1"><a href="/board/?id=custom_bbs2" designElement="text" textIndex="28"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" hrefOri='L2JvYXJkLz9pZD1jdXN0b21fYmJzMg==' >NEW BRAND INTRODUCTION</a></h3>
  </div>
  <div id="mainStoryList" class="board_gallery" designElement='displaylastest' templatePath='bWFpbi9pbmRleC5odG1s'>
    <ul>
<?php if(is_array($TPL_R1=getBoardData('custom_bbs2','3',null,null,'17','60','ID','HID','IMG',array('orderby=gid asc','','rdate_s=','rdate_f=','auto_term=','image_w=406','image_h=')))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
      <li class="board_gallery_li">
        <div class="item_img_area">
          <a href="<?php echo $TPL_V1["wigetboardurl_view"]?>" hrefOri='ey53aWdldGJvYXJkdXJsX3ZpZXd9' ><img src="<?php echo $TPL_V1["filelist"]?>" alt="" designImgSrcOri='ey5maWxlbGlzdH0=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='ey5maWxlbGlzdH0=' designElement='image' /></a>
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
<?php }}else{?>
            <div class="no_data_area2">
                등록된 게시글이 없습니다.
            </div>
<?php }?>
    </ul>
  </div>    
</div>
<!-- //게시판 넣기 -->


<?php if($TPL_VAR["month"]){?>

<?php }else{?>
<?php }?>
<?php if($TPL_VAR["today"]){?>

<?php }else{?>
<?php }?>


<div class="main_bnr_type3 respBnrGon respBnrGon_num3_typeE">
  <ul data-effect="rotate_01">
    <li><a href="https://music-brother.com" target="_blank" hrefOri='aHR0cHM6Ly9tdXNpYy1icm90aGVyLmNvbQ==' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/main_bottom_banner01.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fYm90dG9tX2Jhbm5lcjAxLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fYm90dG9tX2Jhbm5lcjAxLnBuZw==' designElement='image' /></a></li>
    <li><a href="https://bravekongz.com/" target="_blank" hrefOri='aHR0cHM6Ly9icmF2ZWtvbmd6LmNvbS8=' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/new_bravekongz.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL25ld19icmF2ZWtvbmd6LnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL25ld19icmF2ZWtvbmd6LnBuZw==' designElement='image' /></a></li>
      <li><a href="https://bmpbrave.com/" target="_blank" hrefOri='aHR0cHM6Ly9ibXBicmF2ZS5jb20v' ><img src="/data/skin/responsive_sports_sporti_gl/images/design_resp/main_bottom_banner03.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fYm90dG9tX2Jhbm5lcjAzLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fYm90dG9tX2Jhbm5lcjAzLnBuZw==' designElement='image' /></a></li>
  </ul>
</div>
<!-- //3단 이미지 배너 -->

<div class="resp_wrap">
<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'&&$TPL_VAR["sns"]["ntalk_use"]=='Y'&&$TPL_VAR["sns"]["ntalk_use_mobile_main"]=='Y'){?>
  <!-- 네이버 톡톡 -->
  <div class="btn_talk_area">
    <button type="button" class="btn_talk v2" onclick="location.href='https://talk.naver.com/<?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?>#nafullscreen';"><span designElement="text" textIndex="29"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >쇼핑할땐</span> &nbsp;<img src="/data/skin/responsive_sports_sporti_gl/images/icon/icon_talk.png" class="talk_img" alt="네이버톡톡" designImgSrcOri='Li4vaW1hZ2VzL2ljb24vaWNvbl90YWxrLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2ljb24vaWNvbl90YWxrLnBuZw==' designElement='image' />&nbsp; <span designElement="text" textIndex="30"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21haW4vaW5kZXguaHRtbA==" >톡톡하세요</span></button>
  </div>
<?php }?>
</div>