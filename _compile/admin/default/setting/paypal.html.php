<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/setting/paypal.html 000005146 */ ?>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/boardnew.css" />
<style type="text/css">
.info-table-style.joinform-user-table th.its-th {padding-left:15px;}
.info-table-style th {height:28px;}
.pop_guide {padding:20px 0; text-align:left;}
</style>

<script type="text/javascript">
var onInterestSettingButtonIndex = 0;
$(document).ready(function() {
	paypal_sync_height();
	
	$('<div class="title_dvs"><button type="button" id="view_paypal_info" class="resp_btn">페이팔 연동 안내</button></div>').insertBefore("form[name=pgSettingForm]");

	$("#view_paypal_info").click(function(){
		openDialog("페이팔 API 엑세스 안내", "view_paypal_popup", {"width":"750","height":"420","show" : "fade","hide" : "fade"});
	});
});

// 모바일/pc플랫폼 테이블간의 높의 조절
function paypal_sync_height(){
	var h = $("div.paypalinputPgSetting").eq(0).height() ;
	$("div.paypalinputPgSetting table.table_basic").eq(1).height( $("div.paypalinputPgSetting table.table_basic").eq(0).height() + 3 );
}
</script>

<div class="clearbox paypalinputPgSetting">
	<table class="table_basic">
		<col width="15%" /><col width="15%" /><col width="70%" />
		<tr>
			<th class="center bold" colspan="3">PC / 모바일</th>
		</tr>
		<tr>
			<th>결제통화</th>
			<td>통화설정</td>
			<td>결제수단 공통 설정
				<div style="display:inline-block;">                    
                    <select name="paypal_currency">
<?php if(is_array($TPL_R1=code_load('currency'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?> 
<?php if($TPL_V1["codecd"]!='KRW'&&$TPL_V1["codecd"]!='CNY'){?>
<?php if($TPL_V1["codecd"]==$TPL_VAR["paypal_currency"]){?>
                        <option value="<?php echo $TPL_V1["codecd"]?>" selected><?php echo $TPL_V1["codecd"]?></option>
<?php }else{?>
                        <option value="<?php echo $TPL_V1["codecd"]?>" ><?php echo $TPL_V1["codecd"]?></option>
<?php }?>
<?php }?>
<?php }}?>
                    </select>                    
                </div>
			</td>
		</tr>
		<tr>
			<th rowspan="2">일반</th>
			<td>사용여부</td>			
			<td class="resp_radio">
				<label><input type="radio" name="not_use_paypal" id="not_use_paypal_n" value='n' <?php if($TPL_VAR["config_system"]["not_use_paypal"]=='n'){?>checked<?php }?>> 사용</label>
				<label><input type="radio" name="not_use_paypal" id="not_use_paypal_y" value='y' <?php if($TPL_VAR["config_system"]["not_use_paypal"]=='y'){?>checked<?php }?>> 미사용</label>
			</td>			
		</tr>		
		<tr>
			<td>세팅 정보 등록</td>
			<td>
				<table cellpadding="0" cellspacing="3" border="0" width="100%">
				<col width="20%" /><col width="80%" />
				<tr>
					<td>API 사용자 이름 :</td>
					<td>
						<input type="text" name="paypal_username" value="<?php echo $TPL_VAR["paypal_username"]?>" title="API 사용자 이름" style="width:92%;" />
					</td>
				</tr>
				<tr>
					<td>API 비밀번호 : </td>
					<td>
						<input type="password" name="paypal_userpasswd" value="<?php echo $TPL_VAR["paypal_userpasswd"]?>" title="API 비밀번호" style="width:92%;" />
					</td>
				</tr>
				<tr>
					<td>서명 :</td>
					<td>
						<input type="text" name="paypal_signature" value="<?php echo $TPL_VAR["paypal_signature"]?>" title="서명" style="width:92%;" />
					</td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
</div>	
</form>

<div id="view_paypal_popup" class="hide">
	<div class="content">
		<ul class="bullet_num">
			<li>페이팔 비즈니스 계정 가입 을 완료합니다.</li>		
			<li>페이팔 로그인 후 우측 상단의 [프로필] 클릭 후 [프로필 및 설정] 메뉴를 선택합니다.</li>		
			<li>
				좌측 매뉴>판매 도구 메뉴를 클릭합니다. API 액세스 우측의 [업데이트]를 클릭합니다.<br>
				<img src="/admin/skin/default/images/common/img_paypal_guide1.jpg" class="mt5" alt="" />
			</li>		
			<li>
				NVP/SOAP API 통합(클래식) 의 [API 자격증명 관리]를 클릭합니다.<br>
				<img src="/admin/skin/default/images/common/img_paypal_guide2.jpg" class="mt5" alt="" />
			</li>		
			<li>
				[API 서명 요청] 선택 후 [동의 및 제출] 버튼을 클릭합니다.<br>
				<img src="/admin/skin/default/images/common/img_paypal_guide3.jpg" class="mt5" alt="" />
			</li>		
			<li>
				API 사용자 이름, API 비밀번호, 서명 우측의 [표시] 를 클릭하여 정보를 확인합니다.<br>
				<img src="/admin/skin/default/images/common/img_paypal_guide4.jpg" class="mt5" alt="" />
			</li>		
			<li>각 API 정보를 [페이팔 설정>일반>세팅정보 등록]에 입력하면 연동이 완료됩니다.</li>
		</ul>
	</div>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>