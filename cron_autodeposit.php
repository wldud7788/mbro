<?php
// ---------------------------------------------
// 무통장자동입금확인 및 샵링커 주문수집 크론 작업
// ---------------------------------------------

define('_IS_SHELL_MODE_', 'Y');
$_THIS_FILE_PATH_		= dirname(__FILE__);
require_once($_THIS_FILE_PATH_	. '/index.php');
error_reporting(0);	// E_ALL & ~E_NOTICE

require_once(APPPATH ."controllers/_gabia".EXT);
$cronObj	= new _gabia();
$cronObj->autodeposit_cron();
?>