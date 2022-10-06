<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/mypage/myqna_view.html 000014612 */  $this->include_("sslAction","snslinkurl");
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 나의 1:1 문의 View @@
- 파일위치 : [스킨폴더]/mypage/myqna_view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)">MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL215cGFnZS9teXFuYV92aWV3Lmh0bWw=" >나의 1:1 문의</span></h2>
		</div>

		<form name="form1" id="form1" method="post" action="<?php echo sslAction('../board_process')?>"  target="actionFrame">
			<input type="hidden" name="mode" id="mode" value="<?php echo $TPL_VAR["mode"]?>" />
			<input type="hidden" name="board_id" id="board_id" value="<?php echo $TPL_VAR["manager"]["id"]?>" />
			<input type="hidden" name="reply" id="reply" value="<?php echo $_GET["reply"]?>" />
<?php if($TPL_VAR["seq"]){?>
			<input type="hidden" name="seq" id="board_seq" value="<?php echo $TPL_VAR["seq"]?>" />
<?php }?>
			<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>" >
			<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>" >
			<input type="hidden" name="goods_seq" value="<?php echo $_GET["goods_seq"]?>" >

			<div class="board_detail_title">
				<?php echo $TPL_VAR["subject"]?> <?php echo $TPL_VAR["iconnew"]?> <?php echo $TPL_VAR["iconhot"]?> <?php echo $TPL_VAR["iconhidden"]?>

			</div>
			<table class="table_row_a Thc" data-responsive="yes" width="100%" cellpadding="0" cellspacing="0">
				<colgroup><col class="size_b"><col><col class="size_b"><col></colgroup>
				<tbody>
					<tr>
						<th><p>분류</p></th>
						<td><?php if($TPL_VAR["datacategory"]){?>[<?php echo $TPL_VAR["datacategory"]?>]<?php }?> <?php echo $TPL_VAR["iconmobile"]?></td>
						<th><p>작성자</p></th>
						<td><?php echo $TPL_VAR["name"]?></td>
					</tr>
					<tr>
						<th><p>등록일</p></th>
						<td><?php echo $TPL_VAR["r_date"]?></td>
						<th><p>조회수</p></th>
						<td><?php echo number_format($TPL_VAR["hit"])?></td>
					</tr>
<?php if($TPL_VAR["filelist"]){?>
					<tr>
						<th><p>첨부파일</p></th>
						<td colspan="3">
							<ul>
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
								<li>
									<span class="realfilelist hand highlight-link" realfiledir="<?php echo $TPL_V1["realfiledir"]?>" realfilename="<?php echo $TPL_V1["orignfile"]?>"  realfilename="<?php echo $TPL_V1["orignfile"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" filedown="../board_process?mode=board_file_down&board_id=<?php echo $TPL_VAR["boardid"]?>&realfiledir=<?php echo $TPL_V1["realfiledir"]?>&realfilename=<?php echo $TPL_V1["orignfile"]?>"><?php echo $TPL_V1["orignfile"]?> (<span class="size"><?php echo $TPL_V1["realsizefile"]?></span>) <button type="button"  class="bbs_btn">down</button></span>
<?php if($TPL_V1["is_image"]){?>
										<span class="hand" imgsrc="<?php echo $TPL_V1["realfile"]?>" onclick="board_file_review('<?php echo $TPL_V1["realfile"]?>','<?php echo $TPL_V1["imagesize"][ 0]?>','<?php echo $TPL_V1["imagesize"][ 1]?>');" ><img src="/data/skin/responsive_sports_sporti_gl/images/icon/icon_zoom.gif" hspace="1" title="미리보기"/></span>
<?php }?>
								</li>
<?php }}?>
							</ul>
						</td>
					</tr>
<?php }?>
				</tbody>
			</table>
			
			<div class="board_detail_contents">
				<?php echo $TPL_VAR["contents"]?>

			</div>
			
			<div class="board_sns_link">
				<?php echo snslinkurl('board',$TPL_VAR["subject"])?>

			</div>

<?php if($TPL_VAR["re_contents"]){?>
			<div class="board_manager_reply">
				<div class="writer">
					<span class="icon1">답변</span> <strong><?php echo $TPL_VAR["adminname"]?></strong>
<?php if($TPL_VAR["managerview"]["admin_regist_view"]=='Y'){?>
					<span class="gray_06">(<?php echo $TPL_VAR["re_date"]?>)</span>
<?php }?>
				</div>
				<div class="subject">
					<?php echo $TPL_VAR["re_subject"]?>

				</div>
				<div class="contents">
					<?php echo $TPL_VAR["re_contents"]?>

				</div>
			</div>
<?php }?>
		</form>

<?php if($TPL_VAR["managerview"]["auth_recommend_use"]=='Y'){?>
		<!-- 게시글평가 -->
		<div class="board_score">
			<!-- 게시글 평가 인클루드. 파일위치 : [스킨폴더]/board/_score.html -->
<?php $this->print_("scoreskin",$TPL_SCP,1);?>

			<!-- //게시글 평가 인클루드 -->
		</div>
<?php }?>

<?php if($TPL_VAR["commentlay"]=='Y'||$TPL_VAR["comment"]> 0){?>
		<a name="cmtlist"></a>
		<div class="board_comment_area" id="comment_container">
			<!-- 게시글 댓글/덧글 인클루드. 파일위치 : [스킨폴더]/board/_comment.html -->
<?php $this->print_("commentskin",$TPL_SCP,1);?>

			<!-- //게시글 댓글/덧글 인클루드 -->
		</div>
<?php }?>

		<!-- 이전글, 다음글 -->
		<div id="prenextlist" class="board_prev_next_list">
			<!-- 이전글/다음글 인클루드. 파일위치 : [스킨폴더]/board/_prenext.html -->
<?php $this->print_("prenextskin",$TPL_SCP,1);?>

			<!-- //이전글/다음글 인클루드 -->
		</div>

		<!-- 하단 각종 버튼 -->
		<ul class="board_detail_btns">
			<li class="left"><button type="button" name="boardviewclose" class="btn_resp size_b color5">목록</button></li>
			<li class="right">
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"&&empty($TPL_VAR["re_contents"])){?> 
				<button type="button"  name="boad_modify_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>" board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b">수정</button>
<?php }?>
<?php if((($TPL_VAR["display"]== 0||($TPL_VAR["display"]== 1&&$TPL_VAR["replyor"]== 0&&$TPL_VAR["comment"]== 0)))&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"){?> 
				<button type="button"  name="boad_delete_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>"  board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b">삭제</button>
<?php }?>
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["replylay"]=='Y'&&$TPL_VAR["managerview"]["isperm_write"]!="_no"){?> 
				<button type="button"  name="boad_reply_btn" board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b">답변</button>
<?php }?>
<?php if($TPL_VAR["managerview"]["isperm_write"]!="_no"){?>
				<button type="button"  name="boad_write_btn<?php echo $TPL_VAR["managerview"]["isperm_write"]?>" id="boad_write_btn<?php echo $TPL_VAR["managerview"]["isperm_write"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b color2"><?php echo $TPL_VAR["manager"]["name"]?>  쓰기</button>
<?php }?>
			</li>
		</ul>

		<div id="CmtBoardPwCk" class="hide BoardPwCk">
			<div class="msg">
				<h3> 비밀번호 확인</h3>
				<div>댓글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
			</div>
			<form name="BoardPwcheckForm" id="CmtBoardPwcheckForm" method="post" >
			<input type="hidden" name="seq" id="cmt_pwck_seq" value="" />
			<input type="hidden" name="cmtseq" id="cmt_pwck_cmtseq" value="" />
			<div class="ibox">
				<input type="password" name="pw" id="cmt_pwck_pw" class="input" />
				<input type="submit" id="CmtBoardPwcheckBtn" value=" 확인 " class="btnblue" />
				<input type="button" value=" 취소 " class="btngray" onclick="$('#CmtBoardPwCk').dialog('close');" />
			</div>
			</form>
		</div>
		<div id="ModDelBoardPwCk" class="hide BoardPwCk">
			<div class="msg">
				<h3> 비밀번호 확인</h3>
				<div>게시물 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
			</div>
			<form name="ModDelBoardPwcheckForm" id="ModDelBoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame " >
			<input type="hidden" name="modetype" id="modetype" value="" />
			<input type="hidden" name="seq" id="moddel_pwck_seq" value="" />
			<input type="hidden" name="returnurl" id="moddel_pwck_returnurl" value="" />
			<div class="ibox">
				<input type="password" name="pw" id="moddel_pwck_pw" class="input" />
				<input type="submit" id="BoardPwcheckBtn" value=" 확인 " class="btnblue" />
				<input type="button" value=" 취소 " class="btngray" onclick="$('#ModDelBoardPwCk').dialog('close');" />
			</div>
			</form>
		</div>
		<div id="CmtBoardPwCkNew" class="hide BoardPwCk">
			<div class="msg">
				<h3> 비밀번호 확인</h3>
				<div>댓글/답글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
			</div>
			<form name="BoardPwcheckFormNew" id="CmtBoardPwcheckFormNew" method="post" >
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
<?php if($_GET["iframe"]){?>
		<div id="BoardPwCk" class="hide BoardPwCk">
			<div class="msg">
				<h3> 비밀번호 확인</h3>
				<div>게시물 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
			</div>
			<form name="BoardPwcheckForm" id="BoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame " >
			<input type="hidden" name="seq" id="pwck_seq" value="" />
			<input type="hidden" name="returnurl" id="pwck_returnurl" value="" />
			<div class="ibox">
				<input type="password" name="pw" id="pwck_pw" class="input" />
				<input type="submit" id="BoardPwcheckBtn" value=" 확인 " class="btnblue" />
				<input type="button" value=" 취소 " class="btngray" onclick="$('#BoardPwCk').dialog('close');" />
			</div>
			</form>
		</div>
<?php }?>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_sports_sporti_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->


<script type="text/javascript">
	//<![CDATA[
	var board_id = '<?php echo $TPL_VAR["manager"]["id"]?>';
	var board_seq = '<?php echo $_GET["seq"]?>';
	var boardlistsurl = '<?php echo $TPL_VAR["boardurl"]->lists?>';
	var boardwriteurl = '<?php echo $TPL_VAR["boardurl"]->write?>';
	var boardviewurl = '<?php echo $TPL_VAR["boardurl"]->view?>';
	var boardmodifyurl = '<?php echo $TPL_VAR["boardurl"]->modify?>';
	var boardreplyurl = '<?php echo $TPL_VAR["boardurl"]->reply?>';
	var gl_isuser = false;
<?php if(defined('__ISUSER__')){?>
	gl_isuser = '<?php echo defined('__ISUSER__')?>';
<?php }?>
	var comment = '<?php echo $TPL_VAR["comment"]?>';
	var commentlay = '<?php echo $TPL_VAR["commentlay"]?>';
	var isperm_write = '<?php echo $TPL_VAR["managerview"]["isperm_write"]?>';
	//]]>
</script>
<script type="text/javascript" src="/app/javascript/js/board.js?v=20200513"></script>
<script type="text/javascript" src="/app/javascript/js/board_mobile.js?v=1"  charset="utf-8"></script>
<?php if($TPL_VAR["commentskinjsuse"]){?>
<script type="text/javascript" src="/app/javascript/js/board_comment_mobile.js" charset="utf-8"></script>
<?php }?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js" charset="utf-8"></script>

<script type="text/javascript">
function getboardLogin(){
<?php if(defined('__ISUSER__')===true){?>
		//해당 서비스를 이용하시려면 관리자에게 문의하여 주시길 바랍니다.
		openDialogAlert(getAlert('mp110'),'450','140');
<?php }else{?>
		//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
		openDialogConfirm(getAlert('mp111'),'400','155',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
}

function getcmtMbLogin(){
<?php if(defined('__ISUSER__')===true){?>
		//글작성자만 이용가능합니다.
		openDialogAlert(getAlert('mp112'),'400','140');
<?php }else{?>
		//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
		openDialogConfirm(getAlert('mp111'),'400','155',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
}

$(".content img").load(function() {
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
<?php if($_GET["iframe"]){?>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).resize(function(){
		  $('#'+board_id+'_frame',parent.document).height($('#boardlayout').height()+50);
		 }).resize();
	});
	function iframeset(){
		  $('#'+board_id+'_frame',parent.document).height($('#boardlayout').height()+50);
	}
</script>
<?php }?>