<?php /* Template_ 2.2.6 2020/12/14 17:12:54 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/member/popup_change_pass.html 000005038 */ ?>
<style>
.keyboard_guide {position:relative; padding:12px 0 0; min-height:10px; text-align:center;}
.keyboard_guide a[href='#keyboard_specialchars'] {position:absolute; left:5px; top:5px; display:none;}
.keyboard_guide a[href='#keyboard_hangul'] {position:absolute; left:5px; top:5px; display:none;}
.keyboard_guide a[href='#keyboard_open'] {position:absolute; right:5px; top:5px;}
.keyboard_guide a[href='#keyboard_close'] {position:absolute; right:5px; top:5px; display:none;}
.keyboard_guide_img {display:none}
.keyboard_guide_img .keyboard_hangul {margin:20px auto 0 auto; width:290px; height:80px; background:url('/data/skin/responsive_diary_petit_gl/images/common/keyboard.gif') no-repeat; background-size:100% auto}
.keyboard_guide_img .keyboard_specialchars {margin:20px auto 0 auto; width:290px; height:60px; background:url('/data/skin/responsive_diary_petit_gl/images/common/keyboard.gif') no-repeat 0 -85px; background-size:100% auto; display:none;}

.pw_ch_wrap { line-height:1.5; font-size:14px; font-weight:400; }
</style>

<script>
$(function(){
	$("a[href='#keyboard_specialchars'], a[href='#keyboard_hangul']").click(function(){
		if($(this).attr('href')=='#keyboard_specialchars'){
			$("a[href='#keyboard_specialchars']").hide();
			$("a[href='#keyboard_hangul']").show();

			$(".keyboard_hangul").hide();
			$(".keyboard_specialchars").show();
		}else{
			$("a[href='#keyboard_specialchars']").show();
			$("a[href='#keyboard_hangul']").hide();

			$(".keyboard_hangul").show();
			$(".keyboard_specialchars").hide();
		}
	});

	$("a[href='#keyboard_open'], a[href='#keyboard_close']").click(function(){
		if($(this).attr('href')=='#keyboard_open'){
			$("a[href='#keyboard_hangul']").click();
			$("a[href='#keyboard_open']").hide();
			$("a[href='#keyboard_close']").show();
			$(".keyboard_guide_img").show();
		}else{
			$("a[href='#keyboard_specialchars'], a[href='#keyboard_hangul']").hide();
			$("a[href='#keyboard_open']").show();
			$("a[href='#keyboard_close']").hide();
			$(".keyboard_guide_img").hide();
		}
	});
});

$(function(){
	$("form[name='loginForm'] input[name='userid']").focus();
});

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
}//t
</script>

<div class="pw_ch_wrap">
	<div class="title_group1">
		<h3 class="title1">비밀번호 변경</h3>
	</div>

	<p class="Fs18 Fw300">회원님의 소중한 개인정보 보호를 위해 비밀번호를 주기적으로 변경하시는 것이 좋습니다.</p>
	<p class="Fs16 red Pt5 Pb20">※ 어플에서는 이전 비밀번호로 로그인 하셔야합니다.</p>
	<p class="Fs16 orange Pt5 Pb20">※ 비밀번호는 6~20자, 영문 대소문자 또는 숫자 특수문자 중 2가지 이상 조합.</p>

	<form id='passUpdateForm' method='post' action='/login_process/popup_change_pass' target='actionFrame'>
	<input type='hidden' name='password_mode' value='update'>
		<div class="resp_table_row input_form th_size3 Mb5">
			<ul class="tr">
				<li class="th Pl5 Pr5">현재 비밀번호</li>
				<li class="td">
					<input type='password' name='old_password' value='' class='passwordField eng_only Wmax' />
				</li>
			</ul>
			<ul class="tr">
				<li class="th Pl5 Pr5">신규 비밀번호</li>
				<li class="td">
					<input type='password' name='new_password' value='' class='passwordField eng_only Wmax' />
				</li>
			</ul>
			<ul class="tr">
				<li class="th Pl5 Pr5">신규 비밀번호 <span class="Dib">확인</span></li>
				<li class="td">
					<input type='password' name='re_new_password' value='' class='passwordField eng_only Wmax' />
				</li>
			</ul>
		</div>

		<div class="keyboard_guide">
			<a href="#keyboard_specialchars">특수 기호 보기</a>
			<a href="#keyboard_hangul">한글 보기</a>
			<a href="#keyboard_open">PC 키보드 보기 ▼</a>
			<a href="#keyboard_close">PC 키보드 닫기 ▲</a>

			<div class="keyboard_guide_img">
				<div class="keyboard_hangul"></div>
				<div class="keyboard_specialchars"></div>
			</div>
		</div>


		<div class="C Pt20 Fs15">
			<label><input type='checkbox' name='update_rate' value='Y' onclick='update_rate_checked();'> <?php echo $TPL_VAR["passwordRate"]?>개월 이후에 비밀번호를 변경하겠습니다.</label>
		</div>
		<ul class="basic_btn_area2 Mt20">
			<li><button type="submit" class="btn_resp size_c color2">확인</button></li>
			<li><button type="button" class="btn_resp size_c color5 " onclick="passwordAfterUpdate()">취소</button></li>
		</ul>
	</form>
</div>