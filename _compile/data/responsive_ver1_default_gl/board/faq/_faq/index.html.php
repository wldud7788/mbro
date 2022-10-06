<?php /* Template_ 2.2.6 2021/12/15 17:48:34 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/board/faq/_faq/index.html 000006172 */  $this->include_("sslAction");
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ FAQ List/View @@
- 파일위치 : [스킨폴더]/board/faq/_faq/index.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_VAR["viewlist"]!='view'){?>
<form name="boardsearch" id="boardsearch">
	<input type="hidden" name="id" value="<?php echo $_GET["id"]?>">
	<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>">
	<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>">
	<input type="hidden" name="goods_seq" value="<?php echo $_GET["goods_seq"]?>">
	<input type="hidden" name="score" id="score" value="<?php echo $_GET["score"]?>">
	<input type="hidden" name="perpage" id="perpage" value="<?php echo $_GET["perpage"]?>">
	<input type="hidden" name="page" id="page" value="<?php echo $_GET["page"]?>">
	<input type="hidden" name="category" id="category" value="<?php echo $_GET["category"]?>">

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
				<input type="text" name="search_text" id="search_text" class="res_bbs_search_input" value="<?php echo $_GET["search_text"]?>" title="제목, 내용" />
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

<?php if($TPL_VAR["loop"]){?>
	<ul class="faq_new">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<li>
			<div class="question">
				<p class="subject"><?php echo $TPL_V1["subject"]?> <?php echo $TPL_V1["iconnew"]?> <?php echo $TPL_V1["iconhot"]?> <?php echo $TPL_V1["iconfile"]?> <?php echo $TPL_V1["iconhidden"]?></p>
				<p class="add_info">
					<span class="hide">번호:  <?php echo $TPL_V1["number"]?></span>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?>작성자: <?php echo $TPL_V1["name"]?><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?>등록일: <?php echo $TPL_V1["date"]?><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?>조회수: <?php echo $TPL_V1["hit"]?><?php }?>
				</p>
			</div>
			<div id="faqcontent_<?php echo $TPL_V1["seq"]?>" class="answer <?php if($_GET["seq"]!=$TPL_V1["seq"]){?>hide<?php }?>">
<?php if($TPL_V1["filelist"]){?>
				<ul class="filelist">
<?php if(is_array($TPL_R2=$TPL_V1["filelist"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<li>
						<span class="realfilelist hand highlight-link" realfiledir="<?php echo $TPL_V2["realfiledir"]?>" realfilename="<?php echo $TPL_V2["orignfile"]?>" board_id="<?php echo $TPL_V1["boardid"]?>" filedown="../board_process?mode=board_file_down&board_id=<?php echo $TPL_V1["boardid"]?>&realfiledir=<?php echo $TPL_V2["realfiledir"]?>&realfilename=<?php echo $TPL_V2["orignfile"]?>">
							<?php echo $TPL_V2["orignfile"]?> <span class="gray_05">(<?php echo $TPL_V2["realsizefile"]?>)</span>
							<button type="button"  class="btn_resp size_a">down</button>
						</span>
					</li>
<?php }}?>
				</ul>
<?php }?>
				<?php echo $TPL_V1["contents"]?>

			</div>
		</li>
<?php }}?>
	</ul>
<?php }else{?>
	<div class="no_data_area2">
		등록된 게시글이 없습니다.
	</div>
<?php }?>

<?php if($TPL_VAR["pagin"]){?>
<div id="pagingDisplay" class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
<?php }?>

<ul class="bbs_bottom_wrap hide">
	<li class="right">
		<button type="button" name="boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>" <?php if($_GET["iframe"]){?>id="goods_boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>"<?php }else{?>id="boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>"<?php }?> board_id="<?php echo $TPL_VAR["boardid"]?>" fileperm_read="<?php echo $TPL_VAR["manager"]["fileperm_write"]?>" class="btn_resp size_b color2 hidden" /><?php echo $TPL_VAR["manager"]["name"]?> 쓰기</button>
	</li>
</ul>

<div id="BoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3>비밀번호 확인</h3>
		<div>게시물 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
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