<?php /* Template_ 2.2.6 2022/05/30 16:19:14 /www/music_brother_firstmall_kr/admin/skin/default/design/skin_add.html 000001364 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<style type="text/css">
	.goodsDisplayWrap .goodsDisplayImage {width:212px !important; height:242px !important;}
	.goodsDisplayWrap .goodsDisplayImage img {width:240px !important;}
	.skinListTabContents .skin_version { padding-top:10px; text-align:center; font:bold 14px/1.2 tahoma; }
	.skinListTabContents .skin_version:before { display:inline-block; content:'스킨버전 : '; font-size:12px; font-weight:normal; color:#767676; }
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>스킨 추가</h2>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="sub-layout-container body-height-resizing">
	<!-- 서브메뉴 바디 : 시작-->
	<div class='slc-body-wrap'>
		<div class="slc-body">
			<div class="skin_setting">
				<?php echo $TPL_VAR["search_html"]?>

				<!-- 스킨다운로드 영역  영역 : 끝 -->
			</div>
		</div>
	</div>
	<!-- 서브메뉴 바디 : 끝 -->
</div>
<!-- 서브 레이아웃 영역 : 끝 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>