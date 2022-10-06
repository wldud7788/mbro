<?php /* Template_ 2.2.6 2022/03/18 15:13:19 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/board/product_bbs/gallery02/index.html 000014318 */  $this->include_("sslAction");
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_noticeloop_1=empty($TPL_VAR["noticeloop"])||!is_array($TPL_VAR["noticeloop"])?0:count($TPL_VAR["noticeloop"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 사용자 생성 "갤러리형" 게시판 - List @@
- 파일위치 : [스킨폴더]/board/게시판아이디/gallery01/index.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<style type="text/css">
#subpageLNB, #subAllButton{ display:none; }
.subpage_wrap .subpage_container { padding-left:0; }
.custom_board_img_area { width:<?php echo ($TPL_VAR["manager"]["gallery_list_w"])?>px; }

@media only screen and (max-width:1023px) {
	.subpage_wrap .subpage_container { padding-left:10px; }
}
</style>

<?php if($TPL_VAR["viewlist"]!='view'){?>
<form name="boardsearch" id="boardsearch" >
	<input type="hidden" name="id" value="<?php echo $_GET["id"]?>" >
	<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>" >
	<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>" >
	<input type="hidden" name="goods_seq" value="<?php echo $_GET["goods_seq"]?>" >
	<input type="hidden" name="perpage" id="perpage" value="<?php echo $_GET["perpage"]?>" >
	<input type="hidden" name="page" id="page" value="<?php echo $_GET["page"]?>" >
	<input type="hidden" name="category" id="category" value="<?php echo $_GET["category"]?>" >

	<ul class="bbs_top_wrap gallery">
		<li class="left">
			<!-- 갤러리 타입 선택 -->
			<ul id="customGallerySort" class="custom_gallery_sort">
				<li class="sort_1 "><a href="#type1" hrefOri='I3R5cGUx' >가로형</a></li>
				<li class="sort_2 on"><a href="#type2" hrefOri='I3R5cGUy' >새로형</a></li>
				<li class="sort_3"><a href="#type3" hrefOri='I3R5cGUz' >이미지형</a></li>
			</ul>

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
				<input type="text" name="search_text" id="search_text" class="res_bbs_search_input" value="<?php echo $_GET["search_text"]?>" title="제목, 내용, 작성자" />
				<button type="submit" class="btn_resp size_b">검색</button>
				<button type="button" class="btn_resp size_b hide" onclick="document.location.href='<?php echo $TPL_VAR["boardurl"]->resets?>'">초기화</button>
			</span>
		</li>
	</ul>
</form>
<div class="article_info hide">
<?php if($TPL_VAR["sc"]["totalcount"]>$TPL_VAR["sc"]["searchcount"]){?>검색 <?php echo number_format($TPL_VAR["sc"]["searchcount"])?>개/<?php }?>총 <?php echo number_format($TPL_VAR["sc"]["totalcount"])?>개(현재 <?php if($TPL_VAR["sc"]["total_page"]== 0){?>0<?php }else{?><?php echo (($TPL_VAR["sc"]["page"]/$TPL_VAR["sc"]["perpage"])+ 1)?><?php }?>/총 <?php echo number_format($TPL_VAR["sc"]["total_page"])?>페이지)
</div>
<?php }?>

<?php if($TPL_VAR["noticeloop"]){?>
<div class="res_table custom_board_type1">
	<ul class="thead">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><li class="c_num">번호</li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?><li class="c_subject">제목</li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><li class="c_name">작성자</li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li class="c_date">등록일</li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li class="c_score"><?php echo $TPL_VAR["manager"]["scoretitle"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li class="c_hit">조회수</li><?php }?>
	</ul>
<?php if($TPL_noticeloop_1){foreach($TPL_VAR["noticeloop"] as $TPL_V1){?>
	<ul class="tbody notice">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><li class="c_num"><span class="c_mtitle">번호:</span> <?php echo $TPL_V1["number"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?>
		<li class="c_subject">
			<span class="hand boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="#"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>"><a><?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["blank"]?><?php echo $TPL_V1["category"]?> <?php echo $TPL_V1["subjectcut"]?> <?php if($TPL_V1["comment"]> 0){?><span class="comment">(<?php echo number_format($TPL_V1["comment"])?>)<?php }?><?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconvideo"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?></a></span></span>
		</li>
<?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><li class="c_name"><?php echo $TPL_V1["name"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li class="c_date"><?php echo date('Y.m.d',strtotime($TPL_V1["date"]))?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?><li class="c_score"><span class="c_mtitle"><?php echo $TPL_VAR["manager"]["scoretitle"]?>:</span> <?php echo $TPL_V1["recommendlay"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li class="c_hit"><span class="c_mtitle">조회:</span> <?php echo $TPL_V1["hit"]?></li><?php }?>
	</ul>
<?php }}?>
</div>
<?php }?>

<?php if($TPL_VAR["loop"]){?>
<ul id="customGalleryBoard" class="custom_gallery_board2" >
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<li onclick="openPopup('<?php echo $TPL_VAR["boardurl"]->view?><?php echo $TPL_V1["seq"]?>')" >
		<ul class="custom_board_img_area">
			<li >
<?php if($TPL_V1["file_key_w"]&&$TPL_V1["uccdomain_thumbnail"]){?>
				<span class="board_view_wrap boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="#" board_seq="<?php echo $TPL_V1["seq"]?>"  board_id="<?php echo $_GET["id"]?>"><img class="image_thumb" src="<?php echo $TPL_V1["uccdomain_thumbnail"]?>" designImgSrcOri='ey51Y2Nkb21haW5fdGh1bWJuYWlsfQ==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvcHJvZHVjdF9iYnMvZ2FsbGVyeTAyL2luZGV4Lmh0bWw=' designImgSrc='ey51Y2Nkb21haW5fdGh1bWJuYWlsfQ==' designElement='image' /></span>
<?php }elseif(strstr($TPL_V1["filelist"]['realfile'],'http')){?>
				<span class="board_view_wrap boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="#" board_seq="<?php echo $TPL_V1["seq"]?>"  board_id="<?php echo $_GET["id"]?>"><img class="image_thumb" src="http<?php echo str_replace('http','',$TPL_V1["filelist"]['realfile'])?>" designImgSrcOri='aHR0cHs9c3RyX3JlcGxhY2Uo' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvcHJvZHVjdF9iYnMvZ2FsbGVyeTAyL2luZGV4Lmh0bWw=' designImgSrc='aHR0cHs9c3RyX3JlcGxhY2Uo' designElement='image' /></span>
<?php }elseif(strstr($TPL_V1["filelist"]['realfile'],'/data/editor/')){?>
				<span class="board_view_wrap boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="#" board_seq="<?php echo $TPL_V1["seq"]?>"  board_id="<?php echo $_GET["id"]?>"><img class="image_thumb" src="<?php echo $TPL_V1["filelist"]['realfile']?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl_1/images/common/noimage.gif'" designImgSrcOri='ey5maWxlbGlzdFs=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvcHJvZHVjdF9iYnMvZ2FsbGVyeTAyL2luZGV4Lmh0bWw=' designImgSrc='ey5maWxlbGlzdFs=' designElement='image' /></span>
<?php }else{?>
				<span class="board_view_wrap boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="#" board_seq="<?php echo $TPL_V1["seq"]?>"  board_id="<?php echo $_GET["id"]?>"><img class="image_thumb" src="/data/board/<?php echo $_GET["id"]?>/<?php echo $TPL_V1["filelist"]['realfile']?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl_1/images/common/noimage.gif'" designImgSrcOri='L2RhdGEvYm9hcmQve19HRVQuaWR9L3suZmlsZWxpc3Rb' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvcHJvZHVjdF9iYnMvZ2FsbGVyeTAyL2luZGV4Lmh0bWw=' designImgSrc='L2RhdGEvYm9hcmQve19HRVQuaWR9L3suZmlsZWxpc3Rb' designElement='image' /></span>
<?php }?>
			</li>
		</ul>
		<ul class="text_area">
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?>
			<li class="c_subject boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="#"  viewtype="<?php echo $TPL_VAR["manager"]["viewtype"]?>"  pagetype="<?php echo $TPL_VAR["pagetype"]?>"  board_seq="<?php echo $TPL_V1["seq"]?>" board_id="<?php echo $_GET["id"]?>">
				<?php echo $TPL_V1["iconmobile"]?><?php echo $TPL_V1["subjectcut"]?> <?php if($TPL_V1["comment"]> 0){?><span class="comment">(<?php echo number_format($TPL_V1["comment"])?>)</span><?php }?> <?php echo $TPL_V1["iconimage"]?><?php echo $TPL_V1["iconfile"]?><?php echo $TPL_V1["iconvideo"]?><?php echo $TPL_V1["iconnew"]?><?php echo $TPL_V1["iconhot"]?><?php echo $TPL_V1["iconhidden"]?>

			</li>
<?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><li class="c_name"><?php echo $TPL_V1["name"]?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><li class="c_date"><?php echo date('Y.m.d',strtotime($TPL_V1["date"]))?></li><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[score]')&&$TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?>
			<li class="c_score">
				<?php echo $TPL_VAR["manager"]["scoretitle"]?>

<?php if($TPL_VAR["manager"]["auth_recommend_use"]=='Y'){?>
<?php if($TPL_VAR["manager"]["recommend_type"]=='3'){?>   
						<span class="idx-recommend1-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend1"])?></span>/<span class=" idx-recommend1-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend2"])?></span>/<span class=" idx-recommend1-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend3"])?></span>/<span class=" idx-recommend1-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend4"])?></span>/<span class=" idx-recommend1-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend5"])?></span>
<?php }elseif($TPL_VAR["manager"]["recommend_type"]=='2'){?>  
						<span class="idx-recommend-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend"])?></span>
						/
						<span class=" idx-none_rec-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["none_rec"])?></span>  
<?php }elseif($TPL_VAR["manager"]["recommend_type"]=='1'){?> 
							<span class=" idx-recommend-<?php echo $TPL_VAR["seq"]?>"><?php echo number_format($TPL_V1["recommend"])?></span>  
<?php }?>
<?php }?> 
			</li>
<?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><li class="c_hit">조회 <?php echo $TPL_V1["hit"]?></li><?php }?>
			<li class="c_short_code boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="#" board_seq="<?php echo $TPL_V1["seq"]?>"  board_id="<?php echo $_GET["id"]?>"><?php echo $TPL_V1["contentcut"]?></li>
			<li class="c_more boad_view_btn<?php echo $TPL_V1["isperm_read"]?>" viewlink="#" board_seq="<?php echo $TPL_V1["seq"]?>"  board_id="<?php echo $_GET["id"]?>">READ MORE</li>
		</ul>
	</li>
<?php }}?>
</ul>
<?php }else{?>
<div class="no_data_area2 gallery">
	등록된 게시글이 없습니다.
</div>
<?php }?>

<?php if($TPL_VAR["pagin"]){?>
<div id="pagingDisplay" class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
<?php }?>

<?php if($TPL_VAR["viewlist"]!='view'){?>
<ul class="bbs_bottom_wrap hide">
	<li class="right">
<?php if($TPL_VAR["manager"]["auth_write"]!='[admin]'){?>
		<button type="button" name="boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>" id="boad_write_btn<?php echo $TPL_VAR["manager"]["isperm_write"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" fileperm_read="<?php echo $TPL_VAR["manager"]["fileperm_write"]?>" class="btn_resp size_b color2" /><?php echo $TPL_VAR["manager"]["name"]?> 쓰기</button>
<?php }?>
	</li>
</ul>
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
		<input type="password" name="pw" id="pwck_pw" style="width:140px;" />
		<button type="submit" id="BoardPwcheckBtn" class="btn_resp size_b color2" />확인</button>
		<button type="button" class="btn_resp size_b" onclick="$('#BoardPwCk').dialog('close');" />취소</button>
	</div>
	</form>
</div>
<!-- //비밀번호 확인 -->

<script>
$(function() {
	// 갤러리 타입 선택
	$('#customGallerySort a').click(function() {
		$('#customGallerySort>li').removeClass('on');
		$(this).parent('li').addClass('on');
		switch ( this.hash ) {
			case '#type1' : $('#customGalleryBoard').removeClass().addClass('custom_gallery_board1'); break;
			case '#type2' : $('#customGalleryBoard').removeClass().addClass('custom_gallery_board2'); break;
			case '#type3' : $('#customGalleryBoard').removeClass().addClass('custom_gallery_board3'); break;
			default :$('#customGalleryBoard').removeClass().addClass('custom_gallery_board1'); break;
		}
		return false;
	});
});
</script>