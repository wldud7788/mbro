<?php /* Template_ 2.2.6 2020/12/29 17:40:20 /www/music_brother_firstmall_kr/admin/skin/default/order/person_view.html 000017086 */ 
$TPL_shipping_group_list_1=empty($TPL_VAR["shipping_group_list"])||!is_array($TPL_VAR["shipping_group_list"])?0:count($TPL_VAR["shipping_group_list"]);
$TPL_pay_types_1=empty($TPL_VAR["pay_types"])||!is_array($TPL_VAR["pay_types"])?0:count($TPL_VAR["pay_types"]);?>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/admin_cart.css" />
<script type="text/javascript">
function order_price_calculate(){
	var f				= $("form#orderFrm");
	var action			= "/order/calculate";

	f.attr("action",action);
	f.attr("target","actionFrame");
	f[0].submit();
}
$(document).ready(function(){

	$(".detailDescriptionLayerBtn").click(function(){
		$('div.detailDescriptionLayer').not($(this).next('div.detailDescriptionLayer')).hide();
		$(this).next('div.detailDescriptionLayer').show();
	});
	$(".detailDescriptionLayerCloseBtn").click(function(){
		$(this).closest('div.detailDescriptionLayer').hide();
	});
	order_price_calculate();
});
</script>

<div><b>개인결제타이틀 : </b><?php echo $TPL_VAR["record"]["title"]?></div>
<form name="orderFrm" id="orderFrm" method="post" action="cacluate" target="actionFrame">
<input type="hidden" name="mode" value="cart" />
<input type="hidden" name="adminOrder" value="admin" />
<input type="hidden" name="adminOrderType" value="person" />
<input type="hidden" name="member_seq" id="member_seq" value="<?php echo $_GET["member_seq"]?>" />
<input type="hidden" name="person_seq" id="person_seq" value="<?php echo $_GET["person_seq"]?>" />
<div class="admin_cart" style="margin-top:10px;">
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
					<dt style="display:inline-block;">
						<a href="/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>"><img src="<?php echo $TPL_V2["image"]?>" class="order_thumb" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif'" width="60" alt="<?php echo $TPL_V2["goods_name"]?>" /></a>
					</dt>
					<dd style="top:0px;margin:0px;line-height:120% !important;display:inline-block;">
						<a href="/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>" title="<?php echo $TPL_V2["goods_name"]?>" class="order_name"><?php echo $TPL_V2["goods_name"]?></a>
						<div>
<?php if($TPL_V2["adult_goods"]=='Y'){?>
							<img src="/admin/skin/default/images/common/auth_img.png" height="17" align="absmiddle" alt="성인" />
<?php }?>
<?php if($TPL_V2["option_international_shipping_status"]=='y'){?>
							<img src="/admin/skin/default/images/common/icon/plane_on.png" height="14" align="absmiddle" alt="해외배송상품" />
<?php }?>
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
				<div id="cart_option_sale_total_<?php echo $TPL_V2["cart_option_seq"]?>">
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
			</td>
<?php }?>
		</tr>
<?php if(is_array($TPL_R3=$TPL_V2["cart_suboptions"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
		<tr class="sub_bg">
			<td>
				<dl class="order_thumb_wrap">
					<dt>
						<img src="/admin/skin/default/images/common/icon_add_arrow.gif" class="pdr15" alt="" />
					</dt>
					<dd class="order_option">
						<span class="btn_gray icon" style="margin-left:3px;">추가</span>
<?php if($TPL_V3["suboption"]){?>
<?php if($TPL_V3["suboption_title"]){?><?php echo $TPL_V3["suboption_title"]?>:<?php }?><?php echo $TPL_V3["suboption"]?>

<?php }?>
					</dd>
				</dl>
			</td>
			<td><?php echo number_format($TPL_V3["ea"])?></td>
			<td class="right"><?php echo get_currency_price($TPL_V3["price"]*$TPL_V3["ea"], 3)?></td>
			<td class="right">
				<div id="cart_suboption_sale_total_<?php echo $TPL_V3["cart_suboption_seq"]?>">
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
												<?php echo get_currency_price($TPL_V4, 3,'','<span id="cart_suboption_'.$TPL_K3.'_saleprice_'.$TPL_V3["cart_suboption_seq"].'">_str_price_</span>')?>

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
			<td class="nodata" colspan="6">주문 상품이 없습니다.</td>
		</tr>
<?php }?>
	</tbody>
</table>
<!-- //주문상품 테이블 -->
</div>

<!-- 결제정보입력/결제하기 -->
<div class="order_settle clearbox">
	<div class="benefit fx12">
		<div class="pd10">
			<dl class="clearbox" style="padding:10px 0px 0px 0px;">
				<dt>구매적립 혜택</dt>
				<dd>
					구매확정 시 : 캐시 <?php echo get_currency_price($TPL_VAR["total_reserve"], 3,'','<span id="total_reserve" class="bold">_str_price_</span>')?><?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>, 포인트 <span id="total_point" class="bold"><?php echo get_currency_price($TPL_VAR["total_point"])?></span>P
<?php }?>
				</dd>
			</dl>
			<dl class="clearbox" style="padding:5px 0px 0px 0px;">
				<dt>결제수단</dt>
				<dd>
<?php if($TPL_pay_types_1){foreach($TPL_VAR["pay_types"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_V1){?> <?php if($TPL_K1> 0){?> / <?php }?><?php echo $TPL_V1?> <?php }?>
<?php }}?>
				</dd>
			</dl>
			<dl class="clearbox" style="padding:5px 0px 10px 0px;">
				<dt>에누리</dt>
				<dd>
					<?php echo get_currency_price($TPL_VAR["record"]["enuri"], 3)?>

				</dd>
			</dl>
		</div>
	</div>
	<div class="settle bgcolor">
		<dl class="clearbox">
			<dt class="total" style="padding:10px 0px;border:0px;">결제금액</dt>
			<dd class="total price" style="padding:10px 0px;border:0px;">
				<?php echo get_currency_price($TPL_VAR["orderData"]["settleprice"], 3,'','<span class="settle_price tahoma" id="total_settle_price">_str_price_</span>')?>

			</dd>
			<span class="price_cell settle_price_compare fx20 bold tahoma total_result_price"><?php echo $TPL_VAR["total_price_compare"]?></span>
		</dl>

	</div>
</div>
<!-- //결제금액 -->


<!-- 주문자/배송지 정보 -->
<div class="order_settle clearbox">
	<div class="benefit ">
		<h4>배송지</h4>
		
<?php if(!$TPL_VAR["orderData"]["order_seq"]){?>
		<ul class="list_inner fx12">
			<li>배송지 정보는 개인 결제 시 구매자께서 직접 입력하시게 됩니다.</li>
		</ul>
<?php }else{?>
		<ul class="list_inner">
			<li class="delivery_member">
				<div><span class="bold recipient_user_name"><?php echo $TPL_VAR["orderData"]["recipient_user_name"]?></span></div>
				<div class="bold">
					(<span class="recipient_zipcode"><?php echo $TPL_VAR["orderData"]["recipient_zipcode"]?></span>)

					<span class="recipient_address"><?php if($TPL_VAR["orderData"]["recipient_address_type"]=='street'){?><?php echo $TPL_VAR["orderData"]["recipient_address_street"]?><?php }else{?><?php echo $TPL_VAR["orderData"]["recipient_address"]?><?php }?></span> <span class="recipient_address_detail"><?php echo $TPL_VAR["orderData"]["recipient_address_detail"]?></span>
				</div>
				<div>
					<span class="bold cellphone"><?php echo $TPL_VAR["orderData"]["recipient_cellphone"]?></span> / <span class="bold phone"><?php echo $TPL_VAR["orderData"]["recipient_phone"]?></span>
				</div>
				<div>
					배송국가 : <span class="international_nation"><?php echo $TPL_VAR["ini_info"]["kr_nation"]?></span>
				</div>
				<div>
					배송메세지 : <span class="international_nation"><?php echo $TPL_VAR["orderData"]["memo"]?></span>
				</div>
			</li>
		</ul>
<?php }?>
	</div>
	<div class="settle bgcolor fx12">
		<h4>주문자</h4>
		<ul class="list_inner">
			<!-- 회원일 경우 :: START -->
			<li class="order_member">
				<ul>
					<li><?php echo $TPL_VAR["record"]["order_user_name"]?></li>
					<li><?php echo $TPL_VAR["record"]["order_cellphone"]?> / <?php echo $TPL_VAR["record"]["order_phone"]?></li>
					<li><?php echo $TPL_VAR["record"]["order_email"]?></li>
				</ul>
			</li>
			<!-- 회원일 경우 :: END -->
		</ul>
	</div>
	<!-- //주문자 정보 -->
</div>
</form>