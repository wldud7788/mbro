<?php
class AccountService extends ServiceBase
{
	protected $_ServiceName	= 'account';

	public function __construct($params = array())
	{
		parent::__construct($params);
	}

	public function getServiceName(){ return $this->_ServiceName; }

	protected function _encrypt($inputText) {
		if ($this->AesDecrypt($inputText)  === false)
			return $this->AesEncrypt($inputText);
		else
			return $inputText;

	}

	// 마켓 연동을 위한 API Key 생성
	protected function _setFmConnectorAccount() {
		$response	= $this->callOtherConnector("Authorization/setAuthorization/{$this->_CI->config_system['shopSno']}");

		if ($response['success'] == 'Y' && strlen($response['resultData']['accessKey']) == 36) {
			$this->_FmAccessKey		= $response['resultData']['accessKey'];
			$this->_FmSecureKey		= $response['resultData']['secretKey'];
			config_save('ConnectorAuth', array("access_key" => $this->_FmAccessKey, "secret_key" => $this->_FmSecureKey));
		}

	}

	public function setAccountInfo($market, $sellerId, $params, $mode = 'regist') {
		$this->_CI->load->model('connectormodel');
		$sellerId					= trim($sellerId);
		$accountParams['market']	= $market;
		$accountParams['sellerId']	= $sellerId;
		$orgAccountInfo				= $this->_CI->connectormodel->getAccountInfo($accountParams);

		$return						= array();
		$return['success']			= 'Y';
		
		if ($mode == 'regist' && isset($orgAccountInfo['sellerId']) === true) {
			$return['success']		= 'N';
			$return['message']		= "'{$sellerId}'는 이미 등록된 판매자 아이디 입니다.";
			return $return;
		}
		
		if ($mode == 'renew' && isset($orgAccountInfo['sellerId']) !== true) {
			$return['success']		= 'N';
			$return['message']		= "'{$sellerId}'는 등록되지 않은 판매자 아이디 입니다.";
			return $return;
		}

		if (strtoupper($params['goodsPriceSet']['adjustment']['use']) == 'Y') {

			$params['goodsPriceSet']['adjustment']['use']		='Y';

			if (!$this->checkNumberValue($params['goodsPriceSet']['adjustment']['value'])) {
				$return['success']		= 'N';
				$return['message']		= "가격조정은 숫자만 입력 가능합니다.";
				return $return;
			}

			$params['goodsPriceSet']['adjustment']['value']		= (float)$params['goodsPriceSet']['adjustment']['value'];

			switch(strtoupper($params['goodsPriceSet']['adjustment']['unit'])) {
				case	'PER' :
					if ( $params['goodsPriceSet']['adjustment']['value'] < 1 ||
						$params['goodsPriceSet']['adjustment']['value'] > 100
					) {
						$return['success']	= 'N';
						$return['message']	= "% 조정은 1~100 사이의 값만 입력이 가능합니다.";
						return $return;
						break;
					}
					$params['goodsPriceSet']['adjustment']['unit']	= 'PER';
					break;

				case	'CUR' :
					$params['goodsPriceSet']['adjustment']['unit']	= 'CUR';
					break;

				default :
					$return['success']	= 'N';
					$return['message']	= "PER, CUR 값만 사용 가능합니다.";
					return $return;
					break;
			}

			switch(strtoupper($params['goodsPriceSet']['adjustment']['type'])) {
				case	'MINUS' :
					$params['goodsPriceSet']['adjustment']['type']	= 'MINUS';
					break;

				case	'PLUS' :
					$params['goodsPriceSet']['adjustment']['type']	= 'PLUS';
					break;

				default :
					$return['success']	= 'N';
					$return['message']	= "MINUS, PLUS 값만 사용 가능합니다.";
					return $return;
					break;
			}

			if (strtoupper($params['goodsPriceSet']['cutting']['use']) == 'Y') {

				$params['goodsPriceSet']['cutting']['use'] = 'Y';

				switch ($params['goodsPriceSet']['cutting']['unit']) {
					case	10 :
						$params['goodsPriceSet']['cutting']['unit']		= 10;
						break;

					case	100 :
						$params['goodsPriceSet']['cutting']['unit']		= 100;
						break;

					case	1000 :
						$params['goodsPriceSet']['cutting']['unit']		= 1000;
						break;

					default :
						$return['success']	= 'N';
						$return['message']	= "10, 100, 1000 값만 사용 가능합니다.";
						return $return;
						break;
				}

				switch (strtoupper($params['goodsPriceSet']['cutting']['type'])) {
					case	'UP' :
						$params['goodsPriceSet']['cutting']['type']		= 'UP';
						break;

					case	'DOWN' :
						$params['goodsPriceSet']['cutting']['type']		= 'DOWN';
						break;

					case	'ROUND' :
						$params['goodsPriceSet']['cutting']['type']		= 'ROUND';
						break;

					default :
						$return['success']	= 'N';
						$return['message']	= "UP, DOWN, ROUND 값만 사용 가능합니다.";
						return $return;
						break;
				}

			} else {
				$params['goodsPriceSet']['cutting']['use'] = 'N';
			}



		} else {
			$params['goodsPriceSet']['adjustment']['use']		= 'N';
			$params['goodsPriceSet']['cutting']['use']			= 'N';
		}


		if (strtoupper($params['goodsStockSet']['adjustment']['use']) == 'Y') {
			$params['goodsStockSet']['adjustment']['use']		= 'Y';

			if (!$this->checkNumberValue($params['goodsStockSet']['adjustment']['value'])) {
				$return['success']	= 'N';
				$return['message']	= "재고조정은 숫자만 입력 가능합니다.";
				return $return;
			}

			$params['goodsStockSet']['adjustment']['value']		= (int)$params['goodsStockSet']['adjustment']['value'];
		} else {
			$params['goodsStockSet']['adjustment']['use']		= 'N';
		}

		/////////////////////////////////////////////////////
		// Connector AccessKey 확인 값이 없을경우 우선 등록
		if (strlen($this->_FmAccessKey) != 36)
			$this->_setFmConnectorAccount();

		if (strlen($this->_FmAccessKey) != 36) {
			$return['success']	= 'N';
			$return['message']	= "서비스를 사용할 수 없습니다.";
			return $return;
		}
		/////////////////////////////////////////////////////
		
		
		$accountParams['market']					= $market;
		$accountParams['seller_id']					= $sellerId;
		$accountParams['market_auth_info']			= $params['marketAuthInfo'];
		$accountParams['market_other_info']			= (isset($params['marketOtherInfo']) === true) ? $params['marketOtherInfo'] : [];
		$accountParams['goods_price_set']			= $params['goodsPriceSet'];
		$accountParams['goods_stock_set']			= $params['goodsStockSet'];
		$accountParams['account_use']				= ($params['accountUse'] == 'N') ? 'N' : 'Y';


		// 계정 암호화 설정 및 개별 설정
		switch ($accountParams['market']) {
			case	'coupang' :
				$accountParams['market_auth_info']['secretKey']		= $this->_encrypt($accountParams['market_auth_info']['secretKey']);
				$accountParams['market_auth_info']['vendorId']		= $sellerId;
				break;


			case 	'open11st' :
				$accountParams['market_auth_info']['apiKey']		= $this->_encrypt($accountParams['market_auth_info']['apiKey']);
				break;


			case 	'storefarm' :
				$accountParams['market_auth_info']['SellerId']		= $sellerId;
				$accountParams['market_auth_info']['target']		= ($sellerId == 'qa2tc346') ? 'SANDBOX' : 'PRODUCTION';

				if ($mode == 'regist' || $accountParams['market_auth_info']['ApiId'] != $orgAccountInfo['marketAuthInfo']['ApiId']) {	
					$this->setMarketInfo('storefarm');

					$postValue['auth']['SellerId']		= $sellerId;
					$postValue['request']['SellerId']	= $sellerId;
					$postValue['request']['ApiId']		= $accountParams['market_auth_info']['ApiId'];
					
					if ($accountParams['market_auth_info']['target'] == 'PRODUCTION') {
						$this->setMarketInfo('storefarm');
						$return		= $this->callConnector('other/doRegisterSeller', $postValue);

						if ($return['success'] == 'N') {
							if (strpos($return['message'], '이미 매핑된') === false) {
								$return['message']		= "아이디 또는 스마트스토어 API ID를 확인해주세요.";
								return $return;
							}
						}
					}
				}
				break;
		}

		$setAccountParams							= filter_keys($accountParams, $this->_CI->db->list_fields('fm_market_account'));
		$setAccountParams['market_auth_info']		= json_encode($setAccountParams['market_auth_info']);
		$setAccountParams['goods_price_set']		= json_encode($setAccountParams['goods_price_set']);
		$setAccountParams['goods_stock_set']		= json_encode($setAccountParams['goods_stock_set']);
		$setAccountParams['market_other_info']		= json_encode($setAccountParams['market_other_info']);

		if ($mode == 'regist') {
			$setAccountParams['registered_time']	= date('Y-m-d H:i:s');;
			$setAccountParams['renewed_time']		= $setAccountParams['registered_time'];
			$this->_CI->db->insert('fm_market_account', $setAccountParams);

			$accountSeq					= $this->_CI->db->insert_id();

			$accountLog					= array();
			$accountLog['account_seq']	= $accountSeq;
			$accountLog['manager_id']	= $this->_CI->managerInfo['manager_id'];
			$accountLog['log']			= "계정등록";
			$accountLog['log_time']		= $setAccountParams['renewed_time'];
			$this->_CI->db->insert('fm_market_account_log', $accountLog);

			$return['success']	= 'Y';
			$return['message']	= '계정정보 등록 완료';
		} else if ($mode == 'renew') {
			$accountSeq		= $orgAccountInfo['accountSeq'];
			$changeLog		= $this->setMarketAccountLog($orgAccountInfo, $params);
			if (count($changeLog) > 0) {
				$setAccountParams['renewed_time']	= date('Y-m-d H:i:s');

				$this->_CI->db->update('fm_market_account', $setAccountParams, ['seq' => $accountSeq]);
				$accountLog					= array();
				$accountLog['account_seq']	= $accountSeq;
				$accountLog['manager_id']	= $this->_CI->managerInfo['manager_id'];
				$accountLog['log']			= implode("\n", $changeLog);
				$accountLog['log_time']		= $setAccountParams['renewed_time'];

				$this->_CI->db->insert('fm_market_account_log', $accountLog);

				$return['success']	= 'Y';
				$return['message']	= "{$sellerId} 계정 설정을 수정하였습니다.";
			} else {
				$return['success']	= 'Y';
				$return['message']	= '변경된 내용이 없습니다.';
			}
		}

		$return['sellerId']		= $sellerId;
		$return['accountSeq']		= $accountSeq;

		return $return;
	}

	public function setMarketAccountLog($orgParams, $newParams)
	{
		$logList			= array();
		$marketAuthCnt		= count(array_diff($newParams['marketAuthInfo'], $orgParams['marketAuthInfo']));
		$marketOtherCnt		= count(array_diff($newParams['marketOtherInfo'], $orgParams['marketOtherInfo']));
		$priceSetCnt		= count(array_diff($newParams['goodsPriceSet']['adjustment'], $orgParams['goodsPriceSet']['adjustment']));
		$priceSetCnt		+= count(array_diff($newParams['goodsPriceSet']['cutting'], $orgParams['goodsPriceSet']['cutting']));
		$stockSetCnt		= count(array_diff($newParams['goodsStockSet']['adjustment'], $orgParams['goodsStockSet']['adjustment']));
		
		if($newParams['marketAuthInfo']['masterId'] != $orgParams['marketAuthInfo']['masterId']){
			$marketAuthCnt++;
		}
		
		if ($marketAuthCnt > 0)
			$logList[]		= "마켓 인증정보가 변경 되었습니다.";

		if ($marketOtherCnt > 0)
			$logList[]		= "마켓 기타정보가 변경 되었습니다.";

		if ($newParams['accountUse']  != $orgParams['accountUse'] ) {
			$orgText		= ($orgParams['accountUse'] == 'Y') ? '사용' : '해제';
			$newText		= ($newParams['accountUse'] == 'Y') ? '사용' : '해제';
			$logList[]		= "사용 설정 :  {$orgText} => {$newText}";
		}
		

		if ($priceSetCnt > 0) {
			$orgPriceSet	= $this->goodsPriceSetText($orgParams['goodsPriceSet']);
			$newPriceSet	= $this->goodsPriceSetText($newParams['goodsPriceSet']);
			$logList[]		= "{$orgPriceSet} => {$newPriceSet}";
		}

		if ($stockSetCnt > 0) {
			$orgStockSet	= $this->goodsStockSetText($orgParams['goodsStockSet']);
			$newStockSet	= $this->goodsStockSetText($newParams['goodsStockSet']);
			$logList[]		= "{$orgStockSet} => {$newStockSet}";
		}


		return $logList;
	}

	public function goodsPriceSetText($inputParams)
	{
		if ($inputParams['adjustment']['use'] == 'Y') {
			$adjValue	= $inputParams['adjustment']['value'];
			$adjUnit	= ($inputParams['adjustment']['unit'] == 'PER') ? '%' : '원';
			$adjType	= ($inputParams['adjustment']['type'] == 'PLUS') ? '+조정' : '-조정';

			if ($inputParams['cutting']['use'] == 'Y') {
				$cuttingUnit 	= $inputParams['cutting']['unit'];

				switch ((int)$inputParams['cutting']['unit']) {
					case	10 :
						$cuttingUnit	= '일원단위';
						break;

					case	100 :
						$cuttingUnit	= '십원단위';
						break;

					case	1000 :
						$cuttingUnit	= '백원단위';
						break;
				}

				switch ($inputParams['cutting']['type']) {
					case	"ROUND" :
						$cuttingType	= "반올림";
						break;

					case	"UP" :
						$cuttingType	= "올림";
						break;

					default :
						$cuttingType	= "버림";

				}
				$cuttingText	= "{$cuttingUnit}단위 에서 {$cuttingType}";
			} else {
				$cuttingText	= '절사없음';
			}

			$priceSet	= "판매 가격을 {$adjValue}{$adjUnit} {$adjType}({$cuttingText})";
		} else {
			$priceSet	= '원상품 판매가격과 동일하게 전송';
		}

		return $priceSet;
	}

	public function goodsStockSetText($inputParams)
	{
		if ($inputParams['adjustment']['use'] == 'Y') {
			$adjStock	= $inputParams['adjustment']['value'];
			$stockSet	= "재고수량을 {$adjStock}개로 일괄전송";
		} else {
			$stockSet	= '원상품 재고수량 동일하게 전송';
		}

		return $stockSet;
	}

	public function deleteAccountInfo($market, $sellerId) {
		$accountParams['market']	= $market;
		$accountParams['sellerId']	= $sellerId;
		$orgAccountInfo				= $this->_CI->connectormodel->getAccountInfo($accountParams);

		if (isset($orgAccountInfo['sellerId']) !== true) {
			$return['success']		= 'N';
			$return['message']		= "'{$sellerId}'는 등록되지 않은 판매자 아이디 입니다.";
			return $return;
		}

		$accountSeq								= $orgAccountInfo['accountSeq'];
		$deleteAccountParams['seller_id']		= "{$orgAccountInfo['sellerId']}_{$accountSeq}_deleted";
		$deleteAccountParams['delete_yn']		= 'Y';
		$deleteAccountParams['renewed_time']	= date('Y-m-d H:i:s');
		$this->_CI->db->update('fm_market_account', $deleteAccountParams, ['seq' => $accountSeq]);

		$accountLog['account_seq']				= $accountSeq;
		$accountLog['manager_id']				= $this->_CI->managerInfo['manager_id'];
		$accountLog['log']						= '계정이 삭제 되었습니다.';
		$accountLog['log_time']					= $deleteAccountParams['renewed_time'];
		$this->_CI->db->insert('fm_market_account_log', $accountLog);

		$return['success']		= 'Y';
		$return['message']		= "'{$sellerId}'계정이 삭제 되었습니다.";

		return $return;
	}


}