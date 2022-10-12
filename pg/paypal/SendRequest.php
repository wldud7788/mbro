<?php

// hash_call 透過 curl 傳送資?至PayPal並得到結果

function hash_call($methodName,$nvpStr)
{
	
	//declaring of global variables
	//global $API_Endpoint,$version,$API_UserName,$API_Password,$API_Signature,$nvp_Header;

	//setting the curl parameters.
		
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,API_ENDPOINT);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	//turning off the server and peer verification(TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST, 1);

	//check if version is included in $nvpStr else include the version.
	
	if(strlen(str_replace('VERSION=', '', strtoupper($nvpStr))) == strlen($nvpStr)) {
		$nvpStr = "&VERSION=" . urlencode(VERSION) . $nvpStr;
	}

	$nvpreq="METHOD=".urlencode($methodName).$nvpStr;

	//setting the nvpreq as POST FIELD to curl
	curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);

	//getting response from server
	// 從PayPal主機取得結果
	$response = curl_exec($ch);

	//convrting NVPResponse to an Associative Array
		// 將結果?式化為?列
		
	$nvpResArray=deformatNVP($response);
		
	$nvpReqArray=deformatNVP($nvpreq);
		
	$_SESSION['nvpReqArray']=$nvpReqArray;
  
	//debug($response);
	//debug($ch);

	//判?結果是??確

	if (curl_errno($ch)) {
			
		// moving to display page to display curl errors
				  
		$_SESSION['curl_error_no']=curl_errno($ch) ;
				  
		$_SESSION['curl_error_msg']=curl_error($ch);
				  
		$location = "APIError.php?flag=hash_call";

		header("Location: $location");
			 
	} 

	else {
			 
		//closing the curl
					
		curl_close($ch);
		  
	}

	return $nvpResArray;

}



/*
* This function will take NVPString and convert it to an Associative Array and it will decode the response.
  
* It is usefull to search for a particular key and displaying arrays.
  
* @nvpstr is NVPString.
  
* @nvpArray is Associative Array.
  
*/



//將字??式化為?列

function deformatNVP($nvpstr)
{
	
	$intial		= 0;
	$nvpArray	= array();

	while(strlen($nvpstr)){

		//postion of Key
		$keypos= strpos($nvpstr,'=');
		//position of value
		$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

		/*getting the Key and Value values and storing in a Associative Array*/
		$keyval=substr($nvpstr,$intial,$keypos);
		$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);

		//decoding the respose
		$nvpArray[urldecode($keyval)] =urldecode( $valval);
		$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));

	}

	return $nvpArray;

}


?>