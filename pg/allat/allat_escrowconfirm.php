<?php
  // 올앳관련 함수 Include
  //----------------------
  include "./allatutil.php";


  //Request Value Define
  //----------------------
  /********************* Service Code *********************/
  $at_shop_id   = "가맹점 ShopId";       //설정필요
  $at_cross_key = "가맹점 CrossKey";     //설정필요
  /*********************************************************/

  // 요청 데이터 설정
  //----------------------
  $at_data   = "allat_shop_id=".$at_shop_id.
               "&allat_enc_data=".$_POST["allat_enc_data"].
               "&allat_cross_key=".$at_cross_key;

  // 올앳 결제 서버와 통신 : CancelReq->통신함수, $at_txt->결과값
  //----------------------------------------------------------------
  $at_txt = EscrowConfirmReq($at_data,"SSL");

  // 결제 결과 값 확인
  //------------------
  $REPLYCD   =getValue("reply_cd",$at_txt);
  $REPLYMSG  =getValue("reply_msg",$at_txt);

  // 결과 값이 '0000'이면 정상임. 단, allat_test_yn=Y 일경우 '0001'이 정상임.
  // 실제 취소   : allat_test_yn=N 일 경우 reply_cd=0000 이면 정상
  // 테스트 취소 : allat_test_yn=Y 일 경우 reply_cd=0001 이면 정상
  //----------------------------------------------------------------------------------------
  if( !strcmp($REPLYCD,"0000") ){
  // reply_cd "0000" 일때만 성공
	$ES_CONFIRM_YN=getValue("es_confirm_yn",$at_txt);
	$ES_REJECT=getValue("es_reject",$at_txt);

    echo "결과코드    : ".$REPLYCD."<br>";
    echo "결과메세지  : ".$REPLYMSG."<br>";
    echo "구매결정    : ".$ES_CONFIRM_YN."<br>";
    echo "구매거부사유: ".$ES_REJECT."<br>";
  }else{
  // reply_cd 가 "0000" 아닐때는 에러 (자세한 내용은 매뉴얼참조)
  // reply_msg 가 실패에 대한 메세지
    echo "결과코드    : ".$REPLYCD."<br>";
    echo "결과메세지  : ".$REPLYMSG."<br>";
  }
?>
