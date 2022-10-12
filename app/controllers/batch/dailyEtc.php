<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/batch/exportMsg".EXT);
class dailyEtc extends exportMsg {
	public function __construct() {
		parent::__construct();
		$this->load->helper('readurl');
	}
	// 쇼핑몰 분류 업데이트
	public function shop_branch()
	{
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$url = 'https://interface.firstmall.kr/firstmall_plus/setting_branch.xml';
			$result = readurl($url);
			if($result){
				$arr = xml2array($result);
				$shopBranch = $arr['branchlist']['branch'];
			}
			foreach($shopBranch as $data){
				$arrBranch = array();
				$arrItem = array();
				$arrBranch[$data['code']] = $data['value'];
				foreach($data['item'] as $item){
					if($item['value']){
						$arrItem[$data['code'].$item['code']] = $item['value'];
					}
				}
				code_save('shopBranch',$arrBranch);
				code_save('shopBranch'.$data['code'],$arrItem);
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	// 배송추적주소 업데이트
	public function delivery_url()
	{
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$deliverylist	= array();
			$arrDelivery	= array();
			$url = 'http://delivery.firstmall.kr/';
			$result = readurl($url);
			if($result){
				$arr = xml2array($result);
				$deliverylist = $arr['deliverylist']['delivery'];
			}

			foreach($deliverylist as $data){

				$code = $data['code'];
				unset($data['code']);

				if($data['url'] == "_DELETE_"){
					$value = "";
				}else{
					$value = serialize($data);
				}
				if( is_numeric($code) ){
					$arrDelivery['code'.$code]	= $value;
				}else{
					$arrDelivery[$code]			= $value;
				}
			}
			if($arrDelivery) {
				config_save('delivery_url',$arrDelivery);
			}

			# 네이버페이 택배사 코드 매핑
			$deliverylist	= array();
			$arrDelivery	= array();
			$url			= 'http://delivery.firstmall.kr/npay_delivery_company_code.php';
			$result			= readurl($url);
			if($result){
				$arr = xml2array($result);
				$deliverylist = $arr['DeliveryCompanyList']['delivery'];
			}

			foreach($deliverylist as $data){
				$code = $data['code'];
				unset($data['code']);

				if( is_numeric($code) ){
					$arrDelivery['code'.$code] = $data['company_code'];
				}else{
					$arrDelivery[$code]			= $data['company_code'];
				}
			}
			if($arrDelivery) {
				config_save('npay_delivery_company',$arrDelivery);
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	// config 동기화
	public function config_sync(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$url = 'https://interface.firstmall.kr/firstmall_plus/request.php?cmd=configLoad';
			$result = readurl($url);
			if($result){
				$arr = xml2array($result);
				foreach($arr['list']['fm_config'] as $k => $codeVal){
					$arrfmCode[$codeVal['groupcd']][$codeVal['codecd']] = $codeVal['value'];
				}


				foreach($arrfmCode as $groupcd => $data){
					if ($groupcd == 'phpSkin') {
						if ($data['ShopSnos']) {
							$aShopSno = explode(',', $data['ShopSnos']);
							if (in_array($this->config_system['shopSno'], $aShopSno)){
								config_save('phpSkin', array('able'=>'Y'));
							}else{
								config_save('phpSkin', array('able'=>'N'));
							}
						}
					} else {
						config_save($groupcd, $data);
					}
				}
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	// 코드 동기화 :: 2017-10-12 lwh
	public function code_sync(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$url = 'https://interface.firstmall.kr/firstmall_plus/request.php?cmd=codeLoad';
			$result = readurl($url);
			if($result){
				$arr = xml2array($result);
				foreach($arr['list']['fm_code'] as $k => $codeVal){
					$arrfmCode[$codeVal['groupcd']][$codeVal['codecd']] = $codeVal['value'];
				}
				foreach($arrfmCode as $groupcd => $data){
					code_delete($groupcd);
					code_save($groupcd, $data);
				}
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	### 쇼핑몰 분류 업데이트
	public function eximbay()
	{
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$url = 'https://interface.firstmall.kr/firstmall_plus/request.php?cmd=eximbay';
			$result = readurl($url);

			if($result){
				$arr = xml2array($result);
			}

			foreach($arr['eximbay'] as $groupcd => $ar){
				code_delete('eximbay_'.$groupcd);
				foreach($ar['item'] as $r){
					$params = $r;
					unset($params['code']);
					code_save('eximbay_'.$groupcd,array($r['code']=>$params));
				}
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	public function kakaotalk_template(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('kakaotalkmodel');
			$this->kakaotalkmodel->set_template_default_code();
			$cnt = $this->kakaotalkmodel->set_template_sync();
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}

	### 부가서비스 이슈 알림
	public function addservice_notify(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			if( empty($this->environment) ) $this->load->helper('environment');
			$this->load->model('usedmodel');
			$cfg_addservie_notify = config_load('addservie_notify');

			/* SMS 건수 */
			$sms = commonCountSMS();
			if($cfg_addservie_notify['sms_message_complete']!='Y' && 1 <= $sms && $sms <= 50){
				$commonSmsData = array();
				$commonSmsData['sms_charge']['params'][] = array('remainSms'=>$sms);
				commonSendSMS($commonSmsData);

				config_save('addservie_notify',array('sms_message_complete'=>'Y'));
			} else if($cfg_addservie_notify['sms_message_complete'] == 'Y' && $sms > 50) {
				// SMS 발송 알림 보낸 후 50건 이상이 되면 다시 N 으로 수정
				config_save('addservie_notify',array('sms_message_complete'=>'N'));
			}

			/* 자동입금확인 */
			$edate = $this->config_system['autodeposit_count'];
			$remain = round((strtotime($edate)-time()) / (3600*24));
			if($cfg_addservie_notify['autodeposit_message_complete']!='Y' && 1 <= $remain && $remain <= 20){
				$commonSmsData = array();
				$commonSmsData['autodeposit_charge']['params'][] = array('remainAutodeposit'=>$edate);
				commonSendSMS($commonSmsData);

				config_save('addservie_notify',array('autodeposit_message_complete'=>'Y'));
			}else if($cfg_addservie_notify['autodeposit_message_complete'] == 'Y' && $remain > 20) {
				// SMS 발송 알림 보낸 후 연장해서 20일 이상 남으면 다시 N 으로 수정
				config_save('addservie_notify',array('autodeposit_message_complete'=>'N'));
			}

			/* 굿스플로 */
			$goodsflow = $this->usedmodel->used_get_service_info('view');
			if($cfg_addservie_notify['goodsflow_message_complete']!='Y' && 1 <= $goodsflow && $goodsflow <= 50){
				$commonSmsData = array();
				$commonSmsData['goodsflow_charge']['params'][] = array('remainGoodsflow'=>$goodsflow);
				commonSendSMS($commonSmsData);

				config_save('addservie_notify',array('goodsflow_message_complete'=>'Y'));
			}else if($cfg_addservie_notify['goodsflow_message_complete'] == 'Y' && $goodsflow > 50) {
				// SMS 발송 알림 보낸 후 50건 이상 남으면 다시 N 으로 수정
				config_save('addservie_notify',array('goodsflow_message_complete'=>'N'));
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	### 관리자 중요행위 알림 캐시파일 생성
	public function makeCacheActionAert()
	{
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('managermodel');
			$this->managermodel->make_action_alert_cache();
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	public function create_alert_file(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$lang_arr	= array('KR','US','CN','JP');

			$sql		= "select * from fm_alert";
			$result		= $this->db->query($sql);
			$result		= $result->result_array();

			foreach($result as $k => $v){
				foreach($lang_arr as $lang){
					$lang_temp = str_replace("'","\'",$v[$lang]);
					$total_lang[$lang][] = "'".$v['code']."' : '".$lang_temp."'";
				}
			}

			foreach($lang_arr as $lang){
				$jsfilename = "data/js/language/L10n_".$lang.".js";
				if( is_file($jsfilename) ){
					@unlink($jsfilename);
				}
				$fp = fopen($jsfilename, "w") or die("Can't open file ");
				@chmod($jsfilename,0777);
				fwrite($fp, "L10n = {");
				fwrite($fp, implode(',',$total_lang[$lang]));
				fwrite($fp, "};");
				fclose($fp);
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	// 장바구니 비우기
	public function empty_cart(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->helper('basic');

			// 주문설정 로드
			$cfg = config_load('order');

			if(!$cfg['cartDuration']){
				throw new Exception('NO SETTING');
			}

			// 비울 장바구니 최종변경일
			$end = date('Y-m-d 00:00:00',strtotime("-".$cfg['cartDuration']." day"));

			$this->load->library('cartlib');
			$arr = [
				'duration_date' => $end,
				'partner_id' => null,
			];
			$this->cartlib->empty_cart_duraion($arr);

		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	public function log_email_delete() {
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			//3개월전 log 삭제
			$limit_date = date('Y-m-d',strtotime("-3 month"));
			$query	= "delete from fm_log_email where regdate < '".$limit_date."' ";
			$this->db->query($query);
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	public function log_captcha_delete() {
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			//log 삭제
			$this->load->model('Captchamodel');
			// First, delete old captchas
			$expiration = time()-86400; // 1day limit
			$this->Captchamodel->data_delete($expiration);
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	public function log_naverpay_delete(){	//네이버페이 관련 로그 삭제
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$limit_date = date('Y-m-d H:i:s',strtotime("-2 month"));
			$query	= "delete from fm_partner_order_detail where regist_date < '".$limit_date."' ";
			$this->db->query($query);

			$this->load->library('cartlib');
			$arr = [
				'duration_date' => $limit_date,
				'partner_id' => 'npay',
			];
			$this->cartlib->empty_cart_duraion($arr);
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	##
	public function delete_excel_temp(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('exceltempmodel');
			$this->exceltempmodel->truncate_excel_temp();
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}

	protected function _del_tmp_file($tmpPath, $n)
	{
		$dh = opendir($tmpPath);
		while ($o = readdir($dh)) {
			if(!in_array($o,array('.','..','.svn'))){
				$filePath = $tmpPath . '/' . $o;
				$diffDay = round((time() - filemtime($filePath)) / 86400, 1);
				if ($diffDay > $n) {
					echo $filePath, " - delete<br />";
					exec("rm -Rf " . $filePath);
				}
			}
		}
	}

	### /data/tmp, /data/logs/shoplinker, /data/sms 오래된 파일 삭제
	public function tmp_file_delete(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$tmpPath = ROOTPATH . "data/tmp";
			$this->_del_tmp_file($tmpPath, 2);

			$tmpPath = ROOTPATH . "data/logs/shoplinker";
			$this->_del_tmp_file($tmpPath, 7);

			$tmpPath = ROOTPATH . "data/sms";
			$this->_del_tmp_file($tmpPath, 7);
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	### /data/captcha 오래된 파일 삭제
	public function captcha_file_delete(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$tmpPath = ROOTPATH . "data/captcha";
			$this->_del_tmp_file($tmpPath, 1);
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	##
	public function delete_flash_cach(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->model('Cachemodel');
			$this->Cachemodel->cache_delete('flash_banner','');
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	public function du_check(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			// 외부호스팅, 서버 호스팅 은 용량계산을 하지 않도록 개선 2020-02-05
			if( !in_array($this->config_system['service']['hosting_code'], array('F_SH_X','SH_T_R'))) {
				$this->load->model('usedmodel');
				$this->usedmodel->account_used_space();
				$this->db->reconnect();
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	public function delete_excel_file(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$aCategory = array( 0 => "log", 1 => "goods", 2 => "order", 3 => "member", 4 => "export", 5 => "scmgoods" );
			$excelFilePath = ROOTPATH."excel_download/";
			$getDate = date("Ymd", strtotime("-8days"));

			foreach($aCategory as $category){
				$filePath = $excelFilePath.$category."/*";
				$dirs = array_filter(glob($filePath), 'is_dir');

				foreach($dirs as $folder){
					$folderDate = end(explode("/", $folder));
					if($folderDate < $getDate){
						array_map('unlink', glob($folder."/*.*"));
						rmdir($folder);
					}
				}
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	## 서버 캐시파일 삭제
	public function delete_caches(){
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->driver('cache');
			$path = ROOTPATH.'/data/caches';
			if(!is_dir($path)) {
				throw new Exception('NO CACHES DIRETORY');
			}
			$dirs = dir($path);
			while(false !== ($entry = $dirs->read())){
				if(($entry != '.') && ($entry != '..') && ($entry != '.gitignore')){
					if(is_file($path.'/'.$entry)){
						$this->cache->file->delete($entry);
					}
				}
			}
		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
	### SMS 국가 코드 업데이트
	public function sms_national_code()
	{
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$url = 'https://interface.firstmall.kr/firstmall_plus/request.php?cmd=sms_national_code';
			$result = readurl($url);

			if($result){
				$arr = xml2array($result);
			}
			foreach($arr['list'] as $groupcd => $ar){
				code_delete($groupcd);
				foreach($ar['item'] as $r){
					code_save($groupcd,array($r['codecd']=>$r['value']));
				}
			}

		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}


	### kicc 코드 업데이트
	public function kicc_code()
	{
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$url = 'https://interface.firstmall.kr/firstmall_plus/request.php?cmd=kicc';
			$result = readurl($url);

			if($result){
				$arr = xml2array($result);
			}
			foreach($arr['list'] as $groupcd => $ar){
				code_delete($groupcd);
				foreach($ar['item'] as $r){
					code_save($groupcd,array($r['codecd']=>$r['value']));
				}
			}

		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}

	### data/logs 파일 삭제
	public function delete_log_files() {
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$dataLogs = ROOTPATH."data/logs";
			$dir = opendir($dataLogs);
			while($o = readdir($dir)){
				if(!in_array($o,array('.','..','.svn'))){
					$logFolders[] = $o;
				}
			}
			foreach($logFolders as $folder) {
				$tmpPath = ROOTPATH."data/logs/".$folder;
				if(is_dir($tmpPath)){
					$n	= 7;//40->7일 지난 파일 삭제
					$dh = opendir($tmpPath);
					while($o = readdir($dh)){
						if(!in_array($o,array('.','..','.svn'))){
							$filePath	= $tmpPath.'/'.$o;
							$diffDay	= round((time()-filemtime($filePath))/86400,1);

							// filetime 비교하여 7일 지나거나 폴더명과 비교
							if($diffDay>$n || $o < date("Ymd",strtotime("-".$n." day"))) {
								$this->batchlib->_sureRemoveDir($filePath,true);
								echo $filePath," - delete\n";
							}
						}
					}
				}
			}

		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}

	### 라이브 방송 취소처리
	public function broadcast_cancel() {
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			// create , 3day 과거 방송 조회
			$this->load->model('broadcastmodel');
			$sc = array();
			$sc['status'] = 'create';
			$sc['edate'] = date("Y-m-d", strtotime("-4days"));
			$sc['date_gb'] = 'start_date';
			$sc['order_by'] = 'b.start_date';
			$braodcastData = $this->broadcastmodel->getSch($sc);
			$bsSeqList = array();
			foreach($braodcastData as $data) {
				$bsSeqList[] = $data['bs_seq'];
				echo $data['bs_seq']."|";
			}
			// cancel update
			$this->broadcastmodel->setBroadcastStatus($bsSeqList,'cancel');
			foreach($bsSeqList as $bsSeq) {
				// 로깅
				$logParams = array(
					'provider_seq' => 0,
					'manager_seq' => 0,
					'memo' => '3일 경과 자동 취소',
					'device' => 'system'
				);

				// db logging
				$this->load->library('broadcast/logs', $logParams);
				$this->logs->logging('cancel', $bsSeq);
			}

		} catch (Exception $e) {
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
		if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
		if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
    }

    # 개인정보 관리자 로그 삭제
	public function delete_manager_log()
	{
		list($aFunc, $aNextFunc) = $this->batchlib->_getNextFunc(__FUNCTION__);
		try {
			$this->load->library('managerlog');
			$this->managerlog->delete_manager_log();
		} catch (Exception $e) {
			if( $aFunc ) {
				$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
			}
		}
		
		if( $aNextFunc ) {
			$this->{$aNextFunc['sFunctionName']}();
		}
		
		if( $aFunc ) {
			$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
		}
	}
}
// END
/* End of file _gabia.php */
/* Location: ./app/_gabia.php */