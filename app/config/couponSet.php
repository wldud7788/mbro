<? if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
쿠폰 등록 폼 설정
*/

/*
*** 쿠폰
	1. 쿠폰종류
*/

	$config['coupon_category'] = array('goods'=>'상품','shipping'=>'배송비','order'=>'주문서','mileage'=>'마일리지');

	// 1-1. 쿠폰 유형 및 발급방식
		$config['coupon_category_sub']['goods']['direct']['name']						= "직접 발급";
		$config['coupon_category_sub']['goods']['direct']['list']						= array(
																							"download"=>"다운로드",
																							"admin"=>"지정 회원 발급",
																							"point"=>"포인트 차감",
																							"offline_coupon"=>"번호 인증"
																					);
		$config['coupon_category_sub']['goods']['birthday']['name']						= "생일";
		$config['coupon_category_sub']['goods']['birthday']['list']						=  array("birthday"=>"다운로드");
		$config['coupon_category_sub']['goods']['anniversary']['name']					= "기념일";
		$config['coupon_category_sub']['goods']['anniversary']['list']					=  array("anniversary"=>"다운로드");
		$config['coupon_category_sub']['goods']['memberGroup']['name']					= "회원등급조정";
		$config['coupon_category_sub']['goods']['memberGroup']['list']					=  array("memberGroup"=>"다운로드");
		$config['coupon_category_sub']['goods']['member']['name']						= "신규가입";
		$config['coupon_category_sub']['goods']['member']['list']						=  array("member"=>"자동 발급");
		$config['coupon_category_sub']['goods']['memberlogin']['name']					= "이달의 컴백회원";
		$config['coupon_category_sub']['goods']['memberlogin']['list']					=  array("memberlogin"=>"다운로드");
		$config['coupon_category_sub']['goods']['membermonths']['name']					= "이달의 등급";
		$config['coupon_category_sub']['goods']['membermonths']['list']					=  array("membermonths"=>"다운로드");
		$config['coupon_category_sub']['goods']['order']['name']						= "첫 구매";
		$config['coupon_category_sub']['goods']['order']['list']						=  array("order"=>"다운로드");
		$config['coupon_category_sub']['goods']['app_install']['name']					= "앱 설치 상품 쿠폰";
		$config['coupon_category_sub']['goods']['app_install']['list']					=  array("app_install"=>"자동 발급");
		$config['coupon_category_sub']['shipping']['direct']['name']					= "직접 발급";
		$config['coupon_category_sub']['shipping']['direct']['list']					=  array(
																							"shipping"=>"다운로드",
																							"admin_shipping"=>"지정 회원 발급",
																						);
		$config['coupon_category_sub']['shipping']['memberGroup_shipping']['name']		= "회원 등급 조정";
		$config['coupon_category_sub']['shipping']['memberGroup_shipping']['list']		=  array("memberGroup_shipping"=>"다운로드");
		$config['coupon_category_sub']['shipping']['member_shipping']['name']			= "신규가입";
		$config['coupon_category_sub']['shipping']['member_shipping']['list']			=  array("member_shipping"=>"자동 발급");
		$config['coupon_category_sub']['shipping']['memberlogin_shipping']['name']		= "이달의 컴백회원";
		$config['coupon_category_sub']['shipping']['memberlogin_shipping']['list']		=  array("memberlogin_shipping"=>"다운로드");
		$config['coupon_category_sub']['shipping']['membermonths_shipping']['name']		= "이달의 등급";
		$config['coupon_category_sub']['shipping']['membermonths_shipping']['list']		=  array("membermonths_shipping"=>"다운로드");
		$config['coupon_category_sub']['order']['ordersheet']['name']					= "주문서쿠폰";
		$config['coupon_category_sub']['order']['ordersheet']['list']					=  array("ordersheet"=>"다운로드");
	//	$config['coupon_category_sub']['order']['offline']['list']						=  array();
		$config['coupon_category_sub']['mileage']['offline_emoney']['name']				= "마일리지 교환";
		$config['coupon_category_sub']['mileage']['offline_emoney']['list']				=  array("offline_emoney"=>"번호 인증");

		$coupon_all_list = array();
		foreach($config['coupon_category_sub'] as $key=>$list){
			$gubun = ($key == 'goods')? '상품':'배송비';
			foreach($list as $list2){
				if($list2['list']){
					foreach($list2['list'] as $type=>$name){
						if(count($list2['list']) > 1){
							$coupon_all_list[$type] = $gubun." ".$name;
						}else{
							$coupon_all_list[$type] = $list2['name'];
						}
					}
				}
			}
		}

	/*
	 1-2. 전체 쿠폰 리스트
	*/
	$config['coupon_all_list'] = $coupon_all_list;

	/*
	 1-3. 쿠폰 종류 제한
	 무료몰 제한 쿠폰(사용불가)
	*/
	$config['coupon_service']['H_NFR'] = array("point","memberlogin","membermonths","order","admin_shipping","memberGroup_shipping","member_shipping","memberlogin_shipping","membermonths_shipping");

	/*
	 1-3. 쿠폰별 팝업 제공 쿠폰
	*/
	$config['coupon_popup'] = array("birthday","anniversary","memberGroup","member","memberlogin","membermonths","order","shipping");


/*
*** 쿠폰 별 기능 설정 값 세팅

	<ETC> 쿠폰발급대상자
		 issuedTo				:: 'direct' 직접발급, 'normal' 일반

	2. 혜택부담설정
		 discount_seller_type :: 혜택부담 판매자 유형
									'ONLYA'	- 대상 : 본사 상품(배송비) / 혜택부담 : 본사 100%
									'A'		- 대상 : 본사, 모든 입점사 상품(배송비) / 혜택부담 : 본사 100%
									'AOP'	- 대상 : 본사 or 입점사(선택) / 혜택부담 : 선택한 판매자
									'ALL'	- 대상 : 본사, 모든 입점사 상품(배송비) / 혜택부담 : 본사, 입점사 지정 부담률
									'NONE'	- 대상 : 없음, 혜택부담 : 없음
		 discount_target		:: 혜택부담 대상 상품 (goods 상품, shipping 배송비)

	3. 혜택설정
		 benefit_type			:: 혜택 (rate_amount 정률/정액, shipping 배송비, mileage 마일리지)
								:: 최소주문금액 - 혜택이 마일리지 인경우에만 사용 안함
		 periodofuse_type		:: 유효기간(사용기간)설정 date|day|months|year|direct
									일반 - 'date' 특정기간지정/기한지정, 'day' 기한지정, 'months' 당월말, 
									마일리지교환전용 - 'year' 지급년도+{}년 말까지, 'direct' {}개월까지
		 duplicationUseSet		:: 중복할인설정 'duplicate_discount' 중복할인, 'duplicate_down' 중복다운, 'duplicate_all' 중복할인/중복다운, 'unused' 사용안함

	4. 쿠폰발급
		 downloadLimitSet		:: 수량제한  'auto' 자동, 'unlimit' 제한 없음, 'limit' 제한없음/수량제한
		 downloadPeriodSet		:: 발급기한(다운로드기한) 설정
									'auto' 자동신규 구매
									'period' 기간/시간/요일 설정
									'beforeafter' 00일전 ~ 00일 후
									'daysfrom' 00일로부터
									'neworder' 신규가입 미구매
									'notpurchased' 00동안 미구매
									'onceamonthdownload' 월1회 다운로드
									'' 사용안함
		memberGradeSet			:: 회원등급 사용
									'auto' 자동
									'gradelimit' 등급제한 설정
									'' 사용안함
	5. 쿠폰인증
		couponCertificationSet	:: 쿠폰 인증 사용여부 'y' 사용, 'n'미사용
		certificationPeriodSet	:: 인증 기간 사용여부 'y' 사용, 'n' 미사용

	6. 전환포인트
		conversionPointSet		:: 전환포인트 설정 사용여부 'y' 사용, 'n' 미사용

	7. 인증번호발급
		certificationNumberSet	:: 인증번호 발급 사용여부 'y' 사용, 'n' 미사용

	8. 쿠폰사용제한
		usedTogether			:: 타 쿠폰과 함께 사용 여부 'y' 사용가능, 'n' 사용불가
		goodsCategoryLimit		:: 상품/카테고리 제한 여부 'y' 사용가능, 'n' 사용불가
		deviceUsed				:: 사용 가능환경 제한 여부 'y' 전체 사용가능, 'app' 쇼핑몰앱만 사용가능, 'n' 사용불가'
		methodOfPayment			:: 결제 가능 수단 제한 여부 'y' 사용가능, 'n' 사용불가
		refererLimit			:: 할인 유입 경로 제한 여부 'y' 사용가능, 'n' 사용불가

	9. 쿠폰 이미지
		couponImageSet			:: 쿠폰 이미지 세팅 사용 여부 'y' 사용가능, 'n' 사용불가

	10. 쿠폰 이미지
		couponDownUrl			:: 쿠폰 다운로드 URL 복사 사용 여부 'y' 사용가능, 'n' 사용불가

	11. 오프라인 매장
		offlineStore			::  사용여부 'y' 사용가능, 'n' 사용안함
*/
		/*
			상품-직접발급- 지정 회원 발급
		*/
		$config['set_coupon_form']['admin'] = array(
										"issuedTo"					=> "direct",
										"discount_seller_type"		=> "A",
										"discount_target"			=> "goods",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "date|day",
										"duplicationUseSet"			=> "duplicate_discount",
										"downloadLimitSet"			=> "auto",
										"downloadPeriodSet"			=> "auto",
										"memberGradeSet"			=> "auto",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "y",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "n",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			상품-직접발급-다운로드
		*/
		$config['set_coupon_form']['download'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "AOP",
										"discount_target"			=> "goods",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "date|day",
										"duplicationUseSet"			=> "duplicate_all",
										"downloadLimitSet"			=> "limit",
										"downloadPeriodSet"			=> "period",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "y",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "y",
										"offlineStore"				=> "n",
										);
		/*
			상품-직접발급-포인트차감
		*/
		$config['set_coupon_form']['point'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "A",
										"discount_target"			=> "goods",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "date|day",
										"duplicationUseSet"			=> "duplicate_discount",
										"downloadLimitSet"			=> "auto",
										"downloadPeriodSet"			=> "auto",
										"memberGradeSet"			=> "auto",
										"conversionPointSet"		=> "y",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "y",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "n",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			상품-직접발급-번호인증
		*/
		$config['set_coupon_form']['offline_coupon'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "AOP",
										"discount_target"			=> "goods",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "date|day",
										"duplicationUseSet"			=> "duplicate_discount",
										"downloadLimitSet"			=> "",
										"downloadPeriodSet"			=> "",
										"memberGradeSet"			=> "",
										"couponCertificationSet"	=> "y",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "y",
										"certificationPeriodSet"	=> "y",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "y",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "n",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			상품-생일-다운로드
		*/
		$config['set_coupon_form']['birthday'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "ALL",
										"discount_target"			=> "goods",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "day",
										"duplicationUseSet"			=> "duplicate_discount",
										"downloadLimitSet"			=> "unlimit",
										"downloadPeriodSet"			=> "beforeafter",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "y",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			상품-기념일-다운로드
		*/
		$config['set_coupon_form']['anniversary'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "ALL",
										"discount_target"			=> "goods",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "day",
										"duplicationUseSet"			=> "duplicate_discount",
										"downloadLimitSet"			=> "unlimit",
										"downloadPeriodSet"			=> "beforeafter",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "y",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			상품-회원등급조정-다운로드
		*/
		$config['set_coupon_form']['memberGroup'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "ALL",
										"discount_target"			=> "goods",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "day",
										"duplicationUseSet"			=> "duplicate_discount",
										"downloadLimitSet"			=> "unlimit",
										"downloadPeriodSet"			=> "daysfrom",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "y",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			상품-신규가입-다운로드
		*/
		$config['set_coupon_form']['member'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "ALL",
										"discount_target"			=> "goods",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "day",
										"duplicationUseSet"			=> "duplicate_discount",
										"downloadLimitSet"			=> "auto",
										"downloadPeriodSet"			=> "auto",
										"memberGradeSet"			=> "auto",
										"couponCertificationSet"	=> "",
										"certificationPeriodSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "y",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			상품-이달의컴백회원-다운로드
		*/
		$config['set_coupon_form']['memberlogin'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "ALL",
										"discount_target"			=> "goods",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "months",
										"duplicationUseSet"			=> "duplicate_discount",
										"downloadLimitSet"			=> "unlimit",
										"downloadPeriodSet"			=> "notpurchased",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "y",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			상품-이달의등급-다운로드
		*/
		$config['set_coupon_form']['membermonths'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "ALL",
										"discount_target"			=> "goods",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "months",
										"duplicationUseSet"			=> "duplicate_discount",
										"downloadLimitSet"			=> "unlimit",
										"downloadPeriodSet"			=> "onceamonthdownload",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "y",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			상품-첫구매-다운로드
		*/
		$config['set_coupon_form']['order'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "ALL",
										"discount_target"			=> "goods",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "months|date|day",
										"duplicationUseSet"			=> "duplicate_discount",
										"downloadLimitSet"			=> "unlimit",
										"downloadPeriodSet"			=> "neworder",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "y",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			상품-앱설치-다운로드
		*/
		$config['set_coupon_form']['app_install'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "AOP",
										"discount_target"			=> "goods",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "day",
										"duplicationUseSet"			=> "duplicate_discount",
										"downloadLimitSet"			=> "auto",
										"downloadPeriodSet"			=> "auto",
										"memberGradeSet"			=> "auto",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "y",
										"deviceUsed"				=> "app",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			배송비-직접발급-지정회원발급
		*/
		$config['set_coupon_form']['admin_shipping'] = array(
										"issuedTo"					=> "direct",
										"discount_seller_type"		=> "A",
										"discount_target"			=> "shipping",
										"benefit_type"				=> "shipping",
										"periodofuse_type"			=> "day",
										"duplicationUseSet"			=> "unused",
										"downloadLimitSet"			=> "auto",
										"downloadPeriodSet"			=> "auto",
										"memberGradeSet"			=> "auto",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "n",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "n",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			배송비-직접발급-다운로드
		*/
		$config['set_coupon_form']['shipping'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "AOP",
										"discount_target"			=> "shipping",
										"benefit_type"				=> "shipping",
										"periodofuse_type"			=> "date|day",
										"duplicationUseSet"			=> "duplicate_down",
										"downloadLimitSet"			=> "limit",
										"downloadPeriodSet"			=> "period",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "n",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			배송비-회원등급조정-다운로드
		*/
		$config['set_coupon_form']['memberGroup_shipping'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "ALL",
										"discount_target"			=> "shipping",
										"benefit_type"				=> "shipping",
										"periodofuse_type"			=> "day",
										"duplicationUseSet"			=> "unused",
										"downloadLimitSet"			=> "unlimit",
										"downloadPeriodSet"			=> "daysfrom",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "n",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			배송비-신규가입-다운로드
		*/
		$config['set_coupon_form']['member_shipping'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "ALL",
										"discount_target"			=> "shipping",
										"benefit_type"				=> "shipping",
										"periodofuse_type"			=> "day",
										"duplicationUseSet"			=> "unused",
										"downloadLimitSet"			=> "auto",
										"downloadPeriodSet"			=> "auto",
										"memberGradeSet"			=> "auto",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "n",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			배송비-이달의컴백회원-다운로드
		*/
		$config['set_coupon_form']['memberlogin_shipping'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "ALL",
										"discount_target"			=> "shipping",
										"benefit_type"				=> "shipping",
										"periodofuse_type"			=> "months",
										"duplicationUseSet"			=> "unused",
										"downloadLimitSet"			=> "unlimit",
										"downloadPeriodSet"			=> "notpurchased",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "n",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			배송비-이달의등급-다운로드
		*/
		$config['set_coupon_form']['membermonths_shipping'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "ALL",
										"discount_target"			=> "shipping",
										"benefit_type"				=> "shipping",
										"periodofuse_type"			=> "months",
										"duplicationUseSet"			=> "unused",
										"downloadLimitSet"			=> "unlimit",
										"downloadPeriodSet"			=> "onceamonthdownload",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "n",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);
		/*
			주문서-다운로드
		*/
		$config['set_coupon_form']['ordersheet'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "A",
										"discount_target"			=> "NONE",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "date|day",
										"duplicationUseSet"			=> "unused",
										"downloadLimitSet"			=> "limit",
										"downloadPeriodSet"			=> "period",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "n",
										"deviceUsed"				=> "y",
										"methodOfPayment"			=> "y",
										"refererLimit"				=> "y",
										"couponImageSet"			=> "y",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);

		$config['set_coupon_form']['ordersheet_off'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "ONLYA",
										"discount_target"			=> "NONE",
										"benefit_type"				=> "rate_amount",
										"periodofuse_type"			=> "date|day",
										"duplicationUseSet"			=> "unused",
										"downloadLimitSet"			=> "limit",
										"downloadPeriodSet"			=> "period",
										"memberGradeSet"			=> "gradelimit",
										"couponCertificationSet"	=> "",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "",
										"certificationPeriodSet"	=> "",
										"usedTogether"				=> "y",
										"goodsCategoryLimit"		=> "n",
										"deviceUsed"				=> "n",
										"methodOfPayment"			=> "n",
										"refererLimit"				=> "n",
										"couponImageSet"			=> "n",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "y",
										);
		/*
			마일리지-마일리지교환-번호인증
		*/
		$config['set_coupon_form']['offline_emoney'] = array(
										"issuedTo"					=> "normal",
										"discount_seller_type"		=> "A",
										"discount_target"			=> "goods",
										"benefit_type"				=> "mileage",
										"periodofuse_type"			=> "year|direct",
										"duplicationUseSet"			=> "unused",
										"downloadLimitSet"			=> "",
										"downloadPeriodSet"			=> "",
										"memberGradeSet"			=> "",
										"couponCertificationSet"	=> "y",
										"conversionPointSet"		=> "",
										"certificationNumberSet"	=> "y",
										"certificationPeriodSet"	=> "y",
										"usedTogether"				=> "n",
										"goodsCategoryLimit"		=> "n",
										"deviceUsed"				=> "n",
										"methodOfPayment"			=> "n",
										"refererLimit"				=> "n",
										"couponImageSet"			=> "n",
										"couponDownUrl"				=> "n",
										"offlineStore"				=> "n",
										);

/*
	POST로 넘겨 받는 필드 validation 정의
*/
	$coupon_field = array();
	$coupon_field['coupon_category']		= array('label'=>"쿠폰구분",					'rules'=>'trim|required|xss_clean');
	$coupon_field['couponType']				= array('label'=>"쿠폰종류",					'rules'=>'trim|required|xss_clean');
	$coupon_field['couponName']				= array('label'=>"쿠폰명",						'rules'=>'trim|required|xss_clean');
	$coupon_field['couponDesc']				= array('label'=>"쿠폰 설명",					'rules'=>'trim|xss_clean');
	$coupon_field['saleType']				= array('label'=>"쿠폰 혜택 종류",				'rules'=>'trim|required|max_length[7]|xss_clean');
	$coupon_field['salescost_provider']		= array('label'=>"입점사 부담율",				'rules'=>'trim|required|max_length[3]|xss_clean');
	$coupon_field['salescost_provider_list[]']	= array('label'=>"입점사 지정",				'rules'=>'trim|required|max_length[5]|xss_clean');
	$coupon_field['member_grade_list[]']	= array('label'=>"회원 등급 지정",				'rules'=>'trim|required|xss_clean');
	$coupon_field['downloadDate_s[]']		= array('label'=>"발급 기한-시작일",			'rules'=>'trim|required|max_length[10]|xss_clean');
	$coupon_field['downloadDate_e[]']		= array('label'=>"발급 기한-종료일",			'rules'=>'trim|required|max_length[10]|xss_clean');
	$coupon_field['coupon_point']			= array('label'=>"전환 포인트",					'rules'=>'trim|required|numeric|xss_clean|greater_than[0]');
	$coupon_field['goodsSalePrice']			= array('label'=>"할인율(또는 할인금액)",		'rules'=>'trim|required|numeric|max_length[10]|xss_clean|greater_than[0]');
	$coupon_field['maxPercentGoodsSale']	= array('label'=>"최대 할인 금액",				'rules'=>'trim|required|numeric|xss_clean|greater_than[0]');
	$coupon_field['duplicationUse']			= array('label'=>"다중 사용",					'rules'=>'trim|numeric|xss_clean');
	$coupon_field['issuePriodType']			= array('label'=>"유효 기간 종류",				'rules'=>'trim|required|max_length[6]|xss_clean');
	$coupon_field['issueDate[]']			= array('label'=>"유효 기간",					'rules'=>'trim|required|max_length[10]|xss_clean');
	$coupon_field['afterIssueDay']			= array('label'=>"유효 기간",					'rules'=>'trim|required|max_length[10]|xss_clean|greater_than[0]');
	$coupon_field['limitGoodsPrice']		= array('label'=>"최소주문 금액",				'rules'=>'trim|numeric|xss_clean');
	$coupon_field['issueGoods[]']			= array('label'=>"적용 상품",					'rules'=>'trim|numeric|xss_clean');
	$coupon_field['issueCategoryCode[]']	= array('label'=>"적용 카테고리",				'rules'=>'trim|xss_clean');
	$coupon_field['couponImg']				= array('label'=>"쿠폰 PC용 이미지",			'rules'=>'trim|numeric|max_length[3]|xss_clean');
	$coupon_field['couponmobileImg']		= array('label'=>"쿠폰 Mobile용 이미지",		'rules'=>'trim|numeric|max_length[3]|xss_clean');
	$coupon_field['certificate_issued_type']= array('label'=>"인증번호 발급 설정",			'rules'=>'trim|required|max_length[6]|xss_clean');
	$coupon_field['offline_type']			= array('label'=>"인증번호 발급 방식",			'rules'=>'trim|required|max_length[11]|xss_clean');
	$coupon_field['downloadLimitEa']		= array('label'=>"쿠폰 수량 제한",				'rules'=>'trim|required|numeric|xss_clean|greater_than[0]');
	$coupon_field['offline_random_num']		= array('label'=>"인증번호 발급 수",			'rules'=>'trim|numeric|min_length[1]|max_length[5]|xss_clean|greater_than[0]|less_than_equal_to[10000]');
	$coupon_field['offlineLimitEa_one']		= array('label'=>"인증 제한 선착순",			'rules'=>'trim|numeric|min_length[1]|required|xss_clean|greater_than[0]');
	$coupon_field['offline_input_num']		= array('label'=>"동일 인증 번호",				'rules'=>'trim|required|xss_clean');
	$coupon_field['offlineLimitEa_input']	= array('label'=>"인증 횟수 선착순",			'rules'=>'trim|numeric|required|xss_clean|greater_than[0]');
	$coupon_field['offline_file']			= array('label'=>"수동생성 > 엑셀파일",			'rules'=>'trim|required|xss_clean');
	$coupon_field['offline_emoney']			= array('label'=>"쿠폰 인증 시 마일리지 지급액",'rules'=>'trim|numeric|required|xss_clean|greater_than[0]');
	$coupon_field['downloadLimitEa_offline']= array('label'=>"인증횟수",					'rules'=>'trim|required|max_length[10]|xss_clean|greater_than[0]');
	$coupon_field['certificationDate_s']	= array('label'=>"인증 기간",					'rules'=>'trim|required|max_length[10]|xss_clean');
	$coupon_field['certificationDate_e']	= array('label'=>"인증 기간",					'rules'=>'trim|required|max_length[10]|xss_clean');
	$coupon_field['order_terms']			= array('label'=>"신규 가입 미 구매 일 수",		'rules'=>'trim|required|max_length[5]|xss_clean|greater_than[0]');
	$coupon_field['afterUpgrade']			= array('label'=>"등급조정일수",				'rules'=>'trim|required|max_length[5]|xss_clean');
	$coupon_field['couponsametime']			= array('label'=>"타 쿠폰과 함께 사용 여부",	'rules'=>'trim|required|xss_clean');
	$coupon_field['issue_type']				= array('label'=>"상품/카테고리 제한 여부",		'rules'=>'trim|required|xss_clean');
	$coupon_field['sale_agent']				= array('label'=>"사용 가능환경 제한 여부",		'rules'=>'trim|required|xss_clean');
	$coupon_field['sale_payment']			= array('label'=>"결제 가능 수단 제한 여부",	'rules'=>'trim|required|xss_clean');
	$coupon_field['sale_referer']			= array('label'=>"할인 유입 경로",				'rules'=>'trim|required|xss_clean');
	$coupon_field['sale_referer_type']		= array('label'=>"유입경로 할인 중복",			'rules'=>'trim|xss_clean');
	$coupon_field['referersale_seq[]']		= array('label'=>"유입 경로 할인",				'rules'=>'trim|required|xss_clean');
	$coupon_field['sale_store_item[]']		= array('label'=>"오프라인 매장",				'rules'=>'trim|required|xss_clean');
	$coupon_field['beforeDay']				= array('label'=>"기간 설정(~ 일 전)",			'rules'=>'trim|required|max_length[3]|xss_clean|greater_than[0]');
	$coupon_field['afterDay']				= array('label'=>"기간 설정(~ 일 전)",			'rules'=>'trim|required|max_length[3]|xss_clean|greater_than[0]');
	$coupon_field['offline_reserve_year']	= array('label'=>"유효기간(년수 제한)",			'rules'=>'trim|max_length[3]|required|xss_clean');
	$coupon_field['offline_reserve_direct']	= array('label'=>"유효기간(개월수 제한1)",		'rules'=>'trim|max_length[3]|required|xss_clean|greater_than[0]');
	$coupon_field['wonShippingSale']		= array('label'=>"기본 배송비 할인액",			'rules'=>'trim|max_length[10]|required|xss_clean|greater_than[0]');

	$config['fieldValiSet'] = $coupon_field;

// 기본 체크 필드
$config['validation']['common'] = array('couponType','couponName','couponDesc','downloadDate_s','downloadDate_e','limitGoodsPrice','couponImg','couponmobileImg');

$couponValidation = array();
/*
특정필드 필수입력 및 유효성 체크
*/
	/// 쿠폰타입
	$couponValidation['couponType']['y'] = array('couponType');

	/// 오프라인매장 체크
	$couponValidation['offlineStore']['y'] = array('sale_store_item[]');
	/// 쿠폰명
	$couponValidation['couponName']['y'] = array('couponName');
	$couponValidation['couponDesc']['y'] = array('couponDesc');

	/// 혜택부담-본사 or 입점사-부담률 지정 : 입점사선택일 경우 'salescost_provider_list[]' 체크
	$couponValidation['discount_seller_type']['ALL']['discount_seller_type']['all']		= array('salescost_provider');
	$couponValidation['discount_seller_type']['AOP']['discount_seller_type']['seller']	= array('salescost_provider','salescost_provider_list[]');

	/// 혜택-상품정률/정액할인
	$couponValidation['benefit_type']['rate_amount'] = array('saleType','goodsSalePrice');
	$couponValidation['benefit_type']['rate_amount']['saleType']['percent'] = array('maxPercentGoodsSale');

	/// 혜택-배송비무료/배송비할인 금액지정
	//$couponValidation['benefit_type']['shipping'] = array('shippingType','wonShippingSale');
	$couponValidation['benefit_type']['shipping']['shippingType']['free'] 	= array('wonShippingSale');
	$couponValidation['benefit_type']['shipping']['shippingType']['won'] 	= array('wonShippingSale');

	// 혜택-최소주문금액
	$couponValidation['limitGoodsPrice']['y'] = array('limitGoodsPrice');

	/// 혜택-마일리지
	$couponValidation['benefit_type']['mileage'] = array('offline_emoney');

	/// *혜택-유효기간-특정기간지정 or 기한지정 - 선택 조건값에 따라 필수 항목 변경
	$couponValidation['periodofuse_type']['date'] = array('issuePriodType','issueDate[]');

	/// 혜택-유효기간-기한지정
	$couponValidation['periodofuse_type']['day'] = array('issuePriodType','afterIssueDay');

	/// 혜택-유효기간-기한지정
	$couponValidation['periodofuse_type']['months'] = array('issuePriodType');

	/// 혜택-유효기간-기한지정
	$couponValidation['periodofuse_type']['year'] = array('offline_reserve_year');

	/// 혜택-유효기간-기한지정
	$couponValidation['periodofuse_type']['direct']	= array('offline_reserve_direct');

	// 쿠폰발급-발급수량제한
	$couponValidation['downloadLimitSet']['limit']['downloadLimit']['limit']	= array('downloadLimitEa');

	/// 발급기간-기간/시간/요일설정
	$couponValidation['downloadPeriodSet']['period']['download_period_use']['limit'] = array('downloadDate_s[]','downloadDate_e[]');

	/// 발급기간-00일전 ~ 00일 후
	$couponValidation['downloadPeriodSet']['beforeafter'] = array('beforeDay','afterDay');

	/// 발급기간-00일로부터
	$couponValidation['downloadPeriodSet']['daysfrom'] = array('afterUpgrade');

	/// 발급기간-00일로부터
	$couponValidation['downloadPeriodSet']['neworder'] = array('order_terms');

	/// 등급제한설정 (단, 상품 회원등급조정,이달의등급,배송비 회원등급조정은 필수)
	$couponValidation['memberGradeSet']['gradelimit']['couponType']['memberGroup']				= array('member_grade_list[]');
	$couponValidation['memberGradeSet']['gradelimit']['couponType']['membermonths']				= array('member_grade_list[]');
	$couponValidation['memberGradeSet']['gradelimit']['couponType']['memberGroup_shipping']		= array('member_grade_list[]');
	$couponValidation['memberGradeSet']['gradelimit']['couponType']['membermonths_shipping']	= array('member_grade_list[]');

	/// 쿠폰인증 사용 시 - 인증횟수제한, 인증기간
	$couponValidation['couponCertificationSet']['y'] = array('downloadLimitEa_offline','certificationDate_s','certificationDate_e');

	/// 전환포인트
	$couponValidation['conversionPointSet']['y'] = array('coupon_point');

	/// 인증번호발급 - 선택 조건값에 따라 필수 항목 변경
	//$couponValidation['certificationNumberSet']['y'] = array('certificate_issued_type','offline_type');
	$couponValidation['certificationNumberSet']['y']['certificate_issued_type']['auto']['offline_type']['random']			= array('offline_random_num');
	$couponValidation['certificationNumberSet']['y']['certificate_issued_type']['auto']['offlineLimit_one']['limit']		= array('offlineLimitEa_one');
	$couponValidation['certificationNumberSet']['y']['certificate_issued_type']['manual']['offlineLimit_input']['limit']	= array('offlineLimitEa_input');
	$couponValidation['certificationNumberSet']['y']['certificate_issued_type']['manual']['offline_type']['input']			= array('offline_input_num');
	$couponValidation['certificationNumberSet']['y']['certificate_issued_type']['manual']['offline_type']['file']			= array('offline_file');

	/// *쿠폰사용제한 - 선택 조건값에 따라 필수 항목 변경
	$couponValidation['usedTogether']['y']			= array('couponsametime');						//타 쿠폰과 함께 사용 여부
	$couponValidation['goodsCategoryLimit']['y']	= array('issue_type');							//상품/카테고리 제한 여부
	$couponValidation['deviceUsed']['y']			= array('sale_agent');							//사용 가능환경 제한 여부
	$couponValidation['methodOfPayment']['y']		= array('sale_payment');						//결제 가능 수단 제한 여부
	$couponValidation['refererLimit']['y']['sale_referer']['y']['sale_referer_type']['s']	= array('referersale_seq[]');	//유입경로할인 validation check




$config['validation']['etc'] = $couponValidation;

