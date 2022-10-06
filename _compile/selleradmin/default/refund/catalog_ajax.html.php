<?php /* Template_ 2.2.6 2022/05/17 12:29:27 /www/music_brother_firstmall_kr/selleradmin/skin/default/refund/catalog_ajax.html 000006408 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php if(!$TPL_VAR["record"]&&$TPL_VAR["page"]== 1){?>
	<tr class="list-row">
		<td colspan="<?php if($TPL_VAR["pagemode"]=='company_catalog'){?>12<?php }else{?>14<?php }?>" align="center">검색어가 없거나 검색 결과가 없습니다.</td>
	</tr>
<?php }else{?>
	<!-- 리스트 : 시작 -->
<?php if(!$TPL_VAR["record"]){?>
	<tr class="list-row">
		<td colspan="14" align="center">검색어가 없거나 검색 결과가 없습니다.</td>
	</tr>
<?php }else{?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
<?php if($TPL_V1["start"]){?>
	<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
	<tr class="list-title-row">
		<td colspan="14" class="list-title-row-td" style="border-top:none;">
			<div class="relative clearbox">
				<div class="ltr-title">
<?php if($TPL_V1["status"]=='request'){?>
					<span class="small_group"><?php echo $TPL_VAR["arr_refund_status"][$TPL_V1["status"]]?></span> <span class="helpicon" title="환불신청을 처리하세요."></span>
<?php }elseif($TPL_V1["status"]=='ing'){?>
					<span class="small_group"><?php echo $TPL_VAR["arr_refund_status"][$TPL_V1["status"]]?></span> <span class="helpicon" title="환불처리를 완료하세요."></span>
<?php }elseif($TPL_V1["status"]=='complete'){?>
					<span class="small_group"><?php echo $TPL_VAR["arr_refund_status"][$TPL_V1["status"]]?></span> <span class="helpicon" title="환불처리가 완료되었습니다."></span>
<?php }?>
				</div>
			</div>
		</td>
	</tr>
	<!-- 리스트타이틀(주문상태 및 버튼) : 끝 -->
<?php }?>
	<tr class="list-row">
		<td align="center"><?php echo $TPL_V1["no"]?></td>
		<td align="center"><a href="../order/view?no=<?php echo $TPL_V1["order_seq"]?>"><strong class="hand blue"><?php echo $TPL_V1["regist_date"]?></strong><br /><span class="fx11"><?php echo $TPL_V1["refund_code"]?></span></a></td>
		<td align="center">
			<a href="../order/view?no=<?php echo $TPL_V1["order_seq"]?>"><span class="hand blue"><?php echo $TPL_V1["order_seq"]?></span></a>
<?php if($TPL_V1["npay_order_id"]){?><div class="ngreen"><?php echo $TPL_V1["npay_order_id"]?><span style="font-size:11px;"> (Npay주문번호)</span></div><?php }?>
		</td>
		<td align="center">
<?php if($TPL_V1["member_seq"]){?>
			<span class="hand" onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','<?php echo $TPL_V1["order_seq"]?>','right');">
<?php if($TPL_V1["member_type"]=='개인'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" />
<?php }elseif($TPL_V1["member_type"]=='기업'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" /><?php }?>
				<?php echo $TPL_V1["order_user_name"]?>

<?php if($TPL_V1["sns_rute"]){?>
					<span>(<img src="/selleradmin/skin/default/images/sns/sns_<?php echo substr($TPL_V1["sns_rute"], 0, 1)?>0.gif" align="absmiddle" class="btnsnsdetail">/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
					</span>
<?php }else{?>
<?php if($TPL_V1["mbinfo_rute"]=='facebook'){?>
					(<span style="color:#d13b00;" <img src="/admin/skin/default/images/board/icon/sns_f0.gif" align="absmiddle"><?php echo $TPL_V1["mbinfo_email"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
<?php }else{?>
					(<span style="color:#d13b00;"><?php echo $TPL_V1["userid"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
<?php }?>
<?php }?>
			</span>
<?php }else{?>
			<img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <?php echo $TPL_V1["order_user_name"]?> (<span class="desc" order_seq="<?php echo $TPL_V1["order_seq"]?>">비회원</span>)
<?php }?>
		</td>
		<td align="center">
<?php if($TPL_V1["pg"]=='kakaopay'){?>
			<span class="icon-pay-kakaopay"><span>kakaopay</span></span> 
<?php }else{?>
<?php if($TPL_V1["npay_order_id"]){?>
			<span class="icon-pay-npay" title="naver pay"><span>npay</span></span> 
<?php }?>
			<span class="icon-pay-<?php echo $TPL_V1["payment"]?>"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }?>
		</td>
		<td align="center"><?php echo ($TPL_V1["option_ea"]+$TPL_V1["suboption_ea"])?></td>
		<td align="center"><?php if($TPL_V1["refund_type"]=='return'){?><?php echo $TPL_V1["refund_ea_sum"]?><?php }else{?>&nbsp;<?php }?></td>
		<td align="center"><?php if($TPL_V1["refund_type"]=='cancel_payment'){?><?php echo $TPL_V1["refund_ea_sum"]?><?php }else{?>&nbsp;<?php }?></td>
		<td align="center"><?php if($TPL_V1["refund_type"]=='shipping_price'){?>1<?php }else{?>&nbsp;<?php }?></td>
		<td align="center"><?php if($TPL_V1["refund_method"]){?><?php echo $TPL_V1["refund_method"]?><?php }else{?>&nbsp;<?php }?></td>
		<td align="center"><?php echo get_currency_price($TPL_V1["refund_total"])?></td>
		<td align="center"><?php if($TPL_V1["refund_date"]!='0000-00-00'){?><?php echo $TPL_V1["refund_date"]?><?php }else{?>&nbsp;<?php }?></td>
		<td align="center"><?php echo $TPL_V1["mstatus"]?></td>
		<td align="center"><?php echo $TPL_V1["returns_status"]?></td>
	</tr>
	<tr class="list-row hide">
		<td colspan="14" class="list-end-row-td">
			<div class="detail"></div>
		</td>
	</tr>
	<!-- 리스트데이터 : 끝 -->
<?php if($TPL_V1["end"]){?>
	<!-- 합계 : 시작 -->
	<tr class="list-end-row">
		<td colspan="14" class="list-end-row-td">
			<div class="list-end-total-amount">
				<?php echo $TPL_V1["mstatus"]?> <span class="darkgray">합계</span> &nbsp; <?php echo number_format($TPL_VAR["summary"]['status_cnt'][$TPL_V1["status"]])?>건
				&nbsp;&nbsp;&nbsp;
				<?php echo get_currency_price($TPL_VAR["summary"]['tot_price'][$TPL_V1["status"]], 3,'','<span class="fx14">_str_price_</span>')?>

			</div>
		</td>
	</tr>
	<tr class="list-row">
		<td colspan="14" style="border:none; height:30px;"></td>
	</tr>
	<!-- 합계 : 끝 -->
<?php }?>
<?php }}?>
<?php }?>
	<!-- 리스트 : 끝 -->
<?php }?>
		<input type="hidden" id="<?php echo $TPL_VAR["page"]?>_no" value="<?php echo $TPL_VAR["final_no"]?>" />
		<input type="hidden" id="<?php echo $TPL_VAR["page"]?>_step" value="<?php echo $TPL_VAR["final_step"]?>" />