<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class displayCache extends front_base {
    public function __construct() {
        parent::__construct();
        error_reporting(E_ERROR);
		set_time_limit(0);
		ini_set('memory_limit', '-1');
		$this->db->db_debug = false;        
        $this->load->library('batchLib');        
    }
    /*
    상품 디스플레이 캐시 자동 갱신 
    */
    public function _create_display_cache()
    {
        $sYearMon   = date('Ym');
        $sLogFile   = 'displayCache_'.$sYearMon.'.log';
        try{            
            $this->load->model('goodsdisplay');
            $aParams = array('auto_generation'=>'y','cache_use'=>'y');            
            $query = $this->goodsdisplay->get_display_tab_list_sql($aParams);        
            $query = mysqli_query($this->db->conn_id, $query);
            while($aData = mysqli_fetch_array($query)){			
                // 모바일전용 ver3 이상
                if($this->realMobileSkinVersion >  2 && $aData['platform']=='mobile' && ($aData['style']=='newswipe' || $aData['style']=='sizeswipe')){
                    $aData['count_w'] = $aData['count_w_swipe'];
                    $aData['count_h'] = $aData['count_h_swipe'];                
                }
                // 모바일전용 스와이프형 일때 ver2 이하
                if($this->realMobileSkinVersion < 3 && $aData['platform']=='mobile' && $aData['style']=='newswipe'){
                    $aData['count_w'] = $aData['count_w_swipe'];
                    $aData['count_h'] = $aData['count_h_swipe'];                
                }
                $aData['perpage']   = $aData['count_w'] * $aData['count_h'];			
                $this->designDisplayTabAjaxIdx = $aData['display_tab_index'];
                $sFileName   = $this->goodsdisplay->createDesignDisplayCach($aData['display_seq'], $aData['display_tab_index'], $aData['perpage'], $aData['kind']);
            }
        }catch (Exception $e) {			
			$this->batchlib->_cronFileLog($sLogFile, 'error - ' . $e->getMessage());
		}
        $this->batchlib->_cronFileLog($sLogFile, 'create');
    }
}