<?php
require_once "API_Key.php";
require_once "SendRequest.php";


	$currencyCodeType=isset($_REQUEST["currencyCodeType"]) ? ($_REQUEST["currencyCodeType"]) : "";
	  
			
			$serverName = $_SERVER["SERVER_NAME"];
			$serverPort = $_SERVER["SERVER_PORT"];
			$nvpstr="&ORDER_SEQ=".$_REQUEST['order_seq'];
			
	
	
				$itemnum = 0;
				$itemamt = 0.00;
				for($i=0;$i<count($_REQUEST['L_NAME']);$i++) {  
				$L_NAME	= $_REQUEST["L_NAME"][$i];
				$L_AMT	= $_REQUEST["L_AMT"][$i];
				$L_QTY	= $_REQUEST["L_QTY"][$i];
					if($L_NAME != "" && is_numeric($L_AMT) && is_numeric($L_QTY)&&$L_AMT!=0&&$L_QTY!=0)
					{
					$nvpstr.= "&L_PAYMENTREQUEST_0_NAME".$itemnum."=".urlencode($L_NAME) ;	
					$nvpstr.= "&L_PAYMENTREQUEST_0_AMT".$itemnum."=".$L_AMT ;				
					$nvpstr.= "&L_PAYMENTREQUEST_0_QTY".$itemnum."=".$L_QTY ;				
					$itemnum = $itemnum + 1;
					$itemamt = $itemamt + ($L_AMT*$L_QTY);
					}
				}

				$nvpstr.= "&PAYMENTREQUEST_0_ITEMAMT=".(string)$itemamt ;
		
				
				$currencyCodeType=urlencode($currencyCodeType);
				$paymentType="Sale"; 

				$amt = $itemamt;	

				$nvpstr.= "&PAYMENTREQUEST_0_AMT=".(string)$amt ;		
				$nvpstr.= "&PAYMENTREQUEST_0_CURRENCYCODE=".$currencyCodeType ;
				$nvpstr.= "&PAYMENTREQUEST_0_PAYMENTACTION=".$paymentType ;

			    print_r($nvpstr);
	
				$returnURL =urlencode($url_success."?currencyCodeType=".$currencyCodeType."&paymentType=".$paymentType."&amt=".$amt."&L_NAME=".$L_NAME."&L_AMT=".$L_AMT."&L_QTY=".$L_QTY);
			
				$cancelURL =urlencode($url_cancel); 
				$nvpstr.= "&ReturnUrl=".$returnURL ;
				$nvpstr.= "&CANCELURL=".$cancelURL ;
			
				
				$nvpstr = $nvpHeader.$nvpstr;
				
     			
		 	 	$resArray=hash_call("SetExpressCheckout",$nvpstr);
				$_SESSION["reshash"]=$resArray;
		  		$ack = strtoupper($resArray["ACK"]);
		                
		
			   	if($ack=="SUCCESS"){
                                        
					$token		= urldecode($resArray["TOKEN"]);
					$payPalURL	= PAYPAL_URL.$token;

					echo "<br />";
					echo "token : ".$token;

					header("Location: ".$payPalURL);
                                        
				  } else  {
                                         
					 //Redirecting to APIError.php to display errors.

					 $location = "APIError.php?flag=SetExpressCheckout";
						header("Location: $location");
                      echo $resArray["L_ERRORCODE0"]; 
                
					}

?>