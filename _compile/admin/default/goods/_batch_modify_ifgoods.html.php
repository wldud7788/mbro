<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_ifgoods.html 000009098 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<br class="table-gap" />
<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="20%" /><!--대상 상품-->
		<col width="80%" /><!--아래와 같이 업데이트-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th>대상 상품</th>
		<th colspan="2">아래와 같이 업데이트</th>
	</tr>
	</thead>

	<tbody class="ltb">
		<tr class="list-row" style="height:70px;">
			<td align="center" class="td">
			검색된 상품에서  →
			<select name="modify_list"  class="line">
				<option value="choice">선택 </option>
				<option value="all">전체 </option>
			</select>
			</td>
			<td>
				<table width="100%" cellpadding="0"  cellspacing="0" style="border:1px;">
				<colgroup>
					<col width="15%" />
					<col  />
				</colgroup>
				<tr>
					<td><label><input type="checkbox" class="batch_update_item" name="batch_goods_name_yn" value="1" /> 상품명을 </label></td>
					<td><input type='text' name="batch_goods_name" value="" size="40"> 변경합니다.</td>
				</tr>
				<tr>
					<td><label><input type="checkbox" class="batch_update_item" name="batch_color_pick_yn" value="1" /> 검색 색상을</label></td>
					<td>
						<div class="color-check pd3">
<?php if(is_array($TPL_R1=$TPL_VAR["arr_common"]['colorPickList'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<label style="background-color:#<?php echo $TPL_V1["code"]?>;margin:1px;" class=" <?php if($TPL_V1["select"]){?>active<?php }?>" alt="<?php echo $TPL_V1["name"]?>" title="<?php echo $TPL_V1["name"]?>"><input type="checkbox" name="batch_color_pick[]" class="all_color_pick_value" value="<?php echo $TPL_V1["code"]?>" <?php if($TPL_V1["select"]){?>checked<?php }?> apply_target="color_pick" /></label>
<?php }}?>
							변경합니다.
						</div>
					</td>
				</tr>
				<tr>
					<td><label><input type="checkbox" class="batch_update_item" name="batch_keyword_yn" value="1" /> 추가 검색어를</label></td>
					<td><input type='text' name="batch_keyword" value="" size="40"> 변경합니다.</td>
				</tr>
				<tr>
					<td><label><input type="checkbox" class="batch_update_item" name="batch_grade_sale_yn" value="1" /> 회원등급혜택을</label></td>
					<td>
						<select name="batch_grade_sale" class="batch_grade_sale line" style="width:120px;">
<?php if(is_array($TPL_R1=$TPL_VAR["arr_common"]['sale_list'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["sale_seq"]?>"><?php echo $TPL_V1["sale_title"]?></option>
<?php }}?>
						</select> 변경합니다.</td>
				</tr>
				<tr>
					<td><label><input type="checkbox" class="batch_update_item" name="batch_tax_yn" value="1" /> 과세/비과세를</label></td>
					<td>
						<select name="batch_tax" class="batch_tax line" style="width:120px;">
						<option value="tax">과세</option>
						<option value="exempt">비과세</option>
						</select> 변경합니다.
					</td>
				</tr>
				<tr>
					<td style="border-bottom:0px;"><label><input type="checkbox" class="batch_update_item" name="batch_summary_yn" value="1" /> 간략설명을</label></td>
					<td style="border-bottom:0px;"><input type='text' name="batch_summary" value="" size="40"> 변경합니다.</td>
				</tr>
			</table>



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
		<col width="30" /><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="100" /><!--입점--><?php }?>
		<col width="60" /><!--상품이미지-->
		<col width="250" /><!--상품명-->
		<col width="170" /><!--검색색상-->
		<col width="30%" /><!--추가검색어-->
		<col width="80" /><!--회원혜택-->
		<col width="80" /><!--과세여부-->
		<col /><!--간략설명-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
<?php if(serviceLimit('H_AD')){?><th>입점</th><?php }?>
		<th colspan="2">상품명</th>
		<th>검색색상</th>
		<th>추가검색어</th>
		<th>회원혜택</th>
		<th>과세/비과세</th>
		<th>간략설명</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;">
			<td align="center"><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_V1["provider_seq"]=='1'){?>
				<td class="bg-blue white bold center">
<?php if($TPL_V1["lastest_supplier_name"]){?>
					매입 - <?php echo $TPL_V1["lastest_supplier_name"]?>

<?php }else{?>
					매입
<?php }?>
				</td>
<?php }else{?>
				<td class="bg-red white bold center"><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
<?php }?>
			<td align="center">
				<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a></td>
			<td align="left" style="padding-left:10px;">
<?php if($TPL_V1["cancel_type"]=='1'){?><div><span class="order-item-cancel-type left" >[청약철회불가]</span></div><?php }?>
<?php if($TPL_V1["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
				<a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo $TPL_V1["goods_name"]?></a> <div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
			</td>
			<td align="center">
				<div class="color-check pd3 center">
<?php if(is_array($TPL_R2=$TPL_VAR["arr_common"]['colorPickList'])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if(in_array($TPL_V2["code"],$TPL_V1["color_pick_list"])){?>
					<label style="background-color:#<?php echo $TPL_V2["code"]?>;margin:1px;cursor:none;"></label>
<?php }?>
<?php }}?>
				</div>
			</td>
			<td align="left"><?php echo str_replace(',',', ',$TPL_V1["keyword"])?></td>
			<td align="center"><?php echo $TPL_V1["sale_title"]?></td>
			<td align="center"><?php if($TPL_V1["tax"]=='exempt'){?>비과세<?php }else{?>과세<?php }?></td>
			<td align="left"><?php echo $TPL_V1["summary"]?></td>
		</tr>
		<tr class="order-list-summary-row hide">
			<td <?php if(serviceLimit('H_AD')){?>colspan="9"<?php }else{?>colspan="8"<?php }?> class="order-list-summary-row-td option_info_td"><div class="option_info"></div></td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" colspan="9">
<?php if($TPL_VAR["search_text"]){?>
				'<?php echo $TPL_VAR["search_text"]?>' 검색된 상품이 없습니다.
<?php }else{?>
				등록된 상품이 없습니다.
<?php }?>
		</td>
	</tr>
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->

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