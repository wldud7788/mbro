<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class bigdata_process extends admin_base {

	public function __construct() {
		parent::__construct();

		$this->load->model('bigdatamodel');
	}

	## 설정 저장
	public function save_config(){
		$this->load->model('goodsdisplay');
		$bigdataCriteria	= $_POST['bigdataCriteria'];
		$bigdataCriteria = $this->goodsdisplay->check_criteria($bigdataCriteria,'bigdata_catalog');

		config_save('bigdata_criteria', array('condition' => $bigdataCriteria));
		$callback = "parent.document.location.reload();";
		openDialogAlert("설정이 저장 되었습니다.",400,140,'parent',$callback);
	}
}

/* End of file bigdata_process.php */
/* Location: ./app/controllers/admin/bigdata_process.php */