<?php
$sYearMon           = date('Ym');
$sCronLog     = 'daily_remind_'.$sYearMon.'.log';
$iFuncNum					= 1;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'remind_coupon',
    'sMsg'			=> '만료 할인쿠폰 알림',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'remind_emoney',
    'sMsg'			=> '소멸 마일리지 안내',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'remind_cart',
    'sMsg'			=> '장바구니/위시리스트 상품 안내',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'remind_membership',
    'sMsg'			=> '회원등급 혜택 안내',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'remind_timesale',
    'sMsg'			=> '타임세일 종료 상품 안내',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'remind_review',
    'sMsg'			=> '상품 리뷰 작성 안내',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'remind_birthday',
    'sMsg'			=> '생일 축하 안내',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'remind_anniversary',
    'sMsg'			=> '기념일 축하 안내',
    'sLogFile'		=> $sCronLog
);
foreach($aExecFunc as $key => $dataExecFunc) $aExecFunc[$key]['sCfg'] = str_replace(APPPATH.'config/', '', __FILE__);
$config['aExecFunc'] = $aExecFunc;
?>