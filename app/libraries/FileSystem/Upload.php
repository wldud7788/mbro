<?php
namespace App\Libraries\FileSystem;

/**
 * codeigniter 3 파일업로드 Wapping class 
 * http://www.ciboard.co.kr/user_guide/kr/libraries/file_uploading.html
 */
final class Upload
{
	private $CI;

	// ci3 파일 업로드 설정값
	private $configs = [];

	// 업로드 성공 결과
	private $isUpload = false;

	public function __construct()
	{
		$this->CI = &get_instance();

		// 저장공간 체크 하기위해서 사용
		$this->CI->load->model('usedmodel');
	}

	public function put($fileParams)
	{
		// 업로드 설정값
		$configs = $fileParams['config'];

		// 업로드 실행전 유효성 검사
		$validate = $this->validateBeforeUpload($configs);
		if ($validate['status'] === 0) {
			return $validate;
		}

		$this->setConfig($configs);

		// 업로드  (global $_FILES 의 key 값)
		$this->up($fileParams['uploadFileName']);

		// 업로드 결과
		return $this->uploadResult();
	}

	private function setConfig($configs)
	{
		$this->configs = $configs;
	}

	private function validateBeforeUpload($configs)
	{
		$isValidate = [
			// 기존코드 리턴 타입이 int
			'status' => 1,
			'msg' => '',
			'desc' => '',
		];

		// 임시 업로드후 파일을 웹에 보여줄때 사용된다
		if (isset($configs['webPath']) === false) {
			return [
				'status' => 0,
				'msg' => '웹 업로드 경로가 없습니다.',
				'desc' => getAlert('et004'),
			];
		}

		if (isset($configs['upload_path']) === false) {
			return [
				'status' => 0,
				'msg' => '파일업로드 경로가 없습니다.',
				'desc' => getAlert('et004'),
			];
		}

		if (isset($configs['allowed_types']) === false) {
			return [
				'status' => 0,
				'msg' => '업로드 허용파일이 지정되지 않았습니다.',
				'desc' => getAlert('et004'),
			];
		}

		if (isset($configs['max_size']) === false) {
			return [
				'status' => 0,
				'msg' => '파일업로드 최대 용량이 설정 되지 않았습니다.',
				'desc' => getAlert('et004'),
			];
		}

		if (isset($configs['file_name']) === false) {
			return [
				'status' => 0,
				'msg' => '업로드후 변경될 파일 이름이 설정되지 않았습니다.',
				'desc' => getAlert('et004'),
			];
		}

		// 판매점 저장공간 체크
		$storageLimitCheck = $this->CI->usedmodel->used_limit_check();
		if ($storageLimitCheck['type'] === false) {
			return [
				'status' => 0,
				// 파일 저장 공간이 부족하여 업로드가 불가능합니다.
				'msg' => getAlert('et003'),
				'desc' => getAlert('et004'),
			];
		}

		return $isValidate;
	}

	private function up($fileKeyName)
	{
		$this->CI->load->library('upload', $this->configs);

		/**
		 * CI 라이브러리 내부 에서 파일 이름으로 $_FILES 변수에 접근한다.
		 */
		$this->isUpload = $this->CI->upload->do_upload($fileKeyName);
	}

	private function uploadResult()
	{
		return ($this->isUpload === true) ? $this->success() : $this->fail();
	}

	private function success()
	{
		$uploadData = $this->CI->upload->data();
		/**
		 * 기존에 사용하던 포맷으로 리턴 한다.
		 *
		 * 	[status] => 1
		 *  [filePath] => /data/tmp/18fd84004d1efdc61828367704d990121115203.JPG
		 *  [fileInfo] => Array
		 *  (
		 * 		[file_name] => 18fd84004d1efdc61828367704d990121115203.JPG
		 * 		[file_type] => image/jpeg
		 * 		[file_path] => /var/www/html/data/tmp/
		 * 		[full_path] => /var/www/html/data/tmp/18fd84004d1efdc61828367704d990121115203.JPG
		 * 		[raw_name] => 18fd84004d1efdc61828367704d990121115203
		 * 		[orig_name] => 18fd84004d1efdc61828367704d990121115203.JPG
		 * 		[client_name] => k2.JPG
		 * 		[file_ext] => .JPG
		 * 		[file_size] => 40.77
		 * 		[is_image] => 1
		 * 		[image_width] => 570
		 * 		[image_height] => 707
		 * 		[image_type] => jpeg
		 * 		[image_size_str] => width="570" height="707"
		 *  )
		 */

		/**
		 * 리턴값을 배열에 넣어줌
		 */
		$result = [
			'status' => ($this->isUpload === true) ? 1 : 0,
			'filePath' => $this->configs['webPath'] . '/' . $uploadData['file_name'],
			'fileInfo' => $uploadData,
			'filetype' => $uploadData['file_type'],
		];

		return $result;
	}

	private function fail()
	{
		$result = [
			'status' => ($this->isUpload === true) ? 1 : 0,
			// javascript alert 출력에 사용되는 메세지
			'msg' => $this->CI->upload->display_errors(),
			// 화면에 출력되는 메세지
			'desc' => getAlert('et004'),
		];

		return $result;
	}
}
