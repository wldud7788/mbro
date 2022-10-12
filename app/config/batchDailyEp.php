<?php
$sYearMon               = date('Ym');
$sCronLog        = 'daily_ep_'.$sYearMon.'.log';
$iFuncNum               = 1;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'createDaumFile',
    'sMsg'			=> '입점마켓팅 다음EP 생성',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'createNaverFile',
    'sMsg'			=> '입점마켓팅 네이버EP 2.0 생성',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'createNaverThirdFile',
    'sMsg'			=> '입점마켓팅 네이버EP 3.0 생성',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'createReviewFile',
    'sMsg'			=> '입점마켓팅 리뷰EP 생성',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'createNaverSalesEpFile',
    'sMsg'			=> '입점마켓팅 네이버 판매지수EP 생성',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'createFacebookFile',
    'sMsg'			=> '페이스북 피드 생성',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'createGoogleFile',
    'sMsg'			=> '구글 피드 생성',
    'sLogFile'		=> $sCronLog
);
foreach($aExecFunc as $key => $dataExecFunc) $aExecFunc[$key]['sCfg'] = str_replace(APPPATH.'config/', '', __FILE__);
$config['aExecFunc'] = $aExecFunc;
?>