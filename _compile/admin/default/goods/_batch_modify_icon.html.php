<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_icon.html 000010876 */ 
$TPL_r_goods_icon_1=empty($TPL_VAR["r_goods_icon"])||!is_array($TPL_VAR["r_goods_icon"])?0:count($TPL_VAR["r_goods_icon"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
	$(document).ready(function() {
		// 아이콘 일괄변경
		$("#btn_all_icon").bind("click",function(){
			change_all_checkbox('batch_icon','input_icon');
		});

		/* 아이콘 개별삭제 */
		$(".iconViewTable button.iconDel").live("click",function(){
			if(!confirm("정말로 아이콘을 삭제하시겠습니까?")) return;
			var goods_seq = $(this).attr('goods_seq');
			var icon_seq = $(this).attr('icon_seq');
			$.ajax({
				type: "get",
				url: "../goods_process/goods_icon_del",
				data: "icon_seq="+icon_seq+"&goods_seq="+goods_seq,
				success: function(result){
					if(result){
						if( $("#iconViewTable_"+goods_seq+" tbody tr").length > 0) {
							$("#iconViewTable_"+goods_seq+"_"+icon_seq).remove();
						}
						alert('이 상품의 아이콘을 정상적으로 삭제하였습니다.');
					}else{
						alert('상품의 아이콘 삭제가 실패하였습니다.');
						return false;
					}
				}
			});
		});


		$(".iconstartDate").addClass('datepicker');
		$(".iconendDate").addClass('datepicker');
		setDatepicker();


		$("#batch_iconstartDate").addClass('datepicker');
		setDatepicker($("#batch_iconstartDate"));
		$("#batch_iconendDate").addClass('datepicker');
		setDatepicker($("#batch_iconendDate"));


	});


	function change_all_checkbox(input_class_name,class_name)
	{
		$("." + class_name).each(function(){
			if( $(this).parent().parent().parent().parent().parent().parent().find("input[name='goods_seq[]']").attr("checked") == 'checked' ){
				$(this).attr('checked',false);
			}
		});

		$("." + input_class_name).each(function(){
			var batch_obj = $(this);
			if(batch_obj.attr('checked') == 'checked'){
				$("." + class_name).each(function(){
					if( $(this).parent().parent().parent().parent().parent().parent().find("input[name='goods_seq[]']").attr("checked") == 'checked' ){
						if( $(this).val() == batch_obj.val() ){
							$(this).attr('checked',true);
						}
					}
				});
			}
		});
	}
</script>

<br class="table-gap" />
<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="15%" /><!--대상 상품-->
		<col/><!--아래와 같이 업데이트-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th>대상 상품</th>
		<th>아이콘을 아래와 같이 업데이트  </th>
	</tr>
	</thead>

	<tbody class="ltb">
		<tr class="list-row" style="height:70px;">
			<td align="center" class="td">
			검색된 상품에서  →
			<select name="modify_list"  class="modify_list">
				<option value="choice">선택 </option>
				<option value="all">전체 </option>
			</select>
			</td>
			<td class="pdt20 pdb20">
				<div class="mb20">
					<label><input type="radio" name="modify_means" value="add" checked/> 기존 아이콘 그대로 두고 추가</label>
					<label><input type="radio" name="modify_means" value="delete"/> 기존 아이콘은 삭제하고 추가</label>
				</div>
				<table width="100%" cellpadding="0"  cellspacing="0" style="border:0px;">
				<colgroup>
					<col width="50%" />
					<col width="10%" />
					<col  />
				</colgroup>
				<tr>
					<td style="border-bottom:none">[아이콘 선택] : 다중 선택 가능
					<span style="display:inline-block;width:100%">
					<ul>
<?php if($TPL_r_goods_icon_1){foreach($TPL_VAR["r_goods_icon"] as $TPL_V1){?>
					<li style="float:left;width:100px;height:20px;text-align:left;overflow:hidden;margin-left:10px;">
						<label>
						<NOBR>
						<input type="checkbox" name="batch_goodsIconCode[<?php echo $TPL_V1["codecd"]?>]" value="<?php echo $TPL_V1["codecd"]?>" class="batch_icon" />
						<img src="/data/icon/goods/<?php echo $TPL_V1["codecd"]?>.gif" align='absmiddle' height='15' border="0">
						</NOBR>
						</label>
					</li>
<?php }}?>
					</ul>
					</span></td>
					<td style="border-bottom:none">
						선택된 아이콘을
					</td>
					<td style="border-bottom:none">[기간 선택] 미설정 시 노출 지속
					<span style="display:inline-block;width:100%;margin-left:10px;">
					<input type="text" name="batch_iconstartDate" value="" class="line" id="batch_iconstartDate" maxlength="10" size="10" />~
					<input type="text" name="batch_iconendDate" value="" class="line " id="batch_iconendDate"   maxlength="10" size="10" />
					노출한다
					</span></td>
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
		<col width="30" /><!--중요-->
		<col width="40" /><!--번호-->
		<col width="60" /><!--상품이미지-->
		<col  /><!--상품명-->
		<col width="500" /><!--아이콘-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
		<th><span class="icon-star-gray <?php if($TPL_VAR["sc"]["orderby"]=='favorite_chk'&&$TPL_VAR["sc"]["sort"]=='desc'){?>checked<?php }?>" id="order_star"></span></th>
		<th>번호</th>
		<th colspan="2">상품명</th>
		<th>아이콘</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;">
			<td align="center"><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /></td>
			<td align="center"><span class="icon-star-gray star_select <?php echo $TPL_V1["favorite_chk"]?>" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"></span></td>
			<td align="center" class="page_no"><?php echo $TPL_V1["_no"]?></td>
			<td align="center"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a></td>
			<td align="left" style="padding-left:10px;">
<?php if($TPL_V1["tax"]=='exempt'&&$TPL_V1["cancel_type"]=='1'){?>
					<div>
					<span style="color:red;" class="left" >[비과세]</span>
					<span class="order-item-cancel-type left" >[청약철회불가]</span>
					</div>
<?php }elseif($TPL_V1["tax"]=='exempt'){?>
					<div>
					<span style="color:red;" class="left" >[비과세]</span>
					</div>
<?php }elseif($TPL_V1["cancel_type"]=='1'){?>
					<div>
					<span class="order-item-cancel-type left" >[청약철회불가]</span>
					</div>
<?php }?>
<?php if($TPL_V1["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
			<a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo $TPL_V1["goods_name"]?></a> <div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
			</td>
			<td align="center">
				<table class="info-table-style iconViewTable" id="iconViewTable_<?php echo $TPL_V1["goods_seq"]?>" style="width:100%">
				<colgroup>
					<col /><!-- 아이콘 -->
					<col width="50%" /><!-- 노출기간 (미설정 시 노출 지속) -->
					<col width="8%" /><!-- 삭제 -->
				</colgroup>

				<tbody>
<?php if(is_array($TPL_R2=$TPL_V1["icons"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<tr id="iconViewTable_<?php echo $TPL_V1["goods_seq"]?>_<?php echo $TPL_V2["icon_seq"]?>">
						<td class="its-td-align center">
							<img src="/data/icon/goods/<?php echo $TPL_V2["codecd"]?>.gif" border="0" class="goodsIcon hand" align="absmiddle">
						</td>
						<td class="its-td">
							<input type="hidden" name="iconSeq[<?php echo $TPL_V1["goods_seq"]?>][]" value="<?php echo $TPL_V2["icon_seq"]?>" />
							<span>
							<?php echo $TPL_V2["start_date"]?> ~ <?php echo $TPL_V2["end_date"]?>

							</span>
						</td>
						<td class="its-td-align center"><span class="btn-minus"><button type="button" class="iconDel" icon_seq="<?php echo $TPL_V2["icon_seq"]?>"  goods_seq="<?php echo $TPL_V1["goods_seq"]?>" > </button></span></td>
					</tr>
<?php }}?>
				</table>
			</td>
		</tr>
		<tr class="order-list-summary-row hide">
			<td colspan="8" class="order-list-summary-row-td"><div class="option_info"></div></td>
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