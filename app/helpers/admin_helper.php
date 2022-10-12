<?php

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

	/* 가비아 출력 패널 (배너,팝업 -- page direct ) */
	function getGabiaPannel($code)
	{
		$CI = &get_instance();
		$CI->load->helper('readurl');

		$data = [
			'service_code' => SERVICE_CODE,
			'hosting_code' => $CI->config_system['service']['hosting_code'],
			'subDomain' => $CI->config_system['subDomain'],
			'domain' => $CI->config_system['domain'],
			'hostDomain' => $_SERVER['HTTP_HOST'],
			'shopSno' => $CI->config_system['shopSno'],
			'expire_date' => $CI->config_system['service']['expire_date'],
		];

		$res = readurl(get_connet_protocol() . "interface.firstmall.kr/firstmall_plus/request.php?cmd=getGabiaPannel&code={$code}&isdemo=" . $CI->isdemo['isdemo'], $data);

		// 배너 한꺼번에 호출 :: 2014-10-24 lwh
		if ($code == 'allbanner') {
			$tmp_arr = explode('[END]', $res);
			foreach ($tmp_arr as $val) {
				preg_match("/^\[S\:[^]]*\]/", trim($val), $matchs);
				$arrkey = substr($matchs[0], 3, -1);
				$banner_arr[$arrkey] = str_replace($matchs[0], '', $val);
			}
			$res = $banner_arr;
		}

		$res = replace_connect_protocol($res);

		return $res;
	}

	/**
	 * 관리자 메뉴에 GET파라미터가 있는 경우 URL 재조합
	 */
	function adminMenuaCreateURL($requestGetParams)
	{
		if (empty($requestGetParams) === true) {
			return urlencode(preg_replace("/^admin\//", '', uri_string()));
		}
		// 관리자 메뉴 get key값 반환
		$url_key = adminMenualGetKey($requestGetParams);
		// 관리자 메뉴 get value값 반환
		$url_value = adminMenualGetValue($requestGetParams);

		$menual_url = urlencode($url_key . '=' . $url_value);

		return $menual_url;
	}

	/**
	 * 관리자 메뉴 get parameter를 반환
	 * @requestGetName getParameter의 key값을 가져옴
	 */
	function adminMenualGetKey($requestGetName)
	{
		$url_key = array_keys($requestGetName)[0];
		return $url_key;
	}

	/**
	 * 관리자 메뉴 get parameter를 반환
	 * @requestGetValue getParameter의 value값을 가져옴
	 */
	function adminMenualGetValue($requestGetValue)
	{
		$url_value = array_values($requestGetValue)[0];
		return $url_value;
	}

	/**
	 * 관리자 메뉴 카테고리코드로 이동시 URL에 해당하는 코드 반환
	 */
	function adminMenualGetCategory($url)
	{	

		$first_segments = $url->segments[2];
		$two_segments = $url->segments[3];
		$cate_code = '';
		$isStockOut = false; // 재고 반출 메뉴인 경우 true
		
		$statistic = [
			// 요약 통계
			'statistic_summary' => [
				'summary' => '00480001'
			],
			// 방문 통계
			'statistic_visitor' => [
				'visitor_basic' => '004800020001',
				'visitor_referer' => '004800020002',
				'visitor_platform' => '004800020003',
			],
			// 가입 통계
			'statistic_member' => [
				'member_basic' => '004800030001',
				'member_referer' => '004800030002',
				'member_platform' => '004800030003',
				'member_rute' => '004800030004',
				'member_etc' => '004800030005',
			],
			// 판매 통계
			'statistic_sales' => [
				'sales_sales' => '004800040001',
				'sales_goods' => '004800040002',
				'sales_referer' => '004800040003',
				'sales_category' => '004800040004',
				'sales_platform' => '004800040005',
				'sales_payment' => '004800040007',
				'sales_etc' => '004800040006',
				'sales_seller' => '004800040008',
				'sales_o2o' => '004800040009',
			],
			// 상품 통계
			'statistic_goods' => [
				'goods_cart' => '004800050001',
				'goods_wish' => '004800050002',
				'goods_search' => '004800050003',
				'goods_review' => '004800050004',
				'goods_restock' => '004800050005',
			],
			// 적립 통계
			'statistic_epc' => [
				'epc_basic' => '004800060001',
			],
			// 구글 애널리틱스
			'statistic_ga' => [
				'regist' => '00480007',
			],

		];

		// 통계인 경우
		if (in_array($first_segments, array_keys($statistic)) === true) {
			$cate_code = $statistic[$first_segments][$two_segments];
		}

		// 재고 > 반출 메뉴인 경우
		if (
			$first_segments === 'scm_warehousing' 
			&& $two_segments === 'carryingout'
		) {
			$isStockOut = true;
		}

		if ($isStockOut === true) {
			$cate_code = '003900020004';
		}

		return $cate_code;
	}
