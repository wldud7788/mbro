<?php
function copyFile($sourceFilePath, $targetFilePath)
{
	$CI =& get_instance();
	$CI->load->helper('antimalware');
	$patternFound = scanFile($sourceFilePath);
	if (count($patternFound) > 0) {
		return array('result' => false, 'description' => 'malware');
	}
	if (!copy($sourceFilePath, $targetFilePath)) {
		return array('result' => false, 'description' => 'failed');
	}
	return array('result' => true);
}