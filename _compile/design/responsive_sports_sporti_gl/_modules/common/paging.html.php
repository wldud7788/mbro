<?php /* Template_ 2.2.6 2021/12/15 16:50:22 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/_modules/common/paging.html 000002079 */ ?>
<div class="paging_navigation">
<?php if($TPL_VAR["page"]["first"]){?>
	<a href="?page=<?php echo $TPL_VAR["page"]["first"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="first" hrefOri='P3BhZ2U9e3BhZ2UuZmlyc3R9JmFtcDt7cGFnZS5xdWVyeXN0cmluZ30=' >◀ 처음</a>
<?php }?>
<?php if($TPL_VAR["page"]["prev"]){?>
	<a href="?page=<?php echo $TPL_VAR["page"]["prev"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="prev" hrefOri='P3BhZ2U9e3BhZ2UucHJldn0mYW1wO3twYWdlLnF1ZXJ5c3RyaW5nfQ==' >◀ 이전</a>
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
<?php if($TPL_VAR["mobileAjaxCall"]){?>
	<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="on" mobileAjaxCall="<?php echo $TPL_VAR["mobileAjaxCall"]?>" hrefOri='P3BhZ2U9ey52YWx1ZV99JmFtcDt7cGFnZS5xdWVyeXN0cmluZ30=' ><?php echo $TPL_V1?></a>
<?php }else{?>
	<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="on" hrefOri='P3BhZ2U9ey52YWx1ZV99JmFtcDt7cGFnZS5xdWVyeXN0cmluZ30=' ><?php echo $TPL_V1?></a>
<?php }?>
<?php }else{?>
	<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" hrefOri='P3BhZ2U9ey52YWx1ZV99JmFtcDt7cGFnZS5xdWVyeXN0cmluZ30=' ><?php echo $TPL_V1?></a>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?>
	<a href="?page=<?php echo $TPL_VAR["page"]["next"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="next" hrefOri='P3BhZ2U9e3BhZ2UubmV4dH0mYW1wO3twYWdlLnF1ZXJ5c3RyaW5nfQ==' >다음 ▶</a>
<?php }?>
<?php if($TPL_VAR["page"]["last"]){?>
	<a href="?page=<?php echo $TPL_VAR["page"]["last"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="last" hrefOri='P3BhZ2U9e3BhZ2UubGFzdH0mYW1wO3twYWdlLnF1ZXJ5c3RyaW5nfQ==' >마지막 ▶</a>
<?php }?>
</div>