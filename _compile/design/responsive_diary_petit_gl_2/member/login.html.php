<?php /* Template_ 2.2.6 2020/12/30 16:37:18 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_2/member/login.html 000008858 */  $this->include_("sslAction");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 로그인 @@
- 파일위치 : [스킨폴더]/member/login.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php echo $TPL_VAR["is_file_kakao_tag"]?>


<div class="title_container" style="display:none;">
<?php if($_GET["order_auth"]){?>
	<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" >주문배송조회</span></h2>
<?php }elseif($TPL_VAR["mode"]){?>
	<h2><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" >주문</span></h2>
<?php }else{?>
	<h2><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" >로그인</span></h2>
<?php }?>
</div>

<!-- 탭 -->
<div class="resp_login_wrap">
	<div id="loginTab" class="tab_basic fullsize Pt20">
		<p>뮤직브로 기존사이트를 통해 쇼핑몰을 처음 방문해주신 분들은 로그인 전 <a href="https://musicbroshop.com/board/view?id=notice&seq=39" style="color: red;" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2JvYXJkL3ZpZXc/aWQ9bm90aWNlJnNlcT0zOQ==' >공지사항</a>을 참조해주세요. </p>
		<ul>
			<li class="on"><a href="javascript:void(0)" data-tab="member" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" >회원</span></a></li>
			<li <?php if($TPL_VAR["mode"]=='settle'){?>style="display:none"<?php }?>><a href="javascript:void(0)" data-tab="nonmember" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" >비회원</span></a></li>
		</ul>
	</div>
</div>

<!-- +++++++++++ 회원 +++++++++++ -->
<div id="member" class="loginTabContetns resp_login_wrap Mt0">
	<form name="loginForm" target="actionFrame" method="post" action="<?php echo sslAction('../login_process/login')?>" onsubmit="return submitLoginForm(this)">
	<input type="hidden" name="return_url" value="<?php echo $TPL_VAR["return_url"]?>"/>
	<input type="hidden" name="order_auth" value="<?php echo $_GET["order_auth"]?>"/>
		<fieldset>
			<ul class="login_real_area">
				<li class="input_area">
					<input type="text" name="userid" id="userid" class="box_id" value="<?php if($TPL_VAR["idsavechecked"]){?><?php echo $TPL_VAR["idsavechecked"]?><?php }?>" placeholder="이메일아이디" required="required" />
					<!--<input type="email" name="useremail" id="useremail" class="useremail" value="<?php if($TPL_VAR["idsavechecked"]){?><?php echo $TPL_VAR["idsavechecked"]?><?php }?>" placeholder="이메일"/>-->
					<input type="password" name="password" id="password" class="box_pw" placeholder="비밀번호" password="password" required="required" />
				</li>
				<li>
					<label class="id_save"><input type="checkbox" name="idsave" id="idsave" value="checked"  <?php if($TPL_VAR["idsavechecked"]){?> checked="checked" <?php }?> /> <span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" >아이디 저장</span></label>
				</li>
				<li>
					<button type="submit" class="btn_resp size_login1"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" >로그인</span></button>
				</li>
				<li class="find_join">
					<a href="../member/find?mode=findid" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" hrefOri='Li4vbWVtYmVyL2ZpbmQ/bW9kZT1maW5kaWQ=' >아이디 찾기</a> &nbsp;|&nbsp;
					<a href="../member/find?mode=findpw" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" hrefOri='Li4vbWVtYmVyL2ZpbmQ/bW9kZT1maW5kcHc=' >비밀번호 찾기</a> &nbsp;|&nbsp;
					<a href="../member/agreement" class="Fw500 gray_01" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" hrefOri='Li4vbWVtYmVyL2FncmVlbWVudA==' >회원가입</a>
				</li>
			</ul>

			<!-- SNS 가입폼 -->
<?php if(count($TPL_VAR["joinform"]["use_sns"])> 0){?>
			<h3 class="title_sub3 v3"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" >또는 SNS 로그인</span></h3>
			<ul class="sns_login_ul">
<?php if(is_array($TPL_R1=$TPL_VAR["joinform"]["use_sns"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1){?><li class="sns-login-button" snstype="<?php echo $TPL_K1?>"><div class="img"><img src="/data/skin/responsive_diary_petit_gl_2/images/design/sns_icon_<?php echo $TPL_K1?>.png" alt="<?php echo $TPL_K1?> 로그인" title="<?php echo $TPL_V1['nm']?> 로그인" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9zbnNfaWNvbl97PS5rZXlffS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzIvaW1hZ2VzL2Rlc2lnbi9zbnNfaWNvbl97PS5rZXlffS5wbmc=' designElement='image' /></div></li><?php }?>
<?php }}?>
			</ul>
<?php }?>

<?php if($TPL_VAR["mode"]=='settle'){?>
			<div class="Pt40"><button type="button" class="btn_resp size_c color4 Wmax"  onclick="document.location.href='<?php echo $_GET["return_url"]?>';"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" >비회원으로 주문하기</span></button></div>
<?php }elseif($TPL_VAR["mode"]){?>
			<div class="Pt40"><button type="button" class="btn_resp size_c color4 Wmax" onclick="document.location.href='../order/cart';"/><span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" >비회원으로 주문하기</span></button></div>
<?php }?>
		</fieldset>
	</form>
</div>
<!-- +++++++++++ //회원 +++++++++++ -->


<!-- +++++++++++ 비회원 +++++++++++ -->
<div id="nonmember" class="loginTabContetns resp_login_wrap Mt0" style="display:none;">
	<form name="order_auth_form" target="actionFrame" method="post" action="<?php echo sslAction('../mypage_process/order_auth')?>">
	<input type="hidden" name="return_url" value="<?php echo $TPL_VAR["return_url"]?>"/>
		<ul class="login_real_area">
			<li class="input_area">
				<input type="text" name="order_seq" value="" class="box_order" placeholder="주문번호" />
				<input type="text" name="order_email" value="" class="box_order" placeholder="주문자 이메일" />
			</li>
			<li class="desc_area">
				<p designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" >비회원은 주문번호와 이메일로 주문을 조회할 수 있습니다.</p>
			</li>
			<li>
				<button type="submit" class="btn_resp size_login1"><span designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8yL21lbWJlci9sb2dpbi5odG1s" >주문조회</span></button>
			</li>
		</ul>
	</form>
</div>
<!-- +++++++++++ //비회원 +++++++++++ -->




<script src="/app/javascript/js/skin-snslogin.js"></script>

<script type="text/javascript">
var return_url	= "../main/index";
<?php if($_GET["return_url"]){?>
return_url		= "<?php echo $_GET["return_url"]?>";
<?php }elseif($TPL_VAR["return_url"]){?>
return_url		= "<?php echo $TPL_VAR["return_url"]?>";
<?php }?>
var mobileapp	= "<?php echo $TPL_VAR["mobileapp"]?>";
var m_device	= "<?php echo $TPL_VAR["m_device"]?>";
var fbuserauth	= "<?php echo $TPL_VAR["fbuserauth"]?>";
var jointype = '<?php echo $_GET["join_type"]?>';
var apple_authurl	= '<?php echo $TPL_VAR["apple_authurl"]?>';
function submitLoginForm(frm){
	if($("input[name='save_id']").is(":checked")){
		$.cookie('save_userid',$("input[name='userid']",frm).val(),{'expires':30,'path':'/'});
	}else{
		$.cookie('save_userid','',{'expires':-1,'path':'/'});
	}
	if($("input[name='save_pw']").is(":checked")){
		$.cookie('save_password',$("input[name='password']",frm).val(),{'expires':30,'path':'/'});
	}else{
		$.cookie('save_password','',{'expires':-1,'path':'/'});
	}
	return true;
}

$(document).ready(function() {
	// 로딩시 ID 인풋박스 포커스
	$("form[name='loginForm'] input[name='userid']").focus();

	// 회원가입 로그인 탭UI 190208 - sjg
	$('#loginTab a').on('click', function() {
		var tab_name = $(this).data('tab');
		$('.loginTabContetns').hide();
		$('#' + tab_name).show();
		$('#loginTab li').removeClass('on');
		$(this).closest('li').addClass('on');
	});
});

</script>