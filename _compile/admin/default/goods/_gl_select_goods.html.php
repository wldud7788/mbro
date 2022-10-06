<?php /* Template_ 2.2.6 2022/05/17 12:31:59 /www/music_brother_firstmall_kr/admin/skin/default/goods/_gl_select_goods.html 000003353 */ ?>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=20200601"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery_pagination/jquery.pager.js" charset="utf8"></script>
<script type="text/javascript">
var search_opitons = {
				'pageid':'gl_select_goods',
				'search_mode':'<?php echo $TPL_VAR["sc"]["searchmode"]?>',
				'defaultPage':1,
				'divSelectLayId':'goods_search_container',
				'searchFormId':'selectGoodsFrm',
				'form_editor_use':false,
				'select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>'
				};

$(function() {

	/**
	 * 페이징 클릭시 페이지를 로딩한다.
	 * @param int page 페이지번호
	 */
	var pageClick = function(destPage) {
		getAjaxList(destPage);
	}
	
	/**
	 * 상품을 ajax로 검색한다.
	 * @param int page 페이지번호
	 */

	var getAjaxList = function(page) {

		var pageNumber	= page ? page : 1;

		$("#getpage").val(pageNumber);

		var queryString = $('#goods_search_container #selectGoodsFrm').serialize();
		var perpage		= 10;

		$.ajax({
			type	: 'post',
			url		: '/admin/goods/gl_select_goods_data',
			data	: queryString + '&perpage=' + perpage,
			dataType: 'json',
			success	: function(data) {
				var $layer = $('#' + search_opitons.divSelectLayId);
				$layer.find('#ajaxTable').html(data.content);
				$layer.find('#searchcount').html(setComma(data.searchcount));
				$layer.find('#totalcount').html(setComma(data.totalcount));
				$layer.find('#pager').pager({ pagenumber: data.nowpage, pagecount: data.pagecount, buttonClickCallback: pageClick });
			}
		});
	}

	gSearchForm.init(search_opitons,getAjaxList);
	getAjaxList();

});

</script>

<div class="content" id="goods_search_container">

	<div class="item-title">상품 검색</div>

	<!-- 리스트검색폼 : 시작 -->
<?php $this->print_("searchForm",$TPL_SCP,1);?>

	<!-- 리스트검색폼 : 끝 -->

	<div class="mt20">
		<ul class="left-btns clearbox">
			<li class="left">
				<div style="margin-top:rpx;">
					검색 <span id="searchcount" class="bold"><?php echo $TPL_VAR["sc"]["searchcount"]?></span>개 
					(총 <span id="totalcount" class="bold"><?php echo $TPL_VAR["sc"]["totalcount"]?></span>개)
				</div>
			</li>
		</ul>
		<div class="clearbox"></div>
		<table class="table_basic tdc goods_list">
		<colgroup>
			<col width="7%" />
			<col width="12%" />
<?php if(serviceLimit('H_AD')){?>
			<col width="15%"  />
<?php }?>
			<col />
			<col width="15%" />
		</colgroup>
		<thead>
			<tr>
				<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" title="전체선택"></label></th>
				<th>구분</th>
<?php if(serviceLimit('H_AD')){?>
				<th>입점사</th>
<?php }?>
				<th>상품명</th>
				<th>판매가</th>
			</tr>
		</thead>
		<tbody id="ajaxTable">
		</tbody>
		</table>

		<!-- 페이징 -->
		<div id="pager" class="paging_navigation center"></div>

	</div>
</div>

<div class="footer">
	<button type="button" class="confirmSelectGoods resp_btn active size_XL">선택</button>
	<button type="button" class="btnLayClose resp_btn v3 size_XL">닫기</button>
</div>