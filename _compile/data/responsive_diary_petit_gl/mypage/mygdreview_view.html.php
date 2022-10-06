<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/mygdreview_view.html 000019788 */  $this->include_("sslAction","snslinkurl");
$TPL_reviewcategorylist_1=empty($TPL_VAR["reviewcategorylist"])||!is_array($TPL_VAR["reviewcategorylist"])?0:count($TPL_VAR["reviewcategorylist"]);
$TPL_goodsreview_sub_1=empty($TPL_VAR["goodsreview_sub"])||!is_array($TPL_VAR["goodsreview_sub"])?0:count($TPL_VAR["goodsreview_sub"]);
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 나의 상품 후기 View @@
- 파일위치 : [스킨폴더]/mypage/mygdreview_view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript">
	//<![CDATA[
	var pagemode = '';
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
<script type="text/javascript" src="/app/javascript/js/board_comment_mobile.js?v=2"  charset="utf-8"></script>
<?php }?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" ></script>
<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"  charset="utf-8"></script>

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
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvbXlnZHJldmlld192aWV3Lmh0bWw=" >나의 상품 후기</span></h2>
		</div>

		<div class="mypage_greeting">
<?php if($TPL_VAR["reserves"]["autoemoney"]== 1&&$TPL_VAR["reserves"]["autoemoneytype"]!= 3&&$TPL_VAR["reserves"]["autoemoneytitle"]){?>구매자(회원)가 작성한<br /><?php }?>
<?php if($TPL_VAR["reserves"]["autoemoney_video"]> 0||$TPL_VAR["reserves"]["autopoint_video"]> 0){?><strong>동영상 상품후기</strong>는
<?php if($TPL_VAR["reserves"]["autoemoneytype"]!= 1&&($TPL_VAR["reserves"]["autoemoneystrcut1"]> 0||$TPL_VAR["reserves"]["autoemoneystrcut2"]> 0)){?>
					<span>(
<?php if($TPL_VAR["reserves"]["autoemoneytype"]== 2&&$TPL_VAR["reserves"]["autoemoneystrcut1"]> 0){?>
						<?php echo number_format($TPL_VAR["reserves"]["autoemoneystrcut1"])?>

<?php }elseif($TPL_VAR["reserves"]["autoemoneytype"]== 3&&$TPL_VAR["reserves"]["autoemoneystrcut2"]> 0){?>
						<?php echo number_format($TPL_VAR["reserves"]["autoemoneystrcut2"])?>

<?php }?>자 이상)</span>
<?php }?>
<?php if($TPL_VAR["reserves"]["autoemoney_video"]> 0){?>마일리지 <strong class="pointcolor2"><?php echo number_format($TPL_VAR["reserves"]["autoemoney_video"])?></strong>원<?php }?>
<?php if($TPL_VAR["reserves"]["autopoint_video"]> 0){?>, 포인트 <strong class="pointcolor2"><?php echo number_format($TPL_VAR["reserves"]["autopoint_video"])?></strong>P<?php }?>
				지급.<br />
<?php }?>

<?php if($TPL_VAR["reserves"]["autoemoney_photo"]> 0||$TPL_VAR["reserves"]["autopoint_photo"]> 0){?><strong>포토 상품후기</strong>는
<?php if($TPL_VAR["reserves"]["autoemoneytype"]!= 1&&($TPL_VAR["reserves"]["autoemoneystrcut1"]> 0||$TPL_VAR["reserves"]["autoemoneystrcut2"]> 0)){?>
					<span >(
<?php if($TPL_VAR["reserves"]["autoemoneytype"]== 2&&$TPL_VAR["reserves"]["autoemoneystrcut1"]> 0){?>
						<?php echo number_format($TPL_VAR["reserves"]["autoemoneystrcut1"])?>

<?php }elseif($TPL_VAR["reserves"]["autoemoneytype"]== 3&&$TPL_VAR["reserves"]["autoemoneystrcut2"]> 0){?>
						<?php echo number_format($TPL_VAR["reserves"]["autoemoneystrcut2"])?>

<?php }?>자 이상)</span>
<?php }?>
<?php if($TPL_VAR["reserves"]["autoemoney_photo"]> 0){?>마일리지 <strong class="pointcolor2"><?php echo number_format($TPL_VAR["reserves"]["autoemoney_photo"])?></strong>원<?php }?>
<?php if($TPL_VAR["reserves"]["autopoint_photo"]> 0){?>, 포인트 <strong class="pointcolor2"><?php echo number_format($TPL_VAR["reserves"]["autopoint_photo"])?></strong>P<?php }?>
				지급.<br />
<?php }?>

<?php if($TPL_VAR["reserves"]["autoemoney_review"]> 0||$TPL_VAR["reserves"]["autopoint_review"]> 0){?><strong>일반 상품후기</strong>는
<?php if($TPL_VAR["reserves"]["autoemoneytype"]!= 1&&($TPL_VAR["reserves"]["autoemoneystrcut1"]> 0||$TPL_VAR["reserves"]["autoemoneystrcut2"]> 0)){?>
					<span >(
<?php if($TPL_VAR["reserves"]["autoemoneytype"]== 2&&$TPL_VAR["reserves"]["autoemoneystrcut1"]> 0){?>
						<?php echo number_format($TPL_VAR["reserves"]["autoemoneystrcut1"])?>

<?php }elseif($TPL_VAR["reserves"]["autoemoneytype"]== 3&&$TPL_VAR["reserves"]["autoemoneystrcut2"]> 0){?>
						<?php echo number_format($TPL_VAR["reserves"]["autoemoneystrcut2"])?>

<?php }?>자 이상)</span>
<?php }?>
<?php if($TPL_VAR["reserves"]["autoemoney_review"]> 0){?>마일리지 <strong class="pointcolor2"><?php echo number_format($TPL_VAR["reserves"]["autoemoney_review"])?></strong>원<?php }?>
<?php if($TPL_VAR["reserves"]["autopoint_review"]> 0){?>, 포인트 <strong class="pointcolor2"><?php echo number_format($TPL_VAR["reserves"]["autopoint_review"])?></strong>P<?php }?>
				지급.<br />
<?php }?>
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

			<div class="board_detail_title Mt20">
<?php if($TPL_VAR["datacategory"]){?>[<?php echo $TPL_VAR["datacategory"]?>]<?php }?> <?php echo $TPL_VAR["iconmobile"]?><?php echo $TPL_VAR["iconaward"]?> <?php echo $TPL_VAR["subject"]?> <?php echo $TPL_VAR["iconnew"]?> <?php echo $TPL_VAR["iconhot"]?> <?php echo $TPL_VAR["iconhidden"]?>

			</div>
			<table class="table_row_a Thc" data-responsive="yes" width="100%" cellpadding="0" cellspacing="0">
				<colgroup><col class="size_b"><col><col class="size_b"><col></colgroup>
				<tbody>
					<tr>
						<th><p>작성자</p></th>
						<td><?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><?php echo $TPL_VAR["name"]?><?php }?></td>
						<th><p>등록일</p></th>
						<td><?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><?php echo $TPL_VAR["r_date"]?><?php }?></td>
					</tr>
					<tr>
						<th><p>조회수</p></th>
						<td><?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><?php echo number_format($TPL_VAR["hit"])?><?php }?></td>
						<th><p>구매여부</p></th>
						<td><?php if(strstr($TPL_VAR["manager"]["list_show"],'[order_seq]')){?><?php echo $TPL_VAR["buyertitle"]?><?php }?></td>
					</tr>
					<tr>
						<th><p>평점</p></th>
						<td colspan="3">
							<?php echo $TPL_VAR["scorelay"]?><?php if($TPL_VAR["score_avg_lay"]){?>/100<?php }?>
<?php if($TPL_VAR["reviewcategorylist"]){?>,&nbsp;&nbsp;
<?php if($TPL_reviewcategorylist_1){$TPL_I1=-1;foreach($TPL_VAR["reviewcategorylist"] as $TPL_V1){$TPL_I1++;?>
									<?php echo $TPL_V1["title"]?> <?php if($TPL_V1["score"]){?><?php echo getGoodsScore($TPL_V1["score"],$TPL_VAR["manager"],'view',$TPL_V1["idx"])?> <?php }else{?> 0 <?php }?>
<?php if(count($TPL_VAR["reviewcategorylist"])- 1>$TPL_I1){?>,&nbsp;&nbsp;<?php }?>
<?php }}?>
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
<?php if($TPL_VAR["filelist"]){?>
					<tr>
						<th><p>첨부파일</p></th>
						<td colspan="3">
							<ul>
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
								<li>
									<span class="realfilelist hand highlight-link" realfiledir="<?php echo $TPL_V1["realfiledir"]?>" realfilename="<?php echo $TPL_V1["orignfile"]?>"  realfilename="<?php echo $TPL_V1["orignfile"]?>" board_id="goods_qna" filedown="../board_process?mode=board_file_down&board_id=goods_qna&realfiledir=<?php echo $TPL_V1["realfiledir"]?>&realfilename=<?php echo $TPL_V1["orignfile"]?>"><?php echo $TPL_V1["orignfile"]?> (<span class="size"><?php echo $TPL_V1["realsizefile"]?></span>) <button type="button"  class="bbs_btn">down</button></span>
<?php if($TPL_V1["is_image"]){?>
										<span class="hand" imgsrc="<?php echo $TPL_V1["realfile"]?>" onclick="board_file_review('<?php echo $TPL_V1["realfileurl"]?>','<?php echo $TPL_V1["imagesize"][ 0]?>','<?php echo $TPL_V1["imagesize"][ 1]?>');" ><img src="/data/skin/responsive_diary_petit_gl/images/icon/icon_zoom.gif" hspace="1" title="미리보기"/></span>
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

<?php if($TPL_VAR["goodsview"]){?>
			<div class="goods_origin_info">
				<h4 class="title">상품 정보</h4>
				<?php echo $TPL_VAR["goodsview"]?>

			</div>
<?php }?>
			
			<div class="board_sns_link">
				<?php echo snslinkurl('board',$TPL_VAR["subject"])?>

			</div>
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
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"){?>
				<button type="button" name="goods_boad_modify_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>" board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b">수정</button>
<?php }?>
<?php if((($TPL_VAR["display"]== 0||($TPL_VAR["display"]== 1&&$TPL_VAR["replyor"]== 0&&$TPL_VAR["comment"]== 0)))&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"){?> 
				<button type="button"  name="goods_boad_delete_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>"  board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>"  class="btn_resp size_b">삭제 </button>
<?php }?>
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["replylay"]=='Y'&&$TPL_VAR["managerview"]["isperm_write"]!="_no"){?> 
				<button type="button"  id="goods_boad_reply_btn" board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b">답변</button>
<?php }?>
<?php if($TPL_VAR["managerview"]["isperm_write"]!="_no"){?>
				<button type="button" id="goods_boad_write_btn<?php echo $TPL_VAR["managerview"]["isperm_write"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b color2"><?php echo $TPL_VAR["manager"]["name"]?>  쓰기</button>
<?php }?>
		</ul>
		<!-- //버튼 -->

		<div id="CmtBoardPwCk" class="hide BoardPwCk">
			<div class="msg">
				<h3> 비밀번호 확인</h3>
				<div>댓글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
			</div>
			<form name="CmtBoardPwcheckForm" id="CmtBoardPwcheckForm" method="post"  target="actionFrame" >
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
				<div>게시글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
			</div>
			<form name="ModDelBoardPwcheckForm" id="ModDelBoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame" >
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
		<div id="BoardPwCk" class="hide BoardPwCk">
			<div class="msg">
				<h3> 비밀번호 확인</h3>
				<div>게시글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
			</div>
			<form name="BoardPwcheckForm" id="BoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame" >
			<input type="hidden" name="seq" id="pwck_seq" value="" />
			<input type="hidden" name="returnurl" id="pwck_returnurl" value="" />
			<div class="ibox">
				<input type="password" name="pw" id="pwck_pw" class="input" />
				<input type="submit" id="BoardPwcheckBtn" value=" 확인 " class="btnblue" />
				<input type="button" value=" 취소 " class="btngray" onclick="$('#BoardPwCk').dialog('close');" />
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

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->


<script type="text/javascript">
function getboardLogin(){
<?php if(defined('__ISUSER__')===true){?>
		//해당 서비스를 이용하시려면 관리자에게 문의하여 주시길 바랍니다.
		openDialogAlert(getAlert('mp110'),'450','140');
<?php }else{?>
		var returnurl = encodeURIComponent('/goods/view?no=<?php echo $_GET["goods_seq"]?>#goods_review');
		//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
		openDialogConfirm(getAlert('mp111'),'400','155',function(){top.location.href="/member/login?return_url="+returnurl;},function(){});
<?php }?>
}

function getcmtMbLogin(){
<?php if(defined('__ISUSER__')===true){?>
		//글작성자만 이용가능합니다.
		openDialogAlert(getAlert('mp112'),'400','140');
<?php }else{?>
	  var returnurl = encodeURIComponent('/goods/view?no=<?php echo $_GET["goods_seq"]?>#goods_review');
	  //이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
	  openDialogConfirm(getAlert('mp111'),'400','155',function(){top.location.href="/member/login?return_url="+returnurl;},function(){});
<?php }?>
}

$(".content img").load(function() {
	//이미지 가로가 큰경우
	$(".content img").each(function() {
<?php if($TPL_VAR["layout_config"]["layoutScrollLeft"]!='hidden'||$TPL_VAR["layout_config"]["layoutScrollRight"]!='hidden'){?>
			var default_width = '<?php echo $TPL_VAR["layout_config"]["body_width"]- 150?>';//(본문레이아웃사이즈-100) 또는 직접값변경
<?php }else{?>
			var default_width = '<?php echo $TPL_VAR["layout_config"]["body_width"]- 100?>';//(본문레이아웃사이즈-50) 또는 직접값변경
<?php }?>
		if( $(this).width() > default_width || $(this).height() > default_width ) {
			imageResize(this,default_width);
		}
	});
});

$(document).ready(function(){
	$(document).resize(function(){iframeset();}).resize();
	setInterval(function(){iframeset();},1000);
});
function iframeset(){
	  $('#'+board_id+'_frame',parent.document).height($('#boardlayout').height()+100);
}
</script>