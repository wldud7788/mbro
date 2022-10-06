<?php /* Template_ 2.2.6 2022/03/18 15:13:31 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/member/join_gate.html 000007843 */ 
$TPL_couponmemberarray_1=empty($TPL_VAR["couponmemberarray"])||!is_array($TPL_VAR["couponmemberarray"])?0:count($TPL_VAR["couponmemberarray"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 회원가입 @@
- 파일위치 : [스킨폴더]/member/join_gate.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="title_container">
	<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s" >회원가입</span></h2>
</div>
<p class="mypage_greeting gray_06" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s" >회원이 되셔서 할인쿠폰/마일리지 등 다양한 서비스를 받으세요.</p>

<div class="resp_login_wrap">
	<!-- 탭 -->
	<div id="memberSelect" class="tab_basic fullsize">
		<ul>
<?php if($TPL_VAR["joinform"]["join_type"]!='business_only'){?>
			<li class="on"><a href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s" >개인회원</span></a></li>
<?php }?>
<?php if($TPL_VAR["joinform"]["join_type"]!='member_only'){?>
			<!--
			<li><a href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ><span designElement="text">사업자회원</span></a></li>
			-->
<?php }?>
		</ul>
	</div>

<?php if($TPL_VAR["fb_invite"]){?>
	<div class="join_fb_invite">
		<span class="fb_name"><?php echo $TPL_VAR["fb_invite"]["user_name"]?></span> 님으로부터 초대받으셨습니다.
	</div>
<?php }?>

	

<?php if($TPL_VAR["joinform"]["join_type"]!='business_only'){?>
	<div class="sub_page_tab_contents">
		<p class="join_btns">
			<button type="button" class="btn_resp size_c color2 Wmax" onclick="document.location.href='agreement?join_type=member'"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s" >회원가입</span></button>
		</p>

<?php if($TPL_VAR["joinform"]["use_sns"]){?>
		<h3 class="title_sub3 v3 Mt10"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s" >또는 SNS 회원가입</span></h3>
		<ul class="sns_login_ul">
<?php if(is_array($TPL_R1=$TPL_VAR["joinform"]["use_sns"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1){?>
			<li><div class="img"><img src="/data/skin/responsive_sports_sporti_gl_1/images/design/sns_icon_<?php echo $TPL_K1?>.png" onclick="document.location.href='agreement?join_type=<?php echo $TPL_V1['cd']?>member'" alt=" <?php echo $TPL_K1?> 회원가입" title="<?php echo $TPL_V1['nm']?> 회원가입" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9zbnNfaWNvbl97PS5rZXlffS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduL3Nuc19pY29uX3s9LmtleV99LnBuZw==' designElement='image' ></div></li>
<?php }?>
<?php }}?>
		</ul>
<?php }?>
	</div>
<?php }?>

<?php if($TPL_VAR["joinform"]["join_type"]!='member_only'){?>
	<div class="sub_page_tab_contents">
		<p class="join_btns">
			<button type="button" class="btn_resp size_c color2 Wmax" onclick="document.location.href='agreement?join_type=business'"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s" >회원가입</span></button>
		</p>

<?php if($TPL_VAR["joinform"]["use_sns"]){?>
		<h3 class="title_sub3 v3 Mt10"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s" >또는 SNS 회원가입</span></h3>
		<ul class="sns_login_ul">
<?php if(is_array($TPL_R1=$TPL_VAR["joinform"]["use_sns"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1){?>
			<li><div class="img"><img src="/data/skin/responsive_sports_sporti_gl_1/images/design/sns_icon_<?php echo $TPL_K1?>.png" onclick="document.location.href='agreement?join_type=<?php echo $TPL_V1['cd']?>business'" alt=" <?php echo $TPL_K1?> 회원가입" title="<?php echo $TPL_V1['nm']?> 회원가입" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9zbnNfaWNvbl97PS5rZXlffS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduL3Nuc19pY29uX3s9LmtleV99LnBuZw==' designElement='image' ></div></li>
<?php }?>
<?php }}?>
		</ul>
<?php }?>
	</div>
<?php }?>

<?php if($TPL_VAR["emoneyapp"]["emoneyJoin"]> 0||$TPL_VAR["emoneyapp"]["emoneyInvitees"]> 0||$TPL_VAR["couponmember"]["coupon_seq"]){?>
	<h3 class="title_sub2 Mt50"><b class="Fw400"><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s" >신규회원을 위한 혜택을 놓치지 마세요!</span></b></h3>
	<div class="join_member_benefit_detail">
<?php if($TPL_VAR["emoneyapp"]["emoneyJoin"]> 0){?>
		<ul>
			<li class="tt"><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s" >마일리지</span></li>
			<li class="dd">
				<?php echo get_currency_price($TPL_VAR["emoneyapp"]["emoneyJoin"], 2,'','<span class="num">_str_price_</span>')?>

			</li>
		</ul>
<?php }?>
<?php if($TPL_VAR["emoneyapp"]["emoneyInvitees"]> 0&&$TPL_VAR["fb_invite"]){?>
		<ul>
			<li class="tt"><span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s" >추가 마일리지</span></li>
			<li class="dd">
				<?php echo get_currency_price($TPL_VAR["emoneyapp"]["emoneyInvitees"], 2,'','<span class="num">_str_price_</span>')?>

			</li>
		</ul>
<?php }?>
<?php if($TPL_couponmemberarray_1){foreach($TPL_VAR["couponmemberarray"] as $TPL_V1){?>
<?php if($TPL_V1["type"]=='member_shipping'){?>
			<ul>
				<li class="tt"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s" >배송비 쿠폰</span></li>
				<li class="dd">
<?php if($TPL_V1["shipping_type"]=='free'){?>
<?php if($TPL_V1["limit_goods_price_title"]){?>
						<?php echo $TPL_V1["limit_goods_price_title"]?>

<?php }?> 
						<span class="num">배송비무료</span>
						<p class="Fs14 gray_06">(최대<?php echo get_currency_price($TPL_V1["max_percent_shipping_sale"], 2)?>)</p>
<?php }else{?>
						<?php echo get_currency_price($TPL_V1["won_shipping_sale"], 2,'','<span class="num">_str_price_</span>')?>

<?php }?>
				</li>
			</ul>
<?php }else{?>
			<ul>
				<li class="tt"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvbWVtYmVyL2pvaW5fZ2F0ZS5odG1s" >회원가입 쿠폰</span></li>
				<li class="dd">
<?php if($TPL_V1["sale_type"]=='percent'){?>
						<span class="num"><?php echo $TPL_V1["percent_goods_sale"]?></span>%
<?php }else{?>
						<?php echo get_currency_price($TPL_V1["won_goods_sale"], 2,'','<span class="num">_str_price_</span>')?>

<?php }?>
				</li>
			</ul>
<?php }?>
<?php }}?>
	</div>
<?php }?>

</div>

<script>
$(function(){
	// 탭 클릭시
	$("#memberSelect li").each(function(i){
		$(this).click(function(){
			$("#memberSelect li").removeClass("on");
			$(this).addClass("on");
			$(".sub_page_tab_contents").hide().eq(i).show();
		});
	}).eq(0).click();
});
</script>