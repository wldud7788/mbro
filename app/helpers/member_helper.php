<?php

	/**
	* login/member/sns _process >>member session
	* @2014-01-21
	*/
	function create_member_session($data=array()){
		$CI =& get_instance();
		$data['rute'] = ($data['rute']!='f' && $data['sns_f'])?'facebook':$data['rute'];

		// 사업자 회원일 경우 업체명->이름
		if($data['business_seq']){
			$data['user_name'] = $data['bname'];
		}

		// 회원 이름명 OR 업체명 20자 제한
		$data['user_name'] = check_member_name($data['user_name']);

		if(!$data['password_update_date']){
			if($data['lastlogin_date']){
				$data['password_update_date'] = $data['lastlogin_date'];
			}else{
				$data['password_update_date'] = $data['regist_date'];
			}
		}


		$CI->load->model('couponmodel');
		$CI->load->helper('coupon');
		$sc['member_seq']	= $data['member_seq'];
		if( !empty($data['birthday']) && $data['birthday'] != '0000-00-00' ) {
			$data['thisyear_birthday'] = date("Y").substr($data['birthday'],4,6);
			if(checkdate(substr($data['thisyear_birthday'],5,2),substr($data['thisyear_birthday'],8,2),substr($data['thisyear_birthday'],0,4)) != true) {
				$data['thisyear_birthday'] = date("Y-m-d",strtotime('-1 day', strtotime($data['thisyear_birthday'])));
			}
			//한국나이
			$birthyear = date("Y", strtotime($data['birthday'])); //생년
			$nowyear = date("Y"); //현재년도
			$data['birthday_age'] = $nowyear-$birthyear+1;
		}

		if ( !empty($data['anniversary']) ) {
			$data['thisyear_anniversary'] = date("Y").'-'.$data['anniversary'];//기념일(mm-dd) 추가
			if(checkdate(substr($data['thisyear_anniversary'],5,2),substr($data['thisyear_anniversary'],8,2),substr($data['thisyear_anniversary'],0,4)) != true) {
				$data['thisyear_anniversary'] = date("Y-m-d",strtotime('-1 day', strtotime($data['thisyear_anniversary'])));
			}
		}

		$mb_group_sort = mb_group_sort();//회원등급순서 재정렬
		//등급조정쿠폰의 등업된 경우에만 다운가능
		if ($data['grade_update_date'] != '0000-00-00 00:00:00') {
			$fm_member_group_logsql = "select * from fm_member_group_log where member_seq = '".$data['member_seq']."' order by regist_date desc limit 0,1";
			$fm_member_group_logquery = $CI->db->query($fm_member_group_logsql);
			$fm_member_group_log =  $fm_member_group_logquery->row_array();
			if( ($mb_group_sort[$fm_member_group_log['prev_group_seq']] >= $mb_group_sort[$fm_member_group_log['chg_group_seq']]) || ($data['group_seq'] == 1) ) {
				$data['grade_update_date'] = '';
			}
		}else{
			$data['grade_update_date'] = substr($data['regist_date'],0,10);
		}

		if($data['birthday'] == '0000-00-00') $data['birthday'] ='';
		if($data['anniversary'] == '00-00') $data['anniversary'] ='';
		$sc['year']			= date('Y',time());
		$sc['month']		= date('Y-m',time());
		$sc['today']	= date('Y-m-d',time());
		$couponpopupuse = config_load('couponpopupuse');
		unset($couponpopup);
		if( $couponpopupuse['birthday_popup_use'] == 'Y' ) $couponpopup[] = "birthday";
		if( $couponpopupuse['anniversary_popup_use'] == 'Y' ) $couponpopup[] = "anniversary";
		//if( $couponpopupuse['membergroup_popup_use'] == 'Y' ) $couponpopup[] = "membergroup";
		if( $couponpopupuse['memberGroup_popup_use'] == 'Y' ) $couponpopup[] = "memberGroup";
		foreach($couponpopup as $coupontype) {
			if(!$coupontype)continue;
			unset($sc['coupon_type']);
			if( in_array($coupontype, array("memberGroup","membergroup")) ) {//배송비포함된 쿠폰
				$sc['coupon_type'][]		= $coupontype;
				$sc['coupon_type'][]		= $coupontype."_shipping";
			}else{
				$sc['coupon_type'][]		= $coupontype;
			}

			$coupondata = $CI->couponmodel->get_my_download($sc,$data,'totalcnt');
			$data['coupon_'.$coupontype.'_count'] = $coupondata['count'];
		}

        // 채널톡 프로필 연동 항목 추가 ( 보유한 쿠폰수 )
        $coupondata_unusedcount = $CI->couponmodel->get_download_have_total_count($sc, $data);

		// 채널톡 프로필 연동 항목 추가 ( 위시리스트 갯수 )
        $CI->load->model('wishmodel');
        $wish_count = $CI->wishmodel->get_wish_count($data['member_seq']);

		$member_data = array(
			'member_seq'			=> $data['member_seq'],
			'userid'				=> $data['userid'],
			'user_name'				=> $data['user_name'],
			'birthday'				=> $data['birthday'],
			'sex'					=> $data['sex'],
			'group_seq'				=> $data['group_seq'],
			'group_name'			=> $data['group_name'],
			'rute'					=> substr($data['rute'],0,1),
			'gnb_icon_view'			=> $data['gnb_icon_view'],
			'password_update_date'	=> $data['password_update_date'],
			'coupon_birthday_count'				=> $data['coupon_birthday_count'],
			'coupon_anniversary_count'		=> $data['coupon_anniversary_count'],
			'coupon_membergroup_count'		=> $data['coupon_memberGroup_count'],
			'member_type'			=> $data['mtype'],
			'cellphone'				=> $data['cellphone'],
			'email'				=> $data['email'],
            'mailing'           => $data['mailing'],
            'sms'               => $data['sms'],
            'emoney'            => $data['emoney'],
            'cash'              => $data['cash'],
            'member_order_price'    => $data['member_order_price'],
            'coupon'                => $coupondata_unusedcount['unusedcount'],
            'wish_count'            => $wish_count,
            'member_order_goods_cnt' => $data['member_order_goods_cnt'],
		);
		$tmp = config_load('member');
		if(isset($tmp['sessLimit']) && $tmp['sessLimit']=='Y'){
			$limit = 60 * $tmp['sessLimitMin'];
			$CI->session->sess_expiration = $limit;
		}
		$CI->session->set_userdata(array('user'=>$member_data));
	}

	//session update
	function couponsave_member_session($couponData){
		$CI =& get_instance();
		$sess_user = ( $CI->session->userdata('user') )?$CI->session->userdata('user'):$_SESSION['user'];
		//쿠폰새창노출시 쿠폰건수 차감
		if( in_array($couponData['type'],$CI->couponmodel->couponpagetype['mypage']) && $CI->userInfo['coupon_'.$couponData['type'].'_count'] ) {
			$sess_user['coupon_'.$couponData['type'].'_count'] = ($sess_user['coupon_'.$couponData['type'].'_count']==1)?0:($sess_user['coupon_'.$couponData['type'].'_count']-1);
			$CI->session->set_userdata('user',$sess_user);
		}
	}

	function memberIconConf($num=null) {
		$memberIcondata = array('default01.png','default02.png','default03.png','default04.png','default05.png','default06.png','default07.png','default08.png','default09.png','default10.png','default11.png','default12.png','default13.png','default14.png');
		return ($num)?$memberIcondata[$num-1]:$memberIcondata;
	}

	/**
	* 회원등급 정렬순서 재정의 @2016-05-17
	**Array
	(
		[1] => 1
		[4] => 2
		[2] => 3
		[3] => 4
	)
	**/
	function mb_group_sort() {
		$CI =& get_instance();
		$sql = "select * from fm_member_group order by order_sum_price asc, order_sum_cnt asc, sale_price asc";
		$query = $CI->db->query($sql);
		if($query->num_rows() < 1) return;
		foreach ($query->result_array() as $row){$sort_num++;
			$group_sort[$row['group_seq']] = $sort_num;
		}
		return $group_sort;
	}

	/**
	개인정보관련 통합약관
	DB배포 이후 구)필드, 신)필드 조건 구분
	쇼핑몰 이용약관								: agreement			: policy_agreement
	개인정보처리방침							: privacy			: policy_privacy
	[회원가입] 개인정보 수집 및 이용 (필수)		: policy			: policy_joinform
	[회원가입] 개인정보 수집 및 이용 (선택)		:					: policy_joinform_option
	[회원가입] 마케팅 및 광고 활용 동의			:					: policy_marketing
	[비회원 주문] 개인정보 수집 및 이용 		:					: policy_order
	[비회원 게시글 작성] 개인정보 수집 및 이용	:					: policy_board
	[비회원 댓글 작성] 개인정보 수집 및 이용	:					: policy_comment
	[재입고알림] 개인정보 수집 및 이용			:					: policy_restock
	청약철회 관련 방침							: cancellation		: policy_cancellation
	[주문] 개인정보 제3자 제공에 대한 동의 		: policy_third_party: policy_third_party
												:					: policy_third_party_normal
	[주문] 개인정보의 취급위탁에 대한 동의		:					: policy_delegation
	**/

	function chkPolicyInfo($mode = '', $codecd=array()){

		$CI			=& get_instance();
		if($CI->member){
			if($codecd){
				$_member = [];
				foreach($codecd as $_code){
					$_member[$_code] = $CI->member[$_code];
				}
				$CI->member = $_member;
			}
		}else {
			$CI->member = config_load('member', $codecd);
		}
		$arrOrder 	= ($CI->cfg_order) ? $CI->cfg_order : config_load('order');

		// 구)청약철회 관련 방침 데이터는 order config 에 있음.
		$data		= array_merge($CI->member, array('cancellation'=>$arrOrder['cancellation']));

		$policy_fields = [
						'policy_agreement' 			=> 'agreement',
						'policy_privacy'			=> 'privacy',
						'policy_joinform'			=> 'policy',
						'policy_cancellation'		=> 'cancellation',
						'policy_joinform_option'	=> '',
						'policy_marketing'			=> '',
						'policy_order'				=> '',
						'policy_board'				=> '',
						'policy_comment'			=> '',
						'policy_restock'			=> '',
						'policy_third_party'		=> '',
						'policy_third_party_normal'	=> '',
						'policy_delegation'			=> '',
		];

		if($data){
			// 통합약관 관련 DB패치 완료된 상태 일 때.
			if(trim($data['policy_update_date']) && $data['policy_update_date'] <= date("Y-m-d")){
				foreach($policy_fields as $new_field => $old_field){
					// 구)필드 데이터가 존재하면 구)데이터로 노출
					if(trim($old_field)){
						//debug($old_field);
						$data[$new_field] = $data[$old_field];
					}
				}
			}
		}


		// 관리자페이지 호출이 아닐때 치환코드 일괄 처리
		if($mode != 'admin') {
			$arrBasic	= $CI->config_basic;
			if($arrBasic) {
				$replace_params = [
									'shopName' 			=> $arrBasic['companyName'],
									'domain' 			=> $arrBasic['domain'],
									'책임자명'			=> $arrBasic['member_info_manager'],
									'책임자담당부서'	=> $arrBasic['member_info_part'],
									'책임자직급'		=> $arrBasic['member_info_rank'],
									'책임자연락처'		=> $arrBasic['member_info_tel'],
									'책임자이메일'		=> $arrBasic['member_info_email'],
								];

				foreach($policy_fields as $new_field => $old_field){
					// 구)필드 데이터 치환
					if(trim($data[$old_field])){
						foreach($replace_params as $_match_field => $_replace_data){
							$data[$old_field] = str_replace('{'.$_match_field.'}', $_replace_data, $data[$old_field]);
						}
					}

					// 신)필드 데이터 치환
					if(trim($data[$new_field])){
						foreach($replace_params as $_match_field => $_replace_data){
							$data[$new_field] = str_replace('{'.$_match_field.'}', $_replace_data, $data[$new_field]);
						}
					}
				}
			}
		}

		//$data['policy_check'] = $CI->member['policy_check'] = true;

		return $data;
	}

	/**
	 * 사용자앱 자동로그인
	 */
	function sendAutoLoginEvent($memberData) {
		$CI =& get_instance();
		// 앱 접근이 아닌경우 블락
		if ($CI->mobileapp != 'Y') return false;

		// 앱에 전송할 데이터 설정
		$CI->load->model('appmembermodel');
		$send_params = $CI->appmembermodel->config_send_params($memberData);

		// 호출 함수 생성
		$sendScript = "var param = {
								member_seq : ".$send_params['member_seq'].",
								user_id : '".$send_params['user_id']."',
								user_name : '".$send_params['user_name']."',
								session_id : '".session_id()."',
								channel : '".$send_params['channel']."',
								reserve : '".$send_params['reserve']."',
								balance : '".$send_params['balance']."',
								coupon : '".$send_params['coupon']."',
								auto_login : '".$send_params['y']."',
								api_key : '".$send_params['api_key']."'
						};
					var strParam = JSON.stringify(param);
					var dataStr = 'MemberInfo?' + strParam;";
		echo js($sendScript);

		// 디바이스에 따라 분기 처리
		if ($CI->m_device === 'iphone') {
			echo js('window.webkit.messageHandlers.CSharp.postMessage(dataStr);');
		} else {
			echo js('CSharp.postMessage(dataStr);');

		}
	}

// END
/* End of file member_helper.php */
/* Location: ./app/helpers/member_helper.php */