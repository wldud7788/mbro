<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CacheMain extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->sOriLayoutPath         = 'main/index.html';
        $this->sTmpCachedPath         = 'main/tmp_main.html';
        $this->sCachedPath            = 'main/cache_main.html';
    }
    public function set_cache_file($sFileNmae) 	{
        $this->cache_file	= $sFileNmae;
        $this->cache_full_path = $this->cache_file_path . $this->cache_file;
    }
    public function make_file($sContents) {
        ob_start();
        echo $sContents;
        $cach_stats	= ob_get_contents();
        ob_end_clean();
        $file_obj           = fopen($this->cache_full_path, 'w+');
        if	(!$file_obj){
            $dir_name   = dirname($this->cache_full_path);
            if( !is_dir($dir_name) ) @mkdir($dir_name);
            @chmod($dir_name, 0777);
            $file_obj	= fopen($this->cache_full_path, 'w+');
        }
        fwrite($file_obj, $cach_stats);
        fclose($file_obj);
        @chmod($this->cache_full_path, 0777);
    }
    public function del_file() {
        unlink($this->cache_full_path);
    }
    public function check_cache_file() {
        $iFileSize          = filesize($this->cache_full_path);
        //var_dump($this->cache_full_path);
        //var_dump($iFileSize);
        if( !is_file($this->cache_full_path) ){
            return '20';
        }
        if( $iFileSize <= 0 ){
            return '30';
        }
        return '10';
    }
    public function check_cache_filetime() {
        $iFile  = $this->check_cache_file();
        if($iFile == '10'){
            return date("Y.m.d H:i:s", filemtime($this->cache_full_path));
        }
        return false;
    }
    public function main_cache($aResult) {
        $this->load->model('goodsdisplay');
        $sCode  = $this->input->get('code');
        $aMatches               = array();
        $sOriLayoutPath         = $this->sOriLayoutPath;
        $sTmpCachedPath         = $this->sTmpCachedPath;
        $sCachedPath            = $this->sCachedPath;
        $sPrintLayoutPath       = $sOriLayoutPath;
        $skinFilePath           = './data/skin/' . $this->skin . '/' .  $sOriLayoutPath;
        $sSkinFileContents      = file_get_contents($skinFilePath);
       
        $this->cache_file_path  = str_replace('//', '/', $this->template->template_dir) . '/' . $this->skin . '/';
        preg_match_all("/\{\=showDesignDisplay[\(]([0-9]*+)[\)]\}/", $sSkinFileContents, $aMatches);
        if($aMatches[1]){
            foreach($aMatches[1] as $iSeq) {
                $sSource    = "{=showDesignDisplay(".$iSeq.")}";
                $sTarget    = "[[[=showDesignDisplay(".$iSeq.")]]]";
                $sSkinFileContents = str_replace($sSource, $sTarget, $sSkinFileContents);
            }
        }
        preg_match_all("/\{\=showDesignPopup[\(]([0-9]*+)[\)]\}/", $sSkinFileContents, $aPopupMatches);
        if($aPopupMatches[1]){
            foreach($aPopupMatches[1] as $iSeq) {
                $sSource    = "{=showDesignPopup(".$iSeq.")}";
                $sTarget    = "[[[=showDesignPopup(".$iSeq.")]]]";
                $sSkinFileContents = str_replace($sSource, $sTarget, $sSkinFileContents);
            }
        }        
        $this->set_cache_file($sTmpCachedPath);
        $this->make_file($sSkinFileContents);
        $sCheckCode = $this->check_cache_file();
        $aMessage[] =  "10". $sCheckCode;
        if( $sCheckCode == '10' )   $sPrintLayoutPath   = $this->skin . '/' .$sTmpCachedPath;
        else                        $sPrintLayoutPath   = false;
        return array($sPrintLayoutPath, $aMessage, $sCachedPath, $sTmpCachedPath, $aMatches[1], $aPopupMatches[1]);
    }
}