<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);

class bigdata extends front_base {
	
	public function __construct() {
		parent::__construct();

		$this->load->model('bigdatamodel');
		$this->load->model('goodsmodel');
	}

	public function index(){
		redirect("/bigdata/catalog");
	}

	## 랜딩 페이지
	public function catalog(){
		$no						= (int) trim($_GET['no']);
		if	(!$no){
			$list	= $this->goodsmodel->goods_list(array());
			if(isset($list['record'][0]))	$no	= $list['record'][0]['goods_seq'];
		}

		$cfg_system	= ($this->config_system) ? $this->config_system : config_load('system');
		$result		= $this->goodsmodel->get_goods_view($no, true, true);
		if	($result['status'] == 'error'){
			switch($result['errType']){
				case 'echo':
					echo $result['msg'];
					exit;
				break;
				case 'back':
					pageBack($result['msg']);
					exit;
				break;
				case 'redirect':
					alert($result['msg']);
					pageRedirect($result['url'],'');
					exit;
				break;
			}
		}else{
			$goods			= $result['goods'];
			$category		= $result['category'];
			$alerts			= $result['alerts'];
			if	($result['assign'])foreach($result['assign'] as $key => $val){
				if	($key == 'goods')	$this->template->assign(array('goodsinfo'	=> $val));
				else					$this->template->assign(array($key			=> $val));
			}
		}

		// 빅데이터 설정 정보
		$cfg_bigdata = config_load('bigdata_criteria');
		$this->template->assign(array('cfg_bigdata'	=> $cfg_bigdata));

		// 현재 저장된 설정 불러오기
		$reKinds	= $this->bigdatamodel->get_bigdata_goods_display($no,'catalog');

		$this->template->assign(array('kinds'	=> $reKinds));

		$file_path	= $this->template_path();
		$this->print_layout($file_path);
	}
}

/* End of file bigdata.php */
/* Location: ./app/controllers/admin/bigdata.php */