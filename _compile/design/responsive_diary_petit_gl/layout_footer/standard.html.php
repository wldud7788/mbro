<?php /* Template_ 2.2.6 2021/06/16 17:02:25 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/layout_footer/standard.html 000019910 */  $this->include_("confirmLicenseLink","escrow_mark");
$TPL_bank_loop_1=empty($TPL_VAR["bank_loop"])||!is_array($TPL_VAR["bank_loop"])?0:count($TPL_VAR["bank_loop"]);
$TPL_dataRightQuicklist_1=empty($TPL_VAR["dataRightQuicklist"])||!is_array($TPL_VAR["dataRightQuicklist"])?0:count($TPL_VAR["dataRightQuicklist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ #LAYOUT_FOOTER @@
- 파일위치 : [스킨폴더]/layout_footer/standard.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<style>
    .ini_box{margin: 20px auto; max-width: 1260px; padding: 20px 40px 20px 40px; box-sizing: border-box; border-top: 1px solid #ddd;}
    .ini_img{ width: 22%; vertical-align: top;}
    .ini_text_box{display: inline-block; margin-left: 5px;}
    .ini_text_box>p{color: black;}
    .ini_text_box>a{cursor: pointer; padding:3px; background-color: #ADADAD; color: white; margin-top: 3px; border-radius: 5px; display: block; text-align: center;}
    .ini_text_box>a:hover{opacity: 0.7;}

    .ini_box>div{display: inline-block;}

    @media only screen and (max-width:1280px) {
        .ini_img{width: 24%; }
    }
    @media only screen and (max-width:1024px) {
        .ini_img{width: 24%; }
        .ini_box{padding:20px 10px;}
    }
    @media only screen and (max-width:800px) {
        .ini_img{width: 30%; }
    }
</style>
<div id="layout_footer" class="layout_footer">
    <div class="footer_a">
        <div class="resp_wrap">
           <!--  <ul class="menu1">
                <li class="fir">
                    <h4 class="title"><span designElement="text">고객센터</span></h4>
                    <ul>
                         <li><a href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>" class="phone" hrefOri='dGVsOntjb25maWdfYmFzaWMuY29tcGFueVBob25lfQ==' ><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a></li>
                        <li><p designElement="text">상담가능시간 : 오전 10:30 ~ 오후 06:30 / Sat, Sun, Holiday OFF</p></li>
<?php if($TPL_bank_loop_1){foreach($TPL_VAR["bank_loop"] as $TPL_V1){?>
                        <li><?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["account"]?></li>
<?php }}?>
                        <li><a class="pcolor" href="mailto:<?php echo $TPL_VAR["config_basic"]["companyEmail"]?>" hrefOri='bWFpbHRvOntjb25maWdfYmFzaWMuY29tcGFueUVtYWlsfQ==' >상담가능한 메일:<?php echo $TPL_VAR["config_basic"]["companyEmail"]?></a></li>
                    </ul>
                </li>
                <li class="sec">
          <h4 class="title"><span designElement="text">COMMUNITY</span></h4>
          <ul>
            <li><a href="/" designElement="text" hrefOri='Lw==' >Home</a></li>
            <li>
              <a href="/board/?id=notice" designElement="text" hrefOri='L2JvYXJkLz9pZD1ub3RpY2U=' >Notice</a>
            </li>
            <li>
              <a href="/board/?id=faq" designElement="text" hrefOri='L2JvYXJkLz9pZD1mYXE=' >FAQ</a>
            </li>
            <li>
              <a href="/board/?id=goods_qna" designElement="text" hrefOri='L2JvYXJkLz9pZD1nb29kc19xbmE=' >Q&amp;A</a>
            </li>
            <li>
              <a href="/board/?id=goods_review" designElement="text" hrefOri='L2JvYXJkLz9pZD1nb29kc19yZXZpZXc=' >Review</a>
            </li>
          </ul>
                </li>
                <li class="thr">
                    <h4 class="title"><span designElement="text">DELIVERY INFO</span></h4>
                    <ul>
                        <li><a href="#" designElement="text" target="_blank" hrefOri='Iw==' ></a></li>
                        <li><span designElement="text">반송주소: <?php if($TPL_VAR["config_basic"]["companyAddress_type"]=="street"){?><?php echo $TPL_VAR["config_basic"]["companyAddress_street"]?><?php }else{?><?php echo $TPL_VAR["config_basic"]["companyAddress"]?><?php }?> <?php echo $TPL_VAR["config_basic"]["companyAddressDetail"]?></span></li>
                    </ul>
                    <ul class="footer_info">
                        <li><a href="https://mubrothers.com" designElement="text" target="_blank" hrefOri='aHR0cHM6Ly9tdWJyb3RoZXJzLmNvbQ==' >공식홈페이지</a></li>
            <li><a href="/service/agreement" designElement="text" target="_self" hrefOri='L3NlcnZpY2UvYWdyZWVtZW50' >이용약관</a></li>
                        <li><a href="/service/privacy" designElement="text" target="_self" hrefOri='L3NlcnZpY2UvcHJpdmFjeQ==' ><strong>개인정보처리방침</strong></a></li>
            <li><a href="/service/guide" designElement="text" target="_self" hrefOri='L3NlcnZpY2UvZ3VpZGU=' >이용안내</a></li>
                    </ul>
                </li>
            </ul> -->
           
        </div>
    </div>

    <style type="text/css">
      .sns_wrap{margin-bottom: 10px;}
      .sns_wrap>span>a{margin-right: 15px;}

      .facebook_btn:hover i{color: #2545A7;}
      .insta_btn:hover i{color: #B12000;}
      .youtube_btn:hover i{color: red;}
    </style>


    <div class="footer_b">

        <div class="resp_wrap">

          <div id="gnbb" class="sns_wrap">
            <span>            
              <a href="https://facebook.com/bro.mu.37" target="_blank" alt="페이스북" title="페이스북" class="facebook_btn" hrefOri='aHR0cHM6Ly9mYWNlYm9vay5jb20vYnJvLm11LjM3' ><i class="fab fa-facebook"></i> Facebook</a>
              <a href="https://www.instagram.com/mubro_official/?fbclid=IwAR1P1NAPlpnJi6TDASJlhnPo2w1C5hiILZ26uXEsO93mfFOipBJncaN6ZS0" target="_blank" alt="인스타그램" title="인스타그램" class="insta_btn" hrefOri='aHR0cHM6Ly93d3cuaW5zdGFncmFtLmNvbS9tdWJyb19vZmZpY2lhbC8/ZmJjbGlkPUl3QVIxUDFOQVBscG5KaTZUREFTSmxoblBvMncxQzVoaUlMWjI2dVhFc085M21mRk9pcEJKbmNhTjZaUzA=' ><i class="fab fa-instagram" st=""></i> Instagram</a>
              <a href="https://www.youtube.com/channel/UCKK0nXpykY3sp6mIV106kfA?view_as=subscriber" target="_blank" alt="유트브" title="유트브" class="youtube_btn" hrefOri='aHR0cHM6Ly93d3cueW91dHViZS5jb20vY2hhbm5lbC9VQ0tLMG5YcHlrWTNzcDZtSVYxMDZrZkE/dmlld19hcz1zdWJzY3JpYmVy' ><i class="fab fa-youtube" st=""></i> Youtube</a>      
            </span>
          </div>

          <ul class="menu1">
              <li>
                  <span class="info_title" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=" >COMPANY</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyName"]?></span> <span class="info_title" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=" ></span><!-- <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["ceo"]?></span>-->
                  <span class="info_title" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=" >사업장 주소</span>
                  <span class="pcolor"><?php if($TPL_VAR["config_basic"]["companyAddress_type"]=="street"){?><?php echo $TPL_VAR["config_basic"]["companyAddress_street"]?><?php }else{?><?php echo $TPL_VAR["config_basic"]["companyAddress"]?><?php }?> <?php echo $TPL_VAR["config_basic"]["companyAddressDetail"]?></span>
              </li>
              <li>
                  <span class="info_title" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=" >대표번호/고객센터</span> <a href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>" class="pcolor" hrefOri='dGVsOntjb25maWdfYmFzaWMuY29tcGFueVBob25lfQ==' ><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a>
<?php if($TPL_VAR["config_basic"]["companyFax"]){?>
                  <span class="info_title" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=" >FAX</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyFax"]?></span>
<?php }?>
                  <span class="info_title" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=" >통신판매업신고번호</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["businessLicense"]?> <?php echo confirmLicenseLink("[사업자정보확인]")?></span> <span class="info_title" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=" >통신판매업신고번호</span>
                  <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["mailsellingLicense"]?></span>
              </li>
              <li>
                  <span class="info_title" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=" >대표이사</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["member_info_manager"]?> (<a href="mailto:<?php echo $TPL_VAR["config_basic"]["companyEmail"]?>" hrefOri='bWFpbHRvOntjb25maWdfYmFzaWMuY29tcGFueUVtYWlsfQ==' ><?php echo $TPL_VAR["config_basic"]["companyEmail"]?></a>)</span>
                  <span class="info_title" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=" >HOSTING PROVIDER</span>
                  <span class="pcolor">(주)가비아씨엔에스</span>
              </li>
          </ul>
          <p class="copyright" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=" >COPYRIGHT (c) <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyName"]?></span> ALL RIGHTS RESERVED.</p>
          <ul class="footer_info">
              <li><a href="https://mubrothers.com" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw="  target="_blank" hrefOri='aHR0cHM6Ly9tdWJyb3RoZXJzLmNvbQ==' >공식홈페이지</a></li>
              <li><a href="/service/agreement" designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw="  target="_self" hrefOri='L3NlcnZpY2UvYWdyZWVtZW50' >이용약관</a></li>
              <li><a href="/service/privacy" designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw="  target="_self" hrefOri='L3NlcnZpY2UvcHJpdmFjeQ==' ><strong>개인정보처리방침</strong></a></li>
              <li><a href="/service/guide" designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw="  target="_self" hrefOri='L3NlcnZpY2UvZ3VpZGU=' >이용안내</a></li>
              <li><a href="https://musicbroshop.com/page/index?tpl=etc%2Fparter_page.html" designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw="  target="_self" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL3BhZ2UvaW5kZXg/dHBsPWV0YyUyRnBhcnRlcl9wYWdlLmh0bWw=' >입점문의</a></li>
          </ul>
        </div>

        <div class="ini_box">
            <div>
                <img class="ini_img" src='/data/skin/responsive_diary_petit_gl/images/escrow_74x74_color.png' border="0" alt="클릭하시면 이니시스 결제시스템의 유효성을 확인하실 수 있습니다." designImgSrcOri='Li4vaW1hZ2VzL2VzY3Jvd183NHg3NF9jb2xvci5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9lc2Nyb3dfNzR4NzRfY29sb3IucG5n' designElement='image' >
                <div class="ini_text_box">
                    <p>KG이니시스 구매안전 서비스</p>
                    <a Onclick=javascript:window.open("https://mark.inicis.com/mark/escrow_popup.php?mid=ESGBmusicb","mark","scrollbars=no,resizable=no,width=565,height=683");>서비스 가입사실 확인 +</a>
                </div>
            </div>

            <div>
            	<?php echo escrow_mark( 60)?>

            </div>

             <!-- <div class="escrow"></div> -->
        </div>
        
    </div>
    
   
</div>

<?php if(preg_match('/goods\/view/',$_SERVER["REQUEST_URI"])){?>
<?php if($TPL_VAR["navercheckout_tpl"]){?>
<div class="pcHideMoShow" style="height: 117px;">&nbsp;</div>
<?php }?>
<div class="pcHideMoShow" style="height: 80px;">&nbsp;</div>
<?php }?>
<!-- 하단영역 : 끝 -->

<!-- 플로팅 - BACK/TOP(대쉬보드) -->
<div id="floating_over">
    <a href="javascript:history.back();" class="ico_floating_back" title="뒤로 가기" hrefOri='amF2YXNjcmlwdDpoaXN0b3J5LmJhY2soKTs=' ></a>
    <a href="javascript:history.forward();" class="ico_floating_foward" title="앞으로 가기" hrefOri='amF2YXNjcmlwdDpoaXN0b3J5LmZvcndhcmQoKTs=' ></a>
    <a href="#layout_header" class="ico_floating_top" title="위로 가기" hrefOri='I2xheW91dF9oZWFkZXI=' ></a>
<?php if((preg_match('/main\/index/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/catalog/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/brand/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/location/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/search/',$_SERVER["REQUEST_URI"])||preg_match('/bigdata\/catalog/',$_SERVER["REQUEST_URI"]))&&$TPL_VAR["dataRightQuicklist"]&&!preg_match('/goods\/view/',$_SERVER["REQUEST_URI"])){?>
<?php if($TPL_VAR["push_count_today_images"]){?><a href="javascript:;" class="ico_floating_recently" hrefOri='amF2YXNjcmlwdDo7' ><span designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=" >최근본</span><br /><img src="<?php echo $TPL_VAR["push_count_today_images"]?>" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage.gif'" designImgSrcOri='e3B1c2hfY291bnRfdG9kYXlfaW1hZ2VzfQ==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=' designImgSrc='e3B1c2hfY291bnRfdG9kYXlfaW1hZ2VzfQ==' designElement='image' /></a><?php }?>
<?php }?>

    <!-- 최근 본 상품(LAYER) -->
<?php if((preg_match('/main\/index/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/catalog/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/brand/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/location/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/search/',$_SERVER["REQUEST_URI"])||preg_match('/bigdata\/catalog/',$_SERVER["REQUEST_URI"]))&&$TPL_VAR["dataRightQuicklist"]){?>
    <div id="recently_popup">
        <div class="recently_popup">
            <h1>최근 본 상품</h1>
            <div class="recently_thumb">
                <div id="recently_slide_bottom" style="width: 285px; min-height: 80px;">
                    <div class="thumb">
<?php if($TPL_VAR["dataRightQuicklist"]){?>
                        <ul>
<?php if($TPL_dataRightQuicklist_1){$TPL_I1=-1;foreach($TPL_VAR["dataRightQuicklist"] as $TPL_V1){$TPL_I1++;?>
<?php if(($TPL_I1< 40)){?> <?php if(($TPL_I1&&($TPL_I1% 4)== 0)){?>
                        </ul>
                        <ul>
<?php }?>
                            <li>
                                <a href="../goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" class="right_quick_goods" hrefOri='Li4vZ29vZHMvdmlldz9ubz17Lmdvb2RzX3NlcX0=' ><img src="<?php echo $TPL_V1["image"]?>" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage_list.gif'" alt="<?php echo $TPL_V1["goods_name"]?>" designImgSrcOri='ey5pbWFnZX0=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9sYXlvdXRfZm9vdGVyL3N0YW5kYXJkLmh0bWw=' designImgSrc='ey5pbWFnZX0=' designElement='image' /></a
><a href="javascript:rightDeleteItem('mobile_bottom_item_recent', '<?php echo $TPL_V1["goods_seq"]?>',$(this))" class="btn_delete cover" hrefOri='amF2YXNjcmlwdDpyaWdodERlbGV0ZUl0ZW0o' >삭제</a>
                            </li>
<?php }?>
<?php }}?>
                        </ul>
<?php }else{?>
                        <h2>최근 본 상품이 없습니다.</h2>
<?php }?>
                    </div>
                </div>
                <div class="recently_page">
                    <a href="javascript:;" class="btn_page cover" hrefOri='amF2YXNjcmlwdDo7' >선택</a>
                </div>
            </div>
            <a href="javascript:;" class="btn_close" hrefOri='amF2YXNjcmlwdDo7' >모두보기</a>
        </div>
        <div class="recently_bg"></div>
    </div>
<?php if($TPL_dataRightQuicklist_1> 3){?>
    <script type="text/javascript">
        <!--
          $(function(){
            /* 최근 본 상품 - LAYER(슬라이드) */
            $("#recently_slide_bottom").touchSlider({
              flexible:true, roll:true, paging:$("#recently_slide_bottom").next().find(".btn_page"),
              initComplete:function(e){$("#recently_slide_bottom").next().find(".btn_page").each(function(i, el){$(this).text("page " + (i+1));});},
              counter:function(e){$("#recently_slide_bottom").next().find(".btn_page").removeClass("on").eq(e.current-1).addClass("on");}
            });
          });
        //-->
    </script>
<?php }?>
<?php }?>
</div>
<!-- //플로팅 - BACK/TOP(대쉬보드) -->

<script type="text/javascript">
    $(function() {
      /* 반응형 슬라이드 배너 관련( 절대 삭제 금지 ) */
<?php if($TPL_VAR["settle"]){?>
        $('.slider_before_loading').remove();
<?php }else{?>
        $('.slider_before_loading').removeClass('slider_before_loading');
<?php }?>

      // 상품 색상 코드값 디자인( old 상품정보 - new 상품정보 개발 완료후 삭제 요망 )
      /*
      if ( $('.goods_color_area').length > 0 ) {
        $('.goods_color_area .color').filter(function() {
          return ( $(this).css('color') == 'rgb(255, 255, 255)' );
        }).addClass('border');
      }
      */
      // 상품 색상 코드값 디자인( new 상품정보 )
      if ( $('.displaY_color_option').length > 0 ) {
        $('.displaY_color_option .areA').filter(function() {
          return ( $(this).css('background-color') == 'rgb(255, 255, 255)' );
        }).addClass('border');
      }

      $( window ).on('resize', function() {
        if ( window.innerWidth != WINDOWWIDTH ) {
          setTimeout(function(){ WINDOWWIDTH = window.innerWidth; }, 10);
        }
      });
    });

    /*######################## 17.12.19 gcs yjy : 앱 처리(fb 로그아웃) s */
    function logoutfb(){
      FB.getLoginStatus(logoutfb_process);
    }
    function logoutfb_process(){
      FB.api('/me', function(response) {

        FB.logout(function(response) {

        });

        isLogin = false;
<?php if(defined('__ISUSER__')){?>
        loadingStart("body",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});
          $.ajax({
          'url' : '../sns_process/facebooklogout',
          'dataType': 'json',
          'success': function(res) {

            if(res.result == true){
              alert("로그아웃되었습니다.");

<?php if($TPL_VAR["mobileapp"]=='y'){?>
<?php if($TPL_VAR["m_device"]=='iphone'){?>
            window.webkit.messageHandlers.CSharp.postMessage("Logout?");
    //        window.webkit.messageHandlers.CSharp.postMessage('GoHome');
<?php }else{?>
            CSharp.postMessage("Logout?");
    //        CSharp.postMessage('GoHome');
<?php }?>
<?php }?>


            }else{
              document.location.reload();
            }
          }
          });
<?php }?>
        if (fbId != "")  initializeFbTokenValues();
        if (fbUid != "") initializeFbUserValues();

        return false;
      });
    }
    /*######################## 17.12.19 gcs yjy : 앱 처리(fb 로그아웃) e */
</script>