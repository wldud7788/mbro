<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
검색 폼 :: 메뉴별 기본검색 항목 정의

	# searchEditUse : 검색편집 사용 여부
	# searchRequired: 검색 필수(고정) 필드(해당 필드는 사용자가 사용여부 설정 못함)
	# searchDefault : 검색 기본 필드
	# searchValue : 검색 기본 값

*/

/*
0. 공용검색(팝업등)
1. 재고기초
2. 재고관리

	$config["scm_manage_goods"]		= array(
										"searchEditUse"		=> true,
										"searchRequired"	=> array("sc_keyword"),
										"searchDefault"		=> array("sc_keyword"),
									);

	$config["scm_manage_revision"]		= array(
										"searchEditUse"		=> true,
										"searchRequired"	=> array("sc_keyword"),
										"searchDefault"		=> array("sc_keyword"),
	);

3. 발주/입고
4. 판매상품
*/
	$config["admin/goods/catalog"]		= array(
											"searchEditUse"		=> true,
											"searchRequired"	=> array('sc_keyword'),
											"searchDefault"		=> array('sc_keyword','sc_provider','sc_category','sc_regist_date','sc_status','sc_view','sc_shipping'),
											"searchValue"		=> array("goodsStatus" => array('all','normal','runout','purchasing','unsold')),
	);
	
	$config["admin/goods/social_catalog"]		= array(
											"searchEditUse"		=> true,
											"searchRequired"	=> array('sc_keyword'),
											"searchDefault"		=> array('sc_keyword','sc_provider','sc_category','sc_regist_date','sc_status','sc_view'),
											"searchValue"		=> array("goodsStatus" => array('all','normal','runout','purchasing','unsold')),
	);

	$config["admin/goods/package_catalog"]		= array(
											"searchEditUse"		=> true,
											"searchRequired"	=> array('sc_keyword'),
											"searchDefault"		=> array('sc_keyword','sc_provider','sc_category','sc_regist_date','sc_status','sc_view','sc_shipping'),
											"searchValue"		=> array("goodsStatus" => array('all','normal','runout','purchasing','unsold')),
	);

	$config["admin/goods/restock_notify_catalog"]			= array(
																"searchEditUse"		=> true,
																"searchRequired"	=> array('sc_keyword'),
																"searchDefault"		=> array('sc_keyword','sc_regist_date','sc_notify_status','sc_provider','sc_category','sc_goods_status'),
															);
	
	$config["selleradmin/goods/catalog"]		= array(
											"searchEditUse"		=> true,
											"searchRequired"	=> array('sc_keyword'),
											"searchDefault"		=> array('sc_keyword','sc_category','sc_regist_date','sc_status','sc_view','sc_shipping'),
											"searchValue"		=> array("goodsStatus" => array('all','normal','runout','purchasing','unsold')),
	);
	
	$config["selleradmin/goods/social_catalog"]		= array(
											"searchEditUse"		=> true,
											"searchRequired"	=> array('sc_keyword'),
											"searchDefault"		=> array('sc_keyword','sc_provider','sc_category','sc_regist_date','sc_status','sc_view'),
											"searchValue"		=> array("goodsStatus" => array('all','normal','runout','purchasing','unsold')),
	);

	$config["selleradmin/goods/package_catalog"]		= array(
											"searchEditUse"		=> true,
											"searchRequired"	=> array('sc_keyword'),
											"searchDefault"		=> array('sc_keyword','sc_provider','sc_category','sc_regist_date','sc_status','sc_view','sc_shipping'),
											"searchValue"		=> array("goodsStatus" => array('all','normal','runout','purchasing','unsold')),
	);

	$config["selleradmin/goods/restock_notify_catalog"]		= array(
										"searchEditUse"		=> true,
										"searchRequired"	=> array('sc_keyword'),
										"searchDefault"		=> array('sc_keyword','sc_regist_date','sc_notify_status','sc_provider','sc_category','sc_goods_status'),
									);

/*
5. 주문
6. 오픈마켓
7. 회원
*/
	$config["member_catalog"]		= array(
										"searchEditUse"		=> true,
										"searchRequired"	=> array("sc_keyword"),
										"searchDefault"		=> array("sc_keyword","sc_regist_date","sc_grade"),
										"searchValue"		=> array("sorder_sum" => 0, "sorder_cnt" => 0, "semoney" => 0, "slogin_cnt" => 0, "sage" => 0)
									);
	$config["sms_history"]		= array("searchEditUse"	=> false,
								"searchRequired"=> 'all',
								"searchDefault"=> 'all',
								"searchValue" => array('select_date_regist' => '3day', 'search_type' => 'tran_phone')
						);
/*
8. 게시판

9. 프로모션/쿠폰
	9.1 쿠폰 리스트
*/
	$config["coupon_catalog"]		= array(
										"searchEditUse"		=> true,
										"searchRequired"	=> array("sc_keyword"),
										"searchDefault"		=> array("sc_keyword","sc_coupon_category","sc_regist_date","sc_provider","sc_issue_stop"),
										"searchValue"		=> array("search_cost_start" => 0, "search_cost_end" => 100)
									);
	$config["promotion_catalog"]	= array("searchEditUse"	=> false,"searchRequired"=> 'all',"searchDefault"=> 'all',"searchValue" => null);
	$config["referer_catalog"]		= array("searchEditUse"	=> false,"searchRequired"=> 'all',"searchDefault"=> 'all',
											"searchValue"	=> array("search_cost_start" => 0, "search_cost_end" => 100)
										);
	$config["gift_catalog"]			= array("searchEditUse"	=> false,"searchRequired"=> 'all',"searchDefault"=> 'all',"searchValue" => null);
	$config["joincheck_catalog"]	= array("searchEditUse"	=> false,"searchRequired"=> 'all',"searchDefault"=> 'all',"searchValue" => null);
	$config["event_catalog"]		= array("searchEditUse"	=> false,"searchRequired"=> 'all',"searchDefault"=> 'all',"searchValue" => null);

	$config["seller_coupon_catalog"]= array(
										"searchEditUse"		=> true,
										"searchRequired"	=> array("sc_keyword"),
										"searchDefault"		=> array("sc_keyword","sc_coupon_category","sc_regist_date","sc_provider","sc_issue_stop"),
										"searchValue"		=> array("search_cost_start" => 0, "search_cost_end" => 100)
									);
/*
10. 마케팅
11. 통계
12. 입점사
	12.1 입점사 리스트
*/
	$config["provider_catalog"]		= array(
										"searchEditUse"		=> true,
										"searchRequired"	=> array("sc_provider"),
										"searchDefault"		=> array("sc_provider","sc_provider_status","sc_commission_type","sc_calcu_count"),
									);

/*
13. 정산
14. 오프라인매장
15. 공용 라이브러리
*/
	$config["gl_select_goods"]		= array(
		"searchEditUse"		=> false,
		"searchRequired"	=> array('sc_keyword'),
		"searchDefault"		=> array('sc_keyword','sc_provider','sc_category','sc_regist_date','sc_status'),
);

/*
검색 영역에서 사용하는 날짜 프리셋 정의
*/
$config['date_preset'] = array(
	'today' => array(date('Y-m-d'), date('Y-m-d')),								// 오늘
	'3day' => array(date('Y-m-d', strtotime('-3 days')), date('Y-m-d')),		// 3일간
	'1week' => array(date('Y-m-d', strtotime('-7 days')), date('Y-m-d')),		// 일주일
	'1month' => array(date('Y-m-d', strtotime('-30 days')), date('Y-m-d')),		// 1개월
	'3month' => array(date('Y-m-d', strtotime('-90 days')), date('Y-m-d')),	// 3개월
);