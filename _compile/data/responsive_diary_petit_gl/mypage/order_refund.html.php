<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/order_refund.html 000014421 */ 
$TPL_items_1=empty($TPL_VAR["items"])||!is_array($TPL_VAR["items"])?0:count($TPL_VAR["items"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 결제취소 / 환불신청 @@
- 파일위치 : [스킨폴더]/mypage/order_refund.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript">
	var gl_orders_payment	= '<?php echo $TPL_VAR["orders"]["payment"]?>';
	var gl_orders_pg		= '<?php echo $TPL_VAR["orders"]["pg"]?>';
	var gl_order_total_ea	= '<?php echo $TPL_VAR["order_total_ea"]?>';
	var gl_pg_company		= '<?php echo $TPL_VAR["config_system"]["pgCompany"]?>';
</script>
<script type="text/javascript" src="/app/javascript/js/skin-mypageRefund-responsive.js"></script>

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
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfcmVmdW5kLmh0bWw=" >결제취소 / 환불신청</span></h2>
		</div>

		<ul class="myorder_sort Pb5">
			<li class="list1">
				<span class="th">주문번호 :</span>
				<span class="td"><strong class="common_count v2"><?php echo $TPL_VAR["orders"]["order_seq"]?></strong></span>
			</li>
		</ul>
		<p class="desc Pb10">취소할 상품을 먼저 선택하고 수량을 입력하세요.</p>

		<div id="order_refund_container">
		<form name="refundForm" method="post" action="../mypage_process/order_refund" target="actionFrame" onsubmit="return refundSubmit()">
			<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["orders"]["order_seq"]?>" />
			<input type="hidden" name="cancel_type" value="" />
			<input type="hidden" name="use_layout" value="<?php echo $_GET["use_layout"]?>" />
<?php if($TPL_VAR["config_system"]["pgCompany"]=='allat'&&$TPL_VAR["orders"]["payment"]=='card'){?>
			<input type='hidden' name='actionUrl'		value='../mypage_process/order_refund' />
			<input type='hidden' name='allat_shop_id'	value='<?php echo $TPL_VAR["pg"]["mallCode"]?>' />
			<input type='hidden' name='allat_order_no'	value='<?php echo $TPL_VAR["orders"]["order_seq"]?>' />
			<input type='hidden' name='allat_amt'		value='<?php echo $TPL_VAR["orders"]["settleprice"]?>' />
			<input type='hidden' name='allat_seq_no'	value='<?php echo $TPL_VAR["orders"]["pg_transaction_number"]?>' />
			<input type='hidden' name='allat_pay_type'	value='CARD' />
			<input type='hidden' name='allat_enc_data'	value='' />
			<input type='hidden' name='allat_opt_pin'	value='NOVIEW' />
			<input type='hidden' name='allat_opt_mod'	value='WEB' />
			<input type='hidden' name='allat_test_yn'	value='N' />
<?php }?>
<?php if($TPL_VAR["config_system"]["pgCompany"]=='kspay'){?>
			<input type=hidden name="storeid"		value="<?php echo $TPL_VAR["pg"]["mallId"]?>">
			<input type=hidden name="storepasswd"	value="<?php echo $TPL_VAR["pg"]["mallPass"]?>">
			<input type=hidden name="authty"		value="<?php echo $TPL_VAR["orders"]["kspay_authty"]?>">
			<input type=hidden name="trno" size=15 maxlength=12 value="<?php echo $TPL_VAR["orders"]["pg_transaction_number"]?>">
<?php }?>

			<div class="res_table">
				<ul class="thead">
					<li style="width:60px;"><span class="chk_all dib_und">전체선택</span></li>
					<li>주문상품</li>
					<li style="width:80px;">주문수량</li>
					<li style="width:80px;">가능수량</li>
					<li style="width:80px;">취소수량</li>
					<li style="width:80px;">상태</li>
				</ul>
<?php if($TPL_items_1){foreach($TPL_VAR["items"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["options"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["able_refund_ea"]&&$TPL_V1["goods_type"]!='gift'){?>
				<ul class="tbody">
<?php }else{?>
				<ul class="tbody" disabledScript=1>
<?php }?>
					<li>
<?php if($TPL_V1["cancel_type"]=='1'){?>
							<label><input type="checkbox" name="chk_seq[]" readonly="readonly" disabled="disabled" cancel_type="<?php echo $TPL_V1["cancel_type"]?>" /></label>
<?php }else{?>
							<label><input type="checkbox" name="chk_seq[]" value="1" cancel_type="<?php echo $TPL_V1["cancel_type"]?>" /></label>
<?php }?>
						<input type="hidden" name="chk_item_seq[]" value="<?php echo $TPL_V2["item_seq"]?>" />
						<input type="hidden" name="chk_option_seq[]" value="<?php echo $TPL_V2["item_option_seq"]?>" />
						<input type="hidden" name="chk_suboption_seq[]" value="" />
						<input type="hidden" name="chk_individual_refund[]" value="<?php echo $TPL_V1["individual_refund"]?>" />
						<input type="hidden" name="chk_individual_refund_inherit[]" value="<?php echo $TPL_V1["individual_refund_inherit"]?>" />
						<input type="hidden" name="chk_individual_export[]" value="<?php echo $TPL_V1["individual_export"]?>" />
						<input type="hidden" name="chk_individual_return[]" value="<?php echo $TPL_V1["individual_return"]?>" />
					</li>
					<li class="subject">
						<ul class="board_goods_list">
							<li class="pic">
								<img src="<?php echo $TPL_V1["image"]?>" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage_list.gif'" alt="<?php echo $TPL_V1["goods_name"]?>" />
							</li>
							<li class="info">
								<div class="title">
<?php if($TPL_V1["goods_type"]=='gift'||$TPL_V1["cancel_type"]=='1'){?>
									<div class="Pb5">
<?php if($TPL_V1["goods_type"]=='gift'){?><span class="pointcolor2">[사은품]</span><?php }?>
<?php if($TPL_V1["cancel_type"]=='1'){?><span class="pointcolor2">[청약철회불가]</span><?php }?>
									</div>
<?php }?>
<?php if($TPL_V2["coupon_serial"]){?>
									티켓번호: <?php echo $TPL_V2["coupon_serial"]?>

<?php }?>
<?php if($TPL_V2["goods_kind"]=='coupon'&&$TPL_V2["social_start_date"]&&$TPL_V2["social_end_date"]){?>
									<span class="Fs13 No desc">(유효기간:<?php echo $TPL_V2["social_start_date"]?>~<?php echo $TPL_V2["social_end_date"]?>)</span>
<?php }?>
									<?php echo $TPL_V1["goods_name"]?>

								</div>
<?php if($TPL_V2["option1"]!=null||$TPL_V2["option2"]!=null||$TPL_V2["option3"]!=null||$TPL_V2["option4"]!=null||$TPL_V2["option5"]!=null){?>
								<div class="cont3">
<?php if($TPL_V2["option1"]!=null){?><span class="res_option_inline"><span class="xtle"><?php echo $TPL_V2["title1"]?></span><?php echo $TPL_V2["option1"]?></span><?php }?>
<?php if($TPL_V2["option2"]!=null){?><span class="res_option_inline"><span class="xtle"><?php echo $TPL_V2["title2"]?></span><?php echo $TPL_V2["option2"]?></span><?php }?>
<?php if($TPL_V2["option3"]!=null){?><span class="res_option_inline"><span class="xtle"><?php echo $TPL_V2["title3"]?></span><?php echo $TPL_V2["option3"]?></span><?php }?>
<?php if($TPL_V2["option4"]!=null){?><span class="res_option_inline"><span class="xtle"><?php echo $TPL_V2["title4"]?></span><?php echo $TPL_V2["option4"]?></span><?php }?>
<?php if($TPL_V2["option5"]!=null){?><span class="res_option_inline"><span class="xtle"><?php echo $TPL_V2["title5"]?></span><?php echo $TPL_V2["option5"]?></span><?php }?>
								</div>
<?php }?>
<?php if($TPL_V1["inputs"]){?>
								<div class="cont3">
<?php if(is_array($TPL_R3=$TPL_V1["inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V2["value"]){?>
									<span class="res_option_inline">
<?php if($TPL_V3["title"]){?><span class="xtle v2"><?php echo $TPL_V3["title"]?></span><?php }?><?php if($TPL_V3["type"]=='file'){?><a href="../mypage_process/filedown?file=<?php echo $TPL_V3["value"]?>" target="actionFrame" class="gray_05" title="다운로드"><?php echo $TPL_V3["value"]?></a><?php }else{?><?php echo $TPL_V3["value"]?><?php }?>
									</span>
<?php }?>
<?php }}?>
								</div>
<?php }?>
							</li>
						</ul>
					</li>
					<li><span class="mtitle">주문:</span> <?php echo number_format($TPL_V2["ea"])?></li>
					<li><span class="mtitle">가능:</span> <?php echo number_format($TPL_V2["able_refund_ea"])?></li>
					<li>
						<span class="mtitle">취소:</span> 
<?php if($TPL_V2["able_refund_ea"]> 0){?>
							<!-- 인풋 박스 처리 시 input다음에 select를 위치한다. -->
							<input type="number" name="input_chk_ea[]" class="only_number_for_chk_ea res_board_boxad" style="width:48px;" value="<?php echo $TPL_V2["able_refund_ea"]?>" min="1" max="<?php echo $TPL_V2["able_refund_ea"]?>" disabled />
							<select name="chk_ea[]" style="display:none;">
								<option value="<?php echo $TPL_V2["able_refund_ea"]?>" selected><?php echo $TPL_V2["able_refund_ea"]?></option>
							</select>
<?php }else{?>
							-
<?php }?>
					</li>
					<li class="mo_end v2"><span class="reply_title gray_01"><?php echo $TPL_V2["mstep"]?></span></li>
				</ul>
<?php if(is_array($TPL_R3=$TPL_V2["suboptions"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["able_refund_ea"]&&$TPL_V2["goods_type"]!='gift'){?>
				<ul class="tbody suboptions">
<?php }else{?>
				<ul class="tbody suboptions" disabledScript=1>
<?php }?>
					<li>
<?php if($TPL_V1["cancel_type"]=='1'){?>
							<label><input type="checkbox" name="chk_seq[]"  readonly="readonly" disabled="disabled"  cancel_type="<?php echo $TPL_V1["cancel_type"]?>" /></label>
<?php }else{?>
							<label><input type="checkbox" name="chk_seq[]" value="1"  cancel_type="<?php echo $TPL_V1["cancel_type"]?>" /></label>
<?php }?>
						<input type="hidden" name="chk_item_seq[]" value="<?php echo $TPL_V3["item_seq"]?>" item_option_seq="<?php echo $TPL_V2["item_option_seq"]?>" />
						<input type="hidden" name="chk_option_seq[]" value="<?php echo $TPL_V2["item_option_seq"]?>" />
						<input type="hidden" name="chk_suboption_seq[]" value="<?php echo $TPL_V3["item_suboption_seq"]?>" />

						<input type="hidden" name="chk_individual_refund[]" value="<?php echo $TPL_V1["individual_refund"]?>" />
						<input type="hidden" name="chk_individual_refund_inherit[]" value="<?php echo $TPL_V1["individual_refund_inherit"]?>" />
						<input type="hidden" name="chk_individual_export[]" value="<?php echo $TPL_V1["individual_export"]?>" />
						<input type="hidden" name="chk_individual_return[]" value="<?php echo $TPL_V1["individual_return"]?>" />
					</li>
					<li class="subject">
<?php if($TPL_V3["suboption"]){?>
						<div class="reply_ui">
<?php if($TPL_V3["title"]){?><span class="xtle v3"><?php echo $TPL_V3["title"]?></span><?php }?> <?php echo $TPL_V3["suboption"]?>

						</div>
<?php }?>
					</li>
					<li><span class="mtitle">주문:</span> <?php echo number_format($TPL_V3["ea"])?></li>
					<li><span class="mtitle">가능:</span> <?php echo number_format($TPL_V3["able_refund_ea"])?></li>
					<li>
						<span class="mtitle">취소:</span> 
<?php if($TPL_V3["able_refund_ea"]> 0){?>
							<!-- 인풋 박스 처리 시 input다음에 select를 위치한다. -->
							<input type="number" name="input_chk_ea[]" class="only_number_for_chk_ea res_board_numbox" style="width:48px;" value="<?php echo $TPL_V3["able_refund_ea"]?>" min="1" max="<?php echo $TPL_V3["able_refund_ea"]?>" disabled />
							<select name="chk_ea[]" style="display:none;">
								<option value="<?php echo $TPL_V3["able_refund_ea"]?>" selected><?php echo $TPL_V3["able_refund_ea"]?></option>
							</select>
<?php }else{?>
							-
<?php }?>
					</li>
					<li class="mo_end v2"><span class="reply_title gray_01"><?php echo $TPL_V3["mstep"]?></span></li>
				</ul>
<?php }}?>
<?php }}?>
<?php }}?>
			</div>

			<div id="refund_method_layer" <?php if($TPL_VAR["orders"]["payment"]=="card"||$TPL_VAR["orders"]["payment"]=="kakaomoney"||$TPL_VAR["orders"]["pg"]=="payco"||$TPL_VAR["orders"]["payment"]=="cellphone"){?>style="display: none"<?php }?>>
				<h3 class="title_sub1">환불 방법</h3>
				<div class="table_top_line1"></div>
				<table class="table_row_a v2 Thc" width="100%" cellpadding="0" cellspacing="0">
					<colgroup><col class="size_b"><col></colgroup>
					<tbody>
						<tr>
							<th><p>은행</p></th>
							<td><input type="text" name="bank_name" value="" /></td>
						</tr>
						<tr>
							<th><p>예금주</p></th>
							<td><input type="text" name="bank_depositor" value="" /></td>
						</tr>
						<tr>
							<th><p>계좌번호</p></th>
							<td><input type="tel" name="bank_account" value="" /></td>
						</tr>
					</tbody>
				</table>
				<ul class="list_dot_01 Mt10 desc">
					<li>환불방법은 복합결제(마일리지, 쿠폰 사용 등) 및 최초 배송비 계산 등의 이유로 쇼핑몰 관리자와 협의 후 결정됩니다.</li>
				</ul>
			</div>

			<h3 class="title_sub1">상세 사유</h3>
			<textarea name="refund_reason" class="size1"></textarea>

			<h3 class="title_sub1">최초 배송비</h3>
			<div class="gray_05">
				<p>부분 결제 취소 시 추가 배송비가 발생할 수 있으며, 이 때 추가 배송비를 결제해주셔야만 결제취소 처리완료가 가능합니다.</p>
				<p class="Pt12 Pb5"><strong class="gray_04">추가 배송비가 발생하는 경우,</strong></p>
				<ol class="list_01 v3">
					<li>① ‘묶음 배송비’ 상품의 배송비 무료(금액별 차등) 조건을 충족하여 배송비 무료</li>
					<li>② 부분 결제취소로 배송비 무료 조건을 불충족하는 경우 추가 배송비 부과</li>
					<li>③ 추가 배송비는 카드 또는 마일리지로 결제 가능</li>
				</ol>
			</div>

			<div class="btn_area_c">
				<button type="submit" class="btn_resp size_c color2">신청하기</button>
				<a href="/mypage/order_catalog" class="btn_resp size_c">취소</a>
			</div>

		</form>
		</div> 


	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->