<?php /* Template_ 2.2.6 2021/08/25 16:21:02 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/social_goods_group.html 000004999 */ ?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="utf8"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery_pagination/jquery.pager.js" charset="utf8"></script>
<script type="text/javascript">
$(document).ready(function() {
	getAjaxList();

	$("#registsubmitbtn").click(function() {
		var social_goods_group_name = $("#social_goods_group_name").val();
		if( !social_goods_group_name ) {
			alert("티켓상품그룹명을 입력해 주세요.");
			return false;
		}
		var search_text = $("#social_goods_group_search_text").val();
		if( !search_text || (search_text == $("#social_goods_group_search_text").attr("title")) ) {
			$("#social_goods_group_search_text").val('');
		}

		$.ajax({
		type: 'post',
		url: '../goods_process/social_goods_group_regist',
		data: '&provider_seq=<?php echo $_GET["provider_seq"]?>&social_goods_group_name=' + social_goods_group_name,
		dataType: 'json',
		success: function(data) {
			if(data.result == true){
				getAjaxList();
			}else{
				alert(data.msg);
				return false;
			}
		}
		});

	});


	$("#submitbtn").click(function() {
		var search_text = $("#social_goods_group_search_text").val();
		if( !search_text || (search_text == $("#social_goods_group_search_text").attr("title")) ) {
			alert("검색어를 입력해 주세요.");
			return false;
		}
		getAjaxList();
	});

	$( "#social_goods_group" ).submit(function( event ) {
		var search_text = $("#social_goods_group_search_text").val();
		if( !search_text || (search_text == $("#social_goods_group_search_text").attr("title")) ) {
			alert("검색어를 입력해 주세요.");
			return false;
		}else{
			getAjaxList();
		}
	});

});

/**
 * 상품을 ajax로 검색한다.
 * @param int page 페이지번호
 */
function getAjaxList(page) {
	var pageNumber = page ? page : 1;
	$("#getpage").val(pageNumber);
	var queryString = $('#social_goods_group_list').formSerialize();
	var perpage = 40;
	$.ajax({
		type: 'get',
		url: './social_goods_group_html',
		data: queryString+'&perpage=' + perpage,
		dataType: 'json',
		success: function(data) {
			$('#ajaxTable').html(data.content);
			$("#pager").pager({ pagenumber: data.page, pagecount: data.pagecount, buttonClickCallback: pageClick });
			setDefaultText();
		}
	});
}

/**
 * 페이징 클릭시 페이지를 로딩한다.
 * @param int page 페이지번호
 */
function pageClick(page) {
	var search_text = $("#social_goods_group_search_text").val();
	if( !search_text || (search_text == $("#social_goods_group_search_text").attr("title")) ) {
		$("#social_goods_group_search_text").val('');
	}
	$("#getpage").val(page);
	getAjaxList(page);
}

</script>
<?php if($_GET["type"]=='write'){?>
<div name="social_goods_group_regist" id="social_goods_group_regist" >
	<table class="sf-keyword-table" >
	<tr>
		<td class="left" ><span class="item-title">[<?php echo $_GET["provider_name"]?>] 티켓상품그룹</span></td>
		<td class="sfk-td-txt"><input type="text" name="social_goods_group_name" id="social_goods_group_name" value="" /></td>
		<td class="right"><span class="btn small"><button type="button" id="registsubmitbtn" >등록</button></span></td>
	</tr>
	</table>
</div>
<?php }?>
<!-- 리스트검색폼 : 시작 -->
<form name="social_goods_group" id="social_goods_group_list" >
<input type="hidden" name="type" value="<?php echo $_GET["type"]?>" >
<input type="hidden" name="provider_seq" value="<?php echo $_GET["provider_seq"]?>" >
<input type="hidden" name="sel_group_seq" value="<?php echo $_GET["sel_group_seq"]?>" >
<input type="hidden" name="group_seq" value="<?php echo $_GET["group_seq"]?>" >
<input type="hidden" name="page" id="getpage" value="<?php echo $_GET["page"]?>" >
<input type="hidden" name="orderby" id="orderby" value="<?php echo $_GET["orderby"]?>" >
<div class="search-form-container">
	<table class="sf-keyword-table">
	<tr>
		<td class="sfk-td-txt"><input type="text" name="search_text" id="social_goods_group_search_text" value="<?php echo $_GET["search_text"]?>" title="티켓상품그룹명" /></td>
		<td class="sfk-td-btn"><button type="button" id="submitbtn" ><span>검색</span></button></td>
	</tr>
	</table>
</div>
</form>
<!-- 리스트검색폼 : 끝 -->

<div >
	<table class="info-table-style" style="width:100%">
		<colgroup>
			<col width="20%" />
			<col width="20%"  />
			<col width="20%"  />
			<col width="20%"  />
			<col width="20%"  />
		</colgroup>
		<tbody id="ajaxTable"></tbody>
	</table>
</div>
<!-- 서브 레이아웃 영역 : 끝 -->

<!-- 페이징 -->
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td align="center" ><div id="pager" style='clear: both'></div></td>
</tr>
</table>