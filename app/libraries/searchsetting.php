<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class searchsetting {

	public $allow_exit = true;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('searchdefaultconfigmodel');
        $this->CI->config->load("searchFormSet");			// 검색 기본 설정.
	}

    public function pagesearchforminfo($pageid,$_default=null){

		/*
		# SEARCH Form Setting Start
		# searchEditUse : 검색편집 사용 여부
		# searchRequired: 검색 필수(고정) 필드(해당 필드는 사용자가 사용여부 설정 못함)
		# searchDefault : 검색 기본 필드(설정된 검색항목이 없을 때 노출)
		*/
        $set_search_form			= $this->CI->config->item($pageid);
        $data_search_default_str 	= $this->CI->searchdefaultconfigmodel->get_search_default_config($pageid);

		/*
		# SEARCH Data Setting Start
		*/
		unset($_GET['search_form_editor']);

		$search_flag 		= $this->CI->input->get('searchflag');
		$page 				= $this->CI->input->get('page');			// 고정

		if($this->CI->input->get('ship_grp_seq') || $this->CI->input->get('provider_seq')) $search_flag = true;

		// search mode : 검색모드 우선 처리
		if($search_flag){
			$sc						= $this->CI->input->get();
			
			$sc['search_mode']		= "search";
			if ($sc['search_text'])
			{
				$sc['search_text'] = trim($sc['search_text']);
				$sc['search_text'] = stripslashes(htmlspecialchars($sc['search_text']));
			}
		}else{
			if($data_search_default_str['search_info']){
				$sc = json_decode($data_search_default_str['search_info'],1);
				if(json_last_error() != 0){		// json 타입 데이터가 아닐 경우
					parse_str($data_search_default_str['search_info'],$sc);
				}
				unset($sc['sort']);
			}else{
				$sc = $set_search_form['searchValue'];
				//정렬 관련 필드는 저장하지 않음.
			}
		}

		unset($sc['searchcount']);

		/* default_ 제거 */
		foreach($sc as $key => $val){
			if(strstr($key,'default_')){
				$sc[str_replace('default_','',$key)] = $val;
				unset($sc[$key]);
			}

			// 'up@date' -> 'update' 치환 (sqlinjection check 피하기)
			$replace_yn = false;
			if(strstr($key, 'up@date')){
				$key 		= str_replace('up@date', 'update', $key);
				$replace_yn = true;
			}
			if(strstr($val, 'up@date')){
				$val = str_replace('up@date', 'update', $val);
				$replace_yn = true;
			}
			if($replace_yn) {
				$sc[$key] = $val;
			}
		}

		$sc['orderby']			= (isset($sc['orderby']) && $sc['orderby'])	? $sc['orderby']:$_default['orderby'];
		$sc['page']				= (isset($page) && $page > 1) ? intval($page):$_default['page'];
		$sc['perpage']			= (!empty($sc['perpage'])) ? intval($sc['perpage']):$_default['perpage'];
		$sc['sort']				= (isset($sc['sort']) && $sc['sort']) ? $sc['sort']:$_default['sort'];

		/*
		# SEARCH Form Setting Start
        */
        /* 저장된 관리자별 검색필드 사용 항목 가져오기 */
        if($data_search_default_str['field_default']){
            $default_field = json_decode($data_search_default_str['field_default']);
            if(json_last_error() != 0){		// json 타입 데이터가 아닐 경우
                parse_str($data_search_default_str['field_default'],$default_field);
            }
        }else{
            $default_field	= $set_search_form['searchDefault'];		//기본 검색필드 항목
        }
        
        if($default_field) {
		    $sc['form'] 	= array('default_field' => $default_field);	//검색필드 사용 항목
        }
        
		/*
		# SEARCH Form Setting End
		*/
		
		// 날짜 프리셋 세팅
		$sc['date_preset'] = $this->CI->config->item('date_preset');

        return $sc;

    }
}
?>