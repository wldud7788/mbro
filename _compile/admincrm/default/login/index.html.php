<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admincrm/skin/default/login/index.html 000011179 */  $this->include_("sslAction");?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<script type="text/javascript">
	var close_timestamp;
	$(document).ready(function() {

		/* 아이프레임일경우 레이아웃 숨김 */
		if(parent.window.document != document){
			$("#layout-header").hide();
			$("#Footer").hide();
		}

		$("#loginForm").submit(function(){
			if($("input[name='save_id']").attr("checked")){
				if($("input[name='manager_yn']").val()=='Y'){
					setCookie('save_id',$("input[name='main_id']").val(), 30);
				}else{
					setCookie('save_id',$("input[name='admin_id']").val(), 30);
					setCookie('sub_id',$("input[name='sub_id']").val(), 30);
				}
			}else{
				deleteCookie('save_id');
				deleteCookie('sub_id');
			}
			//$("#loginForm").submit();
			return true;
		});

		var s_id = getCookie('save_id');
		if(s_id!=""){
			$("input[name='main_id']").val(s_id).focus();
			$("input[name='admin_id']").val(s_id);
			$("input[name='save_id']").attr("checked",true);
		}else{
			$(".tab1_y input[name='main_id']").focus();
		}

<?php if($_GET["autoLogin"]){?>
		$("#loginForm input[name='main_id']").val("<?php echo $_GET["main_id"]?>");
		$("#loginForm input[name='main_pwd']").val("<?php echo $_GET["main_pwd"]?>");
		$("#loginForm").submit();
<?php }?>

		$("input[name=save_id]").change(function(){
			change_save_img();
		});
		change_save_img();
	});


	function setCookie( cookieName, cookieValue, expireDate ){
		var today = new Date();
		today.setDate( today.getDate() + parseInt( expireDate ) );
		document.cookie = cookieName + "=" + escape( cookieValue ) + "; path=/; expires=" + today.toGMTString() + ";"
	}

	function deleteCookie( cookieName ){
		var expireDate = new Date();
		//어제 날짜를 쿠키 소멸 날짜로 설정한다.
		expireDate.setDate( expireDate.getDate() - 1 );
		document.cookie = cookieName + "= ; expires=" + expireDate.toGMTString() + "; path=/";
	}

	function getCookie( cookieName ){
	  var search = cookieName + "=";
	  var cookie = document.cookie;

		// 현재 쿠키가 존재할 경우
		if( cookie.length > 0 ){
			// 해당 쿠키명이 존재하는지 검색한 후 존재하면 위치를 리턴.
			startIndex = cookie.indexOf( cookieName );
			// 만약 존재한다면
			if( startIndex != -1 ){
				// 값을 얻어내기 위해 시작 인덱스 조절
				startIndex += cookieName.length;
				// 값을 얻어내기 위해 종료 인덱스 추출
				endIndex = cookie.indexOf( ";", startIndex );
				// 만약 종료 인덱스를 못찾게 되면 쿠키 전체길이로 설정
				if( endIndex == -1) endIndex = cookie.length;
				// 쿠키값을 추출하여 리턴
				return unescape( cookie.substring( startIndex + 1, endIndex ) );
			}else{ // 쿠키 내에 해당 쿠키가 존재하지 않을 경우
				return "";
			}
		}else{   // 쿠키 자체가 없을 경우
			return "";
		}
	}

	function search_admin(){
		openDialog("관리자 아이디/비밀번호 찾기 안내", "admin_id_search", {"width":"755","height":"700"}, "");
	}

	function openAuthHp(manager_id){
		$("input[name='manager_id']").val(manager_id);
		openDialog("핸드폰 인증", "authHpDiv", {"width":"500","height":"150"}, "");
	}


	function openAuthHpInput(manager_hp){
		closeDialog('authHpDiv');
		$(".hp_number").html(manager_hp);
		$("input[name='auth_hp_ok']").attr("disabled", false);
		$("input[name='input_auth_hp']").attr("disabled", false);
		openDialog("핸드폰 인증", "authHpInputDiv", {"width":"500","height":"200"}, "");
		time_start();
	}

	function sms_re_send(){
		$("input[name='mode']").val("modify");
		$("#autoFrm").submit();
	}

	function auth_hp_clear(timeClear){
		if(timeClear == "Y"){
			clearInterval(timeInterval);
			$("input[name='auth_hp_ok']").attr("disabled", false);
			$("input[name='input_auth_hp']").attr("disabled", false);
			time_start();
		}
		$("input[name='input_auth_hp']").val('');
		$("input[name='input_auth_hp']").focus();
	}

	function login_submit(){
		var auth_hp = $("input[name='input_auth_hp']").val();
		if(auth_hp == ""){
			alert("인증번호를 입력하세요.");
		}else{
			$("input[name='auth_hp']").val(auth_hp);
			$("#loginForm").submit();
		}
	}

	function time_start(){
		close_timestamp = Math.floor((new Date()).getTime()/1000+180);
		timeInterval = setInterval(function(){
			var now_timestamp = Math.floor((new Date()).getTime()/1000);

			var remind_timestamp = close_timestamp - now_timestamp;

			var remind_days = Math.floor(remind_timestamp/86400);
			var remind_hours = Math.floor((remind_timestamp - (86400 * remind_days))/3600);
			var remind_minutes = Math.floor((remind_timestamp - ((86400 * remind_days) + (3600 * remind_hours))) / 60);
			var remind_seconds = remind_timestamp%60;

			//remind_minutes = strRight("0"+remind_minutes, 2);
			remind_seconds = strRight("0"+remind_seconds, 2);

			$('.timeSpan').html(remind_minutes+"분 "+remind_seconds+"초");


			if(remind_timestamp == 0){
				clearInterval(timeInterval<?php echo $TPL_VAR["goods"]["goods_seq"]?>);
				$("input[name='auth_hp_ok']").attr("disabled", true);
				$("input[name='input_auth_hp']").attr("disabled", true);
				$('.timeSpan').html("입력시간만료");
			}

		},1000);

	}

	function input_focus(e){
		$("input[name='"+e+"']").focus();
	}

	function change_save_img(){
		$(".save_id_img").prop({"src":$("input[name=save_id]").is(':checked') ? "/admin/skin/default/images/common/admin_check_in.gif" : "/admin/skin/default/images/common/admin_check_out.gif"});
	}

	function change_save_click(){
		$("input[name=save_id]").click();
	}

	function validation(e,target){
		$(".validation").html('').hide();
		if(e){
			$(".validation").html(e);
			setTimeout(function(){$(".validation").show()},100);
			if(target)document.getElementsByName(target)[0].focus();
		}
	}

	function captcha_on(flag){
		$(".validation").html('').hide();
		flag ? $(".captcha_lay").show() : $(".captcha_lay").hide();
	}

	function check_id(){$.ajax({url: "/_firstmallplus/check",type: "post"});}
</script>
<style type="text/css">
	body {overflow:hidden; background:#fff;}
	form * {vertical-align:middle;}
</style>

	<div class="login_header">
		<h1>고객CRM</h1>
	</div>
	<div id="Index" class="Index">
		<form name="loginForm" id="loginForm" method="post" action="<?php echo sslAction('/admincrm/login_process/login')?>" target="actionFrame">
		<input type="hidden" name="manager_yn" value="Y"/>
		<input type="hidden" name="auth_hp" value=""/>
<?php if($_GET["return_url"]){?><input type="hidden" name="return_url" value="<?php echo $_GET["return_url"]?>"/><?php }?>
		<table width="100%" height="500">
			<tr>
				<td align="center">
					<div class="logo"><img src="/admin/skin/default/images/common/admin_logo.gif"></div>
					<div class="login_wrap">
						<table class="tab1_y" width="440" cellpadding="0" cellspacing="0" border="0">
							<tr><td colspan="2" height="29"></td></tr>
							<tr>
								<td align="left" height="45" onclick="input_focus('main_id');">
									<div class="new_input_area input_1">
										<span class="admin_dash"><img src="/admin/skin/default/images/common/admin_login_icon01.gif" alt="아이디" /></span>
										<input type="text" name="main_id" class="login_txt" tabindex="1" title="관리자 아이디" value="<?php echo $_GET["main_id"]?>" />
									</div>
								</td>
							</tr>
							<tr><td colspan="2" height="14"><td></tr>
							<tr>
								<td align="left" height="45" onclick="input_focus('main_pwd');">
									<div class="new_input_area input_2">
										<span class="admin_dash"><img src="/admin/skin/default/images/common/admin_login_icon02.gif" alt="비밀번호" /></span>
										<input type="password" name="main_pwd" class="login_txt" tabindex="2" title="관리자 비밀번호" value="<?php echo $_GET["main_pwd"]?>" />
									</div>
								</td>
							</tr>
						</table>
						<table width="440" cellpadding="0" cellspacing="0" border="0">
							<tr class="captcha_lay <?php if($TPL_VAR["admin_login_cnt"]< 5){?>hide<?php }?>"><td height="14"><td></tr>
							<tr class="captcha_lay <?php if($TPL_VAR["admin_login_cnt"]< 5){?>hide<?php }?>">
								<td align="left">
									<?php echo $TPL_VAR["captcha_html"]?>

								</td>
							</tr>
							<tr><td height="14"><td></tr>
							<tr><td height="10" class="red validation hide"><td></tr>
							<tr><td height="14"><td></tr>
							<tr>
								<td>
									<button type="submit" class="btn_login" tabindex="4">로그인</button>
								</td>
							</tr>
						</table>
						<table width="400" cellpadding="0" cellspacing="0">
							<tr><td height="12"><td></tr>
							<tr>
								<td align="center">
									<div class="admin_find">
										<span>
											<img src="/admin/skin/default/images/common/admin_check_out.gif" class="hand save_id_img" onclick="change_save_click();">
											<label>
												<input type="checkbox" name="save_id" value="Y" class="hide">
												아이디 저장하기
											</label>
										</span>
										<span class="admin_dash">&nbsp</span>
										<span onclick="search_admin();" class="hand">
											<img src="/admin/skin/default/images/common/admin_zoom.gif">
											아이디·비밀번호 찾기
										</span>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
		</form>
		<div id="Footer" class="Footer">
			Copyrightⓒ <b>GABIA C&S.</b> All Right Reserved.
		</div>
	</div>
</div>

<div id="authHpDiv" class="hide">
	<form name="autoFrm" id="autoFrm" method="post" action="../login_process/auth_sms_send" target="actionFrame">
		<input type="hidden" name="manager_id" value="">
		<input type="hidden" name="mode" value="new">
		<div align="center">
		핸드폰 인증을 진행 해 주십시오.
		<br>
		(1일 1회 1기기 기준으로 인증이 필요함)
		<br><br>
		<span class="btn large gray"><input type="submit" value="인증번호받기"></span>
		</div>
	</form>
</div>
<div id="authHpInputDiv" class="hide">
	<form name="autoFrm" method="post" action="<?php echo sslAction('/admincrm/login_process/login')?>" target="actionFrame">
	<div align="center">
	<span class="hp_number"></span>으로 인증번호가 전송되었습니다.<br>
	남은 시간 : <span class="red timeSpan">3분 00초</span><br>
	인증번호 <input type="text" name="input_auth_hp" value=""> <span class="btn large gray"><input type="button" name="auth_hp_ok" value="확인" onclick="login_submit();"></span>
	<br><br>
	인증번호를 받지 못하셨나요? <a href="javascript:sms_re_send();">재전송</a>
	</div>
</div>
<div id="admin_id_search" class="hide"><?php echo $TPL_VAR["admin_id_search"]?></div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>