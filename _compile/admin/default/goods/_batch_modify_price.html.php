<?php /* Template_ 2.2.6 2022/05/17 12:31:57 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_price.html 000025790 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.btn-direct-open').on('changeOptionLay', function(){
			var goods_seq	= $(this).attr('goods_seq');

			if ($(this).hasClass('opened') === true) {
				//열기
				reservePolicySet(goods_seq);
			} else {
				//닫기
				$('#option_' + goods_seq).find("[defalult_option='y']").each(function(){
					var targetName	= this.name.replace(/^detail_/, '');
					$('[name="' + targetName + '"]').val(this.value);
				});
			}
		});

		$('.reserve_policy').on('change', function(){
			var goods_seq	= $(this).attr('goods_seq');
			reservePolicySet(goods_seq);
		});

		$('select[name="all_reserve_policy"]').on('change', function() {
			var ctrl			= (this.value == 'shop') ? true : false;
			$(this).siblings('input[name="all_reserve_rate"], select[name="all_reserve_unit"]').attr('disabled', ctrl);
		});

		$('.commission_rate').on('blur', function(){
			if (this.value > 100) {
				this.value=0;
				alert('수수료값은 100%를 넘을 수 없습니다.');
				this.focus();
			}
		});

		$('.su_commission_rate').on('blur', function(){
			var commission_type	= $(this).siblings('.su_commission_type').val();
			if (commission_type == 'SUCO' && this.value > 100) {
				this.value=0;
				alert('공급율값은 100%를 넘을 수 없습니다.');
				this.focus();
			}
		});

		$('.su_commission_type').on('change', function(){
			var $commissionRate	= $(this).siblings('.su_commission_rate');
			if (this.value == 'SUCO' && $commissionRate.val() > 100) {
				$commissionRate.val(0)
				alert('공급율값은 100%를 넘을 수 없습니다.');
				$commissionRate.focus();
			}
		});
	});


	function reservePolicySet(goods_seq) {
		var	reserve_policy	= $('select[name="reserve_policy[' + goods_seq + ']').val();
		var ctrl			= (reserve_policy == 'shop') ? true : false;

		$('select[name="reserve_policy[' + goods_seq + ']"]').siblings('.reserve_rate, .reserve_unit').attr('disabled', ctrl);
		$('#option_' + goods_seq + '  .reserve_rate, #option_' + goods_seq + '  .reserve_unit').attr('disabled', ctrl);
	}

	/* 일괄 검증 */
	function reserve_policy_update($applyObj) {
		var goods_seq	= (typeof $applyObj.attr('goods_seq') == 'undefined') ? 'all' : $applyObj.attr('goods_seq');

		if (goods_seq == 'all') {
			var reserve_policy	= $('select[name="all_reserve_policy"]').val();
			var reserve_unit	= $('select[name="all_reserve_unit"]').val();
			var reserve_rate	= $('input[name="all_reserve_rate"]').val();
			var $reserveValue	= $('input[name="all_reserve_rate"]');
		} else {
			var reserve_policy	= $('select[name="reserve_policy[' + goods_seq + ']"]').val();
			var reserve_unit	= $('#option_' + goods_seq + ' .reserve_unit').val();
			var reserve_rate	= $('#option_' + goods_seq + ' .reserve_rate').val();
			var $reserveValue	= $('#option_' + goods_seq + ' .reserve_rate');
		}

		if (reserve_policy == 'goods' && reserve_unit == 'percent' && reserve_rate > 100)
			return '캐시는 100%을 넘을 수 없습니다.';

		if (goods_seq == 'all') {
			$("input:checkbox[name='goods_seq[]']:checked").each (function() {
				$('select[name="reserve_policy[' + this.value + ']').val(reserve_policy);
				reservePolicySet(this.value);
			});
		}

		return true;
	}

	function commission_rate_check($applyObj) {
		var goods_seq		= (typeof $applyObj.attr('goods_seq') == 'undefined') ? 'all' : $applyObj.attr('goods_seq');
		var apply_type		= $applyObj.attr('apply_type');

		switch (apply_type) {
			case	'all_su_commission' :
				var commission_type		= $('select[name="all_su_commission_type"]').val();
				var commission_rate		= $('input[name="all_su_commission_rate"]').val();
				var $commissionRate		= $('input[name="all_su_commission_rate"]');
				break;

			case	'all_commission_rate' :
				var commission_type		= 'SACO';
				var commission_rate		= $('input[name="all_commission_rate"]').val();
				var $commissionRate		= $('input[name="all_commission_rate"]');
				break;

			case	'su_commission_' + goods_seq :
				var commission_type		= $('.su_commission_' + goods_seq + '_value[apply_target="su_commission_type"]').val();
				var commission_rate		= $('.su_commission_' + goods_seq + '_value[apply_target="su_commission_rate"]').val();
				var $commissionRate		= $('.su_commission_' + goods_seq + '_value[apply_target="su_commission_rate"]');
				break;

			case	'commission_rate_' + goods_seq :
				var commission_type		= 'SACO';
				var commission_rate		= $('.commission_rate_' + goods_seq + '_value[apply_target="commission_rate"]').val();
				var $commissionRate		= $('.commission_rate_' + goods_seq + '_value[apply_target="commission_rate"]');
				break;
		}

		if ((commission_type == 'SACO' || commission_type == 'SUCO') && commission_rate > 100) {
			$commissionRate.val(0);
			$commissionRate.focus();
			var typeText		= (commission_type == 'SACO') ? '수수료' : '공급율';
			return typeText + '값은 100%를 넘을 수 없습니다.';
		}

		return true;
	}
</script>

<div class="clearbox">
	<ul class="left-btns">
		<li>
			<div class="left-btns-txt" id="search_count" class="hide">
				총 <b>0</b> 개
			</div>
		</li>
		<li class="left-btns-txt desc">※ 이용방법 : [검색하기] 버튼으로 검색 후 상품정보를 조건 업데이트 하세요!</li>
	</ul>
	<ul class="right-btns">
		<li>
			<select class="custom-select-box-multi" name="orderby">
				<option value="goods_seq" <?php if($TPL_VAR["orderby"]=='goods_seq'){?>selected<?php }?>>최근등록순</option>
				<option value="goods_name" <?php if($TPL_VAR["orderby"]=='goods_name'){?>selected<?php }?>>상품명순</option>
				<option value="page_view" <?php if($TPL_VAR["orderby"]=='page_view'){?>selected<?php }?>>페이지뷰순</option>
			</select>
		</li>
		<li>
			<select  class="custom-select-box-multi" name="perpage">
				<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
				<option id="dp_qty50" value="50" <?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?> >50개씩</option>
				<option id="dp_qty100" value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
				<option id="dp_qty200" value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
			</select>
		</li>
	</ul>
</div>

<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="28"/><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="90"/><!--입점사--><?php }?>
		<col width="63"/><!--상품이미지-->
		<col width="*"/><!--상품명-->
		<col width="70"/><!--옵션-->
		<col width="95"/><!--매입가-->
<?php if(serviceLimit('H_AD')){?>
		<col width="90"/><!--수수료율-->
		<col width="150"/><!--공급가-->
<?php }?>
		<col width="230"/><!--정가->판매가-->
		<col width="150"/><!--캐시-->
		<col width="110"/><!--옵션노출-->
	</colgroup>
	<thead class="lth">
	<tr style="background-color:#e3e3e3" height="55">
		<th></th>
<?php if(serviceLimit('H_AD')){?><th></th><?php }?>
		<th colspan="2"></th>
		<th><img class="btn_open_all hand" src="/admin/skin/default/images/common/icon/btn_open_all.gif" /></th>
		<th align="center">
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'){?>
			<input type="text" name="all_supply_price" class="all_supply_price_value onlyfloat" apply_target="supply_price" style="text-align:right; width:40px;">
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type="all_supply_price">▼</button></span>
<?php }?>
		</th>
<?php if(serviceLimit('H_AD')){?>
		<th align="center">
			<input type="text" name="all_commission_rate" class="all_commission_rate_value onlyfloat" apply_target="commission_rate" maxlength="5" style="text-align:right; width:40px;">
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type='all_commission_rate' check_function="commission_rate_check" >▼</button></span>
		</th>
		<th align="center">
			<input type="text" name="all_su_commission_rate" class="all_su_commission_value onlyfloat" apply_target="su_commission_rate" style="text-align:right; width:30px;">
			<select name="all_su_commission_type" class="all_su_commission_value line" apply_target="su_commission_type">
				<option value="SUCO">%</option>
				<option value="SUPR">KRW</option>
			</select>
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type='all_su_commission' check_function="commission_rate_check">▼</button></span>
		</th>
<?php }?>
		<th align="center">
			<input type="text" name="all_consumer_price" class="all_consumer_price_value onlyfloat" apply_target="consumer_price" style="text-align:right; width:25%;">
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type='all_consumer_price'>▼</button></span>
			→
			<input type="text" name="all_price" class="all_price_value onlyfloat" apply_target="price" size="7"  style="text-align:right; width:25%;">
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type='all_price'>▼</button></span>
		</th>
		<th class="pdl10 left" style="line-height:25px;">
			<select name="all_reserve_policy" class="reserve_policy all_reserve_policy_value onlyfloat line" apply_target="reserve_policy">
				<option value='shop'>통합정책</option>
				<option value='goods'>개별정책</option>
			</select>
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type='all_reserve_policy' check_function="reserve_policy_update">▼</button></span>
			<br>
			<input type="text" name="all_reserve_rate" class="all_reserve_policy_value" apply_target="reserve_rate"  style="text-align:right; width:45px;" value="" disabled/>
			<select name="all_reserve_unit" class="all_reserve_policy_value line" apply_target="reserve_unit" disabled>
				<option value='percent'>%</option>
				<option value='<?php echo $TPL_VAR["basic_currency"]?>'><?php echo $TPL_VAR["basic_currency"]?></option>
			</select>
		</th>
		<th>
			<select class="all_option_view_value line" apply_target="option_view">
				<option value="Y">노출</option>
				<option value="N">미노출</option>
			</select>
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type='all_option_view'>▼</button></span>
		</th>
	</tr>

	<tr>
		<th rowspan="2"><input type="checkbox" id="chkAll" /></th>
<?php if(serviceLimit('H_AD')){?><th rowspan="2">입점</th><?php }?>
		<th rowspan="2" colspan="2">상품명</th>
		<th rowspan="2">옵션</th>
		<th rowspan="2">매입가(KRW)</th>
<?php if(serviceLimit('H_AD')){?>
		<th colspan="2">정산(KRW)</th>
<?php }?>
		<th rowspan="2">정가 → 판매가</th>
		<th rowspan="2">캐시</th>
		<th rowspan="2">옵션노출</th>
	</tr>
<?php if(serviceLimit('H_AD')){?>
	<tr>
		<th style="border-top:0">수수료율</th>
		<th style="border-top:0">공급가(공급율)</th>
	<tr>
<?php }?>

	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tbody class="ltb goods_list">
		<tr class="list-row" style="height:70px;" goods_seq='<?php echo $TPL_V1["goods_seq"]?>'>
			<td class="center">
				<input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" />
				<input type="hidden" name="default_option_seq[<?php echo $TPL_V1["option_seq"]?>]" value="<?php echo $TPL_V1["goods_seq"]?>" class="default_option<?php if(count($TPL_V1["options"])> 1){?> option_use<?php }?>" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"/>
			</td>
<?php if(serviceLimit('H_AD')){?>
			<td class="<?php if($TPL_V1["provider_seq"]=='1'){?>bg-red<?php }else{?>bg-blue<?php }?> white bold center" >
<?php if($TPL_V1["provider_seq"]=='1'){?>
<?php if($TPL_V1["lastest_supplier_name"]){?>매입 - <?php echo $TPL_V1["lastest_supplier_name"]?><?php }else{?>매입<?php }?>
<?php }else{?>
				<?php echo $TPL_V1["provider_name"]?>

<?php }?>
			</td>
<?php }?>
			<td class="center">
				<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a>
			</td>
			<td class="left pdl10">
				<div>
<?php if($TPL_V1["tax"]=='exempt'){?><span style="color:red;" class="left" >[비과세]</span><?php }?>
<?php if($TPL_V1["cancel_type"]=='1'){?><span class="order-item-cancel-type left" >[청약철회불가]</span><?php }?>
				</div>
<?php if($TPL_V1["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
				<a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut($TPL_V1["goods_name"], 80)?></a>
				<div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
			</td>
			<td class="center">
<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn-direct-open" goods_seq='<?php echo $TPL_V1["goods_seq"]?>'><span class="hide">열기</span></span><?php }?>
			</td>
			<td class="pdl5 left">
<?php if($TPL_V1["provider_seq"]=='1'&&$TPL_VAR["scm_cfg"]['use']!='Y'){?>
				<input type="text" name="supply_price[<?php echo $TPL_V1["option_seq"]?>]" value="<?php echo $TPL_V1["supply_price"]?>" style="text-align:right;width:40px;" class="supply_price supply_price_<?php echo $TPL_V1["goods_seq"]?>_value onlyfloat" apply_target="supply_price"/>
<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn" goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='supply_price_<?php echo $TPL_V1["goods_seq"]?>'>▼</button></span><?php }?>
<?php }?>
			</td class="pdl5 left">
<?php if(serviceLimit('H_AD')){?>
			<td class="pdl5 left">
<?php if($TPL_V1["options"][ 0]["commission_type"]=='SACO'&&$TPL_V1["provider_seq"]> 1){?>
				<input type="text" name="commission_rate[<?php echo $TPL_V1["option_seq"]?>]" size="5" value="<?php echo $TPL_V1["commission_rate"]?>" option_seq='<?php echo $TPL_V1["goods_seq"]?>_<?php echo $TPL_V1["option_seq"]?>' class="commission_rate commission_rate_<?php echo $TPL_V1["goods_seq"]?>_value onlyfloat" apply_target="commission_rate" style="text-align:right;width:40px;" />
<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn"  goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='commission_rate_<?php echo $TPL_V1["goods_seq"]?>' check_function="commission_rate_check">▼</button></span><?php }?>
<?php }?>
			</td>
			<td class="pdl5 left">
<?php if($TPL_V1["options"][ 0]["commission_type"]!='SACO'&&$TPL_V1["provider_seq"]> 1){?>
				<input type="text" name="commission_rate[<?php echo $TPL_V1["option_seq"]?>]" value="<?php echo $TPL_V1["options"][ 0]["commission_rate"]?>" class="su_commission_rate su_commission_<?php echo $TPL_V1["goods_seq"]?>_value onlyfloat" apply_target="su_commission_rate" style="text-align:right;width:35px;"/>
				<select name="commission_type[<?php echo $TPL_V1["option_seq"]?>]"  class="commission_type_sel su_commission_type su_commission_<?php echo $TPL_V1["goods_seq"]?>_value line" apply_target="su_commission_type">
					<option value="SUCO" <?php if($TPL_V1["options"][ 0]["commission_type"]!='SUPR'){?>selected<?php }?>>%</option>
					<option value="SUPR" <?php if($TPL_V1["options"][ 0]["commission_type"]=='SUPR'){?>selected<?php }?>><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
				</select>
<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn" goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='su_commission_<?php echo $TPL_V1["goods_seq"]?>' check_function="commission_rate_check">▼</button></span><?php }?>
<?php }?>
			</td>
<?php }?>
			<td class="pdl10 left">
				<input type="text" name="consumer_price[<?php echo $TPL_V1["option_seq"]?>]" value="<?php echo $TPL_V1["consumer_price"]?>" class="consumer_price consumer_price<?php echo $TPL_V1["goods_seq"]?>_value onlyfloat" apply_target="consumer_price" style="text-align:right;width:25%;"/>
<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn" goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='consumer_price<?php echo $TPL_V1["goods_seq"]?>'>▼</button></span><?php }?>
				→
				<input type="text" name="price[<?php echo $TPL_V1["option_seq"]?>]" value="<?php echo $TPL_V1["price"]?>" class="price price_<?php echo $TPL_V1["goods_seq"]?>_value onlyfloat" apply_target="price" style="text-align:right;width:25%;"/>
<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn" goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='price_<?php echo $TPL_V1["goods_seq"]?>'>▼</button></span><?php }?>
			</td>
			<td class="left pdl10">
				<span style="line-height:30px;">
					<select name="reserve_policy[<?php echo $TPL_V1["goods_seq"]?>]" goods_seq="<?php echo $TPL_V1["goods_seq"]?>" class="reserve_policy line" style="width:101px;">
						<option value='shop' <?php if($TPL_V1["reserve_policy"]!='goods'){?>selected<?php }?>>통합정책</option>
						<option value='goods' <?php if($TPL_V1["reserve_policy"]=='goods'){?>selected<?php }?>>개별정책</option>
					</select>
					<br>
					<input type="text" name="reserve_rate[<?php echo $TPL_V1["option_seq"]?>]" value="<?php echo $TPL_V1["reserve_rate"]?>" class="reserve_rate reserve_policy_<?php echo $TPL_V1["goods_seq"]?>_value onlyfloat" apply_target="reserve_rate" style="text-align:right;width:30px;" <?php if($TPL_V1["reserve_policy"]!='goods'){?>disabled<?php }?>/>
					<select name="reserve_unit[<?php echo $TPL_V1["option_seq"]?>]" class="reserve_unit reserve_policy_<?php echo $TPL_V1["goods_seq"]?>_value line" apply_target="reserve_unit" <?php if($TPL_V1["reserve_policy"]!='goods'){?>disabled<?php }?>>
						<option value='percent' <?php if($TPL_V1["reserve_unit"]=='percent'){?>selected<?php }?>>%</option>
						<option value='<?php echo $TPL_VAR["config_system"]['basic_currency']?>' <?php if($TPL_V1["reserve_unit"]!='percent'){?>selected<?php }?>><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
					</select>
<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn" goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='reserve_policy_<?php echo $TPL_V1["goods_seq"]?>' check_function="reserve_policy_update">▼</button></span><?php }?>
				</span>
			</td>
			<td class="center">
<?php if($TPL_V1["options"][ 0]["option_title"]){?>
				<div class="openAddOptionSet hide" goods_seq='<?php echo $TPL_V1["goods_seq"]?>'>
					<select name="option_view[<?php echo $TPL_V1["option_seq"]?>]"  class="option_view option_view_<?php echo $TPL_V1["goods_seq"]?>_value line" apply_target="option_view">
						<option value="Y" selected>노출</option>
						<option value="N">미노출</option>
					</select>
					<span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn" goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='option_view_<?php echo $TPL_V1["goods_seq"]?>'>▼</button></span>
				</div>
				<div class="closeAddOptionSet" goods_seq='<?php echo $TPL_V1["goods_seq"]?>'>노출</div>
<?php }else{?>
				노출
<?php }?>
			</td>
		</tr>
	</tbody>
<?php if($TPL_V1["options"][ 0]["option_title"]){?>
	<tbody id='option_<?php echo $TPL_V1["goods_seq"]?>' class="optionLay bg-dot-linem hide">
<?php if(is_array($TPL_R2=$TPL_V1["options"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
		<tr height=30 goods_seq='<?php echo $TPL_V1["goods_seq"]?>'>
			<td <?php if(serviceLimit('H_AD')){?>colspan="2"<?php }?>>
				<input type="hidden" name="option_seq[<?php echo $TPL_V2["option_seq"]?>]" value="<?php echo $TPL_V1["goods_seq"]?>" disabled/>
			</td>
			<td class="right"><?php if($TPL_V2["default_option"]=='y'){?>[기준]<?php }?></td>
			<td class="pdl10" colspan="2">
				<span class="detail_default_option_select hand">
<?php if($TPL_V2["option_divide_title"][ 0]){?><?php echo $TPL_V2["option_divide_title"][ 0]?> : <?php echo $TPL_V2["option1"]?><?php }?>
<?php if($TPL_V2["option_divide_title"][ 1]){?>&nbsp;<?php echo $TPL_V2["option_divide_title"][ 1]?> : <?php echo $TPL_V2["option2"]?><?php }?>
<?php if($TPL_V2["option_divide_title"][ 2]){?>&nbsp;<?php echo $TPL_V2["option_divide_title"][ 2]?> : <?php echo $TPL_V2["option3"]?><?php }?>
<?php if($TPL_V2["option_divide_title"][ 3]){?>&nbsp;<?php echo $TPL_V2["option_divide_title"][ 3]?> : <?php echo $TPL_V2["option4"]?><?php }?>
<?php if($TPL_V2["option_divide_title"][ 4]){?>&nbsp;<?php echo $TPL_V2["option_divide_title"][ 4]?> : <?php echo $TPL_V2["option5"]?><?php }?>
				</span>
			</td>
			<td class="pdl5 left">
<?php if($TPL_V1["provider_seq"]=='1'&&$TPL_VAR["scm_cfg"]['use']!='Y'){?>
					<input type="text" name="detail_supply_price[<?php echo $TPL_V2["option_seq"]?>]" value="<?php echo $TPL_V2["supply_price"]?>" class="supply_price" defalult_option="<?php echo $TPL_V2["default_option"]?>" style="text-align:right;width:40px;" disabled/>
<?php }?>
			</td>
<?php if(serviceLimit('H_AD')){?>
			<td class="pdl5 left">
<?php if($TPL_V2["commission_type"]=='SACO'&&$TPL_V1["provider_seq"]> 1){?>
				<input type="text" name="detail_commission_rate[<?php echo $TPL_V2["option_seq"]?>]" size="5" value="<?php echo $TPL_V2["commission_rate"]?>" class="commission_rate onlyfloat" defalult_option="<?php echo $TPL_V2["default_option"]?>" maxlength="5" style="text-align:right;width:40px;" disabled/>
<?php }?>
			</td>
			<td class="pdl5 left">
<?php if($TPL_V2["commission_type"]!='SACO'&&$TPL_V1["provider_seq"]> 1){?>
				<input type="text" name="detail_commission_rate[<?php echo $TPL_V2["option_seq"]?>]" size="5" value="<?php echo $TPL_V2["commission_rate"]?>" class="su_commission_rate onlyfloat" defalult_option="<?php echo $TPL_V2["default_option"]?>" style="text-align:right;width:35px;" disabled/>
				<select name="detail_commission_type[<?php echo $TPL_V2["option_seq"]?>]" class="commission_type_sel su_commission_type line" defalult_option="<?php echo $TPL_V2["default_option"]?>" disabled>
					<option value="SUCO" <?php if($TPL_V2["commission_type"]!='SUPR'){?>selected<?php }?>>%</option>
					<option value="SUPR" <?php if($TPL_V2["commission_type"]=='SUPR'){?>selected<?php }?>><?php echo $TPL_VAR["basic_currency"]?></option>
				</select>
<?php }?>
			</td>
<?php }?>
			<td class="pdl10 left">
				<input type="text" name="detail_consumer_price[<?php echo $TPL_V2["option_seq"]?>]" value="<?php echo $TPL_V2["consumer_price"]?>" class="consumer_price onlyfloat" defalult_option="<?php echo $TPL_V2["default_option"]?>" style="text-align:right;width:30%;" disabled/>
				→
				<input type="text" name="detail_price[<?php echo $TPL_V2["option_seq"]?>]" value="<?php echo $TPL_V2["price"]?>" class="price onlyfloat" defalult_option="<?php echo $TPL_V2["default_option"]?>" style="text-align:right;width:30%;" disabled/>
			</td>
			<td class="pdl10 left">
				<input type="text" name="detail_reserve_rate[<?php echo $TPL_V2["option_seq"]?>]" value="<?php echo $TPL_V2["reserve_rate"]?>" class="reserve_rate onlyfloat" defalult_option="<?php echo $TPL_V2["default_option"]?>" style="text-align:right;width:30px;" disabled/>
				<select name="detail_reserve_unit[<?php echo $TPL_V2["option_seq"]?>]" class="reserve_unit line" defalult_option="<?php echo $TPL_V2["default_option"]?>" disabled>
					<option value='percent' <?php if($TPL_V1["reserve_unit"]=='percent'){?>selected<?php }?>>%</option>
					<option value='<?php echo $TPL_VAR["config_system"]['basic_currency']?>' <?php if($TPL_V1["reserve_unit"]!='percent'){?>selected<?php }?>><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
				</select>
			</td>
			<td class="center">
<?php if($TPL_V2["default_option"]=='y'){?>
				노출
<?php }else{?>
				<select name="detail_option_view[<?php echo $TPL_V2["option_seq"]?>]" defalult_option="<?php echo $TPL_V2["default_option"]?>" class="option_view line">
					<option value="Y" <?php if($TPL_V2["option_view"]!='N'){?>selected<?php }?>>노출</option>
					<option value="N" <?php if($TPL_V2["option_view"]=='N'){?>selected<?php }?>>미노출</option>
				</select>
<?php }?>
			</td>
		</tr>
<?php }}?>
		<tr><td <?php if(serviceLimit('H_AD')){?>colspan="4"<?php }?> height="15"></td><td colspan="7"></td></tr>
	</tbody>
<?php }?>
<?php }}else{?>
	<tbody class="ltb goods_list">
		<tr class="list-row">
			<td align="center" colspan="11">
<?php if($TPL_VAR["search_text"]){?>'<?php echo $TPL_VAR["search_text"]?>' 검색된 상품이 없습니다.<?php }else{?>등록된 상품이 없습니다.<?php }?>
			</td>
		</tr>
	</tbody>
<?php }?>
</table>
<!-- 주문리스트 테이블 : 끝 -->

<script type="text/javascript">
<?php if($TPL_VAR["config_system"]["goods_count"]< 10000){?>
$.ajax({
	type: "get",
	url: "./count",
	data: "param=<?php echo $TPL_VAR["param_count"]?>",
	dataType : "json",
	success: function(obj){
		$("div#search_count").removeClass("hide");
		$("div#search_count b").html(comma(obj.cnt));
		var first	= obj.cnt - <?php echo ($_GET["perpage"]*($_GET["page"]- 1))?>;
		$(".page_no").each(function(idx){
			$(this).html(first-idx);
		});
	}
});
<?php }?>
</script>