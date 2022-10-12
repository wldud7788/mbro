<?php
/*
캐시처리모델 / ocw / 2015-01-15

사용예제

	$CI =& get_instance();
	$CI->load->model('Cachemodel');

	if($CI->Cachemodel->start('category','category_navigation_0001')){
		echo "<div>test : ".time()."</div>"; // PRINT할 내용
		$data = array(time(),microtime()); // RETURN할 내용
		$CI->Cachemodel->flush($data);
	}
	return $CI->Cachemodel->cache_data;
*/
class Cachemodel extends CI_Model {

	var $cache_path = 'data/cache/';
	var $cache_group = 'common'; // 캐시 대상 그룹
	var $cache_time = 3600;
	var $cache_key = null;
	var $cache_data = null;

	function __construct() {
		parent::__construct();
	}

	public function start($cache_group,$cache_key) {
		$this->cache_group = $cache_group;
		$this->cache_key = $cache_key;
		if($this->cache_key && $this->_cache_time_check()){
			$contents = file_get_contents($this->_get_cache_file_path());
			print($contents);

			if(file_exists($this->_get_cache_data_path())){
				$this->cache_data = unserialize(file_get_contents($this->_get_cache_data_path()));
			}
			return false;
		}else{
			ob_start();
			return true;
		}
	}

	public function flush($data=null) {
		if($this->cache_key != null){

			if(!is_dir($this->cache_path)){
				@mkdir($this->cache_path);
				@chmod($this->cache_path,0777);
			}

			if(!is_dir($this->cache_path.$this->cache_group)){
				@mkdir($this->cache_path.$this->cache_group);
				@chmod($this->cache_path.$this->cache_group,0777);
			}

			$contents = ob_get_contents();
			ob_end_clean();
			file_put_contents($this->_get_cache_file_path(),$contents);
			chmod($this->_get_cache_file_path(),0777);
			print($contents);

			if($data!==null){
				$this->cache_data = $data;
				file_put_contents($this->_get_cache_data_path(),serialize($data));
				chmod($this->_get_cache_data_path(),0777);
			}

			$this->cache_key = null;
		}
	}

	public function cache_delete($cache_group,$cache_key=null){
		$this->cache_group = $cache_group;
		$this->cache_key = $cache_key;
		if($this->cache_key){
			if(file_exists($this->_get_cache_file_path())) @unlink($this->_get_cache_file_path());
			if(file_exists($this->_get_cache_data_path())) @unlink($this->_get_cache_data_path());
		}elseif($this->cache_group){
			if(is_dir($this->cache_path.$this->cache_group)){
				system("rm -f ".$this->cache_path.$this->cache_group."/*");
			}
		}
	}

	public function _get_cache_file_path(){
		return $this->cache_path.$this->cache_group.'/'.$this->cache_key.'.html';
	}

	public function _get_cache_data_path(){
		return $this->cache_path.$this->cache_group.'/'.$this->cache_key.'.data';
	}

	public function _cache_time_check(){
		if(file_exists($this->_get_cache_file_path()) && filemtime($this->_get_cache_file_path())+$this->cache_time > time()) return true;
		return false;
	}

}