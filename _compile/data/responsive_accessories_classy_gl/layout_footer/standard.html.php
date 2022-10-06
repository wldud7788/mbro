<?php /* Template_ 2.2.6 2021/12/15 17:08:34 /www/music_brother_firstmall_kr/data/skin/responsive_accessories_classy_gl/layout_footer/standard.html 000014876 */  $this->include_("confirmLicenseLink","escrow_mark");
$TPL_bank_loop_1=empty($TPL_VAR["bank_loop"])||!is_array($TPL_VAR["bank_loop"])?0:count($TPL_VAR["bank_loop"]);
$TPL_dataRightQuicklist_1=empty($TPL_VAR["dataRightQuicklist"])||!is_array($TPL_VAR["dataRightQuicklist"])?0:count($TPL_VAR["dataRightQuicklist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ #LAYOUT_FOOTER @@
- 파일위치 : [스킨폴더]/layout_footer/standard.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="layout_footer" class="layout_footer">
    <div class="footer_a">
        <div class="resp_wrap">
            <ul class="menu1">
                <li>
                    <h1 class="logo_area">
                        <a href='/main/index'><img src="/data/skin/responsive_accessories_classy_gl/images/design_resp/logo.png" alt="<?php echo $TPL_VAR["config_basic"]["companyName"]?>"></a>
                    </h1>
                    <ul class="menu2">
                        <li><a href="/service/company" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >회사소개</a></li>
                        <li><a href="/service/agreement" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >이용약관</a></li>
                        <li><a href="/service/privacy" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" ><strong>개인정보처리방침</strong></a></li>
                        <li><a href="/service/guide" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >이용안내</a></li>
                        <li><a href="/service/partnership" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >제휴안내</a></li>
                    </ul>
                    <!-- //회사 링크 -->
                    <ul class="list2">
                        <li class="company"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >COMPANY</span> : <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyName"]?></span></li>
                        <li class="ceo"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >CEO</span> : <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["ceo"]?> </span></li>
                        <li class="address"><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >ADDRESS</span> : <span class="pcolor"><?php if($TPL_VAR["config_basic"]["companyAddress_type"]=="street"){?><?php echo $TPL_VAR["config_basic"]["companyAddress_street"]?><?php }else{?><?php echo $TPL_VAR["config_basic"]["companyAddress"]?><?php }?> <?php echo $TPL_VAR["config_basic"]["companyAddressDetail"]?></span></li>
                        <li class="phone"><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >TEL</span> : <a href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>" class="link_f"><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a></li>
<?php if($TPL_VAR["config_basic"]["companyFax"]){?>
                        <li class="fax"><span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >FAX</span> : <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyFax"]?></span></li>
<?php }?>
                        <li class="business_license"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >BUSINESS LICENCE</span> :  <?php echo $TPL_VAR["config_basic"]["businessLicense"]?> &nbsp; &nbsp; <span class="link_f"><?php echo confirmLicenseLink("사업자정보확인")?></span></li>
                        <li class="mailselling_license"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >ONLINE LICENCE</span> : <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["mailsellingLicense"]?></span></li>
                        <li class="member_info_manager"><span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" ><span xss=removed>PRIVACY OFFICER</span></span> : <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["member_info_manager"]?> (<a class="pcolor" href="mailto:<?php echo $TPL_VAR["config_basic"]["companyEmail"]?>"><?php echo $TPL_VAR["config_basic"]["companyEmail"]?></a>)</span></li>
                        <li class="hosting_provider"><span designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >HOSTING PROVIDER</span> : <span class="pcolor">(주)가비아씨엔에스</span></li>
                    </ul>
                    <!-- //회사 정보 -->
					<p class="copyright" designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >COPYRIGHT (c) <strong class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyName"]?></strong>&nbsp; ALL RIGHTS RESERVED.</p>
					<ul class="sns">
						<li><a href="#none"><img src="/data/skin/responsive_accessories_classy_gl/images/design_resp/icon_facebook.png" alt=""></a></li>
						<li><a href="#none"><img src="/data/skin/responsive_accessories_classy_gl/images/design_resp/icon_twitter.png" alt=""></a></li>
						<li><a href="#none"><img src="/data/skin/responsive_accessories_classy_gl/images/design_resp/icon_instagram.png" alt=""></a></li>
						<li><a href="#none"><img src="/data/skin/responsive_accessories_classy_gl/images/design_resp/icon_blog.png" alt=""></a></li>
						<li><a href="#none"><img src="/data/skin/responsive_accessories_classy_gl/images/design_resp/icon_kakao.png" alt=""></a></li>
						<li><a href="#none"><img src="/data/skin/responsive_accessories_classy_gl/images/design_resp/icon_youtube.png" alt=""></a></li>
					</ul>
                </li>
                <li class="sub">
                    <h3 class="title"><span designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >CUSTOMER CENTER</span></h3>
                    <ul class="list">
                        <li class="company_phone">
                            <a href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>"><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a>
                        </li>
                        <li><p designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >MON-FRI : AM 09:00 ~ PM 06:00</p></li>
                        <li><p designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >LUNCH&nbsp; &nbsp; : PM 12:00 ~ PM 01:00</p></li>
						<li><p designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >SAT, SUN, HOLIDAY OFF</p></li>
                    </ul>
                    <!-- //고객센터 -->
                </li>
                <li class="sub">
                    <h3 class="title"><span designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >BANK INFO</span></h3>
                    <ul class="list">
<?php if($TPL_bank_loop_1){foreach($TPL_VAR["bank_loop"] as $TPL_V1){?>
                        <li><p class="bank_info"><?php echo $TPL_V1["bank"]?>&nbsp; <?php echo $TPL_V1["account"]?></p></li>
                        <li><p class="bank_info"><span designElement="text" textIndex="21"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >HOLDER</span> : <?php echo $TPL_V1["bankUser"]?></p></li>
<?php }}?>
                        <li>
                            <p class="escrow"><?php echo escrow_mark( 60)?></p>
                        </li>
                    </ul>
                    <!-- //무통장 입금계좌 -->
                </li>
            </ul>
        </div>
    </div>
</div>

<?php if(preg_match('/goods\/view/',$_SERVER["REQUEST_URI"])){?>
<?php if($TPL_VAR["navercheckout_tpl"]){?>
<div class="pcHideMoShow" style="height:117px;">&nbsp;</div>
<?php }?>
<div class="pcHideMoShow" style="height:80px;">&nbsp;</div>
<?php }?>
<!-- 하단영역 : 끝 -->

<!-- 플로팅 - BACK/TOP(대쉬보드) -->
<div id="floating_over">
	<a href="javascript:history.back();" class="ico_floating_back" title="뒤로 가기"></a>
	<a href="javascript:history.forward();" class="ico_floating_foward" title="앞으로 가기"></a>
	<a href="javascript:void(0);" onclick="$('html,body').animate({scrollTop:0},'slow');" class="ico_floating_top" title="위로 가기">TOP</a>
<?php if((preg_match('/main\/index/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/catalog/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/brand/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/location/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/search/',$_SERVER["REQUEST_URI"])||preg_match('/bigdata\/catalog/',$_SERVER["REQUEST_URI"]))&&$TPL_VAR["dataRightQuicklist"]&&!preg_match('/goods\/view/',$_SERVER["REQUEST_URI"])){?>
<?php if($TPL_VAR["push_count_today_images"]){?><a href="javascript:;" class="ico_floating_recently"><span designElement="text" textIndex="22"  textTemplatePath="cmVzcG9uc2l2ZV9hY2Nlc3Nvcmllc19jbGFzc3lfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >최근본</span><br /><img src="<?php echo $TPL_VAR["push_count_today_images"]?>" onerror="this.src='/data/skin/responsive_accessories_classy_gl/images/common/noimage.gif'"></a><?php }?>
<?php }?>

	<!-- 최근 본 상품(LAYER) -->
<?php if((preg_match('/main\/index/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/catalog/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/brand/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/location/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/search/',$_SERVER["REQUEST_URI"])||preg_match('/bigdata\/catalog/',$_SERVER["REQUEST_URI"]))&&$TPL_VAR["dataRightQuicklist"]){?>
	<div id="recently_popup">
		<div class="recently_popup">
			<h1>최근 본 상품</h1>
			<div class="recently_thumb">
				<div id="recently_slide_bottom" style="width:285px; min-height:80px;">
					<div class="thumb">
<?php if($TPL_VAR["dataRightQuicklist"]){?>
						<ul>
<?php if($TPL_dataRightQuicklist_1){$TPL_I1=-1;foreach($TPL_VAR["dataRightQuicklist"] as $TPL_V1){$TPL_I1++;?>
<?php if(($TPL_I1< 40)){?>
<?php if(($TPL_I1&&($TPL_I1% 4)== 0)){?></ul><ul><?php }?>
								<li><a href="../goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" class="right_quick_goods"><img src="<?php echo $TPL_V1["image"]?>" onerror="this.src='/data/skin/responsive_accessories_classy_gl/images/common/noimage_list.gif'" alt="<?php echo $TPL_V1["goods_name"]?>"></a><a href="javascript:rightDeleteItem('mobile_bottom_item_recent', '<?php echo $TPL_V1["goods_seq"]?>',$(this))" class="btn_delete cover">삭제</a></li>
<?php }?>
<?php }}?>
						</ul>
<?php }else{?>
						<h2> 최근 본 상품이 없습니다.</h2>
<?php }?>
					</div>
				</div>
				<div class="recently_page">
					<a href="javascript:;" class="btn_page cover">선택</a>
				</div>
			</div>
			<a href="javascript:;" class="btn_close">모두보기</a>
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
	//				window.webkit.messageHandlers.CSharp.postMessage('GoHome');
<?php }else{?>
					CSharp.postMessage("Logout?");
	//				CSharp.postMessage('GoHome');
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