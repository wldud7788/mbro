<?php /* Template_ 2.2.6 2022/05/17 12:37:19 /www/music_brother_firstmall_kr/admin/skin/default/statistic_visitor/_visitor_menu.html 000000627 */ ?>
<div class="slc-head pdt5">
<ul>
	<li><span class="mitem"><a href="visitor_basic">기본</a></span></li>
	<li><span class="mitem"><a href="visitor_referer">유입경로</a></span></li>
	<li><span class="mitem"><a href="visitor_platform">환경</a></span></li>
</ul>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("div.slc-head a[href='<?php echo $TPL_VAR["selected_visitor_menu"]?>']").parent().parent().addClass("selected");
});
</script>