<?php
  // �þܰ��� �Լ� Include
  //----------------------
  include "./allatutil.php";

  //Request Value Define
  //----------------------
  /********************* Service Code *********************/
  $at_cross_key = "������ CrossKey";     //�����ʿ�
  $at_shop_id   = "������ ShopId";       //�����ʿ�
  $at_supply_amt=0;                      //�ݾ��� �ٽ� ����ؼ� ������ ��(��ŷ����) ==> ( session, DB ���)
  $at_vat_amt=0;                         //�ݾ��� �ٽ� ����ؼ� ������ ��(��ŷ����) ==> ( session, DB ���)
  /*********************************************************/

  // ��û ������ ����
  //----------------------
  $at_data   = "allat_shop_id=".$at_shop_id .
               "&allat_supply_amt=".$at_supply_amt.
               "&allat_vat_amt=".$at_vat_amt.
               "&allat_enc_data=".$_POST["allat_enc_data"].
               "&allat_cross_key=".$at_cross_key;


  // �þ� ���� ������ ��� : CashAppReq->����Լ�, $at_txt->�����
  //----------------------------------------------------------------
  $at_txt = CashAppReq($at_data,"SSL");

  // ���� ��� �� Ȯ��
  //------------------
  $REPLYCD   =getValue("reply_cd",$at_txt);
  $REPLYMSG  =getValue("reply_msg",$at_txt);

  // ����� ó��
  //--------------------------------------------------------------------------
  // ��� ���� '0000'�̸� ������. ��, allat_test_yn=Y �ϰ�� '0001'�� ������.
  // ���� ����   : allat_test_yn=N �� ��� reply_cd=0000 �̸� ����
  // �׽�Ʈ ���� : allat_test_yn=Y �� ��� reply_cd=0001 �̸� ����
  //--------------------------------------------------------------------------
  if( !strcmp($REPLYCD,"0000") ){
    // reply_cd "0000" �϶��� ����
    $APPROVAL_NO  =getValue("approval_no",$at_txt);
    $CASH_BILL_NO =getValue("cash_bill_no",$at_txt);

    echo "����ڵ�             : ".$REPLYCD."<br>";
    echo "����޼���           : ".$REPLYMSG."<br>";
    echo "���ι�ȣ             : ".$APPROVAL_NO."<br>";
    echo "���ݿ����� �Ϸ� ��ȣ : ".$CASH_BILL_NO."<br>";
  }else{
    // reply_cd �� "0000" �ƴҶ��� ���� (�ڼ��� ������ �Ŵ�������)
    // reply_msg �� ���п� ���� �޼���
    echo "����ڵ�  : ".$REPLYCD."<br>";
    echo "����޼���: ".$REPLYMSG."<br>";
  }
?>
