<?php /* Template_ 2.2.6 2022/05/17 12:31:57 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_ifprice.html 000016541 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
	$(document).ready(function(){
		$('select[name="batch_reserve_policy"]').on('change', function(){
			if (this.value == 'shop')
				$('.batch_reserve').attr('disabled', true);
			else
				$('.batch_reserve').attr('disabled', false);

		});
	});
</script>

<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="20%" /><!--대상 상품-->
		<col width="11%" /><!--아래와 같이 업데이트-->
		<col width="23%" /><!--아래와 같이 업데이트-->
		<col width="*" /><!--아래와 같이 업데이트-->
	</colgroup>
	<thead class="lth">
		<tr>
			<th>대상 상품</th>
			<th colspan="3">아래와 같이 업데이트 <span class="desc">(<span class="red">★</span> <?php if(serviceLimit('H_AD')){?>공급가, 수수료율,<?php }?> 매입가, 할인가, 정가, 재고, 캐시는 옵션이 있는 상품의 경우 모든 옵션에 일괄 업데이트 됩니다.)</span></th>
		</tr>
	</thead>

	<tbody class="ltb">
		<tr class="list-row">
			<td align="center" rowspan="7">
				검색된 상품에서  →
				<select name="modify_list"  class="modify_list">
					<option value="choice">선택 </option>
					<option value="all">전체 </option>
				</select>
			</td>
			<td><label><input type="checkbox" class="batch_update_item" name="batch_consumer_price_yn" value="1" /> <span class="red">★</span> 정가를</label></td>
			<td>
				<input type="text" name="batch_consumer_price" value="" class="onlyfloat" style="text-align:right; width:50px;"  class="onlyfloat"/>
				<select name="batch_consumer_price_unit" class="line">
					<option value="percent">%</option>
					<option value="won"><?php echo $TPL_VAR["basic_currency"]?></option>
				</select>
				만큼
				<select name="batch_consumer_price_updown" class="line">
					<option value="up">+ 조정</option>
					<option value="down">- 조정</option>
				</select>
				합니다.
			</td>
			<td>조정된 가격은 설정 > 멀티/글로벌의 가격 절사정책에 따릅니다.</td>
		</tr>
		<tr class="list-row">
			<td><label><input type="checkbox" class="batch_update_item" name="batch_price_yn" value="1" /> <span class="red">★</span> 판매가를</label></td>
			<td>
				<input type="text" name="batch_price" size="10" value="" class="onlyfloat" style="text-align:right; width:50px;"/>
				<select name="batch_price_unit" class="line">
					<option value="percent">%</option>
					<option value="won"><?php echo $TPL_VAR["basic_currency"]?></option>
				</select>
				만큼
				<select name="batch_price_updown" class="line">
					<option value="up">+ 조정</option>
					<option value="down">- 조정</option>
				</select>
				합니다.
			</td>
			<td>조정된 가격은 설정 > 멀티/글로벌의 가격 절사정책에 따릅니다.</td>
		</tr>
<?php if(serviceLimit('H_AD')){?>
		<tr class="list-row">
			<td><label><input type="checkbox" class="batch_update_item" name="batch_su_commission_yn" value="1" /> <span class="red">★</span> 공급가(공급율)를</label></td>
			<td>
				<input type="text" name="batch_su_commission_rate" class="onlyfloat" style="text-align:right; width:50px;">
				<select name="batch_su_commission_type" class="line" >
					<option value="SUCO">%</option>
					<option value="SUPR">KRW</option>
				</select>
				으로 합니다.
			</td>
			<td>(공급가 방식의 입점사 상품 적용)</td>
		</tr>
		<tr class="list-row">
			<td><label><input type="checkbox" class="batch_update_item" name="batch_commission_rate_yn" value="1" /> <span class="red">★</span> 수수료율을</label></td>
			<td>
				<input type="text" name="batch_commission_rate" class="onlyfloat" style="text-align:right; width:50px;">
				% 으로 합니다.
			</td>
			<td>(수수료 방식의 입점사 상품 적용)</td>
		</tr>
<?php }?>
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'){?>
		<tr class="list-row">
			<td><label><input type="checkbox" class="batch_update_item" name="batch_supply_price_yn" value="1" /> <span class="red">★</span> 매입가를</label></td>
			<td>
				<input type="text" name="batch_supply_price" class="onlyfloat" style="text-align:right; width:50px;">
				<select name="batch_supply_price_unit" class="line">
					<option value="percent">%</option>
					<option value="won"><?php echo $TPL_VAR["basic_currency"]?></option>
				</select>
				만큼
				<select name="batch_supply_price_updown" class="line">
					<option value="up">+ 조정</option>
					<option value="down">- 조정</option>
				</select>
				합니다.
			</td>
			<td>
				<label>조정된 가격을</label>
				<select name="batch_supply_price_cutting_price" class="line">
					<option value="0.001">소수점셋째자리</option>
					<option value="0.01">소수점둘째자리</option>
					<option value="0.1">소수점첫째자리</option>
					<option value="1">일원단위</option>
					<option value="10">십원단위</option>
					<option value="100">백원단위</option>
				</select>자리에서
				<select name="batch_supply_price_cutting_action" class="line">
					<option value="rounding">반올림</option>
					<option value="ascending">올림</option>
					<option value="dscending">내림</option>
				</select>
				(본사 상품 적용)
			</td>
		</tr>
<?php }?>
		<tr class="list-row">
			<td><label><input type="checkbox" class="batch_update_item" name="batch_reserve_yn" value="1" /> <span class="red">★</span> 캐시를</label></td>
			<td colspan="2">
				<select name="batch_reserve_policy" class="line">
					<option value="shop">통합정책</option>
					<option value="goods">개별정책</option>
				</select>
				<input type="text" name="batch_reserve" value="" class="batch_reserve onlyfloat" style="text-align:right; width:50px;" disabled/>
				<select name="batch_reserve_unit" class="batch_reserve line" disabled>
					<option value="percent">%</option>
					<option value="won"><?php echo $TPL_VAR["basic_currency"]?></option>
				</select>
				(으)로 합니다.
			</td>
		</tr>
		<tr class="list-row">
			<td><label><input type="checkbox" class="batch_update_item" name="batch_option_view_yn" value="1" /> <span class="red">★</span> 옵션노출을</label></td>
			<td colspan="2">
				<select name="batch_option_view" class="line">
					<option value="Y">노출</option>
					<option value="N">미노출</option>
				</select>
				(으)로 합니다.
			</td>
		</tr>
	</tbody>
</table>

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
		<col width="95"/><!--수수료율-->
		<col width="95"/><!--공급가-->
<?php }?>
		<col width="180"/><!--정가->판매가-->
		<col width="95"/><!--캐시-->
		<col width="95"/><!--옵션노출-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th rowspan="<?php echo $TPL_VAR["rowspan"]?>"><input type="checkbox" id="chkAll" /></th>
<?php if(serviceLimit('H_AD')){?><th rowspan="2">입점</th><?php }?>
		<th rowspan="<?php echo $TPL_VAR["rowspan"]?>" colspan="2">상품명</th>
		<th rowspan="<?php echo $TPL_VAR["rowspan"]?>">옵션</th>
		<th rowspan="<?php echo $TPL_VAR["rowspan"]?>">매입가(KRW)</th>
<?php if(serviceLimit('H_AD')){?>
		<th colspan="<?php echo $TPL_VAR["rowspan"]?>">정산(KRW)</th>
<?php }?>
		<th rowspan="<?php echo $TPL_VAR["rowspan"]?>">정가 → 판매가</th>
		<th rowspan="<?php echo $TPL_VAR["rowspan"]?>">캐시</th>
		<th rowspan="<?php echo $TPL_VAR["rowspan"]?>">옵션노출</th>
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
			<td class="pdr10 right">
<?php if($TPL_V1["provider_seq"]=='1'&&$TPL_VAR["scm_cfg"]['use']!='Y'){?><?php echo $TPL_V1["supply_price"]?> KRW<?php }?>
			</td>
<?php if(serviceLimit('H_AD')){?>
			<td class="pdr10 right">
<?php if($TPL_V1["options"][ 0]["commission_type"]=='SACO'&&$TPL_V1["provider_seq"]> 1){?><?php echo $TPL_V1["options"][ 0]["commission_rate"]?> %<?php }?>
			</td>
			<td class="pdr10 right">
<?php if($TPL_V1["options"][ 0]["commission_type"]!='SACO'&&$TPL_V1["provider_seq"]> 1){?>
				<?php echo $TPL_V1["options"][ 0]["commission_rate"]?><?php if($TPL_V1["options"][ 0]["commission_type"]!='SUPR'){?>%<?php }else{?> <?php echo $TPL_VAR["config_system"]['basic_currency']?><?php }?>
<?php }?>
			</td>
<?php }?>
			<td class="pdr10 right">
				<?php echo $TPL_V1["consumer_price"]?> <?php echo $TPL_VAR["config_system"]['basic_currency']?>

				→
				<?php echo $TPL_V1["price"]?> <?php echo $TPL_VAR["config_system"]['basic_currency']?>

			</td>
			<td class="center">
<?php if($TPL_V1["reserve_policy"]!='goods'){?>
				통합정책
<?php }else{?>
				개별정책<br/>
				<?php echo number_format($TPL_V1["reserve_rate"])?>

<?php if($TPL_V1["reserve_unit"]=='percent'){?>%<?php }else{?><?php echo $TPL_VAR["config_system"]['basic_currency']?><?php }?>
<?php }?>
			</td>
			<td class="center">
				노출
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
			<td class="pdr10 right">
<?php if($TPL_V1["provider_seq"]=='1'&&$TPL_VAR["scm_cfg"]['use']!='Y'){?><?php echo number_format($TPL_V2["supply_price"])?> KRW<?php }?>
			</td>
<?php if(serviceLimit('H_AD')){?>
			<td class="pdr10 right">
<?php if($TPL_V2["commission_type"]=='SACO'&&$TPL_V1["provider_seq"]> 1){?><?php echo $TPL_V2["commission_rate"]?> %<?php }?>
			</td>
			<td class="pdr10 right">
<?php if($TPL_V2["commission_type"]!='SACO'&&$TPL_V1["provider_seq"]> 1){?>
<?php if($TPL_V2["commission_type"]!='SUPR'){?><?php echo $TPL_V2["commission_rate"]?>%<?php }else{?><?php echo number_format($TPL_V2["commission_rate"])?> <?php echo $TPL_VAR["config_system"]['basic_currency']?><?php }?>
<?php }?>
			</td>
<?php }?>
			<td class="pdr10 right">
				<?php echo number_format($TPL_V2["consumer_price"])?> <?php echo $TPL_VAR["config_system"]['basic_currency']?>

				→
				<?php echo number_format($TPL_V2["price"])?> <?php echo $TPL_VAR["config_system"]['basic_currency']?>

			</td>
			<td class="center">
<?php if($TPL_V1["reserve_policy"]!='goods'){?>
				통합정책
<?php }else{?>
				<?php echo number_format($TPL_V2["reserve_rate"])?>

<?php if($TPL_V2["reserve_unit"]=='percent'){?>%<?php }else{?><?php echo $TPL_VAR["config_system"]['basic_currency']?><?php }?>
<?php }?>
			</td>
			<td class="center">
<?php if($TPL_V2["option_view"]=='Y'){?>노출<?php }else{?>미노출<?php }?>
			</td>
		</tr>
<?php }}?>
		<tr><td  <?php if(serviceLimit('H_AD')){?>colspan="2"<?php }?> height="15"></td><td colspan="<?php if(serviceLimit('H_AD')){?>9<?php }else{?>7<?php }?>"></td></tr>
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