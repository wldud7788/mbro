<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/setting/add_national_delivery_desc.html 000030489 */ ?>
<style type="text/css">
/* 배송안내 샘플 테이블 스타일 */
.sample-table_style td { height:25px; }
.btn_move {border:1px solid #ccc; background:#fff; color:#666;}
.btn_chg.small, .btn_sch.small, .btn_gray.small, .btn_move.small {padding:0 7px 0; min-width:0; height:20px; line-height:20px; font-size:11px;}
.blue {color:#2c8ff0 !important;}
</style>
<script type="text/javascript">
function sample_pop(type){
	var height = 310;
	if(type == 2)		height = 280;
	else if(type == 3)	height = 240;
	openDialog("샘플", "sample_popup_" + type, {"width":450});
}

function lang_chg(){
	var l_type = $("#language_type option:selected").val();
	$(".lang_area").hide();
	$("#lang_" + l_type).show();
}

</script>

<div class="pdb5">
	<select name="language_type" id="language_type" onchange="lang_chg();" style="width:100px;">
		<option value="KR">한국어</option>
		<option value="EN">영어</option>
		<option value="CN">중국어</option>
	</select>
</div>

<div class="content">
	<div id="lang_KR" class="lang_area">
		<div class="title_dvs">
			<div class="item-title">
				택배, 직접배송, 퀵서비스, 화물배송, 직접입력 <button type="button" onclick="sample_pop('1')" class="resp_btn size_S">샘플보기</button>
			</div>
			<div class="r_dvs mb10">※ 해외배송일 때는 '지역'→'국가'로 대체됩니다.</div>
		</div>

		<table class="table_basic v8 thl tdc">
		<colgroup>
			<col width="160px" />
			<col width="150px" />
			<col width="270px" />
			<col width="270px" />
			<col width="" />
			<col width="" />
		</colgroup>
		<thead>
		<tr>
			<th colspan="2">배송비 산출기준별 예시</th>
			<th>기본 배송비</th>
			<th>추가 배송비</th>
			<th>희망배송일</th>
			<th>예약판매기간</th>
		</tr>
		</thead>

		<tbody>
		<tr>
			<th class="left">무료</th>
			<td>&nbsp;</td>
			<td>무료배송</td>
			<td class="center">해당없음</td>
			<td>
				희망배송일 : 01월 03일(오늘)부터 배송가능<br/>
				<span style="color:#00B0F0;">[배송가능일]</span> 선택사항
			</td>
			<td>예약판매 : 01월 03일부터 순차적으로 배송</td>
		</tr>
		<tr>
			<th class="left">무료+지역</th>
			<td>&nbsp;</td>
			<td>무료배송 <span class="desc">(배송가능지역별)</span></td>
			<td class="center">해당없음</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>

		<tr>
			<th class="left">고정</th>
			<td>&nbsp;</td>
			<td class="top-line">2,500원</td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th class="left">고정+지역</th>
			<td>&nbsp;</td>
			<td>무료~3,000원 <span class="desc">(배송가능지역별)</span></td>
			<td>추가배송비 : 무료~2,500원 <span class="desc">(지역별)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<!-- 구매금액 :: START -->
		<tr>
			<th class="left">구매금액(구간입력)</th>
			<td>구간입력 2개</td>
			<td class="top-line">2,500원 <span class="desc">(30,000원 이상 무료)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>무료~2,500원 <span class="desc">(구매금액별)</span></td>
			<td class="center">해당없음</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th class="left">구매금액(구간입력)+지역</th>
			<td>구간입력 2개</td>
			<td>2,500원 <span class="desc">(30,000원 이상 무료, 배송가능지역별)</span></td>
			<td>추가배송비 : 무료~2,500원 <span class="desc">(구매금액/지역별)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>무료~2,500원 <span class="desc">(구매금액/배송가능지역별)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>

		<tr>
			<th class="left">구매금액(구간반복)</th>
			<td>구간반복</td>
			<td class="top-line">2,500원<br/><span class="desc">(30,000원 이상 5,000원당 1,000원씩 추가)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th class="left">구매금액(구간반복)+지역</th>
			<td>구간반복</td>
			<td>2,500원<br/><span class="desc">(30,000원 이상 5,000원당 1,000원씩 추가, 배송가능지역별)</span></td>
			<td>추가배송비 : 무료~2,500원 <span class="desc">(구매금액/지역별)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<!-- 구매금액 :: END -->

		<!-- 구매수량 :: START -->
		<tr>
			<th class="left">구매수량(구간입력)</th>
			<td>구간입력 2개</td>
			<td class="top-line">2,500원 <span class="desc">(100개 이상 5,000원)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>무료~2,500원 <span class="desc">(구매수량별)</span></td>
			<td class="center">해당없음</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th class="left">구매수량(구간입력)+지역</th>
			<td>구간입력 2개</td>
			<td>2,500원 <span class="desc">(100개 이상 5,000원, 배송가능지역별)</span></td>
			<td>추가배송비 : 무료~2,500원 <span class="desc">(구매수량/지역별)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>무료~2,500원 <span class="desc">(구매수량/배송가능지역별)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>

		<tr>
			<th class="left">구매수량(구간반복)</th>
			<td>구간반복</td>
			<td class="top-line">2,500원<br/><span class="desc">(100개 이상 50개당 1,000원씩 추가)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th class="left">구매수량(구간반복)+지역</th>
			<td>구간반복</td>
			<td>2,500원<br/><span class="desc">(100개 이상 50개당 1,000원씩 추가, 배송가능지역별)</span></td>
			<td>추가배송비 : 무료~2,500원 <span class="desc">(구매금액/지역별)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<!-- 구매수량 :: END -->

		<!-- 구매무게 :: START -->
		<tr>
			<th class="left">구매무게(구간입력)</th>
			<td>구간입력 2개</td>
			<td class="top-line">2,500원 <span class="desc">(5Kg 이상 5,000원)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>무료~2,500원 <span class="desc">(구매무게별)</span></td>
			<td class="center">해당없음</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th class="left">구매무게(구간입력)+지역</th>
			<td>구간입력 2개</td>
			<td>2,500원 <span class="desc">(5Kg 이상 5,000원, 배송가능지역별)</span></td>
			<td>추가배송비 : 무료~2,500원 <span class="desc">(구매무게/지역별)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>무료~2,500원 <span class="desc">(구매무게/배송가능지역별)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>

		<tr>
			<th class="left">구매무게(구간반복)</th>
			<td>구간반복</td>
			<td class="top-line">2,500원<br/><span class="desc">(5Kg 이상 3Kg당 1,000원씩 추가)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th class="left">구매무게(구간반복)+지역</th>
			<td>구간반복</td>
			<td>2,500원<br/><span class="desc">(5Kg 이상 3Kg당 1,000원씩 추가, 배송가능지역별)</span></td>
			<td>추가배송비 : 무료~2,500원 <span class="desc">(구매금액/지역별)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<!-- 구매무게 :: END -->
		</tbody>
		</table>

		<div class="item-title">
			매장수령 <button type="button" onclick="sample_pop('3')" class="resp_btn size_S">샘플보기</button>
		</div>

		<table class="table_basic v7 thl">
			<colgroup><col width="15%"/><col /></colgroup>		
		<tr>
			<th>구분</th>
			<th>수령매장안내</th>
		</tr>
		<tr>
			<th>무료 + 지역</th>
			<td>
				<select style="width:250px;">
					<option>파리-몽주약국 (재고 : 39개)</option>
				</select>
			</td>
		</tr>
		</table>
	</div>

	<div id="lang_EN" class="lang_area hide">
		<div class="title_dvs">
			<div class="item-title">
				택배, 직접배송, 퀵서비스, 화물배송, 직접입력 <button type="button" onclick="sample_pop('1')" class="resp_btn size_S">샘플보기</button>
			</div>
			<div class="r_dvs">※ 해외배송일 때는 '지역'→'국가'로 대체됩니다.</div>
		</div>
		<table class="table_basic v8 thl tdc">
		<colgroup>
			<col width="160px" />
			<col width="150px" />
			<col width="270px" />
			<col width="270px" />
			<col width="" />
			<col width="" />
		</colgroup>
		<thead>
		<tr>
			<th class="center" colspan="2">배송비 산출기준별 예시</th>
			<th class="center">기본 배송비</th>
			<th class="center">추가 배송비</th>
			<th class="center">희망배송일</th>
			<th class="center">예약판매기간</th>
		</tr>
		</thead>

		<tbody>
		<tr>
			<th>무료</th>
			<td>&nbsp;</td>
			<td>Free Shipping</td>
			<td class="center">해당없음</td>
			<td>
				Hopeful Delivery Date : 03, January (Today) available delivery
				<br/>
				<span style="color:#00B0F0;">[available delivery]</span>
			</td>
			<td>Subscription sales : 03, January In-order delivery</td>
		</tr>
		<tr>
			<th>무료+지역</th>
			<td>&nbsp;</td>
			<td>Free Shipping <span class="desc">(by shipping available regional)</span></td>
			<td class="center">해당없음</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>

		<tr>
			<th>고정</th>
			<td>&nbsp;</td>
			<td class="top-line">2,500won</td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>고정+지역</th>
			<td>&nbsp;</td>
			<td>Free Shipping-3,000won <span class="desc">(by shipping available regional)</span></td>
			<td>Additional Charges : Free Shipping-2,500won <span class="desc">(by regional)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<!-- 구매금액 :: START -->
		<tr>
			<th>구매금액(구간입력)</th>
			<td>구간입력 2개</td>
			<td class="top-line">2,500won <span class="desc">(30,000won and more, Free Shipping)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>Free Shipping~2,500won <span class="desc">(by purchase price)</span></td>
			<td class="center">해당없음</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>구매금액(구간입력)+지역</th>
			<td>구간입력 2개</td>
			<td>2,500won <span class="desc">(30,000won and more, Free Shipping, by shipping available regional)</span></td>
			<td>Additional Charges : Free Shipping-2,500won <span class="desc">(by purchase price/by regional)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>Free Shipping-2,500won <span class="desc">(by purchase price/by shipping available regional)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>

		<tr>
			<th>구매금액(구간반복)</th>
			<td>구간반복</td>
			<td class="top-line">2,500won<br/><span class="desc">(30,000won and more, per 5,000won, 1,000won plus)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>구매금액(구간반복)+지역</th>
			<td>구간반복</td>
			<td>2,500won<br/><span class="desc">(30,000won and more, per 5,000won, 1,000won each plus, by shipping available regional)</span></td>
			<td>Additional Charges : Free Shipping-2,500won <span class="desc">(by purchase price/by regional)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<!-- 구매금액 :: END -->

		<!-- 구매수량 :: START -->
		<tr>
			<th>구매수량(구간입력)</th>
			<td>구간입력 2개</td>
			<td class="top-line">2,500won <span class="desc">(100 and more, 5,000won)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>Free Shipping-2,500won <span class="desc">(by quantity)</span></td>
			<td class="center">해당없음</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>구매수량(구간입력)+지역</th>
			<td>구간입력 2개</td>
			<td>2,500won <span class="desc">(100 and more, 5,000won, by shipping available regional)</span></td>
			<td>Additional Charges : Free Shipping-2,500won <span class="desc">(by quantity/by regional)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>Free Shipping-2,500won <span class="desc">(by quantity/by shipping available regional)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>

		<tr>
			<th>구매수량(구간반복)</th>
			<td>구간반복</td>
			<td class="top-line">2,500won<br/><span class="desc">(100 and more, per 50, 1,000won each plus)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>구매수량(구간반복)+지역</th>
			<td>구간반복</td>
			<td>2,500won<br/><span class="desc">(100 and more, per 50, 1,000won each plus, by shipping available regional)</span></td>
			<td>Additional Charges : Free Shipping-2,500won <span class="desc">(by quantity/by regional)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<!-- 구매수량 :: END -->

		<!-- 구매무게 :: START -->
		<tr>
			<th>구매무게(구간입력)</th>
			<td>구간입력 2개</td>
			<td class="top-line">2,500won <span class="desc">(5kg and more, 5,000won)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>Free Shipping-2,500won <span class="desc">(by weight)</span></td>
			<td class="center">해당없음</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>구매무게(구간입력)+지역</th>
			<td>구간입력 2개</td>
			<td>2,500won <span class="desc">(5kg and more, 5,000won, by shipping available regional)</span></td>
			<td>Additional Charges : Free Shipping-2,500won <span class="desc">(by weight/by regional)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>Free Shipping-2,500won <span class="desc">(by weight/by shipping available regional)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>

		<tr>
			<th>구매무게(구간반복)</th>
			<td>구간반복</td>
			<td class="top-line">2,500won<br/><span class="desc">(5kg and more, per 3kg, 1,000won each plus)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>구매무게(구간반복)+지역</th>
			<td>구간반복</td>
			<td>2,500won<br/><span class="desc">(5kg and more, per 3kg, 1,000won each plus, by shipping available regional)</span></td>
			<td>Additional Charges : Free Shipping-2,500won <span class="desc">(by weight/by regional)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<!-- 구매무게 :: END -->
		</tbody>
		</table>

		<div class="item-title">
			매장수령<button type="button" onclick="sample_pop('3')" class="resp_btn size_S">샘플보기</button>			
		</div>
		<table class="table_basic v7 thl">
			<colgroup><col width="15%"/><col /></colgroup>		
		<tr>
			<th>구분</th>
			<th>수령매장안내</th>
		</tr>
		<tr>
			<th>무료 + 지역</th>
			<td>
				<select style="width:250px;">
					<option>Paris-Monge Parapharmacy (In Stock : 39 Qty)</option>
				</select>
			</td>
		</tr>
		</table>
	</div>

	<div id="lang_CN" class="lang_area hide">
		<div class="title_dvs">
			<div class="item-title">
				택배, 직접배송, 퀵서비스, 화물배송, 직접입력 <button type="button" onclick="sample_pop('1')" class="resp_btn size_S">샘플보기</button>
			</div>
			<div class="r_dvs">※ 해외배송일 때는 '지역'→'국가'로 대체됩니다.</div>
		</div>
		<table class="table_basic v8 thl tdc">
		<colgroup>
			<col width="160px" />
			<col width="150px" />
			<col width="270px" />
			<col width="270px" />
			<col width="" />
			<col width="" />
		</colgroup>
		<thead>
		<tr>
			<th class="center" colspan="2">배송비 산출기준별 예시</th>
			<th class="center">기본 배송비</th>
			<th class="center">추가 배송비</th>
			<th class="center">희망배송일</th>
			<th class="center">예약판매기간</th>
		</tr>
		</thead>

		<tbody>
		<tr>
			<th>무료</th>
			<td>&nbsp;</td>
			<td>免费配送</td>
			<td class="center">해당없음</td>
			<td>
				希望配送日 : 1月3日 (今天) 配送可以'<br/>
				<span style="color:#00B0F0;">[배송가능일]</span> 선택사항
			</td>
			<td>预约销售: 1月3日  按顺序配送</td>
		</tr>
		<tr>
			<th>무료+지역</th>
			<td>&nbsp;</td>
			<td>免费配送 <span class="desc">(可按地区分类的地区l)</span></td>
			<td class="center">해당없음</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>

		<tr>
			<th>고정</th>
			<td>&nbsp;</td>
			<td class="top-line">2,500&#x20a9;</td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>고정+지역</th>
			<td>&nbsp;</td>
			<td>免费配送-3,000&#x20a9; <span class="desc">(可按地区分类的地区)</span></td>
			<td>添加 : 免费配送'-2,500&#x20a9; <span class="desc">(按地域划分的地区)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<!-- 구매금액 :: START -->
		<tr>
			<th>구매금액(구간입력)</th>
			<td>구간입력 2개</td>
			<td class="top-line">2,500&#x20a9; <span class="desc">(30,000&#x20a9; 每 免费配送')</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>免费配送'~2,500&#x20a9; <span class="desc">(按购买金额计算)</span></td>
			<td class="center">해당없음</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>구매금액(구간입력)+지역</th>
			<td>구간입력 2개</td>
			<td>2,500&#x20a9; <span class="desc">(30,000&#x20a9; 每 免费配送', 可按地区分类的地区)</span></td>
			<td>添加 : 免费配送'-2,500&#x20a9; <span class="desc">(按购买金额计算/按地域划分的地区)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>免费配送'-2,500&#x20a9; <span class="desc">(按购买金额计算/可按地区分类的地区)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>

		<tr>
			<th>구매금액(구간반복)</th>
			<td>구간반복</td>
			<td class="top-line">2,500&#x20a9;<br/><span class="desc">(30,000&#x20a9; 每 5,000&#x20a9;, 1,000&#x20a9; 添加)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>구매금액(구간반복)+지역</th>
			<td>구간반복</td>
			<td>2,500&#x20a9;<br/><span class="desc">(30,000&#x20a9; 每 5,000&#x20a9;, 1,000&#x20a9; 添加, 可按地区分类的地区)</span></td>
			<td>添加 : 免费配送'-2,500&#x20a9; <span class="desc">(按购买金额计算/按地域划分的地区)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<!-- 구매금액 :: END -->

		<!-- 구매수량 :: START -->
		<tr>
			<th>구매수량(구간입력)</th>
			<td>구간입력 2개</td>
			<td class="top-line">2,500&#x20a9; <span class="desc">(100 每 5,000&#x20a9;)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>免费配送'-2,500&#x20a9; <span class="desc">(按购买数量)</span></td>
			<td class="center">해당없음</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>구매수량(구간입력)+지역</th>
			<td>구간입력 2개</td>
			<td>2,500&#x20a9; <span class="desc">(100 每 5,000&#x20a9;, 可按地区分类的地区)</span></td>
			<td>添加 : 免费配送'-2,500&#x20a9; <span class="desc">(按购买数量/按地域划分的地区)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>免费配送'-2,500&#x20a9; <span class="desc">(按购买数量/可按地区分类的地区)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>

		<tr>
			<th>구매수량(구간반복)</th>
			<td>구간반복</td>
			<td class="top-line">2,500&#x20a9;<br/><span class="desc">(100 更多 50 每 1,000&#x20a9; 添加)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>구매수량(구간반복)+지역</th>
			<td>구간반복</td>
			<td>2,500&#x20a9;<br/><span class="desc">(100 更多 50 每 1,000&#x20a9; 添加, 可按地区分类的地区)</span></td>
			<td>添加 : 免费配送-2,500&#x20a9; <span class="desc">(按购买数量/按地域划分的地区)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<!-- 구매수량 :: END -->

		<!-- 구매무게 :: START -->
		<tr>
			<th>구매무게(구간입력)</th>
			<td>구간입력 2개</td>
			<td class="top-line">2,500&#x20a9; <span class="desc">(5Kg 更多 5,000&#x20a9;)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>免费配送~2,500&#x20a9; <span class="desc">(按购买力分类)</span></td>
			<td class="center">해당없음</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>구매무게(구간입력)+지역</th>
			<td>구간입력 2개</td>
			<td>2,500&#x20a9; <span class="desc">(5Kg 更多 5,000&#x20a9;, 可按地区分类的地区)</span></td>
			<td>添加 : 免费配送-2,500&#x20a9; <span class="desc">(购买重量/按地域划分的地区)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>구간입력 3개 이상</td>
			<td>免费配送-2,500&#x20a9; <span class="desc">(购买重量/可按地区分类的地区)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>

		<tr>
			<th>구매무게(구간반복)</th>
			<td>구간반복</td>
			<td class="top-line">2,500&#x20a9;<br/><span class="desc">(5Kg 更多 3Kg 每 1,000&#x20a9; 添加)</span></td>
			<td class="center top-line">해당없음</td>
			<td class="center top-line">상동</td>
			<td class="center top-line">상동</td>
		</tr>
		<tr>
			<th>구매무게(구간반복)+지역</th>
			<td>구간반복</td>
			<td>2,500&#x20a9;<br/><span class="desc">(5Kg 更多 3Kg 每 1,000&#x20a9; 添加, 可按地区分类的地区)</span></td>
			<td>添加 : 免费配送-2,500&#x20a9; <span class="desc">(购买金额/按地域划分的地区)</span></td>
			<td class="center">상동</td>
			<td class="center">상동</td>
		</tr>
		<!-- 구매무게 :: END -->
		</tbody>
		</table>

		<div class="item-title">
			매장수령 <button type="button" onclick="sample_pop('3')" class="resp_btn size_S">샘플보기</button>
		</div>

		<table class="table_basic v7 thl">
			<colgroup><col width="15%"/><col /></colgroup>		
		<tr>
			<th>구분</th>
			<th>수령매장안내</th>
		</tr>
		<tr>
			<th>무료 + 지역</th>
			<td>
				<select style="width:250px;">
					<option>파리-몽주약국 (股票 : 39 Qty)</option>
				</select>
			</td>
		</tr>
		</table>
	</div>
	<br/>
</div>

<div class="footer">
	<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
</div>

<div id="sample_popup_1" class="hide">
	<table class="sample-table_style" cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr>
			<td rowspan="5" valign="top" width="80px">배송</td>
			<td>
				<select><option>퀵서비스(착불)</option></select>
				<button type="button" class="btn_move small blue">자세히</button>
			</td>
		</tr>
		<tr><td>3,000원~5,500원 <span class="desc">(구매금액별)</span></td></tr>
		<tr><td>추가배송비 무료~2,500원 <span class="desc">(구매금액/지역별)</span></td></tr>
		<tr><td>희망배송일 당일 5,000원~8,000원 <span class="desc">(구매수량/지역별)</span></td></tr>
		<tr>
			<td>
				13시 이전 주문시 당일배송 
				<button type="button" class="btn_move small">희망배송일</button>
			</td>
		</tr>
		<tr>
			<td>해외배송</td>
			<td>
				<button type="button" class="btn_move small">해외 배송 가능 국가</button>
			</td>
		</tr>
	</table>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this)">닫기</button>
	</div>
</div>
<div id="sample_popup_2" class="hide">
	<table class="sample-table_style" cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr>
			<td rowspan="4" valign="top" width="80px">배송</td>
			<td>
				<select><option>우체국EMS(선불, 착불)</option></select>
				<button type="button" class="btn_move small blue">자세히</button>
			</td>
		</tr>
		<tr><td>7,000원 0.5kg이상 시 0.5kg당 900원씩 추가  국가별</td></tr>
		<tr><td>추가배송비   무료~5,000원   국가별</td></tr>
		<tr><td>2016-06-18부터 순차적으로 발송</td></tr>
		<tr>
			<td>해외배송</td>
			<td>
				<button type="button" class="btn_move small">해외 배송 가능 국가</button>
			</td>
		</tr>
	</table>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this)">닫기</button>
	</div>
</div>
<div id="sample_popup_3" class="hide">
	<table class="sample-table_style" cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr>
			<td rowspan="2" valign="top" width="80px">배송</td>
			<td>
				<select><option>매장픽업</option></select>
				<button type="button" class="btn_move small blue">자세히</button>
			</td>
		</tr>
		<tr>
			<td>
				<select><option>파리-몽주약국(재고 : 39개)</option></select>
			</td>
		</tr>
		<tr>
			<td>해외배송</td>
			<td>
				<button type="button" class="btn_move small">해외 배송 가능 국가</button>
			</td>
		</tr>
	</table>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this)">닫기</button>
	</div>
</div>