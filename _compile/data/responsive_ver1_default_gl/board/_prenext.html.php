<?php /* Template_ 2.2.6 2021/12/15 17:48:34 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/board/_prenext.html 000001981 */  $this->include_("sslAction");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 게시판 이전글/다음글 @@
- 파일위치 : [스킨폴더]/board/_prenext.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<ul>
<?php if($TPL_VAR["nextlay"]){?>
<li>
	<span class="pnl_icon"><img src="/data/skin/responsive_ver1_default_gl/board/<?php echo $TPL_VAR["templateskin"]?>/images/board/btn/btn_bbs_icon_prev.gif" /></span>
	<span class="pnl_desc">다음글</span>
	<span class="pnl_title"><?php echo $TPL_VAR["nextlay"]["subject"]?></span>
	<!--span class="pnl_name"><?php echo $TPL_VAR["nextlay"]["name"]?></span-->
</li>
<?php }?>
<?php if($TPL_VAR["prelay"]){?>
<li>
	<span class="pnl_icon"><img src="/data/skin/responsive_ver1_default_gl/board/<?php echo $TPL_VAR["templateskin"]?>/images/board/btn/btn_bbs_icon_next.gif" /></span>
	<span class="pnl_desc">이전글</span>
	<span class="pnl_title"><?php echo $TPL_VAR["prelay"]["subject"]?></span>
	<!--span class="pnl_name"><?php echo $TPL_VAR["prelay"]["name"]?></span-->
</li>
<?php }?>
</ul>


<div id="BoardPwCk" class="hide BoardPwCk">
	<div class="msg">
		<div>게시글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
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