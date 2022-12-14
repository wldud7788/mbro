<?php /* Template_ 2.2.6 2021/12/15 17:10:32 /www/music_brother_firstmall_kr/data/skin/responsive_interior_modern_gl/_modules/common/html_footer.html 000002569 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ #HTML_FOOTER @@
- 파일위치 : [스킨폴더]/_modules/common/html_footer.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<?php if(!$_GET["iframe"]){?>
<div id="popupChangePassword" class="resp_layer_pop hide">
	<h4 class="title">비밀번호 변경</h4>
	<form id='passUpdateForm' method='post' action='/login_process/popup_change_pass' target='actionFrame'>
	<input type='hidden' name='password_mode' value='update'>
		<div class="y_scroll_auto2">
			<div class="layer_pop_contents v5">
				<h5 class="stitle">회원님의 소중한 개인정보 보호를 위해 비밀번호를 주기적으로 변경하시는 것이 좋습니다.</h5>
				<p class="desc Pb8">※ 비밀번호는 영문 대문자, 영문 소문자, 숫자, 특수문자 중 2가지 이상을 조합한 8~20자</p>
				<div class="resp_table_row input_form th_size3">
					<ul class="tr">
						<li class="th Pl5 Pr5">현재 비밀번호</li>
						<li class="td">
							<input type='password' name='old_password' value='' class='passwordField eng_only Wmax' />
						</li>
					</ul>
					<ul class="tr">
						<li class="th Pl5 Pr5">신규 비밀번호</li>
						<li class="td">
							<input type='password' name='new_password' value='' class='passwordField eng_only Wmax class_check_password_validation' />
						</li>
					</ul>
					<ul class="tr">
						<li class="th Pl5 Pr5">신규 비밀번호 <span class="Dib">확인</span></li>
						<li class="td">
							<input type='password' name='re_new_password' value='' class='passwordField eng_only Wmax' />
						</li>
					</ul>
				</div>
				<div class="C Pt20 Fs15">
					<label><input type='checkbox' name='update_rate' value='Y' onclick='update_rate_checked();'> <?php echo $TPL_VAR["passwordRate"]?>개월 이후에 비밀번호를 변경하겠습니다.</label>
				</div>
			</div>
		</div>
		<div class="layer_bottom_btn_area2 v2">
			<ul class="basic_btn_area2">
				<li><button type="submit" class="btn_resp size_c color2">변경 완료</button></li>
				<li><button type="button" class="btn_resp size_c color5" onclick="hideCenterLayer()">취소</button></li>
			</ul>
		</div>
		<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
	</form>
</div>
<?php }?>
<?php echo header_requires()?></body>
</html>