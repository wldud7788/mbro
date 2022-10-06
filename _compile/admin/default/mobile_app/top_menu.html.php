<?php /* Template_ 2.2.6 2022/05/17 12:36:33 /www/music_brother_firstmall_kr/admin/skin/default/mobile_app/top_menu.html 000000735 */ ?>
<!-- 상단 단계 링크 : 시작 -->
<div id="rn_join">
	<ul class="tab_01 v2 ">	
		<li><a href="javascript:void(0);" onclick="formMoveSub('push_manual',2); " class="<?php if($TPL_VAR["tab2"]){?>current<?php }?> t2">수동 발송</a></li>
		<li><a href="javascript:void(0);" onclick="formMoveSub('push_history',3);" class="<?php if($TPL_VAR["tab3"]){?>current<?php }?> t3">발송 내역</a></li>		
	</ul>	
</div>
<!-- 상단 단계 링크 : 끝 -->

<script type="text/javascript">
	function formMoveSub(gb, no){
		$(".t"+no).addClass("current");
		location.href = gb;
	}
</script>