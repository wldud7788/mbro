<?php
  // �þܰ��� �Լ� Include
  //----------------------
  include "./allatutil.php";

  //Request Value Define
  //----------------------
  /********************* Service Code *********************/
  $at_cross_key = "������ CrossKey";     //�����ʿ�
  $at_shop_id   = "������ ShopId";       //�����ʿ�
  /*********************************************************/

  // ��û ������ ����
  //----------------------
  $at_data   = "allat_shop_id=".$at_shop_id.
               "&allat_enc_data=".$_POST["allat_enc_data"].
               "&allat_cross_key=".$at_cross_key;

  // �þ� ���� ������ ��� : EscrowChkReq->����Լ�, $at_txt->�����
  //----------------------------------------------------------------
  $at_txt = EscrowRetReq($at_data,"SSL");

  // ���� ��� �� Ȯ��
  //------------------
  $REPLYCD   =getValue("reply_cd",$at_txt);        //����ڵ�
  $REPLYMSG  =getValue("reply_msg",$at_txt);       //��� �޼���

  // ����� ó��
  //--------------------------------------------------------------------------
  // ��� ���� '0000'�̸� ������. ��, allat_test_yn=Y �ϰ�� '0001'�� ������.
  // ���� ����   : allat_test_yn=N �� ��� reply_cd=0000 �̸� ����
  // �׽�Ʈ ���� : allat_test_yn=Y �� ��� reply_cd=0001 �̸� ����
  //--------------------------------------------------------------------------
  if( !strcmp($REPLYCD,"0000") ){
    // reply_cd "0000" �϶��� ����
    echo "����ڵ�             : ".$REPLYCD."<br>";
    echo "����޼���           : ".$REPLYMSG."<br>";
  }else{
    // reply_cd �� "0000" �ƴҶ��� ���� (�ڼ��� ������ �Ŵ�������)
    // reply_msg �� ���п� ���� �޼���
    echo "����ڵ�  : ".$REPLYCD."<br>";
    echo "����޼���: ".$REPLYMSG."<br>";
  }
?>
