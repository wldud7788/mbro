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
  $at_txt = EscrowConfirmReq($at_data,"SSL");

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
	$ES_CONFIRM_YN=getValue("es_confirm_yn",$at_txt);
	$ES_REJECT=getValue("es_reject",$at_txt);

    echo "����ڵ�    : ".$REPLYCD."<br>";
    echo "����޼���  : ".$REPLYMSG."<br>";
    echo "���Ű���    : ".$ES_CONFIRM_YN."<br>";
    echo "���Űźλ���: ".$ES_REJECT."<br>";
  }else{
  // reply_cd �� "0000" �ƴҶ��� ���� (�ڼ��� ������ �Ŵ�������)
  // reply_msg �� ���п� ���� �޼���
    echo "����ڵ�    : ".$REPLYCD."<br>";
    echo "����޼���  : ".$REPLYMSG."<br>";
  }
?>
