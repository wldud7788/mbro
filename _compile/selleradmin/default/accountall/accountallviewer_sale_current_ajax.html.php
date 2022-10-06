<?php /* Template_ 2.2.6 2022/05/17 12:28:49 /www/music_brother_firstmall_kr/selleradmin/skin/default/accountall/accountallviewer_sale_current_ajax.html 000004384 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
						<tr>
							<td>당월<?php echo $TPL_V1["out_num"]?><!-- /<?php echo $TPL_V1["seq"]?> --><!--순번--></td>
							<td><!-- 정산(전월:'carryover', 당월:'complete'), 매출(차월:'overdraw', 당월:'complete') -->
							<?php echo $TPL_V1["out_deposit_date"]?>

							<!-- <br/><?php echo $TPL_V1["ac_type"]?> -->
							</td>
							<td><?php if($TPL_V1["out_confirm_date"]){?><?php echo $TPL_V1["out_confirm_date"]?> (<?php echo $TPL_V1["out_step"]?>)<?php }?></td>
<?php if($TPL_V1["out_step"]=="환불완료"){?>
							<td style="mso-number-format:'@';" width="<?php if($_GET["order_referer"]=='npay'){?>134<?php }else{?>134<?php }?>"><a href="../refund/view?no=<?php echo $TPL_V1["refund_code"]?>" target="_blank"><span class="order-step-color-<?php echo $TPL_V1["status"]?>"><?php echo $TPL_V1["refund_code"]?></a>
<?php }else{?>
							<td style="mso-number-format:'@';" width="<?php if($_GET["order_referer"]=='npay'){?>134<?php }else{?>134<?php }?>"><a href="../order/view?no=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><span class="order-step-color-<?php echo $TPL_V1["status"]?>"><?php echo $TPL_V1["order_seq"]?></a>
<?php }?>
							</td>
<?php if(!$_GET["account_hidden_name"]){?>
							<td  width="<?php if($_GET["order_referer"]=='shop'||$_GET["order_referer"]=='npay'){?>80<?php }else{?>78<?php }?>" title="<?php echo $TPL_V1["order_user_name"]?>" class="ellipsis"><?php echo getstrcut($TPL_V1["order_user_name"], 4)?></td>
							<td class="left ellipsis" width="<?php if($_GET["order_referer"]=='shop'){?>100<?php }else{?>97<?php }?>" title="<?php echo $TPL_V1["out_provider_name"]?>"><?php echo getstrcut($TPL_V1["out_provider_name"], 8)?><?php if($TPL_V1["out_provider_name"]){?>(<?php echo $TPL_V1["provider_seq"]?>)<?php }?></td>
							<td class="left " width="<?php if($_GET["order_referer"]=='all'||$_GET["order_referer"]=='pg'||$_GET["order_referer"]=='npay'){?>134<?php }elseif($_GET["order_referer"]=='shop'){?>135<?php }else{?>138<?php }?>" >
								<span alt="<?php echo $TPL_V1["order_goods_name"]?> <?php if($TPL_V1["order_goods_name"]){?><?php if($TPL_V1["title1"]){?><?php echo $TPL_V1["title1"]?>:<?php }?><?php echo $TPL_V1["option1"]?><?php if($TPL_V1["option2"]!=null){?><?php if($TPL_V1["title2"]){?><?php echo $TPL_V1["title2"]?>:<?php }?><?php echo $TPL_V1["option2"]?><?php }?><?php if($TPL_V1["option3"]!=null){?><?php if($TPL_V1["title3"]){?><?php echo $TPL_V1["title3"]?>:<?php }?><?php echo $TPL_V1["option3"]?><?php }?><?php if($TPL_V1["option4"]!=null){?><?php if($TPL_V1["title4"]){?><?php echo $TPL_V1["title4"]?>:<?php }?><?php echo $TPL_V1["option4"]?><?php }?><?php if($TPL_V1["option5"]!=null){?><?php if($TPL_V1["title5"]){?><?php echo $TPL_V1["title5"]?>:<?php }?><?php echo $TPL_V1["option5"]?><?php }?><?php }?>" title="<?php echo $TPL_V1["order_goods_name"]?> <?php if($TPL_V1["order_goods_name"]){?><?php if($TPL_V1["title1"]){?><?php echo $TPL_V1["title1"]?>:<?php }?><?php echo $TPL_V1["option1"]?><?php if($TPL_V1["option2"]!=null){?><?php if($TPL_V1["title2"]){?><?php echo $TPL_V1["title2"]?>:<?php }?><?php echo $TPL_V1["option2"]?><?php }?><?php if($TPL_V1["option3"]!=null){?><?php if($TPL_V1["title3"]){?><?php echo $TPL_V1["title3"]?>:<?php }?><?php echo $TPL_V1["option3"]?><?php }?><?php if($TPL_V1["option4"]!=null){?><?php if($TPL_V1["title4"]){?><?php echo $TPL_V1["title4"]?>:<?php }?><?php echo $TPL_V1["option4"]?><?php }?><?php if($TPL_V1["option5"]!=null){?><?php if($TPL_V1["title5"]){?><?php echo $TPL_V1["title5"]?>:<?php }?><?php echo $TPL_V1["option5"]?><?php }?><?php }?>"><?php if($TPL_V1["out_order_goods_name"]){?><?php echo getstrcut($TPL_V1["out_order_goods_name"], 10)?><?php }else{?><?php echo $TPL_V1["out_order_type"]?><?php }?></span>
							</td>
<?php }?>
						</tr>
<?php }}?>
<?php }?>
					
					<script>
						$("#current_page").val('<?php echo $TPL_VAR["current_page"]+ 1?>');
						$("#current_last_num").val('<?php echo $TPL_VAR["current_out_num"]?>');
					</script>