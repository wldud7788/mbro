<?php
define('_IS_SHELL_MODE_', 'Y');
$_THIS_FILE_PATH_		= dirname(__FILE__);

require_once($_THIS_FILE_PATH_	. '/index.php');
error_reporting(E_ALL & ~E_NOTICE);	// E_ALL & ~E_NOTICE