<?php /* Template_ 2.2.6 2021/06/09 14:26:59 /www/music_brother_firstmall_kr/order/_lg.html 000008220 */  $this->include_("defaultScriptFunc");?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-Control" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
<meta http-equiv="Pragma" content="no-cache"/>
<title>LG유플러스 eCredit서비스 결제</title>

<script language = 'javascript'>
<!--
/*
 * 상점결제 인증요청후 PAYKEY를 받아서 최종결제 요청.
 */
function doPay_ActiveX(){

    ret = xpay_check(document.getElementById('LGD_PAYINFO'), '<?php echo $TPL_VAR["CST_PLATFORM"]?>');

    if (ret=="00"){     //ActiveX 로딩 성공
        var LGD_RESPCODE        = dpop.getData('LGD_RESPCODE');       //결과코드
        var LGD_RESPMSG         = dpop.getData('LGD_RESPMSG');        //결과메세지

        if( "0000" == LGD_RESPCODE ) { //인증성공
            var LGD_PAYKEY      = dpop.getData('LGD_PAYKEY');         //LG유플러스 인증KEY
            var msg = "인증결과 : " + LGD_RESPMSG + "\n";
            msg += "LGD_PAYKEY : " + LGD_PAYKEY +"\n\n";
            document.getElementById('LGD_PAYKEY').value = LGD_PAYKEY;
            document.getElementById('LGD_PAYINFO').submit();
        } else { //인증실패
            alert("인증이 실패하였습니다. " + LGD_RESPMSG);
            parent.reverse_pay_button();
            /*
             * 인증실패 화면 처리
             */
        }
    } else {
<?php if($TPL_VAR["browser"]=="IE"){?>
        alert("LG U+ 전자결제를 위한 ActiveX Control이  설치되지 않았습니다.");
<?php }else{?>
		alert("LG U+ 전자결제를 위한 XPayPlugin 모듈이 설치되지 않았습니다123123."); 
		xpay_showInstall();
<?php }?>
        /** 인증실패 화면 처리 **/
       parent.reverse_pay_button();
    }
}

function isActiveXOK(){
	if(lgdacom_atx_flag == true){
    	document.getElementById('LGD_BUTTON1').style.display='none';
        document.getElementById('LGD_BUTTON2').style.display='';
	}else{
		document.getElementById('LGD_BUTTON1').style.display='';
        document.getElementById('LGD_BUTTON2').style.display='none';
	}
}

//-->
</script>

<?php echo defaultScriptFunc()?></head>
<body onload="isActiveXOK();">
<div id="LGD_ACTIVEX_DIV"/> <!-- ActiveX 설치 안내 Layer 입니다. 수정하지 마세요. -->
<form method="post" id="LGD_PAYINFO" action="../payment/lg">
<table>
    <tr>
        <td>구매자 이름 </td>
        <td><?php echo $TPL_VAR["LGD_BUYER"]?></td>
    </tr>
    <tr>
        <td>구매자 IP </td>
        <td><?php echo $TPL_VAR["LGD_BUYERIP"]?></td>
    </tr>
    <tr>
        <td>구매자 ID </td>
        <td><?php echo $TPL_VAR["LGD_BUYERID"]?></td>
    </tr>
    <tr>
        <td>상품정보 </td>
        <td><?php echo $TPL_VAR["LGD_PRODUCTINFO"]?></td>
    </tr>
    <tr>
        <td>결제금액 </td>
        <td><?php echo $TPL_VAR["LGD_AMOUNT"]?></td>
    </tr>
    <tr>
        <td>구매자 이메일 </td>
        <td><?php echo $TPL_VAR["LGD_BUYEREMAIL"]?></td>
    </tr>
    <tr>
        <td>주문번호 </td>
        <td><?php echo $TPL_VAR["LGD_OID"]?></td>
    </tr>
    <tr>
        <td colspan="2">* 추가 상세 결제요청 파라미터는 메뉴얼을 참조하시기 바랍니다.</td>
    </tr>
    <tr>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td colspan="2">
		<div id="LGD_BUTTON1">결제를 위한 모듈을 다운 중이거나, 모듈을 설치하지 않았습니다. </div>
		<div id="LGD_BUTTON2" style="display:none"><input type="button" value="인증요청" onclick="doPay_ActiveX();"/> </div>
        </td>
    </tr>
</table>
<br>
<br>
<?php if($TPL_VAR["payment"]=='card'){?>
<input type="hidden" name="LGD_CUSTOM_USABLEPAY" value="SC0010">
<?php }?>
<?php if($TPL_VAR["payment"]=='account'){?>
<input type="hidden" name="LGD_CUSTOM_USABLEPAY" value="SC0030">
<?php }?>
<?php if($TPL_VAR["payment"]=='virtual'){?>
<input type="hidden" name="LGD_CUSTOM_USABLEPAY" value="SC0040">
<?php }?>
<?php if($TPL_VAR["payment"]=='cellphone'){?>
<input type="hidden" name="LGD_CUSTOM_USABLEPAY" value="SC0060">
<?php }?>
<?php if($TPL_VAR["escorw"]){?>
<input type="hidden" name="LGD_ESCROW_USEYN" value="Y">
<?php }else{?>
<input type="hidden" name="LGD_ESCROW_USEYN" value="N">
<?php }?>
<input type="hidden" name="CST_PLATFORM"                value="<?php echo $TPL_VAR["CST_PLATFORM"]?>">                   <!-- 테스트, 서비스 구분 -->
<input type="hidden" name="CST_MID"                     value="<?php echo $TPL_VAR["CST_MID"]?>">                        <!-- 상점아이디 -->
<input type="hidden" name="LGD_MID"                     value="<?php echo $TPL_VAR["LGD_MID"]?>">                        <!-- 상점아이디 -->
<input type="hidden" name="LGD_OID"                     value="<?php echo $TPL_VAR["LGD_OID"]?>">                        <!-- 주문번호 -->
<input type="hidden" name="LGD_BUYER"                   value="<?php echo $TPL_VAR["LGD_BUYER"]?>">           			<!-- 구매자 -->
<input type="hidden" name="LGD_PRODUCTINFO"             value="<?php echo $TPL_VAR["LGD_PRODUCTINFO"]?>">     			<!-- 상품정보 -->
<input type="hidden" name="LGD_AMOUNT"                  value="<?php echo $TPL_VAR["LGD_AMOUNT"]?>">                     <!-- 결제금액 -->
<input type="hidden" name="LGD_BUYEREMAIL"              value="<?php echo $TPL_VAR["LGD_BUYEREMAIL"]?>">                 <!-- 구매자 이메일 -->
<input type="hidden" name="LGD_CUSTOM_SKIN"             value="<?php echo $TPL_VAR["LGD_CUSTOM_SKIN"]?>">                <!-- 결제창 SKIN -->
<input type="hidden" name="LGD_CUSTOM_PROCESSTYPE"      value="<?php echo $TPL_VAR["LGD_CUSTOM_PROCESSTYPE"]?>">         <!-- 트랜잭션 처리방식 -->
<input type="hidden" name="LGD_TIMESTAMP"               value="<?php echo $TPL_VAR["LGD_TIMESTAMP"]?>">                  <!-- 타임스탬프 -->
<input type="hidden" name="LGD_HASHDATA"                value="<?php echo $TPL_VAR["LGD_HASHDATA"]?>">                   <!-- MD5 해쉬암호값 -->
<input type="hidden" name="LGD_PAYKEY"                  id="LGD_PAYKEY">                                <!-- LG유플러스 PAYKEY(인증후 자동셋팅)-->
<input type="hidden" name="LGD_VERSION"         		value="PHP_XPay_1.0">							<!-- 버전정보 (삭제하지 마세요) -->
<input type="hidden" name="LGD_BUYERIP"                 value="<?php echo $TPL_VAR["LGD_BUYERIP"]?>">           			<!-- 구매자IP -->
<input type="hidden" name="LGD_BUYERID"                 value="<?php echo $TPL_VAR["LGD_BUYERID"]?>">           			<!-- 구매자ID -->
<!-- 가상계좌(무통장) 결제연동을 하시는 경우  할당/입금 결과를 통보받기 위해 반드시 LGD_CASNOTEURL 정보를 LG 텔레콤에 전송해야 합니다 . -->
<input type="hidden" name="LGD_CASNOTEURL"          	value="<?php echo $TPL_VAR["LGD_CASNOTEURL"]?>">					<!-- 가상계좌 NOTEURL -->

<?php if($TPL_VAR["payment"]=='account'||$TPL_VAR["payment"]=='virtual'){?>
<input type="hidden" name="LGD_CASHRECEIPTYN"          	value="N">									<!-- 결제창에서 현금영수증 입력폼 사용여부 -->
<?php }?>

<input type="hidden" name="LGD_TAXFREEAMOUNT"          	value="<?php echo $TPL_VAR["LGD_TAXFREEAMOUNT"]?>">					<!-- 비과세금액 -->
<input type="hidden" name="LGD_INSTALLRANGE"          	value="<?php echo $TPL_VAR["LGD_INSTALLRANGE"]?>">					<!-- 할부기간 -->

</form>
</body>

<?php if($TPL_VAR["browser"]=="etc"){?>
<script language="javascript" src="http<?php if($_SERVER["HTTPS"]=='on'){?>s<?php }?>://xpay.uplus.co.kr<?php if($TPL_VAR["CST_PLATFORM"]=='test'){?>:<?php if($_SERVER["HTTPS"]=='on'){?>7443<?php }else{?>7080<?php }?><?php }?>/xpay/js/xpay_ub_utf-8.js" type="text/javascript">
</script>
<?php }else{?>
<script language="javascript" src="http<?php if($_SERVER["HTTPS"]=='on'){?>s<?php }?>://xpay.lgdacom.net<?php if($TPL_VAR["CST_PLATFORM"]=='test'){?>:<?php if($_SERVER["HTTPS"]=='on'){?>7443<?php }else{?>7080<?php }?><?php }?>/xpay/js/xpay_utf-8.js" type="text/javascript"></script>
<?php }?>

<script type="text/javascript">doPay_ActiveX();</script>
</html>