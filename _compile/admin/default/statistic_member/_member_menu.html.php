<?php /* Template_ 2.2.6 2022/05/17 12:37:10 /www/music_brother_firstmall_kr/admin/skin/default/statistic_member/_member_menu.html 000000786 */ ?>
<div class="slc-head pdt5">
<ul>
	<li><span class="mitem"><a href="member_basic">기본</a></span></li>
	<li><span class="mitem"><a href="member_referer">유입경로</a></span></li>
	<li><span class="mitem"><a href="member_platform">환경</a></span></li>
	<li><span class="mitem"><a href="member_rute">가입수단</a></span></li>
	<li><span class="mitem"><a href="member_etc">성별/연령/지역</a></span></li>

</ul>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("div.slc-head a[href='<?php echo $TPL_VAR["selected_member_menu"]?>']").parent().parent().addClass("selected");
});

</script>