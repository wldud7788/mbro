<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/member/register_ok.html 000002731 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 회원가입 완료 @@
- 파일위치 : [스킨폴더]/member/register_ok.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_VAR["kid_auth"]=='N'){?>
<div class="title_container">
	<h2 class="pointcolor imp"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9vay5odG1s" >회원가입 완료!</span></h2>
</div>
<p class="mypage_greeting Pb15" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9vay5odG1s" >고객님은 만 14세 미만 회원이므로 </br> 관리자 가입 승인이 필요합니다.</p>

<p class="mypage_greeting Pb30" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9vay5odG1s" >관리자 승인을 위해 법정 대리인 동의서를 </br> 쇼핑몰로 전달 주시기 바랍니다.</p>

<div class="login_ok_menu">
	<ul>
		<li><button type="button" class="btn_resp size_c color4" style="height:70px; line-height:70px;"><a href="<?php echo $TPL_VAR["file_url"]?>" download="<?php echo $TPL_VAR["file_name"]?>">법정 대리인 동의서</a></button></li>
	</ul>
</div>
<?php }else{?>
<div class="title_container">
	<h2 class="pointcolor imp"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9vay5odG1s" >회원가입 완료!</span></h2>
</div>
<p class="mypage_greeting Pb30" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9vay5odG1s" >회원가입을 진심으로 축하드립니다.</p>

<div class="login_ok_menu">
	<ul>
<?php if($TPL_VAR["userInfo"]){?>
		<li><a class="btn_resp size_c color2" href="../mypage/myinfo" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9vay5odG1s" >회원정보수정</a></li>
<?php }else{?>
		<li><a class="btn_resp size_c color2" href="../member/login?return_url=<?php echo urlencode('../main/index')?>"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9vay5odG1s" >로그인</span></a></li>
<?php }?>
		<li><a class="btn_resp size_c color4" href="../main" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9vay5odG1s" >쇼핑하러가기</a></li>
	</ul>
</div>
<?php }?>