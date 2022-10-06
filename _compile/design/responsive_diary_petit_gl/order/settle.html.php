<?php /* Template_ 2.2.6 2021/11/29 15:26:30 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/order/settle.html 000088473 */  $this->include_("showNaverMileageButton","sslAction");
$TPL_shipping_group_list_1=empty($TPL_VAR["shipping_group_list"])||!is_array($TPL_VAR["shipping_group_list"])?0:count($TPL_VAR["shipping_group_list"]);
$TPL_gloop_1=empty($TPL_VAR["gloop"])||!is_array($TPL_VAR["gloop"])?0:count($TPL_VAR["gloop"]);
$TPL_lately_msg_1=empty($TPL_VAR["lately_msg"])||!is_array($TPL_VAR["lately_msg"])?0:count($TPL_VAR["lately_msg"]);
$TPL_bank_1=empty($TPL_VAR["bank"])||!is_array($TPL_VAR["bank"])?0:count($TPL_VAR["bank"]);
$TPL_ship_gl_arr_1=empty($TPL_VAR["ship_gl_arr"])||!is_array($TPL_VAR["ship_gl_arr"])?0:count($TPL_VAR["ship_gl_arr"]);
$TPL_total_sale_list_1=empty($TPL_VAR["total_sale_list"])||!is_array($TPL_VAR["total_sale_list"])?0:count($TPL_VAR["total_sale_list"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 주문/결제 @@
- 파일위치 : [스킨폴더]/order/settle.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<style type="text/css">
	.resp_layer_pop .btn_view_coupons { position:absolute; right:60px; top:22px; }
	.subpage_wrap.order_payment.flyingMode .order_payment_right .order_subsection { position:fixed; right:0; top:0; z-index:100; width:100%; /*width:calc(40% - 20px);*/ }
	.subpage_wrap.order_payment.flyingMode .order_payment_right .order_subsection .right_flying_wrap1 { max-width:1260px; padding-left:40px; padding-right:40px; margin:0 auto; }
	.subpage_wrap.order_payment.flyingMode .order_payment_right .order_subsection .right_flying_wrap2 { width:100%; position:relative; }
	.subpage_wrap.order_payment.flyingMode .order_payment_right .order_subsection .right_flying_wrap3 { position:absolute; right:0; top:0; width:calc(40% - 20px); background:#fff; box-shadow:0 0 4px rgba(0, 0, 0, 0.2); }
	@media only screen and (max-width:1023px) {
		.subpage_wrap.order_payment.flyingMode .order_payment_right .order_subsection .right_flying_wrap1 { padding-left:10px; padding-right:10px; }
		.subpage_wrap.order_payment.flyingMode .order_payment_right .order_subsection .right_flying_wrap3 { width:290px; }
	}
	@media only screen and (max-width:799px) {
		.subpage_wrap.order_payment { display:block; width:auto; }
		.subpage_wrap.order_payment .subpage_container { display:block; padding:10px 0 40px; }
		.subpage_wrap.order_payment .subpage_container.v2 { display:block; padding:10px 0 40px; }
		.subpage_wrap.order_payment .order_payment_right { width:auto; padding-left:0; }
	}
</style>

<script type="text/javascript">
	function onlyNumber(obj) { $(obj).keyup(function(){ $(this).val($(this).val().replace(/[^0-9]/g,"")); }); }
</script>

<?php echo $TPL_VAR["is_file_facebook_tag"]?>



<div id="delivery_address_dialog" style="display:none;"></div><!--주소록-->
<div id="PromotionDialog" class="hide"></div>
<div id="couponDownloadDialog" style="display:none"></div>

<form name="orderFrm" id="orderFrm" method="post" action="cacluate" target="actionFrame">
	<input type="hidden" name="mode" value="<?php echo $TPL_VAR["mode"]?>" />
	<input type="hidden" name="order_version" value="2.0" />
	<input type="hidden" name="delivery_coupon" value="" />
	<input type="hidden" name="download_seq" id="download_seq" value="" />
	<input type="hidden" name="coupon_sale" id="shipping_coupon_sale" value="" />
	<input type="hidden" name="shipping_promotion_code_seq" id="shipping_promotion_code_seq" value="" />
	<input type="hidden" name="shipping_promotion_code_sale" id="shipping_promotion_code_sale" value="" />
	<input type="hidden" name="member_seq" id="member_seq" value="<?php echo $_GET["member_seq"]?>" />
	<input type="hidden" name="person_seq" id="person_seq" value="<?php echo $_GET["person_seq"]?>" />
	<input type="hidden" name="enuri" id="enuri" value="<?php echo $TPL_VAR["enuri"]?>" />
	<input type="hidden" name="is_goods" value="<?php echo $TPL_VAR["is_goods"]?>" />
	<input type="hidden" name="mobilenew" value="y" />

	<input type="hidden" name="ordersheet_coupon_download_seq" id="ordersheet_coupon_download_seq" value="" />

	<div class="subpage_wrap">
		<div class="subpage_container v3 Pb10">
			<!-- 타이틀 -->
			<div class="title_container Pb0">
				<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >주문/결제</span></h2>
			</div>
		</div>
	</div>


	<div id="orderPaymentLayout" class="subpage_wrap order_payment" data-ezmark="undo">
		<div class="subpage_container v2 Pt0 order_payment_left">
			<!-- 주문상품 :: START -->
			<h2 class="title_od1 Pt15"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >주문상품 정보</span></h2>
<?php if($TPL_VAR["shipping_group_list"]){?>
			<div class="cart_contents">
				<div class="cart_list">
<?php if($TPL_shipping_group_list_1){foreach($TPL_VAR["shipping_group_list"] as $TPL_K1=>$TPL_V1){?>
					<ul class="shipping_group_list <?php if($TPL_V1["cfg"]["baserule"]["shipping_set_code"]=='coupon'){?>coupon<?php }?>">
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;
$TPL_cart_suboptions_3=empty($TPL_V2["cart_suboptions"])||!is_array($TPL_V2["cart_suboptions"])?0:count($TPL_V2["cart_suboptions"]);?>
<?php if($TPL_I2== 0){?>
						<li class="goods_delivery_info clearbox">
							<ul class="detail">
								<li class="th">배송 :</li>
<?php if($TPL_V1["cfg"]["baserule"]["shipping_set_code"]=='coupon'){?>
								<li class="ticket"><?php if($TPL_V1["shipper_name"]){?><?php echo $TPL_V1["shipper_name"]?> - <?php }?>티켓배송</li>
<?php }else{?>
								<li class="silmul">
<?php if($TPL_V1["shipper_name"]){?>
									<span class="gray_01">[<?php echo $TPL_V1["shipper_name"]?>]</span>
<?php }?>
									<span><?php echo $TPL_V1["cfg"]["baserule"]["shipping_set_name"]?></span>

<?php if($TPL_V1["cfg"]["baserule"]["shipping_set_code"]!='direct_store'){?>
<?php if($TPL_V1["shipping_prepay_info"]=='delivery'){?>
									<span class="ship_info">(<?php echo getAlert('sy004')?>)</span>
<?php }else{?>
									<span class="ship_info">(<?php echo getAlert('sy003')?>)</span>
<?php }?>
<?php }?>

<?php if($TPL_V1["grp_shipping_price"]> 0){?>
									<span id="price_<?php echo $TPL_V1["shipping_group"]?>" class="grp_shipping_price_<?php echo $TPL_K1?>"><?php echo get_currency_price($TPL_V1["grp_shipping_price"], 2)?></span>
<?php }else{?>
<?php if($TPL_V1["ship_possible"]=='Y'){?>
									<span id="price_<?php echo $TPL_V1["shipping_group"]?>" class="grp_shipping_price_<?php echo $TPL_K1?>">무료</span>
<?php }else{?>
									<span id="price_<?php echo $TPL_V1["shipping_group"]?>" class="red grp_shipping_price_<?php echo $TPL_K1?>">배송불가</span>
<?php }?>
<?php }?>

									<div class="hope">
<?php if($TPL_V1["cfg"]["baserule"]["shipping_set_code"]=='direct_store'){?>
										<span class="ship_info">수령매장 <?php echo $TPL_V1["store_info"]["shipping_store_name"]?></span>
<?php }?>
<?php if($TPL_V1["shipping_hop_date"]){?>
										<span class="ship_info"><?php echo $TPL_V1["shipping_hop_date"]?> 배송</span>
<?php }elseif($TPL_V1["reserve_sdate"]){?>
										<span class="ship_info"><?php echo $TPL_V1["reserve_sdate"]?> 예약</span>
<?php }?>
									</div>
								</li>
								<li class="btn_area">
									<button type="button" class="btn_resp btn_shipping_modify" cart_seq="<?php echo $TPL_V2["cart_seq"]?>" prepay_info="<?php echo $TPL_V1["shipping_prepay_info"]?>" nation="<?php echo $TPL_V1["cfg"]["baserule"]["delivery_nation"]?>" goods_seq="<?php echo $TPL_V2["goods_seq"]?>" hop_date="<?php echo $TPL_V1["shipping_hop_date"]?>" person_seq="<?php echo $_GET["person_seq"]?>">배송 변경</button>
								</li>
<?php }?>
							</ul>
						</li>
<?php }?>

						<li class="cart_goods">
							<div class="cart_goods_detail">

								<div class="cgd_contents">
									<div class="block block1">
										<ul>
											<li class="img_area">
												<a href="../goods/view?no=<?php echo $TPL_V2["goods_seq"]?>" hrefOri='Li4vZ29vZHMvdmlldz9ubz17Li5nb29kc19zZXF9' ><img src="<?php echo $TPL_V2["image"]?>" class="goods_thumb" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage_list.gif'" designImgSrcOri='ey4uaW1hZ2V9' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==' designImgSrc='ey4uaW1hZ2V9' designElement='image' /></a>
											</li>
											<li class="option_area">

<?php if($TPL_V2["eventEnd"]){?>
												<div class="event_area">
												<span class="soloEventTd<?php echo $TPL_V2["cart_option_seq"]?>">
													<span class="title"></span>
													<span class="time">
														<span id="soloday<?php echo $TPL_V2["cart_option_seq"]?>">0</span>일
														<span id="solohour<?php echo $TPL_V2["cart_option_seq"]?>">00</span>:
														<span id="solomin<?php echo $TPL_V2["cart_option_seq"]?>">00</span>:
														<span id="solosecond<?php echo $TPL_V2["cart_option_seq"]?>">00</span>
													</span>
												</span>
													<script>
														$(function() {
															timeInterval<?php echo $TPL_V2["cart_option_seq"]?> = setInterval(function(){
																var time<?php echo $TPL_V2["cart_option_seq"]?> = showClockTime('text', '<?php echo $TPL_V2["eventEnd"]["year"]?>', '<?php echo $TPL_V2["eventEnd"]["month"]?>', '<?php echo $TPL_V2["eventEnd"]["day"]?>', '<?php echo $TPL_V2["eventEnd"]["hour"]?>', '<?php echo $TPL_V2["eventEnd"]["min"]?>', '<?php echo $TPL_V2["eventEnd"]["second"]?>', 'soloday<?php echo $TPL_V2["cart_option_seq"]?>', 'solohour<?php echo $TPL_V2["cart_option_seq"]?>', 'solomin<?php echo $TPL_V2["cart_option_seq"]?>', 'solosecond<?php echo $TPL_V2["cart_option_seq"]?>', '<?php echo $TPL_V2["cart_option_seq"]?>');
																if(time<?php echo $TPL_V2["cart_option_seq"]?> == 0){
																	clearInterval(timeInterval<?php echo $TPL_V2["cart_option_seq"]?>);
																	$(".soloEventTd<?php echo $TPL_V2["cart_option_seq"]?>").html("단독 이벤트 종료");
																}
															},1000);
														});
													</script>
												</div>
<?php }?>

												<div class="goods_name v2">
													<a href="../goods/view?no=<?php echo $TPL_V2["goods_seq"]?>" hrefOri='Li4vZ29vZHMvdmlldz9ubz17Li5nb29kc19zZXF9' ><?php echo $TPL_V2["goods_name"]?></a>
												</div>

<?php if($TPL_V2["adult_goods"]=='Y'||$TPL_V2["option_international_shipping_status"]=='y'||$TPL_V2["cancel_type"]=='1'||$TPL_V2["tax"]=='exempt'){?>
												<div class="icon_area">
<?php if($TPL_V2["adult_goods"]=='Y'){?>
													<img src="/data/skin/responsive_diary_petit_gl/images/common/auth_img.png" alt="성인" class="icon1" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9hdXRoX2ltZy5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vYXV0aF9pbWcucG5n' designElement='image' />
<?php }?>
<?php if($TPL_V2["option_international_shipping_status"]=='y'){?>
													<img src="/data/skin/responsive_diary_petit_gl/images/common/plane.png" alt="해외배송상품" class="icon2" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9wbGFuZS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vcGxhbmUucG5n' designElement='image' />
<?php }?>
<?php if($TPL_V2["cancel_type"]=='1'){?>
													<img src="/data/skin/responsive_diary_petit_gl/images/common/nocancellation.gif" alt="청약철회" class="icon3" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9ub2NhbmNlbGxhdGlvbi5naWY=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vbm9jYW5jZWxsYXRpb24uZ2lm' designElement='image' />
<?php }?>
<?php if($TPL_V2["tax"]=='exempt'){?>
													<img src="/data/skin/responsive_diary_petit_gl/images/common/taxfree.gif" alt="비과세" class="icon4" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi90YXhmcmVlLmdpZg==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vdGF4ZnJlZS5naWY=' designElement='image' />
<?php }?>
												</div>
<?php }?>

<?php if($TPL_V2["option1"]!=null){?>
												<ul class="cart_option">
<?php if($TPL_V2["option1"]){?>
													<li><?php if($TPL_V2["title1"]){?><span class="xtle"><?php echo $TPL_V2["title1"]?></span><?php }?> <?php echo $TPL_V2["option1"]?></li>
<?php }?>
<?php if($TPL_V2["option2"]){?>
													<li><?php if($TPL_V2["title2"]){?><span class="xtle"><?php echo $TPL_V2["title2"]?></span><?php }?> <?php echo $TPL_V2["option2"]?></li>
<?php }?>
<?php if($TPL_V2["option3"]){?>
													<li><?php if($TPL_V2["title3"]){?><span class="xtle"><?php echo $TPL_V2["title3"]?></span><?php }?> <?php echo $TPL_V2["option3"]?></li>
<?php }?>
<?php if($TPL_V2["option4"]){?>
													<li><?php if($TPL_V2["title4"]){?><span class="xtle"><?php echo $TPL_V2["title4"]?></span><?php }?> <?php echo $TPL_V2["option4"]?></li>
<?php }?>
<?php if($TPL_V2["option5"]){?>
													<li><?php if($TPL_V2["title5"]){?><span class="xtle"><?php echo $TPL_V2["title5"]?></span><?php }?> <?php echo $TPL_V2["option5"]?></li>
<?php }?>
												</ul>
<?php }?>

												<input type="hidden" name="coupon_download[<?php echo $TPL_V2["cart_seq"]?>][<?php echo $TPL_V2["cart_option_seq"]?>]" value="" />
												<input type="hidden" name="shippingcoupon_download[<?php echo $TPL_V2["shipping_group"]?>]" value="" />
												<div class="cart_quantity">
													<span class="xtle">수량</span> <?php echo number_format($TPL_V2["ea"])?>개
													<span class="add_txt">(<?php echo get_currency_price($TPL_V2["price"]*$TPL_V2["ea"], 2,'','<span class="cart_price_num">_str_price_</span>')?>)</span>
												</div>

<?php if($TPL_V2["cart_inputs"]){?>
												<ul class="cart_inputs">
<?php if(is_array($TPL_R3=$TPL_V2["cart_inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["input_value"]){?>
													<li>
<?php if($TPL_V3["type"]=='file'){?>
<?php if($TPL_V3["input_title"]){?><span class="xtle v2"><?php echo $TPL_V3["input_title"]?></span><?php }?>
														<a href="/mypage_process/filedown?file=<?php echo $TPL_V3["input_value"]?>" target="actionFrame" title="크게 보기" hrefOri='L215cGFnZV9wcm9jZXNzL2ZpbGVkb3duP2ZpbGU9ey4uLmlucHV0X3ZhbHVlfQ==' ><img src="/mypage_process/filedown?file=<?php echo $TPL_V3["input_value"]?>" class="inputed_img" designImgSrcOri='L215cGFnZV9wcm9jZXNzL2ZpbGVkb3duP2ZpbGU9ey4uLmlucHV0X3ZhbHVlfQ==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==' designImgSrc='L215cGFnZV9wcm9jZXNzL2ZpbGVkb3duP2ZpbGU9ey4uLmlucHV0X3ZhbHVlfQ==' designElement='image' /></a>
<?php }else{?>
<?php if($TPL_V3["input_title"]){?><span class="xtle v2"><?php echo $TPL_V3["input_title"]?></span><?php }?>
														<?php echo $TPL_V3["input_value"]?>

<?php }?>
													</li>
<?php }?>
<?php }}?>
												</ul>
<?php }?>

<?php if($TPL_V2["cart_suboptions"]){?>
												<ul class="cart_suboptions">
<?php if($TPL_cart_suboptions_3){foreach($TPL_V2["cart_suboptions"] as $TPL_V3){?>
													<li>
<?php if($TPL_V3["suboption"]){?>
<?php if($TPL_V3["suboption_title"]){?>
														<span class="xtle v3"><?php echo $TPL_V3["suboption_title"]?></span>
<?php }?>
														<?php echo $TPL_V3["suboption"]?>:
<?php }?>
														<?php echo number_format($TPL_V3["ea"])?>개
														<span class="add_txt">(<?php echo get_currency_price($TPL_V3["price"]*$TPL_V3["ea"], 2)?>)</span>
													</li>
<?php }}?>
												</ul>
<?php }?>
											</li>
										</ul>
									</div>

									<ul class="block block2 x1" id="mobile_cart_sale_tr_<?php echo $TPL_V2["cart_option_seq"]?>">
										<li class="price_a">
											<span class="ptitle">상품금액</span> <?php echo get_currency_price($TPL_V2["tot_price"], 2)?>

										</li>
										<li id="cart_sale_tr_<?php echo $TPL_V2["cart_option_seq"]?>" class="price_b">
											<span class="ptitle">할인금액</span>
											<div id="cart_option_sale_total_<?php echo $TPL_V2["cart_option_seq"]?>">
<?php if($TPL_V2["tot_sale_price"]> 0){?>
												<span class="desc">(-)</span> <span id="mobile_cart_sale_<?php echo $TPL_V2["cart_option_seq"]?>"><?php echo get_currency_price($TPL_V2["tot_sale_price"], 2)?></span>
<?php }else{?>
												-
<?php }?>
											</div>
											<div id="cart_option_sale_detail_<?php echo $TPL_V2["cart_option_seq"]?>" class="Relative <?php if($TPL_V2["sales"]["total_sale_price"]> 0){?>hide<?php }else{?>hide<?php }?>">
												<button type="button" class="detailDescriptionLayerBtn btn_resp size_a color5" style="position:absolute; left:54px; top:-18px;"">내역</button>
												<div class="detailDescriptionLayer hide" style="width:280px; right:0; top:5px;">
													<div class="layer_wrap">
														<h1>할인내역</h1>
														<div class="layer_inner">
															<table class="tbl_col" width="100%" border="0" cellpadding="0" cellspacing="0">
																<caption>할인내역</caption>
																<colgroup>
																	<col style="width:50%" /><col />
																</colgroup>
																<tbody>
<?php if(is_array($TPL_R3=$TPL_V2["sales"]["title_list"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
																<tr id="cart_option_<?php echo $TPL_K3?>_saletr_<?php echo $TPL_V2["cart_option_seq"]?>" <?php if($TPL_V2["sales"]["sale_list"][$TPL_K3]> 0){?><?php }else{?>class="hide"<?php }?>>
																	<th scope="row"><?php echo $TPL_V2["sales"]["title_list"][$TPL_K3]?></th>
																	<td class="bolds ends prices">
																		<?php echo get_currency_price($TPL_V2["sales"]["sale_list"][$TPL_K3], 2,'','<span id="cart_option_'.$TPL_K3.'_saleprice_'.$TPL_V2["cart_option_seq"].'">_str_price_</span>')?>

																	</td>
																</tr>
<?php }}?>
																</tbody>
															</table>
														</div>
														<a href="javascript:;" class="detailDescriptionLayerCloseBtn" hrefOri='amF2YXNjcmlwdDo7' ></a>
													</div>
												</div>
											</div>

										</li>
										<li class="price_c">
											<span class="ptitle">할인적용금액</span>
											<span class="total_p"><?php echo get_currency_price($TPL_V2["tot_result_price"], 2,'','<span id="option_suboption_price_sum_'.$TPL_V2["cart_option_seq"].'">_str_price_</span>')?></span>
										</li>
									</ul>
								</div>
							</div>
						</li>
<?php }}?>
					</ul>
<?php }}?>
				</div>
			</div>
<?php }?>
			<!-- 주문상품 :: END -->

			<!-- 사은품 :: START -->
<?php if($TPL_VAR["gift_cnt"]> 0){?>
			<div class="order_subsection">
				<input type="hidden" name="gift_use" id="gift_use_Y" value="Y" />
				<h3 class="title1">사은품<span id="total_gift_ea" class="desc hide">( <?php echo number_format($TPL_VAR["gift_goods_cnt"])?>개 )</span></h3>
				<div class="contents">
<?php if($TPL_gloop_1){foreach($TPL_VAR["gloop"] as $TPL_V1){?>
					<input type="hidden" name="gifts[]" value="<?php echo $TPL_V1["gift_seq"]?>"/>
					<input type="hidden" name="gifts_provider[]" value="<?php echo $TPL_V1["provider_seq"]?>"/>
					<h4 class="title2 gift_name_<?php echo $TPL_V1["gift_seq"]?>"><?php echo $TPL_V1["title"]?></h4>
					<ul class="list1">
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
						<li>
<?php if(get_gift_image($TPL_V2,'list1')){?>
							<img class="img1" src="<?php echo get_gift_image($TPL_V2,'list1')?>" alt="" designImgSrcOri='ez1nZXRfZ2lmdF9pbWFnZSguLnZhbHVlXyw=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==' designImgSrc='ez1nZXRfZ2lmdF9pbWFnZSguLnZhbHVlXyw=' designElement='image' />
<?php }?>
							<label class="label1"><?php if($TPL_V1["gift_rule"]!="lot"){?><input type="<?php if($TPL_V1["ea"]> 1){?>checkbox<?php }else{?>radio<?php }?>" name="gift_<?php echo $TPL_V1["gift_seq"]?>[]" value="<?php echo $TPL_V2?>"  <?php if($TPL_V1["ea"]> 1){?> onclick="limit_chk('<?php echo $TPL_V1["gift_seq"]?>', this)"<?php }?> <?php if($TPL_I2== 0){?>checked<?php }?>> <?php }?><?php echo get_gift_name($TPL_V2)?></label>
						</li>
<?php }}?>
					</ul>
					<input type="hidden" name="gift_<?php echo $TPL_V1["gift_seq"]?>_limit" value="<?php echo $TPL_V1["ea"]?>">
<?php }}?>
				</div>
			</div>
<?php }?>
			<!-- 사은품 :: END -->

			<div id="facebook_mgs"><div style="padding:10px"><?php if($TPL_VAR["is_file_facebook_tag"]){?>페이스북과 정보를 교환 중에 있습니다. 잠시만 기다려 주세요.<?php }?></div></div>
			<!-- //페이스북 -->


			<div class="order_subsection v2">
				<!-- ++++++++++++++++++++ 주문자 :: START ++++++++++++++++++++ -->
				<h3 class="title3"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >주문자</span></h3>
<?php if($TPL_VAR["members"]){?>
				<ul id="order_info" class="list_01 v2">
					<li>
						<span class="name1"><?php echo $TPL_VAR["members"]["user_name"]?></span> &nbsp;
						<button type="button" id="orderInfoModify" class="btn_resp Mt-2" onclick="$('#order_info_input').show(); $('#order_info').hide(); address_modify('order');">수정</button>
					</li>
					<li>
						<span class="phone1"><?php echo $TPL_VAR["members"]["cellphone"]?></span> <span class="gray_06">&nbsp;/&nbsp;</span>
						<span class="phone2"><?php echo $TPL_VAR["members"]["phone"]?></span>
					</li>
					<li class="hide"><span class="email1"><?php echo $TPL_VAR["members"]["email"]?></span></li>
				</ul>
<?php }?>

				<div id="order_info_input" class="<?php if($TPL_VAR["members"]["order_info_full"]){?>hide<?php }?>">
					<input type="hidden" name="order_post_number" value="<?php echo $TPL_VAR["members"]["post_number"]?>" />
					<input type="hidden" name="order_zipcode[]" value="<?php echo $TPL_VAR["members"]["zipcode"]?>" />
					<input type="hidden" name="order_address_type" value="<?php echo $TPL_VAR["members"]["order_address_type"]?>" />
					<input type="hidden" name="order_address" value="<?php echo $TPL_VAR["members"]["address"]?>" />
					<input type="hidden" name="order_address_street" value="<?php echo $TPL_VAR["members"]["address_street"]?>" />
					<input type="hidden" name="order_address_detail" value="<?php echo $TPL_VAR["members"]["address_detail"]?>" />
					<!-- 회원일 경우 :: START -->
					<div class="order_info_member">
						<ul class="list_01 v2">
							<li class="order_user_name"><?php if($TPL_VAR["members"]["user_name"]){?><?php echo $TPL_VAR["members"]["user_name"]?><?php }else{?>주문자명 없음<?php }?></li>
							<li class="order_phone"><?php if($TPL_VAR["members"]["cellphone"]){?><?php echo $TPL_VAR["members"]["cellphone"]?><?php }else{?>휴대폰번호 없음<?php }?> / <?php if($TPL_VAR["members"]["phone"]){?><?php echo $TPL_VAR["members"]["phone"]?><?php }else{?>추가연락처 없음<?php }?></li>
							<li class="order_email"><?php if($TPL_VAR["members"]["email"]){?><?php echo $TPL_VAR["members"]["email"]?><?php }else{?>이메일 없음<?php }?></li>
						</ul>
						<button type="button" class="settle_chg_wrap btn_resp" onclick="address_modify('order');">수정</button>
					</div>
					<!-- 회원일 경우 :: END -->
					<!-- 주문자 정보 입력 란 :: START -->
					<div class="order_info_input hide">
						<ul class="list_01 v2">
							<li><input type="text" name="order_user_name" value="<?php echo $TPL_VAR["members"]["user_name"]?>" class="pilsu" style="width:170px;" title="<?php echo getAlert('os047')?>" <?php if($TPL_VAR["members"]["rute"]=='none'&&$TPL_VAR["members"]["user_name"]){?>readonly<?php }?> required />
								<!--<button type="button" class="btn_resp size_b" onclick="copy_delivery_info();">배송지 정보와 동일</button></li>-->
							<li>
								<input type="tel" name="order_cellphone[]" value="<?php echo $TPL_VAR["members"]["cellphone1"]?>" class="pilsu" style="width:64px;" onkeydown="onlyNumber(this)" title="휴대폰" valid="<?php echo getAlert('os049')?>" required /> -
								<input type="tel" name="order_cellphone[]" value="<?php echo $TPL_VAR["members"]["cellphone2"]?>" class="pilsu size_phone" onkeydown="onlyNumber(this)" valid="<?php echo getAlert('os049')?>" required /> -
								<input type="tel" name="order_cellphone[]" value="<?php echo $TPL_VAR["members"]["cellphone3"]?>" class="pilsu size_phone" onkeydown="onlyNumber(this)" valid="<?php echo getAlert('os049')?>" required />
							</li>
							<li>
								<input type="tel" name="order_phone[]" value="<?php echo $TPL_VAR["members"]["phone1"]?>" style="width:64px;" onkeydown="onlyNumber(this)" title="연락처2" valid="<?php echo getAlert('os048')?>" /> -
								<input type="tel" name="order_phone[]" value="<?php echo $TPL_VAR["members"]["phone2"]?>" class="size_phone" onkeydown="onlyNumber(this)" valid="<?php echo getAlert('os048')?>" /> -
								<input type="tel" name="order_phone[]" value="<?php echo $TPL_VAR["members"]["phone3"]?>" class="size_phone" onkeydown="onlyNumber(this)" valid="<?php echo getAlert('os048')?>" />
								<span class="desc">(선택)</span>
							</li>
							<li><input type="email" name="order_email" value="<?php echo $TPL_VAR["members"]["email"]?>" class="pilsu size_email_full" title="<?php echo getAlert('os050')?>" required /></li>
						</ul>
					</div>
					<!-- 주문자 정보 입력 란 :: END -->
<?php if(!$TPL_VAR["userInfo"]["member_seq"]){?>
					<ul class="list_dot_01 Pt10 gray_06 hide">
						<li>비회원은 주문번호와 이메일로 주문배송조회가 가능합니다.</li>
						<li>구매내역을 이메일과 SMS로 안내해 드립니다.</li>
						<li>정확한 휴대폰번호와 이메일을 입력해 주십시오.</li>
					</ul>
<?php }?>
				</div>
				<!-- ++++++++++++++++++++ 주문자 :: END ++++++++++++++++++++ -->
				<br>
				<!--다크비 이벤트 영역, 완료 되면 해당 부분 코드 2120으로 변경 필요-->
<?php if($TPL_shipping_group_list_1){foreach($TPL_VAR["shipping_group_list"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<? if ( $TPL_V1["goods"][ 0]['goods_seq'] == '2120') { ?>
					<p style="font-weight:bold; color:red; font-size:22px;">배송 메시지 입력란에 다크비 팬 사인회 당첨자 정보도 같이 기입바랍니다.</p>
                    <span style="color:red; font-size:16px;">ex) 문앞에 부탁드려요.   홍길동/950101/010-1234-1234</span>
				<? } ?>
<?php }}?>
<?php }}?>

				<!-- ++++++++++++++++++++ 배송지 :: START ++++++++++++++++++++ -->
				<h3 class="title3"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >배송지</span></h3>

				<!-- 회원관련 배송정보 -->
				<div class="recipient delivery_info_member">
					<!-- 최종 배송지 :: START -->
					<div class="real_delivery hide">
						<div class="real_delivery_area">
							<ul>
								<!-- 국내 -->
								<li><input type="text" name="recipient_user_name" value="<?php echo $TPL_VAR["members"]["default_address"]["user_name"]?>"  class="inputbox_large wid100"  title="<?php echo getAlert('os055')?>" required/>
								</li>
								<li class="goods_delivery_info">
									<input type="text" name="recipient_new_zipcode" value="<?php echo $TPL_VAR["members"]["default_address"]["zipcode"]?>" class="inputbox_large"   title="<?php echo getAlert('os052')?>" required/>
									<input type="hidden" name="recipient_address_type" value="<?php echo $TPL_VAR["members"]["default_address"]["address_type"]?>" class="inputbox_large wid100"   title="배송지 주소지타입(도로명/지번)" />
									<input type="text" name="recipient_address_street" value="<?php echo $TPL_VAR["members"]["default_address"]["address_street"]?>" title="배송지 도로명 주소" readonly/>
									<input type="text" name="recipient_address" value="<?php echo $TPL_VAR["members"]["default_address"]["address"]?>" title="<?php echo getAlert('os053')?>" required readonly/>
									<input type="text" name="recipient_address_detail" value="<?php echo $TPL_VAR["members"]["default_address"]["address_detail"]?>" title="<?php echo getAlert('os054')?>" required/>
								</li>
								<li class="domestic hide">
									<div class="phone_num1"><?php echo getAlert('os056')?></div>
									<div class="phone_num2">
										<input type="text" name="recipient_phone[]" value="<?php echo $TPL_VAR["members"]["default_address"]["phone1"]?>" class="inputbox_large" onkeydown="onlyNumber(this)" /> -
										<input type="text" name="recipient_phone[]" value="<?php echo $TPL_VAR["members"]["default_address"]["phone2"]?>" class="inputbox_large" onkeydown="onlyNumber(this)" /> -
										<input type="text" name="recipient_phone[]" value="<?php echo $TPL_VAR["members"]["default_address"]["phone3"]?>" class="inputbox_large" onkeydown="onlyNumber(this)" />
									</div>
								</li>
								<li class="domestic hide">
									<div class="phone_num1"><?php echo getAlert('os057')?></div>
									<div class="phone_num2">
										<input type="text" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["members"]["default_address"]["cellphone1"]?>" class="inputbox_large" onkeydown="onlyNumber(this)" valid="휴대폰" /> -
										<input type="text" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["members"]["default_address"]["cellphone2"]?>" class="inputbox_large" onkeydown="onlyNumber(this)" valid="휴대폰" /> -
										<input type="text" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["members"]["default_address"]["cellphone3"]?>" class="inputbox_large" onkeydown="onlyNumber(this)" valid="휴대폰" />
									</div>
								</li>
								<!-- 해외 -->
								<li class="international hide goods_delivery_info">
									<input type="text" name="international_address" value="" title="<?php echo getAlert('os058')?>" required/>
									<input type="text" name="international_town_city" value="" title="<?php echo getAlert('os059')?>" required/>
									<input type="text" name="international_county" value="" title="<?php echo getAlert('os060')?>" required/>
									<input type="text" name="international_postcode" value="" title="<?php echo getAlert('os052')?>" required/>
									<input type="text" class="hide" name="international_country" value="" title="<?php echo getAlert('os061')?>" required/>
								</li>
								<li class="international hide">
									<div class="phone_num1"><?php echo getAlert('os056')?></div>
									<div class="phone_num2">
										<input type="text" name="international_recipient_phone[]" value="" class="inputbox_large" onkeydown="onlyNumber(this)" /> -
										<input type="text" name="international_recipient_phone[]" value="" class="inputbox_large" onkeydown="onlyNumber(this)" /> -
										<input type="text" name="international_recipient_phone[]" value="" class="inputbox_large" onkeydown="onlyNumber(this)" />
									</div>
								</li>
								<li class="international hide">
									<div class="phone_num1"><?php echo getAlert('os057')?></div>
									<div class="phone_num2">
										<input type="text" name="international_recipient_cellphone[]" value="" class="inputbox_large" onkeydown="onlyNumber(this)" valid="휴대폰" /> -
										<input type="text" name="international_recipient_cellphone[]" value="" class="inputbox_large" onkeydown="onlyNumber(this)" valid="휴대폰" /> -
										<input type="text" name="international_recipient_cellphone[]" value="" class="inputbox_large" onkeydown="onlyNumber(this)" valid="휴대폰" />
									</div>
								</li>
							</ul>
						</div>
					</div>
					<!-- 최종 배송지 :: END -->

					<!-- 회원 배송지 VIEW :: START -->
					<div class="delivery_info">
						<ul class="list_01 v2">
							<!-- 받는분 -->
							<li class="user_name_area">
								<span class="recipient_user_name pointcolor imp"><?php echo $TPL_VAR["members"]["default_address"]["user_name"]?></span>
<?php if($TPL_VAR["members"]){?>&nbsp; <button type="button" class="btn_resp Mt-2" onclick="address_modify('delivery'); $('.settle_tab>li').eq(0).trigger('click');">다른배송지 선택</button><?php }?>
								<button type="button" class="btn_resp Mt-2" onclick="address_modify('delivery');">수정</button>
							</li>
							<!-- 주소 -->
							<li <?php if(!$TPL_VAR["is_goods"]){?>class="hide"<?php }?> >
<?php if($TPL_VAR["members"]["default_address"]["zipcode"]){?>
							<span class="kr_zipcode">[<span class="recipient_zipcode"><?php echo $TPL_VAR["members"]["default_address"]["zipcode"]?></span>]</span>
							<span class="recipient_address">
<?php if($TPL_VAR["members"]["default_address"]["address_type"]=='street'){?>
								<?php echo $TPL_VAR["members"]["default_address"]["address_street"]?>

<?php }else{?>
								<?php echo $TPL_VAR["members"]["default_address"]["address"]?>

<?php }?>
							</span>
							<span class="recipient_address_detail"><?php echo $TPL_VAR["members"]["default_address"]["address_detail"]?></span>
<?php }else{?>
							<span class="kr_zipcode hide">[<span class="recipient_zipcode"></span>]</span> <span class="recipient_address">배송주소 없음</span> <span class="recipient_address_detail"></span>
<?php }?>
							</li>
							<!-- 연락처 -->
							<li>
								<span class="cellphone"><?php if($TPL_VAR["members"]["default_address"]["cellphone"]){?><?php echo $TPL_VAR["members"]["default_address"]["cellphone"]?><?php }else{?>휴대폰번호 없음<?php }?></span>
								<span class="gray_07">&nbsp;/&nbsp;</span>
								<span class="phone"><?php if($TPL_VAR["members"]["default_address"]["phone"]){?><?php echo $TPL_VAR["members"]["default_address"]["phone"]?><?php }else{?>추가연락처 없음<?php }?></span>
							</li>
							<!-- 이메일 -->
							<li <?php if(!$TPL_VAR["is_coupon"]){?>class="hide"<?php }?>>
							<?php echo $TPL_VAR["members"]["email"]?>

							</li>
							<!-- 배송국가 -->
							<li class="nation_section <?php if(!$TPL_VAR["is_goods"]){?>hide<?php }?>" >
								배송국가 및 지역 : <span class="international_nation"><?php echo $TPL_VAR["ini_info"]["kr_nation"]?></span>
								<input type="hidden" id="address_nation" name="address_nation" value="<?php echo $TPL_VAR["ini_info"]["nation"]?>" />
								<input type="hidden" id="address_nation_key" name="address_nation_key" value="<?php echo $TPL_VAR["ini_info"]["nation_key"]?>" />
							</li>
							<!-- 기타 안내 :: START -->
							<li class="desc <?php if(!$TPL_VAR["is_direct_store"]){?>hide<?php }?>">
								※ 매장수령상품은 매장에서 상품을 수령하세요.
							</li>
							<li class="desc <?php if(!$TPL_VAR["is_coupon"]){?>hide<?php }?>">
								※ 티켓번호는 문자와 이메일로 보내 드립니다.
							</li>
							<!-- 기타 안내 :: END -->
						</ul>
					</div>
					<!-- 회원 배송지 VIEW :: END -->
				</div>

				<!-- 받는분 정보 입력 란 -->
				<div class="delivery_selecter delivery_info_input hide">
<?php if($TPL_VAR["members"]){?>
					<ul class="settle_tab delivery_choice clearbox">
						<li><a href="javascript:;" hrefOri='amF2YXNjcmlwdDo7' >선택</a></li>
						<li class="input_tab"><a href="javascript:;" hrefOri='amF2YXNjcmlwdDo7' >신규/수정</a></li>
					</ul>
					<div class="settle_tab_contents tab_box1 delivery_often">
						<!-- 다른 배송지 목록. 파일위치 : [스킨폴더]/order/pop_delivery_address.html -->
					</div>
<?php }?>

					<!-- 배송불가 MSG :: START -->
					<div class="ship_possible <?php if(!$TPL_VAR["ship_possible"]){?>hide<?php }?>">
						<input type="hidden" id="ship_possible" name="ship_possible" value="<?php if($TPL_VAR["ship_possible"]){?>N<?php }?>" />
						아래의 국가(<span class="kr_nation bold international_nation"><?php echo $TPL_VAR["ini_info"]["kr_nation"]?></span>)로 배송이 불가능한 상품이 있습니다.<br />
						장바구니에서 주문 상품을 변경해 주세요.
						<button type="button" class="btn_resp pointcolor imp" onclick="location='/order/cart'">장바구니로 돌아가기</button>
					</div>
					<!-- 배송불가 MSG :: END -->

					<div class="settle_tab_contents tab_box2 delivery_input" style="display:none">
						<ul class="list_01 v2">
							<!-- 받는분 -->
							<li>
								<input type="text" name="recipient_input_user_name" class="pilsu" style="width:170px;" value="<?php echo $TPL_VAR["members"]["default_address"]["user_name"]?>" title="<?php echo getAlert('os055')?>" required />
								<button type="button" class="btn_resp size_b color5" onclick="copy_order_info(); input_pilsu_check();">주문자 정보와 동일</button>
							</li>
							<!-- 국내 -->
							<li class="domestic goods_delivery_info <?php if(!$TPL_VAR["is_goods"]){?>hide<?php }?>">
								<input type="hidden" name="recipient_input_address_type" value="<?php echo $TPL_VAR["members"]["default_address"]["address_type"]?>" class="hide" title="<?php echo getAlert('os052')?>" />
								<input type="text" name="recipient_input_new_zipcode" value="<?php echo $TPL_VAR["members"]["default_address"]["zipcode"]?>" title="<?php echo getAlert('os052')?>" class="pilsu size_zip_all" readonly required />
								<button type="button" class="btn_resp size_b color4" onclick="openDialogZipcode_resp('morder');">검색</button>
							</li>
							<li class="domestic goods_delivery_info <?php if(!$TPL_VAR["is_goods"]){?>hide<?php }?>">
								<input type="text" name="recipient_input_address_street" value="<?php echo $TPL_VAR["members"]["default_address"]["address_street"]?>" class="pilsu size_address hide" title="도로명 주소" readonly />
								<input type="text" name="recipient_input_address" value="<?php echo $TPL_VAR["members"]["default_address"]["address"]?>" class="pilsu size_address" title="<?php echo getAlert('os053')?>" readonly />
							</li>
							<li class="domestic goods_delivery_info <?php if(!$TPL_VAR["is_goods"]){?>hide<?php }?>">
								<input type="text" name="recipient_input_address_detail" value="<?php echo $TPL_VAR["members"]["default_address"]["address_detail"]?>" class="pilsu size_address" title="<?php echo getAlert('os054')?>" required />
							</li>
							<!-- 해외 -->
							<li class="international goods_delivery_info hide">
								<input type="text" name="international_address_input" class="pilsu size_full" value="" title="<?php echo getAlert('os058')?>" required />
							</li>
							<li class="international goods_delivery_info hide">
								<input type="text" name="international_town_city_input" class="pilsu size_full" value="" title="<?php echo getAlert('os059')?>" required />
							</li>
							<li class="international goods_delivery_info hide">
								<input type="text" name="international_county_input" class="pilsu size_full" value="" title="<?php echo getAlert('os060')?>" required />
							</li>
							<li class="international goods_delivery_info hide">
								<input type="text" name="international_postcode_input" class="pilsu" style="width:100px;" value="" title="<?php echo getAlert('os052')?>" required />
							</li>
							<li class="hide">
								<input type="text" name="international_country_input" class="pilsu" value="" title="<?php echo getAlert('os061')?>" required />
							</li>
							<!-- 연락처 -->
							<li>
								<input type="tel" name="recipient_input_cellphone[]" value="<?php echo $TPL_VAR["members"]["default_address"]["cellphone1"]?>" class="pilsu" style="width:64px;" onkeydown="onlyNumber(this)" title="휴대폰" valid="<?php echo getAlert('os057')?>" required /> -
								<input type="tel" name="recipient_input_cellphone[]" value="<?php echo $TPL_VAR["members"]["default_address"]["cellphone2"]?>" class="pilsu size_phone" onkeydown="onlyNumber(this)" valid="<?php echo getAlert('os057')?>" required /> -
								<input type="tel" name="recipient_input_cellphone[]" value="<?php echo $TPL_VAR["members"]["default_address"]["cellphone3"]?>" class="pilsu size_phone" onkeydown="onlyNumber(this)" valid="<?php echo getAlert('os057')?>" required />
							</li>
							<li>
								<input type="tel" name="recipient_input_phone[]" value="<?php echo $TPL_VAR["members"]["default_address"]["phone1"]?>" style="width:64px;" onkeydown="onlyNumber(this)" title="연락처2" valid="<?php echo getAlert('os056')?>" /> -
								<input type="tel" name="recipient_input_phone[]" value="<?php echo $TPL_VAR["members"]["default_address"]["phone2"]?>" class="size_phone" onkeydown="onlyNumber(this)" valid="<?php echo getAlert('os056')?>" /> -
								<input type="tel" name="recipient_input_phone[]" value="<?php echo $TPL_VAR["members"]["default_address"]["phone3"]?>" class="size_phone" onkeydown="onlyNumber(this)" valid="<?php echo getAlert('os056')?>" />
								<span class="desc">(선택)</span>
							</li>
							<!-- 이메일 -->
							<li <?php if(!$TPL_VAR["is_coupon"]){?>class="hide"<?php }?>>
							<input type="email" name="recipient_email" value="<?php echo $TPL_VAR["members"]["email"]?>" class="size_email_full" title="<?php echo getAlert('os050')?>" />
							</li>
							<!-- 배송국가 -->
							<li <?php if(!$TPL_VAR["is_goods"]){?>class="hide"<?php }?>>
							<input type="hidden" name="address_group_input" value="" />
							<span class="international_nation">대한민국</span> &nbsp;
							<button type="button" class="btn_resp gray_05" onclick="showCenterLayer('.nation')">다른국가 및 지역선택</button>
							</li>

							<!-- 기타 안내 :: START -->
							<li class="desc <?php if(!$TPL_VAR["is_direct_store"]){?>hide<?php }?>">
								※ 매장수령상품은 매장에서 상품을 수령하세요.
							</li>
							<li class="desc <?php if(!$TPL_VAR["is_coupon"]){?>hide<?php }?>">
								※ 티켓번호는 문자와 이메일로 보내 드립니다.
							</li>
							<!-- 기타 안내 :: END -->

<?php if($TPL_VAR["members"]){?>
							<li class="Pt10">
								<label><input type="checkbox" name="save_delivery_address" value="1" /> 배송주소록에 기본배송지로 저장</label>
							</li>
							<li>
								<label><input type="checkbox" name="save_delivery_address_often" value="1" /> 배송주소록에 저장</label>
							</li>
<?php }?>
						</ul>
					</div>
				</div>

				<!-- 배송 메세지 -->
				<div id="shipMessage" class="ship_message">

					<!-- 여기 -->

					<!--다크비 이벤트 영역, 완료 되면 해당 부분 코드 2120으로 변경 필요-->
<?php if($TPL_shipping_group_list_1){foreach($TPL_VAR["shipping_group_list"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<? if ( $TPL_V1["goods"][ 0]['goods_seq'] == '2120') { ?>
						<input type="text" class="ship_message_txt" name="memo" id="memo" value="" title="배송 메세지 입력     홍길동 / 950101 / 010-1234-1234" autocomplete="off" />
					<? } else {  ?>
						<input type="text" class="ship_message_txt" name="memo" id="memo" value="" title="배송 메세지 입력" autocomplete="off" />
					<? } ?>
<?php }}?>
<?php }}?>
					<ul class="add_message">
						<li>부재시 경비실에 맡겨 주세요.</li>
						<li>부재시 전화 주시거나 문자 남겨 주세요.</li>
						<li>배송 전에 미리 연락해 주세요.</li>
<?php if($TPL_VAR["lately_msg"]){?>
<?php if($TPL_lately_msg_1){foreach($TPL_VAR["lately_msg"] as $TPL_V1){?>
						<li><span class="lately desc">(최근) </span><?php echo $TPL_V1["ship_message"]?></li>
<?php }}?>
<?php }?>
					</ul>
				</div>
				<!-- ++++++++++++++++++++ 배송지 :: END ++++++++++++++++++++ -->

				<!-- 해외 배송 약관/통관고유부호. 파일위치 : [스킨폴더]/order/_international_shipping.html -->
<?php if($TPL_VAR["is_international_shipping"]){?>
<?php $this->print_("international_shipping",$TPL_SCP,1);?>

<?php }?>


				<!-- ++++++++++++++++++++ 할인 :: START ++++++++++++++++++++ -->
				<h3 class="title3"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >할인</span></h3>
				<ul class="list_01 v2">
<?php if($_GET["person_seq"]==""){?>
<?php if($TPL_VAR["members"]){?>
					<li>
						<span class="od_sale_title">할인쿠폰</span>
						<span class="od_sale_price">
						<?php echo get_currency_price( 0, 2,'','<span id="total_coupon_sale" class="save">_str_price_</span>')?>

					</span>
						<button type="button" id="coupon_apply" class="btn_resp">쿠폰사용</button>
						(보유 <span class="bold gray_01"><?php echo number_format($TPL_VAR["member_usable_coupons"])?>장</span>)
					</li>
<?php }?>
<?php }?>

<?php if(serviceLimit('H_NFR')&&$TPL_VAR["isplusfreenot"]["ispromotioncode"]&&$_GET["person_seq"]==""){?>
					<li>
						<span class="od_sale_title">할인코드</span>
						<span class="od_sale_price">
						<?php echo get_currency_price( 0, 2,'','<span id="total_promotion_goods_sale" class="save"></span>')?>

					</span>
						<input type="text" name="cartpromotioncode" id="cartpromotioncode" value="<?php echo $TPL_VAR["cart_promotioncode"]?>" class="save hsize_b" style="width:64px;" />
						<span class="cartpromotioncodeinputlay" <?php if($TPL_VAR["cart_promotioncode"]){?>style="display:none;"<?php }?>><button type="button" onclick="getPromotionck(); return false;" class="btn_resp">코드입력</button></span>
						<span class="cartpromotioncodedellay" <?php if(!$TPL_VAR["cart_promotioncode"]){?>style="display:none;"<?php }?>><button type="button" onclick="getPromotionCartDel(); return false;" class="btn_move small">초기화</button></span>
					</li>
<?php }?>

<?php if(!$_GET["person_seq"]||($_GET["person_seq"]> 0&&$TPL_VAR["person_use_reserve"])){?>
<?php if($TPL_VAR["members"]){?>
					<li>
						<span class="od_sale_title">캐시</span>
						<span class="od_sale_price">
						<?php echo get_currency_price( 0, 2,'','<input type="text" name="emoney_view" class="onlyfloat save hsize_b od_m_box" style="width:64px;" value="_str_price_" />')?>

					</span>
						<input type="hidden" name="emoney" value="0"/>
						<input type="hidden" name="emoney_all" value=""/>
						<button type="button" class="emoney_input_button btn_resp" onclick="use_emoney(); return false;">사용</button>
						<button type="button" class="emoney_all_input_button btn_resp" onclick="use_all_emoney(); return false;">모두사용</button>
						<button type="button" class="emoney_cancel_button btn_resp" style="display:none" onclick="cancel_emoney(); return false;">초기화</button>
						<span class="Dib">(보유 <span class="bold gray_01"><?php echo get_currency_price($TPL_VAR["members"]["emoney"], 2)?></span>)</span>

					</li>
<?php }?>
<?php }?>

<?php if($TPL_VAR["members"]&&$TPL_VAR["cfg_reserve"]["cash_use"]=='Y'){?>
					<li>
						<span class="od_sale_title">예치금</span>
						<span class="od_sale_price">
						<?php echo get_currency_price( 0, 2,'','<input type="text" name="cash_view" class="onlyfloat save hsize_b od_m_box" style="width:64px;" value="_str_price_" />')?>

					</span>
						<input type="hidden" name="cash" value="0"/>
						<input type="hidden" name="cash_all" value=""/>
						<button type="button" class="cash_input_button btn_resp" onclick="use_cash(); return false;">사용</button>
						<button type="button" class="cash_all_input_button btn_resp" onclick="use_all_cash(); return false;">모두사용</button>
						<button  type="button" class="cash_cancel_button btn_resp" style="display:none" onclick="cancel_cash(); return false;">초기화</button>
						<span class="Dib">(보유 <span class="bold gray_01"><?php echo get_currency_price(get_member_money('cash',$TPL_VAR["userInfo"]["member_seq"]), 2)?></span>)</span>
					</li>
<?php }?>

				</ul>
				<!-- ++++++++++++++++++++ 할인 :: END ++++++++++++++++++++ -->

			</div>
		</div>


		<div class="subpage_container v2 Pt0 order_payment_right">
			<div class="order_subsection v2 ">
				<div class="right_flying_wrap1">
					<div class="right_flying_wrap2">
						<div class="right_flying_wrap3">
							<!-- ++++++++++++++++++++ 결제 금액 :: START ++++++++++++++++++++ -->
							<h3 class="title3 Pt15"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >결제 금액</span></h3>
							<div class="order_price_total">
								<ul>
									<li class="th"><span class="gray_01 Fs17" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >상품금액</span></li>
									<li class="td"><?php echo get_currency_price($TPL_VAR["total"], 2,'','<span id="total_goods_price" class="v2 gray_01">_str_price_</span>')?></li>
								</ul>
								<ul>
									<li class="th">
										<span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >배송비</span>&nbsp;
										<button type="button" class="btn_resp size_a gray_05" onclick="showCenterLayer('#besongDetailList')"><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >내역</span></button>
									</li>
									<li class="td">
										(+) <?php echo get_currency_price($TPL_VAR["total_shipping_price"], 2,'','<span class="total_delivery_shipping_price">_str_price_</span>')?>

									</li>
								</ul>
								<ul>
									<li class="th">
										<span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >할인금액</span>&nbsp;
										<button type="button" class="btn_resp size_a gray_05" onclick="showCenterLayer('#saleDetailList')"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >내역</span></button>
									</li>
									<li class="td pointcolor3">
										<span>(-)</span>
										<?php echo get_currency_price($TPL_VAR["total_sale"], 2,'','<span class="total_sales_price">_str_price_</span>')?>

									</li>
								</ul>
<?php if($TPL_VAR["members"]){?>
								<ul>
									<li class="th"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >캐시 사용</span></li>
									<li class="td pointcolor3">
										<span>(-)</span>
										<?php echo get_currency_price( 0, 2,'','<span id="use_emoney">_str_price_</span>')?>

									</li>
								</ul>
<?php if($TPL_VAR["cfg_reserve"]["cash_use"]=='Y'){?>
								<ul>
									<li class="th"><span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >예치금 사용</span></li>
									<li class="td pointcolor3">
										(-)
										<?php echo get_currency_price( 0, 2,'','<span id="use_cash">_str_price_</span>')?>

									</li>
								</ul>
<?php }?>
<?php }?>
								<ul class="total">
									<li class="th"><span designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >최종 결제금액</span></li>
									<li class="td">
										<span class="price"><?php echo get_currency_price($TPL_VAR["total_price"], 2,'','<span class="settle_price">_str_price_</span>')?></span>
<?php if($TPL_VAR["total_price_compare"]){?>
										<span class="settle_price_compare total_result_price gray_05"><?php echo $TPL_VAR["total_price_compare"]?></span>
<?php }?>
									</li>
								</ul>
							</div>

<?php if($TPL_VAR["members"]){?>
							<p class="od_sale_title2"><span designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >예상적립 혜택</span></p>
							<ul class="list_dot_01">
								<li>
<?php if($TPL_VAR["cfg"]["order"]["buy_confirm_use"]){?>
									구매확정 시,
<?php }else{?>
									배송완료 시,
<?php }?>
									<span class="Dib">
									캐시 최대 <?php echo get_currency_price($TPL_VAR["total_reserve"], 2,'','<strong id="total_reserve" class="gray_01">_str_price_</strong>')?>

<?php if(serviceLimit('H_NFR')&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>, 포인트 <strong id="total_point" class="gray_01"><?php echo number_format($TPL_VAR["total_point"])?></strong>P<?php }?>
								</span>
								</li>
<?php if($TPL_VAR["cfg_reserve"]["autoemoney"]){?>
								<li>
									상품평작성 시,
									<span class="Dib">
									캐시 최대 <?php echo get_currency_price($TPL_VAR["cfg_reserve"]["autoemoney_review"], 2,'','<strong class="gray_01">_str_price_</strong>')?>

<?php if(serviceLimit('H_NFR')&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>, 포인트 <strong class="gray_01"><?php echo number_format($TPL_VAR["cfg_reserve"]["autopoint_review"])?></strong>P<?php }?>
								</span>
								</li>
<?php }?>
							</ul>
<?php }?>

<?php if(in_array($TPL_VAR["naver_mileage_yn"],array('y','t'))){?>
							<p class="od_sale_title2" designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >네이버마일리지</p>
							<?php echo showNaverMileageButton()?>

<?php }?>
							<!-- ++++++++++++++++++++ 결제 금액 :: END ++++++++++++++++++++ -->


							<!-- ++++++++++++++++++++ 결제 수단 :: START ++++++++++++++++++++ -->
							<h3 class="title3"><span designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >결제 수단</span></h3>
							<ul class="payment_method_select clearbox" id="payment_type">
<?php if($TPL_VAR["payment"]["payco"]){?>
								<li>
									<div class="payco">
										<label><input type="radio" name="payment" value="payco" /></label>
									</div>
									<p designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >페이코</p>
								</li>
<?php }?>
<?php if($TPL_VAR["payment"]["kakaopay"]){?>
								<li>
									<div class="kakaopay2">
										<label><input type="radio" name="payment" value="kakaopay" /></label>
									</div>
									<p onclick="click_Kakaopay(this);" designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >카카오페이</p>
								</li>
<?php }?>

<?php if($TPL_VAR["config_system"]["not_use_pg"]!='y'){?>
<?php if($TPL_VAR["payment"]["card"]){?>
								<li>
									<div class="card">
										<label><input type="radio" name="payment" value="card" /></label>
									</div>
									<p designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >신용카드</p>
								</li>
<?php }?>
<?php if($TPL_VAR["payment"]["account"]){?>
								<li>
									<div class="account">
										<label><input type="radio" name="payment" value="account" /></label>
									</div>
									<p designElement="text" textIndex="21"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >실시간<br />계좌이체</p>
								</li>
<?php }?>
<?php if($TPL_VAR["escrow"]["account"]){?>
								<li>
									<div class="escrow_account">
										<label><input type="radio" name="payment" value="escrow_account" /></label>
									</div>
									<p designElement="text" textIndex="22"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >실시간<br />계좌이체<br /><span class="desc No">(에스크로)</span></p>
								</li>
<?php }?>
<?php if($TPL_VAR["payment"]["virtual"]){?>
								<li>
									<div class="virtual">
										<label><input type="radio" name="payment" value="virtual" /></label>
									</div>
									<p designElement="text" textIndex="23"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >가상계좌</p>
								</li>
<?php }?>
<?php if($TPL_VAR["escrow"]["virtual"]){?>
								<li>
									<div class="escrow_virtual">
										<label><input type="radio" name="payment" value="escrow_virtual" /></label>
									</div>
									<p designElement="text" textIndex="24"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >가상계좌<br /><span class="desc No">(에스크로)</span></p>
								</li>
<?php }?>
<?php if($TPL_VAR["payment"]["cellphone"]){?>
								<li>
									<div class="cellphonepay">
										<label><input type="radio" name="payment" value="cellphone" /></label>
									</div>
									<p designElement="text" textIndex="25"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >휴대폰결제</p>
								</li>
<?php }?>
<?php }?>
<?php if($TPL_VAR["payment"]["bank"]){?>
								<li>
									<div class="bank2">
										<label><input type="radio" name="payment" value="bank" /></label>
									</div>
									<p designElement="text" textIndex="26"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >무통장입금</p>
								</li>
<?php }?>
<?php if($TPL_VAR["payment"]["paypal"]){?>
								<li>
									<div class="paypal">
										<label><input type="radio" name="payment" value="paypal" /></label>
									</div>
									<p designElement="text" textIndex="27"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >Paypal</p>
								</li>
<?php }?>
<?php if($TPL_VAR["payment"]["eximbay"]){?>
								<li>
									<div class="eximbay">
										<label><input type="radio" name="payment" value="eximbay" /></label>
									</div>
									<p designElement="text" textIndex="28"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==" >eximbay</p>
								</li>
<?php }?>

								<!-- 참고) npay : class="npay", payco : class="payco" -->
							</ul>

							<ul class="payment_method_select hide" id="payment_type_zero">
								<li><strong style="color:#4b4b4b;">전액할인</strong></li>
							</ul>

							<!-- 카카오페이 - 상세 -->
<?php if($TPL_VAR["payment"]["kakaopay"]&&$TPL_VAR["not_use_kakao"]=='n'){?>
							<div class="kakaopay hide">
								<?php echo $TPL_VAR["kakaopay_html"]?>

							</div>
<?php }?>

							<!-- 신용카드 - 상세 -->
							<div id="typereceiptcardlay" class="hide">
								카드매출전표(또는 휴대폰결제전표)로 대체합니다.
							</div>

							<!--무통장입금 - 상세 -->
<?php if($TPL_VAR["payment"]["bank"]){?>
							<ul class="list_01 v2 bank hide">
								<li>
									<input type="text" name="depositor" value="" title="입금자명" />
								</li>
								<li>
									<select name="bank">
										<option value="">은행 선택</option>
<?php if($TPL_bank_1){foreach($TPL_VAR["bank"] as $TPL_V1){?>
<?php if($TPL_V1["accountUse"]=='y'){?>
										<option value="<?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["account"]?> 예금주:<?php echo $TPL_V1["bankUser"]?>"><?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["account"]?> 예금주:<?php echo $TPL_V1["bankUser"]?></option>
<?php }?>
<?php }}?>
									</select>
								</li>
							</ul>
<?php }?>
							<ul id="typereceiptlay" class="mt_sp1 hide">
								<li class="labelgroup_design <?php if(!($TPL_VAR["cfg"]["order"]["cashreceiptuse"]> 0||$TPL_VAR["cfg"]["order"]["taxuse"]> 0)){?>hide<?php }?>">
									<label for="typereceiptuse1"><input type="radio" name="typereceiptuse" id="typereceiptuse1" value="1" > 발급</label>
									<label for="typereceiptuse0" class="on"><input type="radio" name="typereceiptuse" id="typereceiptuse0" value="0" checked="checked"> 발급 안 함</label>
								</li>
								<li class="hide labelgroup_design" id="typereceiptchoice" >
<?php if($TPL_VAR["cfg"]["order"]["cashreceiptuse"]> 0){?>
									<label class='cach_voucherchk on'><input type="radio" name="typereceipt" id="typereceipt2" value="2"> 현금영수증 </label>
<?php }?>
<?php if($TPL_VAR["cfg"]["order"]["taxuse"]> 0){?>
									<label class='tax_voucherchk'><input type="radio" name="typereceipt" id="typereceipt1" value="1"> 세금계산서 </label>
<?php }?>
								</li>
							</ul>
							<div id="typereceipttablelay" class="hide">

								<!-- ~~~~~~~ 현금영수증 신청 부분 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
								<ul id="cash_container" class="typereceiptlay list_01 v2 Mt5 hide">
									<li class="labelgroup_design">
										<label for="cuse0" class="on"><input type="radio" name="cuse" id="cuse0" value="0" checked="checked"> 개인 소득공제</label>
										<label for="cuse1"><input type="radio" name="cuse" id="cuse1" value="1"> 사업자 지출증빙</label>
									</li>
									<li id="personallay">
										<input type="tel" name="creceipt_number[0]" class="size_email_full" maxlength="13" title="휴대폰번호( '-' 없이 입력 )" />
									</li>
									<li id="businesslay" class="hide">
										<input type="tel" name="creceipt_number[1]" class="size_email_full" maxlength="10" title="사업자번호( '-' 없이 입력 )" />
									</li>
									<li id="personallay">
										<input type="email" name="sales_email" class="size_email_full" title="이메일주소" />
									</li>
									<li id="duplicate_message" class="desc">
										※ 결제창에서 다시 현금영수증을 신청하지 마세요. 중복발행 됩니다.
									</li>
								</ul>
								<!-- ~~~~~~~ 세금계산서 신청 부분 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
								<ul id="tax_container" class="typereceiptlay list_01 v2 Mt10 hide">
									<li>
										<input type="text" name="co_name" id="co_name" value="<?php echo $TPL_VAR["business_info"]["bname"]?>" title="상호명" />
									</li>
									<li>
										<input type="tel" name="busi_no" id="busi_no" value="<?php echo $TPL_VAR["business_info"]["bno"]?>" title="사업자번호" /> <span class="desc">ex) 123-12-12345</span>
									</li>
									<li>
										<input type="text" name="co_ceo" id="co_ceo" value="<?php echo $TPL_VAR["business_info"]["bCEO"]?>" title="대표자명" />
									</li>
									<li>
										<input type="text" name="co_status" id="co_status" value="<?php echo $TPL_VAR["business_info"]["bstatus"]?>" title="업태" style="width:130px;" /> /
										<input type="text" name="co_type" id="co_type" value="<?php echo $TPL_VAR["business_info"]["bitem"]?>" title="업종" style="width:130px;" />
									</li>
									<li>
										<input type="text" name="co_new_zipcode" class="size_zip_all" value="<?php echo $TPL_VAR["business_info"]["co_new_zipcode"]?>" title="우편번호" readonly />
										<button type="button" class="btn_resp size_b color4" onclick="openDialogZipcode_resp('co_');">검색</button>
										<input type="hidden" name="co_address_type" id="co_address_type" value="<?php echo $TPL_VAR["business_info"]["baddress_type"]?>" title="주소" />
										<input type="text" name="co_address" id="co_address" value="<?php echo $TPL_VAR["business_info"]["baddress1"]?>" class="size_address Mt5 <?php if($TPL_VAR["business_info"]["baddress_type"]=='street'){?>hide<?php }?>" title="주소" readonly />
										<input type="text" name="co_address_street" id="co_address_street" value="<?php echo $TPL_VAR["business_info"]["baddress1"]?>" class="size_address Mt5 <?php if($TPL_VAR["business_info"]["baddress_type"]!='street'){?>hide<?php }?>" title="주소" readonly />
										<input type="text" name="co_address_detail" id="co_address_detail" value="<?php echo $TPL_VAR["business_info"]["baddress2"]?>" class="size_address Mt5" title="상세주소" />
									</li>
									<li>
										<input type="text" name="person" id="person" value="<?php echo $TPL_VAR["business_info"]["bperson"]?>" title="담당자명" />
									</li>
									<li>
										<input type="email" name="email" id="email" value="<?php echo $TPL_VAR["members"]["email"]?>" title="이메일주소" class="size_email_full" />
									</li>
									<li>
										<input type="tel" name="phone" id="phone" value="<?php echo $TPL_VAR["business_info"]["bphone"]?>" title="연락처 " /> <span class="desc">숫자만 입력</span>
									</li>
								</ul>
							</div>
							<!-- ++++++++++++++++++++ 결제 수단 :: END ++++++++++++++++++++ -->

							<!-- ++++++++++++++++++++ 약관 동의( 비회원 ) :: START ++++++++++++++++++++ -->
<?php if($TPL_VAR["cancellation"]||!defined('__ISUSER__')||(serviceLimit('H_AD')&&$TPL_VAR["policy_third_party"])){?>
							<h3 class="title3">약관 동의</h3>
							<div class="mem_agree_area">
								<label class="pilsu_agree_all2"><input type="checkbox" name="all_agree" id="all_agree" value="Y" /> 전체동의</label>
								<ul id="odAgreeList" class="agree_list2">
<?php if(!defined('__ISUSER__')){?>
									<li>
										<a class="agree_view" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >보기</a>
										<label><input type="checkbox" class="agree_chk" name="agree1" id="agree1" value="Y" /> <span class="title">서비스 이용 약관</span> <span class="desc pointcolor imp">(필수)</span></label>
									</li>
									<li>
										<a class="agree_view" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >보기</a>
										<label><input type="checkbox" class="agree_chk" name="agree2" id="agree2" value="Y" /> <span class="title">개인정보 수집 및 이용</span> <span class="desc pointcolor imp">(필수)</span></label>
									</li>
<?php }?>
<?php if(serviceLimit('H_AD')&&$TPL_VAR["policy_third_party"]){?>
									<li>
										<a class="agree_view" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >보기</a>
										<label><input type="checkbox" class="agree_chk" name="agree3" id="agree3" value="Y" /> <span class="title">개인정보 제3자 제공</span> <span class="desc pointcolor imp">(필수)</span></label>
									</li>
<?php }?>
<?php if($TPL_VAR["cancellation"]){?>
									<li>
										<a class="agree_view" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >보기</a>
										<label><input type="checkbox" class="agree_chk" name="cancellation" id="cancellation" value="Y" /> <span class="title">청약철회 관련방침</span> <span class="desc pointcolor imp">(필수)</span></label>
									</li>
<?php }?>
								</ul>
							</div>
							<script>
								$(function() {
									$('#odAgreeList .agree_view').on('click', function() {
										var agree_title = $(this).next('label').find('.title').text();
										var agree_gubun = $(this).next('label').find('input[type=checkbox]').attr('name');
										$('#odAgreeDetail .title').text(agree_title);
										$('#odAgreeDetail .od_agree_text').hide();
										switch (agree_gubun) {
											case 'agree1' : $('#odAgreeText1').show(); break;
											case 'agree2' : $('#odAgreeText2').show(); break;
											case 'agree3' : $('#odAgreeText3').show(); break;
											case 'cancellation' : $('#odAgreeText4').show(); break;
											default : $('#odAgreeText1').show(); break;
										}
										showCenterLayer('#odAgreeDetail')
									});
								});
							</script>
<?php }?>
							<!-- ++++++++++++++++++++ 약관 동의( 비회원 ) :: END ++++++++++++++++++++ -->

							<!-- 결제 버튼 -->
							<div class="pay_layer btn_area_c" id="pay_layer1">
								<input type="button" value="결제하기" name="button_pay" id="pay" class="btn_resp size_extra color2 Wmax" />
								<span class="hide"><input type="button" value="장바구니로" class="btn_resp size_extra" onclick="document.location.href='cart';" /></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<!-- 카카오페이 레이어 부분 -->
<?php if($TPL_VAR["payment"]["kakaopay"]&&$TPL_VAR["not_use_kakao"]=='n'){?>
	<div class="kakaopay hide">
		<script src="https://<?php echo $TPL_VAR["CnsPayDealRequestUrl"]?>/dlp/scripts/lib/easyXDM.min.js" type="text/javascript"></script>
		<script src="https://<?php echo $TPL_VAR["CnsPayDealRequestUrl"]?>/dlp/scripts/lib/json3.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="https://<?php echo $TPL_VAR["CNSPAY_WEB_SERVER_URL"]?>/js/dlp/client/kakaopayDlpConf.js" charset="utf-8"></script>
		<script type="text/javascript" src="https://<?php echo $TPL_VAR["CNSPAY_WEB_SERVER_URL"]?>/js/dlp/client/kakaopayDlp.min.js" charset="utf-8"></script>
		<script type="text/javascript">
			function kakaoDlpCall(phone,prtype){
				kakaopayDlp.setTxnId(actionFrame.payForm.txnId.value);
				kakaopayDlp.setChannelType(prtype, 'TMS');
				kakaopayDlp.addRequestParams({ MOBILE_NUM : phone});
				kakaopayDlp.callDlp('kakaopay_layer', actionFrame.payForm, submitFunc);
			}
			var submitFunc = function cnspaySubmit(data){
				if(data.RESULT_CODE === '00') {
					actionFrame.kakaopay_complate(data);
				} else if(data.RESULT_CODE === 'KKP_SER_002' || data.RESULT_CODE === 'KKP_SER_004') {
					// X버튼 눌렀을때 : KKP_SER_002
					// 유효시간 초과 : KKP_SER_004
					alert('[' + data.RESULT_CODE + ']' + data.RESULT_MSG);
					actionFrame.kakao_cancel_script();
				} else {
					alert('[' + data.RESULT_CODE + ']' + data.RESULT_MSG);
					// actionFrame.kakao_cancel_script();
				}
			};
		</script>
	</div>
<?php }?>
	<div id="kakaopay_layer"  style="display: none"></div>

	<!-- 배송국가 레이어 -->
	<div class="nation resp_layer_pop hide">
		<h4 class="title">배송국가 및 지역 선택</h4>
		<div class="y_scroll_auto">
			<p class="now_shipping_nation">
				<span id="nation_gl_type" class="<?php if($TPL_VAR["ini_info"]["nation"]=='KOREA'){?>hide<?php }?>"><button type="button" class="btn_resp color2" onclick="chg_shipping_nation('KOREA');">대한민국으로 변경</button></span>
				현재 : <strong class="international_nation"><?php echo $TPL_VAR["ini_info"]["kr_nation"]?></strong>
				<img id="nation_img" src="/admin/skin/default/images/common/icon/nation/<?php echo $TPL_VAR["ini_info"]["nation"]?>.png" alt="" designImgSrcOri='L2FkbWluL3NraW4vZGVmYXVsdC9pbWFnZXMvY29tbW9uL2ljb24vbmF0aW9uL3tpbmlfaW5mby5uYXRpb259LnBuZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==' designImgSrc='L2FkbWluL3NraW4vZGVmYXVsdC9pbWFnZXMvY29tbW9uL2ljb24vbmF0aW9uL3tpbmlfaW5mby5uYXRpb259LnBuZw==' designElement='image' ></dt>
			</p>
			<div class="layer_pop_contents v3">
				<ul class="layer_nation_list">
<?php if($TPL_ship_gl_arr_1){foreach($TPL_VAR["ship_gl_arr"] as $TPL_K1=>$TPL_V1){?>
					<li onclick="chg_shipping_nation('<?php echo $TPL_V1["nation_str"]?>');">
					<span class="nation_flag">
						<img src="/admin/skin/default/images/common/icon/nation/<?php echo $TPL_VAR["ship_gl_list"][$TPL_K1]['gl_nation']?>.png" alt="" designImgSrcOri='L2FkbWluL3NraW4vZGVmYXVsdC9pbWFnZXMvY29tbW9uL2ljb24vbmF0aW9uL3tzaGlwX2dsX2xpc3RbLmtleV9dWw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9zZXR0bGUuaHRtbA==' designImgSrc='L2FkbWluL3NraW4vZGVmYXVsdC9pbWFnZXMvY29tbW9uL2ljb24vbmF0aW9uL3tzaGlwX2dsX2xpc3RbLmtleV9dWw==' designElement='image' >
					</span>
						<span class="nation_name">
						<?php echo $TPL_VAR["ship_gl_list"][$TPL_K1]['kr_nation']?>

						<span class="eng">( <?php echo $TPL_VAR["ship_gl_list"][$TPL_K1]['gl_nation']?> )</span>
					</span>
					</li>
<?php }}?>
				</ul>
			</div>
		</div>
		<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
	</div>

	<!-- 쿠폰 목록 레이어 -->
	<div id="couponDeatilLayer" class="resp_layer_pop hide">
		<h4 class="title">보유 쿠폰</h4>
		<div class="y_scroll_auto2">
			<div class="layer_pop_contents v5">
				<div id="coupon_ordersheet_lay">
					<div id="coupon_ordersheet_select"></div>
				</div>
				<div id="coupon_goods_lay"></div>
				<div id="coupon_shipping_lay">
					<div id="coupon_shipping_select"></div>
				</div>
			</div>
		</div>
		<div class="layer_bottom_btn_area2">
			<button type="button" id="coupon_order" class="btn_resp size_c color2 Wmax">적용</button>
		</div>
		<a href="/mypage/coupon" class="btn_resp btn_view_coupons" target="_blank" hrefOri='L215cGFnZS9jb3Vwb24=' >보유 쿠폰 전체 보기</a>
		<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
	</div>

	<!-- 배송비 내역 레이어 -->
	<div id="besongDetailList" class="resp_layer_pop hide">
		<h4 class="title">배송비 내역</h4>
		<div class="y_scroll_auto2">
			<div class="layer_pop_contents v5">
				<!-- 선불 배송비 상세 :: START -->
				<ul class="od_layer_title1">
					<li class="th">주문 시 결제 배송비 :</li>
					<li class="td">총 <span class="gray_01"><?php echo get_currency_price(array_sum($TPL_VAR["shipping_cost_detail"]["delivery"]), 2,'','<span class="delivery_tot_price totalprice_font">_str_price_</span>')?></span></li>
				</ul>
				<table class="table_row_a" cellpadding="0" cellspacing="0">
					<colgroup><col width="100" /><col /></colgroup>
					<tbody>
					<tr>
						<th scope="row"><p>기본배송비</p></th>
						<td>
							<?php echo get_currency_price($TPL_VAR["shipping_cost_detail"]["delivery"]["std"], 2,'','<span class="std_delivery_price">_str_price_</span>')?>

						</td>
					</tr>
					<tr class="total_add_delivery_lay">
						<th scope="row"><p>추가배송비</p></th>
						<td>
							<?php echo get_currency_price($TPL_VAR["shipping_cost_detail"]["delivery"]["add"], 2,'','<span class="add_delivery_price">_str_price_</span>')?>

						</td>
					</tr>
					<tr>
						<th scope="row"><p>희망일 배송비</p></th>
						<td>
							<?php echo get_currency_price($TPL_VAR["shipping_cost_detail"]["delivery"]["hop"], 2,'','<span class="hop_delivery_price">_str_price_</span>')?>

						</td>
					</tr>
					</tbody>
				</table>
				<!-- 선불 배송비 상세 :: END -->
				<!-- 착불 배송비 상세 :: START -->
				<ul class="od_layer_title1 Mt20">
					<li class="th">착불 결제 배송비 :</li>
					<li class="td">총 <span class="pointcolor2"><?php echo get_currency_price(array_sum($TPL_VAR["shipping_cost_detail"]["postpaid"]), 2,'','<span class="postpaid_tot_price totalprice_font">_str_price_</span>')?></span></li>
				</ul>
				<table class="table_row_a" cellpadding="0" cellspacing="0">
					<colgroup><col width="100" /><col /></colgroup>
					<tbody>
					<tr>
						<th scope="row"><p>기본배송비</p></th>
						<td>
							<?php echo get_currency_price($TPL_VAR["shipping_cost_detail"]["postpaid"]["std"], 2,'','<span class="std_postpaid_price">_str_price_</span>')?>

						</td>
					</tr>
					<tr class="total_add_delivery_lay">
						<th scope="row"><p>추가배송비</p></th>
						<td>
							<?php echo get_currency_price($TPL_VAR["shipping_cost_detail"]["postpaid"]["add"], 2,'','<span class="add_postpaid_price">_str_price_</span>')?>

						</td>
					</tr>
					<tr>
						<th scope="row"><p>희망일 배송비</p></th>
						<td>
							<?php echo get_currency_price($TPL_VAR["shipping_cost_detail"]["postpaid"]["hop"], 2,'','<span class="hop_postpaid_price">_str_price_</span>')?>

						</td>
					</tr>
					</tbody>
				</table>
				<!-- 착불 배송비 상세 :: END -->
			</div>
		</div>
		<div class="layer_bottom_btn_area2">
			<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
		</div>
		<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
	</div>

	<!-- 할인 내역 레이어 -->
	<div id="saleDetailList" class="resp_layer_pop hide">
		<h4 class="title">할인 내역</h4>
		<div class="y_scroll_auto2">
			<div class="layer_pop_contents v5">
				<ul class="od_layer_title1">
					<li class="td">총 <span class="pointcolor"><?php echo get_currency_price($TPL_VAR["total_sale"], 2,'','<span class="total_sales_price totalprice_font">_str_price_</span>')?></span></span></li>
				</ul>
				<table class="table_row_a" cellpadding="0" cellspacing="0">
					<colgroup><col width="100" /><col /></colgroup>
					<tbody>
<?php if($TPL_total_sale_list_1){foreach($TPL_VAR["total_sale_list"] as $TPL_K1=>$TPL_V1){?>
					<tr id="total_<?php echo $TPL_K1?>_sale_tr" <?php if($TPL_V1['price']> 0){?><?php }else{?>class="hide"<?php }?>>
					<th scope="row"><p><?php echo $TPL_V1['title']?></p></th>
					<td class="bolds ends prices">
						<?php echo get_currency_price($TPL_V1['price'], 2,'','<span id="total_'.$TPL_K1.'_sale">_str_price_</span>')?>

					</td>
					</tr>
<?php }}?>
					<tr <?php if($TPL_VAR["enuri"]> 0){?><?php }else{?>class="hide"<?php }?>>
						<th scope="row"><p>에누리</p></th>
						<td>
							<?php echo get_currency_price($TPL_VAR["enuri"], 2,'','<span id="enuri">_str_price_</span>')?>

						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="layer_bottom_btn_area2">
			<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
		</div>
		<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
	</div>

	<!-- 약관 상세 레이어 -->
	<div id="odAgreeDetail" class="resp_layer_pop hide">
		<h4 class="title"></h4>
		<div class="y_scroll_auto2">
			<div class="layer_pop_contents v5">
				<div id="odAgreeText1" class="od_agree_text hide"><?php echo nl2br($TPL_VAR["agreement"])?></div>
				<div id="odAgreeText2" class="od_agree_text hide"><?php echo nl2br($TPL_VAR["policy"])?></div>
				<div id="odAgreeText3" class="od_agree_text hide"><?php echo nl2br($TPL_VAR["policy_third_party"])?></div>
				<div id="odAgreeText4" class="od_agree_text hide"><?php echo nl2br($TPL_VAR["cancellation"])?></div>
			</div>
		</div>
		<div class="layer_bottom_btn_area2">
			<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
		</div>
		<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
	</div>

	<!-- //본문내용 끝 -->
</form>

<!-- 배송 변경 레이어 :: START -->
<div id="shipping_detail_lay" class="resp_layer_pop hide">
	<h4 class="title">배송 변경</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5"></div>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>
<!-- 배송 변경 레이어 :: END -->


<script type="text/javascript">
	// 패치되는 settle 페이지 버전 :: 2017-06-01 스킨패치 시 필수
	skin_order_settle_ver = 1;
	// 배송 변경
	$("button.btn_shipping_modify").bind("click",function() {
		var cart_seq	= $(this).attr('cart_seq');
		var prepay_info = $(this).attr('prepay_info');
		var nation		= $(this).attr('nation');
		var hop_date	= $(this).attr('hop_date');
		var goods_seq	= $(this).attr('goods_seq');
		var cart_table	= parseInt($(this).attr('person_seq')) > 0 ? 'person' : '';

		$.ajax({
			'url'	: '/goods/shipping_detail_info',
			'data'	: {'mode':'cart','cart_seq':cart_seq,'prepay_info':prepay_info,'nation':nation,'hop_date':hop_date,'goods_seq':goods_seq,'cart_table':cart_table},
			'type'	: 'get',
			'dataType': 'text',
			'success': function(html) {
				if(html){
					$("#shipping_detail_lay .layer_pop_contents").html(html);
					showCenterLayer('#shipping_detail_lay');
					//배송방법 안내 및 변경
					//openDialog(getAlert('os170'), "shipping_detail_lay", {"width":500,"height":650});
				}else{
					//오류가 발생했습니다. 새로고침 후 다시시도해주세요.
					alert(getAlert('os171'));
					document.location.reload();
				}
			}
		});
	});
</script>

<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="utf8"></script>
<script type="text/javascript">
	var multiShippingItemNoCnt	= 0;

	var order_version			= $("input[name='order_version']").val();
	var gl_mode					= '<?php echo $TPL_VAR["mode"]?>';
	var gl_region				= new Array();
<?php if(is_array($TPL_R1=$TPL_VAR["shipping_policy"]["policy"][ 1])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
	gl_region[<?php echo $TPL_K1?>] = new Array();
<?php if(is_array($TPL_R2=$TPL_V1["region"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
	gl_region[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>] = "<?php echo $TPL_V2?>";
<?php }}?>
<?php }}?>

	var gl_mobile				= '<?php echo $TPL_VAR["mobile"]?>';
	var gl_ssl_action			= "<?php echo sslAction(implode('',array('../order/pay?mode=',$TPL_VAR["mode"])))?>";
	var gl_pg_company			= '<?php echo $TPL_VAR["pg_company"]?>';
	var gl_isuser				= false;

<?php if(defined('__ISUSER__')){?>gl_isuser					= '<?php echo defined('__ISUSER__')?>';<?php }?>
		gl_iscancellation			= false;
<?php if($TPL_VAR["cancellation"]){?>gl_iscancellation			= true;<?php }?>
			var gl_cashreceiptuse		= '<?php echo $TPL_VAR["cfg"]["order"]["cashreceiptuse"]?>';
			var gl_taxuse				= '<?php echo $TPL_VAR["cfg"]["order"]["taxuse"]?>';
			var gl_request_uri			= '<?php echo urlencode($_SERVER["REQUEST_URI"])?>';
			var gl_goods_seq			= 0;
<?php if($TPL_VAR["goods"]["goods_seq"]){?>gl_goods_seq				= "<?php echo $TPL_VAR["goods"]["goods_seq"]?>";<?php }?>
				var gl_skin					= "<?php echo $TPL_VAR["config_system"]["skin"]?>";
				var gl_http_host			= '<?php echo $_SERVER["HTTP_HOST"]?>';
				var gl_sub_domain			= '<?php echo $TPL_VAR["config_system"]["subDomain"]?>';
<?php if($_SERVER["HTTPS"]=='on'){?>
				var url						= 'https://<?php echo $_SERVER["HTTP_HOST"]?>'
<?php }else{?>
				var url						= 'http://<?php echo $_SERVER["HTTP_HOST"]?>'
<?php }?>
					var is_file_facebook_tag	= <?php if($TPL_VAR["is_file_facebook_tag"]){?>true;<?php }else{?>false;<?php }?>
<?php if($TPL_VAR["is_file_facebook_tag"]){?>
					var fblike_ordertype		= "<?php echo $TPL_VAR["cfg"]["order"]["fblike_ordertype"]?>";
					var fblikesale				= <?php if($TPL_VAR["fblikesale"]){?>true<?php }else{?>false<?php }?>;
						var fbuser					= <?php if($TPL_VAR["fbuser"]){?>true<?php }else{?>false<?php }?>;
							var APP_USE					= "<?php echo $TPL_VAR["APP_USE"]?>";
							var APP_DOMAIN				= "<?php echo $TPL_VAR["APP_DOMAIN"]?>";
							var HTTP_HOST				= "<?php echo $_SERVER["HTTP_HOST"]?>";
							var firstmallcartid			= "<?php echo $TPL_VAR["firstmallcartid"]?>";
							var APP_VER					= '<?php echo $TPL_VAR["APP_VER"]?>';
<?php }?>

								var shipping_policy_count	= "<?php if($TPL_VAR["shipping_policy"]["count"]&&array_sum($TPL_VAR["shipping_policy"]["count"])> 1){?><?php echo array_sum($TPL_VAR["shipping_policy"]["count"])?><?php }else{?>0<?php }?>";

								var shipping_policy_count_detail = <?php if($TPL_VAR["shipping_policy"]["count"][ 0]&&$TPL_VAR["shipping_policy"]["count"][ 1]){?>true<?php }else{?>false<?php }?>;
								var escrow_view				= <?php if(!$TPL_VAR["escrow_view"]){?>true<?php }else{?>false<?php }?>;
									var cart_promotioncode		= "<?php echo $TPL_VAR["cart_promotioncode"]?>";
									var is_goods				= <?php if($TPL_VAR["is_goods"]){?>true<?php }else{?>false<?php }?>;
										var is_direct_store			= <?php if($TPL_VAR["is_direct_store"]){?>true<?php }else{?>false<?php }?>;
											var is_coupon				= <?php if($TPL_VAR["is_coupon"]){?>true<?php }else{?>false<?php }?>;
												var is_members				= <?php if($TPL_VAR["members"]){?>true<?php }else{?>false<?php }?>;
													var is_address				= <?php if($TPL_VAR["members"]["default_address"]["err_ship_addr"]){?>true<?php }else{?>false<?php }?>;
</script>
<script type="text/javascript" src="/app/javascript/js/order-settle.js?dummy=<?php echo date('YmdHis')?>" charset="utf8"></script>
<script type="text/javascript" src="/app/javascript/js/skin-order-settle-resp.js" charset="utf8"></script>

<!-- 해외배송 안내 콘텐츠. 파일위치 : [스킨폴더]/goods/_international_shipping_info.html -->
<?php $this->print_("INTERNATIONAL_SHIPPING_INFO",$TPL_SCP,1);?>

<!-- //해외배송 안내 콘텐츠 -->

<?php if($TPL_VAR["is_file_facebook_tag"]){?>
<!-- 좋아요할인 : 삭제하지 말아주세요 -->
<?php if(!(strstr($_SERVER["HTTP_HOST"],'.firstmall.kr')||$_SERVER["HTTP_HOST"]==$TPL_VAR["APP_DOMAIN"])){?>
<iframe name="snsiframe" src="//<?php echo $TPL_VAR["config_system"]["subDomain"]?>/admin/sns/subdomainfacebookck" frameborder="0" width="0" height="0"></iframe>
<script language="JavaScript" src="<?php if($_GET["mode"]){?>//<?php echo $TPL_VAR["config_system"]["subDomain"]?>/order/fblike_opengraph_firstmallplus?firstmallcartid=<?php echo $TPL_VAR["firstmallcartid"]?>&files=settle&mode=<?php echo $_GET["mode"]?><?php }else{?>//<?php echo $TPL_VAR["config_system"]["subDomain"]?>/order/fblike_opengraph_firstmallplus?firstmallcartid=<?php echo $TPL_VAR["firstmallcartid"]?>&files=settle<?php }?>"></script>
<script language="JavaScript" src="//<?php echo $TPL_VAR["config_system"]["subDomain"]?>/order/fbopengraph?firstmallcartid=<?php echo $TPL_VAR["firstmallcartid"]?>"></script>
<?php }?>
<script language="JavaScript" src="<?php if($_GET["mode"]){?>../order/fblike_opengraph?files=settle&mode=<?php echo $_GET["mode"]?><?php }else{?>../order/fblike_opengraph?files=settle<?php }?>"></script>
<!-- 좋아요할인 : 삭제하지 말아주세요 -->
<?php }?>

<script>
	// 인풋 박스 필수 체크( 값이 있는 경우 )
	function input_pilsu_check() {
		$('input.pilsu').each(function() {
			if ( $(this).val() ) {
				$(this).addClass('complete');
			} else {
				$(this).removeClass('complete');
			}
		});
	}

	// 오른쪽 영역 스크롤링
	function orderPaymentScrolling() {
		var popContentScrollHeight2 = document.body.clientHeight;
		var popContentOuterHeight2 = $('#orderPaymentLayout .order_payment_right .order_subsection').outerHeight();
		var orderPaymentLeft = $('#orderPaymentLayout .order_payment_left').height();
		if ( window.innerWidth > 799 && popContentScrollHeight2 > popContentOuterHeight2 ) {
			$(window).on('scroll', function() {
				var position = $(this).scrollTop();
				var quickTop = $('#orderPaymentLayout .order_payment_right').offset().top;
				popContentOuterHeight2 = $('#orderPaymentLayout .order_payment_right .order_subsection').outerHeight();
				if ( position > quickTop && popContentScrollHeight2 > popContentOuterHeight2 && orderPaymentLeft > popContentOuterHeight2) {
					$('#orderPaymentLayout').addClass('flyingMode');
				} else {
					$('#orderPaymentLayout').removeClass('flyingMode');
				}
			});
		} else {
			$(window).off('scroll');
		}
		$( window ).on('resize', function() {
			if ( window.innerWidth > 799 ) {
				$(window).on('scroll', function() {
					var position = $(this).scrollTop();
					var quickTop = $('#orderPaymentLayout .order_payment_right').offset().top;
					popContentOuterHeight2 = $('#orderPaymentLayout .order_payment_right .order_subsection').outerHeight();
					if ( position > quickTop && popContentScrollHeight2 > popContentOuterHeight2 && orderPaymentLeft > popContentOuterHeight2) {
						$('#orderPaymentLayout').addClass('flyingMode');
					} else {
						$('#orderPaymentLayout').removeClass('flyingMode');
					}
				});
			} else {
				$(window).off('scroll');
				$('#orderPaymentLayout').removeClass('flyingMode');
			}
		});
	}

	$(function() {
		// 인풋박스 필수 체크
		input_pilsu_check();
		$('input.pilsu').on('blur', function() {
			if ( $(this).val() ) {
				$(this).addClass('complete');
			} else {
				$(this).removeClass('complete');
			}
		});

		// 오른쪽 영역 스크롤링
		orderPaymentScrolling();
		/*
        $( window ).on('resize', function() {
            if ( window.innerWidth > 799 ) {
                $('#orderPaymentLayout').removeClass('flyingMode');
            }
        });
        */
	});
</script>