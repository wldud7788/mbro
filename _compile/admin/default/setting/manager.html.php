<?php /* Template_ 2.2.6 2022/05/17 12:36:58 /www/music_brother_firstmall_kr/admin/skin/default/setting/manager.html 000008497 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="../../app/javascript/js/admin-manager.js?dummy=<?php echo date('YmdH')?>"></script>
<form name="settingForm" id="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/manger" target="actionFrame">
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
			<h2>관리자</h2>
		</div>
		
		<div class="page-buttons-right">
<?php if($TPL_VAR["service_limit"]&&$TPL_VAR["config_system"]["service"]["max_manager_cnt"]&&$TPL_VAR["use_manager_cnt"]>=$TPL_VAR["config_system"]["service"]["max_manager_cnt"]){?>		
			<button class="resp_btn active2 size_L" type="button"  <?php if($TPL_VAR["functionLimit"]){?>  onclick="servicedemoalert('use_f');" <?php }else{?> onclick="manager_reg(false)" <?php }?> >관리자 등록</button>
<?php }else{?>
			<button class="resp_btn active2 size_L" type="button"  <?php if($TPL_VAR["functionLimit"]){?>  onclick="servicedemoalert('use_f');" <?php }else{?> onclick="manager_reg(true)" <?php }?> >관리자 등록</button>
<?php }?>			
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="contents_container">
	<!-- 서브메뉴 바디 : 시작-->
	<div class="contents_dvs">		
		<div class="item-title">
			관리자 리스트
<?php if($TPL_VAR["service_limit"]&&$TPL_VAR["config_system"]["service"]["max_manager_cnt"]){?> 
			<span class="desc">(현재 : <?php echo number_format($TPL_VAR["use_manager_cnt"])?>명 / <?php echo number_format($TPL_VAR["config_system"]["service"]["max_manager_cnt"])?>명까지 가능)</span>
<?php }?>		
		</div>
		<div class="table_row_frame">	
			<div class="dvs_top">	
				<div class="dvs_left">	
					<button type="button" class="resp_btn v3" <?php if($TPL_VAR["functionLimit"]){?>  onclick="servicedemoalert('use_f');" <?php }else{?>  id="delete_btn" <?php }?>>선택 삭제</button>	
				</div>
				<div class="dvs_right">	
					<button type="button" class="resp_btn v2" onclick="chatbotSetting();">챗봇상담 설정</button>
<?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'){?>
					<button type="button" class="resp_btn v2"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?>  onclick="auto_logout();" <?php }?> >자동로그아웃 설정</button>
					<button type="button"  class="resp_btn v2" <?php if($TPL_VAR["functionLimit"]){?>  onclick="servicedemoalert('use_f');" <?php }else{?> onclick="manager_log()" <?php }?> >개인정보처리 관리</button>

<?php }?>
				</div>
			</div>
			<table class="table_row_basic">
				<col width="5%" /><col width="10%" /><col width="15%" /><col width="10%" /><col width="10%" />
				<col width="10%" /><col width="14%" /><col width="14%" /><col width="7%" />
				<thead>
					<tr>
						<th><label class="resp_checkbox"><input type="checkbox" onclick="chkAll(this,'manager_seq');"></label></th>
						<th>관리자 구분</th>
						<th>관리자ID (접속허용 IP설정)</th>
						<th>관리자명</th>
						<th>전화번호</th>		
						<th>이메일</th>
						<th>최근 접속일</th>
						<th>등록일</th>
						<th>관리</th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox" name="manager_seq[]" value="<?php echo $TPL_V1["manager_seq"]?>" class="manager_seq" <?php if($TPL_V1["auth"]["manager_yn"]=='Y'){?>disabled<?php }?> manager_yn="<?php echo $TPL_V1["auth"]["manager_yn"]?>"></label></td>
					<td><?php if($TPL_V1["auth"]["manager_yn"]=='Y'){?>대표운영자<?php }else{?>부운영자<?php }?></td>
					<td><span class="blue bold hand" onclick="location.href='manager_reg?manager_seq=<?php echo $TPL_V1["manager_seq"]?>'"><?php echo $TPL_V1["manager_id"]?></span> (<?php if($TPL_V1["limit_ip"]){?><?php echo $TPL_V1["limit_ip"]?><?php }else{?>미설정<?php }?>)</td>
					<td><?php echo $TPL_V1["mname"]?></td>
					<td><?php echo $TPL_V1["mphone"]?></td>			
					<td><?php echo $TPL_V1["memail"]?></td>
					<td><?php echo $TPL_V1["lastlogin_date"]?></td>
					<td><?php echo $TPL_V1["mregdate"]?></td>
					<td class="center">
						<button type="button" class="resp_btn v2"  <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> onclick="location.href='manager_reg?manager_seq=<?php echo $TPL_V1["manager_seq"]?>'" <?php }?>>수정</button>
					</td>
				</tr>
<?php }}?>
				</tbody>
			</table>		
			<!-- 페이징 -->
			</div>
		<div class="paging_navigation footer"><?php echo $TPL_VAR["pagin"]?></div>	
	</div>
	<!-- 서브메뉴 바디 : 끝 -->	
</div>
<!-- 서브 레이아웃 영역 : 끝 -->
</form>

<div id="info" class="hide">
<table width="100%">
<tr><td>무료몰+ : 기본 1계정 (계정 추가 시 1계정당 11,000원, 최초 1회 결제로 기간 관계 없이 계속 이용)</td></tr>
<tr><td>프리미엄몰+ 또는 독립몰+로 업그레이드 하시면 관리자 계정을 무제한 이용 가능합니다.</td></tr>
<tr><td height="20"></td></tr>
<tr>
	<td align="center">
	<input type="button" class="btn_resp b_gray size_a" value="추가신청" id="manager_charge" />
	<input type="button"  class="btn_resp size_a" value="업그레이드" onclick="serviceUpgrade();" />
	</td>
</tr>
</table>
</div>

<div id="managerPaymentPopup" class="hide"></div>
<div id="managerPaymentPopup" class="hide"></div>
<div id="autoLogoutPopup" class="hide">
<form name="autoFrm" method="post" action="../setting_process/auto_logout" target="actionFrame">
	<table class="table_basic thl">
		<tr>
			<th>사용 여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="auto_logout" value="Y" <?php if($TPL_VAR["auto_logout"]=="Y"){?>checked<?php }?>> 사용함</label>
					<label><input type="radio" name="auto_logout" value="N" <?php if($TPL_VAR["auto_logout"]=="N"||$TPL_VAR["auto_logout"]==""){?>checked<?php }?>> 사용 안 함</label>
				</div>
			</td>
		</tr>

		<tr>
			<th>자동 로그아웃 시간</th>
			<td>
				<select name="until_time" class="auto_logout_select" style="margin-bottom:5px;">
					<option value="1" <?php if($TPL_VAR["until_time"]== 1){?>selected<?php }?>>1시간 후</option>
					<option value="2" <?php if($TPL_VAR["until_time"]== 2){?>selected<?php }?>>2시간 후</option>				
				</select>				
			</td>
		</tr>
	</table>

	<ul class="bullet_hyphen resp_message">
		<li>입점사 관리자에도 동일하게 적용됩니다.</li>
	</ul>

	<div class="footer">
		<button class="resp_btn active size_XL"  type="submit">저장</button>	
		<button class="resp_btn v3 size_XL"  type="button" onclick="closeDialogEvent(this);">닫기</button>	
	</div>
</form>
</div>

<div id="chatbotSetting" class="hide">
<form name="chatbotSettingFrm" method="post" action="../setting_process/chatbot_setting" target="actionFrame">
	<table class="table_basic thl">
		<tr>
			<th>버튼 노출여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="chatbot_use" value="Y" <?php if($TPL_VAR["chatbot_use"]=="Y"){?>checked<?php }?>> 노출</label>
					<label><input type="radio" name="chatbot_use" value="N" <?php if($TPL_VAR["chatbot_use"]!="Y"){?>checked<?php }?>> 미노출</label>
				</div>
			</td>
		</tr>
	</table>
	<ul class="bullet_hyphen resp_message">
		<li>관리자 로그인 시 우측 하단에 챗봇상담 버튼 노출여부를 설정합니다.</li>
		<li>챗봇상담 사용방법 <span class="highlight-link hand" onclick="window.open('https://www.firstmall.kr/customer/faq/1251');">자세히 보기</span></li>
	</ul>
	<div class="footer">
		<button class="resp_btn active size_XL"  type="submit">저장</button>	
		<button class="resp_btn v3 size_XL"  type="button" onclick="closeDialogEvent(this);">닫기</button>	
	</div>
</form>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>