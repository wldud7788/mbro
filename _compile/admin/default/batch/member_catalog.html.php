<?php /* Template_ 2.2.6 2021/11/16 10:32:32 /www/music_brother_firstmall_kr/admin/skin/default/batch/member_catalog.html 000003106 */ ?>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/memberList.js?mm=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		memberList.init({'auth_arr':'<?php echo $TPL_VAR["auth_arr"]?>','batch_mode':true});
	});
</script>

<div class="content">	
	<form name="batchMemberForm" id="batchMemberForm" class="search_form">	
	<input type="hidden" name="member_seq" />
	<input type="hidden" name="orderby" value="<?php echo $TPL_VAR["sc"]["orderby"]?>"/>
	<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sc"]["sort"]?>"/>
	<input type="hidden" name="searchcount" value="<?php echo $TPL_VAR["sc"]["searchcount"]?>"/>
	<input type="hidden" name="type" />
	<input type="hidden" name="perpage"  id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" />
	<input type="hidden" name="callPage" id="callPage" value="<?php echo $TPL_VAR["callPage"]?>" />
	<input type="hidden" name="callType" id="callType" value="<?php echo $TPL_VAR["callType"]?>" />
	<input type="hidden" name="dormancy_count" value="<?php echo $TPL_VAR["dormancy_count"]?>">
	<input type="hidden" name="member_grade_seq" value="<?php echo $TPL_VAR["member_grade_seq"]?>">
	<input type="hidden" name="member_grade_name" value="<?php echo $TPL_VAR["member_grade_name"]?>">
	<textarea id="scObj" class="hide"><?php echo $TPL_VAR["scObj"]?></textarea>

	<div id="batch_search_container" class="search_container">
<?php $this->print_("member_search",$TPL_SCP,1);?>

	</div> 

	<div class="contents_container">	
<?php $this->print_("member_list",$TPL_SCP,1);?>

		<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
	</div>
	
<?php if($TPL_VAR["callPage"]=="batch_sms"){?>
	<div class="center mt30">수신 동의자가 아닌 회원에게 광고성 SMS/이메일 발송 시 ‘정보통신망이용 촉진 및 정보보호등에 관한 법률 및 시행령’ 위반’입니다.</div>
<?php }?>
	</form>	
</div>

<?php if($TPL_VAR["pageType"]=="search"){?>
<div class="footer">
<?php if($TPL_VAR["callPage"]=="batch_sms"){?>	
	<button type="button" class="resp_btn active size_XL" onclick="selectMemberInputDown();">선택한 회원 적용</span></button>
	<button type="button" class="resp_btn active size_XL" onclick="serchMemberInputDown();">검색한 회원 적용</span></button>
<?php }else{?>
	<button type="button" class="resp_btn active size_XL" onclick="selectMemberInput('<?php echo $TPL_VAR["callPage"]?>');">선택한 회원 적용</button>
	<button type="button" class="resp_btn active size_XL" onclick="serchMemberInput('<?php echo $TPL_VAR["callPage"]?>');">검색한 회원 적용</button>
<?php }?>
	<button type="button" class="search_reset resp_btn v3 size_XL" onclick="closeDialog('memberSearchDiv')">취소</button>
</div>
<?php }?>