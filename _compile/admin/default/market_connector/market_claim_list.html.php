<?php /* Template_ 2.2.6 2022/05/30 14:56:48 /www/music_brother_firstmall_kr/admin/skin/default/market_connector/market_claim_list.html 000005787 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script>
	var shopName	= '<?php echo strip_tags($TPL_VAR["config_basic"]["shopName"])?>';
	var marketObj	= <?php echo $TPL_VAR["marketsObj"]?>;
	var searchObj	= <?php echo $TPL_VAR["search"]?>;
	var claim_type = '<?php echo $TPL_VAR["claim_type"]?>';

	//객체동결(변경금지)
	Object.freeze(marketObj);
	Object.freeze(searchObj);
</script>
<style type="text/css">
	.footer.search_btn_lay{top: auto; left: calc(50% - 50px);}
</style>

<div id="page-title-bar-area" style="position:relative">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<!-- <?php if($TPL_VAR["MarketLinkage"]["shopCode"]=='shoplinker'){?> -->
<?php $this->print_("scm_login",$TPL_SCP,1);?>

		<!-- <?php }?> -->			
		<div class="page-title">
			<h2>
				<?php echo $TPL_VAR["claim_title"]?> 관리
			</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button id="orderCollectBtn" data-mode="<?php echo $TPL_VAR["claim_type"]?>" class="resp_btn active2 size_L"><?php echo $TPL_VAR["claim_title"]?> 요청 수집</button></li>			
		</ul>
	</div>
</div>
<!-- //페이지 타이틀 바 -->

<div id="distTop" class="search_container">	
	<form id="marketClaimForm">		
	<input type="hidden" name="totalCount" id="totalCount" value="0" cannotBeReset=1 />
	<input type="hidden" name="limit" id="limit" value="50" cannotBeReset=1 />
	<input type="hidden" name="page" id="page" value="1" />
	<input type="hidden" name="now_claim_type" id="now_claim_type" value="<?php echo $TPL_VAR["claim_type"]?>" cannotBeReset=1 />
	<input type="hidden" name="dateType" id="dateType" value="registeredTime" cannotBeReset=1 />
	
	<table class="table_search">		
		<tr>
			<th>				
<?php if($TPL_VAR["claim_type"]=="RTN"){?>
					반품
<?php }elseif($TPL_VAR["claim_type"]=="CAN"){?>
					취소
<?php }else{?>
					교환
<?php }?>				
				요청일
			</th>
			<td>
				<input type="hidden" name="dateType" id="dateType" value="registeredTime" />

				<input type="text" name="searchBeginDate" id="searchBeginDate" value="" class="datepicker line" maxlength="10" size="12" />
				-
				<input type="text" name="searchEndDate" id="searchEndDate" value="" class="datepicker line" maxlength="10" size="12" />
			</td>			
		</tr>
		<tr>
			<th>오픈 마켓</th>
			<td>
				<select name="market[]" id="selMarket" multiple="multiple" style="width:154px" class="selMarketClass variableCheck"></select>
				<select name="sellerId" id="selMarketUserId" style="width:135px" class="selMarketUserId">
					<option value="">관리자아이디</option>
				</select>
			</td>
		</tr>
	
		<tr>
			<th>
<?php if($TPL_VAR["claim_type"]=="RTN"){?>
			주문/반품번호
<?php }elseif($TPL_VAR["claim_type"]=="CAN"){?>
			환불/주문번호
<?php }else{?>
			주문/교환번호
<?php }?>
			</th>
			<td>
				<select name="searchType" >
					<option value="fmClaimCode">
<?php if($TPL_VAR["claim_type"]=="RTN"){?>
					쇼핑몰 반품 번호
<?php }elseif($TPL_VAR["claim_type"]=="CAN"){?>
					쇼핑몰 환불 번호
<?php }else{?>
					쇼핑몰 교환 번호
<?php }?>					
					</option>
					<option value="marketOrderNo">마켓 주문 번호</option>
				</select>
				<input type="text" name="keyword" value="" title="" />
			</td>			
		</tr>	

		<tr>
			<th>주문 상태</th>
			<td>
				<div class="resp_radio">
<?php if($TPL_VAR["claim_type"]=='CAN'){?>
				<label><input type="radio" name="status" value="" checked> 전체</label>
				<label><input type="radio" name="status" value="CAN00"> 취소 요청</label>
				<label><input type="radio" name="status" value="CAN10"> 취소 완료</label>
				<!--label><input type="checkbox" name="status[]" value="CAN99"> 취소거부</label-->
<?php }elseif($TPL_VAR["claim_type"]=='RTN'){?>
				<label><input type="radio" name="status" value="" checked> 전체</label>
				<label><input type="radio" name="status" value="RTN00"> 반품 요청</label>
				<label><input type="radio" name="status" value="RTN10"> 반품 완료</label>
<?php }elseif($TPL_VAR["claim_type"]=='EXC'){?>
				<label><input type="radio" name="status" value="" checked> 전체</label>
				<label><input type="radio" name="status" value="EXC00"> 교환 요청</label>
				<label><input type="radio" name="status" value="EXC10"> 교환 완료</label>
<?php }?>
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
		<div id="claimList"  class="grid-wrap-lay-one table_row_frame">
			<div class="dvs_top">	
				<div class="dvs_left">	
<?php if($TPL_VAR["claim_type"]=='RTN'){?>
						<span id="distStart" onClick="claimRegister('return');" >
						<button type="button" class="resp_btn active">반품 등록</button></span>
<?php }elseif($TPL_VAR["claim_type"]=='EXC'){?>
						<span id="distStart" onClick="claimRegister('exchange');" >
						<button type="button" class="resp_btn active">교환 등록</button></span>
<?php }else{?>
						<span id="distStart" onClick="cancelProcess('complete');" >
						<button type="button" class="resp_btn active">취소 완료</button></span>
<?php }?>
				</div>
				<div class="dvs_right">	
				</div>
			</div>				
			<div id="claimListGrid" class="grid-lay"></div>
			<div class="message-lay">
				<div id="message" class="claim-message" style="overflow: auto;"></div>
			</div>
			<div id="pagingNavigation" class="paging_navigation"></div>
		</div>
	</div>
</div>
<!-- //검색 리스트 -->

<!-- 수동수집 -->
<div id="orderCollection" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>