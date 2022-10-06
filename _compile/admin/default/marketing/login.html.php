<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/marketing/login.html 000003676 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<style>
.login_txt {margin:0px; border:1px solid #c5c9ce !important; cursor:default; width:180px; height:12px;}
.login_txt:focus {margin:0px; border:1px solid #434b55 !important; cursor:text; width:180px; height:12px;}

</style>

<script type="text/javascript">
$(document).ready(function() {
	
	/* 아이프레임일경우 레이아웃 숨김 */
	if(parent.window.document != document){
		$("#layout-header").hide();
		$("#Footer").hide();
	}

});
</script>

<div class="Index" id="Index">
<form name="loginForm" id="loginForm" method="post" action="/admin/marketing_process/login" target="actionFrame">
<input type="hidden" name="vcode" value="<?php echo $_GET["v"]?>"/>

<table width="100%" height="500">
<tr>
	<td align="center">

	<div style="padding-bottom:15px;font-size:18px;font-weight:bold;">제휴사 로그인</div>
	
	<div style="border:3px solid #b8b8b8;width:320px;">
					
		<table width="280" cellpadding="0" cellspacing="0">
		<tr><td colspan="2" height="20"></td></tr>
		<tr>
			<td align="left">
				<input type="text" name="id" class="login_txt" tabindex="1" title="아이디" />
			</td>
			<td rowspan="3" align="right">
				<input type="image" src="/admin/skin/default/images/common/login_btn.gif" style="cursor:pointer;" class="submit_btn" tabindex="3">
			</td>
		</tr>
		<tr><td colspan="3" height="8"><td></tr>
		<tr>
			<td align="left">
				<input type="password" name="pw" class="login_txt" tabindex="2" title="비밀번호" />
			</td>
		</tr>
		<tr><td colspan="2" height="20"></td></tr>
		</table>
	
	</div>

	</td>
</tr>
</table> 

</form>
</div>




<div class="Footer" id="Footer">
<table width="100%" height="100%">
<tr><td height="1" bgcolor="#e0e0e0"></td></tr>
<tr><td height="5"></td></tr>
<tr>
	<td>

	<table width="100%">
	<tr> 
		<td width="95" align="center"><img src="/admin/skin/default/images/common/logo_gabia.gif"></td>
		<td align="left" style="font-family:'돋움',Dotum,AppleGothic,sans-serif;font-size:11px;letter-spacing:-1px;">Copyrightⓒ <b>GABIA.</b> All Right Reserved.</td>
		<td align="right" style="font-family:'돋움',Dotum,AppleGothic,sans-serif;font-size:11px;letter-spacing:-1px;padding-right:10px;"><b>퍼스트몰</b>, 오직 운영자만을 생각한 가장 앞선 쇼핑몰입니다.</td>
	</tr>
	</table>

	</td>
</tr>
</table>
</div>


<script>
// 반드시 본문 내용 중에 id : Index, Footer가 있어야 함.
/*
var Height_Index	= Number(document.getElementById("Index").clientHeight);	// Min-Height를 지정해 주기 위해 기존 Default Height를 저장
window.onload		= changeContentSize;										// Window 창 로드시
window.onresize		= changeContentSize;										// Window 창 크기를 조정할때마다
$("body").css("overflow-y","hidden");
$("body").css("overflow-x","hidden");
function changeContentSize() {
	var Height_Window			= Number(document.documentElement.clientHeight);			// Window 창 높이
	var Height_Footer			= Number(document.getElementById("Footer").clientHeight);	// Footer 높이 구하기
	var ContentTop = Height_Window - Height_Footer - 80;										// 5 = Margin + Padding + Border of Top, Bottom
	document.getElementById("Index").style.minHeight = Height_Index + 'px';					// Index에 Min-Height 적용
	document.getElementById("Index").style.height = ContentTop + "px";						// Index 높이 변경
}
*/
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>