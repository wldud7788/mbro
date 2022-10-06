<?php /* Template_ 2.2.6 2020/12/08 10:20:38 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/board/product_bbs/gallery02/view.html 000004772 */  $this->include_("sslAction");
$TPL_filelistimages_1=empty($TPL_VAR["filelistimages"])||!is_array($TPL_VAR["filelistimages"])?0:count($TPL_VAR["filelistimages"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 사용자 생성 "갤러리형" 게시판 - View @@
- 파일위치 : [스킨폴더]/board/게시판아이디/gallery01/view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<style type="text/css">
#subpageLNB, #subAllButton, #layout_header, .title_container, #layout_footer{ display:none; }
.subpage_wrap .subpage_container { padding:0; }
html, body { height:auto; }
#layout_body { padding-left:20px; padding-right:20px; }
@media only screen and (max-width:1023px) {
	.subpage_wrap .subpage_container { padding-left:10px; }
	#layout_body { box-sizing:border-box; padding-left:10px; padding-right:10px; width:1px; min-width:100%; *width:100%; }
</style>

<form name="form1" id="form1" method="post" action="<?php echo sslAction('../board_process')?>"  target="actionFrame">
	<input type="hidden" name="mode" id="mode" value="<?php echo $TPL_VAR["mode"]?>" />
	<input type="hidden" name="board_id" id="board_id" value="<?php echo $_GET["id"]?>" />
	<input type="hidden" name="reply" id="reply" value="<?php echo $_GET["reply"]?>" />
<?php if($TPL_VAR["seq"]){?>
	<input type="hidden" name="seq" id="board_seq" value="<?php echo $TPL_VAR["seq"]?>" />
<?php }?>
	<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>" >
	<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>" >
	<input type="hidden" name="goods_seq" value="<?php echo $_GET["goods_seq"]?>" >
	
<?php if($TPL_VAR["filelistimages"]){?>
	<ul class="gallery_detail_filelist slider_before_loading">
<?php if($TPL_filelistimages_1){foreach($TPL_VAR["filelistimages"] as $TPL_V1){?>
		<li>
			<img class="gallery_detail_img" src="<?php echo $TPL_V1["realfileurl"]?>" designImgSrcOri='ey5yZWFsZmlsZXVybH0=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9wcm9kdWN0X2Jicy9nYWxsZXJ5MDIvdmlldy5odG1s' designImgSrc='ey5yZWFsZmlsZXVybH0=' designElement='image' >
		</li>
<?php }}?>
	</ul>
<?php }?>
	<ul class="gallery_detail_text">
		<li class="subject"><?php echo $TPL_VAR["subject"]?></li>
		<li class="contents"><?php echo strip_tags($TPL_VAR["contents"])?></li>
	</ul>
</form>
<script type="text/javascript">
$(function() {
	$('.gallery_detail_filelist').slick({
		dots: true, // 도트 페이징 사용( true 혹은 false )
		autoplay: true, // 슬라이드 자동( true 혹은 false )
		autoplaySpeed: 8000, // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 8000 == 8초 )
		speed: 800, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 800 == 0.8초 )
		pauseOnHover: false // Hover시 autoplay 정지안함( 정지: true, 정지안함: false )
	});
});
</script>
<!-- //게시글 비회원 비밀번호 확인 -->

<script type="text/javascript">
function getboardLogin(){
<?php if(defined('__ISUSER__')===true){?>
		//해당 서비스를 이용하시려면 관리자에게 문의하여 주시길 바랍니다.
		openDialogAlert(getAlert('et366'),'450','140');
<?php }else{?>
		//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
		openDialogConfirm(getAlert('et367'),'400','155',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
}

function getcmtMbLogin(){
<?php if(defined('__ISUSER__')===true){?>
		//글작성자만 이용가능합니다.
		openDialogAlert(getAlert('et368'),'400','140');
<?php }else{?>
		//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
		openDialogConfirm(getAlert('et367'),'400','155',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
}

$(window).load(function () {
	//이미지 가로가 큰경우
	$(".content img").each(function() {
<?php if($TPL_VAR["layout_config"]["layoutScrollLeft"]!='hidden'||$TPL_VAR["layout_config"]["layoutScrollRight"]!='hidden'){?>
			var default_width = '<?php echo $TPL_VAR["layout_config"]["body_width"]- 100?>';//(본문레이아웃사이즈-100) 또는 직접값변경
<?php }else{?>
			var default_width = '<?php echo $TPL_VAR["layout_config"]["body_width"]- 50?>';//(본문레이아웃사이즈-50) 또는 직접값변경
<?php }?>
		if( $(this).width() > default_width || $(this).height() > default_width ) {
			imageResize(this,default_width);
		}
	});
});
</script>