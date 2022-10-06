<?php /* Template_ 2.2.6 2022/05/17 12:36:28 /www/music_brother_firstmall_kr/admin/skin/default/member/kakaotalk_top_menu.html 000001164 */ ?>
<!-- 상단 단계 링크 : 시작 -->
<ul class="tab_01 v2 menuTab">	
	<li><a onclick="formMoveSub('kakaotalk_msg',2);" value="kakaotalk_msg">알림톡 메시지 관리</a></li>
	<li><a onclick="formMoveSub('kakaotalk_log',4);" value="kakaotalk_log">알림톡 발송 내역</a></li>
	<li><a onclick="formMoveSub('kakaotalk_charge',3);" value="kakaotalk_charge">알림톡 충전</a></li>	
	<li><a onclick="formMoveSub('kakaotalk',1);" value="kakaotalk">알림톡 설정</a></li>
</ul>		
<!-- 상단 단계 링크 : 끝 -->

<script type="text/javascript">	
	$(document).ready(function() {		
		//페이지 로딩시 해당 메뉴탭 활성
		var arr = $(location). attr("href").split("/");
		var value = arr[arr.length-1].split("?")[0];		
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