<?php
class Joincheckmodel extends CI_Model {
	function __construct() {
		parent::__construct();
		
		$this->stateNames = array(
		'before' 	=> '진행 전',
		'ing' 		=> '진행 중',
		'end'		=> '진행완료',
		'stop'		=> '중단'	
		);
				
		$this->typeNames = array(
		'stamp'		=> '스탬프형 ', 
		'comment'   => '댓글형',
		'login'		=> '로그인형'
		);
		$this->clear_typeNames = array(
		'count'		=> '횟수', 
		'straight'   => '연속'		
		);

		$this->clear_successNames = array(
		'Y'		=> '달성', 
		'N'   => '미달성'		
		);

	}

	//로그인시 체크이벤트 참여
	function login_joincheck($member_seq){
		$today = date('Y-m-d');

		//진행되는 이벤트 있는 확인
		$sql=$this->db->query("SELECT *
			FROM fm_joincheck as evt
		 	where check_state != 'stop' and check_type = 'login' and current_date() between start_date and end_date");
		$state = $sql->row_array();

		if( $state['joincheck_seq'] ){
			//출첵 이벤트
			$result = $this->joincheck($state['joincheck_seq'],$member_seq);
			if($result['code']=='success' || $result['code']=='emoney_pay'){
				 $lgn_check =$result;
			}else{
			 	$lgn_check = '';
			}
		} else{
			$lgn_check='';
		}
		return $lgn_check;
	}

	//출석체크 프로세서
	function joincheck($joincheck_seq,$member_seq,$comment=''){

		$params['member_seq']		=  $member_seq;		//회원
		$params['check_comment']	=  $comment;			//출석맨트
		$params['joincheck_seq']	=  $joincheck_seq;			//출석맨트

		$today = date('Y-m-d');
		$prev = date('Y-m-d',strtotime('-1 day',strtotime($today)));


		//진행중인지 확인
		$this->db->where('joincheck_seq', $joincheck_seq);
		$this->db->from('fm_joincheck');
		$this->db->select("if(check_state = 'stop','stop',
						if(current_date() between start_date and end_date,'ing',
						if(end_date < current_date(),'end','before'))) as status"
		);

		$sql = $this->db->get();
		$state = $sql->row_array();

		//진행중일때
		if($state['status']=='ing'){
			$query = $this->db->get_where('fm_joincheck',array('joincheck_seq'=>$joincheck_seq));
			$joincheck = $query -> row_array();
			$clear_type = $joincheck['check_clear_type'];

			$this->load->model('membermodel');
			$memberinfo = $this->membermodel->get_member_data($member_seq);

			//당일날 중복등록인지 확인하기
			$where=array('joincheck_seq'=>$joincheck_seq,'member_seq'=>$params['member_seq'],'check_date'=>$today);
			$qcheck = $this -> db -> get_where('fm_joincheck_list',$where);
			$recheck = $qcheck -> row_array();

			//중복이 아닐경우
			if(!$recheck){
				//결과값에 저장하기 위해서 데이터 가져오기
				$where = array('joincheck_seq'=>$joincheck_seq,'member_seq'=>$params['member_seq']);
				$query = $this->db->get_where('fm_joincheck_result',$where);
				$jccheck = $query -> row_array();

				$aldata = array(
				'member_seq' 		=> $params['member_seq'],
				'joincheck_seq'		=> $params['joincheck_seq']
				);

				//기존 결과값 수정
				if($jccheck){

					// 달성타입이 연속 출석인지 확인
					if($clear_type=='straight'){

						$where=array('joincheck_seq'=>$joincheck_seq,'member_seq'=>$params['member_seq'],'check_date'=>$prev);
						$query = $this -> db -> get_where('fm_joincheck_list',$where);
						$jrcst = $query -> row_array();
						//연속 타입이고 전날 체크했을 경우
						if($jrcst){
							$aldata['straight_cnt'] = $jccheck['straight_cnt'] + 1;
						}else{
							$aldata['straight_cnt'] = 1;
						}
						$aldata['count_cnt'] = $jccheck['count_cnt'] + 1;

						//목표달성여부체크
						if( ($joincheck['check_clear_count'] == $aldata['straight_cnt']) ||  ($aldata['straight_cnt']%$joincheck['check_clear_count']) == 0 ) {
							$aldata['clear_success'] = 'Y';
							$aldata['clear_suc_date'] = date('Y-m-d H:i:s');
							//목표 달성시 적립 지급
							if( ( $joincheck['check_clear_count'] == $aldata['straight_cnt'] ) || 
								( $joincheck['check_clear_count'] < $aldata['straight_cnt'] )
							)
							{
								/***
								$upsql = "update fm_member set emoney = emoney+".$joincheck['emoney']." where member_seq = ".$params['member_seq'];
								$upqry = $this->db->query($upsql);
								if($upqry){
								***/
								if( $joincheck['emoney'] > 0 || $joincheck['point'] > 0 ) {
									$aldata['emoney_pay']='Y';
									$aldata['emoney_pay_date']=date('Y-m-d H:i:s');
									$aldata['emoney']=$joincheck['emoney'];

									$type				= 'joincheck';
									$memo				= '출석체크 이벤트';
									$memo_lang			= $this->membermodel->make_json_for_getAlert("mp283");    // 출석체크 이벤트
									
									### EMONEY
									$limit_date_emoney = "";
									if($joincheck['reserve_select']=='year'){
										$limit_date_emoney = date("Y-m-d", mktime(0,0,0,12, 31, date("Y")+$joincheck['reserve_year']));//$joincheck['reserve_year']."-12-31";
									}else if($joincheck['reserve_select']=='direct'){
										$limit_date_emoney = date("Y-m-d", mktime(0,0,0,date("m")+$joincheck['reserve_direct'], date("d"), date("Y")));
									}
									if($joincheck['emoney'] > 0 ) {
										$emoney['type']             = $type;
										$emoney['emoney']           = $joincheck['emoney'];
										$emoney['gb']               = 'plus';
										$emoney['memo']             = $memo;
										$emoney['memo_lang']        = $memo_lang;
										$emoney['limit_date']       = $limit_date_emoney;
										$this->membermodel->emoney_insert($emoney, $params['member_seq']);
									}

									### POINT
									$limit_date_point = "";
									if($joincheck['point_select']=='year'){
										$limit_date_point = date("Y-m-d", mktime(0,0,0,12, 31, date("Y")+$joincheck['point_year']));//$joincheck['point_year']."-12-31";
									}else if($joincheck['point_select']=='direct'){
										$limit_date_point = date("Y-m-d", mktime(0,0,0,date("m")+$joincheck['point_direct'], date("d"), date("Y")));
									}
									if($joincheck['point'] > 0 ) {
										$point['type']				= $type;
										$point['point']				= $joincheck['point'];
										$point['gb']				= 'plus';
										$point['memo']				= $memo;
										$point['memo_lang']			= $memo_lang;
										$point['limit_date']		= $limit_date_point;
										$this->membermodel->point_insert($point, $params['member_seq']);
									}
								}else{
									$aldata['emoney_pay']='N';
								}
							}

							if($joincheck['check_SMS_yn']=='Y'){
								$this->_send_sms($joincheck['check_SMS'],$memberinfo['cellphone']);
							}

						}elseif($joincheck['check_clear_count'] <= $aldata['straight_cnt']){
							$aldata['clear_success'] = $jccheck['clear_success'];
							$aldata['emoney_pay'] = $jccheck['emoney_pay'];
						}else{
							$aldata['clear_success'] = 'N';
						}

					//달성 타입이 일반일때
					}else{//연속 횟수
						$aldata['count_cnt'] = $jccheck['count_cnt'] + 1;

						//목표달성여부체크
						if( ($joincheck['check_clear_count'] == $aldata['count_cnt']) ||  ($aldata['count_cnt']%$joincheck['check_clear_count']) == 0 ) {
							$aldata['clear_success'] = 'Y';
							$aldata['clear_suc_date'] = date('Y-m-d H:i:s');
							//목표 달성시 적립 지급
							if( ( $joincheck['check_clear_count'] == $aldata['count_cnt'] ) || 
								( $joincheck['check_clear_count'] < $aldata['count_cnt'] )
							)
							{
								/**
								$upsql = "update fm_member set emoney = emoney+".$joincheck['emoney']." where member_seq = ".$params['member_seq'];
								$upqry = $this->db->query($upsql);
								if($upqry){
								**/
								if( $joincheck['emoney'] > 0 || $joincheck['point'] > 0 ) { 
									$aldata['emoney_pay']='Y';
									$aldata['emoney_pay_date']=date('Y-m-d H:i:s');
									$aldata['emoney']=$joincheck['emoney'];

									$type				= 'joincheck';
									$memo				= '출석체크 이벤트';
									$memo_lang			= $this->membermodel->make_json_for_getAlert("mp283");    // 출석체크 이벤트
									
									### EMONEY
									$limit_date_emoney = "";
									if($joincheck['reserve_select']=='year'){
										$limit_date_emoney = date("Y-m-d", mktime(0,0,0,12, 31, date("Y")+$joincheck['reserve_year']));//$joincheck['reserve_year']."-12-31";
									}else if($joincheck['reserve_select']=='direct'){
										$limit_date_emoney = date("Y-m-d", mktime(0,0,0,date("m")+$joincheck['reserve_direct'], date("d"), date("Y")));
									}
									if($joincheck['emoney'] > 0 ) {
										$emoney['type']				= $type;
										$emoney['emoney']			= $joincheck['emoney'];
										$emoney['gb']				= 'plus';
										$emoney['memo']				= $memo;
										$emoney['memo_lang']		= $memo_lang;
										$emoney['limit_date']		= $limit_date_emoney;
										$this->membermodel->emoney_insert($emoney, $params['member_seq']);
									}

									### POINT
									$limit_date_point = "";
									if($joincheck['point_select']=='year'){
										$limit_date_point = date("Y-m-d", mktime(0,0,0,12, 31, date("Y")+$joincheck['point_year']));//$joincheck['point_year']."-12-31";
									}else if($joincheck['point_select']=='direct'){
										$limit_date_point = date("Y-m-d", mktime(0,0,0,date("m")+$joincheck['point_direct'], date("d"), date("Y")));
									}
									if($joincheck['point'] > 0 ) {
										$point['type']				= $type;
										$point['point']				= $joincheck['point'];
										$point['gb']				= 'plus';
										$point['memo']				= $memo;
										$point['memo_lang']			= $memo_lang;
										$point['limit_date']		= $limit_date_point;
										$this->membermodel->point_insert($point, $params['member_seq']);
									}
								}else{
									$aldata['emoney_pay']='N';
								}
							}

							if($joincheck['check_SMS_yn']=='Y'){
								$this->_send_sms($joincheck['check_SMS'],$memberinfo['cellphone']);
							}
						}elseif($joincheck['check_clear_count'] <= $aldata['count_cnt']){
							$aldata['clear_success'] = $jccheck['clear_success'];
							$aldata['emoney_pay'] = $jccheck['emoney_pay'];
						}else{
							$aldata['clear_success'] = 'N';
						}
					}

					$this->db->where('jcresult_seq',$jccheck['jcresult_seq']);
					$rcslt = $this->db->update('fm_joincheck_result', $aldata);

				//신규 결과값 생성
				}else{

					//연속출석에 따라서 결과값 다르게 저장
					if($clear_type=='straight'){

						$aldata['straight_cnt']=1;

						//목표달성여부체크
						if($joincheck['check_clear_count'] == $aldata['straight_cnt']){
							$aldata['clear_success'] = 'Y';
							$aldata['clear_suc_date'] = date('Y-m-d H:i:s');

							//목표 달성시 적립 지급
								/***
								$upsql = "update fm_member set emoney = emoney+".$joincheck['emoney']." where member_seq = ".$params['member_seq'];
								$upqry = $this->db->query($upsql);
								if($upqry){
								***/
								if( $joincheck['emoney'] > 0 || $joincheck['point'] > 0 ) { 
									$aldata['emoney_pay']='Y';
									$aldata['emoney_pay_date']=date('Y-m-d H:i:s');
									$aldata['emoney']=$joincheck['emoney'];
		
									$type				= 'joincheck';
									$memo				= '출석체크 이벤트';
									$memo_lang			= $this->membermodel->make_json_for_getAlert("mp283");    // 출석체크 이벤트
									
									### EMONEY
									$limit_date_emoney = "";
									if($joincheck['reserve_select']=='year'){
										$limit_date_emoney = date("Y-m-d", mktime(0,0,0,12, 31, date("Y")+$joincheck['reserve_year']));//$joincheck['reserve_year']."-12-31";
									}else if($joincheck['reserve_select']=='direct'){
										$limit_date_emoney = date("Y-m-d", mktime(0,0,0,date("m")+$joincheck['reserve_direct'], date("d"), date("Y")));
									}
									if($joincheck['emoney'] > 0 ) {
										$emoney['type']				= $type;
										$emoney['emoney']			= $joincheck['emoney'];
										$emoney['gb']				= 'plus';
										$emoney['memo']				= $memo;
										$emoney['memo_lang']		= $memo_lang;
										$emoney['limit_date']		= $limit_date_emoney;
										$this->membermodel->emoney_insert($emoney, $params['member_seq']);
									}
		
									### POINT
									$limit_date_point = "";
									if($joincheck['point_select']=='year'){
										$limit_date_point = date("Y-m-d", mktime(0,0,0,12, 31, date("Y")+$joincheck['point_year']));//$joincheck['point_year']."-12-31";
									}else if($joincheck['point_select']=='direct'){
										$limit_date_point = date("Y-m-d", mktime(0,0,0,date("m")+$joincheck['point_direct'], date("d"), date("Y")));
									}
									if($joincheck['point'] > 0 ) {
										$point['type']				= $type;
										$point['point']				= $joincheck['point'];
										$point['gb']				= 'plus';
										$point['memo']				= $memo;
										$point['memo_lang']			= $memo_lang;
										$point['limit_date']		= $limit_date_point;
										$this->membermodel->point_insert($point, $params['member_seq']);
									}
								}

							if($joincheck['check_SMS_yn']=='Y'){
								$this->_send_sms($joincheck['check_SMS'],$memberinfo['cellphone']);
							}

						}else{
							$aldata['clear_success'] = 'N';
						}

					}else{
						$aldata['count_cnt']=1;
						//목표달성여부체크
						if($joincheck['check_clear_count'] == $aldata['count_cnt']){
							$aldata['clear_success'] = 'Y';
							$aldata['clear_suc_date'] = date('Y-m-d H:i:s');

							//목표 달성시 적립 지급
								/**
								$upsql = "update fm_member set emoney = emoney+".$joincheck['emoney']." where member_seq = ".$params['member_seq'];
								$upqry = $this->db->query($upsql);
								if($upqry){
								**/
								if( $joincheck['emoney'] > 0 || $joincheck['point'] > 0 ){
									$aldata['emoney_pay']='Y';
									$aldata['emoney_pay_date']=date('Y-m-d H:i:s');
									$aldata['emoney']=$joincheck['emoney'];
		
									$type				= 'joincheck';
									$memo				= '출석체크 이벤트';
									$memo_lang			= $this->membermodel->make_json_for_getAlert("mp283"); // 출석체크 이벤트
									
									### EMONEY
									$limit_date_emoney = "";
									if($joincheck['reserve_select']=='year'){
										$limit_date_emoney = date("Y-m-d", mktime(0,0,0,12, 31, date("Y")+$joincheck['reserve_year']));//$joincheck['reserve_year']."-12-31";
									}else if($joincheck['reserve_select']=='direct'){
										$limit_date_emoney = date("Y-m-d", mktime(0,0,0,date("m")+$joincheck['reserve_direct'], date("d"), date("Y")));
									}
									if($joincheck['emoney'] > 0 ) {
										$emoney['type']				= $type;
										$emoney['emoney']			= $joincheck['emoney'];
										$emoney['gb']				= 'plus';
										$emoney['memo']				= $memo;
										$emoney['memo_lang']		= $memo_lang;
										$emoney['limit_date']		= $limit_date_emoney;
										$this->membermodel->emoney_insert($emoney, $params['member_seq']);
									}
		
									### POINT 
									$limit_date_point = "";
									if($joincheck['point_select']=='year'){
										$limit_date_point = date("Y-m-d", mktime(0,0,0,12, 31, date("Y")+$joincheck['point_year']));//$joincheck['point_year']."-12-31";
									}else if($joincheck['point_select']=='direct'){
										$limit_date_point = date("Y-m-d", mktime(0,0,0,date("m")+$joincheck['point_direct'], date("d"), date("Y")));
									}
									if($joincheck['point'] > 0 ) {
										$point['type']				= $type;
										$point['point']				= $joincheck['point'];
										$point['gb']				= 'plus';
										$point['memo']				= $memo;
										$point['memo_lang']			= $memo_lang;
										$point['limit_date']		= $limit_date_point;
										$this->membermodel->point_insert($point, $params['member_seq']);
									}
								}

							if($joincheck['check_SMS_yn']=='Y'){
								$this->_send_sms($joincheck['check_SMS'],$memberinfo['cellphone']);
							}

						}else{
							$aldata['clear_success'] = 'N';
						}
					}
					$rcslt = $this->db->insert('fm_joincheck_result', $aldata);
				}

				//등록한 댓글/스템프 저장
				$data = array(
				'member_seq' 		=> $params['member_seq'],
				'joincheck_seq'		=> $params['joincheck_seq'],
				'check_date'		=> $today,
				'check_comment'		=> $params['check_comment'],
				'regist_date'		=> date('Y-m-d H:i:s')
				);

				$result = $this->db->insert('fm_joincheck_list', $data);


				if($result){
					//달성전이고 참여 성공했을때
					if($aldata['clear_success'] == 'N'){
						return array(
							'code' => 'success',
							'msg' => $joincheck['check_it']
							);
					//달성 했을때
					}elseif($aldata['clear_success'] == 'Y' && ($emoney['emoney'] || $point['point']) ){
						
						$c_msg = str_replace("{emoney}",number_format($emoney['emoney']),$joincheck['check_complete']);
						$c_msg = str_replace("{point}",number_format($point['point']),$c_msg);

						return array(
							'code' => 'emoney_pay',
							'msg' => $c_msg
							);
					//달성치를 넘고 참여했을때
					}elseif($aldata['clear_success'] == 'Y' && $jccheck['emoney_pay']=='Y'){
						//로그인형일 때는 안보임
						if($joincheck['check_type'] != 'login'){
							return array(
							'code' => 'success',
							'msg' => $joincheck['check_it']
							);
						}
					}
				}else{
					return array(
						'code' => 'fail',
						'msg' => "작성이 실패하였습니다."
					);
				}

			//중복일 경우
			}else{
				return array(
					'code' => 'duplicate',
					'msg' => $joincheck['check_already']
				);
			}

		//진행 완료인 경우
		}elseif($state['status']=='end'){
			return array(
					'code' => 'end',
					'msg' => "종료된 이벤트입니다."
				);

		//진행 전인 경우
		}elseif ( $state['status']=='before'){
			return array(
					'code' => 'before',
					'msg' => "진행 전 이벤트 입니다."
				);

		//중지일 경우
		}elseif ($state['status']=='stop'){
			return array(
					'code' => 'stop',
					'msg' => "중지된 이벤트 입니다."
				);

		}
	}//joincheck

	function _send_sms($msg,$phone){
		require_once ROOTPATH."/app/libraries/sms.class.php";	
		$auth = config_load('master');
		$sms_id = $this->config_system['service']['sms_id'];
		$sms_api_key = $auth['sms_auth'];
		$gabiaSmsApi = new gabiaSmsApi($sms_id,$sms_api_key);	
		$gabiaSmsApi->sendSMS_Msg($msg,$phone);
	}

	public function get_joincheckout_result_count($joincheck_seq,$wheres=''){

		$this->db->select("COUNT(*) AS COUNT");
		$this->db->where(array('joincheck_seq'=>$joincheck_seq));
		if(is_array($wheres) && count($wheres) > 0) $this->db->where(implode(" AND ",$wheres));
		$query = $this->db->get("fm_joincheck_result")->row_array();
		$count	= $query['COUNT'];

		return $count;
	}

	public function get_joincheck_list($sc){
		
		$where = array();

		if($sc['keyword']) $sc['keyword'] = trim($sc['keyword']);

		// 검색어
		if( !empty($sc['keyword']) ){
			$where[] = "
				CONCAT(
					title
				) LIKE '%" . addslashes($sc['keyword']) . "%'
			";
		}

		// 일자검색
		if( $sc['date'] ){
			$date_field = $sc['date'];
			if($sc['sdate'] && $sc['edate']) $where[] = "date_format({$date_field},'%Y-%m-%d') between '{$sc['sdate']}' and '{$sc['edate']}'";
			else if($sc['sdate']) $where[] = "'{$sc['sdate']}' < date_format({$date_field},'%Y-%m-%d')";
			else if($sc['edate']) $where[] = "date_format({$date_field},'%Y-%m-%d') < '{$sc['edate']}'";
		}		
		
		// 이벤트진행상태
		if( !empty($sc['event_status']) ){
			switch($sc['event_status']){
				case "before":
					$where[] = "start_date > current_date()";
				break;
				case "ing":
					$where[] = "current_date() between start_date and end_date and check_state <> 'stop'";
				break;
				case "end":
					$where[] = "end_date < current_date()";
				break;
				case "stop":
					$where[] = "check_state = 'stop'";
				break;
			}
		}	
		
		// 출석체크 방법		
		if( !empty($sc['event_type']) ){
			$where[] = "check_type='".$sc['event_type']."'";
		}
		
		// 달성조건		
		if( !empty($sc['event_clear_type']) ){
			$where[] = "check_clear_type='".$sc['event_clear_type']."'";
		}
		
		// 삭제되지 않은것
		$arr		=array();
		$arr[]		= "del_state='N'";
		$where[]	= "(".implode(' and ', $arr).")";
	
		$sqlWhereClause = $where ? " AND ".implode(' AND ',$where) : "";

		$search_field = " *	,
							(select count(jcresult_seq)AS 'cnt' from fm_joincheck_result where joincheck_seq=evt.joincheck_seq) as sum_count,
							if(check_state = 'stop','중지',if(current_date() between start_date and end_date,'진행 중',if(end_date < current_date(),'진행완료','진행 전'))) as status";
	
		$limitStr =" LIMIT {$sc['page']}, {$sc['perpage']} ";

		$sql				= array();
		$sql['field']		= $search_field;
		$sql['table']		= "fm_joincheck as evt";
		$sql['wheres']		= implode(' AND ',$where);
		$sql['orderby']		= "ORDER BY joincheck_seq DESC";
		$sql['limit']		= $limitStr;

		$result				= pagingNumbering($sql,$sc);

		foreach($result['record'] as $key => $datarow){

			//$datarow['catename']	= $this->categorymodel->get_category_name($datarow['category_code']);
			$datarow['mcheck_state']		= $this->stateNames[$datarow['check_state']];
			$datarow['mcheck_type']			= $this->typeNames[$datarow['check_type']];			
			$datarow['mcheck_clear_type']	= $this->clear_typeNames[$datarow['check_clear_type']];
			
			//스킨별 팝업사이즈 지정
			if($datarow['check_type'] == 'comment')
			{$datarow['sz1']='680'; $datarow['sz2']='700';}
			else{$datarow['sz1']='545'; $datarow['sz2']='670';}
									
			//달성현황
			$datarow['sum_clear']	= $this->get_joincheckout_result_count($datarow['joincheck_seq'],array("clear_success='y'"));

			//마일리지 현황
			$datarow['sum_emoney']	= $this->get_joincheckout_result_count($datarow['joincheck_seq'],array("emoney_pay='y'"));

			$result['record'][$key] = $datarow;
		}

		return $result;

	}

	public function get_joincheck_memberlist($sc){

		$where = array();

		if(!empty($sc['keyword'])) $sc['keyword'] = trim($sc['keyword']);

		// 검색어
		if( $sc['keyword'] ){

			if($sc['serach_field']){
				$where[] = $sc['serach_field']. " LIKE '%" . addslashes($sc['keyword']) . "%'";
			}else{

				$where[] = "
					CONCAT(	mem.userid,mem.user_name) LIKE '%" . addslashes($sc['keyword']) . "%'
				";
			}
		}

		// 이벤트진행상태
		if( $sc['clear_success'] ){
			$arr = array();	
			foreach($sc['clear_success'] as $key => $data){
				switch($data){
				case "Y":
					$arr[] = "clear_success = 'Y'";
				break;
				case "N":
					$arr[] = "clear_success = 'N'";
				break;				
				}
			}								
			if($arr) $where[] = "(".implode(' OR ',$arr).")";
		}	
		
		// 마일리지 지급 여부
		if( $sc['emoney_pay'] ){
			$arr = array();
			foreach($sc['emoney_pay'] as $key => $data){
				
				switch($data){
					case "Y":
						$arr[] = "emoney_pay = 'Y'";
					break;
					case "N":
						$arr[] = "emoney_pay = 'N'";
					break;						
				}				
			}
			if($arr) $where[] = "(".implode(' OR ',$arr).")";
		}
		
		// 		
		if( $sc['joincheck_seq'] ){
			$arr = array();	
			$arr[] = "joincheck_seq = '".$sc['joincheck_seq']."'";					
			if($arr) $where[] = "(".implode(' OR ',$arr).")";		
			$countWheres[] = "joincheck_seq = '".$sc['joincheck_seq']."'";
		}		
	
		//이벤트 회원 진행 상황
		$search_field 		= "fjr.*,mem.userid,mem.user_name";
		$limitStr 			=" LIMIT {$sc['page']}, {$sc['perpage']} ";

		$sql				= array();
		$sql['field']		= $search_field;
		$sql['table']		= "fm_joincheck_result AS fjr LEFT JOIN fm_member AS mem ON mem.member_seq=fjr.member_seq";
		$sql['wheres']		= implode(' AND ',$where);
		$sql['countWheres']	= $countWheres;
		$sql['orderby']		= "ORDER BY fjr.jcresult_seq DESC";
		$sql['limit']		= $limitStr;

		$result				= pagingNumbering($sql,$sc);

		$rc 				= array();

		//달성현황
		$this->db->select("COUNT(*) AS sum_clear");
		$query 				= $this->db->get_where("fm_joincheck_result",array('joincheck_seq' => $sc['joincheck_seq'],'clear_success' => 'Y'));
		$suc_count 			= $query ->row_array();						
		$rc['sum_clear'] 	= $suc_count['sum_clear'];

		//마일리지 현황		
		$this->db->select("COUNT(*) AS sum_emoney");
		$query 				= $this->db->get_where("fm_joincheck_result",array('joincheck_seq' => $sc['joincheck_seq'],'emoney_pay' => 'Y'));
		$emny_count 		= $query ->row_array();
		$rc['sum_emoney'] 	= $emny_count['sum_emoney'];
		
		//이벤트 정보 가져오기
		$this->db->select("title, check_SMS, check_clear_count, check_clear_type");
		$query 				= $this->db->get_where("fm_joincheck",array('joincheck_seq' => $sc['joincheck_seq']));
		$jc_event 			= $query ->row_array();
		$rc 				= array_merge($rc,$jc_event);
		
		return array($result, $rc);
	}

	public function joincheckDateOverlapCheck($joincheck_seq, $sdate='', $edate='')
	{
		$this->db->select("COUNT(*) AS '0'");
		$this->db->where('start_date >=', $sdate);
		$this->db->where('end_date <=', $edate);
		$this->db->where('joincheck_seq !=', $joincheck_seq);
		return $this->db->get("fm_joincheck")->row_array();
	}

	public function get_joincheck_result($joincheck_seq){
	    $this->db->select("sum(1) as totalcount, sum(if(clear_success='Y', 1, 0)) as sum_clear, sum(if(emoney_pay='Y', 1, 0)) as sum_emoney");
	    $this->db->from('fm_joincheck_result');
	    $this->db->where('joincheck_seq', $joincheck_seq);
	    return $this->db->get();
	}

	public function get_joincheck($joincheck_seq){
	    $this->db->select("*, if(check_state = 'stop','중지',if(current_date() between start_date and end_date,'진행 중',if(end_date < current_date(),'진행완료','진행 전'))) as status");
	    $this->db->from('fm_joincheck');
	    $this->db->where('joincheck_seq', $joincheck_seq);
	    return $this->db->get();
	}
}

/* End of file joincheckmodel.php */
/* Location: ./app/models/joincheckmodel.php */