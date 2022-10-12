<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/common_base".EXT);

class market_connect_callback extends common_base {

	public $supportMarkets		= array();
	protected $_responseBody;
	protected $_queueInfo;
	protected $_goodsService;


	public function __construct()
	{	
		parent::__construct();


		$this->load->model('connectormodel');
		$this->_goodsService	= $this->connector::getInstance('goods');
		$this->supportMarkets	= $this->_goodsService->getSupportMarkets();
		
		/*2017-12-06 샵링커 마켓 설정 추가*/
		$find			= $this->db->query("SELECT * FROM fm_market_account WHERE market LIKE 'API%' and delete_yn = 'N' and account_use = 'Y' group by market");
		$findRow		= $find->result();
		
		foreach ($findRow as $val){
			$getParam['searchMarket'] = $val->market;
			$rtn = $this->connectormodel->getLinkageMarket($getParam);
			$this->supportMarkets[$val->market]['name'] = $rtn[0]['marketName'];
			$this->supportMarkets[$val->market]['productLink'] = '';
		}
		
		/*2017-12-06 샵링커 마켓 설정 추가*/

		$rawRequestData			= file_get_contents("php://input");
		$this->_responseBody	= json_decode($rawRequestData, 1);


		$authText				= $this->_goodsService->AesDecrypt($this->_responseBody['callbackAuth']);
		$clientAuth				= (strtolower($authText) == strtolower($_SERVER['REQUEST_URI'])) ? true : false;

		// Callback 인증이 안되면 에러
		if ($clientAuth !== true) {
			$return['success']	= 'N';
			$return['message']	= 'Callback Auth Fail!!';
			$returnJson			= json_encode($return);
			header('HTTP/1.1 500 Internal Server Error');
			exit($returnJson);
		}


		$requestId			= $this->_responseBody['resultBody']['RequestId'];
		$this->_queueInfo	= $this->connectormodel->getMarketQueueList($requestId);


		if (isset($this->_queueInfo['request_id']) === false) {
			//미리 저장된 request_id가 없으면 에러(500에러)
			$return['success']	= 'N';
			$return['message']	= 'Not Found RequestId';
			$returnJson			= json_encode($return);

			header('HTTP/1.1 500 Internal Server Error');
			exit($returnJson);
		}
		
		// 삭제 처리
		$this->db->delete('fm_market_queue_list', array('request_id' => $requestId));
	}

	public function market_product_update() {

		$requestInfo	= $this->_responseBody['requestInfo'];
		$resultData		= $this->_responseBody['resultBody'];
		$requestId		= $resultData['RequestId'];
		$marketName		= $this->supportMarkets[strtolower($requestInfo['market'])]['name'];
		

		if (isset($this->_queueInfo['other_info']['fmMarketProductSeq']) !== true) {
			//미리 저장된 fmMarketProductSeq가 없으면 에러(500에러)
			$return['success']	= 'N';
			$return['message']	= 'Not Found Code';
			$returnJson			= json_encode($return);

			header('HTTP/1.1 500 Internal Server Error');
			exit($returnJson);
		}

		// Callback 처리
		$fmMarketProductSeq	= $this->_queueInfo['other_info']['fmMarketProductSeq'];
		$distLog			= "{$marketName} 상품 수정 Queue Callback({$requestId}-{$this->_queueInfo['market']}) - ";

		
		if ($resultData['success'] != 'Y') {
			// 수정 실패
			$distLog	.= "{$resultData['message']}";
			$distInfo['last_result']	= 'N';

			$return['success']			= 'N';
			$return['message']			= $distLog;
		} else {

			$response		= $this->_goodsService->syncProductStatusFromMarket($requestInfo['code'], $this->_queueInfo['market'], $this->_queueInfo['seller_id']);
			
			// 수정 성공
			$distInfo['last_result']	= 'Y';
			$return['success']			= 'Y';

			if ($response['success'] == 'Y')
				$distLog	.= "성공";
			else
				$distLog	.= "성공({$response['message']})";
		}


		$return['message']			= $distLog;

		$distInfo['last_distributed_time']	= date('Y-m-d H:i:s');

		$this->_goodsService->makeMarketProductLog($fmMarketProductSeq, $requestInfo['code'], $distLog);
		$this->_goodsService->updateMarketProductInfo($fmMarketProductSeq, $distInfo);
		
		// =========================================
		// 처리 결과를 상품 상세 내역에 업데이트 시작
		// =========================================
		try {
			if($fmMarketProductSeq>0){
				$this->load->model('goodsmodel');

				// 마켓 상품 고유키로 퍼스트몰 상품 정보 얻기
				unset($paramsMarketProduct);
				$paramsMarketProduct['fmMarketProduceSeq'] = $fmMarketProductSeq;
				$marketProduct = $this->connectormodel->getMarketProductList($paramsMarketProduct);

				if(isset($marketProduct) && $marketProduct[0]['goods_seq']){
					$goodsSeq = $marketProduct[0]['goods_seq'];
					$market_product_code = $marketProduct[0]['market_product_code'];
					$fmGoods = $this->goodsmodel->get_goods($goodsSeq);
					$admin_log = $fmGoods['admin_log'];

					unset($goods);
					$goods['update_date']	= date("Y-m-d H:i:s",time());
					$goods['admin_log']		= "<div>".date("Y-m-d H:i:s")." 오픈마켓".(($marketName)?"(".$marketName.")":"")." 상품 정보(".$market_product_code.") 수정에 ".(($return['success']=="Y")?"성공":"실패")." 했습니다.</div>".$admin_log;
					$this->db->where('goods_seq', $goodsSeq);
					$result	= $this->db->update('fm_goods', $goods);
				}
			}
		} catch (Exception $ex) {
			$logDir = ROOTPATH."/data/cronlog/market_connect_callback_".date("ymd").".log";
			$fp = fopen($logDir,"a+");
			fwrite($fp,"[".date('Y-m-d H:i:s')."] - ");
			ob_start();
			print_r($ex);
			$ob_msg = ob_get_contents();
			ob_clean();

			if(fwrite($fp, " ".$ob_msg."\n") === FALSE)
			{
			fclose($fp);
			return 0;
			}
			fclose($fp);
		}
		// =========================================
		// 처리 결과를 상품 상세 내역에 업데이트 종료
		// =========================================
		
		echo json_encode($return);
	}


	public function market_product_status_change() {

		$requestInfo	= $this->_responseBody['requestInfo'];
		$resultData		= $this->_responseBody['resultBody'];
		$requestId		= $resultData['RequestId'];
		$marketName		= $this->supportMarkets[strtolower($requestInfo['market'])]['name'];

		if (isset($this->_queueInfo['other_info']['fmMarketProductSeq']) !== true) {
			//미리 저장된 fmMarketProductSeq가 없으면 에러(500에러)
			$return['success']	= 'N';
			$return['message']	= 'Not Found Code';
			$returnJson			= json_encode($return);

			header('HTTP/1.1 500 Internal Server Error');
			exit($returnJson);
		}

		// Callback 처리
		$fmMarketProductSeq	= $this->_queueInfo['other_info']['fmMarketProductSeq'];
		$distLog			= "{$marketName} 상품 상태 변경 Queue Callback({$requestId}) - ";
		
		if ($resultData['success'] != 'Y') {
			// 수정 실패
			$distLog	.= "{$resultData['message']}";
			$distInfo['last_result']	= 'N';

			$return['success']			= 'N';
		} else {

			$response		= $this->_goodsService->syncProductStatusFromMarket($requestInfo['code'], $this->_queueInfo['market'], $this->_queueInfo['seller_id']);

			// 수정 성공
			$distInfo['last_result']	= 'Y';
			$return['success']			= 'Y';

			if ($response['success'] == 'Y')
				$distLog	.= "성공";
			else
				$distLog	.= "성공({$response['message']})";
		}

		$return['message']			= $distLog;

		$distInfo['last_distributed_time']	= date('Y-m-d H:i:s');

		$this->_goodsService->makeMarketProductLog($fmMarketProductSeq, $requestInfo['code'], $distLog);
		$this->_goodsService->updateMarketProductInfo($fmMarketProductSeq, $distInfo);
		
		echo json_encode($return);

		/*
		$writeText	= print_r($return, 1);
		$log_dir = "/www/b2cdev_firstmall_kr/log";
		$log_file = fopen($log_dir."/log.txt", "a");  
		fwrite($log_file,$writeText."\n\n\n====================================\n");  
		fclose($log_file);
		*/
	
		
	}
}



			
