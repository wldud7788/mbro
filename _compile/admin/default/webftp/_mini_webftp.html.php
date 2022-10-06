<?php /* Template_ 2.2.6 2022/05/17 12:37:25 /www/music_brother_firstmall_kr/admin/skin/default/webftp/_mini_webftp.html 000002511 */ ?>
<style>

#miniWebFtpContainer {position:fixed; width:100%; top:100%; left:0px;}
#miniWebFtpContainer		.miniWebFtpBodyLayer {}
<?php if($TPL_VAR["EYE_EDITOR"]){?> 
	#miniWebFtpContainer 		.miniWebFtpTitleLayer {position:absolute; width:120px; left:50%; margin-left:-60px; border-bottom:1px solid #7c7c7c; text-align:center; height:19px; margin-top:-19px;}
<?php }else{?>
	#miniWebFtpContainer 		.miniWebFtpTitleLayer {position:absolute; width:120px; left:50%; margin-left:-60px; border-bottom:1px solid #7c7c7c; text-align:center; height:13px; margin-top:-13px;}
<?php }?>
#miniWebFtpContainer		.miniWebFtpTitleLayer .closedBtn {display:block; cursor:pointer}
#miniWebFtpContainer		.miniWebFtpTitleLayer .openedBtn {display:none; cursor:pointer}
#miniWebFtpContainer.show	.miniWebFtpTitleLayer .openedBtn {display:block}
#miniWebFtpContainer.show	.miniWebFtpTitleLayer .closedBtn {display:none}

</style>
<script type="text/javascript">
var useWebftpFormItem = true;
$(function(){
	
	/* 폼 셀렉터 사용 설정 */
	$(".webftpFormItem:first-child input[type=radio][name=webftpFormItemSelector]").attr('checked',true);
	if($(".webftpFormItem").length==0) useWebftpFormItem = false;
	
	/* 슬라이딩 버튼 */
	$("#miniWebFtpContainer .miniWebFtpTitleLayer .openedBtn").bind("click",function(){
		$("#miniWebFtpContainer").animate({'margin-top':0}).removeClass('show');
	});
	$("#miniWebFtpContainer .miniWebFtpTitleLayer .closedBtn").bind("click",function(){
		$("#miniWebFtpContainer").animate({'margin-top':-$(".webftp-table-style").height()}).addClass('show');
	});
	
});

</script>

<div id="miniWebFtpContainer">
	<div class="miniWebFtpTitleLayer">
<?php if($TPL_VAR["EYE_EDITOR"]){?>
			<span class="openedBtn"><img src="/admin/skin/default/images/design/directory_img_tab_normal.gif" title="닫기" /></span>
			<span class="closedBtn"><img src="/admin/skin/default/images/design/directory_img_tab_normal.gif" title="열기" /></span></span>
<?php }else{?>
			<span class="openedBtn"><img src="/admin/skin/default/images/design/directory_img_tab.gif" title="닫기" /></span>
			<span class="closedBtn"><img src="/admin/skin/default/images/design/directory_img_tab.gif" title="열기" /></span></span>
<?php }?>
	</div>
	<div class="miniWebFtpBodyLayer">
<?php $this->print_("webftp",$TPL_SCP,1);?>

	</div>
</div>