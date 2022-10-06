<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/setting/allat.html 000017257 */ 
$TPL_payment_1=empty($TPL_VAR["payment"])||!is_array($TPL_VAR["payment"])?0:count($TPL_VAR["payment"]);
$TPL_escrow_1=empty($TPL_VAR["escrow"])||!is_array($TPL_VAR["escrow"])?0:count($TPL_VAR["escrow"]);
$TPL_mobilePayment_1=empty($TPL_VAR["mobilePayment"])||!is_array($TPL_VAR["mobilePayment"])?0:count($TPL_VAR["mobilePayment"]);
$TPL_mobileEscrow_1=empty($TPL_VAR["mobileEscrow"])||!is_array($TPL_VAR["mobileEscrow"])?0:count($TPL_VAR["mobileEscrow"]);?>
<script type="text/javascript">
var onInterestSettingButtonIndex = 0;

/* 모바일/pc플랫폼 테이블간의 높의 조절 */
function sync_height(){
	$("div.inputPgSetting table.info-table-style").eq(1).height( $("div.inputPgSetting table.info-table-style").eq(0).height() );
}

$(document).ready(function() {

	/* 세팅값 출력 */
<?php if($TPL_payment_1){foreach($TPL_VAR["payment"] as $TPL_V1){?>
	$("input[name='payment[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>
<?php if($TPL_escrow_1){foreach($TPL_VAR["escrow"] as $TPL_V1){?>
	$("input[name='escrow[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>
	$("input[name='nonInterestYn'][value='<?php echo $TPL_VAR["nonInterestYn"]?>']").attr('checked',true);
<?php if($TPL_VAR["interestTerms"]!=''){?>
	$("select[name='interestTerms'] option[value='<?php echo $TPL_VAR["interestTerms"]?>']").attr('selected',true);
<?php }?>
	$("input[name='cashReceipts'][value='<?php echo $TPL_VAR["cashReceipts"]?>']").attr('checked',true);
<?php if($TPL_mobilePayment_1){foreach($TPL_VAR["mobilePayment"] as $TPL_V1){?>
	$("input[name='mobilePayment[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>
<?php if($TPL_mobileEscrow_1){foreach($TPL_VAR["mobileEscrow"] as $TPL_V1){?>
	$("input[name='mobileEscrow[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>
	$("input[name='mobileNonInterestYn'][value='<?php echo $TPL_VAR["mobileNonInterestYn"]?>']").attr('checked',true);
<?php if($TPL_VAR["mobileInterestTerms"]!=''){?>
	$("select[name='mobileInterestTerms'] option[value='<?php echo $TPL_VAR["mobileInterestTerms"]?>']").attr('selected',true);
<?php }?>
	$("input[name='mobileCashReceipts'][value='<?php echo $TPL_VAR["mobileCashReceipts"]?>']").attr('checked',true);

	/* 인풋박스 타이틀 표기 */
	setDefaultText();

	/* 모바일/pc플랫폼 테이블간의 높의 조절 */
	sync_height();

	/* 파일업로드버튼 ajax upload 적용 */
	var opt			= {};
	var callback	= function(res){
		var that		= this;
		var result		= eval(res);

		if(result.status){
			$(that).closest('.webftpFormItem').find('.webftpFormItemPreview').attr('src', result.filePath + result.fileInfo.file_name);
			$(that).closest('.webftpFormItem').find('.webftpFormItemPreview').css('display', 'block');
			$(that).closest('.webftpFormItem').find('.webftpFormItemInput').val( result.filePath +result.fileInfo.file_name);
		}else{
			alert(result.msg);
		}
	};

	// ajax 이미지 업로드 이벤트 바인딩
	$('#escrowMarkUploadButton').createAjaxFileUpload(opt, callback);
	$('#escrowMarkMobileUploadButton').createAjaxFileUpload(opt, callback);

	/* 플래시 복사 제거 pjw 2019-06-20 */
	$("#escrow_mark_copy_btn").click(function(){
		clipboard_copy('\{=escrow_mark()\}');
		alert('복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.');
	});

	/* 플래시 복사 제거 pjw 2019-06-20 */
	$("#escrow_mark_copy_mobile_btn").click(function(){
		clipboard_copy('\{=escrow_mark_mobile()\}');
		alert('복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.');
	});
	
	
	$("input[name='payment[]'],input[name='mobilePayment[]'],input[name='escrow[]'],input[name='mobileEscrow[]']").bind("change",function(){
		check_use_payment();
	});
	
	check_use_payment();

	$("input[name='virtual_info'][value='"+$("select[name='pgCompany']").val()+"']").attr("checked",true);

});

function check_use_payment(){	
	$("input[name='payment[]'],input[name='mobilePayment[]'],input[name='escrow[]'],input[name='mobileEscrow[]']").each(function(){
		if( !$(this).is(":checked") ){
			$(this).closest("td").find("input,select").not(this).attr('disabled',true);
		}else{
			$(this).closest("td").find("input,select").not(this).removeAttr('disabled');			
		}
	});
}

</script>
<div class="clearbox inputPgSetting">
	<div style="float:left;width:50%">
	<table width="100%" class="table_basic">
		<col width="10%" /><col width="10%" /><col width="30%" />
		<tr>
			<th class="its-th center bold" colspan="3" height="20">PC</th>
		</tr>
		<tr>
			<th class="its-th" style="min-width:100px;">결제통화</th>
			<td class="its-td" style="min-width:120px;">통화설정</td>
			<td class="its-td">결제수단 공통 설정 : KRW</td>
		</tr>
		<tr>
			<th class="its-th" rowspan="6">일반</th>
			<td class="its-td">결제 모듈</td>
			<td class="its-td">
<?php if($TPL_VAR["mallCode"]==""){?>
					[NON-ActiveX] All@PayNAX
					<input type="hidden" name="nonActiveXUse" value="Y"/>
<?php }else{?>
					<input type="radio" class="line" name="nonActiveXUse" id="nonActiveXNot" size="40" value="N" title="웹표준 결제 사용안함" <?php if($TPL_VAR["nonActiveXUse"]==""||$TPL_VAR["nonActiveXUse"]=="N"){?> checked = "checked" <?php }?>/> <label for="nonActiveXNot">All@Pay</label><br/>			
					<input type="radio" class="line" name="nonActiveXUse" id="nonActiveXUse" size="40" value="Y" title="웹표준 결제 사용" <?php if($TPL_VAR["nonActiveXUse"]=="Y"){?> checked = "checked" <?php }?> /> <label for="nonActiveXUse">[NON-ActiveX] All@PayNAX</label>
<?php }?>			
			</td>
		</tr>		
		<tr>
			<td class="its-td">세팅 정보 등록</td>
			<td class="its-td">
				<div><input type="text" name="mallCode" class="line" value="<?php echo $TPL_VAR["mallCode"]?>" title="상점ID" /></div>
				<div class="desc">
				상점ID는 <span class="bold black">FM_, FF_</span>로 시작하는 표준ID만 입력이 가능합니다.
				</div>
				<div style="padding-top:5px;"><input type="text" class="line" name="merchantKey" size="40" value="<?php echo $TPL_VAR["merchantKey"]?>" title="크로스 Key" /></div>			
			</td>
		</tr>
		<tr>
			<td class="its-td">신용카드</td>
			<td class="its-td">
				<div><label class="resp_checkbox"><input type="checkbox" name="payment[]" value="card" /> 사용</label></div>
				<div style="padding-top:5px;">
					할부기간 :
					<select name="interestTerms">
						<option value="0">일시불</option>
						<option value="2">2개월</option>
						<option value="3">3개월</option>
						<option value="4">4개월</option>
						<option value="5">5개월</option>
						<option value="6">6개월</option>
						<option value="7">7개월</option>
						<option value="8">8개월</option>
						<option value="9">9개월</option>
						<option value="10">10개월</option>
						<option value="11">11개월</option>
						<option value="12">12개월</option>
					</select>
					<span class="desc">할부가 가능한 최대기간을 선택</span>
				</div>
				<div style="padding-top:5px;">
				<label class="resp_checkbox"><input type="checkbox" name="nonInterestYn" value="y" /> 무이자할부 사용</label>
				</div>
			</td>
		</tr>
		<tr>
			<td class="its-td">계좌이체</td>
			<td class="its-td"><label class="resp_checkbox"><input type="checkbox" name="payment[]" value="account" /> 사용</label></td>
		</tr>
		<tr>
			<td class="its-td">가상계좌</label></td>
			<td class="its-td">				

				<div>
					<label>
						<input type="checkbox" name="payment[]" value="virtual" />
						사용
					</label>
					<button type="button" class="button_virtual_info resp_btn">입금 확인 URL 설정</button>
				</div>
				<div>
					<div class="desc">아래의 가상계좌 입금확인 URL을 반드시 세팅 하십시오.</div>
					<div class="desc">세팅하지 않으시면 자동으로 입금확인 되지 않습니다!</div>
					<div>http://<span class="red">쇼핑몰도메인입력</span>/payment/allat_return</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="its-td">핸드폰</td>
			<td class="its-td">
				<label class="resp_checkbox"><input type="checkbox" name="payment[]" value="cellphone" /> 사용</label>
			</td>
		</tr>
		<tr>
			<th class="its-th" rowspan="3">에스크로
			<span class="helpicon" title="에스크로(구매대금예치)는 구매자를 보호하는 제도로써 소비자가 지불한 물품대금을<br/>에스크로사업자(은행 등 공신력있는 제3자)가 맡아 가지고 있다가 배송이 정상적으로<br/>완료되면 판매자 계좌로 입금하는 결제대금 예치제도입니다"></span></th>
			<td class="its-td">계좌이체</td>
			<td class="its-td">
				<div><label class="resp_checkbox"><input type="checkbox" name="escrow[]" value="account" /> 사용</label></div>
				<div>구매자가 <input type="text" name="escrowAccountLimit" class="line onlynumber" size="6" value="<?php echo $TPL_VAR["escrowAccountLimit"]?>" />원 이상의 금액을 결제할 때 계좌이체 에스크로 결제수단을 선택할 수 있습니다.</div>
			</td>
		</tr>
		<tr>
			<td class="its-td">가상계좌</td>
			<td class="its-td">
				<div><label class="resp_checkbox"><input type="checkbox" name="escrow[]" value="virtual" /> 사용</label></div>
				<div>구매자가 <input type="text" name="escrowVirtualLimit" class="line onlynumber" size="6" value="<?php echo $TPL_VAR["escrowVirtualLimit"]?>" />원 이상의 금액을 결제할 때 계좌이체 에스크로 결제수단을 선택할 수 있습니다.</div>
			</td>
		</tr>
		<tr>
			<td class="its-td">
			인증마크용<br/>치환코드
			<span class="helpicon" title="쇼핑몰 하단에 에스크로 인증마크를 노출함으로써 소비자에게<br/>쇼핑몰의 에스크로 여부를 정확하게 알릴 수 있습니다."></span>
			</td>
			<td class="its-td">
				<div>인증마크가 노출되어야 하는 영역에 치환코드를 삽입하세요! 삽입 후 인증마크를 클릭하면 인증여부를 확인할 수 있습니다</div>
				<div class="webftpFormItem clearbox" style="padding-top:5px;">
					<div class="fl">
<?php if($TPL_VAR["escrowMark"]){?>
						<img src="/data/icon/escrow_mark/<?php echo $TPL_VAR["escrowMark"]?>" class="webftpFormItemPreview" style="max-width:300px"/>
<?php }?>
					</div>
					<div class="fl pdl10">
						<div>
							&#123;=escrow_mark()&#125;<span class="btn small" id="escrow_mark_copy"><input type="button" id="escrow_mark_copy_btn" value="복사" /></span>
						</div>
						<div class="pdt10">
							<input type="text" name="newEscrowMark" value="" size="15" class="webftpFormItemInput line" readonly="readonly" />
							<input type="text" name="oriEscrowMarkFilename" class="webftpFormItemInputOriName hide" />
							<input id="escrowMarkUploadButton" type="file" value="" class="uploadify" />
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>
	</div>
	<div style="float:left;width:50%" >
	<table width="100%" class="table_basic inputPgSetting">
		<col width="10%" /><col width="10%" /><col width="30%" />
		<tr>
			<th class="its-th center bold" height="20" colspan="3">모바일</th>
		</tr>
		<tr>
			<th class="its-th" height="20">결제통화</th>
			<td class="its-td">통화설정</td>
			<td class="its-td">PC와 동일</td>
		</tr>
		<tr>
			<th class="its-th" rowspan="5">일반</th>
			<td class="its-td">세팅 정보 등록</td>
			<td class="its-td" valign="middle" height="60">
				PC 플랫폼과 동일
			</td>
		</tr>
		<tr>
			<td class="its-td">신용카드</td>
			<td class="its-td">
				<div><label class="resp_checkbox"><input type="checkbox" name="mobilePayment[]" value="card" /> 사용</label></div>

				<div style="padding-top:5px;">
					할부기간 :
					<select name="mobileInterestTerms">
						<option value="0">일시불</option>
						<option value="2">2개월</option>
						<option value="3">3개월</option>
						<option value="4">4개월</option>
						<option value="5">5개월</option>
						<option value="6">6개월</option>
						<option value="7">7개월</option>
						<option value="8">8개월</option>
						<option value="9">9개월</option>
						<option value="10">10개월</option>
						<option value="11">11개월</option>
						<option value="12">12개월</option>
					</select>
					<span class="desc">할부가 가능한 최대기간을 선택</span>
				</div>
				<div style="padding-top:5px;">
				<label class="resp_checkbox"><input type="checkbox" name="mobileNonInterestYn" value="y" /> 무이자할부 사용</label>
				</div>
			</td>
		</tr>
		<tr>
			<td class="its-td">계좌이체</td>
			<td class="its-td"><label class="resp_checkbox"><input type="checkbox" name="mobilePayment[]" value="account" /> 사용</label></td>
		</tr>
		<tr>
			<td class="its-td">가상계좌</label></td>
			<td class="its-td">			

				<div>
					<label>
						<input type="checkbox" name="mobilePayment[]" value="virtual" />
						사용
					</label>
					<button type="button" class="button_virtual_info resp_btn">입금 확인 URL 설정</button>
				</div>
				<div>
					<div class="desc">아래의 가상계좌 입금확인 URL을 반드시 세팅 하십시오.</div>
					<div class="desc">세팅하지 않으시면 자동으로 입금확인 되지 않습니다!</div>
					<div>http://<span class="red">쇼핑몰도메인입력</span>/payment/allat_return</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="its-td">핸드폰</td>
			<td class="its-td">
				<label class="resp_checkbox"><input type="checkbox" name="mobilePayment[]" value="cellphone" /> 사용</label>
			</td>
		</tr>
		<tr>
			<th class="its-th" rowspan="3">에스크로
			<span class="helpicon" title="에스크로(구매대금예치)는 구매자를 보호하는 제도로써 소비자가 지불한 물품대금을<br/>에스크로사업자(은행 등 공신력있는 제3자)가 맡아 가지고 있다가 배송이 정상적으로<br/>완료되면 판매자 계좌로 입금하는 결제대금 예치제도입니다"></span></th>
			<td class="its-td">계좌이체</td>
			<td class="its-td">
				<div><label class="resp_checkbox"><input type="checkbox" name="mobileEscrow[]" value="account" /> 사용</label></div>
				<div>구매자가 <input type="text" name="mobileEscrowAccountLimit" class="line onlynumber" size="6" value="<?php echo $TPL_VAR["mobileEscrowAccountLimit"]?>" />원 이상의 금액을 결제할 때 계좌이체 에스크로 결제수단을 선택할 수 있습니다.</div>
			</td>
		</tr>
		<tr>
			<td class="its-td">가상계좌</td>
			<td class="its-td">
				<div><label class="resp_checkbox"><input type="checkbox" name="mobileEscrow[]" value="virtual" /> 사용</label></div>
				<div>구매자가 <input type="text" name="mobileEscrowVirtualLimit" class="line onlynumber" size="6" value="<?php echo $TPL_VAR["mobileEscrowVirtualLimit"]?>" />원 이상의 금액을 결제할 때 계좌이체 에스크로 결제수단을 선택할 수 있습니다.</div>
			</td>
		</tr>
		<tr>
			<td class="its-td">
			인증마크용<br/>치환코드
			<span class="helpicon" title="쇼핑몰 하단에 에스크로 인증마크를 노출함으로써 소비자에게<br/>쇼핑몰의 에스크로 여부를 정확하게 알릴 수 있습니다."></span>
			</td>
			<td class="its-td" valign="top">
				<div>인증마크가 노출되어야 하는 영역에 치환코드를 삽입하세요! 삽입 후 인증마크를 클릭하면 인증여부를 확인할 수 있습니다</div>
				<div class="webftpFormItem clearbox" style="padding-top:5px;">
					<div class="fl">
<?php if($TPL_VAR["escrowMarkMobile"]){?>
						<img src="/data/icon/escrow_mark/<?php echo $TPL_VAR["escrowMarkMobile"]?>" class="webftpFormItemPreview" style="max-width:300px"/>
<?php }?>
					</div>
					<div class="fl pdl10">
						<div>
							&#123;=escrow_mark_mobile()&#125;<span class="btn small" id="escrow_mark_copy_mobile"><input type="button" id="escrow_mark_copy_mobile_btn" value="복사" /></span>
						</div>
						<div class="pdt10">
							<input type="text" name="newEscrowMarkMobile" value="" size="15" class="webftpFormItemInput line" readonly="readonly" />
							<input type="text" name="oriEscrowMarkMobileFilename" class="webftpFormItemInputOriName hide" />
							<input id="escrowMarkMobileUploadButton" type="file" value="" class="uploadify" />
						</div>
					</div>					
				</div>
			</td>
		</tr>
	</table>
	</div>
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