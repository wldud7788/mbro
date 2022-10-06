<?php /* Template_ 2.2.6 2022/05/17 12:36:28 /www/music_brother_firstmall_kr/admin/skin/default/member/kakaotalk_msg.html 000010222 */ 
$TPL_msg_type_1=empty($TPL_VAR["msg_type"])||!is_array($TPL_VAR["msg_type"])?0:count($TPL_VAR["msg_type"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/massage.css" />
<script type="text/javascript">
$(document).ready(function() {
	$('#kakaotalk_charge').on('click', function (){
		$.get('kakaotalk_payment', function(data) {
			$('#kakaotalkPopup').html(data);
			openDialog("SMS/카카오 알림톡 충전 <span class='desc'>&nbsp;</span>", "kakaotalkPopup", {"width":"1200","height":"800"});
		});
	});
});

// 종류 tab 메뉴
function tabmenu(no){
	var i=1;
	$(".messTab > li > a").each(function(){
		$(this).removeClass("current");
		if(no == i){
			var change_idx	= "5";
			$(".sms_message_group_lay").hide();
			$(this).addClass("current");
			console.log($(this).attr("value"));
			if($(this).attr("value") == change_idx){
				$("#sms_restriction").show();
			}else{
				$("#sms_restriction").hide();
				$("#sms_message_group_lay_"+$(this).attr('value')).show();
			}
		}
		i = i+1;
	});
}

// 거절사유 확인
function confirm_reject(obj){
	var kkoBizCode = $(obj).closest('.kakao_message').attr('kkoBizCode');
	$.ajax({
		type		: 'post',
		url			: './kakaotalk_template_ajax',
		dataType	: 'json',
		data		: {	'kkoBizCode' : kkoBizCode },
		success: function(result){		
			$.each(result.comments_arr, function(k,info){
				if(info.createdAt)$("#rejectDate").html(info.createdAt);
				if(info.content)$("#rejectMess").html(info.content);
			});
			$("#reject_kkoBizCode").val(kkoBizCode);
			openDialog("거절 사유 확인", "rejectPopup", {"width":"800","height":"500","show" : "fade","hide" : "fade"});
		}
	});
}

// 거절사유에 대한 문의하기
function template_comment(){
	$("#comment_frm").submit();
}

// 사용/미사용 설정
function msg_use(obj){
	var msg_yn		= $(obj).is(':checked');
	var msg_code	= $(obj).closest('.kakao_message').attr('msg_code');
	$.ajax({
		type		: 'post',
		url			: '../member_process/kakaotalk_msg_use_modify',
		dataType	: 'text',
		data		: {	'msg_code' : msg_code, 'msg_yn' : msg_yn },
		success: function(result){
			if(result){
				openDialogAlert('알림톡 사용여부 설정이 수정되었습니다.',400,150);
			}else{
				openDialogAlert('오류가 발생하였습니다.<br/>잠시 후 다시 시도해주세요.',400,150);
			}
		}
	});
}

// 메세지수정
function modify_msg(obj){
	var msg_code = $(obj).closest('.kakao_message').attr('msg_code');
	$.ajax({
		type		: 'post',
		url			: './kakaotalk_template_modify',
		dataType	: 'html',
		data		: { 'msg_code' : msg_code },
		success: function(result){
			$("#kakaotalkPopup").html(result);
			openDialog("알림톡 메시지 수정", "kakaotalkPopup", {"width":"1000","height":"700","show" : "fade","hide" : "fade"});
		}
	});
}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>카카오 알림톡</h2>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">
<?php $this->print_("top_menu",$TPL_SCP,1);?>


	<!-- 서브 레이아웃 영역 : 시작 -->

	<!-- 종류 TAB 메뉴 -->
	<ul class="tab_01 v3 mt15 messTab">		
		<li><a href="javascript:vold(0)" onclick="tabmenu(1)" value="1" class="current">공통</a></li>
		<li><a href="javascript:vold(0)" onclick="tabmenu(2)" value="2">상품 발송 메시지</a></li>
		<li><a href="javascript:vold(0)" onclick="tabmenu(3)" value="3">티켓 발송 메시지</a></li>
		<li><a href="javascript:vold(0)" onclick="tabmenu(4)" value="4">고객 리마인드</a></li>			
	</ul>
	<!-- //종류 TAB 메뉴 -->

<?php if($TPL_msg_type_1){foreach($TPL_VAR["msg_type"] as $TPL_K1=>$TPL_V1){?>

	<div id="sms_message_group_lay_<?php echo $TPL_K1+ 1?>" class="sms_message_group_lay <?php if($TPL_K1> 0){?>hide<?php }?>">
		<div class="kakao_wrap">
			<ul class="clearbox">
<?php if($TPL_VAR["msg_list"][$TPL_V1]){?>
<?php if(is_array($TPL_R2=$TPL_VAR["msg_list"][$TPL_V1])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li>
					<div class="kakao_message num<?php echo count($TPL_V2["kkoLinkType_arr"])?>" msg_code="<?php echo $TPL_V2["msg_code"]?>" kkoBizCode="<?php echo $TPL_V2["kkoBizCode"]?>">
						<div class="stit">
							<label class="resp_checkbox">
							<input type="checkbox" name="" <?php if($TPL_V2["msg_yn"]=='Y'){?>checked<?php }?> onclick="msg_use(this);" />
							<?php echo $TPL_V2["msg_txt"]?>

							</label>
<?php if($TPL_V2["msg_code"]=='deposit_user'){?>
								<span class="helpicon2 detailDescriptionLayerBtn" title="입금 요청"></span>
								<div class="detailDescriptionLayer hide">카카오 알림톡 "입금요청" 발송 시간 설정은 SMS 발송 관리의 "입금 요청"시간 설정에 따릅니다.</div>
<?php }?>

							<div class="icon_wrap fr">
<?php if($TPL_V2["sms_use"]=='Y'){?>
								<img src="/admin/skin/default/images/design/ico_sms_on.gif" alt="문자 ON" />
<?php }else{?>
								<img src="/admin/skin/default/images/design/ico_sms_off.gif" alt="문자 OFF" />
<?php }?>
							</div>
						</div>
						<div class="cont">
							<textarea readonly><?php echo $TPL_V2["templateContents"]?></textarea>
						</div>
						<div class="btns">
							<div class="btn_area link">
								<ul class="clearbox">
<?php if($TPL_V2["kkoLinkType_arr"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["kkoLinkType_arr"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
									<li><a href="#"><?php if($TPL_V3=='DS'){?>배송조회<?php }else{?><?php echo $TPL_V2["kkoLinkName_arr"][$TPL_K3]?><?php }?></a></li>
<?php }}?>
<?php }else{?>
									<li></li>
<?php }?>
								</ul>
							</div>
<?php if($TPL_V2["approval"]=='R'){?>
							<ul class="reject clearbox">
								<li><a class="refuse hand" onclick="confirm_reject(this);"><span>아이콘</span>거절사유 확인</a></li>
								<li><a class="mod mod-left-non hand" onclick="modify_msg(this);"><span>아이콘</span>메시지 수정</a></li>
							</ul>
<?php }else{?>
							<div class="useyn clearbox">								
								<a class="mod hand" onclick="modify_msg(this);"><span>아이콘</span>메시지 수정</a>
							</div>
<?php }?>
<?php if($TPL_V2["approval"]=='N'||$TPL_V2["approval"]=='I'||$TPL_V2["approval"]=='Y'||$TPL_V2["approval"]=='M'){?>
							<div class="approval stay">
								<p><span>아이콘</span>승인 대기중(3~5일 소요)</p>
							</div>
<?php }?>
						</div>
					</div>
					
				</li>
<?php }}?>
<?php }?>
			</ul>
		</div>	
	</div>
<?php }}?>

	<div class="box_style_05">
		<div class="title">안내</div>
		<ul class="bullet_hyphen black">
			<li>알림톡 발송은 알림톡 충전 후 이용 가능합니다. &nbsp;<a href="/admin/member/kakaotalk_charge" class="resp_btn_txt">바로가기</a></li>
			<li>상황별 알림톡 메시지 제목 좌측 체크박스를 선택(체크)하여 발송여부를 설정합니다.</li>
			<li>알림톡과 SMS 동시 사용 중인 경우 알림톡이 우선 발송됩니다.</li>
			<li>카카오톡 미설치 등 알림톡을 발송할 수 없는 경우 발송 실패 처리됩니다. 발송 실패 시, 해당 메시지는 SMS 로 대체 발송됩니다.</li>
			<li>SMS 대체 발송은 [회원 &gt; SMS 자동발송] 기준으로 발송됩니다. &nbsp;<a href="/admin/member/sms" class="resp_btn_txt">바로가기</a></li>
			<li>승인대기중(또는 승인거절) 상태 시, 승인완료 전까지 퍼스트몰 기본 제공 메시지로 알림톡이 발송되며 승인완료 후 자동으로 변경된 메시지로 발송됩니다.</li>
			<li>승인대기중(또는 승인거절) 상태 시, 퍼스트몰 기본 알림톡 메시지 발송을 원치 않으실 경우 해당 메시지 발송 설정을 체크 해제하시면 됩니다.</li>
			<li>고객 리마인드 상황별 알림톡 메시지는 [회원 &gt; SMS/EMAIL 고객리마인드] 설정에 따라 발송됩니다.&nbsp;<a href="/admin/member/curation" class="resp_btn_txt">바로가기</a></li>
			<li>알림톡은 고객에게만 발송됩니다. 관리자는 SMS로 받을 수 있습니다.</li>
		</ul>
	</div>
</div>

<!-- 알림톡 자동발송 메세지 :: END -->

<!-- 서브 레이아웃 영역 : 끝 -->
</div>

<!-- 카카오 알림톡 부결사유 POPUP -->
<div id="rejectPopup" class="hide">
	<form name="comment_frm" id="comment_frm" action="../member_process/kakaotalk_template_comment" method="POST" target="actionFrame">
	<input type="hidden" name="reject_kkoBizCode" id="reject_kkoBizCode" value="" />
	<div class="item-title">거절 사유 확인</div>	
	<table class="table_basic thl">		
		<tr>
			<th>일시</th>
			<td id="rejectDate"></td>
		</tr>
		<tr>			
			<th>내용</th>
			<td id="rejectMess"></td>
		</tr>
	</table>
	<div class="resp_message">- 알림톡 승인거절 사유 확인 후 해당 메시지 수정 및 재검수 요청하시기 바랍니다.</div>
	
	<div class="item-title">답변 제출</div>	
	<textarea name="reject_comment" id="reject_comment" style="width:99%;height:80px;" maxlength="1000"></textarea>	
	<div class="resp_message">- 승인거절 사유로 카카오 측에서 답변을 요구한 경우, 아래에 내용 입력 후 제출하시기 바랍니다.</div>
	
	<div class="footer">
		<button type="button" onclick="template_comment();" class="resp_btn active size_XL">제출</button>
		<button type="button" onclick="closeDialog('rejectPopup')" class="resp_btn v3 size_XL">취소</button>
	</div>
	</form>
</div>

<!-- 카카오 알림톡 메세지 수정 POPUP -->
<div id="kakaotalkPopup" class="kakao_popup hide">
</div>

<?php if($_GET["no"]){?>
<script type="text/javascript">
tabmenu(<?php echo $_GET["no"]?>);
</script>
<?php }?>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>