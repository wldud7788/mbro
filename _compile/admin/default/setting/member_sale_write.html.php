<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/setting/member_sale_write.html 000036214 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_data_1=empty($TPL_VAR["data"])||!is_array($TPL_VAR["data"])?0:count($TPL_VAR["data"]);?>
<script type="text/javascript" src="/app/javascript/js/admin/gCategorySelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gGoodsSelectList.js?mm=<?php echo date('Ymd')?>"></script>

<!-- 회원설정 : 등급 -->
<script type="text/javascript">
$(document).ready(function() {
	$(".categoryList .btn_minus").on("click",function(){
			gCategorySelect.select_delete('minus',$(this));
		});
		
		//선택삭제
		$(".select_goods_del").on("click",function(){
			gGoodsSelect.select_delete('chk',$(this));
		});

		// 상품선택
		$(".btn_select_goods").on("click",function(){
			
			var params = {
						'goodsNameStrCut':30,
						'select_goods':$(this).attr("data-goodstype"),
						'selector':this,
						'service_h_ad':window.Firstmall.Config.Environment.serviceLimit.H_AD
						};
			gGoodsSelect.open(params);

		});

		// 카테고리 선택
		$(".btn_category_select").on("click",function(){
			var params = {
						'select_category':$(this).attr("data-categoryType"),
						'selector':this
						};
			gCategorySelect.open(params);
		});	


	$("button[name='submit_btn']").click(function(){
		$("#gradefrm").submit();
	});

	$("form#gradefrm button#exceptIssueGoodsButton").bind("click",function(){
		//if($("input:radio[name='point_use']:checked").val()=='N') return;
		set_goods_list("exceptIssueGoodsSelect","exceptIssueGoods");
	});
	$("#exceptIssueGoods").sortable();
	$("#exceptIssueGoods").disableSelection();

	// SALE
	$("form#gradefrm button#issueGoodsButton").bind("click",function(){
		//if($("input:radio[name='sale_use']:checked").val()=='N') return;
		set_goods_list("issueGoodsSelect","issueGoods");
	});

	$("button[name='cancel_btn']").bind("click",function(){
		closeDialog('gradePopup');
	});

	$("#issueGoods").sortable();
	$("#issueGoods").disableSelection();	
	

});


function calcu_month(){
	var start_month		= $("select[name='start_month']").val();
	var chg_term		= $("select[name='chg_term']").val();
	var chg_day			= $("select[name='chg_day']").val();
	var chk_term		= $("select[name='chk_term']").val();
	var keep_term		= $("select[name='keep_term']").val();
	var chg_text		= "";
	var chk_text		= "";
	var keep_text		= "";
	var month			= 0;
	var for_type		= 0;
	month = (start_month=='13') ? 1 : parseInt(start_month);
	for_type = Math.round(12/parseInt(chg_term));
	for(var i=0;i<for_type;i++){
		if(i!=0){
			month = chg_month('calcu', month, chg_term, 0);
		}
		chg_text += month+"월 "+chg_day+"일<br>";

		var chk_month = chg_month('chk', month, chk_term, 1);
		var chk_month2 = chg_month('chk', (parseInt(month)+parseInt(chk_term)), chk_term, 0);
		chk_text += chk_month+"월 01일 ~ "+chk_month2+"월 31일<br>";

		var keep_month	= chg_month('add', month, keep_term, 0);
		var keep_day	= (chg_day=='1') ? '31' : '14';
		keep_text += month+"월 "+chg_day+"일 ~ "+keep_month+"월 "+keep_day+"일<br>";
	}
	$("#chg_text").html(chg_text);
	$("#chk_text").html(chk_text);
	$("#keep_text").html(keep_text);
}

function chg_month(type, month, alpha, prev){
	var r_month = 0;
	if(type=='add'){
		r_month = parseInt(month) + parseInt(alpha);
		r_month = r_month - 1;
		if(r_month>12) r_month = r_month - 12;
	}else if(type=='chk'){
		r_month = parseInt(month) - parseInt(alpha) - 1;
		r_month = r_month + prev;
		if(r_month<1) r_month = 12 + r_month;
	}else if(type=='calcu'){
		r_month = parseInt(month) + parseInt(alpha);
		if(r_month>12) r_month = r_month - 12;
	}
	return r_month;
}

function set_goods_list(displayId,inputGoods){
	$.ajax({
		type: "get",
		url: "../goods/select",
		data: "page=1&inputGoods="+inputGoods+"&displayId="+displayId,
		success: function(result){
			$("div#"+displayId).html(result);
		}
	});
	openDialog("상품 검색", displayId, {"width":"1000","height":"700","show" : "fade","hide" : "fade"});
}

function span_controller(name, seq){
	var reserve_y = $("span[name='"+name+"_y["+seq+"]']");
	var reserve_d = $("span[name='"+name+"_d["+seq+"]']");
	var value = $("select[name='"+name+"_select["+seq+"]'] option:selected").val();
	if(value==""){
		reserve_y.hide();
		reserve_d.hide();
	}else if(value=="year"){
		reserve_y.show();
		reserve_d.hide();
	}else if(value=="direct"){
		reserve_y.hide();
		reserve_d.show();
	}
}

</script>
<div class="content">
<form name="gradefrm" id="gradefrm" method="post" target="actionFrame" action="../setting_process/member_sale_write">
<div>
<table class="table_basic fix" style="overflow-x:scroll;">
<col width="100px" /><col width="100px" /><?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?><col /><?php }}?>
<tr>
	<th>세트명</td>
	<td colspan="<?php echo $TPL_VAR["gcount"]+ 1?>">
	<input type="text" name="sale_title" value="<?php echo $TPL_VAR["sale_title"]?>" size="80" title="할인율 타이틀" >
	<label class="hide"><input type="checkbox" name="defualt_yn" value="y" checked="checked"> 이 세트를 기본값으로 사용</label>
	<!--
	<label><input type="checkbox" name="defualt_yn" value="y" <?php if($TPL_VAR["defualt_yn"]=="y"){?>checked<?php }?>> 이 세트를 기본값으로 사용</label>
	-->
	</td>
</tr>
<tr>
	<th rowspan="2" colspan="2">세트종류</th>
	<th colspan="<?php echo $TPL_VAR["gcount"]?>">등급</th>
</tr>
<tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<th><?php echo $TPL_V1["group_name"]?></th>
<?php }}?>
</tr>
<?php if($TPL_VAR["data"]){?>
<?php if($TPL_data_1){foreach($TPL_VAR["data"] as $TPL_V1){?>
<input type="hidden" name="sale_seq" value="<?php echo $TPL_V1["sale_seq"]?>">
<tr>
	<th class="center" rowspan="4">추가할인</th>
	<th class="center">
		조건
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip16')"></span>
	</th>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td>
		<div class="resp_radio col">
			<label><input type="radio" name="sale_use[<?php echo $TPL_V2["group_seq"]?>]" value="N" <?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_use"]=="N"||$TPL_V1[$TPL_V2["group_seq"]]["sale_use"]==""||$TPL_V2["group_seq"]== 0){?>checked<?php }?>> 조건없음</label>			
			<span <?php if($TPL_V2["group_seq"]== 0){?>class="hide"<?php }?>>
			<br>
			<label><input type="radio" name="sale_use[<?php echo $TPL_V2["group_seq"]?>]" value="Y" <?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_use"]=="Y"&&$TPL_V2["group_seq"]!= 0){?>checked<?php }?>>
			<input type="text" name="sale_limit_price[<?php echo $TPL_V2["group_seq"]?>]" class="line onlyfloat right" size="6" value="<?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_limit_price"]?>"/><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상 구매
			</span>
		</div>
	</td>
<?php }}?>
</tr>
<tr>
	<th class="center">
		할인 
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip17')"></span>
	</th>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td>
		<input type="text" name="sale_price[<?php echo $TPL_V2["group_seq"]?>]" class="line onlyfloat right" size="6" value="<?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_price"]){?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_price"]?><?php }else{?>0<?php }?>"/>
		<select name="sale_price_type[<?php echo $TPL_V2["group_seq"]?>]">
			<option value="<?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>" <?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_price_type"]==$TPL_VAR["basic_currency"]){?>selected<?php }?>><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?></option>
			<option value="PER" <?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_price_type"]=="PER"){?>selected<?php }?>>%</option>
		</select> 할인</span>
	</td>
<?php }}?>
</tr>
<tr>
	<th class="center">
		추가옵션 
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip18')"></span>
	</th>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td>
		<input type="text" name="sale_option_price[<?php echo $TPL_V2["group_seq"]?>]" class="line onlyfloat right" size="6" value="<?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_option_price"]){?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_option_price"]?><?php }else{?>0<?php }?>"/>
		<select name="sale_option_price_type[<?php echo $TPL_V2["group_seq"]?>]">
			<option value="<?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>" <?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_option_price_type"]==$TPL_VAR["basic_currency"]){?>selected<?php }?>><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?></option>
			<option value="PER" <?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_option_price_type"]=="PER"){?>selected<?php }?>>%</option>
		</select> 할인</span>
	</td>
<?php }}?>
</tr>
<tr>
	<th class="center">예외</th>
	<td colspan="<?php echo $TPL_VAR["gcount"]?>" class="clear">
		<table class="table_basic thl v3">									
			<tbody>
				<tr>
					<th>상품</th>								
					<td>
						<input type="button" value="상품 선택" class="btn_select_goods resp_btn active" data-goodstype='issueGoods' />
						<span class="span_select_goods_del <?php if(count($TPL_V1["issuegoods_sale"])== 0){?>hide<?php }?>"><input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" selectType="goods" /></span>
						<div class="mt10 wx600 <?php if(count($TPL_V1["issuegoods_sale"])== 0){?>hide<?php }?>">
							<div class="goods_list_header">
								<table class="table_basic tdc">
									<colgroup>
										<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
										<col width="25%" />
										<col width="45%" />
<?php }else{?>
										<col width="70%" />
<?php }?>

										<col width="20%" />
									</colgroup>
									<tbody>
										<tr>
										<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" onClick="gGoodsSelect.checkAll(this)" value="goods"></label></th>
<?php if(serviceLimit('H_AD')){?>
										<th>입점사명</th>
<?php }?>
										<th>상품명</th>
										<th>판매가</th>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="goods_list">
								<table class="table_basic tdc">
									<colgroup>
										<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
										<col width="25%" />
										<col width="45%" />
<?php }else{?>
										<col width="70%" />
<?php }?>
										<col width="20%" />
									</colgroup>
									<tbody>
										<tr rownum=0 <?php if(count($TPL_V1["issuegoods_sale"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
											<td class="center" colspan="4">상품을 선택하세요</td>
										</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->
										
<?php if(is_array($TPL_R2=$TPL_V1["issuegoods"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["type"]=='sale'){?>
										<tr rownum="<?php echo $TPL_V2["goods_seq"]?>">
											<td><label class="resp_checkbox"><input type="checkbox" name='issueGoodsTmp[]' class="chk" value='<?php echo $TPL_V2["goods_seq"]?>' /></label>
												<input type="hidden" name='issueGoods[]' class="chk" value='<?php echo $TPL_V2["goods_seq"]?>' />
												<input type="hidden" name="issueGoodsSeq[<?php echo $TPL_V2["goods_seq"]?>]" value="<?php echo $TPL_V2["issuegoods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
												<td><?php echo $TPL_V2["provider_name"]?></td>
<?php }?>
											<td class='left'>
												<div class="image"><img src="<?php echo viewImg($TPL_V2["goods_seq"],'thumbView')?>" width="50"></div>
												<div class="goodsname">
<?php if($TPL_V2["goods_code"]){?><div>[상품코드:<?php echo $TPL_V2["goods_code"]?>]</div><?php }?>
													<div><?php echo $TPL_V2["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V2["goods_seq"]?>" target="_blank">[<?php echo $TPL_V2["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V2["goods_name"]), 30)?></a></div>
												</div>
											</td>
											<td class='right'><?php echo get_currency_price($TPL_V2["price"], 2)?></td>
										</tr>
<?php }?>
<?php }}?>
									</tbody>
								</table>
							</div>
						</div>	
					</td>
				</tr>
				
				<tr>
					<th>카테고리</th>	
					<td class="categoryList">						
						<input type="button" value="카테고리 선택" class="btn_category_select resp_btn active" />								
							<div class="mt10 wx600 category_list  <?php if(count($TPL_V1["issuecategorys_sale"])== 0){?>hide<?php }?>">
								<table class="table_basic fix">
									<colgroup>
										<col width="85%" />
										<col width="15%" />
									</colgroup>
									<thead>
										<tr class="nodrag nodrop">
											<th>카테고리명</th>
											<th>삭제</th>	
										</tr>
									</thead>
									<tbody>
										<tr rownum=0 <?php if(count($TPL_V1["issuecategorys_sale"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
											<td class="center" colspan="2">카테고리를 선택하세요</td>
										</tr>													
<?php if(is_array($TPL_R2=$TPL_V1["issuecategorys"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["type"]=='sale'){?>
										<tr rownum="<?php echo $TPL_V2["category_code"]?>">
											<td class="center"><?php echo $TPL_V2["title"]?></td>
											<td class="center">
												<input type="hidden" name='issueCategoryCode[]' value='<?php echo $TPL_V2["category_code"]?>' />
												<input type="hidden" name="issueCategoryCodeSeq[<?php echo $TPL_V2["category_code"]?>]" value="<?php echo $TPL_V2["issuecategory_seq"]?>" />
												<button type="button" class="btn_minus"  selectType="category" category_seq="<?php echo $TPL_V2["category_code"]?>"></button>
											</td>
										</tr>
<?php }?>
<?php }}?>
									</tbody>
								</table>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>		
	</td>
</tr>

<tr>
	<th rowspan="4" class="center">추가적립</th>
	<th class="center">
		조건 
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip19')"></span>
	</th>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td>
		<div class="resp_radio col">
			<label><input type="radio" name="point_use[<?php echo $TPL_V2["group_seq"]?>]" value="N" <?php if($TPL_V1[$TPL_V2["group_seq"]]["point_use"]=="N"||$TPL_V1[$TPL_V2["group_seq"]]["point_use"]==""||$TPL_V2["group_seq"]== 0){?>checked<?php }?>> 조건없음</label>		
			<span <?php if($TPL_V2["group_seq"]== 0){?>class="hide"<?php }?>>
				<br>
				<label><input type="radio" name="point_use[<?php echo $TPL_V2["group_seq"]?>]" value="Y" <?php if($TPL_V1[$TPL_V2["group_seq"]]["point_use"]=="Y"&&$TPL_V2["group_seq"]!= 0){?>checked<?php }?>>
				<input type="text" name="point_limit_price[<?php echo $TPL_V2["group_seq"]?>]" class="line onlyfloat right" size="6" value="<?php echo $TPL_V1[$TPL_V2["group_seq"]]["point_limit_price"]?>"/><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상 구매
			</span>
		</div>
	</td>
<?php }}?>
</tr>
<tr>
	<th class="center">
		포인트 
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip20')"></span>
	</th>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td>
		 <input <?php if($TPL_V2["group_seq"]== 0){?>disabled="disabled"<?php }?> type="text" name="point_price[<?php echo $TPL_V2["group_seq"]?>]" class="line onlyfloat right" size="6" value="<?php echo $TPL_V1[$TPL_V2["group_seq"]]["point_price"]?>" <?php if($TPL_VAR["reserve"]["point_use"]!="Y"){?>disabled<?php }?>/><input type="hidden" name="point_price_type[<?php echo $TPL_V2["group_seq"]?>]"  value="PER">%
		<!--select name="point_select[<?php echo $TPL_V2["group_seq"]?>]" onchange="span_controller('point', '<?php echo $TPL_V2["group_seq"]?>');">
			<option value="">제한없음</option>
			<option value="year" <?php if($TPL_V1[$TPL_V2["group_seq"]]["point_select"]=='year'){?>selected<?php }?>>제한 - 12월31일</option>
			<option value="direct" <?php if($TPL_V1[$TPL_V2["group_seq"]]["point_select"]=='direct'){?>selected<?php }?>>제한 - 직접입력</option>
		</select>
		<span name="point_y[<?php echo $TPL_V2["group_seq"]?>]" class="hide"><br>→ 지급연도 + <input type="text" name="point_year[<?php echo $TPL_V2["group_seq"]?>]" class="line onlynumber" style="text-align:right" size="3" maxlength='3'  value="<?php echo $TPL_V1[$TPL_V2["group_seq"]]["point_year"]?>" />년 12월 31일</span>
		<span name="point_d[<?php echo $TPL_V2["group_seq"]?>]" class="hide"><br>→ <input type="text" name="point_direct[<?php echo $TPL_V2["group_seq"]?>]" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_V1[$TPL_V2["group_seq"]]["point_direct"]?>" />개월</span-->
	</td>
<?php }}?>
</tr>
<tr>
	<th class="center">
		마일리지 
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip21')"></span>
	</th>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td>
		 <input <?php if($TPL_V2["group_seq"]== 0){?>disabled="disabled"<?php }?> type="text" name="reserve_price[<?php echo $TPL_V2["group_seq"]?>]" class="line onlyfloat right" size="6" value="<?php echo $TPL_V1[$TPL_V2["group_seq"]]["reserve_price"]?>"/><input type="hidden" name="reserve_price_type[<?php echo $TPL_V2["group_seq"]?>]" value="PER">%
		<!--select name="reserve_select[<?php echo $TPL_V2["group_seq"]?>]" onchange="span_controller('reserve', '<?php echo $TPL_V2["group_seq"]?>');">
			<option value="">제한없음</option>
			<option value="year" <?php if($TPL_V1[$TPL_V2["group_seq"]]["reserve_select"]=='year'){?>selected<?php }?>>제한 - 12월31일</option>
			<option value="direct" <?php if($TPL_V1[$TPL_V2["group_seq"]]["reserve_select"]=='direct'){?>selected<?php }?>>제한 - 직접입력</option>
		</select>
		<span name="reserve_y[<?php echo $TPL_V2["group_seq"]?>]" class="hide"><br>→ 지급연도 + <input type="text" name="reserve_year[<?php echo $TPL_V2["group_seq"]?>]" class="line onlynumber" style="text-align:right" size="3" maxlength='3'  value="<?php echo $TPL_V1[$TPL_V2["group_seq"]]["reserve_year"]?>" />년 12월 31일</span>
		<span name="reserve_d[<?php echo $TPL_V2["group_seq"]?>]" class="hide"><br>→ <input type="text" name="reserve_direct[<?php echo $TPL_V2["group_seq"]?>]" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_V1[$TPL_V2["group_seq"]]["reserve_direct"]?>" />개월</span-->
	</td>
<?php }}?>
</tr>
<tr>
	<th class="center">예외</th>
	<td colspan="<?php echo $TPL_VAR["gcount"]?>" class="clear">
		<table class="table_basic thl v3">									
			<tbody>
				<tr>
					<th>상품</th>								
					<td>
						<input type="button" value="상품 선택" class="btn_select_goods resp_btn active" data-goodstype='exceptIssueGoods' />
						<span class="span_select_goods_del <?php if(count($TPL_V1["issuegoods_emoney"])== 0){?>hide<?php }?>"><input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" selectType="goods" /></span>
						<div class="mt10 wx600 <?php if(count($TPL_V1["issuegoods_emoney"])== 0){?>hide<?php }?>">
							<div class="goods_list_header">
								<table class="table_basic tdc">
									<colgroup>
										<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
										<col width="25%" />
										<col width="45%" />
<?php }else{?>
										<col width="70%" />
<?php }?>

										<col width="20%" />
									</colgroup>
									<tbody>
										<tr>
										<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" onClick="gGoodsSelect.checkAll(this)" value="goods"></label></th>
<?php if(serviceLimit('H_AD')){?>
										<th>입점사명</th>
<?php }?>
										<th>상품명</th>
										<th>판매가</th>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="goods_list">
								<table class="table_basic tdc">
									<colgroup>
										<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
										<col width="25%" />
										<col width="45%" />
<?php }else{?>
										<col width="70%" />
<?php }?>
										<col width="20%" />
									</colgroup>
									<tbody>
										<tr rownum=0 <?php if(count($TPL_V1["issuegoods_emoney"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
											<td class="center" colspan="4">상품을 선택하세요</td>
										</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->										
<?php if(is_array($TPL_R2=$TPL_V1["issuegoods"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["type"]=='emoney'){?>
										<tr rownum="<?php echo $TPL_V2["goods_seq"]?>">
											<td><label class="resp_checkbox"><input type="checkbox" name='exceptIssueGoodsTmp[]' class="chk" value='<?php echo $TPL_V2["goods_seq"]?>' /></label>
												<input type="hidden" name='exceptIssueGoods[]' class="chk" value='<?php echo $TPL_V2["goods_seq"]?>' />
												<input type="hidden" name="exceptIssueGoodsSeq[<?php echo $TPL_V2["goods_seq"]?>]" value="<?php echo $TPL_V2["issuegoods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
												<td><?php echo $TPL_V2["provider_name"]?></td>
<?php }?>
											<td class='left'>
												<div class="image"><img src="<?php echo viewImg($TPL_V2["goods_seq"],'thumbView')?>" width="50"></div>
												<div class="goodsname">
<?php if($TPL_V2["goods_code"]){?><div>[상품코드:<?php echo $TPL_V2["goods_code"]?>]</div><?php }?>
													<div><?php echo $TPL_V2["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V2["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V2["goods_name"]), 30)?></a></div>
												</div>
											</td>
											<td class='right'><?php echo get_currency_price($TPL_V2["price"], 2)?></td>
										</tr>
<?php }?>
<?php }}?>
									</tbody>
								</table>
							</div>
						</div>	
					</td>
				</tr>
				<tr>
					<th>카테고리</th>	
					<td class="categoryList">
						<input type="button" value="카테고리 선택" class="btn_category_select resp_btn active" data-categoryType='exceptIssueCategoryCode'/>								
							<div class="mt10 wx600 category_list  <?php if(count($TPL_V1["issuecategorys_emoney"])== 0){?>hide<?php }?>">
								<table class="table_basic fix">
									<colgroup>
										<col width="85%" />
										<col width="15%" />
									</colgroup>
									<thead>
										<tr class="nodrag nodrop">
											<th>카테고리명</th>
											<th>삭제</th>	
										</tr>
									</thead>
									<tbody>
										<tr rownum=0 <?php if(count($TPL_V1["issuecategorys_emoney"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
											<td class="center" colspan="2">카테고리를 선택하세요</td>
										</tr>													
<?php if(is_array($TPL_R2=$TPL_V1["issuecategorys"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["type"]=='emoney'){?>
										<tr rownum="<?php echo $TPL_V2["category_code"]?>">
											<td class="center"><?php echo $TPL_V2["title"]?></td>
											<td class="center">
												<input type="hidden" name='exceptIssueCategoryCode[]' value='<?php echo $TPL_V2["category_code"]?>' />
												<input type="hidden" name="exceptIssueCategoryCodeSeq[<?php echo $TPL_V2["category_code"]?>]" value="<?php echo $TPL_V1["issuecategory_seq"]?>" />
												<button type="button" class="btn_minus"  selectType="category" category_seq="<?php echo $TPL_V2["category_code"]?>"></button>
											</td>
										</tr>
<?php }?>
<?php }}?>
									</tbody>
								</table>
							</div>
						</div>
					</td>
				</tr>				
			</tbody>
		</table>	
	</td>
</tr>
<?php }}?>

<?php }else{?>

<tr>
	<th class="center" rowspan="4">추가할인</th>
	<th class="center" >
		조건
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip16')"></span>
	</th>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<td>
		<div class="resp_radio col">
			<label><input type="radio" name="sale_use[<?php echo $TPL_V1["group_seq"]?>]" value="N" checked> 조건없음</label>		
			<label><input type="radio" name="sale_use[<?php echo $TPL_V1["group_seq"]?>]" value="Y">
			<input type="text" name="sale_limit_price[<?php echo $TPL_V1["group_seq"]?>]" class="line onlyfloat right" size="6" value=""/><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상 구매
		</div>
	</td>
<?php }}?>
</tr>
<tr>
	<th class="center">
		할인 
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip17')"></span>
	</th>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<td>
		<input type="text" name="sale_price[<?php echo $TPL_V1["group_seq"]?>]" class="line onlyfloat right" size="6" value=""/>
		<select name="sale_price_type[<?php echo $TPL_V1["group_seq"]?>]">
			<option value="<?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>"><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?></option>
			<option value="PER" selected>%</option>
		</select> 할인</span>
	</td>
<?php }}?>
</tr>
<tr>
	<th class="center">
		추가옵션
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip18')"></span>
	</th>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<td>
		<input type="text" name="sale_option_price[<?php echo $TPL_V1["group_seq"]?>]" class="line onlyfloat right" size="6" value=""/>
		<select name="sale_option_price_type[<?php echo $TPL_V1["group_seq"]?>]">
			<option value="<?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>"><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?></option>
			<option value="PER" selected>%</option>
		</select> 할인</span>
	</td>
<?php }}?>
</tr>
<tr>
	<th class="center">예외</th>
	<td colspan="<?php echo $TPL_VAR["gcount"]?>" class="clear">
		<table class="table_basic thl v3">									
			<tbody>
				<tr>
					<th>상품</th>								
					<td>
						<input type="button" value="상품 선택" class="btn_select_goods resp_btn active" data-goodstype='issueGoods' />
						<span class="span_select_goods_del hide"><input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" selectType="goods" /></span>
						<div class="mt10 wx600 hide">
							<div class="goods_list_header">
								<table class="table_basic tdc">
									<colgroup>
										<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
										<col width="25%" />
										<col width="45%" />
<?php }else{?>
										<col width="70%" />
<?php }?>

										<col width="20%" />
									</colgroup>
									<tbody>
										<tr>
										<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" onClick="gGoodsSelect.checkAll(this)" value="goods"></label></th>
<?php if(serviceLimit('H_AD')){?>
										<th>입점사명</th>
<?php }?>
										<th>상품명</th>
										<th>판매가</th>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="goods_list">
								<table class="table_basic tdc">
									<colgroup>
										<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
										<col width="25%" />
										<col width="45%" />
<?php }else{?>
										<col width="70%" />
<?php }?>
										<col width="20%" />
									</colgroup>
									<tbody>
										<tr rownum=0>
											<td class="center" colspan="4">상품을 선택하세요</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>	
					</td>
				</tr>
				
				<tr>
					<th>카테고리</th>	
					<td class="categoryList">						
						<input type="button" value="카테고리 선택" class="btn_category_select resp_btn active" />								
							<div class="mt10 wx600 category_list hide">
								<table class="table_basic fix">
									<colgroup>
										<col width="85%" />
										<col width="15%" />
									</colgroup>
									<thead>
										<tr class="nodrag nodrop">
											<th>카테고리명</th>
											<th>삭제</th>	
										</tr>
									</thead>
									<tbody>
										<tr rownum=0>
											<td class="center" colspan="2">카테고리를 선택하세요</td>
										</tr>								
									</tbody>
								</table>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>		
	</td>
</tr>

<tr>
	<th rowspan="4" class="center">추가적립</th>
	<th class="center">
		조건 
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip19')"></span>
	</th>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<td>
		<div class="resp_radio col">
			<label><input type="radio" name="point_use[<?php echo $TPL_V1["group_seq"]?>]" value="N" checked> 조건없음</label>	
			<label><input type="radio" name="point_use[<?php echo $TPL_V1["group_seq"]?>]" value="Y">
			<input type="text" name="point_limit_price[<?php echo $TPL_V1["group_seq"]?>]" class="line onlyfloat right" size="6" value=""/><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상 구매
		</div>
	</td>
<?php }}?>
</tr>
<tr>
	<th class="center">
		포인트 
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip20')"></span>
	</th>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<td>
		 <input type="text" name="point_price[<?php echo $TPL_V1["group_seq"]?>]" class="line onlyfloat right" size="6" value="" <?php if($TPL_VAR["reserve"]["point_use"]!="Y"){?>disabled<?php }?>/><input type="hidden" name="point_price_type[<?php echo $TPL_V1["group_seq"]?>]" value="PER">%
		<!--select name="point_select[<?php echo $TPL_V1["group_seq"]?>]" onchange="span_controller('point', '<?php echo $TPL_V1["group_seq"]?>');">
			<option value="">제한없음</option>
			<option value="year" <?php if($TPL_VAR["data"]["point_select"]=='year'){?>selected<?php }?>>제한 - 12월31일</option>
			<option value="direct" <?php if($TPL_VAR["data"]["point_select"]=='direct'){?>selected<?php }?>>제한 - 직접입력</option>
		</select>
		<span name="point_y[<?php echo $TPL_V1["group_seq"]?>]" class="hide"><br>→ 지급연도 + <input type="text" name="point_year[<?php echo $TPL_V1["group_seq"]?>]" class="line onlynumber" style="text-align:right" size="3" maxlength='3'  value="" />년 12월 31일</span>
		<span name="point_d[<?php echo $TPL_V1["group_seq"]?>]" class="hide"><br>→ <input type="text" name="point_direct[<?php echo $TPL_V1["group_seq"]?>]" class="line onlynumber" style="text-align:right" size="3" value="" />개월</span-->
	</td>
<?php }}?>
</tr>
<tr>
	<th class="center">
		마일리지 
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip21')"></span>
	</th>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<td>
		 <input type="text" name="reserve_price[<?php echo $TPL_V1["group_seq"]?>]" class="line onlyfloat right" size="6" value="" /><input type="hidden" name="reserve_price_type[<?php echo $TPL_V1["group_seq"]?>]" value="PER">%
		<!--select name="reserve_select[<?php echo $TPL_V1["group_seq"]?>]" onchange="span_controller('reserve', '<?php echo $TPL_V1["group_seq"]?>');">
			<option value="">제한없음</option>
			<option value="year" >제한 - 12월31일</option>
			<option value="direct" >제한 - 직접입력</option>
		</select>
		<span name="reserve_y[<?php echo $TPL_V1["group_seq"]?>]" class="hide"><br>→ 지급연도 + <input type="text" name="reserve_year[<?php echo $TPL_V1["group_seq"]?>]" class="line onlynumber" style="text-align:right" size="3" maxlength='3'  value="" />년 12월 31일</span>
		<span name="reserve_d[<?php echo $TPL_V1["group_seq"]?>]" class="hide"><br>→ <input type="text" name="reserve_direct[<?php echo $TPL_V1["group_seq"]?>]" class="line onlynumber" style="text-align:right" size="3" value="" />개월</span-->
	</td>
<?php }}?>
</tr>
<tr>
	<th class="center">예외</th>
	<td colspan="<?php echo $TPL_VAR["gcount"]?>" class="clear">
		<table class="table_basic thl v3">									
			<tbody>
				<tr>
					<th>상품</th>								
					<td>
						<input type="button" value="상품 선택" class="btn_select_goods resp_btn active" data-goodstype='exceptIssueGoods' />
						<span class="span_select_goods_del hide"><input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" selectType="goods" /></span>
						<div class="mt10 wx600 hide">
							<div class="goods_list_header">
								<table class="table_basic tdc">
									<colgroup>
										<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
										<col width="25%" />
										<col width="45%" />
<?php }else{?>
										<col width="70%" />
<?php }?>

										<col width="20%" />
									</colgroup>
									<tbody>
										<tr>
										<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" onClick="gGoodsSelect.checkAll(this)" value="goods"></label></th>
<?php if(serviceLimit('H_AD')){?>
										<th>입점사명</th>
<?php }?>
										<th>상품명</th>
										<th>판매가</th>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="goods_list">
								<table class="table_basic tdc">
									<colgroup>
										<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
										<col width="25%" />
										<col width="45%" />
<?php }else{?>
										<col width="70%" />
<?php }?>
										<col width="20%" />
									</colgroup>
									<tbody>
										<tr rownum=0>
											<td class="center" colspan="4">상품을 선택하세요</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>	
					</td>
				</tr>
				<tr>
					<th>카테고리</th>	
					<td class="categoryList">
						<input type="button" value="카테고리 선택" class="btn_category_select resp_btn active" data-categoryType='exceptIssueCategoryCode'/>								
							<div class="mt10 wx600 category_list hide">
								<table class="table_basic fix">
									<colgroup>
										<col width="85%" />
										<col width="15%" />
									</colgroup>
									<thead>
										<tr class="nodrag nodrop">
											<th>카테고리명</th>
											<th>삭제</th>	
										</tr>
									</thead>
									<tbody>
										<tr rownum=0>
											<td class="center" colspan="2">카테고리를 선택하세요</td>
										</tr>													
								
									</tbody>
								</table>
							</div>
						</div>
					</td>
				</tr>				
			</tbody>
		</table>	

	</td>
</tr>
<?php }?>

</table>
</div>
</form>
</div>

<div class="footer">
	<button name="submit_btn" class="submit_btn resp_btn active size_XL">저장</button> 
	<button id="cancel_btn" name="cancel_btn" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">취소</button>
</div>

<div id="lay_goods_select"></div><!-- 상품선택 레이어 -->
<div id="lay_category_select"></div><!-- 카테고리 선택 레이어 -->