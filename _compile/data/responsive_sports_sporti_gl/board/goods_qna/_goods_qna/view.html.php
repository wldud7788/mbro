<?php /* Template_ 2.2.6 2021/12/15 16:50:22 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/board/goods_qna/_goods_qna/view.html 000013010 */  $this->include_("sslAction","snslinkurl");
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 상품문의 View @@
- 파일위치 : [스킨폴더]/board/goods_qna/_goods_qna/view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if(!$_GET["iframe"]){?><?php }?>

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
				<th><p designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL3ZpZXcuaHRtbA==" >분류</p></th>
				<td><?php if($TPL_VAR["datacategory"]){?>[<?php echo $TPL_VAR["datacategory"]?>]<?php }?> <?php echo $TPL_VAR["iconmobile"]?><?php echo $TPL_VAR["iconaward"]?></td>
				<th><p designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL3ZpZXcuaHRtbA==" >작성자</p></th>
				<td><?php echo $TPL_VAR["name"]?></td>
			</tr>
			<tr>
				<th><p designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL3ZpZXcuaHRtbA==" >등록일</p></th>
				<td><?php echo $TPL_VAR["r_date"]?></td>
				<th><p designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL3ZpZXcuaHRtbA==" >조회수</p></th>
				<td><?php echo number_format($TPL_VAR["hit"])?></td>
			</tr>
<?php if($TPL_VAR["filelist"]){?>
			<tr>
				<th><p designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL3ZpZXcuaHRtbA==" >첨부파일</p></th>
				<td colspan="3">
					<ul>
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
						<li>
							<span class="realfilelist hand highlight-link" realfiledir="<?php echo $TPL_V1["realfiledir"]?>" realfilename="<?php echo $TPL_V1["orignfile"]?>"  realfilename="<?php echo $TPL_V1["orignfile"]?>" board_id="goods_qna" filedown="../board_process?mode=board_file_down&board_id=goods_qna&realfiledir=<?php echo $TPL_V1["realfiledir"]?>&realfilename=<?php echo $TPL_V1["orignfile"]?>"><?php echo $TPL_V1["orignfile"]?> (<span class="size"><?php echo $TPL_V1["realsizefile"]?></span>) <button type="button"  class="bbs_btn">down</button></span>
<?php if($TPL_V1["is_image"]){?>
								<span class="hand" imgsrc="<?php echo $TPL_V1["realfile"]?>" onclick="board_file_review('<?php echo $TPL_V1["realfile"]?>','<?php echo $TPL_V1["imagesize"][ 0]?>','<?php echo $TPL_V1["imagesize"][ 1]?>');" ><img src="/data/skin/responsive_sports_sporti_gl/board/goods_qna/images/icon/icon_zoom.gif" hspace="1" title="미리보기"/></span>
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

<?php if($TPL_VAR["managerview"]["auth_recommend_use"]=='Y'){?>
	<div class="board_score">
		<!-- 게시글 평가 인클루드. 파일위치 : [스킨폴더]/board/_score.html -->
<?php $this->print_("scoreskin",$TPL_SCP,1);?>

		<!-- //게시글 평가 인클루드 -->
	</div>
<?php }?>


<?php if($TPL_VAR["goodsview"]){?>
	<div class="goods_origin_info">
		<h4 class="title"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL3ZpZXcuaHRtbA==" >상품 정보</span></h4>
		<!-- 상품 정보 노출( 스킨단에서 html 수정 불가. CSS로만 수정하세요. ) -->
		<?php echo $TPL_VAR["goodsview"]?>

	</div>
<?php }?>
	
	<div class="board_sns_link">
		<?php echo snslinkurl('board',$TPL_VAR["subject"])?>

	</div>

	<!-- 관리자 답변 -->
<?php if($TPL_VAR["re_contents"]){?>
	<div class="board_manager_reply">
		<div class="writer">
			<span class="icon1" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL3ZpZXcuaHRtbA==" >답변</span> <strong><?php echo $TPL_VAR["adminname"]?></strong> 
			<span><?php echo $TPL_VAR["reply_title"]?></span>
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


<?php if($TPL_VAR["commentlay"]=='Y'||$TPL_VAR["comment"]> 0){?>
<a name="cmtlist"></a>
<div class="board_comment_area" id="comment_container">
	<!-- 게시글 댓글/덧글 인클루드. 파일위치 : [스킨폴더]/board/_comment.html -->
<?php $this->print_("commentskin",$TPL_SCP,1);?>

	<!-- //게시글 댓글/덧글 인클루드 -->
</div>
<?php }?>

<div id="prenextlist" class="board_prev_next_list">
	<!-- 이전글/다음글 인클루드. 파일위치 : [스킨폴더]/board/_prenext.html -->
<?php $this->print_("prenextskin",$TPL_SCP,1);?>

	<!-- //이전글/다음글 인클루드 -->
</div>

<!-- 하단 각종 버튼 -->
<ul class="board_detail_btns">
	<li class="left"><button type="button" name="boardviewclose" class="btn_resp size_b color5"><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL3ZpZXcuaHRtbA==" >목록</span></button></li>
	<li class="right">
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"){?>
		<button type="button" name="goods_boad_modify_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>" board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b"><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL3ZpZXcuaHRtbA==" >수정</span></button>
<?php }?>
<?php if((($TPL_VAR["display"]== 0||($TPL_VAR["display"]== 1&&$TPL_VAR["replyor"]== 0&&$TPL_VAR["comment"]== 0)))&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"){?> 
		<button type="button"  name="goods_boad_delete_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>"  board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>"  class="btn_resp size_b"><span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL3ZpZXcuaHRtbA==" >삭제</span></button>
<?php }?>
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["replylay"]=='Y'&&$TPL_VAR["managerview"]["isperm_write"]!="_no"){?> 
		<button type="button"  id="goods_boad_reply_btn" board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL3ZpZXcuaHRtbA==" >답변</button>
<?php }?>
<?php if($TPL_VAR["managerview"]["isperm_write"]!="_no"){?>
		<button type="button" id="goods_boad_write_btn<?php echo $TPL_VAR["managerview"]["isperm_write"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b color2"><?php echo $TPL_VAR["manager"]["name"]?> <span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL3ZpZXcuaHRtbA==" >쓰기</span></button>
<?php }?>
	</li>
</ul>
<!-- //버튼 -->





<div id="CmtBoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3>비밀번호 확인</h3>
		<div>댓글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
	</div>
	<form name="BoardPwcheckForm" id="CmtBoardPwcheckForm" method="post">
		<input type="hidden" name="seq" id="cmt_pwck_seq" value="" />
		<input type="hidden" name="cmtseq" id="cmt_pwck_cmtseq" value="" />
		<div class="ibox">
			<input type="password" name="pw" id="cmt_pwck_pw" class="input" />
			<input type="submit" id="CmtBoardPwcheckBtn" value=" 확인 " class="btnblue" />
			<input type="button" value=" 취소 " class="btngray" onclick="$('#CmtBoardPwCk').dialog('close');" />
		</div>
	</form>
</div>
<!-- //댓글 비회원 비밀번호 확인 -->

<div id="ModDelBoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3>비밀번호 확인</h3>
		<div>게시글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
	</div>
	<form name="ModDelBoardPwcheckForm" id="ModDelBoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame ">
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
<!-- //게시글 비회원 비밀번호 확인 -->

<?php if($_GET["iframe"]){?>
<div id="BoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3>비밀번호 확인</h3>
		<div>게시글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
	</div>
	<form name="BoardPwcheckForm" id="BoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame ">
		<input type="hidden" name="seq" id="pwck_seq" value="" />
		<input type="hidden" name="returnurl" id="pwck_returnurl" value="" />
		<div class="ibox">
			<input type="password" name="pw" id="pwck_pw" class="input" />
			<input type="submit" id="BoardPwcheckBtn" value=" 확인 " class="btnblue" />
			<input type="button" value=" 취소 " class="btngray" onclick="$('#BoardPwCk').dialog('close');" />
		</div>
	</form>
</div>
<!-- //비밀번호 확인 -->
<?php }?>

<script type="text/javascript">
	$(document).ready(function(){
		/* iframe 호출 시 팝업 영역 동적 생성 - 시작 */
		var LayerFind = $(document).find("#openDialogLayer");
		// 팝업 없는 경우 영역 생성
		if(LayerFind.length < 1){
			var openDialogLayer = $('<div />',{
				id: 'openDialogLayer',
				display: 'none',
			});
			var openDialogLayerMsg = $('<div />',{
				id: 'openDialogLayerMsg',
				align: 'center',
			});

			$(openDialogLayer).append(openDialogLayerMsg);
			$("#ModDelBoardPwCk").after(openDialogLayer);
		}
		/* iframe 호출 시 팝업 영역 동적 생성 - 종료 */
		
	});

	function getboardLogin(){
<?php if(defined('__ISUSER__')===true){?>
			//해당 서비스를 이용하시려면 관리자에게 문의하여 주시길 바랍니다.
			openDialogAlert(getAlert('et132'),'450','140');
<?php }else{?>
			//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
			openDialogConfirm(getAlert('et133'),'400','155',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
	}

	function getcmtMbLogin(){
<?php if(defined('__ISUSER__')===true){?>
			//글작성자만 이용가능합니다.
			openDialogAlert(getAlert('et131'),'400','140');
<?php }else{?>
			//해당 서비스를 이용하시려면 관리자에게 문의하여 주시길 바랍니다.
			openDialogConfirm(getAlert('et132'),'400','155',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
	}
</script>