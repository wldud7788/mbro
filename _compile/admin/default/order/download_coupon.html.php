<?php /* Template_ 2.2.6 2022/05/17 12:36:38 /www/music_brother_firstmall_kr/admin/skin/default/order/download_coupon.html 000011810 */ ?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="utf8"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery_pagination/jquery.pager.js" charset="utf8"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#submitbtn").click(function() {
		getDownAjaxList();
	});
	$(".select_date").click(function() {
		switch($(this).attr("id")) {
			case 'today' :
				$("input[name='sdate']").val(getDate(0));
				$("input[name='edate']").val(getDate(0));
				break;
			case '3day' :
				$("input[name='sdate']").val(getDate(3));
				$("input[name='edate']").val(getDate(0));
				break;
			case '1week' :
				$("input[name='sdate']").val(getDate(7));
				$("input[name='edate']").val(getDate(0));
				break;
			case '1month' :
				$("input[name='sdate']").val(getDate(30));
				$("input[name='edate']").val(getDate(0));
				break;
			case '3month' :
				$("input[name='sdate']").val(getDate(90));
				$("input[name='edate']").val(getDate(0));
				break;
			default :
				$("input[name='sdate']").val('');
				$("input[name='edate']").val('');
				break;
		}
	});

	$('#display_quantity').bind('change', function() {
		$("#perpage").val($(this).val());
		$("#couponsearch").submit();
	});

	$('#display_orderby').bind('change', function() {
		$("#orderby").val($(this).val());
		$("#couponsearch").submit();
	});

	$("#download_search_text").click( function(){
		if($(this).val() == "주문번호, 아이디, 이름" ){
			$(this).val('');
		}
	});

	$(".userinfo").click(function(){
		var mseq = $(this).attr("mseq");
		alert(mseq);
		var href = "/admin/member/detail?member_seq="+mseq;
		var a = window.open(href, 'mbdetail', '');
		if ( a ) {
			a.focus();
		}
	});

	$('#checkboxAll').click(function() {
		checkAll(this, '.checkeds');
	});

	// 검색어 레이어 박스 : start
	$("#download_search_text").keyup(function () {
		if ($(this).val()) {
			$('.txt_keyword').text($(this).val());
			searchLayerOpen();
		}else{
			$('.searchLayer').hide();
		}
	});

	$("#download_search_text").focus(function () {
		if ($(this).val() && $(this).val()!=$(this).attr('title')) {
			$('.txt_keyword').text($(this).val());
			searchLayerOpen();
		}
	});

	$("a.link_keyword").click(function () {
		var sType = $(this).attr('s_type');
		$('#search_type').val(sType);
		$('.searchLayer').hide();
		getDownAjaxList();
	});

	
	$("#download_search_text").blur(function(){
		if("<?php echo $_GET["keyword"]?>" == $("#search_keyword").val()){
			$(".search_type_text").show();
		}
		setTimeout(function(){
			$('.searchLayer').hide()}, 500
		);
	});

	var offset = $("#download_search_text").offset();
	$('.search_type_text').css({
		'position' : 'absolute',
		'z-index' : 999,
		'left' : 0,
		'top' : 0,
		'width':$("#download_search_text").width()-1,
		'height':$("#download_search_text").height()-5
	});

	$(".search_type_text").click(function () {
		$(".search_type_text").hide();
		$("#search_keyword").focus();
	});

	$(".searchLayer ul li").hover(function() {
		$(".searchLayer ul li").removeClass('hoverli');
		$(this).addClass('hoverli');
	});
	
	getDownAjaxList();
});

function orderinfo(order_seq) {
	var href = "/admin/order/view?no="+order_seq;
	var a = window.open(href, 'orderdetail'+order_seq, '');
	if ( a ) {
		a.focus();
	}
}


function goodsinfo(goods_seq) {
	var href = "/admin/goods/regist?no="+goods_seq;
	var a = window.open(href, 'goodsdetail'+goods_seq, '');
	if ( a ) {
		a.focus();
	}
}

function userinfo(mseq){
	var href = "/admin/member/detail?member_seq="+mseq;
	var a = window.open(href, 'mbdetail'+mseq, '');
	if ( a ) {
		a.focus();
	}
}

/**
 * 상품을 ajax로 검색한다.
 * @param int page 페이지번호
 */
function getDownAjaxList(page) {
	var pageNumber = page ? page : 1;
   $("#getpage").val(pageNumber);
	var queryString = $('#downloadsearch').formSerialize();
	var perpage = 10;
	$.ajax({
		type: 'post',
		url: '/admin/order/get_use_coupon_list',
		data: queryString + '&perpage=' + perpage,
		dataType: 'json',
		success: function(data) {
			if(data) {
				$('#ajaxTable').html(data.content);
				$('#totalsaleprcie').html(setComma(data.totalsaleprcie));
				$('#searchcount').html(setComma(data.searchcount));
				$('#totalcount').html(setComma(data.totalcount));
				$('#nowpage').html(setComma(data.nowpage));
				$('#total_page').html(setComma(data.total_page));
				$("#pager").pager({ pagenumber: data.page, pagecount: data.pagecount, buttonClickCallback: pageClick });
			}
		}
	});
}

/**
 * 페이징 클릭시 페이지를 로딩한다.
 * @param int page 페이지번호
 */
function pageClick(page) {
	$("#getpage").val(page);
	getDownAjaxList(page);
}

//체크박스 색상
$("input[type='checkbox'][name='del[]']").live('change',function(){
	if($(this).is(':checked')){
		$(this).closest('tr').addClass('checked-tr-background');
	}else{
		$(this).closest('tr').removeClass('checked-tr-background');
	}
}).change();

// 쿠폰사용가능한 상품 조회하기 (적용대상조회)
function coupon_info_view(now){
	var coupon_type	 = $(now).attr("coupon_type");
	var download_seq	= $(now).attr("download_seq");
	var coupon_seq	  = $(now).attr("coupon_seq");
	openDialogPopup("쿠폰정보","onlinecoupontypePopupNew",{
		'width':'450',
		'url':'../coupon/coupongoodsreviewer',
		'data':{
			'no'   : download_seq,
			'coupon_type'  : coupon_type,
			'coupon_seq' : coupon_seq,
			'download_seq' : download_seq
		}
	});
}
	

function searchLayerOpen(){
	var offset = $("#download_search_text").offset();
	if( offset) {
		$('.searchLayer').css({
			'position' : 'absolute',
			'z-index' : 999,
			'left' : 2,
			'top' : '85%',
			'width':$("#download_search_text").width() + 3
		}).show();
	}
}

</script>
<!-- 서브 레이아웃 영역 : 시작 -->

<style>
.searchLayer {border: 2px solid #222222;};
</style>

<!-- 리스트검색폼 : 시작 -->
<div class="search-form-container">
	<form name="downloadsearch" id="downloadsearch" >
		<input type="hidden" name="page" id="getpage" value="<?php echo $_GET["page"]?>" >
		<input type="hidden" name="item_option_seq" id="item_option_seq" value="<?php echo $_GET["item_option_seq"]?>" >
		<table class="search-form-table relative">
			<tr>
				<td width="500">
					<table class="sf-keyword-table">
						<td class="sfk-td-txt"><input type="text" name="search_text" id="download_search_text" value="<?php if($TPL_VAR["search_text"]){?><?php echo $TPL_VAR["search_text"]?><?php }else{?>주문번호, 아이디, 이름<?php }?>" title="주문번호, 아이디, 이름" /></td>
						<td class="sfk-td-btn"><button type="button" id="submitbtn"><span>검색</span></button></td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<!-- 검색어 입력시 레이어 박스 : start -->
					<div class="searchLayer hide">
						<input type="hidden" name="search_type" id="search_type" value="<?php echo $TPL_VAR["search_type"]?>" />
						<ul class="searchUl">
							<li><a class="link_keyword" s_type="all" href="#"><span class="txt_keyword"></span> <span class="txt_title">-전체검색</span></a></li>
							<li><a class="link_keyword" s_type="coupon_name" href="#">쿠폰명: <span class="txt_keyword"></span> <span class="txt_title">-쿠폰 찾기</span></a></li>
							<li><a class="link_keyword" s_type="download_seq" href="#">쿠폰번호: <span class="txt_keyword"></span> <span class="txt_title">-쿠폰 찾기</span></a></li>
							<li><a class="link_keyword" s_type="order_seq" href="#">주문번호: <span class="txt_keyword"></span> <span class="txt_title">-주문 찾기</span></a></li>
							<li><a class="link_keyword" s_type="user_id" href="#">아이디: <span class="txt_keyword"></span> <span class="txt_title">-아이디 찾기</span></a></li>
							<li><a class="link_keyword" s_type="user_name" href="#">이름: <span class="txt_keyword"></span> <span class="txt_title">-이름 찾기</span></a></li>
						</ul>
					</div>
					<!-- 검색어 입력시 레이어 박스 : end -->
				</td>
			</tr>
		</table>
			<table class="search-form-table">
				<tr>
					<td>
						<table class="sf-option-table">
						<tr>
							<th><span><?php echo $TPL_VAR["coupons"]["downloaddatetitle"]?></span></th>
							<td>
								<input type="text" name="sdate" id="sdate_down" value="<?php echo $_GET["sdate"]?>" class="datepicker line"  maxlength="10" size="10" />
								&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
								<input type="text" name="edate" id="edate_down" value="<?php echo $_GET["edate"]?>" class="datepicker line" maxlength="10" size="10" />
								&nbsp;&nbsp;
								<span class="btn small"><input type="button"  id="today" value="오늘" class="select_date" /></span>
								<span class="btn small"><input type="button"  id="3day" value="3일간" class="select_date" /></span>
								<span class="btn small"><input type="button"  id="1week" value="일주일" class="select_date" /></span>
								<span class="btn small"><input type="button"  id="1month" value="1개월" class="select_date" /></span>
								<span class="btn small"><input type="button"  id="3month" value="3개월" class="select_date" /></span>
								<span class="btn small"><input type="button"  id="select_date_all"  value="전체" class="select_date"  /></span>
							</td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
	</form>
</div>
<!-- 리스트검색폼 : 끝 -->

<ul class="left-btns clearbox">
	<li><div style="margin-top:rpx;">검색 <span id="searchcount" style="color:#000000; font-size:11px; font-weight: bold"><?php echo $TPL_VAR["sc"]["searchcount"]?></span>개(현재 <span id="nowpage" ></span>/총 <span id="total_page" ><?php echo $TPL_VAR["sc"]["total_page"]?></span>페이지)</div></li>
</ul>

<div class="clearbox"></div>
<div >
	<table class="info-table-style" style="width:100%">
		<colgroup>
			<col width="4%" />
			<col width="14%" />
			<col width="6%" />
			<col width="8%" />
			<col width="10%" />
			<col />
			<col width="10%" />
			<col width="10%" />
			<col width="8%" />
			<col width="5%" />
			<col width="5%" />
			<col width="10%" />
			<col width="8%" />
		</colgroup>
		<thead>
		<tr>
			<th class="its-th-align center">번호</th>
			<th class="its-th-align center">쿠폰명</th>
			<th class="its-th-align center">아이디</th>
			<th class="its-th-align center">이름</th>
			<th class="its-th-align center">발급일</th>
			<th class="its-th-align center" nowrap>사용제한<br/><div >단독/금액/상품/환경/결제/유입</div></th>
			<th class="its-th-align center">유효기간</th>
			<th class="its-th-align center">혜택</th>
			<th class="its-th-align center">할인금액</th>
			<th class="its-th-align center">조회</th>
			<th class="its-th-align center">사용여부</th>
			<th class="its-th-align center">구매상품</th>
			<th class="its-th-align center">사용일</th>
		</tr>
		</thead>
		<tbody id="ajaxTable"></tbody>
	</table>
</div>

<!-- 서브 레이아웃 영역 : 끝 -->

<!-- 페이징 -->
<table align="center" border="0" cellpadding="0" cellspacing="0"  width="100%">
<colgroup>
	<col width="3%">
	<col >
</colgroup>
<tr>
	<td align="center" class="left-btns" ></td>
	<td align="center" ><div id="pager" style='clear: both'></div></td>
</tr>
</table>
<div id="onlinecoupontypePopupNew" class="hide"></div>