<?
    /* ============================================================================== */
    /* =   PAGE : ���� ��û PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �� �������� Payplus Plug-in�� ���ؼ� �����ڰ� ���� ��û�� �ϴ� ������    = */
    /* =   �Դϴ�. �Ʒ��� �� �ʼ�, �� �ɼ� �κа� �Ŵ����� �����ϼż� ������        = */
    /* =   �����Ͽ� �ֽñ� �ٶ��ϴ�.                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
    /* =   ���� �ּ� : http://testpay.kcp.co.kr/pgsample/FAQ/search_error.jsp       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2010.02   KCP Inc.   All Rights Reserved.                 = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* =   ȯ�� ���� ���� Include                                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �� �ʼ�                                                                  = */
    /* =   �׽�Ʈ �� �ǰ��� ������ site_conf_inc.php������ �����Ͻñ� �ٶ��ϴ�.     = */
    /* = -------------------------------------------------------------------------- = */

    include "../cfg/site_conf_inc.php";

    /* = -------------------------------------------------------------------------- = */
    /* =   ȯ�� ���� ���� Include END                                               = */
    /* ============================================================================== */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>*** KCP [AX-HUB Version] ***</title>
    <link href="css/sample.css" rel="stylesheet" type="text/css"/>

<?
    /* ============================================================================== */
    /* =   Javascript source Include                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �� �ʼ�                                                                  = */
    /* =   �׽�Ʈ �� �ǰ��� ������ site_conf_inc.php������ �����Ͻñ� �ٶ��ϴ�.     = */
    /* = -------------------------------------------------------------------------- = */
?>
    <script type="text/javascript" src='<?=$g_conf_js_url?>'></script>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   Javascript source Include END                                            = */
    /* ============================================================================== */
?>
    <script type="text/javascript">
        /* �÷����� ��ġ(Ȯ��) */
        StartSmartUpdate();

        /* Payplus Plug-in ���� */
        function  jsf__pay( form )
        {
            var RetVal = false;

            if( document.Payplus.object == null )
            {
                openwin = window.open( "chk_plugin.html", "chk_plugin", "width=420, height=100, top=300, left=300" );
            }

            /* Payplus Plugin ���� */
            if ( MakePayMessage( form ) == true )
            {
                openwin = window.open( "proc_win.html", "proc_win", "width=449, height=209, top=300, left=300" );
                RetVal = true ;
            }
            
            else
            {
                /*  res_cd�� res_msg������ �ش� �����ڵ�� �����޽����� �����˴ϴ�.
                    ex) ���� Payplus Plugin���� ��� ��ư Ŭ���� res_cd=3001, res_msg=����� ���
                    ���� �����˴ϴ�.
                */
                res_cd  = document.order_info.res_cd.value ;
                res_msg = document.order_info.res_msg.value ;

            }

            return RetVal ;
        }

		// Payplus Plug-in ��ġ �ȳ� 
        function init_pay_button()
        {
            if( document.Payplus.object == null )
                document.getElementById("display_setup_message").style.display = "block" ;
            else
                document.getElementById("display_pay_button").style.display = "block" ;
        }

        /* �ֹ���ȣ ���� ���� */
        function init_orderid()
        {
            var today = new Date();
            var year  = today.getFullYear();
            var month = today.getMonth() + 1;
            var date  = today.getDate();
            var time  = today.getTime();

            if(parseInt(month) < 10) {
                month = "0" + month;
            }

            if(parseInt(date) < 10) {
                date = "0" + date;
            }

            var order_idxx = "TEST" + year + "" + month + "" + date + "" + time;

            document.order_info.ordr_idxx.value = order_idxx;
        }

        /* onLoad �̺�Ʈ �� Payplus Plug-in�� ����ǵ��� �����Ͻ÷��� ������ ������ onLoad �̺�Ʈ�� �־��ֽñ� �ٶ��ϴ�. */
        function onload_pay()
        {
             if( jsf__pay(document.order_info) )
                document.order_info.submit();
        }

		/*����ũ�� ������ �ʿ��� ��ٱ��� ���ÿ��� �Դϴ�.*/
		function create_goodInfo()
        {
			var chr30 = String.fromCharCode(30);	// ASCII �ڵ尪 30
			var chr31 = String.fromCharCode(31);	// ASCII �ڵ尪 31

			var good_info = "seq=1" + chr31 + "ordr_numb=20060310_0001" + chr31 + "good_name=�縻" + chr31 + "good_cntx=2" + chr31 + "good_amtx=1000" + chr30 +
                            "seq=2" + chr31 + "ordr_numb=20060310_0002" + chr31 + "good_name=�Ź�" + chr31 + "good_cntx=1" + chr31 + "good_amtx=1500" + chr30 +
                            "seq=3" + chr31 + "ordr_numb=20060310_0003" + chr31 + "good_name=����" + chr31 + "good_cntx=1" + chr31 + "good_amtx=1000";

          document.order_info.good_info.value = good_info;
        }
    </script>
</head>

<body onload="init_orderid();init_pay_button();create_goodInfo();">

<div align="center">

<!-- �ֹ����� �Է� form : order_info -->
<form name="order_info" method="post" action="./pp_ax_hub.php" >

<?
    /* ============================================================================== */
    /* =   1. �ֹ� ���� �Է�                                                        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ������ �ʿ��� �ֹ� ������ �Է� �� �����մϴ�.                            = */
    /* = -------------------------------------------------------------------------- = */
?>
    <table width="589" cellspacing="0" cellpadding="0">
        <tr style="height:14px"><td style="background-image:url('./img/boxtop589.gif')"></td></tr>
        <tr>
            <td style="background-image:url('./img/boxbg589.gif') " align="center">
                <table width="551" cellspacing="0" cellpadding="16">
                    <tr style="height:17px">
                        <td style="background-image:url('./img/ttbg551.gif');border:0px " class="white">
                            <span class="bold big">[������û]</span> �� �������� ������ ��û�ϴ� ����(����) �������Դϴ�.
                        </td>
                    </tr>
                    <!-- ��� ���� -->
                    <tr>
                        <td style="background-image:url('./img/boxbg551.gif') ;">
                            <p class="align_left">�� �������� ������ ��û�ϴ� �������Դϴ�.</p>
                            <p class="align_left">
                            ���� ������û �������� �����ϰ� �Ǹ� �� ���������� ������ ���� Payplus Plug-in��
                            ���� PC�� ��ġ�Ǿ� �ִ��� Ȯ���մϴ�</p>

                            <p class="align_left">
                            ���� PC�� Payplus Plug-in�� ��ġ���� ���� ���
                            <span class="red bold">������ ����� ����� �˸�ǥ����</span>�̳� �ϴ���
                            <span class="red bold">[������ġ]</span>�� ����
                            <span class="red bold">Payplus Plug-in ��ġ</span>�� �����մϴ�.
                            </p>
                            <p class="align_left">
                            ������û ��ư�� Ŭ���ϰ� �� ��� Payplus Plug-in�� ����Ǹ�
                            Payplus Plug-in�� ���� ������û ������ ��ȣȭ�Ͽ� ������û �������� �����մϴ�.</p>

                            <p class="align_left">
                            <span class="red bold">�� �ʼ�, �� �ɼ�</span>ǥ�ð� ���Ե� ������
                            �������� ��Ȳ�� �°� ������ ���� �����Ͻñ� �ٶ��ϴ�.</p>
                        </td>
                    </tr>
                    <tr style="height:11px"><td style="background:url('./img/boxbtm551.gif') no-repeat;"></td></tr>
                </table>

                <!-- �ֹ����� Ÿ��Ʋ -->
                <table width="527" border="0" cellspacing="0" cellpadding="0" class="margin_top_20">
                    <tr><td colspan="2"  class="title">�ֹ� ����</td></tr>
<?
                    /* ============================================================================== */
                    /* =   1-1. ���� ���� ���� ����                                                 = */
                    /* = -------------------------------------------------------------------------- = */
                    /* =   ������ �ʿ��� ���� ���� ������ �����մϴ�.                               = */
                    /* =                                                                            = */
                    /* =  �ſ�ī�� : 100000000000, ������ü : 010000000000, ������� : 001000000000 = */
                    /* =  ����Ʈ   : 000100000000, �޴���   : 000010000000, ��ǰ��   : 000000001000 = */
                    /* =  ARS      : 000000000010                                                   = */
                    /* =                                                                            = */
                    /* =  ���� ���� ������ ��� PayPlus Plugin���� ������ ���������� ǥ�õ˴ϴ�.    = */
                    /* =  Payplug Plugin���� ���� ���������� ǥ���ϰ� ������ ��� �����Ͻ÷��� ���� = */
                    /* =  ���ܿ� �ش��ϴ� ��ġ�� �ش��ϴ� ���� 1�� �����Ͽ� �ֽʽÿ�.               = */
                    /* =                                                                            = */
                    /* =  ��) �ſ�ī��, ������ü, ������¸� ���ÿ� ǥ���ϰ��� �ϴ� ���            = */
                    /* =  pay_method = "111000000000"                                               = */
                    /* =  �ſ�ī��(100000000000), ������ü(010000000000), �������(001000000000)��  = */
                    /* =  �ش��ϴ� ���� ��� �����ָ� �˴ϴ�.                                       = */
                    /* =                                                                            = */
                    /* = �� �ʼ�                                                                    = */
                    /* =  KCP�� ��û�� �����������θ� ������ �����մϴ�.                            = */
                    /* = -------------------------------------------------------------------------- = */
?>
                    <tr>
                        <td class="sub_title1">���ҹ��</td>
                        <td class="sub_input1">
                            <select name="pay_method" class="frmselect">
                                <option value="100000000000">�ſ�ī��</option>
                                <option value="010000000000">������ü</option>
                                <option value="001000000000">�������</option>
                                <option value="000100000000">����Ʈ</option>
                                <option value="000010000000">�޴���</option>
                                <option value="000000001000">��ǰ��</option>
                                <option value="000000000010">ARS</option>
                                <option value="111000000000">�ſ�ī��/������ü/�������</option>
                            </select>
                        </td>
                    </tr>
                    <!-- �ֹ���ȣ(ordr_idxx) -->
                    <tr>
                        <td class="sub_title1">�ֹ���ȣ</td>
                        <td class="sub_input1"><input type="text" name="ordr_idxx" class="frminput" value="" size="40" maxlength="40"/></td>
                    </tr>
                    <!-- ��ǰ��(good_name) -->
                    <tr>
                        <td class="sub_title1">��ǰ��</td>
                        <td class="sub_input1"><input type="text" name="good_name" class="frminput" value="�ȭ"/></td>
                    </tr>
                    <!-- �����ݾ�(good_mny) - �� �ʼ� : �� ������ ,(�޸�)�� ������ ���ڸ� �Է��Ͽ� �ֽʽÿ�. -->
                    <tr>
                        <td class="sub_title1">�����ݾ�</td>
                        <td class="sub_input1"><input type="text" name="good_mny" class="frminput right" value="1004" size="10" maxlength="9"/>��(���ڸ� �Է�)</td>
                    </tr>
                    <!-- �ֹ��ڸ�(buyr_name) -->
                    <tr>
                        <td class="sub_title1">�ֹ��ڸ�</td>
                        <td class="sub_input1"><input type="text" name="buyr_name" class="frminput" value="ȫ�浿"/></td>
                    </tr>
                    <!-- �ֹ��� E-mail(buyr_mail) -->
                    <tr>
                        <td class="sub_title1">E-mail</td>
                        <td class="sub_input1"><input type="text" name="buyr_mail" class="frminput" value="test@kcp.co.kr" size="30" maxlength="30" /></td>
                    </tr>
                    <!-- �ֹ��� ����ó1(buyr_tel1) -->
                    <tr>
                        <td class="sub_title1">��ȭ��ȣ</td>
                        <td class="sub_input1"><input type="text" name="buyr_tel1" class="frminput" value="02-2108-1000"/></td>
                    </tr>
                    <!-- �޴�����ȣ(buyr_tel2) -->
                    <tr>
                        <td class="sub_title1">�޴�����ȣ</td>
                        <td class="sub_input1"><input type="text" name="buyr_tel2" class="frminput" value="010-0000-0000"/></td>
                    </tr>
                </table>

<?
    /* ============================================================================== */
    /* =   1-2. ����ũ�� ����                                                       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ����ũ�� ����ü�� ����Ǵ� �����Դϴ�.                                 = */
    /* = -------------------------------------------------------------------------- = */
?>				
                <table width="527" border="0" cellspacing="0" cellpadding="0" class="margin_top_20">
                    <tr><td colspan="2"  class="title">�� �� ũ �� �� ��</td></tr>
                    <!-- �����θ�(rcvr_name) -->
                    <tr>
                        <td class="sub_title1">�����θ�</td>
                        <td class="sub_input1"><input type="text" name="rcvr_name" class="frminput" value="ȫ���"/></td>
                    </tr>
                    <!-- ������ ����ó1(rcvr_tel1) -->
                    <tr>
                        <td class="sub_title1">������ ��ȭ��ȣ</td>
                        <td class="sub_input1"><input type="text" name="rcvr_tel1" class="frminput" value="02-2108-1000"/></td>
                    </tr>
                    <!-- ������ �޴�����ȣ(rcvr_tel2) -->
                    <tr>
                        <td class="sub_title1">������ �޴�����ȣ</td>
                        <td class="sub_input1"><input type="text" name="rcvr_tel2" class="frminput" value="010-0000-0000"/></td>
                    </tr>
                    <!-- ������ E-mail(rcvr_mail) -->
                    <tr>
                        <td class="sub_title1">������ E-mail</td>
                        <td class="sub_input1"><input type="text" name="rcvr_mail" class="frminput" value="honggilsoon@kcp.co.kr" size="30" maxlength="30" /></td>
                    </tr>
                    <!-- ������ �����ȣ(rcvr_zipx) -->
                    <tr>
                        <td class="sub_title1">������ �����ȣ</td>
                        <td class="sub_input1"><input type="text" name="rcvr_zipx" class="frminput" value="157864"/></td>
                    </tr>
                    <!-- ������ �ּ�(rcvr_add1) -->
                    <tr>
                        <td class="sub_title1">������ �ּ�</td>
                        <td class="sub_input1"><input type="text" name="rcvr_add1" class="frminput" value="010-0000-0000"/></td>
                    </tr>
                    <tr>
                        <td class="sub_title1">������ ���ּ�</td>
                        <td class="sub_input1"><input type="text" name="rcvr_add2" class="frminput" value="170-5 �츲E-biz����"/></td>
                    </tr>
                </table>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   1-2. ����ũ�� ����  END					                                = */
    /* ============================================================================== */
?>
                <table width="527" border="0" cellspacing="0" cellpadding="0" class="margin_top_10">
                    <!-- ���� ��û/ó������ �̹��� -->
                    <tr style="height:10px"><td></td></tr>
                    <tr id="display_pay_button" style="display:none">
                        <td colspan="2" align="center">
                            <input type="image" src="./img/btn_pay.gif" alt="������ ��û�մϴ�" onclick="return jsf__pay(this.form);"/>
                            <a href="../index.html"><img src="./img/btn_home.gif" width="108" height="37" alt="ó������ �̵��մϴ�" /></a>
                        </td>
                    </tr>
                    <!-- Payplus Plug-in ��ġ �ȳ� -->
                    <tr id="display_setup_message" style="display:none">
                        <td colspan="2" align="center">
                            <span class="red">������ ��� �Ͻ÷��� ����� ����� ǥ������ Ŭ��</span>�Ͻðų�<br/>
                            <a href="http://pay.kcp.co.kr/plugin/file_vista/PayplusWizard.exe"><span class="bold">[������ġ]</span></a>�� ���� Payplus Plug-in�� ��ġ�Ͻñ� �ٶ��ϴ�.<br/>
                            [������ġ]�� ���� ��ġ�Ͻ� ��� <span class="red bold">���ΰ�ħ(F5)Ű</span>�� ���� �����Ͻñ� �ٶ��ϴ�.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td><img src="./img/boxbtm589.gif" alt="Copyright(c) KCP Inc. All rights reserved."/></td></tr>
    </table>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   1. �ֹ� ���� �Է� END                                                    = */
    /* ============================================================================== */
?>

<?
    /* ============================================================================== */
    /* =   2. ������ �ʼ� ���� ����                                                 = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �� �ʼ� - ������ �ݵ�� �ʿ��� �����Դϴ�.                               = */
    /* =   site_conf_inc.php ������ �����ϼż� �����Ͻñ� �ٶ��ϴ�.                 = */
    /* = -------------------------------------------------------------------------- = */
    // ��û���� : ����(pay)/���,����(mod) ��û�� ���
?>
    <input type="hidden" name="req_tx"          value="pay" />
    <input type="hidden" name="site_cd"         value="<?=$g_conf_site_cd	?>" />
    <input type="hidden" name="site_key"        value="<?=$g_conf_site_key  ?>" />
    <input type="hidden" name="site_name"       value="<?=$g_conf_site_name ?>" />

<?
    /*
    �Һοɼ� : Payplus Plug-in���� ī������� �ִ�� ǥ���� �Һΰ��� ���� �����մϴ�.(0 ~ 18 ���� ���� ����)
    �� ����  - �Һ� ������ �����ݾ��� 50,000�� �̻��� ��쿡�� ����, 50000�� �̸��� �ݾ��� �Ͻúҷθ� ǥ��˴ϴ�
               ��) value ���� "5" �� �������� ��� => ī������� ����â�� �ϽúҺ��� 5�������� ���ð���
    */
?>
    <input type="hidden" name="quotaopt"        value="12"/>
    <!-- �ʼ� �׸� : ���� �ݾ�/ȭ����� -->
    <input type="hidden" name="currency"        value="WON"/>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   2. ������ �ʼ� ���� ���� END                                             = */
    /* ============================================================================== */
?>

<?
    /* ============================================================================== */
    /* =   3. Payplus Plugin �ʼ� ����(���� �Ұ�)                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ������ �ʿ��� �ֹ� ������ �Է� �� �����մϴ�.                            = */
    /* = -------------------------------------------------------------------------- = */
?>
    <!-- PLUGIN ���� �����Դϴ�(���� �Ұ�) -->
    <input type="hidden" name="module_type"     value="01"/>
    <!-- ���� ����Ʈ ������ �Ѿ���� ����Ʈ�� �ڵ� : OKĳ����(SCSK), �����Ǿ� ��������Ʈ(SCWB) -->
    <input type="hidden" name="epnt_issu"       value="" />
<?
    /* ============================================================================== */
    /* =   3-1. Payplus Plugin ����ũ�ΰ��� ���� �ʼ� ����                        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ������ �ʿ��� �ֹ� ������ �Է� �� �����մϴ�.                            = */
    /* = -------------------------------------------------------------------------- = */
?>
	<!-- ����ũ�� ��� ���� : �ݵ�� Y �� ���� -->
    <input type="hidden" name="escw_used"       value="Y"/>
	<!-- ����ũ�� ����ó�� ��� : ����ũ��: Y, �Ϲ�: N, KCP ���� ����: O  -->
    <input type="hidden" name="pay_mod"         value="Y"/>
	<!-- ��� �ҿ��� : ���� ��� �ҿ����� �Է� -->
	<input type="hidden"  name="deli_term" value="03"/>
	<!-- ��ٱ��� ��ǰ ���� : ��ٱ��Ͽ� ����ִ� ��ǰ�� ������ �Է�(good_info�� seq�� ����) -->
	<input type="hidden"  name="bask_cntx" value="3"/>
	<!-- ��ٱ��� ��ǰ �� ���� (�ڹ� ��ũ��Ʈ ���� create_goodInfo()�� �·ε� �̺�Ʈ�� �����Ǵ� �κ��Դϴ�.) -->
	<input type="hidden" name="good_info"       value=""/>
   	<!-- ����Ȯ���� ��ü�������� �����Ͻ� ��� "S" �� ����(���� Ȯ�� �� KCP�� ��ϵ� ������ ���������� ��ũó��) -->
    <input type="hidden" name="confirm_type"          value="S" />
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   3-1. Payplus Plugin ����ũ�ΰ��� ���� �ʼ� ����  END                   = */
    /* ============================================================================== */
?>
<!--
      �� �� ��
          �ʼ� �׸� : Payplus Plugin���� ���� �����ϴ� �κ����� �ݵ�� ���ԵǾ�� �մϴ�
          ���� �������� ���ʽÿ�
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

    <!--  ���ݿ����� ���� ���� : Payplus Plugin ���� �����ϴ� �����Դϴ� -->
    <input type="hidden" name="cash_tsdtime"    value=""/>
    <input type="hidden" name="cash_yn"         value=""/>
    <input type="hidden" name="cash_authno"     value=""/>
    <input type="hidden" name="cash_tr_code"    value=""/>
    <input type="hidden" name="cash_id_info"    value=""/>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   3. Payplus Plugin �ʼ� ���� END                                          = */
    /* ============================================================================== */
?>

<?
    /* ============================================================================== */
    /* =   4. �ɼ� ����                                                             = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �� �ɼ� - ������ �ʿ��� �߰� �ɼ� ������ �Է� �� �����մϴ�.             = */
    /* = -------------------------------------------------------------------------- = */

    /* PayPlus���� ���̴� �ſ�ī��� ���� �Ķ���� �Դϴ�
    �� �ش� ī�带 ����â���� ������ �ʰ� �Ͽ� ���� �ش� ī��� ������ �� ������ �մϴ�. (ī��� �ڵ�� �Ŵ����� ����)
    <input type="hidden" name="not_used_card" value="CCPH:CCSS:CCKE:CCHM:CCSH:CCLO:CCLG:CCJB:CCHN:CCCH"/> */

    /* �ſ�ī�� ������ OKĳ���� ���� ���θ� ���� â�� �����ϴ� �Ķ���� �Դϴ�
         OKĳ���� ����Ʈ �������� ��쿡�� â�� �������ϴ�
        <input type="hidden" name="save_ocb"        value="Y"/> */
    
	/* ���� �Һ� ���� �� ����
	       value���� "7" �� �������� ��� => ī������� ����â�� �Һ� 7������ ���ð���
    <input type="hidden" name="fix_inst"        value="07"/> */

	/*  ������ �ɼ�
            �� �����Һ�    (������ ������ �������� ���� �� ������ ������ ������)                             - "" �� ����
            �� �Ϲ��Һ�    (KCP �̺�Ʈ �̿ܿ� ���� �� ��� ������ ������ �����Ѵ�)                           - "N" �� ����
            �� ������ �Һ� (������ ������ �������� ���� �� ������ �̺�Ʈ �� ���ϴ� ������ ������ �����Ѵ�)   - "Y" �� ����
    <input type="hidden" name="kcp_noint"       value=""/> */

    
	/*  ������ ����
            �� ���� 1 : �Һδ� �����ݾ��� 50,000 �� �̻��� ��쿡�� ����
            �� ���� 2 : ������ �������� ������ �ɼ��� Y�� ��쿡�� ���� â�� ����
            ��) �� ī�� 2,3,6���� ������(����,��,����,�Ｚ,����,����,�Ե�,��ȯ) : ALL-02:03:04
            BC 2,3,6����, ���� 3,6����, �Ｚ 6,9���� ������ : CCBC-02:03:06,CCKM-03:06,CCSS-03:06:04
    <input type="hidden" name="kcp_noint_quota" value="CCBC-02:03:06,CCKM-03:06,CCSS-03:06:09"/> */

    
	/*  ������� ���� ���� �Ķ����
         �� �ش� ������ ����â���� ���̰� �մϴ�.(�����ڵ�� �Ŵ����� ����) */
?>
    <input type="hidden" name="wish_vbank_list" value="05:03:04:07:11:23:26:32:34:81:71"/>
<?
    
	
	/*  ������� �Ա� ���� �����ϴ� �Ķ���� - �߱��� + 3��
    <input type="hidden" name="vcnt_expire_term" value="3"/> */

    /*  ������� �Ա� �ð� �����ϴ� �Ķ����
         HHMMSS�������� �Է��Ͻñ� �ٶ��ϴ�
         ������ ���Ͻô°�� �⺻������ 23��59��59�ʰ� ������ �˴ϴ�
         <input type="hidden" name="vcnt_expire_term_time" value="120000"/> */


    /* ����Ʈ ������ ���� ����(�ſ�ī��+����Ʈ) ���θ� ������ �� �ֽ��ϴ�.- N �ϰ�� ���հ��� ������
        <input type="hidden" name="complex_pnt_yn" value="N"/>    */

	/* ��ȭ��ǰ�� ������ ������ �� ���̵� ������ �ؾ� �մϴ�.(�ʼ� ����)
	    <input type="hidden" name="tk_shop_id" value=""/>    */
    
	/* ���ݿ����� ��� â�� ��� ���θ� �����ϴ� �Ķ���� �Դϴ�
         �� Y : ���ݿ����� ��� â ���
         �� N : ���ݿ����� ��� â ��� ����
		 �� ���� : ���ݿ����� ��� �� KCP ���������� ���������� ���ݿ����� ��� ���Ǹ� �ϼž� �մϴ� */
?>
    <input type="hidden" name="disp_tax_yn"     value="Y"/>
<?
    /* ����â�� ������ ����Ʈ�� �ΰ� �÷����� ���� ��ܿ� ����ϴ� �Ķ���� �Դϴ�
       ��ü�� �ΰ� �ִ� URL�� ��Ȯ�� �Է��ϼž� �ϸ�, �ִ� 150 X 50  �̸� ũ�� ����

	�� ���� : �ΰ� �뷮�� 150 X 50 �̻��� ��� site_name ���� ǥ�õ˴ϴ�. */
?>
    <input type="hidden" name="site_logo"       value="" />
<?
	/* ����â ���� ǥ�� �Ķ���� �Դϴ�. ������ �⺻���� ����Ͻ÷��� Y�� �����Ͻñ� �ٶ��ϴ�
		2010-06�� ���� �ſ�ī��� ������¸� �����˴ϴ�
		<input type='hidden' name='eng_flag'      value='Y'> */
?>

<?
	/* KCP�� ������ǰ�� �������ǰ�� ���ÿ� �Ǹ��ϴ� ��ü���� ���������� ���� ���Ǽ��� �����ص帮����, 
	   ���հ��� ���� ����Ʈ�ڵ带 ������ �帮�� �� �ݾ׿� ���� ���հ��� ó���� �����ϵ��� �����ϰ� �ֽ��ϴ�
	
	   ���հ��� ���� ����Ʈ �ڵ�� ����Ͻ� ���������� �ش��� �˴ϴ�
    
	   ��ǰ���� �ƴ϶� �ݾ����� �����Ͽ� ��û�ϼž� �մϴ�
	
	   �Ѱ��� �ݾ��� �����ݾ� + �ΰ��� + ������ݾ��� �հ� ���ƾ� �մϴ�. 
	   (good_mny = comm_tax_mny + comm_vat_mny + comm_free_mny)

	   <input type="hidden" name="tax_flag"          value="TG03">     <!-- ����Ұ�    -->
	   <input type="hidden" name="comm_tax_mny"	     value="">         <!-- �����ݾ�    --> 
       <input type="hidden" name="comm_vat_mny"      value="">         <!-- �ΰ���	    -->
	   <input type="hidden" name="comm_free_mny"     value="">         <!-- ����� �ݾ� -->  
	   
	   skin_indx ���� ��Ų�� ������ �� �ִ� �Ķ�����̸� �� 7������ �����˴ϴ�. 
	   ������ ���Ͻø� 1���� 7���� ���� �־��ֽñ� �ٶ��ϴ�. */
?>
    <input type='hidden' name='skin_indx'      value='1'>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   4. �ɼ� ���� END                                                         = */
    /* ============================================================================== */
?>
</form>
</div>
</body>
</html>