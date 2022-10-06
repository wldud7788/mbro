<?php /* Template_ 2.2.6 2022/05/17 12:31:05 /www/music_brother_firstmall_kr/admin/skin/default/coupon/regist.html 000061561 */ 
$TPL_coupon_category_1=empty($TPL_VAR["coupon_category"])||!is_array($TPL_VAR["coupon_category"])?0:count($TPL_VAR["coupon_category"]);
$TPL_salestoreitemloop_1=empty($TPL_VAR["salestoreitemloop"])||!is_array($TPL_VAR["salestoreitemloop"])?0:count($TPL_VAR["salestoreitemloop"]);
$TPL_couponGroups_1=empty($TPL_VAR["couponGroups"])||!is_array($TPL_VAR["couponGroups"])?0:count($TPL_VAR["couponGroups"]);
$TPL_issuegoods_1=empty($TPL_VAR["issuegoods"])||!is_array($TPL_VAR["issuegoods"])?0:count($TPL_VAR["issuegoods"]);
$TPL_issuecategorys_1=empty($TPL_VAR["issuecategorys"])||!is_array($TPL_VAR["issuecategorys"])?0:count($TPL_VAR["issuecategorys"]);
$TPL_salserefereritemloop_1=empty($TPL_VAR["salserefereritemloop"])||!is_array($TPL_VAR["salserefereritemloop"])?0:count($TPL_VAR["salserefereritemloop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-font-decoration.js"></script>
<script type="text/javascript" src="/app/javascript/js/base64.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>

<!-- @2020-03-01 UX/Ui개선에 따른 공통 css, script -->
<script type="text/javascript">
	// 저장된 값
	var couponData = {
		'coupon_seq'		: '<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>',
		'coupon_name'		: '<?php echo addslashes($TPL_VAR["coupons"]["coupon_name"])?>',
		'coupon_category' 	: '<?php echo $TPL_VAR["coupons"]["coupon_category"]?>',
		'coupon_type' 		: '<?php echo $TPL_VAR["coupons"]["coupon_type"]?>',
		'issued_method' 	: '<?php echo $TPL_VAR["coupons"]["issued_method"]?>',
	};
</script>
<?php if($TPL_VAR["adminissuebtn"]){?><!--쿠폰수동발급-->
<script type="text/javascript" src="/app/javascript/js/admin/gCouponIssued.js?mm=<?php echo date('Ym')?>"></script>
<?php }?>

<script type="text/javascript" src="/app/javascript/js/admin/couponComm.js?mm=<?php echo date('Ym')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gProviderSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gMemberGradeSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gGoodsSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gCategorySelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gRefererSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/couponRegist.js?mm=<?php echo date('Ymd')?>"></script>

<!-- @2020-03-01 UX/Ui개선에 따른 공통 css, script -->
<?php if($TPL_VAR["checkO2OService"]){?>
<script type="text/javascript" src="/app/javascript/js/o2o/admin-o2oCoupon.js"></script>
<?php }?>

<form name="couponRegist" id="couponRegist" method="post" enctype="multipart/form-data" action="../coupon_process/regist" target="actionFrame" data-mode='<?php echo $TPL_VAR["mode"]?>'>
<?php if($TPL_VAR["coupons"]["coupon_seq"]){?><input type="hidden" name="couponSeq" 		value="<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>"  /><?php }?>
	<input type="hidden" name="couponType" 		value="<?php echo $TPL_VAR["coupons"]["issued_method"]?>" data-couponCategory="<?php echo $TPL_VAR["coupons"]["coupon_category"]?>" data-couponType="<?php echo $TPL_VAR["coupons"]["coupon_type"]?>" >
	<input type="hidden" name="coupon_usetype" 	value="<?php echo $TPL_VAR["coupons"]["use_type"]?>" />
	<input type="hidden" name="query_string" 	value="<?php echo $TPL_VAR["query_string"]?>"/>

	<!-- 페이지 타이틀 바 : 시작 -->
	<div id="page-title-bar-area"  class="gray-bar">
		<div id="page-title-bar">
			<!-- 좌측 버튼 -->
			<ul class="page-buttons-left">
				<li><button type="button" onclick="document.location.href='../coupon/catalog?<?php echo $TPL_VAR["query_string"]?>';" class="resp_btn v3 size_L">리스트 바로가기</button></li>
			</ul>

			<!-- 타이틀 -->
			<div class="page-title">
				<h2>쿠폰 <?php if($TPL_VAR["coupons"]["coupon_seq"]){?>수정<?php }else{?>등록<?php }?> </h2>
			</div>
			<!-- 우측 버튼 -->
			<ul class="page-buttons-right">
				<li><button type="submit" class="resp_btn active2 size_L">저장</button></li>
			</ul>
		</div>
	</div>

	<div id="coupon_wrap" class="contents_container">

		<div class="warp">

			<!---- 0. 쿠폰 발급 현황 시작 ---->
<?php if($TPL_VAR["coupons"]["coupon_seq"]){?>
			<div class="item-title">쿠폰 발급 현황</div>
			<table class="table_basic thl">
				<tr>
					<th>발급 상태</th>
					<td colspan="3">
						<div class="resp_toggle">
							<label><input type="radio" name="issue_stop" value="1"/>발급 중지</label>
							<label><input type="radio" name="issue_stop" value="0"/>발급 중</label>
						</div>
						<script>
							addToggle('issue_stop', '<?php echo $TPL_VAR["coupons"]["issue_stop"]?>' );
						</script>
					</td>

				</tr>
<?php if($TPL_VAR["adminissuebtn"]){?>
				<tr>
					<th>발급</th>
					<td colspan="3"><button type="button" class="resp_btn active" onClick="gCouponIssued.open({'issued_type':'coupon','issued_seq':'<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>','download_limit':'<?php echo $TPL_VAR["coupons"]["download_limit"]?>'})">발급</button></td>
				</tr>
<?php }?>
				<tr>
					<th>발급 현황</th>
					<td colspan="3">발급 [<?php echo $TPL_VAR["coupons"]["downloadtotalbtn"]?>건] / 사용 [<?php echo $TPL_VAR["coupons"]["usetotalbtn"]?>건]
						<button type="button" class="downloadlist_btn resp_btn v2" coupon_seq="<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>" >조회</button>
					</td>
				</tr>
				<tr>
					<th>등록일</th>
					<td>
<?php if($TPL_VAR["coupons"]["regist_date"]){?>
						<?php echo $TPL_VAR["coupons"]["regist_date"]?>

<?php }else{?>
						<?php echo date("Y-m-d H:i:s")?>

<?php }?>
					</td>
					<th>수정일</th>
					<td><?php echo $TPL_VAR["coupons"]["update_date"]?></td>
				</tr>
			</table>
<?php }?>
			<!---- 0. 쿠폰 발급 현황 종료 ---->

			<!---- 1. 기본 정보 시작 ---->
			<div class="item-title">기본 정보</div>
			<table class="table_basic thl">
				<tr>
					<th>혜택 구분</th>
					<td >
						<div <?php if(!$TPL_VAR["coupons"]["coupon_seq"]){?>class="resp_radio"<?php }?>>
<?php if($TPL_VAR["coupons"]["coupon_seq"]){?>
						<input type="radio" name="coupon_category" value="<?php echo $TPL_VAR["coupons"]["coupon_category"]?>"  class='hide' checked /><?php echo $TPL_VAR["coupon_category"][$TPL_VAR["coupons"]["coupon_category"]]?>

<?php }else{?>
<?php if($TPL_coupon_category_1){foreach($TPL_VAR["coupon_category"] as $TPL_K1=>$TPL_V1){?>
						<label category="<?php echo $TPL_K1?>"><input type="radio" name="coupon_category" value="<?php echo $TPL_K1?>" <?php echo $TPL_VAR["checked_"]["coupon_category"][$TPL_K1]?> /> <?php echo $TPL_V1?></label>
<?php }}?>
<?php }?>
		</div>
		</td>
		</tr>
		<tr class="t_coupon_type">
			<th>쿠폰 유형</th>
			<td>
				<select name="coupon_type" coupon_category=''>
					<option value='0'>선택하세요</option>
				</select>
				<span class='coupon_type_msg'></span>
			</td>
		</tr>
		<tr class="t_issued_method">
			<th>발급 방법</th>
			<td class='issued_method' issued_method=''>
				<div <?php if(!$TPL_VAR["coupons"]["coupon_seq"]){?>class="resp_radio"<?php }?>></div>
	</td>
	</tr>
	<tr class="t_onoffline">
		<th>온라인/오프라인</th>
		<td class='onoffline' onoffline=''>
			<div class="resp_radio">
<?php if(!$TPL_VAR["coupons"]["coupon_seq"]){?>
				<label><input type="radio" name="sale_store" value="on"> 온라인</label>
				<label><input type="radio" name="sale_store" value="off"> 오프라인</label>
<?php }else{?>
<?php if($TPL_VAR["checked_"]['sale_store']['off']){?>오프라인<?php }else{?>온라인<?php }?>
				<input type="hidden" name="sale_store" value="<?php echo $TPL_VAR["coupons"]["sale_store"]?>" readonly>
<?php }?>
			</div>
		</td>
	</tr>
	<tr class="t_ordersheet">
		<th>오프라인 매장</th>
		<td>
			<div class="resp_checkbox">
<?php if($TPL_VAR["salestoreitemloop"]){?>
<?php if($TPL_salestoreitemloop_1){foreach($TPL_VAR["salestoreitemloop"] as $TPL_V1){?>
				<label>
					<input type="checkbox" name="sale_store_item[]" class="sale_store_item"
						   value="<?php echo $TPL_V1["o2o_store_seq"]?>"
<?php if($TPL_VAR["coupons"]["sale_store"]=='off'&&in_array($TPL_V1["o2o_store_seq"],$TPL_VAR["coupons"]["sale_store_item_arr"])){?>checked<?php }?>
					/> <?php echo $TPL_V1["pos_name"]?>

				</label>
<?php }}?>
<?php }else{?>
				<label>
					※ 사용될 매장 정보가 없습니다. 매장 정보를 등록하세요
					<a href="/admin/o2o/o2osetting" target="_blank">바로가기></a>
				</label>
				<div id="sale_store_item_Popup" class="hide">
					<div class="pdb20">
						쿠폰을 사용할 매장이 등록되어 있지 않습니다.<br /> 매장정보를 등록하여 주세요
					</div>
					<div class="pdb20">
						<a href="/admin/o2o/o2osetting" target="_blank">바로가기></a>
					</div>
				</div>
<?php }?>
			</div>
		</td>
	</tr>
	<tr class="t_coupon_name">
		<th>쿠폰명</th>
		<td>
			<div class="resp_limit_text limitTextEvent">
				<input type="text" class="resp_text" size="80" maxlength="30" name="couponName" value="<?php echo $TPL_VAR["coupons"]["coupon_name"]?>" />
			</div>
		</td>
	</tr>
	<tr>
		<th>쿠폰 설명</th>
		<td>
			<div class="resp_limit_text limitTextEvent">
				<input type="text" class="resp_text" size="80" maxlength="50" name="couponDesc" value="<?php echo $TPL_VAR["coupons"]["coupon_desc"]?>"  />
			</div>
		</td>
	</tr>
	</table>
	<div class="resp_message">- 쿠폰 발급 안내 <a href="https://www.firstmall.kr/customer/faq/1321 " class="resp_btn_txt" target="_blank">자세히 보기</a></div>
	<!---- 1. 기본 정보 종료 ---->

	<!---- 2. 전환포인트 시작 ---->
	<div class="item-title ui_conversion_point">전환 포인트</div>
	<table class="table_basic thl ui_conversion_point">
		<tr>
			<th>전환 포인트</th>
			<td>
				<input type="text" name="coupon_point" size="10"  maxlength="10" class="resp_text onlynumber right" value="<?php echo get_currency_price($TPL_VAR["coupons"]["coupon_point"], 1)?>" /> P 를 쿠폰으로 전환
			</td>
		</tr>
	</table>
	<!---- 2. 전환포인트 종료 ---->

	<!---- 3. 혜택 부담 설정 시작 ---->
<?php if(serviceLimit('H_AD')){?>
	<div class="item-title title_salescost_set"><span>혜택 부담 설정</span></div>
	<div class="div_salescost_set">
		<table class="table_basic thl">
			<tr class='t_discount_seller_type'>
				<th>적용 대상</th>
				<td>
					<div class="resp_radio">
						<label class="admin"><input type="radio" name="discount_seller_type"  value="admin" <?php echo $TPL_VAR["checked_"]['discount_seller_type']['admin']?>> 본사 <span>상품</span></label>
						<label class="provider"><input type="radio" name="discount_seller_type"  value="seller" <?php echo $TPL_VAR["checked_"]['discount_seller_type']['seller']?>> 입점사 <span>상품</span></label>
						<span class="all hide"><input type="radio" name="discount_seller_type"  value="all" <?php echo $TPL_VAR["checked_"]['discount_seller_type']['all']?>></span>
					</div>
					<span class="discount_seller_type_txt admin hide">본사 <span>상품</span></span>
					<span class="discount_seller_type_txt provider hide">입점사 <span>상품</span></span>
					<span class="discount_seller_type_txt all hide">
					본사 <span>상품</span>, 모든 입점사 <span>상품</span>
				</span>
				</td>
			</tr>
			<tr class="t_discount_seller_type_list provider">
				<th>입점사 지정</th>
				<td>
					<input type="button" value="입점사 선택" class="btn_provider_select resp_btn v2" />

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
								<tr rownum=0 <?php if(count($TPL_VAR["coupons"]["provider_name_list"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
								<td class="center" colspan="3">입점사를 선택하세요</td>
								</tr>
<?php if(is_array($TPL_R1=$TPL_VAR["coupons"]["provider_name_list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
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
					<!--<input type="hidden" name="provider_seq_list" value="<?php echo $TPL_VAR["coupons"]["provider_list"]?>" />-->
				</td>
			</tr>
			<tr class="salescost_rate provider">
				<th>입점사 부담률</th>
				<td>
					<input type="text" name="salescostper" size="3" maxlength="3" value="<?php if($TPL_VAR["coupons"]["coupon_seq"]> 0){?><?php echo $TPL_VAR["coupons"]["salescost_provider"]?><?php }else{?>0<?php }?>" class="line onlynumber right" />
<?php if(!$TPL_VAR["coupons"]["coupon_seq"]||$TPL_VAR["coupons"]["issued_method"]=='shipping'){?><span class="percent"><?php if($TPL_VAR["coupons"]["salescost_provider"]> 0){?><?php echo $TPL_VAR["coupons"]["salescost_provider"]?>%<?php }?></span><?php }?>%

					<span class="desc red msg"></span>
					<input type="hidden" name="salescost_provider" value="<?php if($TPL_VAR["coupons"]["coupon_seq"]> 0){?><?php echo $TPL_VAR["coupons"]["salescost_provider"]?><?php }else{?>0<?php }?>" />

				</td>
			</tr>
			<tr class="salescost_rate admin">
				<th>본사 부담률</th>
				<td>
					<span class="percent"><?php if($TPL_VAR["coupons"]["coupon_seq"]> 0){?><?php echo $TPL_VAR["coupons"]["salescost_admin"]?><?php }else{?>100<?php }?>%</span>
					<input type="hidden" name="salescost_admin" value="<?php if($TPL_VAR["coupons"]["coupon_seq"]> 0){?><?php echo $TPL_VAR["coupons"]["salescost_admin"]?><?php }else{?>100<?php }?>" />
				</td>
			</tr>
		</table>
		<div class="resp_message">- 할인 항목별 할인 금액 <a href="https://www.firstmall.kr/customer/faq/1240 " class="resp_btn_txt" target="_blank">자세히 보기</a></div>
	</div>
<?php }else{?>
	<input type="hidden" name="salescostper" value="<?php if($TPL_VAR["coupons"]["coupon_seq"]> 0){?><?php echo $TPL_VAR["coupons"]["salescost_provider"]?><?php }else{?>0<?php }?>">
	<input type="hidden" name="salescost_provider" value="<?php if($TPL_VAR["coupons"]["coupon_seq"]> 0){?><?php echo $TPL_VAR["coupons"]["salescost_provider"]?><?php }else{?>0<?php }?>">
	<input type="hidden" name="salescost_admin" value="<?php if($TPL_VAR["coupons"]["coupon_seq"]> 0){?><?php echo $TPL_VAR["coupons"]["salescost_admin"]?><?php }else{?>100<?php }?>">
<?php }?>
	<!---- 3. 혜택 부담 설정 종료 ---->


	<!---- 4. 혜택 설정 시작 ---->
	<div class="item-title">혜택 설정 <span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/coupon', '#tip_benefit_setting', 'sizeS')"></span></div>
	<div class="ui_benefit_setting">
		<table class="table_basic thl">
			<tr class="t_benefit">
				<th>혜택</th>
				<td>
					<div class="goods">
					<span class=""><!-- 기존 percentGoodsSale, wonGoodsSale 필드를 goodsSalePrice 로 saleType에 따라 나누어 씀 -->
						<input type="text" name="goodsSalePrice" size="12" class="onlynumber right" maxlength=10 value="<?php if(!$TPL_VAR["coupons"]["goods_sale_price"]){?>0<?php }else{?><?php echo get_currency_price($TPL_VAR["coupons"]["goods_sale_price"], 1)?><?php }?>" />
						<select name="saleType">
						<option value="percent" <?php echo $TPL_VAR["selected_"]['sale_type']['percent']?>>%</option>
						<option value="won" <?php echo $TPL_VAR["selected_"]['sale_type']['won']?>><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?></option>
						</select>
					</span>

						<span class="max_goods_sale_price ml20<?php if($TPL_VAR["selected_"]['sale_type']['won']){?> hide<?php }?>">
						최대 <input type="text" name="maxPercentGoodsSale" size="12" maxlength="10" value="<?php if(!$TPL_VAR["coupons"]["max_percent_goods_sale"]){?>0<?php }else{?><?php echo get_currency_price($TPL_VAR["coupons"]["max_percent_goods_sale"], 1)?><?php }?>" class="<?php echo $TPL_VAR["only_numberic_type"]?> right"/> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 할인
					</span>
						<ul class="msg bullet_hyphen"><li>상품의 판매 금액 수량 1개당 적용</li></ul>

					</div>
					<div class="shipping">
						<select name="shippingType">
							<option value="free" <?php echo $TPL_VAR["selected_"]['shipping_type']['free']?> /> 기본 배송비 무료</option>
							<option value="won" <?php echo $TPL_VAR["selected_"]['shipping_type']['won']?>> 기본 배송비 할인</option>
						</select>

						<span class="max_shipping_sale_price ml10 <?php if($TPL_VAR["selected_"]['shipping_type']['won']){?>hide<?php }?>">최대</span>
						<input type="text" name="wonShippingSale" size="10" class="<?php echo $TPL_VAR["only_numberic_type"]?> right" value="<?php echo get_currency_price($TPL_VAR["coupons"]["wonShippingSale"], 1)?>" /> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 할인 <span class="max_shipping_sale_price desc <?php if($TPL_VAR["selected_"]['shipping_type']['won']){?>hide<?php }?>"></span>
					</div>

					<div class="mileage">
						쿠폰 인증 시 캐시 <input type="text" name="offline_emoney" size="10" class="<?php echo $TPL_VAR["only_numberic_type"]?> right" value="<?php if(!$TPL_VAR["coupons"]["offline_emoney"]){?>0<?php }else{?><?php echo get_currency_price($TPL_VAR["coupons"]["offline_emoney"], 1)?><?php }?>" /> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 지급
					</div>
				</td>
			</tr>
			<tr class="t_limit_goods_price">
				<th>최소 주문 금액 <span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/coupon', '#tip_limit_goods_price', 'sizeS')"></span></th>
				<td><input type="text" name="limitGoodsPrice" size="12" maxlength="10" value="<?php if(!$TPL_VAR["coupons"]["limit_goods_price"]){?>0<?php }else{?><?php echo get_currency_price($TPL_VAR["coupons"]["limit_goods_price"], 1)?><?php }?>" class="<?php echo $TPL_VAR["only_numberic_type"]?> right" /> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상 구매 시 사용 가능</td>
			</tr>
			<tr class="t_mileage_period_limit hide">
				<th>캐시 유효기간</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="period_limit" value="unlimit" <?php echo $TPL_VAR["checked_"]['period_limit']['unlimit']?> /> 제한없음</label>
						<label><input type="radio" name="period_limit" value="limit" <?php echo $TPL_VAR["checked_"]['period_limit']['limit']?> /> 제한</label>
					</div>
				</td>
			</tr>
			<tr class="t_period_limit">
				<th>유효 기간</th>
				<td>
					<div class="normal resp_radio">
					<span>
						<label class="months hide">
							<input type="radio" name="issuePriodType" value="months" <?php echo $TPL_VAR["checked_"]['issue_priod_type']['months']?> /> 발급 당월 말일까지
						</label>
						<label class="date"><input type="radio" name="issuePriodType" value="date"  <?php echo $TPL_VAR["checked_"]['issue_priod_type']['date']?> />
							<input type="text" name="issueDate[]" value="<?php echo $TPL_VAR["coupons"]["issue_startdate"]?>" class="datepicker line"  maxlength="10" size="10" />
							~
							<input type="text" name="issueDate[]" value="<?php echo $TPL_VAR["coupons"]["issue_enddate"]?>" class="datepicker line"  maxlength="10" size="10" />
						</label>
						<label class="day hide ml20">
							<input type="radio" name="issuePriodType" value="day" <?php echo $TPL_VAR["checked_"]['issue_priod_type']['day']?> />
							발급일로부터 <input type="text" name="afterIssueDay" size="5" value="<?php echo $TPL_VAR["coupons"]["after_issue_day"]?>" class="onlynumber line" /> 일
						</label>
					</span>
					</div>
					<div class="mileage resp_radio">
						<label><input type="radio" name="issuePriodType" value="year" <?php echo $TPL_VAR["checked_"]['issue_priod_type']['year']?> /> 지급 년도 +
							<input type="text" name="offline_reserve_year" maxlength="4" class="onlynumber right" value="<?php echo $TPL_VAR["coupons"]["offline_reserve_year"]?>" size=4 /> 년 말일까지
						</label>
						<label class="ml20"><input type="radio" name="issuePriodType" value="direct" <?php echo $TPL_VAR["checked_"]['issue_priod_type']['direct']?> />
							<input type="text" name="offline_reserve_direct" maxlength="3" class="onlynumber right" size="3" value="<?php echo $TPL_VAR["coupons"]["offline_reserve_direct"]?>" /> 개월 까지
						</label>
					</div>
				</td>
			</tr>
			<tr class="t_duplication_set">
				<th><span class="title">중복 할인</span>
					<span class="tooltip_btn duplicate_discount" onClick="showTooltip(this, '/admin/tooltip/coupon', '#tip_duplicate_discount', 'sizeS')"></span>
					<span class="tooltip_btn duplicate_down" onClick="showTooltip(this, '/admin/tooltip/coupon', '#tip_duplicate_down', 'sizeS')"></span>
					<span class="tooltip_btn duplicate_all" onClick="showTooltip(this, '/admin/tooltip/coupon', '#tip_duplicate_all', 'sizeS')"></span>
				</th>
				<td>
					<div class="resp_radio">
						<label class="admin"><input type="radio" name="duplicationUse"  value="0" <?php echo $TPL_VAR["checked_"]['duplication_use']['0']?> /> 불가</label>
						<label class="provider"><input type="radio" name="duplicationUse"  value="1" <?php echo $TPL_VAR["checked_"]['duplication_use']['1']?> /> 가능</label>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<!---- 4. 혜택 설정 종료 ---->

	<!---- 5. 쿠폰 발급 시작 ---->
	<div class="item-title ui_coupon_inssuance">쿠폰 발급</div>
	<table class="table_basic thl ui_coupon_inssuance">
		<tr class="t_download_limit">
			<th>수량</th>
			<td>
				<div class="resp_radio">
					<label class="auto"><input type="radio" name="downloadLimit" value="auto" <?php echo $TPL_VAR["checked_"]['download_limit']['auto']?> />자동</label>
					<label class="unlimit <?php if(!$TPL_VAR["checked_"]['download_limit']['auto']){?>ml0<?php }?>"><input type="radio" name="downloadLimit" value="unlimit" <?php echo $TPL_VAR["checked_"]['download_limit']['unlimit']?> /> 제한없음</label>
					<label class="limit ml10">
						<input type="radio" name="downloadLimit" value="limit" <?php echo $TPL_VAR["checked_"]['download_limit']['limit']?> /> 수량 제한
						<input type="text" class="onlynumber right" name="downloadLimitEa" id="downloadLimitEa" value="<?php echo $TPL_VAR["coupons"]["download_limit_ea"]?>" size="5" maxlength="5" /> 개
					</label>
				</div>
			</td>
		</tr>
		<tr class="t_coupon_download_period_use">
			<th>발급 기간</th>
			<td>
				<div class="auto">자동</div>
				<div class="period resp_radio">
					<label class="unlimit"><input type="radio" name="download_period_use" value="unlimit" <?php echo $TPL_VAR["checked_"]['download_period_use']['unlimit']?> /> 제한없음</label>
					<label class="limit"><input type="radio" name="download_period_use" value="limit" <?php echo $TPL_VAR["checked_"]['download_period_use']['limit']?> /> 제한</label>
				</div>
			</td>
		</tr>
		<tr class="t_coupon_issued hide">
			<th>기간설정</th>
			<td><!--
				downloadPeriodSet		:: 발급기한(다운로드기한) 설정
									'auto' 자동신규 구매
									'period' 기간/시간/요일 설정
									'beforeafter' 00일전 ~ 00일 후
									'daysfrom' 00일로부터
									'neworder' 신규가입 미구매
									'notpurchased' 00동안 미구매
									'onceamonthdownload' 월1회 다운로드
									'' 사용안함
				-->
				<div class="auto">자동</div>

				<!-- 기간/시간/요일 설정 -->
				<div class="period">
					<input type="text" name="downloadDate_s[]" value="<?php echo $TPL_VAR["coupons"]["download_startdate"]?>" class="datepicker line"  maxlength="10" size="10" />
					<select name="downloadDate_s[]">
<?php if(is_array($TPL_R1=range( 0, 23))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["coupons"]["download_starthour"]==$TPL_V1){?>selected<?php }?>><?php echo str_pad($TPL_V1, 2,'0',$TPL_VAR["STR_PAD_LEFT"])?></option>
<?php }}?>
					</select>
					<span class="gray">:</span>

					<select name="downloadDate_s[]">
<?php if(is_array($TPL_R1=range( 0, 59))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["coupons"]["download_startmin"]==$TPL_V1){?>selected<?php }?>><?php echo str_pad($TPL_V1, 2,'0',$TPL_VAR["STR_PAD_LEFT"])?></option>
<?php }}?>
					</select>

					<span class="gray" style="margin:0 1px;">~</span>
					<input type="text" name="downloadDate_e[]" value="<?php echo $TPL_VAR["coupons"]["download_enddate"]?>" class="datepicker line"  maxlength="10" size="10" />

					<select name="downloadDate_e[]">
<?php if(is_array($TPL_R1=range( 0, 23))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<option value="<?php echo $TPL_V1?>" <?php echo $TPL_VAR["selected_"]['download_endhour'][$TPL_V1]?>><?php echo str_pad($TPL_V1, 2,'0',$TPL_VAR["STR_PAD_LEFT"])?></option>
<?php }}?>
					</select>
					<span class="gray">:</span>

					<select name="downloadDate_e[]">
<?php if(is_array($TPL_R1=range( 0, 59))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<option value="<?php echo $TPL_V1?>" <?php echo $TPL_VAR["selected_"]['download_endmin'][$TPL_V1]?>><?php echo str_pad($TPL_V1, 2,'0',$TPL_VAR["STR_PAD_LEFT"])?></option>
<?php }}?>
					</select>
					<div>
						<label class="resp_checkbox"><input type="checkbox" name="time_limit" value="1" <?php if($TPL_VAR["coupons"]["download_starttime"]||$TPL_VAR["coupons"]["download_endtime"]){?>checked<?php }?> /> 시간 제한</label>
						<label class="resp_checkbox ml20"><input type="checkbox" name="dayoftheweek_limit" value="1" <?php if($TPL_VAR["coupons"]["download_week"]){?>checked<?php }?> /> 요일 제한</label>
					</div>
				</div>

				<!-- 생일 : 00일전 ~ 00일 후 -->
				<div class="beforeafter">
					<span>생일</span> <input type="text" name="beforeDay" size="3" value="<?php echo $TPL_VAR["coupons"]["beforeDay"]?>"  class="onlynumber" /> 일전
					~ <input type="text" name="afterDay" size="3" value="<?php echo $TPL_VAR["coupons"]["afterDay"]?>"  class="onlynumber" /> 일 이후
				</div>

				<!--등급조정 :  00일로부터 -->
				<div class="daysfrom">
					등급 조정일로부터 <input type="text" name="afterUpgrade" size="3" value="<?php echo $TPL_VAR["coupons"]["after_upgrade"]?>"  class="onlynumber" /> 일 까지
				</div>

				<!-- 신규가입 미구매 -->
				<div class="neworder">
					신규 가입 <input type="text" class="onlynumber" name="order_terms" id="order_terms" value="<?php echo $TPL_VAR["coupons"]["order_terms"]?>"  size="4" /> 일 이후 미 구매 시(월 1회)
				</div>

				<!-- 00동안 미구매 -->
				<div class="notpurchased">
					최근
					<select name="memberlogin_terms">
<?php if(is_array($TPL_R1=range( 0, 11))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<option value="<?php echo $TPL_V1+ 1?>" <?php if($TPL_VAR["coupons"]["memberlogin_terms"]==($TPL_V1+ 1)){?>selected<?php }?>><?php echo str_pad($TPL_V1+ 1, 2,'0',$TPL_VAR["STR_PAD_LEFT"])?>개월</option>
<?php }}?>
					</select>
					동안 미 구매 시 (월 1회, 구매 내역이 1회 이상인 경우 해당)
				</div>

				<!-- 월1회 다운로드-->
				<div class="onceamonthdownload">해당 등급의 회원에게 월 1회 발급</div>
			</td>
		</tr>
		<tr class="t_time_limit <?php if(!$TPL_VAR["coupons"]["download_starttime"]&&!$TPL_VAR["coupons"]["download_endtime"]){?>hide<?php }?>">
			<th>시간 제한</th>
			<td>
				<select name="downloadTime_s[]">
<?php if(is_array($TPL_R1=range( 0, 23))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["coupons"]["download_starttime_h"]==$TPL_V1){?>selected<?php }?>><?php echo str_pad($TPL_V1, 2,'0',$TPL_VAR["STR_PAD_LEFT"])?></option>
<?php }}?>
				</select>
				<select name="downloadTime_s[]">
<?php if(is_array($TPL_R1=range( 0, 59))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["coupons"]["download_starttime_m"]==$TPL_V1){?>selected<?php }?>><?php echo str_pad($TPL_V1, 2,'0',$TPL_VAR["STR_PAD_LEFT"])?></option>
<?php }}?>
				</select>

				<span class="gray" style="margin:0 1px;">~</span>

				<select name="downloadTime_e[]">
<?php if(is_array($TPL_R1=range( 0, 23))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php echo $TPL_VAR["selected_"]['download_endtime_h'][$TPL_V1]?>><?php echo str_pad($TPL_V1, 2,'0',$TPL_VAR["STR_PAD_LEFT"])?></option>
<?php }}?>
				</select>
				<select name="downloadTime_e[]">
<?php if(is_array($TPL_R1=range( 0, 59))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php echo $TPL_VAR["selected_"]['download_endtime_m'][$TPL_V1]?>><?php echo str_pad($TPL_V1, 2,'0',$TPL_VAR["STR_PAD_LEFT"])?></option>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr class="t_dayoftheweek_limit <?php if(!$TPL_VAR["coupons"]["download_week"]){?>hide<?php }?>">
			<th>요일 제한</th>
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="downloadWeek_[]" value="1" <?php echo $TPL_VAR["checked_"]['download_week']['1']?> /> 월요일</label>
					<label><input type="checkbox" name="downloadWeek_[]" value="2" <?php echo $TPL_VAR["checked_"]['download_week']['2']?> />화요일</label>
					<label><input type="checkbox" name="downloadWeek_[]" value="3" <?php echo $TPL_VAR["checked_"]['download_week']['3']?> /> 수요일</label>
					<label><input type="checkbox" name="downloadWeek_[]" value="4" <?php echo $TPL_VAR["checked_"]['download_week']['4']?> /> 목요일</label>
					<label><input type="checkbox" name="downloadWeek_[]" value="5" <?php echo $TPL_VAR["checked_"]['download_week']['5']?> /> 금요일</label>
					<label><input type="checkbox" name="downloadWeek_[]" value="6" <?php echo $TPL_VAR["checked_"]['download_week']['6']?> /> 토요일</label>
					<label><input type="checkbox" name="downloadWeek_[]" value="7" <?php echo $TPL_VAR["checked_"]['download_week']['7']?> /> 일요일</label>
				</div>
			</td>
		</tr>
		<tr class="t_member_grade">
			<th>회원 등급 지정</th>
			<td>
				<div class="auto">자동</div>

				<div class="gradelimit">

					<input type="button" value="등급 선택" class="btn_member_grade_select resp_btn active"/>
					<div class="mt10 wx400 member_grade_list">
						<table class="table_basic fix">
							<colgroup>
								<col width="70%" />
								<col width="30%" />
							</colgroup>
							<thead>
							<tr>
								<th>등급</th>
								<th>삭제</th>
							</tr>
							</thead>
							<tbody>
							<tr rownum=0 <?php if(count($TPL_VAR["couponGroups"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
							<td class="center" colspan="2">회원 등급을 선택하세요</td>
							</tr>
<?php if($TPL_couponGroups_1){foreach($TPL_VAR["couponGroups"] as $TPL_V1){?>
							<tr rownum="<?php echo $TPL_V1["group_seq"]?>">
								<td class="center"><?php echo $TPL_V1["group_name"]?></td>
								<td class="center">
									<input type="hidden" name='member_grade_list[]' value='<?php echo $TPL_V1["group_seq"]?>'>
									<input type="hidden" name="member_grade_coupon_group[<?php echo $TPL_V1["group_seq"]?>]" value="<?php echo $TPL_V1["coupon_group_seq"]?>" />
									<button type="button" class="btn_minus" selectType="member_grade" seq="<?php echo $TPL_V1["group_seq"]?>" onClick="gMemberGradeSelect.select_delete('minus',$(this))"></button></td>
							</tr>
<?php }}?>
							</tbody>
						</table>
					</div>
					<ul class="bullet_hyphen mt5">
						<li>회원 등급을 선택하지 않는 경우 전체 회원에게 발급됩니다.</li>
					</ul>
				</div>
			</td>
		</tr>
	</table>
<?php if(!in_array($TPL_VAR["coupons"]["type"],array('offline_emoney','offline_coupon'))){?>
	<div class="resp_message">- 쿠폰별 발급 주기 안내 <a href="https://www.firstmall.kr/customer/faq/1320 " class="resp_btn_txt" target="_blank">자세히 보기</a></div>
<?php }?>
	<!---- 5. 쿠폰 발급 종료 ---->


	<!---- 6. 쿠폰 인증 시작(offline)  ---->
	<div class="item-title ui_coupon_certification">쿠폰 인증</div>
	<table class="table_basic thl ui_coupon_certification">
		<tr>
			<th>인증 횟수</th>
			<td>
				동일한 쿠폰 최대 <input type="text" class="resp_text onlynumber right" name="downloadLimitEa_offline" value="<?php if(!$TPL_VAR["coupons"]["download_limit_ea"]){?>1<?php }else{?><?php echo $TPL_VAR["coupons"]["download_limit_ea"]?><?php }?>" size="5"  /> 회 인증 가능
			</td>
		</tr>
		<tr>
			<th>인증 기간</th>
			<td>
				<input type="text" name="certificationDate_s" value="<?php echo $TPL_VAR["coupons"]["download_startdate"]?>" class="resp_text datepicker"  maxlength="10" size="10" />
				~
				<input type="text" name="certificationDate_e" value="<?php echo $TPL_VAR["coupons"]["download_enddate"]?>" class="resp_text datepicker"  maxlength="10" size="10" />
			</td>
		</tr>
	</table>
	<!---- 6. 쿠폰 인증 종료(offline) ---->

	<!---- 7. 인증번호발급 시작 ---->
	<div class="item-title ui_certification_number">인증번호 발급</div>
	<table class="table_basic thl ui_certification_number">
		<tr>
			<th>발급 설정</th>
			<td>
				<div class="resp_radio">
<?php if($TPL_VAR["coupons"]["coupon_seq"]){?>
<?php if($TPL_VAR["checked_"]['certificate_issued_type']['auto']){?>자동<?php }else{?>수동<?php }?>
<?php }else{?>
					<label><input type="radio" name="certificate_issued_type" value="auto" <?php echo $TPL_VAR["checked_"]['certificate_issued_type']['auto']?> /> 자동</label>
					<label><input type="radio" name="certificate_issued_type" value="manual" <?php echo $TPL_VAR["checked_"]['certificate_issued_type']['manual']?> /> 수동</label>
<?php }?>
				</div>
			</td>
		</tr>
<?php if($TPL_VAR["coupons"]["coupon_seq"]){?>
		<tr>
			<th>인증번호 발급</th>
			<td>
<?php if($TPL_VAR["checked_"]['offline_type']['one']){?> <!-- 자동 : 1개의 인증번호 생성 -->
				<?php echo $TPL_VAR["coupons"]["offline_input_serialnumber"]?>

				<input type="button" id="offline_coupon_copy" offline_input_serialnumber="<?php echo $TPL_VAR["coupons"]["offline_input_serialnumber"]?>" value="복사" class="resp_btn v2" />
<?php }elseif($TPL_VAR["checked_"]['offline_type']['random']||$TPL_VAR["checked_"]['offline_type']['file']){?> <!-- 자동 : 랜덤 인증 번호 생성 -->
				<div class="offline_type3"  style="padding:5px 0 0 0;">  총 <?php echo number_format($TPL_VAR["coupons"]["offlinecoupontotal"])?>건
					<button type="button" class="offline_coupon_view resp_btn v2">인증번호 보기</button>
					<button type="button" class="offline_coupon_excel_down resp_btn">인증번호 엑셀 다운로드</button>
				</div>
<?php }elseif($TPL_VAR["checked_"]['offline_type']['input']){?> <!-- 수동 : 1개의 인증번호 생성 -->
				동일 인증번호 [<?php echo $TPL_VAR["coupons"]["offline_input_serialnumber"]?>]
				<input type="button" id="offline_coupon_copy" offline_input_serialnumber="<?php echo $TPL_VAR["coupons"]["offline_input_serialnumber"]?>" value="복사" class="resp_btn v2" />
<?php }else{?> <!-- 수동 : 수동 엑셀 등록 -->
<?php }?>
			</td>
		</tr>
<?php if(!$TPL_VAR["checked_"]['offline_type']['random']&&!$TPL_VAR["checked_"]['offline_type']['file']){?>
		<tr>
			<th>인증번호 제한</th>
			<td>
<?php if($TPL_VAR["coupons"]["offline_limit"]=='unlimit'){?>
				제한없이 쿠폰인증 허용
<?php }else{?>
				선착순 <?php echo number_format($TPL_VAR["coupons"]["offline_limit_ea"])?>번까지 쿠폰 인증 허용
<?php }?>
			</td>
		</tr>
<?php }?>
<?php }else{?>
		<tr class="t_offline_type <?php if($TPL_VAR["coupons"]["coupon_seq"]){?>hide<?php }?>">
			<th>발급 방식</th>
			<td>
				<div class="auto resp_radio">
					<label><input type="radio" name="offline_type"  value="one" <?php echo $TPL_VAR["checked_"]['offline_type']['one']?> />  1개의 인증번호 생성</label>
					<label><input type="radio" name="offline_type" value="random" <?php echo $TPL_VAR["checked_"]['offline_type']['random']?> />  랜덤 인증 번호 생성</label>
				</div>
				<div class="manual hide resp_radio">
					<label><input type="radio" name="offline_type"  value="input" <?php echo $TPL_VAR["checked_"]['offline_type']['input']?> />  1개의 인증번호 지정</label>
					<label><input type="radio" name="offline_type" value="file" <?php echo $TPL_VAR["checked_"]['offline_type']['file']?> />  수동 엑셀 등록</label>
				</div>
			</td>
		</tr>
		<tr class="t_offline_input_num hide">
			<th>인증번호 입력</th>
			<td><input type="text" name="offline_input_num" class="offline_input_num" value="<?php echo $TPL_VAR["coupons"]["offline_input_serialnumber"]?>" size="20" title="인증번호입력"></td>
		</tr>
		<tr class="t_offlineLimit_input hide">
			<th>인증 횟수</th>
			<td>
				<select name="offlineLimit_input">
					<option value="unlimit" <?php echo $TPL_VAR["selected_"]['offlineLimit_input']['unlimit']?>>제한 없음</option>
					<option value="limit" <?php echo $TPL_VAR["selected_"]['offlineLimit_input']['limit']?>>선착순</option>
				</select>

				<span class="offlineLimitEa_input <?php if($TPL_VAR["selected_"]['offlineLimit_input']['unlimit']){?>hide<?php }?>"><input type="text" class="onlynumber right" name="offlineLimitEa_input" value="<?php echo $TPL_VAR["coupons"]["offline_limit_ea"]?>"  size="11" /> 번째 까지 가능</span>

			</td>
		</tr>
		<tr class="t_offline_random_num">
			<th>인증번호 발급 수</th>
			<td>
				<input type="text" name="offline_random_num" value="<?php echo $TPL_VAR["coupons"]["offline_random_num"]?>" class="resp_text onlynumber right"  maxlength="5" size="6" />
				개 (최대 1만개) <span class="desc red msg"></span>
			</td>
		</tr>
		<tr class="t_offlineLimit_one hide">
			<th>인증 제한</th>
			<td>
				<select name="offlineLimit_one">
					<option value="unlimit" <?php echo $TPL_VAR["selected_"]['offlineLimit_one']['unlimit']?> >제한 없음</option>
					<option value="limit" <?php echo $TPL_VAR["selected_"]['offlineLimit_one']['limit']?>>선착순</option>
				</select>
				<span class="offlineLimitEa_one hide"><input type="text" class="onlynumber" name="offlineLimitEa_one" value="<?php echo $TPL_VAR["coupons"]["offlineLimitEa_one"]?>"  size="11" /> 번째 까지 가능</span>
			</td>
		</tr>
		<tr class="t_excel_upload hide">
			<th>엑셀</th>
			<td>
				<input type="hidden" name="offline_file" class="offline_file">
				<button type="button" class="batchExcelRegist resp_btn v2">등록</button>
				<span class="offline_file_name"></span>
			</td>
		</tr>
<?php }?>
	</table>
	<!---- 7. 인증번호발급 종료 ---->

	<!---- 8. 쿠폰 사용 제한 시작 ---->
	<div class="item-title ui_usage_restriction">쿠폰 사용 제한</div>
	<table class="table_basic thl ui_usage_restriction">
		<tr class="t_used_together">
			<th>타 쿠폰과 함께 사용</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="couponsametime" value="Y" <?php echo $TPL_VAR["checked_"]['coupon_same_time']['Y']?> /> 사용 가능</label>
					<label><input type="radio" name="couponsametime" value="N" <?php echo $TPL_VAR["checked_"]['coupon_same_time']['N']?> /> 사용 불가</label>
				</div>
			</td>
		</tr>
		<tr class="t_goods_category_limit">
			<th rowspan="2">상품/카테고리 제한</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="issue_type" value="all" <?php echo $TPL_VAR["checked_"]['issue_type']['all']?> />  제한 없음</label>
					<label class="ml50"><input type="radio" name="issue_type" value="issue" <?php echo $TPL_VAR["checked_"]['issue_type']['issue']?> /> 선택한 상품/카테고리만</label>
					<label class="ml50"><input type="radio" name="issue_type" value="except" <?php echo $TPL_VAR["checked_"]['issue_type']['except']?> /> 선택한 상품/카테고리를 제외</label>
				</div>
			</td>
		</tr>
		<tr class="t_goods_category_limit" style="border-top:0;">
			<td class="clear">
				<table class="table_basic thl v3 t_select_goods" style="border-top:1px solid #ccc;">
					<tbody>
					<tr class="t_goods">
						<th>상품</th>
						<td>
							<input type="button" value="상품 선택" class="btn_select_goods resp_btn active"  />
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
									<table class="table_basic tdc fix">
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
										<td colspan="4">상품을 선택하세요</td>
										</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->
<?php if($TPL_issuegoods_1){foreach($TPL_VAR["issuegoods"] as $TPL_V1){?>
										<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
											<td ><label class="resp_checkbox"><input type="checkbox" name='issueGoodsTmp[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' /></label>
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
											<td><?php echo get_currency_price($TPL_V1["price"], 2)?></td>
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
								<table class="table_basic">
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
											<button type="button" class="btn_minus"  selectType="category" seq="<?php echo $TPL_V1["category_code"]?>" onClick="gCategorySelect.select_delete('minus',$(this))"></button></td>
									</tr>
<?php }}?>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr class="t_device_used">
			<th>사용 가능 환경</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="sale_agent" value="a" <?php echo $TPL_VAR["checked_"]['sale_agent']['a']?> /> 제한 없음</label>
					<label><input type="radio" name="sale_agent" value="m" <?php echo $TPL_VAR["checked_"]['sale_agent']['m']?> /> 모바일</label>
					<label><input type="radio" name="sale_agent" value="app" <?php echo $TPL_VAR["checked_"]['sale_agent']['app']?> /> 쇼핑몰앱</label>
				</div>
			</td>
		</tr>
		<tr class="t_method_of_payment">
			<th>결제 가능 수단</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="sale_payment" value="a" <?php echo $TPL_VAR["checked_"]['sale_payment']['a']?> /> 제한 없음</label>
					<label><input type="radio" name="sale_payment" value="b" <?php echo $TPL_VAR["checked_"]['sale_payment']['b']?> /> 무통장</label>
				</div>
			</td>
		</tr>
		<tr class="t_referer_limit">
			<th>할인 유입 경로</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="sale_referer" value="a" <?php echo $TPL_VAR["checked_"]['sale_referer']['a']?> /> 제한 없음</label>
					<label><input type="radio" name="sale_referer" value="n" <?php echo $TPL_VAR["checked_"]['sale_referer']['n']?> /> 유입경로 할인 없을 때 가능</label>
					<label><input type="radio" name="sale_referer" value="y" <?php echo $TPL_VAR["checked_"]['sale_referer']['y']?> /> 유입경로 할인 있을 때 가능</label>
				</div>
			</td>
		</tr>
		<tr class="t_referer_limit">
			<th>유입 경로 할인 제한</th>
			<td class="clear">
				<table class="table_basic thl v3">
					<tbody>
					<tr>
						<th>유입경로 할인 중복</th>
						<td>
							<div class="resp_radio">
								<label><input type="radio" name="sale_referer_type" value="a" <?php echo $TPL_VAR["checked_"]['sale_referer_type']['a']?> /> 모든 유입 경로 할인</label>
								<label><input type="radio" name="sale_referer_type" value="s" <?php echo $TPL_VAR["checked_"]['sale_referer_type']['s']?> /> 선택한 유입 경로 할인</label>
							</div>
						</td>
					</tr>
					<tr class="t_select_referer">
						<th>상세 선택</th>
						<td>
							<input type="button" value="유입 경로 할인선택" class="btn_referersale_select resp_btn active" />
							<div class="mt10 wx600 referersale_list">
								<table class="table_basic fix">
									<colgroup>
										<col width="85%" />
										<col width="15%" />
									</colgroup>
									<thead>
									<tr class="nodrag nodrop">
										<th>유입경로명</th>
										<th>삭제</th>
									</tr>
									</thead>
									<tbody>
									<tr rownum=0 <?php if(count($TPL_VAR["salserefereritemloop"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
									<td class="center" colspan="2">할인 유입 경로를 선택하세요</td>
									</tr>
<?php if($TPL_VAR["coupons"]["sale_referer"]=='y'&&$TPL_VAR["coupons"]["sale_referer_type"]=='s'){?>
<?php if($TPL_VAR["salserefereritemloop"]){?>
<?php if($TPL_salserefereritemloop_1){foreach($TPL_VAR["salserefereritemloop"] as $TPL_V1){?>
									<tr rownum="<?php echo $TPL_V1["referersale_seq"]?>">
										<td class="left"><?php echo $TPL_V1["referersale_name"]?></td>
										<td class="center">
											<input type="hidden" name='referersale_seq[]' value='<?php echo $TPL_V1["referersale_seq"]?>' />
											<button type="button" class="btn_minus" selectType="referersale" seq="<?php echo $TPL_V1["referersale_seq"]?>" onClick="gRefererSelect.select_delete('minus',$(this))"></button></td>
									</tr>
<?php }}?>
<?php }?>
<?php }?>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</table>
	<!---- 8. 쿠폰 사용 제한 종료 ---->


	<!---- 9. 쿠폰 이미지 시작 ---->
	<div class="item-title ui_coupon_image">쿠폰 이미지</div>
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
	<table class="table_basic thl ui_coupon_image">
		<tr class="t_coupon_image_set">
			<th>샘플 이미지</th>
			<td>
				<input type="radio" class="hide" name="couponImg" id="couponImg<?php if($TPL_VAR["coupons"]["coupon_seq"]){?><?php echo $TPL_VAR["coupons"]["coupon_img"]?><?php }else{?>1<?php }?>" value="<?php if($TPL_VAR["coupons"]["coupon_seq"]){?><?php echo $TPL_VAR["coupons"]["coupon_img"]?><?php }else{?>1<?php }?>" <?php echo $TPL_VAR["checked_"]['coupon_img'][ 1]?> />
				<input type="radio" class="hide" name="couponmobileImg" id="couponmobileImg<?php if($TPL_VAR["coupons"]["coupon_seq"]){?><?php echo $TPL_VAR["coupons"]["coupon_mobile_img"]?><?php }else{?>1<?php }?>" value="<?php if($TPL_VAR["coupons"]["coupon_seq"]){?><?php echo $TPL_VAR["coupons"]["coupon_mobile_img"]?><?php }else{?>1<?php }?>" checked="checked" />

				<div style="width:400px;" class="couponImg_light_1" src_sample="/data/coupon/light_coupon_sample_01.png" src_orign="/data/coupon/light_coupon_sample_01_origin.png" ><label for="couponImg_light_1"><img src="/data/coupon/light_coupon_sample_01.png" id="couponImg_light_1_src" /></label></div><div style="clear: both"></div>
				<span class="desc">※ 상기 샘플 이미지는 스킨에 따라 다르게 보일 수 있습니다.</span>
			</td>
		</tr>
	</table>
<?php }else{?>
	<table class="table_basic thl ui_coupon_image">
		<tr>
			<th>쿠폰 이미지</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="coupon_image_set" value="basic"  <?php echo $TPL_VAR["checked_"]['coupon_image_set']['basic']?> /> 기본 이미지</label>
					<label class="ml30"><input type="radio" name="coupon_image_set" value="upload" <?php echo $TPL_VAR["checked_"]['coupon_image_set']['upload']?> /> 이미지 업로드</label>
				</div>
			</td>
		</tr>
		<tr>
			<th>이미지 선택</th>
			<td class="clear">
				<!--- 쿠폰 이미지 선택 -->
				<div class="image_set basic">
					<table class="table_basic thl v3">
						<tbody>
						<tr>
							<th>PC용</th>
							<td>
								<div class="resp_radio">
<?php if(is_array($TPL_R1=range( 1, 3))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
									<label>
										<input type="radio" name="couponImg" value="<?php echo $TPL_K1+ 1?>" <?php echo $TPL_VAR["checked_"]['coupon_img'][$TPL_K1+ 1]?> />
										<span class="couponImg valign-middle" no="<?php echo $TPL_K1+ 1?>" src_sample="/data/coupon/coupon<?php if($TPL_VAR["coupons"]["coupon_same_time"]=='N'){?>sametime<?php }?>_sample_0<?php echo $TPL_K1+ 1?>.gif" src_orign="/data/coupon/coupon<?php if($TPL_VAR["coupons"]["coupon_same_time"]=='N'){?>sametime<?php }?>_skin_0<?php echo $TPL_K1+ 1?>.gif" >
										<img src="/data/coupon/coupon<?php if($TPL_VAR["coupons"]["coupon_same_time"]=='N'){?>sametime<?php }?>_sample_0<?php echo $TPL_K1+ 1?>.gif" class="coupon_img" no="<?php echo $TPL_K1+ 1?>"  width="180" />
									</span>
									</label>
<?php }}?>
								</div>
							</td>
						</tr>
						<tr>
							<th>Mobile</th>
							<td>
								<div class="resp_radio">
<?php if(is_array($TPL_R1=range( 1, 3))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
									<label>
										<input type="radio" name="couponmobileImg" value="<?php echo $TPL_K1+ 1?>"  <?php echo $TPL_VAR["checked_"]['coupon_mobile_img'][$TPL_K1+ 1]?> />
										<span class="couponMobileImg valign-middle" no="<?php echo $TPL_K1+ 1?>" src_sample="/data/coupon/coupon<?php if($TPL_VAR["coupons"]["coupon_same_time"]=='N'){?>sametime<?php }?>_sample_mobile_0<?php echo $TPL_K1+ 1?>.gif" src_orign="/data/coupon/coupon<?php if($TPL_VAR["coupons"]["coupon_same_time"]=='N'){?>sametime<?php }?>_skin_mobile_0<?php echo $TPL_K1+ 1?>.gif" >
									<img src="/data/coupon/coupon<?php if($TPL_VAR["coupons"]["coupon_same_time"]=='N'){?>sametime<?php }?>_sample_mobile_0<?php echo $TPL_K1+ 1?>.gif" class="coupon_mobile_img" no="<?php echo $TPL_K1+ 1?>"  width="180" />
									</span>
									</label>
<?php }}?>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<!--- 쿠폰 이미지 등록 -->
				<div class="image_set upload">
					<table class="table_basic thl v3">
						<tbody>
						<tr>
							<th>PC용</th>
							<td>
								<div>
									<button type="button" class="batchImageRegist resp_btn v2" imagetype="pc" >이미지등록</button>
									<input type="hidden" name="couponimage4" id="couponimage4" value="" >
								</div>
								<div style="width: 269px; text-align: center;" class="mt10">
									<div style="float:left;" class="mt30 hide"><input type="radio" name="couponImg" value="4" <?php echo $TPL_VAR["checked_"]['coupon_img'][ 4]?> /> </div>
									<div style="float:left;">
										<div style='width: 249px;min-height:113px;border: 1px dotted #2EA4C0;' id="couponimage4lay"><?php if($TPL_VAR["coupons"]["coupon_image4"]){?><img src="/data/coupon/<?php echo $TPL_VAR["coupons"]["coupon_image4"]?>"/><?php }?></div>
										<div style="float:left;"><span class="desc">(권장 사이즈 254 × 118)</span></div>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<th>Mobile</th>
							<td>
								<div>
									<button type="button" class="batchmobileImageRegist resp_btn v2" imagetype="mobile" >이미지등록</button>
									<input type="hidden" name="couponmobileimage4" id="couponmobileimage4" value="" >
								</div>
								<div style="width: 269px; text-align: center; " class="mt10">
									<div style="float:left;" class="mt30 hide"><input type="radio" name="couponmobileImg" value="4" <?php echo $TPL_VAR["checked_"]['coupon_mobile_img'][ 4]?> /> </div>
									<div style="float:left;">
										<div style='width: 249px;min-height:113px;border: 1px dotted #2EA4C0;' id="couponmobileimage4lay"><?php if($TPL_VAR["coupons"]["coupon_mobile_image4"]){?><img src="/data/coupon/<?php echo $TPL_VAR["coupons"]["coupon_mobile_image4"]?>"/><?php }?></div>
										<div style="float:left;"><span class="desc">(권장 사이즈 254 × 118)</span></div>
									</div>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</td>

		</tr>
		</tbody>
	</table>
<?php }?>

	<!---- 9. 쿠폰 이미지 종료 ---->

	<!---- 10. 쿠폰 다운로드 URL 시작 ---->
<?php if($TPL_VAR["coupons"]["coupon_seq"]){?>
	<div class="item-title ui_coupon_download_url">쿠폰 다운로드</div>
	<table class="table_basic thl ui_coupon_download_url">
		<tr>
			<th>URL</th>
			<td>
				<span class="btn small"><button type="button" id="couponurlbtn" class="resp_btn v2" code="<?php echo getCouponDownloadUrl('one',$TPL_VAR["coupons"]["type"],$TPL_VAR["coupons"]["coupon_seq"])?>" >URL 복사</button></span>
			</td>
		</tr>
	</table>
	</div>
<?php }?>
	<!---- 10. 쿠폰 다운로드 URL 종료 ---->
	</div>

	</div>
</form>

<p><br /></p><p><br /></p>

<!--<div id="salecost_info"></div>-->
<div id="lay_seller_select"></div><!-- 입점사 선택 레이어 -->
<div id="lay_member_grade_select"></div><!-- 회원 등급 선택 레이어 -->
<div id="lay_goods_select"></div><!-- 상품선택 레이어 -->
<div id="lay_category_select"></div><!-- 카테고리 선택 레이어 -->
<div id="lay_referer_select"></div><!-- 유입경로할인 선택 레이어 -->
<div id="lay_coupon_issued"></div><!-- Popup :: 쿠폰 발급하기 -->


<!-- 인증번호 : 엑셀 업로드 다이얼로그 -->
<div id="ExcelUploadDialog" class="hide">

	<div class="item-title">엑셀 등록</div>

	<table class="table_basic thl">
		<tr>
			<th>양식 다운로드</th>
			<td>
				<button type="button" class="offline_coupon_form resp_btn" onclick="document.location.href='<?php echo $TPL_VAR["offline_coupon_form"]?>'">양식 다운로드</button>
			</td>
		</tr>
		<tr>
			<th>엑셀 업로드</th>
			<td>
			<span class="resp_btn v2">
				<label><input id="ExcelUploadButton" type="file" name="file" value="" class="uploadify" />파일선택</label>
			</span>
			</td>
		</tr>
	</table>

	<div class="resp_message">
		- 프로모션 코드 엑셀 파일 등록 방법 <a href="https://www.firstmall.kr/customer/faq/1252" class="resp_btn_txt" target="_blank">자세히 보기</a>
	</div>

	<div class="footer">
		<button type="button" class="btnLayClose resp_btn active size_XL" onClick="closeDialog('ExcelUploadDialog')">확인</button>
		<button type="button" class="btnLayClose resp_btn size_XL" onClick="closeDialog('ExcelUploadDialog')">취소</button>
	</div>
</div>


<!-- 이미지[PC] 업로드 다이얼로그 -->
<div id="imageUploadDialog" class="hide">
	<table class="table_basic thl">
		<col width="160" />
		<tr>
			<th>파일형식, 사이즈</th>
			<td>.JPG, .GIF, .PNG / 254 * 118</td>
		</tr>
		<tr>
			<th>업로드경로</th>
			<td>/<span class="uploadPath"></span></td>
		</tr>
		<tr>
			<th>파일찾기</th>
			<td>
				<div class="pdr10">
					<img class="imageUploadBtnImage hide" src="/admin/skin/default/images/common/btn_filesearch.gif">
					<input id="imageUploadButton" type="file" name="file" value="" class="uploadify" />
					<input id="imagetype" type="hidden" name="imagetype" value="" />

				</div>
			</td>
		</tr>
	</table>
</div>

<!-- 이미지[MOBILE] 업로드 다이얼로그 -->
<div id="mobileimageUploadDialog" class=" hide">
	<table class="table_basic thl">
		<col width="160" />
		<tr>
			<th>파일형식, 사이즈</th>
			<td>.JPG, .GIF, .PNG / 254 * 118</td>
		</tr>
		<tr>
			<th>업로드경로</th>
			<td>/<span class="uploadPath"></span></td>
		</tr>
		<tr>
			<th>파일찾기</th>
			<td>
				<div class="pdr10">
					<img class="mobileimageUploadBtnImage hide" src="/admin/skin/default/images/common/btn_filesearch.gif">
					<input id="mobileimageUploadButton" type="file" name="file" value="" class="uploadify" />
					<input id="mobileimagetype" type="hidden" name="mobileimagetype" value="" />

				</div>
			</td>
		</tr>
	</table>
</div>

<!-- 이미지 업로드 결과 인디케이터 -->
<div class="uploadifyQueue hide" id="imageUploadButtonQueue">
	<div class="uploadifyQueueItem">
		<div class="cancel">
			<a href="javascript:imageFileDelete();">
				<img src="/app/javascript/plugin/jquploadify/uploadify-cancel.png" border="0">
			</a>
		</div>
		<span class="fileName"></span><span class="percentage"></span>
	</div>
</div>

<!-- 이미지 업로드 결과 인디케이터 -->
<div class="uploadifyQueue hide" id="mobileimageUploadButtonQueue">
	<div class="uploadifyQueueItem">
		<div class="cancel">
			<a href="javascript:imageFileDelete();">
				<img src="/app/javascript/plugin/jquploadify/uploadify-cancel.png" border="0">
			</a>
		</div>
		<span class="fileName"></span><span class="percentage"></span>
	</div>
</div>

<?php $this->print_("coupongoodslayer",$TPL_SCP,1);?>


<script type="text/javascript">

</script>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>