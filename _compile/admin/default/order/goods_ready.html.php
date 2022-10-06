<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/order/goods_ready.html 000016094 */ 
$TPL_shipping_group_items_1=empty($TPL_VAR["shipping_group_items"])||!is_array($TPL_VAR["shipping_group_items"])?0:count($TPL_VAR["shipping_group_items"]);?>
<script type="text/javascript">
$(document).ready(function(){

	// 전체 체크
	$("input[name='allReadyCheck']").click(function(){
		var chk	= false;
		if	($(this).attr('checked'))	chk		= true;

		$("input[name='optionSeq[]']").each(function(){
			if ( $(this).attr("disabled") != "disabled" ) {
				$(this).attr('checked', chk);
			}
		});
		$("input[name='suboptionSeq[]']").each(function(){
			if ( $(this).attr("disabled") != "disabled"  ) {
				$(this).attr('checked', chk);
			}
		});
	});

	// 상품준비 처리 submit
	$("button.set-goods-ready").click(function(){
		chk		= false;
		$("input[name='optionSeq[]']").each(function(){
			if	($(this).attr('checked')){
				chk		= true;
				return;
			}
		});

		if	(!chk){
			$("input[name='suboptionSeq[]']").each(function(){
				if	($(this).attr('checked')){
					chk		= true;
					return;
				}
			});
		}

		if	(!chk){
			openDialogAlert("상품이 선택되지 않았습니다.", 400,150);
			return;
		}

		$("form#goods_ready_frm").submit();
	});
});
</script>

<form name="goods_ready_frm" id="goods_ready_frm" method="post" action="../order_process/goods_ready" target="actionFrame" onsubmit="loadingStart();">
<input name="order_seq" type="hidden" value="<?php echo $TPL_VAR["orders"]["order_seq"]?>" / >

	<div style="margin:0 0 10px 0;">주문번호 : <?php echo $TPL_VAR["orders"]["order_seq"]?></div>
	<div style="margin:0 0 20px 0; border:2px solid #000; padding:15px;">

		<table class="order-summary-table" width="100%" border=0>
		<colgroup>
			<col width="3%" /><!--체크-->
			<col /><!--주문상품-->
			<col width="5%" /><!--수량-->
			<col width="5%" /><!--결제확인-->
			<col width="5%" /><!--상품준비-->
			<col width="5%" /><!--출고준비-->
			<col width="5%" /><!--출고완료-->
			<col width="5%" /><!--배송중-->
			<col width="5%" /><!--취소-->
			<col width="5%" /><!--배송완료-->
			<col width="8%" /><!--상품상태-->
		</colgroup>
		<thead class="oth">
			<tr>
				<th><input type="checkbox" name="allReadyCheck" value="y" /></th>
				<th class="dark">주문상품</th>
				<th class="dark">수량</th>
				<th class="dark">결제<br />확인</th>
				<th class="dark">상품<br />준비</th>
				<th class="dark">출고<br />준비</th>
				<th class="dark">출고<br />완료</th>
				<th class="dark">배송<br/>중</th>
				<th class="dark">배송<br />완료</th>
				<th class="dark">취소<br /><span class="helpicon" title="[주문상품 기준 합계]<br />결제취소"></span></th>
				<th class="dark">상품상태</th>
			</tr>
		</thead>


	<tbody class="otb">
<?php if($TPL_shipping_group_items_1){foreach($TPL_VAR["shipping_group_items"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["items"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if(is_array($TPL_R3=$TPL_V2["options"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V2["goods_type"]=='gift'){?>
		<tr class="order-item-row" bgcolor="#f6f6f6">
<?php }else{?>
		<tr class="order-item-row">
<?php }?>
			<td class="info center"><input type="checkbox" name="optionSeq[]" value="<?php echo $TPL_V3["item_option_seq"]?>" <?php if($TPL_V3["step"]!= 25){?>disabled<?php }?> /></td>
			<td class="info">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<col width="40" /><col />
				<tr>
					<td class="left" valign="top" style="border:none;">
<?php if($TPL_V2["goods_type"]=='gift'){?>
						<span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V2["image"]?>" /></span>
<?php }else{?>
						<a href='/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>' target='_blank'><span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V2["image"]?>" /></span></a>
<?php }?>
					</td>
					<td class="left" valign="top" style="border:none;">
						<div class="goods_name">
<?php if($TPL_V2["goods_type"]=='gift'){?>
							<img src="/admin/skin/default/images/common/icon_gift.gif" align="absmiddle" />
<?php }?>
<?php if($TPL_V2["goods_kind"]=='coupon'){?>
							<a href='../goods/social_regist?no=<?php echo $TPL_V2["goods_seq"]?>' target='_blank'>
<?php }elseif($TPL_V2["goods_type"]=='gift'){?>
							<a href='../goods/gift_regist?no=<?php echo $TPL_V2["goods_seq"]?>' target='_blank'>
<?php }else{?>
							<a href='../goods/regist?no=<?php echo $TPL_V2["goods_seq"]?>' target='_blank'>
<?php }?>
								<span class="goods_name1" style="color:#000000;">
<?php if($TPL_V2["cancel_type"]=='1'){?>
									<span class="order-item-cancel-type " >[청약철회불가]</span>
<?php }?>
								<?php echo $TPL_V2["goods_name"]?>

								</span>
							</a>
<?php if($TPL_V2["adult_goods"]=='Y'){?>
							<img src="/admin/skin/default/images/common/auth_img.png" alt="성인인증상품" title="성인인증상품" style="vertical-align: middle;"/>
<?php }?>
						</div>
<?php if($TPL_V2["event_seq"]&&$TPL_V2["event_title"]){?>
							<a href="/admin/event/<?php if($TPL_V2["event_type"]=='solo'){?>solo<?php }?>regist?event_seq=<?php echo $TPL_V2["event_seq"]?>" target='_blank'><span class="btn small gray"><button type="button" class="goods_event hand"><?php echo $TPL_V2["event_title"]?></button></span></a>
<?php }?>
<?php if($TPL_V3["option1"]!=null){?>
						<div class="goods_option">
							<img src="/admin/skin/default/images/common/icon_option.gif" align="absmiddle" />
<?php if($TPL_V3["title1"]){?><?php echo $TPL_V3["title1"]?>:<?php }?><?php echo $TPL_V3["option1"]?>

<?php if($TPL_V3["option2"]!=null){?><?php if($TPL_V3["title2"]){?><?php echo $TPL_V3["title2"]?>:<?php }?><?php echo $TPL_V3["option2"]?><?php }?>
<?php if($TPL_V3["option3"]!=null){?><?php if($TPL_V3["title3"]){?><?php echo $TPL_V3["title3"]?>:<?php }?><?php echo $TPL_V3["option3"]?><?php }?>
<?php if($TPL_V3["option4"]!=null){?><?php if($TPL_V3["title4"]){?><?php echo $TPL_V3["title4"]?>:<?php }?><?php echo $TPL_V3["option4"]?><?php }?>
<?php if($TPL_V3["option5"]!=null){?><?php if($TPL_V3["title5"]){?><?php echo $TPL_V3["title5"]?>:<?php }?><?php echo $TPL_V3["option5"]?><?php }?>
						</div>
<?php if($TPL_V3["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V3["goods_code"]?>]</div><?php }?>
<?php }else{?>
<?php if($TPL_V3["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V3["goods_code"]?>]</div><?php }?>
<?php }?>
<?php if($TPL_V3["inputs"]){?>
<?php if(is_array($TPL_R4=$TPL_V3["inputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
<?php if($TPL_V4["value"]){?>
						<div class="goods_input">
							<img src="/admin/skin/default/images/common/icon_input.gif" align="absmiddle" />
<?php if($TPL_V4["title"]){?><?php echo $TPL_V4["title"]?>:<?php }?>
<?php if($TPL_V4["type"]=='file'){?>
							<a href="../order_process/filedown?file=<?php echo $TPL_V4["value"]?>" target="actionFrame"><?php echo $TPL_V4["value"]?></a>
<?php }else{?><?php echo $TPL_V4["value"]?><?php }?>
						</div>
<?php }?>
<?php }}?>
<?php }?>



					</td>
				</tr>
				</table>
			</td>
			<td class="price info ea"><?php echo $TPL_V3["ea"]?></td>


			<td class="info ea" align="center"><?php echo number_format($TPL_V3["step25"])?></td>
			<td class="info ea" align="center"><?php echo number_format($TPL_V3["step35"])?></td>
			<td class="info ea" align="center"><?php echo number_format($TPL_V3["step45"])?></td>
			<td class="info ea" align="center"><?php echo number_format($TPL_V3["step55"])?></td>
			<td class="info ea" align="center"><?php echo number_format($TPL_V3["step65"])?></td>
			<td align="center" class="info ea">
				<?php echo $TPL_V3["step75"]?>

<?php if($TPL_V3["cancel_list_ea"]||$TPL_V3["exchange_list_ea"]||$TPL_V3["return_list_ea"]||$TPL_V3["refund_list_ea"]){?>
				<div>
<?php if($TPL_V3["exchange_list_ea"]){?>
					<a href="/admin/returns/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return_exchange.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V3["exchange_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V3["return_list_ea"]){?>
					<a href="/admin/returns/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V3["return_list_ea"]?></span></a>
					<a href="/admin/refund/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_refund.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V3["return_list_ea"]?></span></a>
<?php }?>
				</div>
<?php }?>
			</td>
			<td class="info ea" align="center"><?php echo $TPL_V3["step85"]?></td>
			<td class="info" align="center">
<?php if($TPL_V3["step"]<= 45||$TPL_V3["step"]> 75){?>
					<?php echo $TPL_V3["mstep"]?>

<?php }else{?>
				<div class="under_div_view hand underline">
					<?php echo $TPL_V3["mstep"]?>

					<div class="absolute hide under_div_view_contents">

						<div class="sale_price_layer" style="width:150px;">
							<div class="title_line">배송내역</div>
							<br style="line-height:10px;" />
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<col width="70" />
							<col width="70" />
							<col />
							<tr>
								<th>구분</th>
								<th class="bolds ends">수량</th>
							</tr>
							<tr>
								<td class="gr">택배선불</td>
								<td class="bolds  prices ends">
									<?php echo number_format($TPL_V3["export_sum_ea"]["delivery"])?>

								</td>
							</tr>
							<tr>
								<td class="gr">택배착불</td>
								<td class="bolds  prices ends">
									<?php echo number_format($TPL_V3["export_sum_ea"]["postpaid"])?>

								</td>
							</tr>
							<tr>
								<td class="gr">퀵서비스</td>
								<td class="bolds  prices ends">
									<?php echo number_format($TPL_V3["export_sum_ea"]["quick"])?>

								</td>
							</tr>
							<tr>
								<td class="gr">직접수령</td>
								<td class="bolds  prices ends">
									<?php echo number_format($TPL_V3["export_sum_ea"]["direct"])?>

								</td>
							</tr>
							</table>
						</div>

					</div>
				</div>
<?php }?>
				<!-- <?php if($TPL_V2["goods_kind"]=='coupon'&&$TPL_V3["step"]>= 55){?> -->
				<span class="btn"><img src="/admin/skin/default/images/common/btn_ok_use.gif" class="coupon_use_btn" /></span>
				<!-- <?php }?> -->
			</td>

		</tr>
<?php if(is_array($TPL_R4=$TPL_V3["suboptions"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
		<tr class="order-item-row">
			<td class="info center"><input type="checkbox" name="suboptionSeq[]" value="<?php echo $TPL_V4["item_suboption_seq"]?>" <?php if($TPL_V4["step"]!= 25){?>disabled<?php }?> /></td>
			<td class="info suboption">
<?php if($TPL_V4["suboption"]){?>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<col width="40" /><col />
					<tr>
						<td valign="top" align="right" style="border:none;height:10px;"><img src="/admin/skin/default/images/common/icon_add_arrow.gif" /></td>
						<td valign="top" style="border:none;height:10px;">
							<img src="/admin/skin/default/images/common/icon_add.gif" align="absmiddle" />
							<span class="desc"><?php echo $TPL_V4["title"]?>:<?php echo $TPL_V4["suboption"]?></span>
<?php if($TPL_V4["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V4["goods_code"]?>]</div><?php }?>
						</td>
					</tr>
				</table>
<?php }?>
			</td>
			<td class="price info suboption ea"><?php echo number_format($TPL_V4["ea"])?></td>


			<td class="info suboption ea" align="center"><?php echo number_format($TPL_V4["step25"])?></td>
			<td class="info suboption ea" align="center"><?php echo number_format($TPL_V4["step35"])?></td>
			<td class="info suboption ea" align="center"><?php echo number_format($TPL_V4["step45"])?></td>
			<td class="info suboption ea" align="center"><?php echo number_format($TPL_V4["step55"])?></td>
			<td class="info suboption ea" align="center"><?php echo number_format($TPL_V4["step65"])?></td>
			<td class="info suboption ea" align="center">
				<?php echo $TPL_V4["step75"]?>

<?php if($TPL_V4["cancel_list_ea"]||$TPL_V4["exchange_list_ea"]||$TPL_V4["return_list_ea"]||$TPL_V4["refund_list_ea"]){?>
				<div>
<?php if($TPL_V4["exchange_list_ea"]){?>
					<a href="/admin/returns/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return_exchange.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V4["exchange_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V4["return_list_ea"]){?>
					<a href="/admin/returns/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V4["return_list_ea"]?></span></a>
					<a href="/admin/refund/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_refund.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V4["return_list_ea"]?></span></a>
<?php }?>
				</div>
<?php }?>
			</td>
			<td class="info suboption ea" align="center"><?php echo $TPL_V4["step85"]?></td>
			<td class="info suboption" align="center">
<?php if($TPL_V4["step"]<= 45||$TPL_V4["step"]> 75){?>
					<?php echo $TPL_V4["mstep"]?>

<?php }else{?>
					<div class="under_div_view underline hand">
						<?php echo $TPL_V4["mstep"]?>

						<div class="absolute hide under_div_view_contents">
							<div class="sale_price_layer" style="width:150px;">
								<div class="title_line">배송내역</div>
								<br style="line-height:10px;" />
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<col width="70" />
								<col width="70" />
								<col />
								<tr>
									<th>구분</th>
									<th class="bolds ends">수량</th>
								</tr>
								<tr>
									<td class="gr">택배선불</td>
									<td class="bolds  prices ends">
										<?php echo number_format($TPL_V4["export_sum_ea"]["delivery"])?>

									</td>
								</tr>
								<tr>
									<td class="gr">택배착불</td>
									<td class="bolds  prices ends">
										<?php echo number_format($TPL_V4["export_sum_ea"]["postpaid"])?>

									</td>
								</tr>
								<tr>
									<td class="gr">퀵서비스</td>
									<td class="bolds  prices ends">
										<?php echo number_format($TPL_V4["export_sum_ea"]["quick"])?>

									</td>
								</tr>
								<tr>
									<td class="gr">직접수령</td>
									<td class="bolds  prices ends">
										<?php echo number_format($TPL_V4["export_sum_ea"]["direct"])?>

									</td>
								</tr>
								</table>
							</div>
						</div>
					</div>
<?php }?>
			</td>
		</tr>
<?php }}?>
<?php }}?>
<?php }}?>
<?php }}?>

		</tbody>
	</table>
	</div>

	<div style="margin-bottom:30px;text-align:center;">
		<div>해당 주문건의 결제확인 주문수량을 → 상품준비로 변경하시겠습니까?</div>
		<div class="pdt10"><span class="btn large black"><button type="button" class="set-goods-ready">상품준비 처리</button></span></div>
	</div>
</form>