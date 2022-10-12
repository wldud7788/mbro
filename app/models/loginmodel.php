<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use App\libraries\Password;

/**
 * 관리자 로그인
 */
class loginmodel extends CI_Model
{
    
    /**
     * 관리자 로그인
     * 
     * @param string $id
     * @param string $password
     * @return array
     */
    public function getAdminData($id, $password)
    {
        $str_md5 = md5($password);
        $str_sha256_md5 = hash('sha256',$str_md5);
        $query = "select * from fm_manager where manager_id=? and (mpasswd=? OR mpasswd=?)";
        $query = $this->db->query($query,array($id,$str_md5,$str_sha256_md5));
        return $query->row_array();
    }

    /**
     * 입점사 관리자 로그인
     * 
     * @param string $id
     * @param string $password
     * @return array
     */
    public function getProviderData($id, $password)
    {
        $str_md5 = md5($password);
        $str_sha256_md5 = hash('sha256',$str_md5);
        $query = "select * from fm_provider where provider_id=? and (provider_passwd=? OR provider_passwd=? OR provider_passwd=?)";
		$queryBinds = [
			$id,
			$str_md5,
			$str_sha256_md5,
			Password::encrypt($password)
		];
        $query = $this->db->query($query, $queryBinds);
        return $query->row_array();
    }
    
}