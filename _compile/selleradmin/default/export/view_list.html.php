<?php /* Template_ 2.2.6 2022/05/17 12:29:07 /www/music_brother_firstmall_kr/selleradmin/skin/default/export/view_list.html 000029771 */ 
$TPL_data_export_item_1=empty($TPL_VAR["data_export_item"])||!is_array($TPL_VAR["data_export_item"])?0:count($TPL_VAR["data_export_item"]);?>
<style>
span.goods_name1 {display:inline-block;white-space:nowrap;overflow:hidden;width:250px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
span.goods_name2 {display:inline-block;white-space:nowrap;overflow:hidden;width:500px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
.price {padding-right:5px;text-align:right}
div.left {float:left;padding-right:10px}
span.option {padding-right:10px;}
span.coupon_serial {margin-left:10px;}
table.order-inner-table td,table.order-inner-table th {border:0 !important;height:9px !important;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	chk_small_goods_image();
});
</script>
<table class="order-view-table" width="100%" border=0>
	<colgroup>
		<col />
		<col width="4%" />
		<col width="8%" />
		<col width="6%" />
		<col width="6%" />
		<col width="6%" />
		<col width="5%" />
		<col width="5%" />
		<col width="5%" />
		<col width="5%" />
		<col width="5%" />
		<col width="5%" />
	</colgroup>
	<thead class="oth">
		<tr>
			<th class="dark" rowspan="2">출고상품</th>
			<th class="dark" rowspan="2">주문<br />수량</th>
			<th class="dark" rowspan="2">재고/가용
<?php if(is_array($TPL_R1=config_load('order','ableStockStep'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1=='25'){?>
				<span class="helpicon" title="가용 = 재고-출고예약량<br/>출고예약량 = 결제확인+상품준비+출고준비"></span>
<?php }else{?>
				<span class="helpicon" title="가용 = 재고-출고예약량<br/>출고예약량 = 주문접수+결제확인+상품준비+출고준비"></span>
<?php }?>
<?php }}?></th>
			<th class="dark" rowspan="2">출고수량</th>
			<th class="dark" rowspan="2">예상마일리지<span class="helpicon" title="해당 출고건의 마일리지/포인트가 지급(배송완료 시 또는 구매확정 시)될 때<br />지급되어야 하는 잔여 마일리지/포인트입니다."></span><br/><span class="desc">(예상포인트)</span></th>
			<th class="dark" rowspan="2">지급마일리지<br/><span class="desc">(지급포인트)</span></th>
			<th class="dark" colspan="6">
				현재 출고 외 상태
<?php if($TPL_VAR["data_export"]["wh_name"]){?>
				: <span style="color:red;"><?php echo $TPL_VAR["data_export"]["wh_name"]?></span>
<?php }?>
			<th>
		</tr>
		<tr>
			<th class="dark">준비</th>
			<th class="dark">출고<br/>준비</th>
			<th class="dark">출고<br/>완료</th>
			<th class="dark">배송<br/>중</th>
			<th class="dark">배송<br/>완료</th>
			<th class="dark">취소</th>
		</tr>
	</thead>

	<tbody class="otb">
<?php if($TPL_data_export_item_1){foreach($TPL_VAR["data_export_item"] as $TPL_V1){?>
<?php if($TPL_V1["opt_type"]=='sub'||$TPL_V1["goods_type"]=='gift'){?>
		<tr class="order-item-row" bgcolor="#f6f6f6">
<?php }else{?>
		<tr class="order-item-row">
<?php }?>
			<td class="info">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" style="border:none;">
							<a href='/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank'>
							<span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V1["image"]?>" /></span>
							</a>
						</td>
						<td style="border:none;">
						<div>
<?php if($TPL_V1["npay_product_order_id"]){?><div class="ngray bold"><?php echo $TPL_V1["npay_product_order_id"]?><span style="font-size:11px;font-weight:normal"> (Npay상품주문번호)</span></div><?php }?>
<?php if($TPL_V1["goods_type"]=="gift"){?>
						<img src="/admin/skin/default/images/common/icon_gift.gif" />
<?php }?>
<?php if($TPL_V1["goods_kind"]=='coupon'){?>
						<a href='../goods/social_regist?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank'>
<?php }elseif($TPL_V1["goods_type"]=='gift'){?>
						<a href='../goods/gift_regist?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank'>
<?php }else{?>
<?php if($TPL_V1["is_bundle_export"]=='Y'){?><span class="bold red">[<?php echo $TPL_V1["order_seq"]?>]</span><br/><?php }?>
						<a href='../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank'>
<?php }?><?php echo $TPL_V1["goods_name"]?></a>
						</div>

<?php if($TPL_V1["adult_goods"]=='Y'||$TPL_V1["option_international_shipping_status"]=='y'||$TPL_V1["cancel_type"]=='1'||$TPL_V1["tax"]=='exempt'){?>
						<div style="padding-top:3px">
<?php if($TPL_V1["adult_goods"]=='Y'){?>
							<img src="/admin/skin/default/images/common/auth_img.png" alt="성인" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V1["option_international_shipping_status"]=='y'){?>
							<img src="/admin/skin/default/images/common/icon/plane_on.png" alt="해외배송상품" style="vertical-align: middle;" height="19" />
<?php }?>
<?php if($TPL_V1["cancel_type"]=='1'){?>
							<img src="/admin/skin/default/images/common/icon/nocancellation.gif" alt="청약철회" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V1["tax"]=='exempt'){?>
							<img src="/admin/skin/default/images/common/icon/taxfree.gif" alt="비과세" style="vertical-align: middle;"/>
<?php }?>
						</div>
<?php }?>

						<!-- <?php if($TPL_V1["goods_kind"]=='coupon'){?> -->
						<div style="padding-top:3px">
						<span class="coupon_serial"><?php echo $TPL_V1["coupon_serial"]?></span> /
						<span class="coupon_input"><?php if($TPL_VAR["socialcp_input_type"]=='price'){?><?php echo get_currency_price($TPL_V1["coupon_input"], 3)?><?php }else{?><?php echo number_format($TPL_V1["coupon_input"])?>회<?php }?></span> /
						<span class="coupon_remain_value red">잔여<?php if($TPL_VAR["socialcp_input_type"]=='price'){?><?php echo get_currency_price($TPL_V1["coupon_remain_value"], 3)?><?php }else{?><?php echo number_format($TPL_V1["coupon_remain_value"])?>회<?php }?></span>
						<span class="btn"><img src="/admin/skin/default/images/common/btn_ok_use.gif" class="excoupon_use_btn" order_seq="<?php echo $TPL_VAR["data_export"]["order_seq"]?>" onclick="excoupon_use_btn(this)" /></span>
						</div>
						<!-- <?php }?> -->

<?php if($TPL_V1["event_seq"]&&$TPL_V1["event_title"]){?>
						<div style="padding-top:3px">
						<a href="/admin/event/<?php if($TPL_V1["event_type"]=='solo'){?>solo<?php }?>regist?event_seq=<?php echo $TPL_V1["event_seq"]?>" target='_blank'><span class="btn small gray"><button type="button" class="goods_event hand"><?php echo $TPL_V1["event_title"]?></button></span></a>
						</div>
<?php }?>

<?php if($TPL_V1["option1"]!=null||$TPL_V1["option2"]!=null||$TPL_V1["option3"]!=null||$TPL_V1["option4"]!=null||$TPL_V1["option5"]!=null){?>
						<div style="padding-top:3px">
<?php if($TPL_V1["opt_type"]=='sub'){?>
							<img src="/admin/skin/default/images/common/icon_add.gif" />
<?php }else{?>
							<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php }?>
<?php if($TPL_V1["option1"]!=null){?>
							<span class="option"><?php echo $TPL_V1["title1"]?> : <?php echo $TPL_V1["option1"]?></span>
<?php }?>
<?php if($TPL_V1["option2"]!=null){?>
							<span class="option"><?php echo $TPL_V1["title2"]?> : <?php echo $TPL_V1["option2"]?></span>
<?php }?>
<?php if($TPL_V1["option3"]!=null){?>
							<span class="option"><?php echo $TPL_V1["title3"]?> : <?php echo $TPL_V1["option3"]?></span>
<?php }?>
<?php if($TPL_V1["option4"]!=null){?>
							<span class="option"><?php echo $TPL_V1["title4"]?> : <?php echo $TPL_V1["option4"]?></span>
<?php }?>
<?php if($TPL_V1["option5"]!=null){?>
							<span class="option"><?php echo $TPL_V1["title5"]?> : <?php echo $TPL_V1["option5"]?></span>
<?php }?>
						</div>
<?php }?>
<?php if($TPL_V1["inputs"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["inputs"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["value"]){?>
						<div class="goods_input">
							<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V2["title"]){?><?php echo $TPL_V2["title"]?>:<?php }?>
<?php if($TPL_V2["type"]=='file'){?>
							<a href="../order_process/filedown?file=<?php echo $TPL_V2["value"]?>" target="actionFrame"><?php echo $TPL_V2["value"]?></a>
<?php }else{?><?php echo $TPL_V2["value"]?><?php }?>
						</div>
<?php }?>
<?php }}?>
<?php }?>

<?php if($TPL_V1["goods_type"]=="gift"){?>
<?php if($TPL_V1["gift_title"]){?><div><span class="fx11"><?php echo $TPL_V1["gift_title"]?></span> <span class="btn small gray"><button type="button" class="gift_log" order_seq="<?php echo $TPL_VAR["data_export"]["order_seq"]?>" item_seq="<?php echo $TPL_V1["item_seq"]?>">자세히</button></span></div><?php }?>
<?php }?>

<?php if($TPL_V1["package_yn"]!='y'){?>
						<div class="warehouse-info-lay">
							<ul>
<?php if($TPL_V1["whinfo"]["wh_name"]){?>
								<li>
								<?php echo $TPL_V1["whinfo"]["wh_name"]?> <?php if($TPL_V1["whinfo"]["location_code"]){?>(<?php echo $TPL_V1["whinfo"]["location_code"]?>)<?php }?> : <?php echo number_format($TPL_V1["whinfo"]["ea"])?>(<?php echo number_format($TPL_V1["whinfo"]["badea"])?>)
								</li>
<?php }?>
								<li>상품코드 : <?php echo $TPL_V1["goods_code"]?></li>
							</ul>
						</div>
<?php }?>
						</td>
					</tr>
				</table>
			</td>
			<td class="info center ea"><?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["opt_ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?></td>

			<td class="info center">
<?php if($TPL_V1["package_yn"]=='y'){?>
				<span class="blue">실제상품▼</span>
<?php }else{?>
<?php if($TPL_V1["real_stock"]> 0){?>
			<span class="blue"><?php echo number_format($TPL_V1["real_stock"])?></span>
<?php }else{?>
			<span class="red"><?php echo number_format($TPL_V1["real_stock"])?></span>
<?php }?>
			<br/>
<?php if($TPL_V1["stock"]> 0){?>
			<span class="blue"><?php echo number_format($TPL_V1["stock"])?></span>
<?php }else{?>
			<span class="red"><?php echo number_format($TPL_V1["stock"])?></span>
<?php }?>

			<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V1["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_V1["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
				<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V1["whinfo"]["option_seq"]?>"></span>
				<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"><span class="hide">옵션</span></span>
			</span>
<?php }?>
			</td>

			<td class="info center">
<?php if($TPL_VAR["data_export"]["status"]== 45){?>
			<form method="post" action="../export_process/ea_modify?export_code=<?php echo $TPL_VAR["data_export"]["export_code"]?>" target="actionFrame">
			<input type="text" name="ea[<?php echo $TPL_V1["export_item_seq"]?>]" size="3" class="onlynumber line" value="<?php echo $TPL_V1["ea"]?>" <?php if($TPL_VAR["npay_use"]&&$TPL_V1["npay_product_order_id"]){?>disabled<?php }?>/>
<?php if(!$TPL_VAR["npay_use"]||!$TPL_V1["npay_product_order_id"]){?>
			<span class="btn small cyanblue"><button type="submit" class="ea_modify">변경</button></span>
<?php }?>
			</form>
<?php }else{?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
<?php }?>
			</td>

			<td class="price info">
				<?php echo get_currency_price($TPL_V1["out_reserve"])?><br/>
				<span class="desc">(<?php echo get_currency_price($TPL_V1["out_point"])?>)</span>
			</td>
			<td class="price info">
				<?php echo get_currency_price($TPL_V1["in_reserve"])?><br/>
				<span class="desc">(<?php echo get_currency_price($TPL_V1["in_point"])?>)</span>
			</td>

			<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["ready_ea"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step45"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step55"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step65"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step75"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step85"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
			</td>


		</tr>
<?php if($TPL_V1["package_yn"]=='y'&&$TPL_V1["opt_type"]=='opt'){?>
<?php if(is_array($TPL_R2=$TPL_V1["packages"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
		<tr class="order-item-row">
			<td style="padding-left:45px;">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:0px">
					<tr>
						<td valign="top" style="border:none;" width="14"><img src="/admin/skin/default/images/common/icon/ico_package.gif" border="0" /></td>
						<td style="border:0px;width:50px;text-align:center">
							<span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V2["image"]?>" /></span>
						</td>
						<td style="font-size:11px;border:0px;">
							<span class="red">
							[실제상품 <?php echo $TPL_I2+ 1?>]
							<?php echo $TPL_V2["goods_name"]?>

							</span>
<?php if($TPL_V2["option1"]!=null){?>
							<div style="padding:5px 0px 0px 10px;">
								<?php echo $TPL_V2["title1"]?>:<?php echo $TPL_V2["option1"]?>

<?php if($TPL_V2["option2"]!=null){?> <?php echo $TPL_V2["title2"]?>:<?php echo $TPL_V2["option2"]?><?php }?>
<?php if($TPL_V2["option3"]!=null){?> <?php echo $TPL_V2["title3"]?>:<?php echo $TPL_V2["option3"]?><?php }?>
<?php if($TPL_V2["option4"]!=null){?> <?php echo $TPL_V2["title4"]?>:<?php echo $TPL_V2["option4"]?><?php }?>
<?php if($TPL_V2["option5"]!=null){?> <?php echo $TPL_V2["title5"]?>:<?php echo $TPL_V2["option5"]?><?php }?>
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

							<div class="warehouse-info-lay">
							<ul>
<?php if($TPL_V2["whinfo"]["wh_name"]){?>
								<li>
								<?php echo $TPL_V2["whinfo"]["wh_name"]?> <?php if($TPL_V2["whinfo"]["location_code"]){?>(<?php echo $TPL_V2["whinfo"]["location_code"]?>)<?php }?> : <?php echo number_format($TPL_V2["whinfo"]["ea"])?>(<?php echo number_format($TPL_V2["whinfo"]["badea"])?>)
								</li>
<?php }?>
								<li>상품코드 : <?php echo $TPL_V2["goods_code"]?></li>
							</ul>
							</div>
						</td>
					</tr>
				</table>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["opt_ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["opt_ea"]?>

				<div class="center">
					<span class="helpicon" title="<?php echo $TPL_V2["unit_ea"]?>개 / 주문수량당"></span>
				</div>
			</td>
			<td class="info center">
<?php if($TPL_V2["real_stock"]> 0){?>
				<span class="blue"><?php echo number_format($TPL_V2["real_stock"])?></span>
<?php }else{?>
				<span class="red"><?php echo number_format($TPL_V2["real_stock"])?></span>
<?php }?>
				<br/>
<?php if($TPL_V2["stock"]> 0){?>
				<span class="blue"><?php echo number_format($TPL_V2["stock"])?></span>
<?php }else{?>
				<span class="red"><?php echo number_format($TPL_V2["stock"])?></span>
<?php }?>
				<div class="center">
					<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V2["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_V1["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
						<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V2["whinfo"]["option_seq"]?>"></span>
						<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V2["goods_seq"]?>"><span class="hide">옵션</span></span>
					</span>
				</div>
			</td>
			<td class="info center">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["ea"]?>

			</td>
			<td class="info center">-</td>
			<td class="info center">-</td>
			<td class="info center ea">
<?php if($TPL_V1["ready_ea"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["ready_ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["ready_ea"]?>

<?php }else{?>
				0
<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["exp_step45"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step45"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step45"]?>

<?php }else{?>
				0
<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["exp_step55"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step55"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step55"]?>

<?php }else{?>
				0
<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["exp_step65"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step65"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step65"]?>

<?php }else{?>
				0
<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["exp_step75"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step75"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step75"]?>

<?php }else{?>
				0
<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["exp_step85"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step85"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step85"]?>

<?php }else{?>
				0
<?php }?>
			</td>
		</tr>
<?php }}?>
<?php }?>
<?php if($TPL_V1["package_yn"]=='y'&&$TPL_V1["opt_type"]=='sub'){?>
<?php if(is_array($TPL_R2=$TPL_V1["packages"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
		<tr class="order-item-row" bgcolor="#f6f6f6">
			<td style="padding-left:45px;">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:0px">
					<tr>
						<td valign="top" style="border:none;" width="14"><img src="/admin/skin/default/images/common/icon/ico_package.gif" border="0" /></td>
						<td style="border:0px;width:50px;text-align:center">
							<span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V2["image"]?>" /></span>
						</td>

						<td style="font-size:11px;border:0px;">
							<span class="red">
							[실제상품]
							<?php echo $TPL_V2["goods_name"]?>

							</span>
<?php if($TPL_V2["option1"]!=null){?>
							<div style="padding:5px 0px 0px 10px;">
								<?php echo $TPL_V2["title1"]?>:<?php echo $TPL_V2["option1"]?>

<?php if($TPL_V2["option2"]!=null){?> <?php echo $TPL_V2["title2"]?>:<?php echo $TPL_V2["option2"]?><?php }?>
<?php if($TPL_V2["option3"]!=null){?> <?php echo $TPL_V2["title3"]?>:<?php echo $TPL_V2["option3"]?><?php }?>
<?php if($TPL_V2["option4"]!=null){?> <?php echo $TPL_V2["title4"]?>:<?php echo $TPL_V2["option4"]?><?php }?>
<?php if($TPL_V2["option5"]!=null){?> <?php echo $TPL_V2["title5"]?>:<?php echo $TPL_V2["option5"]?><?php }?>
							</div>
<?php }?>

<?php if($TPL_VAR["exportPrintGoodsBarcode"]){?>
							<div style="padding:2px 0px 0px 10px;">
							<img src="../order/order_barcode_image?order_seq=<?php echo $TPL_V2["goods_code"]?>" />
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

							<div class="warehouse-info-lay">
							<ul>
<?php if($TPL_V2["whinfo"]["wh_name"]){?>
								<li>
								<?php echo $TPL_V2["whinfo"]["wh_name"]?> <?php if($TPL_V2["whinfo"]["location_code"]){?>(<?php echo $TPL_V2["whinfo"]["location_code"]?>)<?php }?> : <?php echo number_format($TPL_V2["whinfo"]["ea"])?>(<?php echo number_format($TPL_V2["whinfo"]["badea"])?>)
								</li>
<?php }?>
								<li>상품코드 : <?php echo $TPL_V2["goods_code"]?></li>
							</ul>
							</div>

						</td>
					</tr>
				</table>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["opt_ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["opt_ea"]?>

				<div class="center">
					<span class="helpicon" title="<?php echo $TPL_V2["unit_ea"]?>개 / 주문수량당"></span>
				</div>
			</td>
			<td class="info center">
<?php if($TPL_V2["real_stock"]> 0){?>
				<span class="blue"><?php echo number_format($TPL_V2["real_stock"])?></span>
<?php }else{?>
				<span class="red"><?php echo number_format($TPL_V2["real_stock"])?></span>
<?php }?>
				<br/>
<?php if($TPL_V2["stock"]> 0){?>
				<span class="blue"><?php echo number_format($TPL_V2["stock"])?></span>
<?php }else{?>
				<span class="red"><?php echo number_format($TPL_V2["stock"])?></span>
<?php }?>

				<div class="center">
					<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V2["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_V1["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
						<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V2["whinfo"]["option_seq"]?>"></span>
						<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V2["goods_seq"]?>"><span class="hide">옵션</span></span>
					</span>
				</div>
			</td>
			<td class="info center">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["ea"]?>

			</td>
			<td class="info center">-</td>
			<td class="info center">-</td>
			<td class="info center ea">
<?php if($TPL_V1["ready_ea"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["ready_ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["ready_ea"]?>

<?php }else{?>
				0
<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["exp_step45"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step45"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step45"]?>

<?php }else{?>
				0
<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["exp_step55"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step55"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step55"]?>

<?php }else{?>
				0
<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["exp_step65"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step65"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step65"]?>

<?php }else{?>
				0
<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["exp_step75"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step75"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step75"]?>

<?php }else{?>
				0
<?php }?>
			</td>
			<td class="info center ea">
<?php if($TPL_V1["exp_step85"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step85"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step85"]?>

<?php }else{?>
				0
<?php }?>
			</td>
		</tr>
<?php }}?>
<?php }?>
<?php }}?>

		<tr class="order-item-row">
			<td style="padding-left:10px; border-right:0px;">
			<?php echo $TPL_VAR["orders"]["recipient_user_name"]?>

<?php if($TPL_VAR["data_export_item"][ 0]["goods_kind"]=='coupon'){?>
<?php if($TPL_VAR["orders"]["recipient_cellphone"]){?> / <?php echo ($TPL_VAR["orders"]["recipient_cellphone"])?><?php }?>
<?php if($TPL_VAR["orders"]["recipient_email"]){?> / <?php echo ($TPL_VAR["orders"]["recipient_email"])?><?php }?>
<?php }else{?>
<?php if($TPL_VAR["orders"]["recipient_zipcode"]){?>(<?php echo $TPL_VAR["orders"]["recipient_zipcode"]?>)<?php }?>
<?php if($TPL_VAR["orders"]["recipient_address_type"]!="street"){?>
					<?php echo $TPL_VAR["orders"]["recipient_address"]?> <?php echo $TPL_VAR["orders"]["recipient_address_detail"]?><br/>
<?php }else{?>
					<?php echo $TPL_VAR["orders"]["recipient_address_street"]?> <?php echo $TPL_VAR["orders"]["recipient_address_detail"]?><br/>
<?php }?>
<?php if($TPL_VAR["orders"]["recipient_phone"]){?><?php echo ($TPL_VAR["orders"]["recipient_phone"])?><?php }?>
<?php if($TPL_VAR["orders"]["recipient_cellphone"]){?> / <?php echo ($TPL_VAR["orders"]["recipient_cellphone"])?><?php }?>
<?php if($TPL_VAR["orders"]["hope_date"]){?> / <?php echo $TPL_VAR["orders"]["hope_date"]?><?php }?>
<?php }?>
			</td>
			<td class="info ea center"><strong><?php echo $TPL_VAR["tot"]["opt_ea"]?></strong></td>
			<td  class="info center">
<?php if($TPL_VAR["tot"]["real_stock"]> 0){?>
			<span class="blue bold"><?php echo number_format($TPL_VAR["tot"]["real_stock"])?></span>
<?php }else{?>
			<span class="red bold"><?php echo number_format($TPL_VAR["tot"]["real_stock"])?></span>
<?php }?>
			<br/>
<?php if($TPL_VAR["tot"]["stock"]> 0){?>
			<span class="blue bold"><?php echo number_format($TPL_VAR["tot"]["stock"])?></span>
<?php }else{?>
			<span class="red bold"><?php echo number_format($TPL_VAR["tot"]["stock"])?></span>
<?php }?>
			</td>
			<td class="info center"><strong><?php echo $TPL_VAR["tot"]["ea"]?> (<?php echo $TPL_VAR["tot"]["goods_cnt"]?>종)</strong></td>
			<td class="price info bold">
				<?php echo get_currency_price($TPL_VAR["tot"]["reserve"])?><br/>
				<span class="desc">(<?php echo get_currency_price($TPL_VAR["tot"]["point"])?>)</span>
			</td>
			<td class="price info bold">
				<?php echo get_currency_price($TPL_VAR["tot"]["in_reserve"])?><br/>
				<span class="desc">(<?php echo get_currency_price($TPL_VAR["tot"]["in_point"])?>)</span>
			</td>
			<td class="info ea bold center"><?php echo number_format($TPL_VAR["tot"]["ready_ea"])?></td>
			<td class="info ea bold center"><?php echo number_format($TPL_VAR["tot"]["exp_step45"])?></td>
			<td class="info ea bold center"><?php echo number_format($TPL_VAR["tot"]["exp_step55"])?></td>
			<td class="info ea bold center"><?php echo number_format($TPL_VAR["tot"]["exp_step65"])?></td>
			<td class="info ea bold center"><?php echo number_format($TPL_VAR["tot"]["exp_step75"])?></td>
			<td class="info ea bold center"><?php echo number_format($TPL_VAR["tot"]["step85"])?></td>
		</tr>
	</tbody>
</table>
<script type="text/javascript">
$(".helpicon").poshytip({
	className: 'tip-darkgray',
	bgImageFrameSize: 8,
	alignTo: 'target',
	alignX: 'right',
	alignY: 'center',
	offsetX: 10,
	allowTipHover: false,
	slide: false,
	showTimeout : 0
});
</script>