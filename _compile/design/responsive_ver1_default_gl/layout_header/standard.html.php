<?php /* Template_ 2.2.6 2022/02/04 15:53:40 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/layout_header/standard.html 000031784 */  $this->include_("showSearchRecent","dataGoodsTodayLight","showTopPromotion","showCategoryLightNavigation");
$TPL_env_list_1=empty($TPL_VAR["env_list"])||!is_array($TPL_VAR["env_list"])?0:count($TPL_VAR["env_list"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ #LAYOUT_HEADER @@
- 파일위치 : [스킨폴더]/layout_header/standard.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<style type="text/css">
    .mobile_top_banner{display: none;}
    .top_link_banner{width: 49.9%; display: inline-block; margin:0;}
    

@media only screen and (max-width: 967px){
    .designPopupBody{margin-bottom: 0;}
    .top_link_banner{width: 49.5%;}
    .pc_top_banner{display: none;}
    .mobile_top_banner{display: block;}
@media only screen and (max-width:546px){
            .top_link_banner{width: 49.5%;}
        }
  
</style>

<div class="designPopupBand hide designElement" popupstyle="band" designelement="popup" templatepath="goods/catalog.html" popupseq="1" style="display: block; background-color: #8280fc;">
    <div class="designPopupBody" style="margin-bottom: 20px;">

        <div class="pc_top_banner">
          <a href="https://music-brother.com/main/detail" target="_blank" class="top_link_banner" hrefOri='aHR0cHM6Ly9tdXNpYy1icm90aGVyLmNvbS9tYWluL2RldGFpbA==' >
              <img src="/data/skin/responsive_ver1_default_gl/images/top_music_link02.jpeg" designImgSrcOri='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvdG9wX211c2ljX2xpbmswMi5qcGVn' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvdG9wX211c2ljX2xpbmswMi5qcGVn' designElement='image' >
          </a>
          <a href="https://audition.music-brother.com" target="_blank" class="top_link_banner" hrefOri='aHR0cHM6Ly9hdWRpdGlvbi5tdXNpYy1icm90aGVyLmNvbQ==' >
              <img src="/data/skin/responsive_ver1_default_gl/images/top_audition_link02.jpeg" designImgSrcOri='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvdG9wX2F1ZGl0aW9uX2xpbmswMi5qcGVn' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvdG9wX2F1ZGl0aW9uX2xpbmswMi5qcGVn' designElement='image' >
          </a>
        </div>

        <div class="mobile_top_banner">
          <a href="https://music-brother.com/main/detail" target="_blank" class="top_link_banner" hrefOri='aHR0cHM6Ly9tdXNpYy1icm90aGVyLmNvbS9tYWluL2RldGFpbA==' >
            <img src="/data/skin/responsive_ver1_default_gl/images/m_top_music_link02.jpeg" designImgSrcOri='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvbV90b3BfbXVzaWNfbGluazAyLmpwZWc=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvbV90b3BfbXVzaWNfbGluazAyLmpwZWc=' designElement='image' >
          </a>
          <a href="https://audition.music-brother.com" target="_blank" class="top_link_banner" hrefOri='aHR0cHM6Ly9hdWRpdGlvbi5tdXNpYy1icm90aGVyLmNvbQ==' >
              <img src="/data/skin/responsive_ver1_default_gl/images/m_top_audition_link02.jpeg" designImgSrcOri='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvbV90b3BfYXVkaXRpb25fbGluazAyLmpwZWc=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvbV90b3BfYXVkaXRpb25fbGluazAyLmpwZWc=' designElement='image' >
          </a>
        </div>
      
        
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


<div id="layout_header" class="layout_header">
	<div class="util_wrap">
		<div class="resp_wrap">
			<!-- language -->
			<div class="language hide">
<?php if($TPL_env_list_1){foreach($TPL_VAR["env_list"] as $TPL_V1){?>
<?php if(($TPL_VAR["this_admin_env"]["language"]==$TPL_V1["language"])&&($TPL_V1["this_admin"]=='y')){?>
				<a class="select_list" id="select_main" href="http://<?php echo $TPL_V1["domain"]?>" hrefOri='aHR0cDovL3suZG9tYWlufQ==' >
					<span class='language_country_img language_country_img_<?php echo $TPL_V1["language"]?>'></span>
					<?php echo $TPL_V1["lang_list"]?>

					<span class="sel_arrow"></span>
				</a>
<?php }?>
<?php }}?>
				<ul class="optionSub" style="position:relative;display:none;">
<?php if($TPL_env_list_1){foreach($TPL_VAR["env_list"] as $TPL_V1){?>
<?php if(($TPL_VAR["this_admin_env"]["language"]!=$TPL_V1["language"])&&($TPL_V1["this_admin"]!='y')){?>
					<li>
						<a class="select_list" href="http://<?php echo $TPL_V1["domain"]?>" hrefOri='aHR0cDovL3suZG9tYWlufQ==' >
							<span class='language_country_img_<?php echo $TPL_V1["language"]?>'></span>
							<?php echo $TPL_V1["lang_list"]?>

						</a>
					</li>
<?php }?>
<?php }}?>
				</ul>
			</div>

			<!-- bookmark -->
			<a class="bookmark" href="<?php echo $TPL_VAR["bookmark"]?>" title="북마크" hrefOri='e2Jvb2ttYXJrfQ==' ><img src="/data/skin/responsive_ver1_default_gl/images/common/icon_bookmark.png" alt="bookmark" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9pY29uX2Jvb2ttYXJrLnBuZw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvY29tbW9uL2ljb25fYm9va21hcmsucG5n' designElement='image' /> <span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s" >BOOKMARK</span></a>

			<ul class="util_wrap_menu2">
<?php if($TPL_VAR["userInfo"]["member_seq"]){?>
				<li class="user_info"><?php if($TPL_VAR["userInfo"]["user_name"]){?><span class="u_name"><?php echo $TPL_VAR["userInfo"]["user_name"]?></span><?php }else{?><span class="u_id"><?php echo $TPL_VAR["userInfo"]["userid"]?></span><?php }?><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s" >님 반갑습니다.</span></li>
				<li><?php if($TPL_VAR["userInfo"]["snsfacebookcon"]&&$TPL_VAR["fbuser"]){?><a href="javascript:void(0);" onclick="FB.logout(function(response) {logout();});return false;" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s" hrefOri='amF2YXNjcmlwdDp2b2lkKDApOw==' >LOGOUT</a><?php }else{?><a href="/login_process/logout" target= "actionFrame" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s" hrefOri='L2xvZ2luX3Byb2Nlc3MvbG9nb3V0' >LOGOUT</a><?php }?></li>
<?php }elseif($TPL_VAR["sess_order"]){?>
				<li><a href="/login_process/logout" target= "actionFrame" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s" hrefOri='L2xvZ2luX3Byb2Nlc3MvbG9nb3V0' >LOGOUT</a></li>
<?php }else{?>
				<li><a href="/member/login" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s" hrefOri='L21lbWJlci9sb2dpbg==' >LOGIN</a></li>
				<li>
					<a href="/member/agreement" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s" hrefOri='L21lbWJlci9hZ3JlZW1lbnQ=' >JOIN</a>
<?php if($TPL_VAR["member_emoneyapp"]["emoneyJoin"]){?>
					<div class="benefit">
						<span class="arrow">▲</span>
						+ <?php echo number_format($TPL_VAR["member_emoneyapp"]["emoneyJoin"])?>

					</div>
<?php }?>
				</li>
<?php }?>
				<li><a href="/mypage" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s" hrefOri='L215cGFnZQ==' >MY SHOPPING</a></li>
				<li><a href="/mypage/order_catalog" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s" hrefOri='L215cGFnZS9vcmRlcl9jYXRhbG9n' >ORDER</a></li>
				<li class="respCartArea"><a href="/order/cart" hrefOri='L29yZGVyL2NhcnQ=' ><span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s" >CART</span><span class="cart_cnt1"><?php echo $TPL_VAR["push_count_cart"]?></span></a></li>
				<li><a href="/service/cs" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s" hrefOri='L3NlcnZpY2UvY3M=' >CS CENTER</a></li>
			</ul>
		</div>
	</div>


	<div class="logo_wrap">
		<div class="resp_wrap">
			<!-- logo -->
			<h1 class="logo_area">
				<a href='/' target='_self' hrefOri='Lw==' ><img src="/data/skin/responsive_ver1_default_gl/images/design/resp_logo_sample.png" title="(주)음악형제들" alt="(주)음악형제들" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9yZXNwX2xvZ29fc2FtcGxlLnBuZw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvZGVzaWduL3Jlc3BfbG9nb19zYW1wbGUucG5n' designElement='image' ></a>
			</h1>

			<!-- 햄버거 버튼 -->
			<div class="resp_top_hamburger">
				<a href="#category" hrefOri='I2NhdGVnb3J5' ><b>aside menu</b></a>
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
						<div class="contetns_area" style="display:none;">
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
									<div id="recentSearchedGuide" class="no_data" style="display:none;">최근 검색어 저장 기능이 꺼져있습니다.</div>
									<ul class="tab_foot_menu">
										<li class="menu_item">
											<a href="javascript:void(0)" data-value="all" onclick="searchRecentRemove(this)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >전체삭제</a>
											<a class="btnRecentAuto off" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >자동저장 끄기</a>
											<a class="btnRecentAuto on" href="javascript:void(0)" style="display:none;" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >자동저장 <span class="importcolor">켜기</span></a>
										</li>
										<li class="search_close searchModuleClose"><a href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >닫기</a></li>
									</ul>
								</div>
								<!-- //최근 검색어 -->
								<!-- 최근본 상품 -->
								<div id="recent-item-list" class="tab_contents" style="display:none;">
									<ul class="recent_item_list">
<?php if(is_array($TPL_R1=dataGoodsTodayLight('list', 12))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
										<li class="recent_item" data-value="<?php echo $TPL_V1["goods_seq"]?>">
											<a class="item_link" href="../goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" hrefOri='Li4vZ29vZHMvdmlldz9ubz17Lmdvb2RzX3NlcX0=' ><img class="item_img" src="<?php echo $TPL_V1["image"]?>" alt="썸네일(스크롤)" onerror="this.src='/data/icon/goods/error/noimage_list.gif';" designImgSrcOri='ey5pbWFnZX0=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s' designImgSrc='ey5pbWFnZX0=' designElement='image' /></a>
											<div class="display_zzim">
<?php if($TPL_V1["wish"]){?>
												<img src="/data/icon/goodsdisplay/preview/thumb_zzim_off.png" class="zzimOffImg"  alt="찜하기" style="display:none" data-member="<?php echo $TPL_VAR["userInfo"]["member_seq"]?>" data-goods="<?php echo $TPL_V1["goods_seq"]?>" data-wish="<?php echo $TPL_V1["wish"]?>" onclick="setWish(this)" designImgSrcOri='L2RhdGEvaWNvbi9nb29kc2Rpc3BsYXkvcHJldmlldy90aHVtYl96emltX29mZi5wbmc=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvaWNvbi9nb29kc2Rpc3BsYXkvcHJldmlldy90aHVtYl96emltX29mZi5wbmc=' designElement='image' >
												<img src="/data/icon/goodsdisplay/preview/thumb_zzim_on.png" class="zzimOnImg" alt="찜하기" data-member="<?php echo $TPL_VAR["userInfo"]["member_seq"]?>" data-goods="<?php echo $TPL_V1["goods_seq"]?>" data-wish="<?php echo $TPL_V1["wish"]?>" onclick="setWish(this)" designImgSrcOri='L2RhdGEvaWNvbi9nb29kc2Rpc3BsYXkvcHJldmlldy90aHVtYl96emltX29uLnBuZw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvaWNvbi9nb29kc2Rpc3BsYXkvcHJldmlldy90aHVtYl96emltX29uLnBuZw==' designElement='image' >
<?php }else{?>
												<img src="/data/icon/goodsdisplay/preview/thumb_zzim_off.png" class="zzimOffImg" alt="찜하기" data-member="<?php echo $TPL_VAR["userInfo"]["member_seq"]?>" data-goods="<?php echo $TPL_V1["goods_seq"]?>" data-wish="<?php echo $TPL_V1["wish"]?>" onclick="setWish(this)" designImgSrcOri='L2RhdGEvaWNvbi9nb29kc2Rpc3BsYXkvcHJldmlldy90aHVtYl96emltX29mZi5wbmc=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvaWNvbi9nb29kc2Rpc3BsYXkvcHJldmlldy90aHVtYl96emltX29mZi5wbmc=' designElement='image' >
												<img src="/data/icon/goodsdisplay/preview/thumb_zzim_on.png" class="zzimOnImg" alt="찜하기" style="display:none" data-member="<?php echo $TPL_VAR["userInfo"]["member_seq"]?>" data-goods="<?php echo $TPL_V1["goods_seq"]?>" data-wish="<?php echo $TPL_V1["wish"]?>" onclick="setWish(this)" designImgSrcOri='L2RhdGEvaWNvbi9nb29kc2Rpc3BsYXkvcHJldmlldy90aHVtYl96emltX29uLnBuZw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvaWNvbi9nb29kc2Rpc3BsYXkvcHJldmlldy90aHVtYl96emltX29uLnBuZw==' designElement='image' >
<?php }?>
											</div>
											<a class="item_delete" href="javascript:void(0)" title="삭제" onclick="todayViewRemove(this);" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >아이템 삭제</a>
										</li>
<?php }}?>
										<li class="no_data" style="display:none;">최근본 상품이 없습니다.</li>
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
							<div id="autoCompleteArea" class="autocomplete_area" style="display:none;">

								<!-- 검색어 자동완성 - 검색어 -->
								<div class="autocomplete_searching">
									<ul id="autoCompleteList" class="searching_list">
									</ul>

									<div id="autoCompleteGuide" class="no_data" style="display:none;">자동완성 기능이 꺼져있습니다</div>

									<ul class="tab_foot_menu">
										<li class="menu_item">
											<a class="btnAutoComplete off" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >자동완성 끄기</a>
											<a class="btnAutoComplete on" href="javascript:void(0)" style="display:none;" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >자동완성 <span class="importcolor">켜기</span></a>
										</li>
										<li class="search_close searchModuleClose"><a href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >닫기</a></li>
									</ul>
								</div>
								<!-- //검색어 자동완성 - 검색어 -->

								<!-- 검색어 자동완성 - 배너( 추천상품 ) -->
								<div id="autoCompleteBanner" class="autocomplete_banner">
									<h5 class="title">추천 상품</h5>
									<ul id="autocompleteBannerList" class="banner_list">
									</ul>
								</div>
								<!-- //검색어 자동완성 - 배너( 추천상품 ) -->
							</div>
						<!-- ------- //검색어 자동완성 ------- -->
						</div>
					</div>
				</div>
			</div>
			<!-- +++++++++++++++++++++++++ //검색 리뉴얼 +++++++++++++++++++++++++++++ -->

			<!-- 장바구니( 1023px 이하에서 노출됨 ) -->
			<a href="/order/cart" class="resp_top_cart" hrefOri='L29yZGVyL2NhcnQ=' ><span class="cart_cnt2"><?php echo $TPL_VAR["push_count_cart"]?></span></a>

			<!-- 슬라이드 배너 영역 (light_style_1_2) :: START -->
			<div class="gnb_bnr_slide gnb_bnr_slide_02 slider_before_loading" style="position:absolute; right:40px; top:0px; width:220px; height:148px;">
				<div class="slider_gon">
					
				</div>
			</div>
			<script type="text/javascript">
			$(function() {
				$('.light_style_1_2').slick({
					autoplay: true,
					vertical: true,
					speed: 400,
					autoplaySpeed: 6000,
				});
			});
			</script>
			<!-- 슬라이드 배너 영역 (light_style_1_2) :: END -->
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
		$(function() {
			$('#resp_promo').slick({
				autoplay: true,
				speed: 800,
				autoplaySpeed: 8000,
			});
		});
	</script>
<?php }?>

	<!-- +++++++++++ 카테고리 메뉴( 카테고리 메뉴를 미노출 하실 분은 style="display:none;" 처리 하세요. ex) id="cateSwiper" class="nav_wrap" style="display:none;" ) +++++++++++ -->
	<div id="cateSwiper" class="nav_wrap">
		<div class="resp_wrap">
			<div class="nav_category_area">
				<div class="designCategoryNavigation">
					<ul class="respCategoryList">
						<li class="nav_category_all">
							<!-- 전체 카테고리 버튼 class 네임 : 'categoryAllBtn', 전체 브랜드 : 'brandAllBtn', 전체 지역 : 'locationAllBtn' -->
							<!-- 전체 카테고리 로딩 파일위치 : [스킨폴더]/_modules/category/all_navigation.html -->
							<a class="hand categoryAllBtn" designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s"  title="전체 카테고리">ALL</a>
						</li>
						<!-- 카테고리 네비게이션. 파일위치 : [스킨폴더]/_modules/category/category_gnb.html -->
						<!-- 참고) 브랜드: showBrandLightNavigation(), 지역: showLocationLightNavigation() -->
						<?php echo showCategoryLightNavigation()?>

						<!-- //카테고리 네비게이션 -->
						<li class="custom_nav_link">
							<a class="categoryDepthLink" designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s"  href="/goods/new_arrivals" hrefOri='L2dvb2RzL25ld19hcnJpdmFscw==' ><em>NEW</em></a>
						</li>
						<li class="custom_nav_link">
							<a class="categoryDepthLink" designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s"  href="/goods/best" hrefOri='L2dvb2RzL2Jlc3Q=' ><em>BEST</em></a>
						</li>
						<li class="custom_nav_link">
							<a class="categoryDepthLink" designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s"  href="/goods/brand_main" hrefOri='L2dvb2RzL2JyYW5kX21haW4=' ><em>BRANDS</em></a>
						</li>
						<li class="custom_nav_link">
							<a class="categoryDepthLink" designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2hlYWRlci9zdGFuZGFyZC5odG1s"  href="/promotion/event" hrefOri='L3Byb21vdGlvbi9ldmVudA==' ><em>EVENT</em></a>
						</li>
						<!-- <li class="custom_nav_link">
							<a class="categoryDepthLink" designElement="text" href="/board/?id=custom_bbs2" hrefOri='L2JvYXJkLz9pZD1jdXN0b21fYmJzMg==' ><em>STORY</em></a>
						</li> -->
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- +++++++++++ //카테고리 메뉴 +++++++++++ -->

	<!-- 카테고리 전체 네비게이션 팝업 START -->
	<div id="categoryAll_wrap" class="categoryAll_wrap" style="display:none;">
		<div class="categoryAllContainer"><!-- 로딩 파일위치 : [스킨폴더]/_modules/category/all_navigation.html --></div>
	</div>
	<!-- 카테고리 전체 네비게이션 팝업 END -->

	<!-- 브랜드 전체 네비게이션 팝업 START -->
	<div id="brandAll_wrap" class="brandAll_wrap" style="display:none;">
		<div class="brandAllContainer"><!-- 로딩 파일위치 : [스킨폴더]/_modules/brand/all_navigation.html --></div>
	</div>
	<!-- 브랜드 전체 네비게이션 팝업 END -->

	<!-- 지역 전체 네비게이션 팝업 START -->
	<div id="locationAll_wrap" class="locationAll_wrap" style="display:none;">
		<div class="locationAllContainer"><!-- 로딩 파일위치 : [스킨폴더]/_modules/location/all_navigation.html --></div>
	</div>
	<!-- 지역 전체 네비게이션 팝업 END -->

</div>
<!-- 상단영역 : 끝 -->
<script type="text/javascript" src="/data/skin/responsive_ver1_default_gl/common/search_ver2_ready.js"></script><!-- 반응형 관련 프론트 js : 검색, 자동검색어 최근본상품 -->
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
		} else if ( REQURL != url2 && ( REQURL.substr( 0, REQURL.length-4 ) == url2 || REQURL.substr( 0, REQURL.length-8 ) == url2) ) {
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