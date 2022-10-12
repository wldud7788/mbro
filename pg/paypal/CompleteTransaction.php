<?
	require_once "API_Key.php";
	require_once "SendRequest.php";
   

 	if(! isset($_REQUEST["token"])) {
 
	 header("Location: $url_cancel"); 
	
		 } else {
				
				$token		= urlencode($_REQUEST["token"]); 
				$payerID	= urlencode($_REQUEST["PayerID"]);			
			    			
			//DoExpressCheckoutPayment
		
				
				$currCodeType=urlencode($_REQUEST["currencyCodeType"]);
				$paymentType=urlencode($_REQUEST["paymentType"]);
				$paymentAmount = urlencode($_REQUEST["amt"]);
        		$serverName = urlencode($_SERVER["SERVER_NAME"]);
				
				$nvpstr ="&TOKEN=".$token;
				
				$nvpstr.="&PAYERID=".$payerID; 
				$nvpstr.="&PAYMENTREQUEST_0_PAYMENTACTION=".$paymentType;
				$nvpstr.="&PAYMENTREQUEST_0_AMT=".$paymentAmount;
				$nvpstr.="&PAYMENTREQUEST_0_CURRENCYCODE=".$currCodeType;
				$nvpstr.="&IPADDRESS=".$serverName ;
				
				$itemnum = 0;
				$itemamt = 0.00;
        		for($i=0;$i<count($_REQUEST['L_NAME']);$i++) {  
				$L_NAME	= $_REQUEST["L_NAME"][$i];
				$L_AMT	= $_REQUEST["L_AMT"][$i];
				$L_QTY	= $_REQUEST["L_QTY"][$i];
					if($L_NAME != "" && is_numeric($L_AMT) && is_numeric($L_QTY)&&$L_AMT!=0&&$L_QTY!=0)
					{
					$nvpstr.= "&L_PAYMENTREQUEST_0_NAME".$itemnum."=".urlencode($L_NAME) ;
					$nvpstr.= "&L_PAYMENTREQUEST_0_DESC".$itemnum."=".urlencode($L_NAME) ;		
					$nvpstr.= "&L_PAYMENTREQUEST_0_AMT".$itemnum."=".$L_AMT ;				
					$nvpstr.= "&L_PAYMENTREQUEST_0_QTY".$itemnum."=".$L_QTY ;				
					$itemnum = $itemnum + 1;
					$itemamt = $itemamt + ($L_AMT*$L_QTY);
					}
				}
				
				//$nvpstr.= "&PAYMENTREQUEST_0_ITEMAMT=".(string)$itemamt ;
				
				//$nvpstr.="&PAYMENTREQUEST_0_DESC=Smart phone Black-32G";
				//$nvpstr.="&PAYMENTREQUEST_0_QTY=1";
	
				
				
				$nvpstr = $nvpHeader.$nvpstr;


				$resArray=hash_call("DoExpressCheckoutPayment",$nvpstr);

				$ack = strtoupper($resArray["ACK"]);

					echo "<pre>";
					print_r($_REQUEST);
					print_r($nvpstr);
					print_r($resArray);
				echo "</pre>";
exit;
				if($ack != "SUCCESS" && $ack != "SUCCESSWITHWARNING"){

					$_SESSION["reshash"]=$resArray;
					$location = "APIError.php?flag=DoExpressCheckoutPayment";
						 header("Location: $location");
				}
				else{
					echo 'DoExpressCheckout Completed Successfully: ';
					echo "<pre>";
					print_r($resArray);

					print_r($_SESSION["reshash"]);
					echo "</pre>";

					if($_SESSION["reshash"]['TOKEN'] != $resArray['TOKEN']){

						echo "TOKEN 오류!!";

					}else{
						echo "TOKEN 정상!!";
					}

	
					echo '<a href="index.html">재결제</a>';
					exit;
				}		
				
		 }
			 
?>
			