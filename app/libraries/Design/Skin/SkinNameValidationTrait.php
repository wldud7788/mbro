<?php
namespace App\libraries\Design\Skin;

trait SkinNameValidationTrait
{
	protected function folderNameValidation($skinParams)
	{
		$skinPrefix = $skinParams['skinPrefix'];
		$folderName = $skinParams['folderName'];

		$return = [
			'result' => true,
			'message' => null,
		];

		// 공통적으로 적용되는 폴더명칭 검사
		$commonValidationResult = $this->commonFolderNameValidation(['folderName' => $folderName]);
		if ($commonValidationResult['result'] === false) {
			$return['result'] = false;
			$return['message'] = $commonValidationResult['message'];
		}
			
		if ($return['result'] === true) {
			// '지정된 스킨이름'이 있으면 폴더명도 맞춰줘야 한다
			$skinPrefixValidationResult = $this->skinPrefixFolderNameValidation([
				'skinPrefix' => $skinPrefix,
				'folderName' => $folderName
			]);
			if ($skinPrefixValidationResult['result'] === false) {
				$return['result'] = false;
				$return['message'] = $skinPrefixValidationResult['message'];
			}
		}

		return $return;
	}

	// 공통적으로 적용되는 폴더명칭 검사
	public function commonFolderNameValidation($skinParams)
	{
		$folderName = $skinParams['folderName'];

		$return = [
			'result' => true,
			'message' => null,
		];

		if (strlen($folderName) === 0) {
			$return['result'] = false;
			$return['message'] = '폴더명이 없습니다.';
		}

		if (preg_match('/^[a-z0-9_]+$/', $folderName) === 0) {
			$return['result'] = false;
			$return['message'] = '폴더명에 허용하지 않는 문자열이 포함되었습니다.';
		}

		return $return;
	}

	// 지정된 스킨명칭에 대한 폴더명칭 검사
	public function skinPrefixFolderNameValidation($skinParams)
	{
		$skinPrefix = $skinParams['skinPrefix'];
		$folderName = $skinParams['folderName'];

		$return = [
			'result' => true,
			'message' => null,
		];

		// '지정된 스킨이름'이 있으면 폴더명도 맞춰줘야 한다
		switch ($skinPrefix) {
			case 'fammerce':
				if (preg_match('/^fammerce_/', $skinFolder) === 0) {
					$return['result'] = false;
					$return['message'] = 'Facebook PC 스킨은 fammerce_로 시작해야합니다.';
				}

				break;

			case 'store':
				if (preg_match('/^store_/', $skinFolder) === 0) {
					$return['result'] = false;
					$return['message'] = '매장용 PC 스킨은 store_로 시작해야합니다.';
				}

				break;

			case 'storemobile':
				if (preg_match('/^storemobile_/', $skinFolder) === 0) {
					$return['result'] = false;
					$return['message'] = '매장용 Mobile 스킨은 storemobile_로 시작해야합니다.';
				}

				break;

			case 'storefammerce':
				if (preg_match('/^storefammerce_/', $skinFolder) === 0) {
					$return['result'] = false;
					$return['message'] = '매장용 Facebook PC 스킨은 storefammerce_로 시작해야합니다.';
				}

				break;
			// 나머지 skinPrefix 조건
			default:
				if (preg_match('/^fammerce_/', $folderName)) {
					$return['result'] = false;
					$return['message'] = 'Facebook PC 스킨만  fammerce_로 시작할 수 있습니다.';
				}

				if (preg_match('/^store_/', $folderName)) {
					$return['result'] = false;
					$return['message'] = '매장용 PC 스킨만  store_로 시작할 수 있습니다.';
				}

				if (preg_match('/^storemobile_/', $folderName)) {
					$return['result'] = false;
					$return['message'] = '매장용 Mobile 스킨만  storemobile_로 시작할 수 있습니다.';
				}

				if (preg_match('/^storefammerce_/', $folderName)) {
					$return['result'] = false;
					$return['message'] = '매장용 Facebook PC 스킨만  storefammerce_로 시작할 수 있습니다.';
				}

				break;
		}

		return $return;
	}

	public function skinNameValidation($skinName)
	{
		// default 값
		$return = [
			'result' => true,
			'message' => null,
		];

		if (strlen($skinName) === 0) {
			$return['result'] = false;
			$return['message'] = '스킨명이 없습니다.';
		}

		if (preg_match('/^[a-zA-Z0-9\s_가-힝]+$/', $skinName) === 0) {
			$return['result'] = false;
			$return['message'] = '스킨명에 허용하지 않는 문자열이 포함되었습니다.';
		}

		return $return;
	}

	public function isSkinFolderDuplicate($path)
	{
		// default 값
		$return = [
			'result' => true,
			'message' => null,
		];

        if (is_dir($path) === true) {
			$return['result'] = false;
			$return['message'] = '동일한 폴더명의 스킨이 존재합니다.';
		}
	
		return $return;
	}
}
