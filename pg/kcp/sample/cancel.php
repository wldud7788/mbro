<?
    /* ============================================================================== */
    /* =   PAGE : ��� ��û PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �Ʒ��� �� ���� �� �κ��� �� �����Ͻÿ� ������ �����Ͻñ� �ٶ��ϴ�.       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
    /* =   ���� �ּ� : http://testpay.kcp.co.kr/pgsample/FAQ/search_error.jsp       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2010.02   KCP Inc.   All Rights Reserved.                 = */
    /* ============================================================================== */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>*** [AX-HUB Version] ***</title>
    <link href="css/sample.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript">
    /* ��� ��ư�� ������ �� ȣ�� */
    function  jsf__go_cancel( form )
    {
        var RetVal = false ;
        if ( form.tno.value.length < 14 )
        {
            alert( "KCP �ŷ� ��ȣ�� �Է��ϼ���" );
            form.tno.focus();
            form.tno.select();
        }
        else
        {
            openwin = window.open( "proc_win.html", "proc_win", "width=449, height=209, top=300, left=300" );
            RetVal = true ;
        }
        return RetVal ;
    }
    </script>
</head>

<body>

<div align="center">
<?
    /* ============================================================================== */
    /* =   1. ��� ��û ���� �Է� ��(cancel_info)                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ��� ��û�� �ʿ��� ������ �����մϴ�.                                    = */
    /* = -------------------------------------------------------------------------- = */
?>
    <form name="cancel_info" method="post" action="pp_ax_hub.php">

    <table width="589" cellspacing="0" cellpadding="0">
        <tr style="height:14px"><td style="background-image:url('./img/boxtop589.gif')"></td></tr>
        <tr>
            <td style="background-image:url('./img/boxbg589.gif')" align="center">

                <!-- ��� ���̺� Start -->
                <table width="551" cellspacing="0" cellpadding="16">
                    <tr style="height:17px">
                        <td style="background-image:url('./img/ttbg551.gif');" class="white">
                            <span class="bold big">[��ҿ�û]</span> �� �������� �����ǿ� ���� ��Ҹ� ��û�ϴ� ����(����) �������Դϴ�.
                        </td>
                    </tr>
                    <tr>
                        <td style="background-image:url('./img/boxbg551.gif') ;">
                            <p class="align_left">�ҽ� ���� �� �ҽ� �ȿ� <span class="red bold">�� ���� ��</span>ǥ�ð� ���Ե� ������
                            �������� ��Ȳ�� �°� ������ ���� �����Ͻñ� �ٶ��ϴ�.</p>
                            <p class="align_left">�� �������� ������ �ǿ� ���� ��Ҹ� ��û�ϴ� ������ �Դϴ�.</p>
                            <p class="align_left">
                            ������ ���εǸ� ��������� KCP �ŷ���ȣ(tno)���� ������ �� �ֽ��ϴ�..<br/>
                            ������������ �� KCP �ŷ���ȣ(tno)������ ��ҿ�û�� �Ͻ� �� �ֽ��ϴ�.</p>
                        </td>
                    </tr>
                    <tr style="height:11px"><td style="background:url('./img/boxbtm551.gif') no-repeat;"></td></tr>
                </table>
                <!-- ��� ���̺� End -->

                <!-- ��� ��û ���� �Է� ���̺� Start -->
                <table width="527" cellspacing="0" cellpadding="0" class="margin_top_20">
                    <tr><td colspan="2" class="title">��� ��û ����</td></tr>
                    <!-- ��û ���� : ��� -->
                    <tr>
                        <td class="sub_title1">��û ����</td>
                        <td class="sub_content1 bold">��� ��û</td>
                    </tr>
                    <!-- Input : ������ ���� �ŷ���ȣ(14 byte) �Է� -->
                    <tr>
                        <td class="sub_title1">KCP �ŷ���ȣ</td>
                        <td class="sub_input1"><input type="text" name="tno" value=""  class="frminput" size="20" maxlength="14"/></td>
                    </tr>
                    <!-- Input : ���� ����(mod_desc) �Է� -->
                    <tr>
                        <td class="sub_title1">���� ����</td>
                        <td class="sub_input1"><input type="text" name="mod_desc" value="" class="frminput" size="30" maxlength="50"/></td>
                    </tr>
                </table>
                <!-- ��� ��û ���� �Է� ���̺� End -->

                <!-- ��û ��ư ���̺� Start -->
                <table width="527" cellspacing="0" cellpadding="0" class="margin_top_20">
                    <!-- ��� ��û/ó������ �̹��� ��ư -->
                    <tr>
                        <td colspan="2" align="center">
                            <input type="image" src="./img/btn_cancel.gif" onclick="return jsf__go_cancel(this.form);" style="width:108;height:37;" alt="��Ҹ� ��û�մϴ�" />
                            <a href="../index.html"><img src="./img/btn_home.gif" width="108" height="37" alt="ó������ �̵��մϴ�" /></a>
                        </td>
                    </tr>
                </table>
                <!-- ��û ��ư ���̺� End -->
            </td>
        </tr>
        <tr><td><img src="./img/boxbtm589.gif" alt="Copyright(c) KCP Inc. All rights reserved."/></td></tr>
    </table>

<?
    /* ============================================================================== */
    /* =   1-1. ��� ��û �ʼ� ���� ����                                            = */
    /* = -------------------------------------------------------------------------- = */
    /* =   �� �ʼ� - �ݵ�� �ʿ��� �����Դϴ�.                                      = */
    /* = -------------------------------------------------------------------------- = */
?>
        <input type="hidden" name="req_tx"   value="mod"  />
        <input type="hidden" name="mod_type" value="STSC" />
    </form>
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   1. ��� ��û ���� END                                                    = */
    /* ============================================================================== */
?>
</div>
</body>
</html>
