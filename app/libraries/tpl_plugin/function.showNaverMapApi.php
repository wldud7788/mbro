<?php
/* 네이버 맵 출력 */
function showNaverMapApi($width="500", $height="400", $mapAdress="", $view_name="", $zoom_use="Y")
{
    $CI =& get_instance();
    $CI->template->include_('showMapApi');
    
    return showMapApi($width, $height, $mapAdress, $view_name);
    
    /*
	$CI =& get_instance();
	$CI->template->include_('showMapApi');

	return showMapApi($width, $height, $mapAdress, $view_name);

	/*
	$CI =& get_instance();
	$maparr = $CI->config_basic;

	$view_name	= ($view_name) ?	$view_name : $maparr['companyName'];
	$id_name = "NaverMap".uniqid();

	if(!$mapAdress)	$addr = urlencode($maparr['companyAddress']." ".$maparr['companyAddressDetail']);
	else			$addr = urlencode($mapAdress);

	$zoom_select	= !empty($maparr['map_client_zoom']) ? $maparr['map_client_zoom'] : 11;

	if	(!$maparr['mapKey'] || $maparr['naverMapKey'] == 'Client'){
		$client_id = $maparr['map_client_id'];
		$client_secret = $maparr['map_client_secret'];
		$ch = curl_init();
		$encoding="utf-8";
		$coord="latlng";
		$output="json";
		$qry_str = "?encoding=".$encoding."&coord=".$coord."&output=".$output."&query=".$addr;
		$headers = array(
			"X-Naver-Client-Id: {$client_id}",
			"X-Naver-Client-Secret: {$client_secret}"
		);
		$url="https://openapi.naver.com/v1/map/geocode";
		curl_setopt($ch, CURLOPT_URL, $url.$qry_str);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res =curl_exec($ch);
		curl_close($ch);
		$ret = json_decode($res, true);

		if ($ret['errorCode'] || !$client_id || !$client_secret)
			return "";

		if	( $ret['result']['items'][0]['point']['x'] )
			$point = array('x'=>$ret['result']['items'][0]['point']['y'], 'y'=>$ret['result']['items'][0]['point']['x']);
		else
			$point = array('x'=>$ret['result']['items']['point']['y'], 'y'=>$ret['result']['items'][0]['point']['x']);

		$returnHTML = "<script type='text/javascript' src='http://openapi.map.naver.com/openapi/v3/maps.js?clientId=".$client_id."'></script>";
		$returnHTML .= "<script type='text/javascript' src='/app/javascript/js/naverMap.js'></script>";
		$returnHTML .= "<div id = '".$id_name."' class='_nmap_mapbox' style='border:1px solid #000; width:".$width."px; height:".$height."px; margin:20px;'></div>";
		$returnHTML .= "<script type='text/javascript'>callMap('".$id_name."','".$point['x']."','".$point['y']."','".$width."','".$height."','".$view_name."','".$zoom_use."', '".$zoom_select."');</script>";
	}else{
		$CI->load->library('SofeeXmlParser');
		$xmlParser = new SofeeXmlParser();
		$key = $maparr['mapKey'];
		$url = "http://openapi.map.naver.com/api/geocode?key=".$key."&encoding=utf-8&coord=latlng&query=".$addr;
		$xmlParser->parseFile($url);
		$tree = $xmlParser->getTree();

		if ($tree['error']['error_code']['value'] == '020' || !$key)
			return "";

		if($tree['geocode']['result']['items']['item'][0]['point']['x']['value']){
			$point = array('y'=>$tree['geocode']['result']['items']['item'][0]['point']['x']['value'], 'x'=>$tree['geocode']['result']['items']['item'][0]['point']['y']['value']);
		}else{
			$point = array('y'=>$tree['geocode']['result']['items']['item']['point']['x']['value'], 'x'=>$tree['geocode']['result']['items']['item']['point']['y']['value']);
		}

		$returnHTML = "<script type='text/javascript' src='http://openapi.map.naver.com/openapi/naverMap.naver?ver=2.0&key=".$key."'></script>";
		$returnHTML .= "<script type='text/javascript' src='/app/javascript/js/naverMap.js'></script>";
		$returnHTML .= "<div id = '".$id_name."' class='_nmap_mapbox' style='border:1px solid #000; width:".$width."px; height:".$height."px; margin:20px;'></div>";
		$returnHTML .= "<script type='text/javascript'>callMap('".$id_name."','".$point['x']."','".$point['y']."','".$width."','".$height."','".$view_name."','".$zoom_use."', '".$zoom_select."');</script>";
	}

	return $returnHTML;
	*/
}
?>