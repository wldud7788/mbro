<?php /* Template_ 2.2.6 2022/05/17 12:36:41 /www/music_brother_firstmall_kr/admin/skin/default/order/settle_cart.html 000058718 */  $this->include_("snsLikeButton","showNaverMileageButton");
$TPL_gloop_1=empty($TPL_VAR["gloop"])||!is_array($TPL_VAR["gloop"])?0:count($TPL_VAR["gloop"]);
$TPL_shipping_group_list_1=empty($TPL_VAR["shipping_group_list"])||!is_array($TPL_VAR["shipping_group_list"])?0:count($TPL_VAR["shipping_group_list"]);
$TPL_lately_delivery_address_1=empty($TPL_VAR["lately_delivery_address"])||!is_array($TPL_VAR["lately_delivery_address"])?0:count($TPL_VAR["lately_delivery_address"]);
$TPL_ship_gl_arr_1=empty($TPL_VAR["ship_gl_arr"])||!is_array($TPL_VAR["ship_gl_arr"])?0:count($TPL_VAR["ship_gl_arr"]);
$TPL_ship_message_1=empty($TPL_VAR["ship_message"])||!is_array($TPL_VAR["ship_message"])?0:count($TPL_VAR["ship_message"]);?>
<style type="text/css">
.rborder { border-right:1px solid #ddd;
div.settle_title { margin:20px 0 5px 0; }
div.settle_title_line {width:100%;height:2px;background-color:#545454;}
#total_goods_price	{font-size:12px;color:#fff;}
.total_result_price	{font-size:20px;font-family:tahoma;font-weight:bold;color:#fff;}
</style>
<script type="text/javascript">
var multiShippingItemNoCnt	= 0;

$(document).ready(function(){

<?php if(!$TPL_VAR["is_goods"]){?>
	$(".goods_delivery_info").hide();
<?php }else{?>
	$(".goods_delivery_info").show();
	check_shipping_method();
<?php }?>

<?php if($TPL_VAR["ordertype"]=='person'){?>
	//$("div.translucent_disable_lay").show();
<?php }?>

<?php if($TPL_VAR["ordertype"]=='admin'&&$TPL_VAR["goodscancellation"]){?>
	// 청약철회 오픈
	$("div.cancellation-lay").show();
<?php }else{?>
	$("div.cancellation-lay").hide();
<?php }?>

<?php if($TPL_VAR["gift_cnt"]> 0){?>
	get_gift_data();
<?php }?>

	// 입점사 갯수 체크 :: 2015-10-08 lwh
	var provider_cnt = "<?php echo $TPL_VAR["provider_cnt"]?>";
	if(provider_cnt == '1'){
		$("#enuri_div").show();
		$(".enuri_div_none").hide();
	}else{
		$("#enuri_div").hide();
		$(".enuri_div_none").show();
	}

	// 쿠폰사용 다이얼로그
	$("button#coupon_apply").bind("click",function(){
		sametime_coupon_dialog();
	});

	// 쿠폰사용가능한 상품 조회하기 (적용대상조회)
	$('.ordercoupongoodsreviewbtn, .shippingcoupongoodsreviewbtn, .ordersheetcoupongoodsreviewbtn').live("click",function(){
		var arr_class = {
			'goods'			: 'ordercoupongoodsreviewbtn'
			, 'shipping'	: 'shippingcoupongoodsreviewbtn'
			, 'ordersheet'	: 'ordersheetcoupongoodsreviewbtn'
		};
		var mode = "goods";
		for(var tmp_mode in arr_class){
			if($(this).hasClass(arr_class[tmp_mode])){
				mode = tmp_mode;
			}
		}

		var download_seq = $(this).attr("download_seq");
		if(!download_seq) {
			//상품쿠폰을 선택해 주세요!
			var msg = getAlert('os165');
			if(mode=="goods"){
				//상품쿠폰을 선택해 주세요!
				msg = getAlert('os165');
			}else if(mode=="shipping"){
				msg = getAlert('os089');
			}
			openDialogAlert(msg,400,150);
			return false;
		}
		var coupongoodsreviewerurl = '../coupon/coupongoodsreviewer?no='+download_seq+'&download_seq='+download_seq;
		var coupon_name = $(this).attr("coupon_name");
		//쿠폰정보 확인하기
		addFormDialog(coupongoodsreviewerurl, '450', '', getAlert('os172'),'false');
	});

	// 배송지 정보 채우기
	$("#copy_order_info").bind("click",function(){
		$("input[name='recipient_user_name']").val( $("input[name='order_user_name']").val() );

		$("input[name='order_phone[]']").each(function(idx){
			$("input[name='recipient_phone[]']").eq(idx).val( $("input[name='order_phone[]']").eq(idx).val() );
		});

		$("input[name='order_cellphone[]']").each(function(idx){
			$("input[name='recipient_cellphone[]']").eq(idx).val( $("input[name='order_cellphone[]']").eq(idx).val() );
		});

		$("input[name='recipient_email']").val( $("input[name='order_email']").val() );

		order_price_calculate();

		$('.phone_num2').each(function(){
			if	(check_input_value($(this)))
				$(this).show().parent().find('.phone_num1').hide();
		});
	});
	
	// 배송설정 변경시
	function chg_shipping_set(nation){
		alert(nation);
		var mode		= '<?php echo $TPL_VAR["mode"]?>';
		var cart_seq	= '<?php echo $TPL_VAR["cart_seq"]?>';
		var admin_mode	= '<?php echo $TPL_VAR["admin_mode"]?>';
		var cart_table	= '<?php echo $TPL_VAR["cart_table"]?>';
		var grp_seq		= '<?php echo $TPL_VAR["grp_info"]["shipping_group_seq"]?>';
		var set_seq		= '';
		var store_use	= '<?php echo $TPL_VAR["set_info"]["store_use"]?>';
		var direct_store= '<?php echo $TPL_VAR["direct_store"]?>';
		var goods_seq	= '<?php echo $TPL_VAR["goods_info"]["goods_seq"]?>';

		if(!nation){
			set_seq = $("#ship_set_list").val();
			nation = $("#ship_set_list option:selected").attr('nation');
		}

		var params	= [];
		params.push({name:'mode',value:mode});
		params.push({name:'grp_seq',value:grp_seq});
		params.push({name:'nation',value:nation});
		if(set_seq)				params.push({name:'set_seq',value:set_seq});
		if(cart_seq)			params.push({name:'cart_seq',value:cart_seq});
		if(admin_mode)			params.push({name:'admin_mode',value:admin_mode});
		if(cart_table)			params.push({name:'cart_table',value:cart_table});
		if(direct_store=='Y')	params.push({name:'direct_store',value:'Y'});
		if(store_use=='Y')		params.push({name:'store_seq',value:$("#store_sel").val()});
		if(goods_seq)			params.push({name:'goods_seq',value:goods_seq});

		$.ajax({
			'url' : '/goods/shipping_detail_info',
			'data' : params,
			'success' : function(html){
				if(html){
					$("#shipping_detail_lay").html(html);
				}else{
					//배송방법 정보가 누락되었습니다\n새로고침 후 다시 시도해주세요.
					alert(getAlert('os235'));
				}
			}
		});
	}
	
	// 배송 방법 변경 :: 2016-07-30 lwh
	$("button.btn_shipping_modify").on("click",function() {

		var cart_seq	= $(this).attr('cart_seq');
		var prepay_info = $(this).attr('prepay_info');
		var nation		= $(this).attr('nation');
		var hop_date	= $(this).attr('hop_date');
		var goods_seq	= $(this).attr('goods_seq');
		var reserve_txt	= $(this).attr('reserve_txt');
		
		$.ajax({
			'url'	: '/goods/shipping_detail_info',
			'data'	: {'mode':'cart','cart_seq':cart_seq,'prepay_info':prepay_info,'nation':nation,'hop_date':hop_date,'goods_seq':goods_seq,'reserve_txt':reserve_txt,'cart_table':'<?php echo $TPL_VAR["cart_table"]?>','admin_mode':'settle'},
			'type'	: 'get',
			'dataType': 'text',
			'success': function(html) {
				if(html){
					$("div#shipping_detail_lay").html(html);
					//배송방법 안내 및 변경
					openDialog(getAlert('oc040'), "shipping_detail_lay", {"width":500,"height":650});//oc043
				}else{
					//오류가 발생했습니다. 새로고침 후 다시시도해주세요.
					alert(getAlert('oc041'));//oc044
					document.location.reload();
				}
			}
		});
	});

	$(".detailDescriptionLayerBtn").click(function(){
		$('div.detailDescriptionLayer').not($(this).next('div.detailDescriptionLayer')).hide();
		$(this).next('div.detailDescriptionLayer').show();
	});
	$(".detailDescriptionLayerCloseBtn").click(function(){
		$(this).closest('div.detailDescriptionLayer').hide();
	});
	
	// 배송국가 변경시 :: 2016-08-03 lwh
	$("#address_nation").bind('change',function(){
		order_price_calculate(); // 재계산
	});

	// 배송지 간편 선택 :: 2016-08-01 lwh
	$("input[name='chkQuickAddress']").bind('click',function(){
		if($(this).attr('type')=='radio' && !$(this).is(":checked")) return;

		var sel_type = $(this).val();
		var late_idx = $(this).attr('idx');

		if($(this).attr('type')=='checkbox' && val=='copy'){
			if(!$(this).is(":checked")){
				val = 'new';
			}
		}

		switch(sel_type){
			case "often":
			case "lately":
			case "member":
				var data = {'type':$(this).val()};
				if(sel_type=='lately'){
					data['idx'] = late_idx;
				}
				$.ajax({
					'url' : '/order/ajax_get_delivery_address',
					'data' : data,
					'dataType' : 'json',
					'success' : function(res){
						if(res){
							// input values
							if (res.recipient_zipcode != null) {
								$("input[name='recipient_zipcode[]']").each(function(idx){
									$(this).val( res.recipient_zipcode.split('-')[idx] );
								});
							}
							$("input[name='recipient_new_zipcode']").val(res.recipient_new_zipcode);
							if(res.recipient_address_type == "street"){
								$("input[name='recipient_address']").hide();
								$("input[name='recipient_address_street']").show();
							}else{
								$("input[name='recipient_address']").show();
								$("input[name='recipient_address_street']").hide();
							}
							$("input[name='recipient_address_type']").val( res.recipient_address_type );
							$("input[name='recipient_address']").val( res.recipient_address );
							$("input[name='recipient_address_street']").val( res.recipient_address_street );
							$("input[name='recipient_address_detail']").val( res.recipient_address_detail );
							if( res.recipient_address_street && res.recipient_address_street.length ) {
								$("input[name='recipient_address']").hide();
								$("input[name='recipient_address_street']").show();
							}
							$("input[name='recipient_user_name']").val( res.recipient_user_name );
							$("input[name='recipient_email']").val( res.recipient_email );

							if (res.recipient_phone != null) {
								$("input[name='recipient_phone[]']").each(function(idx){
									$(this).val( res.recipient_phone.split('-')[idx] );
								});
							}
							if (res.recipient_cellphone != null) {
								$("input[name='recipient_cellphone[]']").each(function(idx){
									$(this).val( res.recipient_cellphone.split('-')[idx] );
								});
							}
							$("input[name='recipient_zipcode[]']").first().blur();

							// span values
							$(".recipient_user_name").html(res.recipient_user_name);
							$(".recipient_zipcode").html(res.recipient_new_zipcode);
							if(res.recipient_address_type == 'street'){
								$(".recipient_address").html(res.recipient_address_street);
							}else{
								$(".recipient_address").html(res.recipient_address);
							}
							$(".recipient_address_detail").html(res.recipient_address_detail);
							$(".cellphone").html(res.recipient_cellphone);
							$(".phone").html(res.recipient_phone);
							if(res.nation == 'KOREA' || res.international == 'domestic'){
								$(".international_nation").html('대한민국');
								$("#address_nation").val('KOREA').trigger('change');
							}else{
								$(".international_nation").html(res.nation);
								$("#address_nation").val(res.nation).trigger('change');
							}

						} // end if
					}
				});
				$(".delivery_member").show();
				$(".delivery_input").hide();
			break;
			case "new":
				$("input[name='recipient_new_zipcode']").val('');
				$("input[name='recipient_address_type']").val('');
				$("input[name='recipient_address']").val('');
				$("input[name='recipient_address_street']").val('');
				$("input[name='recipient_address_detail']").val('');
				$("input[name='recipient_user_name']").val('');
				$("input[name='order_phone[]']").each(function(idx){
					$("input[name='recipient_phone[]']").eq(idx).val("");
				});
				$("input[name='order_cellphone[]']").each(function(idx){
					$("input[name='recipient_cellphone[]']").eq(idx).val("");
				});
				$("input[name='recipient_email']").val('');
				$(".delivery_input").show();
				$(".delivery_member").hide();
<?php if($_GET["nation"]!='KOREA'){?>
				$(".domestic").show();
				$(".international").hide();
<?php }else{?>
				$(".domestic").hide();
				$(".international").show();
<?php }?>
				$("#address_nation").val('KOREA').trigger('change');
			break;
		}
	}).first().attr('checked',true).trigger('click').trigger('change');

	/**
	 * 배송메시지
	*/
	$(".ship_message .click").bind("click", function(){
		if($(this).closest(".ship_message").find(".add_message").css("display")=='none'){
			$(".add_message").hide();
			$(this).closest(".ship_message").find(".add_message").show();
		}else{
			$(".add_message").hide();
			$(this).closest(".ship_message").find(".add_message").hide();
		}
	});
	$(".ship_message").bind("blur", function(){
		$(".add_message").hide();
	});
	$(".add_message li").bind("click", function(){
		var sel_message = $(this).html();
		$(this).closest(".ship_message").find(".ship_message_txt").val(sel_message).trigger('change');
		$(".add_message").hide();
	});

	// 배송메세지 카운터
	$(".ship_message_txt").bind("keyup change", function(){
		var obj			= $(this).closest(".ship-lay");
		var message		= obj.find(".ship_message_txt").val();
		var message_cnt	= message.length;
		if(message_cnt <= 300){
			obj.find(".cnt_txt").html(message_cnt);
		}else{
			//배송메세지는 300자 이하까지만 가능합니다.
			alert(getAlert('os151'));
			obj.find(".cnt_txt").html(300);
			obj.find(".ship_message_txt").val(message.substr(0,300));
		}
	});

	// 결제금액 계산
	$("button#coupon_order").bind("click",function(){
		$("select.coupon_select").each(function(){
			var str				= $(this).attr('id');
			var arr				= str.split('_');
			var cart_seq		= arr[1];
			var cart_option_seq = arr[2];
			$("input[name='coupon_download["+cart_seq+"]["+cart_option_seq+"]']").val($(this).find("option:selected").val());
		});

		$("select.shipping_coupon_select").each(function(){
			var str				= $(this).attr('id');
			
			str = str.replace('shippingcoupon_','');
			$("input[name='shippingcoupon_download["+str+"]']").val($(this).find("option:selected").val());
		});

		$("select.ordersheet_coupon_select").each(function(){
			$("input[name='ordersheet_coupon_download_seq").val($(this).find("option:selected").val());
		});
		order_price_calculate();
		closeDialog("coupon_apply_dialog");
	});


	// ### 기본 초기 설정 :: START
	//set_pay_button();
<?php if($TPL_VAR["shipping_policy"]["count"]&&array_sum($TPL_VAR["shipping_policy"]["count"])> 1){?>
	$("tr.shipping_tr").show();
<?php }else{?>
	$("tr.shipping_tr").hide();
<?php }?>
<?php if($TPL_VAR["cart_promotioncode"]){?>
		getPromotionckloding('<?php echo $TPL_VAR["cart_promotioncode"]?>');
<?php }?>
<?php if(!$TPL_VAR["is_goods"]){?>
	$(".goods_delivery_info").hide();
<?php }?>
<?php if($TPL_VAR["members"]){?>
	$(".delivery_member").show();
	$(".order_member").show();
	$(".delivery_input").hide();
	$(".order_input").hide();
<?php }else{?>
	$(".delivery_member").hide();
	$(".order_member").hide();
	$(".delivery_input").show();
	$(".international").hide();
	$(".order_input").show();
<?php }?>

	order_price_calculate();
	// ### 기본 초기 설정 :: END

});

function open_sale_price_layer(obj){
	$(obj).closest('div').find(".sale_price_layer").show();
}
function close_sale_price_layer(obj){
	$(obj).closest('div').find(".sale_price_layer").hide();
}

function translucent_disable(){

	var trans_height1 = $(".tb_translucent_disable").eq(0).height();
	var trans_height2 = $(".tb_translucent_disable").eq(1).height();

	trans_height1 = trans_height1 + 30;
	trans_height2 = trans_height2 + 15;

	$(".translucent_disable_back").eq(0).height(trans_height1);
	$(".translucent_disable_title").eq(0).attr("style","top:"+eval((trans_height1/2)-10)+"px");

	$(".translucent_disable_back").eq(1).height(trans_height2);
	$(".translucent_disable_title").eq(0).attr("style","top:"+eval((trans_height2/2)-10)+"px");

<?php if($TPL_VAR["ordertype"]=='person'){?>
		$("div.translucent_disable_lay").show();
<?php }?>

}
// 쿠폰적용
function set_coupon_order(obj){
	if($(obj).attr('id')=='coupon_cancel'){
		$("select.coupon_select").val('').change();
	}

	$("select.coupon_select").each(function(){
		var str = $(this).attr('id');
		var arr = str.split('_');
		var cart_seq = arr[1];
		var cart_option_seq = arr[2];
		$("input[name='coupon_download["+cart_seq+"]["+cart_option_seq+"]']").val($(this).find("option:selected").val());
	});

	$("select.shipping_coupon_select").each(function(){
		var shipping_coupon_sale	= $(this).find("option:selected").attr("sale");
		var download_seq			= $(this).find("option:selected").val();

		$("#download_seq").val(download_seq);
		$("#shipping_coupon_sale").val(shipping_coupon_sale);
	});
	order_price_calculate();

	closeDialog("coupon_apply_dialog");
}

// 사은품 정보를 가져온다.
function get_gift_data(){

	var giftHTML	= '';
<?php if($TPL_VAR["gift_cnt"]> 0){?>
	giftHTML	+= '<div style="height:30px"></div>';
	giftHTML	+= '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
	giftHTML	+= '<tr><td><img src="/admin/skin/default/images/common/order_stit_gift.gif" /></td></tr>';
	giftHTML	+= '<tr><td height="10"></td></tr>';
	giftHTML	+= '</table>';
	giftHTML	+= '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
	giftHTML	+= '<col /><col width="280" />';
	giftHTML	+= '<tr><td height="1" bgcolor="dddddd" colspan="2"></td></tr>';
	giftHTML	+= '<tr>';
	giftHTML	+= '<td height="30" colspan="2">';
	giftHTML	+= '&nbsp;&nbsp;<label><input type="radio" name="gift_use" value="Y" checked/> 사은품을 받겠습니다.</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="gift_use" value="N"/> 사은품을 받지 않겠습니다.</label>';
	giftHTML	+= '</td>';
	giftHTML	+= '</tr>';
	giftHTML	+= '<tr><td height="1" bgcolor="dddddd" colspan="2"></td></tr>';
	giftHTML	+= '</table>';
	giftHTML	+= '<div style="height:10px"></div>';
<?php if($TPL_gloop_1){foreach($TPL_VAR["gloop"] as $TPL_V1){?>
	giftHTML	+= '<input type="hidden" name="gifts[]" value="<?php echo $TPL_V1["gift_seq"]?>"/>';
<?php if($TPL_V1["gift_rule"]=='lot'){?>
	giftHTML	+= '<input type="hidden" name="lot_gifts[]" value="<?php echo $TPL_V1["gift_seq"]?>"/>';
<?php }?>
	giftHTML	+= '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="giftTable">';
	giftHTML	+= '<tr><td colspan="3"><b><?php echo $TPL_V1["title"]?></b></td></tr>';
	giftHTML	+= '<tr><td colspan="3" height="5"></td></tr>';
<?php if($TPL_V1["gift_contents"]){?>
	giftHTML	+= '<tr><td colspan="3"><?php echo addslashes($TPL_V1["gift_contents"])?></td></tr>';
	giftHTML	+= '<tr><td colspan="3" height="5"></td></tr>';
<?php }?>
	giftHTML	+= '<tr>';
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_I2!= 0&&($TPL_I2% 3)== 0){?>
	giftHTML	+= '</tr><tr><td height="20"></td></tr><tr>';
<?php }?>
	giftHTML	+= '<td valign="top">';
	giftHTML	+= '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
	giftHTML	+= '<tr><td><label>';
<?php if($TPL_V1["gift_rule"]!='lot'){?>
	giftHTML	+= '<input type="<?php if($TPL_V1["ea"]> 1){?>checkbox<?php }else{?>radio<?php }?>" name="gift_<?php echo $TPL_V1["gift_seq"]?>[]" value="<?php echo $TPL_V2?>" <?php if($TPL_V1["ea"]> 1){?> onclick="limit_chk(\'<?php echo $TPL_V1["gift_seq"]?>\', this);"<?php }?> <?php if($TPL_I2== 0){?>checked<?php }?> /> <?php }?><?php echo get_gift_name($TPL_V2)?></label></td></tr>';
<?php if(get_gift_image($TPL_V2,'list1')){?>
	giftHTML	+= '<tr><td><img src="<?php echo get_gift_image($TPL_V2,'list1')?>"></td></tr>';
<?php }?>
	giftHTML	+= '</table>';
	giftHTML	+= '</td>';
<?php }}?>
	giftHTML	+= '</tr>';
	giftHTML	+= '<tr><td colspan="3" height="10"><input type="hidden" name="gift_<?php echo $TPL_V1["gift_seq"]?>_limit" value="<?php echo $TPL_V1["ea"]?>"></td></tr>';
	giftHTML	+= '<tr><td colspan="3" height="1" bgcolor="#dddddd"></td></tr>';
	giftHTML	+= '</table>';
	giftHTML	+= '<div style="height:10px"></div>';
<?php }}?>
<?php }?>

	$("div#gift_list_lay").html(giftHTML);
	if	(giftHTML)	$("div#gift_list_lay").show();
	else			$("div#gift_list_lay").hide();
}

// 배송지 수정 - input box show :: 2017-07-27 lkh
function address_modify(type){
	var international = $("#address_nation").val();
	if(!type) type = 'delivery';
	$("." + type + "_member").hide();
	$("." + type + "_input").show();

	// 추가 연락처 체크 :: 2017-05-16 lwh
	add_phone($("#btn_" + type + "_add_phone"),'check');

	if(type == 'delivery'){
		set_shipping('input');
		$("#chkQuickAddress_new").attr("checked",true);
	}
}

setDefaultText();
translucent_disable();
</script>


<!--배송방법변경 레이어-->
<div id="shipping_detail_lay2" style="display:none;"></div>

<div class="admin_cart">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table_style">
	<caption>주문상품</caption>
	<colgroup>
		<col /><col style="width:8%" /><col style="width:10%" /><col style="width:10%" />
		<col style="width:10%" /><col style="width:16%" />
	</colgroup>
	<thead>
		<tr>
			<th scope="col">주문상품</th>
			<th scope="col">수량</th>
			<th scope="col">상품금액</th>
			<th scope="col">할인</th>
			<th scope="col">할인금액</th>
			<!--<th scope="col" class="hide">적립</th>-->
			<th scope="col">배송비</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_VAR["shipping_group_list"]){?>
<?php if($TPL_shipping_group_list_1){foreach($TPL_VAR["shipping_group_list"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
		<tr>
			<td class="relative">
				<dl class="order_thumb_wrap">
					<dt>
						<a href="/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>" target="_blank"><img src="<?php echo $TPL_V2["image"]?>" class="order_thumb" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif'" width="60" alt="<?php echo $TPL_V2["goods_name"]?>" /></a>
					</dt>
					<dd>
						<input type="hidden" name="coupon_download[<?php echo $TPL_V2["cart_seq"]?>][<?php echo $TPL_V2["cart_option_seq"]?>]" value="" />
						<a href="/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>" title="<?php echo $TPL_V2["goods_name"]?>" class="order_name" target="_blank"><?php echo $TPL_V2["goods_name"]?></a>
<?php if($TPL_V2["adult_goods"]=='Y'){?>
						<img src="/admin/skin/default/images/common/auth_img.png" height="17" align="absmiddle" alt="성인" />
<?php }?>
<?php if($TPL_V2["option_international_shipping_status"]=='y'){?>
							<img src="/admin/skin/default/images/common/icon/plane_on.png" height="14" align="absmiddle" alt="해외배송상품" />
<?php }?>
						<div>
<?php if($TPL_V2["cancel_type"]=='1'){?>
							<span class="btn_move icon mt3">청약철회불가</span>
<?php }?>
<?php if($TPL_V2["tax"]=='exempt'){?>
							<span class="btn_move icon mt3">비과세</span>
<?php }?>
						</div>
<?php if($TPL_V2["option1"]!=null){?>
						<div class="order_option mt3">
							<span class="btn_gray icon">옵션</span>
<?php if($TPL_V2["title1"]){?>
							<?php echo $TPL_V2["title1"]?>:<?php }?><?php echo $TPL_V2["option1"]?><?php if($TPL_V2["option2"]){?>, <?php if($TPL_V2["title2"]){?>
							<?php echo $TPL_V2["title2"]?>:<?php }?><?php echo $TPL_V2["option2"]?><?php }?><?php if($TPL_V2["option3"]){?>, <?php if($TPL_V2["title3"]){?>
							<?php echo $TPL_V2["title3"]?>:<?php }?><?php echo $TPL_V2["option3"]?><?php }?><?php if($TPL_V2["option4"]){?>, <?php if($TPL_V2["title4"]){?>
							<?php echo $TPL_V2["title4"]?>:<?php }?><?php echo $TPL_V2["option4"]?><?php }?><?php if($TPL_V2["option5"]){?>, <?php if($TPL_V2["title5"]){?>
							<?php echo $TPL_V2["title5"]?>:<?php }?><?php echo $TPL_V2["option5"]?><?php }?>
						</div>
<?php }?>
<?php if($TPL_V2["eventEnd"]){?>
						<div class="soloEventTd2<?php echo $TPL_V2["cart_option_seq"]?> eventEnd mt3">
							<img src="/admin/skin/default/images/common/icon_clock.gif" alt="clock" />
							<span class="time_count">
								<span id="soloday2<?php echo $TPL_V2["cart_option_seq"]?>">0</span>일
								<span id="solohour2<?php echo $TPL_V2["cart_option_seq"]?>">00</span>:<span id="solomin2<?php echo $TPL_V2["cart_option_seq"]?>">00</span>:<span id="solosecond2<?php echo $TPL_V2["cart_option_seq"]?>">00</span>
							</span>
						</div>
						<script type="text/javascript">
							$(function() {
								timeInterval<?php echo $TPL_V2["cart_option_seq"]?> = setInterval(function(){
									var time<?php echo $TPL_V2["cart_option_seq"]?> = showClockTime('text', '<?php echo $TPL_V2["eventEnd"]["year"]?>', '<?php echo $TPL_V2["eventEnd"]["month"]?>', '<?php echo $TPL_V2["eventEnd"]["day"]?>', '<?php echo $TPL_V2["eventEnd"]["hour"]?>', '<?php echo $TPL_V2["eventEnd"]["min"]?>', '<?php echo $TPL_V2["eventEnd"]["second"]?>', 'soloday2<?php echo $TPL_V2["cart_option_seq"]?>', 'solohour2<?php echo $TPL_V2["cart_option_seq"]?>', 'solomin2<?php echo $TPL_V2["cart_option_seq"]?>', 'solosecond2<?php echo $TPL_V2["cart_option_seq"]?>', '<?php echo $TPL_V2["cart_option_seq"]?>');
									if(time<?php echo $TPL_V2["cart_option_seq"]?> == 0){
										clearInterval(timeInterval<?php echo $TPL_V2["cart_option_seq"]?>);
										//단독 이벤트 종료
										$(".soloEventTd2<?php echo $TPL_V2["cart_option_seq"]?>").html(getAlert('oc038'));
									}
								},1000);
							});
						</script>
<?php }?>
<?php if($TPL_V2["cart_inputs"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["cart_inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["input_value"]){?>
								<div class="order_option mt3">
									<span class="btn_gray icon">옵션</span>
<?php if($TPL_V3["type"]=='file'){?>
<?php if($TPL_V3["input_title"]){?><?php echo $TPL_V3["input_title"]?>:<?php }?> <a href="/mypage_process/filedown?file=<?php echo $TPL_V3["input_value"]?>" target="actionFrame"><img src="/mypage_process/filedown?file=<?php echo $TPL_V3["input_value"]?>" width="13" height="13" title="크게 보기" align="absmiddle" /> <span class="desc"><?php echo $TPL_V3["input_value"]?></span></a>
<?php }else{?>
<?php if($TPL_V3["input_title"]){?><?php echo $TPL_V3["input_title"]?>:<?php }?><?php echo $TPL_V3["input_value"]?>

<?php }?>
								</div>
<?php }?>
<?php }}?>
<?php }?>
<?php if($TPL_VAR["cfg"]["order"]["fblike_ordertype"]&&$TPL_VAR["fblikesale"]){?>
						<div class="fblikelay mt5">
							<?php echo snsLikeButton($TPL_V2["goods_seq"],'button_count')?>

						</div>
<?php }?>
					</dd>
				</dl>
				<!-- 배송불가 -->
				<dl class="ship_no <?php if($TPL_V1["ship_possible"]=='Y'){?>hide<?php }?>">
<?php if($TPL_V1["ship_possible"]=='N'){?>
					<dt>선택하신 국가로 배송이 불가한 상품입니다.</dt>
<?php }elseif($TPL_V1["ship_possible"]=='H'){?>
					<dt>선택하신 국가로 희망배송이 불가한 상품입니다.</dt>
<?php }?>
					<dd></dd>
				</dl>
				<!-- //배송불가 -->
			</td>
			<td>
				<div><?php echo number_format($TPL_V2["ea"])?></div>
			</td>
			<td class="right"><?php echo get_currency_price($TPL_V2["price"]*$TPL_V2["ea"], 3)?></td>
			<td class="right">
				<div id="cart_option_sale_total_<?php echo $TPL_V2["cart_option_seq"]?>_2"> 
<?php if($TPL_V2["sales"]["total_sale_price"]> 0){?>
					<?php echo get_currency_price($TPL_V2["sales"]["total_sale_price"], 3)?>

<?php }else{?>
					-
<?php }?>
				</div>
				<!-- 할인내역 LAYER :: START -->
				<div id="cart_option_sale_detail_<?php echo $TPL_V2["cart_option_seq"]?>" <?php if($TPL_V2["sales"]["total_sale_price"]> 0){?><?php }else{?>class="hide"<?php }?>>
					<button type="button" class="mt3 btn_move small detailDescriptionLayerBtn">내역</button>
					<div class="detailDescriptionLayer hide" style="width:280px;">
						<div class="layer_wrap">
							<h1>할인내역</h1>
							<div class="layer_inner">
								<table class="tbl_col" width="100%" border="0" cellpadding="0" cellspacing="0">
									<caption>할인내역</caption>
									<colgroup>
										<col style="width:50%" /><col />
									</colgroup>
									<thead>
										<tr>
											<th scope="col">항목</th>
											<th scope="col">할인금액</th>
										</tr>
									</thead>
									<tbody>
<?php if(is_array($TPL_R3=$TPL_V2["sales"]["title_list"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
										<tr id="cart_option_<?php echo $TPL_K3?>_saletr_<?php echo $TPL_V2["cart_option_seq"]?>" <?php if($TPL_V2["sales"]["sale_list"][$TPL_K3]> 0){?><?php }else{?>class="hide"<?php }?>>
											<th scope="row"><?php echo $TPL_V2["sales"]["title_list"][$TPL_K3]?></th>
											<td>
												<?php echo get_currency_price($TPL_V2["sales"]["sale_list"][$TPL_K3], 3,'','<span id="cart_option_'.$TPL_K3.'_saleprice_'.$TPL_V2["cart_option_seq"].'">_str_price_</span>')?>

											</td>
										</tr>
<?php }}?>
									</tbody>
								</table>
							</div>
							<a href="javascript:;" class="detailDescriptionLayerCloseBtn"></a>
						</div>
					</div>
				</div>
				<!-- 할인내역 LAYER :: END -->
			</td>
			<td class="right bold">
				<?php echo get_currency_price($TPL_V2["sales"]["result_price"], 3,'','<span class="cart_option_price_'.$TPL_V2["cart_option_seq"].'">_str_price_</span>')?>

			</td>
			<!--<td class="hide">
				<table align="center" border="0">
					<tbody>
						<tr>
							<td><img src="/admin/skin/default/images/common/icon/icon_ord_emn.gif" title="캐시" /></td>
							<td class="right"><?php echo number_format($TPL_V2["reserve"], 3,'','<span id="option_reserve_'.$TPL_V2["cart_option_seq"].'">_str_price_</span>')?></td>
						</tr>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
						<tr>
							<td><img src="/admin/skin/default/images/common/icon/icon_ord_point.gif" title="포인트" /></td>
							<td class="right"><span id="option_point_<?php echo $TPL_V1["cart_option_seq"]?>"><?php echo get_currency_price($TPL_V2["point"])?></span>P</td>
						</tr>
<?php }?>
					</tbody>
				</table>
			</td>-->
<?php if($TPL_I2== 0){?>
			<td class="left" rowspan="<?php echo $TPL_V1["row_cnt"]?>">
				<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td>
						<div class="blue"><?php echo $TPL_V1["shipper_name"]?></div>
						<div><?php echo $TPL_V1["cfg"]["baserule"]["shipping_set_name"]?></div>
<?php if($TPL_V1["grp_shipping_price"]> 0){?>
						<div><?php echo get_currency_price($TPL_V1["grp_shipping_price"], 3)?></div>
<?php }else{?>
<?php if($TPL_V1["ship_possible"]=='Y'){?>
						<div>무료</div>
<?php }else{?>
						<div class="red">배송불가</div>
<?php }?>
<?php }?>
					</td>
					<td>
						<!-- 배송방법 변경 :: START -->
						<div class="order_change">
							<button type="button" class="btn_shipping_modify btn_move small" cart_seq="<?php echo $TPL_V2["cart_seq"]?>" prepay_info="<?php echo $TPL_V1["shipping_prepay_info"]?>" nation="<?php echo $TPL_V1["cfg"]["baserule"]["delivery_nation"]?>" goods_seq="<?php echo $TPL_V2["goods_seq"]?>" hop_date="<?php echo $TPL_V1["shipping_hop_date"]?>" reserve_txt="<?php echo $TPL_V1["reserve_sdate"]?><?php echo $TPL_V1["reserve_txt"]?>">변경</button>
						</div>
						<!-- 배송방법 변경 :: END -->
					</td>
				</tr>
				</table>
<?php if($TPL_V1["cfg"]["baserule"]["shipping_set_code"]=='direct_store'){?>
				<div class="ship_info">수령매장 : <?php echo $TPL_V1["store_info"]["shipping_store_name"]?></div>
<?php }else{?>
<?php if($TPL_V1["grp_shipping_price"]> 0){?>
<?php if($TPL_V1["shipping_prepay_info"]=='delivery'){?>
				<div class="ship_info">(주문시 결제)</div>
<?php }else{?>
				<div class="ship_info">(착불)</div>
<?php }?>
<?php }?>
<?php }?>
<?php if($TPL_V1["shipping_hop_date"]){?>
				<div class="ship_info">희망배송일 : <?php echo $TPL_V1["shipping_hop_date"]?></div>
<?php }elseif($TPL_V1["reserve_sdate"]){?>
				<div class="ship_info">예약배송일 : <?php echo $TPL_V1["reserve_sdate"]?></div>
<?php }?>
				<input type="hidden" name="shippingcoupon_download[<?php echo $TPL_V2["shipping_group"]?>]" value="" />
			</td>
<?php }?>
		</tr>
<?php if(is_array($TPL_R3=$TPL_V2["cart_suboptions"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
		<tr class="sub_bg">
			<td>
				<dl class="order_thumb_wrap">
					<dt>
						<img src="/admin/skin/default/images/common/icon_add_arrow.gif" class="pdr15" alt="" />
					</dt>
					<dd class="order_option">
						<span class="btn_gray icon">추가</span>
<?php if($TPL_V3["suboption"]){?>
<?php if($TPL_V3["suboption_title"]){?><?php echo $TPL_V3["suboption_title"]?>:<?php }?><?php echo $TPL_V3["suboption"]?>

<?php }?>
					</dd>
				</dl>
			</td>
			<td><?php echo number_format($TPL_V3["ea"])?></td>
			<td class="right"><?php echo get_currency_price($TPL_V3["price"]*$TPL_V3["ea"], 3)?></td>
			<td class="right">
				<div id="cart_suboption_sale_total_<?php echo $TPL_V2["cart_suboption_seq"]?>">
<?php if($TPL_V3["sales"]["total_sale_price"]> 0){?>
					<?php echo get_currency_price($TPL_V3["sales"]["total_sale_price"], 3)?>

<?php }else{?>
					-
<?php }?>
				</div>
				<div id="cart_suboption_sale_detail_<?php echo $TPL_V3["cart_suboption_seq"]?>" <?php if($TPL_V3["sales"]["total_sale_price"]> 0){?><?php }else{?>class="hide"<?php }?>>
					<button type="button" class="mt3 btn_move small detailDescriptionLayerBtn">내역</button>
					<div class="detailDescriptionLayer hide" style="width:280px;">
						<div class="layer_wrap">
							<h1>할인내역</h1>
							<div class="layer_inner">
								<table class="tbl_col" width="100%" border="0" cellpadding="0" cellspacing="0">
									<caption>할인내역</caption>
									<colgroup>
										<col style="width:50%" /><col />
									</colgroup>
									<thead>
										<tr>
											<th scope="col">항목</th>
											<th scope="col">할인금액</th>
										</tr>
									</thead>
									<tbody>
<?php if(is_array($TPL_R4=$TPL_V3["sales"]["sale_list"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?>
										<tr id="cart_suboption_<?php echo $TPL_K4?>_saletr_<?php echo $TPL_V3["cart_suboption_seq"]?>" <?php if($TPL_V4> 0){?><?php }else{?>class="hide"<?php }?>>
											<td class="gr"><?php echo $TPL_V3["sales"]["title_list"][$TPL_K4]?></td>
											<td class="bolds ends prices">
												{=get_currency_price(....value_,3,'','<span id="cart_suboption_<?php echo $TPL_K4?>_saleprice_'+ ...cart_suboption_seq+'">_str_price_</span>')}
											</td>
										</tr>
<?php }}?>
									</tbody>
								</table>
							</div>
							<a href="javascript:;" class="detailDescriptionLayerCloseBtn"></a>
						</div>
					</div>
				</div>
			</td>
			<td class="right bold">
				<?php echo get_currency_price($TPL_V3["sales"]["result_price"], 3,'','<span id="cart_suboption_price_'.$TPL_V2["cart_suboption_seq"].'">_str_price_</span>')?>

			</td>
			<td class="hide">
				<table align="center" border="0">
					<tbody>
						<tr>
							<td><img src="/admin/skin/default/images/common/icon/icon_ord_emn.gif" title="캐시" /></td>
							<td class="right"><?php echo get_currency_price($TPL_V3["reserve"], 3,'','<span id="suboption_reserve_'.$TPL_V3["cart_suboption_seq"].'">_str_price_</span>')?></td>
						</tr>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
						<tr>
							<td><img src="/admin/skin/default/images/common/icon/icon_ord_point.gif" title="포인트" /></td>
							<td class="right"><span id="suboption_point_<?php echo $TPL_V3["cart_suboption_seq"]?>"><?php echo get_currency_price($TPL_V3["point"])?></span>P</td>
						</tr>
<?php }?>
					</tbody>
				</table>
			</td>
		</tr>
<?php }}?>
<?php }}?>
<?php }}?>
<?php }else{?>
		<tr>
			<td class="nodata" colspan="6">선택된 상품이 없습니다.</td>
		</tr>
<?php }?>
	</tbody>
</table>
<!-- //주문상품 테이블 -->
</div>

<div class="order_settle clearbox">
	<div class="benefit">
		<h4>배송지</h4>
		<ul class="list_inner tb_translucent_disable" style="position:relative;" >
<?php if($TPL_VAR["ordertype"]=='person'){?>
			<div class="translucent_disable_lay">
				<div class="translucent_disable_back" style="height:207px;"></div>
				<div class="translucent_disable_title_personal_code" style="top:80px;;">배송지 정보는 개인 결제 시 구매자께서 직접 입력하시게 됩니다.</div>
			</div>
<?php }?>

			<!-- 배송지 정보 :: START -->
			<li class="goods_delivery_info">
<?php if($TPL_VAR["members"]&&$TPL_VAR["is_goods"]){?>
				<input type="radio" name="chkQuickAddress" id="chkQuickAddress_often" value="often" /> <label for="chkQuickAddress_often">기본배송지</label>
				<input type="radio" name="chkQuickAddress" id="chkQuickAddress_new" value="new" /> <label for="chkQuickAddress_new">신규배송지</label>
<?php if($TPL_VAR["lately_delivery_address"]){?>
<?php if($TPL_lately_delivery_address_1){$TPL_I1=-1;foreach($TPL_VAR["lately_delivery_address"] as $TPL_V1){$TPL_I1++;?>
				<input type="radio" name="chkQuickAddress" id="chkQuickAddress_lately_<?php echo $TPL_V1["address_seq"]?>" value="lately" idx="<?php echo $TPL_I1?>" /> <label for="chkQuickAddress_lately_<?php echo $TPL_V1["address_seq"]?>">최근 : <?php echo $TPL_V1["recipient_user_name"]?></label>
<?php }}?>
<?php }?>
				<button type="button" class="btn_move small" onclick="popDeliveryaddress();">배송주소록</button>
<?php }?>
<?php if(!$TPL_VAR["members"]&&$TPL_VAR["is_goods"]){?>
				<label for="copy_order_info"><input type="checkbox" name="copy_order_info" class="hide" /><button type="button" class="btn_move small" id="copy_order_info">주문자 입력정보와 동일</button></label>
<?php }?>
			</li>
			<!-- 배송지 정보 :: END -->

			<!-- 배송불가 MSG :: START -->
			<li class="ship_possible red <?php if(!$TPL_VAR["ship_possible"]){?>hide<?php }?>">
				<input type="hidden" id="ship_possible" name="ship_possible" value="<?php if($TPL_VAR["ship_possible"]){?>N<?php }?>" />
				아래의 국가(<span class="kr_nation bold international_nation"><?php echo $TPL_VAR["ini_info"]["kr_nation"]?></span>)로 배송이 불가능한 상품이 있습니다.<br />
				장바구니에서 주문 상품을 변경하시거나 다른 국가를 선택해 주세요. &nbsp;
				<button type="button" class="btn_move small red mt-5" onclick="location='/order/cart'">장바구니로 돌아가기</button>
			</li>
			<!-- 배송불가 MSG :: END -->

			<!-- 회원일 경우 :: START -->
			<li class="delivery_member">
				<div><span class="bold recipient_user_name"><?php echo $TPL_VAR["members"]["user_name"]?></span> &nbsp;<button type="button" class="btn_move small" onclick="address_modify('delivery');">수정</button></div>
				<div class="bold">
					(<span class="recipient_zipcode"><?php echo $TPL_VAR["members"]["zipcode"]?></span>) <span class="recipient_address"><?php if($TPL_VAR["members"]["address_type"]=='street'){?><?php echo $TPL_VAR["members"]["address_street"]?><?php }else{?><?php echo $TPL_VAR["members"]["address"]?><?php }?></span> <span class="recipient_address_detail"><?php echo $TPL_VAR["members"]["address_detail"]?></span>
				</div>
				<div>
					<span class="bold cellphone"><?php echo $TPL_VAR["members"]["cellphone"]?></span> / <span class="bold phone"><?php echo $TPL_VAR["members"]["phone"]?></span>
				</div>
				<div>
					배송국가 : <span class="international_nation"><?php echo $TPL_VAR["ini_info"]["kr_nation"]?></span>
					<input type="hidden" id="address_nation" name="address_nation" value="<?php echo $TPL_VAR["ini_info"]["nation"]?>" />
				</div>
			</li>
			<!-- 회원일 경우 :: END -->

			<!-- 받는분 정보 입력 란 :: START -->
			<li class="delivery_input hide">
				<input type="text" name="recipient_user_name" value="<?php echo $TPL_VAR["members"]["user_name"]?>" title="받는분" />
			</li>
			<!-- 국내 -->
			<li class="delivery_input domestic hide">
				<input type="text" name="recipient_new_zipcode" value="<?php echo $TPL_VAR["members"]["zipcode"]?>" maxlength="7" readonly title="우편번호" readonly />
				<button type="button" onclick="window.open('/popup/zipcode?popup=1&zipcode=recipient_zipcode[]&new_zipcode=recipient_new_zipcode&address=recipient_address&address_street=recipient_address_street&address_detail=recipient_address_detail&adminzipcode=y','popup_zipcode','width=600,height=480')" class="btn_move small mt0">검색</button>
<?php if($TPL_VAR["members"]&&$TPL_VAR["is_goods"]){?>
				&nbsp;<label><input type="checkbox" name="save_delivery_address" value="1" /> 기본배송지로 저장</label>
				&nbsp;<label><input type="checkbox" name="save_delivery_address_often" value="1" /> 배송주소록에 저장</label>
<?php }?>
			</li>
			<li class="delivery_input domestic goods_delivery_info hide">
				<input type="hidden" name="recipient_address_type" value="<?php echo $TPL_VAR["members"]["address_type"]?>" size="45" title="주소" />
				<input type="text" name="recipient_address_street" value="<?php echo $TPL_VAR["members"]["address_street"]?>" size="45" class="hide" title="주소" />
				<input type="text" name="recipient_address" value="<?php echo $TPL_VAR["members"]["address"]?>" size="45" readonly title="주소" />
				<input type="text" name="recipient_address_detail" value="<?php echo $TPL_VAR["members"]["address_detail"]?>" size="45" title="상세주소" />
			</li>
			<!-- 해외 -->
			<li class="delivery_input international goods_delivery_info">
				<input type="text" name="international_address" value="" size="45" title="주소" />
			</li>
			<li class="delivery_input international goods_delivery_info hide">
				<input type="text" name="international_town_city" value="" title="시도" />
			</li>
			<li class="delivery_input international goods_delivery_info hide">
				<input type="text" name="international_county" value="" title="주" />
			</li>
			<li class="delivery_input international goods_delivery_info hide">
				<input type="text" name="international_postcode" value="" title="우편번호" />
			</li>
			<li class="delivery_input international goods_delivery_info hide">
				<input type="text" name="international_country" value="" title="국가" />
			</li>
			<li class="delivery_input hide">
				유선전화 :
				<input type="text" name="recipient_phone[]" value="<?php echo $TPL_VAR["members"]["phone_detail"][ 0]?>" size="5" title="유선" /> -
				<input type="text" name="recipient_phone[]" value="<?php echo $TPL_VAR["members"]["phone_detail"][ 1]?>" size="5" title="전화" /> -
				<input type="text" name="recipient_phone[]" value="<?php echo $TPL_VAR["members"]["phone_detail"][ 2]?>" size="5" title="번호" />
			</li>
			<li class="delivery_input hide">
				휴대전화 :
				<input type="text" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["members"]["cellphone_detail"][ 0]?>" size="5" title="휴대" /> -
				<input type="text" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["members"]["cellphone_detail"][ 1]?>" size="5" title="전화" /> -
				<input type="text" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["members"]["cellphone_detail"][ 2]?>" size="5" title="번호" />
			</li>
			<li <?php if(!$TPL_VAR["is_coupon"]){?>class="hide"<?php }?>>
				<input type="text" name="recipient_email" value="<?php echo $TPL_VAR["members"]["email"]?>" title="이메일주소" />
			</li>
			<!-- 받는분 정보 입력 란 :: END -->

			<!-- 선택국가 :: START -->
			<li class="delivery_input hide">
				<span class="international_nation"><?php echo $TPL_VAR["ini_info"]["kr_nation"]?></span> &nbsp;
				<button type="button" class="btn_move small detailDescriptionLayerBtn">다른국가 선택</button>
				<div class="detailDescriptionLayer hide" style="width:420px;">
					<div class="layer_wrap">
						<h1>배송국가 선택</h1>
						<div class="layer_inner">
							<dl class="ship_country clearbox">
								<dt>현재 배송 국가 : <strong class="international_nation"><?php echo $TPL_VAR["ini_info"]["kr_nation"]?></strong>
								<img id="nation_img" src="/admin/skin/default/images/common/icon/nation/<?php echo $TPL_VAR["ini_info"]["nation"]?>.png" height="20" alt=""></dt>
								<dd id="nation_gl_type" <?php if($TPL_VAR["ini_info"]["nation"]=='KOREA'){?>class="hide"<?php }?>><button type="button" class="btn_move small" onclick="chg_shipping_nation('KOREA');">대한민국으로 변경</button></dd>
							</dl>
							<div style="margin-right:-15px; padding-right:5px; height:187px; overflow-y:scroll;">
								<table class="tbl_row" width="100%" border="0" cellpadding="0" cellspacing="0">
									<caption>배송국가</caption>
									<colgroup>
										<col style="width:50%" /><col style="width:50%" />
									</colgroup>
									<tbody>
<?php if($TPL_ship_gl_arr_1){foreach($TPL_VAR["ship_gl_arr"] as $TPL_K1=>$TPL_V1){?>
									<tr>
										<th scope="row" class="hand" onclick="chg_shipping_nation('<?php echo $TPL_V1["nation_str"]?>');">
											<img src="/admin/skin/default/images/common/icon/nation/<?php echo $TPL_VAR["ship_gl_list"][$TPL_K1]['gl_nation']?>.png" height="20" alt=""> <?php echo $TPL_VAR["ship_gl_list"][$TPL_K1]['gl_nation']?>

										</th>
										<td class="left"><?php echo $TPL_VAR["ship_gl_list"][$TPL_K1]['kr_nation']?></td>
									</tr>
<?php }}?>
									</tbody>
								</table>
							</div>
						</div>
						<a href="javascript:;" class="detailDescriptionLayerCloseBtn">닫기</a>
					</div>
				</div>
			</li>
			<!-- 선택국가 :: END -->

			<li class="goods_delivery_info">
				<div class="fleft pdr10">
					<div class="ship-lay total_ship_msg">
						<span class="ship_message">
							<input type="text" class="ship_message_txt" name="memo" id="memo" title="배송 메시지를 입력하세요." value="" />
							<span class="click"></span>
							<ul class="add_message">
								<li>배송 전에 미리 연락해 주세요.</li>
								<li>부재시 경비실에 맡겨 주세요.</li>
								<li>부재시 전화 주시거나 문자 남겨 주세요.</li>
<?php if($TPL_VAR["ship_message"]){?>
<?php if($TPL_ship_message_1){foreach($TPL_VAR["ship_message"] as $TPL_V1){?>
								<li>ddd</li>
<?php }}?>
<?php }?>
							</ul>
						</span>
						<span class="desc"><span class="cnt_txt">0</span>/300</span>
					</div>
					<div class="each_ship_msg hide">
<?php if($TPL_shipping_group_list_1){foreach($TPL_VAR["shipping_group_list"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_ship_message_3=empty($TPL_V2["ship_message"])||!is_array($TPL_V2["ship_message"])?0:count($TPL_V2["ship_message"]);?>
						<div class="ship-lay pdb10">
							<div class="goods_info_txt">
							<?php echo $TPL_V2["goods_name"]?>

<?php if($TPL_V2["title1"]){?>
							<?php echo $TPL_V2["title1"]?>:<?php }?><?php echo $TPL_V2["option1"]?><?php if($TPL_V2["option2"]){?>, <?php if($TPL_V2["title2"]){?>
							<?php echo $TPL_V2["title2"]?>:<?php }?><?php echo $TPL_V2["option2"]?> <?php }?><?php if($TPL_V2["option3"]){?>, <?php if($TPL_V2["title3"]){?>
							<?php echo $TPL_V2["title3"]?>:<?php }?><?php echo $TPL_V2["option3"]?> <?php }?><?php if($TPL_V2["option4"]){?>, <?php if($TPL_V2["title4"]){?>
							<?php echo $TPL_V2["title4"]?>:<?php }?><?php echo $TPL_V2["option4"]?> <?php }?><?php if($TPL_V2["option5"]){?>, <?php if($TPL_V2["title5"]){?>
							<?php echo $TPL_V2["title5"]?>:<?php }?><?php echo $TPL_V2["option5"]?> <?php }?>
							</div>
							<span class="ship_message">
								<input type="text" class="ship_message_txt" name="each_memo[]" size="70" title="배송 메시지를 입력하세요." value="" />
								<span class="click"></span>
								<ul class="add_message">
									<li>배송 전에 미리 연락해 주세요.</li>
									<li>부재시 경비실에 맡겨 주세요.</li>
									<li>부재시 전화 주시거나 문자 남겨 주세요.</li>
<?php if($TPL_VAR["ship_message"]){?>
<?php if($TPL_ship_message_3){foreach($TPL_V2["ship_message"] as $TPL_V3){?>
									<li>ddd</li>
<?php }}?>
<?php }?>
								</ul>
							</span>
							<span class="desc"><span class="cnt_txt">0</span>/300</span>
						</div>
<?php }}?>
<?php }}?>
					</div>
				</div>
				<div class="ship-msg-lay">
					<input type="checkbox" id="each_msg" name="each_msg" onchange="ship_each_input();" /> <label for="each_msg">상품별입력</label>
				</div>
			</li>
		</ul>
	</div>
	<div class="settle bgcolor">
		<h4>주문자</h4>
		<input type="hidden" name="order_zipcode[]" value="<?php echo $TPL_VAR["members"]["zipcode1"]?>" />
		<input type="hidden" name="order_zipcode[]" value="<?php echo $TPL_VAR["members"]["zipcode2"]?>" />
		<input type="hidden" name="order_address_type" value="<?php echo $TPL_VAR["members"]["address_type"]?>" />
		<input type="hidden" name="order_address" value="<?php echo $TPL_VAR["members"]["address"]?>" />
		<input type="hidden" name="order_address_street" value="<?php echo $TPL_VAR["members"]["address_street"]?>" />
		<input type="hidden" name="order_address_detail" value="<?php echo $TPL_VAR["members"]["address_detail"]?>"/>
		<ul class="list_inner">
			<!-- 회원일 경우 :: START -->
			<li class="order_member">
				<ul>
					<li><?php echo $TPL_VAR["members"]["user_name"]?> &nbsp;<button type="button" class="btn_move small" onclick="address_modify('order');">수정</button></li>
					<li>(<?php echo $TPL_VAR["members"]["zipcode"]?>) <?php echo $TPL_VAR["members"]["address_street"]?><?php echo $TPL_VAR["members"]["address_detail"]?></li>
					<li><?php echo $TPL_VAR["members"]["cellphone"]?> / <?php echo $TPL_VAR["members"]["phone"]?></li>
					<li><?php echo $TPL_VAR["members"]["email"]?></li>
				</ul>
			</li>
			<!-- 회원일 경우 :: END -->

			<!-- 주문자 정보 입력 란 :: START -->
			<li class="order_input hide">
				<input type="text" name="order_user_name" value="<?php echo $TPL_VAR["members"]["user_name"]?>" size="26" title="주문자 이름" />
			</li>
			<li class="order_input hide">
				<input type="text" name="order_phone[]" value="<?php echo $TPL_VAR["members"]["phone_detail"][ 0]?>" size="5" class="line" title="유선" /> -
				<input type="text" name="order_phone[]" value="<?php echo $TPL_VAR["members"]["phone_detail"][ 1]?>" size="5" class="line" title="전화" /> -
				<input type="text" name="order_phone[]" value="<?php echo $TPL_VAR["members"]["phone_detail"][ 2]?>" size="5" class="line" title="번호"/>
				<br />
				<input type="text" name="order_cellphone[]" value="<?php echo $TPL_VAR["members"]["cellphone_detail"][ 0]?>" size="5" class="line" title="휴대" /> -
				<input type="text" name="order_cellphone[]" value="<?php echo $TPL_VAR["members"]["cellphone_detail"][ 1]?>" size="5" class="line" title="전화" /> -
				<input type="text" name="order_cellphone[]" value="<?php echo $TPL_VAR["members"]["cellphone_detail"][ 2]?>" size="5" class="line" title="번호" />
			</li>
			<li class="order_input hide">
				<input type="text" name="order_email" value="<?php echo $TPL_VAR["members"]["email"]?>" size="35" title="이메일주소" />
			</li>
			<!-- 받는분 정보 입력 란 :: END -->
			<li>
				<ul class="ul_list2 mt5">
					<li>주문자 정보로 문자와 이메일이 발송됩니다.</li>
					<li>휴대폰번호와 이메일주소를 확인하세요.</li>
					<li>비회원은 이메일과 주문번호로 주문조회가 가능합니다.</li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- //주문자 정보 -->
</div>
<!-- //배송지 정보 -->


<div class="order_settle clearbox">
	<div class="benefit" style="position:relative;" >
		<h4>할인 및 적립<?php echo $TPL_VAR["btn_estimate"]?></h4>
<?php if($TPL_VAR["ordertype"]=='person'){?>
		<div class="translucent_disable_lay">
			<div class="translucent_disable_back" style="top:40px;height:197px;"></div>
			<div class="translucent_disable_title_personal_code" style="top:115px;letter-spacing:-1px;">할인 및 적립정보는 개인 결제 시 구매자께서 직접 입력하시게 됩니다.</div>
		</div>
<?php }?>
		<dl class="save clearbox tb_translucent_disable">
<?php if($TPL_VAR["members"]&&$_GET["person_seq"]==""){?>
			<dt>쿠폰할인</dt>
			<dd>
				<?php echo get_currency_price( 0, 3,'','<span id="total_coupon_sale" class="save">_str_price_</span>')?>

				<button type="button" id="coupon_apply" class="btn_move small wx">쿠폰사용</button>
				&nbsp; 보유 쿠폰 : <span class="bold"><?php echo number_format($TPL_VAR["member_usable_coupons"])?></span>장
			</dd>
<?php }?>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispromotioncode"]&&$_GET["person_seq"]==""){?>
			<dt>코드할인</dt>
			<dd>
				<?php echo get_currency_price( 0, 3,'','<span id="total_promotion_goods_sale" class="save"></span>')?>

				<span class="cartpromotioncodeinputlay" <?php if($TPL_VAR["cart_promotioncode"]){?>style="display:none;"<?php }?>><button type="button" onclick="getPromotionck(); return false;" class="btn_move small wx">코드입력</button></span>
				<span class="cartpromotioncodedellay" <?php if(!$TPL_VAR["cart_promotioncode"]){?>style="display:none;"<?php }?>><button type="button" onclick="getPromotionCartDel(); return false;" class="btn_move small">초기화</button></span>&nbsp;
				<input type="text" name="cartpromotioncode" id="cartpromotioncode" value="<?php echo $TPL_VAR["cart_promotioncode"]?>" class="save" />
			</dd>
<?php }?>
<?php if(($TPL_VAR["members"]&&!$_GET["person_seq"])||($_GET["person_seq"]> 0&&$TPL_VAR["person_use_reserve"])){?>
			<dt>캐시</dt>
			<dd>
				<?php echo get_currency_price( 0, 3,'','<input type="text" name="emoney_view" class="onlyfloat save" value="_str_price_" />')?>

				<input type="hidden" name="emoney" value="0"/>
				<input type="hidden" name="emoney_all" value=""/>
				<span class="emoney_input_button" onclick="use_emoney(); return false;"><button type="button" class="btn_move small">입력</button></span>
				<span class="emoney_all_input_button" onclick="use_all_emoney(); return false;"><button type="button" class="btn_move small">모두사용</button></span>
				<span class="emoney_cancel_button" onclick="cancel_emoney(); return false;" style="display:none"><button type="button" class="btn_move small">초기화</button></span>
				&nbsp; 보유 캐시 : <span class="bold"><?php echo get_currency_price($TPL_VAR["members"]["emoney"], 3)?></span>
			</dd>
<?php }?>
<?php if($TPL_VAR["members"]){?>
			<dt>예치금</dt>
			<dd>
				<?php echo get_currency_price( 0, 3,'','<input type="text" name="cash_view" class="onlyfloat save" value="_str_price_" />')?>

				<input type="hidden" name="cash" value="0"/>
				<input type="hidden" name="cash_all" value=""/>
				<span class="cash_input_button" onclick="use_cash(); return false;"><button type="button" class="btn_move small">사용</button></span>
				<span class="cash_all_input_button" onclick="use_all_cash(); return false;"><button type="button" class="btn_move small">모두사용</button></span>
				<span class="cash_cancel_button hide" onclick="cancel_cash(); return false;" style="display:none"><button  type="button" class="btn_move small">초기화</button></span>
				&nbsp; 보유 예치금 : <span class="bold"><?php echo get_currency_price(get_member_money('cash',$TPL_VAR["members"]["member_seq"]), 3)?></span>
			</dd>
			<dt>예상적립 혜택</dt>
			<dd>
				구매 시 : 캐시 최대 <?php echo get_currency_price($TPL_VAR["total_reserve"], 3,'','<span id="total_reserve" class="bold">_str_price_</span>')?>

<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>, 포인트 <span id="total_point" class="bold"><?php echo get_currency_price($TPL_VAR["total_point"])?></span>P
<?php }?>
<?php if($TPL_VAR["cfg_reserve"]["autoemoney"]){?>
				<p>상품평작성 시 캐시 최대 <?php echo get_currency_price($TPL_VAR["cfg_reserve"]["autoemoney_review"], 2,'','<span class="bold">_str_price_</span>')?><?php if(serviceLimit('H_NFR')&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>, 포인트 <span class="bold"><?php echo number_format($TPL_VAR["cfg_reserve"]["autopoint_review"])?></span>P<?php }?></p>
<?php }?>
			</dd>
<?php }?>
<?php if(in_array($TPL_VAR["naver_mileage_yn"],array('y','t'))){?>
			<!-- 네이버 마일리지 버튼 -->
			<dt>네이버마일리지</dt>
			<dd>
				<?php echo showNaverMileageButton()?>

			</dd>
<?php }?>
		</dl>
	</div>
	<div class="settle bgcolor">
		<dl class="clearbox">
			<dt>총 상품금액</dt>
			<dd><?php echo get_currency_price($TPL_VAR["total"], 3,'','<span id="total_goods_price">_str_price_</span>')?></dd>
			<dt class="goods_delivery_info">배송비</dt>
			<dd class="goods_delivery_info"><span class="normal">(+)</span> <?php echo get_currency_price($TPL_VAR["total_shipping_price"], 3,'','<span class="total_delivery_shipping_price">_str_price_</span>')?></dd>
			<dt>할인금액</dt>
			<dd><span class="normal">(-)</span> <?php echo get_currency_price($TPL_VAR["total_sale"], 3,'','<span class="total_sales_price">_str_price_</span>')?></dd>
<?php if($TPL_VAR["members"]){?>
			<dt>캐시 사용</dt>
			<dd><span class="normal">(-)</span> <?php echo get_currency_price( 0, 3,'','<span id="use_emoney">_str_price_</span>')?></dd>
			<dt>예치금 사용</dt>
			<dd><span class="normal">(-)</span> <?php echo get_currency_price( 0, 3,'','<span id="use_cash">_str_price_</span>')?></dd>
<?php }?>
			<dt class="total" style="padding:10px 0px;">결제금액</dt>
			<dd class="total price" style="padding:10px 0px;">
				<?php echo get_currency_price($TPL_VAR["total_price"], 3,'','<span class="settle_price tahoma">_str_price_</span>')?>

				<span class="price_cell settle_price_compare fx20 bold tahoma total_result_price"><?php echo $TPL_VAR["total_price_compare"]?></span>
			</dd>
		</dl>
	</div>
	<!-- //결제금액 -->
</div>
<!-- //할인 및 적립 -->

<div id="delivery_address_dialog" style="display:none;"></div><!--주소록-->


<div id="coupon_apply_dialog" class="hide">
	<ul class="ul_coupon">
		<li>
			<span class="ico_de">iCON</span> <strong>주문서 쿠폰</strong>
			<ul id="coupon_ordersheet_lay" class="ul_list2"></ul>
		</li>
		<li>
			<span class="ico_de">iCON</span> <strong>상품 쿠폰</strong>
			<ul id="coupon_goods_lay" class="ul_list2">
				<li>상품명  |  상품갯수
					<div class="">
						<select id="" style="width:85%;">
							<option value="" selected="selected">coupons</option>
							<option value=""></option>
						</select>
						<button type="button" class="btn_move small" disabled>쿠폰정보</button>
					</div>
				</li>
			</ul>
		</li>
		<li>
			<span class="ico_de">iCON</span> <strong>배송비 쿠폰 – 개별배송상품에는 적용 불가</strong>
			<ul id="coupon_shipping_lay" class="ul_list2">
				<div id="coupon_shipping_select" class="">
					<select id="" style="width:85%;">
						<option value=""></option>
					</select>
					<button type="button" class="btn_move small">쿠폰정보</button>
				</div>
			</ul>
		</li>
	</ul>
	<div class="mt20 center">
		<button type="button" id="coupon_order" class="btn_sch medium couponbtn">적용</button>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() {

	});
</script>