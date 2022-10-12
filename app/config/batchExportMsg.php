<?php
$sYearMon       = date('Ym');
$sCronLog       = 'exportMsg_'.$sYearMon.'.log';
$iFuncNum       = 1;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'cron_deposit_mail_sms',
    'sMsg'			=> '누락된 결제확인 메일 SMS',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'cron_export_ready',
    'sMsg'			=> '일괄 실물 출고 준비 메일 SMS',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'cron_export_complete',
    'sMsg'			=> '일괄 실물 출고 완료 메일 SMS',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'cron_complete_ticket',
    'sMsg'			=> '일괄 티켓 출고 완료 메일 SMS',
    'sLogFile'		=> $sCronLog
);
$iFuncNum++;
$aExecFunc[]	= array(
    'sNextIndex'	=> $iFuncNum,
    'sFunctionName'	=> 'batch_send_email',
    'sMsg'			=> '일괄 메일 SMS 발송'
);
foreach($aExecFunc as $key => $dataExecFunc) $aExecFunc[$key]['sCfg'] = str_replace(APPPATH.'config/', '', __FILE__);
$config['aExecFunc'] = $aExecFunc;
?>