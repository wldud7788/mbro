<?php /* Template_ 2.2.6 2020/12/30 16:37:14 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_2/layout_header/standard.html 000032120 */  $this->include_("showDesignLightPopup","showCategoryLightNavigation","showSearchRecent","dataGoodsTodayLight","showTopPromotion");
$TPL_env_list_1=empty($TPL_VAR["env_list"])||!is_array($TPL_VAR["env_list"])?0:count($TPL_VAR["env_list"]);?>
<link href="https://fonts.googleapis.com/css2?family=Sunflower:wght@300;500;700&display=swap" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet"> <!--CDN 링크 -->
<meta name="theme-color" content="#000000">
<meta name="naver-site-verification" content="a639f9e475d99362481c5d607d701ab0db52014f" />
<link rel="canonical" href="https://musicbroshop.com">
<meta name="url" content="https://musicbroshop.com">
<meta property="og:url" content="https://musicbroshop.com">
<meta property="og:description" content="뮤직브로샵 만의 다양한 상품, 즐거운 쇼핑">




<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ #LAYOUT_HEADER @@
- 파일위치 : [스킨폴더]/layout_header/standard.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<!-- <div style="display:none;"><?php echo showDesignLightPopup( 1)?></div> -->
<style type="text/css">
  .musicbro_btn{color: white;font-size: 18px;font-weight: bold;display: inline-block; padding-bottom: 10px;}
  .musicbro_btn:hover{text-decoration: underline;}
</style>

<script>
function mo_chk(){

  var os;

  var mobile = (/iphone|ipad|ipod|android/i.test(navigator.userAgent.toLowerCase()));  

  if (mobile) {
    var userAgent = navigator.userAgent.toLowerCase();
    if (userAgent.search("android") > -1){
      return os = "android";
    }else if ((userAgent.search("iphone") > -1) || (userAgent.search("ipod") > -1) || (userAgent.search("ipad") > -1)){
      return os = "ios";
    }else{
      return os = "otehr";
    }

  } else {
    return os = "pc";
  }
}


function action_app_instagram(android_url , ios_url , ios_appstore_url){
  var result_mo_chk = mo_chk();

  if(result_mo_chk!="pc"){
    if(result_mo_chk == "ios"){

      setTimeout( function() {
        window.open(ios_appstore_url);
      }, 1500);

      location.href = ios_url;
    }else{
      location.href = android_url;
    }
  }
}
</script>


<!-- 스타 브랜드대상 아이콘 부분 -->
<style type="text/css">
  .brand_gif_box{position: fixed;top: 60%;left: 3%; width: 185px; z-index: 99;}
  .brand_gif_box>img{width: 100%;}

  @media only screen and (max-width: 1300px){
        .brand_gif_box{left:auto; bottom:30%; top:auto; width:85px; right:1%;}
  }
</style>

<div class="brand_gif_box">
  <img src="/data/popup/brand.gif" alt="브랜드대상" title="브랜드대상" designImgSrcOri='L2RhdGEvcG9wdXAvYnJhbmQuZ2lm' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==' designImgSrc='L2RhdGEvcG9wdXAvYnJhbmQuZ2lm' designElement='image' >
</div>
<!-- 스타 브랜드대상 아이콘 부분 -->

<!-- 왼쪽 사이드바에 스토어 부분 -->
<style type="text/css">
  .app_down_wrap{position: fixed;right: 10px; top:45%; border:1px solid #ddd; width: 90px;z-index: 99; background-color: white;}
  .app_down_wrap .wrap_aside{background-color: #aaa; padding:0;}
  .app_down_wrap .wrap_aside h3{text-align: center; color: white;}
  .app_down_wrap .app_down_box>div>a>p {margin-top: 5px;}
  .app_down_wrap .app_down_box>div>a>img{width: 50%;}
  .app_down_box{border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding:20px 5px; color: #999; text-align: center;}
  .app_down_box>div:nth-of-type(1){margin-bottom: 20px;}
  .app_down_box>div>a{transition: all 0.3s;}
  .app_down_box>div>a:hover{opacity: 0.5;}
  .google_icon, .apple_icon{font-size: 20px;}
  .margin_bottom_0{margin-bottom: 0 !important;}

  @media only screen and (max-width: 1200px){
    .app_down_wrap{width: 70px; top: auto; bottom: 7%;}
  }
</style>

<div class="app_down_wrap">

  <div class="wrap_aside" >
    <h3>음원 스토어</h3>
  </div>
  <div class="app_down_box">
    <div>
      <a href="https://play.google.com/store/apps/details?id=com.musicbrother.app" target="blank" hrefOri='aHR0cHM6Ly9wbGF5Lmdvb2dsZS5jb20vc3RvcmUvYXBwcy9kZXRhaWxzP2lkPWNvbS5tdXNpY2Jyb3RoZXIuYXBw' >
        <i class="fab fa-google-play google_icon"></i>
        <p>구글 스토어</p>
      </a>
    </div>
    <div>
      <a href="https://apps.apple.com/us/app/%EB%AE%A4%EC%A7%81%EB%B8%8C%EB%A1%9C-musicbro/id1537070798" target="blank" hrefOri='aHR0cHM6Ly9hcHBzLmFwcGxlLmNvbS91cy9hcHAvJUVCJUFFJUE0JUVDJUE3JTgxJUVCJUI4JThDJUVCJUExJTlDLW11c2ljYnJvL2lkMTUzNzA3MDc5OA==' >
        <i class="fab fa-app-store-ios apple_icon"></i>
        <p>애플 스토어</p>
      </a>
    </div>
  </div>

<!--   <div class="wrap_aside">
    <h3>BMP코인 환전</h3>
  </div>
  <div class="app_down_box">
    <div class="margin_bottom_0">
      <a href="https://play.google.com/store/apps/details?id=com.musicbrother.app" target="blank" hrefOri='aHR0cHM6Ly9wbGF5Lmdvb2dsZS5jb20vc3RvcmUvYXBwcy9kZXRhaWxzP2lkPWNvbS5tdXNpY2Jyb3RoZXIuYXBw' >
        <img src="/data/skin/responsive_diary_petit_gl_2/images/bmp_icon2.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2JtcF9pY29uMi5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzIvaW1hZ2VzL2JtcF9pY29uMi5wbmc=' designElement='image' >
        <p>BMP코인 환전</p>
      </a>
    </div>
   
  </div> -->

</div>

<!-- 왼쪽 사이드바에 스토어 부분 -->



<div class="designPopupBand hide designElement" popupstyle="band" designelement="popup" templatepath="goods/catalog.html" popupseq="1" style="background-color: rgb(255, 206, 0); display: block;">
    <div class="designPopupBody">
        <a href="/main/index" target="_self" hrefOri='L21haW4vaW5kZXg=' >
            <img src="/data/popup/최상단-띠배너_(1).jpg" designImgSrcOri='L2RhdGEvcG9wdXAv7LWc7IOB64uoLeudoOuwsOuEiF8oMSkuanBn' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==' designImgSrc='L2RhdGEvcG9wdXAv7LWc7IOB64uoLeudoOuwsOuEiF8oMSkuanBn' designElement='image' >
        </a>
        <a href="https://music-brother.com" class="musicbro_btn" target="_blank" hrefOri='aHR0cHM6Ly9tdXNpYy1icm90aGVyLmNvbQ==' >뮤직브로 바로가기</a>
    </div>
    <div class="designPopupClose" style="display: none;">
        <img src="/data/icon/common/etc/btn_tbanner_close.png" alt="banner close" designImgSrcOri='L2RhdGEvaWNvbi9jb21tb24vZXRjL2J0bl90YmFubmVyX2Nsb3NlLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==' designImgSrc='L2RhdGEvaWNvbi9jb21tb24vZXRjL2J0bl90YmFubmVyX2Nsb3NlLnBuZw==' designElement='image' >
    </div>
</div>

<script type="text/javascript">
  if (isMobile()) {
    // 모바일이면 실행될 코드 들어가는 곳
    $(".designPopupBody .musicbro_btn").attr("href","intent://instagram.com/#Intent;package=com.instagram.android;scheme=https;end");
} else {
    // 모바일이 아니면 실행될 코드 들어가는 곳
      $(".designPopupBody .musicbro_btn").attr("href","intent://instagram.com/#Intent;package=com.instagram.android;scheme=https;end");
}
</script>
<!-- //띠배너/팝업 -->

<!-- 상단영역 : 시작 -->
<div id="layout_header" class="layout_header">
  <div class="util_wrap">
    <div class="resp_wrap">
      <!-- language -->
      <div class="language hide">
<?php if($TPL_env_list_1){foreach($TPL_VAR["env_list"] as $TPL_V1){?>
<?php if(($TPL_VAR["this_admin_env"]["language"]==$TPL_V1["language"])&&($TPL_V1["this_admin"]=='y')){?>
        <a class="select_list" id="select_main" href="http://<?php echo $TPL_V1["domain"]?>" hrefOri='aHR0cDovL3suZG9tYWlufQ==' >
          <span class="language_country_img language_country_img_<?php echo $TPL_V1["language"]?>"></span>
          <?php echo $TPL_V1["lang_list"]?>

          <span class="sel_arrow"></span>
        </a>
<?php }?>
<?php }}?>
        <ul class="optionSub" style="position: relative; display: none;">
<?php if($TPL_env_list_1){foreach($TPL_VAR["env_list"] as $TPL_V1){?>
<?php if(($TPL_VAR["this_admin_env"]["language"]!=$TPL_V1["language"])&&($TPL_V1["this_admin"]!='y')){?>
          <li>
            <a class="select_list" href="http://<?php echo $TPL_V1["domain"]?>" hrefOri='aHR0cDovL3suZG9tYWlufQ==' >
              <span class="language_country_img_<?php echo $TPL_V1["language"]?>"></span>
              <?php echo $TPL_V1["lang_list"]?>

            </a>
          </li>
<?php }?>
<?php }}?>
        </ul>
      </div>

        <ul class="util_wrap_menu">
        <li>
          <a designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA=="  href="/goods/best" hrefOri='L2dvb2RzL2Jlc3Q=' ><em>Best</em></a>
        </li>
        <li>
          <a designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA=="  href="/goods/new_arrivals" hrefOri='L2dvb2RzL25ld19hcnJpdmFscw==' ><em>New</em></a>
        </li>
        <li style="display:none;">
          <a designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA=="  href="/goods/brand_main" hrefOri='L2dvb2RzL2JyYW5kX21haW4=' ><em>Brands</em></a>
        </li>
        <li>
          <a designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA=="  href="/promotion/event" hrefOri='L3Byb21vdGlvbi9ldmVudA==' ><em>Event</em></a>
        </li>
        <li style="display:none;">
          <a designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA=="  href="/board/?id=custom_bbs2" hrefOri='L2JvYXJkLz9pZD1jdXN0b21fYmJzMg==' ><em>Story</em></a>
        </li>
      </ul>

      <ul class="util_wrap_menu2">
<?php if($TPL_VAR["userInfo"]["member_seq"]){?>
        <li><?php if($TPL_VAR["userInfo"]["snsfacebookcon"]&&$TPL_VAR["fbuser"]){?><a href="javascript:void(0);" onclick="FB.logout(function(response) {logout();});return false;" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='amF2YXNjcmlwdDp2b2lkKDApOw==' >Logout</a><?php }else{?><a href="/login_process/logout" target="actionFrame" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L2xvZ2luX3Byb2Nlc3MvbG9nb3V0' >Logout</a><?php }?></li>
<?php }elseif($TPL_VAR["sess_order"]){?>
        <li><a href="/login_process/logout" target="actionFrame" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L2xvZ2luX3Byb2Nlc3MvbG9nb3V0' >Logout</a></li>
<?php }else{?>
        <li><a href="/member/login" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L21lbWJlci9sb2dpbg==' >Login</a></li>
        <li>
          <a href="/member/agreement" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L21lbWJlci9hZ3JlZW1lbnQ=' >Join</a>
<?php if($TPL_VAR["member_emoneyapp"]["emoneyJoin"]){?>
          <div class="benefit">
            <span class="arrow">▲</span>
            + <?php echo number_format($TPL_VAR["member_emoneyapp"]["emoneyJoin"])?>

          </div>
<?php }?>
        </li>
<?php }?>
        <li><a href="/mypage" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L215cGFnZQ==' >MyPage</a></li>
        <li><a href="/mypage/order_catalog" designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L215cGFnZS9vcmRlcl9jYXRhbG9n' >Order</a></li>
        <li class="respCartArea">
          <a href="/order/cart" hrefOri='L29yZGVyL2NhcnQ=' ><span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==" >Cart</span><span>(<?php echo $TPL_VAR["push_count_cart"]?>)</span></a>
        </li>
        <li><a href="/service/cs" designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L3NlcnZpY2UvY3M=' >CS Center</a></li>
      </ul>
    </div>
  </div>

  <div class="logo_wrap">
    <div class="resp_wrap">
      <!-- logo -->
      <h1 class="logo_area">
        <a href="/main/index" target="_self" hrefOri='L21haW4vaW5kZXg=' ><img src="/data/skin/responsive_diary_petit_gl_2/images/design_resp/top_logo.jpg" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL3RvcF9sb2dvLmpwZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzIvaW1hZ2VzL2Rlc2lnbl9yZXNwL3RvcF9sb2dvLmpwZw==' designElement='image' /></a>
      </h1>

      <!-- 카테고리 메뉴 -->
      <div id="cateSwiper" class="nav_wrap">
        <div class="resp_wrap">
          <div class="nav_category_area">
            <div class="designCategoryNavigation">
              <ul class="respCategoryList">
                <!-- 카테고리 네비게이션. 파일위치 : [스킨폴더]/_modules/category/category_gnb.html -->
                <!-- 참고) 브랜드: showBrandLightNavigation(), 지역: showLocationLightNavigation() -->
                <?php echo showCategoryLightNavigation()?>

                <!-- //카테고리 네비게이션 -->
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- +++++++++++++++++++++++++ 검색 리뉴얼 +++++++++++++++++++++++++++++ -->
      <div id="searchModule" class="resp_top_search">
        <a href="javascript:void(0)" id="btnSearchV2" class="btn_search_open" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >검색</a>
        <div id="searchVer2" class="search_ver2">
          <div class="search_new">
            <!-- ------- 검색 입력 ------- -->
            <form name="topSearchForm" id="topSearchForm" action="/goods/search">
              <div class="input_area">
                <div class="cont">
                  <label class="search_box"><input type="text" name="search_text" id="searchVer2InputBox" class="search_ver2_input_box" placeholder="Search" autocomplete="off" /></label>
                  <button type="submit" class="search"></button>
                  <button type="button" class="close searchModuleClose"></button>
                </div>
              </div>
            </form>
            <!-- ------- 페이지별 기본 검색 ------- -->
<?php if($TPL_VAR["auto_search_use"]=='y'){?>
            <script type="text/javascript">
              $("form#topSearchForm input[name='search_text']").attr('placeholder', '<?php echo $TPL_VAR["auto_search_text"]?>');
              $("form#topSearchForm").submit(function(event){
              	if(!$("form#topSearchForm input[name='search_text']").val()){
<?php if($TPL_VAR["auto_search_target"]!='_self'){?>
              		var openNewWindow = window.open("about:blank");
<?php }?>
<?php if($TPL_VAR["auto_search_type"]=='direct'&&$TPL_VAR["auto_search_target"]=='_self'){?>
              		document.location.href="<?php echo $TPL_VAR["auto_search_link"]?>";
<?php }elseif($TPL_VAR["auto_search_type"]=='direct'&&$TPL_VAR["auto_search_target"]!='_self'){?>
              		openNewWindow.document.location.href="<?php echo $TPL_VAR["auto_search_link"]?>";
<?php }elseif($TPL_VAR["auto_search_type"]!='direct'&&$TPL_VAR["auto_search_target"]=='_self'){?>
              		document.location.href="/goods/search?search_text=<?php echo urlencode($TPL_VAR["auto_search_link"])?>";
<?php }elseif($TPL_VAR["auto_search_type"]!='direct'&&$TPL_VAR["auto_search_target"]!='_self'){?>
              		openNewWindow.document.location.href="/goods/search?search_text=<?php echo urlencode($TPL_VAR["auto_search_link"])?>";
<?php }?>
              		return false;
              	}
              });
            </script>
<?php }?>
            <!-- ------- //검색 입력 ------- -->
            <div class="contetns_area" style="display: none;">
              <!-- ------- 최근 검색어, 최근본 상품 ------- -->
              <div id="recentArea" class="recent_area">
                <ul class="tab_btns">
                  <li class="on"><a href="#recent-searched-list" hrefOri='I3JlY2VudC1zZWFyY2hlZC1saXN0' >최근 검색어</a></li>
                  <li><a href="#recent-item-list" hrefOri='I3JlY2VudC1pdGVtLWxpc3Q=' >최근본 상품</a></li>
                </ul>
                <!-- 최근 검색어 -->
                <div id="recent-searched-list" class="tab_contents">
                  <ul id="recentSearchedList" class="searching_list">
<?php if(is_array($TPL_R1=showSearchRecent())&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["recent_seq"]){?>
                    <li class="recent_search_item">
                      <a class="searched_item" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ><?php echo $TPL_V1["keyword"]?></a>
                      <a class="searching_item_close" href="javascript:void(0)" data-value="<?php echo $TPL_V1["recent_seq"]?>" onclick="searchRecentRemove(this)" title="삭제" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >삭제</a>
                    </li>
<?php }else{?>
                    <li class="recent_search_item popular_search_item">
                      <a class="searched_item" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ><?php echo $TPL_V1["keyword"]?></a>
                    </li>
<?php }?>
<?php }}?>
                    <li class="no_data">최근검색어가 없습니다.</li>
                  </ul>
                  <div id="recentSearchedGuide" class="no_data" style="display: none;">최근 검색어 저장 기능이 꺼져있습니다.</div>
                  <ul class="tab_foot_menu">
                    <li class="menu_item">
                      <a href="javascript:void(0)" data-value="all" onclick="searchRecentRemove(this)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >전체삭제</a>
                      <a class="btnRecentAuto off" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >자동저장 끄기</a>
                      <a class="btnRecentAuto on" href="javascript:void(0)" style="display: none;" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >자동저장 <span class="importcolor">켜기</span></a>
                    </li>
                    <li class="search_close searchModuleClose"><a href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >닫기</a></li>
                  </ul>
                </div>
                <!-- //최근 검색어 -->
                <!-- 최근본 상품 -->
                <div id="recent-item-list" class="tab_contents" style="display: none;">
                  <ul class="recent_item_list">
<?php if(is_array($TPL_R1=dataGoodsTodayLight('list', 12))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                    <li class="recent_item" data-value="<?php echo $TPL_V1["goods_seq"]?>">
                      <a class="item_link" href="../goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" hrefOri='Li4vZ29vZHMvdmlldz9ubz17Lmdvb2RzX3NlcX0=' ><img class="item_img" src="<?php echo $TPL_V1["image"]?>" alt="썸네일(스크롤)" onerror="this.src='/data/icon/goods/error/noimage_list.gif';" designImgSrcOri='ey5pbWFnZX0=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL2xheW91dF9oZWFkZXIvc3RhbmRhcmQuaHRtbA==' designImgSrc='ey5pbWFnZX0=' designElement='image' /></a>
                      <a class="item_delete" href="javascript:void(0)" title="삭제" onclick="todayViewRemove(this);" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >아이템 삭제</a>
                    </li>
<?php }}?>
                    <li class="no_data" style="display: none;">최근본 상품이 없습니다.</li>
                  </ul>
                  <ul class="tab_foot_menu">
                    <li class="swiper_guide">
                      <span class="to_left">&lt;</span>
                      <span class="to_right">&gt;</span>
                    </li>
                    <li class="search_close searchModuleClose"><a href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >닫기</a></li>
                  </ul>
                </div>
                <!-- //최근본 상품 -->
              </div>
              <!-- ------- //최근 검색어, 최근본 상품 ------- -->

              <!-- ------- 검색어 자동완성 ------- -->
              <div id="autoCompleteArea" class="autocomplete_area" style="display: none;">
                <!-- 검색어 자동완성 - 검색어 -->
                <div class="autocomplete_searching">
                  <ul id="autoCompleteList" class="searching_list"></ul>

                  <div id="autoCompleteGuide" class="no_data" style="display: none;">자동완성 기능이 꺼져있습니다</div>

                  <ul class="tab_foot_menu">
                    <li class="menu_item">
                      <a class="btnAutoComplete off" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >자동완성 끄기</a>
                      <a class="btnAutoComplete on" href="javascript:void(0)" style="display: none;" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >자동완성 <span class="importcolor">켜기</span></a>
                    </li>
                    <li class="search_close searchModuleClose"><a href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >닫기</a></li>
                  </ul>
                </div>
                <!-- //검색어 자동완성 - 검색어 -->

                <!-- 검색어 자동완성 - 배너( 추천상품 ) -->
                <div id="autoCompleteBanner" class="autocomplete_banner">
                  <h5 class="title">추천 상품</h5>
                  <ul id="autocompleteBannerList" class="banner_list"></ul>
                </div>
                <!-- //검색어 자동완성 - 배너( 추천상품 ) -->
              </div>
              <!-- ------- //검색어 자동완성 ------- -->
            </div>
          </div>
        </div>
      </div>
      <!-- +++++++++++++++++++++++++ //검색 리뉴얼 +++++++++++++++++++++++++++++ -->

      <!-- 햄버거 버튼 -->
      <div class="resp_top_hamburger">
        <a href="#category" hrefOri='I2NhdGVnb3J5' ><b>aside menu</b></a>
      </div>
    </div>
  </div>
  <!-- //로고 영역 -->

<?php if(showTopPromotion(null,$TPL_VAR["layout_config"]["width"])){?>
  <div class="resp_wrap">
    <ul id="resp_promo">
      <?php echo showTopPromotion(null,$TPL_VAR["layout_config"]["width"])?>

    </ul>
  </div>
  <script type="text/javascript">
    $(function () {
      $("#resp_promo").slick({
        autoplay: true,
        speed: 800,
        autoplaySpeed: 8000,
      });
    });
  </script>
<?php }?>

  <!-- 카테고리 전체 네비게이션 팝업 START -->
  <div id="categoryAll_wrap" class="categoryAll_wrap" style="display: none;">
    <div class="categoryAllContainer"></div>
  </div>
  <!-- 카테고리 전체 네비게이션 팝업 END -->

  <!-- 브랜드 전체 네비게이션 팝업 START -->
  <div id="brandAll_wrap" class="brandAll_wrap" style="display: none;">
    <div class="brandAllContainer"></div>
  </div>
  <!-- 브랜드 전체 네비게이션 팝업 END -->

  <!-- 지역 전체 네비게이션 팝업 START -->
  <div id="locationAll_wrap" class="locationAll_wrap" style="display: none;">
    <div class="locationAllContainer"></div>
  </div>
  <!-- 지역 전체 네비게이션 팝업 END -->
</div>
<!-- 상단영역 : 끝 -->

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl_2/common/search_ver2_ready.js"></script>
<!-- 반응형 관련 프론트 js : 검색, 자동검색어 최근본상품 -->
<script type="text/javascript">
  var resp_loc_top;
  function flyingTitleBar() {
  	//var resp_loc_top = $("#layout_header .logo_wrap").offset().top;
  	var obj = $("#layout_header .logo_wrap");
  	var obj_H = $("#layout_header .logo_wrap").outerHeight();
  	$(document).scroll(function(){
  		//alert( resp_loc_top );
  		if ( ( $('.designPopupBand').is(':hidden') || $('.designPopupBand').length < 1 )  && window.innerWidth < 480 ) {
  			if ( $("#layout_header .util_wrap").is(':hidden') ) {
  				resp_loc_top = 0;
  			} else {
  				resp_loc_top = $("#layout_header .util_wrap").outerHeight(); // 띠배너 클로즈시 보정
  			}
  		}
  		if(resp_loc_top < $(document).scrollTop() && window.innerWidth < 480 ){
<?php if(preg_match('/goods\/view/',$_SERVER["REQUEST_URI"])){?>
<?php }else{?>
  				obj.addClass("flying");
  				if ( !$('#gonBox').length ) {
  					$('#layout_header .logo_wrap').before('<div id="gonBox"></div>');
  					$('#gonBox').css( 'height', obj_H + 'px' );
  				}
<?php }?>
  		} else {
  			obj.removeClass('flying');
  			if ( $('#gonBox').length ) {
  				$('#gonBox').remove();
  			}
  		}
  	});
  }

  $(function(){
  	// 텍스트 수정기능을 통해 소스에 박혀있는 카테고리 삭제시 --> 항목 삭제
  	$('#cateSwiper .custom_nav_link').each(function(e) {
  		if ( $(this).find('a').text() == '' ) {
  			$(this).remove();
  		}
  	});

  	/* 카테고리 활성화 */
  	var url2, cateIndex;
  	$('#layout_header .designCategoryNavigation .respCategoryList>li').each(function() {
  		url2 = $(this).find('a').attr('href');
  		if ( REQURL == url2 ) {
  			cateIndex = $(this).index();
  		} else if ( REQURL != url2 && REQURL.substr( 0, REQURL.length-4 ) == url2 ) {
  			// 1depth 카테고리 일치하는 요소가 없는 경우 2뎁스에서 검색
  			cateIndex = $(this).index();
  		}
  	});
  	$('#layout_header .designCategoryNavigation .respCategoryList>li').eq(cateIndex).addClass('on');
  	/* //카테고리 활성화 */

  	/* 카테고리 swiper 동작( 1024 미만인 경우 동작, 1024 이상인 경우 : 마우스 오버시 서브메뉴 노출 ) */
  	var slideshowSwiper = undefined;
  	if ( window.innerWidth < 1280 && $('#cateSwiper .designCategoryNavigation').length > 0 ) {
  		$('#cateSwiper .designCategoryNavigation ul.respCategoryList>li').addClass('swiper-slide');
  		slideshowSwiper = new Swiper('#cateSwiper .designCategoryNavigation', {
  			wrapperClass: 'respCategoryList',
  			slidesPerView: 'auto'
  		});
  		slideshowSwiper.slideTo( (cateIndex-1), 800, false );
  	} else {
  		$('#cateSwiper .designCategoryNavigation ul.respCategoryList>li').removeClass('swiper-slide');
  		$('#layout_header .respCategoryList .categoryDepth1').hover(
  			function() { $(this).find('.categorySub').show(); },
  			function() { $(this).find('.categorySub').hide(); }
  		);
  	}
  	$( window ).resize(function() {
  		if ( window.innerWidth != WINDOWWIDTH ) {
  			if ( window.innerWidth < 1280 && $('#cateSwiper .designCategoryNavigation').length > 0 && slideshowSwiper == undefined ) {
  				$('#cateSwiper .designCategoryNavigation ul.respCategoryList>li').addClass('swiper-slide');
  				$('#layout_header .respCategoryList .categoryDepth1').off('hover');
  				slideshowSwiper = new Swiper('#cateSwiper .designCategoryNavigation', {
  					wrapperClass: 'respCategoryList',
  					slidesPerView: 'auto'
  				});
  				slideshowSwiper.slideTo( (cateIndex-1), 800, false );
  			} else if ( window.innerWidth > 1279 && slideshowSwiper != undefined ) {
  				slideshowSwiper.slideTo( 0, 800, false );
  				$('#cateSwiper .designCategoryNavigation ul.respCategoryList>li').removeClass('swiper-slide');
  				slideshowSwiper.destroy();
  				slideshowSwiper = undefined;
  				$('#layout_header .respCategoryList .categoryDepth1').hover(
  					function() { $(this).find('.categorySub').show(); },
  					function() { $(this).find('.categorySub').hide(); }
  				);
  			}
  		}
  	});
  	/* //카테고리 swiper 동작( 1024 미만인 경우 동작, 1024 이상인 경우 : 마우스 오버시 서브메뉴 노출 ) */

  	//================= 카테고리 전체 네비게이션 START ====================
  	$('.categoryAllBtn').click(function() {
  		$('#categoryAll_wrap .categoryAllContainer').load('/common/category_all_navigation', function() {
  			$('#categoryAll_wrap').show();
  			$('body').css( 'overflow', 'hidden' );
  		});
  	});
  	$('#categoryAll_wrap').on('click', '.categoryAllClose', function() {
  		$('#categoryAll_wrap').hide();
  		$('body').css( 'overflow', 'auto' );
  	});
  	//================= 카테고리 전체 네비게이션 END  ====================

  	//================= 브랜드 전체 네비게이션 START ====================
  	$('.brandAllBtn').click(function() {
  		$('#brandAll_wrap .brandAllContainer').load('/common/brand_all_navigation', function() {
  			$('#brandAll_wrap').show();
  			$('body').css( 'overflow', 'hidden' );
  		});
  	});
  	$('#brandAll_wrap').on('click', '.brandAllClose', function() {
  		$('#brandAll_wrap').hide();
  		$('body').css( 'overflow', 'auto' );
  	});
  	//================= 브랜드 전체 네비게이션 END  ====================

  	//================= 지역 전체 네비게이션 START ====================
  	$('.locationAllBtn').click(function() {
  		$('#locationAll_wrap .locationAllContainer').load('/common/location_all_navigation', function() {
  			$('#locationAll_wrap').show();
  			$('body').css( 'overflow', 'hidden' );
  		});
  	});
  	$('#locationAll_wrap').on('click', '.locationAllClose', function() {
  		$('#locationAll_wrap').hide();
  		$('body').css( 'overflow', 'auto' );
  	});
  	//================= 지역 전체 네비게이션 END  ====================

  	// GNB 검색 관련
  	$('#respTopSearch .search_open_btn').click(function() {
  		$('#respTopSearch .search_form').addClass('animating');
  		$('#respTopSearch .search_text').focus();
  	});
  	$('#respTopSearch .search_close_btn').click(function() {
  		$('#respTopSearch .search_form').removeClass('animating');
  	});

  	// 타이틀바 띄우기
  	flyingTitleBar();
  	$( window ).on('resize', function() {
  		if ( window.innerWidth != WINDOWWIDTH ) {
  			flyingTitleBar();
  		}
  	});

  	/* 카테고리 네비게이션 서브레이어 포지션 변화 */
  	var category1DepthNum = $('.respCategoryList .categoryDepth1').length;
  	var rightCategoryStandard = Math.floor( category1DepthNum / 2 );
  	$('.respCategoryList .categoryDepth1').each(function(e) {
  		if ( e > rightCategoryStandard ) {
  			$('.respCategoryList .categoryDepth1').eq(e).addClass('right_area');
  		}
  	});
  	/* 카테고리 네비게이션 서브레이어 포지션 변화 */

  	$('.designPopupBand .designPopupClose').on('click', function() {
  		// 띠배너 닫기 클릭시
  	});
  });
</script>

<!-- 슬라이드 배너 영역 (light_style_1_18) :: START -->

<div class="custom_slider sliderA center"></div>

<script type="text/javascript">
  $(function () {
    $("").not(".slick-initialized").slick({
      // $('.light_style_타입num_배너num')에서 '배너num'는 showDesignBanner(배너num)과 반드시 일치해야 합니다

      dots: true, // 도트 페이징 사용( true 혹은 false )

      autoplay: true, // 슬라이드 자동( true 혹은 false )

      speed: 1000, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 600 == 0.6초 )

      fade: true, // 슬라이딩 fade 모션 사용( true 혹은 fasle )

      autoplaySpeed: 3000, // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 3000 == 3초 )

      // 이 외 slick 슬라이더의 자세한 옵션사항은 http://kenwheeler.github.io/slick/ 참고
    });
  });
</script>

<!-- 슬라이드 배너 영역 (light_style_1_18) :: END -->