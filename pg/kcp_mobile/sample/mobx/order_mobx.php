<?
    /* ============================================================================== */
    /* =   PAGE : ���� ��û PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �� �������� �ֹ� �������� ���ؼ� �����ڰ� ���� ��û�� �ϴ� ������        = */
    /* =   �Դϴ�. �Ʒ��� �� �ʼ�, �� �ɼ� �κа� �Ŵ����� �����ϼż� ������        = */
    /* =   �����Ͽ� �ֽñ� �ٶ��ϴ�.                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
    /* =   ���� �ּ� : http://testpay.kcp.co.kr/pgsample/FAQ/search_error.jsp       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2010.05   KCP Inc.   All Rights Reserved.                 = */
    /* ============================================================================== */
?>
<?
	/* ============================================================================== */
    /* =   ȯ�� ���� ���� Include                                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �� �ʼ�                                                                  = */
    /* =   �׽�Ʈ �� �ǰ��� ������ site_conf_inc.php������ �����Ͻñ� �ٶ��ϴ�.     = */
    /* = -------------------------------------------------------------------------- = */

     include "../../cfg/site_conf_inc.php";       // ȯ�漳�� ���� include
?>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   ȯ�� ���� ���� Include END                                               = */
    /* ============================================================================== */
?>
<?
    /* kcp�� ����� kcp �������� ���۵Ǵ� ���� ��û ����*/
    $req_tx          = $_POST[ "req_tx"         ]; // ��û ����          
    $res_cd          = $_POST[ "res_cd"         ]; // ���� �ڵ�          
    $tran_cd         = $_POST[ "tran_cd"        ]; // Ʈ����� �ڵ�      
    $ordr_idxx       = $_POST[ "ordr_idxx"      ]; // ���θ� �ֹ���ȣ    
    $good_name       = $_POST[ "good_name"      ]; // ��ǰ��             
    $good_mny        = $_POST[ "good_mny"       ]; // ���� �ѱݾ�        
    $buyr_name       = $_POST[ "buyr_name"      ]; // �ֹ��ڸ�           
    $buyr_tel1       = $_POST[ "buyr_tel1"      ]; // �ֹ��� ��ȭ��ȣ    
    $buyr_tel2       = $_POST[ "buyr_tel2"      ]; // �ֹ��� �ڵ��� ��ȣ 
    $buyr_mail       = $_POST[ "buyr_mail"      ]; // �ֹ��� E-mail �ּ� 
    $use_pay_method  = $_POST[ "use_pay_method" ]; // ���� ���          
    $enc_info        = $_POST[ "enc_info"       ]; // ��ȣȭ ����        
    $enc_data        = $_POST[ "enc_data"       ]; // ��ȣȭ ������
	
    $tablet_size      = "1.0"; // ȭ�� ������ ���� - ���ȭ�鿡 �°� ����(��������,�����е� - 1.85, ����Ʈ�� - 1.0)

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title>����Ʈ�� �� ����â</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<meta http-equiv="Cache-Control" content="No-Cache">
<meta http-equiv="Pragma" content="No-Cache">

<meta name="viewport" content="width=device-width; user-scalable=<?=$tablet_size?>; initial-scale=<?=$tablet_size?>; maximum-scale=<?=$tablet_size?>; minimum-scale=<?=$tablet_size?>">

<style type="text/css">
	.LINE { background-color:#afc3ff }
	.HEAD { font-family:"����","����ü"; font-size:9pt; color:#065491; background-color:#eff5ff; text-align:left; padding:3px; }
	.TEXT { font-family:"����","����ü"; font-size:9pt; color:#000000; background-color:#FFFFFF; text-align:left; padding:3px; }
	    B { font-family:"����","����ü"; font-size:13pt; color:#065491;}
	INPUT { font-family:"����","����ü"; font-size:9pt; }
	SELECT{font-size:9pt;}
	.COMMENT { font-family:"����","����ü"; font-size:9pt; line-height:160% }
</style>
<!-- �ŷ���� �ϴ� kcp ������ ����� ���� ��ũ��Ʈ-->
<script type="text/javascript" src="../common/approval_key.js"></script>

<script language="javascript">	

   /* �ֹ���ȣ ���� ���� */
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

        document.forms[0].ordr_idxx.value = vOrderID;
    }


    /* kcp web ����â ȣ�� (����Ұ�)*/
    function call_pay_form()
    {
		var v_frm = document.sm_form;

        layer_cont_obj = document.getElementById("content");
        layer_mobx_obj = document.getElementById("layer_mobx");

        layer_cont_obj.style.display = "none";
        layer_mobx_obj.style.display = "block";

        v_frm.target = "frm_mobx";
        v_frm.action = PayUrl;

		if(v_frm.Ret_URL.value == "")
		{
			/* Ret_URL���� �� �������� URL �Դϴ�. */
			alert("������ Ret_URL�� �ݵ�� �����ϼž� �˴ϴ�.");
			return false;
		}
		else
        {
			v_frm.submit();
		}

        v_frm.submit();
    }

	 /* kcp ����� ���� ���� ��ȣȭ ���� üũ �� ���� ��û*/
    function chk_pay()
    {
        /*kcp ������������ ������ �ֹ��������� ������ ���������� ����(����Ұ�)*/
        self.name = "tar_opener";

        var pay_form = document.pay_form;

        if (pay_form.res_cd.value == "3001" )
        {
            alert("����ڰ� ����Ͽ����ϴ�.");
            pay_form.res_cd.value = "";
            return false;
        }
        if (pay_form.enc_data.value != "" && pay_form.enc_info.value != "" && pay_form.tran_cd.value !="" )
        {
            jsf__show_progress(true);
            alert("������ �ϴ��� Ȯ�� ��ư�� ���� �ּ���.");
        }
        else
        {
             jsf__show_progress(false);
             return false;
        }
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
            document.getElementById("show_req_btn") .style.display = 'inline';
        }
    }

    /* ���� ���� ��û*/
    function jsf__pay ()
    {
        var pay_form = document.pay_form;
        pay_form.submit();
    }

</script>
</head>

<body onload="init_orderid();chk_pay();">

<div id="content">
<form name="sm_form" method="POST">

<table border="0" width="100%">
	<tr>
		<td align="center">

			<b style="color:blue">* ����Ʈ�� �޴��� ���� *</b>

		</td>
	</tr>
</table>
<BR>
<table width="50%" border="0" align="center">
<tr>
	<td width="50%" valign="top">
		<table border="0" width="90%" class="LINE" cellspacing="1" cellpadding="1" align="center">
      <tr>
          <td class="TEXT" colspan="2" style="text-align:center"><b>�ֹ� ����</b></td>
      </tr>
      <tr> 
          <td class="HEAD">good_name(��ǰ��)</td>
          <td class="TEXT"><input type="text" name='good_name' maxlength="100" value='������'></td>
      </tr>
      <tr> 
          <td class="HEAD">hp_mny(�����ݾ�)</td>
          <td class="TEXT"><input type="text" name='good_mny' size="9" maxlength="9" value='1004' ></td>
      </tr>
      <tr> 
          <td class="HEAD">buyr_name(�ֹ����̸�)</td>
          <td class="TEXT"><input type="text" name='buyr_name' size="20" maxlength="20" value="ȫ�浿"></td>
      </tr>
      <tr> 
          <td class="HEAD">buyr_tel1(�ֹ��� ����ó)</td>
          <td class="TEXT"><input type="text" name='buyr_tel1' size="20" maxlength="20" value='02-2108-1000'></td>
      </tr>
      <tr> 
          <td class="HEAD">buyr_tel2(�ֹ��� �ڵ��� ��ȣ)</td>
          <td class="TEXT"><input type="text" name='buyr_tel2' size="20" maxlength="20" value='011-1234-5678'></td>
      </tr>
      <tr> 
          <td class="HEAD">buyr_mail(�ֹ��� E-mail)</td>
          <td class="TEXT"><input type="text" name='buyr_mail' size="30" maxlength="30" value='@kcp.co.kr'></td>
      </tr>
		</table>
	</td>
</tr>
</table>

<table width="100%" border="0">
      <tr id='show_req_btn' align="center">
          <td class="TEXT" colspan="2" style="text-align:center">
              <!-- <input type="submit" value="������� ��û��ư"> -->
              <input type="button" name="submitChecked" onClick="kcp_AJAX();" value="������Ͽ�û" />
              <input type="button" name="btn" value="Reload" onClick="javascript:location.reload()">
          </td>
      </tr>
      <tr id='show_progress' style='display:none;'>
          <td class="TEXT" colspan="2" style="text-align:center">�ݵ�� Ȯ�ι�ư�� Ŭ�� �ϼž߸� ������ ����˴ϴ�.</td>
      </tr>
      <tr id='show_pay_btn' align="center" style='display:none;'>
          <td class="TEXT" colspan="2" style="text-align:center">
              <!-- <input type="submit" value="������ư"> -->
              <input type="button" name="btn" onClick="jsf__pay();" value="Ȯ��" />
          </td>
      </tr>
</table>

<!-- �ʼ� ���� -->

<!-- ��û ���� -->
<input type='hidden' name='req_tx'       value='pay'>
<!-- ����Ʈ �ڵ� -->
<input type="hidden" name='site_cd'      value="<?=$g_conf_site_cd?>">
<!-- ����Ʈ Ű -->
<input type='hidden' name='site_key'     value='<?=$g_conf_site_key?>'>
<!-- ��������-->
<input type="hidden" name='pay_method'   value="MOBX">
<!-- �ֹ���ȣ -->
<input type="hidden" name='ordr_idxx'    value="">
<!-- ��ȭ �ڵ� -->
<input type="hidden" name='currency'     value="410">
<!-- ������� Ű -->
<input type="hidden" name='approval_key' id="approval">
<!-- ���� URL (kcp�� ����� ������ ��û�� �� �ִ� ��ȣȭ �����͸� ���� ���� �������� �ֹ������� URL) -->
<!-- �ݵ�� ������ �ֹ��������� URL�� �Է� ���ֽñ� �ٶ��ϴ�. -->
<input type="hidden" name='Ret_URL'      value="">
<!-- ������ �ʿ��� �Ķ����(����Ұ�)-->
<input type="hidden" name='ActionResult' value="mobx">
<!-- ������ �ʿ��� �Ķ����(����Ұ�)-->
<input type="hidden" name='escw_used'    value="N">
<!-- ȭ�� ũ������ �κ� - Start - -->
<input type="text" name='tablet_size'	 value="<?=$tablet_size?>"/>
<!-- ȭ�� ũ������ �κ� - End - -->
</form>
</div>

<!-- ����Ʈ������ KCP ����â�� ���̾� ���·� ����-->
<div id="layer_mobx" style="position:absolute; left:1px; top:1px; width:310;height:400; z-index:1; display:none;">
    <table width="310" border="0" cellspacing="0" cellpadding="0" style="text-align:center">
        <tr>
            <td>
                <iframe name="frm_mobx" frameborder="0" border="0" width="310" height="400" scrolling="auto"></iframe>
            </td>
        </tr>
    </table>
</div>

<form name="pay_form" method="POST" action="../common/pp_ax_hub.php">
    <input type="hidden" name="req_tx"         value="<?=$req_tx?>">      <!-- ��û ����          -->
    <input type="hidden" name="res_cd"         value="<?=$res_cd?>">      <!-- ��� �ڵ�          -->
    <input type="hidden" name="tran_cd"        value="<?=$tran_cd?>">     <!-- Ʈ����� �ڵ�      -->
    <input type="hidden" name="ordr_idxx"      value="<?=$ordr_idxx?>">   <!-- �ֹ���ȣ           -->
    <input type="hidden" name="good_mny"       value="<?=$good_mny?>">    <!-- �޴��� �����ݾ�    -->
    <input type="hidden" name="good_name"      value="<?=$good_name?>">   <!-- ��ǰ��             -->
    <input type="hidden" name="buyr_name"      value="<?=$buyr_name?>">   <!-- �ֹ��ڸ�           -->
    <input type="hidden" name="buyr_tel1"      value="<?=$buyr_tel1?>">   <!-- �ֹ��� ��ȭ��ȣ    -->
    <input type="hidden" name="buyr_tel2"      value="<?=$buyr_tel2?>">   <!-- �ֹ��� �޴�����ȣ  -->
    <input type="hidden" name="buyr_mail"      value="<?=$buyr_mail?>">   <!-- �ֹ��� E-mail      -->
    <input type="hidden" name="enc_info"       value="<?=$enc_info?>">    <!-- ��ȣȭ ����        -->
    <input type="hidden" name="enc_data"       value="<?=$enc_data?>">    <!-- ��ȣȭ ������      -->
    <input type="hidden" name="use_pay_method" value="000010000000">      <!-- ��û�� ���� ����   -->
</form>
</body>
</html>
