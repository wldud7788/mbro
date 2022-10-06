<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/setting/payco.html 000004798 */ 
$TPL_payco_payment_1=empty($TPL_VAR["payco_payment"])||!is_array($TPL_VAR["payco_payment"])?0:count($TPL_VAR["payco_payment"]);
$TPL_payco_mobilePayment_1=empty($TPL_VAR["payco_mobilePayment"])||!is_array($TPL_VAR["payco_mobilePayment"])?0:count($TPL_VAR["payco_mobilePayment"]);?>
<script type="text/javascript">
var onInterestSettingButtonIndex = 0;

$(document).ready(function() {

	payco_sync_height();

<?php if($TPL_payco_payment_1){foreach($TPL_VAR["payco_payment"] as $TPL_V1){?>
	$("input[name='payco_payment[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>

<?php if($TPL_payco_mobilePayment_1){foreach($TPL_VAR["payco_mobilePayment"] as $TPL_V1){?>
	$("input[name='payco_mobilePayment[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>

	// 페이코 사용여부 테스트 자동 체크 기능 추가
	$("input[name=not_use_payco]").change(function(){
		if($(this).val() == 'n'){
			$("input[name='use_set']").attr("checked", true);
		}else if($(this).val() == 'y'){
			$("input[name='use_set']").attr("checked", false);
		}
	});
	// 페이코 테스트 체크
	$("input[name=use_set]").click(function(){
		if($(this).attr("checked") == 'checked' && $("input[name=not_use_payco]:checked").val() == 'y'){
			alert('페이코 미사용일땐 테스트를 선택할 수 없습니다.');
			$("input[name='use_set']").attr("checked", false);
		}
	});
});

// 모바일/pc플랫폼 테이블간의 높의 조절
function payco_sync_height(){
	var h = $("div.paycoinputPgSetting").eq(0).height() ;
	$("div.paycoinputPgSetting table.table_basic").eq(1).height( $("div.paycoinputPgSetting table.table_basic").eq(0).height()  +3 );
}

</script>
<div class="clearbox paycoinputPgSetting">
	<table class="table_basic">
		<col width="25%" /><col/>
		<tr>
			<th class="center bold" colspan="3"  height="20">PC / 모바일</th>
		</tr>
		<tr>		
			<th class="left">사용여부</th>
			<td>
				<label class="resp_radio"><input type="radio" name="not_use_payco" id="not_use_payco_n" value='n' <?php if($TPL_VAR["config_system"]["not_use_payco"]=='n'){?>checked<?php }?>> 사용</label> 
				<label class="resp_checkbox">(<input type="checkbox" name="use_set" value="test" <?php if($TPL_VAR["use_set"]=='test'||!$TPL_VAR["use_set"]){?>checked<?php }?> /> 테스트)</label>
			
				<label class="resp_radio ml15"><input type="radio" name="not_use_payco" id="not_use_payco_y" value='y' <?php if($TPL_VAR["config_system"]["not_use_payco"]=='y'||!$TPL_VAR["config_system"]["not_use_payco"]){?>checked<?php }?>> 미사용</label>				
				<div class="gray">- ‘테스트‘ 선택 시, 관리자가 로그인한 경우만 결제 버튼이 제공되며 실제 결제처리가 진행됩니다.</div>
				<input type="text" class="hide" name="payco_currency" value="<?php echo $TPL_VAR["payco_currency"]?>" style="width:50px;text-align:right;">
			</td>
		</tr>
		<tr>
			<th class="left">세팅 정보 등록</th>
			<td>
				<table class="inner-table">
				<tr>
					<td>PAYCO코드(sellerKey)</td>
					<td>
						<input type="text" name="sellerKey_tmp" id="sellerKey_tmp" value="<?php echo $TPL_VAR["sellerKey"]?>" disabled/> <span class="red cid_require">!필수</span>
						<input type="hidden" name="sellerKey" id="sellerKey" value="<?php echo $TPL_VAR["sellerKey"]?>" />
						<input type="hidden" name="cpId" id="cpId" value="<?php echo $TPL_VAR["cpId"]?>" />
						<input type="hidden" name="productId" id="productId" value="<?php echo $TPL_VAR["productId"]?>" />
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<th class="left">결제방법</th>
			<td class="resp_checkbox">
				<label><input type="checkbox" name="method_code[]" value="31" <?php if(strpos($TPL_VAR["method_code"],'31')){?>checked<?php }?>/> 신용카드</label>
				<label><input type="checkbox" name="method_code[]" value="35" <?php if(strpos($TPL_VAR["method_code"],'35')){?>checked<?php }?>/> 간편계좌(계좌이체)</label>
				<label><input type="checkbox" name="method_code[]" value="02" <?php if(strpos($TPL_VAR["method_code"],'02')){?>checked<?php }?>/> 무통장입금(가상계좌)</label>
				<!-- 포인트와 쿠폰은 기본 결제 방식 #26000 by hed -->
				<input type="hidden" name="method_code[]" value="98"/> <!-- 페이코 포인트 -->
				<input type="hidden" name="method_code[]" value="75"/> <!-- 페이코 쿠폰 -->
				<input type="hidden" name="method_code[]" value="76"/> <!-- 카드 쿠폰 -->
				<input type="hidden" name="method_code[]" value="77"/> <!-- 가맹점 쿠폰 -->
			</td>
		</tr>
	</table>	
</div>
</form>