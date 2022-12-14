<?php /* Template_ 2.2.6 2022/05/30 14:57:20 /www/music_brother_firstmall_kr/admin/skin/default/market_connector/market_product_list.html 000006855 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script>
	var shopName	= '<?php echo strip_tags($TPL_VAR["config_basic"]["shopName"])?>';
	var marketObj	= <?php echo $TPL_VAR["marketsObj"]?>;
	var searchObj	= <?php echo $TPL_VAR["search"]?>;

	//객체동결(변경금지)
	Object.freeze(marketObj);
	Object.freeze(searchObj);
</script>
<style type="text/css">
	.footer.search_btn_lay{top: auto; left: calc(50% - 50px);}
</style>
<form name="processFrom" id="processFrom" method="get" action="/admin/market_connector/market_setting">
	<input type="hidden" name="pageMode" value="<?php echo $TPL_VAR["pageMode"]?>" />
	<input type="hidden" name="searchMarket" value="" />
	<input type="hidden" name="detailMarket" value="" />
	<input type="hidden" name="accountSeq" value="" />
	<input type="hidden" name="chkSeq" value="" />
	<input type="hidden" name="linkMode" value="" />
	<input type="hidden" name="groupId" value="" />				
</form>
<div id="page-title-bar-area" style="position:relative">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<!-- <?php if($TPL_VAR["MarketLinkage"]["shopCode"]=='shoplinker'){?> -->
<?php $this->print_("scm_login",$TPL_SCP,1);?>

		<!-- <?php }?> -->				
		<div class="page-title">
			<h2>상품 관리</h2>
		</div>
	</div>
</div>
<!-- //페이지 타이틀 바 -->

<div id="distTop"  class="search_container">
	<form name="market_search_form" id="market_search_form" class="search_form">
	<input type="hidden" name="page" id="nowPage" value="1"/>	
	<table class="table_search">	
		<tr>
			<th>검색어</th>
			<td>
				<select name="searchType" style="width:145px">
					<option value="marketProductName">마켓 상품명</option>
					<option value="fmGoodsSeq"><?php echo strip_tags($TPL_VAR["config_basic"]["shopName"])?> 상품번호</option>
					<option value="marketProductCode">마켓 상품번호</option>
				</select>
				<input type="text" name="keyword" style="width:212px" value="" title="" />
			</td>		
		</tr>

		<tr>
			<th>날짜</th>
			<td>
				<div class="date_range_form" >
					<select name="dateType" style="width:145px">
						<option value="lastDistributedDate">최종 전송일</option>
						<option value="registeredDate">마켓 등록일</option>
						<option value="marketCloseDate">판매 종료일</option>
					</select>
					<input type="text" name="searchBeginDate" value="" class="datepicker sdate"  maxlength="10" size="12" />
					-
					<input type="text" name="searchEndDate" value="" class="datepicker edate" maxlength="10" size="12" />
					
					<div class="resp_btn_wrap">
						<input type="button" range="today" value="오늘" class="select_date resp_btn" />
						<input type="button" range="3day" value="3일간" class="select_date resp_btn" />
						<input type="button" range="1week" value="일주일" class="select_date resp_btn" />
						<input type="button" range="1month" value="1개월" class="select_date resp_btn" />
						<input type="button" range="3month" value="3개월" class="select_date resp_btn" />
						<input type="button" range="all"  value="전체" class="select_date resp_btn"/>
						<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden" />
					</div>
				</div>
			</td>		
		</tr>
		<tr>
			<th>오픈 마켓</th>
			<td class="its-td">
				<select name="market[]" id="selMarket" multiple="multiple" style="width:175px" class="selMarketClass variableCheck"></select>

				<select name="sellerId" id="selMarketUserId" style="width:145px" class="selMarketUserId">
					<option value="">관리자아이디</option>
				</select>

				<select name="status[]" multiple="multiple"  id="saleStatus" style="width:175px">
					<option value="210"> 판매중</option>
					<option value="100"> 승인전</option>
					<option value="105"> 승인요청</option>
					<option value="190"> 승인반려</option>
					<option value="saleOut"> 판매중지/종료 등</option>
				</select>

				<select name="lastResult" style="width:145px">
					<option value="">최종전송</option>
					<option value="Y">최종전송 성공</option>
					<option value="N">최종전송 실패</option>
				</select>
			</td>			
		</tr>
		<tr>
			<th>삭제 상품</th>
			<td>
				<label class="resp_checkbox"><input type="checkbox" name="market_product_status" id="market_product_status" defaultValue='false' value="D"/> 쇼핑몰 삭제 상품 포함</label>
			</td>
		</tr>
	</table>
	
	<div class="footer search_btn_lay"></div>
	</form>
</div>
<!-- //검색폼 -->

<div class="contents_container">
	<div id="container">
		<div id="marketProductList"  class="grid-wrap-lay">
			<div class="item-title">수정 대기 상품</div>
			<div class="table_row_frame">
				<div class="dvs_top">	
					<div class="dvs_left">	
						<span class="distStart" onClick="distStart('productSync');" ><button type="button" class="resp_btn active">판매 상태 불러오기</button></span>
						<!-- <?php if($TPL_VAR["confMarket"]!='shoplinker'){?> -->
<?php if($TPL_VAR["onlyMarket"]=='coupang'){?>
							<span class="distStart" onClick="distStart('productConfirm');" ><button type="button"  class="resp_btn v2">쿠팡 승인 요청</button></span>
<?php }else{?>
							<span class="distStart" onClick="openDialogAlert('먼저 쿠팡으로 검색해 주시기 바랍니다.');"><button type="button"  class="resp_btn v2">쿠팡 승인 요청</button></span>
<?php }?>
						<!-- <?php }?> -->
						<span class="distStart" onClick="distStart('productDelete');"><button type="button" class="resp_btn v3">선택 삭제</button></span>
					</div>		
					<div class="dvs_right">	
						<button type="button" id="distPause" onClick="distPause();" class="resp_btn v2">일시중지</button>
						<button type="button" id="distStop" onClick="distStop();" class="resp_btn v2">중지</button>
					</div>		
				</div>	
				<div id="marketProductGrid" class="grid-lay"></div>
			</div>				
		</div>
		
		<div id="marketProductLog"  class="grid-wrap-lay">
			<div class="item-title">로그</div>			
			<div class="table_row_frame">
			<div id="logGrid" class="grid-lay"></div>	
			</div>
			<div class="message-lay"><div id="message" class='distributor-message'></div></div>
		</div>
	</div>
<?php if($TPL_VAR["MarketLinkage"]["shopCode"]=='shoplinker'){?>
	<div class="resp_message">
		- 전송 완료된 상품의 그룹 정보 수정 방법 <a href="https://www.firstmall.kr/customer/faq/1310" class="resp_btn_txt" target="_blank">자세히 보기</a>
	</div>
<?php }?>
	<div id="pagingNavigation" class="paging_navigation ml0" style="width:70%;"></div>		
</div>

<!-- //검색 리스트 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>