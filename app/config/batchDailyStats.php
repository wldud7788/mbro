<?php
$sYearMon           = date('Ym');
$sCronLog           = 'daily_stats_'.$sYearMon.'.log';
$iFuncNum           = 1;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'stats_delete',
    'sMsg'			=> '일일통계 데이터 삭제',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'set_referer_domain',
    'sMsg'			=> 'referer 도메인 업데이트',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'statistic_epc',
    'sMsg'			=> '마일리지, 포인트,캐쉬 통계 집계',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'daily_stats',
    'sMsg'			=> '일일통계 (주문,좋아요,리뷰,재입고알림,찜,장바구니,보기) 집계',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'account_seller_del_sales',
    'sMsg'			=> '불필요한 이월데이터 삭제',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'account_seller_stats',
    'sMsg'			=> '입점사별 정산 집계',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'account_seller_period_update',
    'sMsg'			=> '입점사 정산 주기 변경',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'goods_purchase_ea',
    'sMsg'			=> '상품별 3개월 구매수량 등록',
    'sLogFile'		=> $sCronLog
);
foreach($aExecFunc as $key => $dataExecFunc) $aExecFunc[$key]['sCfg'] = str_replace(APPPATH.'config/', '', __FILE__);
$config['aExecFunc'] = $aExecFunc;
?>