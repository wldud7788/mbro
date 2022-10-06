<?php /* Template_ 2.2.6 2022/03/18 15:13:18 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/board/notice/default01/index.html 000010655 */  $this->include_("sslAction");
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_noticeloop_1=empty($TPL_VAR["noticeloop"])||!is_array($TPL_VAR["noticeloop"])?0:count($TPL_VAR["noticeloop"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 공지사항 List @@
- 파일위치 : [스킨폴더]/board/notice/default01/index.html
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

<?php if($TPL_VAR["noticeloop"]||$TPL_VAR["loop"]){?>
	<div class="res_table">
		<ul class="thead">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><li style="width:48px;"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvbm90aWNlL2RlZmF1bHQwMS9pbmRleC5odG1s" >번호</span></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?><li style="width:80px;"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvbm90aWNlL2RlZmF1bHQwMS9pbmRleC5odG1s" >분류</span></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?><li><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvbm90aWNlL2RlZmF1bHQwMS9pbmRleC5odG1s" >제목</span></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><li class="Hide" style="width:100px;"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvbm90aWNlL2RlZmF1bHQwMS9pbmRleC5odG1s" >작성자</span></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li style="width:100px;"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvbm90aWNlL2RlZmF1bHQwMS9pbmRleC5odG1s" >등록일</span></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li style="width:45px;"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvbm90aWNlL2RlZmF1bHQwMS9pbmRleC5odG1s" >조회</span></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li style="width:45px;"><?php echo $TPL_VAR["manager"]["scoretitle"]?></li><?php }?>
		</ul>
<?php if($TPL_VAR["noticeloop"]){?>
<?php if($TPL_noticeloop_1){foreach($TPL_VAR["noticeloop"] as $TPL_V1){?>
		<ul class="tbody notice">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><li class="num"><span class="mtitle" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvbm90aWNlL2RlZmF1bHQwMS9pbmRleC5odG1s" >공지</span> <?php echo $TPL_V1["number"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?><li><?php echo $TPL_V1["category"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?>
			<li class="subject">
				<span class="hand boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
					<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["blank"]?> <?php echo $TPL_V1["subjectcut"]?>

<?php if($TPL_V1["comment"]> 0){?><span class="comment">(<?php echo number_format($TPL_V1["comment"])?>)</span><?php }?>
					<?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?>

				</span>
			</li>
<?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><li class="Hide"><?php echo $TPL_V1["name"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li><?php echo date('Y.m.d',strtotime($TPL_V1["date"]))?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li><span class="mtitle" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvbm90aWNlL2RlZmF1bHQwMS9pbmRleC5odG1s" >조회:</span> <?php echo $TPL_V1["hit"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li><span class="mtitle"><?php echo $TPL_VAR["manager"]["scoretitle"]?>:</span> <?php echo $TPL_V1["recommendlay"]?></li><?php }?>
		</ul>
<?php }}?>
<?php }?>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<ul class="tbody">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><li class="mo_hide"><span class="mtitle" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvbm90aWNlL2RlZmF1bHQwMS9pbmRleC5odG1s" >번호:</span> <?php echo $TPL_V1["number"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?><li><?php echo $TPL_V1["category"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?>
			<li class="subject">
				<span class="hand boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
					<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["blank"]?> <?php echo $TPL_V1["subjectcut"]?>

<?php if($TPL_V1["comment"]> 0){?><span class="comment">(<?php echo number_format($TPL_V1["comment"])?>)</span><?php }?>
					<?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?>

				</span>
			</li>
<?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><li class="Hide"><?php echo $TPL_V1["name"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li><?php echo date('Y.m.d',strtotime($TPL_V1["date"]))?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li><span class="mtitle" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvbm90aWNlL2RlZmF1bHQwMS9pbmRleC5odG1s" >조회:</span> <?php echo $TPL_V1["hit"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li><span class="mtitle"><?php echo $TPL_VAR["manager"]["scoretitle"]?>:</span> <?php echo $TPL_V1["recommendlay"]?></li><?php }?>
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

<ul class="bbs_bottom_wrap hide">
	<li class="right">
		<button type="button" name="boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>" id="goods_boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" fileperm_read="<?php echo $TPL_VAR["manager"]["fileperm_write"]?>" class="btn_resp size_b color2 hidden" /><?php echo $TPL_VAR["manager"]["name"]?> 쓰기</button>
	</li>
</ul>



<div id="BoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3>비밀번호 확인</h3>
		<div>게시글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
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