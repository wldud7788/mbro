<?php /* Template_ 2.2.6 2022/05/17 12:36:54 /www/music_brother_firstmall_kr/admin/skin/default/setting/add_national_view.html 000026777 */ 
$TPL_shipping_type_1=empty($TPL_VAR["shipping_type"])||!is_array($TPL_VAR["shipping_type"])?0:count($TPL_VAR["shipping_type"]);?>
<script type='text/javascript' src='/app/javascript/jquery/jquery.min.js'></script>
<script type="text/javascript">
$(document).ready(function() {
	// 부모창 접근
	var nation	= '<?php echo $TPL_VAR["ship_set"]["delivery_nation"]?>';
	var target_idx = Number('<?php echo $TPL_VAR["idx"]?>');
<?php if($TPL_VAR["mode"]=='modify'){?>
	var parentobj = parent;
<?php }else{?>
	var parentobj = parent.opener;
<?php }?>

	var idx		= 1;
	var tbObj	= $("."+nation+"_tb",parentobj.document).find(".tbody");
	
	// 기본 TR 삭제
	if($(tbObj).find("tr").attr("base_tr")=="Y"){
		$(tbObj).find("tr").remove();
	}else{
		if(target_idx){
			idx = target_idx;
		}else{
			var last_cls = $(tbObj).find(".item_tr:last-child");
			var tmp_idx	 = last_cls.attr('class').replace('item_tr item_idx_', '');
			if(tmp_idx > 0){
				idx	= parseInt(tmp_idx) + 1;
			}
		}
	}

	// input box의 Name 변경
	var itemObj = $(".item_view").find(".item_tb > tbody");
	$(itemObj).find("input").each(function(){
		var inputName = $(this).attr('name');
		if(typeof(inputName) != 'undefined' && inputName != 'default_yn'){
			var inputArr	= inputName.split('[');
			inputArr[0]		= inputArr[0] + '['+nation+']['+(idx-1)+']';
			var newinput	=inputArr.join('[');
			$(itemObj).find("input[name='"+inputName+"']").attr('name',newinput).addClass('item_idx_' + idx + '_input');
		}
	});

	// 관리->기본 값 설정
	$("input[name='default_yn']").val(nation+'_'+(idx-1));
<?php if($TPL_VAR["mode"]!='modify'){?>
	var already_def = $("input[name='default_yn']",parentobj.document).length;

	if(( idx == 1 && ((already_def == 1 && target_idx) || (already_def < 1 && !target_idx))) || (target_idx && $("input[name='default_yn']",parentobj.document).eq(target_idx - 1).attr('checked'))){
		$(itemObj).find("input[name='default_yn']").closest('.controll_td').css('background-color','#FFE3BB');
		$(itemObj).find("input[name='default_yn']").attr('checked',true);
	}
<?php }?>

	// 부모창 Item Insert
	var itemHtml = '<tr class="item_tr ready_item_tr">' + itemObj.find('tr.ready_item_tr').html() + '</tr>';

	// 기존 정보 수정 시
	if(target_idx){
		$(tbObj).find(".item_idx_" + target_idx).remove();
		var node_idx = target_idx;
		if(target_idx > 1){
			node_idx = target_idx - 1;

			$(tbObj).find(".item_idx_" + node_idx).after(itemHtml);
		}else{
			$(tbObj).prepend(itemHtml);
		}
	}else{
		$(tbObj).append(itemHtml);
	}

<?php if($TPL_VAR["default_yn"]=='Y'&&false){?> 
	// 추후 실시간 연결을 위해 유지.. 현재는 무조건 작동안하도록 수정. 2017-02-16 lwh
	// 기본배송 무료화 정책 체크
	var free_desc = "본 배송그룹의 기본배송방법의 기본배송비가 '무료'가 아니므로<br/>본 배송그룹에 속한 상품은 무료배송으로 자동 표시될 수 없습니다.";
<?php if($TPL_VAR["ship_opt"]['std']['shipping_opt_type']=='free'||$TPL_VAR["ship_opt"]['store']){?>
	free_desc = "본 배송그룹의 기본배송방법의 기본배송비가 '무료'이므로<br/>본 배송그룹에 속한 상품은 무료배송으로 자동 표시될 수 있습니다.";
<?php }?>
	//$(".free-desc",parentobj.document).html(free_desc);
	//$(".free-desc-foot",parentobj.document).show();
<?php }?>

	$(tbObj).find("tr.ready_item_tr").removeClass('ready_item_tr').addClass('item_idx_' + idx);
	parentobj.shipping_set_add(nation);
<?php if($TPL_VAR["mode"]=='modify'){?>
	location.href="/admin/setting_process/add_shipping_item?mode=modify&grp_seq=<?php echo $TPL_VAR["grp_seq"]?>&num=<?php echo $TPL_VAR["num"]?>";
<?php }else{?>
	parent.window.close();
<?php }?>
});
</script>
<div class="item_view">
	<table class="item_tb">
	<tbody>
	<tr class="item_tr ready_item_tr">
		<td class="its-td center nonpd under-line" width="150px">
			<input type="hidden" name="shipping_set_seq" class="set_seq_input" value="<?php echo $TPL_VAR["ship_set"]["shipping_set_seq"]?>" />
			<input type="hidden" class="cl_shipping_set_code" name="shipping_set_code" value="<?php echo $TPL_VAR["ship_set"]["shipping_set_code"]?>" />
			<input type="hidden" name="shipping_set_name" value="<?php echo $TPL_VAR["ship_set"]["shipping_set_name"]?>"  />
			<input type="hidden" name="prepay_info" value="<?php echo $TPL_VAR["ship_set"]["prepay_info"]?>" />
			<input type="hidden" name="delivery_nation" value="<?php echo $TPL_VAR["ship_set"]["delivery_nation"]?>" />
			<input type="hidden" name="delivery_type" value="<?php echo $TPL_VAR["ship_set"]["delivery_type"]?>" />
			<input type="hidden" name="npay_order_possible" value="<?php echo $TPL_VAR["ship_set"]["npay_order_possible"]?>" />
			<input type="hidden" name="npay_order_impossible_msg" value="<?php echo $TPL_VAR["ship_set"]["npay_order_impossible_msg"]?>" />

			<div>
				<?php echo $TPL_VAR["ship_set"]["shipping_set_name"]?>

<?php if($TPL_VAR["ship_set"]["custom_set_use"]=='Y'){?>
				<br/>
				(<?php echo $TPL_VAR["ship_set_code"][$TPL_VAR["ship_set"]["shipping_set_code"]]?>)
<?php }?>
			</div>
			<div>
<?php if($TPL_VAR["ship_set"]["prepay_info"]=='delivery'){?>
				선불
<?php }elseif($TPL_VAR["ship_set"]["prepay_info"]=='postpaid'){?>
				착불
<?php }else{?>
				선/착불
<?php }?>
				
			</div>
			<div class="delivery-info">
<?php if($TPL_VAR["ship_set"]["shipping_set_seq"]&&$TPL_VAR["ship_set"]["shipping_set_code"]!='direct_store'){?>
				<input type="button" class="resp_btn" onclick="ship_desc_pop('<?php echo $TPL_VAR["ship_set"]["shipping_set_seq"]?>')" value="배송안내" />
<?php }else{?>
				<span title="저장이 되지 않았거나, 안내할수 없는 타입입니다."><input type="button" class="btn_resp" value="배송안내" /></span>
<?php }?>
<?php if($TPL_shipping_type_1){foreach($TPL_VAR["shipping_type"] as $TPL_K1=>$TPL_V1){?>
					<input type="hidden" name="<?php echo $TPL_K1?>_use" value="<?php if($TPL_VAR["ship_set"][$TPL_K1]['use_yn']=='Y'){?>Y<?php }else{?>N<?php }?>" />
					<input type="hidden" name="delivery_<?php echo $TPL_K1?>_type" value="<?php if($TPL_VAR["ship_set"][$TPL_K1]['delivery_info_type']=='N'){?>N<?php }else{?>Y<?php }?>" />
					<input type="hidden" name="delivery_<?php echo $TPL_K1?>_input" value="<?php echo $TPL_VAR["ship_set"][$TPL_K1]['delivery_info_input']?>" />
<?php }}?>
			</div>
		</td>
		<td class="its-td center nonpd under-line clear" >
			<table class="table_basic v3">
			<tr>
				<td class="its-td center nonpd" width="80px">배송비</td>
				<td class="its-td center nonpd clear">
					<table class="table_basic v3">
<?php if($TPL_shipping_type_1){$TPL_I1=-1;foreach($TPL_VAR["shipping_type"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
					<tr>
						<td class="its-td center nonpd " width="85px" style="border-left:none;<?php if(count($TPL_VAR["shipping_type"])==($TPL_I1+ 1)){?>border-bottom:none;<?php }?>"><?php echo $TPL_V1?></td>
						<td class="its-td left" <?php if(count($TPL_VAR["shipping_type"])==($TPL_I1+ 1)){?>style="border-bottom:none;"<?php }?>>
<?php if($TPL_VAR["ship_set"][$TPL_K1]['use_yn']=='Y'){?>
<?php if($TPL_K1=='std'){?>
							<div class="delivery-limit-lay">
							<input type="hidden" name="delivery_limit" value="<?php echo $TPL_VAR["ship_set"]["delivery_limit"]?>" />
<?php if($TPL_VAR["ship_set"]["delivery_limit"]=='unlimit'){?>
<?php if($TPL_VAR["ship_set"]["delivery_nation"]=='korea'){?>
							대한민국 전국 배송
<?php }else{?>
							전세계 배송
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["ship_set"]["delivery_nation"]=='korea'){?>
							대한민국 중 지정 지역 배송
<?php }else{?>
							해외국가 중 선택 국가 배송
<?php }?>
<?php }?>
							</div>
<?php }?>
<?php if($TPL_K1=='hop'){?>
							<div class="hop_shipping_area pdb20">
								<table class="table_basic">
								<tr>
									<th class="its-th" width="150px">희망배송일 선택</th>
									<td class="its-td">
										<input type="hidden" name="hopeday_required" value="<?php echo $TPL_VAR["ship_set"]["hopeday_required"]?>" />
<?php if($TPL_VAR["ship_set"]["hopeday_required"]=='N'){?>
										선택사항
<?php }else{?>
										필수사항
<?php }?>
									</td>
								</tr>
								<tr>
									<th class="its-th">선택 가능 시작일</th>
									<td class="its-td">
										<input type="hidden" name="hopeday_limit_set" value="<?php echo $TPL_VAR["ship_set"]["hopeday_limit_set"]?>" />
										<input type="hidden" name="hopeday_limit_val" value="<?php echo $TPL_VAR["ship_set"]["hopeday_limit_val"]?>" />
<?php if($TPL_VAR["ship_set"]["hopeday_limit_set"]=='time'){?>
									주문 당일부터 선택 가능<br/>
									단, 주문 당일은 <?php echo substr($TPL_VAR["ship_set"]["hopeday_limit_val"], 0, 2)?>:<?php echo substr($TPL_VAR["ship_set"]["hopeday_limit_val"], 2, 2)?> 이전 주문 시 당일배송 선택 가능
<?php }else{?>
									주문 당일 + <?php echo $TPL_VAR["ship_set"]["hopeday_limit_val"]?> 일째 되는 날 부터 선택 가능
<?php }?>
									</td>
								</tr>
								<tr>
									<th class="its-th">특정요일 선택 불가</th>
									<td class="its-td">
										<input type="hidden" name="hopeday_limit_week" value="<?php echo $TPL_VAR["ship_set"]['hopeday_limit_week_real']?>" />
<?php if(is_array($TPL_R2=$TPL_VAR["ship_set"]['hopeday_limit_week'])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<?php if($TPL_V2=='1'){?>
										<?php echo $TPL_VAR["weekday"][$TPL_K2]?>

<?php }?>
<?php }}?>
									</td>
								</tr>
								<tr>
									<th class="its-th">선택 불가일</th>
									<td class="its-td nonpd">
										<table class="table_basic info-tb-inner hopday-tb" >
<?php if($TPL_VAR["ship_set"]['hopeday_limit_repeat_day']){?>
										<tr>
											<td width="80px" style="border-bottom:1px solid #DADADA;">매년</td>
											<td style="border-bottom:1px solid #DADADA;">
												<input type="hidden" name="hopeday_limit_repeat_day" value="<?php echo $TPL_VAR["ship_set"]['hopeday_limit_repeat_day']?>" />
												<?php echo $TPL_VAR["ship_set"]['hopeday_limit_repeat_day']?>

											</td>
										</tr>
<?php }?>
<?php if($TPL_VAR["ship_set"]['limit_day_tmp']){?>
<?php if(is_array($TPL_R2=$TPL_VAR["ship_set"]['limit_day_tmp'])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_K2=>$TPL_V2){$TPL_I2++;?>
										<tr>
											<td width="50px">
<?php if($TPL_I2== 0){?>
												<input type="hidden" name="hopeday_limit_day" value="<?php echo $TPL_VAR["ship_set"]['hopeday_limit_day']?>" />
												<input type="hidden" name="limit_day_serialize" value='<?php echo $TPL_VAR["ship_set"]['limit_day_serialize']?>' />
<?php }?>
												<?php echo $TPL_K2?>년
											</td>
											<td><?php echo implode(', ',$TPL_V2)?></td>
										</tr>
<?php }}?>
<?php }?>
										</table>
									</td>
								</tr>
								</table>
							</div>
<?php }elseif($TPL_K1=='store'){?>
							<div class="store_shipping_area">
<?php if($TPL_VAR["ship_store"]){?>
								<table class="table_basic">
								<colgroup>
									<col width="80px" />
									<col width="100px" />
									<col width="50px" />
									<col />
									<col width="100px" />
									<col width="200px" />
									<col width="50px" />
								</colgroup>
								<thead>
								<tr>
									<th class="its-th center">분류</th>
									<th class="its-th center">매장명</th>
									<th class="its-th-align center">해외</th>
									<th class="its-th center">주소</th>
									<th class="its-th center">전화번호</th>
									<th class="its-th-align pdl5">매장의 재고수량</th>
									<th class="its-th-align center">상태</th>
								</tr>
								</thead>
								<tbody>
<?php if(is_array($TPL_R2=$TPL_VAR["ship_store"]['rel'])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
								<tr>
									<td class="its-td-align center">
										<input type="hidden" name="store_address_seq[<?php echo $TPL_I2?>]" value="<?php echo $TPL_V2["shipping_address_seq"]?>" />
										<input type="hidden" name="shipping_address_category[<?php echo $TPL_I2?>]" value="<?php echo $TPL_VAR["ship_store"]['tmp'][$TPL_I2]['shipping_address_category']?>" />
										<?php echo $TPL_VAR["ship_store"]['tmp'][$TPL_I2]['shipping_address_category']?>

									</td>
									<td class="its-td left">
										<input type="hidden" name="shipping_store_name[<?php echo $TPL_I2?>]" value="<?php echo $TPL_V2["shipping_store_name"]?>" />
										<?php echo $TPL_V2["shipping_store_name"]?>

<?php if($TPL_V2["store_scm_use"]=='Y'){?>
										<div class="blue">(사용 창고)</div>
<?php }elseif($TPL_V2["store_scm_use"]=='N'){?>
										<div class="red">(미사용 창고)</div>
<?php }?>
									</td>
									<td class="its-td-align center">
										<input type="hidden" name="shipping_address_nation[<?php echo $TPL_I2?>]" value="<?php echo $TPL_VAR["ship_store"]['tmp'][$TPL_I2]['shipping_address_nation']?>" />
										<?php echo $TPL_VAR["ship_store"]['tmp'][$TPL_I2]['shipping_address_nation']?>

									</td>							
									<td class="its-td left">
										<input type="hidden" name="shipping_address_full[<?php echo $TPL_I2?>]" value="<?php echo $TPL_VAR["ship_store"]['tmp'][$TPL_I2]['shipping_address_full']?>" />
										<?php echo $TPL_VAR["ship_store"]['tmp'][$TPL_I2]['shipping_address_full']?>

									</td>
									<td class="its-td-align pdl5">
										<input type="hidden" name="store_phone[<?php echo $TPL_I2?>]" value="<?php echo $TPL_V2["store_phone"]?>" />
										<?php echo $TPL_V2["store_phone"]?>

									</td>
									<td class="its-td-align pdl5">
										<input type="hidden" name="store_information[<?php echo $TPL_I2?>]" value="<?php echo $TPL_V2["store_information"]?>" />
										<input type="hidden" name="store_scm_type[<?php echo $TPL_I2?>]" value="<?php echo $TPL_V2["store_scm_type"]?>" />
										<input type="hidden" name="store_supply_set[<?php echo $TPL_I2?>]" value="<?php echo $TPL_V2["store_supply_set"]?>" />
										<input type="hidden" name="store_supply_set_view[<?php echo $TPL_I2?>]" value="<?php echo $TPL_V2["store_supply_set_view"]?>" />
										<input type="hidden" name="store_supply_set_order[<?php echo $TPL_I2?>]" value="<?php echo $TPL_V2["store_supply_set_order"]?>" />
<?php if($TPL_V2["store_supply_set"]=='Y'){?>
											해당 상품의 해당 창고의 재고수량<br/>
<?php if($TPL_V2["store_supply_set_view"]=='Y'){?>
											※ 매장 재고수량 노출
<?php }else{?>
											※ 매장 재고수량 미노출
<?php }?>
											<br/>
<?php if($TPL_V2["store_supply_set_order"]=='Y'){?>
											※ 매장 재고수량 있을때 선택가능
<?php }else{?>
											※ 매장 재고수량 없어도 선택가능
<?php }?>
<?php }else{?>
										해당 상품의 재고수량
<?php }?>
									</td>
									<td class="its-td-align center">
										<input type="hidden" name="store_scm_use[<?php echo $TPL_I2?>]" value="<?php echo $TPL_V2["store_scm_use"]?>" />
<?php if($TPL_V2["store_scm_use"]=='N'){?>
										<div class="red">미노출</div>
<?php }else{?>
										<div class="blue">노출</div>
<?php }?>
									</td>
									<input name="store_type[<?php echo $TPL_I2?>]" type="hidden" value="<?php echo $TPL_V2["store_type"]?>" />
									<input name="store_scm_seq[<?php echo $TPL_I2?>]" type="hidden" value="<?php echo $TPL_V2["store_scm_seq"]?>" />
								</tr>
<?php }}?>
								</tbody>
								</table>
<?php }?>
							</div>
<?php }?>


<?php if($TPL_K1=='std'||$TPL_K1=='add'||$TPL_K1=='hop'){?>
							<div class="cost_shipping_area">
								<table class="table_basic wauto" >
								<thead>
								<tr>
									<th class="its-th center">
										<input type="hidden" name="shipping_opt_type[<?php echo $TPL_K1?>]" value="<?php echo $TPL_VAR["ship_opt"][$TPL_K1]['shipping_opt_type']?>" />
										<?php echo $TPL_VAR["shipping_otp_type"][$TPL_VAR["ship_opt"][$TPL_K1]['shipping_opt_type']]?>

<?php if($TPL_VAR["ship_opt"][$TPL_K1]['shipping_opt_type']!='free'&&$TPL_VAR["ship_opt"][$TPL_K1]['shipping_opt_type']!='fixed'){?>
										<span class="btn-help" onclick="ship_opt_pop();"></span>
<?php }?>
									</th>
<?php if(is_array($TPL_R2=$TPL_VAR["ship_cost"][$TPL_K1][ 0]['shipping_area_name'])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
									<th class="its-th center" width="110px">
<?php if($TPL_VAR["ship_set"]["delivery_nation"]!='korea'){?>
										<span <?php if(count($TPL_VAR["ship_zone"][$TPL_K1]['sel_address_street'][$TPL_K2])> 0){?>onclick="ship_zone_pop(this);" class="hand blue"<?php }?>>
											<input type="hidden" name="shipping_area_name[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>]" value="<?php echo $TPL_V2?>" />
											<?php echo $TPL_V2?>

<?php if(count($TPL_VAR["ship_zone"][$TPL_K1]['sel_address_street'][$TPL_K2])> 0){?>(<?php echo count($TPL_VAR["ship_zone"][$TPL_K1]['sel_address_street'][$TPL_K2])?>)<?php }?>
										</span>
<?php }else{?>
										<span <?php if($TPL_VAR["zone_count"][$TPL_K1][$TPL_K2]['count']> 0){?> onclick="ship_zone_pop_ajax(this, '<?php echo $TPL_VAR["zone_cost_seq"][$TPL_K1][$TPL_K2]?>', <?php echo $TPL_VAR["zone_count"][$TPL_K1][$TPL_K2]?>, 0, 0);" class="hand blue"<?php }?>>
											<input type="hidden" name="shipping_area_name[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>]" value="<?php echo $TPL_V2?>" />
											<input type="hidden" name="zone_count[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>]" value="<?php echo $TPL_VAR["zone_count"][$TPL_K1][$TPL_K2]?>" />
											<input type="hidden" name="zone_cost_seq[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>]" value="<?php echo $TPL_VAR["zone_cost_seq"][$TPL_K1][$TPL_K2]?>" />
											<?php echo $TPL_V2?>

<?php if($TPL_VAR["zone_count"][$TPL_K1][$TPL_K2]> 0){?>(<?php echo $TPL_VAR["zone_count"][$TPL_K1][$TPL_K2]?>)<?php }?>
										</span>
<?php }?>
										<span>
<?php if($TPL_K1=='hop'&&$TPL_VAR["ship_cost"][$TPL_K1][ 0]['shipping_today_yn'][$TPL_K2]=='Y'){?>
											<input type="hidden" name="shipping_today_yn[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>]" value="<?php echo $TPL_VAR["ship_cost"][$TPL_K1][ 0]['shipping_today_yn'][$TPL_K2]?>" />
											<br/>(당일)
<?php }?>
										</span>
<?php if($TPL_VAR["ship_set"]["delivery_nation"]!='korea'){?>
										<div class="zone_address_area hide">
<?php if(is_array($TPL_R3=$TPL_VAR["ship_zone"][$TPL_K1]['sel_address_street'][$TPL_K2])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
											<input type="hidden" name="sel_address_street[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>][<?php echo $TPL_I3?>]" value="<?php echo $TPL_V3?>" />
											<input type="hidden" name="sel_address_zibun[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>][<?php echo $TPL_I3?>]" value="<?php echo $TPL_VAR["ship_zone"][$TPL_K1]['sel_address_zibun'][$TPL_K2][$TPL_I3]?>" />
											<input type="hidden" name="sel_address_join[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>][<?php echo $TPL_I3?>]" value="<?php echo $TPL_VAR["ship_zone"][$TPL_K1]['sel_address_join'][$TPL_K2][$TPL_I3]?>" />
											<input type="hidden" name="sel_address_txt[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>][<?php echo $TPL_I3?>]" value="<?php echo $TPL_VAR["ship_zone"][$TPL_K1]['sel_address_txt'][$TPL_K2][$TPL_I3]?>" />
<?php }}?>
										</div>
										<div class="zone_address_pop hide">
											<table class="info-table-style" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<th class="its-th center" width="30px">번호</th>
												<th class="its-th center">주소</td>
											</tr>
<?php if(is_array($TPL_R3=$TPL_VAR["ship_zone"][$TPL_K1]['sel_address_street'][$TPL_K2])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
											<tr>
												<td class="its-td nonpd center"><?php echo (count($TPL_VAR["ship_zone"][$TPL_K1]['sel_address_street'][$TPL_K2])-$TPL_I3)?></th>
												<td class="its-td">
													<?php echo $TPL_VAR["ship_zone"][$TPL_K1]['sel_address_txt'][$TPL_K2][$TPL_I3]?>

												</td>
											</tr>
<?php }}?>
											</table>
											<br/>
										</div>
<?php }else{?>
										<div id="zone_address_pop_<?php echo $TPL_VAR["zone_cost_seq"][$TPL_K1][$TPL_K2]?>" class="hide">
											<table class="info-table-style" cellpadding="0" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th class="its-th center" width="30px">번호</th>
													<th class="its-th center">주소</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
											</table>
											<br/>
											<div class="paging_navigation"></div>
										</div>
<?php }?>
									</th>
<?php }}?>
								</tr>
								</thead>
								<tbody>
<?php if(is_array($TPL_R2=$TPL_VAR["ship_opt"][$TPL_K1]['section_st'])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_K2=>$TPL_V2){$TPL_I2++;?>
								<tr>
									<td class="its-td" style="min-width:100px;">
										<div class="section_area_input">
											<input type="hidden" name="section_st[<?php echo $TPL_K1?>][<?php echo $TPL_I2?>]" value="<?php echo $TPL_V2?>" />
											<input type="hidden" name="section_ed[<?php echo $TPL_K1?>][<?php echo $TPL_I2?>]" value="<?php echo $TPL_VAR["ship_opt"][$TPL_K1]['section_ed'][$TPL_I2]?>" />
											<input type="hidden" name="shipping_opt_seq[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>]" value="<?php echo $TPL_VAR["shipping_opt_seq"][$TPL_K1][$TPL_K2]?>" />

<?php if($TPL_VAR["ship_opt"][$TPL_K1]['shipping_opt_type']=='free'||$TPL_VAR["ship_opt"][$TPL_K1]['shipping_opt_type']=='fixed'){?>
											<div style="width:100%;text-align:center;">─</div>
<?php }else{?>
											<?php echo $TPL_V2?> <?php echo $TPL_VAR["ship_opt"][$TPL_K1]['shipping_opt_unit']?>

<?php if(strpos($TPL_VAR["ship_opt"][$TPL_K1]['shipping_opt_type'],'rep')&&count($TPL_VAR["ship_opt"][$TPL_K1]['section_st'])==($TPL_I2+ 1)){?>
											부터는
<?php }else{?>
											이상 ~ 
<?php }?>
<?php if(strpos($TPL_VAR["ship_opt"][$TPL_K1]['shipping_opt_type'],'rep')){?>
											<?php echo $TPL_VAR["ship_opt"][$TPL_K1]['section_ed'][$TPL_I2]?> <?php echo $TPL_VAR["ship_opt"][$TPL_K1]['shipping_opt_unit']?>

<?php if(count($TPL_VAR["ship_opt"][$TPL_K1]['section_st'])==($TPL_I2+ 1)){?>당<?php }else{?>미만<?php }?>
<?php }elseif(count($TPL_VAR["ship_opt"][$TPL_K1]['section_st'])>($TPL_I2+ 1)){?>
											<?php echo $TPL_VAR["ship_opt"][$TPL_K1]['section_ed'][$TPL_I2]?> <?php echo $TPL_VAR["ship_opt"][$TPL_K1]['shipping_opt_unit']?>

<?php }?>
<?php }?>
										</div>
									</td>
<?php if(is_array($TPL_R3=$TPL_VAR["ship_cost"][$TPL_K1][$TPL_I2]['shipping_cost'])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
									<td class="its-td right pdr5" width="105px">
										<input type="hidden" name="shipping_cost[<?php echo $TPL_K1?>][<?php echo $TPL_I2?>][<?php echo $TPL_K3?>]" value="<?php echo $TPL_V3?>" />
										<input type="hidden" name="shipping_cost_seq[<?php echo $TPL_K1?>][<?php echo $TPL_I2?>][<?php echo $TPL_K3?>]" value="<?php echo $TPL_VAR["ship_cost"][$TPL_K1][$TPL_I2]['shipping_cost_seq'][$TPL_K3]?>" />
										<?php echo $TPL_V3?> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

<?php if($TPL_VAR["ship_cost"][$TPL_K1][$TPL_I2]['shipping_today_yn'][$TPL_K3]=='Y'){?>
										<input type="hidden" name="shipping_cost_today[<?php echo $TPL_K1?>][<?php echo $TPL_I2?>][<?php echo $TPL_K3?>]" value="<?php echo $TPL_VAR["ship_cost"][$TPL_K1][$TPL_I2]['shipping_cost_today'][$TPL_K3]?>" />
										<br/>당일 <?php echo $TPL_VAR["ship_cost"][$TPL_K1][$TPL_I2]['shipping_cost_today'][$TPL_K3]?> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

<?php }?>
									</td>
<?php }}?>
								</tr>
<?php }}?>
								</tbody>
								</table>
							</div>
<?php }?>
<?php }else{?>
						<span class="gray fx11" style="">미사용</span>
<?php }?>
						</td>
					</tr>
<?php }}?>
					</table>
				</td>
			</tr>
			<tr>
				<td>반품</br/>배송비</td>
				<td class="its-td center nonpd clear">
					<table class="table_basic v3 info-tb-inner">
					<tr>
						<td class="its-td center nonpd" width="84px" >반품</td>
						<td class="its-td left">
							<input type="hidden" name="refund_shiping_cost" value="<?php echo $TPL_VAR["ship_set"]["refund_shiping_cost"]?>" />
							<input type="hidden" name="shiping_free_yn" value="<?php echo $TPL_VAR["ship_set"]["shiping_free_yn"]?>" />
							편도 : <?php echo $TPL_VAR["ship_set"]["refund_shiping_cost"]?> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

<?php if($TPL_VAR["ship_set"]["shiping_free_yn"]=='Y'){?>
							(배송비가 무료인 경우, 왕복 <?php echo ($TPL_VAR["ship_set"]["refund_shiping_cost"]* 2)?> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 받음)
<?php }?>
						</td>
					</tr>
					<tr>
						<td class="its-td center nonpd">(맞)교환</td>
						<td class="its-td left">
							<input type="hidden" name="swap_shiping_cost" value="<?php echo $TPL_VAR["ship_set"]["swap_shiping_cost"]?>" />
							왕복 : <?php echo $TPL_VAR["ship_set"]["swap_shiping_cost"]?> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

						</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</td>
		<td class="its-td center under-line controll_td" width="80px" <?php if($TPL_VAR["default_yn"]=='Y'){?>style="background-color:#FFE3BB;"<?php }?>>
			<label class="resp_radio"><input type="radio" name="default_yn" onclick="chg_base_set(this);" value="" <?php if($TPL_VAR["default_yn"]=='Y'){?>checked<?php }?> /> 기본</label>
			<br/><br/>
			<div class="pdt5">
				<button type="button" class="resp_btn v2" onclick="btn_modify_shipping_set(this);">수정</button>
			</div>
			<div class="pdt5">
				<button type="button" class="resp_btn v3" onclick="btn_delete_shipping_set(this);">삭제</button>
			</div>
		</td>
	</tr>	
	</tbody>
	</table>
</div>