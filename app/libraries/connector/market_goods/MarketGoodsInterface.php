<?php
Interface MarketGoodsInterface {
	
	/*	생성자
		$getBaseMarketInfo	: 기본 연동정보
	*/
	public function __construct($getBaseMarketInfo);
		
	
	/*	마켓용 파라미터 리턴
		$productInfo		: 상품정보
		$addInfo			: 마켓 추가정보
	*/
	public function marketGoodsParams($productInfo, $addInfo);


	/*	마켓용 파라미터 생성
		$allGoodsInfo		: 퍼스트몰 상품정보
		$mode				: 상품 등록(register) / 상품 수정(update) 구분
	*/
	public function buildMarketParams($allGoodsInfo, $mode);
}