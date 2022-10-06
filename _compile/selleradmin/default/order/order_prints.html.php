<?php /* Template_ 2.2.6 2022/05/17 12:29:23 /www/music_brother_firstmall_kr/selleradmin/skin/default/order/order_prints.html 000036582 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/orderprint.css" />
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<div class="pbreak">
	<div align="center">
	<table cellspacing="5" cellpadding="0" border="0">
		<tr>
			<td>
			<span style="text-align:center;font-size:20px;letter-spacing:-1px;font-weight:bold;padding-top:20px;">
			주문내역서
			</span>
			</td>
			<td>
<?php if($TPL_VAR["shop_logo_type"]=='img'){?>
			<img src="<?php echo $TPL_VAR["shop_logo_img"]?>" border="0" style="max-height:30px">
<?php }else{?>
			<span style="text-align:center;font-size:15px;letter-spacing:-1px;font-weight:bold;padding-top:20px;color:#747474;">
			<?php echo $TPL_VAR["shop_logo_text"]?>

			</span>
<?php }?>
			</td>
		</tr>
	</table>
	</div>
<?php if($TPL_VAR["order_barcode"]){?>
	<table style="width:97%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td align="right">
					<?php echo $TPL_V1["order"]["order_barcode"]?>

				</td>
			</tr>
	</table>
<?php }?>
	<div style="height:5px;"></div>
	<table align="center" width="98%" cellspacing="0" cellpadding="0" border="0">
	<col width="48%" />
	<col style="width:4%;" />
	<col width="48%" />
	<tr>
		<td><span class="title_print_info">주문정보</span></td>
		<td></td>
		<td><span class="title_print_info">결제정보</span></td>
	</tr>
	<tr>
		<td><div style="width:100%;border-top:1px solid #545454;height:1px;"></div></td>
		<td></td>
		<td><div style="width:100%;border-top:1px solid #545454;height:1px;"></div></td>
	</tr>
	<tr>
		<td>
			<table width="100%" class="order_print_info" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<th>주문번호</th>
					<td><?php echo $TPL_V1["order"]["order_seq"]?></td>
				</tr>
				<tr>
					<th>주문일자</th>
					<td><?php echo $TPL_V1["order"]["regist_date"]?></td>
				</tr>
				<tr>
					<th>주문고객</th>
					<td><?php echo $TPL_V1["order"]["order_user_name"]?></td>
				</tr>
				<tr>
					<th>전화</th>
					<td><?php echo $TPL_V1["order"]["order_phone"]?></td>
				</tr>
				<tr>
					<th>휴대전화</th>
					<td><?php echo $TPL_V1["order"]["order_cellphone"]?></td>
				</tr>
				<tr>
					<th>이메일</th>
					<td><?php echo $TPL_V1["order"]["order_email"]?></td>
				</tr>
			</table>
		</td>
		<td></td>
		<td valign="top">
			<table width="100%" class="order_print_info" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<th>상품금액</th>
					<td>
<?php if($TPL_V1["order"]["deposit_yn"]!='y'){?><span>(입금전)</span><?php }?>
					<?php echo get_currency_price($TPL_V1["items_tot"]["price"], 4)?></td>
				</tr>
				<tr>
					<th>배송비</th>
					<td><?php echo get_currency_price($TPL_V1["shipping_tot"]["goods_shipping_cost"]+$TPL_V1["shipping_tot"]["shipping_cost"], 4)?></td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
	<div style="height:5px"></div>
	<table align="center" width="98%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td><span class="title_print_info">배송정보</span></td>
	</tr>
	</table>
	<table width="98%"  class="delivery_goods_print_info"  cellspacing="0" cellpadding="0" border="0" align="center">
	<col width="10%"></col>
	<col width="20%"></col>
	<col width="10%"l></col>
	<col width="20%"></col>
	<col width="10%"></col>
	<col width="20%"></col>
	<tr>
		<th>받는고객</th>
		<td><?php echo $TPL_V1["order"]["recipient_user_name"]?></td>
		<th>연락처1</th>
		<td>
			<?php echo $TPL_V1["order"]["recipient_phone"]?>

		</td>
		<th>연락처2</th>
		<td>
		<?php echo $TPL_V1["order"]["recipient_cellphone"]?>

<?php if($TPL_V1["order"]["recipient_email"]&&$TPL_V1["order"]["recipient_cellphone"]){?><br/><?php }?>
		<?php echo $TPL_V1["order"]["recipient_email"]?>

		</td>
	</tr>
	<tr>
		<th>배송지 주소</th>
		<td colspan="5">
<?php if($TPL_V1["order"]["international"]=="international"){?>
			<?php echo $TPL_V1["order"]["international_address"]?> 	<?php echo $TPL_V1["order"]["international_town_city"]?> <?php echo $TPL_V1["order"]["international_county"]?> <?php echo $TPL_V1["order"]["international_postcode"]?> <?php echo $TPL_V1["order"]["international_country"]?>

<?php }else{?>
<?php if($TPL_V1["order"]["recipient_address_type"]!='street'){?> (구) <?php }?>
			(<?php echo $TPL_V1["order"]["recipient_zipcode"]?>)
<?php if($TPL_V1["order"]["recipient_address_type"]=='street'){?><?php echo $TPL_V1["order"]["recipient_address_street"]?><?php }else{?><?php echo $TPL_V1["order"]["recipient_address"]?><?php }?> <?php echo $TPL_V1["order"]["recipient_address_detail"]?>

<?php }?>
		</td>
	</tr>
	<tr>
		<th>배송 메시지</th>
		<td colspan="5"><?php echo $TPL_V1["order"]["memo"]?></td>
	</tr>
	</table>

	<div style="height:10px"></div>
	<table align="center" width="98%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="left"><span class="title_print_info">주문상품</span>(<?php echo number_format($TPL_V1["order"]["total_type"])?>종-총 <?php echo number_format($TPL_V1["items_tot"]["ea"])?>개)</td>
	</tr>
	</table>
<?php if(is_array($TPL_R2=$TPL_V1["shipping_group_items"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["couopn_items"]){?>
	<table class="delivery_goods_print_info" align="center" width="98%" cellspacing="0" cellpadding="0" border="0">
		<col />
		<col width="35" />
		<col width="70" />
		<col width="70" />
		<col width="70" />
		<col width="50" />
		<col width="70" />
		<col width="35" />

		<tr>
			<th>티켓명</th>
			<th>주문</th>
			<th>판매가</th>
			<th>할인</th>
			<th>할인가</th>
			<th>적립</th>
			<th>배송</th>
			<th>취소</th>

		</tr>
<?php if(is_array($TPL_R3=$TPL_V2["couopn_items"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
<?php if(is_array($TPL_R4=$TPL_V3["options"])&&!empty($TPL_R4)){$TPL_I4=-1;foreach($TPL_R4 as $TPL_V4){$TPL_I4++;?>
		<tr>
			<td>
			<table border="0" cellpadding="0" cellspacing="0">
					<tr>
<?php if($TPL_VAR["order_goods_image"]){?>
						<td style="border:0px">
							<img src="<?php echo $TPL_V3["image"]?>" style="max-width:50px;max-height:50px;">
						</td>
<?php }?>
						<td style="font-size:11px;border:0px;">
							<?php echo $TPL_V3["goods_name"]?>

<?php if($TPL_V4["option1"]!=null){?>
							<div style="padding:2px 0px 0px 10px;">
								<?php echo $TPL_V4["title1"]?>:<?php echo $TPL_V4["option1"]?>

<?php if($TPL_V4["option2"]!=null){?> <?php echo $TPL_V4["title2"]?>:<?php echo $TPL_V4["option2"]?><?php }?>
<?php if($TPL_V4["option3"]!=null){?> <?php echo $TPL_V4["title3"]?>:<?php echo $TPL_V4["option3"]?><?php }?>
<?php if($TPL_V4["option4"]!=null){?> <?php echo $TPL_V4["title4"]?>:<?php echo $TPL_V4["option4"]?><?php }?>
<?php if($TPL_V4["option5"]!=null){?> <?php echo $TPL_V4["title5"]?>:<?php echo $TPL_V4["option5"]?><?php }?>
							</div>
<?php }?>
<?php if($TPL_VAR["order_addinfo"]){?>
<?php if(($TPL_VAR["order_warehouse"]&&$TPL_V4["whinfo"]["wh_seq"]> 0)||($TPL_VAR["order_goods_code"]&&$TPL_V4["goods_code"])){?>
							<div style="padding:5px;margin:2px 10px 5px 0;border:1px solid #c5c5c5;background-color:#fff;">
							<ul>
<?php if($TPL_VAR["order_warehouse"]&&$TPL_V4["whinfo"]["wh_seq"]> 0){?>
								<li>
<?php if($TPL_V4["whinfo"]["wh_name"]){?>
								<?php echo $TPL_V4["whinfo"]["wh_name"]?> (<?php echo $TPL_V4["whinfo"]["location_code"]?>) : <?php echo number_format($TPL_V4["whinfo"]["ea"])?>(<?php echo number_format($TPL_V4["whinfo"]["badea"])?>)
<?php }else{?>
								해당 창고에 입고된 내역이 없습니다.
<?php }?>
								</li>
<?php }?>
<?php if($TPL_VAR["order_goods_code"]&&$TPL_V4["goods_code"]){?>
								<li><?php echo $TPL_V4["goods_code"]?></li>
<?php }?>
							</ul>
							</div>
<?php }?>
<?php }?>
<?php if($TPL_VAR["order_goods_barcode"]&&$TPL_V4["goods_code"]){?>
							<div style="padding:2px 0px 0px 0px;">
								<?php echo $TPL_V4["barcode_image"]?>

							</div>
<?php }?>
<?php if($TPL_V4["inputs"]){?>
							<div style="padding:2px 0px 0px 10px;">
<?php if(is_array($TPL_R5=$TPL_V4["inputs"])&&!empty($TPL_R5)){foreach($TPL_R5 as $TPL_V5){?>
<?php if($TPL_V5["value"]){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V5["title"]){?><?php echo $TPL_V5["title"]?>:<?php }?>
<?php if($TPL_V5["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V5["value"]?>" target="actionFrame"><?php echo $TPL_V5["value"]?></a>
<?php }else{?><?php echo $TPL_V5["value"]?><?php }?>
								</div>
<?php }?>
<?php }}?>
							</div>
<?php }?>
						</td>
					</tr>
				</table>
			</td>
			<td class="right"><?php echo $TPL_V4["ea"]?></td>
			<td class="right"><?php echo get_currency_price($TPL_V4["out_price"], 4)?></td>
			<td class="right"><?php echo get_currency_price($TPL_V4["out_price"]-$TPL_V4["out_sale_price"], 4)?></td>
			<td class="right">
				<?php echo get_currency_price($TPL_V4["out_sale_price"], 4)?>

				<br/>(<?php echo get_currency_price($TPL_V4["sale_price"], 4)?>)
			</td>
			<td class="right">
				<?php echo get_currency_price($TPL_V4["out_reserve"], 4,'','','unit-money')?>

<?php if($TPL_V4["out_point"]){?>
				<br/><?php echo get_currency_price($TPL_V4["out_point"])?><span class="unit-money">P</span>
<?php }?>
			</td>
<?php if($TPL_I3== 0&&$TPL_I4== 0){?>
			<td rowspan="<?php echo $TPL_V2["rowspan"]?>" class="right">
				<div>
<?php if($TPL_V2["shipping"]["provider_seq"]== 1){?>본사<?php }else{?><?php echo $TPL_V2["shipping"]["provider_name"]?><?php }?>
				</div>
				<div>
					티켓
				</div>
			</td>
<?php }?>
			<td class="right"><?php echo $TPL_V4["step85"]?></td>

		</tr>

<?php if($TPL_V4["package_yn"]=='y'){?>
<?php if(is_array($TPL_R5=$TPL_V4["packages"])&&!empty($TPL_R5)){$TPL_I5=-1;foreach($TPL_R5 as $TPL_V5){$TPL_I5++;?>
		<tr>
			<td style="padding-left:45px;">
				<table border="0" cellpadding="0" cellspacing="0" style="border:0px">
					<tr>
<?php if($TPL_VAR["order_goods_image"]){?>
						<td style="width:50px;border:0px;text-align:center">
							<img src="<?php echo $TPL_V5["image"]?>" style="max-width:50px;max-height:50px;">
						</td>
<?php }?>
						<td style="font-size:11px;border:0px;">
							<span>[실제상품 <?php echo $TPL_I5+ 1?>]</span>
							<?php echo $TPL_V5["goods_name"]?>

<?php if($TPL_V5["option1"]!=null){?>
							<div style="padding:2px 0px 0px 0px;">
								- <?php echo $TPL_V5["title1"]?>:<?php echo $TPL_V5["option1"]?>

<?php if($TPL_V5["option2"]!=null){?> <?php echo $TPL_V5["title2"]?>:<?php echo $TPL_V5["option2"]?><?php }?>
<?php if($TPL_V5["option3"]!=null){?> <?php echo $TPL_V5["title3"]?>:<?php echo $TPL_V5["option3"]?><?php }?>
<?php if($TPL_V5["option4"]!=null){?> <?php echo $TPL_V5["title4"]?>:<?php echo $TPL_V5["option4"]?><?php }?>
<?php if($TPL_V5["option5"]!=null){?> <?php echo $TPL_V5["title5"]?>:<?php echo $TPL_V5["option5"]?><?php }?>
							</div>
<?php }?>
<?php if($TPL_VAR["order_addinfo"]){?>
<?php if(($TPL_VAR["order_warehouse"]&&$TPL_V5["whinfo"]["wh_seq"]> 0)||($TPL_VAR["order_goods_code"]&&$TPL_V5["goods_code"])){?>
							<div style="padding:5px;margin:2px 10px 5px 0;border:1px solid #c5c5c5;background-color:#fff;">
							<ul>
<?php if($TPL_VAR["order_warehouse"]&&$TPL_V5["whinfo"]["wh_seq"]> 0){?>
								<li>
<?php if($TPL_V5["whinfo"]["wh_name"]){?>
								<?php echo $TPL_V5["whinfo"]["wh_name"]?> (<?php echo $TPL_V5["whinfo"]["location_code"]?>) : <?php echo number_format($TPL_V5["whinfo"]["ea"])?>(<?php echo number_format($TPL_V5["whinfo"]["badea"])?>)
<?php }else{?>
								해당 창고에 입고된 내역이 없습니다.
<?php }?>
								</li>
<?php }?>
<?php if($TPL_VAR["order_goods_code"]&&$TPL_V5["goods_code"]){?>
								<li><?php echo $TPL_V5["goods_code"]?></li>
<?php }?>
							</ul>
							</div>
<?php }?>
<?php }?>
<?php if($TPL_VAR["order_goods_barcode"]&&$TPL_V5["goods_code"]){?>
							<div style="padding:2px 0px 0px 0px;">
								<?php echo $TPL_V5["barcode_image"]?>

							</div>
<?php }?>
<?php if($TPL_V5["inputs"]){?>
							<div style="padding:2px 0px 0px 0px;">
<?php if(is_array($TPL_R6=$TPL_V5["inputs"])&&!empty($TPL_R6)){foreach($TPL_R6 as $TPL_V6){?>
<?php if($TPL_V6["value"]){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
									- <?php if($TPL_V6["title"]){?><?php echo $TPL_V6["title"]?>:<?php }?>
<?php if($TPL_V6["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V5["value"]?>" target="actionFrame"><?php echo $TPL_V6["value"]?></a>
<?php }else{?><?php echo $TPL_V6["value"]?><?php }?>
								</div>
<?php }?>
<?php }}?>
							</div>
<?php }?>
						</td>
					</tr>
				</table>
			</td>
			<td class="right">
				<?php echo number_format($TPL_V5["unit_ea"]*$TPL_V4["ea"])?>

			</td>
			<td class="right">-</td>
			<td class="right">-</td>
			<td class="right">
				-
			</td>
			<td class="right">
				-
			</td>
			<td class="right">
				-
			</td>
		</tr>
<?php }}?>
<?php }?>

<?php }}?>
<?php }}?>
	</table>
<?php }?>
<?php }}?>
<?php if(is_array($TPL_R2=$TPL_V1["shipping_group_items"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["goods_items"]){?>
	<div style="height:3px"></div>
	<table class="delivery_goods_print_info" align="center" width="98%" cellspacing="0" cellpadding="0" border="0">
		<col />
		<col width="35" />
		<col width="70" />
		<col width="70" />
		<col width="70" />
		<col width="50" />
		<col width="70" />
		<col width="35" />
		<col width="35" />
		<tr>
			<th>상품명</th>
			<th>주문</th>
			<th>판매가</th>
			<th>할인</th>
			<th>할인가(단가)</th>
			<th>적립</th>
			<th>배송</th>
			<th>취소</th>
			<th>주문 접수</th>
		</tr>
<?php if(is_array($TPL_R3=$TPL_V2["goods_items"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
<?php if(is_array($TPL_R4=$TPL_V3["options"])&&!empty($TPL_R4)){$TPL_I4=-1;foreach($TPL_R4 as $TPL_V4){$TPL_I4++;?>
		<tr>
			<td>
				<table border="0" cellpadding="0" cellspacing="0" style="border:0px">
					<tr>
<?php if($TPL_VAR["order_goods_image"]){?>
						<td style="width:50px;border:0px;text-align:center">
							<img src="<?php echo $TPL_V3["image"]?>" style="max-width:50px;max-height:50px;">
						</td>
<?php }?>
						<td style="font-size:11px;border:0px;">
							<?php echo $TPL_V3["goods_name"]?>

<?php if($TPL_V4["option1"]!=null){?>
							<div style="padding:2px 0px 0px 0px;">
								- <?php echo $TPL_V4["title1"]?>:<?php echo $TPL_V4["option1"]?>

<?php if($TPL_V4["option2"]!=null){?> <?php echo $TPL_V4["title2"]?>:<?php echo $TPL_V4["option2"]?><?php }?>
<?php if($TPL_V4["option3"]!=null){?> <?php echo $TPL_V4["title3"]?>:<?php echo $TPL_V4["option3"]?><?php }?>
<?php if($TPL_V4["option4"]!=null){?> <?php echo $TPL_V4["title4"]?>:<?php echo $TPL_V4["option4"]?><?php }?>
<?php if($TPL_V4["option5"]!=null){?> <?php echo $TPL_V4["title5"]?>:<?php echo $TPL_V4["option5"]?><?php }?>
							</div>
<?php }?>
<?php if($TPL_VAR["order_addinfo"]){?>
<?php if((($TPL_VAR["order_warehouse"]&&$TPL_V4["whinfo"]["wh_seq"]> 0)||($TPL_VAR["order_goods_code"]&&$TPL_V4["goods_code"]))&&$TPL_V4["package_yn"]!='y'){?>
							<div style="padding:5px;margin:2px 10px 5px 0;border:1px solid #c5c5c5;background-color:#fff;">
							<ul>
<?php if($TPL_VAR["order_warehouse"]&&$TPL_V4["whinfo"]["wh_seq"]> 0){?>
								<li>
<?php if($TPL_V4["whinfo"]["wh_name"]){?>
								<?php echo $TPL_V4["whinfo"]["wh_name"]?> (<?php echo $TPL_V4["whinfo"]["location_code"]?>) : <?php echo number_format($TPL_V4["whinfo"]["ea"])?>(<?php echo number_format($TPL_V4["whinfo"]["badea"])?>)
<?php }else{?>
								해당 창고에 입고된 내역이 없습니다.
<?php }?>
								</li>
<?php }?>
<?php if($TPL_VAR["order_goods_code"]&&$TPL_V4["goods_code"]){?>
								<li><?php echo $TPL_V4["goods_code"]?></li>
<?php }?>
							</ul>
							</div>
<?php }?>
<?php }?>
<?php if($TPL_VAR["order_goods_barcode"]&&$TPL_V4["goods_code"]){?>
							<div style="padding:2px 0px 0px 0px;">
								<?php echo $TPL_V4["barcode_image"]?>

							</div>
<?php }?>
<?php if($TPL_V4["inputs"]){?>
							<div style="padding:2px 0px 0px 10px;">
<?php if(is_array($TPL_R5=$TPL_V4["inputs"])&&!empty($TPL_R5)){foreach($TPL_R5 as $TPL_V5){?>
<?php if($TPL_V5["value"]){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
									- <?php if($TPL_V5["title"]){?><?php echo $TPL_V5["title"]?>:<?php }?>
<?php if($TPL_V5["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V5["value"]?>" target="actionFrame"><?php echo $TPL_V5["value"]?></a>
<?php }else{?><?php echo $TPL_V5["value"]?><?php }?>
								</div>
<?php }?>
<?php }}?>
							</div>
<?php }?>
						</td>
					</tr>
				</table>
			</td>
			<td class="right"><?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V4["ea"]?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?></td>
			<td class="right"><?php echo get_currency_price($TPL_V4["out_price"], 4)?></td>
			<td class="right">
				<?php echo get_currency_price($TPL_V4["out_price"]-$TPL_V4["out_sale_price"], 4)?>

			</td>
			<td class="right">
				<?php echo get_currency_price($TPL_V4["out_sale_price"], 4)?>

				<br/>(<?php echo get_currency_price($TPL_V4["sale_price"], 4)?>)
			</td>
			<td class="right">
				<?php echo get_currency_price($TPL_V4["out_reserve"], 4,'','','unit-money')?>

<?php if($TPL_V4["out_point"]){?>
				<br/><?php echo get_currency_price($TPL_V4["out_point"])?><span class="unit-money">P</span>
<?php }?>
			</td>

<?php if($TPL_I3== 0&&$TPL_I4== 0){?>
			<td rowspan="<?php echo $TPL_V2["rowspan"]?>" class="right">
				<div class="blue">
<?php if($TPL_V2["shipping"]["provider_seq"]== 1){?>
					본사
<?php }else{?>
					<?php echo $TPL_V2["shipping"]["provider_name"]?>

<?php }?>
				</div>

<?php if(preg_match('/gift/',$TPL_V2["shipping"]["shipping_group"])){?>
						사은품배송
<?php }else{?>
				<div>
					<span><?php if($TPL_V2["shipping"]["shipping_method_name"]=='쿠폰'){?>티켓<?php }else{?><?php echo $TPL_V2["shipping"]["shipping_set_name"]?><?php }?></span>
<?php if($TPL_VAR["orders"]["international_country"]){?><span class="pdl5 lsp-1"><?php echo $TPL_VAR["orders"]["international_country"]?></span><?php }?>
				</div>
<?php if($TPL_V2["shipping"]["shipping_set_code"]=='direct_store'){?>
				<div class="lsp-1">수령매장 : <?php echo $TPL_V2["shipping"]["shipping_store_name"]?></div>
<?php }else{?>
				<div >
					<span class="bold">
<?php if($TPL_V2["shipping"]["shipping_cost"]> 0){?>
						<?php echo get_currency_price($TPL_V2["shipping"]["shipping_cost"], 4)?>

<?php }elseif($TPL_V2["shipping"]["postpaid"]> 0){?>
						<?php echo get_currency_price($TPL_V2["shipping"]["postpaid"], 4)?>

<?php }else{?>
						무료
<?php }?>
					</span>
<?php if($TPL_V2["shipping"]["shipping_cost"]> 0||$TPL_V2["shipping"]["postpaid"]> 0){?>
<?php if($TPL_V2["shipping"]["shipping_pay_type"]){?><span class="lsp-1">(<?php echo $TPL_V2["shipping"]["shipping_pay_type"]?>)</span><?php }?>
<?php }?> 
				</div>
<?php }?>
<?php if($TPL_V2["shipping"]["reserve_sdate"]){?>
				<div>예약배송일 : <?php echo $TPL_V2["shipping"]["reserve_sdate"]?></div>
<?php }elseif($TPL_V2["shipping"]["shipping_hop_date"]){?>
				<div>희망배송일 : <?php echo $TPL_V2["shipping"]["shipping_hop_date"]?></div>
<?php }?>
<?php }?>

<?php if($TPL_V2["shipping"]["shipping_coupon_sale"]> 0){?>
				<div>-<?php echo get_currency_price($TPL_V2["shipping"]["shipping_coupon_sale"], 4)?> 쿠폰</div>
<?php }?>
<?php if($TPL_V2["shipping"]["shipping_promotion_code_sale"]> 0){?>
				<div>-<?php echo get_currency_price($TPL_V2["shipping"]["shipping_promotion_code_sale"], 4)?> 코드</div>
<?php }?>
			</td>
<?php }?>
			<td class="right"><?php echo $TPL_V4["step85"]?></td>
			<td class="right"><?php echo $TPL_V4["mstep"]?></td>
		</tr>

<?php if($TPL_V4["package_yn"]=='y'&&$TPL_VAR["order_package"]){?>
<?php if(is_array($TPL_R5=$TPL_V4["packages"])&&!empty($TPL_R5)){$TPL_I5=-1;foreach($TPL_R5 as $TPL_V5){$TPL_I5++;?>
		<tr>
			<td style="padding-left:45px;">
				<table border="0" cellpadding="0" cellspacing="0" style="border:0px">
					<tr>
<?php if($TPL_VAR["order_goods_image"]){?>
						<td style="width:50px;border:0px;text-align:center">
							<img src="<?php echo $TPL_V5["image"]?>" style="max-width:50px;max-height:50px;">
						</td>
<?php }?>
						<td style="font-size:11px;border:0px;">
							<span>[실제상품 <?php echo $TPL_I5+ 1?>]</span>
							<?php echo $TPL_V5["goods_name"]?>

<?php if($TPL_V5["option1"]!=null){?>
							<div style="padding:2px 0px 0px 0px;">
								- <?php echo $TPL_V5["title1"]?>:<?php echo $TPL_V5["option1"]?>

<?php if($TPL_V5["option2"]!=null){?> <?php echo $TPL_V5["title2"]?>:<?php echo $TPL_V5["option2"]?><?php }?>
<?php if($TPL_V5["option3"]!=null){?> <?php echo $TPL_V5["title3"]?>:<?php echo $TPL_V5["option3"]?><?php }?>
<?php if($TPL_V5["option4"]!=null){?> <?php echo $TPL_V5["title4"]?>:<?php echo $TPL_V5["option4"]?><?php }?>
<?php if($TPL_V5["option5"]!=null){?> <?php echo $TPL_V5["title5"]?>:<?php echo $TPL_V5["option5"]?><?php }?>
							</div>
<?php }?>
<?php if($TPL_VAR["order_addinfo"]){?>
<?php if(($TPL_VAR["order_warehouse"]&&$TPL_V5["whinfo"]["wh_seq"]> 0)||($TPL_VAR["order_goods_code"]&&$TPL_V5["goods_code"])){?>
							<div style="padding:5px;margin:2px 10px 5px 0;border:1px solid #c5c5c5;background-color:#fff;">
							<ul>
<?php if($TPL_VAR["order_warehouse"]&&$TPL_V5["whinfo"]["wh_seq"]> 0){?>
								<li>
<?php if($TPL_V5["whinfo"]["wh_name"]){?>
								<?php echo $TPL_V5["whinfo"]["wh_name"]?> (<?php echo $TPL_V5["whinfo"]["location_code"]?>) : <?php echo number_format($TPL_V5["whinfo"]["ea"])?>(<?php echo number_format($TPL_V5["whinfo"]["badea"])?>)
<?php }else{?>
								해당 창고에 입고된 내역이 없습니다.
<?php }?>
								</li>
<?php }?>
<?php if($TPL_VAR["order_goods_code"]&&$TPL_V5["goods_code"]){?>
								<li><?php echo $TPL_V5["goods_code"]?></li>
<?php }?>
							</ul>
							</div>
<?php }?>
<?php }?>
<?php if($TPL_VAR["order_goods_barcode"]&&$TPL_V5["goods_code"]){?>
							<div style="padding:2px 0px 0px 0px;">
								<?php echo $TPL_V5["barcode_image"]?>

							</div>
<?php }?>
<?php if($TPL_V5["inputs"]){?>
							<div style="padding:2px 0px 0px 0px;">
<?php if(is_array($TPL_R6=$TPL_V5["inputs"])&&!empty($TPL_R6)){foreach($TPL_R6 as $TPL_V6){?>
<?php if($TPL_V6["value"]){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
									- <?php if($TPL_V6["title"]){?><?php echo $TPL_V6["title"]?>:<?php }?>
<?php if($TPL_V6["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V5["value"]?>" target="actionFrame"><?php echo $TPL_V6["value"]?></a>
<?php }else{?><?php echo $TPL_V6["value"]?><?php }?>
								</div>
<?php }?>
<?php }}?>
							</div>
<?php }?>
						</td>
					</tr>
				</table>
			</td>
			<td class="right">
				<?php echo number_format($TPL_V5["unit_ea"]*$TPL_V4["ea"])?>

			</td>
			<td class="right">-</td>
			<td class="right">-</td>
			<td class="right">
				-
			</td>
			<td class="right">
				-
			</td>
			<td class="right">
				-
			</td>
			<td class="right">
				-
			</td>
		</tr>
<?php }}?>
<?php }?>

<?php if(is_array($TPL_R5=$TPL_V4["suboptions"])&&!empty($TPL_R5)){foreach($TPL_R5 as $TPL_V5){?>
		<tr>
			<td style="padding-left:20px;">
				<table border="0" cellpadding="0" cellspacing="0" style="border:0px">
					<tr>
<?php if($TPL_VAR["order_goods_image"]){?>
						<td style="width:50px;border:0px"></td>
<?php }?>
						<td style="border:0px">
						<div style="padding-left:10px;">
						<?php echo $TPL_V5["title"]?> : <?php echo $TPL_V5["suboption"]?>

						</div>
<?php if($TPL_VAR["order_addinfo"]){?>
<?php if((($TPL_VAR["order_warehouse"]&&$TPL_V5["whinfo"]["wh_seq"]> 0)||($TPL_VAR["order_goods_code"]&&$TPL_V5["goods_code"]))&&$TPL_V5["package_yn"]!='y'){?>
						<div style="padding:5px;margin:2px 10px 5px 0;border:1px solid #c5c5c5;background-color:#fff;">
						<ul>
<?php if($TPL_VAR["order_warehouse"]&&$TPL_V5["whinfo"]["wh_seq"]> 0){?>
							<li>
<?php if($TPL_V5["whinfo"]["wh_name"]){?>
							<?php echo $TPL_V5["whinfo"]["wh_name"]?> (<?php echo $TPL_V5["whinfo"]["location_code"]?>) : <?php echo number_format($TPL_V5["whinfo"]["ea"])?>(<?php echo number_format($TPL_V5["whinfo"]["badea"])?>)
<?php }else{?>
							해당 창고에 입고된 내역이 없습니다.
<?php }?>
							</li>
<?php }?>
<?php if($TPL_VAR["order_goods_code"]&&$TPL_V5["goods_code"]){?>
							<li><?php echo $TPL_V5["goods_code"]?></li>
<?php }?>
						</ul>
						</div>
<?php }?>
<?php }?>
<?php if($TPL_VAR["order_goods_barcode"]&&$TPL_V5["goods_code"]){?>
						<div style="padding:2px 0px 0px 0px;">
							<?php echo $TPL_V5["barcode_image"]?>

						</div>
<?php }?>
						</td>
					</tr>
				</table>
			</td>
			<td class="right"><?php if($TPL_V5["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V5["ea"]?><?php if($TPL_V5["package_yn"]=='y'){?>]<?php }?></td>
			<td class="right"><?php echo get_currency_price($TPL_V5["out_price"], 4)?></td>
			<td class="right">
				<?php echo get_currency_price($TPL_V5["out_price"]-$TPL_V5["out_sale_price"], 4)?>

			</td>
			<td class="right">
				<?php echo get_currency_price($TPL_V5["out_sale_price"], 4)?>

				<br/>(<?php echo get_currency_price($TPL_V5["sale_price"], 4)?>)
			</td>
			<td class="right">
				<?php echo get_currency_price($TPL_V5["out_reserve"], 4,'','','unit-money')?>

<?php if($TPL_V5["out_point"]){?>
				<br/><?php echo get_currency_price($TPL_V5["out_point"])?><span class="unit-money">P</span>
<?php }?>
			</td>
			<td class="right"><?php echo $TPL_V5["step85"]?></td>
			<td><?php echo $TPL_V5["mstep"]?></td>
		</tr>

<?php if($TPL_V5["package_yn"]=='y'&&$TPL_VAR["order_sub_relation"]){?>
<?php if(is_array($TPL_R6=$TPL_V5["packages"])&&!empty($TPL_R6)){foreach($TPL_R6 as $TPL_V6){?>
		<tr>
			<td style="padding-left:65px;">
				<table border="0" cellpadding="0" cellspacing="0" style="border:0px">
					<tr>
<?php if($TPL_VAR["order_goods_image"]){?>
						<td style="width:50px;border:0px;text-align:center">
							<img src="<?php echo $TPL_V6["image"]?>" style="max-width:50px;max-height:50px;">
						</td>
<?php }?>
						<td style="font-size:11px;border:0px;">
							<span>[실제상품]</span>
							<?php echo $TPL_V6["goods_name"]?>

<?php if($TPL_V6["option1"]!=null){?>
							<div style="padding:2px 0px 0px 0px;">
								- <?php echo $TPL_V6["title1"]?>:<?php echo $TPL_V6["option1"]?>

<?php if($TPL_V6["option2"]!=null){?> <?php echo $TPL_V6["title2"]?>:<?php echo $TPL_V6["option2"]?><?php }?>
<?php if($TPL_V6["option3"]!=null){?> <?php echo $TPL_V6["title3"]?>:<?php echo $TPL_V6["option3"]?><?php }?>
<?php if($TPL_V6["option4"]!=null){?> <?php echo $TPL_V6["title4"]?>:<?php echo $TPL_V6["option4"]?><?php }?>
<?php if($TPL_V6["option5"]!=null){?> <?php echo $TPL_V6["title5"]?>:<?php echo $TPL_V6["option5"]?><?php }?>
							</div>
<?php }?>
<?php if($TPL_VAR["order_addinfo"]){?>
<?php if(($TPL_VAR["order_warehouse"]&&$TPL_V6["whinfo"]["wh_seq"]> 0)||($TPL_VAR["order_goods_code"]&&$TPL_V6["goods_code"])){?>
							<div style="padding:5px;margin:2px 10px 5px 0;border:1px solid #c5c5c5;background-color:#fff;">
							<ul>
<?php if($TPL_VAR["order_warehouse"]&&$TPL_V6["whinfo"]["wh_seq"]> 0){?>
								<li>
<?php if($TPL_V6["whinfo"]["wh_name"]){?>
								<?php echo $TPL_V6["whinfo"]["wh_name"]?> (<?php echo $TPL_V6["whinfo"]["location_code"]?>) : <?php echo number_format($TPL_V6["whinfo"]["ea"])?>(<?php echo number_format($TPL_V6["whinfo"]["badea"])?>)
<?php }else{?>
								해당 창고에 입고된 내역이 없습니다.
<?php }?>
								</li>
<?php }?>
<?php if($TPL_VAR["order_goods_code"]&&$TPL_V6["goods_code"]){?>
								<li><?php echo $TPL_V6["goods_code"]?></li>
<?php }?>
							</ul>
							</div>
<?php }?>
<?php }?>
<?php if($TPL_VAR["order_goods_barcode"]&&$TPL_V6["goods_code"]){?>
							<div style="padding:2px 0px 0px 0px;">
								<?php echo $TPL_V6["barcode_image"]?>

							</div>
<?php }?>
<?php if($TPL_V6["inputs"]){?>
							<div style="padding:2px 0px 0px 0px;">
<?php if(is_array($TPL_R7=$TPL_V6["inputs"])&&!empty($TPL_R7)){foreach($TPL_R7 as $TPL_V7){?>
<?php if($TPL_V7["value"]){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
									- <?php if($TPL_V7["title"]){?><?php echo $TPL_V7["title"]?>:<?php }?>
<?php if($TPL_V7["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V5["value"]?>" target="actionFrame"><?php echo $TPL_V7["value"]?></a>
<?php }else{?><?php echo $TPL_V7["value"]?><?php }?>
								</div>
<?php }?>
<?php }}?>
							</div>
<?php }?>
						</td>
					</tr>
				</table>
			</td>
			<td class="right">
				<?php echo number_format($TPL_V6["unit_ea"]*$TPL_V5["ea"])?>

			</td>
			<td class="right">-</td>
			<td class="right">-</td>
			<td class="right">
				-
			</td>
			<td class="right">
				-
			</td>
			<td class="right">
				-
			</td>
			<td class="right">
				-
			</td>
		</tr>
<?php }}?>
<?php }?>

<?php }}?>
<?php }}?>
<?php }}?>
	</table>
<?php }?>
<?php }}?>
	<div style="height:5px;"></div>

	<table cellpadding="0" cellspacing="0" border="0" align="center" width="696">
	<colgroup><col width="17%">
	<col>
	<col width="17%">
	<col>
	<col width="17%">
	<col>
	<col width="17%">
	<col>
	<col width="17%">
	</colgroup><tbody><tr>
		<td style="text-align:right;font-size:12px;">
			<span>
			총 상품금액
			</span>
		</td>
		<td style="text-align:center;font-size:12px;"><span>+</span></td>
		<td style="text-align:right;font-size:12px;">
			<span>
				배송비
				<span><?php echo get_currency_price($TPL_V1["shipping_tot"]["goods_shipping_cost"]+$TPL_V1["shipping_tot"]["shipping_cost"], 2)?></span>
			</span>
		</td>
		<td style="text-align:center;font-size:12px;"><span>-</span></td>
		<td style="text-align:right;font-size:12px;">
			<span>
				할인
				<span><?php echo get_currency_price($TPL_V1["items_tot"]["event_sale"]+$TPL_V1["items_tot"]["multi_sale"]+$TPL_V1["items_tot"]["coupon_sale"]+$TPL_V1["items_tot"]["member_sale"]+$TPL_V1["items_tot"]["fblike_sale"]+$TPL_V1["items_tot"]["mobile_sale"]+$TPL_V1["items_tot"]["promotion_code_sale"]+$TPL_V1["items_tot"]["referer_sale"]+$TPL_V1["shipping_tot"]["shipping_coupon_sale"]+$TPL_V1["shipping_tot"]["shipping_promotion_code_sale"]+$TPL_V1["order"]["enuri"], 2)?></span>

			</span>
		</td>
		<td style="text-align:center;font-size:12px;"><span>-</span></td>
		<td style="text-align:right;font-size:12px;">
			<span>
				사용
				<span><?php echo get_currency_price($TPL_V1["order"]["emoney"]+$TPL_V1["order"]["cash"], 2)?></span>
			</span>
		</td>
		<td style="text-align:center;font-size:12px;"><span>=</span></td>
		<td style="text-align:right;font-size:12px;">
			<span>
				총 결제금액
			</span>
		</td>
	</tr>
	<tr>
		<td style="text-align:right;font-size:11px;"><span><?php echo get_currency_price($TPL_V1["items_tot"]["price"], 2)?></span></td>
		<td></td>
		<td style="text-align:right;font-size:11px;">
<?php if($TPL_V1["shipping_tot"]["goods_shipping_cost"]||$TPL_V1["shipping_tot"]["add_goods_shipping_cost"]){?>
			<div>
				개별배송
<?php if($TPL_V1["shipping_tot"]["goods_shipping_cost"]){?>
				<span><?php echo get_currency_price($TPL_V1["shipping_tot"]["goods_shipping_cost"], 2)?></span>
<?php }?>
<?php if($TPL_V1["shipping_tot"]["add_goods_shipping_cost"]){?>
				<br>(도서지역 <?php echo get_currency_price($TPL_V1["shipping_tot"]["add_goods_shipping_cost"], 2)?> 포함)
<?php }?>
			</div>
<?php }?>
<?php if($TPL_V1["shipping_tot"]["shipping_cost"]||$TPL_V1["shipping_tot"]["add_goods_shipping_cost"]){?>
			<div>
				기본배송
<?php if($TPL_V1["shipping_tot"]["shipping_cost"]){?>
				<span><?php echo get_currency_price($TPL_V1["shipping_tot"]["shipping_cost"], 2)?></span>
<?php }?>
<?php if($TPL_V1["shipping_tot"]["add_shipping_cost"]){?>
				<br>(도서지역 <?php echo get_currency_price($TPL_V1["shipping_tot"]["add_shipping_cost"], 2)?> 포함)
<?php }?>
			</div>
<?php }?>
<?php if($TPL_V1["order"]["postpaid"]){?>
			<div>
				착불배송
				<span><?php echo get_currency_price($TPL_V1["order"]["postpaid"], 2)?></span>
			</div>
<?php }?>
		</td>
		<td></td>
		<td style="text-align:right;font-size:11px;">
<?php if($TPL_V1["items_tot"]["event_sale"]){?>
			<div>
				이벤트
				<?php echo get_currency_price($TPL_V1["items_tot"]["event_sale"], 2,'','<span>_str_price_</span>')?>

			</div>
<?php }?>
<?php if($TPL_V1["items_tot"]["multi_sale"]){?>
			<div>
				복수구매
				<?php echo get_currency_price($TPL_V1["items_tot"]["multi_sale"], 2,'','<span>_str_price_</span>')?>

			</div>
<?php }?>
<?php if($TPL_V1["items_tot"]["coupon_sale"]){?>
			<div>
				쿠폰
				<span><?php echo get_currency_price($TPL_V1["items_tot"]["coupon_sale"], 2)?></span>
			</div>
<?php }?>
<?php if($TPL_V1["items_tot"]["promotion_code_sale"]){?>
			<div>
				코드
				<span><?php echo get_currency_price($TPL_V1["items_tot"]["promotion_code_sale"], 2)?></span>
			</div>
<?php }?>
<?php if($TPL_V1["items_tot"]["member_sale"]){?>
			<div>
				등급
				<span><?php echo get_currency_price($TPL_V1["items_tot"]["member_sale"], 2)?></span>
			</div>
<?php }?>
<?php if($TPL_V1["items_tot"]["mobile_sale"]){?>
			<div>
				모바일
				<span><?php echo get_currency_price($TPL_V1["items_tot"]["mobile_sale"], 2)?></span>
			</div>
<?php }?>
<?php if($TPL_V1["items_tot"]["referer_sale"]){?>
			<div>
				유입경로
				<span><?php echo get_currency_price($TPL_V1["items_tot"]["referer_sale"], 2)?></span>
			</div>
<?php }?>
<?php if($TPL_V1["items_tot"]["shipping_coupon_sale"]){?>
			<div>
				배송비쿠폰
				<span><?php echo get_currency_price($TPL_V1["shipping_tot"]["shipping_coupon_sale"], 2)?></span>
			</div>
<?php }?>
<?php if($TPL_V1["items_tot"]["shipping_promotion_code_sale"]){?>
			<div>
				배송비코드
				<span><?php echo get_currency_price($TPL_V1["shipping_tot"]["shipping_promotion_code_sale"], 2)?></span>
			</div>
<?php }?>
<?php if($TPL_V1["order"]["enuri"]){?>
			<div>
				에누리
				<span><?php echo get_currency_price($TPL_V1["order"]["enuri"], 2)?></span>
			</div>
<?php }?>
		</td>
		<td></td>
		<td style="text-align:right;font-size:11px;">
<?php if($TPL_V1["order"]["emoney"]){?>
			<div>
				마일리지
				<span><?php echo get_currency_price($TPL_V1["order"]["emoney"], 2)?></span>
			</div>
<?php }?>
<?php if($TPL_V1["order"]["cash"]){?>
			<div>
				예치금
				<span><?php echo get_currency_price($TPL_V1["order"]["cash"], 2)?></span>
			</div>
<?php }?>
		</td>
		<td></td>
		<td style="text-align:right;font-size:12px;">
			<span><?php echo get_currency_price($TPL_V1["order"]["settleprice"], 2)?></span>
		</td>
	</tr>
	</tbody></table>

<?php if($TPL_VAR["order_centerinfo"]){?>
	<div style="padding:10px 5px 0px 5px;"><?php echo $TPL_VAR["order_centerinfo_message"]?></div>
<?php }?>


</div>
<?php }}?>

<script type="text/javascript">
$(document).ready(function() {
	window.print();
});
</script>

</body>
</html>