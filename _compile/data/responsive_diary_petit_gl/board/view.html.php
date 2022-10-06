<?php /* Template_ 2.2.6 2020/10/15 17:39:14 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/board/view.html 000006033 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 게시판 View 레이아웃 템플릿 @@
- 파일위치 : [스킨폴더]/board/view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="boardlayout">
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
		var gl_isuser = false;
<?php if(defined('__ISUSER__')){?>
		gl_isuser = '<?php echo defined('__ISUSER__')?>';
<?php }?>
		var return_url = '<?php echo urlencode($_SERVER["REQUEST_URI"])?>';
		var comment = '<?php echo $TPL_VAR["comment"]?>';
		var commentlay = '<?php echo $TPL_VAR["commentlay"]?>';
		var isperm_write = '<?php echo $TPL_VAR["managerview"]["isperm_write"]?>';
		//]]>
	</script>
	<script type="text/javascript" src="/app/javascript/js/board.js?v=7"  charset="utf-8"></script>
<?php if($TPL_VAR["commentskinjsuse"]){?>
	<script type="text/javascript" src="/app/javascript/js/board_mobile.js?v=1"  charset="utf-8"></script>
	<script type="text/javascript" src="/app/javascript/js/board_comment_mobile.js?v=2"  charset="utf-8"></script>
<?php }?>
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
			<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC92aWV3Lmh0bWw=" >MENU</span></a>

			<!-- 타이틀 ( 관리자에서 설정한 "게시판명"이 노출됩니다. ) -->
			<div class="title_container">
				<h2><?php echo $TPL_VAR["manager"]["name"]?></h2>
			</div>
<?php }?>

			<div id="bbsview">
				<!-- ------- 각각의 게시판 view.html( 게시물 상세 ) 로드 ------- -->
<?php $this->print_("skin",$TPL_SCP,1);?>

				<!-- ------- //각각의 게시판 view.html( 게시물 상세 ) 로드 ------- -->
			</div>

			<!-- <?php if(!$_GET["iframe"]){?><div id="bbslist" class="Pt20">{//#listskin}</div><?php }?> -->

		</div>
		<!-- +++++ //cscenter contents ++++ -->
	</div>
	<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/cscenter_ui.js"></script><!-- 고객센터 ui 공통 -->
</div>
<!-- //본문내용 끝 -->

<?php if(!$_GET["iframe"]){?>
<div id="CmtBoardPwCkNew" class="hide BoardPwCk">
	<div class="msg">
		<h3> 비밀번호 확인</h3>
		<div>댓글/답글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
	</div>
	<form name="BoardPwcheckFormNew" id="CmtBoardPwcheckFormNew" method="post">
	<input type="hidden" name="modetype" id="cmtmodetype_new" value="" />
	<input type="hidden" name="seq" id="cmt_pwck_seq_new" value="" />
	<input type="hidden" name="cmtseq" id="cmt_pwck_cmtseq_new" value="" />
	<input type="hidden" name="cmtparentseq" id="cmt_pwck_cmtreplyseq_new" value="" />
	<input type="hidden" name="cmtreplyidx" id="cmt_pwck_cmtreplyidx_new" value="" />
	<div class="ibox">
		<input type="password" name="pw" id="cmt_pwck_pw_new" class="input" />
		<input type="button" id="CmtBoardPwcheckBtnNew" value=" 확인 " class="btnblue" />
		<input type="button" value=" 취소 " class="btngray" onclick="$('#CmtBoardPwCkNew').dialog('close');" />
	</div>
	</form>
</div>
<?php }?>
<?php if($_GET["iframe"]){?>
<script type="text/javascript">
$(document).ready(function(){
	$(document).resize(function(){
		$('#'+board_id+'_frame',parent.document).height($('#boardlayout').height());
	}).resize();
	$(document).on('click', function() {
		iframeset();
	});
});
function iframeset(){
	$('#'+board_id+'_frame',parent.document).height($('#boardlayout').height());
}
</script>
<?php }?>
<script type="text/javascript">
	function getLogin(){
<?php if(defined('__ISUSER__')===true){?>
			//해당 서비스를 이용하시려면 관리자에게 문의하여 주시길 바랍니다.
			openDialogAlert(getAlert('et363'),'450','140');
<?php }else{?>
			//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
			openDialogConfirm(getAlert('et362'),'400','155',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
	}
	function getMbLogin(){
<?php if(defined('__ISUSER__')===true){?>
			//글작성자만 이용가능합니다.
			openDialogAlert(getAlert('et364'),'400','140');
<?php }else{?>
			//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
			openDialogConfirm(getAlert('et362'),'400','155',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
	}
</script> 
<!-- ++++++++++++++++++++++++++++++++++ 게시판 View 레이아웃 템플릿 :: END ++++++++++++++++++++++++++++++++++ -->