<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'DATABASE_USER',
	'password' => 'DATABASE_PASS',
	'database' => 'DATABASE_USER',
	'dbdriver' => 'mysqli',
	'dbprefix' => 'fm_',
	'pconnect' => TRUE,
	'db_debug' => (ENVIRONMENT !== 'production')?true:false,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
