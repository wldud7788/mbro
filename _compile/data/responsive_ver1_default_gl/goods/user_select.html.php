<?php /* Template_ 2.2.6 2021/12/15 17:48:34 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/goods/user_select.html 000007203 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 상품 검색 - 상단부분 @@
- 파일위치 : [스킨폴더]/goods/user_select.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript">
function keyMoveSelectedItem(e){
	if($("div#targetList div.selectedGoods").length){
		var sArr = new Array();
		if(e.keyCode == '38'){ // up
			$("div#<?php echo $_GET["displayId"]?> div#targetList div.targetGoods").each(function(idx){
				if( $(this).hasClass("selectedGoods") ){
					idx--;
					if( idx >= 0 ){
						$("div#<?php echo $_GET["displayId"]?> div#targetList div.targetGoods").eq(idx).before( $(this) );
					}
				}
			});
		}
		if(e.keyCode == '40'){ // downt
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
		}
		select_<?php echo $_GET["displayId"]?>.apply_layer();
	}
}

document.onkeydown = function(){keyMoveSelectedItem(event);};

function targetGoods_click(obj){
	obj.toggleClass('selectedGoods');
}

$(document).ready(function() {

	/* 카테고리 불러오기 */
	category_select_load('','selectCategory1','');
	$("div#goodsSelectorSearch select[name='selectCategory1']").live("change",function(){
		category_select_load('selectCategory1','selectCategory2',$(this).val());
		category_select_load('selectCategory2','selectCategory3',"");
		category_select_load('selectCategory3','selectCategory4',"");
		//$('[name=selectCategory3], [name=selectCategory4]').hide();
	});
	$("div#goodsSelectorSearch select[name='selectCategory2']").live("change",function(){
		category_select_load('selectCategory2','selectCategory3',$(this).val());
		category_select_load('selectCategory3','selectCategory4',"");
		//$('[name=selectCategory4]').hide();
	});

	$("div#goodsSelectorSearch select[name='selectCategory3']").live("change",function(){
		category_select_load('selectCategory3','selectCategory4',$(this).val());
	});

	$("div#<?php echo $_GET["displayId"]?> div.targetGoods").live('dblclick',function(){
		$(this).remove();
		select_<?php echo $_GET["displayId"]?>.apply_layer();
	});

	// 카테고리 선택시 하위옵션 없는 항목 노출 X
	$( document ).ajaxComplete(function() {
		$('#categorySelect select').each(function() {
			var optionLength = $(this).find('option').length;
			if ( optionLength < 2 ) {
				$(this).hide();
			}
		});
	});



});
</script>

<div id="goodsSelectorSearch" class="search-form-container" >
	<form action="/goods/user_select_list" method="get" target="select_<?php echo $_GET["displayId"]?>" id="selectform<?php echo $_GET["displayId"]?>" >
		<input type="hidden" name="inputGoods" value="<?php echo $_GET["inputGoods"]?>" />
		<input type="hidden" name="displayId" value="<?php echo $_GET["displayId"]?>" />
		<input type="hidden" name="goods_review" value="<?php echo $_GET["goods_review"]?>" />
		<input type="hidden" name="order3month" value="<?php echo $TPL_VAR["order3month"]?>" />
		<input type="hidden" name="order_seq" value="<?php echo $_GET["order_seq"]?>" />

		<div class="inputbox_area">
			<input type="text" name="selectGoodsName" class="input_text" value="" placeholder="상품명(매입상품명), 상품코드" />
			<button type="submit" id="selectSearchButton" class="btn_resp size_b color2">검색</button>
		</div>

		<table class="table_row_a Thc Mt10" width="100%" cellpadding="0" cellspacing="0">
		<colgroup><col class="size_b"><col></colgroup>
		<tbody>
			<tr>
				<th><p>카테고리</p></th>
				<td>
					<div id="categorySelect" class="category_select">
						<select name="selectCategory1">
							<option value="">1차 카테고리</option>
						</select>
						<select name="selectCategory2" class="hide">
							<option value="">2차 카테고리</option>
						</select>
						<select name="selectCategory3" class="hide">
							<option value="">3차 카테고리</option>
						</select>
						<select name="selectCategory4" class="hide">
							<option value="">4차 카테고리</option>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<th><p>가격대</p></th>
				<td>
					<input type="text" name="selectStartPrice" value="" class="onlynumber size_price" /> ~
					<input type="text" name="selectEndPrice" value="" class="onlynumber size_price" />
				</td>
			</tr>
<?php if(!$_GET["isadmin"]){?>
			<tr>
				<th><p>구매여부</p></th>
				<td>
<?php if(defined('__ISUSER__')){?>
						<label ><input type="checkbox" name="mborder" value="1"  checked="checked" onclick="$('#selectform<?php echo $_GET["displayId"]?>').submit();"> 내가 구매한상품</label>
<?php }else{?>
						<label ><input type="checkbox" name="mborder" value="1" onclick="alert('로그인 후 이용해 주세요.')">내가 구매한 상품</label>
<?php }?>
				</td>
			</tr> 
<?php }?>
		</tbody>
		</table>
	</form>

	<div class="search_goods_result">
		<div class="searched_items">
			<h5 class="title_sub2"><b>검색된 상품 리스트</b></h5>
			<p class="desc center Pb10">상품을 클릭하여 선택</p>
			<!-- ------- 검색된 상품 리스트. 파일위치 : [스킨폴더]/goods/user_select_list.html ------- -->
			<iframe width="100%" height="1400" frameborder="0" src="/goods/user_select_list?iframe=1&inputGoods=<?php echo $_GET["inputGoods"]?>&displayId=<?php echo $_GET["displayId"]?>&bulkorder=<?php echo $_GET["bulkorder"]?>&goods_review=<?php echo $_GET["goods_review"]?>&mborder=1&order3month=<?php echo $TPL_VAR["order3month"]?>&order_seq=<?php echo $_GET["order_seq"]?>" name="select_<?php echo $_GET["displayId"]?>" id="select_<?php echo $_GET["displayId"]?>"></iframe>
			<!-- ------- 검색된 상품 리스트------- -->
		</div>
<?php if(!$_GET["goods_review"]){?>
		<div class="selected_items">
			<h5 class="title_sub2"><b>선택된 상품 리스트</b></h5>
			<p class="desc center Pb10">상품을 더블클릭하여 제외<!-- 노출순서는 클릭 후 키보드 방향키 ↑↓로변경하세요.--></p>
			<div id="targetList" class="board_goods_select_display v2 x1"></div>
			<p class="desc center" style="padding:10px 5px 0;">노출순서는 클릭 후 키보드 방향키 ↑↓로 변경</p>
			<div class="btn_area_a Pb5">
				<button type="button" class="btn_resp size_b color2" onclick="hideCenterLayer()">확인</button>
			</div>
		</div>
<?php }else{?>
		<div id="targetList" class="board_goods_select_display v2 x1" style="display:none;"></div>
<?php }?>
	</div>
</div>