<?php /* Template_ 2.2.6 2021/12/15 17:48:38 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/mypage/myqna_catalog.html 000011459 */  $this->include_("sslAction");
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_noticeloop_1=empty($TPL_VAR["noticeloop"])||!is_array($TPL_VAR["noticeloop"])?0:count($TPL_VAR["noticeloop"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 나의 1:1 문의 List @@
- 파일위치 : [스킨폴더]/mypage/myqna_catalog.html
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
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbXlwYWdlL215cW5hX2NhdGFsb2cuaHRtbA==" >나의 1:1 문의</span></h2>
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
				//]]>
			</script>
			<script type="text/javascript" src="/app/javascript/js/board.js?v=20200513"></script>
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
								<input type="text" name="search_text" id="search_text" class="res_bbs_search_input" value="<?php echo $_GET["search_text"]?>" title="제목, 내용" />
								<button type="submit" class="btn_resp size_b">검색</button>
								<button type="button" class="btn_resp size_b hide" onclick="document.location.href='<?php echo $TPL_VAR["boardurl"]->lists?>'">초기화</button>
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
						<li style="width:45px;">번호</li>
						<li style="width:80px;">상태</li>
						<li style="width:100px;">분류</li>
						<li>제목</li>
						<li style="width:130px;">날짜</li>
						<li style="width:45px;">조회</li>
					</ul>
<?php if($TPL_VAR["noticeloop"]){?>
<?php if($TPL_noticeloop_1){foreach($TPL_VAR["noticeloop"] as $TPL_V1){?>
						<ul class="tbody notice <?php if($TPL_V1["display"]== 1){?>gray<?php }?>">
							<li class="num"><span class="mtitle">공지</span> <?php echo $TPL_V1["number"]?></li>
							<li class="mo_hide"><strong class="pointcolor">공지</strong></li>
							<li><?php echo $TPL_V1["category"]?></li>
							<li class="subject">
								<span class="hand boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>" viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>" pagetype="<?php echo $TPL_VAR["pagetype"]?>" board_seq="<?php echo $TPL_V1["seq"]?>"  board_id="<?php echo $TPL_VAR["manager"]["id"]?>">
									<a>
										<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["blank"]?> <?php echo $TPL_V1["subjectcut"]?>

<?php if($TPL_V1["comment"]> 0){?><span class="comment">(<?php echo number_format($TPL_V1["comment"])?>)</span><?php }?>
										<?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?>

									</a>
								</span>
							</li>
							<li><?php echo str_replace("-","/",$TPL_V1["date"])?></li>
							<li><span class="mtitle">조회:</span> <?php echo $TPL_V1["hit"]?></li>
						</ul>
<?php }}?>
<?php }?>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<ul class="tbody <?php if($TPL_V1["display"]== 1){?>gray<?php }?> <?php if($TPL_V1["reply_state"]=='complete'){?>complete<?php }?>">
							<li class="mo_hide"><span class="mtitle">번호:</span> <?php echo $TPL_V1["number"]?></li>
							<li><?php if($TPL_V1["reply_state"]=='standby'){?><span class="reply_title">답변대기</span><?php }elseif($TPL_V1["reply_state"]=='complete'){?><span class="reply_title pointcolor2" >답변완료</span><?php }?></li>
							<li style="order:-4;"><?php echo $TPL_V1["category"]?></li>
							<li class="subject">
								<span class="hand boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>" viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>" pagetype="<?php echo $TPL_VAR["pagetype"]?>" board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $TPL_VAR["manager"]["id"]?>">
									<a>
										<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["blank"]?> <?php echo $TPL_V1["subjectcut"]?>

<?php if($TPL_V1["comment"]> 0){?><span class="comment">(<?php echo number_format($TPL_V1["comment"])?>)</span><?php }?>
										<?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?>

									</a>
								</span>
							</li>
							<li><?php echo str_replace("-","/",$TPL_V1["date"])?></li>
							<li><span class="mtitle">조회:</span> <?php echo $TPL_V1["hit"]?></li>
						</ul>
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

				<!-- 나의 1:1 문의에서는 사용되지 않는 것으로 보임 -->
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
				<!-- //나의 1:1 문의에서는 사용되지 않는 것으로 보임 -->
			</div>
		</div>


	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_ver1_default_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->

<script type="text/javascript">
$(function() {
	var pagingTotalNum = $('#pagingDisplay a').length;
	if ( pagingTotalNum < 2 ) {
		$('#pagingDisplay').hide();
	}
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