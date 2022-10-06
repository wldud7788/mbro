<?php /* Template_ 2.2.6 2021/04/05 16:02:58 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/member/register_ok.html 000001925 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 회원가입 완료 @@
- 파일위치 : [스킨폴더]/member/register_ok.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="title_container">
	<h2 class="pointcolor imp"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvcmVnaXN0ZXJfb2suaHRtbA==" >회원가입 완료!</span></h2>
</div>
<p class="mypage_greeting Pb30" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvcmVnaXN0ZXJfb2suaHRtbA==" >회원가입을 진심으로 축하드립니다.</p>

<div class="login_ok_menu">
	<ul>
<?php if($TPL_VAR["userInfo"]){?>
		<li><a class="btn_resp size_c color2" href="../mypage/myinfo" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvcmVnaXN0ZXJfb2suaHRtbA==" >회원정보수정</a></li>
<?php }else{?>
		<li><a class="btn_resp size_c color2" href="../member/login?return_url=<?php echo urlencode('../main/index')?>"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvcmVnaXN0ZXJfb2suaHRtbA==" >로그인</span></a></li>
<?php }?>
		<li><a class="btn_resp size_c color4" href="../main" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvcmVnaXN0ZXJfb2suaHRtbA==" >쇼핑하러가기</a></li>
	</ul>
</div>

<!-- 전환페이지 설정 -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script> 
<script type="text/javascript"> 
	if (!wcs_add) var wcs_add={};
	wcs_add["wa"] = "s_2741259f610f";
	var _nasa={};
	if(window.wcs){
		_nasa["cnv"] = wcs.cnv("2","1"); //전환유형, 전환가치
		wcs_do(_nasa);
	}
</script>