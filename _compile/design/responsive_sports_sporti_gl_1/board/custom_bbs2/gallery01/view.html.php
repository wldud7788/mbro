<?php /* Template_ 2.2.6 2022/03/18 15:13:18 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/board/custom_bbs2/gallery01/view.html 000009599 */  $this->include_("sslAction","snslinkurl");
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<style type="text/css">
#subpageLNB, #subAllButton { display:none; }
.subpage_wrap .subpage_container { padding-left:0; }
@media only screen and (max-width:1023px) {
	.subpage_wrap .subpage_container { padding-left:10px; }
}
</style>

<form name="form1" id="form1" method="post" action="<?php echo sslAction('../board_process')?>"  target="actionFrame">
	<input type="hidden" name="mode" id="mode" value="<?php echo $TPL_VAR["mode"]?>" />
	<input type="hidden" name="board_id" id="board_id" value="<?php echo $_GET["id"]?>" />
	<input type="hidden" name="reply" id="reply" value="<?php echo $_GET["reply"]?>" />
<?php if($TPL_VAR["seq"]){?>
	<input type="hidden" name="seq" id="board_seq" value="<?php echo $TPL_VAR["seq"]?>" />
<?php }?>
	<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>" >
	<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>" >
	<input type="hidden" name="goods_seq" value="<?php echo $_GET["goods_seq"]?>" >

	<div class="gallery_detail_title">
<?php if($TPL_VAR["datacategory"]){?>[<?php echo $TPL_VAR["datacategory"]?>]<?php }?> <?php echo $TPL_VAR["iconmobile"]?> <?php echo $TPL_VAR["subject"]?> <?php echo $TPL_VAR["iconnew"]?> <?php echo $TPL_VAR["iconhot"]?> <?php echo $TPL_VAR["iconhidden"]?>

	</div>
	<ul class="gallery_detail_desc">
		<li><?php echo $TPL_VAR["name"]?></li>
		<li><?php echo $TPL_VAR["r_date"]?></li>
		<li>์กฐํ์ <?php echo number_format($TPL_VAR["hit"])?></li>
	</ul>
<?php if($TPL_VAR["filelist"]){?>
	<ul class="gallery_detail_filelist">
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
		<li>
			<span class="realfilelist hand highlight-link" realfiledir="<?php echo $TPL_V1["realfiledir"]?>" realfilename="<?php echo $TPL_V1["orignfile"]?>"  realfilename="<?php echo $TPL_V1["orignfile"]?>" board_id="<?php echo $_GET["id"]?>" filedown="../board_process?mode=board_file_down&board_id=<?php echo $_GET["id"]?>&realfiledir=<?php echo $TPL_V1["realfiledir"]?>&realfilename=<?php echo $TPL_V1["orignfile"]?>"><?php echo $TPL_V1["orignfile"]?> (<span class="size"><?php echo $TPL_V1["realsizefile"]?></span>) <button type="button"  class="bbs_btn">down</button></span>
<?php if($TPL_V1["is_image"]){?>
				<span class="hand" imgsrc="<?php echo $TPL_V1["realfile"]?>" onclick="board_file_review('<?php echo $TPL_V1["realfile"]?>','<?php echo $TPL_V1["imagesize"][ 0]?>','<?php echo $TPL_V1["imagesize"][ 1]?>');" ><img src="/data/skin/responsive_sports_sporti_gl_1/images/icon/icon_zoom.gif" hspace="1" title="๋ฏธ๋ฆฌ๋ณด๊ธฐ" designImgSrcOri='Li4vLi4vLi4vaW1hZ2VzL2ljb24vaWNvbl96b29tLmdpZg==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvYm9hcmQvY3VzdG9tX2JiczIvZ2FsbGVyeTAxL3ZpZXcuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMS9pbWFnZXMvaWNvbi9pY29uX3pvb20uZ2lm' designElement='image' /></span>
<?php }?>
		</li>
<?php }}?>
	</ul>
<?php }?>
	
<?php if($TPL_VAR["file_key_w"]&&$TPL_VAR["uccdomain_fileswf"]){?>
	<div class="board_detail_contents">
		<embed src="<?php echo $TPL_VAR["uccdomain_fileswf"]?>" width="<?php echo $TPL_VAR["managerview"]["video_size0"]?>" height="<?php echo $TPL_VAR["managerview"]["video_size1"]?>" allowfullscreen="true" wmode="transparent"></embed>
	</div>
<?php }?>

	<div class="board_detail_contents">
		<?php echo $TPL_VAR["contents"]?>

	</div>

<?php if($TPL_VAR["managerview"]["auth_recommend_use"]=='Y'){?>
	<div class="c_scorelay"><?php $this->print_("scoreskin",$TPL_SCP,1);?></div>
<?php }?>
	
	<div class="board_sns_link">
		<?php echo snslinkurl('board',$TPL_VAR["subject"])?>

	</div>
</form>


<?php if($TPL_VAR["commentlay"]=='Y'||$TPL_VAR["comment"]> 0){?>
<a name="cmtlist"></a>
<div class="board_comment_area"  id="comment_container"><?php $this->print_("commentskin",$TPL_SCP,1);?></div>
<?php }?>

<!-- ์ด์?/๋ค์ ๊ธ -->
<div id="prenextlist" class="board_prev_next_list">
<?php $this->print_("prenextskin",$TPL_SCP,1);?>

</div>

<!-- ํ๋จ ๊ฐ์ข ๋ฒํผ -->
<ul class="board_detail_btns">
	<li class="left"><button type="button" name="boardviewclose" class="btn_resp size_b color5">๋ชฉ๋ก</button></li>
	<li class="right">
<?php if($TPL_VAR["manager"]["auth_write"]!='[admin]'){?>
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"){?>
			<button type="button" name="boad_modify_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>" board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b">์์?</button>
<?php }?>
<?php }?>
<?php if((($TPL_VAR["display"]== 0||($TPL_VAR["display"]== 1&&$TPL_VAR["replyor"]== 0&&$TPL_VAR["comment"]== 0)))&&$TPL_VAR["managerview"]["isperm_moddel"]!="_mbno"){?>
		<button type="button"  name="boad_delete_btn<?php echo $TPL_VAR["managerview"]["isperm_moddel"]?>"  board_seq="<?php echo $TPL_VAR["seq"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b">์ญ์?</button>
<?php }?>
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["replylay"]=='Y'&&$TPL_VAR["managerview"]["isperm_write"]!="_no"){?>
		<button type="button" name="boad_reply_btn" board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b">๋ต๋ณ</button>
<?php }?>
<?php if($TPL_VAR["manager"]["auth_write"]!='[admin]'){?>
<?php if($TPL_VAR["managerview"]["isperm_write"]!="_no"){?>
			<button type="button" name="boad_write_btn<?php echo $TPL_VAR["managerview"]["isperm_write"]?>" id="boad_write_btn<?php echo $TPL_VAR["managerview"]["isperm_write"]?>"  board_id="<?php echo $TPL_VAR["boardid"]?>" class="btn_resp size_b color2"><?php echo $TPL_VAR["manager"]["name"]?> ์ฐ๊ธฐ</button>
<?php }?>
<?php }?>
	</li>
</ul>


<div id="CmtBoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3> ๋น๋ฐ๋ฒํธ ํ์ธ</h3>
		<div style="padding:10px 0 0;">๋๊ธ ๋ฑ๋ก์์ ์๋?ฅํ๋ ๋น๋ฐ๋ฒํธ๋ฅผ ์๋?ฅํด ์ฃผ์ธ์.</div>
	</div>
	<form name="BoardPwcheckForm" id="CmtBoardPwcheckForm" method="post" >
	<input type="hidden" name="seq" id="cmt_pwck_seq" value="" />
	<input type="hidden" name="cmtseq" id="cmt_pwck_cmtseq" value="" />
	<div class="ibox">
		<input type="password" name="pw" id="cmt_pwck_pw" style="width:140px;" />
		<button type="submit" id="CmtBoardPwcheckBtn" class="btn_resp size_b color2" />ํ์ธ</button>
		<button type="button" class="btn_resp size_b" onclick="$('#CmtBoardPwCk').dialog('close');" />์ทจ์</button>
	</div>
	</form>
</div>
<!-- //๋๊ธ ๋นํ์ ๋น๋ฐ๋ฒํธ ํ์ธ -->

<div id="ModDelBoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<h3> ๋น๋ฐ๋ฒํธ ํ์ธ</h3>
		<div style="padding:10px 0 0;">๊ฒ์๊ธ ๋ฑ๋ก์์ ์๋?ฅํ๋ ๋น๋ฐ๋ฒํธ๋ฅผ ์๋?ฅํด ์ฃผ์ธ์.</div>
	</div>
	<form name="ModDelBoardPwcheckForm" id="ModDelBoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame " >
	<input type="hidden" name="modetype" id="modetype" value="" />
	<input type="hidden" name="seq" id="moddel_pwck_seq" value="" />
	<input type="hidden" name="returnurl" id="moddel_pwck_returnurl" value="" />
	<div class="ibox">
		<input type="password" name="pw" id="moddel_pwck_pw" style="width:140px;" />
		<button type="submit" id="BoardPwcheckBtn" class="btn_resp size_b color2" />ํ์ธ</button>
		<button type="button" class="btn_resp size_b" onclick="$('#ModDelBoardPwCk').dialog('close');" />์ทจ์</button>
	</div>
	</form>
</div>
<!-- //๊ฒ์๊ธ ๋นํ์ ๋น๋ฐ๋ฒํธ ํ์ธ -->

<script type="text/javascript">
	function getboardLogin(){
<?php if(defined('__ISUSER__')===true){?>
			//ํด๋น ์๋น์ค๋ฅผ ์ด์ฉํ์๋?ค๋ฉด ๊ด๋ฆฌ์์๊ฒ ๋ฌธ์ํ์ฌ ์ฃผ์๊ธธ ๋ฐ๋๋๋ค.
			openDialogAlert(getAlert('et366'),'450','140');
<?php }else{?>
			//์ด์ฉํ์๋?ค๋ฉด ๋ก๊ทธ์ธ์ด ํ์ํฉ๋๋ค!<br/>๋ก๊ทธ์ธํ์๊ฒ?์ต๋๊น?
			openDialogConfirm(getAlert('et367'),'400','155',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
	}

	function getcmtMbLogin(){
<?php if(defined('__ISUSER__')===true){?>
			//๊ธ์์ฑ์๋ง ์ด์ฉ๊ฐ๋ฅํฉ๋๋ค.
			openDialogAlert(getAlert('et368'),'400','140');
<?php }else{?>
			//์ด์ฉํ์๋?ค๋ฉด ๋ก๊ทธ์ธ์ด ํ์ํฉ๋๋ค!<br/>๋ก๊ทธ์ธํ์๊ฒ?์ต๋๊น?
			openDialogConfirm(getAlert('et367'),'400','155',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
	}

	$(window).load(function () {
		//์ด๋ฏธ์ง ๊ฐ๋ก๊ฐ ํฐ๊ฒฝ์ฐ
		$(".content img").each(function() {
<?php if($TPL_VAR["layout_config"]["layoutScrollLeft"]!='hidden'||$TPL_VAR["layout_config"]["layoutScrollRight"]!='hidden'){?>
				var default_width = '<?php echo $TPL_VAR["layout_config"]["body_width"]- 100?>';//(๋ณธ๋ฌธ๋?์ด์์์ฌ์ด์ฆ-100) ๋๋ ์ง์?๊ฐ๋ณ๊ฒฝ
<?php }else{?>
				var default_width = '<?php echo $TPL_VAR["layout_config"]["body_width"]- 50?>';//(๋ณธ๋ฌธ๋?์ด์์์ฌ์ด์ฆ-50) ๋๋ ์ง์?๊ฐ๋ณ๊ฒฝ
<?php }?>
			if( $(this).width() > default_width || $(this).height() > default_width ) {
				imageResize(this,default_width);
			}
		});
	});
</script>