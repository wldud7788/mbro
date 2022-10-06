<?php /* Template_ 2.2.6 2020/12/23 15:34:00 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/coin/main.html 000001276 */  $this->include_("sslAction");?>
<!-- 탭 -->
<div class="resp_login_wrap">
	<div id="loginTab" class="tab_basic fullsize Pt20">		
	</div>
</div>
<? if(!$_SESSION[user][member_seq]) { ?>
	<div id="member" class="loginTabContetns resp_login_wrap Mt0">
		<form name="loginmove" target="actionFrame" method="post" action="<?php echo sslAction('../coin/loginmove')?>">
			<fieldset>
					<li>
						<button type="submit" class="btn_resp size_login1"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2NvaW4vbWFpbi5odG1s" >마일리지 충전(BMP)</span></button>
					</li>
			</fieldset>
		</form>
	</div>
<?	} else { ?>
	<div id="member" class="loginTabContetns resp_login_wrap Mt0">
		<form name="pagemove" target="actionFrame" method="post" action="<?php echo sslAction('../coin/pagemove')?>">
			<fieldset>
					<li>
						<button type="submit" class="btn_resp size_login1"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2NvaW4vbWFpbi5odG1s" >마일리지 충전(BMP)</span></button>
					</li>
			</fieldset>
		</form>
	</div>
<? } ?>