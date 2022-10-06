<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/order/_coupon.html 000005728 */ 
$TPL_provider_cart_1=empty($TPL_VAR["provider_cart"])||!is_array($TPL_VAR["provider_cart"])?0:count($TPL_VAR["provider_cart"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 쿠폰 선택( 결제시 '쿠폰사용' 클릭시 뜨는 레이어 콘텐츠 ) @@
- 파일위치 : [스킨폴더]/order/_coupon.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<li>
	<h5 class="stitle v2 Pb4 gray_01">ㆍ상품 쿠폰</h5>
<?php if($TPL_VAR["provider_cart"]){?>
	<ul class="list_01 v2">
<?php if($TPL_provider_cart_1){foreach($TPL_VAR["provider_cart"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["cart_list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
		<li>
			<p class="stitle v3"><?php echo $TPL_V2["goods_name"]?></p>
<?php if($TPL_V2["option1"]!=null){?>
			<span class="option_info">
<?php if($TPL_V2["title1"]){?><?php echo $TPL_V2["title1"]?> : <?php }?><?php echo $TPL_V2["option1"]?>

<?php if($TPL_V2["option2"]!=null){?><?php if($TPL_V2["title2"]){?><?php echo $TPL_V2["title2"]?> : <?php }?><?php echo $TPL_V2["option2"]?> <?php }?>
<?php if($TPL_V2["option3"]!=null){?><?php if($TPL_V2["title3"]){?><?php echo $TPL_V2["title3"]?> : <?php }?><?php echo $TPL_V2["option3"]?> <?php }?>
<?php if($TPL_V2["option4"]!=null){?><?php if($TPL_V2["title4"]){?><?php echo $TPL_V2["title4"]?> : <?php }?><?php echo $TPL_V2["option4"]?> <?php }?>
<?php if($TPL_V2["option5"]!=null){?><?php if($TPL_V2["title5"]){?><?php echo $TPL_V2["title5"]?> : <?php }?><?php echo $TPL_V2["option5"]?> <?php }?>
			</span> 
			( <?php echo number_format($TPL_V2["ea"])?>개 )
<?php }?>
			<div class="sel_area Pt5">
				<select name="coupon[<?php echo $TPL_V2["cart_seq"]?>]" class="coupon_select" id="coupon_<?php echo $TPL_V2["cart_seq"]?>_<?php echo $TPL_V2["cart_option_seq"]?>"  onchange="changeCouponSelectbox(this, 'goods')" style="width:100%;<?php if(!$TPL_V2["coupons"]){?>background-color:#D9D9D9;<?php }?>" <?php if(!$TPL_V2["coupons"]){?>disabled<?php }?>>
<?php if($TPL_V2["coupons"]){?>
					<option value="" selected>--쿠폰 선택--</option>
<?php if(is_array($TPL_R3=$TPL_V2["coupons"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
					<option value="<?php echo $TPL_V3["download_seq"]?>" couponsametime="<?php echo $TPL_V3["coupon_same_time"]?>"  duplication="<?php echo $TPL_V3["duplication_use"]?>" sale="<?php echo $TPL_V3["goods_sale"]?>"  <?php if($TPL_V3["download_seq"]==$TPL_V2["download_seq"]){?> selected="selected" <?php }?> ><?php if($TPL_V3["couponsametimetitle"]){?>[<?php echo $TPL_V3["couponsametimetitle"]?>] <?php }?><?php echo $TPL_V3["coupon_name"]?> (<?php echo get_currency_price($TPL_V3["goods_sale"], 2)?> 할인)</option>
<?php }}?>
<?php }else{?>
				<option value="" selected>적용 대상 쿠폰이 없습니다.</option>
<?php }?>
				</select>
			</div>
		</li>
<?php }}?>
<?php }}?>
	</ul>
<?php }else{?>
	<ul>
		<li class="pdb10">
			보유하고 있는 상품 쿠폰이 없습니다.
		</li>
	</ul>
<?php }?>
</li>

<script>
$.cookie( "couponsametimeuse", null );
</script>
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