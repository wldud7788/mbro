<?php /* Template_ 2.2.6 2021/08/25 16:20:52 /www/music_brother_firstmall_kr/selleradmin/skin/default/coupon/regist.html 000034308 */ 
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

<script type="text/javascript">
	// 저장된 값
	var g_coupon_category	= "<?php echo $TPL_VAR["coupons"]["coupon_category"]?>";			// 쿠폰
	var g_coupon_type		= "<?php echo $TPL_VAR["coupons"]["coupon_type"]?>";				// 종류
	var g_issued_method		= "<?php echo $TPL_VAR["coupons"]["issued_method"]?>";			// 발급방법
	var g_coupon_seq		= "<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>";
	var g_coupon_name		= "<?php echo addslashes($TPL_VAR["coupons"]["coupon_name"])?>";

</script>

<!-- @2020-03-01 UX/Ui개선에 따른 공통 css, script -->
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common-ui.css?mm=20200601" />
<script type="text/javascript" src="/app/javascript/js/admin/couponComm.js?mm=20200601"></script>
<!-- @2020-03-01 UX/Ui개선에 따른 공통 css, script -->

<?php if($TPL_VAR["checkO2OService"]){?>
<script type="text/javascript" src="/app/javascript/js/o2o/admin-o2oCoupon.js"></script>
<?php }?>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area"  class="gray-bar">
	<div id="page-title-bar">
		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><button type="button" onclick="document.location.href='../coupon/catalog?<?php echo $TPL_VAR["query_string"]?>';" class="resp_btn v3 size_L">쿠폰 리스트</button></li>
		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>쿠폰 보기</h2>
		</div>
	</div>
</div>
<div id="coupon_wrap" class="contents_container">

	<div class="warp">

	<!---- 0. 쿠폰 발급 현황 시작 ---->
		<div class="item-title">쿠폰 발급 현황</div>
		<table class="table_basic thl">
		<colgroup>
			<col width="160px" />
			<col width="30%" />
			<col width="160px" />
			<col />
		</colgroup>

		<tr>
			<th>발급 상태</th>
			<td colspan="3"><?php if($TPL_VAR["coupons"]["issue_stop"]== 1){?>발급 중지<?php }else{?>발급 중<?php }?></td>
		</tr>
		<tr>
			<th>발급현황</th>
			<td colspan="3">발급 [<?php echo $TPL_VAR["coupons"]["downloadtotalbtn"]?>건] / 사용 [<?php echo $TPL_VAR["coupons"]["usetotalbtn"]?>건]</td>
		</tr>
		<tr>
			<th>등록일</th>
			<td><?php echo $TPL_VAR["coupons"]["regist_date"]?></td>
			<th>수정일</th>
			<td><?php echo $TPL_VAR["coupons"]["update_date"]?></td>
		</tr>
		</table>
	<!---- 0. 쿠폰 발급 현황 종료 ---->

	<!---- 1. 기본 정보 시작 ---->
		<div class="item-title">기본 정보</div>
		<table class="table_basic thl">
		<tr>
			<th>쿠폰</th>
			<td>
<?php if($TPL_coupon_category_1){foreach($TPL_VAR["coupon_category"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_VAR["coupons"]&&$TPL_VAR["checked_"]["coupon_category"][$TPL_K1]){?><?php echo $TPL_V1?><?php }?>
<?php }}?>
			</td>
		</tr>
		<tr class="tr_coupon_type">
			<th>종류</th>
			<td>
				<?php echo $TPL_VAR["coupon_category_sub"][$TPL_VAR["set_coupon_form"]["discount_target"]][$TPL_VAR["coupons"]["coupon_type"]]['name']?>

			</td>
		</tr>
		<tr class="tr_issued_method">
			<th>발급 방법</th>
			<td class='issued_method'>
				<?php echo $TPL_VAR["coupon_category_sub"][$TPL_VAR["set_coupon_form"]["discount_target"]][$TPL_VAR["coupons"]["coupon_type"]]['list'][$TPL_VAR["coupons"]["type"]]?>

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
<?php if($TPL_VAR["coupon_category"]=="order"&&$TPL_VAR["salestoreitemloop"]){?>
		<tr class="tr_ordersheet">
			<th>오프라인 매장 <span class="required_chk"></span></th>
			<td>
				<div class="resp_radio">
<?php if($TPL_salestoreitemloop_1){foreach($TPL_VAR["salestoreitemloop"] as $TPL_V1){?>
                        <label>
                        <input type="checkbox" name="sale_store_item[]" class="sale_store_item" 
                            value="<?php echo $TPL_V1["o2o_store_seq"]?>"
<?php if($TPL_VAR["coupons"]["sale_store"]=='off'&&in_array($TPL_V1["o2o_store_seq"],$TPL_VAR["coupons"]["sale_store_item_arr"])){?>checked<?php }?>
                        /> <?php echo $TPL_V1["pos_name"]?>

                        </label>
<?php }}?>
				</div>
			</td>
		</tr>
<?php }?>
		<tr>
			<th>쿠폰명 <span class="required_chk"></span></th>
			<td><?php echo $TPL_VAR["coupons"]["coupon_name"]?></td>
		</tr>
		<tr>
			<th>쿠폰설명</th>
			<td><?php echo $TPL_VAR["coupons"]["coupon_desc"]?></td>
		</tr>
		</table>
		<div class="resp_message">- 쿠폰 발급 안내 <a href="https://www.firstmall.kr/customer/faq/1321 " class="resp_btn_txt" target="_blank">자세히 보기</a></div>
	<!---- 1. 기본 정보 종료 ---->


	<!---- 2. 혜택 부담 설정 시작 ---->
	<div class="item-title title_salescost_set"><span>혜택 부담 설정</span></div>
	<div class="div_salescost_set">
		<table class="table_basic thl">
		<tr class='t_discount_seller_type'>
			<th>적용 대상</th>
			<td>
<?php if($TPL_VAR["set_coupon_form"]["discount_seller_type"]=="AOP"){?>
<?php if($TPL_VAR["checked_"]['discount_seller_type']['admin']){?>본사<?php }else{?>입점사<?php }?>
<?php }elseif($TPL_VAR["set_coupon_form"]["discount_seller_type"]=="A"){?>
					본사
<?php }elseif($TPL_VAR["set_coupon_form"]["discount_seller_type"]=="NONE"){?>
<?php }else{?>
					본사/모든 입점사
<?php }?>
<?php if($TPL_VAR["set_coupon_form"]["discount_target"]=="goods"){?>상품<?php }else{?>배송비<?php }?>
			</td>
		</tr>
		<tr class="salescost_rate provider">
			<th>입점사 부담률 <span class="required_chk"></span></th>
			<td><?php if($TPL_VAR["coupons"]["coupon_seq"]> 0){?><?php echo $TPL_VAR["coupons"]["salescost_provider"]?><?php }else{?>0<?php }?>%</td>
		</tr>
		<tr class="salescost_rate admin">
			<th>본사 부담률</th>
			<td>
				<span class="percent"><?php if($TPL_VAR["coupons"]["coupon_seq"]> 0){?><?php echo $TPL_VAR["coupons"]["salescost_admin"]?><?php }else{?>100<?php }?>%</span>
			</td>
		</tr>
		</table>
		<ul class="bullet_hyphen mt5">
			<li>할인 항목별 할인 금액 <a href="https://www.firstmall.kr/customer/faq/1240" class="resp_btn_txt" target="_blank">자세히 보기</a></li>
		</ul>
	</div>
	<!---- 2. 혜택 부담 설정 종료 ---->


	<!---- 3. 혜택 설정 시작 ---->
		<div class="item-title">혜택 설정 <span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/coupon', '#tip_benefit_setting', 'sizeS')"></span></div>
		<div class="ui_benefit_setting">
		<table class="table_basic thl">
		<tr>
			<th>혜택 <span class="required_chk"></span></th>
			<td>
<?php if($TPL_VAR["set_coupon_form"]["benefit_type"]=="rate_amount"){?>
				<div class="goods">
<?php if(!$TPL_VAR["coupons"]["goods_sale_price"]){?>
						0
<?php }else{?>
<?php if($TPL_VAR["selected_"]['sale_type']['percent']){?>
							<?php echo get_currency_price($TPL_VAR["coupons"]["goods_sale_price"], 1)?>%

							, 최대 <?php if(!$TPL_VAR["coupons"]["max_percent_goods_sale"]){?>0<?php }else{?><?php echo get_currency_price($TPL_VAR["coupons"]["max_percent_goods_sale"], 2)?><?php }?> 할인
							<ul class="bullet_hyphen"><li>상품의 판매 금액 수량 1개당 적용</li></ul>
<?php }else{?>
							<?php echo get_currency_price($TPL_VAR["coupons"]["goods_sale_price"], 2)?>

<?php }?>
<?php }?>

				</div>
<?php }elseif($TPL_VAR["set_coupon_form"]["benefit_type"]=="shipping"){?>
				<div class="shipping">
<?php if($TPL_VAR["selected_"]['shipping_type']['free']){?>
						기본 배송비 무료 , 최대 <?php echo get_currency_price($TPL_VAR["coupons"]["wonShippingSale"], 2)?> 할인
<?php }else{?>
						기본 배송비 할인
						, <?php echo get_currency_price($TPL_VAR["coupons"]["won_shipping_sale"], 2)?> 할인
<?php }?>
				</div>

<?php }elseif($TPL_VAR["set_coupon_form"]["benefit_type"]=="mileage"){?>
				<div class="mileage">
					쿠폰 인증 시 마일리지 <?php if(!$TPL_VAR["coupons"]["offline_emoney"]){?>0<?php }else{?><?php echo get_currency_price($TPL_VAR["coupons"]["offline_emoney"], 2)?><?php }?> 지급
				</div>
<?php }?>
			</td>
		</tr>
		<tr class="t_limit_goods_price">
			<th>최소 주문 금액 <span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/coupon', '#tip_limit_goods_price', 'sizeS')"></span></th>
			<td>해당 상품 <?php if(!$TPL_VAR["coupons"]["limit_goods_price"]){?>0<?php }else{?><?php echo get_currency_price($TPL_VAR["coupons"]["limit_goods_price"], 2)?><?php }?> 이상 구매 시 사용 가능</td>
		</tr>
		<tr class="t_mileage_period_limit hide">
			<th>마일리지 유효기간</th>
			<td><?php if($TPL_VAR["checked_"]['period_limit']['unlimit']){?>제한없음<?php }else{?>제한<?php }?></td>
		</tr>
		<tr class="t_period_limit">
			<th>유효기간 <span class="required_chk"></span></th>
			<td>
<?php if($TPL_VAR["checked_"]['issue_priod_type']['date']){?>
					 <?php echo $TPL_VAR["coupons"]["issue_startdate"]?> ~ <?php echo $TPL_VAR["coupons"]["issue_enddate"]?>

<?php }elseif($TPL_VAR["checked_"]['issue_priod_type']['day']){?>
					발급일로부터 <?php echo $TPL_VAR["coupons"]["after_issue_day"]?>일
<?php }elseif($TPL_VAR["checked_"]['issue_priod_type']['months']){?>
					발급 당월 말일까지
<?php }elseif($TPL_VAR["checked_"]['offline_reserve_select']['year']){?>
					지급 년도 + <?php echo $TPL_VAR["coupons"]["offline_reserve_year"]?> 년 말일까지
<?php }elseif($TPL_VAR["checked_"]['offline_reserve_select']['direct']){?>
					<?php echo $TPL_VAR["coupons"]["offline_reserve_direct"]?>  개월 까지
<?php }?>
			</td>
		</tr>
		<tr class="t_duplication_set">
			<th>
<?php if($TPL_VAR["set_coupon_form"]["duplicationUseSet"]=="duplicate_discount"){?>
				<span class="title">중복 할인</span>
				<span class="tooltip_btn duplicationUseSet" onClick="showTooltip(this, '/selleradmin/tooltip/coupon', '#tip_duplicate_discount', 'sizeS')"></span>
<?php }elseif($TPL_VAR["set_coupon_form"]["duplicationUseSet"]=="duplicate_down"){?>
				<span class="title">중복 다운</span>
				<span class="tooltip_btn duplicate_down" onClick="showTooltip(this, '/selleradmin/tooltip/coupon', '#tip_duplicate_down', 'sizeS')"></span>
<?php }elseif($TPL_VAR["set_coupon_form"]["duplicationUseSet"]=="duplicate_all"){?>
				<span class="title">중복할인/중복다운</span>
				<span class="tooltip_btn duplicate_all" onClick="showTooltip(this, '/selleradmin/tooltip/coupon', '#tip_duplicate_all', 'sizeS')"></span>
<?php }?>
			</th>
			<td>
<?php if($TPL_VAR["checked_"]['duplication_use']['0']){?>불가<?php }else{?>가능<?php }?>
			</td>
		</tr>
		</table>
		</div>
<?php if(!in_array($TPL_VAR["coupons"]["type"],array('offline_emoney','offline_coupon'))){?>
		<div class="resp_message">- 쿠폰별 발급 주기 안내 <a href="https://www.firstmall.kr/customer/faq/1320 " class="resp_btn_txt" target="_blank">자세히 보기</a></div>
<?php }?>
	<!---- 3. 혜택 설정 종료 ---->


	<!---- 4. 쿠폰 발급 시작 ---->
<?php if($TPL_VAR["set_coupon_form"]["downloadLimitSet"]!=""||$TPL_VAR["set_coupon_form"]["downloadPeriodSet"]!=""||$TPL_VAR["set_coupon_form"]["memberGradeSet"]!=""){?>
		<div class="item-title ui_coupon_inssuance">쿠폰 발급</div>
		<table class="table_basic thl ui_coupon_inssuance">
		<tr class="t_download_limit">
			<th>수량 <span class="required_chk"></span></th>
			<td>
				<div class="resp_radio">
<?php if($TPL_VAR["checked_"]['download_limit']['auto']){?>
						자동
<?php }elseif($TPL_VAR["checked_"]['download_limit']['unlimit']){?>
						제한없음
<?php }elseif($TPL_VAR["checked_"]['download_limit']['limit']){?>
						수량 제한 <?php echo $TPL_VAR["coupons"]["download_limit_ea"]?> 개
<?php }?>
				</div>
			</td>
		</tr>
<?php if($TPL_VAR["set_coupon_form"]["downloadPeriodSet"]){?>
		<tr class="t_coupon_download_period_use">
			<th>발급 기간</th>
			<td> <?php if($TPL_VAR["set_coupon_form"]["downloadPeriodSet"]=="auto"){?>
					자동
<?php }else{?>
<?php if($TPL_VAR["coupons"]["download_period_use"]=='unlimit'){?>제한없음<?php }else{?>제한<?php }?>
<?php }?>
			</td>
		</tr>
		<tr class="t_coupon_issued <?php if($TPL_VAR["coupons"]["download_period_use"]=='unlimit'){?>hide<?php }?>">
			<th>기간설정 <span class="required_chk"></span></th>
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
				
<?php if($TPL_VAR["set_coupon_form"]["downloadPeriodSet"]=="auto"){?>
				<div class="auto">자동</div>
<?php }elseif($TPL_VAR["set_coupon_form"]["downloadPeriodSet"]=="period"){?>
				<!-- 기간/시간/요일 설정 -->
				<div class="period">
					<?php echo $TPL_VAR["coupons"]["download_startdate"]?> <?php echo $TPL_VAR["coupons"]["download_starthour"]?>:<?php echo $TPL_VAR["coupons"]["download_startmin"]?>

					<span class="gray" style="margin:0 1px;">~</span>
					<?php echo $TPL_VAR["coupons"]["download_enddate"]?> <?php echo $TPL_VAR["coupons"]["download_endhour"]?>:<?php echo $TPL_VAR["coupons"]["download_endmin"]?>

				</div>
<?php }elseif($TPL_VAR["set_coupon_form"]["downloadPeriodSet"]=="beforeafter"){?>
				<!-- 생일 : 00일전 ~ 00일 후 -->
				<div class="beforeafter">
<?php if($TPL_VAR["couponse"]["type"]=="birthday"){?>생일<?php }else{?>기념일<?php }?>
					<?php echo $TPL_VAR["coupons"]["beforeDay"]?> 일전 ~ <?php echo $TPL_VAR["coupons"]["afterDay"]?> 일 이후
				</div>
<?php }elseif($TPL_VAR["set_coupon_form"]["downloadPeriodSet"]=="daysfrom"){?>
				<!--등급조정 :  00일로부터 -->
				<div class="daysfrom">
					등급 조정일로부터 <?php echo $TPL_VAR["coupons"]["after_upgrade"]?> 일 까지
				</div>
<?php }elseif($TPL_VAR["set_coupon_form"]["downloadPeriodSet"]=="neworder"){?>
				<!-- 신규가입 미구매 -->
				<div class="neworder">
					신규 가입 <?php echo $TPL_VAR["coupons"]["order_terms"]?> 일 이후 미 구매 시(월 1회)
				</div>
<?php }elseif($TPL_VAR["set_coupon_form"]["downloadPeriodSet"]=="notpurchased"){?>
				<!-- 00동안 미구매 -->
				<div class="notpurchased">
					최근 <?php echo $TPL_VAR["coupons"]["memberlogin_terms"]?> 개월 동안 미 구매 시 (월 1회)
				</div>
<?php }elseif($TPL_VAR["set_coupon_form"]["downloadPeriodSet"]=="onceamonthdownload"){?>
				<!-- 월1회 다운로드-->
				<div class="onceamonthdownload">해당 등급의 회원에게 월 1회 발급</div>
<?php }?>
			</td>
		</tr>
<?php }?>
<?php if($TPL_VAR["set_coupon_form"]["downloadPeriodSet"]=="period"){?>
		<tr class="t_time_limit <?php if($TPL_VAR["coupons"]["download_period_use"]=='unlimit'){?>hide<?php }?>">
			<th>시간 제한</th>
			<td>
				<?php echo $TPL_VAR["coupons"]["download_starttime_h"]?> ~ <?php echo $TPL_VAR["coupons"]["download_starttime_m"]?>

				<span class="gray" style="margin:0 1px;">~</span>
				<?php echo $TPL_VAR["coupons"]["download_endtime_h"]?> ~ <?php echo $TPL_VAR["coupons"]["download_endtime_m"]?>

			</td>
		</tr>
<?php }?>
<?php if($TPL_VAR["set_coupon_form"]["downloadPeriodSet"]=="period"){?>
		<tr class="t_dayoftheweek_limit <?php if($TPL_VAR["coupons"]["download_period_use"]=='unlimit'){?>hide<?php }?>">
			<th>요일 제한</th>
			<td><?php echo implode(", ",$TPL_VAR["checked_"]['download_week'])?></td>
		</tr>
<?php }?>
<?php if($TPL_VAR["set_coupon_form"]["memberGradeSet"]!=""){?>
		<tr class="t_member_grade">
			<th>회원 등급 지정</th>
			<td>
<?php if($TPL_VAR["set_coupon_form"]["memberGradeSet"]=="auto"){?>
				<div class="auto">자동</div>
<?php }elseif($TPL_VAR["set_coupon_form"]["memberGradeSet"]=="gradelimit"){?>
				<div class="gradelimit">
					<div class="mt10 wx400 member_grade_list">
						<table class="table_basic">
							<thead>
								<tr>
									<th>등급</th>	
								</tr>
							</thead>
							<tbody>
								<tr rownum=0 <?php if(count($TPL_VAR["couponGroups"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
									<td class="center">선택된 회원 등급이 없습니다.</td>
								</tr>
<?php if($TPL_couponGroups_1){foreach($TPL_VAR["couponGroups"] as $TPL_V1){?>
								<tr rownum="<?php echo $TPL_V1["group_seq"]?>">
									<td class="center"><?php echo $TPL_V1["group_name"]?></td>
								</tr>
<?php }}?>
							</tbody>
						</table>
					</div>
					<ul class="bullet_hyphen mt5">
						<li>회원 등급을 선택하지 않는 경우 전체 회원에게 발급됩니다.</li>
					</ul>
				</div>
<?php }?>
			</td>
		</tr>
<?php }?>
		</table>
<?php }?>
	<!---- 4. 쿠폰 발급 종료 ---->


	<!---- 5. 쿠폰 인증 시작(offline)  ---->
<?php if($TPL_VAR["set_coupon_form"]["couponCertificationSet"]=="y"){?>
		<div class="item-title ui_coupon_certification">쿠폰 인증</div>
		<table class="table_basic thl ui_coupon_certification">
		<tr>
			<th>인증 횟수 <span class="required_chk"></span></th>
			<td>
				동일한 쿠폰 최대 <?php if(!$TPL_VAR["coupons"]["download_limit_ea"]){?>1<?php }else{?><?php echo $TPL_VAR["coupons"]["download_limit_ea"]?><?php }?> 회 인증 가능
			</td>
		</tr>
		<tr>
			<th>인증 기간 <span class="required_chk"></span></th>
			<td><?php echo $TPL_VAR["coupons"]["download_startdate"]?> ~ <?php echo $TPL_VAR["coupons"]["download_enddate"]?></td>
		</tr>
		</table>
<?php }?>
	<!---- 5. 쿠폰 인증 종료(offline) ---->

	<!---- 6. 전환포인트 시작 ---->
<?php if($TPL_VAR["set_coupon_form"]["conversionPointSet"]=="y"){?>
		<div class="item-title ui_conversion_point">전환 포인트</div>
		<table class="table_basic thl ui_conversion_point">
		<tr>
			<th>전환 포인트 <span class="required_chk"></span></th>
			<td><?php echo get_currency_price($TPL_VAR["coupons"]["coupon_point"], 1)?> P 를 쿠폰으로 전환</td>
		</tr>
		</table>
<?php }?>
	<!---- 6. 전환포인트 종료 ---->

	<!---- 7. 인증번호발급 시작 ---->
<?php if($TPL_VAR["set_coupon_form"]["certificationNumberSet"]=="y"){?>
		<div class="item-title ui_certification_number">인증번호 발급</div>
		<table class="table_basic thl ui_certification_number">
		<tr <?php if($TPL_VAR["coupons"]["coupon_seq"]){?>class="hide"<?php }?>>
			<th>발급 설정</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="certificate_issued_type" value="auto" <?php echo $TPL_VAR["checked_"]['certificate_issued_type']['auto']?> /> 자동</label>
					<label><input type="radio" name="certificate_issued_type" value="manual" <?php echo $TPL_VAR["checked_"]['certificate_issued_type']['manual']?> /> 수동</label>
				</div>
			</td>
		</tr>
		<tr class="t_offline_type <?php if($TPL_VAR["coupons"]["coupon_seq"]){?>hide<?php }?>">
			<th>발급 방식</th>
			<td>
				<div class="auto resp_radio">
					<label><input type="radio" name="offline_type" value="random" <?php echo $TPL_VAR["checked_"]['offline_type']['random']?> />  랜덤 인증 번호 생성</label>
					<label><input type="radio" name="offline_type"  value="one" <?php echo $TPL_VAR["checked_"]['offline_type']['one']?> />  1개의 인증번호 생성</label>
				</div>
				<div class="manual hide resp_radio">
					<label><input type="radio" name="offline_type" value="file" <?php echo $TPL_VAR["checked_"]['offline_type']['file']?> />  수동 엑셀 등록</label>
					<label><input type="radio" name="offline_type"  value="input" <?php echo $TPL_VAR["checked_"]['offline_type']['input']?> />  1개의 인증번호 지정</label>
				</div>
			</td>
		</tr>
		<tr class="t_offline_input_num hide">
			<th>인증번호 입력 <span class="required_chk"></span></th>
			<td><?php if($TPL_VAR["coupons"]["coupon_seq"]){?>
				동일 인증번호 [<?php echo $TPL_VAR["coupons"]["offline_input_serialnumber"]?>]
				<span class="btn small valign-middle cyanblue"><input type="button" id="offline_coupon_copy" offline_input_serialnumber="<?php echo $TPL_VAR["coupons"]["offline_input_serialnumber"]?>" value="인증번호 복사" /></span>
<?php }else{?>
				<input type="text" name="offline_input_num" class="offline_input_num" value="<?php echo $TPL_VAR["coupons"]["offline_input_serialnumber"]?>" size="20" title="인증번호입력">
<?php }?>
			</td>
		</tr>
		<tr class="t_offlineLimit_input hide">
			<th>인증 횟수 <span class="required_chk"></span></th>
			<td><?php if($TPL_VAR["coupons"]["coupon_seq"]){?>
<?php if($TPL_VAR["coupons"]["offline_limit"]=='unlimit'){?>
						제한없이 쿠폰인증 허용
<?php }else{?>
						선착순 <?php echo number_format($TPL_VAR["coupons"]["offline_limit_ea"])?>번까지 쿠폰 인증 허용
<?php }?>
<?php }else{?>
				<select name="offlineLimit_input">
				<option value="unlimit" <?php echo $TPL_VAR["selected_"]['offlineLimit_input']['unlimit']?>>제한 없음</option>
				<option value="limit" <?php echo $TPL_VAR["selected_"]['offlineLimit_input']['limit']?>>선착순</option>
				</select>
				
				<span class="offlineLimitEa_input <?php if($TPL_VAR["selected_"]['offlineLimit_input']['unlimit']){?>hide<?php }?>"><input type="text" class="onlynumber right" name="offlineLimitEa_input" value="<?php echo $TPL_VAR["coupons"]["offline_limit_ea"]?>"  size="11" /> 번째 까지 가능</span>
<?php }?>
			</td>
		</tr>
		<tr class="t_offline_random_num">
			<th>인증번호 발급 수 <span class="required_chk"></span></th>
			<td>
				<?php echo $TPL_VAR["coupons"]["offline_random_num"]?>개 (최대 1만개)
			</td>
		</tr>
		<tr class="t_offlineLimit_one hide">
			<th>인증 제한 <span class="required_chk"></span></th>
			<td>
				<select name="offlineLimit_one">
				<option value="unlimit" <?php echo $TPL_VAR["selected_"]['offlineLimit_one']['unlimit']?> >제한 없음</option>
				<option value="limit" <?php echo $TPL_VAR["selected_"]['offlineLimit_one']['limit']?>>선착순</option>
				</select>
				<span class="offlineLimitEa_one hide"><input type="text" class="onlynumber" name="offlineLimitEa_one" value="<?php echo $TPL_VAR["coupons"]["offline_limit_ea"]?>"  size="11" /> 번째 까지 가능</span>
			</td>
		</tr>
<?php if($TPL_VAR["coupons"]["offline_type"]=='file'){?>
		<tr class="t_excel_upload hide">
			<th>인증번호 수동등록 <span class="required_chk"></span></th>
			<td>
				<div class="offline_type3"  style="padding:5px 0 0 0;">  [총 <?php echo number_format($TPL_VAR["coupons"]["offlinecoupontotal"])?>건]
				<button type="button" class="offline_coupon_view resp_btn v2">인증번호 보기</button>
				<button type="button" class="offline_coupon_excel_down resp_btn">인증번호 엑셀 다운로드</button>
				</div>
			</td>
		</tr>
<?php }else{?>
		<tr class="t_excel_upload hide">
			<th>엑셀 <span class="required_chk"></span></th>
			<td>
				<input type="hidden" name="offline_file" class="offline_file"> 
				<button type="button" class="batchExcelRegist resp_btn v2">등록</button>
				<span class="offline_file_name"></span>
			</td>
		</tr>
<?php }?>
		</table>
<?php }?>
	<!---- 7. 인증번호발급 종료 ---->

	<!---- 8. 쿠폰 사용 제한 시작 ---->
<?php if($TPL_VAR["set_coupon_form"]["usedTogether"]!="y"&&$TPL_VAR["set_coupon_form"]["goodsCategoryLimit"]!="y"&&($TPL_VAR["set_coupon_form"]["deviceUsed"]!="y"&&$TPL_VAR["set_coupon_form"]["deviceUsed"]!="app")&&$TPL_VAR["set_coupon_form"]["methodOfPayment"]!="y"&&$TPL_VAR["set_coupon_form"]["refererLimit"]!="y"){?>
<?php }else{?>
		<div class="item-title ui_usage_restriction">쿠폰 사용 제한</div>
		<table class="table_basic thl ui_usage_restriction">
		<tr class="t_used_together">
			<th>타 쿠폰과 함께 사용</th>
			<td colspan="2"><?php if($TPL_VAR["checked_"]['coupon_same_time']['N']){?>사용 불가<?php }else{?>사용 가능<?php }?></td>
		</tr>
		<tr class="t_goods_category_limit">
			<th <?php if(!$TPL_VAR["checked_"]['issue_type']['all']){?>rowspan="2"<?php }?>>상품/카테고리 제한</th>
			<td><?php if($TPL_VAR["checked_"]['issue_type']['all']){?>제한 없음<?php }elseif($TPL_VAR["checked_"]['issue_type']['issue']){?>선택한 상품/카테고리<?php }else{?>선택한 상품/카테고리를 제외<?php }?></td>
		</tr>
<?php if(!$TPL_VAR["checked_"]['issue_type']['all']){?>
		<tr class="t_goods_category_limit">
			<td class="clear">
				<table class="table_basic thl v3 t_select_goods">
				<tbody>
					<tr class="t_goods">
						<th>상품</th>
						<td>
							<div class="mt10 wx600">
								<div class="goods_list_header">
								<table class="table_basic tdc">
									<colgroup>
										<col width="75%" />
										<col width="25%" />
									</colgroup>
									<tbody>
										<tr>
											<th>상품명</th>
											<th>판매가</th>
										</tr>
									</tbody>
								</table>
								</div>
								<div class="goods_list">
								<table class="table_basic tdc fix">
									<colgroup>
										<col width="75%" />
										<col width="25%" />
									</colgroup>
									<tbody>
										<tr rownum=0 <?php if(count($TPL_VAR["issuegoods"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
											<td colspan="2">선택된 상품이 없습니다.</td>
										</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->
<?php if($TPL_issuegoods_1){foreach($TPL_VAR["issuegoods"] as $TPL_V1){?>
										<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
											<td class='left'>
												<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></div>
												<div class="goodsname">
<?php if($TPL_V1["goods_code"]){?><div>[상품코드:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
													<div><?php echo $TPL_V1["goods_kind_icon"]?> <a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V1["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 30)?></a></div>
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
							<div class="mt10 wx600 category_list">
								<table class="table_basic">
									<thead>
										<tr class="nodrag nodrop">
											<th>카테고리명</th>
										</tr>
									</thead>
									<tbody>
										<tr rownum=0 <?php if(count($TPL_VAR["issuecategorys"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
											<td class="center">선택된 카테고리가 없습니다.</td>
										</tr>
<?php if($TPL_issuecategorys_1){foreach($TPL_VAR["issuecategorys"] as $TPL_V1){?>
										<tr rownum="<?php echo $TPL_V1["category_code"]?>">
											<td class="center"><?php echo $TPL_V1["category"]?></td>
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
<?php }?>
		<tr class="t_device_used">
			<th>사용 가능 환경</th>
			<td><?php if($TPL_VAR["checked_"]['sale_agent']['a']){?>제한 없음<?php }elseif($TPL_VAR["checked_"]['sale_agent']['m']){?>모바일<?php }else{?>쇼핑몰앱<?php }?></td>
		</tr>
		<tr class="t_method_of_payment">
			<th>결제 가능 수단</th>
			<td><?php if($TPL_VAR["checked_"]['sale_payment']['a']){?>제한 없음<?php }else{?>무통장<?php }?></td>
		</tr>
		<tr class="t_referer_limit">
			<th>할인 유입 경로</th>
			<td><?php if($TPL_VAR["checked_"]['sale_referer']['a']){?>제한 없음<?php }elseif($TPL_VAR["checked_"]['sale_referer']['n']){?>유입경로 할인 없을 때 가능<?php }else{?>유입경로 할인 있을 때 가능<?php }?></td>
		</tr>
<?php if(!$TPL_VAR["checked_"]['sale_referer']['a']){?>
		<tr class="t_referer_limit">
			<th>유입 경로 할인 제한</th>
			<td class="clear">
				<table class="table_basic thl v3">
				<tbody>
					<tr>
						<th>유입경로 할인 중복</th>
						<td><?php if($TPL_VAR["checked_"]['sale_referer_type']['a']){?>모든 유입 경로 할인<?php }elseif($TPL_VAR["checked_"]['sale_referer_type']['s']){?>선택한 유입 경로 할인<?php }?></td>
					</tr>
					<tr class="t_select_referer">
						<th>상세 선택</th>
						<td>
							<div class="mt10 wx600 referersale_list">
								<table class="table_basic">
									<thead>
										<tr class="nodrag nodrop">
											<th>유입경로명</th>
										</tr>
									</thead>
									<tbody>
										<tr rownum=0 <?php if(count($TPL_VAR["salserefereritemloop"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
											<td class="center" colspan="2">선택된 할인 유입 경로가 없습니다.</td>
										</tr>
<?php if($TPL_VAR["coupons"]["sale_referer"]=='y'&&$TPL_VAR["coupons"]["sale_referer_type"]=='s'){?> 
<?php if($TPL_VAR["salserefereritemloop"]){?> 
<?php if($TPL_salserefereritemloop_1){foreach($TPL_VAR["salserefereritemloop"] as $TPL_V1){?>
										<tr rownum="<?php echo $TPL_V1["referersale_seq"]?>">
											<td class="center"><?php echo $TPL_V1["referersale_name"]?></td>
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
<?php }?>
		</table>
<?php }?>
	<!---- 8. 쿠폰 사용 제한 종료 ---->


	<!---- 9. 쿠폰 이미지 시작 ---->
<?php if($TPL_VAR["set_coupon_form"]["couponImageSet"]=="y"){?>
		<div class="item-title ui_coupon_image">쿠폰 이미지</div>
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
		<table class="table_basic thl ui_coupon_image">
		<tr class="t_coupon_image_set">
			<th>샘플 이미지</th>
			<td>
				<div style="width:400px;" class="couponImg_light_1" src_sample="/data/coupon/light_coupon_sample_01.png" src_orign="/data/coupon/light_coupon_sample_01_origin.png" ><label for="couponImg_light_1"><img src="/data/coupon/light_coupon_sample_01.png" id="couponImg_light_1_src" /></label></div><div style="clear: both"></div>
				<span class="desc">※ 상기 샘플 이미지는 스킨에 따라 다르게 보일 수 있습니다.</span>
			</td>
		</tr>
		</table>
<?php }else{?>
		<table class="table_basic thl ui_coupon_image">
		<tr>
			<th>쿠폰 이미지</th>
			<td class="clear">
				<table class="table_basic thl v3">
					<tbody>
					<tr>
						<th>PC용</th>
						<td><img src="/data/coupon/coupon<?php if($TPL_VAR["coupons"]["coupon_same_time"]=='N'){?>sametime<?php }?>_sample_0<?php echo $TPL_VAR["coupons"]["coupon_img"]?>.gif" width="180" /></td>
					</tr>
					<tr>
						<th>Mobile</th>
						<td><img src="/data/coupon/coupon<?php if($TPL_VAR["coupons"]["coupon_same_time"]=='N'){?>sametime<?php }?>_sample_mobile_0<?php echo $TPL_VAR["coupons"]["coupon_mobile_img"]?>.gif" width="180" /></td>
					</tr>
					</tbody>
				</table>
			</td>
		</tr>
		</tbody>
		</table>
<?php }?>
<?php }?>
	<!---- 9. 쿠폰 이미지 종료 ---->
</div>

<p><br /></p>

<script type="text/javascript">
$(function() {
	var left_scroll_x;
	var left_scroll_y;
	var right_scroll_y;
	var xxx = 0;
	$('.t_select_goods .goods_list').mouseover(function() {
		$('.t_select_goods .goods_list').on('scroll', function() {
			left_scroll_x = $('.goods_list').scrollLeft();
			$('.t_select_goods .goods_list_header').scrollLeft( left_scroll_x );
		});
	});
});
</script>

<?php $this->print_("coupongoodslayer",$TPL_SCP,1);?>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>