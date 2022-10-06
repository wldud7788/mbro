<?php /* Template_ 2.2.6 2022/05/17 12:29:14 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_batch_modify_goods.html 000010696 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
function all_color_pick($applyObj){

	var applyType			= $applyObj.attr('apply_type');
	var all_checked_obj		= new Array();
	var target				= "";
	var k					= 0;

	$('.' + applyType + '_value').each(function() {
		if($(this).is(":checked")){
			all_checked_obj[k] = $(this).val();
			k++;
		}
		target		= $(this).attr('apply_target');
	});

	$("input:checkbox[name='goods_seq[]']:checked").each (function(e) {

		var $applyTbodyObj	= $('tr[goods_seq="' + this.value + '"]');
		var obj				= $applyTbodyObj.find("input[name='" + target + "["+this.value+"][]']");

		//초기화
		obj.prop("checked",false);
		obj.parent().attr("class","");

		obj.each(function(){

			for(var i=0; i < all_checked_obj.length; i++){

				if(all_checked_obj[i] == this.value){

					$(this).prop("checked",true);
					$(this).parent().attr("class","active");
				}
			}
		});
	});

	return true;

}
</script>

<ul class="left-btns clearbox">
	<li>
		<div style="margin-top:rpx;" id="search_count" class="hide">
			총 <b>0</b> 개
		</div>
	</li>
	<li><span class="desc">※ 이용방법 : [검색하기]버튼으로 검색 후 상품정보를 조건 업데이트 하세요!</span></li>
</ul>

<br class="table-gap" />
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

<style>
.list-table-style th .color-check label {
	width:14px;height:14px;
}
</style>

<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="30" /><!--체크-->
		<col width="60" /><!--상품이미지-->
		<col width="250" /><!--상품명-->
		<col width="170" /><!--검색색상-->
		<col width="200" /><!--추가검색어-->
		<col width="130" /><!--회원혜택-->
		<col width="110" /><!--과세여부-->
		<col /><!--간략설명-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th></th>

		<th colspan="2">
			<input type='text' name="all_goods_name" class="all_goods_name_value" value="" apply_target="goods_name" apply_text="상품명" style="width:80%"><span class="btn small gray ml3"><button type="button" class="applyAllBtn"  apply_type="all_goods_name">▼</button></span>
		</th>
		<th>
			<div class="color-check pd3 center">
<?php if(is_array($TPL_R1=$TPL_VAR["arr_common"]['colorPickList'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
				<label style="background-color:#<?php echo $TPL_K1?>;margin:1px;" class=" <?php if($TPL_V1== 1){?>active<?php }?>">
				<input type="checkbox" name="all_color_pick[]" class="all_color_pick_value" value="<?php echo $TPL_K1?>" <?php if($TPL_V1== 1){?>checked<?php }?> apply_target="color_pick" /></label>
<?php }}?>
				<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type="all_color_pick" done_function="all_color_pick">▼</button></span>
			</div>
		</th>
		<th>
			<input type='text' name="all_batch_keyword" class="all_batch_keyword_value" value="" apply_target="batch_keyword" style="width:70%;"><span class="btn small gray ml3"><button type="button" class="applyAllBtn" apply_type="all_batch_keyword">▼</button></span>
		</th>
		<th>
			<select name="all_grade_sale" class="all_grade_sale_value line" apply_target="grade_sale" style="width:60%;">
<?php if(is_array($TPL_R1=$TPL_VAR["arr_common"]['sale_list'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<option value="<?php echo $TPL_V1["sale_seq"]?>"><?php echo $TPL_V1["sale_title"]?></option>
<?php }}?>
			</select><span class="btn small gray ml3 mt3"><button type="button" class="applyAllBtn" apply_type="all_grade_sale">▼</button></span>
		</th>
		<th>
			<select name="all_tax" class="all_tax_value line" apply_target="tax" style="width:60%;">
			<option value="tax">과세</option>
			<option value="exempt">비과세</option>
			</select><span class="btn small gray ml3 mt3"><button type="button" class="applyAllBtn" apply_type="all_tax">▼</button></span>
		</th>
		<th>
			<input type='text' name="all_summary" class="all_summary_value" value="" apply_target="summary" style="width:80%;"><span class="btn small gray ml3"><button type="button" class="applyAllBtn" apply_type="all_summary">▼</button></span>
		</th>
	</tr>
	</thead>
</table>
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="30" /><!--체크-->
		<col width="60" /><!--상품이미지-->
		<col width="250" /><!--상품명-->
		<col width="170" /><!--검색색상-->
		<col width="200" /><!--추가검색어-->
		<col width="110" /><!--회원혜택-->
		<col width="110" /><!--과세여부-->
		<col /><!--간략설명-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th style="border-top:0px;"><input type="checkbox" id="chkAll" /></th>
		<th style="border-top:0px;" colspan="2">상품명</th>
		<th style="border-top:0px;">검색색상</th>
		<th style="border-top:0px;">추가검색어</th>
		<th style="border-top:0px;">회원혜택</th>
		<th style="border-top:0px;">과세/비과세</th>
		<th style="border-top:0px;">간략설명</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;" goods_seq="<?php echo $TPL_V1["goods_seq"]?>">
			<td class="center"><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /></td>
			<td class="center">
				<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a>
			</td>
			<td class="left" style="padding-left:10px;">
<?php if($TPL_V1["cancel_type"]=='1'){?><div><span class="order-item-cancel-type left" >[청약철회불가]</span></div><?php }?>
<?php if($TPL_V1["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
				<input type="text" name="goods_name[<?php echo $TPL_V1["goods_seq"]?>]" size="35" value="<?php echo $TPL_V1["goods_name"]?>" apply_type="goods_name<?php echo $TPL_V1["goods_seq"]?>" class="goods_name"> <div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
			</td>
			<td>
				<div class="color-check pd3 center">
<?php if(is_array($TPL_R2=$TPL_VAR["arr_common"]['colorPickList'])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
					<label style="background-color:#<?php echo $TPL_K2?>;margin:1px;" class="<?php if(in_array($TPL_K2,$TPL_V1["color_pick_list"])){?>active<?php }?>"><input type="checkbox" name="color_pick[<?php echo $TPL_V1["goods_seq"]?>][]" value="<?php echo $TPL_K2?>" <?php if(in_array($TPL_K2,$TPL_V1["color_pick_list"])){?>checked<?php }?> class="color_pick" apply_type="color_pick<?php echo $TPL_V1["goods_seq"]?>" /></label>
<?php }}?>
				</div>
			</td>

			<td class="center"><input type='text' name="batch_keyword[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["keyword"]?>" style="width:90%;" class="batch_keyword" apply_type="batch_keyword<?php echo $TPL_V1["goods_seq"]?>"></td>
			<td class="center">
				<select name="grade_sale[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["summary"]?>" style="width:90%;" class="grade_sale line" apply_type="grade_sale<?php echo $TPL_V1["goods_seq"]?>">
<?php if(is_array($TPL_R2=$TPL_VAR["arr_common"]['sale_list'])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<option value="<?php echo $TPL_V2["sale_seq"]?>" <?php if($TPL_V2["sale_seq"]==$TPL_V1["sale_seq"]){?> selected<?php }?>><?php echo $TPL_V2["sale_title"]?></option>
<?php }}?>
				</select>
			</td>
			<td class="center">
				<select name="tax[<?php echo $TPL_V1["goods_seq"]?>]" style="width:85%;" class="tax line" apply_type="tax<?php echo $TPL_V1["goods_seq"]?>">
				<option value="tax" <?php if($TPL_V1["tax"]=='tax'){?>selected<?php }?>>과세</option>
				<option value="exempt" <?php if($TPL_V1["tax"]=='exempt'){?>selected<?php }?>>비과세</option>
				</select>
			</td>
			<td class="center"><input type='text' name="summary[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["summary"]?>" style="width:95%;" class="summary" apply_type="summary<?php echo $TPL_V1["goods_seq"]?>"></td>

		</tr>
		<tr class="order-list-summary-row hide">
			<td colspan="10" class="order-list-summary-row-td option_info_td"><div class="option_info"></div></td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" colspan="10">
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