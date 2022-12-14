<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/order/_kakaopay.html 000023221 */  $this->include_("defaultScriptFunc");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="utf-8" lang="utf-8">
<head>
    <title>CNSPay 결제 샘플 페이지</title>
	<meta http-equiv="cache-control" content="no-cache"/>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="/app/javascript/jquery/jquery.min.1.6.4.js" charset="urf-8"></script>
	<script src="https://<?php echo $TPL_VAR["CnsPayDealRequestUrl"]?>/dlp/scripts/lib/easyXDM.min.js" type="text/javascript"></script>
	<script src="https://<?php echo $TPL_VAR["CnsPayDealRequestUrl"]?>/dlp/scripts/lib/json3.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://<?php echo $TPL_VAR["CNSPAY_WEB_SERVER_URL"]?>/js/dlp/client/kakaopayDlpConf.js" charset="utf-8"></script>
	<script type="text/javascript" src="https://<?php echo $TPL_VAR["CNSPAY_WEB_SERVER_URL"]?>/js/dlp/client/kakaopayDlp.min.js" charset="utf-8"></script>
	<script type="text/javascript">
		/**
		cnspay	를 통해 결제를 시작합니다.
		*/
		function cnspay() {
			if(document.getElementById("kakaopay").checked){
				// TO-DO : 가맹점에서 해줘야할 부분(TXN_ID)과 KaKaoPay DLP 호출 API
				// 결과코드가 00(정상처리되었습니다.)
				document.payForm.acceptCharset = "utf-8";
				if (document.payForm.canHaveHTML) { // detect IE
					document.charset = payForm.acceptCharset;
				}
				if(document.payForm.resultCode.value == '00') {
					// TO-DO : 가맹점에서 해줘야할 부분(TXN_ID)과 KaKaoPay DLP 호출 API
					parent.kakaoDlpCall('<?php echo $TPL_VAR["data_order"]["order_cellphone"]?>','<?php echo $TPL_VAR["pgVal"]["PR_TYPE"]?>');
					return;


					kakaopayDlp.setTxnId(document.payForm.txnId.value);
					kakaopayDlp.setChannelType('<?php echo $TPL_VAR["pgVal"]["PR_TYPE"]?>', 'TMS');
					kakaopayDlp.addRequestParams({ MOBILE_NUM : '<?php echo $TPL_VAR["data_order"]["order_cellphone"]?>'});
					kakaopayDlp.callDlp('kakaopay_layer', document.payForm, submitFunc);
				} else {
					alert('[RESULT_CODE] : ' + document.payForm.resultCode.value + '\n[RESULT_MSG] : ' + document.payForm.resultMsg.value);
				}
			}
		}

		function getTxnId() {
			cnspay();return;
			// form에 iframe 주소 세팅
			document.payForm.target = "txnIdGetterFrame";
			document.payForm.action = "/kakaopay/getTxnId";
			document.payForm.acceptCharset = "utf-8";
			if (document.payForm.canHaveHTML) { // detect IE
				document.charset = payForm.acceptCharset;
			}
			// post로 iframe 페이지 호출
			document.payForm.submit();

			// payForm의 타겟, action을 수정한다
			document.payForm.target = "";
			document.payForm.action = "/kakaopay/result";
			document.payForm.acceptCharset = "utf-8";
			if (document.payForm.canHaveHTML) { // detect IE
				document.charset = payForm.acceptCharset;
			}
			// getTxnId.jsp의 onload 이벤트를 통해 cnspay() 호출
		}

		// 인증 결과를 받을 함수
		var submitFunc = function cnspaySubmit(data){

			if(data.RESULT_CODE === '00') {

				// 부인방지토큰은 기본적으로 name="NON_REP_TOKEN"인 input박스에 들어가게 되며, 아래와 같은 방법으로 꺼내서 쓸 수도 있다.
				// 해당값은 가군인증을 위해 돌려주는 값으로서, 가맹점과 카카오페이 양측에서 저장하고 있어야 한다.
				// var temp = data.NON_REP_TOKEN;
				document.payForm.submit();

			} else if(data.RESLUT_CODE === 'KKP_SER_002') {
				// X버튼 눌렀을때의 이벤트 처리 코드 등록
				alert('[RESULT_CODE] : ' + data.RESULT_CODE + '\n[RESULT_MSG] : ' + data.RESULT_MSG);
			} else {
				alert('[RESULT_CODE] : ' + data.RESULT_CODE + '\n[RESULT_MSG] : ' + data.RESULT_MSG);
			}
		};

		// 인증 결과 처리 함수
		function kakaopay_complate(data){
			document.payForm.NON_REP_TOKEN.value = data.NON_REP_TOKEN;
			document.payForm.SPU.value = data.SPU;
			document.payForm.SPU_SIGN_TOKEN.value = data.SPU_SIGN_TOKEN;
			document.payForm.MPAY_PUB.value = data.MPAY_PUB;
			document.payForm.submit();
		}

		function installmentOnChange() {
			var paymentMethod = "CC"; //결제수단코드 - CC : 신용카드
			var possiCardNum = document.getElementById('possiCard').value;
			var fixedIntNum = document.getElementById('fixedInt').value;

			if( possiCardNum == '' || fixedIntNum == '' ){
				document.getElementById('noIntOpt').value = "";

			} else {
				// 무이자 할부를 선택함에 따라 넘겨줘야 하는 값(pdf 참조)
				document.getElementById('noIntOpt').value = paymentMethod + possiCardNum + fixedIntNum;

			}
		}

		function noIntYNonChange() {
			var noIntYN = document.getElementById('noIntYN').value;
			var paymentMethod = "CC"; //결제수단코드 - CC : 신용카드
			var possiCardNum = document.getElementById('possiCard').value;
			var fixedIntNum = document.getElementById('fixedInt').value;

			if( noIntYN == 'N' ){
				document.getElementById('noIntOpt').value = "";

			} else if( possiCardNum == '' || fixedIntNum == '' ){
				document.getElementById('noIntOpt').value = "";

			} else {
				// 무이자 할부를 선택함에 따라 넘겨줘야 하는 값(pdf 참조)
				document.getElementById('noIntOpt').value = paymentMethod + possiCardNum + fixedIntNum;

			}
		}

		function maxIntChange() {
			//최대할부개월에 따라서 고정할부개월의 선택 가능 범위 조정
		}
	</script>

	<!-- 카카오페이------------------------------------------------- -->
<?php echo defaultScriptFunc()?></head>

<body>
<div id="openDialogLayer" style="display: none">
	<div align="center" id="openDialogLayerMsg"></div>
</div>
<form name="payForm" id="payForm" action="../payment/kakaopay"  method="post" accept-charset="utf-8">

<div id="wrap">
	<div id="header">
		<h1>---CNSPay 결제 요청---</h1>
	</div>
	<div id="container">
		<div id="contents">
			<div class="bubble-box">결제 요청페이지 샘플입니다.</div>
			<div class="table-box">
				<table>
					<caption>정보를 기입하신 후 확인버튼을 눌러주십시오.</caption>
					<colgroup>
						<col class="nth-1" />
						<col class="nth-2" />
					</colgroup>
					<tbody>
					<tr class="nth-1">
						<th></th>
						<td><b>결제 필수 변수 목록</b></td>
					</tr>
					<tr>
						<th scope="row" class="require"><span class="dot">*</span>결제수단 :</th>
						<td>
							<span class="radio-wrap">
								<input type="checkbox" name="PayMethod" value="KAKAOPAY" id="kakaopay" checked="checked"/>
								<label for="kakaopay">카카오페이</label>
							</span>
						</td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>결제타입 :</label></th>
						<td>
							<select name="TransType">
								<option value='0' selected>일반결제</option>
								<!-- option value="1">에스크로</option-->
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>상품명 :</label></th>
						<td><input name="GoodsName" type="text" value="<?php echo $TPL_VAR["goods_name"]?>"/></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>상품가격 :</label></th>
						<td><input name="Amt" type="text" value="<?php echo $TPL_VAR["settleprice"]?>"/></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot"></span>공급가액 :</label></th>
						<td><input name="SUPPLY_AMT" type="text" value="<?php echo $TPL_VAR["total_tax_mny"]?>"/></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot"></span>부가가치세 :</label></th>
						<td><input name="GOODS_VAT" type="text" value="<?php echo $TPL_VAR["vat_mny"]?>"/></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot"></span>봉사료 :</label></th>
						<td><input name="SERVICE_AMT" type="text" value="0"/></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>상품갯수 :</label></th>
						<td><input type="text" name="GoodsCnt" value="<?php echo $TPL_VAR["data_order"]["total_ea"]?>"/></td>
					</tr>
					<!-- merchantTxnNumIn(= merchantTxnNum ) 으로 변경 -->
					<!-- tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>상품주문번호 :</label></th>
						<td><input name="Moid" type="text" value="mnoid1234567890"/></td>
					</tr -->
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>가맹점아이디 :</label></th>
						<td><input type="text" name="MID" value="<?php echo $TPL_VAR["mid"]?>" readonly style="background-color: #e2e2e2;" /></td>
					</tr>
					<tr>
						<th></th>
					</tr>
					<tr>
						<th></th>
						<td><b>TXN_ID를 가져오기 위해 사용하는 필수 변수 목록</b></td>
					</tr>

					<!-- MPay에서 TXN_ID를 가져오기 위해 사용하는 변수 목록 -->
					<!-- CN : 웹결제, N : 인앱결제 -->
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>CN : 웹결제, N : 인앱결제 :</label></th>
						<td><input type="text" id="CERTIFIED_FLAG" name="CERTIFIED_FLAG" readonly value="<?php echo $TPL_VAR["pgVal"]["CERTIFIED_FLAG"]?>" /></td>
					</tr>
					<!-- 인증구분 , 01 : key-in, ... 10 : kakaoPay -->
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>AuthFlg(카카오는 10으로 고정)</label></th>
						<td><input type="text" id="AuthFlg" name="AuthFlg" value="10" readonly style="background-color: #e2e2e2;" /></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>거래통화 :</label></th>
						<td><input type="text" name="currency" value="<?php echo $TPL_VAR["pgVal"]["CURRENCY"]?>" readonly style="background-color: #e2e2e2;" /></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>가맹점 암호화키 :</label></th>
						<td><input type="text" name="merchantEncKey" value="<?php echo $TPL_VAR["merchantEncKey"]?>" readonly style="background-color: #e2e2e2;" /></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>가맹점 해쉬키 :</label></th>
						<td><input type="text" name="merchantHashKey" value="<?php echo $TPL_VAR["merchantHashKey"]?>" readonly style="background-color: #e2e2e2;" /></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>TXN_ID 요청URL :</label></th>
						<td><input type="text" name="requestDealApproveUrl" value="https://<?php echo $TPL_VAR["targetUrl"]?><?php echo $TPL_VAR["msgName"]?>" readonly style="background-color: #e2e2e2;" /></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>결제요청타입 :</label></th>
						<td>
							<select name ="prType">
								<option value="WPM" <?php if($TPL_VAR["pgVal"]["PR_TYPE"]=='WPM'){?>selected<?php }?>>WEB 결제(PC결제)</option>
								<option value="MPM" <?php if($TPL_VAR["pgVal"]["PR_TYPE"]=='MPM'){?>selected<?php }?>>Mobile 결제</option>
							</select>
						</td>
					</tr>
					<tr>
						<!-- 채널타입설정 : 상세한 내용은 매뉴얼 참조  -->
						<th scope="row" class="require"><label for=""><span class="dot">*</span>채널타입 :</label></th>
						<td>
							<select name ="channelType">
								<!--오류가 나더라도 기본 4 선택 :: 원래는 비워놓음-->
								<option value="4">선택</option>
								<option value="2" <?php if($TPL_VAR["pgVal"]["channelType"]=='2'){?>selected="selected"<?php }?>>모바일웹결제</option>
								<option value="4" <?php if($TPL_VAR["pgVal"]["channelType"]=='4'){?>selected="selected"<?php }?>>TMS 방식</option>
							</select>
						</td>
					</tr>
					<tr>
						<!-- "merchantTxnNumIn"을 활용해서 TXN_ID와 MERCHANT_TXN_NUM을 불러오고, 해당값을 "merchantTxnNum" 에 setting 한다. -->
						<th scope="row" class="require"><label for=""><span class="dot">*</span>가맹점 거래번호 :</label></th>
						<td><input type="text" name="merchantTxnNumIn" id="merchantTxnNumIn" value="<?php echo $TPL_VAR["merchantTxnNumIn"]?>" /></td>
					</tr>
					<tr>
						<th></th>
					</tr>
					<tr>
						<th></th>
						<td><b>할부결제때 사용되는 선택변수 목록. 옳은 값들을 넣지 않으면 무이자를 사용하지 않는것으로 한다.</b></td>
					</tr>
					<!-- 결제가능카드설정 (결제가능한 수단 제한 가능) 금지카드설정X 공백 !!홈쇼핑에서 필수항목  -->
					<tr>
						<th scope="row" class="require"><label for="">카드선택 :</label></th>
						<td>
							<select class="require" id="possiCard" name="possiCard" onchange="javascript:installmentOnChange();">
								<option value="">나중에 선택하기</option>
								<option value="01">비씨</option>
								<option value="02">국민</option>
								<option value="03">외환</option>
								<option value="04">삼성</option>
								<option value="06">신한</option>
								<option value="07">현대</option>
								<option value="08">롯데</option>
								<option value="11">한미</option>
								<option value="11">씨티</option>
								<option value="12">NH채움(농협)</option>
								<option value="13">수협</option>
								<option value="13">신협</option>
								<option value="15">우리</option>
								<option value="16">하나SK</option>
								<option value="18">주택</option>
								<option value="19">조흥(강원)</option>
								<option value="21">광주</option>
								<option value="22">전북</option>
								<option value="23">제주</option>
								<option value="25">해외비자</option>
								<option value="26">해외마스터</option>
								<option value="27">해외다이너스</option>
								<option value="28">해외AMX</option>
								<option value="29">해외JCB</option>
								<option value="30">해외디스커버</option>
								<option value="34">은련</option>
							</select>
						</td>
					</tr>
					<!-- 고정할부개월 (00,01 (일시불), 02 ~24, 36 해당숫자로 할부가능) -->
					<tr>
						<th scope="row" class="require"><label for="">할부개월 :</label></th>
						<td>
							<select class="require" id="fixedInt" name="fixedInt" onchange="javascript:installmentOnChange();">
								<option value="">나중에 선택하기</option>
								<option value="00">일시불</option>
								<option value="01">1개월</option>
								<option value="02">2개월</option>
								<option value="03">3개월</option>
								<option value="04">4개월</option>
								<option value="05">5개월</option>
								<option value="06">6개월</option>
								<option value="07">7개월</option>
								<option value="08">8개월</option>
								<option value="09">9개월</option>
								<option value="10">10개월</option>
								<option value="11">11개월</option>
								<option value="12">12개월</option>
								<option value="13">13개월</option>
								<option value="14">14개월</option>
								<option value="15">15개월</option>
								<option value="16">16개월</option>
								<option value="17">17개월</option>
								<option value="18">18개월</option>
								<option value="19">19개월</option>
								<option value="20">20개월</option>
								<option value="21">21개월</option>
								<option value="22">22개월</option>
								<option value="23">23개월</option>
								<option value="24">24개월</option>
								<option value="36">36개월</option>
							</select>
						</td>
					</tr>
					<!-- 최대 할부개월 "":전체개월 선택가능 , ex) 06 : 1~6 개월 선택 가능 -->
					<tr>
						<th scope="row" class="require"><label for="">최대할부개월 :</label></th>
						<td>
							<!-- 만약 최대 할부 개월이 지정되어있다면 :: interestTerms 값에 따라 최대 지정-->
							<select class="require" id="maxInt" name="maxInt" onchange="javascript:maxIntChange();">
								<option value="">선택안함</option>
								<option value="01" <?php if($TPL_VAR["interestTerms"]=='0'){?>selected<?php }?>>1개월</option>
								<option value="02" <?php if($TPL_VAR["interestTerms"]=='2'){?>selected<?php }?>>2개월</option>
								<option value="03" <?php if($TPL_VAR["interestTerms"]=='3'){?>selected<?php }?>>3개월</option>
								<option value="04" <?php if($TPL_VAR["interestTerms"]=='4'){?>selected<?php }?>>4개월</option>
								<option value="05" <?php if($TPL_VAR["interestTerms"]=='5'){?>selected<?php }?>>5개월</option>
								<option value="06" <?php if($TPL_VAR["interestTerms"]=='6'){?>selected<?php }?>>6개월</option>
								<option value="07" <?php if($TPL_VAR["interestTerms"]=='7'){?>selected<?php }?>>7개월</option>
								<option value="08" <?php if($TPL_VAR["interestTerms"]=='8'){?>selected<?php }?>>8개월</option>
								<option value="09" <?php if($TPL_VAR["interestTerms"]=='9'){?>selected<?php }?>>9개월</option>
								<option value="10" <?php if($TPL_VAR["interestTerms"]=='10'){?>selected<?php }?>>10개월</option>
								<option value="11" <?php if($TPL_VAR["interestTerms"]=='11'){?>selected<?php }?>>11개월</option>
								<option value="12" <?php if($TPL_VAR["interestTerms"]=='12'){?>selected<?php }?>>12개월</option>
								<option value="13">13개월</option>
								<option value="14">14개월</option>
								<option value="15">15개월</option>
								<option value="16">16개월</option>
								<option value="17">17개월</option>
								<option value="18">18개월</option>
								<option value="19">19개월</option>
								<option value="20">20개월</option>
								<option value="21">21개월</option>
								<option value="22">22개월</option>
								<option value="23">23개월</option>
								<option value="24">24개월</option>
								<option value="36">36개월</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for="">무이자 사용여부 :</label></th>
						<td>
							<select class="require" id="noIntYN" name="noIntYN" onchange="javascript:noIntYNonChange();">
								<option value="">사용안함</option>
								<option value="Y" <?php if($TPL_VAR["pgVal"]["NOINTYN"]=='Y'){?>selected<?php }?>>사용</option>
							</select>
						</td>
					</tr>
					<!-- 결제수단코드 + 카드코드 + - + 무이자 개월 ex) CC01-02:03:05:09  -->
					<tr>
						<th scope="row" class="require"><label for="">무이자 옵션 :</label></th>
						<td><input type="text" name="noIntOpt" id="noIntOpt" value="<?php echo $TPL_VAR["pgVal"]["NOINTOPT"]?>"  readonly="readonly" style="background-color: #e2e2e2;"/></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for="">카드사포인트사용여부 :</label></th>
						<td>
							<!--퍼스트몰에서는 카드사 포인트 사용안함 고정-->
							<select name ="pointUseYn">
								<option value="N" selected>카드사 포인트 사용안함</option>
								<option value="Y">카드사 포인트 사용</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for="">금지카드설정 :</label></th>
						<td><input type="text" name="blockCard" value=""/></td>
					</tr>

					<tr>
						<th></th>
						<td><b>가맹점 내에서 활용할 기타 변수 목록</b></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for="">구매자 이메일 :</label></th>
						<td><input name="BuyerEmail" type="text" value="<?php echo $TPL_VAR["data_order"]["order_email"]?>"/></td>
					</tr>
					<tr>
						<th scope="row" class="require"><label for=""><span class="dot">*</span>구매자명 :</label></th>
						<td><input name="BuyerName" type="text" value="<?php echo $TPL_VAR["data_order"]["order_user_name"]?>"/></td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="btns">
				<a href="javascript:getTxnId();">결제 요청하기</a>
			</div>
		</div>
		<div class="footer">
			<ul>
				<li>- <span class="dot">*</span> 표 항목은 반드시 기입해주시길 바랍니다.</li>
				<li>- <strong>테스트 아이디로 결제된 건에대해서는 당일 오후 11:30분에 일괄 취소됩니다.</strong></li>
				<li>- 실제아이디 적용시 테스트아이디가 적용되지 않도록 각별한 주의를 부탁드립니다.</li>
			</ul>
		</div>
	</div>
</div>


<!-- MPay에서 TXN_ID 를 가져 올 때 함께 받아오는 변수 목록 -->
<div id="txnContents" ><!-- style="display:none" -->
	resultcod : <input id="resultCode" name="resultCode" type="text" value="<?php echo $TPL_VAR["resultCode"]?>"/><br/>
	resultmsg : <input id="resultMsg" name="resultMsg" type="text" value="<?php echo $TPL_VAR["resultMsg"]?>"/><br/>
	txnId : <input id="txnId" name="txnId" type="text" value="<?php echo $TPL_VAR["txnId"]?>"/><br/>
	merchantTxnNum(Moid) : <input id="merchantTxnNum" name="merchantTxnNum" type="text" value="<?php echo $TPL_VAR["merchantTxnNum"]?>"/><br/> <!-- Moid -->
	prDt : <input id="prDt" name="prDt" type="text" value="<?php echo $TPL_VAR["prDt"]?>"/><br/>
</div>
<br/>----------------------------------------------------------------------<br/>
<div id="dlpContents" ><!-- style="display:none" -->
	<!-- TODO : DLP창으로부터 받은 결과값을 SETTING 할 INPUT LIST -->
	SPU : <input type="text" name="SPU" value=""/><br/>
	SPU_SIGN_TOKEN : <input type="text" name="SPU_SIGN_TOKEN" value=""/><br/>
	MPAY_PUB : <input type="text" name="MPAY_PUB" value=""/><br/>
		<!-- 부인방지 토큰 / RESULT_CODE == 00일 때는 항상 들어오는 값. -->
		<!-- 해당값은 가군인증을 위해 돌려주는 값으로서, 가맹점과 카카오페이 양측에서 저장하고 있어야 한다. -->
		NON_REP_TOKEN : <input type="text" name="NON_REP_TOKEN" value=""/><br/>
</div>

<!-- TODO :  LayerPopup의 Target DIV 생성 -->
<div id="kakaopay_layer"  style="display: none"></div>

<input type="hidden" name="EdiDate" value="<?php echo $TPL_VAR["ediDate"]?>"/>
<input type="hidden" name="EncryptData" value="<?php echo $TPL_VAR["hash_String"]?>"/>

</form>
<iframe name="txnIdGetterFrame" id="txnIdGetterFrame" action="" src="" border="1"  width="100%" height="500"></iframe>
</body>

<script>cnspay();</script>
</html>