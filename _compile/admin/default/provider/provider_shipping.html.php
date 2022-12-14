<?php /* Template_ 2.2.6 2022/05/17 12:36:51 /www/music_brother_firstmall_kr/admin/skin/default/provider/provider_shipping.html 000055606 */ ?>
<script type="text/javascript">
$(document).ready(function() {

	// 우체국택배 업무자동화 서비스 :: 2016-03-29 lwh
	$("#epostSetting").bind('click', function(){
		var epost_step = "<?php echo $TPL_VAR["config_epost"]["status"]?>";
		if(epost_step == '0' || epost_step == '1' || epost_step == '9'){
			DLstat_controller('ep_','ing',true);
			$(".chk_duple").closest('td').find('.btn').hide();
			$(".personInfo").hide();
		}else{
			DLstat_controller('ep_','open',true);
		}

		openDialog("택배 업무 자동화 연동 - 우체국택배", "epostSettingPopup", {"width":800});

		setDefaultText();
	});

	// 우체국택배 중복체크 :: 2016-03-29 lwh
	$(".chk_duple").bind('click', function(){
		var that	= $(this);
		var chk_type= $(that).attr('chk_type');
		var obj		= $("input[name='"+chk_type+"']");
		var chk_val	= '';

		// 체크문자 조합
		if(chk_type == 'epost_num')
			chk_val = obj.val();
		else
			chk_val = (obj.eq(0).val() && obj.eq(1).val()) ? obj.eq(0).val() + '-' + obj.eq(1).val() : '';

		if(!chk_val || chk_val == ''){
			alert('중복 체크할 값을 먼저 입력해주세요.');
			obj.eq(0).focus();
			return false;
		}

		// 체크문자 검사
		var pattern = /^[0-9]*$/; //패턴검사 정규식
		if(obj.eq(0).val() && !pattern.test(obj.eq(0).val())){
			alert('숫자만 입력 가능합니다.');
			obj.eq(0).focus();
			return false;
		}
		if(obj.eq(1).val() && !pattern.test(obj.eq(1).val())){
			alert('숫자만 입력 가능합니다.');
			obj.eq(1).focus();
			return false;
		}

		// 중복체크 실행
		$.ajax({
			'url' : '../setting_process/epost_duple_chk',
			'type' : 'post',
			'data' : {'chk_type':chk_type, 'chk_val':chk_val},
			'dataType' : 'json',
			'success' : function(respons){
				if(respons.result){
					openDialogAlert('사용가능합니다.',400,155);
					$(that).closest('td').find('.btn').hide();
					$(that).closest('td').find('.duple_txt').show();
					$(that).closest('td').find('.duple_chk_use').val('Y');
				}else{
					openDialogAlert(respons.msg,400,180);
				}
			}
		});
	});

	// 우체국 택배 중복확인 무결성 체크 :: 2016-03-30 lwh
	$(".duple_input").bind('keyup', function(){
		$(this).closest('td').find('.btn').show();
		$(this).closest('td').find('.duple_txt').hide();
		$(this).closest('td').find('.duple_chk_use').val('');
	});

	// 우체국 택배 사용여부 저장 :: 2016-03-31 lwh
	$("#set_epostuse").bind('click', function(){
		var requestkey		= $("input[name='requestkey']").val();
		var epost_notuse	= ($("#epost_notuse").is(":checked")) ? 'N' : 'Y';
		$.ajax({
			'url' : '../setting_process/epost_use_save',
			'type' : 'post',
			'data' : {'requestkey':requestkey, 'epost_notuse':epost_notuse},
			'dataType' : 'json',
			'success' : function(respons){
				if(respons){
					openDialogAlert(respons.msg,400,150);
				}
			}
		});
	});

	// 우체국 택배 신청취소 :: 2016-03-31 lwh
	$("#epost_cancel").bind('click', function(){
		$.ajax({
			'url' : '../setting_process/epost_cancel',
			'type' : 'post',
			'data' : {'requestkey' : "<?php echo $TPL_VAR["config_epost"]["requestkey"]?>", 'status' : "<?php echo $TPL_VAR["config_epost"]["status"]?>"},
			'dataType' : 'json',
			'success' : function(respons){
				if(respons.result){
					openDialogAlert(respons.msg,400,140,function(){location.reload();});
				}else{
					openDialogAlert(respons.msg,400,160);
				}
			}
		});
	});

	// 롯데택배 업무자동화 서비스
	$("#invoiceSetting").bind('click', function(){
		openDialog("택배 업무 자동화 연동 - 롯데택배", "invoiceSettingPopup", {"width":800});

		setDefaultText();
	});

	// 굿스플로 업무자동화 서비스 :: 2015-06-11 lwh
	$("#goodsflowSetting").bind('click', function(){
		// 연동 신청중일 경우 데이터 수정 변경 금지 :: 2015-06-22 lwh
		var goodsflow_step = "<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']?>";
		if(goodsflow_step == '1'){
			DLstat_controller('gf_','complete',true);
		}else if(goodsflow_step == '2'){
			DLstat_controller('gf_','ing',true);
		}else{
			DLstat_controller('gf_','open',true);
		}

		openDialog("택배 업무 자동화 연동 - 굿스플로", "goodsflowSettingPopup", {"width":900});

		setDefaultText();
	});

	// 굿스플로 신청취소 :: 2015-06-22 lwh
	$("#goodsflow_cancel").bind('click', function(){
		$.ajax({
			'url' : '../setting_process/goodsflow_cancel',
			'type' : 'post',
			'data' : {'requestKey' : "<?php echo $TPL_VAR["config_goodsflow"]["setting"]['requestKey']?>", 'provider_seq' : "<?php echo $TPL_VAR["config_goodsflow"]["setting"]["provider_seq"]?>"},
			'dataType' : 'json',
			'success' : function(respons){
				if(respons.result){
					openDialogAlert('서비스 신청이 취소되었습니다.',400,140,function(){location.reload();});
				}else{
					openDialogAlert(respons.msg,400,140);
				}
			}
		});
	});

	// 굿스플로 택배사 선택 :: 2015-06-15 lwh
	$("#deliveryCode").bind('change', function(){
		var delivery		= $(this).val();
		$("#deliveryName").val($("#deliveryCode option:selected").text());
		$("select[name='boxSize[]']").children("[value='02']").remove();
		if(delivery == 'EPOST' || delivery == 'CJGLS'){
			$("select[name='boxSize[]']").prepend("<option value='02'>2Kg, 60Cm 미만</option>");
			$("select[name='boxSize[]']").val("02");
		}else{
			$("select[name='boxSize[]']").val("05");
		}
	});

	// 굿스플로 정보수정 시 수정 불가 목록 해제 :: 2015-06-25
	$("form[name=goodsflowSettingForm]").submit(function(){
		DLstat_controller('gf_','ing',false);
		var goodsflow_use = $("input[name=goodsflow_notuse]:checked").length;
		var submit_flag = true;
		if(!goodsflow_use){
			var boxArr = $("select[name='boxSize[]']");
			$.each(boxArr, function(key, val){
				shFare_obj	= $("input[name='shFare[]']").eq(key);
				scFare_obj	= $("input[name='scFare[]']").eq(key);
				bhFare_obj	= $("input[name='bhFare[]']").eq(key);
				rtFare_obj	= $("input[name='rtFare[]']").eq(key);

				if(!shFare_obj.val() || !scFare_obj.val() || !bhFare_obj.val() || !rtFare_obj.val()){
					openDialogAlert('박스타입의 모든값은 필수입니다.',400,140);
					submit_flag = false;
				}
			});
		}

		return submit_flag;
	});

	// 굿스플로 사용현황 :: 2015-06-25 lwh
	$("#gf_log").bind('click', function(){
		openDialog("굿스플로 사용현황 <span class='desc'>&nbsp;</span>", "goodsflow_log_area", {"width":"800","height":"820"});
	});

	// 자동화서비스 안내 차이점 :: 2015-06-12 lwh
	$("#infoDesc").bind('click', function(){
		openDialog("자동화 서비스 차이점 안내", "desc_popup_area", {"width":700});
	});

	// 요금정보 추가 :: 2015-06-12 lwh
	$(".add_price").bind('click', function(){
		var clone = $(this).closest('tr').clone();
		clone.find('th').html('<span class="btn small gray"><input type="button" class="del_price" value="-" /></span>');
		$("#goodsflow_form").append('<tr>'+clone.html()+'</tr>');
	});

	// 요금정보 삭제 :: 2015-06-12 lwh
	$(".del_price").live('click', function(){
		$(this).closest('tr').remove();
	});

	// 입점사 이용 설정 :: 2015-07-17 lwh
	$("#set_gf_use").bind('click', function(){
		var gf_use = 'N';
		var provider_seq = '<?php echo $_GET["provider_seq"]?>';
		if($("input[name='gf_use']:checked").val() == 'Y'){
			gf_use = $("input[name='gf_use']:checked").val();
		}		
		$.ajax({
			'url' : '../setting_process/goodsflow_provider_set',
			'type' : 'post',
			'data' : {'gf_use' : gf_use, 'provider_seq' : provider_seq},
			'dataType' : 'json',
			'success' : function(respons){
				if(respons.res == 'Y'){
					openDialogAlert('수정되었습니다.',400,140,function(){location.reload();});
				}else{
					openDialogAlert('수정에 실패하였습니다.',400,140,function(){location.reload();});
				}
			}
		});
	});

	$("input[name='invoice_notuse']").change(function(){
		if($(this).is(":checked")){
			$("#invoiceSettingAuthContainer *").attr("disabled",true);
			$("#invoiceSettingAuthContainer span.btn").addClass("gray");
			$("#invoiceSettingAuthContainer input.invoice_auth_code").val('');
		}else{
			$("#invoiceSettingAuthContainer *").removeAttr("disabled");
			$("#invoiceSettingAuthContainer span.btn").removeClass("gray");
		}
	}).change();


	$("form[name='invoiceSettingForm']").submit(function(){

		var returnValue = true;

		if(!$("input[name='invoice_notuse']").is(":checked")){
			$("input.invoice_auth_code").each(function(){
				var that = this;
				if($(this).val()!='' && $(this).val()!=$(this).attr("auth_code")) {
					openDialogAlert("인증버튼을 클릭하여 인증을 완료해 주시기바랍니다.",400,140,function(){
						$(that).focus();
					});
					returnValue = false;
				}
			});
		}

		return returnValue;
	});

	$("input.invoice_auth_code").bind('keyup change',function(){
		if($(this).val()!='' && $(this).val()==$(this).attr("auth_code")) {
			$(this).closest('div').children(".invoice_auth_code_desc").html("<span class='fx11 blue'>인증완료</span>");
		}else{
			$(this).closest('div').children(".invoice_auth_code_desc").html("");
		}
	}).change();

	// 굿스플로 우편번호 검색 :: 2015-07-07 lwh
	$("#goodsflowZipcodeButton").live("click",function(){
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']!='2'){?>
        openDialogZipcode('goodsflow');
<?php }?>
    });

	// 굿스플로 택배사 명 default 처리 :: 2015-07-09 lwh
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']!='1'){?>
	$("#deliveryName").val($("#deliveryCode option:selected").text());
<?php }?>

	//관리자 택배배송비 권한에 따른 설정 버튼 노출 @nsg 2016-02-29
	var setting_shipping_act = <?php echo $TPL_VAR["setting_shipping_act"]?>;
	if(setting_shipping_act){
		$(".modifyDeliveryButton").parent().css('display','none')
	}

});

// 우체국, 굿스플로 연동설정창 컨트롤 :: 2015-06-22 -> 2016-03-28 lwh
function DLstat_controller(mode,step,flag){
	var className = mode+step;
	$("."+className).attr("disabled", flag);
}

function hlc_auth(){
	var auth_code = $("input[name='auth_code[hlc]']").val();
	$.ajax({
		'url' : '../setting_process/hlc_auth',
		'type' : 'post',
		'data' : {'auth_code' : auth_code},
		'dataType' : 'text',
		'success' : function(result){
			alert(result);
			return;
			if(result.code=='success'){
				$("input[name='auth_code[hlc]']").attr('auth_code',auth_code).change();
				openDialogAlert(result.msg,400,140);
			}else{
				openDialogAlert(result.msg,400,140,function(){
					$("input[name='auth_code[hlc]']").focus();
				});
			}
		}
	});
}
</script>
<style type="text/css">.ep_box { border:0px !important; }</style>
<input type="hidden" name="shipping_provider_seq" value="<?php echo $_GET["provider_seq"]?>"/>	
<div class="clearbox" style="padding:3px;">
	<table width="100%" class="info-table-style">
		
		<thead>
		
		<tr>
		<th class="its-th-align center" rowspan="2">실물 배송 정책</th>
		<th class="its-th-align center" rowspan="2">배송 방법</th>
		<th class="its-th-align center" rowspan="2">사용 여부</th>
		<th class="its-th-align center" colspan="4">배송비 계산</th>
		</tr>
		<tr>
		<th class="its-th-align center">택배사</th>
		<th class="its-th-align center">지정 상품 기준</th>
		<th class="its-th-align center">실 결제금액 기준</th>				
		<th class="its-th-align center">추가 배송비(<?php if($TPL_VAR["addDeliveryType"]=="street"){?>도로명 주소 기준<?php }else{?>지번 주소 기준<?php }?>) 
<?php if($_GET["provider_seq"]> 1){?>
		<span class="btn small gray"><button type="button" class="modifyDeliveryButton" title="국내 – 택배 추가배송비" name="add_delivery">세팅</button></span>
<?php }?>
		</th>
		</tr>
		
	
		</thead>
		<tbody>				
						
		<tr>				
			<td class="its-td" rowspan="4">기본 배송 상품</td>
			<td class="its-td">
				택배 (선불)							
			</td>
			<td class="its-td-align center">
<?php if($TPL_VAR["data_providershipping"]["use_yn"]=='y'){?>
			<span style="color:blue">사용</span>
<?php }else{?>					
			<span style="color:red">미사용</span>
<?php }?>
			
<?php if($_GET["provider_seq"]> 1){?>
			<span class="btn small gray"><button type="button" class="modifyDeliveryButton" title="국내 – 택배 선불" name="delivery">세팅</button></span>					
<?php }?>
			
			</td>					
			<td class="its-td-align left" style="padding-left:5px;">
<?php if($TPL_VAR["config_system"]["invoice_use"]=='1'&&$_GET["provider_seq"]== 1){?>
				<div> ● 롯데택배(업무자동화)</div>
<?php }?>	
<?php if(is_array($TPL_R1=$TPL_VAR["data_providershipping"]["deliveryCompany"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<div> ● <?php echo $TPL_V1?></div>
<?php }}?>
			</td>
			<td class="its-td-align center">	
<?php if($TPL_VAR["data_providershipping"]["order_delivery_free"]=='free'){?>						
					<div>지정된 상품 구매 시 무료</div>
<?php if($TPL_VAR["data_providershipping"]["data_issue_goods"]||$TPL_VAR["data_providershipping"]["data_issue_category"]||$TPL_VAR["data_providershipping"]["data_issue_brand"]){?>
					<div>지정 상품 있음</div>
<?php }?>
<?php }?>
			</td>
			<td class="its-td-align center">
				<div>
<?php if($TPL_VAR["data_providershipping"]["delivery_cost_policy"]=='free'){?>
					무료
<?php }?>
<?php if($TPL_VAR["data_providershipping"]["delivery_cost_policy"]=='pay'){?>
					<?php echo number_format($TPL_VAR["data_providershipping"]["pay_delivery_cost"])?>원
<?php }?>
					
<?php if($TPL_VAR["data_providershipping"]["delivery_cost_policy"]=='ifpay'){?>
					<?php echo number_format($TPL_VAR["data_providershipping"]["ifpay_free_price"])?>원 이상 구매 시 무료, 미만  <?php echo number_format($TPL_VAR["data_providershipping"]["ifpay_delivery_cost"])?>원
<?php }?>
				</div>
			</td>				
			
			<td class="its-td-align left" style="padding-left:5px;">
<?php if($TPL_VAR["addDeliveryType"]=="street"){?>
<?php if($TPL_VAR["data_providershipping"]["use_yn"]=='y'&&$TPL_VAR["data_providershipping"]["sigungu_street"][ 0]){?>
<?php if(is_array($TPL_R1=$TPL_VAR["data_providershipping"]["sigungu_street"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
							<div> ● <?php echo $TPL_V1?> <?php echo number_format($TPL_VAR["data_providershipping"]["addDeliveryCost"][$TPL_K1])?>원 추가</div>
<?php }}?>
<?php }?>						
<?php }else{?>
<?php if($TPL_VAR["data_providershipping"]["use_yn"]=='y'&&$TPL_VAR["data_providershipping"]["sigungu"][ 0]){?>
<?php if(is_array($TPL_R1=$TPL_VAR["data_providershipping"]["sigungu"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
							<div> ● <?php echo $TPL_V1?> <?php echo number_format($TPL_VAR["data_providershipping"]["addDeliveryCost"][$TPL_K1])?>원 추가</div>
<?php }}?>
<?php }?>
<?php }?>
			</td>
		</tr>
		
		<tr>				
			
			<td class="its-td">
				택배 (착불)							
			</td>
			<td class="its-td-align center">
<?php if($TPL_VAR["data_providershipping"]["postpaid_delivery_cost_yn"]=='y'){?>
			<span style="color:blue">사용</span>
<?php }else{?>					
			<span style="color:red">미사용</span>
<?php }?>
			
<?php if($_GET["provider_seq"]> 1){?>
			<span class="btn small gray"><button type="button" class="modifyDeliveryButton" title="국내 – 택배 착불" name="postpaid">세팅</button></span>
<?php }?>					
			</td>					
			<td class="its-td-align center" style="padding-left:5px;">	
				↑상동						
			</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">
				<div>						
<?php if($TPL_VAR["data_providershipping"]["postpaid_delivery_cost_yn"]=='y'){?><?php echo number_format($TPL_VAR["data_providershipping"]["postpaid_delivery_cost"])?>원<?php }?>
				</div>
			</td>				
			
			<td class="its-td-align center">-</td>
		</tr>
		<tr>				
			
			<td class="its-td">
				퀵서비스 (착불)						
			</td>
			<td class="its-td-align center">
<?php if($TPL_VAR["data_providershipping"]["quick_use_yn"]=='y'){?>
			<span style="color:blue">사용</span>
<?php }else{?>					
			<span style="color:red">미사용</span>
<?php }?>
			
<?php if($_GET["provider_seq"]> 1){?>
			<span class="btn small gray"><button type="button" class="modifyDeliveryButton" title="국내 – 퀵서비스" name="quick">세팅</button></span>
<?php }?>				
			</td>					
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
		</tr>				
		<tr>
			<td class="its-td">
				직접수령						
			</td>
			<td class="its-td-align center">
<?php if($TPL_VAR["data_providershipping"]["direct_use_yn"]=='y'){?>
			<span style="color:blue">사용</span>
<?php }else{?>					
			<span style="color:red">미사용</span>
<?php }?>
			
<?php if($_GET["provider_seq"]> 1){?>
			<span class="btn small gray"><button type="button" class="modifyDeliveryButton" title="국내 – 직접수령" name="direct">세팅</button></span>
<?php }?>				
			</td>					
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
		</tr>
		
		<tr>				
			<td class="its-td" rowspan="4">개별배송 정책</td>
			<td class="its-td">
				택배 (선불)						
			</td>
			<td class="its-td-align center">
			상품별로 세팅<br/>
			<a href="/admin/goods/catalog" target="_blank"><span class="highlight-link">바로가기></span></a>			
			</td>					
			<td class="its-td-align center">=기본배송 정책</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">=기본배송 정책</td>
		</tr>
		
		<tr>
			<td class="its-td">
				택배 (착불)					
			</td>
			<td class="its-td-align center">
			상품별로 세팅<br/>
			<a href="/admin/goods/catalog" target="_blank"><span class="highlight-link">바로가기></span></a>			
			</td>					
			<td class="its-td-align center">=기본배송 정책</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
		</tr>
		<tr>
			<td class="its-td">
				퀵서비스(착불)						
			</td>
			<td class="its-td-align center">
<?php if($TPL_VAR["data_providershipping"]["quick_use_yn"]=='y'){?>
			<span style="color:blue">사용</span>
<?php }else{?>					
			<span style="color:red">미사용</span>
<?php }?>
			<span class="desc">(=기본 배송)</span>				
			</td>					
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
		</tr>
		<tr>
			<td class="its-td">
				직접수령						
			</td>
			<td class="its-td-align center">
<?php if($TPL_VAR["data_providershipping"]["direct_use_yn"]=='y'){?>
			<span style="color:blue">사용</span>
<?php }else{?>					
			<span style="color:red">미사용</span>
<?php }?>
			<span class="desc">(=기본 배송)</span>				
			</td>					
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
		</tr>
		
		
		</tbody>
	</table>		
</div>

<!-- 택배자동화 서비스 :: START -->
<div class="item-title"  style="width:92%">국내 – 택배 업무 자동화 서비스 <span class="desc" style="font-weight:normal">주문된 상품을 택배로 보낼 때 반드시 해야 하는 택배 업무를 자동화합니다.</span></div>
	<table width="100%" class="info-table-style" style="table-layout:fixed">
	<colgroup>
			<col width="40%" />
			<col width="15%" />
			<col width="20%" />
			<col width="20%" />
		</colgroup>
	<thead>
		<tr>
			<th class="its-th-align center">자동화 서비스 <span class="btn small orange" style="padding-left:10px;"><button type="button" id="infoDesc">안내)차이점</button></span></th>
			<th class="its-th-align center">연동 설정</th>
			<th class="its-th-align center">상태</th>
			<th class="its-th-align center">잔여 건수</th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<td class="its-td">
			우체국 택배<br/>
			(이용 가능 택배사 : 우체국)
		</td>
		<td class="its-td center">
			<span class="btn small red"><button type="button" id="epostSetting">연동정보</button></span>
		</td>
		<td class="its-td">
			[우체국]<br/>
<?php if($TPL_VAR["config_epost"]["status_msg"]){?>
				<?php echo $TPL_VAR["config_epost"]["status_msg"]?>

<?php }else{?>
			이용 중지 - 연동 정보 미입력
<?php }?>
		</td>
		<td class="its-td">무료</td>
	</tr>
	<tr>
		<td class="its-td">
			롯데 택배&nbsp;<span class="btn small orange" style="padding-left:18px;" onclick="window.open('https://firstmall.kr/ec_hosting/addservice/invoice.php')"><button type="button">서비스 이용 안내</button></span><br/>
			(이용 가능 택배사 : 롯데택배)
		</td>
		<td class="its-td center">
			<span class="btn small red"><button type="button" id="invoiceSetting">연동정보</button></span>
		</td>
		<td class="its-td">
			[롯데 택배]<br/>
<?php if($TPL_VAR["config_invoice"]["hlc"]["use"]=='1'){?>
				이용중
<?php }else{?>
				이용 중지 - 관리자에 의해 중지
<?php }?>
		</td>
		<td class="its-td">무료</td>
	</tr>
	<tr>
		<td class="its-td">
			굿스플로&nbsp;<span class="btn small orange" style="padding-left:22px;" onclick="window.open('https://firstmall.kr/ec_hosting/addservice/goodsflow.php')"><button type="button">서비스 이용 안내</button></span><br/>
			(이용 가능 택배사 : CJ/옐로우캡/로젠/KG로지스/우체국/한진)
		</td>
		<td class="its-td center">
			<span class="btn small red"><button type="button" id="goodsflowSetting">연동정보</button></span>
			<div style="padding-top:5px;">
<?php if($TPL_VAR["config_system"]["goodsflow_use"]== 1){?>
				<label><input type="checkbox" name="gf_use" value="Y" <?php if($TPL_VAR["config_goodsflow"]["setting"]["gf_use"]=='Y'){?>checked<?php }?>/> 가능</label>
				&nbsp;
				<span class="btn small cyanblue"><button type="button" id="set_gf_use">저장</button></span>
<?php }else{?>
				<label onclick="javascript:alert('\'본사만 가능\' 설정 시 입점사 이용 설정은 할 수 없습니다.');"><input type="checkbox" name="aaa" value="Y" disabled /> 가능</label>
<?php }?>
			</div>
		</td>
		<td class="its-td">
<?php if($TPL_VAR["config_system"]["goodsflow_use"]){?>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['gf_use']=='Y'){?>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['deliveryName']){?>
			[<?php echo $TPL_VAR["config_goodsflow"]["setting"]['deliveryName']?>]<br/>
<?php }?>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_msg']){?>
			<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflow_msg']?>

<?php }else{?>
			이용 중지 - 연동 정보 미입력
<?php }?>
<?php }else{?>
			이용 중지 - 본사 사용중지처리
<?php }?>
<?php }else{?>
			이용 중지 - 본사 사용중지처리
<?php }?>
		</td>
		<td class="its-td">
			<?php echo number_format($TPL_VAR["service_cnt"])?>건 
			<span class="btn small gray"><input type="button" id="gf_log" value="사용현황" /></span>
		</td>
	</tr>
	</tbody>
	</table>
	<div style="padding-top:5px; padding-bottom:15px; line-height:20px;">
		<div class="pdl10 pdt5">
		※ 롯데택배 - <b>5자리 우편번호 미지원</b>으로 5자리 우편번호로 접수된 주문건은 자동화 서비스를 이용할 수 없습니다.<br/>
		&nbsp;&nbsp;&nbsp;따라서 5자리 우편번호로 접수된 주문건은 자동화 서비스 외 다른 출고 방법으로 출고 처리해 주세요  (단 굿스플로 롯데 택배 이용시에는 자동화 서비스 이용 가능)
		</div>
		<div class="pdl10 pdt5">
		※ 굿스플로 - 송장 출력을 하려면 인터넷 익스플로러 8.0 이상을 사용하셔야 합니다.(익스플로러 外 사파리, 크롬 등 송장 출력 불가)
		</div>
		<div class="pdl10 pdt5">
		※ 입점사가 굿스플로 서비스를 이용하려면 ‘<b>가능</b>’ 으로 설정되어있어야만 사용 가능합니다.
		</div>
	</div>

	<div class="pdl10">※ 택배 업무 자동화 프로세스</div>
	<table width="100%" class="info-table-style" style="table-layout:fixed">
	<colgroup>
		<col width="160"/>
		<col />
	</colgroup>
	<tr>
		<th class="its-th">자동화 서비스</th>
		<td class="its-td">① 운송장번호</td>
		<td class="its-td">② 운송장 출력</td>
		<td class="its-td">③ 택배사에 출고정보 전달</td>
		<td class="its-td">④ 배송 추적</td>
	</tr>
	<tr>
		<th class="its-th">우체국 택배</th>
		<td class="its-td" rowspan="2">자동 할당</td>
		<td class="its-td">우체국 관리자에서 출력</td>
		<td class="its-td" rowspan="2">택배사에 자동 전송</td>
		<td class="its-td" rowspan="2">자동으로 추적하여 배송완료 자동 처리</td>
	</tr>
	<tr>
		<th class="its-th">롯데택배,<br/>굿스플로</th>
		<td class="its-td">쇼핑몰 관리환경에서 바로 출력</td>
	</tr>
	</table>
	<div class="pdl10 pdt10">※ 택배 업무 자동화 서비스 정보 업데이트 주기</div>
	<table width="100%" class="info-table-style" style="table-layout:fixed">
	<tr>
		<th class="its-th">구분</th>
		<td class="its-th">출고정보(퍼스트몰 → 택배사)</td>
		<td class="its-th">배송정보(택배사 → 퍼스트몰)</td>
	</tr>
	<tr>
		<td class="its-td">우체국택배</td>
		<td class="its-td">최대20분 소요</td>
		<td class="its-td">3시간단위</td>
	</tr>
	<tr>
		<td class="its-td">롯데택배</td>
		<td class="its-td">최대30분 소요</td>
		<td class="its-td">3시간단위</td>
	</tr>
	<tr>
		<td class="its-td">굿스플로</td>
		<td class="its-td">실시간</td>
		<td class="its-td">1일 1회</td>
	</tr>
	</table>
<!-- 택배자동화 서비스 :: END -->

<div class="item-title" style="width:100%"><span style="display:inline-block;"></span>보내는 곳 주소 및 반송 주소 <span style="display:inline-block;width:50px;text-align:right">
<?php if($_GET["provider_seq"]> 1){?>
<span class="btn small gray"><button type="button" class="modifyDeliveryButton" title="보내는 곳 주소 및 반송 주소" name="address">수정</button></span>
<?php }?>
</span></div>

<table width="100%" class="info-table-style">
<col width="200" /><col width="" /><col width="200" /><col width="" />
<tr>
	<th class="its-th">보내는 곳 주소</th>
	<td class="its-td">
<?php if($TPL_VAR["data_providershipping"]["sendding_zipcode"]){?>
		<span <?php if($TPL_VAR["data_providershipping"]["sendding_address_type"]=='street'){?>style="font-weight:bold;"<?php }?>>(도로명)</span> <?php echo $TPL_VAR["data_providershipping"]["sendding_zipcode"]?> <?php echo $TPL_VAR["data_providershipping"]["sendding_address_street"]?> <?php echo $TPL_VAR["data_providershipping"]["sendding_address_detail"]?><br>
		<span <?php if($TPL_VAR["data_providershipping"]["sendding_address_type"]!='street'){?>style="font-weight:bold;"<?php }?>>(지번)</span> <?php echo $TPL_VAR["data_providershipping"]["sendding_zipcode"]?> <?php echo $TPL_VAR["data_providershipping"]["sendding_address"]?>	<?php echo $TPL_VAR["data_providershipping"]["sendding_address_detail"]?><br>
<?php }?>
		
	</td>
</tr>
<tr>
	<th class="its-th">반송 주소</th>
	<td class="its-td">	
<?php if($TPL_VAR["data_providershipping"]["return_zipcode"]){?>
		<span <?php if($TPL_VAR["data_providershipping"]["return_address_type"]=='street'){?>style="font-weight:bold;"<?php }?>>(도로명)</span> <?php echo $TPL_VAR["data_providershipping"]["return_zipcode"]?> <?php echo $TPL_VAR["data_providershipping"]["return_address_street"]?> <?php echo $TPL_VAR["data_providershipping"]["return_address_detail"]?><br>
		<span <?php if($TPL_VAR["data_providershipping"]["return_address_type"]!='street'){?>style="font-weight:bold;"<?php }?>>(지번)</span> <?php echo $TPL_VAR["data_providershipping"]["return_zipcode"]?> <?php echo $TPL_VAR["data_providershipping"]["return_address"]?> <?php echo $TPL_VAR["data_providershipping"]["return_address_detail"]?><br>
		<span class="desc pdl10">↑ 상단의 주소는 구매자가 MY페이지에서 반품 할 때 반송 주소로 안내 되어집니다.</span>	
<?php }?>
	</td>
</tr>
</table>

<div id="invoiceSettingPopup" style="display:none;">
	<form name="invoiceSettingForm" action="../setting_process/invoice_setting" target="actionFrame" method="post">

	<table class="info-table-style" width="100%">
	<col width="170" />
		<tr>
			<th class="its-th">사용여부</th>
			<td class="its-td">
				<label><input type="checkbox" name="invoice_notuse" value="1" <?php if(!$TPL_VAR["config_system"]["invoice_use"]){?>checked<?php }?> /> 사용하지 않겠습니다.</label>
			</td>
		</tr>
	</table>

	<div id="invoiceSettingAuthContainer">

		<div class="gabia-pannel" code="invoice_guide_lotte"></div>

		<!-- 롯데택배 : start -->
		<table class="info-table-style" width="100%">
		<col width="170" />
		<tr>
			<th class="its-th">세팅비</th>
			<td class="its-td">
				<strike class="gray">110,000원</strike> → 0원 (이벤트 적용)
			</td>
		</tr>
		<tr>
			<th class="its-th">서비스 이용료</th>
			<td class="its-td">
				0원
			</td>
		</tr>
		<tr>
			<th class="its-th">계약 대리점명</th>
			<td class="its-td">
				<input type="text" class="line" name="branch_name" value="<?php echo $TPL_VAR["config_invoice"]["hlc"]["branch_name"]?>" />
				<span class="desc">예) 서울남부지점</span>
			</td>
		</tr>
		<tr>
			<th class="its-th">신용코드 인증</th>
			<td class="its-td">
				<div>
					<input type="text" class="invoice_auth_code line" name="auth_code[hlc]" value="<?php echo $TPL_VAR["config_invoice"]["hlc"]["auth_code"]?>" auth_code="<?php echo $TPL_VAR["config_invoice"]["hlc"]["auth_code"]?>" /> <span class="btn small black"><button type="button" onclick="hlc_auth()" >인증</button></span>
					<span class="invoice_auth_code_desc"></span>
				</div>
			</td>
		</tr>
		<tr>
			<th class="its-th">
				운송장 프린트 세팅
				<div class="gabia-pannel" code="invoice_print_setting_guide"></div>
			</th>
			<td class="its-td">
				<table cellpadding="0" cellspacing="0">
				<tr>
					<td><label><input type="radio" name="print_type" value="label_a" id="print_type_label_a" checked /> 라벨프린트 A타입</label></td>
					<td width="20"></td>
					<td><label><input type="radio" name="print_type" value="label_b" id="print_type_label_b"/> 라벨프린트 B타입</label></td>
					<td width="20"></td>
					<td><label><input type="radio" name="print_type" value="a4" id="print_type_a4" /> 레이저프린트 A4용지</label></td>
				</tr>
				<tr>
					<td height="5" colspan="5"></td>
				</tr>
				<tr>
					<td valign="top" align="center"><label for="print_type_label_a"><img src="/admin/skin/default/images/common/img_dliv_label_a.gif" /></label></td>
					<td></td>
					<td valign="top" align="center"><label for="print_type_label_b"><img src="/admin/skin/default/images/common/img_dliv_label_b.gif" /></label></td>
					<td></td>
					<td valign="top" align="center"><label for="print_type_a4"><img src="/admin/skin/default/images/common/img_dliv_a4.gif" /></label></td>
				</tr>
				</table>

				<script>
				$("input[name='print_type'][value='<?php echo $TPL_VAR["config_invoice"]["hlc"]["print_type"]?>']").attr('checked',true);
				</script>

			</td>
		</tr>
		</table>

		<!-- 롯데택배 : end -->

	</div>
	<div class="center pdt20">
<?php if(false){?>
		<span class="btn medium cyanblue"><input type="submit" value="확인" /></span>
<?php }else{?>
		<span class="red">
			입점사 연동은 입점사에서 직접 설정하여야 합니다.<br/>
			해당화면은 연동정보 조회만 가능합니다.
		</span>
<?php }?>
	</div>
	</form>
</div>

<!-- 우체국택배 연동설정 팝업창 :: 2016-03-28 lwh -->
<div id="epostSettingPopup" style="display:none;">
	<div id="status_info_txt">
<?php if($TPL_VAR["config_epost"]["status_msg"]){?>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
		우체국 택배 연동 서비스 이용이 가능합니다.
		단, 운송장 출력은 우체국 관리자 에서 가능하오니 이점 유의하시기 바랍니다.
<?php }elseif($TPL_VAR["config_epost"]["status"]=='7'){?>
		우체국 택배 연동 서비스가 현재 ‘<B><?php echo $TPL_VAR["config_epost"]["status_msg"]?></B>’ 상태 입니다.<br/>
		승인보류 사유를 확인하신 후 다시 서비스 신청을 완료해주시기 바랍니다.<br/>
		서비스 신청 후 3 영업일 이내에 승인이 되지 않은 경우 고객센터(1544-3270)로 문의해 주시기 바랍니다.
<?php }else{?>
		우체국 택배 연동 서비스가 현재 ‘<B><?php echo $TPL_VAR["config_epost"]["status_msg"]?></B>’ 상태 입니다.<br/>
		서비스 신청 후 3 영업일 이내에 승인이 되지 않은 경우 고객센터(1544-3270)로 문의해 주시기 바랍니다.
<?php }?>
<?php }else{?>
		우체국 택배 업무 자동화 서비스는 지역 우체국에 방문하여 '기업택배' 계약 완료 및 인터넷 우체국 택배 회원가입을 완료하신 후 서비스 신청이 가능합니다.<br/>
		이미 계약 완료 후 이용 중이시라면 바로 서비스 신청 하시면 됩니다.
<?php }?>
	</div>
	<div class="pd10 red">*표시 필수</div>
	<!-- 연동 설정 :: START -->
	<form name="epostSettingForm" action="/admin/setting_process/epost_setting" target="actionFrame" method="post">
	<input type="hidden" name="requestkey" value="<?php echo $TPL_VAR["config_epost"]["requestkey"]?>" />
	<input type="hidden" name="provider_seq" value="<?php echo $_GET["provider_seq"]?>" />
	<table width="100%" class="info-table-style" id="epost_form">
	<colgroup>
	<col width="16%"/>
	<col />
	<col width="16%"/>
	<col />
	</colgroup>
	<tr>
		<th class="its-th pdl10">사용여부</th>
		<td class="its-td" colspan="3">
			<label><input type="checkbox" name="epost_notuse" id="epost_notuse" value="N" /> 사용하지 않겠습니다.</label>
<?php if($TPL_VAR["config_epost"]["epost_use"]=='N'){?>
			<script>$("#epost_notuse").attr('checked',true);</script>
<?php }?>
		</td>
	</tr>
	<tr>
		<th class="its-th pdl10">연동상태</th>
		<td class="its-td" colspan="3">
<?php if($TPL_VAR["config_epost"]["status_msg"]){?>
				<?php echo $TPL_VAR["config_epost"]["status_msg"]?>

<?php }else{?>
			이용 중지 - 연동 정보 미입력
<?php }?>
		</td>
	</tr>
	<tr>
		<th class="its-th pdl10">우체국 아이디 <span class="red">*</span></th>
		<td class="its-td">
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
			*******
<?php }else{?>
			<input type="text" name="epost_id" value="<?php echo $TPL_VAR["config_epost"]["epost_id"]?>" class="line ep_ing" />
<?php }?>
		</td>
		<th class="its-th pdl10">우체국 비밀번호 <span class="red">*</span></th>
		<td class="its-td">
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
			*******
<?php }else{?>
			<input type="password" name="epost_pw" value="<?php echo $TPL_VAR["config_epost"]["epost_pw"]?>" class="line ep_ing" />
<?php }?>
		</td>
	</tr>
	<tr>
		<th class="its-th pdl10">우체국 고객번호 <span class="red">*</span></th>
		<td class="its-td">
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
			<?php echo getstrcut($TPL_VAR["config_epost"]["epost_num"], 7,'***')?>

<?php }else{?>
			<input type="hidden" class="duple_chk_use" name="duple_chk1" value="" />
			<input type="text" name="epost_num" value="<?php echo $TPL_VAR["config_epost"]["epost_num"]?>" class="line ep_ing duple_input" />
			<span class="btn small white"><input type="button" class="chk_duple" chk_type="epost_num" value="중복확인"/></span>
			<span class="red duple_txt hide">사용가능</span>
<?php }?>
		</td>
		<th class="its-th pdl10">우체국 승인번호 <span class="red">*</span></th>
		<td class="its-td">
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
			<?php echo $TPL_VAR["config_epost"]["epost_auth_code"][ 0]?> - <?php echo getstrcut($TPL_VAR["config_epost"]["epost_auth_code"][ 1], 1,'****')?>

<?php }else{?>
			<input type="hidden" class="duple_chk_use" name="duple_chk2" value="" />
			<input type="text" name="epost_auth_code[]" value="<?php echo $TPL_VAR["config_epost"]["epost_auth_code"][ 0]?>" class="line ep_ing duple_input" size="7" /> -
			<input type="text" name="epost_auth_code[]" value="<?php echo $TPL_VAR["config_epost"]["epost_auth_code"][ 1]?>" class="line ep_ing duple_input" size="7" />
			<span class="btn small white"><input type="button" class="chk_duple" chk_type="epost_auth_code[]" value="중복확인"/></span>
			<span class="red duple_txt hide">사용가능</span>
<?php }?>
		</td>
	</tr>
	<tr>
		<th class="its-th pdl10">라벨프린터 <span class="red">*</span></th>
		<td class="its-td" colspan="3">
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
<?php if($TPL_VAR["config_epost"]["label_printer"]=='N'){?>사용안함<?php }else{?><?php echo $TPL_VAR["config_epost"]["label_printer"]?><?php }?>
<?php }else{?>
			<select name="label_printer" class="line ep_ing">
				<option value="">선택</option>
				<option value="N">사용안함</option>
				<option value="DataMax">DataMax</option>
				<option value="Zebra">Zebra</option>
				<option value="LUKHAN">LUKHAN</option>
				<option value="BIXOLON-D420">BIXOLON-D420</option>
				<option value="TOSHIBA B-EX4T1-GS12">TOSHIBA B-EX4T1-GS12</option>
			</select>
<?php if($TPL_VAR["config_epost"]["label_printer"]){?>
			<script>
			$("select[name='label_printer'] option[value='<?php echo $TPL_VAR["config_epost"]["label_printer"]?>']").attr('selected',true).trigger('change');
			</script>
<?php }?>
<?php }?>
		</td>
	</tr>
	<tr>
		<th class="its-th pdl10">상호명</th>
		<td class="its-td">
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
			<?php echo $TPL_VAR["config_epost"]["biz_name"]?>

<?php }else{?>
			<input type="text" name="biz_name" value="<?php echo $TPL_VAR["config_epost"]["biz_name"]?>" class="ep_ing ep_box" readonly />
<?php }?>
		</td>
		<th class="its-th pdl10">대표자명</th>
		<td class="its-td">
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
			<?php echo $TPL_VAR["config_epost"]["biz_ceo"]?>

<?php }else{?>
			<input type="text" name="biz_ceo" value="<?php echo $TPL_VAR["config_epost"]["biz_ceo"]?>" class="ep_ing ep_box" readonly />
<?php }?>
		</td>
	</tr>
	<tr>
		<th class="its-th pdl10">사업자등록번호</th>
		<td class="its-td" colspan="3">
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
			<?php echo $TPL_VAR["config_epost"]["biz_no"]?>

<?php }else{?>
			<input type="text" name="biz_no" value="<?php echo $TPL_VAR["config_epost"]["biz_no"]?>" class="ep_ing ep_box" readonly />
<?php }?>
		</td>
	</tr>
	<tr>
		<th class="its-th pdl10">사업장주소</th>
		<td class="its-td" colspan="3">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<colgroup>
			<col width="55px" />
			<col width="10px" />
			<col />
			</colgroup>
			<tr>
				<td height="30px">우편번호</td>
				<td width="10px"> : </td>
				<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
					<?php echo $TPL_VAR["config_epost"]["biz_zipcode"]?>

<?php }else{?>
					<input type="text" name="biz_zipcode" value="<?php echo $TPL_VAR["config_epost"]["biz_zipcode"]?>" class="ep_ing ep_box" size="6" readonly />
<?php }?>
				</td>
			</tr>
			<tr>
				<td height="30px">주소</td>
				<td width="10px"> : </td>
				<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
					<?php echo $TPL_VAR["config_epost"]["biz_address"]?>

<?php }else{?>
					<input type="text" name="biz_address" value="<?php echo $TPL_VAR["config_epost"]["biz_address"]?>" size="80" class="ep_ing ep_box" readonly />
<?php }?>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th class="its-th pdl10">전화번호</th>
		<td class="its-td">
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
			<?php echo $TPL_VAR["config_epost"]["biz_phone"]?>

<?php }else{?>
			<input type="text" name="biz_phone" value="<?php echo $TPL_VAR["config_epost"]["biz_phone"]?>" class=" ep_ing ep_box" readonly />
<?php }?>
		</td>
		<th class="its-th">이메일</th>
		<td class="its-td">
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
			<?php echo $TPL_VAR["config_epost"]["biz_email"]?>

<?php }else{?>
			<input type="text" name="biz_email" value="<?php echo $TPL_VAR["config_epost"]["biz_email"]?>" class=" ep_ing ep_box" readonly />
<?php }?>
		</td>
	</tr>
	</table>
	<div class="personInfo" style="padding-top:10px;font-size:12px;">
		※ 입점사 사업자정보 변경은 각 입점사 관리자에서<span class="highlight-link" style="vertical-align:text-top !important;">정보수정>사업자</span> 에서 수정하셔야합니다.
	</div>

	<div class="center pdt20">
<?php if(false){?>	
<?php if($TPL_VAR["config_epost"]["status"]=='0'||$TPL_VAR["config_epost"]["status"]=='1'){?>
		<span class="btn medium red"><input type="button" id="epost_cancel" value="신청취소" /></span>
<?php }elseif($TPL_VAR["config_epost"]["status"]=='9'){?>
		<span class="btn medium red"><input type="button" id="epost_cancel" value="서비스 취소"/></span>
<?php }else{?>
		<span class="btn medium cyanblue"><input type="submit" value="서비스신청" /></span>
<?php }?>
<?php }else{?>
		<span class="red">
			입점사 연동은 입점사에서 직접 설정하여야 합니다.<br/>
			해당화면은 연동정보 조회만 가능합니다.
		</span>
<?php }?>
	</div>
	</form>
</div>
<!-- 우체국택배 연동설정 팝업창 :: END -->

<div id="goodsflowSettingPopup" style="display:none;">
	<div>
		굿스플로 택배 업무 자동화 서비스를 이용하시려면<br/>먼저 택배사(CJ/옐로우캡/로젠/KG로지스/우체국/한진) 와 계약을 하신 이후에 아래  정보를 기입해주세요.
	</div>
	<div class="pd10 red">*표시 필수</div>
	<!-- 굿스플로 설정 :: START -->
	<form name="goodsflowSettingForm" action="../setting_process/goodsflow_setting" target="actionFrame" method="post">
	<input type="hidden" name="requestKey" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['requestKey']?>" />
	<table width="100%" class="info-table-style" id="goodsflow_form">
	<colgroup>
	<col width="19%"/>
	<col />
	</colgroup>
	<tr>
		<th class="its-th">연동상태</th>
		<td class="its-td" colspan="3">
<?php if($TPL_VAR["config_system"]["goodsflow_use"]){?>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['gf_use']=='Y'){?>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['deliveryName']){?>
				[<?php echo $TPL_VAR["config_goodsflow"]["setting"]['deliveryName']?>]<br/>
<?php }?>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_msg']){?>
				<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflow_msg']?>

<?php }else{?>
				이용 중지 - 연동 정보 미입력
<?php }?>
<?php }else{?>
				이용 중지 - 본사 사용중지처리
<?php }?>
<?php }else{?>
				이용 중지 - 본사 사용중지처리
<?php }?>
		</td>
	</tr>
	<tr>
		<th class="its-th">* 아이디</th>
		<td class="its-td">
			<input type="hidden" name="mallId" value="<?php echo $TPL_VAR["config_system"]["shopSno"]?>_<?php echo $TPL_VAR["provider_seq"]?>" />
			XXXXX
		</td>
		<th class="its-th">* 입점사 쇼핑몰명</th>
		<td class="its-td">
			<input type="text" name="mallName" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['mallName']?>" class="line gf_ing" />
		</td>
	</tr>
	<tr>
		<th class="its-th">대표자</th>
		<td class="its-td">
			<input type="text" name="mallUserName" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['mallUserName']?>" class="line gf_ing" />
		</td>
		<th class="its-th">* 발송지명</th>
		<td class="its-td">
			<input type="text" name="centerName" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['centerName']?>" class="line gf_ing" />
		</td>
	</tr>
	<tr>
		<th class="its-th">* 발송지주소</th>
		<td class="its-td" colspan="3">
			<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td height="30px">우편번호 : </td>
				<td colspan="3">
					<input type="text" name="goodsflowZipcode[]" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflowZipcode'][ 0]?>" class="gf_ing" size="3" readonly /> -
					<input type="text" name="goodsflowZipcode[]" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflowZipcode'][ 1]?>" class="gf_ing" size="3" readonly />
					<span class="btn small"><input type="button" id="goodsflowZipcodeButton" value="우편번호" /></span>
				</td>
			</tr>
			<tr>
				<td height="30px">기본주소 : </td>
				<td>
					<input type="text" name="goodsflowAddress_type" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflowAddress_type']?>" class="line hide" />
					<input type="text" name="goodsflowAddress" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflowAddress']?>" size="40" class="line gf_ing" />
					<input type="text" name="goodsflowAddress_street" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflowAddress_street']?>" size="40" class="line hide" />
				</td>
				<td>상세주소</td>
				<td><input type="text" name="goodsflowAddressDetail" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflowAddressDetail']?>" size="30" class="line gf_ing" /></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th class="its-th">* 발송지전화1</th>
		<td class="its-td">
			<input type="text" name="centerTel1" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['centerTel1']?>" title="- 를 제외하고 입력" class="line gf_ing" />
		</td>
		<th class="its-th">발송지전화2</th>
		<td class="its-td">
			<input type="text" name="centerTel2" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['centerTel2']?>" title="- 를 제외하고 입력" class="line gf_ing" />
		</td>
	</tr>
	<tr>
		<th class="its-th">* 사업자 번호</th>
		<td class="its-td">
			<input type="text" name="bizNo" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['bizNo']?>" title="- 를 제외하고 입력" class="line gf_ing gf_complete" />
		</td>
		<th class="its-th">* 택배사</th>
		<td class="its-td">
			<input type="hidden" name="deliveryName" id="deliveryName" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['deliveryName']?>" />
			<select name="deliveryCode" id="deliveryCode" class="gf_ing gf_complete">
<?php if(is_array($TPL_R1=$TPL_VAR["config_goodsflow"]['terms'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
				<option value="<?php echo $TPL_K1?>" <?php if($TPL_VAR["config_goodsflow"]["setting"]['deliveryCode']==$TPL_K1){?>selected<?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
			</select>
		</td>
	</tr>
	<tr>
		<th class="its-th">* 택배사 계약코드</th>
		<td class="its-td">
			<input type="text" name="contractNo" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['contractNo']?>" class="line gf_ing gf_complete" />
		</td>
		<th class="its-th">택배사 업체코드<br/>(우체국인 경우 필수)</th>
		<td class="its-td">
			<input type="text" name="contractCustNo" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['contractCustNo']?>" class="line gf_ing gf_complete" />
		</td>
	</tr>
	<tr>
		<th class="its-th">
			* 요금정보<br/>
			(택배사와 계약한 <br/>정보를 기입,<br/> 다중기입 가능)<br/>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']!='2'){?>
			<span class="btn small gray"><input type="button" class="add_price" value="+" /></span>
<?php }?>
		</th>
		<td class="its-td" colspan="3">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if($TPL_VAR["config_goodsflow"]["setting"]['boxSize']){?>
<?php if(is_array($TPL_R1=$TPL_VAR["config_goodsflow"]["setting"]['boxSize'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
			<tr>
				<td height="30px">박스타입</td>
				<td colspan="7">
					<select name="boxSize[]" class="gf_ing">
						<option value="02" <?php if($TPL_VAR["config_goodsflow"]["setting"]['boxSize'][$TPL_K1]=='02'){?>selected<?php }?>>2Kg, 60Cm 미만</option>
						<option value="05" <?php if($TPL_VAR["config_goodsflow"]["setting"]['boxSize'][$TPL_K1]=='05'){?>selected<?php }?>>5Kg, 80Cm 미만</option>
						<option value="10" <?php if($TPL_VAR["config_goodsflow"]["setting"]['boxSize'][$TPL_K1]=='10'){?>selected<?php }?>>10Kg, 120Cm 미만</option>
						<option value="20" <?php if($TPL_VAR["config_goodsflow"]["setting"]['boxSize'][$TPL_K1]=='20'){?>selected<?php }?>>20Kg, 140Cm 미만</option>
						<option value="30" <?php if($TPL_VAR["config_goodsflow"]["setting"]['boxSize'][$TPL_K1]=='30'){?>selected<?php }?>>30Kg, 160Cm 미만</option>
					</select>
				</td>
			</tr>
			<tr>
				<td height="30px">선불배송 :</td>
				<td>
					<input type="text" name="shFare[]" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['shFare'][$TPL_K1]?>" size="10" class="line gf_ing" />
				</td>
				<td>신용배송 :</td>
				<td>
					<input type="text" name="scFare[]" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['scFare'][$TPL_K1]?>" size="10" class="line gf_ing" />
				</td>
				<td>착불배송 :</td>
				<td>
					<input type="text" name="bhFare[]" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['bhFare'][$TPL_K1]?>" size="10" class="line gf_ing" />
				</td>
				<td>반품배송 :</td>
				<td>
					<input type="text" name="rtFare[]" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['rtFare'][$TPL_K1]?>" size="10" class="line gf_ing" />
				</td>
			</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td height="30px">박스타입</td>
				<td colspan="7">
					<select name="boxSize[]">
						<option value="02">2Kg, 60Cm 미만</option>
						<option value="05">5Kg, 80Cm 미만</option>
						<option value="10">10Kg, 120Cm 미만</option>
						<option value="20">20Kg, 140Cm 미만</option>
						<option value="30">30Kg, 160Cm 미만</option>
					</select>
				</td>
			</tr>
			<tr>
				<td height="30px">선불배송 :</td>
				<td>
					<input type="text" name="shFare[]" value="" size="10" class="line gf_ing" />
				</td>
				<td>신용배송 :</td>
				<td>
					<input type="text" name="scFare[]" value="" size="10" class="line gf_ing" />
				</td>
				<td>착불배송 :</td>
				<td>
					<input type="text" name="bhFare[]" value="" size="10" class="line gf_ing" />
				</td>
				<td>반품배송 :</td>
				<td>
					<input type="text" name="rtFare[]" value="" size="10" class="line gf_ing" />
				</td>
			</tr>
<?php }?>
			</table>
		</td>
	</tr>
	</table>
	<div class="center pdt20">
<?php if(false){?>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']=='1'){?>
		<input type="hidden" name="gf_mode" value="modify" />
		<span class="btn medium cyanblue"><input type="submit" value="정보수정"/></span>
		<div class="red" style="padding-top:30px;">
			* 사업자번호나 택배사 혹은 택배사 계약코드가  변경된 경우 연동 서비스를 취소하고 재신청을 해야 합니다. &nbsp;&nbsp;&nbsp;
			<span class="btn medium red"><input type="button" id="goodsflow_cancel" value="서비스 취소"/></span>
		</div>
<?php }elseif($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']=='2'){?>
		<div class="red" style="padding-bottom:30px;">
			연동 대기중입니다. 잠시만 기다려 주세요.
		</div>
		<span class="btn medium red"><input type="button" id="goodsflow_cancel" value="신청취소" /></span>
<?php }elseif($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']=='3'){?>
		<span class="btn medium cyanblue"><input type="submit" value="재신청" /></span>
<?php }else{?>
		<span class="btn medium cyanblue"><input type="submit" value="서비스신청" /></span>
<?php }?>
<?php }else{?>
		<span class="red">
			입점사 굿스플로 연동은 입점사에서 직접 설정하여야 합니다.<br/>
			해당화면은 연동정보 조회만 가능합니다.
		</span>
<?php }?>
	</div>
	</form>
	<!-- 굿스플로 설정 :: END -->
</div>
<!-- 굿스플로 결제 -->
<div id="goodsflow_payment" class="hide"></div>
<!-- 굿스플로 로그 -->
<div id="goodsflow_log_area" class="hide">
	<iframe name="goodsflow_log" id="goodsflow_log" src="/admin/setting/goodsflow_log?no=<?php echo $TPL_VAR["config_goodsflow"]["setting"]["provider_seq"]?>" width="100%" height="730" frameborder="0"></iframe>
</div>
<!-- 택배업무자동화서비스 안내 팝업 :: 2015-07-07 lwh -->
<div id="desc_popup_area" class="hide">
	<table width="100%" class="info-table-style">
	<colgroup>
		<col width="15%"/>
		<col width="25%"/>
		<col width="25%"/>
		<col width="35%"/>
	</colgroup>
	<thead>
	<tr>
		<th class="its-th-align center">&nbsp;</th>
		<th class="its-th-align center">우체국 택배</th>
		<th class="its-th-align center">롯데 택배</th>
		<th class="its-th-align center">굿스플로</th>
	</tr>
	</thead>
	<tr>
		<td class="its-td">비용</td>
		<td class="its-td">무료</td>
		<td class="its-td">무료</td>
		<td class="its-td">유료</td>
	</tr>
	<tr>
		<td class="its-td">과금 방식 및 차감</td>
		<td class="its-td">-</td>
		<td class="its-td">-</td>
		<td class="its-td">
			선 충전 후 송장 출력시 차감<br/>
			(동일 출고번호당 1번 차감<br/>
			즉, 동일한 출고번호에 여러 번 출고하면 <br/>
			1번만 차감함)
		</td>
	</tr>
	<tr>
		<td class="its-td">지원택배</td>
		<td class="its-td">우체국 택배</td>
		<td class="its-td">롯데 택배</td>
		<td class="its-td">
			CJ/옐로우캡/로젠/동부/우체국/한진
		</td>
	</tr>
	<tr>
		<td class="its-td">출력 방법</td>
		<td class="its-td">우체국택배(자동) 출고 후<br/>우체국 택배 관리자에서 출력</td>
		<td class="its-td">롯데택배(자동) 출고 후<br/>출력 가능</td>
		<td class="its-td">
			굿스플로 자동화로 출고<br/>
			→ ‘송장 받기/출력‘ 으로 연동을 한 이후에 출력
		</td>
	</tr>
	</table>
</div>