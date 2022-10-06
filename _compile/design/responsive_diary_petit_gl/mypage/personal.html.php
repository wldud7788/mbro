<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/personal.html 000002984 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 개인결제 @@
- 파일위치 : [스킨폴더]/mypage/personal.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvcGVyc29uYWwuaHRtbA==" >개인결제</span></h2>
		</div>


<?php if($TPL_VAR["page"]["totalcount"]== 0){?>
		<div class="no_data_area2">
			개인결제 내역이 없습니다.
		</div>
<?php }else{?>

		<?php echo $TPL_VAR["goodsDisplayHTML"]?>


		<div class="paging_navigation">
<?php if($TPL_VAR["page"]["first"]){?><a href="?page=<?php echo $TPL_VAR["page"]["first"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="first" hrefOri='P3BhZ2U9e3BhZ2UuZmlyc3R9JmFtcDt7cGFnZS5xdWVyeXN0cmluZ30=' >◀ 처음</a><?php }?>
<?php if($TPL_VAR["page"]["prev"]){?><a href="?page=<?php echo $TPL_VAR["page"]["prev"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="prev" hrefOri='P3BhZ2U9e3BhZ2UucHJldn0mYW1wO3twYWdlLnF1ZXJ5c3RyaW5nfQ==' >◀ 이전</a><?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
					<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="on" hrefOri='P3BhZ2U9ey52YWx1ZV99JmFtcDt7cGFnZS5xdWVyeXN0cmluZ30=' ><?php echo $TPL_V1?></a>
<?php }else{?>
					<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" hrefOri='P3BhZ2U9ey52YWx1ZV99JmFtcDt7cGFnZS5xdWVyeXN0cmluZ30=' ><?php echo $TPL_V1?></a>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?><a href="?page=<?php echo $TPL_VAR["page"]["next"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="next" hrefOri='P3BhZ2U9e3BhZ2UubmV4dH0mYW1wO3twYWdlLnF1ZXJ5c3RyaW5nfQ==' >다음 ▶</a><?php }?>
<?php if($TPL_VAR["page"]["last"]){?><a href="?page=<?php echo $TPL_VAR["page"]["last"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="last" hrefOri='P3BhZ2U9e3BhZ2UubGFzdH0mYW1wO3twYWdlLnF1ZXJ5c3RyaW5nfQ==' >마지막 ▶</a><?php }?>
		</div>
<?php }?>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->