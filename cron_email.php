<?php
// ---------------------------------------------
// 이메일 발송
// ---------------------------------------------

define('_IS_SHELL_MODE_', 'Y');
$_THIS_FILE_PATH_		= dirname(__FILE__);
require_once($_THIS_FILE_PATH_	. '/index.php');
error_reporting(0);	// E_ALL & ~E_NOTICE

require_once(APPPATH ."controllers/_batch".EXT);
$cronObj	= new _batch();
$cronObj->cron_send_email();
?>