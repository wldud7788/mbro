<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 비디오 커머스 권한 체크
 * @author Sunha Ryu
 * 2019-12-12
 */
class permit
{    
    public $type;
    public $manager_seq;
    public $provider_seq;
    public $ci;
    
    public function __construct($apiTokenInfo)
    {
        $this->ci = &get_instance();
        $this->init($apiTokenInfo);
    }
        
    public function init($apiTokenInfo)
    {
		$manager = $this->ci->session->userdata('manager');
		$manager_seq = (!empty($manager['manager_seq']) ? $manager['manager_seq'] : $apiTokenInfo['manager_seq']);
		
		$provider = $this->ci->session->userdata('provider');
		// manager 데이터가 있으면 무조건 provider_seq =1 
		$provider['provider_seq'] = (!empty($manager['manager_seq'])) ? '1' : $provider['provider_seq'];
		$provider_seq = (!empty($provider['provider_seq']) ? $provider['provider_seq'] : $apiTokenInfo['provider_seq']);
		
        $this->setManagerSeq($manager_seq);
        $this->setProviderSeq($provider_seq);
    }
    
    public function type($type)
    {
        $this->type = $type;
        return $this;
    }
    
    public function setManagerSeq($manager_seq)
    {
        $this->manager_seq = $manager_seq;
	}

    public function setProviderSeq($provider_seq)
    {
        $this->provider_seq = $provider_seq;
	}	
	
	public function getManagerSeq()
    {
        return $this->manager_seq;
	}

    public function getProviderSeq()
    {
        return $this->provider_seq;
    }
    
    /**
     * 권한을 체크한다.
     * @param int $manager_seq : 관리자 순번
     * @param string $perm : 권한 코드
     * @param boolean $manager_yn : true일시 주운영자는 true
     * @return boolean
     */
    public function check($perm, $manager_yn = true)
    {
        if(empty($this->manager_seq)) {
            return $this->retFalse();
        }
        $perms = array();
        if($manager_yn) {
            $perms[] = 'manager_yn';
        }
		$perms[] = $perm;

		$authData = $this->getAuth($this->manager_seq, $perms);

		if($authData['manager_yn']=='Y') return true;
		if($authData[$perm]=='Y') return true; 

        return $this->retFalse();
    }
    
    /**
     * 환경에 맞게 오류를 반환한다.
     */
    public function retFalse()
    {
        switch($this->type) {
            case 'admin':
				$res = array(
					'success' => false,
					'msg' => "권한이 없습니다.",
				);

				return $this->ci->response($res);
                exit;
                
            case 'app':
				$this->ci->response403();
				exit;

			default :
				exit;
                
        }
        return false;
    }
    
    
    /**
     * 권한 데이터를 authmodel을 이용하여 반환한다.
     * @param int $manager_seq
     * @param array $authNames
     * @return array
     */
    private function getAuth($manager_seq, $auth = array())
    {
        $this->ci->load->model('authmodel');
        $where = array(
            'manager_seq' => $manager_seq,
            'codecd' => $auth,
        );
        $query = $this->ci->authmodel->select('codecd, value', $where);
        $authData = $query->result_array();
        $auth = array();
        if(count($authData)>0) {
            foreach($authData as $row) {
                $auth[$row['codecd']] = $row['value'];
            }
        }
        return $auth;
    }
}