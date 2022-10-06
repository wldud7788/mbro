<?php /* Template_ 2.2.6 2021/01/08 12:02:06 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/_modules/layout.html 000004416 */ ?>
<!-- ================= #HTML_HEADER :: START. 파일위치 : _modules/common/html_header.html ================= -->
<?php $this->print_("HTML_HEADER",$TPL_SCP,1);?>

<!-- ================= #HTML_HEADER :: END. 파일위치 : _modules/common/html_header.html ================= -->

<!--[ 디자인모드 호출 스크립트]-->
<?php if($TPL_VAR["designMode"]){?>
<script type="text/javascript">
/* 디자인매니저 세팅 */
$(function(){
	if(parent.document==document){
		DM_init('<?php echo $TPL_VAR["template_path"]?>');
	}
});
</script>
<?php }?>

<!--[ 모바일쇼핑몰 디자인모드시 화면 구성 ]-->
<?php if(($TPL_VAR["mobileMode"]||$TPL_VAR["storemobileMode"])&&$TPL_VAR["designMode"]){?>

<?php }?>



<div id="wrap">
	<!-- ================= 어사이드 :: START. 파일위치 : _modules/common/layout_side.html (비동기 로드) ================= -->
	<div id="layout_side" class="layout_side"></div>
	<!-- ================= 어사이드 :: END. 파일위치 : _modules/common/layout_side.html (비동기 로드) ================= -->
	<a href="javascript:;" id="side_close" class="side_close" hrefOri='amF2YXNjcmlwdDo7' >어사이드 닫기</a>

	<div id="layout_wrap" class="layout_wrap">
<?php if(!$_GET["popup"]&&!$_GET["iframe"]){?>
<?php if($TPL_VAR["layout_config"]["layoutHeader"]!='hidden'){?>
		<!-- ================= #LAYOUT_HEADER :: START. 파일위치 : layout_header/standard.html (default) ================= -->
<?php $this->print_("LAYOUT_HEADER",$TPL_SCP,1);?>

		<!-- ================= #LAYOUT_HEADER :: END. 파일위치 : layout_header/standard.html (default) ================= -->
<?php }?>
<?php }?>

		<div id="layout_body" class="layout_body">
<?php if(!($TPL_VAR["layout_config"]["layoutMainTopBar"]!='hidden'&&strpos(uri_string(),"main")!==false&&$TPL_VAR["layout_config"]["layoutMainTopBar"]!='')){?>
		<!-- ================= 파트 페이지들 :: START. ================= -->
<?php $this->print_("LAYOUT_BODY",$TPL_SCP,1);?>

		<!-- ================= 파트 페이지들 :: END. ================= -->
<?php }?>
		</div>

<?php if(!$_GET["popup"]&&!$_GET["iframe"]){?>
<?php if($TPL_VAR["layout_config"]["layoutFooter"]!='hidden'){?>
		<!-- ================= #LAYOUT_FOOTER :: START. 파일위치 : layout_footer/standard.html (default) ================= -->
<?php $this->print_("LAYOUT_FOOTER",$TPL_SCP,1);?>

		<!-- ================= #LAYOUT_FOOTER :: END. 파일위치 : layout_footer/standard.html (default) ================= -->
<?php }?>
<?php }?>

<?php if(!$_GET["iframe"]){?>
		<iframe name="actionFrame" id="actionFrame" src="/main/blank" frameborder="0" width="100%" <?php if($_GET["debug"]== 1){?>height="600"<?php }else{?>height="0"<?php }?>></iframe>
		<div id="openDialogLayer" style="display: none">
			<div align="center" id="openDialogLayerMsg"></div>
		</div>
<?php }?>
		<div id="ajaxLoadingLayer" style="display: none"></div>
	</div>	
</div>
<div id="mobileZipcodeLayer" style="display: none"></div>
<!-- 결제창을 레이어 형태로 구현-->
<div id="layer_pay" class="hide"></div>
<div id="payprocessing" class="pay_layer hide">
	<div style="margin:auto;"><img src="/data/skin/responsive_diary_petit_gl_1/images/design/img_paying.gif" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9pbWdfcGF5aW5nLmdpZg==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL19tb2R1bGVzL2xheW91dC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2Rlc2lnbi9pbWdfcGF5aW5nLmdpZg==' designElement='image' /></div>
	<div style="margin:auto;padding-top:20px;"><img src="/data/skin/responsive_diary_petit_gl_1/images/design/progress_bar.gif" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9wcm9ncmVzc19iYXIuZ2lm' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL19tb2R1bGVzL2xheW91dC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2Rlc2lnbi9wcm9ncmVzc19iYXIuZ2lm' designElement='image' /></div>
</div>
<div id="layout_side_background" class="layout_side_background"></div>

<!-- ================= #HTML_FOOTER :: START. 파일위치 : _modules/common/html_footer.html ================= -->
<?php $this->print_("HTML_FOOTER",$TPL_SCP,1);?>

<!-- ================= #HTML_FOOTER :: END. 파일위치 : _modules/common/html_footer.html ================= -->