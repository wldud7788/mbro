<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/bigdata/search_form.html 000012083 */ 
$TPL_eventData_1=empty($TPL_VAR["eventData"])||!is_array($TPL_VAR["eventData"])?0:count($TPL_VAR["eventData"]);
$TPL_giftData_1=empty($TPL_VAR["giftData"])||!is_array($TPL_VAR["giftData"])?0:count($TPL_VAR["giftData"]);?>
<script type="text/javascript">
	function targetGoods_click(obj){
		obj.toggleClass('selectedGoods');
	}

	$(document).ready(function() {
		/* 카테고리 불러오기 */
		category_admin_select_load('','selectCategory1','');
		$("select[name='selectCategory1']").bind("change",function(){
			category_admin_select_load('selectCategory1','selectCategory2',$(this).val());
			category_admin_select_load('selectCategory2','selectCategory3',"");
			category_admin_select_load('selectCategory3','selectCategory4',"");
		});
		$("select[name='selectCategory2']").bind("change",function(){
			category_admin_select_load('selectCategory2','selectCategory3',$(this).val());
			category_admin_select_load('selectCategory3','selectCategory4',"");
		});
		$("select[name='selectCategory3']").bind("change",function(){
			category_admin_select_load('selectCategory3','selectCategory4',$(this).val());
		});

		/* 브랜드 불러오기 */
		brand_admin_select_load('','selectBrand1','');
		$("select[name='selectBrand1']").bind("change",function(){
			brand_admin_select_load('selectBrand1','selectBrand2',$(this).val());
			brand_admin_select_load('selectBrand2','selectBrand3',"");
			brand_admin_select_load('selectBrand3','selectBrand4',"");
		});
		$("select[name='selectBrand2']").bind("change",function(){
			brand_admin_select_load('selectBrand2','selectBrand3',$(this).val());
			brand_admin_select_load('selectBrand3','selectBrand4',"");
		});
		$("select[name='selectBrand3']").bind("change",function(){
			brand_admin_select_load('selectBrand3','selectBrand4',$(this).val());
		});

		/* 이벤트 선택 */
		$("select[name='selectEvent']").bind("change",function(){
			event_admin_select_load('selectEvent','selectEventBenefits',$(this).val());
		}).change();

		/* 지역 불러오기 */
		location_admin_select_load('','selectLocation1','');
		$("select[name='selectLocation1']").bind("change",function(){
			location_admin_select_load('selectLocation1','selectLocation2',$(this).val());
			location_admin_select_load('selectLocation2','selectLocation3',"");
			location_admin_select_load('selectLocation3','selectLocation4',"");
		});
		$("select[name='selectLocation2']").bind("change",function(){
			location_admin_select_load('selectLocation2','selectLocation3',$(this).val());
			location_admin_select_load('selectLocation3','selectLocation4',"");
		});
		$("select[name='selectLocation3']").bind("change",function(){
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


		$("div.targetGoods").live('dblclick',function(event){
			$(this).remove();
			$('.result_lay').html('');
		});

		apply_input_style();
	});
</script>
<style>
	.selectedGoods{ background-color:#e7f2fc; }
	.targetGoods {padding:4px; overflow:hidden; cursor:pointer}
	.targetGoods .image {padding-right:4px;}
	.targetGoods .name {display:block; width:300px; overflow:hidden; white-space:nowrap;}
	.info-table-style label {margin-right:10px;}
</style>

<div id="goodsSelectorSearch">
	<form action="../goods/select_list" method="get" target="select_bigdata">
	<input type="hidden" name="goods_review" value="<?php echo $_GET["goods_review"]?>" />
	<input type="hidden" name="type" value="<?php echo $_GET["type"]?>" />
	<input type="hidden" name="select_one_goods_callback" value="<?php echo $_GET["select_one_goods_callback"]?>" />
	<input type="hidden" name="inputGoods" value="bigdata" />
	<input type="hidden" name="displayId" value="<?php echo $_GET["displayId"]?>" />
	<input type="hidden" name="bigdata_test" value="1" />

	<table class="info-table-style" width="100%" border="0" cellpadding="0" cellspacing="0">
		<col width="15%" /><col width="40%" /><col width="15%" /><col />
		<tr>
			<th class="its-th-align">검색어</th>
			<td class="its-td" colspan="3">
				<input type="text" name="selectGoodsName" value="" title="상품명(매입상품명), 상품코드" style="width:98%"  />
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
				<input type="text" name="selectStartPrice" size="6" value="" class="onlynumber"  /> 원부터 ~
				<input type="text" name="selectEndPrice" size="6" value="" class="onlynumber"  /> 원까지
			</td>
		</tr>
		<tr>
			<th class="its-th-align">이벤트</th>
			<td class="its-td" colspan="3">
				<strong>할인이벤트 </strong>&nbsp;
				<select name="selectEvent">
					<option value="">이벤트 선택</option>
<?php if($TPL_eventData_1){foreach($TPL_VAR["eventData"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["event_seq"]?>">[<?php echo $TPL_V1["status"]?>] <?php echo $TPL_V1["title"]?></option>
<?php }}?>
				</select>&nbsp; &nbsp; 
				<select name="selectEventBenefits"  class="hide"></select>
				<strong>사은품이벤트 </strong>&nbsp;
				<select name="selectGift">
					<option value="">이벤트 선택</option>
<?php if($TPL_giftData_1){foreach($TPL_VAR["giftData"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["gift_seq"]?>">[<?php echo $TPL_V1["status"]?>] <?php echo $TPL_V1["title"]?></option>
<?php }}?>
				</select>
			</td>
		</tr>
	</table>
	<div class="mt15 center">
		<span class="btn large cyanblue"><button type="submit" id="selectSearchButton">검색</button></span>
	</div>
	</form>
</div>
<div style="height:20px;"></div>

<table style="width:100%">
	<col>
	<col width="5">
	<col width="50%">
	<tr>
		<td valign="top">
			<div style="background-color:#f1f1f1; font-weight:normal;border-collapse:collapse; border:1px solid #aaa;height:30px; line-height:15px;padding:4px;">검색된 상품 리스트<div><span class="desc">상품을 클릭하면 선택됩니다.</span></div></div>
			<iframe width="100%" height="<?php echo $TPL_VAR["containerHeight"]?>" frameborder="0" src="../goods/select_list?inputGoods=bigdata&displayId=&onlyType=<?php echo $_GET["onlyType"]?>&adminshipping=<?php echo $_GET["adminshipping"]?>&adminOrder=<?php echo $_GET["adminOrder"]?>&init=Y&goods_review=<?php echo $_GET["goods_review"]?>&type=<?php echo $_GET["type"]?>&select_one_goods_callback=<?php echo $_GET["select_one_goods_callback"]?>&bigdata_test=1&bigdata_no=<?php if($_GET["no"]){?><?php echo $_GET["no"]?><?php }else{?><?php echo $_POST["no"]?><?php }?>&selectGoodsName=<?php if($_GET["no"]){?><?php echo $_GET["no"]?><?php }else{?><?php echo $_POST["no"]?><?php }?>" name="select_bigdata"></iframe>
		</td>
<?php if($_GET["type"]!='select_one_goods'){?>
		<td></td>
		<td valign="top">
			<div style="background-color:#f1f1f1; font-weight:normal;border-collapse:collapse; border:1px solid #aaa;height:30px; line-height:15px;padding:4px;">선택된 상품 <br /> <span class="desc">상품을 더블클릭하면 제외됩니다.</span></div>
			<div id="targetList" style="height:<?php echo $TPL_VAR["containerHeight"]?>px;overflow:auto;"></div>
		</td>
<?php }?>
	</tr>
</table>