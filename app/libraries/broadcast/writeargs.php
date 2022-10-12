<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 방송 편성표 등록/수정 페이지에서 사용하는 arguments를 반환하는 라이브러리
 * @author Sunha Ryu
 */
class writeargs
{    
    public $ci;
    
    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->model('broadcastmodel');
        $this->ci->load->helper("basic");
    }
    
    /**
     * 방송 편성표 작성 페이지에서 사용하는 변수
     * @return array
     */
    public function getWriteArgs()
    {
        $args = array();
        
        // 폼에서 사용하는 기본 데이터
        $args['default'] = $this->getDefault();
        return $args;
    }
    
    /**
     * 폼에서 사용하는 데이터를 배열로 반환한다.
     * @return array
     */
    private function getDefault() {
		$default = array();
		$default = $this->getRegistDateTime();
        $default['hours'] = $this->getHours();
        $default['minutes'] = $this->getMinutes();
        return $default;
    }
    
    
    /*************************Default Funcs***************************/
    
    /**
     * 시(0~23) 반환
     * @return array
     */
    private function getHours() {
        $hours = array();
        for($i=0; $i<=23; $i++) {
            $hours[] = sprintf("%02d", $i);
        }
        return $hours;
    }
    
    /**
     * 분(00~50) 반환
     * @return array
     */
    private function getMinutes() {
        $minutes = array();
        for($i=0; $i<=50; $i+=10) {
            $minutes[] = sprintf("%02d", $i);
        }
        return $minutes;
	}
	
	/**
	* 현재 시간에서 가장 빠른 시간 리턴
	* 단,10분 단위로 반환 //60 넘으면 시간 +1 / 23시간 넘으면 일자+1
	*/
    private function getRegistDateTime() {
		$default = array();
		$default['date'] = date("Y-m-d");
		$default['hour'] = date("H");
		$default['minute'] = substr_replace(date("i")+10, '0', -1);

		
		// 60분 이상이면 시간 +1 , 분은 00
		if($default['minute'] >= 60) {
			$default['hour'] = $default['hour']+1;
			$default['minute'] = '00';
			// 24시 이상이면 일+1, 시간/분 00
			if($default['hour'] >= 24) {
				$default['date'] = date("Y-m-d", strtotime($default['date'], "+1 day"));
				$default['hour'] = '00';
			}
		}
        return $default;
    }
}