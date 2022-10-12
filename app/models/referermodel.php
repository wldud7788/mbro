<?php
/**
 * 매출증빙 서류 : 현금영수증/매출증빙 내역
 * @author gabia
 * @since version 1.0 - 2012.06.29
 */
class referermodel extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_referersale_list($sc){

		$addWhere = array();

		$limitStr = " LIMIT {$page}, {$perpage}";

		$addWhere[] = "referersale_seq > 0";

		if($sc['search_text']) $sc['search_text'] = trim($sc['search_text']);

		## 키워드 검색
		if	(!empty($sc['search_text'])){
			if(!empty($sc['search_field'])){
				$addWhere[]	= $sc['search_field']." like '%".$sc['search_text']."%' ";
			}else{
				$addWhere[]	= "(referersale_name like '%".$sc['search_text']."%' 
								or referersale_url like '%".$sc['search_text']."%' ) ";
			}
		}

		## 생성일 검색
		if	(!empty($sc['sdate']) && !empty($sc['edate'])){
			$addWhere[]	= "regist_date between '".$sc['sdate']." 00:00:00' and '".$sc['edate']." 23:59:59' ";
		}elseif	(!empty($sc['sdate'])){
			$addWhere[]	= "regist_date >= '".$sc['sdate']." 00:00:00' ";
		}elseif	(!empty($sc['edate'])){
			$addWhere[]	= "regist_date <= '".$sc['edate']." 23:59:59' ";
		}

		## 통신판매중계자 부담율 검색
		$sales_cost_fld	= 'salescost_admin';
		if	($sc['cost_type'] == 'provider')	$sales_cost_fld	= 'salescost_provider';
		if		(!empty($sc['search_cost_start']) && !empty($sc['search_cost_end'])){
			$addWhere[]	= "".$sales_cost_fld." between '".$sc['search_cost_start']."' and  '".$sc['search_cost_end']."' ";
		}elseif	(!empty($sc['search_cost_start']) && empty($sc['search_cost_end'])){
			$addWhere[]	= "".$sales_cost_fld." >= '".$sc['search_cost_start']."' ";
		}elseif	(empty($sc['search_cost_start']) && !empty($sc['search_cost_end'])){
			$addWhere[]	= "".$sales_cost_fld." <= '".$sc['search_cost_end']."' ";
		}

		## 입점사 검색, 입점사 관리자에서 검색 시
		if(!empty($sc['provider_seq'])){
			if($sc['provider_seq'] == 1){
				$addWhere[] = "provider_list = ''";
			}else{
				$addWhere[] = "provider_list like '%|".$sc['provider_seq']."|%'";
			}
		}
		$sqlWhereClause = $addWhere ? implode(' AND ',$addWhere) : "";

		$limitStr =" LIMIT {$sc['page']}, {$sc['perpage']} ";

		$sql				= array();
		$sql['field']		= "*,(select order_seq from fm_order_item_option where referersale_seq > 0 and referersale_seq = ref.referersale_seq limit 1) as order_seq";
		$sql['table']		= "fm_referersale as ref";
		$sql['wheres']		= $sqlWhereClause;
		$sql['orderby']		= "ORDER BY referersale_seq DESC";
		$sql['limit']		= $limitStr;
		$result				= pagingNumbering($sql,$sc);

		return $result;

	}

	//프로모션 > 쿠폰 > 사용제한 - 유입경로
	public function get_referersale_all($sc){ 

		## 키워드 검색
		if	(!empty($sc['search_text'])){
			$addWhere	.= " and (referersale_name like '%".$sc['search_text']."%' 
								or referersale_url like '%".$sc['search_text']."%' ) ";
		}

		## 생성일 검색
		if	(!empty($sc['sdate']) && !empty($sc['edate'])){
			$addWhere	.= " and regist_date between '".$sc['sdate']."' and '".$sc['edate']."' ";
		}elseif	(!empty($sc['sdate'])){
			$addWhere	.= " and regist_date >= '".$sc['sdate']."' ";
		}elseif	(!empty($sc['edate'])){
			$addWhere	.= " and regist_date <= '".$sc['edate']."' ";
		}

		## 통신판매중계자 부담율 검색
		if	(!empty($sc['search_cost'])){
			if	($sc['cost_type'] == 'provider')
				$addWhere	.= " and salescost_provider = '".$sc['search_cost']."' ";
			else
				$addWhere	.= " and salescost_admin = '".$sc['search_cost']."' ";
		}

		## 입점사 검색
		if	(!empty($sc['provider_seq'])){
			$addWhere	.= " and provider_list like '%|".$sc['provider_seq']."|%' ";
		}

		## 입점사 부담율 검색
		if	(!empty($sc['salescost_provider'])){
			$addWhere	.= " and salescost_provider > '".$sc['salescost_provider']."' ";
		}

		$sql	= "select * from fm_referersale";
		if( $addWhere ) $sql.= " where 1 ".$addWhere;
		$query	= $this->db->query($sql);
		$result	= $query->result_array(); 
		return $result;
	}

	public function get_referersale_info($referersale_seq){
		$sql	= "select * from fm_referersale where referersale_seq = ? ";
		$query	= $this->db->query($sql, array($referersale_seq));
		$result	= $query->result_array();

		return $result[0];
	}

	public function get_referersale_issuecategory($no)
	{
		$result = false;
		$this->db->where('referersale_seq', $no);
		$query = $this->db->get('fm_referersale_issuecategory');
		foreach( $query->result_array() as $row ){
			$result[] = $row;
		}
		return $result;
	}

	public function get_referersale_issuegoods($no)
	{		
		$result = false;
		
		$this->db->select("a.*");
		$this->db->from("fm_referersale_issuegoods AS a");
		if( defined('__SELLERADMIN__') === true ){
			$this->db->join('fm_goods AS g', 'g.goods_seq=a.goods_seq','left');
			$this->db->where('g.provider_seq', $this->providerInfo['provider_seq']);
		}
		$this->db->where('a.referersale_seq', $no);
		$query = $this->db->get();
		foreach( $query->result_array() as $row ){
			$result[] = $row;
		}
		return $result;

	}

	public function sales_referersale($referer_url, $goods_seq, $price, $ea,$couponreferear=null,$provider_seq=null){
		// http나 https 제거
		if	(preg_match('/^http/', $referer_url)){
			$referer_url	= addslashes(preg_replace('/^https*\:\/\//', '', $referer_url));
		}

		$date			= date('Y-m-d');
		$sql			= "select * from fm_referersale where '".$date."' between issue_startdate and issue_enddate and ( (url_type = 'like' and INSTR('".$referer_url."', referersale_url) ) or (url_type = 'equal' and referersale_url = '".$referer_url."') ) ";
			
			//프로모션 쿠폰 > 사용한- 유입경로 @2014-07-07
			if ( $couponreferear ) { 
				$couponreferein = implode("','",$couponreferear); 
				$sql.= " and referersale_seq in ('".$couponreferein."') "; 
			}

		$query			= $this->db->query($sql);
		$referersale	= $query->result_array();

		if($referersale){
			$this->load->model('goodsmodel');
			$goods_info			= $this->goodsmodel->get_goods($goods_seq);
			$goods_category		= $this->goodsmodel->get_goods_category($goods_seq);
			$category_code_arr	= array();
			if	($goods_category){
				foreach( $goods_category as $k => $category ) {
					$category_code_arr[]	= $category['category_code'];
				}
			}

			// 배송비쿠푼의 경우 상품지정안함. 본사/입점사만 지정.
			if($provider_seq && !$goods_info['provider_seq']) $goods_info['provider_seq'] = $provider_seq;

			foreach( $referersale as $k => $row ) {

				## 해당 상품의 할인 부담 입점사 체크
				if	( ($row['provider_list'] && !strstr($row['provider_list'], '|'.$goods_info['provider_seq'].'|')) || (!$row['provider_list'] && $goods_info['provider_seq'] != 1))	continue;

				if	($row['issue_type'] != 'all'){
					$issuegoods		= $this->get_referersale_issuegoods($row['referersale_seq']);
					$issuecategory	= $this->get_referersale_issuecategory($row['referersale_seq']);
				}

				## 허용인데 허용 대상 상품, 카테고리가 없는 경우 ( 전체 사용불가와 같음 )
				if	($row['issue_type'] == 'issue' && !$issuegoods && !$issuecategory) continue;

				if		($row['issue_type'] == 'issue')		$issueStatus	= false;
				elseif	($row['issue_type'] == 'except')	$issueStatus	= true;
				else										$issueStatus	= true;

				## 허용/예외 상품 체크
				if	($issuegoods){
					foreach( $issuegoods as $k => $goods ){
						if	($row['issue_type'] == $goods['type'])
							$issuegoods_arr[]	= $goods['goods_seq'];
					}

					if		($row['issue_type'] == 'issue'){
						if	(in_array($goods_seq, $issuegoods_arr))	$issueStatus	= true;
						else										$issueStatus	= false;
					}elseif	($row['issue_type'] == 'except'){
						if	(in_array($goods_seq, $issuegoods_arr))	$issueStatus	= false;
						else										$issueStatus	= true;
					}
				}

				## 허용/예외 카테고리 체크
				if	($issuecategory){
					foreach($issuecategory as $k => $category){
						if		($row['issue_type'] == 'issue'){
							if	(in_array($category['category_code'], $category_code_arr))	$issueStatus	= true;
						}elseif	($row['issue_type'] == 'except'){
							if	(in_array($category['category_code'], $category_code_arr))	$issueStatus	= false;
						}
					}
				}

				if	(!$issueStatus)	continue;

				## 개당 할인 금액 계산 ( 고객에게 유리한 할인을 적용하기 위한 할인금액 비교 )
				$row['sales_price']	= $row['won_goods_sale'];
				if	($row['sale_type'] == 'percent')
					$row['sales_price']	= $price * ($row['percent_goods_sale'] / 100);

				// 가격 절사
				$row['sales_price']	= get_price_point($row['sales_price']);

//				if	($row['duplication_use'] == 1)
					$row['sales_price']	= $row['sales_price'] * $ea;

				if	($row['sale_type'] == 'percent' && $row['sales_price'] > $row['max_percent_goods_sale'])
					$row['sales_price']	= $row['max_percent_goods_sale'];

				if	($result['sales_price']	> 0 && $result['sales_price'] > $row['sales_price'])
					continue;

				## 할인 적용
				$result				= $row;
			}
		}

		return $result;
	}

	public function get_salecost_provider($params){
		$ea						= $params['ea'];
		$referer_sale			= $params['referer_sale'];
		$provider_per			= $params['referersale']['salescost_provider'];
		$provider_list			= $params['referersale']['provider_list'];
		$provider_seq			= $params['provider_seq'];
		$salescost_provider		= 0;

		## 입점사의 부담율이 0보다 클 시 계산 ( 개당 부담금 )
		if	( $referer_sale > 0 && (($provider_list && strstr($provider_list, '|'.$provider_seq.'|')) || (!$provider_list && $provider_seq == 1))){
			$salescost_provider		= floor(($referer_sale * ($provider_per / 100)) / $ea);
		}

		return $salescost_provider;
	}

	public function get_referersale_for_url($referer_url, $url_type = 'equal'){
		$referer_url	= addslashes($referer_url);

		if	($url_type == 'like')
			$addWhere	= " or INSTR(referersale_url, '".$referer_url."') ";

		$sql			= "select * from fm_referersale where 
							(url_type = 'like' and INSTR('".$referer_url."', referersale_url)) or 
							(url_type = 'equal' and referersale_url = '".$referer_url."') "
							.$addWhere;
		$query			= $this->db->query($sql);
		$referersale	= $query->row_array();

		return $referersale;
	}

	// 유입경로 중복 체크 ( URL + 유효기간 + 입점사 + 제외 seq )
	public function chk_referersale_duple($referer_url, $url_type, $sdate, $edate, $provider_list, $referer_seq = ''){

		$url_type		= ($url_type) ? $url_type : 'equal';

		// 유효기간 중복 확인
		$addDate			= " '".$sdate."' between issue_startdate and issue_enddate or
								'".$edate."' between issue_startdate and issue_enddate ";

		// 유입경로 중복 확인
		$referer_url		= addslashes($referer_url);
		$addReferer			= " (url_type = 'like' and INSTR('".$referer_url."', referersale_url)) or 
								(url_type = 'equal' and referersale_url = '".$referer_url."') ";
		if	($url_type == 'like')
			$addReferer		.= " or INSTR(referersale_url, '".$referer_url."') ";

		// 입점사 중복 확인
		$addProvider		= " provider_list is null or provider_list = '' ";
		if	($provider_list){
			$provider_arr	= explode('|', $provider_list);
			foreach($provider_arr as $k => $provider_seq){
				if	($provider_seq)
					$addProviderSql[]	= " INSTR( provider_list, '|".$provider_seq."|' ) ";
			}

			if	(count($addProviderSql) > 0)
				$addProvider	= " " . implode(' or ', $addProviderSql) . " ";
		}

		// 제외 seq
		if	($referer_seq)
			$addSeq			= " and referersale_seq != '".$referer_seq."' ";

		$sql				= "select * from fm_referersale where 
								( ".$addDate." ) and 
								( ".$addReferer." ) and 
								( ".$addProvider." ) "
								.$addSeq;
		$query				= $this->db->query($sql);
		$referersale		= $query->row_array();

		return $referersale;
	}

	// 할인 대상 유입경로 할인 목록
	public function get_referersale_target_list($referer_url){
		if	($this->config_system['service']['code'] != 'P_FREE' && $this->isplusfreenot){

			// http나 https 제거
			if	(preg_match('/^http/', $referer_url)){
				$referer_url	= preg_replace('/^https*\:\/\//', '', $referer_url);
			}

			$date			= date('Y-m-d');
			$sql			= "select * from fm_referersale where '".$date."' between issue_startdate and issue_enddate and ( (url_type = 'like' and INSTR('".$referer_url."', referersale_url) ) or (url_type = 'equal' and referersale_url = '".$referer_url."') ) ";
			$query			= $this->db->query($sql);
			$referersale	= $query->result_array();
		}

		return $referersale;
	}

	// 해당 상품에 적용 가능한 유입경로 할인 목록
	public function get_goods_referersale($goods_seq, $category_code_arr = array(), $provider_seq=''){

		if	($this->config_system['service']['code'] != 'P_FREE' && $this->isplusfreenot){

			$date			= date('Y-m-d');
			$sql			= "select * from fm_referersale where '".$date."' between issue_startdate and issue_enddate ";
			
			## 입점사 정보만..
			if($provider_seq && $provider_seq != 1){
				$sql	.= " and provider_list like '%|".$provider_seq."|%' ";
			}

			$query			= $this->db->query($sql);
			$referersale	= $query->result_array();

			if($referersale){
				$this->load->model('goodsmodel');
				$goods_info			= $this->goodsmodel->get_goods($goods_seq);
				if	(!is_array($category_code_arr) || count($category_code_arr) < 1 ){
					$goods_category		= $this->goodsmodel->get_goods_category($goods_seq);
					$category_code_arr	= array();
					if	($goods_category){
						foreach( $goods_category as $k => $category ) {
							$category_code_arr[]	= $category['category_code'];
						}
					}
				}

				foreach( $referersale as $k => $row ) {

					if	($row['issue_type'] != 'all'){
						$issuegoods		= $this->get_referersale_issuegoods($row['referersale_seq']);
						$issuecategory	= $this->get_referersale_issuecategory($row['referersale_seq']);
					}

					## 허용인데 허용 대상 상품, 카테고리가 없는 경우 ( 전체 사용불가와 같음 )
					if	($row['issue_type'] == 'issue' && !$issuegoods && !$issuecategory) continue;

					if($row['issue_type'] == 'all') {
						$issueStatus	= true;
					}

					## 허용/예외 상품 체크
					if	($issuegoods){
						foreach( $issuegoods as $k => $goods ){
							if	($row['issue_type'] == $goods['type'])
								$issuegoods_arr[]	= $goods['goods_seq'];
						}

						if($row['issue_type'] == 'issue'){
							if(in_array($goods_seq, $issuegoods_arr))	$issueStatus	= true;
							else										$issueStatus	= false;
						}elseif	($row['issue_type'] == 'except'){
							if	(in_array($goods_seq, $issuegoods_arr))	$issueStatus	= false;
							else										$issueStatus	= true;
						}
					}


					## 허용/예외 카테고리 체크
					if	($issuecategory){
						foreach($issuecategory as $k => $category){
							if		($row['issue_type'] == 'issue'){
								if	(in_array($category['category_code'], $category_code_arr))	$issueStatus	= true;
							}elseif	($row['issue_type'] == 'except'){
								if	(in_array($category['category_code'], $category_code_arr))	$issueStatus	= false;
							}
						}
					}

					if	(!$issueStatus)	continue;

					## 할인 적용
					$result[]		= $row;
				}
			}
		}

		return $result;
	}

	# 진행중인 유입경로 할인
	public function get_referersale_ing_list(){
		$ingeventsql	= 'SELECT * FROM fm_referersale WHERE NOW() BETWEEN issue_startdate AND issue_enddate';
		$ingeventquery	= $this->db->query($ingeventsql);
		return $ingeventquery->result_array();
	}
}