<?php /* Template_ 2.2.6 2022/05/17 12:36:37 /www/music_brother_firstmall_kr/admin/skin/default/order/cart_new.html 000016841 */  $this->include_("snsLikeButton");
$TPL_shipping_cart_list_1=empty($TPL_VAR["shipping_cart_list"])||!is_array($TPL_VAR["shipping_cart_list"])?0:count($TPL_VAR["shipping_cart_list"]);?>
<?php if($TPL_VAR["shipping_cart_list"]){?>
<?php if($TPL_shipping_cart_list_1){foreach($TPL_VAR["shipping_cart_list"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>

<div class="tmp_cart_item <?php echo $TPL_V2["list_key"]?>" list_num="<?php echo $_GET['list_num']?>" >

	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table_style" style="border-top:0px;border-bottom:1px solid #ddd;">
		<colgroup>
			<col width="30" />
			<col width="" />
			<col width="70" />
			<col width="90" />
			<col width="90" />
			<col width="90" />
			<col width="90" />
		</colgroup>
	<tbody>
	<tr class="cartlist">
		<td class="cell" height="60">
			<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?> goods" goods_seq="<?php echo $TPL_V2["goods_seq"]?>" opt_num="<?php echo $TPL_K2?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][option][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V2["option1"])?>" />
			<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][optionTitle][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V2["title1"])?>" />

<?php if($TPL_V2["option2"]){?>
			<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][option][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V2["option2"])?>" />
			<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][optionTitle][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V2["title2"])?>" />
<?php }?>
<?php if($TPL_V2["option3"]){?>
			<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][option][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V2["option3"])?>" />
			<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][optionTitle][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V2["title3"])?>" />
<?php }?>
<?php if($TPL_V2["option4"]){?>
			<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][option][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V2["option4"])?>" />
			<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][optionTitle][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V2["title4"])?>" />
<?php }?>
<?php if($TPL_V2["option5"]){?>
			<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][option][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V2["option5"])?>" />
			<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][optionTitle][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V2["title5"])?>" />
<?php }?>

			<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][optionEa][<?php echo $TPL_K2?>]" value="<?php echo $TPL_V2["ea"]?>" />

			<input type="hidden" name="cartOptionSeq[<?php echo $TPL_V2["cart_seq"]?>][]" value="<?php echo $TPL_V2["cart_option_seq"]?>" />
			<!--<img src="/admin/skin/default/images/design/icon_del_detail.gif" style="cursor:pointer;" onclick="cart_delete('<?php echo $TPL_V2["cart_seq"]?>','<?php echo $TPL_V2["cart_option_seq"]?>');">-->

			<img src="/admin/skin/default/images/design/icon_del_detail.gif" style="cursor:pointer;" onclick="cart_delete('<?php echo $TPL_V2["cart_seq"]?>','<?php echo $TPL_V2["list_key"]?>');">

		</td>
		<td class="cell rborder">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td class="left" width="80" valign="top">
					<a href="/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>" target="_blank"><img src="<?php echo $TPL_V2["image"]?>" align="absmiddle" hspace="5" style="border:1px solid #ddd;" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif'" width="60" /></a>
				</td>
				<td class="left"  valign="top">
					<div class="goods_name">
<?php if(serviceLimit('H_AD')){?>
						[<?php echo $TPL_V2["provider_name"]?>]
<?php }?>
						<a href="../goods/regist?no=<?php echo $TPL_V2["goods_seq"]?>" title="<?php echo $TPL_V2["goods_name"]?>" target="_blank"><?php echo $TPL_V2["goods_name"]?></a>
					</div>

					<div>
<?php if($TPL_V2["adult_goods"]=='Y'){?>
						<img src="/admin/skin/default/images/common/auth_img.png" alt="성인" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V2["option_international_shipping_status"]=='y'){?>
						<img src="/admin/skin/default/images/common/icon/plane_on.png" alt="해외배송상품" style="vertical-align: middle;" height="19" />
<?php }?>
<?php if($TPL_V2["cancel_type"]=='1'){?>
						<img src="/admin/skin/default/images/common/icon/nocancellation.gif" alt="청약철회" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V2["tax"]=='exempt'){?>
						<img src="/admin/skin/default/images/common/icon/taxfree.gif" alt="비과세" style="vertical-align: middle;"/>
<?php }?>
					</div>

<?php if($TPL_V2["eventEnd"]){?>
					<div class="cart_soloEventTd<?php echo $TPL_V2["list_key"]?>" style="font-face:Dotum; font-size:11px;">
						<img src="/admin/skin/default/images/common/icon_clock.gif" style="padding-bottom:2px;">남은시간
						<span style="background-color:#c61515; color:#ffffff; padding:2px; font-weight:bold;">
						<span id="cart_soloday<?php echo $TPL_V2["list_key"]?>" style="color:#ffffff; font-weight:bold;">0</span>일
						<span id="cart_solohour<?php echo $TPL_V2["list_key"]?>" style="color:#ffffff; font-weight:bold;">00</span>:
						<span id="cart_solomin<?php echo $TPL_V2["list_key"]?>" style="color:#ffffff; font-weight:bold;">00</span>:
						<span id="cart_solosecond<?php echo $TPL_V2["list_key"]?>" style="color:#ffffff; font-weight:bold;">00</span>
						</span>
					</div>
					<script>
						$(function() {
							timeInterval<?php echo $TPL_V2["list_key"]?> = setInterval(function(){
								var time<?php echo $TPL_V2["list_key"]?> = showClockTime('text', '<?php echo $TPL_V2["eventEnd"]["year"]?>', '<?php echo $TPL_V2["eventEnd"]["month"]?>', '<?php echo $TPL_V2["eventEnd"]["day"]?>', '<?php echo $TPL_V2["eventEnd"]["hour"]?>', '<?php echo $TPL_V2["eventEnd"]["min"]?>', '<?php echo $TPL_V2["eventEnd"]["second"]?>', 'cart_soloday<?php echo $TPL_V2["list_key"]?>', 'cart_solohour<?php echo $TPL_V2["list_key"]?>', 'cart_solomin<?php echo $TPL_V2["list_key"]?>', 'cart_solosecond<?php echo $TPL_V2["list_key"]?>', '<?php echo $TPL_V2["list_key"]?>');
								if(time<?php echo $TPL_V2["list_key"]?> == 0){
									clearInterval(timeInterval<?php echo $TPL_V2["list_key"]?>);
									$(".cart_soloEventTd<?php echo $TPL_V2["list_key"]?>").html("단독 이벤트 종료");
								}
							},1000);
						});
					</script>
<?php }?>

<?php if($TPL_V2["option1"]!=null){?>
					<div class="goods_option">
						<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php if($TPL_V2["title1"]){?><?php echo $TPL_V2["title1"]?>:<?php }?><?php echo $TPL_V2["option1"]?>

<?php if($TPL_V2["option2"]!=null){?><?php if($TPL_V2["title2"]){?><?php echo $TPL_V2["title2"]?>:<?php }?><?php echo $TPL_V2["option2"]?> <?php }?>
<?php if($TPL_V2["option3"]!=null){?><?php if($TPL_V2["title3"]){?><?php echo $TPL_V2["title3"]?>:<?php }?><?php echo $TPL_V2["option3"]?> <?php }?>
<?php if($TPL_V2["option4"]!=null){?><?php if($TPL_V2["title4"]){?><?php echo $TPL_V2["title4"]?>:<?php }?><?php echo $TPL_V2["option4"]?> <?php }?>
<?php if($TPL_V2["option5"]!=null){?><?php if($TPL_V2["title5"]){?><?php echo $TPL_V2["title5"]?>:<?php }?><?php echo $TPL_V2["option5"]?> <?php }?>
					</div>
<?php }?>
<?php if($TPL_V2["cart_inputs"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["cart_inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["input_value"]){?>
							<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][inputsType][<?php echo $TPL_K2?>][]" value="<?php echo $TPL_V3["type"]?>" />
							<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][inputsTitle][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V3["input_title"])?>" />
							<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][inputsValue][<?php echo $TPL_K2?>][]" value="<?php if($TPL_V3["type"]=='file'&&strstr($TPL_V3["input_img_path"],'tmp')){?><?php echo ($TPL_V3["input_img_path"])?><?php }?><?php echo ($TPL_V3["input_value"])?>" />
							<div class="goods_input">
								<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V3["type"]=='file'){?>
<?php if($TPL_V3["input_title"]){?><?php echo $TPL_V3["input_title"]?>:<?php }?> <img src="/<?php echo $TPL_V3["input_img_path"]?><?php echo $TPL_V3["input_value"]?>" width="13" height="13" title="크게 보기" align="absmiddle" /> <span class="desc"><?php echo $TPL_V3["input_value"]?></span></a>
<?php }else{?>
<?php if($TPL_V3["input_title"]){?><?php echo $TPL_V3["input_title"]?>:<?php }?><?php echo $TPL_V3["input_value"]?>

<?php }?>
							</div>
<?php }?>
<?php }}?>
<?php }?>
<?php if($TPL_VAR["cfg"]["order"]["fblike_ordertype"]&&$TPL_VAR["fblikesale"]){?>
					<div class="fblikelay" style="padding-top:10px">
						<?php echo snsLikeButton($TPL_V2["goods_seq"],'button_count')?>

					</div>
<?php }?>
				</td>
			</tr>
			</table>
		</td>
		<td class="cell rborder">
			<div><?php echo number_format($TPL_V2["ea"])?></div>
			<div><img src="/admin/skin/default/images/design/btn_change.gif" onclick="option_modify('<?php echo $TPL_V2["cart_option_seq"]?>','<?php echo $_GET["cart_table"]?>', '<?php echo $TPL_V2["goods_seq"]?>','tmp_cart<?php echo $TPL_V2["list_key"]?>','<?php if($_GET["old_option_seq"]){?>order<?php }else{?>tmp<?php }?>');" style="cursor:pointer;" /></div>
		</td>
		<td class="cell right rborder"><span><?php echo get_currency_price($TPL_V2["price"]*$TPL_V2["ea"])?></span><?php echo $TPL_VAR["basic_currency"]?></td>
		<td class="cell center rborder">
			<div>
<?php if($TPL_V2["sales"]["total_sale_price"]> 0){?>
				<?php echo get_currency_price($TPL_V2["sales"]["total_sale_price"], 3)?>

<?php }else{?>
				-
<?php }?>
			</div>
			<div <?php if($TPL_V2["sales"]["total_sale_price"]> 0){?><?php }else{?>class="hide"<?php }?>>
				<img src="/admin/skin/default/images/common/icon_dc_list.gif" alt="할인내역" class="price_area" class="hand" onmouseover="open_sale_price_layer(this);" onmouseout="close_sale_price_layer(this);" />
				<div class="absolute">
					<div class="sale_price_layer hide" style="width:200px;">
						<div class="title_line">할인내역</div>
						<br style="line-height:10px;" />
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<col width="78" />
						<tr>
							<th>구분</th>
							<th class="bolds ends">할인</th>
						</tr>
<?php if(is_array($TPL_R3=$TPL_V2["sales"]["title_list"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
						<tr <?php if($TPL_V2["sales"]["sale_list"][$TPL_K3]> 0){?><?php }else{?>class="hide"<?php }?>>
							<td class="gr"><?php echo $TPL_V2["sales"]["title_list"][$TPL_K3]?></td>
							<td class="bolds ends prices">
								<span><?php echo get_currency_price($TPL_V2["sales"]["sale_list"][$TPL_K3])?></span><?php echo $TPL_VAR["basic_currency"]?>

							</td>
						</tr>
<?php }}?>
						</table>
					</div>
				</div>
			</div>
		</td>
		<td class="cell right rborder">
			<span><?php echo get_currency_price($TPL_V2["sales"]["result_price"])?></span><?php echo $TPL_VAR["basic_currency"]?>

		</td>
		<td class="cell rborder">
			<table align="center" border="0">
			<col />
			<col width="50" />
			<tr>
				<td><img src="/admin/skin/default/images/common/icon/icon_ord_emn.gif" title="캐시" /></td>
				<td class="right"><span ><?php echo get_currency_price($TPL_V2["reserve"])?></span><?php echo $TPL_VAR["basic_currency"]?></td>
			</tr>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
			<tr>
				<td><img src="/admin/skin/default/images/common/icon/icon_ord_point.gif" title="포인트" /></td>
				<td class="right"><span ><?php echo get_currency_price($TPL_V2["point"])?></span>P</td>
			</tr>
<?php }?>
			</table>
		</td>
	</tr>
<?php if(is_array($TPL_R3=$TPL_V2["cart_suboptions"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
	<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][suboptionTitle][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V3["suboption_title"])?>" />
	<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][suboption][<?php echo $TPL_K2?>][]" value="<?php echo ($TPL_V3["suboption"])?>" />
	<input type="hidden" class="tmp_cart<?php echo $TPL_V2["list_key"]?>" name="goods[<?php echo $TPL_V2["goods_seq"]?>][suboptionEa][<?php echo $TPL_K2?>][]" value="<?php echo $TPL_V3["ea"]?>" />

	<tr class="cartlist <?php echo $TPL_V2["cart_option_seq"]?>" cart_opt_seq="<?php echo $TPL_V2["cart_option_seq"]?>">
		<td class="cell sub_bg"></td>
		<td class="cell sub_bg rborder">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td class="right" width="80">
					<div style="padding-right:5px;"><img src="/admin/skin/default/images/common/icon_add_arrow.gif" /></div>
				</td>
				<td class="left"  valign="top">
					<img src="/admin/skin/default/images/common/icon_add.gif" />
<?php if($TPL_V3["suboption"]){?>
<?php if($TPL_V3["suboption_title"]){?><?php echo $TPL_V3["suboption_title"]?>:<?php }?><?php echo $TPL_V3["suboption"]?>

<?php }?>
				</td>
			</tr>
			</table>
		</td>
		<td class="cell sub_bg rborder"><div><?php echo number_format($TPL_V3["ea"])?></div></td>
		<td class="cell sub_bg right rborder"><?php echo get_currency_price($TPL_V3["price"]*$TPL_V3["ea"], 3)?></td>
		<td class="cell sub_bg center rborder">
			<div >
<?php if($TPL_V3["sales"]["total_sale_price"]> 0){?>
				<?php echo get_currency_price($TPL_V3["sales"]["total_sale_price"], 3)?>

<?php }else{?>
				-
<?php }?>
			</div>
			<div <?php if($TPL_V3["sales"]["total_sale_price"]> 0){?><?php }else{?>class="hide"<?php }?>>
				<img src="/admin/skin/default/images/common/icon_dc_list.gif" alt="할인내역" class="price_area" class="hand"  onmouseover="open_sale_price_layer(this);" onmouseout="close_sale_price_layer(this);" />
				<div class="absolute">
					<div class="sale_price_layer hide" style="width:200px;">
						<div class="title_line">할인내역</div>
						<br style="line-height:10px;" />
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<col width="78" />
						<tr>
							<th>구분</th>
							<th class="bolds ends">할인</th>
						</tr>
<?php if(is_array($TPL_R4=$TPL_V3["sales"]["sale_list"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?>
						<tr bgcolor="#ffffff" height="25" <?php if($TPL_V4> 0){?><?php }else{?>class="hide"<?php }?>>
							<td class="gr"><?php echo $TPL_V3["sales"]["title_list"][$TPL_K4]?></td>
							<td class="bolds ends prices">
								<span ><?php echo get_currency_price($TPL_V4)?></span><?php echo $TPL_VAR["basic_currency"]?>

							</td>
						</tr>
<?php }}?>
						</table>
					</div>
				</div>
			</div>
		</td>
		<td class="cell sub_bg right rborder">
			<span ><?php echo get_currency_price($TPL_V3["sales"]["result_price"])?></span><?php echo $TPL_VAR["basic_currency"]?>

		</td>
		<td class="cell sub_bg rborder">
			<table align="center" border="0">
			<col />
			<col width="50" />
			<tr>
				<td><img src="/admin/skin/default/images/common/icon/icon_ord_emn.gif" title="캐시" /></td>
				<td class="right"><span ><?php echo get_currency_price($TPL_V3["reserve"])?></span><?php echo $TPL_VAR["basic_currency"]?></td>
			</tr>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
			<tr>
				<td><img src="/admin/skin/default/images/common/icon/icon_ord_point.gif" title="포인트" /></td>
				<td class="right"><span ><?php echo get_currency_price($TPL_V3["point"])?></span>P</td>
			</tr>
<?php }?>
			</table>
		</td>
	</tr>
<?php }}?>
	</tbody>
	</table>
</div>
<?php }}?>
<?php }}?>

<?php }?>