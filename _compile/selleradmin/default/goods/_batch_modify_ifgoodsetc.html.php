<?php /* Template_ 2.2.6 2022/05/17 12:29:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_batch_modify_ifgoodsetc.html 000010315 */ 
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
		<col width="7%" /><!--아래와 같이 업데이트-->
		<col width="*" /><!--아래와 같이 업데이트-->
	</colgroup>
	<thead class="lth">
		<tr>
			<th>대상 상품</th>
			<th colspan="2">아래와 같이 업데이트 <span class="desc">(<span class="red">★</span> 상품코드, 무게, 재고 등 옵션이 있는 항목은 모든 옵션에 일괄 업데이트 됩니다.)</span></th>
		</tr>
	</thead>

	<tbody class="ltb">
		<tr class="list-row">
			<td align="center" rowspan="5">
				검색된 상품에서  →
				<select name="modify_list"  class="modify_list">
					<option value="choice">선택 </option>
					<option value="all">전체 </option>
				</select>
			</td>

			<td colspan="2">
				<label><input type="checkbox" name="batch_goodscode_yn" value="1" /> 상품 기본코드를 자동 생성합니다.</label>
			</td>
		</tr>
		<tr class="list-row">
			<td>
				<label><input type="checkbox" name="batch_weight_yn" value="1" /> 무게를</label>
			</td>
			<td>
				<input type="text" name="batch_weight_value" class="onlyfloat" style="text-align:right; width:50px;"> (kg) 변경합니다.
			</td>
		</tr>
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'){?>
		<tr class="list-row">
			<td>
				<label><input type="checkbox" name="batch_stock_yn" value="1" /> 재고를</label>
			</td>
			<td>
				<input type="text" name="batch_stock_value" class="onlyfloat" style="text-align:right; width:50px;"> 변경합니다.
			</td>
		</tr>
		<tr class="list-row">
			<td colspan="2">
				<label><input type="checkbox" name="batch_badstock_yn" value="1" /> 불량재고를 초기화 (0)로 변경합니다.</label>
			</td>
		</tr>
<?php }?>
		<tr class="list-row">
			<td>
				<label><input type="checkbox" name="batch_safe_stock_yn" value="1" /> 안전재고를</label>
			</td>
			<td>
				<input type="text" name="batch_safe_stock_value" class="onlyfloat" style="text-align:right; width:50px;"> 변경합니다.
			</td>
		</tr>
	</tbody>
</table>


<br class="table-gap" />

<ul class="left-btns clearbox">
	<li><span class="desc">이용방법 : [검색하기]버튼으로 검색 후 상품정보를 업데이트 하세요.</span></li>
</ul>

<div class="fr">
	<div class="clearbox">
		<ul class="right-btns clearbox">
		<li><select class="custom-select-box-multi" name="orderby">
			<option value="goods_seq" <?php if($TPL_VAR["orderby"]=='goods_seq'){?>selected<?php }?>>최근등록순</option>
			<option value="goods_name" <?php if($TPL_VAR["orderby"]=='goods_name'){?>selected<?php }?>>상품명순</option>
			<option value="page_view" <?php if($TPL_VAR["orderby"]=='page_view'){?>selected<?php }?>>페이지뷰순</option>
		</select></li>
		<li><select  class="custom-select-box-multi" name="perpage">
			<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
			<option id="dp_qty50" value="50" <?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?> >50개씩</option>
			<option id="dp_qty100" value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
			<option id="dp_qty200" value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
		</select></li>
	</ul>
	</div>
</div>
<br style="line-height:2px;" />

<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="30" /><!--체크-->
		<col width="100" /><!--입점사-->
		<col width="63" /><!--상품이미지-->
		<col /><!--상품명-->
		<col width="70" /><!--옵션-->
		<col width="150" /><!--상품기본코드-->
		<col width="100" /><!--무게-->

		<col width="100" /><!--재고-->
		<col width="100" /><!--불량-->

		<col width="100" /><!--안전재고-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
		<th>입점</th>
		<th colspan="2">상품명</th>
		<th>옵션</th>
		<th>상품기본코드</th>
		<th>무게(kg)</th>

		<th>재고</th>
		<th>불량</th>

		<th>안전재고</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<!-- 상품정보 : 시작 -->
		<tbody class="ltb goods_list">
			<tr class="list-row" style="height:70px;" goods_seq="<?php echo $TPL_V1["goods_seq"]?>">
				<td class="center">
					<input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" />
					<input type="hidden" name="default_option_seq[<?php echo $TPL_V1["option_seq"]?>]" value="<?php echo $TPL_V1["goods_seq"]?>" class="default_option<?php if(count($TPL_V1["options"])> 1){?> option_use<?php }?>" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"/>
				</td>
				<td class="center white bold <?php if($TPL_V1["provider_seq"]=='1'){?>bg-blue<?php }else{?>bg-red<?php }?>">
<?php if($TPL_V1["provider_seq"]=='1'){?>
<?php if($TPL_V1["lastest_supplier_name"]){?>매입 - <?php echo $TPL_V1["lastest_supplier_name"]?><?php }else{?>매입<?php }?>
<?php }else{?>
					<?php echo $TPL_V1["provider_name"]?>

<?php }?>
				</td>
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
				<td class="center"><!--// 코드 //-->
					<?php echo $TPL_V1["goods_code"]?>

				</td>
				<td class="pdr10 right"><!--// 무게 //-->
					<?php echo $TPL_V1["options"][ 0]["weight"]?> Kg
				</td>
				<td class="pdr10 right"><!--// 재고 //-->
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'){?>
					<?php echo $TPL_V1["default_stock"]?>

<?php }?>
				</td>
				<td class="pdr10 right"><!--// 불량 //-->
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'){?>
					<?php echo $TPL_V1["default_badstock"]?>

<?php }?>
				</td>
				<td class="pdr10 right"><!--// 안전재고 //-->
					<?php echo $TPL_V1["default_safe_stock"]?>

				</td>
			</tr>
		</tbody>
		<!-- 상품정보 : 끝 -->

		<!-- 옵션정보 : 시작 -->
<?php if($TPL_V1["options"][ 0]["option_title"]){?>
		<tbody id='option_<?php echo $TPL_V1["goods_seq"]?>' class="optionLay bg-dot-linem hide">
<?php if(is_array($TPL_R2=$TPL_V1["options"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<tr height="30" goods_seq="<?php echo $TPL_V1["goods_seq"]?>">
				<td <?php if(serviceLimit('H_AD')){?>colspan="2"<?php }?>>
					<input type="hidden" name="option_seq[<?php echo $TPL_V2["option_seq"]?>]" value="<?php echo $TPL_V1["goods_seq"]?>" disabled/>
				</td>
				<td class="right"><?php if($TPL_V2["default_option"]=='y'){?>[대표]<?php }?></td>
				<td class="pdl10" colspan="2">
					<span class="detail_default_option_select hand">
<?php if($TPL_V2["option_divide_title"][ 0]){?><?php echo $TPL_V2["option_divide_title"][ 0]?> : <?php echo $TPL_V2["option1"]?><?php }?>
<?php if($TPL_V2["option_divide_title"][ 1]){?>&nbsp;<?php echo $TPL_V2["option_divide_title"][ 1]?> : <?php echo $TPL_V2["option2"]?><?php }?>
<?php if($TPL_V2["option_divide_title"][ 2]){?>&nbsp;<?php echo $TPL_V2["option_divide_title"][ 2]?> : <?php echo $TPL_V2["option3"]?><?php }?>
<?php if($TPL_V2["option_divide_title"][ 3]){?>&nbsp;<?php echo $TPL_V2["option_divide_title"][ 3]?> : <?php echo $TPL_V2["option4"]?><?php }?>
<?php if($TPL_V2["option_divide_title"][ 4]){?>&nbsp;<?php echo $TPL_V2["option_divide_title"][ 4]?> : <?php echo $TPL_V2["option5"]?><?php }?>
					</span>
				</td>
				<td class="pdr10 right"><!--// 상품 기본코드 영역 //--></td>
				<td class="pdr10 right"><!--// 무게 //-->
					<?php echo $TPL_V2["weight"]?> kg
				</td>
				<td class="pdr10 right"><!--// 재고 //-->
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'){?>
					<?php echo $TPL_V2["stock"]?>

<?php }?>
				</td>
				<td class="pdr10 right"><!--// 불량 //-->
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'){?>
					<?php echo $TPL_V2["badstock"]?>

<?php }?>
				</td>
				<td class="pdr10 right"><!--// 안전재고 //-->
					<?php echo $TPL_V2["safe_stock"]?>

				</td>
			</tr>
<?php }}?>
		</tbody>
		<!-- 옵션정보 : 끝 -->
<?php }?>
<?php }}?>
<?php }else{?>
	<tbody class="ltb goods_list">
		<tr class="list-row">
			<td align="center" colspan="<?php if($TPL_VAR["scm_cfg"]['use']!='Y'){?>9<?php }else{?>7<?php }?>">
<?php if($TPL_VAR["search_text"]){?>
					'<?php echo $TPL_VAR["search_text"]?>' 검색된 상품이 없습니다.
<?php }else{?>
					등록된 상품이 없습니다.
<?php }?>
			</td>
		</tr>
	</tbody>
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->

</table>
<!-- 주문리스트 테이블 : 끝 -->