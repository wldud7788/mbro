<?php /* Template_ 2.2.6 2020/12/30 18:42:54 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/order/complete.html 000035301 */ 
$TPL_shipping_group_items_1=empty($TPL_VAR["shipping_group_items"])||!is_array($TPL_VAR["shipping_group_items"])?0:count($TPL_VAR["shipping_group_items"]);
$TPL_items_1=empty($TPL_VAR["items"])||!is_array($TPL_VAR["items"])?0:count($TPL_VAR["items"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 주문완료 / 결제실패 @@
- 파일위치 : [스킨폴더]/order/complete.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_VAR["config_system"]["pgCompany"]=="lg"){?><script type="text/javascript" src="//pgweb.dacom.net/WEB_SERVER/js/receipt_link.js"></script><?php }?>
<?php if($TPL_VAR["config_system"]["pgCompany"]=="allat"){?> <?php }?>
<script type="text/javascript">
	//매출전표 처리
	function receiptView(tno, shopid, ordno, pg_kind, authdata, payment)
	{
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
				window.open(receiptWin , "" , "width=450, height=800, scrollbars=yes");
			}else if(pg_kind=='inicis'){
				receiptWin = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid="+ tno + "&noMethod=1";
				window.open(receiptWin , "" , "width=410,height=715, scrollbars=no,resizable=no");
			}else if(pg_kind=='lg'){
				showReceiptByTID(shopid, tno, authdata);
			}else if(pg_kind=='allat'){
				if(payment == "cellphone"){
					var allat_urls = "https://www.allatpay.com/servlet/AllatBizPop/member/pop_tx_receipt.jsp?tx_seq_no="+tno+"&order_no="+ordno+"&pay_type=HP";
					window.open(allat_urls,"app","width=410,height=650,scrollbars=0");
				}else{
					var allat_urls = "https://www.allatpay.com/servlet/AllatBizPop/member/pop_card_receipt.jsp?tx_seq_no="+tno+"&order_no="+ordno;
					window.open(allat_urls,"app","width=410,height=650,scrollbars=0");
				}
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
				window.open(receiptWin , "" , "width=450, height=800, scrollbars=yes");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='inicis'){?>
				receiptWin = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid="+ tno + "&noMethod=1";
				window.open(receiptWin , "" , "width=410,height=715, scrollbars=no,resizable=no");
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='lg'){?>
				showReceiptByTID(shopid, tno, authdata);
<?php }elseif($TPL_VAR["config_system"]["pgCompany"]=='allat'){?>
				if(payment == "cellphone"){
					var allat_urls = "https://www.allatpay.com/servlet/AllatBizPop/member/pop_tx_receipt.jsp?tx_seq_no="+tno+"&order_no="+ordno+"&pay_type=HP";
					window.open(allat_urls,"app","width=410,height=650,scrollbars=0");
				}else{
					var allat_urls = "https://www.allatpay.com/servlet/AllatBizPop/member/pop_card_receipt.jsp?tx_seq_no="+tno+"&order_no="+ordno;
					window.open(allat_urls,"app","width=410,height=650,scrollbars=0");
				}
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
</script>



<div class="subpage_wrap">
	<div class="subpage_container v3 Pb10">
		<!-- 타이틀 -->
		<div class="title_container">
			<a class="btn_history back" href="javascript:history.back();" hrefOri='amF2YXNjcmlwdDpoaXN0b3J5LmJhY2soKTs=' ><img src="/data/skin/responsive_diary_petit_gl/images/design/arw_prev.gif" alt="히스토리 뒤로" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9hcndfcHJldi5naWY=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9kZXNpZ24vYXJ3X3ByZXYuZ2lm' designElement='image' /></a>
<?php if($TPL_VAR["orders"]["step"]== 99||$TPL_VAR["orders"]["step"]== 0){?>
			<h2 class="pointcolor imp"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >결제실패</span></h2>
<?php }else{?>
			<h2><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >주문완료</span></h2>
<?php }?>
			<a class="btn_history forward" href="javascript:history.forward();" hrefOri='amF2YXNjcmlwdDpoaXN0b3J5LmZvcndhcmQoKTs=' ><img src="/data/skin/responsive_diary_petit_gl/images/design/arw_next.gif" alt="히스토리 앞으로" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9hcndfbmV4dC5naWY=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9kZXNpZ24vYXJ3X25leHQuZ2lm' designElement='image' /></a>
		</div>
		<div class="mypage_greeting">
<?php if($TPL_VAR["orders"]["step"]== 99||$TPL_VAR["orders"]["step"]== 0){?>
			<span class="username"><?php echo $TPL_VAR["orders"]["order_user_name"]?></span>님의 주문/결제가 <span class="pointcolor">실패하였습니다.</span>
<?php }else{?>
			<span class="username"><?php echo $TPL_VAR["orders"]["order_user_name"]?></span>님의 주문이 정상적으로 처리되었습니다.
<?php }?>
		</div>
	</div>
</div>


<div class="subpage_wrap order_payment" data-ezmark="undo">
	<div class="subpage_container v2 Pt0 Pb40 order_payment_left2">
		<h2 class="title_od1 Pt15"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >주문상품</span></h2>
<?php if($TPL_VAR["shipping_group_items"]){?>
		<div class="cart_contents">
			<div class="cart_list">
				
<?php if($TPL_shipping_group_items_1){foreach($TPL_VAR["shipping_group_items"] as $TPL_V1){?>
				<ul class="shipping_group_list">
<?php if(is_array($TPL_R2=$TPL_V1["items"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["options"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["options"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["shipping_division"]){?>
					<li class="goods_delivery_info clearbox">
						<ul class="detail">
							<li class="th">배송 :</li>
<?php if($TPL_V2["data_shipping"]){?>
							<li class="silmul">
<?php if($TPL_V2["data_shipping"]["provider_name"]){?>
								<span class="blue">[<?php echo $TPL_V2["data_shipping"]["provider_name"]?>]</span>
<?php }?>
								<span><?php echo $TPL_V2["data_shipping"]["shipping_set_name"]?></span>
<?php if($TPL_V2["data_shipping"]["shipping_cost"]> 0){?>
									<strong><?php echo get_currency_price($TPL_V2["data_shipping"]["shipping_cost"], 2)?></strong>
<?php }elseif($TPL_V2["data_shipping"]["postpaid"]> 0){?>
									<strong><?php echo get_currency_price($TPL_V2["data_shipping"]["postpaid"], 2)?></strong>
<?php }else{?>
									<strong>무료</strong>
<?php }?>
<?php if($TPL_V2["data_shipping"]["shipping_set_code"]=='direct_store'){?>
								<span class="ship_info">(수령매장 <?php echo $TPL_V2["data_shipping"]["shipping_store_name"]?>)</span>
<?php }else{?>
<?php if($TPL_V2["data_shipping"]["shipping_cost"]> 0||$TPL_V2["data_shipping"]["postpaid"]> 0){?>
								<span class="ship_info">(<?php echo $TPL_V2["data_shipping"]["shipping_pay_type"]?>)</span>
<?php }?>
<?php }?>
<?php if($TPL_V2["data_shipping"]["shipping_hop_date"]){?>
								<span class="ship_info">(<?php echo $TPL_V2["data_shipping"]["shipping_hop_date"]?> 희망)</span>
<?php }elseif($TPL_V2["data_shipping"]["reserve_sdate"]){?>
								<span class="ship_info">(<?php echo $TPL_V2["data_shipping"]["reserve_sdate"]?> 예약)</span>
<?php }?>
							</li>
<?php }?>
						</ul>
					</li>
<?php }?>

					<li class="cart_goods <?php if($TPL_V2["goods_type"]=='gift'){?>gift<?php }?>">
						<div class="cart_goods_detail">
							<div class="cgd_contents">
								<div class="block block1">
									<ul>
										<li class="img_area">
											<a href="../goods/view?no=<?php echo $TPL_V2["goods_seq"]?>" hrefOri='Li4vZ29vZHMvdmlldz9ubz17Li5nb29kc19zZXF9' ><img src="<?php echo $TPL_V2["image"]?>" class="goods_thumb" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage_list.gif'" designImgSrcOri='ey4uaW1hZ2V9' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s' designImgSrc='ey4uaW1hZ2V9' designElement='image' /></a>
										</li>
										<li class="option_area">
											<div class="goods_name v2 d2">
												<a href="../goods/view?no=<?php echo $TPL_V2["goods_seq"]?>" hrefOri='Li4vZ29vZHMvdmlldz9ubz17Li5nb29kc19zZXF9' ><?php echo $TPL_V2["goods_name"]?></a>
											</div>

<?php if($TPL_V2["goods_type"]=='gift'||$TPL_V2["adult_goods"]=='Y'||$TPL_V2["option_international_shipping_status"]=='y'||$TPL_V2["cancel_type"]=='1'||$TPL_V2["tax"]=='exempt'){?>
											<div class="icon_area">
<?php if($TPL_V2["goods_type"]=='gift'){?>
												[사은품]
<?php }?>
<?php if($TPL_V2["adult_goods"]=='Y'){?>
												<img src="/data/skin/responsive_diary_petit_gl/images/common/auth_img.png" alt="성인" class="icon1" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9hdXRoX2ltZy5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vYXV0aF9pbWcucG5n' designElement='image' />
<?php }?>
<?php if($TPL_V2["option_international_shipping_status"]=='y'){?>
												<img src="/data/skin/responsive_diary_petit_gl/images/common/plane.png" alt="해외배송상품" class="icon2" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9wbGFuZS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vcGxhbmUucG5n' designElement='image' />
<?php }?>
<?php if($TPL_V2["cancel_type"]=='1'){?>
												<img src="/data/skin/responsive_diary_petit_gl/images/common/nocancellation.gif" alt="청약철회" class="icon3" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9ub2NhbmNlbGxhdGlvbi5naWY=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vbm9jYW5jZWxsYXRpb24uZ2lm' designElement='image' />
<?php }?>
<?php if($TPL_V2["tax"]=='exempt'){?>
												<img src="/data/skin/responsive_diary_petit_gl/images/common/taxfree.gif" alt="비과세" class="icon4" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi90YXhmcmVlLmdpZg==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vdGF4ZnJlZS5naWY=' designElement='image' />
<?php }?>
											</div>
<?php }?>

<?php if($TPL_V3["option1"]!=null){?>
											<ul class="cart_option">
<?php if($TPL_V3["option1"]){?>
												<li><?php if($TPL_V3["title1"]){?><span class="xtle"><?php echo $TPL_V3["title1"]?></span><?php }?> <?php echo $TPL_V3["option1"]?></li>
<?php }?>
<?php if($TPL_V3["option2"]){?>
												<li><?php if($TPL_V3["title2"]){?><span class="xtle"><?php echo $TPL_V3["title2"]?></span><?php }?> <?php echo $TPL_V3["option2"]?></li>
<?php }?>
<?php if($TPL_V3["option3"]){?>
												<li><?php if($TPL_V3["title3"]){?><span class="xtle"><?php echo $TPL_V3["title3"]?></span><?php }?> <?php echo $TPL_V3["option3"]?></li>
<?php }?>
<?php if($TPL_V3["option4"]){?>
												<li><?php if($TPL_V3["title4"]){?><span class="xtle"><?php echo $TPL_V3["title4"]?></span><?php }?> <?php echo $TPL_V3["option4"]?></li>
<?php }?>
<?php if($TPL_V3["option5"]){?>
												<li><?php if($TPL_V3["title5"]){?><span class="xtle"><?php echo $TPL_V3["title5"]?></span><?php }?> <?php echo $TPL_V3["option5"]?></li>
<?php }?>
											</ul>
<?php }?>
											
											<div class="cart_quantity">
												<span class="xtle">수량</span> <?php if($TPL_V2["goods_type"]=='gift'){?>-<?php }else{?><?php echo $TPL_V3["ea"]?>개<?php }?>
												<span class="add_txt">(<?php echo get_currency_price($TPL_V3["tot_ori_price"], 2)?>)</span>
											</div>

<?php if($TPL_V3["inputs"]){?>
											<ul class="cart_inputs">
<?php if(is_array($TPL_R4=$TPL_V3["inputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
<?php if($TPL_V4["title"]){?>
												<li>
<?php if($TPL_V4["type"]=='file'){?>
<?php if($TPL_V4["title"]){?><span class="xtle v2"><?php echo $TPL_V4["title"]?></span><?php }?>
														<a href="/mypage_process/filedown?file=<?php echo $TPL_V4["value"]?>" target="actionFrame" title="다운로드" hrefOri='L215cGFnZV9wcm9jZXNzL2ZpbGVkb3duP2ZpbGU9ey4uLi52YWx1ZX0=' ><img src="/mypage_process/filedown?file=<?php echo $TPL_V4["value"]?>" class="inputed_img" alt="" designImgSrcOri='L215cGFnZV9wcm9jZXNzL2ZpbGVkb3duP2ZpbGU9ey4uLi52YWx1ZX0=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s' designImgSrc='L215cGFnZV9wcm9jZXNzL2ZpbGVkb3duP2ZpbGU9ey4uLi52YWx1ZX0=' designElement='image' /></a>
<?php }else{?>
<?php if($TPL_V4["title"]){?><span class="xtle v2"><?php echo $TPL_V4["title"]?></span><?php }?>
														<?php echo $TPL_V4["value"]?>

<?php }?>
												</li>
<?php }?>
<?php }}?>
											</ul>
<?php }?>

<?php if($TPL_V3["suboptions"]){?>
											<ul class="cart_suboptions">
<?php if(is_array($TPL_R4=$TPL_V3["suboptions"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
												<li>
<?php if($TPL_V4["suboption"]){?>
<?php if($TPL_V4["title"]){?>
													<span class="xtle v3"><?php echo $TPL_V4["title"]?></span>
<?php }?>
													<?php echo $TPL_V4["suboption"]?>

<?php }?>
													<?php echo $TPL_V4["ea"]?>개
													<span class="add_txt">(<?php echo get_currency_price($TPL_V4["price"]*$TPL_V4["ea"], 2)?>)</span>
												</li>
<?php }}?>
											</ul>
<?php }?>
										</li>
									</ul>
								</div>
								<input type="hidden" name="coupon_download[<?php echo $TPL_V2["cart_seq"]?>]" value="" />
							</div>
						</div>
					</li>
<?php }}?>
<?php }?>
<?php }}?>
				</ul>
<?php }}?>
			</div>
		</div>
<?php }?>

		<div class="goods_delivery_info Pt10 y1 hide">
			<b>기본배송비 : <?php echo get_currency_price($TPL_VAR["orders"]["basic_delivery"], 2)?></b>
<?php if($TPL_VAR["orders"]["add_delivery"]> 0){?>
			&nbsp;&nbsp;&nbsp;<b>추가배송비 : <?php echo get_currency_price($TPL_VAR["orders"]["add_delivery"], 2)?></b>
<?php }?>
<?php if($TPL_VAR["orders"]["hop_delivery"]> 0){?>
			&nbsp;&nbsp;&nbsp;<b>희망배송비 : <?php echo get_currency_price($TPL_VAR["orders"]["add_delivery"], 2)?></b>
<?php }?>
<?php if($TPL_VAR["orders"]["shipping_coupon_sale"]> 0){?>
			&nbsp;&nbsp;&nbsp;<b>배송비쿠폰할인 : (-)<?php echo get_currency_price($TPL_VAR["orders"]["shipping_coupon_sale"], 2)?></b>
<?php }?>
<?php if($TPL_VAR["orders"]["shipping_code_sale"]> 0){?>
			&nbsp;&nbsp;&nbsp;<b>배송비코드할인 : (-)<?php echo get_currency_price($TPL_VAR["orders"]["shipping_code_sale"], 2)?></b>
<?php }?>
			</span>
		</div>

		<div class="order_subsection v2">
			<h3 class="title3"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >주문자</span></h3>
			<ul class="list_01 v2">
				<li>
					<span class="name1 pointcolor2 imp"><?php echo $TPL_VAR["orders"]["order_user_name"]?></span>
				</li>
				<li>
					<span class="phone1"><?php echo $TPL_VAR["orders"]["order_cellphone"]?></span>
<?php if($TPL_VAR["orders"]["order_phone"]){?>
					<span class="gray_06">&nbsp;/&nbsp;</span>
					<span class="phone2"><?php echo $TPL_VAR["orders"]["order_phone"]?></span>
<?php }?>
				</li>
<?php if($TPL_VAR["orders"]["order_email"]){?>
				<li><span class="email1"><?php echo $TPL_VAR["orders"]["order_email"]?></span></li>
<?php }?>
				<li class="desc">
					주문자 정보로 주문 관련 정보가 문자와 이메일로 발송됩니다.<br />
<?php if(!$TPL_VAR["orders"]["member_seq"]){?>
					비회원은 이메일과 주문번호로 주문조회가 가능합니다.<br />
<?php }?>
				</li>
			</ul>

			<h3 class="title3"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >배송지</span></h3>
			<ul class="list_01 v2">
				<li>
					<span class="name1 pointcolor imp"><?php echo $TPL_VAR["orders"]["recipient_user_name"]?></span>
<?php if($TPL_VAR["is_goods"]){?>
					<span class="gray_06">(<?php echo $TPL_VAR["orders"]["nation_name_kor"]?>)</span>
<?php }?>
				</li>
<?php if($TPL_VAR["is_goods"]){?>
				<li>
<?php if($TPL_VAR["orders"]["international"]=='domestic'){?>
					[ <?php echo $TPL_VAR["orders"]["recipient_zipcode"]?> ]
<?php if($TPL_VAR["orders"]["recipient_address_type"]=='street'){?>
					<?php echo $TPL_VAR["orders"]["recipient_address_street"]?>

<?php }else{?>
					<?php echo $TPL_VAR["orders"]["recipient_address"]?>

<?php }?>
					<?php echo $TPL_VAR["orders"]["recipient_address_detail"]?><br/>
					<span class="desc">
					(
<?php if($TPL_VAR["orders"]["recipient_address_type"]=='street'){?>
						<?php echo $TPL_VAR["orders"]["recipient_address"]?>

<?php }else{?>
						<?php echo $TPL_VAR["orders"]["recipient_address_street"]?>

<?php }?>
						<?php echo $TPL_VAR["orders"]["recipient_address_detail"]?>

					)
					</span>
<?php }else{?>
					<?php echo $TPL_VAR["orders"]["international_address"]?> <?php echo $TPL_VAR["orders"]["international_town_city"]?> <?php echo $TPL_VAR["orders"]["international_county"]?> <?php echo $TPL_VAR["orders"]["international_country"]?>

<?php }?>
				</li>
<?php }?>
				<li>
					<?php echo $TPL_VAR["orders"]["recipient_cellphone"]?>

<?php if($TPL_VAR["orders"]["recipient_phone"]){?>
					<span class="gray_07">&nbsp;/&nbsp;</span> <?php echo $TPL_VAR["orders"]["recipient_phone"]?>

<?php }?>
<?php if($TPL_VAR["orders"]["recipient_email"]){?>
					<br /><?php echo $TPL_VAR["orders"]["recipient_email"]?>

<?php }?>
				</li>
<?php if($TPL_VAR["is_direct_store"]){?>
				<li>※ 매장수령 상품은 매장에서 수령하세요.</li>
<?php }?>
<?php if($TPL_VAR["is_coupon"]){?>
				<li>※ 티켓번호는 문자와 이메일로 보내드립니다.</li>
<?php }?>
<?php if($TPL_VAR["orders"]["each_memo"]||$TPL_VAR["orders"]["memo"]){?>
				<li>
<?php if($TPL_VAR["orders"]["each_memo"]){?>
<?php if(is_array($TPL_R1=$TPL_VAR["orders"]["each_memo"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<div>
						<span class="desc">(<?php echo $TPL_V1["goods_name"]?>)</span><br/>
						<span><?php echo $TPL_V1["ship_message"]?></span>
					</div>
<?php }}?>
<?php }else{?>
					<?php echo $TPL_VAR["orders"]['memo']?>

<?php }?>
				</li>
<?php }?>
			</ul>

<?php if($TPL_VAR["orders"]["clearance_unique_personal_code"]){?>
			<h3 class="title3"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >해외구매대행상품</span></h3>
			<div class="unique_personal_code">
				개인통관고유부호 : <span class="pointcolor"><?php echo $TPL_VAR["orders"]["clearance_unique_personal_code"]?></span>
			</div>
<?php }?>

		</div>
	</div>


	<div class="subpage_container v2 Pt0 Pb40 order_payment_right2">
		<div class="order_subsection v2 ">
			<h3 class="title3 Pt15"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >결제 금액</span></h3>
			<div class="order_price_total">
				<ul>
					<li class="th"><strong><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >상품금액</span></strong></li>
					<li class="td"><?php echo get_currency_price($TPL_VAR["orders"]["tot_price"], 2)?></li>
				</ul>
				<ul>
					<li class="th">
						<span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >배송비</span>&nbsp;
						<button type="button" class="btn_resp size_a gray_05" onclick="showCenterLayer('#besongDetailList')">내역</button>
					</li>
					<li class="td">
						(+) <?php echo get_currency_price($TPL_VAR["orders"]["tot_origin_shipping_cost"], 2)?>

					</li>
				</ul>
<?php if($TPL_VAR["orders"]["total_sale_price"]> 0){?>
				<ul>
					<li class="th">
						<span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >할인금액</span>&nbsp;
						<button type="button" class="btn_resp size_a gray_05" onclick="showCenterLayer('#saleDetailList')">내역</button>
					</li>
					<li class="td pointcolor3">
						(-) <?php echo get_currency_price($TPL_VAR["orders"]["total_sale_price"], 2)?>

					</li>
				</ul>
<?php }?>
<?php if($TPL_VAR["orders"]["member_seq"]){?>
<?php if($TPL_VAR["orders"]["emoney"]> 0){?>
				<ul>
					<li class="th">캐시 사용</li>
					<li class="td pointcolor3">
						(-) <?php echo get_currency_price($TPL_VAR["orders"]["emoney"], 2)?>

					</li>
				</ul>
<?php }?>
<?php if($TPL_VAR["orders"]["cash"]> 0){?>
				<ul>
					<li class="th">예치금 사용</li>
					<li class="td pointcolor3">
						(-) <?php echo get_currency_price($TPL_VAR["orders"]["cash"], 2)?>

					</li>
				</ul>
<?php }?>
<?php }?>
				<ul class="total">
					<li class="th"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >총 결제금액</span></li>
					<li class="td">
						<span class="price"><?php echo get_currency_price($TPL_VAR["orders"]["settleprice"], 2,'','<span class="settle_price">_str_price_</span>')?></span>
<?php if($TPL_VAR["orders"]["settleprice_compare"]){?>
						<span class="total_result_price"><?php echo $TPL_VAR["orders"]["settleprice_compare"]?></span>
<?php }?>
					</li>
				</ul>
			</div>

			<!-- 주의 내용 -->
			<div class="od_comp_warnning hide">
				<p class="od_sale_title2 pointcolor imp">주의</p>
				<ul class="list_dot_01">
					<li>비회원 주문의 경우, 주문번호로 주문이 조회되오니 주문번호를 꼭 기억하세요.</li>
					<li>무통장입금의 경우, <?php echo $TPL_VAR["order_config"]["cancelDuration"]?>일 이내로 입금 하셔야 하며 이후 입금되지 않은 주문은 자동으로 취소됩니다.</li>
<?php if($TPL_VAR["is_goods"]){?>
					<li>배송은 결제완료 후 지역에 따라 1~7일 가량 소요됩니다. 상품별 자세한 배송과정은 주문조회를 통하여 조회하실 수 있습니다.</li>
<?php }?>
<?php if($TPL_VAR["is_coupon"]){?>
					<li>결제 후 티켓이 즉시 발송됩니다. 상품별 티켓번호나 사용내역은 주문조회를 통하여 조회하실 수 있습니다.</li>
<?php }?>
					<li>주문의 취소 및 환불, 교환에 관한 사항은 이용안내의 내용을 참고해 주세요.</li>
				</ul>
			</div>

			<h3 class="title3"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >주문결제정보</span>&nbsp; <?php if($TPL_VAR["btn_tradeinfo"]){?><span class="btn_resp gray_06"><?php echo $TPL_VAR["btn_tradeinfo"]?></span><?php }?></h3>
			<table class="table_row_a" cellpadding="0" cellspacing="0">
				<colgroup><col width="100"><col></colgroup>
				<tbody>
					<tr>
						<th scope="row"><p>주문번호</p></th>
						<td>
							<?php echo $TPL_VAR["orders"]["order_seq"]?> &nbsp;
							<span class="Dib desc">(<?php echo date('Y-m-d H:i',strtotime($TPL_VAR["orders"]["regist_date"]))?>)</span>
						</td>
					</tr>
					<tr>
						<th scope="row"><p>주문상태</p></th>
						<td><?php echo $TPL_VAR["orders"]["step_info"]?></td>
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
							<?php echo $TPL_VAR["orders"]["payment"]?>

<?php if($TPL_VAR["orders"]["mpayment"]=='bank'){?>
							 (입금자명:<?php echo $TPL_VAR["orders"]["depositor"]?>)
<?php }elseif($TPL_VAR["orders"]["mpayment"]=='card'&&$TPL_VAR["orders"]["payment_cd"]!='MONEY'){?>
							 (<?php if($TPL_VAR["order_pg_log"]["card_name"]){?><?php echo $TPL_VAR["order_pg_log"]["card_name"]?>/<?php }?><?php if($TPL_VAR["orders"]["card_quota"]> 0){?><?php echo $TPL_VAR["orders"]["card_quota"]?>개월할부<?php }else{?>일시불<?php }?>)
<?php }?>
						</td>
					</tr>
<?php if($TPL_VAR["orders"]["virtual_account"]){?>
					<tr>
						<th scope="row"><p>입금계좌</p></th>
						<td><?php echo $TPL_VAR["orders"]["virtual_account"]?></td>
					</tr>
<?php }?>
<?php if($TPL_VAR["orders"]["bank_account"]){?>
					<tr>
						<th scope="row"><p>입금계좌</p></th>
						<td><?php echo $TPL_VAR["orders"]["bank_account"]?></td>
					</tr>
<?php }?>

<?php if($TPL_VAR["orders"]["pg"]=='payco'&&$TPL_VAR["orders"]["mpayment"]=='bank'&&$TPL_VAR["orders"]["virtual_date"]){?>
					<dl>
						<dt>입금기간</dt>
						<dd><?php echo $TPL_VAR["orders"]["virtual_date"]?></dd>
					</dl>
<?php }elseif($TPL_VAR["orders"]["deposit_yn"]=='n'&&$TPL_VAR["order_config"]["autocancel_txt"]){?>
					<tr>
						<th scope="row"><p>입금기간</p></th>
						<td><?php echo $TPL_VAR["order_config"]["autocancel_txt"]?></td>
					</tr>
<?php }?>
					<tr>
						<th scope="row"><p>결제금액</p></th>
						<td><strong><?php echo get_currency_price($TPL_VAR["orders"]["settleprice"], 2)?></strong></td>
					</tr>
<?php if($TPL_VAR["orders"]["typereceipt"]> 0){?>
					<tr>
						<th scope="row"><p>증빙자료</p></th>
						<td>
<?php if($TPL_VAR["orders"]["typereceipt"]== 1){?>
							세금계산서
<?php }elseif($TPL_VAR["orders"]["typereceipt"]== 2){?>
							현금영수증 (<?php if($TPL_VAR["orders"]["cuse"]== 0){?>개인소득공제<?php }elseif($TPL_VAR["orders"]["cuse"]== 1){?>사업자지출증빙용<?php }?>)
<?php }?>
						</td>
					</tr>
<?php }elseif(($TPL_VAR["orders"]["mpayment"]=='card'||$TPL_VAR["orders"]["receipt_view"])&&$TPL_VAR["orders"]["step"]>= 25&&$TPL_VAR["orders"]["step"]< 85){?>
					<tr>
						<th scope="row"><p>증빙자료</p></th>
						<td>
							<button type="button" class="btn_resp" onclick="receiptView('<?php echo $TPL_VAR["orders"]["pg_transaction_number"]?>', '<?php echo $TPL_VAR["pg"]["mallCode"]?>', '<?php echo $TPL_VAR["orders"]["order_seq"]?>', '<?php echo $TPL_VAR["orders"]["pg_kind"]?>', '<?php echo $TPL_VAR["orders"]["authdata"]?>', '<?php echo $TPL_VAR["orders"]["mpayment"]?>');">신용카드매출전표</button>
						</td>
					</tr>
<?php }?>
				</tbody>
			</table>

		</div>
	</div>
</div>

<div class="Pb60 C">
	<a href="/mypage/order_view?no=<?php echo $TPL_VAR["orders"]["order_seq"]?>" class="btn_resp size_c color2" hrefOri='L215cGFnZS9vcmRlcl92aWV3P25vPXtvcmRlcnMub3JkZXJfc2VxfQ==' ><span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >MY페이지 주문내역</span></a>
	<a href="/" class="btn_resp size_c color5" hrefOri='Lw==' ><span designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9vcmRlci9jb21wbGV0ZS5odG1s" >쇼핑 계속하기</span></a>
</div>


<!-- 배송비 내역 레이어 -->
<div id="besongDetailList" class="resp_layer_pop hide">
	<h4 class="title">배송비 내역</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<ul class="od_layer_title1">
				<li class="td">총 <span class="pointcolor2"><?php echo get_currency_price($TPL_VAR["orders"]["tot_origin_shipping_cost"], 2)?></span></li>
			</ul>
			<table class="table_row_a" cellpadding="0" cellspacing="0">
				<colgroup><col width="100" /><col /></colgroup>
				<tbody>
<?php if($TPL_VAR["orders"]["std_cost"]> 0){?>
					<tr>
						<th scope="row"><p>기본배송비</p></th>
						<td>
							<?php echo get_currency_price($TPL_VAR["orders"]["std_cost"], 2)?>

						</td>
					</tr>
<?php }?>
<?php if($TPL_VAR["orders"]["add_cost"]> 0){?>
					<tr>
						<th scope="row"><p>추가배송비</p></th>
						<td>
							<?php echo get_currency_price($TPL_VAR["orders"]["add_cost"], 2)?>

						</td>
					</tr>
<?php }?>
<?php if($TPL_VAR["orders"]["hop_cost"]> 0){?>
					<tr>
						<th scope="row"><p>희망배송비</p></th>
						<td>
							<?php echo get_currency_price($TPL_VAR["orders"]["hop_cost"], 2)?>

						</td>
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

<!-- 할인 내역 레이어 -->
<div id="saleDetailList" class="resp_layer_pop hide">
	<h4 class="title">할인 내역</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<ul class="od_layer_title1">
				<li class="td">총 <span class="pointcolor3"><?php echo get_currency_price($TPL_VAR["orders"]["total_sale_price"], 2)?></span></li>
			</ul>
			<table class="table_row_a" cellpadding="0" cellspacing="0">
				<colgroup><col width="100" /><col /></colgroup>
				<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["orders"]["sale_list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1['price']> 0){?>
					<tr>
						<th scope="row"><p><?php echo $TPL_V1['title']?></p></th>
						<td class="bolds ends prices">
							<?php echo get_currency_price($TPL_V1['price'], 2)?>

						</td>
					</tr>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["enuri"]> 0){?>
					<tr>
						<th scope="row"><p>에누리</p></th>
						<td>
							<?php echo get_currency_price($TPL_VAR["enuri"], 2)?>

						</td>
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

<style type="text/css">
@media only screen and (max-width:767px) {
	.subpage_wrap.order_payment { display:block; width:auto; }
	.subpage_wrap.order_payment .subpage_container { display:block; padding:10px 10px 40px; }
	.subpage_wrap.order_payment .subpage_container.v2 { display:block; padding:10px 10px 40px; }
	.subpage_wrap.order_payment .order_payment_left2 { padding-right:0; }
	.subpage_wrap.order_payment .order_payment_right2 { padding-left:0; }
}
</style>

<?php if($TPL_VAR["APP_USE"]=='f'&&$TPL_VAR["is_file_facebook"]){?>
	<!-- 구매 : 삭제하지 말아주세요 -->
<?php if(!(strstr($_SERVER["HTTP_HOST"],'.firstmall.kr')||$_SERVER["HTTP_HOST"]==$TPL_VAR["APP_DOMAIN"])){?>
		<script>
<?php if($TPL_items_1){foreach($TPL_VAR["items"] as $TPL_V1){?>
<?php if($TPL_V1["goods_type"]!='gift'){?>
				getfbopengraph('<?php echo $TPL_V1["goods_seq"]?>', 'buy', '<?php echo $TPL_VAR["config_system"]["subDomain"]?>','');
<?php }?>
<?php }}?>
		</script>
<?php }else{?>
		<script>
<?php if($TPL_items_1){foreach($TPL_VAR["items"] as $TPL_V1){?>
<?php if($TPL_V1["goods_type"]!='gift'){?>
				getfbopengraph('<?php echo $TPL_V1["goods_seq"]?>', 'buy', '<?php echo $_SERVER["HTTP_HOST"]?>','');
<?php }?>
<?php }}?>
		</script>
<?php }?>
	<!-- 삭제하지 말아주세요 -->
<?php }?>

<?php if(!(strstr($_SERVER["HTTP_HOST"],'.firstmall.kr')||$_SERVER["HTTP_HOST"]==$TPL_VAR["APP_DOMAIN"])){?>
<iframe name="snsiframe" src="//<?php echo $TPL_VAR["config_system"]["subDomain"]?>/admin/sns/subdomainfacebookck" frameborder="0" width="0" height="0"></iframe>
<?php }?>

 <script type="text/javascript">
	$(document).ready(function(){
<?php if(!$TPL_VAR["is_goods"]){?>
		$(".goods_delivery_info").hide();
<?php }?>

		$(".price_area").bind("mouseover",function(){
			$(this).parent().find(".sale_price_layer").show();
		}).bind("mouseout",function(){
			$(this).parent().find(".sale_price_layer").hide();
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

	function change_address_btn(seq){
		var str="../mypage_process/change_address?address_seq=" + seq + "&complete=y";
		$("iframe[name='actionFrame']").attr('src',str);
	}
</script>