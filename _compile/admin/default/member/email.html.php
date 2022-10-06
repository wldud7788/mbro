<?php /* Template_ 2.2.6 2022/05/25 15:03:06 /www/music_brother_firstmall_kr/admin/skin/default/member/email.html 000006850 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

	<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
<script type="text/javascript">
	$(document).ready(function() {
		//
		$(".selectMail").live("click",function(){

			$("input[name='mail_form']").val($(this).val());

		});

		$("input[name='mail']").val(['join']);
		$("input[name='mail_form']").val(["join"]);

		<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
		if($("input[name='marketing_agree_user_yn']").attr("checked")) {

			$("input[name='marketing_agree_user_yn']").hide().after('<input type="checkbox" checked disabled class="email_info"/>');

		}

		// EMAIL
		$("#email_form").click(function(){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
			var screenWidth;
			var screenHeight;

			screenWidth = 1200;
			screenHeight = 900;

			window.open('../batch/email_form',"send_email","menubar=no, toolbar=no, location=yes, status=no, resizble=yes, scrollbars=yes,width=" + screenWidth + ", height=" + screenHeight);
		});

		//메일 내용 수정
		$(".emailContentsModifyBtn").on("click", function(){
			var _mode = $(this).attr("mode"); 	
			window.open('email_contents_modify_pop?mode='+_mode,"send_email","menubar=no, toolbar=no, location=yes, status=no, resizble=yes, scrollbars=no,width=1000, height=900");
		});

		//체크박스 선택 시 제어사항
		$(".email_info").on("click", function(){
			email_info_act(this);
		});
	});
	function essential_func(e){
		if(!$(e).is(':checked')){
			ess_txt = '비밀번호';
			if($(e).prop('name') == 'findid_user_yn') ess_txt = '아이디';
			$('.ess_txt').text(ess_txt);
			$('.essential_ck').removeClass('essential_ck');
			$(e).prop('checked',true).addClass('essential_ck');
			openDialog('알림', 'essential', {'width':430,'height':190});
		}
	}


	function email_info_act(el) {
		var name = $(el).attr('name');
		
		if(name == 'coupon_released_user_yn' || name == 'coupon_delivery_user_yn') {
			$(el).attr('checked',true);
		}
		if(name == 'findid_user_yn' || name == 'findpwd_user_yn') {
			essential_func(el);
		}
		if(name == 'marketing_agree_user_yn') {
			marketing_agree_confirm(el);
		}
	}

	function dialog_linkage_sms_mail_info(){
		openDialog('외부 판매마켓 주문 문자/이메일 발송','linkage_sms_mail_info', {'width':772,'height':185});
	}
	
	function marketing_agree_confirm(e){
		if($(e).is(':checked')){
			openDialog('안내', 'marketing_agree_confirm', {'width':430,'height':190});
		}
	}
</script>
<style type="text/css">
	.table_basic > tbody > tr > th{ width: 25%; }
</style>


<form name="memberForm" id="memberForm" method="post" target="actionFrame" action="../member_process/email_info">

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<ul class="page-buttons-left">
			<li><button type="button" id="email_form" class="resp_btn active3 size_L">이메일 수동 발송</button></li>			
		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>이메일 발송 관리</h2>
		</div>
	
		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button type="submit" class="resp_btn active2 size_L">저장</button></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">

	<!-- 상단 단계 링크 : 시작 -->
	<ul class="tab_01 v2 tabEvent">
		<li><a href='email'>이메일 자동 발송</a></td>
		<li><a href='email_history'>이메일 발송 내역</a></td>
	</ul>
	<!-- 상단 단계 링크 : 끝 -->

	<!-- 서브 레이아웃 영역 : 시작 -->
<?php if($TPL_loop_1){$TPL_I1=-1;foreach($TPL_VAR["loop"] as $TPL_V1){$TPL_I1++;?>
	<div class="item-title "><?php echo $TPL_VAR["group_name"][$TPL_I1]['value']?> 이메일</div>

	<table class="table_basic tdc ">	
		<colgroup>
			<col width="20%" />					
			<col width="20%" />	
			<col width="20%" />	
			<col width="20%" />	
			<col width="20%" />	
		</colgroup>
		<tr>
			<th>메일</th>
			<th>고객</th>
			<th>관리자</th>
<?php if($TPL_VAR["scm_cfg"]["use"]=='Y'){?>
			<th>거래처</th>
<?php }?>
			<th>관리</th>
		</tr>
<?php if(is_array($TPL_R2=$TPL_V1["list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>	
		<tr>
			<td class="left"><?php echo $TPL_V2["text"]?></td>
			<td>
<?php if($TPL_V2["user_use"]){?>
				<label class="resp_checkbox"><input type="checkbox" name="<?php echo $TPL_V2["name"]?>_user_yn" value="Y" class="email_info" <?php echo $TPL_V2["user_chk"]?>> 발송</label>
<?php }?>
			</td>
			<td>
<?php if($TPL_V2["admin_use"]){?>
				<label class="resp_checkbox"><input type="checkbox" name="<?php echo $TPL_V2["name"]?>_admin_yn" value="Y" class="email_info" <?php echo $TPL_V2["admin_chk"]?>> 발송</label>
<?php }?>
			</td>
<?php if($TPL_VAR["scm_cfg"]["use"]=='Y'){?>
			<td>
<?php if($TPL_V2["order_use"]){?>
				<label class="resp_checkbox"><input type="checkbox" name="<?php echo $TPL_V2["name"]?>_user_yn" value="Y" class="email_info" <?php echo $TPL_V2["user_chk"]?>> 발송</label>
<?php }?>
			</td>
<?php }?>
			<td><button type="button" mode="<?php echo $TPL_V2["name"]?>" class="resp_btn v2 emailContentsModifyBtn">수정</button></td>
		</tr>
<?php }}?>
	</table>
<?php }}?>
</div>

</form>

<div id="linkage_sms_mail_info" class="hide">
<?php $this->print_("linkage_sms_mail_info",$TPL_SCP,1);?>

</div>

<div id="essential" class="hide">
	<ul>
		<li>해제를 하시면 회원에게 이메일로 <span class="ess_txt">아이디</span>를 전송하지 못합니다.</li>
		<li>해제하시려면 '확인'을 취소 하시려면 '취소'를 클릭해 주세요</li>
	</ul>
	<div class="center mt20">
		<span class="btn large cyanblue"><input type="button" onclick="$('.essential_ck').prop('checked',false);$('#essential').dialog('close')" value="해제"></span>
		<span class="btn large gray"><input type="button" onclick="$('#essential').dialog('close')" value="취소"></span>
	</div>
</div>

<div id="marketing_agree_confirm" class="hide">
	<ul>
		<li>익일부터 자동발송 됩니다. 자동발송 설정 후 다시 자동발송 해제가 불가능 합니다. 저장 하시겠습니까?</li>
	</ul>
	<div class="center mt20">
		<span class="btn large cyanblue"><input type="button" onclick="$('input[name=marketing_agree_user_yn]').css('display', 'none');$('#marketing_agree_confirm').dialog('close');" value="예"></span>
		<span class="btn large gray"><input type="button" onclick="$('input[name=marketing_agree_user_yn]').prop('checked', false);$('#marketing_agree_confirm').dialog('close');" value="아니오"></span>
	</div>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>