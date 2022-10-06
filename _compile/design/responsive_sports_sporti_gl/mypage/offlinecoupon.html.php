<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/mypage/offlinecoupon.html 000002551 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 쿠폰 등록(인증) ( 쿠폰 내역 > [+ 쿠폰 등록] 클릭시 이동 페이지 ) @@
- 파일위치 : [스킨폴더]/mypage/offlinecoupon.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL215cGFnZS9vZmZsaW5lY291cG9uLmh0bWw=" >쿠폰 등록(인증)</span></h2>
		</div>

		<p class="mypage_greeting">쿠폰번호를 입력하세요.</p>
		
		<div class="cont_coupon_reg">
			<input type="text" name="offline_serialnumber" id="offline_serialnumber" value="" maxlength="35" placeholder="쿠폰번호" />
			<button type="button" id="offlinecouponbtn" class="btn_resp size_b color6">등록</button>
		</div>

		<div class="btn_area_d">
			<a class="btn_resp size_c" href="/mypage/coupon" hrefOri='L215cGFnZS9jb3Vwb24=' >쿠폰 내역</a>
		</div>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_sports_sporti_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->


<script type="text/javascript">
$(document).ready(function() {
	//쿠폰인증받기
	$("#offlinecouponbtn").click(function(){
		var offline_serialnumber = $("#offline_serialnumber").val();
		if(offline_serialnumber){
			$.ajax({
				'url' : '../coupon/offlinecoupon_member',
				'data' : {'offline_serialnumber':offline_serialnumber},
				'type' : 'post',
				'dataType': 'json',
				'success': function(data) {
					if(data.result){
						openDialogConfirm(data.msg,'400','180',function(){document.location.href=data.returnurl});
					}else{
						openDialogAlert(data.msg,'400','140',function(){});
					}
				}
			});
		}else{
			//인증번호를 입력해 주세요!
			openDialogAlert(getAlert('mp071'),'400','140',function(){});
		}
	});
});
</script>