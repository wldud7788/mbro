<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/login/index.html 000013502 */  $this->include_("sslAction");?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<style>

#progressbar {border-top-left-radius:8px;border-top-right-radius:8px;border-bottom-left-radius:8px;border-bottom-right-radius:8px}
</style>
<script type="text/javascript" src="/app/javascript/plugin/jquery.fmprogressbar.js"></script>
<script type="text/javascript" src="/app/javascript/js/selleradmin_login.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	/* 아이프레임일경우 레이아웃 숨김 */
	if(parent.window.document != document){
		$("#layout-header").hide();
		$("#Footer").hide();
	}

	$("#loginForm").submit(function(){
		if($("input[name='save_id']").attr("checked")){
			if($("input[name='manager_yn']").val()=='Y'){
				setCookie('save_pid',$("input[name='main_id']").val(), 30);
			}
		}else{
			deleteCookie('save_pid');
		}
		return true;
	});

	var s_id = getCookie('save_pid');
	if(s_id!=""){
		$("input[name='main_id']").val(s_id);
		$("input[name='sub_id']").val(s_id);
		$("input[name='save_id']").attr("checked",true);
		$(".tab1_y input[name='main_pwd']").focus();
	}else{
		$(".tab1_y input[name='main_id']").focus();
	}

	$("input[name=save_id]").change(function(){
		change_save_img();
	});
	change_save_img();
	
<?php if($TPL_VAR["autoLogin"]){?>
		document.loginForm.submit();
<?php }?>

	//아이디 패스워드 입력 이벤트
	$(".input_wrap .label").click(function(){
		$(this).addClass("on");
		$(this).parent().addClass("on");
		$(this).parent().find("input").removeClass("off");
		$(this).parent().find("input").focus();	
	})

	$(".input_wrap input").focusin(function(){
		$(this).parent().addClass("on");
		$(this).removeClass("off");
		$(this).parent().find(".label").addClass("on");
	})

	$(".input_wrap input").focusout(function(){
		var _parent = $(this).parent();
		var _label = $(this).parent().find(".label");
		
		_parent.removeClass("on");

		if($(this).val())
		{
			$(this).removeClass("off");
			_label.addClass("on");				
		}else{
			$(this).addClass("off");
			_label.removeClass("on");				
		}			
	})		
	
	setInputLabel();			
});

//라벨 세팅
function setInputLabel(){
	$(".input_wrap > div").each(function(){			
		var _input = $(this).find("input");
		var _label = $(this).find(".label");		
		if(_input.val()=="")
		{				
			_input.addClass("off")
			_label.removeClass("on");
		}else{	
			_input.removeClass("off")
			_label.addClass("on");				
		}
	})		
}

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
	}else{ // 쿠키 자체가 없을 경우
		return "";
	}
}

function openAuthHp(manager_id){
	$("input[name='manager_id']").val(manager_id);
	openDialog("핸드폰 인증", "authHpDiv", {"width":"500","height":"170"}, "");
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

function enterchk(){캡차
	if(event.keyCode==13){
		login_submit();
		event.returnValue=false;
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
	$("input[name=save_id]").is(':checked')? $(".save_id").addClass("on") : $(".save_id").removeClass("on");
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
	if(flag)
	{
		$(".captcha_lay").show();
		$(".login_form br").hide();
		
	}else{
		$(".captcha_lay").hide();
		$(".login_form br").show();
	}
}

function check_id(){$.ajax({url: "/_firstmallplus/check",type: "post"});}
</script>

<style type="text/css">
	input[type='text'], input[type='password'] {min-height: auto;}
	body  {overflow:hidden; background:#f9f9f9; height: 100%;}
	#wrap {display:table; width: 100%; height: 100%;}	
	.login_wrap {display:table-cell; text-align: center; vertical-align: middle;}
	.login_wrap ul {display:inline-block; border:1px solid #dadada; background:#FFF; padding:100px 55px 100px 130px;}
	.login_wrap ul > li {display:inline-block; float:left; text-align:left; line-height:1.5;}
	.login_wrap .login_form {margin: 10px 30px 10px 0; padding-right: 50px; border-right: 1px solid #e7e7e7; min-height: 392px;}
	.login_wrap .login_form h1 {margin:6px 0 30px; text-align:center; font-size:30px;}
	.login_wrap .login_form .input_wrap > div {border:1px solid #dadada; padding:10px 20px; border-radius:2px; position:relative; width:260px;}	
	.login_wrap .login_form .input_wrap > div.on {border:1px solid #4899ed; box-shadow: 0 3px 5px rgba(0,0,0,.2);}
	.login_wrap .login_form .input_wrap > div.id {margin-bottom:15px;}	
	.login_wrap .login_form .input_wrap > div .label {color:#c0c0c0; font-weight:600; width:100%;  font-size:18px; padding:7px 0;}
	.login_wrap .login_form .input_wrap > div .label.on {font-size:14px; padding:0;} 
	.login_wrap .login_form .input_wrap > div input { border:0 !important; width:100%; font-size:17px; padding:0;}
	.login_wrap .login_form .input_wrap > div input.off {height:0;} 
	.login_wrap .login_form .input_wrap > div input:focuse {height:auto;} 
	.login_wrap .login_form .save_id {margin-top:10px; font-size:15px; color:#c0c0c0; font-weight:600;}
	.login_wrap .login_form .save_id.on {color:#333;}
	.login_wrap .login_form .save_id label{letter-spacing: -1.5px;}
	.login_wrap .login_form .save_id img {padding:0 2px 0 3px;}
	.login_wrap .login_form .submit_btn {background:#68adf8; color:#FFF; border:0; width:100%; padding: 20px 0; font-size:20px !important; font-weight:600;  border-radius:2px; margin:10px 0 10px; box-shadow: 0 10px 20px rgba(0,0,0,.2); cursor:pointer;}
	.login_wrap .login_form .admin_find{font-size:15px; text-decoration:underline; color:#333; margin-top:5px;}
	.login_wrap .login_form .validation {color:#4899ed; margin-left: 30px;}

	.captcha_table {border: 1px solid #dadada; width: 100%; border-radius: 2px 2px 0 0; margin-top:5px;}
	.captcha_table .captcha_td2{border-left: 1px solid #dadada; text-align: center; width: 80px;}
	.captcha_text input {width: 100%; margin-top: -1px; border-radius: 0 0 2px 2px; padding: 7px 10px; border: 1px solid #dadada;}
	.login_right_banner {width:428px;}
</style>


<div class="Index login_wrap" id="Index">
	<ul>
		<!-- [ 좌측 컨텐츠 영역: 시작 ] -->
		<li class="login_form">
			<form name="loginForm" id="loginForm" method="post" action="/selleradmin/login_process/login" target="actionFrame">
				<input type="hidden" name="manager_yn" value="Y"/>
				<input type="hidden" name="auth_hp" value=""/>
<?php if($TPL_VAR["autoLogin"]){?>
				<input type="hidden" name="main_id" value="<?php echo $TPL_VAR["main_id"]?>" />
				<input type="hidden" name="main_pwd" value="<?php echo $TPL_VAR["main_pwd"]?>" />
<?php }else{?>			
				<h1><img src="/admin/skin/default/images/common/login_logo.png"></h1>

				<div class="input_wrap">
					<div class="id">
						<div class="label">아이디</div>
						<input type="text" name="main_id" tabindex="1" class="off" value="<?php echo $_GET["main_id"]?>" />
					</div>
					<div class="pwd">
						<div class="label">비밀번호</div>
						<input type="password" name="main_pwd" tabindex="2"  class="off" value="<?php echo $_GET["main_pwd"]?>" />
					</div>	
				</div>

				<div class="save_id">
					<img src="/admin/skin/default/images/common/admin_check_out.gif" class="hand save_id_img" onclick="change_save_click();" style="margin-bottom:3px;" align="absmiddle">
					<label>
						<input type="checkbox" name="save_id" value="Y" class="hide">
						아이디 저장
					</label>
				</div>	

				<div class="validation hide"></div>	
				<div class="captcha_lay <?php if($TPL_VAR["selleradmin_login_cnt"]< 5){?>hide<?php }?>"><?php echo $TPL_VAR["captcha_html"]?></div>
				<br class="<?php if($TPL_VAR["selleradmin_login_cnt"]>= 5){?>hide<?php }?>"/>
				<input type="submit"  class="submit_btn" tabindex="4" value="로그인">		
<?php }?>		
			</form>
		</li>
		<!-- [ 좌측 컨텐츠 영역: 끝 ] -->

		<!-- [ 우측 배너 영역: 시작 ] -->
		<li>
			<div class="login_right_banner"><?php echo $TPL_VAR["login_right_banner"]?></div>
		</li>
		<!-- [ 우측 배너 영역: 끝 ] -->
	</ul>
	
	<div class="Footer mt20 " id="Footer">
		Copyright ⓒ <b>GabiaCNS</b> Inc. All Rights Reserved.
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
	<form name="autoFrm" method="post" action="<?php echo sslAction('/selleradmin/login_process/login')?>" target="actionFrame">
	<div align="center">
	<span class="hp_number"></span>으로 인증번호가 전송되었습니다.<br>
	남은 시간 : <span class="red timeSpan">3분 00초</span><br>
	인증번호 <input type="text" name="input_auth_hp" value="" onkeydown="enterchk();"> <span class="btn large gray"><input type="button" name="auth_hp_ok" value="확인" onclick="login_submit();"></span>
	<br><br>
	인증번호를 받지 못하셨나요? <a href="javascript:sms_re_send();">재전송</a>
	</div>
	</form>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>