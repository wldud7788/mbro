<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/setting/kcp.html 000030864 */ 
$TPL_payment_1=empty($TPL_VAR["payment"])||!is_array($TPL_VAR["payment"])?0:count($TPL_VAR["payment"]);
$TPL_escrow_1=empty($TPL_VAR["escrow"])||!is_array($TPL_VAR["escrow"])?0:count($TPL_VAR["escrow"]);
$TPL_mobilePayment_1=empty($TPL_VAR["mobilePayment"])||!is_array($TPL_VAR["mobilePayment"])?0:count($TPL_VAR["mobilePayment"]);
$TPL_mobileEscrow_1=empty($TPL_VAR["mobileEscrow"])||!is_array($TPL_VAR["mobileEscrow"])?0:count($TPL_VAR["mobileEscrow"]);
$TPL_pcCardCompanyCode_1=empty($TPL_VAR["pcCardCompanyCode"])||!is_array($TPL_VAR["pcCardCompanyCode"])?0:count($TPL_VAR["pcCardCompanyCode"]);
$TPL_mobileCardCompanyCode_1=empty($TPL_VAR["mobileCardCompanyCode"])||!is_array($TPL_VAR["mobileCardCompanyCode"])?0:count($TPL_VAR["mobileCardCompanyCode"]);
$TPL_arrKcpCardCompany_1=empty($TPL_VAR["arrKcpCardCompany"])||!is_array($TPL_VAR["arrKcpCardCompany"])?0:count($TPL_VAR["arrKcpCardCompany"]);?>
<script type="text/javascript">
var onInterestSettingButtonIndex = 0;

/* 모바일/pc플랫폼 테이블간의 높의 조절 */
function sync_height(){
	$("div.inputPgSetting table.info-table-style").eq(1).height( $("div.inputPgSetting table.info-table-style").eq(0).height() );
}

$(document).ready(function() {
	/* 무이자 할부기간 선택팝업 */
	$("button.nonInterestSettingButton").each(function(idx){
		$(this).bind("click",function(){
			onInterestSettingButtonIndex = idx;
			openDialog("무이자할부 <span class='desc'>무이자할부 정보를 설정합니다.</span>", "nonInterestPopup", {"width":"390","height":200});
		});
	});

	/* 무이자 할부기간 삭제 */
	$("button.nonInterestSettingDelete").live("click",function(){
		$(this).parent().parent().remove();
	});

	/* 무이자 할부기간 추가 */
	$("button#nonInterestAddButton").bind("click",function(){
		var arrPlaform = new Array();
		arrPlaform[0] = "pc";
		arrPlaform[1] = "mobile";
		var codeName = arrPlaform[onInterestSettingButtonIndex] + "CardCompanyCode[]";
		var termsName =  arrPlaform[onInterestSettingButtonIndex] + "CardCompanyTerms[]";
		var opt_text = $("select[name=cardCompany] option:selected").html();
		var opt_value = $("select[name=cardCompany] option:selected").val();
		var mons = "";
		$("input[type='checkbox'][name='nonInterestTerms[]']:checked").each(function(){
			 mons += ',' + $(this).val();
		});
		if(mons == "") return false;
		$("input[name='"+codeName+"']").each(function(){
			if($(this).val() == opt_value) $(this).parent().remove();
		});
		mons = mons.substring(1);
		var tag = '<div> - ' + opt_text + ' ' + mons + " 개월";
		tag += '<input type="hidden" name="' + codeName + '" value="' + opt_value + '">';
		tag += '<input type="hidden" name="' + termsName + '" value="' + mons + '">';
		tag += ' <span class="btn small gray"><button type="button" class="nonInterestSettingDelete">삭제<span class="arrowright"></span></button></span></div>';
		$("button.nonInterestSettingButton").eq(onInterestSettingButtonIndex).parent().next().next().append(tag);
	});


	/* 세팅값 출력 */
<?php if($TPL_payment_1){foreach($TPL_VAR["payment"] as $TPL_V1){?>
	$("input[name='payment[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>
<?php if($TPL_escrow_1){foreach($TPL_VAR["escrow"] as $TPL_V1){?>
	$("input[name='escrow[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>

<?php if($TPL_VAR["interestTerms"]!=''){?>
	$("select[name='interestTerms'] option[value='<?php echo $TPL_VAR["interestTerms"]?>']").attr('selected',true);
<?php }?>
<?php if($TPL_VAR["nonInterestTerms"]!=''){?>
	$("select[name='nonInterestTerms'] option[value='<?php echo $TPL_VAR["nonInterestTerms"]?>']").attr('selected',true);
<?php }?>
	$("input[name='cashReceipts'][value='<?php echo $TPL_VAR["cashReceipts"]?>']").attr('checked',true);
<?php if($TPL_mobilePayment_1){foreach($TPL_VAR["mobilePayment"] as $TPL_V1){?>
	$("input[name='mobilePayment[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>
<?php if($TPL_mobileEscrow_1){foreach($TPL_VAR["mobileEscrow"] as $TPL_V1){?>
	$("input[name='mobileEscrow[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>
<?php if($TPL_VAR["mobileInterestTerms"]!=''){?>
	$("select[name='mobileInterestTerms'] option[value='<?php echo $TPL_VAR["mobileInterestTerms"]?>']").attr('selected',true);
<?php }?>
<?php if($TPL_VAR["mobileNonInterestTerms"]!=''){?>
	$("select[name='mobileNonInterestTerms'] option[value='<?php echo $TPL_VAR["mobileNonInterestTerms"]?>']").attr('selected',true);
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
			$(that).closest('.webftpFormItem').find('.webftpFormItemInputOriName').val( result.fileInfo.client_name);
		}else{
			alert(result.msg);
		}
	};

	// ajax 이미지 업로드 이벤트 바인딩
	$('#escrowMarkUploadButton').createAjaxFileUpload(opt, callback);
	$('#escrowMarkMobileUploadButton').createAjaxFileUpload(opt, callback);
	$('#kcpLogouploadButton').createAjaxFileUpload(opt, callback);

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
	

	$(".kcplogo-delete").click(function(){
		$.getJSON('/admin/setting_process/kcplogo_delete', function(data) {
			if	(data.result == 'ok'){
				$("input[name='kcp_logo_val_img']").val('');
				$("input[name='kcp_logo_img_filename']").val('');
				$("#orgfile").html('');
				alert('삭제되었습니다.');
			}
		});
	});

	$("#preview_kcp_skin").click(function(){
		openDialog("KCP 스킨 미리보기", "skin_preview", {"width":"910","height":"660"});
	});

	$("select[name='nonInterestTerms']").bind("change",function(){
		check_nonInterest();
	});

	check_nonInterest();

	$("select[name='mobileNonInterestTerms']").bind("change",function(){
		check_nonInterest_mobile();
	});

	check_nonInterest_mobile();

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

function check_nonInterest()
{
	$("select[name='nonInterestTerms'] option").each(function(){
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

function check_nonInterest_mobile()
{
	$("select[name='mobileNonInterestTerms'] option").each(function(){
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
<div class="clearbox inputPgSetting">
	<div style="float:left;width:50%">
	<table width="100%" class="table_basic">
		<col width="10%" /><col width="10%" /><col width="30%" />
		<tr>
			<th class="its-th center bold" colspan="3" height="20">PC</th>
		</tr>
		<tr>
			<th class="its-th" height="20">결제통화</th>
			<td class="its-td">통화설정</td>
			<td class="its-td">결제수단 공통 설정 : KRW</td>
		</tr>
		<tr>
			<th class="its-th" rowspan="6">일반</th>
			<td class="its-td">세팅 정보 등록</td>
			<td class="its-td">
<?php if($TPL_VAR["mallCode"]==""){?>
					[NON-ActiveX] Payplus Non Plug-in
					<input type="hidden" name="nonActiveXUse" value="Y"/>
<?php }else{?>
					<input type="radio" class="line" name="nonActiveXUse" id="nonActiveXNot" size="40" value="N" title="웹표준 결제 사용안함" <?php if($TPL_VAR["nonActiveXUse"]==""||$TPL_VAR["nonActiveXUse"]=="N"){?> checked = "cehcked" <?php }?>/> <label for="nonActiveXNot">Payplus Plug-in</label><br/>			
					<input type="radio" class="line" name="nonActiveXUse" id="nonActiveXUse" size="40" value="Y" title="웹표준 결제 사용" <?php if($TPL_VAR["nonActiveXUse"]=="Y"){?> checked = "cehcked" <?php }?>/> <label for="nonActiveXUse">[NON-ActiveX] Payplus Non Plug-in</label>
<?php }?>				
			</td>
		</tr>		
		<tr>
			<td class="its-td">세팅 정보 등록</td>
			<td class="its-td">
				<div><input type="text" name="mallCode" class="line" value="<?php echo $TPL_VAR["mallCode"]?>" title="사이트 코드"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>/></div>
				<div style="padding-top:5px;"><input type="text" class="line" name="merchantKey" size="40" value="<?php echo $TPL_VAR["merchantKey"]?>" title="사이트 키"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?> /></div>
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
					무이자 할부기간 :
					<select name="nonInterestTerms">
						<option value="automatic">자동</option>
						<option value="manual">수동</option>
					</select>
					<span class="btn small black">
					<button type="button" class="nonInterestSettingButton">설정하기<span class="arrowright"></span></button>
					</span>
					<div class="desc">
					<span class='red'>무이자할부 수수료를 PG사에서 부담 (권장)</span>
					<span class='red'>무이자할부 수수료를 쇼핑몰에서 부담(PG사와 협의)</span>
					</div>
					<div>
<?php if($TPL_pcCardCompanyCode_1){$TPL_I1=-1;foreach($TPL_VAR["pcCardCompanyCode"] as $TPL_V1){$TPL_I1++;?>
					<div>
					- <?php echo $TPL_VAR["arrCardCompany"][$TPL_V1]?> <?php echo $TPL_VAR["pcCardCompanyTerms"][$TPL_I1]?> 개월
					<input type="hidden" name="pcCardCompanyCode[]" value="<?php echo $TPL_V1?>">
					<input type="hidden" name="pcCardCompanyTerms[]" value="<?php echo $TPL_VAR["pcCardCompanyTerms"][$TPL_I1]?>">
					<span class="btn small gray"><button type="button" class="nonInterestSettingDelete">삭제<span class="arrowright"></span></button></span>
					</div>
<?php }}?>
					</div>
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
					<label class="resp_checkbox">
						<input type="checkbox" name="payment[]" value="virtual" />
						사용
					</label>
					<button type="button" class="button_virtual_info resp_btn">입금 확인 URL 설정</button>
				</div>
				<div>
					<div class="desc">아래의 가상계좌 입금확인 URL을 반드시 세팅 하십시오.</div>
					<div class="desc">세팅하지 않으시면 자동으로 입금확인 되지 않습니다!</div>
					<div>http://<span class="red">쇼핑몰도메인입력</span>/payment/kcp_return</div>
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
	<div style="float:left;width:50%">
	<table width="100%" class="table_basic inputPgSetting">
		<col width="10%" /><col width="10%" /><col width="30%" />
		<tr>
			<th class="its-th center bold" colspan="3" height="20">모바일</th>
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
					무이자 할부기간 :
					<select name="mobileNonInterestTerms">
						<option value="automatic">자동</option>
						<option value="manual">수동</option>
					</select>
					<span class="btn small black">
					<button type="button" class="nonInterestSettingButton">설정하기<span class="arrowright"></span></button>
					</span>
					<div class="desc">
					<span class='red'>무이자할부 수수료를 PG사에서 부담 (권장)</span>
					<span class='red'>무이자할부 수수료를 쇼핑몰에서 부담(PG사와 협의)</span>
					</div>
					<div>
<?php if($TPL_mobileCardCompanyCode_1){$TPL_I1=-1;foreach($TPL_VAR["mobileCardCompanyCode"] as $TPL_V1){$TPL_I1++;?>
					<div>
					<?php echo $TPL_VAR["arrCardCompany"][$TPL_V1]?> <?php echo $TPL_VAR["mobileCardCompanyTerms"][$TPL_I1]?> 개월
					<input type="hidden" name="mobileCardCompanyCode[]" value="<?php echo $TPL_V1?>">
					<input type="hidden" name="mobileCardCompanyTerms[]" value="<?php echo $TPL_VAR["mobileCardCompanyTerms"][$TPL_I1]?>">
					<span class="btn small gray"><button type="button" class="nonInterestSettingDelete">삭제<span class="arrowright"></span></button></span>
					</div>
<?php }}?>
					</div>
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
					<label class="resp_checkbox">
						<input type="checkbox" name="mobilePayment[]" value="virtual" />
						사용
					</label>
					<button type="button" class="button_virtual_info resp_btn">입금 확인 URL 설정</button>
				</div>
				<div>
					<div class="desc">아래의 가상계좌 입금확인 URL을 반드시 세팅 하십시오.</div>
					<div class="desc">세팅하지 않으시면 자동으로 입금확인 되지 않습니다!</div>
					<div>http://<span class="red">쇼핑몰도메인입력</span>/payment/kcp_return</div>
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
<div class="clearbox inputPgSetting" style="margin-top:10px;">
<table width="100%" class="table_basic thl inputPgSetting">
	<col width="15%" />
	<tr>
		<th>결제창에 쇼핑몰 표기</th>
		<td>
			<div class="webftpFormItem clearbox">
				<div class="fl" style="padding-top:4px;">
					<label class="resp_radio"><input type="radio" name="kcp_logo_type"<?php if($TPL_VAR["kcp_logo_type"]=='img'){?>checked<?php }?> value="img" /> 로고(최대 150 X 50 미만)</label>
				</div>
				<div class="fl pdl10" style="line-height:27px;">
					<input type="text" name="kcp_logo_val_img" value="<?php echo $TPL_VAR["kcp_logo_val_img"]?>" size="15" class="webftpFormItemInput line" readonly="readonly" />
					<input type="text" name="kcp_logo_img_filename" class="webftpFormItemInputOriName hide" value="<?php echo $TPL_VAR["kcp_logo_img_filename"]?>" />
					<input id="kcpLogouploadButton" type="file" value="" class="uploadify" />
				</div>
				<div class="fl pdl10" style="padding-top:4px;">
<?php if($TPL_VAR["kcp_logo_val_img"]){?>
						<div id="orgfile">
							<span id="orgfilename" style="cursor:default;" onmouseover="$('#preview_kcp_paylogo').show();" onmouseout="$('#preview_kcp_paylogo').hide();"><?php echo $TPL_VAR["kcp_logo_img_filename"]?></span> <u class="kcplogo-delete" style="cursor:pointer;">삭제</u>
						</div>
						<div id="preview_kcp_paylogo" class="hide" style="position:absolute;border:1px solid #e4e4e4;"><img src="<?php echo $TPL_VAR["kcp_logo_val_img_url"]?>" /></div>
<?php }?>
				</div>
				<div class="fl" style="padding:5px 0 0 30px;">
					<label class="resp_radio"><input type="radio" name="kcp_logo_type" value="text" <?php if($TPL_VAR["kcp_logo_type"]=='text'||!$TPL_VAR["kcp_logo_type"]){?>checked<?php }?> /> 쇼핑몰명</label>
				</div>
				<div class="fl" style="padding:1px 0 0 5px;">
					<input type="text" name="kcp_logo_val_text" value="<?php if($TPL_VAR["kcp_logo_val_text"]){?><?php echo $TPL_VAR["kcp_logo_val_text"]?><?php }else{?><?php echo $TPL_VAR["shopName"]?><?php }?>" />
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<th>
			결제창 스킨
			<span id="preview_kcp_skin"><input type="button" value="미리보기" class="resp_btn v3 size_S" /></span>
		</th>
		<td>
			<div class="resp_radio">
				<label><input type="radio" name="kcp_skin_color" <?php if(!$TPL_VAR["kcp_skin_color"]||$TPL_VAR["kcp_skin_color"]== 1){?>checked<?php }?> value="1" /> <span style="background-color:#076080;color:#fff;">&nbsp;&nbsp;1&nbsp;&nbsp;</span></label>				
				<label><input type="radio" name="kcp_skin_color" <?php if($TPL_VAR["kcp_skin_color"]== 2){?>checked<?php }?> value="2" /> <span style="background-color:#7f358c;color:#fff;">&nbsp;&nbsp;2&nbsp;&nbsp;</span></label>				
				<label><input type="radio" name="kcp_skin_color" <?php if($TPL_VAR["kcp_skin_color"]== 3){?>checked<?php }?> value="3" /> <span style="background-color:#7b5a31;color:#fff;">&nbsp;&nbsp;3&nbsp;&nbsp;</span></label>				
				<label><input type="radio" name="kcp_skin_color" <?php if($TPL_VAR["kcp_skin_color"]== 4){?>checked<?php }?> value="4" /> <span style="background-color:#9f1f52;color:#fff;">&nbsp;&nbsp;4&nbsp;&nbsp;</span></label>				
				<label><input type="radio" name="kcp_skin_color" <?php if($TPL_VAR["kcp_skin_color"]== 5){?>checked<?php }?> value="5" /> <span style="background-color:#2d4875;color:#fff;">&nbsp;&nbsp;5&nbsp;&nbsp;</span></label>				
				<label><input type="radio" name="kcp_skin_color" <?php if($TPL_VAR["kcp_skin_color"]== 6){?>checked<?php }?> value="6" /> <span style="background-color:#066394;color:#fff;">&nbsp;&nbsp;6&nbsp;&nbsp;</span></label>				
				<label><input type="radio" name="kcp_skin_color" <?php if($TPL_VAR["kcp_skin_color"]== 7){?>checked<?php }?> value="7" /> <span style="background-color:#8f6d02;color:#fff;">&nbsp;&nbsp;7&nbsp;&nbsp;</span></label>				
				<label><input type="radio" name="kcp_skin_color" <?php if($TPL_VAR["kcp_skin_color"]== 8){?>checked<?php }?> value="8" /> <span style="background-color:#d15019;color:#fff;">&nbsp;&nbsp;8&nbsp;&nbsp;</span></label>				
				<label><input type="radio" name="kcp_skin_color" <?php if($TPL_VAR["kcp_skin_color"]== 9){?>checked<?php }?> value="9" /> <span style="background-color:#7fb150;color:#fff;">&nbsp;&nbsp;9&nbsp;&nbsp;</span></label>				
				<label><input type="radio" name="kcp_skin_color" <?php if($TPL_VAR["kcp_skin_color"]== 10){?>checked<?php }?> value="10" /> <span style="background-color:#b2352f;color:#fff;">&nbsp;&nbsp;10&nbsp;&nbsp;</span></label>				
				<label><input type="radio" name="kcp_skin_color" <?php if($TPL_VAR["kcp_skin_color"]== 11){?>checked<?php }?> value="11" /> <span style="background-color:#4f535c;color:#fff;">&nbsp;&nbsp;11&nbsp;&nbsp;</span></label>
			</div>
		</td>
	</tr>
</table>
</div>
</form>
<div id="skin_preview" class="hide">
	<img src="/admin/skin/default/images/design/img_kcp_skin_preview.jpg" />	
	<div class="footer">
		<button type="button" onclick="closeDialogEvent(this)" class="resp_btn v3 size_XL">닫기</button>
	</div>
</div>
<div id="nonInterestPopup" style="display: none">
	<input type="hidden" name="nonInterestSettingButtonIndex" value="0" />
	<div>
	<select name="cardCompany">
<?php if($TPL_arrKcpCardCompany_1){foreach($TPL_VAR["arrKcpCardCompany"] as $TPL_V1){?>
		<option value="<?php echo $TPL_V1["codecd"]?>"><?php echo $TPL_V1["value"]?></option>
<?php }}?>
	</select>
	</div>
	<div>
	<label class="resp_checkbox"><input type="checkbox" name="nonInterestTerms[]" value="2" /> 2개월</label>
	<label class="resp_checkbox"><input type="checkbox" name="nonInterestTerms[]" value="3" /> 3개월</label>
	<label class="resp_checkbox"><input type="checkbox" name="nonInterestTerms[]" value="4" /> 4개월</label>
	<label class="resp_checkbox"><input type="checkbox" name="nonInterestTerms[]" value="5" /> 5개월</label>
	<label class="resp_checkbox"><input type="checkbox" name="nonInterestTerms[]" value="6" /> 6개월</label>
	<label class="resp_checkbox"><input type="checkbox" name="nonInterestTerms[]" value="7" /> 7개월</label>
	<label class="resp_checkbox"><input type="checkbox" name="nonInterestTerms[]" value="8" /> 8개월</label>
	<label class="resp_checkbox"><input type="checkbox" name="nonInterestTerms[]" value="9" /> 9개월</label>
	<label class="resp_checkbox"><input type="checkbox" name="nonInterestTerms[]" value="10" /> 10개월</label>
	<label class="resp_checkbox"><input type="checkbox" name="nonInterestTerms[]" value="11" /> 11개월</label>
	<label class="resp_checkbox"><input type="checkbox" name="nonInterestTerms[]" value="12" /> 12개월</label>
	</div>
	<div style="padding:10px 0 0 0" align="center"><span class="btn medium"><button type="button" id="nonInterestAddButton">추가</button></span></div>
</div>
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