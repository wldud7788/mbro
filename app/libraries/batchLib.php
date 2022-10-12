<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class batchLib extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->aExecFunc = array();
    }
    ## 순차별 크론 실행
    public function _getNextFunc($thisFunc)
	{
		if(!$this->aExecFunc) return false;
		foreach($this->aExecFunc as $aFunc){
			if($aFunc['sFunctionName'] == $thisFunc){
                echo chr(10) . $thisFunc . ' - ' .$aFunc['sCfg'];
				return array($aFunc, $this->aExecFunc[$aFunc['sNextIndex']]);
			}
		}
		return array($thisFunc, false);
	}
	## 크론잡 파일로그
	public function _cronFileLog($filename, $content){
		$logDir = ROOTPATH."/data/cronlog/";
		if(!is_dir($logDir)){
			mkdir($logDir);
			@chmod($logDir,0777);
		}
		$fp = fopen($logDir.$filename,"a+");
		fwrite($fp,"[".date('Y-m-d H:i:s')."] - ");
		fwrite($fp,$content . "\r\n");
		fclose($fp);
		$this->db->queries = array();
		$this->db->query_times = array();
	}
    ## 폴더 및 하위 폴더 삭제
    public function _sureRemoveDir($dir,$DeleteMe){
		if(!$sdh = opendir($dir)) return;
		while(false !== ($obj = readdir($sdh))){
			if(in_array($obj,array('.','..','.svn'))) continue;
			 if(file_exists($dir."/".$obj) && !@unlink($dir."/".$obj)) {
				 $this->_sureRemoveDir($dir.'/'.$obj, true);
			 }
		}
		closedir($sdh);
		if ($DeleteMe){
			@rmdir($dir);
		}
	}

	public function createPgLog($sPgCompany, $aPgCfg)
	{
		$aLogDirs = array(
			'inicis' => array(
				'pg/inicis/log/INIPHP_receipt_[PG_ID]_[YY][MM][DD].log'
			),
			'lg' => array(
				'pg/lgdacom/log/log_[YYYY][MM][DD].log'
			),
			'kspay' => array(
				'pg/kspay/log/[YYYY][MM][DD].txt'
			),
			'kcp' => array(
				'pg/kcp/log/[YYYY][MM]',
				'pg/kcp/log/[YYYY][MM]/[DD]_pp_cli.log'
			),
			'kicc' => array(
				'pg/kicc/receipt/log',
				'pg/kicc/receipt/log/[YYYY][MM]',
				'pg/kicc/receipt/log/[YYYY][MM]/[DD]_easypay_cli.log'
			)
		);

		$sPgId = $aPgCfg['mallCode'];
		$iYYYY = date('Y');
		$iYY = date('y');
		$iMM = date('m');
		$iDD = date('d');

		foreach ($aLogDirs[$sPgCompany] as $LogUrl) {
			$change = false;
			$LogUrl = str_replace('[PG_ID]', $sPgId, $LogUrl);
			$LogUrl = str_replace('[YYYY]', $iYYYY, $LogUrl);
			$LogUrl = str_replace('[YY]', $iYY, $LogUrl);
			$LogUrl = str_replace('[MM]', $iMM, $LogUrl);
			$LogUrl = str_replace('[DD]', $iDD, $LogUrl);
			if (preg_match('/\./', $LogUrl)) { // 로그 파일
				if ( ! is_file($LogUrl)) {
					fclose(fopen($LogUrl, "w+"));
					$change = true;
				}
			} else { // 로그 폴더
				if ( ! is_dir($LogUrl)) {
					mkdir($LogUrl);
					$change = true;
				}
			}
			if ($change) {
				chown($LogUrl, 'nobody');
			}
		}
	}
}