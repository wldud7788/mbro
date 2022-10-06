<?php /* Template_ 2.2.6 2022/05/17 12:36:31 /www/music_brother_firstmall_kr/admin/skin/default/member/sms_pop.html 000004466 */ ?>
<?php if($TPL_VAR["css"]!='common-ui'){?>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common-ui.css?mm=<?php echo date('Ymd')?>" />
<?php }?>
<script type="text/javascript">
$(document).ready(function() {
<?php if($_GET["page"]=='refund'){?>
		$("select[name='memo_type']").live('change',function(){
			if($(this).val()=='direct'){
				$("input[name='memo_direct']").show();
			}else{
				$("input[name='memo_direct']").hide();
			}
		});

		$("input[name='send_sms']").bind('click',function(){
			if($(this).attr("checked")){
				$(".sms").attr("disabled",false);

				/* 2021.12.30 11월 3차 패치 by 김혜진 */
				// 개인정보 마스킹 처리 입력폼 비활성화
<?php if($TPL_VAR["private_masking"]){?>
				$("input[name='cellphone']").attr('disabled',true);
<?php }?>
			}else{
				$(".sms").attr("disabled",true);
			}
		});

		$("#smsFrm input[name='msg']").bind("keydown",function(){
			str = $(this).val();
			$(this).parent().find(".sms_byte").html(chkByte(str));
		});
<?php }else{?>
		//내용입력 byte
		addTextByteEvent()
<?php }?>
});

</script>


<form name="smsFrm" id="smsFrm" method="post" target="actionFrame" action="/admin/member_process/sms_pop">
	<input type="hidden" name="member_seq" value="<?php echo $TPL_VAR["member_seq"]?>"/>
	<!-- 2021.12.30 11월 3차 패치 by 김혜진 -->
	<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["order_seq"]?>"/>
	<input type="hidden" name="type" value="<?php echo $TPL_VAR["type"]?>"/>
<?php if($_GET["page"]=='refund'){?>
	<table width="100%" class="info-table-style">
	<tbody>
	<tr>
		<th class="its-th-align">

		<table width="100%">
		<tr>
			<td>
				<div><input type="checkbox" name="send_sms" value="Y" <?php if($TPL_VAR["count"]< 1){?>disabled<?php }?>>SMS 전송  [ 보유SMS건수 : <?php echo $TPL_VAR["count"]?>통, 90 bytes 이상 시 LMS로 발송이 되며 3건이 차감됩니다.]</div>
				<input type="text" name="cellphone" value="<?php if($TPL_VAR["bcellphone"]){?><?php echo $TPL_VAR["bcellphone"]?><?php }else{?><?php echo $TPL_VAR["cellphone"]?><?php }?>" class="line sms" disabled size="14">
				<input type="text" name="msg" class="line sms" <?php if($TPL_VAR["certify_code_msg"]){?> value="<?php echo $TPL_VAR["certify_code_msg"]?>" <?php }?> title="메시지를 입력하세요."  size="50">
				<b class="sms_byte">0</b>byte
			</td>
		</tr>
		<tr><td height="10"></td></tr>
		<tr>
			<td>
			<span class="btn large cyanblue"><button <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  type="button"  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?>  type="submit"  id="send_submit" <?php }?> >확인</button></span>
			</td>
		</tr>
		</table>

		</th>
	</tr>
	</tbody>
	</table>
<?php }else{?>
	<div class="item-title">SMS 발송</div>
	<table class="table_basic thl">
		<tr>
			<th>잔여 건수</th>
			<td>잔여 <?php echo $TPL_VAR["count"]?>건</td>
		</tr>

		<tr>
			<th>받는 사람</th>
			<td>
				<input type="text" name="cellphone" class="sms" value="<?php if($TPL_VAR["bcellphone"]){?><?php echo $TPL_VAR["bcellphone"]?><?php }else{?><?php echo $TPL_VAR["cellphone"]?><?php }?>" <?php if($TPL_VAR["private_masking"]){?>disabled<?php }?>>
			</td>
		</tr>

		<tr>
			<th>내용</th>
			<td>
				<input type="checkbox" name="send_sms" value="Y" <?php if($TPL_VAR["count"]< 1){?>disabled<?php }else{?>checked<?php }?> class="hide">
				<div class="resp_limit_text textByteEvent">
					<input type="text" name="msg" class="resp_text sms" <?php if($TPL_VAR["certify_code_msg"]){?> value="<?php echo $TPL_VAR["certify_code_msg"]?>" <?php }?> title="메시지를 입력하세요." size="50"  maxByte="" <?php if($TPL_VAR["count"]< 1){?>disabled<?php }?>>
				</div>
			</td>
		</tr>
	</table>
	<div class="resp_message">- 90 bytes 이상 시 LMS로 발송이 되며 3건이 차감됩니다.</div>

	<div class="footer">
		<button class="resp_btn active size_XL" <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  type="button"  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?>  type="submit"  id="send_submit" <?php }?> >발송</button>
		<button class="resp_btn v3 size_XL" type="button" onclick="closeDialogEvent(this);">취소</button>
	</div>
<?php }?>

</form>