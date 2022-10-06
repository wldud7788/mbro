<?php /* Template_ 2.2.6 2021/12/15 17:48:38 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/order/_coupon_ordersheet.html 000002110 */ 
$TPL_ordersheetcoupons_1=empty($TPL_VAR["ordersheetcoupons"])||!is_array($TPL_VAR["ordersheetcoupons"])?0:count($TPL_VAR["ordersheetcoupons"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 쿠폰 선택( 결제시 '쿠폰사용' 클릭시 뜨는 레이어 콘텐츠 ) @@
- 파일위치 : [스킨폴더]/order/_coupon_ordersheet.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_VAR["ordersheetcoupons"]){?>
<li>
	<h5 class="stitle v2 Pb4 gray_01">ㆍ주문서 쿠폰</h5>
	<ul class="list_01 v2">
		<li>
			<div class="sel_area Pt5">
				<select name="coupon_ordersheet" class="coupon_select ordersheet_coupon_select" id="ordersheetcoupon" onchange="changeCouponSelectbox(this, 'ordersheet')" style="width:100%;">
					<option value="" selected>--주문서 쿠폰 선택--</option>
<?php if($TPL_ordersheetcoupons_1){foreach($TPL_VAR["ordersheetcoupons"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["download_seq"]?>" 
						couponsametime="<?php echo $TPL_V1["coupon_same_time"]?>" 
						sale="<?php echo $TPL_V1["ordersheet_sale"]?>" 
<?php if($TPL_V1["download_seq"]==$TPL_VAR["ordersheet_coupon_download_seq"]){?> 
						selected="selected" 
<?php }?>
					>
<?php if($TPL_V1["couponsametimetitle"]){?>[<?php echo $TPL_V1["couponsametimetitle"]?>] <?php }?>
						<?php echo $TPL_V1["coupon_name"]?>

						(<?php echo get_currency_price($TPL_V1["ordersheet_sale"], 2)?> 할인)
					</option>
<?php }}else{?>
					<option value="" selected>적용 대상 쿠폰이 없습니다.</option>
<?php }?>
				</select>
			</div>
		</li>
	</ul>
<?php }else{?>
	<ul>
		<li class="pdb10">
			보유하고 있는 주문서 쿠폰이 없습니다.
		</li>
	</ul>
<?php }?>
</li>

<script>
	$.cookie( "couponsametimeuse", null );
	$(".coupon_select, .shipping_coupon_select, .ordersheet_coupon_select").each(function(){ resetCouponSelect(this); });
</script>