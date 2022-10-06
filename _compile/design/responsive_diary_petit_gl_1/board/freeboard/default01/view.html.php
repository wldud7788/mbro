<?php /* Template_ 2.2.6 2021/05/24 18:06:28 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/board/freeboard/default01/view.html 000010318 */  $this->include_("sslAction","snslinkurl");
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 사용자 생성 "리스트형" 게시판 - View @@
- 파일위치 : [스킨폴더]/board/게시판아이디/default01/view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

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

	<div class="board_detail_title">
<?php if($TPL_VAR["datacategory"]){?>[<?php echo $TPL_VAR["datacategory"]?>]<?php }?> <?php echo $TPL_VAR["iconmobile"]?> <?php echo $TPL_VAR["subject"]?> <?php echo $TPL_VAR["iconnew"]?> <?php echo $TPL_VAR["iconhot"]?> <?php echo $TPL_VAR["iconhidden"]?>

	</div>
	<table class="table_row_a Thc" data-responsive="yes" width="100%" cellpadding="0" cellspacing="0">
		<colgroup><col class="size_b"><col><col class="size_b"><col></colgroup>
		<tbody>
			<tr>
				<th><p>작성자</p></th>
				<td><?php echo $TPL_VAR["name"]?></td>
				<th><p>등록일</p></th>
				<td><?php echo $TPL_VAR["r_date"]?></td>
			</tr>
			<tr>
				<th><p>조회수</p></th>
				<td colspan="3"><?php echo number_format($TPL_VAR["hit"])?></td>
			</tr>
<?php if($TPL_VAR["filelist"]){?>
			<tr>
				<th><p>첨부파일</p></th>
				<td colspan="3">
					<ul>
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
						<li>
							<span class="realfilelist hand highlight-link" realfiledir="<?php echo $TPL_V1["realfiledir"]?>" realfilename="<?php echo $TPL_V1["orignfile"]?>"  realfilename="<?php echo $TPL_V1["orignfile"]?>" board_id="<?php echo $_GET["id"]?>" filedown="../board_process?mode=board_file_down&board_id=<?php echo $_GET["id"]?>&realfiledir=<?php echo $TPL_V1["realfiledir"]?>&realfilename=<?php echo $TPL_V1["orignfile"]?>"><?php echo $TPL_V1["orignfile"]?> (<span class="size"><?php echo $TPL_V1["realsizefile"]?></span>) <button type="button"  class="bbs_btn">down</button></span>
<?php if($TPL_V1["is_image"]){?>
								<span class="hand" imgsrc="<?php echo $TPL_V1["realfile"]?>" onclick="board_file_review('<?php echo $TPL_V1["realfile"]?>','<?php echo $TPL_V1["imagesize"][ 0]?>','<?php echo $TPL_V1["imagesize"][ 1]?>');" ><img src="/data/skin/responsive_diary_petit_gl_1/images/icon/icon_zoom.gif" hspace="1" title="미리보기" designImgSrcOri='Li4vLi4vLi4vaW1hZ2VzL2ljb24vaWNvbl96b29tLmdpZg==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2ZyZWVib2FyZC9kZWZhdWx0MDEvdmlldy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2ljb24vaWNvbl96b29tLmdpZg==' designElement='image' /></span>
<?php }?>
						</li>
<?php }}?>
					</ul>
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>

<?php if($TPL_VAR["file_key_w"]&&$TPL_VAR["uccdomain_fileswf"]){?>
	<div class="board_detail_contents">
		<embed src="<?php echo $TPL_VAR["uccdomain_fileswf"]?>" width="<?php echo $TPL_VAR["managerview"]["video_size0"]?>" height="<?php echo $TPL_VAR["managerview"]["video_size1"]?>" allowfullscreen="true" wmode="transparent"></embed>
	</div>
<?php }?>

	<div class="board_detail_contents">
		<?php echo $TPL_VAR["contents"]?>

	</div>

<?php if($TPL_VAR["managerview"]["auth_recommend_use"]=='Y'){?>
	<div class="c_scorelay">
		<!-- 게시글 평가 인클루드. 파일위치 : [스킨폴더]/board/_score.html -->
<?php $this->print_("scoreskin",$TPL_SCP,1);?>

		<!-- //게시글 평가 인클루드 -->
	</div>
<?php }?>
	
	<div class="board_sns_link">
		<?php echo snslinkurl('board',$TPL_VAR["subject"])?>

	</div>
</form>


<?php if($TPL_VAR["commentlay"]=='Y'||$TPL_VAR["comment"]> 0){?>
<a name="cmtlist"></a>
<div class="board_comment_area"  id="comment_container">
	<!-- 게시글 댓글/덧글 인클루드. 파일위치 : [스킨폴더]/board/_comment.html -->
<?php $this->print_("commentskin",$TPL_SCP,1);?>

	<!-- //게시글 댓글/덧글 인클루드 -->
</div>
<?php }?>

<!-- 이전/다음 글 -->
<!--
<div id="prenextlist" class="board_prev_next_list">
	{//#prenextskin}
</div>
-->

<!-- 목록 불러오기 -->
<?php if(!$_GET["iframe"]){?><div id="bbslist" class="Pt20"><?php $this->print_("listskin",$TPL_SCP,1);?></div><?php }?>

<!-- 하단 각종 버튼 -->
<ul class="board_detail_btns">
	<li class="left"><button type="button" name="boardviewclose" class="btn_resp size_b color5">목록</button></li>
	<li class="right">
<?php if($TPL_VAR["manager"]["auth_write"]!='[admin]'){?>
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"){?>
			<button type="button" name="boad_modify_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>" board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b">수정</button>
<?php }?>
<?php }?>
<?php if((($TPL_VAR["display"]== 0||($TPL_VAR["display"]== 1&&$TPL_VAR["replyor"]== 0&&$TPL_VAR["comment"]== 0)))&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"){?>
		<button type="button"  name="boad_delete_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>"  board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b">삭제</button>
<?php }?>
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["replylay"]=='Y'&&$TPL_VAR["managerview"]["isperm_write"]!="_no"){?>
		<button type="button" name="boad_reply_btn" board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b">답변</button>
<?php }?>
<?php if($TPL_VAR["manager"]["auth_write"]!='[admin]'){?>
<?php if($TPL_VAR["managerview"]["isperm_write"]!="_no"){?>
			<button type="button" name="boad_write_btn<?php echo $TPL_VAR["managerview"]["isperm_write"]?>" id="boad_write_btn<?php echo $TPL_VAR["managerview"]["isperm_write"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b color2"><?php echo $TPL_VAR["manager"]["name"]?> 쓰기</button>
<?php }?>
<?php }?>
	</li>
</ul>


<div id="CmtBoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3> 비밀번호 확인</h3>
		<div style="padding:10px 0 0;">댓글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
	</div>
	<form name="BoardPwcheckForm" id="CmtBoardPwcheckForm" method="post" >
	<input type="hidden" name="seq" id="cmt_pwck_seq" value="" />
	<input type="hidden" name="cmtseq" id="cmt_pwck_cmtseq" value="" />
	<div class="ibox">
		<input type="password" name="pw" id="cmt_pwck_pw" style="width:140px;" />
		<button type="submit" id="CmtBoardPwcheckBtn" class="btn_resp size_b color2" />확인</button>
		<button type="button" class="btn_resp size_b" onclick="$('#CmtBoardPwCk').dialog('close');" />취소</button>
	</div>
	</form>
</div>
<!-- //댓글 비회원 비밀번호 확인 -->

<div id="ModDelBoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3> 비밀번호 확인</h3>
		<div style="padding:10px 0 0;">게시글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
	</div>
	<form name="ModDelBoardPwcheckForm" id="ModDelBoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame " >
	<input type="hidden" name="modetype" id="modetype" value="" />
	<input type="hidden" name="seq" id="moddel_pwck_seq" value="" />
	<input type="hidden" name="returnurl" id="moddel_pwck_returnurl" value="" />
	<div class="ibox">
		<input type="password" name="pw" id="moddel_pwck_pw" style="width:140px;" />
		<button type="submit" id="BoardPwcheckBtn" class="btn_resp size_b color2" />확인</button>
		<button type="button" class="btn_resp size_b" onclick="$('#ModDelBoardPwCk').dialog('close');" />취소</button>
	</div>
	</form>
</div>
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