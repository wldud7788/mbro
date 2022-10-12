<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class event extends front_base {

	public function index() { 
		if(!$_SESSION['user']['member_seq']) { 
			echo "<script type='text/javascript'>
					alert('로그인이 필요한 서비스입니다.');
					location.replace('/member/login?url=/event/');
					</script>";
		} else {  
			$this->print_layout($this->template_path());
		}
	} 

	public function result() { 
		
		$passlist = array(
			'sign' => $_GET['pass']
		);

		$tknlist = array(
			'tkn' => $_GET['tkn']
		);

		$this->template->assign('tkn',$tknlist);
		$this->template->assign('pass',$passlist);

		$this->print_layout($this->template_path());

	} 

	public function process() { 
		// 1. 빈칸 없이 들어왔나 확인 
		$email = $_POST['email'];
		$password = $_POST['password']; 
		$coupon = $_POST['coupon'];

		if($email == '' || $password == '' || $coupon == '') { 
			echo "<script type='text/javascript'>
					alert('빈칸이 있습니다.');
					location.replace('/event/index');
					</script>";
		} 
		
		// 2-0. 회원번호 입력
		$member_seq = $_SESSION['user']['member_seq']; 

		// 쿠폰 번호 확인 
		$this->load->model('eventmodel'); 
		$result2 = $this->eventmodel->eventcode($coupon); 

		if(!$result2) { 
			echo "<script type='text/javascript'>
					alert('존재하지 않는 쿠폰 코드입니다');
					location.replace('/event/index');
				</script>";
			exit; 
		}  
		// 유저코드가 내거, 0 이면 지나가고, 아니면 알림창 띄우기 
		

		if($result2['member_seq'] != $member_seq && $result2['member_seq'] != NULL ) { 
			echo "<script type='text/javascript'>
					alert('이미 사용된 쿠폰번호입니다.');
					location.replace('/event/index');
				</script>";
			exit; 
		} 

		// 2. 아이디, 비번값을 api로 보낸다. 
		
		$this->load->library('apiprocess'); 
		$token = $this->apiprocess->auth($email, $password); 
		$user = $this->apiprocess->userid($token['token']); 
		
		// 3. 계정이 확인되었는지, 되지 않았는지에 따라 분기를 탄다. 
		if($token['message']) { 
			echo "<script type='text/javascript'>
					alert('아이디나 비멀번호가 다릅니다.');
					location.replace('/event/index');
				</script>";
			exit; 
		} 

		// 4. 유저 정보 확인 
		// 4-1. 
		
		$result3 = $this->eventmodel->eventinsert($member_seq, $user['_id'] ,$coupon); 
		
		// 3-3. 계정 확인이 된다면 이용권 이용유무가 있는지 파악한다. 
		if($user) { 
			if($user['ticketExpiredAt']) { 
				redirect('/event/result?pass=NO'); 
				exit; 
			} else { 
				redirect('/event/result?pass=YES'); 
				exit;  
				  
			}  
		} 
		
	} 

	public function movepage() { 
		// 1. 세션에서 회원 조회 
		$member_seq = $_SESSION['user']['member_seq']; 

		// 2. db로드 
		$this->load->model('eventmodel');

		// 3. 내역이 있는지 조회 
		$result = $this->eventmodel->eventsearch($member_seq);
	
		// 4-1. 내역이 없다면, 잘못된 접근 입니다 띄우고 음원 페이지로 그냥 이동 
		if(!$result) { 
			echo "<script type='text/javascript'>
					alert('잘못된 접근입니다.');
					location.replace('https://www.music-brother.com');
				</script>";
			exit; 
		} 

		if($result['use_count'] == '1') { 
			echo "<script type='text/javascript'>
					alert('고객님께선 이미 혜택적용중입니다.');
					location.replace('https://www.music-brother.com');
				</script>";
			exit; 
		} 
		
		// 4-2. 내역이 있다면, 이용권 강제지정을 한다. 
		$this->load->library('apiprocess'); 
		$this->apiprocess->ticket($result['user_id']);

		$this->eventmodel->eventticket($member_seq);
		

		echo "<script type='text/javascript'>
					alert('한달 무료이용권이 적용되었습니다.');
					location.replace('https://www.music-brother.com');
				</script>";
		exit; 
		
	} 
}
?>