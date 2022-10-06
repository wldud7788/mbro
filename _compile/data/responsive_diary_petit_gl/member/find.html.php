<?php /* Template_ 2.2.6 2021/02/22 16:08:37 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/member/find.html 000025648 */  $this->include_("sslAction");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 아이디/비밀번호 찾기 @@
- 파일위치 : [스킨폴더]/member/find.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="title_container">
	<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >아이디/비밀번호 찾기</span></h2>
</div>

<div class="resp_login_wrap Mt10">
	<!-- 탭 -->
	<div class="tab_basic fullsize Mb0">
		<ul id="idPwTab">
			<li class="on"><a href="javascript:void(0)" data-tab="idFindArea"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >아이디 찾기</span></a></li>
			<li><a href="javascript:void(0)" data-tab="pwFindArea"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >비밀번호 찾기</span></a></li>
		</ul>
	</div>
	
	<!-- +++++++++++++++++++++ 아이디 찾기 +++++++++++++++++++++ -->
	<div class="idPwContents" id="idFindArea">
		<a name="findid"></a>
		<form name="loginForm" target="actionFrame" method="post" action="<?php echo sslAction('../login_process/findid')?>">
			<div id="findidfromlay">
<?php if($TPL_VAR["realnameinfo"]["useRealnamephone"]=='Y'||$TPL_VAR["realnameinfo"]["realnameId"]){?>
					<h3 class="title_sub2 v2 Mt20"><b><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >본인인증 수단으로 아이디 찾기</span></b></h3>
					<p class="gray_06 C" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >실명이 확인된 회원은 인증을 통하여 찾을 수 있습니다.</p>
					<div class="label_group v2">
<?php if($TPL_VAR["realnameinfo"]["useRealnamephone"]=='Y'){?>
						<label><input type="radio" name="auth_type" findtype="id" value="phone" checked /> <span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >휴대폰</span></label>
<?php }?>
<?php if($TPL_VAR["realnameinfo"]["realnameId"]){?>
						<label><input type="radio" name="auth_type" findtype="id" value="ipin" <?php if($TPL_VAR["realnameinfo"]["useRealnamephone"]!='Y'){?>checked<?php }?> /> <span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >아이핀(i-Pin)</span></label>
						<label><input type="radio" name="auth_type" findtype="id" value="auth" /> <span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >안심체크</span></label>
<?php }?>
					</div>
					<!-- 휴대폰 -->
					<ul id="phone_id_tab" class="find_confirm" <?php if($TPL_VAR["realnameinfo"]["useRealnamephone"]!='Y'){?>style="display:none;"<?php }?>>
						<li class="img"><img src="/data/skin/responsive_diary_petit_gl/images/common/join_img_phone.gif" alt="휴대폰 인증" /></li>
						<li class="contents">
							<p designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >휴대폰번호와 이름을 사용하여 본인확인을 합니다.</p>
						</li>
						<li class="btns">
							<a href="javascript:phonePopup('id');" class="btn_resp size_c color2 Wmax"><span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >휴대폰 인증</span></a>
						</li>
					</ul>
<?php if($TPL_VAR["realnameinfo"]["realnameId"]){?>
					<!-- 아이핀 -->
					<ul id="ipin_id_tab" class="find_confirm" <?php if($TPL_VAR["realnameinfo"]["useRealnamephone"]=='Y'){?>style="display:none;"<?php }?>>
						<li class="img"><img src="/data/skin/responsive_diary_petit_gl/images/common/join_img_ipin.gif" alt="아이핀 인증" /></li>
						<li class="contents">
							<p designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >주민등록번호 대신 사용하는 사이버 신원확인번호입니다.</p>
						</li>
						<li class="btns">
							<a href="javascript:ipinPopup('id');" class="btn_resp size_c color2 Wmax"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >아이핀 인증</span></a>
						</li>
					</ul>
					<!-- 안심체크 -->
					<ul id="auth_id_tab" class="find_confirm" style="display:none;">
						<li class="img"><img src="/data/skin/responsive_diary_petit_gl/images/common/join_img_name.gif" alt="안심체크 인증" /></li>
						<li class="contents">
							<p designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >주민등록번호 대신 이름, 생년월일, 성별, 유선전화 또는 주소로 인증합니다.</p>
						</li>
						<li class="btns">
							<a href="javascript:checkPopup('id');" class="btn_resp size_c color2 Wmax"><span designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >안심체크 인증</span></a>
						</li>
					</ul>
<?php }?>
<?php }?>
				<h3 class="title_sub2 v2 Mt20"><b><span designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >등록 정보로 아이디 찾기</span></b></h3>
				<p class="gray_06 C" designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >회원가입 시 등록한 정보로 찾을 수 있습니다.</p>
				<div class="label_group v2">
					<label><input type="radio" name="find_gb" value="email" checked /> <span designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >이메일</span></label>
<?php if($TPL_VAR["sms_auth"]&&$TPL_VAR["findid_user_yn"]=='Y'){?>
					<label><input type="radio" name="find_gb" value="cellphone"/> <span designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >휴대폰</span></label>
<?php }?>
				</div>
				<div class="resp_join_table v2 th_size3">
					<ul>
						<li class="th "><p designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >이름</p></li>
						<li class="td">
							<input type="text" name="user_name" value="" class="size_full" />
						</li>
					</ul>
					<ul id="id_em">
						<li class="th "><p designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >이메일</p></li>
						<li class="td">
							<input type="email" name="email" value="" class="size_full" />
						</li>
					</ul>
					<ul id="id_cp" style="display:none;">
						<li class="th "><p designElement="text" textIndex="21"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >휴대폰</p></li>
						<li class="td">
							<input type="tel" name="cellphone[]" value="" class="size_phone" /> - 
							<input type="tel" name="cellphone[]" value="" class="size_phone" /> - 
							<input type="tel" name="cellphone[]" value="" class="size_phone" />
						</li>
					</ul>
<?php if($TPL_VAR["id_search_captcha_html"]){?>
					<ul>
						<li class="th "><p designElement="text" textIndex="22"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >보안문자</p></li>
						<li class="td">
							<div class="captcha_wrap"><?php echo $TPL_VAR["id_search_captcha_html"]?></div>
						</li>
					</ul>
<?php }?>
				</div>
				<div class="btn_area_b">
					<button type="submit" class="btn_resp size_c color2 Wmax" /><span designElement="text" textIndex="23"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >확인</span></button>
				</div>
			</div>

			<!-- 아이디 찾기 결과 -->
			<div id="findidresultlay" class="find_id_result" style="display:none;">
				<div class="auth_result">
					<div class="findidresultok1">
						<p designElement="text" textIndex="24"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >고객님의 아이디는 <strong class="pointcolor2" id="findidlay1"></strong> 입니다.</p>
					</div>
					<div class="findidresultok2 hide">
						<p designElement="text" textIndex="25"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >회원 이메일 주소(<strong class="pointcolor2" id="findidlay2"></strong>)로 정보가 발송되었습니다.<br/>메일을 확인하시기 바랍니다.</p>
					</div>
					<div class="findidresultok3 hide">
						<p designElement="text" textIndex="26"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >회원 휴대폰(<strong class="blue" id="findidlay3"></strong>)으로 정보가 발송되었습니다.<br/>SMS를 확인하시기 바랍니다.</p>
					</div>
					<div class="findidresultfalse">
						<p designElement="text" textIndex="27"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" ><strong class="pointcolor">일치하는 정보가 없습니다.</strong><br/>아이디 찾기 방법을 변경하거나 회원가입을 해주세요.</p>
					</div>
					<div class="findidresultok1 findidresultok2 findidresultok3 btn_area_c hide">
						<a href="javascript:;" class="btn_find_pw btn_resp size_c color2"><span designElement="text" textIndex="28"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >비밀번호 찾기</span></a>
						<a href="/member/login?return_url=/main" class="btn_resp size_c color5"><span designElement="text" textIndex="29"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >로그인</span></a>
					</div>
					<div class="findidresultfalse btn_area_c hide">
						<a href="javascript:;" class="btn_find_id btn_resp size_c color2"><span designElement="text" textIndex="30"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >아이디 찾기</span></a>
						<a href="/member/agreement" class="btn_resp size_c color5"><span designElement="text" textIndex="31"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >회원가입</span></a>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- +++++++++++++++++++++ //아이디 찾기 +++++++++++++++++++++ -->

	<!-- +++++++++++++++++++++ 비밀번호 찾기 +++++++++++++++++++++ -->
	<div class="idPwContents" id="pwFindArea" style="display:none;">
		<a name="findpw"></a>
		<form name="loginForm2" target="actionFrame" method="post" action="<?php echo sslAction('../login_process/findpwd')?>">
			<div id="findpwfromlay">
<?php if($TPL_VAR["realnameinfo"]["useRealnamephone"]=='Y'||$TPL_VAR["realnameinfo"]["realnameId"]){?>
					<h3 class="title_sub2 v2 Mt20"><b><span designElement="text" textIndex="32"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >본인인증 수단으로 임시 비밀번호 찾기</span></b></h3>
					<p class="gray_06 C Pb15" designElement="text" textIndex="33"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >실명이 확인된 회원은 인증을 통하여 찾을 수 있습니다.</p>
					<div class="resp_join_table v2 th_size3">
						<ul>
							<li class="th "><p designElement="text" textIndex="34"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >아이디</p></li>
							<li class="td">
								<input type="text" name="userids_find" value="" class="size_full" />
							</li>
						</ul>
					</div>
					<div class="label_group v2">
<?php if($TPL_VAR["realnameinfo"]["useRealnamephone"]=='Y'){?>
						<label><input type="radio" name="auth_type" findtype="pw" value="phone" checked /> <span designElement="text" textIndex="35"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >휴대폰</span></label>
<?php }?>
<?php if($TPL_VAR["realnameinfo"]["realnameId"]){?>
						<label><input type="radio" name="auth_type" findtype="pw"  value="ipin" <?php if($TPL_VAR["realnameinfo"]["useRealnamephone"]!='Y'){?>checked<?php }?> /> <span designElement="text" textIndex="36"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >아이핀(i-Pin)</span></label>
						<label><input type="radio" name="auth_type" findtype="pw"  value="auth" /> <span designElement="text" textIndex="37"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >안심체크</span></label>
<?php }?>
					</div>
					<!-- 휴대폰 -->
<?php if($TPL_VAR["realnameinfo"]["useRealnamephone"]=='Y'){?>
					<ul id="phone_pw_tab" class="find_confirm" <?php if($TPL_VAR["realnameinfo"]["useRealnamephone"]!='Y'){?> style="display:none;"<?php }?>>
						<li class="img"><img src="/data/skin/responsive_diary_petit_gl/images/common/join_img_phone.gif" alt="휴대폰 인증" /></li>
						<li class="contents">
							<p designElement="text" textIndex="38"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >휴대폰번호와 이름을 사용하여 본인확인을 합니다.</p>
						</li>
						<li class="btns">
							<a href="javascript:phonePopup('pw');" class="btn_resp size_c color2 Wmax"><span designElement="text" textIndex="39"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >휴대폰 인증</span></a>
						</li>
					</ul>
<?php }?>
<?php if($TPL_VAR["realnameinfo"]["realnameId"]){?>
					<!-- 아이핀 -->
					<ul id="ipin_pw_tab" class="find_confirm" <?php if($TPL_VAR["realnameinfo"]["useRealnamephone"]=='Y'){?> style="display:none;"<?php }?>>
						<li class="img"><img src="/data/skin/responsive_diary_petit_gl/images/common/join_img_ipin.gif" alt="아이핀 인증" /></li>
						<li class="contents">
							<p designElement="text" textIndex="40"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >주민등록번호 대신 사용하는 사이버 신원확인번호입니다.</p>
						</li>
						<li class="btns">
							<a href="javascript:ipinPopup('pw');" class="btn_resp size_c color2 Wmax"><span designElement="text" textIndex="41"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >아이핀 인증</span></a>
						</li>
					</ul>
					<!-- 안심체크 -->
					<ul id="auth_pw_tab" class="find_confirm" style="display:none;">
						<li class="img"><img src="/data/skin/responsive_diary_petit_gl/images/common/join_img_name.gif" alt="안심체크 인증" /></li>
						<li class="contents">
							<p designElement="text" textIndex="42"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >주민등록번호 대신 이름, 생년월일, 성별, 유선전화 또는 주소로 인증합니다.</p>
						</li>
						<li class="btns">
							<a href="javascript:checkPopup('pw');" class="btn_resp size_c color2 Wmax"><span designElement="text" textIndex="43"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >안심체크 인증</span></a>
						</li>
					</ul>
<?php }?>
<?php }?>

				<h3 class="title_sub2 v2 Mt20"><b><span designElement="text" textIndex="44"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >등록 정보로 임시 비밀번호 찾기</span></b></h3>
				<p class="gray_06 C" designElement="text" textIndex="45"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >회원가입 시 등록한 정보로 찾을 수 있습니다.</p>
				<div class="label_group v2">
					<label><input type="radio" name="finds_gb" value="emails" checked /> <span designElement="text" textIndex="46"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >이메일</span></label>
<?php if($TPL_VAR["sms_auth"]&&$TPL_VAR["findpwd_user_yn"]=='Y'){?>
					<label><input type="radio" name="finds_gb" value="cellphones" /> <span designElement="text" textIndex="47"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >휴대폰</span></label>
<?php }?>
				</div>
				<div class="resp_join_table v2 th_size3">
					<ul>
						<li class="th "><p designElement="text" textIndex="48"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >이름</p></li>
						<li class="td">
							<input type="text" name="user_names" value="" class="size_full" />
						</li>
					</ul>
					<ul>
						<li class="th "><p designElement="text" textIndex="49"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >아이디</p></li>
						<li class="td">
							<input type="text" name="userids" value="" class="size_full" />
						</li>
					</ul>
					<ul id="pwd_em">
						<li class="th "><p designElement="text" textIndex="50"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >이메일</p></li>
						<li class="td">
							<input type="email" name="emails" value="" class="size_full" />
						</li>
					</ul>
					<ul id="pwd_cp" style="display:none;">
						<li class="th "><p designElement="text" textIndex="51"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >휴대폰</p></li>
						<li class="td">
							<input type="tel" name="cellphones[]" value="" class="size_phone" /> - 
							<input type="tel" name="cellphones[]" value="" class="size_phone" /> - 
							<input type="tel" name="cellphones[]" value="" class="size_phone" />
						</li>
					</ul>
<?php if($TPL_VAR["pass_search_captcha_html"]){?>
					<ul>
						<li class="th "><p designElement="text" textIndex="52"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >보안문자</p></li>
						<li class="td">
							<div class="captcha_wrap"><?php echo $TPL_VAR["pass_search_captcha_html"]?></div>
						</li>
					</ul>
<?php }?>
				</div>
				<div class="btn_area_b">
					<button type="submit" class="btn_resp size_c color2 Wmax" /><span designElement="text" textIndex="53"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >확인</span></button>
				</div>
			</div>

			<!-- 비밀번호 찾기 결과 -->
			<div id="findpwresultlay" class="find_id_result" style="display:none;">
				<div class="auth_result">
					<div class="findpwresultok1 hide">
						<p designElement="text" textIndex="54"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >고객님의 임시 비밀번호는 <strong class="pointcolor2" id="findpwlay1"></strong> 입니다.<br/>로그인하신 후 변경해주세요.</p>
					</div>
					<div class="findpwresultok2 hide">
						<p designElement="text" textIndex="55"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >회원 이메일 주소(<strong class="pointcolor2" id="findpwlay2"></strong>)로 임시 비밀번호가 발송되었습니다.<br/>메일을 확인하시기 바랍니다.</p>
					</div>
					<div class="findpwresultok3 hide">
						<p designElement="text" textIndex="56"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >회원 휴대폰(<strong class="pointcolor2" id="findpwlay3"></strong>)으로 임시 비밀번호가 발송되었습니다.<br/>SMS를 확인하시기 바랍니다.</p>
					</div>
					<div class="findpwresultfalse1 hide">
						<p designElement="text" textIndex="57"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" ><strong class="pointcolor">일치하는 정보가 없습니다.</strong><br/>찾기 방법을 변경하거나 회원가입을 해주세요.</p>
					</div>
					<div class="findpwresultfalse2 hide">
						<p designElement="text" textIndex="58"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" ><strong class="pointcolor">입력한 아이디와 인증한 정보가 맞지 않습니다.</strong><br/>아이디를 다시 확인해주세요.</p>
					</div>
					<div class="findpwresultok1 findpwresultok2 findpwresultok3 btn_area_c hide">
						<a href="/member/login?return_url=/main" class="btn_resp size_c color2 Wmax" designElement="text" textIndex="59"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >로그인</a>
					</div>
					<div class="findpwresultfalse1 btn_area_c hide">
						<a href="javascript:;" class="btn_find_pw btn_resp size_c color2"><span designElement="text" textIndex="60"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >비밀번호 찾기</span></a>&nbsp;
						<a href="/member/agreement" class="btn_resp size_c color5" designElement="text" textIndex="61"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >회원가입</a>
					</div>
					<div class="findpwresultfalse2 btn_area_c hide">
						<a href="javascript:;" class="btn_find_id btn_resp size_c color2 Wmax"><span designElement="text" textIndex="62"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >아이디 찾기</span></a>
					</div>
				</div>
			</div>
			<!-- //비밀번호 찾기 결과 -->

<?php if($TPL_VAR["joinform"]["use_f"]||$TPL_VAR["joinform"]["use_t"]||$TPL_VAR["joinform"]["use_m"]||$TPL_VAR["joinform"]["use_c"]){?>
			<ul class="list_dot_01 Mt20 gray_06">
				<li><p designElement="text" textIndex="63"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvZmluZC5odG1s" >SNS 계정으로 가입한 회원의 비밀번호는 저장하고 있지 않으며 해당 SNS 서비스 제공사에 문의하시길 바랍니다.</p></li>
			</ul>
<?php }?>
		</form>
	</div>
	<!-- +++++++++++++++++++++ //비밀번호 찾기 +++++++++++++++++++++ -->
</div>

<script type="text/javascript">
	$(document).ready(function() {
		// 탭 컨텐츠
		$('#idPwTab a').click(function() {
			var gon = $(this).data('tab');
			$('#idPwTab>li').removeClass('on');
			$(this).parent('li').addClass('on');
			$('.idPwContents').hide();
			$('#' + gon).show();
		});
<?php if($_GET["mode"]=='findpw'){?>
			$('[data-tab=pwFindArea]').click();
<?php }else{?>
			$('[data-tab=idFindArea]').click();
<?php }?>


		$("input[name='find_gb']").click(function() {
			if($(this).val()=='email'){
				$("#id_em").show();
				$("#id_cp").hide();
			}else{
				$("#id_em").hide();
				$("#id_cp").show();
			}
		});

		$("input[name='finds_gb']").click(function() {
			if($(this).val()=='emails'){
				$("#pwd_em").show();
				$("#pwd_cp").hide();
			}else{
				$("#pwd_em").hide();
				$("#pwd_cp").show();
			}
		});

		//본인인증 수단선택
		$("input:radio[name='auth_type']").live("click",function(){
			var findtype = $(this).attr("findtype");
			$(".findtype_auth").val(findtype);
			if($(this).val()=='phone'){
				$("#phone_"+findtype+"_tab").show();
				$("#ipin_"+findtype+"_tab").hide();
				$("#auth_"+findtype+"_tab").hide();
			}else if($(this).val()=='ipin'){
				$("#phone_"+findtype+"_tab").hide();
				$("#ipin_"+findtype+"_tab").show();
				$("#auth_"+findtype+"_tab").hide();
			}else{
				$("#phone_"+findtype+"_tab").hide();
				$("#ipin_"+findtype+"_tab").hide();
				$("#auth_"+findtype+"_tab").show();
			}
		});

		$(".btn_find_id").click(function() {
			document.location.href="/member/find?mode=findid";//?#findid
		});

		$(".btn_find_pw").click(function() {
			document.location.href="/member/find?mode=findpw";//?#findpw
		});
	});

	window.name ="Parent_window";

	//본인인증:휴대폰
	function phonePopup(findtype_auth){
		if( findtype_auth == 'pw' && !$("input[name='userids_find']").val() ){//비번착시기
			//아이디를 정확히 입력해 주세요.
			openDialogAlert(getAlert('mb184'),'400','140',function(){$("input[name='userids_find']").focus();});
			return;
		}
		var url = "../member_process/realnamecheck?findidpw=1&realnametype=phone";
		url += "&sReserved1="+findtype_auth;
		if( findtype_auth == 'pw' ) url += "&sReserved2="+$("input[name='userids_find']").val();
		window.open(url, 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
	}

	//아이핀 실명인증
	function ipinPopup(findtype_auth){
		if( findtype_auth == 'pw' && !$("input[name='userids_find']").val() ){//비번착시기
			openDialogAlert(getAlert('mb184'),'400','140',function(){$("input[name='userids_find']").focus();});
			return;
		}
		var url = "../member_process/realnamecheck?findidpw=1&realnametype=ipin";
		url += "&sReserved1="+findtype_auth;
		if( findtype_auth == 'pw' ) url += "&sReserved2="+$("input[name='userids_find']").val();
		window.open(url, 'popupIPIN2', 'width=450, height=550, top=100, left=100,fullscreen=no, menubar=no status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
	}

	//안심체크 실명인증
	function checkPopup(findtype_auth){
		if( findtype_auth == 'pw' && !$("input[name='userids_find']").val() ){//비번착시기
			openDialogAlert(getAlert('mb184'),'400','140',function(){$("input[name='userids_find']").focus();});
			return;
		}
		var url = "../member_process/realnamecheck?findidpw=1&realnametype=check";
		url += "&sReserved1="+findtype_auth;
		if( findtype_auth == 'pw' ) url += "&sReserved2="+$("input[name='userids_find']").val();
		window.open(url, 'niceID_popup', 'width=500, height=550, toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,top=0,left=0,location=no');
	}
</script>