<?php /* Template_ 2.2.6 2021/12/15 16:44:42 /www/music_brother_firstmall_kr/data/skin/responsive_multishop_trendy_gl/layout_footer/standard.html 000017883 */  $this->include_("getBoarddata","confirmLicenseLink","escrow_mark");
$TPL_bank_loop_1=empty($TPL_VAR["bank_loop"])||!is_array($TPL_VAR["bank_loop"])?0:count($TPL_VAR["bank_loop"]);
$TPL_dataRightQuicklist_1=empty($TPL_VAR["dataRightQuicklist"])||!is_array($TPL_VAR["dataRightQuicklist"])?0:count($TPL_VAR["dataRightQuicklist"]);?>
<div id="layout_footer" class="layout_footer">
	<div class="footer_b">
		<div class="resp_wrap">
			<ul class="menu2">
				<li><a href="/" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='Lw==' >HOME</a></li>
				<li><a href="/service/company" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L3NlcnZpY2UvY29tcGFueQ==' >COMPANY</a></li>
				<li><a href="/service/agreement" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L3NlcnZpY2UvYWdyZWVtZW50' >AGREEMENT</a></li>
				<li class="bold"><a href="/service/privacy" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L3NlcnZpY2UvcHJpdmFjeQ==' >PRIVACY POLICY</a></li>
                <li><a href="/service/guide" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L3NlcnZpY2UvZ3VpZGU=' >SHOP GUIDE</a></li>
                <li><a href="/service/partnership" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L3NlcnZpY2UvcGFydG5lcnNoaXA=' >PARTNERSHIP</a></li>
			</ul>
		</div>
	</div>

	<div class="footer_a" <?php if(preg_match('/goods\/view/',$_SERVER["REQUEST_URI"])){?>style="display:none;"<?php }?>>
		<div class="resp_wrap">
			<ul class="menu1">
				<li class="foot_menu_d1 cs">
					<h4 class="title"><a href="/service/cs" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" hrefOri='L3NlcnZpY2UvY3M=' >CS CENTER</a></h4>
					<ul class="list v4">
						<li class="compay_phone">
							<a href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>" hrefOri='dGVsOntjb25maWdfYmFzaWMuY29tcGFueVBob25lfQ==' ><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a>
						</li>
						<li><a href="mailto:<?php echo $TPL_VAR["config_basic"]["companyEmail"]?>" hrefOri='bWFpbHRvOntjb25maWdfYmFzaWMuY29tcGFueUVtYWlsfQ==' ><?php echo $TPL_VAR["config_basic"]["companyEmail"]?></a></li>
						<li><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >mon-fri am 09:00 - pm 06:00<br>lunch pm 12:00 - pm 01:00, sat.sun.holiday - off</span></li>
					</ul>
				</li>
				<li class="foot_menu_d2 bank">
					<h4 class="title"><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >BANK INFO</span></h4>
					<ul class="list v3 gray_03">
<?php if($TPL_bank_loop_1){foreach($TPL_VAR["bank_loop"] as $TPL_V1){?>
						<li>
							<p><?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["account"]?></p>
							<p><span class="gray_06" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >????????? :</span> <?php echo $TPL_V1["bankUser"]?></p>
						</li>
<?php }}?>
					</ul>
				</li>
				<li class="foot_menu_d3 exchange">
					<h4 class="title"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >RETURN / EXCHANGE</span></h4>
					<ul class="list v5">
						<li><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >???????????? :</span> <?php if($TPL_VAR["config_basic"]["companyAddress_type"]=="street"){?><?php echo $TPL_VAR["config_basic"]["companyAddress_street"]?><?php }else{?><?php echo $TPL_VAR["config_basic"]["companyAddress"]?><?php }?> <?php echo $TPL_VAR["config_basic"]["companyAddressDetail"]?></li>
						<li style="text-indent:0; padding-left:0;">
							<span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >???????????? : ??????????????? 1588-0000</span>
							<a href="#" target="_blank" title="??????" class="btn_resp size_a" designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA=="  alt="????????? ???????????? ????????? ???????????????." hrefOri='Iw==' >????????????</a>
						</li>
					</ul>
					<ul class="list v2 clearbox Mt15">
						<li title="???????????????">
							<a href="/mypage/index" hrefOri='L215cGFnZS9pbmRleA==' ><img src="/data/skin/responsive_multishop_trendy_gl/images/common/menu_guide_03.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9tZW51X2d1aWRlXzAzLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX211bHRpc2hvcF90cmVuZHlfZ2wvaW1hZ2VzL2NvbW1vbi9tZW51X2d1aWRlXzAzLnBuZw==' designElement='image' /></a>
						</li>
						<li title="????????????">
							<a href="/order/cart" hrefOri='L29yZGVyL2NhcnQ=' ><img src="/data/skin/responsive_multishop_trendy_gl/images/common/menu_guide_04.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9tZW51X2d1aWRlXzA0LnBuZw==' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX211bHRpc2hvcF90cmVuZHlfZ2wvaW1hZ2VzL2NvbW1vbi9tZW51X2d1aWRlXzA0LnBuZw==' designElement='image' /></a>
						</li>
						<li title="????????????">
							<a href="/service/cs" hrefOri='L3NlcnZpY2UvY3M=' ><img src="/data/skin/responsive_multishop_trendy_gl/images/common/menu_guide_01.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9tZW51X2d1aWRlXzAxLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX211bHRpc2hvcF90cmVuZHlfZ2wvaW1hZ2VzL2NvbW1vbi9tZW51X2d1aWRlXzAxLnBuZw==' designElement='image' /></a>
						</li>
						<li title="?????????">
							<a href="/promotion/event" hrefOri='L3Byb21vdGlvbi9ldmVudA==' ><img src="/data/skin/responsive_multishop_trendy_gl/images/common/menu_guide_02.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9tZW51X2d1aWRlXzAyLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX211bHRpc2hvcF90cmVuZHlfZ2wvaW1hZ2VzL2NvbW1vbi9tZW51X2d1aWRlXzAyLnBuZw==' designElement='image' /></a>
						</li>
					</ul>
				</li>
				<li class="foot_menu_d4 notice">
					<h4 class="title"><span designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >NOTICE</span></h4>
					<div id="footer_notice" designElement='displaylastest' templatePath='bGF5b3V0X2Zvb3Rlci9zdGFuZGFyZC5odG1s'>
						<table cellpadding="0" cellspacing="0" class="table_footer_notice">
							<colgroup><col><col style="width:74px;"></colgroup>
							<tbody>
<?php if(is_array($TPL_R1=getBoardData('notice','4',null,null,'24','40','ID','HID','IMG',array('orderby=gid asc','','rdate_s=2018-11-27','rdate_f=','auto_term=','image_w=400','image_h=400')))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
								<tr>
									<td class="subject"><?php echo $TPL_V1["subject"]?></td>
									<td class="date"><?php echo substr($TPL_V1["r_date"], 0, 10)?></td>
								</tr>
<?php }}?>
							</tbody>
						</table>
					</div>
				</li>
			</ul>
		</div>
	</div>

	<div class="footer_c">
		<div class="resp_wrap">
			<ul class="menu3">
				<li><span designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >COMPANY</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyName"]?></span></li>
				<li><span designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >OWNER</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["ceo"]?> </span></li>
				<li><span designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >ADDRESS</span> <span class="pcolor"><?php if($TPL_VAR["config_basic"]["companyAddress_type"]=="street"){?><?php echo $TPL_VAR["config_basic"]["companyAddress_street"]?><?php }else{?><?php echo $TPL_VAR["config_basic"]["companyAddress"]?><?php }?> <?php echo $TPL_VAR["config_basic"]["companyAddressDetail"]?></span></li>
				<li><span designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >TEL</span> <a href="tel:<?php echo $TPL_VAR["config_basic"]["companyPhone"]?>" class="pcolor" hrefOri='dGVsOntjb25maWdfYmFzaWMuY29tcGFueVBob25lfQ==' ><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></a></li>
<?php if($TPL_VAR["config_basic"]["companyFax"]){?>
				<li><span designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >FAX</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyFax"]?></span></li>
<?php }?>
				<li><span designElement="text" textIndex="21"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >BUSINESS LICENCE</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["businessLicense"]?> <?php echo confirmLicenseLink("[?????????????????????]")?></span></li>
				<li><span designElement="text" textIndex="22"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >MAIL-ORDER LICENSE</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["mailsellingLicense"]?></span></li>
				<li><span designElement="text" textIndex="23"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >WEBMASTER</span> <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["member_info_manager"]?> (<a class="pcolor" href="mailto:<?php echo $TPL_VAR["config_basic"]["companyEmail"]?>" hrefOri='bWFpbHRvOntjb25maWdfYmFzaWMuY29tcGFueUVtYWlsfQ==' ><?php echo $TPL_VAR["config_basic"]["companyEmail"]?></a>)</span></li>
				<li>HOSTING PROVIDER <span class="pcolor">(???)?????????????????????</span></li>
			</ul>
			<p class="copyright" designElement="text" textIndex="24"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >COPYRIGHT (c) <span class="pcolor"><?php echo $TPL_VAR["config_basic"]["companyName"]?></span> ALL RIGHTS RESERVED.</p>
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
<!-- ???????????? : ??? -->

<!-- ????????? - BACK/TOP(????????????) -->
<div id="floating_over">
	<a href="javascript:history.back();" class="ico_floating_back" title="?????? ??????" hrefOri='amF2YXNjcmlwdDpoaXN0b3J5LmJhY2soKTs=' ></a>
	<a href="javascript:history.forward();" class="ico_floating_foward" title="????????? ??????" hrefOri='amF2YXNjcmlwdDpoaXN0b3J5LmZvcndhcmQoKTs=' ></a>
	<a href="#layout_header" class="ico_floating_top" title="?????? ??????" hrefOri='I2xheW91dF9oZWFkZXI=' >TOP</a>
<?php if((preg_match('/main\/index/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/catalog/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/brand/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/location/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/search/',$_SERVER["REQUEST_URI"])||preg_match('/bigdata\/catalog/',$_SERVER["REQUEST_URI"]))&&$TPL_VAR["dataRightQuicklist"]&&!preg_match('/goods\/view/',$_SERVER["REQUEST_URI"])){?>
<?php if($TPL_VAR["push_count_today_images"]){?><a href="javascript:;" class="ico_floating_recently" hrefOri='amF2YXNjcmlwdDo7' ><span designElement="text" textIndex="25"  textTemplatePath="cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==" >?????????</span><br /><img src="<?php echo $TPL_VAR["push_count_today_images"]?>" onerror="this.src='/data/skin/responsive_multishop_trendy_gl/images/common/noimage.gif'" designImgSrcOri='e3B1c2hfY291bnRfdG9kYXlfaW1hZ2VzfQ==' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==' designImgSrc='e3B1c2hfY291bnRfdG9kYXlfaW1hZ2VzfQ==' designElement='image' ></a><?php }?>
<?php }?>

	<!-- ?????? ??? ??????(LAYER) -->
<?php if((preg_match('/main\/index/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/catalog/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/brand/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/location/',$_SERVER["REQUEST_URI"])||preg_match('/goods\/search/',$_SERVER["REQUEST_URI"])||preg_match('/bigdata\/catalog/',$_SERVER["REQUEST_URI"]))&&$TPL_VAR["dataRightQuicklist"]){?>
	<div id="recently_popup">
		<div class="recently_popup">
			<h1>?????? ??? ??????</h1>
			<div class="recently_thumb">
				<div id="recently_slide_bottom" style="width:285px; min-height:80px;">
					<div class="thumb">
<?php if($TPL_VAR["dataRightQuicklist"]){?>
						<ul>
<?php if($TPL_dataRightQuicklist_1){$TPL_I1=-1;foreach($TPL_VAR["dataRightQuicklist"] as $TPL_V1){$TPL_I1++;?>
<?php if(($TPL_I1< 40)){?>
<?php if(($TPL_I1&&($TPL_I1% 4)== 0)){?></ul><ul><?php }?>
								<li><a href="../goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" class="right_quick_goods" hrefOri='Li4vZ29vZHMvdmlldz9ubz17Lmdvb2RzX3NlcX0=' ><img src="<?php echo $TPL_V1["image"]?>" onerror="this.src='/data/skin/responsive_multishop_trendy_gl/images/common/noimage_list.gif'" alt="<?php echo $TPL_V1["goods_name"]?>" designImgSrcOri='ey5pbWFnZX0=' designTplPath='cmVzcG9uc2l2ZV9tdWx0aXNob3BfdHJlbmR5X2dsL2xheW91dF9mb290ZXIvc3RhbmRhcmQuaHRtbA==' designImgSrc='ey5pbWFnZX0=' designElement='image' ></a><a href="javascript:rightDeleteItem('mobile_bottom_item_recent', '<?php echo $TPL_V1["goods_seq"]?>',$(this))" class="btn_delete cover" hrefOri='amF2YXNjcmlwdDpyaWdodERlbGV0ZUl0ZW0o' >??????</a></li>
<?php }?>
<?php }}?>
						</ul>
<?php }else{?>
						<h2> ?????? ??? ????????? ????????????.</h2>
<?php }?>
					</div>
				</div>
				<div class="recently_page">
					<a href="javascript:;" class="btn_page cover" hrefOri='amF2YXNjcmlwdDo7' >??????</a>
				</div>
			</div>
			<a href="javascript:;" class="btn_close" hrefOri='amF2YXNjcmlwdDo7' >????????????</a>
		</div>
		<div class="recently_bg"></div>
	</div>
<?php if($TPL_dataRightQuicklist_1> 3){?>
	<script type="text/javascript">
	<!--
		$(function(){
			/* ?????? ??? ?????? - LAYER(????????????) */
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
<!-- //????????? - BACK/TOP(????????????) -->


<script type="text/javascript">
$(function() {
	/* ????????? ???????????? ?????? ??????( ?????? ?????? ?????? ) */
<?php if($TPL_VAR["settle"]){?>
		$('.slider_before_loading').remove();
<?php }else{?>
		$('.slider_before_loading').removeClass('slider_before_loading');
<?php }?>

	// ?????? ?????? ????????? ?????????( new ???????????? )
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

/*######################## 17.12.19 gcs yjy : ??? ??????(fb ????????????) s */
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
					alert("???????????????????????????.");

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
/*######################## 17.12.19 gcs yjy : ??? ??????(fb ????????????) e */
</script>