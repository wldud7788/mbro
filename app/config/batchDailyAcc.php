<?php
$sYearMon           = date('Ym');
$sCronLog    = 'accumul_'.$sYearMon.'.log';
$iFuncNum					= 1;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'accumul_stats_sales',
    'sMsg'			=> '상품 구매 통계',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'accumul_sales_mdstats',
    'sMsg'			=> '매출 구매 통계',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'accumul_sales_refund',
    'sMsg'			=> '환불 구매 통계',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'accumul_sales_category',
    'sMsg'			=> '카테고리/브랜드 구매 통계',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'accumul_cart_stats',
    'sMsg'			=> '장바구니 구매 통계',
    'sLogFile'		=> $sCronLog
);
foreach($aExecFunc as $key => $dataExecFunc) $aExecFunc[$key]['sCfg'] = str_replace(APPPATH.'config/', '', __FILE__);
$config['aExecFunc'] = $aExecFunc;
?>