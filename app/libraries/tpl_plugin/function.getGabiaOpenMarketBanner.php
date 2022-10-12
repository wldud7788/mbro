<?
function getGabiaOpenMarketBanner($type = 'multi')
{
	$CI =& get_instance();
	$CI->load->helper('readurl');

	$revision = preg_replace("/[^0-9]/i","",@file_get_contents(ROOTPATH.'revision.txt'));

	$data = array(
			'service_code'	=> SERVICE_CODE,
			'hosting_code'	=> $CI->config_system['service']['hosting_code'],
			'subDomain'		=> $CI->config_system['subDomain'],
			'domain'		=> $CI->config_system['domain'],
			'hostDomain'	=> $_SERVER['HTTP_HOST'],
			'shopSno'		=> $CI->config_system['shopSno'],
			'expire_date'	=> $CI->config_system['service']['expire_date'],
			'revision'		=> $revision,
			'setting_date'	=> $CI->config_system['service']['setting_date'],
	);

	$cach_file_path	= $_SERVER['DOCUMENT_ROOT'] . '/data/cach/admin_skin_banner_openmarket.html';

	$read	= false;
	if( !is_file($cach_file_path) ){
		$read	= true;
	}else{
		if( date("Y-m-d H:i:s.", fileatime($cach_file_path)) < date("Y-m-d H:i:s.", strtotime("-4 hours")) )	$read	= true;
		else $read = false;
	}

	if($read){
		$res	= readurl(get_connet_protocol()."interface.firstmall.kr/firstmall_plus/request.php?cmd=getGabiaOpenMarketBanner&mode=".$type, $data);
		$file_obj	= fopen($cach_file_path, 'w+');
		if	(!$file_obj){
			$dir_name	= dirname($cach_file_path);
			if( !is_dir($dir_name) )	@mkdir($dir_name);
			@chmod($dir_name,0777);
			$file_obj	= fopen($cach_file_path, 'w+');
		}
		fwrite($file_obj, $res);
		fclose($file_obj);
		@chmod($cach_file_path,0777);
	}else{
		$res	= file_get_contents($cach_file_path);
	}

	$res = replace_connect_protocol($res);

	return $res;
}