<?php /* Template_ 2.2.6 2021/08/25 16:14:39 /www/music_brother_firstmall_kr/admin/skin/default/goods/_social_for_regist.html 000015810 */ 
$TPL_socialcpcancels_1=empty($TPL_VAR["socialcpcancels"])||!is_array($TPL_VAR["socialcpcancels"])?0:count($TPL_VAR["socialcpcancels"]);?>
<div class="item-title">티켓정보</div>
<input type="hidden" name="goods_kind" id="goods_kind" value="coupon" />
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="15%" />
		<col width="12%" />
		<col/>
		<col width="18%" />
		<col width="12%" />
	</colgroup>
	<tbody>
		<tr>
			<th class="its-th-align center" >티켓상품그룹</td>
			<td class="its-td"  colspan="4" >
				<input type="hidden" name="social_goods_group_name_tmp" class="social_goods_group_name" value="<?php echo $TPL_VAR["goods"]["social_goods_group_data"]["name"]?>" >
				<input type="hidden" name="social_goods_group" id="social_goods_group" value="<?php echo $TPL_VAR["goods"]["social_goods_group_data"]["group_seq"]?>">
				<input type="text" name="social_goods_group_name"  class="social_goods_group_name" value="<?php echo $TPL_VAR["goods"]["social_goods_group_data"]["name"]?>"> <span class="btn small"><button type="button" id="coupon_group_search" >찾기</button></span>
				<span class="desc">판매자(본사 또는 입점사)가 티켓 상품을 그룹화하여 편리하게 관리할 수 있게 합니다. 그룹은 판매자별로 생성되어 관리됩니다.</span>
			</td>
		</tr>
		<tr>
			<th class="its-th-align center" rowspan="2">티켓번호</td>
			<td class="its-td"  colspan="4" >
				결제 완료 시 → 구매자에게 → 구매 상품 수량을 기준으로 → 티켓번호가 자동 발송됨
				<div class="pdt5">
					<span class="desc">상품 등록 후 내부 시스템 ↔ 외부 제휴사 시스템 선택을 변경 불가하며  상품 복사 시에는 내부 시스템이 기본 선택됩니다.</span>
				</div>
			</td>
		</tr>
		<tr>
			<td class="its-td"  colspan="4" >
				<table  id="social_number_tbl">
					<colgroup>
						<col width="400" />
						<col width="300" />
						<col width="350" />
					</colgroup>
					<tr>
						<td>							
								<label><input type="radio" name="coupon_serial_type" value="a" <?php if($TPL_VAR["goods"]["coupon_serial_type"]!='n'){?>checked<?php }elseif($TPL_VAR["goods"]["goods_seq"]){?> disabled<?php }?> /> 내부 시스템에서 자동 생성되는 16자리 티켓번호 사용</label>							
						</td>
						<td>
							<div>
								<label><input type="radio" name="coupon_serial_type" value="n" <?php if($TPL_VAR["goods"]["coupon_serial_type"]=='n'){?>checked<?php }elseif($TPL_VAR["goods"]["goods_seq"]){?> disabled<?php }?> /> 외부 제휴사 시스템에서 생성된 티켓번호 사용</label>
								<input type="hidden" name="coupon_serial_upload" value="<?php echo $TPL_VAR["goods"]["coupon_serial_str"]?>" />
							</div>
						</td>
						<td><span class="btn small"><button type="button" id="coupon_serial_upload"> 티켓번호 등록</button></span></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2">
							<div class="desc">단, 등록된 티켓번호 소진 시 자동으로 품절 처리 되며, 티켓번호가 부족할 때 계속해서 추가 등록 가능합니다.</div>							
							<div id="coupon_result" <?php if($TPL_VAR["goods"]["coupon_serial_tcnt"]> 0){?><?php }else{?>class="hide"<?php }?>>총 <span class="tcnt sum_number"><?php echo number_format($TPL_VAR["goods"]["coupon_serial_tcnt"])?></span>개 중 <span class="sum_number"><?php echo number_format($TPL_VAR["goods"]["coupon_serial_ecnt"])?></span>개가 발송됨</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<th class="its-th-align center">티켓의 값어치</td>
			<td class="its-td"  colspan="4" >
				<label><input type="radio" name="socialcp_input_type" id="socialcp_input_type_pass" value="pass" <?php if($TPL_VAR["goods"]["socialcp_input_type"]!='price'){?> checked="checked" <?php }?> /> 티켓 1장의 값어치는 횟수(이용권,관람권 등)입니다. </label>
				&nbsp;&nbsp;<label><input type="radio" name="socialcp_input_type" id="socialcp_input_type_price" value="price" <?php if($TPL_VAR["goods"]["socialcp_input_type"]=='price'){?> checked="checked" <?php }?>  /> 티켓 1장의 값어치는 금액입니다. </label>
				<div class="pdt5 desc">
					아래 판매 정보에서 티켓 1장의 값어치를 입력 해 주십시오. 구매자는 티켓 1장의 값어치가 남았을 경우 해당 티켓번호로 값어치만큼 사용 가능합니다.
				</div>
			</td>
		</tr>
		<tr>
			<th class="its-th-align center">티켓 유효기간<br/>(사용기간)</td>
			<td class="its-td"  colspan="4" >
				아래 판매 정보의 <a href="#04"><img src="/admin/skin/default/images/common/btn_option_must.gif" align="absmiddle" alt="[필수옵션설정]" /></a> 에서 [특수 정보] 기능으로 설정 해 주십시오.
				<span class="btn small orange"><button type="button"  id="btn_goods_special_list"> 안내) 특수 정보 활용</button></span>
				<div class="desc">
					<div class="red pdt5">					
						티켓의 필수옵션으로 정의된 유효기간(수동기간, 날짜)이 종료되었으면 → 자동으로 구매를 막습니다.
					</div>
					<div class="red pdt5">					
						티켓의 필수옵션으로 정의된 유효기간(수동기간, 날짜)이 모두 종료되었으면 → 자동으로 판매중지 상태가 됩니다.
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<th class="its-th-align center">티켓 사용지역</td>
			<td class="its-td" colspan="4" >
				아래 판매 정보의 <a href="#04"><img src="/admin/skin/default/images/common/btn_option_must.gif" align="absmiddle" alt="[필수옵션설정]" /></a> 에서 [특수 정보] 기능으로 설정 해 주십시오.
			</td>
		</tr>
		<tr>
			<th class="its-th-align center" rowspan="2" >유효기간 시작 전 <br/>취소(환불)</td>
			<td class="its-td" ><span class="red">전체</span> 값어치 모두 있고 </td>
			<td class="its-td" >
				<table cellspacing="10" cellpadding="10" >
					<tr>
						<td>
							<label><input type="radio" name="socialcp_cancel_type" id="socialcp_cancel_type_pay" value="pay" <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]=='pay'||!$TPL_VAR["goods"]["socialcp_cancel_type"]){?> checked="checked" <?php }?>  /> 결제확인 후 </label>
							<input type="text" name="socialcp_cancel_day[]"  id="socialcp_cancel_day_0"  size="3" value="<?php echo $TPL_VAR["goods"]["socialcp_cancel_day0"]?>" class="right line onlynumber_signed1" <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]!='pay'&&$TPL_VAR["goods"]["socialcp_cancel_type"]){?> disabled="disabled" <?php }?>/>일 이내에만 100% 취소(환불) 가능
						</td>
					</tr>
					<tr>
						<td>
							<label><input type="radio" name="socialcp_cancel_type" id="socialcp_cancel_type_option" value="option"  <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]=='option'){?> checked="checked" <?php }?>  /> 유효기간 </label> 시작 전에만 100% <label for="socialcp_cancel_type_option">취소(환불) 가능</label> </td>
					</tr>
					<tr>
						<td class="left">
							<table>
								<tr>
								<td class="left" style="padding-right:5px" ><label><input type="radio" name="socialcp_cancel_type" id="socialcp_cancel_type_dayoption" value="payoption" <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]=='payoption'){?> checked="checked" <?php }?> />
								</td>
								<td>
								<table class="info-table-style" >
								<colgroup>
									<col width="30%" />
									<col />
								</colgroup>
								<tbody>
									<tr>
										<td class="its-td-align left" style="padding:0 5px;">유효기간 시작일 기준</td>
										<td>
											<table class="" id="socialcpcancelViewTable" style="width:430px">
											<colgroup>
												<col width="25%" />
												<col />
												<col width="10%" />
											</colgroup>
											<tbody>
<?php if($TPL_VAR["socialcpcancels"]){?>
<?php if($TPL_socialcpcancels_1){$TPL_I1=-1;foreach($TPL_VAR["socialcpcancels"] as $TPL_V1){$TPL_I1++;?>
													<tr class="socialcpcancelViewTabletr" >
														<td class="its-td" >
													<input type="hidden" name="socialcp_cancel_seq[]" value="<?php echo $TPL_V1["seq"]?>" />
															<input type="text" name="socialcp_cancel_day[]" size="3" value="<?php echo $TPL_V1["socialcp_cancel_day"]?>" class="right line onlynumber_signed1"  <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]!='payoption'){?> disabled="disabled" <?php }?>    />일 이전
														</td>
														<td class="its-td">
															<input type="text" name="socialcp_cancel_percent[]"  size="3" class="right line onlynumber percent" value="<?php echo $TPL_V1["socialcp_cancel_percent"]?>"  <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]!='payoption'){?> disabled="disabled" <?php }?>  />% <span class="socialcp_cancel_percent_title <?php if($TPL_I1< 1){?>hide<?php }?>" ><span class="red">공제</span> 후</span> 취소(환불) 가능
														</td>
														<td class="its-td-align center">
<?php if($TPL_I1== 0){?>
																<span class="btn-plus"><button type="button" id="socialcpcancelAdd"></button></span>
<?php }else{?>
																<span class="btn-minus"><button type="button" class="socialcpcancelDel"></button></span>
<?php }?>
														</td>
													</tr>
<?php }}?>
<?php }else{?>
												<tr  class="socialcpcancelViewTabletr" >
													<td class="its-td">
														<input type="text" name="socialcp_cancel_day[]" size="3" value="" class="right line onlynumber_signed1"  disabled="disabled" />일 전까지
													</td>
													<td class="its-td">
														<input type="text" name="socialcp_cancel_percent[]"  size="3" class="right line onlynumber percent" value="100"  disabled="disabled"  />% <span class="socialcp_cancel_percent_title hide" ><span class="red">공제</span> 후</span> 취소(환불) 가능
													</td>
													<td class="its-td-align center"><span class="btn-plus"><button type="button" id="socialcpcancelAdd"></button></span></td>
												</tr>
<?php }?>
											</tbody>
											</table>
										</td>
									</tr>
									<tr>
										<td class="its-td left" colspan="2">
											<div class="socialcpcancelViewdiv">
											<label><input type="checkbox"name="socialcp_cancel_payoption" id="socialcp_cancel_payoption" value="1"    <?php if($TPL_VAR["goods"]["socialcp_cancel_payoption"]=='1'){?> checked="checked" <?php }?>   <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]!='payoption'){?> disabled="disabled" <?php }?> /> 유효기간 시작일부터 ~ 종료일까지 </label>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="socialcp_cancel_payoption_percent"  size="3" class="right line onlynumber percent" value="<?php echo $TPL_VAR["goods"]["socialcp_cancel_payoption_percent"]?>"  <?php if($TPL_VAR["goods"]["socialcp_cancel_payoption"]!='1'){?> disabled="disabled" <?php }?>  />% 취소(환불) 가능
											</div>
										</td>
									</tr>
								</tbody>
								</table>
								<div class="pdt5"> <span class="btn small orange"><button type="button"  id="btn_ticket_goods_refund_helper">설정 예시</button></span></div>
								</td>
							</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td class="its-td" >
				자동 <span class="icon-order-step-75">배송완료</span>
				<div class="desc pdt5">
				<span class="red" >
				유효기간 시작 전<br/>
				전체미사용→반품/환불→가치종료</span>
				</div>
				<div class="pdt5">
				<span class="btn small orange"><button type="button"  id="btn_socialcp_cancel_card">안내) 카드결제 자동취소</button></span>
				</div>
			</td>
			<td class="its-td" > 적립(환불금액만큼 제외)</td>
		</tr>
		<tr>
			<td class="its-td" ><span class="blue">잔여</span> 값어치 <span class="green">남아</span> 있고 </td>
			<td class="its-td" >
				<label><input type="radio" name="socialcp_cancel_use_refund" class="socialcp_cancel_use_refund" value="0"  <?php if($TPL_VAR["goods"]["socialcp_cancel_use_refund"]!='1'){?> checked="checked" <?php }?> /> ↑상기 조건과 동일합니다. </label> <br/>
				<label><input type="radio" name="socialcp_cancel_use_refund" class="socialcp_cancel_use_refund" value="1"  <?php if($TPL_VAR["goods"]["socialcp_cancel_use_refund"]=='1'){?> checked="checked" <?php }?> /> 부분 사용한 티켓은 취소(환불) 불가 </label>
			</td>
			<td class="its-td" >
				<span class="gray">(배송완료 상태)</span>
				<div class="desc pdt5">
				<span class="red" >유효기간 시작 전<br/>
				부분미사용→반품/환불→가치종료</span>
				</div>
			</td>
			<td class="its-td" > 적립(환불금액만큼 제외)</td>
		</tr>
		<tr>
			<th class="its-th-align center" rowspan="2" >유효기간 종료 후<br/>미사용 티켓환불</td>
			<td class="its-td" ><span class="red">전체</span> 값어치 모두 있고 </td>
			<td class="its-td" rowspan="2" >
				<label><input type="radio" name="socialcp_use_return" class="socialcp_use_return" value="1"  <?php if($TPL_VAR["goods"]["socialcp_use_return"]=='1'){?> checked="checked" <?php }?> /> 미사용티켓환불대상 </label>
				<div>
				&nbsp;&nbsp;&nbsp; 미사용 티켓은 유효기간 종료 후
				<input type="text" name="socialcp_use_emoney_day" id="socialcp_use_emoney_day" size="3" value="<?php echo $TPL_VAR["goods"]["socialcp_use_emoney_day"]?>" class="socialcp_use_returnlay right line onlynumber_signed1"  <?php if($TPL_VAR["goods"]["socialcp_use_return"]!='1'){?> disabled="disabled" <?php }?> />일 이내  구매금액의
				<input type="text" name="socialcp_use_emoney_percent" id="socialcp_use_emoney_percent"  size="3" class="socialcp_use_returnlay right line onlynumber percent" value="<?php echo $TPL_VAR["goods"]["socialcp_use_emoney_percent"]?>"  <?php if($TPL_VAR["goods"]["socialcp_use_return"]!='1'){?> disabled="disabled" <?php }?> />% 취소(환불) 가능
				</div>
				<label><input type="radio" name="socialcp_use_return" class="socialcp_use_return" value="0" <?php if(!$TPL_VAR["goods"]["socialcp_use_return"]||$TPL_VAR["goods"]["socialcp_use_return"]!='1'){?> checked="checked" <?php }?> /> 미사용티켓환불대상아님</label>
			</td>
			<td class="its-td" >
				자동 <span class="icon-order-step-75">배송완료</span>
				<div class="desc pdt5">
				<span class="red" >
				유효기간 종료 후<br/>
				전체미사용→반품/환불→가치종료</span>
				</div>
			</td>
			<td class="its-td" > 적립(환불금액만큼 제외)</td>
		</tr>
		<tr>
			<td class="its-td" ><span class="blue">잔여</span> 값어치 <span class="green">남아</span> 있고 </td>
			<td class="its-td" >				
				<span class="gray">(배송완료 상태)</span>
				<div class="desc pdt5">
				<span class="red" >유효기간 종료 후<br/>
				부분미사용→반품/환불→가치종료</span>
				</div>
			</td>
			<td class="its-td" > 적립(환불금액만큼 제외)</td>
		</tr>
	</tbody>
</table>
<div class="desc pd5">
	<span class="red">주의사항 : 해당 티켓의 유효기간은 필수옵션(여러 개 사용)으로 유효기간(또는 날짜, 수동기간, 자동기간)을 생성해야만 합니다. 그렇지 않을 경우 유효기간을 알 수 없어 해당 티켓의 취소/환불이 되지 않습니다.</span>
</div>