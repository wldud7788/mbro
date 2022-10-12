<?php
$sYearMon	   = date('Ym');
$sCronLog	   = 'daily_etc_'.$sYearMon.'.log';
$iFuncNum	   = 1;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'shop_branch',
	'sMsg'			=> '쇼핑몰 분류 동기화',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'delivery_url',
	'sMsg'			=> '택배사 동기화',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'config_sync',
	'sMsg'			=> 'config 동기화',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'code_sync',
	'sMsg'			=> '코드 동기화',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'eximbay',
	'sMsg'			=> '엑심베이 코드 동기화',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'empty_cart',
	'sMsg'			=> '장바구니 비우기',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'log_email_delete',
	'sMsg'			=> 'email log 삭제',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'log_captcha_delete',
	'sMsg'			=> 'captcha 삭제',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'log_naverpay_delete',
	'sMsg'			=> 'naverpay 삭제',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'delete_excel_temp',
	'sMsg'			=> '엑셀다운로드데이터 삭제',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'kakaotalk_template',
	'sMsg'			=> '카카오알림톡 템플릿 동기화',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'tmp_file_delete',
	'sMsg'			=> '오래된 파일 삭제',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'captcha_file_delete',
	'sMsg'			=> '캡차 파일 삭제',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'delete_flash_cach',
	'sMsg'			=> '플래시 캐시 파일 삭제',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'du_check',
	'sMsg'			=> '사용 용량 업데이트',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'makeCacheActionAert',
	'sMsg'			=> '관리자 중요행위 알림 캐시파일 생성',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'addservice_notify',
	'sMsg'			=> '부가서비스 이슈 알림',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'create_alert_file',
	'sMsg'			=> '언어별 js메시지 파일 생성',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'delete_excel_file',
	'sMsg'			=> '엑셀 파일 삭제',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'delete_caches',
	'sMsg'			=> '서버 캐시파일 삭제',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'sms_national_code',
	'sMsg'			=> 'SMS 국가 코드',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'kicc_code',
	'sMsg'			=> 'KICC 코드 동기화',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'delete_log_files',
	'sMsg'			=> '로그 폴더 삭제',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
	'sFunctionName'	=> 'broadcast_cancel',
	'sMsg'			=> '방송 취소 처리',
	'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
	'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'delete_manager_log',
    'sMsg'			=> '개인정보 관리자 로그 삭제',
	'sLogFile'		=> $sCronLog
);
foreach($aExecFunc as $key => $dataExecFunc) $aExecFunc[$key]['sCfg'] = str_replace(APPPATH.'config/', '', __FILE__);
$config['aExecFunc'] = $aExecFunc;
?>