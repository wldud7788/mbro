<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/order/_inicis_mobile.html 000011867 */  $this->include_("defaultScriptFunc");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <meta http-equiv="Cache-Control" content="No-Cache">
    <meta http-equiv="Pragma" content="No-Cache">
    <meta name="viewport" content="width=device-width"/>
<title>INIpayMobile 결제 샘플</title>
<style>
body, tr, td {font-size:10pt; font-family:돋움,verdana; color:#433F37; line-height:19px;}
table, img {border:none}

</style>
<script type="application/x-javascript">

    addEventListener("load", function()
    {
        setTimeout(updateLayout, 0);
    }, false);

    var currentWidth = 0;

    function updateLayout()
    {
        if (window.innerWidth != currentWidth)
        {
            currentWidth = window.innerWidth;

            var orient = currentWidth == 320 ? "profile" : "landscape";
            document.body.setAttribute("orient", orient);
            setTimeout(function()
            {
                window.scrollTo(0, 1);
            }, 100);
        }
    }

    setInterval(updateLayout, 400);

</script>

<script language=javascript type="text/javascript">

var width = 330;
var height = 480;
var xpos = (screen.width - width) / 2;
var ypos = (screen.width - height) / 2;
var position = "top=" + ypos + ",left=" + xpos;
var features = position + ", width=320, height=440";
var date = new Date();
var date_str = "testoid_"+date.getFullYear()+""+date.getMinutes()+""+date.getSeconds();
if( date_str.length != 16 )
{
    for( i = date_str.length ; i < 16 ; i++ )
    {
        date_str = date_str+"0";
    }
}


function on_app()
{
       	var order_form = document.ini;
		var paymethod;
		if(order_form.paymethod.value == "wcard")
			paymethod = "CARD";
		else if(order_form.paymethod.value == "mobile")
			paymethod = "HPP";
		else if(order_form.paymethod.value == "vbank")
			paymethod = "VBANK";
		else if(order_form.paymethod.value == "culture")
			paymethod = "CULT";
		else if(order_form.paymethod.value == "hpmn")
			paymethod = "HPMN";

       	param = "";
       	param = param + "mid=" + order_form.P_MID.value + "&";
       	param = param + "oid=" + order_form.P_OID.value + "&";
       	param = param + "price=" + order_form.P_AMT.value + "&";
       	param = param + "goods=" + order_form.P_GOODS.value + "&";
       	param = param + "uname=" + order_form.P_UNAME.value + "&";
       	param = param + "mname=" + order_form.P_MNAME.value + "&";
       	param = param + "mobile=000-111-2222" + order_form.P_MOBILE.value + "&";
       	param = param + "paymethod=" + paymethod + "&";
       	param = param + "noteurl=" + order_form.P_NOTI_URL.value + "&";
       	param = param + "ctype=1" + "&";
       	param = param + "returl=" + "&";
       	param = param + "email=" + order_form.P_EMAIL.value;
		var ret = location.href="INIpayMobile://" + encodeURI(param);
}

function on_web()
{
	var order_form	= document.ini;
	var paymethod	= order_form.paymethod.value;
	order_form.charset='euc-kr';
	//self.name = "BTPG_WALLET";
	/*
	var wallet = window.open("", "BTPG_WALLET", features);	
	if (wallet == null) 
	{
		if ((webbrowser.indexOf("Windows NT 5.1")!=-1) && (webbrowser.indexOf("SV1")!=-1)) 
		{    // Windows XP Service Pack 2
			alert("팝업이 차단되었습니다. 브라우저의 상단 노란색 [알림 표시줄]을 클릭하신 후 팝업창 허용을 선택하여 주세요.");
		} 
		else 
		{
			alert("팝업이 차단되었습니다.");
		}
		return false;
	}
	wallet.focus();
	order_form.target = "BTPG_WALLET";
	*/
	order_form.target = "_top";
	order_form.action = "https://mobile.inicis.com/smart/" + paymethod + "/";	
	// 이니시스 고도화 테스트 서버 URL
	// order_form.action = "https://stgmobile.inicis.com/smart/" + paymethod + "/";	
	order_form.submit();
}

function onSubmit()
{
	var order_form = document.ini;
	var inipaymobile_type = order_form.inipaymobile_type.value;
	if( inipaymobile_type == "app" )
		return on_app();
	else if( inipaymobile_type == "web" )
		return on_web();
}

</script>
<?php echo defaultScriptFunc()?></head>

<body topmargin="0"  leftmargin="0" marginwidth="0" marginheight="0">
<div style="display:none;">
<form id="form1" name="ini" method="post" action="" accept-charset="euc-kr" >
	<table width="320" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td height="69" align="center" background="/order/images/title_bg.png" style="color:#ffffff; font-size:16px; font-weight:bold;">INIpay Mobile 결제요청</td>
	</tr>
	<tr>
		<td height="347" align="center" valign="top" background="/order/images/bg_01.png"><table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="298" height="296" align="center" background="/order/images/table_bg.png"><table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="95" height="25" align="left" style="background-position:0px 40%; padding-left:8px; font-size:12px; color:#607c90;">방식</td>
				<td align="left">
				<select name="inipaymobile_type" id="select">
					<option value="web">INIpayMobile Web</option>
					<option value="app">INIpayMobile App</option>
				</select>
				</td>
			</tr>
			<tr>
			<td height="25" align="left" style="background-position:0px 40%; padding-left:8px; font-size:12px; color:#607c90;">주문번호</td>
				<td align="left"><input type="hidden" name="P_OID" id="textfield2" value="<?php echo $TPL_VAR["order_seq"]?>" style="border-color:#cdcdcd; border-width:1px; border-style:solid; color:#555555; height:15px;"/></td>
			</tr>
			<tr>
				<td height="25" align="left" style="background-position:0px 40%; padding-left:8px; font-size:12px; color:#607c90;">상품명</td>
				<td align="left"><input type="hidden" name="P_GOODS" value="<?php echo $TPL_VAR["goods_name"]?>" id="textfield3" style="border-color:#cdcdcd; border-width:1px; border-style:solid; color:#555555; height:15px;"/></td>
			</tr>
			<tr>
				<td height="25" align="left" style="background-position:0px 40%; padding-left:8px; font-size:12px; color:#607c90;">가격 </td>
				<td align="left"><input type="hidden" name="P_AMT" value="<?php echo $TPL_VAR["settleprice"]?>" id="textfield4" style="border-color:#cdcdcd; border-width:1px; border-style:solid; color:#555555; height:15px;"/></td>
			</tr>
			<tr>
				<td height="25" align="left" style="background-position:0px 40%; padding-left:8px; font-size:12px; color:#607c90;">부가세 </td>
				<td align="left"><input type="hidden" name="P_TAX" value="<?php echo $TPL_VAR["surtax"]?>" id="textfield4" style="border-color:#cdcdcd; border-width:1px; border-style:solid; color:#555555; height:15px;"/></td>
			</tr>
			<tr>
				<td height="25" align="left" style="background-position:0px 40%; padding-left:8px; font-size:12px; color:#607c90;">비과세 </td>
				<td align="left"><input type="hidden" name="P_TAXFREE" value="<?php echo $TPL_VAR["freeprice"]?>" id="textfield4" style="border-color:#cdcdcd; border-width:1px; border-style:solid; color:#555555; height:15px;"/></td>
			</tr>
			<tr>
				<td height="25" align="left" style="background-position:0px 40%; padding-left:8px; font-size:12px; color:#607c90;">구매자이름</td>
				<td align="left"><input type="hidden" name="P_UNAME" value="<?php echo $TPL_VAR["order_user_name"]?>" id="textfield5" style="border-color:#cdcdcd; border-width:1px; border-style:solid; color:#555555; height:15px;"/></td>
			</tr>
			<tr>
				<td height="25" align="left" style="background-position:0px 40%; padding-left:8px; font-size:12px; color:#607c90;">상점이름 </td>
				<td align="left"><input type="hidden" name="P_MNAME" value="<?php echo iconv('utf-8','euc-kr',$TPL_VAR["config_basic"]["shopName"])?>" id="textfield6" style="border-color:#cdcdcd; border-width:1px; border-style:solid; color:#555555; height:15px;"/></td>
			</tr>
			<tr>
				<td height="25" align="left" style="background-position:0px 40%; padding-left:8px; font-size:12px; color:#607c90;">휴대폰번호</td>
				<td align="left"><input type="hidden" name="P_MOBILE" id="textfield7" value="<?php echo $TPL_VAR["order_cellphone"]?>" style="border-color:#cdcdcd; border-width:1px; border-style:solid; color:#555555; height:15px;"/></td>
			</tr>
			<tr>
				<td height="25" align="left" style="background-position:0px 40%; padding-left:8px; font-size:12px; color:#607c90;">이메일</td>
				<td align="left"><input type="hidden" name="P_EMAIL" value="<?php echo $TPL_VAR["order_email"]?>" id="textfield8" style="border-color:#cdcdcd; border-width:1px; border-style:solid; color:#555555; height:15px;"/></td>
			</tr>
			<tr>
				<td height="25" align="left" style="background-position:0px 40%; padding-left:8px; font-size:12px; color:#607c90;">결제방법 </td>
				<td align="left"><label>
				<select name="paymethod" id="select">				
					
<?php if($TPL_VAR["payment"]=='card'){?>
					<option value="wcard" selected>신용카드 결제</option>
<?php }else{?>
					<option value="wcard">신용카드 결제</option>
<?php }?>				
<?php if($TPL_VAR["payment"]=='account'||$TPL_VAR["payment"]=='escrow_account'){?>
					<option value="bank" selected>계좌이체</option> 
<?php }else{?>
					<option value="bank">계좌이체</option> 
<?php }?>
<?php if($TPL_VAR["payment"]=='cellphone'){?>
					<option value="mobile" selected>핸드폰 결제</option>
<?php }else{?>
					<option value="mobile">핸드폰 결제</option>
<?php }?>
<?php if($TPL_VAR["payment"]=='virtual'||$TPL_VAR["payment"]=='escrow_virtual'){?>
					<option value="vbank" selected>가상계좌 </option>
<?php }else{?>
					<option value="vbank">가상계좌</option>
<?php }?>
				</select>
				</label></td>
			</tr>
			</table></td>
		</tr>
		</table></td>
	</tr>
	</table>
	<input type="hidden" name="P_HPP_METHOD" value="2"> 
	<input type="hidden" name="P_MID" value="<?php echo $TPL_VAR["mallCode"]?>" />
	<input type="hidden" name="P_NOTI" value="<?php echo $TPL_VAR["order_seq"]?>" />	
	<input type="hidden" name="P_NOTI_URL" value="<?=get_connet_protocol()?><?php echo $_SERVER["HTTP_HOST"]?>/inicis_mobile/inicis_rnoti" />
	<input type="hidden" name="P_NEXT_URL" value="<?=get_connet_protocol()?><?php echo $_SERVER["HTTP_HOST"]?>/inicis_mobile/inicis_next" />
	<input type="hidden" name="P_RETURN_URL" value="<?=get_connet_protocol()?><?php echo $_SERVER["HTTP_HOST"]?>/inicis_mobile/popup_return?order_seq=<?php echo $TPL_VAR["order_seq"]?>" />
<?php if($TPL_VAR["inicis_max_quota"]){?>
	<input type="hidden" name="P_QUOTABASE" value="<?php echo $TPL_VAR["inicis_max_quota"]?>">
<?php }?>
<?php if($TPL_VAR["inicis_noint_quota"]){?>
	<input type="hidden" name="P_RESERVED" value="ismart_use_sign=Y&merc_noint=Y&noint_quota=<?php echo $TPL_VAR["inicis_noint_quota"]?>&twotrs_isp=Y&block_isp=Y&twotrs_isp_noti=N&useescrow=<?php echo $TPL_VAR["useescrow"]?>&bank_receipt=N&apprun_check=Y&app_scheme=fm<?php echo $TPL_VAR["config_system"]["shopSno"]?>://" />
<?php }else{?>
	<input type="hidden" name="P_RESERVED" value="ismart_use_sign=Y&twotrs_isp=Y&block_isp=Y&twotrs_isp_noti=N&useescrow=<?php echo $TPL_VAR["useescrow"]?>&bank_receipt=N&apprun_check=Y&app_scheme=fm<?php echo $TPL_VAR["config_system"]["shopSno"]?>://" />
<?php }?>	
<?php if($TPL_VAR["Vcard_date"]){?>
	<input type="hidden" name="P_VBANK_DT" value="<?php echo $TPL_VAR["Vcard_date"]?>">
<?php }?>
	<button onclick="onSubmit()">결제하기</button>
</form>
</div>
<script>onSubmit();</script>
</body>
</html>