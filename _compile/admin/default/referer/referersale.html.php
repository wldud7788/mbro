<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/referer/referersale.html 000018741 */ 
$TPL_issuegoods_1=empty($TPL_VAR["issuegoods"])||!is_array($TPL_VAR["issuegoods"])?0:count($TPL_VAR["issuegoods"]);
$TPL_issuecategorys_1=empty($TPL_VAR["issuecategorys"])||!is_array($TPL_VAR["issuecategorys"])?0:count($TPL_VAR["issuecategorys"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin/gProviderSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gGoodsSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gCategorySelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/refererRegist.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript">
var referersaleData = {
					'referersaleSeq':'<?php echo $TPL_VAR["referer"]["referersale_seq"]?>',
					'issueType':"<?php echo $TPL_VAR["referer"]["issue_type"]?>",
					'saleType':'<?php echo $TPL_VAR["referer"]["sale_type"]?>',
					'salesTag':'<?php if(count($TPL_VAR["referer"]["provider_name_list"])> 0){?>provider<?php }else{?>admin<?php }?>',
					'pageMode':'<?php echo $TPL_VAR["mode"]?>'};
</script>

<?php if($TPL_VAR["referer"]["referersale_seq"]){?>
<form name="detailForm" id="detailForm" method="post" action="../referer_process/modify" target="actionFrame">
<input type="hidden" name="referersaleSeq" value="<?php echo $TPL_VAR["referer"]["referersale_seq"]?>" />
<?php }else{?>
<form name="detailForm" id="detailForm" method="post" action="../referer_process/regist" target="actionFrame">
<?php }?>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area"  class="gray-bar">
	<div id="page-title-bar">
		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><button type="button" class="resp_btn v3 size_L" onclick="document.location.href='../referer/catalog';">리스트 바로가기</button></li>
		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>유입경로 할인 <?php if($TPL_VAR["referer"]["referersale_seq"]){?>수정<?php }else{?>등록<?php }?> </h2>
		</div>
		<!-- 우측 버튼 -->

		<ul class="page-buttons-right">
			<li><button type="submit" class="resp_btn active2 size_L">저장</button></li>
		</ul>
	</div>
</div>

<div class="contents_container">

	<div class="item-title">기본정보</div>
	
	<table class="table_basic thl">		
		
		<tr>
			<th>유입경로명 <span class="required_chk"></span></th>
			<td <?php if($TPL_VAR["referer"]["referersale_seq"]){?>colspan="3"<?php }?>>				
<?php if($TPL_VAR["referer"]["referersale_seq"]){?>
				<?php echo $TPL_VAR["referer"]["referersale_name"]?>

<?php }else{?>
				<div class="resp_limit_text limitTextEvent">
					<input type="text" class="resp_text" name="refererName" maxLength="30" size="50" value="<?php echo $TPL_VAR["referer"]["referersale_name"]?>" />
				</div>
<?php }?>
			</td>
		</tr>	

		<tr>
			<th>유입경로 설명</th>
			<td <?php if($TPL_VAR["referer"]["referersale_seq"]){?>colspan="3"<?php }?>>				
<?php if($TPL_VAR["referer"]["referersale_seq"]){?>
				<?php echo $TPL_VAR["referer"]["referersale_desc"]?>

<?php }else{?>
				<div class="resp_limit_text limitTextEvent">
					<input type="text" class="resp_text" size="50"  maxLength="50" name="refererDesc" value="<?php echo $TPL_VAR["referer"]["referersale_desc"]?>" />
				</div>
<?php }?>
			</td>
		</tr>	
		
<?php if($TPL_VAR["referer"]["referersale_seq"]){?>
		<tr>
			<th>등록일</th>
			<td><?php echo $TPL_VAR["referer"]["regist_date"]?></td>
			<th>수정일</th>
			<td><?php echo $TPL_VAR["referer"]["update_date"]?></td>
		</tr>
<?php }?>
		
	</table>

	<div class="item-title">유입 경로 설정</div>
	
	<table class="table_basic thl">		
		<tr>
			<th>
				유입경로 URL <span class="required_chk"></span>
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip4')"></span>
			</th>
			<td>
				http://<?php if($TPL_VAR["referer"]["referersale_seq"]){?><?php echo $TPL_VAR["referer"]["referersale_url"]?>

					<input type="hidden" name="refererUrl" value="<?php echo $TPL_VAR["referer"]["referersale_url"]?>" />
<?php }else{?>
					<input type="text" class="line" size="70" name="refererUrl" value="<?php echo $TPL_VAR["referer"]["referersale_url"]?>" />
					<button type="button" class="referer-url-chk-btn resp_btn v2">중복확인</button>
<?php }?>
			</td>				
		</tr>

		<tr>
			<th>URL 범위</th>
			<td>
<?php if($TPL_VAR["referer"]["referersale_seq"]){?>
<?php if($TPL_VAR["referer"]["url_type"]=='like'){?>유입경로 URL 포함 시<?php }else{?>유입경로 URL과 일치 시<?php }?>
<?php }else{?>
					<div class="resp_radio">
						<label><input type="radio" name="refererUrlType" value="equal" checked="checked" > 유입경로 URL과 일치 시</label>
						<label><input type="radio" name="refererUrlType" value="like" > 유입경로 URL 포함 시</label>							
					</div>	
<?php }?>
			</td>				
		</tr>
	</table>


<?php if(serviceLimit('H_AD')){?>

	<div class="item-title">혜택 부담 설정</div>

	<table class="table_basic thl">		
		<tr>
			<th>대상</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="sales_tag" value="admin" > 본사 상품</label>
					<label><input type="radio" name="sales_tag" value="provider" > 입점사 상품</label>			
				</div>	
			</td>
		</tr>

		<tr class="sales_tag_provider hide provider">
			<th>입점사 지정 <span class="required_chk"></span></th>
			<td>
				<input type="button" value="입점사 선택" class="btn_provider_select resp_btn active"/>
				
				<div class="mt10 wx500">
					<div class="provider_list_header">
						<table class="table_basic tdc">
						<colgroup>
							<col width="40%" />
							<col width="40%" />
							<col width="20%" />
						</colgroup>
						<thead>
							<tr class="nodrag nodrop">
								<th>입점사명</th>
								<th>정산 방식</th>		
								<th>삭제</th>	
							</tr>
						</thead>
						</table>
					</div>
					<div class="provider_list">
						<table class="table_basic fix">
							<colgroup>
								<col width="40%" />
								<col width="40%" />
								<col width="20%" />
							</colgroup>
							<tbody>
								<tr rownum=0 <?php if(count($TPL_VAR["referer"]["provider_name_list"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
									<td class="center" colspan="3">입점사를 선택하세요</td>
								</tr>
<?php if(is_array($TPL_R1=$TPL_VAR["referer"]["provider_name_list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<tr rownum="<?php echo $TPL_V1["provider_seq"]?>">
								<td class="center"><?php echo $TPL_V1["provider_name"]?></td>
								<td class="center"><?php echo $TPL_V1["commission_text"]?></td>
								<td class="center">
									<input type="hidden" name="salescost_provider_list[]" value="<?php echo $TPL_V1["provider_seq"]?>">
									<button type="button" class="btn_minus" selectType="provider" seq="<?php echo $TPL_V1["provider_seq"]?>" onClick="gProviderSelect.select_delete('minus',$(this))"></button></td>
							</tr>
<?php }}?>
							</tbody>
						</table>
					</div>
				</div>
				<input type="hidden" name="provider_seq_list" value="<?php echo $TPL_VAR["referer"]["provider_list"]?>" />				
			</td>
		</tr>

		<tr class="sales_tag_provider hide">
			<th>입점사 부담률 <span class="required_chk"></span></th>
			<td>				
				<input type="text" name="salescostper" size="3" maxlength="3" value="<?php if($TPL_VAR["referer"]["referersale_seq"]> 0&&$TPL_VAR["referer"]["provider_name_list"]){?><?php echo $TPL_VAR["referer"]["salescost_provider"]?><?php }else{?>0<?php }?>" class="line onlynumber right" /> %
				<span class="desc red msg"></span>
				<input type="hidden" name="salescost_provider" value="<?php if($TPL_VAR["referer"]["referersale_seq"]> 0&&$TPL_VAR["referer"]["provider_name_list"]){?><?php echo $TPL_VAR["referer"]["salescost_provider"]?><?php }else{?>0<?php }?>" />
			</td>
		</tr>

		<tr class="sales_admin">
			<th>본사 부담률</th>
			<td>				
				<span class="percent"><?php if($TPL_VAR["referer"]["referersale_seq"]> 0&&$TPL_VAR["referer"]["provider_name_list"]){?><?php echo $TPL_VAR["referer"]["salescost_admin"]?><?php }else{?>100<?php }?>%</span>
				<input type="hidden" name="salescost_admin" value="<?php if($TPL_VAR["referer"]["referersale_seq"]> 0&&$TPL_VAR["referer"]["provider_name_list"]){?><?php echo $TPL_VAR["referer"]["salescost_admin"]?><?php }else{?>100<?php }?>" />
			</td>
		</tr>
	</table>
	<div class="resp_message">- 할인 항목별 할인 금액 <a href="https://www.firstmall.kr/customer/faq/1240 " class="resp_btn_txt" target="_blank">자세히 보기</a>
<?php }?>

	<div class="item-title">혜택 설정</div>

	<table class="table_basic thl">		
		<tr>
			<th>
				혜택 <span class="required_chk"></span>
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip3')"></span>
			</th>
			<td>
				<input type="text" name="percentGoodsSale" size="8" maxlength="3" class="resp_text onlynumber right saleType_percent hide " value="<?php if($TPL_VAR["referer"]["percent_goods_sale"]){?><?php echo $TPL_VAR["referer"]["percent_goods_sale"]?><?php }else{?>0<?php }?>" />

				<input type="text" name="wonGoodsSale" size="8" class="resp_text <?php echo $TPL_VAR["only_numberic_type"]?> right saleType_won hide" value="<?php if($TPL_VAR["referer"]["won_goods_sale"]){?><?php echo $TPL_VAR["referer"]["won_goods_sale"]?><?php }else{?>0<?php }?>" />	

				<select name="saleType" class="resp_select">
					<option value="percent">%</option>
					<option value="won"><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?></option>
				</select>

				<span class="ml20 saleType_percent hide">
					최대 <input type="text" name="maxPercentGoodsSale" size="8" value="<?php if($TPL_VAR["referer"]["max_percent_goods_sale"]){?><?php echo $TPL_VAR["referer"]["max_percent_goods_sale"]?><?php }else{?>0<?php }?>" class="resp_text <?php echo $TPL_VAR["only_numberic_type"]?> right "/> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

				</span>				
				 할인				 
				 <div class="resp_message v2">- 상품의 판매 금액 수량 1개당 적용</div>
			</td>
		</tr>

		<tr>
			<th>
				상품 최소 주문 금액
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip7')"></span>
			</th>
			<td>				
				해당 상품 <input type="text" name="limitGoodsPrice" size="6" value="<?php if($TPL_VAR["referer"]["limit_goods_price"]){?><?php echo $TPL_VAR["referer"]["limit_goods_price"]?><?php }else{?>0<?php }?>" class="<?php echo $TPL_VAR["only_numberic_type"]?> right " /><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상 구매 시 사용 가능
			</td>
		</tr>

		<tr>
			<th>유효기간 <span class="required_chk"></span></th>
			<td>				
				<input type="text" name="issueDate[]" value="<?php echo $TPL_VAR["referer"]["issue_startdate"]?>" class="datepicker resp_text"  maxlength="10" size="10" /> ~ <input type="text" name="issueDate[]" value="<?php echo $TPL_VAR["referer"]["issue_enddate"]?>" class="datepicker resp_text"  maxlength="10" size="10" />	
			</td>
		</tr>
	</table>

	<div class="item-title">유입 경로 할인 제한</div>

	<table class="table_basic thl">		
		<tr>
			<th>상품/카테고리 제한</th>
			<td class="clear">
				<ul class="ul_list_02">
					<li>
						<div class="resp_radio">
							<label><input type="radio" name="issue_type" id="issue_type0" value="all" checked="checked" > 제한 없음</label>
							<label><input type="radio" name="issue_type" id="issue_type1" value="issue" > 선택한 상품/카테고리만</label>
							<label><input type="radio" name="issue_type" id="issue_type2" value="except" > 선택한 상품/카테고리를 제외</label>
						</div>
					</li>
					<li class="clear issue_type_issue issue_type_except hide">
						<table class="table_basic thl v3 t_select_goods">
							<tbody>
								<tr class="t_goods">
									<th>상품</th>
									<td>
										<input type="button" value="상품 선택" class="btn_select_goods resp_btn active" />
										<input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" selectType="goods" />
										<div class="mt10 wx600">
											<div class="goods_list_header">
												<table class="table_basic tdc">
													<colgroup>
														<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
														<col width="25%" />
														<col width="45%" />
<?php }else{?>
														<col width="70%" />
<?php }?>
														<col width="20%" />
													</colgroup>
													<tbody>
														<tr>
														<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" value="goods"></label></th>
<?php if(serviceLimit('H_AD')){?>
															<th>입점사명</th>
<?php }?>
															<th>상품명</th>
															<th>판매가</th>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="goods_list">
												<table class="table_basic tdc">
													<colgroup>
														<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
														<col width="25%" />
														<col width="45%" />
<?php }else{?>
														<col width="70%" />
<?php }?>
														<col width="20%" />
													</colgroup>
													<tbody>
														<tr rownum=0 <?php if(count($TPL_VAR["issuegoods"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
															<td class="center" colspan="4">상품을 선택하세요</td>
														</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->
<?php if($TPL_issuegoods_1){foreach($TPL_VAR["issuegoods"] as $TPL_V1){?>
														<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
															<td><label class="resp_checkbox"><input type="checkbox" name='issueGoodsTmp[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' /></label>
																<input type="hidden" name='issueGoods[]' value='<?php echo $TPL_V1["goods_seq"]?>' />
																<input type="hidden" name="issueGoodsSeq[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["issuegoods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
																<td><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
															<td class='left'>
																<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></div>
																<div class="goodsname">
<?php if($TPL_V1["goods_code"]){?><div>[상품코드:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
																	<div><?php echo $TPL_V1["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V1["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 30)?></a></div>
																</div>
															</td>
															<td class='right'><?php echo get_currency_price($TPL_V1["price"], 2)?></td>
														</tr>
<?php }}?>
													</tbody>
												</table>
											</div>
										</div>
									</td>
								</tr>
								<tr class="t_category">
									<th>카테고리</th>
									<td>
										<input type="button" value="카테고리 선택" class="btn_category_select resp_btn active" />
										<div class="mt10 wx600 category_list">
											<table class="table_basic fix">
												<colgroup>
													<col width="85%" />
													<col width="15%" />
												</colgroup>
												<thead>
													<tr class="nodrag nodrop">
														<th>카테고리명</th>
														<th>삭제</th>	
													</tr>
												</thead>
												<tbody>
													<tr rownum=0 <?php if(count($TPL_VAR["issuecategorys"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
														<td class="center" colspan="2">카테고리를 선택하세요</td>
													</tr>
<?php if($TPL_issuecategorys_1){foreach($TPL_VAR["issuecategorys"] as $TPL_V1){?>
													<tr rownum="<?php echo $TPL_V1["category_code"]?>">
														<td class="center"><?php echo $TPL_V1["category"]?></td>
														<td class="center">
															<input type="hidden" name='issueCategoryCode[]' value='<?php echo $TPL_V1["category_code"]?>' />
															<input type="hidden" name="issueCategoryCodeSeq[<?php echo $TPL_V1["category_code"]?>]" value="<?php echo $TPL_V1["issuecategory_seq"]?>" />
															<button type="button" class="btn_minus"  selectType="category" seq="<?php echo $TPL_V1["category_code"]?>" onClick="gCategorySelect.select_delete('minus',$(this))"></button>
														</td>
													</tr>
<?php }}?>
												</tbody>
											</table>
										</div>
									</td>
								</tr>
							</tbody>
							</table>
					</li>
				</ul>				
			</td>
		</tr>
	</table>

<?php if($TPL_VAR["referer"]["referersale_seq"]){?>
	<div class="item-title">관리자 테스트</div>

	<table class="table_basic thl">		
		<tr>
			<th>
				관리자 테스트
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip5')"></span>
			</th>
			<td>				
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
				<input type="button" name="testPC_btn" class="resp_btn" referersale_url="<?php echo $TPL_VAR["referer"]["referersale_url"]?>"  value="테스트" /> 
<?php }else{?>
				<input type="button" name="testPC_btn" class="resp_btn" referersale_url="<?php echo $TPL_VAR["referer"]["referersale_url"]?>"  value="PC 테스트" /> 
				<input type="button" name="testM_btn" class="resp_btn" referersale_url="<?php echo $TPL_VAR["referer"]["referersale_url"]?>"  value="Mobile 테스트" />
<?php }?>				
			</td>
		</tr>
	</table>
<?php }?>

</div>
</form>

<div id="lay_seller_select"></div><!-- 입점사 선택 레이어 -->
<div id="lay_goods_select"></div><!-- 상품선택 레이어 -->
<div id="lay_category_select"></div><!-- 카테고리 선택 레이어 -->


<?php $this->print_("layout_footer",$TPL_SCP,1);?>