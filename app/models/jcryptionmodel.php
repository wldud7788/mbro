<?php
require_once APPPATH.'third_party/jcryption/sqAES.php';
require_once APPPATH.'third_party/jcryption/JCryption.php';

class jcryptionmodel extends CI_Model {
	
	protected $jc_obj;
	protected $private_key_file;
	protected $public_key_file;
	
	function __construct() {
		parent::__construct();
		
		$this->private_key_file = 'third_party/jcryption/keys/ssl.gabiafreemall.com.public.pem';
		$this->public_key_file = 'third_party/jcryption/keys/ssl.gabiafreemall.com.private.pem';
		
		$this->jc_obj = new JCryption(APPPATH.$this->private_key_file, APPPATH.$this->public_key_file);
	}
	function getPublicKey(){
		$this->jc_obj->getPublicKey();
	}
	function handshake(){
		$this->jc_obj->handshake();
	}
	
	public function go()
	{
		if (isset($_GET['getPublicKey'])) {
			$this->getPublicKey();
		}
		if (isset($_GET['handshake'])) {
			$this->handshake();
		}
	}
	public function decrypt()
	{
		$this->jc_obj->decrypt();
	}
	
	public function decrypt_key($sKey, $sEnc)
	{
		return $this->jc_obj->decrypt_key($sKey, $sEnc);
	}

}
?>