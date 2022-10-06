<?php /* Template_ 2.2.6 2021/12/15 17:48:34 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/board/write.html 000003604 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 게시판 Write 레이아웃 템플릿 @@
- 파일위치 : [스킨폴더]/board/write.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="boardlayout" >
	<script type="text/javascript">
	//<![CDATA[
	var board_id = '<?php echo $_GET["id"]?>';
	var board_seq = '<?php echo $_GET["seq"]?>';
	var boardlistsurl = '<?php echo $TPL_VAR["boardurl"]->lists?>';
	var boardwriteurl = '<?php echo $TPL_VAR["boardurl"]->write?>';
	var boardviewurl = '<?php echo $TPL_VAR["boardurl"]->view?>';
	var boardmodifyurl = '<?php echo $TPL_VAR["boardurl"]->modify?>';
	var boardreplyurl = '<?php echo $TPL_VAR["boardurl"]->reply?>';
	var boardrpermurl = '<?php echo $TPL_VAR["boardurl"]->perm?>';
	var file_use = '<?php echo $TPL_VAR["manager"]["file_use"]?>';
	var video_use = '<?php echo $TPL_VAR["manager"]["video_use"]?>';
	var return_url = '<?php echo urlencode($_SERVER["REQUEST_URI"])?>';
	//]]>
	</script>
	<script type="text/javascript" src="/app/javascript/js/board.js?v=7"  charset="utf-8"></script>
	<script type="text/javascript" src="/app/javascript/js/board_mobile.js?v=1"  charset="utf-8"></script>
	<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="utf-8"></script>
	<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"  charset="utf-8"></script>


	<div class="subpage_wrap">
		<!-- +++++ cscenter LNB ++++ -->
<?php if(!$_GET["iframe"]){?>
		<div  id="subpageLNB" class="subpage_lnb">
			<!-- ------- 고객센터 LNB 인클루드. 파일위치 : [스킨폴더]/_modules/common/board_lnb.html ------- -->
<?php $this->print_("board_lnb",$TPL_SCP,1);?>

			<!-- ------- //고객센터 LNB 인클루드 ------- -->
		</div>
<?php }?>

		<!-- +++++ cscenter contents ++++ -->
		<div class="subpage_container">
<?php if(!$_GET["iframe"]){?>
			<!-- 전체 메뉴 -->
			<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvd3JpdGUuaHRtbA==" >MENU</span></a>

			<!-- 타이틀 ( 관리자에서 설정한 "게시판명"이 노출됩니다. ) -->
			<div class="title_container">
				<h2><?php echo $TPL_VAR["manager"]["name"]?></h2>
			</div>
<?php }?>

			<div id="bbsview">
				<!-- ------- 각각의 게시판 write.html( 게시물 쓰기 ) 로드 ------- -->
<?php $this->print_("skin",$TPL_SCP,1);?>

				<!-- ------- //각각의 게시판 write.html( 게시물 쓰기 ) 로드 ------- -->
			</div>

		</div>
		<!-- +++++ //cscenter contents ++++ -->
	</div>
	<script type="text/javascript" src="/data/skin/responsive_ver1_default_gl/common/cscenter_ui.js"></script><!-- 고객센터 ui 공통 -->
</div>

<script type="text/javascript">
function getLogin(){
<?php if(defined('__ISUSER__')===true){?>
		//글작성자만 이용가능합니다.
		openDialogAlert(getAlert('et364'),'400','140');
<?php }else{?>
		//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
		openDialogConfirm(getAlert('et362'),'400','155',function(){top.location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
}
</script>
<!-- ++++++++++++++++++++++++++++++++++ 게시판 Write 레이아웃 템플릿 :: END ++++++++++++++++++++++++++++++++++ -->