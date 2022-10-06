<?php /* Template_ 2.2.6 2022/05/17 12:36:40 /www/music_brother_firstmall_kr/admin/skin/default/order/order_refund.html 000029534 */ 
$TPL_items_1=empty($TPL_VAR["items"])||!is_array($TPL_VAR["items"])?0:count($TPL_VAR["items"]);
$TPL_npay_reason_code_1=empty($TPL_VAR["npay_reason_code"])||!is_array($TPL_VAR["npay_reason_code"])?0:count($TPL_VAR["npay_reason_code"]);?>
<script type="text/javascript">
$(function(){

	$("#order_refund_container input[name='chk_seq[]']").change(function(){
		var row = $(this).closest("tr");
		var idx = $("#order_refund_container input[name='chk_seq[]']").index(this);
		var chk_item_seq = row.find("input[name='chk_item_seq[]']").val();
		var chk_option_seq = row.find("input[name='chk_option_seq[]']").val();
		var chk_suboption_seq	= row.find("input[name='chk_suboption_seq[]']").val();
		var chk_individual_refund = row.find("input[name='chk_individual_refund[]']").val();
		var chk_individual_refund_inherit = row.find("input[name='chk_individual_refund_inherit[]']").val();
		var chk_individual_export = row.find("input[name='chk_individual_export[]']").val();
		var chk_individual_return = row.find("input[name='chk_individual_return[]']").val();

		var sub_disabled_non		= 0;

		// Npay주문건 : 추가옵션과 함께 주문시 필수옵션 단독 취소 불가. 추가옵션 취소 후 필수옵션 취소되어야 함.(API)
<?php if(!$TPL_VAR["npay_use"]||$TPL_VAR["orders"]["pg"]!="npay"){?>
		// 추가옵션 선택할때
		if(row.find("input[name='chk_suboption_seq[]']").val()!='' && $(this).is(":checked")){
			if(chk_individual_refund!='1'){ // 개별취소 안되도록 설정했을때
				// 필수옵션이 선택되어있지 않으면 에러
				var result = true;
				$("#order_refund_container input[name='chk_item_seq[]'][value='"+chk_item_seq+"'][item_option_seq='"+chk_option_seq+"']").each(function(){
					if($(this).closest("tr").find("input[name='chk_suboption_seq[]']").val()==''){
						if(!$(this).closest("tr").find("input[name='chk_seq[]']").is(":checked")){
							openDialogAlert("이 상품의 추가옵션은 개별취소할 수 없습니다.",400,140);
							$("input[name='chk_seq[]']").eq(idx).attr("checked",false);
							result = false;
						}
					}
				});
				if(!result) return false;
			}
		}

		// 추가옵션 해제할때
		if(row.find("input[name='chk_suboption_seq[]']").val()!='' && !$(this).is(":checked")){
			if(chk_individual_refund!='1' || (chk_individual_refund=='1' && chk_individual_refund_inherit=='1')){
				var result = true;
				$("#order_refund_container input[name='chk_item_seq[]'][value='"+chk_item_seq+"'][item_option_seq='"+chk_option_seq+"']").each(function(){
					if($(this).closest("tr").find("input[name='chk_suboption_seq[]']").val()==''){
						if($(this).closest("tr").find("select[name='chk_ea[]'] option:last-child").is(":selected")){
							if(chk_individual_refund!='1'){
								openDialogAlert("이 상품의 추가옵션은 개별취소할 수 없습니다.",400,140);
							}else if(chk_individual_refund=='1' && chk_individual_refund_inherit=='1'){
								openDialogAlert("이 상품의 필수옵션이 취소되면 추가옵션도 함께 취소되어야합니다.",450,140);
							}
							$("input[name='chk_seq[]']").eq(idx).attr("checked",true);
							result = false;
						}
					}
				});
				if(!result) return false;
			}
		}

		// 필수옵션 해제할때
		if(row.find("input[name='chk_suboption_seq[]']").val()=='' && !$(this).is(":checked")){
			if(chk_individual_refund!='1'){ // 개별취소 안되도록 설정했을때
				// 추가옵션 해제
				var result = true;
				$("#order_refund_container input[name='chk_item_seq[]'][value='"+chk_item_seq+"'][item_option_seq='"+chk_option_seq+"']").each(function(){
					if($(this).closest("tr").find("input[name='chk_suboption_seq[]']").val()!=''){
						$(this).closest("tr").find("input[name='chk_seq[]']").removeAttr("checked").each(function(){
							$(this).closest("tr").find("input,select,textarea").not(this).attr("disabled",true);
						});
						$(this).closest("tr").find("select[name='chk_ea[]']").val('').attr("disabled",true);
					}
				});
			}
		}
<?php }?>


<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>
		// 취소가능한 추가옵션이 1개 이상일 때 아래 스크립트 적용
		var sub_disabled_cnt		= 0;

		//$("#viewgubun").html("aaa : " + chk_option_seq);
		var this_suboption = $("#order_refund_container input[name='chk_suboption_seq[]'][item_option_seq='"+chk_option_seq+"']");
		this_suboption.each(function(){
			var row2 = $(this).closest("tr");
			if($(this).val() != "") { 
				var sub_disabled = row2.find("input[name='chk_seq[]']").attr("disabled");

				//$("#viewgubun2").html("sub_disabled : "+ typeof this_disabled);

				if( sub_disabled ) { 
					sub_disabled_cnt = sub_disabled_cnt + 1; 
				}else{
					sub_disabled_non = sub_disabled_non + 1; 
				}
				//$("#viewgubun3").html("sub_disabled_non : "+sub_disabled_non);
				//if($(this).attr("disabled") == false) { sub_cnt		= sub_cnt + 1; }
			}
		});
<?php }?>


		if($(this).is(":checked")){
			row.find("input,select,textarea").not(this).removeAttr("disabled");
			row.find("select[name='chk_ea[]'] option:last-child").attr("selected",true).parent().change();
			
			/* npay 필수옵션 체크 일때 : 추가옵션도 함께 체크 */
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>
			if(chk_suboption_seq == '' && sub_disabled_non > 0){
				$("#order_refund_container input[name='chk_suboption_seq[]'][item_option_seq='"+chk_option_seq+"']").each(function(e){

					if($(this).val() != ''){

						$(this).removeAttr("disabled");
						var row2 = $(this).closest("tr");
						var sub_disabled = row2.find("input[name='chk_seq[]']").attr("disabled");
						if(sub_disabled != 'disabled'){
							row2.find("input,select,textarea").not(this).removeAttr("disabled");
							row2.find("input[name='chk_seq[]']").prop("checked",true);
							row2.find("select[name='chk_ea[]'] option:last-child").attr("selected",true).parent().change();
						}
					}
				});
			}
<?php }?>

		}
		else{
			row.find("input,select,textarea").not(this).attr("disabled",true);
			row.find("select[name='chk_ea[]'] option:first-child").attr("selected",true).parent().change();
			if($(this).attr('cancel_type') ==  1 ){
				//$(this).attr("disabled",true);
			}
			
			/* npay 추가옵션 선택해제 일 때 필수옵션도 선택해제 시킴, */
			/* 필수옵션 해제일때 : 전체 취소하거나 추가옵션이 모두 취소된 후에 필수옵션 취소 가능. */
			if(chk_suboption_seq != ''){
				if(sub_disabled_non > 0 ){
					if($(this).is(":checked") == false){
						var opt = $("#order_refund_container input[name='chk_seq[]'][item_option_seq='"+chk_option_seq+"'][opt_type='opt']").closest("tr");
						opt.find("input,select,textarea").not(this).not(opt.find("input[name='chk_seq[]']")).attr("disabled",true);
						opt.find("select[name='chk_ea[]'] option:first-child").attr("selected",true).parent().change();
						opt.find("input[name='chk_seq[]']").prop("checked",false);
					}
				}
			}
		}

		refund_method_layer_view();
	});

	$("#order_refund_container select[name='chk_ea[]']").change(function(){
		var row = $(this).closest("tr");
		var idx = $("#order_refund_container select[name='chk_ea[]']").index(this);
		var chk_item_seq = row.find("input[name='chk_item_seq[]']").val();
		var chk_option_seq = row.find("input[name='chk_option_seq[]']").val();
		var chk_individual_refund = row.find("input[name='chk_individual_refund[]']").val();
		var chk_individual_refund_inherit = row.find("input[name='chk_individual_refund_inherit[]']").val();
		var chk_individual_export = row.find("input[name='chk_individual_export[]']").val();
		var chk_individual_return = row.find("input[name='chk_individual_return[]']").val();

		if($(this).val()=='0'){
			$(this).closest("tr").find("input[name='chk_seq[]']").removeAttr("checked").change();
		}

		// 필수옵션일때
		if(row.find("input[name='chk_suboption_seq[]']").val()==''){
			if(chk_individual_refund!='1' || (chk_individual_refund=='1' && chk_individual_refund_inherit=='1')){
				if(row.find("select[name='chk_ea[]'] option:last-child").is(":selected")){
					$("#order_refund_container input[name='chk_item_seq[]'][value='"+chk_item_seq+"'][item_option_seq='"+chk_option_seq+"']").each(function(){
						if($(this).parent().find("input[name='chk_suboption_seq[]']").val()!=''){
							$(this).parent().find("input[name='chk_seq[]']").not(":disabled").attr("checked",true).change();
							$(this).closest("tr").find("select[name='chk_ea[]'] option").not(":last-child").attr("disabled",true);
						}
					});
				}else{
					$("#order_refund_container input[name='chk_item_seq[]'][value='"+chk_item_seq+"'][item_option_seq='"+chk_option_seq+"']").each(function(){
						if($(this).parent().find("input[name='chk_suboption_seq[]']").val()!=''){
							$(this).closest("tr").find("select[name='chk_ea[]'] option").not(":last-child").removeAttr("disabled");
						}
					});
				}
			}
		}

		refund_method_layer_view();
	});

	$("#order_refund_container .chk_all").click(function(){
		if($("#order_refund_container input[name='chk_seq[]']").not(":checked").length==0){
			$("#order_refund_container input[name='chk_seq[]']").removeAttr("checked").change();
		}else{
			$("#order_refund_container input[name='chk_seq[]']").not(":disabled").attr("checked",true).change();
		}
	});

	$("tr[disabledScript=1]").find("input,select").attr("disabled",true);

	// 수량 인풋박스 컨트롤
	$(".only_number_for_chk_ea").bind("blur",function(){
		var min = parseInt($(this).attr("min"));
		if(!( $(this).val() != "0" && $(this).val() != "")){
			openDialogAlert("0개 이상을 입력해주세요.",400,140,function(){$el.val(max);$el.focus();});
			$(this).val(max);
		}
		$(this).trigger("change");
	});
	// 수량 인풋박스 컨트롤
	/* 숫자만 입력, 맨앞 0 지움 */
	$(".only_number_for_chk_ea").bind("keyup change",function(){
		var regexp = /[^0-9]/gi;
		var $el = $(this);
		// 수량 체크
		var max = parseInt($(this).attr("max"));
		var min = parseInt($(this).attr("min"));
		var val = 0;
		if( $(this).val() != "0" && $(this).val() != ""){
			val = parseInt($(this).val());
		}		
		if(regexp.test($(this).val())) {
			$(this).val($(this).val().replace(regexp,""));
			openDialogAlert("숫자만 입력 가능합니다.",400,140,function(){$el.val(max);$el.focus();});
			$(this).val(max);
		}
		if($(this).val().length > 1 && $(this).val().substring(0,1) == "0"){
			$(this).val($(this).val().substring(1,$(this).val().length));
		}
		// 공백 입력 불가
		if($(this).val()==""){
			//$(this).val(0);
		}
		
		var msg = "수량은 "+min+"부터 "+max+"까지만 입력 가능합니다.";
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>
		msg = "네이버페이 주문은 전체취소(부분취소불가)만 가능합니다.";
<?php }?>
		if((val < min || val > max) && val != 0){
			openDialogAlert(msg,400,140,function(){$el.val(max);$el.focus();});
			$(this).val(max);
		}
		// select 박스에 값 전달
		$selectBoxEl = $(this).next();
		$selectBoxEl.children().remove();
		$selectBoxEl.append($("<option>").val($(this).val()));
		$selectBoxEl.val($selectBoxEl.first().val());
	});

});


function refund_method_layer_view(){
	var chk_ea_sum = 0;

	$("#order_refund_container select[name='chk_ea[]']").each(function(){
		chk_ea_sum += parseInt($(this).val());
	});

	if("<?php echo $TPL_VAR["order_total_ea"]?>" == chk_ea_sum.toString()){
		document.refundForm.cancel_type.value='full';
	}else{
		document.refundForm.cancel_type.value='partial';
	}

	if(("<?php echo $TPL_VAR["orders"]["payment"]?>" == "card" || "<?php echo $TPL_VAR["orders"]["payment"]?>" == "kakaomoney" || "<?php echo $TPL_VAR["orders"]["pg"]?>" == "payco" ) && "<?php echo $TPL_VAR["order_total_ea"]?>" == chk_ea_sum.toString()){
		$("#refund_method_layer").hide();
		$("#manual_refund_layer").show();
	}else{
		$("#refund_method_layer").show();
		$("#manual_refund_layer").hide();
	}

}

function refundSubmit(){

	/* 올앳 결제취소시 파라미터 암호화 스크립트 처리 */
<?php if($TPL_VAR["orders"]["pg"]=='allat'&&$TPL_VAR["orders"]["payment"]=='card'){?>
	if(document.refundForm.cancel_type.value=='full'){
		document.refundForm.action = "/common/allat_enc";
	}else{
		document.refundForm.action = "/admin/order_process/order_refund";
	}
<?php }?>

	loadingStart();

	return true;
}
</script>
<style>
body, select, button, table {font-size:11px}
.goods_name {display:inline-block;white-space:nowrap;overflow:hidden;width:320px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
</style>
<div id="order_refund_container">
	<form name="refundForm" method="post" action="/admin/order_process/order_refund" target="actionFrame" onsubmit="return refundSubmit()">
	<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["orders"]["order_seq"]?>" />
	<input type="hidden" name="cancel_type" value="" />

<?php if($TPL_VAR["orders"]["pg"]=='allat'&&$TPL_VAR["orders"]["payment"]=='card'){?>
	<input type='hidden' name='actionUrl'		value='/admin/order_process/order_refund' />
	<input type='hidden' name='allat_shop_id'	value='<?php echo $TPL_VAR["pg"]["mallCode"]?>' />
	<input type='hidden' name='allat_order_no'	value='<?php echo $TPL_VAR["orders"]["order_seq"]?>' />
<?php if($TPL_VAR["orders"]["pg_currency"]=='KRW'){?>
	<input type='hidden' name='allat_amt'		value='<?php echo floor($TPL_VAR["orders"]["settleprice"])?>' />
<?php }else{?>
	<input type='hidden' name='allat_amt'		value='<?php echo $TPL_VAR["orders"]["settleprice"]?>' />
<?php }?>
	<input type='hidden' name='allat_seq_no'	value='<?php echo $TPL_VAR["orders"]["pg_transaction_number"]?>' />

	<input type='hidden' name='allat_pay_type'	value='CARD' />
	<input type='hidden' name='allat_enc_data'	value='' />
	<input type='hidden' name='allat_opt_pin'	value='NOVIEW' />
	<input type='hidden' name='allat_opt_mod'	value='WEB' />
	<input type='hidden' name='allat_test_yn'	value='N' />
<?php }?>

<?php if($TPL_VAR["config_system"]["pgCompany"]=='kspay'){?>
	<input type=hidden name="storeid"		value="<?php echo $TPL_VAR["pg"]["mallId"]?>">
	<input type=hidden name="storepasswd"	value="<?php echo $TPL_VAR["pg"]["mallPass"]?>">
	<input type=hidden name="authty"		value="<?php echo $TPL_VAR["orders"]["kspay_authty"]?>">
	<input type=hidden name="trno" size=15 maxlength=12 value="<?php echo $TPL_VAR["orders"]["pg_transaction_number"]?>">
<?php }?>

	주문번호 : <?php echo $TPL_VAR["orders"]["order_seq"]?>


	<div style="height:15px"></div>

	<div class="pdb5">● 주문상품 중 결제취소 가능 상품 : 결제취소 상품과 수량을 선택하세요!</div>
	<span class="btn small gray mt5 mb5"><button type="button" class="chk_all">전체선택</button></span>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table_style">
	<thead>
	<tr>
		<th width="40"><span class="chk_all hand">선택</span></th>
		<th>주문상품</th>
		<th width="100">주문수량</th>
		<th width="100">취소 가능 수량</th>
		<th width="100">결제 취소 수량</th>
		<th width="80">처리 상태</th>
	</tr>
	</thead>
	<tbody>
<?php if($TPL_items_1){foreach($TPL_VAR["items"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["options"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["able_refund_ea"]&&$TPL_V1["goods_type"]!='gift'){?>
		<tr>
<?php }else{?>
		<tr disabledScript=1>
<?php }?>
			<td class="cell">
				<label><input type="checkbox" name="chk_seq[]" item_option_seq="<?php echo $TPL_V2["item_option_seq"]?>" opt_type="opt" <?php if($TPL_V2["able_refund_ea"]== 0){?>disabled<?php }?>  /></label>
				<input type="hidden" name="chk_item_seq[]" value="<?php echo $TPL_V2["item_seq"]?>" item_option_seq="<?php echo $TPL_V2["item_option_seq"]?>" disabled="disabled" />
				<input type="hidden" name="chk_option_seq[]" value="<?php echo $TPL_V2["item_option_seq"]?>" disabled="disabled" />
				<input type="hidden" name="chk_suboption_seq[]" value="" item_option_seq="<?php echo $TPL_V2["item_option_seq"]?>" disabled="disabled" />
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=='npay'){?><input type="hidden" name="chk_npay_product_order_id[]" value="<?php echo $TPL_V2["npay_product_order_id"]?>" disabled="disabled" /><?php }?>

				<input type="hidden" name="chk_individual_refund[]" value="<?php echo $TPL_V1["individual_refund"]?>" disabled="disabled" />
				<input type="hidden" name="chk_individual_refund_inherit[]" value="<?php echo $TPL_V1["individual_refund_inherit"]?>" disabled="disabled" />
				<input type="hidden" name="chk_individual_export[]" value="<?php echo $TPL_V1["individual_export"]?>" disabled="disabled" />
				<input type="hidden" name="chk_individual_return[]" value="<?php echo $TPL_V1["individual_return"]?>" disabled="disabled" />
			</td>
			<td class="cell left">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="left" width="80" valign="top"><img src="<?php echo $TPL_V1["image"]?>" align="absmiddle" hspace="5" width="45" height="45" style="border:1px solid #ddd;" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif'" /></td>
					<td class="left">
<?php if($TPL_V1["provider_name"]){?>
						<div class="provider_name">[<?php echo $TPL_V1["provider_name"]?>]</div>
<?php }?>
<?php if($TPL_VAR["npay_use"]&&$TPL_V2["npay_product_order_id"]){?><div class="ngray bold"><?php echo $TPL_V2["npay_product_order_id"]?><span style="font-size:11px;font-weight:normal"> (Npay상품주문번호)</span></div><?php }?>
						<div style="line-height:20px;" class="goods_name">
						<?php echo $TPL_V1["goods_name"]?>

						</div>

<?php if($TPL_V2["adult_goods"]=='Y'||$TPL_V2["option_international_shipping_status"]=='y'||$TPL_V2["cancel_type"]=='1'||$TPL_V2["tax"]=='exempt'){?>
						<div>
<?php if($TPL_V2["adult_goods"]=='Y'){?>
							<img src="/admin/skin/default/images/common/auth_img.png" alt="성인" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V2["option_international_shipping_status"]=='y'){?>
							<img src="/admin/skin/default/images/common/icon/plane_on.png" alt="해외배송상품" style="vertical-align: middle;" height="19" />
<?php }?>
<?php if($TPL_V2["cancel_type"]=='1'){?>
							<img src="/admin/skin/default/images/common/icon/nocancellation.gif" alt="청약철회" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V2["tax"]=='exempt'){?>
							<img src="/admin/skin/default/images/common/icon/taxfree.gif" alt="비과세" style="vertical-align: middle;"/>
<?php }?>
						</div>
<?php }?>

<?php if($TPL_V2["goods_kind"]=='coupon'){?>
<?php if($TPL_V2["coupon_serial"]){?><span class="order-item-coupon-serial" >티켓번호:<?php echo $TPL_V2["coupon_serial"]?></span><br/><?php }?>
<?php if($TPL_V2["goods_kind"]=='coupon'&&$TPL_V2["social_start_date"]&&$TPL_V2["social_end_date"]){?><span class="order-item-coupon-date" >유효기간:<?php echo $TPL_V2["social_start_date"]?>~<?php echo $TPL_V2["social_end_date"]?></span><br/><?php }?>
							<div class="goods-coupon-use-return">사용제한 : <?php echo $TPL_V2["couponinfo"]["coupon_use_return"]?></div>
							<div class="goods-coupon-cancel-day">취소 마감시간 : <?php echo $TPL_V2["couponinfo"]["socialcp_cancel_refund_day"]?></div>
<?php }?>
<?php if($TPL_V2["option1"]||$TPL_V2["option2"]||$TPL_V2["option3"]||$TPL_V2["option4"]||$TPL_V2["option5"]){?>
						<div class="desc"><img src="/admin/skin/default/images/common/icon_option.gif" style="vertical-align:bottom" />
<?php if($TPL_V2["option1"]){?><?php echo $TPL_V2["title1"]?> : <?php echo $TPL_V2["option1"]?><?php }?>
<?php if($TPL_V2["option2"]){?>, <?php echo $TPL_V2["title2"]?> : <?php echo $TPL_V2["option2"]?><?php }?>
<?php if($TPL_V2["option3"]){?>, <?php echo $TPL_V2["title3"]?> : <?php echo $TPL_V2["option3"]?><?php }?>
<?php if($TPL_V2["option4"]){?>, <?php echo $TPL_V2["title4"]?> : <?php echo $TPL_V2["option4"]?><?php }?>
<?php if($TPL_V2["option5"]){?>, <?php echo $TPL_V2["title5"]?> : <?php echo $TPL_V2["option5"]?><?php }?>
<?php }?>
<?php if($TPL_V2["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V2["goods_code"]?>]</div><?php }?>
						</div>
<?php if($TPL_V2["inputs"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["value"]){?>
						<div class="desc" style="margin:1px;">
							<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V3["title"]){?><?php echo $TPL_V3["title"]?>:<?php }?>
<?php if($TPL_V3["type"]=='file'){?>
							<a href="../order_process/filedown?file=<?php echo $TPL_V3["value"]?>" target="actionFrame" style="color:#848484;"><?php echo $TPL_V3["value"]?></a>
<?php }else{?><?php echo $TPL_V3["value"]?><?php }?>
						</div>
<?php }?>
<?php }}?>
<?php }?>
					</td>
				</tr>
				</table>
			</td>
			<td class="cell"><?php echo number_format($TPL_V2["ea"])?></td>
			<td class="cell"><?php echo number_format($TPL_V2["able_refund_ea"])?></td>
			<td class="cell">
<?php if($TPL_V2["able_refund_ea"]> 0){?>
					<!-- 인풋 박스 처리 시 input다음에 select를 위치한다. -->
					<input type="number"
						   name="input_chk_ea[]" 
						   class="only_number_for_chk_ea" 
						   value="<?php echo $TPL_V2["able_refund_ea"]?>"
						   min="<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=='npay'){?><?php echo $TPL_V2["able_refund_ea"]?><?php }else{?>1<?php }?>" 
						   max="<?php echo $TPL_V2["able_refund_ea"]?>"
						   disabled="disabled" />
					<select name="chk_ea[]" style="display:none;" disabled="disabled">
						<option value="<?php echo $TPL_V2["able_refund_ea"]?>" selected><?php echo $TPL_V2["able_refund_ea"]?></option>
					</select>
<?php }else{?>
					-
<?php }?>
			</td>
			<td class="cell">
				<?php echo $TPL_V2["mstep"]?>

			</td>
		</tr>

<?php if(is_array($TPL_R3=$TPL_V2["suboptions"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["able_refund_ea"]){?>
		<tr>
<?php }else{?>
		<tr disabledScript=1>
<?php }?>
			<td class="cell">
				<label><input type="checkbox" name="chk_seq[]"  item_option_seq="<?php echo $TPL_V2["item_option_seq"]?>" opt_type="sub" <?php if($TPL_V3["able_refund_ea"]== 0){?>disabled<?php }?>   /></label>
				<input type="hidden" name="chk_item_seq[]" value="<?php echo $TPL_V3["item_seq"]?>" item_option_seq="<?php echo $TPL_V2["item_option_seq"]?>" disabled="disabled" />
				<input type="hidden" name="chk_option_seq[]" value="<?php echo $TPL_V2["item_option_seq"]?>" disabled="disabled" />
				<input type="hidden" name="chk_suboption_seq[]" value="<?php echo $TPL_V3["item_suboption_seq"]?>" item_option_seq="<?php echo $TPL_V2["item_option_seq"]?>" disabled="disabled" />
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=='npay'){?><input type="hidden" name="chk_npay_product_order_id[]" value="<?php echo $TPL_V3["npay_product_order_id"]?>" disabled="disabled" /><?php }?>

				<input type="hidden" name="chk_individual_refund[]" value="<?php echo $TPL_V1["individual_refund"]?>" disabled="disabled" />
				<input type="hidden" name="chk_individual_refund_inherit[]" value="<?php echo $TPL_V1["individual_refund_inherit"]?>" disabled="disabled" />
				<input type="hidden" name="chk_individual_export[]" value="<?php echo $TPL_V1["individual_export"]?>" disabled="disabled" />
				<input type="hidden" name="chk_individual_return[]" value="<?php echo $TPL_V1["individual_return"]?>" disabled="disabled" />
			</td>
			<td class="cell left">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="right" width="80" valign="top">
						<img src="/admin/skin/default/images/common/icon_add_arrow.gif" border="0" /><span style="width:20px;display:inline-block"></span>
					</td>
					<td class="left">
<?php if($TPL_VAR["npay_use"]&&$TPL_V3["npay_product_order_id"]){?><div class="ngray bold"><?php echo $TPL_V3["npay_product_order_id"]?><span style="font-size:11px;font-weight:normal">(Npay상품주문번호)</span></div><?php }?>
						<div style="line-height:20px;"><?php if($TPL_V3["cancel_type"]=='1'){?><span class="order-item-cancel-type " >[청약철회불가]</span><br/><?php }?><?php echo $TPL_V3["goods_name"]?></div>
<?php if($TPL_V3["suboption"]){?>
						<div class="desc"><img src="/admin/skin/default/images/common/icon_add.gif" style="vertical-align:bottom" />
<?php if($TPL_V3["suboption"]){?><?php echo $TPL_V3["title"]?> : <?php echo $TPL_V3["suboption"]?><?php }?>
<?php }?>
<?php if($TPL_V3["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V3["goods_code"]?>]</div><?php }?>
						</div>
					</td>
				</tr>
				</table>
			</td>
			<td class="cell"><?php echo number_format($TPL_V3["ea"])?></td>
			<td class="cell"><?php echo number_format($TPL_V3["able_refund_ea"])?></td>
			<td class="cell">
<?php if($TPL_V3["able_refund_ea"]> 0){?>
					<!-- 인풋 박스 처리 시 input다음에 select를 위치한다. -->
					<input type="number"
						   name="input_chk_ea[]" 
						   class="only_number_for_chk_ea" 
						   value="<?php echo $TPL_V3["able_refund_ea"]?>"
						   min="<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=='npay'){?><?php echo $TPL_V3["able_refund_ea"]?><?php }else{?>1<?php }?>" 
						   max="<?php echo $TPL_V3["able_refund_ea"]?>"
						   disabled="disabled" />
					<select name="chk_ea[]" style="display:none;" disabled="disabled">
						<option value="<?php echo $TPL_V3["able_refund_ea"]?>" selected><?php echo $TPL_V3["able_refund_ea"]?></option>
					</select>
<?php }else{?>
					-
<?php }?>
			</td>
			<td class="cell">
				<?php echo $TPL_V3["mstep"]?>

			</td>
		</tr>
<?php }}?>


<?php }}?>
<?php }}?>
	</tbody>
	</table>
	
<?php if($TPL_VAR["orders"]["show_refund_method"]=='Y'){?>
	<div id="refund_method_layer">

		<div style="height:15px"></div>

		<div class="pdb5">● 환불 방법</div>
		<table class="info_table_style" width="100%">
		<tr>
			<th class="its_th">은행</th><td class="its_td"><input type="text" name="bank_name" value="" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>disabled<?php }?> /></td>
			<th class="its_th">예금주</th><td class="its_td"><input type="text" name="bank_depositor" value="" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>disabled<?php }?> /></td>
			<th class="its_th">계좌번호</th><td class="its_td"><input type="text" name="bank_account" value="" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>disabled<?php }?> /></td>
		</tr>
		</table>
		<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
		<div class="mt5">
			- 환불방법은 복합결제(마일리지, 쿠폰 사용 등) 및 최초 배송비 계산 등의 이유로 쇼핑몰 관리자와 협의 후 결정됩니다.
<?php if(in_array($TPL_VAR["orders"]["payment"],array("bank","virtual","escrow_virtual"))){?>
			<br />- 환불 금액을 입력할 환불 계좌 정보입니다. 결제 수단이 무통장, 가상 계좌인 경우 결제 금액은 관리자가 수동으로 입금해주세요.
<?php }?>
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>
		 <br />- 네이버페이 환불의 경우, 네이버페이 어드민 페이지에서 환불 정보를 입력할 수 있습니다.
<?php }?>
		</div>
	</div>
<?php }?>

	<div style="height:15px"></div>

<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>
	<div class="pdb5">● 상세 사유 
		: <select name="npay_reason_code">
<?php if($TPL_npay_reason_code_1){foreach($TPL_VAR["npay_reason_code"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option><?php }}?>
		</select>
	</div>
<?php }else{?>
	<div class="pdb5">● 상세 사유 
	<textarea name="refund_reason" style="width:100%;" rows="2"></textarea>
	<div style="height:15px"></div>
	</div>
<?php }?>

	<div class="pdb5">● 최초 배송비</div>
	부분 결제 취소 시 추가 배송비가 발생할 수 있으며, 이 때, 추가 배송비를 결제해 주셔야만 결제취소 처리완료가 가능합니다.<br />
	<b>[추가 배송비가 발생하는 경우]</b><br />
	① ‘묶음 배송비’ 상품의 배송비 무료(금액별 차등) 조건을 충족하여 배송비 무료<br />
	   부분 결제취소로 배송비 무료 조건을 불충족하는 경우 추가 배송비 부과<br />
	   추가 배송비는 카드 또는 캐시로 결제 가능<br />
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>
	<div class="pdb5">● 네이버페이 환불의 경우, 네이버페이 어드민 페이지에서 환불 정보를 입력할 수 있습니다.</div>
<?php }?>


	<div style="height:15px"></div>

	<div id="manual_refund_layer" class="center hide">
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>
			네이버 페이 주문에 대한 환불은 네이버페이에서 처리됩니다.
<?php }else{?>
		<label><input type="checkbox" name="manual_refund_yn" value="y" checked /> 전자결제(PG)사 결제취소 처리 후 환불완료처리</label>
<?php }?>
	</div>

	<div style="height:15px"></div>

	<div class="center"><span class="btn large black"><input type="submit" value="작성완료" /></span></div>

	<div style="height:15px"></div>

	</form>
</div>