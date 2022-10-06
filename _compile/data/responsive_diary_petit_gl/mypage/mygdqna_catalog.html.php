<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/mygdqna_catalog.html 000022761 */  $this->include_("sslAction");
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_noticeloop_1=empty($TPL_VAR["noticeloop"])||!is_array($TPL_VAR["noticeloop"])?0:count($TPL_VAR["noticeloop"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 나의 상품 문의 List @@
- 파일위치 : [스킨폴더]/mypage/mygdqna_catalog.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<style>
.resp_layer_bg { z-index:9998; }
</style>
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
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvbXlnZHFuYV9jYXRhbG9nLmh0bWw=" >나의 상품 문의</span></h2>
		</div>

		<!-- <?php if($TPL_VAR["viewlist"]!='view'){?> -->
		<!-- <?php }?> -->

		<div id="boardlayout">
			<script type="text/javascript">
				//<![CDATA[
				var board_id = '<?php echo $TPL_VAR["manager"]["id"]?>';
				var boardlistsurl = '<?php echo $TPL_VAR["boardurl"]->lists?>';
				var boardwriteurl = '<?php echo $TPL_VAR["boardurl"]->write?>';
				var boardviewurl = '<?php echo $TPL_VAR["boardurl"]->view?>';
				var boardmodifyurl = '<?php echo $TPL_VAR["boardurl"]->modify?>';
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
<?php if($TPL_VAR["commentskinjsuse"]){?>
			<script type="text/javascript" src="/app/javascript/js/board_comment_mobile.js?v=4"  charset="utf-8"></script>
<?php }?>
			<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" ></script>
			<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"  charset="utf-8"></script>

			<div id="bbslist">
				
				<!-- 검색 -->
				<form name="boardsearch" id="boardsearch" >
					<input type="hidden" name="id" value="<?php echo $TPL_VAR["manager"]["id"]?>" >
					<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>" >
					<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>" >
					<input type="hidden" name="goods_seq" value="<?php echo $_GET["goods_seq"]?>" >
					<input type="hidden" name="perpage" id="perpage" value="<?php echo $_GET["perpage"]?>" >
					<input type="hidden" name="page" id="page" value="<?php echo $_GET["page"]?>" >
					<input type="hidden" name="category" id="category" value="<?php echo $_GET["category"]?>" >
					<input type="hidden" name="score" id="score" value="<?php echo $_GET["score"]?>" >

					<ul class="bbs_top_wrap">
						<li class="left">
<?php if($TPL_VAR["categorylist"]){?>
							<select name="category" id="searchcategory">
								<option value="" selected="selected" >- 질문유형전체 -</option>
<?php if($TPL_categorylist_1){foreach($TPL_VAR["categorylist"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1?>" <?php if($_GET["category"]==$TPL_V1){?> selected="selected" <?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
							</select>
<?php }?>
						</li>
						<li class="right2">
							<span class="searchform">
								<input type="text" name="search_text" id="search_text" value="<?php echo $_GET["search_text"]?>" title="작성자, 제목, 내용"  class="res_bbs_search_input" />
								<button type="submit" class="btn_resp size_b">검색</button>
								<button type="button" class="bbs_btn hide" onclick="document.location.href='<?php echo $TPL_VAR["boardurl"]->lists?>'">초기화</button>
							</span>
						</li>
					</ul>
				</form>

				<div class="article_info hide">
<?php if($TPL_VAR["sc"]["totalcount"]>$TPL_VAR["sc"]["searchcount"]){?>검색 <?php echo number_format($TPL_VAR["sc"]["searchcount"])?>개/<?php }?>총 <?php echo number_format($TPL_VAR["sc"]["totalcount"])?>개(현재 <?php if($TPL_VAR["sc"]["total_page"]== 0){?>0<?php }else{?><?php echo (($TPL_VAR["sc"]["page"]/$TPL_VAR["sc"]["perpage"])+ 1)?><?php }?>/총 <?php echo number_format($TPL_VAR["sc"]["total_page"])?>페이지)
				</div>

<?php if($TPL_VAR["noticeloop"]||$TPL_VAR["loop"]){?>
				<div class="res_table">
					<ul class="thead">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><li style="width:45px;">번호</li><?php }?>
						<li style="width:80px;">상태</li>
<?php if($TPL_VAR["categorylist"]){?><li style="width:100px;">분류</li><?php }?>
						<li>제목</li>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li style="width:84px;">날짜</li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li style="width:45px;"><?php echo $TPL_VAR["manager"]["scoretitle"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li style="width:45px;">조회</li><?php }?>
					</ul>
<?php if($TPL_VAR["noticeloop"]){?>
<?php if($TPL_noticeloop_1){foreach($TPL_VAR["noticeloop"] as $TPL_V1){?>
						<ul class="tbody notice <?php if($TPL_V1["display"]== 1){?>gray<?php }?>">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><li class="num"><span class="mtitle">공지</span> <?php echo $TPL_V1["number"]?></li><?php }?>
							<li class="mo_hide"><strong class="pointcolor">공지</strong></li>
<?php if($TPL_VAR["categorylist"]){?><li><?php echo $TPL_V1["category"]?></li><?php }?>
							<li class="subject">
<?php if($TPL_V1["goodsInfo"]){?>
								<ul class="board_goods_list">
									<li class="pic">
										<span class="boad_view_btn<?php echo $TPL_V1["isperm_read"]?> " viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
											<img src="<?php echo $TPL_V1["goodsInfo"]["goodsimg"]?>" onerror="this.src='/data/icon/error/noimage_list.gif'" alt="" />
										</span>
									</li>
									<li class="info">
										<div class="name"><a href="/goods/view?no=<?php echo $TPL_V1["goodsInfo"]["goods_seq"]?>" target="_blank"><?php echo $TPL_V1["goodsInfo"]["goods_name"]?></a></div>
										<div class="title">
											<span class="boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
												<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["iconaward"]?><?php echo $TPL_V1["blank"]?> <?php echo $TPL_V1["subjectcut"]?>

<?php if($TPL_V1["comment"]> 0){?><span class="comment">(<?php echo number_format($TPL_V1["comment"])?>)</span><?php }?>
												<?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?>

											</span>
										</div>
										<div class="cont">
											<span class="boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>" viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>" board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>"><?php echo $TPL_V1["goodsInfo"]["goodslistcontents"]?></span>
										</div>
									</li>
								</ul>
<?php }else{?>
								<span class="hand boad_view_btn<?php echo $TPL_V1["isperm_read"]?> " viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
									<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["iconaward"]?><?php echo $TPL_V1["blank"]?> <?php echo $TPL_V1["subjectcut"]?>

<?php if($TPL_V1["comment"]> 0){?><span class="comment">(<?php echo number_format($TPL_V1["comment"])?>)</span><?php }?>
									<?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconvideo"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?>

								</span>
<?php }?>
							</li>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li><?php echo str_replace("-","/",$TPL_V1["date"])?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?>
							<li>
								<span class="mtitle"><?php echo $TPL_VAR["manager"]["scoretitle"]?>:</span>
<?php if($TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?> 
<?php if($TPL_VAR["manager"]["recommend_type"]=='3'){?>   
										<span class="idx-recommend1-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend1"])?></span>/<span class="idx-recommend1-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend2"])?></span>/<span class="idx-recommend1-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend3"])?></span>/<span class="idx-recommend1-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend4"])?></span>/<span class="idx-recommend1-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend5"])?></span>
<?php }elseif($TPL_VAR["manager"]["recommend_type"]=='2'){?>  
										<span class="idx-recommend-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend"])?></span>/<span class="idx-none_rec-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["none_rec"])?></span>  
<?php }elseif($TPL_VAR["manager"]["recommend_type"]=='1'){?> 
										<span class="idx-recommend-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend"])?></span>  
<?php }?> 
<?php }?> 
							</li>
<?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li><span class="mtitle">조회:</span> <?php echo $TPL_V1["hit"]?></li><?php }?>
						</ul>
						<div id="tdviewer<?php echo $TPL_V1["seq"]?>" class="goodsviewer resp_layer_pop maxHeight hide" style="z-index:9999;">
							<div class="y_scroll_auto mh100">
								<div id="viewer<?php echo $TPL_V1["seq"]?>" class="layer_pop_contents v3">
								</div>
							</div>
						</div>
<?php }}?>
<?php }?>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<ul class="tbody <?php if($TPL_V1["display"]== 1){?>gray<?php }?> <?php if($TPL_V1["reply_state"]=='complete'){?>complete<?php }?> <?php if($TPL_V1["blank"]){?>reply<?php }?>">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><li class="mo_hide"><span class="mtitle">번호:</span> <?php echo $TPL_V1["number"]?></li><?php }?>
							<li><?php if($TPL_V1["reply_state"]=='standby'){?><span class="reply_title">답변대기</span><?php }elseif($TPL_V1["reply_state"]=='complete'){?><span class="reply_title">답변완료</span><?php }?></li>
<?php if($TPL_VAR["categorylist"]){?><li style="order:-4;"><?php echo $TPL_V1["category"]?></li><?php }?>
							<li class="subject">
<?php if($TPL_V1["goodsInfo"]){?>
								<ul class="board_goods_list">
									<li class="pic">
										<span class="boad_view_btn<?php echo $TPL_V1["isperm_read"]?> " viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
											<img src="<?php echo $TPL_V1["goodsInfo"]["goodsimg"]?>" onerror="this.src='/data/icon/error/noimage_list.gif'" alt="" />
										</span>
									</li>
									<li class="info">
										<div class="name"><a href="/goods/view?no=<?php echo $TPL_V1["goodsInfo"]["goods_seq"]?>" target="_blank"><?php echo $TPL_V1["goodsInfo"]["goods_name"]?></a></div>
										<div class="title">
											<span class="boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
												<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["iconaward"]?><?php echo $TPL_V1["blank"]?> <?php echo $TPL_V1["subjectcut"]?>

<?php if($TPL_V1["comment"]> 0){?><span class="comment">(<?php echo number_format($TPL_V1["comment"])?>)</span><?php }?>
												<?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?>

											</span>
										</div>
										<div class="cont">
											<span class="boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>" viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>" board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>"><?php echo $TPL_V1["goodsInfo"]["goodslistcontents"]?></span>
										</div>
									</li>
								</ul>
<?php }else{?>
								<span class="hand boad_view_btn<?php echo $TPL_V1["isperm_read"]?> " viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
									<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["iconaward"]?><?php echo $TPL_V1["blank"]?> <?php echo $TPL_V1["subjectcut"]?>

<?php if($TPL_V1["comment"]> 0){?><span class="comment">(<?php echo number_format($TPL_V1["comment"])?>)</span><?php }?>
									<?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconvideo"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?>

								</span>
<?php }?>
							</li>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li><?php echo str_replace("-","/",$TPL_V1["date"])?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li><span class="mtitle"><?php echo $TPL_VAR["manager"]["scoretitle"]?>:</span><?php echo $TPL_V1["recommendlay"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li><span class="mtitle">조회:</span> <?php echo $TPL_V1["hit"]?></li><?php }?>
						</ul>
						<div id="tdviewer<?php echo $TPL_V1["seq"]?>" class="goodsviewer resp_layer_pop maxHeight hide" style="z-index:9999;">
							<div class="y_scroll_auto mh100">
								<div id="viewer<?php echo $TPL_V1["seq"]?>" class="layer_pop_contents v3">
								</div>
							</div>
						</div>
<?php }}?>
<?php }?>
				</div>
<?php }else{?>
				<div class="no_data_area2">
					등록된 게시글이 없습니다.
				</div>
<?php }?>

<?php if($TPL_VAR["pagin"]){?>
				<div id="pagingDisplay" class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
<?php }?>

				<ul class="bbs_bottom_wrap">
					<li class="right">
						<button type="button" name="boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>" id="boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" fileperm_read="<?php echo $TPL_VAR["manager"]["fileperm_write"]?>" class="btn_resp size_b color2" /><?php echo $TPL_VAR["manager"]["name"]?> 쓰기</button>
					</li>
				</ul>

				<!-- 나의 상품 문의에서는 사용되지 않는 것으로 보임 -->
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
						<input type="button" value=" 취소 " class="bbs_btn" onclick="$('#BoardPwCk').dialog('close');" />
					</div>
					</form>
				</div>
				<!-- //나의 상품 문의에서는 사용되지 않는 것으로 보임 -->

			</div>
		</div>


	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->

<script>
$(function() {
	// 페이징 개수가 1개일때 노출 X
	var pagingTotalNum = $('#pagingDisplay a').length;
	if ( pagingTotalNum < 2 ) {
		$('#pagingDisplay').hide();
	}

	// reply 왼쪽 여백 조절
	$('.res_table img[title=blank]').each(function() {
		var blankWidth = $(this).attr('width');
		var replyLeftMargin = 12;
		var replyStep = blankWidth / 53;
		$(this).css('width', replyStep * replyLeftMargin + 'px');
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

<?php if($TPL_VAR["manager"]["viewtype"]=='layer'){?>
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
<script type="text/javascript">
	$(document).ready(function() {
		$(".viewerlay_close_btn").live("click",function(){
			var board_seq = $(this).attr('board_seq');
			$("#viewer"+board_seq).html('').show();
			hideCenterLayer("#tdviewer"+board_seq);
			return false;
		});
	});

	function getboardLogin(){
<?php if(defined('__ISUSER__')===true){?>
			//해당 서비스를 이용하시려면 관리자에게 문의하여 주시길 바랍니다.
			openDialogAlert(getAlert('mp110'),'450','140');
<?php }else{?>
			//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
			openDialogConfirm(getAlert('mp111'),'400','155',function(){top.location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
	}

	function getcmtMbLogin(){
<?php if(defined('__ISUSER__')===true){?>
			//글작성자만 이용가능합니다.
			openDialogAlert(getAlert('mp112'),'400','140');
<?php }else{?>
			//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
			openDialogConfirm(getAlert('mp111'),'400','155',function(){top.location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
	}
</script>
<?php }?>