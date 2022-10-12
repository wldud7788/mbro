<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of goodsList
 *
 * @author 이기세
 */
class goodsList {
	//put your code here
	var $adultImg = "";

	public function __construct() {
		$this->CI =& get_instance();
		$this->adultImg = "/data/skin/".$this->CI->skin."/images/common/19mark.jpg";
	}

	/**
	 * 성인상품 이미지 교체 체크
	 * @param $goods 상품정보
	 * @return type boolean true : 교체
	 */
	public function checkingMarkingAdultImg($goods) {
		$result = false;
		// 상품정보 없으면 상품 조회
		if(!$goods['adult_goods']) {
			$this->CI->load->model('goodsmodel');
			$goods = $this->CI->goodsmodel->get_goods($goods['goods_seq']);
		}

		$adultAuth = $this->CI->session->userdata('auth_intro');
		// 성인인증 상품 && 성인인증세션없음 && 관리자(입점사) 도 아니면 교체 true
		if( $goods['adult_goods'] == 'Y' && $adultAuth['auth_intro_yn'] == '' 
			&& (!$this->CI->managerInfo && !$this->CI->providerInfo)){
			$result = true;
		}

		return $result;
	}
}
