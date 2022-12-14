<?php /* Template_ 2.2.6 2022/05/17 12:30:50 /www/music_brother_firstmall_kr/admin/skin/default/batch/sms_hp_auth.html 000002505 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common-ui.css?mm=<?php echo date('YmdHis')?>" />
<script type="text/javascript">
//본인인증:휴대폰
function phonePopup(){
	var url = "../batch_process/realnamecheck?realnametype=phone";
	window.open(url, 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
}

//아이핀 실명인증
function ipinPopup(){
	var url = "../batch_process/realnamecheck?realnametype=ipin";
	window.open(url, 'popupIPIN2', 'width=450, height=550, top=100, left=100,fullscreen=no, menubar=no status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 좌측 버튼 -- >
		<ul class="page-buttons-left">
			<li><span class="btn large orange"><button type="button" id="email_form">이메일 수동발송</button></span></li>
			<li><span class="btn large orange"><button type="button" id="sms_form">SMS 수동발송</button></span></li>
			<li><span class="btn large orange"><button type="button" id="emoney_form">마일리지</button></span></li>
			<li><span class="btn large orange"><button type="button" id="point_form">포인트</button></span></li>

		</ul-->

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>문자발송(대량)</h2>
		</div>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->
<div class="contents_container">
	<div class="center mt50">
	<img src="/admin/skin/default/images/design/accredit_box.gif" usemap="#authImg" class="">
	</div>
	<div class="box_style_05 mt30">
		<div class="title">안내</div>
		<ul class="bullet_circle">					
			<li>안전한 문자발송을 위해 인증이 필요합니다.</li>	
			<li>위 본인 인증 수단으로 인증을 진행해 주십시오.</li>	
			<li>인증 후 3시간 초과 시 재인증이 필요합니다.(PC기준)</li>	
		</ul>
	</div>
</div>


<map name="authImg">
	<area shape="RECT" coords="53,214,209,250" href="javascript:phonePopup();" title="" />
	<area shape="RECT" coords="358,213,514,251" href="javascript:ipinPopup();" title="" />
</map>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>