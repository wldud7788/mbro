<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class server extends front_base {
/*
	public function password() {
		// 쿼리로 받아온 것 설정
		$params = array();
		parse_str($_SERVER['QUERY_STRING'], $params);
		
		// 변수 설정
		$email = $params['email'];
		$password = $params['password'];
		$newpwd = hash('sha256',md5($password));

		// post 되어온 정보로 유저 정보 가져오기, fm_member 에서 userid 랑 email 주소랑 같으니까 가능
		$query	= $this->db->get_where('fm_member', array('userid' => $email));
		$result = $query->row_array();

		// 비밀번호 자릿수 확인 
		$size = strlen($password);
		
		// 비밀번호 영문,숫자 들어가있는지 확인 
		$num = preg_match('/[0-9]/u', $password);
		$eng = preg_match('/[a-z]/u', $password);

		#### TODO 1. 여기서부터 진행하는 코드들은 모두 로그 기록해놔야함!! 
		 
		if(!$email || !$password) { 
			// 빈칸일 시 아래것 생성
			$this->output
				 ->set_content_type('application/json')
				 ->set_output(json_encode(array(
					'status'	=> false,
					'email'		=> $params['email'],
					'password'	=> $params['password'],
					'msg'		=> '이메일 또는 비밀번호가 빠졌습니다.'
				)));
		} else if($size > 20) { 
			// 비밀번호 자릿수 20자 초과면 표시
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(array(
					'status'	=> false,
					'email'		=> $params['email'],
					'password'	=> $params['password'],
					'msg'		=> '비밀번호는 영문, 숫자 포함 6자 이상 20자 미만이어야합니다.'
				)));
		} else if ($size < 6) { 
			// 비밀번호 자릿수 6자 미만이면 표시
			$this->output
				->set_status_header('200')
				->set_content_type('application/json')
				->set_output(json_encode(array(
					'status'	=> false,
					'email'		=> $params['email'],
					'password'	=> $params['password'],
					'msg'		=> '비밀번호는 영문, 숫자 포함 6자 이상 20자 미만이어야합니다.'
				)));
		} else if ($num == 0 || $eng == 0) { 
			// 비밀번호에 영문 혹은 숫자 안들어가있으면 표시 
			$this->output
				 ->set_content_type('application/json')
				 ->set_output(json_encode(array(
					'status'	=> true,
					'email'		=> $params['email'],
					'password'	=> $params['password'],
					'msg'		=> '비밀번호는 영문, 숫자 포함 6자 이상 20자 미만이어야합니다.'
				)));
		} else if (!$result) { 
			// 맞는 회원정보가 없을시 표시 
			$this->output
				 ->set_content_type('application/json')
				 ->set_output(json_encode(array(
					'status'	=> false,
					'email'		=> $params['email'],
					'password'	=> $params['password'],
					'msg'		=> '맞는 아이디가 없습니다. 다시 확인해주세요'
				)));
		} else { 
			// 비밀번호 업데이트 2021-01-27 오류 생겼었음 죽여주시오 
			//$sql = $this->db->update('fm_member', array('password' => $newpwd));

			// json 띄워주기
			$this->output
				->set_status_header('200')
				->set_content_type('application/json')
				->set_output(json_encode(array(
					'status'			=> true,
					'username'			=>	$result['user_name'],
					'email'				=>	$params['email'],
					'post_password'		=>	$params['password'],
					'update_password'	=>	$result['password'],
					'update_time'		=>	$result['update_date'],
					'msg'				=>	'정보변경이 완료되었습니다.'
				)));
		}
	}
	*/
}
?>