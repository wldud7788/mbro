<?php /* Template_ 2.2.6 2021/01/08 12:02:10 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/member/dormancy_auth.html 000006623 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 휴면해제 @@
- 파일위치 : [스킨폴더]/member/dormancy_auth.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">
	<div class="subpage_container v2">

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=" >휴면해제</span></h2>
		</div>
		<p class="mypage_greeting" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=" >쇼핑몰을 정상적으로 이용하려면 휴면해제가 필요합니다.<br />휴면해제하려면 본인확인 인증절차를 진행해주세요.<br /></p>
		
		<ul class="resp_auth_wrap">
<?php if($TPL_VAR["realnameinfo"]["useRealnamephone_dormancy"]=='Y'){?>
			<li>
				<ul class="resp_auth_container">
					<li class="img"><span class="img_outer"><img src="/data/skin/responsive_diary_petit_gl_1/images/common/join_img_phone.gif" alt="휴대폰 인증" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9qb2luX2ltZ19waG9uZS5naWY=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2NvbW1vbi9qb2luX2ltZ19waG9uZS5naWY=' designElement='image' /></span></li>
					<li class="txt"><p designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=" >휴대폰 번호와 이름을 사용하여<br />본인확인을 합니다.</p></li>
					<li class="btn"><a href="javascript:phonePopup();" class="btn_resp size_c color2" hrefOri='amF2YXNjcmlwdDpwaG9uZVBvcHVwKCk7' ><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=" >휴대폰 인증</span></a></li>
				</ul>
			</li>
<?php }?>
<?php if($TPL_VAR["realnameinfo"]["useIpin_dormancy"]=='Y'){?>
			<li>
				<ul class="resp_auth_container">
					<li class="img"><span class="img_outer"><img src="/data/skin/responsive_diary_petit_gl_1/images/common/join_img_ipin.gif" alt="아이핀 인증" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9qb2luX2ltZ19pcGluLmdpZg==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2NvbW1vbi9qb2luX2ltZ19pcGluLmdpZg==' designElement='image' /></span></li>
					<li class="txt"><p designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=" >주민등록번호 대신 사용하는<br />사이버 신원확인번호입니다.</p></li>
					<li class="btn"><a href="javascript:ipinPopup();" class="btn_resp size_c color2" hrefOri='amF2YXNjcmlwdDppcGluUG9wdXAoKTs=' ><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=" >아이핀 인증</span></a></li>
				</ul>
			</li>
<?php }?>
<?php if($TPL_VAR["realnameinfo"]["useRealname_dormancy"]=='Y'){?>
			<li>
				<ul class="resp_auth_container">
					<li class="img"><span class="img_outer"><img src="/data/skin/responsive_diary_petit_gl_1/images/common/join_img_ipin.gif" alt="아이핀 인증" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9qb2luX2ltZ19pcGluLmdpZg==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2NvbW1vbi9qb2luX2ltZ19pcGluLmdpZg==' designElement='image' /></span></li>
					<li class="txt"><p designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=" >주민등록번호 대신 사용하는<br />사이버 신원확인번호입니다.</p></li>
					<li class="btn"><a href="javascript:ipinPopup();" class="btn_resp size_c color2" hrefOri='amF2YXNjcmlwdDppcGluUG9wdXAoKTs=' ><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=" >아이핀 인증</span></a></li>
				</ul>
			</li>
<?php }?>
		</ul>

		<ul class="list_dot_01 gray_05 Mt20">
			<li><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=" >본인확인이 되지 않는 경우 아래의 본인확인기관에 본인인증 등록을 요청할 수 있습니다.</span> (<a href="http://www.idcheck.co.kr" target="_blank" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=" hrefOri='aHR0cDovL3d3dy5pZGNoZWNrLmNvLmty' ><u>한국신용정보㈜</u></a> <a href="tel:1588-2486" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=" hrefOri='dGVsOjE1ODgtMjQ4Ng==' >1588-2486</a>)</li>
			<li><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL21lbWJlci9kb3JtYW5jeV9hdXRoLmh0bWw=" >타인의 개인정보를 부정하게 사용하는 경우 3년 이하의 징역 또는 1천만원 이하의 벌금에 처해질 수 있습니다.</span></li>
		</ul>
	</div>
</div>







<!-- 본문내용 시작 -->
<div class="join_wrap">
	
</div>

<script type="text/javascript">
	var url = "../member_process/realnamecheck?dormancy=1&dormancy_seq=<?php echo $TPL_VAR["member_seq"]?>&";
	//본인인증:휴대폰
	function phonePopup(){
		var link_url = url + "realnametype=phone";
		window.open(link_url, 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
	}

	//아이핀 실명인증
	function ipinPopup(){
		var link_url = url + "realnametype=ipin";
		window.open(link_url, 'popupIPIN2', 'width=450, height=550, top=100, left=100,fullscreen=no, menubar=no status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
	}

	//안심체크 실명인증
	function checkPopup(){
		var link_url = url + "realnametype=check";
		window.open(link_url, 'niceID_popup', 'width=500, height=550, toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,top=0,left=0,location=no');
	}
</script>