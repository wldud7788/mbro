<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/order/catalog_ajax.html 000034375 */ 
$TPL_down_forms_1=empty($TPL_VAR["down_forms"])||!is_array($TPL_VAR["down_forms"])?0:count($TPL_VAR["down_forms"]);
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php if($TPL_VAR["page"]== 1){?>
		<tr class="list-row">
			<td colspan="<?php if($TPL_VAR["pagemode"]=='company_catalog'){?>12<?php }else{?>15<?php }?>" align="center">
				<ul class="right-btns">
					<li>
						<select class="custom-select-box" id="excel_type_0">
							<option value="">타입선택</option>
							<option value="select">선택 다운로드</option>
							<option value="search">검색 다운로드</option>
						</select>
						<select class="custom-select-box" id="select_down_0">
							<option value="">양식선택</option>
<?php if($TPL_down_forms_1){foreach($TPL_VAR["down_forms"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["seq"]?>"><?php echo $TPL_V1["name"]?></option>
<?php }}?>
						</select>
						<span class="btn small"><button name="excel_down" onclick="excel_down('0')" class="resp_btn v3"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle"  /><span>전체다운로드</span></button></span>
					</li>
				</ul>
			</td>
		</tr>
<?php }?>	

<?php if(!$TPL_VAR["record"]&&$TPL_VAR["page"]== 1){?>
		<tr class="list-row">
			<td colspan="<?php if($TPL_VAR["pagemode"]=='company_catalog'){?>12<?php }else{?>15<?php }?>" align="center">검색어가 없거나 검색 결과가 없습니다.</td>
		</tr>
<?php }else{?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>

<?php if($TPL_V1["end_step_cnt"]){?>
		<!-- 합계 : 시작 -->
		<tr class="list-end-row">
			<td colspan="<?php if($TPL_VAR["pagemode"]=='company_catalog'){?>12<?php }else{?>15<?php }?>" class="list-end-row-td">
<?php if($TPL_VAR["no_receipt_address"]==false){?>
				<ul class="left-btns" style="margin-top:2px;">
					<li>
						<select class="list-select custom-select-box-multi" name="select_<?php echo $TPL_V1["end_step"]?>"  rows="4" onchange="list_select(this)">
							<option value="select" <?php if($TPL_VAR["stepBox"][$TPL_V1["end_step"]]=='select'){?>selected<?php }?>>전체선택</option>
							<option value="not-select" <?php if($TPL_VAR["stepBox"][$TPL_V1["end_step"]]=='not-select'){?>selected<?php }?>>선택안함</option>
<?php if($TPL_VAR["pagemode"]!="company_catalog"){?>
							<option value="important" <?php if($TPL_VAR["stepBox"][$TPL_V1["end_step"]]=='important'){?>selected<?php }?>>별표선택</option>
							<option value="not-important" <?php if($TPL_VAR["stepBox"][$TPL_V1["end_step"]]=='not-important'){?>selected<?php }?>>별표없음</option>
<?php }?>
						</select>
					</li>
					<li>
<?php if($TPL_V1["end_step"]=='15'){?>
						<span class="btn small green"><button name="order_deposit" id="<?php echo $TPL_V1["end_step"]?>" onclick="batch_order_deposit(this)" class="resp_btn active4">결제확인</button></span>
						<span class="btn small gray"><button name="cancel_order"  id="<?php echo $TPL_V1["end_step"]?>" onclick="batch_cancel_order(this);" class="resp_btn v2">주문무효</button></span>
<?php }?>

<?php if(in_array($TPL_V1["end_step"],array('25'))){?>
						<span class="btn small deepgreen"><button name="batch_goods_ready"  id="<?php echo $TPL_V1["end_step"]?>" onclick="batch_goods_ready(this);" class="resp_btn active5">상품준비</button></span>
<?php }?>

<?php if(in_array($TPL_V1["end_step"],array('25','35','40','50','60','70'))){?>
						<span class="btn small red"><button name="goods_export" id="<?php echo $TPL_V1["end_step"]?>"  onclick="batch_goods_export(<?php echo $TPL_V1["end_step"]?>);" class="resp_btn active">출고처리</button></span>
<?php }?>
<?php if(in_array($TPL_V1["end_step"],array('95','99'))){?>
						<span class="btn small"><button name="goods_temps"  id="<?php echo $TPL_V1["end_step"]?>" onclick="batch_delete_order(this);" class="resp_btn v3">삭제처리</button></span>
<?php }?>
						<span class="btn small"><button name="goods_print" id="<?php echo $TPL_V1["end_step"]?>" class="hand resp_btn v3" align="absmiddle"  onclick="order_print(this);"><img src="/admin/skin/default/images/common/icon_order.png"/><span>프린트</span></button></span>						
						
<?php if($TPL_V1["end_step"]=='25'||$TPL_V1["end_step"]=='35'||$TPL_V1["end_step"]=='95'){?>
							<span class="hand batch_reverse resp_btn v3" id="<?php echo $TPL_V1["end_step"]?>"  onclick="batch_reverse(this);" autodepositKey="<?php if($TPL_VAR["bankChk"]=='Y'){?><?php echo $TPL_V1["autodeposit_key"]?><?php }?>">
<?php if($TPL_V1["end_step"]=='25'){?>
							'주문접수' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_V1["end_step"]=='35'){?>
							'결제확인' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_V1["end_step"]=='95'){?>
							'주문접수' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }?>
							</span>
<?php }?>

<?php if($TPL_V1["end_step"]=='25'){?>
						<span class="helpicon" title="취소, 반품, 환불이 없는 무통장 주문건을 주문접수(미입금)로 되돌릴 수 있습니다."></span>
<?php }elseif($TPL_V1["end_step"]=='35'){?>
						<span class="helpicon" title="상품준비 중인 주문을 결제확인으로 되돌릴 수 있습니다."></span>
<?php }elseif($TPL_V1["end_step"]=='95'){?>
						<span class="helpicon" title="주문이 무효된 주문을 다시 주문접수로 되돌릴 수 있습니다."></span>
<?php }?>
					</li>
				</ul>
<?php }?>
				<div class="list-end-total-amount">
					<span class="order-step-color-<?php echo $TPL_V1["end_step"]?>"><?php echo $TPL_V1["end_mstep"]?></span> <span class="darkgray">합계</span> &nbsp; <?php echo number_format($TPL_V1["end_step_cnt"])?>건
					<?php echo $TPL_VAR["currency_symbol"]['symbol']?> <span class="fx14 order-step-color-<?php echo $TPL_V1["end_step"]?>"><?php echo get_currency_price($TPL_V1["end_step_settleprice"], 4)?></span>
				</div>
			</td>
		</tr>
		<!-- 합계 : 끝 -->
<?php }?>

<?php if($TPL_V1["start_step"]){?>
		<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
		<tr class="list-title-row">
			<td colspan="<?php if($TPL_VAR["pagemode"]=='company_catalog'){?>12<?php }else{?>15<?php }?>" class="list-title-row-td list-title-row-td-step-<?php echo $TPL_V1["step"]?>">
				<div class="relative clearbox">
<?php if($TPL_V1["step"]== 15){?>
					<div class="ltr-title ltr-title-step-<?php echo $TPL_V1["step"]?>">
<?php }else{?>
					<div class="ltr-title ltr-title-step-<?php echo $TPL_V1["step"]?>">
<?php }?>
						<div class="btn-open-all"><img src="/admin/skin/default/images/common/icon/btn_open_all.gif" class="btn_open_all" id="<?php echo $TPL_V1["step"]?>" onclick="btn_open_all(this);" /></div>
<?php if($TPL_V1["step"]== 15){?>
						<span class="step_title">(출고 전)</span>주문접수
						<span class="helpicon" title="접수된 주문의 입금을 확인하세요"></span>
<?php }elseif($TPL_V1["step"]== 25){?>
						<span class="step_title">(출고 전)</span>결제확인
						<span class="helpicon" title="결제가 확인된 주문의 상품을 출고하세요"></span>
<?php }elseif($TPL_V1["step"]== 35){?>
						<span class="step_title">(출고 전)</span>상품준비
						<span class="helpicon" title="보내지 못했던 상품의 재고가 확보되셨다면 상품을 출고하세요"></span>
<?php }elseif($TPL_V1["step"]== 40){?>
						<span class="step_title">(출고 전)</span>부분 출고준비
						<span class="helpicon" title="보내지 못했던 상품의 재고가 확보되셨다면 상품을 출고하세요"></span>
						<a href='../export/catalog?export_status[45]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
<?php }elseif($TPL_V1["step"]== 45){?>
						<span class="step_title">(출고 전)</span> 출고준비
						<span class="helpicon" title="출고리스트에서 출고완료를 처리하세요. 출고수량만큼 재고가 자동 차감됩니다"></span>
						<a href='../export/catalog?export_status[45]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
<?php }elseif($TPL_V1["step"]== 50){?>
						<span class="step_title">(출고 후)</span>
						부분 출고완료 <span class="helpicon" title="보내지 못했던 상품의 재고가 확보되셨다면 상품을 출고하세요"></span>
						<a href='../export/catalog?export_status[55]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
<?php }elseif($TPL_V1["step"]== 55){?>
						<span class="step_title">(출고 후)</span>출고완료
						<span class="helpicon" title="출고리스트에서 배송완료를 처리하세요."></span>
						<a href='../export/catalog?export_status[55]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
<?php }elseif($TPL_V1["step"]== 60){?>
						<span class="step_title">(출고 후)</span>부분 배송 중
						<span class="helpicon" title="보내지 못했던 상품의 재고가 확보되셨다면 상품을 출고하세요"></span>
						<a href='../export/catalog?export_status[65]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
<?php }elseif($TPL_V1["step"]== 65){?>
						<span class="step_title">(출고 후)</span>배송 중
						<span class="helpicon" title="출고리스트에서 배송완료를 처리하세요."></span>
						<a href='../export/catalog?export_status[65]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
<?php }elseif($TPL_V1["step"]== 70){?>
						<span class="step_title">(출고 후)</span>부분 배송완료
						<span class="helpicon" title="보내지 못했던 상품의 재고가 확보되셨다면 상품을 출고하세요"></span>
						<a href='../export/catalog?export_status[75]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
<?php }elseif($TPL_V1["step"]== 75){?>
						<span class="step_title">(출고 후)</span>배송완료
						<span class="helpicon" title="배송이 완료되었습니다."></span>
						<a href='../export/catalog?export_status[75]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
<?php }elseif($TPL_V1["step"]== 85){?>
						<span class="step_title">(출고 전)</span>결제취소(전체)
						<span class="helpicon" title="결제를 취소한 주문입니다. 환불리스트에서 환불을 처리하세요."></span>
<?php }elseif($TPL_V1["step"]== 95){?>
						<span class="step_title">(출고 전)</span>주문무효
						<span class="helpicon" title="입금이 안되어 무효 처리된 주문입니다"></span>
<?php }elseif($TPL_V1["step"]== 99){?>
						<span class="step_title">(출고 전)</span>결제실패
						<span class="helpicon" title="주문할 때 오류가 발생한 주문입니다"></span>
<?php }?>
					</div>
<?php if($TPL_VAR["no_receipt_address"]==false){?>
					<ul class="left-btns">
						<li>
							<select class="list-select custom-select-box-multi" name="select_<?php echo $TPL_V1["step"]?>"  rows="4" onchange="list_select(this)">
							<option value="select">전체선택</option>
							<option value="not-select">선택안함</option>
<?php if($TPL_VAR["pagemode"]!="company_catalog"){?>
							<option value="important">별표선택</option>
							<option value="not-important">별표없음</option>
<?php }?>
							</select>
						</li>
						<li>
<?php if($TPL_V1["step"]=='15'){?>
							<span class="btn small green"><button name="order_deposit" id="<?php echo $TPL_V1["step"]?>" onclick="batch_order_deposit(this)" class="resp_btn active4">결제확인</button></span>
							<span class="btn small gray"><button name="cancel_order"  id="<?php echo $TPL_V1["step"]?>" onclick="batch_cancel_order(this);" class="resp_btn v2">주문무효</button></span>
<?php }?>

<?php if(in_array($TPL_V1["step"],array('25'))){?>
							<span class="btn small deepgreen"><button name="batch_goods_ready"  id="<?php echo $TPL_V1["step"]?>" onclick="batch_goods_ready(this);" class="resp_btn active5">상품준비</button></span>
<?php }?>

<?php if(in_array($TPL_V1["step"],array('25','35','40','50','60','70'))){?>
							<span class="btn small red"><button name="goods_export"  id="<?php echo $TPL_V1["step"]?>" onclick="batch_goods_export(<?php echo $TPL_V1["step"]?>);" class="resp_btn active">출고처리</button></span>
<?php }?>

<?php if(in_array($TPL_V1["step"],array('95','99'))){?>
							<span class="btn small"><button name="goods_temps"  id="<?php echo $TPL_V1["step"]?>" onclick="batch_delete_order(this);" class="resp_btn v3">삭제처리</button></span>
<?php }?>

							<span class="btn small"><button name="goods_print" id="<?php echo $TPL_V1["step"]?>" class="hand resp_btn v3" align="absmiddle"  onclick="order_print(this);"><img src="/admin/skin/default/images/common/icon_order.png"/><span>프린트</span></button></span>

<?php if($TPL_V1["step"]=='25'||$TPL_V1["step"]=='35'||$TPL_V1["step"]=='95'){?>
							<span class="hand batch_reverse resp_btn v3" id="<?php echo $TPL_V1["step"]?>" onclick="batch_reverse(this);" autodepositKey="<?php if($TPL_VAR["bankChk"]=='Y'){?><?php echo $TPL_V1["autodeposit_key"]?><?php }?>">
<?php if($TPL_V1["step"]=='25'){?>
							'주문접수' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_V1["step"]=='35'){?>
							'결제확인' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_V1["step"]=='95'){?>
							'주문접수' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }?>
							</span>
<?php }?>

<?php if($TPL_V1["step"]=='25'){?>
							<span class="helpicon" title="취소, 반품, 환불이 없는 무통장 주문건을 주문접수(미입금)로 되돌릴 수 있습니다."></span>
<?php }elseif($TPL_V1["step"]=='35'){?>
							<span class="helpicon" title="상품준비 중인 주문을 결제확인으로 되돌릴 수 있습니다."></span>
<?php }elseif($TPL_V1["step"]=='95'){?>
							<span class="helpicon" title="주문이 무효된 주문을 다시 주문접수로 되돌릴 수 있습니다."></span>
<?php }?>
						</li>
					</ul>

					<div style="float: right; padding: 5px 0;" class="right-btns">
						<!-- EXCEL -->
						<ul style="display:inline-block;">
							<li>
								<select class="custom-select-box" id="excel_type_<?php echo $TPL_V1["step"]?>">
									<option value="">타입선택</option>
									<option value="select">선택 다운로드</option>
									<option value="search">검색 다운로드</option>
								</select>
								<select class="custom-select-box" id="select_down_<?php echo $TPL_V1["step"]?>">
									<option value="">양식선택</option>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
									<option value="<?php echo $TPL_V2["seq"]?>"><?php echo $TPL_V2["name"]?></option>
<?php }}?>
								</select>
								<span class="btn small"><button name="excel_down" onclick="excel_down('<?php echo $TPL_V1["step"]?>')" class="resp_btn v3"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /><span>일괄다운로드</span></button></span>
<?php if($TPL_V1["step"]< 45&&$TPL_V1["step"]> 15){?>
								<span class="btn small"><button name="excel_upload" onclick="view_excel_upload_help();" class="resp_btn v3"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /><span>일괄업로드(송장)</span></button></span>
<?php }?>
							</li>
						</ul>
					</div>
<?php }?>
				</div>
			</td>
		</tr>
		<!-- 리스트타이틀(주문상태 및 버튼) : 끝 -->
<?php }?>

		<tr class="list-row step<?php echo $TPL_V1["step"]?> important_<?php echo $TPL_V1["order_seq"]?> <?php if($TPL_V1["thischeck"]){?>checked-tr-background<?php }?>">
			<td align="center"><input type="checkbox" name="order_seq[]" value="<?php echo $TPL_V1["order_seq"]?>" <?php if($TPL_V1["thischeck"]){?>checked<?php }?> accumul_mark="<?php echo $TPL_V1["accumul_mark"]?>" onchange="color_order_seq(this)" class="resp_checkbox"/></td>
			<td align="center" <?php if($TPL_VAR["pagemode"]=='company_catalog'){?>class="hide"<?php }?>>
<?php if($TPL_V1["important"]){?>
			<span class="icon-star-gray hand checked list-important important-<?php echo $TPL_V1["step"]?>" id="important_<?php echo $TPL_V1["order_seq"]?>" onclick="list_important(this)" ></span>
<?php }else{?>
			<span class="icon-star-gray hand list-important important-<?php echo $TPL_V1["step"]?>" id="important_<?php echo $TPL_V1["order_seq"]?>" onclick="list_important(this)"></span>
<?php }?>
			</td>
			<td align="center" class="ft11"><?php echo $TPL_V1["no"]?></td>

			<td align="center">
<?php if($TPL_V1["referer"]){?><a href="<?php if($TPL_V1["referer_naver"]){?><?php echo $TPL_V1["referer_naver"]?><?php }else{?><?php echo $TPL_V1["referer"]?><?php }?>" target="_blank"><?php }?>
				<span class="help" title="<?php echo $TPL_V1["referer_name"]?> <?php if($TPL_V1["referer_naver"]){?><?php echo $TPL_V1["referer_naver"]?><?php }else{?><?php echo $TPL_V1["referer"]?><?php }?>" style="font-size:11px;font-weight:bold;color:#006666;"><?php echo getstrcut($TPL_V1["referer_name"], 1,'')?></span>
<?php if($TPL_V1["referer"]){?></a><?php }?>
			</td>
			<td align="center">
				<span class="help blue bold" title="<?php echo $TPL_V1["linkage_mallname"]?>" style="font-size:11px;">
<?php if(is_numeric(mb_substr($TPL_V1["linkage_mallname"], 0, 1))){?>
					<?php echo mb_substr($TPL_V1["linkage_mallname"], 0, 2)?>

<?php }else{?>
					<?php echo mb_substr($TPL_V1["linkage_mallname"], 0, 1)?>

<?php }?>
				</span>
			</td>
			<td align="center" class="ft11"><?php echo substr($TPL_V1["regist_date"], 2, - 3)?></td>
			<td align="center" class="ft11">
<?php if($TPL_V1["sitetype"]=="M"||$TPL_V1["sitetype"]=="OFF_M"){?><span title="모바일">모</span>
<?php }elseif($TPL_V1["sitetype"]=="F"||$TPL_V1["sitetype"]=="OFF_F"){?><span title="페이스북">페</span>
<?php }elseif($TPL_V1["sitetype"]=="APP_ANDROID"){?><span class="icon_app_android" title="안드로이드">안</span>
<?php }elseif($TPL_V1["sitetype"]=="APP_IOS"){?><span class="icon_app_ios" title="iOS">iOS</span>
<?php }elseif($TPL_V1["sitetype"]=="POS"){?><span title="오프라인매장">매장</span>
<?php }else{?><span title="PC">PC</span><?php }?>
			</td>
			<td align="left" class="ft11 left">
<?php if($TPL_V1["marketplacetitle"]&&$TPL_V1["marketplace"]!='etc'){?><span style="display:inline-block;"><?php echo $TPL_V1["marketplacetitle"]?></span><?php }?>
<?php if($TPL_V1["orign_order_seq"]||$TPL_V1["admin_order"]||$TPL_V1["person_seq"]||$TPL_V1["label"]){?>
				<div class="desc pdt3">
<?php if($TPL_V1["orign_order_seq"]){?> 교환주문<?php }?>
<?php if($TPL_V1["admin_order"]){?> 관리자주문<?php }?>
<?php if($TPL_V1["person_seq"]){?> 개인결제<?php }?>
<?php if($TPL_V1["label"]){?> <span class="order_lable <?php echo $TPL_V1["label"]?>"><img src="/admin/skin/default/images/design/icon_order_<?php echo $TPL_V1["label"]?>.gif" style="width: 14px"></span><?php }?>
				</div><?php }?>
				<!--######################## 16.12.15 gcs yjy : 검색조건 유지되도록 -->
				<a href="javascript:orderView('<?php echo $TPL_V1["order_seq"]?>')"><span class="order-step-color-<?php echo $TPL_V1["step"]?> bold"><?php echo $TPL_V1["order_seq"]?></span></a>

				<a href="javascript:printOrderView('<?php echo $TPL_V1["order_seq"]?>', 'catalog')"><span class="icon-print-order"></span></a>			
				<a href="view?no=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><span class="btn-administration"><span class="hide">새창</span></span></a>
				<span class="btn-direct-open" onclick="btn_direct_open(this);"><span class="hide">바로열기</span></span>

<?php if($TPL_V1["linkage_mall_order_id"]){?>
				<div class="blue bold"><?php echo $TPL_V1["linkage_mall_order_id"]?> (<?php echo $TPL_V1["linkage_mallname_text"]?>)</div>
<?php }else{?>
<?php if($TPL_V1["npay_order_id"]){?><div class="ngreen bold"><?php echo $TPL_V1["npay_order_id"]?><span style="font-size:11px;font-weight:normal"> (Npay주문번호) </span></div><?php }?>
<?php if($TPL_V1["talkbuy_order_id"]){?><div class="kyellow bold"><?php echo $TPL_V1["talkbuy_order_id"]?><span style="font-size:11px;font-weight:normal"> (Kpay주문번호) </span></div><?php }?>
<?php }?>
<?php if($TPL_V1["linkage_id"]=='pos'){?>
				<div class="blue bold"><?php echo $TPL_V1["linkage_order_id"]?> (<?php echo $TPL_V1["linkage_mallname_text"]?>)</div>
<?php }?>
			</td>
			<td class="left" align="left"><div class="goods_name"><?php echo $TPL_V1["goods_name"]?> <?php if($TPL_V1["item_cnt"]> 1){?>외 <?php echo $TPL_V1["item_cnt"]- 1?>종<?php }?></div></td>
			<td class="right"><?php echo $TPL_V1["tot_ea"]?>(<?php echo $TPL_V1["item_cnt"]?>종)</td>
			<td align="center" class="ft11">
<?php if($TPL_V1["step"]>= 40&&$TPL_V1["step"]<= 75){?>
			<a href="../export/catalog?hsb_kind=export&header_search_keyword=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><span class="order-step-color-<?php echo $TPL_V1["step"]?> hand"><?php if($TPL_V1["bundle_yn"]=='y'){?>[합]<?php }?>출고▶</span></a>
<?php }?>
			</td>
			<td class="ft11 hand" onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','<?php echo $TPL_V1["order_seq"]?>','right');">
<?php if($TPL_V1["recipient_user_name"]!=$TPL_V1["order_user_name"]){?>
					<div style="margin-top:5px;"><?php echo $TPL_V1["recipient_user_name"]?></div>
<?php }?>

					<div style="margin-bottom:3px;">
<?php if($TPL_V1["member_seq"]){?>
<?php if($TPL_V1["member_type"]=='개인'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" vspace="0" align="absmiddle" />
<?php }elseif($TPL_V1["member_type"]=='기업'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" vspace="0" align="absmiddle" /><?php }?>
					<span><?php echo $TPL_V1["order_user_name"]?></span>
<?php if($TPL_V1["sns_rute"]){?>
						<span>(<img src="/admin/skin/default/images/sns/sns_<?php echo substr($TPL_V1["sns_rute"], 0, 1)?>0.gif" align="absmiddle" class="btnsnsdetail">/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
						</span>
<?php if($TPL_V1["blacklist"]){?><img src="/admin/skin/default/images/common/ico_blacklist_<?php echo $TPL_V1["blacklist"]?>.png" align="absmiddle" alt="블랙리스트_<?php echo $TPL_V1["blacklist"]?>" /><?php }else{?><img src="/admin/skin/default/images/common/ico_angel.png" align="absmiddle" alt="엔젤회원" /><?php }?>
<?php }else{?>
						(<span style="color:#d13b00;"><?php echo $TPL_V1["userid"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span></a>)
<?php if($TPL_V1["blacklist"]){?><img src="/admin/skin/default/images/common/ico_blacklist_<?php echo $TPL_V1["blacklist"]?>.png" align="absmiddle" alt="블랙리스트_<?php echo $TPL_V1["blacklist"]?>" /><?php }else{?><img src="/admin/skin/default/images/common/ico_angel.png" align="absmiddle" alt="엔젤회원" /><?php }?>
<?php }?>
<?php }else{?>
					<img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <span><?php echo $TPL_V1["order_user_name"]?></span> (<span class="desc">비회원</span>)
<?php if($TPL_V1["ordblacklist"]){?><img src="/admin/skin/default/images/common/ico_blacklist_<?php echo $TPL_V1["ordblacklist"]?>.png" align="absmiddle" alt="블랙리스트_<?php echo $TPL_V1["ordblacklist"]?>" /><?php }else{?><img src="/admin/skin/default/images/common/ico_angel.png" align="absmiddle" alt="엔젤회원" /><?php }?>
<?php }?>
					</div>
			</td>

			<!--// 결제 수단 //-->
			<td align="right" class="ft11">
<?php if($TPL_V1["linkage_id"]!='connector'){?>
<?php if($TPL_V1["payment"]=='bank'){?>
<?php if($TPL_V1["order_user_name"]==$TPL_V1["depositor"]){?>
				<span class="darkgray"><span title="입금자명"><?php echo $TPL_V1["depositor"]?></span></span>
<?php }else{?>
				<span class="blue"><span title="입금자명"><?php echo $TPL_V1["depositor"]?></span></span>
<?php }?>
<?php }else{?>
<?php if($TPL_V1["pg"]=='npay'){?>
				<span class="icon-pay-<?php echo $TPL_V1["pg"]?>" title="naver pay"><span>npay</span></span>
<?php }elseif($TPL_V1["pg"]=='kakaopay'){?>
				<span class="icon-pay-kakaopay-simple" title="kakaopay"><span>kakaopay</span></span>
<?php }elseif($TPL_V1["pg"]=='talkbuy'){?>
				<span class="icon-pay-talkbuy-simple" title="talkbuy"><span>talkbuy</span></span>
<?php }else{?>
				<span class="icon-pay-<?php echo $TPL_V1["pg"]?>-simple" title="<?php echo $TPL_V1["pg"]?>"><span><?php echo $TPL_V1["pg"]?></span></span>
<?php }?>
<?php }?>

<?php if($TPL_V1["payment"]=='escrow_account'){?>
				<span class="icon-pay-escrow" title="에스크로"><span>에스크로</span></span>
				<span class="icon-pay-account" title="<?php echo $TPL_V1["mpayment"]?>"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }elseif($TPL_V1["payment"]=='escrow_virtual'){?>
				<span class="icon-pay-escrow" title="에스크로"><span>에스크로</span></span>
				<span class="icon-pay-virtual" title="<?php echo $TPL_V1["mpayment"]?>"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }elseif($TPL_V1["pg"]=='talkbuy'&&$TPL_V1["payment"]=='point'){?>
				<span class="icon-pay-kakaomoney" title="카카오페이 머니"><span></span></span>
<?php }elseif($TPL_V1["pg"]!='kakaopay'){?>
				<span class="icon-pay-<?php echo $TPL_V1["payment"]?>" title="<?php echo $TPL_V1["mpayment"]?>"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }?>
<?php if($TPL_V1["payment"]=='bank'&&$TPL_V1["bank_name"]){?>
				<span class="darkgray"><span title="은행명"><?php echo $TPL_V1["bank_name"]?></span></span>
<?php }?>
<?php }?>
<?php if($TPL_V1["deposit_date"]){?>
				 <div class="pdt5"><?php echo substr($TPL_V1["deposit_date"], 2, - 3)?></div>
<?php }?>
			</td>

<?php if($TPL_VAR["pagemode"]!="company_catalog"){?>
			<td align="right" style="padding-right:5px;"><b><?php echo get_currency_price($TPL_V1["settleprice"], 4)?></b></td>
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
<?php }?>
		</tr>

		<tr class="order-list-summary-row hide">
			<td colspan="<?php if($TPL_VAR["pagemode"]=='company_catalog'){?>12<?php }else{?>15<?php }?>" class="order-list-summary-row-td"><div class="order_info"></div></td>
		</tr>
		<!-- 리스트데이터 : 끝 -->

<?php if($TPL_V1["last_step_cnt"]){?>
		<!-- 합계 : 시작 -->
		<tr class="list-end-row">
			<td colspan="<?php if($TPL_VAR["pagemode"]=='company_catalog'){?>12<?php }else{?>15<?php }?>" class="list-end-row-td">
<?php if($TPL_VAR["no_receipt_address"]==false){?>
				<ul class="left-btns" style="margin-top:2px;">
					<li>
						<select class="list-select custom-select-box-multi" name="select_<?php echo $TPL_V1["last_step"]?>"  rows="4" onchange="list_select(this)">
						<option value="select" <?php if($TPL_VAR["stepBox"][$TPL_V1["last_step"]]=='select'){?>selected<?php }?>>전체선택</option>
						<option value="not-select" <?php if($TPL_VAR["stepBox"][$TPL_V1["last_step"]]=='not-select'){?>selected<?php }?>>선택안함</option>
<?php if($TPL_VAR["pagemode"]!="company_catalog"){?>
						<option value="important" <?php if($TPL_VAR["stepBox"][$TPL_V1["last_step"]]=='important'){?>selected<?php }?>>별표선택</option>
						<option value="not-important" <?php if($TPL_VAR["stepBox"][$TPL_V1["last_step"]]=='not-important'){?>selected<?php }?>>별표없음</option>
<?php }?>
						</select>
					</li>
					<li>
<?php if($TPL_V1["last_step"]=='15'){?>
						<span class="btn small green"><button name="order_deposit" id="<?php echo $TPL_V1["last_step"]?>" onclick="batch_order_deposit(this)" class="resp_btn active4">결제확인</button></span>
						<span class="btn small gray"><button name="cancel_order"  id="<?php echo $TPL_V1["last_step"]?>" onclick="batch_cancel_order(this);" class="resp_btn v3">주문무효</button></span>
<?php }?>

<?php if(in_array($TPL_V1["last_step"],array('25'))){?>
						<span class="btn small deepgreen"><button name="batch_goods_ready"  id="<?php echo $TPL_V1["last_step"]?>" onclick="batch_goods_ready(this);" class="resp_btn active5">상품준비</button></span>
<?php }?>

<?php if(in_array($TPL_V1["last_step"],array('25','35','40','50','60','70'))){?>
						<span class="btn small red"><button name="goods_export"  id="<?php echo $TPL_V1["last_step"]?>" onclick="batch_goods_export(<?php echo $TPL_V1["last_step"]?>);" class="resp_btn active">출고처리</button></span>
<?php }?>

<?php if(in_array($TPL_V1["last_step"],array('95','99'))){?>
						<span class="btn small"><button name="goods_temps"  id="<?php echo $TPL_V1["last_step"]?>" onclick="batch_delete_order(this);" class="resp_btn v3">삭제처리</button></span>
<?php }?>
						<span></span>

						<span class="btn small"><button name="goods_print" id="<?php echo $TPL_V1["last_step"]?>" class="hand resp_btn v3" align="middle"  onclick="order_print(this);"><img src="/admin/skin/default/images/common/icon_order.png"/><span>프린트</span></button></span>				
						
<?php if($TPL_V1["last_step"]=='25'||$TPL_V1["last_step"]=='35'||$TPL_V1["last_step"]=='95'){?>
						<span class="hand batch_reverse resp_btn v3" id="<?php echo $TPL_V1["last_step"]?>" onclick="batch_reverse(this);" autodepositKey="<?php if($TPL_VAR["bankChk"]=='Y'){?><?php echo $TPL_V1["autodeposit_key"]?><?php }?>" >
<?php if($TPL_V1["step"]=='25'){?>
						'주문접수' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_V1["step"]=='35'){?>
						'결제확인' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_V1["step"]=='95'){?>
						'주문접수' 상태로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }?>
						</span>
<?php }?>

<?php if($TPL_V1["step"]=='25'){?>
						<span class="helpicon" title="취소, 반품, 환불이 없는 무통장 주문건을 주문접수(미입금)로 되돌릴 수 있습니다."></span>
<?php }elseif($TPL_V1["step"]=='35'){?>
						<span class="helpicon" title="상품준비 중인 주문을 결제확인으로 되돌릴 수 있습니다."></span>
<?php }elseif($TPL_V1["step"]=='95'){?>
						<span class="helpicon" title="주문이 무효된 주문을 다시 주문접수로 되돌릴 수 있습니다."></span>
<?php }?>
					</li>
				</ul>
<?php }?>
				<div class="list-end-total-amount">
					<span class="order-step-color-<?php echo $TPL_V1["last_step"]?>"><?php echo $TPL_V1["mstep"]?></span> <span class="darkgray">합계</span> &nbsp; <?php echo number_format($TPL_V1["last_step_cnt"])?>건
					&nbsp;&nbsp;&nbsp;
					<?php echo $TPL_VAR["currency_symbol"]['symbol']?> <span class="fx14 order-step-color-<?php echo $TPL_V1["last_step"]?>"><?php echo get_currency_price($TPL_V1["last_step_settleprice"], 4)?></span>
				</div>
			</td>
		</tr>
		<!-- 합계 : 끝 -->
<?php }?>

<?php }}?>
<?php if($TPL_VAR["record"]){?>
	<tr class="list-row pageoverflow">
		<td colspan="<?php if($TPL_VAR["pagemode"]=='company_catalog'){?>12<?php }else{?>15<?php }?>" align="center"  class="btn_destory" ><span class="btn large"><button type="button" name="order_admin_person"  class="resp_btn v2 size_S" onclick="get_catalog_ajax();">더 보기 <span class="arrowright"></span></button></span></td>
	</tr>
<?php }?>
<?php }?>
		<input type="hidden" id="<?php echo $TPL_VAR["page"]?>_no" value="<?php echo $TPL_VAR["final_no"]?>" />
		<input type="hidden" id="<?php echo $TPL_VAR["page"]?>_step" value="<?php echo $TPL_VAR["final_step"]?>" />
		<input type="hidden" id="<?php echo $TPL_VAR["page"]?>_last_step_cnt" value="<?php echo $TPL_VAR["last_step_cnt"]?>" />
		<input type="hidden" id="<?php echo $TPL_VAR["page"]?>_last_step_settleprice" value="<?php echo $TPL_VAR["last_step_settleprice"]?>" />