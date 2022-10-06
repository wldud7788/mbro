<?php /* Template_ 2.2.6 2021/06/10 10:58:14 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/order/innopay_order.html 000005804 */  $this->include_("defaultScriptFunc");?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <meta http-equiv="Pragma" content="no-cache"/>

    <script src="https://pg.innopay.co.kr/ipay/js/jquery-2.1.4.min.js" async defer></script>
    <script src="https://pg.innopay.co.kr/ipay/js/innopay-2.0.js" charset="utf-8" async defer></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            // 결제요청 함수
            innopay.goPay({
                PayMethod: 'CARD',
                MID: document.getElementById('MID').value,
                MerchantKey: document.getElementById('MerchantKey').value,
                GoodsName: document.getElementById('GoodsName').value,
                Amt: document.getElementById('Amt').value,
                BuyerName: document.getElementById('BuyerName').value,
                BuyerTel: document.getElementById('BuyerTel').value,
                BuyerEmail: document.getElementById('BuyerEmail').value,
                ResultYN: document.getElementById('ResultYN').value,
                Moid: 'testpay01m01234567890',
                ReturnURL: document.getElementById('ReturnURL').value,
                Currency: ''
            });
        });
    </script>
<?php echo defaultScriptFunc()?></head>
<body>
<form action="" name="Form" id="frm" method="post">
    <table>
        <caption>쇼핑몰 결제요청 폼</caption>
        <tbody>
        <tr>
            <td className="title" className="title">
                <div><b>결제수단</b></div>
            </td>
            <input type="text" id="PayMethod" name="PayMethod" value="testpay01m">
            </td>
        </tr>
        <tr>
            <td className="title">
                <div><b>상점 MID</b></div>
            </td>
            <td className=''>
                <div>
                    <input type="text" id="MID" name="MID" value="testpay01m" style="width:40%;"> (발급받은 상점MID를 입력)
                    <!-- <input type="text" name="MID" value="i00000001m" style="width:40%;"> (발급받은 상점MID를 입력) -->
                </div>
            </td>
        </tr>
        <tr>
            <td className="title">
                <div><b>상점 라이센스키</b></div>
            </td>
            <td className=''>
                <div>
                    <input type="text" id="MerchantKey" style="width:100%;" name="MerchantKey"
                           value="Ma29gyAFhvv/+e4/AHpV6pISQIvSKziLIbrNoXPbRS5nfTx2DOs8OJve+NzwyoaQ8p9Uy1AN4S1I0Um5v7oNUg==">
                    <!-- 발급된 가맹점키 -->
                    <!-- <input type="text" style="width:100%;" name="MerchantKey" value="TEST"> --> <!-- 발급된 가맹점키 -->
                </div>
            </td>
        </tr>
        <tr>
            <td className="title" className="title">
                <div><b>상품명</b></div>
            </td>
            <td>
                <div>
                    <input type="text" id="GoodsName" name="GoodsName" value="테스트상품" placeholder="">
                </div>
            </td>
        </tr>
        <tr>
            <td className="title">
                <div><b>상품가격</b></div>
            </td>
            <td>
                <div>
                    <input type="text" id="Amt" name="Amt" value="1000"
                           onKeyUp="javascript:numOnly(this,document.frm,false);">
                </div>
            </td>
        </tr>
        <tr>
            <td className="title">
                <div><b>구매자명</b></div>
            </td>
            <td>
                <div>
                    <input type="text" id="BuyerName" name="BuyerName" value="mn_홍길동" placeholder="">
                </div>
            </td>
        </tr>
        <tr>
            <td className="title">
                <div><b>구매자 연락처</b></div>
            </td>
            <td>
                <div>
                    <input type="text" id="BuyerTel" name="BuyerTel" value="012345678" placeholder="">
                </div>
            </td>
        </tr>
        <tr>
            <td className="title">
                <div><b>구매자 이메일 주소</b></div>
            </td>
            <td>
                <div>
                    <input type="text" id="BuyerEmail" name="BuyerEmail" value="test@test.com" placeholder="">
                </div>
            </td>
        </tr>
        <tr>
            <td className="title">
                <div><b>PG결제결과창 유무</b></div>
            </td>
            <td className="">
                <div>
                    <input type="text" id="ResultYN" name="ResultYN" value="Y" style="width:8%;"> (N:결제결과창 없음, 가맹점
                    ReturnURL로 결과전송)
                </div>
            </td>
        </tr>
        <tr height="10">
            <td></td>
            <td></td>
        </tr>
        <!-- 선택 파라미터 -->
        <tr>
            <td className="title">
                <div>결제결과전송 URL</div>
            </td>
            <td>
                <div>
                    <input type="text" id="ReturnURL" name="ReturnURL"
                           value="https://pg.innopay.co.kr/ipay/returnPay.jsp" placeholder="">
                    <br> (ReturnURL 이 없는 경우 현재페이지로 결제결과가 전송됩니다)
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <div style="height:10px;"></div>
</form>
</body>
</html>