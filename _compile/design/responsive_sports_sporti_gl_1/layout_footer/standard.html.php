<?php /* Template_ 2.2.6 2022/04/04 17:28:55 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/layout_footer/standard.html 000017195 */  $this->include_("confirmLicenseLink","escrow_mark");
$TPL_bank_loop_1=empty($TPL_VAR["bank_loop"])||!is_array($TPL_VAR["bank_loop"])?0:count($TPL_VAR["bank_loop"]);
$TPL_dataRightQuicklist_1=empty($TPL_VAR["dataRightQuicklist"])||!is_array($TPL_VAR["dataRightQuicklist"])?0:count($TPL_VAR["dataRightQuicklist"]);?>
<style type="text/css">
    .kakao_chat_icon{position: fixed; right: 20px; bottom: 20px; width: 50px; z-index:9999;}
  /*.kakao_chat_icon{animation-duration: 2s; animation-name: kakao; animation-iteration-count: infinite;}*/
  .ico_floating_recently{display: none;}
  .delay_text{display: none; position: absolute; right: 0; top: -20px; width: 500%; background: black; color: white; padding: 5px;}
  .kakao_chat_icon:hover .delay_text{display: block;}
  .escrow>img{display: none; width: 50px;}
  .layout_footer .escrow{position: relative; top: auto; right: auto; margin-top: 10px;}

   @keyframes kakao {
	  50%{opacity: 0.2;}

	}
</style>


<div class="kakao_chat_icon">
	<p>문의하기</p>
  	<a href="https://pf.kakao.com/_QjdiK" target="_blank" hrefOri='aHR0cHM6Ly9wZi5rYWthby5jb20vX1FqZGlL' >
    	<img src="/data/skin/responsive_sports_sporti_gl_1/images/kakao_chat.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2tha2FvX2NoYXQucG5n' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMva2FrYW9fY2hhdC5wbmc=' designElement='image' >
  	</a>
  	<p class="delay_text">문의량이 많아 답변이 다소 늦을 수 있습니다.(평균 3시간)</p>
</div>


<div id="layout_footer" class="layout_footer" style="margin-top: 0px;">
	<div class="footer_b">
		<div class="resp_wrap">
			<ul class="menu2">
				<li><a href="/service/company" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" hrefOri='L3NlcnZpY2UvY29tcGFueQ==' >COMPANY</a></li>
				<li><a href="/service/agreement" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" hrefOri='L3NlcnZpY2UvYWdyZWVtZW50' >AGREEMENT</a></li>
				<li class="bold"><a href="/service/privacy" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" hrefOri='L3NlcnZpY2UvcHJpdmFjeQ==' >PRIVACY POLICY</a></li>
                <li><a href="/service/guide" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" hrefOri='L3NlcnZpY2UvZ3VpZGU=' >SHOP GUIDE</a></li>
                <li><a href="/service/partnership" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" hrefOri='L3NlcnZpY2UvcGFydG5lcnNoaXA=' >PARTNERSHIP</a></li>
			</ul>
		</div>
	</div>
	<div class="footer_a">
		<div class="resp_wrap">
			<ul class="menu1">
			<!-- 	<li>
					<span designElement="text">CUSTOMER CENTER</span>
					<a href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>" class="pcolor phone" hrefOri='dGVsOntjb25maWdfYmFzaWMuY29tcGFueVBob25lfQ==' ><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a>
				</li> -->
				<li>
					<span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >MON-FRI</span>
					<span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s"  class="pcolor">AM 10:30 - PM 06:00</span>
				</li>
				<li>
					<span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >LUNCH</span>
					<span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s"  class="pcolor">PM 12:30 - PM 02:00 (SAT, SUN, HOLIDAY CLOSED)</span>
				</li>
				<li>
					<span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >BANK INFO</span>
<?php if($TPL_bank_loop_1){foreach($TPL_VAR["bank_loop"] as $TPL_V1){?>
					<span class="pcolor mr20"><?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["account"]?></span>
                    <span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >HOLDER</span> <span class="pcolor"><?php echo $TPL_V1["bankUser"]?></span>
<?php }}?>
				</li>
			</ul>
		</div>
	</div>
	<div class="footer_c">
		<div class="resp_wrap">
			<ul class="menu3">
				<li><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >COMPANY</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyName"]?></span></li>
				<li><span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >OWNER</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["ceo"]?> </span></li>
				<li><span designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >ADDRESS</span> <span class="pcolor"><?php if($TPL_VAR["config_basic"]["companyAddress_type"]=="street"){?><?php echo $TPL_VAR["config_basic"]["companyAddress_street"]?><?php }else{?><?php echo $TPL_VAR["config_basic"]["companyAddress"]?><?php }?> <?php echo $TPL_VAR["config_basic"]["companyAddressDetail"]?></span></li>
				<li><span designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >TEL</span> <a href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>" class="pcolor" hrefOri='dGVsOntjb25maWdfYmFzaWMuY29tcGFueVBob25lfQ==' ><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a></li>
<?php if($TPL_VAR["config_basic"]["companyFax"]){?>
				<!-- <li><span designElement="text">FAX</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyFax"]?></span></li> -->
<?php }?>
				<li><span designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >BUSINESS LICENCE</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["businessLicense"]?> <?php echo confirmLicenseLink("[사업자정보확인]")?></span></li>
				<li><span designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >MAIL-ORDER LICENSE</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["mailsellingLicense"]?></span></li>
				<li><span designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >대표메일</span> <span class="pcolor"> <a class="pcolor ml0" href="mailto:<?php echo $TPL_VAR["config_basic"]["companyEmail"]?>" hrefOri='bWFpbHRvOntjb25maWdfYmFzaWMuY29tcGFueUVtYWlsfQ==' ><?php echo $TPL_VAR["config_basic"]["companyEmail"]?></a>&nbsp;</span></li>
				<!-- <li><span designElement="text">HOSTING PROVIDER</span> <span class="pcolor">(주)가비아씨엔에스</span></li> -->
			</ul>
			<p class="copyright" designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >COPYRIGHT (c) <?php echo $TPL_VAR["config_basic"]["companyName"]?>&nbsp; ALL RIGHTS RESERVED.</p>
			
			<ul class="social">
				<li><a title="페이스북" href="/" hrefOri='Lw==' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/ico_facebook.png" alt="페이스북" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2ljb19mYWNlYm9vay5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvaWNvX2ZhY2Vib29rLnBuZw==' designElement='image' ></a></li>
				<li><a title="트위터" href="/" hrefOri='Lw==' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/ico_twitter.png" alt="트위터" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2ljb190d2l0dGVyLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvaWNvX3R3aXR0ZXIucG5n' designElement='image' ></a></li>
				<li><a title="인스타그램" href="/" hrefOri='Lw==' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/ico_instagram.png" alt="인스타그램" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2ljb19pbnN0YWdyYW0ucG5n' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvaWNvX2luc3RhZ3JhbS5wbmc=' designElement='image' ></a></li>
				<li><a title="네이버블로그" href="/" hrefOri='Lw==' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/ico_naverblog.png" alt="네이버블로그" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2ljb19uYXZlcmJsb2cucG5n' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvaWNvX25hdmVyYmxvZy5wbmc=' designElement='image' ></a></li>
				<li><a title="카카오스토리" href="/" hrefOri='Lw==' ><img src="/data/skin/responsive_sports_sporti_gl_1/images/design_resp/ico_kakaostory.png" alt="카카오스토리" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbl9yZXNwL2ljb19rYWthb3N0b3J5LnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduX3Jlc3AvaWNvX2tha2Fvc3RvcnkucG5n' designElement='image' ></a></li>
			</ul>
			<div class="escrow" >
				<?php echo escrow_mark( 60)?>

				<img src="/data/icon/escrow_mark/kicc.png" style="cursor:pointer; display: block;" onclick="f_escrowKicc();" designImgSrcOri='L2RhdGEvaWNvbi9lc2Nyb3dfbWFyay9raWNjLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvaWNvbi9lc2Nyb3dfbWFyay9raWNjLnBuZw==' designElement='image' >
			</div>
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
	<a href="javascript:history.back();" class="ico_floating_back" title="뒤로 가기" hrefOri='amF2YXNjcmlwdDpoaXN0b3J5LmJhY2soKTs=' >back</a>
	<a href="javascript:history.forward();" class="ico_floating_foward" title="앞으로 가기" hrefOri='amF2YXNjcmlwdDpoaXN0b3J5LmZvcndhcmQoKTs=' >forward</a>
	<a href="#none" onclick="$('html,body').animate({scrollTop:0},'slow');" class="ico_floating_top" title="위로 가기" hrefOri='I25vbmU=' >top</a>
<?php if((preg_match('/main\/index/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/catalog/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/brand/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/location/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/search/',$_SERVER["REQUEST_URI"])||preg_match('/bigdata\/catalog/',$_SERVER["REQUEST_URI"]))&&$TPL_VAR["dataRightQuicklist"]&&!preg_match('/goods\/view/',$_SERVER["REQUEST_URI"])){?>
<?php if($TPL_VAR["push_count_today_images"]){?><a href="javascript:;" class="ico_floating_recently" hrefOri='amF2YXNjcmlwdDo7' ><span designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >최근본</span><br /><img src="<?php echo $TPL_VAR["push_count_today_images"]?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl_1/images/common/noimage.gif'" designImgSrcOri='e3B1c2hfY291bnRfdG9kYXlfaW1hZ2VzfQ==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='e3B1c2hfY291bnRfdG9kYXlfaW1hZ2VzfQ==' designElement='image' ></a><?php }?>
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
								<li><a href="../goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" class="right_quick_goods" hrefOri='Li4vZ29vZHMvdmlldz9ubz17Lmdvb2RzX3NlcX0=' ><img src="<?php echo $TPL_V1["image"]?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl_1/images/common/noimage_list.gif'" alt="<?php echo $TPL_V1["goods_name"]?>" designImgSrcOri='ey5pbWFnZX0=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='ey5pbWFnZX0=' designElement='image' ></a><a href="javascript:rightDeleteItem('mobile_bottom_item_recent', '<?php echo $TPL_V1["goods_seq"]?>',$(this))" class="btn_delete cover" hrefOri='amF2YXNjcmlwdDpyaWdodERlbGV0ZUl0ZW0o' >삭제</a></li>
<?php }?>
<?php }}?>
						</ul>
<?php }else{?>
						<h2> 최근 본 상품이 없습니다.</h2>
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