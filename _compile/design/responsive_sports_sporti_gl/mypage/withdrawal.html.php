<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/mypage/withdrawal.html 000003712 */ 
$TPL_withdrawal_arr_1=empty($TPL_VAR["withdrawal_arr"])||!is_array($TPL_VAR["withdrawal_arr"])?0:count($TPL_VAR["withdrawal_arr"]);
$TPL_snslist_1=empty($TPL_VAR["snslist"])||!is_array($TPL_VAR["snslist"])?0:count($TPL_VAR["snslist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 회원 탈퇴 @@
- 파일위치 : [스킨폴더]/mypage/withdrawal.html
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
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL215cGFnZS93aXRoZHJhd2FsLmh0bWw=" >회원 탈퇴</span></h2>
		</div>

		<form name="registFrm" id="registFrm" target="actionFrame" method="post" action="/member_process/withdrawal">
			<div class="resp_table_row v2">
				<ul class="tr">
					<li class="th">탈퇴사유</li>
					<li class="td">
						<div class="label_group">
<?php if($TPL_withdrawal_arr_1){foreach($TPL_VAR["withdrawal_arr"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1== 0){?>
						<label><input type="radio" name="reason" value="<?php echo $TPL_V1["codecd"]?>" checked="checked" /> <?php echo $TPL_V1["value"]?></label>&nbsp;
<?php }else{?>
						<label><input type="radio" name="reason" value="<?php echo $TPL_V1["codecd"]?>"/> <?php echo $TPL_V1["value"]?></label>&nbsp;
<?php }?>
<?php }}?>
						</div>
					</li>
				</ul>
				<ul class="tr">
					<li class="th">내용</li>
					<li class="td P5">
						<textarea name="memo" rows="5"></textarea>
					</li>
				</ul>
			</div>

			<div class="Pt20 C pointcolor">
				회원탈퇴 시 회원님의 개인정보, 주문내역, 마일리지, 쿠폰 등 모든 정보가 바로 삭제됩니다.
<?php if($TPL_VAR["snslist"]){?>
				회원님의 SNS계정(<?php if($TPL_snslist_1){$TPL_I1=-1;foreach($TPL_VAR["snslist"] as $TPL_V1){$TPL_I1++;?><?php echo $TPL_V1["rute"]?><?php if($TPL_V1[($TPL_I1+ 1)]){?>, <?php }?><?php }}?>) 정보가 쇼핑몰에서 삭제됩니다.
<?php }?>
			</div>
			<div class="Pt10 C">
				<label><input type="checkbox" name="agree" value="Y" /> 예, 정보삭제에 동의합니다.</label>
			</div>

			<div class="btn_area_c">
				<button type="button" id="btn_submit" class="btn_resp size_c color2">확인</button>
				<a href="javascript:document.registFrm.reset();" class="btn_resp size_c" hrefOri='amF2YXNjcmlwdDpkb2N1bWVudC5yZWdpc3RGcm0ucmVzZXQoKTs=' >취소</a>
			</div>

		</form>
		<!--  //본문내용 끝 -->

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_sports_sporti_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->


<script type="text/javascript">
$(document).ready(function() {
	$("#btn_submit").click(function() {
		if($("input[name='agree']:checked").val()!='Y'){
			//정보 삭제에 동의해 주십시오.
			alert(getAlert('mb162'));
			$("input[name='agree']").focus();
			return false;
		}

		//정말로 회원 탈퇴하시겠습니까?
		if(!confirm(getAlert('mb163'))) return;
		$("#registFrm").submit();
	});
});
</script>