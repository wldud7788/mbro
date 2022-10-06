<?php /* Template_ 2.2.6 2022/04/06 18:44:26 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/_modules/common/layout_side.html 000028586 */  $this->include_("dataWishCount");
$TPL_favorite_category_1=empty($TPL_VAR["favorite_category"])||!is_array($TPL_VAR["favorite_category"])?0:count($TPL_VAR["favorite_category"]);
$TPL_category_1=empty($TPL_VAR["category"])||!is_array($TPL_VAR["category"])?0:count($TPL_VAR["category"]);
$TPL_favorite_brand_1=empty($TPL_VAR["favorite_brand"])||!is_array($TPL_VAR["favorite_brand"])?0:count($TPL_VAR["favorite_brand"]);
$TPL_best_brand_1=empty($TPL_VAR["best_brand"])||!is_array($TPL_VAR["best_brand"])?0:count($TPL_VAR["best_brand"]);
$TPL_brand_1=empty($TPL_VAR["brand"])||!is_array($TPL_VAR["brand"])?0:count($TPL_VAR["brand"]);
$TPL_location_1=empty($TPL_VAR["location"])||!is_array($TPL_VAR["location"])?0:count($TPL_VAR["location"]);
$TPL_dataRightQuicklist_1=empty($TPL_VAR["dataRightQuicklist"])||!is_array($TPL_VAR["dataRightQuicklist"])?0:count($TPL_VAR["dataRightQuicklist"]);
$TPL_env_list_1=empty($TPL_VAR["env_list"])||!is_array($TPL_VAR["env_list"])?0:count($TPL_VAR["env_list"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 어사이드 @@
- 파일위치 : [스킨폴더]/_modules/common/layout_side.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div>

<!-- 구글 번역 시작 -->
<div style="padding:10px; border-bottom: 1px solid #ddd;">
	
    <div id="google_translate_element" class="language_box"></div>

    <style type="text/css">
      .goog-te-gadget .goog-te-combo{width: 150px;}
      .aside_userinformation>ul{display: block;}
      .aside_userinformation>ul>li{display: block;}
      .asie_main_menu>ul>li{display: inline-block; width: 49%; margin: 1px;}
      .asie_main_menu>ul>li.bmp_icon>a, .asie_main_menu>ul>li.mubro_music>a, .asie_main_menu>ul>li.mubro_audition>a, .asie_main_menu>ul>li.shop_event>a{background: none;}
      .asie_main_menu>ul>li>a{padding: 5px; border: 1px solid #ccc;}
      .asie_main_menu>ul>li>a>img{width: 20%; vertical-align: unset;}
      .asie_main_menu>ul>li>a>span{display: inline-block; margin-left: 10px;}
      .aside_navigation_wrap ul.menu li.mitem.category a.mitem_title{line-height: 40px;}
      .aside_navigation_wrap ul.menu li.mitem.mitemicon2{background-color: white;}
      .aside_navigation_wrap ul.menu li.mitem_subcontents ul.submenu{background-color: white;}
      @font-face {
		    font-family: 'GongGothicMedium';
		    src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_20-10@1.0/GongGothicMedium.woff') format('woff');
		    font-weight: normal;
		    font-style: normal;
		}
		@font-face {
    font-family: 'MapoFlowerIsland';
    src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2001@1.1/MapoFlowerIslandA.woff') format('woff');
    font-weight: normal;
    font-style: normal;
}
    </style>
    <script type="text/javascript">
      function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            
            layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL, includedLanguages:'ko,en,de,ja,fr,ru,zh-CN,zh-TW', 
            gaTrack: true, 
            gaId: '직접입력해야합니다.'},'google_translate_element');}      
    </script> 

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
   	<script>
      setTimeout(function(){document.querySelector("[value="+''+"]").innerText = 'Language selection';}, 1000);
      setTimeout(function(){document.querySelector("[value=en]").innerText = 'english';}, 1000);
      setTimeout(function(){document.querySelector("[value=ko]").innerText = 'Korea';}, 1000);
      setTimeout(function(){document.querySelector("[value=de]").innerText = 'German';}, 1000);
      setTimeout(function(){document.querySelector("[value=ja]").innerText = 'Japanese';}, 1000);
      setTimeout(function(){document.querySelector("[value=fr]").innerText = 'French';}, 1000);
      setTimeout(function(){document.querySelector("[value=ru]").innerText = 'Russian';}, 1000);
      setTimeout(function(){document.querySelector("[value=zh-CN]").innerText = 'Chinese(Simplified)';}, 1000);
      setTimeout(function(){document.querySelector("[value=zh-TW]").innerText = 'Chinese(Traditional)';}, 1000);
    </script>
</div>
 <!-- 구글 번역 종료 -->

 
<div class="aside_userinformation">
<?php if($TPL_VAR["userInfo"]["member_seq"]){?>
	<ul>
		<!-- O2O 바코드 -->
<?php if($TPL_VAR["checkO2OService"]){?>
<?php $this->print_("o2o_layout_side",$TPL_SCP,1);?>

<?php }?>
		
		<li class="left_area">
			<strong class="user_name"><?php if($TPL_VAR["userInfo"]["user_name"]){?><?php echo $TPL_VAR["userInfo"]["user_name"]?><?php }else{?><?php echo $TPL_VAR["userInfo"]["userid"]?><?php }?></strong><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >님 안녕하세요.</span>
		</li>
		<li class="right_area" style="margin-top: 10px;">
			<a href="https://musicbroshop.com/mypage" class="btn_resp" style="width:49%;">마이페이지</a>
			<a href="../login_process/logout" target="actionFrame" class="btn_resp" style="width:49%;">로그아웃</a>
		</li>
	</ul>
<?php }else{?>
	<ul>
		<li class="left_area">
			<span class="gray_06" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >로그인하세요.</span>
		</li>
		<li class="right_area">
			<a href="../member/login" class="btn_resp color4" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >로그인</a>
			<a href="../member/agreement" class="btn_resp" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >회원가입</a>
		</li>
	</ul>
<?php }?>
</div>



<div class="aside_navigation_wrap">
	<ul class="tab">
		<li data-menuname="categorySideMenu" class="current"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >카테고리</span></li>
		<li data-menuname="brandSideMenu"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >브랜드</span></li>
		<li data-menuname="locationSideMenu"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >지역</span></li>
		<li data-menuname="boardSideMenu"><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >CS CENTER</span></li>
	</ul>

	<!-- ++++++++ 카테고리 ++++++++ -->
	<div class="designElement" designelement="category">
		<ul id="categorySideMenu" class="menu">
<?php if($TPL_VAR["userInfo"]["member_seq"]){?>
			<li class="mitem mitemicon1 favorite">
				<a class="mitem_title v3" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >FAVORITE CATEGORY</a>
			</li>
			<li class="mitem_subcontents">
				<ul class="submenu">
<?php if($TPL_VAR["favorite_category"]){?>
<?php if($TPL_favorite_category_1){foreach($TPL_VAR["favorite_category"] as $TPL_V1){?>
						<li class="submitem favorite">
							<a href="/goods/catalog?code=<?php echo $TPL_V1["category_code"]?>" class="submitem_title"><?php echo $TPL_V1["title"]?></a>
<?php if($TPL_VAR["userInfo"]["member_seq"]){?><a class="mitem_favorite <?php if($TPL_V1["favorite"]){?>mitem_favorite_on<?php }?>" ctype="category" ccode="<?php echo $TPL_V1["category_code"]?>"></a><?php }?>
						</li>
<?php }}?>
<?php }else{?>
						<li class="submitem no_favorite">
							자주 이용할 카테고리의 <img src="/data/skin/responsive_sports_sporti_gl_1/images/design/ico_fvr_off.png" width="20" alt="카테고리 즐겨찾기" />을 눌러주세요.
						</li>
<?php }?>
				</ul>
			</li>
<?php }?>
<?php if($TPL_category_1){foreach($TPL_VAR["category"] as $TPL_V1){?>
			<li class="mitem category mitem_category <?php if($TPL_V1["childs"]){?>mitemicon2<?php }else{?>mitemicon3<?php }?>">
				<a class="mitem_title"></a>
				<a class="mitem_goodsview" href="/goods/catalog?code=<?php echo $TPL_V1["category_code"]?>"><?php echo $TPL_V1["ori_title"]?></a>
<?php if($TPL_VAR["userInfo"]["member_seq"]){?><a class="mitem_favorite <?php if($TPL_V1["favorite"]){?>mitem_favorite_on<?php }?>" ctype="category" ccode="<?php echo $TPL_V1["category_code"]?>"></a><?php }?>
			</li>
			<li class="mitem_subcontents" style="display: list-item;">
				<ul class="submenu">
<?php if(is_array($TPL_R2=$TPL_V1["childs"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<li class="submitem category">
						<a class="submitem_title"></a>
						<a class="mitem_goodsview" href="/goods/catalog?code=<?php echo $TPL_V2["category_code"]?>"><?php echo $TPL_V2["ori_title"]?></a>
<?php if($TPL_VAR["userInfo"]["member_seq"]){?><a class="mitem_favorite <?php if($TPL_V2["favorite"]){?>mitem_favorite_on<?php }?>" ctype="category" ccode="<?php echo $TPL_V2["category_code"]?>"></a><?php }?>
					</li>
<?php }}?>
				</ul>
			</li>
<?php }}?>
		</ul>
	</div>
	<!-- ++++++++ //카테고리 ++++++++ -->

	<!-- ++++++++ 브랜드 ++++++++ -->
	<ul id="brandSideMenu" class="menu" style="display:none;">
<?php if($TPL_VAR["userInfo"]["member_seq"]){?>
		<li class="mitem mitemicon1 favorite">
			<a class="mitem_title v3" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >FAVORITE BRAND</a>
		</li>
		<li class="mitem_subcontents">
			<ul class="submenu">
<?php if($TPL_VAR["favorite_brand"]){?>
<?php if($TPL_favorite_brand_1){foreach($TPL_VAR["favorite_brand"] as $TPL_V1){?>
					<li class="submitem favorite">
						<a href="/goods/brand?code=<?php echo $TPL_V1["category_code"]?>" class="submitem_title"><?php echo $TPL_V1["title"]?></a>
<?php if($TPL_VAR["userInfo"]["member_seq"]){?><a class="mitem_favorite <?php if($TPL_V1["favorite"]){?>mitem_favorite_on<?php }?>" ctype="brand" ccode="<?php echo $TPL_V1["category_code"]?>"></a><?php }?>
					</li>
<?php }}?>
<?php }else{?>
					<li class="submitem no_favorite">
						자주 이용할 브랜드의 <img src="/data/skin/responsive_sports_sporti_gl_1/images/design/ico_fvr_off.png" width="20" alt="브랜드 즐겨찾기" />을 눌러주세요.
					</li>
<?php }?>
			</ul>
		</li>
<?php }?>

<?php if($TPL_VAR["best_brand"]){?>
		<li class="mitem mitemicon1 favorite">
			<a class="mitem_title v2" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >BEST BRAND</a>
		</li>
		<li class="mitem_subcontents">
			<ul class="submenu favorite">
<?php if($TPL_best_brand_1){foreach($TPL_VAR["best_brand"] as $TPL_V1){?>
				<li class="submitem favorite">
					<a href="/goods/brand?code=<?php echo $TPL_V1["category_code"]?>" class="submitem_title"><?php if($TPL_V1["node_catalog_image_normal"]){?><img src="<?php echo $TPL_V1["node_catalog_image_normal"]?>" /><?php }else{?><?php echo $TPL_V1["title"]?><?php }?></a>
<?php if($TPL_VAR["userInfo"]["member_seq"]){?><a class="mitem_favorite <?php if($TPL_V1["favorite"]){?>mitem_favorite_on<?php }?>" ctype="brand" ccode="<?php echo $TPL_V1["category_code"]?>"></a><?php }?>
				</li>
<?php }}?>
			</ul>
			<div class="bestbrands_paging"></div>
		</li>
<?php }?>
		
		<!-- 브랜드 소팅 -->
		<li class="aside_brand_sorting">
			<ul class="brandsort">
				<li class="current"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >전체</span></li>
				<li><span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >가나다</span></li>
				<li><span designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >ABC</span></li>
				<li><span designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >기타</span></li>
			</ul>
			<div class="brandsort_words"></div>
			<ul class="brandsort_words hide">
				<li>ㄱ</li>
				<li>ㄴ</li>
				<li>ㄷ</li>
				<li>ㄹ</li>
				<li>ㅁ</li>
				<li>ㅂ</li>
				<li>ㅅ</li>
				<li>ㅇ</li>
				<li>ㅈ</li>
				<li>ㅊ</li>
				<li>ㅋ</li>
				<li>ㅌ</li>
				<li>ㅍ</li>
				<li>ㅎ</li>
			</ul>
			<ul class="brandsort_words hide">
				<li>A</li>
				<li>B</li>
				<li>C</li>
				<li>D</li>
				<li>E</li>
				<li>F</li>
				<li>G</li>
				<li>H</li>
				<li>I</li>
				<li>J</li>
				<li>K</li>
				<li>L</li>
				<li>M</li>
				<li>N</li>
				<li>O</li>
				<li>P</li>
				<li>Q</li>
				<li>R</li>
				<li>S</li>
				<li>T</li>
				<li>U</li>
				<li>V</li>
				<li>W</li>
				<li>X</li>
				<li>Y</li>
				<li>Z</li>
			</ul>
		</li>

<?php if($TPL_brand_1){foreach($TPL_VAR["brand"] as $TPL_V1){?>
		<li class="mitem category mitem_brand <?php if($TPL_V1["childs"]){?>mitemicon1<?php }else{?>mitemicon3<?php }?>" title_eng="<?php echo $TPL_V1["title_eng"]?>" title="<?php echo $TPL_V1["ori_title"]?>">
			<a class="mitem_title">
				<!-- //브랜드 로고 보이게 하는 부분 -->
				<img src="<?php echo $TPL_V1["brand_image"]?>" alt="" onerror="this.src='/data/skin/responsive_sports_sporti_gl_1/images/common/noimage.gif';">
				<!-- 브랜드 로고 보이게 하는 부분// -->
			</a>
			<a class="mitem_goodsview" href="/goods/brand?code=<?php echo $TPL_V1["category_code"]?>"><?php echo $TPL_V1["ori_title"]?></a>
<?php if($TPL_VAR["userInfo"]["member_seq"]){?><a class="mitem_favorite <?php if($TPL_V1["favorite"]){?>mitem_favorite_on<?php }?>" ctype="brand" ccode="<?php echo $TPL_V1["category_code"]?>"></a><?php }?>
		</li>
		<li class="mitem_subcontents">
			<ul class="submenu">
<?php if(is_array($TPL_R2=$TPL_V1["childs"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="submitem category">
					<a class="submitem_title"></a>
					<a class="mitem_goodsview" href="/goods/brand?code=<?php echo $TPL_V2["category_code"]?>"><?php echo $TPL_V2["ori_title"]?></a>
<?php if($TPL_VAR["userInfo"]["member_seq"]){?><a class="mitem_favorite <?php if($TPL_V2["favorite"]){?>mitem_favorite_on<?php }?>" ctype="brand" ccode="<?php echo $TPL_V2["category_code"]?>"></a><?php }?>
				</li>
<?php }}?>
			</ul>
		</li>
<?php }}?>
	</ul>
	<!-- ++++++++ //브랜드 ++++++++ -->

	<!-- ++++++++ 지역 ++++++++ -->
	<ul id="locationSideMenu" class="menu" style="display:none;">
<?php if($TPL_location_1){foreach($TPL_VAR["location"] as $TPL_V1){?>
		<li class="mitem category mitem_location <?php if($TPL_V1["childs"]){?>mitemicon1<?php }else{?>mitemicon3<?php }?>">
			<a class="mitem_title"></a>
			<a class="mitem_goodsview" href="/goods/location?code=<?php echo $TPL_V1["location_code"]?>"><?php echo $TPL_V1["ori_title"]?></a>
		</li>
		<li class="mitem_subcontents">
			<ul class="submenu">
<?php if(is_array($TPL_R2=$TPL_V1["childs"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li class="submitem category">
					<a class="submitem_title"></a>
					<a class="mitem_goodsview" href="/goods/location?code=<?php echo $TPL_V2["location_code"]?>"><?php echo $TPL_V2["ori_title"]?></a>
				</li>
<?php }}?>
			</ul>
		</li>
<?php }}?>
	</ul>
	<!-- ++++++++ //지역 ++++++++ -->

	<!-- ++++++++ 커뮤니티 ++++++++ -->
	<ul id="boardSideMenu" class="menu board" style="display:none;">
		<li><a href="/board/?id=notice" designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >공지사항</a></li>
		<li><a href="/board/?id=faq" designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >자주묻는질문</a></li>
		<li><a href="/board/?id=goods_qna" designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >상품문의</a></li>
		<li><a href="https://musicbroshop.com/mypage/myqna_catalog" designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >1:1 문의</a></li>
		<li><a href="/board/?id=goods_review" designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >상품후기</a></li>
<?php if($TPL_VAR["isplusfreenot"]){?><li><a href="/board/?id=bulkorder" designElement="text" textIndex="21"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >대량구매</a></li><?php }?>
	</ul>
	<!-- ++++++++ //커뮤니티 ++++++++ -->

	<div class="aside_navigation_bottom_line"></div>
</div>

<!-- 최근 본 상품(SIDE) -->
<div class="wrap_aside">
	<h3 class="title_sub3 v2"><span designElement="text" textIndex="22"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >최근 본 상품</span> <?php if($TPL_VAR["push_count_today"]){?><a href="/goods/recently" class="push_count">(<?php echo $TPL_VAR["push_count_today"]?>)</a><?php }?></h3>
</div>
<?php if($TPL_VAR["dataRightQuicklist"]){?>
<div class="aside_recently">
	<ul id="asideRecentlyMenu" class="aside_recently_menu">
<?php if($TPL_dataRightQuicklist_1){$TPL_I1=-1;foreach($TPL_VAR["dataRightQuicklist"] as $TPL_V1){$TPL_I1++;?>
<?php if(($TPL_I1< 30)){?>
		<li class="sslide" data-removeitem='<?php echo $TPL_V1["goods_seq"]?>'>
			<a href="../goods/view?no=<?php echo $TPL_V1["goods_seq"]?>"><img src="<?php echo $TPL_V1["image"]?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl_1/images/common/noimage_list.gif'" alt="" /></a>
			<a href="javascript:rightDeleteItem( 'mobile_left_item_recent', '<?php echo $TPL_V1["goods_seq"]?>', $(this) );" class="btn_remove">삭제</a>
		</li>
<?php }?>
<?php }}?>
	</ul>
</div>
<script>
$(function() {
	$('#asideRecentlyMenu').slick({
		centerMode: true,
		centerPadding: '20px',
		slidesToShow: 3,
		autoplay: true,
		speed: 400,
		autoplaySpeed: 4000,
	});
	$('#asideRecentlyMenu .btn_remove').on('click', function() {
		var removeItem = $(this).closest('.sslide').data('removeitem');
		$('#asideRecentlyMenu .sslide').each(function(e) {
			if ( $(this).data('removeitem') == removeItem ) {
				$('#asideRecentlyMenu').slick('slickRemove', e);
			}
		});
		if ( $('#asideRecentlyMenu .sslide').length < 1 ) {
			$('.aside_recently_nodata').show();
			$('.aside_recently').remove();
		}
	});
});
</script>
<?php }?>
<p class="aside_recently_nodata" <?php if($TPL_VAR["dataRightQuicklist"]){?>style="display:none;"<?php }?>>
	최근 본 상품이 없습니다.
</p>

<div class="asie_main_menu">
	<ul>
		<div style="display: none;">
			<li class="am_home"><a href="/" designElement="text" textIndex="23"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >홈</a></li>
			<li class="am_order"><a href="/mypage/order_catalog"><span designElement="text" textIndex="24"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >주문조회</span> <?php if($TPL_VAR["push_count_order"]){?><span class="push_count" title="무료/취소/완료 제외한 수"><?php echo $TPL_VAR["push_count_order"]?></span><?php }?></a></li>
			<li class="am_my">
<?php if($TPL_VAR["userInfo"]["member_seq"]){?><a href="/mypage/index"><?php }else{?><a href="/member/login?return_url=/mypage/index"><?php }?><span designElement="text" textIndex="25"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >MY쇼핑</span></a>
			</li>
			<li class="am_cs"><a href="/mypage/myqna_catalog" designElement="text" textIndex="26"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >1:1문의</a></li>
			<li class="am_cart"><a href="/order/cart"><span designElement="text" textIndex="27"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >장바구니</span> <?php if($TPL_VAR["push_count_cart"]){?><span class="push_count"><?php echo $TPL_VAR["push_count_cart"]?></span><?php }?></a></li>
			<li class="am_wish">
<?php if($TPL_VAR["userInfo"]["member_seq"]){?><a href="/mypage/wish"><?php }else{?><a href="/member/login?return_url=/mypage/wish"><?php }?><span designElement="text" textIndex="28"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >위시리스트</span> <?php if(dataWishCount()){?><span class="push_count"><?php echo number_format(dataWishCount())?></span><?php }?></a>
			</li>
			<li class="am_coupon"><a href="/mypage/coupon" designElement="text" textIndex="29"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >쿠폰</a></li>
			<li class="am_emony"><a href="/mypage/emoney" designElement="text" textIndex="30"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >캐시</a></li>
		</div>
		<li class="bmp_icon">
			<a href="https://musicbroshop.com/coin" designElement="text" textIndex="31"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >
				<img src="/data/skin/responsive_sports_sporti_gl_1/images/common/bmp_icon2.png" alt="">
				<span>BMP코인<br>전환하기</span>
			</a>
		</li>
		<!-- <li class="mubro_intro"><a href="https://mubrothers.com/" designElement="text" target="_blank">소개페이지<br> 바로가기</a></li> -->
		<li class="mubro_music">
			<a href="https://music-brother.com/main/detail" designElement="text" textIndex="32"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw="  target="_blank">
				<img src="/data/skin/responsive_sports_sporti_gl_1/images/common/icon_aside_110.png" alt="">
				<span>뮤직브로<br>바로가기</span>
			</a>
		</li>
		<li class="mubro_audition">
			<a href="https://audition.music-brother.com/" designElement="text" textIndex="33"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw="  target="_blank">
				<img src="/data/skin/responsive_sports_sporti_gl_1/images/common/icon_aside_112.png" alt="">
				<span>오디션<br>바로가기</span>
			</a>
		</li>
		<li class="shop_event">
			<a href="https://musicbroshop.com/promotion/event" designElement="text" textIndex="34"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >
				<img src="/data/skin/responsive_sports_sporti_gl_1/images/common/event_icon.png" alt="">
				<span>EVENT<br>바로가기</span>
			</a>
		</li>
	</ul>
</div>

<!-- CS CENTER 정보(SIDE) -->
<div class="wrap_aside">
	<h3 class="title_sub3 v2"><a href="/service/cs" designElement="text" textIndex="35"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >CS CENTER</a></h3>
	<!-- <a class="aside_cs_phone" href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>"><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a> -->
	<a href="../mypage/myqna_catalog">1:1 문의 바로가기</a>
	<p class="aside_cs_addinfo" designElement="text" textIndex="36"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvX21vZHVsZXMvY29tbW9uL2xheW91dF9zaWRlLmh0bWw=" >MON ~ FRI<br />AM 09:00 ~ PM 06:00<br />LUNCH AM 12:00 ~ PM 01:00<br />SAT, SUN, HOLIDAY OFF<br /></p>
</div>

<div class="wrap_aside v2" style="display:none;">
	<select class="Wmax" onchange="location.href=this.value;">
<?php if($TPL_env_list_1){foreach($TPL_VAR["env_list"] as $TPL_V1){?>
		<option value="http://<?php echo $TPL_V1["domain"]?>" <?php if(($TPL_VAR["this_admin_env"]["language"]==$TPL_V1["language"])&&($TPL_V1["this_admin"]=='y')){?>selected<?php }?>><?php echo $TPL_V1["language"]?></option>
<?php }}?>
	</select>
</div>

<!-- 얼럿창 -->
<div id="category_favorite_alert" class="category_favorite_alert">
	<div class="cfa_on"></div>
	<div class="cfa_off"></div>
	<div class="cfa_msg"></div>
</div>


<script type="text/javascript" src="/data/skin/responsive_sports_sporti_gl_1/common/side.js"></script>
<script>
$(function() {
	// side 카테고리, 브랜드, 지역 활성화
	var url3;
	$('#categorySideMenu a.mitem_goodsview, #brandSideMenu a.mitem_goodsview, #locationSideMenu a.mitem_goodsview').each(function() {
		url3 = $(this).attr('href');
		if ( REQURL == url3 || REQURL.substr( 0, REQURL.length-4 ) == url3 ) {
			if ( $(this).parent('.mitem.category').length ) {
				$(this).parent('.mitem.category').addClass('on')
			} else if ( $(this).parent('.submitem.category').length ) {
				$(this).closest('.mitem_subcontents').show();
				$(this).closest('.mitem_subcontents').prev('.mitem.category').removeClass('.mitemicon1').addClass('mitemicon2');
				$(this).parent('.submitem.category').addClass('on');
			}
			$('#layout_side .tab>li').removeClass('current');
			$('#layout_side .menu').hide();

			switch ( $(this).closest('.menu').attr('id') ) {
				case 'categorySideMenu' :
				$('#layout_side .tab>li[data-menuname=categorySideMenu]').addClass('current');
				$('#categorySideMenu').show();
				break;

				case 'brandSideMenu' :
				$('#layout_side .tab>li[data-menuname=brandSideMenu]').addClass('current');
				$('#brandSideMenu').show();
				break;

				case 'locationSideMenu' :
				$('#layout_side .tab>li[data-menuname=locationSideMenu]').addClass('current');
				$('#locationSideMenu').show();
				break;

				default :
				$('#layout_side .tab>li[data-menuname=categorySideMenu]').addClass('current');
				$('#categorySideMenu').show();
				break;
			}
		}
	});
	
	// side 커뮤니티 활성화
	$('#boardSideMenu>li>a').each(function() {
		url3 = $(this).attr('href');
		if ( REQURL == url3 ) {
			$(this).parent('li').addClass('on')
			$('#layout_side .tab>li').removeClass('current');
			$('#layout_side .menu').hide();
			$('#layout_side .tab>li[data-menuname=boardSideMenu]').addClass('current');
			$('#boardSideMenu').show();
		}
	});

	// "카테고리" 카테고리 없을시 처리
	if ( $('#categorySideMenu .mitem_category').length < 1 ) {
		$('#layout_side .tab>li[data-menuname=categorySideMenu]').hide();
		$('#layout_side .tab>li').removeClass('current');
		$('#layout_side ul.menu').hide();
		$('#layout_side .tab>li[data-menuname=categorySideMenu]').next('li').addClass('current');
		$('#categorySideMenu').next('ul').show();
	}
	// "브랜드" 카테고리 없을시 처리
	if ( $('#brandSideMenu .mitem_brand').length < 1 ) {
		$('#layout_side .tab>li[data-menuname=brandSideMenu]').hide();
		$('#layout_side .aside_brand_sorting').hide();
		$('#layout_side .tab>li').removeClass('current');
		$('#layout_side ul.menu').hide();
		if ( $('#categorySideMenu .mitem_category').length < 1 ) {
			$('#layout_side .tab>li[data-menuname=brandSideMenu]').next('li').addClass('current');
			$('#brandSideMenu').next('ul').show();
		} else {
			$('#layout_side .tab>li[data-menuname=categorySideMenu]').addClass('current');
			$('#categorySideMenu').show();
		}
	}
	// "지역" 카테고리 없을시 처리
	if ( $('#locationSideMenu .mitem_location').length < 1 ) {
		$('#layout_side .tab>li[data-menuname=locationSideMenu]').hide();
		$('#layout_side .tab>li').removeClass('current');
		$('#layout_side ul.menu').hide();
		if ( $('#categorySideMenu .mitem_category').length > 0 ) {
			$('#layout_side .tab>li[data-menuname=categorySideMenu]').addClass('current');
			$('#categorySideMenu').show();
		} else if ( $('#brandSideMenu .mitem_brand').length > 0 ) {
			$('#layout_side .tab>li[data-menuname=brandSideMenu]').addClass('current');
			$('#brandSideMenu').show();
		} else {
			$('#layout_side .tab>li[data-menuname=locationSideMenu]').next('li').addClass('current');
			$('#locationSideMenu').next('ul').show();
		}
	}
});
</script>