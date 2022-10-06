<?php /* Template_ 2.2.6 2022/05/17 12:36:31 /www/music_brother_firstmall_kr/admin/skin/default/member/top_menu.html 000001593 */ ?>
<!-- 상단 단계 링크 : 시작 -->
<ul class="tab_01 v2 menuTab">			
<?php if($_GET['sc_gb']=="PERSONAL"){?>
	<li><a onclick="location.href='curation';" value='curation'>리마인드 메시지 설정</a></li>
	<li><a onclick="location.href='curation_history_sms';" value='curation_history_sms'>SMS 발송 내역</a></li>
	<li><a onclick="location.href='curation_history_email';" value='curation_history_email'>이메일 발송 내역</a></li>
	<li><a onclick="location.href='curation_stat?first=1';" value='curation_stat'>유입 통계</a></li>	
<?php }else{?>
	<li><a onclick="formMoveSub('sms',1);" value='sms'>SMS 자동발송</a></li>
	<li><a onclick="formMoveSub('sms_history',2);" value='sms_history'>SMS 발송내역</a></li>
	<li><a onclick="formMoveSub('sms_charge',3);" value='sms_charge'>SMS 충전</a></li>
	<li><a onclick="formMoveSub('sms_auth',4);" value='sms_auth'>SMS 설정</a></li>
<?php }?>
</ul>
<!-- 상단 단계 링크 : 끝 -->

<script type="text/javascript">
	$(document).ready(function() {		
		//페이지 로딩시 해당 메뉴탭 활성
		var arr = $(location). attr("href").split("/");		
		var value= arr[arr.length-1].split("?")[0];
		$(".menuTab > li > a").each(function(){ 
			if(value==$(this).attr("value")) $(this).addClass("current");			
		})
	});

	function formMoveSub(gb, no){
		$(".current").removeClass("current");
		$(this).addClass("current");
		location.href = gb;
	}
</script>