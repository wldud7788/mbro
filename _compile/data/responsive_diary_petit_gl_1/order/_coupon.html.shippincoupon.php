<?php /* Template_ 2.2.6 2021/01/08 12:02:10 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/order/_coupon.html 000002761 */ 
$TPL_provider_cart_1=empty($TPL_VAR["provider_cart"])||!is_array($TPL_VAR["provider_cart"])?0:count($TPL_VAR["provider_cart"]);?>

<li>
	<h5 class="stitle v2 gray_01 Pb4 Mt20">ㆍ배송비 쿠폰</h5>
	<ul class="list_01 v2">
<?php if($TPL_VAR["provider_cart"]&&$TPL_VAR["total_shipping_price"]){?>
<?php if($TPL_VAR["checkshippingcoupons"]){?>
<?php if($TPL_provider_cart_1){foreach($TPL_VAR["provider_cart"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["cart_list"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
				<!-- <?php if($TPL_V2["shipping_provider_division"]&&$TPL_I2== 0){?> -->
		<li>
			<div class="coupon_provider_info pointcolor2 Pt10">
<?php if(serviceLimit('H_AD')){?>
				<span class="provider_name">[<?php echo $TPL_V2["shipping"]['provider_name']?>]</span>
<?php }?>
				<span class="shipping_method"><?php echo $TPL_V2["shipping_method_name"]?></span>
				<span id="price_<?php echo $TPL_V2["shipping_group"]?>"><?php echo get_currency_price($TPL_V1["grp_shipping_price"], 2)?></span>
			</div>
			<div class="coupon_selecter Pt5">
				<select name="coupon_shipping[<?php echo $TPL_V2["shipping_group"]?>]" id="shippingcoupon_<?php echo $TPL_V2["shipping_group"]?>" class="shipping_coupon_select" onchange="changeCouponSelectbox(this, 'shipping')"  style="width:100%;<?php if(!$TPL_V2["shipping_coupon"]){?>background-color:#D9D9D9;<?php }?>"> 
<?php if($TPL_V2["event"]['use_coupon_shipping']!='n'&&$TPL_V2["shipping_coupon"]){?>
					<option value="" selected>--배송비 쿠폰 선택--</option>
<?php if(is_array($TPL_R3=$TPL_V2["shipping_coupon"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
					<option value="<?php echo $TPL_V3["download_seq"]?>"  couponsametime="<?php echo $TPL_V3["coupon_same_time"]?>"   sale="<?php echo $TPL_V3["shipping_sale"]?>" <?php if($TPL_V3["download_seq"]==$_POST["download_seq"]){?> selected="selected" <?php }?>><?php echo $TPL_V3["coupon_name"]?> (<?php echo get_currency_price($TPL_V3["shipping_sale"], 2)?> 할인)</option>
<?php }}?>
<?php }else{?>
					<option value="" selected>적용 대상 쿠폰이 없습니다.</option>
<?php }?>
				</select>
			</div>
		</li>
<?php }?>
<?php }}?>
<?php }}?>
<?php }else{?>
		<li>
			보유하고 있는 배송비 쿠폰이 없습니다.
		</li>
<?php }?>
<?php }else{?>
		<li>
			주문 시 결제하셔야 하는 배송비가 없습니다.
		</li>
<?php }?>
	</ul>
</li>
<script>
$.cookie( "couponsametimeuse", null );
$(".coupon_select, .shipping_coupon_select").each(function(){ resetCouponSelect(this); });
</script>