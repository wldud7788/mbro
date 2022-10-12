<?php
function o2o_readurl($requestUrl,$data='',$binary=false, $timeout=7, $headers='', $http_build=true, $debug=false, $method="POST"){
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt ($ch, CURLOPT_SSLVERSION,1);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt ($ch, CURLOPT_TIMEOUT, $timeout);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	if($file){ // file이 있는 경우 :: 2017-08-21 lwh
		curl_setopt ($ch, CURLOPT_INFILESIZE, $file['size']);
	}
	if($_FILES){ // POST FILES 있는 경우 :: 2018-02-20 lwh
		foreach($_FILES as $column => $file){
			if (!is_array($file['tmp_name'])){
				if (function_exists('curl_file_create')) {
					$data[$column] = curl_file_create($file['tmp_name'],$file['type'],$file['name']);
				}else{
					$tmpname		= $file['tmp_name'];
					$filename		= $file['name'];
					$filetype		= $file['type'];
					$data[$column]	= '@'.$tmpname.';filename='.$filename.';type='.$filetype;
				}

			}
		}
	}

	if($headers){ // 헤더를 보내야 하는경우 :: 2017-08-21 lwh
		foreach($headers as $key => $val){
			$send_header[] = $key . ':' . $val;
		}
		curl_setopt ($ch, CURLOPT_HTTPHEADER, $send_header);
	}
	if($binary){
		curl_setopt ($ch, CURLOPT_BINARYTRANSFER, 1);
	}
	// 별도의 메소드로 readurl 을 호출할 경우, 각 메소드별로 처리 방식이 다를 수 있으므로 추가 할 때마다 수정
	if($method == "GET"){
		curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, $method);
		$requestUrl = $requestUrl."?".http_build_query($data);
		unset($data);
	}elseif($method == "POST"){
		curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, $method);
	}
	if($data){
		if($http_build){ // 기본
			curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		}else{ // http_build 가 전달되지 않는경우 :: 2017-08-21 lwh
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		}
	}
	curl_setopt ($ch, CURLOPT_URL,$requestUrl);
	$result		= curl_exec($ch);
	$httpCode	= curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	if($httpCode == 200){
		return $result;
	}else{
		if($debug){
			$errCode['httpCode']	= $httpCode;
			$errCode['result']		= $result;
			$errCode['info']		= curl_getinfo($ch);
			return $errCode;
		}
	}
	return false;
}

// END
/* End of file readurl_helper.php */
/* Location: ./app/helpers/o2o/readurl_helper.php */