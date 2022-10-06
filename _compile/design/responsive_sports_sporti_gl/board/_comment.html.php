<?php /* Template_ 2.2.6 2021/12/15 16:50:22 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/board/_comment.html 000029330 */  $this->include_("sslAction");
$TPL_cmtloop_1=empty($TPL_VAR["cmtloop"])||!is_array($TPL_VAR["cmtloop"])?0:count($TPL_VAR["cmtloop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
	@@ 게시판 댓글/덧글 @@
	- 파일위치 : [스킨폴더]/board/_comment.html
	++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

	<div class="cmt_division v2">
		<div class="content title_area">
			<span class="title" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=" >댓글</span> <strong class="num pointcolor"><?php echo number_format($TPL_VAR["comment"])?></strong> &nbsp;
			<input type="button" name="board_comment_btn" id="board_comment_btn_<?php echo $TPL_VAR["seq"]?>" seq="<?php echo $TPL_VAR["seq"]?>" value="댓글 등록하기▼" class="board_comment_btn btn_resp size_b" />
		</div>
	</div>

	<a name="cwriteform"></a>
	<div id="cwrite<?php echo $TPL_VAR["managerview"]["isperm_write_cmt"]?>"  class="<?php if($TPL_VAR["commentlay"]=='N'){?>hide<?php }?>" >
		<div id="cmt_insert_<?php echo $TPL_VAR["seq"]?>" class="cmt_contents cmt_insert hide">
			<form name="cmtform_<?php echo $TPL_VAR["seq"]?>" id="cmtform_<?php echo $TPL_VAR["seq"]?>" method="post"  action="<?php echo sslAction('../board_comment_process')?>"  target="commentactionFrame">
<?php if($TPL_VAR["seq"]){?>
			<input type="hidden" name="seq" id="board_seq" value="<?php echo $TPL_VAR["seq"]?>" />
			<input type="hidden" name="board_id" id="board_id" value="<?php echo $TPL_VAR["manager"]["id"]?>" />
			<input type="hidden" name="mode" id="cmtmode" value="board_comment_write" />
			<input type="hidden" name="viewtype" value="<?php echo $TPL_VAR["pagemode"]?>" />
			<input type="hidden" name="returnurl" id="cmtreturnurl" value="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_VAR["seq"]?>" />
<?php }?>
<?php if($TPL_VAR["managerview"]["isperm_write_cmt"]=="_no"){?>
			<div class="cmt_box center hand">로그인 또는 댓글권한이 있을 경우 등록하실 수 있습니다</div>
<?php }else{?>
			<table class="cmt_box" cellpadding="0" cellspacing="0">
				<tbody>
<?php if(defined('__ISUSER__')===true&&$TPL_VAR["user_name"]){?>
				<tr>
					<td class="its-td">
						<input type="hidden" name="name" id="cmtname" class="required line" size="20" value="<?php echo $TPL_VAR["user_name"]?>" />
						<input type="text" value="<?php echo $TPL_VAR["user_name"]?>"  readonly="readonly" class="required line" />
						<input type="hidden" name="pw" id="cmtpw" class="required line pwchecklay" size="20" title="비밀번호" value="" />
						&nbsp;<span class="<?php echo $TPL_VAR["cmthiddenlay"]?>" ><label > <input type="checkbox" name="hidden"   id="cmthidden"  value="1" <?php echo $TPL_VAR["cmthiddenckeck"]?> /> 비밀댓글</label></span>
					</td>
				</tr>
<?php }else{?>
				<tr>
					<td class="its-td">
						<input type="text" name="name" id="cmtname" class="required line" size="20" title="이름" value="<?php echo $TPL_VAR["user_name"]?>" />
						<a class="its-td pwchecklay <?php if(defined('__ISUSER__')===true){?>hide<?php }?> ">
							<input type="password" name="pw" id="cmtpw" class="required line pwchecklay" size="20" title="비밀번호" value="" />
						</a>
						&nbsp;<span class="<?php echo $TPL_VAR["cmthiddenlay"]?>" ><label > <input type="checkbox" name="hidden"   id="cmthidden"  value="1" <?php echo $TPL_VAR["cmthiddenckeck"]?> /> 비밀댓글</label></span>
					</td>
				</tr>
<?php }?>
				<tr>
					<td class="its-td">
						<textarea name="content" id="cmtcontent" class="size1 required line" title="댓글을 입력해 주세요."></textarea>
					</td>
				</tr>
				<tr>
					<td class="its-td">
						<button type="button" class="btn_resp size_b" name="board_commentsend" id="board_commentsend" seq="<?php echo $TPL_VAR["seq"]?>">댓글등록</button>
					</td>
				</tr>
<?php if($TPL_VAR["manager"]["autowrite_use"]=='Y'&&$TPL_VAR["captcha_image"]){?>
				<tr>
					<td class="its-td"><?php $this->print_("securimage",$TPL_SCP,1);?></td>
				</tr>
<?php }?>
<?php if(!defined('__ISUSER__')){?>
				<tr class="board_detail_btns2">
					<td class="L Pb20">
						<span class="Bo">개인정보 수집 및 이용 (필수)</span>
						<textarea class="cs_policy_textarea Mt10" readonly><?php echo $TPL_VAR["policy"]?></textarea>
						<input type="hidden" name="agree" value="n" />
						<label class="Dib fright Pt10 gray_01"><input type="checkbox" class="agree_check"/> 개인정보 수집 및 이용에 동의합니다.</label> &nbsp; &nbsp;
					</td>
				</tr>
<?php }?>
				</tbody>
			</table>
<?php }?>
			</form>
		</div>
	</div>
	<div class="cmt_division v3">
		<table class="cmt_tbl" cellpadding="0" cellspacing="0" border="0" width="100%">
<?php if($TPL_VAR["cmtloop"]){?>
<?php if($TPL_cmtloop_1){foreach($TPL_VAR["cmtloop"] as $TPL_V1){?>
			<tr>
				<td class="cmt_area cmt_cont_head">
					<span class="iconhidden"><?php echo $TPL_V1["iconhidden"]?></span>
					<strong><?php echo $TPL_V1["name"]?></strong>
<?php if($TPL_V1["date"]){?><span class="desc">&nbsp; <?php if(getDateFormat($TPL_V1["r_date"],"Y-m-d")==date("Y-m-d")){?><?php echo date('H:i',strtotime($TPL_V1["date"]))?><?php }else{?><?php echo $TPL_V1["date"]?><?php }?></span><?php }?>
<?php if($TPL_V1["iconnew"]){?>
						<img src="/data/skin/responsive_sports_sporti_gl/board/<?php echo $TPL_VAR["templateskin"]?>/images/icon/icon_new.png" title="new" align="absmiddle" designImgSrcOri='e3RlbXBsYXRlc2tpbn0vaW1hZ2VzL2ljb24vaWNvbl9uZXcucG5n' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvYm9hcmQve3RlbXBsYXRlc2tpbn0vaW1hZ2VzL2ljb24vaWNvbl9uZXcucG5n' designElement='image' >
<?php }?>
				</td>
			</tr>
			<tr>
				<td class="cmt_area cmt_contents" style="font-weight:normal;">
					<div style="left:0;word-wrap:break-word;word-break:break-all;"><?php echo nl2br($TPL_V1["content"])?></div>
					<!-- 수정영역 -->
					<div id="mod_contents_<?php echo $TPL_V1["seq"]?>" class="Pt5 hide">
						<form name="cmtform_mod_<?php echo $TPL_V1["seq"]?>" id="cmtform_mod_<?php echo $TPL_V1["seq"]?>" method="post"  action="<?php echo sslAction('../board_comment_process')?>"  target="actionFrame">
<?php if($TPL_VAR["seq"]){?>
						<input type="hidden" name="p_seq" value="<?php echo $TPL_VAR["seq"]?>" />
						<input type="hidden" name="seq" class="board_seq" value="<?php echo $TPL_VAR["seq"]?>" />
						<input type="hidden" name="cmtseq" class="board_cmtseq" value="<?php echo $TPL_V1["seq"]?>" />
						<input type="hidden" name="board_id" class="board_id" value="<?php echo $TPL_VAR["manager"]["id"]?>" />
						<input type="hidden" name="mode" class="cmtmode" value="board_comment_modify" />
						<input type="hidden" name="viewtype" value="<?php echo $TPL_VAR["pagemode"]?>" />
						<input type="hidden" name="returnurl" class="cmtreturnurl" value="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_VAR["seq"]?>" />
<?php }?>
<?php if($TPL_VAR["managerview"]["isperm_write_cmt"]=="_no"){?>
						<div class="cmt_box center hand">로그인 또는 댓글권한이 있을 경우 등록하실 수 있습니다</div>
<?php }else{?>
						<table class="cmt_box" cellpadding="0" cellspacing="0">
							<tbody>
<?php if(defined('__ISUSER__')===true&&$TPL_VAR["user_name"]){?>
							<tr>
								<td class="its-td">
									<input type="hidden" name="name" class="cmtname required line" size="19" value="<?php echo $TPL_V1["real_name"]?>" />

									<input type="text" value="<?php echo $TPL_VAR["user_name"]?>"  readonly="readonly" class="required line" />
									<input type="hidden" name="pw" class="cmtpw required line pwchecklay" size="19" title="비밀번호" value="" />
									&nbsp;<span class="<?php echo $TPL_VAR["cmthiddenlay"]?>" ><label><input type="checkbox" name="hidden"  class="cmthidden"  value="1" <?php echo $TPL_VAR["cmthiddenckeck"]?> /> 비밀댓글</label></span>
								</td>
							</tr>
<?php }else{?>
							<tr>
								<td class="its-td">
									<input type="text" name="name" class="cmtname required line" size="19" title="이름" value="<?php echo $TPL_V1["real_name"]?>" />
									<a class="its-td pwchecklay <?php if(defined('__ISUSER__')===true){?>hide<?php }?> "><input type="password" name="pw" class="cmtpw required line " size="19" title="비밀번호" value="" /></a>
									&nbsp;<span class="<?php echo $TPL_VAR["cmthiddenlay"]?>" ><label><input type="checkbox" name="hidden"  class="cmthidden"  value="1" <?php echo $TPL_VAR["cmthiddenckeck"]?> /> 비밀댓글</label></span>
								</td>
							</tr>
<?php }?>
							<tr>
								<td class="its-td">
									<textarea name="content" class="size1 cmtcontent required line"><?php echo $TPL_V1["org_content"]?></textarea>
								</td>
							</tr>
							<tr>
								<td class="its-td" >
									<button type="button"  name="board_commentsend_mod" id="board_commentsend_mod" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" class="btn_resp size_b">댓글수정</button>
								</td>
							</tr>
<?php if($TPL_VAR["manager"]["autowrite_use"]=='Y'&&$TPL_VAR["captcha_image"]){?>
							<tr>
								<td class="its-td"><?php $this->print_("securimage",$TPL_SCP,1);?></td>
							</tr>
<?php }?>
							</tbody>
						</table>
<?php }?>
						</form>
					</div>
					<!-- 수정영역 END -->

<?php if($TPL_V1["isperm_hide"]!='hide'){?>
					<div class="pdt10">
						<span class="btn_resp size_a <?php echo $TPL_V1["isperm_hide"]?>" name="boad_cmt_reply_btn<?php echo $TPL_VAR["managerview"]["isperm_write_cmt"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>"  board_cmt_idx="<?php echo $TPL_V1["idx"]?>"  alt="답글쓰기" title="답글쓰기" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=" >답글</span>
						<span class="btn_resp size_a <?php echo $TPL_V1["isperm_hide"]?>" name="boad_cmt_modify_btn<?php echo $TPL_V1["isperm_moddel"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" alt="답글수정" title="답글수정" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=" >수정</span>
						<span class="btn_resp size_a <?php echo $TPL_V1["isperm_hide"]?>" name="boad_cmt_delete_btn<?php echo $TPL_V1["isperm_moddel"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" alt="답글삭제" title="답글삭제" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=" >삭제</span>
						<!-- 댓글평가 -->
<?php if($TPL_VAR["managerview"]["auth_cmt_recommend_use"]=='Y'){?>
						<span class="scorelay">
<?php if($TPL_VAR["managerview"]["cmt_recommend_type"]=='2'){?>
<?php if($TPL_VAR["managerview"]["icon_cmt_recommend_src"]&&$TPL_VAR["managerview"]["icon_cmt_none_rec_src"]){?>
								<span style="width:50px;margin:auto;border:0px dashed black;padding:5px;">
									<span class=" icon_cmt_recommend_<?php echo $TPL_VAR["seq"]?>_<?php echo $TPL_V1["seq"]?>_lay<?php echo $TPL_V1["is_cmt_recommend"]?> icon_cmt_recommend_lay<?php echo $TPL_V1["is_cmt_recommend"]?> hand " board_recommend="recommend"  board_cmt_seq="<?php echo $TPL_V1["seq"]?>"  board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_cmt_recommend_src"]?>" class="icon_cmt_recommend_img" designImgSrcOri='e21hbmFnZXJ2aWV3Lmljb25fY210X3JlY29tbWVuZF9zcmN9' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=' designImgSrc='e21hbmFnZXJ2aWV3Lmljb25fY210X3JlY29tbWVuZF9zcmN9' designElement='image' /></span>
									<span class=" idx-cmt-recommend-<?php echo $TPL_VAR["seq"]?>-<?php echo $TPL_V1["seq"]?> "><?php echo number_format($TPL_V1["recommend"])?></span>
									<span class=" icon_cmt_none_rec_<?php echo $TPL_VAR["seq"]?>_<?php echo $TPL_V1["seq"]?>_lay<?php echo $TPL_V1["is_cmt_recommend"]?>  icon_cmt_none_rec_lay<?php echo $TPL_V1["is_cmt_recommend"]?> hand" board_recommend="none_rec"  board_cmt_seq="<?php echo $TPL_V1["seq"]?>"  board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_cmt_none_rec_src"]?>"  class="icon_cmt_none_rec_img"  designImgSrcOri='e21hbmFnZXJ2aWV3Lmljb25fY210X25vbmVfcmVjX3NyY30=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=' designImgSrc='e21hbmFnZXJ2aWV3Lmljb25fY210X25vbmVfcmVjX3NyY30=' designElement='image' /></span>
									<span class=" idx-cmt-none_rec-<?php echo $TPL_VAR["seq"]?>-<?php echo $TPL_V1["seq"]?>"><?php echo number_format($TPL_V1["none_rec"])?></span>
								</span>
<?php }?>
<?php }elseif($TPL_VAR["managerview"]["cmt_recommend_type"]=='1'){?>
<?php if($TPL_VAR["managerview"]["icon_cmt_recommend_src"]){?>
								<span style="width:50px;margin:auto;border:0px dashed black;padding:5px;">
									<span class="icon_cmt_recommend_<?php echo $TPL_VAR["seq"]?>_<?php echo $TPL_V1["seq"]?>_lay<?php echo $TPL_V1["is_cmt_recommend"]?> icon_cmt_recommend_lay<?php echo $TPL_V1["is_cmt_recommend"]?> hand  " board_recommend="recommend"  board_cmt_seq="<?php echo $TPL_V1["seq"]?>"  board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_cmt_recommend_src"]?>" class="icon_cmt_recommend_img" designImgSrcOri='e21hbmFnZXJ2aWV3Lmljb25fY210X3JlY29tbWVuZF9zcmN9' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=' designImgSrc='e21hbmFnZXJ2aWV3Lmljb25fY210X3JlY29tbWVuZF9zcmN9' designElement='image' /></span>
									<span class=" idx-cmt-recommend-<?php echo $TPL_VAR["seq"]?>-<?php echo $TPL_V1["seq"]?>"><?php echo number_format($TPL_V1["recommend"])?></span>
								</span>
<?php }?>
<?php }?>
						</span>
<?php }?>
					</div>
<?php }?>

				</td>
			</tr>
			<!-- 답글영역 -->
			<tr class=" hide cmtreplylay cmtreplyform<?php echo $TPL_V1["seq"]?> ">
				<td id="cmtreplyform<?php echo $TPL_V1["seq"]?>">
					<div class="wbox">
<?php if($TPL_VAR["managerview"]["isperm_write_cmt"]=="_no"){?>
							<div class="cmt_box center hand">로그인 또는 댓글권한이 있을 경우 등록하실 수 있습니다</div>
<?php }else{?>
							<table class="cmt_box" cellpadding="0" cellspacing="0">
								<thead class="hide">
								<tr>
									<th class="its-th-align center" >댓글쓰기</th>
								</tr>
								</thead>
								<tbody>
<?php if(defined('__ISUSER__')===true&&($TPL_VAR["user_name"])){?>
									<tr>
										<td class="its-td"><input type="hidden" name="name" id="cmtname<?php echo $TPL_V1["seq"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>"  value="<?php echo $TPL_VAR["user_name"]?>"  /><input type="text" value="<?php echo $TPL_VAR["user_name"]?>"  readonly="readonly"  class="required line" />
										<a class="  pwchecklay <?php if(defined('__ISUSER__')===true){?>hide<?php }?>"><input type="password"  password="password" name="pw" board_cmt_seq="<?php echo $TPL_V1["seq"]?>"id="cmtpw<?php echo $TPL_V1["seq"]?>" class="required line"  size="25" title="비밀번호" value="" /></a>
										&nbsp;<span class="<?php echo $TPL_VAR["cmthiddenlay"]?>" ><label > <input type="checkbox" name="hidden"  id="cmthidden<?php echo $TPL_V1["seq"]?>"   value="1" <?php echo $TPL_VAR["hiddenckeck"]?> /> 비밀답글</label></span>
										</td>
									</tr>
<?php }else{?>
									<tr>
										<td class="its-td"><input type="text" name="name" id="cmtname<?php echo $TPL_V1["seq"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" class="required line" size="20" title="이름" value="<?php echo $TPL_VAR["user_name"]?>" />
										<a class="  pwchecklay <?php if(defined('__ISUSER__')===true){?>hide<?php }?>"><input type="password"  password="password" name="pw" board_cmt_seq="<?php echo $TPL_V1["seq"]?>"id="cmtpw<?php echo $TPL_V1["seq"]?>" class="required line "  size="20" title="비밀번호" value="" /></a>
										&nbsp;<span class="<?php echo $TPL_VAR["cmthiddenlay"]?>" ><label > <input type="checkbox" name="hidden"  id="cmthidden<?php echo $TPL_V1["seq"]?>"   value="1" <?php echo $TPL_VAR["hiddenckeck"]?> /> 비밀답글</label></span>
										</td>
									</tr>
<?php }?>
									<tr>
										<td  class="its-td"><textarea name="content" id="cmtcontent<?php echo $TPL_V1["seq"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" class="size1 required line" title="<?php if($TPL_VAR["managerview"]["isperm_write_cmt"]=="_no"){?>로그인 후 이용해 주세요!<?php }else{?>답글을 입력해 주세요.<?php }?>" title=" "></textarea></td>
									</tr>
									<tr>
										<td class="its-td">
										<button type="button"  name="board_commentsend_reply" id="board_commentsend_reply<?php echo $TPL_V1["seq"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>"  board_cmt_reply_seq=""  board_cmt_idx="<?php echo $TPL_V1["idx"]?>" class="btn_resp size_b">답글등록</button>
										<!-- <button  type="reset" name="board_comment_reply_cancel" id="board_comment_reply_cancel<?php echo $TPL_V1["seq"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" board_cmt_reply_seq=""  board_cmt_idx="<?php echo $TPL_V1["idx"]?>" class="round_btn">답글취소</button> -->
									</td>
									</tr>

<?php if($TPL_VAR["manager"]["autowrite_use"]=='Y'&&$TPL_VAR["captcha_image"]){?>
									<tr>
										<td class="its-td"><?php $this->print_("securimage",$TPL_SCP,1);?></td>
									</tr>
<?php }?>

<?php if(!defined('__ISUSER__')){?>
									<tr class="board_detail_btns2">
										<td class="L Pb20">
											<span class="Bo">개인정보 수집 및 이용 (필수)</span>
											<textarea class="cs_policy_textarea Mt10" readonly><?php echo $TPL_VAR["policy"]?></textarea>
											<input type="hidden" name="agree" id="cmtagree<?php echo $TPL_V1["seq"]?>" value="n" />
											<label class="Dib fright Pt10 gray_01"><input type="checkbox" class="agree_check"/> 개인정보 수집 및 이용에 동의합니다.</label> &nbsp; &nbsp;
										</td>
									</tr>
<?php }?>
								</tbody>
							</table>
<?php }?>
					</div>
				</td>
			</tr>
			<!-- 답글영역 END -->

				<!-- 댓글의 댓글 -->
<?php if($TPL_V1["cmtreplyloop"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["cmtreplyloop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<tr>
						<td class="cmt_area cmt_cont_head cmt_reply" >
						<img src="/data/skin/responsive_sports_sporti_gl/board/<?php echo $TPL_VAR["templateskin"]?>/images/board/icon/icon_comment_reply.gif"  title="답변" alt="답변" designImgSrcOri='e3RlbXBsYXRlc2tpbn0vaW1hZ2VzL2JvYXJkL2ljb24vaWNvbl9jb21tZW50X3JlcGx5LmdpZg==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvYm9hcmQve3RlbXBsYXRlc2tpbn0vaW1hZ2VzL2JvYXJkL2ljb24vaWNvbl9jb21tZW50X3JlcGx5LmdpZg==' designElement='image' >
						<span class="iconhidden"><?php echo $TPL_V2["iconhidden"]?></span><strong class="name"><?php echo $TPL_V2["name"]?></strong>
<?php if($TPL_V2["date"]){?><span class="desc">&nbsp;  <?php if(getDateFormat($TPL_V2["r_date"],"Y-m-d")==date("Y-m-d")){?><?php echo date('H:i',strtotime($TPL_V2["date"]))?><?php }else{?><?php echo $TPL_V2["date"]?><?php }?></span><?php }?>
<?php if($TPL_V2["iconnew"]){?>
								<img src="/data/skin/responsive_sports_sporti_gl/board/<?php echo $TPL_VAR["templateskin"]?>/images/icon/icon_new.png" title="new" align="absmiddle" designImgSrcOri='e3RlbXBsYXRlc2tpbn0vaW1hZ2VzL2ljb24vaWNvbl9uZXcucG5n' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvYm9hcmQve3RlbXBsYXRlc2tpbn0vaW1hZ2VzL2ljb24vaWNvbl9uZXcucG5n' designElement='image' >
<?php }?>
						</td>
					</tr>
					<tr>
						<td class="cmt_area cmt_reply cmt_contents" colspan="2">
							<div style="left:0;word-wrap:break-word;word-break:break-all;"><?php echo nl2br($TPL_V2["content"])?></div>
							<!-- 답글수정영역 -->
							<div class=" hide cmtreplyform<?php echo $TPL_V2["seq"]?> ">
								<div id="cmtreplyform<?php echo $TPL_V2["seq"]?>" class="Pt5" >
									<div >
<?php if($TPL_VAR["managerview"]["isperm_write_cmt"]=="_no"){?>
											<div class="cmt_box center hand">로그인 또는 댓글권한이 있을 경우 등록하실 수 있습니다</div>
<?php }else{?>
										<form >
											<table class="cmt_box" cellpadding="0" cellspacing="0">
												<thead class="hide">
												<tr>
													<th class="its-th-align center" >답글쓰기</th>
												</tr>
												</thead>
												<tbody>
<?php if(defined('__ISUSER__')===true&&($TPL_VAR["user_name"])){?>
													<tr>
														<td class="its-td">
															<input type="hidden" name="name" id="cmtname<?php echo $TPL_V2["seq"]?>" board_cmt_seq="<?php echo $TPL_V2["seq"]?>"  value="<?php echo $TPL_VAR["user_name"]?>"  />
															<input type="text" value="<?php echo $TPL_VAR["user_name"]?>"  readonly="readonly"  class="required line" />
															<a class="pwchecklay <?php if(defined('__ISUSER__')===true){?>hide<?php }?>"><input type="password"  password="password" name="pw" board_cmt_seq="<?php echo $TPL_V2["seq"]?>"id="cmtpw<?php echo $TPL_V2["seq"]?>" class="required line"  size="15" title="비밀번호" value="" /></a>
															&nbsp;<span class="<?php echo $TPL_VAR["cmthiddenlay"]?>" ><label > <input type="checkbox" name="hidden"  id="cmthidden<?php echo $TPL_V2["seq"]?>"   value="1" <?php echo $TPL_VAR["hiddenckeck"]?> /> 비밀답글</label></span>
														</td>
													</tr>
<?php }else{?>
													<tr>
														<td class="its-td"><input type="text" name="name" id="cmtname<?php echo $TPL_V2["seq"]?>" board_cmt_seq="<?php echo $TPL_V2["seq"]?>" class="required line" size="15" title="이름" value="<?php echo $TPL_VAR["user_name"]?>" />
														<a class="  pwchecklay <?php if(defined('__ISUSER__')===true){?>hide<?php }?>"><input type="password"  password="password" name="pw" board_cmt_seq="<?php echo $TPL_V2["seq"]?>"id="cmtpw<?php echo $TPL_V2["seq"]?>" class="required line"  size="15" title="비밀번호" value="" /></a>
														&nbsp;<span class="<?php echo $TPL_VAR["cmthiddenlay"]?>" ><label > <input type="checkbox" name="hidden"  id="cmthidden<?php echo $TPL_V2["seq"]?>"   value="1" <?php echo $TPL_VAR["hiddenckeck"]?> /> 비밀답글</label></span>
														</td>
													</tr>
<?php }?>
													<tr>
														<td  class="its-td"><textarea name="content" id="cmtcontent<?php echo $TPL_V2["seq"]?>" board_cmt_seq="<?php echo $TPL_V2["seq"]?>" class="size1 required line" title="<?php if($TPL_VAR["managerview"]["isperm_write_cmt"]=="_no"){?>로그인 후 이용해 주세요!<?php }else{?>답글을 입력해 주세요.<?php }?>" title=" "></textarea></td>
													</tr>
													<tr>
														<td class="its-td">
														<button type="button" name="board_commentsend_reply" id="board_commentsend_reply<?php echo $TPL_V2["seq"]?>" board_cmt_seq="<?php echo $TPL_V2["seq"]?>"  board_cmt_reply_seq=""  board_cmt_idx="<?php echo $TPL_V2["idx"]?>" class="round_btn">답글수정</button>
														</td>
													</tr>
<?php if($TPL_VAR["manager"]["autowrite_use"]=='Y'&&$TPL_VAR["captcha_image"]){?>
													<tr>
														<td class="its-td"><?php $this->print_("securimage",$TPL_SCP,1);?></td>
													</tr>
<?php }?>
												</tbody>
											</table>
										</form>
<?php }?>
									</div>
								</div>
							</div>
							<!-- 답글수정영역 END -->
							<div class="pdt10">
<?php if($TPL_V2["isperm_hide"]!='hide'){?>
								<span class="btn_resp size_a <?php echo $TPL_V2["isperm_hide"]?>" name="boad_cmt_modify_reply_btn<?php echo $TPL_V2["isperm_moddel"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" board_cmt_reply_seq="<?php echo $TPL_V2["seq"]?>"  alt="답글수정" title="답글수정" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=" >수정</span>
								<span class="btn_resp size_a <?php echo $TPL_V2["isperm_hide"]?>" name="boad_cmt_delete_reply_btn<?php echo $TPL_V2["isperm_moddel"]?>" board_cmt_seq="<?php echo $TPL_V1["seq"]?>" board_cmt_reply_seq="<?php echo $TPL_V2["seq"]?>"  alt="답글삭제" title="답글삭제" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=" >삭제</span>
<?php }?>
								<!-- 댓글평가 -->
<?php if($TPL_VAR["managerview"]["auth_cmt_recommend_use"]=='Y'){?>
								<span class="scorelay">
<?php if($TPL_VAR["managerview"]["cmt_recommend_type"]=='2'){?>
<?php if($TPL_VAR["managerview"]["icon_cmt_recommend_src"]&&$TPL_VAR["managerview"]["icon_cmt_none_rec_src"]){?>
										<span style="width:50px;margin:auto;border:0px dashed black;padding:5px;">
											<span class=" icon_cmt_recommend_<?php echo $TPL_VAR["seq"]?>_<?php echo $TPL_V2["seq"]?>_lay<?php echo $TPL_V2["is_cmt_recommend"]?> icon_cmt_recommend_lay<?php echo $TPL_V2["is_cmt_recommend"]?> hand " board_recommend="recommend"  board_cmt_seq="<?php echo $TPL_V2["seq"]?>"  board_seq="<?php echo $TPL_VAR["seq"]?>"  board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_cmt_recommend_src"]?>" class="icon_cmt_recommend_img" designImgSrcOri='e21hbmFnZXJ2aWV3Lmljb25fY210X3JlY29tbWVuZF9zcmN9' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=' designImgSrc='e21hbmFnZXJ2aWV3Lmljb25fY210X3JlY29tbWVuZF9zcmN9' designElement='image' /></span>
											<span class=" idx-cmt-recommend-<?php echo $TPL_VAR["seq"]?>-<?php echo $TPL_V2["seq"]?> "><?php echo number_format($TPL_V2["recommend"])?></span>
											<span class=" icon_cmt_none_rec_<?php echo $TPL_VAR["seq"]?>_<?php echo $TPL_V2["seq"]?>_lay<?php echo $TPL_V2["is_cmt_recommend"]?>  icon_cmt_none_rec_lay<?php echo $TPL_V2["is_cmt_recommend"]?> hand" board_recommend="none_rec"  board_cmt_seq="<?php echo $TPL_V2["seq"]?>"  board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_cmt_none_rec_src"]?>"  class="icon_cmt_none_rec_img"  designImgSrcOri='e21hbmFnZXJ2aWV3Lmljb25fY210X25vbmVfcmVjX3NyY30=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=' designImgSrc='e21hbmFnZXJ2aWV3Lmljb25fY210X25vbmVfcmVjX3NyY30=' designElement='image' /></span>
											<span class=" idx-cmt-none_rec-<?php echo $TPL_VAR["seq"]?>-<?php echo $TPL_V2["seq"]?>"><?php echo number_format($TPL_V2["none_rec"])?></span>
										</span>
<?php }?>
<?php }elseif($TPL_VAR["managerview"]["cmt_recommend_type"]=='1'){?>
<?php if($TPL_VAR["managerview"]["icon_cmt_recommend_src"]){?>
										<span style="width:50px;margin:auto;border:0px dashed black;padding:5px;">
											<span class="icon_cmt_recommend_<?php echo $TPL_VAR["seq"]?>_<?php echo $TPL_V2["seq"]?>_lay<?php echo $TPL_V2["is_cmt_recommend"]?> icon_cmt_recommend_lay<?php echo $TPL_V2["is_cmt_recommend"]?> hand  " board_recommend="recommend"  board_cmt_seq="<?php echo $TPL_V2["seq"]?>"  board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" ><img src="<?php echo $TPL_VAR["managerview"]["icon_cmt_recommend_src"]?>" class="icon_cmt_recommend_img" designImgSrcOri='e21hbmFnZXJ2aWV3Lmljb25fY210X3JlY29tbWVuZF9zcmN9' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JvYXJkL19jb21tZW50Lmh0bWw=' designImgSrc='e21hbmFnZXJ2aWV3Lmljb25fY210X3JlY29tbWVuZF9zcmN9' designElement='image' /></span>
											<span class=" idx-cmt-recommend-<?php echo $TPL_VAR["seq"]?>-<?php echo $TPL_V2["seq"]?>"><?php echo number_format($TPL_V2["recommend"])?></span>
										</span>
<?php }?>
<?php }?>
								</span>
<?php }?>
							</div>
						</td>
					</tr>
<?php }}?>
<?php }?>
<?php }}?>
<?php }else{?>
			<!--div style="text-align:center; padding-top:40px;">등록된 댓글이 없습니다.</div-->
<?php }?>
		</table>
	</div>
<!-- 페이징 --><div id="cmtpager" align="center"  class="paging_navigation" ><?php echo $TPL_VAR["cmtpagin"]?></div><!-- 페이징 -->
<iframe name="commentactionFrame" src="" frameborder="0" width="0" height="0" class="hide"></iframe>


<script type="text/javascript">
$(document).ready(function(){
	// 페이징 개수가 1개일때 노출 X
	var pagingTotalNum = $('#cmtpager a').length;
	if ( pagingTotalNum < 2 ) {
		$('#cmtpager').hide();
	}

	$('input[type="checkbox"]').ezMark({
		checkedCls: 'ez-checkbox-on'
	});
});
</script>