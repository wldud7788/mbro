<?php /* Template_ 2.2.6 2022/05/17 12:36:46 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/tab_menu.html 000003630 */ ?>
<style type="text/css">
.tab_v2 .ctab, .tab_v2 .ctab-on { width: 170px; line-height:40px; font-size:12px; font-family:'Malgun Gothic'; color:#555; border-color:#bbb; }
.tab_v2 .ctab-on { color:#000; border-bottom-color:#fff; }
.tab_v2 {}
</style>

<?php if($_GET["cmd"]=='brand_main'){?>
<!-- 상단 단계 링크 : 시작 -->
<div class="left" id="rn_join">
	<br style="line-height:40px;" />

	<div style="position:absolute;">
		<table cellpadding="0" cellspacing="0" class="tab_v2">
			<tr>
				<td class="ctab<?php echo $TPL_VAR["tab1"]?> t1 wx300"><span class="hand" onclick="formMoveSub('main',1);">브랜드 메인</span></td>
				<td class="ctab<?php echo $TPL_VAR["tab2"]?> t2 wx300"><span class="hand" onclick="formMoveSub('image',2);">베스트 브랜드, 베스트 아이콘, 브랜드 이미지</span></td>
			</tr>
		</table>
	</div>
	<table height="42" width="100%" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #bbb;">
		<tr>
			<td align="center"></td>
		</tr>
	</table>
</div>
<!-- 상단 단계 링크 : 끝 -->

<script type="text/javascript">
function formMoveSub(gb, no){
	$(".ctab-on").addClass("ctab");
	$(".ctab-on").removeClass("ctab-on");
	$(".t"+no).addClass("ctab-on");
	if(gb == 'main')	location.href = './subpage_layout?cmd=<?php echo $_GET["cmd"]?>&tab='+gb;
	else				location.href = './page_layout?cmd=<?php echo $_GET["cmd"]?>&tab='+gb;
}
</script>
<?php }else{?>
<!-- 상단 단계 링크 : 시작 -->
<div class="left" id="rn_join">
	<br style="line-height:40px;" />

	<div style="position:absolute;">
		<table cellpadding="0" cellspacing="0" class="tab_v2">
			<tr>
				<td class="ctab<?php echo $TPL_VAR["tab1"]?> t1 "><span class="hand" onclick="formMoveSub('access_limit',1);">페이지 접속제한</span></td>
				<td class="ctab<?php echo $TPL_VAR["tab2"]?> t2 "><span class="hand" onclick="formMoveSub('banner',2);">페이지 배너</span></td>
				<td class="ctab<?php echo $TPL_VAR["tab3"]?> t3 "><span class="hand" onclick="formMoveSub('recommend',3);">페이지 추천상품</span></td>
				<td class="ctab<?php echo $TPL_VAR["tab4"]?> t4 "><span class="hand" onclick="formMoveSub('page_goods',4);">페이지 검색 필터</span></td>
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?><td class="ctab<?php echo $TPL_VAR["tab5"]?> t5 "><span class="hand" onclick="formMoveSub('goods_info',5);">페이지 검색 상품 정보</span></td><?php }?>
				<td class="ctab<?php echo $TPL_VAR["tab6"]?> t6 "><span class="hand" onclick="formMoveSub('navigation',6);">네비게이션 노출/배너</span></td>
				<td class="ctab<?php echo $TPL_VAR["tab7"]?> t7 "><span class="hand" onclick="formMoveSub('all_navigation',7);">전체 네비게이션 <?php if($_GET['cmd']=='brand'){?>/ 메인<?php }else{?>노출/배너<?php }?></span></td>
			</tr>
		</table>
	</div>
	<table height="42" width="100%" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #bbb;">
		<tr>
			<td align="center"></td>
		</tr>
	</table>
</div>
<!-- 상단 단계 링크 : 끝 -->

<script type="text/javascript">
function formMoveSub(gb, no){
	$(".ctab-on").addClass("ctab");
	$(".ctab-on").removeClass("ctab-on");
	$(".t"+no).addClass("ctab-on");

	if(gb == 'goods_info')	location.href = './subpage_layout?cmd=<?php echo $_GET["cmd"]?>&tab='+gb;
	else					location.href = './page_layout?cmd=<?php echo $_GET["cmd"]?>&tab='+gb+'&tabno='+no;
}
</script>
<?php }?>