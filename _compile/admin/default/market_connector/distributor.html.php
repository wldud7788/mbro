<?php /* Template_ 2.2.6 2022/05/17 12:36:19 /www/music_brother_firstmall_kr/admin/skin/default/market_connector/distributor.html 000003878 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<!-- 2022.01.04 11월 4차 패치 by 김혜진 -->
<style>
	body{overflow: auto;}
</style>
<script type="text/javascript">
	var seller_id	= '';
	var marketObj	= <?php echo $TPL_VAR["marketsObj"]?>;
	var shopName	= '<?php echo strip_tags($TPL_VAR["config_basic"]["shopName"])?>';

	//객체동결(변경금지)
	Object.freeze(marketObj);
</script>
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
		<!--ul class="page-buttons-left">
			<li>
				<span class="btn large red"><button onclick="location.href='event_view?mode=sale_event';">전체 이벤트 페이지 설정</button></span>
			</li>
		</ul-->
		
		<!-- <?php if($TPL_VAR["MarketLinkage"]["shopCode"]=='shoplinker'){?> -->
<?php $this->print_("scm_login",$TPL_SCP,1);?>

		<!-- <?php }?> -->		

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>상품 등록</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<!--li><span class="helpicon" title=""></span></li-->
		</ul>

	</div>
</div>
<!-- //페이지 타이틀 바 -->

<!--div id="distTop" class="search-form-container" style=""></div-->
<!-- //검색폼 -->
<div class="contents_container">
	<div id="container" class="mt30">
		<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["params"]["page"]?>"/>
		<input type="hidden" name="limit" id="limit" value="100" />
		<input type="hidden" name="totalCount" id="totalCount" value="0" />
		
		<div id="standByList"  class="grid-wrap-lay">
			<div class="item-title">등록 대기 상품</div>			
			<div class="table_row_frame">	
				<div class="dvs_top">	
					<div class="dvs_left">	
						<button type="button" onclick="distDelete()" class="resp_btn v3">선택 삭제</button>
					</div>
					<div class="dvs_right">	
						<span id="distProductAdd"><button type="button" class="resp_btn active">상품추가</button></span>
						<span id="distStart" onClick="distStart();"><button type="button" class="resp_btn v2">배포시작</button></span>
					</div>
				</div>
				<div id="standByGrid" class="grid-lay"></div>		
				<div id="pagingNavigation" class="paging_navigation"></div>			
			</div>		
		</div>	

		<div id="distributeList"  class="grid-wrap-lay">	
			<div class="item-title">등록 결과</div>
			<div class="table_row_frame">	
				<div class="dvs_top">	
					<div class="dvs_left">	
						
					</div>
					<div class="dvs_right">	
						<button type="button" id="distPause" onClick="distPause();"  class="resp_btn v2">일시중지</button>
						<button type="button" id="distStop" onClick="distStop();"  class="resp_btn v2">배포중지</button>
					</div>
				</div>

				<div id="resultGrid" class="grid-lay"></div>
			</div>
			
			<div class="item-title">로그</div>
			<div class="message-lay"><div id="message" class='distributor-message'></div></div>
		</div>
	</div>	
</div>
<!--div id="distBottom" class="grid-lay"></div-->
<div id="lay_goods_select"></div><!-- 상품선택 레이어 -->
<?php $this->print_("distributor",$TPL_SCP,1);?>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>