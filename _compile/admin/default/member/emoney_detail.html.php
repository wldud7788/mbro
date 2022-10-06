<?php /* Template_ 2.2.6 2022/05/17 12:36:27 /www/music_brother_firstmall_kr/admin/skin/default/member/emoney_detail.html 000007403 */ ?>
<script type="text/javascript">
$(document).ready(function() {
	$("select[name='gb']").live('change',function(){
		if($(this).val()=='minus'){
			$(".reserve_select_lay").hide();
		}else{
			$(".reserve_select_lay").show();
		}
	});
	$("select[name='memo_type']").live('change',function(){
		if($(this).val()=='direct'){
			$("input[name='memo_direct']").show();
		}else{
			$("input[name='memo_direct']").hide();
		}
	});
	// 추가한 메시지 디폴트
	$("select[name='memo_type2']").live('change',function(){
		if($(this).val()=='direct'){
			$("input[name='memo_direct']").show();
		}else{
			$("input[name='memo_direct']").hide();
		}
	});

	$("input[name='send_sms']").bind('click',function(){
		if($(this).attr("checked")){
			$(".sms").attr("disabled",false);
		}else{
			$(".sms").attr("disabled",true);
		}
	});

	$("select[name='reserve_select']").live("change",function(){
		span_controller('reserve');
	});

	$('#reserve_year').val('<?php echo $TPL_VAR["reserve"]["reserve_year"]?>');

	$.ajax({
		url: "/admin/member/coin_value",
		success:function(data){
			$("input[id='RATE']").val(data);
		}
	});
});


function span_controller(name){
	var reserve_y = $("span[name='"+name+"_y']");
	var reserve_d = $("span[name='"+name+"_d']");
	var value = $("select[name='"+name+"_select'] option:selected").val();
	if(value==""){
		reserve_y.hide();
		reserve_d.hide();
	}else if(value=="year"){
		reserve_y.show();
		reserve_d.hide();
	}else if(value=="direct"){
		reserve_y.hide();
		reserve_d.show();
	}
}

function pop_history(seq){
	$.get('used_history?type=emoney&seq='+seq, function(data) {
		$('#usedPopup').html(data);
		openDialog("차감 내역", "usedPopup", {"width":"600","height":"250"});
	});
}
</script>


<form name="emoneyFrm" id="emoneyFrm" method="post" target="actionFrame" action="/admin/member_process/emoney_detail">
<input type="hidden" name="member_seq" value="<?php echo $TPL_VAR["member_seq"]?>"/>

<table width="100%" style="border:2px solid #e1e1e1">
<tbody>
<tr>
	<th class="pd20"><span style="font-size:14px;font-weight:bold;"><?php echo $TPL_VAR["user_name"]?></span>(<?php if($TPL_VAR["userid"]==$TPL_VAR["sns_n"]){?><?php echo $TPL_VAR["conv_sns_n"]?><?php }else{?><?php echo $TPL_VAR["userid"]?><?php }?>) 회원님이 보유한 캐시는 <span style="font-size:14px;font-weight:bold;"><?php echo get_currency_price($TPL_VAR["emoney"])?></span><?php echo $TPL_VAR["basic_currency"]?> 입니다.</th>
</tr>
</table>


<div class="item-title" style="width:92%">캐시 지급/차감 <span class="helpicon" title="수동으로 캐시를 지급 또는 차감할 수 있습니다."></span></div>

<table width="100%" class="info-table-style">
<tbody>
<tr>
	<th class="its-th-align">

	<table width="100%">
	<tr>
		시세 &nbsp<input type="text" id="BMP" name="시세" size="7" oninput="calculate()" > X 
		충전할 BMP &nbsp<input type="text" id="RATE" value="<?php echo $TPL_VAR["coinrate"]["rate"]?>"  size="7" readonly> =
		전환 될 캐시 &nbsp<input type="text" id="TOTAL2" value="" size="10" readonly>

		<td class="right pdr20">
			금액 : <select name="gb">
				<option value="plus">지급(+)</option>
				<option value="minus">차감(-)</option>
			</select>
			<input type="text" name="emoney" class="line onlyfloat" size="7"><?php echo $TPL_VAR["basic_currency"]?>

		</td>
		<td class="left pdl20">
			사유 :
			<select name="memo_type">
				<option value="">== 선택해 주세요 ==</option>
				<option value="신규 회원가입 지급">신규 회원가입 지급</option>
				<option value="상품구매 추가 적립">상품구매 추가 적립</option>
				<option value="상품구매 사용 차감">상품구매 사용 차감</option>
				<option value="BMP 코인 전환">BMP 코인 전환</option>
				<option value="10% 추가 전환">10% 추가 전환</option>
			</select>
			<input type="text" name="memo_direct" class="line hide">
		</td>
	</tr>
	<tr>
		<td height="40" class="right pdr20">
			<span class="reserve_select_lay">
				유효기간 : <select name="reserve_select">
					<option value="">제한하지 않음</option>
					<option value="year" <?php if($TPL_VAR["reserve"]["reserve_select"]=='year'){?>selected<?php }?>>제한 - 12월31일</option>
					<option value="direct" <?php if($TPL_VAR["reserve"]["reserve_select"]=='direct'){?>selected<?php }?>>제한 - 직접입력</option>
				</select>
			</span>
			<span name="reserve_y" class="hide">→ 
			<select name="reserve_year" id="reserve_year">
<?php if(is_array($TPL_R1=range( 0, 9))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
				<option value="<?php echo $TPL_K1?>"><?php echo intval(date('Y'))+intval($TPL_K1)?>년</option>
<?php }}?>
			</select>
			12월 31일</span>
			<span name="reserve_d" class="hide">→ <input type="text" name="reserve_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["reserve"]["reserve_direct"]?>" />개월</span>
			</span>
		</td>
		<td class="left pdl20">
			처리자 : <?php echo $TPL_VAR["mname"]?>

		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div class="pdb10"><input type="checkbox" name="send_sms" value="Y" <?php if($TPL_VAR["count"]< 1||!$TPL_VAR["send_phone"]){?>disabled<?php }?>> SMS 전송  [ 보유SMS건수 : <?php echo number_format($TPL_VAR["count"])?>통, 90바이트 이상 시 LMS로 발송이 되며 3건이 차감됩니다. ]</div>
			<input type="text" name="cellphone" value="<?php echo $TPL_VAR["cellphone"]?>" class="line sms" disabled size="14">
			<!-- <input type="text" name="msg" class="line sms" title="메시지를 입력하세요." disabled size="50"> -->
			<select name=" msg">
				<option value="선택해 주세요" class="line sms" disabled size="50">== 선택해 주세요 ==</option>
				<option value="안녕하세요 음악형제들에서 알려드립니다. 캐시가 충전되셨습니다. 마이페이지 나의 캐시 내역에서 확인하실 수 있습니다." class="line sms" disabled size="50">안녕하세요 음악형제들에서 알려드립니다. 캐시가 충전되셨습니다. 마이페이지 나의 캐시 내역에서 확인하실 수 있습니다.</option>
				<option value="안녕하세요 음악형제들에서 알려드립니다. 캐시가 차감되셨습니다. 마이페이지 나의 캐시 내역에서 확인하실 수 있습니다." class="line sms" disabled size="50">안녕하세요 음악형제들에서 알려드립니다. 캐시가 차감되셨습니다. 마이페이지 나의 캐시 내역에서 확인하실 수 있습니다.</option>
			</select>
		</td>
	</tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td colspan="2">
			<span class="btn large cyanblue"><button type="submit" id="send_submit">확인</button></span>
		</td>
	</tr>
	</table>

	</th>
</tr>
</tbody>
</table>

<div>
<iframe id="mbcontaineremoney" src="/admin/member/emoney_list?member_seq=<?php echo $TPL_VAR["member_seq"]?>" style="width:100%;" height="450"  scrolling="no" frameborder="0"></iframe>
</div>


</form>
<div id="usedPopup" class="hide"></div>
<script>
	function calculate() {
		var bmp = document.getElementById("BMP").value;
		var rate = document.getElementById("RATE").value;
		var total = bmp*rate;

		document.getElementById("TOTAL2").value = total; 
	}
</script>