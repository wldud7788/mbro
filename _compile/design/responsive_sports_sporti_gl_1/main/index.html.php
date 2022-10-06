<?php /* Template_ 2.2.6 2022/09/06 16:34:10 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/main/index.html 000026283 */  $this->include_("getBoarddata","showDesignLightPopup","setTemplatePath","showDesignBanner","showDesignDisplay");
$TPL_year_1=empty($TPL_VAR["year"])||!is_array($TPL_VAR["year"])?0:count($TPL_VAR["year"]);
$TPL_month_1=empty($TPL_VAR["month"])||!is_array($TPL_VAR["month"])?0:count($TPL_VAR["month"]);
$TPL_today_1=empty($TPL_VAR["today"])||!is_array($TPL_VAR["today"])?0:count($TPL_VAR["today"]);?>
<!-- 상점 후기 최근글 start -->
<style type="text/css">
.designLastestNew6316f7f1e1277 .tit {font-size:12px; font-weight:bold;}
.designLastestNew6316f7f1e1277 .normal_bbslist .cat {font-size:12px;font-family:gothic,gulim;color:#888;letter-spacing:-1px;}
.designLastestNew6316f7f1e1277 .normal_bbslist .sbj {text-align:left;letter-spacing:0px;}
.designLastestNew6316f7f1e1277 .normal_bbslist .sbj a {font-size:12px;font-family:gothic,gulim;color:#222222;text-decoration:none;line-height:150%;}
.designLastestNew6316f7f1e1277 .normal_bbslist .sbj a:hover {text-decoration:underline;}
.designLastestNew6316f7f1e1277 .normal_bbslist .comment {font:normal 11px arial;color:#FC6138;}
</style>
<div class='designDisplay designLastestNew6316f7f1e1277' designElement='displaylastest'  id="designLastestNew6316f7f1e1277" templatePath='bWFpbi9pbmRleC5odG1s' >
	<div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="bottom" align="left" height="25"><span class="tit"><p><br></p></span></td>
			<td valign="bottom" align="right"><b><a href="/board/?id=store_review" hrefOri='L2JvYXJkLz9pZD1zdG9yZV9yZXZpZXc=' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design/cscenter_btn_more.gif" designImgSrcOri='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduL2NzY2VudGVyX2J0bl9tb3JlLmdpZg==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduL2NzY2VudGVyX2J0bl9tb3JlLmdpZg==' designElement='image' /></a></b></td>
		</tr>
	</table>
	</div>
	<br style="line-height:10px;" />
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
<?php if(is_array($TPL_R1=getBoardData('store_review','2',null,null,'80','200','ID','HID','IMG',array('orderby=gid asc','','rdate_s=2019-12-12','rdate_f=2022-09-06','none_auto_term=999','image_w=80','image_h=80')))&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1&&$TPL_I1% 2== 0){?></tr><tr ><td height="10"></td></tr><tr  class="normal_bbslist"><?php }?>
			<td width="50%"  class="sbj">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
<td  width="80"  height="80"><?php if($TPL_V1["filelist"]){?><span class="BoardgoodsDisplayImageWrap"  decoration="e30=" ><a href="<?php echo $TPL_V1["wigetboardurl_view"]?>" hrefOri='ey53aWdldGJvYXJkdXJsX3ZpZXd9' ><img src="<?php echo $TPL_V1["filelist"]?>" width="80" height="80" onerror="this.src='/data/skin/<?php echo $TPL_VAR["skin"]?>/images/common/noimage.gif'" designImgSrcOri='ey5maWxlbGlzdH0=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='ey5maWxlbGlzdH0=' designElement='image' /></a></span><?php }?></td>					<td width="10"></td>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td align="left">
<?php if($TPL_V1["goodsInfo"]){?><a href="<?php echo $TPL_V1["wigetboardurl_view"]?>" target="" hrefOri='ey53aWdldGJvYXJkdXJsX3ZpZXd9' ><?php echo $TPL_V1["goodsInfo"]["goods_name"]?> </a><br/><?php }?>
							<?php echo $TPL_V1["subject"]?> <?php echo $TPL_V1["iconnew"]?> <?php echo $TPL_V1["iconhot"]?> <?php echo $TPL_V1["iconfile"]?> <?php echo $TPL_V1["iconhidden"]?>

						</td>
						</tr>


						<tr><td height="6"></td></tr>
						<tr>
							<td align="left">
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
<?php }}?>
	</tr>
	<tr><td height="10"></td></tr>
	</table>
</div>
<!-- 상점 후기 최근글 end -->

<!-- 상품후기  최근글 start -->
<style type="text/css">
.designLastestNew6316cd30dc51f .tit {font-size:12px; font-weight:bold;}
.designLastestNew6316cd30dc51f .normal_bbslist .cat {font-size:12px;font-family:gothic,gulim;color:#888;letter-spacing:-1px;}
.designLastestNew6316cd30dc51f .normal_bbslist .sbj {text-align:left;letter-spacing:0px;}
.designLastestNew6316cd30dc51f .normal_bbslist .sbj a {font-size:12px;font-family:gothic,gulim;color:#222222;text-decoration:none;line-height:150%;}
.designLastestNew6316cd30dc51f .normal_bbslist .sbj a:hover {text-decoration:underline;}
.designLastestNew6316cd30dc51f .normal_bbslist .comment {font:normal 11px arial;color:#FC6138;}
</style>
<div class='designDisplay designLastestNew6316cd30dc51f' designElement='displaylastest'  id="designLastestNew6316cd30dc51f" templatePath='bWFpbi9pbmRleC5odG1s' >
	<div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="bottom" align="left" height="25"><span class="tit"><p><br></p></span></td>
			<td valign="bottom" align="right"><b><a href="/board/?id=goods_review" hrefOri='L2JvYXJkLz9pZD1nb29kc19yZXZpZXc=' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design/cscenter_btn_more.gif" designImgSrcOri='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduL2NzY2VudGVyX2J0bl9tb3JlLmdpZg==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduL2NzY2VudGVyX2J0bl9tb3JlLmdpZg==' designElement='image' /></a></b></td>
		</tr>
	</table>
	</div>

	<br style="line-height:10px;" />

	<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr >
<?php if(is_array($TPL_R1=getBoardData('goods_review','2',null,null,'80','200','ID','HID','IMG',array('image_w=80','image_h=80')))&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
<?php if(($TPL_I1+ 1)== 1){?><tr class="normal_bbslist"><?php }?>
			<td width="50%" valign="top" class="sbj"><table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
				<tr><td height="6"></td></tr>
				<tr>
					<td align="left">
<?php if($TPL_V1["goodsInfo"]){?><a href="<?php echo $TPL_V1["wigetboardurl_view"]?>" target="" hrefOri='ey53aWdldGJvYXJkdXJsX3ZpZXd9' ><?php echo $TPL_V1["goodsInfo"]["goods_name"]?> </a><br/><?php }?>
							<?php echo $TPL_V1["subject"]?> <?php echo $TPL_V1["iconnew"]?> <?php echo $TPL_V1["iconhot"]?> <?php echo $TPL_V1["iconfile"]?> <?php echo $TPL_V1["iconhidden"]?>

					</td>
				</tr>
				</table>
			</td>
<?php if(($TPL_I1+ 1)!= 0&&(($TPL_I1+ 1)% 2)== 0){?></tr><tr  class="normal_bbslist"><?php }?>
<?php }}?>
		</tr>
		<tr>
			<td height="30"></td>
		</tr>
	</table>
</div>
<!-- 상품후기  최근글 end -->
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
    <h3 class="title1"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" >WEEKLY RANKING</span></h3>
  </div>
  <div class="show_display_col4" data-effect="scale">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10172)?>

  </div>
</div>


<!-- //BEST PRODUCTS -->


<div class="resp_wrap">
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" >브레이브콩즈 NFT PROJECT</span></h3>
    <p class="text2" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" >메타콩즈가 용감한형제의 프로듀싱으로 다시 태어납니다.</p>
  </div>
  <div class="main_bnr_type2" style="margin-top:0px;">
      <ul data-effect="scale">
          <li style="text-align: center">
              <a href="#none" target='_self' hrefOri='I25vbmU=' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/bravekongz_img01.jpg" title="" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2JyYXZla29uZ3pfaW1nMDEuanBn' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvYnJhdmVrb25nel9pbWcwMS5qcGc=' designElement='image' /></a>
          </li>

      </ul>
  </div>
</div>


<div class="full_bnr" style="margin-top: 0px; padding:0px;">
  <div class="respBnrGon respBnrGon_num2_typeA">
    <div class="title_group1">
      <h3 class="title1"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" >#슈스스스</span></h3>
    </div>
    <ul>
      <li>
        <a href="#none" class="roll" hrefOri='I25vbmU=' >
          <!-- <p style="text-align: left; margin-bottom: 5px;">뮤직브로 기획전 상품 20% 할인</p> -->
          <h2 style="text-align:left; font-weight: bold; margin-bottom: 15px; font-size: 40px;">Best Collection</h2>
          <img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/john-vicente-NmaFcajjlMw-unsplash.jpg" alt="배너 01" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2pvaG4tdmljZW50ZS1ObWFGY2FqamxNdy11bnNwbGFzaC5qcGc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3Avam9obi12aWNlbnRlLU5tYUZjYWpqbE13LXVuc3BsYXNoLmpwZw==' designElement='image' />
        </a>
      </li>
  <!--    <li>
        <a href="#none" class="roll" hrefOri='I25vbmU=' >
          <p style="text-align: left; margin-bottom: 5px;">뮤직브로 기획전 상품 20% 할인</p>
          <h2 style="text-align:left; font-weight: bold; margin-bottom: 15px; font-size: 40px;">Best Collection</h2>
          <img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/khalid-boutchich-zMTDK9p2QyQ-unsplash.jpg" alt="배너 02" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2toYWxpZC1ib3V0Y2hpY2gtek1UREs5cDJReVEtdW5zcGxhc2guanBn' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3Ava2hhbGlkLWJvdXRjaGljaC16TVRESzlwMlF5US11bnNwbGFzaC5qcGc=' designElement='image' />
        </a>
      </li> -->
      <li>
        <a href="#none" class="roll" hrefOri='I25vbmU=' >
          <a href='#none' target='_self' hrefOri='I25vbmU=' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/sama-hosseini-WUru1jV4ix8-unsplash.jpg" title="배너 02" alt="배너 02" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL3NhbWEtaG9zc2VpbmktV1VydTFqVjRpeDgtdW5zcGxhc2guanBn' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3Avc2FtYS1ob3NzZWluaS1XVXJ1MWpWNGl4OC11bnNwbGFzaC5qcGc=' designElement='image' /></a>
          <!-- <p style="text-align: left; margin-top: 15px;">뮤직브로 기획전 상품 20% 할인</p> -->
          <h2 style="text-align:left; font-weight: bold; font-size: 40px;">Best Collection</h2>
        </a>
      </li>
    </ul>
  </div>
</div>
<!-- //full_bnr (이미지 배너) -->


<!-- 슬라이드 배너 영역 (light_style_1_3) :: END -->
<div class="main_bnr_type2">
    <ul data-effect="scale">
        <li>
            <a href="#none" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/middle_music_banner01.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21pZGRsZV9tdXNpY19iYW5uZXIwMS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvbWlkZGxlX211c2ljX2Jhbm5lcjAxLnBuZw==' designElement='image' /></a>
        </li>
        <li>
            <a href="#none" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/middle_luxury_banner01.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21pZGRsZV9sdXh1cnlfYmFubmVyMDEucG5n' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvbWlkZGxlX2x1eHVyeV9iYW5uZXIwMS5wbmc=' designElement='image' /></a>
        </li>
    </ul>
</div>
<!-- //2단 이미지 배너 -->


<div class="resp_wrap main_bnr3">
    <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" >기획전</span></h3>
  </div>
  <div class="respBnrGon respBnrGon_num3_typeB">
    <ul data-effect="scale">
      <li><a href="#" hrefOri='Iw==' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/main_middle_img03.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbWlkZGxlX2ltZzAzLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvbWFpbl9taWRkbGVfaW1nMDMucG5n' designElement='image' /></a></li>
      <li><a href="#" hrefOri='Iw==' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/main_middle_img01.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbWlkZGxlX2ltZzAxLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvbWFpbl9taWRkbGVfaW1nMDEucG5n' designElement='image' /></a></li>
      <li><a href="#" hrefOri='Iw==' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/main_middle_img02.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fbWlkZGxlX2ltZzAyLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvbWFpbl9taWRkbGVfaW1nMDIucG5n' designElement='image' /></a></li>
    </ul>
  </div>
</div>
<!-- //이미지 배너 (EVENT) -->



<div class="main_bnr_type3 respBnrGon respBnrGon_num3_typeE">
  <ul data-effect="rotate_01">
    <li><a href="#none" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/main_bottom_banner01.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fYm90dG9tX2Jhbm5lcjAxLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvbWFpbl9ib3R0b21fYmFubmVyMDEucG5n' designElement='image' /></a></li>
    <li><a href="#none" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/main_bottom_banner02.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fYm90dG9tX2Jhbm5lcjAyLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvbWFpbl9ib3R0b21fYmFubmVyMDIucG5n' designElement='image' /></a></li>
    <li><a href="#none" hrefOri='I25vbmU=' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/main_bottom_banner03.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL21haW5fYm90dG9tX2Jhbm5lcjAzLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvbWFpbl9ib3R0b21fYmFubmVyMDMucG5n' designElement='image' /></a></li>
  </ul>
</div>
<!-- //3단 이미지 배너 -->
<div class="resp_wrap"> 
  <div class="title_group1">
    <h3 class="title1"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" >BRAND PICK ITEM</span></h3>
  </div>
  <div class="show_display_col4">
    <?php echo setTemplatePath('main/index.html')?><?php echo showDesignDisplay( 10171)?>

  </div>
</div>

<!-- //NEW ARRIVALS -->

<!-- =====================================================
  백그라운드 이미지로 처리되어 있습니다. 
  배너 이미지를 변경하려면 아래 경로( '[스킨폴더]/images/design_resp/' )의 이미지를 업로드하여 바꾸기 바랍니다.
  이미지 사이즈 : 1920 * 1500 (권장)
  ===================================================== -->
<div class="full_bnr" style="background-image:url('/data/skin/responsive_sports_sporti_gl_1/images/design_resp/bottom_img01.jpg');">
    <ul class="text_wrap">          
        <li class="text1"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" >GLOBAL K-POP PLATFORM MUSICBRO</span></li>
        <li class="text2"><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" >전 세계 K-POP 팬들을 위한 놀이터 뮤직브로 </span></li>
        <li class="sbtn"><a href="#none" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" hrefOri='I25vbmU=' >read more</a></li>        
    </ul>
</div>
<!-- //패럴렉스 배너 -->

<div class="resp_wrap"> 
  <div class="title_group1">
    <h3 class="title1"><a href="/board/?id=custom_bbs2" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" hrefOri='L2JvYXJkLz9pZD1jdXN0b21fYmJzMg==' >NEW BRAND INTRODUCTION</a></h3>
  </div>
  <div id="mainStoryList" class="board_gallery" designElement='displaylastest' templatePath='bWFpbi9pbmRleC5odG1s'>
    <ul>
<?php if(is_array($TPL_R1=getBoardData('custom_bbs2','3',null,null,'17','60','ID','HID','IMG',array('orderby=gid asc','','rdate_s=','rdate_f=','auto_term=','image_w=406','image_h=')))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
      <li class="board_gallery_li">
        <div class="item_img_area">
          <a href="<?php echo $TPL_V1["wigetboardurl_view"]?>" hrefOri='ey53aWdldGJvYXJkdXJsX3ZpZXd9' ><img src="<?php echo $TPL_V1["filelist"]?>" alt="" designImgSrcOri='ey5maWxlbGlzdH0=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='ey5maWxlbGlzdH0=' designElement='image' /></a>
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

<!-- 20220328 ~ 랭킹 관련 작업 by 김혜진 -->

<div class="resp_wrap">
    <div class="title_group1">
        <h3 class="title1"><a href="" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" hrefOri='' >RANK</a></h3>
    </div>
<!--      <div class="item_img_area">
        올해 방문자 TOP
        <table>
            <tr>
                <th>순위</th>
                <td>닉네임</td>
            </tr>
<?php if($TPL_VAR["year"]){?>
<?php if($TPL_year_1){foreach($TPL_VAR["year"] as $TPL_V1){?>
            <tr>
                <th><?php echo $TPL_V1["id"]?></th>
                <td><?php echo $TPL_V1["user_name"]?></td>
            </tr>
<?php }}?>
<?php }else{?>
<?php }?>
        </table>
    </div> -->
    <div class="item_img_area">
        이번달 방문자 TOP
        <table>
            <tr>
                <th>순위</th>
                <td>닉네임</td>
            </tr>
<?php if($TPL_VAR["month"]){?>
<?php if($TPL_month_1){foreach($TPL_VAR["month"] as $TPL_V1){?>
                    <tr>
                        <th><?php echo $TPL_V1["id"]?></th>
                        <td><?php echo $TPL_V1["userid"]?></td>
                    </tr>
<?php }}?>
<?php }else{?>
<?php }?>
        </table>
    </div>
    <div class="item_img_area">
        오늘 방문자 TOP
        <table>
            <tr>
                <th>순위</th>
                <td>닉네임</td>
            </tr>
<?php if($TPL_VAR["today"]){?>
<?php if($TPL_today_1){foreach($TPL_VAR["today"] as $TPL_V1){?>
            <tr>
                <th><?php echo $TPL_V1["id"]?></th>
                <td><?php echo $TPL_V1["userid"]?></td>
            </tr>
<?php }}?>
<?php }else{?>
<?php }?>
        </table>
    </div>

</div>

<div class="resp_wrap">
<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'&&$TPL_VAR["sns"]["ntalk_use"]=='Y'&&$TPL_VAR["sns"]["ntalk_use_mobile_main"]=='Y'){?>
  <!-- 네이버 톡톡 -->
  <div class="btn_talk_area">
    <button type="button" class="btn_talk v2" onclick="location.href='https://talk.naver.com/<?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?>#nafullscreen';"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" >쇼핑할땐</span> &nbsp;<img src="/data/skin/responsive_sports_sporti_gl_1/images/icon/icon_talk.png" class="talk_img" alt="네이버톡톡" designImgSrcOri='Li4vaW1hZ2VzL2ljb24vaWNvbl90YWxrLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvaWNvbi9pY29uX3RhbGsucG5n' designElement='image' />&nbsp; <span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWFpbi9pbmRleC5odG1s" >톡톡하세요</span></button>
  </div>
<?php }?>
</div>