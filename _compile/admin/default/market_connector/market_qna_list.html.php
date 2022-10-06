<?php /* Template_ 2.2.6 2022/05/30 14:57:41 /www/music_brother_firstmall_kr/admin/skin/default/market_connector/market_qna_list.html 000003821 */ ?>
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

<div id="page-title-bar-area" style="position:relative">
	<div id="page-title-bar">
		<!-- <?php if($TPL_VAR["MarketLinkage"]["shopCode"]=='shoplinker'){?> -->
<?php $this->print_("scm_login",$TPL_SCP,1);?>

		<!-- <?php }?> -->	

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>문의 관리</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button id="orderCollectBtn" data-mode="QNA" class="resp_btn active2 size_L">문의 수집</button></li>			
		</ul>
	</div>
</div>
<!-- //페이지 타이틀 바 -->

<div id="distTop" class="search_container">			
	<form id="marketQnaForm">		
	<input type="hidden" name="totalCount" id="totalCount" value="0" />
	<input type="hidden" name="limit" id="limit" value="50" />
	<input type="hidden" name="page" id="page" value="1" />

	<table class="table_search">
		<tr>
			<th>문의일</th>
			<td>
				<input type="hidden" name="dateType" id="dateType" value="registeredTime" />
				<input type="text" name="searchBeginDate" id="searchBeginDate" value="" class="datepicker line" maxlength="10" size="12" />
				-
				<input type="text" name="searchEndDate" id="searchEndDate" value="" class="datepicker line" maxlength="10" size="12" />
			</td>
		</tr>

		<tr>
			<th>오픈마켓</th>
			<td>
				<select name="market[]" id="selMarket" multiple="multiple" style="width:154px" class="selMarketClass variableCheck"></select>
				<select name="sellerId" id="selMarketUserId" style="width:145px" class="selMarketUserId">
					<option value="">판매자 아이디</option>
				</select>
			</td>
		</tr>

		<tr>
			<th>최종 전송 상태</th>
			<td>		
				<div class="resp_radio">
					<label><input type="radio" name="lastResult" value="" checked> 전체</label>
					<label><input type="radio" name="lastResult" value="Y"> 전송 성공</label>
					<label><input type="radio" name="lastResult" value="N"> 전송 실패</label>
				</div>
			</td>
		</tr>
		
		<tr>
			<th>상태</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="fm_answer_yn" value="" checked> 전체</label>
					<label><input type="radio" name="fm_answer_yn" value="N"> 답변 대기</label>
					<label><input type="radio" name="fm_answer_yn" value="Y"> 답변 완료</label>
				</div>
			</td>
		</tr>		
	</table>
	<div class="footer search_btn_lay"></div>
	</form>
</div>
<!-- //검색폼 -->

<div class="contents_container">
	<div id="container">	
		<div id="marketQnaList"  class="grid-wrap-lay-one table_row_frame">
			<div class="dvs_top">	
				<div class="dvs_left">	
					<span onClick="distStart('qnaDelete');"><button type="button" class="resp_btn v3">선택 삭제</button>
				</div>				
			</div>	
			<div id="marketQnaListGrid" class="grid-lay"></div>
			<div class="message-lay">
				<div id="message" class="order-message" style="overflow: auto;"></div>
			</div>				
		</div>
	</div>
	<div id="pagingNavigation" class="paging_navigation"></div>
<!-- //검색 리스트 -->
</div>

<!-- 답변 등록 -->
<div id="answerDialog" class="hide"></div>

<!-- 전송 로그 -->
<div id="qnaLogDialog" class="hide"></div>

<!-- 수동수집 -->
<div id="orderCollection" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>