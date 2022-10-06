<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/mypage/order_return.html 000024551 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_reasonLoop_1=empty($TPL_VAR["reasonLoop"])||!is_array($TPL_VAR["reasonLoop"])?0:count($TPL_VAR["reasonLoop"]);
$TPL_reasons_1=empty($TPL_VAR["reasons"])||!is_array($TPL_VAR["reasons"])?0:count($TPL_VAR["reasons"]);
$TPL_bankReturn_1=empty($TPL_VAR["bankReturn"])||!is_array($TPL_VAR["bankReturn"])?0:count($TPL_VAR["bankReturn"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 교환/반품 신청 @@
- 파일위치 : [스킨폴더]/mypage/order_return.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript">
	var gl_orders_payment	= '<?php echo $TPL_VAR["orders"]["payment"]?>';
	var gl_items_tot_ea		= '<?php echo $TPL_VAR["items_tot"]["ea"]?>';
</script>
<script type="text/javascript" src="/app/javascript/js/skin-mypageReturn-responsive.js"></script>

<div class="subpage_wrap" data-ezmark="undo">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)">MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><?php if($TPL_VAR["mode"]=='exchange'){?><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL215cGFnZS9vcmRlcl9yZXR1cm4uaHRtbA==" >교환</span><?php }else{?><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL215cGFnZS9vcmRlcl9yZXR1cm4uaHRtbA==" >반품</span><?php }?> <span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL215cGFnZS9vcmRlcl9yZXR1cm4uaHRtbA==" >신청</span></h2>
		</div>
		
		<div id="order_return_container">
		<form name="refundForm" method="post" action="../mypage_process/order_return" target="actionFrame">
			<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["orders"]["order_seq"]?>" />
			<input type="hidden" name="use_layout" value="<?php echo $_GET["use_layout"]?>" />
<?php if($TPL_VAR["mode"]=='exchange'){?>
			<input type="hidden" name="mode" value="<?php echo $TPL_VAR["mode"]?>" />
<?php }?>

			<ul class="myorder_sort Pb5">
				<li class="list1">
					<span class="th">주문번호 :</span>
					<span class="td"><strong class="common_count v2"><?php echo $TPL_VAR["orders"]["order_seq"]?></strong></span>
				</li>
			</ul>
			<p class="desc">
<?php if($TPL_VAR["mode"]=='exchange'){?>교환<?php }else{?>반품<?php }?>할 상품을 먼저 선택하고 수량을 입력하세요.<br />
<?php if($TPL_VAR["mode"]=='exchange'){?>
<?php if($TPL_VAR["gift_cnt"]> 0){?><span class="pointcolor3">사은품 지급 대상 상품 반품 시 사은품도 함께 반품해 주십시오.</span><?php }?>
<?php }?>
			</p>

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<div class="shipping_group">
				<div class="Pt20 Pb8 Bo"><label><input type="radio" name="chk_shipping_seq" value="<?php echo $TPL_V1["shipping_provider"]["provider_seq"]?>" tot_rt_ea="<?php echo $TPL_V1["tot_rt_ea"]?>" return_zipcode="<?php echo $TPL_V1["return_zipcode"]?>" return_address="<?php echo $TPL_V1["return_address"]?>" /> <?php echo $TPL_V1["shipping_provider"]["provider_name"]?></label></div>
				<input type="hidden" name="chk_shipping_group_address[]" value=": (반송주소) <?php echo $TPL_V1["shipping_provider"]["deli_zipcode"]?> <?php echo htmlspecialchars($TPL_V1["shipping_provider"]["deli_address1"])?> <?php echo htmlspecialchars($TPL_V1["shipping_provider"]["deli_address2"])?>" />
				<div class="res_table">
					<ul class="thead">
						<li style="width:60px;"><span class="chk_all dib_und">전체선택</span></li>
						<li>주문상품</li>
						<li style="width:80px;">주문수량</li>
						<li style="width:80px;">가능수량</li>
						<li style="width:80px;">신청수량</li>
						<li style="width:80px;">상태</li>
					</ul>
<?php if(is_array($TPL_R2=$TPL_V1["export_item"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_V2["rt_ea"]&&$TPL_V2["goods_type"]!='gift'){?>
						<ul class="tbody <?php if($TPL_V2["opt_type"]!='opt'){?>suboptions<?php }?>">
<?php }else{?>
						<ul class="tbody <?php if($TPL_V2["opt_type"]!='opt'){?>suboptions<?php }?>" disabledScript=1>
<?php }?>
							<li>
<?php if($TPL_V2["cancel_type"]=='1'){?>
									<label><input type="checkbox" name="chk_seq[]"  readonly="readonly" disabled="disabled"  cancel_type="<?php echo $TPL_V2["cancel_type"]?>" /></label>
<?php }else{?>
									<label><input type="checkbox" name="chk_seq[]" value="1"  cancel_type="<?php echo $TPL_V2["cancel_type"]?>" /></label>
<?php }?>
								<input type="hidden" name="chk_item_seq[]" value="<?php echo $TPL_V2["item_seq"]?>" item_option_seq="<?php echo $TPL_V2["item_option_seq"]?>" export_code="<?php echo $TPL_V2["export_code"]?>" />
								<input type="hidden" name="chk_option_seq[]" value="<?php echo $TPL_V2["item_option_seq"]?>" />
								<input type="hidden" name="chk_suboption_seq[]" value="<?php if($TPL_V2["opt_type"]=='sub'){?><?php echo $TPL_V2["option_seq"]?><?php }else{?><?php }?>" />
								<input type="hidden" name="chk_export_code[]" value="<?php echo $TPL_V2["export_code"]?>" />
								<input type="hidden" name="chk_individual_return[]" value="<?php echo $TPL_V2["individual_return"]?>" />
<?php if($TPL_I2== 0){?>
								<input type="hidden" name="pay_shiping_cost[]" shipping_seq="<?php echo $TPL_V2["shipping_seq"]?>" value="<?php if($TPL_VAR["mode"]=='exchange'){?><?php echo $TPL_V2["swap_shiping_cost"]?><?php }elseif($TPL_V2["shiping_free_yn"]=='Y'){?><?php echo $TPL_V2["swap_refund_shiping_cost"]?><?php }else{?><?php echo $TPL_V2["refund_shiping_cost"]?><?php }?>" />
<?php }?>
							</li>
							<li class="subject">
<?php if($TPL_V2["opt_type"]=='opt'){?>
								<ul class="board_goods_list">
									<li class="pic">
										<img src="<?php echo $TPL_V2["image"]?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl/images/common/noimage_list.gif'" alt="<?php echo $TPL_V2["goods_name"]?>" /></span>
									</li>
									<li class="info">
										<div class="title">
<?php if($TPL_V2["goods_type"]=='gift'||$TPL_V2["cancel_type"]=='1'){?>
											<div class="Pb5">
<?php if($TPL_V2["goods_type"]=='gift'){?><span class="pointcolor2">[사은품]</span><?php }?>
<?php if($TPL_V2["cancel_type"]=='1'&&$TPL_V2["opt_type"]=='opt'){?><span class="pointcolor2">[청약철회불가]</span><?php }?>
											</div>
<?php }?>
<?php if($TPL_V2["opt_type"]=='opt'){?>
											<?php echo $TPL_V2["goods_name"]?>

<?php }?>
<?php if($TPL_V2["goods_kind"]=='coupon'&&$TPL_VAR["mode"]!='exchange'){?>
<?php if($TPL_V2["coupon_serial"]){?>
												<div class="Pt5 pointcolor">티켓번호: <?php echo $TPL_V2["coupon_serial"]?></div>
<?php }?>
<?php if($TPL_V2["social_start_date"]&&$TPL_V2["social_end_date"]){?>
												<div class="Fs13 No desc">(유효기간:<?php echo $TPL_V2["social_start_date"]?>~<?php echo $TPL_V2["social_end_date"]?>)</div>
<?php }?>
<?php }?>
										</div>
<?php if($TPL_V2["option1"]||$TPL_V2["option2"]||$TPL_V2["option3"]||$TPL_V2["option4"]||$TPL_V2["option5"]){?>
										<div class="cont3">
<?php if($TPL_V2["option1"]){?><span class="res_option_inline"><?php if($TPL_V2["title1"]){?><span class="xtle"><?php echo $TPL_V2["title1"]?></span><?php }?><?php echo $TPL_V2["option1"]?></span><?php }?>
<?php if($TPL_V2["option2"]){?><span class="res_option_inline"><?php if($TPL_V2["title2"]){?><span class="xtle"><?php echo $TPL_V2["title2"]?></span><?php }?><?php echo $TPL_V2["option2"]?></span><?php }?>
<?php if($TPL_V2["option3"]){?><span class="res_option_inline"><?php if($TPL_V2["title3"]){?><span class="xtle"><?php echo $TPL_V2["title3"]?></span><?php }?><?php echo $TPL_V2["option3"]?></span><?php }?>
<?php if($TPL_V2["option4"]){?><span class="res_option_inline"><?php if($TPL_V2["title4"]){?><span class="xtle"><?php echo $TPL_V2["title4"]?></span><?php }?><?php echo $TPL_V2["option4"]?></span><?php }?>
<?php if($TPL_V2["option5"]){?><span class="res_option_inline"><?php if($TPL_V2["title5"]){?><span class="xtle"><?php echo $TPL_V2["title5"]?></span><?php }?><?php echo $TPL_V2["option5"]?></span><?php }?>
										</div>
<?php }?>

<?php if($TPL_V2["inputs"]){?>
										<div class="cont3">
<?php if(is_array($TPL_R3=$TPL_V2["inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["value"]){?>
											<span class="res_option_inline">
<?php if($TPL_V3["title"]){?><span class="xtle v2"><?php echo $TPL_V3["title"]?></span><?php }?><?php if($TPL_V3["type"]=='file'){?><a href="../mypage_process/filedown?file=<?php echo $TPL_V3["value"]?>" target="actionFrame" class="gray_05" title="다운로드"><?php echo $TPL_V3["value"]?></a><?php }else{?><?php echo $TPL_V3["value"]?><?php }?>
											</span>
<?php }?>
<?php }}?>
										</div>
<?php }?>
									</li>
								</ul>
<?php }else{?>
								<div class="reply_ui">
<?php if($TPL_V2["title1"]){?><span class="xtle v3"><?php echo $TPL_V2["title1"]?></span><?php }?> <?php echo $TPL_V2["option1"]?>

								</div>
<?php }?>
							</li>
							<li><span class="mtitle">주문:</span> <?php echo number_format($TPL_V2["opt_ea"])?></li>
							<li><span class="mtitle">가능:</span> <?php echo number_format($TPL_V2["rt_ea"])?></li>
							<li>
								<span class="mtitle">신청:</span>
<?php if($TPL_V2["rt_ea"]> 0){?>
									<!-- 인풋 박스 처리 시 input다음에 select를 위치한다. -->
									<input type="number" name="input_chk_ea[]" class="only_number_for_chk_ea res_board_boxad" style="width:48px;" value="<?php echo $TPL_V2["rt_ea"]?>" min="1" max="<?php echo $TPL_V2["rt_ea"]?>" />
									<select name="chk_ea[]" style="display:none;">
										<option value="<?php echo $TPL_V2["rt_ea"]?>" selected><?php echo $TPL_V2["rt_ea"]?></option>
									</select>
<?php }else{?>
									-
									<select name="chk_ea[]" class="hide"><option></option></select>
<?php }?>
							</li>
							<li class="mo_end v2"><span class="reply_title gray_01"><?php echo $TPL_V2["mstep"]?></span></li>
						</ul>
<?php }}?>
				</div>
			</div>
<?php }}?>

			<h3 class="title_sub1">사유 선택</h3>
			<div class="reason_area">
				<select name="reason" class="M">
<?php if($TPL_VAR["reasonLoop"]){?>
<?php if($TPL_reasonLoop_1){foreach($TPL_VAR["reasonLoop"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["codecd"]?>"><?php echo $TPL_V1["reason"]?></option>
<?php }}?>
<?php }else{?>
<?php if($TPL_reasons_1){foreach($TPL_VAR["reasons"] as $TPL_V1){?>
<?php if($TPL_V1["codecd"]!='110'){?>
					<option value="<?php echo $TPL_V1["codecd"]?>"><?php echo $TPL_V1["value"]?></option>
<?php }?>
<?php }}?>
<?php }?>
				</select> &nbsp;
				<span class="reason_ship_duty_area pointcolor2"><?php if($TPL_VAR["mode"]=='exchange'){?>교환<?php }else{?>반품<?php }?>배송비 :
					<span class="reason_ship_duty reason_seller hide">판매자 부담</span>
					<span class="reason_ship_duty reason_buyer hide">구매자 부담</span>
				</span>
				<input type="hidden" name="reason_desc" value="">
			</div>

			<h3 class="title_sub1">상세 사유</h3>
			<textarea name="reason_detail" class="size1"></textarea>

			<h3 class="title_sub1">연락처</h3>
			<table class="table_row_a v2" width="100%" cellpadding="0" cellspacing="0">
				<colgroup><col class="size_b"><col></colgroup>
				<tbody>
					<tr>
						<th><p>구매자</p></th>
						<td><?php echo $TPL_VAR["orders"]["order_user_name"]?></td>
					</tr>
					<tr>
						<th><p>휴대폰 <b class="pointcolor">*</b></p></th>
						<td>
							<input type="tel" name="cellphone[]" class="size_phone" value="<?php echo $TPL_VAR["orders"]["order_cellphone"][ 0]?>" /> -
							<input type="tel" name="cellphone[]" class="size_phone" value="<?php echo $TPL_VAR["orders"]["order_cellphone"][ 1]?>" /> -
							<input type="tel" name="cellphone[]" class="size_phone" value="<?php echo $TPL_VAR["orders"]["order_cellphone"][ 2]?>" />
						</td>
					</tr>
					<tr>
						<th><p>연락처2</p></th>
						<td>
							<input type="tel" name="phone[]" class="size_phone" value="<?php echo $TPL_VAR["orders"]["order_phone"][ 0]?>" /> -
							<input type="tel" name="phone[]" class="size_phone" value="<?php echo $TPL_VAR["orders"]["order_phone"][ 1]?>" /> -
							<input type="tel" name="phone[]" class="size_phone" value="<?php echo $TPL_VAR["orders"]["order_phone"][ 2]?>" />
						</td>
					</tr>
				</tbody>
			</table>

			<h3 class="title_sub1">반품 방법</h3>
			<ul class="list_01 v2">
				<li>
					<label><input type="radio" name="return_method" value="user" checked="checked" /> <span class="return_method_text bold">직접 판매자에게 발송</span> <span class="Dib">( ↓ 아래의 주소로 발송)</span></label>
					<div class="return_shipping_group_address pointcolor2" style="padding:4px 0 0 0;"></div>
				</li>
				<li class="Pt10">
					<label><input type="radio" name="return_method" value="shop" /> <span class="return_method_text">지정 택배사에서 가져가 주세요.</span> <span class="Dib">( ↓ 아래의 주소로 발송)</span></label>
					<div class="return_custom_shipping_address" style="padding:4px 0 0 0; display:none;">
						<span id="returnPostNumberArea"><input type="text" name="return_recipient_new_zipcode" maxlength="7" readonly class="size_zip_all" value="<?php echo $TPL_VAR["orders"]["recipient_zipcode"]?>"></span>
						<span><button type="button" id="return_recipient_zipcode_button" class="btn_resp size_b color4" onclick="openDialogZipcode_resp('return_recipient_');">주소찾기</button></span>
						<input type="hidden" name="return_recipient_address_type" value="<?php echo $TPL_VAR["orders"]["recipient_address_type"]?>" />
						<input type="text" name="return_recipient_address" value="<?php echo $TPL_VAR["orders"]["recipient_address"]?>" class="size_address Mt5" readonly />
						<input type="text" name="return_recipient_address_street" value="<?php echo $TPL_VAR["orders"]["recipient_address_street"]?>" class="size_address Mt5 hide" readonly />
						<input type="text" name="return_recipient_address_detail" value="<?php echo $TPL_VAR["orders"]["recipient_address_detail"]?>" class="size_address Mt5" />
					</div>
				</li>
			</ul>

<?php if($TPL_VAR["mode"]!='exchange'&&$TPL_VAR["orders"]["show_refund_method"]=='Y'){?>
			<h3 class="title_sub1">환불 방법</h3>
			<div class="Pb8">
				<label><input type="radio" name="refund_method" value="bank" checked /> 통장 계좌 환불</label>
			</div>
			<div class="table_top_line1"></div>
			<table class="table_row_a v2 Thc" width="100%" cellpadding="0" cellspacing="0">
				<colgroup><col class="size_b"><col></colgroup>
				<tbody>
					<tr>
						<th><p>은행</p></th>
						<td>
							<select name="bank">
<?php if(is_array($TPL_R1=code_load('bankCode'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
								<option value='<?php echo $TPL_V1["codecd"]?>'><?php echo $TPL_V1["value"]?></option>
<?php }}?>
							</select>
						</td>
					</tr>
					<tr>
						<th><p>예금주</p></th>
						<td><input type="text" name="depositor" /></td>
					</tr>
					<tr>
						<th><p>계좌번호</p></th>
						<td>
							<input type="tel" name="account[]" style="width:70px;" class="onlynumber" />
							<input type="tel" name="account[]" style="width:70px;" class="onlynumber" />
							<input type="tel" name="account[]" style="width:70px;" class="onlynumber" />
						</td>
					</tr>
				</tbody>
			</table>
			<ul class="list_dot_01 Mt10 desc">
				<li>예치금는 유효기간 내 현금으로 출금  및 상품 구매 시 사용 가능 합니다. (유효 기간: 적립일 기준 5년)</li>
				<li>전자금융법에 의해 200만원 이상의 보유는 불가합니다.</li>
<?php if(in_array($TPL_VAR["orders"]["payment"],array("bank","virtual","escrow_virtual"))){?>
				<li>결제 수단이 무통장 또는 가상계좌인 경우 환불 계좌 정보는 필수 입력 사항입니다.</li>
				<li>관리자로부터 환불 금액을 입금 받을 계좌 정보를 입력해주세요.</li>
<?php }?>
			</ul>
<?php }?>

			<div class="shipping_refund_area hide">
				<h3 class="title_sub1">배송비 결제방법</h3>
				<div class="shipping_refund">
					<div>
						<select name="refund_ship_type" id="refund_ship_type" class="M" onchange="refund_ship_type_chg();">
							<option value=""><?php echo getAlert('mo149')?></option>
<?php if($TPL_VAR["mode"]!='exchange'){?>
							<option value="M"><?php echo getAlert('mo150')?></option>
<?php }?>
							<option value="A"><?php echo getAlert('mo151')?></option>
							<option value="D"><?php echo getAlert('mo152')?></option>
						</select> &nbsp;
						<span class="pointcolor2"><?php if($TPL_VAR["mode"]=='exchange'){?>교환<?php }else{?>반품<?php }?>배송비 : <span id="refund_ship_cost"><?php echo get_currency_price( 0, 2)?></span></span>
						<span class="refund_ship_minus hide">(<?php if($TPL_VAR["mode"]=='exchange'){?>교환<?php }else{?>반품<?php }?>배송비를 제외한 금액을 환불합니다.)</span>
					</div>
					<div class="refund_ship_account Pt8 hide">
						<table class="table_row_a v2 Thc" width="100%" cellpadding="0" cellspacing="0">
							<colgroup><col class="size_b"><col></colgroup>
							<tbody>
								<tr>
									<th><p>입금은행/<span class="Dib">입금계좌</span></p></th>
									<td>
										<select name="shipping_price_bank_account">
											<option value="">입금은행</option>
<?php if($TPL_bankReturn_1){foreach($TPL_VAR["bankReturn"] as $TPL_V1){?>
											<option value="<?php echo $TPL_V1["bank"]["value"]?> <?php echo $TPL_V1["accountReturn"]?> <?php echo $TPL_V1["bankUserReturn"]?>"><?php echo $TPL_V1["bank"]["value"]?> <?php echo $TPL_V1["accountReturn"]?> <?php echo $TPL_V1["bankUserReturn"]?></option>
<?php }}?>
										</select>
									</td>
								</tr>
								<tr>
									<th><p>입금자명</p></th>
									<td><input type="text" name="shipping_price_depositor" value="" title="" /></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="btn_area_c">
				<button type="button" name="submitButton" class="btn_resp size_c color2">신청하기</button>
				<a href="/mypage/order_catalog" class="btn_resp size_c">취소</a>
			</div>
		</form>
		</div>

		<ul class="resp_content1 Mt30">
			<li>
				<h3 class="title_sub2 Mt20"><b>※ 교환/반품으로 인한 배송비 발생 기준 안내</b></h3>
				<div class="contents">
					<ul class="list_01 v2">
						<li>
							<p class="Pb5"><strong class="pointcolor3">구매자 부담</strong> (반품 배송비 + 최초 배송비)</p>
							<table class="table_row_a v2" width="100%" cellpadding="0" cellspacing="0">
								<colgroup><col class="size_b"><col></colgroup>
								<tbody>
									<tr>
										<th><p>반품 <span class="Dib">→ 환불</span></p></th>
										<td>
											반품 시 배송비는 반품의 원인을 제공한 자가 부담합니다.<br />
											구매자의 변심으로 반품을 원할 경우에는 구매자가 배송비를 지불<br />
										</td>
									</tr>
									<tr>
										<th><p>반품 <span class="Dib">→ 교환</span></p></th>
										<td>
											상품 교환 시 배송비는 교환의 원인을 제공한 자가 부담합니다.<br />
											구매자의 변심으로 교환을 원할 경우에는 구매자가 배송비를 지불<br />
										</td>
									</tr>
								</tbody>
							</table>
						</li>
						<li class="Pt12">
							<p class="Pb5"><strong class="pointcolor2">판매자 부담</strong> (반품 배송비 + 최초 배송비)</p>
							<table class="table_row_a v2" width="100%" cellpadding="0" cellspacing="0">
								<colgroup><col class="size_b"><col></colgroup>
								<tbody>
									<tr>
										<th><p>반품 <span class="Dib">→ 환불</span></p></th>
										<td>
											반품 시 배송비는 반품의 원인을 제공한 자가 부담합니다.<br />
											상품 하자나 제품 불일치로 인한 반품의 경우에는 판매자가 배송비를 지불<br />
										</td>
									</tr>
									<tr>
										<th><p>반품 <span class="Dib">→ 교환</span></p></th>
										<td>
											상품 교환 시 배송비는 교환의 원인을 제공한 자가 부담합니다.<br />
											상품 하자나 제품 불일치로 인한 교환의 경우에는 판매자가 배송비를 지불<br />
										</td>
									</tr>
								</tbody>
							</table>
						</li>
					</ul>
<?php if($TPL_VAR["mode"]=='exchange'){?>
					<ul class="list_dot_01 Pt10 gray_06">
						<li>교환 / 반품 접수의 처리내용은 [ 마이페이지 &gt; 교환/반품 내역 ]에서 확인 하실 수 있습니다.</li>
					</ul>
<?php }?>
				</div>
			</li>
			<li style="width:44%;">
				<h3 class="title_sub2 gray_03 Mt20"><b>교환/반품 배송비</b></h3>
				<div class="contents">
					<h4 class="title_sub5">교환/반품 배송비 입금</h4>
					<p>반송 시 상품에 배송비를 동봉 하실 경우 발생할 수 있는 분실 사고 및 책임분쟁을 방지하고자 배송비 전용 계좌로 입금을 해주셔야 합니다.</p>
					<h4 class="title_sub5">교환/반품 배송비 내역 (5000원)</h4>
					<p>
						교환 : 반송 착불 배송비 2500 + 재발송 배송비 2500<br />
						반품 : 최초 발송 배송비 2500 + 반송 착불 배송비 2500<br />
						(최초 배송비를 결제 하신 경우도 해당 배송비는 상품 가격과 함께 환불 처리됩니다.)<br />
						도서지역 : 제주도를 포함한 도서지역은 왕복 4000원의 추가 배송비가 발생합니다.<br />
					</p>
				</div>
			</li>
		</ul>

		<ul class="resp_content1 Mt20">
			<li>
				<h3 class="title_sub2 Mt20"><b class="pointcolor2">교환/반품이 가능한 경우는?</b></h3>
				<div class="contents">
					<h4 class="title_sub5">단순변심</h4>
					<p>수령한 상품의 사이즈 변경 또는 디자인, 색상 등이 마음에 들지 않아, 수령 일 기준 7일 이내 교환/반품 접수 및 배송비 입금, 반송 처리하시는 경우</p>
					<h4 class="title_sub5">배송오류 및 불량</h4>
					<p>
						주문하신 상품과 다른 상품을 수령하셨거나, 제조상 명백한 불량의 상품을 수령하신 경우.<br />
						단, 불량 상품의 경우 세탁 및 수선과정 이후 발생 또는 발견하는 손상 및 불량은 확인이 불가하므로 해당하지 않습니다.
					</p>
				</div>
			</li>
			<li>
				<h3 class="title_sub2 Mt20"><b class="pointcolor3">교환/반품이 불가능한 경우는?</b></h3>
				<div class="contents">
					<h4 class="title_sub5">청약철회 기간 경과 또는 구매 확정</h4>
					<p>상품 수령 후 7일 이내 교환/반품 접수 및 배송비 입금, 반송 처리를 하지 않으신 경우 또는 구매 확정이 완료되어 포인트가 지급된 경우</p>
					<h4 class="title_sub5">상품 착용 또는 훼손</h4>
					<p>상품 착용의 흔적이 있거나, 라벨 및 텍 제거, 제품 박스 및 포장 제거 등으로 새 상품으로서의 가치가 감소한 경우</p>
					<h4 class="title_sub5">교환불가(반품가능)</h4>
					<p>구매하신 상품의 사이즈 또는 컬러, 동일가 상품 교환 이외에 교환을 원하시는 상품의 가격이 다른 경우 반품 후 재 주문을 해주셔야 합니다.</p>
				</div>
			</li>
		</ul>
	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>
<script type="text/javascript" src="/data/skin/responsive_sports_sporti_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->