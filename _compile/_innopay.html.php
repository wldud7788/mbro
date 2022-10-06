<?php /* Template_ 2.2.6 2021/08/25 10:31:40 /www/music_brother_firstmall_kr/order/_innopay.html 000008401 */  $this->include_("defaultScriptFunc");?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>이노페이</title>

    <!-- InnoPay 결제연동 스크립트(필수) -->
    <!--<script type="text/javascript" src="https://pg.innopay.co.kr/ipay/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="https://pg.innopay.co.kr/ipay/js/innopay-2.0.js" charset="utf-8"></script>-->

    <script type="javascript">
        document.write('<script type="text/javascript" src="https://pg.innopay.co.kr/ipay/js/innopay-2.0.js"><\/script>');
        document.write('<script type="text/javascript" src="https://pg.innopay.co.kr/ipay/js/jquery-2.1.4.min.js"  charset="utf-8"><\/script>');
    </script>
    <script language=javascript src="https://pg.innopay.co.kr/ipay/js/innopay-2.0.js"></script>
    <script language=javascript src="https://pg.innopay.co.kr/ipay/js/jquery-2.1.4.min.js" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            innopay.goPay({
                PayMethod: 'CARD',		// 결제수단(CARD,BANK,VBANK,CARS,CSMS,DSMS,EPAY,EBANK)
                MID: 'pgmusicbrm',							// 가맹점 MID
                MerchantKey:document.getElementById('MerchantKey').value,	// 가맹점 라이센스키
                GoodsName:document.getElementById('GoodsName').value,		// 상품명
                Amt:document.getElementById('Amt').value,							// 결제금액(과세)
                BuyerName:document.getElementById('BuyerName').value,		// 고객명
                BuyerTel:document.getElementById('BuyerTel').value,				// 고객전화번호
                BuyerEmail:document.getElementById('BuyerEmail').value,			// 고객이메일
                ResultYN:'Y',				// 결제결과창 출력유뮤
                Moid:document.getElementById('Moid').value,			// 가맹점에서 생성한 주문번호 셋팅
                //// 선택 파라미터
                ReturnURL:document.getElementById('ReturnURL').value,			// 결제결과 전송 URL(없는 경우 아래 innopay_result 함수에 결제결과가 전송됨)
                Currency:''										// 통화코드가 원화가 아닌 경우만 사용(KRW/USD)
            });
            $("html").removeClass("hidden");
            $("body").removeClass("hidden")
        });


        function innopay_result(data){
            var a = JSON.stringify(data);
            // Sample
            var mid = data.MID;					// 가맹점 MID
            var tid = data.TID;					// 거래고유번호
            var amt = data.Amt;					// 금액
            var moid = data.MOID;				// 주문번호
            var authdate = data.AuthDate;		// 승인일자
            var authcode = data.AuthCode;		// 승인번호
            var resultcode = data.ResultCode;	// 결과코드(PG)
            var resultmsg = data.ResultMsg;		// 결과메세지(PG)
            var errorcode = data.ErrorCode;		// 에러코드(상위기관)
            var errormsg = data.ErrorMsg;		// 에러메세지(상위기관)
            var EPayCl   = data.EPayCl;
            alert("["+resultcode+"]"+resultmsg);
        }
    </script>
<?php echo defaultScriptFunc()?></head>
<body>
    <form id="frm" name="frm">
        <table>
            <caption>쇼핑몰 결제요청 폼</caption>
            <tbody>
            <tr>
                <td class="title" class="title"><div><b>결제수단</b></div></td>
                <td>
                    <div>
                        <input type="text" name="PayMethod" value="CARD" style="width:40%;">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="title"><div><b>상점 MID</b></div></td>
                <td class=''>
                    <div>
                        <input type="text" name="MID" value="pgmusicbrm" style="width:40%;"> (발급받은 상점MID를 입력)
                        <!-- <input type="text" name="MID" value="i00000001m" style="width:40%;"> (발급받은 상점MID를 입력) -->
                    </div>
                </td>
            </tr>
            <tr>
                <td class="title"><div><b>상점 라이센스키</b></div></td>
                <td class=''>
                    <div>
                        <input type="text" style="width:100%;" id="MerchantKey" name="MerchantKey" value="9bqHRG9dywEx3NnZkWZAvewrpNVwLncn5T8kXyy3ekZp09sNoq4wtiriJe8suuYS3qx0r3dY9IsA7USJSXcJBw=="> <!-- 발급된 가맹점키 -->
                        <!-- <input type="text" style="width:100%;" name="MerchantKey" value="TEST"> --> <!-- 발급된 가맹점키 -->
                    </div>
                </td>
            </tr>
            <tr>
                <td class="title" class="title"><div><b>상품명</b></div></td>
                <td>
                    <div>
                        <input type="text" id="GoodsName" value="개발팀테스트상품" placeholder="">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="title"><div><b>(테스트)상품가격</b></div></td>
                <td>
                    <div>
                        <input type="text" id="Amt" name="Amt" value="<?php echo $TPL_VAR["settle_price"]?>" onKeyUp="javascript:numOnly(this,document.frm,false);">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="title"><div><b>구매자명</b></div></td>
                <td>
                    <div>
                        <input type="text" id="BuyerName" name="BuyerName" value="<?php echo $TPL_VAR["order_user_name"]?>" placeholder="">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="title"><div><b>구매자 연락처</b></div></td>
                <td>
                    <div>
                        <input type="text" id="BuyerTel" name="BuyerTel" value="<?php echo $TPL_VAR["order_cellphone"]?>" placeholder="">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="title"><div><b>구매자 이메일 주소</b></div></td>
                <td>
                    <div>
                        <input type="text" id="BuyerEmail" name="BuyerEmail" value="<?php echo $TPL_VAR["order_email"]?>" placeholder="">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="title"><div><b>주문번호</b></div></td>
                <td>
                    <div>
                        <input type="text" id="Moid" name="Moid" value="<?php echo $TPL_VAR["order_seq"]?>" placeholder="">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="title"><div><b>PG결제결과창 유무</b></div></td>
                <td class="">
                    <div>
                        <input type="text" id="ResultYN"  name="ResultYN" value="Y" style="width:8%;"> (N:결제결과창 없음, 가맹점 ReturnURL로 결과전송)
                    </div>
                </td>
            </tr>
            <tr height="10">
                <td></td><td></td>
            </tr>
            <!-- 선택 파라미터 -->
            <tr>
                <td class="title"><div>결제결과전송 URL</div></td>
                <td>
                    <div>
                        <input type="text" id="ReturnURL" name="ReturnURL" value="https://musicbroshop.com/payment/innopay" placeholder="">
                        <br> (ReturnURL 이 없는 경우 현재페이지로 결제결과가 전송됩니다)
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div align="center" style="height:50px;">
            <input type="button" class="btn_submit" name="btn_pay" value="결제요청" >
        </div>
        <div style="height:10px;"></div>
    </form>
    <!-- End Form -->
</body>
</html>