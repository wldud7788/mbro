<?php /* Template_ 2.2.6 2022/05/17 12:31:51 /www/music_brother_firstmall_kr/admin/skin/default/goods/option_default_setting.html 000007835 */ ?>
<script type="text/javascript" src="/app/javascript/js/goods-display.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript">
$(function(){
	/* 관련상품 조건 선택 버튼 */
	$("button#relationCriteriaButton").live("click",function(){
		var displayResultId = "relationCriteria";
		var criteria = $("#relationCriteria").val();
		if (criteria=="") {
			criteria = "admin∀type=select_auto,provider=all,month=1,act=recently,min_ea=1";
		}
		openDialog("조건 선택", "#displayGoodsSelectPopup", {"width":"960","height":"560","show" : "fade","hide" : "fade"});
//		set_goods_list("displayGoodsSelect",displayResultId,'criteria',criteria);
		set_goods_list_auto("displayGoodsSelect",displayResultId,criteria,'relation','criteria');
	});

	// 자동노출조건 설명
//	setCriteriaDescription();
	setCriteriaDescription_upgrade();
});

function set_goods_list_auto(displayId,inputGoods,criteria,auto_condition_use_id,kind,type){
	$.ajax({
		type: "get",
		url: "../goods/select_auto",
		data: "inputGoods="+inputGoods+"&displayKind="+kind+"&displayId="+displayId+"&criteria="+encodeURIComponent(criteria)+"&auto_condition_use_id="+auto_condition_use_id+"&type="+type,
		success: function(result){
			$("div#"+displayId).html(result);
			$("#"+displayId+"Container").show();
		}
	});
}

// RELATION GOODS
function set_goods_list(displayId,inputGoods,type,criteria){
	$.ajax({
		type: "get",
		url: "../goods/select",
		data: "innerMode=2&type="+type+"&containerHeight=230&page=1&inputGoods="+inputGoods+"&displayId="+displayId+"&displayKind=relation&criteria="+encodeURIComponent(criteria)+'&prefix=relation_&relation_goods_seq=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&autoSelectOnly=Y',
		success: function(result){
			$("div#"+displayId).html(result).show();
			$("#"+displayId+"Container").show();
		}
	});
}
</script>
<form name="ovFrm" method="post" action="../goods_process/set_option_view_count" target="actionFrame">
<input type="hidden" name="goods_kind" value="<?php echo $_GET["goods_kind"]?>" />
<input type="hidden" name="editor_view" value="N" />
<table class="info-table-style" style="width:100%">
<tr>
	<th class="its-th-align center" width="130">구분</th>
	<th class="its-th-align center" width="130">항목</th>
	<th class="its-th-align center">설정</th>
</tr>
<!-- 상품 수정 시 -->
<tr>
	<td class="its-td-align center">상품 수정 시<br/>보기 기본값</td>
	<td class="its-td-align center">옵션 보기</td>
	<td class="its-td-align pdl10">
		필수옵션은 기본으로 <input type="text" size="3" name="option_view_count" value="<?php echo $TPL_VAR["config_goods"]["option_view_count"]?>" />개가 보이며
		나머지는 <span style="color:red;">모두열기▼</span>를 클릭하여 봅니다.
		<br/>
		<div id="area_suboption" <?php if($_GET["goods_kind"]=='coupon'){?>class='hide'<?php }?>>
		추가구성옵션은 기본으로 <input type="text" size="3" name="suboption_view_count" value="<?php echo $TPL_VAR["config_goods"]["suboption_view_count"]?>" />개가 보이며
		나머지는 <span style="color:red;">모두열기▼</span>를 클릭하여 봅니다.
		</div>
		<span class="desc">※ <span style="color:red;">모두열기▼</span>는 기본 개수를 초과한 옵션 개수가 있을 경우에만 나타납니다.</span>
	</td>
</tr>
<!-- 상품 등록/수정 시 -->
<!--tr>
	<td class="its-td-align center">상품 등록/수정<br/>보기 기본값</td>
	<td class="its-td-align center">에디터 보기</td>
	<td class="its-td-align pdl10">
		<input type="hidden" name="editor_view" value="N" />
		PC/태블릿용, 상품설명/모바일용, 상품설명/공용정보 입력 시<br/>
		에디터를 미사용
		<select name="editor_view">
			<option value="Y" <?php if($TPL_VAR["config_goods"]["editor_view"]=='Y'){?>selected="selected"<?php }?>>사용</option>
			<option value="N" <?php if($TPL_VAR["config_goods"]["editor_view"]=='N'){?>selected="selected"<?php }?>>미사용</option>
		</select>
		하여 내용을 입력
	</td>
</tr-->

<!-- 상품 등록 시 -->
<tr>
	<td class="its-td-align center" rowspan="2">상품 등록 시<br/>정보 기본값</td>
	<td class="its-td-align center">상품 공통 정보</td>
	<td class="its-td-align pdl10">
		<select name="common_info_seq">
<?php if($TPL_VAR["config_goods"]["common_info_loop"]){?>
			<option value="">선택하세요</option>
<?php if(is_array($TPL_R1=$TPL_VAR["config_goods"]["common_info_loop"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["info_name"]!='== 선택하세요 =='&&$TPL_V1["info_name"]!='== ←좌측에 상품 공통 정보명을 입력하여 새로운 상품 공통 정보를 만드시거나 또는 ↓아래에서 이미 만들어진 상품 공통 정보를 불러오세요 =='){?>
			<option value="<?php echo $TPL_V1["info_seq"]?>" <?php if($TPL_V1["info_seq"]==$TPL_VAR["config_goods"]["common_info_seq"]){?>selected="selected"<?php }?>><?php echo $TPL_V1["info_name"]?> &nbsp;[고유번호 : <?php echo $TPL_V1["info_seq"]?>]</option>
<?php }?>
<?php }}?>
<?php }else{?>
				<option value="">상품 공통 정보가 없습니다.</option>
<?php }?>
		</select><br/>
		<span class="desc">※ 상품 공통 정보는 상품 등록 및 수정 화면에서 상품 공통 정보 입력 시 생성할 수 있습니다.</span>
	</td>
</tr>
<tr>
	<td class="its-td-align center">관련 상품<br/>자동 선정</td>
	<td class="its-td-align pdl10 relationGoodsContainer">
		<div id="relationGoodsAutoContainer">
			<span class="btn small gray hide"><button type="button" id="relationCriteriaButton">조건 선택</button></span>
			<div class="clearbox" style="height:5px;"></div>
			<input type='hidden' class="displayCriteria" id="relationCriteria" name='relation_criteria' value="<?php if($TPL_VAR["config_goods"]["relation_criteria"]){?><?php echo $TPL_VAR["config_goods"]["relation_criteria"]?><?php }else{?><?php }?>" />

			<div class="displayCriteriaDesc"></div>
		</div>
	</td>
</tr>
<!-- 상품 리스트 기본 검색 설정 -->
<tr>
	<td class="its-td-align center" rowspan="3">상품 리스트</td>
	<td class="its-td-align center">대표 카테고리</td>
	<td class="its-td-align pdl10">
		<label><input type="checkbox" name="list_default_condition[category]" value="y" <?php if($TPL_VAR["config_goods"]["list_condition_category"]=='y'){?>checked<?php }?> /> 대표 카테고리를 확인합니다.</label>
	</td>
</tr>
<tr>
	<td class="its-td-align center">대표 브랜드</td>
	<td class="its-td-align pdl10">
		<label><input type="checkbox" name="list_default_condition[brand]" value="y" <?php if($TPL_VAR["config_goods"]["list_condition_brand"]=='y'){?>checked<?php }?> /> 대표 브랜드를 확인합니다.</label>
	</td>
</tr>
<tr>
	<td class="its-td-align center">가격대체문구</td>
	<td class="its-td-align pdl10">
		<label><input type="checkbox" name="list_default_condition[stringprice]" value="y" <?php if($TPL_VAR["config_goods"]["list_condition_stringprice"]=='y'){?>checked<?php }?> /> 가격대체문구를 확인합니다.</label>
	</td>
</tr>
</table>
<div style="padding-top:10px;width:100%;text-align:center;">
	<span class="btn large cyanblue"><button type="submit">저장</button></span>
	<span class="btn large gray" onclick="closeDialog('set_option_view_lay');"><input type="button" value="취소"></span>
</div>
<div>
	<span class="darkgray fx12">※ 관리자 ID 당 설정이 저장됩니다.</span>
</div>
<div id="displayGoodsSelectPopup">
	<div id="displayGoodsSelect"></div>
</div>
</form>