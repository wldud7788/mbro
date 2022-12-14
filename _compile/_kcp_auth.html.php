<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/order/_kcp_auth.html 000018409 */  $this->include_("defaultScriptFunc");?>
<html>
<head>
<title>스마트폰 웹 결제창</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="No-Cache">
<meta http-equiv="Pragma" content="No-Cache">
<meta name="viewport" content="width=device-width; user-scalable=<?php echo $TPL_VAR["tablet_size"]?>; initial-scale=<?php echo $TPL_VAR["tablet_size"]?>; maximum-scale=<?php echo $TPL_VAR["tablet_size"]?>; minimum-scale=<?php echo $TPL_VAR["tablet_size"]?>">

<style type="text/css">
	.LINE { background-color:#afc3ff }
	.HEAD { font-family:"굴림","굴림체"; font-size:9pt; color:#000000; background-color:#FFFFFF; text-align:left; padding:3px; }
	.TEXT { font-family:"굴림","굴림체"; font-size:9pt; color:#000000; background-color:#FFFFFF; text-align:left; padding:3px; }
	    B { font-family:"굴림","굴림체"; font-size:13pt; color:#065491;}
	INPUT { font-family:"굴림","굴림체"; font-size:9pt; }
	SELECT{font-size:9pt;}
	.COMMENT { font-family:"굴림","굴림체"; font-size:9pt; line-height:160% }
</style>
<!-- 거래등록 하는 kcp 서버와 통신을 위한 스크립트-->
<script type="text/javascript" src="/pg/kcp_mobile/sample/common/approval_key.js?dummy=2014090819"></script>

<script language="javascript">
	
	/* 주문번호 생성 예제 */
    function init_orderid()
    {
        var today = new Date();
        var year  = today.getFullYear();
        var month = today.getMonth()+ 1;
        var date  = today.getDate();
        var time  = today.getTime();

        if(parseInt(month) < 10) {
            month = "0" + month;
        }

        var vOrderID = year + "" + month + "" + date + "" + time;
        var vDEL_YMD = year + "" + month + "" + date;

        //document.forms[0].ordr_idxx.value = vOrderID;
        self.name = "tar_opener";
    }

	/* kcp web 결제창 호출 (변경불가)*/
    function call_pay_form()
    {

       var v_frm = document.sm_form;

        layer_cont_obj   = document.getElementById("content");
        layer_card_obj = document.getElementById("layer_card");

        //layer_cont_obj.style.display = "none";
        //layer_card_obj.style.display = "block";

        //v_frm.target = "frm_card";
<?php if($_POST['mobilenew']=='y'){?>
		if (parent.document.getElementById("payprocessing") != null){
			parent.document.getElementById("payprocessing").style.display = "none";
		}
<?php }?>

		// 인코딩 방식에 따른 변경 -- Start
        if(v_frm.encoding_trans == undefined)
        {
        	v_frm.action = PayUrl;
        }
        else
        {
        	if(v_frm.encoding_trans.value == "UTF-8")
        	{
                v_frm.action = PayUrl.substring(0,PayUrl.lastIndexOf("/")) + "/jsp/encodingFilter/encodingFilter.jsp";
                v_frm.PayUrl.value = PayUrl;
        	}
        	else
        	{
        		v_frm.action = PayUrl;
        	}
        }
        // 인코딩 방식에 따른 변경 -- End

        if(v_frm.Ret_URL.value == "")
        {
            /* Ret_URL값은 현 페이지의 URL 입니다. */
            alert("연동시 Ret_URL을 반드시 설정하셔야 됩니다.");
            return false;
        }
        else
        {
           v_frm.submit();
        }
    }


	/* kcp 통신을 통해 받은 암호화 정보 체크 후 결제 요청*/
    function chk_pay()
    {
        /*kcp 결제서버에서 가맹점 주문페이지로 폼값을 보내기위한 설정(변경불가)*/
        //self.name = "tar_opener";
	
        var pay_form = document.pay_form;

        if (pay_form.res_cd.value == "3001" )
        {
            alert("사용자가 취소하였습니다.");
            pay_form.res_cd.value = "";
            return false;
        }
        else if (pay_form.res_cd.value == "3000" )
        {
            alert("30만원 이상 결제 할수 없습니다.");
            pay_form.res_cd.value = "";
            return false;
        }
        
        if (pay_form.enc_data.value != "" && pay_form.enc_info.value != "" && pay_form.tran_cd.value !="" )
        {
            jsf__show_progress(true);
            alert("페이지 하단의 확인 버튼을 눌러 주세요.");
        }
        else
        {
             jsf__show_progress(false);
             return false;
        }
    }

	/* 에스크로 장바구니 상품 상세 정보 생성 예제 */
	function create_goodInfo()
	{
		var chr30 = String.fromCharCode(30);
		var chr31 = String.fromCharCode(31);

		var good_info = "seq=1" + chr31 + "ordr_numb=20060310_0001" + chr31 + "good_name=양말" + chr31 + "good_cntx=2" + chr31 + "good_amtx=1000" + chr30 +
		"seq=2" + chr31 + "ordr_numb=20060310_0002" + chr31 + "good_name=신발" + chr31 + "good_cntx=1" + chr31 + "good_amtx=1500" + chr30 +
		"seq=3" + chr31 + "ordr_numb=20060310_0003" + chr31 + "good_name=바지" + chr31 + "good_cntx=1" + chr31 + "good_amtx=1000";

		document.sm_form.good_info.value = good_info;
	}

	function  jsf__show_progress( show )
    {
        if ( show == true )
        {
            document.getElementById("show_pay_btn") .style.display  = 'inline';
            document.getElementById("show_progress").style.display = 'inline';
            document.getElementById("show_req_btn") .style.display = 'none';
        }
        else
        { 
            document.getElementById("show_pay_btn") .style.display  = 'none';
            document.getElementById("show_progress").style.display = 'none';
<?php if($_POST['mobilenew']=='y'){?>
			kcp_AJAX();
<?php }else{?>
			document.getElementById("show_req_btn") .style.display = 'inline';
<?php }?>
        }
    }

    /* 최종 결제 요청*/
    function jsf__pay ()
    {
        var pay_form = document.pay_form;
        pay_form.submit();
    }
</script>

<?php echo defaultScriptFunc()?></head>
<body onload="chk_pay();">

<div id="content" style="display:<?php if($_POST['mobilenew']!='y'){?>block<?php }else{?>none<?php }?>;margin:auto;">

	<form name="sm_form" method="POST">

	<input type="hidden" name="encoding_trans" value="UTF-8" />
	<input type="hidden" name='PayUrl' > 

<?php if($_POST['mobilenew']!='y'){?>
	<table border="0" width="100%">
		<tr>
			<td align="center">
				<b style="color:blue">* 스마트폰 KCP 결제 *</b>
			</td>
		</tr>
	</table>
	<BR>
<?php }?>

	<table width="90%" border="0" align="center" <?php if($_POST['mobilenew']=='y'){?>style="dispaly:block;"<?php }?>>
	<tr>
		<td width="50%" valign="top">
			<table border="0" width="90%" class="LINE" cellspacing="1" cellpadding="1" align="center">
		  <tr>
			  <td class="TEXT" colspan="2" style="text-align:center"><b>주문 정보</b></td>
		  </tr>
		  <tr> 
			  <td class="HEAD">상품명</td>
			  <td class="TEXT"><input type="hidden" name='good_name' maxlength="100" value='<?php echo $TPL_VAR["goods_name"]?>'><?php echo $TPL_VAR["goods_name"]?></td>
		  </tr>
		  <tr> 
			  <td class="HEAD">상품금액</td>
			  <td class="TEXT"><input type="hidden" name='good_mny' size="9" maxlength="9" value='<?php echo $TPL_VAR["settleprice"]?>' ><?php echo number_format($TPL_VAR["settleprice"])?></td>
		  </tr>
		  <tr> 
			  <td class="HEAD">주문자이름</td>
			  <td class="TEXT"><input type="hidden" name='buyr_name' size="20" maxlength="20" value="<?php echo $TPL_VAR["order_user_name"]?>"><?php echo $TPL_VAR["order_user_name"]?></td>
		  </tr>
		  <tr> 
			  <td class="HEAD">주문자 연락처</td>
			  <td class="TEXT"><input type="hidden" name='buyr_tel1' size="20" maxlength="20" value='<?php echo $TPL_VAR["order_phone"]?>'><?php echo $TPL_VAR["order_phone"]?></td>
		  </tr>
		  <tr> 
			  <td class="HEAD">주문자 핸드폰 번호</td>
			  <td class="TEXT"><input type="hidden" name='buyr_tel2' size="20" maxlength="20" value='<?php echo $TPL_VAR["order_cellphone"]?>'><?php echo $TPL_VAR["order_cellphone"]?></td>
		  </tr>
		  <tr> 
			  <td class="HEAD">주문자 E-mail</td>
			  <td class="TEXT"><input type="hidden" name='buyr_mail' size="20" maxlength="30" value='<?php echo $TPL_VAR["order_email"]?>'><?php echo $TPL_VAR["order_email"]?></td>
		  </tr>
<?php if($TPL_VAR["payment"]=='virtual'){?>
		  <tr>
			  <td class="HEAD">마감일자</td>
			  <td class="TEXT"><input type="hidden" name='ipgm_date' size="30" maxlength="10" value='<?php if($TPL_VAR["ipgm_date"]){?><?php echo $TPL_VAR["ipgm_date"]?><?php }else{?><?php echo date("Ymd",time()+ 24* 3600* 3)?><?php }?>'></td>
		  </tr>
<?php }?>
			</table>
		</td>
	</tr>
	</table>

	<table width="100%" border="0">
		  <tr id='show_req_btn' align="center">
			  <td class="TEXT" colspan="2" style="text-align:center">
				  <!-- <input type="submit" value="결제등록 요청버튼"> -->
<?php if($_POST['mobilenew']!='y'){?><input type="button" name="submitChecked" onClick="kcp_AJAX();" value="결제등록요청" /><?php }?>
			  </td>
		  </tr>
		  <tr id='show_progress' style='display:none;'>
			  <td class="TEXT" colspan="2" style="text-align:center">반드시 확인버튼을 클릭 하셔야만 결제가 진행됩니다.</td>
		  </tr>
		  <tr id='show_pay_btn' align="center" style='display:none;'>
			  <td class="TEXT" colspan="2" style="text-align:center">
				  <!-- <input type="submit" value="결제버튼"> -->
				  <input type="button" name="btn" onClick="jsf__pay();" value="확인" />
			  </td>
		  </tr>
	</table>
	<!-- 필수 사항 -->

	<!-- 요청 구분 -->
	<input type="hidden" name='req_tx'       value='pay'>
	<!-- 사이트 코드 -->
	<input type="hidden" name='site_cd'      value="<?php echo $TPL_VAR["g_conf_site_cd"]?>">
	<!-- 사이트 키 -->
	<input type="hidden" name='site_key'     value='<?php echo $TPL_VAR["g_conf_site_key"]?>'>
	 <!-- 사이트 이름 --> 
	<input type="hidden" name='shop_name'    value="<?php echo $TPL_VAR["g_conf_site_name"]?>">
	<!-- 결제수단-->
<?php if(preg_match('/card/',$TPL_VAR["payment"])){?>
	<input type="hidden" name='pay_method'   value="CARD">
<?php }elseif(preg_match('/cellphone/',$TPL_VAR["payment"])){?>
	<input type="hidden" name='pay_method'   value="MOBX">
<?php }elseif(preg_match('/account/',$TPL_VAR["payment"])){?>
	<input type="hidden" name='pay_method'   value="BANK">
<?php }elseif(preg_match('/virtual/',$TPL_VAR["payment"])){?>
	<input type="hidden" name='pay_method'   value="VCNT">
<?php }?>

	<!-- 주문번호 -->
	<input type="hidden"  name='ordr_idxx'    value="<?php echo $TPL_VAR["order_seq"]?>">
	<!-- 최대 할부개월수 -->
	<input type="hidden" name='quotaopt'     value="12">
	<!-- 통화 코드 -->
	<input type="hidden" name='currency'     value="410">
	<!-- 결제등록 키 -->
	<input type="hidden" name='approval_key' id="approval">
	<!-- 리턴 URL (kcp와 통신후 결제를 요청할 수 있는 암호화 데이터를 전송 받을 가맹점의 주문페이지 URL) -->
	<!-- 반드시 가맹점 주문페이지의 URL을 입력 해주시기 바랍니다. -->
	<input type="hidden" name='Ret_URL'      value="<?=get_connet_protocol()?><?php echo $_SERVER["HTTP_HOST"]?>/kcp_mobile/pp_ax_hub">
	<!-- 인증시 필요한 파라미터(변경불가)-->

<?php if(preg_match('/card/',$TPL_VAR["payment"])){?>
	<input type="hidden" name='ActionResult'   value="card">
<?php }elseif(preg_match('/cellphone/',$TPL_VAR["payment"])){?>
	<input type="hidden" name='ActionResult'   value="mobx">
<?php }elseif(preg_match('/account/',$TPL_VAR["payment"])){?>
	<input type="hidden" name='ActionResult'   value="acnt">
<?php }elseif(preg_match('/virtual/',$TPL_VAR["payment"])){?>
	<input type="hidden" name='ActionResult'   value="vcnt">
<?php }?>

	<!-- 인증시 필요한 파라미터(변경불가)-->
<?php if(preg_match('/escrow/',$TPL_VAR["payment"])){?>
	<input type="hidden" name='escw_used'    value="Y"/>
	<!-- 에스크로 결제처리모드 KCP 설정된 금액 결제(사용 : 설정된금액적용: 사용안함: -->
	<input type="hidden" name="pay_mod"         value="Y"/>
	<!-- 배송소요기간 -->
	<input type="hidden" name='deli_term' value='05'>
<?php }else{?>
	<input type="hidden" name='escw_used'    value="N"/>
	<input type="hidden" name="pay_mod"         value="N"/>
<?php }?>
	<!-- 장바구니 개수(수량아님) -->
	<input type="hidden" name='bask_cntx' value="<?php echo $TPL_VAR["bask_cntx"]?>">
	<!-- 장바구니 정보(상단 스크립트 참조) -->
	<textarea name='good_info' style="<?php if($_POST['mobilenew']!='y'){?>display:none;<?php }?>width:100%;height:60px;"><?php echo $TPL_VAR["good_info"]?></textarea>

	<!-- 기타 파라메터 추가 부분 - Start - -->
<?php if($_POST['mobilenew']=='y'){?>
	<input type="hidden" name='param_opt_1'	 value="mobilenew"/>
<?php }else{?>
	<input type="hidden" name='param_opt_1'	 value="<?php echo $TPL_VAR["param_opt_1"]?>"/>
<?php }?>
	<input type="hidden" name='param_opt_2'	 value="<?php echo $TPL_VAR["param_opt_2"]?>"/>
	<input type="hidden" name='param_opt_3'	 value="<?php echo $TPL_VAR["param_opt_3"]?>"/>
	<!-- 기타 파라메터 추가 부분 - End - -->
	<!-- 화면 크기조정 부분 - Start - -->
	<input type="hidden" name='tablet_size'	 value="<?php echo $TPL_VAR["tablet_size"]?>"/>
	<!-- 화면 크기조정 부분 - End - -->
	<!--
		사용 카드 설정
		<input type="hidden" name='used_card'    value="CClg:ccDI">
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
		*/
	-->
	<input type="hidden" name="kcp_noint" value="<?php echo $TPL_VAR["quotaopt"]?>"/>
	<input type="hidden" name="kcp_noint_quota" value="<?php echo $TPL_VAR["kcp_noint_quota"]?>"/>

	<!-- 복합과세처리 시작 -->
<?php if($TPL_VAR["comm_free_mny"]){?>
	<input type="hidden" name="tax_flag"          value="TG03">    <!-- 변경불가      -->
	<input type="hidden" name="comm_tax_mny"      value="<?php echo $TPL_VAR["comm_tax_mny"]?>">          <!-- 과세금액      -->
	<input type="hidden" name="comm_vat_mny"      value="<?php echo $TPL_VAR["comm_vat_mny"]?>">          <!-- 부가세        -->
	<input type="hidden" name="comm_free_mny"     value="<?php echo $TPL_VAR["comm_free_mny"]?>">          <!-- 비과세 금액  -->
<?php }?>
	<!-- 복합과세처리 끝 -->
	
	<!-- 앱 결제 관련 시작 : @20190423 KCP로부터 확인한 내용. AppUrl변수는 앱일때에만 사용 되어야 함. 웹결제시 appurl 변수 포함되면 안됨. -->
<?php if($TPL_VAR["ISMOBILE_APP_AGENT"]){?>
<?php if(preg_match('/card/',$TPL_VAR["payment"])){?>
	<input type="hidden" name="AppUrl" value=" ispmobile://card_pay" />
<?php }else{?>
	<input type="hidden" name="AppUrl" value=" ispmobile://" />
<?php }?>
<?php }?>
	<!-- 앱 결제 관련 종료 -->
	</form>
</div>

<!-- 스마트폰에서 KCP 결제창을 레이어 형태로 구현-->
<div id="layer_card" style="width:320px;height:600px;z-index:1; border:2px solid red;display:none;margin:auto;padding:0px;background-color:#ffffff;">
<iframe name="frm_card" frameborder="0" border="0" width="100%" height="100%" scrolling="no"></iframe>
</div>

<form name="pay_form" method="POST" action="/kcp_mobile/approval">
    <input type="hidden" name="req_tx"         value="">      <!-- 요청 구분          -->
    <input type="hidden" name="res_cd"         value="">      <!-- 결과 코드          -->
    <input type="hidden" name="tran_cd"        value="">     <!-- 트랜잭션 코드      -->
    <input type="hidden" name="ordr_idxx"      value="">   <!-- 주문번호           -->
    <input type="hidden" name="good_mny"       value="">    <!-- 휴대폰 결제금액    -->
    <input type="hidden" name="good_name"      value="">   <!-- 상품명             -->
    <input type="hidden" name="buyr_name"      value="">   <!-- 주문자명           -->
    <input type="hidden" name="buyr_tel1"      value="">   <!-- 주문자 전화번호    -->
    <input type="hidden" name="buyr_tel2"      value="">   <!-- 주문자 휴대폰번호  -->
    <input type="hidden" name="buyr_mail"      value="">   <!-- 주문자 E-mail      -->
    <input type="hidden" name="enc_info"       value="">    <!-- 암호화 정보        -->
    <input type="hidden" name="enc_data"       value="">    <!-- 암호화 데이터      -->
    <input type="hidden" name="use_pay_method" value="100000000000">      <!-- 요청된 결제 수단   -->
	<input type="hidden" name="param_opt_1"	   value="">
	<input type="hidden" name="param_opt_2"	   value="">
	<input type="hidden" name="param_opt_3"	   value="">
	<!-- 복합과세처리 시작 -->
<?php if($TPL_VAR["comm_free_mny"]){?>
	<input type="hidden" name="tax_flag"          value="TG03">    <!-- 변경불가      -->
	<input type="hidden" name="comm_tax_mny"      value="<?php echo $TPL_VAR["comm_tax_mny"]?>">          <!-- 과세금액      -->
	<input type="hidden" name="comm_vat_mny"      value="<?php echo $TPL_VAR["comm_vat_mny"]?>">          <!-- 부가세        -->
	<input type="hidden" name="comm_free_mny"     value="<?php echo $TPL_VAR["comm_free_mny"]?>">          <!-- 비과세 금액  -->
<?php }?>
	<!-- 복합과세처리 끝 -->
</form>
</body>
</html>