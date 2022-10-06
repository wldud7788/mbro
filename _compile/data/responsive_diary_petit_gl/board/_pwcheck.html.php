<?php /* Template_ 2.2.6 2020/10/15 17:39:14 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/board/_pwcheck.html 000003148 */  $this->include_("sslAction");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 게시판 비밀번호 확인 @@
- 파일위치 : [스킨폴더]/board/_pwcheck.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript">
//<![CDATA[
var board_id = '<?php echo $_GET["id"]?>';
var boardlistsurl = '<?php echo $TPL_VAR["boardurl"]->lists?>';
var boardwriteurl = '<?php echo $TPL_VAR["boardurl"]->write?>';
var boardviewurl = '<?php echo $TPL_VAR["boardurl"]->view?>';
var boardmodifyurl = '<?php echo $TPL_VAR["boardurl"]->modify?>';
var boardreplyurl = '<?php echo $TPL_VAR["boardurl"]->reply?>';
var boardrpermurl = '<?php echo $TPL_VAR["boardurl"]->perm?>';
//]]>
</script>
<script type="text/javascript" src="/app/javascript/js/board.js?v=7"  charset="utf-8"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="utf-8"></script>
<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"  charset="utf-8"></script>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td height="30"></td>
</tr>
<tr>
	<td width="40"></td>
	<td>
		<!-- 본문내용 시작 -->
		<div id="chkbox">

			<div class="msg">
				<h3> 비밀번호 확인</h3>
				<div>게시글 등록시에 입력했던 비밀번호를 입력해 주세요.</div>
			</div>


			<form name="BoardPwcheckForm" id="BoardPwcheckForm" method="post" action="<?php echo sslAction('../board_process')?>" target="actionFrame " >
			<input type="hidden" name="mode" value="board_hidden_pwcheck" />
			<input type="hidden" name="seq" id="pwck_seq" value="<?php echo $_GET["seq"]?>" />
			<input type="hidden" name="returnurl" id="pwck_returnurl" value="<?php if($TPL_VAR["returnurl"]){?><?php echo urldecode($TPL_VAR["returnurl"])?><?php }elseif($_GET["returnurl"]){?><?php echo urldecode($_GET["returnurl"])?><?php }else{?><?php echo $_SERVER["HTTP_REFERER"]?><?php }?>" />
			<div class="ibox">
				<input type="password" name="pw" id="pwck_pw" class="input" />
				<input type="submit" id="BoardPwcheckBtn" value=" 확인 " class="hand round_btn " />
				<input type="button" value=" 취소 " class="hand round_btn " onclick="document.location.href='<?php echo $TPL_VAR["boardurl"]->lists?>';" />
			</div>
			</form>
		</div>

		<style type="text/css">
		#chkbox {border:#dfdfdf solid 1px;width:350px;padding:20px 10px 20px 10px;margin:40px auto 40px auto;}
		#chkbox .msg {}
		#chkbox .msg h3 {margin:0;padding:0 0 9px 0;font-size:14px;font-weight:bold;font-family:"malgun gothic","dotum";border-bottom:#dfdfdf dashed 1px;}
		#chkbox .msg h3 img {position:relative;top:3px;}
		#chkbox .msg div {padding:10px 0 0 22px;color:#999;}
		#chkbox .ibox {padding:30px 0 10px 22px;}
		#chkbox .input {width:150px;}
		#chkbox .btnblue {width:80px;}
		</style>

		<!-- 본문내용 끝 -->
	</td>
	<td width="40"></td>
</tr>
</table> </td>
</tr>
</table>