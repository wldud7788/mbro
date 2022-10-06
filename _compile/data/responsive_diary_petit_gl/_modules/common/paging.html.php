<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/_modules/common/paging.html 000001613 */ ?>
<div class="paging_navigation">
<?php if($TPL_VAR["page"]["first"]){?>
	<a href="?page=<?php echo $TPL_VAR["page"]["first"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="first">◀ 처음</a>
<?php }?>
<?php if($TPL_VAR["page"]["prev"]){?>
	<a href="?page=<?php echo $TPL_VAR["page"]["prev"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="prev">◀ 이전</a>
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
<?php if($TPL_VAR["mobileAjaxCall"]){?>
	<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="on" mobileAjaxCall="<?php echo $TPL_VAR["mobileAjaxCall"]?>"><?php echo $TPL_V1?></a>
<?php }else{?>
	<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="on"><?php echo $TPL_V1?></a>
<?php }?>
<?php }else{?>
	<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>"><?php echo $TPL_V1?></a>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?>
	<a href="?page=<?php echo $TPL_VAR["page"]["next"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="next">다음 ▶</a>
<?php }?>
<?php if($TPL_VAR["page"]["last"]){?>
	<a href="?page=<?php echo $TPL_VAR["page"]["last"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="last">마지막 ▶</a>
<?php }?>
</div>