<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/order/_kcp.html 000035528 */  $this->include_("defaultScriptFunc");?>
<?
    /* ============================================================================== */
    /* =   PAGE : 결제 요청 PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   이 페이지는 Payplus Plug-in을 통해서 결제자가 결제 요청을 하는 페이지    = */
    /* =   입니다. 아래의 ※ 필수, ※ 옵션 부분과 매뉴얼을 참조하셔서 연동을        = */
    /* =   진행하여 주시기 바랍니다.                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://testpay.kcp.co.kr/pgsample/FAQ/search_error.jsp       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2010.02   KCP Inc.   All Rights Reserved.                 = */
    /* ============================================================================== */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>*** KCP [AX-HUB Version] ***</title>
<?
    /* ============================================================================== */
    /* =   Javascript source Include                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수                                                                  = */
    /* =   테스트 및 실결제 연동시 site_conf_inc.php파일을 수정하시기 바랍니다.     = */
    /* = -------------------------------------------------------------------------- = */
?>
    <script type="text/javascript" src='<?php echo $TPL_VAR["g_conf_js_url"]?>' charset='euc-kr'></script>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   Javascript source Include END                                            = */
    /* ============================================================================== */
?>
    <script type="text/javascript">

		/* 플러그인 설치(확인) */
		StartSmartUpdate();
        /*  해당 스크립트는 타브라우져에서 적용이 되지 않습니다.
        if( document.Payplus.object == null )
        {
            openwin = window.open( "chk_plugin.html", "chk_plugin", "width=420, height=100, top=300, left=300" );
        }
        */

        /* Payplus Plug-in 실행 */
        function  jsf__pay( form )
        {
            var RetVal = false;

			var inst	= false;
			if ((navigator.userAgent.indexOf('MSIE') > 0) || (navigator.userAgent.indexOf('Trident/7.0') > 0)){
				if(document.Payplus.object){
					inst = true;
				}
			}else if	(navigator.userAgent.indexOf('Chrome') > 0){
				inst = true;	// 크롬에서는 pluins에서 kcp가 탐색되지 않음.
			}else{
				for (var i = 0; i < navigator.plugins.length; i++){
					if (navigator.plugins[i].name == "KCP"){ inst = true; }
				}
			}

			if(inst){
				/* Payplus Plugin 실행 */
				if ( MakePayMessage( form ) == true )
				{
					//openwin = window.open( "proc_win.html", "proc_win", "width=449, height=209, top=300, left=300" );
					RetVal = true ;
				}
				else
				{
					/*  res_cd와 res_msg변수에 해당 오류코드와 오류메시지가 설정됩니다.
						ex) 고객이 Payplus Plugin에서 취소 버튼 클릭시 res_cd=3001, res_msg=사용자 취소
						값이 설정됩니다.
					*/
					res_cd  = document.order_info.res_cd.value ;
					res_msg = document.order_info.res_msg.value ;
					parent.reverse_pay_button();
				}
			}else{
                openwin = window.open( "/pg/kcp/sample/chk_plugin.html", "chk_plugin", "width=640, height=460, top=300, left=300" );
			}
            return RetVal ;
        }

        // Payplus Plug-in 설치 안내 
        function init_pay_button(){

            if ((navigator.userAgent.indexOf('MSIE') > 0) || (navigator.userAgent.indexOf('Trident/7.0') > 0)){
                try{
                    if( document.Payplus.object == null ){
                        document.getElementById("display_setup_message").style.display = "block" ;
                    }else{
                        document.getElementById("display_pay_button").style.display = "block" ;
                    }
                }catch (e){
                    document.getElementById("display_setup_message").style.display = "block" ;
                }
            }else{
                try{
                    if( Payplus == null ){
                        document.getElementById("display_setup_message").style.display = "block" ;
                    }else{
                        document.getElementById("display_pay_button").style.display = "block" ;
                    }
                }catch (e){
                    document.getElementById("display_setup_message").style.display = "block" ;
                }
            }
			onload_pay();
        }

        /* 주문번호 생성 예제 */
        function init_kcp()
        {
            /*
             * 인터넷 익스플로러와 파이어폭스(사파리, 크롬.. 등등)는 javascript 파싱법이 틀리기 때문에 object 가 인식 전에 실행 되는 문제
             * 기존에는 onload 부분에 추가를 했지만 setTimeout 부분에 추가
             * setTimeout 300의 의미는 플러그인 인식속도에 따른 여유시간 설정
             * - 20101018 -
             */
			if ( !(navigator.userAgent.indexOf('MSIE') > 0) && !(navigator.userAgent.indexOf('Trident/7.0') > 0)){
				setTimeout("onload_pay();",300);
			}else{
				onload_pay();
			}
        }

        /* onLoad 이벤트 시 Payplus Plug-in이 실행되도록 구성하시려면 다음의 구문을 onLoad 이벤트에 넣어주시기 바랍니다. */
        function onload_pay()
        {
             if( jsf__pay(document.order_info) )
             document.order_info.submit();
        }

		/*에스크로 결제시 필요한 장바구니 샘플예제 입니다.*/
		function create_goodInfo()
        {
			var chr30 = String.fromCharCode(30);	// ASCII 코드값 30
			var chr31 = String.fromCharCode(31);	// ASCII 코드값 31

			var good_info = "seq=1" + chr31 + "ordr_numb=20060310_0001" + chr31 + "good_name=양말" + chr31 + "good_cntx=2" + chr31 + "good_amtx=1000" + chr30 +
                            "seq=2" + chr31 + "ordr_numb=20060310_0002" + chr31 + "good_name=신발" + chr31 + "good_cntx=1" + chr31 + "good_amtx=1500" + chr30 +
                            "seq=3" + chr31 + "ordr_numb=20060310_0003" + chr31 + "good_name=바지" + chr31 + "good_cntx=1" + chr31 + "good_amtx=1000";


			document.order_info.good_info.value = good_info;
        }


    </script>
<?php echo defaultScriptFunc()?></head>

<body onload="init_kcp();">


<div align="center">

<!-- 주문정보 입력 form : order_info -->
<form name="order_info" method="post" action="../payment/kcp" >

<?
    /* ============================================================================== */
    /* =   1. 주문 정보 입력                                                        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   결제에 필요한 주문 정보를 입력 및 설정합니다.                            = */
    /* = -------------------------------------------------------------------------- = */
?>
    <table width="589" cellspacing="0" cellpadding="0">
        <tr style="height:14px"><td style="background-image:url('/order/img/boxtop589.gif')"></td></tr>
        <tr>
            <td style="background-image:url('/order/img/boxbg589.gif') " align="center">
                <table width="551" cellspacing="0" cellpadding="16">
                    <tr style="height:17px">
                        <td style="background-image:url('/order/img/ttbg551.gif');border:0px " class="white">
                            <span class="bold big">[결제요청]</span> 이 페이지는 결제를 요청하는 샘플(예시) 페이지입니다.
                        </td>
                    </tr>
                    <!-- 상단 문구 -->
                    <tr>
                        <td style="background-image:url('/order/img/boxbg551.gif') ;">
                            <p class="align_left">이 페이지는 결제를 요청하는 페이지입니다.</p>
                            <p class="align_left">
                            고객이 결제요청 페이지에 접근하게 되면 웹 브라우저에서 결제를 위한 Payplus Plug-in이
                            고객의 PC에 설치되어 있는지 확인합니다</p>

                            <p class="align_left">
                            고객의 PC에 Payplus Plug-in이 설치되지 않은 경우
                            <span class="red bold">브라우저 상단의 노란색 알림표시줄</span>이나 하단의
                            <span class="red bold">[수동설치]</span>를 통해
                            <span class="red bold">Payplus Plug-in 설치</span>가 가능합니다.
                            </p>
                            <p class="align_left">
                            결제요청 버튼을 클릭하게 될 경우 Payplus Plug-in이 실행되며
                            Payplus Plug-in을 통해 결제요청 정보를 암호화하여 결제요청 페이지로 전송합니다.</p>

                            <p class="align_left">
                            <span class="red bold">※ 필수, ※ 옵션</span>표시가 포함된 문장은
                            가맹점의 상황에 맞게 적절히 수정 적용하시기 바랍니다.</p>
                        </td>
                    </tr>
                    <tr style="height:11px"><td style="background:url('/order/img/boxbtm551.gif') no-repeat;"></td></tr>
                </table>

                <!-- 주문정보 타이틀 -->
                <table width="527" border="0" cellspacing="0" cellpadding="0" class="margin_top_20">
                    <tr><td colspan="2"  class="title">주문 정보</td></tr>
<?
                    /* ============================================================================== */
                    /* =   1-1. 결제 수단 정보 설정                                                 = */
                    /* = -------------------------------------------------------------------------- = */
                    /* =   결제에 필요한 결제 수단 정보를 설정합니다.                               = */
                    /* =                                                                            = */
                    /* =  신용카드 : 100000000000, 계좌이체 : 010000000000, 가상계좌 : 001000000000 = */
                    /* =  포인트   : 000100000000, 휴대폰   : 000010000000, 상품권   : 000000001000 = */
                    /* =  ARS      : 000000000010                                                   = */
                    /* =                                                                            = */
                    /* =  위와 같이 설정한 경우 PayPlus Plugin에서 설정한 결제수단이 표시됩니다.    = */
                    /* =  Payplug Plugin에서 여러 결제수단을 표시하고 싶으신 경우 설정하시려는 결제 = */
                    /* =  수단에 해당하는 위치에 해당하는 값을 1로 변경하여 주십시오.               = */
                    /* =                                                                            = */
                    /* =  예) 신용카드, 계좌이체, 가상계좌를 동시에 표시하고자 하는 경우            = */
                    /* =  pay_method = "111000000000"                                               = */
                    /* =  신용카드(100000000000), 계좌이체(010000000000), 가상계좌(001000000000)에  = */
                    /* =  해당하는 값을 모두 더해주면 됩니다.                                       = */
                    /* =                                                                            = */
                    /* = ※ 필수                                                                    = */
                    /* =  KCP에 신청된 결제수단으로만 결제가 가능합니다.                            = */
                    /* = -------------------------------------------------------------------------- = */
?>
                    <tr>
                        <td class="sub_title1">지불방법</td>
                        <td class="sub_input1">
                            <select name="pay_method" class="frmselect">
<?php if($TPL_VAR["payment"]=='card'){?>
                                <option value="100000000000">신용카드</option>
<?php }?>
<?php if($TPL_VAR["payment"]=='account'){?>
                                <option value="010000000000">계좌이체</option>
<?php }?>
<?php if($TPL_VAR["payment"]=='virtual'){?>
                                <option value="001000000000">가상계좌</option>
<?php }?>
<?php if($TPL_VAR["payment"]=='cellphone'){?>
                                <option value="000010000000">휴대폰</option>
<?php }?>
                            </select>
                        </td>
                    </tr>
                    <!-- 주문번호(ordr_idxx) -->
                    <tr>
                        <td class="sub_title1">주문번호</td>
                        <td class="sub_input1"><input type="text" name="ordr_idxx" class="frminput" value="<?php echo $TPL_VAR["order_seq"]?>" size="40" maxlength="40"/></td>
                    </tr>
                    <!-- 상품명(good_name) -->
                    <tr>
                        <td class="sub_title1">상품명</td>
                        <td class="sub_input1"><input type="text" name="good_name" class="frminput" value="<?php echo $TPL_VAR["goods_name"]?>"/></td>
                    </tr>
                    <!-- 결제금액(good_mny) - ※ 필수 : 값 설정시 ,(콤마)를 제외한 숫자만 입력하여 주십시오. -->
                    <tr>
                        <td class="sub_title1">결제금액</td>
                        <td class="sub_input1"><input type="text" name="good_mny" class="frminput right" value="<?php echo $TPL_VAR["settle_price"]?>" size="10" maxlength="9"/>원(숫자만 입력)</td>
                    </tr>
                    <!-- 주문자명(buyr_name) -->
                    <tr>
                        <td class="sub_title1">주문자명</td>
                        <td class="sub_input1"><input type="text" name="buyr_name" class="frminput" value="<?php echo $TPL_VAR["order_user_name"]?>"/></td>
                    </tr>
                    <!-- 주문자 E-mail(buyr_mail) -->
                    <tr>
                        <td class="sub_title1">E-mail</td>
                        <td class="sub_input1"><input type="text" name="buyr_mail" class="frminput" value="<?php echo $TPL_VAR["order_email"]?>" size="30" maxlength="30" /></td>
                    </tr>
<?php if($TPL_VAR["payment"]=='virtual'){?>
					<!-- 마감일자 (ipgm_date) -->
					<tr>
						<td class="HEAD">마감일자</td>
						<td class="TEXT"><input type="text" name='ipgm_date' size="30" maxlength="10" value='<?php if($TPL_VAR["ipgm_date"]){?><?php echo $TPL_VAR["ipgm_date"]?><?php }else{?><?php echo date("Ymd",time()+ 24* 3600* 3)?><?php }?>'></td>
					</tr>
<?php }?>
                    <!-- 주문자 연락처1(buyr_tel1) -->
                    <tr>
                        <td class="sub_title1">전화번호</td>
                        <td class="sub_input1"><input type="text" name="buyr_tel1" class="frminput" value="<?php echo $TPL_VAR["order_phone"]?>"/></td>
                    </tr>
                    <!-- 휴대폰번호(buyr_tel2) -->
                    <tr>
                        <td class="sub_title1">휴대폰번호</td>
                        <td class="sub_input1"><input type="text" name="buyr_tel2" class="frminput" value="<?php echo $TPL_VAR["order_cellphone"]?>"/></td>
                    </tr>
                </table>

<?
    /* ============================================================================== */
    /* =   1-2. 에스크로 정보                                                       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   에스크로 사용업체에 적용되는 정보입니다.                                 = */
    /* = -------------------------------------------------------------------------- = */
?>
                <table width="527" border="0" cellspacing="0" cellpadding="0" class="margin_top_20">
                    <tr><td colspan="2"  class="title">에 스 크 로 정 보</td></tr>
                    <!-- 수취인명(rcvr_name) -->
                    <tr>
                        <td class="sub_title1">수취인명</td>
                        <td class="sub_input1"><input type="text" name="rcvr_name" class="frminput" value="<?php echo $TPL_VAR["data_order"]["recipient_user_name"]?>"/></td>
                    </tr>
                    <!-- 수취인 연락처1(rcvr_tel1) -->
                    <tr>
                        <td class="sub_title1">수취인 전화번호</td>
                        <td class="sub_input1"><input type="text" name="rcvr_tel1" class="frminput" value="<?php echo $TPL_VAR["data_order"]["recipient_phone"]?>"/></td>
                    </tr>
                    <!-- 수취인 휴대폰번호(rcvr_tel2) -->
                    <tr>
                        <td class="sub_title1">수취인 휴대폰번호</td>
                        <td class="sub_input1"><input type="text" name="rcvr_tel2" class="frminput" value="<?php echo $TPL_VAR["data_order"]["recipient_cellphone"]?>"/></td>
                    </tr>
                    <!-- 수취인 E-mail(rcvr_mail) -->
                    <tr>
                        <td class="sub_title1">수취인 E-mail</td>
                        <td class="sub_input1"><input type="text" name="rcvr_mail" class="frminput" value="<?php echo $TPL_VAR["data_order"]["order_email"]?>" size="30" maxlength="30" /></td>
                    </tr>
                    <!-- 수취인 우편번호(rcvr_zipx) -->
                    <tr>
                        <td class="sub_title1">수취인 우편번호</td>
                        <td class="sub_input1"><input type="text" name="rcvr_zipx" class="frminput" value="<?php echo $TPL_VAR["data_order"]["recipient_zipcode"]?>"/></td>
                    </tr>
                    <!-- 수취인 주소(rcvr_add1) -->
                    <tr>
                        <td class="sub_title1">수취인 주소</td>
                        <td class="sub_input1"><input type="text" name="rcvr_add1" class="frminput" value="<?php echo $TPL_VAR["data_order"]["recipient_address"]?>"/></td>
                    </tr>
                    <tr>
                        <td class="sub_title1">수취인 상세주소</td>
                        <td class="sub_input1"><input type="text" name="rcvr_add2" class="frminput" value="<?php echo $TPL_VAR["data_order"]["recipient_address_detail"]?>"/></td>
                    </tr>
                </table>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   1-2. 에스크로 정보  END					                                = */
    /* ============================================================================== */
?>
                <table width="527" border="0" cellspacing="0" cellpadding="0" class="margin_top_10">
                    <!-- 결제 요청/처음으로 이미지 -->
                    <tr style="height:10px"><td></td></tr>
                    <tr id="display_pay_button" style="display:none">
                        <td colspan="2" align="center">
                            <input type="image" src="/order/img/btn_pay.gif" alt="결제를 요청합니다" onclick="return jsf__pay(this.form);"/>
                            <a href="../index.html"><img src="/order/img/btn_home.gif" width="108" height="37" alt="처음으로 이동합니다" /></a>
                        </td>
                    </tr>
                    <!-- Payplus Plug-in 설치 안내 -->
                    <tr id="display_setup_message" style="display:none">
                        <td colspan="2" align="center">
                            <span class="red">결제를 계속 하시려면 상단의 노란색 표시줄을 클릭</span>하시거나<br/>
                            <a href="http://pay.kcp.co.kr/plugin/file_vista/PayplusWizard.exe"><span class="bold">[수동설치]</span></a>를 눌러 Payplus Plug-in을 설치하시기 바랍니다.<br/>
                            [수동설치]를 눌러 설치하신 경우 <span class="red bold">새로고침(F5)키</span>를 눌러 진행하시기 바랍니다.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td><img src="/order/img/boxbtm589.gif" alt="Copyright(c) KCP Inc. All rights reserved."/></td></tr>
    </table>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   1. 주문 정보 입력 END                                                    = */
    /* ============================================================================== */
?>

<?
    /* ============================================================================== */
    /* =   2. 가맹점 필수 정보 설정                                                 = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수 - 결제에 반드시 필요한 정보입니다.                               = */
    /* =   site_conf_inc.php 파일을 참고하셔서 수정하시기 바랍니다.                 = */
    /* = -------------------------------------------------------------------------- = */
    // 요청종류 : 승인(pay)/취소,매입(mod) 요청시 사용
?>
    <input type="hidden" name="req_tx"          value="pay" />
    <input type="hidden" name="site_cd"         value="<?php echo $TPL_VAR["g_conf_site_cd"]?>" />
    <input type="hidden" name="site_key"        value="<?php echo $TPL_VAR["g_conf_site_key"]?>" />
    <input type="hidden" name="site_name"       value="<?php echo $TPL_VAR["g_conf_site_name"]?>" />

<?
    /*
    할부옵션 : Payplus Plug-in에서 카드결제시 최대로 표시할 할부개월 수를 설정합니다.(0 ~ 18 까지 설정 가능)
    ※ 주의  - 할부 선택은 결제금액이 50,000원 이상일 경우에만 가능, 50000원 미만의 금액은 일시불로만 표기됩니다
               예) value 값을 "5" 로 설정했을 경우 => 카드결제시 결제창에 일시불부터 5개월까지 선택가능
    */
?>
    <input type="hidden" name="quotaopt"        value="<?php echo $TPL_VAR["quotaopt"]?>"/>
    <!-- 필수 항목 : 결제 금액/화폐단위 -->
    <input type="hidden" name="currency"        value="WON"/>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   2. 가맹점 필수 정보 설정 END                                             = */
    /* ============================================================================== */
?>

<?
    /* ============================================================================== */
    /* =   3. Payplus Plugin 필수 정보(변경 불가)                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   결제에 필요한 주문 정보를 입력 및 설정합니다.                            = */
    /* = -------------------------------------------------------------------------- = */
?>
    <!-- PLUGIN 설정 정보입니다(변경 불가) -->
    <input type="hidden" name="module_type"     value="01"/>
    <!-- 복합 포인트 결제시 넘어오는 포인트사 코드 : OK캐쉬백(SCSK), 베네피아 복지포인트(SCWB) -->
    <input type="hidden" name="epnt_issu"       value="" />
<?
    /* ============================================================================== */
    /* =   3-1. Payplus Plugin 에스크로결제 사용시 필수 정보                        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   결제에 필요한 주문 정보를 입력 및 설정합니다.                            = */
    /* = -------------------------------------------------------------------------- = */
?>
	<!-- 에스크로 사용 여부 : 반드시 Y 로 설정 -->
    <input type="hidden" name="escw_used"       value="Y"/>
<?php if($TPL_VAR["escorw"]){?>
	<!-- 에스크로 결제처리 모드 : 에스크로: Y, KCP 설정 조건: O  -->
    <input type="hidden" name="pay_mod"         value="Y"/>
<?php }else{?>
	<!-- 에스크로 결제처리 모드 : 일반: N, KCP 설정 조건: O  -->
    <input type="hidden" name="pay_mod"         value="N"/>
<?php }?>
	<!-- 배송 소요일 : 예상 배송 소요일을 입력 -->
	<input type="hidden"  name="deli_term" value="03"/>
	<!-- 장바구니 상품 개수 : 장바구니에 담겨있는 상품의 개수를 입력(good_info의 seq값 참조) -->
	<input type="hidden"  name="bask_cntx" value="1"/>
	<!-- 장바구니 상품 상세 정보 (자바 스크립트 샘플 create_goodInfo()가 온로드 이벤트시 설정되는 부분입니다.) -->
	<textarea name='good_info' style="width:100%;height:60px;"><?php echo $TPL_VAR["good_info"]?></textarea>
   	<!-- 구매확인을 업체페이지에 구현하실 경우 "S" 로 설정(메일 확인 시 KCP에 등록된 가맹점 웹페이지로 링크처리) -->
    <input type="hidden" name="confirm_type"          value="S" />
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   3-1. Payplus Plugin 에스크로결제 사용시 필수 정보  END                   = */
    /* ============================================================================== */
?>
<!--
      ※ 필 수
          필수 항목 : Payplus Plugin에서 값을 설정하는 부분으로 반드시 포함되어야 합니다
          값을 설정하지 마십시오
-->
    <input type="hidden" name="res_cd"          value=""/>
    <input type="hidden" name="res_msg"         value=""/>
    <input type="hidden" name="tno"             value=""/>
    <input type="hidden" name="trace_no"        value=""/>
    <input type="hidden" name="enc_info"        value=""/>
    <input type="hidden" name="enc_data"        value=""/>
    <input type="hidden" name="ret_pay_method"  value=""/>
    <input type="hidden" name="tran_cd"         value=""/>
    <input type="hidden" name="bank_name"       value=""/>
    <input type="hidden" name="bank_issu"       value=""/>
    <input type="hidden" name="use_pay_method"  value=""/>

    <!--  현금영수증 관련 정보 : Payplus Plugin 에서 설정하는 정보입니다 -->
    <input type="hidden" name="cash_tsdtime"    value=""/>
    <input type="hidden" name="cash_yn"         value=""/>
    <input type="hidden" name="cash_authno"     value=""/>
    <input type="hidden" name="cash_tr_code"    value=""/>
    <input type="hidden" name="cash_id_info"    value=""/>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   3. Payplus Plugin 필수 정보 END                                          = */
    /* ============================================================================== */
?>

<?
    /* ============================================================================== */
    /* =   4. 옵션 정보                                                             = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 옵션 - 결제에 필요한 추가 옵션 정보를 입력 및 설정합니다.             = */
    /* = -------------------------------------------------------------------------- = */

    /* PayPlus에서 보이는 신용카드사 삭제 파라미터 입니다
    ※ 해당 카드를 결제창에서 보이지 않게 하여 고객이 해당 카드로 결제할 수 없도록 합니다. (카드사 코드는 매뉴얼을 참고)
    <input type="hidden" name="not_used_card" value="CCPH:CCSS:CCKE:CCHM:CCSH:CCLO:CCLG:CCJB:CCHN:CCCH"/> */

    /* 신용카드 결제시 OK캐쉬백 적립 여부를 묻는 창을 설정하는 파라미터 입니다
         OK캐쉬백 포인트 가맹점의 경우에만 창이 보여집니다
        <input type="hidden" name="save_ocb"        value="Y"/> */

	/* 고정 할부 개월 수 선택
	       value값을 "7" 로 설정했을 경우 => 카드결제시 결제창에 할부 7개월만 선택가능
    <input type="hidden" name="fix_inst"        value="07"/> */

	/*  무이자 옵션
            ※ 설정할부    (가맹점 관리자 페이지에 설정 된 무이자 설정을 따른다)                             - "" 로 설정
            ※ 일반할부    (KCP 이벤트 이외에 설정 된 모든 무이자 설정을 무시한다)                           - "N" 로 설정
            ※ 무이자 할부 (가맹점 관리자 페이지에 설정 된 무이자 이벤트 중 원하는 무이자 설정을 세팅한다)   - "Y" 로 설정
    <input type="hidden" name="kcp_noint"       value=""/> */


	/*  무이자 설정
            ※ 주의 1 : 할부는 결제금액이 50,000 원 이상일 경우에만 가능
            ※ 주의 2 : 무이자 설정값은 무이자 옵션이 Y일 경우에만 결제 창에 적용
            예) 전 카드 2,3,6개월 무이자(국민,비씨,엘지,삼성,신한,현대,롯데,외환) : ALL-02:03:04
            BC 2,3,6개월, 국민 3,6개월, 삼성 6,9개월 무이자 : CCBC-02:03:06,CCKM-03:06,CCSS-03:06:04
    <input type="hidden" name="kcp_noint_quota" value="CCBC-02:03:06,CCKM-03:06,CCSS-03:06:09"/> */


	/*  가상계좌 은행 선택 파라미터
         ※ 해당 은행을 결제창에서 보이게 합니다.(은행코드는 매뉴얼을 참조) */
?>
    <input type="hidden" name="wish_vbank_list" value="05:03:04:07:11:23:26:32:34:81:71"/>
<?


	/*  가상계좌 입금 기한 설정하는 파라미터 - 발급일 + 3일 */
?>
    <input type="hidden" name="vcnt_expire_term" value="<?php if($TPL_VAR["cancelDuration"]){?><?php echo $TPL_VAR["cancelDuration"]?><?php }else{?>3<?php }?>"/> 

<?

    /*  가상계좌 입금 시간 설정하는 파라미터
         HHMMSS형식으로 입력하시기 바랍니다
         설정을 안하시는경우 기본적으로 23시59분59초가 세팅이 됩니다
         <input type="hidden" name="vcnt_expire_term_time" value="120000"/> */


    /* 포인트 결제시 복합 결제(신용카드+포인트) 여부를 결정할 수 있습니다.- N 일경우 복합결제 사용안함
        <input type="hidden" name="complex_pnt_yn" value="N"/>    */

	/* 문화상품권 결제시 가맹점 고객 아이디 설정을 해야 합니다.(필수 설정)
	    <input type="hidden" name="tk_shop_id" value=""/>    */

	/* 현금영수증 등록 창을 출력 여부를 설정하는 파라미터 입니다
         ※ Y : 현금영수증 등록 창 출력
         ※ N : 현금영수증 등록 창 출력 안함
		 ※ 주의 : 현금영수증 사용 시 KCP 상점관리자 페이지에서 현금영수증 사용 동의를 하셔야 합니다 */
?>
    <input type="hidden" name="disp_tax_yn"     value="Y"/>
<?
    /* 결제창에 가맹점 사이트의 로고를 플러그인 좌측 상단에 출력하는 파라미터 입니다
       업체의 로고가 있는 URL을 정확히 입력하셔야 하며, 최대 150 X 50  미만 크기 지원

	※ 주의 : 로고 용량이 150 X 50 이상일 경우 site_name 값이 표시됩니다. */

?>
<?php if($TPL_VAR["kcp_logo_type"]=='img'&&is_file($TPL_VAR["kcp_logo_val_img"])){?>
    <input type="text" name="site_logo"       value="<?php echo $TPL_VAR["kcp_logo_img"]?>" />
<?php }else{?>
	<input type="text" name="site_logo"       value="" />
<?php }?>
<?
	/* 결제창 영문 표시 파라미터 입니다. 영문을 기본으로 사용하시려면 Y로 세팅하시기 바랍니다
		2010-06월 현재 신용카드와 가상계좌만 지원됩니다
		<input type='hidden' name='eng_flag'      value='Y'> */
?>

<?
	/* KCP는 과세상품과 비과세상품을 동시에 판매하는 업체들의 결제관리에 대한 편의성을 제공해드리고자,
	   복합과세 전용 사이트코드를 지원해 드리며 총 금액에 대해 복합과세 처리가 가능하도록 제공하고 있습니다

	   복합과세 전용 사이트 코드로 계약하신 가맹점에만 해당이 됩니다

	   상품별이 아니라 금액으로 구분하여 요청하셔야 합니다

	   총결제 금액은 과세금액 + 부과세 + 비과세금액의 합과 같아야 합니다.
	   (good_mny = comm_tax_mny + comm_vat_mny + comm_free_mny)

	   skin_indx 값은 스킨을 변경할 수 있는 파라미터이며 총 7가지가 지원됩니다.
	   변경을 원하시면 1부터 7까지 값을 넣어주시기 바랍니다. */
?>
	<input type="hidden" name="tax_flag" value="TG03">     <!-- 변경불가    -->
	<input type="hidden" name="comm_tax_mny" value="<?php echo $TPL_VAR["comm_tax_mny"]?>">         <!-- 과세금액    -->
	<input type="hidden" name="comm_vat_mny" value="<?php echo $TPL_VAR["comm_vat_mny"]?>">         <!-- 부가세	    -->
	<input type="hidden" name="comm_free_mny" value="<?php echo $TPL_VAR["comm_free_mny"]?>">         <!-- 비과세 금액 -->

    <input type='hidden' name='skin_indx'      value='<?php if($TPL_VAR["kcp_skin_color"]){?><?php echo $TPL_VAR["kcp_skin_color"]?><?php }else{?>1<?php }?>'>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   4. 옵션 정보 END                                                         = */
    /* ============================================================================== */
?>

<button type="button" onclick="onload_pay()">결제하기</button>

</form>
</div>


</body>
</html>