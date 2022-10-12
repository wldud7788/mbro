<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class talkbuy_ordersheet_rebuild
{
	private $talkbuyOrderSheetData = [];
	private $partnerOrderSheetData = [];

	public function __construct() 
    {
		$this->CI = &get_instance();
		$this->CI->load->library("partnerlib");
	}

	/**
	 * 추가상품(서브옵션)만 개별배송 으로 처리가능해야 한다.
	 * 추가상품데이터만 있고 옵션상품 데이터가 없으면 옵션상품 데이터를 만들어준다.
	 */
	public function dataRebuild($contents)
	{
		$contentCount = count($contents);
		for ($i = 0; $i < $contentCount; $i++) {
			$contents[$i] = $this->product_rebuild($contents[$i]);
		}

		return $contents;
	}

    private function product_rebuild($talkbuyOrderSheetData)
	{
		// 주문상품
		$this->setOrderSheet($talkbuyOrderSheetData);

		// 솔루션에 저장 되어있던 주문 데이터
		$this->setPartnerOrderSheetData();

		// 주문상품 처리 프로세스 확인 (추가상품만인지)
		$this->setOrderProcessType();
		
		// 추가상품만 존재하는 데이터에 상품 데이터 추가
		$this->addSubOptionProductData();

		return $this->talkbuyOrderSheetData;
	}

	private function setOrderSheet($talkbuyOrderSheetData)
	{
		$this->talkbuyOrderSheetData = $talkbuyOrderSheetData;
	}

	private function setPartnerOrderSheetData()
	{
		$this->partnerOrderSheetData = $this->CI->partnerlib->getPartnerOrder([
			'session_tmp' => $this->talkbuyOrderSheetData['customData1'],
			'partner_id' => 'talkbuy',
		]);
	}

	/**
	 * 서브옵션 상품만 개별배송인지 확인
	 * - 주문데이터에 추가상품(서브옵션) 데이터만 존재하는지 확인
	 * 
	 * A옵션상품 X, A추가상품 O
	 * A옵션상품 O, A추가상품 O, B옵션상품 X, B추가상품 O
	 * A옵션상품 X, A추가상품 O, B옵션상품 X, B추가상품 O
	 */
	private function setOrderProcessType()
	{
		foreach ($this->talkbuyOrderSheetData['orderProduct'] as &$products) {
			if ($this->isSuboptionIndividualDelivery($products) === true) {
				$products['orderStatusProcessType'] = 'suboption';
			} else {
				$products['orderStatusProcessType'] = 'product';
			}
		}
	}
	
	private function isSuboptionIndividualDelivery($products)
	{
		$subOption = false;
	
		if (
			// 상품정보가 없음
			strlen($products['id']) === 0 &&
			// 서브옵션 존재
			(isset($products['suboption']) === true && count($products['suboption']) > 0)
		) {
			$subOption = true;
		}
		
		return $subOption;
	}

	private function addSubOptionProductData()
	{
		foreach ($this->talkbuyOrderSheetData['orderProduct'] as &$products) {
			// 추가옵션 상품이면 옵션상품 데이터를 넣어준다.
			if ($products['orderStatusProcessType'] === 'suboption') {
				$products = $this->addProductData($products);
			}
		}
	}

	private function addProductData($products)
	{
		// 첫번째 서브옵션 톡구매 주문상품 아이디 (두번째, 세번째 서브옵션 데이터도 같음)
		$firstProductSubOption = $products['suboption'][0];
		$suboptionTalkbuyProductId = $firstProductSubOption['id'];

		// 상품 아이디 (서브옵션 데이터와 같음)
		$products['productId'] = $firstProductSubOption['productId'];
		// 배송그룹 아이디 (서브옵션 데이터와 같음)
		$products['shippingFeeGroupId'] = $firstProductSubOption['shippingFeeGroupId'];

		// 서브옵션 아이디로 옵션 상품정보를 구한다
		$productOption = $this->getProductSearch($suboptionTalkbuyProductId);
		$products['id'] = $productOption['partner_order_pk'];

		/**
		 *  서브옵션의 상품주문 상태를 본상품에 넣어준다.
		 *  구매확정시 사용된다.
		 */
		$products['status'] = $firstProductSubOption['status'];

		return $products;
	}

	private function getProductSearch($suboptionTalkbuyProductId)
	{
		// 같은상품이 장바구니에 중복으로 담길 경우 구분 할수있는 seq 구한다
	    $cartOptionSeq = $this->getCartOptionSeq($suboptionTalkbuyProductId);
		// cartOptionSeq 가 같은 상품중 option 상품을 구한다
		$productOption = $this->getProductOption($cartOptionSeq);

		return $productOption;
	}

	private function getCartOptionSeq($suboptionTalkbuyProductId)
	{
		// 같은상품이 장바구니에 중복으로 담길경우 구분할수있는 seq
		$cartOptionSeq = '0';

		$partnerCount = count($this->partnerOrderSheetData);
		// 카트 옵션아이디
		for ($i = 0; $i < $partnerCount; $i++) {
			$partnerProduct = $this->partnerOrderSheetData[$i];
			
			if ($partnerProduct['partner_order_pk'] === $suboptionTalkbuyProductId) {
				$cartOptionSeq = $partnerProduct['cart_option_seq'];
				break;
			}
		}

		return $cartOptionSeq;
	}

	private function getProductOption($cartOptionSeq)
	{
		$productOption = [];

		// 옵션상품 정보
		$partnerCount = count($this->partnerOrderSheetData);
		for ($i = 0; $i < $partnerCount; $i++) {
			$partnerProduct = $this->partnerOrderSheetData[$i];
			
			if ($partnerProduct['option_type'] === 'option' && $partnerProduct['cart_option_seq'] === $cartOptionSeq) {
				$productOption = $partnerProduct;
				break;
			}
		}

		return $productOption;
	}

}