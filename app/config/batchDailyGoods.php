<?php
$sYearMon           = date('Ym');
$sCronLog           = 'daily_goods_'.$sYearMon.'.log';
$iFuncNum			= 1;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'social_goods_validate',
    'sMsg'			=> '티켓상품의 모든옵션의 유효기간이 만기시 판매중지',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'delete_tmp_option_data',
    'sMsg'			=> '옵션 임시 데이터 삭제',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'set_goods_event_price',
    'sMsg'			=> '시간대별 이벤트가 추가',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'endOfAutoDisplay',
    'sMsg'			=> '자동노출 종료상품 수동 전환',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'save_scm_ledger_month',
    'sMsg'			=> '수불부 월별 집계',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'truncate_tmp_goods_data',
    'sMsg'			=> '빠른상품등록 임시 데이터 삭제',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'all_category_count',
    'sMsg'			=> '카테고리 연결 수 저장',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'all_brand_count',
    'sMsg'			=> '브랜드 연결 수 저장',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'sort_category_goods',
    'sMsg'			=> '카테고리 상품 정렬 맞춤',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'sort_brand_goods',
    'sMsg'			=> '브랜드 상품 정렬 맞춤',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'sort_location_goods',
    'sMsg'			=> '지역 상품 정렬 맞춤',
    'sLogFile'		=> $sCronLog
);
foreach($aExecFunc as $key => $dataExecFunc) $aExecFunc[$key]['sCfg'] = str_replace(APPPATH.'config/', '', __FILE__);
$config['aExecFunc'] = $aExecFunc;
?>