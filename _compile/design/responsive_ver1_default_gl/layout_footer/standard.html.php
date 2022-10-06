<?php /* Template_ 2.2.6 2022/03/14 17:22:22 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/layout_footer/standard.html 000016134 */  $this->include_("confirmLicenseLink","escrow_mark");
$TPL_bank_loop_1=empty($TPL_VAR["bank_loop"])||!is_array($TPL_VAR["bank_loop"])?0:count($TPL_VAR["bank_loop"]);
$TPL_dataRightQuicklist_1=empty($TPL_VAR["dataRightQuicklist"])||!is_array($TPL_VAR["dataRightQuicklist"])?0:count($TPL_VAR["dataRightQuicklist"]);?>
<div id="layout_footer" class="layout_footer">

	<div class="footer_a" <?php if(preg_match('/goods\/view/',$_SERVER["REQUEST_URI"])){?>style="display:none;"<?php }?>>
		<div class="resp_wrap">
			<ul class="menu1">
		<!-- 		<li class="foot_menu_d1 cs">
					<h4 class="title"><a href="/service/cs" designElement="text" hrefOri='L3NlcnZpY2UvY3M=' >CS CENTER</a></h4>
					<ul class="list v4">
						<li class="compay_phone">
							<a href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>" hrefOri='dGVsOntjb25maWdfYmFzaWMuY29tcGFueVBob25lfQ==' ><img src="/data/skin/responsive_ver1_default_gl/images/common/icon_call_02.png" class="img_call" alt="" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9pY29uX2NhbGxfMDIucG5n' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvY29tbW9uL2ljb25fY2FsbF8wMi5wbmc=' designElement='image' /><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a>
						</li>
						<li class="compay_phone">
							<a href="../mypage/myqna_catalog" hrefOri='Li4vbXlwYWdlL215cW5hX2NhdGFsb2c=' >1:1 문의 바로가기</a>
						</li>
						<li><span designElement="text">open : am 10:00 ~ pm 06:00 / Sat, Sun, Holiday OFF</span></li>
						<li class="Pt2"><a href="mailto:<?php echo $TPL_VAR["config_basic"]["companyEmail"]?>" hrefOri='bWFpbHRvOntjb25maWdfYmFzaWMuY29tcGFueUVtYWlsfQ==' ><?php echo $TPL_VAR["config_basic"]["companyEmail"]?></a></li>
					</ul>
				</li> -->
				<li class="foot_menu_d2 bank">
					<h4 class="title"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >BANK INFO</span></h4>
					<ul class="list v3 gray_03">
<?php if($TPL_bank_loop_1){foreach($TPL_VAR["bank_loop"] as $TPL_V1){?>
						<li>
							<p><?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["account"]?></p>
							<p><span class="gray_06" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >예금주 :</span> <?php echo $TPL_V1["bankUser"]?></p>
						</li>
<?php }}?>
					</ul>
				</li>
				<li class="foot_menu_d3 guide">
					<h4 class="title"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >SHOP MENU</span></h4>
					<ul class="list v2 clearbox">
						<li>
							<a href="/mypage/index" hrefOri='L215cGFnZS9pbmRleA==' ><img src="/data/skin/responsive_ver1_default_gl/images/common/menu_guide_03.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9tZW51X2d1aWRlXzAzLnBuZw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvY29tbW9uL21lbnVfZ3VpZGVfMDMucG5n' designElement='image' /></a>
							<p class="desc" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >MYPAGE</p>
						</li>
						<li>
							<a href="/order/cart" hrefOri='L29yZGVyL2NhcnQ=' ><img src="/data/skin/responsive_ver1_default_gl/images/common/menu_guide_04.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9tZW51X2d1aWRlXzA0LnBuZw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvY29tbW9uL21lbnVfZ3VpZGVfMDQucG5n' designElement='image' /></a>
							<p class="desc" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >CART</p>
						</li>
						<!-- <li>
							<a href="/service/cs" hrefOri='L3NlcnZpY2UvY3M=' ><img src="/data/skin/responsive_ver1_default_gl/images/common/menu_guide_01.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9tZW51X2d1aWRlXzAxLnBuZw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvY29tbW9uL21lbnVfZ3VpZGVfMDEucG5n' designElement='image' /></a>
							<p class="desc" designElement="text">CS CENTER</p>
						</li> -->
						<li>
							<a href="/promotion/event" hrefOri='L3Byb21vdGlvbi9ldmVudA==' ><img src="/data/skin/responsive_ver1_default_gl/images/common/menu_guide_02.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9tZW51X2d1aWRlXzAyLnBuZw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvY29tbW9uL21lbnVfZ3VpZGVfMDIucG5n' designElement='image' /></a>
							<p class="desc" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >EVENT</p>
						</li>
					</ul>
				</li>
		<!-- 		<li class="foot_menu_d4 delivery">
					<h4 class="title"><span designElement="text">DELIVERY INFO</span></h4>
					<ul class="list v5">
						<li><span designElement="text">반품주소 :</span> (<?php echo $TPL_VAR["refund_address"]["address_zipcode"]?>)<?php if($TPL_VAR["refund_address"]["address_type"]=="street"){?><?php echo $TPL_VAR["refund_address"]["address_street"]?><?php }else{?><?php echo $TPL_VAR["refund_address"]["address"]?><?php }?> <?php echo $TPL_VAR["refund_address"]["address_detail"]?></li>
						<li style="text-indent:0; padding-left:0;">
							<span designElement="text">배송조회 : ○○○택배 1588-0000</span>
							<a href="#" target="_blank" title="새창" class="btn_resp size_a" designElement="text" alt="택배사 배송추적 주소를 입력하세요." hrefOri='Iw==' >배송추적</a>
						</li>
					</ul>
				</li> -->
			</ul>
		</div>
	</div>

	<div class="footer_b">
		<div class="resp_wrap">
			<ul class="menu2">
				<li><a href="/" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" hrefOri='Lw==' >HOME</a></li>
				<li><a href="https://mubrothers.com/" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s"  target="_blank" hrefOri='aHR0cHM6Ly9tdWJyb3RoZXJzLmNvbS8=' >COMPANY</a></li>
				<li><a href="/service/agreement" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" hrefOri='L3NlcnZpY2UvYWdyZWVtZW50' >AGREEMENT</a></li>
				<li><a href="/service/privacy" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" hrefOri='L3NlcnZpY2UvcHJpdmFjeQ==' >PRIVACY POLICY</a></li>
			</ul>
		</div>
	</div>

	<div class="footer_c">
		<div class="resp_wrap">
			<ul class="menu3">
				<li><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >회사명 :</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyName"]?></span></li>
				<li><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >대표자 :</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["ceo"]?> </span></li>
				<li><span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >주소 :</span> <span class="pcolor"><?php if($TPL_VAR["config_basic"]["companyAddress_type"]=="street"){?><?php echo $TPL_VAR["config_basic"]["companyAddress_street"]?><?php }else{?><?php echo $TPL_VAR["config_basic"]["companyAddress"]?><?php }?> <?php echo $TPL_VAR["config_basic"]["companyAddressDetail"]?></span></li>
				<li><span designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >대표번호 :</span> <a href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>" class="pcolor" hrefOri='dGVsOntjb25maWdfYmFzaWMuY29tcGFueVBob25lfQ==' ><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a></li>
<?php if($TPL_VAR["config_basic"]["companyFax"]){?>
				<!-- <li><span designElement="text">팩스 :</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyFax"]?></span></li> -->
<?php }?>
				<li><span designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >사업자등록번호 :</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["businessLicense"]?> <?php echo confirmLicenseLink("[사업자정보확인]")?></span></li>
				<li><span designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >통신판매업신고번호 :</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["mailsellingLicense"]?></span></li>
				<li><span designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >개인정보보호책임자 :</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["member_info_manager"]?> <!-- (<a class="pcolor" href="mailto:<?php echo $TPL_VAR["config_basic"]["companyEmail"]?>" hrefOri='bWFpbHRvOntjb25maWdfYmFzaWMuY29tcGFueUVtYWlsfQ==' ><?php echo $TPL_VAR["config_basic"]["companyEmail"]?></a>) --></span></li>
				<li>호스팅 제공자 : <span class="pcolor">(주)가비아씨엔에스</span></li>
                <li>대표이메일 : <span class="pcolor">musicbroooo@gmail.com</span></li>
			</ul>
			<p class="copyright" designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >COPYRIGHT (c) <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyName"]?></span> ALL RIGHTS RESERVED.</p>
			<div class="escrow"><?php echo escrow_mark( 60)?></div>
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
	<a href="javascript:history.back();" class="ico_floating_back" title="뒤로 가기" hrefOri='amF2YXNjcmlwdDpoaXN0b3J5LmJhY2soKTs=' ></a>
	<a href="javascript:history.forward();" class="ico_floating_foward" title="앞으로 가기" hrefOri='amF2YXNjcmlwdDpoaXN0b3J5LmZvcndhcmQoKTs=' ></a>
	<a href="#layout_header" class="ico_floating_top" title="위로 가기" hrefOri='I2xheW91dF9oZWFkZXI=' >TOP</a>
<?php if($TPL_VAR["dataRightQuicklist"]&&!preg_match('/goods\/view/',$_SERVER["REQUEST_URI"])){?>
<?php if($TPL_VAR["push_count_today_images"]){?><a href="javascript:;" class="ico_floating_recently" hrefOri='amF2YXNjcmlwdDo7' ><span designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s" >최근본</span><br /><img src="<?php echo $TPL_VAR["push_count_today_images"]?>" onerror="this.src='/data/skin/responsive_ver1_default_gl/images/common/noimage.gif'" designImgSrcOri='e3B1c2hfY291bnRfdG9kYXlfaW1hZ2VzfQ==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='e3B1c2hfY291bnRfdG9kYXlfaW1hZ2VzfQ==' designElement='image' ></a><?php }?>
<?php }?>

	<!-- 최근 본 상품(LAYER) -->
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
								<li><a href="../goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" class="right_quick_goods" hrefOri='Li4vZ29vZHMvdmlldz9ubz17Lmdvb2RzX3NlcX0=' ><img src="<?php echo $TPL_V1["image"]?>" onerror="this.src='/data/skin/responsive_ver1_default_gl/images/common/noimage_list.gif'" alt="<?php echo $TPL_V1["goods_name"]?>" designImgSrcOri='ey5pbWFnZX0=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s' designImgSrc='ey5pbWFnZX0=' designElement='image' ></a><a href="javascript:rightDeleteItem('mobile_bottom_item_recent', '<?php echo $TPL_V1["goods_seq"]?>',$(this))" class="btn_delete cover" hrefOri='amF2YXNjcmlwdDpyaWdodERlbGV0ZUl0ZW0o' >삭제</a></li>
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