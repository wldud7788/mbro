<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
class set_fm_code extends front_base {

	public function main_index()
	{
		redirect("main/index");
	}

	public function index()
	{
		//error_reporting(E_ALL);
		
		unset($arr);
		$arr['KRW'] = array('symbol' => '&#x20a9;','hangul' => '원','nation' => '한국');
		$arr['USD'] = array('symbol' => htmlentities('$',ENT_HTML5),'hangul' => '달러','nation' => '미국');
		$arr['CNY'] = array('symbol' => htmlentities('¥',ENT_HTML5),'hangul' => '위안','nation' => '중국');
		$arr['JPY'] = array('symbol' => htmlentities('¥',ENT_HTML5),'hangul' => '엔','nation' => '일본');
		$arr['EUR'] = array('symbol' => htmlentities('€',ENT_HTML5),'hangul' => '유로','nation' => '유럽');
		$i = 0;
		echo "DELETE FROM `fm_code` WHERE groupcd='currency';".chr(10);
		foreach($arr as $curr => $code){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('currency', '%s', '%s','2016-06-14 20:%02d:00');",$curr,serialize($code),$i).chr(10);
			echo $query;
			$i++;
		}

		unset($arr);
		$arr['CN'] = array('name'=>'중국어','currency_code'=>'CNY','config_code'=>'chinese');
		$arr['US'] = array('name'=>'영어','currency_code'=>'USD','config_code'=>'english');
		$arr['KR'] = array('name'=>'한국어','currency_code'=>'KRW','config_code'=>'korean');
		$arr['JP'] = array('name'=>'일본어','currency_code'=>'JPY','config_code'=>'japanese');

		$i = 0;
		echo "DELETE FROM `fm_code` WHERE groupcd='language';".chr(10);
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('language', '%s', '%s','2016-06-23 20:%02d:00');",$code,serialize($value),$i).chr(10);
			echo $query;
			$i++;
		}

		unset($arr);
		$arr['KRW'] = 1000;
		$arr['CNY'] = 1;
		$arr['JPY'] = 100;
		$arr['EUR'] = 1;
		$arr['USD'] = 1;

		$i = 0;
		echo "DELETE FROM `fm_code` WHERE groupcd='currency_amout';".chr(10);
		foreach($arr as $curr => $code){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('currency_amout', '%s', '%s','2016-07-25 20:%02d:00');",$curr,$code,$i).chr(10);
			echo $query;
			$i++;
		}

		unset($arr);
		$arr['KRW'][] =  htmlentities('\\',ENT_HTML5);
		$arr['KRW'][] = 'KRW';
		$arr['KRW'][] = '원';
		$arr['KRW'][] = 'won';

		$arr['USD'][] = htmlentities('$',ENT_HTML5);
		$arr['USD'][] = 'USD';
		$arr['USD'][] =  htmlentities('US$',ENT_HTML5);

		$arr['CNY'][] = htmlentities('¥');
		$arr['CNY'][] = 'CNY';
		$arr['CNY'][] =  htmlentities('元',ENT_HTML5);

		$arr['JPY'][] = htmlentities('¥');
		$arr['JPY'][] = 'JPY';
		$arr['JPY'][] =  htmlentities('円',ENT_HTML5);

		$arr['EUR'][] = htmlentities('€');
		$arr['EUR'][] =  htmlentities('EUR',ENT_HTML5);

		$i = 0;
		echo "DELETE FROM `fm_code` WHERE groupcd='currency_symbol';".chr(10);
		foreach($arr as $curr => $code){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('currency_symbol', '%s', '%s','2016-07-26 20:%02d:00');",$curr,serialize($code),$i).chr(10);
			echo $query;
			$i++;
		}
		

		## 주문
		$d = "2016-07-28";
		$t = 0;

		$i = 0;
		unset($arr);
		$arr['manager_yn'] = '슈퍼관리자';
		$t++;
		$groupcd = 'auth_manager';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		$i = 0;
		unset($arr);
		$arr['order_view'] = '주문보기';
		$arr['order_deposit'] = '입금확인 처리';
		$arr['order_goods_export'] = '출고/배송 처리';
		$arr['personal_act'] = '개인결제 만들기(개인결제 리스트  조회) 및 관리자 주문 넣기';
		$arr['autodeposit_view'] = '자동입금확인 보기';
		$arr['autodeposit_act'] = '수동 실행 권한';
		$arr['refund_view'] = '반품/환불 보기';
		$arr['refund_act'] = '반품/환불 정보 처리';
		$arr['temporary_view'] = '삭제리스트 보기';
		$arr['sales_view'] = '매출증빙자료(카드매출전표, 현금영수증,세금계산서) 보기';
		$t++;
		$groupcd = 'auth_order';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		## 상품
		$i = 0;
		unset($arr);
		$arr['goods_view'] = '판매상품 보기';
		$arr['goods_act'] = '판매상품 정보 등록/수정/삭제 (사은품,상품데이터 일괄업데이트,카테고리/브랜드/지역 관리 및 바코드 인쇄 포함)';
		$t++;
		$groupcd = 'auth_goods';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}


		## 회원
		$i = 0;
		unset($arr);
		$arr['member_view'] = '회원 보기';
		$arr['member_act'] = '회원 정보 수정';
		$arr['member_promotion'] = '마일리지/포인트 지급 (자동 지급 외 수동 지급)';
		$arr['member_download'] = '회원정보 다운로드';
		$arr['dormancy_view'] = '휴면처리리스트';
		$arr['withdrawal_view'] = '탈퇴리스트 보기';
		$arr['withdrawal_act'] = '회원탈퇴 처리';
		$arr['member_send'] = 'SMS 및 메일발송 (자동 발송 외 수동 발송)';
		$t++;
		$groupcd = 'auth_member';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		## 프로모션/쿠폰
		$i = 0;
		unset($arr);
		$arr['coupon_view'] = '쿠폰 보기';
		$arr['coupon_act'] = '쿠폰/코드 등록 및 발급';
		$arr['event_view'] = '할인 이벤트 보기';
		$arr['event_act'] = '할인 이벤트 등록 및 수정';
		$arr['gift_view'] = '사은품 이벤트 보기';
		$arr['gift_act'] = '사은품 이벤트 등록 및 수정';
		$arr['referer_view'] = '유입 경로 할인 보기';
		$arr['referer_act'] = '유입경로 할인 등록 및 수정';
		$arr['joincheck_view'] = '출석 이벤트 보기';
		$arr['joincheck_act'] = '출석 이벤트 등록 및 수정';
		$t++;
		$groupcd = 'auth_promotion';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		## 프로모션/쿠폰
		$i = 0;
		unset($arr);
		$arr['marketplace_view'] = '입점마케팅 설정 보기';
		$arr['marketplace_act'] = '입점마케팅 수정';
		$t++;
		$groupcd = 'auth_marketplace';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		## 통계
		$i = 0;
		unset($arr);
		$arr['statistic_summary'] = '요약';
		$arr['statistic_visitor'] = '방문';
		$arr['statistic_member'] = '가입';
		$arr['statistic_sales'] = '구매';
		$arr['statistic_goods'] = '상품';
		$arr['statistic_epc'] = '적립';
		$t++;
		$groupcd = 'auth_statistic';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		## 입점사
		$i = 0;
		unset($arr);
		$arr['provider_view'] = '입점사 보기';
		$arr['provider_act'] = '입점사 등록 및 수정';
		$t++;
		$groupcd = 'auth_provider';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		$i = 0;
		unset($arr);
		$arr['account_view'] = '정산리스트 보기';
		$t++;
		$groupcd = 'auth_account';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		## 디자인
		$i = 0;
		unset($arr);
		$arr['design_act'] = '디자인 권한 (스킨설정, PC/Mobile/Tablet/Facebook)';
		$t++;
		$groupcd = 'auth_design';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		## 설정
		$i = 0;
		unset($arr);
		$arr['setting_basic_view'] = '멀티/글로벌 보기';
		/*$arr['setting_basic_act'] = '일반정보 설정';*/
		$arr['setting_seo_view'] = 'SEO 보기';
		$arr['setting_seo_act'] = 'SEO 설정';
		$arr['setting_snsconf_view'] = 'SNS/외부연동 보기';
		$arr['setting_snsconf_act'] = 'SNS/외부연동 설정';
		$arr['setting_operating_view'] = '운영방식 보기';
		$arr['setting_operating_act'] = '운영방식 설정';
		$arr['setting_pg_view'] = '전자결제 보기';
		$arr['setting_bank_view'] = '무통장 보기';
		$arr['setting_member_view'] = '회원 보기';
		$arr['setting_member_act'] = '회원 설정';
		$arr['setting_goodscd_view'] = '상품/코드 보기';
		$arr['setting_goodscd_act'] = '상품/코드 설정';
		$arr['setting_address_view'] = '주소/검색 보기';
		$arr['setting_address_act'] = '주소/검색 설정';
		$arr['setting_order_view'] = '주문 보기';
		$arr['setting_order_act'] = '주문 설정';
		$arr['setting_sale_view'] = '매출증빙 보기';
		$arr['setting_sale_act'] = '매출증빙 설정';
		$arr['setting_reserve_view'] = '마일리지/예치금 보기';
		$arr['setting_reserve_act'] = '마일리지/예치금 설정';
		$arr['setting_shipping_view'] = '배송 설정 보기';
		$arr['setting_shipping_act'] = '배송 설정 설정';
		$arr['setting_deliverycompany_view'] = '택배사 보기';
		$arr['setting_deliverycompany_act'] = '택배사 설정';
		$arr['setting_protect_view'] = '보안 보기';
		$arr['setting_protect_act'] = '보안 설정 권한';
		$arr['setting_admin_view'] = '보안 보기';
		$t++;
		$groupcd = 'auth_setting';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		## 게시판
		$i = 0;
		unset($arr);
		$arr['board_manger'] = '게시판 관리 (생성,수정,삭제)';
		$t++;
		$groupcd = 'auth_board';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		## 고객상담게시판
		$i = 0;
		unset($arr);
		$arr['counsel_view'] = '고객상담 통합게시판 보기';
		$arr['counsel_act'] = '고객상담 통합게시판 관리';
		$t++;
		$groupcd = 'auth_counsel';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}


		$d = "2016-07-29";
		$t = 0;

		## 재고기초
		$i = 0;
		unset($arr);
		$arr['scmstore_view'] = '쇼핑몰별 창고 보기';
		$arr['scmstore_act'] = '쇼핑몰별 창고 수정';
		$arr['scmtrader_view'] = '거래처(매입처) 보기';
		$arr['scmtrader_act'] = '거래처 등록 및 수정';
		$arr['scmwarehouse_view'] = '창고 보기';
		$arr['scmwarehouse_act'] = '창고 등록 및 수정';
		$t++;
		$groupcd = 'auth_scmstore';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		## 재고관리
		$i = 0;
		unset($arr);
		$arr['scmgoods_view'] = '상품관리 보기';
		$arr['scmgoods_act'] = '상품관리 등록 및 수정';
		$arr['scmrevision_view'] = '재고조정 보기';
		$arr['scmrevision_act'] = '재고조정 등록';
		$arr['scmstockmove_view'] = '재고이동 보기';
		$arr['scmstockmove_act'] = '재고이동 등록';
		$arr['scmledger_view'] = '재고수불부 보기';
		$arr['scminven_view'] = '재고자산명세서 보기';
		$t++;
		$groupcd = 'auth_scmgoods';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}

		## 발주/입고
		$i = 0;
		unset($arr);
		$arr['scmautoorder_view'] = '자동발주 보기';
		$arr['scmautoorder_act'] = '자동발주 등록 및 수정';
		$arr['scmsorder_view'] = '발주 보기';
		$arr['scmsorder_act'] = '발주 처리';
		$arr['scmwarehousing_view'] = '입고 보기';
		$arr['scmwarehousing_act'] = '입고 처리';
		$arr['scmcarryingout_view'] = '반출 보기';
		$arr['scmcarryingout_act'] = '반출 처리';
		$arr['scmsordwhs_view'] = '발주입고현황 보기';
		$arr['scmsordforwhs_view'] = '발주대비 입고현황 보기';
		$arr['scmtraderaccount_view'] = '거래처별 정산 보기';
		$t++;
		$groupcd = 'auth_scmautoorder';
		$query = sprintf("DELETE FROM `fm_code` WHERE groupcd='%s';",$groupcd).chr(10);
		echo $query;
		foreach($arr as $code => $value){
			$query = sprintf("INSERT INTO `fm_code` (`groupcd`, `codecd`, `value`, `regist_date`)
				VALUES ('%s', '%s', '%s','".$d." %02d:%02d:00');",$groupcd,$code,$value,$t,$i).chr(10);
			echo $query;
			$i++;
		}
	}

	public function blank()
	{
		unset($this);
		exit;

	}

	public function test()
	{
		debug($this->db->conn_id);
		$orderby = mysqli_real_escape_string($this->db->conn_id, '11111');
		debug($orderby);
	}

}

