<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class Banner extends selleradmin_base {
	
	public function __construct() { 
		parent::__construct();

		$this->admin_menu();
		$this->tempate_modules();

		$file_path	= $this->template_path();
		define('FILE_PATH', $file_path);

		// 모바일 
		$this->template->assign('ismobile',$this->_is_mobile_agent);//ismobile

		//상단 타이틀
		$this->template->define(array('tpl'=>FILE_PATH));

	}
	
	public function index() { 


		// 1. 접속 아이디 
		$access_id = $_SESSION['provider']['provider_seq'];

		// 2. 쿼리문
		$text = "SELECT * FROM mb_banner WHERE company_id = '{$access_id}' AND visuality = '1' ORDER BY id DESC"; 
		$query = $this->db->query($text);
		$row = $query->result_array(); 
		$num = $query->num_rows(); 
		
		// 3. 배열로 해서 뷰로 넘긴다. 
		$banner_index = array(); 

		foreach ($row as $key => $value) { 

			$url = substr($row[$key]['url'],2,100); 
			
			// 2021-03-12 노출,미노출 관련 작업 
			if($row[$key]['active'] = 'on') { 
				$active = '노출'; 
			} else { 
				$active = '미노출';
			} 
			
			$banner_index[] = array(
				'id' => $row[$key]['id'],
				'title' => $row[$key]['title'],
				'url' => 'https://musicbroshop.com/'.$url,
				'startDate' => $row[$key]['startDate'],
				'endDate' => $row[$key]['endDate'],
				'inputDate' => $row[$key]['inputDate'],
				'active' => $active
			);
		} 

		$this->template->assign('banner_index',$banner_index);

		$this->template->print_("tpl");
	} 

	public function input() { 
		// 1. 관리자이름 = 회사이름 
		$name = $_SESSION['provider']['provider_name'];
		$this->template->assign('name',$name);

		$this->template->print_("tpl");
	} 

	public function revise() { 
		$id = $_GET['no']; 

		$text = "SELECT * FROM mb_banner WHERE id = '{$id}' ORDER BY id DESC"; 
		$query = $this->db->query($text);
		$row = $query->result_array(); 
		
		foreach ($row as $key => $value) { 

			$url = substr($row[$key]['url'],2,100); 
			$name = $_SESSION['manager']['mname'];
			if($row[$key]['active'] == 'on') { 
				$active = 'checked';
			} else { 
				$active = '';
			}	
			$banner_info[] = array(
				'id' => $row[$key]['id'],
				'name' => $name, 
				'title' => $row[$key]['title'],
				'url' => 'https://musicbroshop.com/'.$url,
				'startDate' => $row[$key]['startDate'],
				'endDate' => $row[$key]['endDate'],
				'inputDate' => $row[$key]['inputDate'],
				'active' => $active
			);
		} 

		$this->template->assign('banner_info',$banner_info);
		$this->template->print_("tpl");
	} 
	
	public function process() { 
		// 1. 현재 접속 중인 아이디 확인 
		$access_id = $_SESSION['provider']['provider_seq'];

		// 2. POST 로 넘어온 것 변수 작성 
		$bn_name = $_POST['name'];
		$bn_title = $_POST['title'];
		$bn_start = $_POST['start'];
		$bn_end = $_POST['end'];
		//$bn_content = $_POST['content']; 
		if(!$_POST['check']) { 
			$bn_check = 'off';
		} else { 
			$bn_check = 'on';
		} 
		
		// 3. 파일 관련 변수 지정 
		$date = date('Y-m-d');

		// 2-1. POST 로 받은 것 확인 여부 
		if($bn_title == '')  { 
			echo "<script type='text/javascript'>
					alert('제목을 입력해주세요');
					location.replace('./input');
			  </script>";
			exit;
		} 
		
		// 2-2. 시작날짜 관련 작업 
		if($bn_start == '') { 
			echo "<script type='text/javascript'>
					alert('시작날짜가 입력되지 않았습니다.');
					location.replace('./input');
			  </script>";
			exit;
		} 
		
		if($bn_end == '') { 
			echo "<script type='text/javascript'>
					alert('종료날짜가 입력되지 않았습니다.');
					location.replace('./input');
			  </script>";
			exit;
		} 

		// 시작날짜가 오늘보다 전 일 경우 
		if($bn_start < $date || $bn_end < $date) { 
			echo "<script type='text/javascript'>
					alert('시작날짜 및 종료날짜는 금일보다 이 전일 수 없습니다.');
					location.replace('./input');
			  </script>";
			exit;
		} 

		// 3. 파일 관련 변수 지정 
		$date = date('Y-m-d');

		// 4. 파일 이름은 파일이 있는지 확인하고 넣기 
		$text = "SELECT * FROM mb_banner WHERE company_id = '{$access_id}' ORDER BY id DESC"; 
		$query = $this->db->query($text);
		$row = $query->num_rows();

		
		// 5. 파일 업로드 진행 
		$uploadDir = './data/fileupload/banner/'; 
		$uploadPath = $uploadDir.$date.'/'.$access_id;
		
		// 6. 파일을 서버에 저장 
		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = 'jpeg|jpg|png';
		$config['max_size'] = '10000';
		$config['file_name'] = $row; // db에 저장된 쿼리 갯수 = 파일 이름
		
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		// 7. 폴더 없다면 생성 
		if(!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0777, true);
		}

		
		$data = array(); 

		$url = substr($_FILES['img']['type'],2,100);

		
		// 8. 업로드 실행 
		if(!$this->upload->do_upload('img')) { 
			$error = $this->upload->display_errors();
			
			echo "<script type='text/javascript'>
					alert('".$error."');
					location.replace('./input');
			  </script>";
			exit;
		} 
		
		$file = $this->upload->data();


		$file_url = $uploadPath.'/'.$file['orig_name']; 


		// 9. 변수로 만들어서 정리 
		$data = array (
			'title' => $bn_name,
			'url' => $file_url,
			'startDate' => $bn_start,
			'endDate' => $bn_end,
			'active' => $bn_check,
			'company_id' => $access_id

		); 
		
		// 10. db에 업로드 
		$result = $this->db->insert('mb_banner', $data);

		// 11. 알림창 띄우기 
		
		echo "<script type='text/javascript'>
					alert('등록이 완료되었습니다.');
					location.replace('./index');
			  </script>";
		
		exit; 

		
	} 

	public function bannerDelete() { 
		$id = $_GET['id']; 
		
		// 1. db에서 해당 아이디의 파일 경로를 가져온다. 
		$text = "SELECT * FROM mb_banner WHERE id = '{$id}' ORDER BY id DESC"; 
		$query = $this->db->query($text);
		$row = $query->result_array();
		
		// 2. 파일이 저장되어있는 url 을 가져온다. 
		$url = $row['0']['url']; 

		// 3. 파일이 존재한다면 아래 것 실행 
		if( !unlink($url) ) {
			
			echo '삭제가 되지 않았습니다. 개발팀에 문의해주세요.'; 
			exit; 

		}

		else {
			$text = "UPDATE mb_banner SET visuality = '0' WHERE id = '{$id}' ";
			$query = $this->db->query($text);

			echo '파일이 정상적으로 삭제 되었습니다.'; 
			exit; 
		}
	} 

	public function bannerRevise() {
		// 1. GET으로 넘어온 것 확인 
		$id = $_GET['id'];

		// 2. POST 로 넘어온 것 변수 작성 
		$bn_name = $_POST['name'];
		$bn_title = $_POST['title'];
		$bn_start = $_POST['start'];
		$bn_end = $_POST['end'];

		if(!$_POST['check']) { 
			$bn_check = 'off';
		} else { 
			$bn_check = 'on';
		} 
		
		// 3. 파일 관련 변수 지정 
		$date = date('Y-m-d');
		
		// 변경된 파일이 있는지 없는지에 따라 아래 것 실행 
		if($_FILES['img']['name'] == '') { 

			$text = "UPDATE mb_banner 
					 SET title = '{$bn_title}',
						 startDate = '{$bn_start}',
						 endDate = '{$bn_end}',
						 active = '{$bn_check}'
					 WHERE id = '{$id}' ";
			$query = $this->db->query($text);
			


		} else if($_FILES['img']['name'] != '') { 
			
			// 5. 파일 업로드 진행 
			$uploadDir = './data/fileupload/banner/'; 
			$uploadPath = $uploadDir.$date.'/'.$access_id;
			
			// 6. 파일을 서버에 저장 
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'jpeg|jpg|png';
			$config['max_size'] = '10000';
			$config['file_name'] = $row; // db에 저장된 쿼리 갯수 = 파일 이름
			
			
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			
			// 8. 업로드 실행 
			if(!$this->upload->do_upload('img')) { 
				$error = $this->upload->display_errors();
				
				echo "<script type='text/javascript'>
						alert('".$error."');
						location.replace('./revise');
				  </script>";
			} 
			
			$file = $this->upload->data();
			$file_url = $uploadPath.'/'.$file['orig_name']; 


			// 9. 변수로 만들어서 정리 
			$data = array (
				'title' => $bn_name,
				'url' => $file_url,
				'startDate' => $bn_start,
				'endDate' => $bn_end,
				'active' => $bn_check,
				'company_id' => $access_id

			); 

			$text = "UPDATE mb_banner SET url = '{$file_url}' WHERE id = '{$id}' ";
			$query = $this->db->query($text);
		}
		
		echo "<script type='text/javascript'>
					alert('수정이 완료되었습니다.');
					location.replace('./index');
			  </script>";
		
		exit;	
	}
}
/* End of file banner.php */
/* Location: ./app/controllers/admin/banner.php */

