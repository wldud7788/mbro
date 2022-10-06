<?php /* Template_ 2.2.6 2022/05/17 12:28:49 /www/music_brother_firstmall_kr/selleradmin/skin/default/accountall/accountallviewer_acc_carry_ajax.html 000011095 */ 
$TPL_carryoverloop_1=empty($TPL_VAR["carryoverloop"])||!is_array($TPL_VAR["carryoverloop"])?0:count($TPL_VAR["carryoverloop"]);?>
<?php if($TPL_VAR["carryoverloop"]){?>
<?php if($TPL_carryoverloop_1){$TPL_I1=-1;foreach($TPL_VAR["carryoverloop"] as $TPL_V1){$TPL_I1++;?>
					<tr>
<?php if(!$_GET["account_hidden_sales"]){?>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ea"]> 0){?>-<?php }?><?php echo $TPL_V1["out_ea"]?><!-- 판매수량 --></td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?> right fwbd <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?>"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_price"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_price"])?><!-- 판매금액 --></td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?> right <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?>"><!-- 할인(본사) -->
<?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_salescost_admin"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_salescost_admin"])?>

						</td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>  right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?>"><!-- 제휴사(무통장:0/pg) -->
<?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_pg_sale_price"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_pg_sale_price"])?>

						</td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?> right <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?>"><!-- 할인(입점사) -->
<?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_salescost_provider"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_salescost_provider"])?>

						</td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>  right fwbd <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?>"><?php if(($TPL_V1["minus_sale"]=='1')&&($TPL_V1["total_payprice"])> 0){?>-<?php }?><?php echo number_format($TPL_V1["total_payprice"])?><!-- 결제금액(A) --></td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>  right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?>"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_sale_price"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_sale_price"])?><!-- 실결제액 --></td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>  right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?>"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_cash_use"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_cash_use"])?><!-- 이머니 --></td>
<?php }?>
<?php if(!$_GET["account_hidden_cal"]){?>
<?php if($TPL_V1["out_ac_acc_status"]=='no_acc'){?>
						<td class=" <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_no_acc_bg cal_left">
						<!-- 정산수량 --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 정산대상금액 --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 정산대상-결제금액 --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 정산대상-본사할인 --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 정산대상-제휴사할인 --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 공급금액 --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 수수료율(%) --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_no_acc_bg">
						<!-- 수수료 -->
						</td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_no_acc_bg cal_right">
						<!-- 정산금액(B) -->
						</td>
<?php }elseif($TPL_V1["out_ac_acc_status"]=='ing_acc'){?>
						<td class=" <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg cal_left">-
						<!-- 정산수량 --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg">-
						<!-- 정산대상(수수료방식) --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg">-
						<!-- 정산대상(수수료방식)-결제금액 --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg">-
						<!-- 정산대상(수수료방식)-본사할인 --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg">-
						<!-- 정산대상(수수료방식)-제휴사할인 --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg">-
						<!-- 정산대상(공급가방식) --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg">-
						<!-- 수수료율(%) --></td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg">-
						<!-- 수수료 -->
						</td>
						<td class="right <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg cal_right">-
						<!-- 정산금액(B) -->
						</td>
<?php }else{?>
						<td class="center <?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg cal_left"><?php echo $TPL_V1["out_exp_ea"]?>

						<!-- 정산수량 --></td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>  right fwbd <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_total_ac_price"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_total_ac_price"])?>

						<!-- 정산대상(수수료방식) --></td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>  right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg"><?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_pg_default_price"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_pg_default_price"])?>

						<!-- 정산대상(수수료방식)-결제금액 --></td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>  right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg">
<?php if(in_array($TPL_V1["commission_type"],array('SUCO','SUPR'))){?>
								-
<?php }else{?>
<?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ac_salescost_admin"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_ac_salescost_admin"])?>

<?php }?>
						<!-- 정산대상(수수료방식)-본사할인 -->
						</td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>  right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg">
<?php if(in_array($TPL_V1["commission_type"],array('SUCO','SUPR'))){?>
								-
<?php }else{?>
<?php if(($TPL_V1["minus_sale"]=='1')&&$TPL_V1["out_ac_pg_price"]> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_ac_pg_price"])?>

<?php }?>
						<!-- 정산대상(수수료방식)-제휴사할인 -->
						</td>
						<td class="
<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>  
							right  
<?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> 
<?php if($TPL_I1== 0){?>cal_top<?php }?> 
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
<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>
							right 
<?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?>
<?php if($TPL_I1== 0){?>cal_top<?php }?>
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
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>  right  <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg" title="(<?php echo $TPL_V1["sales_unit_feeprice"]?>*<?php echo $TPL_V1["out_ea"]?>)+<?php echo $TPL_V1["sales_unit_minfee"]?>+<?php echo $TPL_V1["sales_feeprice_rest"]?>"><?php if(($TPL_V1["minus_sale"]=='1')&&($TPL_V1["out_sales_unit_feeprice"])> 0){?>-<?php }?><?php echo number_format($TPL_V1["out_sales_unit_feeprice"])?>

						<!-- 수수료 -->
						</td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>  right fwbd <?php if(($TPL_V1["minus_sale"]=='1')){?>red<?php }?> <?php if($TPL_I1== 0){?>cal_top<?php }?> cal_bg cal_right"><?php if($TPL_V1["account_type"]=='refund'){?>-<?php }?><?php echo number_format($TPL_V1["out_commission_price"])?>

						<!-- 정산금액(B) -->
							<!-- (B) : <?php echo number_format($TPL_V1["commission_price"])?>*<?php echo $TPL_V1["out_ea"]?>+<?php echo number_format($TPL_V1["commission_price_rest"])?>  -->
							 <!-- p>
								<?php echo number_format(($TPL_V1["out_sales_unit_feeprice"])+($TPL_V1["out_commission_price"]))?>

							</p -->
							<!---->
						</td>
<?php }?>
<?php }?>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?> left"  style=" mso-number-format:'@';" title="<?php echo $TPL_V1["out_pg_ordernum"]?>"><?php echo getstrcut($TPL_V1["out_pg_ordernum"], 24)?>	<!-- <br/><?php echo $TPL_V1["order_seq"]?> --></td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?>"><?php echo $TPL_V1["out_order_referer_viewer"]?></td>
						<td class="<?php if($TPL_V1["ac_type"]=='cal_sales'){?> its_tr_carryover_not <?php }?> " title="<?php echo $TPL_V1["out_payment"]?>"><?php echo getstrcut($TPL_V1["out_payment"], 7)?></td>
					</tr>
<?php }}?>
<?php }?>
					
					<script>
						$("#carry_page").val('<?php echo $TPL_VAR["carry_page"]+ 1?>');
						$("#carry_last_num").val('<?php echo $TPL_VAR["carryover_out_num"]?>');
					</script>