<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/member/adult_auth.html 000006927 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 성인인증 @@
- 파일위치 : [스킨폴더]/member/adult_auth.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="title_container Pt50">
	<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >성인인증</span></h2>
</div>

<div class="mypage_greeting Lh16 pointcolor imp">
	<div style="text-align:center; padding: 20px 0 20px 0;"><img src="/data/skin/responsive_sports_sporti_gl/images/common/top_img_minor.gif" alt="19세 미만 출입금지" /></div>
	<div style="padding: 0 20px 0 20px;">
		<p style="padding-bottom:10px; font-size:30px; line-height:1.2; font-weight:700; color:red; text-align:center;" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >본 상품정보는 '청소년에게 유해한 정보'를 포함하고 있어서, 성인여부 인증이 필요합니다.</p>
		<p style="font-size:20px; text-align:center; line-height: 1.2; padding:0 4% 0 4%;" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >이 정보내용은 「청소년유해매체물로서 정보통신망 이용촉진 및 정보보호 등에 관한 법률」 및 「청소년 보호법」에 따라 19세 미만의 청소년이 이용할 수 없습니다.</p>
	</div>
	
	<div style="width:100%; padding: 20px 0 0 0; text-align:center;">
		<p style="display:inline-block;"><a class="btn_resp size_c color3 Wmax" href="https://firstmall.kr" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >19세 미만 나가기</a></p>
	</div>
</div>
	
<div class="center_contents_layout">
	<div class="inner C">
		<form name="authForm" id="authForm" action="../member_process/auth_chk" target="actionFrame" method="post">
		<input type="hidden" name="return_url" value="<?php echo $TPL_VAR["return_url"]?>"/>

			<h3 class="title_sub1 C"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >아래의 본인인증 수단으로 인증을 진행해주세요.</span></h3>

			

<?php if($TPL_VAR["realnameinfo"]["useRealnamephone_adult"]=='Y'){?>
			<h3 class="title_sub2 v2 Fs24 Mt10"><b><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >휴대폰 인증</span></b></h3>
			<p style="padding:0 0 15px; font-size:15px; color:#767676;" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >휴대폰번호와 이름을 사용하여 본인확인을 합니다.</p>
			<a href="javascript:phonePopup();" class="btn_resp size_c color2 Wmax"><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >휴대폰 인증</span></a>
<?php }?>

<?php if($TPL_VAR["realnameinfo"]["useRealnamephone_adult"]=='Y'&&$TPL_VAR["realnameinfo"]["useIpin_adult"]=='Y'){?>
			<div></div>

<?php }elseif($TPL_VAR["realnameinfo"]["useRealnamephone_adult"]!='Y'&&$TPL_VAR["realnameinfo"]["useIpin_adult"]!='Y'){?>
			<p class="no_data_area2 Mt20" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >성인인증 수단이 없습니다. 쇼핑몰 고객센터로 문의해주십시오.</p>
<?php }?>
			
<?php if($TPL_VAR["realnameinfo"]["useIpin_adult"]=='Y'){?>
			<h3 class="title_sub2 v2 Fs24 Mt10"><b><span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >아이핀 인증</span></b></h3>
			<p style="padding:0 0 15px; font-size:15px; color:#767676;" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >주민등록번호 대신 사용하는 사이버 신원확인번호입니다.</p>
			<a href="javascript:ipinPopup();" class="btn_resp size_c color2 Wmax"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >아이핀 인증</span></a>
<?php }?>


			<ul class="list_dot_01 L Mt30">
				<li><span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >본인확인이 되지 않는 경우 아래의 본인확인기관에 본인인증 등록을 요청할 수 있습니다.</span> (<a href="http://www.idcheck.co.kr" target="_blank" designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" ><u>한국신용정보㈜</u></a> <a href="tel:1588-2486" designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >1588-2486</a>)</li>
				<li><p designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZHVsdF9hdXRoLmh0bWw=" >타인의 개인정보를 부정하게 사용하는 경우 3년 이하의 징역 또는 1천만원 이하의 벌금에 처해질 수 있습니다.</p></li>
			</ul>
		</form>
	</div>
	
	<div>
		<div style="width:100%; padding: 30px 0 30px 0; text-align:center;">
			<p style="display:inline-block; font-size: 18px;">www.<?php echo $TPL_VAR["domain"]?></p>
		</div>
	</div>
</div>


<script type="text/javascript">
	var return_url = "";
<?php if($TPL_VAR["return_url"]){?>
		return_url = "&return_url=<?php echo $TPL_VAR["return_url"]?>";
<?php }?>
	//본인인증:휴대폰
	function phonePopup(){
		var url = "../member_process/realnamecheck?intro=1&realnametype=phone"+return_url;
		window.open(url, 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
	}

	//아이핀 실명인증
	function ipinPopup(){
		var url = "../member_process/realnamecheck?intro=1&realnametype=ipin"+return_url;
		window.open(url, 'popupIPIN2', 'width=450, height=550, top=100, left=100,fullscreen=no, menubar=no status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
	}

	//안심체크 실명인증
	function checkPopup(){
		var url = "../member_process/realnamecheck?intro=1&realnametype=check"+return_url;
		window.open(url, 'niceID_popup', 'width=500, height=550, toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,top=0,left=0,location=no');
	}
</script>