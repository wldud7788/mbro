<?php /* Template_ 2.2.6 2020/12/31 10:49:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/order_view.html 000129167 */ 
$TPL_shipping_group_items_1=empty($TPL_VAR["shipping_group_items"])||!is_array($TPL_VAR["shipping_group_items"])?0:count($TPL_VAR["shipping_group_items"]);
$TPL_order_shippings_1=empty($TPL_VAR["order_shippings"])||!is_array($TPL_VAR["order_shippings"])?0:count($TPL_VAR["order_shippings"]);
$TPL_cancel_log_1=empty($TPL_VAR["cancel_log"])||!is_array($TPL_VAR["cancel_log"])?0:count($TPL_VAR["cancel_log"]);
$TPL_data_return_1=empty($TPL_VAR["data_return"])||!is_array($TPL_VAR["data_return"])?0:count($TPL_VAR["data_return"]);
$TPL_data_refund_1=empty($TPL_VAR["data_refund"])||!is_array($TPL_VAR["data_refund"])?0:count($TPL_VAR["data_refund"]);
$TPL_lately_msg_1=empty($TPL_VAR["lately_msg"])||!is_array($TPL_VAR["lately_msg"])?0:count($TPL_VAR["lately_msg"]);
$TPL_arr_address_group_1=empty($TPL_VAR["arr_address_group"])||!is_array($TPL_VAR["arr_address_group"])?0:count($TPL_VAR["arr_address_group"]);
$TPL_ship_gl_arr_1=empty($TPL_VAR["ship_gl_arr"])||!is_array($TPL_VAR["ship_gl_arr"])?0:count($TPL_VAR["ship_gl_arr"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 주문/배송 상세 @@
- 파일위치 : [스킨폴더]/mypage/order_view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_VAR["config_system"]["pgCompany"]=="lg"){?><script type="text/javascript" src="//pgweb.uplus.co.kr/WEB_SERVER/js/receipt_link.js"></script><?php }?>
<?php if($TPL_VAR["config_system"]["pgCompany"]=="allat"){?> <?php }?>

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfdmlldy5odG1s" >주문/배송 상세</span></h2>
		</div>

		<ul class="myorder_sort">
			<li class="list1">
				<h3 class="title_sub4 Pt0 Pb0">주문상품</h3>
			</li>
			<li class="list2 Pt5">
<?php if($TPL_VAR["orders"]["payment"]!='pos_pay'){?>
<?php if($TPL_VAR["orders"]["step"]== 15){?>
					<button type="button" class="btn_resp size_b pointcolor3 imp" onclick="order_cancel('<?php echo $TPL_VAR["orders"]["order_seq"]?>');">주문무효</button>
<?php }?>
<?php if($TPL_VAR["refund_able_ea"]&&$TPL_VAR["orders"]["step"]>= 25&&$TPL_VAR["orders"]["step"]< 85&&!$TPL_VAR["orders"]["orign_order_seq"]){?>
					<button type="button" class="btn_resp size_b pointcolor3 imp" onclick="order_refund('<?php echo $TPL_VAR["orders"]["order_seq"]?>');">결제취소</button>
<?php }?>
<?php if($TPL_VAR["items_tot"]["coupontotal"]> 0&&in_array($TPL_VAR["orders"]["step"],array( 40, 50, 55, 60, 70, 75))){?>
					<button type="button" class="btn_resp size_b pointcolor3 imp" onclick="order_return_coupon('<?php echo $TPL_VAR["orders"]["order_seq"]?>');">티켓상품 환불신청</button>
<?php }?>
<?php if(($TPL_VAR["items_tot"]["goodstotal"]&&$TPL_VAR["return_able_ea"])){?>
					<button type="button" class="btn_resp size_b pointcolor3 imp" onclick="order_return('<?php echo $TPL_VAR["orders"]["order_seq"]?>');">반품신청</button>
					<button type="button" class="btn_resp size_b pointcolor3 imp" onclick="order_exchange('<?php echo $TPL_VAR["orders"]["order_seq"]?>');">교환신청</button>
<?php }?>
<?php }?>
<?php if($TPL_VAR["is_btn_tradeinfo"]){?>
				<button type="button" class="btn_resp size_b color5" onclick="<?php echo $TPL_VAR["btn_tradeinfo_script"]?>">거래명세서</button>
<?php }?>
			</li>
		</ul>

		<div class="res_table">
			<ul class="thead">
				<li>주문상품</li>
				<li style="width:45px;">수량</li>
				<li style="width:90px;">상품금액</li>
				<li style="width:75px;">할인금액</li>
				<li style="width:90px;">할인적용금액</li>
<?php if($TPL_VAR["orders"]["member_seq"]){?><li style="width:64px;">적립</li><?php }?>
				<li style="width:80px;">상태</li>
				<li class="goods_delivery_info" style="width:100px;">배송비</li>
			</ul>
<?php if($TPL_shipping_group_items_1){foreach($TPL_VAR["shipping_group_items"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["items"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if(is_array($TPL_R3=$TPL_V2["options"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
<?php if($TPL_V2["goods_type"]=='gift'){?>
			<ul class="tbody gift <?php if($TPL_I2== 0&&$TPL_I3== 0){?><?php }else{?>besong_grouped<?php }?>">
<?php }else{?>
			<ul class="tbody <?php if($TPL_I2== 0&&$TPL_I3== 0){?><?php }else{?>besong_grouped<?php }?>">
<?php }?>
				<li class="subject">
					<ul class="board_goods_list">
						<li class="pic">
<?php if($TPL_V2["goods_type"]=='gift'){?>
							<img src="<?php echo $TPL_V2["image"]?>" alt="" designImgSrcOri='ey4uaW1hZ2V9' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfdmlldy5odG1s' designImgSrc='ey4uaW1hZ2V9' designElement='image' />
<?php }else{?>
							<a href='/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>' target='_blank' title="새창" hrefOri='L2dvb2RzL3ZpZXc/bm89ey4uZ29vZHNfc2VxfQ==' ><img src="<?php echo $TPL_V2["image"]?>" alt="<?php echo $TPL_V1["goods_name"]?>" designImgSrcOri='ey4uaW1hZ2V9' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfdmlldy5odG1s' designImgSrc='ey4uaW1hZ2V9' designElement='image' /></a>
<?php }?>
						</li>
						<li class="info">
							<div class="title">
<?php if($TPL_V2["goods_type"]=='gift'||$TPL_V2["cancel_type"]=='1'||$TPL_V2["tax"]=='exempt'){?>
								<div class="Pb5">
<?php if($TPL_V2["goods_type"]=='gift'){?>
									<span class="pointcolor2">[사은품]</span>
<?php }?>
<?php if($TPL_V2["cancel_type"]=='1'){?>
									<span class="pointcolor2">[청약철회불가]</span>
<?php }?>
<?php if($TPL_V2["tax"]=='exempt'){?>
									<span class="pointcolor2">[비과세]</span>
<?php }?>
								</div>
<?php }?>
<?php if($TPL_V2["goods_type"]=='gift'){?>
								<?php echo $TPL_V2["goods_name"]?>

<?php }else{?>
								<a href='/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>' target='_blank' title="새창" hrefOri='L2dvb2RzL3ZpZXc/bm89ey4uZ29vZHNfc2VxfQ==' ><?php echo $TPL_V2["goods_name"]?></a>
<?php }?>
<?php if($TPL_V2["adult_goods"]=='Y'){?>
								<img src="/data/skin/responsive_diary_petit_gl/images/common/auth_img.png" height="17" alt="성인" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9hdXRoX2ltZy5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfdmlldy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vYXV0aF9pbWcucG5n' designElement='image' />
<?php }?>
<?php if($TPL_V2["option_international_shipping_status"]=='y'){?>
								<img src="/data/skin/responsive_diary_petit_gl/images/common/plane.png" height="14" alt="해외배송상품" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9wbGFuZS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfdmlldy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vcGxhbmUucG5n' designElement='image' />
<?php }?>
							</div>
<?php if($TPL_V3["option1"]){?>
							<div class="cont3">
								<span class="res_option_inline"><?php if($TPL_V3["title1"]){?><span class="xtle"><?php echo $TPL_V3["title1"]?></span><?php }?><?php echo $TPL_V3["option1"]?></span>
<?php if($TPL_V3["option2"]){?><span class="res_option_inline"><?php if($TPL_V3["title2"]){?><span class="xtle"><?php echo $TPL_V3["title2"]?></span><?php }?><?php echo $TPL_V3["option2"]?></span><?php }?>
<?php if($TPL_V3["option3"]){?><span class="res_option_inline"><?php if($TPL_V3["title3"]){?><span class="xtle"><?php echo $TPL_V3["title3"]?></span><?php }?><?php echo $TPL_V3["option3"]?></span><?php }?>
<?php if($TPL_V3["option4"]){?><span class="res_option_inline"><?php if($TPL_V3["title4"]){?><span class="xtle"><?php echo $TPL_V3["title4"]?></span><?php }?><?php echo $TPL_V3["option4"]?></span><?php }?>
<?php if($TPL_V3["option5"]){?><span class="res_option_inline"><?php if($TPL_V3["title5"]){?><span class="xtle"><?php echo $TPL_V3["title5"]?></span><?php }?><?php echo $TPL_V3["option5"]?></span><?php }?>
							</div>
<?php }?>
<?php if($TPL_V3["inputs"]){?>
							<div class="cont3">
<?php if(is_array($TPL_R4=$TPL_V3["inputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
<?php if($TPL_V4["value"]){?>
								<span class="res_option_inline">
<?php if($TPL_V4["title"]){?><span class="xtle v2"><?php echo $TPL_V4["title"]?></span><?php }?><?php if($TPL_V4["type"]=='file'){?><a href="../mypage_process/filedown?file=<?php echo $TPL_V3["value"]?>" target="actionFrame" class="gray_05" title="다운로드" hrefOri='Li4vbXlwYWdlX3Byb2Nlc3MvZmlsZWRvd24/ZmlsZT17Li4udmFsdWV9' ><?php echo $TPL_V4["value"]?></a><?php }else{?><?php echo $TPL_V4["value"]?><?php }?>
								</span>
<?php }?>
<?php }}?>
							</div>
<?php }?>
<?php if($TPL_V2["goods_type"]=='gift'){?>
<?php if($TPL_V2["gift_title"]){?>
								<div class="cont2">
									<?php echo $TPL_V2["gift_title"]?> <button type="button" class="gift_log btn_resp size_a color6" order_seq="<?php echo $TPL_VAR["orders"]["order_seq"]?>" item_seq="<?php echo $TPL_V2["item_seq"]?>">자세히</button>
								</div>
<?php }?>
<?php }?>
						</li>
					</ul>
				</li>
				<li><span class="mtitle">수량:</span> <?php echo $TPL_V3["ea"]?></li>
				<li class="right"><span class="mtitle">금액:</span> <?php echo get_currency_price($TPL_V3["out_price"], 2)?></li>
				<li class="right">
					<span class="mtitle">할인:</span>
					<span class="pointcolor3"><?php echo get_currency_price($TPL_V3["out_event_sale"]+$TPL_V3["out_multi_sale"]+$TPL_V3["out_coupon_sale"]+$TPL_V3["out_member_sale"]+$TPL_V3["out_fblike_sale"]+$TPL_V3["out_mobile_sale"]+$TPL_V3["out_promotion_code_sale"]+$TPL_V3["out_referer_sale"], 2)?></span>

<?php if(($TPL_V3["out_event_sale"]+$TPL_V3["out_multi_sale"]+$TPL_V3["out_coupon_sale"]+$TPL_V3["out_member_sale"]+$TPL_V3["out_fblike_sale"]+$TPL_V3["out_mobile_sale"]+$TPL_V3["out_promotion_code_sale"]+$TPL_V3["out_referer_sale"])> 0){?>
					<button type="button" class="btn_resp size_a" onclick="showCenterLayer(this, 'brother')">내역</button>
					<div class="resp_layer_pop hide">
						<h4 class="title">할인 내역</h4>
						<div class="y_scroll_auto2">
							<div class="layer_pop_contents v5">
								<table class="table_row_a" cellpadding="0" cellspacing="0">
									<colgroup><col class="size_a" /><col /></colgroup>
									<tbody>
<?php if($TPL_V3["out_event_sale"]&&$TPL_V3["out_event_sale"]> 0){?>
										<tr>
											<th scope="row"><p>이벤트할인</p></th>
											<td><?php echo get_currency_price($TPL_V3["out_event_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V3["out_multi_sale"]&&$TPL_V3["out_multi_sale"]> 0){?>
										<tr>
											<th scope="row"><p>복수구매할인</p></th>
											<td><?php echo get_currency_price($TPL_V3["out_multi_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V3["out_member_sale"]&&$TPL_V3["out_member_sale"]> 0){?>
										<tr>
											<th scope="row"><p>등급할인</p></th>
											<td><?php echo get_currency_price($TPL_V3["out_member_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V3["out_mobile_sale"]&&$TPL_V3["out_mobile_sale"]> 0){?>
										<tr>
											<th scope="row"><p>모바일</p></th>
											<td><?php echo get_currency_price($TPL_V3["out_mobile_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V3["out_fblike_sale"]&&$TPL_V3["out_fblike_sale"]> 0){?>
										<tr>
											<th scope="row"><p>좋아요</p></th>
											<td><?php echo get_currency_price($TPL_V3["out_fblike_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V3["out_coupon_sale"]&&$TPL_V3["out_coupon_sale"]> 0){?>
										<tr>
											<th scope="row"><p>쿠폰할인</p></th>
											<td><?php echo get_currency_price($TPL_V3["out_coupon_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V3["out_promotion_code_sale"]&&$TPL_V3["out_promotion_code_sale"]> 0){?>
										<tr>
											<th scope="row"><p>코드할인</p></th>
											<td><?php echo get_currency_price($TPL_V3["out_promotion_code_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V3["out_referer_sale"]&&$TPL_V3["out_referer_sale"]> 0){?>
										<tr>
											<th scope="row"><p>유입경로</p></th>
											<td><?php echo get_currency_price($TPL_V3["out_referer_sale"], 2)?></td>
										</tr>
<?php }?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="layer_bottom_btn_area2">
							<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
						</div>
						<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
					</div>
<?php }?>
				</li>
				<li class="right">
					<span class="mtitle">할인적용:</span>
					<strong class="pointcolor2"><?php echo get_currency_price($TPL_V3["out_price"]-$TPL_V3["out_tot_sale"], 2)?></strong>
				</li>
<?php if($TPL_VAR["orders"]["member_seq"]){?>
				<li class="right">
					<span class="mtitle">적립:</span>
					<?php echo get_currency_price($TPL_V3["out_reserve"], 2)?><?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?><div class="res_point_span"><?php echo get_currency_price($TPL_V3["out_point"])?>P</div><?php }?>
				</li>
<?php }?>
				<li class="mo_end v2">
					<span class="reply_title gray_01">
<?php if($TPL_VAR["orders"]["payment"]!='pos_pay'){?>
                            <?php echo $TPL_V3["mstep"]?>

<?php }else{?>
                            오프라인<br/>매장 주문
<?php }?>
					</span>
				</li>
<?php if($TPL_I2== 0&&$TPL_I3== 0){?>
				<li class="goods_delivery_info besong_group2 left <?php if($TPL_V1["totalitems"]> 1){?>rowspan<?php }?>">
<?php if($TPL_VAR["orders"]["payment"]!='pos_pay'){?>
						<div class="rcont">
							<strong class="mtitle gray_01">배송그룹:</strong>
<?php if($TPL_V1["shipping"]["provider_name"]){?>
							<span class="gray_06">[<?php echo $TPL_V1["shipping"]["provider_name"]?>]</span>
<?php }?>
<?php if($TPL_V1["shipping"]["shipping_set_code"]=='coupon'){?>
								[티켓발송]
<?php }else{?>
								<div class="Dib"><?php echo $TPL_V1["shipping"]["shipping_set_name"]?></div>
<?php if($TPL_V1["shipping"]["delivery_cost"]> 0){?>
								<div><strong class="pointcolor2"><?php echo get_currency_price($TPL_V1["shipping"]["shipping_cost"], 2)?></strong></div>
<?php }else{?>
								<div><strong class="pointcolor">무료</strong></div>
<?php }?>
<?php }?>

<?php if($TPL_V1["shipping"]["shipping_set_code"]=='direct_store'){?>
							<div class="ship_info">수령매장 : <?php echo $TPL_V1["shipping"]["shipping_store_name"]?></div>
<?php }else{?>
<?php if($TPL_V1["shipping"]["delivery_cost"]> 0){?>
<?php if($TPL_V1["shipping"]["shipping_type"]=='prepay'){?>
							<div class="ship_info">(주문시 결제)</div>
<?php }elseif($TPL_V1["shipping"]["shipping_type"]=='postpaid'){?>
							<div class="ship_info">(착불)</div>
<?php }else{?>
							<div class="ship_info">(무료)</div>
<?php }?>
<?php }?>
<?php }?>
<?php if($TPL_V1["shipping"]["shipping_hop_date"]){?>
							<div class="ship_info">희망배송일 : <?php echo $TPL_V1["shipping"]["shipping_hop_date"]?></div>
<?php }elseif($TPL_V1["shipping"]["reserve_sdate"]){?>
							<div class="ship_info">예약배송일 : <?php echo $TPL_V1["shipping"]["reserve_sdate"]?></div>
<?php }?>
						</div>
<?php }else{?>
						<div class="rcont">
							<div class="ship_info"><?php echo $TPL_V1["shipping"]["shipping_store_name"]?></div>
						</div>
<?php }?>
				</li>
<?php }else{?>
				<li class="rowspaned"></li>
<?php }?>
			</ul>

<?php if(is_array($TPL_R4=$TPL_V3["suboptions"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
			<ul class="tbody suboptions">
				<li class="subject">
<?php if($TPL_V4["suboption"]){?>
					<div class="reply_ui">
<?php if($TPL_V4["title"]){?><span class="xtle v3"><?php echo $TPL_V4["title"]?></span><?php }?> <?php echo $TPL_V4["suboption"]?>

					</div>
<?php }?>
				</li>
				<li><span class="mtitle">수량:</span> <?php echo $TPL_V4["ea"]?></li>
				<li class="right"><span class="mtitle">금액:</span> <?php echo get_currency_price($TPL_V4["out_price"], 2)?></li>
				<li class="right">
					<span class="mtitle">할인:</span>
					<span class="pointcolor3"><?php echo get_currency_price($TPL_V4["out_event_sale"]+$TPL_V4["out_multi_sale"]+$TPL_V4["out_coupon_sale"]+$TPL_V4["out_member_sale"]+$TPL_V4["out_fblike_sale"]+$TPL_V4["out_mobile_sale"]+$TPL_V4["out_promotion_code_sale"]+$TPL_V4["out_referer_sale"], 2)?></span>
<?php if(($TPL_V4["out_event_sale"]+$TPL_V4["out_multi_sale"]+$TPL_V4["out_coupon_sale"]+$TPL_V4["out_member_sale"]+$TPL_V4["out_fblike_sale"]+$TPL_V4["out_mobile_sale"]+$TPL_V4["out_promotion_code_sale"]+$TPL_V4["out_referer_sale"])> 0){?>
					<button type="button" class="btn_resp size_a" onclick="showCenterLayer(this, 'brother')">내역</button>
					<div class="resp_layer_pop hide">
						<h4 class="title">할인 내역</h4>
						<div class="y_scroll_auto2">
							<div class="layer_pop_contents v5">
								<table class="table_row_a" cellpadding="0" cellspacing="0">
									<colgroup><col class="size_a" /><col /></colgroup>
									<tbody>
<?php if($TPL_V3["out_event_sale"]){?>
										<tr>
											<th scope="row"><p>이벤트할인</p></th>
											<td><?php echo get_currency_price($TPL_V3["out_event_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V3["out_multi_sale"]){?>
										<tr>
											<th scope="row"><p>복수구매할인</p></th>
											<td><?php echo get_currency_price($TPL_V3["out_multi_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V4["out_member_sale"]){?>
										<tr>
											<th scope="row"><p>등급할인</p></th>
											<td><?php echo get_currency_price($TPL_V4["out_member_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V4["out_mobile_sale"]){?>
										<tr>
											<th scope="row"><p>모바일</p></th>
											<td><?php echo get_currency_price($TPL_V4["out_mobile_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V4["out_fblike_sale"]){?>
										<tr>
											<th scope="row"><p>좋아요</p></th>
											<td><?php echo get_currency_price($TPL_V4["out_fblike_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V4["out_coupon_sale"]){?>
										<tr>
											<th scope="row"><p>쿠폰할인</p></th>
											<td><?php echo get_currency_price($TPL_V4["out_coupon_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V4["out_promotion_code_sale"]){?>
										<tr>
											<th scope="row"><p>코드할인</p></th>
											<td><?php echo get_currency_price($TPL_V4["out_promotion_code_sale"], 2)?></td>
										</tr>
<?php }?>
<?php if($TPL_V4["out_referer_sale"]){?>
										<tr>
											<th scope="row"><p>유입경로</p></th>
											<td><?php echo get_currency_price($TPL_V4["out_referer_sale"], 2)?></td>
										</tr>
<?php }?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="layer_bottom_btn_area2">
							<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
						</div>
						<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
					</div>
<?php }?>
				</li>
				<li class="right">
					<span class="mtitle">할인적용:</span>
					<strong class="pointcolor2"><?php echo get_currency_price($TPL_V4["out_price"]-$TPL_V4["out_tot_sale"], 2)?></strong>
				</li>
<?php if($TPL_VAR["orders"]["member_seq"]){?>
				<li class="right">
					<span class="mtitle">적립:</span>
					<?php echo get_currency_price($TPL_V4["out_reserve"], 2)?><?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?><div class="res_point_span"><?php echo get_currency_price($TPL_V4["out_point"])?>P</div><?php }?>
				</li>
<?php }?>
				<li class="mo_end v2 gray_01">
					<span class="reply_title gray_01">
<?php if($TPL_VAR["orders"]["payment"]!='pos_pay'){?>
							<?php echo $TPL_V4["mstep"]?>

<?php }else{?>
                            오프라인<br/>매장 주문
<?php }?>
					</span>
				</li>
				<li class="rowspaned"></li>
			</ul>
<?php }}?>

<?php }}?>
<?php }}?>
<?php }}?>
		</div>


		<ul class="sub_layout_z1">

			<!-- ++++++++++++++ LEFT Area ++++++++++++++ -->
			<li class="layout_aside_a">
				<h3 class="title_sub4">주문자</h3>
				<ul class="list_01 v2">
					<li>
						<strong class="Fs15 gray_01"><?php echo $TPL_VAR["orders"]["order_user_name"]?></strong>
					</li>
					<li>
						<span class="phone1"><?php echo $TPL_VAR["orders"]["order_cellphone"]?></span>
<?php if($TPL_VAR["orders"]["order_phone"]){?>
						<span class="gray_07">&nbsp;/&nbsp;</span>
						<span class="Dib phone2"><?php echo $TPL_VAR["orders"]["order_phone"]?></span>
<?php }?>
<?php if($TPL_VAR["orders"]["order_email"]){?>
						<span class="gray_07">&nbsp;/&nbsp;</span>
						<span class="Dib email1"><?php echo $TPL_VAR["orders"]["order_email"]?></span>
<?php }?>
					</li>
				</ul>

				<div class="orderSettle">
					<h3 class="title_sub4">배송지</h3>
					<div id="view_address_wrap">
						<ul class="delivery_member list_01 v2">
							<li>
								<strong class="recipient_user_name Fs15 pointcolor imp"><?php echo $TPL_VAR["orders"]["recipient_user_name"]?></strong> &nbsp;
<?php if($TPL_VAR["orders"]["step"]<= 25&&$TPL_VAR["orders"]["shipping_group_exists"]=='Y'&&$TPL_VAR["orders"]["shipping_group_set_exists"]=='Y'){?>
									<button type="button" class="btn_resp" onclick="mode_change('address_wrap', 'edit')">수정</button>
<?php if(defined('__ISUSER__')&&$TPL_VAR["is_goods"]){?>
									<!-- 에러 개선될때까지 미노출 처리 -->
									<button type="button" class="btn_resp" style="display:none;" onclick="popDeliveryaddress();">배송주소록</button>
<?php }?>
<?php }?>
							</li>
<?php if($TPL_VAR["is_goods"]){?>
							<li class="domestic" <?php if($TPL_VAR["orders"]["international"]!='domestic'){?>style="display:none;"<?php }?>>
								[<span class="recipient_zipcode"><?php echo $TPL_VAR["orders"]["merge_recipient_zipcode"]?></span>]
<?php if($TPL_VAR["orders"]["recipient_address_type"]=='street'){?>
								<span class="recipient_address_street data2"><?php echo $TPL_VAR["orders"]["recipient_address_street"]?></span>
<?php }else{?>
								<span class="recipient_address data2"><?php echo $TPL_VAR["orders"]["recipient_address"]?></span>
<?php }?>
								<span class="recipient_address_detail"><?php echo $TPL_VAR["orders"]["recipient_address_detail"]?></span><br/>
								<span class="desc">
								(
<?php if($TPL_VAR["orders"]["recipient_address_type"]=='street'){?>
									<span class="recipient_address data2"><?php echo $TPL_VAR["orders"]["recipient_address"]?></span>
<?php }else{?>
									<span class="recipient_address_street data2"><?php echo $TPL_VAR["orders"]["recipient_address_street"]?></span>
<?php }?>
									<span class="recipient_address_detail"><?php echo $TPL_VAR["orders"]["recipient_address_detail"]?></span>
								)
								</span>
							</li>
							<li class="international" <?php if($TPL_VAR["orders"]["international"]!='international'){?>style="display:none;"<?php }?>>
<?php if($TPL_VAR["orders"]["international_address"]){?><span class="international_address"><?php echo $TPL_VAR["orders"]["international_address"]?></span>, <?php }?>
<?php if($TPL_VAR["orders"]["international_town_city"]){?><span class="international_town_city"><?php echo $TPL_VAR["orders"]["international_town_city"]?></span>, <?php }?>
<?php if($TPL_VAR["orders"]["international_county"]){?><span class="international_county"><?php echo $TPL_VAR["orders"]["international_county"]?></span>, <?php }?>
<?php if($TPL_VAR["orders"]["international_country"]){?><span class="international_country"><?php echo $TPL_VAR["orders"]["international_country"]?></span><?php }?>
							</li>
<?php }?>
							<li>
								<span class="recipient_cellphone data2"><?php echo $TPL_VAR["orders"]["merge_recipient_cellphone"]?></span>
								<span <?php if(!$TPL_VAR["orders"]["merge_recipient_phone"]){?>style="display:none;"<?php }?>>
									<span class="gray_07">&nbsp;/&nbsp;</span>
									<span class="Dib recipient_phone data2"><?php echo $TPL_VAR["orders"]["merge_recipient_phone"]?></span>
								</span>
								<span <?php if(!$TPL_VAR["orders"]["recipient_email"]){?>style="display:none;"<?php }?>>
									<span class="gray_07">&nbsp;/&nbsp;</span>
									<span class="Dib recipient_email data2"><?php echo $TPL_VAR["orders"]["recipient_email"]?></span>
								</span>
							</li>
<?php if($TPL_VAR["is_goods"]){?>
							<li class="gray_06">
								배송국가 : <span class="nation_name data2"><?php echo $TPL_VAR["orders"]["nation_name_kor"]?></span>
								<input type="hidden" id="address_nation" name="address_nation" value="<?php echo $TPL_VAR["ini_info"]["nation"]?>" />
							</li>
<?php }?>
<?php if($TPL_VAR["is_direct_store"]){?>
							<li class="desc">※ 매장수령 상품은 매장에서 수령하세요.</li>
<?php }?>
<?php if($TPL_VAR["is_coupon"]){?>
							<li class="desc">※ 티켓번호는 문자와 이메일로 보내드립니다.</li>
<?php }?>
							<li <?php if(!$TPL_VAR["orders"]["each_memo"]&&!$TPL_VAR["orders"]["memo"]){?>style="display:none;"<?php }?>>
<?php if(is_array($TPL_VAR["orders"]["memo"])){?>
<?php if(is_array($TPL_R1=$TPL_VAR["orders"]["memo"]["ship_message"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
								<div>
									<span class="desc">(<?php echo $TPL_VAR["orders"]["memo"]["goods_info"][$TPL_K1]?><?php if($TPL_VAR["orders"]["memo"]["goods_option"][$TPL_K1]){?> - <?php echo $TPL_VAR["orders"]["memo"]["goods_option"][$TPL_K1]?><?php }?>)</span><br/>
									<span class="recipient_ship_messages"><?php echo $TPL_VAR["orders"]["memo"]["ship_message"][$TPL_K1]?></span>
								</div>
<?php }}?>
<?php }else{?>
								<span class="recipient_ship_message"><?php echo $TPL_VAR["orders"]["memo"]?></span>
<?php }?>
							</li>
<?php if($TPL_VAR["orders"]["clearance_unique_personal_code"]){?>
							<li>
								<p class="Pb2">[해외구매대행상품]</p>
								개인통관고유부호: <span class="clearance_unique_personal_code pointcolor"><?php echo $TPL_VAR["orders"]["clearance_unique_personal_code"]?></span>
							</li>
<?php }?>
						</ul>

					</div>

					<form name="recipient" method="post" action="../mypage_process/recipient" target="actionFrame">
					<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["orders"]["order_seq"]?>" />
					<input type="hidden" name="international" value="<?php echo $TPL_VAR["orders"]["international"]?>" />
					<div id="edit_address_wrap" class="resp_layer_pop hide">
						<h4 class="title">배송지 수정</h4>
						<div class="y_scroll_auto2">
							<div class="layer_pop_contents v5">
								<ul class="shipping_delivery_input list_01 v2">
									<li>
										<input type="text" name="recipient_user_name" value="<?php echo $TPL_VAR["orders"]["recipient_user_name"]?>" style="width:170px;" title="받는분" />
									</li>
<?php if($TPL_VAR["is_goods"]){?>
									<!-- 국내 -->
									<li class="domestic goods_delivery_info">
										<input type="text" name="recipient_new_zipcode" value="<?php echo $TPL_VAR["orders"]["merge_recipient_zipcode"]?>" class="size_zip_all" maxlength="7" title="우편번호" readonly />
										<button type="button" class="btn_resp size_b color4" onclick="openDialogZipcode_resp('recipient_');">검색</button>
										<input type="hidden" name="recipient_address_type" value="<?php echo $TPL_VAR["members"]["default_address"]["address_type"]?>" size="45" title="주소구분" />
										<input type="text" name="recipient_address_street" value="<?php echo $TPL_VAR["orders"]["recipient_address_street"]?>" class="size_address Mt5" title="도로명 주소" <?php if($TPL_VAR["orders"]["recipient_address_type"]!='street'){?> style="display:none;"<?php }?> readonly />
										<input type="text" name="recipient_address" value="<?php echo $TPL_VAR["orders"]["recipient_address"]?>" class="size_address Mt5" title="지번주소" <?php if($TPL_VAR["orders"]["recipient_address_type"]=='street'){?>style="display:none;"<?php }?> readonly />
										<input type="text" name="recipient_address_detail" value="<?php echo $TPL_VAR["orders"]["recipient_address_detail"]?>" class="size_address Mt5" title="상세주소" required />
									</li>
									<!-- 해외 -->
									<li class="international goods_delivery_info">
										<select name="region" class="hide">
<?php if(is_array($TPL_R1=$TPL_VAR["shipping_policy"]["policy"][ 1][ 0]["region"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1==$TPL_VAR["orders"]["region"]){?>
											<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }?>
<?php }}?>
										</select>
										<input type="text" name="international_address" value="<?php echo $TPL_VAR["orders"]["international_address"]?>" class="size_full Mt5" title="주소" required />
										<input type="text" name="international_town_city" value="<?php echo $TPL_VAR["orders"]["international_town_city"]?>" class="size_full Mt5" title="시도" required />
										<input type="text" name="international_county" value="<?php echo $TPL_VAR["orders"]["international_county"]?>" class="size_full Mt5" title="주" required />
										<input type="text" name="international_postcode" value="<?php echo $TPL_VAR["orders"]["international_postcode"]?>" class="size_full Mt5" title="우편번호" required />
										<input type="text" class="hide" name="international_country" value="<?php echo $TPL_VAR["orders"]["international_country"]?>" title="국가" readonly required />
									</li>
<?php }?>

									<!-- 연락처 -->
									<li class="base_phone">
										<input type="tel" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["orders"]["recipient_cellphone"][ 0]?>" style="width:64px;" maxlength="4" title="휴대폰" valid="휴대폰" /> -
										<input type="tel" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["orders"]["recipient_cellphone"][ 1]?>" style="width:64px;" maxlength="4" title="휴대폰" valid="휴대폰" /> -
										<input type="tel" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["orders"]["recipient_cellphone"][ 2]?>" style="width:64px;" maxlength="4" title="휴대폰" valid="휴대폰" />
<?php if($TPL_VAR["orders"]["merge_recipient_phone"]){?>
										<button type="button" id="btn_delivery_add_phone" class="add_phone_btn btn_resp size_b color4" onclick="add_phone(this,'close')">추가연락처 ▲</span>
<?php }else{?>
										<button type="button" id="btn_delivery_add_phone" class="add_phone_btn btn_resp size_b" onclick="add_phone(this,'open');">추가연락처 ▼</span>
<?php }?>
									</li>
									<li class="add_phone<?php if(!$TPL_VAR["orders"]["merge_recipient_phone"]){?> hide<?php }?>">
										<input type="tel" class="add_phone_input" name="recipient_phone[]" value="<?php echo $TPL_VAR["orders"]["recipient_phone"][ 0]?>" style="width:64px;" maxlength="4" title="추가" /> -
										<input type="tel" class="add_phone_input" name="recipient_phone[]" value="<?php echo $TPL_VAR["orders"]["recipient_phone"][ 1]?>" style="width:64px;" maxlength="4" title="추가" /> -
										<input type="tel" class="add_phone_input" name="recipient_phone[]" value="<?php echo $TPL_VAR["orders"]["recipient_phone"][ 2]?>" style="width:64px;" maxlength="4" title="추가" />
									</li>

									<li><input type="text" name="recipient_email" value="<?php echo $TPL_VAR["orders"]["recipient_email"]?>" class="size_email_full" title="받는분 이메일주소" /></li>

									<!-- 배송 메세지 -->
									<li id="shipMessage" class="goods_delivery_info">
<?php if(is_array($TPL_VAR["orders"]["memo"])){?>
										<div class="each_ship_msg">
<?php if(is_array($TPL_R1=$TPL_VAR["orders"]["memo"]["ship_message"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
											<div class="ship-lay">
												<div class="goods_info_txt"><?php echo $TPL_VAR["orders"]["memo"]["goods_info"][$TPL_K1]?><?php if($TPL_VAR["orders"]["memo"]["goods_option"][$TPL_K1]){?> - <?php echo $TPL_VAR["orders"]["memo"]["goods_option"][$TPL_K1]?><?php }?></div>
												<div class="ship_message Mt0">
													<input type="text" class="ship_message_txt" name="each_memo[<?php echo $TPL_K1?>]" title="배송 메시지를 입력하세요." value="<?php echo $TPL_VAR["orders"]["memo"]["ship_message"][$TPL_K1]?>" autocomplete="off" />
													<ul class="add_message Mb30">
														<li>배송 전에 미리 연락해 주세요.</li>
														<li>부재시 경비실에 맡겨 주세요.</li>
														<li>부재시 전화 주시거나 문자 남겨 주세요.</li>
													</ul>
												</div>
												<div class="desc Pt5">
													<strong class="cnt_txt gray_01">0</strong> / 300
												</div>
											</div>
<?php }}?>
										</div>
<?php }else{?>
										<div class="ship-lay total_ship_msg">
											<div class="ship_message Mt0">
												<input type="text" class="ship_message_txt" name="memo" id="memo" title="배송 메시지를 입력하세요." value="<?php echo $TPL_VAR["orders"]["memo"]?>" autocomplete="off" />
												<ul class="add_message Mb30">
													<li>배송 전에 미리 연락해 주세요.</li>
													<li>부재시 경비실에 맡겨 주세요.</li>
													<li>부재시 전화 주시거나 문자 남겨 주세요.</li>
												</ul>
											</div>
											<div class="desc Pt5">
												<strong class="cnt_txt gray_01">0</strong> / 300
											</div>
										</div>
<?php }?>
									</li>

<?php if($TPL_VAR["orders"]["clearance_unique_personal_code"]){?>
									<li>
										개인통관고유부호 : <input type="text" name="clearance_unique_personal_code" value="<?php echo $TPL_VAR["orders"]["clearance_unique_personal_code"]?>" style="width:160px;" />
									</li>
<?php }?>
								</ul>
							</div>
						</div>
						<div class="layer_bottom_btn_area2 v2">
							<ul class="basic_btn_area2">
<?php if($TPL_VAR["orders"]["step"]<= 25&&$TPL_VAR["orders"]["shipping_group_exists"]=='Y'&&$TPL_VAR["orders"]["shipping_group_set_exists"]=='Y'){?>
								<li><button type="submit" class="btn_resp size_c color2">수정 완료</button></li>
<?php }?>
								<li><button type="button" class="btn_resp size_c color5" onclick="hideCenterLayer()">취소</button></li>
							</ul>
						</div>
						<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
					</div>
					</form>
				</div>
			</li>
			<!-- ++++++++++++++ //LEFT Area ++++++++++++++ -->

			<!-- ++++++++++++++ RIGHT Area ++++++++++++++ -->
			<li class="layout_aside_b">
				<!-- 결제 금액 -->
				<h3 class="title_sub4">결제 금액</h3>
				<div class="order_price_total">
					<ul>
						<li class="th"><strong>상품금액</strong></li>
						<li class="td"><?php echo get_currency_price($TPL_VAR["items_tot"]["price"], 2,'','<span class="total_goods_price2">_str_price_</span>')?></li>
					</ul>
					<ul>
						<li class="th">
							배송비&nbsp;
							<button type="button" class="btn_resp size_a gray_05" onclick="showCenterLayer('#besongDetailList')">내역</button>
						</li>
						<li class="td">
							(+) <?php echo get_currency_price($TPL_VAR["shipping_tot"]["tot_origin_shipping_cost"], 2)?>

						</li>
					</ul>
					<ul>
						<li class="th">
							할인금액&nbsp;
							<button type="button" class="btn_resp size_a gray_05" onclick="showCenterLayer('#saleDetailList')">내역</button>
						</li>
						<li class="td pointcolor3">
							<span>(-)</span> <?php echo get_currency_price($TPL_VAR["items_tot"]["event_sale"]+$TPL_VAR["items_tot"]["multi_sale"]+$TPL_VAR["items_tot"]["member_sale"]+$TPL_VAR["items_tot"]["mobile_sale"]+$TPL_VAR["items_tot"]["fblike_sale"]+$TPL_VAR["items_tot"]["coupon_sale"]+$TPL_VAR["items_tot"]["promotion_code_sale"]+$TPL_VAR["items_tot"]["referer_sale"]+$TPL_VAR["shipping_tot"]["coupon_sale"]+$TPL_VAR["shipping_tot"]["code_sale"]+$TPL_VAR["orders"]["enuri"], 2)?>

						</li>
					</ul>
<?php if($TPL_VAR["members"]){?>
<?php if($TPL_VAR["orders"]["emoney"]> 0){?>
					<ul>
						<li class="th">캐시 사용</li>
						<li class="td pointcolor3">
							<span>(-)</span> <?php echo get_currency_price($TPL_VAR["orders"]["emoney"], 2)?>

						</li>
					</ul>
<?php }?>
<?php if($TPL_VAR["orders"]["cash"]> 0){?>
					<ul>
						<li class="th">예치금 사용</li>
						<li class="td pointcolor3">
							<span>(-)</span> <?php echo get_currency_price($TPL_VAR["orders"]["cash"], 2)?>

						</li>
					</ul>
<?php }?>
<?php }?>
					<ul class="total">
						<li class="th">최종 결제금액</li>
						<li class="td">
							<span class="price"><?php echo get_currency_price($TPL_VAR["orders"]["settleprice"], 2,'','<span class="settle_price">_str_price_</span>')?></span>
							<div class="settle_price_compare total_result_price gray_05"><?php echo $TPL_VAR["total_price_compare"]?></div>
						</li>
					</ul>
				</div>

				<!-- 주문결제정보 -->
				<h3 class="title_sub4">주문결제정보</h3>
				<table class="table_row_a" cellpadding="0" cellspacing="0">
				<colgroup><col width="84"><col></colgroup>
				<tbody>
					<tr>
						<th scope="row"><p>주문번호</p></th>
						<td><?php echo $TPL_VAR["orders"]["order_seq"]?></td>
					</tr>
					<tr>
						<th scope="row"><p>주문날짜</p></th>
						<td><?php echo date('Y-m-d H:i',strtotime($TPL_VAR["orders"]["regist_date"]))?></td>
					</tr>
					<tr>
						<th scope="row"><p>주문상태</p></th>
						<td>
<?php if($TPL_VAR["orders"]["payment"]!='pos_pay'){?>
<?php if($TPL_VAR["orders"]["step"]== 99){?> [CODE: <?php echo $TPL_VAR["orders"]["pg_log"]["res_cd"]?>] <?php echo $TPL_VAR["orders"]["pg_log"]["res_msg"]?> <?php }?>
<?php }else{?>
								오프라인 매장 주문
<?php }?>
						</td>
					</tr>
					<tr>
						<th scope="row"><p>결제일시</p></th>
						<td>
<?php if($TPL_VAR["orders"]["deposit_yn"]=='n'){?>
							입금대기
<?php }else{?>
							<?php echo date('Y-m-d H:i:s',strtotime($TPL_VAR["orders"]["deposit_date"]))?>

<?php }?>
						</td>
					</tr>
					<tr>
						<th scope="row"><p>결제방식</p></th>
						<td>
							<?php echo $TPL_VAR["orders"]["mpayment"]?>

<?php if($TPL_VAR["orders"]["payment"]=='bank'){?>
							<span class="Dib">(입금자명:<?php echo $TPL_VAR["orders"]["depositor"]?>)</span>
<?php }elseif($TPL_VAR["orders"]["payment"]=='card'&&$TPL_VAR["orders"]["payment_cd"]!='MONEY'){?>
							<span class="Dib">(<?php if($TPL_VAR["order_pg_log"]["card_name"]){?><?php echo $TPL_VAR["order_pg_log"]["card_name"]?>/<?php }?><?php if($TPL_VAR["orders"]["card_quota"]> 0){?><?php echo $TPL_VAR["orders"]["card_quota"]?>개월할부<?php }else{?>일시불<?php }?>)</span>
<?php }?>
						</td>
					</tr>
<?php if($TPL_VAR["orders"]["bank_account"]||$TPL_VAR["orders"]["virtual_account"]){?>
					<tr>
						<th scope="row"><p>입금계좌</p></th>
						<td>
							<?php echo $TPL_VAR["account_number"]["bank_name"]?>

							<span class="Dib"><?php echo $TPL_VAR["account_number"]["account_number"]?></span>
<?php if($TPL_VAR["account_number"]["account_owner"]){?>
							<span class="Dib">(<?php echo $TPL_VAR["account_number"]["account_owner"]?>)</span>
<?php }?>
						</td>
					</tr>
<?php }?>
<?php if($TPL_VAR["orders"]["deposit_yn"]=='n'&&$TPL_VAR["cfg_order"]["autocancel_txt"]){?>
					<tr>
						<th scope="row"><p>입금기간</p></th>
						<td><?php echo $TPL_VAR["cfg_order"]["autocancel_txt"]?></td>
					</tr>
<?php }?>
					<tr>
						<th scope="row"><p>결제금액</p></th>
						<td><strong><?php echo get_currency_price($TPL_VAR["orders"]["settleprice"], 2)?></strong></td>
					</tr>
<?php if($TPL_VAR["orders"]["payment"]!='pos_pay'){?>
<?php if($TPL_VAR["orders"]["step"]!= 95&&$TPL_VAR["orders"]["step"]!= 85&&$TPL_VAR["orders"]["step"]!= 99){?>
<?php if($TPL_VAR["orders"]["typereceipt"]> 0&&($TPL_VAR["tax"]["tstep"]== 1||$TPL_VAR["tax"]["tstep"]== 2||$TPL_VAR["tax"]["tstep"]== 4||$TPL_VAR["creceipt"]["tstep"]== 1||$TPL_VAR["creceipt"]["tstep"]== 2||$TPL_VAR["creceipt"]["tstep"]== 4)){?>
								<tr>
									<th scope="row"><p>증빙자료</p></th>
<?php if($TPL_VAR["orders"]["typereceipt"]== 1){?>
									<td>
<?php if($TPL_VAR["tax"]["tstep"]== 1||$TPL_VAR["tax"]["tstep"]== 2||$TPL_VAR["tax"]["tstep"]== 4){?>
<?php if(($TPL_VAR["tax"]["tstep"]== 1)){?>
											<button type="button" class="btn_resp" id="taxcashbtn<?php echo $TPL_VAR["tax"]["tstep"]?>" deposit="<?php echo $TPL_VAR["orders"]["deposit_yn"]?>">세금계산서</button>
<?php }elseif($TPL_VAR["tax"]["tstep"]== 2){?>
<?php if($TPL_VAR["tax"]["approach"]=='unlink'){?>
											<button type="button" class="btn_resp taxCompleteOver">세금계산서</button>
<?php }elseif($TPL_VAR["tax"]["approach"]=='link'||$TPL_VAR["tax"]["approach"]=='auto'||!$TPL_VAR["tax"]["approach"]){?>
											<button type="button" class="btn_resp" id="taxcashbtn<?php echo $TPL_VAR["tax"]["tstep"]?>" sales_seq="<?php echo $TPL_VAR["tax"]["seq"]?>"  order_seq ="<?php echo $TPL_VAR["orders"]["order_seq"]?>" settleprice="<?php echo $TPL_VAR["orders"]["settleprice"]?>" >세금계산서</button>
<?php }?>
<?php }elseif($TPL_VAR["tax"]["tstep"]== 4){?>
											<button type="button" class="btn_resp" id="taxcashbtn<?php echo $TPL_VAR["tax"]["tstep"]?>">세금계산서</button>
<?php }?>
<?php if($TPL_VAR["tax"]["tstep"]== 1){?>
											발급대기
<?php }?>
<?php }?>
									</td>
<?php }elseif($TPL_VAR["orders"]["typereceipt"]== 2){?>
									<td>
<?php if($TPL_VAR["creceipt"]["tstep"]== 1||$TPL_VAR["creceipt"]["tstep"]== 2||$TPL_VAR["creceipt"]["tstep"]== 4){?>
<?php if(($TPL_VAR["creceipt"]["tstep"]== 1||$TPL_VAR["tax"]["tstep"]== 1)){?>
												<button type="button" class="btn_resp" id="pgcashbtn<?php echo $TPL_VAR["creceipt"]["tstep"]?>" deposit="<?php echo $TPL_VAR["orders"]["deposit_yn"]?>">현금영수증</button>
<?php }elseif($TPL_VAR["creceipt"]["tstep"]== 2||$TPL_VAR["tax"]["tstep"]== 2){?>
<?php if(!$TPL_VAR["creceipt"]["cash_no"]){?>
												<button type="button" class="btn_resp completeOver">현금영수증</button>
<?php }else{?>
												<button type="button" class="btn_resp" id="pgcashbtn<?php echo $TPL_VAR["creceipt"]["tstep"]?>" sales_seq="<?php echo $TPL_VAR["creceipt"]["seq"]?>"  order_seq ="<?php echo $TPL_VAR["orders"]["order_seq"]?>" cash_no="<?php echo $TPL_VAR["creceipt"]["cash_receipts_no"]?>" settleprice="<?php echo $TPL_VAR["orders"]["settleprice"]?>" pg_kind="<?php echo $TPL_VAR["creceipt"]["pg_kind"]?>">현금영수증</button>
<?php }?>
<?php }elseif($TPL_VAR["creceipt"]["tstep"]== 4){?>
												<button type="button" class="btn_resp" id="pgcashbtn<?php echo $TPL_VAR["creceipt"]["tstep"]?>">현금영수증</button>
<?php }?>
												(<?php if($TPL_VAR["creceipt"]["cuse"]== 0){?>개인소득공제<?php }elseif($TPL_VAR["creceipt"]["cuse"]== 1){?>사업자지출증빙용<?php }?>)
<?php if($TPL_VAR["creceipt"]["tstep"]== 1){?>
												발급대기 <button type="button" class="btn_resp cancelBtn" order_seq="<?php echo $TPL_VAR["orders"]["order_seq"]?>">발급취소</button>
<?php }?>
<?php }?>
									</td>
<?php }?>
								</tr>
<?php }elseif($TPL_VAR["orders"]["payment"]=='card'){?>
								<tr>
									<th scope="row"><p>증빙자료</p></th>
									<td>
										<button type="button" class="btn_resp" onclick="receiptView('<?php echo $TPL_VAR["orders"]["pg_transaction_number"]?>', '<?php echo $TPL_VAR["pg"]["mallCode"]?>', '<?php echo $TPL_VAR["orders"]["order_seq"]?>', '<?php echo $TPL_VAR["orders"]["pg_kind"]?>', '<?php echo $TPL_VAR["orders"]["authdata"]?>', '<?php echo $TPL_VAR["orders"]["payment"]?>');">신용카드매출전표</button>
									</td>
								</tr>
<?php }elseif($TPL_VAR["orders"]["payment"]=='cellphone'){?>
<?php }else{?>
<?php if((($TPL_VAR["cfg"]["order"]["sale_reserve_yn"]!='Y'&&$TPL_VAR["orders"]["emoney"]> 0)&&$TPL_VAR["orders"]["settleprice"]<= 0)||(($TPL_VAR["cfg"]["order"]["sale_emoney_yn"]!='Y'&&$TPL_VAR["orders"]["cash"]> 0)&&$TPL_VAR["orders"]["settleprice"]<= 0)){?>
<?php }else{?>
								<tr>
									<th scope="row"><p>증빙자료</p></th>
									<td>
<?php if($TPL_VAR["orders"]["deposit_yn"]=='n'){?>
										입금 후 신청 가능합니다.
<?php }else{?>
										<select name="receipt_type" class="M">
											<option value="">선택</option>
<?php if($TPL_VAR["cfg_order"]["taxuse"]> 0){?>
											<option value="tax" receipt_possible="<?php echo $TPL_VAR["orders"]["tax_receipt_possible"]?>"<?php if($TPL_VAR["orders"]["typereceipt"]== 1){?> selected<?php }?>>세금계산서</option>
<?php }?>
<?php if($TPL_VAR["cfg_order"]["cashreceiptuse"]> 0){?>
<?php if($TPL_VAR["orders"]["settleprice"]> 0){?>
											<option value="cash" receipt_possible="<?php echo $TPL_VAR["orders"]["cash_receipt_possible"]?>"<?php if($TPL_VAR["orders"]["typereceipt"]== 2){?> selected<?php }?>>현금영수증</option>
<?php }?>
<?php }?>
										</select>

<?php if(($TPL_VAR["orders"]["tax_receipt_possible"]||$TPL_VAR["orders"]["cash_receipt_possible"])&&$TPL_VAR["orders"]["step"]>= 15&&$TPL_VAR["orders"]["step"]<= 75&&!$TPL_VAR["orders"]["orign_order_seq"]){?>
										<select id="receipt_apply" order_seq="<?php echo $TPL_VAR["orders"]["order_seq"]?>" step="<?php echo $TPL_VAR["orders"]["step"]?>" class="M" style="display:none;">
<?php }else{?>
										<select id="receipt_apply" class="M" disabled>
<?php }?>
											<option value="n" checked>미신청</option>
											<option value="y">신청</option>
										</select>
										<span class="receipt_date_limit gray_06"<?php if($TPL_VAR["orders"]["typereceipt"]!= 1&&$TPL_VAR["orders"]["typereceipt"]!= 0){?> style="display:none;"<?php }?>><?php echo $TPL_VAR["orders"]["tax_receipt_possible_txt"]?></span>
										<span class="receipt_date_limit gray_06"<?php if($TPL_VAR["orders"]["typereceipt"]!= 2){?> style="display:none;"<?php }?>><?php echo $TPL_VAR["orders"]["cash_receipt_possible_txt"]?></span>
<?php }?>
									</td>
								</tr>
<?php }?>
<?php }?>
<?php }?>
<?php }?>
				</tbody>
				</table>

<?php if($TPL_VAR["cfg_order"]["autocancel"]=='y'&&$TPL_VAR["cfg_order"]["cancelDuration"]> 0){?>
				<div class="Pt10 pointcolor3">
					무통장입금으로 주문하신 고객님들 중 주문후 <?php echo $TPL_VAR["cfg_order"]["cancelDuration"]?>일 이내에 입금해 주시지 않으면 자동취소 처리될 수 있습니다.
				</div>
<?php }?>
			</li>
			<!-- ++++++++++++++ //RIGHT Area ++++++++++++++ -->
		</ul>

<?php if(count($TPL_VAR["order_shippings"])>= 1){?>
		<h3 class="title_sub4">배송 내역</h3>
<?php if($TPL_order_shippings_1){foreach($TPL_VAR["order_shippings"] as $TPL_V1){?>
<?php if($TPL_V1["exports"]){?>
				<div class="res_table">
					<ul class="thead">
						<li>상품</li>
						<li style="width:70px;">주문수량</li>
						<li style="width:90px;">발송수량</li>
						<li style="width:80px;">상품후기</li>
						<li style="width:170px;">발송정보</li>
					</ul>
<?php if(is_array($TPL_R2=$TPL_V1["exports"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if(is_array($TPL_R3=$TPL_V2["item"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
						<ul class="tbody <?php if($TPL_V3["opt_type"]!='opt'){?>suboptions<?php }?> <?php if($TPL_I3== 0){?><?php }else{?>besong_grouped<?php }?>">
							<li class="subject">
<?php if($TPL_V3["opt_type"]=='opt'){?>
								<ul class="board_goods_list">
									<li class="pic">
										<img src="<?php echo $TPL_V3["image"]?>" alt="" designImgSrcOri='ey4uLmltYWdlfQ==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfdmlldy5odG1s' designImgSrc='ey4uLmltYWdlfQ==' designElement='image' />
									</li>
									<li class="info">
										<div class="title">
<?php if($TPL_V3["goods_type"]=='gift'){?>
											<span class="pointcolor2">[사은품]</span>
<?php }?>
											<?php echo $TPL_V3["goods_name"]?>

										</div>
<?php if($TPL_V2["goods_kind"]=='coupon'){?>
										<div class="cont3">
											<?php echo $TPL_V3["social_start_date"]?> ~ <?php echo $TPL_V3["social_end_date"]?>

										</div>
<?php }?>
<?php if($TPL_V3["option1"]){?>
										<div class="cont3">
											<span class="res_option_inline"><?php if($TPL_V3["title1"]){?><span class="xtle"><?php echo $TPL_V3["title1"]?></span><?php }?><?php echo $TPL_V3["option1"]?></span>
<?php if($TPL_V3["option2"]){?><span class="res_option_inline"><?php if($TPL_V3["title2"]){?><span class="xtle"><?php echo $TPL_V3["title2"]?></span><?php }?><?php echo $TPL_V3["option2"]?></span><?php }?>
<?php if($TPL_V3["option3"]){?><span class="res_option_inline"><?php if($TPL_V3["title3"]){?><span class="xtle"><?php echo $TPL_V3["title3"]?></span><?php }?><?php echo $TPL_V3["option3"]?></span><?php }?>
<?php if($TPL_V3["option4"]){?><span class="res_option_inline"><?php if($TPL_V3["title4"]){?><span class="xtle"><?php echo $TPL_V3["title4"]?></span><?php }?><?php echo $TPL_V3["option4"]?></span><?php }?>
<?php if($TPL_V3["option5"]){?><span class="res_option_inline"><?php if($TPL_V3["title5"]){?><span class="xtle"><?php echo $TPL_V3["title5"]?></span><?php }?><?php echo $TPL_V3["option5"]?></span><?php }?>
										</div>
<?php }?>
									</li>
								</ul>
<?php }else{?>
								<div class="reply_ui">
<?php if($TPL_V3["title1"]){?><span class="xtle v3"><?php echo $TPL_V3["title1"]?></span><?php }?> <?php echo $TPL_V3["option1"]?>

								</div>
<?php }?>
							</li>
							<li class="<?php echo $TPL_V3["opt_type"]?>area"><span class="mtitle">주문:</span> <?php echo $TPL_V3["opt_ea"]?></li>
							<li class="<?php echo $TPL_V3["opt_type"]?>area mo_end">
								<span class="mtitle">발송:</span> 
								<?php echo $TPL_V3["ea"]?>

<?php if($TPL_V2["goods_kind"]=='coupon'){?>
								<div class="m_dib">
									(<?php if($TPL_V3["coupon_value_type"]=='pass'){?><?php echo number_format($TPL_V2["coupon_use_value"])?>회<?php }else{?><?php echo get_currency_price($TPL_V2["coupon_use_value"], 2)?><?php }?> /
<?php if($TPL_V3["coupon_value_type"]=='pass'){?><?php echo number_format($TPL_V2["coupon_input"])?>회<?php }else{?><?php echo get_currency_price($TPL_V2["coupon_input"], 2)?><?php }?>)
								</div>
<?php }?>
							</li>
							<li class="<?php echo $TPL_V3["opt_type"]?>area">
<?php if($TPL_V3["goods_type"]!='gift'&&$TPL_V3["opt_type"]=='opt'){?>
								<button type="button" class="btn_resp res_board_boxad2" onclick="goods_review_write('<?php echo $TPL_V3["goods_seq"]?>','<?php echo $TPL_V1["order_seq"]?>');">상품후기</button>
<?php }?>
							</li>
<?php if($TPL_I3== 0){?>
							<li class="<?php echo $TPL_V3["opt_type"]?>area besong_group2 left <?php if(count($TPL_V2["item"])> 1){?>rowspan<?php }?>">
								<div class="rcont">
<?php if($TPL_VAR["orders"]["payment"]!='pos_pay'){?>
										<strong class="mtitle gray_01">배송그룹:</strong>
<?php if($TPL_V2["provider_name"]){?>
										<span class="gray_06">[<?php echo $TPL_V2["provider_name"]?>]</span>
<?php }?>
										<div class="Dib"><?php echo $TPL_V2["shipping_set_name"]?></div>
										<div class="pointcolor2"><?php echo $TPL_V2["export_date"]?> 발송</div>
<?php if($TPL_V2["status"]== 55||$TPL_V2["status"]== 65||$TPL_V2["status"]== 75){?>
										<div>[<?php echo $TPL_V2["mstatus"]?>]</div>
<?php }?>
<?php if($TPL_V2["goods_kind"]=='coupon'){?>
										<div><?php echo $TPL_V3["recipient_cellphone"]?></div>
										<div><?php echo $TPL_V3["recipient_email"]?></div>
<?php }else{?>
<?php if($TPL_V2["shipping_method"]=='direct_store'){?>
											<div><?php echo $TPL_V2["direct_store"]["shipping_store_name"]?></div>
<?php }?>
											<div><?php echo $TPL_V2["mdelivery"]?></div>
											<div class="btn_area_mx1">
<?php if($TPL_V2["goods_kind"]!='coupon'&&$TPL_V2["tracking_url"]){?>
												<button type="button" class="btn_resp" onclick="window.open('<?php echo $TPL_V2["tracking_url"]?>');">배송조회</button>
<?php }?>
											</div>
<?php }?>
<?php }else{?>
										<div class="pointcolor2">오프라인 매장 주문</div>
										<div><?php echo $TPL_V2["direct_store"]["shipping_store_name"]?></div>
<?php }?>
									<div class="btn_area_mx1">
<?php if($TPL_V2["goods_kind"]=='coupon'){?>
										<button type="button" class="btn_resp" onclick="coupon_history('<?php echo $TPL_V2["export_code"]?>','<?php echo $TPL_V3["coupon_serial"]?>');">사용내역</button>
<?php if($TPL_V2["coupon_check_use"]['result']=='success'){?>
										<button type="button" class="btn_resp color2" onclick="coupon_use('<?php echo $TPL_V2["export_code"]?>','<?php echo $TPL_V3["coupon_serial"]?>');" title="새창">티켓사용</button>
<?php }else{?>
										[티켓사용]
<?php }?>
<?php }else{?>
<?php if($TPL_V2["buyconfirmInfo"]['btn_buyconfirm']){?>
												<button type="button" class="btn_resp color2 exportbuyconfirm" export_code="<?php echo $TPL_V2["export_code"]?>" status="<?php echo $TPL_V2["status"]?>" >구매확정</button>
<?php }else{?>
<?php if($TPL_V2["buyconfirmInfo"]['reserve_buyconfirm_ea']){?>
													구매확정 : <?php echo substr($TPL_V2["data_buy_confirm"]["regdate"], 0, 10)?><?php if($TPL_V2["data_buy_confirm"]["actor_id"]=='system'){?> (자동)<?php }?>
<?php }?>
<?php }?>
<?php }?>
									</div>
								</div>
							</li>
<?php }else{?>
							<li class="rowspaned"></li>
<?php }?>
						</ul>
<?php }}?>
<?php }}?>
				</div>
<?php }else{?>
				<div class="no_data_area2">
					배송(출고) 내역이 없습니다.
				</div>
<?php }?>
<?php }}?>
<?php }?>

<?php if($TPL_VAR["cancel_log"]||$TPL_VAR["data_return"]||$TPL_VAR["data_refund"]){?>
		<h3 class="title_sub4">무효/취소/반품 내역</h3>
		<div class="res_table">
			<ul class="thead">
				<li>무효/취소/반품</li>
				<li style="width:160px;">처리일시</li>
				<li style="width:100px;">처리수량</li>
				<li style="width:130px;">처리금액</li>
				<li>상세</li>
			</ul>
<?php if($TPL_cancel_log_1){foreach($TPL_VAR["cancel_log"] as $TPL_V1){?>
			<ul class="tbody">
				<li class="subject half t1"><strong class="reply_title pointcolor3 imp"><?php echo $TPL_V1["title"]?></strong></li>
				<li class="subject half x1"><?php echo $TPL_V1["regist_date"]?></li>
				<li><span class="mtitle">수량:</span> <?php echo $TPL_V1["ea"]?></li>
				<li><span class="mtitle">금액:</span> <?php echo get_currency_price($TPL_V1["price"])?></li>
				<li class="mo_end"><?php echo $TPL_V1["detail"]?>&nbsp;</li>
			</ul>
<?php }}?>
<?php if($TPL_data_return_1){foreach($TPL_VAR["data_return"] as $TPL_V1){?>
			<ul class="tbody">
				<li class="subject half t1"><strong class="reply_title pointcolor3 imp">반품</strong></li>
				<li class="subject half x1"><a href="../mypage/return_view?return_code=<?php echo $TPL_V1["return_code"]?>" target="_blank" hrefOri='Li4vbXlwYWdlL3JldHVybl92aWV3P3JldHVybl9jb2RlPXsucmV0dXJuX2NvZGV9' ><?php echo $TPL_V1["regist_date"]?></a></li>
				<li><span class="mtitle">수량:</span> <?php echo $TPL_V1["ea"]?></li>
				<li><span class="mtitle">금액:</span> <?php echo get_currency_price($TPL_V1["opt_price"]+$TPL_V1["sub_price"], 2)?></li>
				<li class="mo_end"><a href="../mypage/return_view?return_code=<?php echo $TPL_V1["return_code"]?>" target="_blank" hrefOri='Li4vbXlwYWdlL3JldHVybl92aWV3P3JldHVybl9jb2RlPXsucmV0dXJuX2NvZGV9' ><?php echo $TPL_V1["mstatus"]?></a>&nbsp;</li>
			</ul>
<?php }}?>
<?php if($TPL_data_refund_1){foreach($TPL_VAR["data_refund"] as $TPL_V1){?>
			<ul class="tbody">
				<li class="subject half t1"><strong class="reply_title pointcolor3 imp">환불</strong></li>
				<li class="subject half x1"><a href="../mypage/refund_view?refund_code=<?php echo $TPL_V1["refund_code"]?>" target="_blank" hrefOri='Li4vbXlwYWdlL3JlZnVuZF92aWV3P3JlZnVuZF9jb2RlPXsucmVmdW5kX2NvZGV9' ><?php echo $TPL_V1["regist_date"]?></a></li>
				<li><span class="mtitle">수량:</span> <?php echo $TPL_V1["ea"]?></li>
				<li><span class="mtitle">금액:</span> <?php echo get_currency_price($TPL_V1["refund_price"], 2)?></li>
				<li class="mo_end"><a href="../mypage/refund_view?refund_code=<?php echo $TPL_V1["refund_code"]?>" target="_blank" hrefOri='Li4vbXlwYWdlL3JlZnVuZF92aWV3P3JlZnVuZF9jb2RlPXsucmVmdW5kX2NvZGV9' ><?php echo $TPL_V1["mstatus"]?></a>&nbsp;</li>
			</ul>
<?php }}?>
		</div>
<?php }?>

		<!-- 하단 버튼 -->
		<div class="btn_area_c">
			<a href="/mypage/order_catalog" class="btn_resp size_c color5" hrefOri='L215cGFnZS9vcmRlcl9jYXRhbG9n' >주문/배송 내역</a>
		</div>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->

<!-- 배송주소록 Layer -->
<div id="delivery_address_dialog" class="resp_layer_pop hide">
	<h4 class="title">배송 주소록</h4>
	<div class="y_scroll_auto">
		<div class="layer_pop_contents v3 delivery_often">
		</div>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>

<!-- 배송비 내역 레이어 -->
<div id="besongDetailList" class="resp_layer_pop hide">
	<h4 class="title">배송비 내역</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<ul class="od_layer_title1">
				<li class="td">총 <span class="pointcolor2"><?php echo get_currency_price($TPL_VAR["shipping_tot"]["tot_origin_shipping_cost"], 2,'','<span class="totalprice_font">_str_price_</span>')?></span></li>
			</ul>
			<table class="table_row_a" cellpadding="0" cellspacing="0">
				<colgroup><col width="100" /><col /></colgroup>
				<tbody>
<?php if($TPL_VAR["shipping_tot"]["std_cost"]> 0){?>
					<tr>
						<th scope="row"><p>기본배송비</p></th>
						<td><?php echo get_currency_price($TPL_VAR["shipping_tot"]["std_cost"], 2)?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["shipping_tot"]["add_cost"]> 0){?>
					<tr>
						<th scope="row"><p>추가배송비</p></th>
						<td><?php echo get_currency_price($TPL_VAR["shipping_tot"]["add_cost"], 2)?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["shipping_tot"]["hop_cost"]> 0){?>
					<tr>
						<th scope="row"><p>희망배송비</p></th>
						<td><?php echo get_currency_price($TPL_VAR["shipping_tot"]["hop_cost"], 2)?></td>
					</tr>
<?php }?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>

<!-- 할인금액 내역 레이어 -->
<div id="saleDetailList" class="resp_layer_pop hide">
	<h4 class="title">할인금액 내역</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<ul class="od_layer_title1">
				<li class="td">총 <span class="pointcolor"><?php echo get_currency_price($TPL_VAR["items_tot"]["member_sale"]+$TPL_VAR["items_tot"]["mobile_sale"]+$TPL_VAR["items_tot"]["fblike_sale"]+$TPL_VAR["items_tot"]["coupon_sale"]+$TPL_VAR["items_tot"]["promotion_code_sale"]+$TPL_VAR["items_tot"]["referer_sale"]+$TPL_VAR["shipping_tot"]["coupon_sale"]+$TPL_VAR["shipping_tot"]["code_sale"]+$TPL_VAR["orders"]["enuri"], 2,'','<span class="totalprice_font">_str_price_</span>')?></span>
			</ul>
			<table class="table_row_a" cellpadding="0" cellspacing="0">
				<colgroup><col width="100" /><col /></colgroup>
				<tbody>
<?php if($TPL_VAR["items_tot"]["event_sale"]> 0){?>
					<tr>
						<th scope="row"><p>이벤트할인</p></th>
						<td><?php echo get_currency_price($TPL_VAR["items_tot"]["event_sale"], 2)?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["items_tot"]["multi_sale"]> 0){?>
					<tr>
						<th scope="row"><p>복수구매할인</p></th>
						<td><?php echo get_currency_price($TPL_VAR["items_tot"]["multi_sale"], 2)?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["items_tot"]["member_sale"]> 0){?>
					<tr>
						<th scope="row"><p>등급할인</p></th>
						<td><?php echo get_currency_price($TPL_VAR["items_tot"]["member_sale"], 2)?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["items_tot"]["mobile_sale"]> 0){?>
					<tr>
						<th scope="row"><p>모바일</p></th>
						<td><?php echo get_currency_price($TPL_VAR["items_tot"]["mobile_sale"], 2)?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["items_tot"]["fblike_sale"]> 0){?>
					<tr>
						<th scope="row"><p>좋아요</p></th>
						<td><?php echo get_currency_price($TPL_VAR["items_tot"]["fblike_sale"], 2)?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["items_tot"]["coupon_sale"]> 0){?>
					<tr>
						<th scope="row"><p>쿠폰할인</p></th>
						<td><?php echo get_currency_price($TPL_VAR["items_tot"]["coupon_sale"], 2)?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["items_tot"]["promotion_code_sale"]> 0){?>
					<tr>
						<th scope="row"><p>할인코드</p></th>
						<td><?php echo get_currency_price($TPL_VAR["items_tot"]["promotion_code_sale"], 2)?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["items_tot"]["referer_sale"]> 0){?>
					<tr>
						<th scope="row"><p>유입경로</p></th>
						<td><?php echo get_currency_price($TPL_VAR["items_tot"]["referer_sale"], 2)?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["shipping_tot"]["coupon_sale"]> 0){?>
					<tr>
						<th scope="row"><p>배송비쿠폰</p></th>
						<td><?php echo get_currency_price($TPL_VAR["shipping_tot"]["coupon_sale"], 2)?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["shipping_tot"]["code_sale"]> 0){?>
					<tr>
						<th scope="row"><p>배송비코드</p></th>
						<td><?php echo get_currency_price($TPL_VAR["shipping_tot"]["code_sale"], 2)?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["orders"]["enuri"]> 0){?>
					<tr>
						<th scope="row"><p>에누리</p></th>
						<td><?php echo get_currency_price($TPL_VAR["orders"]["enuri"], 2)?></td>
					</tr>
<?php }?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>

<!-- 증빙자료 신청 -->
<div id="saleslay" class="resp_layer_pop hide">
	<h4 class="title">증빙자료 신청</h4>
	<div class="y_scroll_auto">
		<div class="layer_pop_contents v3">
			<div class="hide">
<?php if($TPL_VAR["creceipt"]["tstep"]== 2||$TPL_VAR["tax"]["tstep"]== 2){?>
<?php if($TPL_VAR["orders"]["typereceipt"]== 2){?> 현금영수증
						<img src="/data/skin/responsive_diary_petit_gl/images/design/btn_print_receipt.gif" id="pgcashbtn<?php echo $TPL_VAR["creceipt"]["tstep"]?>" class="hand" sales_seq="<?php echo $TPL_VAR["creceipt"]["seq"]?>"  order_seq ="<?php echo $TPL_VAR["orders"]["order_seq"]?>" cash_no="<?php echo $TPL_VAR["creceipt"]["cash_receipts_no"]?>" settleprice="<?php echo $TPL_VAR["orders"]["settleprice"]?>" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9idG5fcHJpbnRfcmVjZWlwdC5naWY=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfdmlldy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9kZXNpZ24vYnRuX3ByaW50X3JlY2VpcHQuZ2lm' designElement='image' />
<?php }elseif($TPL_VAR["orders"]["typereceipt"]== 1){?> 세금계산서
<?php }else{?> 발급안함
<?php }?>
<?php }else{?>
					<label for="typereceipt0"><input type="radio" name="typereceipt" id="typereceipt0" value="0" checked="checked" /> 발급안함 </label>
<?php if($TPL_VAR["cfg_order"]["cashreceiptuse"]> 0){?>
					<label for="typereceipt2">
					<input type="radio" name="typereceipt" id="typereceipt2" value="2" <?php if($TPL_VAR["orders"]["typereceipt"]== 2){?> checked="checked" <?php }?><?php if($TPL_VAR["orders"]["cash_receipt_possible"]!= 1){?> disabled<?php }?>>
					현금영수증 </label>
<?php }?>
<?php if($TPL_VAR["cfg_order"]["taxuse"]> 0){?>
					<label for="typereceipt1">	<input type="radio" name="typereceipt" id="typereceipt1" value="1"  <?php if($TPL_VAR["orders"]["typereceipt"]== 1){?> checked="checked" <?php }?><?php if($TPL_VAR["orders"]["tax_receipt_possible"]!= 1){?> disabled<?php }?>> 세금계산서 </label>
<?php }?>
<?php }?>
			</div>
			<!-- ~~~~~~~ 현금영수증 신청 부분 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
			<div id="cash_container" class="<?php if(!($TPL_VAR["cfg_order"]["cashreceiptuse"]> 0&&$TPL_VAR["creceipt"]["seq"]&&$TPL_VAR["creceipt"]["tstep"]== 2)&&$TPL_VAR["orders"]["typereceipt"]!= 2){?>hide<?php }?>">
			<form name="CreceiptForm" method="post" action="../sales_process/cashreceiptwrite" target="actionFrame">
				<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["orders"]["order_seq"]?>" />
				<input type="hidden" name="settleprice" value="<?php echo $TPL_VAR["orders"]["settleprice"]?>" />
<?php if($TPL_VAR["orders"]["typereceipt"]){?>
				<input type="hidden" name="creceipt_seq" value="<?php echo $TPL_VAR["creceipt"]["seq"]?>" />
<?php }?>
				<input type="hidden" name="goods_name" value="<?php echo $TPL_VAR["creceipt"]["goods_name"]?>" />
				<input type="hidden" name="order_user_name" value="<?php echo $TPL_VAR["orders"]["order_user_name"]?>" />
				<input type="hidden" name="order_step" value="<?php echo $TPL_VAR["orders"]["step"]?>" />
				<div class="resp_table_row input_form">
					<ul class="tr">
						<li class="th">발행용도</li>
						<li class="td label_group">
<?php if($TPL_VAR["creceipt"]["tstep"]== 2){?>
<?php if($TPL_VAR["creceipt"]["cuse"]== 1){?>
									개인 소득공제용
<?php }else{?>
									사업자 지출증빙용
<?php }?>
<?php }else{?>
							<label for="cuse0"><input type="radio" name="cuse"  id="cuse0" value="0" <?php if($TPL_VAR["creceipt"]["cuse"]!= 1||!$TPL_VAR["creceipt"]["seq"]){?> checked="checked" <?php }?> /> 개인 소득공제</label>
							<label for="cuse1"><input type="radio" name="cuse"  id="cuse1" value="1" <?php if($TPL_VAR["creceipt"]["cuse"]== 1){?>checked="checked" <?php }?>/> 사업자 지출증빙</label>
<?php }?>
						</li>
					</ul>
					<ul class="tr">
						<li class="th">인증번호</li>
						<li class="td">
<?php if($TPL_VAR["creceipt"]["tstep"]== 2){?>
<?php if($TPL_VAR["creceipt"]["cuse"]== 1){?>
								사업자번호 : <?php echo $TPL_VAR["creceipt"]["creceipt_number"]?>

<?php }else{?>
								휴대폰번호 : <?php echo $TPL_VAR["creceipt"]["creceipt_number"]?>

<?php }?>
<?php }else{?>
								<div id="personallay"  class="<?php if($TPL_VAR["creceipt"]["cuse"]== 1){?>hide<?php }?>">
									<input type="tel" name="creceipt_number[0]" maxlength="13" value="<?php if($TPL_VAR["creceipt"]["cuse"]== 0){?><?php echo $TPL_VAR["creceipt"]["creceipt_number"]?><?php }?>" title="휴대폰번호" /> <span class="res_st_desc2">"-" 없이 입력</span>
								</div>
								<div id="businesslay" class="<?php if($TPL_VAR["creceipt"]["cuse"]!= 1){?>hide<?php }?>" >
									 <input type="tel" name="creceipt_number[1]" maxlength="10" value="<?php if($TPL_VAR["creceipt"]["cuse"]== 0){?><?php echo $TPL_VAR["creceipt"]["creceipt_number"]?><?php }?>" title="사업자번호" /> <span class="res_st_desc2">"-" 없이 입력</span>
								 </div>
<?php }?>
						</li>
					</ul>
					<ul class="tr">
						<li class="th">이메일주소</li>
						<li class="td">
							<div id="personallay">
								<input type="text" name="email" class="size_email_full" value="<?php echo $TPL_VAR["creceipt"]["email"]?>" title="이메일주소" />
							</div>
						</li>
					</ul>
				</div>
<?php if($TPL_VAR["creceipt"]["tstep"]!= 2){?>
				<div class="btn_area_b Pb5">
					<button type="submit" class="btn_resp size_c color2"><?php if($TPL_VAR["creceipt"]["seq"]&&$TPL_VAR["orders"]["typereceipt"]){?>수정하기<?php }else{?>신청하기<?php }?></button>
					<button type="button" class="btn_resp size_c" onclick="hideCenterLayer(); $('select[name=receipt_type]>option:eq(0)').prop('selected', true); $('#receipt_apply>option:eq(0)').prop('selected', true); $('#receipt_apply').hide();">취소</button>
				</div>
<?php }?>
			</form>
			</div>
			<!-- ~~~~~~~ 세금계산서 신청 부분 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
			<div id="tax_container" class="<?php if(!($TPL_VAR["cfg_order"]["taxuse"]> 0&&$TPL_VAR["tax"]["seq"]&&$TPL_VAR["tax"]["tstep"]== 2)&&$TPL_VAR["orders"]["typereceipt"]!= 1){?>hide<?php }?>">
			<form name="TaxForm" method="post" action="../sales_process/taxwrite" target="actionFrame">
				<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["orders"]["order_seq"]?>" />
				<input type="hidden" name="settleprice" value="<?php echo $TPL_VAR["orders"]["settleprice"]?>" />
				<input type="hidden" name="tax_seq" value="<?php echo $TPL_VAR["tax"]["seq"]?>" />
				<input type="hidden" name="order_step" value="<?php echo $TPL_VAR["orders"]["step"]?>" />
				<div class="resp_table_row input_form">
					<ul class="tr">
						<li class="th">상호명</li>
						<li class="td"><input type="text" name="co_name" id="co_name" value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["co_name"]?><?php }else{?><?php echo $TPL_VAR["business_info"]["bname"]?><?php }?>" title="상호명" /></li>
					</ul>
					<ul class="tr">
						<li class="th">사업자번호</li>
						<li class="td">
							<input type="text" name="busi_no" id="busi_no" value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["busi_no"]?><?php }else{?><?php echo $TPL_VAR["business_info"]["bno"]?><?php }?>" title="사업자번호 " /> 
							<span class="res_st_desc2">ex)123-12-12345</span>
						</li>
					</ul>
					<ul class="tr">
						<li class="th">대표자</li>
						<li class="td"><input type="text" name="co_ceo" id="co_ceo" value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["co_ceo"]?><?php }else{?><?php echo $TPL_VAR["business_info"]["bCEO"]?><?php }?>" title="대표자" /></li>
					</ul>
					<ul class="tr">
						<li class="th">업태</li>
						<li class="td">
							<input type="text" name="co_status" id="co_status" value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["co_status"]?><?php }else{?><?php echo $TPL_VAR["business_info"]["bstatus"]?><?php }?>" title="업태" />
						</li>
					</ul>
					<ul class="tr">
						<li class="th">업종</li>
						<li class="td">
							<input type="text" name="co_type" id="co_type" value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["co_type"]?><?php }else{?><?php echo $TPL_VAR["business_info"]["bitem"]?><?php }?>" title="업종" />
						</li>
					</ul>
					<ul class="tr">
						<li class="th">주소</li>
						<li class="td">
							<span id="PostNumberArea"><input type="text" name="new_zipcode" value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["new_zipcode"]?><?php }else{?><?php echo $TPL_VAR["business_info"]["co_new_zipcode"]?><?php }?>" class="size_zip_all" title="우편번호" readonly /></span>
							<button type="button" class="btn_resp size_b color4" onclick="openDialogZipcode_resp('');">검색</button>
							<!--button type="button" class="btn_resp size_b color4" onclick="window.open('../popup/zipcode','popup_zipcode','width=500,height=350')">검색</button-->

							<input type="hidden" name="address_type" value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["address_type"]?><?php }else{?><?php echo $TPL_VAR["business_info"]["baddress_type"]?><?php }?>" />
							<input type="text" name="address" id="address" class="size_address Mt5" <?php if($TPL_VAR["tax"]["seq"]){?><?php if($TPL_VAR["tax"]["address_type"]=="street"){?>style="display:none;"<?php }?><?php }else{?><?php if($TPL_VAR["business_info"]["baddress_type"]=='street'){?>style="display:none;"<?php }?><?php }?> value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["address"]?><?php }else{?><?php echo $TPL_VAR["business_info"]["baddress1"]?><?php }?>" title="기본주소" readonly />
							<input type="text" name="address_street" id="address_street" class="size_address Mt5" <?php if($TPL_VAR["tax"]["seq"]){?><?php if($TPL_VAR["tax"]["address_type"]!="street"){?>style="display:none;"<?php }?><?php }else{?><?php if($TPL_VAR["business_info"]["baddress_type"]!='street'){?>style="display:none;"<?php }?><?php }?> value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["address_street"]?><?php }else{?><?php echo $TPL_VAR["business_info"]["baddress1"]?><?php }?>" title="기본주소" readonly />

							<input type="text" name="address_detail" class="size_address Mt5" value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["address_detail"]?><?php }else{?><?php echo $TPL_VAR["business_info"]["baddress2"]?><?php }?>" title="상세주소" />
						</li>
					</ul>
					<ul class="tr">
						<li class="th">담당자</li>
						<li class="td"><input type="text" name="person" id="person" value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["person"]?><?php }else{?><?php echo $TPL_VAR["business_info"]["bperson"]?><?php }?>" title="담당자" /></li>
					</ul>
					<ul class="tr">
						<li class="th">이메일</li>
						<li class="td"><input type="text" name="email" id="email" value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["email"]?><?php }else{?><?php echo $TPL_VAR["members"]["email"]?><?php }?>" title="이메일" /></li>
					</ul>
					<ul class="tr">
						<li class="th">연락처</li>
						<li class="td"><input type="text" name="phone" id="phone" value="<?php if($TPL_VAR["tax"]["seq"]){?><?php echo $TPL_VAR["tax"]["phone"]?><?php }else{?><?php echo $TPL_VAR["business_info"]["bphone"]?><?php }?>" title="연락처" /></li>
					</ul>
				</div>

<?php if($TPL_VAR["tax"]["tstep"]!= 2){?>
				<div class="btn_area_b Pb5">
					<button type="submit" class="btn_resp size_c color2"><?php if($TPL_VAR["tax"]["seq"]){?>수정하기<?php }else{?>신청하기<?php }?></button>
					<button type="button" class="btn_resp size_c" onclick="hideCenterLayer(); $('select[name=receipt_type]>option:eq(0)').prop('selected', true); $('#receipt_apply>option:eq(0)').prop('selected', true); $('#receipt_apply').hide();">취소</button>
				</div>
<?php }?>
			</form>
			</div>
		</div>
	</div>
	<span class="btn_pop_close" onclick="hideCenterLayer(); $('select[name=receipt_type]>option:eq(0)').prop('selected', true); $('#receipt_apply>option:eq(0)').prop('selected', true); $('#receipt_apply').hide();"></span>
</div>

<!-- 구매 확정 및 캐시/포인트 지급 -->
<div id="export_buy_confirm_msg" class="resp_layer_pop hide">
	<h4 class="title">구매 확정 및 캐시/포인트 지급</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<input type="hidden" name="export_code" value="" />
			<input type="hidden" name="status" value="" />
			<div class="Pt10 Pb10">
				구매 확정 및 캐시/포인트 지급을 받으시기 전에 반드시 아래사항을 확인하여 주세요.<br />
				확인 버튼 클릭 시 구매 확정 및 캐시/포인트가 지급됩니다.<br />
			</div>
			<ul class="list_dot_01 box Mt10 gray_05">
				<li>주문 상품을 수령하셨고, 고객 변심 및 착오에 의한  교환 또는 환불의 의사가 없으실 경우 확인해주세요. 확인 후 즉시 캐시/포인트가 지급됩니다.</li>
				<li>동일 주문건의 상품 중 일부 만 교환 또는 반품을 원하실 경우 주문 번호 클릭 후 세부 주문내역에서  개별 상품에  대한 구매확정을 해주셔야 합니다.</li>
				<li>구매 확정으로 캐시/포인트가 지급된 이후 또는 제품 착용 시  교환 또는 환불이 불가합니다.</li>
<?php if($TPL_VAR["cfg_order"]["save_type"]=='exist'){?>
				<li>구매 확정을 하시지 않으시면 출고 완료 후  <?php echo $TPL_VAR["cfg_order"]["save_term"]?>일 후에는  자동으로 구매 확정 처리되지만 캐시/포인트는 소멸됩니다.</li>
<?php }else{?>
				<li>구매 확정을 하시지 않으시더라도 출고 완료 후  <?php echo $TPL_VAR["cfg_order"]["save_term"]?>일 후에는  자동으로 구매 확정 및 캐시/포인트가 지급됩니다.</li>
<?php }?>
			</ul>
			<ul class="export_buy_confirm_agree_container list_01 v2 C Pt15">
				<li>구매를 확정하기 위해 상품수령을 확인해 주세요.</li>
				<li class="Pt10 gray_01">
					<span class="pointcolor">상품을 수령하셨습니까?</span> &nbsp;
					<label><input type="radio" name="export_buy_confirm_agree" value="y" /> 예</label> &nbsp; &nbsp;
					<label><input type="radio" name="export_buy_confirm_agree" value="n" checked /> 아니오</label>
				</li>
			</ul>
		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<ul class="basic_btn_area2">
			<li><button type="button" id="export_buy_confirm_btn" class="btn_resp size_c color2 Wmax">구매확정</button></li>
			<li><button type="button" class="btn_resp size_c color5" onclick="hideCenterLayer()">취소</button></li>
		</ul>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>


<!-- 티켓 사용 내역 조회 -->
<div id="coupon_use_lay" class="resp_layer_pop hide">
	<h4 class="title">티켓 사용 내역</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5"></div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>

<!-- 사은품 이벤트 정보 -->
<div id="gift_use_lay" class="resp_layer_pop hide">
	<h4 class="title">사은품 이벤트 정보</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5"></div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>
<div id="gift_use_lay"></div>

<!-- 교환 신청 (페이지 이동으로 처리) -->
<!--div id="order_refund_layer" class="hide"></div-->


<script type="text/javascript">
	var lately_msg_list = new Array();
<?php if($TPL_VAR["lately_msg"]){?>
<?php if($TPL_lately_msg_1){foreach($TPL_VAR["lately_msg"] as $TPL_K1=>$TPL_V1){?>lately_msg_list[<?php echo $TPL_K1?>] = "<?php echo $TPL_V1["ship_message"]?>";
<?php }}?>
<?php }?>

	$(document).ready(function() {
		// 배송지 등록 / 수정 :: 2016-08-02 lwh
		$("select[name='select_address_group']").bind('change',function(){
			if($(this).val()==""){
				$("input[name='address_group']").val('').show();
			}else{
				$("input[name='address_group']").val($(this).val()).hide();
			}
		}).trigger('change');

		// 배송그룹 등록/수정 :: 2016-08-02 lwh
		$("#insert_address").bind("click",function(){
			var f = $("form#in_Address");
			f.attr("action","../mypage_process/delivery_address");
			f.attr("target","actionFrame");
			f[0].submit();
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
		});
	});

	$(function(){
<?php if(!$TPL_VAR["items_tot"]["goodstotal"]||$TPL_VAR["items_tot"]["goodstotal"]<= 0){?>
		$(".goods_delivery_info").hide();
<?php }?>

		//매출전표처리
		$("#pgreceiptbtn").click(function(){
			var tno= $(this).attr('tno');
			var shopid= '<?php echo $TPL_VAR["pg"]["mallCode"]?>';
			var ordno= $(this).attr('order_seq');
			var pg_kind = $(this).attr('pg_kind');
			var authdata= $(this).attr('authdata');
			var payment= '<?php echo $TPL_VAR["orders"]["mpayment"]?>';
			receiptView(tno, shopid, ordno, pg_kind, authdata, payment);
		});

		// 미신청시 UI처리
		$("#receipt_apply").change(function(){
			var value		= $(this).val();
			var tax_allow	= "<?php echo $TPL_VAR["orders"]["sales_tax_allow"]?>";
			if	(tax_allow == 'N') {
				// 환불신청 중입니다. 환불완료 후 세금계산서 신청해주세요.
				openDialogAlert(getAlert('mp233'),400,150,function(){ $("#receipt_apply > option[value=n]").attr("selected", true); });
				return false;
			}
			if	(value == 'y') {
				//매출증빙
				showCenterLayer('#saleslay')
				//openDialog(getAlert('mp120'), "saleslay", {"width":500,"height":400});
			}

			init_block_payco_cash_receip();
		});

		// 세금계산서 처리
		$("#taxcashbtn1").click(function(){
			var deposit = $(this).attr('deposit');

			if(deposit == 'n') {
				openDialogAlert(getAlert('mp215'),400,150,function(){ });
			} else {
				openDialogAlert(getAlert('mp218'),400,150,function(){ });
			}
		});

		$("#taxcashbtn4").click(function(){
			openDialogAlert(getAlert('mp216'),400,150,function(){ });
		});

		$("#taxcashbtn2").click(function(){
			var shopid= '<?php echo $TPL_VAR["pg"]["mallCode"]?>';
			var sales_seq	= $(this).attr('sales_seq');
			var order_seq	= $(this).attr('order_seq');
			var settleprice	= $(this).attr('settleprice');
			var cst_platform = '';

			$.ajax({
				'url' : '../mypage/tax_receipt_view',
				'data' : {'order_seq':order_seq,'seq':sales_seq},
				'type' : 'post',
				'dataType' : 'json',
				'success' : function(data) {
					if(data.tax_receipt_view) {
						$("#sales_tax_layer").html(data.tax_receipt_view);
						openDialog(getAlert('os237'), "sales_tax_layer", {"width":550,"height":500});
						setDefaultText();
					}
				}
			});
		});

		$(".taxCompleteOver").click(function(){
			openDialogAlert(getAlert('mp217'),400,140,function(){ });
		});

		// 현금영수증 처리
		$("#pgcashbtn1").click(function(){
			var deposit = $(this).attr('deposit');

			if(deposit == 'n') {
				openDialogAlert(getAlert('mp211'),400,150,function(){ });
			} else {
				openDialogAlert(getAlert('mp221'),400,150,function(){ });
			}
		});

		$("#pgcashbtn4").click(function(){
			openDialogAlert(getAlert('mp214'),400,150,function(){ });
		});

		$("#pgcashbtn2").click(function(){
			var cash_no= $(this).attr('cash_no');
			var shopid= '<?php echo $TPL_VAR["pg"]["mallCode"]?>';
			var ordno= $(this).attr('order_seq');
			var pg_kind = $(this).attr('pg_kind');
			var settleprice= $(this).attr('settleprice');
			var  tax_bank = '';
			var cst_platform = '';

			openDialogAlert(getAlert('mp184'),400,140,function(){

				if(pg_kind){
					if(pg_kind=="lg"){
						$.ajax({
							'url' : '../mypage_process/order_pg_info',
							'data' : {'order_seq':ordno},
							'type' : 'post',
							'dataType' : 'json',
							'success' : function(data) {
								if(data.result) {
									var  tax_bank = data.tax_bank;
									var cst_platform = data.cst_platform;
									cashView(cash_no, shopid, ordno, settleprice, tax_bank, cst_platform, pg_kind);
								}
							}
						});
					}else{
						var  tax_bank		= '';
						var cst_platform	= '';
						cashView(cash_no, shopid, ordno, settleprice, tax_bank, cst_platform, pg_kind);
					}
				}else{
<?php if($TPL_VAR["config_system"]["pgCompany"]=='lg'){?>
						$.ajax({
							'url' : '../mypage_process/order_pg_info',
							'data' : {'order_seq':ordno},
							'type' : 'post',
							'dataType' : 'json',
							'success' : function(data) {
								if(data.result) {
									var  tax_bank = data.tax_bank;
									var cst_platform = data.cst_platform;
									cashView(cash_no, shopid, ordno, settleprice, tax_bank, cst_platform, pg_kind);
								}
							}
						});
<?php }else{?>
						var  tax_bank		= '';
						var cst_platform	= '';
						cashView(cash_no, shopid, ordno, settleprice, tax_bank, cst_platform, pg_kind);
<?php }?>
				}

			});
		});

		$(".completeOver").click(function(){
			openDialogAlert(getAlert('mp213'),400,140,function(){ });
		});

		$(".cancelBtn").click(function(){
			var order_seq = $(this).attr('order_seq');

			openDialogConfirm(getAlert('mp212'),400,140,function(){
				$.ajax({
					'url' : '../mypage_process/cancel_tax',
					'data' : {'order_seq':order_seq},
					'type' : 'post',
					'dataType' : 'json',
					'success' : function(data) {
						if(data.result) {
							openDialogAlert(getAlert('mp041'),400,150,function(){
								document.location.reload();
							});
						}
					}
				});
			},function(){ });
		});

		$('[name="receipt_type"]').change(function(){
			if ( $(this).val() == '' ) {
				$('#receipt_apply').hide();
				return false;
			} else {
				$('#receipt_apply').show();
			}

			var _index = $(this).find('option:selected').index(), v = $(this).val(), receipt_possible = $('[name="receipt_type"] option').eq(_index).attr('receipt_possible');

			$('#receipt_apply option:eq(0)').attr('selected', true);

			switch(v) {
				case 'tax':
					$('.receipt_date_limit').eq(0).show();
					$('.receipt_date_limit').eq(1).hide();

					$('#saleslay [name="typereceipt"]').attr('checked', false);
					$('#saleslay [name="typereceipt"]').eq(2).attr('checked', true);

					if(!receipt_possible) {
						$('#receipt_apply').attr('disabled', true).css({ background:'#dbdbdb' });
					} else {
						$('#receipt_apply').attr('disabled', false).css({ background:'' });
					}

					$('#saleslay #tax_container').show();
					$('#saleslay #cash_container').hide();
					break;
				case 'cash':
					$('.receipt_date_limit').eq(0).hide();
					$('.receipt_date_limit').eq(1).show();

					$('#saleslay [name="typereceipt"]').attr('checked', false);
					$('#saleslay [name="typereceipt"]').eq(1).attr('checked', true).focus();

					if(!receipt_possible) {
						$('#receipt_apply').attr('disabled', true).css({ background:'#dbdbdb' });
					} else {
						$('#receipt_apply').attr('disabled', false).css({ background:'' });
					}

					$('#saleslay #tax_container').hide();
					$('#saleslay #cash_container').show();
					break;
			}
		});

		// 영수증 발급을 클릭했을경우
		$("input:radio[name='typereceipt']").click(function() {
			// 발급안함
			if($(this).val() == 0) {
				$('#cash_container').hide();
				$('#tax_container').hide();
				taxRemoveClass();
				cashRemoveClass();
			}
			// 세금계산서 신청일 경우
			else if($(this).val() == 1) {
				$('#tax_container').show();
				$('#cash_container').hide();

				$('#co_name').attr('title', ' ').addClass('required');
				$('#co_ceo').attr('title', ' ').addClass('required');
				$('#busi_no').attr('title', ' ').addClass('required').addClass('busiNo');
				$('#co_zipcode').attr('title', ' ').addClass('required');
				$('#co_address').attr('title', ' ').addClass('required');
				$('#co_status').attr('title', ' ').addClass('required');
				$('#co_type').attr('title', ' ').addClass('required');

				cashRemoveClass();
			}
			// 현금영수증 신청일 경우
			else if($(this).val() == 2) {
				$('#cash_container').show();
				$('#tax_container').hide();
				$('#creceipt_number').attr('title', ' ').addClass('required').addClass('numberHyphen');
				taxRemoveClass();
			}
		});

		/**
		 * 세금계산서 폼체크를 삭제한다.
		 */
		function taxRemoveClass() {
			$('#co_name').removeClass('required');
			$('#co_ceo').removeClass('required');
			$('#busi_no').removeClass('required');
			$('#co_zipcode').removeClass('required');
			$('#co_address').removeClass('required');
			$('#co_status').removeClass('required');
			$('#co_type').removeClass('required');
		}

		/**
		 * 현금영수증 폼체크를 삭제한다.
		 */
		function cashRemoveClass() {
			$('#creceipt_number').removeClass('required');
		}

		//현금영수증 개인공제용
		$("#cuse0").click(function(){
			$("#personallay").show();
			$("#businesslay").hide();
		});

		//현금영수증 사업자지출증빙용
		$("#cuse1").click(function(){
			$("#personallay").hide();
			$("#businesslay").show();
		});

		$(".salesBtn").click(function(){
			//매출증빙
			openDialog(getAlert('mp120'), "saleslay", {"width":500,"height":400});
		});

		$(".exportbuyconfirm").live('click',function(){
			var export_code = $(this).attr('export_code');
			var status = $(this).attr('status');
			$("#export_buy_confirm_msg input[name='export_code']").val(export_code);
			$("#export_buy_confirm_msg input[name='status']").val(status);

			if(status!='75'){
				$(".export_buy_confirm_agree_container").show();
			}else{
				$(".export_buy_confirm_agree_container").hide();
			}

			// 배송완료 전이면 수령확인 메시지
			//구매 확정 및 캐시/포인트 지급
			showCenterLayer('#export_buy_confirm_msg');
			//openDialog(getAlert('mp121'), "#export_buy_confirm_msg",{"width":550});
		});

		$("#export_buy_confirm_btn").live("click",function(){
			var ret = false;
			var export_code = $("#export_buy_confirm_msg input[name='export_code']").val();
			var status = $("#export_buy_confirm_msg input[name='status']").val();

			if(status!='75'){
				if(!$("input[name='export_buy_confirm_agree'][value='y']").is(":checked")){
					//상품수령여부에 체크해주세요.
					openDialogAlert(getAlert('mp129'),'450','140',function(){
						$("input[name='export_buy_confirm_agree']").eq(0).focus();
					});
					return;
				}
			}
			hideCenterLayer('#export_buy_confirm_msg');
			//closeDialog("#export_buy_confirm_msg");
			export_buy_confirm(export_code);
		});

		$(".price_area").bind("mouseover",function(){
			$(this).parent().find(".sale_price_layer").show();
		}).bind("mouseout",function(){
			$(this).parent().find(".sale_price_layer").hide();
		});

		// 사은품 지급 조건 상세
		$(".gift_log").bind('click', function(){
			$.ajax({
				type: "post",
				url: "./gift_use_log",
				data: "order_seq="+$(this).attr('order_seq')+"&item_seq="+$(this).attr('item_seq'),
				success: function(result){
					if	(result){
						$("#gift_use_lay .layer_pop_contents").html(result);
						//사은품 이벤트 정보
						showCenterLayer('#gift_use_lay');
						//openDialog(getAlert('mp122'), "gift_use_lay", {"width":"450","height":"220"});
					}
				}
			});
		});

		$(".sale").bind("mouseover",function(){
			$(this).closest('td').find('div').removeClass('hide');
		}).bind("mouseout",function(){
			$(this).closest('td').find('div').addClass('hide');
		});

		/* 토글 레이어 */
		$(".detailDescriptionLayerBtn").click(function(){
			$('div.detailDescriptionLayer').not($(this).siblings('div.detailDescriptionLayer')).hide();
			$(this).siblings('div.detailDescriptionLayer').toggle();
		});
		$(".detailDescriptionLayerCloseBtn").click(function(){
			$(this).closest('div.detailDescriptionLayer').hide();
		});
	});

	// 쿠폰 사용내역 조회
	function coupon_history(exportCode,serial){
		$("#coupon_use_lay .layer_pop_contents").html('');
		$.ajax({
			type: "get",
			url: "./coupon_view?code="+exportCode+"&scode="+serial+"&popup=1",
			data: "code="+exportCode,
			success: function(result){
				if	(result.search(/error\:/) != -1){
					openDialogAlert(result.replace('error:', ''), 400, 150);
				}else{
					$("#coupon_use_lay .layer_pop_contents").html(result);
					showCenterLayer('#coupon_use_lay');
					//openDialog(getAlert('mp123')+' - <span class="desc" style="color:#0083a9" >'+serial+'</span>', "#coupon_use_lay", {"width":"500","height":"550"});
				}
			}
		});
	}

	// 쿠폰 사용하기
	function coupon_use(exportCode,serial){
		if ( window.innerWidth > 767 ) {
			window.open("./coupon_use?code="+exportCode+"&scode="+serial+"&popup=1",'coupon_use', 'width=500, height=600, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=yes, scrollbar=yes');
		} else {
			window.open("./coupon_use?code="+exportCode+"&scode="+serial+"&popup=1", "_blank");
		}
	}

	//구매확정처리
	function export_buy_confirm(export_code){
		$.ajax({
			'url' : '../mypage_process/buy_confirm',
			'data' : {'export_code':export_code},
			'type' : 'get',
			'dataType' : 'json',
			'success' : function(data) {
				if(data.result) {
					openDialogAlert(data.msg,'450','200',function(){document.location.reload();});
				}else if(data.msg){
					openDialogAlert(data.msg,'450','200');
				}
			}
		});
	}

	function goods_review_write(goodsseq,order_seq){
		if(goodsseq){
<?php if(defined('__ISUSER__')){?>
				location.href = '/mypage/mygdreview_write?goods_seq='+goodsseq+'&order_seq='+order_seq;
<?php }else{?>
				location.href = '/board/write?id=goods_review&goods_seq='+goodsseq+'&order_seq='+order_seq;
<?php }?>
		}
	}

	function order_cancel(order_seq){
		//주문을 무효처리 합니다.
		if(confirm(getAlert('mp124')))
		{
			actionFrame.location.href = '../mypage_process/cancel?order_seq=<?php echo $TPL_VAR["orders"]["order_seq"]?>';
		}
	}

	function order_refund(order_seq){
		location.href='/mypage/order_refund?order_seq=' + order_seq + '&use_layout=1';
	}

	function order_return_coupon(order_seq){
		location.href='/mypage/order_return?mode=return_coupon&order_seq=' + order_seq + '&type=return&use_layout=1';
	}

	function order_return(order_seq){
		location.href='/mypage/order_return?order_seq=' + order_seq + '&type=return&use_layout=1';
	}

	function order_exchange(order_seq){
		location.href='/mypage/order_return?mode=exchange&order_seq=' + order_seq + '&type=exchange&use_layout=1';
	}

	//매출전표 처리
	function receiptView(tno, shopid, ordno, pg_kind, authdata, payment) {
		if(pg_kind){
			if(pg_kind=='kcp'){
				if(payment == "cellphone"){
					receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=mcash_bill&h_trade_no=" + tno;
				}else if(payment == "virtual"){
					receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=vcnt_bill&a_trade_no=" + tno;
				}else if(payment == "account"){
					receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=acnt_bill&h_trade_no=" + tno;
				}else{
					receiptWin = "https://admin.kcp.co.kr/Modules/Sale/Card/ADSA_CARD_BILL_Receipt.jsp?c_trade_no=" + tno;
				}
				window.open(receiptWin , "" , "width=450,height=800,scrollbars=yes");
			}else if(pg_kind=='inicis'){
				receiptWin = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid="+ tno + "&noMethod=1";
				window.open(receiptWin , "" , "width=410,height=715, scrollbars=no,resizable=no");
			}else if(pg_kind=='lg'){
				showReceiptByTID(shopid, tno, authdata);
			}else if(pg_kind=='allat'){
				var allat_urls = "https://www.allatpay.com/servlet/AllatBizPop/member/pop_card_receipt.jsp?tx_seq_no="+tno+"&order_no="+ordno;
				window.open(allat_urls,"app","width=410,height=650,scrollbars=0");
			}else if(pg_kind=='kspay'){
				var allat_urls = "https://nims.ksnet.co.kr/pg_infoc/src/bill/credit_view_print.jsp?tr_no="+tno;
				window.open(allat_urls,"app","width=456,height=700,scrollbars=1");
			}else if(pg_kind=='kakaopay'){
				var status = "toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=550,height=540";
				$.get('/kakaopay/pg_confirm?no='+ordno+'&tno='+tno, function(data) {
					var url = data;
					window.open(url,"popupIssue",status);
				});
			}else if(pg_kind=='kicc'){
				var status = "toolbar=0,scroll=1,menubar=0,status=0,resizable=0,width=380,height=700";
				$.get('/kicc/receipt?no='+ordno, function(data) {
					var url = data;
					if(url!='false'){
						window.open(url,"popupIssue",status);
					}else{
						alert('매출증빙 요청 정보가 올바르지 않습니다.');
					}
				});
			}else if(pg_kind=='payco'){
				var status = "toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=550,height=540";
				$.get('/payco/pg_confirm?no='+ordno, function(data) {
					var url = data;
					window.open(url,"popupIssue",status);
				});
			}
		}else{
<?php if($TPL_VAR["config_system"]["pgCompany"]=='kcp'){?>
				if(payment == "cellphone"){
					receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=mcash_bill&h_trade_no=" + tno;
				}else if(payment == "virtual"){
					receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=vcnt_bill&a_trade_no=" + tno;
				}else if(payment == "account"){
					receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=acnt_bill&h_trade_no=" + tno;
				}else{
					receiptWin = "https://admin.kcp.co.kr/Modules/Sale/Card/ADSA_CARD_BILL_Receipt.jsp?c_trade_no=" + tno;
				}
				window.open(receiptWin , "" , "width=450, height=800");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='inicis'){?>
				receiptWin = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid="+ tno + "&noMethod=1";
				window.open(receiptWin , "" , "width=410,height=715, scrollbars=no,resizable=no");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='lg'){?>
				showReceiptByTID(shopid, tno, authdata);
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='allat'){?>
				var allat_urls = "https://www.allatpay.com/servlet/AllatBizPop/member/pop_card_receipt.jsp?tx_seq_no="+tno+"&order_no="+ordno;
				window.open(allat_urls,"app","width=410,height=650,scrollbars=0");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='kspay'){?>
				var allat_urls = "https://nims.ksnet.co.kr/pg_infoc/src/bill/credit_view_print.jsp?tr_no="+tno;
				window.open(allat_urls,"app","width=456,height=700,scrollbars=1");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='kicc'){?>
				var status = "toolbar=0,scroll=1,menubar=0,status=0,resizable=0,width=380,height=700";
				$.get('/kicc/receipt?no='+ordno, function(data) {
					var url = data;
					if(url!='false'){
						window.open(url,"popupIssue",status);
					}else{
						alert('매출증빙 요청 정보가 올바르지 않습니다.');
					}
				});
<?php }?>
		}
	}

	//현금영수증처리
	function cashView(cash_no, shopid, ordno, settleprice, tax_bank, cst_platform, pg_kind)	{
		if(pg_kind){
			if(pg_kind=="kcp"){
				receiptWin = receiptWin = "https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?cash_no="+cash_no;
					window.open(receiptWin , "" , "width=360, height=647");
			}else if(pg_kind=="inicis"){
				showreceiptUrl = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid="+ cash_no + "&clpaymethod=22";
					window.open(showreceiptUrl,"showreceipt","width=380,height=540, scrollbars=no,resizable=no");
			}else if(pg_kind=="lg"){
				showCashReceipts(shopid, ordno, '01', tax_bank, cst_platform);
			}else if(pg_kind=="allat"){
				var cash_no = cash_no.replace( /(^\s*)|(\s*$)/g, "" );
					var urls ="https://www.allatpay.com/servlet/AllatBizPop/member/pop_cash_receipt.jsp?receipt_seq_no="+ cash_no + "&shop_id="+shopid+"&amt="+settleprice;
					window.open(urls,"app","width=410,height=650,scrollbars=0");
			}else if(pg_kind=="kspay"){
				showreceiptUrl = "https://nims.ksnet.co.kr/pg_infoc/src/bill/ps2.jsp?s_pg_deal_numb="+cash_no;
					window.open(showreceiptUrl ,"showreceipt","width=435, height=540");
			}else if(pg_kind=='kicc'){
				var status = "toolbar=0,scroll=1,menubar=0,status=0,resizable=0,width=380,height=700";
				$.get('/kicc/receipt?no='+ordno, function(data) {
					var url = data;
					if(url!='false'){
						window.open(url,"popupIssue",status);
					}else{
						alert('매출증빙 요청 정보가 올바르지 않습니다.');
					}
				});
			}
		}else{
<?php if($TPL_VAR["config_system"]["pgCompany"]==="kcp"){?>
					receiptWin = receiptWin = "https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?cash_no="+cash_no;
					window.open(receiptWin , "" , "width=360, height=647");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]==="inicis"){?>
					showreceiptUrl = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid="+ cash_no + "&clpaymethod=22";
					window.open(showreceiptUrl,"showreceipt","width=380,height=540, scrollbars=no,resizable=no");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='lg'){?>
					showCashReceipts(shopid, ordno, '01', tax_bank, cst_platform);
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='allat'){?>
					var cash_no = cash_no.replace( /(^\s*)|(\s*$)/g, "" );
					var urls ="https://www.allatpay.com/servlet/AllatBizPop/member/pop_cash_receipt.jsp?receipt_seq_no="+ cash_no + "&shop_id="+shopid+"&amt="+settleprice;
					window.open(urls,"app","width=410,height=650,scrollbars=0");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='kspay'){?>
					showreceiptUrl = "https://nims.ksnet.co.kr/pg_infoc/src/bill/ps2.jsp?s_pg_deal_numb="+cash_no;
					window.open(showreceiptUrl ,"showreceipt","width=435, height=540");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='kicc'){?>
				var status = "toolbar=0,scroll=1,menubar=0,status=0,resizable=0,width=380,height=700";
				$.get('/kicc/receipt?no='+ordno, function(data) {
					var url = data;
					if(url!='false'){
						window.open(url,"popupIssue",status);
					}else{
						alert('매출증빙 요청 정보가 올바르지 않습니다.');
					}
				});
<?php }?>
		}
	}

	function taxlayerclose(){
		hideCenterLayer('#saleslay');
		//$('#saleslay').dialog('close');
	}

	/**
	 * 배송메시지
	*/
	$(function(){
		// 초기 모든 배송메세지 길이 체크
		$('.ship-lay').each(function(){
			var obj = $(this);
			check_ship_message_length(obj);
		});
	});

	for(var i=0; i< lately_msg_list.length; i++){
		$(".add_message").append("<li>(최근) "+lately_msg_list[i]+"</li>");
	}

	$("#shipMessage .ship_message_txt").on('focus', function(){
		if($(this).closest(".ship_message").find(".add_message").css("display")=='none'){
			$(".add_message").hide();
			$(this).closest(".ship_message").find(".add_message").show();
		}else{
			$(".add_message").hide();
			$(this).closest(".ship_message").find(".add_message").hide();
		}
	});
	$("#shipMessage .ship_message_txt").on('blur', function(){
		$(".add_message").hide();
	});
	$(".add_message>li").on("mousedown", function(){
		var sel_message = $(this).html();
		sel_message = sel_message.replace('(최근) ','');
		$(this).closest(".ship_message").find(".ship_message_txt").val(sel_message).trigger('change');
		$(".add_message").hide();
	});

	// 배송메세지 카운터
	$(".ship_message_txt").bind("keyup change", function(){
		var obj = $(this).closest(".ship-lay");
		check_ship_message_length(obj);
	});

	// 배송메세지 길이 체크
	function check_ship_message_length(obj){
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
	}

	// 배송지 수정 완료
	function callback_recipient() {
		//var elem = $('.order_settle .benefit'), f = {}, form = $('form[name="recipient"]', elem), buff = form.serializeArray();
		var elem = $('.orderSettle'), f = {}, form = $('form[name="recipient"]', elem), buff = form.serializeArray();

		$.each(buff, function(k, v){
			f[v.name] = v.value;
		});

		// 개별 가져오기
		f.recipient_cellphone = '';
		$('[name="recipient_cellphone[]"]', form).each(function(){
			f.recipient_cellphone += (f.recipient_cellphone ? '-' : '') + $(this).val();
		});

		f.recipient_phone = '';
		$('[name="recipient_phone[]"]', form).each(function(){
			f.recipient_phone += (f.recipient_phone ? '-' : '') + $(this).val();
		});

		$('.recipient_user_name', elem).html(f.recipient_user_name);
		$('.recipient_zipcode', elem).html(f.recipient_new_zipcode);
		$('.recipient_address', elem).html(f.recipient_address);
		$('.recipient_address_street', elem).html(f.recipient_address_street);
		$('.recipient_address_detail', elem).html(f.recipient_address_detail);
		$('.recipient_cellphone', elem).html(f.recipient_cellphone);
		$('.recipient_phone', elem).html(f.recipient_phone);
		$('.recipient_email', elem).html(f.recipient_email);
		$('.recipient_ship_message', elem).html(f.memo);
		$('.international_address', elem).html(f.international_address);
		$('.international_country', elem).html(f.international_country);
		$('.international_county', elem).html(f.international_county);
		$('.international_postcode', elem).html(f.international_postcode);
		$('.international_town_city', elem).html(f.international_town_city);
		$('.clearance_unique_personal_code', elem).html(f.clearance_unique_personal_code);

		// 상품별 배송메세지
		$('#edit_address_wrap .ship_message_txt', elem).each(function(){
			var index = $('#edit_address_wrap .ship_message_txt', elem).index($(this)), ship_message = $(this).val();
			$('#view_address_wrap .recipient_ship_messages', elem).eq(index).text(ship_message);
		});

		// visible sw
		f.recipient_phone ? $('.recipient_phone', elem).show() : $('.recipient_phone', elem).hide();
		f.recipient_email ? $('.recipient_email', elem).show() : $('.recipient_email', elem).hide();
		f.memo ? $('.recipient_ship_message', elem).parents('li').show() : $('.recipient_ship_message', elem).parents('li').hide();

		mode_change('address_wrap', 'view');
	}

	// 배송주소록 팝업 창 :: 2016-08-02 lwh
	function popDeliveryaddress(page){
		var member_seq = $("input[name='member_seq']").val(), international = $("input[name='international']").val();
		$.ajax({
			'url'	: '/order/pop_delivery_address',
			'data'	: {'page':page,'member_seq':member_seq, 'international': international},
			'type'	: 'get',
			'dataType': 'text',
			'success': function(html) {
				if(html){
					//$("#delivery_address_dialog").html(html);
					$("#delivery_address_dialog .layer_pop_contents").html(html);
					if(page != 'reload'){
						//주소록
						//openDialog(getAlert('os185'), "delivery_address_dialog", {"width":730,"height":480});
						showCenterLayer('#delivery_address_dialog');
					}
				}else{
					//주소록을 로드하지 못했습니다.
					alert(getAlert('os182'));
					document.location.reload();
				}
			}
		});
	}

	// 배송지 수정 등록 용 국가변경 :: 2016-08-03 lwh
	function chg_address_nation(obj){
		var sel_nation = $(obj).val();
		if(sel_nation == 'KOREA'){
			$("#inAddress").find(".domestic").show();
			$("#inAddress").find(".international").hide();
		}else{
			$("#inAddress").find(".domestic").hide();
			$("#inAddress").find(".international").show();
		}
	}

	// 추가연락처
	function add_phone(obj, type){
		if			(type == 'open'){
			$(obj).closest('li').next('.add_phone').show();
			$(obj).attr('onclick',"add_phone(this,'close')");
			$(obj).html('추가연락처 ▲');
		}else if	(type == 'close'){
			$(obj).closest('li').next('.add_phone').hide();
			$(obj).attr('onclick',"add_phone(this,'open')");
			$(obj).html('추가연락처 ▼');
		}else{ // 체크하여 값이 있으면 열기
			var add_phone_flag = true;
			$(obj).closest('li').next('.add_phone').find('input.add_phone_input').each(function(){
				if (!$(this).val())	add_phone_flag = false;
			});

			if(add_phone_flag){
				$(obj).closest('li').next('.add_phone').show();
				$(obj).attr('onclick',"add_phone(this,'close')");
				$(obj).html('추가연락처 ▲');
			}
		}
	}

	// PC용 주소지정 - 주소록 지정 / 배송지 선택지정
	function set_address(addr){
		if(addr == 'new'){ // 신규 배송지
			$("input[name='recipient_new_zipcode']").val('');
			$("input[name='recipient_address_type']").val('');
			$("input[name='recipient_address']").val('');
			$("input[name='recipient_address_street']").val('');
			$("input[name='recipient_address_detail']").val('');
			$("input[name='recipient_user_name']").val('');
			$("input[name='international_address']").val('');
			$("input[name='international_town_city']").val('');
			$("input[name='international_county']").val('');
			$("input[name='international_postcode']").val('');
			$("input[name='recipient_phone[]']").each(function(idx){
				$("input[name='recipient_phone[]']").eq(idx).val("");
			});
			$("input[name='recipient_cellphone[]']").each(function(idx){
				$("input[name='recipient_cellphone[]']").eq(idx).val("");
			});
			$("input[name='recipient_email']").val('');
			$(".international").hide();
			if(!$("#address_nation").val()){
				$("#address_nation").val('KOREA').trigger('change');
			}
			set_shipping('input');
		}else if(addr == 'modify'){
			$(".delivery_member").hide();
			$(".international").hide();
			$("#address_nation").val('KOREA').trigger('change');
		}else{
			var is_error = false;

			$(".kr_zipcode").show();
			if(addr.nation == 'KOREA' || addr.international == 'domestic'){
				// apply
				$.ajax({
					type: "POST",
					method: "POST",
					url: "../mypage_process/recipient",
					data: {
						"mode" : "json",
						"order_seq":"<?php echo $TPL_VAR["orders"]["order_seq"]?>",
						"international":"domestic",
						"recipient_user_name":addr.recipient_user_name,
						"region":addr.region,
						"recipient_new_zipcode":addr.recipient_new_zipcode,
						"recipient_address":addr.recipient_address,
						"recipient_address_street":addr.recipient_address_street,
						"recipient_address_detail":addr.recipient_address_detail,
						"recipient_address_type":addr.recipient_address_type,
						"recipient_cellphone":addr.recipient_cellphone,
						"recipient_phone":addr.recipient_phone,
						"recipient_email":addr.recipient_email
					},
					dataType: "json",
					async: false
				})
				.done(function(data){
					switch(data.state) {
						case '999':
							data.error_message && openDialogAlert(data.error_message, 400, 150);
							data.location && (location.href = data.location);
							is_error = true;
							break;
						default:

					}
				});

				if(is_error) {
					return false;
				}

				// input values
				$("#international").val('0');
				$(".kr_zipcode").show();
				$("input[name='international']").val('domestic');
				$("input[name='address_description']").val(addr.address_description);
				$("input[name='recipient_user_name']").val(addr.recipient_user_name);
				$("input[name='recipient_address_type']").val(addr.recipient_address_type);
				$("input[name='recipient_address']").val(addr.recipient_address);
				$("input[name='recipient_address_street']").val(addr.recipient_address_street);
				$("input[name='recipient_address_detail']").val(addr.recipient_address_detail);
				$("input[name='recipient_new_zipcode']").eq(0).val(addr.recipient_new_zipcode);
				$("input[name='recipient_email']").val(addr.recipient_email);
				if (addr.recipient_phone != null) {
					$("input[name='recipient_phone[]']").each(function(idx){
						$(this).val( addr.recipient_phone.split('-')[idx] );
					});
				}
				if (addr.recipient_cellphone != null) {
					$("input[name='recipient_cellphone[]']").each(function(idx){
						$(this).val( addr.recipient_cellphone.split('-')[idx] );
					});
				}

				// span values
				if(addr.recipient_user_name)
						$(".recipient_user_name").html(addr.recipient_user_name);
				else	$(".recipient_user_name").html('받는분 없음');

				if(addr.recipient_new_zipcode){
					$(".recipient_zipcode").html(addr.recipient_new_zipcode);
					$(".recipient_address_street").html(addr.recipient_address_street);
					$(".recipient_address").html(addr.recipient_address);
					$(".recipient_address_detail").html(addr.recipient_address_detail);
				}else{
					$(".kr_zipcode").hide();
					$(".recipient_address").html('배송주소 없음');
				}

				if(addr.recipient_cellphone)
						$(".cellphone").html(addr.recipient_cellphone);
				else	$(".cellphone").html('휴대폰번호 없음');

				if(addr.recipient_phone)
						$(".phone").html(addr.recipient_phone);
				else	$(".phone").html('추가연락처 없음');

				$(".international_nation").html('대한민국');
				$("#address_nation").val('KOREA').trigger('change');

				// 국내 ON, 해외 OFF
				$('#view_address_wrap .domestic').show();
				$('#view_address_wrap .international').hide();
				$('#edit_address_wrap .domestic').show();
				$('#edit_address_wrap .international').hide();
				$('#edit_address_wrap .domestic input').attr('disabled', false);
				$('#edit_address_wrap .international input').attr('disabled', true);
			}else{
				// apply
				$.ajax({
					type: "POST",
					method: "POST",
					url: "../mypage_process/recipient",
					data: {
						"mode" : "json",
						"order_seq":"<?php echo $TPL_VAR["orders"]["order_seq"]?>",
						"international":"international",
						"recipient_user_name":addr.recipient_user_name,
						"region":addr.region,
						"international_address":addr.international_address,
						"international_town_city":addr.international_town_city,
						"international_county":addr.international_county,
						"international_postcode":addr.international_postcode,
						"international_country":addr.international_country,
						"recipient_cellphone":addr.recipient_cellphone,
						"recipient_phone":addr.recipient_phone,
						"recipient_email":addr.recipient_email
					},
					dataType: "json",
					async: false
				})
				.done(function(data){
					switch(data.state) {
						case '999':
							data.error_message && openDialogAlert(data.error_message, 400, 150);
							data.location && (location.href = data.location);
							is_error = true;
							break;
						default:

					}
				});

				if(is_error) {
					return false;
				}

				// input values
				$("#international").val('1');
				$(".kr_zipcode").hide();
				$("input[name='international']").val('international');
				$("input[name='address_description']").val(addr.address_description);
				$("input[name='recipient_user_name']").val(addr.recipient_user_name);
				$("select[name='region']").val(addr.region);
				$("input[name='international_county']").val(addr.international_county);
				$("input[name='international_address']").val(addr.international_address);
				$("input[name='international_town_city']").val(addr.international_town_city);
				$("input[name='international_postcode']").val(addr.international_postcode);
				$("input[name='international_country']").val(addr.international_country);
				$("input[name='recipient_email']").val(addr.recipient_email);
				if (addr.recipient_phone != null) {
					$("input[name='recipient_phone[]']").each(function(idx){
						$(this).val( addr.recipient_phone.split('-')[idx] );
					});
				}
				if (addr.recipient_cellphone != null) {
					$("input[name='recipient_cellphone[]']").each(function(idx){
						$(this).val( addr.recipient_cellphone.split('-')[idx] );
					});
				}

				// span values
				$(".recipient_user_name").html(addr.recipient_user_name);
				$(".international_address").html(addr.international_address);
				$(".international_town_city").html(addr.international_town_city);
				$(".international_county").html(addr.international_county);
				$(".international_country").html(addr.international_country);
				addr.recipient_cellphone && addr.recipient_cellphone != '--' ? $(".recipient_cellphone").html(addr.recipient_cellphone).show() : $(".recipient_cellphone").hide();
				addr.recipient_phone && addr.recipient_phone != '--' ? $(".recipient_phone").html((addr.recipient_cellphone && addr.recipient_phone ? ' / ' : '') + addr.recipient_phone).show() : $(".recipient_phone").hide();
				$(".recipient_email").html(addr.recipient_email);
				$(".international_nation").html(addr.nation);
				$(".nation_name").html(addr.nation.replace(/^([가-힣.]+) \([a-z.]+\)/i, '$1'));
				$("#address_nation").val(addr.nation).trigger('change');

				// 국내 OFF, 해외 ON
				$('#view_address_wrap .domestic').hide();
				$('#view_address_wrap .international').show();
				$('#edit_address_wrap .domestic').hide();
				$('#edit_address_wrap .international').show();
				$('#edit_address_wrap .domestic input').attr('disabled', true);
				$('#edit_address_wrap .international input').attr('disabled', false);
			} // end nation if

			if(addr.recipient_email) $(".recipient_email").html(addr.recipient_email);
			else	$(".recipient_email").html('이메일주소 없음');

			set_shipping('view');

			openDialogAlert("배송지가 변경되었습니다.", 400, 150);
		} // end address if
	}

	// 배송 view 결정 - 필수 배송호출 :: 2017-05-15 lwh
	function set_shipping(type){

		// 각 타입별 배송지 view
		$(".direct_store_info").hide();
		$(".coupon_delivery_info").hide();
		if(typeof(is_goods)!='undefined' && is_goods)
			$(".goods_delivery_info").show();
		if(typeof(is_direct_store)!='undefined' && is_direct_store)
			$(".direct_store_info").show();
		if(typeof(is_coupon)!='undefined' && is_coupon)
			$(".coupon_delivery_info").show();

		// 입력 또는 view 결정
		if(type == 'view'){
			$(".delivery_member").show();
		}else{
			$(".delivery_member").hide();
		}

		// 국가별 결정
		var international = $("#address_nation").val();
		if(international == 'KOREA'){
			$(".international").hide();
		}else{
			$(".domestic").hide();
		}
	}

	function mode_change(wrap_id, mode) {
		if(!wrap_id) return false;

		var edit_wrap_id = 'edit_' + wrap_id,
			 view_wrap_id = 'view_' + wrap_id,
			 international = $('#view_address_wrap [name="international"]').val();
			 address_nation = $('#view_address_wrap [name="address_nation"]').val();

		switch(mode) {
			case 'edit':
				openDialogAlert(getAlert('mo145'),400,140,function(){
					// 국가체크해서 입력폼 활성
					if(international == 'domestic' || address_nation == 'KOREA') {
						$('#edit_address_wrap .domestic').show();
						$('#edit_address_wrap .international').hide();
						$('#edit_address_wrap .domestic input').attr('disabled', false);
						$('#edit_address_wrap .international input').attr('disabled', true);
					} else {
						$('#edit_address_wrap .domestic').hide();
						$('#edit_address_wrap .international').show();
						$('#edit_address_wrap .domestic input').attr('disabled', true);
						$('#edit_address_wrap .international input').attr('disabled', false);
					}

					//$('#'+edit_wrap_id).show();
					//$('#'+view_wrap_id).hide();
					showCenterLayer('#' + edit_wrap_id);

				});
				break;
			case 'view':
				//$('#'+edit_wrap_id).hide();
				//$('#'+view_wrap_id).show();
				hideCenterLayer('#' + edit_wrap_id);
				break;
		}
	}

	// 페이코의 경우 현금 영수증 신청 불가능하도록 처리
    function init_block_payco_cash_receip(){
        var receipt_type = $("select[name='receipt_type']");
        var receipt_apply = $("#receipt_apply");
        var typereceipt = $("input:radio[name='typereceipt']:checked");
        
        // 페이코일때 현금영수증을 신청하려는 경우
        if('<?php echo $TPL_VAR["orders"]["pg"]?>'=='payco' // 페이코인경우
        //    && (    // 선택 조건과 상관 없이 페이코의 경우 세금계산서, 현금영수증을 신청할 수 없음.
        //        (receipt_type.val() == 'cash' &&  receipt_apply.val() == 'y') // 셀렉트에서 선택 시
        //        || (typereceipt.val() == '2')    // 팝업에서 선택 시
        //    )
        ){
            // 선택 조건 초기화
            receipt_type.val('tax');
            receipt_apply.val('n');
            // receipt_type.trigger('change');
            alert('페이코 간편결제로 결제하신 주문의 세금 계산서 및 현금 영수증은 페이코 사이트에서 발급할 수 있습니다.');
            // 레이어 닫기
            taxlayerclose();
        }
    }
//-->
</script>


<!-- 배송지등록 / 수정 :: START -->
<!-- 주문/배송 상세에서는 배송 주소록 가져오지 않는 것으로 처리함 (통신 에러남) -->
<div id="inAddress" class="hide">
	<form id="in_Address" method="post" >
	<input type="hidden" name="insert_mode" />
	<input type="hidden" name="page_type" value="order" />
	<input type="hidden" name="address_seq" />
	<div>- 자주쓰는 배송지는 최대 30개까지 등록할 수 있습니다.</div>
	<table width="100%" class="info_table_style mt10" border="0" cellpadding="5" cellspacing="0">
		<colgroup>
			<col width="90" />
			<col />
		</colgroup>
		<tbody>
			<tr >
				<th scope="row">그룹</th>
				<td>
					<select name="select_address_group">
<?php if($TPL_arr_address_group_1){foreach($TPL_VAR["arr_address_group"] as $TPL_V1){?>
<?php if($TPL_V1["address_group"]){?>
						<option value="<?php echo $TPL_V1["address_group"]?>"><?php echo $TPL_V1["address_group"]?></option>
<?php }?>
<?php }}?>
						<option value="">새 그룹 만들기</option>
					</select>
					<input type="text" name="address_group" value="" size="20" maxlength="20" />
					<div class="mt5"><label><input type="checkbox" name="save_delivery_address" value="1" /> 기본 배송지로 지정합니다.</label></div>
				</td>
			</tr>
			<tr >
				<th scope="row">설명</th>
				<td><input type="text" name="address_description" value="" size="45" /></td>
			</tr>
			<tr>
				<th scope="row">받는분</th>
				<td><input type="text" name="recipient_user_name" value="" size="20" title="받는분" /></td>
			</tr>
			<tr class="shipping_nation_tr">
				<th scope="row">국가</th>
				<td>
					<div style="float:left;padding-right:10px;" class="international_layer">
						<select name="nation_select" onchange="chg_address_nation(this);">
							<option value="KOREA">대한민국(KOREA)</option>
<?php if($TPL_ship_gl_arr_1){foreach($TPL_VAR["ship_gl_arr"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["nation_str"]?>"><?php echo $TPL_V1["nation_str"]?></option>
<?php }}?>
						</select>
					</div>
				</td>
			</tr>
			<tr class="domestic">
				<th scope="row">주소</th>
				<td>
					<input type="text" name="recipient_new_zipcode" value="" size="10" title="우편번호" readonly />
					<input type="hidden" name="check_new_zipcode" value="NEW" />
					<button type="button"  class="btn_move small" onclick="window.open('../popup/zipcode?mtype=delivery','popup_zipcode','width=600,height=480')">주소찾기</button>
					<input type="hidden" name="recipient_address_type" value="" title="배송지 주소지타입(도로명/지번)" />
					<div class="mt5"><input type="text" class="address_street" name="recipient_address_street" value="" size="45" title="도로명 주소" readonly /> <span class="desc">도로명 주소</span></div>
					<div class="mt5"><input type="text" name="recipient_address" value="" size="45" title="주소" readonly /> <span class="desc">지번 주소</span></div>
					<div class="mt5"><input type="text" name="recipient_address_detail" value="" size="45" title="나머지주소" /> <span class="desc">나머지주소</span></div>
				</td>
			</tr>
			<tr class="international hide">
				<th scope="row" valign="top">주소</th>
				<td>
					<input type="text" name="international_address" value="" size="45" title="주소" /> <span class="desc">주소</span>
					<div class="mt5"><input type="text" name="international_town_city" value="" size="30" title="시도" /> <span class="desc">시도</span></div>
					<div class="mt5"><input type="text" name="international_county" value="" size="22" title="주" /> <span class="desc">주</span></div>
					<div class="mt5"><input type="text" name="international_postcode" value="" size="15" title="우편번호" /> <span class="desc">우편번호</span></div>
					<div class="hide"><input type="text" name="international_country" value="" size="30" title="국가" /> <span class="desc">국가</span></div>
				</td>
			</tr>
			<tr>
				<th scope="row">연락처</th>
				<td>
					<ul class="list_inner">
					<li class="cellphone_li">
						<input type="tel" name="recipient_cellphone[]" value="" size="3" maxlength="4" onkeydown="onlyNumber(this)" title="받는분 휴대폰"/> -
						<input type="tel" name="recipient_cellphone[]" value="" size="2" maxlength="4" onkeydown="onlyNumber(this)" /> -
						<input type="tel" name="recipient_cellphone[]" value="" size="2" maxlength="4" onkeydown="onlyNumber(this)" />
						&nbsp;
						<span class="add_phone_btn hand" id="btn_inAddress_add_phone" onclick="add_phone(this,'open');">추가연락처 ▼</span>
					</li>
					<li class="add_phone pdt5 hide">
						<input type="tel" class="add_phone_input" name="recipient_phone[]" value="" size="3" maxlength="4" onkeydown="onlyNumber(this)" /> -
						<input type="tel" class="add_phone_input" name="recipient_phone[]" value="" size="2" maxlength="4" onkeydown="onlyNumber(this)" /> -
						<input type="tel" class="add_phone_input" name="recipient_phone[]" value="" size="2" maxlength="4" onkeydown="onlyNumber(this)" />
					</li>
					</ul>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btn_wrap">
		<button type="button" id="insert_address" class="btn_chg">확인</button>
	</div>
	</form>
</div>
<!-- 배송지등록 / 수정 :: END -->

<!-- 없는 것으로 보임 -->
<!--
<div id="sales_tax_layer" class="hide"></div>
-->

<!-- 없는 것으로 보임 -->
<!--
<div id="order_return_msg" class="hide">
	교환/ 반품 신청이 접수 되었습니다.<br />
	고객센터에서 확인 후 순차적으로 처리 및<br />
	답변 또는 연락을 드리겠습니다.<br />
	<br />
	<div class="center"><span class="btn small"><input type="button" value="확인" onclick="closeDialog('order_refund_layer');document.location.reload();" /></span></div>
</div>
-->

<!-- 없는 것으로 보임 -->
<!--
<div id="order_return_coupon_msg" class="hide">
	교환/ 반품 신청이 접수 되었습니다.<br />
	고객센터에서 확인 후 순차적으로 처리 및<br />
	답변 또는 연락을 드리겠습니다.<br />
	<br />
	<div class="center"><span class="btn small"><input type="button" value="확인" onclick="closeDialog('order_return_layer');document.location.reload();" /></span></div>
</div>
-->

<!-- 없는 것으로 보임 -->
<!--
<div id="coupon_use_guide" class="hide">
	<table class="coupon_use_guide_tb" cellpadding="0" cellspacing="0" border="0">
		<tr><td>발행된 티켓은 2가지 방법으로 사용할 수 있습니다.</td></tr>
		<tr><th>1. 스마트폰 인증을 통한 사용</th></tr>
		<tr><td class="contents">가지고 있는 휴대폰을 통해 간편한 인증을 거쳐 사용할 수 있습니다.</td></tr>
		<tr><td class="list_contents">
			① 스마트폰을 통해  쇼핑몰에 접속후 my페이지>주문배송조회로 이동<br/>
			② 해당 상품의 “사용하기’ 버튼 클릭<br/>
			③ 매장 직원 인증 확인
		</td></tr>
		<tr><td class="guide_img"><img src="/data/skin/responsive_diary_petit_gl/images/design/guide_img_cpn.jpg" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9ndWlkZV9pbWdfY3BuLmpwZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfdmlldy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9kZXNpZ24vZ3VpZGVfaW1nX2Nwbi5qcGc=' designElement='image' /></td></tr>
		<tr><th>2. 티켓 번호 인증을 통한 사용</th></tr>
		<tr><td class="contents">스마트폰이 없을 때는 발급받은 티켓 번호를 직접 매장 직원에게 알려줘서 사용가능합니다. 단 매장에 티켓 번호를 확인할 수 있는 인터넷 환경이 있어야 합니다.(인터넷이 연결된 PC 가 있어야 함)</td></tr>
	</table>
	<style type="text/css">
		#coupon_use_guide {display:none;padding:40px; }
		#coupon_use_guide table.coupon_use_guide_tb { width:100%; }
		#coupon_use_guide table.coupon_use_guide_tb th { text-align:left;padding-top:15px;}
		#coupon_use_guide table.coupon_use_guide_tb td { text-align:left; }
		#coupon_use_guide table.coupon_use_guide_tb td.guide_img { text-align:center; }
		#coupon_use_guide table.coupon_use_guide_tb td.contents { line-height:20px;padding:8px 15px;}
		#coupon_use_guide table.coupon_use_guide_tb td.list_contents { padding:0 15px;line-height:22px; }
	</style>
</div>
-->