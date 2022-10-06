<?php /* Template_ 2.2.6 2022/05/17 12:36:30 /www/music_brother_firstmall_kr/admin/skin/default/member/sms_auth.html 000008636 */ 
$TPL_admins_arr_1=empty($TPL_VAR["admins_arr"])||!is_array($TPL_VAR["admins_arr"])?0:count($TPL_VAR["admins_arr"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	$(document).ready(function() {

		//
		$("#addNum").bind("click",function(){
			var cnt		= $(".admins_num1").length + 1;
			var idx		= cnt - 1;
			var addHtml	= "<tr><td class='pdt5'>";
			addHtml += "관리자("+cnt+") <input type=\"text\" name=\"admins_num1[]\" size=\"5\" maxlength=\"4\" class='admins_num1'> - <input type=\"text\" name=\"admins_num2[]\" size=\"5\" maxlength=\"4\"> - <input type=\"text\" name=\"admins_num3[]\" size=\"5\" maxlength=\"4\">";
			addHtml += " <span class=\"btn_minus\" id=\"delNum\"  idx=\""+idx+"\"></span>";
			addHtml += "</td></tr>";
			$('#add_plus_phone').append(addHtml);

			var disabled	= '';
			var name		= '';
			var ynHtml		= '';
			$(".admin_yn_lay").each(function(){
				name		= $(this).attr('area');
				disabled	= $(this).attr('dis');
				ynHtml	= '<div id="admins_yn_label_'+idx+'"><label><input type="checkbox" name="'+name+'_admins_yn_'+idx+'" value="Y" '+disabled+' /> 관리자('+cnt+')</label></div>';
				$(this).append(ynHtml);
			});
		});
		$("#delNum").live("click",function(){
			$("div#admins_yn_label_"+$(this).attr('idx')).remove();
			$(this).parent().parent().remove();
		});

		// SMS
		$("#sms_form").click(function(){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }else{?>
			var screenWidth;
			var screenHeight;

			screenWidth = 1000;
			screenHeight = 750;

			window.open('../batch/sms_form',"sms_form","menubar=no, toolbar=no, location=yes, status=no, resizble=yes, scrollbars=yes,width=" + screenWidth + ", height=" + screenHeight);
<?php }?>
		});			
	});

	function openKeyInput(){
		openDialog('보안키 변경','sms_safe_key', {'width':440,'height':200});
	}

	function apiKeyInput(){
		$("input[name='sms_auth']").val($("input[name='sms_auth_input']").val());
		document.memberForm.submit();
	}
</script>

<form name="smsForm" id="smsForm" method="post" target="actionFrame" action="../member_process/sms_auth">
<input type="hidden" name="mode" value="admin" />
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<ul class="page-buttons-left" style="z-index:1;">			
			<li><button type="button" id="sms_form" class="resp_btn active3 size_L">SMS 수동 발송</button></li>			
		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>SMS 발송 관리</h2>
		</div>

		<!-- 좌측 버튼
		<ul class="page-buttons-left">
			<li><span class="btn large icon"><button><span class="arrowleft"></span>이동버튼</button></span></li>
			<li><span class="btn large icon"><button><span class="arrowleft"></span>이동버튼</button></span></li>
		</ul> -->

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button  <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  type="button" <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> type="submit" <?php }?>  class="resp_btn active2 size_L">저장</button></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">
<?php if($TPL_VAR["kakaouse"]=='Y'){?>
	<div class="box_style_06 mb20">
		현재 귀하의 쇼핑몰은 "카카오 알림톡" 자동 발송을 사용 중입니다. <a href="/admin/member/kakaotalk_msg" target="_blank" class="resp_btn_txt">설정 방법 </a>
	</div>
<?php }?>

<?php $this->print_("top_menu",$TPL_SCP,1);?>


	<!-- 서브 레이아웃 영역 : 시작 -->
	<div class="item-title">보안키</div>

	<table class="table_basic thl">		
		<tr>
			<th>보안키 등록</th>
			<td>
<?php if($TPL_VAR["sms_auth"]){?>
					<button type="button" onclick="openKeyInput();" class="resp_btn active">변경</button> 보안키가 등록되었습니다.
<?php }else{?>
					<button type="button" onclick="openKeyInput();" class="resp_btn active">등록</button> 입력된 보안키가 없습니다. 
<?php }?>
			</td>
		</tr>		
	</table>

	<div class="item-title">SMS 번호 설정</div>
	<table class="table_basic thl">		
		<tr>
			<th>발신 번호</th>
			<td>
<?php if($TPL_VAR["send_phone"]){?><?php echo $TPL_VAR["send_phone"]?><?php }else{?>등록된 발신 번호가 없습니다.<?php }?>
				<input type="hidden" name="send_num[]" size="5" maxlength="4" value="<?php echo $TPL_VAR["send_num"][ 0]?>"><input type="hidden" name="send_num[]" size="5" maxlength="4" value="<?php echo $TPL_VAR["send_num"][ 1]?>"><input type="hidden" name="send_num[]" size="5" maxlength="4" value="<?php echo $TPL_VAR["send_num"][ 2]?>">
			</td>
		</tr>
		
		<tr>
			<th>관리자 수신 번호</th>
			<td>				
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tbody id="add_plus_phone">
<?php if($TPL_VAR["admins_arr"]){?>
<?php if($TPL_admins_arr_1){$TPL_I1=-1;foreach($TPL_VAR["admins_arr"] as $TPL_V1){$TPL_I1++;?>
						<tr>
							<td <?php if($TPL_I1> 0){?>class='pdt5'<?php }?>>						
								관리자(<?php echo $TPL_I1+ 1?>) 
								<input type="text" name="admins_num1[]" size="5" maxlength="4" value="<?php echo $TPL_V1["number"][ 0]?>" class="admins_num1"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>  > - <input type="text" name="admins_num2[]" size="5" maxlength="4" value="<?php echo $TPL_V1["number"][ 1]?>"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>  > - <input type="text" name="admins_num3[]" size="5" maxlength="4" value="<?php echo $TPL_V1["number"][ 2]?>"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>  >
<?php if($TPL_I1== 0){?><span class="btn_plus" id="addNum"></span><?php }else{?><span class="btn_minus" id="delNum" idx="<?php echo $TPL_I1?>"></span><?php }?>
							</td>
						</tr>
<?php }}?>
<?php }else{?>
					<tr>
						<td>관리자(1) <input type="text" name="admins_num1[]" size="5" maxlength="4" class="admins_num1"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>  > - <input type="text" name="admins_num2[]" size="5" maxlength="4"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>  > - <input type="text" name="admins_num3[]" size="5" maxlength="4"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>  > <span class="btn_plus" id="addNum"></span></td>
					</tr>
<?php }?>
					</tbody>
				</table>
			</td>
		</tr>
	</table>

	<div class="box_style_05 resp_message">
		<div class="title">안내</div>
		<ul class="bullet_circle">					
			<li>보안키 발급 방법 <a href="https://www.firstmall.kr/customer/faq/1258" target="_blank" class="resp_btn_txt">자세히 보기</a></li>
			<li>발신 번호 인증/변경 방법 <a href="https://www.firstmall.kr/customer/faq/180" target="_blank" class="resp_btn_txt">자세히 보기</a></li>
			<li>보안키 입력 및 발신번호 인증 후 SMS 발송이 가능합니다.</li>
			<li>SMS 발송의 보안을 강화하기 위해 정기적으로 보안키 변경을 적극 권장 드립니다.</li>
			<li>보안키 변경 후 변경 후에는 반드시 재발급된 보안키로 다시 입력해주세요.</li>
		</ul>
	</div>
</form>
</div>

<div id="sms_safe_key" class="hide">
	<form name="memberForm" id="memberForm" method="post" target="actionFrame" action="../member_process/sms_auth">
	<input type="hidden" name="sms_auth" value="" size="40" title="보안키 입력"/>
	<table class="table_basic thl">		
		<tr>
			<th>보안키</th>
			<td><input type="password" name="sms_auth_input" value="" size="40" /></td>
		</tr>								
	</table>		
	
	<div class="footer">
		<button <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  type="button" <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> type="button" onclick="apiKeyInput();" <?php }?> class="resp_btn active size_XL">확인</button>
		<button type="button" onclick="closeDialog('sms_safe_key');" class="resp_btn v3 size_XL">취소</button>
	</div>
	</form>
</div>


<script type="text/javascript">
var no = <?php echo $_GET['no']?>;
tabmenu(no);
</script>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>