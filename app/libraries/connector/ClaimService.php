<?php

Class ClaimService  extends ServiceBase
{

	protected $_ServiceName		= 'claim';
	public $orderStatus;
	
	public function __construct($params = array())
	{
		parent::__construct($params);
		$this->_CI->load->model('connectormodel');
		$this->orderStatus	= $this->getStatusCode('order');
		
		/*2017-12-06 샵링커 마켓 설정 추가*/
		$find			= $this->_CI->db->query("SELECT * FROM fm_market_account WHERE market LIKE 'API%' and delete_yn = 'N' and account_use = 'Y' group by market");
		$findRow		= $find->result();
		
		$this->_CI->load->model('connectormodel');
		$connectorModel		=& $this->_CI->connectormodel;
		foreach ($findRow as $val){
			$getParam['searchMarket'] = $val->market;
			$rtn = $connectorModel->getLinkageMarket($getParam);
			$this->_supportMarkets[$val->market]['name'] = $rtn[0]['marketName'];
			$this->_supportMarkets[$val->market]['productLink'] = '';
		}
		
		/*2017-12-06 샵링커 마켓 설정 추가*/
		
		// 주문 로그 생성을 위한 마켓 정보 얻기
		$_connectorBase	= $this->_CI->connector::getInstance();
		$this->_supportMarketNames	= $_connectorBase->getAllMarkets();
	}

	public function getServiceName(){ return $this->_ServiceName; }


	/* 마켓 클레임 등록 */
	public function marketClaimInseart($market, $sellerId, $claimList)
	{
		
		$connectorModel		=& $this->_CI->connectormodel;

		$skipCnt			= 0;
		$refundCompleteList	= array();
		$totalClaim			= 0;
		$skipClaim			= 0;
		$requestCancel		= 0;
		
		$this->setMarketInfo($market, $sellerId);

		foreach ((array)$claimList as $claimRow) {

			$nowMarketClaimSeq		= 0;
			$totalClaim++;
			
			$searchClaim					= array();
			$searchClaim['marketOrderNo']	= $claimRow['marketOrderNo'];
			$searchClaim['marketClaimCode']	= $claimRow['marketClaimCode'];
			
			// 샵링커에서 온 클레임(취소건)일 경우에는  marketClaimCode(샵링커 주문번호)로 조회
			if( (strpos($market,"API") !== false) && $claimRow['marketOrderSeq'] === 1 &&  !empty($claimRow['marketClaimCode'])) {
			    $searchClaim['openmarketOrderId']     = $claimRow['marketClaimCode'];
			} else {
			    $searchClaim['marketOrderSeq']		= $claimRow['marketOrderSeq'];
			}
			
			$checkList						= $connectorModel->getMarketClaimList($searchClaim);

			if (count($checkList) > 0) {
				$skipClaim++;
				continue;
			}
		
			$claimParams							= array();
			$claimParams['market_order_no']			= $claimRow['marketOrderNo'];
			$claimParams['market']					= $market;
			$claimParams['seller_id']				= $sellerId;
			$claimParams['is_fm_order']				= 'N';
			$claimParams['market_delivery_no']		= $claimRow['marketDeliveryNo'];
			$claimParams['market_order_seq']		= $claimRow['marketOrderSeq'];
			$claimParams['market_product_code']		= $claimRow['marketProductCode'];
			$claimParams['market_claim_code']		= $claimRow['marketClaimCode'];
			$claimParams['claim_type']				= $claimRow['claimType'];
			$claimParams['fm_claim_code']			= '';
			$claimParams['claim_status']			= $claimRow['claimStatus'];
			$claimParams['request_qty']				= $claimRow['requestQty'];
			$claimParams['claim_registrant']		= $claimRow['claimRegistrant'];
			$claimParams['claim_reason']			= $claimRow['claimReason'];
			$claimParams['claim_reason_desc']		= $claimRow['claimReasonDesc'];
			$claimParams['claim_raw_info']			= json_encode($claimRow['claimRawInfo']);
			$claimParams['registered_time']			= $claimRow['registeredTime'];
			$claimParams['renewed_time']			= '0000-00-00 00:00:00';
			$claimParams['claim_close_time']		= '0000-00-00 00:00:00';
			

			if ($claimRow['claimType']  == 'EXC') {
				$claimParams['exchange_name']			= $claimRow['exchangeName'];
				$claimParams['exchange_zipcode']		= $claimRow['exchangeZipcode'];
				$claimParams['exchange_address']		= $claimRow['exchangeAddress'];
				$claimParams['exchange_address_detail']	= $claimRow['exchangeAddressDetail'];
				$claimParams['exchange_cellphone']		= $claimRow['exchangeCellphone'];
				$claimParams['exchange_tel']			= $claimRow['exchangeTel'];

			}



			if ($claimRow['claimStatus'] == 'CAN10')
				$claimParams['claim_close_time']	= $claimRow['claimCloseTime'];
						

			$searchOrder						= array();
			$searchOrder['marketOrderNo']		= $claimRow['marketOrderNo'];
			$searchOrder['marketProductCode']	= $claimRow['marketProductCode'];
			
			// 샵링커에서 온 클레임(취소건)일 경우에는  marketClaimCode(샵링커 주문번호)로 조회
			if( (strpos($market,"API") !== false) && $claimRow['marketOrderSeq'] === 1 &&  !empty($claimRow['marketClaimCode'])) {
			    $searchOrder['openmarketOrderId']     = $claimRow['marketClaimCode'];
			} else {
			    $searchOrder['marketOrderSeq']		= $claimRow['marketOrderSeq'];
			}

			$marketOrderList	= $connectorModel->getMarketOrderList($searchOrder, 'onlyMarketOrder');

			if (isset($marketOrderList[0]['market_product_code'])) {
				$claimParams['fm_market_order_seq']		= (int)$marketOrderList[0]['seq'];
				$claimParams['market_delivery_no']		= $marketOrderList[0]['market_delivery_no'];
				$claimParams['market_order_seq']		= $marketOrderList[0]['market_order_seq'];
				$claimParams['is_fm_order']				= 'Y';
			}

			$result				= $this->_CI->db->insert('fm_market_claims', $claimParams);
			$nowMarketClaimSeq	= $this->_CI->db->insert_id();

			if (isset($marketOrderList[0]['fm_order_seq']) && $claimRow['claimStatus'] == 'CAN10')
				$refundCompleteList[]	= $nowMarketClaimSeq;


			/*
			if ($marketOrderInfo['fm_market_order_seq'] > 0) {
				// 마켓주문 상태 갱신(취소는 따로 처리)
				if ($claimParams['claim_status'] != 'CAN10' && $claimParams['claim_status'] != $marketOrderInfo['market_order_status']) {
					$orderStatusParams			= array();
					$orderStatusParams['market_order_status']	= $claimParams['claim_status'];
					$this->_CI->db->update('fm_market_orders', $orderStatusParams, array('seq'=>$marketOrderInfo['fm_market_order_seq']));
				}				
			}

			if ($marketOrderInfo['fm_order_seq'] > 0)
				$this->registFmOrderCancel($nowMarketClaimSeq, $marketOrderInfo['fm_order_seq'], $claimRow['requestQty'], 'complete');
			*/
		}


		$requestCancel		= count($refundCompleteList);

		if (count($refundCompleteList) > 0)
			$return['cancelResult']	= $this->registerFmOrderCancel($refundCompleteList);
		

		$return['success']	= 'Y';
		$return['message']	= '총 수집 클래임'.number_format($totalClaim).' 개 / ';
		$return['message']	.= '이전 수집된 클래임 '.number_format($skipClaim).' 개 / ';
		$return['message']	.= '취소 완료된 클래임 '.number_format($requestCancel).' 개';


		return $return;
	}


	/* 취소주문 퍼스트몰 등록 */
	public function registerFmOrderCancel($refundCompleteList, $rejectList = array()) {

		if(count($refundCompleteList) < 1)
			return false;

		$this->_CI->load->model('ordermodel');
		$this->_CI->load->model('refundmodel');
		$this->_CI->load->model('goodsmodel');


		$orderModel		=& $this->_CI->ordermodel;
		$goodsModel		=& $this->_CI->goodsmodel;
		$refundModel	=& $this->_CI->refundmodel;
		$connectorModel	=& $this->_CI->connectormodel;

		$minfo			= $this->_CI->session->userdata('manager');
		$managerSeq		= $minfo['manager_seq'];


		$claimParams['listSeq']		= $refundCompleteList;
		$claimParams['claimType']	= 'CAN';
		$refundList					= $connectorModel->getMarketClaimList($claimParams, 'forRegisterClaim');
	
		$errorList			= array();
		$targetList			= array();

		foreach((array)$refundList as $row) {
			$fmOrderSeq		= $row['fm_order_seq'];
			$fmItemSeq		= $row['fm_item_seq'];
			$fmOptionSeq	= $row['fm_item_option_seq'];
			$fmSuboptionSeq	= $row['fm_item_suboption_seq'];
			$claimKey		= "{$fmItemSeq}_{$fmOptionSeq}_{$fmSuboptionSeq}";
			
			$beginDate		= date('Y-m-d', $row['registered_timestamp']);
			$endDate		= ($row['registered_timestamp'] < $row['claim_close_timestamp']) ? date('Y-m-d', $row['claim_close_timestamp']) : date('Y-m-d');

			$this->setMarketInfo($row['market'], $row['seller_id']);
			
			if(stripos($row['market'],"API") !== false){
				$MarketLinkage	= config_load('MarketLinkage');
				$postVal['request']['shoplinkerId'] = $MarketLinkage['shoplinkerId'];
				$row['market_claim_code'] = $row['market_order_no'];
			}else{
				$postVal = false;
			}
			
			$statusResult	= $this->callConnector("Claim/getClaimStatus/{$beginDate}/{$endDate}/CAN/{$row['market_claim_code']}", $postVal);
			$claimStatus	= $statusResult['resultData'];

			if ($claimStatus['claimStatus'] != 'CAN10') {
				unset($targetList[$fmOrderSeq]);
				$errMessge			= "[{$this->_supportMarkets[$row['market']]['name']} 주문번호 - {$row['market_order_no']}] \"{$row['market_product_code']}\"상품의 주문 상태를 확인해 주세요";
				$return['error'][]	= $errMessge;
				$errParams		= array();
				$errParams['last_message']	= $errMessge;
				$errParams['renewed_time']	= date('Y-m-d H:i:s');
				$this->_CI->db->update('fm_market_claims', $errParams, array('seq' => $row['fm_market_claim_seq']));
				continue;
			}

			// 취소 완료시 취소 수량 갱신
			if ($claimStatus['claimStatus'] == 'CAN10') {
				$cancelParams	= array();
				$cancelParams['order_cancel_qty']		= $row['request_qty'] + $row['order_cancel_qty'];
				$cancelParams['market_order_status']	= ($cancelParams['order_cancel_qty'] >= $row['order_qty']) ? 'CAN10' : 'ORD20';
				$cancelParams['order_cancel_qty']		= ($cancelParams['order_cancel_qty'] > $row['order_qty']) ? $row['order_qty'] : $cancelParams['order_cancel_qty'];

				$this->_CI->db->update('fm_market_orders', $cancelParams, array('seq'=>$row['fm_market_order_seq']));
			}

			if(isset($targetList[$fmOrderSeq][$claimKey]) !== true) {
				$targetList[$fmOrderSeq]['list'][$claimKey]	= $row;
			} else {
				$targetList[$fmOrderSeq]['list'][$claimKey]['request_qty']		+= $row['request_qty'];
				$targetList[$fmOrderSeq]['list'][$claimKey]['totql_cancel_qty']	+= $row['order_cancel_qty'];
			}
		
			$targetList[$fmOrderSeq]['seqList'][]	= $row['fm_market_claim_seq'];	// 클래임seq


			$shippingInfo		= $orderModel->get_order_shipping($fmOrderSeq);
			$shippingArr		= array();
			$totalShippingCost	= 0;

			foreach ($shippingInfo as $key => $shippingInfo) {
				if ($shippingInfo['shipping_method'] == 'shipping_method') 
					continue;
				
				$shippingInfo['provider_seq']				= ((int)$shippingInfo['provider_seq'] < 2) ? 1 : $shippingInfo['provider_seq'];

				$shippingArr[$shippingInfo['provider_seq']]	+= $shippingInfo['shipping_cost'];
				$totalShippingCost							+= $shippingInfo['shipping_cost'];

			}

			

			$targetList[$fmOrderSeq]['count']				+= $row['request_qty'];	// 해당옵션 전체 취소건수
			$targetList[$fmOrderSeq]['totalShippingCost']	= $totalShippingCost;	// 해당주문 전체 배송비
			$targetList[$fmOrderSeq]['prividerShipping']	= $shippingArr;			// 해당주문 판매처별 배송비
			
			// 개별배송 전체 상품이 취소된경우
			if ($row['market_order_status'] == 'CAN10' && isset($shippingInfo['each_delivery'.$row['fm_goods_seq']]) == true)
				$targetList[$fmOrderSeq]['eachShippingCost']	+= $shippingInfo['each_delivery'.$row['fm_goods_seq']]['shipping_cost'];


		}

		foreach((array)$targetList as $fmOrderSeq => $refundList) {

			$this->_CI->db->trans_begin();

			$orderQtyTotal			= $orderModel->get_order_total_ea($fmOrderSeq);
			
			$cancelType				= ($refundList['count'] == $orderQtyTotal) ? 'full' : 'partial';
			$baseRefundInfo			= array_shift(array_slice($refundList['list'], 0, 1)); ;
			$orderItemList			= array();
			$providerSum			= array();
			$fmGoodsSeqList			= array();
			$refundItemPriceList	= array();
			$refundProviderSum		= array();
			$deliveryCost			= (isset($targetList[$fmOrderSeq]['eachShippingCost'])) ? $targetList[$fmOrderSeq]['eachShippingCost'] : 0;
			$totalRefundPrice		= 0;
						
			$params['fmOrderSeq']	= $fmOrderSeq;
			$marketOrderList		= $connectorModel->getMarketOrderList($params, 'onlyOrder');
			$providerOrderQty		= array();
			$providerListByItem		= array();
			$providerSeq			= 0;
			$totalLeftQty			= 0;
			

			// 남은 주문수량 확인
			foreach ($marketOrderList as $marketOrder) {
				$providerSeq		= ($marketOrder['provider_seq'] > 0 ) ? $marketOrder['provider_seq'] : 1;
				$totalLeftQty		+= $marketOrder['order_qty'] - $marketOrder['order_cancel_qty'];

				$providerOrderQty[$providerSeq]						+= $marketOrder['order_qty'] - $marketOrder['order_cancel_qty'];
				$providerListByItem[$marketOrder['fm_item_seq']]	= $providerSeq;
				
			}

			foreach((array) $refundList['list'] as $refundInfo) {
				
				$cancelRequestQty			= $refundInfo['request_qty'];

				$nowItem					= array();
				$nowItem['item_seq']		= $refundInfo['fm_item_seq'];
				$nowItem['option_seq']		= ($refundInfo['fm_item_suboption_seq'] > 0) ? 0 : $refundInfo['fm_item_option_seq'];
				$nowItem['suboption_seq']	= $refundInfo['fm_item_suboption_seq'];
				$nowItem['ea']				= $cancelRequestQty;
				

				if($refundInfo['fm_item_suboption_seq'] < 1) {

					$mode		= 'option';
					$orderModel->set_step_ea(85, $cancelRequestQty, $refundInfo['fm_item_option_seq'], $mode);

					$query		= "select o.*, i.goods_seq from fm_order_item_option o, fm_order_item i  where o.item_seq=i.item_seq and o.item_option_seq=?";
					$query		= $this->_CI->db->query($query, array($refundInfo['fm_item_option_seq']));
					$optionData = $query->row_array();

					if ($optionData['ea'] == $optionData['step85'])
						$this->_CI->db->set('step','85');

					$this->_CI->db->set('refund_ea','refund_ea+'.$cancelRequestQty,false);
					$this->_CI->db->where('item_option_seq', $refundInfo['fm_item_option_seq']);
					$this->_CI->db->update('fm_order_item_option');

					// 주문 option 상태 변경
					$orderModel->set_option_step($refundInfo['fm_item_option_seq'],'option');


					// 반품으로 인한 원주문 추출 및 교체 :: 2015-08-13 pjm
					$query = $this->_CI->db->get_where('fm_order_item_option',
						array(
						'item_option_seq'	=> $refundInfo['fm_item_option_seq'],
						'item_seq'			=> $refundInfo['fm_item_seq'])
					);
					$result = $query->result_array();
					
					if($result[0]['top_item_option_seq'])
						$nowItem['option_seq']	= $result[0]['top_item_option_seq'];

					if($result[0]['top_item_seq'])
						$nowItem['item_seq']	= $result[0]['top_item_seq'];

				} else {
					$mode = 'suboption';
					$orderModel->set_step_ea(85, $cancelRequestQty,$refundInfo['fm_item_suboption_seq'],$mode);

					$query = "select o.*, i.goods_seq from fm_order_item_suboption o, fm_order_item i  where o.item_seq=i.item_seq and o.item_suboption_seq=?";
					$query = $this->_CI->db->query($query,array($refundInfo['fm_item_suboption_seq']));
					$optionData = $query->row_array();

					if($optionData['ea']==$optionData['step85'])
						$this->_CI->db->set('step','85');

					$this->_CI->db->set('refund_ea','refund_ea+'.$cancelRequestQty,false);
					$this->_CI->db->where('item_suboption_seq',$refundInfo['fm_item_suboption_seq']);
					$this->_CI->db->update('fm_order_item_suboption');

					// 주문 option 상태 변경
					$orderModel->set_option_step($refundInfo['fm_item_suboption_seq'],'suboption');


					// 반품으로 인한 원주문 추출 및 교체 :: 2015-08-13 pjm
					$query	= $this->_CI->db->get_where('fm_order_item_suboption', array('item_suboption_seq'=>$refundInfo['fm_item_suboption_seq']));
					$result	= $query->result_array();
					if($result[0]['top_item_suboption_seq'])
						$nowItem['suboption_seq'] = $result[0]['top_item_suboption_seq'];
				}

				$fmGoodsSeqList[]		= $refundInfo['fm_goods_seq'];
				$orderItemList[]		= $nowItem;
				$totalRefundPrice		+= $cancelRequestQty * $result[0]['price'];

				
				$itemKey	= "{$nowItem['item_seq']}{$nowItem['option_seq']}{$nowItem['suboption_seq']}";
				$refundItemPriceList[$itemKey]		= $cancelRequestQty * $result[0]['price'];

				//입점사 배송비 / 환불금액
				$providerSeq						= $providerListByItem[$refundInfo['fm_item_seq']];
				$refundProviderSum[$providerSeq]	= $cancelRequestQty * $result[0]['price'];

				if ($providerOrderQty[$providerSeq] < 1) {
					// 배송비 등록 수정 :: 2018-05-14 lkh
					$refundItemDeliveryPriceList[$itemKey] = $shippingArr[$providerSeq];
					$deliveryCost					+= $shippingArr[$providerSeq];
					$shippingArr[$providerSeq]		= 0;	// 
				}
			}

		
			if($totalLeftQty < 1) {
				$refundDeliveryCost		= $targetList[$fmOrderSeq]['totalShippingCost'];
				$orderModel->set_step($fmOrderSeq, 85);
			} else {
				$refundDeliveryCost		= $deliveryCost;
			}



			$refundParams	= array();
			$refundParams['order_seq']			= $fmOrderSeq;
			$refundParams['refund_method']		= 'bank';
			$refundParams['bank_name']			= '';
			$refundParams['bank_depositor']		= '';
			$refundParams['bank_account']		= '';
			$refundParams['refund_reason']		= "[{$this->_supportMarkets[$baseRefundInfo['market']]['name']}] {$baseRefundInfo['claim_reason']} {$baseRefundInfo['claim_reason_desc']}";
			$refundParams['refund_type']		= 'cancel_payment';
			$refundParams['status']				= 'complete';
			$refundParams['cancel_type']		= $cancelType;
			$refundParams['refund_price']		= $totalRefundPrice + $refundDeliveryCost;
			$refundParams['refund_delivery']	= $refundDeliveryCost;
			$refundParams['manager_seq']		= $managerSeq;
			$refundParams['regist_date']		= date('Y-m-d H:i:s');
			$refundParams['refund_date']		= $refundParams['regist_date'];
			$refundParams['admin_memo']			= "[{$this->_supportMarkets[$baseRefundInfo['market']]['name']}] 주문 취소";


			$refundCode	= $refundModel->insert_refund($refundParams, $orderItemList);
			$query		= $this->_CI->db->get_where('fm_order_refund_item', array('refund_code'=>$refundCode));
			$itemList	= $query->result_array();
			
			foreach ($itemList as $rowKey => $itemInfo) {
				$nowKey			= "{$itemInfo['item_seq']}{$itemInfo['option_seq']}{$itemInfo['suboption_seq']}";

				$nowItemParams	= array();
				$nowItemParams['refund_goods_price']		= $refundItemPriceList[$nowKey];

				if($refundItemDeliveryPriceList[$nowKey]){
					// 배송비 등록 수정 :: 2018-05-14 lkh
					$nowItemParams['refund_delivery_price']	= $refundItemDeliveryPriceList[$nowKey];
					//$nowItemParams['refund_delivery_price']	= $refundDeliveryCost;
				}

				$this->_CI->db->update('fm_order_refund_item', $nowItemParams, array('refund_item_seq' => $itemInfo['refund_item_seq']));
			}

			$logTitle	= "주문취소";
			$logDetail	= "[{$this->_supportMarkets[$baseRefundInfo['market']]['name']}] 주문취소가 완료되었습니다.";
			$logParams	= array('refund_code' => $refund_code);
			
			// 주문 로그 생성
			$orderLogTitle = "[".$this->_supportMarketNames[$baseRefundInfo['market']]['name']."] 취소완료 (API)";
			$orderModel->set_log($fmOrderSeq, 'process', ($this->_CI->managerInfo['mname'])?$this->_CI->managerInfo['mname']:"시스템", $orderLogTitle, $logDetail, $logParams);
			
			$orderModel->set_log($fmOrderSeq, 'complete', ($this->_CI->managerInfo['mname'])?$this->_CI->managerInfo['mname']:"시스템", $logTitle, $logDetail, $logParams);

			$query		= $this->_CI->db->get_where('fm_order_refund_item', array('refund_code'=>$refundCode));
			$itemList	= $query->result_array();

			//$totalRefundPrice		+= $cancelRequestQty * $result[0]['price'];
			//$refundItemPriceList[$itemKey]		= $cancelRequestQty * $result[0]['price'];
			
			$refundParams						= array();
			$refundParams['fm_claim_code']		= $refundCode;
			$refundParams['last_message']		= '"주문취소" 완료';
			$refundParams['renewed_time']		= date('Y-m-d H:i:s');
			$refundParams['claim_status']		= 'CAN10';
			$refundParams['claim_close_time']	= $refundParams['renewed_time'];

			if (count($targetList[$fmOrderSeq]['seqList']) > 1)
				$this->_CI->db->where_in('seq', $targetList[$fmOrderSeq]['seqList']);
			else
				$this->_CI->db->where('seq', $targetList[$fmOrderSeq]['seqList'][0]);
		

			$this->_CI->db->update('fm_market_claims', $refundParams);
			$message				= "[{$this->_supportMarkets[$refundInfo['market']]['name']} 주문번호 - {$refundInfo['market_order_no']}] \"{$row['market_product_code']}\"상품 \"주문취소\" 완료";
			$return['success'][]	= $message;

			
			// 출고예약량 업데이트
			foreach($fmGoodsSeqList as $goodsSeq)
				$goodsModel->modify_reservation_real($goodsSeq);

			/**
			* 4-2 환불데이타를 이용한 통합정산테이블 생성 시작
			* @
			**/
			// 정산개선 미정산 추가 
			$this->_CI->load->helper('accountall');
			if(!$this->_CI->accountallmodel)	$this->_CI->load->model('accountallmodel');
			if(!$this->_CI->providermodel)	$this->_CI->load->model('providermodel');
			if(!$this->_CI->refundmodel)		$this->_CI->load->model('refundmodel');
			if(!$this->_CI->returnmodel)		$this->_CI->load->model('returnmodel');
			if(!$this->_CI->ordermodel)		$this->_CI->load->model('ordermodel');
			$data_order		= $this->_CI->ordermodel->get_order($fmOrderSeq);
			//정산대상 수량업데이트
			$this->_CI->accountallmodel->update_calculate_sales_ac_ea($fmOrderSeq,$refundCode, 'refund', null, $data_order);
			//정산확정 처리
			$this->_CI->accountallmodel->insert_calculate_sales_order_refund($fmOrderSeq, $refundCode, $cancelType, $data_order);//월별매출
			//debug_var($this->_CI->db->queries);
			//debug_var($this->_CI->db->query_times);
			/**
			* 3-2 환불데이타를 이용한 통합정산테이블 생성 끝
			* @
			**/

			$this->_CI->db->trans_commit();
			//$this->_CI->db->trans_rollback();
		}


		if (count($rejectList) > 0) {
			if (count($rejectList) > 1)
				$this->_CI->db->where_in('seq', $rejectList);
			else
				$this->_CI->db->where('seq', $rejectList[0]);

			$refundParams						= array();
			$refundParams['last_message']		= '취소거부된 클레임 입니다.';
			$refundParams['renewed_time']		= date('Y-m-d H:i:s');
			$refundParams['claim_status']		= 'CAN99';
			$refundParams['claim_close_time']	= $refundParams['renewed_time'];
			$this->_CI->db->update('fm_market_claims', $refundParams);

			foreach ((array)$rejectList as $orderInfo) {
				$orderParams					= array();
				$orderParams['last_message']	= '취소가 거부되었습니다.';
				$orderParams['renewed_time']	= $refundParams['renewed_time'];
				$orderParams['claim_status']	= ($orderInfo['invoice_num']) ? 'ORD40' : 'ORD20';
				$this->_CI->db->update('fm_market_claims', $orderParams, array('seq' => $orderInfo['fm_market_order_seq']));
			}
		}

		return $return;
	}


	/* 반품/교환 클레임 퍼스트몰 등록 */
	public function registerFmOrderReturn($returnRequestList, $claimType = 'RTN') {

		if(count($returnRequestList) < 1)
			return false;
		
		$this->_CI->load->model('ordermodel');
		$this->_CI->load->model('refundmodel');
		$this->_CI->load->model('exportmodel');
		$this->_CI->load->model('returnmodel');


		$orderModel		=& $this->_CI->ordermodel;
		$refundModel	=& $this->_CI->refundmodel;
		$exportModel	=& $this->_CI->exportmodel;
		$returnModel	=& $this->_CI->returnmodel;
		$connectorModel	=& $this->_CI->connectormodel;

		$minfo			= $this->_CI->session->userdata('manager');
		$managerSeq		= $minfo['manager_seq'];


		$claimParams['listSeq']		= $returnRequestList;
		$claimParams['claimType']	= $claimType;
		$returnList					= $connectorModel->getMarketClaimList($claimParams, 'forRegisterClaim');

		
		$errorList		= array();
		$targetList		= array();
		
		foreach((array)$returnList as $row) {
			$fmOrderSeq		= $row['fm_order_seq'];
			$claimCode		= $row['market_claim_code'];
			$fmItemSeq		= $row['fm_item_seq'];
			$fmOptionSeq	= $row['fm_item_option_seq'];
			$fmSuboptionSeq	= $row['fm_item_suboption_seq'];
			$claimKey		= "{$fmItemSeq}_{$fmOptionSeq}_{$fmSuboptionSeq}";
			
			$beginDate		= date('Y-m-d', $row['registered_timestamp']);
			$endDate		= ($row['registered_timestamp'] < $row['claim_close_timestamp']) ? date('Y-m-d', $row['claim_close_timestamp']) : date('Y-m-d');
			
			$this->setMarketInfo($row['market'], $row['seller_id']);
			
			if(stripos($row['market'],"API") !== false){
				$MarketLinkage	= config_load('MarketLinkage');
				$postVal['request']['shoplinkerId'] = $MarketLinkage['shoplinkerId'];
				$row['market_claim_code'] = $row['market_order_no'];
			}else{
				$postVal = false;
			}
			
			$statusResult	= $this->callConnector("Claim/getClaimStatus/{$beginDate}/{$endDate}/{$claimType}/{$row['market_claim_code']}",$postVal);
			$claimStatus	= $statusResult['resultData'];

			if ($claimStatus['claimStatus'] != $claimType.'00') {
				
				unset($targetList[$claimCode]);
				$errParams					= array();

				if ($claimStatus['claimStatus'] == $claimType.'10') {
					//완료된 클래임
					$errMessge					= "처리 완료된 클래임 입니다.";
					$return['error'][]			= $errMessge;
					$errParams['claim_status']	= $claimStatus['claimStatus'];
				} else {
					//기타
					$errMessge					= "[{$this->_supportMarkets[$row['market']]['name']} 주문번호 - {$row['market_order_no']}] \"{$row['market_product_code']}\"상품의 반품 상태를 확인해 주세요";
					$return['error'][]			= $errMessge;
				}

				$errParams['last_message']		= $errMessge;
				$errParams['renewed_time']		= date('Y-m-d H:i:s');
				$this->_CI->db->update('fm_market_claims', $errParams, array('seq' => $row['fm_market_claim_seq']));
				continue;
			}

			if($fmSuboptionSeq > 0 ) { 		// 추가옵션
				$params = array(
					"exp.order_seq" 				=> $fmOrderSeq,
					"item.item_seq" 				=> $fmItemSeq,
					"item.suboption_seq" 			=> $fmSuboptionSeq,
				);
				$option_type = "sub";
			} else {	// 필수옵션
				$params = array(
					"exp.order_seq" 				=> $fmOrderSeq,
					"item.item_seq" 				=> $fmItemSeq,
					"item.option_seq" 				=> $fmOptionSeq,
				);
				$option_type = "opt";
			}
			$exportQuery	= $exportModel->get_data_export_item($params,$option_type);
			$exportData 	= $exportQuery->row_array();
			if($exportData['export_code'] == '') {
				unset($targetList[$claimCode]);
				$errMessge			= "[{$this->_supportMarkets[$row['market']]['name']} 주문번호 - {$row['market_order_no']}] \"{$row['market_product_code']}\"상품의 출고 상태를 확인해 주세요";
				$return['error'][]	= $errMessge;
				$errParams					= array();
				$errParams['last_message']	= $errMessge;
				$errParams['renewed_time']	= date('Y-m-d H:i:s');
				$this->_CI->db->update('fm_market_claims', $errParams, array('seq' => $row['fm_market_claim_seq']));
				continue;
			}


			if(isset($targetList[$claimCode][$claimKey]) !== true) {
				$row['export_code']		  = $exportData['export_code'];
				$row['claim_reason_code'] = $claimStatus['claimReasonCode'];
				$targetList[$claimCode]['list'][$claimKey]	= $row;
			} else {
				$targetList[$claimCode]['list'][$claimKey]['request_qty']		+= $row['request_qty'];
			}
			

			$targetList[$claimCode]['seqList'][]	= $row['fm_market_claim_seq'];	// 클래임seq
		}

		foreach((array)$targetList as $claimCode => $returnList) {
				
			$baseReturnInfo			= array_shift(array_slice($returnList['list'], 0, 1));
			$fmOrderSeq				= $baseReturnInfo['fm_order_seq'];


			$orderItemList			= array();
			$returnItemPriceList	= array();
			$orderReturnList		= array();
			$totalReturnPrice		= 0;

			$this->_CI->db->trans_begin();
			
			$itemList		= array();
			$reason_code	= '';
			foreach($returnList['list'] as $retunInfo) {
				
				$returnRequestQty			= $retunInfo['request_qty'];

				$nowItem					= array();
				$nowItem['item_seq']		= $retunInfo['fm_item_seq'];
				$nowItem['option_seq']		= ($retunInfo['fm_item_suboption_seq'] > 0) ? 0 : $retunInfo['fm_item_option_seq'];
				$nowItem['suboption_seq']	= $retunInfo['fm_item_suboption_seq'];
				$nowItem['ea']				= $returnRequestQty;
				$nowItem['give_reserve']	= 0;
				$nowItem['give_point']		= 0;
				$nowItem['give_reserve_ea']	= 0;
				
				if($retunInfo['fm_item_suboption_seq'] < 1) {
					// 반품으로 인한 원주문 추출 및 교체 :: 2014-11-27 lwh
					$optionParams['item_option_seq']	= $nowItem['option_seq'];
					$optionParams['item_seq']			= $nowItem['item_seq'];
					$query		= $this->_CI->db->get_where('fm_order_item_option', $optionParams);
					$result		= $query->result_array();

					if($result[0]['top_item_option_seq'])
						$nowItem['option_seq']		= $result[0]['top_item_option_seq'];

					if($result[0]['top_item_option_seq'])
						$nowItem['item_seq']		= $result[0]['top_item_seq'];

					$query		= "select * from fm_order_item_option where item_option_seq=?";
					$query		= $this->_CI->db->query($query,array($nowItem['option_seq']));
					$optionData	= $query->row_array();

					if($claimType != 'EXC'){
						$this->_CI->db->set('refund_ea', 'refund_ea+'.$nowItem['ea'], false);
						$this->_CI->db->where('item_option_seq', $nowItem['option_seq']);
						$this->_CI->db->update('fm_order_item_option');
					}
				} else {
					// 반품으로 인한 원주문 추출 및 교체 :: 2014-11-27 lwh
					$subOptionParams['item_suboption_seq']	= $nowItem['suboption_seq'];
					$query		= $this->_CI->db->get_where('fm_order_item_suboption',$subOptionParams);
					$result		= $query->result_array();


					if($result[0]['top_item_suboption_seq'])
						$nowItem['suboption_seq']	= $result[0]['top_item_suboption_seq'];

					$query		= "select * from fm_order_item_suboption where item_suboption_seq=?";
					$query		= $this->_CI->db->query($query,array($nowItem['suboption_seq']));
					$optionData	= $query->row_array();

					if($claimType != 'EXC'){
						$this->_CI->db->set('refund_ea', 'refund_ea+'.$nowItem['ea'], false);
						$this->_CI->db->where('item_suboption_seq', $nowItem['suboption_seq']);
						$this->_CI->db->update('fm_order_item_suboption');
					}
				}
				
				if($claimType == 'EXC')		$returnType	= 'exchange';
				else						$returnType	= 'return';

				$fmGoodsSeqList[]				= $refundInfo['fm_goods_seq'];

				$orderItemList[]				= $nowItem;
				$reason_code					= $this->getTransReasonCode($retunInfo['claim_reason_code']);
				$returnItem						= array();
				$returnItem['item_seq']			= $nowItem['item_seq'];
				$returnItem['option_seq']		= $nowItem['option_seq'];
				$returnItem['suboption_seq']	= $nowItem['suboption_seq'];
				$returnItem['ea']				= $nowItem['ea'];
				$returnItem['reason_code']		= $reason_code;
				$returnItem['reason_desc']		= "[{$this->_supportMarkets[$retunInfo['market']]['name']}] {$retunInfo['claim_reason']} {$retunInfo['claim_reason_desc']}";
				$returnItem['export_code']		= $retunInfo['export_code'];
				$returnItem['give_reserve_ea']	= 0;
				$orderReturnList[]				= $returnItem;

				$itemKey	= "{$nowItem['item_seq']}{$nowItem['option_seq']}{$nowItem['suboption_seq']}";
				$returnItemPriceList[$itemKey]	= $returnRequestQty * $optionData['price'];
				$totalReturnPrice				+= $returnRequestQty * $optionData['price'];
			}
			
			$fmOrderInfo	= $orderModel->get_order($fmOrderSeq);

			if($claimType == 'EXC'){
				$refundCode	= '0';
				$returnType	= 'exchange';
			}else{
				// 반품시 최상위 주문번호 저장 :: 2014-11-27 lwh
				$returnType	= 'return';
				if($fmOrderInfo['top_orign_order_seq'])
					$orginOrderSeq		= $fmOrderInfo['top_orign_order_seq'];
				else
					$orginOrderSeq		= $fmOrderSeq;
					
				$refundParams					= array();
				$refundParams['order_seq']		= $orginOrderSeq;
				$refundParams['refund_method']	= 'bank';
				$refundParams['bank_name']		= '';
				$refundParams['bank_depositor']	= '';
				$refundParams['bank_account']	= '';
				$refundParams['refund_price']	= $totalReturnPrice;
				$refundParams['refund_reason']	= "[{$this->_supportMarkets[$baseReturnInfo['market']]['name']}] {$baseReturnInfo['claim_reason']} {$baseReturnInfo['claim_reason_desc']}";
				$refundParams['refund_type']	= $returnType;
				$refundParams['manager_seq']	= $managerSeq;
				$refundParams['regist_date']	= date('Y-m-d H:i:s');
				$refundParams['admin_memo']		= "[{$this->_supportMarkets[$baseReturnInfo['market']]['name']}] 반품환불";

				$refundCode		= $refundModel->insert_refund($refundParams, $orderItemList);
				$query			= $this->_CI->db->get_where('fm_order_refund_item', array('refund_code'=>$refundCode));
				$itemList		= $query->result_array();

				foreach ($itemList as $rowKey => $itemInfo) {
					$nowKey			= "{$itemInfo['item_seq']}{$itemInfo['option_seq']}{$itemInfo['suboption_seq']}";

					$nowItemParams	= array();
					$nowItemParams['refund_goods_price']	= $returnItemPriceList[$nowKey];

					$this->_CI->db->update('fm_order_refund_item', $nowItemParams, array('refund_item_seq' => $itemInfo['refund_item_seq']));
				}


				$logTitle	= "환불신청";
				$logDetail	= "[{$this->_supportMarkets[$baseRefundInfo['market']]['name']}] 관리자 반품신청에 의한 환불신청이 접수되었습니다.";
				$logParams	= array('refund_code' => $refund_code);
				$orderModel->set_log($orginOrderSeq, 'process', ($this->_CI->managerInfo['mname'])?$this->_CI->managerInfo['mname']:"시스템", $logTitle, $logDetail, $logParams);
			}

			// 반품 등록
			$returnParams									= array();
			$returnParams['status']							= 'request';
			$returnParams['order_seq']						= $fmOrderSeq;
			$returnParams['refund_code']					= $refundCode;
			$returnParams['reason_code']					= $reason_code;
			$returnParams['return_type']					= $returnType;
			$returnParams['return_reason']					= "[{$this->_supportMarkets[$baseReturnInfo['market']]['name']}] {$baseReturnInfo['claim_reason']} {$baseReturnInfo['claim_reason_desc']}";
			$returnParams['cellphone']						= $baseReturnInfo['exchange_cellphone'];
			$returnParams['phone']							= $baseReturnInfo['exchange_tel'];
			$returnParams['return_method']					= 'user';
			$returnParams['sender_zipcode']					= str_replace('-', '', $baseReturnInfo['exchange_zipcode']);
			$returnParams['sender_address_type']			= 'zibun';
			$returnParams['sender_address']					= $baseReturnInfo['exchange_address'];
			$returnParams['sender_address_street']			= '';
			$returnParams['sender_address_detail']			= $baseReturnInfo['exchange_address_detail'];
			$returnParams['regist_date']					= date('Y-m-d H:i:s');
			$returnParams['manager_seq']					= $managerSeq;
			$returnParams['shipping_price_depositor']		= '';
			$returnParams['shipping_price_bank_account']	= '';


			$returnCode		= $returnModel->insert_return($returnParams, $orderReturnList);

			$returnParams						= array();
			$returnParams['fm_claim_code']		= $returnCode;
			$returnParams['last_message']		= '"반품접수" 완료';
			$returnParams['renewed_time']		= date('Y-m-d H:i:s');

			if (count($returnList['seqList']) > 1)
				$this->_CI->db->where_in('seq', $returnList['seqList']);
			else
				$this->_CI->db->where('seq', $returnList['seqList'][0]);
		


			$this->_CI->db->update('fm_market_claims', $returnParams);



			$message				= "[{$this->_supportMarkets[$refundInfo['market']]['name']} 주문번호 - {$baseReturnInfo['market_order_no']}] \"{$row['market_product_code']}\"상품 \"반품접수\" 완료";
			$return['success'][]	= $message;
			
			if($claimType == 'EXC'){
				$title		="맞교환 신청이 완료되었습니다.";
				$logTitle	= "맞교환신청";
				$logDetail	= "[{$this->_supportMarkets[$baseRefundInfo['market']]['name']}] 관리자가 맞교환신청을 하였습니다.";
				
				$orderLogTitle = "[".$this->_supportMarketNames[$fmOrderInfo['linkage_mall_code']]['name']."] 교환요청 (API)";
			}else{
				$title		="반품 신청이 완료되었습니다.";
				$logTitle	= "반품신청";
				$logDetail	= "[{$this->_supportMarkets[$baseRefundInfo['market']]['name']}] 관리자가 반품신청을 하였습니다.";
				
				$orderLogTitle = "[".$this->_supportMarketNames[$fmOrderInfo['linkage_mall_code']]['name']."] 반품요청 (API)";
			}
			
			// 주문 로그 생성
			$orderModel->set_log($fmOrderSeq, 'process', ($this->_CI->managerInfo['mname'])?$this->_CI->managerInfo['mname']:"시스템", $orderLogTitle, $logDetail, $logParams);

			$logParams	= array('return_code' => $returnCode);
			$orderModel->set_log($fmOrderSeq, 'process', ($this->_CI->managerInfo['mname'])?$this->_CI->managerInfo['mname']:"시스템", $logTitle, $logDetail, $logParams);



			$this->_CI->db->trans_commit();
			//$this->_CI->db->trans_rollback();

		}
		
		return $return;

	}

	/* 마켓 환불 승인 처리 */
	public function marketClaimConfirm($fmClaimCode, $claimType = 'RTN') {
		
		$this->_CI->load->model('ordermodel');

		$orderModel				=& $this->_CI->ordermodel;
		$connectorModel			=& $this->_CI->connectormodel;

		$params['claimType']	= $claimType;
		$params['fmClaimCode']	= $fmClaimCode;
		$claimList				= $connectorModel->getMarketClaimList($params, 'withMarketOrder', true);
	

		if (count($claimList) < 1)
			return array('success' => 'Y', 'message' => '"연동 마켓" 주문이 아닙니다.');
		
		$baseRefundInfo			= $claimList[0];
		$marketCompleteFail		= false;
		$failInfo				= array();
		$renewedTime			= date('Y-m-d H:i:s');

		foreach ($claimList as $claimInfo) {
			$beginDate		= date('Y-m-d', $claimInfo['registered_timestamp']);
			$endDate		= ($claimInfo['registered_timestamp'] < $claimInfo['claim_close_timestamp']) ? date('Y-m-d', $claimInfo['claim_close_timestamp']) : date('Y-m-d');


			$returnParams['request']						= array();
			$returnParams['request']['marketClaimCode']		= $claimInfo['market_claim_code'];
			$returnParams['request']['marketOrderNo']		= $claimInfo['market_order_no'];
			$returnParams['request']['marketDeliveryNo']	= $claimInfo['market_delivery_no'];
			$returnParams['request']['marketOrderSeq']		= $claimInfo['market_order_seq'];
			$returnParams['request']['requestQty']			= $claimInfo['request_qty'];
			$returnParams['request']['registeredTime']		= $claimInfo['registered_time'];
			$returnParams['request']['marketClaimRawData']	= json_decode($claimInfo['claim_raw_info'],1);

			
			$this->setMarketInfo($claimInfo['market'], $claimInfo['seller_id']);
			
			if(stripos($claimInfo['market'],"API") !== false){
				$MarketLinkage	= config_load('MarketLinkage');
				$returnParams['request']['shoplinkerId'] = $MarketLinkage['shoplinkerId'];
			}
			
			$response		= $this->callConnector("Claim/doReturnComplete", $returnParams);

			if($response['success'] != 'Y') {
				$marketCompleteFail	= true;
				break;
			}
			
			$completedParams						= array();
			$completedParams['last_message']		= '반품완료된 클레임 입니다.';
			$completedParams['renewed_time']		= $renewedTime;
			$completedParams['claim_status']		= 'RTN10';
			$completedParams['claim_close_time']	= $renewedTime;;
			$this->_CI->db->update('fm_market_claims', $completedParams, array('seq' => $claimInfo['seq']));

		}

		if ($marketCompleteFail === true) {
			$title		= "마켓 반품 실패";
			$logTitle	= "[{$this->_supportMarkets[$baseRefundInfo['market']]['name']}] 주문번호 - {$baseRefundInfo['market_order_no']} 반품실패";
			$logDetail	= "[{$this->_supportMarkets[$baseRefundInfo['market']]['name']}] 주문번호 - {$baseRefundInfo['market_order_no']} 관리자가 반품완료가 실패 하였습니다.";

			$logParams	= array('return_code' => $fmClaimCode);
			$orderModel->set_log($baseRefundInfo['fm_order_seq'], 'process', ($this->_CI->managerInfo['mname'])?$this->_CI->managerInfo['mname']:"시스템", $logTitle, $logDetail, $logParams);
			$return['success']	= 'N';
			$return['message']	= $response['message'];
			
			$orderLogTitle = "[".$this->_supportMarketNames[$baseRefundInfo['market']]['name']."] 반품완료실패 (API) - ".$response['message'];
		} else {
			$marketCompleteFail	= true;
			$title		= "마켓 반품성공";
			$logTitle	= "[{$this->_supportMarkets[$baseRefundInfo['market']]['name']}] 주문번호 - {$baseRefundInfo['market_order_no']} 마켓 반품완료";
			$logDetail	= "[{$this->_supportMarkets[$baseRefundInfo['market']]['name']}] 주문번호 - {$baseRefundInfo['market_order_no']} 마켓 반품완료 처리되었습니다.";
			$logParams	= array('return_code' => $fmClaimCode);
			$return['success']	= 'Y';
			$return['message']	= $response['resultData']['message'];
			
			$orderLogTitle = "[".$this->_supportMarketNames[$baseRefundInfo['market']]['name']."] 반품완료 (API)";
		}
		
		// 주문 로그 생성
		$orderModel->set_log($baseRefundInfo['fm_order_seq'], 'process', ($this->_CI->managerInfo['mname'])?$this->_CI->managerInfo['mname']:"시스템", $orderLogTitle, $logDetail, $logParams);

		$orderModel->set_log($baseRefundInfo['fm_order_seq'], 'process', ($this->_CI->managerInfo['mname'])?$this->_CI->managerInfo['mname']:"시스템", $logTitle, $logDetail, $logParams);

		return $return;
	}
	
	// 오픈마켓에서 가져온 반품사유를 퍼스트몰에 맞게 변환 :: 2018-08-13 pjw
	public function getTransReasonCode($reason_code){
		// 구매자 책임 코드 (변심) 120
		// 판매자 책임 코드 (하자) 210
		// 판매자 책임 코드 (오배송) 310
		$reason_list = array(
			'101' => '120',		// 구매자 - 상품에 이상 없으나 구매 의사 없어짐
			'110' => '120',		// 구매자 - 사이즈, 색상 등을 잘못 선택함
			'113' => '120',		// 구매자 - 기타(구매자 책임사유)
			'114' => '120',		// 구매자 - 구매자 귀책으로 교환을 반품으로 전환
			'119' => '120',		// 구매자 - 전세계배송(추가 해외배송비 미결제)
			'121' => '120',		// 구매자 - 구매하고 싶지 않거나 색상/사이즈 잘못 선택
			'199' => '120',		// 구매자 - 구매확정후 직권취소(구매자 책임)
			'206' => '120',		// 구매자 - 사이즈 또는 색상 등을 잘못 선택함
			'212' => '120',		// 구매자 - 구매자 귀책으로 반품을 교환으로 전환
			'211' => '120',		// 구매자 - 기타(구매자 책임사유)

			'105' => '210',		// 판매자 - 상품이 상품상세 정보와 틀림
			'111' => '210',		// 판매자 - 배송된 상품의 파손/하자/포장 불량
			'122' => '210',		// 판매자 - 배송된 상품 파손/하자/불량, 상품 미도착
			'123' => '210',		// 판매자 - 배송지연, 상품 품질 문제 등
			'198' => '210',		// 판매자 - 구매확정후 직권취소(판매자 책임)
			'207' => '210',		// 판매자 - 배송된 상품의 파손/하자/포장 불량
			'210' => '210',		// 판매자 - 상품이 상품상세 정보와 틀림

			'108' => '310',		// 판매자 - 다른 상품이 잘못 배송됨
			'112' => '310',		// 판매자 - 상품이 도착하고 있지 않음
			'115' => '310',		// 판매자 - 판매자 귀책으로 교환을 반품으로 전환
			'116' => '310',		// 판매자 - 기타(판매자 책임사유)
			'117' => '310',		// 판매자 - 전세계배송 국내통관 거부
			'118' => '310',		// 판매자 - 전세계배송 30kg 초과
			'208' => '310',		// 판매자 - 다른 상품이 잘못 배송됨
			'209' => '310',		// 판매자 - 품절 등의 사유로 판매자 협의 후 교환
			'213' => '310',		// 판매자 - 판매자 귀책으로 반품을 교환으로 전환
			'214' => '310',		// 판매자 - 기타(판매자 책임사유)
		);

		$return_reason = $reason_list[$reason_code];
		if($return_reason == '') $return_reason = '310';

		return $return_reason;
	}
}