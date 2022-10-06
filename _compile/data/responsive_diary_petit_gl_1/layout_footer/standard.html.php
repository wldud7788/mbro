<?php /* Template_ 2.2.6 2021/01/08 12:02:07 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/layout_footer/standard.html 000016527 */  $this->include_("escrow_mark","confirmLicenseLink");
$TPL_bank_loop_1=empty($TPL_VAR["bank_loop"])||!is_array($TPL_VAR["bank_loop"])?0:count($TPL_VAR["bank_loop"]);
$TPL_dataRightQuicklist_1=empty($TPL_VAR["dataRightQuicklist"])||!is_array($TPL_VAR["dataRightQuicklist"])?0:count($TPL_VAR["dataRightQuicklist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ #LAYOUT_FOOTER @@
- 파일위치 : [스킨폴더]/layout_footer/standard.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<style>
    .ini_box{margin: 20px auto; max-width: 1260px; padding: 20px 40px 20px 40px; box-sizing: border-box; border-top: 1px solid #ddd;}
    .ini_img{ width: 4%; vertical-align: top;}
    .ini_text_box{display: inline-block; margin-left: 5px;}
    .ini_text_box>p{color: black;}
    .ini_text_box>a{cursor: pointer; padding:3px; background-color: #ADADAD; color: white; margin-top: 3px; border-radius: 5px; display: block; text-align: center;}
    .ini_text_box>a:hover{opacity: 0.7;}

    @media only screen and (max-width:1280px) {
        .ini_img{width: 6%; }
    }
    @media only screen and (max-width:1024px) {
        .ini_img{width: 6%; }
        .ini_box{padding:20px 10px;}
    }
    @media only screen and (max-width:800px) {
        .ini_img{width: 10%; }
    }
</style>
<div id="layout_footer" class="layout_footer">
    <div class="footer_a">
        <div class="resp_wrap">
           <!--  <ul class="menu1">
                <li class="fir">
                    <h4 class="title"><span designElement="text">고객센터</span></h4>
                    <ul>
                         <li><a href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>" class="phone"><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a></li>
                        <li><p designElement="text">상담가능시간 : 오전 10:30 ~ 오후 06:30 / Sat, Sun, Holiday OFF</p></li>
<?php if($TPL_bank_loop_1){foreach($TPL_VAR["bank_loop"] as $TPL_V1){?>
                        <li><?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["account"]?></li>
<?php }}?>
                        <li><a class="pcolor" href="mailto:<?php echo $TPL_VAR["config_basic"]["companyEmail"]?>">상담가능한 메일:<?php echo $TPL_VAR["config_basic"]["companyEmail"]?></a></li>
                    </ul>
                </li>
                <li class="sec">
					<h4 class="title"><span designElement="text">COMMUNITY</span></h4>
					<ul>
						<li><a href="/" designElement="text">Home</a></li>
						<li>
							<a href="/board/?id=notice" designElement="text">Notice</a>
						</li>
						<li>
							<a href="/board/?id=faq" designElement="text">FAQ</a>
						</li>
						<li>
							<a href="/board/?id=goods_qna" designElement="text">Q&amp;A</a>
						</li>
						<li>
							<a href="/board/?id=goods_review" designElement="text">Review</a>
						</li>
					</ul>
                </li>
                <li class="thr">
                    <h4 class="title"><span designElement="text">DELIVERY INFO</span></h4>
                    <ul>
                        <li><a href="#" designElement="text" target="_blank"></a></li>
                        <li><span designElement="text">반송주소: <?php if($TPL_VAR["config_basic"]["companyAddress_type"]=="street"){?><?php echo $TPL_VAR["config_basic"]["companyAddress_street"]?><?php }else{?><?php echo $TPL_VAR["config_basic"]["companyAddress"]?><?php }?> <?php echo $TPL_VAR["config_basic"]["companyAddressDetail"]?></span></li>
                    </ul>
                    <ul class="footer_info">
                        <li><a href="https://mubrothers.com" designElement="text" target="_blank">공식홈페이지</a></li>
						<li><a href="/service/agreement" designElement="text" target="_self">이용약관</a></li>
                        <li><a href="/service/privacy" designElement="text" target="_self"><strong>개인정보처리방침</strong></a></li>
						<li><a href="/service/guide" designElement="text" target="_self">이용안내</a></li>
                    </ul>
                </li>
            </ul> -->
            <div class="escrow"><?php echo escrow_mark( 60)?></div>
        </div>
    </div>
    <div class="footer_b">

        <div class="resp_wrap">
            <ul class="menu1">
                <li>
                    <span class="info_title" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >COMPANY</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyName"]?></span> <span class="info_title" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" ></span><!-- <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["ceo"]?></span>-->
                    <span class="info_title" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >사업장 주소</span>
                    <span class="pcolor"><?php if($TPL_VAR["config_basic"]["companyAddress_type"]=="street"){?><?php echo $TPL_VAR["config_basic"]["companyAddress_street"]?><?php }else{?><?php echo $TPL_VAR["config_basic"]["companyAddress"]?><?php }?> <?php echo $TPL_VAR["config_basic"]["companyAddressDetail"]?></span>
                </li>
                <li>
                    <span class="info_title" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >대표번호/고객센터</span> <a href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>" class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a>
<?php if($TPL_VAR["config_basic"]["companyFax"]){?>
                    <span class="info_title" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >FAX</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyFax"]?></span>
<?php }?>
                    <span class="info_title" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >통신판매업신고번호</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["businessLicense"]?> <?php echo confirmLicenseLink("[사업자정보확인]")?></span> <span class="info_title" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >통신판매업신고번호</span>
                    <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["mailsellingLicense"]?></span>
                </li>
                <li>
                    <span class="info_title" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >대표이사</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["member_info_manager"]?> (<a href="mailto:<?php echo $TPL_VAR["config_basic"]["companyEmail"]?>"><?php echo $TPL_VAR["config_basic"]["companyEmail"]?></a>)</span>
                    <span class="info_title" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >HOSTING PROVIDER</span>
                    <span class="pcolor">(주)가비아씨엔에스</span>
                </li>
            </ul>
            <p class="copyright" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >COPYRIGHT (c) <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyName"]?></span> ALL RIGHTS RESERVED.</p>
            <ul class="footer_info">
                <li><a href="https://mubrothers.com" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA=="  target="_blank">공식홈페이지</a></li>
                <li><a href="/service/agreement" designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA=="  target="_self">이용약관</a></li>
                <li><a href="/service/privacy" designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA=="  target="_self"><strong>개인정보처리방침</strong></a></li>
                <li><a href="/service/guide" designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA=="  target="_self">이용안내</a></li>
                <li><a href="https://musicbroshop.com/page/index?tpl=etc%2Fparter_page.html" designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA=="  target="_self">입점문의</a></li>
            </ul>
        </div>

        <div class="ini_box">
            <div>
                <img class="ini_img" src='/data/skin/responsive_diary_petit_gl_1/images/escrow_74x74_color.png' border="0" alt="클릭하시면 이니시스 결제시스템의 유효성을 확인하실 수 있습니다." >
                <div class="ini_text_box">
                    <p>KG이니시스 구매안전 서비스</p>
                    <a Onclick=javascript:window.open("https://mark.inicis.com/mark/escrow_popup.php?mid=ESGBmusicb","mark","scrollbars=no,resizable=no,width=565,height=683");>서비스 가입사실 확인 +</a>
                </div>
            </div>
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
    <a href="javascript:history.back();" class="ico_floating_back" title="뒤로 가기"></a>
    <a href="javascript:history.forward();" class="ico_floating_foward" title="앞으로 가기"></a>
    <a href="#layout_header" class="ico_floating_top" title="위로 가기"></a>
<?php if((preg_match('/main\/index/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/catalog/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/brand/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/location/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/search/',$_SERVER["REQUEST_URI"])||preg_match('/bigdata\/catalog/',$_SERVER["REQUEST_URI"]))&&$TPL_VAR["dataRightQuicklist"]&&!preg_match('/goods\/view/',$_SERVER["REQUEST_URI"])){?>
<?php if($TPL_VAR["push_count_today_images"]){?><a href="javascript:;" class="ico_floating_recently"><span designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >최근본</span><br /><img src="<?php echo $TPL_VAR["push_count_today_images"]?>" onerror="this.src='/data/skin/responsive_diary_petit_gl_1/images/common/noimage.gif'" /></a><?php }?>
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
                                <a href="../goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" class="right_quick_goods"><img src="<?php echo $TPL_V1["image"]?>" onerror="this.src='/data/skin/responsive_diary_petit_gl_1/images/common/noimage_list.gif'" alt="<?php echo $TPL_V1["goods_name"]?>" /></a
><a href="javascript:rightDeleteItem('mobile_bottom_item_recent', '<?php echo $TPL_V1["goods_seq"]?>',$(this))" class="btn_delete cover">삭제</a>
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