<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * IFDO 연동 라이브러리
 * 2020-09-28
 * by hed 
 */
class ifdolibrary
{
	public $allow_exit = true;
	public $ifdo_marketing;
	public $script;
	
	function __construct() {
		$this->CI =& get_instance();
		
		// ifdo 기본 정보
		$this->ifdo_marketing = $this->get_ifdo_marketing();
	}
	
	/**
	 * IFDO연동 설정 저장
	 * @param type $aPostParams
	 * @return type
	 */
	function set_ifdo_marketing($aPostParams){
		$ifdo_marketing = array();
		$ifdo_marketing['use'] 		= trim($aPostParams['ifdo_marketing_use']);
		$ifdo_marketing['code'] 	= trim($aPostParams['ifdo_marketing_code']);
		config_save('ifdo_marketing', $ifdo_marketing);
		
		$items = $this->get_ifdo_marketing();
		return $items;
	}
	
	/**
	 * IFDO연동 설정 정보
	 * @param type $aPostParams
	 * @return type
	 */
	function get_ifdo_marketing(){
		$items = config_load('ifdo_marketing');
		return $items;
	}
	
	function check_used(){
		return ($this->ifdo_marketing["use"] == "Y" && $this->ifdo_marketing["code"]);
	}
	
	function check_base_validation(){
		return ($this->ifdo_marketing["use"] == "Y" && $this->ifdo_marketing["code"] && !$_GET['popup'] && !$_GET['iframe'] && !preg_match('/admin\//',$CI->uri->uri_string));
	}
	
	// 1. 공통스크립트
	function init($ret){
		$script = '';
		
		// 회원 수집 스크립트는 공통 스크립트에 부가정보이므로 별도로 호출
		$this->member();
		
		// 추가 스크립트
		$extend_script = implode($this->script, "");
		
		
		// 하이브리드앱 버전
		$app_version = '';
		
		// ifo 공통스크립트
		if($this->check_base_validation()){
			$init_script = "
				<!-- Start Script for IFDO -->
				<script type='text/javascript'>
				if(typeof(_NB_gs) === 'undefined'){
					var _NB_gs = 'wlog.ifdo.co.kr'; 
					var _NB_MKTCD = '".$this->ifdo_marketing["code"]."';
					var _NB_APPVER='".$app_version."'; /* 하이브리드 앱 버전 */
					(function(a,b,c,d,e){var f;f=b.createElement(c),g=b.getElementsByTagName(c)[0];f.async=1;f.src=d;
					f.setAttribute('charset','utf-8');
					g.parentNode.insertBefore(f,g)})(window,document,'script','//script.ifdo.co.kr/jfullscript.js');	
				}
				</script>
				<!-- End Script for IFDO -->
			";
		}
		
		$script = $ret.$extend_script.$init_script;
		
		
		return $script;
	}
	
	// 2. 회원 가입 분석
	function join($userInfo = ''){
		$this->script['join'] = '';
		
		// ifdo 출력 조건
		if($userInfo && $this->check_base_validation()){
			$this->script['join'] = "
				<!-- Start Script for IFDO (회원가입분석) -->
				<script type='text/javascript'>
					var _NB_JID='".$userInfo."';
					var _NB_JN='join'; // 회원가입 :join
				</script>
				<!-- End Script for IFDO -->
			";
		}
		
		return $this->script['join'];
	}
	
	// 3. 회원 분석 
	// 회원 분석은 공통스크립트과 짝으로 수집
	function member(){
		$this->script['member'] = '';
		$userInfo = $this->CI->session->userdata('user');
		
		// ifdo 출력 조건
		if($userInfo['member_seq'] && $this->check_base_validation()){
			$this->script['member'] = "
				<!-- Start Script for IFDO (회원분석) -->
				<script type='text/javascript'>
					var _NB_ID='".$userInfo['userid']."';
					var _NB_EMAIL = '".$userInfo['email']."';
					var _NB_UDF={'udf01':'".$userInfo['user_name']."','udf02':'".$userInfo['email']."','udf06':'".$userInfo['group_name']."'};
				</script>
				<!-- End Script for IFDO -->
			";
		}
		
		return $this->script['member'];
	}
	
	// 4. 상품조회 분석
	function goods_view($goods = array()){
		$this->script['goods_view'] = '';
		$userInfo = $this->CI->session->userdata('user');
		
		// 판매금액
		$goods_price = ($goods['price'] > $goods['sale_price']) ? $goods['sale_price'] : $goods['price'];
		
		// 품절 
		$goods_status = ($goods['goods_status'] == 'runout') ? 'N' : '';
			
		// ifdo 출력 조건
		if($this->check_base_validation()){
			$this->script['goods_view'] = "
				<!-- Start Script for IFDO (상품조회 분석) -->
				<script type='text/javascript'>
				var _NB_PD = '".$goods['goods_name']."';
				var _NB_PC = '".$goods['goods_seq']."';
				".( ($goods_price) ? " var _NB_AMT = ".$goods_price."; " : "" )."
				function _LastMetaTag(a ,b) {var metas = document.getElementsByTagName('meta');var e='';for (var i=0; i<metas.length; i++) { if (metas[i].getAttribute(a) == b) { e= metas[i].getAttribute('content'); }};return e;};
				var _NB_IMG = _LastMetaTag('property','og:image');  /* 제품이미지 */
				var _NB_PD_USE = ''; /* 현재 상품이 품절인 경우 N 값을 넣어주세요 */
				var _NB_DAMT = ''; /* 제품 할인가격 */
				</script>
				<!-- End Script for IFDO -->
			";
		}
		
		return $this->script['goods_view'];
	}
	
	// 5. 장바구니 분석
	function cart_view($shipping_group_list = array()){
		$this->script['cart_view'] = '';
		
		// ifdo 출력 조건
		if($this->check_base_validation()){
			// 장바구니 수집 목록 구성
			$cart_list_html = "";
			if($shipping_group_list){
				$cart_list_html .= "
					<!-- IFDO 장바구니 분석 목록 구성 시작 -->
					<div id='Order_BasketPackage' style='display:none;'>
						<div class='orderListArea'>
							<table border='1' summary='' >
							<tbody class='center middle' id='ifdo_basket_list'>
				";

				foreach($shipping_group_list as $shipping_group){
					foreach($shipping_group['goods'] as $goods_info){
						$cart_list_html .= "
							<tr class='ifdo_basket_ul'>
								<td class='ifdo_product_name'>".$goods_info['goods_name']."</td>
								<td class='ifdo_product_no'>".$goods_info['goods_seq']."</td>
								<td class='ifdo_product_price'>".($goods_info['price'] * $goods_info['ea'])."</td>
								<td class='ifdo_product_cate'></td>
								<td class='ifdo_product_num'>".$goods_info['ea']."</td>
							</tr>
						";
					}
				}

				$cart_list_html .= "
							</tbody>
							</table>
						</div>
					</div>
					<!-- IFDO 장바구니 분석 목록 구성 종료 -->
				";

			}

			// 장바구니 수집 기본 스크립트
			$cart_base_html = "
				<!-- Start Script for IFDO (장바구니 분석) -->
				<script type='text/javascript'>
					var _NB_LO = [];
					var _NB_plist =[];
					var obj = document.getElementById('ifdo_basket_list');
					if( obj != null ){
						var obj2 = obj.getElementsByClassName('ifdo_basket_ul');
						var len = obj2.length;
						if( len > 0 ){
							for(var i=0;i<len;i++){
								var _l_name=obj2[i].getElementsByClassName('ifdo_product_name')[0].textContent;
								var _l_price=obj2[i].getElementsByClassName('ifdo_product_price')[0].textContent;
								var _l_cate=obj2[i].getElementsByClassName('ifdo_product_cate')[0].textContent;
								var _l_pc=obj2[i].getElementsByClassName('ifdo_product_no')[0].textContent;
								var _l_num=obj2[i].getElementsByClassName('ifdo_product_num')[0].textContent;
								if(_l_name!=''&&_l_price!=''&&_l_num!=''){
									if( typeof _NB_plist[_l_name] == 'undefined'){
										var _t_obj = {};
										_t_obj['PN'] = _l_name;
										_t_obj['PC'] = _l_pc;
										_t_obj['PR'] = parseInt(_l_price.replace(/[^0-9]/gi,''));
										_t_obj['AM'] = parseInt(_l_num.replace(/[^0-9]/gi,''));
										_t_obj['CT'] = '';
										_NB_LO.push(_t_obj);
										_NB_plist[_l_name] = _l_name;
									}
								}
							}
						}
					}
					var _NB_PM = 'u';/*장바구니 구분값*/	
				</script>
				<!-- End Script for IFDO -->
			";

			$cart_html = $cart_list_html.$cart_base_html;
			$this->script['cart_view'] = $cart_html;
		}
		
		return $this->script['cart_view'];
	}
	// 5-1. 장바구니 추가 이벤트
	// 해당 이벤트는 클릭시 동작해야하므로 별도로 바인딩하여 처리
	function cart_in($goods = array()){
		$script = "";
		
		// ifdo 출력 조건
		if($goods && $this->check_base_validation()){
			$script = "
				<!-- Start Script for IFDO (장바구니 클릭 분석) -->
				<script>
					$(document).ready(function(){
						$('#addCart').on('click', function() {
							if( check_option() ) {
								if(typeof _NB_CART_IN=='function'){
								
									var obj_goods_ea = $(\"input[name*='optionEa']\");
									obj_goods_ea.each(function(){
										var catagory_name = '';
										var goods_seq = '".$goods['goods_seq']."';
										var goods_name = '".$goods['goods_name']."';
										var goods_ea = $(this).val();
										var goods_price = '".$goods['price']."';
										_NB_CART_IN(catagory_name,goods_seq,goods_name,goods_ea,goods_price);
									});
									
								}
							}
						});
					});
				</script>
				<!-- End Script for IFDO -->
			";
		}
		
		return $script;
	}
	
	// 6. 구매 분석 
	function purchase($shipping_group_items = array(), $orders = array()){
		$this->script['purchase'] = '';
		
		// ifdo 출력 조건
		if($this->check_base_validation()){
			// 구매 분석 수집 목록 구성
			$purchase_list_html = "";
			$purchase_list_html .= "
				<!-- Start Script for IFDO (구매분석) -->
				<div module='Order_result' style='display:none;'>
			";

			if($orders['member_seq']){
				$purchase_list_html .= "
					<div id='ifdo_order_id'>".$orders['order_seq']."</div>
					<div id='ifdo_order_amount'>".$orders['settleprice']."</div>
				";
			}
			$purchase_list_html .= "
					<div class='orderListArea'>
						<table summary>
						<tbody module='Order_normalresultlist' class='center middle' id='ifdo_order_list'>
			";

			foreach($shipping_group_items as $shipping_group){
				foreach($shipping_group['items'] as $item){
					foreach($item['options'] as $option){
					$purchase_list_html .= "
						<tr class='ifdo_order_ul'>
							<td class='ifdo_product_name'>".$item['goods_name']."</td>
							<td class='ifdo_product_no'>".$item['goods_seq']."</td>
							<td class='ifdo_product_cate'></td>
							<td class='ifdo_product_price'>".$option['tot_sale_price']."</td>
							<td class='ifdo_product_num'>".$option['ea']."</td>
						</tr>
					";
					}
				}
			}

			$purchase_list_html .= "
						</tbody>
						</table>
					</div>
				</div>
				<!-- IFDO 구매 분석 목록 구성 종료 -->
			";

			// 구매분석 수집 기본 스크립트
			$purchase_base_html = "
				<script type='text/javascript'>
					var _NB_LO = [];
					var _NB_plist =[];
					//var _NB_LO = [{'PN':'','CT':'','AM':'0','PR':'2000'}]; 
					var obj = document.getElementById('ifdo_order_list');
					if( obj != null ){
						var obj2 = obj.getElementsByClassName('ifdo_order_ul');
						var len = obj2.length;
						if( len > 0 ){
							for(var i=0;i<len;i++){
								var _l_name=obj2[i].getElementsByClassName('ifdo_product_name')[0].textContent;
								var _l_price=obj2[i].getElementsByClassName('ifdo_product_price')[0].textContent;
								var _l_cate=obj2[i].getElementsByClassName('ifdo_product_cate')[0].textContent;
								var _l_pc=obj2[i].getElementsByClassName('ifdo_product_no')[0].textContent;
								var _l_num=obj2[i].getElementsByClassName('ifdo_product_num')[0].textContent;
								if(_l_name!=''&&_l_price!=''&&_l_num!=''){
									if( typeof _NB_plist[_l_name] == 'undefined'){
										var _t_obj = {};
										_t_obj['PN'] = _l_name;
										_t_obj['PC'] = _l_pc;
										_t_obj['PR'] = parseInt(_l_price.replace(/[^0-9]/gi,''));
										_t_obj['AM'] = parseInt(_l_num.replace(/[^0-9]/gi,''));
										_t_obj['CT'] = '';
										_NB_LO.push(_t_obj);
										_NB_plist[_l_name] = _l_name;
									}
								}
							}
						}
					}
					if( document.getElementById('ifdo_order_id') ) var _NB_ORD_NO =document.getElementById('ifdo_order_id').textContent;
					if( document.getElementById('ifdo_order_amount') ) var _NB_ORD_AMT =parseInt(document.getElementById('ifdo_order_amount').textContent);
					var _NB_PM = 'b';/*구매완료 구분값*/
				</script>
				<!-- End Script for IFDO -->
			";

			$purchase_html = $purchase_list_html.$purchase_base_html;
			$this->script['purchase'] = $purchase_html;
		}
		
		return $this->script['purchase'];
	}
	
	//7. 내부검색 분석
	function search($params = array(), $totalcount = '0'){
		$this->script['search'] = '';
		
		if($totalcount == ''){
			$totalcount = '0';
		}
		
		// ifdo 출력 조건
		if(($params['page'] == '1' || $params['page'] == '') && $this->check_base_validation()){
			
			$search_text = $params['search_text'];
			if($params['osearchtext']){
				$search_text = $params['osearchtext'];
			}
			
			// 내부검색 분석 수집 목록 구성
			$search_html = "";
			$search_html .= "
				<!-- Start Script for IFDO (내부검색 분석) -->
			";

			$search_html .= "
			<div module='search_form' style='display:none;'>
				<div class='searchResult'>
					<div id='ifdo_search_keyword'>".$search_text."</div>
					<div id='ifdo_search_count'>".$totalcount."</div>
				</div>
			</div>
			";

				
			// 내부검색 수집 기본 스크립트
			$search_html .= "
				<script type='text/javascript'>
				var _NB_kwd = ''; /* 내부검색어*/
				var _NB_AMT = ''; /* 내부검색 결과수 */
				if( document.getElementById('ifdo_search_keyword') ){
					_NB_kwd =document.getElementById('ifdo_search_keyword').textContent;
				}
				if( document.getElementById('ifdo_search_count') ) _NB_AMT =parseInt(document.getElementById('ifdo_search_count').textContent);
				</script>
				<!-- End Script for IFDO -->
			";

			$this->script['search'] = $search_html;
		}
		
		return $this->script['search'];
	}
	
	// 8. 위시리스트 분석
	function wish_view($record = array()){
		$this->script['wish_view'] = '';
		
		// ifdo 출력 조건
		if($this->check_base_validation()){
			// 위시리스트 수집 목록 구성
			$wish_list_html = "";
			$wish_list_html .= "
				<!-- IFDO 위시리스트 분석 목록 구성 시작 -->
				<div id='Order_BasketPackage' style='display:none;'>
					<div class='orderListArea'>
						<table border='1' summary='' >
						<tbody class='center middle' id='ifdo_basket_list'>
			";

			foreach($record as $goods_info){
				$wish_list_html .= "
							<tr class='ifdo_basket_ul'>
								<td class='ifdo_product_name'>".$goods_info['goods_name']."</td>
								<td class='ifdo_product_no'>".$goods_info['goods_seq']."</td>
								<td class='ifdo_product_price'>".($goods_info['sale_price'])."</td>
								<td class='ifdo_product_cate'></td>
								<td class='ifdo_product_num'>1</td>
							</tr>
				";
			}

			$wish_list_html .= "
						</tbody>
						</table>
					</div>
				</div>
				<!-- IFDO 위시리스트 분석 목록 구성 종료 -->
			";
			
			// 위시리스트 수집 기본 스크립트
			$wish_base_html = "
				<!-- Start Script for IFDO (위시리스트 분석) -->
				<script type='text/javascript'>
					var _NB_LO = [];
					var _NB_plist =[];
					var obj = document.getElementById('ifdo_basket_list');
					if( obj != null ){
						var obj2 = obj.getElementsByClassName('ifdo_basket_ul');
						var len = obj2.length;
						if( len > 0 ){
							for(var i=0;i<len;i++){
								var _l_name=obj2[i].getElementsByClassName('ifdo_product_name')[0].textContent;
								var _l_price=obj2[i].getElementsByClassName('ifdo_product_price')[0].textContent;
								var _l_cate=obj2[i].getElementsByClassName('ifdo_product_cate')[0].textContent;
								var _l_pc=obj2[i].getElementsByClassName('ifdo_product_no')[0].textContent;
								var _l_num=obj2[i].getElementsByClassName('ifdo_product_num')[0].textContent;
								if(_l_name!=''&&_l_price!=''&&_l_num!=''){
									if( typeof _NB_plist[_l_name] == 'undefined'){
										var _t_obj = {};
										_t_obj['PN'] = _l_name;
										_t_obj['PC'] = _l_pc;
										_t_obj['PR'] = parseInt(_l_price.replace(/[^0-9]/gi,''));
										_t_obj['AM'] = parseInt(_l_num.replace(/[^0-9]/gi,''));
										_t_obj['CT'] = '';
										_NB_LO.push(_t_obj);
										_NB_plist[_l_name] = _l_name;
									}
								}
							}
						}
					}
					var _NB_PM = 'w';/*위시리스트 구분값*/	
				</script>
				<!-- End Script for IFDO -->
			";

			$wish_html = $wish_list_html.$wish_base_html;
			$this->script['wish_view'] = $wish_html;
		}
		
		return $this->script['wish_view'];
	}
}
?>
