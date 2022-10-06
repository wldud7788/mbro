<?php /* Template_ 2.2.6 2021/01/08 12:01:43 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/board/goods_qna/_goods_qna/index.html 000017073 */  $this->include_("sslAction");
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_noticeloop_1=empty($TPL_VAR["noticeloop"])||!is_array($TPL_VAR["noticeloop"])?0:count($TPL_VAR["noticeloop"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 상품문의 List @@
- 파일위치 : [스킨폴더]/board/goods_qna/_goods_qna/index.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_VAR["viewlist"]!='view'){?>
<form name="boardsearch" id="boardsearch">
	<input type="hidden" name="id" value="<?php echo $_GET["id"]?>">
	<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>">
	<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>">
	<input type="hidden" name="goods_seq" value="<?php echo $_GET["goods_seq"]?>">
	<input type="hidden" name="perpage" id="perpage" value="<?php echo $_GET["perpage"]?>">
	<input type="hidden" name="page" id="page" value="<?php echo $_GET["page"]?>">
	<input type="hidden" name="category" id="category" value="<?php echo $_GET["category"]?>">

	<ul class="bbs_top_wrap">
		<li class="left">
<?php if($TPL_VAR["categorylist"]){?>
			<select name="category" id="searchcategory">
				<option value="" selected="selected">- 전체 -</option>
<?php if($TPL_categorylist_1){foreach($TPL_VAR["categorylist"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1?>" <?php if($_GET["category"]==$TPL_V1){?> selected="selected" <?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
			</select>
<?php }?>
		</li>
		<li class="right2">
			<span class="searchform">
				<input type="text" name="search_text" id="search_text" class="res_bbs_search_input" value="<?php echo $_GET["search_text"]?>" title="제목, 내용, 상품명, 상품설명, 작성자" />
				<button type="submit" class="btn_resp size_b">검색</button>
				<button type="button" class="btn_resp size_b hide" onclick="document.location.href='<?php echo $TPL_VAR["boardurl"]->resets?>'">초기화</button>
			</span>
		</li>
	</ul>
</form>
<div class="article_info hide">
<?php if($TPL_VAR["sc"]["totalcount"]>$TPL_VAR["sc"]["searchcount"]){?>검색 <?php echo number_format($TPL_VAR["sc"]["searchcount"])?>개/<?php }?>총 <?php echo number_format($TPL_VAR["sc"]["totalcount"])?>개 (현재 <?php if($TPL_VAR["sc"]["total_page"]== 0){?>0<?php }else{?><?php echo (($TPL_VAR["sc"]["page"]/$TPL_VAR["sc"]["perpage"])+ 1)?><?php }?>/총 <?php echo number_format($TPL_VAR["sc"]["total_page"])?>페이지)
</div>
<?php }?>


<?php if($TPL_VAR["noticeloop"]||$TPL_VAR["loop"]){?>
	<div class="res_table">
		<ul class="thead">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><li style="width:45px;"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >번호</span></li><?php }?>
			<li style="width:80px;"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >상태</span></li>
			<li style="width:100px;"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >분류</span></li>
			<li><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >문의</span></li>
			<li style="width:94px;"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >작성자</span></li>
			<li style="width:84px;"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >등록일</span></li>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li style="width:45px;"><?php echo $TPL_VAR["manager"]["scoretitle"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li style="width:45px;"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >조회</span></li><?php }?>
		</ul>
<?php if($TPL_VAR["noticeloop"]){?>
<?php if($TPL_noticeloop_1){foreach($TPL_VAR["noticeloop"] as $TPL_V1){?>
		<ul class="tbody notice">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><li class="num"><span class="mtitle" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >공지</span> <?php echo $TPL_V1["number"]?></li><?php }?>
			<li class="mo_hide"><span class="pointcolor" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >공지</span></li>
			<li><?php echo $TPL_V1["category"]?></li>
			<li class="subject">
<?php if($TPL_V1["goodsInfo"]){?>
					<ul class="board_goods_list">
						<li class="pic">
							<span class="boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
								<img src="<?php echo $TPL_V1["goodsInfo"]["goodsimg"]?>" onerror="this.src='/data/icon/error/noimage_list.gif'" alt="" designImgSrcOri='ey5nb29kc0luZm8uZ29vZHNpbWd9' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=' designImgSrc='ey5nb29kc0luZm8uZ29vZHNpbWd9' designElement='image' />
							</span>
						</li>
						<li class="info">
							<div class="name"><a href="/goods/view?no=<?php echo $TPL_V1["goodsInfo"]["goods_seq"]?>" target="_blank" hrefOri='L2dvb2RzL3ZpZXc/bm89ey5nb29kc0luZm8uZ29vZHNfc2VxfQ==' ><?php echo $TPL_V1["goodsInfo"]["goods_name"]?></a></div>
							<div class="title">
								<span class="boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
									<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["blank"]?> <?php echo $TPL_V1["subjectcut"]?>

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
<?php if($TPL_VAR["contentcut"]){?>
					<div class="board_list_cont hand boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>" viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>" board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>"><?php echo $TPL_V1["contentcut"]?></div>
<?php }?>
<?php }?>
			</li>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><li><?php echo $TPL_V1["name"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li><?php echo $TPL_V1["date"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li><span class="mtitle"><?php echo $TPL_VAR["manager"]["scoretitle"]?>:</span> <?php echo $TPL_V1["recommendlay"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li><span class="mtitle" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >조회:</span> <?php echo number_format($TPL_V1["hit"])?></li><?php }?>
		</ul>
<?php }}?>
<?php }?>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<ul class="tbody <?php if($TPL_V1["display"]== 1){?>gray<?php }?> <?php if($TPL_V1["reply_state"]=='complete'){?>complete<?php }?> <?php if($TPL_V1["blank"]){?>reply<?php }?>">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><li class="mo_hide"><span class="mtitle" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >번호:</span> <?php echo $TPL_V1["number"]?></li><?php }?>
			<li><span class="reply_title"><?php echo $TPL_V1["reply_title"]?></span></li>
			<li style="order:-4;"><?php echo $TPL_V1["category"]?></li>
			<li class="subject">
<?php if($TPL_V1["goodsInfo"]){?>
				<ul id="goodsview" class="board_goods_list">
					<li class="pic">
						<span class="boad_view_btn<?php echo $TPL_V1["isperm_read"]?> " viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
							<img src="<?php echo $TPL_V1["goodsInfo"]["goodsimg"]?>" onerror="this.src='/data/icon/error/noimage_list.gif'" alt="" designImgSrcOri='ey5nb29kc0luZm8uZ29vZHNpbWd9' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=' designImgSrc='ey5nb29kc0luZm8uZ29vZHNpbWd9' designElement='image' />
						</span>
					</li>
					<li class="info">
						<div class="name"><a href="/goods/view?no=<?php echo $TPL_V1["goodsInfo"]["goods_seq"]?>" target="_blank" hrefOri='L2dvb2RzL3ZpZXc/bm89ey5nb29kc0luZm8uZ29vZHNfc2VxfQ==' ><?php echo $TPL_V1["goodsInfo"]["goods_name"]?></a></div>
						<div class="title">
							<span class="boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
								<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["blank"]?> <?php echo $TPL_V1["subjectcut"]?>

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
<?php if($TPL_VAR["contentcut"]){?>
				<div class="board_list_cont hand boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>" viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>" board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>"><?php echo $TPL_V1["contentcut"]?></div>
<?php }?>
<?php }?>
			</li>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><li><?php echo $TPL_V1["name"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li><?php echo $TPL_V1["date"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li><span class="mtitle"><?php echo $TPL_VAR["manager"]["scoretitle"]?>:</span> <?php echo $TPL_V1["recommendlay"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li><span class="mtitle" designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >조회:</span> <?php echo number_format($TPL_V1["hit"])?></li><?php }?>
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
		<button type="button" name="boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>" <?php if($_GET["iframe"]){?>id="goods_boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>"<?php }else{?>id="boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>"<?php }?> board_id="<?php echo $TPL_VAR["boardid"]?>" fileperm_read="<?php echo $TPL_VAR["manager"]["fileperm_write"]?>" class="btn_resp size_b color2" /><?php echo $TPL_VAR["manager"]["name"]?> <span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2JvYXJkL2dvb2RzX3FuYS9fZ29vZHNfcW5hL2luZGV4Lmh0bWw=" >쓰기</span></button>
	</li>
</ul>





<div id="BoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3> 비밀번호 확인</h3>
		<div>게시글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
	</div>
	<form name="BoardPwcheckForm" id="BoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame ">
		<input type="hidden" name="seq" id="pwck_seq" value="" />
		<input type="hidden" name="returnurl" id="pwck_returnurl" value="" />
		<div class="ibox">
			<input type="password" name="pw" id="pwck_pw" style="width:140px;" />
			<button type="submit" id="BoardPwcheckBtn" class="btn_resp size_b color2" />확인</button>
			<button type="button" class="btn_resp size_b" onclick="$('#BoardPwCk').dialog('close');" />취소</button>
		</div>
	</form>
</div>
<!-- //비밀번호 확인 -->


<script>
$(function() {
	// reply 왼쪽 여백 조절
	$('.res_table img[title=blank]').each(function() {
		var blankWidth = $(this).attr('width');
		var replyLeftMargin = 12;
		var replyStep = blankWidth / 53;
		$(this).css('width', replyStep * replyLeftMargin + 'px');
	});
});
</script>