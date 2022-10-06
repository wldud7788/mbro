<?php /* Template_ 2.2.6 2022/05/11 10:48:16 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_social_for_regist.html 000014068 */ 
$TPL_socialcpcancels_1=empty($TPL_VAR["socialcpcancels"])||!is_array($TPL_VAR["socialcpcancels"])?0:count($TPL_VAR["socialcpcancels"]);?>
<script>
	$(function(){
		changeFileStyle();
	});
	function upload_coupon_serial(){
		if	(!$("input#coupon_serial_file").val()){
			openDialogAlert('업로드할 파일이 없습니다.', 400, 150);
			return false;
		}
		$("form#coupon_serial_upload_form").submit();
	}
</script>
<!-- 티켓 정보 -->
<a name="04" alt="티켓 정보"></a>
<div class="bx-lay" data-bxcode="social_info">
	<div class="bx-title">
		<span class="item-title">티켓 정보</span>
		<span class='right'></span>
	</div>
	<div class="cont">
		<input type="hidden" name="goods_kind" id="goods_kind" value="coupon" />
		<table class="table_basic thl">
		<tbody>
			<tr>
				<th class="left" >티켓 상품 그룹</th>
				<td colspan="3" >
					<input type="hidden" name="social_goods_group_name_tmp" class="social_goods_group_name" value="<?php echo $TPL_VAR["goods"]["social_goods_group_data"]["name"]?>" >
					<input type="hidden" name="social_goods_group" id="social_goods_group" value="<?php echo $TPL_VAR["goods"]["social_goods_group_data"]["group_seq"]?>">
					<input type="text" name="social_goods_group_name"  class="social_goods_group_name" size="20" value="<?php echo $TPL_VAR["goods"]["social_goods_group_data"]["name"]?>"> 
					<button type="button" id="coupon_group_search" class="resp_btn v2">찾기</button>
				</td>
			</tr>
			<tr>
				<th class="left">티켓 번호</th>
				<td colspan="3" >
					<div class="resp_radio">
						<label><input type="radio" name="coupon_serial_type" value="a" <?php if($TPL_VAR["goods"]["coupon_serial_type"]!='n'){?>checked<?php }elseif($TPL_VAR["goods"]["goods_seq"]){?> disabled<?php }?> /> 자동 생성 (16자리)</label>
						<label class="ml20"><input type="radio" name="coupon_serial_type" value="n" <?php if($TPL_VAR["goods"]["coupon_serial_type"]=='n'){?>checked<?php }elseif($TPL_VAR["goods"]["goods_seq"]){?> disabled<?php }?> /> 수동 등록</label>
						<input type="hidden" name="coupon_serial_upload" value="<?php echo $TPL_VAR["goods"]["coupon_serial_str"]?>" />
					</div>
				</td>
			</tr>
			<tr class="excelupload hide">
				<th class="left">엑셀 업로드</th>
				<td colspan="3" >
					<button type="button" class="resp_btn v2" id="coupon_serial_upload"> 티켓번호 등록</button>

					<ul class="bullet_hyphen resp_message">
						<li>등록된 티켓 번호 소진 시 자동 품절 처리 됩니다. 소진 후 티켓 번호는  추가 등록이 가능합니다.</li>
					</ul>
				</td>
			</tr> 
			<tr  id="coupon_result" class="<?php if($TPL_VAR["goods"]["coupon_serial_tcnt"]> 0){?><?php }else{?>hide<?php }?> ">
				<th class="left">티켓 번호 수량</th>
				<td ><span class="tcnt sum_number"><?php echo number_format($TPL_VAR["goods"]["coupon_serial_tcnt"])?></span></td>
				<th class="left">티켓 발송 수량</th>
				<td ><span class="sum_number"><?php echo number_format($TPL_VAR["goods"]["coupon_serial_ecnt"])?></span></td>
			</tr> 
			<tr>
				<th class="left">티켓 사용 기준</th>
				<td colspan="3" >
					<div class="resp_radio">
						<label><input type="radio" name="socialcp_input_type" id="socialcp_input_type_pass" value="pass" <?php if($TPL_VAR["goods"]["socialcp_input_type"]!='price'){?> checked="checked" <?php }?> /> 횟수</label>
						<label class="ml20"><input type="radio" name="socialcp_input_type" id="socialcp_input_type_price" value="price" <?php if($TPL_VAR["goods"]["socialcp_input_type"]=='price'){?> checked="checked" <?php }?>  /> 금액</label>
					</div>
				</td>
			</tr>
			<tr>
				<th class="left">장소 표기
					<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/goods', '#regist_tiket_place_view', 'sizeS')"></span>
				</th>
				<td colspan="3" >
					<div class="resp_checkbox">
						<label><input type="checkbox" name="pc_mapView" class="mapView" value="Y" disabled="disable" <?php if($TPL_VAR["goods"]["pc_mapview"]=='Y'){?>checked<?php }?> /> <?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>PC - <?php }?>지역 정보 지도로 표기</label>
<?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>
						<label><input type="checkbox" name="m_mapView" class="mapView" value="Y" disabled="disable" <?php if($TPL_VAR["goods"]["m_mapview"]=='Y'){?>checked<?php }?> /> 모바일 - 지역 정보 지도로 표기</label>
<?php }?>
					</div>
				</td>
			</tr>
		</table>
		<ul class="bullet_hyphen resp_message mt10">
			<li>티켓의 유효기간은 필수 옵션에서 날짜/자동기간/수동기간 으로 설정해주세요. <a href="https://www.firstmall.kr/customer/faq/1304" target="_blank"><span class="underline blue">자세히 보기&gt;</span></a></li>
			<li>티켓의 지역은 필수 옵션에서 지역으로 설정해주세요. 지역 설정 시 티켓 정보와 함께 지도가 제공됩니다.</li>
			<li>티켓 발송 안내 <span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/goods', '#regist_tiket_send_guide', 'sizeS')"></span></li>
		</ul>
	</div>
</div>

<!-- 환불정보 -->
<a name="05" alt="환불 정보"></a>
<div class="bx-lay" data-bxcode="social_refund">
	<div class="bx-title">
		<span class="item-title">환불 정보</span>
		<span class='right'></span>
	</div>
	<div class="cont">
		<div style="margin-top:-15px;">
			<span class="item-sub-title">유효 기간 이전</span>
			<table class="table_basic thl">
			<tbody>
				<tr>
					<th class="left">미사용</th>
					<td>
						<div class="resp_radio wp95">
							<label><input type="radio" name="socialcp_cancel_type" id="socialcp_cancel_type_pay" value="pay" <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]=='pay'||!$TPL_VAR["goods"]["socialcp_cancel_type"]){?> checked="checked" <?php }?>  /> 기간 내 환불 </label>
							<label><input type="radio" name="socialcp_cancel_type" id="socialcp_cancel_type_option" value="option"  <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]=='option'){?> checked="checked" <?php }?>  /> 전액 환불</label>
							<label><input type="radio" name="socialcp_cancel_type" id="socialcp_cancel_type_dayoption" value="payoption" <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]=='payoption'){?> checked="checked" <?php }?> />조건부 환불</label>
						</div>

						<div class="socialcp_cancel_type_pay wp50 <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]=='payoption'||$TPL_VAR["goods"]["socialcp_cancel_type"]=='option'){?> hide <?php }?>">
							<table class="table_basic thl v7" >
								<colgroup>
									<col width="30%" />
									<col />
								</colgroup>
								<tbody>
									<tr>
										<th class="left">기간 설정 <span class="required_chk"></span></th>
										<td>
											결제 확인 후 <input type="text" name="socialcp_cancel_day[]"  id="socialcp_cancel_day_0"  size="3" value="<?php echo $TPL_VAR["goods"]["socialcp_cancel_day0"]?>" class="right onlynumber_signed1" <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]!='pay'&&$TPL_VAR["goods"]["socialcp_cancel_type"]){?> disabled="disabled" <?php }?>/>일 이내
										</td>
									</tr>
								</tbody>
							</table>
							
							<ul class='bullet_hyphen resp_message'>
								<li>유효기간 이전 티켓 환불 설명 예시
									<a href="https://www.firstmall.kr/customer/faq/1519" target="_blank"><span class="blue underline">자세히 보기 &gt;</span></a>
								</li>
							</ul>
						</div>

						<div class="socialcp_cancel_type_dayoption wp50 mt5 <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]!='payoption'){?> hide <?php }?>">
							<table class="table_basic v7" id="socialcpcancelViewTable">
							<colgroup>
								<col width="10%" />
								<col width="40%" />
								<col />
							</colgroup>
							<thead>
							<tr>
								<th><button type="button" class="btn_plus" id="socialcpcancelAdd"></button></th>
								<th>기간 <span class="required_chk"></span></th>
								<th>환불 가능 <span class="required_chk"></span></th>
							</tr>
							</thead>
							<tbody>
<?php if($TPL_VAR["socialcpcancels"]){?>
<?php if($TPL_socialcpcancels_1){$TPL_I1=-1;foreach($TPL_VAR["socialcpcancels"] as $TPL_V1){$TPL_I1++;?>
								<tr class="socialcpcancelViewTabletr" >
									<td class="center">
<?php if($TPL_I1> 0){?>
											<button type="button" class="socialcpcancelDel btn_minus"></button>
<?php }?>
									</td>
									<td>
										<input type="hidden" name="socialcp_cancel_seq[]" value="<?php echo $TPL_V1["seq"]?>" />
										<input type="text" name="socialcp_cancel_day[]" size="4" maxlength="4" value="<?php echo $TPL_V1["socialcp_cancel_day"]?>" class="right onlynumber_signed1"  <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]!='payoption'){?> disabled="disabled" <?php }?>    />일 이전
									</td>
									<td>
										<input type="text" name="socialcp_cancel_percent[]"  size="4" maxlength="3" class="right onlynumber percent" value="<?php echo $TPL_V1["socialcp_cancel_percent"]?>"  <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]!='payoption'){?> disabled="disabled" <?php }?>  />% <span class="socialcp_cancel_percent_title <?php if($TPL_I1< 1){?>hide<?php }?>" ><span class="red">공제 후</span></span> 환불 가능
									</td>
								</tr>
<?php }}?>
<?php }else{?>
							<tr  class="socialcpcancelViewTabletr" >
								<td class="center"></td>
								<td>
									<input type="text" name="socialcp_cancel_day[]" size="4" maxlength="4" value="" class="right onlynumber_signed1"  disabled="disabled" />일 전까지
								</td>
								<td>
									<input type="text" name="socialcp_cancel_percent[]"  size="4" maxlength="3" class="right onlynumber percent" value="100"  disabled="disabled"  />% <span class="socialcp_cancel_percent_title hide" ><span class="red">공제 후</span></span> 환불 가능
								</td>
							</tr>
<?php }?>
							</tbody>
							</table>
							<div class="mt5 resp_checkbox socialcpcancelViewdiv">
								<label><input type="checkbox"name="socialcp_cancel_payoption" id="socialcp_cancel_payoption" value="1" <?php if($TPL_VAR["goods"]["socialcp_cancel_payoption"]=='1'){?> checked="checked" <?php }?>   <?php if($TPL_VAR["goods"]["socialcp_cancel_type"]!='payoption'){?> disabled="disabled" <?php }?> /> 유효기간 시작일부터 ~ 종료일까지 </label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="socialcp_cancel_payoption_percent"  size="3" class="right onlynumber percent" value="<?php echo $TPL_VAR["goods"]["socialcp_cancel_payoption_percent"]?>"  <?php if($TPL_VAR["goods"]["socialcp_cancel_payoption"]!='1'){?> disabled="disabled" <?php }?>  />% 환불 가능
							</div>
						</div>

					</td>
				</tr>
				<tr>
					<th class="left">부분 사용</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="socialcp_cancel_use_refund" class="socialcp_cancel_use_refund" value="0"  <?php if($TPL_VAR["goods"]["socialcp_cancel_use_refund"]!='1'){?> checked="checked" <?php }?> /> 미사용 환불 정책 동일</label>
							<label><input type="radio" name="socialcp_cancel_use_refund" class="socialcp_cancel_use_refund" value="1"  <?php if($TPL_VAR["goods"]["socialcp_cancel_use_refund"]=='1'){?> checked="checked" <?php }?> /> 부분 사용 티켓 환불 불가</label>
						</div>
					</td>
				</tr>
			</tbody>
			</table>
		</div>

		<div class="mt10">
			<span class="item-sub-title">유효 기간 이후</span>
			<table class="table_basic thl">
			<tbody>
				<tr>
					<th class="left">미사용</th>
					<td rowspan="2" style="height:80px;" valign="top">
						<div class="resp_radio">
							<label><input type="radio" name="socialcp_use_return" value="1"  <?php if($TPL_VAR["goods"]["socialcp_use_return"]=='1'){?> checked="checked" <?php }?> /> 조건에 따라 환불 </label>
							<label><input type="radio" name="socialcp_use_return" value="0" <?php if(!$TPL_VAR["goods"]["socialcp_use_return"]||$TPL_VAR["goods"]["socialcp_use_return"]!='1'){?> checked="checked" <?php }?> /> 환불 불가</label>
						</div>
						<div class="wx800 socialcp_use_return mt5">
						<table class="table_basic v7">
							<colgroup>
								<col width="15%" />
								<col width="35%" />
								<col width="15%" />
								<col width="35%" />
							</colgroup>
							<tbody>
								<tr>
									<th class="left">기간 설정 <span class="<?php if($TPL_VAR["goods"]["socialcp_use_return"]=='1'){?>required_chk<?php }?> "></span></th>
									<td>
										유효 기간 종료 후 <input type="text" name="socialcp_use_emoney_day" id="socialcp_use_emoney_day" size="4" maxlength="4" value="<?php echo $TPL_VAR["goods"]["socialcp_use_emoney_day"]?>" class="socialcp_use_returnlay right onlynumber_signed1"  <?php if($TPL_VAR["goods"]["socialcp_use_return"]!='1'){?> disabled="disabled" <?php }?> />일 이내
									</td>
									<th class="left">환불 금액 <span class="<?php if($TPL_VAR["goods"]["socialcp_use_return"]=='1'){?>required_chk<?php }?>"></span></th>
									<td>
										<input type="text" name="socialcp_use_emoney_percent" id="socialcp_use_emoney_percent"  size="4" maxlength="3" class="socialcp_use_returnlay right onlynumber percent" value="<?php echo $TPL_VAR["goods"]["socialcp_use_emoney_percent"]?>"  <?php if($TPL_VAR["goods"]["socialcp_use_return"]!='1'){?> disabled="disabled" <?php }?> />% 취소(환불) 가능
									</td>
								</tr>
							</tbody>
						</table>
						</div>
					</td>
				</tr>
				<tr>
					<th class="left">부분 사용</th>
				</tr>
			</tbody>
			</table>
		</div>
	</div>
</div>