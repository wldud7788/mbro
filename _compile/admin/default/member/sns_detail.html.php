<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/member/sns_detail.html 000003035 */ ?>
<style>
.ui-dialog { background-color:#fff;border:2px solid #434444;padding:0px;width:300px; position: absolute; z-index: 10002; display: block;}
table.in-sns {border:1px solid #f1f1f1; border-collapse: collapse; background-color:#ffffff;}
table.in-sns th { background-color:#f1f1f1; padding:3px;border-bottom:1px solid #fff; color:#000000;}
table.in-sns td { padding:3px;padding-left:10px; border-bottom:1px solid #f1f1f1;text-align:left;}
.ui-dialog-titlebar { height:37px; }
.ui-dialog .ui-dialog-titlebar-close { top: 42%; }
.ui-dialog-titlebar .ui-dialog-title{ line-height:28px; }

</style>

<script type="text/javascript">
	$(function(){
		$(".ui-dialog-titlebar-close").bind("click",function(){
<?php if($TPL_VAR["no"]){?>
			$("div#snsdetailPopup<?php echo $TPL_VAR["no"]?>").hide();
<?php }else{?>
			$("div#snsdetailPopup_<?php echo $TPL_VAR["snscd"]?>").hide();
<?php }?>
		});
	});
</script>

<!-- sns 연동 정보 상세 -->
<div tabindex="-1" class="ui-dialog ui-widget ui-widget-content ui-corner-all" role="dialog" aria-labelledby="ui-dialog-title-snsdetailPopup">

	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span class="ui-dialog-title" id="ui-dialog-title-snsdetailPopup"><img src="/admin/skin/default/images/sns/sns_<?php echo substr($TPL_VAR["snscd"], 0, 1)?>0.gif" align="absmiddle"> <?php echo $TPL_VAR["data"]["rute_nm"]?> 정보</span>
		<a class="ui-dialog-titlebar-close ui-corner-all hand" role="button"><span class="ui-icon ui-icon-closethick">close</span></a>
	</div>
	<table width="100%" class="in-sns" >
		<col width="100" />
<?php if($TPL_VAR["data"]["message"]){?>
		<tr>
			<td colspan="2" colspan="center">연동 해제된 계정입니다.</td>
		</tr>
<?php }else{?>
<?php if($TPL_VAR["data"]["email"]){?>
			<tr>
				<th>이메일</th>
				<td><?php echo $TPL_VAR["data"]["email"]?></td>
			</tr>
<?php }?>
<?php if($TPL_VAR["data"]["user_name"]){?>
			<tr>
				<th>이름(닉네임)</th>
				<td><?php echo $TPL_VAR["data"]["user_name"]?></td>
			</tr>
<?php }?>
<?php if($TPL_VAR["data"]["sex"]){?>
			<tr>
				<th>성별</th>
				<td><?php echo $TPL_VAR["data"]["sex"]?></td>
			</tr>
<?php }?>
<?php if($TPL_VAR["data"]["birthday"]){?>
			<tr>
				<th>생일</th>
				<td><?php echo $TPL_VAR["data"]["birthdayV"]?></td>
			</tr>
<?php }?>
<?php if($TPL_VAR["data"]["rute"]=="facebook"){?>
			<tr>
				<th>프로필보기</th>
				<td><a href="https://facebook.com/profile.php?id=<?php echo $TPL_VAR["data"]["sns_f"]?>" target="_blank"><u>프로필 보기</u></a></td>
			</tr>
<?php }?>
<?php }?>
<?php if($TPL_VAR["member_seq"]){?>
		<tr>
			<th>회원상세</th>
			<td><a href="/admincrm/main/user_detail?member_seq=<?php echo $TPL_VAR["member_seq"]?>" target="_blank"><u>바로가기</u></a></td>
		</tr>
<?php }?>
	</table>

</div>