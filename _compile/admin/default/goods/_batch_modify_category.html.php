<?php /* Template_ 2.2.6 2022/05/17 12:31:55 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_category.html 000025928 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
	$(document).ready(function() {

		/* 카테고리 불러오기 */
		category_admin_select_load('','add_category1','');
		$("select[name='add_category1']").live("change",function(){
			category_admin_select_load('add_category1','add_category2',$(this).val());
			category_admin_select_load('add_category2','add_category3',"");
			category_admin_select_load('add_category3','add_category4',"");
		});
		$("select[name='add_category2']").live("change",function(){
			category_admin_select_load('add_category2','add_category3',$(this).val());
			category_admin_select_load('add_category3','add_category4',"");
		});
		$("select[name='add_category3']").live("change",function(){
			category_admin_select_load('add_category3','add_category4',$(this).val());
		});

		category_admin_select_load('','move_category1','');
		$("select[name='move_category1']").live("change",function(){
			category_admin_select_load('move_category1','move_category2',$(this).val());
			category_admin_select_load('move_category2','move_category3',"");
			category_admin_select_load('move_category3','move_category4',"");
		});
		$("select[name='move_category2']").live("change",function(){
			category_admin_select_load('move_category2','move_category3',$(this).val());
			category_admin_select_load('move_category3','move_category4',"");
		});
		$("select[name='move_category3']").live("change",function(){
			category_admin_select_load('move_category3','move_category4',$(this).val());
		});

		category_admin_select_load('','copy_category1','');
		$("select[name='copy_category1']").live("change",function(){
			category_admin_select_load('copy_category1','copy_category2',$(this).val());
			category_admin_select_load('copy_category2','copy_category3',"");
			category_admin_select_load('copy_category3','copy_category4',"");
		});
		$("select[name='copy_category2']").live("change",function(){
			category_admin_select_load('copy_category2','copy_category3',$(this).val());
			category_admin_select_load('copy_category3','copy_category4',"");
		});
		$("select[name='copy_category3']").live("change",function(){
			category_admin_select_load('copy_category3','copy_category4',$(this).val());
		});


		/* 브랜드 불러오기 */
		brand_admin_select_load('','add_brand1','');
		$("select[name='add_brand1']").live("change",function(){
			brand_admin_select_load('add_brand1','add_brand2',$(this).val());
			brand_admin_select_load('add_brand2','add_brand3',"");
			brand_admin_select_load('add_brand3','add_brand4',"");
		});
		$("select[name='add_brand2']").live("change",function(){
			brand_admin_select_load('add_brand2','add_brand3',$(this).val());
			brand_admin_select_load('add_brand3','add_brand4',"");
		});
		$("select[name='add_brand3']").live("change",function(){
			brand_admin_select_load('add_brand3','add_brand4',$(this).val());
		});

		brand_admin_select_load('','move_brand1','');
		$("select[name='move_brand1']").live("change",function(){
			brand_admin_select_load('move_brand1','move_brand2',$(this).val());
			brand_admin_select_load('move_brand2','move_brand3',"");
			brand_admin_select_load('move_brand3','move_brand4',"");
		});
		$("select[name='move_brand2']").live("change",function(){
			brand_admin_select_load('move_brand2','move_brand3',$(this).val());
			brand_admin_select_load('move_brand3','move_brand4',"");
		});
		$("select[name='move_brand3']").live("change",function(){
			brand_admin_select_load('move_brand3','move_brand4',$(this).val());
		});

		brand_admin_select_load('','copy_brand1','');
		$("select[name='copy_brand1']").live("change",function(){
			brand_admin_select_load('copy_brand1','copy_brand2',$(this).val());
			brand_admin_select_load('copy_brand2','copy_brand3',"");
			brand_admin_select_load('copy_brand3','copy_brand4',"");
		});
		$("select[name='copy_brand2']").live("change",function(){
			brand_admin_select_load('copy_brand2','copy_brand3',$(this).val());
			brand_admin_select_load('copy_brand3','copy_brand4',"");
		});
		$("select[name='copy_brand3']").live("change",function(){
			brand_admin_select_load('copy_brand3','copy_brand4',$(this).val());
		});
		$("select[name='target_modify']").bind("change",function(){
			check_target_modify();
		});

		/* 지역 불러오기 */
		location_admin_select_load('','add_location1','');
		$("select[name='add_location1']").live("change",function(){
			location_admin_select_load('add_location1','add_location2',$(this).val());
			location_admin_select_load('add_location2','add_location3',"");
			location_admin_select_load('add_location3','add_location4',"");
		});
		$("select[name='add_location2']").live("change",function(){
			location_admin_select_load('add_location2','add_location3',$(this).val());
			location_admin_select_load('add_location3','add_location4',"");
		});
		$("select[name='add_location3']").live("change",function(){
			location_admin_select_load('add_location3','add_location4',$(this).val());
		});

		location_admin_select_load('','move_location1','');
		$("select[name='move_location1']").live("change",function(){
			location_admin_select_load('move_location1','move_location2',$(this).val());
			location_admin_select_load('move_location2','move_location3',"");
			location_admin_select_load('move_location3','move_location4',"");
		});
		$("select[name='move_location2']").live("change",function(){
			location_admin_select_load('move_location2','move_location3',$(this).val());
			location_admin_select_load('move_location3','move_location4',"");
		});
		$("select[name='move_location3']").live("change",function(){
			location_admin_select_load('move_location3','move_location4',$(this).val());
		});

		location_admin_select_load('','copy_location1','');
		$("select[name='copy_location1']").live("change",function(){
			location_admin_select_load('copy_location1','copy_location2',$(this).val());
			location_admin_select_load('copy_location2','copy_location3',"");
			location_admin_select_load('copy_location3','copy_location4',"");
		});
		$("select[name='copy_location2']").live("change",function(){
			location_admin_select_load('copy_location2','copy_location3',$(this).val());
			location_admin_select_load('copy_location3','copy_location4',"");
		});
		$("select[name='copy_location3']").live("change",function(){
			location_admin_select_load('copy_location3','copy_location4',$(this).val());
		});
		$("select[name='target_modify']").bind("change",function(){
			check_target_modify();
		});

		check_target_modify();

	});

	function check_target_modify()
	{
		$("tbody.if_category").addClass("hide");
		$("tbody.if_brand").addClass("hide");
		$("tbody.if_location").addClass("hide");
		var target_str = $("select[name='target_modify'] option:selected").val();
		if( target_str == 'category' ){
			$("tbody.if_category").removeClass("hide");
		}
		if( target_str == 'brand' ){
			$("tbody.if_brand").removeClass("hide");
		}
		if( target_str == 'location' ){
			$("tbody.if_location").removeClass("hide");
		}
	}
</script>
<br class="table-gap" />

<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="15%" /><!--대상 상품-->
		<col width="15%" /><!--검색 조건-->
		<col /><!--아래와 같이 업데이트-->
		<col width="80" /><!--결과-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th>대상 상품</th>
		<th>검색 조건</th>
		<th>
		<select name="target_modify" class="line">
			<option value="category" class="bg-blue white">카테고리</option>
			<option value="brand" class="bg-red white">브랜드</option>
			<option value="location" class="bg-red white">지역</option>
		</select>
		를 아래와 같이 업데이트
		</th>
		<th>결과</th>
	</tr>
	</thead>
	<tbody class="ltb if_category">
		<tr class="list-row" style="height:70px;">
			<td align="center" rowspan="10">
			검색된 상품에서  →
			<select name="modify_list_category" class="line">
				<option value="choice">선택 </option>
				<option value="all">전체 </option>
			</select>
			</td>
			<td align="center">-</td>
			<td>
			<label>
			<input type="radio" name="search_category_mode" value="add" checked />
			</label>
			<select class="line" name="add_category1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
			<select class="line" name="add_category2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
			<select class="line" name="add_category3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
			<select class="line" name="add_category4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>
			카테고리에 연결합니다.
			<div class="blue">상품에 연결된 카테고리가 없었으면 연결되는 카테고리가 대표카테고리가 됩니다.</div>
			</td>
			<td align="center">
			연결
			</td>
		</tr>
		<tr class="list-row" style="height:70px;">

			<td align="center" class="blue">카테고리로 검색해야만 가능</td>
			<td>
			<label>
			<input type="radio" name="search_category_mode" value="move" />
			기존 카테고리와의 연결을 해제하고
			</label>
			<select class="line" name="move_category1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
			<select class="line" name="move_category2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
			<select class="line" name="move_category3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
			<select class="line" name="move_category4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>
			카테고리에 연결합니다.
			<div class="blue">해제되는 카테고리가 대표카테고리였으면 연결되는 카테고리가 대표카테고리가 됩니다.</div>
			</td>
			<td align="center">
			이동
			</td>
		</tr>
		<tr class="list-row" style="height:70px;">
			<td align="center">-</td>
			<td>
			<label>
			<input type="radio" name="search_category_mode" value="copy" />
			상품을 복사해서
			</label>
			<select class="line" name="copy_category1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
			<select class="line" name="copy_category2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
			<select class="line" name="copy_category3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
			<select class="line" name="copy_category4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>
			카테고리에 연결합니다.
			<div class="blue">복사된 신규상품에 연결되는 카테고리는 당연히 대표카테고리가 됩니다.</div>
			</td>
			<td align="center">
			복사
			</td>
		</tr>
		<tr class="list-row" style="height:70px;">
			<td align="center" class="blue">카테고리로 검색해야만 가능</td>
			<td>
			<label>
			<input type="radio" name="search_category_mode" value="del" />
			카테고리로 검색된 상품의 해당 카테고리만 연결을 해제합니다.
			</label>
			<div class="blue">단, 카테고리가 대표카테고리이면 연결을 해제하지 않습니다.</div>
			</td>
			<td align="center">
			부분해제
			</td>
		</tr>
		<tr class="list-row" style="height:70px;">
			<td align="center">-</td>
			<td>
			<label>
			<input type="radio" name="search_category_mode" value="all_del" />
			모든 카테고리와의 연결을 해제합니다.
			</label>
			<div class="blue">즉, 해당 상품은 미분류 상품이 됩니다.</div>
			</td>
			<td align="center">
			전체해제
			</td>
		</tr>
	</tbody>

	<tbody class="ltb if_brand">
		<tr class="list-row" style="height:70px;">
			<td align="center" rowspan="5">
			검색된 상품에서  →
			<select name="modify_list_brand" class="modify_list line">
				<option value="choice">선택 </option>
				<option value="all">전체 </option>
			</select>
			</td>
			<td align="center">-</td>
			<td>
			<label>
			<input type="radio" name="search_brand_mode" value="add" checked />
			</label>
			<select class="line" name="add_brand1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
			<select class="line" name="add_brand2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
			<select class="line" name="add_brand3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
			<select class="line" name="add_brand4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>
			브랜드에 연결합니다.
			<div class="red">상품에 연결된 브랜드가 없었으면 연결되는 브랜드가 대표브랜드가 됩니다.</div>
			</td>
			<td align="center">
			연결
			</td>
		</tr>
		<tr class="list-row" style="height:70px;">

			<td align="center" style="color:red">브랜드로 검색해야만 가능</td>
			<td>
			<label>
			<input type="radio" name="search_brand_mode" value="move" />
			기존 브랜드와의 연결을 해제하고
			</label>
			<select class="line" name="move_brand1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
			<select class="line" name="move_brand2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
			<select class="line" name="move_brand3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
			<select class="line" name="move_brand4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>
			브랜드에 연결합니다.
			<div class="red">해제되는 브랜드가 대표브랜드였으면 연결되는 브랜드가 대표브랜드가 됩니다.</div>
			</td>
			<td align="center">
			이동
			</td>
		</tr>
		<tr class="list-row" style="height:70px;">
			<td align="center">-</td>
			<td>
			<label>
			<input type="radio" name="search_brand_mode" value="copy" />
			상품을 복사해서
			</label>
			<select class="line" name="copy_brand1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
			<select class="line" name="copy_brand2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
			<select class="line" name="copy_brand3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
			<select class="line" name="copy_brand4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>
			브랜드에 연결합니다.
			<div class="red">복사된 신규상품에 연결되는 브랜드는 당연히 대표브랜드가 됩니다.</div>
			</td>
			<td align="center">
			복사
			</td>
		</tr>
		<tr class="list-row" style="height:70px;">
			<td align="center" style="color:red">브랜드로 검색해야만 가능</td>
			<td>
			<label>
			<input type="radio" name="search_brand_mode" value="del" />
			브랜드로 검색된 상품의 해당 브랜드만 연결을 해제합니다.
			</label>
			<div class="red">단, 브랜드가 대표브랜드이면 연결을 해제하지 않습니다.</div>
			</td>
			<td align="center">
			부분해제
			</td>
		</tr>
		<tr class="list-row" style="height:70px;">
			<td align="center">-</td>
			<td>
			<label>
			<input type="radio" name="search_brand_mode" value="all_del" />
			모든 브랜드와의 연결을 해제합니다.
			</label>
			<div class="red">즉, 해당 상품은 미분류 상품이 됩니다.</div>
			</td>
			<td align="center">
			전체해제
			</td>
		</tr>
	</tbody>
	<tbody class="ltb if_location">
		<tr class="list-row" style="height:70px;">
			<td align="center" rowspan="5">
			검색된 상품에서  →
			<select name="modify_list_location" class="modify_list line">
				<option value="choice">선택 </option>
				<option value="all">전체 </option>
			</select>
			</td>
			<td align="center">-</td>
			<td>
			<label>
			<input type="radio" name="search_location_mode" value="add" checked />
			</label>
			<select class="line" name="add_location1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
			<select class="line" name="add_location2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
			<select class="line" name="add_location3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
			<select class="line" name="add_location4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>
			지역에 연결합니다.
			<div class="red">상품에 연결된 지역이 없었으면 연결되는 지역이 대표지역이 됩니다.</div>
			</td>
			<td align="center">
			연결
			</td>
		</tr>
		<tr class="list-row" style="height:70px;">

			<td align="center" style="color:red">지역으로 검색해야만 가능</td>
			<td>
			<label>
			<input type="radio" name="search_location_mode" value="move" />
			기존 지역과의 연결을 해제하고
			</label>
			<select class="line" name="move_location1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
			<select class="line" name="move_location2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
			<select class="line" name="move_location3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
			<select class="line" name="move_location4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>
			지역에 연결합니다.
			<div class="red">해제되는 지역이 대표지역였으면 연결되는 지역이 대표지역이 됩니다.</div>
			</td>
			<td align="center">
			이동
			</td>
		</tr>
		<tr class="list-row" style="height:70px;">
			<td align="center">-</td>
			<td>
			<label>
			<input type="radio" name="search_location_mode" value="copy" />
			상품을 복사해서
			</label>
			<select class="line" name="copy_location1" size="1" style="width:100px;"><option value="">= 1차 분류 =</option></select>
			<select class="line" name="copy_location2" size="1" style="width:100px;"><option value="">= 2차 분류 =</option></select>
			<select class="line" name="copy_location3" size="1" style="width:100px;"><option value="">= 3차 분류 =</option></select>
			<select class="line" name="copy_location4" size="1" style="width:100px;"><option value="">= 4차 분류 =</option></select>
			지역에 연결합니다.
			<div class="red">복사된 신규상품에 연결되는 지역는 당연히 대표지역이 됩니다.</div>
			</td>
			<td align="center">
			복사
			</td>
		</tr>
		<tr class="list-row" style="height:70px;">
			<td align="center" style="color:red">지역으로 검색해야만 가능</td>
			<td>
			<label>
			<input type="radio" name="search_location_mode" value="del" />
			지역으로 검색된 상품의 해당 지역만 연결을 해제합니다.
			</label>
			<div class="red">단, 지역이 대표지역이면 연결을 해제하지 않습니다.</div>
			</td>
			<td align="center">
			부분해제
			</td>
		</tr>
		<tr class="list-row" style="height:70px;">
			<td align="center">-</td>
			<td>
			<label>
			<input type="radio" name="search_location_mode" value="all_del" />
			모든 지역과의 연결을 해제합니다.
			</label>
			<div class="red">즉, 해당 상품은 미분류 상품이 됩니다.</div>
			</td>
			<td align="center">
			전체해제
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
	<ul class="right-btns clearbox">
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
		<col width="50" /><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="100" /><!--입점사--><?php }?>
		<col width="60" /><!--상품이미지-->
		<col /><!--상품명-->
		<col width="20%" /><!--대표 카테고리-->
		<col width="20%" /><!--대표 브랜드-->
		<col width="20%" /><!--대표 지역-->

	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
<?php if(serviceLimit('H_AD')){?><th>입점</th><?php }?>
		<th colspan="2">상품명</th>
		<th>대표 카테고리</th>
		<th>대표 브랜드</th>
		<th>대표 지역</th>
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
			<td align="center"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a></td>
			<td align="left" style="padding-left:10px;"><a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut($TPL_V1["goods_name"], 80)?></a> <div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
<?php if($TPL_V1["tax"]=='exempt'){?><div style="color:red;">[비과세]</div><?php }?></td>
			<td style="padding-left:5px;">
<?php if($TPL_V1["category"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["category"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if(!$TPL_V2["link"]){?>
					<div style="color:gray"><?php echo implode(' > ',$TPL_V2["category_name"])?></div>
<?php }else{?>
					<div ><strong><?php echo implode(' > ',$TPL_V2["category_name"])?></strong></div>
<?php }?>
<?php }}?>
<?php }else{?><span style="color:gray">미분류</span><?php }?>
			</td>
			<td style="padding-left:10px;">
<?php if($TPL_V1["brand"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["brand"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if(!$TPL_V2["link"]){?>
					<div style="color:gray"><?php echo implode(' > ',$TPL_V2["brand_name"])?></div>
<?php }else{?>
					<div ><strong><?php echo implode(' > ',$TPL_V2["brand_name"])?></strong></div>
<?php }?>
<?php }}?>
<?php }else{?><span style="color:gray">미분류</span><?php }?>
			</td>
			<td style="padding-left:10px;">
<?php if($TPL_V1["location"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["location"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if(!$TPL_V2["link"]){?>
					<div style="color:gray"><?php echo implode(' > ',$TPL_V2["location_name"])?></div>
<?php }else{?>
					<div ><strong><?php echo implode(' > ',$TPL_V2["location_name"])?></strong></div>
<?php }?>
<?php }}?>
<?php }else{?><span style="color:gray">미분류</span><?php }?>
			</td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" colspan="7">
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