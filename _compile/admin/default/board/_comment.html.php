<?php /* Template_ 2.2.6 2022/05/17 12:30:56 /www/music_brother_firstmall_kr/admin/skin/default/board/_comment.html 000016949 */ 
$TPL_cmtloop_1=empty($TPL_VAR["cmtloop"])||!is_array($TPL_VAR["cmtloop"])?0:count($TPL_VAR["cmtloop"]);?>
<div class="item-title">
	<span>댓글 (<?php echo $TPL_VAR["comment"]?>)</span>
	<span class="fr">
		<button type="button" name="board_cmt_seldelete_btn" board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="resp_btn v3">선택 삭제</button>
	</span>
</div>
<table class="table_basic">
	<colgroup>
		<col width="1">
		<col width="150">
		<col>
		<col width="130">
		<col width="160">
	</colgroup>
	<thead>
		<tr>
			<th>
				<label class="resp_checkbox">
					<input type="checkbox" id="checkboxcmtAll" name="checkboxcmtAll" value>
				</label>
			</th>
			<th>작성자</th>
			<th>내용</th>
			<th>등록일</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_cmtloop_1){foreach($TPL_VAR["cmtloop"] as $TPL_V1){?>
		<tr>
			<td class="center">
				<label class="resp_checkbox">
					<input type="checkbox" name="cmtdel[]" value="<?php echo $TPL_V1["seq"]?>" class="cmtcheckeds hand" cmt="parent">
				</label>
			</td>
			<td>
				<p>
					<?php echo $TPL_V1["iconhidden"]?>

					<?php echo $TPL_V1["name"]?>

					<?php echo $TPL_V1["iconnew"]?>

				</p>
				<p>(IP: <?php echo $TPL_V1["ip"]?>)</p>
			</td>
			<td>
				<p>
					<span style="white-space:pre-line"><?php echo $TPL_V1["content"]?></span>
				</p>
				<div class="center">
<?php if($TPL_V1["cmtaward"]&&$TPL_V1["best"]!="checked"){?>
					<input type="button" name="cmt_award_btn"value="당첨 <?php if($TPL_V1["best"]=='checked'){?>해제하기<?php }else{?>해주기<?php }?>" class="bbs_btn cmt_award_btn <?php echo $TPL_V1["best"]?> " board_cmt_seq="<?php echo $TPL_V1["seq"]?>" board_cmt_idx="<?php echo $TPL_V1["idx"]?>" board_seq="<?php echo $_GET["seq"]?>" returnurl="<?php echo $TPL_VAR["boardurl"]->cmtview?>" board_id="<?php echo $TPL_VAR["boardid"]?>">
<?php }?>
<?php if($TPL_VAR["managerview"]["auth_cmt_recommend_use"]=='Y'){?>
					<!-- 댓글평가 -->
					<span class="scorelay" style="margin: 15px 0 5px">
<?php if($TPL_VAR["managerview"]["auth_cmt_recommend_use"]=='Y'){?>
						<span >
<?php if($TPL_VAR["managerview"]["cmt_recommend_type"]=='2'){?> 
<?php if($TPL_VAR["managerview"]["icon_cmt_recommend_src"]&&$TPL_VAR["managerview"]["icon_cmt_none_rec_src"]){?>
								<span style="width:50px;margin:auto;border:0px dashed black;padding:5px">  
									<span class="icon_cmt_recommend_<?php echo $TPL_VAR["seq"]?>_<?php echo $TPL_V1["seq"]?>_lay<?php echo $TPL_V1["is_cmt_recommend"]?> icon_cmt_recommend_lay<?php echo $TPL_V1["is_cmt_recommend"]?> hand" board_recommend="recommend" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" board_seq="<?php echo $_GET["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>"><img src="<?php echo $TPL_VAR["managerview"]["icon_cmt_recommend_src"]?>" class="icon_cmt_recommend_img"></span>
									<span class="idx-cmt-recommend-<?php echo $TPL_VAR["seq"]?>-<?php echo $TPL_V1["seq"]?> "><?php echo number_format($TPL_V1["recommend"])?></span>
									<span class="icon_cmt_none_rec_<?php echo $TPL_VAR["seq"]?>_<?php echo $TPL_V1["seq"]?>_lay<?php echo $TPL_V1["is_cmt_recommend"]?> icon_cmt_none_rec_lay<?php echo $TPL_V1["is_cmt_recommend"]?> hand" board_recommend="none_rec" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" board_seq="<?php echo $_GET["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>"><img src="<?php echo $TPL_VAR["managerview"]["icon_cmt_none_rec_src"]?>" class="icon_cmt_none_rec_img"></span>
									<span class="idx-cmt-none_rec-<?php echo $TPL_VAR["seq"]?>-<?php echo $TPL_V1["seq"]?>"><?php echo number_format($TPL_V1["none_rec"])?></span>
								</span> 
<?php }?>
<?php }elseif($TPL_VAR["managerview"]["cmt_recommend_type"]=='1'){?>
<?php if($TPL_VAR["managerview"]["icon_cmt_recommend_src"]){?>
								<span style="width:50px;margin:auto;border:0px dashed black;padding:5px">  
									<span class="icon_cmt_recommend_<?php echo $TPL_VAR["seq"]?>_<?php echo $TPL_V1["seq"]?>_lay<?php echo $TPL_V1["is_cmt_recommend"]?> icon_cmt_recommend_lay<?php echo $TPL_V1["is_cmt_recommend"]?> hand" board_recommend="recommend" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" board_seq="<?php echo $_GET["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>"><img src="<?php echo $TPL_VAR["managerview"]["icon_cmt_recommend_src"]?>" class="icon_cmt_recommend_img"></span>
									<span class="idx-cmt-recommend-<?php echo $TPL_VAR["seq"]?>-<?php echo $TPL_V1["seq"]?>"><?php echo number_format($TPL_V1["recommend"])?></span> 
								</span> 
<?php }?>
<?php }?>
						</span>
<?php }?> 
					</span>
					<!-- 댓글평가 -->
<?php }?>
				</div>
			</td>
			<td class="center">
				<nobr><?php echo implode('</nobr> <nobr>',explode(' ',$TPL_V1["date"]))?></nobr>
			</td>
			<td>
				<nobr>
					<button type="button" name="boad_cmt_reply_btn<?php echo $TPL_VAR["managerview"]["isperm_write"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" board_cmt_idx="<?php echo $TPL_V1["idx"]?>" class="resp_btn v2">댓글</button>
					<button type="button" name="boad_cmt_modify_btn<?php echo $TPL_V1["isperm_moddel"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="resp_btn v2 <?php echo $TPL_V1["isperm_hide"]?>">수정</button>
					<button type="button" name="boad_cmt_delete_btn<?php echo $TPL_V1["isperm_moddel"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="resp_btn v3 <?php echo $TPL_V1["isperm_hide"]?>">삭제</button>
				</nobr>
			</td>
		</tr>
<?php if(is_array($TPL_R2=$TPL_V1["cmtreplyloop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
		<tr>
			<td class="center">
				<label class="resp_checkbox">
					<input type="checkbox" name="cmtdel[]" value="<?php echo $TPL_V2["seq"]?>" class="cmtcheckeds hand" cmt="reply">
				</label>
			</td>
			<td>
				<p>
					<?php echo $TPL_V2["iconhidden"]?>

					<?php echo $TPL_V2["name"]?>

					<?php echo $TPL_V2["iconnew"]?>

				</p>
				<p>(IP: <?php echo $TPL_V2["ip"]?>)</p>
			</td>
			<td>
				<p>
					<span>
						<img src="/admin/skin/default/images/board/icon/icon_comment_reply.gif">
						<span style="font-weight:bold;color:#4472c4">RE:</span>
					</span>
					<span style="white-space:pre-line"><?php echo $TPL_V2["content"]?></span>
				</p>
				<div class="center">
<?php if($TPL_VAR["managerview"]["auth_cmt_recommend_use"]=='Y'){?>
					<!-- 댓글평가 -->
					<span class="scorelay" style="margin: 15px 0 5px">
<?php if($TPL_VAR["managerview"]["auth_cmt_recommend_use"]=='Y'){?>
						<span >
<?php if($TPL_VAR["managerview"]["cmt_recommend_type"]=='2'){?> 
<?php if($TPL_VAR["managerview"]["icon_cmt_recommend_src"]&&$TPL_VAR["managerview"]["icon_cmt_none_rec_src"]){?>
								<span style="width:50px;margin:auto;border:0px dashed black;padding:5px">  
									<span class="icon_cmt_recommend_<?php echo $TPL_VAR["seq"]?>_<?php echo $TPL_V2["seq"]?>_lay<?php echo $TPL_V2["is_cmt_recommend"]?> icon_cmt_recommend_lay<?php echo $TPL_V2["is_cmt_recommend"]?> hand " board_recommend="recommend" board_cmt_seq="<?php echo $TPL_V2["seq"]?>" board_seq="<?php echo $_GET["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>"><img src="<?php echo $TPL_VAR["managerview"]["icon_cmt_recommend_src"]?>" class="icon_cmt_recommend_img"></span>
									<span class="idx-cmt-recommend-<?php echo $TPL_VAR["seq"]?>-<?php echo $TPL_V2["seq"]?> "><?php echo number_format($TPL_V1["recommend"])?></span>
									<span class="icon_cmt_none_rec_<?php echo $TPL_VAR["seq"]?>_<?php echo $TPL_V2["seq"]?>_lay<?php echo $TPL_V2["is_cmt_recommend"]?> icon_cmt_none_rec_lay<?php echo $TPL_V2["is_cmt_recommend"]?> hand" board_recommend="none_rec" board_cmt_seq="<?php echo $TPL_V2["seq"]?>" board_seq="<?php echo $_GET["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>"><img src="<?php echo $TPL_VAR["managerview"]["icon_cmt_none_rec_src"]?>" class="icon_cmt_none_rec_img"></span>
									<span class="idx-cmt-none_rec-<?php echo $TPL_VAR["seq"]?>-<?php echo $TPL_V2["seq"]?>"><?php echo number_format($TPL_V1["none_rec"])?></span>
								</span> 
<?php }?>
<?php }elseif($TPL_VAR["managerview"]["cmt_recommend_type"]=='1'){?>
<?php if($TPL_VAR["managerview"]["icon_cmt_recommend_src"]){?>
								<span style="width:50px;margin:auto;border:0px dashed black;padding:5px">  
									<span class="icon_cmt_recommend_<?php echo $TPL_VAR["seq"]?>_<?php echo $TPL_V2["seq"]?>_lay<?php echo $TPL_V2["is_cmt_recommend"]?> icon_cmt_recommend_lay<?php echo $TPL_V2["is_cmt_recommend"]?> hand " board_recommend="recommend" board_cmt_seq="<?php echo $TPL_V2["seq"]?>" board_seq="<?php echo $_GET["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>"><img src="<?php echo $TPL_VAR["managerview"]["icon_cmt_recommend_src"]?>" class="icon_cmt_recommend_img"></span>
									<span class="idx-cmt-recommend-<?php echo $TPL_VAR["seq"]?>-<?php echo $TPL_V2["seq"]?>"><?php echo number_format($TPL_V1["recommend"])?></span> 
								</span> 
<?php }?>
<?php }?>
						</span>
<?php }?> 
					</span>
					<!-- 댓글평가 -->
<?php }?>  
				</div>
			</td>
			<td class="center">
				<nobr><?php echo implode('</nobr> <nobr>',explode(' ',$TPL_V2["date"]))?></nobr>
			</td>
			<td>
				<nobr>
					<button type="button" name="boad_cmt_modify_reply_btn<?php echo $TPL_V2["isperm_moddel"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" board_cmt_reply_seq="<?php echo $TPL_V2["seq"]?>" board_cmt_idx="<?php echo $TPL_V1["idx"]?>" class="resp_btn v2 <?php echo $TPL_V2["isperm_hide"]?>">수정</button>
					<button type="button" name="boad_cmt_delete_btn<?php echo $TPL_V2["isperm_moddel"]?>" board_cmt_seq="<?php echo $TPL_V2["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" board_cmt_reply_seq="<?php echo $TPL_V2["seq"]?>" board_cmt_idx="<?php echo $TPL_V1["idx"]?>" class="resp_btn v3 <?php echo $TPL_V2["isperm_hide"]?>">삭제</button>
				</nobr>
			</td>
		</tr>
<?php }}?>
		<tr class="cmtreplylay cmtreplyform<?php echo $TPL_V1["idx"]?> hide">
			<td class="left" colspan="5">
				<div class="wbox" id="cmtreplyform<?php echo $TPL_V1["idx"]?>">
<?php if($TPL_VAR["managerview"]["isperm_write"]=="_no"){?>
						<div class="box center hand" style="width:100%;color:gray;margin:5px">로그인 후 댓글권한이 있을 경우 등록하실 수 있습니다</div>
<?php }else{?>
						<table class="box" style="width:100%">
							<colgroup>
								<col>
								<col width="1">
							</colgroup>
							<tbody>
								<tr>
									<td colspan="2">
										<?php echo $TPL_VAR["commentmanager"]["writetitle"]?> (IP: <?php echo $_SERVER["REMOTE_ADDR"]?>)
										<input type="hidden" name="name" id="cmtname<?php echo $TPL_V1["seq"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" value="<?php echo $TPL_VAR["cmt_name"]?>">
									</td>
								</tr>
								<tr>
									<td>
										<textarea name="content" id="cmtcontent<?php echo $TPL_V1["seq"]?>" class="resp_textarea" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" style="width:calc(100% - .6em);box-sizing:border-box" required></textarea>
									</td>
									<td valign="top">
										<nobr>
											<button type="button" name="board_commentsend_reply" id="board_commentsend_reply<?php echo $TPL_V1["seq"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" board_cmt_reply_seq="" board_cmt_idx="<?php echo $TPL_V1["idx"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="resp_btn active">등록</button>
										</nobr>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<span class="<?php echo $TPL_VAR["cmthiddenlay"]?>">
											<label class="resp_checkbox">
												<input type="checkbox" name="hidden" id="cmthidden<?php echo $TPL_V1["seq"]?>" value="1" <?php echo $TPL_VAR["hiddenckeck"]?>>
												<span>비밀 댓글</span>
											</label>
										</span>
									</td>
								</tr>
							</tbody>
						</table>
<?php }?>
				</div>
			</td>
		</tr>
<?php }}else{?>
		<tr>
			<td class="center" colspan="5">등록된 댓글이 없습니다.</td>
		</tr>
<?php }?>
	</tbody>
</table>
<div id="cmtpager" class="paging_navigation center"><?php echo $TPL_VAR["cmtpagin"]?></div>

<a name="cwriteform"></a>
<div id="cwrite<?php echo $TPL_VAR["managerview"]["isperm_write"]?>" class="<?php if($TPL_VAR["commentlay"]=='N'){?>hide<?php }?>">
	<form name="cmtform1" id="cmtform1" method="post" action="/admin/board_comment_process" target="actionFrame">
		<input type="hidden" name="mode" id="cmtmode" value="board_comment_write">
		<input type="hidden" name="board_id" value="<?php echo $_GET["id"]?>">
		<input type="hidden" name="seq" value="<?php echo $TPL_VAR["seq"]?>">
		<input type="hidden" name="cmtseq" id="cmtseq" value="<?php echo $TPL_VAR["cmtseq"]?>">
		<input type="hidden" name="returnurl" id="cmtreturnurl" value="<?php echo $TPL_VAR["boardurl"]->cmtview?>&cmtpage=<?php echo $_GET["cmtpage"]?>">
		<input type="hidden" id="cmtname" name="name" value="<?php echo $TPL_VAR["cmt_name"]?>">
		<table class="box" style="width:100%">
			<colgroup>
				<col>
				<col width="1">
			</colgroup>
			<tbody>
				<tr>
					<td colspan="2">
						<?php echo $TPL_VAR["commentmanager"]["writetitle"]?> (IP: <?php echo $_SERVER["REMOTE_ADDR"]?>)
					</td>
				</tr>
				<tr>
					<td>
						<textarea name="content" id="cmtcontent" class="resp_textarea" rows="2" comment="true" style="width:calc(100% - .30em);box-sizing:border-box" required></textarea>
					</td>
					<td valign="top">
						<nobr>
							<button type="submit" name="board_commentsend" id="board_commentsend" board_id="<?php echo $TPL_VAR["boardid"]?>" class="resp_btn size_XL active">등록</button>
						</nobr>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<span class="<?php echo $TPL_VAR["cmthiddenlay"]?>">
							<label class="resp_checkbox">
								<input type="checkbox" name="hidden" id="cmthidden" value="1" <?php echo $TPL_VAR["hiddenckeck"]?>>
								<span>비밀 댓글</span>
							</label>
						</span>
					</td>
				</tr>
<?php if($_GET["id"]=='goods_review'){?>
				<tr>
					<td class="left">
						<div > 
							<label class="resp_checkbox"><input type="checkbox" name="board_sms" id="board_sms_com" value="1" <?php if($TPL_VAR["managerview"]["sms_reply_user_yn"]=="Y"&&$TPL_VAR["rsms"]=='Y'&&$TPL_VAR["tel1"]){?> checked="checked" <?php }?> <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');$('#board_sms_com').prop('checked',false);" <?php }?>  <?php if($TPL_VAR["managerview"]["sms_reply_user_yn"]!='Y'){?>disabled<?php }?>> SMS전송</label>

							<input type="text" name="board_sms_hand" id="board_sms_hand" value="<?php echo $TPL_VAR["tel1"]?>" title="휴대폰정보를 입력하세요.">
								잔여 SMS:<?php echo ($TPL_VAR["count"])?>건
							<div style="margin-top:5px"><span class="resp_message">
<?php if($TPL_VAR["managerview"]["sms_reply_user_yn"]!='Y'){?>
									게시판 설정 > SMS발송을 사용하고 있지 않습니다.  <a href="/admin/board/manager_write?id=<?php echo $_GET["id"]?>" class="resp_btn size_S" target="_blank">SMS 발송 설정</a>
<?php }else{?>
									SMS전송 체크시 입력된 전화번호로 함께 전송됩니다. <?php echo $TPL_VAR["managerview"]["restriction_msg"]?>

<?php }?>
								</span>
							</div>
						</div> 
					</td>
				</tr>
<?php }?>
			</tbody>
		</table>
	</form>
</div>
<script>
$(function() {
	EditorJSLoader.ready(function(Editor) {
		DaumEditorLoader.init(".daumeditor");
	});

	//댓글등록및 수정
	$('#cmtform1').validate({
		onkeyup: false,
		rules: {
			name: { required:true},
			content: { required:true}
		},
		messages: {
			name: { required:'입력해 주세요.'},
			captcha_code: { required:'입력해 주세요.'},
			pw: { required:''},
			content: { required:'입력해 주세요.'}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent());
		},
		submitHandler: function(f) {
			if(readyEditorForm(f)){
				if(!$("#cmtname").val() || $("#cmtname").val() == "이름을 입력해 주세요." ) {
					alert('이름을 입력해 주세요.');
					$("#cmtname").focus();
					return false;
				}

				if(!$("#cmtcontent").val() || $("#cmtcontent").val() == "<p>&nbsp;</p>" || $("#cmtcontent").val() == "내용을 입력해 주세요."){
					alert('내용을 입력해 주세요.');
					$("#cmtcontent").focus();
					return false;
				}
				f.submit();
			}
		}
	});

});
</script>