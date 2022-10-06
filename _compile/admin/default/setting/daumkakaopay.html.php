<?php /* Template_ 2.2.6 2022/05/17 12:36:56 /www/music_brother_firstmall_kr/admin/skin/default/setting/daumkakaopay.html 000004353 */ ?>
<script type="text/javascript">
var onInterestSettingButtonIndex = 0;

$(document).ready(function() {

	/* 세팅값 출력 */
<?php if($TPL_VAR["interestTerms"]){?>
	$("select[name='interestTerms'] option[value='<?php echo $TPL_VAR["interestTerms"]?>']").attr('selected',true);
<?php }?>

	kakao_sync_height();

	// 카드에 체크가 되어있을 때만 할부기간 활성화
	interestTermsDisabled();
	$("input[name^=payment_opt]").bind("click",function(){
		interestTermsDisabled();
	});
});

function interestTermsDisabled(){
	$("select[name='interestTerms']").attr("disabled", true);
	$("input[name^=payment_opt]").each(function(){
		if($(this).attr("checked") == "checked" && $(this).val()=="CARD"){
			$("select[name='interestTerms']").attr("disabled", false);
		}
	});
}

// 모바일/pc플랫폼 테이블간의 높의 조절
function kakao_sync_height(){
	$("div.daumkakaoinputPgSetting table.table_basic").eq(1).height( $("div.daumkakaoinputPgSetting table.table_basic").eq(0).height()+3 );
}

// 신용카드 무이자 할부 기간 체크
function kakao_check_nonInterest(){
	$("select[name='kakaopay_nonInterestTerms'] option").each(function(){
		if( $(this).attr('selected') ){
			if( $(this).val() == 'automatic' ){
				$(this).parent().next().hide().next().find("span:eq(0)").show();
				$(this).parent().next().next().find("span:eq(1)").hide();
				$(this).parent().next().next().next().hide();
			}else{
				$(this).parent().next().show().next().find("span:eq(1)").show();
				$(this).parent().next().next().find("span:eq(0)").hide();
				$(this).parent().next().next().next().show();
			}
		}
	});
}

</script>
<div class="clearbox daumkakaoinputPgSetting">
	<input type="hidden" name="nonActiveXUse" value="Y" />
	<table class="table_basic">
		<col width="25%" /><col/>
		<tr>
			<th class="center bold" colspan="2"  height="20">PC / 모바일</th>
		</tr>
		<tr>			
			<th class="left">사용여부</th>			
			<td class="resp_radio">
				<label><input type="radio" name="not_use_daumkakaopay" id="not_use_kakao_n" value='n' <?php if($TPL_VAR["config_system"]["not_use_daumkakaopay"]=='n'){?>checked<?php }?>> 사용</label>
				<label><input type="radio" name="not_use_daumkakaopay" id="not_use_kakao_y" value='y' <?php if($TPL_VAR["config_system"]["not_use_daumkakaopay"]=='y'||!$TPL_VAR["config_system"]["not_use_daumkakaopay"]){?>checked<?php }?>> 미사용</label>
			</td>			
		</tr>
		<tr>
			<th class="left">세팅 정보 등록</th>
			<td>
				CID : <input type="text" name="kakao_cid" class="line" value="<?php echo $TPL_VAR["cid"]?>" title="CID" /> <span class="red cid_require">!필수</span>			
			</td>
		</tr>
		<tr>
			<th class="left">결제방법</th>
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="payment_opt[]" value="CARD" <?php if(in_array('CARD',$TPL_VAR["payment_opt"])){?>checked<?php }?> /> 카드</label>					
					<label><input type="checkbox" name="payment_opt[]" value="MONEY" <?php if(in_array('MONEY',$TPL_VAR["payment_opt"])){?>checked<?php }?> /> 카카오머니</label>
				</div>
				<div class="mt5">
					할부기간 :
					<select name="interestTerms" >
						<option value="auto">자동</option>
						<option value="01">일시불</option>
						<option value="02">2개월</option>
						<option value="03">3개월</option>
						<option value="04">4개월</option>
						<option value="05">5개월</option>
						<option value="06">6개월</option>
						<option value="07">7개월</option>
						<option value="08">8개월</option>
						<option value="09">9개월</option>
						<option value="10">10개월</option>
						<option value="11">11개월</option>
						<option value="12">12개월</option>
					</select>
					<span class="desc">고정할부값 미사용 시 `자동` 선택</span>
				</div>
			</td>
		</tr>
	</table>	
</div>
</form>
<script type="text/javascript">
$(".helpicon").poshytip({
	className: 'tip-darkgray',
	bgImageFrameSize: 8,
	alignTo: 'target',
	alignX: 'right',
	alignY: 'center',
	offsetX: 10,
	allowTipHover: false,
	slide: false,
	showTimeout : 0
});
</script>