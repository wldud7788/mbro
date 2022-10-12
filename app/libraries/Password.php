<?php
namespace App\libraries;

final class Password
{
    // const 변수에 접근제어자는 php 7.1부터 사용가능
    const ALGORITHM = 'sha256';

	public static function encrypt($password)
	{       
        if (strlen(trim($password)) === 0) {
            throw new \Exception("password can't be empty!");
        }

		return hash(self::ALGORITHM, $password . self::salt());
	}

	// 패스워드 확인
	public static function isConfirm($password, $encryptPassword)
	{
		$confirm = false;

		if (isset($password) === false || isset($encryptPassword) === false) {
			return $confirm;
		}

		// md5 경우
		if (self::isOldAlgorithm($encryptPassword) === true) {
			$confirm = self::isOldPasswordConfirm($password, $encryptPassword);
		// sha256 경우
		} else {
			$confirm = self::isPasswordConfirm($password, $encryptPassword);
		}

		return $confirm;
	}

	/**
	 * 오래된 password 구분 (md5)
	 * 
	 * 저장된 password 자릿수로 구분짓는다
	 * md5 : 32 자리
	 * sha256 : 64 자리
	 */
	public static function isOldAlgorithm($encryptPassword)
	{
		$isOld = true;
		
		$sha256Length = 64;
		
		if (strlen($encryptPassword) === $sha256Length) {
			$isOld = false;
		}

		return $isOld;
	}

    private static function salt()
	{
		return config_item('encryption_key');
	}

	// md5 확인
	private static function isOldPasswordConfirm($password, $encryptPassword)
	{
		$confirm = false;

		if (md5($password) === $encryptPassword) {
			$confirm = true;
		}

		return $confirm;
	}

	// sha256 확인
	private static function isPasswordConfirm($password, $encryptPassword)
	{
		$confirm = false;

		if (self::encrypt($password) === $encryptPassword) {
			$confirm = true;
		}
		
		return $confirm;
	}
}
