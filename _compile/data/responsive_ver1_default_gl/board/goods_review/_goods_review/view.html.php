<?php /* Template_ 2.2.6 2021/12/15 17:48:34 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/board/goods_review/_goods_review/view.html 000014814 */  $this->include_("sslAction","snslinkurl");
$TPL_reviewcategorylist_1=empty($TPL_VAR["reviewcategorylist"])||!is_array($TPL_VAR["reviewcategorylist"])?0:count($TPL_VAR["reviewcategorylist"]);
$TPL_goodsreview_sub_1=empty($TPL_VAR["goodsreview_sub"])||!is_array($TPL_VAR["goodsreview_sub"])?0:count($TPL_VAR["goodsreview_sub"]);
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 상품후기 View @@
- 파일위치 : [스킨폴더]/board/goods_review/_goods_review/view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if(!$_GET["iframe"]){?><?php }?>

<form name="form1" id="form1" method="post" action="<?php echo sslAction('../board_process')?>"  target="actionFrame">
	<input type="hidden" name="mode" id="mode" value="<?php echo $TPL_VAR["mode"]?>" />
	<input type="hidden" name="board_id" id="board_id" value="<?php echo $_GET["id"]?>" />
	<input type="hidden" name="reply" id="reply" value="<?php echo $_GET["reply"]?>" />
<?php if($TPL_VAR["seq"]){?>
	<input type="hidden" name="seq" id="board_seq" value="<?php echo $TPL_VAR["seq"]?>" />
<?php }?>
	<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>">
	<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>">
	<input type="hidden" name="goods_seq" value="<?php echo $_GET["goods_seq"]?>">

	<div class="board_detail_title">
<?php if($TPL_VAR["datacategory"]){?>[<?php echo $TPL_VAR["datacategory"]?>]<?php }?> <?php echo $TPL_VAR["iconmobile"]?> <?php echo $TPL_VAR["subject"]?> <?php echo $TPL_VAR["iconnew"]?> <?php echo $TPL_VAR["iconhot"]?> <?php echo $TPL_VAR["iconhidden"]?>

	</div>
	<table class="table_row_a Thc" data-responsive="yes" width="100%" cellpadding="0" cellspacing="0">
		<colgroup><col class="size_b"><col><col class="size_b"><col></colgroup>
		<tbody>
			<tr>
				<th><p designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >작성자</p></th>
				<td><?php echo $TPL_VAR["name"]?></td>
				<th><p designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >등록일</p></th>
				<td><?php echo $TPL_VAR["r_date"]?></td>
			</tr>
			<tr>
				<th><p designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >조회수</p></th>
				<td><?php echo number_format($TPL_VAR["hit"])?></td>
<?php if($TPL_VAR["buyertitle"]){?>
				<th><p designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >구매여부</p></th>
				<td><?php echo $TPL_VAR["buyertitle"]?></td>
<?php }?>
			</tr>
			<tr>
				<th><p designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >평점</p></th>
				<td colspan="3">
<?php if(!$TPL_VAR["isplusfreenot"]){?>
						<?php echo $TPL_VAR["scorelay"]?>

<?php }else{?>
						<?php echo $TPL_VAR["scorelay"]?><?php if($TPL_VAR["score_avg_lay"]){?>/100<?php }?>
<?php if($TPL_VAR["reviewcategorylist"]){?>,&nbsp;&nbsp;
<?php if($TPL_reviewcategorylist_1){$TPL_I1=-1;foreach($TPL_VAR["reviewcategorylist"] as $TPL_V1){$TPL_I1++;?>
								<?php echo $TPL_V1["title"]?> <?php if($TPL_V1["score"]){?><?php echo getGoodsScore($TPL_V1["score"],$TPL_VAR["manager"],'view',$TPL_V1["idx"])?> <?php }else{?> 0 <?php }?>
<?php if(count($TPL_VAR["reviewcategorylist"])- 1>$TPL_I1){?>,&nbsp;&nbsp;<?php }?>
<?php }}?>
<?php }?>
<?php }?>
				</td>
			</tr>
<?php if($TPL_VAR["goodsreview_sub"]){?>
<?php if($TPL_goodsreview_sub_1){foreach($TPL_VAR["goodsreview_sub"] as $TPL_V1){?>
<?php if($TPL_V1["used"]=='Y'){?>
			<tr>
				<th><p><?php echo $TPL_V1["label_title"]?></p></th>
				<td colspan="3">
					<?php echo $TPL_V1["label_view"]?>

				</td>
			</tr>
<?php }?>
<?php }}?>
<?php }?>
<?php if($TPL_VAR["file_key_w"]&&$TPL_VAR["uccdomain_fileswf"]){?>
			<tr>
				<th><p designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >첨부파일</p></th>
				<td colspan="3">
					<embed src="<?php echo $TPL_VAR["uccdomain_fileswf"]?>" width="<?php echo $TPL_VAR["managerview"]["video_size0"]?>" height="<?php echo $TPL_VAR["managerview"]["video_size1"]?>" allowfullscreen="true" wmode="transparent"></embed>
				</td>
			</tr>
<?php }?>
<?php if($TPL_VAR["filelist"]){?>
			<tr>
				<th><p designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >첨부파일</p></th>
				<td colspan="3">
					<ul>
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
						<li>
							<span class="realfilelist hand highlight-link" realfiledir="<?php echo $TPL_V1["realfiledir"]?>" realfilename="<?php echo $TPL_V1["orignfile"]?>"  realfilename="<?php echo $TPL_V1["orignfile"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" filedown="../board_process?mode=board_file_down&board_id=<?php echo $TPL_VAR["boardid"]?>&realfiledir=<?php echo $TPL_V1["realfiledir"]?>&realfilename=<?php echo $TPL_V1["orignfile"]?>"><?php echo $TPL_V1["orignfile"]?> (<span class="size"><?php echo $TPL_V1["realsizefile"]?></span>) <button type="button"  class="bbs_btn">down</button></span>
<?php if($TPL_V1["is_image"]){?>
								<span class="hand" imgsrc="<?php echo $TPL_V1["realfile"]?>" onclick="board_file_review('<?php echo $TPL_V1["realfileurl"]?>','<?php echo $TPL_V1["imagesize"][ 0]?>','<?php echo $TPL_V1["imagesize"][ 1]?>');"><img src="/data/skin/responsive_ver1_default_gl/images/icon/icon_zoom.gif" hspace="1" title="미리보기"/></span>
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
		<h4 class="title"><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >상품 정보</span></h4>
		<!-- 상품 정보 노출( 스킨단에서 html 수정 불가. CSS로만 수정하세요. ) -->
		<?php echo $TPL_VAR["goodsview"]?>

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

<!-- 이전글, 다음글 -->
<div id="prenextlist" class="board_prev_next_list">
	<!-- 이전글/다음글 인클루드. 파일위치 : [스킨폴더]/board/_prenext.html -->
<?php $this->print_("prenextskin",$TPL_SCP,1);?>

	<!-- //이전글/다음글 인클루드 -->
</div>

<!-- 하단 각종 버튼 -->
<ul class="board_detail_btns">
	<li class="left"><button type="button" name="boardviewclose" class="btn_resp size_b color5"><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >목록</span></button></li>
	<li class="right">
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"){?>
		<button type="button" <?php if($_GET["iframe"]){?>name="goods_boad_modify_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>"<?php }else{?>name="boad_modify_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>"<?php }?> board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b"><span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >수정</span></button>
<?php }?>
<?php if((($TPL_VAR["display"]== 0||($TPL_VAR["display"]== 1&&$TPL_VAR["replyor"]== 0&&$TPL_VAR["comment"]== 0)))&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"){?> 
		<button type="button"  <?php if($_GET["iframe"]){?>name="goods_boad_delete_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>"<?php }else{?>name="boad_delete_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>"<?php }?>  board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>"  class="btn_resp size_b"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >삭제</span></button>
<?php }?>
<?php if(!$_GET["iframe"]){?>
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["replylay"]=='Y'&&$TPL_VAR["managerview"]["isperm_write"]!="_no"){?>
			<button type="button"  name="boad_reply_btn" board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >답변</span></button>
<?php }?>
<?php }?>
<?php if($TPL_VAR["managerview"]["isperm_write"]!="_no"){?>
		<button type="button" <?php if($_GET["iframe"]){?>id="goods_boad_write_btn<?php echo $TPL_VAR["managerview"]["isperm_write"]?>"<?php }else{?>id="boad_write_btn<?php echo $TPL_VAR["managerview"]["isperm_write"]?>"<?php }?> board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b color2"><?php echo $TPL_VAR["manager"]["name"]?> <span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvZ29vZHNfcmV2aWV3L19nb29kc19yZXZpZXcvdmlldy5odG1s" >쓰기</span></button>
<?php }?>
	</li>
</ul>



<div id="CmtBoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3> 비밀번호 확인</h3>
		<div style="padding:10px 0 0;">댓글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
	</div>
	<form name="BoardPwcheckForm" id="CmtBoardPwcheckForm" method="post">
		<input type="hidden" name="seq" id="cmt_pwck_seq" value="" />
		<input type="hidden" name="cmtseq" id="cmt_pwck_cmtseq" value="" />
		<div class="C Pt20">
			<input type="password" name="pw" id="cmt_pwck_pw" style="width:140px;" />
			<button type="submit" id="CmtBoardPwcheckBtn" class="btn_resp size_b color2">확인</button>
			<button type="button" class="btn_resp size_b" onclick="$('#CmtBoardPwCk').dialog('close');">취소</button>
		</div>
	</form>
</div>
<!-- //댓글 비회원 비밀번호 확인 -->

<div id="ModDelBoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3> 비밀번호 확인</h3>
		<div style="padding:10px 0 0;">게시글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
	</div>
	<form name="ModDelBoardPwcheckForm" id="ModDelBoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame ">
		<input type="hidden" name="modetype" id="modetype" value="" />
		<input type="hidden" name="seq" id="moddel_pwck_seq" value="" />
		<input type="hidden" name="returnurl" id="moddel_pwck_returnurl" value="" />
		<div class="C Pt20">
			<input type="password" name="pw" id="moddel_pwck_pw" style="width:140px;" />
			<button type="submit" id="BoardPwcheckBtn" class="btn_resp size_b color2">확인</button>
			<button type="button" class="btn_resp size_b" onclick="$('#ModDelBoardPwCk').dialog('close');">취소</button>
		</div>
	</form>
</div>

<!-- //게시글 비회원 비밀번호 확인 -->
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
			openDialogAlert(getAlert('et143'),'450','140');
<?php }else{?>
			//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
			openDialogConfirm(getAlert('et144'),'400','155',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
	}

	function getcmtMbLogin(){
<?php if(defined('__ISUSER__')===true){?>
			//글작성자만 이용가능합니다.
			openDialogAlert(getAlert('et145'),'400','140');
<?php }else{?>
			//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
			openDialogConfirm(getAlert('et144'),'400','155',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
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
			if( $(this).width()> default_width || $(this).height()> default_width ) {
				imageResize(this,default_width);
			}
		});
	});
</script>