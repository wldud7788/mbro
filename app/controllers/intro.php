<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class intro extends front_base {

	public function main_index()
	{
		redirect("intro/index");
	}

	public function index()
	{
		$this->print_layout($this->template_path());
	}

	/* IP 접속차단 */
	public function denined_ip(){
		$this->print_layout($this->template_path());
	}

	/* 공사중 */
	public function construction(){
		$this->print_layout($this->template_path());
	}

	public function intro_main(){
		$this->session->set_userdata('intro','intro_main');
		$_SESSION['intro'] = "intro_main";
		$this->print_layout($this->template_path());
	}

	/* 회원전용 */
	public function member_only(){

		// return_url 에 http나 https가 있을 경우 외부 도메인으로 보낼 수 없도록 처리 by hed #24462
		block_out_link_return_url();
		
		$this->load->helper('cookie');
		$this->template->assign('idsavechecked',get_cookie('userlogin'));
		
		$this->load->library('snssocial');

		$joinform = $this->snssocial->joinform_usesns();
		if($joinform) $this->template->assign('joinform',$joinform);

		if(preg_match('/board\/view/',$_GET['return_url'])){
			if($_GET['seq']){
				$_GET['return_url'] = $_GET['return_url']."&seq=".$_GET['seq'];
			}
		}
		$this->template->assign('return_url',$_GET['return_url']);
		$this->print_layout($this->template_path());
	}

	/* 성인인증 */
	public function adult_only(){
		// 성인몰 체크
		/*$arrBasic = ($this->config_basic)?$this->config_basic:config_load('basic');
		if($arrBasic['operating']!='adult'){
			echo "<script>alert('잘못된 접근입니다.');location.href='/main';</script>";
			exit;
		}*/

		if($this->userInfo['member_seq']){
			echo js("document.location.replace('/member/adult_auth');");
			exit;
		}

		$this->load->helper('cookie');
		$this->template->assign('idsavechecked',get_cookie('userlogin'));

		$realname = config_load('realname');
		$auth = $this->session->userdata('auth');

		$this->load->library('snssocial');
		$joinform = $this->snssocial->joinform_usesns();
		if($joinform) $this->template->assign('joinform',$joinform);

		if(preg_match('/board\/view/',$_GET['return_url'])){
			if($_GET['seq']){
				$_GET['return_url'] = $_GET['return_url']."&seq=".$_GET['seq'];
			}
		}

		$this->template->assign('return_url',$_GET['return_url']);
		$this->template->assign('realnameinfo',$realname);
		$this->template->assign('realname',$realname['useRealname']);
		$this->template->assign('domain',$this->config_basic['domain']);

		$this->print_layout($this->template_path());
	}

}