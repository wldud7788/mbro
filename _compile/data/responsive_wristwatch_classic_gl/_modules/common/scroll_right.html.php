<?php /* Template_ 2.2.6 2021/12/15 17:04:30 /www/music_brother_firstmall_kr/data/skin/responsive_wristwatch_classic_gl/_modules/common/scroll_right.html 000007925 */  $this->include_("dataGoodsToday");
$TPL_bank_loop_1=empty($TPL_VAR["bank_loop"])||!is_array($TPL_VAR["bank_loop"])?0:count($TPL_VAR["bank_loop"]);?>
<div id="rightQuickMenuWrap" class="rightQuickMenuWrap2" style="right:-220px;">	
	<a href="javascript:void(0);" class="rightQuick_close"><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/right_quick_close.png" alt="close" /></a>
	<a href="javascript:void(0);" class="rightQuick_open"><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/right_quick_open.png" alt="open" /></a>
    <!-- //열고 & 닫기 -->
	
	<div class="rightQuickMenu2">
		<a href="javascript:void(0);" onclick="$('html,body').animate({scrollTop:0},'slow');" title="to Top"><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/btn_quick_top.png" alt="TOP" /></a>
		<a href="javascript:void(0);" onclick="$('html,body').animate({scrollTop:$(document).height()},'slow');" title="to Bottom"><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/btn_quick_btm.png" alt="BOTTOM" /></a>
	</div>
    <!-- //to top & to bottom -->

	<div class="right_wrap">
		<div id="rightQuickMenu" class="rightQuickMenu">
			<div class="right_item_recent">
				<div class="right_itemList">
					<h3><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >TODAY VIEW</span> <span id="right_recent_total"><?php echo number_format(count(dataGoodsToday()))?></span></h3>
					<ul></ul>
					<div id="right_page_div" class="right_quick_paging">
						<a href="javascript:void(0);" class="right_quick_btn_prev"><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/right_quick_menu_left_icon.png" alt="prev" /></a>
						<div class="right_page_box"><span class="right_quick_current_page bold"></span><span class="right_quick_separation">/</span><span class="right_quick_total_page"></span></div>
						<a href="javascript:void(0);" class="right_quick_btn_next"><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/right_quick_menu_right_icon.png" alt="next" /></a>
					</div>
				</div>
			</div>
			<!-- //최근본상품 -->
		</div>

		<h3><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >CS CENTER</span></h3>
		<ul class="right_menu1">
			<li class="phone"><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></li>
			<li><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >PHONE : AM 09:00 ~ PM 06:00</span></li>
			<li><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >LUNCH : PM 12:00 ~ PM 01:00</span></li>
			<li><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >SAT, SUN, HOLIDAY OFF</span></li>
		</ul>
		<!-- //고객센터 -->

		<h3><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >BANK INFO</span></h3>
		<ul class="bank_info">
<?php if($TPL_bank_loop_1){foreach($TPL_VAR["bank_loop"] as $TPL_V1){?>
			<li>
				<?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["account"]?><br />
				<span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >HOLDER</span> : <?php echo $TPL_V1["bankUser"]?><br />
			</li>
<?php }}?>
		</ul>
		<!-- //무통장 입금계좌 -->
        
        <h3><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >COMMUNITY</span></h3>
        <ul class="right_menu1">
            <li><a href="/board/?id=notice" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >NOTICE</a></li>
            <li><a href="/board/?id=faq" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >FAQ</a></li>
            <li><a href="/board/?id=goods_qna" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >Q&amp;A</a></li>
            <li><a href="/board/?id=goods_review" designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >REVIEW</a></li>
<?php if($TPL_VAR["isplusfreenot"]){?><li><a href="/board/?id=bulkorder" designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >BULKORDER</a></li><?php }?>
        </ul>
        <!-- //회사 링크 -->

		<h3><span designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV93cmlzdHdhdGNoX2NsYXNzaWNfZ2wvX21vZHVsZXMvY29tbW9uL3Njcm9sbF9yaWdodC5odG1s" >SOCIAL NETWORK</span></h3>
		<ul class="social_list">
			<li><a title="페이스북" href="/"><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/icon_facebook.png" alt="페이스북"></a></li>
			<li><a title="트위터" href="/"><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/icon_twitter.png" alt="트위터"></a></li>
			<li><a title="인스타그램" href="/"><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/icon_instagram.png" alt="인스타그램"></a></li>
			<li><a title="네이버블로그" href="/"><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/icon_naverblog.png" alt="네이버블로그"></a></li>
			<li><a title="카카오스토리" href="/"><img src="/data/skin/responsive_wristwatch_classic_gl/images/design_resp/icon_kakaostory.png" alt="카카오스토리"></a></li>
		</ul>
        <!-- //SNS -->

<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'&&$TPL_VAR["sns"]["ntalk_use"]=='Y'&&$TPL_VAR["sns"]["ntalk_use_web_quick"]=='Y'){?>
		<a href="javascript:;" class="btn_navertalk" onclick="window.open('https://talk.naver.com/<?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?>', 'talktalk', 'width=471, height=640');return false;"><img src="/data/skin/responsive_wristwatch_classic_gl/images/icon/icon_talk.png" alt="네이버 톡톡" />&nbsp; 톡톡</a>
		<!-- //네이버 톡톡 연동 -->
<?php }?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$set_right_recent = 1;	 /* 최근 본상품 설정 */
		$set_right_recomm = 5;   /* 추천상품 설정 */
		$set_right_cart = 5;		 /* 장바구니 설정 */
		$set_right_wish = 5;		/* 위시리스트 설정 */

		/* 사이드바 슬라이드 */
        $(".rightQuick_open").click(function() {
			$.cookie('rightQuickMenuWrapClosed',1,{path:'/'});
			rightQuickMenuOpen();
		});
		if($.cookie('rightQuickMenuWrapClosed')){
			rightQuickMenuOpen();
		}	
		$(".rightQuick_close").click(function() {
			$.cookie('rightQuickMenuWrapClosed',null,{path:'/'});
			rightQuickMenuClose();
		})			
	});
	/* 열기 */
	function rightQuickMenuOpen(){		
		$(".rightQuickMenuWrap2").stop().animate({'right':'0'}, 400);
		$(".rightQuick_open").hide();
		$(".rightQuick_close").show();
	}
	/* 닫기 */
	function rightQuickMenuClose(){		
		$(".rightQuickMenuWrap2").stop().animate({'right':'-220px'}, 400);
		$(".rightQuick_open").show();
		$(".rightQuick_close").hide();
	}
</script>