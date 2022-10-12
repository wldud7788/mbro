<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class coin extends front_base {

    public function __construct() {
        parent::__construct();

        $this->load->model('coinmodel');
        $this->load->library('ciqrcode');
    }

	// 코인 메인 페이지 호출
	public function index()
	{	
		// 바로 아래 main 으로 이동한다. 
		redirect("coin/coin_notice");
	}

	// 코인 메인 페이지에 레이아웃 추가 
	public function main() {
		// view 페이지에 레이아웃 추가
		$this->print_layout($this->template_path());
	}

	public function coin_notice() {
        // 2022.01.20 모델에서 가져오는 것으로 변경
        $coin_row = $this->coinmodel->value();

		$coinlist = array(
			'rate' => $coin_row['rate'],
			'date' => $coin_row['date']
		);

		$this->template->assign('coin',$coinlist);

		// view 페이지에 레이아웃 추가
		$this->print_layout($this->template_path());

	}

	public function loading() {
		// 2022.01.21 $_SESSION => $this->session 으로 변경
        $this->userInfo = $this->session->userdata('user');
        $member_seq = $this->userInfo['member_seq'];

        // 로그인 되지 않은 유저라면 로그인페이지로 이동, 로그인 후 재 방문 요청
        if ($member_seq == NULL) {
            pageRedirect('/member/login', '로그인 후 이용해주세요', 'parent');
            exit;
        }

		$now = date("Ymd"); // 주문시간(현재시간)

        $result = $this->coinmodel->chk_user($member_seq);

		// 이미 저장된 갯수가 있는지 확인
		$count = $result['0']['cnt'];
		
		// 이미 입금기록이 있는 고객이라면 뒤에 1을 붙여서, 해시태그를 다르게 만든다.
		if($count != '0') {
			$count += 1;
		} else { 
			$count = '1';
		}

		/* 2022.01.21 여기까지 작업함! */

		// 코인 주문번호 = 1000 + 고객번호 + 주문시간
		$od_num = $member_seq.$now.$count;

		// MB+유저번호+날짜(년,월,일)+해시(유저아이디)
		// sha256 으로 하면 해시자리수가 맞지 않아 데이터가 보내지지 않음. md5 까지 가능한 것으로 보임 
		$userid = hash('md5',$_SESSION['user']['userid']); // 해시처리한 유저 아이디 
		$member_hash = 'MB'.$member_seq.$now.$userid;

		$this->db->insert("fm_coin",array(
						'od_num' => $od_num,
						'member_seq' => $member_seq,
						'member_hash' => $member_hash,
						'status' => '접수중'
		));

		$coin_url = 'https://shopcoin.musicbrotherss.com/payment?user='.$_SESSION['user']['userid'].'&secret='.$member_hash;
		echo "<script>
			var _width = '500';
			var _height = '700';
		 

			var _left = Math.ceil(( window.screen.width - _width )/2);
			var _top = Math.ceil(( window.screen.width - _height )/6); 
 

			window.open('".$coin_url."','bmp_popup', 'width='+ _width +', height='+ _height +', left=' + _left + ', top='+ _top);

			</script>";

        // 2022.01.21 맨 위에 놓지 않으면 페이지 500에러 발생
        $this->print_layout($this->template_path());
	}

    public function download() {

        $this->load->helper('download');

	    $name = 'BMP_GUIDE.pdf';
	    $type = $this->input->get('type');

	    if ($type=='web') {
            $dir = APPPATH.'coin/bmp_web.pdf';
        } else if ($type=='app'){
            $dir = APPPATH.'coin/bmp_app.pdf';
        }

        //$dir = APPPATH.'coin/bmp_guide.pdf';

        $data = @file_get_contents($dir);
        force_download($name, $data);
	    //$data = @file_get_contents('./'.APPPATH.'/');

    }

    public function event() {
        // 로그인 여부 확인
        // 2022.01.21 $_SESSION => $this->session 으로 변경
        $this->userInfo = $this->session->userdata('user');
        $member_seq = $this->userInfo['member_seq'];


        // 로그인 되지 않은 유저라면 로그인페이지로 이동, 로그인 후 재 방문 요청
        if ($member_seq == NULL) {
            pageRedirect('/member/login', '로그인 후 이용해주세요', 'parent');
            exit;
        }

        // 2022.01.21 맨 위에 놓지 않으면 페이지 500에러 발생
        $this->print_layout($this->template_path());
    }

    public function event_process() {

        // 유저 member_seq 확인
        $this->userInfo = $this->session->userdata('user');
        $member_seq = $this->userInfo['member_seq'];

        $date = date("Y-m-d");

        // 내 계좌 주소에 특문,한글 들어가 있으면 안됨. 영어랑 숫자만
        $name = $this->input->post('name');
        $phone[] = $this->input->post('phone');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $money = $this->input->post('money');

        // 오늘 응모 횟수가 있는지 확인
        /*$seek = $this->coinmodel->search('member_seq', 'fm_coin_event', 'member_seq = '.$member_seq.' AND created_at like "'.$date.'%"');

        if ($seek) {
            pageRedirect('/', '오늘은 이미 응모하셨습니다.', 'parent');
            exit;
        }*/

        if ($money < 20000) {
            pageRedirect('/coin/event', '코인은 최저 2만BMP부터 가능합니다.', 'parent');
            exit;
        }


        $real = $phone[0][0].$phone[0][1].$phone[0][2];

        $real_phone = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $real);
        $real_address = preg_replace("/[^A-Za-z\d]/", "", $address);

        $data = array(
            'member_seq' => $member_seq,
            'name' => $name,
            'phone' => $real_phone,
            'email' => $email,
            'address' => $real_address,
            'money' => $money,
            'user_status' => 'wait',
            'created_at' => date("Y-m-d:H:i:s"),
            'updated_at' => date("Y-m-d:H:i:s")
        );

        $this->coinmodel->insert($data);


        pageRedirect('/', '신청이 완료되었습니다. 평일 최대 24시간 이내, 주말 최대 48시간 이내로 캐시가 지급됩니다.', 'parent');
        exit;
    }

    public function event_update() {

    }
}
?>