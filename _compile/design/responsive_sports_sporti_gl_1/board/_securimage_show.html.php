<?php /* Template_ 2.2.6 2021/12/15 16:50:22 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/board/_securimage_show.html 000000845 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 게시판 스팸방지( 캡챠 이미지 ) @@
- 파일위치 : [스킨폴더]/board/_securimage_show.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="simplelist-table-style boardfileliststyle captcha_code_container">	
	<div id="board_captcha" class="board_captcha" style="width:160px;" > <?php echo $TPL_VAR["captcha_image"]?></div>	
	<input type="text" style="width:150px;" name="captcha_code" id="captcha_code" class="captcha_code required" alt="좌측에 표시된 문자를 정확히 입력해 주세요."/>
	<span id="captcha_code_refresh" class="captcha_code_refresh hand"/>
</div>