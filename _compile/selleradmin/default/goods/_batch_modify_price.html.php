<?php /* Template_ 2.2.6 2022/05/17 12:29:16 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_batch_modify_price.html 000013569 */ 
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
});


function reservePolicySet(goods_seq) {
	var	reserve_policy	= $('select[name="reserve_policy[' + goods_seq + ']').val();
	var ctrl			= (reserve_policy == 'shop') ? true : false;

	$('select[name="reserve_policy[' + goods_seq + ']"]').siblings('.reserve_rate, .reserve_unit').attr('disabled', ctrl);
	$('#option_' + goods_seq + '  .reserve_rate, #option_' + goods_seq + '  .reserve_unit').attr('disabled', ctrl);
}


</script>
<br class="table-gap" />

<ul class="left-btns clearbox">
	<li>
		<div style="margin-top:rpx;" id="search_count" class="hide">
			총 <b>0</b> 개
		</div>
	</li>
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

<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="28"/><!--체크-->
		<col width="90"/><!--입점사-->
		<col width="63"/><!--상품이미지-->
		<col width="*"/><!--상품명-->
		<col width="70"/><!--옵션-->
		<col width="100"/><!--수수료율-->
		<col width="100"/><!--공급가-->
		<col width="230"/><!--정가->판매가-->
		<col width="100"/><!--적립금-->
		<col width="100"/><!--옵션노출-->
	</colgroup>
	<thead class="lth">
	<tr style="background-color:#e3e3e3" height="55">
		<th></th>
		<th></th>
		<th colspan="2"></th>
		<th><img class="btn_open_all hand" src="/admin/skin/default/images/common/icon/btn_open_all.gif" /></th>
		<th colspan="2" align="center"></th>
		<th align="center">
			<input type="text" name="all_consumer_price" class="all_consumer_price_value onlyfloat" apply_target="consumer_price" style="text-align:right; width:25%;">
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type='all_consumer_price'>▼</button></span>
			→
			<input type="text" name="all_price" class="all_price_value onlyfloat" apply_target="price" size="7"  style="text-align:right; width:25%;">
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type='all_price'>▼</button></span>
		</th>
		<th class="pdl10 left" style="line-height:25px;"></th>
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
		<th rowspan="2">입점</th>
		<th rowspan="2" colspan="2">상품명</th>
		<th rowspan="2">옵션</th>
		<th colspan="2">정산(KRW)</th>
		<th rowspan="2">정가 → 판매가</th>
		<th rowspan="2">적립금</th>
		<th rowspan="2">옵션노출</th>
	</tr>
	<tr>
		<th style="border-top:0">수수료율</th>
		<th style="border-top:0">공급가(공급율)</th>
	<tr>

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
			<td class="bg-blue white bold center"><?php echo $TPL_V1["provider_name"]?></td>
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
			<td class="pdr10 right"><?php if($TPL_V1["options"][ 0]["commission_type"]=='SACO'&&$TPL_V1["provider_seq"]> 1){?><?php echo $TPL_V1["options"][ 0]["commission_rate"]?> %<?php }?></td>
			<td class="pdr10 right">
<?php if($TPL_V1["options"][ 0]["commission_type"]=='SUCO'){?>
				<?php echo $TPL_V1["options"][ 0]["commission_rate"]?> %
<?php }elseif($TPL_V1["options"][ 0]["commission_type"]=='SUPR'){?>
				<?php echo $TPL_V1["options"][ 0]["commission_rate"]?> <?php echo $TPL_VAR["config_system"]['basic_currency']?>

<?php }?>
			</td>
			<td class="pdl10 left">
				<input type="text" name="consumer_price[<?php echo $TPL_V1["option_seq"]?>]" value="<?php echo $TPL_V1["consumer_price"]?>" class="consumer_price consumer_price<?php echo $TPL_V1["goods_seq"]?>_value onlyfloat" apply_target="consumer_price" style="text-align:right;width:25%;"/>
<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn" goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='consumer_price<?php echo $TPL_V1["goods_seq"]?>'>▼</button></span><?php }?>
				→
				<input type="text" name="price[<?php echo $TPL_V1["option_seq"]?>]" value="<?php echo $TPL_V1["price"]?>" class="price price_<?php echo $TPL_V1["goods_seq"]?>_value onlyfloat" apply_target="price" style="text-align:right;width:25%;"/>
<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn" goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='price_<?php echo $TPL_V1["goods_seq"]?>'>▼</button></span><?php }?>
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
			<td class="pdr10 right"><?php if($TPL_V2["commission_type"]=='SACO'&&$TPL_V1["provider_seq"]> 1){?><?php echo $TPL_V2["commission_rate"]?> %<?php }?></td>
			<td class="pdr10 right">
<?php if($TPL_V2["commission_type"]=='SUCO'){?>
				<?php echo $TPL_V2["commission_rate"]?> %
<?php }elseif($TPL_V2["commission_type"]=='SUPR'){?>
				<?php echo $TPL_V2["commission_rate"]?> <?php echo $TPL_VAR["config_system"]['basic_currency']?>

<?php }?>
			</td>
			<td class="pdl10 left">
				<input type="text" name="detail_consumer_price[<?php echo $TPL_V2["option_seq"]?>]" value="<?php echo $TPL_V2["consumer_price"]?>" class="consumer_price onlyfloat" defalult_option="<?php echo $TPL_V2["default_option"]?>" style="text-align:right;width:30%;" disabled/>
				→
				<input type="text" name="detail_price[<?php echo $TPL_V2["option_seq"]?>]" value="<?php echo $TPL_V2["price"]?>" class="price onlyfloat" defalult_option="<?php echo $TPL_V2["default_option"]?>" style="text-align:right;width:30%;" disabled/>
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
		<tr><td height="15"></td><td colspan="9"></td></tr>
	</tbody>
<?php }?>
<?php }}else{?>
	<tbody class="ltb goods_list">
		<tr class="list-row">
			<td align="center" colspan="10">
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