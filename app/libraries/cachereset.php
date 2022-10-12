<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CacheReset extends CI_Model
{
	public function __construct() {
		parent::__construct();
	}

	public function admin_boardmanager_process_index()
	{
		$mode = $this->input->post('mode');
		if ( ! $mode) {
			$mode = $this->input->get('mode');
		}
		if (in_array($mode, array('boardmanager_write', 'boardmanager_modify', 'boardmanager_delete', 'boardmanager_multi_delete', 'boardmanager_copy'))) {
			$aCacheId[] = 'category_recommend';
			$aCacheId[] = 'design_goods';
			$aCacheId[] = 'location_recommend_html';
		}
		return $aCacheId;
	}
}
