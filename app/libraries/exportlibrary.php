<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 출고와 관련된 소스들이 컨트롤러와 모델에 산재되어 있어 향후 병합을 위한 라이브러리 구조 
 * 2018-08-06
 * by hed 
 */
class ExportLibrary
{
	function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('order2exportmodel');
	}
	
	/**
	 * 출고 데이터 구성 by hed
	 * @param $post_params				입력 데이터
	 *				check_mode								체크 모드 | check : 체크모드
	 *				export_mode								출고 모드 | 기본 goods | order : 주문별, goods : 상품별
	 *				each_shipping_seq						개별 배송 고유키
	 *				each_item_option_seq					개별 아이템 옵션 고유키
	 *				each_shipping_method					개별 배송 타입 | direct_store : 매장수령, coupon : 티켓상품
	 *				export_date								출고일자
	 *				stockable								재고여부? 정확한 기능 파악 필요 | limit : ??
	 *				export_step								출고 상태 | 45 : 출고준비, 55: 출고완료, 65 : 배송중, 75 : 배송완료
	 *				ticket_stockable						티켓상품 재고여부? 정확한 기능 파악 필요 | limit : ??
	 *				ticket_step								티켓상품 출고 상태 | 45 : 출고준비, 55: 출고완료, 65 : 배송중, 75 : 배송완료
	 *				scm_wh									출고 창고 고유키
	 *				package_grouping_key					패키지 그룹핑 번호 | package-{(item_option_seq|item_suboption_seq)}
	 *				order_seq[shipping_seq]							각 배송 별 주문번호 | 배송 고유키 fm_order_shipping.shipping_seq
	 *				check_shipping_seq[shipping_seq]				출고 대상 배송 고유키
	 *				export_shipping_group[shipping_seq]				출고 배송 그룹 | fm_order_shipping.shipping_group
	 *				export_shipping_method[shipping_seq]			출고 배송 방법 | fm_order_shipping.shipping_method
	 *				export_shipping_set_name[shipping_seq]			출고 배송지명 | fm_order_shipping.shipping_set_name
	 *				delivery_company[shipping_seq]					택배회사
	 *				delivery_number[shipping_seq]					운송번호
	 *				export_store_scm_type[shipping_seq]				출고 SCM 연결 여부
	 *				export_address_seq[shipping_seq]				출고 대상 주소지 | fm_shipping_store.shipping_address_seq
	 *				optioninfo[shipping_seq][option|suboption][item_option_seq]				출고 옵션 정보 | {goods_seq}(option|suboption){option_seq}
	 *				whSupplyPrice[shipping_seq][option|suboption][item_option_seq]			출고 대상 창고의 공급가액 | supply_price
	 *				goodscode[shipping_seq][option|suboption][item_option_seq]				출고 대상 상품 코드 | goods_code
	 *				stock[shipping_seq][option|suboption][item_option_seq]					출고대상 창고의 재고 | 미매칭 포함
	 *				autoWh[shipping_seq][option|suboption][item_option_seq]					출고대상 자동 매칭 창고
	 *				request_ea[shipping_seq][option|suboption][item_option_seq]				출고 요청 갯수
	 *				shipping_goods_kind[shipping_seq][option|suboption][item_option_seq]	출고 요청 상품 타입 | OPT : 필수옵션, SUB : 추가옵션, COU : 티켓상품
	 * @return $export_param			리턴 데이터
	 */
	public function make_order_export($post_params){
		
		$result_param = $post_params;

		# 택배가 아닐경우 택배사 코드/송장번호 초기화 :: 2016-10-06 lwh
		foreach($post_params['export_shipping_method'] as $shipping_seq => $shipping_method){
			if(!in_array($shipping_method,array("delivery"))){
				$post_params['delivery_company'][$shipping_seq] = "";
				$post_params['delivery_number'][$shipping_seq] = "";
			}
		}

		if($post_params['each_shipping_seq']){
			$request_ea = $post_params['request_ea'][$post_params['each_shipping_seq']];

			// 패키지상품추가
			foreach($post_params['package_request_ea'][$post_params['each_shipping_seq']]['option'] as $item_option_seq => $data_package){
				$unit_request_ea = 0;
				foreach($data_package as $package_option_seq => $package_ea){
					$request_ea['option'][$item_option_seq] = $package_ea;
				}

			}
			foreach($post_params['package_request_ea'][$post_params['each_shipping_seq']]['suboption'] as $item_suboption_seq => $data_package){
				$unit_request_ea = 0;
				foreach($data_package as $package_suboption_seq => $package_ea){
					$request_ea['suboption'][$item_suboption_seq] = $package_ea;
				}

			}

			if($post_params['each_shipping_method'] == 'coupon'){
				foreach($request_ea['option'] as $option_key => $option_seq ){
					if($option_key != $post_params['each_item_option_seq']){
						unset($request_ea['option'][$option_key],$post_params['shipping_goods_kind'][$post_params['each_shipping_seq']]['option'][$option_key]);
					}
				}
			}
			unset($result_param['request_ea']);
			$result_param['request_ea'][$post_params['each_shipping_seq']] = $request_ea;
		}else{
			unset($result_param['request_ea']);
			foreach($post_params['check_shipping_seq'] as $check_shipping_group_seq){
				$request_ea = $post_params['request_ea'][$check_shipping_group_seq];

				// 패키지상품추가
				foreach($post_params['package_request_ea'][$check_shipping_group_seq]['option'] as $item_option_seq => $data_package){
					$unit_request_ea = 0;
					foreach($data_package as $package_option_seq => $package_ea){
						$unit_ea = $post_params['unit_ea']['option'][$item_option_seq][$package_option_seq];
						if(!$unit_request_ea) $unit_request_ea = $package_ea / $unit_ea;
						$request_ea['option'][$item_option_seq] = $unit_request_ea;
					}

			}
				foreach($post_params['package_request_ea'][$check_shipping_group_seq]['suboption'] as $item_suboption_seq => $data_package){
					$unit_request_ea = 0;
					foreach($data_package as $package_suboption_seq => $package_ea){
						$unit_ea = $post_params['unit_ea']['suboption'][$item_suboption_seq][$package_suboption_seq];
						if(!$unit_request_ea) $unit_request_ea = $package_ea / $unit_ea;
						$request_ea['suboption'][$item_suboption_seq] = $unit_request_ea;
					}

				}

				$result_param['request_ea'][$check_shipping_group_seq] = $request_ea;
			}
		}
		return $result_param;
	}
	
	/**
	 * 출고 처리 by hed
	 * @param $post_params				입력 데이터
	 *				check_mode								체크 모드 | check : 체크모드
	 *				export_mode								출고 모드 | 기본 goods | order : 주문별, goods : 상품별
	 *				each_shipping_seq						개별 배송 고유키
	 *				each_item_option_seq					개별 아이템 옵션 고유키
	 *				each_shipping_method					개별 배송 타입 | direct_store : 매장수령, coupon : 티켓상품
	 *				export_date								출고일자
	 *				stockable								재고여부? 정확한 기능 파악 필요 | limit : ??
	 *				export_step								출고 상태 | 45 : 출고준비, 55: 출고완료, 65 : 배송중, 75 : 배송완료
	 *				ticket_stockable						티켓상품 재고여부? 정확한 기능 파악 필요 | limit : ??
	 *				ticket_step								티켓상품 출고 상태 | 45 : 출고준비, 55: 출고완료, 65 : 배송중, 75 : 배송완료
	 *				order_seq[shipping_seq]					각 배송 별 주문번호 | 배송 고유키 fm_order_shipping.shipping_seq
	 *				check_shipping_seq[shipping_seq]		출고 대상 배송 고유키
	 *				scm_wh									출고 창고 고유키
	 *				package_grouping_key					패키지 그룹핑 번호 | package-{(item_option_seq|item_suboption_seq)}
	 *				export_shipping_group[shipping_seq]				출고 배송 그룹 | fm_order_shipping.shipping_group
	 *				export_shipping_method[shipping_seq]			출고 배송 방법 | fm_order_shipping.shipping_method
	 *				export_shipping_set_name[shipping_seq]			출고 배송지명 | fm_order_shipping.shipping_set_name
	 *				delivery_company[shipping_seq]					택배회사
	 *				delivery_number[shipping_seq]					운송번호
	 *				export_store_scm_type[shipping_seq]				출고 SCM 연결 여부
	 *				export_address_seq[shipping_seq]				출고 대상 주소지 | fm_shipping_store.shipping_address_seq
	 *				optioninfo[shipping_seq][option|suboption][item_option_seq]				출고 옵션 정보 | {goods_seq}(option|suboption){option_seq}
	 *				whSupplyPrice[shipping_seq][option|suboption][item_option_seq]			출고 대상 창고의 공급가액 | supply_price
	 *				goodscode[shipping_seq][option|suboption][item_option_seq]				출고 대상 상품 코드 | goods_code
	 *				stock[shipping_seq][option|suboption][item_option_seq]					출고대상 창고의 재고 | 미매칭 포함
	 *				autoWh[shipping_seq][option|suboption][item_option_seq]					출고대상 자동 매칭 창고
	 *				request_ea[shipping_seq][option|suboption][item_option_seq]				출고 요청 갯수
	 *				shipping_goods_kind[shipping_seq][option|suboption][item_option_seq]	출고 요청 상품 타입 | OPT : 필수옵션, SUB : 추가옵션, COU : 티켓상품
	 * @param array &$out				리턴 데이터
	 *		$orderItemList;								// 주문 상품 목록
	 */
	public function proc_order_export_exec($export_param, $excel_data='', $param_shipping='', &$out){

		/**
		* 대량출고처리를 위해 초기화 하며 검수시 주석처리하여 로그를 확인해 주세요.
		* $this->CI->db->queries $this->CI->db->query_times 초기화
		* @2016-12-06
		**/
		$dbqueriesunset = true;

		if	(!$this->CI->scm_cfg)	$this->CI->scm_cfg	= config_load('scm');
		if	($this->CI->scm_cfg['use'] == 'Y'){
			$cfg['scm_use']			= 'Y';
			$cfg['scm_wh']			= $export_param['scm_wh'];

			if	($export_param['optioninfo']) foreach($export_param['optioninfo'] as $k => $optioninfo){
				if	($optioninfo['option']) foreach($optioninfo['option'] as $option_seq => $optstr){
					$arr_scmoptioninfo[$k]['option'][$option_seq]['info']	= $optstr;
					$arr_scmoptioninfo[$k]['option'][$option_seq]['stock']	= $export_param['stock'][$k]['option'][$option_seq];
					$arr_scmoptioninfo[$k]['option'][$option_seq]['autowh']	= $export_param['autoWh'][$k]['option'][$option_seq];
					$arr_scmoptioninfo[$k]['option'][$option_seq]['code']	= $export_param['goodscode'][$k]['option'][$option_seq];
					$arr_scmoptioninfo[$k]['option'][$option_seq]['price']	= $export_param['whSupplyPrice'][$k]['option'][$option_seq];
				}
				if	($optioninfo['suboption']) foreach($optioninfo['suboption'] as $suboption_seq => $substr){
					$arr_scmoptioninfo[$k]['suboption'][$suboption_seq]['info']		= $substr;
					$arr_scmoptioninfo[$k]['suboption'][$suboption_seq]['stock']	= $export_param['stock'][$k]['suboption'][$suboption_seq];
					$arr_scmoptioninfo[$k]['suboption'][$suboption_seq]['autowh']	= $export_param['autoWh'][$k]['suboption'][$suboption_seq];
					$arr_scmoptioninfo[$k]['suboption'][$suboption_seq]['code']		= $export_param['goodscode'][$k]['suboption'][$suboption_seq];
					$arr_scmoptioninfo[$k]['suboption'][$suboption_seq]['price']	= $export_param['whSupplyPrice'][$k]['suboption'][$suboption_seq];
				}
			}
		}

		$cfg['wh_seq'] 				= $export_param['scm_wh'];
		$cfg['stockable'] 			= $export_param['stockable'];
		$cfg['step'] 				= $export_param['export_step'];
		$cfg['ticket_stockable'] 	= $export_param['ticket_stockable'];
		$cfg['ticket_step'] 		= $export_param['ticket_step'];
		$cfg['export_date'] 		= $export_param['export_date'];
		$cfg['bundle_mode'] 		= ($export_param['bundle_mode'] == 'bundle') ? 'bundle' : '';
		$cfg['not_connect_scm']		= $export_param['not_connect_scm'];	// 미연결창고 여부

		$arr_order_seq 				= $export_param['order_seq'];
		$arr_request_ea  			= $export_param['request_ea'];
		$arr_shipping_goods_kind	= $export_param['shipping_goods_kind'];
		$arr_delivery_company		= $export_param['delivery_company'];
		$arr_delivery_number		= $export_param['delivery_number'];
		$arr_npay_flag_release		= $export_param['npay_flag_release'];		//npay 보류 사유
		$arr_not_match_goods_order	= $export_param['not_match_goods_order'];	// 미매칭 출고 처리 여부

		// 배송 출고 데이터 추가 작업 :: 2016-10-06 lwh
		$arr_export_data['group']		= $export_param['export_shipping_group'];
		$arr_export_data['method']		= $export_param['export_shipping_method'];
		$arr_export_data['set_name']	= $export_param['export_shipping_set_name'];
		$arr_export_data['scm_type']	= $export_param['export_store_scm_type'];
		$arr_export_data['address_seq'] = $export_param['export_address_seq'];

		$tmp_export_error		= array();		//출고에러
		$tmp_export_error_msg	= array();		//출고에러메세지
		$tmp_export_request		= array();		//출고요청
		$tmp_export_success		= array();		//출고성공

		$params_order_export = array(
			'cfg'	=> $cfg,
			'arr_order_seq'	=> $arr_order_seq,
			'arr_request_ea'	=> $arr_request_ea,
			'arr_shipping_goods_kind'	=> $arr_shipping_goods_kind,
			'arr_delivery_company'	=> $arr_delivery_company,
			'arr_delivery_number'	=> $arr_delivery_number,
			'arr_export_data'	=> $arr_export_data,
			'param_shipping'	=> $param_shipping,
			'arr_scmoptioninfo'	=> $arr_scmoptioninfo,
			'arr_npay_flag_release'	=> $arr_npay_flag_release,
			'arr_not_match_goods_order'	=> $arr_not_match_goods_order
		);
		$result_check = $this->CI->order2exportmodel->order_export($params_order_export);
		
		# 실패
		if($result_check[1]){
			$out['result_check'] = $result_check[1];
			foreach($result_check[1] as $data){
				$tmp_export_error[$data['step']][$data['export_item_seq']]	= $data['order_seq']." : ".$data['msg'];
				$tmp_export_error_msg[$data['step']][]						= $data['msg'];
				$tmp_export_request[$data['step']][$data['shipping_seq']]	= true;
			}
			//출고 실패사유 노출
			if($tmp_export_error_msg[45]){
				$err_msg_45 = $tmp_export_error_msg[45][0];
				if(count($tmp_export_error_msg[45])>1){
					$err_msg_45 .= " 외 ".(count($tmp_export_error_msg[45])-1)."건";
				}
			}
			if($tmp_export_error_msg[55]){
				$err_msg_55 = $tmp_export_error_msg[55][0];
				if(count($tmp_export_error_msg[55])>1){
					$err_msg_55 .= " 외 ".(count($tmp_export_error_msg[55])-1)."건";
				}
			}
		}

		# 성공
		foreach($result_check[2] as $data){
			if( array_sum($data['items']['ea'] ) >0 ){
				$tmp_export_request[$data['status']][$data['shipping_seq']] = true;
				$tmp_export_success[$data['status']][$data['shipping_seq']] = true;
			}
		}

		if($export_param['check_mode'] == 'check' && $export_param['library_call_type'] != 'o2o'){
			//번들 배송인 경우 1건으로 처리
			$bundle_mode		= '';
			if($export_param['bundle_mode'] == 'bundle'){
				$bundle_mode	= 'bundle';

				$arrayKeys		= array_keys($tmp_export_success['55']);
				if($arrayKeys > 1){
					$tmp_array	= $tmp_export_success['55'][$arrayKeys[0]];
					unset($tmp_export_success['55']);
					$tmp_export_success['55'][$arrayKeys[0]]	= $tmp_array;
				}

				$arrayKeys		= array_keys($tmp_export_error['55']);
				if($arrayKeys > 1){
					$tmp_array	= $tmp_export_error['55'][$arrayKeys[0]];
					unset($tmp_export_error['55']);
					$tmp_export_error['55'][$arrayKeys[0]]	= $tmp_array;
				}


				$arrayKeys		= array_keys($tmp_export_success['45']);
				if($arrayKeys > 1){
					$tmp_array	= $tmp_export_success['45'][$arrayKeys[0]];
					unset($tmp_export_success['45']);
					$tmp_export_success['45'][$arrayKeys[0]]	= $tmp_array;
				}

				$arrayKeys		= array_keys($tmp_export_error['45']);
				if($arrayKeys > 1){
					$tmp_array	= $tmp_export_error['45'][$arrayKeys[0]];
					unset($tmp_export_error['45']);
					$tmp_export_error['45'][$arrayKeys[0]]	= $tmp_array;
				}
			}

			$msg_height = 220;

			$msg = "<span class=\'fx12 left \'><div class=\'ml25\'><strong>예상 처리 결과는 아래와 같습니다.</strong></div>";
			$msg .= "<div class=\'left mt10 ml25\'>▶ 출고준비 ".number_format(count($tmp_export_success['45']) + count($tmp_export_error['45']))."건 요청 → 성공 ".number_format(count($tmp_export_success['45']))."건";
			$msg .= " , 실패".number_format(count($tmp_export_error['45']))."건 예상</div>";

			//출고 실패사유 노출
			if($tmp_export_error_msg[45]){
				$msg .= "<div class=\'left ml30\'><span class=\'red\'>┖ 실패사유 : ".$err_msg_45."</span></div>";
				$msg_height += 30;
			}

			$msg .= "<div class=\'left ml25 mt5\'>▶ 출고완료  ".number_format(count($tmp_export_success['55'])+count($tmp_export_error['55']))."건 요청 → 성공 ".number_format(count($tmp_export_success['55']))."건";
			$msg .= " , 실패".number_format(count($tmp_export_error['55']))."건 예상</div>";

			if	($this->CI->scm_cfg['use'] == 'Y'){
				$msg .= "※출고완료 시 {$this->CI->scm_cfg['use_warehouse'][$export_param['scm_wh']]}의 재고가 차감됩니다.";
			}
			$msg .= "<br/>";

			//출고 실패사유 노출
			if($tmp_export_error_msg[55]){
				$msg .= "<div class=\'left ml30\'><span class=\'red\'>┖ 실패사유 : ".$err_msg_55."</span></div>";
				$msg_height += 30;
			}
			$msg .= "</span><br/>";

			if($export_param['input_mode'] == 'excel'){
				echo("
				<script>
					parent.loadingStop();
					var params = {'yesMsg':'[예] 출고처리 실행','noMsg':'[아니오] 출고처리 취소'}
					parent.openDialogConfirm('".nl2br($msg)."',500,200,function(){
						parent.upload_excel();
					},function(){},params);
				</script>
				");
			}else{
				echo("
				<script>
					parent.loadingStop();
					var params = {'yesMsg':'[예] 출고처리 실행','noMsg':'[아니오] 출고처리 취소'}
					parent.openDialogConfirm('".nl2br($msg)."',500,".$msg_height.",function(){
						parent.batch_export('{$bundle_mode}');
					},function(){},params);
				</script>
				");
			}
			// 예상 결과보기 종료시에도 출고 처리 완료로 바꿈 by hed
			$this->update_order_receive('end');
			exit;
		}

		// 출고 중복실행방지 2019-01-15 s
		$order_receive_status = $this->select_order_receive();
		if( $order_receive_status == 'ing' && $export_param['library_call_type'] != 'o2o'){
			echo('
				<script>
					parent.loadingStop();
					alert("현재 다른 관리자가 출고 진행중입니다.\n잠시 후 다시 출고진행해주세요.");
				</script>
				');
			exit;
		}
		$this->update_order_receive('ing');
		// 출고 중복실행방지 2019-01-15 e

		if($dbqueriesunset) {// 대량출고처리를 위해 디버그용쿼리 초기화 @2016-12-08
			$this->CI->db->queries = array();
			$this->CI->db->query_times = array();
		}

		// 에러로그저장
		$this->CI->load->model('exportlogmodel');

		$export_type = 'goods';
		if($export_param['export_mode'] == 'order') $export_type = 'order';

		if($export_param['input_mode'] == 'excel'){
			$export_type = "excel_" . $export_type;
		}else{
			$export_type = "web_" . $export_type;
		}

		if($result_check[1]){
			foreach($result_check[1] as $data_error){
				$goods_kind = 'goods';
				if( preg_match('/COU/',$data_error['export_item_seq']) ) $goods_kind = 'coupon';

				if( $goods_kind == 'goods' ){
					$stockable	= $export_param['stockable'];
					$step		= $export_param['export_step'];
				}else{
					$stockable	= $export_param['ticket_stockable'];
					$step		= $export_param['ticket_step'];
				}
				$this->CI->exportlogmodel->export_log($stockable,$step,$export_type,$goods_kind,$data_error);
			}

			//출고 실패사유 노출(npay) @2016-01-27 pjm
			//if($err_msg_45) $export_error_msg = "출고준비 ".$err_msg_45;
			//if($err_msg_55) $export_error_msg .= "출고완료 ".$err_msg_55;

		}
		// 엑셀 출고 처리 결과 조합
		if( $excel_data ){
			$i = 0;
			$last_field_num = count($excel_data[0]);
			foreach($excel_data[0] as $title){
				if($title == '*출고상품번호'){
					$export_item_seq_title_num = $i;
				}
				if( $title == '*출고그룹' ){
					$shipping_seq_title_num = $i;
				}
				$i++;
			}
			foreach($excel_data as $excel_row_key => $excel_row){
				$excel_data[$excel_row_key][$last_field_num] = "성공";
				if( !$excel_row[$export_item_seq_title_num] && $excel_row[$shipping_seq_title_num] == $error['shipping_seq'] ){
					unset($excel_data[$excel_row_key]);
					continue;
				}
				foreach($result_check[1] as $error){
					if( $excel_row[$export_item_seq_title_num] ){
						list($opttype,$shipping_seq,$opt_seq) = $this->CI->excelmodel->get_info_by_export_item_seq( $excel_row[$export_item_seq_title_num]);
						if( $shipping_seq == $error['shipping_seq']){
							$excel_data[$excel_row_key][$last_field_num] = $error['msg'];
						}
					}else if($excel_row[$shipping_seq_title_num] == $error['shipping_seq']){
						$excel_data[$excel_row_key][$last_field_num] = $error['msg'];
					}
				}
			}
			$excel_data[0][$last_field_num] = "결과";

			// 처리결과 임시테이블에 저장
			$this->CI->load->model('exceltempmodel');
			$export_temp_seq = $this->CI->exceltempmodel->excel_temp_insert($excel_data);
		}
		# ----------------------------------------------------------------------------------------
		# 출고처리
		$export_params = $result_check[2];
		$tmp_export_error_msg = array();
		if( $export_params ){
			$result_export= $this->CI->order2exportmodel->goods_export($export_params,$cfg);

			foreach($result_export as $goods_kind=>$result_export1){
				foreach($result_export1 as $export_status => $result_export2){
					foreach($result_export2 as $export_item_seq => $result_export3){
						$result_export4 = explode('<br/>',$result_export3['export_code']);
						foreach( $result_export4 as $tmp_explode_code ){
							if($tmp_explode_code == "ERROR"){
								$tmp_export_error[$export_status][$export_item_seq] = $result_export3['message'];
							}else{
								$arr_explode_code[$goods_kind][$export_status][ $tmp_explode_code ] = $tmp_explode_code;
								$arr_explode_code_all[ $tmp_explode_code ]							= $tmp_explode_code;
							}
						}
					}
				}
			}
		}

		$cnt_export_result_goods_45		= (int) count($arr_explode_code['goods']['45']);	 // 실물 출고준비 갯수
		$cnt_export_result_goods_55		= (int) count($arr_explode_code['goods']['55']);	 // 실물 출고완료 갯수
		$cnt_export_result_coupon_55	= (int) count($arr_explode_code['coupon']['55']);	 // 쿠폰 출고완료 갯수

		$cnt_export_result_goods		= $cnt_export_result_goods_45 + $cnt_export_result_goods_55;
		$cnt_export_result_coupon		= $cnt_export_result_coupon_45 + $cnt_export_result_coupon_55;

		$cnt_export_result_coupon_55	= $cnt_export_result_coupon_55; // 쿠폰 출고완료 갯수
		$cnt_export_request_45			= (int) count($tmp_export_error['45'])
											+ $cnt_export_result_goods_45;
		$cnt_export_request_55			= (int) count($tmp_export_error['55'])
											+ $cnt_export_result_coupon_55
											+ $cnt_export_result_goods_55
											+ (int) $result_export_error_cnt;
		$cnt_export_error_45			= (int) count($tmp_export_error['45']);
		$cnt_export_error_55			= (int) count($tmp_export_error['55']) + (int) $result_export_error_cnt;

		if(count($tmp_export_error['45']) > 0){
			$export_error_msg = implode("<br />",$tmp_export_error['45']);
		}
		if(count($tmp_export_error['55']) > 0){
			$export_error_msg = implode("<br />",$tmp_export_error['55']);
		}

		$msg = "처리 결과는 아래와 같습니다.";
		$msg .= "<br/>출고준비 ".number_format($cnt_export_request_45)."건 요청 → 성공 ".number_format($cnt_export_result_goods_45)."건";
		$msg .= " ,실패".number_format($cnt_export_error_45)."건";
		$msg .= "<br/>출고완료 ".number_format($cnt_export_request_55)."건 요청 → 성공 ".number_format($cnt_export_result_coupon_55+$cnt_export_result_goods_55)."건";
		$msg .= " ,실패".number_format($cnt_export_error_55)."건";

		$result_obj = "{";
		$result_obj .= "'cnt_export_request_45':".$cnt_export_request_45;
		$result_obj .= ",'cnt_export_result_goods_45':".$cnt_export_result_goods_45;
		$result_obj .= ",'cnt_export_error_45':".$cnt_export_error_45;
		$result_obj .= ",'cnt_export_request_55':".$cnt_export_request_55;
		$result_obj .= ",'cnt_export_result_coupon_55':".$cnt_export_result_coupon_55;
		$result_obj .= ",'cnt_export_result_goods_55':".$cnt_export_result_goods_55;
		$result_obj .= ",'cnt_export_error_55':".$cnt_export_error_55;
		$result_obj .= ",'exist_invoice':".$this->CI->order2exportmodel->exist_invoice;
		$result_obj .= ",'export_result_error_msg':'".urlencode($export_error_msg)."'";
		$result_obj .= "}";

		if($arr_explode_code_all){
			$str_goods_export_code = implode('|',$arr_explode_code_all); // 실물출고코드합치기
		}

		if($cnt_export_result_goods_45 >0){
			// 출고준비->출고완료 출고 상태 변경 창로드
			$callback = "parent.batch_status_popup(45,'".$str_goods_export_code."',".$cnt_export_result_coupon_55.",".$result_obj.",'".$cfg['bundle_mode']."');";
		}else{
			// 인쇄용창 로드
			$callback = "parent.batch_status_popup(55,'".$str_goods_export_code."',".$cnt_export_result_coupon_55.",".$result_obj.",'".$cfg['bundle_mode']."');";
		}
		if($export_param['input_mode'] != 'excel'){
			$callback = "parent.close_export_popup();".$callback;
		}

		if($dbqueriesunset) {// 대량출고처리를 위해 디버그용쿼리 초기화 @2016-12-08
			$this->CI->db->queries = array();
			$this->CI->db->query_times = array();
		}

		// 물류관리 매장 재고 전송
		if	($this->CI->scm_cfg['use'] == 'Y'){
			$this->CI->load->model('scmmodel');
			if	($this->CI->scmmodel->tmp_scm['wh_seq'] > 0){
				$sendResult		= $this->CI->scmmodel->change_store_stock($this->CI->scmmodel->tmp_scm['goods'], array($this->CI->scmmodel->tmp_scm['wh_seq']), '');
			}
		}
		
		// 출고 중복실행방지 2019-01-15 s
		$this->update_order_receive('end'); 
		// 출고 중복실행방지 2019-01-15 e

		if($export_param['library_call_type'] != 'o2o'){
			// O2O 주문 자동 배송완료 처리
			$this->CI->load->library('o2o/o2oinitlibrary');
			$this->CI->o2oinitlibrary->init_admin_order_process_order_export_exec($export_param['order_seq'], $cfg['wh_seq']);		

			if	(!$sendResult['status']){
				if($export_param['bundle_mode'] == 'bundle'){
					echo "<script>".$callback."</script>";
				}else{
					echo "<script>".$callback."parent.window.opener.location.reload();</script>";
				}
			}
		}
		
		$out['sendResult']					=	$sendResult;
		$out['bundle_mode']					=	$export_param['bundle_mode'];
		$out['callback']					=	$callback;
		$out['cnt_export_error_45']			=	$cnt_export_error_45;
		$out['cnt_export_error_55']			=	$cnt_export_error_55;
	}
	
	
	/**
	 * 출고 쿼리 얻기 by hed
	 * @param $order_seq				주문번호 '|' 구분자
	 * @return $result					리턴 데이터
	 */
	public function get_order_export_query($order_seq){
		$this->CI->load->model('ordermodel');
		
		// 주문번호 검색
		if($order_seq){
			$where_order[] = "ord.order_seq in (".str_replace("|",",",$order_seq).")";
		}
		$query = $this->CI->ordermodel->get_order2export_list($where_order);
		return $query;
	}
	/**
	 * 출고 데이터 얻기 by hed
	 * @param $order_seq				입력 데이터
	 * @return $result					리턴 데이터
	 */
	public function get_order_export_data($order_seq, $warehouse=null){
		$this->CI->load->library('blockpage');
		
		$query = $this->get_order_export_query($order_seq);
		$bind[] = $order_seq;
		
		if(!$_GET['page']) $_GET['page'] = 1;
		$result_page = select_page(100,$_GET['page'],10,$query,$bind);
		
		$result = array();
		foreach($result_page['record'] as $data_order){
			$order_seq = $data_order['order_seq'];
			$result_data = array();
			$params = array(
							'order_seq'=>$order_seq,
							'provider_seq'=>$_GET['provider_seq'],
							'search_shipping_method'=>$_GET['search_shipping_method'],
							'base_inclusion'=>$_GET['base_inclusion'],
							'provider_seq_consignment'=>$provider_seq_consignment
			);
			if($warehouse){
				$params['warehouse'] = $warehouse;
			}
			$data = $this->CI->order2exportmodel->get_data_for_batch_export_item($params);

			// 주문 필터링
			foreach($data as $data_){
				if( $data_['shipping_seq'] == $data_order['shipping_seq']) {
					if( $data_order['coupon_option_seq']){
						if( $data_['options'][$data_order['coupon_option_seq']] ){
							$coupon_option = $data_['options'][$data_order['coupon_option_seq']];
							unset($data_['options']);
							$data_['options'][$data_order['coupon_option_seq']] = $coupon_option;
						}else{
							continue;
						}
					}

					$data_['shipping_set_code'] = $data_['shipping_method'];
					// NEW 배송정보 추출 :: 2016-09-22 lwh
					$shipping = $this->CI->ordermodel->get_order_shipping($order_seq,null,$data_order['shipping_seq']);
					if($shipping){
						$shipping_group_arr	= explode('_', $data_['shipping_group']);
						$data_['shipping_grp_seq']	= $shipping_group_arr[0];
						$data_['shipping_set_seq']	= $shipping_group_arr[1];
						$data_['shipping_set_code'] = ($shipping_group_arr[3]) ? $shipping_group_arr[2].'_'.$shipping_group_arr[3] : $shipping_group_arr[2];

						$ship_set_arr = $this->CI->shippingmodel->get_shipping_set($data_['shipping_grp_seq']);
						$data_['shipping_grp_info'] = $ship_set_arr;

						// 매장수령 정보 추출
						if($data_['shipping_set_code'] == 'direct_store'){
							$ship_store_arr = $this->CI->shippingmodel->get_shipping_store($data_['shipping_set_seq'],'shipping_set_seq');
							$data_['shipping_store_info'] = $ship_store_arr;
						}
					}
					$result_data[] = $data_;
				}
			}
			$data = $result_data;
			$result_order = $this->CI->ordermodel->get_order($order_seq);

			// 불필요 값 제거 작업
			if( $result_order['order_phone'] == '--' ) $result_order['order_phone'] = '';
			if( $result_order['order_cellphone'] == '--' ) $result_order['order_cellphone'] = '';
			if( $result_order['recipient_phone'] == '--' ) $result_order['recipient_phone'] = '';
			if( $result_order['recipient_cellphone'] == '--' ) $result_order['recipient_cellphone'] = '';

			// 받는정보
			foreach($data as $key_shipping => $data_shipping){

				$num++;

				// 공급사 배송 존재 여부
				if( $data_shipping['provider_seq']!=1 && $data_shipping['provider_seq'] ){
					$exist_provider = true;
				}

				if(! $data_provider_shipping_method[$data_shipping['provider_seq']] ){
					$data_provider_shipping_method[$data_shipping['provider_seq']] = $this->CI->providershipping->get_provider_shipping($data_shipping['provider_seq']);
				}

				$data[$key_shipping]['arr_shipping_method'] = $data_provider_shipping_method[$data_shipping['provider_seq']];

				$data[$key_shipping]['export_exist'] = false;
				foreach($data_shipping['options'] as $key_option => $data_option){

					# Npay 주문, 맞교환으로 인한 재주문건
					if($npay_use && $data_option['npay_product_order_id'] && $data_option['top_item_option_seq']){
						# 원주문건의 교환보류가 걸려있는지 확인
						$sql = "select
								ret.npay_flag,ret.return_code
							from
								fm_order_return_item as ret_item
								left join fm_order_return as ret on ret.return_code=ret_item.return_code
							where
								ret_item.option_seq=?
								and ret.order_seq=?
							";
						$query = $this->CI->db->query($sql,array($data_option['top_item_option_seq'],$data_shipping['orign_order_seq']));
						$ret_data = $query->row_array();
						if($ret_data['npay_flag']){
							if(array_key_exists(strtoupper($ret_data['npay_flag']),$npay_hold_reason)){
								$data[$key_shipping]['options'][$key_option]['exchange_return_code'] = $ret_data['return_code'];
								$data[$key_shipping]['options'][$key_option]['npay_flag_msg'] = $npay_hold_reason[strtoupper($ret_data['npay_flag'])];
							}
						}
					}

					if($data_option['export_ea']>0){
						$data[$key_shipping]['export_exist'] = true;
					}
					if( $data_option['request_ea'] > 0){ // 보낼수량
						$data[$key_shipping]['request_exist'] = true;
					}
					if( $data_option['stock'] === '미매칭' ){
						$data_option['nomatch']++;
						$data[$key_shipping]['miss_goods'] = true;
					}

					if($data_option['package_yn'] == 'y'){
						$data_option['packages'] = $this->CI->orderpackagemodel->get_option($data_option['item_option_seq']);
						$data[$key_shipping]['rowspan'] += count($data_option['packages']);
						foreach($data_option['packages'] as $key=>$data_package){
							$stock			= (int) $data_package['stock'];
							$badstock		= (int) $data_package['badstock'];
							$reservation	= (int) $data_package['reservation'.$this->CI->cfg_order['ableStockStep']];
							$ablestock		= $stock - $badstock - $reservation;
							$data_option['packages'][$key]['ablestock'] = $ablestock;
							$data_option['packages'][$key]['goods_seq'] = $data_package['goods_seq'];

							if(!$data_package['option_seq']){
								$data_option['nomatch']++;
								$data_option['packages'][$key]['stock'] = "미매칭";
							}
						}
					}

					foreach($data_option['suboptions'] as $key_suboption => $data_suboption){
						if($data_suboption['export_ea']>0){
							$data[$key_shipping]['export_exist'] = true;
						}
						if( $data_suboption['request_ea'] > 0){
							$data[$key_shipping]['request_exist'] = true;
						}
						if( $data_suboption['stock'] === '미매칭' ){
							$data_option['nomatch']++;
							$data[$key_shipping]['miss_goods'] = true;
						}

						if($data_suboption['package_yn'] == 'y'){
							$data_suboption['packages'] = $this->CI->orderpackagemodel->get_suboption($data_suboption['item_suboption_seq']);
							$data[$key_shipping]['rowspan'] += count($data_suboption['packages']);
							foreach($data_suboption['packages'] as $key=>$data_package){
								$stock			= (int) $data_package['stock'];
								$badstock		= (int) $data_package['badstock'];
								$reservation	= (int) $data_package['reservation'.$this->CI->cfg_order['ableStockStep']];
								$ablestock		= $stock - $badstock - $reservation;
								$data_suboption['packages'][$key]['ablestock'] = $ablestock;
								$data_suboption['packages'][$key]['goods_seq'] = $data_package['goods_seq'];
							}
							$data_option['suboptions'][$key_suboption]['packages'] = $data_suboption['packages'];
							
							if(!$data_package['option_seq']){
								$data_option['nomatch']++;
								$data_suboption['packages'][$key]['stock'] = "미매칭";
							}
						}
					}
				}
				
				if($result_order['linkage_id'] == 'pos' && $data[$key_shipping]['miss_goods']){
					$data[$key_shipping]['request_exist'] = 'pos';
				}
				$data[$key_shipping]['options'][$key_option] = $data_option;

				$arr_recipient_info = array();
				if($result_order['recipient_address_type']=='street'){
					$arr_recipient_info[] = $result_order['recipient_address_street'];
					$arr_recipient_info[] = $result_order['recipient_address_detail'];
					$arr_recipient_info[] = $result_order['recipient_user_name'];
				}else{
					$arr_recipient_info[] = $result_order['recipient_address'];
					$arr_recipient_info[] = $result_order['recipient_address_detai'];
					$arr_recipient_info[] = $result_order['recipient_user_name'];
				}

				if($data_shipping['shipping_method']=='coupon'){
					$arr_recipient_info = array();
					$arr_recipient_info[] = $result_order['recipient_cellphone'];
					$arr_recipient_info[] = $result_order['recipient_user_name'];
					
					$exist_ticket = true;
				}else{
					$exist_goods = true;
				}

				if(preg_match( '/each/',$data_shipping['shipping_method'])){
					$data[$key_shipping]['shipping_method'] = str_replace("each_","",$data_shipping['shipping_method']);
				}

				$data[$key_shipping]['num'] = $num;
				$data[$key_shipping]['recipient_info'] = implode(' ',$arr_recipient_info);
				$data[$key_shipping]['provider_name'] = $this->CI->order2exportmodel->provider_data[$data_shipping['provider_seq']]['provider_name'];
			}

			// 회원정보
			$result_member = $this->CI->membermodel->get_member_data($result_order['member_seq']);

			if ($result_order['linkage_id'] == 'connector'){
				if(substr($result_order['linkage_mall_code'],0,3) == "API"){
					$result_order['linkage_mallname_text']	= $shopLinkermarketList[$result_order['linkage_mall_code']]['name'];
				}else{
					$result_order['linkage_mallname_text']	= $marketList[$result_order['linkage_mall_code']]['name'];
				}
			}elseif ($result_order['linkage_id'] == 'pos' && $o2oStoreList) {
				foreach($o2oStoreList as $o2oStore){
					if($o2oStore['o2o_store_seq'] == $result_order['linkage_mall_code']){
						$result_order['linkage_mallname_text']	= $o2oStore['pos_name'];
					}
				}
			}

			$result['order'][$result_order['order_seq']] = $result_order;
			if($result_member['member_seq'] ){
				$result['member'][$result_member['member_seq']] = $result_member;
			}
			
			$result['ordershipping'][] = $data;
		}
		
		return $result;
	}
	
	
	/**
	 * 출고 상태 변경 처리 by hed
	 * @param $post_params				입력 데이터
	 *				status									출고 상태 | 45 : 출고완료, 55 : 배송중, 65 : 배송완료
	 *				export_date								출고일자 | 기본값 date("Y-m-d")
	 *				stockable								재고여부? 정확한 기능 파악 필요 | limit : ??
	 *				scm_wh									출고창고
	 *				export_code								출고번호 | array()
	 *				shipping_provider_seq[export_code]		출고입점사 고유키
	 *				export_shipping_group[export_code]		출고 배송 그룹 고유키
	 *				export_shipping_method[export_code]		출고 배송 방법 | direct_store : 매장수령
	 *				export_shipping_set_name[export_code]	출고 배송명
	 *				delivery_company[export_code]			택배사코드
	 *				delivery_number[export_code]			운송번호
	 *				export_store_scm_type[export_code]		출고 SCM 연결 여부
	 *				export_address_seq[export_code]			출고 매장 수령 고유키
	 *				
	 * @param array &$out				리턴 데이터
	 *		$callback;								// 회신 데이터
	 *		$err_cnt;								// 에러건수
	 *		$req_cnt;								// 요청건수
	 */
	public function proc_order_batch_status($post_params, &$out){

		$this->CI->load->model('exportmodel');

		$cfg_order = config_load('order');
		$cfg_order['runout'] = 'unlimited';

		if($post_params['stockable']=='limit'){
			$cfg_order['runout'] = 'stock';
		}

		if($post_params['status'] == '45'){
			$mode			= "complete_export";
			$mode_from		= "출고준비";
			$mode_to		= "출고완료";
			$mode_to_status = 55;
		}else if($post_params['status'] == '55'){
			$mode			= "going_delivery";
			$mode_from		= "출고완료";
			$mode_to		= "배송중";
			$mode_to_status = 65;
		}else if($post_params['status'] == '65'){
			$mode			= "complete_delivery";
			$mode_from		= "배송중";
			$mode_to		= "배송완료";
			$mode_to_status = 75;
		}else{
			$mode			= "save";
		}

		if( $post_params['codes'] ){
			$post_params['export_code'] = explode('|',$post_params['codes']);
		}

		// 개별출고처리
		if( $post_params['each_export_code'] )
		{
			$post_params['export_code'] = array($post_params['each_export_code']);
		}

		if( $post_params['market_mode'] == 'y' ) {
			$post_params['export_code'] = explode('|',$post_params['err_codes']);
		}

		if($post_params['export_code']){
			$post_params['export_code'] = array_unique($post_params['export_code']);
		}

		$npay_export = array();
		foreach($post_params['export_code'] as $export_code)
		{

			$export_field	= (preg_match('/^B/', $export_code)) ? 'bundle_export_code' : 'export_code';

			$field = array();
			$bind = array();

			//출구완료시에만 출고일 업데이트합니다. @2016-07-29 ysm
			if ( $mode == "complete_export" ) {
				$field[] = "export_date = ?";
				$bind[] = ($post_params['export_date'])?$post_params['export_date']:date("Y-m-d");
			}

			if( $post_params['export_shipping_method'][$export_code] ){
				$field[] = "delivery_number = ?";
				$field[] = "delivery_company_code = ?";
				$field[] = "international = 'domestic'";
				$field[] = "domestic_shipping_method = ?";
				// 배송정보 추가분 :: 2016-10-10 lwh
				$field[] = "shipping_group = ?";
				$field[] = "shipping_method = ?";
				$field[] = "shipping_set_name = ?";
				$field[] = "store_scm_type = ?";
				$field[] = "shipping_address_seq = ?";

				$bind[] = $post_params['delivery_number'][$export_code];
				$bind[] = $post_params['delivery_company'][$export_code];
				$bind[] = $post_params['export_shipping_method'][$export_code];
				// 배송정보 추가분 :: 2016-10-10 lwh
				$bind[] = $post_params['export_shipping_group'][$export_code];
				$bind[] = $post_params['export_shipping_method'][$export_code];
				$bind[] = $post_params['export_shipping_set_name'][$export_code];
				$bind[] = $post_params['export_store_scm_type'][$export_code];
				$bind[] = $post_params['export_address_seq'][$export_code];
			}
			
			// 상태변경일시 업데이트 추가 @2017-02-09 nsg
			$field[] = "status_date = ?";
			$bind[] = date('Y-m-d H:i:s');

			$bind[] = $export_code;
			$query = "
			update fm_goods_export set ".implode(",",$field)." where {$export_field} = ?";
			$this->CI->db->query($query,$bind);

		}

		$result_msg			= '';
		$r_err_export_code	= array();
		foreach($post_params['export_code'] as $code){
			if( $mode != 'save' ){

				if( $mode == 'complete_export' ){
					$cfg_order['scm_wh']        = $post_params['scm_wh'];
					$err_export = $this->CI->exportmodel->exec_complete_export($code,$cfg_order);
					if(!$err_export['result'])
					{
						$r_err_export_code[] = $code;
						if(!$result_msg) $result_msg = $err_export['msg'];
					}
				}else if( $mode == 'going_delivery' ){
					$market_mode = isset($post_params['selectMarkets']) ? 'y' : ''; 
					$export_mode = ($post_params['market_mode'] == 'y') ? 'market' : ''; 
					$err_export = $this->CI->exportmodel->{'exec_'.$mode}($code, $export_mode);
					if(!$err_export['result'])
					{
						$r_err_export_code[] = $code;
						if(!$result_msg) $result_msg = $err_export['msg'];
					}
				}else{
					$this->CI->exportmodel->{'exec_'.$mode}($code);
				}
			}
		}

		if($mode == "complete_export") {
			/* 출고자동화 전송 (우체국택배 자동화 전송 포함시킴 : 2016-04-05 lwh)*/
			$this->CI->load->model('invoiceapimodel');
			$invoiceExportResult = $this->CI->invoiceapimodel->export($this->CI->exportCompleteCode);
		}

		if(count($this->CI->exportSmsData) > 0){
			commonSendSMS($this->CI->exportSmsData);
		}

		$err_cnt = count($r_err_export_code);
		$req_cnt = count($post_params['export_code']);

		if($result_msg) $result_msg = urlencode($result_msg);

		$msg = "처리 결과는 아래와 같습니다.";
		$msg .= "<br/>".$mode_to." ".number_format($req_cnt)."건 요청 → 성공 ".number_format($req_cnt - $err_cnt)."건";
		$msg .= " ,실패 ".number_format($err_cnt)."건";

		$result_obj = "{";
		$result_obj .= "'err_cnt':".$err_cnt;
		$result_obj .= ",'req_cnt':".$req_cnt;
		$result_obj .= ",'export_result_msg':'".$result_msg."'";
		$result_obj .= ",'market_mode':'".$market_mode."'";
		$result_obj .= ",'err_export_code':'".implode('|',$r_err_export_code)."'";
		$result_obj .= "}";

		if($post_params['export_code']){
			$str_goods_export_code = implode('|',$post_params['export_code']); // 실물출고코드합치기
		}

		$callback = "parent.close_export_popup();parent.batch_status_popup(".$mode_to_status.",'".$str_goods_export_code."',0,".$result_obj.");";

		/*
		if( $mode == 'save'){
			openDialogAlert("변경 정보가 저장 되었습니다.",400,140,'parent',"parent.location.reload();");
		}else{
			echo "<script>".$callback."parent.window.opener.location.reload();</script>";
		}
		*/
		$out['callback']					=	$callback;
		$out['err_cnt']						=	$err_cnt;
		$out['req_cnt']						=	$req_cnt;
	}
	
	/**
	 * 배송 데이터 얻기 by hed
	 * @param $params				입력 데이터
	 * @return $result					리턴 데이터
	 */
	public function get_order_batch_status_data($params){
		$this->CI->load->library('blockpage');
		$this->CI->load->model('exportmodel');
		$this->CI->load->helper('shipping');
		$this->CI->load->model('ordermodel');
		$this->CI->load->model('providermodel');
		$this->CI->load->model('goodsmodel');
		$this->CI->load->model('providershipping');
		$this->CI->load->model('orderpackagemodel');
		$this->CI->load->model('shippingmodel');
		
		if($params){
			list($query,$bind) = $this->CI->exportmodel->get_change_status_list($params);
			
			if(!$_GET['page']) $_GET['page'] = 1;
			$result_page = select_page(100,$_GET['page'],10,$query,$bind);
			$goodsflow_flag = false; // 굿스플로 일괄 처리 버튼 제어변수 :: 2016-10-10 lwh

			foreach($result_page['record'] as $data_export_code){

				$mode		= '';
				if($data_export_code['is_bundle_export'] == 'Y'){
					$mode	= 'bundle';
					$data_export_code['export_code']	= $data_export_code['bundle_export_code'];
				}
				

				$query = $this->CI->exportmodel->get_change_status_detail($data_export_code['export_code']);

				foreach($query->result_array() as $data){

					// 배송정보 기본 추출 :: 2016-10-10 lwh
					$shipping_group_arr	= explode('_', $data['shipping_group']);
					$data['shipping_grp_seq']	= $shipping_group_arr[0];
					$data['shipping_set_seq']	= $shipping_group_arr[1];
					$data['shipping_set_code'] = ($shipping_group_arr[3]) ? $shipping_group_arr[2].'_'.$shipping_group_arr[3] : $shipping_group_arr[2];

					// 배송출고지 추출 :: 2016-10-10 lwh
					$sql = "SELECT * FROM fm_shipping_grouping WHERE shipping_group_seq = ?";
					$grp_query	= $this->CI->db->query($sql,$data['shipping_grp_seq']);
					$grp_res	= $grp_query->row_array();
					$send_add = $this->CI->shippingmodel->get_shipping_address($grp_res['sendding_address_seq'], $grp_res['sendding_scm_type']);
					if($send_add['address_nation'] == 'korea'){
						$send_add['view_address'] = ($send_add['address_type'] == 'street') ? $send_add['address_street'] : $send_add['address'];
						$send_add['view_address'] = '(' . $send_add['address_zipcode'] . ') ' . $send_add['view_address'] . ' ' . $send_add['address_detail'];
					}else{
						$send_add['view_address'] = '(' . $send_add['international_postcode'] . ') ' . $send_add['international_country'] . ' ' . $send_add['international_town_city'] . ' ' . $send_add['international_county'] . ' ' . $send_add['international_address'];
					}
					$data['sending_address'] = $send_add;
					// $data['refund_address']		= $this->CI->shippingmodel->get_shipping_address($grp_res['refund_address_seq'], $grp_res['refund_scm_type']); // 일단 필요없음

					// 배송방법 예외처리 추가 :: 2016-10-10 lwh
					if(!$data['shipping_method']) $data['shipping_method'] = $data['domestic_shipping_method'];
					if(!$data['shipping_set_name']){
						$data['shipping_set_name'] = $this->CI->shippingmodel->shipping_method_arr[$data['shipping_method']];
					}

					// 굿스플로 일괄 처리 버튼 제어 :: 2016-10-10 lwh
					if($data['shipping_method'] == 'delivery' || $data['shipping_method'] == 'postpaid')	$goodsflow_flag = true;

					if($data_export_code['is_bundle_export'] == 'Y'){
						$data['export_code']		= $data['bundle_export_code'];
						$data['is_bundle_export']	= 'Y';
						$data['bundle_order_list']	= array_values(array_unique(explode(',',$data_export_code['has_order_list'])));
					}

					// 매장수령 정보 추출 :: 2016-10-10 lwh
					if($data['shipping_method'] == 'direct_store'){
						$ship_store_arr = $this->CI->shippingmodel->get_shipping_store($data['shipping_set_seq'],'shipping_set_seq');
						$data['shipping_store_info'] = $ship_store_arr;
					}

					if($data['option_seq']){
						$data_option_stock = $this->CI->goodsmodel->get_goods_option_stock($data['goods_seq'],$data['option1'],$data['option2'],$data['option3'],$data['option4'],$data['option5'],2);
						$data['stock'] = $data_option_stock[0];
						$goods_code = $data['opt_goods_code'];
						$data['goods_option_seq'] = $data_option_stock[1][0]['option_seq'];
					}

					if($data['suboption_seq']){
						$data['stock'] = $this->CI->goodsmodel->get_goods_suboption_stock($data['goods_seq'],$data['subtitle'],$data['suboption']);
						$goods_code = $data['subopt_goods_code'];
					}

					// opt_goods_code subopt_goods_code
					$data['bar_goods_code'] = $goods_code;
					if ( ! preg_match("/^[a-z0-9:_\/-]+$/i", $goods_code))
					{
						$data['bar_goods_code'] = "";
					}
					$data['bar_goods_code'] = $data['bar_goods_code'];

					if($data['inputs']){
						$arr_inputs = explode(',',$data['inputs']);
						foreach($arr_inputs as $str_input){
							$row_input = explode(':',$str_input);
							$data['subinputs'][] = array('type'=>$row_input[0],'title'=>$row_input[1],'value'=>$row_input[2]);
						}
					}

					$shipping_provider_seq = 1;
					if( $data['shipping_provider_seq'] ) $shipping_provider_seq = $data['shipping_provider_seq'];

					if(! $data_provider_shipping_method[$shipping_provider_seq] ){
						$data_provider_shipping_method[$shipping_provider_seq] = $this->CI->providershipping->get_provider_shipping($shipping_provider_seq);
					}

					$data['shipping'] = $data_provider_shipping_method[$shipping_provider_seq];

					if(!$delivery_company_array[$data['shipping_provider_seq']]){
						$delivery_company_array[$shipping_provider_seq] = get_shipping_company_provider($shipping_provider_seq);
					}
					$data['delivery_company_array'] = $delivery_company_array[$shipping_provider_seq];

					if($data['goods_kind'] == 'coupon'){
						$data['couponinfo'] = get_goods_coupon_view($data['export_code']);
						$log_params['export_code']	= $data['export_code'];
						$log_params['send_kind']	= 'mail';
						$data['mail_send_log'] = $this->CI->exportmodel->get_coupon_export_send_log($log_params, 2);
						$log_params['send_kind']	= 'sms';
						$data['sms_send_log'] = $this->CI->exportmodel->get_coupon_export_send_log($log_params, 2);
						$data['confirm_date'] = $this->CI->exportmodel->arr_status[$data['socialcp_confirm_date']];
						$data['coupon_use_value']	= $data['coupon_input'] - $data['coupon_remain_value'];
						$data['mstatus_arr'][0]		= $this->CI->exportmodel->arr_status[$data['status']];
						$data['mstatus_arr'][1]		= $this->CI->exportmodel->socialcp_status[$data['socialcp_status']][2] . $this->CI->exportmodel->socialcp_status[$data['socialcp_status']][0];
					}else{
						$exist_goods = true;
					}
					$data['mstatus'] = $this->CI->exportmodel->arr_status[$data['status']];
					$data['num'] = $data_export_code['_no'];

					//#23611 2019-02-07 ycg 주문 상태가 출고 상태에 포함된 경우 체크박스 선택되도록 수정
					$export_status = in_array($data['status'], array_keys($this->CI->exportmodel->arr_status));
					$export_status!=false?$data['export_status']='y':$data['export_status']='n';

					if( $data['package_yn'] == 'y' ){
						$data['packages'] = $this->CI->orderpackagemodel->get_option($data['option_seq']);
					}else if($data['subopt_package_yn'] == 'y'){
						$data['packages'] = $this->CI->orderpackagemodel->get_suboption($data['suboption_seq']);
					}

					if ($data['linkage_id'] == 'connector'){
						if(stripos($data['linkage_mall_code']) !== false){
							$data['linkage_mallname_text']	= $marketList[$data['linkage_mall_code']]['name'];
						}else{
							$data['linkage_mallname_text']	= $marketList[$data['linkage_mall_code']]['name'];
						}
					}
					//$data['linkage_mallname_text']	= $marketList[$data['linkage_mall_code']]['name'];

					$result[$data['export_code']][] = $data;
				}
			}
			
			$openmarketReturnOrder = 0;
			foreach($result as $export_code =>$data){
				foreach($data as $k=>$data_option){
					$data1[$export_code]++;
					if( !$result[$export_code][0]['tot_goods_name'] ){
						$result[$export_code][0]['tot_goods_name'] = $data_option['goods_name'];
						$result[$export_code][0]['tot_image'] = $data_option['image'];
					}
					$result[$export_code][0]['tot_stock'] += (int) $data_option['stock'];
					$result[$export_code][0]['tot_ea'] += (int) $data_option['opt_ea'] + (int) $data_option['subopt_ea'];
					$result[$export_code][0]['tot_step85'] += (int) $data_option['opt_step85'] + (int) $data_option['subopt_step85'];
					$result[$export_code][0]['tot_sended_ea'] += (int) $data_option['opt_step45'] + (int) $data_option['opt_step55']+ (int) $data_option['opt_step65']+ (int) $data_option['opt_step75'];
					$result[$export_code][0]['tot_sended_ea'] += (int) $data_option['subopt_step45'] + (int) $data_option['subopt_step55']+ (int) $data_option['subopt_step65']+ (int) $data_option['subopt_step75'];
					$result[$export_code][0]['tot_export_ea'] += (int) $data_option['ea'];
					$data1[$export_code] += count($data_option['packages']);
				}
				foreach($data as $k=>$data_option){
					$result[$export_code][$k]['rowspan'] = $data1[$export_code];
				}
				$result[$export_code][0]['tot_request_ea'] =  $result[$export_code]['tot_ea'] - $result[$export_code]['tot_sended_ea'] - $result[$export_code]['tot_step85'];

				/*20180322 오픈마켓 주문 중 반품일 경우 카운트 체크 $openmarketReturnOrder 추가 ldb*/
				if((strpos($result[$export_code][0]['linkage_mall_order_id'],'ex-') !== false)&&(is_array($_GET['selectMarkets']) === true)) {
					$openmarketReturnOrder += 1;
				}
				/*end*/
			}
		}
		
		return $result;
	}
	
	

	/* 출고 중복실행방지 현재 상태 체크 */
	function select_order_receive(){
		$filePath = ROOTPATH.'data/order_export_exec.txt';
		$fileContents = 'end';
		if(file_exists($filePath)) {
			
			$handle	= fopen($filePath, "r");
			$fileContents = fread($handle, filesize($filePath));
			fclose($handle);
			
			if( $fileContents == 'ing' ){
				$ftime = (time() - filemtime($filePath)) / 60;
				if( $ftime >= 5 ){
					$fileContents = 'end';
				}
			}
		}
		return $fileContents;
	}

	/* 출고 중복실행방지 상태 업데이트 */
	function update_order_receive($str)
	{
		$filePath = ROOTPATH.'data/order_export_exec.txt';
		$fp = fopen($filePath, 'w');
		fwrite($fp, $str);
		fclose($fp);
	}

	/**
	 * 마이페이지 출고 상세
	 */
	function export_view_front($order_seq) {

		$this->CI->load->library('buyconfirmlib');
		$this->CI->load->model('returnmodel');
		$this->CI->load->model('exportmodel');
		$this->CI->load->model('buyconfirmmodel');

		$exports = $this->CI->exportmodel->get_export_for_order($order_seq);
		foreach( $exports as $k => $data_export ){
			$export_cnt ++;
			$shipping_arr['international'] = $data_export['international'];
			if($data_export['international'] == 'domestic'){
				$shipping_arr['shipping_method'] = $shipping_arr['domestic_shipping_method'];
			}else{
				$shipping_arr['shipping_method_international'] = $shipping_arr['international_shipping_method'];
			}
			$data_export['out_shipping_method'] = $this->CI->ordermodel->get_delivery_method($orders);

			$data_export['item'] =  $this->CI->exportmodel->get_export_item($data_export['export_code']);
			$data_export['data_buy_confirm']		= $this->CI->buyconfirmmodel->get_log_buy_confirm($data_export['export_seq']);

			// 배송정보(매장수령의 경우)
			if($data_export['shipping_method'] == 'direct_store') {
				$shipping_direct_store = $this->CI->ordermodel->get_order_shipping($order_seq,null,$data_export['item']['shipping_seq']);
				$data_export['direct_store'] = $shipping_direct_store[$data_export['shipping_group']];
			}

			if($data_export['international_shipping_method']){
				$data_export['mdelivery'] = $data_export['international_shipping_method'];
				$data_export['mdelivery_number'] = $data_export['international_delivery_no'];
				$data_export['tracking_url'] = "#";
				if($data_export['international_shipping_method']!='ups'){
					$data_export['tracking_url'] = get_delivery_company(get_international_method_code(strtoupper($data_export['international_shipping_method'])),'url').$data_export['international_delivery_no'];
				}
			}

			if( !$data_export['mdelivery_number'] && $data_export['delivery_number'] ){
				$data_export['mdelivery'] = $data_export['delivery_company_array'][$data_export['delivery_company_code']]['company'];
				$data_export['mdelivery_number'] = $data_export['delivery_number'];
				$data_export['tracking_url'] = $data_export['delivery_company_array'][$data_export['delivery_company_code']]['url'].str_replace('-','',$data_export['delivery_number']);
			}

			if($data_export['buy_confirm'] != 'none') {
				$buy_confirm_cnt++;
			}

			foreach( $data_export['item'] as $i=>$data){

				// 티켓상품 출고일 경우
				if	($data['goods_kind'] == 'coupon'){
					$coupon_export[$data['export_code']]['coupon_serial']		= $data['coupon_serial'];
					$coupon_export[$data['export_code']]['coupon_st']			= $data['coupon_st'];
					$coupon_export[$data['export_code']]['recipient_email']		= $data['recipient_email'];
					$coupon_export[$data['export_code']]['recipient_cellphone']	= $data['recipient_cellphone'];
					$coupon_export[$data['export_code']]['mail_status']			= $data['mail_status'];
					$coupon_export[$data['export_code']]['sms_status']			= $data['sms_status'];
					$coupon_export[$data['export_code']]['coupon_value']		= $data['coupon_value'];
					$coupon_export[$data['export_code']]['coupon_value_type']	= $data['coupon_value_type'];
					$coupon_export[$data['export_code']]['coupon_remain_value']	= $data['coupon_remain_value'];

					$coupon_export[$data['export_code']]['couponinfo'] = get_goods_coupon_view($data['export_code']);

					$coupon_export[$data['export_code']]['coupon_check_use']	= $this->CI->exportmodel->chk_coupon(array('export_code' => $data_export['export_code']));

					$data_export['coupon_check_use']	= $coupon_export[$data['export_code']]['coupon_check_use'];
				}else{
					//출고별 마일리지 지급 예상 수량, 마일리지 지급수량
					$exports_tot[$data['export_code']]['reserve_ea']			+= $data['reserve_ea'];
					$exports_tot[$data['export_code']]['reserve_buyconfirm_ea']	+= $data['reserve_buyconfirm_ea'];
					if($data['goods_kind'] == "coupon") $exports_tot[$data['export_code']]['goods_coupon'] = true;
				}

				## 사은품
				$data['gift_title'] = "";
				if($data['goods_type'] == "gift"){
					$giftlog = $this->CI->giftmodel->get_gift_title($order_seq,$data['item_seq']);
					$data_export['item'][$i]['gift_title'] = $giftlog['gift_title'];
				}

				$it_s = $data['item_seq'];
				$it_ops = $data['option_seq'];

				if($data['opt_type']=='opt'){
					$return_item = $this->CI->returnmodel->get_return_item_ea($it_s,$it_ops,$data_export['export_code']);
				}
				if($data['opt_type']=='sub'){
					$return_item = $this->CI->returnmodel->get_return_subitem_ea($it_s,$it_ops,$data_export['export_code']);
				}

				$data_export['item'][$i]['inputs'] = $this->CI->ordermodel->get_input_for_option($data['item_seq'], $data['option_seq']);

				$data_export['item'][$i]['rt_ea']=$data['ea'] - $return_item['ea'];
				$data_export['rt_ea']+=$data_export['item'][$i]['rt_ea'];

				if($data_export['status'] == '45'){
					$data_export['item'][$i]['reserve_ea'] = 0;
				}
			}

			/* 반품신청 가능 기간 체크 @2016-11-17 */
			if($this->CI->cfg_order['buy_confirm_use']){
				// 구매확정 사용시 출고완료일 후 n일 내에만 반품신청 가능
				$order_return_edate = date('Ymd',strtotime('+'.$this->CI->cfg_order['save_term'].' day',strtotime($data_export['complete_date'])));

				$data_export['return_able_term'] = (date('Ymd')<=$order_return_edate)?1:0;
				$able_return_ea_ck += (date('Ymd')>$order_return_edate)?0:$data['ea'];

			}else{
				// 구매확정 미사용시 배송완료일 후 n일 내에만 반품신청 가능
				$order_return_sdate = date('Ymd',strtotime('+'.$this->CI->cfg_order['save_term'].' day',strtotime($data_export['shipping_date'])));
				$data_export['return_able_term'] = (date('Ymd')<=$order_return_sdate)?1:0;
				$able_return_ea_ck += ($data_export['shipping_date'] != '0000-00-00' && date('Ymd')>$order_return_sdate)?0:$data['ea'];
			}

			if(!serviceLimit('H_AD')) {
				unset($data_export['provider_name']);
			}

			// 구매 확정 버튼 활성화 여부 체크
			$buyconfirmInfo = $this->CI->buyconfirmlib->check_buyconfirm($data_export, $data_export['item']);
			$data_export['buyconfirmInfo'] = $buyconfirmInfo;

			$exports[$k] = $data_export;
		}

		return [
			'exports' => $exports,
			'exports_tot' => $exports_tot,
			'export_cnt' => $export_cnt,
			'buy_confirm_cnt' => $buy_confirm_cnt,
			'able_return_ea_ck' => $able_return_ea_ck,
		];
	}
}
?>