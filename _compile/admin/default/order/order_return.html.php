<?php /* Template_ 2.2.6 2022/01/05 11:56:25 /www/music_brother_firstmall_kr/admin/skin/default/order/order_return.html 000035771 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_reasonLoop_1=empty($TPL_VAR["reasonLoop"])||!is_array($TPL_VAR["reasonLoop"])?0:count($TPL_VAR["reasonLoop"]);
$TPL_bankReturn_1=empty($TPL_VAR["bankReturn"])||!is_array($TPL_VAR["bankReturn"])?0:count($TPL_VAR["bankReturn"]);?>
<script type="text/javascript">
$(function(){
	$("#order_return_container select[name='reason[]']").change(function(){
		var row = $(this).closest("tr");
		var reason_desc = row.find("select[name='reason[]'] option:selected").text();
		row.find("input[name='reason_desc[]']").val(reason_desc);
	});

	$("#order_return_container input[name='chk_seq[]']").change(function(){
		// disabled 상태면 checked 속성을 제거하고 false를 반환한다.
		if($(this).attr('disabled') === 'disabled') {
			$(this).removeAttr('checked');
			return false;
		}
		var obj						= $(this);
		var row						= obj.closest("tr");
		var idx						= $("#order_return_container select[name='chk_ea[]']").index(this);
		var chk_item_seq			= row.find("input[name='chk_item_seq[]']").val();
		var chk_option_seq			= row.find("input[name='chk_option_seq[]']").val();
		var chk_suboption_seq		= row.find("input[name='chk_suboption_seq[]']").val();
		var chk_individual_return	= row.find("input[name='chk_individual_return[]']").val();
		var chk_export_code			= row.find("input[name='chk_export_code[]']").val();
		var pay_shiping_cost_arr	= new Array();

		var sub_disabled_non	= 0;

		// Npay주문건 : 추가옵션과 함께 주문시 필수옵션 단독 취소 불가. 추가옵션 취소 후 필수옵션 취소되어야 함.(API)
<?php if(!$TPL_VAR["npay_use"]||$TPL_VAR["orders"]["pg"]!="npay"){?>
		// 추가옵션 선택할때
		if(row.find("input[name='chk_suboption_seq[]']").val()!='' && obj.is(":checked")){
			// 개별취소 안되도록 설정했을때
			if(chk_individual_return != '1'){

				var result = true;		// 필수옵션이 선택되어있지 않으면 에러

				$("#order_return_container input[name='chk_item_seq[]'][value='"+chk_item_seq+"'][item_option_seq='"+chk_option_seq+"'][export_code='"+chk_export_code+"']").each(function(){
					if($(this).closest("tr").find("input[name='chk_suboption_seq[]']").val()==''){
						if(!$(this).closest("tr").find("input[name='chk_seq[]']").is(":checked")){
							obj.prop("checked",false);
							openDialogAlert("이 상품의 추가옵션은 개별반품할 수 없습니다.",400,140);
							result = false;
						}
					}
				});
				if(!result) return false;
			}
		}

		// 추가옵션 해제할때
		if(row.find("input[name='chk_suboption_seq[]']").val()!='' && !$(this).is(":checked")){
			if(chk_individual_return!='1'){
				var obj			= $(this);
				var result		= true;
				$("#order_return_container input[name='chk_item_seq[]'][value='"+chk_item_seq+"'][item_option_seq='"+chk_option_seq+"'][export_code='"+chk_export_code+"']").each(function(){
					if($(this).closest("tr").find("input[name='chk_suboption_seq[]']").val()==''){
						if($(this).closest("tr").find("select[name='chk_ea[]'] option").length>1 && $(this).closest("tr").find("select[name='chk_ea[]'] option:last-child").is(":selected")){
							obj.prop("checked",true);
							openDialogAlert("이 상품의 추가옵션은 개별반품할 수 없습니다.",400,140);
							result = false;
						}
					}
				});
				if(!result) return false;
			}
		}

		// 필수옵션 해제할때
		if(row.find("input[name='chk_suboption_seq[]']").val()=='' && !$(this).is(":checked")){
			if(chk_individual_return!='1'){ // 개별취소 안되도록 설정했을때
				// 추가옵션 해제
				var result = true;
				$("#order_return_container input[name='chk_item_seq[]'][value='"+chk_item_seq+"'][item_option_seq='"+chk_option_seq+"'][export_code='"+chk_export_code+"']").each(function(){
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


		// 취소가능한 추가옵션이 1개 이상일 때 아래 스크립트 적용
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>
		var this_suboption		= $("#order_return_container input[name='chk_suboption_seq[]'][item_option_seq='"+chk_option_seq+"']");
		this_suboption.each(function(){
			var row2 = $(this).closest("tr");
			if($(this).val() != "") { 
				var sub_disabled = row2.find("input[name='chk_seq[]']").attr("disabled");
				if( sub_disabled ) { }
				else{
					sub_disabled_non = sub_disabled_non + 1; 
				}
			}
		});
<?php }?>

		if($(this).is(":checked")){
			row.find("input,select,textarea").not(this).removeAttr("disabled");
			row.find("select[name='chk_ea[]'] option:last-child").attr("selected",true).parent().change();

			/* npay 필수옵션 체크 일때 : 추가옵션도 함께 체크 */
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>
			if(chk_suboption_seq == '' && sub_disabled_non > 0){
				$("#order_return_container input[name='chk_suboption_seq[]'][item_option_seq='"+chk_option_seq+"']").each(function(e){

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
			if(chk_suboption_seq != '' && sub_disabled_non > 0 ){
				if($(this).is(":checked") == false){
					var opt = $("#order_return_container input[name='chk_seq[]'][item_option_seq='"+chk_option_seq+"'][opt_type='opt']").closest("tr");
					opt.find("input,select,textarea").not(this).not(opt.find("input[name='chk_seq[]']")).attr("disabled",true);
					opt.find("select[name='chk_ea[]'] option:first-child").attr("selected",true).parent().change();
					opt.find("input[name='chk_seq[]']").prop("checked",false);
				}
			}
		}

		// 사유 선택 여부 결정 :: 2018-06-12 lwh
		if($("#order_return_container input[name='chk_seq[]']:checked").length > 0){
			$("select[name='reason']").removeAttr("disabled");
			$("select[name='reason']").css('background','');
			$(".reason_ship_duty_area").show();
			// 반품/교환 배송비 View 계산
			$("#order_return_container input[name='chk_seq[]']:checked").not(":disabled").each(function (idx){
				var shipObj = $(this).closest('tbody').find("input[name='pay_shiping_cost[]']");
				pay_shiping_cost_arr[shipObj.attr('shipping_seq')] = parseFloat(shipObj.val());
			});
			// 배열에 값이 없어 reduce 함수 오류 수정 :: 2019-08-13 rsh
			if( pay_shiping_cost_arr.length > 0 ) {
				var refund_ship_cost = pay_shiping_cost_arr.reduce(function (previous, current){
					return previous + current
				});
			} else {
				var refund_ship_cost = 0;
			}
			
			$("#shiping_cost").val(refund_ship_cost);
			$("#refund_ship_cost").html(get_currency_price(refund_ship_cost,2));
		}else{
			$("select[name='reason']").attr('disabled',true);
			$("select[name='reason']").css('background','#ccc');
			$(".reason_ship_duty_area").hide();
		}
		$("select[name='reason']").trigger('change');

		refund_method_layer_view();
	}).change();

	$("#order_return_container select[name='chk_ea[]']").change(function(){
		var row = $(this).closest("tr");
		var idx = $("#order_return_container select[name='chk_ea[]']").index(this);
		var chk_item_seq = row.find("input[name='chk_item_seq[]']").val();
		var chk_option_seq = row.find("input[name='chk_option_seq[]']").val();
		var chk_individual_return = row.find("input[name='chk_individual_return[]']").val();
		var chk_export_code = row.find("input[name='chk_export_code[]']").val();

		if($(this).val()=='0'){
			$(this).closest("tr").find("input[name='chk_seq[]']").removeAttr("checked").change();
		}

		// 필수옵션일때
		if(row.find("input[name='chk_suboption_seq[]']").val()==''){
			if(chk_individual_return!='1'){
				if(row.find("select[name='chk_ea[]'] option").length>1 && row.find("select[name='chk_ea[]'] option:last-child").is(":selected")){
					$("#order_return_container input[name='chk_item_seq[]'][value='"+chk_item_seq+"'][item_option_seq='"+chk_option_seq+"'][export_code='"+chk_export_code+"']").each(function(){
						if($(this).parent().find("input[name='chk_suboption_seq[]']").val()!=''){
							$(this).parent().find("input[name='chk_seq[]']").not(":disabled").attr("checked",true).change();
							$(this).closest("tr").find("select[name='chk_ea[]'] option").not(":last-child").attr("disabled",true);
						}
					});
				}else{
					$("#order_return_container input[name='chk_item_seq[]'][value='"+chk_item_seq+"'][item_option_seq='"+chk_option_seq+"'][export_code='"+chk_export_code+"']").each(function(){
						if($(this).parent().find("input[name='chk_suboption_seq[]']").val()!=''){
							$(this).closest("tr").find("select[name='chk_ea[]'] option").not(":last-child").removeAttr("disabled");
						}
					});
				}
			}
		}

		refund_method_layer_view();
	});

	$("#order_return_container .chk_all").click(function(){
		var tableObj = $(this).closest('span').next('.chk_list_table'); 
		if($("input[name='chk_seq[]']",tableObj).not(":disabled").not(":checked").length==0){
			$("input[name='chk_seq[]']",tableObj).removeAttr("checked").change();
		}else{
			$("input[name='chk_seq[]']",tableObj).not(":disabled").attr("checked",true).change();
		}
	});

	$("input[name='refund_method']").change(function(){
		$(".refund_method_cash").hide();
		$(".refund_method_bank").hide();
		if($(this).is(":checked")){
			$(".refund_method_"+$(this).val()).show();
		}
	}).change();

	$("input[name='chk_shipping_seq'][tot_rt_ea!='0']").eq(0).attr("checked",true);
	$("input[name='chk_shipping_seq']").change(function(){
		var shippingGroupObj = $(this).closest('div.shipping_group');
		if($(this).is(":checked") ){
			$(shippingGroupObj).children("table").css('opacity',1);
			$(shippingGroupObj).find("tr").not("[disabledscript='1']").find("*").removeAttr("disabled");
			$("div.shipping_group").not(shippingGroupObj).children("table").css('opacity',0.5).find("*").not("tbody,tr").attr("disabled",true);

			if($(this).val()!='1' && $("input[name='chk_shipping_group_address[]']",shippingGroupObj).val().length>20){
				$(".return_shipping_group_address").text($("input[name='chk_shipping_group_address[]']",shippingGroupObj).val());
			}else{
				$(".return_shipping_group_address").text(": (반송주소) " + $(this).attr("return_address"));
			}
		}else{
			//$(shippingGroupObj).children("table").css('opacity',0.5).find("*").attr("disabled",true);
			//$("div.shipping_group").not(shippingGroupObj).children("table").css('opacity',1).find("*").removeAttr("disabled");
		}
		$("#order_return_container input[name='chk_seq[]']").change();

	}).change();

	$("input[name='submitButton']").bind('click',function(){
		var frm = this;
		openDialogConfirm("반품신청을 하기 위해 상품수령을 확인해주세요. 상품을 수령하셨습니까?",450,140,function(){
			$("form[name='refundForm']").submit();
		});
		return false;
	});

	// 우편번호 찾기
	$("#return_recipient_zipcode_button").live("click",function(){
        openDialogZipcode('return_recipient_');
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
		if((val < min || val > max) && val != 0){
			openDialogAlert("수량은 "+min+"부터 "+max+"까지만 입력 가능합니다.",400,140,function(){$el.val(max);$el.focus();});
			$(this).val(max);
		}
		// select 박스에 값 전달
		$selectBoxEl = $(this).next();
		$selectBoxEl.children().remove();
		$selectBoxEl.append($("<option>").val($(this).val()));
		$selectBoxEl.val($selectBoxEl.first().val());
	});

	// 사유 선택 시 - 책임확정 :: 2018-06-12 lwh
	$("select[name='reason']").on('change', function(){
		var reason_desc = $("select[name='reason'] option:selected").text();
		$("input[name='reason_desc']").val(reason_desc);
		$(".reason_ship_duty").hide();

<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?>
		var duty = $("select[name='reason'] option:selected").attr('npay_duty');
<?php }else{?>
		var duty = $("select[name='reason'] option:selected").val();
<?php }?>

		if(duty == "buyer" || duty == "120"){
			if(duty == "120") $(".shipping_refund_area").show();
			$(".reason_buyer").show();
		}else{
			$(".shipping_refund_area").hide();
			$(".reason_seller").show();
		}
	});

});


function refund_method_layer_view(){
	var chk_ea_sum = 0;

	$("#order_return_container select[name='chk_ea[]']").not(":disabled").each(function(){
		chk_ea_sum += num($(this).val());
	});

	if("<?php echo $TPL_VAR["orders"]["payment"]?>" == "card" && "<?php echo $TPL_VAR["items_tot"]["ea"]?>" == chk_ea_sum.toString()){
		$("#refund_method_layer").hide();
	}else{
		$("#refund_method_layer").show();
	}

}

// 반품/교환 배송비 결제 방법
function refund_ship_type_chg(){
	var refund_ship_type = $("#refund_ship_type option:selected").val();
	$(".refund_ship_account").hide();
	$(".refund_ship_minus").hide();
	if (refund_ship_type == 'A'){
		$(".refund_ship_account").show();
	}else if (refund_ship_type == 'M'){
		$(".refund_ship_minus").show();
	}
}
</script>

<style>
.goods_name {display:inline-block;white-space:nowrap;overflow:hidden;width:350px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
</style>

<div id="order_return_container">

	<form name="refundForm" method="post" action="/admin/order_process/order_return" target="actionFrame" onsubmit="loadingStart();">
	<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["orders"]["order_seq"]?>" />
	<input type="hidden" id="shiping_cost" name="shiping_cost" />

	주문번호 : <?php echo $TPL_VAR["orders"]["order_seq"]?>


	<div style="height:15px"></div>

	● 주문상품 중 <?php if($_GET["mode"]=='exchange'){?>교환<?php }else{?>반품<?php }?> 가능 상품 : <?php if($_GET["mode"]=='exchange'){?>교환<?php }else{?>반품<?php }?> 상품과 수량을 선택하세요!

<?php if($TPL_VAR["gift_cnt"]> 0){?><!--<span class="red">사은품 지급 대상 상품 반품 시 사은품도 함께 반품해 주십시오.</span>--><?php }?>

	<div style="height:15px"></div>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<div class="shipping_group">
		<div class="pdb5"><label><input type="radio" name="chk_shipping_seq" value="<?php echo $TPL_V1["shipping_provider"]["provider_seq"]?>" tot_rt_ea="<?php echo $TPL_V1["tot_rt_ea"]?>" return_address="<?php echo $TPL_V1["return_address"]?>" /> <?php echo $TPL_V1["shipping_provider"]["provider_name"]?></label></div>
		<input type="hidden" name="chk_shipping_group_address[]" value=": (반송주소) <?php echo $TPL_V1["shipping_provider"]["deli_zipcode"]?> <?php echo htmlspecialchars($TPL_V1["shipping_provider"]["deli_address1"])?> <?php echo htmlspecialchars($TPL_V1["shipping_provider"]["deli_address2"])?>" />
		<span class="btn small gray mt5 mb5"><button type="button" class="chk_all">전체선택</button></span>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table_style chk_list_table">
		<thead>
		<tr>
			<th width="40">선택</th>
			<th>주문상품</th>
			<th width="80">주문수량</th>
			<th width="100"><?php if($_GET["mode"]=='exchange'){?>교환<?php }else{?>반품<?php }?> 가능 수량</th>
			<th width="80"><?php if($_GET["mode"]=='exchange'){?>교환<?php }else{?>반품<?php }?> 수량</th>
			<th width="80">처리 상태</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td class="cell left" colspan="7">
				↓ 출고번호 : <?php echo $TPL_V1["export_item"][ 0]["export_code"]?> &nbsp;&nbsp; 배송지 : <?php echo $TPL_VAR["orders"]["recipient_user_name"]?> /  <?php if($TPL_VAR["orders"]["recipient_address_type"]=="street"){?> <?php echo $TPL_VAR["orders"]["recipient_address_street"]?><?php }else{?> <?php echo $TPL_VAR["orders"]["recipient_address"]?> <?php }?> <?php echo $TPL_VAR["orders"]["recipient_address_detail"]?>

			</td>
		</tr>
<?php if(is_array($TPL_R2=$TPL_V1["export_item"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_V2["rt_ea"]&&$TPL_V2["goods_type"]!='gift'){?>
			<tr>
<?php }else{?>
			<tr disabledScript=1>
<?php }?>
				<td class="cell">
					<!-- 구매확정후 반품가능 처리 by hed #32095 -->
					<input type='hidden' name='chk_after_refund[]'	value='<?php echo $TPL_V2["after_refund"]?>' />
					
					<label><input type="checkbox" name="chk_seq[]" value="1" item_option_seq="<?php echo $TPL_V2["item_option_seq"]?>" opt_type="<?php echo $TPL_V2["opt_type"]?>" /></label>
					<input type="hidden" name="chk_item_seq[]" value="<?php echo $TPL_V2["item_seq"]?>" item_option_seq="<?php echo $TPL_V2["item_option_seq"]?>" export_code="<?php echo $TPL_V2["export_code"]?>" />
					<input type="hidden" name="chk_option_seq[]" value="<?php echo $TPL_V2["item_option_seq"]?>" />
					<input type="hidden" name="chk_suboption_seq[]" value="<?php if($TPL_V2["opt_type"]=='sub'){?><?php echo $TPL_V2["option_seq"]?><?php }else{?><?php }?>"  item_option_seq="<?php echo $TPL_V2["item_option_seq"]?>" />
					<input type="hidden" name="chk_export_code[]" value="<?php echo $TPL_V2["export_code"]?>" />
					<input type="hidden" name="chk_individual_return[]" value="<?php echo $TPL_V2["individual_return"]?>" />
<?php if($TPL_I2== 0){?>
					<input type="hidden" name="pay_shiping_cost[]" shipping_seq="<?php echo $TPL_V2["shipping_seq"]?>" value="<?php if($_GET["mode"]=='exchange'||$TPL_V2["shiping_free_yn"]=='Y'){?><?php echo $TPL_V2["swap_shiping_cost"]?><?php }else{?><?php echo $TPL_V2["refund_shiping_cost"]?><?php }?>" />
<?php }?>
					<input type="hidden" name="mode" value="<?php echo $_GET["mode"]?>" />
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?><input type="hidden" name="chk_npay_product_order_id[]" value="<?php echo $TPL_V2["npay_product_order_id"]?>" item_option_seq="<?php echo $TPL_V2["item_option_seq"]?>" opt_type="<?php echo $TPL_V2["opt_type"]?>" /><?php }?>
				</td>
				<td class="cell left">
					<table border="0" width="420" cellpadding="0" cellspacing="0">
					<colgroup><col width="65"><col width="355"></colgroup>
					<tr>
						<td class="left" valign="top">
<?php if($TPL_V2["opt_type"]=='opt'){?>
						<img src="<?php echo $TPL_V2["image"]?>" align="absmiddle" hspace="5" width="45" height="45" style="border:1px solid #ddd;" onerror="this.src='/admin/skin/default/order/images/common/noimage_list.gif'" />
<?php }else{?>
						<div style="width:100%;text-align:right;"><img src="/admin/skin/default/images/common/icon_add_arrow.gif" border="0" hspace="15"></div>
<?php }?>

						</td>
						<td class="left">

<?php if($TPL_VAR["npay_use"]&&$TPL_V2["npay_product_order_id"]){?><div class="ngray bold"><?php echo $TPL_V2["npay_product_order_id"]?><span style="font-size:11px;font-weight:normal"> (Npay상품주문번호)</span></div><?php }?>
<?php if($TPL_V2["opt_type"]=='opt'){?>
							<div style="line-height:20px;" class="goods_name">
<?php if($TPL_V2["goods_type"]=='gift'){?>
								<img src="/admin/skin/default/images/common/icon_gift.gif" />
<?php }?>
								<?php echo $TPL_V2["goods_name"]?>

							</div>
<?php }?>

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

<?php if($TPL_V2["option1"]!=null||$TPL_V2["option2"]!=null||$TPL_V2["option3"]!=null||$TPL_V2["option4"]!=null||$TPL_V2["option5"]!=null){?>
							<div class="desc">
<?php if($TPL_V2["opt_type"]=='sub'){?>
								<img src="/admin/skin/default/images/common/icon_add.gif" align="absmiddle" />
<?php }else{?>
								<img src="/admin/skin/default/images/common/icon_option.gif" align="absmiddle" />
<?php }?>
<?php if($TPL_V2["option1"]!=null){?><?php echo $TPL_V2["title1"]?> : <?php echo $TPL_V2["option1"]?><?php }?>
<?php if($TPL_V2["option2"]!=null){?>, <?php echo $TPL_V2["title2"]?> : <?php echo $TPL_V2["option2"]?><?php }?>
<?php if($TPL_V2["option3"]!=null){?>, <?php echo $TPL_V2["title3"]?> : <?php echo $TPL_V2["option3"]?><?php }?>
<?php if($TPL_V2["option4"]!=null){?>, <?php echo $TPL_V2["title4"]?> : <?php echo $TPL_V2["option4"]?><?php }?>
<?php if($TPL_V2["option5"]!=null){?>, <?php echo $TPL_V2["title5"]?> : <?php echo $TPL_V2["option5"]?><?php }?>
							</div>
<?php }?>
<?php if($TPL_V2["goods_code"]){?>
							<div class="goods_option fx11 goods_code_icon">
								[상품코드: <?php echo $TPL_V2["goods_code"]?>]
							</div>
<?php }?>

<?php if($TPL_V2["inputs"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["value"]){?>
							<div class="desc" style="margin:1px;">
								<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V3["title"]){?><?php echo $TPL_V3["title"]?>:<?php }?>
<?php if($TPL_V3["type"]=='file'){?>
								<a href="/admin/order_process/filedown?file=<?php echo $TPL_V3["value"]?>" target="actionFrame" style="color:#848484;"><?php echo $TPL_V3["value"]?></a>
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
				<td class="cell"><?php echo number_format($TPL_V2["rt_ea"])?></td>
				<td class="cell">
<?php if($TPL_V2["rt_ea"]> 0){?>
						<!-- 인풋 박스 처리 시 input다음에 select를 위치한다. -->
						<input type="number"
							   name="input_chk_ea[]" 
							   class="only_number_for_chk_ea" 
							   value="<?php echo $TPL_V2["rt_ea"]?>"
							   min="<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=="npay"){?><?php echo $TPL_V2["rt_ea"]?><?php }else{?>1<?php }?>" 
							   max="<?php echo $TPL_V2["rt_ea"]?>" />
						<select name="chk_ea[]" style="display:none;">
							<option value="<?php echo $TPL_V2["rt_ea"]?>" selected><?php echo $TPL_V2["rt_ea"]?></option>
						</select>
<?php }else{?>
						-
						<select name="chk_ea[]" class="hide"><option></option></select>
<?php }?>
				</td>
				<td class="cell">
					<?php echo $TPL_V2["mstep"]?>

				</td>
			</tr>
<?php }}?>
			</tbody>
			</table>

			<div style="height:15px"></div>
		</div>
<?php }}?>


		<div>● 사유 선택</div>
		<select name="reason">
<?php if($TPL_reasonLoop_1){foreach($TPL_VAR["reasonLoop"] as $TPL_V1){?>
			<option value="<?php echo $TPL_V1["codecd"]?>" npay_duty="<?php echo $TPL_V1["duty"]?>"><?php echo $TPL_V1["reason"]?></option>
<?php }}?>
		</select>
		<span class="reason_ship_duty_area blue"><?php if($_GET["mode"]=='exchange'){?>교환<?php }else{?>반품<?php }?>배송비 : 
			<span class="reason_ship_duty reason_seller hide">판매자 부담</span>
			<span class="reason_ship_duty reason_buyer hide">구매자 부담</span>
		</span>
		<input type="hidden" name="reason_desc" value="">

<?php if(!$TPL_VAR["npay_use"]||$TPL_VAR["orders"]["pg"]!="npay"){?>
		<div style="height:15px"></div>

		<div>● 상세 사유</div>
		<div><textarea name="reason_detail" style="width:100%;" rows="2"></textarea>
		</div>
<?php }?>

		<div style="height:15px"></div>

<?php if(!$TPL_VAR["npay_use"]||$TPL_VAR["orders"]["pg"]!="npay"){?>
		<div>● 연락처</div>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table_style">
		<thead>
		<tr>
			<th width="30%">구매자</th>
			<th width="35%">휴대폰</th>
			<th width="35%">연락처</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td class="cell"><?php echo $TPL_VAR["orders"]["order_user_name"]?></td>
			<td class="cell">
			<select name="cellphone[]">
<?php if(is_array($TPL_R1=code_load('cellPhone'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["orders"]["order_cellphone"][ 0]==$TPL_V1["codecd"]){?>
			<option value="<?php echo $TPL_V1["codecd"]?>" selected><?php echo $TPL_V1["value"]?></option>
<?php }else{?>
			<option value="<?php echo $TPL_V1["codecd"]?>"><?php echo $TPL_V1["value"]?></option>
<?php }?>
<?php }}?>
			</select>
			<input type="text" name="cellphone[]" size="6" class="line" value="<?php echo $TPL_VAR["orders"]["order_cellphone"][ 1]?>" />
			<input type="text" name="cellphone[]" size="6" class="line" value="<?php echo $TPL_VAR["orders"]["order_cellphone"][ 2]?>" />
			</td>
			<td class="cell">
			<select name="phone[]">
<?php if(is_array($TPL_R1=code_load('locationPhone'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["orders"]["order_phone"][ 0]==$TPL_V1["codecd"]){?>
			<option value="<?php echo $TPL_V1["codecd"]?>" selected><?php echo $TPL_V1["value"]?> <?php echo $TPL_V1["codecd"]?></option>
<?php }else{?>
			<option value="<?php echo $TPL_V1["codecd"]?>"><?php echo $TPL_V1["value"]?> <?php echo $TPL_V1["codecd"]?></option>
<?php }?>
<?php }}?>
			</select>
			<input type="text" name="phone[]" size="6" class="line" value="<?php echo $TPL_VAR["orders"]["order_phone"][ 1]?>" />
			<input type="text" name="phone[]" size="6" class="line" value="<?php echo $TPL_VAR["orders"]["order_phone"][ 2]?>" />
			</td>
		</tr>
		</tbody>
		</table>
		<div style="height:15px"></div>
<?php }?>

		<div style="padding-bottom:3px;">● 반품 방법</div>
		<div style="padding-bottom:3px;" class="fx12">
			<label><input type="radio" name="return_method" value="user" checked="checked" /> 구매자가 직접 물품을 반송</label>
			<span class="return_shipping_group_address"></span>
		</div>
	
<?php if(!$TPL_VAR["npay_use"]||$TPL_VAR["orders"]["pg"]!="npay"){?>
		<div>
			<table widht="100%">
				<tr>
					<td width="420">
					<label><input type="radio" name="return_method" value="shop" /> 쇼핑몰 반품 택배를 통해 물품을 반송합니다.</label>
					<input type="text" name="return_recipient_zipcode[]" value="<?php echo $TPL_VAR["orders"]["recipient_new_zipcode"]?>" size="7" />
					<span class="btn small"><button type="button" onclick="openDialogZipcode('return_recipient_');" >주소찾기</button></span>
					<input type="hidden" name="return_recipient_address_type" value=""  />
					</td>
					<td width="60">(도로명)</td>
					<td><input type="text" name="return_recipient_address_street" value="<?php echo $TPL_VAR["orders"]["recipient_address_street"]?>" size="40" class="line" /></td>
				</tr>
				<tr>
					<td></td>
					<td>(지번)</td>
					<td><input type="text" name="return_recipient_address" value="<?php echo $TPL_VAR["orders"]["recipient_address"]?>" size="40" class="line" /></td>
				</tr>
				<tr>
					<td></td>
					<td>(공통상세)</td>
					<td><input type="text" name="return_recipient_address_detail" value="<?php echo $TPL_VAR["orders"]["recipient_address_detail"]?>" size="40" class="line" /></td>
				</tr>
			</table>
		</div>
<?php }?>

<?php if((!$TPL_VAR["npay_use"]||$TPL_VAR["orders"]["pg"]!='npay')&&$_GET["mode"]!='exchange'&&$TPL_VAR["orders"]["show_refund_method"]=='Y'){?>
		<div style="height:15px"></div>
		<div>● 환불 방법</div>
		<div>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table_style">
		<thead>
		<tr>
			<th>은행</th>
			<th>예금주</th>
			<th>계좌번호</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td class="cell">
			<select name="bank">
<?php if(is_array($TPL_R1=code_load('bankCode'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<option value='<?php echo $TPL_V1["codecd"]?>'><?php echo $TPL_V1["value"]?></option>
<?php }}?>
			</select>
			</td>
			<td class="cell">
			<input type="text" name="depositor" size="10" class="line" />
			</td>
			<td class="cell">
			<input type="text" name="account[]" size="10" class="line onlynumber" />
			<input type="text" name="account[]" size="20" class="line onlynumber" />
			<input type="text" name="account[]" size="20" class="line onlynumber" />
			</td>
		</tr>
		</tbody>
		</table>
			<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
<?php if(in_array($TPL_VAR["orders"]["payment"],array("bank","virtual","escrow_virtual"))){?>
			<div class="mt5">
				- 환불 금액을 입력할 환불 계좌 정보입니다. 결제 수단이 무통장, 가상 계좌인 경우 결제 금액은 관리자가 수동으로 입금해주세요.
			</div>
<?php }?>

		</div>
<?php }?>

		<div class="shipping_refund_area hide mt10">
			<div>● 배송비 결제방법</div>
			<div class="shipping_refund mt5 pdb5">
				<div>
					<select name="refund_ship_type" id="refund_ship_type" onchange="refund_ship_type_chg();">
						<option value="">선택</option>
<?php if($_GET["mode"]!='exchange'){?>
						<option value="M">환불금액에서 차감</option>
<?php }?>
						<option value="A">직접 송금</option>
						<option value="D">택배상자 동봉</option>
					</select>&nbsp;
					<span class="pdl10 blue"><?php if($_GET["mode"]=='exchange'){?>교환<?php }else{?>반품<?php }?>배송비 : <span id="refund_ship_cost"><?php echo get_currency_price( 0, 2)?></span></span>
					<span class="refund_ship_minus hide">(<?php if($_GET["mode"]=='exchange'){?>교환<?php }else{?>반품<?php }?>배송비를 제외한 금액을 환불합니다.)</span>
				</div>
				<div class="refund_ship_account hide mt5">
					<table class="list_table_style" width="100%" border="0" cellpadding="0" cellspacing="0">
					<colgroup>
						<col width="20%" /><col width="30%" /><col width="20%" /><col />
					</colgroup>
					<tbody>
					<tr>
						<td scope="row" height="30">입금은행/입금계좌</th>
						<td>
							<select name="shipping_price_bank_account">
								<option value="">입금은행</option>
<?php if($TPL_bankReturn_1){foreach($TPL_VAR["bankReturn"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["bank"]["value"]?> <?php echo $TPL_V1["accountReturn"]?> <?php echo $TPL_V1["bankUserReturn"]?>"><?php echo $TPL_V1["bank"]["value"]?> <?php echo $TPL_V1["accountReturn"]?> <?php echo $TPL_V1["bankUserReturn"]?></option>
<?php }}?>
							</select>
						</td>
						<td scope="row">입금자명</th>
						<td><input type="text" name="shipping_price_depositor" value="" title="" /></td>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>

		<div style="height:15px"></div>
		<div>● 배송비 안내</div>
		<div class="mt5">
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=='npay'){?>
		네이버페이 반품 건은 네이버페이 어드민 페이지에서 수거완료를 확인하세요.
<?php }else{?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table_style">
		<thead>
		<tr>
			<th width="80">구분 </th>
			<th>구매자 부담 = 반품 배송비+최초 배송비</th>
			<th>판매자 부담 = 반품 배송비 + 최초 배송비</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td align="center" height="40">반품->환불</td>
			<td style="padding-left:5px;">반품 시 배송비는 반품의 원인을 제공한 자가 부담합니다.<br/>구매자의 변심으로 반품을 원할 경우에는 구매자가 배송비를 지불</td>
			<td style="padding-left:5px;">반품 시 배송비는 반품의 원인을 제공한 자가 부담합니다.<br/>상품 하자나 제품 불일치로 인한 반품의 경우에는 판매자가 배송비를 지불</td>
		</tr>
		<tr>
			<td align="center" height="40">반품->교환</td>
			<td style="padding-left:5px;">상품 교환 시 배송비는 교환의 원인을 제공한 자가 부담합니다.<br/>구매자의 변심으로 교환을 원할 경우에는 구매자가 배송비를 지불</td>
			<td style="padding-left:5px;">상품 교환 시 배송비는 교환의 원인을 제공한 자가 부담합니다.<br/>상품 하자나 제품 불일치로 인한 교환의 경우에는 판매자가 배송비를 지불</td>
		</tr>
		</tbody>
		</table>
<?php }?>
		</div>

		<div style="height:15px"></div>

		<div class="center"><span class="btn large black"><input type="submit" value="작성완료" /></span></div>

		<div style="height:40px"></div>

		</form>
	</div>
</div>