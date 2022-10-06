<?php /* Template_ 2.2.6 2022/05/17 12:31:52 /www/music_brother_firstmall_kr/admin/skin/default/goods/select.html 000030081 */ 
$TPL_eventData_1=empty($TPL_VAR["eventData"])||!is_array($TPL_VAR["eventData"])?0:count($TPL_VAR["eventData"]);
$TPL_giftData_1=empty($TPL_VAR["giftData"])||!is_array($TPL_VAR["giftData"])?0:count($TPL_VAR["giftData"]);
$TPL_auto_orders_1=empty($TPL_VAR["auto_orders"])||!is_array($TPL_VAR["auto_orders"])?0:count($TPL_VAR["auto_orders"]);
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);?>
<script type="text/javascript">
function keyMoveSelectedItem(e){

	if($("div#targetList div.selectedGoods").length){
		var sArr = new Array();
		if(event.keyCode == '38'){ // up
			$("div#<?php echo $_GET["displayId"]?> div#targetList div.targetGoods").each(function(idx){
				if( $(this).hasClass("selectedGoods") ){
					idx--;
					if( idx >= 0 ){
						$("div#<?php echo $_GET["displayId"]?> div#targetList div.targetGoods").eq(idx).before( $(this) );
					}
				}
			});
			select_<?php echo $_GET["displayId"]?>.apply_layer();
			document.body.focus();
			return false;
		}
		if(event.keyCode == '40'){ // down
			var i = 0;
			$("div#<?php echo $_GET["displayId"]?> div#targetList div.targetGoods").each(function(idx){
				if( $(this).hasClass("selectedGoods") ){
					sArr[i] = idx;
					i++;
				}
			});
			for(var i=sArr.length-1;i>=0;i--){
				var idx = sArr[i];
				var obj = $("div#<?php echo $_GET["displayId"]?> div#targetList div.targetGoods").eq(idx);
				idx++;
				if( idx < $("div#<?php echo $_GET["displayId"]?> div#targetList div.targetGoods").length ){
					$("div#<?php echo $_GET["displayId"]?> div#targetList div.targetGoods").eq(idx).after( obj );
				}
			}
			select_<?php echo $_GET["displayId"]?>.apply_layer();
			document.body.focus();
			return false;
		}

	}
}

document.onkeydown = function(e){return keyMoveSelectedItem(e);};

function targetGoods_click(obj){
	obj.toggleClass('selectedGoods');
}

function check_new_select(){
	$.ajax({
		url: "../design_process/set_upgrade_select",
		type: "get",
		data: "display_seq=<?php echo $TPL_VAR["display_seq"]?>&relation_goods_seq=<?php echo $_GET["relation_goods_seq"]?>",
		success : function(json){
			openDialogAlert("설정이 변경되었습니다.",'400','160',function(){location.reload()});
		}
	});
}

$(document).ready(function() {

<?php if($_GET["criteria"]){?>
	var criteria = "<?php echo $_GET["criteria"]?>".split(",");
	if(criteria=="") return;
	for(var i=0;i<criteria.length;i++){
		var div = criteria[i].split("=");
		var name = div[0];
		var value = decodeURIComponent(div[1]);

		var obj = $("#goodsSelectorSearch>form *[name='"+name+"']");
		if(obj.length){
			if(obj[0].tagName.toUpperCase()=='INPUT' && (obj.attr('type')=='checkbox' || obj.attr('type')=='radio')){
				$("#goodsSelectorSearch>form input[name='"+name+"'][value='"+value+"']").attr("checked",true);
			}else if(obj[0].tagName=='SELECT'){
				obj.val(value).attr("defaultValue",value);
			}else{
				obj.val(value);
			}
		}
	}
<?php }else{?>
		$("#goodsSelectorSearch>form input[name='selectGoodsStatus[]']").eq(0).attr("checked",true);
<?php }?>

	/* 카테고리 불러오기 */
	category_admin_select_load('','selectCategory1','');
	$("div#<?php echo $_GET["displayId"]?> select[name='selectCategory1']").bind("change",function(){
		category_admin_select_load('selectCategory1','selectCategory2',$(this).val());
		category_admin_select_load('selectCategory2','selectCategory3',"");
		category_admin_select_load('selectCategory3','selectCategory4',"");
	});
	$("div#<?php echo $_GET["displayId"]?> select[name='selectCategory2']").bind("change",function(){
		category_admin_select_load('selectCategory2','selectCategory3',$(this).val());
		category_admin_select_load('selectCategory3','selectCategory4',"");
	});
	$("div#<?php echo $_GET["displayId"]?> select[name='selectCategory3']").bind("change",function(){
		category_admin_select_load('selectCategory3','selectCategory4',$(this).val());
	});

	/* 브랜드 불러오기 */
	brand_admin_select_load('','selectBrand1','');
	$("div#<?php echo $_GET["displayId"]?> select[name='selectBrand1']").bind("change",function(){
		brand_admin_select_load('selectBrand1','selectBrand2',$(this).val());
		brand_admin_select_load('selectBrand2','selectBrand3',"");
		brand_admin_select_load('selectBrand3','selectBrand4',"");
	});
	$("div#<?php echo $_GET["displayId"]?> select[name='selectBrand2']").bind("change",function(){
		brand_admin_select_load('selectBrand2','selectBrand3',$(this).val());
		brand_admin_select_load('selectBrand3','selectBrand4',"");
	});
	$("div#<?php echo $_GET["displayId"]?> select[name='selectBrand3']").bind("change",function(){
		brand_admin_select_load('selectBrand3','selectBrand4',$(this).val());
	});

	/* 이벤트 선택 */
	$("div#<?php echo $_GET["displayId"]?> select[name='selectEvent']").bind("change",function(){
		event_admin_select_load('selectEvent','selectEventBenefits',$(this).val());
	}).change();

	/* 지역 불러오기 */
	location_admin_select_load('','selectLocation1','');
	$("div#<?php echo $_GET["displayId"]?> select[name='selectLocation1']").bind("change",function(){
		location_admin_select_load('selectLocation1','selectLocation2',$(this).val());
		location_admin_select_load('selectLocation2','selectLocation3',"");
		location_admin_select_load('selectLocation3','selectLocation4',"");
	});
	$("div#<?php echo $_GET["displayId"]?> select[name='selectLocation2']").bind("change",function(){
		location_admin_select_load('selectLocation2','selectLocation3',$(this).val());
		location_admin_select_load('selectLocation3','selectLocation4',"");
	});
	$("div#<?php echo $_GET["displayId"]?> select[name='selectLocation3']").bind("change",function(){
		location_admin_select_load('selectLocation3','selectLocation4',$(this).val());
	});

	/* 이벤트 검색폼 활성화 */
	var regExp = /^(.*)\/event[0-9]{7}\.html$/;
	if(regExp.test($("input[name='template_path']").val())){
		$(".searchFormItemEvent").show();
		$(".searchFormItemGift").hide();
		$(".searchFormItemNormal").hide();
	}

	/* GIFT 이벤트 검색폼 활성화 */
	var regExp = /^(.*)\/gift[0-9]{7}\.html$/;
	if(regExp.test($("input[name='template_path']").val())){
		$(".searchFormItemGift").show();
		$(".searchFormItemEvent").hide();
		$(".searchFormItemNormal").hide();
	}


	$("div#<?php echo $_GET["displayId"]?> div.targetGoods").live('dblclick',function(event){
		$(this).remove();
		select_<?php echo $_GET["displayId"]?>.apply_layer();
	});

	$(".displayGoodsRemoveButton").click(function(){
		$("div#<?php echo $_GET["displayId"]?> div.targetGoods").each(function(){
			$(this).remove();
		});
		select_<?php echo $_GET["displayId"]?>.apply_layer();
	});
/*

	$("div#<?php echo $_GET["displayId"]?> div.targetGoods").live(function(event){
		if( $(this).hasClass('selectedGoods') ){
			$(this).removeClass('selectedGoods');
		}else{
			$(this).addClass('selectedGoods');
		}
	});

	*/

	// 상품디스플레이 : 자동조건상품 추출하여 수동노출에 넣기
	$("#selectCriteriaSearchButton").click(function(){

		var tabIdx =$("#<?php echo $_GET["inputGoods"]?>").closest('.displayTabGoodsContainer').attr('tabIdx');

		var count_w = num($("input[name='<?php echo $_GET["prefix"]?>count_w']").val());
		var count_h = num($("input[name='<?php echo $_GET["prefix"]?>count_h']").val());
		if(!count_w || !count_h){
			var msg = "상품 노출 개수를 입력해주세요";
			openDialogAlert(msg,400,140,function(){
				if(!count_w) {$("input[name='<?php echo $_GET["prefix"]?>count_w']").focus();return false;}
				if(!count_h) {$("input[name='<?php echo $_GET["prefix"]?>count_h']").focus();return false;}
			});
			return false;
		}

		if($("#goodsSelectorSearch>form input[name='selectGoodsName']").val()==$("#goodsSelectorSearch>form input[name='selectGoodsName']").attr('title')){
			$("#goodsSelectorSearch>form input[name='selectGoodsName']").val('');
		}

		var params = $("#goodsSelectorSearch>form").serialize() + '&return_goods_seq=1&count_w='+count_w+'&count_h='+count_h;

		$.ajax({
			'url' : '../goods/select_list',
			'data' : params,
			'dataType' : 'json',
			'type' : 'get',
			'success' : function(res){
<?php if($_GET["displayKind"]=='relation'){?>
				var displayGoodsId = "relationGoods";
<?php }else{?>
				var displayGoodsId = "displayGoods"+tabIdx;
<?php }?>
				var iObj = $("#"+displayGoodsId);
				var tag = "";

				for(var i=0;i<res.length;i++){
					var goodsSeq = res[i].goods_seq;
					if(goodsSeq){
						var img = res[i].image;
						var goodsName = res[i].goods_name;
						var goodsPrice = res[i].price;
						tag += "<div class='goods fl move'>";
						tag += "<div align='center' class='image'><img src='"+img+"' class='goodsThumbView' width='50' height='50' onerror=\"this.src='/admin/skin/default/images/common/noimage_list.gif'\" /></div>";
						tag += "<div align='center' class='name' style='width:70px;overflow:hidden;white-space:nowrap;'>"+htmlspecialchars(goodsName)+"</div>";
						tag += "<div align='center' class='price'>"+comma(goodsPrice)+"</div>";
						tag += "<input type='hidden' name='"+displayGoodsId+"[]' value='"+goodsSeq+"' />";
						tag += "</div>";
					}
				}

				iObj.html( tag );



			}
		});

		var formParams = $("#goodsSelectorSearch>form").serializeArray();
		var params = new Array();
		for(var i in formParams){
			if(formParams[i].name=='displayId') continue;
			if(formParams[i].name=='inputGoods') continue;
			if(formParams[i].value!=null && formParams[i].value.length>0) params.push(formParams[i].name+"="+encodeURIComponent(formParams[i].value));
		}

		$("#<?php echo $_GET["inputGoods"]?>").val(params.join(","));

<?php if($_GET["displayKind"]=='relation'){?>
		$("input[name='relation_type'][value='MANUAL']").attr("checked",true).change();
<?php }else{?>
		$("select.contents_type").eq(tabIdx).val("select").change();
<?php }?>

		closeDialog("#displayGoodsSelectPopup");
	});

	// 자동조건 적용
	$("#selectCriteriaButton").click(function(){

		var tabIdx = $("#<?php echo $_GET["inputGoods"]?>").closest('.displayTabGoodsContainer').attr('tabIdx');

		if($("#goodsSelectorSearch>form input[name='selectGoodsName']").val()==$("#goodsSelectorSearch>form input[name='selectGoodsName']").attr('title')){
			$("#goodsSelectorSearch>form input[name='selectGoodsName']").val('');
		}

		var formParams = $("#goodsSelectorSearch>form").serializeArray();
		var params = new Array();
		for(var i in formParams){
			if(formParams[i].name=='selectStartPrice' || formParams[i].name=='selectEndPrice') {
				if(num($("#goodsSelectorSearch>form input[name='selectEndPrice']").val())<=0)  continue;
			}
			if(formParams[i].name=='displayId') continue;
			if(formParams[i].name=='inputGoods') continue;
			if(formParams[i].value!=null && formParams[i].value.length>0) {
				var val = formParams[i].name+"="+encodeURIComponent(formParams[i].value);
				if(formParams[i].name=='selectCategory1' || formParams[i].name=='selectCategory2' || formParams[i].name=='selectCategory3' || formParams[i].name=='selectCategory4' || formParams[i].name=='selectBrand1' || formParams[i].name=='selectBrand2' || formParams[i].name=='selectBrand3' || formParams[i].name=='selectBrand4' || formParams[i].name=='selectLocation1' || formParams[i].name=='selectLocation2' || formParams[i].name=='selectLocation3' || formParams[i].name=='selectLocation4'){
					val = val+"="+$("#goodsSelectorSearch>form select[name='"+formParams[i].name+"'] option:selected").text();
				}
				params.push(val);
			}
		}

		$("#<?php echo $_GET["inputGoods"]?>").val(params.join(","));

<?php if($_GET["displayKind"]=='relation'){?>
		$("input[name='relation_type'][value='AUTO']").attr("checked",true).change();
<?php }else{?>
		$("select.contents_type").eq(tabIdx).val("auto").change();
<?php }?>

		closeDialog("#displayGoodsSelectPopup");

		setCriteriaDescription();
	});

	apply_input_style();

	$('#allInsertButton').click(function(){
		$.ajax({
			url: "../goods/select_list?allList=1",
			type: "get",
			data : $('#goodsSelectorSearch form').serialize(),
			dataType: "json",
			success : function(json){
				x		= -1;
				html	= [];
				$.each(json,function(){
					html[++x] = "<input type='hidden' name='distributor_goods[]' value='"+this.goods_seq+"'>";
				});
				var iObj = $("div#<?php echo $_GET["inputGoods"]?>",parent.document);
				iObj.html('총: '+(x+1)+'건의 상품이 있습니다.'+html.join(''));
				$("input[name='allList']",parent.document).val(1);
				$('#<?php echo $_GET["displayId"]?>').dialog('close');
			}
		});
	});

	$('#selectUpgradeButton').click(function(){
		openDialog('안내', 'upgradeConfirm', {'width':400,'height':160});
	});
	
	$("[name='select_date']").click(function() {
		switch($(this).attr("id")) {
			case 'today' :
				$("input[name='selectSdate']").val(getDate(0));
				$("input[name='selectEdate']").val(getDate(0));
				break;
			case '3day' :
				$("input[name='selectSdate']").val(getDate(3));
				$("input[name='selectEdate']").val(getDate(0));
				break;
			case '1week' :
				$("input[name='selectSdate']").val(getDate(7));
				$("input[name='selectEdate']").val(getDate(0));
				break;
			case '1month' :
				$("input[name='selectSdate']").val(getDate(30));
				$("input[name='selectEdate']").val(getDate(0));
				break;
			case '3month' :
				$("input[name='selectSdate']").val(getDate(90));
				$("input[name='selectEdate']").val(getDate(0));
				break;
			default :
				$("input[name='selectSdate']").val('');
				$("input[name='selectEdate']").val('');
				break;
		}
	});
});
</script>
<style>
.selectedGoods{ background-color:#e7f2fc; }
.targetGoods {padding:4px; overflow:hidden; cursor:pointer}
.targetGoods .image {padding-right:4px;}
.targetGoods .name {display:block; width:300px; overflow:hidden; white-space:nowrap;}
</style>
<div>
<div id="goodsSelectorSearch">

<form action="../goods/select_list" method="get" target="select_<?php echo $_GET["displayId"]?>">
	<input type="hidden" name="goods_review" value="<?php echo $_GET["goods_review"]?>" />
	<input type="hidden" name="type" value="<?php echo $_GET["type"]?>" />
	<input type="hidden" name="select_one_goods_callback" value="<?php echo $_GET["select_one_goods_callback"]?>" />
	<input type="hidden" name="inputGoods" value="<?php echo $_GET["inputGoods"]?>" />
	<input type="hidden" name="displayId" value="<?php echo $_GET["displayId"]?>" />
<?php if($_GET["relation_goods_seq"]){?>
	<!-- 상품의 대표 카테고리,브랜드,지역 가져와서 관련상품출력할때 사용-->
	<input type="hidden" name="relation_goods_seq" value="<?php echo $_GET["relation_goods_seq"]?>" />
<?php }?>


	<table class="info-table-style" width="100%" border="0" cellpadding="0" cellspacing="0">
	<col width="120" /><col width="430" /><col width="120" /><col />
	<tr>
		<th class="its-th-align">검색어</th>
		<td class="its-td" colspan="3">
			<input type="text" name="selectGoodsName" value="" title="상품명(매입상품명), 상품코드" style="width:95%"  />
		</td>
	</tr>
	<tr>
		<th class="its-th-align">날짜</th>
		<td class="its-td" colspan="3">
			<select class="line" name="selectdateGb" style="width:100px;">
				<option value="regist_date">등록일</option>
				<option value="update_date">수정일</option>
			</select>
			<input type="text" name="selectSdate" value="" class="datepicker line" maxlength="10" style="width:90px;" />
			<span class="gray">-</span>
			<input type="text" name="selectEdate" value="" class="datepicker line" maxlength="10" style="width:90px;" />
			<span style="padding-left:7px;"></span>
			<span class="btn small"><button type="button" id="today" class=""  value="오늘" name="select_date">오늘</button></span>
			<span class="btn small"><button type="button" id="3day" class="" value="3일간" name="select_date">3일간</button></span>
			<span class="btn small"><button type="button" id="1week" class="" value="일주일" name="select_date">일주일</button></span>
			<span class="btn small"><button type="button" id="1month" class="" value="1개월" name="select_date">1개월</button></span>
			<span class="btn small"><button type="button" id="3month" class="" value="3개월" name="select_date">3개월</button></span>
			<span class="btn small"><button type="button" id="all" class="" value="전체" name="select_date">전체</button></span>
		</td>
	</tr>
	<tr>
		<th class="its-th-align">상태</th>
		<td class="its-td">
			<label><input type="checkbox" name="selectGoodsStatus[]" value="normal" /> 정상</label>
			<label><input type="checkbox" name="selectGoodsStatus[]" value="runout" /> 품절</label>
			<label><input type="checkbox" name="selectGoodsStatus[]" value="purchasing" /> 재고확보중</label>
			<label><input type="checkbox" name="selectGoodsStatus[]" value="unsold" /> 판매중지</label>
		</td>
		<th class="its-th-align">노출 여부</th>
		<td class="its-td">
			<label><input type="radio" name="selectGoodsView" value="" /> 전체</label>
			<label><input type="radio" name="selectGoodsView" value="look" checked="checked" /> 노출</label>
			<label><input type="radio" name="selectGoodsView" value="notLook" /> 미노출</label>
		</td>
	</tr>
	<tr>
		<th class="its-th-align">카테고리</th>
		<td class="its-td">
			<select name="selectCategory1" style="width:100px" <?php if($_GET["displayKind"]=='category'&&$_GET["type"]=='criteria'){?>disabled<?php }?>>
			<option value="">1차 카테고리</option>
			</select>
			<select name="selectCategory2" style="width:100px" <?php if($_GET["displayKind"]=='category'&&$_GET["type"]=='criteria'){?>disabled<?php }?>>
			<option value="">2차 카테고리</option>
			</select>
			<select name="selectCategory3" style="width:100px" <?php if($_GET["displayKind"]=='category'&&$_GET["type"]=='criteria'){?>disabled<?php }?>>
			<option value="">3차 카테고리</option>
			</select>
			<select name="selectCategory4" style="width:100px" <?php if($_GET["displayKind"]=='category'&&$_GET["type"]=='criteria'){?>disabled<?php }?>>
			<option value="">4차 카테고리</option>
			</select>
		</td>
		<th class="its-th-align">이미지영역 동영상</th>
		<td class="its-td">
			<label><input type="checkbox" name="file_key_w" value="1" <?php if($_GET["file_key_w"]){?>checked="checked"<?php }?> /> 있음</label>
			<select name="video_use" class="video_use">
				<option value="" selected >전체</option>
				<option value="Y">노출</option>
				<option value="N">미노출</option>
			</select>
		</td>
	</tr>
	<tr>
		<th class="its-th-align">브랜드</th>
		<td class="its-td">
			<select name="selectBrand1" style="width:100px" <?php if($_GET["displayKind"]=='brand'&&$_GET["type"]=='criteria'){?>disabled<?php }?>>
			<option value="">1차 브랜드</option>
			</select>
			<select name="selectBrand2" style="width:100px" <?php if($_GET["displayKind"]=='brand'&&$_GET["type"]=='criteria'){?>disabled<?php }?>>
			<option value="">2차 브랜드</option>
			</select>
			<select name="selectBrand3" style="width:100px" <?php if($_GET["displayKind"]=='brand'&&$_GET["type"]=='criteria'){?>disabled<?php }?>>
			<option value="">3차 브랜드</option>
			</select>
			<select name="selectBrand4" style="width:100px" <?php if($_GET["displayKind"]=='brand'&&$_GET["type"]=='criteria'){?>disabled<?php }?>>
			<option value="">4차 브랜드</option>
			</select>
		</td>
		<th class="its-th-align">설명영역 동영상</th>
		<td class="its-td">
			<label><input type="checkbox" name="videototal" value="1" /> 있음</label>
		</td>
	</tr>
	<tr>
		<th class="its-th-align">지역</th>
		<td class="its-td">
			<select name="selectLocation1" style="width:100px" <?php if($_GET["displayKind"]=='location'&&$_GET["type"]=='criteria'){?>disabled<?php }?>>
			<option value="">1차 지역</option>
			</select>
			<select name="selectLocation2" style="width:100px" <?php if($_GET["displayKind"]=='location'&&$_GET["type"]=='criteria'){?>disabled<?php }?>>
			<option value="">2차 지역</option>
			</select>
			<select name="selectLocation3" style="width:100px" <?php if($_GET["displayKind"]=='location'&&$_GET["type"]=='criteria'){?>disabled<?php }?>>
			<option value="">3차 지역</option>
			</select>
			<select name="selectLocation4" style="width:100px" <?php if($_GET["displayKind"]=='location'&&$_GET["type"]=='criteria'){?>disabled<?php }?>>
			<option value="">4차 지역</option>
			</select>
		</td>
		<th class="its-th-align">판매가격</th>
		<td class="its-td">
			<input type="text" name="selectStartPrice" size="6" value="" class="onlynumber"  />원부터 ~
			<input type="text" name="selectEndPrice" size="6" value="" class="onlynumber"  />원까지
		</td>
	</tr>
	<tr>
		<th class="its-th-align">이벤트</th>
		<td class="its-td" colspan="3">
			<strong>할인이벤트 </strong>
			<select name="selectEvent">
			<option value="">이벤트 선택</option>
<?php if($TPL_eventData_1){foreach($TPL_VAR["eventData"] as $TPL_V1){?>
			<option value="<?php echo $TPL_V1["event_seq"]?>">[<?php echo $TPL_V1["status"]?>] <?php echo $TPL_V1["title"]?></option>
<?php }}?>
			</select>
			<select name="selectEventBenefits"  class="hide"></select>

			<strong>사은품이벤트 </strong>
			<select name="selectGift">
			<option value="">이벤트 선택</option>
<?php if($TPL_giftData_1){foreach($TPL_VAR["giftData"] as $TPL_V1){?>
			<option value="<?php echo $TPL_V1["gift_seq"]?>">[<?php echo $TPL_V1["status"]?>] <?php echo $TPL_V1["title"]?></option>
<?php }}?>
			</select>
		</td>
	</tr>
<?php if($_GET["type"]=='criteria'){?>
	<tr>
		<th class="its-th-align">자동노출 정렬</th>
		<td class="its-td">
<?php if($TPL_auto_orders_1){$TPL_I1=-1;foreach($TPL_VAR["auto_orders"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
	 		<div>
	 			<label><input type="radio" name="auto_order" value="<?php echo $TPL_K1?>" title="<?php echo $TPL_V1?>" <?php if($TPL_I1== 0){?>checked="checked"<?php }?> /><?php echo $TPL_V1?></label>&nbsp;&nbsp;
	 		</div>
<?php }}?>
		</td>
		<th class="its-th-align">자동노출 검색기간</th>
		<td class="its-td">
			<label><input type="radio" name="auto_term_type" value="relative" checked="checked" /> 최근  </label><input type="text" name="auto_term" value="<?php if($TPL_VAR["data"]["auto_term"]==null){?>30<?php }else{?><?php echo $TPL_VAR["data"]["auto_term"]?><?php }?>" size="3" maxlength="4" class="onlynumber" />일
			<br />
			<label><input type="radio" name="auto_term_type" value="absolute" /> 고정 </label><input type="text" name="auto_start_date" value="<?php if($TPL_VAR["data"]["auto_start_date"]!='0000-00-00'){?><?php echo $TPL_VAR["data"]["auto_start_date"]?><?php }?>" size="7" maxlength="8" class="datepicker" style="font-size:11px !important" /> ~ <input type="text" name="auto_end_date" value="<?php if($TPL_VAR["data"]["auto_end_date"]!='0000-00-00'){?><?php echo $TPL_VAR["data"]["auto_end_date"]?><?php }?>" size="7" maxlength="8" class="datepicker" style="font-size:11px !important" />
		</td>
	</tr>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
	<tr>
		<th class="its-th-align">입점판매자</th>
		<td class="its-td" colspan="3">
			<div class="ui-widget">
				<select name="provider_seq_selector" style="vertical-align:middle;width:141px;">
					<option value="0">- 입점사 검색 -</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["provider_seq"]?>"><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }}?>
				</select>
				<span style="margin-left:20px;">&nbsp;</span>
			<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $_GET["provider_seq"]?>" />
			<input type="text" name="provider_name" value="<?php echo $_GET["provider_name"]?>" style="width:124px;" readonly />
			</div>
			<span class="ptc-charges hide"></span>

			<style>
			.ui-combobox {
				position: relative;
				display: inline-block;
			}
			.ui-combobox-toggle {
				position: absolute;
				top: 0;
				bottom: 0;
				margin-left: -1px;
				padding: 0;
				/* adjust styles for IE 6/7 */
				*height: 1.7em;
				*top: 0.1em;
			}
			.ui-combobox-input {
				margin: 0;
				padding: 0.3em;
			}
			.ui-autocomplete {
				max-height: 200px;
				overflow-y: auto;
				/* prevent horizontal scrollbar */
				overflow-x: hidden;
			}

			</style>

			<script>
			$(function(){
				var prv_obj = $("select[name='provider_seq_selector']").next(".ui-combobox").children("input");
				prv_obj.val('- 입점사 선택 -');
				$( "select[name='provider_seq_selector']" )
				.css({'width': 125})
				.combobox()
				.change(function(){
					if( $(this).val() > 0 ){
						$("input[name='provider_seq']").val($(this).val());
						$("input[name='provider_name']").val($("option:selected",this).text());
					}else{
						$("input[name='provider_seq']").val('');
						$("input[name='provider_name']").val('');
						//$( "select[name='provider_seq_selector']" ).val('- 입점사 검색 -');
					}
				})
				.next(".ui-combobox").children("input")
				.css({'width': 125})
				.bind('focus',function(){
					if($(this).val()==$( "select[name='provider_seq_selector'] option:first-child" ).text()){
						$(this).val('');
					}
				})
				.bind('mouseup',function(){
					if($(this).val()==''){
						$( "select[name='provider_seq_selector']").next(".ui-combobox").children("a.ui-combobox-toggle").click();
					}
				});
			});
			</script>
		</td>
	</tr>
<?php }?>
	</table>



<?php if($_GET["type"]=='criteria'){?>
	</form>
	</div>

	<div class="pdt10 center">
		<div class="pdb10 center desc">
			등록된 상품갯수가 약3,000개 이상일 경우 [상품노출 자동방식]은 해당 페이지의 로딩속도가 느려지게 됩니다.<br />
			그러므로 상품갯수가 많을 경우 상품을 선택하여 노출하는 [상품노출 수동방식]을 권장 드립니다.
		</div>
<?php if($_GET["autoSelectOnly"]!='Y'){?>
		<span class="btn medium cyanblue"><button type="button" id="selectCriteriaSearchButton">↑ 위 자동 조건에 만족하는 상품을 추출하여 수동 상품노출에 넣기</button></span>
		또는
<?php }?>
		<span class="btn medium cyanblue"><button type="button" id="selectCriteriaButton">↑ 위 자동 조건으로 상품노출 하기</button></span>

	</div>

	<div class="pdt10 center desc">
		또는<br />
		앞으로 업그레이드된 자동 선정 조건을 사용하여 자동 노출 하실 수 있습니다.<br />
		단, (구) 자동 선정 기능은 더 이상 사용할 수 없습니다.<br /><br />
		<span class="btn medium cyanblue"><button type="button" id="selectUpgradeButton">업그레이드된 자동 선정 사용하기</button></span>
	</div>
	<div class="hide" id="upgradeConfirm">
		<div class="center">
			업그레이드된 자동 선정하기를 사용하실 경우<br/>
			(구)자동 선정 기능은 더이상 사용 할 수 없습니다.<br /><br />
			<span class="btn medium cyanblue"><button type="button" onclick="check_new_select();">사용</button></span>
			<span class="btn medium cyanblue"><button type="button" onclick="$('#upgradeConfirm').dialog('close');">취소</button></span>
		</div>
	</div>

<?php }else{?>
		<div class="pdt10 center"><span class="btn medium"><button type="submit" id="selectSearchButton">검색</button></span></div>
<?php if($_GET["allList"]){?>
		<span class="btn medium"><button type="button" id="allInsertButton">검색결과모두넣기</button></span>
<?php }?>

	</form>
	</div>

	<div style="height:5px;"></div>
	<table style="width:100%">
	<col>
	<col width="5">
	<col width="50%">
	<tr>
		<td valign="top">
		<div style="background-color:#f1f1f1; font-weight:normal;border-collapse:collapse; border:1px solid #aaa;height:30px; line-height:15px;padding:4px;">검색된 상품 리스트<div><span class="desc">상품을 클릭하면 선택됩니다.</span></div></div>
		<iframe width="100%" height="<?php echo $TPL_VAR["containerHeight"]?>" frameborder="0" src="../goods/select_list?inputGoods=<?php echo $_GET["inputGoods"]?>&displayId=<?php echo $_GET["displayId"]?>&onlyType=<?php echo $_GET["onlyType"]?>&adminshipping=<?php echo $_GET["adminshipping"]?>&adminOrder=<?php echo $_GET["adminOrder"]?>&init=Y&goods_review=<?php echo $_GET["goods_review"]?>&type=<?php echo $_GET["type"]?>&select_one_goods_callback=<?php echo $_GET["select_one_goods_callback"]?>&selectGoodsView=look" name="select_<?php echo $_GET["displayId"]?>"></iframe>
		</td>
<?php if($_GET["type"]!='select_one_goods'){?>
		<td></td>
		<td valign="top">
		<div style="background-color:#f1f1f1; font-weight:normal;border-collapse:collapse; border:1px solid #aaa;height:30px; line-height:15px;padding:4px;">선택된 상품 리스트 <br /> <span class="desc">상품을 더블클릭하면 제외됩니다. 노출순서는 클릭 후 키보드 방향키 ↑↓로변경하세요.</span></div>

		<div id="targetList" style="height:<?php echo $TPL_VAR["containerHeight"]?>px;overflow:auto;"></div>

		</td>
<?php }?>
	</tr>
<?php if($_GET["innerMode"]=='1'){?>
	<tr>
		<td colspan="2" align="right" class="pdt5">
			<span class="btn small"><input type="button" value="닫기" onclick="$('#<?php echo $_GET["displayId"]?>').empty();$('#<?php echo $_GET["displayId"]?>Container').hide();" /></span>
		</td>
	</tr>
<?php }?>
	</table>
	</div>
<?php }?>