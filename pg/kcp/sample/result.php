<?
    /* ============================================================================== */
    /* =   PAGE : ��� ó�� PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
	/* =   pp_ax_hub.php ���Ͽ��� ó���� ������� ����ϴ� �������Դϴ�.            = */
	/* = -------------------------------------------------------------------------- = */
    /* =   ������ ������ �߻��ϴ� ��� �Ʒ��� �ּҷ� �����ϼż� Ȯ���Ͻñ� �ٶ��ϴ�.= */
    /* =   ���� �ּ� : http://testpay.kcp.co.kr/pgsample/FAQ/search_error.jsp       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2010.02  KCP Inc.   All Rights Reserved.                  = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* =   ���� ���                                                                = */
    /* = -------------------------------------------------------------------------- = */
    $site_cd          = $_POST[ "site_cd"        ];      // ����Ʈ�ڵ�
	$req_tx           = $_POST[ "req_tx"         ];      // ��û ����(����/���)
    $use_pay_method   = $_POST[ "use_pay_method" ];      // ��� ���� ����
    $bSucc            = $_POST[ "bSucc"          ];      // ��ü DB ����ó�� �Ϸ� ����
    /* = -------------------------------------------------------------------------- = */
    $res_cd           = $_POST[ "res_cd"         ];      // ����ڵ�
    $res_msg          = $_POST[ "res_msg"        ];      // ����޽���
	$res_msg_bsucc    = "";
    /* = -------------------------------------------------------------------------- = */
    $ordr_idxx        = $_POST[ "ordr_idxx"      ];      // �ֹ���ȣ
    $tno              = $_POST[ "tno"            ];      // KCP �ŷ���ȣ
    $good_mny         = $_POST[ "good_mny"       ];      // �����ݾ�
    $good_name        = $_POST[ "good_name"      ];      // ��ǰ��
    $buyr_name        = $_POST[ "buyr_name"      ];      // �����ڸ�
    $buyr_tel1        = $_POST[ "buyr_tel1"      ];      // ������ ��ȭ��ȣ
    $buyr_tel2        = $_POST[ "buyr_tel2"      ];      // ������ �޴�����ȣ
    $buyr_mail        = $_POST[ "buyr_mail"      ];      // ������ E-Mail
    /* = -------------------------------------------------------------------------- = */
	// ����
	$pnt_issue        = $_POST[ "pnt_issue"      ];      // ����Ʈ ���񽺻�
	$app_time         = $_POST[ "app_time"       ];      // ���νð� (����)
	/* = -------------------------------------------------------------------------- = */
    // �ſ�ī��
    $card_cd          = $_POST[ "card_cd"        ];      // ī���ڵ�
    $card_name        = $_POST[ "card_name"      ];      // ī���
	$noinf			  = $_POST[ "noinf"          ];      // ������ ����
	$quota            = $_POST[ "quota"          ];      // �Һΰ���
    $app_no           = $_POST[ "app_no"         ];      // ���ι�ȣ
    /* = -------------------------------------------------------------------------- = */
    // ������ü
    $bank_name        = $_POST[ "bank_name"      ];      // �����
	$bank_code        = $_POST[ "bank_code"      ];      // �����ڵ�
    /* = -------------------------------------------------------------------------- = */
    // �������
    $bankname         = $_POST[ "bankname"       ];      // �Ա��� ����
    $depositor        = $_POST[ "depositor"      ];      // �Ա��� ���� ������
    $account          = $_POST[ "account"        ];      // �Ա��� ���� ��ȣ
	$va_date          = $_POST[ "va_date"        ];      // ������� �Աݸ�������
    /* = -------------------------------------------------------------------------- = */
    // ����Ʈ
    $pt_idno          = $_POST[ "pt_idno"        ];      // ���� �� ���� ���̵�
	$add_pnt          = $_POST[ "add_pnt"        ];      // �߻� ����Ʈ
	$use_pnt          = $_POST[ "use_pnt"        ];      // ��밡�� ����Ʈ
	$rsv_pnt          = $_POST[ "rsv_pnt"        ];      // �� ���� ����Ʈ
	$pnt_app_time     = $_POST[ "pnt_app_time"   ];      // ���νð�
	$pnt_app_no       = $_POST[ "pnt_app_no"     ];      // ���ι�ȣ
	$pnt_amount       = $_POST[ "pnt_amount"     ];      // �����ݾ� or ���ݾ�
	/* = -------------------------------------------------------------------------- = */
	//�޴���
	$commid			  = $_POST[ "commid"		 ];      // ��Ż� �ڵ�
	$mobile_no		  = $_POST[ "mobile_no"      ];      // �޴��� ��ȣ
	/* = -------------------------------------------------------------------------- = */
	//��ǰ��
	$tk_van_code	  = $_POST[ "tk_van_code"    ];      // �߱޻� �ڵ�
	$tk_app_no		  = $_POST[ "tk_app_no"      ];      // ���� ��ȣ
	/* = -------------------------------------------------------------------------- = */
	// ���ݿ�����
	$cash_yn          = $_POST[ "cash_yn"        ];      //���ݿ����� ��� ����
	$cash_authno      = $_POST[ "cash_authno"    ];      //���ݿ����� ���� ��ȣ
	$cash_tr_code     = $_POST[ "cash_tr_code"   ];      //���ݿ����� ���� ����
	$cash_id_info     = $_POST[ "cash_id_info"   ];      //���ݿ����� ��� ��ȣ
	/* = -------------------------------------------------------------------------- = */
	// ����ũ��
    $escw_yn          = $_POST[  "escw_yn"       ];      // ����ũ�� ��� ����
    $deli_term        = $_POST[  "deli_term"     ];      // ��� �ҿ���
    $bask_cntx        = $_POST[  "bask_cntx"     ];      // ��ٱ��� ��ǰ ����
    $good_info        = $_POST[  "good_info"     ];      // ��ٱ��� ��ǰ �� ����
    $rcvr_name        = $_POST[  "rcvr_name"     ];      // ������ �̸�
    $rcvr_tel1        = $_POST[  "rcvr_tel1"     ];      // ������ ��ȭ��ȣ
    $rcvr_tel2        = $_POST[  "rcvr_tel2"     ];      // ������ �޴�����ȣ
    $rcvr_mail        = $_POST[  "rcvr_mail"     ];      // ������ E-Mail
    $rcvr_zipx        = $_POST[  "rcvr_zipx"     ];      // ������ �����ȣ
    $rcvr_add1        = $_POST[  "rcvr_add1"     ];      // ������ �ּ�
    $rcvr_add2        = $_POST[  "rcvr_add2"     ];      // ������ ���ּ�
	/* ============================================================================== */

    $req_tx_name = "";

    if( $req_tx == "pay" )
    {
        $req_tx_name = "����";
    }
    else if( $req_tx == "mod" )
    {
        $req_tx_name = "���/����";
    }

	/* ============================================================================== */
    /* =   ������ �� DB ó�� ���н� �� ��� �޽��� ����                           = */
    /* = -------------------------------------------------------------------------- = */

	if($req_tx == "pay")
	{
		//��ü DB ó�� ����
		if($bSucc == "false")
		{
			if ($res_cd == "0000")
            {
                $res_msg_bsucc = "������ ���������� �̷�������� ��ü���� ���� ����� ó���ϴ� �� ������ �߻��Ͽ� �ý��ۿ��� �ڵ����� ��� ��û�� �Ͽ����ϴ�. <br> ��ü�� �����Ͽ� Ȯ���Ͻñ� �ٶ��ϴ�.";
            }
            else
            {
                $res_msg_bsucc = "������ ���������� �̷�������� ��ü���� ���� ����� ó���ϴ� �� ������ �߻��Ͽ� �ý��ۿ��� �ڵ����� ��� ��û�� �Ͽ�����, <br> <b>��Ұ� ���� �Ǿ����ϴ�.</b><br> ��ü�� �����Ͽ� Ȯ���Ͻñ� �ٶ��ϴ�.";
            }
		}
	}

	/* = -------------------------------------------------------------------------- = */
    /* =   ������ �� DB ó�� ���н� �� ��� �޽��� ���� ��                        = */
    /* ============================================================================== */
?>
    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>*** KCP [AX-HUB Version] ***</title>
    <link href="css/sample.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        /* �ſ�ī�� ������ ���� ��ũ��Ʈ */
        function receiptView(tno)
        {
            receiptWin = "https://admin.kcp.co.kr/Modules/Sale/Card/ADSA_CARD_BILL_Receipt.jsp?c_trade_no=" + tno;
            window.open(receiptWin , "" , "width=420, height=670");
        }

        /* ���ݿ����� ���� ��ũ��Ʈ */
        function receiptView2( site_cd, order_id, bill_yn, auth_no )
        {
        	receiptWin2 = "https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp";
        	receiptWin2 += "?";
        	receiptWin2 += "term_id=PGNW" + site_cd + "&";
        	receiptWin2 += "orderid=" + order_id + "&";
        	receiptWin2 += "bill_yn=" + bill_yn + "&";
        	receiptWin2 += "authno=" + auth_no ;

        	window.open(receiptWin2 , "" , "width=360, height=645");
        }
    </script>
</head>

<body>
    <div align="center">
        <table width="589" cellspacing="0" cellpadding="0">
            <tr style="height:14px"><td style="background-image:url('./img/boxtop589.gif')"></td></tr>
            <tr>
                <td style="background-image:url('./img/boxbg589.gif') " align="center">
                    <table width="551" cellspacing="0" cellpadding="16">
                        <tr style="height:17px">
                            <td style="background-image:url('./img/ttbg551.gif');border:0px " class="white">
                                <span class="bold big">[������]</span> �� �������� ���� ����� ����ϴ� ����(����) �������Դϴ�.
                            </td>
                        </tr>
                        <tr>
                            <td style="background-image:url('./img/boxbg551.gif');" >
                                ���� ����� ����ϴ� ������ �Դϴ�.<br/>
                                ��û�� ���������� ó���� ��� ����ڵ�(res_cd)���� 0000���� ǥ�õ˴ϴ�.
                            </td>
                        </tr>
                        <tr style="height:11px"><td style="background:url('./img/boxbtm551.gif') no-repeat;"></td></tr>
                    </table>
<?
    /* ============================================================================== */
    /* =   ���� ��� �ڵ� �� �޽��� ���(����������� �ݵ�� ������ֽñ� �ٶ��ϴ�.)= */
    /* = -------------------------------------------------------------------------- = */
    /* =   ���� ���� : res_cd���� 0000���� �����˴ϴ�.                              = */
    /* =   ���� ���� : res_cd���� 0000�̿��� ������ �����˴ϴ�.                     = */
    /* = -------------------------------------------------------------------------- = */
?>
                    <table width="85%" align="center" border="0" cellpadding="0" cellspacing="1" class="margin_top_20">
                        <tr><td colspan="2"  class="title">ó�� ���(<?=$req_tx_name ?></td></tr>
                        <!-- ��� �ڵ� -->
                        <tr><td class="sub_title1">����ڵ�</td><td class="sub_content1"><?=$res_cd?></td></tr>
                        <!-- ��� �޽��� -->
                        <tr><td class="sub_title1">��� �޼���</td><td class="sub_content1"><?=$res_msg?></td></tr>
<?
    // ó�� ������(pp_ax_hub.php)���� ������ DBó�� �۾��� ������ ��� �󼼸޽����� ����մϴ�.
    if( !$res_msg_bsucc == "")
    {
?>
                        <tr><td class="sub_title1">��� �� �޼���</td><td class="sub_content1 bold"><?=$res_msg_bsucc?></td></tr>
					</table>
<?
    }
?>

<?
	/* = -------------------------------------------------------------------------- = */
    /* =   ���� ��� �ڵ� �� �޽��� ��� ��                                         = */
    /* ============================================================================== */

	/* ============================================================================== */
    /* =  01. ���� ��� ���                                                        = */
    /* = -------------------------------------------------------------------------- = */
	if ( $req_tx == "pay" )                           // �ŷ� ���� : ����
    {
		/* ============================================================================== */
		/* =  01-1. ��ü DB ó�� ���� (bSucc���� false�� �ƴ� ���)                     = */
        /* = -------------------------------------------------------------------------- = */
		if ( $bSucc != "false" )                      // ��ü DB ó�� ����
        {
			/* ============================================================================== */
			/* =  01-1-1. ���� ������ ���� ��� ��� (res_cd���� 0000�� ���)               = */
		    /* = -------------------------------------------------------------------------- = */
			if ( $res_cd == "0000" )                  // ���� ����
            {
?>
                <table width="85%" align="center" border="0" cellpadding="0" cellspacing="1" class="margin_top_10">
					<tr><td colspan="2"  class="title">�� �� �� ��</td></tr>
                    <!-- �ֹ���ȣ -->
                    <tr><td class="sub_title1">�ֹ���ȣ</td><td class="sub_content1"><?=$ordr_idxx?></td></tr>
                    <!-- KCP �ŷ���ȣ -->
                    <tr><td class="sub_title1">KCP �ŷ���ȣ</td><td class="sub_content1"><?=$tno?></td></tr>
                    <!-- �����ݾ� -->
                    <tr><td class="sub_title1">�����ݾ�</td><td class="sub_content1"><?=$good_mny?>��</td></tr>
                    <!-- ��ǰ��(good_name) -->
                    <tr><td class="sub_title1">��ǰ��</td><td class="sub_content1"><?=$good_name?></td></tr>
                    <!-- �ֹ��ڸ� -->
                    <tr><td class="sub_title1">�ֹ��ڸ�</td><td class="sub_content1"><?=$buyr_name?></td></tr>
                    <!-- �ֹ��� ��ȭ��ȣ -->
                    <tr><td class="sub_title1">�ֹ��� ��ȭ��ȣ</td><td class="sub_content1"><?=$buyr_tel1?></td></tr>
                    <!-- �ֹ��� �޴�����ȣ -->
                    <tr><td class="sub_title1">�ֹ��� �޴�����ȣ</td><td class="sub_content1"><?=$buyr_tel2?></td></tr>
                    <!-- �ֹ��� E-mail -->
                    <tr><td class="sub_title1">�ֹ��� E-mail</td><td class="sub_content1"><?=$buyr_mail?></td></tr>
<?
				/* ============================================================================== */
			    /* =  �ſ�ī�� ������� ���                                                    = */
		        /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "100000000000" )       // �ſ�ī��
                {
?>
                <table width="85%" align="center" cellpadding="0" cellspacing="0" class="margin_top_10">
                    <tr><td colspan="2"  class="title">�ſ�ī�� ����</td></tr>
                    <!-- �������� : �ſ�ī�� -->
                    <tr><td class="sub_title1">��������</td><td class="sub_content1">�ſ�ī��</td></tr>
                    <!-- ���� ī�� -->
                    <tr><td class="sub_title1">����ī��</td><td class="sub_content1"><?=$card_cd?> / <?=$card_name?></td></tr>
                    <!-- ���νð� -->
                    <tr><td class="sub_title1">���νð�</td><td class="sub_content1"><?=$app_time?></td></tr>
                    <!-- ���ι�ȣ -->
                    <tr><td class="sub_title1">���ι�ȣ</td><td class="sub_content1"><?=$app_no?></td></tr>
                    <!-- �Һΰ��� -->
                    <tr><td class="sub_title1">�Һΰ���</td><td class="sub_content1"><?=$quota?></td></tr>
					<!-- �����ڿ��� -->
					<tr><td class="sub_title1">�����ڿ���</td><td class="sub_content1"><?=$noinf?></td></tr>
<?
					/* ============================================================================== */
				    /* =  ���հ���(����Ʈ + �ſ�ī��) ���� ��� ó��                                 = */
		            /* = -------------------------------------------------------------------------- = */
                    if ( $pnt_issue == "SCSK" || $pnt_issue == "SCWB" )
                    {
?>				</table>
				<table width="85%" align="center" cellpadding="0" cellspacing="0" class="margin_top_10">
					<tr><td colspan="2"  class="title">����Ʈ ����</td></tr>
                    <!-- ����Ʈ�� -->
					<tr><td class="sub_title1">����Ʈ��</td><td class="sub_content1"><?=$pnt_issue?></td></tr>
					<!-- ���� �� ���� ���̵� -->
					<tr><td class="sub_title1">���� �� ���� ���̵�</td><td class="sub_content1"><?=$pt_idno?></td></tr>
					<!-- ����Ʈ ���νð� -->
					<tr><td class="sub_title1">����Ʈ ���νð�</td><td class="sub_content1"><?=$pnt_app_time?></td></tr>
					<!-- ����Ʈ ���ι�ȣ -->
					<tr><td class="sub_title1">����Ʈ ���ι�ȣ</td><td class="sub_content1"><?=$pnt_app_no?></td></tr>
					<!-- �����ݾ� or ���ݾ� -->
					<tr><td class="sub_title1">�����ݾ� or ���ݾ�</td><td class="sub_content1"><?=$pnt_amount?></td></tr>
					<!-- �߻� ����Ʈ -->
					<tr><td class="sub_title1">�߻� ����Ʈ</td><td class="sub_content1"><?=$add_pnt?></td></tr>
					<!-- ��밡�� ����Ʈ -->
					<tr><td class="sub_title1">��밡�� ����Ʈ</td><td class="sub_content1"><?=$use_pnt?></td></tr>
					<!-- �� ���� ����Ʈ -->
					<tr><td class="sub_title1">�� ���� ����Ʈ</td><td class="sub_content1"><?=$rsv_pnt?></td></tr>
<?
                    }
					/* ============================================================================== */
				    /* =  �ſ�ī�� ������ ���                                                      = */
		            /* = -------------------------------------------------------------------------- = */
					/*    ���� �ŷ��ǿ� ���ؼ� �������� ��� �� �� �ֽ��ϴ�.                        = */
					/* = -------------------------------------------------------------------------- = */
?>
                    <tr>
						<td class="sub_title1">������ Ȯ��</td>
						<td class="sub_content1"><a href="javascript:receiptView('<?=$tno?>')"><img src="./img/btn_receipt.gif" alt="�������� Ȯ���մϴ�." />
                    </td>
                    <tr><td colspan="2">�� ������ Ȯ���� ���������� ��쿡�� �����մϴ�.</td></tr>
                    <tr class="line2"><td colspan="2" bgcolor="#bbcbdb"></td></tr>
                </table>
<?
                }
                /* ============================================================================== */
                /* =   ������ü ���� ��� ���                                                  = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "010000000000" )       // ������ü
                {
?>
                <table width="85%" align="center" cellpadding="0" cellspacing="0" class="margin_top_10">
                    <tr><td colspan="2"  class="title">������ü ����</td></tr>
                    <!-- �������� : ������ü -->
                    <tr><td class="sub_title1">��������</td><td class="sub_content1">������ü</td></tr>
                    <!-- ��ü���� -->
                    <tr><td class="sub_title1">��ü����</td><td class="sub_content1"><?=$bank_name?></td></tr>
					<!-- ��ü ���� �ڵ� -->
                    <tr><td class="sub_title1">��ü �����ڵ�</td><td class="sub_content1"><?= $bank_code ?></td></tr>
                    <!-- ���νð� -->
                    <tr><td class="sub_title1">���� �ð�</td><td class="sub_content1"><?= $app_time ?></td></tr>
                </table>
<?
                }
			    /* ============================================================================== */
                /* =   ������� ���� ��� ���                                                  = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "001000000000" )       // �������
                {
?>
                    <table width="85%" align="center" cellpadding="0" cellspacing="0" class="margin_top_10">
                    <tr><td colspan="2"  class="title">������� ����</td></tr>
                    <!-- �������� : ������� -->
                    <tr><td class="sub_title1">��������</td><td class="sub_content1">�������</td></tr>
                    <!-- �Ա��� ���� -->
                    <tr><td class="sub_title1">�Ա��� ����</td><td class="sub_content1"><?=$bankname?></td></tr>
					<!-- �Ա��� ���� ������ -->
                    <tr><td class="sub_title1">�Ա��� ���� ������</td><td class="sub_content1"><?=$depositor?></td></tr>
					<!-- �Ա��� ���� ��ȣ -->
                    <tr><td class="sub_title1">�Ա��� ���� ��ȣ</td><td class="sub_content1"><?=$account?></td></tr>
					<!-- ������� �Աݸ����ð� -->
                    <tr><td class="sub_title1">������� �Աݸ����ð�</td><td class="sub_content1"><?=$va_date?></td></tr>
                </table>
<?
                }
				/* ============================================================================== */
                /* =   ����Ʈ ���� ��� ���                                                    = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "000100000000" )         // ����Ʈ
                {
?>
				<table width="85%" align="center" cellpadding="0" cellspacing="0" class="margin_top_10">
                    <tr><td colspan="2"  class="title">����Ʈ ����</td></tr>
                    <!-- �������� : ����Ʈ -->
                    <tr><td class="sub_title1">��������</td><td class="sub_content1">����Ʈ</td></tr>
                    <!-- ����Ʈ�� -->
                    <tr><td class="sub_title1">����Ʈ��</td><td class="sub_content1"><?=$pnt_issue?></td></tr>
					<!-- ���� �� ���� ���̵� -->
					<tr><td class="sub_title1">���� �� ���� ���̵�</td><td class="sub_content1"><?=$pt_idno?></td></tr>
					<!-- ����Ʈ ���νð� -->
                    <tr><td class="sub_title1">����Ʈ ���νð�</td><td class="sub_content1"><?=$pnt_app_time?></td></tr>
					<!-- ����Ʈ ���ι�ȣ -->
                    <tr><td class="sub_title1">����Ʈ ���ι�ȣ</td><td class="sub_content1"><?=$pnt_app_no?></td></tr>
					<!-- �����ݾ� or ���ݾ� -->
                    <tr><td class="sub_title1">�����ݾ� or ���ݾ�</td><td class="sub_content1"><?=$pnt_amount?></td></tr>
					<!-- �߻� ����Ʈ -->
                    <tr><td class="sub_title1">�߻� ����Ʈ</td><td class="sub_content1"><?=$add_pnt?></td></tr>
					<!-- ��밡�� ����Ʈ -->
                    <tr><td class="sub_title1">��밡�� ����Ʈ</td><td class="sub_content1"><?=$use_pnt?></td></tr>
					<!-- �� ���� ����Ʈ -->
                    <tr><td class="sub_title1">�� ���� ����Ʈ</td><td class="sub_content1"><?=$rsv_pnt?></td></tr> 
                </table>
<?
                }
				/* ============================================================================== */
                /* =   �޴��� ���� ��� ���                                                  = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "000010000000" )       // �޴���
                {
?>
                <table width="85%" align="center" cellpadding="0" cellspacing="0" class="margin_top_10">
                    <tr><td colspan="2"  class="title">�޴��� ����</td></tr>
                    <!-- �������� : �޴��� -->
                    <tr><td class="sub_title1">��������</td><td class="sub_content1">�޴���</td></tr>
                    <!-- ���νð� -->
                    <tr><td class="sub_title1">���νð�</td><td class="sub_content1"><?=$app_time?></td></tr>
					<!-- ��Ż��ڵ� -->
                    <tr><td class="sub_title1">��Ż��ڵ�</td><td class="sub_content1"><?=$commid?></td></tr>
					<!-- �޴�����ȣ -->
                    <tr><td class="sub_title1">�޴�����ȣ</td><td class="sub_content1"><?=$mobile_no?></td></tr>
                </table>
<?
                }
			    /* ============================================================================== */
                /* =   ��ǰ�� ���� ��� ���                                                    = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "000000001000" )       // ��ǰ��
                {
?>
                <table width="85%" align="center" cellpadding="0" cellspacing="0" class="margin_top_10">
                    <tr><td colspan="2"  class="title">��ǰ�� ����</td></tr>
                    <!-- �������� : ��ǰ�� -->
                    <tr><td class="sub_title1">��������</td><td class="sub_content1">��ǰ��</td></tr>
                    <!-- �߱޻��ڵ� -->
                    <tr><td class="sub_title1">�߱޻��ڵ�</td><td class="sub_content1"><?=$tk_van_code?></td></tr>
					<!-- ���νð� -->
                    <tr><td class="sub_title1">���νð�</td><td class="sub_content1"><?=$app_time?></td></tr>
					<!-- ���ι�ȣ -->
                    <tr><td class="sub_title1">���ι�ȣ</td><td class="sub_content1"><?=$tk_app_no?></td></tr>
                </table>
<?
                }
                /* -------------------------------------------------------------------------- = */
                /*  ����ũ�� ����                                                             = */
                /* -------------------------------------------------------------------------- = */
                /*  ����ũ�� ��뿩��(escw_yn)���� Y�� ��쿡�� ����ũ�� ������ ǥ�õ˴ϴ�.   = */
                /* -------------------------------------------------------------------------- = */

                If  ( $escw_yn == "Y" )
				{
?>                
                <table width="85%" cellpadding="0" cellspacing="1" class="margin_top_20">
                    <tr><td colspan="2" class="title">�� �� ũ �� �� ��</td></tr>
                    <!-- �ֹ��ڸ� -->
                    <tr><td class="sub_title1">�����θ�</td><td class="sub_content1"><?=$rcvr_name?></td></tr>
                    <!-- �ֹ��� ��ȭ��ȣ -->
                    <tr><td class="sub_title1">������ ��ȭ��ȣ</td><td class="sub_content1"><?=$rcvr_tel1?></td></tr>
                    <!-- �ֹ��� �޴�����ȣ -->
                    <tr><td class="sub_title1">������ �޴�����ȣ</td><td class="sub_content1"><?=$rcvr_tel2?></td></tr>
                    <!-- �ֹ��� E-mail -->
                    <tr><td class="sub_title1">������ E-mail</td><td class="sub_content1"><?=$rcvr_mail?></td></tr>
					<!-- ������ �����ȣ -->
					<tr><td class="sub_title1">������ �����ȣ</td><td class="sub_content1"><?=$rcvr_zipx?></td></tr>
					<!-- ������ �ּ� -->
					<tr><td class="sub_title1">������ �ּ�</td><td class="sub_content1"><?=$rcvr_add1?></td></tr>
					<!-- ������ ���ּ� -->
					<tr><td class="sub_title1">������ ���ּ�</td><td class="sub_content1"><?=$rcvr_add2?></td></tr>
					<!-- ��� �ҿ��� -->
					<tr><td class="sub_title1">��� �ҿ���</td><td class="sub_content1"><?=$deli_term?></td></tr>
                </table>
<?
				}
				/* ============================================================================== */
                /* =  ���ݿ����� ���� ���                                                      = */
                /* = -------------------------------------------------------------------------- = */
				if ( $cash_yn != "" )
				{
?>
				<!-- ���ݿ����� ���� ���-->
                <table width="85%" cellpadding="0" cellspacing="0" class="margin_top_20">
                    <tr><td colspan="2" class="title">���ݿ����� ����</td></tr>
                    <tr><td class="sub_title1">���ݿ����� ��Ͽ���</td><td class="sub_content1"><?=$cash_yn?></td></tr>
<?
					// ���ݿ������� ��ϵ� ��� ���ι�ȣ ���� ����
						if ($cash_authno != "")
						{
?>
						<tr><td class="sub_title1">���ݿ����� ���ι�ȣ</td><td class="sub_content1"><?= $cash_authno ?></td></tr>
						<tr>
                        <td class="sub_title1">������ Ȯ��</td>
                        <td class="sub_content1"><a href="javascript:receiptView2('<?=$site_cd?>','<?=$ordr_idxx ?>', '<?= $cash_yn ?>', '<?= $cash_authno ?>')"><img src="./img/btn_receipt.gif" alt="���ݿ�������  Ȯ���մϴ�." />
                        </td>
                        <tr><td colspan="2">�� ������ Ȯ���� ���������� ��쿡�� �����մϴ�.</td></tr>
	                    <tr class="line2"><td colspan="2" bgcolor="#bbcbdb"></td></tr>
<?
						}
?>
				</table>
<?
				}
			}
			/* = -------------------------------------------------------------------------- = */
            /* =   01-1-1. ���� ������ ���� ��� ��� END                                   = */
            /* ============================================================================== */
        }
		/* = -------------------------------------------------------------------------- = */
        /* =   01-1. ��ü DB ó�� ���� END                                              = */
        /* ============================================================================== */
    }
	/* = -------------------------------------------------------------------------- = */
    /* =   01. ���� ��� ��� END                                                   = */
    /* ============================================================================== */
?>
                <table width="85%" align="center" class="margin_top_10">
					<tr><td style="text-align:center"><a href="../index.html"><img src="./img/btn_home.gif" width="108" height="37" alt="ó������ �̵��մϴ�" /></a></td></tr>
                </table>
                </td>
            </tr>
            <tr><td><img src="./img/boxbtm589.gif" alt="Copyright(c) KCP Inc. All rights reserved."/></td></tr>
		</table>
    </div>
</html>
