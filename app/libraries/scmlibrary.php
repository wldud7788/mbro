<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SCM 관련된 소스들이 컨트롤러와 모델에 산재되어 있어 향후 병합을 위한 라이브러리 구조 
 * 2018-08-06
 * by hed 
 */
class ScmLibrary
{
	public $allow_exit = true;
	
	function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('scmmodel');
	}
	
	// 쇼핑몰 창고 리스트 얻기
	public function get_scm_basic_store($params, &$stores, &$store_list){
		$sc['page']			= (trim($params['page']) > 0) ? trim($params['page']) : '1';
		$sc['store_type']	= trim($params['sc_store_type']);
		$sc['perpage']		= 10;
		$stores				= $this->CI->scmmodel->get_store($sc);
		if	($stores['record']) foreach($stores['record'] as $k => $data){
			if	($data['admin_env_seq'] > 0){
				unset($sc, $wh_name_list, $wh_export, $wh_return);
				$sc['admin_env_seq']		= $data['admin_env_seq'];
				$use_warehouse				= $this->CI->scmmodel->get_store_warehouse($sc);
				if	($use_warehouse) foreach($use_warehouse as $j => $wh){
					$wh_name_list[]			= $wh['wh_name'];
					if	($wh['export_wh'])	$wh_export	= $wh['wh_name'];
					if	($wh['return_wh'])	$wh_return	= $wh['wh_name'];
				}
				$data['wh_list']	= $wh_name_list;
				$data['wh_export']	= $wh_export;
				$data['wh_return']	= $wh_return;

				$store_list[]			= $data;
			}
		}
	}
	
	// 쇼핑몰 창고 상세 얻기
	public function get_scm_basic_store_regist($params, &$store, &$warehouses, &$manager){
		unset($sc);
		$sc['admin_env_seq']	= $params['sno'];
		$store					= $this->CI->scmmodel->get_store($sc);
		$store					= $store[0];
		$sc['only_warehouse']	= 'y';
		$store_warehouse		= $this->CI->scmmodel->get_store_warehouse($sc);
		if	(is_array($warehouses) && count($warehouses) > 0 && 
			is_array($store_warehouse) && count($store_warehouse) > 0){
			foreach($warehouses as $k => $whdata){
				foreach($store_warehouse as $j => $swdata){
					if	($whdata['wh_seq'] == $swdata['wh_seq']){
						$whdata['mine']	= 'y';
						if	($swdata['export_wh']){
							$whdata['export_wh']	= 'y';
						}
						if	($swdata['return_wh']){
							$whdata['return_wh']	= 'y';
						}
					}
				}
				$tmp_warehouses[]	= $whdata;
			}
			$warehouses			= $tmp_warehouses;
		}
		$sc['parent_table']		= 'store';
		$sc['parent_seq']		= $store['admin_env_seq'];
		$manager				= $this->CI->scmmodel->get_manager($sc);
		$manager				= $manager[0];
	}
	
	
	// 매장 저장
	public function set_save_store($params, &$data){
		$data			= $this->CI->scmmodel->chk_store_params($params);
		$admin_env_seq	= $data['admin_env_seq'];
		if	($data['store']){
			$this->CI->scmmodel->save_store($data['store'], $admin_env_seq);	// insert는 불가!!
		}
		if	($admin_env_seq > 0){
			$use_warehouse	= $this->CI->scmmodel->save_store_warehouse($admin_env_seq, $data['warehouse'], $data['export_wh'], $data['return_wh']);
			$this->CI->scmmodel->save_manager('store', $admin_env_seq, $data['manager']);

			// config에 저장할 매장 정보
			$cfg_arr		= array('admin_env_seq'		=> $admin_env_seq, 
									'admin_env_name'	=> $data['store']['admin_env_name'], 
									'use_warehouse'		=> $use_warehouse, 
									'export_wh'			=> $data['export_wh'], 
									'return_wh'			=> $data['return_wh']);

			// 출고창고 Update
			if	(!$this->CI->config_system)	$this->CI->config_system	= config_load('system');
			if	($this->CI->config_system['shopSno'] == $params['admin_shop_no']){
				config_save('scm', $cfg_arr);
			}else{
				$this->CI->load->model('multishopmodel');
				$this->CI->multishopmodel->config_save('scm',$cfg_arr, $params['admin_shop_no']);
			}
		}
	}
	public function call_exit(){
		if($this->allow_exit){
			exit;
		}
	}
}
?>