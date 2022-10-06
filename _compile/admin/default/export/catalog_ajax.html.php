<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/export/catalog_ajax.html 000027665 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php if(!$TPL_VAR["record"]&&$TPL_VAR["page"]== 1){?>
	<tr class="list-row">
		<td colspan="11" align="center">검색어가 없거나 검색 결과가 없습니다.</td>
	</tr>
<?php }else{?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_K1=>$TPL_V1){?>

<?php if($TPL_V1["end_step_cnt"]){?>
		<!-- 합계 : 시작 -->
		<tr class="list-end-row">
			<td colspan="11" class="list-end-row-td">
				<ul class="left-btns clearbox" style="margin-top:2px">
					<li>
						<select class="list-select custom-select-box-multi" name="select_<?php echo $TPL_V1["end_step"]?>"  rows="4">
						<option value="select">전체선택</option>
						<option value="not-select">선택안함</option>
						<option value="important">별표선택</option>
						<option value="not-important">별표없음</option>
						</select>
					</li>
					<li>
						<span class="btn small"><button name="goods_print" id="<?php echo $TPL_V1["end_step"]?>" class="hand resp_btn v3" align="absmiddle"><img src="/admin/skin/default/images/common/icon_order_2.png"/><span>프린트</span></button></span>	
							
<?php if($TPL_VAR["status_invoice_cnt"][$TPL_V1["end_step"]]){?>
						<span class="btn small"><button name="invoice_print" id="<?php echo $TPL_V1["end_step"]?>" class="hand resp_btn v3" align="absmiddle"><img src="/admin/skin/default/images/common/icon_order_3.png"/><span>프린트</span></button></span>					
<?php }?>

<?php if($TPL_V1["end_step"]=='45'){?>
						<span class="btn small red" onclick="export_proc('45','<?php echo $TPL_V1["end_step"]?>');"><button type="button" class="resp_btn active">출고상태변경</button></span>
<?php }elseif($TPL_V1["end_step"]=='55'){?>
						<span class="btn small red" onclick="export_proc('55','<?php echo $TPL_V1["end_step"]?>');"><button type="button" class="resp_btn active">출고상태변경</button></span>
<?php }elseif($TPL_V1["end_step"]=='65'){?>
						<span class="btn small red" onclick="export_proc('65','<?php echo $TPL_V1["end_step"]?>');"><button type="button" class="resp_btn active">출고상태변경</button></span>
<?php }?>
						
<?php if($TPL_V1["end_step"]=='45'||($TPL_VAR["scm_cfg"]['use']!='Y'&&$TPL_V1["end_step"]=='55')||$TPL_V1["end_step"]=='65'){?>
							<span class="hand reverse_export resp_btn v3" id="<?php echo $TPL_V1["end_step"]?>">
<?php if($TPL_V1["end_step"]=='45'){?>
								'상품준비' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_VAR["scm_cfg"]['use']!='Y'&&$TPL_V1["end_step"]=='55'){?>
								'출고준비' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_V1["end_step"]=='65'){?>
								'출고완료' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }?>
							</span>
<?php if($TPL_V1["end_step"]=='45'){?>
							<span class="helpicon" title="출고 준비된 상품을 상품준비로 되돌릴 수 있습니다."></span>
<?php }elseif($TPL_VAR["scm_cfg"]['use']!='Y'&&$TPL_V1["end_step"]=='55'){?>
							<span class="helpicon" title="출고 완료된 상품을 출고준비로 되돌릴 수 있습니다.<br/>이 때 출고완료 시 차감된 재고 수량이 환원됩니다."></span>
<?php }elseif($TPL_V1["end_step"]=='65'){?>
							<span class="helpicon" title="배송 중인 상품을 출고완료로 되돌릴 수 있습니다."></span>
<?php }?>							
<?php }?>
					</li>
				</ul>
				<div class="list-end-total-amount">
					<span class="order-step-color-<?php echo $TPL_V1["end_step"]?>"><?php echo $TPL_V1["end_mstep"]?></span> <span class="darkgray">합계</span> &nbsp; <?php echo number_format($TPL_V1["end_step_cnt"])?>건
					&nbsp;&nbsp;&nbsp;
					￦ <span class="fx14 order-step-color-<?php echo $TPL_V1["end_step"]?>"><?php echo number_format($TPL_V1["end_step_settleprice"])?></span>
				</div>
			</td>
		</tr>
		<!-- 합계 : 끝 -->
<?php }?>

<?php if($TPL_V1["start_step"]){?>
		<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
		<tr class="list-title-row">
			<td colspan="11" class="list-title-row-td list-title-row-td-step-<?php echo $TPL_V1["status"]?>">
				<div class="relative clearbox">
					<div class="ltr-title ltr-title-step-<?php echo $TPL_V1["status"]?>">
<?php if($TPL_V1["status"]== 45){?>
						<span class="small_group">출고준비</span> <span class="helpicon" title="출고완료를 처리하세요.출고수량만큼 재고가 자동 차감됩니다."></span>
<?php }elseif($TPL_V1["status"]== 55){?>
						<span class="small_group">출고완료</span> <span class="helpicon" title="배송완료를 처리하세요.회원에게 마일리지가 지급됩니다."></span>
<?php }elseif($TPL_V1["status"]== 65){?>
						<span class="small_group">배송중</span> <span class="helpicon" title="배송완료를 처리하세요.회원에게 마일리지가 지급됩니다."></span>
<?php }elseif($TPL_V1["status"]== 75){?>
						<span class="small_group">배송완료</span> <span class="helpicon" title="배송완료가 처리되어 회원에게 마일리지가 지급되었습니다."></span>
<?php }?>
					</div>
					<ul class="left-btns">
						<li>
							<select class="list-select custom-select-box-multi" name="select_<?php echo $TPL_V1["status"]?>"  rows="5">
							<option value="select">전체선택</option>
							<option value="not-select">선택안함</option>
							<option value="important">별표선택</option>
							<option value="not-important">별표없음</option>
							</select>
						</li>
						<li>
							<span class="btn small"><button name="goods_print" id="<?php echo $TPL_V1["status"]?>" class="hand resp_btn v3" align="absmiddle"><img src="/admin/skin/default/images/common/icon_order_2.png"/><span>프린트</span></button></span>	
							
<?php if($TPL_VAR["status_invoice_cnt"][$TPL_V1["status"]]){?>
							<span class="btn small"><button name="invoice_print" id="<?php echo $TPL_V1["status"]?>" class="hand resp_btn v3" align="absmiddle"><img src="/admin/skin/default/images/common/icon_order_3.png"/><span>프린트</span></button></span>	
<?php }?>					

<?php if($TPL_V1["status"]=='45'){?>
							<span class="btn small red" onclick="export_proc('45','<?php echo $TPL_V1["status"]?>');"><button type="button" class="resp_btn active">출고상태변경</button></span>
<?php }elseif($TPL_V1["status"]=='55'){?>
							<span class="btn small red" onclick="export_proc('55','<?php echo $TPL_V1["status"]?>');"><button type="button" class="resp_btn active">출고상태변경</button></span>
<?php }elseif($TPL_V1["status"]=='65'){?>
							<span class="btn small red" onclick="export_proc('65','<?php echo $TPL_V1["status"]?>');"><button type="button" class="resp_btn active">출고상태변경</button></span>
<?php }?>

<?php if($TPL_V1["status"]=='45'||($TPL_VAR["scm_cfg"]['use']!='Y'&&$TPL_V1["status"]=='55')||$TPL_V1["status"]=='65'){?>
								<span class="hand reverse_export resp_btn v3" id="<?php echo $TPL_V1["status"]?>">
<?php if($TPL_V1["status"]=='45'){?>
									'상품준비' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_VAR["scm_cfg"]['use']!='Y'&&$TPL_V1["status"]=='55'){?>
									'출고준비' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_V1["status"]=='65'){?>
									'출고완료' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }?>
								</span>
<?php if($TPL_V1["status"]=='45'){?>
								<span class="helpicon" title="출고 준비된 상품을 상품준비로 되돌릴 수 있습니다."></span>
<?php }elseif($TPL_VAR["scm_cfg"]['use']!='Y'&&$TPL_V1["status"]=='55'){?>
								<span class="helpicon" title="출고 완료된 상품을 출고준비로 되돌릴 수 있습니다.<br/>이 때 출고완료 시 차감된 재고 수량이 환원됩니다."></span> 
<?php }elseif($TPL_V1["status"]=='65'){?>
								<span class="helpicon" title="배송 중인 상품을 출고완료로 되돌릴 수 있습니다."></span>
<?php }?>								
<?php }?>
						</li>
					</ul>
					<!-- EXCEL -->
					<ul class="right-btns">
						<li>
							<select class="custom-select-box" id="select_down_<?php echo $TPL_V1["status"]?>">
								<option value="">양식선택</option>
								<option value="EXPORT">출고번호별 한줄</option>
								<option value="ITEM">상품별 한줄</option>
							</select>

							<span class="btn small"><button name="download_list" class="resp_btn v3">항목설정<span class="arrowright"></span></button></span>
							<span class="btn small"><button name="excel_down" status="<?php echo $TPL_V1["status"]?>" data-provider='admin' class="resp_btn v3"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /><span>일괄다운로드</span></button></span>
							<span class="btn small"><button name="excel_upload" status="<?php echo $TPL_V1["status"]?>" class="resp_btn v3"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /><span>일괄업로드(출고)</span></button></span>
						</li>
					</ul>
				</div>
			</td>
		</tr>
		<!-- 리스트타이틀(주문상태 및 버튼) : 끝 -->
<?php }?>

		<!-- 리스트데이터 : 시작 -->
		<tr class="list-row step<?php echo $TPL_V1["status"]?>">
			<td align="center">
				<input type="checkbox" name="export_code[]" class="export_code_<?php echo $TPL_V1["status"]?> resp_checkbox" value="<?php echo $TPL_V1["export_code"]?>" order_seq="<?php echo $TPL_V1["order_seq"]?>" goods_kind="<?php echo $TPL_V1["goods_kind"]?>"/>
			</td>
			<td align="center">
<?php if($TPL_V1["important"]=="1"){?>
				<span class="icon-star-gray hand checked list-important important-<?php echo $TPL_V1["status"]?>" id="important_<?php echo $TPL_V1["export_seq"]?>"></span>
<?php }?>
<?php if($TPL_V1["important"]=="2"){?>
				<span class="icon-star-gray hand soldout list-important important-<?php echo $TPL_V1["status"]?>"
				id="important_<?php echo $TPL_V1["export_seq"]?>"></span>
<?php }?>
<?php if($TPL_V1["important"]=="0"){?>
				<span class="icon-star-gray hand list-important important-<?php echo $TPL_V1["status"]?>" id="important_<?php echo $TPL_V1["export_seq"]?>"></span>
<?php }?>
			</td>
			<td align="center"><?php echo $TPL_V1["no"]?></td>
			<td align="center">
				<div class="origin_order">
					<a href="../order/catalog?hsb_kind=order&header_search_keyword=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/btn_orig_order.gif' border="0" align="absmiddle" alt="해당 출고의 주문을 확인합니다"></a>
				</div>
<?php if($TPL_V1["is_bundle_export"]=='Y'){?>
				<div class="hand under_div_view relative">
					(합포장)
					<div class="absolute under_div_view_contents hide">
						<div class="sale_price_layer">
							<table width="300" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<th class="gr" width="50%">주문</th>
									<th class="ends" width="50%">출고</th>
								</tr>
<?php if(is_array($TPL_R2=$TPL_V1["bundle_order_list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<tr>
									<td>
										<a href="../order/view?no=<?php echo $TPL_V2?>" target="_blank"><?php echo $TPL_V2?></a>
									</td>
									<td class="ends">
										<a href="../export/catalog?keyword_type=ord.order_seq&keyword=<?php echo $TPL_V2?>">해당 주문의 출고검색</a>
									</td>
								</tr>
<?php }}?>
							</table>
						</div>
					</div>
				</div>
<?php }?>
			</td>
			<td align="center">
<?php if($TPL_V1["status_date"]){?>
				<?php echo $TPL_V1["status_date"]?>

<?php }else{?>
				-
<?php }?>
			</td>
			<td align="left">
				<!-- ######################## 16.12.16 gcs yjy : 검색조건 유지되도록 -->
				<a href="javascript:exportView('<?php echo $TPL_V1["export_code"]?>')" target="_self">
<?php if($TPL_V1["buy_confirm"]=='none'){?>
				<span class="icon-buy-none"></span>
<?php }else{?>
				<span class="icon-buy-confirm"></span>
<?php }?>
				<span class="hand bold order-step-color-<?php echo $TPL_V1["status"]?>"><?php echo $TPL_V1["export_code"]?></span>
				</a>
				<a href="javascript:printExportView('<?php echo $TPL_V1["order_seq"]?>','<?php echo $TPL_V1["export_code"]?>', 'catalog')"><span class="icon-print-export"></span></a>
<?php if($TPL_V1["invoice_send_yn"]=='y'){?>
				<a href="javascript:printInvoiceView('<?php echo $TPL_V1["order_seq"]?>','<?php echo $TPL_V1["export_code"]?>')"><span class="icon-print-invoice"></span></a>
<?php }?>
				<a href="view?no=<?php echo $TPL_V1["export_code"]?>" target="_blank"><span class="btn-administration"><span class="hide">새창</span></span></a>
				<span class="btn-direct-open"><span class="hide">바로열기</span></span>
<?php if($TPL_V1["linkage_mall_code"]){?>
				<div class="left pdl30 blue bold">&nbsp;<?php echo $TPL_VAR["linkage_mallnames"][$TPL_V1["linkage_mall_code"]]?></div>
<?php }?>
			</td>
			<td align="left" style='line-height:17px;' class="left">
<?php if($TPL_V1["goods_type"]=='gift'){?>
				<img src="/admin/skin/default/images/common/icon_gift.gif" align="absmiddle" />
<?php }?>
<?php if($TPL_V1["opt_type"]=='sub'){?>
				<img src="/admin/skin/default/images/common/icon_add.gif" align="absmiddle" />
<?php }?>
<?php if($TPL_V1["item_title"]){?>
				<?php echo $TPL_V1["item_title"]?>

				<span class="desc">(<?php echo $TPL_V1["goods_name"]?>)</span>
<?php }else{?>
				<?php echo $TPL_V1["goods_name"]?>

<?php }?>
<?php if($TPL_V1["item_count"]> 1){?>외 <?php echo $TPL_V1["item_count"]- 1?>종<?php }?>
<?php if($TPL_V1["goods_kind"]=='coupon'){?>
				<span class="btn"><img src="/admin/skin/default/images/common/btn_ok_use.gif" class="coupon_use_btn" order_seq="<?php echo $TPL_V1["order_seq"]?>" onclick="excoupon_use_btn(this)" /></span>
<?php }?>
			</td>
			<td align="center"><?php echo $TPL_V1["ea"]?>/<?php echo $TPL_V1["item_count"]?></td>
			<td align="center">
				<table class="sub_tb" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="45%">
						<div class="recipient_info">
							<?php echo $TPL_V1["recipient_user_name"]?><br/>
<?php if($TPL_V1["recipient_cellphone"]){?>
							<?php echo $TPL_V1["recipient_cellphone"]?>

<?php }else{?>
							<?php echo $TPL_V1["recipient_phone"]?>

<?php }?>
						</div>
					</td>
					<td width="10%">/</td>
					<td width="45%">
						<div class="order_info hand" onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','<?php echo $TPL_V1["order_seq"]?>','right');">
<?php if($TPL_V1["member_seq"]){?>
<?php if($TPL_V1["member_type"]=='개인'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" title="개인" />
<?php }elseif($TPL_V1["member_type"]=='기업'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" title="기업" /><?php }?>
							<?php echo $TPL_V1["order_user_name"]?>

<?php if($TPL_V1["sns_rute"]){?>
							<div>
								(<img src="/admin/skin/default/images/sns/sns_<?php echo substr($TPL_V1["sns_rute"], 0, 1)?>0.gif" align="absmiddle" class="btnsnsdetail">/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
								<div id="snsdetailPopup<?php echo $TPL_V1["step"]?><?php echo $TPL_K1?>" class="snsdetailPopup absolute hide" style="margin-left:73px;margin-top:-16px;"></div>
							</div>
<?php }else{?>
<?php if($TPL_V1["mbinfo_rute"]=='facebook'){?>
							<div>
								(<img src="/admin/skin/default/images/board/icon/sns_f0.gif" align="absmiddle"><?php echo $TPL_V1["mbinfo_email"]?></span>/<span class="blue" member_seq="<?php echo $TPL_V1["member_seq"]?>"><?php echo $TPL_V1["group_name"]?></span>)
							</div>
<?php }else{?>
							<div>
								(<span class="blue" member_seq="<?php echo $TPL_V1["member_seq"]?>"><?php echo $TPL_V1["group_name"]?></span>)
							</div>
<?php }?>
<?php }?>
<?php }else{?>
							<div><img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <?php echo $TPL_V1["order_user_name"]?></div>
							<div>(<span class="desc">비회원</span>)</div>
<?php }?>
						</div>
					</td>
				</tr>
				</table>
			</td>
			<td align="center">
				<input type="text" name="export_date[<?php echo $TPL_V1["export_code"]?>]" class="line datepicker waybill_number tahoma" size="10" value="<?php echo $TPL_V1["export_date"]?>" style="font-size:11px; width:90px;" />
			</td>
<?php if($TPL_V1["goods_kind"]=='coupon'){?>
			<td align="left" class="pdl10">
				<div class="desc normal"><?php echo $TPL_V1["email"]?></div>
				<div class="desc normal"><?php echo $TPL_V1["cellphone"]?></div>
			</td>
<?php }else{?>
			<td align="left" class="shipping_info_<?php echo $TPL_V1["export_code"]?> left">
				<!-- 배송 정보 :: START -->
				<input type="hidden" name="export_shipping_group[<?php echo $TPL_V1["export_code"]?>]" class="export_shipping_group" value="<?php echo $TPL_V1["shipping_group"]?>" />
				<input type="hidden" id="export_shipping_method_<?php echo $TPL_V1["export_code"]?>" name="export_shipping_method[<?php echo $TPL_V1["export_code"]?>]" class="export_shipping_method" value="<?php echo $TPL_V1["shipping_method"]?>" />
				<input type="hidden" name="export_shipping_set_name[<?php echo $TPL_V1["export_code"]?>]" class="export_shipping_set_name" value="<?php echo $TPL_V1["shipping_set_name"]?>" />
<?php if(serviceLimit('H_AD')){?>
				<div><?php echo $TPL_V1["provider_name"]?></div>
<?php }?>
				<div class="blue">
					<span class="shipping_set_name_<?php echo $TPL_V1["export_code"]?>"><?php echo $TPL_V1["shipping_set_name"]?></span>
				</div>
				<div class="delivery_lay <?php if(!in_array($TPL_V1["shipping_method"],array('delivery','postpaid'))){?>hide<?php }?>">
<?php if($TPL_V1["international"]=='domestic'){?>
					<select name="delivery_company_code[<?php echo $TPL_V1["export_code"]?>]" class="waybill_number delivery_company_code" style="width:90px; padding:4px 0px !important;" chkVal="<?php echo $TPL_V1["delivery_company_code"]?>">
<?php if(is_array($TPL_R2=$TPL_V1["delivery_company_array"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<?php if(substr($TPL_K2, 0, 5)=='auto_'&&$TPL_K2==$TPL_V1["delivery_company_code"]){?>
						<option value='<?php echo $TPL_K2?>' style='background-color:yellow' selected><?php echo $TPL_V2["company"]?></option>
<?php }elseif($TPL_K2==$TPL_V1["delivery_company_code"]){?>
						<option value='<?php echo $TPL_K2?>' selected="selected"><?php echo $TPL_V2["company"]?></option>
<?php }else{?>
						<option value='<?php echo $TPL_K2?>' <?php if(substr($TPL_K2, 0, 5)=='auto_'){?>style='background-color:yellow'<?php }?>><?php echo $TPL_V2["company"]?></option>
<?php }?>
<?php }}?>
					</select>
					<input type="text" name="delivery_number[<?php echo $TPL_V1["export_code"]?>]" class="line waybill_number delivery_number" value="<?php echo $TPL_V1["delivery_number"]?>" style="width:100px; padding:5px!important;"/>
<?php if($TPL_V1["delivery_company_code"]&&$TPL_V1["delivery_number"]){?>	
							<span class="btn small cyanblue"><button type="button" class="hand resp_btn v2" onclick="goDeliverySearch(this);">조회</button></span>										
<?php }elseif($TPL_V1["delivery_company_code"]=='auto_hlc'&&$TPL_V1["delivery_number"]){?>
					<a href="<?php echo $TPL_V1["tracking_url"]?>" target="_blank"><span class="btn small cyanblue"><button type="button" class="hand resp_btn v2">조회</button></span></a>
<?php }?>
<?php if(($TPL_V1["delivery_company_code"]=='auto_hlc'||$TPL_V1["delivery_company_code"]=='auto_epostnet')&&!$TPL_V1["delivery_number"]){?>
					<div><a href="javascript:;" onclick="invoice_export_resend(this,'<?php echo $TPL_V1["export_code"]?>')"><span class='red'>[송장재발급]</span></a></div>
<?php }?>
<?php }else{?>
					<select name="international_shipping_method[<?php echo $TPL_V1["export_code"]?>]" class="waybill_number <?php if($TPL_V1["international"]!='international'||!$TPL_V1["international_company_array"]){?>hide<?php }?>">
<?php if(is_array($TPL_R2=$TPL_V1["international_company_array"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["company"]==$TPL_V1["international_shipping_method"]){?>
						<option value='<?php echo $TPL_V2["company"]?>' style='background-color:yellow' selected><?php echo str_replace('선불 > ','',$TPL_V2["method"])?></option>
<?php }else{?>
						<option value='<?php echo $TPL_V2["company"]?>'><?php echo str_replace('선불 > ','',$TPL_V2["method"])?></option>
<?php }?>
<?php }}?>
					</select>
					<input type="text" name="international_delivery_no[<?php echo $TPL_V1["export_code"]?>]" class="line waybill_number delivery_number" value="<?php echo $TPL_V1["international_delivery_no"]?>" style="width:90%;" />
<?php }?>
				</div>

				<input type="hidden" name="shipping_provider_seq" class="shipping_provider_seq" value="<?php echo $TPL_V1["shipping_provider_seq"]?>" />

				<!-- 매장선택 :: START -->
				<div class="store_lay <?php if($TPL_V1["shipping_method"]!='direct_store'){?>hide<?php }?>">
					<input type="hidden" class="store_scm_type_<?php echo $TPL_V1["export_code"]?>" name="export_store_scm_type[<?php echo $TPL_V1["export_code"]?>]" value="<?php echo $TPL_V1["store_scm_type"]?>" />
					<select name="export_address_seq[<?php echo $TPL_V1["export_code"]?>]" onchange="store_set(this, '<?php echo $TPL_V1["export_code"]?>');">
<?php if(is_array($TPL_R2=$TPL_V1["shipping_store_info"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<option value="<?php echo $TPL_V2["shipping_address_seq"]?>" scm_type="<?php echo $TPL_V2["store_scm_type"]?>" <?php if($TPL_V2["shipping_address_seq"]==$TPL_V1["shipping_address_seq"]){?>selected<?php }?>><?php echo $TPL_V2["shipping_store_name"]?></option>
<?php }}?>
					</select>
				</div>
				<!-- 매장선택 :: END -->

				<!-- 출고지 정보 :: START -->
				<div class="address_lay <?php if($TPL_V1["shipping_method"]=='direct_store'){?>hide<?php }?>">
					<span class="hand" onclick="address_pop('<?php echo $TPL_V1["sending_address"]['address_category']?>','<?php echo $TPL_V1["sending_address"]['address_name']?>','<?php echo $TPL_V1["sending_address"]['view_address']?>','<?php echo $TPL_V1["sending_address"]['shipping_phone']?>');"><?php echo $TPL_V1["sending_address"]['address_name']?></span>
				</div>
				<!-- 출고지 정보 :: END -->
				
				<!-- 배송 정보 :: END -->
			</td>
<?php }?>
		</tr>
		<tr class="list-row hide">
			<td colspan="11" class="list-end-row-td"><div class="detail"></div></td>
		</tr>
		<!-- 리스트데이터 : 끝 -->

<?php if($TPL_V1["last_step_cnt"]){?>
		<!-- 합계 : 시작 -->
		<tr class="list-end-row">
			<td colspan="11" class="list-end-row-td">
				<ul class="left-btns clearbox" style="margin-top:2px">
					<li>
						<select class="list-select custom-select-box-multi" name="select_<?php echo $TPL_V1["status"]?>"  rows="4">
						<option value="select">전체선택</option>
						<option value="not-select">선택안함</option>
						<option value="important">별표선택</option>
						<option value="not-important">별표없음</option>
						</select>
					</li>
					<li>
						<span class="btn small"><button name="goods_print" id="<?php echo $TPL_V1["status"]?>" class="hand resp_btn v3" align="absmiddle"><img src="/admin/skin/default/images/common/icon_order_2.png"/><span>프린트</span></button></span>	
				
<?php if($TPL_VAR["status_invoice_cnt"][$TPL_V1["status"]]){?>
						<span class="btn small"><button name="invoice_print" id="<?php echo $TPL_V1["status"]?>" class="hand resp_btn v3" align="absmiddle"><img src="/admin/skin/default/images/common/icon_order_3.png"/><span>프린트</span></button></span>					
<?php }?>

<?php if($TPL_V1["status"]=='45'){?>
						<span class="btn small red" onclick="export_proc('45','<?php echo $TPL_V1["status"]?>');"><button type="button" class="resp_btn active">출고상태변경</button></span>
<?php }elseif($TPL_V1["status"]=='55'){?>
						<span class="btn small red" onclick="export_proc('55','<?php echo $TPL_V1["status"]?>');"><button type="button" class="resp_btn active">출고상태변경</button></span>
<?php }elseif($TPL_V1["status"]=='65'){?>
						<span class="btn small red" onclick="export_proc('65','<?php echo $TPL_V1["status"]?>');"><button type="button" class="resp_btn active">출고상태변경</button></span>
<?php }?>

<?php if($TPL_V1["status"]=='45'||($TPL_VAR["scm_cfg"]['use']!='Y'&&$TPL_V1["status"]=='55')||$TPL_V1["status"]=='65'){?>
							<span class="hand reverse_export resp_btn v3" id="<?php echo $TPL_V1["status"]?>">
<?php if($TPL_V1["status"]=='45'){?>
								'상품준비' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_VAR["scm_cfg"]['use']!='Y'&&$TPL_V1["status"]=='55'){?>
								'출고준비' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_V1["status"]=='65'){?>
								'출고완료' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }?>
							</span>

<?php if($TPL_V1["status"]=='45'){?>
							<span class="helpicon" title="출고 준비된 상품을 상품준비로 되돌릴 수 있습니다."></span> 
<?php }elseif($TPL_VAR["scm_cfg"]['use']!='Y'&&$TPL_V1["status"]=='55'){?>
							<span class="helpicon" title="출고 완료된 상품을 출고준비로 되돌릴 수 있습니다.<br/>이 때 출고완료 시 차감된 재고 수량이 환원됩니다."></span>
<?php }elseif($TPL_V1["status"]=='65'){?>
							<span class="helpicon" title="배송 중인 상품을 출고완료로 되돌릴 수 있습니다."></span>
<?php }?>
<?php }?>
					</li>
				</ul>
				<div class="list-end-total-amount">
					<span class="order-step-color-<?php echo $TPL_V1["step"]?>"><?php echo $TPL_V1["mstatus"]?></span> <span class="darkgray">합계</span> &nbsp; <?php echo number_format($TPL_V1["last_step_cnt"])?>건
					&nbsp;&nbsp;&nbsp;
					￦ <span class="fx14 order-step-color-<?php echo $TPL_V1["step"]?>"><?php echo number_format($TPL_V1["last_step_settleprice"])?></span>
				</div>
			</td>
		</tr>
		<!-- 합계 : 끝 -->
<?php }?>

<?php }}?>
<?php if($TPL_VAR["record"]){?>
	<tr class="list-row pageoverflow">
		<td colspan="11" align="center" class="btn_destory" ><span class="btn large"><button type="button" name="order_admin_person" class="resp_btn v2 size_S" onclick="get_catalog_ajax();">더 보기 <span class="arrowright"></span></button></span></td>
	</tr>
<?php }?>
<?php }?>
	<input type="hidden" id="<?php echo $TPL_VAR["page"]?>_no" value="<?php echo $TPL_VAR["final_no"]?>" />
	<input type="hidden" id="<?php echo $TPL_VAR["page"]?>_step" value="<?php echo $TPL_VAR["final_step"]?>" />