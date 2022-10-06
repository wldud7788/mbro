<?php /* Template_ 2.2.6 2020/10/15 17:39:14 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/board/mbqna/_mbqna/index.html 000012091 */  $this->include_("sslAction");
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_noticeloop_1=empty($TPL_VAR["noticeloop"])||!is_array($TPL_VAR["noticeloop"])?0:count($TPL_VAR["noticeloop"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php if($TPL_VAR["viewlist"]!='view'){?>
<div class="sub_title_bar">
	<h2><?php echo $TPL_VAR["manager"]["name"]?></a></h2>
	<a href="javascript:history.back();" class="stb_back_btn" hrefOri='amF2YXNjcmlwdDpoaXN0b3J5LmJhY2soKTs=' ><img src="/data/skin/responsive_diary_petit_gl/images/design/btn_back.png" designImgSrcOri='Li4vLi4vLi4vaW1hZ2VzL2Rlc2lnbi9idG5fYmFjay5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9tYnFuYS9fbWJxbmEvaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9kZXNpZ24vYnRuX2JhY2sucG5n' designElement='image' /></a>
</div>

<div class="bbstopbox">
	<div class="pright">
<?php if($TPL_VAR["manager"]["auth_write"]!='[admin]'){?>
		<span id="boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" fileperm_read="<?php echo $TPL_VAR["manager"]["fileperm_write"]?>" class="btn_style black hand">글쓰기</span>
<?php }?>
		<span class="btn_style black hand boad_search_btn_m" >검색 ▼</span>
	</div>
</div>
<?php if(!$_GET["search_text"]){?><script>$('.boad_search_btn_m').click();</script><?php }?>
<div class="pdb5">
	<div class="bbssearchbox" <?php if(!$_GET["search_text"]){?>style="display:none"<?php }?>>
		<form name="boardsearch" id="boardsearch" >
		<input type="hidden" name="id" value="<?php echo $_GET["id"]?>" >
		<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>" >
		<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>" >
		<input type="hidden" name="goods_seq" value="<?php echo $_GET["goods_seq"]?>" >
		<input type="hidden" name="perpage" id="perpage" value="<?php echo $_GET["perpage"]?>" >
		<input type="hidden" name="page" id="page" value="<?php echo $_GET["page"]?>" >
		<input type="hidden" name="category" id="category" value="<?php echo $_GET["category"]?>" >
		<input type="text" name="search_text" id="search_text" value="<?php echo $_GET["search_text"]?>" title="이 게시판 검색" /><input type="image" src="/data/skin/responsive_diary_petit_gl/images/design/btn_search_s.png" designImgSrcOri='Li4vLi4vLi4vaW1hZ2VzL2Rlc2lnbi9idG5fc2VhcmNoX3MucG5n' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9tYnFuYS9fbWJxbmEvaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9kZXNpZ24vYnRuX3NlYXJjaF9zLnBuZw==' designElement='image' />
		</form>
	</div>
</div>
<?php }?>

<?php if($TPL_VAR["categorylist"]){?>
<div class="bbstopbox"> <select  name="category" id="searchcategory" class="required common-select styled"  >
	<option value="" selected="selected" >- 분류선택 -</option>
<?php if($TPL_categorylist_1){foreach($TPL_VAR["categorylist"] as $TPL_V1){?>
	<option value="<?php echo $TPL_V1?>" <?php if($_GET["category"]==$TPL_V1){?> selected="selected"  <?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
	</select>
</div>
<?php }?>

<ul class="bbslist_ul_style">
	<!-- 공지사항 리스트데이터 : 시작 -->
<?php if($TPL_VAR["noticeloop"]){?>
<?php if($TPL_noticeloop_1){foreach($TPL_VAR["noticeloop"] as $TPL_V1){?>
		<li>
<?php if($TPL_V1["goodsInfo"]["image"]){?>
			<span class="bus_goods_image">
				<img  src="<?php echo $TPL_V1["goodsInfo"]["image"]?>" class="hand small_goods_image" designImgSrcOri='ey5nb29kc0luZm8uaW1hZ2V9' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9tYnFuYS9fbWJxbmEvaW5kZXguaHRtbA==' designImgSrc='ey5nb29kc0luZm8uaW1hZ2V9' designElement='image' />
			</span>
<?php }?>
			<span class="hand boad_view_btn_m<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
				<div class="bus_subject">
					<img src="/data/skin/responsive_diary_petit_gl/images/board/icon/icon_notice.gif" designImgSrcOri='Li4vLi4vLi4vaW1hZ2VzL2JvYXJkL2ljb24vaWNvbl9ub3RpY2UuZ2lm' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9tYnFuYS9fbWJxbmEvaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9ib2FyZC9pY29uL2ljb25fbm90aWNlLmdpZg==' designElement='image' />
					<span ><a><?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["iconaward"]?><?php echo $TPL_V1["blank"]?><?php echo $TPL_V1["category"]?> <?php echo $TPL_V1["subjectcut"]?> <?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconvideo"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?></a></span></span>
				</div>
				<span class="bus_record_info">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><span class="cell" ><?php echo $TPL_V1["name"]?></span><?php }?>
				<span class="cell"> <?php if(getDateFormat($TPL_V1["r_date"],"Y-m-d")==date("Y-m-d")){?><?php echo date('H:i',strtotime($TPL_V1["date"]))?><?php }else{?><?php echo $TPL_V1["date"]?><?php }?></span>
				<span class="cell">조회 <?php echo number_format($TPL_V1["hit"])?></span>
				</span>
			</span>
<?php if($TPL_VAR["manager"]["auth_cmt_use"]=='Y'){?><span class="bus_comment"><?php echo number_format($TPL_V1["comment"])?></span><?php }?>
		</li>
		<li class="board_contents hide" style="background-color:#fcfcfc;" id="board_contents_<?php echo $TPL_V1["seq"]?>"><?php echo $TPL_V1["seq"]?></li>
<?php }}?>
<?php }?>
	<!-- 공지사항리스트데이터 : 끝 -->

	<!-- 리스트데이터 : 시작 -->
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<li>
<?php if($TPL_V1["goodsInfo"]["image"]){?>
			<span class="bus_goods_image">
				<img  src="<?php echo $TPL_V1["goodsInfo"]["image"]?>" class="hand small_goods_image" designImgSrcOri='ey5nb29kc0luZm8uaW1hZ2V9' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9tYnFuYS9fbWJxbmEvaW5kZXguaHRtbA==' designImgSrc='ey5nb29kc0luZm8uaW1hZ2V9' designElement='image' />
			</span>
<?php }?>
			<span class="hand boad_view_btn_m<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
				<div class="bus_subject">
					<span>
					<a><?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["iconaward"]?><?php echo $TPL_V1["blank"]?><?php echo $TPL_V1["category"]?> <?php echo $TPL_V1["subject_real"]?>

						<span class="comment_<?php echo $TPL_V1["seq"]?>">
							<?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconvideo"]?>

<?php if($TPL_V1["iconnew"]){?>
								<img src="/data/skin/responsive_diary_petit_gl/images/icon/icon_new.png" title="new" align="absmiddle" designImgSrcOri='Li4vLi4vLi4vaW1hZ2VzL2ljb24vaWNvbl9uZXcucG5n' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9tYnFuYS9fbWJxbmEvaW5kZXguaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9pY29uL2ljb25fbmV3LnBuZw==' designElement='image' >
<?php }?>
							<?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?> <?php echo $TPL_V1["scorelay"]?>

						</span>
					</a>
					</span>
				</div>
				<span class="bus_record_info">
				<span class="cell" ><?php echo $TPL_V1["name"]?></span>
				<span class="cell"> <?php if(getDateFormat($TPL_V1["r_date"],"Y-m-d")==date("Y-m-d")){?><?php echo date('H:i',strtotime($TPL_V1["date"]))?><?php }else{?><?php echo $TPL_V1["date"]?><?php }?></span>
				<span class="cell">조회 <?php echo number_format($TPL_V1["hit"])?></span>
				<span class="cell"><?php echo $TPL_V1["buyertitle"]?></span>
				</span>
			</span>

<?php if($TPL_VAR["manager"]["auth_cmt_use"]=='Y'){?><span class="bus_comment idx-comment-<?php echo $TPL_V1["seq"]?>"><?php echo number_format($TPL_V1["comment"])?></span><?php }?>
		</li>
		<li class="board_contents hide" style="background-color:#fcfcfc;" id="board_contents_<?php echo $TPL_V1["seq"]?>"><?php echo $TPL_V1["seq"]?></li>
<?php }}?>
<?php }else{?>
		<li style="text-align:center;">등록된 게시글이 없습니다.</li>
<?php }?>
	<!-- 리스트데이터 : 끝 -->
</ul>

<?php if($TPL_VAR["loop"]){?>
<div class="pd20">
<?php if($TPL_VAR["pagin"]){?><!-- 페이징 --><div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div><!-- 페이징 --> <?php }?>
</div>
<?php }?>

<div id="BoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3> 비밀번호 확인</h3>
		<div>게시글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
	</div>
	<form name="BoardPwcheckForm" id="BoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame " >
	<input type="hidden" name="seq" id="pwck_seq" value="" />
	<input type="hidden" name="returnurl" id="pwck_returnurl" value="" />
	<div class="ibox">
		<input type="password" name="pw" id="pwck_pw" class="input" />
		<input type="submit" id="BoardPwcheckBtn" value=" 확인 " class="hand round_btn " />
		<input type="button" value=" 취소 " class="hand round_btn " onclick="$('#BoardPwCk').dialog('close');" />
	</div>
	</form>
</div>

<!--게시글 비회원 비밀번호 확인 -->
<div id="ModDelBoardPwCk_m" class="hide BoardPwCk">
	<div class="msg">
		<div>등록시에 입력했던 비밀번호를 입력해 주세요.</div>
	</div>
	<form name="ModDelBoardPwcheckForm" id="ModDelBoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame" >
	<input type="hidden" name="board_id" id="board_id" value="<?php echo $_GET["id"]?>" />
	<input type="hidden" name="modetype" id="modetype" value="board_delete" />
	<input type="hidden" name="mode" id="mode" value="board_delete" />
	<input type="hidden" name="delseq" id="moddel_pwck_seq" value="" />
	<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>" >
	<input type="hidden" name="returnurl" id="moddel_pwck_returnurl" value="<?php echo $TPL_VAR["boardurl"]->userurl?>" />
	<div class="ibox" style="text-align:center;">
		<input type="password" name="pw" id="moddel_pwck_pw" style="width:130px;" class="input" />
		<input type="submit" id="BoardPwcheckBtn" value=" 확인 " class="hand round_btn " />
		<input type="button" value=" 취소 " class="hand round_btn " onclick="$('#moddel_pwck_pw').val(''); $('#ModDelBoardPwCk_m').dialog('close');" />
	</div>
	</form>
</div>

<!-- 댓글 비회원 비밀번호 확인 -->
<div id="CmtBoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<div>댓글 등록시에 입력했던 <br/>비밀번호를 입력해 주세요.</div>
	</div>
	<form name="BoardPwcheckForm" id="CmtBoardPwcheckForm" method="post">
	<input type="hidden" name="board_id" id="board_id" value="<?php echo $_GET["id"]?>" />
	<input type="hidden" name="mode" value="board_comment_delete_pwcheck" />
	<input type="hidden" name="seq" id="cmt_pwck_seq" value="" />
	<input type="hidden" name="cmtseq" id="cmt_pwck_cmtseq" value="" />
	<div class="ibox">
		<input type="password" name="pw" id="cmt_pwck_pw" class="input" style="width:120px;" />
		<input type="submit" id="CmtBoardPwcheckBtn" value=" 확인 " class="hand round_btn " />
		<input type="button" value=" 취소 " class="hand round_btn " onclick="$('#CmtBoardPwCk').dialog('close');" />
	</div>
	</form>
</div>