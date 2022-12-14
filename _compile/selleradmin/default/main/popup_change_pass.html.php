<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/main/popup_change_pass.html 000003944 */ ?>
<style>
.login_txt {margin:1px; border:1px solid #c5c9ce !important; cursor:default; width:180px; height:12px;}
.login_txt:focus {margin:0px; border:1px solid #434b55 !important; cursor:text; width:180px; height:12px;}
.tab1_y th { width:160px; padding: 8px 5px; vertical-align: top; font:11px Dotum; letter-spacing:-1px;}
</style>


<form name="loginForm" id="loginForm" method="post" action="../login_process/change_pass" target="actionFrame">
<input type="hidden" name="provider_seq" value="<?php echo $TPL_VAR["providerInfo"]["provider_seq"]?>" />
<div style="margin:0 auto; font:12px/1.5em Dotum; width:98%;text-align:left;padding:0px 10px; letter-spacing:-1px">
<?php if($_GET["required"]){?>
	정보통신망 이용촉진 및 정보보호 등에 관한 법률에 따른 방통위 시행령에 따라 개인정보 보호 책임자의 비밀번호는 8자 이상의<br>영문 대소문자 또는 숫자, 특수문자 중 2가지 이상을 조합해서 만들어야 합니다. 
<?php }else{?>
	정보통신망 이용촉진 및 정보보호 등에 관한 법률에 따른 방통위 시행령에 따라 개인정보 보호 책임자의 비밀번호는 8자 이상의<br>영문 대소문자 또는 숫자, 특수문자 중 2가지 이상을 조합해서 만들어야 하며 주기적(90일)으로 변경을 하셔야 합니다.
<?php }?>
</div>
<!--<div style="height:15px; border-top:1px solid #dcdcdc; margin-top:15px"></div>-->
<table width="100%"  style="background:#f7f7f7; border-top:1px solid #dcdcdc; border-bottom:1px solid #dcdcdc; margin:10px 0; padding-top:10px">
<tr>
	<td align="left">
	<table width="650" cellpadding="0" cellspacing="0">
	<tr class="tab1_y">
		<th align="left">현재 비밀번호</td>
		<td align="left">
			<input type="password" name="now_passwd" class="login_txt passwordField" />
		</td>		
	</tr>
	<tr class="tab1_y"><td colspan="3" height="8"><td></tr>
	<tr class="tab1_y">
		<th align="left">새 비밀번호</td>
		<td align="left">
			<input type="password" name="new_passwd" class="login_txt passwordField class_check_password_validation" />
			<span class="red bold"></span>
		</td>
	</tr>
	<tr class="tab1_y"><td colspan="3" height="8"><td></tr>
	<tr class="tab1_y">
		<th align="left">새 비밀번호 확인</td>
		<td align="left">
			<input type="password" name="re_passwd" class="login_txt passwordField" />
			<span class="red bold"></span>
		</td>
	</tr>
	<tr><td colspan="2" height="5"><td></tr>
	</table>
	</div>
	</td>
</tr>
</table> 

<div class="desc">
※ 8~20자, 영문 대소문자 또는 숫자, 특수문자 중 2가지 이상 조합<br>
※ 사용 가능 특수문자 : ! # $ % & ( ) * + - / : = > ? @ [ ＼ ] ^ _ { | } ~ 
</div>

<div class="pdt20" align="center">
<span class="btn large cyanblue"><input type="submit" value="지금 변경"></span>
<?php if(!$_GET["required"]){?>
<span class="btn large gray"><input type="button" value="90일 이후 변경" onclick="change_pass_date()"></span>
<?php }?>
</div>

<?php if($_GET["required"]){?>
<div align="center" class="pdt20" style="font:12px/1.5em Dotum; letter-spacing:-1px">
	현재 6개월 동안 비밀번호를 변경하지 않으셨습니다. 귀사 쇼핑몰의 보안을 위해 반드시 변경해 주십시오.
</div>
<?php }?>

</form>
<script type="text/javascript">

function change_pass_date(){
	$("input[name='now_passwd']").val('');
	$("input[name='new_passwd']").val('');
	$("input[name='re_passwd']").val('');
	$(".passwordField").attr("disabled",true);
	$("#loginForm").attr("action","/selleradmin/login_process/change_pass_date");
	$("#loginForm").submit();
}

$(".class_check_password_validation").each(function(){
    init_check_password_validation($(this));
});

</script>