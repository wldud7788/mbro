<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/common_base".EXT);
class _market extends common_base {
	
	protected $_connectorBasic;
	protected $beginDate;
	protected $endDate;

	public $supportMarkets		= array();

	public function __construct(){
		date_default_timezone_set('Asia/Seoul');
		parent::__construct();

		$this->load->library('Connector');
		$connector	= $this->connector::getInstance();

		$dateTimeObj	= new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('ASIA/SEOUL'));
		$dateTime		= $dateTimeObj->format("Y-m-d H:i:s T");

		$this->load->model('connectormodel');
		$this->_connectorBasic	= $this->connector::getInstance();
		$this->supportMarkets	= $this->_connectorBasic->getAllMarkets();
		// 샵링커/직접연동 마켓 구분
		$MarketLinkage	= config_load('MarketLinkage');
		$isShoplinker = ($MarketLinkage['shopCode'] == "shoplinker");
		foreach($this->supportMarkets as $key => $val) {
		    if( (strpos($key,"API") !== false) === !$isShoplinker) {
		        unset($this->supportMarkets[$key]);
		    }
		}
		$this->beginDate		= date('Y-m-d', strtotime('-7 Day'));
		$this->endDate			= date('Y-m-d');
	}

	public function getCronOrders(){
		$this->load->library('batchLib');
		$MarketLinkage	= config_load('MarketLinkage');
		echo chr(10) . __FUNCTION__.' - '.str_replace(APPPATH.'controllers/', '', __FILE__);
		$sLogFile	= 'marketGetCronOrders_'.date('Ym').'.log';
		$this->batchlib->_cronFileLog($sLogFile, 'Market Order Collect cron Start...');
		try {
			$marketList		= $this->supportMarkets;
			$orderService	= $this->connector::getInstance('order');
			$url			= "Order/getOrderList/{$this->beginDate}/{$this->endDate}";
			foreach((array)$marketList as $marketKey => $market) {
				foreach((array)$market['sellerList'] as $sellerId) {
					$orderService->setMarketInfo($marketKey, $sellerId);
					
					if(stripos($marketKey,"API") !== false){
						$postVal['request']['shoplinkerId'] = $MarketLinkage['shoplinkerId'];
					}else{
						$postVal = array();
					}
					
					$response	= $orderService->callConnector($url, $postVal);
					
					$sMsg = "{$market['name']}($sellerId) - ";
					
					if ($response['success'] == 'Y') {
						$return	= $orderService->marketOrderInseart($marketKey, $sellerId, $response['resultData']);
						if ($MarketLinkage['openmarket_auto_regist_order'] == 'Y') $orderService->orderMoveToFmOrder($return); // 주문 자동 등록
						$this->batchlib->_cronFileLog($sLogFile, $sMsg . $return['message']);
					} else {
						/**
						 * throw Exception 처리할 경우 반복문에서 벗어나기 때문에 모든 마켓을 조회하지 않는 오류 수정
						 * 2019-08-21
						 * @author Sunha Ryu
						 */
						$this->batchlib->_cronFileLog($sLogFile, $sMsg . '수집된 주문이 없습니다.');
					}
				}
			}
		} catch (Exception $e) {
			$this->batchlib->_cronFileLog($sLogFile, $e->getMessage());
		}
		$this->batchlib->_cronFileLog($sLogFile, 'Market Order Collect cron end...');
	}

	public function getCronClaim() {
        $this->load->library('batchLib');
        echo chr(10) . __FUNCTION__.' - '.str_replace(APPPATH.'controllers/', '', __FILE__);
        $sLogFile   = 'marketgetCronClaim_'.date('Ym').'.log';
        $this->batchlib->_cronFileLog($sLogFile, 'Market Claim Collect cron Start...');
        try {
            $marketList		= $this->supportMarkets;
            $claimService	= $this->connector::getInstance('claim');
            $url			= "Claim/getClaimList/{$this->beginDate}/{$this->endDate}";

            foreach((array)$marketList as $marketKey => $market) {
                foreach((array)$market['sellerList'] as $sellerId) {
                    $claimService->setMarketInfo($marketKey, $sellerId);

                    if(stripos($marketKey,"API") !== false){
                        $MarketLinkage	= config_load('MarketLinkage');
                        $postVal['request']['shoplinkerId'] = $MarketLinkage['shoplinkerId'];
                    }else{
                        $postVal = array();
                    }

                    $response	= $claimService->callConnector($url,$postVal);
                    $sMsg = "{$market['name']}($sellerId) - ";

                    if ($response['success'] == 'Y') {
                        $return	= $claimService->marketClaimInseart($marketKey, $sellerId, $response['resultData']);
                        $this->batchlib->_cronFileLog($sLogFile, $sMsg . $return['message']);
                    } else {
                        /**
                         * throw Exception 처리할 경우 반복문에서 벗어나기 때문에 모든 마켓을 조회하지 않는 오류 수정
                         * 2019-08-21
                         * @author Sunha Ryu
                         */
                        $this->batchlib->_cronFileLog($sLogFile, $sMsg . '수집된 클레임이 없습니다.');
                    }
                }
            }
        } catch (Exception $e) {	
            $this->batchlib->_cronFileLog($sLogFile, $e->getMessage());
        }
        $this->batchlib->_cronFileLog($sLogFile, 'Market Claim Collect cron end...');
	}

	public function getCronQna() {
        $this->load->library('batchLib');
        echo chr(10) . __FUNCTION__.' - '.str_replace(APPPATH.'controllers/', '', __FILE__);
        $sLogFile   = 'marketgetCronQna_'.date('Ym').'.log';
        $this->batchlib->_cronFileLog($sLogFile, 'Market Qna Collect cron Start...');
        try {
            $marketList		= $this->supportMarkets;
            $qnaService	= $this->connector::getInstance('qna');
            $url			= "Qna/getQnaList/{$this->beginDate}/{$this->endDate}";

            foreach((array)$marketList as $marketKey => $market) {
                foreach((array)$market['sellerList'] as $sellerId) {
                    $qnaService->setMarketInfo($marketKey, $sellerId);

                    if(stripos($marketKey,"API") !== false){
                        $MarketLinkage	= config_load('MarketLinkage');
                        $postVal['request']['shoplinkerId'] = $MarketLinkage['shoplinkerId'];
                    }else{
                        $postVal = array();
                    }

                    $response	= $qnaService->callConnector($url,$postVal);
                    $sMsg = "{$market['name']}($sellerId) - ";

                    if ($response['success'] == 'Y') {
                        $return	= $qnaService->marketQnaInsert($marketKey, $sellerId, $response['resultData']);
                        $this->batchlib->_cronFileLog($sLogFile, $sMsg . $return['message']);
                    } else {
                        /**
                         * throw Exception 처리할 경우 반복문에서 벗어나기 때문에 모든 마켓을 조회하지 않는 오류 수정
                         * 2019-08-21
                         * @author Sunha Ryu
                         */
                        $this->batchlib->_cronFileLog($sLogFile, $sMsg . '수집된 문의가 없습니다.');
                    }
                }
            }
        } catch (Exception $e) {	
            $this->batchlib->_cronFileLog($sLogFile, $e->getMessage());
        }
        $this->batchlib->_cronFileLog($sLogFile, 'Market Qna Collect cron end...');
	}

}