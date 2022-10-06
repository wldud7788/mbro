<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/common/warning.html 000006041 */ ?>
<style>
#warningDialogLayer {line-height:20px; text-align:center; padding-bottom:25px;}
</style>

<div id="warningDialogLayer">
	
	<!--[ 유료몰 : 만료일 전 10~0일 이내일때]-->
<?php if(serviceLimit('H_NFR')&&substr($TPL_VAR["code"], - 1)=='1'&&uri_string()=='admin/main/index'){?>
	쇼핑몰 서비스 사용기간이 <b class="red"><?php echo number_format($TPL_VAR["intval"])?></b>일 남았습니다.<br /><br />
	사용기간 만료 후 30일이 경과되면 쇼핑몰 방문자(소비자) 화면 접속이 제한됩니다.<br />
	사용기간 만료 후 60일이 경과되면 쇼핑몰은 삭제 됩니다.<br />
	MY가비아(<a href="http://www.gabia.com/mygabia" target="_blank">http://www.gabia.com/mygabia</a>)에 접속하셔서 사용기간을 연장해 주시기 바랍니다.
	<div class="pdt20"><span class="btn large cyanblue"><input type="button" value="확인" style="width:100px" onclick="$('#warningDialogLayer').dialog('close')" /></span></div>
	
	<script type="text/javascript">
	openDialog("쇼핑몰 이용안내","warningDialogLayer",{'width':700});
	</script>
<?php }?>
	
	<!--[ 유료몰 : 만료일 후 1~29일 이내일때]-->
<?php if(serviceLimit('H_NFR')&&substr($TPL_VAR["code"], - 1)=='2'){?>
	쇼핑몰 서비스 사용기간 만료 후 <b class="red"><?php echo number_format(abs($TPL_VAR["intval"]))?></b>일이 경과되었습니다.<br /><br />
	사용기간 만료 후 30일이 경과되면 쇼핑몰 방문자(소비자) 화면 접속이 제한됩니다.<br />
	사용기간 만료 후 60일이 경과되면 쇼핑몰은 삭제 됩니다.<br />
	MY가비아(<a href="http://www.gabia.com/mygabia" target="_blank">http://www.gabia.com/mygabia</a>)에 접속하셔서 사용기간을 연장해 주시기 바랍니다.
	
	<script type="text/javascript">
	openDialog("쇼핑몰 이용안내","warningDialogLayer",{'width':700,'noClose':true});
	</script>
<?php }?>
	
	<!--[ 유료몰 : 만료일 후 30~60일 이내일때]-->
<?php if(serviceLimit('H_NFR')&&substr($TPL_VAR["code"], - 1)=='3'){?>
	쇼핑몰 서비스 사용기간 만료 후 <b class="red"><?php echo number_format(abs($TPL_VAR["intval"]))?></b>일이 경과되었습니다.<br /><br />
	사용기간 만료 후 30일이 경과되어 쇼핑몰 방문자(소비자) 화면 접속이 제한되었습니다.<br />
	사용기간 만료 후 60일이 경과되면 쇼핑몰은 삭제 됩니다.<br />
	MY가비아(<a href="http://www.gabia.com/mygabia" target="_blank">http://www.gabia.com/mygabia</a>)에 접속하셔서 사용기간을 연장해 주시기 바랍니다.
	
	<script type="text/javascript">
	openDialog("쇼핑몰 이용안내","warningDialogLayer",{'width':700,'noClose':true});
	</script>
<?php }?>
	
	<!--[ 유료몰 : 만료일 후 60일 경과시]-->
<?php if(serviceLimit('H_NFR')&&substr($TPL_VAR["code"], - 1)=='4'){?>
	쇼핑몰 서비스 사용기간 만료 후 <b class="red"><?php echo number_format(abs($TPL_VAR["intval"]))?></b>일이 경과되었습니다.<br /><br />
	사용기간 만료 후 60일이 경과되어 삭제 대상 쇼핑몰입니다.<br />
	쇼핑몰 삭제가 곧 진행됩니다. 지금 즉시 퍼스트몰 고객센터(1544-3270)로 연락 바랍니다.
	
	<script type="text/javascript">
	openDialog("쇼핑몰 이용안내","warningDialogLayer",{'width':700,'noClose':true});
	</script>
<?php }?>
	
	<!--[ 무료몰 : 마지막접속일 이후 30~60일 이내일때]-->
<?php if(serviceLimit('H_FR')&&substr($TPL_VAR["code"], - 1)=='3'&&uri_string()=='admin/main/index'){?>
	<b>관리자환경 최종 로그인일로부터 <b class="red"><?php echo number_format(abs($TPL_VAR["intval"]))?></b>일만에 로그인하셨습니다.</b><br /><br />
	쇼핑몰 사용자(소비자)화면의 접속제한이 해제되었습니다.<br />
	아래 내용을 숙지하여 쇼핑몰 운영에 지장이 없으시길 바랍니다 <br /><br />
	<span class="desc">- 관리자환경 최종 로그인일로부터 30일간 로그인이 한번도 없으면 
	사전 통보 없이 쇼핑몰 사용자(소비자)화면의 접속이 제한됩니다.<br /></span>
	<span class="desc">- 관리자환경 최종 로그인일로부터 60일간 로그인이 한번도 없으면 
	사전 통보 없이 쇼핑몰은 삭제 됩니다.<br /></span>
	<div class="pdt20"><span class="btn large cyanblue"><input type="button" value="확인" style="width:100px" onclick="$('#warningDialogLayer').dialog('close')" /></span></div>
	
	<script type="text/javascript">
	openDialog("쇼핑몰 이용안내","warningDialogLayer",{'width':700});
	</script>
<?php }?>
	
	<!--[ 무료몰 : 마지막접속일 이후 60일 경과시]-->
<?php if(serviceLimit('H_FR')&&substr($TPL_VAR["code"], - 1)=='4'&&uri_string()=='admin/main/index'){?>
	<b>관리자환경 최종 로그인일로부터 <b class="red"><?php echo number_format(abs($TPL_VAR["intval"]))?></b>일만에 로그인하셨습니다.</b><br /><br />
	쇼핑몰 사용자(소비자)화면의 접속제한이 해제되었습니다.<br />
	아래 내용을 숙지하여 쇼핑몰 운영에 지장이 없으시길 바랍니다 <br /><br />
	<span class="desc">- 관리자환경 최종 로그인일로부터 30일간 로그인이 한번도 없으면 
	사전 통보 없이 쇼핑몰 사용자(소비자)화면의 접속이 제한됩니다.<br /></span>
	<span class="desc">- 관리자환경 최종 로그인일로부터 60일간 로그인이 한번도 없으면 
	사전 통보 없이 쇼핑몰은 삭제 됩니다.<br /></span>
	<div class="pdt20"><span class="btn large cyanblue"><input type="button" value="확인" style="width:100px" onclick="$('#warningDialogLayer').dialog('close')" /></span></div>
	
	<script type="text/javascript">
	openDialog("쇼핑몰 이용안내","warningDialogLayer",{'width':700});
	</script>
<?php }?>
	
</div>