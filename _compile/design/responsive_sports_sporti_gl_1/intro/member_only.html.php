<?php /* Template_ 2.2.6 2022/03/18 15:13:31 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/intro/member_only.html 000005118 */  $this->include_("sslAction");?>
<?php $this->print_("HTML_HEADER",$TPL_SCP,1);?>


<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 인트로 > 회원전용 @@
- 파일위치 : [스킨폴더]/intro/member_only.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php echo $TPL_VAR["is_file_facebook_tag"]?>

<?php echo $TPL_VAR["is_file_kakao_tag"]?>


<div class="layout_intro">
	<div class="title_container">
		<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvaW50cm8vbWVtYmVyX29ubHkuaHRtbA==" >로그인</span></h2>
	</div>
	<p class="mypage_greeting pointcolor" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvaW50cm8vbWVtYmVyX29ubHkuaHRtbA==" >본 사이트는 회원만 이용 가능합니다!</p>

	<div class="resp_login_wrap">
		<form name="loginForm" target="actionFrame" method="post" action="<?php echo sslAction('../login_process/login')?>">
		<input type="hidden" name="return_url" value="<?php echo $TPL_VAR["return_url"]?>"/>
			<fieldset>
				<ul class="login_real_area">
					<li class="input_area">
						<input type="text" name="userid" id="userid" class="box_id" value="<?php if($TPL_VAR["idsavechecked"]){?><?php echo $TPL_VAR["idsavechecked"]?><?php }?>" placeholder="아이디" />
						<input type="password" name="password" class="box_pw" placeholder="비밀번호" />
					</li>
					<li>
						<label class="id_save"><input type="checkbox" name="idsave" id="idsave" value="checked"  <?php if($TPL_VAR["idsavechecked"]){?> checked="checked" <?php }?> /> <span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvaW50cm8vbWVtYmVyX29ubHkuaHRtbA==" >아이디 저장</span></label>
					</li>
					<li>
						<button type="submit" class="btn_resp size_login1"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvaW50cm8vbWVtYmVyX29ubHkuaHRtbA==" >로그인</span></button>
					</li>
					<li class="find_join">
						<a href="../member/find?mode=findid" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvaW50cm8vbWVtYmVyX29ubHkuaHRtbA==" hrefOri='Li4vbWVtYmVyL2ZpbmQ/bW9kZT1maW5kaWQ=' >아이디 찾기</a> &nbsp;|&nbsp;
						<a href="../member/find?mode=findpw" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvaW50cm8vbWVtYmVyX29ubHkuaHRtbA==" hrefOri='Li4vbWVtYmVyL2ZpbmQ/bW9kZT1maW5kcHc=' >비밀번호 찾기</a> &nbsp;|&nbsp;
						<a class="join" href="/member/agreement" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvaW50cm8vbWVtYmVyX29ubHkuaHRtbA==" hrefOri='L21lbWJlci9hZ3JlZW1lbnQ=' >회원가입</a>
					</li>
				</ul>

				<!-- SNS 가입폼 -->
<?php if(count($TPL_VAR["joinform"]["use_sns"])> 0){?>
				<h3 class="title_sub3 v3"><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvaW50cm8vbWVtYmVyX29ubHkuaHRtbA==" >또는 SNS 로그인</span></h3>
				<ul class="sns_login_ul">
<?php if(is_array($TPL_R1=$TPL_VAR["joinform"]["use_sns"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1){?><li class="sns-login-button" snstype="<?php echo $TPL_K1?>"><div class="img"><img src="/data/skin/responsive_sports_sporti_gl_1/images/design/sns_icon_<?php echo $TPL_K1?>.png" alt="<?php echo $TPL_K1?> 로그인" title="<?php echo $TPL_V1['nm']?> 로그인" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9zbnNfaWNvbl97PS5rZXlffS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvaW50cm8vbWVtYmVyX29ubHkuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvZGVzaWduL3Nuc19pY29uX3s9LmtleV99LnBuZw==' designElement='image' /></div></li><?php }?>
<?php }}?>
				</ul>
<?php }?>
			</fieldset>
		</form>

<?php if($TPL_VAR["mode"]){?>
		<div class="Pt40"><a class="btn_resp size_c color4 Wmax" href="../order/cart" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvaW50cm8vbWVtYmVyX29ubHkuaHRtbA==" hrefOri='Li4vb3JkZXIvY2FydA==' >주문하러 가기</a></div>
<?php }?>
	</div>
</div>






<script src="/app/javascript/js/skin-snslogin.js"></script>
<script type="text/javascript">
var return_url		= "../main/index";
<?php if($_GET["return_url"]){?>
return_url			= "<?php echo $_GET["return_url"]?>";
<?php }elseif($TPL_VAR["return_url"]){?>
return_url			= "<?php echo $TPL_VAR["return_url"]?>";
<?php }?>
var mobileapp		= "<?php echo $TPL_VAR["mobileapp"]?>";
var m_device		= "<?php echo $TPL_VAR["m_device"]?>";
var fbuserauth		= "<?php echo $TPL_VAR["fbuserauth"]?>";
var jointype		= '<?php echo $_GET["join_type"]?>';
var apple_authurl	= '<?php echo $TPL_VAR["apple_authurl"]?>';
</script>

<?php $this->print_("HTML_FOOTER",$TPL_SCP,1);?>