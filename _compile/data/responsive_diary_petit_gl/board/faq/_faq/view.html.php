<?php /* Template_ 2.2.6 2020/10/15 17:39:14 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/board/faq/_faq/view.html 000006175 */  $this->include_("sslAction");
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);
$TPL_filelistimages_1=empty($TPL_VAR["filelistimages"])||!is_array($TPL_VAR["filelistimages"])?0:count($TPL_VAR["filelistimages"]);?>
<style type="text/css">
.bbsview_division { padding:10px 0 !important; border:none;}
.bbsview_top {padding:0 10px; height:30px; line-height:30px; }
.content { padding:10px; }
.cmt_division {border-top:1px solid #e6e6e6;}
.cmt_area { padding:10px; }
.cmt_reply { padding-left:20px; }
.cmt_contents { padding-top:0px; padding-bottom:10px; border-bottom:0px solid #e6e6e6; min-height:30px; }
.modify_contents { font-size:14px; color:#767575; cursor:pointer; }
.delete_contents { font-size:14px; color:#767575; cursor:pointer; }
.reply_stat td { height:25px; font-size:12px;}
.reply_stat td:first-child { border-right:1px solid #BDBDBD; }
</style>
<div class="bbsview_division">
	<div class="bbsview_top clearbox">
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"){?>
		<div class="fright">
			<span class="hand round_btn goods_boad_modify_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>" board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" alt="본문수정">
				<a>수정</a>
			</span>
			<span class="hand round_btn goods_boad_delete_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>" board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" alt="본문삭제">
				<a>삭제</a>
			</span>
		</div>
<?php }?>
	</div>

	<!-- 파일 리스트 -->
<?php if($TPL_VAR["file_key_i"]&&$TPL_VAR["uccdomain_fileurl"]){?>
		<div class="content" >
			<iframe   width="<?php if($TPL_VAR["manager"]["video_size_mobile0"]){?><?php echo $TPL_VAR["manager"]["video_size_mobile0"]?><?php }else{?>200<?php }?>" height="<?php if($TPL_VAR["manager"]["video_size_mobile1"]){?><?php echo $TPL_VAR["manager"]["video_size_mobile1"]?><?php }else{?>150<?php }?>" src="<?php echo $TPL_VAR["uccdomain_fileurl"]?>&g=tag&width=<?php echo $TPL_VAR["manager"]["video_size_mobile0"]?>&height=<?php echo $TPL_VAR["manager"]["video_size_mobile1"]?>" frameborder="0" allowfullscreen></iframe>
		</div>
<?php }elseif($TPL_VAR["file_key_w"]&&$TPL_VAR["uccdomain_fileurl"]){?>
		<div class="content" >
			<iframe   width="<?php if($TPL_VAR["manager"]["video_size_mobile0"]){?><?php echo $TPL_VAR["manager"]["video_size_mobile0"]?><?php }else{?>200<?php }?>" height="<?php if($TPL_VAR["manager"]["video_size_mobile1"]){?><?php echo $TPL_VAR["manager"]["video_size_mobile1"]?><?php }else{?>150<?php }?>" src="<?php echo $TPL_VAR["uccdomain_fileurl"]?>&g=tag&width=<?php echo $TPL_VAR["manager"]["video_size_mobile0"]?>&height=<?php echo $TPL_VAR["manager"]["video_size_mobile1"]?>" frameborder="0" allowfullscreen></iframe>
		</div>
<?php }?>

<?php if($TPL_VAR["filelist"]){?>
	<div class="content">
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
		<span class="realfilelist hand highlight-link" realfiledir="<?php echo $TPL_V1["realfiledir"]?>" realfilename="<?php echo $TPL_V1["orignfile"]?>"  realfilename="<?php echo $TPL_V1["orignfile"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" filedown="../board_process?mode=board_file_down&board_id=<?php echo $TPL_VAR["boardid"]?>&realfiledir=<?php echo $TPL_V1["realfiledir"]?>&realfilename=<?php echo $TPL_V1["orignfile"]?>"><?php echo $TPL_V1["orignfile"]?> (<span class="size"><?php echo $TPL_V1["realsizefile"]?></span>) <button type="button"  class="bbs_btn">down</button></span>
<?php }}?>
	</div>
<?php }?>

	<!-- 내용 -->
	<div class="content" style="min-height:50px;word-wrap:break-word;">
		<?php echo $TPL_VAR["contents"]?>

	</div>

	<!-- 모바일등록시 첨부파일의 이미지다운 -->
<?php if($TPL_VAR["filelistimages"]&&$TPL_VAR["insert_image"]=='none'&&$TPL_VAR["editor"]!= 1){?>
	<div class="content">
<?php if($TPL_filelistimages_1){foreach($TPL_VAR["filelistimages"] as $TPL_V1){?>
		<span class="realfilelist hand highlight-link" realfiledir="<?php echo $TPL_V1["realfiledir"]?>" realfilename="<?php echo $TPL_V1["orignfile"]?>"  realfilename="<?php echo $TPL_V1["orignfile"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" filedown="../board_process?mode=board_file_down&board_id=<?php echo $TPL_VAR["boardid"]?>&realfiledir=<?php echo $TPL_V1["realfiledir"]?>&realfilename=<?php echo $TPL_V1["orignfile"]?>"><?php echo $TPL_V1["orignfile"]?> (<span class="size"><?php echo $TPL_V1["realsizefile"]?></span>) <button type="button"  class="bbs_btn">down</button></span>
<?php }}?>
	</div>
<?php }?>
	<!-- 모바일등록시 첨부파일의 이미지다운 -->

<?php if($TPL_VAR["managerview"]["auth_recommend_use"]=='Y'){?>
	<!-- 게시글평가 -->
	<div class="scorelay"  style="margin: 15px 0 5px"><?php $this->print_("scoreskin",$TPL_SCP,1);?></div>
	<!-- 게시글평가 -->
<?php }?>  

<?php if($TPL_VAR["commentlay"]=='Y'||$TPL_VAR["comment"]> 0){?>
	<div class="content">
		<a name="cmtlist"></a>
		<div class="comment"  id="comment_container" style="margin: 15px 0 5px"><?php $this->print_("commentskin",$TPL_SCP,1);?></div>
	</div>
<?php }?>
</div>

<?php if(!$TPL_VAR["pagemode"]){?>
<div >
	<!-- 이전/다음 -->
	<div id="prenextlist"  style="margin: 15px 0 5px"><?php $this->print_("prenextskin",$TPL_SCP,1);?></div>
	<!-- 이전/다음 -->
</div>
<?php }?>

<!-- 컨트롤 폼 : 시작 -->
<form name="writeform" id="writeform" method="post" action="<?php echo sslAction('../board_process')?>"  enctype="multipart/form-data" target="comentFrame">
<input type="hidden" name="board_id" id="board_id" value="<?php echo $_GET["id"]?>" />
<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>" >
<input type="hidden" name="delseq" id="seq" value="" />
<input type="hidden" name="real_name" id="real_name" value="" />
</form>
<!-- 컨트롤 폼 : 끝 -->