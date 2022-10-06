<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/accountall/accountgroup.html 000012214 */ 
$TPL_year_1=empty($TPL_VAR["year"])||!is_array($TPL_VAR["year"])?0:count($TPL_VAR["year"]);
$TPL_month_1=empty($TPL_VAR["month"])||!is_array($TPL_VAR["month"])?0:count($TPL_VAR["month"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<!-- dom 보다 늦게 로드 되어야 합니다 requirejs 적용불가 -->
<script defer src="/app/javascript/js/alpinejs.3.10.0.min.js"></script>

<script type="text/javascript" >
$(function () {
	gSearchForm.init({'pageid':'accountgroup','sc':<?php echo $TPL_VAR["scObj"]?>}, function () {
		// alpinejs 검색 이벤트 붙이지 못해서 우회방법 사용
		$('#alpinejs-trriger-search').trigger('click');
	});
});
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>업체별 정산</h2>
		</div>		
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<!-- 리스트검색폼 : 시작 -->
<div id="search_container" class="search_container">
	<form name="accountsearch" id="accountsearch"  class="search_form">
	<table class="table_search">
		<tr>
			<th>기간</th>
			<td>
				<select name="s_year" class="wx80" defaultValue="<?php echo date('Y')?>">
<?php if($TPL_year_1){foreach($TPL_VAR["year"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["sc"]["s_year"]==$TPL_V1){?> selected="selected" <?php }?> ><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
				<select name="s_month" class="wx80" defaultValue="<?php echo date('m')?>">
<?php if($TPL_month_1){foreach($TPL_VAR["month"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["sc"]["s_month"]==$TPL_V1){?> selected="selected" <?php }?> ><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</td>
		</tr>

		<tr>
			<th>입점사명</th>
			<td>				
				<select name="provider_seq_selector" data-mode='account' style="vertical-align:middle;">
				</select>
				<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $TPL_VAR["sc"]["provider_seq"]?>" />		
			</td>
		</tr>

		<tr>
			<th>정산 주기</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="pay_period" id="pay_period_all" value="all"> 전체</label>
					<label><input type="radio" name="pay_period" id="pay_period_1" value="1"> 1회</label>
					<label><input type="radio" name="pay_period" id="pay_period_2" value="2"> 2회</label>
					<label><input type="radio" name="pay_period" id="pay_period_4" value="4"> 4회</label>
				</div>
			</td>
		</tr>
	</table>

	<div class="footer search_btn_lay"></div>
	
	</form>
</div>

<div class="contents_dvs v2" x-data="asyncList()">
	<template @click="search" id="alpinejs-trriger-search"></template>
	<div class="table_row_frame">
		<div class="dvs_top">			
			<div class="dvs_left">	
				<span class="confirm_setting_date">
		
					<span
						x-html="calculateCloseInfoHtml"
					></span>
		
				</span>
				<span>* 부가세(VAT) 포함</span>
			</div>

			<div class="dvs_right">
				<button @click="excelDownload" type="button"  value="" class="resp_btn v3"><span class="icon_excel"></span> 다운로드</button>		
			</div>
		</div>

		<div id="account_table">
			<table width="100%" class="calc-table-style group" cellpadding="0" cellspacing="0">
				<caption>정산리스트</caption>
				<!-- 테이블 헤더 : 시작 -->
				<colgroup>
					<col width="35"/><!--순번-->
					<col width="200" /><!--입점사-->
					<col width="100" /><!--정산횟수-->
					<col width="100" /><!--정산기간-->
					<col width="130" /><!--정산-정산대상금액-->
					<col width="130" /><!--정산-수수료-->
					<col width="130" /><!--정산금액-->
				</colgroup>
				<thead>
					<tr>
						<th scope="col" rowspan="2">순번</th>
						<th scope="col" rowspan="2">입점사 ID</th>
						<th scope="col" rowspan="2">정산횟수</th>
						<th scope="col" rowspan="2">정산기간</th>
						<th scope="col" colspan="2">정산</th>
						<th scope="col" rowspan="2">정산금액</th>
					</tr>
					<tr>
						<th scope="col">정산대상금액</th>
						<th scope="col">수수료</th>
					</tr>
				</thead>
				<tbody>
				<template x-if="list.length === 0">
					<tr>
						<td colspan="7" class="nodata">조회 내역이 없습니다.</td>
					</tr>
				</template>
				<template x-for="(account, index) in sortList()" :key="index">
					<tr>
						<template x-if="account.period_count === 0">
							<td
								x-text="countList" 
								:rowspan="account.period_type"
								name="account-list-count"
							></td>
						</template>
						<template x-if="account.period_count === 0">
							<td 
								class="left" 
								:rowspan="account.period_type"
							>
								<a
									:href="account.href"
									target="_blank"
									x-text="account.provider_name + '(' + account.provider_id + ')'"
								></a>
							</td>
						</template>
						<template x-if="account.period_count === 0">
							<td :rowspan="account.period_type">월
							<span x-text="account.period_type"></span>회</td>
						</template>
						<td x-text="account.settlePeriodText"></td>
						<td class="right" x-text="comma(account.sum_price)"></td>
						<td class="right" x-text="comma(account.sum_feeprice)"></td>
						<td class="right" x-text="comma(account.sum_commission_price)"></td>
					</tr>
				</template>
				</tbody>
				<tfoot>
					<tr class="sum">
						<td colspan="4">총합계</td>
						<td class="right" x-text="comma(listTotalSum.sum_price)"></td>
						<td class="right" x-text="comma(listTotalSum.sum_feeprice)"></td>
						<td class="right" x-text="comma(listTotalSum.sum_commission_price)"></td>
					</tr>
				</tfoot>
			</table>
		</div>

		<div class="dvs_bottom">			
			<div class="dvs_right">
				<button @click="excelDownload" type="button"  value="" class="resp_btn v3"><span class="icon_excel"></span> 다운로드</button>		
			</div>
		</div>
	</div>
</div>

<!-- 서브 레이아웃 영역 : 끝 -->
<script>
document.addEventListener('alpine:init', () => {
	Alpine.data('asyncList', () => ({
		// 한번에 가져오는 입점사 수
		intervalCount : 50,
		list : [],
		listTotalSum : {
			// 정산 대상금액
			sum_price : 0,
			// 정산 수수료
			sum_feeprice : 0,
			// 정산 금액
			sum_commission_price : 0,
		},
		// 정산 마감 안내
		calculateCloseInfoHtml : '',
		// 모든 입점사 리스트
		providerList : JSON.parse('<?php echo $TPL_VAR["providerList"]?>'),
		// 진행사항
		progressCount : 0,
		// 리스트 순번 카운트
		countBoardList : {},
		// 비동기로 데이터가 수집되어서 정렬 처리
		sortList() {
			return this.list.sort((a, b) => {
				return a.provider_seq - b.provider_seq;
			});
		},
		year() {
			return $('[name=s_year]').val();
		},
		month() {
			return $('[name=s_month]').val();
		},
		// 정산주기
		payPeriod() {
			return $(':radio[name="pay_period"]:checked').val() || '';
		},
		// 정산횟수(1,2,4) 에 따라서 데이터가 달라져서 index 사용하지 못함
		countList() {
			return $('[name=account-list-count').length;
		},
		add(company) {
			// 입점사 정산 링크
			company.href = "./accountallviewerall?provider_seq=" + company.provider_seq 
				+ "&provider_seq_selector=" + company.provider_seq 
				+ "&provider_name=" + encodeURI(company.provider_name) + "("+company.provider_id + ")"
				+ "&s_year=" + this.year()
				+ "&s_month=" + this.month();

			// 정산주기 (숫자 의미는..)
			const settlePeriod = {
				2 : {
					0 : '01일 ~ 15일',
					1 : '16일 ~ 말일',
				},
				4 : {
					0 : '01일 ~ 07일',
					1 : '08일 ~ 14일',
					2 : '15일 ~ 21일',
					3 : '22일 ~ 말일',
				},
			}
			if (typeof settlePeriod[company.period_type] === 'undefined') {
				company.settlePeriodText = '01일 ~ 말일';
			} else {
				company.settlePeriodText = settlePeriod[company.period_type][company.period_count];
			}

			this.list.push(company);
		},
		reset() {
			this.list = [];

			this.listTotalSum.sum_price = 0;
			this.listTotalSum.sum_feeprice = 0;
			this.listTotalSum.sum_commission_price = 0;

			this.progressCount = 0;
		},
		setTotalSum(company) {
			this.listTotalSum.sum_price += company.sum_price;
			this.listTotalSum.sum_feeprice += company.sum_feeprice;
			this.listTotalSum.sum_commission_price += company.sum_commission_price;
		},
		setCalculateCloseHtml(calculate) {
			this.calculateCloseInfoHtml = this.year() + '년 ' + this.month() + '월 정산마감일 : ';
			
			if (calculate.accountConfirm !== null) {
				this.calculateCloseInfoHtml += calculate.accountConfirm.confirm_name + '(' + calculate.accountConfirm.confirm_end_date + ' 마감실행)';
			} else {
				this.calculateCloseInfoHtml += calculate.accountallConfirmSetting.confirm_name + '(' + calculate.accountallConfirmSetting.confirm_date + ' <font color=\'red\'>마감실행예정</font>)';
			}
		},
		// 정산 데이터 가져오기
		settleData(provider_seq_list) {
			// 바로 진행률 보여주기 위해서 시작전 추가
			simpleProgress.run(this.progressPercent());
							
			$.ajax({
				type: "get",
				url: "/admin/accountall/async_accountgroup?s_year=" + this.year() + "&s_month=" + this.month() + "&pay_period=" + this.payPeriod() + "&provider_seq_list=" + provider_seq_list, 
				dataType : 'json',
				async : true,
				// rest api 통신 실패시 http code 400 수신
				error(response) {
					alert(JSON.parse(response.responseText).message);
					simpleProgress.run(100);
				}
			})
			.then((response) => {
				if (
					response.result === 'success' 
					&& response.accountGroups.length > 0
				) {
					response.accountGroups.map((company) => {
						// 총 합산
						this.setTotalSum(company);
						// 리스트에 등록
						this.add(company);
					});
				}
				// 정산마감 안내 text
				this.setCalculateCloseHtml(response.calculate);
				
				// progress 카운터 증가
				this.progressCount++;
			})
			.then(() => {
				// 진행률 표기
				simpleProgress.run(this.progressPercent());
			});
		},
		progressPercent() {
			// 풀이 : Math.round(ajax 호출 횟수 / Math.ceil(전체 입점사수 / this.intervalCount) * 100);
			return Math.round(this.progressCount / Math.ceil(this.providerList.length / this.intervalCount) * 100) || 0;
		},
		// 모든 입점사 데이터 가져오기
		allSettleData() {
			let providerSendGroup = [];
			const listLength = this.providerList.length;
			
			for (let i = 0; i < listLength; i++) {
				let providerSeq = this.providerList[i].no;

				providerSendGroup.push(providerSeq);

				/*
				 * 실행 조건
				 * 조건 1. 50 번째 마다 실행 입점사 ID 모아서 전송
				 * 조건 2. loop count 마지막이면 실행
				 */
				let isExecute =  ((i > 0 && i % this.intervalCount === 0) || i === (listLength - 1)) ? true : false;

				if (isExecute === true) {

					this.settleData(providerSendGroup.join(','));
					// 비우기
					providerSendGroup = [];
				}
			}
		},
		init() {
			// setTimeout 없이 바로 실행되면 freezing 현상 있음
			setTimeout(() => {
				this.allSettleData();
			}, 100);
		},
		search() {
			this.reset();

			let provider_seq = $('[name=provider_seq_selector]').val();
			if (provider_seq === 'all') {
				this.allSettleData();
			} else {
				this.settleData([provider_seq]);
			}
		},
		excelDownload() {
			if (this.list.length > 0) {
				divExcelDownload('sellertotal_' + this.year() + this.month(),'#account_table');
			} else {
				openDialogAlert('조회내역이 없습니다',300,180);
			}
		}
	}));
});
</script>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>