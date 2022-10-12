<?php
/* 상품검색폼 출력*/
function dataInstargram()
{
	//18년 12월 11일 인스타 서비스 종료로 인해 수정 kmj
	//긴급 패치 일자는 18년 12월 04일 이므로 이를 종료 일자로 함
	//종료 후 api 리턴 값을 알 수 없으므로 종료 이후 빈 ul 만 넘기는 것으로 함

	if( date('Ymd') < '20181204' ){
		$CI =& get_instance();
		$CI->load->helper('readurl');

		$aImgName['150']	= 'thumbnail';
		$aImgName['320']	= 'low_resolution';
		$aImgName['640']	= 'standard_resolution';

		$instargramThumb	= config_load('instargramThumb');

		if($instargramThumb['thumSize']=='')	$instargramThumb['thumSize'] = 150;
		if($instargramThumb['thumPdt']=='')		$instargramThumb['thumPdt'] = 0;
		if($instargramThumb['thumPdl']=='')		$instargramThumb['thumPdl'] = 0;
		if($instargramThumb['thumCell']=='')	$instargramThumb['thumCell'] = 1;
		if($instargramThumb['thumRow']=='')		$instargramThumb['thumRow'] = 1;
		if($instargramThumb['thumNumber']=='')	$instargramThumb['thumNumber'] = 1;

		if(!$CI->arrSns['accesstoken_i']) return false;
		$sRequestUrl	= 'https://api.instagram.com/v1/users/self/media/recent/';
		$aParams	= array(
			'access_token'	=> $CI->arrSns['accesstoken_i'],
			'count'			=> $instargramThumb['thumNumber']
		);
		$sRequestUrl .= '?' . http_build_query($aParams);
		$aArticles	= readurl($sRequestUrl, '', false, 3, '', true);
		$aDataJson	= json_decode($aArticles, true);

		$sImgName			= $aImgName[$instargramThumb['thumSize']];
		$iLimit				= $instargramThumb['thumCell'] * $instargramThumb['thumRow'];
		$sTag	= '<ul style="clear:both;">';
		foreach($aDataJson['data'] as $key => $data){
			$iNum	= $key + 1;
			if($iNum > $iLimit) continue ;
			$sTag	.= '<li style="float:left; width:'.$instargramThumb['thumSize'].'px; height:'.$instargramThumb['thumSize'].'px;margin-top:'.$instargramThumb['thumPdt'].'px;margin-left:'.$instargramThumb['thumPdl'].'px;"><a href="'.$data['link'].'" target="_blank"><img src="'.$data['images'][$sImgName]['url'].'"></a></li>';
			if($iNum % $instargramThumb['thumCell'] == 0) $sTag	.= '</ul><ul style="clear:both;">';
		}
		$sTag	.= '</ul>';
	} else {
		$sTag	= '<ul style="clear:both;"></ul>';
	}

	return $sTag;
}
?>