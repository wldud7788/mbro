<?php /* Template_ 2.2.6 2021/12/15 17:48:38 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/order/cart.html 000036314 */ 
$TPL_shipping_group_list_1=empty($TPL_VAR["shipping_group_list"])||!is_array($TPL_VAR["shipping_group_list"])?0:count($TPL_VAR["shipping_group_list"]);
$TPL_ship_gl_arr_1=empty($TPL_VAR["ship_gl_arr"])||!is_array($TPL_VAR["ship_gl_arr"])?0:count($TPL_VAR["ship_gl_arr"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 장바구니 @@
- 파일위치 : [스킨폴더]/order/cart.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php echo $TPL_VAR["is_file_facebook_tag"]?>


<div class="title_container">
	<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvb3JkZXIvY2FydC5odG1s" >장바구니</span></h2>
</div>

<!-- 본문내용 시작 -->
<form name="cart_form" id="cart_form" method="post" target="actionFrame" action="order">
<input type="hidden" name="cart_version" value='3' />
<input type="hidden" name="nation" value='<?php echo $TPL_VAR["ini_info"]["nation"]?>' />
<input type="hidden" name="kr_nation" value='<?php echo $TPL_VAR["ini_info"]["kr_nation"]?>' />
<!-- <?php if($TPL_VAR["shipping_group_list"]){?> -->
<ul class="resp_cart_wrap">
	<!-- ++++++++++++ cart left area +++++++++++ -->
	<li class="cart_left">
		<div class="cart_contents">

			<!-- 전체 선택 -->
			<ul class="cart_contents_top clearbox">
				<li class="aa">
					<label class="checkbox_allselect"><input type="checkbox" class="btn_select_all" /> <span class="txt">전체선택</span></label>
				</li>
				<li class="bb hide">
					<input type="button" class="btn_resp size_b btn_shipping_modify" value="배송변경" />
				</li>
			</ul>

			<div class="cart_list">
<?php if($TPL_shipping_group_list_1){foreach($TPL_VAR["shipping_group_list"] as $TPL_V1){?>
			<ul class="shipping_group_list">
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;
$TPL_cart_suboptions_3=empty($TPL_V2["cart_suboptions"])||!is_array($TPL_V2["cart_suboptions"])?0:count($TPL_V2["cart_suboptions"]);?>
<?php if($TPL_I2== 0){?>
				<li class="goods_delivery_info clearbox" id="sippingInfo<?php echo $TPL_V2["shipping_group_seq"]?>">
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
<?php if($TPL_V1["grp_shipping_price"]> 0){?>
<?php if($TPL_V1["shipping_prepay_info"]=='delivery'){?>
							<span class="ship_info">(<?php echo getAlert('sy004')?>)</span>
<?php }else{?>
							<span class="ship_info">(<?php echo getAlert('sy003')?>)</span>
<?php }?>
<?php }?>
<?php }?>
<?php if($TPL_V1["grp_shipping_price"]> 0){?>
							<span id="price_<?php echo $TPL_V1["shipping_group"]?>"><?php echo get_currency_price($TPL_V1["grp_shipping_price"], 2)?></span>
<?php }else{?>
<?php if($TPL_V1["ship_possible"]=='Y'){?>
							<span id="price_<?php echo $TPL_V1["shipping_group"]?>">무료</span>
<?php }else{?>
							<span id="price_<?php echo $TPL_V1["shipping_group"]?>" class="red">배송불가</span>
<?php }?>
<?php }?>
							
							<div class="hope">
<?php if($TPL_V1["cfg"]["baserule"]["shipping_set_code"]=='direct_store'){?>
								<span class="ship_info">수령매장 <?php echo $TPL_V1["store_info"]["shipping_store_name"]?></span>
<?php }?>
<?php if($TPL_V1["shipping_hop_date"]){?>
								<span class="ship_info">희망배송일 : <?php echo $TPL_V1["shipping_hop_date"]?></span>
<?php }elseif($TPL_V1["reserve_sdate"]){?>
								<span class="ship_info">예약배송일 : <?php echo $TPL_V1["reserve_sdate"]?><?php echo $TPL_V1["reserve_txt"]?></span>
<?php }?>
							</div>
						</li>
						<li class="btn_area">
							<button type="button" class="btn_resp" onclick="bundle_goods_search('<?php echo $TPL_V1["cfg"]["baserule"]["shipping_group_seq"]?>');" title="새창">묶음배송 상품보기</button>
							<input type="button" class="btn_resp btn_shipping_modify" cart_seq="<?php echo $TPL_V2["cart_seq"]?>" prepay_info="<?php echo $TPL_V1["shipping_prepay_info"]?>" nation="<?php echo $TPL_V1["cfg"]["baserule"]["delivery_nation"]?>" goods_seq="<?php echo $TPL_V2["goods_seq"]?>" hop_date="<?php echo $TPL_V1["shipping_hop_date"]?>" reserve_txt="<?php echo $TPL_V1["reserve_sdate"]?><?php echo $TPL_V1["reserve_txt"]?>" value="배송 변경" />
						</li>
<?php }?>
					</ul>
				</li>
<?php }?>
				<li class="cart_goods" id="cart_goods_<?php echo $TPL_V2["cart_option_seq"]?>">
					<div class="cart_goods_detail">
						<div class="cgd_top">
							<label>
								<input type="hidden" name="ship_possible[<?php echo $TPL_V2["cart_option_seq"]?>]" value="<?php echo $TPL_V1["ship_possible"]?>"/>
								<input type="checkbox" name="cart_option_seq[]" value="<?php echo $TPL_V2["cart_option_seq"]?>" stat="<?php echo $TPL_V1["ship_possible"]?>" rel="<?php echo $TPL_V2["goods_seq"]?>" />
								<span class="goods_name"><?php echo $TPL_V2["goods_name"]?></span>
							</label>
							<button type="button" class="btn_thisitem_del" value="<?php echo $TPL_V2["cart_option_seq"]?>" title="상품 삭제">삭제 </button>
						</div>
						
						<div class="cgd_contents">
							<div class="block block1">
								<ul>
									<li class="img_area">
										<a href="../goods/view?no=<?php echo $TPL_V2["goods_seq"]?>" hrefOri='Li4vZ29vZHMvdmlldz9ubz17Li5nb29kc19zZXF9' ><img src="<?php echo $TPL_V2["image"]?>" class="goods_thumb" onerror="this.src='/data/skin/responsive_ver1_default_gl/images/common/noimage_list.gif'" designImgSrcOri='ey4uaW1hZ2V9' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvb3JkZXIvY2FydC5odG1s' designImgSrc='ey4uaW1hZ2V9' designElement='image' /></a>
									</li>
									<li class="option_area">
<?php if($TPL_V2["eventEnd"]){?>
										<div class="event_area">
											<span class="soloEventTd<?php echo $TPL_V2["cart_option_seq"]?>">
												<span class="title">남은시간</span>
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

<?php if($TPL_V2["adult_goods"]=='Y'||$TPL_V2["option_international_shipping_status"]=='y'||$TPL_V2["cancel_type"]=='1'||$TPL_V2["tax"]=='exempt'){?>
										<div class="icon_area">
<?php if($TPL_V2["adult_goods"]=='Y'){?>
											<img src="/data/skin/responsive_ver1_default_gl/images/common/auth_img.png" alt="성인" class="icon1" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9hdXRoX2ltZy5wbmc=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvb3JkZXIvY2FydC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvY29tbW9uL2F1dGhfaW1nLnBuZw==' designElement='image' />
<?php }?>
<?php if($TPL_V2["option_international_shipping_status"]=='y'){?>
											<img src="/data/skin/responsive_ver1_default_gl/images/common/plane.png" alt="해외배송상품" class="icon2" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9wbGFuZS5wbmc=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvb3JkZXIvY2FydC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvY29tbW9uL3BsYW5lLnBuZw==' designElement='image' />
<?php }?>
<?php if($TPL_V2["cancel_type"]=='1'){?>
											<img src="/data/skin/responsive_ver1_default_gl/images/common/nocancellation.gif" alt="청약철회" class="icon3" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9ub2NhbmNlbGxhdGlvbi5naWY=' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvb3JkZXIvY2FydC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvY29tbW9uL25vY2FuY2VsbGF0aW9uLmdpZg==' designElement='image' />
<?php }?>
<?php if($TPL_V2["tax"]=='exempt'){?>
											<img src="/data/skin/responsive_ver1_default_gl/images/common/taxfree.gif" alt="비과세" class="icon4" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi90YXhmcmVlLmdpZg==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvb3JkZXIvY2FydC5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3ZlcjFfZGVmYXVsdF9nbC9pbWFnZXMvY29tbW9uL3RheGZyZWUuZ2lm' designElement='image' />
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

										<div class="cart_quantity"><span class="xtle">수량</span> <?php echo number_format($TPL_V2["ea"])?>개 <span class="add_txt">(<?php echo get_currency_price($TPL_V2["price"]*$TPL_V2["ea"], 2)?>)</span></div>

<?php if($TPL_V2["cart_inputs"]){?>
										<ul class="cart_inputs">
<?php if(is_array($TPL_R3=$TPL_V2["cart_inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["input_value"]){?>
											<li>
<?php if($TPL_V3["type"]=='file'){?>
<?php if($TPL_V3["input_title"]){?><span class="xtle v2"><?php echo $TPL_V3["input_title"]?></span><?php }?> 
													<a href="/mypage_process/filedown?file=<?php echo $TPL_V3["input_value"]?>" target="actionFrame" title="크게 보기" hrefOri='L215cGFnZV9wcm9jZXNzL2ZpbGVkb3duP2ZpbGU9ey4uLmlucHV0X3ZhbHVlfQ==' ><img src="/mypage_process/filedown?file=<?php echo $TPL_V3["input_value"]?>" class="inputed_img" designImgSrcOri='L215cGFnZV9wcm9jZXNzL2ZpbGVkb3duP2ZpbGU9ey4uLmlucHV0X3ZhbHVlfQ==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvb3JkZXIvY2FydC5odG1s' designImgSrc='L215cGFnZV9wcm9jZXNzL2ZpbGVkb3duP2ZpbGU9ey4uLmlucHV0X3ZhbHVlfQ==' designElement='image' /></a>
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

							<ul class="block block2" id="mobile_cart_sale_tr_<?php echo $TPL_V2["cart_option_seq"]?>">
								<li class="price_a">
									<span class="ptitle">상품금액</span> <?php echo get_currency_price($TPL_V2["tot_price"], 2)?>

								</li>
								<li class="price_b">
									<span class="ptitle">
										할인금액 
<?php if($TPL_V2["tot_sale_price"]> 0){?>
										<button type="button" class="btn_resp size_a color5" onclick="showCenterLayer('#cart_sale_detail_<?php echo $TPL_V2["cart_option_seq"]?>')">내역</button>
<?php }?>
									</span>
<?php if($TPL_V2["tot_sale_price"]> 0){?>
									(-) <span id="mobile_cart_sale_<?php echo $TPL_V2["cart_option_seq"]?>"><?php echo get_currency_price($TPL_V2["tot_sale_price"], 2)?></span>
<?php }else{?>
									-&nbsp;
<?php }?>

									<div id="cart_sale_detail_<?php echo $TPL_V2["cart_option_seq"]?>" class="resp_layer_pop hide">
										<h4 class="title">할인 내역</h4>
										<div class="y_scroll_auto2">
											<div class="layer_pop_contents v5">
												<div class="resp_1line_table">
<?php if(is_array($TPL_R3=$TPL_V2["sales"]["title_list"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
													<ul id="mobile_cart_option_<?php echo $TPL_K3?>_saletr_<?php echo $TPL_V2["cart_option_seq"]?>" <?php if($TPL_V2["tsales"]["sale_list"][$TPL_K3]> 0){?><?php }else{?>class="hide"<?php }?>>
														<li class="th size1"><p><?php echo $TPL_V2["sales"]["title_list"][$TPL_K3]?></p></li>
														<li class="td"><span id="mobile_cart_option_<?php echo $TPL_K3?>_saleprice_<?php echo $TPL_V2["cart_option_seq"]?>"><?php echo get_currency_price($TPL_V2["tsales"]["sale_list"][$TPL_K3], 2)?></span></li>
													</ul>
<?php }}?>
												</div>
											</div>
										</div>
										<div class="layer_bottom_btn_area2">
											<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
										</div>
										<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
									</div>

								</li>
								<li class="price_c">
									<span class="ptitle">할인적용금액</span>
									<span class="total_p" id="option_suboption_price_sum_<?php echo $TPL_V2["cart_option_seq"]?>"><?php echo get_currency_price($TPL_V2["tot_result_price"], 2,'','<span class="num">_str_price_</span>')?></span>
								</li>
							</ul>

							<ul class="block block3">
								<li><button type="button" class="btn_option_modify btn_resp" id="<?php echo $TPL_V2["cart_option_seq"]?>">옵션/수량변경</button></li>
								<!--li><button type="button" class="btn_option_modify btn_resp" id="<?php echo $TPL_V2["cart_option_seq"]?>">옵션/수량변경</button></li-->
								<li><button type="button" class="btn_direct_buy btn_resp color2" value="<?php echo $TPL_V2["cart_option_seq"]?>">바로구매</button></li>
							</ul>

						</div>

						<!-- 옵션 수량변경 Layer -->
						<div id="optional_changes_area_<?php echo $TPL_V2["cart_option_seq"]?>" class="resp_layer_pop maxHeight hide">
							<h4 class="title">옵션/수량 변경</h4>
							<div class="y_scroll_auto">
								<div class="layer_pop_contents v2 Pb70">
									<!--h5 class="stitle"><?php echo $TPL_V2["goods_name"]?></h5-->
									<div id="onContent">
										옵션/수량 변경 컨텐츠
									</div>
								</div>
							</div>
							<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
						</div>

					</div>
				</li>
<?php }}?>
			</ul>
<?php }}?>
			</div>
		</div>
		
		<!-- 배송 국가 수정 레이어 팝업 -->
		<!-- <?php if($TPL_VAR["impossible_shipping_flag"]==true){?> -->
		<div class="cart_list">
			<ul class="shipping_group_list">
				<li class="goods_delivery_info clearbox" id="sippingInfo{..shipping_group_seq}">
					<ul class="detail">
						<li><span >현재 배송 국가 : <strong><?php echo getstrcut($TPL_VAR["ini_info"]["kr_nation"], 10)?></strong> <img src="/admin/skin/default/images/common/icon/nation/<?php echo $TPL_VAR["ini_info"]["nation"]?>.png" height="20" alt="" designImgSrcOri='L2FkbWluL3NraW4vZGVmYXVsdC9pbWFnZXMvY29tbW9uL2ljb24vbmF0aW9uL3tpbmlfaW5mby5uYXRpb259LnBuZw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvb3JkZXIvY2FydC5odG1s' designImgSrc='L2FkbWluL3NraW4vZGVmYXVsdC9pbWFnZXMvY29tbW9uL2ljb24vbmF0aW9uL3tpbmlfaW5mby5uYXRpb259LnBuZw==' designElement='image' ></span></li>
						<li><button type="button" class="btn_option_modify btn_resp" id="select_other_country">다른국가 선택</button></li>
					</ul>
				</li>
			</ul>
		</div>
<?php }?>

		<div id="select_country_layer_pop" class="resp_layer_pop hide">
			<h4 class="title">배송국가 선택</h4>
			<div class="y_scroll_auto2">
				<div class="layer_pop_contents v5">
					<div class ="shipping-info-lay">
						<ul class="ul_ship">
							<li>
								<dl class="clearbox">
									<dt>
										<h5 class="title_sub3 Pt5 Pb5">
											현재 배송 국가 : <strong><?php echo getstrcut($TPL_VAR["ini_info"]["kr_nation"], 10)?></strong> <img src="/admin/skin/default/images/common/icon/nation/<?php echo $TPL_VAR["ini_info"]["nation"]?>.png" height="20" alt="" designImgSrcOri='L2FkbWluL3NraW4vZGVmYXVsdC9pbWFnZXMvY29tbW9uL2ljb24vbmF0aW9uL3tpbmlfaW5mby5uYXRpb259LnBuZw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvb3JkZXIvY2FydC5odG1s' designImgSrc='L2FkbWluL3NraW4vZGVmYXVsdC9pbWFnZXMvY29tbW9uL2ljb24vbmF0aW9uL3tpbmlfaW5mby5uYXRpb259LnBuZw==' designElement='image' >
										</h5>
									</dt>
									<dd>
										<button type="button" class="btn_resp <?php if($TPL_VAR["ini_info"]["nation"]=='KOREA'){?> hide <?php }?>" onclick="chg_shipping_nation('KOREA');" title="새창">대한민국으로 변경</button>
									</dd>
								</dl>
								<div style="padding-right:5px;">
									<table width="100%" class="list_table_style" border="0" cellspacing="0" cellpadding="0">
										<caption>배송국가</caption>
										<colgroup>
											<col style="width:50%">
										</colgroup>
										<tbody>
<?php if($TPL_ship_gl_arr_1){foreach($TPL_VAR["ship_gl_arr"] as $TPL_K1=>$TPL_V1){?>
											<tr onclick="chg_shipping_nation('<?php echo $TPL_V1["nation_str"]?>');">
												<td class="hand">
													<img src="/admin/skin/default/images/common/icon/nation/<?php echo $TPL_VAR["ship_gl_list"][$TPL_K1]['gl_nation']?>.png" style="text-align: left;" alt="" designImgSrcOri='L2FkbWluL3NraW4vZGVmYXVsdC9pbWFnZXMvY29tbW9uL2ljb24vbmF0aW9uL3tzaGlwX2dsX2xpc3RbLmtleV9dWw==' designTplPath='cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvb3JkZXIvY2FydC5odG1s' designImgSrc='L2FkbWluL3NraW4vZGVmYXVsdC9pbWFnZXMvY29tbW9uL2ljb24vbmF0aW9uL3tzaGlwX2dsX2xpc3RbLmtleV9dWw==' designElement='image' > <?php echo $TPL_VAR["ship_gl_list"][$TPL_K1]['gl_nation']?>

												</td>
												<td class="hand">
													<?php echo $TPL_VAR["ship_gl_list"][$TPL_K1]['kr_nation']?>

												</td>
											</tr>
<?php }}?>
										</tbody>
									</table>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
		</div>
		<!-- 배송 국가 수정 레이어 팝업 END-->

		<!-- 버튼 그룹 -->
		<div class="selected_btn_groups">
			<label class="checkbox_allselect"><input type="checkbox" class="btn_select_all" /> <span class="txt">전체선택</span></label>
			
			<div class="btns">
				<button type="button" class="btn_resp size_b color2 btn_selected_order">선택상품 주문하기</button>
<?php if($TPL_VAR["member_seq"]){?>
				<button type="button" class="btn_resp size_b color4 btn_select_wishlist">선택상품 찜</button>
<?php }?>
				<button type="button" class="btn_resp size_b gray_05 btn_select_del">선택상품 삭제</button>
			</div>
		</div>
	</li>
	<!-- ++++++++++++ //cart left area +++++++++++ -->

	<!-- ++++++++++++ cart right area +++++++++++ -->
	<li class="cart_right">
		<h3 class="title_x">전체 주문시 금액</h3>

		<!-- 총합계 Start -->
		<div class="total_sum_price">
			<ul class="list list1">
				<li class="th">총 상품금액</li>
				<li class="td"><span class="sum_price" id="totalGoodsPrice"><?php echo get_currency_price($TPL_VAR["total"], 2,'','<span class="num">_str_price_</span>')?></span></li>
			</ul>
			<ul class="list list2">
				<li class="th">총 배송비</li>
				<li class="td"><span class="sum_price" id="shippingTotalPrice"><?php if($TPL_VAR["total_shipping_price"]> 0){?>(+) <?php }?><span id="total_shipping_price"><?php echo get_currency_price($TPL_VAR["total_shipping_price"], 2)?></span></span></li>
			</ul>
			<ul class="list list3">
				<li class="th">총 할인</li>
				<li class="td"><span class="sum_price" id="saleTotalPrice"><?php if($TPL_VAR["total_sale"]> 0){?>(-) <?php }?><span id="mobile_total_sale"><?php echo get_currency_price($TPL_VAR["total_sale"], 2)?></span></span></li>
			</ul>
			<ul class="list list4 total">
				<li class="th">총 결제금액</li>
				<li class="td"><span class="sum_price settle_price" id="totalPrice"><?php echo get_currency_price($TPL_VAR["total_price"], 2,'','<span class="num">_str_price_</span>')?></span></li>
			</ul>
		</div>

		<ul class="cart_order_btn_area">
<?php if($TPL_VAR["btn_estimateyn"]=='y'){?>
			<li>
				<button type="button" class="btn_resp size_c btn_select_estimate">전체 견적서</button>
			</li>
<?php }?>
			<li>
				<input type="button" class="btn_resp size_c color2 btn_all_order" <?php if($TPL_VAR["total_ea"]< 1){?>onclick="openDialogAlert('주문할 상품을 선택해 주세요.','400','140');return false;" <?php }?> value="전체 주문하기" />
			</li>
		</ul>
		<div class="pdb10 center"><?php echo $TPL_VAR["navercheckout_tpl"]?></div>
		<div class="pdb10 center"><?php echo $TPL_VAR["talkbuyorder_tpl"]?></div>
	</li>
	<!-- ++++++++++++ //cart right area +++++++++++ -->
</ul>
<!-- <?php }else{?> -->
<div class="no_data_area2">
	장바구니에 담긴 상품이 없습니다.
</div>
<!-- <?php }?> -->


	
		


	<div class="total_price_n_btns">
		

		
	</div>


	




</form>


	<div align="center" id="facebook_mgs"><?php if($TPL_VAR["is_file_facebook_tag"]){?>페이스북과 정보를 교환 중에 있습니다. 잠시만 기다려 주세요.<?php }?>.</div>

	<div id="optional_changes_dialog" style="display:none;"></div>

	<!-- 배송 변경 레이어 -->
	<div id="shipping_detail_lay" class="resp_layer_pop hide">
		<h4 class="title">배송 변경</h4>
		<div class="y_scroll_auto2">
			<div class="layer_pop_contents v5"></div>
		</div>
		<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
	</div>
	<!--div id="shipping_detail_lay" style="display:none;"></div-->

<?php $this->print_("INTERNATIONAL_SHIPPING_INFO",$TPL_SCP,1);?>


	<!-- 본문내용 끝 -->
<?php if($TPL_VAR["is_file_facebook_tag"]){?>
		<!-- 좋아요할인 : 삭제하지 말아주세요 -->
<?php if(!(strstr($_SERVER["HTTP_HOST"],'.firstmall.kr')||$_SERVER["HTTP_HOST"]==$TPL_VAR["APP_DOMAIN"])){?>
<iframe name="snsiframe" src="//<?php echo $TPL_VAR["config_system"]["subDomain"]?>/admin/sns/subdomainfacebookck" frameborder="0" width="0" height="0"></iframe>
<script language="JavaScript" src="//<?php echo $TPL_VAR["config_system"]["subDomain"]?>/order/fblike_opengraph_firstmallplus?firstmallcartid=<?php echo $TPL_VAR["firstmallcartid"]?>"></script>
<script language="JavaScript" src="//<?php echo $TPL_VAR["config_system"]["subDomain"]?>/order/fbopengraph?firstmallcartid=<?php echo $TPL_VAR["firstmallcartid"]?>"></script>
<?php }?>
		<script language="JavaScript" src="../order/fblike_opengraph"></script>
		<!-- 좋아요할인 : 삭제하지 말아주세요 -->
<?php }?>



<script type="text/javascript">
<?php if($TPL_VAR["APP_LIKE_TYPE"]=='API'){?>
	try{
		window.fbAsyncInit = function() {
			FB.init({
			appId      : plus_app_id, //App ID
			status     : true, // check login status
			cookie     : true, // enable cookies to allow the server to access the session
			xfbml      : true,  // parse XFBML,
			oauth      : true,
			version    : 'v<?php echo $TPL_VAR["APP_VER"]?>'
			});
<?php if($TPL_VAR["cfg"]["order"]["fblike_ordertype"]&&$TPL_VAR["fblikesale"]){?>
				FB.getLoginStatus(function(response) {
					$("#fbloginlay").hide();
<?php if(!$TPL_VAR["fbuser"]){?>
							$.ajax({'url' : '../sns_process/facebooklogincknone', 'type' : 'post'});
<?php }?>
					if (response.status === 'connected') {
						var uid = response.authResponse.userID;
						var accessToken = response.authResponse.accessToken;
					} else if (response.status === 'not_authorized') {
						$("#fbloginlay").show();
					} else {
						$("#fbloginlay").show();
					}
				});
<?php }?>
<?php if($TPL_VAR["APP_USE"]=='f'){?>
				// like 이벤트가 발생할때 호출된다.
				FB.Event.subscribe('edge.create', function(response) {
					//페이스북과 정보를 교환 중에 있습니다. 잠시만 기다려 주세요.
					$("#facebook_mgs").html(getAlert('oc039'));
<?php if(($_SERVER["HTTP_HOST"]==$TPL_VAR["APP_DOMAIN"])){?>
						$.ajax({'url' : '../sns_process/facebooklikeck', 'type' : 'post', 'data' : {'mode':'like', 'product_url':response}, 'dataType': 'json','success': function(result){$("#facebook_mgs").html("");order_price_calculate();}});
<?php }else{?>
						var url = '../sns_process/facebooklikeck?mode=like&firstmallcartid=<?php echo $TPL_VAR["firstmallcartid"]?>&product_url='+response;
						$.getJSON(url + "&jsoncallback=?", function(res) {$("#facebook_mgs").html("");order_price_calculate();});
<?php }?>
				});

				// unlike 이벤트가 발생할때 호출된다.
				FB.Event.subscribe('edge.remove', function(response) {
					//페이스북과 정보를 교환 중에 있습니다. 잠시만 기다려 주세요.
					$("#facebook_mgs").html(getAlert('oc039'));
<?php if(($_SERVER["HTTP_HOST"]==$TPL_VAR["APP_DOMAIN"])){?>
						$.ajax({'url' : '../sns_process/facebooklikeck', 'type' : 'post', 'data' : {'mode':'unlike', 'product_url':response}, 'dataType': 'json','success': function(result){$("#facebook_mgs").html("");order_price_calculate();}});
<?php }else{?>
						var url = '../sns_process/facebooklikeck?mode=unlike&firstmallcartid=<?php echo $TPL_VAR["firstmallcartid"]?>&product_url='+response;
						$.getJSON(url + "&jsoncallback=?", function(res) {$("#facebook_mgs").html("");order_price_calculate();});
<?php }?>
				});//
<?php }?>
		}
	} catch (facebookjsok) {
	}
<?php }?>

	$(document).ready(function() {
		
		var cartVersion = $('input[name=cart_version]').val(); //18-05-03 카트 스킨 버전 gcns jhs add

<?php if(!$TPL_VAR["is_goods"]){?>
		$(".goods_delivery_info").hide();
<?php }?>

		// 전체 선택
		$("form#cart_form .btn_select_all").change(function() {
			if($(this).is(":checked")){
				$("form#cart_form .btn_select_all").attr("checked",true);
				//$("form#cart_form .btn_select_all").closest("div").addClass("ez-checkbox-on");
				$("form#cart_form input[name='cart_option_seq[]']").each(function(){
					$(this).attr("checked",true);
					//$(this).closest("div").addClass("ez-checkbox-on");
				});
				$(".cart_goods").addClass('selected');
				cnt = $("form#cart_form input[name='cart_option_seq[]']").length;
				
				//18-05-03 gcns jhs add 장바구니 개선
				if(cartVersion >= 3){
					setPriceInfoCheck();	//전체 주문선택 금액 계산 추가 gcns jhs add
				}
			}else{
				$("form#cart_form .btn_select_all").removeAttr("checked");
				//$("form#cart_form .btn_select_all").closest("div").removeClass("ez-checkbox-on");
				$("form#cart_form input[name='cart_option_seq[]']").each(function(){
					$(this).removeAttr("checked");
					//$(this).closest("div").removeClass("ez-checkbox-on");
				});
				$(".cart_goods").removeClass('selected');
				//18-05-03 gcns jhs add 장바구니 개선
				if(cartVersion >= 3){				
					setPriceInfoCheck();	//전체 주문선택 금액 계산 추가 gcns jhs add	
				}
			}
		});
		/*
		$("form#cart_form .btn_select_all").change(function() {
			if($(this).is(":checked")){
				$("form#cart_form input[name='cart_option_seq[]']").each(function(){
					$(this).attr("checked",true);
					$(this).closest("div").addClass("ez-checkbox-on");
				});
				$(".cart_goods").css('outline','2px solid #769dff');
				cnt = $("form#cart_form input[name='cart_option_seq[]']").length;
			}else{
				$("form#cart_form input[name='cart_option_seq[]']").each(function(){
					$(this).removeAttr("checked");
					$(this).closest("div").removeClass("ez-checkbox-on");
				});
				$(".cart_goods").css('outline','');
			}
		});
		*/

		// 해당 상품삭제
		$(".btn_thisitem_del").click(function() {
			var selected_order = $(this).val();
			$("input[name='cart_option_seq[]']").removeAttr("checked");
			$("input[name='cart_option_seq[]'][value='"+selected_order+"']").attr("checked", true);

			$("form#cart_form").attr("action","del");
			$("form#cart_form").attr("target","actionFrame");
			$("form#cart_form")[0].submit();
		});

		// 선택 상품 삭제
		$(".btn_select_del").click(function() {
			var selected_order = '';
			$("input[name='cart_option_seq[]']").each(function(e, el) {
				if( $(el).attr('checked') == 'checked' ){
					selected_order += $(el).val() + ",";
				}
			});
			if(!selected_order){
				//삭제할 상품을 선택해 주세요.
				openDialogAlert(getAlert('oc003'),'400','140');
				return false;
			}
			$("form#cart_form").attr("action","del");
			$("form#cart_form").attr("target","actionFrame");
			$("form#cart_form")[0].submit();
		});


		// 옵션/수량변경 클릭시
		$("button.btn_option_modify").bind("click",function() {
			var id = $(this).attr("id");
			var url = "optional_changes?no="+id+"&t="+new Date().getTime();
			var area_obj = $("#optional_changes_area_"+id);
			$.get(url, function(data) {
				area_obj.find('#onContent').empty().html(data);
				showCenterLayer(area_obj);
			});
		});

		// 바로구매
		$(".btn_direct_buy").bind("click",function() {
			var selected_order = $(this).val();
			$("input[name='cart_option_seq[]']").removeAttr("checked");
			$("input[name='cart_option_seq[]'][value='"+selected_order+"']").attr("checked", true);

			//$("form#cart_form").attr("action","settle?mode=choice");
			$("form#cart_form").attr("action","addsettle?mode=choice");
			$("form#cart_form").attr("target","");
			$("form#cart_form")[0].submit();
			$("form#cart_form").attr("target","actionFrame");
		});

		// 선택 주문
		$(".btn_selected_order").bind("click",function() {
			var selected_order = '';
			var ship_possible = true;
			$("input[name='cart_option_seq[]']").each(function(e, el) {
				if( $(el).attr('checked') == 'checked' ){
					if( $(el).attr('stat') != 'Y' ){
						ship_possible = false;
						return false;
					}
					selected_order += $(el).val() + ",";
				}
			});

			if(!ship_possible){
				// 주문이 불가능한 상품이 있습니다.
				openDialogAlert(getAlert('os142'),'400','140');
				return false;
			}

			if(!selected_order){
				//주문할 상품을 선택해 주세요.
				openDialogAlert(getAlert('oc042'),'400','140');
				return false;
			}

			//$("form#cart_form").attr("action","settle?mode=choice");
			$("form#cart_form").attr("action","addsettle?mode=choice");
			$("form#cart_form").attr("target","");
			$("form#cart_form")[0].submit();
			$("form#cart_form").attr("target","actionFrame");
		});

		// 전체 주문
		$(".btn_all_order").bind("click",function() {
			$("form#cart_form").attr("action","addsettle");
			$("form#cart_form").attr("target","actionFrame");
			$("form#cart_form")[0].submit();
		});

		// 선택 위시리스트 저장
		$(".btn_select_wishlist").bind("click",function(){
			$("form#cart_form").attr("action","../mypage/wish_add?mode=cart");
			$("form#cart_form").attr("target","actionFrame");
			$("form#cart_form")[0].submit();
		});

		// 비우기
		$(".btn_select_all_del").bind("click",function(){
			$("input[name='cart_option_seq[]']").attr("checked",true);

			$("form#cart_form").attr("action","del");
			$("form#cart_form").attr("target","actionFrame");
			$("form#cart_form")[0].submit();
		});

		// 상품 선택시
		$("input[name='cart_option_seq[]']").bind("click",function(){
			var obj = eval("cart_goods_" + $(this).val());
			if($(this).is(":checked")){
				$(obj).addClass('selected');
				cnt = $("input[name='cart_option_seq[]']:checked").length;
			}else{
				$(obj).removeClass('selected');
				cnt = $("input[name='cart_option_seq[]']:checked").length;
			}
		});

<?php if($TPL_VAR["cart_promotioncode"]){?>
			getPromotionckloding();
<?php }?>

		//배송 방법 변경 이벤트
		bind_shipping_modify_btn();

		// 배송국가 선택 레이어 팝업 이벤트
		$("#select_other_country").bind("click",function() {
			showCenterLayer('#select_country_layer_pop');
		});

		//  견적서 출력
		$(".btn_select_estimate").bind("click",function(){
			var win = window.open('/prints/form_print_estimate?code=cart', '_estimate', 'width=960,height=760, scrollbars=yes');
			win.focus();
		});
	//	order_price_calculate();
	});

	function getPromotionckloding() {
		var cartpromotioncode = '<?php echo $TPL_VAR["cart_promotioncode"]?>';
		if( cartpromotioncode  ) {
			$.ajax({
				'url' : '../promotion/getPromotionJson?mode=cart',
				'data' : {'cartpromotioncode':cartpromotioncode},
				'type' : 'post',
				'dataType': 'json',
				'success': function(data) {
					order_price_calculate();
				}
			});
		}
	}

	// facebook 라이크 할인 적용 및 오픈그라피
	function getfblikeopengraph(){
		$.get('../order/fblike_opengraph', function(data) {
			$("#facebook_mgs").html("");
		});
	}

	function order_price_calculate()
	{
		var f = $("form#orderFrm");

		f.attr("action","calculate?mode=cart");
		f.attr("target","actionFrame");
		f[0].submit();
	}
	
	// 묶음배송상품보기
	function bundle_goods_search(grp_seq){ 
		window.open('/goods/search?ship_grp_seq='+grp_seq);
	}
	
	// 배송국가 선택 이벤트
	function chg_shipping_nation(nation){
		var tmpFrm	= '<form name="nationFrm" id="nationFrm" method="post" action="./cart"><input type="hidden" name="nation" value="' + nation + '"></form>';
		$('body').append(tmpFrm);
		$("#nationFrm").submit();
	}
</script>

<form name="orderFrm" id="orderFrm" method="post" action="cacluate" target="actionFrame"></form>