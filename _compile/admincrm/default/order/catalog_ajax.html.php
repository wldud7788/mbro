<?php /* Template_ 2.2.6 2022/05/17 12:05:25 /www/music_brother_firstmall_kr/admincrm/skin/default/order/catalog_ajax.html 000009844 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php if(!$TPL_VAR["record"]&&$TPL_VAR["page"]== 1){?>
		<tr class="list-row">
			<td colspan="<?php if($TPL_VAR["ajaxCall"]){?>10<?php }else{?>9<?php }?>" align="center">검색어가 없거나 검색 결과가 없습니다.</td>
		</tr>
<?php }else{?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>

<?php if($TPL_V1["start_step"]){?>
		<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
		<tr class="list-title-row">
			<td colspan="<?php if($TPL_VAR["ajaxCall"]){?>10<?php }else{?>9<?php }?>" class="list-title-row-td list-title-row-td-step-<?php echo $TPL_V1["step"]?>">
				<div class="relative">
					<div class="ltr-title ltr-title-step-<?php echo $TPL_V1["step"]?>">
<?php if($TPL_V1["step"]== 15){?>
					<span class="step_title">(출고 전)</span>주문접수
<?php }elseif($TPL_V1["step"]== 25){?>
					<span class="step_title">(출고 전)</span>결제확인
<?php }elseif($TPL_V1["step"]== 35){?>
					<span class="step_title">(출고 전)</span>상품준비
<?php }elseif($TPL_V1["step"]== 40){?>
					<span class="step_title">(출고 전)</span>부분 출고준비
<?php }elseif($TPL_V1["step"]== 45){?>
					<span class="step_title">(출고 전)</span>출고준비
<?php }elseif($TPL_V1["step"]== 50){?>
					<span class="step_title">(출고 후)</span>부분 출고완료
<?php }elseif($TPL_V1["step"]== 55){?>
					<span class="step_title">(출고 후)</span>출고완료
<?php }elseif($TPL_V1["step"]== 60){?>
					<span class="step_title">(출고 후)</span>부분 배송 중
<?php }elseif($TPL_V1["step"]== 65){?>
					<span class="step_title">(출고 후)</span>배송 중
<?php }elseif($TPL_V1["step"]== 70){?>
					<span class="step_title">(출고 후)</span>부분 배송완료
<?php }elseif($TPL_V1["step"]== 75){?>
					<span class="step_title">(출고 후)</span>배송완료
<?php }elseif($TPL_V1["step"]== 85){?>
					<span class="step_title">(출고 전)</span>결제취소(전체)
<?php }elseif($TPL_V1["step"]== 95){?>
					<span class="step_title">(출고 전)</span>주문무효
<?php }elseif($TPL_V1["step"]== 99){?>
					<span class="step_title">(출고 전)</span>결제실패
<?php }elseif($TPL_V1["step"]== 0){?>
					<span class="step_title">(출고 전)</span>결제시도
<?php }?>
					</div>
				</div>
			</td>
		</tr>
		<!-- 리스트타이틀(주문상태 및 버튼) : 끝 -->
<?php }?>


		<tr class="list-row step<?php echo $TPL_V1["step"]?> important_<?php echo $TPL_V1["order_seq"]?> <?php if($TPL_V1["thischeck"]){?>checked-tr-background<?php }?>">
			<td align="center" class="ft11"><?php echo substr($TPL_V1["regist_date"], 2, - 3)?></td>
			<td align="left" class="ft11">
				<a href="/admin/order/view?no=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><span class="order-step-color-<?php echo $TPL_V1["step"]?> bold"><?php echo $TPL_V1["order_seq"]?></span></a>
<?php if($TPL_V1["linkage_mall_order_id"]){?>
				<div class="blue bold"><?php echo $TPL_V1["linkage_mall_order_id"]?></div>
<?php }?>
			</td>
			<td align="left">
			<div class="goods_name"><?php if($TPL_V1["gift_cnt"]> 0){?><span title="사은품 주문"><img src="/admin/skin/default/images/design/icon_order_gift.gif" align="absmiddle"/></span><?php }?> <?php echo $TPL_V1["goods_name"]?></div>
			</td>
			<td class="right">
			<?php echo $TPL_V1["tot_ea"]?>(<?php echo $TPL_V1["item_cnt"]?>종)
			</td>
			<td align="center" class="ft11">
			</td>

			<td class="ft11 hand" onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','<?php echo $TPL_V1["order_seq"]?>','right');">
<?php if($TPL_V1["shipping_cnt"]> 1||$TPL_V1["recipient_user_name"]!=$TPL_V1["order_user_name"]){?>
					<div style="margin-top:5px;"><?php echo $TPL_V1["recipient_user_name"]?> <?php if($TPL_V1["shipping_cnt"]> 1){?>외 <?php echo ($TPL_V1["shipping_cnt"]- 1)?>명<?php }?></div>
<?php }?>
					<div style="margin-bottom:3px;">
<?php if($TPL_V1["member_seq"]){?>
<?php if($TPL_V1["member_type"]=='개인'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" vspace="0" align="absmiddle" />
<?php }elseif($TPL_V1["member_type"]=='기업'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" vspace="0" align="absmiddle" /><?php }?>
					<span><?php echo $TPL_V1["order_user_name"]?></span>
<?php if($TPL_V1["sns_rute"]){?>
						<span>(<img src="/admin/skin/default/images/sns/sns_<?php echo substr($TPL_V1["sns_rute"], 0, 1)?>0.gif" align="absmiddle" class="btnsnsdetail">/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
						</span>
<?php }else{?>
						(<span style="color:#d13b00;"><?php echo $TPL_V1["userid"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span></a>)
<?php }?>
<?php if($TPL_V1["blacklist"]){?><img src="/admin/skin/default/images/common/ico_blacklist_<?php echo $TPL_V1["blacklist"]?>.png" align="absmiddle" alt="블랙리스트_<?php echo $TPL_V1["blacklist"]?>" /><?php }else{?><img src="/admin/skin/default/images/common/ico_angel.png" align="absmiddle" alt="엔젤회원" /><?php }?>
<?php }else{?>
					<img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <span><?php echo $TPL_V1["order_user_name"]?></span> (<span class="desc">비회원</span>)
<?php if($TPL_V1["ordblacklist"]){?><img src="/admin/skin/default/images/common/ico_blacklist_<?php echo $TPL_V1["ordblacklist"]?>.png" align="absmiddle" alt="블랙리스트_<?php echo $TPL_V1["ordblacklist"]?>" /><?php }else{?><img src="/admin/skin/default/images/common/ico_angel.png" align="absmiddle" alt="엔젤회원" /><?php }?>
<?php }?>
					</div>
			</td>

			<!--// 결제 수단 //-->
			<td align="right" class="ft11">
<?php if($TPL_V1["payment"]=='bank'){?>
<?php if($TPL_V1["order_user_name"]==$TPL_V1["depositor"]){?>
				<span class="darkgray"><span title="입금자명"><?php echo $TPL_V1["depositor"]?></span></span>
<?php }else{?>
				<span class="blue"><span title="입금자명"><?php echo $TPL_V1["depositor"]?></span></span>
<?php }?>
<?php }?>
<?php if($TPL_V1["payment"]=='escrow_account'){?>
			<span class="icon-pay-escrow"><span>에스크로</span></span>
			<span class="icon-pay-account"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }elseif($TPL_V1["payment"]=='escrow_virtual'){?>
			<span class="icon-pay-escrow"><span>에스크로</span></span>
			<span class="icon-pay-virtual"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }elseif($TPL_V1["pg"]=='kakaopay'){?>
			<span class="icon-pay-<?php echo $TPL_V1["pg"]?>-simple"><span><?php echo $TPL_V1["pg"]?></span></span>
<?php }else{?>
			<span class="icon-pay-<?php echo $TPL_V1["payment"]?>"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }?>
<?php if($TPL_V1["payment"]=='bank'&&$TPL_V1["bank_name"]){?>
			<span class="darkgray"><span title="은행명"><?php echo $TPL_V1["bank_name"]?></span></span>
<?php }?>
<?php if($TPL_V1["deposit_date"]){?>
			 <div class="pdt5"><?php echo substr($TPL_V1["deposit_date"], 2, - 3)?></div>
<?php }?>
			</td>
			<td align="right" style="padding-right:5px;"><b><?php echo get_currency_price($TPL_V1["settleprice"])?></b></td>
			<td align="center" class="ft11">
			<div><?php echo $TPL_V1["mstep"]?></div>
<?php if($TPL_V1["cancel_list_ea"]||$TPL_V1["exchange_list_ea"]||$TPL_V1["return_list_ea"]||$TPL_V1["refund_list_ea"]){?>
			<div>
<?php if($TPL_V1["cancel_list_ea"]){?>
				<a href="/admin/refund/catalog?keyword=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_cancel.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V1["cancel_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V1["exchange_list_ea"]){?>
				<a href="/admin/returns/catalog?keyword=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return_exchange.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V1["exchange_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V1["return_list_ea"]){?>
				<a href="/admin/returns/catalog?keyword=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V1["return_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V1["refund_list_ea"]){?>
				<a href="/admin/refund/catalog?keyword=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_refund.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V1["refund_list_ea"]?></span></a>
<?php }?>
			</div>
<?php }?>
			</td>
<?php if($TPL_VAR["ajaxCall"]){?>
			<td class="ctd hand" onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','<?php echo $TPL_V1["order_seq"]?>','left');">
				<span class="btn small valign-middle cyanblue"><input type="button" name="manager_modify_btn" value="CRM" /></span>
			</td>
<?php }?>
		</tr>
		<tr class="order-list-summary-row hide">
			<td colspan="<?php if($TPL_VAR["ajaxCall"]){?>10<?php }else{?>9<?php }?>" class="order-list-summary-row-td"><div class="order_info"></div></td>
		</tr>
		<!-- 리스트데이터 : 끝 -->
<?php }}?>
<?php }?>
		<input type="hidden" id="<?php echo $TPL_VAR["page"]?>_no" value="<?php echo $TPL_VAR["final_no"]?>" />
		<input type="hidden" id="<?php echo $TPL_VAR["page"]?>_step" value="<?php echo $TPL_VAR["final_step"]?>" />