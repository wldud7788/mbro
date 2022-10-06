<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/barcode/_barcode_info_popup.html 000008803 */ ?>
<!-- 바코드 정보 입력방법 팝업 -->
<script type='text/javascript'>
$(document).ready(function(){
	//바코드 정보 입력방법
	$("#barcode_info").click(function(){
		openDialog("바코드 정보 입력방법", "barcode_regist_info", {"width":"1000","height":"630","show" : "fade","hide" : "fade"});
	});
});
</script>
<style>
	/*바코드 정보 입력방법 안내 팝업*/
	#barcode_regist_info h2 { font-size: 13pt }
	#barcode_regist_info .cont { padding: 10px; margin-bottom: 30px }
	#barcode_regist_info .cont th { background: #eaeaea }
	#barcode_regist_info .cont .tb-wrap { margin: 15px 0px; height: 250px; }
	#barcode_regist_info .cont .tb-wrap .tb-long  { width: 920px; min-height: 100%; border-collapse: collapse;  }
	#barcode_regist_info .cont .tb-wrap .tb-long  th,
	#barcode_regist_info .cont .tb-wrap .tb-long  td { border: 1px solid #dadada; text-align: center; }
	#barcode_regist_info .cont .tb-wrap .tb-small { width: 150px; min-height: 100%; border-collapse: collapse;  }
	#barcode_regist_info .cont .tb-wrap .tb-small th,
	#barcode_regist_info .cont .tb-wrap .tb-small td { border: 1px solid #dadada; text-align: center; }

	.arrow { margin-top: 100px }
	.fleft { float: left; }
	.clear { clear: both }
	.inp { padding: 3px 12px; border: 1px solid #dadada }
</style>
<div id="barcode_regist_info" class="hide">
	<h2>가정. 아래 상품에 대하여 바코드를 등록한다고 가정</h2>
	<div class="cont">
		<img src="/admin/skin/default/images/common/barcode_sample01.gif"/>
	</div>
	<h2>1. 바코드 정보 입력 규칙</h2>
	<div class="cont">
		<div class="tb-wrap">
			<table class="tb-long">
				<tr>
					<th rowspan="2">바코드 종류</th>
					<th colspan="5">규칙</th>
				</tr>
				<tr>
					<th>숫자</th>
					<th>영문</th>
					<th>특수문자</th>
					<th>길이제한</th>
					<th>기타</th>
				</tr>
				<tr>
					<th>Code39</th>
					<td>가능</td>
					<td>대문자</td>
					<td>- SPACE $ / %</td>
					<td>없음</td>
					<td></td>
				</tr>
				<tr>
					<th>Code128-A</th>
					<td>가능</td>
					<td>대문자</td>
					<td>- SPACE $ / %</td>
					<td>없음</td>
					<td></td>
				</tr>
				<tr>
					<th>Code128-B</th>
					<td>가능</td>
					<td>대문자</td>
					<td>- SPACE $ / %</td>
					<td>없음</td>
					<td></td>
				</tr>
				<tr>
					<th>Code128-C</th>
					<td>가능. 단, 짝수 개의 숫자 입력</td>
					<td>불가</td>
					<td>불가</td>
					<td>없음</td>
					<td></td>
				</tr>
				<tr>
					<th>ISBN</th>
					<td>가능</td>
					<td>불가</td>
					<td>불가</td>
					<td>13자리</td>
					<td>978로 시작 (마지막 번호는 유효성 번호이며, 틀린 번호이면 자동치환)</td>
				</tr>
			</table>
		</div>
	</div>

	<h2>2. 바코드 정보 입력 방법</h2>

	<h2>방법 1. 관리자 환경에서 상품 등록/수정 시 입력하는 방법</h2>
	<div class="cont">
		<p>
			상품기본코드 입력란에 <span class="red">546404-</span>와 같이 입력합니다.<br/>
			상품옵션코드 입력란에 아래와 같이 입력합니다. 최종 바코드는 기본코드와 옵션코드가 조합됩니다.
		</p>
		<div class="tb-wrap">
			<table class="tb-small fleft">
				<tr> <th colspan="2">옵션</th></tr>
				<tr> <th>색상</th> <th>사이즈</th> </tr>
				<tr> <td>그레이<br/>063</td> <td>S<br/>SS</td> </tr>
				<tr> <td>그레이<br/>063</td> <td>M<br/>SM</td> </tr>
				<tr> <td>그레이<br/>063</td> <td>L<br/>SL</td> </tr>
				<tr> <td>화이트<br/>100</td> <td>S<br/>SS</td> </tr>
				<tr> <td>화이트<br/>100</td> <td>M<br/>SM</td> </tr>
				<tr> <td>화이트<br/>100</td> <td>L<br/>SL</td> </tr>
			</table>
			<div class="fleft">
				<img class="arrow" src="/admin/skin/default/images/common/barcode_sample02.gif"/>
			</div>
			<table class="tb-small">
				<tr> <th colspan="2">바코드(상품코드)</th></tr>
				<tr> <td>546404-063SS</td></tr>
				<tr> <td>546404-063SM</td></tr>
				<tr> <td>546404-063SL</td></tr>
				<tr> <td>546404-100SS</td></tr>
				<tr> <td>546404-100SM</td></tr>
				<tr> <td>546404-100SL</td></tr>
			</table>
		</div>

		<p class="clear">
			또는 상품기본코드 입력란에 입력하지 않습니다.<br/>
			상품옵션코드 입력란에 아래와 같이 입력합니다. 최종바코드는 기종과 동일한 결과입니다.
		</p>

		<div class="tb-wrap">
			<table class="tb-small fleft">
				<tr> <th colspan="2">옵션</th></tr>
				<tr> <th>색상</th> <th>사이즈</th> </tr>
				<tr> <td>그레이<br/>546404-063</td> <td>S<br/>SS</td> </tr>
				<tr> <td>그레이<br/>546404-063</td> <td>M<br/>SM</td> </tr>
				<tr> <td>그레이<br/>546404-063</td> <td>L<br/>SL</td> </tr>
				<tr> <td>화이트<br/>546404-100</td> <td>S<br/>SS</td> </tr>
				<tr> <td>화이트<br/>546404-100</td> <td>M<br/>SM</td> </tr>
				<tr> <td>화이트<br/>546404-100</td> <td>L<br/>SL</td> </tr>
			</table>
			<div class="fleft">
				<img class="arrow" src="/admin/skin/default/images/common/barcode_sample02.gif"/>
			</div>
			<table class="tb-small">
				<tr> <th colspan="2">바코드(상품코드)</th></tr>
				<tr> <td>546404-063SS</td></tr>
				<tr> <td>546404-063SM</td></tr>
				<tr> <td>546404-063SL</td></tr>
				<tr> <td>546404-100SS</td></tr>
				<tr> <td>546404-100SM</td></tr>
				<tr> <td>546404-100SL</td></tr>
			</table>
		</div>
	</div>
	<h2>방법 2. 상품을 엑셀 다운로드 후 입력하는 방법</h2>
	<div class="cont">
		<p>
			상품을 엑셀로 다운로드 받아 바코드 정보를 입력합니다.
		</p>
		<div class="tb-wrap">
			<table class="tb-long">
				<tr>
					<th colspan="2">바코드</th>
					<th rowspan="2">상품번호</th>
					<th rowspan="2">옵션번호</th>
					<th rowspan="2">상품명</th>
					<th rowspan="2">옵션명</th>
				</tr>
				<tr>
					<th>기본코드</th>
					<th>옵션코드</th>
				</tr>
				<tr> <td>546404-</td> <td>063SS</td> <td>1</td> <td>1</td> <td>티셔츠</td> <td>그레이/S</td> </tr>
				<tr> <td>546404-</td> <td>063SM</td> <td>1</td> <td>2</td> <td>티셔츠</td> <td>그레이/M</td> </tr>
				<tr> <td>546404-</td> <td>063SL</td> <td>1</td> <td>3</td> <td>티셔츠</td> <td>그레이/L</td> </tr>
				<tr> <td>546404-</td> <td>100SS</td> <td>1</td> <td>4</td> <td>티셔츠</td> <td>화이트/S</td> </tr>
				<tr> <td>546404-</td> <td>100SM</td> <td>1</td> <td>5</td> <td>티셔츠</td> <td>화이트/M</td> </tr>
				<tr> <td>546404-</td> <td>100SL</td> <td>1</td> <td>6</td> <td>티셔츠</td> <td>화이트/L</td> </tr>
			</table>
		</div>
	</div>
	<h2>방법 3. 관리자환경에서 일괄 입력하는 방법</h2>
	<div class="cont">
		<p>
			관리자환경에서 상품의 바코드 정보를 일괄 입력합니다.
		</p>
		<div class="tb-wrap">
			<table class="tb-long">
				<tr>
					<th colspan="2">바코드</th>
					<th rowspan="2">상품번호</th>
					<th rowspan="2">옵션번호</th>
					<th rowspan="2">상품명</th>
					<th rowspan="2">옵션명</th>
				</tr>
				<tr>
					<th>기본코드</th>
					<th>옵션코드</th>
				</tr>
				<tr> <td><span class="inp">546404-</span></td> <td><span class="inp">063SS</span></td> <td>1</td> <td>1</td> <td>티셔츠</td> <td>그레이/S</td> </tr>
				<tr> <td><span class="inp">546404-</span></td> <td><span class="inp">063SM</span></td> <td>1</td> <td>2</td> <td>티셔츠</td> <td>그레이/M</td> </tr>
				<tr> <td><span class="inp">546404-</span></td> <td><span class="inp">063SL</span></td> <td>1</td> <td>3</td> <td>티셔츠</td> <td>그레이/L</td> </tr>
				<tr> <td><span class="inp">546404-</span></td> <td><span class="inp">100SS</span></td> <td>1</td> <td>4</td> <td>티셔츠</td> <td>화이트/S</td> </tr>
				<tr> <td><span class="inp">546404-</span></td> <td><span class="inp">100SM</span></td> <td>1</td> <td>5</td> <td>티셔츠</td> <td>화이트/M</td> </tr>
				<tr> <td><span class="inp">546404-</span></td> <td><span class="inp">100SL</span></td> <td>1</td> <td>6</td> <td>티셔츠</td> <td>화이트/L</td> </tr>
			</table>
		</div>
	</div>
	<h2>방법 4. 정의된 코드로 바코드 입력 방법</h2>
	<div class="cont">
		<p>
			<a href='../setting/goods' class='link_blue_01'>상품 코드/정보</a>에서 상품 속성(브랜드, 색상, 사이즈 등)에 대한 코드를 등록합니다.<br/>
			미리 등록한 속성으로 상품 등록 시 바코드 정보가 자동 생성됩니다.
		</p>
	</div>
</div>