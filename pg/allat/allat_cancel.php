<?php
  // �þܰ��� �Լ� Include
  //----------------------
  include "./allatutil.php";


  //Request Value Define
  //----------------------
  /********************* Service Code *********************/
  $at_shop_id   = "������ ShopId";       //�����ʿ�
  $at_cross_key = "������ CrossKey";     //�����ʿ�
  /*********************************************************/

  // ��û ������ ����
  //----------------------
  $at_data   = "allat_shop_id=".$at_shop_id.
               "&allat_enc_data=".$_POST["allat_enc_data"].
               "&allat_cross_key=".$at_cross_key;

  // �þ� ���� ������ ��� : CancelReq->����Լ�, $at_txt->�����
  //----------------------------------------------------------------
  $at_txt = CancelReq($at_data,"SSL");

  // ���� ��� �� Ȯ��
  //------------------
  $REPLYCD   =getValue("reply_cd",$at_txt);
  $REPLYMSG  =getValue("reply_msg",$at_txt);

  // ��� ���� '0000'�̸� ������. ��, allat_test_yn=Y �ϰ�� '0001'�� ������.
  // ���� ���   : allat_test_yn=N �� ��� reply_cd=0000 �̸� ����
  // �׽�Ʈ ��� : allat_test_yn=Y �� ��� reply_cd=0001 �̸� ����
  //----------------------------------------------------------------------------------------
  if( !strcmp($REPLYCD,"0000") ){
  // reply_cd "0000" �϶��� ����
    $CANCEL_YMDHMS=getValue("cancel_ymdhms",$at_txt);
    $PART_CANCEL_FLAG=getValue("part_cancel_flag",$at_txt);
    $REMAIN_AMT=getValue("remain_amt",$at_txt);
    $PAY_TYPE=getValue("pay_type",$at_txt);

    echo "����ڵ�    : ".$REPLYCD."<br>";
    echo "����޼���  : ".$REPLYMSG."<br>";
    echo "��ҳ�¥    : ".$CANCEL_YMDHMS."<br>";
    echo "��ұ���    : ".$PART_CANCEL_FLAG."<br>"; //�ſ�ī�� : ���(0),�κ����(1),  ������ü: ���(0), ȯ��(2),�κ�ȯ��(3)
    echo "�ܾ�        : ".$REMAIN_AMT."<br>";
    echo "�ŷ���ı���: ".$PAY_TYPE."<br>";
  }else{
  // reply_cd �� "0000" �ƴҶ��� ���� (�ڼ��� ������ �Ŵ�������)
  // reply_msg �� ���п� ���� �޼���
    echo "����ڵ�    : ".$REPLYCD."<br>";
    echo "����޼���  : ".$REPLYMSG."<br>";
  }
?>