<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/setting/manager.html 000008621 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript">
$(document).ready(function() {
	$("#delete_btn").click(function(){
		var cnt = $("input:checkbox[name='provider_seq[]']:checked").length;
		if(cnt<1){
			alert("삭제할 관리자를 선택해 주세요."); 
			return;
		}else{
			var queryString = $("#settingForm").serialize();
			if(!confirm("선택한 관리자를 삭제 시키겠습니까? ")) return;
			$.ajax({
				type: "get",
				url: "../setting_process/manager_delete",
				data: queryString,
				success: function(result){			
					//alert(result);
					location.reload();
				}
			});
		}
	});

	$('#manager_charge').live('click', function (){
		$.get('manager_payment', function(data) {		
			$('#managerPaymentPopup').html(data);		
			openDialog("관리자 계정 추가 신청", "managerPaymentPopup", {"width":"800","height":"650"});
		});
	});

	$("input[name='auto_logout']").click(function(){
		init_auto_logout();
	});

	init_auto_logout();

});

function init_auto_logout(){
	if($("input[name='auto_logout']").attr("checked")){
		$(".auto_logout_select").attr("disabled",false);
	}else{
		$(".auto_logout_select").attr("disabled",true);
	}
}

function chkAll(chk, name){
	if(chk.checked){
		$(".provider_seq").attr("checked",true);
		$("input[name='provider_seq[]'][manager_yn='Y']").attr('checked',false);
	}else{
		$(".provider_seq").attr("checked",false);
	}
}

function manager_reg(){
<?php if($TPL_VAR["service_limit"]&&$TPL_VAR["config_system"]["service"]["max_manager_cnt"]&&$TPL_VAR["use_manager_cnt"]>=$TPL_VAR["config_system"]["service"]["max_manager_cnt"]){?>
	openDialog("관리자 계정 이용 안내", "info", {"width":"600","height":"180"});
	return;
<?php }?> 
	location.href='manager_reg';
}

function manager_log(){
	location.href='manager_log';
}
</script>
<form name="settingForm" id="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/manger" target="actionFrame">
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
	
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>관리자</h2>
		</div>
		
		<div class="page-buttons-right">
            <button type="button" class="resp_btn active size_L" <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> onclick="manager_reg()" <?php }?> >관리자 등록</button>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
	<!-- 서브메뉴 바디 : 시작-->
		<div class="contents_dvs v2">		
			<div class="item-title">
			관리자 리스트
<?php if($TPL_VAR["service_limit"]&&$TPL_VAR["config_system"]["service"]["max_manager_cnt"]){?> 
			<span class="desc">(현재 : <?php echo number_format($TPL_VAR["use_manager_cnt"])?>명 / <?php echo number_format($TPL_VAR["config_system"]["service"]["max_manager_cnt"])?>명까지 가능)</span>
<?php }?>				
			</div>	
			
			<div class="table_row_frame">	
			<div class="dvs_top">	
				<div class="dvs_left">	
					<button type="button" class="resp_btn v3" <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  type="button" <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?>  id="delete_btn" <?php }?>>선택 삭제</button>	
				</div>		
                <div class="dvs_right">	
                    <button type="button" class="resp_btn v2" <?php if($TPL_VAR["functionLimit"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> onclick="manager_log()" <?php }?> >개인정보처리 관리</button>
                </div>		
			</div>
		
			<table class="table_row_basic">
			<col width="8%" /><col width="16%" /><col width="18%" /><col width="16%" /><col width="16%" /><col width="16%" /><col width="10%" />
			<thead>
			<tr>
				<th><label class="resp_checkbox"><input type="checkbox" onclick="chkAll(this,'provider_seq');"></label></th>
				<th>관리자 구분</th>
				<th>관리자ID (접속허용 IP설정)</th>
				<th>관리자명</th>
				<th>최근 접속일</th>
				<th>등록일</th>
				<th>관리</th>
			</tr>
			</thead>
			<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<tr>
				<td><label class="resp_checkbox"><input type="checkbox" name="provider_seq[]" value="<?php echo $TPL_V1["provider_seq"]?>" class="provider_seq" <?php if($TPL_V1["manager_yn"]=='Y'){?>disabled<?php }?> manager_yn="<?php echo $TPL_V1["manager_yn"]?>"></label></td>
				<td><?php if($TPL_V1["manager_yn"]=='Y'){?>대표운영자<?php }else{?>부운영자<?php }?></td>
				<td><span class="blue bold hand"<?php if($TPL_V1["manager_yn"]=='Y'){?>onclick="location.href='provider_reg?no=<?php echo $TPL_V1["provider_seq"]?>'"<?php }else{?>onclick="location.href='manager_reg?provider_seq=<?php echo $TPL_V1["provider_seq"]?>'"<?php }?>><?php echo $TPL_V1["provider_id"]?></span> (<?php if($TPL_V1["limit_ip"]){?><?php echo $TPL_V1["limit_ip"]?><?php }else{?>미설정<?php }?>)</td>
				<td><?php echo $TPL_V1["provider_name"]?></td>
				<td><?php echo $TPL_V1["lastlogin_date"]?></td>
				<td><?php echo $TPL_V1["regdate"]?></td>
				<td>
					<button type="button" class="resp_btn v2" 	<?php if($TPL_V1["manager_yn"]=='Y'){?>onclick="location.href='provider_reg?no=<?php echo $TPL_V1["provider_seq"]?>'"<?php }else{?>onclick="location.href='manager_reg?provider_seq=<?php echo $TPL_V1["provider_seq"]?>'"<?php }?>>수정</button>
				</td>
			</tr>
<?php }}?>
			</tbody>
			</table>
		</div>		
		<!-- 페이징 -->
		<div class="paging_navigation footer"><?php echo $TPL_VAR["pagin"]?></div>
	</div>
	<!-- 서브메뉴 바디 : 끝 -->

<!-- 서브 레이아웃 영역 : 끝 -->
</form>


<div id="info" class="hide">
<table width="100%">
<tr><td>무료몰+ : 기본 1계정 (계정 추가 시 1계정당 11,000원, 최초 1회 결제로 기간 관계 없이 계속 이용)</td></tr>
<tr><td>프리미엄몰+ 또는 독립몰+로 업그레이드 하시면 관리자 계정을 무제한 이용 가능합니다.</td></tr>
<tr><td height="20"></td></tr>
<tr>
	<td align="center">
	<span class="btn medium cyanblue valign-middle"><input type="button" value="추가신청 > " id="manager_charge" /></span>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand" onclick="serviceUpgrade();" align="absmiddle" />
	</td>
</tr>
</table>
</div>

<div id="managerPaymentPopup" class="hide"></div>
<div id="managerPaymentPopup" class="hide"></div>
<div id="autoLogoutPopup" class="hide">
<form name="autoFrm" method="post" action="../setting_process/auto_logout" target="actionFrame">
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<label><input type="checkbox" name="auto_logout" value="Y" <?php if($TPL_VAR["auto_logout"]=="Y"){?>checked<?php }?>>사용</label> 
				&nbsp;&nbsp;
				<select name="until_time" class="auto_logout_select">
					<option value="1" <?php if($TPL_VAR["until_time"]== 1){?>selected<?php }?>>1시간 후</option>
					<option value="2" <?php if($TPL_VAR["until_time"]== 2){?>selected<?php }?>>2시간 후</option>
					<option value="3" <?php if($TPL_VAR["until_time"]== 3){?>selected<?php }?>>3시간 후</option>
					<option value="4" <?php if($TPL_VAR["until_time"]== 4){?>selected<?php }?>>4시간 후</option>
					<option value="5" <?php if($TPL_VAR["until_time"]== 5){?>selected<?php }?>>5시간 후</option>
					<option value="6" <?php if($TPL_VAR["until_time"]== 6){?>selected<?php }?>>6시간 후</option>
					<option value="10" <?php if($TPL_VAR["until_time"]== 10){?>selected<?php }?>>10시간 후</option>
					<option value="12" <?php if($TPL_VAR["until_time"]== 12){?>selected<?php }?>>12시간 후</option>
				</select>
				자동으로 로그아웃 합니다.
				<div style="padding-top:5px; padding-bottom:10px;">※ 입점사 관리자에도 동일하게 적용됩니다.</div>
			</td>
		</tr>
	</table>

	<div align="center">
	<span class="btn large gray"><input type="submit" value="저장"></span>
	<span class="btn large gray"><input type="button" value="취소" onclick="closeDialog('#autoLogoutPopup');"></span>
	</div>
</form>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>