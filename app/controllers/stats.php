<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class stats extends front_base {
    public function __construct() {
		parent::__construct();
    }

	public function search_recent_auto(){
		$sAuto = "on";
		if(get_cookie('searchRecent') == 'off') $sAuto = "off";
		echo json_encode(array('auto' => $sAuto));
	}

	public function use_auto_complete(){
		$sAuto = "on";
		if(get_cookie('searchAuto') == 'off') $sAuto = "off";
		echo json_encode(array('auto' => $sAuto));
	}

	public function search_auto_complete(){
		$this->load->model('statsmodel');
		$this->load->model('Eventmodel');
		$this->load->model('goodsmodel');
		$this->load->model('goodslistmodel');
		$this->load->model('categorymodel');
		$this->load->library('sale');
		$sKeyword		= $this->input->get('keyword');
		$cfg_reserve	= ($this->reserves) ? $this->reserves : config_load('reserve');
		$enddate		= date('Y-m-d', strtotime('-30day'));
		$sKeyword		= str_replace(' ', '',addslashes($sKeyword));
		if( $sKeyword ){
			$aResult		= $this->statsmodel->getSearchList($sKeyword, $enddate);
			$aResultEvents	= $this->Eventmodel->getEventAuto($sKeyword);
			$aResultRecomm	= $this->goodslistmodel->autoCompleteRecomm($sKeyword, $enddate, $this->userInfo['member_seq'] , $this->userInfo['group_seq']);
		}
		echo json_encode(array('keywords'=>$aResult, 'events'=>$aResultEvents, 'recomms'=>$aResultRecomm));
	}
}

/* End of file stats_process.php */
/* Location: ./app/controllers/stats_process.php */