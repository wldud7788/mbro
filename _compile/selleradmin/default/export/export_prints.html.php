<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/selleradmin/skin/default/export/export_prints.html 000019153 */ 
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
			발송(출고)내역서
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
<?php if($TPL_VAR["export_code_barcode"]){?>
	<table style="width:97%">
			<tr>
				<td align="right">
					<?php echo $TPL_V1["data_export"]["export_barcode"]?>

				</td>
			</tr>
	</table>
<?php }?>
	<br style="height:40px" />
<?php if(is_array($TPL_R2=$TPL_V1["order_list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<table align="center" width="98%">
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
			<table width="100%" class="order_print_info">
				<tr>
					<th>주문번호</th>
					<td><?php echo $TPL_V2["order"]["order_seq"]?></td>
				</tr>
				<tr>
					<th>주문일자</th>
					<td><?php echo $TPL_V2["order"]["regist_date"]?></td>
				</tr>
				<tr>
					<th>주문고객</th>
					<td><?php echo $TPL_V2["order"]["order_user_name"]?></td>
				</tr>
				<tr>
					<th>전화</th>
					<td><?php echo $TPL_V2["order"]["order_phone"]?></td>
				</tr>
				<tr>
					<th>휴대전화</th>
					<td><?php echo $TPL_V2["order"]["order_cellphone"]?></td>
				</tr>
				<tr>
					<th>이메일</th>
					<td><?php echo $TPL_V2["order"]["order_email"]?></td>
				</tr>
			</table>
		</td>
		<td></td>
		<td>
			<table width="100%" class="order_print_info">
				<tr>
					<th>상품금액</th>
					<td><?php echo get_currency_price($TPL_V2["items_tot"]["price"], 4)?></td>
				</tr>
				<tr>
					<th>배송비</th>
					<td><?php echo get_currency_price($TPL_V2["shipping_tot"]["goods_shipping_cost"]+$TPL_V2["shipping_tot"]["shipping_cost"], 4)?></td>
				</tr>
				<tr>
					<th>할인</th>
					<td><?php echo get_currency_price($TPL_V2["items_tot"]["event_sale"]+$TPL_V2["items_tot"]["multi_sale"]+$TPL_V2["items_tot"]["coupon_sale"]+$TPL_V2["items_tot"]["member_sale"]+$TPL_V2["items_tot"]["fblike_sale"]+$TPL_V2["items_tot"]["mobile_sale"]+$TPL_V1["items_tot"]["promotion_code_sale"]+$TPL_V2["items_tot"]["referer_sale"]+$TPL_V2["shipping_tot"]["shipping_coupon_sale"]+$TPL_V2["shipping_tot"]["shipping_promotion_code_sale"]+$TPL_V2["orders"]["enuri"], 4)?></td>
				</tr>
				<tr>
					<th>사용 마일리지/예치금</th>
					<td><?php echo get_currency_price($TPL_V1["order"]["emoney"], 4)?> / <?php echo get_currency_price($TPL_V1["order"]["cash"], 4)?></td>
				</tr>
				<tr>
					<th>총 결제금액</th>
					<td>
<?php if($TPL_V1["order"]["deposit_yn"]!='y'){?><span>(입금전)</span><?php }?>
						<span style="font-size:12px;"><?php echo get_currency_price($TPL_V1["order"]["settleprice"], 4)?></span>
					</td>
				</tr>
				<tr>
					<th>결제수단</th>
					<td><?php echo $TPL_V1["order"]["mpayment"]?></td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
	<br/><hr/><br/><br/>
<?php }}?>
	<div style="height:5px"></div>
	<table align="center" width="98%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td><span class="title_print_info">배송정보</span></td>
	</tr>
	<tr>
		<td><div style="width:100%;border-top:1px solid #545454;height:1px;"></div></td>
	</tr>
	</table>
	<div style="height:3px"></div>
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
<?php if($TPL_V1["order"]["international"]=='international'){?>
<?php if($TPL_V1["order"]["international_postcode"]){?>
		(<?php echo $TPL_V1["order"]["international_postcode"]?>)
		<?php echo $TPL_V1["order"]["international_address"]?>

		<?php echo $TPL_V1["order"]["international_town_city"]?>

		<?php echo $TPL_V1["order"]["international_county"]?>

		<?php echo $TPL_V1["order"]["international_country"]?>

<?php }?>
<?php }else{?>
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
	<table align="center" width="98%">
	<tr>
		<td class="left"><span class="title_print_info">발송상품</span></td>
	</tr>
	<tr>
		<td><div style="width:100%;border-top:1px solid #545454;height:2px;"></div></td>
	</tr>
	</table>

	<table class="delivery_goods_print_info" align="center" width="98%">
		<col width="80" />
		<col  />
		<col width="80" />
		<col  />
		<tr>
			<th>출고번호</th>
			<td>
				<?php echo $TPL_V1["data_export"]["export_code"]?> <?php if($TPL_V1["data_export"]["is_bundle_export"]=='Y'){?>[합포장(묶음배송)]<?php }?>
			</td>
			<th>출고일자</th>
			<td>
				<?php echo $TPL_V1["data_export"]["export_date"]?>

			</td>
		</tr>
<?php if($TPL_V1["data_export_shipping"]["shipping_method"]!='coupon'){?>
		<tr>
			<th>배송방법</th>
			<td>
				<?php echo $TPL_V1["data_export"]["out_shipping_method"]?>

			</td>
			<th>운송장번호</th>
			<td>
				<?php echo $TPL_V1["data_export"]["mdelivery"]?> <?php echo $TPL_V1["data_export"]["mdelivery_number"]?>

			</td>
		</tr>
<?php }?>
	</table>
	<div style="height:3px"></div>
	<table class="delivery_goods_print_info" align="center" width="98%">
		<col />
		<col width="35" />
		<col width="70" />
		<col width="70" />
		<col width="70" />
		<col width="60" />
		<col width="35" />
		<col width="35" />
<?php if(is_array($TPL_R2=$TPL_V1["data_export_item"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_I2== 0){?>
		<tr>
			<th>
<?php if($TPL_V1["data_export_shipping"]["shipping_method"]=='coupon'){?>
			티켓명
<?php }else{?>
			상품명
<?php }?>
			</th>
			<th>주문</th>
			<th>판매가</th>
			<th>할인</th>
			<th>할인가(단가)</th>
			<th>적립</th>
			<th>취소</th>
			<th>발송</th>
		</tr>
<?php }?>
		<tr>
<?php if($TPL_V2["opt_type"]=='opt'){?>
			<td>
				<table border="0" cellpadding="0" cellspacing="0" style="border:0px">
					<tr>
<?php if($TPL_VAR["export_goods_image"]){?>
						<td style="border:0px;width:50px;text-align:center">
							<img src="<?php echo $TPL_V2["image"]?>" style="max-width:50px;max-height:50px;">
						</td>
<?php }?>
						<td style="font-size:11px;border:0px;">
							<?php echo $TPL_V2["goods_name"]?>

<?php if($TPL_V2["option1"]!=null){?>
							<div style="padding:5px 0px 0px 10px;">
								<?php echo $TPL_V2["title1"]?>:<?php echo $TPL_V2["option1"]?>

<?php if($TPL_V2["option2"]!=null){?> <?php echo $TPL_V2["title2"]?>:<?php echo $TPL_V2["option2"]?><?php }?>
<?php if($TPL_V2["option3"]!=null){?> <?php echo $TPL_V2["title3"]?>:<?php echo $TPL_V2["option3"]?><?php }?>
<?php if($TPL_V2["option4"]!=null){?> <?php echo $TPL_V2["title4"]?>:<?php echo $TPL_V2["option4"]?><?php }?>
<?php if($TPL_V2["option5"]!=null){?> <?php echo $TPL_V2["title5"]?>:<?php echo $TPL_V2["option5"]?><?php }?>
							</div>
<?php }?>
<?php if($TPL_VAR["export_addinfo"]){?>
<?php if(($TPL_VAR["export_warehouse"]&&$TPL_V2["whinfo"]["wh_seq"]> 0)||($TPL_VAR["export_goods_code"]&&$TPL_V2["goods_code"])){?>
							<div style="padding:5px;margin:2px 10px 5px 0;border:1px solid #c5c5c5;background-color:#fff;">
							<ul>
<?php if($TPL_VAR["export_warehouse"]&&$TPL_V2["whinfo"]["wh_seq"]> 0){?>
								<li>
<?php if($TPL_V2["whinfo"]["wh_name"]){?>
								<?php echo $TPL_V2["whinfo"]["wh_name"]?> (<?php echo $TPL_V2["whinfo"]["location_code"]?>) : <?php echo number_format($TPL_V2["whinfo"]["ea"])?>(<?php echo number_format($TPL_V2["whinfo"]["badea"])?>)
<?php }else{?>
								해당 창고에 입고된 내역이 없습니다.
<?php }?>
								</li>
<?php }?>
<?php if($TPL_VAR["export_goods_code"]&&$TPL_V2["goods_code"]){?>
								<li><?php echo $TPL_V2["goods_code"]?></li>
<?php }?>
							</ul>
							</div>
<?php }?>
<?php }?>
<?php if($TPL_VAR["export_goods_barcode"]&&$TPL_V2["goods_code"]){?>
							<div style="padding:2px 0px 0px 10px;">
								<?php echo $TPL_V2["barcode_image"]?>

							</div>
<?php }?>
<?php if($TPL_V2["inputs"]){?>
							<div style="padding:0px 0px 0px 10px;">
<?php if(is_array($TPL_R3=$TPL_V2["inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["value"]){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V3["title"]){?><?php echo $TPL_V3["title"]?>:<?php }?>
<?php if($TPL_V3["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V3["value"]?>" target="actionFrame"><?php echo $TPL_V3["value"]?></a>
<?php }else{?><?php echo $TPL_V3["value"]?><?php }?>
								</div>
<?php }?>
<?php }}?>
							</div>
<?php }?>
						</td>
					</tr>
				</table>
<?php }else{?>
			<td style="padding-left:20px;">
				<table border="0" cellpadding="0" cellspacing="0" style="border:0px">
				<tr>
					<td style="border:0px">
						<div style="padding-left:10px;">
							<?php echo $TPL_V2["title1"]?> : <?php echo $TPL_V2["option1"]?>

<?php if($TPL_VAR["export_addinfo"]){?>
<?php if(($TPL_VAR["export_warehouse"]&&$TPL_V2["whinfo"]["wh_seq"]> 0)||($TPL_VAR["export_goods_code"]&&$TPL_V2["goods_code"])){?>
							<div style="padding:5px;margin:2px 10px 5px 0;border:1px solid #c5c5c5;background-color:#fff;">
							<ul>
<?php if($TPL_VAR["export_warehouse"]&&$TPL_V2["whinfo"]["wh_seq"]> 0){?>
								<li>
<?php if($TPL_V2["whinfo"]["wh_name"]){?>
								<?php echo $TPL_V2["whinfo"]["wh_name"]?> (<?php echo $TPL_V2["whinfo"]["location_code"]?>) : <?php echo number_format($TPL_V2["whinfo"]["ea"])?>(<?php echo number_format($TPL_V2["whinfo"]["badea"])?>)
<?php }else{?>
								해당 창고에 입고된 내역이 없습니다.
<?php }?>
								</li>
<?php }?>
<?php if($TPL_VAR["export_goods_code"]&&$TPL_V2["goods_code"]){?>
								<li><?php echo $TPL_V2["goods_code"]?></li>
<?php }?>
							</ul>
							</div>
<?php }?>
<?php }?>
<?php if($TPL_VAR["export_goods_barcode"]){?>
							<div style="padding:2px 0px 0px 0px;">
								<?php echo $TPL_V2["barcode_image"]?>

							</div>
<?php }?>

						</div>
					</td>
				</tr>
				</table>
<?php }?>
			</td>
			<td class="right">
<?php if($TPL_V2["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V2["opt_ea"]?><?php if($TPL_V2["package_yn"]=='y'){?>]<?php }?>
			</td>

			<td class="right"><?php echo get_currency_price($TPL_V2["out_price"], 4)?></td>
			<td class="right"><?php echo get_currency_price($TPL_V2["out_price"]-$TPL_V2["out_sale_price"], 4)?></td>
			<td class="right">
				<?php echo get_currency_price($TPL_V2["out_sale_price"], 4)?>

				<br/>(<?php echo get_currency_price($TPL_V2["sale_price"], 4)?>)
			</td>
			<td class="right">
			<?php echo get_currency_price($TPL_V2["out_reserve"], 4,'','','unit-money')?>

<?php if($TPL_V2["out_point"]){?>
			<br/><?php echo get_currency_price($TPL_V2["out_point"])?><span class="unit-money">P</span>
<?php }?>
			</td>
			<td class="right"><?php echo $TPL_V2["step85"]?></td>
			<td class="right"><?php echo $TPL_V2["ea"]?></td>
		</tr>
		
<?php if($TPL_V2["package_yn"]=='y'&&$TPL_V2["opt_type"]=='opt'){?> <!-- export_PackageGoodsName && 이부분 삭제 2016.04.21 -->			
<?php if(is_array($TPL_R3=$TPL_V2["packages"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
		<tr>
			<td style="padding-left:45px;">
				<table border="0" cellpadding="0" cellspacing="0" style="border:0px">
					<tr>
<?php if($TPL_VAR["export_goods_image"]){?>
						<td style="border:0px;width:50px;text-align:center">
							<img src="<?php echo $TPL_V3["image"]?>" style="max-width:50px;max-height:50px;">
						</td>
<?php }?>
						<td style="font-size:11px;border:0px;">
							[실제상품 <?php echo $TPL_I3+ 1?>]
							<?php echo $TPL_V3["goods_name"]?>

<?php if($TPL_V3["option1"]!=null){?>
							<div style="padding:5px 0px 0px 10px;">
								<?php echo $TPL_V3["title1"]?>:<?php echo $TPL_V3["option1"]?>

<?php if($TPL_V3["option2"]!=null){?> <?php echo $TPL_V3["title2"]?>:<?php echo $TPL_V3["option2"]?><?php }?>
<?php if($TPL_V3["option3"]!=null){?> <?php echo $TPL_V3["title3"]?>:<?php echo $TPL_V3["option3"]?><?php }?>
<?php if($TPL_V3["option4"]!=null){?> <?php echo $TPL_V3["title4"]?>:<?php echo $TPL_V3["option4"]?><?php }?>
<?php if($TPL_V3["option5"]!=null){?> <?php echo $TPL_V3["title5"]?>:<?php echo $TPL_V3["option5"]?><?php }?>
							</div>
<?php }?>

<?php if($TPL_VAR["export_goods_code"]){?>
							<div style="padding:2px 0px 0px 10px;">
							<?php echo $TPL_V3["goods_code"]?>

							</div>
<?php }?>
<?php if($TPL_VAR["export_goods_barcode"]){?>
							<div style="padding:2px 0px 0px 10px;">
								<?php echo $TPL_V3["barcode_image"]?>

							</div>
<?php }?>
<?php if($TPL_V2["inputs"]){?>
							<div style="padding:0px 0px 0px 10px;">
<?php if(is_array($TPL_R4=$TPL_V3["inputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
<?php if($TPL_V4["value"]){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V4["title"]){?><?php echo $TPL_V4["title"]?>:<?php }?>
<?php if($TPL_V4["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V4["value"]?>" target="actionFrame"><?php echo $TPL_V4["value"]?></a>
<?php }else{?><?php echo $TPL_V4["value"]?><?php }?>
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
				<?php echo $TPL_V3["unit_ea"]*$TPL_V2["opt_ea"]?>

			</td>
			<td class="right">-</td>
			<td class="right">-</td>
			<td class="right">-</td>
			<td class="right">-</td>
			<td class="right">-</td>
			<td class="right">-</td>
		</tr>
<?php }}?>
<?php }?>
<?php if($TPL_V2["package_yn"]=='y'&&$TPL_V2["opt_type"]=='sub'){?> <!-- export_PackageGoodsNameSub && 이 부분 삭제 2016.04.21 -->
<?php if(is_array($TPL_R3=$TPL_V2["packages"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
		<tr>
			<td style="padding-left:65px;">
				<table border="0" cellpadding="0" cellspacing="0" style="border:0px">
					<tr>
<?php if($TPL_VAR["export_goods_image"]){?>
						<td style="border:0px;width:50px;text-align:center">
							<img src="<?php echo $TPL_V3["image"]?>" style="max-width:50px;max-height:50px;">
						</td>
<?php }?>
						<td style="font-size:11px;border:0px;">
							[실제상품]
							<?php echo $TPL_V3["goods_name"]?>

<?php if($TPL_V3["option1"]!=null){?>
							<div style="padding:5px 0px 0px 10px;">
								<?php echo $TPL_V3["title1"]?>:<?php echo $TPL_V3["option1"]?>

<?php if($TPL_V3["option2"]!=null){?> <?php echo $TPL_V3["title2"]?>:<?php echo $TPL_V3["option2"]?><?php }?>
<?php if($TPL_V3["option3"]!=null){?> <?php echo $TPL_V3["title3"]?>:<?php echo $TPL_V3["option3"]?><?php }?>
<?php if($TPL_V3["option4"]!=null){?> <?php echo $TPL_V3["title4"]?>:<?php echo $TPL_V3["option4"]?><?php }?>
<?php if($TPL_V3["option5"]!=null){?> <?php echo $TPL_V3["title5"]?>:<?php echo $TPL_V3["option5"]?><?php }?>
							</div>
<?php }?>

<?php if($TPL_VAR["export_goods_code"]){?>
							<div style="padding:2px 0px 0px 10px;">
							<?php echo $TPL_V3["goods_code"]?>

							</div>
<?php }?>
<?php if($TPL_VAR["export_goods_barcode"]){?>
							<div style="padding:2px 0px 0px 10px;">
								<?php echo $TPL_V3["barcode_image"]?>

							</div>
<?php }?>
<?php if($TPL_V2["inputs"]){?>
							<div style="padding:0px 0px 0px 10px;">
<?php if(is_array($TPL_R4=$TPL_V3["inputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
<?php if($TPL_V4["value"]){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V4["title"]){?><?php echo $TPL_V4["title"]?>:<?php }?>
<?php if($TPL_V4["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V4["value"]?>" target="actionFrame"><?php echo $TPL_V4["value"]?></a>
<?php }else{?><?php echo $TPL_V4["value"]?><?php }?>
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
				<?php echo $TPL_V3["unit_ea"]*$TPL_V2["opt_ea"]?>

			</td>
			<td class="right">-</td>
			<td class="right">-</td>
			<td class="right">-</td>
			<td class="right">-</td>
			<td class="right">-</td>
			<td class="right">-</td>
		</tr>
<?php }}?>
<?php }?>
<?php }}?>


	</table>

<?php if($TPL_VAR["export_centernfo"]){?>
	<div style="padding:10px 7px 0px 7px;"><?php echo $TPL_VAR["export_centerinfo_message"]?></div>
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