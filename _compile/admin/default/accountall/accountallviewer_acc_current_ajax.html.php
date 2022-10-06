<?php /* Template_ 2.2.6 2022/05/17 12:30:47 /www/music_brother_firstmall_kr/admin/skin/default/accountall/accountallviewer_acc_current_ajax.html 000013839 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){$TPL_I1=-1;foreach($TPL_VAR["loop"] as $TPL_V1){$TPL_I1++;?>
					<tr>
<?php if(!$_GET["account_hidden_sales"]){?>
						<td class="<?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0){?>acc_top<?php }?> acc_bg acc_left"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ea"]> 0){?>-<?php }?><?php echo $TPL_V1["out_ea"]?><!-- 수량 --></td>
						<td nowrap class="right fwbd <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0){?>acc_top<?php }?> acc_bg"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_price"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_price"])?><!-- 판매금액 --></td>
						<td class="right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0){?>acc_top<?php }?> acc_bg">
<?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_salescost_admin"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_salescost_admin"])?><!-- 할인(본사) -->
						</td>
						<td class="right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0){?>acc_top<?php }?> acc_bg">
<?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_pg_sale_price"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_pg_sale_price"])?><!-- 제휴사(무통장:0/pg) -->
						</td>
						<td class="right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0){?>acc_top<?php }?> acc_bg">
<?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_salescost_provider"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_salescost_provider"])?><!-- 할인(입점사) -->
						</td>
						<td class="right fwbd <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0){?>acc_top<?php }?> acc_bg"><?php if(($TPL_V1["minus_sale"]=='1')&&($TPL_V1["total_payprice"])> 0){?>-<?php }?><?php echo number_format($TPL_V1["total_payprice"])?><!-- 결제금액(A) --></td>
						<td class="right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0){?>acc_top<?php }?> acc_bg"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_sale_price"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_sale_price"])?><!-- 실결제액 --></td>
						<td class="right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0){?>acc_top<?php }?> acc_bg acc_right"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_cash_use"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_cash_use"])?><!-- 이머니 --></td>
<?php }?>
<?php if(!$_GET["account_hidden_cal"]){?>
<?php if($TPL_V1["out_ac_acc_status"]=='no_acc'){?>
						<td class=" <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_no_acc_bg cal_left">
						<!-- 정산수량 --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 정산대상(수수료방식) --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 정산대상(수수료방식)-결제금액 --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 정산대상(수수료방식)-본사할인 --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 정산대상(수수료방식)-제휴사할인 --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 정산대상(공급가방식) --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 수수료율(%) --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 수수료 -->
						</td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_no_acc_bg cal_right">
						<!-- 정산금액(B) -->
						</td>
<?php }elseif($TPL_V1["out_ac_acc_status"]=='ing_acc'){?>
						<td class=" <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg cal_left">-
						<!-- 정산수량 --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg">-
						<!-- 정산대상(수수료방식) --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg">-
						<!-- 정산대상(수수료방식)-결제금액 --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg">-
						<!-- 정산대상(수수료방식)-본사할인 --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg">-
						<!-- 정산대상(수수료방식)-제휴사할인 --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg">-
						<!-- 정산대상(공급가방식) --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg">-
						<!-- 수수료율(%) --></td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg">-
						<!-- 수수료 -->
						</td>
						<td class="right <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg cal_right">-
						<!-- 정산금액(B) -->
						</td>
<?php }else{?>
						<td class=" <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg cal_left"><?php if(($TPL_V1["account_type"]=='after_refund'&&$TPL_V1["out_exp_ea"]> 0)){?>-<?php }?><?php echo $TPL_V1["out_exp_ea"]?>

						<!-- 정산수량 --></td>
						<td class="right fwbd <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_total_ac_price"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_total_ac_price"])?>

						<!-- 정산대상(수수료방식) --></td>
						<td class="right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_pg_default_price"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_pg_default_price"])?>

						<!-- 정산대상(수수료방식)-결제금액 --></td>
						<td class="right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg">
<?php if(in_array($TPL_V1["commission_type"],array('SUCO','SUPR'))){?>
								-
<?php }else{?>
<?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ac_salescost_admin"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_ac_salescost_admin"])?>

<?php }?>
						<!-- 정산대상(수수료방식)-본사할인 -->
						</td>
						<td class="right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg">
<?php if(in_array($TPL_V1["commission_type"],array('SUCO','SUPR'))){?>
								-
<?php }else{?>
<?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ac_pg_price"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_ac_pg_price"])?>

<?php }?>
						<!-- 정산대상(수수료방식)-제휴사할인 -->
						</td>
						<td class="
							right  
<?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> 
<?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> 
							cal_bg
							"
						>
							<span 
<?php if(in_array($TPL_V1["commission_type"],array('SUCO','SUPR'))){?>
								style="color:blue;"
<?php }?>
							>
<?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ac_consumer_real_price"]> 0){?>-<?php }?>
							<?php echo number_format($TPL_V1["out_ac_consumer_real_price"])?>

							</span>
							<!-- 정산대상(공급가방식) -->
						</td>
						<td class="
							right
<?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> 
<?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> 
							cal_bg
							"
						>
							<span 
<?php if(in_array($TPL_V1["commission_type"],array('SUCO','SUPR'))){?>
								style="color:blue;"
<?php }?>
							>
<?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ac_fee_rate"]!= 0){?>-<?php }?>
<?php if($TPL_V1["out_ac_fee_rate"]!= 0){?>
								<?php echo $TPL_V1["out_ac_fee_rate"]?>%
<?php }else{?>
							-
<?php }?>
							</span>
							<!-- 수수료율(%) -->
						</td>
						<td class="right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg" title="(<?php echo $TPL_V1["sales_unit_feeprice"]?>*<?php echo $TPL_V1["out_ea"]?>)+<?php echo $TPL_V1["sales_unit_minfee"]?>+<?php echo $TPL_V1["sales_feeprice_rest"]?>"><?php if(($TPL_V1["minus_sale"]=='1')&&($TPL_V1["out_sales_unit_feeprice"])> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_sales_unit_feeprice"])?>

						<!-- 수수료 -->
						</td>
						<td class="right fwbd <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>cal_top<?php }?> cal_bg cal_right"><?php if(($TPL_V1["minus_sale"]=='1')){?>-<?php }?><?php echo number_format($TPL_V1["out_commission_price"])?>

						<!-- 정산금액(B) -->
						<!-- <br/>   (B) : <?php echo number_format($TPL_V1["commission_price"])?>*<?php echo $TPL_V1["out_ea"]?>+<?php echo ($TPL_V1["commission_price_rest"])?> -->
						<!-- p><?php echo number_format(($TPL_V1["out_sales_unit_feeprice"])+($TPL_V1["out_commission_price"]))?></p -->
						<!-- -->
						</td>
<?php }?>
						<td class="right fwbd <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_VAR["current_page"]== 1&&$TPL_I1== 0&&!$TPL_VAR["carryoverloop"]){?>profit_top<?php }?> profit_bg profit_left profit_right"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["ac_type"]!='cal_sales'&&($TPL_V1["status"]=='complete'||$TPL_V1["status"]=='carryover'||$TPL_V1["provider_seq"]=='1'||$TPL_V1["shipping_provider_seq"]=='1')&&$TPL_V1["out_ac_profit_price"]&&$TPL_V1["out_ac_profit_price"]>= 0){?>-<?php }?><?php if($TPL_V1["ac_type"]!='cal_sales'&&($TPL_V1["status"]=='complete'||$TPL_V1["status"]=='carryover'||$TPL_V1["provider_seq"]=='1'||$TPL_V1["shipping_provider_seq"]=='1')){?><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ac_profit_price"]< 0){?><?php echo number_format(( -$TPL_V1["out_ac_profit_price"]))?><?php }else{?><?php echo number_format($TPL_V1["out_ac_profit_price"])?><?php }?><?php }?>
						<!-- 이익금액(C)>(C)=(A)-(B) -->
						</td>
						<td class="right <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?>"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ac_profit_rate"]&&$TPL_V1["out_ac_profit_rate"]> 0){?>-<?php }?><?php if($TPL_V1["out_ac_profit_rate"]!= 0){?><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ac_profit_rate"]< 0){?><?php echo ( -$TPL_V1["out_ac_profit_rate"])?><?php }else{?><?php echo $TPL_V1["out_ac_profit_rate"]?><?php }?>%<?php }?>
						<!-- 이익금액(C)>이익율(%) -->
						</td>
						<td style="display:none;" class="right <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?>"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ac_supply_price"]&&$TPL_V1["out_ac_supply_price"]> 0){?>-<?php }?><?php if($TPL_V1["out_ac_supply_price"]!= 0){?><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ac_supply_price"]< 0){?><?php echo ( -$TPL_V1["out_ac_supply_price"])?><?php }else{?><?php echo $TPL_V1["out_ac_supply_price"]?><?php }?><?php }?>
						<!-- 매입가 -->
						</td>
<?php }?>
						<td class="left"  style=" mso-number-format:'@';" title="<?php echo $TPL_V1["out_pg_ordernum"]?>"><?php echo getstrcut($TPL_V1["out_pg_ordernum"], 24)?>	<!-- <br/><?php echo $TPL_V1["order_seq"]?> --></td>
						<td><?php echo $TPL_V1["out_order_referer_viewer"]?></td>
						<td title="<?php echo $TPL_V1["out_payment"]?>"><?php echo getstrcut($TPL_V1["out_payment"], 6)?></td>
					</tr>
<?php }}?>
<?php }?>
					
					<script>
						$("#current_page").val('<?php echo $TPL_VAR["current_page"]+ 1?>');
						$("#current_last_num").val('<?php echo $TPL_VAR["current_out_num"]?>');
					</script>