<?php /* Template_ 2.2.6 2020/12/28 14:32:40 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/coin/deposit.html 000001060 */  $this->include_("sslAction");?>
<!-- 탭 -->
<div class="resp_login_wrap">
	<div id="loginTab" class="tab_basic fullsize Pt20">
		<p>BMP 코인 입금 요청</p>
	</div>
</div>

<div id="member" class="loginTabContetns resp_login_wrap Mt0">
	<form name="loginmove" target="actionFrame" method="post" action="<?php echo sslAction('../coin/order')?>">
		<fieldset>
			<li class="input_area">
				<input type="text" name="name" class="box_id" placeholder="입금자" required="required" />
				<input type="text" name="money" class="box_id" placeholder="코인금액(숫자만 작성)" required="required" />
			</li>
			<br>
			<li>
				<button type="submit" class="btn_resp size_login1"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9jb2luL2RlcG9zaXQuaHRtbA==" >완료</span></button>
			</li>
		</fieldset>
	</form>
</div>
<?php echo $TPL_VAR["coin"]["member_hash"]?>