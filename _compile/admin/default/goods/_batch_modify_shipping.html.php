<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_shipping.html 000007984 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
	$(document).ready(function() {
		// 위탁배송 본사그룹 호출
		$("#shipping_grp_sel").on('change',function(){
			if($(this).val() == 'trust_ship'){
				$("#shipping_grp_sub").show();
				get_ship_sub_grp();
			}else{
				$("#shipping_grp_sub").hide();
			}
		});

		reset_ship_grp();
		get_ship_grp('<?php echo $_GET["provider_seq"]?>');
	});

	function reset_ship_grp(){
		$("#shipping_grp_sel > option").remove();
		$("#shipping_grp_sel").append('<option value="">선택</option>');
	}

	function get_ship_grp(provider_seq){
		$.ajax({
			type: 'get',
			url: '../popup/shipping_grp_ajax',
			data: 'provider_seq='+provider_seq,
			dataType: 'json',
			success: function(res) {
				$.each(res, function(idx, data){
					$("#shipping_grp_sel").append('<option value="' + res[idx]['shipping_group_seq'] + '">' + res[idx]['shipping_group_name'] + '</option>');
				});
				if	(provider_seq > 1){
					$("#shipping_grp_sel").append('<option value="trust_ship">본사위탁배송</option>');
				}
			}
		});
	}

	function get_ship_sub_grp(){
		$.ajax({
			type: 'get',
			url: '../popup/shipping_grp_ajax',
			data: 'provider_seq=1',
			dataType: 'json',
			success: function(res) {
				$.each(res, function(idx, data){
					$("#shipping_grp_sub").append('<option value="' + res[idx]['shipping_group_seq'] + '">' + res[idx]['shipping_group_name'] + '</option>');
				});
			}
		});
	}
</script>

<br class="table-gap" />

<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="40%" /><!--대상 상품-->
		<col width="60%" /><!--아래와 같이 업데이트-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th>대상 상품</th>
		<th colspan="2">아래와 같이 업데이트</th>
	</tr>
	</thead>

	<tbody class="ltb">
		<tr class="list-row" style="height:70px;">
			<td class="td" align="center">
<?php if(serviceLimit('H_AD')){?>
<?php if($_GET["provider_seq"]){?>
				<input type="hidden" name="sel_provider_seq" value="<?php echo $_GET["provider_seq"]?>" />
				<b><?php if($_GET["provider_seq"]> 1){?><?php echo $_GET["provider_name"]?><?php }else{?>본사<?php }?></b> 판매자로 
				검색된 상품에서  →
				<select name="modify_list"  class="modify_list">
					<option value="choice">선택 </option>
					<option value="all">전체 </option>
				</select>
<?php }else{?>
				먼저 판매자를 선택하여 검색해주세요.
<?php }?>
<?php }else{?>
				<input type="hidden" name="sel_provider_seq" value="1" />
				검색된 상품에서  →
				<select name="modify_list"  class="modify_list">
					<option value="choice">선택 </option>
					<option value="all">전체 </option>
				</select>
<?php }?>
			</td>
			<td class="td" align="center">
<?php if($_GET["provider_seq"]> 0){?>
				<select id="shipping_grp_sel" name="sel_shipping_group_seq">
				</select>
				<select id="shipping_grp_sub" name="shipping_grp_sub" class="hide">
				</select>
				&nbsp;
				배송 정책으로 변경합니다.
<?php }else{?>
				-
<?php }?>
			</td>
		</tr>
	</tbody>
</table>

<div class="clearbox">
	<ul class="left-btns">
		<li class="left-btns-txt desc">※ 이용방법 : [검색하기] 버튼으로 검색 후 상품정보를 조건 업데이트 하세요!</li>
	</ul>
	<ul class="right-btns">
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
		<col width="30" /><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="100" /><!--입점사--><?php }?>
		<col width="63" /><!--상품이미지-->
		<col /><!--상품명-->
<?php if(serviceLimit('H_AD')){?><col width="150"/><!--배송주체--><?php }?>
		<col width="30%" /><!--배송-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
<?php if(serviceLimit('H_AD')){?><th>입점</th><?php }?>
		<th colspan="2">상품명</th>
<?php if(serviceLimit('H_AD')){?><th>배송주체</th><?php }?>
		<th>배송 정책</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<!-- 상품정보 : 시작 -->
		<tbody class="ltb goods_list">
			<tr class="list-row" style="height:70px;">
				<td class="center"><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
				<td class="center white bold <?php if($TPL_V1["provider_seq"]=='1'){?>bg-blue<?php }else{?>bg-red<?php }?>">
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
<?php if(serviceLimit('H_AD')){?>
				<td class="option_td pdl5 left">
<?php if($TPL_V1["provider_seq"]== 1||$TPL_V1["trust_shipping"]=='Y'){?>
					본사 배송
<?php }else{?>
					입점사 배송
<?php }?>
				</td>
<?php }?>
				<td class="option_td pdl5 left">
					<div class="fl">
<?php if(!$TPL_VAR["selleradmin"]||$TPL_V1["trust_shipping"]!='Y'){?>
						<?php echo $TPL_V1["shipping_group_name"]?> (<?php echo $TPL_V1["shipping_group_seq"]?>)
<?php }?>
<?php if($TPL_V1["trust_shipping"]=='Y'){?>
						<div class="desc">본사가 위탁 배송 합니다.</div>
<?php }?>
					</div>
<?php if(!$TPL_VAR["selleradmin"]||$TPL_V1["trust_shipping"]!='Y'){?>
					<div class="fr pdr10">
						<span class="highlight-link hand" onclick="window.open('../setting/shipping_group_regist?shipping_group_seq=<?php echo $TPL_V1["shipping_group_seq"]?>');">상세</span>
					</div>
<?php }?>
				</td>
			</tr>
		</tbody>
		<!-- 상품정보 : 끝 -->
<?php }}?>
<?php }else{?>
	<tbody class="ltb goods_list">
		<tr class="list-row">
			<td align="center" colspan="6">
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