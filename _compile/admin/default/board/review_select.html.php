<?php /* Template_ 2.2.6 2022/05/17 12:30:56 /www/music_brother_firstmall_kr/admin/skin/default/board/review_select.html 000006898 */ ?>
<script type="text/javascript">
function keyMoveSelectedItem(e){
	if($("div#targetList div.selectedGoods").length){
		var sArr = new Array();
		if(event.keyCode == '38'){ // up
			$("div#<?php echo $_GET["displayId"]?> div#targetList div.targetBoard").each(function(idx){
				if( $(this).hasClass("selectedGoods") ){
					idx--;
					if( idx >= 0 ){
						$("div#<?php echo $_GET["displayId"]?> div#targetList div.targetBoard").eq(idx).before( $(this) );
					}
				}
			});
			select_<?php echo $_GET["displayId"]?>.apply_layer();
			document.body.focus();
			return false;
		}
		if(event.keyCode == '40'){ // down
			var i = 0;
			$("div#<?php echo $_GET["displayId"]?> div#targetList div.targetBoard").each(function(idx){
				if( $(this).hasClass("selectedGoods") ){
					sArr[i] = idx;
					i++;
				}
			});
			for(var i=sArr.length-1;i>=0;i--){
				var idx = sArr[i];
				var obj = $("div#<?php echo $_GET["displayId"]?> div#targetList div.targetBoard").eq(idx);
				idx++;
				if( idx < $("div#<?php echo $_GET["displayId"]?> div#targetList div.targetBoard").length ){
					$("div#<?php echo $_GET["displayId"]?> div#targetList div.targetBoard").eq(idx).after( obj );
				}
			}
			select_<?php echo $_GET["displayId"]?>.apply_layer();
			document.body.focus();
			return false;
		}

	}
}

document.onkeydown = function(e){return keyMoveSelectedItem(e);};

function targetBoard_click(obj){
	obj.toggleClass('selectedGoods');
}


$(document).ready(function() {
	$("div#<?php echo $_GET["displayId"]?> div.targetBoard").live('dblclick',function(){
		$(this).remove();
		select_<?php echo $_GET["displayId"]?>.apply_layer();
	});
});


/* 저장하기 */
function reviewsubmit(){
	document.reviewform.submit();
}

</script>
<style>
.selectedGoods{ background-color:#e7f2fc; }

/* 검색폼 양식 t */
div.search-form-container {background:#e6e9e9; padding:7px 0 10px 0;}
div.search-form-container table.search-form-table	{margin:auto;}
div.search-form-container table.sf-option-table th	{height:25px; text-align:left; padding-right:10px;}
div.search-form-container table.sf-keyword-table {width:100%; border:2px solid #000; background-color:#fff; table-layout:fixed;}
div.search-form-container table.sf-keyword-table .sfk-td-txt {padding-right:5px;}
div.search-form-container table.sf-keyword-table .sfk-td-txt input {width:100%; height:22px; border:0px; margin:0px; background-color:#fff; line-height:22px; text-align:center;}
div.search-form-container table.sf-keyword-table .sfk-td-btn {padding-left:2px; width:63px; text-align:center; border-left:1px solid #ccc;}
div.search-form-container table.sf-keyword-table .sfk-td-btn button {width:60px; height:22px; border:0px; background:url('/admin/skin/default/images/common/btn_search.gif') no-repeat center center; cursor:pointer}
div.search-form-container table.sf-keyword-table .sfk-td-btn button span {display:none}
</style>

<style>

.goodsviewbox1 {float:left;width:40%;padding-bottom: 5px; padding-left: 0px; padding-right: 0px; border-top: #efefef 0px solid; padding-top: 5px;}
.goodsviewbox1 .pic {width: 50px; float: left; vertical-align: top;}
.goodsviewbox1 .gdinfo {width:120px;line-height: 140%; float: left; margin-left: 10px;}
.goodsviewbox1 .gdinfo .goods_name {padding-bottom: 5px; padding-left: 0px; padding-right: 0px; padding-top: 0px;}
.goodsviewbox1 .gdinfo .price {font-family: dotum; color: #333333;}

.goodsviewbox2 {float:left;width:60%;padding-bottom: 5px; padding-left: 0px; padding-right: 0px; border-top: #efefef 0px solid; padding-top: 5px;}
.goodsviewbox2 .info { line-height: 140%;margin-left: 10px;}
.goodsviewbox2 .info .subject {width:250px;padding-bottom: 5px; padding-left: 0px; padding-right: 0px; color: #3c5899; font-weight: bold; padding-top: 0px;}
</style>
<div>
<div id="goodsSelectorSearch" class="search-form-container">

<form name="reviewform" action="../board/review_select_list" method="get" target="select_<?php echo $_GET["displayId"]?>">
	<input type="hidden" name="id" value="goods_review">
	<input type="hidden" name="inputBoard" value="<?php echo $_GET["inputBoard"]?>">
	<input type="hidden" name="displayId" value="<?php echo $_GET["displayId"]?>">

	<div align="center">
	<table class="sf-keyword-table" style="width:<?php if($_GET["goods_review"]){?>400px;<?php }else{?>500px;<?php }?>">
	<tr>
		<td class="sfk-td-txt"><input type="text" name="search_text" value="" title="상품명, 상품간략설명, 상품설명, 작성자, 아이디, 제목, 내용"></td>
		<td class="sfk-td-btn"><button type="button" onclick="reviewsubmit()"><span>검색</span></button></td>
	</tr>
	</table>
	</div>
	<div style="padding-top:5px" align="center">
		<span style="display:inline-block;width:300px">
		<label class="resp_checkbox"><input type="checkbox" name="isorder_seq" value="1"> 구매한 후기</label>
		<label class="resp_checkbox"><input type="checkbox" name="isimage" value="1"> 포토 후기</label>
		<label class="resp_checkbox"><input type="checkbox" name="best" value="checked"> 베스트 후기</label>
		</span>
		<span>
		<strong>정렬  </strong>
		<select name="orderby">
			<option value="gid asc, m_date asc" selected="selected">최근 작성순↓</option>
			<option value="gid desc, m_date desc">최근 작성순↑</option>
			<option value="hit desc">조회순↓</option>
			<option value="hit asc">조회순↑</option>
			<option value="score desc">평점순↓</option>
			<option value="score asc">평점순↑</option>
		</select>
		</span>
	</div>
</form>
</div>
<div style="height:5px"></div>
<table style="width:100%">
<col>
<col width="5">
<col width="50%">
<tr>
	<td valign="top">
	<div style="background-color:#f1f1f1; font-weight:normal;border-collapse:collapse; border:1px solid #aaa;height:30px; line-height:15px;padding:4px">검색된 상품후기 리스트 <div><span class="desc">상품후기을 클릭하면 선택됩니다.</span></div></div>
	<iframe width="100%" height="600" frameborder="0" src="../board/review_select_list?id=goods_review&&inputBoard=<?php echo $_GET["inputBoard"]?>&displayId=<?php echo $_GET["displayId"]?>" name="select_<?php echo $_GET["displayId"]?>"></iframe>
	</td>
	<td></td>
	<td valign="top">
	<div style="background-color:#f1f1f1; font-weight:normal;border-collapse:collapse; border:1px solid #aaa;height:30px; line-height:15px;padding:4px">선택된 상품후기 리스트 <div><span class="desc">상품후기를 더블클릭하면 제외됩니다. 노출순서는 클릭 후 키보드 방향키 ↑↓로변경하세요.</span></div></div>
	<div id="targetList" style="height:600px;overflow:auto"></div>
	</td>
</tr>
</table>
</div>