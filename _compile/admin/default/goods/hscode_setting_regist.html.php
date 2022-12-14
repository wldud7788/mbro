<?php /* Template_ 2.2.6 2022/02/03 11:56:28 /www/music_brother_firstmall_kr/admin/skin/default/goods/hscode_setting_regist.html 000016860 */ 
$TPL_hscode_items_1=empty($TPL_VAR["hscode_items"])||!is_array($TPL_VAR["hscode_items"])?0:count($TPL_VAR["hscode_items"]);?>
<script type="text/javascript">

$(document).ready(function() {

	$("#hscodeRegistLayer").on("click", ".save_all", function(){
		var id		= $(this).attr("id");
		var value	= $("input[name='"+id+"_all']").val();
		if(id == 'customs_tax'){
			var zone_num = $(this).closest('.zone_text').attr('idx');
			value	= $(this).closest('span.zone_text').find("input[name='"+id+"_all']").val();
			$(".zone"+zone_num).val(value);
		}else{
			$("input[name='"+id+"[]']").val(value);
		}
	});

	$("input[name='hscode_common']").bind("blur",function(){

		var obj = $(this);

		if(obj.val().trim() == '') {
			alert("사용할 공통 코드를 먼저 입력하세요.");
			return false;
		}
		$.ajax({
			type: "get",
			url: "../goods_process/gete_hscode_common",
			data: "hscode_common="+obj.val(),
			success: function(result){
				if(result == 'codenull'){
					openDialogAlert("사용할 공통 코드를 먼저 입력하세요.",400,150);
				}else{
					if(eval(result) > 0){
						obj.val("");
						openDialogAlert("이미 사용중인 공통 코드입니다.",400,150);
					}
				}
			}
		});
		return false;

	});

	$("#hscode_save").bind("click",function(){

		var f = document.hscodeRegistFrm;

		var hscode_name_chk = false;
		$("#hscodeRegistLayer input[name='hscode_name[]']").each(function(){
			if($(this).val() == ''){ 
				openDialogAlert("품명 입력해 주세요.",400,150);
				$(this).focus();
				hscode_name_chk = true;
				return false;
			}
		});
		if(hscode_name_chk) return false;

		var hscode_common_chk = false;
		$("#hscodeRegistLayer input[name='hscode_common[]']").each(function(){
			if($(this).val() == ''){ 
				openDialogAlert("공통 코드를 입력해 주세요.",400,150);
				$(this).focus();
				hscode_common_chk = true;
				return false;
			}
			if($(this).val().length != 6){
				openDialogAlert("공통 코드는 6자리로 입력해 주세요.",400,150);
				$(this).focus();
				hscode_common_chk = true;
				return false;
			}
		});
		if(hscode_common_chk) return false;

		var hscode_nation_chk = false;
		$("#hscodeRegistLayer input[name='hscode_nation[]']").each(function(){
			if($(this).val() == ''){ 
				openDialogAlert("국가별 개별코드를 입력해 주세요.",400,150);
				$(this).focus();
				hscode_nation_chk = true;
				return false;
			}
		});
		if(hscode_nation_chk) return false;

		var customs_tax_chk = false;
		$("#hscodeRegistLayer .customs_tax").each(function(){
			if($(this).val().trim() == ''){ 
				openDialogAlert("세율을 입력해 주세요",400,150);
				$(this).focus();
				customs_tax_chk = true;
				return false;
			}
		});
		if(customs_tax_chk) return false;

		f.submit();

	});
	

});
	
	function nation_duplication_chk(obj){
		
		var trObj = $(obj).closest("tr");
		var nation_key			= trObj.find(".nation_key");
		var export_nation_key	= trObj.find(".export_nation_key");

		var nation_value		= nation_key.val();
		var nation_text			= $("select[name='nation_key[]'] option[value='"+nation_key.val()+"']",trObj).text();

		for(var i=0; i< export_nation_key.length; i++){
	
			var export_nation_value = export_nation_key.eq(i).val();
			var export_nation_text	= $(".export_nation_key option[value='"+export_nation_value+"']",trObj).eq(i).text();

			if(nation_value == export_nation_value){
				openDialogAlert("수입국가["+nation_text+"]와 동일한 수출국가["+export_nation_text+"]로 설정이 불가합니다.",400,170);
				return false;
			}
		}

	}

	// 품명 및 수입국가 추가
	function add_hscode_section(obj,type){

		// 수입국가 추가
		if(type == 'zone'){
			// 수입국가 컬럼
			var sectionHtml	= $(obj).closest("th").clone();
			var last_idx	= $(obj).closest("thead").find(".zone_text").eq(-1).attr('idx');
			var new_idx		= parseInt(last_idx)+1;
			$(sectionHtml).find(".zone_text").attr('idx',new_idx);
			$(sectionHtml).find(".zone_idx_0").removeClass("zone_idx_0").addClass("zone_idx_"+new_idx);

			$(sectionHtml).find("input[type='text']").val('');
			//$(sectionHtml).find(".zone_address_area").html('');
			$(sectionHtml).find(".ctrl-add-btn").removeClass('cyanblue').addClass('red');
			$(sectionHtml).find(".ctrl-btn").text('삭제').attr("onClick", null).click(function(){
				del_hscode_section(this, type);
			});
			$(obj).closest("tr").append(sectionHtml);

			//데이터 셀
			$(obj).closest("table").find("tbody > tr, tfoot > tr").each(function(e){
				var td_idx = 5;
				if(e > 0) td_idx = 3;
				var cellHtml = $(this).find("td").eq(td_idx).clone();
				$(cellHtml).find("input[type='text']").val('');
				$(cellHtml).find(".customs_tax").removeClass("zone0").addClass("zone"+new_idx);
				$(cellHtml).find(".today_idx_0").removeClass("today_idx_0").addClass("today_idx_"+new_idx);
				$(this).append(cellHtml);
			});
			
			$(".th_customs_tax").attr("colspan",$(".zone_text").length);

		// 품명 추가
		}else if(type == 'section'){

			var sectionHtml = $(obj).closest("tr").clone();
			var last_idx	= $(obj).closest("tbody").find("tr").index();
			var row_val		= $(obj).closest("form").find("input[name='hscode_row_length']").val();
			var row_length	= $(obj).closest("tbody").find("tr").length;
			$(obj).closest("form").find("input[name='hscode_row_length']").val(row_length);
			$(obj).closest("tbody").find("tr td.subj").attr("rowspan",eval($(obj).closest("tbody").find("tr").length) + 1);
			$(obj).closest("tbody").find("tr td.code").attr("rowspan",eval($(obj).closest("tbody").find("tr").length) + 1);
			$(sectionHtml).find("td.subj").remove();
			$(sectionHtml).find("td.code").remove();
			$(sectionHtml).find("input[type='text']").val('');
			$(sectionHtml).find(".ctrl-add-btn").removeClass('cyanblue').addClass('red');
			$(sectionHtml).find("input[name='hscode_row[]']").val(row_length);
			$(sectionHtml).find(".export_nation_key").attr("name","export_nation_key["+(row_length)+"][]");
			$(sectionHtml).find(".customs_tax").attr("name","customs_tax["+(row_length)+"][]");
			$(sectionHtml).find(".ctrl-btn").text('삭제').attr("onClick", null).click(function(){
				del_hscode_section(this, type);
			});
			$(obj).closest("tbody").append(sectionHtml);
		}
	}

	// 품명 및 수입국가 삭제
	function del_hscode_section(obj, type){
		if(type == 'zone'){
			// 수입국가 컬럼 index 가져와서 index 맞는 th, td 다 지움
			var objIndex = $(obj).closest("th").index();
			$(obj).closest("table").find("tbody > tr, tfoot > tr").each(function(e){
				if(e == 0){
					$(this).find("td").eq(eval(objIndex)+2).remove();
				}else{
					$(this).find("td").eq(objIndex).remove();
				}
			});
			$(obj).closest("table").find("thead > tr:last-child th").eq(objIndex).remove();
			//$(obj).closest("table").find("tr th:child(1)").eq(objIndex).remove();
			
			$(".th_customs_tax").attr("colspan",$(".zone_text").length);

		}else if(type == 'section'){
			$(obj).closest("tbody").find("tr td.subj").attr("rowspan",eval($(obj).closest("tbody").find("tr").length) - 1);
			$(obj).closest("tbody").find("tr td.code").attr("rowspan",eval($(obj).closest("tbody").find("tr").length) - 1);
			$(obj).closest("tr").remove();
		}
	}


</script>

<style>
	#hscodeRegistLayer table.info-table-style {table-layout:fixed;margin:auto;position:relative;width:auto;}
	/*#hscodeRegistLayer table.info-table-style thead th, 
	#hscodeRegistLayer table.info-table-style tbody td { 
			position:relative;white-space:nowrap;
			border-left:1px solid #000;
	} 
	*/
	#hscodeRegistLayer table tr .subj {width:140px;min-width:140px;}
	#hscodeRegistLayer table tr .code {width:100px;min-width:100px;}
	#hscodeRegistLayer table tr .coladd {width:60px;min-width:60px;}
	#hscodeRegistLayer table tr .nation {width:130px;min-width:130px;}
	#hscodeRegistLayer table tr .nation_code {width:110px;min-width:110px;}
	#hscodeRegistLayer table tr .tax {width:185px;min-width:185px;}
	#hscodeRegistLayer table tr td.subj,#hscodeRegistLayer table tr td.code {vertical-align:top;}
</style>

<div class="content">
	<div id="hscodeRegistLayer" style="width:750px;height:390px;">
		<div style="width:100%;height:100%; overflow:auto;">
		<form name="hscodeRegistFrm" id="hscodeRegistFrm" method="POST" action="../goods_process/hscode_setting" target="actionFrame">
		<input type="hidden" name="hscode_seq" value="<?php echo $TPL_VAR["hscode_seq"]?>">
		<input type="hidden" name="hscode_row_length" value="<?php echo count($TPL_VAR["hscode_items"])?>" size=1>
		<input type="hidden" name="get_hscode" value="<?php echo $TPL_VAR["hscode"]?>" />
		<input type="hidden" name="keyword" value="<?php echo $TPL_VAR["keyword"]?>" />
		<input type="hidden" name="search_type" value="<?php echo $TPL_VAR["search_type"]?>" />
		<table class="table_basic">
		<thead>
			<tr>
				<th class="subj" rowspan="2">품명</th>
				<th class="code" rowspan="2">공통코드</th>
				<th class="" colspan="3">수입국가코드</th>
				<th class="th_customs_tax" colspan="<?php echo count($TPL_VAR["hscode_items"][ 0]['export_nation_key'])?>">수출국가별 수입국가 세율</th>
			</tr>
			<tr>
				<th class="coladd">&nbsp;</th>
				<th class="nation">수입국가</th>
				<th class="nation_code">
					수입국가코드
					<div class="mt5">
					<input type="text" size="4" name="hscode_nation_all" class="onlynumber" value="" maxlength="6" />
					<span class="btn small black"><button type="button" class="save_all"  id="hscode_nation">▼</button></span>
					</div>
				</th>
<?php if(is_array($TPL_R1=$TPL_VAR["hscode_items"][ 0]['export_nation_key'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
				<th class="tax">
					<span class="zone_area_add_btn">
<?php if($TPL_K1== 0){?>
						<span class="ctrl-add-btn add-col add_btn_area"><button class="ctrl-btn resp_btn v2" type="button" onclick="add_hscode_section(this,'zone');">추가</button></span>
<?php }else{?>
						<span class="ctrl-add-btn add-col  add_btn_area"><button class="ctrl-btn resp_btn v3" type="button" onclick="del_hscode_section(this,'zone');">삭제</button></span>
<?php }?>
					</span>
					<span class="zone_text zone_idx_0" idx=0>
						<input type="text" size="4" name="customs_tax_all" class="onlyfloat" value="" />
						<span class="btn small black"><button type="button" class="save_all" id="customs_tax">▼</button></span>
					</span>
				</th>
<?php }}else{?>
				<th class="tax">
					<span class="zone_area_add_btn">
						<span class="btn small ctrl-add-btn add-col cyanblue add_btn_area"><button class="ctrl-btn" type="button" onclick="add_hscode_section(this,'zone');">추가</button></span>
					</span>
					<span class="zone_text zone_idx_0" idx=0>
						<input type="text" size="4" name="customs_tax_all" class="onlyfloat" value="" />
						<span class="btn small black"><button type="button" class="save_all" id="customs_tax">▼</button></span>
					</span>
				</th>
<?php }?>
			</tr>  
		</thead>
		<tbody>
			<tr>
				<td class="subj center" <?php if(count($TPL_VAR["hscode_items"])> 1){?>rowspan="<?php echo count($TPL_VAR["hscode_items"])?>"<?php }?>>
					<input type="text" name="hscode_name" title="품명" value="<?php echo $TPL_VAR["hscode_name"]?>" style="width:80%;">
				</td>
				<td class="code center" <?php if(count($TPL_VAR["hscode_items"])> 1){?>rowspan="<?php echo count($TPL_VAR["hscode_items"])?>"<?php }?>>
					<input type="text" name="hscode_common" title="공통코드" maxlength="6" value="<?php echo $TPL_VAR["hscode_common"]?>" <?php if($TPL_VAR["hscode_seq"]){?>disabled<?php }?> style="width:80%;">
				</td>
<?php if($TPL_VAR["hscode_items"]){?>
<?php if($TPL_hscode_items_1){foreach($TPL_VAR["hscode_items"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1> 0){?>
			<tr>
<?php }?>
				<td class="coladd center">
					<input type="hidden" name="hscode_row[]" value="<?php echo $TPL_K1?>">
					<span class="zone_area_add_btn">
<?php if($TPL_K1== 0){?>
						<span class="ctrl-add-btn add-col add_btn_area"><button class="ctrl-btn resp_btn v2" type="button" onclick="add_hscode_section(this,'section');">추가</button></span>
<?php }else{?>
						<span class="ctrl-add-btn add-col add_btn_area"><button class="ctrl-btn resp_btn v3" type="button" onclick="del_hscode_section(this,'section');">삭제</button></span>
<?php }?>
					</span>
				</td>
				<td class="nation center">
					<select name="nation_key[]" class="input nation_key" onChange="nation_duplication_chk(this)" nation_key='true' title="수입국가" style="width:116px;padding:3px; vertical-align:middle; border:1px solid #ccc;">
<?php if(is_array($TPL_R2=$TPL_VAR["nation_list"]['loop'])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["nationKey"]){?>
					<option value="<?php echo $TPL_V2["nationKey"]?>" <?php if($TPL_V2["nationKey"]==$TPL_V1["nation_key"]){?>selected<?php }?>><?php echo $TPL_V2["nationName"]?>(<?php echo $TPL_V2["nationCode"]?>)</option>
<?php }?>
<?php }}?>
					</select>
				</td>
				<td class="nation_code center">
					<input type="text" name="hscode_nation[]" title="수입국가코드" style="width:80%;" maxlength="6" value="<?php echo $TPL_V1["hscode_nation"]?>">
				</td>
<?php if(is_array($TPL_R2=$TPL_V1["export_nation_key"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
				<td class="tax center">
					<select name="export_nation_key[<?php echo $TPL_K1?>][]" class="input today_idx_0 export_nation_key" onChange="nation_duplication_chk(this)" export_nation_key='true' title="수출국가" style="width:80px;padding:3px; vertical-align:middle; border:1px solid #ccc;">
<?php if(is_array($TPL_R3=$TPL_VAR["nation_list"]['loop'])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["nationKey"]){?>
					<option value="<?php echo $TPL_V3["nationKey"]?>" <?php if($TPL_V3["nationKey"]==$TPL_V2){?>selected<?php }?>><?php echo $TPL_V3["nationName"]?>(<?php echo $TPL_V3["nationCode"]?>)</option>
<?php }?>
<?php }}?>
					</select>
					<input type="text" name="customs_tax[<?php echo $TPL_K1?>][]" class="customs_tax zone<?php echo $TPL_K1?>" size="4" title="세율" value="<?php echo $TPL_V1["customs_tax"][$TPL_K2]?>"> %
				</td>
<?php }}?>
<?php if($TPL_K1> 0){?>
			</tr>
<?php }?>
<?php }}?>
<?php }else{?>
				<td class="coladd center">
					<input type="hidden" name="hscode_row[]" value="0" size=1>
					<span class="zone_area_add_btn">
						<span class="btn small ctrl-add-btn add-col cyanblue add_btn_area"><button class="ctrl-btn" type="button" onclick="add_hscode_section(this,'section');">추가</button></span>
					</span>
				</td>
				<td class="nation center">
					<select name="nation_key[]" class="input nation_key" onChange="nation_duplication_chk(this)" nation_key='true' title="수입국가" style="width:116px;padding:3px; vertical-align:middle; border:1px solid #ccc;">
<?php if(is_array($TPL_R1=$TPL_VAR["nation_list"]['loop'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["nationKey"]){?>
					<option value="<?php echo $TPL_V1["nationKey"]?>"><?php echo $TPL_V1["nationName"]?>(<?php echo $TPL_V1["nationCode"]?>)</option>
<?php }?>
<?php }}?>
					</select>
				</td>
				<td class="nation_code center">
					<input type="text" name="hscode_nation[]" title="수입국가코드" style="width:80%;" maxlength="6">
				</td>
				<td class="tax center">
					<select name="export_nation_key[0][]" class="input today_idx_0 export_nation_key" onChange="nation_duplication_chk(this)" export_nation_key='true' title="수출국가" style="width:80px;padding:3px; vertical-align:middle; border:1px solid #ccc;">
<?php if(is_array($TPL_R1=$TPL_VAR["nation_list"]['loop'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["nationKey"]){?>
					<option value="<?php echo $TPL_V1["nationKey"]?>"><?php echo $TPL_V1["nationName"]?>(<?php echo $TPL_V1["nationCode"]?>)</option>
<?php }?>
<?php }}?>
					</select>
					<input type="text" name="customs_tax[0][]" class="customs_tax zone0" size="4" title="세율"> %
				</td>
<?php }?>
			</tr>
		</tbody>
		</table>
	</form>
		</div>
	</div>
</div>

<div class="footer">
	<button type="button" id="hscode_save" class="resp_btn active size_XL">저장</button></span>
	<button type="button" onclick="closeDialog('hscode_register_popup')" class="resp_btn v3 size_XL">취소</button></span>
</div>