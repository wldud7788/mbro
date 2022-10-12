<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ssl extends CI_Controller {
	/* SSL 중계처리 페이지 */
	public function relay(){
		error_reporting(E_PARSE|E_ERROR);
		$this->load->helper('cookiesecure');
		$action_url = $_GET['action'];
		$encoded = base64_encode(cookieEncode(serialize($_POST), 50));
		echo '
		<form name="sslForm" method="post" action="'.$action_url.'">
			<input type="hidden" name="sslEncodedString" value="'.$encoded.'">
		</form>
		<script language="javascript">
			document.sslForm.submit();
		</script>';
	}

	public function getRSAPublicKey(){
		
		$_GET['getPublicKey'] = true;
		$this->load->model('jcryptionmodel');
		$this->jcryptionmodel->go();
	}

	public function getRSAHandShake(){

		$_GET['handshake'] = true;
		$this->load->model('jcryptionmodel');
		$this->jcryptionmodel->go();
	}
	public function relayRsa(){
		// 암호화 데이터가 있을 경우 디코딩
		if($_POST['jCryption']){
			$this->load->model('jcryptionmodel');
			$this->jcryptionmodel->decrypt();
		}
		
		$base64url_decode_action = base64_decode(str_replace(array('-', '_'), array('+', '/'), $_GET['action']));
		
		error_reporting(E_PARSE|E_ERROR);
		$this->load->helper('cookiesecure');
		$action_url = $base64url_decode_action;
		$encoded = base64_encode(cookieEncode(serialize($_POST), 50));
		echo '
		<form name="sslForm" method="post" action="'.$action_url.'">
			<input type="hidden" name="sslEncodedString" value="'.$encoded.'">
		</form>
		<script language="javascript">
			document.sslForm.submit();
		</script>';
	}
}