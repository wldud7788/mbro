<?php /* Template_ 2.2.6 2021/12/15 17:48:34 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/board/bulkorder/_bulkorder/index.html 000010870 */  $this->include_("sslAction");
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_noticeloop_1=empty($TPL_VAR["noticeloop"])||!is_array($TPL_VAR["noticeloop"])?0:count($TPL_VAR["noticeloop"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 대량구매 List @@
- 파일위치 : [스킨폴더]/board/bulkorder/_bulkorder/index.html
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
	<input type="hidden" name="score" id="score" value="<?php echo $_GET["score"]?>">

	<ul class="bbs_top_wrap">
		<li class="left">
<?php if($TPL_VAR["categorylist"]){?>
			<select name="category" id="searchcategory">
				<option value="" selected="selected">- 질문유형전체 -</option>
<?php if($TPL_categorylist_1){foreach($TPL_VAR["categorylist"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1?>" <?php if($_GET["category"]==$TPL_V1){?> selected="selected" <?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
			</select>
<?php }?>
		</li>
		<li class="right2">
			<span class="searchform">
				<input type="text" name="search_text" id="search_text" class="res_bbs_search_input" value="<?php echo $_GET["search_text"]?>" title="상품명, 회사명, 문의자, 제목, 내용" />
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
			<li style="width:45px;"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >번호</span></li>
			<li style="width:80px;"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >상태</span></li>
			<li style="width:105px;"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >분류</span></li>
			<li><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >문의</span></li>
			<li style="width:120px;"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >문의자</span></li>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li style="width:100px;"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >문의일</span></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li style="width:45px;"><?php echo $TPL_VAR["manager"]["scoretitle"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li style="width:45px;"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >조회</span></li><?php }?>
		</ul>
<?php if($TPL_VAR["noticeloop"]){?>
<?php if($TPL_noticeloop_1){foreach($TPL_VAR["noticeloop"] as $TPL_V1){?>
		<ul class="tbody notice">
			<li class="num"><span class="mtitle" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >공지</span> <?php echo $TPL_V1["number"]?></li>
			<li class="mo_hide"><span class="pointcolor" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >공지</span></li>
			<li><?php echo $TPL_V1["category"]?></li>
			<li class="subject">
				<span class="hand boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
					<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["blank"]?> <?php echo $TPL_V1["subjectcut"]?>

<?php if($TPL_V1["comment"]> 0){?><span class="comment">(<?php echo number_format($TPL_V1["comment"])?>)</span><?php }?>
					<?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?>

				</span>
			</li>
			<li><?php echo $TPL_V1["name"]?></li>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li><?php echo date('Y.m.d',strtotime($TPL_V1["date"]))?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li><span class="mtitle"><?php echo $TPL_VAR["manager"]["scoretitle"]?>:</span><?php echo $TPL_V1["recommendlay"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li><span class="mtitle" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >조회:</span> <?php echo $TPL_V1["hit"]?></li><?php }?>
		</ul>
<?php }}?>
<?php }?>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<ul class="tbody <?php if($TPL_V1["display"]== 1){?>gray<?php }?> <?php if($TPL_V1["reply_state"]=='complete'){?>complete<?php }?> <?php if($TPL_V1["blank"]){?>reply<?php }?>">
			<li class="mo_hide"><span class="mtitle" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >번호:</span> <?php echo $TPL_V1["number"]?></li>
			<li><span class="reply_title"><?php echo $TPL_V1["reply_title"]?></span></li>
			<li style="order:-4;"><?php echo $TPL_V1["category"]?></li>
			<li class="subject">
				<span class="hand boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
					<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["blank"]?> <?php echo $TPL_V1["subjectcut"]?> <?php if($TPL_V1["comment"]> 0){?><span class="comment">(<?php echo number_format($TPL_V1["comment"])?>)</span><?php }?>
					<?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?>

				</span>
			</li>
			<li><?php echo $TPL_V1["name"]?></li>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li><?php echo date('Y.m.d',strtotime($TPL_V1["date"]))?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li><span class="mtitle"><?php echo $TPL_VAR["manager"]["scoretitle"]?>:</span><?php echo $TPL_V1["recommendlay"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li><span class="motle2" designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >조회:</span> <?php echo $TPL_V1["hit"]?></li><?php }?>
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
		<button type="button" name="boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>"  <?php if($_GET["iframe"]){?>id="goods_boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>"<?php }else{?>id="boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>"<?php }?> board_id="<?php echo $TPL_VAR["boardid"]?>" fileperm_read="<?php echo $TPL_VAR["manager"]["fileperm_write"]?>" class="btn_resp size_b color2" /><?php echo $TPL_VAR["manager"]["name"]?> <span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvYnVsa29yZGVyL19idWxrb3JkZXIvaW5kZXguaHRtbA==" >쓰기</span></button>
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
			<input type="password" name="pw" id="pwck_pw" class="input" />
			<input type="submit" id="BoardPwcheckBtn" value=" 확인 " class="btnblue" />
			<input type="button" value=" 취소 " class="bbs_btn" onclick="$('#BoardPwCk').dialog('close');" />
		</div>
	</form>
</div>
<!-- //비밀번호 확인 -->