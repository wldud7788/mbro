<?php /* Template_ 2.2.6 2022/09/06 16:41:30 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_2/goods/search_list_template.html 000002133 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "상품리스트 페이지" 상품 영역 @@
- 파일위치 : [스킨폴더]/goods/search_list_template.html
- 관련 페이지들 : 카테고리, 지역, 브랜드, 검색결과, 신상품, 베스트, 이벤트, 사은품 이벤트, 미니샵
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_VAR["totcount"]> 0){?>
<ul>
<?php $this->print_("goods_info_template",$TPL_SCP,1);?>

</ul>
<?php }else{?>
<div class="no_data_area2 Mt20">
	<!--errorMessage-->
	새로운 상품으로 준비중 입니다.
</div>
<?php }?>

<?php if($TPL_VAR["page"]["totalpage"]> 1){?>
<div class="paging_navigation">
<?php if($TPL_VAR["page"]["first"]){?><a href="?page=<?php echo $TPL_VAR["page"]["first"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="first">◀ 처음</a><?php }?>
<?php if($TPL_VAR["page"]["prev"]){?><a href="?page=<?php echo $TPL_VAR["page"]["prev"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="prev">◀ 이전</a><?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
			<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="on"><?php echo $TPL_V1?></a>
<?php }else{?>
			<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>"><?php echo $TPL_V1?></a>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?><a href="?page=<?php echo $TPL_VAR["page"]["next"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="next">다음 ▶</a><?php }?>
<?php if($TPL_VAR["page"]["last"]){?><a href="?page=<?php echo $TPL_VAR["page"]["last"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="last">마지막 ▶</a><?php }?>
</div>
<?php }?>

<script>$("a.total span.num").html('<?php echo number_format($TPL_VAR["totcount"])?>');</script>