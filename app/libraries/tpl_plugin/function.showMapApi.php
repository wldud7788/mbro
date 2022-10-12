<?php
/* 네이버 맵 출력 */
function showMapApi($width=500, $height=400, $mapAdress=null, $viewName=null, $zoom=3)
{
	$CI			=& get_instance();
	$appKey		= $CI->arrSns['key_k']; //카카오 자바스크립트 앱키
	$maparr		= $CI->config_basic;
	$viewName	= $viewName ? $viewName : $maparr['companyName'];

	if(!$mapAdress){
		if($maparr['companyAddress_street']){
			$mapAdress = $maparr['companyAddress_street'];
		} else {
			$mapAdress = $maparr['companyAddress'];
		}
	}

	if( $zoom <= 0 || $zoom > 14 ){
		$zoom = 3;
	}

	// 사용안 할때는 영역 자체를 안 그리도록 수정
	if($CI->arrSns['use_k']){
		echo "<div id='page-title-bar-area'><div id='showmap' style='width:".$width."px;height:".$height."px;'></div></div>";
		echo "<script type='text/javascript' src='//dapi.kakao.com/v2/maps/sdk.js?appkey=".$appKey."&libraries=services,drawing'></script>";
		echo "<script>
				var mapContainer = document.getElementById('showmap'), // 지도를 표시할 div 
					mapOption = {
						center: new daum.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
						level: ".$zoom.", // 지도의 확대 레벨
						mapTypeId : daum.maps.MapTypeId.ROADMAP // 지도종류
					};  

				var map = new daum.maps.Map(mapContainer, mapOption); 
				var mapTypeControl = new daum.maps.MapTypeControl();
				map.addControl(mapTypeControl, daum.maps.ControlPosition.TOPRIGHT);	
				var zoomControl = new daum.maps.ZoomControl();
				map.addControl(zoomControl, daum.maps.ControlPosition.RIGHT);
				var geocoder = new daum.maps.services.Geocoder();
				geocoder.addressSearch('".$mapAdress."', function(result, status) {
					 if (status === daum.maps.services.Status.OK) {
						var coords = new daum.maps.LatLng(result[0].y, result[0].x);
						var marker = new daum.maps.Marker({
							map: map,
							position: coords
						});

						var infowindow = new daum.maps.InfoWindow({
							content: '<div style=\"width:150px;text-align:center;padding:6px 0;\">".$viewName."</div>'
						});
						infowindow.open(map, marker);
						map.setCenter(coords);
					} 
				});
			</script>";
	}
}
?>