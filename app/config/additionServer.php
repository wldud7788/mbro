<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/**
 * 부가서비스 통신서버 설정
*/

// 카카오싱크 중계서버
$active_group = config_load('active_group', 'kakaosync');
$active_group = $active_group['kakaosync'] ?? 'default';

$kakaosync['default'] = [
	'mallApiHost' => 'kakaosync.gabiacns.com',
	'allowServers' => [
		'139.150.79.117'
	]
];

$kakaosync['dev'] = [
	'mallApiHost' => 'dev-kakaosync.gabiacns.com',
	'allowServers' => [
		'139.150.73.87'
	]
];

$config['kakaosync'] = $kakaosync[$active_group];

// 인스타그램 중계서버
$active_group = config_load('active_group', 'instagram');
$active_group = $active_group['instagram'] ?? 'default';

$instagram['default'] = [
	'mallApiHost' => 'apisns.gabiacns.com',
	'allowServers' => [
		'139.150.79.117'
	]
];

$instagram['dev'] = [
	'mallApiHost' => 'dev-kakaosync.gabiacns.com',
	'allowServers' => [
		'139.150.73.87'
	]
];

$config['instagram'] = $instagram[$active_group];
