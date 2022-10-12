<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class stats_process extends front_base {
    public function __construct() {
		parent::__construct();
    }

    public function insert_search_stats(){
        $this->load->model('statsmodel');
        $this->statsmodel->insert_search_stats(trim(urldecode($this->input->post('search_text'))), trim(urldecode($this->input->post('member_seq'))));
		echo json_encode(array('status'=>'OK'));
    }

    public function goods_view_log(){
        $this->load->helper('reservation');
        $this->load->model('dailystatsmodel');
        $aGoods = array(
            'goods_seq'     => $this->input->post('goods_seq'),
            'goods_name'    => $this->input->post('goods_name'),
            'provider_seq'  => $this->input->post('provider_seq'),
            'goods_kind'    => $this->input->post('goods_kind')
        );
        $this->dailystatsmodel->view_log($aGoods);

        /* 고객리마인드서비스 상세유입로그 */
        $curation = array("action_kind"=>"goodsview","goods_seq"=>$aGoods['goods_seq']);
        curation_log($curation);
    }

	public function search_recent_del(){
		$this->load->model('statsmodel');
		$aPostParams	= $this->input->post();
		$iMemberSeq		= $this->userInfo['member_seq'];
		$sIp			= $_SERVER['REMOTE_ADDR'];
		if( $aPostParams['recent_seq'] == 'all' ){
			if($iMemberSeq){
				$aParams['iMemberSeq']	= $iMemberSeq;
			}else{
				$aParams['sIp']			= $sIp;
			}
		}else if( $aPostParams['recent_seq'] ){
			$aParams['iRecentSeq'] = $aPostParams['recent_seq'];
		}
		if( $aParams ) $this->statsmodel->delSearchRecent($aParams);
		echo json_encode(array('status'=>'OK'));
	}

	public function set_search_recent_auto(){
		$sAuto			= "on";
		$aPostParams	= $this->input->post();
		if($aPostParams['auto'] == 'on')  $sAuto = "off";
		$cookie = array(
			'name'   => 'searchRecent',
			'value'  => $sAuto,
			'expire' => '2592000',
			'path'   => '/'
        );
		set_cookie($cookie);
		echo json_encode(array('status'=>'OK'));
	}

	public function set_use_auto_complete(){
		$sAuto			= "on";
		$aPostParams	= $this->input->post();
		if($aPostParams['auto'] == 'on')  $sAuto = "off";
		$cookie = array(
			'name'   => 'searchAuto',
			'value'  => $sAuto,
			'expire' => '2592000',
			'path'   => '/'
        );
		set_cookie($cookie);
		echo json_encode(array('status'=>'OK'));
	}
}

/* End of file stats_process.php */
/* Location: ./app/controllers/stats_process.php */