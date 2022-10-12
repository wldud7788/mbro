<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/common_base".EXT);

class captcha extends common_base {
	
	public function __construct() {
		parent::__construct();
	}

	public function index(){
	}

	public function securimage_show(){
		include_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/Securimage.php";
		$img = new Securimage();
		if (!empty($_GET['namespace'])) $img->setNamespace($_GET['namespace']);
		$img->show();
	}

	public function securimage_play(){
		include_once $_SERVER['DOCUMENT_ROOT']."/app/libraries/Securimage.php";
		$img = new Securimage();
		if (!empty($_GET['namespace'])) $img->setNamespace($_GET['namespace']);
		$img->outputAudioFile();
	}
}
