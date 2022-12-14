<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/coupon/offline_coupon.html 000003198 */ ?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="utf8"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery_pagination/jquery.pager.js" charset="utf8"></script>
<script type="text/javascript">
$(document).ready(function() {
	getAjaxOfflineList();

	$("#submitbtn").click(function() {
		getAjaxOfflineList();
	});

});

/**
 * 상품을 ajax로 검색한다.
 * @param int page 페이지번호
 */
function getAjaxOfflineList(page) {
	var pageNumber = page ? page : 1;
   $("#getpage").val(pageNumber);
	var queryString = $('#offlinecoupon_search').formSerialize();
	var perpage = 20;
	$.ajax({
		type: 'post',
		url: '/admin/coupon_process/offline_coupon_list',
		data: queryString + '&perpage=' + perpage,
		dataType: 'json',
		success: function(data) {
			$('#ajaxTable').html(data.content);
			$('#searchcount').html(setComma(data.searchcount));
			$('#totalcount').html(setComma(data.totalcount));
			$('#nowpage').html(setComma(data.nowpage));
			$('#total_page').html(setComma(data.total_page));
			$("#pager").pager({ pagenumber: data.page, pagecount: data.pagecount, buttonClickCallback: pageClick });
		}
	});
}

/**
 * 페이징 클릭시 페이지를 로딩한다.
 * @param int page 페이지번호
 */
function pageClick(page) {
	$("#getpage").val(page);
	getAjaxOfflineList(page);
}

</script>

<form name="offlinecoupon_search" id="offlinecoupon_search"  method="post" >
<input type="hidden" name="no" value="<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>" >
<input type="hidden" name="page" id="getpage" value="<?php echo $_GET["page"]?>" >
<input type="hidden" name="orderby" id="orderby" value="<?php echo $_GET["orderby"]?>" >
<!-- 리스트검색폼 : 시작 -->
<div class="search_container">
	<div class="item-title">인증번호 검색</div>
	<table class="table_search">	
		<tr>
			<th>인증번호</th>
			<td>
				<input type="text" name="search_text" id="search_text" value="<?php echo $_GET["search_text"]?>" title="인증번호" />				
				<button type="button" class="resp_btn active " id="submitbtn">검색</button>		
			</td>
		</tr>
	</table>
</div>
</form>
<!-- 리스트검색폼 : 끝 -->

<div class="list_info_container mt10">
	<div class="dvs_left">	
		검색 <span id="searchcount" class="bold"><?php echo $TPL_VAR["sc"]["searchcount"]?>></span>개 (총 <span id="totalcount" class="bold"><?php echo $TPL_VAR["sc"]["totalcount"]?></span>개)
	</div>	
</div>

<div>
	<table class="table_basic tdc">
		<colgroup>
			<col width="30%" />
			<col width="70%" />
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>인증번호(<span class="red" >사용</span>)</th>
		</tr>
		</thead>
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